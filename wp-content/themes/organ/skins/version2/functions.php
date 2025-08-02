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
                          
                              <?php 
                                 if(isset($organ_Options['enable_header_language']) && ($organ_Options['enable_header_language']!=0))
                                     { ?>
                               <div class="dropdown block-language-wrapper"> 
			            <a role="button" data-toggle="dropdown" data-target="#" class="block-language dropdown-toggle" href="#"> 
			              <img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/english.png" alt="<?php esc_attr_e('English', 'organ');?>">  
			              <?php esc_attr_e('English', 'organ');?><span class="caret"></span>
			            </a>
			            <ul class="dropdown-menu" role="menu">
			              <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/english.png" alt="<?php esc_attr_e('English', 'organ');?>">    <?php esc_attr_e('English', 'organ');?></a></li>
			              <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/francais.png" alt="<?php esc_attr_e('French', 'organ');?>"> <?php esc_attr_e('French', 'organ');?> </a></li>
			              <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="<?php echo esc_url(get_template_directory_uri()) ;?>/images/german.png" alt="<?php esc_attr_e('German', 'organ');?>">   <?php esc_attr_e('German', 'organ');?></a></li>
			            </ul>
			        </div>
                              <?php  } ?>
                              <!--form-language-->
                              <!-- END For version 1,2,3,4,6 -->
                              <!-- For version 1,2,3,4,6 -->
                              <?php if(isset($organ_Options['enable_header_currency']) && ($organ_Options['enable_header_currency']!=0))
                                 { ?>
                              <div class="dropdown block-currency-wrapper"> 
			            <a role="button" data-toggle="dropdown" data-target="#" class="block-currency dropdown-toggle" href="#">  
			              <?php esc_attr_e('USD', 'organ');?> <span class="caret"></span></a>
			            <ul class="dropdown-menu" role="menu">
			              <li role="presentation">
			                <a role="menuitem" tabindex="-1" href="#">
			                <?php esc_attr_e('$ - Dollar', 'organ');?>
			                </a>
			              </li>
			              <li role="presentation">
			                <a role="menuitem" tabindex="-1" href="#">
			                <?php esc_attr_e('&pound; - Pound', 'organ');?>
			                </a>
			              </li>
			              <li role="presentation">
			                <a role="menuitem" tabindex="-1" href="#">
			                <?php esc_attr_e('&euro; - Euro', 'organ');?>
			                </a>
			              </li>
			            </ul>
			      </div>
                              <?php  } ?> 
                              <!--form-currency-->
                              <!-- END For version 1,2,3,4,6 -->
                           
                           <?php  }  
}
}

