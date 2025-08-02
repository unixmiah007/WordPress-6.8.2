<?php
if ( ! function_exists ( 'tmOrgan_logo_image' ) ) {
function tmOrgan_logo_image()
{ 
     global $organ_Options;
    $logoUrl = get_template_directory_uri() . '/images/logo.png';
                  
     if (isset($organ_Options['header_use_imagelogo']) && $organ_Options['header_use_imagelogo'] === 0) {
                                   ?>
     <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?>">
               <?php bloginfo('name'); ?>
               </a>
               <?php
                  } else if (isset($organ_Options['header_logo']['url']) && !empty($organ_Options['header_logo']['url'])) { 
                      $logoUrl = $organ_Options['header_logo']['url'];
                      ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?> "> <img
                  alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($logoUrl); ?>"
                  height="<?php echo !empty($organ_Options['header_logo_height']) ? esc_html($organ_Options['header_logo_height']) : ''; ?>"
                  width="<?php echo !empty($organ_Options['header_logo_width']) ? esc_html($organ_Options['header_logo_width']) : ''; ?>"> </a>
               <?php
                  } else { ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo esc_url(get_home_url()); ?>"> 
               <img src="<?php echo esc_url($logoUrl) ;?>" alt="<?php bloginfo('name'); ?>"> </a>
               <?php } 

}
}

if ( ! function_exists ( 'tmOrgan_mobile_search' ) ) {
function tmOrgan_mobile_search()
{ global $organ_Options;
  $TmOrgan = new TmOrgan();
    if (isset($organ_Options['header_remove_header_search']) && !$organ_Options['header_remove_header_search']) : 
        echo'<div class="mobile-search">';
         echo wp_specialchars_decode($TmOrgan->tmOrgan_custom_search_form());
         echo'<div class="search-autocomplete" id="search_autocomplete1" style="display: none;"></div></div>';
         endif;
}
}

if ( ! function_exists ( 'tmOrgan_search_form' ) ) {

 function tmOrgan_search_form()
  {  
    global $organ_Options;
  $TmOrgan = new TmOrgan();
  ?>
  <?php if (isset($organ_Options['header_remove_header_search']) && !$organ_Options['header_remove_header_search']) : ?>
            <div class="block-icon pull-right"> <a data-target=".bs-example-modal-lg" data-toggle="modal" class="search-focus dropdown-toggle links"> <i class="fa fa-search"></i> </a>
              <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-label="Close" data-dismiss="modal" class="close" type="button"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/interstitial-close.png" alt="<?php esc_attr_e('close', 'organ') ;?> "> </button>
                    </div>
                    <div class="modal-body">
                       <div id="modalsearch">
                          <div class="input-group">
 <?php $TmOrgan->tmOrgan_custom_search_form(); ?>
 </div>
                        </div>
                  </div>
                </div>
              </div>
            </div>
             </div>
            <?php  endif; ?>
  <?php
  }
}

if ( ! function_exists ( 'tmOrgan_currency_language' ) ) {

function tmOrgan_currency_language()
{
  global $organ_Options;
   if((isset($organ_Options['enable_header_language']) && ($organ_Options['enable_header_language']!=0)) || (isset($organ_Options['enable_header_currency']) && ($organ_Options['enable_header_currency']!=0)))
        {?>
                           <div class="lang-curr">
                              <?php 
                                 if(isset($organ_Options['enable_header_language']) && ($organ_Options['enable_header_language']!=0))
                                     { ?>
                              <div class="form-language">
                                 <ul class="lang" role="menu">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/english.png" alt="<?php esc_attr_e('English', 'organ');?>">    </a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/francais.png" alt="<?php esc_attr_e('French', 'organ');?>"></a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/german.png" alt="<?php esc_attr_e('German', 'organ');?>">  </a></li>
                                 </ul>
                              </div>
                              <?php  } ?>
                              <!--form-language-->
                              <!-- END For version 1,2,3,4,6 -->
                              <!-- For version 1,2,3,4,6 -->
                              <?php if(isset($organ_Options['enable_header_currency']) && ($organ_Options['enable_header_currency']!=0))
                                 { ?>
                              <div class="form-currency">
                                 <ul class="currencies_list">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('$', 'organ');?>
                                       </a>
                                    </li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('&pound;', 'organ');?>
                                       </a>
                                    </li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                                       <?php esc_attr_e('&euro;', 'organ');?>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                              <?php  } ?> 
                              <!--form-currency-->
                              <!-- END For version 1,2,3,4,6 -->
                           </div>
                           <?php  }  
}
}

