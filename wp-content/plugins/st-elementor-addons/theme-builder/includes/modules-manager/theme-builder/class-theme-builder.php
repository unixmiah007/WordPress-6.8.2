<?php
/**
 * Theme Builder template builder's main file.
 *
 * @package ST_Elementor_Addons
 */

namespace ST_Elementor_Addons\ModulesManager\Theme_Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ST_Elementor_Addons\Traits\Singleton;
use ST_Elementor_Addons\ModulesManager\Theme_Builder\Conditions\STEA_Conditions;
use Elementor;
use ST_Elementor_Addons\Helper\Helper;

/**
 * Class STEA Theme Builder
 */
class STEA_Theme_Builder {
	use Singleton;

	/**
	 * Current file directory.
	 *
	 * @var string
	 */
	public $dir;

	/**
	 * Current theme template
	 *
	 * @var String
	 */
	public $template;

	/**
	 * Instance of Elementor class.
	 *
	 * @var Elementor
	 */
	private static $elementor;

	/**
	 * Constructor
	 *
	 * @access private
	 */
	private function __construct() {
		$this->template = get_template();
		$this->dir      = dirname( __FILE__ ) . '/';

		$is_elementor_callable = ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) ? true : false;

		$compatibility_themes = array( 'astra' );

		// If no match is found, set up fallback support.
		if ( ! in_array( $this->template, $compatibility_themes ) ) {
			add_action( 'init', array( $this, 'setup_fallback_support' ) );
		} else {
			require STEA_PATH . 'themes/compatibility/class-stea-compatibility-compat.php';
		}

