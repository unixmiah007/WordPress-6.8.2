<?php

 /*Define Contants */
define('TMORGAN_ORGAN_VERSION', '1.0');  
define('TMORGAN_THEME_PATH', get_template_directory());
define('TMORGAN_THEME_URI', get_template_directory_uri());
define('TMORGAN_THEME_STYLE_URI', get_stylesheet_directory_uri());
define('TMORGAN_THEME_LIB_PATH', get_template_directory() . '/includes/');
define('TMORGAN_THEME_NAME', 'organ');


/* Include required tgm activation */
require_once (trailingslashit( get_template_directory()). '/includes/tgm_activation/install-required.php');
require_once (trailingslashit( get_template_directory()). '/includes/reduxActivate.php');
if (file_exists(trailingslashit( get_template_directory()). '/includes/reduxConfig.php')) {
    require_once (trailingslashit( get_template_directory()). '/includes/reduxConfig.php');
}

/* Include theme variation functions */ 
require_once(TMORGAN_THEME_PATH . '/core/tm_framework.php');


if (!isset($content_width)) {
    $content_width = 800;
}



class TmOrgan {
   
  /**
  * Constructor
  */
  function __construct() {
    // Register action/filter callbacks
  
    add_action('after_setup_theme', array($this, 'tmOrgan_organ_setup'));
    add_action( 'init', array($this, 'tmOrgan_theme'));
    add_action('wp_enqueue_scripts', array($this,'tmOrgan_custom_enqueue_google_font'));
    
    add_action('admin_enqueue_scripts', array($this,'tmOrgan_admin_scripts_styles'));
    add_action('wp_enqueue_scripts', array($this,'tmOrgan_scripts_styles'));
    add_action('wp_head', array($this,'tmOrgan_apple_touch_icon'));
  
    add_action('widgets_init', array($this,'tmOrgan_widgets_init'));

    add_action('wp_head', array($this,'tmOrgan_enqueue_custom_css'));
    
    add_action('add_meta_boxes', array($this,'tmOrgan_reg_page_meta_box'));
    add_action('save_post',array($this, 'tmOrgan_save_page_layout_meta_box_values')); 
    add_action('add_meta_boxes', array($this,'tmOrgan_reg_post_meta_box'));
    add_action('save_post',array($this, 'tmOrgan_save_post_layout_meta_box_values')); 
 
    }

function tmOrgan_theme() {

global $organ_Options;

}

  /**
  * Theme setup
  */
  function tmOrgan_organ_setup() {   
    global $organ_Options;
     load_theme_textdomain('organ', get_template_directory() . '/languages');
     load_theme_textdomain('woocommerce', get_template_directory() . '/languages');

      // Add default posts and comments RSS feed links to head.
      add_theme_support('automatic-feed-links');
      add_theme_support('title-tag');
      add_theme_support('post-thumbnails');
      add_image_size('tmOrgan-featured_preview', 55, 55, true);
      add_image_size('tmOrgan-article-home-large',1140, 450, true);
      add_image_size('tmOrgan-article-home-small', 335, 150, true);
      add_image_size('tmOrgan-article-home-medium', 335, 155, true); 
      add_image_size('tmOrgan-product-size-large',214, 214, true);      
          
         
    add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );
    
    add_theme_support( 'post-formats', array(
      'aside','video','audio'
    ) );
    
    // Setup the WordPress core custom background feature.
    $default_color = trim( 'ffffff', '#' );
    $default_text_color = trim( '333333', '#' );
    
    add_theme_support( 'custom-background', apply_filters( 'tmOrgan_custom_background_args', array(
      'default-color'      => $default_color,
      'default-attachment' => 'fixed',
    ) ) );
    
    add_theme_support( 'custom-header', apply_filters( 'tmOrgan_custom_header_args', array(
      'default-text-color'     => $default_text_color,
      'width'                  => 1170,
      'height'                 => 450,
      
    ) ) );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
     */
    add_editor_style('css/editor-style.css' );
    
    /*
    * Edge WooCommerce Declaration: WooCommerce Support and settings
    */    
    
      if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        require_once(TMORGAN_THEME_PATH. '/woo_function.php');
        // Disable WooCommerce Default CSS if set
        if (!empty($organ_Options['woocommerce_disable_woo_css'])) {
          add_filter('woocommerce_enqueue_styles', '__return_false');
          wp_enqueue_style('woocommerce_enqueue_styles', get_template_directory_uri() . '/woocommerce.css');
        }
      }
 
    // Register navigation menus
    
    register_nav_menus(
      array(
       'toplinks' => esc_html__( 'Top menu', 'organ' ),
       'main_menu' => esc_html__( 'Main menu', 'organ' ),
       'menu_left' => esc_html__( 'Menu Left', 'organ' ),
       'menu_right' => esc_html__( 'Menu Right', 'organ' )
       
      ));
    
  }
    

