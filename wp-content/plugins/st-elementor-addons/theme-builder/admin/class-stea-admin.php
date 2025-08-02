<?php
/**
 *
 * @package st-elementor-addons
 */

use Stea_Theme_Builder\Lib\Stea_Target_Rules_Fields;

defined( 'ABSPATH' ) || exit;

/**
 * Stea_Theme_Builder_Admin setup
 *
 * @since 1.0.0
 */
class Stea_Theme_Builder_Admin {

	/**
	 * Instance of Stea_Theme_Builder_Admin
	 *
	 * @var Stea_Theme_Builder_Admin
	 */
	private static $_instance = null;

	/**
	 * Constructor
	 */
	private function __construct() {

		add_action( 'init', array( $this, 'stea_theme_builder_post_type' ) );
		add_action( 'init', array( $this, 'stea_theme_builder_frontend_settings' ) );
		add_action( 'add_meta_boxes', array( $this, 'stea_theme_builder_register_metabox' ) );
		add_action( 'save_post', array( $this, 'stea_theme_builder_save_meta' ) );
		add_action( 'template_redirect', array( $this, 'block_template_frontend' ) );
		add_filter( 'manage_stea-theme-template_posts_columns', array( $this, 'set_custom_columns' ) );
		add_action( 'manage_stea-theme-template_posts_custom_column', array( $this, 'render_custom_column' ), 10, 2 );
		add_action( 'manage_stea-theme-template_posts_custom_column', array( $this, 'column_content' ), 10, 2 );
		add_filter( 'manage_stea-theme-template_posts_columns', array( $this, 'column_headings' ) );
		// add_action( 'admin_head', array( $this, 'correct_current_active_menu' ), 50 );

		$this->add_elementor_cpt_support();

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) && ELEMENTOR_PRO_VERSION > 2.8 ) {
			add_action( 'elementor/editor/footer', array( $this, 'register_stea_theme_builder_epro_script' ), 99 );
		}

		register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
		register_activation_hook( __FILE__, array( $this, 'flush_rewrites' ) );

	}

	/**
	 * Instance of Stea_Theme_Builder_Admin
	 *
	 * @return Stea_Theme_Builder_Admin Instance of Stea_Theme_Builder_Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Script for Elementor Pro full site editing support.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function register_stea_theme_builder_epro_script() {
		$ids_array = array(
			array(
				'id'    => get_stea_theme_builder_header_id(),
				'value' => 'Header',
			),
			array(
				'id'    => get_stea_theme_builder_footer_id(),
				'value' => 'Footer',
			),
			array(
				'id'    => stea_theme_builder_get_singular_id(),
				'value' => 'Singular',
			),
			array(
				'id'    => stea_theme_builder_get_archive_id(),
				'value' => 'Archive',
			),
		);
	}

	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 *
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['stea_theme_builder_display_rules'] = __( 'Display Rules', 'st-elementor-addons' );
		$columns['date']                             = __( 'Date', 'st-elementor-addons' );

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @param array $column Name of column.
	 * @param int $post_id Post id.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function column_content( $column, $post_id ) {

		if ( 'stea_theme_builder_display_rules' === $column ) {

			$locations = get_post_meta( $post_id, 'stea_theme_builder_target_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="stea-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'stea_theme_builder_target_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="stea-advanced-headers-exclusion-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'stea_theme_builder_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = array();
					foreach ( $users as $user ) {
						$user_label[] = Stea_Target_Rules_Fields::get_user_by_key( $user );
					}
					echo '<div class="stea-advanced-headers-users-wrap">';
					echo '<strong>Users: </strong>';
					echo join( ', ', array_map( 'esc_html', $user_label ) );
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 *
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = array();
		$index          = array_search( 'specifics', $locations['rule'], true );
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = Stea_Target_Rules_Fields::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = Stea_Target_Rules_Fields::get_location_by_key( $location );
			}
		}

		echo join( ', ', array_map( 'esc_html', $location_label ) );
	}

	public function flush_rewrites() {
		$this->stea_theme_builder_post_type();
		flush_rewrite_rules();
	}

	/**
	 * Register Post type for Stea Theme Builder templates
	 */
	public function stea_theme_builder_post_type() {
		$labels = array(
			'name'               => __( 'Layouts', 'st-elementor-addons' ),
			'singular_name'      => __( 'Layout', 'st-elementor-addons' ),
			'menu_name'          => __( 'Theme Builder', 'st-elementor-addons' ),
			'name_admin_bar'     => __( 'Theme Builder', 'st-elementor-addons' ),
			'add_new'            => __( 'Add New', 'st-elementor-addons' ),
			'add_new_item'       => __( 'Add New Layout', 'st-elementor-addons' ),
			'new_item'           => __( 'New Layout', 'st-elementor-addons' ),
			'edit_item'          => __( 'Edit Layout', 'st-elementor-addons' ),
			'view_item'          => __( 'View Layout', 'st-elementor-addons' ),
			'all_items'          => __( 'All Layout', 'st-elementor-addons' ),
			'search_items'       => __( 'Search Layouts', 'st-elementor-addons' ),
			'parent_item_colon'  => __( 'Parent Layouts:', 'st-elementor-addons' ),
			'not_found'          => __( 'No Layout found.', 'st-elementor-addons' ),
			'not_found_in_trash' => __( 'No Layout found in Trash.', 'st-elementor-addons' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'rewrite'             => false,
			'query_var'           => false,
			'can_export'          => true,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'map_meta_cap'        => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'has_archive'         => false,
			'menu_icon'           => STEA_URL . '/theme-builder/admin/assets/images/stea-theme-template-icon.svg',
			'supports'            => array( 'title', 'author', 'elementor' ),
		);

		register_post_type( 'stea-theme-template', $args );

	}

	/**
	 *** Add elementor support for wpr_templates.
	 **/
	public function add_elementor_cpt_support() {

		if ( ! is_admin() ) {
			return;
		}

		$cpt_support = get_option( 'elementor_cpt_support' );

		if ( ! $cpt_support ) {
			update_option( 'elementor_cpt_support', array( 'post', 'page', 'stea-theme-template' ) );
		} elseif ( ! in_array( 'stea-theme-template', $cpt_support, true ) ) {
			$cpt_support[] = 'stea-theme-template';
			update_option( 'elementor_cpt_support', $cpt_support );
		}

	}

	public function correct_current_active_menu() {

		$screen = get_current_screen();

		if ( 'stea-theme-template' === $screen->id ) {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('#toplevel_page_stea-elementor-addons').addClass('wp-has-current-submenu wp-menu-open menu-top menu-top-first').removeClass('wp-not-current-submenu');
					$('#toplevel_page_stea-elementor-addons > a').addClass('wp-has-current-submenu').removeClass('wp-not-current-submenu');
					$("#toplevel_page_stea-elementor-addons a[href*='edit.php?post_type=stea-theme-template']").addClass('current');
				});
			</script>
			<?php
		}

	}

	/**
	 * Register settings.
	 */
	public function stea_theme_builder_frontend_settings() {

		$themer_settings = array(
			'public'   => false,
			'status'   => false,
			'expanded' => false,
			'tab'      => 'all-layout',
			'size'     => 500,
			'layout'   => 'list',
		);

		add_option( 'stea_themer_frontend_settings', $themer_settings );

	}

	/**
	 * Register meta box(es).
	 */
	public function stea_theme_builder_register_metabox() {
		add_meta_box(
			'st-elementor-addons-meta-box',
			__( 'Stea Theme Builder Options', 'st-elementor-addons' ),
			array(
				$this,
				'stea_theme_builder_metabox_render',
			),
			'stea-theme-template',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 */
	public function stea_theme_builder_metabox_render( $post ) {
		$values        = get_post_custom( $post->ID );
		$template_type = isset( $values['stea_theme_builder_template_type'] ) ? esc_attr( $values['stea_theme_builder_template_type'][0] ) : '';
		$sticky        = isset( $values['stea_theme_builder_sticky'] ) ? esc_attr( $values['stea_theme_builder_sticky'][0] ) : '';

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'stea_theme_builder_meta_nounce', 'stea_theme_builder_meta_nounce' );
		?>
		<table class="st-elementor-addons-options-table widefat">
			<tbody>
			<tr class="st-elementor-addons-options-row type-of-template">
				<td class="st-elementor-addons-options-row-heading">
					<label for="stea_theme_builder_template_type"><?php esc_html_e( 'Type of Template', 'st-elementor-addons' ); ?></label>
				</td>
				<td class="st-elementor-addons-options-row-content">
					<select name="stea_theme_builder_template_type" id="stea_theme_builder_template_type">
						<option value="" <?php selected( $template_type, '' ); ?>><?php esc_html_e( 'Select', 'st-elementor-addons' ); ?></option>
						<optgroup label="Structure">
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php esc_html_e( 'Header', 'st-elementor-addons' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php esc_html_e( 'Footer', 'st-elementor-addons' ); ?></option>
						</optgroup>
						<optgroup label="Content">
							<option value="type_archive" <?php selected( $template_type, 'type_archive' ); ?>><?php esc_html_e( 'Archive', 'st-elementor-addons' ); ?></option>
							<option value="type_singular" <?php selected( $template_type, 'type_singular' ); ?>><?php esc_html_e( 'Singular', 'st-elementor-addons' ); ?></option>
							<option value="custom" <?php selected( $template_type, 'custom' ); ?>><?php esc_html_e( 'Shortcode', 'st-elementor-addons' ); ?></option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr class="st-elementor-addons-options-row header-sticky">
				<td class="st-elementor-addons-options-row-heading">
					<label for="stea_theme_builder_sticky"><?php esc_html_e( 'Header Sticky', 'st-elementor-addons' ); ?></label>
					<i class="st-elementor-addons-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Enable this in order to sticky header (steatb-appear).', 'st-elementor-addons' ); ?>"></i>
				</td>
				<td class="st-elementor-addons-options-row-content">
					<select name="stea_theme_builder_sticky" id="stea_theme_builder_sticky">
						<option value="" <?php selected( $sticky, '' ); ?>><?php esc_html_e( 'Disable', 'st-elementor-addons' ); ?></option>
						<option value="enable" <?php selected( $sticky, 'enable' ); ?>><?php esc_html_e( 'Enable', 'st-elementor-addons' ); ?></option>
					</select>
				</td>
			</tr>
			<?php $this->display_rules_tab(); ?>
			<tr class="st-elementor-addons-options-row st-elementor-addons-shortcode">
				<td class="st-elementor-addons-options-row-heading">
					<label for="stea_theme_builder_template_type"><?php esc_html_e( 'Shortcode', 'st-elementor-addons' ); ?></label>
					<i class="st-elementor-addons-options-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Copy this shortcode and paste it into post.', 'st-elementor-addons' ); ?>">
					</i>
				</td>
				<td class="st-elementor-addons-options-row-content">
						<span class="st-elementor-addons-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[stea_theme_builder_template id='<?php echo esc_attr( $post->ID ); ?>']" class="st-elementor-addons-large-text code">
						</span>
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 *
	 * @since  1.0.0
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		Stea_Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'stea_theme_builder_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'stea_theme_builder_target_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'stea_theme_builder_target_user_roles', true );
		?>
		<tr class="st-elementor-addons-target-rules-row st-elementor-addons-options-row">
			<td class="st-elementor-addons-target-rules-row-heading st-elementor-addons-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'st-elementor-addons' ); ?></label>
				<i class="st-elementor-addons-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Add locations for where this template should appear.', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="st-elementor-addons-target-rules-row-content st-elementor-addons-options-row-content">
				<?php
				Stea_Target_Rules_Fields::target_rule_settings_field(
					'st-elementor-addons-target-rules-location',
					array(
						'title'          => __( 'Display Rules', 'st-elementor-addons' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'st-elementor-addons' ),
					),
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="st-elementor-addons-target-rules-row st-elementor-addons-options-row">
			<td class="st-elementor-addons-target-rules-row-heading st-elementor-addons-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'st-elementor-addons' ); ?></label>
				<i class="st-elementor-addons-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Add locations for where this template should not appear.', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="st-elementor-addons-target-rules-row-content st-elementor-addons-options-row-content">
				<?php
				Stea_Target_Rules_Fields::target_rule_settings_field(
					'st-elementor-addons-target-rules-exclusion',
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
		<tr class="st-elementor-addons-target-rules-row st-elementor-addons-options-row">
			<td class="st-elementor-addons-target-rules-row-heading st-elementor-addons-options-row-heading">
				<label><?php esc_html_e( 'User Roles', 'st-elementor-addons' ); ?></label>
				<i class="st-elementor-addons-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Display custom template based on user role.', 'st-elementor-addons' ); ?>"></i>
			</td>
			<td class="st-elementor-addons-target-rules-row-content st-elementor-addons-options-row-content">
				<?php
				Stea_Target_Rules_Fields::target_user_role_settings_field(
					'st-elementor-addons-target-rules-users',
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
	 * Save meta field.
	 *
	 * @param POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function stea_theme_builder_save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['stea_theme_builder_meta_nounce'] ) || ! wp_verify_nonce( $_POST['stea_theme_builder_meta_nounce'], 'stea_theme_builder_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = Stea_Target_Rules_Fields::get_format_rule_value( $_POST, 'st-elementor-addons-target-rules-location' );
		$target_exclusion = Stea_Target_Rules_Fields::get_format_rule_value( $_POST, 'st-elementor-addons-target-rules-exclusion' );
		$target_users     = array();

		if ( isset( $_POST['st-elementor-addons-target-rules-users'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['st-elementor-addons-target-rules-users'] );
		}

		update_post_meta( $post_id, 'stea_theme_builder_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'stea_theme_builder_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'stea_theme_builder_target_user_roles', $target_users );

		if ( isset( $_POST['stea_theme_builder_template_type'] ) ) {
			update_post_meta( $post_id, 'stea_theme_builder_template_type', sanitize_text_field( $_POST['stea_theme_builder_template_type'] ) );
		}

		if ( isset( $_POST['stea_theme_builder_sticky'] ) ) {
			update_post_meta( $post_id, 'stea_theme_builder_sticky', sanitize_text_field( $_POST['stea_theme_builder_sticky'] ) );
		}

		update_post_meta( $post_id, '_elementor_template_type', 'stea-theme-template' );
	}

	/**
	 * Don't display the elementor Stea Theme Builder templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'stea-theme-template' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_safe_redirect( site_url(), 301 );
			die;
		}
	}


	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	public function set_custom_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );
		$columns['type'] = __( 'Type', 'st-elementor-addons' );
		$columns['date'] = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int $post_id post id.
	 */
	public function render_custom_column( $column, $post_id ) {

		$type = get_post_meta( $post_id, 'stea_theme_builder_template_type', true );

		if ( 'type' === $column ) {
			ob_start();
			?>
			<span class="st-elementor-addons-type-col-wrap">
					<?php echo esc_html( ucfirst( str_replace( 'type_', '', $type ) ) ); ?>
			</span>
			<?php
			ob_get_contents();
		}
	}

}

Stea_Theme_Builder_Admin::instance();