if ( ! function_exists ( 'tmOrgan_home_page_banner' ) ) {

function tmOrgan_home_page_banner()
{
    global $organ_Options;
    if(isset($organ_Options['enable_home_gallery']) && $organ_Options['enable_home_gallery']  && isset($organ_Options['home-page-slider']) && !empty($organ_Options['home-page-slider'])) {  
        ?>
  <div id="thm-mart-slideshow" class="thm-mart-slideshow">
  <div class="container">
    <div id='thm_slider_wrapper' class='thm_slider_wrapper fullwidthbanner-container' >
      <div id='thm-rev-slider' class='rev_slider fullwidthabanner'>
      <ul>
      <?php foreach($organ_Options['home-page-slider'] as $slide): ?>
          <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='<?php echo esc_url($slide['thumb']); ?>'><img src='<?php echo esc_url($slide['image']); ?>'  data-bgposition='left top'  data-bgfit='cover' data-bgrepeat='no-repeat' alt="slider-image1" />
           <div class="info">
            <?php echo wp_specialchars_decode($slide['description']);?> 
           </div>  
          </li>       
        <?php endforeach; ?>
      </ul>
    </div>  
  </div>
 </div>
</div>

<!-- end Slider --> 
<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#thm-rev-slider').show().revolution({
                dottedOverlay: 'none',
                delay: 5000,
                startwidth: 0,
                startheight:650,

                hideThumbs: 200,
                thumbWidth: 200,
                thumbHeight: 50,
                thumbAmount: 2,

                navigationType: 'thumb',
                navigationArrows: 'solo',
                navigationStyle: 'round',

                touchenabled: 'on',
                onHoverStop: 'on',
                
                swipe_velocity: 0.7,
                swipe_min_touches: 1,
                swipe_max_touches: 1,
                drag_block_vertical: false,
            
                spinner: 'spinner0',
                keyboardNavigation: 'off',

                navigationHAlign: 'center',
                navigationVAlign: 'bottom',
                navigationHOffset: 0,
                navigationVOffset: 20,

                soloArrowLeftHalign: 'left',
                soloArrowLeftValign: 'center',
                soloArrowLeftHOffset: 20,
                soloArrowLeftVOffset: 0,

                soloArrowRightHalign: 'right',
                soloArrowRightValign: 'center',
                soloArrowRightHOffset: 20,
                soloArrowRightVOffset: 0,

                shadow: 0,
                fullWidth: 'on',
                fullScreen: 'on',

                stopLoop: 'off',
                stopAfterLoops: -1,
                stopAtSlide: -1,

                shuffle: 'off',

                autoHeight: 'on',
                forceFullWidth: 'off',
                fullScreenAlignForce: 'off',
                minFullScreenHeight: 0,
                hideNavDelayOnMobile: 1500,
            
                hideThumbsOnMobile: 'off',
                hideBulletsOnMobile: 'off',
                hideArrowsOnMobile: 'off',
                hideThumbsUnderResolution: 0,

                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                startWithSlide: 0,
                fullScreenOffsetContainer: ''
            });
        });
        </script>


  
<?php 
    }
}
}

if ( ! function_exists ( 'tmOrgan_daily_offer' ) ) {

function tmOrgan_daily_offer()
{
global $organ_Options;
  ?>
    <div class="header-banner">
         <?php  if (isset($organ_Options['topslide']) && !empty($organ_Options['topslide'])) {?>
         <div class="assetBlock">
            <div style="height: 20px; overflow: hidden;" id="slideshow">
               <?php
                  $i=0;              
                  foreach($organ_Options['topslide'] as $topslide)
                  {?>
                  <p style="display: block;"><?php echo wp_specialchars_decode($topslide); ?></p>
                     <?php }?>
            </div>
          
         </div>
        <?php  }?>
                  
      </div>

  <?php  }
}

if ( ! function_exists ( 'tmOrgan_home_offer_banners' ) ) {

//slider bottom banner
function tmOrgan_home_offer_banners()
{
    global $organ_Options;
  if (isset($organ_Options['enable_home_offer_banners']) && !empty($organ_Options['enable_home_offer_banners'])){
        ?>
        <!-- banner -->
    <div id="top">
    <div class="container">
      <div class="row">
        <ul>
            
        <?php if (isset($organ_Options['home-offer-banner1']) && !empty($organ_Options['home-offer-banner1']['url'])) : ?>
        <li>
        <div>         
          <a href="<?php echo !empty($organ_Options['home-offer-banner1-url']) ? esc_url($organ_Options['home-offer-banner1-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner1', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner1']['url']); ?>">              
          </a>        
        </div>
        </li>
        <?php endif; ?>
        
        <?php if (isset($organ_Options['home-offer-banner2']) && !empty($organ_Options['home-offer-banner2']['url'])) : ?>
        <li>
        <div>         
          <a href="<?php echo !empty($organ_Options['home-offer-banner2-url']) ? esc_url($organ_Options['home-offer-banner2-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner2', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner2']['url']); ?>">
          </a>    
        </div>
        </li>
        <?php endif; ?>
        
        <?php if (isset($organ_Options['home-offer-banner3']) && !empty($organ_Options['home-offer-banner3']['url'])) : ?>
        <li>
        <div>
          <a href="<?php echo !empty($organ_Options['home-offer-banner3-url']) ? esc_url($organ_Options['home-offer-banner3-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner3', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner3']['url']); ?>">
          </a>
        </div>
        </li>
        <?php endif; ?>

        <?php if (isset($organ_Options['home-offer-banner4']) && !empty($organ_Options['home-offer-banner4']['url'])) : ?>
        <li>
        <div>
          <a href="<?php echo !empty($organ_Options['home-offer-banner4-url']) ? esc_url($organ_Options['home-offer-banner4-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner4', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner4']['url']); ?>">
          </a>
        </div>
        </li>
        <?php endif; ?>

        <?php if (isset($organ_Options['home-offer-banner5']) && !empty($organ_Options['home-offer-banner5']['url'])) : ?>
        <li>
        <div>
          <a href="<?php echo !empty($organ_Options['home-offer-banner5-url']) ? esc_url($organ_Options['home-offer-banner5-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner5', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner5']['url']); ?>">
          </a>
        </div>
        </li>
        <?php endif; ?>

        <?php if (isset($organ_Options['home-offer-banner6']) && !empty($organ_Options['home-offer-banner6']['url'])) : ?>
        <li>
        <div>
          <a href="<?php echo !empty($organ_Options['home-offer-banner6-url']) ? esc_url($organ_Options['home-offer-banner6-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner6', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner6']['url']); ?>">
          </a>
        </div>
        </li>
        <?php endif; ?>
        </ul>  
            </div>
        </div>
    </div>
    <!-- end banner -->    
    <?php } 
} //function ends here
}

