<?php
/**
 * STEA_Compatibility_Compat setup
 *
 * @package ST_Elementor_Addons
 */

use ST_Elementor_Addons\ModulesManager\Theme_Builder\STEA_Theme_Builder;

/**
 * Astra theme compatibility.
 */
class STEA_Compatibility_Compat {

	/**
	 * Instance of STEA_Compatibility_Compat.
	 *
	 * @var STEA_Compatibility_Compat
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new STEA_Compatibility_Compat();

			add_action( 'wp', array( self::$instance, 'hooks' ) );
		}

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( stea_header_enabled() ) {
			add_action( 'template_redirect', array( $this, 'setup_header_compatibility' ), 10 );
			add_action( 'astra_header', 'stea_render_header' );
		}

		if ( stea_footer_enabled() ) {
			add_action( 'template_redirect', array( $this, 'setup_footer_compatibility' ), 10 );
			add_action( 'astra_footer', 'stea_render_footer' );
		}

		if ( stea_single_enabled() || stea_archive_enabled() || get_stea_error_404_id() || stea_single_page_enabled() ) {
			// Replace templates.
			add_filter( 'template_include', array( $this, 'override_single' ), 11 );
		}
	}

	/**
	 * Disable header from the theme.
	 */
	public function setup_header_compatibility() {
		remove_action( 'astra_header', 'astra_header_markup' );

		// Remove the new header builder action.
		if ( class_exists( 'Astra_Builder_Helper' ) && Astra_Builder_Helper::$is_header_footer_builder_active ) {
			remove_action( 'astra_header', array( Astra_Builder_Header::get_instance(), 'prepare_header_builder_markup' ) );
		}
	}

	/**
	 * Disable footer from the theme.
	 */
	public function setup_footer_compatibility() {
		remove_action( 'astra_footer', 'astra_footer_markup' );

		// Remove the new footer builder action.
		if ( class_exists( 'Astra_Builder_Helper' ) && Astra_Builder_Helper::$is_header_footer_builder_active ) {
			remove_action( 'astra_footer', array( Astra_Builder_Footer::get_instance(), 'footer_markup' ) );
		}
	}

	/**
	 * Function for overriding the single,archive templates in the elmentor way.
	 *
	 * @return void
	 */
	public function override_single() {

		if ( is_404() ) {
			require STEA_PATH . 'theme-builder/themes/default/stea-header-footer-single.php';
		}
		if ( is_page() ) {
			require STEA_PATH . 'theme-builder/themes/default/stea-header-footer-single.php';
		}
		if ( is_single() ) {
			require STEA_PATH . 'theme-builder/themes/default/stea-header-footer-single.php';
		}
		if ( is_archive() ) {
			require STEA_PATH . 'theme-builder/themes/default/stea-header-footer-archive.php';
		}
	}
}

STEA_Compatibility_Compat::instance();
