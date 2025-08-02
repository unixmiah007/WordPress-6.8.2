<?php
/**
 * Class STEA_Widget\STEA_Button_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Button_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_button';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Button', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-button';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // Content Tab
        $this->start_controls_section(
            'stea_btn_content_section',
            [
                'label' => __( 'Content', 'st-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stea_btn_button_text',
            [
                'label'       => __( 'Button Text', 'st-elementor-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Click Me', 'st-elementor-addons' ),
                'placeholder' => __( 'Enter button text', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'stea_btn_button_url',
            [
                'label'       => __( 'Button URL', 'st-elementor-addons' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'Paste URL or Type', 'st-elementor-addons' ),
                'default'     => [
                    'url'         => '',
                    'is_external' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'stea_btn_style_section',
            [
                'label' => __( 'Style', 'st-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'stea_btn_typography',
				'selector' => '{{WRAPPER}} .stea-btn-wrap a',
			]
		);

        $this->add_control(
			'stea_text_color',
			[
				'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stea-btn-wrap a' => 'color: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'stea_bg_color',
			[
				'label' => esc_html__( 'BG Color', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stea-btn-wrap a' => 'background: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
            'stea_btn_alignment',
            [
                'label'       => __( 'Alignment', 'st-elementor-addons' ),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => __( 'Left', 'st-elementor-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'st-elementor-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'st-elementor-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'     => 'center',
                'toggle'      => true,
                'selectors' => [
					'{{WRAPPER}} .stea-btn-wrap' => 'text-align: {{VALUE}};',
				],
            ],
        );

        $this->add_responsive_control(
			'stea_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 20,
					'bottom' => 10,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-btn-wrap a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
       
        $this->add_responsive_control(
			'stea_btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-btn-wrap a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

    /**
     * Render widget output.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'button', 'class', 'stea-button' );

        if ( $settings['stea_btn_button_url']['url'] ) {
            $this->add_render_attribute( 'button', 'href', esc_url( $settings['stea_btn_button_url']['url'] ) );

            if ( $settings['stea_btn_button_url']['is_external'] ) {
                $this->add_render_attribute( 'button', 'target', '_blank' );
            }
        }

        echo '<div class="stea-btn-wrap">';
        echo '<a ' . wp_kses_post( $this->get_render_attribute_string( 'button' ) ) . '>';
        echo esc_html( $settings['stea_btn_button_text'] );
        echo '</a>';
        echo '</div>';

    }
}