<?php
/**
 * STEA_Default_Compat setup
 *
 * @package ST_Elementor_Addons
 */

namespace ST_Elementor_Addons\Themes;

use ST_Elementor_Addons\ModulesManager\Theme_Builder\STEA_Theme_Builder;

/**
 * Astra theme compatibility.
 */
class STEA_Default_Compat {

	/**
	 *  Initiator
	 */
	public function __construct() {
		add_action( 'wp', array( $this, 'hooks' ) );
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( stea_header_enabled() ) {
			// Replace header.php template.
			add_action( 'get_header', array( $this, 'override_header' ) );

			// Display STEA's header in the replaced header.
			add_action( 'stea_header', 'stea_render_header' );
		}

		if ( stea_footer_enabled() ) {
			// Replace footer.php template.
			add_action( 'get_footer', array( $this, 'override_footer' ) );

			// Display STEA's footer in the replaced footer.
			add_action( 'stea_footer', 'stea_render_footer' );
		}

	}

	/**
	 * Function for overriding the header in the elmentor way.
	 *
	 * @return void
	 */
	public function override_header() {
		require STEA_PATH . 'theme-builder/themes/default/stea-header.php';
		$templates   = array();
		$templates[] = 'header.php';
		// Avoid running wp_head hooks again.
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	/**
	 * Function for overriding the footer in the elmentor way.
	 *
	 * @return void
	 */
	public function override_footer() {
		require STEA_PATH . 'theme-builder/themes/default/stea-footer.php';
		$templates   = array();
		$templates[] = 'footer.php';
		// Avoid running wp_footer hooks again.
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

}

new STEA_Default_Compat();
