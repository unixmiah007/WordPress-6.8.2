<?php
/**
 * Stea Theme Builder Function
 *
 * @package  st-elementor-addons
 */

/**
 * Checks if Header is enabled from Stea_Theme_Builder.
 *
 * @return bool True if header is enabled. False if header is not enabled
 * @since 1.0.0
 */
function stea_theme_builder_header_enabled() {
	$header_id = Stea_Theme_Builder_Main::get_settings( 'type_header', '' );
	$status    = false;

	if ( '' !== $header_id ) {
		$status = true;
	}

	return apply_filters( 'stea_theme_builder_header_enabled', $status );
}

/**
 * Checks if Footer is enabled from Stea_Theme_Builder.
 *
 * @return bool True if header is enabled. False if header is not enabled.
 * @since 1.0.0
 */
function stea_theme_builder_footer_enabled() {
	$footer_id = Stea_Theme_Builder_Main::get_settings( 'type_footer', '' );
	$status    = false;

	if ( '' !== $footer_id ) {
		$status = true;
	}

	return apply_filters( 'stea_theme_builder_footer_enabled', $status );
}

/**
 * Get Stea_Theme_Builder Header ID
 *
 * @return (String|boolean) header id if it is set else returns false.
 * @since 1.0.0
 */
function get_stea_theme_builder_header_id() {
	$header_id = Stea_Theme_Builder_Main::get_settings( 'type_header', '' );

	if ( '' === $header_id ) {
		$header_id = false;
	}

	return apply_filters( 'get_stea_theme_builder_header_id', $header_id );
}

/**
 * Get Stea_Theme_Builder Footer ID
 *
 * @return (String|boolean) header id if it is set else returns false.
 * @since 1.0.0
 */
function get_stea_theme_builder_footer_id() {
	$footer_id = Stea_Theme_Builder_Main::get_settings( 'type_footer', '' );

	if ( '' === $footer_id ) {
		$footer_id = false;
	}

	return apply_filters( 'get_stea_theme_builder_footer_id', $footer_id );
}

/**
 * Display header markup.
 *
 * @since 1.0.0
 */
function stea_theme_builder_render_header() {

	if ( false === apply_filters( 'enable_stea_theme_builder_render_header', true ) ) {
		return;
	}

	$sticky = get_post_meta( get_stea_theme_builder_header_id(), 'stea_theme_builder_sticky' );
	$class  = ( 'enable' === $sticky[0] ) ? ' steatb-header-sticky' : '';

	?>
	<header class="st-elementor-addons-header<?php echo esc_attr( $class ); ?>" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
		<p class="main-title stea-hidden" itemprop="headline"><a href="<?php echo esc_url( bloginfo( 'url' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php esc_html( bloginfo( 'name' ) ); ?></a></p>
		<nav class="st-elementor-addons-header-nav">
			<?php Stea_Theme_Builder_Main::get_header_content(); ?>
		</nav>
	</header>

	<?php

}

/**
 * Display footer markup.
 *
 * @since 1.0.0
 */
function stea_theme_builder_render_footer() {

	if ( false === apply_filters( 'enable_stea_theme_builder_render_footer', true ) ) {
		return;
	}

	?>
	<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="st-elementor-addons-footer"
			role="contentinfo">
		<?php Stea_Theme_Builder_Main::get_footer_content(); ?>
	</footer>
	<?php

}


/**
 * Get Stea_Theme_Builder Before Footer ID
 *
 * @return String|boolean before footer id if it is set else returns false.
 * @since 1.0.0
 */
function stea_theme_builder_get_singular_id() {

	$singular_id = Stea_Theme_Builder_Main::get_settings( 'type_singular', '' );

	if ( '' === $singular_id ) {
		$singular_id = false;
	}

	return apply_filters( 'get_stea_theme_builder_singular_id', $singular_id );
}

/**
 * Checks if Before Footer is enabled from Stea_Theme_Builder.
 *
 * @return bool True if before footer is enabled. False if before footer is not enabled.
 * @since 1.0.0
 */
function stea_theme_builder_is_singular_enabled() {

	$singular_id = Stea_Theme_Builder_Main::get_settings( 'type_singular', '' );
	$status      = false;

	if ( '' !== $singular_id ) {
		$status = true;
	}

	return apply_filters( 'stea_theme_builder_singular_enabled', $status );
}

/**
 * Display before footer markup.
 *
 * @since 1.0.0
 */
function stea_theme_builder_render_singular() {

	if ( false === apply_filters( 'enable_stea_theme_builder_render_singular', true ) ) {
		return;
	}
	?>
	<div class="st-elementor-addons-singular-wrapper">
		<?php Stea_Theme_Builder_Main::get_singular_content(); ?>
	</div>
	<?php

}

/**
 * Get Stea_Theme_Builder Before Footer ID
 *
 * @return String|boolean before footer id if it is set else returns false.
 * @since 1.0.0
 */
function stea_theme_builder_get_archive_id() {

	$archive_id = Stea_Theme_Builder_Main::get_settings( 'type_archive', '' );

	if ( '' === $archive_id ) {
		$archive_id = false;
	}

	return apply_filters( 'get_stea_theme_builder_archive_id', $archive_id );
}

/**
 * Checks if Before Footer is enabled from Stea_Theme_Builder.
 *
 * @return bool True if before footer is enabled. False if before footer is not enabled.
 * @since 1.0.0
 */
function stea_theme_builder_is_archive_enabled() {

	$archive_id = Stea_Theme_Builder_Main::get_settings( 'type_archive', '' );
	$status     = false;

	if ( '' !== $archive_id ) {
		$status = true;
	}

	return apply_filters( 'stea_theme_builder_archive_enabled', $status );
}

/**
 * Display before footer markup.
 *
 * @since 1.0.0
 */
function stea_theme_builder_render_archive() {

	if ( false === apply_filters( 'enable_stea_theme_builder_render_archive', true ) ) {
		return;
	}
	?>
	<div class="st-elementor-addons-archive-wrapper">
		<?php Stea_Theme_Builder_Main::get_archive_content(); ?>
	</div>
	<?php

}
