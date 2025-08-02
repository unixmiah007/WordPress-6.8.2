<?php
namespace ST_Elementor_Addons\Helper;
use Elementor\Plugin;

class Helper {
	/**
	 * Get All POst Types
	 *
	 * @return array
	 */
	public static function get_post_types() {
		$post_types = get_post_types(
			array(
				'public'            => true,
				'show_in_nav_menus' => true,
			),
			'objects'
		);
		$post_types = wp_list_pluck( $post_types, 'label', 'name' );

		return array_diff_key( $post_types, array( 'elementor_library', 'stea-theme-template', 'attachment' ) );
	}

	public static function get_query_post_list( $post_type = 'any', $limit = -1, $search = '' ) {
		global $wpdb;
		$where = '';
		$data  = array();

		if ( -1 == $limit ) {
			$limit = '';
		} elseif ( 0 == $limit ) {
			$limit = 'limit 0,1';
		} else {
			$limit = $wpdb->prepare( ' limit 0,%d', esc_sql( $limit ) );
		}

		if ( 'any' === $post_type ) {
			$in_search_post_types = get_post_types( array( 'exclude_from_search' => false ) );
			if ( empty( $in_search_post_types ) ) {
				$where .= ' AND 1=0 ';
			} else {
				$where .= " AND {$wpdb->posts}.post_type IN ('" . join(
					"', '",
					array_map( 'esc_sql', $in_search_post_types )
				) . "')";
			}
		} elseif ( ! empty( $post_type ) ) {
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_type = %s", esc_sql( $post_type ) );
		}

		if ( ! empty( $search ) ) {
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql( $search ) . '%' );
		}

		$query   = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
		$results = $wpdb->get_results( $query ); //phpcs:ignore
		if ( ! empty( $results ) ) {
			foreach ( $results as $row ) {
				$data[ $row->ID ] = $row->post_title;
			}
		}
		return $data;
	}

	/**
	 * Get all types of post.
	 *
	 * @param  string $post_type
	 *
	 * @return array
	 */
	public static function get_post_list( $post_type = 'any' ) {
		return self::get_query_post_list( $post_type );
	}

	/**
	 * Get all Authors
	 *
	 * @return array
	 */
	public static function get_authors_list() {
		$args = array(
			'capability'          => array( 'edit_posts' ),
			'has_published_posts' => true,
			'fields'              => array(
				'ID',
				'display_name',
			),
		);

		// Capability queries were only introduced in WP 5.9.
		if ( version_compare( $GLOBALS['wp_version'], '5.9-alpha', '<' ) ) {
			$args['who'] = 'authors';
			unset( $args['capability'] );
		}

		$users = get_users( $args );

		if ( ! empty( $users ) ) {
			return wp_list_pluck( $users, 'display_name', 'ID' );
		}

		return array();
	}


	/**
	 * [stea_pro_get_taxonomies]
	 *
	 * @return [array] product texonomies
	 */
	public static function stea_get_taxonomies( $object = 'product', $skip_terms = false ) {
		$all_taxonomies  = get_object_taxonomies( $object );
		$taxonomies_list = array();
		foreach ( $all_taxonomies as $taxonomy_data ) {
			$taxonomy = get_taxonomy( $taxonomy_data );
			if ( $skip_terms === true ) {
				if ( ( $taxonomy->show_ui ) && ( 'pa_' !== substr( $taxonomy_data, 0, 3 ) ) ) {
					$taxonomies_list[ $taxonomy_data ] = $taxonomy->label;
				}
			} else {
				if ( $taxonomy->show_ui ) {
					$taxonomies_list[ $taxonomy_data ] = $taxonomy->label;
				}
			}
		}
		return $taxonomies_list;
	}

}
