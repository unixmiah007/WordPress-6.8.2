<?php
/**
 * Single Post/Page File.
 *
 * @package ST_Elementor_Addons
 */

use ST_Elementor_Addons\ModulesManager\Theme_Builder\STEA_Theme_Builder;


@get_header();

STEA_Theme_Builder::get_single_content();

@get_footer();

