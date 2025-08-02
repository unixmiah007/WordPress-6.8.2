<?php
/**
 * Class STEA_Widget\STEA_Add_To_Cart_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Add_To_Cart_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_add_to_cart';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Add To Cart', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-product-add-to-cart';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'woocommerce-elements' ];
    }

    public function get_script_depends() {
		return ['wc-add-to-cart', 'wc-add-to-cart-variation', 'wc-single-product','stea-common-widget'];
	}

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cart', 'product', 'button', 'add to cart' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

		// Tab: Content ==============
		// Section: General ----------
		$this->start_controls_section(
			// 'section_product_title',
			'section_add_to_cart_general',
			[
				'label' => esc_html__( 'General', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'add_to_cart_layout',
			[
				'label' => esc_html__( 'Select Layout', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'vertical',
				'label_block' => false,
				'options' => [
					'column' => [
						'title' => esc_html__( 'Vertical', 'st-elementor-addons' ),
						'icon' => 'eicon-editor-list-ul',
					],
					'row' => [
						'title' => esc_html__( 'Horizontal', 'st-elementor-addons' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'prefix_class' => 'stea-add-to-cart-layout-',
				'selectors_dictionary' => [
					'row' => 'display: flex; align-items: center;',
					'column' => 'display: flex; flex-direction: column;',
				],
                'selectors' => [
                    '{{WRAPPER}} .stea-product-add-to-cart .cart' => '{{VALUE}};'
                ],
				'default' => 'column',
				'separator' => 'before'
			]
		);

        $this->add_responsive_control(
            'add_to_cart_alignment',
            [
                'label'     => esc_html__('Text Align', 'st-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'st-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'st-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'st-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .stea-product-add-to-cart .cart' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .single_variation_wrap' => 'text-align: {{VALUE}}',
                ],
				'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'add_to_cart_button_alignment',
            [
                'label'     => esc_html__('Button Horizontal Align', 'st-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'st-elementor-addons'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'st-elementor-addons'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'st-elementor-addons'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'stea-product-adc-align-',
                'default'   => 'left',
				'condition' => [
					'add_to_cart_layout' => 'column'
				]
            ]
        );

        $this->add_responsive_control(
            'add_to_cart_buttons_vr',
            [
                'label'     => esc_html__('Button Vertical Align', 'st-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'end'   => [
                        'title' => esc_html__('Top', 'st-elementor-addons'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'st-elementor-addons'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'start'  => [
                        'title' => esc_html__('Bottom', 'st-elementor-addons'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .stea-product-add-to-cart .cart button' => 'align-self: {{VALUE}}',
                    '{{WRAPPER}} .single_variation_wrap' => 'align-self: {{VALUE}}',
                ],
				'condition' => [
					'add_to_cart_layout' => 'row'
				]
            ]
        );

		$this->add_control( 
			'add_to_cart_variations_layout',
			[
				'label' => esc_html__( 'Choose An Option Display', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'row' => esc_html__( 'Inline', 'st-elementor-addons' ),
					'column' =>  esc_html__( 'Separate', 'st-elementor-addons' )
				],
				'prefix_class' => 'stea-variations-layout-',
				'selectors_dictionary' => [
					'row' => '',
					'column' => 'display: flex; flex-direction: column;',
				],
                'selectors' => [
                    '{{WRAPPER}} .variations tr' => '{{VALUE}};',
                ],
				'default' => 'column',
				'separator' => 'before'
			]
		);

		$this->add_control(
			// 'product_buttons_layout',
			'add_to_cart_buttons_layout',
			[
				'label' => esc_html__( 'Button Display', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'row' => esc_html__( 'Inline', 'st-elementor-addons' ),
					'column' => esc_html__( 'Separate', 'st-elementor-addons' ),
				],
				'prefix_class' => 'stea-buttons-layout-',
				'selectors_dictionary' => [
					'row' => 'flex-direction: row;',
					'column' => 'flex-direction: column;',
				],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-stea-product-add-to-cart .woocommerce-variation-add-to-cart' => '{{VALUE}};',
                    '{{WRAPPER}} .stea-product-add-to-cart .stea-simple-qty-wrap' => 'display: flex; {{VALUE}};'
                ],
				'default' => 'row',
			]
		);

        $this->add_control(
            'quantity_btn_position',
            [
                'label'   => esc_html__('Quantity Input Style', 'st-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'after',
				'prefix_class' => 'stea-product-qty-align-',
                'options' => [
                    'default' => esc_html__('Default (Browser)', 'st-elementor-addons'),
                    'before' => esc_html__('Triggers Left', 'st-elementor-addons'),
                    'after' => esc_html__('Triggers Right', 'st-elementor-addons'),
                    'both' => esc_html__('Triggers Left-Right', 'st-elementor-addons'),
                ],
				'render_type' => 'template',
            ]
        );

		$this->end_controls_section(); // End Controls Section

		// Styles ====================
		$this->start_controls_section(
			'section_style_quantity',
			[
				'label' => esc_html__( 'Add to Cart Quantity', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_quantity_style' );

		$this->start_controls_tab(
			'tab_quantity_normal',
			[
				'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'quantity_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#787878',
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'quantity_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'quantity_border_color',
			[
				'label'  => esc_html__( 'Border Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E0E0E0',
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'quantity_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'st-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.5,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'transition-duration: {{VALUE}}s',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_quantity_hover',
			[
				'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'quantity_color_hr',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9F2a',
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'quantity_bg_color_hr',
			[
				'label'  => esc_html__( 'Background Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty:hover' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'quantity_dimensions',
			[
				'label' => esc_html__( 'Quantity', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'quantity_size',
			[
				'label' => esc_html__( 'Font Size', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'add_to_cart_quantity_height',
			[
				'label' => esc_html__( 'Height', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 43,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'height: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}}.stea-product-qty-align-both .stea-product-add-to-cart .stea-quantity-wrapper i' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'add_to_cart_quantity_width',
			[
				'label' => esc_html__( 'Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 91,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'add_to_cart_quantity_distance',
			[
				'label' => esc_html__( 'Distance', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}}.stea-buttons-layout-row .stea-product-add-to-cart .stea-simple-qty-wrap .stea-quantity-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-buttons-layout-column .stea-product-add-to-cart .stea-simple-qty-wrap .stea-quantity-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-buttons-layout-row .stea-product-add-to-cart .variations_button .stea-quantity-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-buttons-layout-column .stea-product-add-to-cart .variations_button .stea-quantity-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'quantity_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'border-style: {{VALUE}};'
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'quantity_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .stea-quantity-wrapper i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart .quantity .qty' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'quantity_border_type!' => 'none',
				]
			]
		);

        $this->add_control(
            'quantity_radius',
            [
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-product-add-to-cart .quantity input.qty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

		$this->end_controls_section();

		// Styles ====================
		// Section: Add to Cart Button
		$this->start_controls_section(
			'section_style_add_to_cart',
			[
				'label' => esc_html__( 'Add to Cart Button', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_add_to_cart_style' );

		$this->start_controls_tab(
			'tab_add_to_cart_normal',
			[
				'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'add_to_cart_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart a.added_to_cart' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'add_to_cart_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9F2a',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart a.added_to_cart' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'add_to_cart_border_color',
			[
				'label'  => esc_html__( 'Border Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'border-color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'add_to_cart_box_shadow',
				'selector' => '{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button, {{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart,',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'add_to_cart_typography',
				'selector' => '{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button, {{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '16',
							'unit' => 'px',
						],
					],
				]
			]
		);

		$this->add_control(
			'add_to_cart_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'st-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.5,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button' => 'transition-duration: {{VALUE}}'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_add_to_cart_hover',
			[
				'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'add_to_cart_color_hr',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button:hover' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'add_to_cart_bg_color_hr',
			[
				'label'  => esc_html__( 'Background Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fb8900',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button:hover' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'add_to_cart_border_color_hr',
			[
				'label'  => esc_html__( 'Border Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button:hover' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart:hover' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item .button:hover' => 'border-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'add_to_cart_box_shadow_hr',
				'selector' => '{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button:hover, {{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'add_to_cart_width',
			[
				'label' => esc_html__( 'Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 165,
				],
				'selectors' => [
					'{{WRAPPER}}  .stea-product-add-to-cart .single_add_to_cart_button' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'width: {{SIZE}}{{UNIT}};'
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'add_to_cart_height',
			[
				'label' => esc_html__( 'Height', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 43,
				],
				'selectors' => [
					'{{WRAPPER}}  .stea-product-add-to-cart .single_add_to_cart_button' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'table_distance',
			[
				'label' => esc_html__( 'Distance', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}}.stea-add-to-cart-layout-row table' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-add-to-cart-layout-column table' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-add-to-cart-layout-row .stea-product-add-to-cart form.cart .woocommerce-variation-add-to-cart' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-add-to-cart-layout-column .stea-product-add-to-cart form.cart .woocommerce-variation-add-to-cart' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'add_to_cart_margin',
			[
				'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'add_to_cart_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'border-style: {{VALUE}};'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'add_to_cart_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'add_to_cart_border_type!' => 'none',
				]
			]
		);

		$this->add_control(
			'add_to_cart_radius',
			[
				'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stea-product-add-to-cart  a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Styles ====================
		// Section: Grouped -------
		$this->start_controls_section(
			'section_grouped_styles',
			[
				'label' => esc_html__( 'Grouped Product', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'add_to_cart_group',
			[
				'label'     => esc_html__('Variable Product', 'st-elementor-addons'),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'add_to_cart_group_odd_bg_color',
			[
				'label'     => esc_html__('Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFFF7',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list tr.woocommerce-grouped-product-list-item td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_group_even_bg_color',
			[
				'label'     => esc_html__('Even Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list tr.woocommerce-grouped-product-list-item:nth-child(even) td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_group_border_color',
			[
				'label'     => esc_html__('Border Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list tr.woocommerce-grouped-product-list-item td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'group_title_heading',
			[
				'label' => esc_html__( 'Title', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'grouped_title_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list-item__label a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-grouped-product-list-item__label label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grouped_title_typography',
				'selector' => '{{WRAPPER}} .woocommerce-grouped-product-list-item__label a, {{WRAPPER}} .woocommerce-grouped-product-list-item__label label, {{WRAPPER}} .woocommerce-grouped-product-list-item .button',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '',
							'unit' => 'px',
						],
					],
				]
			]
		);

		$this->add_control(
			'grouped_price_heading',
			[
				'label' => esc_html__( 'Price', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'grouped_price_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list-item__price span' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grouped_price_typography',
				'selector' => '{{WRAPPER}} .woocommerce-grouped-product-list-item__price span',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '',
							'unit' => 'px',
						],
					],
				]
			]
		);

		$this->add_control(
			'grouped_table_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list tr.woocommerce-grouped-product-list-item td' => 'border-style: {{VALUE}};'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'grouped_table_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-grouped-product-list tr.woocommerce-grouped-product-list-item td' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'grouped_table_border_type!' => 'none',
				]
			]
		);

		$this->add_responsive_control(
			'grouped_product_padding',
			[
				'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 12,
					'right' => 12,
					'bottom' => 12,
					'left' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart form.cart .group_table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		// Styles ====================
		// Section: Variations -------
		$this->start_controls_section(
			'section_variation_styles',
			[
				'label' => esc_html__( 'Variable Product', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'add_to_cart_label',
			[
				'label'     => esc_html__('Attribute Name', 'st-elementor-addons'),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'add_to_cart_label_color',
			[
				'label'     => esc_html__('Label Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .variations th label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_label_border_color',
			[
				'label'     => esc_html__('Border Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} form.cart .variations th' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} form.cart .variations td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_label_odd_bg_color',
			[
				'label'     => esc_html__('Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFFF2',
				'selectors' => [
					'{{WRAPPER}} .variations tr th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_label_even_bg_color',
			[
				'label'     => esc_html__('Even Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .variations tr:nth-child(even) th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'add_to_cart_variation_names',
				'selector' => '{{WRAPPER}} .variations th.label label',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '15',
							'unit' => 'px',
						],
					],
				]
			]
		);

		$this->add_responsive_control(
			'variation_name_padding',
			[
				'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 10,
					'right' => 7,
					'bottom' => 7,
					'left' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .variations th.label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'add_to_cart_value',
			[
				'label'     => esc_html__('Attribute Value', 'st-elementor-addons'),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'add_to_cart_value_odd_bg_color',
			[
				'label'     => esc_html__('Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .variations tr td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_value_even_bg_color',
			[
				'label'     => esc_html__('Even Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .variations tr:nth-child(even) td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'variations_table_label_width',
			[
				'label' => esc_html__( 'Label Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}}.stea-variations-layout-row .variations tr th' => 'width: {{SIZE}}%;',
					'{{WRAPPER}}.stea-variations-layout-column .variations tr th' => 'width: {{SIZE}}%;',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'variations_table_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} form.cart .variations td' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} form.cart .variations th' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variations_table_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} form.cart .variations td' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} form.cart .variations th' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'variations_table_border_type!' => 'none',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section

		$this->start_controls_section(
			'section_style_variations_select',
			[
				'label' => esc_html__( 'Variations Select', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		
		$this->start_controls_tabs(
			'variation_select_style_tabs'
		);
		
		$this->start_controls_tab(
			'variation_select_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_color',
			[
				'label'     => esc_html__('Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#787878',
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_border_color',
			[
				'label'     => esc_html__('Border Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_bg_color',
			[
				'label'     => esc_html__('Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'add_to_cart_variation_select',
				'selector' => '{{WRAPPER}} .variations select, {{WRAPPER}} .variations option',
			]
		);

		$this->add_control(
			'variations_select_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'border-style: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'variations_select_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'variations_select_border_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'variation_select_focus_tab',
			[
				'label' => esc_html__( 'Focus', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_color_focus',
			[
				'label'     => esc_html__('Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#787878',
				'selectors' => [
					'{{WRAPPER}} .variations select:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_border_color_focus',
			[
				'label'     => esc_html__('Border Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#787878',
				'selectors' => [
					'{{WRAPPER}} .variations select:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'add_to_cart_variation_dropdown_bg_color_focus',
			[
				'label'     => esc_html__('Background Color', 'st-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .variations select:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'variations_select_border_type_focus',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .variations select:focus' => 'border-style: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'variations_select_border_width_focus',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .variations select:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'variations_select_border_type_focus!' => 'none',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'variation_select_width',
			[
				'label' => esc_html__( 'Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} form.cart .variations select' => 'width: {{SIZE}}{{UNIT}};'
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'variation_select_padding',
			[
				'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'variation_select_margin',
			[
				'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} form.cart .variations select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; width: calc(100% - ({{RIGHT}}{{UNIT}} + {{LEFT}}{{UNIT}}));',
				]
			]
		);

		$this->add_control(
			'variations_select_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .variations select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section(); // variations select section

		$this->start_controls_section(
			'section_style_variations_description',
			[
				'label' => esc_html__( 'Variations Item Info', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'variation_description_heading',
			[
				'label' => esc_html__( 'Description', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variation_description_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#787878',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-description p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'variation_description_typography',
				'selector' => '{{WRAPPER}} .woocommerce-variation-description p',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->add_control(
			'variation_description_alignment',
			[
				'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-description p' => 'text-align: {{VALUE}}'
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variation_price_heading',
			[
				'label' => esc_html__( 'Price', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variation_price_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9F2a',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-price span' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'variation_price_typography',
				'selector' => '{{WRAPPER}} .woocommerce-variation-price span',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->add_control(
			'variation_price_alignment',
			[
				'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
				'description' => esc_html__('For Variable Products Only', 'st-elementor-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-price' => 'text-align: {{VALUE}}'
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variation_availability_heading',
			[
				'label' => esc_html__( 'Availability', 'st-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'variation_availability_color_in_stock',
			[
				'label'  => esc_html__( 'In Stock Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9F2a',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-availability p.stock' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-variation-availability p.in-stock' => 'color: {{VALUE}}',
					'{{WRAPPER}} p.stock' => 'color: {{VALUE}}',
					'{{WRAPPER}} p.in-stock' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'variation_availability_color_out_of_stock',
			[
				'label'  => esc_html__( 'Out of Stock Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF4F40',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-availability p.stock.out-of-stock' => 'color: {{VALUE}}',
					'{{WRAPPER}} p.stock.out-of-stock' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'variation_availability_typography',
				'selector' => '{{WRAPPER}} .woocommerce-variation-availability p.stock, {{WRAPPER}} .woocommerce-variation-availability p.stock'
			]
		);

		$this->add_control(
			'variation_availability_alignment',
			[
				'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-variation-availability p.stock' => 'text-align: {{VALUE}}'
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Styles ====================
		// Section: Reset Options Button
		$this->start_controls_section(
			'section_style_reset',
			[
				'label' => esc_html__( 'Reset Options Button', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'reset_color',
			[
				'label'  => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#CECECE',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'reset_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'reset_border_color',
			[
				'label'  => esc_html__( 'Border Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'reset_typography',
				'selector' => '{{WRAPPER}} .stea-product-add-to-cart .reset_variations',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '16',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'reset_padding',
			[
				'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 10,
					'bottom' => 0,
					'left' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'reset_margin',
			[
				'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'reset_border_type',
			[
				'label' => esc_html__( 'Border Type', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'st-elementor-addons' ),
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
					'groove' => esc_html__( 'Groove', 'st-elementor-addons' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'reset_border_width',
			[
				'label' => esc_html__( 'Border Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'reset_border_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'reset_radius',
			[
				'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-add-to-cart .reset_variations' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}
    
    function custom_wc_add_to_cart_message( $message, $product_id ) { 
        $message = sprintf(esc_html__('%s has been added to your cart. Thank you for shopping!','st-elementor-addons'), get_the_title( $product_id ) ); 
        return $message; 
    }
    
    /**
     * Get products list
     */
    // private function get_products() {
    //     $products = [];
        
    //     $args = [
    //         'post_type' => 'product',
    //         'posts_per_page' => -1,
    //         'post_status' => 'publish',
    //     ];
        
    //     $query = new \WP_Query($args);
        
    //     if ($query->have_posts()) {
    //         while ($query->have_posts()) {
    //             $query->the_post();
    //             $products[get_the_ID()] = get_the_title();
    //         }
    //     }
        
    //     wp_reset_postdata();
        
    //     return $products;
    // }
    
    /**
     * Render widget output.
     */
    protected function render() {
        // Get Settings
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute(
            'add_to_cart_wrapper',
            [
                'id' => 'add-to-cart-attributes',
                'class' => [ 'stea-product-add-to-cart' ],
                'layout-settings' => $settings['quantity_btn_position']
            ]
        );
    
        // Get Product
		global $product;
        $product = wc_get_product();
		
		if ( ! $product ) return;
		
        if ( ! $product ) {
            return;
        }
    
        $btn_arg = [
            'position' => $settings['quantity_btn_position']
        ];
    
        add_action('woocommerce_before_add_to_cart_quantity', function () use ($btn_arg, $product) {
            if ($product->is_type('simple')) {
                echo '<div class="stea-simple-qty-wrap">';
            }
            echo '<div class="stea-quantity-wrapper">';
    
            
        });
    
        add_action('woocommerce_after_add_to_cart_quantity', function () use ($btn_arg) {
          
    
            echo '</div>';
        });
    
        add_action('woocommerce_after_add_to_cart_button', function () use ($product) {
            if ($product->is_type('simple')) {
                echo '</div>';
            }
        });
    
        do_action( 'woocommerce_before_single_product' );
        
        add_filter( 'wc_add_to_cart_message', 'custom_wc_add_to_cart_message', 10, 2 );
    
        echo '<div '. $this->get_render_attribute_string( 'add_to_cart_wrapper' ) .'>';
            woocommerce_template_single_add_to_cart();
        echo '</div>';
    }
    
    /**
     * Render form button (with quantity)
     */
    private function render_form_button($product) {
        if (!$product && current_user_can('manage_options')) {
            echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__('Please set a valid product', 'st-elementor-addons') . '</div>';
            return;
        }
    
        $settings = $this->get_settings_for_display();
    
        // Add filter to modify the button text
        add_filter('woocommerce_product_single_add_to_cart_text', function() use ($settings) {
            return $settings['button_text'];
        });
    
        // Render the WooCommerce add to cart form
        ob_start();
        woocommerce_template_single_add_to_cart();
        $form = ob_get_clean();
        
        // Add elementor button class to the submit button
        $form = str_replace('single_add_to_cart_button', 'single_add_to_cart_button elementor-button', $form);
        
        echo $form;
    
        // Remove the filter after rendering
        remove_all_filters('woocommerce_product_single_add_to_cart_text');
    }
}