if ( ! function_exists ( 'tmOrgan_header_service' ) ) {
function tmOrgan_header_service()
{
    global $organ_Options;

if (isset($organ_Options['header_show_info_banner']) && !empty($organ_Options['header_show_info_banner'])) :
                  ?>
    <div class="our-features-box wow bounceInUp">
    <div class="container">
       <ul>
    <li>
                     <?php if (!empty($organ_Options['header_shipping_banner'])) : ?>
                      <div class="feature-box free-shipping">
                        <div class="icon-truck"></div>
                        <div class="content"><?php echo wp_specialchars_decode($organ_Options['header_shipping_banner']); ?></div>
                      </div>
                      <?php endif; ?>
                  </li>
                     <li>
                       <?php if (!empty($organ_Options['header_customer_support_banner'])) : ?>
                      <div class="feature-box need-help">
                        <div class="icon-support"></div>
                        <div class="content"><?php echo wp_specialchars_decode($organ_Options['header_customer_support_banner']); ?></div>
                      </div>
                       <?php endif; ?>
                    </li>
                   <li>
                    <?php if (!empty($organ_Options['header_moneyback_banner'])) : ?>
                      <div class="feature-box money-back">
                        <div class="icon-money"></div>
                        <div class="content"><?php echo wp_specialchars_decode($organ_Options['header_moneyback_banner']); ?></div>
                      </div>
                      <?php endif; ?>
                    </li>
                   <li class="last">
                     <?php if (!empty($organ_Options['header_returnservice_banner'])) : ?>
                    <div class="feature-box return-policy">
                      <div class="icon-return"></div>
                      <div class="content"><?php echo wp_specialchars_decode($organ_Options['header_returnservice_banner']); ?></div>
                    </div>
                    <?php endif; ?>
                  </li>
                     
               </ul>
            </div>
        </div>

    <?php
   
     endif;
}
}

if ( ! function_exists ( 'tmOrgan_home_sub_banners' ) ) {
function tmOrgan_home_sub_banners()
{
     global $organ_Options;
   if (isset($organ_Options['enable_home_sub_banners']) && $organ_Options['enable_home_sub_banners']){
        ?>

        <!-- banner -->
<div style="" class="full-banner">
                     <?php if (isset($organ_Options['home-sub-banner1']) && !empty($organ_Options['home-sub-banner1']['url'])) : ?>
                     <div class="col-sm-4">
                   <div class="img_wrapper">

                  <a href="<?php echo !empty($organ_Options['home-sub-banner1-url']) ? esc_url($organ_Options['home-sub-banner1-url']) : '#' ?>">
                    <img src="<?php echo esc_url($organ_Options['home-sub-banner1']['url']); ?>" alt="<?php esc_attr_e('offer banner', 'organ'); ?>">  </a> 
                          </div> 
                         </div> 

                    <?php endif; ?>

                    <div class="col-sm-4">                  
                    <?php if (isset($organ_Options['home-sub-banner2']) && !empty($organ_Options['home-sub-banner2']['url'])) : ?>
                     <div class="img_wrapper">
                            <a href="<?php echo !empty($organ_Options['home-sub-banner2-url']) ? esc_url($organ_Options['home-sub-banner2-url']) : '#' ?>">
                                   <img src="<?php echo esc_url($organ_Options['home-sub-banner2']['url']); ?>"
                                         alt="<?php esc_attr_e('offer banner', 'organ'); ?>">  </a> 
                        </div> 
                    <?php endif; ?>

                    <?php if (isset($organ_Options['home-sub-banner3']) && !empty($organ_Options['home-sub-banner3']['url'])) : ?>
                          <div class="img_wrapper">
                        <a href="<?php echo !empty($organ_Options['home-sub-banner3-url']) ? esc_url($organ_Options['home-sub-banner3-url']) : '#' ?>">
                                    <img src="<?php echo esc_url($organ_Options['home-sub-banner3']['url']); ?>"
                                         alt="<?php esc_attr_e('offer banner', 'organ'); ?>">  </a> 
                       </div>
                    <?php endif; ?>
                    
  
                     </div> 

                <?php 
                 if (isset($organ_Options['home-sub-banner4']) && !empty($organ_Options['home-sub-banner4']['url']))
                 {
        ?>
                 <div class="col-sm-4">
                  <div class="img_wrapper">

                 <a href="<?php echo !empty($organ_Options['home-sub-banner4-url']) ? esc_url($organ_Options['home-sub-banner4-url']) : '#' ?>">
                  <img src="<?php echo esc_url($organ_Options['home-sub-banner4']['url']); ?>" alt="<?php esc_attr_e('offer banner', 'organ'); ?>">  </a>
                  </div>
                 </div> 
        <?php } ?>

       </div>   
<?php }  ?>

        <!-- end banner -->

    <?php 
} 
}

