<?php
/* Template name: Home */
get_header();
$TmOrgan = new TmOrgan();
?>
<?php tmOrgan_home_page_banner(); ?>

<?php //tmOrgan_home_sub_banners ();?>
<?php //tmOrgan_category_product($organ_Options['home-product-categories-limit']!='' ? esc_html($organ_Options['home-product-categories-limit']) : 10);?>
<?php tmOrgan_home_offer_banners(); ?>
<?php tmOrgan_bestseller_products(); ?>
<?php tmOrgan_hotdeal_product(); ?>
<?php tmOrgan_product_tabs(); ?>
<?php tmOrgan_home_blog_posts();?>

<?php get_footer(); ?>
