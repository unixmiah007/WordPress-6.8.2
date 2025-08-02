<?php

namespace StElementorAddons\Modules\DynamicTags;

defined('ABSPATH') || exit;

define('ST_ELEMENTOR_ADDONS_PATH_INC', plugin_dir_path(__FILE__) . 'inc/');
define('ST_ELEMENTOR_ADDONS_URL', plugins_url('/', __FILE__));
define('ST_ELEMENTOR_ADDONS_TAGS_DIR', plugin_basename(__FILE__));

require plugin_dir_path(__FILE__) . 'class-dynamic-tags.php';
