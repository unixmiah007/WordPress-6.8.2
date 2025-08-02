<?php
/**
 * Class STEA_Widget\STEA_WC_Breadcrumb
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_WC_Breadcrumb extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_wc_breadcrumb';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST WC Breadcrumb', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-product-breadcrumbs';
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
        return [ 'woocommerce', 'breadcrumbs', 'navigation', 'shop' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            $this->start_controls_section(
                'section_missing_woocommerce',
                [
                    'label' => __( 'WooCommerce Missing', 'st-elementor-addons' ),
                ]
            );

            $this->add_control(
                'woocommerce_missing_warning',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __( 'The %s plugin is required for this widget to work. Please install and activate it.', 'st-elementor-addons' ),
                        '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                ]
            );

            $this->end_controls_section();
            return;
        }

        $this->start_controls_section(
            'section_breadcrumbs_content',
            [
                'label' => __( 'Breadcrumbs', 'st-elementor-addons' ),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'st-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
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
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __( 'HTML Tag', 'st-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'div' => 'div',
                    'nav' => 'nav',
                    'p' => 'p',
                    'span' => 'span',
                ],
                'default' => 'nav',
            ]
        );

        $this->add_control(
            'home_text',
            [
                'label' => __( 'Home Text', 'st-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Home', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __( 'Separator', 'st-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => ' / ',
                'selectors' => [
                    '{{WRAPPER}} .stea-breadcrumb-separator' => 'content: "{{VALUE}}"',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Breadcrumbs', 'st-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .stea-breadcrumb',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-breadcrumb' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_breadcrumbs_style' );

        $this->start_controls_tab(
            'tab_color_normal',
            [
                'label' => __( 'Normal', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __( 'Link Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-breadcrumb a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_color_hover',
            [
                'label' => __( 'Hover', 'st-elementor-addons' ),
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => __( 'Link Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-breadcrumb a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'separator_color',
            [
                'label' => __( 'Separator Color', 'st-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .stea-breadcrumb-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output.
     */
    protected function render() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            return;
        }

        $settings = $this->get_settings_for_display();
        $html_tag = $settings['html_tag'] ? $settings['html_tag'] : 'nav';

        $args = [
            'delimiter'   => '<span class="stea-breadcrumb-separator">' . $settings['separator'] . '</span>',
            'wrap_before' => '<' . $html_tag . ' class="stea-breadcrumb">',
            'wrap_after'  => '</' . $html_tag . '>',
            'home'        => $settings['home_text'],
        ];

        woocommerce_breadcrumb( $args );
    }
}