if ( ! function_exists ( 'tmOrgan_home_page_banner' ) ) {

function tmOrgan_home_page_banner()
{
    global $organ_Options;
    if(isset($organ_Options['enable_home_gallery']) && $organ_Options['enable_home_gallery']  && isset($organ_Options['home-page-slider']) && !empty($organ_Options['home-page-slider'])) {  
        ?>
<div id="thm-slideshow" class="thm-slideshow">
 <div class="container">
  <div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;"> 
 
    <div id="rev_slider_4_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.0.7">
    <ul>
<?php foreach($organ_Options['home-page-slider'] as $slide):
 $imgtag='<img src="'. esc_url($slide['image']).'"  alt="'.esc_html($slide['title']).'"  />';
  $thumb=  str_replace("{IMGTHUMB}",$slide['thumb'],$slide['description']);
  $title=  str_replace("{IMGTITLE}",$slide['title'],$thumb);
  $newdesc= str_replace("{IMGSRC}",$imgtag,$title);
?>

<?php echo wp_specialchars_decode($newdesc); ?> 
  <?php endforeach; ?>
  </ul>
  <div class="tp-static-layers"></div>
    <div class="tp-bannertimer" style="height: 7px; background-color: rgba(255, 255, 255, 0.25);"></div>
 </div>
</div>
</div>
</div>


<!-- end Slider --> 
<script type="text/javascript">
var tpj=jQuery;     
          var revapi4;
          tpj(document).ready(function() {
            if(tpj("#rev_slider_4_1").revolution == undefined){
              revslider_showDoubleJqueryError("#rev_slider_4_1");
            }else{
              revapi4 = tpj("#rev_slider_4_1").show().revolution({
                sliderType:"standard",
                sliderLayout:"fullwidth",
                dottedOverlay:"none",
                delay:9000,
                navigation: {
                  keyboardNavigation:"off",
                  keyboard_direction: "horizontal",
                  mouseScrollNavigation:"off",
                  onHoverStop:"off",
                  touch:{
                    touchenabled:"on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                  }
                  ,
                  arrows: {
                    style:"zeus",
                    enable:true,
                    hide_onmobile:true,
                    hide_under:700,
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    tmp:'<div class="tp-title-wrap">    <div class="tp-arr-imgholder"></div> </div>',
                    left: {
                      h_align:"left",
                      v_align:"center",
                      h_offset:30,
                      v_offset:0
                    },
                    right: {
                      h_align:"right",
                      v_align:"center",
                      h_offset:30,
                      v_offset:0
                    }
                  }
                  ,
                  bullets: {
                    enable:true,
                    hide_onmobile:true,
                    hide_under:600,
                    style:"metis",
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    direction:"horizontal",
                    h_align:"center",
                    v_align:"bottom",
                    h_offset:0,
                    v_offset:30,
                    space:5,
                    tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span><span class="tp-bullet-title">{{title}}</span>'
                  }
                },
                viewPort: {
                  enable:true,
                  outof:"pause",
                  visible_area:"80%"
                },
                responsiveLevels:[1240,1024,778,480],
                gridwidth:[768,1024,778,480],
                gridheight:[700,600,500,400],
                lazyType:"none",
                parallax: {
                  type:"mouse",
                  origo:"slidercenter",
                  speed:2000,
                  levels:[2,3,4,5,6,7,12,16,10,50],
                },
                shadow:0,
                spinner:"off",
                stopLoop:"off",
                stopAfterLoops:-1,
                stopAtSlide:-1,
                shuffle:"off",
                autoHeight:"off",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                  simplifyAll:"off",
                  nextSlideOnWindowFocus:"off",
                  disableFocusListener:false,
                }
              });
            }
          }); /*ready*/        
</script>


  
<?php 
    }
}
}


