<?php
/**
 * Theme Builder Util;
 *
 * @package  ST_Elementor_Addons
 */

use ST_Elementor_Addons\ModulesManager\Theme_Builder\STEA_Theme_Builder;

/**
 * Checks if Header is enabled from STEA.
 *
 * @return bool True if header is enabled. False if header is not enabled
 */
function stea_header_enabled() {
	$header_id = STEA_Theme_Builder::get_settings( 'header', '' );
	$status    = false;

	if ( '' !== $header_id ) {
		$status = true;
	}

	return apply_filters( 'stea_header_enabled', $status );
}

/**
 * Checks if Footer is enabled from STEA.
 *
 * @return bool True if Footer is enabled. False if Footer is not enabled.
 */
function stea_footer_enabled() {
	$footer_id = STEA_Theme_Builder::get_settings( 'footer', '' );
	$status    = false;

	if ( '' !== $footer_id ) {
		$status = true;
	}

	return apply_filters( 'stea_footer_enabled', $status );
}

/**
 * Get STEA Header ID
 *
 * @since  1.3.0
 *
 * @return (String|boolean) Header ID or false.
 */
function get_stea_header_id() {
	$header_id = STEA_Theme_Builder::get_settings( 'header', '' );

	if ( '' === $header_id ) {
		$header_id = false;
	}

	return apply_filters( 'get_stea_header_id', $header_id );
}

/**
 * Get STEA Footer ID
 *
 * @since  1.3.0
 *
 * @return (String|boolean) Footer ID or false.
 */
function get_stea_footer_id() {
	$footer_id = STEA_Theme_Builder::get_settings( 'footer', '' );

	if ( '' === $footer_id ) {
		$footer_id = false;
	}

	return apply_filters( 'get_stea_footer_id', $footer_id );
}

/**
 * Checks if Single template is enabled from STEA.
 *
 * @return bool True if Single template  is enabled. False if Single template is not enabled
 */
function stea_single_page_enabled() {
	$single_id = STEA_Theme_Builder::get_settings( 'single-page', '' );
	$status    = false;

	if ( '' !== $single_id ) {
		$status = true;
	}

	return apply_filters( 'stea_single_page_enabled', $status );
}

/**
 * Get STEA Single Page ID
 *
 * @since  1.3.0
 *
 * @return (String|boolean) Single Page ID or false.
 */
function get_stea_single_page_id() {
	$single_page_id = STEA_Theme_Builder::get_settings( 'single-page', '' );

	if ( '' === $single_page_id ) {
		$single_page_id = false;
	}

	return apply_filters( 'get_stea_single_page_id', $single_page_id );
}

/**
 * Checks if Single template is enabled from STEA.
 *
 * @return bool True if Single template  is enabled. False if Single template is not enabled
 */
function stea_single_enabled() {
	$single_id = STEA_Theme_Builder::get_settings( 'single-post', '' );
	$status    = false;

	if ( '' !== $single_id ) {
		$status = true;
	}

	return apply_filters( 'stea_single_enabled', $status );
}
/**
 * Get STEA Single Post ID
 *
 * @since  1.3.0
 *
 * @return (String|boolean) Single Post ID or false.
 */
function get_stea_single_post_id() {
	$single_post_id = STEA_Theme_Builder::get_settings( 'single-post', '' );

	if ( '' === $single_post_id ) {
		$single_post_id = false;
	}

	return apply_filters( 'get_stea_single_post_id', $single_post_id );
}

/**
 * Get STEA Error 404 ID
 *
 * @since  1.4.0
 *
 * @return (String|boolean) Error_404 ID or false.
 */
function get_stea_error_404_id() {
	$error_404_id = STEA_Theme_Builder::get_settings( 'error-404', '' );

	if ( '' === $error_404_id ) {
		$error_404_id = false;
	}

	return apply_filters( 'get_stea_error_404_id', $error_404_id );
}

/**
 * Checks if Archive template is enabled from STEA.
 *
 * @return bool True if Archive template  is enabled. False if Archive template is not enabled
 */
