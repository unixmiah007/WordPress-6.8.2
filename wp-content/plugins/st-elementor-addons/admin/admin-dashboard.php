<?php
function stea_add_admin_page() {
    // Add the main STE Addons menu
    add_menu_page(
        'ST Elementor Addons',
        'STE Addons',
        'manage_options',
        'stea-dashboard',
        'stea_dashboard_page',
        STEA_URL . 'admin/assets/images/stea-admin-logo.svg',
        50
    );

    // Theme Builder Sub menu
    add_submenu_page(
        'stea-dashboard',
        esc_html__( 'Theme Builder', 'st-elementor-addons' ),
        esc_html__( 'Theme Builder', 'st-elementor-addons' ),
        'manage_options',
        'edit.php?post_type=stea-theme-template'
    );

    // Buy Bundle Sub menu
    add_submenu_page(
        'stea-dashboard', 
        'Buy Bundle',     
        'Buy Bundle',     
        'manage_options', 
        'stea-buy-bundle',
        'stea_redirect_to_bundle'
    );
}
add_action('admin_menu', 'stea_add_admin_page');

// Redirect callback for "Buy Bundle"
function stea_admin_menu_script() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyBundleLink = document.querySelector('#toplevel_page_stea-dashboard ul li:last-child a');
            if (buyBundleLink && buyBundleLink.href.includes('stea-buy-bundle')) {
                buyBundleLink.setAttribute('target', '_blank');
                buyBundleLink.setAttribute('href', 'https://striviothemes.com/product/wordpress-theme-bundle/');
            }
        });
    </script>
    <?php
}
add_action('admin_footer', 'stea_admin_menu_script');

function stea_dashboard_page() {
    ?>
    <div class="stea-main-wrap">
        <div id="stea-admin-wrapper">
            <!-- Sidebar -->
            <div id="stea-sidebar-wrap">
                <div class="stea-sidebar">
                    <div class="stea-logo">
                        <h2>ST Elementor Addons</h2>
                    </div>
                    <ul class="stea-menu">
                        <li><a href="#stea-wel-mng-main-dashboard">Dashboard</a></li>
                        <li class="active"><a href="#stea-wid-mng-main-dashboard">Widgets</a></li>
                        <li><a href="#extensions">Extensions</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div id="stea-admin-dash-right-container">
                <div id="stea-wel-mng-main-dashboard" class="stea-admin-dash-detail-tab"> <?php require_once STEA_PATH . 'admin/welcome-dashboard.php'; ?></div>
                <div id="stea-wid-mng-main-dashboard" class="stea-admin-dash-detail-tab active"> <?php require_once STEA_PATH . 'admin/widget-dashboard.php'; ?></div>
                <div id="extensions" class="stea-admin-dash-detail-tab"> <?php require_once STEA_PATH . 'admin/extensions-dashboard.php'; ?> </div>
            </div>
        </div>
    </div>
    <?php
}

function st_elementor_addons_admin_assets() {
    // Enqueue Admin CSS
    wp_enqueue_style(
        'st-elementor-addons-admin-css', 
        STEA_URL . 'admin/assets/css/admin.css',
        [],
        '1.0', 
        'all' 
    );

    // Enqueue Admin JS
    wp_enqueue_script(
        'st-elementor-addons-admin-js',
        STEA_URL . 'admin/assets/js/stea-admin.js',
        ['jquery'],
        '1.0', 
        true 
    );

    // Localize the script with AJAX URL and nonce
    wp_localize_script(
        'st-elementor-addons-admin-js',
        'stea_admin_ajax',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('stea_admin_nonce')
        ]
    );
    // Enqueue SweetAlert2 pop-up on save settings in admin dashboard
    wp_enqueue_script(
        'sweetalert2',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
        [],
        null,
        true
);

}
add_action('admin_enqueue_scripts', 'st_elementor_addons_admin_assets');

// Initialize the option if it doesn't exist
// Get existing option
$existing_widget_status = get_option('stea_widget_status', []);

// Define default values
$default_widget_status = [
    'stea-button'         => 'on',
    'stea-flexbox-slider' => 'on',
    'stea-marquee'   => 'on',
    'stea-dynamic-tags'   => 'on',
    'stea-float-effect'   => 'on',
    'stea-custom-css'   => 'on',
    'stea-product-grid'   => 'on',
    'stea-product-select-filter' => 'on',
    'stea-product-checkbox-filter' => 'on',
    'stea-add-to-cart' => 'on',
    'stea-breadcrumb' => 'on', 
    'stea-product-price' => 'on',
    'stea-product-data-tab' => 'on',
    'stea-page-cart' => 'on',
    'stea-page-checkout' => 'on',
    'stea-nav-menu' => 'on',
    'stea-post-grid' => 'on',
    'stea-product-rating' => 'on'
];

// Merge existing options with new ones
$updated_widget_status = array_merge($default_widget_status, $existing_widget_status);

// Update the option only if there are new values
if ($existing_widget_status !== $updated_widget_status) {
    update_option('stea_widget_status', $updated_widget_status);
}

add_action('wp_ajax_stea_save_widget_status', 'stea_save_widget_status');

function stea_save_widget_status() {
    // Security check
    if (!isset($_POST['_ajax_nonce']) || !wp_verify_nonce($_POST['_ajax_nonce'], 'stea_admin_nonce')) {
        wp_send_json_error(['message' => 'Security check failed.']);
    }

    // Validate input
    if (!isset($_POST['widget_name']) || !isset($_POST['widget_status'])) {
        wp_send_json_error(['message' => 'Invalid input.']);
    }

    $widget_name = sanitize_text_field($_POST['widget_name']);
    $widget_status = sanitize_text_field($_POST['widget_status']);

    $widget_statuses = get_option('stea_widget_status', []);

    // Save only if widget exists
    if (!array_key_exists($widget_name, $widget_statuses)) {
        wp_send_json_error(['message' => 'Widget not found.']);
    }

    $widget_statuses[$widget_name] = $widget_status;
    update_option('stea_widget_status', $widget_statuses);

    wp_send_json_success(['message' => 'Value saved']);
}
