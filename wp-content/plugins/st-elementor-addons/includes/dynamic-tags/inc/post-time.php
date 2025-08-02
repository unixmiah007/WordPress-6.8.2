<?php

namespace StElementorAddons\Modules\DynamicTags\Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class STEA_Post_Time extends Tag
{

	public function get_name()
	{
		return 'stea-post-time';
	}

	public function get_title()
	{
		return esc_html__('Post Time', 'st-elementor-addons' );
	}

	public function get_group()
	{
		return 'post';
	}

	public function get_categories()
	{
		return [TagsModule::TEXT_CATEGORY];
	}

	protected function register_controls()
	{
		$this->add_control(
			'type',
			[
				'label' => esc_html__('Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'post_date_gmt' => esc_html__('Post Published', 'st-elementor-addons' ),
					'post_modified_gmt' => esc_html__('Post Modified', 'st-elementor-addons' ),
				],
				'default' => 'post_date_gmt',
			]
		);

		$this->add_control(
			'format',
			[
				'label' => esc_html__('Format', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__('Default', 'st-elementor-addons' ),
					'g:i a' => date('g:i a'),
					'g:i A' => date('g:i A'),
					'H:i' => date('H:i'),
					'custom' => esc_html__('Custom', 'st-elementor-addons' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'custom_format',
			[
				'label' => esc_html__('Custom Format', 'st-elementor-addons' ),
				'default' => '',
				'description' => sprintf('<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', esc_html__('Documentation on date and time formatting', 'st-elementor-addons' )),
				'condition' => [
					'format' => 'custom',
				],
			]
		);
	}

	public function render()
	{
		$time_type = $this->get_settings('type');
		$format = $this->get_settings('format');

		switch ($format) {
			case 'default':
				$date_format = '';
				break;
			case 'custom':
				$date_format = $this->get_settings('custom_format');
				break;
			default:
				$date_format = $format;
				break;
		}

		if ('post_date_gmt' === $time_type) {
			$value = get_the_time($date_format);
		} else {
			$value = get_the_modified_time($date_format);
		}

		echo wp_kses_post($value);
	}
}
