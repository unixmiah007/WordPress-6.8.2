<?php

use Elementor\Core\Files\CSS\Post;
use Elementor\Frontend;
use Elementor\Post_CSS_File;
use ElementorPro\Plugin;
use Stea_Theme_Builder\Lib\Stea_Target_Rules_Fields;
// use \Stea_Theme_Builder_Settings;
/**
 * Class Stea_Theme_Builder_Main
 */
class Stea_Theme_Builder_Main {

	/**
	 * Instance of Stea_Theme_Builder_Main
	 *
	 * @var Stea_Theme_Builder_Main
	 */
	private static $instance = null;

	/**
	 * Instance of Elementor Frontend class.
	 *
	 * @var Frontend()
	 */
	private static $elementor_instance;
	/**
	 * Current theme template
	 *
	 * @var String
	 */
	public $template;

	/**
	 * Instance of Stea_Theme_Builder_Main
	 *
	 * @return Stea_Theme_Builder_Main Instance of Stea_Theme_Builder_Main
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	public function init() {

		$this->template = get_template();

		self::$elementor_instance = ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) ? Elementor\Plugin::instance() : '';

		if ( self::$elementor_instance ) {

			$this->includes();

			if ( 'stea' === $this->template ) {
				require STEA_PATH . 'theme-builder/themes/class-stea-compatibility.php';
			} elseif ( 'astra' === $this->template ) {
				require STEA_PATH . 'theme-builder/themes/class-astra-compatibility.php';
			} elseif ( 'generatepress' === $this->template ) {
				require STEA_PATH . 'theme-builder/themes/class-generatepress-compatibility.php';
			} elseif ( 'megaone' === $this->template ) {
				require STEA_PATH . 'theme-builder/themes/class-megaone-compatibility.php';
			} elseif ( 'oceanwp' === $this->template ) {
				require STEA_PATH . 'theme-builder/themes/class-oceanwp-compatibility.php';
			} else {
				require STEA_PATH . 'theme-builder/themes/class-default-compatibility.php';
			}

			// Scripts and styles.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			//Plugin Row Meta & Link
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
			add_filter( 'plugin_action_links_' . STEA_BASE, array( $this, 'plugin_action_links' ) );

			add_shortcode( 'stea_theme_builder_template', array( $this, 'render_template' ) );

			//Add Elementor Modules
			add_action( 'init', array( $this, 'register_modules' ) );

			// Register Document Type
			add_action( 'elementor/documents/register', array( $this, 'register_elementor_document_type' ) );

			//Comment Shortcode
			add_shortcode( 'stea_comments_template', array( $this, 'stea_theme_builder_comments_template' ) );

		}

	}

	/**
	 * Loads the globally required files for the plugin.
	 */
	public function includes() {

		require_once STEA_PATH . 'theme-builder/admin/class-stea-admin.php';
		require_once STEA_PATH . 'theme-builder/admin/class-stea-rest-api.php';

		require_once STEA_PATH . 'theme-builder/inc/stea-functions.php';

		// Load Target rules.
		require_once STEA_PATH . 'theme-builder/lib/target-rule/class-stea-target-rules-fields.php';

		// Load WPML & Polylang Compatibility if WPML is installed and activated.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) || defined( 'POLYLANG_BASENAME' ) ) {
			require_once STEA_PATH . 'theme-builder/inc/wpml-compatibility.php';
		}

	}

	/**
	 * Prints the Header content.
	 */
	public static function get_header_content() {
		if ( self::$elementor_instance ) {
			echo self::$elementor_instance->frontend->get_builder_content_for_display( get_stea_theme_builder_header_id() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Prints the Footer content.
	 */
	public static function get_footer_content() {
		if ( self::$elementor_instance ) {
			echo self::$elementor_instance->frontend->get_builder_content_for_display( get_stea_theme_builder_footer_id() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Prints the Before Footer content.
	 */
	public static function get_singular_content() {
		if ( self::$elementor_instance ) {
			echo self::$elementor_instance->frontend->get_builder_content_for_display( stea_theme_builder_get_singular_id() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Prints the Before Footer content.
	 */
	public static function get_archive_content() {
		if ( self::$elementor_instance ) {
			echo self::$elementor_instance->frontend->get_builder_content_for_display( stea_theme_builder_get_archive_id() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Get option for the plugin settings
	 *
	 * @param mixed $setting Option name.
	 * @param mixed $default Default value to be received if the option value is not stored in the option.
	 *
	 * @return mixed.
	 */
	public static function get_settings( $setting = '', $default = '' ) {
		if ( 'type_header' === $setting || 'type_footer' === $setting || 'type_singular' === $setting || 'type_archive' === $setting ) {
			$templates = self::get_template_id( $setting );
			$template  = ! is_array( $templates ) ? $templates : $templates[0];
			$template  = apply_filters( "stea_theme_builder_get_settings_{$setting}", $template );
			return $template;
		}
	}

	/**
	 * Get header or footer template id based on the meta query.
	 *
	 * @param String $type Type of the template header/footer.
	 *
	 * @return Mixed       Returns the header or footer template id if found, else returns string ''.
	 */
	public static function get_template_id( $type ) {

		$option = array(
			'location'  => 'stea_theme_builder_target_include_locations',
			'exclusion' => 'stea_theme_builder_target_exclude_locations',
			'users'     => 'stea_theme_builder_target_user_roles',
		);

		$stea_theme_builder_templates = Stea_Target_Rules_Fields::get_instance()->get_posts_by_conditions( 'stea-theme-template', $option );

		foreach ( $stea_theme_builder_templates as $template ) {
			if ( get_post_meta( absint( $template['id'] ), 'stea_theme_builder_template_type', true ) === $type ) {
				return $template['id'];
			}
		}

		return '';
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {

		wp_enqueue_style( 'st-elementor-addons', STEA_URL . 'theme-builder/assets/css/stea-theme-builder.css', null, STEA_VERSION );
		wp_enqueue_script( 'st-elementor-addons', STEA_URL . 'theme-builder/assets/js/stea-theme-builder.js', array( 'jquery' ), STEA_VERSION, true );

		wp_script_add_data( 'st-elementor-addons', 'async', true );

		//Frontend Panel
		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) && ! ( self::$elementor_instance && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {

			global $user_ID;

			wp_enqueue_style( 'st-elementor-addons-frontend', STEA_URL . 'theme-builder/admin/assets/css/stea-frontend.css', array(), STEA_VERSION );
			wp_enqueue_script( 'st-elementor-addons-frontend', STEA_URL . 'theme-builder/admin/assets/js/stea-frontend.js', array(), STEA_VERSION, true );
			wp_enqueue_script( 'st-elementor-addons-frontend-chunk', STEA_URL . 'theme-builder/admin/assets/js/stea-chunk.js', array(), STEA_VERSION, true );
			wp_enqueue_script( 'st-elementor-addons-frontend-main', STEA_URL . 'theme-builder/admin/assets/js/stea-main.js', array(), STEA_VERSION, true );
			wp_localize_script(
				'st-elementor-addons-frontend',
				'SteaThemeBuilderApi',
				array(
					'ApiUrl'   => get_rest_url(),
					'siteUrl'  => get_site_url(),
					'adminUrl' => get_admin_url(),
					'user'     => $user_ID,
					'nonce'    => wp_create_nonce( 'wp_rest' ),
				)
			);
		}

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			if (method_exists(Plugin::instance(), 'enqueue_styles')) {
				$elementor_pro = Plugin::instance();
				$elementor_pro->enqueue_styles();
			}
		}

		if ( self::$elementor_instance && stea_theme_builder_header_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Post( get_stea_theme_builder_header_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new Post_CSS_File( get_stea_theme_builder_header_id() );
			}

			$css_file->enqueue();
		}

		if ( self::$elementor_instance && stea_theme_builder_footer_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Post( get_stea_theme_builder_footer_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new Post_CSS_File( get_stea_theme_builder_footer_id() );
			}

			$css_file->enqueue();
		}

		if ( self::$elementor_instance && stea_theme_builder_is_singular_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Post( stea_theme_builder_get_singular_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new Post_CSS_File( stea_theme_builder_get_singular_id() );
			}
			$css_file->enqueue();
		}

		if ( self::$elementor_instance && stea_theme_builder_is_archive_enabled() ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Post( stea_theme_builder_get_archive_id() );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$css_file = new Post_CSS_File( stea_theme_builder_get_archive_id() );
			}
			$css_file->enqueue();
		}

	}

	/**
	 * Load admin styles on header footer elementor edit screen.
	 */
	public function enqueue_admin_scripts() {

		global $pagenow;
		$screen = get_current_screen();

		wp_enqueue_style( 'st-elementor-addons-admin', STEA_URL . 'theme-builder/admin/assets/css/stea-admin.css', array(), STEA_VERSION );

		if ( ( 'stea-theme-template' === $screen->id && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) || ( 'edit.php' === $pagenow && 'edit-stea-theme-template' === $screen->id ) ) {

			wp_enqueue_script( 'st-elementor-addons-admin', STEA_URL . 'theme-builder/admin/assets/js/stea-admin.js', array( 'jquery' ), STEA_VERSION, true );

		}
	}

	/**
	 * Adds classes to the body tag conditionally.
	 *
	 * @param Array $classes array with class names for the body tag.
	 *
	 * @return Array          array with class names for the body tag.
	 */
	public function body_class( $classes ) {

		$classes[] = 'st-elementor-addons-template';

		return $classes;
	}

	/**
	 * Callback to shortcode.
	 *
	 * @param array $atts attributes for shortcode.
	 */
	public function render_template( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'stea_theme_builder_template'
		);

		$id = ! empty( $atts['id'] ) ? apply_filters( 'stea_theme_builder_render_template_id', intval( $atts['id'] ) ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		$post = get_post( $id );
		if ( ! $post ) {
			wp_die( __( 'Post not found.', 'st-elementor-addons' ), 404 );
		}
		    if ( ! empty( $post->post_password ) && post_password_required( $post ) ) {
			wp_die( __( 'This post is password protected.', 'st-elementor-addons' ), 403 );
		}
		if ( $post->post_status === 'trash' ) {
			wp_die( __( 'You are not allowed to access this post (Trashed Post).', 'st-elementor-addons' ), 403 );
		}
		$post_status = $post->post_status;
		$status_labels = [
			'private' => 'Private Post',
			'draft' => 'Draft Post',
			'pending' => 'Pending Post',
			'trash' => 'Trashed Post',
		];
		if (
			in_array( $post_status, array_keys( $status_labels ), true ) &&
			! current_user_can( 'read_post', $id )
		) {
			$label = $status_labels[ $post_status ];
			wp_die( sprintf( __( 'You are not allowed to access this post(%s).', 'st-elementor-addons' ), $label ), 403 );
		}

		if ( self::$elementor_instance ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new Post( $id );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				// Load elementor styles.
				$css_file = new Post_CSS_File( $id );
			}
			$css_file->enqueue();
		}

		if ( self::$elementor_instance ) {
			return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
		}

	}

	/**
	 * Plugin row meta.
	 *
	 * Adds row meta links to the plugin list table
	 *
	 * Fired by `plugin_row_meta` filter.
	 *
	 * @param array $plugin_meta An array of the plugin's metadata, including
	 *                            the version, author, author URI, and plugin URI.
	 * @param string $plugin_file Path to the plugin file, relative to the plugins
	 *                            directory.
	 *
	 * @return array An array of plugin row meta links.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( STEA_BASE === $plugin_file ) {
			$row_meta    = array( 'docs' => '<a href="https://elementor.wpstea.com/docs/" aria-label="' . esc_attr( esc_html__( 'View Documentation', 'st-elementor-addons' ) ) . '" target="_blank">' . esc_html__( 'Documentation', 'st-elementor-addons' ) . '</a>' );
			$plugin_meta = array_merge( $plugin_meta, $row_meta );
		}

		return $plugin_meta;
	}

	/**
	 * Plugin action links.
	 *
	 * Adds action links to the plugin list table
	 *
	 * Fired by `plugin_action_links` filter.
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array An array of plugin action links.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function plugin_action_links( $links ) {
		$settings_link = sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'edit.php?post_type=stea-theme-template' ), esc_html__( 'Settings', 'st-elementor-addons' ) );
		array_unshift( $links, $settings_link );
		$links['rate_us'] = sprintf( '<a href="%1$s" target="_blank" class="st-elementor-addons-gopro">%2$s</a>', 'https://wordpress.org/plugins/st-elementor-addons/#reviews', esc_html__( 'Rate Us', 'st-elementor-addons' ) );
		return $links;
	}

	/**
	 * Register Modules
	 *
	 * Register Modules Settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function register_modules() {
		include_once STEA_PATH . 'theme-builder/inc/header-sticky.php';
	}

	/**
	 * Register Document Type
	 *
	 * Register Modules Settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function register_elementor_document_type( $documents_manager ) {
		if ( get_post_type() === 'stea-theme-template' ) {
			update_post_meta( get_the_ID(), '_elementor_template_type', 'stea-theme-template' );
		}
		include_once STEA_PATH . 'theme-builder/inc/preview-settings.php';
		$documents_manager->register_document_type( Stea_Theme_Builder_Settings::get_type(), Stea_Theme_Builder_Settings::get_class_full_name() );
	}

	/**
	 * Create Shortcode for Comment
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function stea_theme_builder_comments_template() {
		if ( ( comments_open() || get_comments_number() ) ) {
			comments_template();
		}
	}



}

// Instantiate Stea_Theme_Builder_Main Class
Stea_Theme_Builder_Main::instance();
