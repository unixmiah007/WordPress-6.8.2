<?php

namespace StElementorAddons\Modules\DynamicTags;

use StElementorAddons\Inc\Helper\St_Elementor_Addons_Helper;

class STEA_Extension_Dynamic_Tags
{
	private static $_instance = null;

	public function __construct()
	{
		add_action('elementor/dynamic_tags/register', [$this, 'stea_register_dynamic_tags']);
	}

	/**
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags
	 */
	public function stea_register_dynamic_tags($dynamic_tags)
	{

		$tags = array(
			'stea-archive-description' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'archive-description.php',
				'class' => 'Tags\STEA_Archive_Description',
				'group' => 'archive',
				'title' => 'Archive',
			),
			'stea-archive-meta' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'archive-meta.php',
				'class' => 'Tags\STEA_Archive_Meta',
				'group' => 'archive',
				'title' => 'Archive',
			),
			'stea-archive-title' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'archive-title.php',
				'class' => 'Tags\STEA_Archive_Title',
				'group' => 'archive',
				'title' => 'Archive',
			),
			'stea-archive-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'archive-url.php',
				'class' => 'Tags\STEA_Archive_URL',
				'group' => 'archive',
				'title' => 'Archive',
			),
			'stea-author-info' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'author-info.php',
				'class' => 'Tags\STEA_Author_Info',
				'group' => 'author',
				'title' => 'Author',
			),
			'stea-author-meta' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'author-meta.php',
				'class' => 'Tags\STEA_Author_Meta',
				'group' => 'author',
				'title' => 'Author',
			),
			'stea-author-name' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'author-name.php',
				'class' => 'Tags\STEA_Author_Name',
				'group' => 'author',
				'title' => 'Author',
			),
			'stea-author-profile-picture' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'author-profile-picture.php',
				'class' => 'Tags\STEA_Author_Profile_Picture',
				'group' => 'author',
				'title' => 'Author',
			),
			'stea-author-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'author-url.php',
				'class' => 'Tags\STEA_Author_URL',
				'group' => 'author',
				'title' => 'Author',
			),
			'stea-comments-number' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'comments-number.php',
				'class' => 'Tags\STEA_Comments_Number',
				'group' => 'comments',
				'title' => 'Comments',
			),
			'stea-comments-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'comments-url.php',
				'class' => 'Tags\STEA_Comments_URL',
				'group' => 'comments',
				'title' => 'Comments',
			),
			'stea-contact-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'contact-url.php',
				'class' => 'Tags\STEA_Contact_URL',
				'group' => 'action',
				'title' => 'Action',
			),
			'stea-current-date-time' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'current-date-time.php',
				'class' => 'Tags\STEA_Current_Date_Time',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-featured-image-data' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'featured-image-data.php',
				'class' => 'Tags\STEA_Featured_Image_Data',
				'group' => 'media',
				'title' => 'Media',
			),
			'stea-page-title' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'page-title.php',
				'class' => 'Tags\STEA_Page_Title',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-post-custom-field' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-custom-field.php',
				'class' => 'Tags\STEA_Custom_Field',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-pages-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'pages-url.php',
				'class' => 'Tags\STEA_Pages_Url',
				'group' => 'URL',
				'title' => 'URL',
			),
			'stea-cats-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'taxonomies-url.php',
				'class' => 'Tags\STEA_Taxonomies_Url',
				'group' => 'URL',
				'title' => 'URL',
			),
			'stea-post-date' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-date.php',
				'class' => 'Tags\STEA_Post_Date',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-excerpt' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-excerpt.php',
				'class' => 'Tags\STEA_Post_Excerpt',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-description' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-description.php',
				'class' => 'Tags\STEA_Post_Description',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-featured-image' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-featured-image.php',
				'class' => 'Tags\STEA_Post_Featured_Image',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-gallery' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-gallery.php',
				'class' => 'Tags\STEA_Post_Gallery',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-id' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-id.php',
				'class' => 'Tags\STEA_Post_ID',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-terms' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-terms.php',
				'class' => 'Tags\STEA_Post_Terms',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-time' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-time.php',
				'class' => 'Tags\STEA_Post_Time',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-title' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-title.php',
				'class' => 'Tags\STEA_Post_Title',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-post-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'post-url.php',
				'class' => 'Tags\STEA_Post_URL',
				'group' => 'post',
				'title' => 'Post',
			),
			'stea-request-parameter' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'request-parameter.php',
				'class' => 'Tags\STEA_Request_Parameter',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-shortcode' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'shortcode.php',
				'class' => 'Tags\STEA_Shortcode',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-site-logo' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'site-logo.php',
				'class' => 'Tags\STEA_Site_Logo',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-site-tagline' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'site-tagline.php',
				'class' => 'Tags\STEA_Site_Tagline',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-site-title' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'site-title.php',
				'class' => 'Tags\STEA_Site_Title',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-site-url' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'site-url.php',
				'class' => 'Tags\Site_URL',
				'group' => 'site',
				'title' => 'Site',
			),
			'stea-user-info' => array(
				'file'  => ST_ELEMENTOR_ADDONS_PATH_INC . 'user-info.php',
				'class' => 'Tags\STEA_User_Info',
				'group' => 'site',
				'title' => 'Site',
			)
		);

		foreach ($tags as $tags_type => $tags_info) {
			if (!empty($tags_info['file']) && !empty($tags_info['class'])) {
				St_Elementor_Addons_Helper::stea_elementor()->dynamic_tags->register_group($tags_info['group'], [
					'title' => __( $tags_info['title'], 'st-elementor-addons' )
				]);

				include_once($tags_info['file']);

				if (class_exists($tags_info['class'])) {
					$class_name = $tags_info['class'];
				} elseif (class_exists(__NAMESPACE__ . '\\' . $tags_info['class'])) {
					$class_name = __NAMESPACE__ . '\\' . $tags_info['class'];
				}

				$dynamic_tags->register(new $class_name);
			}
		}
	}


	public static function get_instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

STEA_Extension_Dynamic_Tags::get_instance();
