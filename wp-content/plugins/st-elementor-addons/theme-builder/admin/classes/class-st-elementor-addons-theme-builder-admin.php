<?php
/**
 * STEA Theme Builder's Admin part.
 *
 * @package  ST_Elementor_Addons
 * @package  ST_Elementor_Addons
 */

namespace ST_Elementor_Addons\Admin\Theme_Builder;

use ST_Elementor_Addons\ModulesManager\Theme_Builder\Conditions\STEA_Conditions;
use ST_Elementor_Addons\ModulesManager\Theme_Builder\STEA_Theme_Builder;
use ST_Elementor_Addons\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * STEA_HF_Admin Class.
 *
 * @since 1.3.0
 */
class STEA_HF_Admin {
	use Singleton;

	/**
	 * Post type slug.
	 *
	 * @var string
	 */
	public $post_type = 'stea-theme-template';

	/**
	 * Template type arg for URL.
	 *
	 * @var string
	 */
	public $type_tax = 'template_type';

	/**
	 * Constructor
	 *
	 * @access private
	 *
	 * @since 1.3.0
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_stea_theme_builder_posttype' ) );
		add_filter( 'views_edit-' . $this->post_type, array( $this, 'print_type_tabs' ) );
		add_filter( 'parse_query', array( $this, 'prefix_parse_filter' ) );
		add_action( 'add_meta_boxes', array( $this, 'stea_hf_register_metabox' ) );
		add_action( 'save_post', array( $this, 'stea_hf_save_meta_data' ) );
		add_action( 'admin_notices', array( $this, 'location_notice' ) );
		add_action( 'template_redirect', array( $this, 'block_template_frontend' ) );
		add_filter( 'single_template', array( $this, 'load_canvas_template' ) );
		add_filter( 'manage_stea-theme-template_posts_columns', array( $this, 'add_shortcode_column' ) );
		add_filter( 'manage_stea-theme-template_posts_columns', array( $this, 'add_type_column' ) );
		add_action( 'manage_stea-theme-template_posts_custom_column', array( $this, 'render_shortcode_column' ), 10, 2 );
		add_action( 'manage_stea-theme-template_posts_custom_column', array( $this, 'render_type_column' ), 10, 2 );
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) && ELEMENTOR_PRO_VERSION > 2.8 ) {
			add_action( 'elementor/editor/footer', array( $this, 'register_stea_epro_script' ), 99 );
		}

		if ( is_admin() ) {
			add_action( 'manage_stea-theme-template_posts_custom_column', array( $this, 'render_column_content' ), 10, 2 );
			add_filter( 'manage_stea-theme-template_posts_columns', array( $this, 'add_column_headings' ) );
		}
	}

	/**
	 * Parse query to filter specific temlpate type.
	 *
	 * @param object $query
	 */
	public function prefix_parse_filter( $query ) {
		global $pagenow;
		$current_page = isset( $_GET[ $this->type_tax ] ) ? $_GET[ $this->type_tax ] : '';

		if ( is_admin() &&
			'edit.php' == $pagenow &&
			isset( $_GET[ $this->type_tax ] ) &&
			$_GET[ $this->type_tax ] != '' ) {

			$query->query_vars['meta_key']     = 'stea_hf_template_type';
			$query->query_vars['meta_value']   = $current_page;
			$query->query_vars['meta_compare'] = '=';
		}
	}

