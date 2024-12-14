<?php


require(get_stylesheet_directory() . '/inc/rdh-info.php');
wp_enqueue_style('sweetalert2', plugins_url('smile-brilliant/assets/css/') . 'sweetalert2.css?v=' . $version, false);
wp_enqueue_script('sweetalert2', plugins_url('smile-brilliant/assets/js/') . 'sweetalert2.js?v=' . $version, '1.0.0', true);


global $wpdb;
$current_user = wp_get_current_user();
$useremail = $current_user->user_email;
$field_value = bp_get_profile_field_data(array(
  'field' => 'Referral',
  'user_id' => get_current_user_id(),

));

$user_idd = bp_core_get_userid(bp_core_get_username(get_current_user_id()));
$useremail = $current_user->user_email;
if (!$user_idd || $user_idd == '') {
  $linkslug = $wpdb->get_var("SELECT user_login FROM wp_users WHERE user_nicename = '" . bp_core_get_username(get_current_user_id()) . "'");
} else {
  $linkslug = bp_core_get_username(get_current_user_id());
}
$copylinkslug = bp_core_get_username($user_id);
if (is_user_logged_in() && get_current_user_id() == $user_id) {
  $linkslug = $current_user->user_nicename;
  $copylinkslug = $linkslug;
}


/*
if (is_user_logged_in() && get_current_user_id() == $user_id) {
  $copylinkslug = bp_core_get_username(get_current_user_id());
} else {
  $copylinkslug = bp_core_get_username($user_id);
}
*/
?>

<!doctype html>

<html <?php language_attributes(); ?>>



