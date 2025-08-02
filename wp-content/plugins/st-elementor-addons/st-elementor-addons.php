<?php
/**
* Plugin Name: ST Elementor Addons
* Plugin URI:  https://striviothemes.com/st-elementor-addons/
* Description: A lightweight plugin that adds customizable widgets to Elementor, including a button widget, marquee, Flexbox carousel, WooCommerce widgets, and more.
* Version:     0.1.5
* Requires at least: 5.6
* Requires PHP:      7.4
* Author:      kristynabennett
* Author URI:  https://striviothemes.com
* Text Domain: st-elementor-addons
* License:     GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants.
define( 'STEA_VERSION', '0.0.4' );
define( 'STEA_PATH', plugin_dir_path( __FILE__ ) );
// define( 'STEA_URL', plugin_dir_url( __FILE__ ) );
define('STEA_URL', plugins_url('/', __FILE__));
define( 'STEA_FILE', __FILE__ );
define( 'STEA_BASE', plugin_basename( __FILE__ ) );

// Require Admin Dashboard
require STEA_PATH . 'admin/admin-dashboard.php';
// Require Widget Style
require STEA_PATH . 'stea-enqueue-all-scripts.php';

// Register Widgets Dynamically Start
function stea_register() {
    if (did_action('elementor/loaded')) {
        $settings = get_option('stea_widget_status', []);

        if (!empty($settings['stea-marquee']) && $settings['stea-marquee'] === 'on') {
            require_once STEA_PATH . 'includes/marquee/stea-marquee.php';
            \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Marquee_Widget() );
        }
        if (!empty($settings['stea-button']) && $settings['stea-button'] === 'on') {
            require_once STEA_PATH . 'includes/button/stea-button.php';
            \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Button_Widget() );
        }
        if (!empty($settings['stea-nav-menu']) && $settings['stea-nav-menu'] === 'on') {
            require_once STEA_PATH . 'includes/nav-menu/stea-nav-menu.php';
            \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Nav_Menu_Widget() );
        }
        if (!empty($settings['stea-post-grid']) && $settings['stea-post-grid'] === 'on') {
            require_once STEA_PATH . 'includes/post-grid/stea-post-grid.php';
            \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Post_Grid_Widget() );
        }
        // Woocommerce Widgets
        if (class_exists( 'WooCommerce' ) ) {
            
            if (!empty($settings['stea-add-to-cart']) && $settings['stea-add-to-cart'] === 'on') {
                require_once STEA_PATH . 'includes/add-to-cart/stea-add-to-cart.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Add_To_Cart_Widget() );
            }
            if (!empty($settings['stea-product-data-tab']) && $settings['stea-product-data-tab'] === 'on') {
                require_once STEA_PATH . 'includes/product-data-tab/stea-product-data-tab.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_WC_Product_Tabs_Widget() );
            }
            if (!empty($settings['stea-breadcrumb']) && $settings['stea-breadcrumb'] === 'on') {
                require_once STEA_PATH . 'includes/breadcrumb/stea-breadcrumb.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_WC_Breadcrumb() );
            }
            if (!empty($settings['stea-product-price']) && $settings['stea-product-price'] === 'on') {
                require_once STEA_PATH . 'includes/product-price/stea-product-price.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_WC_Product_Price() );
            }
            if (!empty($settings['stea-product-grid']) && $settings['stea-product-grid'] === 'on') {
                require_once STEA_PATH . 'includes/product-grid/stea-product-grid.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Product_Grid_Widget() );
            }
            if (!empty($settings['stea-product-select-filter']) && $settings['stea-product-select-filter'] === 'on') {
                require_once STEA_PATH . 'includes/product-select-filter/stea-product-select-filter.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Product_Select_Filter_Widget() );
            }
            if (!empty($settings['stea-product-checkbox-filter']) && $settings['stea-product-checkbox-filter'] === 'on') {
                require_once STEA_PATH . 'includes/product-checkbox-filter/stea-product-checkbox-filter.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Product_Checkbox_Filter_Widget() );
            }
            if (!empty($settings['stea-page-cart']) && $settings['stea-page-cart'] === 'on') {
                require_once STEA_PATH . 'includes/page-cart/stea-page-cart.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Page_Cart_Widget() );
            }
            if (!empty($settings['stea-page-checkout']) && $settings['stea-page-checkout'] === 'on') {
                require_once STEA_PATH . 'includes/page-checkout/stea-page-checkout.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Page_Checkout_Widget() );
            }
            if (!empty($settings['stea-product-rating']) && $settings['stea-product-rating'] === 'on') {
                require_once STEA_PATH . 'includes/product-rating/stea-product-rating.php';
                \Elementor\Plugin::instance()->widgets_manager->register( new \STEA_Widget\STEA_Product_Rating_Widget() );
            }
        }

    }
}
add_action('elementor/widgets/register', 'stea_register');

// Register Widgets Dynamically End
$settings = get_option('stea_widget_status', []);
if (!empty($settings['stea-flexbox-slider']) && $settings['stea-flexbox-slider'] === 'on') {
	require STEA_PATH . 'includes/flexbox-slider/stea-flexbox-slider-helper.php';
}

if (!empty($settings['stea-dynamic-tags']) && $settings['stea-dynamic-tags'] === 'on') {
    require_once STEA_PATH . 'includes/dynamic-tags/dynamic-tags.php';
    require_once STEA_PATH . 'includes/dynamic-tags/helper-class.php';
}

if (!empty($settings['stea-float-effect']) && $settings['stea-float-effect'] === 'on') {
    require_once STEA_PATH . 'includes/float-effect/stea-float-effect.php';
}

if (!empty($settings['stea-custom-css']) && $settings['stea-custom-css'] === 'on') {
    require_once STEA_PATH . 'includes/custom-css/stea-custom-css.php';
}

// Theme Builder //
require_once STEA_PATH . 'theme-builder/stea-theme-builder.php';
// Theme Builder End //

// Product Grid Start //
require_once( __DIR__ . '/helper/product-grid/stea-product-helper.php' );
require_once( __DIR__ . '/helper/product-grid/ajax-numbered-pagination.php' );



// Wishlist AJAX handler
function stea_update_wishlist_handler() {
    check_ajax_referer('stea_wishlist_nonce', 'security');

    if (!is_user_logged_in()) {
        wp_send_json_error([
            'message' => __('Please login to modify your wishlist','st-elementor-addons')
        ]);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $user_id = get_current_user_id();
    $wishlist = get_user_meta($user_id, 'stea_wishlist', true);
    $wishlist = is_array($wishlist) ? $wishlist : [];

    if (in_array($product_id, $wishlist)) {
        // Remove from wishlist
        $wishlist = array_diff($wishlist, [$product_id]);
        update_user_meta($user_id, 'stea_wishlist', $wishlist);
        wp_send_json_success([
            'message' => __('Product removed from wishlist','st-elementor-addons')
        ]);
    } else {
        // Add to wishlist
        $wishlist[] = $product_id;
        update_user_meta($user_id, 'stea_wishlist', $wishlist);
        wp_send_json_success([
            'message' => __('Product added to wishlist','st-elementor-addons')
        ]);
    }
}
add_action('wp_ajax_stea_update_wishlist', 'stea_update_wishlist_handler');
add_action('wp_ajax_nopriv_stea_update_wishlist', 'stea_update_wishlist_handler');



function stea_display_wishlist() {
    if (!is_user_logged_in()) {
        return '<p>Please log in to view your wishlist.</p>';
    }

    $user_id = get_current_user_id();
    $wishlist = get_user_meta($user_id, 'stea_wishlist', true);

    if (empty($wishlist)) {
        return '<p>Your wishlist is empty.</p>';
    }

    $args = [
        'post_type' => 'product',
        'post__in'  => $wishlist,
    ];
    $query = new WP_Query($args);
    ob_start();
    
    if ($query->have_posts()) {
        echo '<ul class="stea-wishlist">';
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> - ' . $product->get_price_html() . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Your wishlist is empty.</p>';
    }
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('stea_wishlist', 'stea_display_wishlist');