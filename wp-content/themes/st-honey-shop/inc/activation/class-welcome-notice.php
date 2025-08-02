<?php
/**
 * Welcome Notice class.
 */
class ST_Honey_Shop_Welcome_Notice {

	/**
	** Constructor.
	*/
	public function __construct() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Render Notice
		add_action( 'admin_notices', [$this, 'st_honey_shop_render_notice'] );

		// Enque AJAX Script
		add_action( 'admin_enqueue_scripts', [$this, 'st_honey_shop_admin_enqueue_scripts'], 5 );

		// Dismiss
		add_action( 'admin_enqueue_scripts', [$this, 'st_honey_shop_notice_enqueue_scripts'], 5 );
		add_action( 'wp_ajax_sb_st_honey_shop_dismissed_handler', [$this, 'st_honey_shop_dismissed_handler'] );

		// Reset
		add_action( 'switch_theme', [$this, 'st_honey_shop_reset_notices'] );
		add_action( 'after_switch_theme', [$this, 'st_honey_shop_reset_notices'] );

		// Install Plugins
		add_action( 'wp_ajax_sthoneyshop_install_activate_st_demo_importer', [$this, 'st_honey_shop_install_activate_st_demo_importer'] );
		add_action( 'wp_ajax_nopriv_sthoneyshop_install_activate_st_demo_importer', [$this, 'st_honey_shop_install_activate_st_demo_importer'] );