<head>

  <meta charset="<?php bloginfo('charset'); ?>" />

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
  <meta name="color-scheme" content="light only" />
    <meta name="supported-color-schemes" content="light" />
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <meta name="google-site-verification" content="dDdWeexBGoa81nhp6EOYjALxzvQQwHllqZAXFnSY4bM" />

  <meta name="facebook-domain-verification" content="4eqw7wferl6j9egl8p8wp3x0axo0f2" />
  <link rel="canonical" href="<?php echo esc_url( get_permalink() ); ?>" />


  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/products') !== false) {
    $meta_description = get_the_author_meta('description', $user_id);
    if ($meta_description == '') {
      $product_meta_description = 'See oral care products recommended by ' . $user_firstname . ' ' . $user_lastname;
    }
  ?>
    <title>Oral Care products recommended by <?php echo $user_firstname . ' ' . $user_lastname; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">

  <?Php } ?>

  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/profile') !== false) { ?>

    <title><?php echo $user_firstname . ' ' . $user_lastname; ?> - Dental Hygienist | RDH Connect™</title>
    <meta name="description" content="<?php echo $user_firstname . ' ' . $user_lastname; ?> RDH is a RDH Connect™ member based in <?php echo $address_town_city . ', ' . $address_state; ?>. See <?php echo $user_firstname ?>'s profile, publications, and product recommendations here!">
  <?Php } ?>

  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/contact') !== false) { ?>
    <title><?php echo $user_firstname . ' ' . $user_lastname; ?> RDH - <?php echo $address_town_city . ', ' . $address_state; ?>  Contact Info</title>
    <meta name="description" content="Have oral care questions for a registered dental hygienist? Contact  <?php echo $user_firstname . ' ' . $user_lastname; ?> RDH">
  <?Php } ?>

  <meta name="keywords" content="<?php echo $user_firstname . ' ' . $user_lastname; ?> RDH, <?php echo $user_firstname . ' ' . $user_lastname . ' ' . $address_town_city . ' ' . $address_state; ?> Best oral care products">
  <meta name="author" content="<?php echo $user_firstname . ' ' . $user_lastname; ?>">
  <meta property="og:image" content="<?php echo home_url(); ?>/wp-content/themes/revolution-child/assets/images/rdh-share.png" />

  <!-- Podcorn -->

  <?php

  $enable_google_optimize = get_field('enable_service', 'option');

  //  if ($enable_google_optimize) {

  echo '<script src="https://www.googleoptimize.com/optimize.js?id=OPT-574SN2W"></script>';

  // }

  ?>



  <script>
    // (function(w, d, s, l, i) {

    //   w[l] = w[l] || [];



    //   function podcorn() {

    //     w[l].push(arguments);

    //   };

    //   podcorn('js', new Date());

    //   podcorn('config', i);

    //   var f = d.getElementsByTagName(s)[0],

    //     j = d.createElement(s);

    //   j.async = true;

    //   j.src = 'https://behaviour.podcorn.com/js/app.js?id=' + i;

    //   f.parentNode.insertBefore(j, f);

    // })(window, document, 'script', 'podcornDataLayer', 'cf9e577f-9296-448a-aaeb-0a3e2cd9b4f6');
  </script>

  <script>
    (function(w, d, t, r, u) {

      var f, n, i;

      w[u] = w[u] || [], f = function() {

          var o = {

            ti: "175001323"

          };

          o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")

        },

        n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function() {

          var s = this.readyState;

          s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)

        },

        i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i)

    })

    (window, document, "script", "//bat.bing.com/bat.js", "uetq");
  </script>

  <!-- End Podcorn -->

  <?php

  /*

      <script src="https://www.googleoptimize.com/optimize.js?id=OPT-574SN2W" onerror="window.GoogleOptimizeError = true"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/googleOptimize.js?v=<?php echo time(); ?>"></script>





         * Always have wp_head() just before the closing </head>

         * tag of your theme, or you will break many plugins, which

         * generally use this hook to add elements to <head> such

         * as styles, scripts, and meta tags.

         */

  wp_head();
  //Socket_Script_info();
  ?>

  <?php if (isset($_GET['utm_campaign']) && isset($_GET['utm_medium'])) {

  ?>

    <script>
      jQuery(document).ready(function() {

        current_url = window.location.href;

        if (current_url.includes("#addshoppers___utm_enable")) {

          new_url = current_url.replace("#", "&");

          window.location.href = new_url;

        }

      });
    </script>

  <?php

  }

  ?>

  <!-- Global site tag (gtag.js) - Google Ads: 991526735 -->

  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-991526735"></script>

  <script>
    window.dataLayer = window.dataLayer || [];



    function gtag() {

      dataLayer.push(arguments);

    }

    gtag('js', new Date());



    gtag('config', 'AW-991526735');
  </script>



  <script type="text/javascript">
    var AddShoppersWidgetOptions = {

      'loadCss': false,

      'pushResponse': false

    };

    (! function() {

      var t = document.createElement("script");

      t.type = "text/javascript",

        t.async = !0,

        t.id = "AddShoppers",

        t.src = "https://shop.pe/widget/widget_async.js#5c617c03bbddbd44eae72714",

        document.getElementsByTagName("head")[0].appendChild(t)

    }());
  </script>

  <!-- slick slider -->

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css" type="text/css" media="screen" /> -->

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



    @media screen and (max-width: 767px) {
      html body .contentOverlayMenu {
        height: 100%;
      }

      .profile .buddypress-wrap .item-body {
        margin: 0px 0;
      }


      

    }
  </style>



  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/smile-brilliant-styles.css?ver=1.3.4117" type="text/css" media="screen" />

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/custom-styles.css?ver=1.1.1.1.14" type="text/css" media="screen" />

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/media-query.css?ver=1.1.1.18875" type="text/css" media="screen" />
  <style>
    body {
      padding-top: 0px !important;
    }

    .mobile-toggle-holder.style1,
    #sale-header-orange {
      /* display: none !important; */
    }

    .secondary-area #quick_cart:before {
      font: normal normal normal 32px/1 FontAwesome;
    }

    #quick_cart {
      margin-left: 0px;
    }

    .secondary-area-mbt,
    .user-login {
      margin-top: 0px;
      min-height: 0;
    }

    .secondary-area-mbt {
      position: absolute;
      right: 64px;
      top: -5px;
    }

    .secondary-area-mbt:hover,
    .secondary-area-mbt:hover+.user-login {
      border-top: 3px solid transparent;
    }

    #quick_cart {
      margin-right: 0px;
    }


    nav#side-cart.animatedSideBar {
      transform: translate(0px, 0px) !important;
    }

    .side-panel header .thb-mobile-close {
      transform: translate(0px, 0px) !important;
    }

    .widget.widget_shopping_cart .product_list_widget li {
      transform: translate(0px, 0px) !important;
      opacity: 1 !important;
    }

    .profile-container-wrapper .profile-container .headingSectionTop {
      font-size: 24px;
      margin-bottom: 20px;
      color: #282828;
      font-weight: 400;

    }

    .sale-page.rdhtabs .headingSectionTop {
      margin-top: 0px;
      color: #282828;
      font-weight: 400;
    }

    .profile-container {
      max-width: 1420px;
      width: 100%;
    }

    @media screen and (min-width: 768px) {
      .contactMessagesMbt .headingSectionTop {
        padding-left: 50px;
      }

    }

    @media screen and (max-width: 767px) {


      .profile-container-wrapper .profile-container .headingSectionTop {
        font-size: 18px;
        margin-bottom: 20px;

      }

      .sale-page.rdhtabs .headingSectionTop {
        margin-top: 20px;
      }

      .profile-container-wrapper .contactMessagesMbt {
        margin-top: 20px;
      }

      .secondary-area #quick_cart:before {
        font: normal normal normal 24px/1 FontAwesome;
      }

      .secondary-area-mbt {
        right: 44px;
      }

    }


    
  </style>


  <!-- End of smilebrilliant Zendesk Widget script -->

