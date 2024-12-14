<?php

/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */
defined('ABSPATH') || exit;
global $wp;
$url = strtok($_SERVER['REQUEST_URI'], '?');
do_action('product_rating_html');
echo '<input type="hidden" id="myAccountRef" value="' . basename(parse_url($url, PHP_URL_PATH)) . '" />';
//shine-subscription#RB
$shine_user = get_user_meta($current_user->ID, 'is_shine_user', true);
if (!wp_is_mobile() || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
    if(!$shine_user){
?>

<div class="shine-cards-my-account">
<div class="owl-item ">
   <div class="item">
      <div class="testimonial-one__single">
          <div class="ribbon ribbon-top-left"><span><span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span> </span></div> 
         <div class="testimonial-one__single-inner">
         <div class="testimonial-one__shape-1 shape-position-adjust left-position">
               <img decoding="async" class=""
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png" />
            </div>            
            <div class="testimonial-one__shape-1 shape-position-adjust">
               <img decoding="async" class=""
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png" />
            </div>
                <p>An easy-to-use membership program that will save you up to 70% on various dental, vision, and Rx expenses without costly insurance commitments or limitations.</p>

                    <div class="download-your-insurance-card">
                        <a href="/shine" class="btn" id="download-shine-card">
                            Become a Sh<span class="yellow-text" style="color:#bdf3f0">!</span>ne Member
                        </a>
                    </div>

         </div>
      </div>
   </div>
</div>
</div>
<?php }?>

    <div class="flexDesktop">
        <div class="sideBarNavigationList">
            <?php do_action('woocommerce_account_navigation'); ?>
        </div>
        <div class="myAccountContainerMbtInner">
            <?php
            do_action('woocommerce_account_content');
            ?>
        </div>
    </div>
<?php
} else {
    ?>
    <div class="flexMobile">
        <div class="mobileNavigationList">
            <?php do_action('woocommerce_account_navigation'); ?>
        </div>
        <div class="myAccountContainerMbtInnerMobile iamheretocheck">
<?php
if(!$shine_user){
?>
<div class="shine-cards-my-account">
<div class="owl-item ">
   <div class="item">
      <div class="testimonial-one__single">
         <!-- <div class="ribbon ribbon-top-left"><span><span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span> Member</span></div> -->
         <div class="testimonial-one__single-inner">
         <div class="testimonial-one__shape-1 shape-position-adjust left-position">
               <img decoding="async" class=""
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png" />
            </div>            
            <div class="testimonial-one__shape-1 shape-position-adjust">
               <img decoding="async" class=""
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png" />
            </div>
                <p>An easy-to-use membership program that will save you up to 70% on various dental, vision, and Rx expenses without costly insurance commitments or limitations.</p>

                    <div class="download-your-insurance-card">
                        <a href="/product/shine" class="btn" id="download-shine-card">
                            Become a Sh<span class="yellow-text" style="color:#f0c23a">!</span>ne Member
                        </a>
                    </div>

         </div>
      </div>
   </div>
</div>
</div>                
<?php
}
?>

            <?php
            do_action('woocommerce_account_content');
            ?>
        </div>
    </div>
<?php
}
?>
<div class="loading-sbr" style="display:none;">
    <div class="inner-sbr"></div>
</div>
<style>
    .loading-sbr {
        position: fixed;
        height: 100%;
        width: 100%;
        left: 0;
        right: 0;
        z-index: 9999;
        top: 0;
        display: none;
    }

    .loading-sbr .inner-sbr {
        position: fixed;
        width: 100%;
        width: 100%;
        z-index: 99;
        background: url('/wp-content/plugins/smile-brilliant/assets/images/puff-white.svg');
        height: 100%;
        background-repeat: no-repeat;
        background-position: center;
        max-width: 80px;
        max-height: 80px;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        margin-top: -40px;
        top: 50%;
        background-size: contain;
    }

    .loading-js #affwp-affiliate-dashboard-url-generator,
    .loading-js .affwp-tab-content {
        filter: blur(3px);
        -webkit-filter: blur(3px);
        -moz-filter: blur(3px);
        -o-filter: blur(3px);
        -ms-filter: blur(3px);
        filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius='3');
    }
</style>