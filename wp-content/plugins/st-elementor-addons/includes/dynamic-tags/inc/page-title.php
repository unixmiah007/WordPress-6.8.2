<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use StElementorAddons\Inc\Helper\St_Elementor_Addons_Helper;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Page_Title extends Tag
{

	public function get_name()
	{
		return 'stea-page-title';
	}

	public function get_title()
	{
		return esc_html__('Page Title', 'st-elementor-addons' );
	}

	public function get_group()
	{
		return 'site';
	}

	public function get_categories()
	{
		return [TagsModule::TEXT_CATEGORY];
	}

	public function render()
	{
		if (is_home() && 'yes' !== $this->get_settings('show_home_title')) {
			return;
		}

		$include_context = 'yes' === $this->get_settings('include_context');

		$title = St_Elementor_Addons_Helper::stea_get_page_title($include_context);

		echo wp_kses_post($title);
	}

	protected function register_controls()
	{
		$this->add_control(
			'include_context',
			[
				'label' => esc_html__('Include Context', 'st-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_home_title',
			[
				'label' => esc_html__('Show Home Title', 'st-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);
	}
}
