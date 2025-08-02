<?php
require_once (get_template_directory(). '/includes/tgm_activation/class-tgm-plugin-activation.php');

add_action('tgmpa_register', 'tmOrgan_register_required_plugins');

function tmOrgan_register_required_plugins()
{

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(


        array(
            'name' => 'Redux Framework', // The plugin name.
            'slug' => 'redux-framework', // The plugin slug (typically the folder name).
            'required' => true, // If false, the plugin is only 'recommended' instead of required.

        ),

        array(
            'name' => 'WooCommerce', // The plugin name.
            'slug' => 'woocommerce', // The plugin slug (typically the folder name).
            'required' => true, // If false, the plugin is only 'recommended' instead of required.

        ),


        array(
            'name' => 'YITH Woocommerce Compare', // The plugin name.
            'slug' => 'yith-woocommerce-compare', // The plugin slug (typically the folder name).
            'required' => true, // If false, the plugin is only 'recommended' instead of required.

        ),

        array(
            'name' => 'YITH WooCommerce Quick View', // The plugin name.
            'slug' => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name).
            'required' => true, // If false, the plugin is only 'recommended' instead of required.

        ),
        array(
            'name' => 'YITH WooCommerce Wishlist', // The plugin name.
            'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name).
            'required' => true, // If false, the plugin is only 'recommended' instead of required.

        ),
         array(
            'name' => 'MailChimp for WordPress', // The plugin name.
            'slug' => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
            'required' => false, // If false, the plugin is only 'recommended' instead of required.

        )
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'organ',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

        /*
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'organ' ),
            'menu_title'                      => __( 'Install Plugins', 'organ' ),
            /* translators: %s: plugin name. * /
            'installing'                      => __( 'Installing Plugin: %s', 'organ' ),
            /* translators: %s: plugin name. * /
            'updating'                        => __( 'Updating Plugin: %s', 'organ' ),
            'oops'                            => __( 'Something went wrong with the plugin API.', 'organ' ),
            'notice_can_install_required'     => _n_noop(
                /* translators: 1: plugin name(s). * /
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'organ'
            ),
            'notice_can_install_recommended'  => _n_noop(
                /* translators: 1: plugin name(s). * /
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'organ'
            ),
            'notice_ask_to_update'            => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'organ'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                /* translators: 1: plugin name(s). * /
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'organ'
            ),
            'notice_can_activate_required'    => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'organ'
            ),
            'notice_can_activate_recommended' => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'organ'
            ),
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'organ'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'organ'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'organ'
            ),
            'return'                          => __( 'Return to Required Plugins Installer', 'organ' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'organ' ),
            'activated_successfully'          => __( 'The following plugin was activated successfully:', 'organ' ),
            /* translators: 1: plugin name. * /
            'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'organ' ),
            /* translators: 1: plugin name. * /
            'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'organ' ),
            /* translators: 1: dashboard link. * /
            'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'organ' ),
            'dismiss'                         => __( 'Dismiss this notice', 'organ' ),
            'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'organ' ),
            'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'organ' ),

            'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
        ),
        */
    );

    tgmpa($plugins, $config);

}