function stea_archive_enabled() {
	$archive_id = STEA_Theme_Builder::get_settings( 'archive', '' );
	$status     = false;

	if ( '' !== $archive_id ) {
		$status = true;
	}

	return apply_filters( 'stea_archive_enabled', $status );
}
/**
 * Get STEA Archive ID
 *
 * @since  1.5.0
 *
 * @return (String|boolean) Error_404 ID or false.
 */
function get_stea_archive_id() {
	$error_404_id = STEA_Theme_Builder::get_settings( 'archive', '' );

	if ( '' === $error_404_id ) {
		$error_404_id = false;
	}

	return apply_filters( 'get_stea_archive_id', $error_404_id );
}

/**
 * Retrieves the single product ID according to STEA Theme Builder settings.
 *
 * This function checks if the current page is a product page and retrieves the single product ID
 * based on STEA Theme Builder settings.
 *
 * @global object $post The current post object.
 *
 * @return int|false Single product ID if available, otherwise false.
 */
function get_stea_single_product_id() {
	$single_product_id = false;

	if ( is_product() ) {
		if ( '' !== $single_product_id ) {
			$single_product_id = STEA_Theme_Builder::get_settings( 'single-product', '' );
		}
	}

	return apply_filters( 'get_stea_single_product_id', $single_product_id );
}

/**
 * Get STEA Product Archive id
 *
 * @since  1.8.0
 *
 * @return (String|boolean) Error_404 ID or false.
 */
function get_stea_product_archive_id() {
	$product_archive_id = false;
	if ( is_shop() || is_archive() || is_product_taxonomy() || is_product_category() || is_product_tag() || is_woocommerce() ) {
		if ( '' !== $product_archive_id ) {
			$product_archive_id = STEA_Theme_Builder::get_settings( 'product-archive', '' );
		}
	}

	return apply_filters( 'get_stea_product_archive_id', $product_archive_id );

}
/**
 * Display Header markup.
 */
function stea_render_header() {

	if ( false == apply_filters( 'enable_stea_render_header', true ) ) {
		return;
	}

	?>
		<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
			<?php STEA_Theme_Builder::get_header_content(); ?>
		</header>

	<?php

}

/**
 * Display footer markup.
 */
function stea_render_footer() {

	if ( false == apply_filters( 'enable_stea_render_footer', true ) ) {
		return;
	}

	?>
		<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
			<?php STEA_Theme_Builder::get_footer_content(); ?>
		</footer>
	<?php

}

/**
 * Display sigle page/post markup.
 */
function stea_render_single() {

	if ( false == apply_filters( 'enable_stea_render_single', true ) ) {
		return;
	}
	STEA_Theme_Builder::get_single_content();
}

/**
 * Display Archive post/product markup.
 *
 * @since  1.0.2
 */
function stea_render_archive() {

	if ( false == apply_filters( 'enable_stea_render_archive', true ) ) {
		return;
	}
	STEA_Theme_Builder::get_archive_content();
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! is_plugin_active( 'st-elementor-addons/st-elementor-addons.php' ) ) {
	if ( ! function_exists( 'stea_theme_template_render_at_location' ) ) {
		/**
		 * Render STEA Theme location.
		 *
		 * @since 1.7.0
		 *
		 * @param string $location STEA Theme location.
		 * @return boolean
		 */
		function stea_theme_template_render_at_location( $location ) {
			$module  = STEA_Theme_Builder::instance();
			$content = false;

			switch ( $location ) {
				case 'header':
					$content = $module::get_header_content();
					break;
				case 'footer':
					$content = $module::get_footer_content();
					break;
				case 'single':
					$content = $module::get_single_content();
					break;
				case 'archive':
					$content = $module::get_archive_content();
					break;
				// Locations other than Header, Footer, Single Post, Single Page or Archive will render Single template.
				case 'default':
					$content = $module::get_single_content();
			}

			return $content;
		}
	}
}
