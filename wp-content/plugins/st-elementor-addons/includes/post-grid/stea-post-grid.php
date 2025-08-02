<?php
/**
 * Class STEA_Widget\STEA_Post_Grid_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Post_Grid_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_post_grid';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Post Grid', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
		return array( 'stea-post-grid' );
	}

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // === Query Controls ===
        $this->start_controls_section('stea_query_section', [
            'label' => esc_html__('Query', 'st-elementor-addons'),
        ]);


        // Fetch post types start //
        $post_types = get_post_types([
            'public' => true,    // Only show public post types
            'show_ui' => true    // Only show post types that appear in admin UI
        ], 'objects');

        // Prepare options array
        $post_type_options = [];
        if (!empty($post_types)) {
            foreach ($post_types as $post_type) {
                $post_type_options[$post_type->name] = $post_type->label;
            }
        }

        // Add control with dynamic post types
        $this->add_control(
            'selected_post_type',
            [
                'label' => esc_html__('Post Types', 'st-elementor-addons'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $post_type_options,
                'default' => 'post', // Default to 'post' post type
                'description' => esc_html__('Select which post types to include.', 'st-elementor-addons'),
            ]
        );
        // Fetch post types End //

        $this->add_control('posts_per_page', [
            'label' => esc_html__('Posts Per Page', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
        ]);

        $this->add_control('post_content_word_count', [
            'label' => esc_html__('Description Count', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 20,
            // 'min' => 1,
        ]);

        $this->add_responsive_control(
            'columns',
            [
                'label' => __( 'Columns', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 6,
                'selectors' => [
                    '{{WRAPPER}}' => '--stea-product-grid-wrap-number-of-columns-to-show: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'text_align',
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
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .stea-product-grid-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->end_controls_section();

// Button Start //
$this->start_controls_section(
    'button_settings_section',
    [
        'label' => __( 'Button', 'st-elementor-addons' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'button_settings_title',
    [
        'label' => esc_html__( 'Button Text', 'st-elementor-addons' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__( 'Read More', 'st-elementor-addons' ),
        'placeholder' => esc_html__( 'Type your title here', 'st-elementor-addons' ),
    ]
);

$this->add_control(
    'button_settings_icon',
    [
        'label' => esc_html__('Icon', 'st-elementor-addons'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-arrow-right',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'icon_position',
    [
        'label' => esc_html__( 'Icon Position', 'st-elementor-addons' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'before' => [
                'title' => esc_html__( 'Left', 'st-elementor-addons' ),
                'icon' => 'eicon-angle-left',
            ],
            'after' => [
                'title' => esc_html__( 'Right', 'st-elementor-addons' ),
                'icon' => 'eicon-angle-right',
            ],
        ],
        'default' => 'after',
        'toggle' => true,
    ]
);

$this->end_controls_section();


        // === Style: Container ===
        $this->start_controls_section('style_container', [
            'label' => esc_html__('Item Wrapper', 'st-elementor-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control(
			'container_gap',
			[
				'label' => esc_html__( 'Gap', 'st-elementor-addons' ),
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
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-grid-wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'container_colors_tabs' );

        // Normal State Tab
        $this->start_controls_tab(
            'container_color_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'container_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .stea-post-grid-item',
			]
		);
        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'container_color_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'container_background_hover',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .stea-post-grid-item:hover',
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), [
            'name' => 'container_shadow',
            'selector' => '{{WRAPPER}} .stea-post-grid-item',
        ]);

        $this->add_responsive_control(
            'container_padding',
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
                    '{{WRAPPER}} .stea-post-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'container_border_radius',
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
                    '{{WRAPPER}} .stea-post-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

       

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .stea-post-grid-item',
			]
		);
        $this->end_controls_section();

        // === Style: Image ===
        $this->start_controls_section('style_image', [
            'label' => esc_html__('Image', 'st-elementor-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .stea-feature-image img',
			]
		);

        $this->add_responsive_control(
			'img_width',
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
					'{{WRAPPER}} .stea-feature-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
			'img_height',
			[
				'label' => esc_html__( 'Height', 'st-elementor-addons' ),
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
					'size' => 'auto',
				],
				'selectors' => [
					'{{WRAPPER}} .stea-feature-image img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
            'img_object_fit',
            [
                'label' => esc_html__( 'Object Fit', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__( 'Cover', 'st-elementor-addons' ),
                    'contain' => esc_html__( 'Contain', 'st-elementor-addons' ),
                    'fill'  => esc_html__( 'Fill', 'st-elementor-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-feature-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
      
        $this->add_control(
			'image_radius',
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
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-feature-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'image_padding',
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
                    '{{WRAPPER}} .stea-feature-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // === Style: Title ===
        $this->start_controls_section('style_title', [
            'label' => esc_html__('Title', 'st-elementor-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs( 'title_colors_tabs' );

        // Normal State Tab
        $this->start_controls_tab(
            'title_color_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-title span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'title_color_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Color', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-title span:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .stea-post-grid-title span',
        ]);

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 5,
                    'right' => 0,
                    'bottom' => 5,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // === Style: Description ===
        $this->start_controls_section('style_description', [
            'label' => esc_html__('Description', 'st-elementor-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs( 'description_colors_tabs' );

        // Normal State Tab
        $this->start_controls_tab(
            'description_color_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Color', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'description_color_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label' => esc_html__( 'Color', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-description:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .stea-post-grid-description',
        ]);

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => 5,
                    'right' => 0,
                    'bottom' => 5,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-post-grid-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // === Style: Button ===
        $this->start_controls_section('style_button', [
            'label' => esc_html__('Button', 'st-elementor-addons'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .stea-post-grid-button-text',
            ]
        );
        
        $this->start_controls_tabs('button_colors');
        
        // Normal
        $this->start_controls_tab('button_normal', [
            'label' => esc_html__('Normal', 'st-elementor-addons'),
        ]);
        
        $this->add_control('button_color', [
            'label' => esc_html__('Text Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-btn' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->add_control('icon_color', [
            'label' => esc_html__('Icon Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-btn svg' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'stea_post_grid_btn_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .stea-product-grid-btn',
			]
		);

        $this->end_controls_tab();
        
        // Hover
        $this->start_controls_tab('button_hover', [
            'label' => esc_html__('Hover', 'st-elementor-addons'),
        ]);
        
        $this->add_control('button_color_hover', [
            'label' => esc_html__('Text Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-btn:hover' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->add_control('icon_color_hover', [
            'label' => esc_html__('Icon Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-btn:hover svg' => 'color: {{VALUE}};',
            ],
        ]);
        
        $this->add_control('btn_border_color_hover', [
            'label' => esc_html__('Border Color', 'st-elementor-addons'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .stea-product-grid-btn:hover' => 'border-color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'stea_post_grid_btn_background_hover',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .stea-product-grid-btn:hover',
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        

        $this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Gap', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-grid-btn' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Width', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .stea-product-grid-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'btn_text_align',
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
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .stea-product-grid-btn' => 'justify-content: {{VALUE}};',
				],
			]
		);

       
        $this->add_responsive_control(
            'btn_padding',
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
                    '{{WRAPPER}} .stea-product-grid-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'btn_margin',
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
                    '{{WRAPPER}} .stea-product-grid-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'btn_radius',
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
                    '{{WRAPPER}} .stea-product-grid-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'selector' => '{{WRAPPER}} .stea-product-grid-btn',
			]
		);
        $this->end_controls_section();
        
    }

    /**
     * Render widget output.
     */
    protected function render() {
    $settings = $this->get_settings_for_display();
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $query = new \WP_Query([
        'post_type'      => $settings['selected_post_type'],
        'posts_per_page' => $settings['posts_per_page'],
        'paged'          => $paged,
    ]);

    if ($query->have_posts()) {
        echo '<div class="stea-product-grid-wrap">';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $title = get_the_title();
            if($settings['post_content_word_count'] == '0'){
                $content = '';    
            }else{
                $content = wp_trim_words(get_the_content(), $settings['post_content_word_count'], '...');
            }
            $permalink = get_permalink();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
            
            // Output the image with your responsive classes and let CSS controls handle sizing
            $thumbnail = $thumbnail_url ? sprintf(
                '<img src="%s" class="img-fluid stea-feature-image" alt="%s" loading="lazy">',
                esc_url($thumbnail_url),
                esc_attr(get_the_title($post_id))
            ) : '';

            echo '<div class="stea-post-grid-item">';
                echo '<div class="stea-feature-image">' . $thumbnail . '</div>';
                echo sprintf(
                    '<h5 class="stea-post-grid-title"><a href="%s">%s</a></h5>',
                    esc_url($permalink),
                    '<span>' . esc_html($title) . '</span>'
                );
                echo '<p class="stea-post-grid-description">' . esc_html($content) . '</p>';

                // Button with icon
                $button_text    = esc_html($settings['button_settings_title']);
                $icon_position  = $settings['icon_position'] ?? 'after';
                $icon_html      = '';
                
                // Get icon color & size
                $icon_color     = $settings['icon_color'] ?? '';
                $icon_size      = $settings['icon_size'] ?? ''; // Expecting px or rem
                
                $icon_style = '';
                if ($icon_color) {
                    $icon_style .= 'color:' . esc_attr($icon_color) . ';';
                }
                if ($icon_size) {
                    $icon_style .= 'font-size:' . esc_attr($icon_size) . ';';
                }
                $button_add_to_cart_icon = $settings['button_settings_icon'];
                $button_icon_data = wp_json_encode($button_add_to_cart_icon);
                // Generate icon HTML
                $icon_html = '';

                if (isset($button_add_to_cart_icon['value']) && is_array($button_add_to_cart_icon['value']) && isset($button_add_to_cart_icon['value']['url'])) {
                    if (isset($button_add_to_cart_icon['library']) && $button_add_to_cart_icon['library'] === 'svg') {
                        $icon_html = '<img src="' . esc_url($button_add_to_cart_icon['value']['url']) . '" alt="' . esc_attr($add_to_cart_btn_text) . '" class="stea-icon-svg" />';
                    }
                } elseif (isset($button_add_to_cart_icon['value']) && !empty($button_add_to_cart_icon['value'])) {
                    $icon_html = '<i class="' . esc_attr($button_add_to_cart_icon['value']) . '"></i>';
                }
                
                // Combine icon + text
                $button_output = '';
                if ($icon_position === 'before') {
                    $button_output .= $icon_html;
                }
                $button_output .= '<span class="stea-post-grid-button-text">' . $button_text . '</span>';
                if ($icon_position === 'after') {
                    $button_output .= $icon_html;
                }
                
                // Output button
                echo sprintf(
                    '<div class="stea-post-grid-btn-wrapper"><a href="%s" class="button stea-product-grid-btn">%s</a></div>',
                    esc_url(get_permalink()),
                    $button_output
                );
            echo '</div>';
        }

        echo '</div>';

        // Pagination
        $big = 999999999;
        echo '<div class="stea-pagination" style="margin-top:20px;">';
        echo paginate_links([
            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'    => '?paged=%#%',
            'current'   => max(1, $paged),
            'total'     => $query->max_num_pages,
        ]);
        echo '</div>';

        wp_reset_postdata();
    } else {
        echo '<p>No services found.</p>';
    }
}
    
}