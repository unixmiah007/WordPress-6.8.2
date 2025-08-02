<?php
/**
 * Class STEA_Widget\STEA_Marquee_Widget
 */

namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class STEA_Marquee_Widget extends Widget_Base {

    public function get_name() {
        return 'stea_marquee';
    }

    public function get_title() {
        return __('ST Marquee', 'st-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-animation-text';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['stea-marquee'];
    }

    public function get_script_depends() {
        return ['stea-marquee', 'stea-gsap'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'stea_marquee_content_section',
            [
                'label' => __('Content', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'marquee_text',
            [
                'label' => __('Text', 'st-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Marquee Item', 'st-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'marquee_icon',
            [
                'label' => __('Icon', 'st-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'marquee_image',
            [
                'label' => __('Image', 'st-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                // No default image
            ]
        );

        $repeater->add_control(
            'marquee_link',
            [
                'label' => __('Link', 'st-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'st-elementor-addons'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'marquee_items',
            [
                'label' => __('Marquee Items', 'st-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'marquee_text' => 'Animate Anything...',
                        'marquee_icon' => ['value' => 'fas fa-bolt', 'library' => 'fa-solid'],
                    ],
                    [
                        'marquee_text' => 'Delivering silky-smooth performance',
                        'marquee_icon' => ['value' => 'fas fa-tachometer-alt', 'library' => 'fa-solid'],
                    ],
                    [
                        'marquee_text' => 'So you can focus on the fun stuff.',
                        'marquee_icon' => ['value' => 'fas fa-smile', 'library' => 'fa-solid'],
                    ],
                ],
                'title_field' => '{{{ marquee_text }}}',
            ]
        );

        $this->add_control(
            'marquee_speed',
            [
                'label' => __('Speed', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
            ]
        );

        // $this->add_control(
        //     'marquee_direction',
        //     [
        //         'label' => __('Direction', 'st-elementor-addons'),
        //         'type' => Controls_Manager::SELECT,
        //         'options' => [
        //             'left' => __('Left', 'st-elementor-addons'),
        //             'right' => __('Right', 'st-elementor-addons'),
        //         ],
        //         'default' => 'left',
        //     ]
        // );

        $this->add_control(
            'marquee_direction',
            [
                'label' => __('Direction', 'st-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ltr' => __('Left to Right', 'st-elementor-addons'),
                    'rtl' => __('Right to Left', 'st-elementor-addons'),
                ],
                'default' => 'rtl',
            ]
        );
        
        $this->add_control(
            'enable_scroll_animation',
            [
                'label' => __('Enable Scroll Animation', 'st-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'st-elementor-addons'),
                'label_off' => __('No', 'st-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'st-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'st-elementor-addons'),
                'label_off' => __('No', 'st-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'stea_marquee_style_section',
            [
                'label' => __('Spacing', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'marquee_spacing',
            [
                'label' => __('Spacing', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-item' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'marquee_icon_spacing',
            [
                'label' => __('Image / Icon Spacing', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-item-inner' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'stea_marquee_style_text_section',
            [
                'label' => __('Text', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'marquee_typography',
                'selector' => '{{WRAPPER}} .stea-marquee-text',
            ]
        );

        $this->add_control(
            'marquee_text_color',
            [
                'label' => __('Text Color', 'st-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-text' => 'color: {{VALUE}}',
                ],
                'default' => '#000000',
            ]
        );
        $this->end_controls_section();
      
        $this->start_controls_section(
            'stea_marquee_style_icon_and_image_section',
            [
                'label' => __('Image / Icon', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-icon i, {{WRAPPER}} .stea-marquee-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'st-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-icon i, {{WRAPPER}} .stea-marquee-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stea-marquee-image img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $speed = isset($settings['marquee_speed']['size']) ? $settings['marquee_speed']['size'] : 1;
        $direction = isset($settings['marquee_direction']) ? $settings['marquee_direction'] : 'ltr';
        $scroll_animation = isset($settings['enable_scroll_animation']) ? $settings['enable_scroll_animation'] : 'yes';
        $pause_on_hover = isset($settings['pause_on_hover']) ? $settings['pause_on_hover'] : 'no';
        ?>
        <div class="shabbir">
        <div class="stea-marquee-wrapper" data-speed="<?php echo esc_attr($speed); ?>" data-direction="<?php echo esc_attr($direction); ?>" data-scroll-animation="<?php echo esc_attr($scroll_animation); ?>" data-pause-on-hover="<?php echo esc_attr($pause_on_hover); ?>">
            <div class="stea-marquee-rail">
                <?php 
                if (!empty($settings['marquee_items'])) {
                    foreach ($settings['marquee_items'] as $item) {
                        if (!empty($item['marquee_text']) || !empty($item['marquee_icon']['value']) || !empty($item['marquee_image']['url'])) {
    
                            $link_attrs = '';
                            if (!empty($item['marquee_link']['url'])) {
                                $this->add_link_attributes('marquee_link_' . $item['_id'], $item['marquee_link']);
                                $link_attrs = $this->get_render_attribute_string('marquee_link_' . $item['_id']);
                            }
    
                            $content = '';
    
                            $content .= '<div class="stea-marquee-item-inner">';
    
                            // ICON
                                if (!empty($item['marquee_icon']['value'])) {
                                    $content .= '<span class="stea-marquee-icon">';
                                    ob_start();
                                    \Elementor\Icons_Manager::render_icon($item['marquee_icon'], ['aria-hidden' => 'true']);
                                    $content .= ob_get_clean();
                                    $content .= '</span>';
                                }
    
                            // IMAGE (if NOT placeholder)
                            if (!empty($item['marquee_image']['url']) && strpos($item['marquee_image']['url'], 'placeholder') === false) {
                                $content .= '<span class="stea-marquee-image">';
                                $content .= '<img src="' . esc_url($item['marquee_image']['url']) . '" alt="' . esc_attr($item['marquee_text']) . '">';
                                $content .= '</span>';
                            }
    
                            // TEXT
                            if (!empty($item['marquee_text'])) {
                                $content .= '<h3 class="stea-marquee-text">' . esc_html($item['marquee_text']) . '</h3>';
                            }
    
                            $content .= '</div>';
    
                            // OUTPUT
                            if (!empty($item['marquee_link']['url'])) {
                                echo '<a ' . $link_attrs . ' class="stea-marquee-item">' . $content . '</a>';
                            } else {
                                echo '<div class="stea-marquee-item">' . $content . '</div>';
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
        </div>
        <?php
    }
    
}