</head>



<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <?php do_action('thb_before_wrapper'); ?>

  <!-- Start Wrapper -->

  <div id="wrapper" class="thb-page-transition-<?php echo esc_attr(ot_get_option('page_transition', 'on')); ?>">



    <!-- Start Sub-Header -->

    <?php

    if (ot_get_option('subheader', 'off') === 'on') {

      get_template_part('inc/templates/header/subheader-' . ot_get_option('subheader_style', 'style1'));
    }

    ?>

    <!-- End Sub-Header -->



    <?php get_template_part('inc/templates/header/' . ot_get_option('header_style', 'style1')); ?>

    <?php //echo do_shortcode('[trustindex no-registration=google]');

    ?>

    <div role="main">

<?php
$current_url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if((is_user_logged_in() && strpos($current_url, "support") == false && strpos($current_url, "my-account") !== false) ||(is_user_logged_in() && strpos($current_url, "support") == false && strpos($current_url, "/profile/edit") !== false)){?>
    <div id="chat-circle">
      <a href="/my-account/support/?active-tab=chat">
        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chat_talk.svg" />
      </a>
      <div id="totalunreadmessages"></div>
    <?php } ?>
  
  </div>

  



      <div class="user-profile-hero rdhHeaderWrapper">

      <style>
				body.page-id-192 #wrapper div[role="main"] {
           padding-top: 0px;
        }      
    </style>

        <div class="profile-container">

          <div class="nav-men-wrapper" id="flyout-example">
          

        <div class="rowMbtParent notificationAllUnique">
          <div class="rowMbt libellNotification">
            <div class="bellNotification">
              <div class="bellWrapper">
                <a href="javascript:;" class="notificationAnchor navLink bellanimate">
                    <i class="fa fa-bell" aria-hidden="true"></i><span class="notificationCounter">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notificationCenter">
                <a class="hidden-desktop close" href="JavaScript:void(0);"><span>×</span></a>
                <div class="dropdownHeader">Notification</div>
                  <div id="DZ_W_Notification1" class="widget-media dz-scroll">
                      <ul class="timeline">
                      
                      </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

         

          <div class="rowMbt secondary-area-mbt">
            <div class="secondary-area-mbt">

              <div id="quick_cartt">

                <a rel="nofollow" id="dropdownMenuCart">

                  <i class="fa fa-shopping-cart fa-lg"></i>

                  <span class="float_count"></span>

                </a>

              </div>

              <?php

              if (!is_checkout()) {

                //                    woocommerce_mini_cart();

              }



              do_action('thb_secondary_area');

              ?>



            </div>
          </div>

          <div class="rowMbt rowMenuRdhConnect">
            <div id="nav-menu" class="burgerNav dddd">
              <span class="menu-loginIcon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
              <span></span>

              <span></span>

              <span></span>

              <span></span>

              <span></span>

              <span></span>

            </div>



            <div class="navigation-menu-body" style="display:none;">

              <div class="dropdown-wrapper">

                <div class="dropdownHeader">

                  RDH Connect

                </div>

                <div class="navigation-nav-item">

                  <ul id="contentThatFades">

                    <?php if (is_user_logged_in()) {



                      // echo 'logged in id is'.get_current_user_id();
                      if (get_current_user_id() == $user_id) {
                        ///  if ($field_value != '') {

                        echo '<li class="edit-account-list order-2">

                        <a href="/members/' . bp_core_get_username($user_id) . '/profile/edit/group/1">

                          <div class="flex-div">

                            <div class="navigatio-icon">

                            <span class="circleShapedIconParent">

                              <span class="circleShapedIcon">

                                <i class="fa fa-user" aria-hidden="true"></i>

                              </span>

                              </span>

                            </div>

                            <div class="navigation-text">

                              <div class="navigation-top-text uppercase">

                                Edit Public  Profile

                              </div>

                              <div class="navigation-small-text">

                                 Manage and edit name or email

                              </div>

                            </div>

                          </div>

                        </a>

                      </li>';
                      }


                      echo '<li class="rdh-home-page order-1">

         <a href="/my-account/" >
         <div class="flex-div">
         <div class="navigatio-icon smilebrilliant-logo rdh-logo-menu">
            <span class="circleShapedIconParent">
              <span class="circleShapedIcon">
                <img src="https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/myaccount/RDH.svg" class="sbrlogo" alt="Smile Brilliant">
            </span>
            </span>
         </div>
         <div class="navigation-text">
           <div class="navigation-top-text uppercase">
           RDHC  Home
           </div>
           <div class="navigation-small-text">
               Manage your RDHC public profile
           </div>
         </div>

       </div>

         </a>

     </li>';


                      echo '<li class="edit-account-list order-4">

              <a href="' . get_home_url() . '" >

              <div class="flex-div">

              <div class="navigatio-icon smilebrilliant-logo">

                <img src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png" class="sbrlogo" alt="Smile Brilliant">

              </div>

              <div class="navigation-text">

                <div class="navigation-top-text uppercase">

                  Smile brilliant Home

                </div>

                <div class="navigation-small-text">

                  Personalized Oral Care Products

                </div>



              </div>

            </div>

              </a>

          </li>';

                      echo '<li class="edit-account-list order-3">

              <a href="' . esc_url(wc_logout_url()) . '" >

              <div class="flex-div">

              <div class="navigatio-icon">

              <span class="circleShapedIconParent">

                <span class="circleShapedIcon">

                <i class="fa fa-sign-out" aria-hidden="true"></i>

                </span>

                </span>

              </div>

              <div class="navigation-text">

                <div class="navigation-top-text uppercase">

                    Log Out

                </div>

                <div class="navigation-small-text" >

                     RDH member Log Out

                </div>

              </div>

            </div>

              </a>

          </li>';
                    } else {

                    ?>

                      <li>

                        <a href="<?php echo get_home_url(); ?>/my-account/">

                          <div class="flex-div">

                            <div class="navigatio-icon">

                              <i class="fa fa-user-o" aria-hidden="true"></i>

                            </div>

                            <div class="navigation-text">

                              <div class="navigation-top-text uppercase">

                                Member Login

                              </div>

                              <div class="navigation-small-text">

                                Existing RDH member login

                              </div>

                            </div>

                          </div>

                        </a>

                      </li>



                      <li>

                        <a href="<?php echo get_home_url(); ?>/rdh/">

                          <div class="flex-div">

                            <div class="navigatio-icon rdh-connect-logo">

                              <img class="connect-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rdh-profile/RDH-logo.svg" alt="" />

                            </div>

                            <div class="navigation-text">

                              <div class="navigation-top-text uppercase">

                                RDH Connect Home

                              </div>

                              <div class="navigation-small-text">

                                Learn about RDH Connect

                              </div>



                            </div>

                          </div>

                        </a>

                      </li>



                      <li>

                        <a href="<?php echo get_home_url(); ?>">

                          <div class="flex-div">

                            <div class="navigatio-icon smilebrilliant-logo">

                              <img src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png" class="sbrlogo" alt="Smile Brilliant">

                            </div>

                            <div class="navigation-text">

                              <div class="navigation-top-text uppercase">

                                Smile brilliant Home

                              </div>

                              <div class="navigation-small-text">

                                Personalized Oral Care Products

                              </div>



                            </div>

                          </div>

                        </a>

                      </li>

                    <?php } ?>



                  </ul>



                </div>

              </div>

            </div>

          </div>

          </div>

          </div>



          <div class="user-profile-header">

            <div class="profile-image">
              <div class="user-img">

                <a class="addEditPhoto" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/change-avatar"; ?>">
                  <div class="editOverlay">
                    <i class="fa fa-pencil" aria-hidden="true"></i><span> edit photo</span>
                  </div>
                </a>

                <img src="<?php

                          echo bp_core_fetch_avatar(

                            array(

                              'item_id' => $user_id, // id of user for desired avatar

                              'type'    => 'full',

                              'html'   => FALSE     // FALSE = return url, TRUE (default) = return img html

                            )

                          );

                          ?>" alt="" />

              </div>

              <div class="border-img">

                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/border-round.png" alt="" srcset="">

              </div>

            </div>





            <div class="rdh-profile-top-section">

              <div class="row-mbt">
                <div class="rdh-logo">
                  <img class="desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rdh-profile/RDH-logo.svg" alt="" />
                </div>
                <div class="rdh-publick-profile-link hidden-mobile" style="display:none">
                  <a class="viewPublickProfileAnchor-t" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
                    </span> View public profile</a>
                </div>

              </div>

              <div class="profile-detail Montserrat ">

                <h1 class="font-mont"><?php echo $user_firstname; ?> <?php echo $user_lastname; ?> <span class="RDHdisplayName">RDH</span>

                  <?php
                  echo '<span class="checkbMark">';
                  $icon = 'verified_icon_blue';
                  //    echo $user_id;
                  if (in_array($user_id, array(149484, 114131, 149487, 149480))) {
                    $icon = 'verified_icon_pink';
                  }
                  echo '<img class="iconVerificed" src="' . get_stylesheet_directory_uri() . '/assets/images/' . $icon . '.svg" alt="" />';
                  echo '</span>';

                  ?>


                </h1>

                <p class="designation"> <?php echo $rdh_subtitle; ?></p>

                <div class="address">
                  <p class="font-mont"><?php echo $address_town_city; ?>, <?php echo $address_state; ?>, <?php echo $address_country;?></p>
                </div>
                <div class="rdh-publick-profile-link copyLinkToClickBoards show_after_logged hidden-mobile">

                  <?php
                  /*
                     <a class="viewPublickProfileAnchor-t hide-on--all-profile-pages" target="_blank" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>"> <span> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </span> Edit profile</a>
                    */
                  if (is_user_logged_in() && get_current_user_id() == $user_id) {
                  ?>
                    <a class="viewPublickProfileAnchor-t hide-on--all-profile-pages" target="_blank" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>"> <span> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </span> Edit profile</a>
                  <?php
                  }
                  ?>

                  <a class="viewPublickProfileAnchor-t hide-on-public-profile" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
                    </span> View public profile</a>

                  <!-- <a target="_blank" class="copy_text viewPublickProfileAnchor" data-toggle="tooltip" title="URL copied" href="<?php //echo get_home_url();
                                                                                                                                    ?>/rdh/profile/<?php //echo  $linkslug;
                                                                                                                                                    ?>"> <span> <i class="fa fa-clipboard" aria-hidden="true"></i>
                    </span>Copy</a> -->

                  <span class="viewPublickProfileAnchor clickToclipBoard">
                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                    <button onclick="copyToClipboard('<?php echo get_home_url(); ?>/rdh/profile/<?php echo  $copylinkslug; ?>') ? this.innerText='Copied!': this.innerText='Sorry :(' ">Copy</button>
                  </span>


                </div>
              </div>
            </div>
          </div>

          <div class="rdh-publick-profile-link copyLinkToClickBoards show_after_logged hidden-desktop">

            <a class="viewPublickProfileAnchor-t hide-on-public-profile" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
              </span> View public profile</a>
            <?php

            if (is_user_logged_in() && get_current_user_id() == $user_id) {
            ?>
              <a class="viewPublickProfileAnchor-t hide-on--all-profile-pages" target="_blank" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>"> <span> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </span> Edit profile</a>
            <?php
            }
            /*
 <a class="viewPublickProfileAnchor-t hide-on--all-profile-pages" target="_blank" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>"> <span> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </span> Edit profile</a>
*/
            ?>
            <span class="viewPublickProfileAnchor clickToclipBoard">
              <i class="fa fa-clipboard" aria-hidden="true"></i>
              <button onclick="copyToClipboard('<?php echo get_home_url(); ?>/rdh/profile/<?php echo  $copylinkslug; ?>') ? this.innerText='Copied!': this.innerText='Sorry :(' ">Copy</button>
            </span>


          </div>




        </div>

        <script>
          $(document).ready(function() {
            $('.selectquantitybtn').click(function() {
              var price = $(this).attr('data-price');
              console.log(price);
              //$(this).parents('.product-selection-box').find('.price-display').text(price);
            });

            $('.plus-btn').click(function() {
              var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
              quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
              updatePrice($(this).parents('.product-selection-box').find('.box'));
            });

            $('.minus-btn').click(function() {
              var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
              var decrementedValue = parseFloat(quantity.val()) - 1;
              if (decrementedValue >= 1) {
                quantity.val(decrementedValue).trigger('change');
                updatePrice($(this).parents('.product-selection-box').find('.box'));
              }
            });





          });

          function updatePrice(box) {
            var price = box.parents('.product-selection-box').find('.selectquantitybtn').attr('data-price');
            console.log(price);
            var quantity = box.find('.quantity').val();
            var total = parseFloat(price) * parseFloat(quantity);
            total = total.toFixed(2);
            box.find('.price-display').text(total);
          }







          jQuery(document).ready(function() {

            if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
              jQuery('.secondary-area-mbt').hide();
            }
          });
          jQuery(document).ajaxComplete(function(event, xhr, settings) {
            if (typeof settings !== 'undefined' && typeof settings.data !== 'undefined') {
            if (settings.data.includes("product_id")) {
              if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
                jQuery('.secondary-area-mbt').hide();
              } else {
                jQuery('.secondary-area-mbt').show();
              }
            }
          }
          });
        </script>
        <script>
          function archiveFunction(rdh_id) {

            Swal.fire({
              title: 'Are you sure?',
              html: 'You will not be able to recover this publication!',
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              preConfirm: (login) => {
                return fetch('<?php echo admin_url("admin-ajax.php"); ?>?pub_id=' + rdh_id + '&action=delete_rdh_publications')
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                    return response.json()
                  })
                  .catch(error => {
                    Swal.showValidationMessage(
                      `Request failed: ${error}`
                    )
                  })
              },
              allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {

              if (result.isConfirmed) {
                if (result.value.statusText == 'success') {
                  Swal.fire({
                    title: ' Publication is Deleted',
                  })
                  load_existig_publications('<?php echo get_current_user_id(); ?>');
                } else {
                  Swal.fire({
                    title: 'Smething went wrong',
                  })
                }

              }
            })
          }
        </script>


      </div>