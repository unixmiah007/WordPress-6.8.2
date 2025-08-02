<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class StElementor_Import {
    private $whizzie_instance;
    private $import_delay = 500000; // 0.5 seconds delay between imports
    private $max_retries = 3;
    private $logger;

    public function __construct($whizzie_instance) {
        $this->whizzie_instance = $whizzie_instance;
        $this->logger = function($message) {
            error_log('[StElementor_Import] ' . $message);
        };
    }

    public function st_demo_importer_setup_elementor() {
        try {
            // Enable Elementor features
            $this->enable_elementor_features();
            
            // Get theme data and prepare pages for import
            $pages_arr = $this->prepare_pages_for_import();
            
            // Process default kit first
            $this->process_default_kit();
            
            // Call theme-specific setup if available
            $this->call_theme_setup_function();
            
            // Import all pages with proper error handling
            $this->import_all_pages($pages_arr);
            
            // Return success response
            wp_send_json([
                'success' => true,
                'permalink' => site_url(),
                'message' => 'Import completed successfully'
            ]);
            
        } catch (Exception $e) {
            $this->log_error('Import failed: ' . $e->getMessage());
            wp_send_json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function enable_elementor_features() {
        update_option('elementor_unfiltered_files_upload', '1');
        update_option('elementor_experiment-e_optimized_control_loading', 'active');
    }

    private function prepare_pages_for_import() {
        $st_themes = $this->whizzie_instance->get_st_themes();
        $arrayJson = [];
        
        if ($st_themes['status'] == 200 && !empty($st_themes['data'])) {
            foreach ($st_themes['data'] as $single_theme) {
                $arrayJson[$single_theme->theme_text_domain] = [
                    'title' => $single_theme->theme_page_title,
                    'url' => $single_theme->theme_json_url
                ];
            }
        }

        $my_theme_txd = wp_get_theme();
        $get_textdomain = $my_theme_txd->get('TextDomain');
        $pages_arr = [];

        if (array_key_exists($get_textdomain, $arrayJson)) {
            $getpreth = $arrayJson[$get_textdomain];
            $pages_arr[] = [
                'title' => $getpreth['title'],
                'ishome' => 1,
                'type' => '',
                'post_type' => 'page',
                'url' => $getpreth['url'],
            ];
            
            if (defined('IS_ST_PREMIUM') || defined('IS_ST_FREEMIUM')) {
                $this->add_premium_pages($pages_arr);
            }
        } else {
            $pages_arr[] = [
                'title' => 'Strivio Business',
                'type' => '',
                'ishome' => 1,
                'post_type' => 'page',
                'url' => STDI_THEMES_HOME_URL . "/demo/all-json/spectra-business/spectra-business.json",
            ];
        }

        return $pages_arr;
    }

    private function add_premium_pages(&$pages_arr) {
        $json_url = get_template_directory_uri() . '/inc/page.json';
        $response = wp_remote_get($json_url);
        
        if (is_wp_error($response) || $response['response']['code'] != 200) {
            $this->log_error('Failed to fetch premium pages JSON');
            return;
        }

        $inner_page_json = wp_remote_retrieve_body($response);
        $inner_page_json_decoded = json_decode($inner_page_json, true);

        if ($inner_page_json_decoded !== null) {
            foreach ($inner_page_json_decoded as $page) {
                $pages_arr[] = [
                    'type' => $page['type'] ?? '',
                    'title' => $page['name'],
                    'ishome' => 0,
                    'post_type' => $page['posttype'],
                    'url' => $page['source'],
                ];
            }
        }
    }

    private function process_default_kit() {
        $kit_found = false;
        $page_json_url = get_template_directory_uri() . '/inc/page.json';
        $response = wp_remote_get($page_json_url);
        
        if (!is_wp_error($response)) {
            $pages = json_decode(wp_remote_retrieve_body($response), true);
            
            if (is_array($pages)) {
                foreach ($pages as $page) {
                    if (!empty($page['type']) && $page['type'] === 'st-default-kit' && $page['posttype'] === 'elementor_library') {
                        $kit_found = $this->import_kit($page['source']);
                        if ($kit_found) break;
                    }
                }
            }
        }

        if (!$kit_found) {
            $this->create_all_existing_elementor_values();
        }
    }

    private function import_kit($kit_url) {
        $response = wp_remote_get($kit_url);
        if (is_wp_error($response)) return false;
        
        $kit_data = json_decode(wp_remote_retrieve_body($response), true);
        if (empty($kit_data['settings'])) return false;

        $post_id = wp_insert_post([
            'post_title'    => 'St Elementor Kit',
            'post_status'   => 'publish',
            'post_type'     => 'elementor_library',
        ]);

        if (!$post_id) return false;

        update_post_meta($post_id, '_elementor_template_type', 'kit');
        update_post_meta($post_id, '_wp_page_template', 'default');
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        update_post_meta($post_id, '_elementor_page_settings', $kit_data['settings']);
        update_post_meta($post_id, '_elementor_data', []);

        update_option('elementor_active_kit', $post_id);
        return true;
    }

    private function call_theme_setup_function() {
        $my_theme_txd = wp_get_theme();
        $get_textdomain = $my_theme_txd->get('TextDomain');
        $setup_widgets_function = str_replace('-', '_', $get_textdomain) . '_demo_import';
        
        if (class_exists('ST_Theme_Whizzie') && method_exists('ST_Theme_Whizzie', $setup_widgets_function)) {
            ST_Theme_Whizzie::$setup_widgets_function();
        }
    }

    private function import_all_pages($pages_arr) {
        $home_id = null;
        
        foreach ($pages_arr as $page) {
            for ($retry = 0; $retry < $this->max_retries; $retry++) {
                try {
                    $imported_id = $this->import_single_page(
                        $page['url'],
                        $page['title'],
                        $page['ishome'],
                        $page['post_type'],
                        $page['type'] ?? ''
                    );
                    
                    if ($page['ishome']) {
                        $home_id = $imported_id;
                    }
                    
                    // Success - break retry loop
                    break;
                    
                } catch (Exception $e) {
                    $this->log_error(sprintf(
                        'Attempt %d/%d failed for %s: %s',
                        $retry + 1,
                        $this->max_retries,
                        $page['title'],
                        $e->getMessage()
                    ));
                    
                    if ($retry === $this->max_retries - 1) {
                        throw $e; // Re-throw if last attempt
                    }
                    
                    usleep($this->import_delay * ($retry + 1));
                }
            }
            
            usleep($this->import_delay);
        }
        
        return $home_id;
    }

    private function import_single_page($url, $title, $is_home, $post_type, $type) {
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            throw new Exception("Failed to fetch page data from {$url}");
        }
        
        $json_data = wp_remote_retrieve_body($response);
        if (empty($json_data)) {
            throw new Exception("Empty response from {$url}");
        }
        
        $upload_dir = wp_upload_dir();
        $filename = $this->random_string(25) . '.json';
        $file_path = trailingslashit($upload_dir['path']) . $filename;
        
        if (!function_exists('WP_Filesystem')) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
        }
        
        WP_Filesystem();
        global $wp_filesystem;
        
        if (!$wp_filesystem || !$wp_filesystem->put_contents($file_path, $json_data, FS_CHMOD_FILE)) {
            throw new Exception("Failed to save temporary import file");
        }
        
        $file_url = $upload_dir['url'] . '/' . $filename;
        $elementor_data = $this->get_elementor_theme_data($file_url, $file_path);
        
        $page_data = [
            'post_type' => $post_type,
            'post_title' => $title,
            'post_content' => $elementor_data['elementor_content'],
            'post_status' => 'publish',
            'post_author' => 1,
            'meta_input' => $elementor_data['elementor_content_meta']
        ];
        
        $post_id = wp_insert_post($page_data);
        if (!$post_id || is_wp_error($post_id)) {
            throw new Exception("Failed to create post for {$title}");
        }
        
        $this->handle_special_page_types($post_id, $post_type, $type, $is_home);
        return $post_id;
    }

    private function handle_special_page_types($post_id, $post_type, $type, $is_home) {
        if ($post_type === 'stea-theme-template') {
            if($type == 'type_header' || $type == 'type_footer' ) {
                $array_location = [
                    'rule' => ['basic-global'],
                    'specific' => []
                ];
                $template_type = $type;
                update_post_meta($post_id, 'stea_theme_builder_sticky', 'enable');
            }else{
                $array_location = [
                    'rule' => [$type],
                    'specific' => []
                ];
                $template_type = ($type === 'special-woo-shop' || strpos($type, 'archive') !== false) 
                    ? 'type_archive' 
                    : 'type_singular';
            }
            
            
            update_post_meta($post_id, 'stea_theme_builder_target_include_locations', $array_location);
            update_post_meta($post_id, 'stea_theme_builder_template_type', $template_type);
        }
        
        // Handle ElementsKit templates
        if ($post_type === 'elementskit_template') {
            update_post_meta($post_id, '_wp_page_template', 'elementor_canvas');
            update_post_meta($post_id, 'elementskit_template_activation', 'yes');
            update_post_meta($post_id, 'elementskit_template_type', $type);
            update_post_meta($post_id, 'elementskit_template_condition_a', 'entire_site');
        }
        
        // Handle home page settings
        if ($is_home) {
            update_option('page_on_front', $post_id);
            update_option('show_on_front', 'page'); // Always set to 'page' for front page displays
            
            $my_theme_txd = wp_get_theme();
            $get_textdomain = $my_theme_txd->get('TextDomain');
            
            // Special handling for KristynaBennett themes
            if ($my_theme_txd->get('Author') === 'KristynaBennett') {
                update_post_meta($post_id, '_wp_page_template', 'frontpage.php');
            }
            // Special handling for SEDI free themes
            elseif ($this->is_sedi_free_theme($get_textdomain)) {
                update_post_meta($post_id, '_wp_page_template', 'home-page-template.php');
            }
        }
    }

    private function is_sedi_free_theme($textdomain) {
        $api_url = STDI_ADMIN_CUSTOM_ENDPOINT . 'get_theme_text_domain_data';
        $response = wp_remote_get($api_url, ['headers' => ['Content-Type' => 'application/json']]);
        
        if (is_wp_error($response)) return false;
        
        $json = json_decode($response['body']);
        if ($json->code != 200) return false;
        
        $sedi_free_text_domains = array_map(function($value) {
            return $value->theme_text_domain;
        }, $json->data);
        
        return in_array($textdomain, $sedi_free_text_domains);
    }

    public function get_elementor_theme_data($json_url, $json_path) {
    
        // Mime a supported document type.
        $elementor_plugin = \Elementor\Plugin::$instance;
        $elementor_plugin->documents->register_document_type('not-supported', \Elementor\Modules\Library\Documents\Page::get_class_full_name());
        $template = $json_path;
        $name = '';
        $_FILES['file']['tmp_name'] = $template;
        $elementor = new \Elementor\TemplateLibrary\Source_Local;
        $elementor->import_template($name, $template);
        wp_delete_file($json_path);

        $args = array('post_type' => 'elementor_library','nopaging' => true,'posts_per_page' => '1','orderby' => 'date','order' => 'DESC');
        add_filter('posts_where', array($this, 'custom_posts_where'));
        $query = new \WP_Query($args);
        remove_filter('posts_where', array($this, 'custom_posts_where'));
    
        $last_template_added = $query->posts[0];
        //get template id
        $template_id = $last_template_added->ID;
        wp_reset_query();
        wp_reset_postdata();
        //page content
        $page_content = $last_template_added->post_content;
        //meta fields
        $elementor_data_meta = get_post_meta($template_id, '_elementor_data');
        $elementor_ver_meta = get_post_meta($template_id, '_elementor_version');
        $elementor_edit_mode_meta = get_post_meta($template_id, '_elementor_edit_mode');
        $elementor_css_meta = get_post_meta($template_id, '_elementor_css');
        $elementor_metas = array('_elementor_data' => !empty($elementor_data_meta[0]) ? wp_slash($elementor_data_meta[0]) : '', '_elementor_version' => !empty($elementor_ver_meta[0]) ? $elementor_ver_meta[0] : '', '_elementor_edit_mode' => !empty($elementor_edit_mode_meta[0]) ? $elementor_edit_mode_meta[0] : '', '_elementor_css' => $elementor_css_meta,);
        $elementor_json = array('elementor_content' => $page_content, 'elementor_content_meta' => $elementor_metas);
        return $elementor_json;
    }
    public function custom_posts_where($where) {
        return $where;
    }
    public function create_all_existing_elementor_values() {

        update_option('elementor_unfiltered_files_upload', '1');
        update_option('elementor_experiment-e_optimized_control_loading', 'active');
        
        // getting color from theme start //
        if (file_exists(get_template_directory() . '/inc/json/color.json')) {
            
            $color_json = get_template_directory_uri() . '/inc/json/color.json';
            $response = wp_remote_get($color_json);
            $color_arr = array();
            
            if (!is_wp_error($response) && $response['response']['code'] == 200) {
                $color_setting_json = wp_remote_retrieve_body($response);
                $color_setting_json_decoded = json_decode($color_setting_json, true);
                
                if ($color_setting_json_decoded !== null) {
                    foreach ($color_setting_json_decoded as $color) {
                            array_push($color_arr, array(
                                '_id' => isset($color['_id']) ? $color['_id'] : 'st_default',
                                'title' => isset($color['title']) ? $color['title'] : 'ST Default',
                                'color' => isset($color['color']) ? $color['color'] : '#ffff',
                            ));
                        }
                    } 
                }
            } else {
                $color_arr[] = array(
                    '_id' => 'st_default',
                    'title' => 'ST Default',
                    'color' => '#ffff'
                );
            }
        // getting color from theme end //

        // getting typography from theme start //
        if (file_exists(get_template_directory() . '/inc/json/typography.json')) {
            $typography_json = get_template_directory_uri() . '/inc/json/typography.json';
            $response = wp_remote_get($typography_json);
            $typography_arr = array();
            
            if (!is_wp_error($response) && $response['response']['code'] == 200) {
                $typography_setting_json = wp_remote_retrieve_body($response);
                $typography_setting_json_decoded = json_decode($typography_setting_json, true);
                
                if ($typography_setting_json_decoded !== null) {
                    foreach ($typography_setting_json_decoded as $typography) {
                        // Base typography structure
                        $typography_item = array(
                            '_id' => isset($typography['_id']) ? $typography['_id'] : 'st_default',
                            'title' => isset($typography['title']) ? $typography['title'] : 'ST Default',
                            'typography_typography' => isset($typography['typography_typography']) ? $typography['typography_typography'] : 'custom',
                            'typography_font_family' => isset($typography['typography_font_family']) ? $typography['typography_font_family'] : 'Montserrat',
                            'typography_font_weight' => isset($typography['typography_font_weight']) ? $typography['typography_font_weight'] : '500',
                        );
        
                        // Responsive font sizes
                        $responsive_sizes = array(
                            'typography_font_size',
                            'typography_font_size_widescreen',
                            'typography_font_size_laptop',
                            'typography_font_size_tablet',
                            'typography_font_size_mobile_extra',
                            'typography_font_size_mobile',
                        );
        
                        foreach ($responsive_sizes as $key) {
                            if (isset($typography[$key])) {
                                $typography_item[$key] = $typography[$key];
                            }
                        }
        
                        // Responsive line heights
                        $responsive_line_heights = array(
                            'typography_line_height',
                            'typography_line_height_widescreen',
                            'typography_line_height_laptop',
                            'typography_line_height_tablet',
                            'typography_line_height_mobile_extra',
                            'typography_line_height_mobile',
                        );
        
                        foreach ($responsive_line_heights as $key) {
                            if (isset($typography[$key])) {
                                $typography_item[$key] = $typography[$key];
                            }
                        }
        
                        array_push($typography_arr, $typography_item);
                    }
                }
            }
        } else {
            // Default fallback if the file is missing
            $typography_arr[] = array(
                '_id' => 'st_default',
                'title' => 'ST Default',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Montserrat',
                'typography_font_weight' => '500',
            );
        }
        
        // getting typography from theme end //
      
        $elementor_kit_id = get_option('elementor_active_kit');
            
        if (!get_post_meta($elementor_kit_id, '_elementor_page_settings', true)) {
            // Define the entire array with the desired values
         
            $system_colors = array(
                'system_colors' => array(
                    array(
                        '_id' => 'primary',
                        'title' => 'Primary',
                        'color' => '#6EC1E4'
                    ),
                    array(
                        '_id' => 'secondary',
                        'title' => 'Secondary',
                        'color' => '#54595F'
                    ),
                    array(
                        '_id' => 'text',
                        'title' => 'Text',
                        'color' => '#7A7A7A'
                    ),
                    array(
                        '_id' => 'accent',
                        'title' => 'Accent',
                        'color' => '#61CE70'
                    )
                ),
                'custom_colors' => array(),
                'system_typography' => array(
                    array(
                        '_id' => 'primary',
                        'title' => 'Primary',
                        'typography_typography' => 'custom',
                        'typography_font_family' => 'Roboto',
                        'typography_font_weight' => 600
                    ),
                    array(
                        '_id' => 'secondary',
                        'title' => 'Secondary',
                        'typography_typography' => 'custom',
                        'typography_font_family' => 'Roboto Slab',
                        'typography_font_weight' => 400
                    ),
                    array(
                        '_id' => 'text',
                        'title' => 'Text',
                        'typography_typography' => 'custom',
                        'typography_font_family' => 'Roboto',
                        'typography_font_weight' => 400
                    ),
                    array(
                        '_id' => 'accent',
                        'title' => 'Accent',
                        'typography_typography' => 'custom',
                        'typography_font_family' => 'Roboto',
                        'typography_font_weight' => 500
                    )
                ),
                'custom_typography' => array(),
                'default_generic_fonts' => 'Sans-serif',
                'site_name' => 'wp1',
                'page_title_selector' => 'h1.entry-title',
                'active_breakpoints' => array(
                    'viewport_mobile',
                    'viewport_mobile_extra',
                    'viewport_tablet',
                    'viewport_tablet_extra',
                    'viewport_laptop',
                    'viewport_widescreen'
                ),
                'viewport_md' => 768,
                'viewport_lg' => 1025,
                'colors_enable_styleguide_preview' => 'yes',
                'viewport_lg' => 1
            );
           
            $system_colors['custom_typography'] = array_merge($system_colors['custom_typography'], $typography_arr);
            $system_colors['custom_colors'] = array_merge($system_colors['custom_colors'], $color_arr);

            // Save the entire array as post meta
            update_post_meta($elementor_kit_id, '_elementor_page_settings', $system_colors);
        } else {
            // add color start //
            $elementor_kit_id = get_option('elementor_active_kit');
            $get_all_existing_elementor_values = get_post_meta($elementor_kit_id, '_elementor_page_settings', true);
            
            $expected_custom_colors = $color_arr;
                function add_missing_custom_colors(&$existing_array, $expected_array, $key) {
                    if (!isset($existing_array[$key]) || !is_array($existing_array[$key])) {
                    $existing_array[$key] = $expected_array;
                } else {
                    $existing_values = $existing_array[$key];
                    $missing_items = array_udiff($expected_array, $existing_values, function($a, $b) {
                    return $a['_id'] <=> $b['_id'];
                });
                    $existing_array[$key] = array_merge($existing_values, $missing_items);
                }
        
            }
        
            add_missing_custom_colors($get_all_existing_elementor_values, $expected_custom_colors, 'custom_colors');
            update_post_meta($elementor_kit_id, '_elementor_page_settings', $get_all_existing_elementor_values);
            // add color end //
            
            // add typography start //
            $expected_custom_typography = $typography_arr;

            function add_missing_custom_typography(&$existing_array, $expected_array, $key) {
                if (!isset($existing_array[$key]) || !is_array($existing_array[$key])) {
                    $existing_array[$key] = $expected_array;
                } else {
                    $existing_values = $existing_array[$key];
                    $missing_items = array_udiff($expected_array, $existing_values, function($a, $b) {
                        return $a['_id'] <=> $b['_id'];
                    });
                    $existing_array[$key] = array_merge($existing_values, $missing_items);
                }
            }
            
            add_missing_custom_typography($get_all_existing_elementor_values, $expected_custom_typography, 'custom_typography');
            update_post_meta($elementor_kit_id, '_elementor_page_settings', $get_all_existing_elementor_values);
            // add typography end //
            
            // add breakpoints end //
            $expected_breakpoints = array(
                'viewport_mobile',
                'viewport_mobile_extra',
                'viewport_tablet',
                'viewport_tablet_extra',
                'viewport_laptop',
                'viewport_widescreen'
            );
            
            if (isset($get_all_existing_elementor_values['active_breakpoints']) && is_array($get_all_existing_elementor_values['active_breakpoints'])) {
                $active_breakpoints = $get_all_existing_elementor_values['active_breakpoints'];
                $missing_breakpoints = array_diff($expected_breakpoints, $active_breakpoints);
            
                if (!empty($missing_breakpoints)) {
                    $updated_breakpoints = array_merge($active_breakpoints, $missing_breakpoints);
                    $get_all_existing_elementor_values['active_breakpoints'] = $updated_breakpoints;
                    update_post_meta($elementor_kit_id, '_elementor_page_settings', $get_all_existing_elementor_values);
                }
            } else {
                $get_all_existing_elementor_values['active_breakpoints'] = $expected_breakpoints;
            
                update_post_meta($elementor_kit_id, '_elementor_page_settings', $get_all_existing_elementor_values);
            }
            // add breakpoints end //
        
        }
               
        // adding elementor kit settings end
    }
    public function random_string($length) {
        
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0;$i < $length;$i++) {
            $key.= $keys[array_rand($keys) ];
        }
        return $key;
    }
    
    private function log_error($message) {
        call_user_func($this->logger, $message);
    }
}