	/**
	 * Print library types tabs.
	 *
	 * @param array $edit_links
	 *
	 * @since 1.8.0 Added single-product.
	 * @since 1.8.0 Added Product Archive
	 * @return array containing links for navigation tabs
	 */
	public function print_type_tabs( $edit_links ) {

		$tabs = array(
			'all'             => esc_html__( 'All', 'st-elementor-addons' ),
			'header'          => esc_html__( 'Header', 'st-elementor-addons' ),
			'footer'          => esc_html__( 'Footer', 'st-elementor-addons' ),
			'single-page'     => esc_html__( 'Single Page', 'st-elementor-addons' ),
			'single-post'     => esc_html__( 'Single Post', 'st-elementor-addons' ),
			'error-404'       => esc_html__( 'Error 404', 'st-elementor-addons' ),
			'archive'         => esc_html__( 'Archive', 'st-elementor-addons' ),
			'single-product'  => esc_html__( 'Single Product', 'st-elementor-addons' ),
			'product-archive' => esc_html__( 'Product Archive', 'st-elementor-addons' ),
		);

		$active_tab = isset( $_GET[ $this->type_tax ] ) ? $_GET[ $this->type_tax ] : 'all';
		$page_link  = admin_url( 'edit.php?post_type=' . $this->post_type );

		if ( ! array_key_exists( $active_tab, $tabs ) ) {
			$active_tab = 'all';
		} ?>

		<div class="nav-tab-wrapper jet-library-tabs">
			<?php
			foreach ( $tabs as $tab => $label ) {

				$class = 'nav-tab';

				if ( $tab === $active_tab ) {
					$class .= ' nav-tab-active';
				}

				if ( 'all' !== $tab ) {
					$link = add_query_arg( array( $this->type_tax => $tab ), $page_link );
				} else {
					$link = $page_link;
				}

				printf( '<a href="%1$s" class="%3$s">%2$s</a>', esc_url( $link ), esc_html( $label ), esc_attr( $class ) );

			}
			?>
		</div>
		<br>
		<?php
		return $edit_links;
	}

	/**
	 * Script for Elementor Pro full site editing support.
	 *
	 * @access public
	 *
	 * @since 1.5.0 Added Archive to $ids.
	 * @since 1.8.0 Added Single Product to $ids.
	 * @since 1.8.0 Added Product Archive to $ids
	 *
	 * @return void
	 */
	public function register_stea_epro_script() {
		$ids = array(
			array(
				'id'    => get_stea_header_id(),
				'value' => 'Header',
			),
			array(
				'id'    => get_stea_footer_id(),
				'value' => 'Footer',
			),
			array(
				'id'    => get_stea_single_page_id(),
				'value' => 'Single Page',
			),
			array(
				'id'    => get_stea_single_post_id(),
				'value' => 'Single Post',
			),
			array(
				'id'    => get_stea_error_404_id(),
				'value' => 'Error 404',
			),
			array(
				'id'    => get_stea_archive_id(),
				'value' => 'Archive',
			),
		);
		// Single product and product archive will be added in $ids array when woocommerce is activated.
		if ( class_exists( 'WooCommerce' ) ) {
			array_push(
				$ids,
				array(
					'id'    => get_stea_single_product_id(),
					'value' => 'Single Product',
				),
				array(
					'id'    => get_stea_product_archive_id(),
					'value' => 'Product Archive',
				),
			);

		}

		wp_enqueue_script(
			'stea-hf-epro-compatibility',
			STEA_URL . 'theme-builder/includes/modules-manager/theme-builder/compatibility/js/stea-theme-epro-compatibility.js',
			array( 'jquery' ),
			STEA_VERSION,
			true
		);

		wp_localize_script(
			'stea-hf-epro-compatibility',
			'stea_hf_admin',
			array(
				'ids' => wp_json_encode( $ids ),
			)
		);
	}

	/**
	 * Add or remove admin table column headings.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param array $columns Array of columns.
	 *
	 * @return array
	 */
	public function add_column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['stea_hf_template_display_conditions'] = __( 'Display Conditions', 'st-elementor-addons' );
		$columns['date']                                = __( 'Date', 'st-elementor-addons' );

