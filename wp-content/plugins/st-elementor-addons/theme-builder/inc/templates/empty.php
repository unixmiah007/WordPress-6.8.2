<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

if ( stea_theme_builder_is_singular_enabled() ) {
	stea_theme_builder_render_singular();
} elseif ( stea_theme_builder_is_archive_enabled() ) {
	stea_theme_builder_render_archive();
} else {
	the_content();
}

get_footer();