		add_action( 'wp_ajax_st_honey_shop_cancel_elementor_redirect', [$this, 'st_honey_shop_cancel_elementor_redirect'] );
	}

	public function st_honey_shop_cancel_elementor_redirect() {
		exit;
	}

	/**
	** Get plugin status.
	*/
	public function st_honey_shop_get_plugin_status( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
	
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
			return 'not_installed';
		} else {
			$plugin_updates = get_site_transient( 'update_plugins' );
			$plugin_needs_update = is_object($plugin_updates) && isset($plugin_updates->response) && is_array($plugin_updates->response) 
				? array_key_exists($plugin_path, $plugin_updates->response) 
				: false;
	
			if ( in_array( $plugin_path, (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin_path ) ) {
				return $plugin_needs_update ? 'active_update' : 'active';
			} else {
				return $plugin_needs_update ? 'inactive_update' : 'inactive';
			}    
		}
	}
	

	/**
	** Install a plugin.
	*/
	public function st_honey_shop_install_plugin( $plugin_slug ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		if ( false === filter_var( $plugin_slug, FILTER_VALIDATE_URL ) ) {
			$api = plugins_api(
				'plugin_information',
				[
					'slug'   => $plugin_slug,
					'fields' => [
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'compatibility'     => false,
						'homepage'          => false,
						'donate_link'       => false,
					],
				]
			);

			$download_link = $api->download_link;
		} else {
			$download_link = $plugin_slug;
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$install = $upgrader->install( $download_link );

		if ( false === $install ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update a plugin.
	*/
	public function st_honey_shop_update_plugin( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->upgrade( $plugin_path );

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update all plugins.
	*/
	public function st_honey_shop_update_all_plugins() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->bulk_upgrade([
			'elementor/elementor.php',
			'st-demo-importer/st-demo-importer.php'
		]);

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Activate a plugin.
	*/
	public function st_honey_shop_activate_plugin( $plugin_path ) {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return false;
		}

		$activate = activate_plugin( $plugin_path, '', false, false ); // TODO: last argument changed to false instead of true

		if ( is_wp_error( $activate ) ) {
			return false;
		} else {
			return true;
		}
	}


	/**
	** Install ST Demo Impoter.
	*/
	public function st_honey_shop_install_activate_st_demo_importer() {
		check_ajax_referer( 'nonce', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions to install the plugin.', 'st-honey-shop' ) );
			wp_die();
		}

		$plugin_status = $this->st_honey_shop_get_plugin_status( 'st-demo-importer/st-demo-importer.php' );

		if ( 'not_installed' === $plugin_status ) {
			$this->st_honey_shop_install_plugin( 'st-demo-importer' );
			$this->st_honey_shop_activate_plugin( 'st-demo-importer/st-demo-importer.php' );

		} else {
			if ( 'inactive' === $plugin_status ) {
				$this->st_honey_shop_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			} elseif ( 'inactive_update' === $plugin_status || 'active_update' === $plugin_status ) {
				$this->st_honey_shop_update_plugin( 'st-demo-importer/st-demo-importer.php' );
				$this->st_honey_shop_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			}
		}

		if ( 'active' === $this->st_honey_shop_get_plugin_status( 'st-demo-importer/st-demo-importer.php' ) ) {
			wp_send_json_success();
		}

		wp_send_json_error( esc_html__( 'Failed to initialize or activate importer plugin.', 'st-honey-shop' ) );

		wp_die();
	}

	/**
	** Render Notice
	*/
	public function st_honey_shop_render_notice() {
		global $pagenow;

		$screen = get_current_screen();
		
		if ( 'stdemoimporter-wizard' !== $screen->parent_base ) {
			$transient_name = sprintf( '%s_activation_notice', get_template() );

			if ( ! get_transient( $transient_name ) ) {
				?>
				<div class="notice notice-success is-dismissible st-honey-shop-notice" data-notice="<?php echo esc_attr( $transient_name ); ?>">
					<button type="button" class="notice-dismiss"></button>

					<?php $this->st_honey_shop_render_notice_content(); ?>
				</div>
				<?php
			}
		}
	}

	/**
	** Render Notice Content
	*/
	public function st_honey_shop_render_notice_content() {
		$action = 'install-activate';
		$freemius_passed = 'false';
		$redirect_url = 'admin.php?page=stdemoimporter-wizard';
		$st_demo_importer_status = $this->st_honey_shop_get_plugin_status('st-demo-importer/st-demo-importer.php');
	
		if ('active' === $st_demo_importer_status) {
			$action = 'default';
		}
	
		$screen = get_current_screen();
		$flex_attr = '';
		$display_attr = 'display: inline-block !important';
	
		if ('toplevel_page_stdemoimporter-wizard' === $screen->id) {
			$flex_attr = 'display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center';
			$display_attr = 'display: none !important';
		} ?>
	
		<div class="st-honey-shop-welcome-message" style="<?php echo esc_attr($flex_attr); ?>">
			<h1 style="<?php echo esc_attr($display_attr); ?>">
				<?php esc_html_e('Welcome to ST Honey Shop', 'st-honey-shop'); ?>
			</h1>
			<p>
				<?php esc_html_e('ST Honey Shop is a beautifully designed WordPress theme for honey producers, beekeepers, and organic sellers, built with Elementor for easy customization. Featuring WooCommerce integration, responsive design, and SEO-ready code, it helps you showcase and sell honey products effortlessly. With its warm palette and elegant layouts, it’s perfect for building trust and growing your honey brand online.', 'st-honey-shop'); ?>
			</p>
			<div class="st-honey-shop-action-buttons">
				<a href="<?php echo esc_url(admin_url($redirect_url)); ?>" class="button button-primary" data-action="<?php echo esc_attr($action); ?>" data-freemius="<?php echo esc_attr($freemius_passed); ?>">
					<?php esc_html_e('Get Started with St Demo Importer', 'st-honey-shop'); ?>
					<span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/product/honey-wordpress-theme/'); ?>" class="button button-primary st-honey-shop-buy-now" target="_blank">
					<?php esc_html_e('Buy Now', 'st-honey-shop'); ?>
					<span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/demo/st-honey-shop-pro'); ?>" class="button button-primary st-honey-shop-view-demo" target="_blank">
					<?php esc_html_e('Demo', 'st-honey-shop'); ?>
					<span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
			</div>
		</div>
		<?php
	}
	

	/**
	** Reset Notice.
	*/
	public function st_honey_shop_reset_notices() {
		delete_transient( sprintf( '%s_activation_notice', get_template() ) );
	}

	/**
	** Dismissed handler
	*/
	public function st_honey_shop_dismissed_handler() {
        check_ajax_referer('sb_dismiss_notice_nonce', 'nonce');

        if ( ! current_user_can('administrator') ) {
            return;
        }

		if ( isset( $_POST['notice'] ) ) {
			set_transient( sanitize_text_field( wp_unslash( $_POST['notice'] ) ), true, 0 );
		}
	}

	/**
	** Notice Enqunue Scripts
	*/
	public function st_honey_shop_notice_enqueue_scripts( $page ) {
		
		wp_enqueue_script( 'jquery' );

        // Generate a nonce
        $nonce = wp_create_nonce('sb_dismiss_notice_nonce');

		ob_start();
		?>
		<script>
			jQuery(function($) {
				$( document ).on( 'click', '.st-honey-shop-notice .notice-dismiss', function () {
					jQuery.post( 'ajax_url', {
						action: 'sb_st_honey_shop_dismissed_handler',
						notice: $( this ).closest( '.st-honey-shop-notice' ).data( 'notice' ),
                        nonce: '<?php echo $nonce; ?>', // Pass the nonce here
					});
					$( '.st-honey-shop-notice' ).hide();
				} );
			});
		</script>
		<?php
		$script = str_replace( 'ajax_url', admin_url( 'admin-ajax.php' ), ob_get_clean() );

		wp_add_inline_script( 'jquery', str_replace( ['<script>', '</script>'], '', $script ) );
	}

	/**
	** Register scripts and styles for welcome notice.
	*/
	public function st_honey_shop_admin_enqueue_scripts( $page ) {
		// Enqueue Scripts
		wp_enqueue_script( 'st-honey-shop-welcome-notic-js', get_template_directory_uri() . '/inc/activation/js/welcome-notice.js', ['jquery'], false, true );

		wp_localize_script( 'st-honey-shop-welcome-notic-js', 'st_honey_shop_localize', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'elementor_nonce' => wp_create_nonce( 'nonce' ),
			'st_demo_importer_nonce' => wp_create_nonce( 'nonce' ),
			'failed_message' => esc_html__( 'Something went wrong, contact support.', 'st-honey-shop' ),
		] );

		// Enqueue Styles.
		wp_enqueue_style( 'st-honey-shop-welcome-notic-css', get_template_directory_uri() . '/inc/activation/css/welcome-notice.css' );
	}

}

new ST_Honey_Shop_Welcome_Notice();