<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Archive_Description extends Tag
{

	public function get_name()
	{
		return 'stea-archive-description';
	}

	public function get_title()
	{
		return esc_html__('Archive Description', 'st-elementor-addons' );
	}

	public function get_group()
	{
		return 'archive';
	}

	public function get_categories()
	{
		return [TagsModule::TEXT_CATEGORY];
	}

	public function render()
	{
		echo wp_kses_post(get_the_archive_description());
	}
}