function tmOrgan_fonts_url() {
  global $organ_Options;
  $fonts_url = '';
  $fonts     = array();
  $subsets   = 'latin,latin-ext';
 
 if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')
{
     
    if ( 'off' !== _x( 'on', 'Raleway: on or off', 'organ' ) ) {
         $fonts[]='Raleway:400,100,200,300,500,600,700,800,900';
    }
    
    if ( 'off' !== _x( 'on', 'Montserrat: on or off', 'organ' ) ) {
       $fonts[]='Montserrat:400,700';
    }
    
    if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'organ' ) ) {
         $fonts[]='Open Sans:400,300italic,300,600,600italic,400italic,700,700italic,800,800italic';
    }    	
    
    if ( 'off' !== _x( 'on', 'Lora: on or off', 'organ' ) ) {
        $fonts[]='Lora:400,700,400italic';
    }
   
} else {

   if ( 'off' !== _x( 'on', 'Source Sans: on or off', 'organ' ) ) {
       $fonts[]='Source Sans Pro:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic';
    }
  

 
    if ( 'off' !== _x( 'on', 'Montserrat: on or off', 'organ' ) ) {
       $fonts[]='Montserrat:400,700';
    }
    
 
    if ( 'off' !== _x( 'on', 'Roboto: on or off', 'organ' ) ) {
        $fonts[]='Roboto:400,500,300,700,900';
    }
    
 
    if ( 'off' !== _x( 'on', 'Raleway: on or off', 'organ' ) ) {
         $fonts[]='Raleway:400,100,200,300,600,500,700,800,900';
    }
}

    if ( $fonts ) {
    $fonts_url = add_query_arg( array(
      'family' => urlencode( implode( '|', $fonts ) ),
      'subset' => urlencode( $subsets ),
    ), 'https://fonts.googleapis.com/css' );
  }
    return $fonts_url;
}
/*
Enqueue scripts and styles.
*/
function tmOrgan_custom_enqueue_google_font() {

  wp_enqueue_style( 'tmOrgan-Fonts', $this->tmOrgan_fonts_url() , array(), '1.0.0' );
}


  function tmOrgan_admin_scripts_styles()
  {  
      wp_enqueue_script('tmOrgan-admin', TMORGAN_THEME_URI . '/js/admin_menu.js', array(), '', true);
  }

