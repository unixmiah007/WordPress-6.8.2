<?php
function tmOrgan_product_pagebanner()
{
    global $organ_Options;
if (isset($organ_Options['product_banner']) && !empty($organ_Options['product_banner']['url']))
 {?>
 <div class="product-banner-box">
  <a href="<?php echo !empty($organ_Options['product_banner_url']) ? esc_url($organ_Options['product_banner_url']) : '#' ?>">                 
 <img src="<?php echo esc_url($organ_Options['product_banner']['url']); ?>" alt="<?php esc_attr_e('Product Banner', 'organ'); ?>">
   </a> 
  </div>          
<?php }
}


function tmOrgan_product_social_share()
{
global $organ_Options;
$sharing_facebook = isset($organ_Options['social_facebook']) ? $organ_Options['social_facebook'] : 0;
$sharing_twitter = isset($organ_Options['social_twitter']) ? $organ_Options['social_twitter'] : 0;
$sharing_google = isset($organ_Options['social_googlep']) ? $organ_Options['social_googlep'] : 0;
$sharing_linkedin = isset($organ_Options['social_linkedin']) ? $organ_Options['social_linkedin'] : 0;
$sharing_pinterest = isset($organ_Options['social_pinterest']) ? $organ_Options['social_pinterest'] : 0;


if (!empty($sharing_facebook) ||
!empty($sharing_twitter) ||
!empty($sharing_linkedin) ||
!empty($sharing_google) ||
!empty($sharing_pinterest)
) :
?>
    <div class="social">
                            <ul>
            <?php if (!empty($sharing_facebook)) : ?>
                <li class="fb pull-left">
                    <a onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo esc_html(urlencode(get_permalink()));?>','sharer', 'toolbar=0,status=0,width=620,height=280');"  href="javascript:;">
                      
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!empty($sharing_twitter)) :  ?>
                <li class="tw pull-left">
                    <a onclick="popUp=window.open('http://twitter.com/home?status=<?php echo esc_html(urlencode(get_the_title())); ?> <?php echo esc_html(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;"  href="javascript:;">
                     
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!empty($sharing_google)) :  ?>
                <li class="googleplus pull-left">
               <a href="javascript:;" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo esc_html(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                   
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!empty($sharing_linkedin )):?>
                <li  class="linkedin pull-left">
                    <a  onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_html(urlencode(get_permalink())); ?>&amp;title=<?php echo esc_html(urlencode(get_the_title())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                      
                    </a>
                </li>
            <?php endif; ?>

            

            <?php if (!empty($sharing_pinterest)) :  ?>
                <li class="pintrest pull-left">
                    <a onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_html(urlencode(get_permalink())); ?>&amp;description=<?php echo esc_html(urlencode(get_the_title())); ?>&amp;media=<?php $arrImages = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo has_post_thumbnail() ? esc_html($arrImages[0])  : "" ; ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                   
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif;

}