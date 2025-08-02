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
<body <?php body_class(); ?> >
  <?php wp_body_open(); ?>
  <div class="page">

      <!-- Header -->
      <header>	     
       <div class="header-container">
         <div class="header-top">
          <div class="container">
           <div class="row">
            <div class="col-lg-6 col-sm-4 col-md-4 col-xs-7">
              <?php tmOrgan_currency_language();?>
              <div class="welcome-msg hidden-xs"><?php tmOrgan_welcomemsg() ?></div>
	      
            </div>
            <div class="col-lg-6 col-sm-8 col-md-8 col-xs-5"> 
              <!--mini-cart-->
              <div class="top-cart-contain pull-right">
                     <?php
                        if (class_exists('WooCommerce')) :
                             tmOrgan_mini_cartv2();
                             endif;
                             ?>
                     <!--top-cart-content-->
                </div>
                 <!-- top search code -->
                <div class="top-search">
                     <?php echo tmOrgan_search_form(); ?>  
                </div>
                <?php  if ( has_nav_menu( 'toplinks' ) ) :?>
             
                      <div class="toplinks">
                        <div class="links">                            
                            <?php echo tmOrgan_top_navigation(); ?>                           
                        </div>
                     </div>
              
               <?php endif ;?> 
            </div>  
            </div>
            </div>
           </div>  <!-- container -->
         </div>        
      </header>
      <!-- end header -->
      <nav>
        <div class="container">
            <!-- Header Logo -->
            <div class="logo">
             <div><?php tmOrgan_logo_image();?></div>
            </div>
            <!-- End Header Logo -->
          

            <div class="top-menu">          
               
                  <a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
                  <div class="tm-main-menu">
                     <div id="main-menu">
                  <?php  if ( has_nav_menu( 'menu_left' ) ) :?>
                  	<?php echo tmOrgan_menu_left(); ?> 
                  <?php endif ;?>                  
                  <?php  if ( has_nav_menu( 'menu_right' ) ) :?>
                  	<?php echo tmOrgan_menu_right(); ?> 
                  <?php endif ;?> 
                  
                        <?php //echo tmOrgan_main_menu(); ?>                       
                    
                     </div>
                     </div>
               
            </div>
        </div>
      </nav>       
              
                
                 

                  

                   
                 
                  <!--links-->
               
      <?php if (class_exists('WooCommerce') && is_woocommerce()) : ?>
     
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
         
    <?php endif; ?>