		return $columns;
	}

	/**
	 * Render column content.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param array $column  Name of column.
	 * @param int   $post_id Post id.
	 *
	 * @return void
	 */
	public function render_column_content( $column, $post_id ) {

		if ( 'stea_hf_template_display_conditions' === $column ) {

			$locations = get_post_meta( $post_id, 'stea_hf_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="stea-hf__admin-column-include-locations-wrapper" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'stea_hf_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="stea-hf__admin-column-exclude-locations-wrapper" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'stea_hf_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = array();
					foreach ( $users as $user ) {
						$user_label[] = STEA_Conditions::get_user_by_key( $user );
					}
					echo '<div class="stea-hf__admin-column-target-users-wrapper">';
					echo '<strong>Users: </strong>';
					echo join( ', ', $user_label ); // phpcs:ignore
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display conditions column.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param array $locations Array of locations.
	 *
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = array();
		$index          = array_search( 'specifics', $locations['rule'] ); // phpcs:ignore
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = STEA_Conditions::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = STEA_Conditions::get_location_by_key( $location );
			}
		}

		echo join( ', ', $location_label ); // phpcs:ignore
	}


	/**
	 * Register STEA Theme Builder post type.
	 *
	 * @access public
	 *
	 * @since 1.3.2 post_type changed to stea-theme-template
	 *
	 * @return void
	 */
	public function register_stea_theme_builder_posttype() {
		$labels = array(
			'name'               => __( 'Theme Builder', 'st-elementor-addons' ),
			'singular_name'      => __( 'Theme Builder', 'st-elementor-addons' ),
			'menu_name'          => __( 'Theme Template', 'st-elementor-addons' ),
			'name_admin_bar'     => __( 'Theme Template', 'st-elementor-addons' ),
			'add_new'            => __( 'Add New', 'st-elementor-addons' ),
			'add_new_item'       => __( 'Add New Template', 'st-elementor-addons' ),
			'new_item'           => __( 'New Template', 'st-elementor-addons' ),
			'edit_item'          => __( 'Edit Template', 'st-elementor-addons' ),
			'view_item'          => __( 'View Template', 'st-elementor-addons' ),
			'all_items'          => __( 'All Templates', 'st-elementor-addons' ),
			'search_items'       => __( 'Search Templates', 'st-elementor-addons' ),
			'parent_item_colon'  => __( 'Parent Template:', 'st-elementor-addons' ),
			'not_found'          => __( 'No Templates found.', 'st-elementor-addons' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'st-elementor-addons' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'rewrite'             => false,
			'supports'            => array( 'title', 'thumbnail', 'elementor' ),
		);

		register_post_type( 'stea-theme-template', $args );
	}

	/**
	 * Get help doc URL.
	 *
	 * @since 1.3.2 Slug changed to stea-theme-builder
	 *
	 * @return string Doc URL.
	 */
	public function get_help_url() {
		return '';
	}

	/**
	 * Register meta box(es).
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @return void
	 */
	public function stea_hf_register_metabox() {
		$help_url     = $this->get_help_url();
		$help_element = '<a href="' . esc_url( $help_url ) . '" class="stea-hf__need-help" target="_blank">Need Help?</a>';

		add_meta_box(
			'stea-hf-meta-box',
			// translators: %1$s represents the help element.
			sprintf( __( 'Template Meta Settings %1$s', 'st-elementor-addons' ), $help_element ),
			array(
				$this,
				'stea_hf_metabox_render',
			),
			'stea-theme-template',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta box(es) content.
	 *
	 * @access public
	 *
	 * @since 1.5.0 Added Archive option.
	 * @since 1.8.0 Added single-product option.
	 *
	 * @param POST $post Current post object which is being displayed.
	 *
	 * @return void
	 */
	public function stea_hf_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['stea_hf_template_type'] ) ? esc_attr( $values['stea_hf_template_type'][0] ) : '';
		$display_on_canvas = isset( $values['stea-hf__enable-for-canvas'] ) ? true : false;

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'stea_hf_meta_nonce', 'stea_hf_meta_nonce' );
		?>
		<table class="stea-hf__meta-options-table widefat">
			<tbody>
				<tr class="stea-hf__meta-options-row type-of-template">
					<td class="stea-hf__meta-options-row-heading">
						<label for="stea_hf_template_type"><?php esc_html_e( 'Type of Template', 'st-elementor-addons' ); ?></label>
					</td>
					<td class="stea-hf__meta-options-row-body">
						<select name="stea_hf_template_type" id="stea_hf_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php esc_html_e( 'Select Template type', 'st-elementor-addons' ); ?></option>
							<option value="header" <?php selected( $template_type, 'header' ); ?>><?php esc_html_e( 'Header', 'st-elementor-addons' ); ?></option>
							<option value="footer" <?php selected( $template_type, 'footer' ); ?>><?php esc_html_e( 'Footer', 'st-elementor-addons' ); ?></option>
							<option value="single-page" <?php selected( $template_type, 'single-page' ); ?>><?php esc_html_e( 'Single Page', 'st-elementor-addons' ); ?></option>
							<option value="single-post" <?php selected( $template_type, 'single-post' ); ?>><?php esc_html_e( 'Single Post', 'st-elementor-addons' ); ?></option>
							<option value="error-404" <?php selected( $template_type, 'error-404' ); ?>><?php esc_html_e( 'Error 404', 'st-elementor-addons' ); ?></option>
							<option value="archive" <?php selected( $template_type, 'archive' ); ?>><?php esc_html_e( 'Archive', 'st-elementor-addons' ); ?></option>
							<option value="single-product" <?php selected( $template_type, 'single-product' ); ?>><?php esc_html_e( 'Single Product', 'st-elementor-addons' ); ?></option>
							<option value="product-archive" <?php selected( $template_type, 'product-archive' ); ?>><?php esc_html_e( 'Product  Archive', 'st-elementor-addons' ); ?></option>
						</select>
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
				<tr class="stea-hf__meta-options-row stea-hf__shortcode">
					<td class="stea-hf__meta-options-row-heading">
						<label for="stea-hf__template-shortcode"><?php esc_html_e( 'Shortcode', 'st-elementor-addons' ); ?></label>
						<i class="stea-hf__meta-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html__( 'Copy this shortcode and paste it into your post, page, or text widget content.', 'st-elementor-addons' ); ?>">
						</i>
					</td>
					<td class="stea-hf__meta-options-row-body">
						<span class="stea-hf__shortcode-column">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[stea_theme_template id='<?php echo esc_attr( $post->ID ); ?>']" class="stea-hf__template-shortcode code">
						</span>
					</td>
				</tr>
				<tr class="stea-hf__meta-options-row stea-hf__enable-for-canvas">
					<td class="stea-hf__meta-options-row-heading">
						<label for="stea-hf__enable-for-canvas">
							<?php esc_html_e( 'Enable Layout for Elementor Canvas Template?', 'st-elementor-addons' ); ?>
						</label>
						<i class="stea-hf__meta-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Enabling this option will allow you to display this template on pages using Elementor Canvas Template.', 'st-elementor-addons' ); ?>"></i>
					</td>
					<td class="stea-hf__meta-options-row-body">
						<input type="checkbox" id="stea-hf__enable-for-canvas" name="stea-hf__enable-for-canvas" value="1" <?php checked( $display_on_canvas, true ); ?> />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Conditions Tabs.
	 *
	 * @access public
	 *
	 * @since  1.3.0
	 */
	public function display_rules_tab() {
		// Load Display Conditions assets.
		STEA_Conditions::instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'stea_hf_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'stea_hf_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'stea_hf_target_user_roles', true );
		?>
		<tr class="stea-hf__display-condition-row stea-hf__meta-options-row">
			<td class="stea-hf__display-condition-row-heading stea-hf__meta-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'st-elementor-addons' ); ?></label>
				<i class="stea-hf__display-condition-row-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add the location(s) for where this template should appear.', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="stea-hf__display-condition-row-body stea-hf__meta-options-row-body">
				<?php
				STEA_Conditions::target_rule_settings_field(
					'stea-hf-include-locations',
					array(
						'title'          => __( 'Display Rules', 'st-elementor-addons' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display On Condition', 'st-elementor-addons' ),
					),
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="stea-hf__display-condition-row stea-hf__meta-options-row">
			<td class="stea-hf__display-condition-row-heading stea-hf__meta-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'st-elementor-addons' ); ?></label>
				<i class="stea-hf__display-condition-row-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add the location(s) for where this template should not appear.', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="stea-hf__display-condition-row-body stea-hf__meta-options-row-body">
				<?php
				STEA_Conditions::target_rule_settings_field(
					'stea-hf-exclude-locations',
					array(
						'title'          => __( 'Exclude On', 'st-elementor-addons' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'st-elementor-addons' ),
						'rule_type'      => 'exclude',
					),
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<tr class="stea-hf__user-role-condition-row stea-hf__meta-options-row">
			<td class="stea-hf__user-role-condition-row-heading stea-hf__meta-options-row-heading">
				<label><?php esc_html_e( 'User Roles', 'st-elementor-addons' ); ?></label>
				<i class="stea-hf__user-role-condition-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Display this template based on user role(s).', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="stea-hf__user-role-condition-body stea-hf__meta-options-row-body">
				<?php
				STEA_Conditions::target_user_role_settings_field(
					'stea-hf-target-user-roles',
					array(
						'title'          => __( 'Users', 'st-elementor-addons' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add User Rule', 'st-elementor-addons' ),
					),
					$users
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save post meta data.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param  POST $post_id Current post object which is being displayed.
	 *
	 * @return Void
	 */
	public function stea_hf_save_meta_data( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['stea_hf_meta_nonce'] ) || ! wp_verify_nonce( $_POST['stea_hf_meta_nonce'], 'stea_hf_meta_nonce' ) ) { // phpcs:ignore
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = STEA_Conditions::get_format_rule_value( $_POST, 'stea-hf-include-locations' );
		$target_exclusion = STEA_Conditions::get_format_rule_value( $_POST, 'stea-hf-exclude-locations' );
		$target_users     = array();

		if ( isset( $_POST['stea-hf-target-user-roles'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['stea-hf-target-user-roles'] ); // phpcs:ignore
		}

		update_post_meta( $post_id, 'stea_hf_include_locations', $target_locations );
		update_post_meta( $post_id, 'stea_hf_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'stea_hf_target_user_roles', $target_users );

		if ( isset( $_POST['stea_hf_template_type'] ) ) {
			update_post_meta( $post_id, 'stea_hf_template_type', esc_attr( $_POST['stea_hf_template_type'] ) ); // phpcs:ignore
		}

		if ( isset( $_POST['stea-hf__enable-for-canvas'] ) ) {
			update_post_meta( $post_id, 'stea-hf__enable-for-canvas', esc_attr( $_POST['stea-hf__enable-for-canvas'] ) ); // phpcs:ignore
		} else {
			delete_post_meta( $post_id, 'stea-hf__enable-for-canvas' );
		}
	}

	/**
	 * Display notice when editing the template when there is one more of similar layout is active on the site.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @return mixed
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' !== $pagenow || ! is_object( $post ) || 'stea-theme-template' !== $post->post_type ) {
			return;
		}

		$template_type = get_post_meta( $post->ID, 'stea_hf_template_type', true );

		if ( '' !== $template_type ) {
			$templates = STEA_Theme_Builder::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID == $templates[0] ) { // phpcs:ignore
				echo '<div class="notice notice-warning is-dismissible"><p>';
				echo esc_html__( 'A template already exists with same display conditions, creating this will override the previous template.', 'st-elementor-addons' );
				echo '</p></div>';
			}
		}
	}

	/**
	 * Convert the Template name to be added in the notice.
	 *
	 * @access public
	 *
	 * @since  1.3.0
	 *
	 * @param  String $template_type Template type name.
	 *
	 * @return String Template type name.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( $template_type );

		return $template_type;
	}

	/**
	 * Don't display the elementor Theme Builder & blocks templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.3.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function block_template_frontend() {
		if ( is_singular( 'stea-theme-template' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 ); // phpcs:ignore
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @access public
	 *
	 * @since  1.3.0
	 *
	 * @param  String $single_template Single template.
	 */
	public function load_canvas_template( $single_template ) {
		global $post;

		if ( 'stea-theme-template' === $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	/**
	 * Add type column to admin.
	 *
	 * @access public
	 *
	 * @param array $columns Columns array.
	 *
	 * @since 1.3.0
	 *
	 * @return array Array of columns after adding type column.
	 */
	public function add_type_column( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['type'] = __( 'Type', 'st-elementor-addons' );
		$columns['date'] = $date_column;

		return $columns;
	}

	/**
	 * Add shortcode column to admin.
	 *
	 * @access public
	 *
	 * @param array $columns Columns array.
	 *
	 * @since 1.3.0
	 *
	 * @return array Array of columns after adding shortcode column.
	 */
	public function add_shortcode_column( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'st-elementor-addons' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Render shortcode column.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param array $column Column array.
	 * @param int   $post_id post id.
	 *
	 * @return void
	 */
	public function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="stea-hf__shortcode-column">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[stea_theme_template id='<?php echo esc_attr( $post_id ); ?>']" class="stea-hf__template-shortcode code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}

	/**
	 * Render shortcode column.
	 *
	 * @access public
	 *
	 * @since 1.3.0
	 *
	 * @param array $column Column array.
	 * @param int   $post_id post id.
	 *
	 * @return void
	 */
	public function render_type_column( $column, $post_id ) {
		switch ( $column ) {
			case 'type':
				ob_start();
				$template_type = esc_html( get_post_meta( $post_id, 'stea_hf_template_type' )[0] );
				?>
				<span class="stea-hf__type-column">
					<a
					class="stea-hf__template-type"
					href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $this->post_type . '&' . $this->type_tax . '=' . $template_type ) ); ?>">
					<?php echo esc_html( ucwords( str_replace( '-', ' ', $template_type ) ) ); ?></a>
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

STEA_HF_Admin::instance();
