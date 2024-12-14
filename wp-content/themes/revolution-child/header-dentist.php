<?php


require (get_stylesheet_directory() . '/inc/dentist-info.php');
wp_enqueue_style('sweetalert2', plugins_url('smile-brilliant/assets/css/') . 'sweetalert2.css?v=' . $version, false);
wp_enqueue_script('sweetalert2', plugins_url('smile-brilliant/assets/js/') . 'sweetalert2.js?v=' . $version, '1.0.0', true);


global $wpdb;
$current_user = wp_get_current_user();
$useremail = $current_user->user_email;
global $dentistmessage;
if (function_exists('bp_version')) {
  if (get_query_var('dentist_name') != false && get_query_var('dentist_name') != '') {
    $field_value = bp_get_profile_field_data(
      array(
        'field' => 'Referral',
        'user_id' => get_current_user_id(),

      )
    );

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
  }
}
// Define the base directory for the images
$base_dir = get_stylesheet_directory_uri() . '/assets/images/dentists/';

// Get the dentist's name from the query variable
$dentist_name = get_query_var('dentist_name');

// Construct the image path
$image_path = $base_dir . $dentist_name . '.png';

// Fallback image path
$fallback_image_path = $base_dir . 'sharing-icon.png';

// Check if the dentist-specific image exists
if (@getimagesize($image_path)) {
  $image_src = $image_path;
} else {
  $image_src = $fallback_image_path;
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

  <link rel="profile" href="http://gmpg.org/xfn/11">

  <meta name="google-site-verification" content="dDdWeexBGoa81nhp6EOYjALxzvQQwHllqZAXFnSY4bM" />

  <meta name="facebook-domain-verification" content="4eqw7wferl6j9egl8p8wp3x0axo0f2" />
  <link rel="canonical" href="<?php echo esc_url(home_url() . '/dentist/' . $dentist_name); ?>" />


  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/products') !== false) {
    $meta_description = get_the_author_meta('description', $user_id);
    if ($meta_description == '') {
      $product_meta_description = 'See oral care products recommended by Dr. ' . $user_firstname . ' ' . $user_lastname;
    }
    ?>
    <title>Oral Care products recommended by <?php echo $user_firstname . ' ' . $user_lastname; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">

  <?Php } ?>

  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/profile') !== false) { ?>

    <title><?php echo $user_firstname . ' ' . $user_lastname; ?> - <? $practice_name; ?></title>
    <meta name="description"
      content="Dr. <?php echo $user_firstname . ' ' . $user_lastname; ?>  is a Dentist based in <?php echo $address_town_city . ', ' . $address_state; ?>. See <?php echo $user_firstname ?>'s product recommendations here!">
  <?Php } ?>

  <?php if (strpos($_SERVER['REQUEST_URI'], 'rdh/contact') !== false) { ?>
    <title><?php echo $user_firstname . ' ' . $user_lastname; ?> - <? $practice_name; ?> -
      <?php echo $address_town_city . ', ' . $address_state; ?> Contact Info
    </title>
    <meta name="description"
      content="Have oral care questions? Contact <?php echo $user_firstname . ' ' . $user_lastname; ?> - <? $practice_name; ?>">
  <?Php } ?>

  <meta name="keywords"
    content="<?php echo $user_firstname . ' ' . $user_lastname; ?> <? $practice_name; ?>, <?php echo $user_firstname . ' ' . $user_lastname . ' ' . $address_town_city . ' ' . $address_state; ?> Best oral care products">
  <meta name="author" content="<?php echo $user_firstname . ' ' . $user_lastname; ?>">
  <meta property="og:image" content="<?php echo $image_src; ?>" />

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
    (function (w, d, t, r, u) {

      var f, n, i;

      w[u] = w[u] || [], f = function () {

        var o = {

          ti: "175001323"

        };

        o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")

      },

        n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function () {

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
      jQuery(document).ready(function () {

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

    (! function () {

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
    .geha-memeber-button {
      border-radius: 10px 10px 0 0;
    }

    html body .user-profile-hero:not(.no-bkground-required) {
      padding-top: 117px;
    }

    #reco-active {
      opacity: 0;
      visibility: hidden;
    }

    html body header#sbr-header {
      position: absolute;
      background: #ffffff !important;
      border-bottom: 1px solid #c5c6c9;
    }

    html body .burgerNav {
      height: 30px;
    }

    html body:not(.home) header#sbr-header {
      background: #fff0;
    }

    #sbr-header ul.nav.navbar-nav.navbar-right,
    ul.nav.navbar-nav.navbar-left {
      display: none !important;
    }

    .secondary-area-mbt.oneforDesktop {
      position: static;
    }

    header#sbr-header,
    .deal-top-bar,
    #friendbuyoverlaySite,
    header#mobile-header,
    iframe#launcher,
    #scroll_to_top {
      /* display: none !important; */
    }

    .header-spacer {
      height: 0px !important;
    }

    .floting-geha-button.floating-sharing-button {
      background: none;
    }

    .floting-geha-button.floating-sharing-button .geha-memeber-button {
      background-color: #00EA41;
      border-radius: 0;
      width: 100%;
    }

    .floting-geha-button.floating-sharing-button .geha-memeber-button a {
      display: flex;
      align-items: center;
      justify-content: center;
      column-gap: 11px;
      font-size: 16px;
      font-weight: 500;
      color: #000;
    }



    .floting-geha-button.floating-sharing-button .geha-memeber-button a i {
      font-size: 18px;
    }

    .floating-sharing-button.dentish-share-button-js {
      top: initial;
      bottom: 0;
      width: 100%;
    }

    .floating-sharing-button.dentish-share-button-js .geha-memeber-button {
      -webkit-transform: rotateZ(0deg);
    }

    html body.addPublicationModalPopup .modal.is-visible .modal-overlay {
      opacity: 0;
      visibility: hidden;
      transition-delay: 0s;
    }

    section.shopLanderPageHader .pageheaderBotm select,
    .resetFilter a {
      font-family: 'Open Sans', sans-serif;
    }

    .welcome-dr-link .navigation-text {
      max-width: 82%;
    }

    .phonenumber a {
      color: #797a7a;
      font-size: 14px;
      display: flex;
      margin-top: 6px;
    }

    .phonenumber a:hover {
      color: #1fb3e0;
    }

    .rdh-profile-top-section {
      padding-left: 75px;
    }

    html .elementor-kit-754129 .user-profile-hero {
      padding-bottom: 54px;
    }

    #sbr-header .secondary-area-mbt,
    #sbr-header .user-login {
      top: initial;
    }

    #product-list a.openpop.access-code-handler.view-pricing-button-css {
      min-width: 100%;
      min-width: 0;
    }





    @media screen and (max-width: 767px) {

      html body .contentOverlayMenu {
        height: 100%;
      }

      .profile .buddypress-wrap .item-body {
        margin: 0px 0;
      }

      #vipPage div#product-list.grid-changed .drtext {
        position: static;
      }

      #vipPage #product-list .landing-product:not(.medium-12) .product-selection-price-wrap,
      #vipPage #product-list .landing-product:not(.medium-12) .product-selection-price-wrap {
        padding-top: 0px;
      }

      .user-profile-hero .tabsSectionrdhSec ul li a.active {
        font-size: 16px;
      }

      #vipPage .user-profile-hero .tabsSectionrdhSec {
        border-bottom: 0px solid #13748d;
      }

      html .elementor-kit-754129 .user-profile-hero,
      section.shopLanderPageHader {
        padding-bottom: 0px !important;
      }

      #product-list:not(.grid-changed) .landing-product:not(.medium-6) .drtext {
        margin-bottom: 0px;
      }

      #product-list:not(.grid-changed) .product-selection-price-wrap {
        margin-top: 10px;
      }

      #vipPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
        justify-content: center;
      }

      .navigation-menu-body .flex-div {}

      .navigatio-icon.smilebrilliant-logo {
        text-align: center;
      }

      .user-profile-hero .navigation-menu-body .flex-div {
        flex-direction: column;
      }
    }
  </style>



  <link rel="stylesheet"
    href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/smile-brilliant-styles.css?ver=1.3.4117"
    type="text/css" media="screen" />

  <link rel="stylesheet"
    href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/custom-styles.css?ver=1.1.1.1.15231" type="text/css"
    media="screen" />

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/media-query.css?ver=1.1.1.18874"
    type="text/css" media="screen" />
  <style>
    body {
      padding-top: 0px !important;
    }

    .mobile-toggle-holder.style1,
    #sale-header-orange {
      display: none !important;
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
      width: 94%;
      max-width: 94%;
    }

    .profile-container .user-profile-header {
      max-width: 1420px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      padding-bottom: 0rem;
      justify-content: space-between;
    }

    .user-profile-header .profile-detail {
      /* margin-top: 1.5rem; */
    }

    .burgerNav span {
      background: #000000;
    }

    .share-profile-btn {
      background: #dd1f69;
      border-radius: 10px;
      font-weight: 400;
      font-size: 14px;
      padding: 6px 15px;
      color: #fff;
      display: flex;
      align-items: center;
      column-gap: 8px;
      min-width: 133px;
    }

    .floating-sharing-button {
      max-width: initial;
      z-index: 123;

    }

    .modal-body {
      padding: 1rem;
    }

    .addPublicationModalPopup .modal-content {
      max-height: initial;
      overflow-y: initial;
      padding: 0;
    }

    .share-with-icons {
      display: flex;
      flex-wrap: wrap;
      column-gap: 15px;
    }

    .share-with-icons a {
      border-radius: 50%;
      background-color: #fff;
      text-align: center;
      transition: .6s;
      box-shadow: 0 5px 4px rgba(0, 0, 0, .2);
      padding: 4px;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .share-with-icons a svg {
      height: 32px;
      width: 32px;
      fill: #1fb6e4;
    }

    .share-with-icons a.share-email svg {
      height: 30px;
    }

    .share-options label,
    .share-text {
      font-weight: 500;
      font-size: 14px;
      text-transform: uppercase;
      font-family: 'Montserrat';
    }

    .addPublicationModalPopup .modal-header {
      text-align: left;
      background: #e8f8fc;
    }

    .addPublicationModalPopup .modal-heading {
      font-size: 18px;
      line-height: 1;
    }

    .addPublicationModalPopup .modal-cross {
      border-radius: 85px;
      font-size: 25px;
      font-weight: 600;
      cursor: pointer;
      border: 0;
      background: none;
    }

    .addPublicationModalPopup .modal-close,
    .addPublicationModalPopup .modal-cross {
      padding: 0;
      top: 12px;
      right: 10px;
    }

    .addPublicationModalPopup .modal-close:hover,
    .addPublicationModalPopup .modal-cross:hover {
      color: #777;
    }

    .share-button-row .btn-primary-blue {
      font-size: 20px;
      background-color: #1fb6e4;
      border-color: #1fb6e4;
      border-radius: 5px;
      text-transform: uppercase;
      width: 100%;
      padding: 8px 10px;
      text-align: center;
      letter-spacing: 0;
      font-weight: 400;
      position: relative;
    }

    .share-button-row {
      margin-top: 20px;
    }


    #product-list .view-pricing-button-css,
    .buttons-popup-container a,
    button.emailshare--email-submit,
    button.tellshare--tel-submit {
      border: 2px solid;
      font-weight: 300;
      font-family: 'Montserrat';
      background-color: #1fb6e4;
      border-color: #1fb6e4;
      border-radius: 10px;
      position: relative;
      cursor: pointer;
      line-height: 20px;
      min-height: 53px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 20px;
      max-width: 290px;
      margin-left: auto;
      margin-right: auto;
      text-transform: capitalize;
      width: 100%;
      min-width: 239px;
    }

    .buttons-popup-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      column-gap: 10px;
    }

    a.yes-btn {
      background: gray;
      border-color: gray;
    }

    button.emailshare--email-submit,
    button.tellshare--tel-submit {
      width: 100%;
      min-width: 100%;
      min-height: 44px;
      margin-top: 7px;
      border-radius: 5px;
      position: relative;
    }

    .modal-dentist h2 {
      margin-bottom: 5px;
      font-weight: 600;
      text-transform: uppercase;
      text-align: center;
    }

    .modal-dentist {
      text-align: center;
    }

    .modal-dentist p {
      margin-bottom: 0;
      text-align: center;
      font-family: 'Montserrat';
    }

    .modal-content-dentist .buttons-popup-container a {
      width: auto;
      min-width: 50%;
      position: static;
    }

    #product-list .view-pricing-button-css:hover,
    .buttons-popup-container a:hover {
      color: #fff;
      background-color: #595858;
      border-color: #595858;
    }

    #product-list .medium-6 .view-pricing-button-css {
      margin-right: 0
    }

    .normalyAmount.italic {
      display: none !important;
    }

    .drtext i {
      font-size: 12px;
      font-style: italic;
      font-weight: 400;
      color: #565759;
      font-family: "Open sans", sans-serif;
    }

    .medium-6 .product-selection-description-parent-inner {
      position: relative;
    }

    .medium-6 .product-selection-description-parent-inner .drtext {
      /* position: absolute; */
      left: 0;
      bottom: 12px;
    }



    #contentThatFades .user-not-loggina .access-code-handler {
      color: #3c98cc;
    }

    .after-access-code {
      margin-top: 20px;
    }

    div#qrcode-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }


    div#product-list.grid-changed .drtext {
      position: absolute;
      position: static;
      bottom: 0;
    }

    .drtext {
      display: flex;
      align-content: center;
      /* justify-content: center; */
    }

    div#product-list:not(.grid-changed) .medium-3 .drtext,
    div#product-list:not(.grid-changed) .medium-12 .drtext {
      justify-content: center;
      /* background:red; */
    }


    div#product-list.grid-changed .product-selection-description-parent-inner {
      position: relative;
    }

    div#product-list.grid-changed .product-selection-description-parent-inner .drtext {
      bottom: 6px;
      /* color: red !important; */
    }

    #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent {
      min-height: 180px;
      max-height: 180px;
    }

    #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent {
      min-height: 140px;
      max-height: 140px;
    }

    #product-list:not(.grid-changed) .landing-product:not(.medium-6) .drtext {
      margin-bottom: 4px;
    }

    .share-qr-code-popup {
      display: none !important;
    }

    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner {
      padding-bottom: 20px;
    }

    .profile-container-wrapper .contactMessagesMbt,
    .rdhtabs.profile-container-all {

      padding-top: 50px;
    }

    .rdh-sub-footer {
      margin-top: 2rem;
    }

    .rdhsub-footer-logo {
      max-width: 100px;

      border-radius: 100%;
      background: none;
      overflow: hidden;
      padding: 0;
    }

    .RDHProfileFooter aside.socials ul {
      column-gap: 10px;
    }

    .all-product-dropdown {
      min-width: 250px;
    }



    .navigation-menu-body .dropdownHeader {

      background: #1fb6e4;
    }

    .icon-menu-dentist-system,
    .user-login {
      margin-left: 30px;
    }

    .icon-menu-dentist-system {
      display: inline-block !important;
    }

    html body .secondary-area-mbt:hover,
    html body .secondary-area-mbt:hover+.user-login {
      border-top: 0px solid transparent;
    }

    html body .navigation-menu-body {
      top: -25px;
      right: -188px;
      right: -10%;
    }


    .share-box-wrapper-dentist {
      padding: 1rem;
      border: 1px solid #eee;
      background: #f3f3f3;
      margin-top: 20px;
      position: relative;
    }

    .share-box-wrapper-dentist .form-boox .row-flex {
      display: flex;
      flex-direction: column;
    }

    .share-box-wrapper-dentist .form-boox input {
      margin: 0;
      border: 1px solid #d7d7d7;
      background-color: #fff;
      height: 46px;
      padding: 10px 16px;
      line-height: 16px;
      border-radius: 0;
      width: 100%;
      border-radius: 5px;
    }

    .share-box-wrapper-dentist .form-boox input[type="submit"] {
      margin-top: 10px;
      background-color: #1fb6e4;
      border-color: #1fb6e4;
      color: #fff;
      margin-top: 15px;
      letter-spacing: 0;
      font-size: 18px;
      font-weight: 500;
    }

    .share-header-wrap h2 {
      text-align: center;
      font-size: 16px;
      font-family: 'Montserrat';
      text-transform: uppercase;
      margin-bottom: 8px;
      position: relative;
      font-weight: 500;
    }

    .share-box-wrapper-dentist .modal-close-section {
      position: absolute;
      right: -11px;
      font-size: 18px;
      top: -16px;
      line-height: 0;
      width: 25px;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f3f3f3;
      border-radius: 25px;
      line-height: 1;
    }

    .share-box-wrapper-dentist {
      display: none;
    }

    .form-boox {
      display: none;
    }

    .is-visible-box {
      display: block;
    }

    .profile-container .fillNot span.circleShapedIconParent {
      border: 1px solid #fff;
    }

    .profile-container .fillNot span.circleShapedIcon {
      background: none !important;
      color: #555759;
    }

    .dr-name-displayer {
      font-size: 18px;
      margin-top: 8px;
      margin-bottom: 30px;
    }

    .clipboard-parent-wrapper {
      position: relative;
    }

    .clipboard-parent-wrapper button.clipboard {
      position: absolute;
      right: 0;
      top: -19px;
      right: 4px;
      background-color: #ffffff;
      color: #1fb6e4;
      display: flex;
      align-items: center;
      column-gap: 6px;
      cursor: copy;
      font-family: 'Montserrat';
    }

    span.cpy-text {
      font-size: 12px;
      text-transform: uppercase;
    }

    .navigatio-icon.smilebrilliant-logo {
      text-align: elft;
    }

    .navigatio-icon.smilebrilliant-logo .sbrlogo {
      max-width: 30px;
    }

    #wrapper .before-access-code label {
      font-size: 14px;
      font-weight: normal;
      margin-bottom: 10px;
    }

    #wrapper .after-access-code {
      text-align: center;
    }

    .profile-container #quick_cart {
      display: none;
    }

    #vipPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
    #vipPage .packageQuantityBox,
    .selectPackageBox,
    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
      background: #e7fafd;
    }



    .modal-dentist {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      opacity: 0;
      visibility: hidden;
      transform: scale(1.1);
      z-index: 9992;
      transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
    }

    .modal-content-dentist {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 2rem 1.5rem;
      width: 30em;
      border-radius: 0.5rem;
    }

    .close-button-dentist {
      width: 25px;
      cursor: pointer;
      border-radius: 1rem;
      background-color: lightgray;
      position: absolute;
      right: -11px;
      top: -9px;
      background: #fff;
      color: #1fb6e4;
      border: 1px solid #b3b3b3;
      font-size: 24px;
      font-weight: 700;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .close-button-dentist:hover {
      color: var(--clr-main);
    }

    .show-modal {
      opacity: 1;
      visibility: visible;
      transform: scale(1.0);
      transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
    }

    .modal-content-dentist .buttons-popup-container a {}

    .modal-dentist .buttons-popup-container {
      margin-top: 15px;
    }

    .arrow-up-indicator {
      width: 0px;
      height: 0px;
      border-left: 14px solid transparent;
      border-right: 14px solid transparent;
      border-bottom: 14px solid #f3f3f3;
      position: absolute;
      top: -14px;
      left: 11px;
    }

    .telephone-sharebox-dentist .arrow-up-indicator {
      left: 75px;
    }

    .error-message-pop {
      font-size: 12px;
      color: red;
    }

    .addPublicationModalPopup .modal-transition {
      transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
    }

    .after-success #geha-coupon-code-box {}

    .patient-acces-code-row {
      display: flex;
      justify-content: center;
      flex-direction: column;
    }

    .span-acces {
      font-size: 15px;
      text-transform: uppercase;
      margin-bottom: 5px;
      letter-spacing: 1px;
    }

    .accescodedata.after-success #geha-coupon-code-box {
      color: #828282;
      background: #fff;
      line-height: 1;
      padding: 14px 26px;
    }

    .span-acces-code {
      color: #1fb6e4;
    }

    .accescodedata.after-success #geha-coupon-code-box .view-my-public-profile {
      line-height: 0;
      margin-top: 5px;
    }

    .accescodedata.after-success #geha-coupon-code-box .view-my-public-profile a {
      font-size: 14px;
      line-height: 1;
      text-decoration: underline;
      color: #828282;
      text-transform: uppercase;
    }

    .after-success #geha-coupon-code-box {
      border: dashed #1fb6e4 2px;
    }

    .content-header-left {
      display: flex;
      align-content: center;
      justify-content: center;
    }




    /* new changes by amir 24may */

    @media screen and (min-width: 767px) {

      #product-list.grid-changed .medium-6.landing-product .product-selection-description-parent-inner,
      #product-list.grid-changed .medium-9.landing-product .product-selection-description-parent-inner,
      #product-list.grid-changed .medium-3.landing-product .product-selection-description-parent-inner,
      #product-list.grid-changed .medium-8.landing-product .product-selection-description-parent-inner,
      #product-list.grid-changed .medium-12.landing-product .product-selection-description-parent-inner,
      #product-list.grid-changed .medium-4.landing-product .product-selection-description-parent-inner {
        /* background: red; */
      }

      #product-list.grid-changed .landing-product:not(.medium-12) .productDescriptionDiv,
      #product-list.grid-changed .landing-product:not(.medium-12) .productDescriptionDiv {
        /* background: blue; */
        min-height: 0px;
      }

      #wrapper #vipPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
        /* background: orange; */
        min-height: 0px;
      }

      #wrapper #vipPage #product-list .product-selection-description-parent {
        display: flex;
        align-content: center;
      }

      #wrapper #vipPage #product-list .product-selection-description-parent-inner {
        width: 100%;
      }

      #wrapper #vipPage #product-list.grid-changed .product-selection-price-text-top.noflexDiv {
        height: initial;
        /* background: green; */
      }

      #wrapper #vipPage #product-list.grid-changed .medium-3 .product-selection-price-text-top .view-pricing-button-css,
      #wrapper #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text-top .view-pricing-button-css {
        top: 50%;
        transform: translateY(-50%);
        margin-top: 0;
        /* border: 10px solid orange !important; */
      }

      #wrapper #vipPage .landing-product.medium-6 span.selec-option-to-share {
        position: static;
      }

      /* for pricing view only  */
      .view-pricing #wrapper #vipPage #product-list.grid-changed .view-pricing-button-css {
        /* border: 10px solid black !important; */
        margin-top: 0;
      }

      .view-pricing .product-selection-price-text-top.noflexDiv {}

      .view-pricing #product-list .product-selection-price-text-top {
        height: auto;
        /* background: brown; */
      }

      .view-pricing #product-list .landing-product:not(.medium-12) .productDescriptionDiv,
      #product-list .landing-product:not(.medium-12) .productDescriptionDiv {
        /* background: purple; */
        height: auto;
        min-height: initial;
      }

      .view-pricing #product-list .medium-6.landing-product .product-selection-description-parent-inner,
      #product-list .medium-9.landing-product .product-selection-description-parent-inner {
        align-items: center;
        /* background: gray; */
      }

      .view-pricing #product-list .landing-product:not(.medium-12) .product-selection-description-parent {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .view-pricing #product-list .landing-product:not(.medium-12) .product-selection-description-parent .product-selection-description-parent-inner {
        width: 100%;
      }

      #product-list .medium-6.landing-product .product-selection-description-parent-inner,
      #product-list .medium-9.landing-product .product-selection-description-parent-inner {
        align-items: center;
      }














    }



    @media screen and (min-width: 768px) {
      .only-mobile{ display: none;}
      #product-list.grid-changed .medium-3 .product-selection-price-text-top .view-pricing-button-css,
      #product-list.grid-changed .medium-12 .product-selection-price-text-top .view-pricing-button-css {
        /* border: 10px solid orange !important;  */
        position: absolute;
        right: 0;
        top: 20px;

      }

      #product-list.grid-changed .medium-12 .product-selection-price-text-top {
        /* border: 10px solid purple !important; */
      }

      .profile-container-wrapper .contactFormWrapper,
      .contactMessagesMbt .headingSectionTop,
      .profile-container-wrapper .social-links-rdh-left-section {
        padding-left: 0px !important;
      }

      .contactMessagesMbt .headingSectionTop {
        padding-left: 50px;
      }

      #product-list:not(.grid-changed) .medium-6 .product-selection-price-wrap.green .ony-dentist-page {
        /* margin-top: 35px; */
      }

      #product-list:not(.grid-changed) .medium-6 .product-selection-price-wrap.green .ony-dentist-page,
      #product-list:not(.grid-changed) .medium-6 .product-selection-price-wrap .ony-dentist-page {
        /* position: relative;
        top: 24px; */
      }

      #product-list.grid-changed .product-selection-price-wrap.green .ony-dentist-page {
        position: relative;
        /* top: 20px; */
      }



    }


    @media screen and (max-width: 1000px) {
      .profile-container .user-profile-header {
        flex-direction: column;
      }


    }

    @media screen and (max-width: 767px) {
      .hidden-mobile{ display: none;}
      span.span-acces-code {
        font-size: 36px;
      }

      .span-acces,
      .accescodedata.after-success #geha-coupon-code-box .view-my-public-profile a {
        font-size: 13px;
      }

      .accescodedata.after-success #geha-coupon-code-box {
        margin-top: 0;
        margin-bottom: 0;
      }

      .after-success {
        width: 100%;
      }


      .user-profile-hero .user-profile-header {
        padding-bottom: 2rem;
      }

      #product-list .featureTag {
        z-index: 99;
      }

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

      #wrapper .check-button [type="checkbox"]:checked+label:before,
      #wrapper .check-button [type="checkbox"]:not(:checked)+label:before,
      #wrapper .medium-6 .check-button [type="checkbox"]:checked+label:before,
      #wrapper .medium-6 .check-button [type="checkbox"]:not(:checked)+label:before {
        width: 46px;
        height: 32px;
      }

      #product-list.teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button,
      #product-list.teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite,
      #product-list.teethWhieteingSystemWrapper.productLandingPageContainer .btn,
      #product-list.teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button {
        font-size: 18px;
        font-weight: 500;
      }

      #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent,
      #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent {
        min-height: initial;
        max-height: initial;
      }

      #product-list.productLandingPageContainer .productDescriptionDiv {
        margin-bottom: 8px;
      }

      .share-text {
        text-align: left;
      }

      .modal-content-dentist {
        width: 24em;
      }

      #product-list .check-button [type="checkbox"]:checked+label:after,
      #product-list .check-button [type="checkbox"]:not(:checked)+label:after {
        font-size: 36px;
        top: 7px;
      }

      html body #vipPage #product-list:not(.grid-changed) .medium-3 .check-button label {
        font-size: 18px;
      }

      .order-m-1 {
        order: 1;
      }

      .order-m-2 {
        order: 2;
      }

      .order-m-3 {
        order: 3;
      }

      .order-m-4 {
        order: 4;
      }

      .logged-in .navigation-menu-body ul li {
        justify-content: center;
      }

      html body .navigation-menu-body #contentThatFades>li.admin-login-btn {
        /* width: 100%;
        border-top: 1px solid #ebebeb; */
      }

      span.selec-option-to-share {
        position: relative;
        top: 6px;
      }

      .medium-12 span.selec-option-to-share {
        top: 14px;
      }



      /* for fixing burger menu mobile */

      .activateMenuNavigationWrapper #mobile-menu {
        transform: translate(100%, 100%);
        opacity: 0;
        visibility: hidden;
        display: none;
      }

      .navigation-menu-body {
        background: #fff;
        transform: translate(100%, 100%);
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: fixed;
        height: 100%;
        top: 0 !important;
        right: 0;
        left: 0;
      }

      .activateMenuNavigationWrapper .navigation-menu-body {
        transform: translate(0, 0);
        opacity: 1;
        visibility: visible;
        display: flex !important;

      }

      .user-profile-hero .navigation-menu-body ul li a {
        width: 100%;
      }

      html body .navigation-menu-body #contentThatFades>li {
        width: 100%;
      }

      .user-profile-hero .navigation-menu-body .flex-div {
        flex-direction: row;
      }

      body.logged-in .user-profile-hero .navigatio-icon.smilebrilliant-logo {
        margin: 0;
      }

      .user-profile-hero .navigation-menu-body .flex-div {
        justify-content: start;
        column-gap: 15px;
      }

      .user-profile-hero .navigation-menu-body .navigation-text {
        text-align: left;
      }

      .profile-container .navigatio-icon span.circleShapedIcon {
        color: #555759;
        background: #ffffff;
      }

      .profile-container span.circleShapedIconParent {
        border: 0px solid #3c98cc;
      }

      .navigatio-icon.smilebrilliant-logo .sbrlogo {
        max-width: 40px;
      }

      .navigation-menu-body .navigatio-icon {
        min-width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
    }


    @media screen and (max-width: 1060px) and (orientation: portrait) {

      #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent {
        min-height: 220px;
        max-height: 200px;
      }

      #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent {
        min-height: 156px;
        max-height: 156px;
      }

    }




    @media screen and (max-width: 900px) and (orientation: landscape) {
      #wrapper #vipPage #product-list.grid-changed .product-selection-price-wrap button.btn {
        min-width: 160px;
      }

      #wrapper #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
        max-width: 100%;
        padding-top: 0rem;
      }

      #wrapper #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
        margin-left: -7px;
        margin-right: -7px;
        padding: 15px 7px;
      }

      #wrapper #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
        max-width: none;
      }

      #vipPage #product-list.grid-changed .medium-12 .product-selection-image-wrap img {
        max-height: 230px;
      }


    }

    @media only screen and (min-width: 768px) and (max-width: 1300px) {
      #product-list:not(.grid-changed) .medium-3 .product-selection-image-wrap {
        min-height: 230px;
      }
    }

    @media screen and (max-width: 767px) and (orientation: portrait) {

      #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent,
      #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent {
        min-height: initial;
        max-height: initial;
      }

      .floating-sharing-button.dentish-share-button-js {}

      .main-navigation-mobile:before {
        opacity: 0;
        visibility: hidden;
      }

      .floting-geha-button.floating-sharing-button .geha-memeber-button {
        bottom: 59px;
      }

      .floating-sharing-button.dentish-share-button-js {
        z-index: 1234;
      }


    }

    .landscape-warning {
      display: none;
      position: fixed;
      width: 100%;
      height: 100%;
      background: #fffffff5;
      z-index: 7898;
    }

    .landscape-inner-warning-message {
      text-align: center;
      padding: 20px;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #000;
      position: fixed;
      width: 100%;
      height: 100%;
      max-width: 370px;
      margin-left: auto;
      margin-right: auto;
      left: 0;
      right: 0;
    }

    .close-warning {
      width: 25px;
      cursor: pointer;
      border-radius: 1rem;
      background-color: lightgray;
      position: absolute;
      right: 40px;
      top: 40px;
      background: #fff;
      color: #1fb6e4;
      border: 1px solid #b3b3b3;
      font-size: 24px;
      font-weight: 700;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .landscape-inner-warning-message p {
      color: #565759;
      font-weight: 500;
    }

    .addressCopyToClicpboard {
      text-wrap: inherit;
      word-break: break-all;
      font-size: 14px;
      font-family: 'Montserrat';
      margin-top: 12px;
    }

    .modal-content-dentist .share-url {
      border: 1px solid #eeee;
      padding: 1rem;
      text-align: left;
      margin-top: 1.5rem;
      border: dashed #1fb6e4 2px;
      padding-top: 0;
      position: relative;
    }

    .modal-content-dentist .share-url a {
      font-size: 14px;
      text-transform: uppercase;
      margin-bottom: 8px;
      letter-spacing: 1px;
      display: block;
      position: absolute;
      top: -13px;
      background: #ffff;
      padding-left: 6px;
      padding-right: 10px;
      color: #1fb6e4;
    }

    .addressCopyToClipboard {
      word-break: break-all;
      padding-top: 1rem;
    }

    @media screen and (min-width: 810px) and (max-width: 1080px) and (orientation: portrait) {

      #wrapper #vipPage #product-list:not(.grid-changed) .medium-3 .check-button label {
        padding-left: 5px;
        padding-right: 5px;
      }

      #wrapper span.selec-option-to-share {
        line-height: 1.2;
        display: block;
        margin-bottom: 5px;
      }

      #wrapper .check-button [type="checkbox"]:checked+label:before,
      #wrapper .check-button [type="checkbox"]:not(:checked)+label:before {
        width: 39px;
        height: 30px;
      }

      #wrapper .check-button [type="checkbox"]:checked+label:after,
      #wrapper .check-button [type="checkbox"]:not(:checked)+label:after {
        top: 7px;
        font-size: 30px;
        -webkit-text-stroke: 1px #fff;
      }

      #product-list .landing-product:not(.medium-12) .productDescriptionDiv,
      #product-list .landing-product:not(.medium-12) .productDescriptionDiv {
        min-height: 0;
      }

      #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent {
        min-height: 180px;
        max-height: 180px;
      }

      #product-list:not(.grid-changed) .medium-3 .product-selection-image-wrap {
        min-height: 205px;
      }
    }



    @media screen and (max-device-width: 920px) and (orientation: landscape) {
      .landscape-warning {
        display: flex;
      }
    }


    @media screen and (max-width: 375px) and (orientation: portrait) {

      .share-box-wrapper-dentist {
        margin-top: 10px;
      }

      .addPublicationModalPopup .form-group {
        margin-bottom: 0.5rem;
      }

      .share-with-icons a {
        width: 35px;
        height: 35px;
      }

      .share-with-icons a.share-email svg {
        height: 22px;
      }

      .share-with-icons a svg {
        height: 22px;
        width: 22px;
      }

      .arrow-up-indicator {
        left: 5px;
      }

      .telephone-sharebox-dentist .arrow-up-indicator {
        left: 52px;
      }

      .addPublicationModalPopup .form-group input,
      .addPublicationModalPopup .form-group select {
        max-height: 42px;
        min-height: 42px;
      }

      .addPublicationModalPopup .form-group textarea {
        min-height: 70px;
        max-height: 70px;
      }
    }
  </style>


  <!-- End of smilebrilliant Zendesk Widget script -->