if ( ! function_exists ( 'tmOrgan_category_product' ) ) {

function tmOrgan_category_product($limit)
{
    global $organ_Options;
    if (isset($organ_Options['home-product-categories']) && !empty($organ_Options['home-product-categories'])) {
    $location = 'home-product-categories';
        
      $term = get_term_by( 'id',$organ_Options[$location], 'product_cat', 'ARRAY_A' );   ?>
                     
      <div class="top-cate">
  <div class="featured-pro container">
    <div class="row">
      <div class="slider-items-products">
        <div class="new_title">
          <h2><?php echo esc_html($term['name']); ?></h2>
     
        </div> 
        <div id="top-categories" class="product-flexslider hidden-buttons">
          <div class="slider-items slider-width-col4 products-grid owl-carousel owl-theme" style="opacity: 1; display: block;">
          
        
          <?php
        $args = array(
            'posts_per_page' => $limit,
            'tax_query' => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' =>$organ_Options[$location]
              )
            ),
            'post_type' => 'product',
            'orderby' => 'title',
          );
        

        $loop = new WP_Query( $args );
        
        if ( $loop->have_posts() ) {
          while ( $loop->have_posts() ) : $loop->the_post();
            tmOrgan_category_product_template();
          endwhile;
        } else {
          esc_attr_e( 'No products found', 'organ' );
        }

        wp_reset_postdata();
      ?>
            
        
            <!-- Item -->
            
            <!-- End Item -->
            
          <!-- <div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev"><a class="flex-prev"></a></div><div class="owl-next"><a class="flex-next"></a></div></div></div></div> -->
        </div>
      </div>
    </div>
    </div>
  </div>
  </div>
    <?php   
  }
}
}


if ( ! function_exists ( 'tmOrgan_featured_products' ) ) {
function tmOrgan_featured_products()
{
    global $organ_Options;
    if (isset($organ_Options['enable_home_featured_products']) && !empty($organ_Options['enable_home_featured_products'])) {
        ?>
  <div class="container">
    <div class="row">

<div class="col-sm-9 col-xs-12">       
   <div class="featured-pro  wow bounceInUp animated">
    <div class="slider-items-products">
    <div class="new_title center">
        <h2>
          <?php esc_attr_e('Featured Products', 'organ'); ?>
        </h2>
      </div>
    <div id="featured-slider" class="product-flexslider hidden-buttons">
      <div class="slider-items products-grid slider-width-col6 owl-carousel owl-theme"> 
        
                <?php
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'meta_key' => '_featured',
                    'meta_value' => 'yes',                   
                    'posts_per_page' => $organ_Options['featured_per_page']
                  
                );
                $loop = new WP_Query($args);
                if ($loop->have_posts()) {
                    while ($loop->have_posts()) : $loop->the_post();
                        tmOrgan_featured_template();
                    endwhile;
                } else {
                    esc_attr_e('No products found','organ');
                }

                wp_reset_postdata();
                ?>
    
      </div>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-3 col-xs-12">
<?php  
  if (isset($organ_Options['featured_image']) && !empty($organ_Options['featured_image']['url']))
 {?>
 <div class="featured-box">
  <a href="<?php echo !empty($organ_Options['featured_product_url']) ? esc_url($organ_Options['featured_product_url']) : '#' ?>">                 
 <img src="<?php echo esc_url($organ_Options['featured_image']['url']); ?>" alt="<?php esc_attr_e('Featured', 'organ'); ?>">
   </a> 
  </div>          
<?php } ?> 
     </div> 
      </div>
    </div>
    <?php
    }
}
}