		if ( $is_elementor_callable ) {
			self::$elementor = Elementor\Plugin::instance();

			$this->include_files();

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			if ( class_exists( 'WooCommerce' ) ) {
				// Single Product.
				add_filter( 'wc_get_template_part', array( $this, 'get_product_page_woocommerce_template' ), 99, 3 );
				add_filter( 'template_include', array( $this, 'get_product_page_elementor_template' ), 999 );
				add_action( 'stea_template_woocommerce_product_content', array( $this, 'get_product_content_elementor' ), 5 );
				add_action( 'stea_template_woocommerce_product_content', array( $this, 'get_product_default_data' ), 10 );
			}
			// Product Archive Page.
			if ( class_exists( 'WooCommerce' ) ) {
				add_action( 'template_redirect', array( $this, 'stea_product_archive_template' ), 999 );
				add_filter( 'template_include', array( $this, 'stea_redirect_product_archive_template' ), 999 );
				add_action( 'stea_template_woocommerce_archive_product_content', array( $this, 'stea_archive_product_page_content' ) );
			}

			add_shortcode( 'stea_theme_template', array( $this, 'render_template' ) );
		}

	}

	/**
	 * Add support for theme if the current theme does add support for 'header-footer-elementor'
	 *
	 * @since  1.6.1
	 */
	public function setup_fallback_support() {
		require_once STEA_PATH . 'theme-builder/themes/default/class-stea-default-compat.php';

	}

	/**
	 * Include all the required files
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function include_files() {
		require_once STEA_PATH . 'theme-builder/admin/classes/class-st-elementor-addons-theme-builder-admin.php';

		require_once $this->dir . 'theme-util.php';

		// Load WPML & Polylang Compatibility if WPML is installed and activated.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) || defined( 'POLYLANG_BASENAME' ) ) {
			require_once $this->dir . 'compatibility/class-theme-wpml-compatibility.php';
		}

		require_once $this->dir . 'conditions/class-stea-conditions.php';
	}

	/**
	 * Enqueue styles and scripts.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			if ( method_exists( $elementor->frontend, 'enqueue_styles' ) ) {
				$elementor->frontend->enqueue_styles();
			}
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			if ( method_exists( $elementor_pro, 'enqueue_styles' ) ) {
				$elementor_pro->enqueue_styles();
			}
		}

		if ( get_stea_header_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_header_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_header_id() );
			}

			$css_file->enqueue();
		}

		if ( get_stea_footer_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_footer_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_footer_id() );
			}

			$css_file->enqueue();
		}

		if ( get_stea_single_page_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_single_page_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_single_page_id() );
			}

			$css_file->enqueue();
		}

		if ( get_stea_single_post_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_single_post_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_single_post_id() );
			}

			$css_file->enqueue();
		}

		if ( get_stea_error_404_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_error_404_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_error_404_id() );
			}

			$css_file->enqueue();
		}

		if ( get_stea_archive_id() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( get_stea_archive_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new \Elementor\Post_CSS_File( get_stea_archive_id() );
			}

			$css_file->enqueue();
		}
	}

	/**
	 * Load admin styles on Theme Builder edit screen.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		global $pagenow;
		$screen = get_current_screen();

		if ( ( 'stea-theme-template' === $screen->id && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) || ( 'edit.php' === $pagenow && 'edit-stea-theme-template' === $screen->id ) ) {
			wp_enqueue_style( 'stea-hf-admin-style', STEA_URL . 'theme-builder/admin/css/stea-theme-admin.css', array(), STEA_VERSION );
			wp_enqueue_script( 'stea-hf-admin-script', STEA_URL . 'theme-builder/admin/assets/js/stea-theme-admin.js', array(), STEA_VERSION, true );
		}
	}

	/**
	 * Adds classes to the body tag conditionally.
	 *
	 * @access public
	 *
	 * @param  array $classes Array of class names for the body tag.
	 *
	 * @return array Array of class names for the body tag.
	 */
	public function body_class( $classes ) {
		if ( get_stea_header_id() ) {
			$classes[] = 'stea-theme-header';
		}

		if ( get_stea_footer_id() ) {
			$classes[] = 'stea-theme-footer';
		}

		if ( get_stea_single_page_id() ) {
			$classes[] = 'stea-theme-single-page';
		}

		if ( get_stea_single_post_id() ) {
			$classes[] = 'stea-theme-single-post';
		}

		if ( get_stea_error_404_id() ) {
			$classes[] = 'stea-theme-error-404';
		}

		if ( get_stea_archive_id() ) {
			$classes[] = 'stea-theme-archive';
		}

		$classes[] = 'stea-template-' . $this->template;
		$classes[] = 'stea-stylesheet-' . get_stylesheet();

		return $classes;
	}

	/**
	 * Ouputs the Header template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_header_content() {
		$header_id = get_stea_header_id();

		if ( ! $header_id ) {
			return false;
		}

		echo '<header id="masthead" class="site-header" role="banner" >';
		echo self::$elementor->frontend->get_builder_content_for_display( $header_id );//phpcs:ignore
		echo '</header>';

		return true;
	}

	/**
	 * Outputs the Footer template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_footer_content() {
		$footer_id = get_stea_footer_id();

		if ( ! $footer_id ) {
			return false;
		}

		echo '<div id="footer" class="clearfix site-footer">';
		echo self::$elementor->frontend->get_builder_content_for_display( $footer_id );//phpcs:ignore
		echo '</div>';

		return true;
	}

	/**
	 * Calls respective function based on its type.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean Value returned by function call or false.
	 */
	public static function get_single_content() {
		$current_post = get_the_ID();

		if ( is_404( $current_post ) ) {
			return self::get_error_404_content();
		}

		if ( is_page( $current_post ) || is_attachment( $current_post ) ) {
			return self::get_single_page_content();
		}

		if ( is_single( $current_post ) ) {
			return self::get_single_post_content();
		}

		return false;
	}

	/**
	 * Outputs the Single Page template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_single_page_content() {
		$single_page_id = get_stea_single_page_id();

		if ( ! $single_page_id ) {
			return false;
		}

		echo self::$elementor->frontend->get_builder_content_for_display( $single_page_id ); //phpcs:ignore

		return true;
	}

	/**
	 * Outputs the Single Post template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_single_post_content() {
		$single_post_id = get_stea_single_post_id();

		if ( ! $single_post_id ) {
			return false;
		}

		echo self::$elementor->frontend->get_builder_content_for_display( $single_post_id );//phpcs:ignore

		return true;
	}

	/**
	 * Outputs the Error 404 template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_error_404_content() {
		$error_404_id = get_stea_error_404_id();

		if ( ! $error_404_id ) {
			return false;
		}

		echo self::$elementor->frontend->get_builder_content_for_display( $error_404_id );//phpcs:ignore

		return true;
	}

	/**
	 * Outputs the Archive template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.7.0` false if template doesn't exists otherwise true.
	 */
	public static function get_archive_content() {
		$archive_id = get_stea_archive_id();

		if ( ! $archive_id ) {
			return false;
		}

		echo ( self::$elementor->frontend->get_builder_content_for_display( $archive_id ) ); //phpcs:ignore

		return true;
	}
	/**
	 * Outputs the Product Archive template content.
	 *
	 * @access public
	 * @static
	 *
	 * @return boolean since `1.8.0` false if template doesn't exists otherwise true.
	 */
	public static function get_product_archive_content() {
		$archive_id = get_stea_product_archive_id();

		if ( ! $archive_id ) {
			return false;
		}

		echo ( self::$elementor->frontend->get_builder_content_for_display( $archive_id ) );//phpcs:ignore

		return true;
	}

	/**
	 * Get settings for Theme Builder template builder
	 *
	 * @access public
	 * @static
	 *
	 * @param  mixed $setting Option name.
	 *
	 * @return mixed
	 */
	public static function get_settings( $setting = '' ) {
		if ( 'header' === $setting || 'footer' === $setting || 'single-page' === $setting || 'single-post' === $setting || 'error-404' === $setting || 'archive' === $setting || 'single-product' === $setting || 'product-archive' === $setting ) {
			$templates = self::get_template_id( $setting );

			$template = ! is_array( $templates ) ? $templates : $templates[0];

			$template = apply_filters( "stea_hf_get_settings_{$setting}", $template );

			return $template;
		}
	}

	/**
	 * Get template id based on the meta query.
	 *
	 * @access public
	 * @static
	 *
	 * @param  string $type Type of the template.
	 *
	 * @return mixed  Template ID or empty string.
	 */
	public static function get_template_id( $type ) {
		$option = array(
			'location'  => 'stea_hf_include_locations',
			'exclusion' => 'stea_hf_exclude_locations',
			'users'     => 'stea_hf_target_user_roles',
		);

		$templates    = STEA_Conditions::instance()->get_posts_by_conditions( 'stea-theme-template', $option );
		$template_ids = array();

		foreach ( $templates as $template ) {
			if ( get_post_meta( absint( $template['id'] ), 'stea_hf_template_type', true ) === $type ) {
				$template_ids[] = $template['id'];
			}
		}

		return empty( $template_ids ) ? '' : $template_ids;
	}

	/**
	 * Render shortcode
	 *
	 * @access public
	 *
	 * @param array $atts Attributes for shortcode.
	 *
	 * @return mixed
	 */
	public function render_template( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'stea_theme_template'
		);

		$id = ! empty( $atts['id'] ) ? apply_filters( 'stea_hf_render_shortcode', intval( $atts['id'] ) ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $id );
		} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
			$css_file = new \Elementor\Post_CSS_File( $id );
		}

		$css_file->enqueue();

		return self::$elementor->frontend->get_builder_content_for_display( $id );
	}

	/**
	 * Retrieves the WooCommerce template for the product page, if available.
	 *
	 * This function checks if the current template being loaded is for the content
	 * of a single product in WooCommerce. If so, and if a custom WooCommerce template
	 * is set for it, it returns the corresponding template file path. Otherwise, it
	 * returns the original template path.
	 *
	 * @param string $template The original template file path.
	 * @param string $slug     The template slug.
	 * @param string $name     The template name.
	 * @return string The updated template file path, if a custom template is set; otherwise, the original template path.
	 */
	public function get_product_page_woocommerce_template( $template, $slug, $name ) {
		if ( 'content' === $slug && 'single-product' === $name ) {
			if ( get_stea_single_product_id() ) {
				$template = $this->dir . 'templates/woocommerce/single-product.php';
			}
		}

		return $template;
	}

	/**
	 * Retrieves the Elementor template for the product page, if available.
	 *
	 * This function checks if the current page is a single product page and if a custom
	 * Elementor template is set for it. If a custom template is set, it returns the
	 * corresponding Elementor template file path. Otherwise, it returns the original
	 * template path.
	 *
	 * @param string $template The original template file path.
	 * @return string The updated template file path, if an Elementor template is set; otherwise, the original template path.
	 */
	public function get_product_page_elementor_template( $template ) {
		if ( is_embed() ) {
			return $template;
		}

		if ( is_singular( 'product' ) ) {
			if ( get_stea_single_product_id() ) {
				$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

				if ( 'elementor_header_footer' === $page_template ) {
					$template = $this->dir . 'templates/woocommerce/single-product-fullwidth.php';
				} elseif ( 'elementor_canvas' === $page_template ) {
					$template = $this->dir . 'templates/woocommerce/single-product-canvas.php';
				}
			}
		}

		return $template;
	}

	/**
	 * Retrieves the content of the single product using Elementor if available.
	 *
	 * This function checks if a custom Elementor template is set for the single product.
	 * If a custom template is set, it retrieves and displays the content using Elementor's
	 * frontend builder. Otherwise, it falls back to displaying the default content using
	 * the WordPress `the_content()` function.
	 *
	 * @return void
	 */
	public function get_product_content_elementor() {
		if ( get_stea_single_product_id() ) {
			$template_id = get_stea_single_product_id();
			echo ( Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id ) );//phpcs:ignore
		} else {
			the_content();
		}
	}

	/**
	 * Generates default product data for structured data.
	 *
	 * This function calls the WooCommerce structured data generator to generate
	 * default product data for structured data markup.
	 *
	 * @return void
	 */
	public function get_product_default_data() {
		WC()->structured_data->generate_product_data();
	}

	/**
	 * Retrieves the ID of the Stea product archive template.
	 *
	 * This function checks if WooCommerce is active and if the current page is a shop page,
	 * product category page, or product tag page. If so, it retrieves the ID of the custom
	 * product archive template specified in the taxonomy term meta or global settings. If no
	 * custom template is set, it falls back to the default product archive template. Returns
	 * 0 if no suitable template is found.
	 *
	 * @return int The ID of the Stea product archive template, or 0 if not found.
	 */
	public function stea_product_archive_template() {
		$archive_template_id = 0;
		if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
			$termobj            = get_queried_object();
			$get_all_taxonomies = Helper::stea_get_taxonomies();

			if ( is_shop() || ( is_tax( 'product_cat' ) && is_product_category() ) || ( is_tax( 'product_tag' ) && is_product_tag() ) || ( isset( $termobj->taxonomy ) && is_tax( $termobj->taxonomy ) && array_key_exists( $termobj->taxonomy, $get_all_taxonomies ) ) ) {
				$product_shop_custom_page_id = get_stea_product_archive_id(); // getting the product archive id.
				// Archive Layout Control.
				$steatermlayoutid = 0;
				if ( ( is_tax( 'product_cat' ) && is_product_category() ) || ( is_tax( 'product_tag' ) && is_product_tag() ) ) {

					$product_archive_custom_page_id = get_stea_product_archive_id();

					// Get Meta Value.
					$steatermlayoutid = get_term_meta( $termobj->term_id, 'stea_selectcategory_layout', true ) ? get_term_meta( $termobj->term_id, 'stea_selectcategory_layout', true ) : '0';

					if ( ! empty( $product_archive_custom_page_id ) && '0' == $steatermlayoutid ) {
						$steatermlayoutid = $product_archive_custom_page_id;
					}
				}
				if ( '0' != $steatermlayoutid ) {
					$archive_template_id = $steatermlayoutid;
				} else {
					if ( ! empty( $product_shop_custom_page_id ) ) {
						$archive_template_id = $product_shop_custom_page_id;
					}
				}
				return $archive_template_id;
			}

			return $archive_template_id;
		}
	}

	/**
	 * Redirects the product archive template to a custom template if available.
	 *
	 * This function checks if a custom archive product template is set for Stea products.
	 * If a custom template is set, it redirects to that template. Otherwise, it falls back
	 * to the default WooCommerce archive-product.php template. If debug mode is enabled or
	 * if the current user can manage options, it allows the override of the default template.
	 * Additionally, it handles special cases where the archive template is created using
	 * Elementor, redirecting to the appropriate Elementor-based template accordingly.
	 *
	 * @param string $template The path to the currently assigned template file.
	 * @return string The updated path to the template file.
	 */
	public function stea_redirect_product_archive_template( $template ) {
		$archive_template_id = $this->stea_product_archive_template();
		$templatefile        = array();
		$templatefile[]      = 'templates/woocommerce/archive-product.php';
		if ( '0' != $archive_template_id ) {
			$template = locate_template( $templatefile );
			if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ) {
				$template = $this->dir . 'templates/woocommerce/archive-product.php';
			}
			$page_template_slug = get_page_template_slug( $archive_template_id );
			if ( 'elementor_header_footer' === $page_template_slug ) {
				$template = $this->dir . 'templates/woocommerce/archive-product-fullwidth.php';
			} elseif ( 'elementor_canvas' === $page_template_slug ) {
				$template = $this->dir . 'templates/woocommerce/archive-product-canvas.php';
			}
		}
		return $template;
	}
	/**
	 * Retrieves and displays the content for the Stea archive product page.
	 *
	 * This function retrieves the appropriate template for the Stea archive product page
	 * and displays its content. If Elementor plugin is active, it utilizes Elementor's
	 * frontend builder to fetch and display the content. Otherwise, it falls back to
	 * displaying the default content.
	 *
	 * @param WP_Post $post The post object for the current page.
	 * @return void
	 */
	public function stea_archive_product_page_content( $post ) {
		$archive_template_id = $this->stea_product_archive_template();
		if ( '0' != $archive_template_id ) {
			echo class_exists( '\Elementor\Plugin' ) ? ( Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $archive_template_id ) ) : '';//phpcs:ignore
		} else {
			the_content(); }
	}
}
