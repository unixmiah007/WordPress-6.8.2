<?php
/**
 * ST Elementor Addons - Floating Effects
 * Adds floating animation controls to all Elementor widgets
 * 
 * @package STElementorAddons
 * @since 1.0.0
 */

namespace STEA_Widget;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined('ABSPATH') || die();

class STEA_Floating_Effect {

    /**
     * Track if scripts have been enqueued
     * @var bool
     */
    public static $should_script_enqueue = false;

    /**
     * Initialize the floating effects
     */
    public static function init() {
        add_action('elementor/element/common/_section_style/after_section_end', [__CLASS__, 'register_controls'], 10);
        add_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
        add_action('elementor/preview/enqueue_scripts', [__CLASS__, 'enqueue_preview_scripts']);
    }

    /**
     * Check if we should enqueue scripts for this widget
     * 
     * @param Element_Base $element
     */
    public static function should_script_enqueue($element) {
        // Only enqueue once
        if (self::$should_script_enqueue) {
            return;
        }

        // Check if floating effect is enabled
        if ('yes' === $element->get_settings_for_display('stea_floating_fx')) {
            self::enqueue_scripts();
            self::$should_script_enqueue = true;
            
            // Remove hook after first enqueue
            remove_action('elementor/frontend/widget/before_render', [__CLASS__, 'should_script_enqueue']);
        }
    }

    /**
     * Enqueue scripts for the editor preview
     */
    public static function enqueue_preview_scripts() {
        self::enqueue_scripts();
    }

    /**
     * Enqueue required scripts
     */
    public static function enqueue_scripts() {
        // Register anime.js if not already registered
        if (!wp_script_is('anime', 'registered')) {
            wp_register_script(
                'anime',
                STEA_URL . 'assets/js/float-effect/anime.min.js',
                [],
                '3.2.1',
                true
            );
        }

        // Register floating effects script
        wp_register_script(
            'stea-floating-effect',
            STEA_URL . 'assets/js/float-effect/stea-floating-effect.js',
            ['jquery', 'anime'],
            STEA_VERSION,
            true
        );

        // Enqueue the scripts
        wp_enqueue_script('anime');
        wp_enqueue_script('stea-floating-effect');
    }

