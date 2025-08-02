<?php 

$TmOrgan = new TmOrgan();?>

<?php tmOrgan_footer_brand_logo();?>
<?php tmOrgan_header_service(); ?>

 <footer>
    <div class="footer-inner">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-xs-12 col-lg-8">

                <?php if (is_active_sidebar('footer-sidebar-1')) : ?>
                    <div class="footer-column pull-left">
                      <?php dynamic_sidebar('footer-sidebar-1'); ?>
                    </div>
                <?php endif; ?>

            
           
               <?php if (is_active_sidebar('footer-sidebar-2')) : ?>
                    <div class="footer-column pull-left">
                      <?php dynamic_sidebar('footer-sidebar-2'); ?>
                     </div>
                <?php endif; ?>

           
              <?php if (is_active_sidebar('footer-sidebar-3')) : ?>
                   <div class="footer-column pull-left">
                     <?php dynamic_sidebar('footer-sidebar-3'); ?>
                    </div>
              <?php endif; ?>
              
          </div>
          <div class="col-xs-12 col-lg-4">
            <div class="footer-column-last">
            <?php if( function_exists( 'mc4wp_show_form' ) ) { ?> 
              <div class="newsletter-wrap">
              <h4>Sign up for emails</h4>	
              <?php mc4wp_show_form();?>
              </div>
            <?php } ?>  
	      <div class="social">
                <h4>Follow Us</h4>
              <?php $TmOrgan->tmOrgan_social_media_links(); ?>
              </div> 
               <?php if (is_active_sidebar('footer-sidebar-4')) : ?>
                  <?php dynamic_sidebar('footer-sidebar-4'); ?>
               <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
      <?php tmOrgan_footer_middle();?>
    </div>
    
    
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
         <?php $TmOrgan->tmOrgan_footer_text(); ?>
        </div>
      </div>
    </div>
  </footer>

    </div>
   
    
    
<div class="menu-overlay"></div>
<?php // navigation panel
require_once(TMORGAN_THEME_PATH .'/menu_panel.php');
 ?>
   
    <?php wp_footer(); ?>
    </body></html>