if ( ! function_exists ( 'tmOrgan_home_offer_banners' ) ) {

//slider bottom banner
function tmOrgan_home_offer_banners()
{
    global $organ_Options;
  if (isset($organ_Options['enable_home_offer_banners']) && !empty($organ_Options['enable_home_offer_banners'])){
        ?>
        <!-- banner -->
    <div class="promo-section">
    <div class="container">
      <div class="row">       
        <?php if (isset($organ_Options['home-offer-banner1']) && !empty($organ_Options['home-offer-banner1']['url'])) : ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">         
          <a href="<?php echo !empty($organ_Options['home-offer-banner1-url']) ? esc_url($organ_Options['home-offer-banner1-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner1', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner1']['url']); ?>">              
          </a>        
        </div>
        <?php endif; ?>
        
        <?php if (isset($organ_Options['home-offer-banner2']) && !empty($organ_Options['home-offer-banner2']['url'])) : ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">         
          <a href="<?php echo !empty($organ_Options['home-offer-banner2-url']) ? esc_url($organ_Options['home-offer-banner2-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner2', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner2']['url']); ?>">
          </a>    
        </div>
        <?php endif; ?>
        
        <?php if (isset($organ_Options['home-offer-banner3']) && !empty($organ_Options['home-offer-banner3']['url'])) : ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <a href="<?php echo !empty($organ_Options['home-offer-banner3-url']) ? esc_url($organ_Options['home-offer-banner3-url']) : '#' ?>" title="<?php esc_attr_e('link', 'organ'); ?>">
            <img alt="<?php esc_attr_e('offer banner3', 'organ'); ?>" src="<?php echo esc_url($organ_Options['home-offer-banner3']['url']); ?>">
          </a>
        </div>
        <?php endif; ?>
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
                      <div class="feature-box red_bg">
                        <span class="icon-globe-alt"></span>
                        <div class="content">
                          <h3><?php echo wp_specialchars_decode($organ_Options['header_shipping_banner']); ?></h3>
                        </div>
                      </div>
                      <?php endif; ?>
                  </li>
                     <li>
                       <?php if (!empty($organ_Options['header_customer_support_banner'])) : ?>
                      <div class="feature-box yellow_bg">
                        <span class="icon-support"></span>
                        <div class="content">
                          <h3><?php echo wp_specialchars_decode($organ_Options['header_customer_support_banner']); ?></h3>
                        </div>
                      </div>
                       <?php endif; ?>
                    </li>
                   <li>
                    <?php if (!empty($organ_Options['header_moneyback_banner'])) : ?>
                      <div class="feature-box brown_bg"> 
                        <span class="icon-share-alt"></span>                        
                        <div class="content">
                          <h3><?php echo wp_specialchars_decode($organ_Options['header_moneyback_banner']); ?></h3>
                        </div>
                      </div>
                      <?php endif; ?>
                    </li>
                   <!-- <li class="last">
                     <?php //if (!empty($organ_Options['header_returnservice_banner'])) : ?>
                    <div class="feature-box return-policy">
                      <div class="icon-return"></div>
                      <div class="content"><?php //echo wp_specialchars_decode($organ_Options['header_returnservice_banner']); ?></div>
                    </div>
                    <?php //endif; ?>
                  </li>
                    -->  
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
    global $organ_Options,$organcount_loop;
    $organcount_loop=1;
    if (isset($organ_Options['enable_home_featured_products']) && !empty($organ_Options['enable_home_featured_products'])) {
        ?>
        <ul class="pdt-list products-grid zoomOut play">

        
                <?php
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => $organ_Options['featured_per_page'],
                    'tax_query' => array(
                         array(
                             'taxonomy' => 'product_visibility',
                             'field'    => 'name',
                             'terms'    => 'featured',
                             'operator' => 'IN',
                         ),
                    )                  
                    
                  
                );
                $loop = new WP_Query($args);
                if ($loop->have_posts()) {
                    while ($loop->have_posts()) : $loop->the_post();
                        //tmOrgan_featured_template();
                        tmOrgan_productitem_template();
                        $organcount_loop++;
                    endwhile;
                } else {
                    esc_attr_e('No products found','organ');
                }

                wp_reset_postdata();
                ?>
    
        </ul>
    <?php
    }
}
}


if ( ! function_exists ( 'tmOrgan_bestseller_products' ) ) {
function tmOrgan_bestseller_products()
{
   global $organ_Options;

if (isset($organ_Options['enable_home_bestseller_products']) && !empty($organ_Options['enable_home_bestseller_products'])) { 
  ?>

<section class="featured-pro container wow bounceInUp animated">
   <div class="slider-items-products container">
      <div class="new_title center">
        <h2><?php esc_attr_e('Top Products ', 'organ'); ?></h2>
        <div class="starSeparator"></div>
      </div>


      <div id="featured-slider" class="product-flexslider hidden-buttons">
        <div class="slider-items slider-width-col4 products-grid">


       <?php 

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
              //echo "Last SQL-Query: {$loop->request}";exit;
                  if ( $loop->have_posts() ) {
                  while ( $loop->have_posts() ) : $loop->the_post();                  
                  tmOrgan_bestseller_products_template();
                 
                  endwhile;
                  } else {
                  esc_attr_e( 'No products found', 'organ' );
                  }

                 wp_reset_postdata();
                             
                             
?>

            </div>
          </div>          
</section>

 <?php  } ?>
<?php 

}
}


