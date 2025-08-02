<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;


if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}


global $organ_Options;
?>
<div class="main-container col1-layout wow bounceInUp animated">
    <div class="main">
    	<div class="col-main">
        	<div class="product-view wow bounceInUp animated" itemscope="" itemtype="http://schema.org/Product" itemid="#product_base">

          		<div class="product-essential container">
            		<div class="row">
            			<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
            				<?php
        		/**
				 * Hook: woocommerce_before_single_product.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 */
				do_action( 'woocommerce_before_single_product' );
				?>
						<?php
							/**
							 * woocommerce_before_single_product hook.
							 *
							 * @hooked wc_print_notices - 10
							 */
							 do_action( 'woocommerce_before_single_product' );

							 if ( post_password_required() ) {
							 	echo get_the_password_form();
							 	return;
							 }
						?>
						<?php  do_action('tmOrgan_single_product_pagination'); ?>

						<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2') { ?>
						 	<div class="product-img-box col-lg-4 col-sm-4 col-xs-12">
						<?php } else { ?>
						 	<div class="product-img-box col-sm-6 col-xs-12">
						<?php } ?>       

						   <?php
								/**
								 * woocommerce_before_single_product_summary hook.
								 *
								 * @hooked woocommerce_show_product_sale_flash - 10
								 * @hooked woocommerce_show_product_images - 20
								 */
								do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>

						 <?php if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2') { ?> 
						     <div class="product-shop col-lg-8 col-sm-8 col-xs-12">
						 <?php } else { ?>
							 <div class="product-shop col-sm-6 col-xs-12">
						 <?php } ?>                

							<!-- <div class="summary entry-summary"> -->

								<?php
									/**
									 * woocommerce_single_product_summary hook.
									 *
									 * @hooked woocommerce_template_single_title - 5
									 * @hooked woocommerce_template_single_rating - 10
									 * @hooked woocommerce_template_single_price - 10
									 * @hooked woocommerce_template_single_excerpt - 20
									 * @hooked woocommerce_template_single_add_to_cart - 30
									 * @hooked woocommerce_template_single_meta - 40
									 * @hooked woocommerce_template_single_sharing - 50
									 * @hooked WC_Structured_Data::generate_product_data() - 60
									 */
									do_action( 'woocommerce_single_product_summary' );
								?>

							<!-- </div> --><!-- .summary -->
							<?php tmOrgan_product_pagebanner(); ?> 
						   
							<?php tmOrgan_product_social_share();?>  
						</div>

						</div>
						</div>
					</div>

					</div><!-- #product-<?php the_ID(); ?> -->
					<?php
						/**
						 * woocommerce_after_single_product_summary hook.
						 *
						 * @hooked woocommerce_output_product_data_tabs - 10
						 * @hooked woocommerce_upsell_display - 15
						 * @hooked woocommerce_output_related_products - 20
						 */
						do_action( 'woocommerce_after_single_product_summary' );
					?>
					<div itemscope id="product-<?php the_ID(); ?>" <?php post_class(); ?> >
			  		<meta itemprop="url" content="<?php the_permalink(); ?>"/>


					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
