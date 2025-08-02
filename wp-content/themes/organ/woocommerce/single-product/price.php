<?php
/**
 * Single Product Price, including microdata for SEO
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div class="price-box price"><?php echo wp_specialchars_decode($product->get_price_html()); ?></div>