function tmOrgan_scripts_styles()
{
    global $organ_Options,$yith_wcwl;
    /*JavaScript for threaded Comments when needed*/
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }


    //wp_enqueue_style('bootstrap.min-css', TMORGAN_THEME_URI . '/css/bootstrap.min.css', array(), '');   
   if (isset($organ_Options['theme_layout'])  && !empty($organ_Options['theme_layout']))
{
wp_enqueue_style('bootstrap', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/bootstrap.min.css', array(), '');   
}else
{
wp_enqueue_style('bootstrap', TMORGAN_THEME_URI . '/skins/default/bootstrap.min.css', array(), '');   
} 
   if(isset($organ_Options['opt-animation']) && !empty($organ_Options['opt-animation']))
   {
    wp_enqueue_style('animate', TMORGAN_THEME_URI . '/css/animate.css', array(), '');
   }
  wp_enqueue_style('font-awesome', TMORGAN_THEME_URI . '/css/font-awesome.css', array(), '');

  wp_enqueue_style('owl.carousel', TMORGAN_THEME_URI . '/css/owl.carousel.css', array(), '');

  wp_enqueue_style('owl.theme', TMORGAN_THEME_URI . '/css/owl.theme.css', array(), '');
  
  wp_enqueue_style('flexslider', TMORGAN_THEME_URI . '/css/flexslider.css', array(), '');

   wp_enqueue_style('bxslider', TMORGAN_THEME_URI . '/css/jquery.bxslider.css', array(), '');
  
     
  wp_enqueue_style('tmOrgan-style', TMORGAN_THEME_URI . '/style.css', array(), '');    

  if (isset($organ_Options['theme_layout']) && !empty($organ_Options['theme_layout']))
  {
     wp_enqueue_style( 'tmOrgan-blog', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/blogs.css', array(), '');
     wp_enqueue_style( 'tmOrgan-revslider', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/revslider.css', array(), '');
     wp_enqueue_style('tmOrgan-layout', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/style.css', array(), '');
     wp_enqueue_style('tmOrgan-responsive', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/responsive.css', array(), '');
     wp_enqueue_style( 'tmOrgan-tm_menu', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/tm_menu.css', array(), '');  
     wp_enqueue_style('jquery.mobile-menu-js', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/jquery.mobile-menu.css', array(), '');
     if(isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')     
     {
        wp_enqueue_style( 'tmOrgan-simple-line-icons', TMORGAN_THEME_URI . '/skins/' . $organ_Options['theme_layout'] . '/simple-line-icons.css', array(), '');        
     }
  } else {
     wp_enqueue_style( 'tmOrgan-blog', TMORGAN_THEME_URI . '/skins/default/blogs.css', array(), '');
     wp_enqueue_style( 'tmOrgan-revslider', TMORGAN_THEME_URI . '/skins/default/revslider.css', array(), '');
     wp_enqueue_style('tmOrgan-layout', TMORGAN_THEME_URI . '/skins/default/style.css', array(), '');
     wp_enqueue_style('tmOrgan-responsive', TMORGAN_THEME_URI . '/skins/default/responsive.css', array(), '');
     wp_enqueue_style( 'tmOrgan-tm_menu', TMORGAN_THEME_URI . '/skins/default/tm_menu.css', array(), '');  
     wp_enqueue_style('jquery.mobile-menu-js', TMORGAN_THEME_URI . '/skins/default/jquery.mobile-menu.css', array(), '');

  }   
    
 //theme js

    wp_enqueue_script('bootstrap.min', TMORGAN_THEME_URI . '/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.cookie', TMORGAN_THEME_URI . '/js/jquery.cookie.min.js', array('jquery'), '', true);
     wp_enqueue_script('countdown',TMORGAN_THEME_URI . '/js/countdown.js', array('jquery'), '', true);
    wp_enqueue_script('parallax',TMORGAN_THEME_URI . '/js/parallax.js', array('jquery'), '', true);
     wp_enqueue_script('tmOrgan-common',TMORGAN_THEME_URI . '/js/common.js', array('jquery'), '', true);

       if (isset($yith_wcwl) && is_object($yith_wcwl)) { 
    
      wp_localize_script( 'tmOrgan-common', 'js_oragan_comman', array(
        
        'TM_ADD_TO_WISHLIST_SUCCESS_TEXT' => esc_html__('Product successfully added to wishlist','organ').' <a href="'.esc_url($yith_wcwl->get_wishlist_url()).'">'.esc_html__('Browse Wishlist.','organ').'</a>' ,
        'TM_ADD_TO_WISHLIST_EXISTS_TEXT' => esc_html__('The product is already in the wishlist!','organ').' <a href="'.esc_url($yith_wcwl->get_wishlist_url()).'">'.esc_html__('Browse Wishlist.','organ').'</a>' ,
        'IMAGEURL' => esc_url(TMORGAN_THEME_URI).'/images',
    
        'SITEURL' =>  esc_url(site_url())

      ) );


        }
    else{
        wp_localize_script( 'tmOrgan-common', 'js_oragan_comman', array(
        'TM_ADD_TO_WISHLIST_SUCCESS_TEXT'=>"",
        'TM_ADD_TO_WISHLIST_EXISTS_TEXT' =>"",
        'IMAGEURL' => esc_url(TMORGAN_THEME_URI).'/images',         
        'SITEURL' =>  esc_url(site_url())      
        
        
      ) );


      }
 



     if (isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')
    {
      wp_enqueue_script('revolution', TMORGAN_THEME_URI . '/js/revolution-slider.js', array('jquery'), '', true);
      wp_enqueue_script('revolution-exe', TMORGAN_THEME_URI . '/js/revolution.extension.js', array('jquery'), '', true);  
    } else {
      wp_enqueue_script('revolution', TMORGAN_THEME_URI . '/js/revslider.js', array('jquery'), '', true);  
    } 
    
    
    wp_enqueue_script('jquery.bxslider-js', TMORGAN_THEME_URI . '/js/jquery.bxslider.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.flexslider-js', TMORGAN_THEME_URI . '/js/jquery.flexslider.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.mobile-menu-js', TMORGAN_THEME_URI . '/js/jquery.mobile-menu.min.js', array('jquery'), '', true);
    wp_enqueue_script('owl.carousel.min-js',TMORGAN_THEME_URI . '/js/owl.carousel.min.js', array('jquery'), '', true);
    wp_enqueue_script('cloud-zoom-js', TMORGAN_THEME_URI . '/js/cloud-zoom.js', array('jquery'), '', true);

     
      wp_register_script('tmOrgan-theme', TMORGAN_THEME_URI .'/js/tm_menu.js', array('jquery'), '', true );
        wp_enqueue_script('tmOrgan-theme');

            wp_localize_script( 'tmOrgan-theme', 'js_organ_vars', array(
            'ajax_url' => esc_js(admin_url( 'admin-ajax.php' )),
            'container_width' => 1160,
            'grid_layout_width' => 20           
        ) );

     
}

 
  function tmOrgan_apple_touch_icon()
  {
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(TMORGAN_THEME_URI). '/images/apple-touch-icon.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(TMORGAN_THEME_URI). '/images/apple-touch-icon57x57.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
       esc_url(TMORGAN_THEME_URI). '/images/apple-touch-icon72x72.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(TMORGAN_THEME_URI). '/images/apple-touch-icon114x114.png'
    );
    printf(
      '<link rel="apple-touch-icon" href="%s" />',
      esc_url(TMORGAN_THEME_URI). '/images/apple-touch-icon144x144.png'
    );
  }
  //register sidebar widget
  function tmOrgan_widgets_init()
  {
      register_sidebar(array(
      'name' => esc_html__('Blog Sidebar', 'organ'),
      'id' => 'sidebar-blog',
      'description' => esc_html__('Sidebar that appears on the right of Blog and Search page.', 'organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h3 class="block-title">',
      'after_title' => '</h3>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Shop Sidebar','organ'),
      'id' => 'sidebar-shop',
      'description' => esc_html__('Main sidebar that appears on the left.', 'organ'),
      'before_widget' => '<div id="%1$s" class="block %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Content Sidebar Left', 'organ'),
      'id' => 'sidebar-content-left',
      'description' => esc_html__('Additional sidebar that appears on the left.','organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Content Sidebar Right', 'organ'),
      'id' => 'sidebar-content-right',
      'description' => esc_html__('Additional sidebar that appears on the right.', 'organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<div class="block-title">',
      'after_title' => '</div>',
    ));
   
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 1','organ'),
      'id' => 'footer-sidebar-1',
      'description' => esc_html__('Appears in the footer section of the site.','organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 2', 'organ'),
      'id' => 'footer-sidebar-2',
      'description' => esc_html__('Appears in the footer section of the site.', 'organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 3', 'organ'),
      'id' => 'footer-sidebar-3',
      'description' => esc_html__('Appears in the footer section of the site.','organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 4', 'organ'),
      'id' => 'footer-sidebar-4',
      'description' => esc_html__('Appears in the footer section of the site.', 'organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));
    register_sidebar(array(
      'name' => esc_html__('Footer Widget Area 5', 'organ'),
      'id' => 'footer-sidebar-5',
      'description' => esc_html__('Appears in the footer section of the site.', 'organ'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h4>',
      'after_title' => '</h4>',
    ));

  }




  function tmOrgan_reg_page_meta_box() {
    $screens = array('page');

    foreach ($screens as $screen) {        
      add_meta_box(
          'tmOrgan_page_layout_meta_box', esc_html__('Page Layout', 'organ'), 
          array($this, 'tmOrgan_page_layout_meta_box_cb'), $screen, 'normal', 'core'
      );
    }
  }

  function tmOrgan_page_layout_meta_box_cb($post) {

    $saved_page_layout = get_post_meta($post->ID, 'tmOrgan_page_layout', true);
    
    $show_breadcrumb = get_post_meta($post->ID, 'tmOrgan_show_breadcrumb', true);
    
   if(empty($saved_page_layout)) {
      $saved_page_layout = 3;
    }
    $page_layouts = array(
      1 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-1.png',
      2 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-2.png',
      3 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-3.png',
      4 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-4.png',
    );  
    ?>
  <style type="text/css">
        input.of-radio-img-radio{display: none;}
        .tile_img_wrap{
          display: block;                
        }
        .tile_img_wrap > span > img{
          float: left;
          margin:0 5px 10px 0;
        }
        .tile_img_wrap > span > img:hover{
          cursor: pointer;
        }            
        .tile_img_wrap img.of-radio-img-selected{
          border: 3px solid #CCCCCC;
        }
         #tmOrgan_page_layout_meta_box h2 {
    margin-top: 20px;
    font-size: 1.5em;
    
     }
        #tmOrgan_page_layout_meta_box .inside h2 {
    margin-top: 20px;
    font-size: 1.5em;
    margin-bottom: 15px;
    padding: 0 0 3px;
    clear: left;
}
        
      </style>
  <?php
    echo "<input type='hidden' name='tmOrgan_page_layout_verifier' value='".wp_create_nonce('tmOrgan_7a81jjde')."' />";    
    $output = '<div class="tile_img_wrap">';
      foreach ($page_layouts as $key => $img) {
        $checked = '';
        $selectedClass = '';
        if($saved_page_layout == $key){
          $checked = 'checked="checked"';
          $selectedClass = 'of-radio-img-selected';
        }
        $output .= '<span>';
        $output .= '<input type="radio" class="checkbox of-radio-img-radio" value="' . absint($key) . '" name="tmOrgan_page_layout" ' . esc_html($checked). ' />';            
        $output .= '<img src="' . esc_url($img) . '" alt="'.esc_html__('Page Layout', 'organ').'" class="of-radio-img-img ' . esc_html($selectedClass) . '" />';
        $output .= '</span>';
            
      }    
    $output .= '</div>';
    echo wp_specialchars_decode($output);
    ?>
  <script type="text/javascript">
      jQuery(function($){            
        $(document.body).on('click','.of-radio-img-img',function(){
          $(this).parents('.tile_img_wrap').find('.of-radio-img-img').removeClass('of-radio-img-selected');
          $(this).parent().find('.of-radio-img-radio').attr('checked','checked');
          $(this).addClass('of-radio-img-selected');
        });            
    });
      
      </script>

  <h2><?php esc_attr_e('Show breadcrumb', 'organ'); ?></h2>
  <p>
    <input type="radio" name="tmOrgan_show_breadcrumb" value="1" <?php echo "checked='checked'"; ?> />
    <label><?php esc_attr_e('Yes','organ'); ?></label>
    &nbsp;
    <input type="radio" name="tmOrgan_show_breadcrumb" value="0"  <?php if($show_breadcrumb === '0'){ echo "checked='checked'"; } ?>/>
    <label><?php esc_attr_e('No', 'organ'); ?></label>
  </p>
  <?php
  }

  function tmOrgan_save_page_layout_meta_box_values($post_id){
    if (!isset($_POST['tmOrgan_page_layout_verifier']) 
        || !wp_verify_nonce($_POST['tmOrgan_page_layout_verifier'], 'tmOrgan_7a81jjde') 
        || !isset($_POST['tmOrgan_page_layout']) 
       
        )
      return $post_id;
    
    
    add_post_meta($post_id,'tmOrgan_page_layout',sanitize_text_field( $_POST['tmOrgan_page_layout']),true) or 
    update_post_meta($post_id,'tmOrgan_page_layout',sanitize_text_field( $_POST['tmOrgan_page_layout']));
    
    add_post_meta($post_id,'tmOrgan_show_breadcrumb',sanitize_text_field( $_POST['tmOrgan_show_breadcrumb']),true) or 
    update_post_meta($post_id,'tmOrgan_show_breadcrumb',sanitize_text_field( $_POST['tmOrgan_show_breadcrumb']));  
  }


  /*Register Post Meta Boxes for Blog Post Layouts*/

    function tmOrgan_reg_post_meta_box() {
    $screens = array('post');

    foreach ($screens as $screen) {        
      add_meta_box(
          'tmOrgan_post_layout_meta_box', esc_html__('Post Layout', 'organ'), 
          array($this, 'tmOrgan_post_layout_meta_box_cb'), $screen, 'normal', 'core'
      );
    }
  }

  function tmOrgan_post_layout_meta_box_cb($post) {

    $saved_post_layout = get_post_meta($post->ID, 'tmOrgan_post_layout', true);         
    if(empty($saved_post_layout))
    {
      $saved_post_layout = 2;
    }
    
    $post_layouts = array(
      1 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-1.png',
      2 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-2.png',
      3 => esc_url(TMORGAN_THEME_URI).'/images/tmOrgan_col/category-layout-3.png',
      
    );  
    ?>
  <style type="text/css">
        input.of-radio-img-radio{display: none;}
        .tile_img_wrap{
          display: block;                
        }
        .tile_img_wrap > span > img{
          float: left;
          margin:0 5px 10px 0;
        }
        .tile_img_wrap > span > img:hover{
          cursor: pointer;
        }            
        .tile_img_wrap img.of-radio-img-selected{
          border: 3px solid #CCCCCC;
        }
        .postbox-container .inside .tile_img_wrap
        {
          height:70px;
        }
        
      </style>
  <?php
    echo "<input type='hidden' name='tmOrgan_post_layout_verifier' value='".wp_create_nonce('tmOrgan_7a81jjde1')."' />";    
    $output = '<div class="tile_img_wrap">';
      foreach ($post_layouts as $key => $img) {
        $checked = '';
        $selectedClass = '';
        if($saved_post_layout == $key){
          $checked = 'checked="checked"';
          $selectedClass = 'of-radio-img-selected';
        }
        $output .= '<span>';
        $output .= '<input type="radio" class="checkbox of-radio-img-radio" value="' . absint($key) . '" name="tmOrgan_post_layout" ' . esc_html($checked). ' />';            
        $output .= '<img src="' . esc_url($img) . '" alt="'.esc_html__('Page Layout', 'organ').'" class="of-radio-img-img ' . esc_html($selectedClass) . '" />';
        $output .= '</span>';
            
      }    
    $output .= '</div>';
    echo wp_specialchars_decode($output);
    ?>
  <script type="text/javascript">
      jQuery(function($){            
        $(document.body).on('click','.of-radio-img-img',function(){
          $(this).parents('.tile_img_wrap').find('.of-radio-img-img').removeClass('of-radio-img-selected');
          $(this).parent().find('.of-radio-img-radio').attr('checked','checked');
          $(this).addClass('of-radio-img-selected');
        });            
    });
      
      </script>

  
  <?php
  }

  function tmOrgan_save_post_layout_meta_box_values($post_id){
    if (!isset($_POST['tmOrgan_post_layout_verifier']) 
        || !wp_verify_nonce($_POST['tmOrgan_post_layout_verifier'], 'tmOrgan_7a81jjde1') 
        || !isset($_POST['tmOrgan_post_layout']) 
       
        )
      return $post_id;
    
    
    add_post_meta($post_id,'tmOrgan_post_layout',sanitize_text_field($_POST['tmOrgan_post_layout']),true) or 
    update_post_meta($post_id,'tmOrgan_post_layout',sanitize_text_field($_POST['tmOrgan_post_layout']));
    
    
  }

  //custom functions 

  //search form code
  function tmOrgan_custom_search_form()
  { global $organ_Options;
  ?>
 
<form name="myform"  method="GET" action="<?php echo esc_url(home_url('/')); ?>">
         <input type="text" name="s" class="tm-search" maxlength="70" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e('Search', 'organ'); ?>">
  
    
     <?php if (class_exists('WooCommerce')) : ?>    
      <input type="hidden" value="product" name="post_type">
    <?php endif; ?>
    <button type="submit" class="search-btn-bg search-icon"><span class="glyphicon glyphicon-search"></span>&nbsp;</button>
  </form>

  <?php
  }



// page title code
function tmOrgan_page_title() {

    global  $post, $wp_query, $author,$organ_Options;

    $home = esc_html__('Home', 'organ');

  
    if ( ( ! is_home() && ! is_front_page() && ! (is_post_type_archive()) ) || is_paged() ) {

        if ( is_home() ) {
           echo wp_specialchars_decode(single_post_title('', false));

        } else if ( is_category() ) {

            echo esc_html(single_cat_title( '', false ));

        } elseif ( is_tax() ) {

            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            echo wp_specialchars_decode(esc_html( $current_term->name ));

        }  elseif ( is_day() ) {

            printf( esc_html__( 'Daily Archives: %s', 'organ' ), get_the_date() );

        } elseif ( is_month() ) {

            printf( esc_html__( 'Monthly Archives: %s', 'organ' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'organ' ) ) );

        } elseif ( is_year() ) {

            printf( esc_html__( 'Yearly Archives: %s', 'organ' ), get_the_date( _x( 'Y', 'yearly archives date format', 'organ' ) ) );

        }   else if ( is_post_type_archive() ) {
            sprintf( esc_html__( 'Archives: %s', 'organ' ), post_type_archive_title( '', false ) );
        } elseif ( is_single() && ! is_attachment() ) {
        
                echo esc_html(get_the_title());

            

        } elseif ( is_404() ) {

            echo esc_html__( 'Error 404', 'organ' );

        } elseif ( is_attachment() ) {

            echo esc_html(get_the_title());

        } elseif ( is_page() && !$post->post_parent ) {

            echo esc_html(get_the_title());

        } elseif ( is_page() && $post->post_parent ) {

            echo esc_html(get_the_title());

        } elseif ( is_search() ) {

            echo wp_specialchars_decode(esc_html__( 'Search results for &ldquo;', 'organ' ) . get_search_query() . '&rdquo;');

        } elseif ( is_tag() ) {

            echo wp_specialchars_decode(esc_html__( 'Posts tagged &ldquo;', 'organ' ) . single_tag_title('', false) . '&rdquo;');

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo wp_specialchars_decode(esc_html__( 'Author:', 'organ' ) . ' ' . $userdata->display_name);

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo wp_specialchars_decode($post_type->labels->singular_name);
            }

        }

        if ( get_query_var( 'paged' ) ) {
            echo wp_specialchars_decode( ' (' . esc_html__( 'Page', 'organ' ) . ' ' . get_query_var( 'paged' ) . ')');
        }
    } else {
        if ( is_home() && !is_front_page() ) {
            if ( ! empty( $home ) ) {               
                  echo wp_specialchars_decode(single_post_title('', false));
            }
        }
    }
}

// page breadcrumbs code
function tmOrgan_breadcrumbs() {
    global $post, $organ_Options,$wp_query, $author;
    if(isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2')
    {
    $delimiter = '';
    } else {
    $delimiter = ' &mdash;&rsaquo; ';
    }
    $before = '<li>';
    $after = '</li>';
    $home = esc_html__('Home', 'organ');

  
  // breadcrumb code
   
    if ( ( ! is_home() && ! is_front_page() && ! (is_post_type_archive()) ) || is_paged() ) {
        echo '<ul class="breadcrumb">';

        if ( ! empty( $home ) ) {
            echo wp_specialchars_decode($before . '<a class="home" href="' . esc_url(home_url() ) . '">' . $home . '</a>' . $delimiter . $after);
        }

        if ( is_home() ) {

            echo wp_specialchars_decode($before . single_post_title('', false) . $after);

         }      
         else if ( is_category() ) {

            if ( get_option( 'show_on_front' ) == 'page' ) {
                echo wp_specialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
            }

            $cat_obj = $wp_query->get_queried_object();
            if ($cat_obj) {
                $this_category = get_category( $cat_obj->term_id );
                if ( 0 != $this_category->parent ) {
                    $parent_category = get_category( $this_category->parent );
                    if ( ( $parents = get_category_parents( $parent_category, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                        echo wp_specialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $delimiter . $after);
                    }
                }
                echo wp_specialchars_decode($before . single_cat_title( '', false ) . $after);
            }

        } 
        elseif ( is_tax()) {      
                    
            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                echo wp_specialchars_decode($before . '<a href="' . esc_url(get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) )) . '">' . esc_html( $ancestor->name ) . '</a>' . $delimiter . $after);
            }

            echo wp_specialchars_decode($before . esc_html( $current_term->name ) . $after);

        } 
       
        elseif ( is_day() ) {

            echo wp_specialchars_decode($before . '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>' . $delimiter . $after);
            echo wp_specialchars_decode($before . '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a>' . $delimiter . $after);
            echo wp_specialchars_decode($before . get_the_time('d') . $after);

        } elseif ( is_month() ) {

            echo wp_specialchars_decode($before . '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>' . $delimiter . $after);
            echo wp_specialchars_decode($before . get_the_time('F') . $after);

        } elseif ( is_year() ) {

            echo wp_specialchars_decode($before . get_the_time('Y') . $after);

        } elseif ( is_single() && ! is_attachment() ) {

         
            if ( 'post' != get_post_type() ) {
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo wp_specialchars_decode($before . '<a href="' . esc_url(get_post_type_archive_link( get_post_type() )) . '">' . esc_html($post_type->labels->singular_name) . '</a>' . $delimiter . $after);
                echo wp_specialchars_decode($before . get_the_title() . $after);

            } else {

                if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                    echo wp_specialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
                }

                $cat = current( get_the_category() );
              if ( ( $parents = get_category_parents( $cat, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                $getitle=get_the_title();
                  if(empty($getitle))
                  {
                    $newdelimiter ='';
                  }
                  else
                  {
                     $newdelimiter=$delimiter;
                  }
                    echo wp_specialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $newdelimiter . $after);
                }
                echo wp_specialchars_decode($before . get_the_title() . $after);

            }

        } elseif ( is_404() ) {

            echo wp_specialchars_decode($before . esc_html__( 'Error 404', 'organ' ) . $after);

        } elseif ( is_attachment() ) {

            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID );
            $cat = $cat[0];
            if ( ( $parents = get_category_parents( $cat, TRUE, $delimiter . $after . $before ) ) && ! is_wp_error( $parents ) ) {
                echo wp_specialchars_decode($before . substr( $parents, 0, strlen($parents) - strlen($delimiter . $after . $before) ) . $delimiter . $after);
            }
            echo wp_specialchars_decode($before . '<a href="' . esc_url(get_permalink( $parent )) . '">' . esc_html($parent->post_title) . '</a>' . $delimiter . $after);
            echo wp_specialchars_decode($before . get_the_title() . $after);

        } elseif ( is_page() && !$post->post_parent ) {

            echo wp_specialchars_decode($before . get_the_title() . $after);

        } elseif ( is_page() && $post->post_parent ) {

            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ( $parent_id ) {
                $page = get_post( $parent_id );
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title( $page->ID )) . '</a>';
                $parent_id  = $page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            foreach ( $breadcrumbs as $crumb ) {
                echo wp_specialchars_decode($before . $crumb . $delimiter . $after);
            }

            echo wp_specialchars_decode($before . get_the_title() . $after);

        } elseif ( is_search() ) {

            echo wp_specialchars_decode($before . esc_html__( 'Search results for &ldquo;', 'organ' ) . get_search_query() . '&rdquo;' . $after);

        } elseif ( is_tag() ) {

            if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                echo wp_specialchars_decode($before . '<a href="' . esc_url(get_permalink( get_option('page_for_posts' ) )) . '">' . esc_html(get_the_title( get_option('page_for_posts', true) )) . '</a>' . $delimiter . $after);
            }

            echo wp_specialchars_decode($before . esc_html__( 'Posts tagged &ldquo;', 'organ' ) . single_tag_title('', false) . '&rdquo;' . $after);

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo wp_specialchars_decode($before . esc_html__( 'Author:', 'organ' ) . ' ' . $userdata->display_name . $after);

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo wp_specialchars_decode($before . $post_type->labels->singular_name . $after);
            }

        }

        if ( get_query_var( 'paged' ) ) {
            echo wp_specialchars_decode($before . '&nbsp;(' . esc_html__( 'Page', 'organ' ) . ' ' . get_query_var( 'paged' ) . ')' . $after);
        }

        echo '</ul>';
    } else { 
        if ( is_home() && !is_front_page() ) {
            echo '<ul class="breadcrumb">';

            if ( ! empty( $home ) ) {
                echo wp_specialchars_decode($before . '<a class="home" href="' . esc_url(home_url()) . '">' . $home . '</a>' . $delimiter . $after);

               
                echo wp_specialchars_decode($before . single_post_title('', false) . $after);
            }

            echo '</ul>';
        }
    }
}
  
  // breadcrumb
  function tmOrgan_page_breadcrumb()
  {
    /* === OPTIONS === */

    $text['home'] = 'Home'; // text for the 'Home' link
    $text['category'] = 'Archive by Category "%s"'; // text for a category page
    $text['tax'] = 'Archive for "%s"'; // text for a taxonomy page
    $text['search'] = 'Search Results for "%s" Query'; // text for a search results page
    $text['tag'] = 'Posts Tagged "%s"'; // text for a tag page
    $text['author'] = 'Articles Posted by %s'; // text for an author page
    $text['404'] = 'Error 404'; // text for the 404 page

    //global $organ_Options;
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
   
    $delimiter = ' &mdash;&rsaquo; '; // delimiter between crumbs
    
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;

    $homeLink = home_url() . '/';
    $linkBefore = '<span typeof="v:Breadcrumb">';
    $linkAfter = '</span>';
    $linkAttr = ' rel="v:url" property="v:title"';
    $link = $linkBefore . '<a' . wp_specialchars_decode($linkAttr) . ' href="%1$s">%2$s</a>' . wp_specialchars_decode($linkAfter);

    if (is_home() || is_front_page()) {

      if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($text['home']) . '</a></div>';
     
    } else {
     
      echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, esc_url($homeLink), esc_html($text['home']) ). $delimiter;


      if (is_category()) {
        $thisCat = get_category(get_query_var('cat'), false);
        if ($thisCat->parent != 0) {
          $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
          $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
          $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
          echo wp_specialchars_decode($cats);
        }
        echo wp_specialchars_decode($before . sprintf($text['category'], single_cat_title('', false)) . $after);

      } elseif (is_tax()) {
        $thisCat = get_category(get_query_var('cat'), false);
        if ($thisCat->parent != 0) {
          $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
          $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
          $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
          echo wp_specialchars_decode($cats);
        }
        echo wp_specialchars_decode($before . sprintf(esc_html($text['tax']), single_cat_title('', false)) . $after);

      } elseif (is_search()) {
        echo wp_specialchars_decode($before . sprintf(esc_html($text['search']), get_search_query()) . $after);

      } elseif (is_day()) {
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
        echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
        echo wp_specialchars_decode($before . get_the_time('d') . $after);

      } elseif (is_month()) {
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
        echo wp_specialchars_decode($before . get_the_time('F') . $after);

      } elseif (is_year()) {
        echo wp_specialchars_decode($before . get_the_time('Y') . $after);

      } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
          $post_type = get_post_type_object(get_post_type());
          $slug = $post_type->rewrite;
          printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
          if ($showCurrent == 1) echo wp_specialchars_decode($delimiter . $before . get_the_title() . $after);
        } else {
          $cat = get_the_category();
          $cat = $cat[0];
          $cats = get_category_parents($cat, TRUE, $delimiter);
          if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
          $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
          $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
          echo wp_specialchars_decode($cats);
          if ($showCurrent == 1) echo wp_specialchars_decode($before . get_the_title() . $after);
        }

      } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
        $post_type = get_post_type_object(get_post_type());
        echo wp_specialchars_decode($before . $post_type->labels->singular_name . $after);

      } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID);
        $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo wp_specialchars_decode($cats);
        printf($link, get_permalink($parent), $parent->post_title);
        if ($showCurrent == 1) echo wp_specialchars_decode($delimiter . $before . get_the_title() . $after);

      } elseif (is_page() && !$post->post_parent) {
        if ($showCurrent == 1) echo wp_specialchars_decode($before . get_the_title() . $after);

      } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo wp_specialchars_decode($breadcrumbs[$i]);
          if ($i != count($breadcrumbs) - 1) echo wp_specialchars_decode($delimiter);
        }
        if ($showCurrent == 1) echo wp_specialchars_decode($delimiter . $before . get_the_title() . $after);

      } elseif (is_tag()) {
        echo wp_specialchars_decode($before . sprintf($text['tag'], single_tag_title('', false)) . $after);

      } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo wp_specialchars_decode($before . sprintf($text['author'], $userdata->display_name) . $after);

      } elseif (is_404()) {
        echo wp_specialchars_decode($before . $text['404'] . $after);
      }

      if (get_query_var('paged')) {
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
         esc_attr_e('Page', 'organ') . ' ' . get_query_var('paged');
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
      }

      echo '</div>';

    }
  }

  // mini cart
  function tmOrgan_mini_cart()
{
    global $woocommerce,$organ_Options;
    ?>

<div class="mini-cart">
   <div  class="basket">
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
          <?php if(isset($organ_Options['theme_layout']) && $organ_Options['theme_layout']=='version2'){ ?>
        <?php  esc_attr_e('My Cart','organ'); ?>
        <?php } ?>
         
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
                        href="<?php echo esc_url(wc_get_cart_url()); ?>"><i
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
 

 
  //social links
  function tmOrgan_social_media_links()
  {
    global $organ_Options;

    if (isset($organ_Options
  ['social_facebook']) && !empty($organ_Options['social_facebook'])) {
      echo "<li class=\"fb pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_facebook']) ."'></a></li>";
    }

    if (isset($organ_Options['social_twitter']) && !empty($organ_Options['social_twitter'])) {
      echo "<li class=\"tw pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_twitter']) ."'></a></li>";
    }

    if (isset($organ_Options['social_googlep']) && !empty($organ_Options['social_googlep'])) {
      echo "<li class=\"googleplus pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_googlep'])."'></a></li>";
    }

    if (isset($organ_Options['social_rss']) && !empty($organ_Options['social_rss'])) {
      echo "<li class=\"rss pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_rss'])."'></a></li>";
    }

    if (isset($organ_Options['social_pinterest']) && !empty($organ_Options['social_pinterest'])) {
      echo "<li class=\"pintrest pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_pinterest'])."'></a></li>";
    }

    if (isset($organ_Options['social_linkedin']) && !empty($organ_Options['social_linkedin'])) {
      echo "<li class=\"linkedin pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_linkedin'])."'></a></li>";
    }

    if (isset($organ_Options['social_youtube']) && !empty($organ_Options['social_youtube'])) {
      echo "<li class=\"youtube pull-left\"><a target=\"_blank\" href='".  esc_url($organ_Options['social_youtube'])."'></a></li>";
    }
  }


  // bottom cpyright text 
  function tmOrgan_footer_text()
  {
    global $organ_Options;
    if (isset($organ_Options['bottom-footer-text']) && !empty($organ_Options['bottom-footer-text'])) {
      echo wp_specialchars_decode ($organ_Options['bottom-footer-text']);
    }
  }


  function tmOrgan_getPostViews($postID)
  {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
      return "0 View";
    }
    return $count . ' Views';
  }

  function tmOrgan_setPostViews($postID)
  {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
      $count = 0;
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
    } else {
      $count++;
      update_post_meta($postID, $count_key, $count);
    }
  }


  function tmOrgan_is_blog() {
    global  $post;
    $posttype = get_post_type($post );
    return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
  }
  //add to cart function
