<!DOCTYPE html>
<html <?php language_attributes(); ?> id="parallax_scrolling">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
 <?php wp_head(); ?>
</head>
<?php
 $TmOrgan = new TmOrgan(); ?>
<body <?php body_class('cms-index-index  cms-home-page'); ?> >
  <?php wp_body_open(); ?>
  <div id="page" class="page catalog-category-view">

      <!-- Header -->
      <header id="header" >
	     <?php tmOrgan_daily_offer();?>
       <div id="header">
         <div class="header-container container">
         <div class="row">
            <!-- Header Logo -->
            <div class="logo">
             <div><?php tmOrgan_logo_image();?></div>
            </div>
            <!-- End Header Logo -->
          

            <div class="top-menu">          
               
                  <a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
                 
                  <div class="tm-main-menu">
                     <div id="main-menu">
                        <?php echo tmOrgan_main_menu(); ?>                       
                    
                     </div>
                     </div>
               
            </div>
             
               <div class="header-right-col">
                <?php  if ( has_nav_menu( 'toplinks' ) ) :?>
                  <div class="click-nav">
                     <div class="no-js">
                        <a title="<?php esc_attr_e('clicker:', 'organ');?>" class="clicker"></a>
                        <div class="top-links">
                            <?php tmOrgan_currency_language();?>
                            <?php echo tmOrgan_top_navigation(); ?>                           
                        </div>
                     </div>
                  </div>
               <?php endif ;?>
                  <div class="top-cart-contain">
                     <?php
                        if (class_exists('WooCommerce')) :
                             $TmOrgan->tmOrgan_mini_cart();
                             endif;
                             ?>
                     <!--top-cart-content-->
                  </div>

                  <!--mini-cart-->

                    <!-- top search code -->
              <div class="top-search">
              
                     <?php echo tmOrgan_search_form(); ?>  
                   
                     
          </div>
                 
                  <!--links-->
               </div>
            </div>
         </div>
        </div> 
      </header>
      <!-- end header -->
      <?php if (class_exists('WooCommerce') && is_woocommerce()) : ?>
     <div class="page-heading">
    <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
                  <?php woocommerce_breadcrumb(); ?>
              </div>
          <!--col-xs-12--> 
        </div>
        <!--row--> 
      </div>
      <!--container--> 
    </div>
         <?php if(is_product_category()){?>
         <div class="page-title">
             <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                            <h2>
                                <?php esc_html(woocommerce_page_title()); ?>
                            </h2>
                        <?php endif; ?>
     
    </div>
    <?php } ?>
      </div>
      <?php endif; ?>