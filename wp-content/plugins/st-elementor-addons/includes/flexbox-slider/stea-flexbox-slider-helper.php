<?php
// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Plugin;

/**
 * Main Flexbox Class
 */
class STEA_Flexbox_Slider {
	/**
	 * The Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Register widget on Elementor initialization
		add_action( 'elementor/widgets/register', array( $this, 'stea_new_flexbox' ) );

		// Register Swiper styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'stea_register_widget_script' ), 9999 );

		// Ensure that the Swiper styles/scripts are enqueued only when necessary
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'stea_enqueue_swiper_styles' ) );
	}

	/**
	 * Register new nested elements (widgets)
	 * 
	 * @since 1.0.0
	 */
	public function stea_new_flexbox( $stea_widgets_manager ) {
		// Check if the nested elements feature is active
		if ( Plugin::$instance->experiments->is_feature_active( 'nested-elements' ) ) {
			// Include the widget file
			include_once STEA_PATH . 'includes/flexbox-slider/stea-flexbox-slider.php';

			// Register the widget
			$stea_widgets_manager->register( new ST_Nested_Slider() );
		}
	}

	/**
	 * Register the scripts and styles for the slider
	 * 
	 * @since 1.0.0
	 */
	public function stea_register_widget_script() {
		// Register Swiper 8 styles
		// wp_register_style( 'stea-swiper-style', 'https://unpkg.com/swiper/swiper-bundle.min.css', [], '8.0.0' ); // Swiper 8 style

		// Register Swiper 8 script
		// wp_register_script( 'stea-swiper-script', 'https://unpkg.com/swiper/swiper-bundle.min.js', [], '8.0.0', true ); // Swiper 8 JS

		// Register custom slider script
		wp_register_script( 'stea-el-slider', STEA_URL . 'assets/js/flexbox-slider/slider.min.js', array( 'jquery', 'elementor-frontend' ), '1.0.0', true );
	}

	/**
	 * Conditionally enqueue Swiper styles and scripts only when necessary
	 * 
	 * @since 1.0.0
	 */
	public function stea_enqueue_swiper_styles() {
		// Only enqueue styles and scripts for the pages where the widget is present
		if ( is_page() || is_single() ) {
			wp_enqueue_style( 'stea-swiper-style' ); // Enqueue Swiper styles
			wp_enqueue_script( 'stea-swiper-script' ); // Enqueue Swiper script
		}
	}
}

new STEA_Flexbox_Slider;

/**
 * Flexbox Addon Manager
 */
class STEA_Flexbox {

	private $stea_modules = array();

	/**
	 * The Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->stea_modules = apply_filters(
			'stea_modules',
			array(
				'slider',
				// 'conditional',
			)
		);

		// Load style on admin for elementor preview
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'stea_enqueue_script' ) );
		add_action( 'init', array( $this, 'stea_load_module' ) );
	}

	/**
	 * Enqueue scripts for Elementor editor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function stea_enqueue_script() {
		wp_enqueue_script( 'stea-el-admin', STEA_URL . 'assets/js/flexbox-slider/stea-admin.min.js', array( 'nested-elements' ), '1.0', true );
	}

	/**
	 * Load modules
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function stea_load_module() {
		// Ensure Elementor is active and the Plugin class is available
		if ( class_exists( '\Elementor\Plugin' ) ) {
			$stea_elementor = \Elementor\Plugin::instance();

			if ( $stea_elementor->experiments->is_feature_active( 'container' ) ) {
				foreach ( $this->stea_modules as $stea_module ) {
					include_once STEA_PATH . 'includes/flexbox-slider/stea-flexbox-slider-helper.php';
				}
			}
		}
	}
}

new STEA_Flexbox;
