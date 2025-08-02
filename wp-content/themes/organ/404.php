<?php

get_header(); ?>
 <div class="page-heading">
    <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <?php $TmOrgan->tmOrgan_breadcrumbs(); ?>
      </div>
          <!--col-xs-12--> 
        </div>
        <!--row--> 
      </div>
      <!--container--> 
    </div>
    <div class="page-title">
      <h1 class="entry-title">
        <?php $TmOrgan->tmOrgan_page_title(); ?>
      </h1>
        </div>
</div>

<div class="content-wrapper">
    <div class="container">
        <div class="std">
            <div class="page-not-found wow bounceInRight animated">
                <h2><?php  esc_attr_e('404','organ') ;?></h2>

                <h3><img src="<?php echo esc_url(get_template_directory_uri()) . '/images/signal.png'; ?>"
                         alt="<?php  esc_attr_e('404! Page Not Found','organ') ;?>">
                         <?php  esc_attr_e('Oops! The Page you requested was not found!','organ') ;?></h3>

                <div><a href="<?php echo esc_url(get_home_url()); ?>" type="button"
                        class="btn-home"><span><?php  esc_attr_e('Back To Home','organ') ;?></span></a></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