function tmOrgan_woocommerce_product_add_to_cart_text() {
    global $product;
    $product_type = $product->get_type();
    $product_id=$product->get_id();
    if($product->is_in_stock())
    {
    switch ( $product_type ) {
    case 'external':
    ?>
    <button class="button btn-cart" title='<?php esc_attr_e("Buy product",'organ'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span> <?php esc_attr_e('Buy product', 'organ'); ?></span>
    </button>
    <?php
       break;
       case 'grouped':
        ?>
    <button class="button btn-cart" title='<?php esc_attr_e("View products",'organ'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")' >
    <span><?php esc_attr_e('View products', 'organ'); ?> </span>
    </button>
    <?php
       break;
       case 'simple':
        ?>
    <?php tmOrgan_simple_product_link();?>
    <?php
       break;
       case 'variable':
        ?>
    <button class="button btn-cart"  title='<?php esc_attr_e("Select options",'organ'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span>
    <?php esc_attr_e('Select options', 'organ'); ?>
    </span> 
    </button>
    <?php
       break;
       default:
        ?>
    <button class="button btn-cart" title='<?php esc_attr_e("Read more",'organ'); ?>'
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'>
    <span><?php esc_attr_e('Read more', 'organ'); ?></span> 
    </button>
    <?php
       break;
       
       }
       }
       else
       {
       ?>
    <button type='button' class="button btn-cart" title='<?php esc_attr_e('Out of stock', 'organ'); ?> '
       onClick='window.location.assign("<?php echo esc_js(get_permalink($product_id)); ?>")'
       class='button btn-cart'>
    <span> <?php esc_attr_e('Out of stock', 'organ'); ?> </span>
    </button>
    <?php
    }
}
 
 // comment display 
  function tmOrgan_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
    <div class="comment-body">
      <div class="img-thumbnail">
        <?php echo get_avatar($comment, 80); ?>
      </div>
      <div class="comment-block">
        <div class="comment-arrow"></div>
        <span class="comment-by">
          <strong><?php echo get_comment_author_link() ?></strong>
          <span class="pt-right">
            <span> <?php edit_comment_link('<i class="fa fa-pencil"></i> ' . esc_html__('Edit', 'organ'),'  ','') ?></span>
            <span> <?php comment_reply_link(array_merge( $args, array('reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__('Reply', 'organ'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
          </span>
        </span>
        <div>
          <?php if ($comment->comment_approved == '0') : ?>
            <em><?php echo esc_html__('Your comment is awaiting moderation.', 'organ') ?></em>
            <br />
          <?php endif; ?>
          <?php comment_text() ?>
        </div>
        <span class="date pt-right"><?php printf(esc_html__('%1$s at %2$s', 'organ'), get_comment_date(),  get_comment_time()) ?></span>
      </div>
    </div>
  </li>
  <?php }

  //css manage by admin
  function tmOrgan_enqueue_custom_css() {
    global $organ_Options;

    ?>
    <style rel="stylesheet" property="stylesheet" type="text/css">
      <?php if(isset($organ_Options['opt-color-rgba']) &&  !empty($organ_Options['opt-color-rgba'])) {
      ?>
      .tm-main-menu {
        background-color: <?php echo esc_html($organ_Options['opt-color-rgba'])." !important";
      ?>
      }
      <?php
      }
      ?>
       
      
      <?php if(isset($organ_Options['footer_color_scheme']) && $organ_Options['footer_color_scheme']) {
      if(isset($organ_Options['footer_copyright_background_color']) && !empty($organ_Options['footer_copyright_background_color'])) {
       ?>
      .footer-bottom {
        background-color: <?php echo esc_html($organ_Options['footer_copyright_background_color'])." !important";
       ?>
      }

      <?php
       }
       ?>
      <?php if(isset($organ_Options['footer_copyright_font_color']) && !empty($organ_Options['footer_copyright_font_color'])) {
       ?>
      .coppyright {
        color: <?php echo esc_html($organ_Options['footer_copyright_font_color'])." !important";
      ?>
      }

      <?php
       }
       ?>
      <?php
       }
       ?>
    </style>
    <?php
  }
}


// Instantiate theme
$TmOrgan = new TmOrgan();

?>