if ( ! function_exists ( 'tmOrgan_bestseller_products_template' ) ) {
function tmOrgan_bestseller_products_template()
{
   
  $TmOrgan = new TmOrgan();
  global $product, $yith_wcwl,$post;
    $imageUrl = wc_placeholder_img_src();
   if (has_post_thumbnail())
      $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'organ-product-size-large');
      
       $product_type = $product->get_type();
            
             
              $sales_price_date_to='';
              $product_type = $product->get_type();

               $hotdeal=get_post_meta($post->ID,'hotdeal_on_home',true);
              $sales_price_to='';
              if(!empty($hotdeal) && $hotdeal!=='no')
              { 
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
                $curdate=date("m/d/y h:i:s A");  
            
               if(!empty($sales_price_to))
               {
                $sales_price_date_to = date("Y/m/d", $sales_price_to);
               } 
               else{
                $sales_price_date_to='';
              } 
            }
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
                       <div class="sale-label sale-top-right">
                         <?php esc_attr_e('Sale', 'organ'); ?>
                       </div>
                      <?php endif; ?>

                  <?php if(!empty($hotdeal) && !empty($sales_price_to))
                    {?>
                       <div class="box-timer">
                          <div class="countbox_2 timer-grid"  data-time="<?php echo esc_html($sales_price_date_to) ;?>">
                          </div>
                       </div>

                  <?php }?>


          <div class="actions">

                          <div class="quick-view-btn">

                            <?php if (class_exists('YITH_WCQV_Frontend')) { ?>
                                     
                                           <a class="detail-bnt yith-wcqv-button link-quickview" 
                                           data-product_id="<?php echo esc_html($product->get_id());?>"></a>
                                    
                            <?php } ?>
                          </div>
                            
                          <div class="link-wishlist">
                            <?php if (isset($yith_wcwl) && is_object($yith_wcwl)) {

                                     $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'class="link-wishlist"' : 'class="link-wishlist"';
                                    ?>
                                      <a title="<?php esc_attr_e('Add to Wishlist','organ');?>" href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>"  data-product-id="<?php echo esc_html($product->get_id()); ?>" data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>></a> 
                              
                            <?php } ?>
                          </div>
                          <div class="link-compare">
                            
                            <?php if (class_exists('YITH_Woocompare_Frontend')) {
                                           $mgk_yith_cmp = new YITH_Woocompare_Frontend; ?>

                                        <a title="<?php esc_attr_e('Add to Compare','organ');?>" href="<?php echo esc_url($mgk_yith_cmp->add_product_url($product->get_id())); ?>" class="link-compare add_to_compare compare " data-product_id="<?php echo esc_html($product->get_id()); ?>"></a>
                               
                            <?php } ?> 
                          </div>
                          
                          <div class="add_cart">
                            <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?> 
                          </div> 
			  
			  </div>			
 
                          <div class="rating">
                             <div class="ratings">
                               <div class="rating-box">
                                <?php $average = $product->get_average_rating(); ?>
                                  <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"> </div>
                                </div>
                              </div>
                          </div>
                      
                    </div>
                  </div>

   <div class="item-info">
     <div class="info-inner">

        <div class="item-title"> 
          <a href="<?php the_permalink(); ?>"
              title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a> 
        </div>
                      
        <div class="item-content">
         

          <div class="item-price">
            <div class="price-box">
                 <?php echo wp_specialchars_decode($product->get_price_html()); ?>
            </div>    
          </div>
            
        
        
       </div>
    </div>
  </div>
</div>
</div>




<?php

}
}



