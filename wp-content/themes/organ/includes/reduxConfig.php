<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config
    {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }


        public function initSettings()
        {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
           

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
         

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**
         * This is a test function that will let you see when the compiler hook occurs.
         * It only runs if a field    set with compiler=>true is changed.
         * */
        function compiler_action($options, $css, $changed_values)
        {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
       
        }

        /**
         * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
         * Simply include this function in the child themes functions.php file.
         * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
         * so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections)
        {
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'organ'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'organ'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args)
        {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults)
        {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        public function setSections()
        {

            /**
             * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'organ'), $this->theme->display('Name'));

            ?>
            <div id="current-theme" class="<?php echo esc_html($class); ?>">
                <?php if ($screenshot) : ?>
                    <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize"
                           title="<?php echo esc_html($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>"
                                 alt="<?php esc_attr_e('Current theme preview', 'organ'); ?>"/>
                        </a>
                    <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>"
                         alt="<?php esc_attr_e('Current theme preview', 'organ'); ?>"/>
                <?php endif; ?>

                <h4><?php echo esc_html($this->theme->display('Name')); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'organ'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'organ'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'organ') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_html($this->theme->display('Description')); ?></p>
                    <?php
                    if ($this->theme->parent()) {
                        printf(' <p class="howto">' . esc_html__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'organ') . '</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'organ'), $this->theme->parent()->display('Name'));
                    }
                    ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();

                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }


             global $woocommerce;
               $cat_arg=array();
               $cat_data='';
                if(class_exists('WooCommerce')) {
                   
                     $cat_data='terms';
                    $cat_arg=array('taxonomies'=>'product_cat', 'args'=>array());
                }

            // ACTUAL DECLARATION OF SECTIONS
            // Edgesettings: Home Page Settings Tab
            $this->sections[] = array(
                'title' => esc_html__('Home Settings', 'organ'),
                'desc' => esc_html__('Home page settings ', 'organ'),
                'icon' => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(   

                    array(
                        'id' => 'theme_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Theme Variation', 'organ'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'organ'),
                        'options' => array(
                            'default' => array(
                                'title' => esc_html__('Default', 'organ'),
                                'alt' => esc_html__('Default', 'organ'),
                                'img' => get_template_directory_uri() . '/images/variations/screen1.jpg'
                            ),
                            'version2' => array(
                                'title' => esc_html__('Version2', 'organ'),
                                'alt' => esc_html__('Version 2', 'organ'),
                                'img' => get_template_directory_uri() . '/images/variations/screen2.jpg'
                            ),
                                                    
                           
                        ),
                        'default' => 'default'
                    ), 
                    array(
                        'id' => 'enable_welcome_msg',
                        'type' => 'switch',
                        'required' => array('theme_layout', '=', 'version2'),
                        'title' => esc_html__('Enable welcome message', 'organ'),
                        'subtitle' => esc_html__('You can enable/disable welcome message', 'organ')
                    ), 
                    array(
                        'id' => 'welcome_msg',
                        'type' => 'text',
                        'required' => array('enable_welcome_msg', '=', '1'),
                        'title' => esc_html__('Enter your welcome message here', 'organ'),
                        'subtitle' => esc_html__('Enter your welcome message here.', 'organ'),
                        'desc' => esc_html__('', 'organ'),                       
                    
                    ),             
                                  
                    array(
                        'id' => 'enable_home_gallery',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Home Page Gallery', 'organ'),
                        'subtitle' => esc_html__('You can enable/disable Home page Gallery', 'organ')
                    ),

                    array(
                        'id' => 'home-page-slider',
                        'type' => 'slides',
                        'title' => esc_html__('Home Slider Uploads', 'organ'),
                        'required' => array('enable_home_gallery', '=', '1'),
                        'subtitle' => esc_html__('Unlimited slide uploads with drag and drop sortings.', 'organ'),
                        'placeholder' => array(
                            'title' => esc_html__('This is a title', 'organ'),
                            'description' => esc_html__('Description Here', 'organ'),
                            'url' => esc_html__('Give us a link!', 'organ'),
                        ),
                    ),
                      
                        array(
                     'id'=>'topslide',
                     'type' => 'multi_text',
                     'required' => array(array('theme_layout', '=', 'default')),
                     'title' => esc_html__('Top slides', 'organ'),                     
                     'subtitle' => esc_html__('Add content for top offer slides', 'organ'),
                     'desc' => esc_html__('Add content for top offer slides', 'organ')
                      ),                
            

                        
                  
                    array(
                        'id' => 'enable_home_offer_banners',
                        'type' => 'switch',              
                        'title' => __('Enable Home Page Offer Banners', 'organ'),
                        'subtitle' => __('You can enable/disable Home page offer Banners', 'organ')
                    ),
                    array(
                        'id' => 'home-offer-banner1',
                        'type' => 'media',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner 1', 'organ'),
                        'desc' => __('', 'organ'),
                        'subtitle' => __('Upload offer banner to appear on  home page ', 'organ'),                                    
                    ),   
                    array(
                        'id' => 'home-offer-banner1-url',
                        'type' => 'text',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner-1 URL', 'organ'),
                        'subtitle' => __('URL for the offer banner.', 'organ'),
                    ),                     
                    array(
                        'id' => 'home-offer-banner2',
                        'type' => 'media',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner 2', 'organ'),
                        'desc' => __('', 'organ'),
                        'subtitle' => __('Upload offer banner to appear on  home page ', 'organ')
                    ),
                    array(
                        'id' => 'home-offer-banner2-url',
                        'type' => 'text',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner-2 URL', 'organ'),
                        'subtitle' => __('URL for the offer banner.', 'organ'),
                    ),                       
                    array(
                        'id' => 'home-offer-banner3',
                        'type' => 'media',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner 3', 'organ'),
                        'desc' => __('', 'organ'),
                        'subtitle' => __('Upload offer banner to appear on  home page ', 'organ')
                    ),
                    array(
                        'id' => 'home-offer-banner3-url',
                        'type' => 'text',
                        'required' => array('enable_home_offer_banners', '=', '1'),
                        'title' => __('Home offer Banner-3 URL', 'organ'),
                        'subtitle' => __('URL for the offer banner.', 'organ'),
                    ),                          
                                      
                    array(
                       'id'=>'home-product-categories',
                        'type' => 'select',
                        'data' => $cat_data,   
                        'required' => array(array('theme_layout', '=', 'default')),                         
                        'args' => $cat_arg,         
                        'title' => __('Product Categories ', 'organ'), 
                     'subtitle' => __('Please choose a product categories to show on home.', 'organ'),                       
                    ),
                    array(
                    'id'=>'home-product-categories-limit',
                     'type' => 'text',                                             
                     'required' => array(array('theme_layout', '=', 'default')),           
                     'title' => __('Product Categories - Limit', 'organ'), 
                     'subtitle' => __('Number of products show from  category.', 'organ'),                           
                    ),

                        
                    array(
                        'id' => 'enable_home_bestseller_products',
                        'type' => 'switch',
                        'title' => esc_html__('Show Best Seller Products', 'organ'),
                        'subtitle' => esc_html__('You can show best seller products on home page.', 'organ')
                    ),

                   array(
                            'id'=>'home_bestseller_categories',
                            'type' => 'select',
                            'multi'=> true,                        
                            'data' => $cat_data,                            
                            'args' => $cat_arg,
                            'title' => esc_html__('Best Seller Category', 'organ'), 
                            'required' => array('enable_home_bestseller_products', '=', '1'),
                            'subtitle' => esc_html__('Please choose Best Seller Category to show  its product in home page.', 'organ'),
                            'desc' => '',
                        ),
                   array(
                        'id' => 'bestseller_per_page',
                        'type' => 'text',
                        'required' => array(array('enable_home_bestseller_products', '=', '1')),
                        'title' => esc_html__('Number of bestseller Products', 'organ'),
                        'subtitle' => esc_html__('Number of bestseller products on home page.', 'organ')
                    ),

                       array(
                            'id' => 'bestseller_image',
                            'type' => 'media',
                            'required' => array(array('enable_home_bestseller_products', '=', '1'), array('theme_layout', '=', 'default')),
                            'title' => esc_html__('Home bestseller image', 'organ'),
                            'desc' => esc_html__('', 'organ'),
                            'subtitle' => esc_html__('Upload bestseller image appear to the left of best seller on  home page ', 'organ')
                    ),
                      array(
                        'id' => 'bestseller_product_url',
                        'type' => 'text',
                        'required' => array(array('enable_home_bestseller_products', '=', '1'), array('theme_layout', '=', 'default')),
                        'title' => esc_html__('Home Best seller   Url', 'organ'),
                        'subtitle' => esc_html__('Home Best seller  Url.', 'organ'),
                    ),
                 
                    array(
                        'id' => 'enable_home_recommended_products',
                        'type' => 'switch',
                        'required' => array('theme_layout', '=', 'version2'),
                        'title' => esc_html__('Show recommeded Products', 'organ'),
                        'subtitle' => esc_html__('You can show Show recommeded Products on home page.', 'organ')
                    ),   

                    array(
                        'id' => 'recommended_products_per_page',
                        'type' => 'text',
                        'required' => array(array('enable_home_recommended_products', '=', '1'),array('theme_layout', '=', 'version2')),
                        'title' => esc_html__('Number of recommeded Products', 'organ'),
                        'subtitle' => esc_html__('Number of recommeded products on home page.', 'organ')
                    ),

                    array(
                        'id' => 'enable_home_new_products',
                        'type' => 'switch',
                        'required' => array('theme_layout', '=', 'version2'),
                        'title' => esc_html__('Show New Products', 'organ'),
                        'subtitle' => esc_html__('You can show Show New Products on home page.', 'organ')
                    ),   

                    array(
                        'id' => 'new_products_per_page',
                        'type' => 'text',
                        'required' => array(array('enable_home_new_products', '=', '1'),array('theme_layout', '=', 'version2')),
                        'title' => esc_html__('Number of New Products', 'organ'),
                        'subtitle' => esc_html__('Number of New products on home page.', 'organ')
                    ),
                    
                    array(
                        'id' => 'enable_home_featured_products',
                        'required' => array('theme_layout', '=', 'version2'),
                        'type' => 'switch',
                        'title' => esc_html__('Show Featured Products', 'organ'),
                        'subtitle' => esc_html__('You can show featured products on home page.', 'organ')
                    ),
                         
                               
                    array(
                        'id' => 'featured_per_page',
                        'type' => 'text',
                        'required' => array(array('enable_home_featured_products', '=', '1'),array('theme_layout', '=', 'version2')),
                        'title' => esc_html__('Number of Featured Products', 'organ'),
                        'subtitle' => esc_html__('Number of Featured products on home page.', 'organ')
                    ),

           
                                              

                 array(
                        'id' => 'enable_home_blog_posts',
                        'type' => 'switch',
                        'title' => esc_html__('Show Latest Post', 'organ'),
                        'subtitle' => esc_html__('You can show latest blog post on home page.', 'organ')
                    ),

                ), // fields array ends
            );


            
            // Edgesettings: General Settings Tab
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => esc_html__('General Settings', 'organ'),
                'fields' => array(
                    array(
                        'id'       => 'enable_brand_logo',
                        'type'     => 'switch',                    
                        'title'    => __( 'Enable Company Logo Uploads', 'organ' ),
                        'subtitle' => __( 'You can enable/disable Company Logo Uploads', 'organ' ),
                          'default' => '0'
                    ),                   
                    array(
                        'id' => 'all-company-logos',
                        'type' => 'slides',
                        'title' => __('Company Logo Uploads', 'organ'),
                        'subtitle' => __('Unlimited Logo uploads with drag and drop sortings.', 'organ'),
                        'placeholder' => array(
                            'title' => __('This is a title', 'organ'),
                            'description' => __('Description Here', 'organ'),
                            'url' => __('Give us a link!', 'organ'),
                        ),
                    ),
                                                                                                                   
                     array(
                     'id'       => 'category_item',
                     'type'     => 'spinner', 
                     'title'    => esc_html__('Product display in product category page', 'organ'),
                     'subtitle' => esc_html__('Number of item display in product category page','organ'),
                     'desc'     => esc_html__('Number of item display in product category page', 'organ'),
                     'default'  => '9',
                     'min'      => '0',
                     'step'     => '1',
                     'max'      => '100',
                     ),

                      array(
                        'id'       => 'enable_testimonial',
                        'type'     => 'switch',                    
                        'required' => array(array('theme_layout', '=', 'default')),
                        'title'    => esc_html__( 'Enable Testimonial ', 'organ' ),
                        'subtitle' => esc_html__( 'You can enable/disable Testimonial Uploads', 'organ' ),
                          'default' => '0'
                    ),                   
                    array(
                        'id' => 'all_testimonial',
                        'type' => 'slides',
                        'required' => array('enable_testimonial', '=', '1'),
                        'title' => esc_html__('Add Testimonial here', 'organ'),
                        'subtitle' => esc_html__('Unlimited testimonial.', 'organ'),
                        'placeholder' => array(
                            'title' => esc_html__('This is a title', 'organ'),
                            'description' => esc_html__('Description Here', 'organ'),
                            'url' => esc_html__('Give us a link!', 'organ'),
                        ),
                        ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Back To Top Button', 'organ'),
                        'subtitle' => esc_html__('Toggle whether or not to enable a back to top button on your pages.', 'organ'),
                        'default' => true,
                    ),

                    /*array(
                        'id'       => 'enable_footer_middle',
                        'type'     => 'switch',                    
                        'title'    => esc_html__( 'Enable Footer middle section', 'organ' ),
                        'subtitle' => esc_html__( 'You can Footer middle section', 'organ' ),
                          'default' => '0'
                    ),
                    array(
                        'id' => 'footer-text',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Text', 'organ'), 
                        'required' => array('enable_footer_middle', '=', '1'),                     
                       'subtitle' => esc_html__('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'organ'),
                        'default' => '',
                    ),*/
                )
            );
            // Edgesettings: General Options -> Styling Options Settings Tab
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => esc_html__('Styling Options', 'organ'),
               
                'fields' => array(
                        array(
                        'id' => 'opt-animation',
                        'type' => 'switch',
                        'title' => esc_html__('Use animation effect', 'organ'),
                        'subtitle' => esc_html__('', 'organ'),
                        'default' => 0,
                        'on' => 'On',
                        'off' => 'Off',
					),     
                    array(
                        'id' => 'set_body_background_img_color',
                        'type' => 'switch',
                        'title' => esc_html__('Set Body Background', 'organ'),
                        'subtitle' => esc_html__('', 'organ'),
                        'default' => 0,
                        'on' => 'On',
                        'off' => 'Off',
                    ),
                    array(
                        'id' => 'opt-background',
                        'type' => 'background',
                        'required' => array('set_body_background_img_color', '=', '1'),
                        'output' => array('body'),
                        'title' => esc_html__('Body Background', 'organ'),
                        'subtitle' => esc_html__('Body background with image, color, etc.', 'organ'),               
                        'transparent' => false,
                    ),                   
                    array(
                        'id' => 'opt-color-footer',
                        'type' => 'color',
                        'title' => esc_html__('Footer Background Color', 'organ'),
                        'subtitle' => esc_html__('Pick a background color for the footer.', 'organ'),
                        'validate' => 'color',
                        'transparent' => false,
                        'mode' => 'background',
                        'output' => array('.footer')
                    ),
                    array(
                        'id' => 'opt-color-rgba',
                        'type' => 'color',
                        'title' => esc_html__('Header Nav Menu Background', 'organ'),
                        'output' => array('.tm-main-menu'),
                        'mode' => 'background',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'opt-color-header',
                        'type' => 'color',
                        'title' => esc_html__('Header Background', 'organ'),
                        'transparent' => false,
                        'output' => array('.header-container'),
                        'mode' => 'background',
                    ),                   
                )
            );


            // Edgesettings: Header Tab
            $this->sections[] = array(
                'icon' => 'el-icon-file-alt',
                'title' => esc_html__('Header', 'organ'),
                'heading' => esc_html__('All header related options are listed here.', 'organ'),
                'desc' => esc_html__('', 'organ'),
                'fields' => array(
                    array(
                        'id' => 'enable_header_currency',
                        'type' => 'switch',
                        'title' => esc_html__('Show Currency HTML', 'organ'),
                        'subtitle' => esc_html__('You can show Currency in the header.', 'organ')
                    ),
                    array(
                        'id' => 'enable_header_language',
                        'type' => 'switch',
                        'title' => esc_html__('Show Language HTML', 'organ'),
                        'subtitle' => esc_html__('You can show Language in the header.', 'organ')
                    ),
                    array(
                        'id' => 'header_use_imagelogo',
                        'type' => 'checkbox',
                        'title' => esc_html__('Use Image for Logo?', 'organ'),
                        'subtitle' => esc_html__('If left unchecked, plain text will be used instead (generated from site name).', 'organ'),
                        'desc' => esc_html__('', 'organ'),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'header_logo',
                        'type' => 'media',
                        'required' => array('header_use_imagelogo', '=', '1'),
                        'title' => esc_html__('Logo Upload', 'organ'),
                        'desc' => esc_html__('', 'organ'),
                        'subtitle' => esc_html__('Upload your logo here and enter the height of it below', 'organ'),
                    ),
                    array(
                        'id' => 'header_logo_height',
                        'type' => 'text',
                        'required' => array('header_use_imagelogo', '=', '1'),
                        'title' => esc_html__('Logo Height', 'organ'),
                        'subtitle' => esc_html__('Don\'t include "px" in the string. e.g. 30', 'organ'),
                        'desc' => '',
                        'validate' => 'numeric'
                    ),
                    array(
                        'id' => 'header_logo_width',
                        'type' => 'text',
                        'required' => array('header_use_imagelogo', '=', '1'),
                        'title' => esc_html__('Logo Width', 'organ'),
                        'subtitle' => esc_html__('Don\'t include "px" in the string. e.g. 30', 'organ'),
                        'desc' => '',
                        'validate' => 'numeric'
                    ),    
                                 
                    array(
                        'id' => 'header_remove_header_search',
                        'type' => 'checkbox',
                        'title' => esc_html__('Remove Header Search', 'organ'),
                        'subtitle' => esc_html__('Active to remove the search functionality from your header', 'organ'),
                        'desc' => esc_html__('', 'organ'),
                        'default' => '0'
                    ),
                     array(
                        'id' => 'header_show_info_banner',
                        'type' => 'switch',
                        'title' => esc_html__('Show Info Banners', 'organ'),
                          'default' => '0'
                    ),

                 
                    array(
                        'id' => 'header_shipping_banner',
                        'type' => 'text',
                        'required' => array('header_show_info_banner', '=', '1'),
                        'title' => esc_html__('Shipping Banner Text', 'organ'),
                    ),

                    array(
                        'id' => 'header_customer_support_banner',
                        'type' => 'text',
                        'required' => array('header_show_info_banner', '=', '1'),
                        'title' => esc_html__('Customer Support Banner Text', 'organ'),
                    ),

                    array(
                        'id' => 'header_moneyback_banner',
                        'type' => 'text',
                        'required' => array('header_show_info_banner', '=', '1'),
                        'title' => esc_html__('Warrant/Gaurantee Banner Text', 'organ'),
                    ),
                      array(
                        'id' => 'header_returnservice_banner',
                        'type' => 'text',
                        'required' => array('header_show_info_banner', '=', '1'),
                        'title' => esc_html__('Return service Banner Text', 'organ'),
                    ),
                   
                 
                   
                ) //fields end
            );

             // Edgesettings: Menu Tab
            $this->sections[] = array(
                'icon' => 'el el-website icon',
                'title' => esc_html__('Menu', 'organ'),
                'heading' => esc_html__('All Menu related options are listed here.', 'organ'),
                'desc' => esc_html__('', 'organ'),
                'fields' => array(
                   array(
                        'id' => 'show_menu_arrow',
                        'type' => 'switch',
                        'title' => esc_html__('Show Menu Arrow', 'organ'),
                        'desc'  => esc_html__('Show arrow in menu.', 'organ'),
                        
                    ),               
                   array(
                    'id'       => 'login_button_pos',
                    'type'     => 'radio',
                    'title'    => esc_html__('Show Login/sign and logout link', 'organ'),                   
                    'desc'     => esc_html__('Please Select any option from above.', 'organ'),
                     //Must provide key => value pairs for radio options
                    'options'  => array(
                    'none' => 'None', 
                   'toplinks' => 'In Top Menu', 
                   'main_menu' => 'In Main Menu'
                    ),
                   'default' => 'none'
                    )
                  
                ) // fields ends here
            );
            // Edgesettings: Footer Tab
            $this->sections[] = array(
                'icon' => 'el-icon-file-alt',
                'title' => esc_html__('Footer', 'organ'),
                'heading' => esc_html__('All footer related options are listed here.', 'organ'),
                'desc' => esc_html__('', 'organ'),
                'fields' => array(
                    array(
                        'id' => 'footer_color_scheme',
                        'type' => 'switch',
                        'title' => esc_html__('Custom Footer Color Scheme', 'organ'),
                        'subtitle' => esc_html__('', 'organ')
                    ),               
                    array(
                        'id' => 'footer_copyright_background_color',
                        'type' => 'color',
                        'required' => array('footer_color_scheme', '=', '1'),
                        'transparent' => false,
                        'title' => esc_html__('Footer Copyright Background Color', 'organ'),
                        'subtitle' => esc_html__('', 'organ'),
                        'validate' => 'color',
                    ),
                    array(
                        'id' => 'footer_copyright_font_color',
                        'type' => 'color',
                        'required' => array('footer_color_scheme', '=', '1'),
                        'transparent' => false,
                        'title' => esc_html__('Footer Copyright Font Color', 'organ'),
                        'subtitle' => esc_html__('', 'organ'),
                        'validate' => 'color',
                    ),                    
                    array(
                        'id' => 'bottom-footer-text',
                        'type' => 'editor',
                        'title' => esc_html__('Bottom Footer Text', 'organ'),
                        'subtitle' => esc_html__('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'organ'),
                        'default' => esc_html__('Powered by ThemesSoft', 'organ'),
                    ),
                    array(
                        'id' => 'enable_footer_middle',
                        'type' => 'switch', 
                        'required' => array('theme_layout', '=', 'version2'),                      
                        'title' => esc_html__('Enable footer middle', 'organ'),
                        'subtitle' => esc_html__('You can enable/disable Footer Middle', 'organ')
                    ),

                    array(
                        'id' => 'footer_middle',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Middle Text ', 'organ'), 
                        'required' => array('enable_footer_middle', '=', '1'),               
                       'subtitle' => esc_html__('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'organ'),
                        'default' => '',
                    ),    
                                            
                    
                    
                ) // fields ends here
            );

            //Edgesettings: Blog Tab
            $this->sections[] = array(
                'icon' => 'el-icon-pencil',
                'title' => esc_html__('Blog Page', 'organ'),
                'fields' => array( 
                       array(
                        'id' => 'blog-page-layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Blog Page Layout', 'organ'),
                        'subtitle' => esc_html__('Select main blog listing and category page layout from the available blog layouts.', 'organ'),
                        'options' => array(
                            '1' => array(
                                'alt' => 'Left sidebar',
                                'img' => get_template_directory_uri() . '/images/tmOrgan_col/category-layout-1.png'

                            ),
                            '2' => array(
                                'alt' => 'Right Right',
                                'img' => get_template_directory_uri() . '/images/tmOrgan_col/category-layout-2.png'
                            ),
                            '3' => array(
                                'alt' => '2 Column Right',
                                'img' => get_template_directory_uri() . '/images/tmOrgan_col/category-layout-3.png'
                            )                                                                                 
                          
                        ),
                        'default' => '2'
                    ), 
                     array(
                        'id' => 'blog_show_authors_bio',
                        'type' => 'switch',
                        'title' => esc_html__('Author\'s Bio', 'organ'),
                        'subtitle' => esc_html__('Show Author Bio on Blog page.', 'organ'),
                         'default' => true,
                        'desc' => esc_html__('', 'organ')
                    ),                  
                    array(
                        'id' => 'blog_show_post_by',
                        'type' => 'switch',
                        'title' => esc_html__('Display Post By', 'organ'),
                         'default' => true,
                        'subtitle' => esc_html__('Display Psot by Author on Listing Page', 'organ')
                    ),
                    array(
                        'id' => 'blog_display_tags',
                        'type' => 'switch',
                        'title' => esc_html__('Display Tags', 'organ'),
                         'default' => true,
                        'subtitle' => esc_html__('Display tags at the bottom of posts.', 'organ')
                    ),
                    array(
                        'id' => 'blog_full_date',
                        'type' => 'switch',
                        'title' => esc_html__('Display Full Date', 'organ'),
                        'default' => true,
                        'subtitle' => esc_html__('This will add date of post meta on all blog pages.', 'organ')
                    ),
                    array(
                        'id' => 'blog_display_comments_count',
                        'type' => 'switch',
                        'default' => true,
                        'title' => esc_html__('Display Comments Count', 'organ'),
                        'subtitle' => esc_html__('Display Comments Count on Blog Listing.', 'organ')
                    ),
                    array(
                        'id' => 'blog_display_category',
                        'type' => 'switch',
                        'title' => esc_html__('Display Category', 'organ'),
                         'default' => true,
                        'subtitle' => esc_html__('Display Comments Category on Blog Listing.', 'organ')
                    ),
                    array(
                        'id' => 'blog_display_view_counts',
                        'type' => 'switch',
                        'title' => esc_html__('Display View Counts', 'organ'),
                         'default' => true,
                        'subtitle' => esc_html__('Display View Counts on Blog Listing.', 'organ')
                    ),                  
                )
            );

            // Edgesettings: Social Media Tab
            $this->sections[] = array(
                'icon' => 'el-icon-file',
                'title' => esc_html__('Social Media', 'organ'),
                'fields' => array(
                    array(
                        'id' => 'social_facebook',
                        'type' => 'text',
                        'title' => esc_html__('Facebook URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your Facebook URL.', 'organ'),
                    ),
                    array(
                        'id' => 'social_twitter',
                        'type' => 'text',
                        'title' => esc_html__('Twitter URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your Twitter URL.', 'organ'),
                    ),
                    array(
                        'id' => 'social_googlep',
                        'type' => 'text',
                        'title' => esc_html__('Google+ URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your Google Plus URL.', 'organ'),
                    ),
                  
                    array(
                        'id' => 'social_pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your Pinterest URL.', 'organ'),
                    ),
                    array(
                        'id' => 'social_youtube',
                        'type' => 'text',
                        'title' => esc_html__('Youtube URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your Youtube URL.', 'organ'),
                    ),
                    array(
                        'id' => 'social_linkedin',
                        'type' => 'text',
                        'title' => esc_html__('LinkedIn URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your LinkedIn URL.', 'organ'),
                    ),
                    array(
                        'id' => 'social_rss',
                        'type' => 'text',
                        'title' => esc_html__('RSS URL', 'organ'),
                        'subtitle' => esc_html__('Please enter in your RSS URL.', 'organ'),
                    )                   
                )
            );


            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . esc_html__('<strong>Theme URL:</strong> ', 'organ') . '<a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . esc_html__('<strong>Author:</strong> ', 'organ') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . esc_html__('<strong>Version:</strong> ', 'organ') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . esc_html__('<strong>Tags:</strong> ', 'organ') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';


          
            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'organ'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'organ'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );


        }

        public function setHelpTabs()
        {


        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'tm_option',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Organ Options', 'organ'),
                'page_title' => esc_html__('Organ Options', 'organ'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'organ_Options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => '',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );

            // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
            $this->args['admin_bar_links'][] = array(
                'id' => 'redux-docs',
                'href' => 'http://docs.reduxframework.com/',
                'title' => esc_html__('Documentation', 'organ'),
            );

            $this->args['admin_bar_links'][] = array(
            
                'href' => 'https://github.com/ReduxFramework/redux-framework/issues',
                'title' => esc_html__('Support', 'organ'),
            );

            $this->args['admin_bar_links'][] = array(
                'id' => 'redux-extensions',
                'href' => 'reduxframework.com/extensions',
                'title' => esc_html__('Extensions', 'organ'),
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon' => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );

            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
        }

        public function validate_callback_function($field, $value, $existing_value)
        {
            $error = true;
            $value = 'just testing';

        

            $return['value'] = $value;
            $field['msg'] = 'your custom error message';
            if ($error == true) {
                $return['error'] = $field;
            }

            return $return;
        }

        public function class_field_callback($field, $value)
        {
            print_r($field);
            echo '<br/>CLASS CALLBACK';
            print_r($value);
        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value)
    {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value)
    {
        $error = true;
        $value = 'just testing';

   

        $return['value'] = $value;
        $field['msg'] = 'your custom error message';
        if ($error == true) {
            $return['error'] = $field;
        }

        return $return;
    }
endif;
