<?php
/**
 * @package organ
 * @subpackage organ
 */

if(class_exists( 'WooCommerce' ) && is_woocommerce()){
	dynamic_sidebar( 'sidebar-shop' );
} else {
	dynamic_sidebar( 'sidebar-blog' );
}
?> 

