<?php

namespace StElementorAddons\Inc\Helper;

use Elementor\Utils;
use Elementor\Icons_Manager;

class St_Elementor_Addons_Helper
{
    public static function stea_elementor()
	{
		return \Elementor\Plugin::$instance;
	}

	// Get Page Title
	public static function stea_get_page_title($include_context = true)
	{
		$title = '';

		if (is_singular()) {
			/* translators: %s: Search term. */
			$title = get_the_title();

			if ($include_context) {
				$post_type_obj = get_post_type_object(get_post_type());
				$title = sprintf('%s: %s', $post_type_obj->labels->singular_name, $title);
			}
		} elseif (is_search()) {
			/* translators: %s: Search term. */
			$title = sprintf(__('Search Results for: %s', 'st-elementor-addons'), get_search_query());

			if (get_query_var('paged')) {
				/* translators: %s is the page number. */
				$title .= sprintf(__('&nbsp;&ndash; Page %s', 'st-elementor-addons'), get_query_var('paged'));
			}
		} elseif (is_category()) {
			$title = single_cat_title('', false);

			if ($include_context) {
				/* translators: Category archive title. 1: Category name */
				$title = sprintf(__('Category: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_tag()) {
			$title = single_tag_title('', false);
			if ($include_context) {
				/* translators: Tag archive title. 1: Tag name */
				$title = sprintf(__('Tag: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_author()) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';

			if ($include_context) {
				/* translators: Author archive title. 1: Author name */
				$title = sprintf(__('Author: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_year()) {
			$title = get_the_date(_x('Y', 'yearly archives date format', 'st-elementor-addons'));

			if ($include_context) {
				/* translators: Yearly archive title. 1: Year */
				$title = sprintf(__('Year: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_month()) {
			$title = get_the_date(_x('F Y', 'monthly archives date format', 'st-elementor-addons'));

			if ($include_context) {
				/* translators: Monthly archive title. 1: Month name and year */
				$title = sprintf(__('Month: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_day()) {
			$title = get_the_date(_x('F j, Y', 'daily archives date format', 'st-elementor-addons'));

			if ($include_context) {
				/* translators: Daily archive title. 1: Date */
				$title = sprintf(__('Day: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_tax('post_format')) {
			if (is_tax('post_format', 'post-format-aside')) {
				$title = _x('Asides', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-gallery')) {
				$title = _x('Galleries', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-image')) {
				$title = _x('Images', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-video')) {
				$title = _x('Videos', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-quote')) {
				$title = _x('Quotes', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-link')) {
				$title = _x('Links', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-status')) {
				$title = _x('Statuses', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-audio')) {
				$title = _x('Audio', 'post format archive title', 'st-elementor-addons');
			} elseif (is_tax('post_format', 'post-format-chat')) {
				$title = _x('Chats', 'post format archive title', 'st-elementor-addons');
			}
		} elseif (is_post_type_archive()) {
			$title = post_type_archive_title('', false);

			if ($include_context) {
				/* translators: Post type archive title. 1: Post type name */
				$title = sprintf(__('Archives: %s', 'st-elementor-addons'), $title);
			}
		} elseif (is_tax()) {
			$title = single_term_title('', false);

			if ($include_context) {
				$tax = get_taxonomy(get_queried_object()->taxonomy);
				/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
				$title = sprintf(__('%1$s: %2$s', 'st-elementor-addons'), $tax->labels->singular_name, $title);
			}
		} elseif (is_404()) {
			$title = __('Page Not Found', 'st-elementor-addons');
		} // End if().

		$title = apply_filters('stea/core_elements/get_the_archive_title', $title);

		return $title;
	}




	// Archive URL
	public static function stea_get_the_archive_url()
	{
		$url = '';
		if (is_category() || is_tag() || is_tax()) {
			$url = get_term_link(get_queried_object());
		} elseif (is_author()) {
			$url = get_author_posts_url(get_queried_object_id());
		} elseif (is_year()) {
			$url = get_year_link(get_query_var('year'));
		} elseif (is_month()) {
			$url = get_month_link(get_query_var('year'), get_query_var('monthnum'));
		} elseif (is_day()) {
			$url = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
		} elseif (is_post_type_archive()) {
			$url = get_post_type_archive_link(get_post_type());
		}

		return $url;
	}



    public static function stea_set_global_authordata()
	{
		global $authordata;
		if (!isset($authordata->ID)) {
			$post = get_post();
			$authordata = get_userdata($post->post_author); // WPCS: override ok.
		}
	}


    public static function stea_get_taxonomies($args = [], $output = 'names', $operator = 'and')
	{
		global $wp_taxonomies;

		$field = ('names' === $output) ? 'name' : false;

		// Handle 'object_type' separately.
		if (isset($args['object_type'])) {
			$object_type = (array) $args['object_type'];
			unset($args['object_type']);
		}

		$taxonomies = wp_filter_object_list($wp_taxonomies, $args, $operator);

		if (isset($object_type)) {
			foreach ($taxonomies as $tax => $tax_data) {
				if (!array_intersect($object_type, $tax_data->object_type)) {
					unset($taxonomies[$tax]);
				}
			}
		}

		if ($field) {
			$taxonomies = wp_list_pluck($taxonomies, $field);
		}

		return $taxonomies;
	}




    public static function stea_post_types_category_slug()
	{

		$post_types = [
			'category' => esc_html__('Post', 'st-elementor-addons')
		];

		if (class_exists('WooCommerce')) {
			$post_types['product_cat'] = esc_html__('Product', 'st-elementor-addons');
		}

		//other post types taxonomies here

		return apply_filters('stea_post_types_category_slug', $post_types);
	}


}
