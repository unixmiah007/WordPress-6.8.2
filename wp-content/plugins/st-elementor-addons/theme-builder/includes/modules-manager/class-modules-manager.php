<?php
/**
 * Modules Mananger for ST Elementor Addons
 *
 * @package ST_Elementor_Addons
 */

namespace ST_Elementor_Addons\ModulesManager;

if ( ! defined( 'WPINC' ) ) {
	exit;
}

use ST_Elementor_Addons\Traits\Singleton;

/**
 * Class Modules Manager
 *
 * @subpackage ST_Elementor_Addons\ModulesManager
 */
class Modules_Manager {
	use Singleton;

	/**
	 * Constructor.
	 *
	 * @access private
	 *
	 * @since 1.3.1
	 */
	private function __construct() {
		$this->include_modules();
	}

	/**
	 * Get list of modules.
	 *
	 * Add the module name with Kebab case in lowercase
	 * which should be the name of the root directory of the module.
	 *
	 * @access public
	 *
	 * @since 1.3.1
	 *
	 * @return array Modules list.
	 */
	public function get_modules_list() {
		// Add the directory of the module to register.
		$modules = array(
			'theme-builder',
			// 'login-register',
		);

		return $modules;
	}

	/**
	 * Include all the modules main file.
	 *
	 * Modules main file should in the format class-<module-name>.php
	 * and the class name should be prefixed with "STEA_".
	 *
	 * @access public
	 *
	 * @since 1.3.1
	 *
	 * @return void
	 */
	public function include_modules() {
		$modules = $this->get_modules_list();
		foreach ( $modules as $module ) {
			$class_file = "class-{$module}.php";
			$class_name = ucwords( str_replace( '-', '_', $module ), '_' );
			$class_name = __NAMESPACE__ . "\\{$class_name}\\STEA_{$class_name}";

			require_once "{$module}/{$class_file}";
			if ( class_exists( $class_name ) ) {
				$class_name::instance();
			}
		}
	}

}

Modules_Manager::instance();
