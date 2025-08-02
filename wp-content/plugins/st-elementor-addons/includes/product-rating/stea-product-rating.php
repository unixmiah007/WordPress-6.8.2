<?php
/**
 * Class STEA_Widget\STEA_Product_Rating_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Product_Rating_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_product_rating';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Product Rating', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-product-rating';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
		return ['stea-product-rating'];
	}
    /**
     * Register widget controls.
     */
    protected function register_controls() {

		$this->start_controls_section(
			'section_product_rating',
			[
				'label' => esc_html__( 'Styles', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_rating_layout',
			[
				'label' => esc_html__( 'Layout', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'flex' => esc_html__('Horizontal', 'st-elementor-addons'),
					'block' => esc_html__('Vertical', 'st-elementor-addons'),
				],
                'prefix_class' => 'stea-product-rating-',
                'selectors' => [
                    '{{WRAPPER}} .stea-product-rating' => 'display: {{VALUE}}; align-items: center;'
                ],
				'default' => 'flex',
			]
		);

		$this->add_control(
			'product_rating_show_text',
			[
				'label' => esc_html__( 'Show Text', 'st-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'stea-pr-show-text-'
			]
		);

		$this->add_responsive_control(
			'product_rating_alignment',
			[
				'label'        => esc_html__('Alignment', 'st-elementor-addons'),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => esc_html__('Left', 'st-elementor-addons'),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__('Center', 'st-elementor-addons'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__('Right', 'st-elementor-addons'),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'prefix_class' => 'stea-product-rating-',
				'default'      => 'left',
                'selectors' => [
                    '{{WRAPPER}}.stea-product-rating-block .stea-woo-rating' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}}.stea-product-rating-block .woocommerce-review-link' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}}.stea-product-rating-flex .stea-product-rating' => 'justify-content: {{VALUE}};'
                ],
				'separator'    => 'after',
			]
		);

		$this->add_control(
			'product_rating_color',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffd726',
				'selectors' => [
					'{{WRAPPER}} .stea-woo-rating i:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_rating_unmarked_color',
			[
				'label' => esc_html__( 'Unmarked Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D2CDCD',
				'selectors' => [
					'{{WRAPPER}} .stea-woo-rating i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stea-woo-rating svg' => 'fill: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'product_rating_text_color',
			[
				'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#787878',
				'selectors' => [
					'{{WRAPPER}} a.woocommerce-review-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_rating_text_color_hover',
			[
				'label' => esc_html__( 'Text Hover Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#787878',
				'selectors' => [
					'{{WRAPPER}} a.woocommerce-review-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_rating_typography',
				'selector' => '{{WRAPPER}} .stea-product-rating .woocommerce-review-link',
				'fields_options' => [
					'typography' => [
						'default' => 'custom',
					],
					'font_size' => [
						'default' => [
							'size' => '13',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->add_control(
			'product_rating_tr_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'st-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.1,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .stea-product-rating .woocommerce-review-link' => 'transition-duration: {{VALUE}}s;'
				],
			]
		);

		$this->add_control(
			'product_rating_size',
			[
				'label' => esc_html__( 'Icon Size', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
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
					'{{WRAPPER}} .stea-woo-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-woo-rating svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_rating_gutter',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Gutter', 'st-elementor-addons' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-woo-rating i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-woo-rating span' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_rating_spacing',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Label Distance', 'st-elementor-addons' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}}.stea-product-rating-flex .stea-product-rating a.woocommerce-review-link' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.stea-product-rating-block .stea-product-rating a.woocommerce-review-link' => 'margin-top: {{SIZE}}{{UNIT}}; display: block;',
				],
				'separator' => 'after'
			]
		);

        $this->end_controls_section();

		// Section: Request New Feature
    }

    /**
     * Render widget output.
     */
    public function render_product_rating( $settings ) {
		global $product;

		// If NOT a Product
		if ( is_null( $product ) ) {
			return;
		}

        $rating_count = $product->get_rating_count();
		$rating_amount = floatval( $product->get_average_rating() );
		$round_rating = (int)$rating_amount;
        $rating_icon = '&#9734;';

		echo '<div class="stea-woo-rating">';

			for ( $i = 1; $i <= 5; $i++ ) {
				if ( $i <= $rating_amount ) {
					echo '<i class="stea-rating-icon-full">'. $rating_icon .'</i>';
				} elseif ( $i === $round_rating + 1 && $rating_amount !== $round_rating ) {
					echo '<i class="stea-rating-icon-'. ( $rating_amount - $round_rating ) * 10 .'">'. $rating_icon .'</i>';
				} else {
					echo '<i class="stea-rating-icon-empty">'. $rating_icon .'</i>';
				}
	     	}

		echo '</div>';
		?>

        <a href="#reviews" class="woocommerce-review-link" rel="nofollow">
            (<?php printf( _n( '%s customer review', '%s customer reviews', 10, 'st-elementor-addons' ), '<span class="count">' . esc_html( $rating_count ) . '</span>' ); ?>)
        </a>

		<?php
	}

    protected function render() {
        // Get Settings
        $settings = $this->get_settings_for_display();
        global $product;

        $product = wc_get_product();

        if ( empty( $product ) ) {
            return;
        }

        setup_postdata( $product->get_id() );

        echo '<div class="stea-product-rating">';
            $this->render_product_rating($settings);
        echo '</div>';
    }
}