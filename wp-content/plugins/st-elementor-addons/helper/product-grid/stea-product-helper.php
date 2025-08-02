<?php
// Add to Cart to view cart Product Grid
 function ajax_add_to_cart_handler() {
    $product_id = intval($_POST['product_id']);
    if ($product_id && class_exists('WC_Cart')) {
        $added = WC()->cart->add_to_cart($product_id);
        if ($added) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    }

    wp_die();
}
add_action('wp_ajax_add_to_cart', 'ajax_add_to_cart_handler');
add_action('wp_ajax_nopriv_add_to_cart', 'ajax_add_to_cart_handler');

// AJAX Handler Product Filter
add_action('wp_ajax_stea_filter_products', 'stea_filter_products');
add_action('wp_ajax_nopriv_stea_filter_products', 'stea_filter_products');

function stea_filter_products() {
    check_ajax_referer('stea_ajax_filter_nonce', 'security');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $currentProCat = isset($_POST['current_pro_cat']) ? sanitize_text_field($_POST['current_pro_cat']) : '';
    $add_to_cart_btn_text = isset($_POST['button_title']) ? sanitize_text_field($_POST['button_title']) : '';
    $buttonIcon = isset($_POST['button_icon']) ? sanitize_text_field($_POST['button_icon']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : $settings['posts_per_page'];
    
    
    $raw_button_icon = isset($_POST['button_icon']) ? wp_unslash($_POST['button_icon']) : '';
$decoded_icon = json_decode($raw_button_icon, true);

// Set default structure
$button_add_to_cart_icon = array(
    'value'   => '',
    'library' => '',
);

// Check if it's an array (from Elementor icon picker)
if (is_array($decoded_icon)) {
    $library = isset($decoded_icon['library']) ? sanitize_text_field($decoded_icon['library']) : '';

    // Case: custom SVG with URL
    if (
        isset($decoded_icon['value']) &&
        is_array($decoded_icon['value']) &&
        isset($decoded_icon['value']['url']) &&
        strtolower($library) === 'svg'
    ) {
        $button_add_to_cart_icon['value'] = array(
            'url' => esc_url_raw($decoded_icon['value']['url']),
        );
        $button_add_to_cart_icon['library'] = 'svg';

    // Case: font icon (e.g., 'fas fa-star')
    } elseif (
        isset($decoded_icon['value']) &&
        is_string($decoded_icon['value']) &&
        !empty($decoded_icon['value'])
    ) {
        $button_add_to_cart_icon['value'] = sanitize_text_field($decoded_icon['value']);
        $button_add_to_cart_icon['library'] = $library ? $library : 'font';
    }
} else {
    // Fallback: string icon from somewhere else
    $button_add_to_cart_icon['value'] = sanitize_text_field($raw_button_icon);
    $button_add_to_cart_icon['library'] = 'font';
}
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    ];

    if (!empty($currentProCat)) {
        $currentProCatArray = array_map('trim', explode(',', $currentProCat)); // Convert string to array
        
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $currentProCatArray, // Use the array
                'operator' => 'IN', // Ensures it matches any of the categories
            ],
        ];
    } elseif (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => (array) $category, // Ensure it's an array
                'operator' => 'IN', // Ensures it matches any of the categories
            ],
        ];
    }
    
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();

        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            
            include STEA_PATH . 'templates/products/stea-product-card-1.php';                

        }

        $products_html = ob_get_clean();
        $max_page = $query->max_num_pages;

        // Prepare the Load More button
        $load_more_html = '';
        if ($paged < $max_page) {
            $load_more_html = '<div class="stea-product-grid-load-more-wrap">';
            $load_more_html .= '<button id="load-more-products" class="button load-more-products" data-page="' . esc_attr($paged + 1) . '" data-category="' . esc_attr($category) . '">' . __( 'Load More', 'st-elementor-addons' ) . '</button>';
            $load_more_html .= '</div>';
        }

        wp_send_json_success([
            'html' => $products_html,
            'load_more_html' => $load_more_html,
            'max_page' => $max_page,
        ]);
    } else {
        wp_send_json_error(__('No products found.', 'st-elementor-addons'));
    }

    wp_die();
}