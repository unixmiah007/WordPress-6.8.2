<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Author_Info extends Tag
{

	public function get_name()
	{
		return 'stea-author-info';
	}

	public function get_title()
	{
		return esc_html__('Author Info', 'st-elementor-addons' );
	}

	public function get_group()
	{
		return 'author';
	}

	public function get_categories()
	{
		return [TagsModule::TEXT_CATEGORY];
	}

	public function render()
	{
		$key = $this->get_settings('key');

		if (empty($key)) {
			return;
		}

		$value = get_the_author_meta($key);

		echo wp_kses_post($value);
	}

	public function get_panel_template_setting_key()
	{
		return 'key';
	}

	protected function register_controls()
	{
		$this->add_control(
			'key',
			[
				'label' => esc_html__('Field', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'description',
				'options' => [
					'description' => esc_html__('Bio', 'st-elementor-addons' ),
					'email' => esc_html__('Email', 'st-elementor-addons' ),
					'url' => esc_html__('Website', 'st-elementor-addons' ),
				],
			]
		);
	}
}
