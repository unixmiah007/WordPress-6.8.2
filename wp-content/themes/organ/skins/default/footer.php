<?php 
$TmOrgan = new TmOrgan();?>
 
  
<footer>
        
  <div class="footer-inner">
    <div class="newsletter-row">
    <div class="container">
      <div class="row"> 
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col"> 
          <!-- Footer Payment Link -->
          <?php if (is_active_sidebar('footer-sidebar-5')) : ?>
            <?php dynamic_sidebar('footer-sidebar-5'); ?>
          <?php endif; ?> 
        </div>
        <!-- Footer Newsletter -->
        <?php if( function_exists( 'mc4wp_show_form' ) ) { ?> 
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col1">
          <div class="newsletter-wrap">              
            <?php mc4wp_show_form(); ?>                
          </div>
          <!--newsletter-wrap--> 
        </div>
        <?php } ?>
      </div>
    </div>
    <!--footer-column-last--> 
    </div>
    
      <div class="container">
        <div class="row">
          <div class="col-sm-4 col-xs-12 col-lg-4">
            <!-- <div class="footer-column co-info footer-first"> -->
                <?php if (is_active_sidebar('footer-sidebar-1')) : ?>
                    <div class="co-info">
                    <?php dynamic_sidebar('footer-sidebar-1'); ?>
                
                    <div class="social">
                        <ul>
                            <?php $TmOrgan->tmOrgan_social_media_links(); ?>
                        </ul>
                    </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-8 col-xs-12 col-lg-8">
              <div class="footer-column">
                  <?php if (is_active_sidebar('footer-sidebar-2')) : ?>
                      <?php dynamic_sidebar('footer-sidebar-2'); ?>
                  <?php endif; ?>
              </div>
              <div class="footer-column">
                  <?php if (is_active_sidebar('footer-sidebar-3')) : ?>
                      <?php dynamic_sidebar('footer-sidebar-3'); ?>
                  <?php endif; ?>
              </div>
              <div class="footer-column">
                  <?php if (is_active_sidebar('footer-sidebar-4')) : ?>
                      <?php dynamic_sidebar('footer-sidebar-4'); ?>
                  <?php endif; ?>                
              </div>
            </div>        
          </div>
          <!--col-sm-12 col-xs-12 col-lg-8-->
          <!--col-xs-12 col-lg-4-->
        </div>
        <!--row-->
      </div>
      <!--container-->
    

     
      <div class="footer-bottom">
      <div class="container">
      <div class="row">
          <?php $TmOrgan->tmOrgan_footer_text(); ?>
      </div>
      <!--row-->
      </div>
      <!--container-->
      </div>
    <!--footer-bottom-->
  <!--/div-->
  </footer>

    </div>
   
    <script type="text/javascript">
    jQuery(document).ready(function($){ 
        
        new UISearch(document.getElementById('form-search'));
    });

    </script>
    
<div class="menu-overlay"></div>
<?php // navigation panel
require_once(TMORGAN_THEME_PATH .'/menu_panel.php');
 ?>
    <!-- JavaScript -->
    
    <?php wp_footer(); ?>
    </body></html>
