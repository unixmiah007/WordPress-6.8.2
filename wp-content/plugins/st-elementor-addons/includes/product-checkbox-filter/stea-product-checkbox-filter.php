<?php
/**
 * Class STEA_Widget\STEA_Product_Checkbox_Filter_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Product_Checkbox_Filter_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_product_checkbox_filter';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Product Checkbox Filter', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-checkbox';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
		return array( 'stea-product-checkbox-filter' );
	}

    public function get_script_depends() {
		return array( 'stea-product-checkbox-filter' );
	}

    /**
     * Register widget controls.
     */
    protected function register_controls() {
    // Content Section Start //
    // Layout Start //
    $this->start_controls_section(
        'layout_section',
        [
            'label' => __( 'Layout', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $this->add_control(
        'show_count',
        [
            'label' => esc_html__( 'Show Count', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Show', 'st-elementor-addons' ),
            'label_off' => esc_html__( 'Hide', 'st-elementor-addons' ),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $this->add_responsive_control(
        'count_spacing',
        [
            'label' => esc_html__( 'Count Gap', 'st-elementor-addons' ),
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
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-product-category-filter-checkbox li' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'list_spacing',
        [
            'label' => esc_html__( 'Gap Between Items', 'st-elementor-addons' ),
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
                '{{WRAPPER}} .stea-product-category-filter-checkbox' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'cout_setting_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
            'condition' => [
			'show_count' => 'yes',
            ],
        ]
    );

    $this->add_responsive_control(
        'text_jspacing',
        [
            'label' => esc_html__( 'Gap Between Text & Count', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'condition' => [
			'show_count' => 'yes',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
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
                '{{WRAPPER}} .item-text-wrap' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'text_justify_content',
        [
            'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'label_block' => true,
            'condition' => [
			'show_count' => 'yes',
            ],
            'options' => [
                'start' => [
                    'title' => esc_html__( 'Start', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-start-h',
                ],
                'center' => [
                    'title' => esc_html__( 'Center', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-center-h',
                ],
                'end' => [
                    'title' => esc_html__( 'End', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-end-h',
                ],
                'space-between' => [
                    'title' => esc_html__( 'Space Between', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-space-between-h',
                ],
                'space-around' => [
                    'title' => esc_html__( 'Space Around', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-space-around-h',
                ],
                'space-evenly' => [
                    'title' => esc_html__( 'Space Evenly', 'st-elementor-addons' ),
                    'icon' => 'eicon-justify-space-evenly-h',
                ],
            ],
            'default' => 'space-between',
            'toggle' => true,
            'selectors' => [
                '{{WRAPPER}} .item-text-wrap' => 'justify-content: {{VALUE}};',
            ],
        ]
    );
    $this->end_controls_section();
    
    // Filter Tab Start //
    $this->start_controls_section(
        'filter_section',
        [
            'label' => __( 'Filter', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $this->add_control(
        'show_search_filter',
        [
            'label' => esc_html__( 'Show Search', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Show', 'st-elementor-addons' ),
            'label_off' => esc_html__( 'Hide', 'st-elementor-addons' ),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $this->add_control(
        'show_show_more',
        [
            'label' => esc_html__( 'Show More', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Show', 'st-elementor-addons' ),
            'label_off' => esc_html__( 'Hide', 'st-elementor-addons' ),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $this->add_control(
        'ht_show_show_more',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
            'condition' => [
			'show_show_more' => 'yes',
            ],
        ]
    );

    $this->add_control(
        'number_of_item_show_default',
        [
            'label' => esc_html__( 'Show number of item by default', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'default' => 10,
            'condition' => [
			'show_show_more' => 'yes',
            ],
        ]
    );
    $this->end_controls_section();

    // Style Start
    $this->start_controls_section(
        'title_section',
        [
            'label' => __( 'List Item', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
        'list_item_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-category-filter-checkbox li div label, .cat-count' => 'color: {{VALUE}} !important',
            ],
        ]
    );
   
    $this->add_control(
        'checkbox_color',
        [
            'label' => esc_html__( 'Input Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#21850A',
            'selectors' => [
                '{{WRAPPER}} .stea-product-category-filter-checkbox input' => 'accent-color: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'stea_product_filter_item_bg_color',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-category-filter-checkbox li',
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
        'list_item_text_color_hover',
        [
            'label' => esc_html__('Text Color on Hover', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-category-filter-checkbox li:hover label' => 'color: {{VALUE}}',
                '{{WRAPPER}} .stea-product-category-filter-checkbox li:hover .cat-count' => 'color: {{VALUE}} !important',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'stea_product_filter_item_bg_color_hover',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-product-category-filter-checkbox li:hover',
        ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
        'list_item_color_end_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]
    );

    $this->add_responsive_control(
        'list_item_padding',
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
                '{{WRAPPER}} .stea-product-category-filter-checkbox li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    $this->end_controls_section();

    $this->start_controls_section(
        'show_more_style_section',
        [
            'label' => __( 'Show More', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
			'show_show_more' => 'yes',
            ],
        ]
    );

    $this->add_control(
        'show_more_btn_text_align',
        [
            'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
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
                    'title' => esc_html__( 'Justify', 'st-elementor-addons' ),
                    'icon' => 'eicon-text-align-justify',
                ],
            ],
            'default' => 'center',
            'toggle' => true,
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-wrap' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .stea-show-more-wrap.justify-align' => 'width: 100%;',
            ],
            'prefix_class' => 'stea-show-more-align-',
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'show_more_btn_typography',
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn',
        ]
    );

    $this->add_control(
        'show_more_btn_typography_end_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]
    );

    $this->start_controls_tabs(
        'show_more_btn_tabs'
    );
    $this->start_controls_tab(
        'show_more_btn_tab',
        [
            'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
        ]
    );

    $this->add_control(
        'show_more_btn_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-checkbox-btn' => 'color: {{VALUE}} !important',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'show_more_btn_bg_color',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow',
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn',
        ]
    );
    $this->end_controls_tab();
    $this->start_controls_tab(
        'show_more_btn_hover_tab',
        [
            'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
        ]
    );
  
    $this->add_control(
        'show_more_btn_text_color_hover',
        [
            'label' => esc_html__('Text Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-checkbox-btn:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->add_control(
        'show_more_btn_border_color_hover',
        [
            'label' => esc_html__('Border Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-checkbox-btn:hover' => 'border-color: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'show_more_btn_bg_color_hover',
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn:hover',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow_hover',
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn:hover',
        ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
        'show_more_btn_start_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'show_more_btn_border',
            'selector' => '{{WRAPPER}} .stea-show-more-checkbox-btn',
        ]
    );

    $this->add_responsive_control(
        'show_more_btn_border_radius',
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
                '{{WRAPPER}} .stea-show-more-checkbox-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'show_more_btn_padding_start_hr',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]
    );

    $this->add_responsive_control(
        'show_more_btn_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 5,
                'right' => 20,
                'bottom' => 5,
                'left' => 20,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-checkbox-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_responsive_control(
        'show_more_btn_margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 10,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-show-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'serach_field_style_section',
        [
            'label' => __( 'Search', 'st-elementor-addons' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
			'show_search_filter' => 'yes',
            ],
        ]
    );  
    
    $this->add_control(
        'serach_field_text_color',
        [
            'label' => esc_html__( 'Text Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search' => 'color: {{VALUE}}',
            ],
        ]
    );
    $this->add_control(
        'serach_field_text_placeholder_color',
        [
            'label' => esc_html__( 'Placeholder Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search::placeholder' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->add_control(
        'serach_field_back_ground_color',
        [
            'label' => esc_html__( 'Background Color', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search' => 'background-color: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'serach_field_border',
            'selector' => '{{WRAPPER}} .stea-filter-search',
        ]
    );

    $this->add_control(
        'serach_field_margin',
        [
            'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 15,
                'left' => 0,
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'serach_field_padding',
        [
            'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 8,
                'right' => 8,
                'bottom' => 8,
                'left' => 8,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'serach_field_border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
            'default' => [
                'top' => 4,
                'right' => 4,
                'bottom' => 4,
                'left' => 4,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .stea-filter-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    
        // $initial_show = $settings['number_of_item_show_default'];
        $initial_show = !empty( $settings['number_of_item_show_default'] ) ? (int) $settings['number_of_item_show_default'] : 1;

        $show_search_filter = $settings['show_search_filter'] === 'yes';
        $show_show_more = $settings['show_show_more'] === 'yes';
    
        echo '<div class="stea-product-grid-filter-checkbox" data-initial-show="' . esc_attr($initial_show) . '" data-show-more="' . ($show_show_more ? 'true' : 'false') . '">';

        // Conditionally render search input
        if ( $show_search_filter ) {
            echo '<div class="stea-filter-search-wrap">';
            echo '<input type="text" class="stea-filter-search" placeholder="Search categories..." />';
            echo '</div>';
        }
    
        echo '<ul class="stea-product-category-filter-checkbox">';
    
        // Get all product categories
        $product_categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
        ]);
    
        $category_count = 0;
        foreach ( $product_categories as $category ) {
            $category_count++;
            $checkbox_id = 'stea-category-' . $category->term_id;
    
            $show_more_class = ($show_show_more && $category_count > $initial_show) ? 'stea-hidden-category' : '';
    
            echo '<li class="category-item ' . esc_attr($show_more_class) . '" data-search-term="' . esc_attr(strtolower($category->name)) . '">';
            echo '<input type="checkbox" id="' . esc_attr($checkbox_id) . '" class="stea-category-filter" value="' . esc_attr($category->slug) . '">';
            echo '<div class="item-text-wrap">';
            echo '<label for="' . esc_attr($checkbox_id) . '">' . esc_html($category->name) . '</label>';
            if ( 'yes' === $settings['show_count'] ) {
                echo '<span class="cat-count"> (' . esc_html($category->count) . ')</span>';
            }
            echo '</div>';
            echo '</li>';
        }
    
        echo '</ul>';
    
        // Conditionally render Show More button
        if ( $show_show_more && count($product_categories) > $initial_show ) {
            $remaining = count($product_categories) - $initial_show;
            echo '<div class="stea-show-more-wrap">';
            echo '<button class="stea-show-more-checkbox-btn">Show More (+' . esc_html($remaining) . ')</button>';
            echo '</div>';
        }
    
        echo '</div>';
     
    }
}