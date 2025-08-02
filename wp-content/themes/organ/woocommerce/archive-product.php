<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );



global $organ_Options;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header( 'shop' );

$plugin_url = plugins_url();


?>
<?php
if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')
{    ?>


   <script type="text/javascript">

    jQuery(function ($) {

        "use strict";


        jQuery.display = function (view) {

            view = jQuery.trim(view);

            if (view == 'list') {
                jQuery(".button-grid").removeClass("button-active");
                jQuery(".button-list").addClass("button-active");
                jQuery.getScript("<?php echo  esc_url(site_url()) ; ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                });
                jQuery('.category-products .products-grid').attr('class', 'products-list');


                jQuery('ul.products-list  > li.item').each(function (index, element) {

                    var htmls = '';
                    var element = jQuery(this);


                     element.attr('class', 'item');


                    htmls += '<div class="pimg">';

                    var image = element.find('.pimg').html();

                    if (image != undefined) {
                        htmls += image;
                    }

                    htmls += '</div>';
          

                    htmls += '<div class="product-shop">';
                    if (element.find('.item-title').length > 0)
                        htmls += '<h2 class="product-name item-title"> ' + element.find('.item-title').html() + '</h2>';

                     var ratings = element.find('.ratings').html();

                    htmls += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';

                    var descriptions = element.find('.desc').html();
                    htmls += '<div class="desc std">' + descriptions + '</div>';

                      var price = element.find('.price-box').html();

                    if (price != null) {
                        htmls += '<div class="price-box">' + price + '</div>';
                    }

                    htmls += '<div class="actions">' + element.find('.actions').html();
                    
                    htmls += '</div>';
                    htmls += '</div>';


                    element.html(htmls);
                });

                jQuery.cookie('display', 'list');

            } else {
                 var wooloop=1;
                 var pgrid='';
                 jQuery(".button-list").removeClass("button-active");
                 jQuery(".button-grid").addClass("button-active");
                 jQuery.getScript("<?php echo esc_url(site_url()); ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                 });
                 jQuery('.category-products .products-list').attr('class', 'products-grid');
                 
                 jQuery('ul.products-grid > li.item').each(function (index, element) {
                    var html = '';

                    element = jQuery(this);
                      if(wooloop%4==1) 
                    {
                     pgrid='wide-first';   
                     }
                     else if(wooloop%4==0) 
                     {
                     pgrid='last'; 
                      }
                      else
                      {
                       pgrid=''; 

                      }

                    element.attr('class', 'item col-lg-4 col-md-4 col-sm-6 col-xs-6 '+pgrid);
                    
                    html += '<div class="item-inner"><div class="item-img"><div class="item-img-info"><div class="pimg">';
              

                    var image = element.find('.pimg').html();

                    if (image != undefined) {

                        html += image;
                    }

                  
                    html +='</div>';
                    
                     

                     html += '<div class="actions">';
                     var actions = element.find('.actions').html();
                   
                     html +=actions;
                   html += '</div>';

                     var ratings = element.find('.ratings').html();

                    html += '<div class="rating"><div class="ratings">' + ratings + '</div></div>';
                    
                    html +='</div></div>';
                  
                
                    
                    html +='<div class="item-info"><div class="info-inner">';
                       if (element.find('.item-title').length > 0)
                       {
                        html += '<div class="item-title"> ' + element.find('.item-title').html() + '</div>';
                    }


                html +='<div class="item-content">';
                        

                        var price = element.find('.price-box').html();

                     if (price != null) {
                        html += '<div classs="item-price"><div class="price-box"> ' + price + '</div></div>';
                    }

                    var descriptions = element.find('.desc').html();
                    html += '<div class="desc std">' + descriptions + '</div>';
                   
                    html += '</div></div></div></div>';

                    element.html(html);
                      wooloop++;
                 });

                 jQuery.cookie('display', 'grid');
            }
        }

        jQuery('a.list-trigger').click(function () {
            jQuery.display('list');

        });
        jQuery('a.grid-trigger').click(function () {
            jQuery.display('grid');
        });

        var view = 'grid';
        view = jQuery.cookie('display') !== undefined ? jQuery.cookie('display') : view;

        if (view) {
            jQuery.display(view);

        } else {
            jQuery.display('grid');
        }
        return false;


    });
    </script>
    

<?php } else { /*default */?>

<script type="text/javascript"><!--


    jQuery(function ($) {

        "use strict";


        jQuery.display = function (view) {

            view = jQuery.trim(view);

            if (view == 'list') {
                jQuery(".button-grid").removeClass("button-active");
                jQuery(".button-list").addClass("button-active");
                jQuery.getScript("<?php echo  esc_url(site_url()) ; ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                });
                // jQuery('.products-grid').attr('class', 'products-list');


                // jQuery('.products-list > ul > li').each(function (index, element) {

                    jQuery('.pro-grid .category-products .products-grid').attr('class', 'products-list');


                jQuery('.pro-grid ul.products-list  > li.item').each(function (index, element) {

                    var htmls = '';
                    var element = jQuery(this);


                    element.attr('class', 'item');


                    htmls += '<div class="pimg">';

                    var element = jQuery(this);

                    var image = element.find('.pimg').html();

                    if (image != undefined) {
                        htmls += image;
                    }

                    htmls += '</div>';


            

                    htmls += '<div class="product-shop">';
                    if (element.find('.item-title').length > 0)
                        htmls += '<h2 class="product-name item-title"> ' + element.find('.item-title').html() + '</h2>';

                  

          

                     var ratings = element.find('.ratings').html();

                    htmls += ' <div class="rating"><div class="ratings">' + ratings + '</div></div>';

                    var descriptions = element.find('.desc').html();
                    htmls += '<div class="desc std">' + descriptions + '</div>';
                      var price = element.find('.price-box').html();

                    if (price != null) {
                        htmls += ' <div class="price-box">' + price + '</div>';
                    }
            htmls += '<div class="action">' + element.find('.action').html() + '</div>'; 
                    htmls += '<div class="product-action actions">' + element.find('.product-action').html() + '</div>';
                    htmls += '</div>';
                 

                    element.html(htmls);
                });


                jQuery.cookie('display', 'list');

            } else {
                 var wooloop=1;
                 var pgrid='';
                 jQuery(".button-list").removeClass("button-active");
                 jQuery(".button-grid").addClass("button-active");
                 jQuery.getScript("<?php echo esc_url(site_url()); ?>/wp-content/plugins/yith-woocommerce-quick-view/assets/js/frontend.js", function () {
                 });
                 // jQuery('.products-list').attr('class', 'products-grid');

                 // jQuery('.products-grid > ul > li').each(function (index, element) {
                    jQuery('.pro-grid .category-products .products-list').attr('class', 'products-grid');
                 
                 jQuery('.pro-grid ul.products-grid > li.item').each(function (index, element) {
                    var html = '';

                     element = jQuery(this);

                     if(wooloop%3==1) 
                    {
                     pgrid='wide-first';   
                     }

                     else if(wooloop%3==0) 
                     {
                     pgrid='last'; 
                      }
                      else
                      {
                       pgrid=''; 

                      }

                    element.attr('class', 'item col-lg-4 col-md-4 col-sm-4 col-xs-6 ' +pgrid );

                    html += '<div class="item-inner"><div class="item-img"><div class="item-img-info"><div class="pimg">';

                    var element = jQuery(this);

                    var image = element.find('.pimg').html();

                    if (image != undefined) {

                        html += image;
                    }
                    html +='</div><div class="item-box-hover"><div class="box-inner product-action">';
                     var actions = element.find('.product-action').html();
                   
                     html +=actions;
                    html += '</div></div></div></div>';

                  

                    html += '<div class="item-info"><div class="info-inner">';
                    if (element.find('.item-title').length > 0)
                        html += '<div class="item-title"> ' + element.find('.item-title').html() + '</div>';                                


                    html += ' <div class="item-content">';
                     var ratings = element.find('.ratings').html();

                    html += ' <div class="rating"><div class="ratings">' + ratings + '</div></div>';

                       var price = element.find('.price-box').html();

                     if (price != null) {
                        html += '<div classs="item-price"><div class="price-box"> ' + price + '</div></div>';
                    }
                    var descriptions = element.find('.desc').html();
                    html += '<div class="desc std">' + descriptions + '</div>';
                   
                    html += '';  
                   
                   html += '<div class="action">';
                    var action = element.find('.action').html();
                   
                    html +=action;
                    html += '</div>';
                    html += '</div></div></div>';

                    element.html(html);
                     wooloop++;
                 });

                 jQuery.cookie('display', 'grid');
            }
        }

        jQuery('a.list-trigger').click(function () {
            jQuery.display('list');

        });
        jQuery('a.grid-trigger').click(function () {
            jQuery.display('grid');
        });

        var view = 'grid';
        view = jQuery.cookie('display') !== undefined ? jQuery.cookie('display') : view;

        if (view) {
            jQuery.display(view);

        } else {
            jQuery.display('grid');
        }
        return false;


    });
    //--></script>
<?php
 } //end else 
?>    

<div class="main-container col2-left-layout">
    <div class="main container">
    
      <div class="row">

        <div class="col-main col-sm-9 col-sm-push-3">
          <div class="pro-coloumn">
          
            
             <div class="category-description std">
                <div class="slider-items-products">
                  <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col1">                   
                                                        
                      <div class="item">
     
                   <?php do_action('woocommerce_archive_description'); ?>
                        </div>
                      <!-- End Item --> 
                      
                    </div>
                  </div>
                </div>
            </div>
         
            
            <div class="col-main pro-grid">  
                <?php if ( have_posts() ) { ?>    
                  <div class="toolbar">
                    <div class="display-product-option">
                            <?php
                            /**
                             * woocommerce_before_shop_loop hook
                             *
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action('woocommerce_before_shop_loop');
                            ?> 
                         <?php do_action('woocommerce_after_shop_loop');?>  
                     </div>               
                   </div>
                   
              


                <div class="category-products">
                    <?php woocommerce_product_loop_start();

                        if ( wc_get_loop_prop( 'total' ) ) {
                            while ( have_posts() ) {
                                the_post();

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 *
                                 * @hooked WC_Structured_Data::generate_product_data() - 10
                                 */
                                do_action( 'woocommerce_shop_loop' );

                                wc_get_template_part( 'content', 'product' );
                            }
                        }

                    woocommerce_product_loop_end(); ?>

                    <?php do_action('woocommerce_after_shop_loop');?> 
                </div>                    
            

            <?php 
                 }
                else {    
                      /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
               }  ?>                             
               
               </div>  <!-- pro-column  --> 
             </div>  <!--  col-main pro-grid    -->
        </div>   <!-- col-sm-9   -->
        

        <div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">     
                   
                <?php
                /**
                 * woocommerce_sidebar hook
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                do_action('woocommerce_sidebar');
                ?>
               
        </div> <!-- col-sm-3   -->
    </div> <!-- row -->
</div> <!-- container -->
</div> <!-- maincontainer -->
<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php get_footer('shop'); ?>
