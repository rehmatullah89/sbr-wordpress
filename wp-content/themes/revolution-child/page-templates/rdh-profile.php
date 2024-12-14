<?php
require(get_stylesheet_directory() . '/inc/rdh-info.php');
setcookie('affwp_ref', $affiliate_id, time() + (86400 * 30), "/");
//update_user_meta($user_id,'product_found','');
setcookie('red_user_id', $user_id, strtotime('+1 day'));

get_header('rdh');
?>
<style>
  header#sbr-header,
  .deal-top-bar,
  #friendbuyoverlaySite,
  header#mobile-header,
  iframe#launcher,
  #scroll_to_top {

    display: none !important;

  }

  .header-spacer {

    height: 0px !important;

  }



  .profile-container-wrapper.rdhTemplateWrapper {
    margin-top: -100px;
  }

  .no-bkground-required {
    padding: 0px;
    background: none !important;
  }

  .user-profile-hero {
    padding-bottom: 100px;
  }

  .logged-in .hide-on-public-profile {
    display: none !important;
  }

  html body #wrapper .hide-on--all-profile-pages {
    display: inline-flex;
  }

  @media (max-width: 767px) {
    .logged-in .rdhHeaderWrapper .secondary-area-mbt {
      /* top: -2px; */
    }

    .profile-container-wrapper.rdhTemplateWrapper {
      margin-top: -21px;
    }

    .user-profile-hero {
      padding-bottom: 0px;
    }

    .user-profile-hero.rdhHeaderWrapper {
      padding-bottom: 15px;
      margin-bottom: 0;
    }
  }
</style>

