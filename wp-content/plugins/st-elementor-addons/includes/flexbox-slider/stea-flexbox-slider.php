<?php

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
    die();
}

use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;

class St_Nested_Slider extends Widget_Nested_Base {

    public function get_name() {
        return 'stea-flexbox-slider';
    }

    public function get_title() {
        return esc_html__( 'ST Nested Slider', 'st-elementor-addons' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return array( 'layout' );
    }
    
    public function get_style_depends() {
        return array( 'e-swiper', 'stea-flexbox-slider' );
    }

    public function get_script_depends() {
        return array( 'stea-el-slider' );
    }

    public function get_keywords() {
        return array( 'nested', 'slider', 'carousel', 'flexbox', 'container', 'slides', 'image' );
    }

    protected function get_default_children_placeholder_selector() {
        return '.stea-flexbox-slider';
    }

    protected function slide_item_container( int $index ) {
        return array(
            'elType'   => 'container',
            'settings' => array(
                '_title'        => sprintf( __( 'Slide #%s', 'st-elementor-addons' ), $index ),
                'content_width' => 'full',
                'padding'       => array(
                    'unit'     => 'px',
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'isLinked' => true,
                ),
            ),
        );
    }

    protected function get_default_children_title() {
        return esc_html__( 'Slide #%d', 'st-elementor-addons' );
    }

    protected function get_default_repeater_title_setting_key() {
        return '';
    }

    protected function get_default_children_elements() {
        return array(
            $this->slide_item_container( 1 ),
            $this->slide_item_container( 2 ),
        );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_slider',
            array(
                'label' => esc_html__( 'Slider', 'st-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            )
        );
        
        $repeater = new Repeater();

        $this->add_control( 
            'slides', 
            array(
                'label'       => esc_html__( 'Slide Items', 'st-elementor-addons' ),
                'type'        => Control_Nested_Repeater::CONTROL_TYPE,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [],
                    [],
                ],
                'button_text' => esc_html__( 'Add Slide', 'st-elementor-addons' ),
            )
        );

        $this->end_controls_section();        

        $this->start_controls_section(
            'section_slider_options',
            array(
                'label' => esc_html__( 'Slider Options', 'st-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            )
        );

        $this->add_responsive_control(
            'slides_to_show',
            array(
                'label'              => esc_html__( 'Slides to Show', 'st-elementor-addons' ),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 1,
                'max'                => 10,
                'step'               => 0.5,
                'default'            => 1,
                'frontend_available' => true,
                'render_type'        => 'template',
                'selectors'          => array(
                    '{{WRAPPER}} .elementor-main-swiper:not(.swiper-initialized) .swiper-slide' => 'max-width: calc(100% / var(--st-nested-carousel-slides-to-show, 1));',
                    '{{WRAPPER}}' => '--st-nested-carousel-slides-to-show: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            array(
                'label'              => esc_html__( 'Slides to Scroll', 'st-elementor-addons' ),
                'description'        => esc_html__( 'Set how many slides are scrolled per swipe.', 'st-elementor-addons' ),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 1,
                'max'                => 10,
                'step'               => 0.5,
                'condition'          => array(
                    'slides_to_show!' => 1,
                ),
                'frontend_available' => true,
            )
        );
        
        $this->add_responsive_control(
            'slide_spacing',
            array(
                'label'              => esc_html__( 'Space Between', 'st-elementor-addons' ) . ' (px)',
                'type'               => Controls_Manager::SLIDER,
                'range'              => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'frontend_available' => true,
                'render_type'        => 'none',
                'condition'          => array(
                    'transition!' => array( 'fade', 'cube', 'flip', 'cards', 'creative', 'creative2', 'creative3', 'creative4' ),
                ),
            )
        );

        $this->add_control(
            'navigation',
            array(
                'label'              => esc_html__( 'Navigation', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'both',
                'options'           => array(
                    'both'   => esc_html__( 'Arrows and Dots', 'st-elementor-addons' ),
                    'arrows' => esc_html__( 'Arrows', 'st-elementor-addons' ),
                    'dots'   => esc_html__( 'Dots', 'st-elementor-addons' ),
                    'none'   => esc_html__( 'None', 'st-elementor-addons' ),
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label'              => esc_html__( 'Autoplay', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'pause_on_hover',
            array(
                'label'              => esc_html__( 'Pause on Hover', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => array(
                    'autoplay!' => '',
                ),
            )
        );

        $this->add_control(
            'pause_on_interaction',
            array(
                'label'              => esc_html__( 'Pause on Interaction', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => array(
                    'autoplay!' => '',
                ),
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label'              => esc_html__( 'Autoplay Speed', 'st-elementor-addons' ) . ' (ms)',
                'type'               => Controls_Manager::NUMBER,
                'default'            => 5000,
                'condition'          => array(
                    'autoplay' => 'yes',
                ),
                'selectors'          => array(
                    '{{WRAPPER}} .swiper-slide' => 'transition-duration: calc({{VALUE}}ms*1.2)',
                ),
                'render_type'        => 'none',
                'frontend_available' => true,
                'separator'          => 'after',
            )
        );

        $this->add_control(
            'infinite',
            array(
                'label'              => esc_html__( 'Infinite Loop', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'center_mode',
            array(
                'label'              => esc_html__( 'Center Mode', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'condition'         => array(
                    'transition' => array( 'slide', 'coverflow', 'coverflow2' ),
                ),
            )
        );

        $this->add_control(
            'disable_drag',
            array(
                'label'              => esc_html__( 'Disable Mouse Drag', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'transition',
            array(
                'label'              => esc_html__( 'Transition', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'slide',
                'options'            => array(
                    'slide'      => esc_html__( 'Slide', 'st-elementor-addons' ),
                    'fade'       => esc_html__( 'Fade (Slides To Show = 1)', 'st-elementor-addons' ),
                    'cube'       => esc_html__( 'Cube (Slides To Show = 1)', 'st-elementor-addons' ),
                    'coverflow'  => esc_html__( 'Coverflow (Slides To Show > 2)', 'st-elementor-addons' ),
                    'coverflow2' => esc_html__( 'Coverflow 2 (Slides To Show > 2)', 'st-elementor-addons' ),
                    'flip'       => esc_html__( 'Flip (Slides To Show = 1)', 'st-elementor-addons' ),
                    'cards'      => esc_html__( 'Cards (Slides To Show = 1)', 'st-elementor-addons' ),
                    'creative'   => esc_html__( 'Creative (Slides To Show = 1)', 'st-elementor-addons' ),
                    'creative2'  => esc_html__( 'Creative 2 (Slides To Show = 1)', 'st-elementor-addons' ),
                    'creative3'  => esc_html__( 'Creative 3 (Slides To Show = 1)', 'st-elementor-addons' ),
                    'creative4'  => esc_html__( 'Creative 4 (Slides To Show = 1)', 'st-elementor-addons' ),
                ),
                'frontend_available' => true,
                'label_block'        => true,
            )
        );

        $this->add_control(
            'transition_notice',
            array(
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__( '\'Slides To Show\' option should be 1.', 'st-elementor-addons' ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'       => array(
                    'transition!' => array( 'slide', 'coverflow', 'coverflow2' ),
                )
            )
        );

        $this->add_control(
            'transition_speed',
            array(
                'label'              => esc_html__( 'Transition Speed', 'st-elementor-addons' ) . ' (ms)',
                'type'               => Controls_Manager::NUMBER,
                'default'            => 500,
                'render_type'        => 'none',
                'frontend_available' => true,
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_arrow',
            array(
                'label'     => esc_html__( 'Arrows', 'st-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'navigation' => array( 'arrows', 'both' ),
                ),
            )
        );

        $this->add_control(
            'arrow_icon_prev',
            array(
                'label'       => esc_html__( 'Prev Icon', 'st-elementor-addons' ),
                'type'        => Controls_Manager::ICONS,
                'skin'        => 'inline',
                'label_block' => false,
                'default'     => array(
                    'value'   => 'fas fa-chevron-left',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->add_control(
            'arrow_icon_next',
            array(
                'label'       => esc_html__( 'Next Icon', 'st-elementor-addons' ),
                'type'        => Controls_Manager::ICONS,
                'skin'        => 'inline',
                'label_block' => false,
                'default'     => array(
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->add_control(
            'arrows_position',
            array(
                'label'        => esc_html__( 'Position', 'st-elementor-addons' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'inside',
                'options'      => array(
                    'inside'  => esc_html__( 'Inside', 'st-elementor-addons' ),
                    'outside' => esc_html__( 'Outside', 'st-elementor-addons' ),
                    'custom'  => esc_html__( 'Custom', 'st-elementor-addons' ),
                ),
                'prefix_class' => 'elementor-arrows-position-',
                'condition'    => array(
                    'transition' => array( 'slide', 'fade' ),
                ),
            )
        );

        $this->add_control(
            'arrows_position_2',
            array(
                'label'        => esc_html__( 'Position', 'st-elementor-addons' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'inside',
                'options'      => array(
                    'inside'  => esc_html__( 'Inside', 'st-elementor-addons' ),
                    'custom'  => esc_html__( 'Custom', 'st-elementor-addons' ),
                ),
                'prefix_class' => 'elementor-arrows-position-',
                'condition'    => array(
                    'transition!' => array( 'slide', 'fade' ),
                ),
            )
        );

        $this->add_control(
            'custom_arrow_y',
            array(
                'label'      => esc_html__( 'Vertical Position', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => 'in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        ),
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position_2',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => '!in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        )                            
                    ),
                ),            
            )
        );

        $this->add_control(
            'custom_arrow_prev_x',
            array(
                'label'      => esc_html__( 'Prev Icon Horizontal Position', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => 'in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        ),
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position_2',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => '!in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        )                            
                    ),
                ),            
            )
        );

        $this->add_control(
            'custom_arrow_next_x',
            array(
                'label'      => esc_html__( 'Next Icon Horizontal Position', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => 'in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        ),
                        array(
                            'relation' => 'and',
                            'terms'    => array(
                                array(
                                    'name'     => 'arrows_position_2',
                                    'operator' => '===',
                                    'value'    => 'custom',
                                ),
                                array(
                                    'name'     => 'transition',
                                    'operator' => '!in',
                                    'value'    => array( 'slide', 'fade' ),
                                ),                                    
                            ),
                        )                            
                    ),
                ),                
            )
        );

        $this->add_control(
            'arrows_size',
            array(
                'label'      => esc_html__( 'Size', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            )
        );

        $this->add_control(
            'arrows_width',
            array(
                'label'      => esc_html__( 'Width', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'width: {{SIZE}}{{UNIT}};align-items: center;justify-content: center;',
                ],
            )
        );

        $this->add_control(
            'arrows_height',
            array(
                'label'      => esc_html__( 'Height', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'height: {{SIZE}}{{UNIT}};align-items: center;justify-content: center;',
                ],
            )
        );

        $this->add_control(
            'arrows_border_width',
            array(
                'label'      => esc_html__( 'Border Width', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 20,
                    ],
                    'em' => [
                        'max' => 2,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'border-width: {{SIZE}}{{UNIT}};border-style: solid;',
                ],
            )
        );

        $this->add_control(
            'arrows_border_radius',
            array(
                'label' => esc_html__( 'Border Radius', 'st-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'arrows_tabs' );
            $this->start_controls_tab( 
                'normal', 
                array( 
                    'label' => esc_html__( 'Normal', 'st-elementor-addons' ) 
                ) 
            );
                $this->add_control(
                    'arrows_color',
                    array(
                        'label' => esc_html__( 'Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button'     => 'color: {{VALUE}}',
                            '{{WRAPPER}} .elementor-swiper-button svg' => 'fill: {{VALUE}}',
                        ),
                    )
                );

                $this->add_control(
                    'arrows_bg_color',
                    array(
                        'label' => esc_html__( 'Background Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button' => 'background-color: {{VALUE}}',
                        ),
                    )
                );

                $this->add_control(
                    'arrows_bd_color',
                    array(
                        'label' => esc_html__( 'Border Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button' => 'border-color: {{VALUE}}',
                        ),
                        'condition' => array(
                            'arrows_border_width!' => '',
                        ),                            
                    )
                );
            $this->end_controls_tab();

            $this->start_controls_tab( 
                'hover', 
                array( 
                    'label' => esc_html__( 'Hover', 'st-elementor-addons' ) 
                ) 
            );
                $this->add_control(
                    'arrows_hover_color',
                    array(
                        'label' => esc_html__( 'Hover Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button:hover'     => 'color: {{VALUE}}',
                            '{{WRAPPER}} .elementor-swiper-button:hover svg' => 'fill: {{VALUE}}',
                        ),
                    )
                );
                $this->add_control(
                    'arrows_hover_bg_color',
                    array(
                        'label' => esc_html__( 'Hover Background Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button:hover' => 'background-color: {{VALUE}}',
                        ),
                    )
                );

                $this->add_control(
                    'arrows_hover_bd_color',
                    array(
                        'label' => esc_html__( 'Hover Border Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button:hover' => 'border-color: {{VALUE}}',
                        ),
                        'condition' => array(
                            'arrows_border_width!' => '',
                        ),    
                    )
                );        
                $this->add_control(
                    'arrows_hover_transition',
                    array(
                        'label'     => esc_html__( 'Transition Speed', 'st-elementor-addons' ) . ' (s)',
                        'type'      => Controls_Manager::NUMBER,
                        'default'   => 0.3,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button' => 'transition: {{VALUE}}s',
                        ),
                    )
                );                                
            $this->end_controls_tab();
            
            $this->start_controls_tab( 
                'disabled', 
                array( 
                    'label' => esc_html__( 'Disabled', 'st-elementor-addons' ) 
                ) 
            );
                $this->add_control(
                    'arrows_disabled_color',
                    array(
                        'label' => esc_html__( 'Disabled Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button.swiper-button-disabled'     => 'color: {{VALUE}}',
                            '{{WRAPPER}} .elementor-swiper-button.swiper-button-disabled svg' => 'fill: {{VALUE}}',
                        ),
                    )
                );
                $this->add_control(
                    'arrows_disabled_bg_color',
                    array(
                        'label' => esc_html__( 'Disabled Background Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button.swiper-button-disabled' => 'background-color: {{VALUE}}',
                        ),
                    )
                );

                $this->add_control(
                    'arrows_disabled_bd_color',
                    array(
                        'label' => esc_html__( 'Disabled Border Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .elementor-swiper-button.swiper-button-disabled' => 'border-color: {{VALUE}}',
                        ),
                        'condition' => array(
                            'arrows_border_width!' => '',
                        ),                                
                    )
                );                    
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_dots',
            array(
                'label'     => esc_html__( 'Pagination', 'st-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'navigation' => array( 'dots', 'both' ),
                ),
            )
        );

        $this->add_control(
            'pagination',
            array(
                'label'              => esc_html__( 'Pagination', 'st-elementor-addons' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'bullets',
                'options'            => array(
                    'bullets'     => esc_html__( 'Dots', 'st-elementor-addons' ),
                    'dynamic'     => esc_html__( 'Dynamic Bullets', 'st-elementor-addons' ),
                    'fraction'    => esc_html__( 'Fraction', 'st-elementor-addons' ),
                    'progressbar' => esc_html__( 'Progress', 'st-elementor-addons' ),
                ),
                'prefix_class'       => 'elementor-pagination-type-',
                'render_type'        => 'template',
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'dots_width',
            array(
                'type'      => Controls_Manager::SWITCHER,
                'label'     => __( 'Width Auto', 'st-elementor-addons' ),
                'selectors' => array(
                    '{{WRAPPER}} .swiper-pagination-fraction,{{WRAPPER}} .swiper-pagination-custom,{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets' => "width:auto;",
                ),
                'condition' => array(
                    'pagination!' => array( 'dynamic', 'progressbar' ),
                ),                    
            )
        );

        $this->add_control(
            'dots_position',
            array(
                'label'        => esc_html__( 'Position', 'st-elementor-addons' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'inside',
                'options'      => array(
                    'outside' => esc_html__( 'Outside', 'st-elementor-addons' ),
                    'inside'  => esc_html__( 'Inside', 'st-elementor-addons' ),
                    'custom'  => esc_html__( 'Custom', 'st-elementor-addons' ),
                ),
                'prefix_class' => 'elementor-pagination-position-',
                'condition'    => array(
                    'pagination!' => 'progressbar',
                ),
            )
        );

        $this->add_control(
            'custom_dots_y',
            array(
                'label'      => esc_html__( 'Vertical Position', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-fraction,{{WRAPPER}} .swiper-pagination-custom,{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    'dots_position' => 'custom',
                ),            
            )
        );

        $this->add_control(
            'custom_dots_x',
            array(
                'label'      => esc_html__( 'Horizontal Position', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-fraction,{{WRAPPER}} .swiper-pagination-custom,{{WRAPPER}} .swiper-horizontal > .swiper-pagination-bullets' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => array(
                    'dots_position' => 'custom',
                ),            
            )
        );

        $this->add_control(
            'dots_size',
            array(
                'label'      => esc_html__( 'Size', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em', 'rem', 'custom' ),
                'range' => array(
                    'px' => array(
                        'min' => 5,
                        'max' => 15,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'dots_spacing',
            array(
                'label'      => esc_html__( 'Dots Spacing', 'st-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'custom' ),
                'range'      => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}}' => '--swiper-pagination-bullet-horizontal-gap: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'pagination' => array( 'bullets', 'dynamic' ),
                ),
            )
        );

        $this->start_controls_tabs( 'dots_tabs' );
            $this->start_controls_tab( 
                'dots_normal', 
                array( 
                    'label' => esc_html__( 'Normal', 'st-elementor-addons' ) 
                ) 
            );
                
                $this->add_control(
                    'dots_bg_color',
                    array(
                        'label'     => esc_html__( 'Background Color', 'st-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => array(
                            // The opacity property will override the default inactive dot color which is opacity 0.2.
                            '{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background-color: {{VALUE}}; opacity: 1;',
                            '{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color: {{VALUE}};',
                        ),
                        'condition' => array(
                            'pagination!' => 'fraction',
                        ),                            
                    )
                );

                $this->add_control(
                    'dots_fraction_color',
                    array(
                        'label'     => esc_html__( 'Color', 'st-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}}',
                        ),
                        'condition' => array(
                            'pagination' => 'fraction',
                        ),
                    )
                );                        

            $this->end_controls_tab();

            $this->start_controls_tab( 
                'dots_hover', 
                array( 
                    'label' => esc_html__( 'Hover', 'st-elementor-addons' ),
                    'condition' => array(
                        'pagination' => array( 'bullets', 'dynamic' ),
                    ),
                ) 
            );
            
                $this->add_control(
                    'dots_hover_bg_color',
                    array(
                        'label' => esc_html__( 'Hover Background Color', 'st-elementor-addons' ),
                        'type'  => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}}',
                        ),
                    )
                );

                $this->add_control(
                    'dots_hover_transition',
                    array(
                        'label'     => esc_html__( 'Transition Speed', 'st-elementor-addons' ) . ' (s)',
                        'type'      => Controls_Manager::NUMBER,
                        'default'   => 0.3,
                        'selectors' => array(
                            '{{WRAPPER}} .swiper-pagination-bullet' => 'transition: {{VALUE}}s',
                        ),
                    )
                );                        
            
            $this->end_controls_tab();
        
            $this->start_controls_tab( 
                'dots_active', 
                array( 
                    'label' => esc_html__( 'Active', 'st-elementor-addons' ) 
                ) 
            );
                
                $this->add_control(
                    'dots_active_bg_color',
                    array(
                        'label'     => esc_html__( 'Active Background Color', 'st-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
                            '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => '--swiper-pagination-color: {{VALUE}};',
                        ),
                        'condition' => array(
                            'pagination!' => 'fraction',
                        ),
                    )
                );

                $this->add_control(
                    'dots_active_fraction_color',
                    array(
                        'label'     => esc_html__( 'Active Color', 'st-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => array(
                            '{{WRAPPER}} .swiper-pagination-fraction .swiper-pagination-current' => 'color: {{VALUE}}',
                        ),
                        'condition' => array(
                            'pagination' => 'fraction',
                        ),
                    )
                );                        
                
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    private function render_swiper_button( $settings, $type ) {
        $icon_key = 'arrow_icon_' . $type;
        Icons_Manager::render_icon( $settings[ $icon_key ], [ 'aria-hidden' => 'true' ] );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( empty( $settings['slides'] ) ) {
            return;
        }
        $direction = is_rtl() ? 'rtl' : 'ltr';

        $show_dots = in_array( $settings['navigation'], [ 'dots', 'both' ] );
        $show_arrows = in_array( $settings['navigation'], [ 'arrows', 'both' ] );

        $slides_count = count( $settings['slides'] );

        $slides_html = '';
        foreach ( $settings['slides'] as $index => $slide ) {
            // Slide Content.
            ob_start();
            $this->print_child( $index );
            $slide_html = ob_get_clean();
            $slides_html .= '<div class="swiper-slide">' . $slide_html . '</div>';
        }
        ?>
        <div class="elementor-swiper stea-flexbox-slider">
            <div class="elementor-slides-wrapper elementor-main-swiper swiper" dir="<?php echo esc_attr( $direction ); ?>">
                <div class="swiper-wrapper elementor-slides stea-flexbox-slider">
                    <?php echo $slides_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
                <?php if ( 1 < $slides_count ) : ?>
                    <?php if ( $show_dots ) : ?>
                        <div class="swiper-pagination"></div>
                    <?php endif; ?>
                    <?php if ( $show_arrows ) : ?>
                        <div class="elementor-swiper-button elementor-swiper-button-prev stea-swiper-btn">
                            <?php $this->render_swiper_button( $settings, 'prev' ); ?>
                            <span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'st-elementor-addons' ); ?></span>
                        </div>
                        <div class="elementor-swiper-button elementor-swiper-button-next stea-swiper-btn">
                            <?php $this->render_swiper_button( $settings, 'next' ); ?>
                            <span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'st-elementor-addons' ); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
            var direction        = elementorFrontend.config.is_rtl ? 'rtl' : 'ltr',
                navi             = settings.navigation,
                showDots         = ( 'dots' === navi || 'both' === navi ),
                showArrows       = ( 'arrows' === navi || 'both' === navi ),
                buttonSize       = settings.button_size;
            var prev = elementor.helpers.renderIcon( view, settings.arrow_icon_prev, { 'aria-hidden': true }, 'i' , 'object' ),
                next = elementor.helpers.renderIcon( view, settings.arrow_icon_next, { 'aria-hidden': true }, 'i' , 'object' );
        #>
        <div class="elementor-swiper">
            <div class="elementor-slides-wrapper elementor-main-swiper swiper" dir="{{ direction }}">
                <div class="swiper-wrapper elementor-slides stea-flexbox-slider">
                </div>
                <# if ( 1 < settings.slides.length ) { #>
                    <# if ( showDots ) { #>
                        <div class="swiper-pagination"></div>
                    <# } #>
                    <# if ( showArrows ) { #>
                        <div class="elementor-swiper-button elementor-swiper-button-prev">
                            {{{ prev.value }}}
                            <span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'st-elementor-addons' ); ?></span>
                        </div>
                        <div class="elementor-swiper-button elementor-swiper-button-next">
                            {{{ next.value }}}
                            <span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'st-elementor-addons' ); ?></span>
                        </div>
                    <# } #>
                <# } #>
            </div>
        </div>
        <?php
    }
}