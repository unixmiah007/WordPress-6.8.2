<?php
/**
 * Cross-sells 
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $cross_sells ) : ?>
<section class="cross-sell-pro wow bounceInUp">
	<div class="cross-sells  upsell-pro row">
		<div class="new_title center">
		<h2><?php _e( 'You may be interested in the following items:', 'organ' ) ?></h2>
		<div class="line"></div>
		</div>
		<div class="slider-items-products">

            <div id="cross-sell-products" class="product-flexslider hidden-buttons category-products">
			<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $cross_sells as $cross_sell ) : ?>

					<?php
					 	$post_object = get_post( $cross_sell->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
			</div>
        </div>
	</div>
</section>
<?php endif;

wp_reset_postdata();
