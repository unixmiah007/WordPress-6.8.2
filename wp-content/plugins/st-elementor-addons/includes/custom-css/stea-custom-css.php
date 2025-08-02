<?php
/**
 * Floating Effects extension class for ST Elementor Addons
 */

namespace STEA_Widget;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined( 'ABSPATH' ) || die();

class STEA_Custom_Css {


        /*
         * Instance of this class
         */
        private static $instance = null;
    
    
        public function __construct() {
    
            // Add new controls to advanced tab globally
            add_action( 'elementor/element/after_section_end', array( $this, 'register' ), 25, 3 );
    
            // Render the custom CSS
            add_action( 'elementor/element/parse_css', array( $this, 'stea_elementor_add_post_css' ), 10, 2 );
    
        }
    
        public static function get_instance() {
            if ( ! self::$instance ) {
                self::$instance = new self();
            }
    
            return self::$instance;
        }
    
        public function register( $element, $section_id ) {
    
            if ( 'section_custom_css_pro' !== $section_id ) {
                return;
            }
    
            if ( in_array( $element->get_name(), array( 'section', 'column', 'common', 'container' ), true ) ) {
    
                $element->start_controls_section(
                    'section_stea_elementor_custom_css',
                    array(
                        'label' => __( 'ST Custom CSS', 'st-elementor-addons' ),
                        'tab'   => Controls_Manager::TAB_ADVANCED,
                    )
                );
    
                $element->add_control(
                    'stea_custom_css',
                    array(
                        'type'        => Controls_Manager::CODE,
                        'label'       => __( 'Custom CSS', 'st-elementor-addons' ),
                        'render_type' => 'ui',
                        'show_label'  => false,
                        'language'    => 'css',
                    )
                );
    
                $element->add_control(
                    'stea_custom_css_description',
                    array(
                        'raw'             => __( 'Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'st-elementor-addons' ),
                        'type'            => Controls_Manager::RAW_HTML,
                        'content_classes' => 'elementor-descriptor',
                    )
                );
    
                $element->end_controls_section();
            }
        }
    
        public function stea_elementor_add_post_css( $post_css, $element ) {
    
            $element_settings = $element->get_settings();
    
            if ( empty( $element_settings['stea_custom_css'] ) ) {
                return;
            }
    
            $css = trim( $element_settings['stea_custom_css'] );
    
            if ( empty( $css ) ) {
                return;
            }
            $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );
    
            // Add a css comment
            $css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';
    
            $post_css->get_stylesheet()->add_raw_css( $css );
        }
    }

STEA_Custom_Css::get_instance();