if ( ! function_exists ( 'tmOrgan_product_tabs' ) ) {
function tmOrgan_product_tabs()
{
    global $organ_Options;
    ?>

<div class="container">
    <div class="row">
      <div class="products-grid">
        <div class="col-md-12">
          <div class="std">
            <div class="home-tabs">
              <div class="producttabs">
                <div id="thm_producttabs1" class="thm-producttabs"> 
                  
                  <div class="thm-pdt-container"> 
                  
                    <div class="thm-pdt-nav">
                      <ul class="pdt-nav">
                        
                        <?php 
                        if (isset($organ_Options['enable_home_new_products']) && !empty($organ_Options['enable_home_new_products'])) { ?>


                        <li class="item-nav <?php if (!$organ_Options['enable_home_recommended_products'] ) {echo' tab-loaded tab-nav-actived';} ?>" data-type="order" data-catid="" data-orderby="best_sales" data-href="pdt_best_sales"><span class="title-navi"><?php esc_attr_e('New Arrival', 'organ'); ?></span></li>

                        <?php }

                        if (isset($organ_Options['enable_home_recommended_products']) && !empty($organ_Options['enable_home_recommended_products'])) { ?>

                        <li class="item-nav tab-loaded tab-nav-actived" data-type="order" data-catid="" data-orderby="new_arrivals" data-href="pdt_new_arrivals"><span class="title-navi"><?php esc_attr_e('Recommended', 'organ'); ?></span></li>

                         <?php }
                         if (isset($organ_Options['enable_home_featured_products']) && !empty($organ_Options['enable_home_featured_products'])) {   ?>

                        <li class="item-nav <?php if (!$organ_Options['enable_home_new_products'] && !$organ_Options['enable_home_recommended_products']) {echo' tab-loaded tab-nav-actived';} ?>" data-type="order" data-catid="" data-orderby="featured" data-href="pdt_featured"><span class="title-navi"><?php esc_attr_e('Featured', 'organ'); ?></span></li>

                        <?php } ?>

                      </ul>
                    </div>

                    <div class="thm-pdt-content wide-5">

                      <?php if (isset($organ_Options['enable_home_new_products']) && !empty($organ_Options['enable_home_new_products'])) { ?>

                         <div class="pdt-content is-loaded pdt_best_sales is-loaded <?php if (!$organ_Options['enable_home_recommended_products'] ) {echo' tab-content-actived';} ?>">                            
                           <?php tmOrgan_new_products(); ?>
                         </div>

                       <?php } ?>
                  
                      <?php if (isset($organ_Options['enable_home_recommended_products']) && !empty($organ_Options['enable_home_recommended_products'])) { ?>

                           <div class="pdt-content pdt_new_arrivals is-loaded  tab-content-actived">                        
                              <?php tmOrgan_recommended_products(); ?>
                          </div>

                       <?php } ?>
                  
                      <?php if (isset($organ_Options['enable_home_featured_products']) && !empty($organ_Options['enable_home_featured_products'])) { ?>
                      
                            <div class="pdt-content pdt_featured is-loaded <?php if (!$organ_Options['enable_home_new_products'] && !$organ_Options['enable_home_recommended_products']) {echo' tab-content-actived';} ?>">
                              <?php tmOrgan_featured_products(); ?>
                           </div>
                      
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
}
}


if ( ! function_exists ( 'tmOrgan_recommended_products' ) ) {
function tmOrgan_recommended_products()
{
   global $organ_Options,$organcount_loop;
   $organcount_loop=1;
  ?>
 <ul class="pdt-list products-grid zoomOut play">
                
                <?php
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'meta_key' => 'recommended',                 
                    'posts_per_page' => $organ_Options['recommended_products_per_page']
                  
                );
                $loop = new WP_Query($args);
                if ($loop->have_posts()) {
                    while ($loop->have_posts()) : $loop->the_post();
                        tmOrgan_productitem_template();
                        $organcount_loop++;
                    endwhile;
                } else {
                    esc_attr_e('No products found','organ');
                }

                wp_reset_postdata();
                ?>
</ul>
<?php 

}
}


