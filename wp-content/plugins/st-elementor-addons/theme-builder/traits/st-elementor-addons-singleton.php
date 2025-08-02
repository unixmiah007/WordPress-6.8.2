<?php
/**
 * Trait for making singleton instance
 *
 * @package st-elementor-addons
 * @since 1.0.0
 */

namespace ST_Elementor_Addons\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Trait for making singleton instance
 */
trait Singleton {

		/**
		 * Represents the singleton instance.
		 *
		 * @var null|self
		 */
	public static $instance = null;

	/**
	 * Retrieves the singleton instance of the class.
	 *
	 * @return self The singleton instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
