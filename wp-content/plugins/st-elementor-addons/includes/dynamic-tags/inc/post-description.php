<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Post_Description extends Tag
{

	public function get_name()
	{
		return 'stea-post-description';
	}

	public function get_title()
	{
		return esc_html__('Post Description', 'st-elementor-addons' );
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
		// Allow only a real `post_description` and not the trimmed `post_content` from the `get_the_description` filter
		$post = get_post();
		if (!$post || empty($post->post_content)) {
			return;
		}

		echo wp_kses_post($post->post_content);
	}
}
