<?php
final class Stea_Theme_Builder {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		//Fires when Stea Theme Builder was fully loaded
		do_action( 'stea_theme_builder_loaded' );

		require_once plugin_dir_path( __FILE__ ) . 'stea-theme-builder-helper.php';
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'st-elementor-addons' );
	}


}

// Instantiate Stea_Theme_Builder.
new Stea_Theme_Builder();