    /**
     * Register floating effect controls
     * 
     * @param Element_Base $element
     */
    public static function register_controls($element) {
        $element->start_controls_section(
            'section_stea_floating',
            [
                'label' => __('ST Floating Effects', 'st-elementor-addons'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        // Main toggle control
        $element->add_control(
            'stea_floating_fx',
            [
                'label' => __('Enable Floating Effects', 'st-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
        );

        // ======================
        // TRANSLATE EFFECTS
        // ======================
        $element->add_control(
            'stea_floating_fx_translate_toggle',
            [
                'label' => __('Translate', 'st-elementor-addons'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'stea_floating_fx' => 'yes',
                ],
            ]
        );

        $element->start_popover();

        // Translate X
        $element->add_control(
            'stea_floating_fx_translate_x',
            [
                'label' => __('Translate X', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 0,
                        'to' => 20,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition' => [
                    'stea_floating_fx_translate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        // Translate Y
        $element->add_control(
            'stea_floating_fx_translate_y',
            [
                'label' => __('Translate Y', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 0,
                        'to' => 20,
                    ],
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition' => [
                    'stea_floating_fx_translate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        // Translate Duration
        $element->add_control(
            'stea_floating_fx_translate_duration',
            [
                'label' => __('Duration (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'size' => 1000,
                ],
                'condition' => [
                    'stea_floating_fx_translate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        // Translate Delay
        $element->add_control(
            'stea_floating_fx_translate_delay',
            [
                'label' => __('Delay (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                        'step' => 100,
                    ],
                ],
                'condition' => [
                    'stea_floating_fx_translate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->end_popover();

        // ======================
        // ROTATE EFFECTS
        // ======================
        $element->add_control(
            'stea_floating_fx_rotate_toggle',
            [
                'label' => __('Rotate', 'st-elementor-addons'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'stea_floating_fx' => 'yes',
                ],
            ]
        );

        $element->start_popover();

        // Rotate Mode
        $element->add_control(
            'stea_floating_fx_rotate_mode',
            [
                'label' => __('Mode', 'st-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'compact' => [
                        'title' => __('Compact', 'st-elementor-addons'),
                        'icon' => 'eicon-plus-circle',
                    ],
                    'loose' => [
                        'title' => __('Loose', 'st-elementor-addons'),
                        'icon' => 'eicon-minus-circle',
                    ],
                ],
                'default' => 'loose',
                'toggle' => false,
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'stea_floating_fx_rotate_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // Rotate X (loose mode)
        $element->add_control(
            'stea_floating_fx_rotate_x',
            [
                'label' => __('Rotate X', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 0,
                        'to' => 30,
                    ],
                    'unit' => 'deg',
                ],
                'range' => [
                    'deg' => [
                        'min' => -180,
                        'max' => 180,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_rotate_mode' => 'loose',
                ],
                'frontend_available' => true,
            ]
        );

        // Rotate Y (loose mode)
        $element->add_control(
            'stea_floating_fx_rotate_y',
            [
                'label' => __('Rotate Y', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 0,
                        'to' => 0,
                    ],
                    'unit' => 'deg',
                ],
                'range' => [
                    'deg' => [
                        'min' => -180,
                        'max' => 180,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_rotate_mode' => 'loose',
                ],
                'frontend_available' => true,
            ]
        );

        // Rotate Z (compact mode)
        $element->add_control(
            'stea_floating_fx_rotate_z',
            [
                'label' => __('Rotate Z', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 0,
                        'to' => 30,
                    ],
                    'unit' => 'deg',
                ],
                'range' => [
                    'deg' => [
                        'min' => -180,
                        'max' => 180,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_rotate_mode' => 'compact',
                ],
                'frontend_available' => true,
            ]
        );

        // Rotate Duration
        $element->add_control(
            'stea_floating_fx_rotate_duration',
            [
                'label' => __('Duration (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'size' => 1000,
                ],
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        // Rotate Delay
        $element->add_control(
            'stea_floating_fx_rotate_delay',
            [
                'label' => __('Delay (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                        'step' => 100,
                    ],
                ],
                'condition' => [
                    'stea_floating_fx_rotate_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->end_popover();

        // ======================
        // SCALE EFFECTS
        // ======================
        $element->add_control(
            'stea_floating_fx_scale_toggle',
            [
                'label' => __('Scale', 'st-elementor-addons'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'stea_floating_fx' => 'yes',
                ],
            ]
        );

        $element->start_popover();

        // Scale Mode
        $element->add_control(
            'stea_floating_fx_scale_mode',
            [
                'label' => __('Mode', 'st-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'compact' => [
                        'title' => __('Compact', 'st-elementor-addons'),
                        'icon' => 'eicon-plus-circle',
                    ],
                    'loose' => [
                        'title' => __('Loose', 'st-elementor-addons'),
                        'icon' => 'eicon-minus-circle',
                    ],
                ],
                'default' => 'loose',
                'toggle' => false,
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'stea_floating_fx_scale_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // Scale X (loose mode)
        $element->add_control(
            'stea_floating_fx_scale_x',
            [
                'label' => __('Scale X', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 1,
                        'to' => 1.2,
                    ],
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_scale_mode' => 'loose',
                ],
                'frontend_available' => true,
            ]
        );

        // Scale Y (loose mode)
        $element->add_control(
            'stea_floating_fx_scale_y',
            [
                'label' => __('Scale Y', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 1,
                        'to' => 1,
                    ],
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_scale_mode' => 'loose',
                ],
                'frontend_available' => true,
            ]
        );

        // Scale (compact mode)
        $element->add_control(
            'stea_floating_fx_scale_z',
            [
                'label' => __('Scale', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'sizes' => [
                        'from' => 1,
                        'to' => 1.2,
                    ],
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'labels' => [
                    __('From', 'st-elementor-addons'),
                    __('To', 'st-elementor-addons'),
                ],
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                    'stea_floating_fx_scale_mode' => 'compact',
                ],
                'frontend_available' => true,
            ]
        );

        // Scale Duration
        $element->add_control(
            'stea_floating_fx_scale_duration',
            [
                'label' => __('Duration (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'size' => 1000,
                ],
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        // Scale Delay
        $element->add_control(
            'stea_floating_fx_scale_delay',
            [
                'label' => __('Delay (ms)', 'st-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                        'step' => 100,
                    ],
                ],
                'condition' => [
                    'stea_floating_fx_scale_toggle' => 'yes',
                    'stea_floating_fx' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->end_popover();
        $element->end_controls_section();
    }
}

// Initialize the floating effects
STEA_Floating_Effect::init();