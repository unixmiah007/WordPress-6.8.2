<?php
/**
 * Class STEA_Widget\STEA_Nav_Menu_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Nav_Menu_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_header_nav_menu';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST Nav Menu', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-nav-menu';
    }
    
    public function get_keywords() {
        return ['menu', 'nav-menu', 'nav', 'navigation', 'navigation-menu', 'mega', 'megamenu', 'mega-menu'];
    }

    public function get_style_depends() {
        return ['stea-nav-menu', 'widget-icon-list'];
    }

    public function get_script_depends() {
        return ['stea-nav-menu'];
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }
    public function get_menus(){
        $list = [];
        $menus = wp_get_nav_menus();
        foreach($menus as $menu){
            $list[$menu->slug] = $menu->name;
        }

        return $list;
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        $this->start_controls_section(
            'stea_content_tab',
            [
                'label' => esc_html__('Menu Settings', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stea_nav_menu',
            [
                'label'     => esc_html__( 'Select menu', 'st-elementor-addons' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_menus(),
            ]
        );

        $this->add_responsive_control(
            'stea_main_menu_position',
            [
                'label' => esc_html__( 'Horizontal menu position', 'st-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'stea-menu-po-left',
                'options' => [
                    'stea-menu-po-left'  => esc_html__( 'Left', 'st-elementor-addons' ),
                    'stea-menu-po-center' => esc_html__( 'Center', 'st-elementor-addons' ),
                    'stea-menu-po-right' => esc_html__( 'Right', 'st-elementor-addons' ),
                    'stea-menu-po-justified'  => esc_html__( 'Justified', 'st-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
            'stea_nav_dropdown_as',
            [
                'label' => esc_html__( 'Dropdown open as', 'st-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'steam-nav-dropdown-hover',
                'options' => [
                    'steam-nav-dropdown-hover'  => esc_html__( 'Hover', 'st-elementor-addons' ),
                    'steam-nav-dropdown-click' => esc_html__( 'Click', 'st-elementor-addons' ),
                ],
            ]
        );

		$this->add_control(
            'stea_style_tab_submenu_item_arrow',
            [
                'label' => esc_html__('Submenu Indicator Icon', 'st-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'stea_one_page_enable',
            [
                'label' => esc_html__('Enable one page? ', 'st-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' =>esc_html__( 'Yes', 'st-elementor-addons' ),
                'label_off' =>esc_html__( 'No', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'stea_one_page_notice',
            [
                'type' => Controls_Manager::NOTICE,
                'notice_type' => 'warning',
                'heading' => esc_html__('Enable OnePage Notice', 'st-elementor-addons'),
                'content' => esc_html__('This feature only works on the current page. Ensure that the links in your menu are pointing to sections within the same page for the one-page navigation correctly.', 'st-elementor-addons'),
                'condition' => [
                    'stea_one_page_enable' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'stea_responsive_breakpoint',
            [
                'label' => __( 'Responsive Breakpoint', 'st-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'setam_menu_responsive_tablet',
                'options' => [
                    'setam_menu_responsive_tablet'  => __( 'Tablet', 'st-elementor-addons' ),
                    'setam_menu_responsive_mobile' => __( 'Mobile', 'st-elementor-addons' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'stea_mobile_menu',
            [
                'label' => esc_html__('Mobile Menu Settings', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stea_nav_menu_logo',
            [
                'label' => esc_html__( 'Mobile Menu Logo', 'st-elementor-addons' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '', //Utils::get_placeholder_image_src() -- removed for conflict with jetpack
                    'id'    => -1
                ],
            ]
        );

        $this->add_control(
            'stea_nav_menu_logo_link_to',
            [
                'label' => esc_html__( 'Menu link', 'st-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'home',
                'options' => [
                    'home' => esc_html__( 'Default(Home)', 'st-elementor-addons' ),
                    'custom' => esc_html__( 'Custom URL', 'st-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
            'stea_nav_menu_logo_link',
            [
                'label' => esc_html__( ' Custom Link', 'st-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => 'https://wpmet.com',
                'condition' => [
                    'stea_nav_menu_logo_link_to' => 'custom',
                ],
                'show_label' => false,

            ]
        );

        $this->add_control(
            'stea_hamburger_icon',
            [
                'label' => __( 'Hamburger Icon (Optional)', 'st-elementor-addons' ),
                'type' => Controls_Manager::ICONS,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'submenu_click_area',
            [
                'label'         => esc_html__('Submenu Click Area', 'st-elementor-addons'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Icon', 'st-elementor-addons'),
                'label_off'     => esc_html__('Text', 'st-elementor-addons'),
                'return_value'  => 'icon',
                'default'       => 'icon',
            ]
        );

        // Adding List Content Code
        $this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
        $this->add_control(
			'stea_mob_icon_list_heading',
			[
				'label' => esc_html__( 'Icon List', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'Layout', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'traditional',
				'options' => [
					'traditional' => [
						'title' => esc_html__( 'Default', 'st-elementor-addons' ),
						'icon' => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => esc_html__( 'Inline', 'st-elementor-addons' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'style_transfer' => true,
				'prefix_class' => 'elementor-icon-list--layout-',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'st-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List Item', 'st-elementor-addons' ),
				'default' => esc_html__( 'List Item', 'st-elementor-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'st-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'st-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__( 'Items', 'st-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'st-elementor-addons' ),
						'selected_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__( 'List Item #2', 'st-elementor-addons' ),
						'selected_icon' => [
							'value' => 'fas fa-times',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__( 'List Item #3', 'st-elementor-addons' ),
						'selected_icon' => [
							'value' => 'fas fa-dot-circle',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
			]
		);

		$this->add_control(
			'link_click',
			[
				'label' => esc_html__( 'Apply Link On', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'full_width' => esc_html__( 'Full Width', 'st-elementor-addons' ),
					'inline' => esc_html__( 'Inline', 'st-elementor-addons' ),
				],
				'default' => 'full_width',
				'separator' => 'before',
				'prefix_class' => 'elementor-list-item-link-',
			]
		);

        $this->end_controls_section();




        


        // style tab start
        



        $this->start_controls_section(
            'stea_menu_style_tab',
            [
                'label' => esc_html__('Menu Wrapper', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'stea_menubar_height',
            [
                'label' => esc_html__( 'Menu Height', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop' ],
                'desktop_default' => [
                    'size' => 80,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'stea_menu_wrap_h',
            [
                'label' => esc_html__( 'Menu wrapper background', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menubar_background',
                'label' => esc_html__( 'Menu Panel Background', 'st-elementor-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'devices' => [ 'desktop' ],
                'selector' => '{{WRAPPER}} .stea-menu-container',
            ]
        );

        $this->add_responsive_control(
            'wrapper_color_mobile',
            [
                'label'     => esc_html__( 'Mobile Wrapper Background', 'st-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'devices'   => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-container'   => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_panel_spacing',
            [
                'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'tablet_default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'devices' => ['desktop', 'tablet'],
                'selectors' => [
                    '{{WRAPPER}} .stea-nav-identity-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_panel_width',
            [
                'label' => esc_html__( 'Width', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'range' => [
                    'px' => [
                        'min' => 350,
                        'max' => 700,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'size' => 350,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_border_radius',
            [
                'label' => esc_html__( 'Menu border radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'separator' => [ 'before' ],
                'desktop_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'setam_menu_item_icon_spacing',
            [
                'label' => esc_html__( 'Menu Icon Spacing', 'st-elementor-addons' ),
                'description' => esc_html__( 'This is only work with Mega menu icon option', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav li a .steam-menu-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'stea_style_tab_menuitem',
            [
                'label' => esc_html__('Menu Item', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'stea_content_typography',
                'label' => esc_html__( 'Typography', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav > li > a',
            ]
        );



        $this->add_control(
            'stea_menu_item_h',
            [
                'label' => esc_html__( 'Menu Item Style', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->start_controls_tabs(
            'stea_nav_menu_tabs'
        );
        // Normal
        $this->start_controls_tab(
            'stea_nav_menu_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_item_background',
                'label' => esc_html__( 'Item background', 'st-elementor-addons' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .stea-navbar-nav > li > a',
            ]
        );

        $this->add_responsive_control(
            'stea_menu_text_color',
            [
                'label' => esc_html__( 'Item text color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'desktop_default' => '#000000',
                'tablet_default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li > a' => 'color: {{VALUE}}',
                ],
            ]
        );
	
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'  => 'stea_menu_text_border',
				'selector'  => '{{WRAPPER}} .stea-navbar-nav > li > a',
				'size_units'  => ['px'],
			]
		);

		$this->add_control(
			'stea_menu_text_border_radius',
			[
				'label'      => esc_html__('Border Radius (px)', 'st-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .stea-navbar-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'stea_nav_menu_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_item_background_hover',
                'label' => esc_html__( 'Item background', 'st-elementor-addons' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .stea-navbar-nav > li > a:hover, {{WRAPPER}} .stea-navbar-nav > li > a:focus, {{WRAPPER}} .stea-navbar-nav > li > a:active, {{WRAPPER}} .stea-navbar-nav > li:hover > a',
            ]
        );

        $this->add_responsive_control(
            'stea_item_color_hover',
            [
                'label' => esc_html__( 'Item text color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#707070',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li > a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li > a:focus' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li > a:active' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li:hover > a .stea-submenu-indicator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li > a:hover .stea-submenu-indicator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li > a:focus .stea-submenu-indicator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li > a:active .stea-submenu-indicator' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'  => 'stea_menu_text_border_hover',
				'selector'  => '{{WRAPPER}} .stea-navbar-nav > li:hover > a',
				'size_units'  => ['px'],
			]
		);

		$this->add_control(
			'stea_menu_text_border_radius_hover',
			[
				'label'      => esc_html__('Border Radius (px)', 'st-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .stea-navbar-nav > li:hover > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        // active
        $this->start_controls_tab(
            'stea_nav_menu_active_tab',
            [
                'label' => esc_html__( 'Active', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'		=> 'stea_nav_menu_active_bg_color',
                'label' 	=> esc_html__( 'Item background', 'st-elementor-addons' ),
                'types'		=> ['classic', 'gradient'],
                'selector'	=> '{{WRAPPER}} .stea-navbar-nav > li.current-menu-item > a,{{WRAPPER}} .stea-navbar-nav > li.current-menu-ancestor > a'
            ]
        );

        $this->add_responsive_control(
            'stea_nav_menu_active_text_color',
            [
                'label' => esc_html__( 'Item text color (Active)', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#707070',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav > li.current-menu-ancestor > a .stea-submenu-indicator' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'  => 'stea_menu_text_border_active',
				'selector'  => '{{WRAPPER}} .stea-navbar-nav > li.current-menu-item > a',
				'size_units'  => ['px'],
			]
		);

		$this->add_control(
			'stea_menu_text_border_radius_active',
			[
				'label'      => esc_html__('Border Radius (px)', 'st-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .stea-navbar-nav > li.current-menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'stea_menu_item_spacing',
            [
                'label' => esc_html__( 'Item Spacing', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => [ 'before' ],
                'desktop_default' => [
                    'top' => 0,
                    'right' => 15,
                    'bottom' => 0,
                    'left' => 15,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'top' => 10,
                    'right' => 15,
                    'bottom' => 10,
                    'left' => 15,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_item_margin',
            [
                'label' => esc_html__( 'Item Margin', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'stea_style_tab_submenu_indicator',
			[
				'label' => esc_html__('Submenu Indicator', 'st-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'setam_submenu_indicator_font_size',
			[
				'label' => esc_html__( 'Font Size', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stea-navbar-nav > li > a .steam-submenu-indicator-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'stea_style_tab_submenu_indicator_color',
			[
				'label' => esc_html__( 'color', 'st-elementor-addons' ),
				'type'  => Controls_Manager::COLOR,
				'default'   =>  '#101010',
				'alpha'     => false,
				'selectors' => [
					'{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator' => 'color: {{VALUE}}; fill: {{VALUE}}',
					'{{WRAPPER}} .stea-navbar-nav > li > a .steam-submenu-indicator-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_submenu_indicator_background',
                'label' => esc_html__('Background', 'st-elementor-addons'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_submenu_indicator_border',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'stea_submenu_indicator_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .stea-navbar-nav > li > a .steam-submenu-indicator-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'setam_submenu_indicator_spacing',
            [
                'label' => esc_html__('Margin', 'st-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav-default .stea-dropdown-has>a .stea-submenu-indicator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .stea-navbar-nav-default .stea-dropdown-has>a .steam-submenu-indicator-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //create Padding, Border, Radius
        $this->add_responsive_control(
            'stea_submenu_indicator_padding',
            [
                'label' => esc_html__('Padding', 'st-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav > li > a .stea-submenu-indicator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .stea-navbar-nav > li > a .steam-submenu-indicator-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
		$this->end_controls_section();

        $this->start_controls_section(
            'stea_style_tab_submenu_item',
            [
                'label' => esc_html__('Submenu Item', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'stea_menu_item_typography',
                'label' => esc_html__( 'Typography', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a',
            ]
        );

        $this->add_responsive_control(
            'stea_submenu_item_spacing',
            [
                'label' => esc_html__( 'Spacing', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => ['desktop', 'tablet'],
                'desktop_default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'stea_submenu_active_hover_tabs'
        );
        $this->start_controls_tab(
            'stea_submenu_normal_tab',
            [
                'label'	=> esc_html__('Normal', 'st-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'stea_submenu_item_color',
            [
                'label' => esc_html__( 'Item text color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_item_background',
                'label' => esc_html__( 'Item background', 'st-elementor-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stea_submenu_hover_tab',
            [
                'label'	=> esc_html__('Hover', 'st-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'stea_item_text_color_hover',
            [
                'label' => esc_html__( 'Item text color (hover)', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#707070',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:focus' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:active' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li:hover > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_item_background_hover',
                'label' => esc_html__( 'Item background (hover)', 'st-elementor-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '
					{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:hover,
					{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:focus,
					{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a:active,
					{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li:hover > a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stea_submenu_active_tab',
            [
                'label'	=> esc_html__('Active', 'st-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'stea_nav_sub_menu_active_text_color',
            [
                'label' => esc_html__( 'Item text color (Active)', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#707070',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li.current-menu-item > a' => 'color: {{VALUE}} !important'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'		=> 'stea_nav_sub_menu_active_bg_color',
                'label' 	=> esc_html__( 'Item background (Active)', 'st-elementor-addons' ),
                'types'		=> ['classic', 'gradient'],
                'selector'	=> '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li.current-menu-item > a',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'stea_menu_item_border_heading',
            [
                'label' => esc_html__( 'Sub Menu Items Border', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_item_border',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li > a',
            ]
        );

        $this->add_control(
            'stea_menu_item_border_last_child_heading',
            [
                'label' => esc_html__( 'Border Last Child', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_item_border_last_child',
                'label' => esc_html__( 'Border last Child', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li:last-child > a',
            ]
        );

        $this->add_control(
            'stea_menu_item_border_first_child_heading',
            [
                'label' => esc_html__( 'Border First Child', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_item_border_first_child',
                'label' => esc_html__( 'Border First Child', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel > li:first-child > a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'stea_style_tab_submenu_panel',
            [
                'label' => esc_html__('Submenu Panel', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'sub_panel_padding',
			[
				'label'         => esc_html__('Padding', 'st-elementor-addons'),
                'type'          => Controls_Manager::DIMENSIONS,
                'default'       => [
                    'top'       => '15',
                    'bottom'    => '15',
                    'left'      => '0',
                    'right'     => '0',
                    'isLinked'  => false,
                ],
				'selectors'     => [
					'{{WRAPPER}} .stea-submenu-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_panel_submenu_border',
                'label' => esc_html__( 'Panel Menu Border', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_submenu_container_background',
                'label' => esc_html__( 'Container background', 'st-elementor-addons' ),
                'types' => [ 'classic','gradient' ],
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel',
            ]
        );

        $this->add_responsive_control(
            'stea_submenu_panel_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'desktop_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_submenu_container_width',
            [
                'label' => esc_html__( 'Conatiner width', 'st-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'devices' => [ 'desktop' ],
                'desktop_default' => '220px',
                'tablet_default' => '200px',
                'selectors' => [
                    '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel' => 'min-width: {{VALUE}};',
                ]
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'stea_panel_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-navbar-nav .stea-submenu-panel',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'stea_menu_toggle_style_tab',
            [
                'label' => esc_html__( 'Hamburger Menu', 'st-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'stea_menu_toggle_style_title',
            [
                'label' => esc_html__( 'Hamburger Toggle', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'stea_menu_toggle_icon_position',
            [
                'label' => esc_html__( 'Position', 'st-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Top', 'st-elementor-addons' ),
                        'icon' => 'fa fa-angle-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Middle', 'st-elementor-addons' ),
                        'icon' => 'fa fa-angle-right',
                    ],
                ],
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger' => 'float: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_toggle_spacing',
            [
                'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'top' => '8',
                    'right' => '8',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_toggle_width',
            [
                'label' => esc_html__( 'Width', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 45,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_toggle_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_open_typography',
            [
                'label' => esc_html__( 'Icon Size', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger > .steam-menu-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'stea_hamburger_icon[value]!'    => '',
                ],
            ]
        );

        $this->start_controls_tabs(
            'stea_menu_toggle_normal_and_hover_tabs'
        );

        $this->start_controls_tab(
            'stea_menu_toggle_normal',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_toggle_background',
                'label' => esc_html__( 'Background', 'st-elementor-addons' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .stea-menu-hamburger',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_toggle_border',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .stea-menu-hamburger',
            ]
        );

        $this->add_control(
            'stea_menu_toggle_icon_color',
            [
                'label' => esc_html__( 'Hamburger Icon Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger .stea-menu-hamburger-icon' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .stea-menu-hamburger > .steam-menu-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stea_menu_toggle_hover',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_toggle_background_hover',
                'label' => esc_html__( 'Background', 'st-elementor-addons' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .stea-menu-hamburger:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_toggle_border_hover',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .stea-menu-hamburger:hover',
            ]
        );

        $this->add_control(
            'stea_menu_toggle_icon_color_hover',
            [
                'label' => esc_html__( 'Hamburger Icon Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-hamburger:hover .stea-menu-hamburger-icon' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .stea-menu-hamburger:hover > .steam-menu-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'stea_menu_close_style_title',
            [
                'label' => esc_html__( 'Close Toggle', 'st-elementor-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'stea_menu_close_typography',
                'label' => esc_html__( 'Typography', 'st-elementor-addons' ),
                'selector' => '{{WRAPPER}} .stea-menu-close',
            ]
        );

        $this->add_responsive_control(
            'stea_menu_close_spacing',
            [
                'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'top' => '8',
                    'right' => '8',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_close_margin',
            [
                'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'top' => '12',
                    'right' => '12',
                    'bottom' => '12',
                    'left' => '12',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_close_width',
            [
                'label' => esc_html__( 'Width', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 45,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_menu_close_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet'],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'stea_menu_close_normal_and_hover_tabs'
        );

        $this->start_controls_tab(
            'stea_menu_close_normal',
            [
                'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_close_background',
                'label' => esc_html__( 'Background', 'st-elementor-addons' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .stea-menu-close',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_close_border',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .stea-menu-close',
            ]
        );

        $this->add_control(
            'stea_menu_close_icon_color',
            [
                'label' => esc_html__( 'Hamburger Icon Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(51, 51, 51, 1)',
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stea_menu_close_hover',
            [
                'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stea_menu_close_background_hover',
                'label' => esc_html__( 'Background', 'st-elementor-addons' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .stea-menu-close:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'stea_menu_close_border_hover',
                'label' => esc_html__( 'Border', 'st-elementor-addons' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .stea-menu-close:hover',
            ]
        );

        $this->add_control(
            'stea_menu_close_icon_color_hover',
            [
                'label' => esc_html__( 'Hamburger Icon Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .stea-menu-close:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'stea_mobile_menu_logo_style_tab',
            [
                'label' => esc_html__( 'Mobile Menu Logo', 'st-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_logo_width',
            [
                'label' => esc_html__( 'Width', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 5,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 160,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 120,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-nav-logo > img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_logo_height',
            [
                'label' => esc_html__( 'Height', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-nav-logo > img' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_logo_margin',
            [
                'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'tablet_default' => [
                    'top' => '5',
                    'right' => '0',
                    'bottom' => '5',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => 'false',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-nav-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'stea_mobile_menu_logo_padding',
            [
                'label' => esc_html__( 'Padding', 'st-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'tablet_default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                    'isLinked' => 'true',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-nav-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
			'seta_section_icon_list',
			[
				'label' => esc_html__( 'Mobile Icon List', 'st-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'seta_section_icon_list_margin',
			[
				'label' => esc_html__( 'Margin', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 15,
					'bottom' => 2,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .stea-nav-social-data-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_responsive_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_control(
			'divider',
			[
				'label' => esc_html__( 'Divider', 'st-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'st-elementor-addons' ),
				'label_on' => esc_html__( 'On', 'st-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => esc_html__( 'Style', 'st-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'st-elementor-addons' ),
					'double' => esc_html__( 'Double', 'st-elementor-addons' ),
					'dotted' => esc_html__( 'Dotted', 'st-elementor-addons' ),
					'dashed' => esc_html__( 'Dashed', 'st-elementor-addons' ),
				],
				'default' => 'solid',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label' => esc_html__( 'Weight', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
				],
				'condition' => [
					'divider' => 'yes',
					'view!' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label' => esc_html__( 'Height', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'divider' => 'yes',
					'view' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Icon Settings', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's', 'ms', 'custom' ],
				'default' => [
					'unit' => 's',
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'transition: color {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-icon-list-icon svg' => 'transition: fill {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
					'%' => [
						'min' => 6,
					],
					'vw' => [
						'min' => 6,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}}' => '--e-icon-list-icon-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_indent',
			[
				'label' => esc_html__( 'Gap', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon' => is_rtl() ? 'padding-left: {{SIZE}}{{UNIT}};' : 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$e_icon_list_icon_css_var = 'var(--e-icon-list-icon-size, 1em)';
		$e_icon_list_icon_align_left = sprintf( '0 calc(%s * 0.25) 0 0', $e_icon_list_icon_css_var );
		$e_icon_list_icon_align_center = sprintf( '0 calc(%s * 0.125)', $e_icon_list_icon_css_var );
		$e_icon_list_icon_align_right = sprintf( '0 0 0 calc(%s * 0.25)', $e_icon_list_icon_css_var );

		$this->add_responsive_control(
			'icon_self_align',
			[
				'label' => esc_html__( 'Horizontal Alignment', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'st-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'selectors_dictionary' => [
					'left' => sprintf( '--e-icon-list-icon-align: left; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_left ),
					'center' => sprintf( '--e-icon-list-icon-align: center; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_center ),
					'right' => sprintf( '--e-icon-list-icon-align: right; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_right ),
				],
				'selectors' => [
					'{{WRAPPER}}' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_self_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'st-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'st-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'st-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'st-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => '--icon-vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_vertical_offset',
			[
				'label' => esc_html__( 'Adjust Vertical Position', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 15,
					],
					'em' => [
						'min' => -1,
						'max' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--icon-vertical-offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'stea_text_setting_icon_mob_nav_menu',
			[
				'label' => esc_html__( 'Text Settings', 'st-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-icon-list-item > .elementor-icon-list-text, {{WRAPPER}} .elementor-icon-list-item > a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-icon-list-text',
			]
		);

		$this->start_controls_tabs( 'text_colors' );

		$this->start_controls_tab(
			'text_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'text_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label' => esc_html__( 'Color', 'st-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'st-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's', 'ms', 'custom' ],
				'default' => [
					'unit' => 's',
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text' => 'transition: color {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings_for_display();

        // Return if menu not selected
        if(empty($settings['stea_nav_menu'])) {
            return;
        }

        $hamburger_icon_value = '';
        $hamburger_icon_type = '';
        if ($settings['stea_hamburger_icon'] != '' && $settings['stea_hamburger_icon']) {
            if ($settings['stea_hamburger_icon']['library'] !== 'svg') {
                $hamburger_icon_value = esc_attr($settings['stea_hamburger_icon']['value']);
                $hamburger_icon_type = esc_attr('icon');
            } else {
                $hamburger_icon_value = esc_url($settings['stea_hamburger_icon']['value']['url']);
                $hamburger_icon_type = esc_attr('url');
            }
        }

        // Responsive menu breakpoint
        $responsive_menu_breakpoint = '';
        if ($settings['stea_responsive_breakpoint'] === 'setam_menu_responsive_tablet') {
            $responsive_menu_breakpoint = "1024";
        } else {
            $responsive_menu_breakpoint = "767";
        }

		?>
		<nav class="steam-wid-con <?php echo esc_attr($settings['stea_responsive_breakpoint']); ?>" 
			data-hamburger-icon="<?php echo esc_attr($hamburger_icon_value); ?>" 
			data-hamburger-icon-type="<?php echo esc_attr($hamburger_icon_type); ?>" 
			data-responsive-breakpoint="<?php echo esc_attr($responsive_menu_breakpoint); ?>">
			<?php $this->render_raw(); ?>
        </nav>
		<?php
    }

    protected function render_raw() {
        $settings = $this->get_settings_for_display();
    
        if ( $settings['stea_nav_menu'] !== '' && wp_get_nav_menu_items( $settings['stea_nav_menu'] ) !== false && count( wp_get_nav_menu_items( $settings['stea_nav_menu'] ) ) > 0 ) {
            // Hamburger Button
            ?>
            <button class="stea-menu-hamburger stea-menu-toggler" type="button" aria-label="hamburger-icon">
                <?php
                if ( $settings['stea_hamburger_icon']['value'] === '' ) :
                    ?>
                    <span class="stea-menu-hamburger-icon"></span><span class="stea-menu-hamburger-icon"></span><span class="stea-menu-hamburger-icon"></span>
                    <?php
                endif;
    
                \Elementor\Icons_Manager::render_icon( $settings['stea_hamburger_icon'], [ 'aria-hidden' => 'true', 'class' => 'steam-menu-icon' ] );
                ?>
            </button>
            <?php
    
            // Build social icon list
            ob_start();
    
            $fallback_defaults = [ 'fa fa-check', 'fa fa-times', 'fa fa-dot-circle-o' ];
            $this->add_render_attribute( 'icon_list', 'class', 'elementor-icon-list-items' );
            $this->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item' );
    
            if ( 'inline' === $settings['view'] ) {
                $this->add_render_attribute( 'icon_list', 'class', 'elementor-inline-items' );
                $this->add_render_attribute( 'list_item', 'class', 'elementor-inline-item' );
            }
            ?>
            <div class="stea-nav-social-data-wrap">
                <ul <?php $this->print_render_attribute_string( 'icon_list' ); ?>>
                    <?php foreach ( $settings['icon_list'] as $index => $item ) :
                        $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );
                        $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );
                        $this->add_inline_editing_attributes( $repeater_setting_key );
                        $migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
                        ?>
                        <li <?php $this->print_render_attribute_string( 'list_item' ); ?>>
                            <?php
                            if ( ! empty( $item['link']['url'] ) ) {
                                $link_key = 'link_' . $index;
                                $this->add_link_attributes( $link_key, $item['link'] );
                                ?>
                                <a <?php $this->print_render_attribute_string( $link_key ); ?>>
                            <?php }
    
                            if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
                                $item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
                            }
    
                            $migrated = isset( $item['__fa4_migrated']['selected_icon'] );
                            $is_new = ! isset( $item['icon'] ) && $migration_allowed;
    
                            if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
                                ?>
                                <span class="elementor-icon-list-icon">
                                    <?php
                                    if ( $is_new || $migrated ) {
                                        \Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    } else {
                                        echo '<i class="' . esc_attr( $item['icon'] ) . '" aria-hidden="true"></i>';
                                    }
                                    ?>
                                </span>
                            <?php endif; ?>
                            <span <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>>
                                <?php $this->print_unescaped_setting( 'text', 'icon_list', $index ); ?>
                            </span>
                            <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            $icon_list_html = ob_get_clean();
    
            // Logo block
            $link = $target = $nofollow = '';
    
            if ( isset( $settings['stea_nav_menu_logo_link_to'] ) && $settings['stea_nav_menu_logo_link_to'] === 'home' ) {
                $link = get_home_url();
            } elseif ( isset( $settings['stea_nav_menu_logo_link']['url'] ) ) {
                $link    = $settings['stea_nav_menu_logo_link']['url'];
                $target  = ( $settings['stea_nav_menu_logo_link']['is_external'] === "on" ) ? "_blank" : "";
                $nofollow = ( $settings['stea_nav_menu_logo_link']['nofollow'] === "on" ) ? "nofollow" : "";
            }
    
            $markup = '<div class="stea-nav-identity-panel">';
            $logo   = ! empty( $settings['stea_nav_menu_logo'] ) ? $settings['stea_nav_menu_logo'] : [];
    
            if ( ! empty( $logo['id'] ) && ! empty( $logo['url'] ) ) {
                $nav_logo_html = sprintf(
                    '<img src="%s" title="%s" alt="%s" decoding="async" />',
                    esc_url( $logo['url'] ),
                    \Elementor\Control_Media::get_image_title( $logo ),
                    \Elementor\Control_Media::get_image_alt( $logo )
                );
    
                $markup .= sprintf(
                    '<a class="stea-nav-logo" href="%1$s" target="%2$s" rel="%3$s">%4$s</a>',
                    esc_url( $link ),
                    esc_attr( $target ),
                    esc_attr( $nofollow ),
                    $nav_logo_html
                );
            }
    
            $markup .= '<button class="stea-menu-close stea-menu-toggler" type="button">X</button></div>';
    
            // Menu container
            $container_classes = [
                'stea-menu-container stea-menu-offcanvas-elements stea-navbar-nav-default',
                'steam-nav-menu-one-page-' . $settings['stea_one_page_enable'],
                ! empty( $settings['stea_nav_dropdown_as'] ) ? $settings['stea_nav_dropdown_as'] : 'steam-nav-dropdown-hover',
            ];
    
            echo '<div id="steam-megamenu-' . esc_attr( $settings['stea_nav_menu'] ) . '" class="' . esc_attr( join( ' ', $container_classes ) ) . '">';
    
            // Social Icons (before <ul>)
            echo $icon_list_html;
    
            $args = [
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'container'       => false,
                'menu'            => $settings['stea_nav_menu'],
                'menu_class'      => 'stea-navbar-nav ' . esc_attr( $settings['stea_main_menu_position'] ) . ' submenu-click-on-' . esc_attr( $settings['submenu_click_area'] ),
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
            ];
    
            if ( ! class_exists( '\STEA_Widget_Helper\STEA_Secondary_Menu_Helper' ) ) {
                include dirname( __FILE__ ) . '/stea-nav-menu-helper.php';
            }
            $args['walker'] = new \STEA_Widget_Helper\STEA_Secondary_Menu_Helper();
    
            // Submenu indicator
            $args['submenu_indicator_icon'] = $this->get_indicator_icon( $settings );
    
            // WP 6.1 submenu fix
            if ( version_compare( get_bloginfo( 'version' ), '6.1', '<' ) ) {
                $args['depth'] = 4;
            }
    
            wp_nav_menu( $args );
    
            // Logo + Close button (after <ul>)
            echo $markup;
    
            echo '</div>'; // Close .stea-menu-container
            ?>
            <div class="stea-menu-overlay stea-menu-offcanvas-elements stea-menu-toggler steam-nav-menu--overlay"></div>
            <?php
        }
    }

    protected function get_indicator_icon($settings) {
        $icon_html = '';
        $indicator_class = 'stea-submenu-indicator';
        
        if (!empty($settings['stea_style_tab_submenu_item_arrow']) && !empty($settings['stea_style_tab_submenu_item_arrow']['value'])) {
            $icon_class = esc_attr($settings['stea_style_tab_submenu_item_arrow']['value']);
        
            // Ensure it's not an SVG
            if ($settings['stea_style_tab_submenu_item_arrow']['library'] !== 'svg') {
                $icon_html = sprintf(
                    '<i class="%1$s %2$s" aria-hidden="true"></i>',
                    $icon_class,
                    $indicator_class
                );
            }
        }

		return $icon_html;
	}
    
}