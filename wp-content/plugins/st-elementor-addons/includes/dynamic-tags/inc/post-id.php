<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Post_ID extends Tag
{

	public function get_name()
	{
		return 'stea-post-id';
	}

	public function get_title()
	{
		return esc_html__('Post ID', 'st-elementor-addons' );
	}

	public function get_group()
	{
		return 'post';
	}

	public function get_categories()
	{
		return [TagsModule::TEXT_CATEGORY];
	}

	public function render()
	{
		echo get_the_ID();
	}
}
