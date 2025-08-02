<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author      Striviothemes
 * @package WooCommerce/Templates
 * @version     1.8.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>
<div class="stea-archive-product">
	<?php do_action( 'stea_template_woocommerce_archive_product_content' ); ?>
</div>
<?php get_footer( 'shop' ); ?>
