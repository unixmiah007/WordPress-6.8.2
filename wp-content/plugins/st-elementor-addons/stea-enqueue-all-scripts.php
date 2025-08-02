<?php
// enqueue Style Start Based on widget load //
function register_widget_styles() {
    wp_register_style(
        'stea-flexbox-slider',
        STEA_URL . 'assets/css/flexbox-slider/stea-flexbox-slider.css',
        [],
        null
    );
    wp_register_style(
        'stea-marquee',
        STEA_URL . 'assets/css/marquee/stea-marquee.css',
        [],
        null
    );
    wp_register_style(
        'stea-product-grid',
        STEA_URL . 'assets/css/product-grid/stea-product-grid.css',
        [],
        null
    );
    wp_register_style(
        'stea-post-grid',
        STEA_URL . 'assets/css/post-grid/stea-post-grid.css',
        [],
        null
    );
    wp_register_style(
        'stea-product-data-tab',
        STEA_URL . 'assets/css/product-data-tab/stea-product-data-tab.css',
        [],
        null
    );
    wp_register_style(
        'stea-page-cart',
        STEA_URL . 'assets/css/page-cart/stea-page-cart.css',
        [],
        null
    );
    wp_register_style(
        'stea-nav-menu',
        STEA_URL . 'assets/css/nav-menu/stea-nav-menu.css',
        [],
        null
    );
    wp_register_style(
        'stea-product-rating',
        STEA_URL . 'assets/css/product-rating/stea-product-rating.css',
        [],
        null
    );
    wp_register_style(
        'stea-page-checkout',
        STEA_URL . 'assets/css/page-checkout/stea-page-checkout.css',
        [],
        null
    );
    wp_register_style(
        'stea-product-checkbox-filter',
        STEA_URL . 'assets/css/product-checkbox-filter/stea-product-checkbox-filter.css',
        [],
        null
    );
}
add_action( 'elementor/frontend/after_register_styles', 'register_widget_styles', 20);

// Enqueue JS only when a widget is used
function enqueue_widget_js_on_use( $widget ) {
    if ( 'stea_marquee' === $widget->get_name() ) {
        wp_enqueue_script(
            'stea-marquee', plugin_dir_url(__FILE__) . 'assets/js/marquee/stea-marquee.js',['jquery'],'1.0', true
        );
        wp_enqueue_script(
            'stea-gsap', plugin_dir_url(__FILE__) . 'assets/js/marquee/gsap.min.js',['jquery'],'1.0', true
        );
    }
}
add_action( 'elementor/frontend/after_render', 'enqueue_widget_js_on_use' );


add_action('wp_enqueue_scripts', 'stea_enqueue_floating_scripts');
function stea_enqueue_floating_scripts() {
    // Register anime.js (required for floating effects)
    wp_register_script(
        'anime',
        STEA_URL . 'assets/js/float-effect/anime.min.js',
        [],
        '3.2.1',
        true
    );
    
    wp_register_script(
        'stea-floating-effect',
        STEA_URL . 'assets/js/float-effect/stea-floating-effect.js',
        ['jquery', 'anime'],
        STEA_VERSION,
        true
    );
    
    wp_enqueue_script(
        'stea-observer', // Note: lowercase for consistency
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Observer.min.js',
        array('jquery', 'stea-gsap'),
        '3.12.2',
        true
    );

    wp_enqueue_script(
        'stea-nav-menu',
        STEA_URL . 'assets/js/nav-menu/stea-nav-menu.js',
        array('jquery'),
        STEA_VERSION,
        true
    );

    wp_enqueue_script(
        'stea-product-checkbox-filter',
        STEA_URL . 'assets/js/product-checkbox-filter/stea-product-checkbox-filter.js',
        array('jquery'),
        STEA_VERSION,
        true
    );
}



