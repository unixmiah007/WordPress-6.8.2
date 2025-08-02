<?php
/**
 * Class STEA_Widget\STEA_Product_Grid_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Product_Grid_Widget extends Widget_Base {

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
        return __( 'ST Product Grid', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-products';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }
    
    public function get_style_depends() {
		return array( 'stea-product-grid' );
	}

    public function get_script_depends() {
		return ['number-pagination', 'widget-product-grid', 'stea-wishlist-ajax'];
	}

  // Register controls start //
  protected function _register_controls() {

    $this->start_controls_section(
        'structure_section',
        [
            'label' => __( 'Structure', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $this->add_control(
        'product_card_design',
        [
            'label' => esc_html__( 'Select Product Card Design', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::VISUAL_CHOICE,
            'label_block' => true,
            'render_type' => 'template',
            'options' => [
                'product-card-1' => [
                    'title' => esc_attr__( 'Basic.', 'st-elementor-addons' ),
                    'image' => STEA_URL . 'assets/img/product-template/pro-card-1.svg',
                ],
                'product-card-2' => [
                    'title' => esc_attr__( 'Buttons On Hover', 'st-elementor-addons' ),
                    'image' => STEA_URL . 'assets/img/product-template/pro-card-2.svg',
                ]
            ],
            'default' => 'product-card-1',
            'columns' => 2,
            'prefix_class' => 'some-layout-',
        ]
    );
    
    $this->end_controls_section();

    $this->start_controls_section(
        'layout_section',
        [
            'label' => __( 'Layout', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );
    
    $this->add_control(
        'posts_per_page',
        [
            'label' => __( 'Posts Per Page', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 6,
        ]
    );

    $this->add_responsive_control(
        'columns',
        [
            'label' => __( 'Columns', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'max' => 6,
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-number-of-columns-to-show: {{VALUE}}',
            ],
        ]
    );

    $this->add_control(
        'alignment',
        [
            'label' => __( 'Alignment', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
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
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-card-alignment: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
    // Content End //

    // Query Section Start //
    $this->start_controls_section(
        'query_section',
        [
            'label' => __( 'Query', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $this->add_control(
        'product_filter_by',
        [
            'label' => esc_html__( 'Product Filter By', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'recent_products',
            'options' => [
                'current_query' => esc_html__( 'Current Query', 'st-elementor-addons' ),
                'recent_products' => esc_html__( 'Recent Products', 'st-elementor-addons' ),
                'related_products' => esc_html__( 'Related Products', 'st-elementor-addons' ),
                'custom_select'  => esc_html__( 'Custom Select', 'st-elementor-addons' ),
            ]
        ]
    );
     // Add Product Tag Search Control
    
     // get all product tags
        $terms = get_terms([
            'taxonomy' => 'product_tag',
            'hide_empty' => false, // Include all tags, even if they are not used
        ]);
    
        $options = [];
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
        }
    
    
     $this->add_control(
        'product_tag',
        [
            'label' => __('Product Tag', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple' => true,
            'options' => $options, // Dynamically populate options
        ]
    );
    // get all tags end //
    // Fetch product categories start //
    $product_categories = get_terms([
        'taxonomy' => 'product_cat', // WooCommerce product categories taxonomy
        'hide_empty' => false,       // Whether to hide categories without products
    ]);

    // Prepare options array
    $category_options = [];
    if ( ! is_wp_error( $product_categories ) ) {
        foreach ( $product_categories as $category ) {
            $category_options[ $category->slug ] = $category->name; // Use slug as key, name as label
        }
    }

    // Add control with dynamic categories
    $this->add_control(
        'product_categories',
        [
            'label' => esc_html__( 'Product Categories', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple' => true,
            'options' => $category_options, // Use dynamically generated options
            'default' => '', // Default to all categories
            'description' => esc_html__( 'Short Products By Categories.', 'st-elementor-addons' ),
        ]
    );
    // Fetch product categories End //

    $this->end_controls_section();
    // Query Section End //

    // Button Start //
    $this->start_controls_section(
        'button_add_to_cart_section',
        [
            'label' => __( 'Add To Cart', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );
    
    $this->add_control(
        'button_add_to_cart_title',
        [
            'label' => esc_html__( 'Button Text', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Add To Cart', 'st-elementor-addons' ),
            'placeholder' => esc_html__( 'Type your title here', 'st-elementor-addons' ),
        ]
    );

    $this->add_control(
        'button_add_to_cart_icon',
        [
            'label' => esc_html__( 'Icon', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fa-solid fa-cart-shopping',
                'library' => 'fa-solid',
            ],
            'recommended' => [
                'fa-solid' => [
                    'shopping-cart',
                    'dot-circle',
                    'square-full',
                ],
                'fa-regular' => [
                    'circle',
                    'dot-circle',
                    'square-full',
                ],
            ],
        ]
    );

    $this->end_controls_section();

    // Button End //

    // Pagination Section
    $this->start_controls_section(
        'pagination_section',
        [
            'label' => __( 'Pagination', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );
    
    $this->add_control(
        'enable_pagination',
        [
            'label' => __( 'Enable Pagination', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]
    );
    
    $this->add_control(
        'pagination_type',
        [
            'label' => __( 'Pagination Type', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'load_more',
            'options' => [
                'load_more' => __( 'Load More', 'st-elementor-addons' ),
                'page_numbers' => __( 'Page Numbers', 'st-elementor-addons' ),
            ],
            'condition' => [
			'enable_pagination' => 'yes',
		],
        ]
    );

    $this->end_controls_section();

    // Style Control Start //
    // Title Style Tab Start //
    $this->start_controls_section(
        'title_section',
        [
            'label' => __( 'Title', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'title_color',
        [
            'label' => __( 'Title Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#333',
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-title-color-to-show: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-title span',
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Text_Stroke::get_type(),
        [
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-title span',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Text_Shadow::get_type(),
        [
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-title span',
        ]
    );
    
    

    $this->end_controls_section();
    // Title Style Tab End //
    
    // Image Style Start //
    $this->start_controls_section(
        'image_section',
        [
            'label' => __( 'Image', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    
    $this->add_responsive_control(
        'width',
        [
            'label' => esc_html__( 'Width', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'height',
        [
            'label' => esc_html__( 'Height', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 5,
                ]
            ],
            'default' => [
                'unit' => 'px',
                'size' => 'auto',
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image img' => 'height: {{SIZE}}{{UNIT}};',
            ]
        ]
    );

    $this->add_responsive_control(
        'object_fit',
        [
            'label' => esc_html__( 'Object Fit', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                '' => esc_html__( 'Cover', 'st-elementor-addons' ),
                'contain' => esc_html__( 'Contain', 'st-elementor-addons' ),
                'fill'  => esc_html__( 'Fill', 'st-elementor-addons' ),
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image img' => 'object-fit: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_responsive_control(
        'border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-image, .stea-product-grid-product-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'border',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-image img',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'image_box_shadow',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-image img',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'background',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-grid-product-image',
        ]
    );
    
    $this->end_controls_section();
    // Image Style End //

    // Container Style Start //
    $this->start_controls_section(
        'product_card_section',
        [
            'label' => __( 'Product Card', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'spacing',
        [
            'label' => esc_html__( 'Spacing', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 20,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'card_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
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
                '{{WRAPPER}} .stea-product-grid .product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'card_border_radius',
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item',
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow',
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item',
        ]
    );

    $this->add_responsive_control(
        'card_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid .product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    

    $this->start_controls_tabs(
        'product_card_style_tabs'
    );

    $this->start_controls_tab(
        'product_card_style_normal_tab',
        [
            'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'card_background',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item',
        ]
    );

    $this->end_controls_tab();
    $this->start_controls_tab(
        'product_card_style_hover_tab',
        [
            'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'hover_card_background',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item:hover',
        ]
    );
    $this->add_control(
        'hover_card_border_hover_color',
        [
            'label' => esc_html__( 'Border Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid .product-item:hover' => 'border-color: {{VALUE}}',
            ],
        ]
    );
    $this->add_control(
        'hover_card_border_hover_color_transition',
        [
            'label' => esc_html__( 'Transition Duration', 'elementor' ) . ' (s)',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 3,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'size' => 0.5,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid .product-item' => 'transition-duration: {{SIZE}}s;',
            ],
        ]
    );
    
    $this->end_controls_tab();
    $this->end_controls_tabs();
    
    $this->end_controls_section();
    // Card Control End //

    // Price Control Start //
    $this->start_controls_section(
        'price_section',
        [
            'label' => __( 'Price', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    
    $this->add_control(
        'price_color',
        [
            'label' => __( 'Price Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff5722',
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-price-color-to-show: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_control(
        'regular_price_color',
        [
            'label' => __( 'Regular Price Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#A5A5A5',
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-regular-price-color-to-show: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_control(
        'regural_price_size',
        [
            'label' => esc_html__( 'Regural Price Size', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 5,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 12,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-price del' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'price_typography',
            'selector' => '{{WRAPPER}} .stea-product-grid-product-price',
        ]
    );

    $this->add_responsive_control(
        'price_margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();
    // Price Control End //

    // Rating Control Start //
    $this->start_controls_section(
        'stea_product_grid_rating_section',
        [
            'label' => __( 'Rating', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    
    $this->add_responsive_control(
        'stea_product_grid_rating_size',
        [
            'label' => esc_html__( 'Star Size', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 5,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'rating_color',
        [
            'label' => esc_html__( 'Star Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffcc00',
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-regular-star-color-to-show: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_control(
        'empty_star_color',
        [
            'label' => esc_html__( 'Empty Star Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-regular-empty-star-color-to-show: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_responsive_control(
        'star_margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'product_discount_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
             'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'product_cmt_count_typography',
            'selector' => '{{WRAPPER}} .product-card-2-rating-wrap .stea-product-cmt-count',
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );
    
    $this->add_control(
        'product_cmt_count_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-cmt-count' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'product_cmt_count_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .stea-product-cmt-count',
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );

    $this->add_responsive_control(
        'product_cmt_count_margin_left',
        [
            'label' => esc_html__( 'Margin Left', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                    'step' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 5,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-cmt-count' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );   

    $this->add_responsive_control(
        'product_cmt_count_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-cmt-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'product_cmt_count_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-cmt-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'product_cmt_count_border',
            'selector' => '{{WRAPPER}} .product-card-2-rating-wrap .stea-product-cmt-count',
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );
    $this->end_controls_section();
    
    // Discount Style Start
    $this->start_controls_section(
        'hover_wraper_style_tab',
        [
            'label' => __( 'Hover Image Wraper', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );
    $this->add_control(
        'hover_wraper_overlay_color',
        [
            'label' => esc_html__( 'Background Overlay Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0, 0, 0, 0.3)',
            'selectors' => [
                '{{WRAPPER}} .image-overlay' => 'background: {{VALUE}}',
            ],
        ]
    );
    $this->add_responsive_control(
        'hover_wraper_space_between_buttons',
        [
            'label' => esc_html__( 'Spacin Between Buttons', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} .hover-btn-wrap' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    $this->end_controls_section();


    // Discount Style Start
    $this->start_controls_section(
        'discount_style_tab',
        [
            'label' => __( 'Discount', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'product_card_design' => 'product-card-2',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'discount_typography',
            'selector' => '{{WRAPPER}} .product-card-2-discount-wrap .discount-badge',
        ]
    );
	
    $this->add_control(
        'discount_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .product-card-2-discount-wrap .discount-badge' => 'color: {{VALUE}}',
            ],
        ]
    );

	$this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'discount_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .product-card-2-discount-wrap',
        ]
    );

    $this->add_responsive_control(
        'discount_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .product-card-2-discount-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'discount_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .product-card-2-discount-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'discount_border',
            'selector' => '{{WRAPPER}} .product-card-2-discount-wrap .discount-badge',
        ]
    );

    $this->end_controls_section();
    
    // Add To Cart Control Start //
    $this->start_controls_section(
        'stea_product_grid_add_to_cart_style_section',
        [
            'label' => __( 'Add To Cart', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'add_to_cart_btn_typography',
            'selector' => '{{WRAPPER}} .stea-product-grid-add-to-cart-btn span',
        ]
    );
    $this->start_controls_tabs(
        'style_tabs'
    );

    $this->start_controls_tab(
        'style_normal_tab',
        [
            'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
        ]
    );
    $this->add_control(
        'add_to_cart_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-text-color-to-show: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'add_to_cart_btn_bg_color',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-grid-add-to-cart-btn',
        ]
    );
    $this->end_controls_tab();
    $this->start_controls_tab(
        'style_hover_tab',
        [
            'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
        ]
    );
    $this->add_control(
        'add_to_cart_text_color_hover',
        [
            'label' => esc_html__( 'Add To Cart Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-text-color-to-show-on-hover: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'add_to_cart_btn_bg_color_hover',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-grid-add-to-cart-btn:hover',
        ]
    );

    $this->add_control(
        'add_to_cart_text_border_color_hover',
        [
            'label' => esc_html__( 'Border Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--stea-product-grid-border-color-to-show-on-hover: {{VALUE}}',
            ],
        ]
    );
    $this->end_controls_tab();
    $this->end_controls_tabs();

	$this->add_responsive_control(
        'add_to_cat_btn_icon_size',
        [
            'label' => esc_html__( 'Icon Size', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-add-to-cart-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );	
    
    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'add_to_cart_btn_border',
            'selector' => '{{WRAPPER}} .stea-product-grid-add-to-cart-btn',
        ]
    );

    $this->add_responsive_control(
        'add_to_cart_btn_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 5,
                'right' => 5,
                'bottom' => 5,
                'left' => 5,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-add-to-cart-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'add_to_cart_btn_padding',
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
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-add-to-cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'add_to_cart_btn_margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .add-to-cart-btn-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'add_to_cart_btn_icon_margin',
        [
            'label' => esc_html__( 'Icon Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 7,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-add-to-cart-btn i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();

    // Wishlist Control Start //
    $this->start_controls_section(
        'stea_product_grid_wishlist_btn_style_section',
        [
            'label' => __( 'Wishlist Button', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'wishlist_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-add-to-wishlist i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_responsive_control(
        'wishlist_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 5,
                'right' => 5,
                'bottom' => 5,
                'left' => 5,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-add-to-wishlist' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_control(
        'wishlist_icon_color_active',
        [
            'label' => esc_html__( 'Added To Wishlist', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .add-to-wishlist-btn-wrap .added i' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->start_controls_tabs(
        'wishlist_style_tabs'
    );
    $this->start_controls_tab(
        'wishlist_style_normal_tab',
        [
            'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
        ]
    );

    $this->add_control(
        'wishlist_icon_color',
        [
            'label' => esc_html__( 'Icon Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .add-to-wishlist-btn-wrap i' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'wishlist_wrap_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item .add-to-wishlist-btn-wrap .stea-add-to-wishlist',
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'wishlist_style_hover_tab',
        [
            'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
        ]
    );

    $this->add_control(
        'wishlist_icon_color_hover',
        [
            'label' => esc_html__( 'Icon Hover Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .add-to-wishlist-btn-wrap:hover i' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'wishlist_wrap_background_hover',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .stea-product-grid .product-item .add-to-wishlist-btn-wrap .stea-add-to-wishlist:hover',
        ]
    );
    $this->end_controls_tab();
    $this->end_controls_tabs();
    
    $this->end_controls_section();
}

    /**
    * Render widget output.
    */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : '1';
        $product_categories = $settings['product_categories'];
        $product_tags = $settings['product_tag'];
        $button_add_to_cart_icon = $settings['button_add_to_cart_icon'];
        $button_icon_data = wp_json_encode($button_add_to_cart_icon);
        $add_to_cart_btn_text = $settings['button_add_to_cart_title'];
        $product_card_design = $settings['product_card_design'];
        $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : $settings['posts_per_page'];
    
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
        ];

        $tax_query_array = array(
            'relation' => 'AND'
          );
        
        // Handle product filtering
        switch ($settings['product_filter_by']) {
            case 'current_query':
                $category = get_queried_object();
                $category_id = $category->term_id;
                array_push( $tax_query_array, array(
                    'taxonomy'  =>  'product_cat',
                    'field'     =>  'term_id',
                    'terms'     =>  $category_id
                  ));
                break;
                
            case 'recent_products':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
                
            case 'related_products':
                if (is_singular('product')) {
                    $current_product_id = get_the_ID();
                    $related_ids = wc_get_related_products($current_product_id);
                    $args['post__in'] = $related_ids;
                } else {
                    $args['orderby'] = 'date';
                    $args['order'] = 'DESC';
                }
                break;
                
            case 'custom_select':
                // Custom select will use the tax queries below
                break;
        }
        
        $args['tax_query'] = $tax_query_array;
        
        $query = new \WP_Query($args);
    
        if ($query->have_posts()) {
            ob_start();
            $product_categories = (array) $product_categories;
            echo '<span class="stea-current-product-category" 
                    data-current-product-category="' . esc_attr(implode(', ', $product_categories)) . '" 
                    data-button-title="' . esc_attr($add_to_cart_btn_text) . '" 
                    data-button-icon=\'' . esc_attr($button_icon_data) . '\'>
                  </span>';
                  if ($settings['product_filter_by'] === 'current_query' && is_archive()) {
                      $category = get_queried_object();
                      $category_id = $category->term_id;            
                      echo '<span class="stea-archive-product-page" 
                          data-current-query-term="' . esc_attr($category_id) . '"></span>';
                  }
                  if ($settings['product_filter_by'] === 'related_products' && is_singular('product')) {
                        $current_product_id = get_the_ID();
                        $related_ids = wc_get_related_products($current_product_id);       
                        echo '<span class="stea-single-product-page" 
                        data-related-pro-ids=\'' . esc_attr(json_encode($related_ids)) . '\'></span>';
                  }
            echo '<div class="stea-product-grid" data-posts-per-page="' . esc_attr($settings['posts_per_page']) . '" data-filter-by="' . esc_attr($settings['product_filter_by']) . '" data-pagination-type="' . esc_attr($settings['pagination_type']) . '"data-product-card="' . esc_attr($product_card_design) . '">';
            
            $template_path = STEA_PATH . 'templates/products/stea-' . $product_card_design . '.php';
            while ($query->have_posts()) {
                $query->the_post();
                global $product;
                // include STEA_PATH . 'templates/products/stea-' . $product_card_design . '.php';

                if ( file_exists( $template_path ) ) {
                    include $template_path;
                } else {
                    echo '<p>' . esc_html__( 'Product template not found: ', 'st-elementor-addons' ) . esc_html( $product_card_design ) . '</p>';
                }

            }
    
            echo '</div>';
            
            if ($settings['enable_pagination'] === 'yes') {
                if ($settings['pagination_type'] === 'load_more') {
                    echo '<div class="stea-product-grid-load-more-wrap">';
                    echo '<button id="load-more-products" class="button load-more-products" data-page="1">' . __('Load More', 'st-elementor-addons') . '</button>';
                    echo '</div>';
                } elseif ($settings['pagination_type'] === 'page_numbers') {
                    echo '<div class="stea-pagination">';
                    for ($i = 1; $i <= $query->max_num_pages; $i++) {
                        echo '<button class="pagination-button" data-page="' . $i . '">' . $i . '</button>';
                    }
                    echo '</div>';
                }
            }

            wp_reset_postdata();
            ob_end_flush();
        } else {
            echo '<p>' . __('No products found.', 'st-elementor-addons') . '</p>';
        }
    }


}