if ( ! function_exists ( 'tmOrgan_productitem_template' ) ) {
function tmOrgan_productitem_template()
{
  
  $TmOrgan = new TmOrgan();


  global $product, $yith_wcwl,$post;
  global $organ_loop_class,$organcount_loop;
   
   $imageUrl = wc_placeholder_img_src();
   if (has_post_thumbnail())
      $imageUrl =  wp_get_attachment_image_src(get_post_thumbnail_id(),'tmOrgan-product-size-large');

   if($organcount_loop%4==1){ $organ_loop_class='wide-first'; }
   elseif($organcount_loop%4==0){$organ_loop_class='last'; } 
   else{$organ_loop_class=''; } 

   ?>


<li class="item item-animate <?php echo esc_attr($organ_loop_class);?>">
  <div class="item-inner">
      <div class="item-img">
          <div class="item-img-info">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>" class="product-image">
                        <figure class="img-responsive">
                        <img alt="<?php echo esc_html($post->post_title); ?>" src="<?php echo esc_url($imageUrl[0]); ?>">
                         </figure>
                       </a>

                       <?php if ($product->is_on_sale()) : ?>
                         <div class="new-label new-top-left">
                          <?php esc_attr_e('Sale', 'organ'); ?>
                         </div>
                       <?php endif; ?>

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
                            <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Wishlist', 'organ'); ?>" data-product-id="<?php echo esc_html($product->get_id()); ?>" data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                                ><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a>
                          </div>

                      <?php } ?>


                      <?php if (class_exists('YITH_Woocompare_Frontend')) {
                             $mgk_yith_cmp = new YITH_Woocompare_Frontend; ?> 

                            <div class="link-compare">
                              <a href="<?php echo esc_url($mgk_yith_cmp->add_product_url($product->get_id())); ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Compare', 'organ'); ?>" class="compare  add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); 
                              ?></span></a>
                             </div>

                      <?php  } ?> 
                    <div class="add_cart">
                    <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
                    </div>
              </div>


                <div class="rating">
                     <div class="ratings">
                        <div class="rating-box">
                          <?php $average = $product->get_average_rating(); ?>
                            <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"> 
                            </div>
                        </div>
                     </div>
                  </div>
                </div>
             </div>
            <div class="item-info">
              <div class="info-inner">
                  <div class="item-title">
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($post->post_title); ?>"> <?php echo esc_html($post->post_title); ?> </a> 
                  </div>
                  <div class="item-content">
                    <div class="item-price">
                      <div class="price-box">
                        <span class="regular-price"> 
                            <?php echo wp_specialchars_decode($product->get_price_html()); ?>
                        </span>
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


if ( ! function_exists ( 'tmOrgan_new_products' ) ) {
function tmOrgan_new_products()
{
   global $organ_Options,$organcount_loop;
   $organcount_loop=1;
  if (isset($organ_Options['enable_home_new_products']) && !empty($organ_Options['enable_home_new_products'])) { ?>


    <ul class="pdt-list products-grid zoomOut play">
                      
                <?php
                $args = array(
                              'post_type'       => 'product',
                              'post_status'       => 'publish',
                              'ignore_sticky_posts'   => 1,
                              'posts_per_page' => $organ_Options['new_products_per_page'],      
                              'orderby' => 'date',
                              'order' => 'DESC',
                              
                              );
                $loop = new WP_Query($args);

                if ($loop->have_posts()) {
                    
                    while ($loop->have_posts()) : $loop->the_post();
                        //tmOrgan_new_products_template();
                        tmOrgan_productitem_template();
                        $organcount_loop++;
                    endwhile;
                } else {
                    esc_attr_e('No products found','organ');
                }

                wp_reset_postdata();?>
    </ul>
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
        <div class="latest-blog">
        <div class="container">
          <div class="new_title center">
            <h1><?php esc_attr_e('Latest Blog', 'organ'); ?></h1>
            <div class="starSeparator"></div>
          </div>  
      
 <div class="row">
       
        <?php

        $args = array('posts_per_page' => 2, 'post__not_in' => get_option('sticky_posts'));
        $the_query = new WP_Query($args);
           $i=1;  
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post(); ?>
            
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">  
                  <div class="blog_post">
                     <div class="thumbnail">  
                      <h2>
                        <a href="<?php the_permalink(); ?>"><?php esc_html(the_title()); ?>
                     </a>
                      </h2>
                      <div class="featured-img">
                        <span class="gradient-overlay"></span>
                        <a href="<?php the_permalink(); ?>">
                          <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail'); ?>
                         <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>">
                        </a>
          
                      </div>                          
                     </div>

                    <div class="entry-meta">
                     
                      <a href="#">
                        <span class="author-avatar byline"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>By John Doe</span> <span class="timestamp"><?php esc_html(the_time('F d, Y')); ?></span>
                      </a>
           
                    </div>
                    <?php the_excerpt(); ?>                   
                    <a class="readmore" href="<?php the_permalink(); ?>"><?php esc_attr_e('Continue Reading','organ'); ?></a> 

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
    <div class="brand-logo">
    <div class="container">  
    <div class="slider-items-products">
      <div id="brand-logo-slider" class="product-flexslider hidden-buttons">
      <div class="slider-items slider-width-col6"> 
        <?php
        foreach ($organ_Options['all-company-logos'] as $_logo) : ?>
        <!-- Item -->

         <div class="item"> 

          <a href="<?php echo esc_url($_logo['url']); ?>" target="_blank"> <img
                        src="<?php echo esc_url($_logo['image']); ?>" 
                        alt="<?php echo esc_attr($_logo['title']); ?>"> </a>
        
        </div>               
        
        <!-- End Item -->
        <?php endforeach; ?>
      </div>
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
    
   <?php echo wp_specialchars_decode($organ_Options['footer_middle']);?>
            
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
        <img alt="<?php echo esc_attr($post->post_title); ?>" class="img-responsive" src="<?php echo esc_url($imageUrl[0]); ?>">
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
<li class="item">
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
</li>
<?php
}
}

if ( ! function_exists ( 'tmOrgan_hotdeal_product' ) ) {
function tmOrgan_hotdeal_product()
{
   global $organ_Options;
  
  
       $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'meta_key' => 'hotdeal_on_home',
            'meta_query'     => array(
          
              array(
                    'relation' => 'OR',
                    array( // Simple products type
                        'key'           => '_sale_price',
                        'value'         => 0,
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                  
                    array( // Variable products type
                        'key'           => '_min_variation_sale_price',
                        'value'         => 0,
                        'compare'       => '>',
                        'type'          => 'numeric'
                    )
                    )
                 
                )
        );

        $loop = new WP_Query( $args );
        //echo "LOG: {$loop->request}"; exit;
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) : $loop->the_post();
              tmOrgan_hotdeal_template();
            
            endwhile;
        } else {
        esc_attr_e( 'No products found', 'organ' );
        }
        wp_reset_postdata();
  
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
               if(!empty($sales_price_to))
               {
               $sales_price_date_to = date("Y/m/d", $sales_price_to);
               } 
               else{
                $sales_price_date_to='';
               } 
               $curdate=date("m/d/y h:i:s A");
                         
?> 
         
           <div class="offer-slider parallax parallax-2">
              <div class="container">
               
                <h2> <?php esc_attr_e('Deals of the day', 'organ'); ?></h2>
                <div class="starSeparator"></div>
                <p><?php echo esc_html($post->post_title); ?></p>
                <div class="box-timer">
                      <div class="countbox_1 timer-grid" data-time="<?php echo esc_html($sales_price_date_to) ;?>"></div>
                </div>
                <a href="#" class="shop-now">Shop Now</a>     

              </div>
            </div>
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
                            <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )  ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Wishlist', 'organ'); ?>" data-product-id="<?php echo esc_html($product->get_id()); ?>" data-product-type="<?php echo esc_html($product->get_type()); ?>" <?php echo wp_specialchars_decode($classes); ?>
                                ><span><?php esc_attr_e('Add to Wishlist', 'organ'); ?></span></a>
                          </div>

                      <?php } ?>


                      <?php if (class_exists('YITH_Woocompare_Frontend')) {
                             $mgk_yith_cmp = new YITH_Woocompare_Frontend; ?> 

                            <div class="link-compare">
                              <a href="<?php echo esc_url($mgk_yith_cmp->add_product_url($product->get_id())); ?>" data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e('Compare', 'organ'); ?>" class="compare  add_to_compare" data-product_id="<?php echo esc_html($product->get_id()); ?>"><span><?php esc_attr_e('Add to Compare', 'organ'); 
                              ?></span></a>
                             </div>

                      <?php  } ?> 
                    <div class="add_cart">
                    <?php $TmOrgan->tmOrgan_woocommerce_product_add_to_cart_text() ;?>
                    </div>
              </div>
              <div class="rating">
                     <div class="ratings">
                        <div class="rating-box">
                          <?php $average = $product->get_average_rating(); ?>
                            <div style="width:<?php echo esc_html(($average / 5) * 100); ?>%" class="rating"> 
                            </div>
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

