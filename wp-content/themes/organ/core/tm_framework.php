<?php 
require_once(TMORGAN_THEME_PATH . '/includes/layout.php');
require_once(TMORGAN_THEME_PATH . '/includes/tm_menu.php');
require_once(TMORGAN_THEME_PATH .'/core/social_share.php');


 /* Include theme variation functions */  
 if ( ! function_exists ( 'tmOrgan_theme_layouts' ) ) {
 function tmOrgan_theme_layouts()
 {
 global $organ_Options;   
 if (isset($organ_Options['theme_layout']) && !empty($organ_Options['theme_layout'])) { 
require_once (get_template_directory(). '/skins/' . $organ_Options['theme_layout'] . '/functions.php');   
} else {
require_once (get_template_directory(). '/skins/default/functions.php');   
}
 }
}

// call theme skins function
tmOrgan_theme_layouts();


 /* Include theme variation header */   
 if ( ! function_exists ( 'tmOrgan_theme_header' ) ) {
   function tmOrgan_theme_header()
 {
 global $organ_Options;   
  if (isset($organ_Options['theme_layout']) && !empty($organ_Options['theme_layout'])) {
load_template(get_template_directory() . '/skins/' . $organ_Options['theme_layout'] . '/header.php', true);
} else {
load_template(get_template_directory() . '/skins/default/header.php', true);
}
 }
}

/* Include theme variation homepage */ 
if ( ! function_exists ( 'tmOrgan_theme_homepage' ) ) {
  function tmOrgan_theme_homepage()
 {  
 global $organ_Options;  

 if (isset($organ_Options['theme_layout']) && !empty($organ_Options['theme_layout'])) { 
load_template(get_template_directory() . '/skins/' . $organ_Options['theme_layout'] . '/homepage.php', true);
} else {
load_template(get_template_directory() . '/skins/default/homepage.php', true);
}
 }
}

 /* Include theme variation footer */
if ( ! function_exists ( 'tmOrgan_theme_footer' ) ) {  
function tmOrgan_theme_footer()
{
     
 global $organ_Options;   
  if (isset($organ_Options['theme_layout']) && !empty($organ_Options['theme_layout'])) {
load_template(get_template_directory() . '/skins/' . $organ_Options['theme_layout'] . '/footer.php', true);
} else {
load_template(get_template_directory() . '/skins/default/footer.php', true);
} 
}
}

if ( ! function_exists ( 'tmOrgan_simple_product_link' ) ) {  
function tmOrgan_simple_product_link()
{
  global $product,$class;
  $product_type = $product->get_type();
  $product_id=$product->get_id();
  if($product->get_price()=='')
  { ?>
<a class="button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")' >
    <span><?php echo esc_html($product->add_to_cart_text()); ?> </span>
    </a>
<?php  }
  else{
  ?>
<a class="single_add_to_cart_button add_to_cart_button  product_type_simple ajax_add_to_cart button btn-cart" title='<?php echo esc_html($product->add_to_cart_text()); ?>' data-quantity="1" data-product_id="<?php echo esc_attr($product->get_id()); ?>"
      href='<?php echo esc_url($product->add_to_cart_url()); ?>'>
    <span><?php echo esc_html($product->add_to_cart_text()); ?> </span>
    </a>
<?php
}
}
}



if ( ! function_exists ( 'tmOrgan_body_classes' ) ) {
function tmOrgan_body_classes( $classes ) 
{
  // Adds a class to body.
global $organ_Options; 

if ((is_front_page() && is_home()) || is_front_page())
{
  $classes[]='cms-index-index cms-home-page';
}
else
{
  $classes[]='cms-index-index inner-page';
}

  return $classes;
}
}

add_filter( 'body_class', 'tmOrgan_body_classes');
 
?>