if ( ! function_exists ( 'tmOrgan_bestseller_products' ) ) {
function tmOrgan_bestseller_products()
{
   global $organ_Options,$yith_wcwl;

if (isset($organ_Options['enable_home_bestseller_products']) && !empty($organ_Options['enable_home_bestseller_products']) && !empty($organ_Options['home_bestseller_categories'])) { 
  ?>
<div class="best-pro slider-items-products container">
  <div class="new_title">
    <h2><?php esc_attr_e('Best Seller', 'organ'); ?></h2>
  </div>  
  <?php  
  if (isset($organ_Options['bestseller_image']) && !empty($organ_Options['bestseller_image']['url']))
 {?>
       <div class="cate-banner-img">
        <a href="<?php echo !empty($organ_Options['bestseller_product_url']) ? esc_url($organ_Options['bestseller_product_url']) : '#' ?>">
         <img src="<?php echo esc_url($organ_Options['bestseller_image']['url']); ?>" alt="<?php esc_attr_e('best seller', 'organ'); ?>">
       </a>
          </div>   
<?php } ?>     
      

  <!-- Tab panes -->
<div id="best-seller" class="product-flexslider hidden-buttons">
    <div class="slider-items slider-width-col4 products-grid">  
  
    <?php 
 //    $contentloop=1;
 //  foreach($organ_Options['home_bestseller_categories'] as $catcontent)
 // {
 //   $term = get_term_by( 'id', $catcontent, 'product_cat', 'ARRAY_A' );

                
 //                              $args = array(
 //                              'post_type'       => 'product',
 //                              'post_status'       => 'publish',
 //                              'ignore_sticky_posts'   => 1,
 //                              'posts_per_page'    => 10,      
 //                              'meta_key'        => 'total_sales',
 //                              'orderby'         => 'meta_value_num',
 //                              'tax_query' => array(       
 //                               array(
 //                              'taxonomy' => 'product_cat',
 //                              'field' => 'id',
 //                              'terms' => $catcontent,
 //                               )
 //                               ),
 //                              'meta_query'      => array(
 //                               array(
 //                               'key'     => '_visibility',
 //                               'value'   => array( 'catalog', 'visible' ),
 //                               'compare'   => 'IN'
 //                               )
 //                              )
 //                              );
      $meta_query = WC()->query->get_meta_query();
                 
                  $tax_query = WC()->query->get_tax_query();
                  $tax_query[] = array(
                      'taxonomy' => 'product_cat',
                      'field'  => 'id',                                   
                      'terms' => isset($organ_Options['home_bestseller_categories']) ? $organ_Options['home_bestseller_categories'] : '',
                      'operator' => 'IN',
                  );

                  $query_args = array(
                      'post_type' => 'product',
                      'post_status' => 'publish',
                      'ignore_sticky_posts' => 1,
                      'posts_per_page' => isset($organ_Options['bestseller_per_page']) ? $organ_Options['bestseller_per_page'] : 5,      
                      'meta_key'=>'total_sales',                    
                      'orderby' => 'meta_value_num',
                      'order' => 'desc',
                      'meta_query' => WC()->query->get_meta_query(),
                      'tax_query' => $tax_query,
                  );

                                $loop = new WP_Query( $query_args );
                                if ( $loop->have_posts() ) {
                                while ( $loop->have_posts() ) : $loop->the_post();                  
                                tmOrgan_bestseller_template();
                                endwhile;
                                } else {
                                esc_attr_e( 'No products found', 'organ' );
                                }

                               wp_reset_postdata();
                               //$contentloop++;
                             
?>

      
 <?php  //} ?>

</div>
</div>
</div>
<?php 
}
}
}

if ( ! function_exists ( 'tmOrgan_home_blog_posts' ) ) {
function tmOrgan_home_blog_posts()
{
    $count = 0;
    global $organ_Options;
    $TmOrgan = new TmOrgan();
    if (isset($organ_Options['enable_home_blog_posts']) && !empty($organ_Options['enable_home_blog_posts'])) {
        ?>
        <div class="latest-blog container">

      
 <div class="row">
       
        <?php

        $args = array('posts_per_page' => 3, 'post__not_in' => get_option('sticky_posts'));
        $the_query = new WP_Query($args);
           $i=1;  
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post(); ?>
            
                <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">  
                  <div class="blog_inner">
                     <div class="blog-img">  
                      <a href="<?php the_permalink(); ?>">
                                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail'); ?>
                                <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>">
                            </a>
                           
                      </div>
                      <div class="blog-info">
                      <div class="home-blog-title">
                     <h3>
                      <a href="<?php the_permalink(); ?>"><?php esc_html(the_title()); ?>
                     </a>
                   </h3>
                      <div class="post-date"><i class="fa fa-calendar"></i>
                    <time class="entry-date" datetime="2015-05-11T11:19:34+00:00"><?php esc_html(the_time('d<\b\\r>M')); ?></time>
                    </div>
                  </div>
                     <ul>
                     
                    <li><i class="fa fa-eye"></i><?php echo esc_html($TmOrgan->tmOrgan_getPostViews(get_the_ID())); ?> </li>

                      <li><i class="fa fa-comment"></i><a href="<?php comments_link(); ?>"><?php comments_number('0 Comment', '1 Comment', '% Comments'); ?>
                          </a></li>
                    </ul> 
                  <div class="homeblog">
                    <?php the_excerpt(); ?>
                   </div> 
                    <a class="readmore" href="<?php the_permalink(); ?>"><?php esc_attr_e('Read More','organ'); ?></a> 

                  </div>
             </div>
              </div>
            <?php    $i++;
             endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <p>
                <?php esc_attr_e('Sorry, no posts matched your criteria.', 'organ'); ?>
            </p>
        <?php endif;
        ?>
        </div>
        
</div>
<?php
    }
}
}

if ( ! function_exists ( 'tmOrgan_footer_brand_logo' ) ) {
function tmOrgan_footer_brand_logo()
{
    global $organ_Options;
    if (isset($organ_Options['enable_brand_logo']) && $organ_Options['enable_brand_logo'] && !empty($organ_Options['all-company-logos'])) : ?>
    <div class="logo-brand col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="new_title">
      <h2>Brand Logo</h2>
    </div>
    <div class="slider-items-products">
      <div id="brand-slider" class="product-flexslider hidden-buttons">
      <div class="slider-items slider-width-col6"> 
        <?php $i=0;
        foreach ($organ_Options['all-company-logos'] as $_logo) : ?>
        <!-- Item -->
        <?php if($i==0) { ?> 
         <div class="item"> 
        <?php } ?>         
          <a href="<?php echo esc_url($_logo['url']); ?>" target="_blank"> <img
                        src="<?php echo esc_url($_logo['image']); ?>" 
                        alt="<?php echo esc_attr($_logo['title']); ?>"> </a>
        <?php if($i==1) { $i=0; ?>  
        </div>               
        <?php } else { $i++; } ?>
        <!-- End Item -->
        <?php endforeach; ?>
      </div>
      </div>
    </div>
    </div>
  

  <?php endif;
}
}
if ( ! function_exists ( 'tmOrgan_home_testimonial' ) ) {
function tmOrgan_home_testimonial()
{
 global $organ_Options;

  if(isset($organ_Options['enable_testimonial']) && !empty($organ_Options['enable_testimonial']) && isset($organ_Options['all_testimonial']) && !empty($organ_Options['all_testimonial'])) {
?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 testimonials-section">
<div class="offer-slider parallax parallax-2">
<ul class="bxslider">

<?php
  foreach ($organ_Options['all_testimonial'] as $testimono) :  
  ?>
<li>
<div class="avatar"><img src="<?php echo esc_url($testimono['image']); ?>" data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat'
                                        alt="<?php echo esc_html($testimono['title']); ?>"/>   </div>
<div class="testimonials"><?php echo wp_specialchars_decode($testimono['description']); ?></div>
<div class="clients_author"><a href="<?php echo !empty($testimono['url']) ? esc_url($testimono['url']) : '#' ?>" target="_blank">
              <?php echo wp_specialchars_decode($testimono['title']); ?>       </a></div>
</li>


        <?php endforeach; ?>

<?php
}
?>
</ul>
</div>
</div>
          
<?php
}
}