<div class="profile-container-wrapper rdhTemplateWrapper">

  <!--user profile header section-->

  <div class="user-profile-hero no-bkground-required">
    <div class="tabsSectionrdhSec">

      <div class="profile-container">

        <div class="list-items Montserrat">

          <ul id="list_items_mbt">

            <li><a id="profile-active" data-href-cust="/rdh/profile/<?php echo get_query_var('buddyname'); ?>">Profile</a></li>

            <?php

            $affwp_product_rates =  get_user_meta($user_id, 'affwp_product_rates', true);
            $rdh_recommended_toggle_show = get_user_meta($user_id, 'rdh_recommended_url', true);

            if ($rdh_recommended_toggle_show != 'hide') { ?>

              <li><a id="reco-active" data-href-cust="/rdh/products/<?php echo get_query_var('buddyname'); ?>?ref=<?php echo $affiliate_id; ?>">Product Recommendations</a></li>

            <?php } ?>

            <li><a id="contact-active" data-href-cust="/rdh/contact/<?php echo get_query_var('buddyname'); ?>">Contact Me</a></li>

          </ul>

        </div>

      </div>

    </div>



  </div>



  <!--user profile header section end-->











  <!--user profile main section-->





  <?php

  //if (strpos($_SERVER['REQUEST_URI'], 'rdh/products') !== false) {



  if ($rdh_recommended_toggle_show != 'hide') {

    // echo '<pre>';

    // print_r($affwp_product_rates);

    // echo '</pre>';



  ?>







<div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer">
        <div class="row-t product-item-display profile-container sale-page rdhtabs" style="display:none">

<?php
 $product_found= get_user_meta($user_id,'product_found',true);
?>
      <h3 class="headingSectionTop font-mont">
        MY PERSONAL PRODUCT RECOMMENDATIONS
      </h3>

      <h2 class="sectionTitle" style="display:none ;">

        Now Purchase My Recommended Products On Discounts Of Upto <span>30%</span> Offered

      </h2>

      <?php
        global $wpdb;
        $get_redhc_page = "SELECT post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_posts.ID =  wp_postmeta.post_id WHERE meta_key='rdhc_id' AND meta_value = $user_id AND post_type='page' and post_status = 'publish'";
        $page_id = $wpdb->get_var( $wpdb->prepare($get_redhc_page));
        if($page_id!='') {
        $page = get_post( $page_id );
        $content = apply_filters('the_content', $page->post_content); 
        echo $content;
        }
        
        if($product_found =='') {
            ?>
            <script>
              jQuery(document).ready(function(){
          
                //jQuery('#reco-active').remove();
              });
             
              </script>
            
            <?php
        }
        else{
          //echo 'found';
        }
        //$existing_value = get_user_meta($user_id,'rdhc_discounted_products',true);
        // echo '<pre>';
        // print_r($existing_value);
        // echo '</pre>';
        // echo $user_id;
        ?>
        <script>
          jQuery(document).ready(function(){
            if(jQuery('.lander-shortcode').length>0){
              //
              console.log('exists');
            }
            else{
              jQuery('#reco-active').remove();
              console.log('no exist');
            }
          });
        </script>
      <div class="col-lg-12 itemProducts">

        <?php
if(isset($affwp_product_rates['woocommerce']) && is_array($affwp_product_rates['woocommerce'])) {
        foreach ($affwp_product_rates['woocommerce'] as $arr) {
continue;
          foreach ($arr['products'] as $key => $val) {

            $product_id = $val;

            $rate_sale = $arr['rate_sale'];

            $type_sale = $arr['type_sale'];

            $product = wc_get_product($product_id);

            $pprice = (int) $product->get_price();

            $discount  = 0;

            if ($type_sale == 'percentage') {

              $discount = ($pprice * $rate_sale) / 100;

              $discounted_price = $pprice - $discount;
            } elseif ($type_sale == 'flat') {

              $discount = $rate_sale;

              $discounted_price = $pprice - $rate_sale;
            } else {

              $discount = 0;

              $discounted_price = $pprice;
            }

            $pid =  $product_id;

            $_product = $product;



            $sale_price =  get_post_meta($pid, '_price', true) - $discount;

            $still_available = get_post_meta($pid, 'still_available', true);

            $bogo_custom_title = get_post_meta($pid, 'bogo_custom_title', true);



        ?> <div class="product-selection-box-parent">

              <div class="product-selection-box">

                <div class="row-t-mm">

                  <div class="product-selection-title-right">

                    <span class="availableItem"><?php echo $still_available; ?> STILL AVAILABLE</span> <span class="saveOnItem">SAVE $<?php echo get_post_meta($pid, 'sale_page_discount', true); ?></span>

                  </div>

                </div>

                <div class="row-t-mm">

                  <div class="col-sm-12-mm col-md-12-mm">

                    <div class="product-image">

                      <img src="<?php echo get_the_post_thumbnail_url($pid, 'large'); ?>" alt="">

                    </div>

                  </div>

                  <div class="product-selection-description-text-wrap">

                    <div class="product-selection-description-text-wrap-inner">

                      <div class="product-selection-title-text-wrap">



                        <span class="product-selection-title-text-name">

                          <?php

                          if ($bogo_custom_title == '') {

                            $ptitle = get_post_meta($pid, 'styled_title', true);

                            if ($ptitle == '') {

                              $ptitle =  get_the_title($pid);
                            }

                            $ptitle =  get_the_title($pid);
                          } else {

                            $ptitle = $bogo_custom_title;
                          }



                          ?>

                          <?php echo  $ptitle; ?>

                        </span>



                        <div class="row-mbt-product justify-content-between maxwidth80">

                          <?php



                          if ($_product->is_on_sale()) {

                          ?>

                            <div class="original-price">

                              <div class="price-was gray-text line-thorough"><span class="wasText">was </span><span class="doller-sign">$</span><?php echo $_product->get_regular_price(); ?></div>

                            </div>



                            <div class="sale-price">



                              <div class="price-new "><span class="doller-sign">$</span><?php echo $_product->get_sale_price(); ?></div>

                            </div>

                          <?php

                          } else {

                          ?>

                            <div class="original-price">



                              <div class="price-was gray-text line-thorough"><span class="wasText">was </span><span class="doller-sign">$</span><?php echo get_post_meta($pid, '_price', true); ?></div>

                            </div>



                            <div class="sale-price">

                              <div class="price-new "><span class="doller-sign">$</span><?php echo $sale_price; ?></div>

                            </div>

                          <?php

                          }

                          ?>





                        </div>









                      </div>



                      <div class="product-selection-description-text">

                        <?php echo get_post_meta($pid, 'sale_page_info', true); ?>



                        <div class="add-to-cart">

                          <?php



                          $bogoProduct = get_post_meta($pid, 'bogo_product_id', true);

                          $addedClass = '';



                          if (in_array($bogoProduct, array_column(WC()->cart->get_cart(), 'product_id'))) {

                            foreach (WC()->cart->get_cart() as $cartkey => $cart_item) {

                              // compatibility with WC +3

                              if ($cart_item['data']->get_id() == $bogoProduct && isset($cart_item['bogo_added'])) {

                                $addedClass = 'added-to-cart';
                              }

                              if ($cart_item['data']->get_id() == $bogoProduct && isset($cart_item['bogo_discount'])) {

                                $addedClass = 'added-to-cart';
                              }
                            }
                          }

                          $string_bogo = '';

                          if (get_post_meta($pid, 'bogo_product_id', true) != '') {

                            $string_bogo = 'data-bogo_discount=' . get_post_meta($pid, 'bogo_product_id', true) . ' onClick="addClassByClickmbt(this)" ';
                          }

                          ?>

                          <?php if ($_product->is_on_sale()) {

                          ?>

                            <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart <?php echo $addedClass; ?>" href="?add-to-cart=<?php echo $pid; ?>" <?php echo  $string_bogo; ?> data-quantity="1" data-product_id="<?php echo $pid; ?>" data-action="woocommerce_add_order_item">ADD TO CART</button>

                          <?php

                          } else {

                          ?>

                            <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart <?php echo $addedClass; ?>" href="?add-to-cart=<?php echo $pid; ?>" <?php echo  $string_bogo; ?> data-quantity="1" data-product_id="<?php echo $pid; ?>" data-rdh_sale_price="<?php echo $sale_price; ?>" data-action="woocommerce_add_order_item">ADD TO CART</button>

                          <?php

                          } ?>



                        </div>



                      </div>







                    </div>

                    <script>
                      function addClassByClickmbt(obj) {

                        jQuery(obj).addClass('added-to-cart');

                      }
                    </script>



                  </div>

                </div>

              </div>

            </div>

        <?php

          }
        }
      }
        ?>

      </div>

    </div>
      </div>

  <?php

  } else {

    echo '<div class="article-content-wrapper" style="display: none;">

    <div class="articles-wrapper"><div class="no-article"><h6>No Product found</h6></div></div></div>';
  }

  ?>



  <?php

  //  } else if (strpos($_SERVER['REQUEST_URI'], 'rdh/contact') !== false) {

  ?>





  <div class="contactMessagesMbt profile-container rdhtabs" style="display:none;">

    <h3 class="headingSectionTop font-mont">
      LET’S CONNECT!


    </h3>

    <div class="contactBarText" style="display:none;">

      <p>CONTACT <?php echo strtoupper($user_firstname); ?> <?php echo strtoupper($user_lastname); ?> RDH</p>

    </div>

    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <div class="flex-wrap">

      <div class="contactFormWrapper">
        <div id="rdhResponse"></div>
        <form class="rdhContact" id="rdhContactForm">

          <div class="form-group">
            <label for="contactFormName" class="upper"><i class="fa fa-user"></i>Your Name</label><br>
            <span class="wpcf7-form-control-wrap user-name"><input type="text" name="user-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Your Name"></span>
          </div>
          <div class="form-group">
            <label for="contactFormEmail" class="upper"><i class="fa fa-envelope"></i>Your Email</label><br>
            <span class="wpcf7-form-control-wrap user-email"><input type="email" name="user-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" aria-required="true" aria-invalid="false" placeholder="Your Email"></span>
          </div>
          <div class="form-group select-field">
            <label for="contactType" class="upper"><i class="fa fa-cog"></i>MESSAGE TYPE</label><br>
            <span class="wpcf7-form-control-wrap type"><select name="type" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                <option value="General Inquiry">General Inquiry</option>
              </select></span>
          </div>

          <div class="form-group text-area-wrapper">
            <label for="contactFormMessage" class="upper"><i class="fa fa-pencil"></i>YOUR MESSAGE</label><br>
            <span class="wpcf7-form-control-wrap message">
              <textarea name="message" cols="40" rows="6" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required form-control-large" aria-required="true" aria-invalid="false" placeholder="Enter Your Message"></textarea></span>
          </div>
          <input type="hidden" name="action" value="rdhConnectQuery" />
          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
          <div class="button-align-desktop">
            <div class="g-recaptcha" data-sitekey="6LcpUbIeAAAAAHVNlO9ov2TS2gPdNn0mEQ90YZ3i"></div>
            <div class="justify-start send-message-text-parent">
              <input type="button" value="SEND MESSAGE" id="btn_rdhContactForm" class="btn send-message-text">

            </div>

          </div>

        </form>

      </div>

      <script>
        jQuery("body").on("click", "#btn_rdhContactForm", function() {



          jQuery(".contactFormWrapper").find('#rdhResponse').html('');

          jQuery(".contactFormWrapper").block({

            message: null,

            overlayCSS: {

              background: "#fff",

              opacity: 0.6,

            },

          });

          var elementT = document.getElementById("rdhContactForm");

          var formdata = new FormData(elementT);

          jQuery.ajax({

            url: ajaxurl,

            data: formdata,

            async: true,

            method: "POST",

            dataType: "HTML",

            success: function(response) {

              jQuery("body .contactFormWrapper").unblock();

              jQuery("body .contactFormWrapper").find('#rdhResponse').html(response);

              grecaptcha.reset();

            },

            cache: false,

            contentType: false,

            processData: false,

          });

        });
      </script>

      <div class="social-links-rdh-left-section">

        <div class="social-links-rdh">

          <p class="follow-social-text">Follow <?php echo $user_firstname; ?> <?php echo $user_lastname; ?></p>

          <ul>

            <?php $style_s_follow = "none;" ?>

            <?php if (get_user_meta($user_id, 's_facebook', true) != '') {

              $style_s_follow = "block";

            ?>

              <li> <a href="http://www.facebook.com/<?php echo get_user_meta($user_id, 's_facebook', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fb.png" alt="" srcset=""></a> </li>

            <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_twitter', true) != '') {

              $style_s_follow = "block";

            ?>

              <li> <a href="http://www.twitter.com/<?php echo get_user_meta($user_id, 's_twitter', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/twitr.png" alt="" srcset=""></a> </li>

            <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_linkedin', true) != '') {

              $style_s_follow = "block";

            ?>

              <li> <a href="http://www.linkedin.com/in/<?php echo get_user_meta($user_id, 's_linkedin', true); ?>"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/linkdin.png" alt="" srcset=""></a></li>

            <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_instagram', true) != '') {

            ?>

              <li> <a href="http://www.instagram.com/<?php echo get_user_meta($user_id, 's_instagram', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insta.png" alt="" srcset=""></a> </li>

            <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_youtube', true) != '') {

              $style_s_follow = "block";

            ?>



              <li> <a href="http://www.youtube.com/<?php echo get_user_meta($user_id, 's_youtube', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/youtube.png" alt="" srcset=""></a> </li>

            <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_tikTok', true) != '') {

              $style_s_follow = "block";

            ?>



              <li class="ticktokIcon"> <a href="http://www.tiktok.com/@<?php echo get_user_meta($user_id, 's_tikTok', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tiktok.svg" alt="" srcset=""></a> </li>

            <?php

            }

            ?>

            <?php



            if (get_user_meta($user_id, 's_blog', true) != '') {

              $style_s_follow = "block";



            ?>



              <li class="blockIcon_mbt"> <a href="<?php echo get_user_meta($user_id, 's_blog', true); ?>"><i class="fa fa-link" aria-hidden="true"></i></a> </li>

            <?php

            }

            ?>

          </ul>

          <style>
            .follow-social-text {
              display: <?php echo $style_s_follow; ?>
            }
          </style>

        </div>

      </div>


        </div>


        <?php 

        //echo show_chat_widget_rdh_profile($user_id);?>



  </div>



  <?php



  //  } else {

  ?>





  <div class="rdhtabs profile-container-all" style="display:none">

    <div class="profile-container">

      <div class="user-details-wrapper gap-between-elements-60">

        <div class="profile-detail Montserrat  ">

          <h3 class="font-mont"><?php echo $user_firstname; ?> <?php echo $user_lastname; ?> <span class="RDHdisplayName">RDH</span></h3>

          <p class="designation font-mont"> <?php echo $rdh_subtitle; ?></p>

          <div class="address">

            <!-- <p>HOME TOWN</p> -->

            <p class="font-mont"><?php echo $address_town_city; ?>, <?php echo $address_state; ?>, <?php echo $address_country;?></p>

          </div>
          <ul>
            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/RDHEF-image.png" alt="" /></li>

            <?php if (is_array($titles) && count($titles) > 0) {

              foreach ($titles as $ti) {

                echo '<li class="bg">' . $ti . '</li>';
              }
            }
            ?>
          </ul>
          <div class="license-wrapper ">
            <?php if (is_array($liscence) && count($liscence) > 0) {

              for ($i = 0; $i < count($liscence['state']); $i++) {

                $state_full_name = isset($statesUs[$liscence['state'][$i]]) ? $statesUs[$liscence['state'][$i]] : $liscence['state'][$i];

                echo ' <div class="license-box"><small>License</small>

                <p class="lincese-box-text">' . ($state_full_name) . '</span><span class="text-hash-only"></span> <span class="lincense-state"></p></div>';
              }
            }

            ?>







          </div>







          <div class="brief-intro-wrapper  mobile-hiddden">

            <div class="brief-introduction">

              <h2>INTRODUCTION</h2>

              <p class="open-sans">

                <?php echo $brief; ?>

              </p>

            </div>

          </div>





        </div>



        <div class="mobile-layout-adjust">



          <?php

          if ($embed_url == 'hide') {

          ?>

            <script>
              jQuery(".user-details-wrapper").addClass('added-class-full-width-js');
            </script>



          <?php } ?>



          <?php
          $rdhc_video_  = get_user_meta($user_id, 'rdhc_video_', true);
          if ($embed_url != 'hide') {
            $user_info = get_userdata($user_id);
            $rows = get_field('rdhc_invite_codes', 'option');
            //$rdhc_video_ = '';
            if ($rows) {
              foreach ($rows as $row) {
                $rdhc_email_address = isset($row['rdhc_email_address']) ? $row['rdhc_email_address'] : '';
                $rdhc_invite_code = $row['rdhc_invite_code'] ? $row['rdhc_invite_code'] : '';
                $rdhc_code_usage_limit = $row['rdhc_code_usage_limit'] ? $row['rdhc_code_usage_limit'] : '';
                if ($rdhc_email_address == $user_info->user_email) {
                  ///$rdhc_video_ = $row['rdhc_video_'] ? $row['rdhc_video_'] : '';
                  break;
                }
              }
            }
            if($rdhc_video_!=''){
          ?>

            <div class="introVideo order-1m ss">

              <div class="iframe-video">

                <?php echo $rdhc_video_; ?>

              </div>

              <div class="video-title">

                Meet <?php echo $user_firstname; ?> <?php echo $user_lastname; ?> RDH

              </div>



            </div>

          <?php } } ?>



          <div class="brief-intro-wrapper order-2m desktop-hidden ">

            <div class="brief-introduction">

              <h2>INTRODUCTION</h2>

              <p>

                <?php echo $brief; ?>

              </p>

            </div>

          </div>

        </div>





        <div class="social-network Montserrat" style="display:none;">

          <p>SOCIAL NETWORK</p>

          <div class="social-icons">

            <ul>

              <?php if (get_user_meta($user_id, 's_facebook', true) != '') {

              ?>

                <li> <a href="http://www.facebook.com/<?php echo get_user_meta($user_id, 's_facebook', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fb.png" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_twitter', true) != '') {

              ?>

                <li> <a href="http://www.twitter.com/<?php echo get_user_meta($user_id, 's_twitter', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/twitr.png" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_linkedin', true) != '') {

              ?>

                <li> <a href="http://www.linkedin.com/in/<?php echo get_user_meta($user_id, 's_linkedin', true); ?>"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/linkdin.png" alt="" srcset=""></a></li>

              <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_instagram', true) != '') {

              ?>

                <li> <a href="http://www.instagram.com/<?php echo get_user_meta($user_id, 's_instagram', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insta.png" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_youtube', true) != '') {

              ?>



                <li> <a href="http://www.youtube.com/<?php echo get_user_meta($user_id, 's_youtube', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/youtube.png" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_tikTok', true) != '') {

              ?>



                <li> <a href="http://www.tiktok.com/@<?php echo get_user_meta($user_id, 's_tikTok', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tiktok.svg" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

              <?php



              if (get_user_meta($user_id, 's_blog', true) != '') {



              ?>



                <li> <a href="<?php echo get_user_meta($user_id, 's_blog', true); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/blog.png" alt="" srcset=""></a> </li>

              <?php

              }

              ?>

            </ul>



            <div class="buttons">

              <div class="product-button">

                <button><a href="/rdh/products/<?php echo get_query_var('buddyname'); ?>?ref=<?php echo $affiliate_id; ?>"> MY RECOMMENDATIONS</a></button>

              </div>

              <div class="contact">

                <button class="modal-toggle"><a href="">CONTACT</a></button>

              </div>

            </div>



            <div class="modal">

              <div class="modal-overlay modal-toggle"></div>

              <div class="modal-wrapper modal-transition">

                <div class="modal-header">

                  <button class="modal-close modal-toggle">

                    <div class="close">

                      <span></span>

                      <span></span>

                    </div>

                  </button>

                  <h2 class="modal-heading">Contact <?php echo $user_firstname; ?> <?php echo $user_lastname; ?></h2>

                </div>



                <div class="modal-body">

                  <div class="modal-content">

                    <form id="contact" action="" method="post">



                      <div class="form-row">

                        <fieldset>

                          <input placeholder="Your name" type="text" tabindex="1" required autofocus>

                        </fieldset>

                        <fieldset>

                          <input placeholder="Your Email Address" type="email" tabindex="2" required>

                        </fieldset>

                      </div>

                      <div class="form-row">

                        <fieldset>

                          <input placeholder="Your Phone " type="tel" tabindex="3" required>

                        </fieldset>

                        <fieldset>

                          <input placeholder="Subject" type="url" tabindex="4" required>

                        </fieldset>

                      </div>

                      <fieldset>

                        <textarea placeholder="message" tabindex="5" required></textarea>

                      </fieldset>

                      <fieldset style="text-align:right">

                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Send Message</button>

                      </fieldset>

                    </form>

                  </div>

                </div>

              </div>

            </div>



          </div>

        </div>

      </div>

    </div>



    <?php



    if (is_array($experience) && count($experience) > 0) {

    ?>

      <div class="profile-container Montserrat">

        <div class="work-experience-wrapper">

          <div class="heading">

            <h2>WORK EXPERIENCE</h2>

          </div>

        </div>

        <div class="box-wrapper">

          <?php

          for ($i = 0; $i < count($experience['exp_title']); $i++) {

            $total_months_exp = '';

            $total_yearss_exp = '';



            $till_month = $experience['end_month'][$i];

            $till_year = $experience['end_year'][$i];

            $start_month = $experience['start_month'][$i];

            $start_year = $experience['start_year'][$i];

            if ($experience['end_month'][$i] == '') {

              $till_month = date("m");

              $till_year = date("Y");
            }

            $total_months_m = (int) $till_month - (int) $start_month;

            $total_months = (int) $till_year - (int) $start_year;

            if ($total_months > 0) {

              $total_months = $total_months * 12;
            }

            $total_months = $total_months + ($total_months_m);

            $years_t =  $total_months / 12;

            if (is_float($years_t) && $years_t > 1) {

              $whole = floor($years_t);

              $months = round($total_months % 12);

              $years_t = $whole . ' yrs & ' . $months . ' months';
            } else if (is_float($years_t) && $years_t < 1) {
              if ($total_months < 12) {
                $months = $total_months;
              }
              $years_t = $months . ' months';
            } else {

              $years_t = $years_t . ' yrs';
            }
          ?>



            <div class="box">

              <div class="box-inner">

                <h3><?php echo str_replace("\'", "'", $experience['company'][$i]); ?></h3>

                <p> <?php echo str_replace("\'", "'", $experience['exp_title'][$i]); ?></p>

                <p> <?php echo str_replace("\'", "'", $experience['city'][$i]); ?>, <?php echo str_replace("\'", "'", $experience['state'][$i]); ?></p>

                <span><?php echo $month_name = date("F", mktime(0, 0, 0, (int) $experience['start_month'][$i], 10)); ?> <?php echo $experience['start_year'][$i]; ?> - <?php if ($experience['end_month'][$i] == '') {

                                                                                                                                                                    echo 'Present';
                                                                                                                                                                  } else {

                                                                                                                                                                    echo   date("F", mktime(0, 0, 0, (int) $experience['end_month'][$i], 10));
                                                                                                                                                                  } ?> <?php echo $experience['end_year'][$i]; ?></span> <span class="year"> - <?php echo $years_t; ?></span>



              </div>

            </div>

          <?php

          }

          ?>

        </div>

      </div>

    <?php

    }

    ?>

    <?php

    if (is_array($education) && count($education) > 0) {

    ?>

      <div class="profile-container Montserrat">

        <div class="education-wrapper">

          <div class="heading">

            <h2>EDUCATION</h2>

          </div>

        </div>

        <div class="box-wrapper">

          <?php

          for ($i = 0; $i < count($education['degree_title']); $i++) {

          ?>

            <div class="box">

              <h3><?php echo str_replace("\'", "'", $education['school'][$i]); ?></h3>

              <p><?php echo str_replace("\'", "'", $education['degree_title'][$i]); ?></p>

              <span><?php echo date('F Y', strtotime($education['grad_date'][$i])) ?></span>



            </div>

          <?php

          }

          ?>

        </div>

      </div>

    <?php

    }

    ?>





    <!-- <div class="profile-container Montserrat">

      <div class="education-wrapper">

        <div class="heading">

          <h2>EDUCATION</h2>

        </div>

      </div>

      <div class="box-wrapper">

        <div class="box">

          <h3>Dental Solutions</h3>

          <p>Lahore, Punjab, Pakistan</p>

          <span>Jan 2017- present</span> <span class="year">- 5 yrs</span>

        </div>

        <div class="box">

          <h3>University Of Punjab</h3>

          <p>BS Computer Science</p>

          <span>2002 - 2004</span>

        </div>

        <div class="box">

          <h3>Dental Solutions</h3>

          <p>Lahore, Punjab, Pakistan</p>

          <span>Jan 2005 - Jan 2007</span>

        </div>

      </div>

    </div> -->

    <?php $articless = sbr_articles_callback('listing', 0, $user_id)['articles'];
         global $wpdb;

         $my_publications = $wpdb->get_results(
           $wpdb->prepare(
             "SELECT * FROM wp_rdh_publications WHERE user_id = %d",
             $user_id
           )
         );

    if ($articless != '<div class="no-article"><h6>No Article found</h6></div>' || count($my_publications)>0) { ?>
    <style>
        .no-article {
        display:none;
        }
    </style>
      <div class="profile-container Montserrat">

        <div class="article-wrapper">

          <div class="heading">

            <h2>MY PUBLICATIONS</h2>

          </div>

        </div>



        <div class="article-content-wrapper">

          <div class="articles-wrapper">

            <?php print_r($articless); ?>
                    <?php
                   
                    $user_info = get_userdata($user_id);
                      $username = $user_info->user_login;
                      $first_name = $user_info->first_name;
                      $last_name = $user_info->last_name;
                     
                      $rdhTitle = get_field('rdh_titleline', 'user_' . $user_id);
                            if ($rdhTitle) {
                                $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
                            }
                            $author_name = $first_name.' '.$last_name.$rdhTitle;
                    $html ='';
                    if(is_array($my_publications) && count($my_publications)>0) {
                        $categories = get_categories();
                        $related_categories = array();
                        foreach($categories as $category) {
                          //  echo $category->slug.'=>'.$category->name.'<br />';
                            $related_categories[$category->slug] = $category->name;
                        }
                        
                        foreach($my_publications as $pub) {
                          
                            $category_name = isset($related_categories[$pub->pub_category]) ? $related_categories[$pub->pub_category]:$pub->pub_category;
                            $final_image = 'LOGO-RDHC-default.jpg';
                            if (str_contains($pub->publication_publisher, 'Magazine')) { 
                                $final_image = 'LOGO-RDH-mag-purple.jpg';
                            }
                            if (str_contains($pub->publication_publisher, 'Dentistry')) { 
                                $final_image = 'LOGO-dentistyIQ.jpg';
                            }
                            if (str_contains($pub->publication_publisher, 'Todays')) { 
                                $final_image = 'LOGO-todays-rdh.jpg';
                            }
                            if (str_contains($pub->publication_publisher, 'Inside')) { 
                                $final_image = 'LOGO-inside-dental-hygiene.jpg';
                            }
                            if (str_contains($pub->publication_publisher, 'Dimensions')) { 
                                $final_image = 'LOGO-dimensions-of-dental-hygiene.jpg';
                            }
                            if($pub->pub_authorName!='') {
                                $author_name_updated = $author_name.'<br />'.stripslashes($pub->pub_authorName);
                            }
                            else{
                              $author_name_updated = $author_name;
                            }
                            if($pub->publication_publisher)
                            $html .='<div class="card">
                        <a href="'.$pub->pub_url.'rel=nofollow">
                            <div class="card-img">
                                <img src="'.get_stylesheet_directory_uri().'/assets/images/rdh-article-thumbnail/'.$final_image.'" >
                
                            </div>
                            <div class="card-details">
                                <div class="">
                                    <small>'.stripslashes($category_name).'</small>
                                </div>
                                <div class="card-title">
                                    <h2>'.stripslashes($pub->pub_title).'</h2>
                                </div>
                                
                                </a>
                                <div class="description mbtDescriptionRow">
                                <div class="description">
                                    <p>'.stripslashes($pub->pub_description).'</p>
                                    <p class="author">By: '.stripslashes($author_name_updated).'</span></p>
                                </div>
                                    <div class="action_buttons_mbt">
                                    <div class="buttonRow_inner">
                                        <a class="readmore" href="'.$pub->pub_url.'?rel=nofollow" class="readmoreButton">    
                                            READ MORE
                                        </a>                   
                                    </div> 
                                    
                                    </div>
                                </div>
                            </div>
                       
                    </div>';
                           
                          
                        }

                    }
                    echo $html;
                    ?>


          </div>

        </div>

      </div>

    <?php } ?>

  </div>

</div>

<!--modal popup-->

<script>
  $('.modal-toggle').on('click', function(e) {

    e.preventDefault();

    $('.modal').toggleClass('is-visible');

  });
</script>

<!--user profile main section end-->

<?php



// }

if (strpos($_SERVER['REQUEST_URI'], 'rdh/products') !== false) {

?>

  <script>
    jQuery(document).ready(function() {

      jQuery("#reco-active").addClass('active');



    });
  </script>

<?php

} else if (strpos($_SERVER['REQUEST_URI'], 'rdh/profile') !== false) {

?>

  <script>
    jQuery(document).ready(function() {

      jQuery("#profile-active").addClass('active');



    });
  </script>

<?php

} else if (strpos($_SERVER['REQUEST_URI'], 'rdh/contact') !== false) {

?>

  <script>
    jQuery(document).ready(function() {

      jQuery("#contact-active").addClass('active');



    });
  </script>

<?php



}



get_footer('rdhprofile'); ?>

<script>
  $(document).ready(function() {

    $('.burgerNav').click(function() {

      // $(this).toggleClass('open');

      // $(this).parent('.nav-men-wrapper').toggleClass('open-navigation');



    });

  });







  if ($('#list_items_mbt li').size() <= 2) {

    $(".tabsSectionrdhSec .list-items").addClass('listItemSmall');

  } else {

    $(".tabsSectionrdhSec .list-items").removeClass('listItemSmall');

  }

  jQuery(document).on('click', '#list_items_mbt li a', function() {

    jQuery('#list_items_mbt li a').removeClass('active');

    jQuery(this).addClass('active');

    show_hide_tabs_rdh();

    window.history.pushState({}, '', jQuery(this).attr('data-href-cust'));

  });

  jQuery(document).ready(function() {

    show_hide_tabs_rdh();

  });

  function show_hide_tabs_rdh() {

    if (jQuery('#profile-active').hasClass('active')) {

      jQuery('.rdhtabs').hide();

      jQuery('.profile-container-all').show();

      jQuery("body").addClass('active-profile-tab');

      jQuery("body").removeClass('active-recomendation-tab');

      jQuery("body").removeClass('active-contact-tab');

    }

    if (jQuery('#reco-active').hasClass('active')) {

      jQuery('.rdhtabs').hide();

      jQuery('.profile-container.sale-page').show();

      jQuery("body").addClass('active-recomendation-tab');

      jQuery("body").removeClass('active-profile-tab');

      jQuery("body").removeClass('active-contact-tab');

    }

    if (jQuery('#contact-active').hasClass('active')) {

      jQuery('.rdhtabs').hide();

      jQuery('.contactMessagesMbt').show();

      jQuery("body").addClass('active-contact-tab');

      jQuery("body").removeClass('active-recomendation-tab');

      jQuery("body").removeClass('active-profile-tab');

    }

  }




  jQuery(document).on('click', '.packageheader  a.iconCloseBox', function() {
    jQuery(this).parents(".selectPackageWrapper").removeClass('openPackage');
});


// option for multiple package

jQuery(document).on('click', '.selectpackageButton  button', function() {
    jQuery(".selectPackageWrapper").removeClass('openPackage');
    jQuery(this).parents(".selectPackageWrapper").addClass('openPackage');

});
// remove class outsideClick
jQuery(document).click(function(event) {
    if (!jQuery(event.target).closest('.selectPackageWrapper').length) {
        jQuery('.openPackage').removeClass('openPackage');
    }
});



// option for Quantity Box

jQuery(document).on('click', '.openQuantityBox  button', function() {

    jQuery(".product-selection-description-parent-inner").removeClass('openPackage-quantity');
    jQuery(this).parents(".product-selection-description-parent-inner").addClass('openPackage-quantity');
});
jQuery(document).on('click', '.packageQuantityBox  a.iconCloseBox', function() {
    jQuery(this).parents(".product-selection-description-parent-inner").removeClass('openPackage-quantity');
});

// remove class outsideClick
jQuery(document).click(function(event) {
    if (!jQuery(event.target).closest('.product-selection-description-parent-inner').length) {
        jQuery('.openPackage-quantity').removeClass('openPackage-quantity');
    }
});


jQuery('.lander-shortcode').each(function() {
    jQuery(this).parents('.wpb_column').addClass('landing-product');

});


/*For total*/
jQuery(document).ready(function() {
    jQuery(document).on('click','.select-a-package',function(){
        jQuery(this).parents('.product-selection-box').find('.pacakge_selected_data:last').prop( "checked", true ).trigger('click');
    });
    jQuery("input[name='fav_language']").click(function(){
    selected_product_id = jQuery(this).attr('data-pid');
    av_price = jQuery(this).attr('data-avr-price');
    var rdh_sale_price = $(this).attr('data-rdh_sale_price');
    if (typeof rdh_sale_price !== 'undefined' && rdh_sale_price !== false && rdh_sale_price!='' && rdh_sale_price>0) {
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-rdh_sale_price',rdh_sale_price);
    }
    else{
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-rdh_sale_price');
    }
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id',selected_product_id);
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href','?add-to-cart='+selected_product_id);
    if(av_price!='') {
      jQuery(this).parents('.product-selection-box').find('.normalyAmount').show();
      jQuery(this).parents('.product-selection-box').find('.targeted_avr').html(av_price);
    }
    else{
      jQuery(this).parents('.product-selection-box').find('.normalyAmount').hide();
    }
    jQuery(this).parents('.product-selection-box').find('.packageAmount').text(jQuery(this).attr('data-price'));


});
jQuery(document).find('.qty-update').change(function(){
    //
})


jQuery(document).on("change", ".quantity", function() {
    console.log('changed-val');
    selected_product_id = jQuery(this).attr('data-pid');
    console.log(jQuery(this).val());
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id',selected_product_id);
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href','?add-to-cart='+selected_product_id);
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-quantity',jQuery(this).val());
    })
    jQuery(".selectquantitybtn").click(function(){
        jQuery(this).parents('.product-selection-box').find('.quantity').trigger('change');
    });
    })


    // check child element then add class to parents
    jQuery(".productLandingPageContainer .wpb_row.row-fluid").each(function() {
        var childrenCount = $(this).children().length;
        jQuery(this).addClass("childrenBox-" + childrenCount);
    });



</script>