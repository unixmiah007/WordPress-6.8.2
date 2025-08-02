<?php
/* Template name: Home */
get_header();
global $organ_Options;
$TmOrgan = new TmOrgan();
?>
<?php tmOrgan_home_page_banner(); ?>
<?php tmOrgan_header_service(); ?>
<?php //tmOrgan_home_sub_banners (); ?>
<?php tmOrgan_category_product($organ_Options['home-product-categories-limit']!='' ? esc_html($organ_Options['home-product-categories-limit']) : 10);?>
<?php tmOrgan_home_offer_banners(); ?>
<?php tmOrgan_bestseller_products(); ?>
<?php tmOrgan_home_blog_posts();?>
<div class="brand-logo wow bounceInUp animated animated" style="visibility: visible;">
  <div class="container">
    <div class="row">
	<?php tmOrgan_footer_brand_logo();?>
	<?php tmOrgan_home_testimonial();?>
	</div>
  </div>
</div>

<?php get_footer(); ?>