if ( ! function_exists ( 'tmOrgan_footer_middle' ) ) {
function tmOrgan_footer_middle()
{
  global $organ_Options;
 if (isset($organ_Options['enable_footer_middle']) && !empty($organ_Options['enable_footer_middle'])) {?>
    <div class="newsletter-row">
      <div class="container">
        <div class="row">
          <!-- Footer Newsletter -->
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <!-- Footer Newsletter -->
          <?php 
    if( function_exists( 'mc4wp_show_form' ) ) {
                 ?> 
        
            <div class="newsletter-wrap">
               <?php
                 mc4wp_show_form();
                ?>
           
            <!--newsletter-wrap-->
          </div>
          <?php  }   ?>
           </div>
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <!-- Footer Payment Link -->
             <?php   
              if (isset($organ_Options['footer-text']) && !empty($organ_Options['footer-text'])) {
                  echo wp_specialchars_decode($organ_Options['footer-text']);
                  }
             ?>
        </div>
        </div>
      </div>
      <!--footer-column-last-->
    </div>
    <?php  }  

}
}

if ( ! function_exists ( 'tmOrgan_bestseller_template' ) ) {
function tmOrgan_bestseller_template()
{
  $TmOrgan = new TmOrgan();
  global $product, $woocommerce_loop, $yith_wcwl,$post;
   $imageUrl = wc_placeholder_img_src();
   if (has_post_thumbnail())
      $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-large');
   ?>
 <div class="item">
     <div class="item-inner">
      <div class="item-img">
         <div class="item-img-info">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
               <figure class="img-responsive">
            <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>">
             </figure>
             </a>
            <?php if ($product->is_on_sale()) : ?>
            <div class="sale-label sale-top-left">
               <?php esc_attr_e('Sale', 'organ'); ?>
            </div>
            <?php endif; ?>
            <div class="item-box-hover">
               <div class="box-inner">
                  <div class="product-detail-bnt">
                     <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                     <a class="yith-wcqv-button quickview button detail-bnt" title="<?php esc_attr_e('Quick View', 'organ'); ?>" href="#"
                        data-product_id="<?php echo esc_html($product->get_id()); ?>"><span> <?php esc_attr_e('Quick View', 'organ'); ?></span></a>
                     <?php } ?>
                  </div>
                  <div class="actions">
                     <span class="add-to-links">
                     <?php
                        if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                            $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                            ?>
                     <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>"  data-product-id="<?php echo esc_html($product->get_id()); ?>"
                        data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                        title="<?php esc_attr_e('Add to Wishlist', 'organ'); ?>"><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a> 
                     <?php
                        }
                        ?> 
                     <?php if (class_exists('YITH_Woocompare_Frontend')) {
                        $tm_yith_cmp = new YITH_Woocompare_Frontend; ?>      
                     <a href="<?php echo esc_url($tm_yith_cmp->add_product_url($product->get_id())); ?>" class="compare link-compare add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"
                        title="<?php esc_attr_e('Add to Compare', 'organ'); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); 
                        ?></span></a>
                     <?php
                        }
                        ?>              
                     </span> 
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
      <div class="item-info">
         <div class="info-inner">
            <div class="item-title"><a href="<?php the_permalink(); ?>"
               title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a>
            </div>
            <div class="item-content">
               <div class="rating">
                  <div class="ratings">
                     <div class="rating-box">
                        <?php $average = $product->get_average_rating(); ?>
                        <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"> </div>
                     </div>
                  </div>
               </div>
               <div class="item-price">
                  <div class="price-box">
                    <?php echo wp_specialchars_decode($product->get_price_html()); ?>
                  </div>
               </div>
               <div class="add_cart">
                     <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
}
}

if ( ! function_exists ( 'tmOrgan_category_product_template' ) ) {
function tmOrgan_category_product_template()
{

  $TmOrgan = new TmOrgan();
  global $product, $woocommerce_loop, $post, $woocommerce, $yith_wcwl, $organ_Options
  ;
  $imageUrl = wc_placeholder_img_src();
  if (has_post_thumbnail())
        $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-small');;
  ?>
  
    <div class="item">
      <div class="pro-img">
          <a title="<?php echo esc_attr($post->post_title); ?>" href="<?php the_permalink(); ?>"><img alt="<?php echo esc_attr($post->post_title); ?>" class="img-responsive" src="<?php echo esc_url($imageUrl[0]); ?>"></a>
          <div class="pro-info"><a title="<?php echo esc_attr($post->post_title); ?>" href="<?php the_permalink(); ?>"><?php echo esc_html($post->post_title); ?></a></div>
      </div>
    </div>
 
<?php 
}
}


