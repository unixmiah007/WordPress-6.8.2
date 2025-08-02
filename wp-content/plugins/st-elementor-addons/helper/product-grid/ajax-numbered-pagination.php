<?php
function stea_numbered_pagination() {
    check_ajax_referer('stea_ajax_filter_nonce', 'security');

    $category           = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $currentProCat      = isset($_POST['current_pro_cat']) ? sanitize_text_field($_POST['current_pro_cat']) : '';
    $paged              = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page     = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6; // default fallback
    $add_to_cart_btn_text = isset($_POST['button_title']) ? sanitize_text_field($_POST['button_title']) : '';
    $product_filter_by  = isset($_POST['product_filter_by']) ? sanitize_text_field($_POST['product_filter_by']) : 'recent_products';
    $pagination_type  = isset($_POST['pagination_type']) ? sanitize_text_field($_POST['pagination_type']) : 'page_numbers';
    $product_card_design  = isset($_POST['product_card']) ? sanitize_text_field($_POST['product_card']) : 'product-card-1';

    $raw_button_icon = isset($_POST['button_icon']) ? wp_unslash($_POST['button_icon']) : '';
    $decoded_icon = json_decode($raw_button_icon, true);

    $button_add_to_cart_icon = array(
        'value'   => '',
        'library' => '',
    );

    if (is_array($decoded_icon)) {
        $library = isset($decoded_icon['library']) ? sanitize_text_field($decoded_icon['library']) : '';
        if (isset($decoded_icon['value']) && is_array($decoded_icon['value']) && isset($decoded_icon['value']['url']) && strtolower($library) === 'svg') {
            $button_add_to_cart_icon['value'] = array('url' => esc_url_raw($decoded_icon['value']['url']));
            $button_add_to_cart_icon['library'] = 'svg';
        } elseif (isset($decoded_icon['value']) && is_string($decoded_icon['value']) && !empty($decoded_icon['value'])) {
            $button_add_to_cart_icon['value'] = sanitize_text_field($decoded_icon['value']);
            $button_add_to_cart_icon['library'] = $library ?: 'font';
        }
    } else {
        $button_add_to_cart_icon['value'] = sanitize_text_field($raw_button_icon);
        $button_add_to_cart_icon['library'] = 'font';
    }

    // Base args
    $args = [
        'post_type'      => 'product',
        'post_status'    =>  'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
    ];

    $tax_query_array = array(
        'relation' => 'AND'
      );

    // Handle product filter types
    if(!empty( $category )){
        if (!empty($category)) {
            $tax_query_array = array();
            
            // If $category contains comma-separated values
            if (strpos($category, ',') !== false) {
                $category_slugs = explode(',', $category);
                $tax_query_array[] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category_slugs,
                    'operator' => 'IN' // This will match products in ANY of the categories
                );
            } 
            // Single category
            else {
                $tax_query_array[] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category
                );
            }
        }
    }else {
        switch ($product_filter_by) {
            case 'recent_products':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
    
            case 'related_products':
                    $current_product_id = get_the_ID();
                    $related_pro_ids = [];
                    if (!empty($_POST['related_pro_ids'])) {
                        $ids = $_POST['related_pro_ids'];
                        $related_pro_ids = is_array($ids) ? $ids : json_decode(stripslashes($ids), true);
                        $related_pro_ids = array_filter(array_map('intval', (array) $related_pro_ids));
                    }
                    $related_ids = wc_get_related_products($current_product_id, $posts_per_page);
                    $args['post__in'] = $related_pro_ids;
                break;
    
            case 'custom_select':
                // tax_query will be set below based on category/currentProCat
                break;
    
           // Replace the current_query case with this:
            case 'current_query':
                $current_query_vars = isset($_POST['current_query_vars']) ? json_decode(stripslashes($_POST['current_query_vars']), true) : [];
                    array_push( $tax_query_array, array(
                        'taxonomy'  =>  'product_cat',
                        'field'     =>  'term_id',
                        'terms'     =>  $current_query_vars
                    ));
                break;
        }
    }

    $args['tax_query'] = $tax_query_array;
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        $template_path = STEA_PATH . 'templates/products/stea-' . $product_card_design . '.php';
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            // include STEA_PATH . 'templates/products/stea-' . $product_card_design . '.php';

            if ( file_exists( $template_path ) ) {
                include $template_path;
            } else {
                echo '<p>' . esc_html__( 'Product template not found: ', 'st-elementor-addons' ) . esc_html( $product_card_design ) . '</p>';
            }

        }
        $products_html = ob_get_clean();
    
        $max_page = $query->max_num_pages;
        $pagination_html = '';
        $load_more_html = '';
    
        if ($pagination_type === 'page_numbers' && $max_page > 1) {
            $pagination_html = '<div class="stea-pagination">';
            for ($i = 1; $i <= $max_page; $i++) {
                $active_class = ($i === $paged) ? 'active' : '';
                $pagination_html .= '<button class="pagination-button ' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
            }
            $pagination_html .= '</div>';
        } elseif ($pagination_type === 'load_more' && $paged < $max_page) {
            $load_more_html = '<div class="stea-product-grid-load-more-wrap">';
            $load_more_html .= '<button id="load-more-products" class="button load-more-products" data-page="' . ($paged + 1) . '">' . __('Load More', 'st-elementor-addons') . '</button>';
            $load_more_html .= '</div>';
        }
        
        wp_send_json_success([
            'html'            => $products_html,
            'pagination_html' => $pagination_html,
            'load_more_html'  => $load_more_html,
            'max_page'        => $max_page,
        ]);
    } else {
        wp_send_json_error(__('No products found.', 'st-elementor-addons'));
    }
        wp_die();
    }
add_action('wp_ajax_stea_numbered_pagination', 'stea_numbered_pagination');
add_action('wp_ajax_nopriv_stea_numbered_pagination', 'stea_numbered_pagination');