</head>



<body <?php body_class(); ?>>

  <div class="landscape-warning">
    <button id="close-warning-landsacpe" class="close-warning">×</button>
    <div class="landscape-inner-warning-message">
      <p class="font-mont" style="
    margin: 0;
">Please rotate your device to portrait mode for optimum user experience.</p>
    </div>
  </div>


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
      if ((is_user_logged_in() && strpos($current_url, "support") == false && strpos($current_url, "my-account") !== false) || (is_user_logged_in() && strpos($current_url, "support") == false && strpos($current_url, "/profile/edit") !== false)) { ?>
        <div id="chat-circle">
          <a href="/my-account/support/?active-tab=chat">
            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chat_talk.svg" />
          </a>
          <div id="totalunreadmessages"></div>
        <?php } ?>

      </div>
      <?php
      if (is_user_logged_in() && get_user_meta($user_id, 'access_code', true) != '') { ?>

        <div class="floting-geha-button floating-sharing-button dentish-share-button-js">
          <div class="geha-memeber-button">
            <a href="javascript:void(0);" class="share-popup-open">
              <i class="fa fa-share-alt" aria-hidden="true"></i> Share
            </a>
          </div>
        </div>
      <?php } ?>
      <?php
      if ((get_current_user_id() != $user_id && isset($_COOKIE['message_from_dentist'])) || (get_current_user_id() != $user_id && $dentistmessage != '')) { ?>

        <div class="floting-geha-button floating-sharing-button dentish-share-button-js">
          <div class="geha-memeber-button">
            <a href="javascript:void(0);" class="message-popup-open">
              <i class="fa fa-envelope" aria-hidden="true"></i> View Message From Dentist
            </a>
          </div>
        </div>
      <?php } ?>


      <div class="user-profile-hero rdhHeaderWrapper">

        <style>
          body.page-id-192 #wrapper div[role="main"] {
            padding-top: 0px;
          }
        </style>

        <div class="profile-container">

          <div class="nav-men-wrapper" id="flyout-example">

            <div class="rowMbtParent notificationAllUnique">

              <div class="rowMbt secondary-area-mbt" style="display: none;">
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
                <div id="nav-menu" class="burgerNav dddd" style="opacity: 0;">
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
                      Navigation
                      <!-- RDH Connect -->

                    </div>

                    <div class="navigation-nav-item">

                      <ul id="contentThatFades">

                        <?php if (is_user_logged_in()) {



                          // echo 'logged in id is'.get_current_user_id();
                          if (get_current_user_id() == $user_id) {
                            if (function_exists('bp_version')) {
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
                          }
                          if (get_current_user_id() != $user_id && !isset($_COOKIE['access_code'])) {
                            echo '<li class="rdh-home-page order-1">

         <a href="javascript:void(0);"   class="access-code-handler one-link">
         <div class="flex-div">
         <div class="navigatio-icon smilebrilliant-logo rdh-logo-menu">
            <span class="circleShapedIconParent">
              <span class="circleShapedIcon">
              <i class="fa fa-user-o" aria-hidden="true"></i>

            </span>
            </span>
         </div>
         <div class="navigation-text">
           <div class="navigation-top-text uppercase">
                    PATIENT ACCESS CODE
           </div>
           <div class="navigation-small-text">
           Enter patient access code one
           </div>
         </div>

       </div>

         </a>

     </li>';
                          }



                          echo '<li class="rdh-home-page welcome-dr-link fillNot">
                          <a href="javascript:void(0);" class="">
                              <div class="flex-div">
                                  <div class="navigatio-icon smilebrilliant-logo rdh-logo-menu">
                                      <span class="circleShapedIconParent">
                                          <span class="circleShapedIcon">
                                          <i class="fa fa-stethoscope" aria-hidden="true"></i>

                                          </span>
                                      </span>
                                  </div>
                                  <div class="navigation-text">
                                      <div class="navigation-top-text uppercase">
                                      Welcome Dr. ' . $user_lastname . '!
                                      </div>
                                  </div>
                              </div>
                          </a>
                      </li>';


                          echo '<li class="  fillNot share-this-page ">
                      <a href="javascript:void(0)" class="share-popup-open">
                        <div class="flex-div">
                          <div class="navigatio-icon smilebrilliant-logo">
                            <i class="fa fa-share-alt" aria-hidden="true" style="color: #555768;"></i>
                          </div>
                          <div class="navigation-text">
                            <div class="navigation-top-text uppercase">
                              Share This Page
                            </div>
                            <div class="navigation-small-text">
                              Share link to this page
                            </div>
                          </div>
                        </div>
                      </a>
                    </li>';


                          echo '<li class="rdh-home-page order-1 editmy-dentist-profile" style="display:none;">
     <a href="/my-account"   class="">
     <div class="flex-div">
     <div class="navigatio-icon smilebrilliant-logo rdh-logo-menu">
        <span class="circleShapedIconParent">
          <span class="circleShapedIcon">
           <i class="fa fa-user" aria-hidden="true"></i>
        </span>
        </span>
     </div>
     <div class="navigation-text">
       <div class="navigation-top-text uppercase">
                Edit my profile
       </div>
       <div class="navigation-small-text">
       Manage and edit name or email
       </div>
     </div>

   </div>

     </a>

 </li>';

                          echo '<li class="edit-account-list order-3 fillNot">

              <a href="javascript:void(0);" onclick="confirmLogout()" href="' . esc_url(wc_logout_url()) . '" >

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

                Click here to log out

                </div>

                <div class="navigation-small-text" >

                For dentist & office use only

                </div>

              </div>

            </div>

              </a>

          </li><script>
          var logouturl = "' . esc_url(wc_logout_url()) . '";
          function confirmLogout() {
            jQuery("#modal-dentist2").addClass("show-modal");
            jQuery("#modal-dentist2 .yes-btn").attr("href",logouturl);
              

          }
          </script>';

                          echo '<li class="edit-account-list order-4 ">

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

                Shop All Smile Brilliant Products


                </div>



              </div>

            </div>

              </a>

          </li>';


                        } else {
                          if (!isset($_COOKIE['access_code'])) {
                            ?>

                            <li class="user-not-loggin  paients-access-code-li mobile-border-bottom order-m-1">
                              <a href="javascript:void(0);" class="access-code-handler">
                                <div class="flex-div">
                                  <div class="navigatio-icon">
                                    <i class="fa fa-cogs" aria-hidden="true" style="color: #656776;"></i>
                                    <!-- <i class="fa fa-user" aria-hidden="true" ></i> -->
                                  </div>
                                  <div class="navigation-text">
                                    <div class="navigation-top-text uppercase">
                                      Client Access
                                    </div>
                                    <div class="navigation-small-text">
                                      Patient-only Product Pricing
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </li>
                          <?php } ?>


                          <li class="user-not-loggin  fillNot admin-login-btn mobile-border-bottom order-m-3">
                            <a href="<?php echo get_home_url() . '/my-account'; ?>">
                              <div class="flex-div">
                                <div class="navigatio-icon smilebrilliant-logo">
                                  <i class="fa fa-user-o" aria-hidden="true" style="color: #555768;"></i>
                                </div>
                                <div class="navigation-text">
                                  <div class="navigation-top-text uppercase">
                                    Admin Login
                                  </div>
                                  <div class="navigation-small-text">
                                    For dentist & office use only

                                  </div>
                                </div>
                              </div>
                            </a>
                          </li>





                          <li class="user-not-loggin smilebrilliant-home-page-link order-m-2">
                            <a href="<?php echo get_home_url(); ?>">
                              <div class="flex-div">
                                <div class="navigatio-icon smilebrilliant-logo">
                                  <img
                                    src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png"
                                    class="sbrlogo tilt-icon" alt="Smile Brilliant">
                                </div>
                                <div class="navigation-text">
                                  <div class="navigation-top-text uppercase">
                                    Smile brilliant Home
                                  </div>
                                  <div class="navigation-small-text">
                                    Shop All Smile Brilliant Products

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

            <div class="content-header-left">
              <div class="profile-image">
                <div class="user-img">
                  <!-- <a class="addEditPhoto" href="<?php if (function_exists('bp_version')) {
                    echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/change-avatar";
                  } ?>">
                  <div class="editOverlay">
                    <i class="fa fa-pencil" aria-hidden="true"></i><span> edit photo</span>
                  </div>
                </a> -->

                  <!-- <img src="<?php //if(function_exists('bp_version')){ echo bp_core_fetch_avatar(array('item_id' => $user_id, 'type' => 'full', 'html' => FALSE)); } ?>" alt="" /> -->



                  <!-- Use the image source in an HTML img tag -->
                  <img src="<?php echo esc_url($image_src); ?>" alt="" srcset="">


                </div>

                <div class="border-img">

                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/border-round.png" alt=""
                    srcset="">

                </div>

              </div>


             


              <div class="rdh-profile-top-section">
                <div class="profile-detail Montserrat ">
                  <div class="inncer-align-content">
                    <h1 class="font-mont">
                      <?php
                      $practice_name = get_user_meta($user_id, 'practice_name', true);
                      echo $practice_name; ?>
                      <div class="dr-name-displayer">Dr. <? echo $user_lastname; ?></div>
                      <?php
                      echo '<span class="checkbMark"  style="display: none;">';
                      $icon = 'verified_icon_blue';
                      //    echo $user_id;
                      if (in_array($user_id, array(149484, 114131, 149487, 149480))) {
                        $icon = 'verified_icon_pink';
                      }
                      echo '<img class="iconVerificed" src="' . get_stylesheet_directory_uri() . '/assets/images/' . $icon . '.svg" alt="" />';
                      echo '</span>';
                      $address_parts = explode(',', $address_address);
                      $street = isset($address_parts[0]) ? trim($address_parts[0]) : '';
                      $city = isset($address_parts[1]) ? trim($address_parts[1]) : '';
                      $state = isset($address_parts[2]) ? trim($address_parts[2]) : '';
                      $country = isset($address_parts[3]) ? trim($address_parts[3]) : '';
                      ?>


                    </h1>

                    <p class="designation"> <?php echo $rdh_subtitle; ?></p>

                    <div class="address">
                      <p class="font-mont"><?php if ($street) {
                        echo $street . ' ';
                      }
                      if ($city) {
                        echo $city . '<br>';
                      }
                      if ($state) {
                        echo $state . ', ';
                      }
                      if ($country) {
                        echo $country;
                      } ?>
                      <?
                      $queryuname = get_query_var('dentist_name');
                      $dentist_data = DENTIST_DATA;
                      // echo '<pre>';
                      // print_r($dentist_data);
                       if(isset($dentist_data[$queryuname]) && isset($dentist_data[$queryuname]['website'])){?>
                      <p class="font-mont phonenumber website_url"><a target="_blank"
                          href="<? echo $dentist_data[$queryuname]['website']?>"><span class="hidden-mobile"><?echo $dentist_data[$queryuname]['website']?></span> <span class="only-mobile">Dentist Website</span>  </a></p>
                        <? } ?>
                      <p class="font-mont phonenumber"><a
                          href="tel:<?php echo $billing_phone; ?>"><?php echo $billing_phone; ?></a></p>

                    </div>

                  </div>
                </div>
              </div>
            </div>

            <?
            $access_code = get_user_meta(get_current_user_id(), 'access_code', true);

            if ($access_code != '') {
              ?>
              <div class="displayField accescodedata after-success">
                <div id="geha-coupon-code-box" class="font-mont">
                  <div class="patient-acces-code-row">
                    <span class="span-acces"> patient Access Code </span> <span class="span-acces-code">
                      <?php echo $access_code; ?></span>
                  </div>
                  <?
               
                  $current_user = wp_get_current_user();
                  if ($current_user->ID != 0) {
                    $username = $current_user->user_login;
                  }
                  ?>
                  <div class="view-my-public-profile" style="display: none;"><a href="/dentist/<? echo $username; ?>">
                      <i class="fa fa-link" aria-hidden="true"></i> View My Public Profile</a>
                  </div>

                </div>
              </div>



            <? } ?>


          </div>





        </div>

        <script>
          $(document).ready(function () {
            $('.selectquantitybtn').click(function () {
              var price = $(this).attr('data-price');
              console.log(price);
              //$(this).parents('.product-selection-box').find('.price-display').text(price);
            });

            $('.plus-btn').click(function () {
              var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
              quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
              updatePrice($(this).parents('.product-selection-box').find('.box'));
            });

            $('.minus-btn').click(function () {
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







          jQuery(document).ready(function () {

            if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
              // jQuery('.secondary-area-mbt').hide();
            }
          });
          jQuery(document).ajaxComplete(function (event, xhr, settings) {
            if (typeof settings !== 'undefined' && typeof settings.data !== 'undefined') {
              if (settings.data.includes("product_id")) {
                if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
                  // jQuery('.secondary-area-mbt').hide();
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