if ( ! function_exists ( 'tmOrgan_featured_template' ) ) {
function tmOrgan_featured_template()
{

$TmOrgan = new TmOrgan();
global $product, $woocommerce_loop, $yith_wcwl,$post;

$imageUrl = wc_placeholder_img_src();
if (has_post_thumbnail())
    $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-large');  
?>
<!-- Item -->
<div class="item">
<div class="item-inner">
   <div class="item-img">
      <div class="item-img-info">
         <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
           <figure class="img-responsive">
          <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>">
          </figure>
           </a>
         <div class="item-box-hover">
            <div class="box-inner">

      <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
               <div class="product-detail-bnt"><a class="button detail-bnt yith-wcqv-button quickview" title="<?php esc_attr_e('Quick View', 'organ'); ?>"  data-product_id="<?php echo esc_html($product->get_id()); ?>"><span> <?php esc_attr_e('Quick View', 'organ'); ?></span></a></div>
      <?php } ?>            
               <div class="actions"><span class="add-to-links">
                 <?php
                                    if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                                        $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                                        ?>
                                                  <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>"  data-product-id="<?php echo esc_html($product->get_id()); ?>"
                                           data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                                           title="<?php esc_attr_e('Add to Wishlist', 'organ'); ?>"><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a> 
                                          <?php
                                            }
                                        ?> 

                               
                                    <?php if (class_exists('YITH_Woocompare_Frontend')) {
                                        $tm_yith_cmp = new YITH_Woocompare_Frontend; ?>      
                                                  <a href="<?php echo esc_url($tm_yith_cmp->add_product_url($product->get_id())); ?>" class="compare link-compare add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"
                                           title="<?php esc_attr_e('Add to Compare', 'organ'); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); 
                                           ?></span></a>
                                      <?php
                                    }
                                    ?>      
                          </span> </div>
               <div class="add_cart">
                 <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="item-info">
      <div class="info-inner">
         <div class="item-title"><a href="<?php the_permalink(); ?>"
                                               title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a> </div>
         <div class="item-content">
            <div class="rating">
               <div class="ratings">
                  <div class="rating-box">
                    <?php $average = $product->get_average_rating(); ?>
                     <div class="rating"  style="width:<?php echo esc_html(($average / 5) * 100); ?>%"></div>
                  </div>
                  
               </div>
            </div>
            <div class="item-price">
               <div class="price-box"><?php echo wp_specialchars_decode($product->get_price_html()); ?></div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php
}
}

if ( ! function_exists ( 'tmOrgan_hotdeal_template' ) ) {
function tmOrgan_hotdeal_template()
{
$TmOrgan = new TmOrgan();
 global $product, $woocommerce_loop, $yith_wcwl,$post;
   $imageUrl = wc_placeholder_img_src();
   if (has_post_thumbnail())
        $imageUrl = wp_get_attachment_url(get_post_thumbnail_id());

              $product_type = $product->get_type();

          
              if($product_type=='variable')
              {
               $available_variations = $product->get_available_variations();
               $variation_id=$available_variations[0]['variation_id'];
                $newid=$variation_id;
              }
              else
              {
                $newid=$post->ID;
           
              }                                    
               $sales_price_to = get_post_meta($newid, '_sale_price_dates_to', true);  
               $sales_price_date_to = date("m/d/y h:i:s A", $sales_price_to);  
               $curdate=date("m/d/y h:i:s A");
                         
?> 
         
           <li class="item col-lg-12 banner-arrow">
                  <div class="item-inner">
                  <input type="hidden" name="hot_sale_end" id="hot_sale_end" value="<?php echo esc_html($sales_price_date_to) ;?>"> 
                    <input type="hidden" name="hot_sale_current" id="hot_sale_current" value="<?php echo esc_html($curdate) ;?>">
                     <div class="item-img">
                     <div class="box-timer">
                     <div class="countbox_1 timer-grid">
                     </div>
                     </div>
                
               <div class="item-img-info">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
              <figure class="img-responsive">
            <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl); ?>">
              </figure>
             </a>
            <?php if ($product->is_on_sale()) : ?>
            <div class="sale-label sale-top-left">
               <?php esc_attr_e('Sale', 'organ'); ?>
            </div>
            <?php endif; ?>
             </div>
                </div>
              <div class="item-info banner-top banner1">
               <div class="text-banner">
               <div class="banner-texthome">
               
                 <h2><?php esc_attr_e('Hot Deal', 'organ'); ?></h2>
                <h3> <a href="<?php the_permalink(); ?>"
               title="<?php echo esc_html($post->post_title); ?>"> 
               <?php echo esc_html($post->post_title); ?> </a></h3>

                 <h4>
                 <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
                  </h4>
                </div>
                  </div>
                  
                  </div>
                 
                  </div>
                </li>
<?php
}
}