if ( ! function_exists ( 'tmOrgan_welcomemsg' ) ) {
function tmOrgan_welcomemsg()
{ 
     global $organ_Options;

       if (isset($organ_Options['enable_welcome_msg']) && $organ_Options['enable_welcome_msg'])
             {
           if (is_user_logged_in()) {
            global $current_user;
      
              if(isset($organ_Options['welcome_msg'])) {
            echo esc_attr_e('You are logged in as', 'organ'). '   <b>'. esc_attr($current_user->display_name) .'</b>';
          }
          }
          else{
            if(isset($organ_Options['welcome_msg']) && ($organ_Options['welcome_msg']!='')){
            echo wp_specialchars_decode($organ_Options['welcome_msg']);
            }
          } 
        }
}
}

function tmOrgan_mini_cartv2()
{
    global $woocommerce;
    ?>

<div class="mini-cart">
   <div  class="basket">
      <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>">
        <?php  esc_attr_e('My Cart','organ'); ?> 
        <span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?> </span>
      </a>
   </div>

      <div class="top-cart-content arrow_box">
         <div class="block-subtitle">
            <div class="top-subtotal"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?> <?php  esc_attr_e('items','organ'); ?>, <span class="price"><?php echo wp_specialchars_decode(WC()->cart->get_cart_subtotal()); ?></span> </div>
         </div>
         <?php if (sizeof(WC()->cart->get_cart()) > 0) : $i = 0; ?>
         <ul id="cart-sidebar" class="mini-products-list">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
            <?php
               $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
               $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
               
               if ($_product && $_product->exists() && $cart_item['quantity'] > 0
                   && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)
               ) :
               
                   $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
                   $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(array(60, 60)), $cart_item, $cart_item_key);
                   $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                   $cnt = sizeof(WC()->cart->get_cart());
                   $rowstatus = $cnt % 2 ? 'odd' : 'even';
                   ?>
            <li class="item <?php echo esc_html($rowstatus); ?> <?php if ($cnt - 1 == $i) { ?>last<?php } ?>">
              <div class="item-inner">
               <a class="product-image"
                  href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>"  title="<?php echo esc_html($product_name); ?>"> <?php echo str_replace(array('http:', 'https:'), '', wp_specialchars_decode($thumbnail)); ?> </a>
             

                  <div class="product-details">
                       <div class="access">
                     <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                        title="<?php esc_attr_e('Remove This Item','organ') ;?>" onClick="" class="btn-remove1"><?php esc_attr_e('Remove','organ') ;?></a> <a class="btn-edit" title="<?php esc_attr_e('Edit item','organ') ;?>"
                        href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>"><i
                        class="icon-pencil"></i><span
                        class="hidden"><?php esc_attr_e('Edit item','organ') ;?></span></a>
                         </div>
                      <strong><?php echo esc_html($cart_item['quantity']); ?>
                  </strong> x <span class="price"><?php echo wp_specialchars_decode($product_price); ?></span>
                     <p class="product-name"><a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>"
                        title="<?php echo esc_html($product_name); ?>"><?php echo esc_html($product_name); ?></a> </p>
                  </div>
                  <?php echo wp_specialchars_decode(wc_get_formatted_cart_item_data($cart_item)); ?>
                     </div>
              
            </li>
            <?php endif; ?>
            <?php $i++; endforeach; ?>
         </ul>    
         <div class="actions">
            <button class="btn-checkout" type="button"
               onClick="window.location.assign('<?php echo esc_js(wc_get_checkout_url()); ?>')"><span><?php esc_attr_e('Checkout','organ') ;?></span> </button>          
         </div>
         <?php else:?>
         <p class="a-center noitem">
            <?php esc_attr_e('Sorry, nothing in cart.', 'organ');?>
         </p>
         <?php endif; ?>
      </div>
   </div>

<?php
}
 