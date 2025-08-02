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
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$TmOrgan = new TmOrgan();

global $product, $woocommerce_loop, $yith_wcwl,$organ_Options;

// Ensure visibility
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
  return;
}


// Extra post classes
$classes = array();

if (is_cart()) {

    $classes[] = 'item col-md-3 col-sm-6 col-xs-12';

} else {
    
  $classes[] = 'item col-lg-4 col-md-4 col-sm-4 col-xs-6';
       
}
?>


<?php 
if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2' )
 {  /*version2*/  ?>

   <li <?php wc_product_class($classes); ?>>
   <div class="item-inner">
      <div class="item-img">
         <div class="item-img-info">

          <div class="pimg">
            <?php do_action('woocommerce_before_shop_loop_item'); ?>        
              <a href="<?php the_permalink(); ?>" class="product-image">
                  <?php
                     /**
                      * woocommerce_before_shop_loop_item_title hook
                      *
                      * @hooked woocommerce_show_product_loop_sale_flash - 10
                      * @hooked woocommerce_template_loop_product_thumbnail - 10
                      */
                     do_action('woocommerce_before_shop_loop_item_title');
                     ?>
              </a>
               <?php if ($product->is_on_sale()) : ?>
                     <div class="sale-label sale-top-right">
                         <?php esc_attr_e('Sale', 'organ'); ?>
                     </div>
                 <?php endif; ?>

            </div> 
              
            <div class="actions">

                      <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                            <div class="quick-view-btn">
                                   <a class="yith-wcqv-button" href="#"
                                    data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Quick View', 'organ'); ?>"
                                    data-product_id="<?php echo esc_html($product->get_id()); ?>"><span><?php esc_attr_e('Quick View', 'organ'); ?></span></a>
                            </div>
                     <?php } ?>
                  


                      <?php if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                            $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"'; ?>

                           <div class="link-wishlist">
                            <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) ) ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Wishlist', 'organ'); ?>" data-product-id="<?php echo esc_html($product->get_id()); ?>" data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?> ><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a>
                          </div>

                      <?php } ?>


                      <?php if (class_exists('YITH_Woocompare_Frontend')) {
                            $tm_yith_cmp = new YITH_Woocompare_Frontend;
                           ?> 

                            <div class="link-compare">
                              <a href="<?php echo esc_url( $tm_yith_cmp->add_product_url($product->get_id())); ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Compare', 'organ'); ?>" class="compare  add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); ?></span></a>
                             </div>

                      <?php  } ?> 

                       <?php
                  /**
                   * woocommerce_after_shop_loop_item hook
                   *
                   * @hooked woocommerce_template_loop_add_to_cart - 10
                   */
                  do_action('woocommerce_after_shop_loop_item');
                  
                  ?>  

              </div>


                <div class="rating">
                    <div class="ratings">
                       <div class="rating-box">
                         <?php $average = $product->get_average_rating(); ?>
                         <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"></div>
                       </div>
                     </div>
                </div>

          </div>
       </div>

    <div class="item-info">

      <div class="info-inner">
         <div class="item-title"> 
           <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?></a>
         </div>
       
       <div class="item-content">
            
          <div class="item-price">
             <div class="price-box">
                <?php echo wp_specialchars_decode($product->get_price_html()); ?>
             </div>
          </div>
             
        <div class="desc std">
            <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
        </div>

        

        </div>
      </div>
    </div>
   </div>
</li>
<?php } else { ?>

<li <?php post_class($classes); ?> class="item" >
   <div class="item-inner">
      <div class="item-img">
         <div class="item-img-info">
            <?php do_action('woocommerce_before_shop_loop_item'); ?>
            <div class="pimg">
            <a  href="<?php the_permalink(); ?>" class="product-image">
              
                  <?php
                     /**
                      * woocommerce_before_shop_loop_item_title hook
                      *
                      * @hooked woocommerce_show_product_loop_sale_flash - 10
                      * @hooked woocommerce_template_loop_product_thumbnail - 10
                      */
                     do_action('woocommerce_before_shop_loop_item_title');
                     ?>
             
            </a>
          </div>
        
         <div class="item-box-hover">
             <div class="box-inner product-action">
              <div class="product-detail-bnt">
                   <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                  <a title="<?php esc_attr_e('Quick View', 'organ'); ?>" class="button detail-bnt yith-wcqv-button quickview" type="button" data-product_id="<?php echo esc_html($product->get_id()); ?>"><span><?php esc_attr_e('Quick View', 'organ'); ?></span></a>
                  <?php } ?>
                </div> 
                <?php if (isset($yith_wcwl) && is_object($yith_wcwl)) {
		        $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
	        ?>
		<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) ) ?>"
	           data-product-id="<?php echo esc_html($product->get_id()); ?>"
        	   data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
	           title="<?php esc_attr_e('Add to WishList','organ'); ?>"></a>
		<?php
	        }
	        
	        if (class_exists('YITH_Woocompare_Frontend')) {

        		$tm_yith_cmp = new YITH_Woocompare_Frontend;
          	
	         ?>
		<a class="compare add_to_compare_small link-compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"
	href="<?php echo esc_url($tm_yith_cmp->add_product_url($product->get_id())); ?>" title="<?php esc_attr_e('Add to Compare','organ'); ?>"></a>
		<?php
		}
	        ?>
                                  
	        
            </div>
         </div>
          </div>
      </div>
    <div class="item-info">
      <div class="info-inner">
            <div class="item-title"><a href="<?php the_permalink(); ?>">
               <?php the_title(); ?>
               </a>
            </div>
            <div class="item-content">
               <div class="rating">
                  <div class="ratings">
                     <div class="rating-box">
                        <?php $average = $product->get_average_rating(); ?>
                        <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"></div>
                     </div>
                  </div>
               </div>
               <div class="item-price">
                  <div class="price-box"> <?php echo wp_specialchars_decode($product->get_price_html()); ?>
                     <?php
                        /**
                         * woocommerce_after_shop_loop_item_title hook
                         *
                         * @hooked woocommerce_template_loop_rating - 5
                         * @hooked woocommerce_template_loop_price - 10
                         */
                        
                        ?>                   
                  </div>
               </div>
                 
               <div class="desc std">
                  <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?>
               </div>
               <div class="action">

                   <?php
                   $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text();
                   ?>
              </div>     
            </div>
         </div>
      </div>
   </div>
</li>
<?php } ?>