if ( ! function_exists ( 'tmOrgan_recommended_template' ) ) {
function tmOrgan_recommended_template()
{
  $TmOrgan = new TmOrgan();
 global $product, $woocommerce_loop, $yith_wcwl,$post;
$imageUrl = wc_placeholder_img_src();
if (has_post_thumbnail())
        $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-large');
?>
<li class="item item-animate">
   <div class="item-inner">
      <div class="item-img">
         <div class="item-img-info">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
                <figure class="img-responsive">
            <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>"> 
             </figure>
            </a>
            <?php if ($product->is_on_sale()) : ?>
            <div class="sale-label sale-top-left">
               <?php esc_attr_e('Sale', 'organ'); ?>
            </div>
            <?php endif; ?>
            <div class="item-box-hover">
               <div class="box-inner">
                  <div class="product-detail-bnt">
                     <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                     <a class="yith-wcqv-button quickview button detail-bnt" title="<?php esc_attr_e('Quick View', 'organ'); ?>" href="#"
                        data-product_id="<?php echo esc_html($product->get_id()); ?>"><span> <?php esc_attr_e('Quick View', 'organ'); ?></span></a>
                     <?php } ?>
                  </div>
                  <div class="actions">
                     <span class="add-to-links">
                     <?php
                        if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                        $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                        ?>
                     <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>"  data-product-id="<?php echo esc_html($product->get_id()); ?>"
                        data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                        title="<?php esc_attr_e('Add to Wishlist', 'organ'); ?>"><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a> 
                     <?php
                        }
                        ?> 
                     <?php 
                        if (class_exists('YITH_Woocompare_Frontend')) {
                        $tm_yith_cmp = new YITH_Woocompare_Frontend; ?>      
                     <a href="<?php echo esc_url($tm_yith_cmp->add_product_url($product->get_id())); ?>" class="compare link-compare add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"
                        title="<?php esc_attr_e('Add to Compare', 'organ'); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); ?></span></a>
                     <?php
                        }
                        ?>
                     </span> 
                  </div>
                  <div class="add_cart">
                    <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="item-info">
         <div class="info-inner">
            <div class="item-title"> <a href="<?php the_permalink(); ?>"
               title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a> </div>
            <div class="item-content">
               <div class="rating">
                  <div class="ratings">
                     <div class="rating-box">
                        <?php $average = $product->get_average_rating(); ?>
                        <div class="rating"  style="width:<?php echo esc_html(($average / 5) * 100); ?>%"></div>
                     </div>           
                  </div>
               </div>
               <div class="item-price">
                  <div class="price-box">
                    <?php echo wp_specialchars_decode($product->get_price_html()); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</li>
<?php
}
}

if ( ! function_exists ( 'tmOrgan_related_upsell_template' ) ) {
function tmOrgan_related_upsell_template()
{
  $TmOrgan = new TmOrgan();
 global $product, $woocommerce_loop, $yith_wcwl,$post;


$imageUrl = wc_placeholder_img_src();
if (has_post_thumbnail())
    $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-large'); 
     
?>
<!-- Item -->
<div class="item">
<div class="item-inner">
   <div class="item-img">
      <div class="item-img-info">
         <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
           <figure class="img-responsive">
          <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>">
          </figure>
         </a>
         <?php if ($product->is_on_sale()) : ?>
            <div class="sale-label sale-top-left">
               <?php esc_attr_e('Sale', 'organ'); ?>
            </div>
         <?php endif; ?>
         <div class="item-box-hover">
            <div class="box-inner">

      <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
               <div class="product-detail-bnt"><a class="button detail-bnt yith-wcqv-button quickview" title="<?php esc_attr_e('Quick View', 'organ'); ?>"  data-product_id="<?php echo esc_html($product->get_id()); ?>"><span> <?php esc_attr_e('Quick View', 'organ'); ?></span></a></div>
      <?php } ?>            
               <div class="actions"><span class="add-to-links">
                 <?php
                                    if (isset($yith_wcwl) && is_object($yith_wcwl)) {
                                        $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                                        ?>
                                                  <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>"  data-product-id="<?php echo esc_html($product->get_id()); ?>"
                                           data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                                           title="<?php esc_attr_e('Add to Wishlist', 'organ'); ?>"><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a> 
                                          <?php
                                            }
                                        ?> 

                               
                                    <?php if (class_exists('YITH_Woocompare_Frontend')) {
                                        $tm_yith_cmp = new YITH_Woocompare_Frontend; ?>      
                                                  <a href="<?php echo esc_url($tm_yith_cmp->add_product_url($product->get_id())); ?>" class="compare link-compare add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"
                                           title="<?php esc_attr_e('Add to Compare', 'organ'); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); 
                                           ?></span></a>
                                      <?php
                                    }
                                    ?>      
                          </span> </div>
               
            </div>
         </div>
      </div>
   </div>
   <div class="item-info">
      <div class="info-inner">
         <div class="item-title"><a href="<?php the_permalink(); ?>"
                                               title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a> </div>
         <div class="item-content">
            <div class="rating">
               <div class="ratings">
                  <div class="rating-box">
                    <?php $average = $product->get_average_rating(); ?>
                     <div class="rating"  style="width:<?php echo esc_html(($average / 5) * 100); ?>%"></div>
                  </div>
                  
               </div>
            </div>
            <div class="item-price">
               <div class="price-box"><?php echo wp_specialchars_decode($product->get_price_html()); ?></div>
            </div>
            <div class="add_cart">
                 <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php
}
}