// fontawesome
// function enqueue_fontawesome_assets() {
//     // Enqueue Font Awesome CSS
//     wp_enqueue_style(
//         'fontawesome-css',
//         STEA_URL . 'assets/css/fontawesome/all.css',
//         array(),
//         null
//     );

//     // Enqueue Font Awesome JS
//     wp_enqueue_script(
//         'fontawesome-js',
//         STEA_URL . 'assets/js/fontawesome/all.js',
//         array(),
//         null,
//         true
//     );
// }
// add_action('wp_enqueue_scripts', 'enqueue_fontawesome_assets');

function enqueue_fontawesome_with_v4_shim() {
    // Main FA6 CSS
    wp_enqueue_style(
        'fontawesome-css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );

    // FA4 compatibility shim
    wp_enqueue_style(
        'fontawesome-v4-shims',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/v4-shims.min.css',
        array('fontawesome-css'),
        '6.5.0'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_fontawesome_with_v4_shim');




// Enqueue Scritps Start //
// Main File widget-product-grid
add_action( 'wp_enqueue_scripts', 'stea_enqueue_ajax_pagination_scripts' );
function stea_enqueue_ajax_pagination_scripts() {
if (class_exists( 'WooCommerce' ) ) {

    wp_enqueue_script(
        'widget-product-grid', STEA_URL . 'assets/js/product-grid/widget-product-grid.js', [ 'jquery' ], '1.0', true );

    wp_localize_script( 'widget-product-grid', 'stea_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'cart_url' => wc_get_cart_url(), // Add WooCommerce cart URL
        'view_cart_text' => __( 'View Cart', 'st-elementor-addons' ), // Add dynamic text for the "View Cart" button
    ] );
}
}
//  Number Pagination This file is for product number pagination with filter.
add_action('wp_enqueue_scripts', 'stea_enqueue_pagination_scripts');
function stea_enqueue_pagination_scripts() {
    wp_enqueue_script(
        'number-pagination',
        plugin_dir_url(__FILE__) . 'assets/js/product-grid/number-pagination.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_localize_script('number-pagination', 'stea_ajax_filter', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('stea_ajax_filter_nonce'),
    ]);
}


//  Load More Pagination This file is for product load more pagination with filter.

add_action('wp_enqueue_scripts', 'stea_product_filter_scripts');
function stea_product_filter_scripts() {
    wp_enqueue_script(
        'stea-product-filter',
        STEA_URL . 'assets/js/product-grid/product-filter.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_localize_script('stea-product-filter', 'stea_ajax_filter', [
        'ajax_url'       => admin_url('admin-ajax.php'),
        'nonce'          => wp_create_nonce('stea_ajax_filter_nonce'),
        'posts_per_page' => get_option('posts_per_page'), // Default WP posts per page
    ]);
}

function stea_enqueue_wishlist_script() {
    wp_enqueue_script('stea-wishlist-ajax', STEA_URL . 'assets/js/product-grid/whishlist-product-grid.js', ['jquery', 'sweetalert2'], null, true);

    wp_localize_script('stea-wishlist-ajax', 'steaWishlist', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('stea_wishlist_nonce'),
        'login_url' => wp_login_url(),
        'is_user_logged_in' => is_user_logged_in(),
        'i18n' => [
            'login_required' => __('Login Required', 'st-elementor-addons'),
            'login_for_wishlist' => __('Please login to use wishlist feature', 'st-elementor-addons'),
            'login_button' => __('Login Now', 'st-elementor-addons'),
            'cancel_button' => __('Maybe Later', 'st-elementor-addons'),
            'error' => __('Error!', 'st-elementor-addons'),
            'request_failed' => __('Request failed. Please try again.', 'st-elementor-addons')
        ]
    ]);
    
    // Enqueue SweetAlert2 if not already loaded
    if (!wp_script_is('sweetalert2', 'registered')) {
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', [], '11.4.8', true);
        wp_enqueue_style('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css', [], '11.4.8');
    }
}
add_action('wp_enqueue_scripts', 'stea_enqueue_wishlist_script');