<?php
/**
 * Class STEA_Widget\STEA_WC_Product_Price
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_WC_Product_Price extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_wc_product_price';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST WC Product Price', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-product-price';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'woocommerce-elements' ];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'price', 'product', 'sale' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

		// Tab: Content ==============
		// Section: General ----------
		$this->start_controls_section(
			'section_product_price',
			[
				'label' => esc_html__( 'General', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
            'product_price_align',
            [
                'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'label_block' => false,
                'options' => [
					'left'    => [
						'title' => __( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
                ],
				'selectors' => [
					'{{WRAPPER}} .stea-product-price' => 'text-align: {{VALUE}}',
				],
				'separator' => 'after'
            ]
        );

		$this->add_control(
			'product_price_tag',
			[
				'label' => esc_html__( 'Sale Price Display', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'inline' => esc_html__( 'Inline', 'st-elementor-addons' ),
					'separate' => esc_html__( 'Separate', 'st-elementor-addons' ),
				],
				'prefix_class' => 'stea-product-price-'
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Styles ====================
		// Section: Price ------------
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'  => esc_html__( 'Normal Price Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF9F2a',
				'selectors' => [
					'{{WRAPPER}} .stea-product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .stea-product-price',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '25',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->add_control(
			'price_sale_color',
			[
				'label'  => esc_html__( 'Sale Price Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#A3A3A3',
				'selectors' => [
					'{{WRAPPER}} .stea-product-price del' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_sale_typography',
				'selector' => '{{WRAPPER}} .stea-product-price del',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '18',
							'unit' => 'px',
						],
					],
				]
			]
		);

		$this->add_control(
			'price_sale_spacing',
			[
				'label' => __( 'Distance', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.stea-product-price-inline .stea-product-price ins' => 'margin-left: {{SIZE}}px',
					'{{WRAPPER}}.stea-product-price-separate .stea-product-price ins' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

	}

    /**
     * Render widget output.
     */
    protected function render() {
		// Get Settings
		$settings = $this->get_settings();

		// Get Product
		$product = wc_get_product();

		if ( ! $product ) {
			return;
		}

		// Output
		echo '<div class="stea-product-price">';
			echo $product->get_price_html();
		echo '</div>';

	}
}