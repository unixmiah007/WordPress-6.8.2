<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// Existing code follows...

require STDI_DIR . 'theme-wizard/tgm/class-tgm-plugin-activation.php';
/**
 * Registration of recommended plugins.
 */
function st_demo_importer_register_recommended_plugins_set() {


	$plugins_arr = array(
		array(
			'name'             => __( 'Elementor', 'st-demo-importer' ),
			'slug'             => 'elementor',
			'required'         => true,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'ST Elementor Addons', 'st-demo-importer' ),
			'slug'             => 'st-elementor-addons',
			'required'         => true,
			'force_activation' => false,
		),
	);

	if ( file_exists( get_template_directory() . '/inc/plugins.json' ) ) {
		$plugins_json = file_get_contents( get_template_directory() . '/inc/plugins.json' );
		$plugins_json_decoded = json_decode($plugins_json, true);

		$plugins_arr = array();

		foreach ( $plugins_json_decoded as $plugin_data_json  ) {
			if ( isset( $plugin_data_json ['source'] ) && $plugin_data_json ['source'] != "" ) {
				$plugin_data_json ['source'] = get_template_directory() . $plugin_data_json ['source'];
			}
			array_push( $plugins_arr, $plugin_data_json  );
		}

	}

	$st_demo_importer_config = array();
	st_demo_importer_tgmpa( $plugins_arr, $st_demo_importer_config );
}
add_action( 'st_demo_importer_tgmpa_register', 'st_demo_importer_register_recommended_plugins_set' );
