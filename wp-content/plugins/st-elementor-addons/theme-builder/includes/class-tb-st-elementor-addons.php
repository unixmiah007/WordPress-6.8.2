<?php
/**
 * Adds menu and assets.
 *
 * @package    st-elementor-addons
 * @subpackage st-elementor-addons/includes
 * @author      <support@striviothemes.com>
 */

use Elementor\Utils;
use Elementor\Plugin;
use ST_Elementor_Addons\Helper\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ST_Elementor_Addons
 *
 * @package ST_Elementor_Addons
 */
class ST_Elementor_Addons {


	const MINIMUM_ELEMENTOR_VERSION = '3.10.0';

	/**
	 * False if no posts are found for migration.
	 *
	 * @var $is_migrated
	 */
	public static $is_migrated = true;

	/**
	 * Represents the singleton instance.
	 *
	 * @var null|self
	 */
	private static $instance = null;

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

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'include_modules_manager' ) );

		// Enqueues the necessary scripts and styles for the plugin's admin interface
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		$this->load_dependencies();
	}

	/**
	 * Responsible for defining all actions that occur in the admin area.
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		include_once STEA_PATH . 'theme-builder/helper/helper.php';
		include_once STEA_PATH . 'theme-builder/traits/st-elementor-addons-singleton.php';
	}

	/**
	 * Loads Plugins Text Domain
	 */
	public function i18n() {

		load_plugin_textdomain( 'st-elementor-addons' );
	}

	/**
	 * Include modules manager
	 */
	public function include_modules_manager() {
		// Load the modules.
		require STEA_PATH . 'theme-builder/includes/modules-manager/class-modules-manager.php';
	}

	/**
	 * Callback function to display admin notice.
	 */
	public function stea_theme_builder_notice_callback() {}

	/**
	 * Enqueue Scripts
	 *
	 * Enqueues the necessary scripts and styles for the plugin's admin interface.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'stea-select2', STEA_URL . 'theme-builder/admin/assets/lib/select2/select2.js', array( 'jquery' ), STEA_VERSION, true );

		// Select2 i18n.
		$wp_local_lang = get_locale();

		if ( '' !== $wp_local_lang ) {
			$select2_available_lang = array(
				''               => 'en',
				'hi_IN'          => 'hi',
				'mr'             => 'mr',
				'af'             => 'af',
				'ar'             => 'ar',
				'ary'            => 'ar',
				'as'             => 'as',
				'azb'            => 'az',
				'az'             => 'az',
				'bel'            => 'be',
				'bg_BG'          => 'bg',
				'bn_BD'          => 'bn',
				'bo'             => 'bo',
				'bs_BA'          => 'bs',
				'ca'             => 'ca',
				'ceb'            => 'ceb',
				'cs_CZ'          => 'cs',
				'cy'             => 'cy',
				'da_DK'          => 'da',
				'de_CH'          => 'de',
				'de_DE'          => 'de',
				'de_DE_formal'   => 'de',
				'de_CH_informal' => 'de',
				'dzo'            => 'dz',
				'el'             => 'el',
				'en_CA'          => 'en',
				'en_GB'          => 'en',
				'en_AU'          => 'en',
				'en_NZ'          => 'en',
				'en_ZA'          => 'en',
				'eo'             => 'eo',
				'es_MX'          => 'es',
				'es_VE'          => 'es',
				'es_CR'          => 'es',
				'es_CO'          => 'es',
				'es_GT'          => 'es',
				'es_ES'          => 'es',
				'es_CL'          => 'es',
				'es_PE'          => 'es',
				'es_AR'          => 'es',
				'et'             => 'et',
				'eu'             => 'eu',
				'fa_IR'          => 'fa',
				'fi'             => 'fi',
				'fr_BE'          => 'fr',
				'fr_FR'          => 'fr',
				'fr_CA'          => 'fr',
				'gd'             => 'gd',
				'gl_ES'          => 'gl',
				'gu'             => 'gu',
				'haz'            => 'haz',
				'he_IL'          => 'he',
				'hr'             => 'hr',
				'hu_HU'          => 'hu',
				'hy'             => 'hy',
				'id_ID'          => 'id',
				'is_IS'          => 'is',
				'it_IT'          => 'it',
				'ja'             => 'ja',
				'jv_ID'          => 'jv',
				'ka_GE'          => 'ka',
				'kab'            => 'kab',
				'km'             => 'km',
				'ko_KR'          => 'ko',
				'ckb'            => 'ku',
				'lo'             => 'lo',
				'lt_LT'          => 'lt',
				'lv'             => 'lv',
				'mk_MK'          => 'mk',
				'ml_IN'          => 'ml',
				'mn'             => 'mn',
				'ms_MY'          => 'ms',
				'my_MM'          => 'my',
				'nb_NO'          => 'nb',
				'ne_NP'          => 'ne',
				'nl_NL'          => 'nl',
				'nl_NL_formal'   => 'nl',
				'nl_BE'          => 'nl',
				'nn_NO'          => 'nn',
				'oci'            => 'oc',
				'pa_IN'          => 'pa',
				'pl_PL'          => 'pl',
				'ps'             => 'ps',
				'pt_BR'          => 'pt',
				'pt_PT_ao90'     => 'pt',
				'pt_PT'          => 'pt',
				'rhg'            => 'rhg',
				'ro_RO'          => 'ro',
				'ru_RU'          => 'ru',
				'sah'            => 'sah',
				'si_LK'          => 'si',
				'sk_SK'          => 'sk',
				'sl_SI'          => 'sl',
				'sq'             => 'sq',
				'sr_RS'          => 'sr',
				'sv_SE'          => 'sv',
				'szl'            => 'szl',
				'ta_IN'          => 'ta',
				'te'             => 'te',
				'th'             => 'th',
				'tl'             => 'tl',
				'tr_TR'          => 'tr',
				'tt_RU'          => 'tt',
				'tah'            => 'ty',
				'ug_CN'          => 'ug',
				'uk'             => 'uk',
				'ur'             => 'ur',
				'uz_UZ'          => 'uz',
				'vi'             => 'vi',
				'zh_CN'          => 'zh',
				'zh_TW'          => 'zh',
				'zh_HK'          => 'zh',
			);

			if ( isset( $select2_available_lang[ $wp_local_lang ] ) && file_exists( STEA_URL . 'theme-builder/admin/assets/lib/select2/i18n/' . $select2_available_lang[ $wp_local_lang ] . '.js' ) ) {
				wp_enqueue_script(
					'stea-select2-lang',
					STEA_URL . 'theme-builder/admin/assets/lib/select2/i18n/' . $select2_available_lang[ $wp_local_lang ] . '.js',
					array( 'jquery', 'stea-select2' ),
					STEA_VERSION,
					true
				);
			}
		}

		wp_register_style( 'stea-select2-style', STEA_URL . 'theme-builder/admin/assets/lib/select2/select2.css', array(), STEA_VERSION );
		wp_enqueue_style( 'stea-select2-style' );

	}

}