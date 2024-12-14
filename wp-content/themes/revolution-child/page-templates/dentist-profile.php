<?php
global $dentist_id;
global $dentistmessage;
function disable_browser_cache()
{
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}
add_action('send_headers', 'disable_browser_cache');
$dentisturl_flush = home_url() . "/dentist/" . get_query_var('dentist_name') . "/";

if (function_exists('w3tc_flush_url')) {
  //exit('exit');
  w3tc_flush_url($dentisturl_flush);
}
$dentist_page = false;
if (get_query_var('dentist_name') != '') {
  $dentist_page = true;
}
require (get_stylesheet_directory() . '/inc/dentist-info.php');
$dentist_id = $user_id;
$user_info = get_userdata($user_id);
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;
setcookie('affwp_ref', $affiliate_id, time() + (86400 * 30), "/");
//update_user_meta($user_id,'product_found','');
setcookie('red_user_id', $user_id, time() + (86400 * 30), "/");
$_COOKIE['red_user_id'] = $user_id;
setcookie('dentist_id', $user_id, time() + (86400 * 30), "/");
//$selected_products = isset($_REQUEST['selected_products']) ? $_REQUEST['selected_products'] : '';
$recommendation_id = isset($_REQUEST['recommendation_id']) ? $_REQUEST['recommendation_id'] : '';
$ids = get_ids_from_recommendation();

$access_code = '';
$selected_products = '';
$dentistmessage = '';
if ($ids) {
  $share_url = get_share_url_from_db($ids['last_insert_id']);
  $dentist_note_db = get_dentist_note_from_db($ids['last_insert_id']);

  $parsed_url = parse_url($share_url);
  parse_str($parsed_url['query'], $query_params);
  $selected_products = isset($query_params['selected_products']) ? sanitize_text_field($query_params['selected_products']) : '';
  $access_code = isset($query_params['access_code']) ? sanitize_text_field($query_params['access_code']) : '';
  $dentistmessage = $dentist_note_db;

  //access_code
}
// echo $selected_products;
// echo '<br />';
// echo $access_code;
// die();
//$access_code = isset($_REQUEST['access_code']) ? $_REQUEST['access_code'] : '';

$user_access_code = get_user_meta($user_id, 'access_code', true);
if (base64_decode($access_code) != $user_access_code) {
  //  echo 'not mached';
//  die();
  $selected_products = '';
}
if (base64_decode($access_code) == $user_access_code) {
  setcookie('access_code', $user_access_code, time() + (86400 * 30), "/");
  // if(isset($_REQUEST['selected_products'])){
  //   setcookie('selected_products', $_REQUEST['selected_products'], time() + (86400 * 30), "/");
  // }
  if ($selected_products != '') {
    setcookie('selected_products', $selected_products, time() + (86400 * 30), "/");
  }
  //if (isset($_REQUEST['dentist_message'])) {
  if ($dentistmessage != '') {
    // $dentistmessage = $_REQUEST['dentist_message'];
    $dentistmessage = str_replace("\'", "'", $dentistmessage);
    $dentistmessage = str_replace('\"', '"', $dentistmessage);

    setcookie('message_from_dentist', $dentistmessage, time() + (86400 * 30), "/");
  }
}
get_header('dentist');

if ($access_code == '') {
  $selected_products = isset($_COOKIE['selected_products']) ? $_COOKIE['selected_products'] : '';
}
if (isset($_COOKIE['access_code']) && $_COOKIE['access_code'] != '') {
  setcookie('dentist_slug', $user_info->user_login, time() + (86400 * 30), "/");
}

// You can then further process the decoded code as needed
?>


<style>
  .user-profile-header .profile-image .user-img {
    border: 5px solid #1fb6e4;
    border-radius: 100%;
    background: none;
    overflow: hidden;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
  }

  .user-profile-hero .profile-image .user-img img {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    width: auto;
    height: auto;
    border-radius: 0%;
    max-width: 85%;
    background-color: #fff;
  }

  header#sbr-header,
  .deal-top-bar,
  #friendbuyoverlaySite,
  header#mobile-header,
  iframe#launcher,
  #scroll_to_top {

    /* display: none !important; */

  }

  .active-profile-tab .tabsSectionrdhSec {
    border-color: #1fb6e4;
  }

  .tabsSectionrdhSec a#profile-active.active {
    background-color: #1fb6e4;
  }

  .tabsSectionrdhSec ul li a,
  .tabsSectionrdhSec ul li a.active {
    font-weight: 500;
    border-radius: 7px 7px 0px 0px;
  }

  .header-spacer {

    height: 0px !important;

  }

  .rdh-profile-top-section .profile-detail h3,
  .rdh-profile-top-section .profile-detail h1 {
    font-weight: 600;
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
    background: #e7fafd;
  }

  .logged-in .hide-on-public-profile {
    display: none !important;
  }

  html body #wrapper .hide-on--all-profile-pages {
    display: inline-flex;
  }

  #product-list.productLandingPageContainer .medium-12 .featureTag {
    border-radius: 10px;
  }

  #product-list.productLandingPageContainer .featureTag {
    display: none;
  }

  section.shopLanderPageHader .pageheaderBotm {
    box-shadow: rgba(0, 0, 0, 0.08) 0px 4px 12px;
    padding-top: 5px;
    padding-bottom: 5px;
    min-width: 176px;
    overflow: hidden;
  }

  section.shopLanderPageHader {
    margin-top: -3.5rem;
  }

  #vipPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-5>.vc_column-inner {
    background-color: #fff !important;
  }

  /* product styles */
  body {
    overflow-x: hidden;
  }

  #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-6>.vc_column-inner {
    background-color: #fff !important;
  }

  #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
    max-width: 1330px;
  }

  #vipPage .vipPageBanner {
    max-height: 620px;
    overflow: hidden;
    background: rgb(69, 8, 118);
    background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%);
    /* background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/geha-banner-bg.jpg); */

  }

  .gehanFormSection {
    background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/geha-banner-bg.jpg);
    background-color: #683c8b;
    background-repeat: repeat-x;
  }

  #vipPage .rowMbt {
    display: flex;
    flex-wrap: wrap;
  }

  .mt-100 {
    padding-top: 100px;
  }

  #vipPage .geha-banner-text-section-parent {
    width: 40%;
  }

  #vipPage .graphicImagePeople {
    width: 60%;
    text-align: right;
  }

  #vipPage .text-white {
    color: #fff;
  }

  #vipPage .geha-banner-text-section {
    text-align: center;
  }


  #vipPage .geha-banner-text-section p {
    margin-bottom: 0;
    padding-bottom: 10px;
  }

  #vipPage .geha-banner-text-section h2 {
    margin-top: 40px;
    font-size: 30px;
    margin-bottom: 50px;
    line-height: 1.1;
  }

  #vipPage .gehaLoginCustomer {
    margin-top: 25px;
  }

  #vipPage .seeDiscountBtn button {
    background: #eb6754;
    border-color: #eb6754;
    letter-spacing: 0;
    font-size: 20px;

  }

  #vipPage .seeDiscountBtn button:hover {
    background-color: #595858;
    border-color: #595858;
  }

  #vipPage .gehaLoginCustomer h3 {
    color: #fff;
    font-size: 20px;
    font-weight: 300;
  }

  #vipPage .gehaLoginCustomer h3 a:hover {
    color: #fff;
  }

  #vipPage .gehaLoginCustomer h3 a {
    color: #dec5f5;
  }

  #vipPage .splitTwo {
    width: calc(100%/2);
  }

  #vipPage .productGripgSectionWrapper {
    background: #17a2b8;
    padding: 20px;
  }

  #vipPage .productGripgSection {
    border: 1px solid #fff;
    padding: 30px;
  }

  #vipPage .productGripgSection li {
    background-image: url(https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/adults-probiotics-blue-tick.png);
    background-repeat: no-repeat;
    background-position: left;
    font-size: 26px;
    list-style: none;
    padding-left: 74px;
    line-height: 44px;
    margin-top: 0px;
    background-size: 45px;
    margin-bottom: 10px;
    font-weight: 300;
  }

  #vipPage .productGripgSection h3 {
    font-size: 67px;
    font-weight: bolder;
    letter-spacing: 1px;
    line-height: 52px;
    margin-bottom: 50px;
  }

  #vipPage .productGripgSection ul {
    margin-bottom: 60px;
  }

  #vipPage .productGripgSectionProduct {
    background-position: center;
    background: url(https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/geha-page/geha-product-image.jpg);
  }

  #vipPage section.sectionProductDisplay {
    margin-top: 10px;
  }

  #vipPage .logoesSecHfa {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;

  }

  #vipPage .logoesSecHfa img {
    max-width: 118px;
  }

  #vipPage section.sectionHsaFsa {
    background: #555759;
    padding: 20px 0px;
  }

  #vipPage .colhFsaSec {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }

  #vipPage .colhFsaSec h4 {
    font-size: 30px;
  }

  #vipPage section.ourSuportedCustomers.product-logo-wrapper {
    background: #440876;
    padding-top: 38px;
    padding-bottom: 38px;
    margin-top: 0px;
  }

  #vipPage .extra_logo_before-top .boxSecBox {
    position: relative;
  }

  #vipPage .extra_logo_before-top .col-md-3,
  #vipPage .extra_logo_before .col-md-3 {
    -webkit-box-flex: 0;
    -ms-flex: initial;
    flex: initial;
    max-width: max-content;
    padding-left: 2.5%;
    padding-right: 2.5%;
  }

  #vipPage .extra_logo_before-top .boxSecBox.box-with-extra-logo:before {
    content: "";
    background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/logoes-tiktok.png);
    width: 114px;
    height: 149px;
    position: absolute;
    top: 0;
    left: 0;
    background-repeat: no-repeat;
  }

  #vipPage .box-with-extra-logo-right:before {
    content: "";
    background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/logoes-small-circle.png);
    width: 50px;
    height: 49px;
    position: absolute;
    top: 0;
    right: -100px;
    background-repeat: no-repeat;
  }

  #vipPage .logo-strip-two .col-md-3 {
    padding-left: 4%;
    padding-right: 4%;
  }

  #vipPage .justify-conten {
    justify-content: center;
  }

  #vipPage .extra_logo_before-top .spacing-left-emphty,
  #vipPage .smilePageIconSection-parent-div .extra_logo_before .spacing-left-emphty {
    position: relative;
    padding-left: 158px;
  }

  #vipPage .rowMbt.extra_logo_before-top.logo-strip-one.justify-conten {
    margin-bottom: 35px;
  }

  #vipPage .second-row .boxSecBox.spacing-left-emphty.col-md-3.col-4 {
    padding-left: 30px;
  }

  #vipPage .fullWidth {
    width: 100%;
  }

  #vipPage .year-wrannanty-container .itsSimpleHeading {
    color: #522773;
    text-align: center;
    margin-bottom: 0;
    font-weight: 400;
    font-size: 30px;
    margin-bottom: 20px;
  }

  #vipPage section.warrantysectionPage {
    margin-bottom: 70px;
  }

  #vipPage section.gehanFormSection {
    padding-top: 50px;
    padding-bottom: 40px;
  }

  #vipPage .gehanFormSection input[type="text"],
  #vipPage .gehanFormSection input[type="email"] {
    margin-bottom: 10px;
    min-height: 70px;
  }

  #vipPage .member-ids input[type="text"] {
    background: #efdefc;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box,
  #vipPage .profile-container {
    width: 100%;
  }

  #vipPage section.sectionHsaFsa {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  #vipPage section.ourCustomers h2 {
    font-size: 60px;
    font-weight: 700;
    margin-top: 0px;
    margin-bottom: 36px;
    padding-top: 40px;
  }

  #vipPage section.ourCustomers h3 {
    font-size: 26px;
    font-weight: normal;
    margin-top: 0;

  }

  #vipPage .customer-before-after-image {
    margin-top: 60px;
    margin-bottom: 65px;
  }

  #vipPage .warrabty-text-container p {
    font-weight: 400;
  }

  #vipPage .col-md-12.text-center.form-notes {
    margin-top: 20px;
  }

  #vipPage .w-100 {
    width: 100%;
  }

  #vipPage .row.after-success {
    width: 100%;
  }

  #vipPage .colhFsaSec p {
    font-size: 14px;
  }

  #vipPage .container {
    margin-left: auto;
    margin-right: auto;
    /* padding-bottom:30px; */
  }

  #vipPage section.shopLanderPageHader .pageheaderTop {
    /* background: rgb(69, 8, 118) !important;
        background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%) !important; */
    background-image: url(/wp-content/themes/revolution-child/assets/images/sales/2022/cyber-monday-sale/BannerBackground.png);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  #vipPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
    right: 78px;
    top: -16px;
    max-width: 436px;
  }

  #vipPage .alin-items-center {
    align-items: center;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
    background-color: #e8f8fc !important;
  }

  #vipPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-5>.vc_column-inner {
    background-color: #fff !important;
  }


  #vipPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button,
  .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite,
  .teethWhieteingSystemWrapper.productLandingPageContainer .btn {
    background-color: #1fb6e4;
    border-color: #1fb6e4;
    border-radius: 10px;
  }

  #vipPage .productLandingPageContainer .medium-12 .small-desc h4,
  .productLandingPageContainer .medium-12 .small-desc h5 {
    color: #65657f;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12 .product-selection-description b {
    color: #65657f;
    font-weight: 500;
  }

  #vipPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
  #vipPage .packageQuantityBox,
  .selectPackageBox {
    background: #e8f8fc;
  }

  #vipPage .graphicImagePeople img {
    width: 100%;
    max-width: 776px;
  }


  /* 9th-child-image-section added */
  #vipPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description b {
    font-size: 16px;
    font-weight: normal;
    color: #565759;
    font-weight: 400;
  }

  #vipPage #product-list.teethWhieteingSystemWrapper .medium-12.child-9 .productDescriptionDiv b {
    font-weight: bold;
    line-height: inherit;
    color: #565759;
  }

  #vipPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.child-9 .productDescriptionDiv b {
    font-size: 22px;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description-text {
    padding-top: 0px;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description-text p {
    margin: 0
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.child-9 .days-textFortyFive {
    margin-top: 35px;
  }

  #vipPage #product-list.productLandingPageContainer .medium-12.child-9 .text-blue {
    color: #3c98cc !important;
  }

  .product-selection-description-parent {
    position: relative;
  }

  #vipPage .ultrasonic-text-contain-by-js .backOrderList {
    position: absolute;
    display: block;
    top: -2px;
    right: 0;
    max-width: 366px;
  }

  #vipPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList {
    line-height: 14px;
    top: -7px;
  }

  #vipPage #product-list.productLandingPageContainer:not(.grid-changed) .medium-12 .ultrasonic-text-contain-by-js .backOrderList {
    position: static;
  }

  /* Ended 9th-child-image-section added */

  /* popup */

  .addPublicationModalPopup .modal {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 70%);
    opacity: 0;
    visibility: hidden;
    transform: scale(1.1);
    /* transition: visibility 0s linear 0s, opacity 0s 0s, transform 0s; */
    z-index: 9991;
  }




  .show-modal {
    opacity: 1;
    visibility: visible;
    transform: scale(1.0);
    transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
  }

  h1.gehaTextmember {
    margin-bottom: 0;
  }

  p.memeberGranted {
    color: #440776;
    margin-bottom: 10px;
  }

  h2.youreInText {
    color: #555759;
    font-weight: bolder;
    font-size: 72px;
    margin-bottom: 10px;
  }

  h3.pleaseRed {
    color: #eb6754;
    font-weight: 600;
    font-size: 30px;
  }

  .descriptionBody {
    font-size: 16px;
    line-height: 1.2;
    max-width: 84%;
    margin-left: auto;
    margin-right: auto;
  }

  .modal .seeDiscountBtn .btn {
    background: #440776;
    color: #fff;
    letter-spacing: 0;
    font-size: 20px;
  }

  #vipPage .container-form {
    max-width: 820px;
  }

  #vipPage .after-success #geha-coupon-code-box {
    background-color: #ffffff;
  }

  #vipPage .after-success h1 {
    line-height: 42px;
  }


  #vipPage #product-list.grid-changed .medium-12 .product-selection-image-wrap img {
    max-width: 100%;
  }


  #vipPage #product-list.grid-changed .medium-12 .product-selection-description b {
    font-weight: 700;
    font-size: 16px;
    text-transform: uppercase;
    padding-right: 15px;
    color: #565759;
  }

  #vipPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
    max-height: 44px;
    overflow: hidden;
    min-height: 44px;
    display: flex;
    align-items: flex-end;
  }

  #vipPage #product-list.grid-changed .medium-12 .normalyAmount {
    display: none;
  }

  #vipPage #product-list.grid-changed .product-selection-price-text-top {
    height: 30px;
    display: flex;
    align-items: center;
    flex-direction: initial;
    justify-content: flex-start;
  }

  #vipPage #product-list.grid-changed .starRatinGImage {
    display: none;
  }

  #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner {
    padding: 0px;
  }

  #vipPage #product-list.grid-changed .medium-12 .small-desc,
  #vipPage #product-list.grid-changed .medium-12 .featureShippingPrice {
    display: none;
  }

  #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text-top {
    margin: 0px;
  }

  #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
    background-color: #ffffff !important;
  }

  #vipPage #product-list.grid-changed .product-selection-price-text {
    font-size: 18px;
  }

  #vipPage #product-list.grid-changed span.product-selection-price-text del:before {
    top: 10px;
    left: -8px;
  }

  #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
    font-size: 18px;
  }

  #vipPage #product-list.grid-changed .landing-product div[data-tagging="Featured!"] .featureTag {
    margin-right: 22px;
    top: 0px;
  }

  #vipPage #product-list.grid-changed #product-list .product-selection-description {
    margin-bottom: 0px;
  }

  #vipPage #product-list.grid-changed .medium-12 .selectPackageBox,
  #vipPage #product-list.grid-changed .medium-12 .packageQuantityBox {
    margin-right: 0;
  }

  #vipPage #product-list.grid-changed .thb-dark-column.medium-12.landing-product {
    margin-bottom: 0px;
  }


  div#product-list.grid-changed {
    margin-top: 20px;
  }

  #vipPage #product-list.grid-changed .active-recomendation-tab #product-list .product-selection-description {
    margin-bottom: 0px;
  }

  #vipPage #product-list.grid-changed .medium-3 .product-selection-description-parent-inner>.normalyAmount {
    display: none;
  }

  #vipPage #product-list.grid-changed .medium-3 .productDescriptionDiv {
    text-align: left;
  }

  #vipPage #product-list.grid-changed .product-selection-price-wrap button.btn {
    min-width: 220px;
  }

  #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
    max-width: inherit;
    width: auto;

  }

  .before-access-code h1 {
    display: block;
    font-size: 2em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    text-align: center;
    margin-top: 10px;
  }

  .secondary-area-mbt {
    /* display: block !important; */
  }

  .addPublicationModalPopup .modal.is-visible .modal-transition {
    top: 24%;
    left: 50%;
    transform: translate(-50%, -20%);
    width: 500px;
    height: 314px;
    margin-left: auto;
    margin-right: auto;
    height: auto;
    /* max-height: 400px; */

  }

  .addPublicationModalPopup .modal-content {
    height: auto;
  }

  .addPublicationModalPopup .modal-access-code .modal-content {
    overflow: initial;
    padding: 0;
  }



  section.shopLanderPageHader #product-list.productLandingPageContainer:not(.grid-changed) .small-12.landing-product:nth-child(6) .vc_column-inner {
    /* background-color: #e9e9f5 !important; */
  }

  #product-list .landing-product:not(.medium-12) .featureTag {
    background: #f8a18a;
  }

  #vipPage #product-list.grid-changed .medium-12 .featureTag,
  #vipPage #product-list.grid-changed .landing-product .featureTag {
    top: 0px;
    margin-right: 20px;
  }


  #vipPage .rowMbtInner {
    margin-left: auto;
    margin-right: auto;
  }

  #vipPage .row.after-success h1,
  #vipPage .row.after-success p {
    display: none !important;
  }

  #vipPage section.sectionHsaFsa,
  #vipPage .ourSuportedCustomers {
    max-width: 1420px;
    margin-left: auto;
    margin-right: auto;
  }



  #vipPage .medium-3 .product-selection-price-text-top.noflexDiv {
    /* display: block !important; */
    line-height: 1;
  }

  #vipPage #product-list:not(.grid-changed) .medium-3 .product-selection-price-text-top.noflexDiv {
    margin-bottom: 10px;
  }

  #vipPage #product-list:not(.grid-changed) .medium-6.landing-product .productDescriptionDiv {
    align-items: flex-start;
  }

  #vipPage .productLandingPageContainer .medium-3 span.product-selection-price-text del bdi,
  #vipPage .productLandingPageContainer .medium-6 span.product-selection-price-text del bdi {
    margin-right: 0;
  }

  #vipPage .productLandingPageContainer .medium-12.landing-product span.product-selection-price-text.hoo,
  #vipPage .productLandingPageContainer .medium-12.landing-product span.product-selection-price-text.heee {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .grid-changed #vipPage .medium-3 .product-selection-price-text-top.noflexDiv {
    text-align: left;
    padding-top: 4px;
  }

  .grid-changed #vipPage .medium-12 span.product-selection-price-text.heee {
    display: flex;
    align-items: center;
  }

  #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text {
    font-size: 24px;
    font-weight: 500;
  }

  #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount,
  #vipPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi {
    font-weight: 500;
  }

  #vipPage #product-list.grid-changed .medium-12 span.product-selection-price-text del:before {
    top: 14px;
  }

  #vipPage #product-list.grid-changed .product-selection-price-text-top {
    padding-top: 5px;
  }

  #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del span bdi,
  #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del span,
  #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del,
  #product-list.productLandingPageContainer .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount {
    font-weight: 500;
  }

  .hidden {
    display: none !important;
  }

  section.shopLanderPageHader .pageheaderTop .row {
    align-items: center;
    flex-wrap: initial;
    justify-content: center;
  }

  .banner-img.banner-text-center {
    position: relative;
    /* left: 2.5vw; */
  }

  section.shopLanderPageHader .pageheaderBotm {
    position: relative;
    z-index: 12;
  }

  #product-list .featureTag {
    font-size: 14px;
  }

  .back-order p {
    margin: 0;
  }

  .back-order {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
    display: none;
  }



  /* discount prices side by side with but line */
  #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text .wasText {
    display: none;
  }

  #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text del bdi {
    color: #c6c9cd;
    font-size: 100%;
  }

  #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text del:before {
    left: -1px;
    height: 2px;
    background: #f8a18a;
  }

  #vipPage #product-list:not(.grid-changed) .columns:not(.medium-12) span.product-selection-price-text del:before {
    top: 25px;
  }





  .italic-style {
    font-style: italic;
  }

  span.selec-option-to-share {
    font-size: 12px;
  }

  .access-code-handler {
    font-size: 12px;
    color: #f8a18a;
  }


  /* for only dentist page */

  .dentist-only-page #product-list .thb-dark-column.medium-3.landing-product,
  .dentist-only-page #product-list .thb-dark-column.medium-4.landing-product,
  .dentist-only-page #product-list .thb-dark-column.medium-6.landing-product {
    width: 100%;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
  }

  .dentist-only-page #product-list .medium-3.thb-dark-column.small-12.landing-product .product-selection-box,
  .dentist-only-page #product-list .medium-4.thb-dark-column.small-12.landing-product .product-selection-box,
  .dentist-only-page #product-list .medium-4.thb-dark-column.small-12.landing-product .product-selection-box {
    margin-top: 0;
    display: flex;
    align-content: center;
    justify-content: space-between;
    padding-left: 15px;
    position: relative;
  }

  .landing-product:not(.medium-12) .enter-access-code-to-view-pricing {
    display: none;
  }

  span.selec-option-to-share {
    /* display: none; */
  }

  .landing-product.medium-12 span.selec-option-to-share {
    display: inline-flex;
  }


  .landing-product.medium-12 span.selec-option-to-share {
    display: inline-flex;
  }

  #product-list.grid-changed .selec-option-to-share {
    display: inline-flex;
  }



  @media (min-width: 768px) {


    .landing-product.medium-6 span.selec-option-to-share {
      position: relative;
      top: 22px;
    }

    .banner-img.banner-image-retainer-cleaner img {
      position: relative;
      top: 37px;
    }

    .banner-img.banner-image-flosser img {
      position: relative;
      top: 69px;
    }

    section.shopLanderPageHader .pageheaderTop h1,
    section.shopLanderPageHader .pageheaderTop h1 span {
      font-size: 55px;
    }

    #vipPage #product-list.grid-changed .openPackage-quantity .packageQuantityBox,
    #vipPage #product-list.grid-changed .openPackage .selectPackageBox {
      max-width: 308px;
      right: 0;
      left: inherit;
      border-left: 1px solid #c5c6c9;
      margin-right: 0;
    }

    #vipPage section.ourCustomers .container {
      background: #eaeff3;
      padding-bottom: 65px;
    }

  }

  @media only screen and (max-width: 1024px) and (min-width: 768px) {

    #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
      max-width: 370px;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
      max-width: 50%;
      justify-content: center;
    }

  }

  @media (min-width: 1024px) {
    .vc_wp_text.wpb_content_element.warrabty-text-container {
      max-width: 82%;
    }

    #vipPage .gehanFormSection .seeDiscountBtn #send-my-discount {
      min-width: 400px;
    }

    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
      max-width: inherit;
      width: auto;
      min-height: 130px;
      max-height: 130px;
      /* background: orange!important; */
    }

    #vipPage #product-list.grid-changed .landing-product.medium-6 .product-selection-description-parent,
    #vipPage #product-list.grid-changed .landing-product.medium-3 .product-selection-description-parent {
      min-height: 130px;
      max-height: 130px;
      /* background: red!important; */

    }

    section.shopLanderPageHader .pageheaderBotm select {
      padding: 0 30px 0 10px;
      min-width: 186px;
      /* font-family: 'Montserrat'; */
    }


  }

  @media (max-width: 1500px) {
    #vipPage .productGripgSection h3 {
      font-size: 52px;
    }

    #vipPage .productGripgSection li {
      font-size: 20px;
      padding-left: 59px;
    }

    section.shopLanderPageHader .pageheaderTop h1,
    section.shopLanderPageHader .pageheaderTop h1 span {
      font-size: 46px;
    }

    section.shopLanderPageHader .pageheaderTop p {
      font-size: 16.8px;
    }

  }

  @media (max-width: 1300px) {
    #vipPage .productGripgSection h3 {
      font-size: 42px;
    }

    #vipPage .productGripgSection li {
      font-size: 16px;
    }

    #vipPage section.ourCustomers h2 {
      font-size: 48px;
    }

    #vipPage .rowMbt.extra_logo_before-top.logo-strip-one.justify-conten {
      margin-bottom: 60px;
    }

    #vipPage .mt-100 {
      padding-top: 56px;
    }


    section.shopLanderPageHader .pageheaderTop h1,
    section.shopLanderPageHader .pageheaderTop h1 span {
      font-size: 3.2vw;
    }

    section.shopLanderPageHader .pageheaderTop p {
      font-size: 1.4vw;
    }


  }

  @media (max-width: 767px) {

    #vipPage .geha-banner-text-section-parent {
      width: 100%;
    }

    #vipPage section.shopLanderPageHader .pageheaderTop {
      margin-top: 30px;
      padding-top: 8rem;
    }

    #vipPage h1.gehaLogoLarge img {
      max-width: 200px;
    }

    #vipPage .mt-100 {
      padding-top: 25px;
    }

    #vipPage .geha-banner-text-section h2 {
      margin-top: 20px;
      font-size: 26px;
      margin-bottom: 35px;
      line-height: 1.1;
    }

    #vipPage .graphicImagePeople {
      width: 100%;
      text-align: center;
    }

    #vipPage .splitTwo {
      width: calc(100%/1);
    }

    #vipPage .productGripgSection h3 {
      font-size: 34px;
      line-height: 33px;
      margin-bottom: 20px;
    }

    #vipPage .productGripgSection li {
      padding-left: 37px;
      background-size: 30px;
      line-height: 28px;
      text-align: left;
    }

    #vipPage .productGripgSection {
      padding: 20px;
    }

    #vipPage .productGripgSection ul {
      margin-bottom: 30px;
    }

    #vipPage .seeDiscountBtn button {
      font-size: 18px;
    }

    #vipPage .colhFsaSec {
      justify-content: center;
    }

    /* .sectionHsaFsa .colhFsaSec{order: 2;}
        .sectionHsaFsa .colhLogoSec{order: 1;}         */
    #vipPage section.ourCustomers h2 {
      font-size: 32px;
      line-height: 1;
      margin-top: 30px;
      margin-top: 0px;
      margin-bottom: 20px;
      padding-top: 40px;
    }

    #vipPage section.ourCustomers h3 {
      font-size: 18px;
      line-height: 1.4;
    }

    #vipPage section.ourCustomers {
      padding: 0 15px;
    }

    #vipPage section.ourCustomers h3 br {
      display: none;
    }

    #vipPage .customer-before-after-image {
      margin-top: 30px;
      margin-bottom: 38px;
    }

    #vipPage section.gehanFormSection {
      padding-top: 30px;
      padding-bottom: 25px;
      padding-left: 15px;
      padding-right: 10px;
    }

    .header-spacer {
      height: 60px !important;
    }

    #vipPage .productGripgSectionWrapper {
      padding: 0px;
    }

    #vipPage .logoesSecHfa img {
      max-width: 88px;
    }

    #vipPage .colhFsaSec {
      margin-bottom: 6px;
    }

    #vipPage .form-steps h5 {
      margin-bottom: 28px;
      font-size: 18px;
    }

    #vipPage section.ourSuportedCustomers.product-logo-wrapper {
      padding-top: 20px;
      padding-bottom: 16px;
      margin-top: 0px;
    }

    #vipPage .logoesformobileOnly .col-4 {
      max-width: 33.33%;
      -webkit-box-flex: 0;
      -ms-flex: 0 0 33.33%;
      flex: 0 0 33.33%;
      max-width: 33.33%;
      margin-bottom: 11px;
    }

    #vipPage .gehaLoginCustomer h3 {
      font-size: 16px;
    }

    #vipPage .pageHeader {
      position: relative;
    }

    #vipPage .shopLanderPageHader .mobileOptionDisplay.whitening-teeth-girl-with-smile {
      right: 0;
      top: 35px;
      max-width: 161px;
      left: 0;
      max-height: 210px;
      overflow: hidden;
    }

    .modal-content {
      width: 100%;
    }

    h2.youreInText {
      font-size: 53px;
    }

    #vipPage .descriptionBody {
      max-width: 100%;
    }

    h1.gehaTextmember {
      margin-bottom: 10px;
    }

    #vipPage .graphicImagePeople img {
      max-width: 283px;
    }

    #vipPage #product-list.grid-changed .product-selection-price-text-top {
      justify-content: center;
    }

    #vipPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
      align-items: flex-start;
      min-height: 0px;
    }

    #vipPage #product-list.grid-changed .medium-12 .product-selection-description b {
      padding-right: 0px;

    }

    #vipPage #product-list.grid-changed .medium-12 .product-selection-description b {
      font-size: 16px;
    }

    section.shopLanderPageHader .pageheaderTop h1,
    section.shopLanderPageHader .pageheaderTop h1 span {
      font-size: 24px;
    }

    section.shopLanderPageHader .pageheaderTop p {
      font-size: 14px;
    }

    section.shopLanderPageHader {
      margin-top: 0.5rem;
    }

    #vipPage #product-list.grid-changed .normalyAmount {
      margin-bottom: 0px;
    }

    .productLandingPageContainer span.product-selection-price-text del:before {
      left: -10px;
    }

    span.product-selection-price-text del:before,
    .body-plaque-highlighter span.product-selection-price-text del:before,
    .product-electric-toothbrush span.product-selection-price-text del:before {
      width: auto;
    }

    #vipPage .ourCustomers .container {
      padding-bottom: 40px;
    }

    #vipPage #product-list.grid-changed .product-selection-price-text-top {
      height: auto;
    }

    #product-list .product-selection-description b {
      padding-right: 0px;
    }

    #vipPage #product-list.grid-changed .product-selection-price-text-top {
      padding-top: 0px;
    }

    #vipPage #product-list.grid-changed .medium-3 .productDescriptionDiv {
      text-align: center;
    }

    #vipPage #product-list.grid-changed .product-selection-price-text-top {
      text-align: center;
      margin-bottom: 3px;
    }

    #product-list.productLandingPageContainer .medium-12 .product-selection-price-text-top {
      margin-top: 6px;
      margin-bottom: 6px;
    }

    #vipPage #product-list.grid-changed .wasTextParent-div,
    .wasTextParent-div {
      line-height: 1;
    }

    #vipPage .product-selection-description-parent-inner .normalyAmount,
    .normalyAmount {
      margin-bottom: 0px;
    }

    #vipPage div#product-list {
      margin-top: 24px;
    }

    section.shopLanderPageHader .pageheaderBotm select {
      font-size: 16px;
      min-width: 200px;
    }

    .tabsSectionrdhSec ul li a,
    .tabsSectionrdhSec ul li a.active {
      border-radius: 0;
    }

    .resetFilter a {
      font-size: 13px;
    }

    section.shopLanderPageHader .pageheaderTop h1,
    section.shopLanderPageHader .pageheaderTop h1 span {
      font-size: 20px;
    }

    #vipPage #product-list .landing-product:not(.medium-12) .product-selection-price-wrap {
      /* padding-top: 6px; */
    }

    #vipPage #product-list.productLandingPageContainer span.woocommerce-Price-amount.amount {
      line-height: 1;
    }

    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
      font-size: 14px;
    }

    #vipPage .vipPageBanner {
      margin-top: 55px;
    }

    .banner-img.banner-image-retainer-cleaner {
      position: relative;
      top: 31px;
    }

    .banner-img.banner-image-flosser {
      position: relative;
      top: 40px;
    }

    section.shopLanderPageHader .pageheaderTop {
      padding-top: 4rem;
    }

    #vipPage #product-list .columns span.product-selection-price-text del:before {
      top: 50% !important;
      transform: translateY(-50%);
    }

    #vipPage .ultrasonic-text-contain-by-js .backOrderList {
      top: -51px;
    }

    #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList,
    #vipPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList {
      line-height: 14px;
      top: -65px;
    }

  }


  #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent,
  #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent,
  #product-list:not(.grid-changed) .landing-product.medium-4 .product-selection-description-parent {
    overflow: inherit;
  }

  .overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #002343;
    opacity: 0.6;
    top: 0;
    z-index: 3;
  }

  .modal {
    position: absolute;
    z-index: 10000;
    /* 1 */
    top: 0;
    left: 0;
    visibility: hidden;
    width: 100%;
    height: 100%;
  }

  .modal.is-visible {
    visibility: visible;
    opacity: 1;
  }

  .modal-overlay {
    position: fixed;
    z-index: 10;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: hsla(0, 0%, 0%, 0.5);
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s linear 0.3s, opacity 0.3s;
  }

  .modal.is-visible .modal-overlay {
    opacity: 1;
    visibility: visible;
    transition-delay: 0s;
  }

  .modal-wrapper {
    position: fixed;
    z-index: 9999;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -2 0%);
    width: 25em;
    margin-left: -16em;
    background-color: #fff;
    border-radius: 12px;
    border: 4px solid #e8f8fc;
  }

  .modal-body {}

  .modal-body p {
    font-size: 14px;
    font-weight: 600;
    margin-top: 7px;
  }

  .modal-transition {
    transition: all 0.3s 0.12s;
    transform: translateY(-10%);
    opacity: 0;
  }

  .modal.is-visible .modal-transition {
    opacity: 1;
  }

  .modal-header,
  .modal-content {
    padding: 1em;
  }

  .modal-header {
    position: relative;
    background-color: #fff;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    text-align: center;
  }

  .modal-close,
  .modal-cross {
    position: absolute;
    top: 10px;
    right: 15px;
    padding: 5px 10px;
    color: #000;
    background: #fff;
    border: 1px solid #000;
    border-radius: 85px;
    font-size: 25px;
    font-weight: 600;
    cursor: pointer;

  }

  .after-access-code h1 {
    font-size: 20px;
    text-align: center;
    margin: 0;
  }

  .after-access-code {
    border: 1px dashed #9cebff;
    padding: 1rem;
    border-radius: 10px;
    background: #e8f8fc;
  }

  .addPublicationModalPopup .modal-content {
    padding-left: 0;
    padding-right: 0;
  }

  .before-access-code .modal-body {
    width: 92%;
  }

  .addPublicationModalPopup .before-access-code .form-group label {
    display: block;
    margin-bottom: 4px;
    font-size: 18px;
    font-weight: 600;
  }

  .modal-heading {
    font-size: 1.125em;
    margin: 0;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .modal-content>*:first-child {
    margin-top: 0;
  }

  .modal-content>*:last-child {
    margin-bottom: 0;
  }

  .check-button [type="checkbox"]:checked,
  .check-button [type="checkbox"]:not(:checked) {
    position: absolute;
    left: -9999px;
  }

  .check-button [type="checkbox"]:checked+label,
  .check-button [type="checkbox"]:not(:checked)+label {
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
  }

  .check-button [type="checkbox"]:checked+label:before,
  .check-button [type="checkbox"]:not(:checked)+label:before {
    content: '';
    position: absolute;
    right: 13px;
    /* top: 0; */
    width: 60px;
    height: 48px;
    border: 1px solid #a2a3a5;
    border-radius: 10px;
    background: #fff;
  }

  .check-button [type="checkbox"]:checked+label:after,
  .check-button [type="checkbox"]:not(:checked)+label:after {
    content: "\f00c";
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    position: absolute;
    top: 3px;
    right: 18px;
    /* border-radius: 100%; */
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    font-size: 44px;
    color: #04eb00;
    -webkit-text-stroke: 3px #fff;

  }

  .check-button [type="checkbox"]:not(:checked)+label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
  }

  .check-button [type="checkbox"]:checked+label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  #wrapper .check-button {}

  #wrapper .check-button label {
    min-height: 53px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    color: #fff;
    font-size: 22px;
    max-width: 290px;
    margin-left: auto;
    margin-right: auto;
    text-transform: capitalize;
    width: 100%;
    min-width: 239px;
  }

  .added-text {
    display: none;
  }

  .check-button [type="checkbox"]:checked+label .click-to-select {
    display: none;
  }

  .check-button [type="checkbox"]:checked+label .added-text {
    display: inline-block;
  }


  #wrapper .medium-6 .check-button label {
    font-size: 18px;
    padding-left: 15px;
    padding-right: 15px;
  }

  #wrapper .medium-6 .check-button [type="checkbox"]:checked+label:before,
  #wrapper .medium-6 .check-button [type="checkbox"]:not(:checked)+label:before {
    width: 52px;
    height: 38px;
  }

  #wrapper .medium-6 .check-button [type="checkbox"]:checked+label:after,
  #wrapper .medium-6 .check-button [type="checkbox"]:not(:checked)+label:after {
    font-size: 38px;
    top: 5px;
    right: 20px;
  }

  #wrapper .medium-3 .check-button label,
  #wrapper .medium-6 .check-button label,
  #wrapper .medium-4 .check-button label,
  #wrapper .medium-8 .check-button label,
  #wrapper .medium-12 .check-button label {
    font-size: 18px;
    padding-left: 15px;
    padding-right: 15px;
    /* color: red; */
    max-width: 240px;
    height: 38px;
    margin-bottom: 0;
  }

  #product-list.grid-changed .selec-option-to-share {
    /* background: orange; */
    display: none;
  }

  .requmended-by-dentist {
    width: 150px;
    height: 150px;
    overflow: hidden;
    position: absolute;
    z-index: 23;
  }

  .requmended-by-dentist::before,
  .requmended-by-dentist::after {
    position: absolute;
    /* z-index: -1; */
    content: '';
    display: block;
    border: 5px solid #ff8e6b;
  }

  .requmended-by-dentist span {
    position: absolute;
    display: block;
    width: 225px;
    padding: 22px 0;
    background-color: #ffa488;
    box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
    color: #fff;
    font-family: 'Montserrat';
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    text-transform: uppercase;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    padding-top: 10px;


  }

  .by-dentist-tag {
    font-size: 90%;
    position: absolute;
    right: 0;
    left: 0;
    top: 26px;

  }

  .selected-for-share .product-selection-box {
    border-color: #ffa488;
    box-shadow: 0px 0px 10px #808080a8;
  }

  /* top right*/
  .ribbon-top-right {
    top: -10px;
    right: -10px;
  }

  .ribbon-top-right::before,
  .ribbon-top-right::after {
    border-top-color: transparent;
    border-right-color: transparent;
  }

  .ribbon-top-right::before {
    top: 0;
    left: 0;
  }

  .ribbon-top-right::after {
    bottom: 0;
    right: 0;
  }

  .ribbon-top-right span {
    left: -25px;
    top: 30px;
    transform: rotate(45deg);
  }

  #wrapper .medium-3 .check-button label,
  #wrapper .medium-6 .check-button label {
    /* min-height: 44px; */
  }

  #wrapper .medium-6 .check-button [type="checkbox"]:checked+label:before,
  #wrapper .medium-6 .check-button [type="checkbox"]:not(:checked)+label:before,
  #wrapper .medium-3 .check-button [type="checkbox"]:checked+label:before,
  #wrapper .medium-3 .check-button [type="checkbox"]:not(:checked)+label:before {
    /* width: 42px;
    height: 32px; */
  }

  #wrapper .medium-6 .check-button [type="checkbox"]:checked+label:after,
  #wrapper .medium-6 .check-button [type="checkbox"]:not(:checked)+label:after {
    /* top: 0px; */
  }

  .medium-6 .check-button [type="checkbox"]:checked+label:after,
  .check-button [type="checkbox"]:not(:checked)+label:after,
  .medium-3 .check-button [type="checkbox"]:checked+label:after,
  .check-button [type="checkbox"]:not(:checked)+label:after {
    /* top: -4px;
    right: 10px; */

  }

  .active-profile-tab section.shopLanderPageHader.dental-systm-wrapper-tp,
  .active-contact-tab section.shopLanderPageHader.dental-systm-wrapper-tp {
    display: none;
  }

  .active-recomendation-tab section.shopLanderPageHader.dental-systm-wrapper-tp {
    display: block;
  }


  #product-list.grid-changed a.access-code-handler.enter-access-code-to-view-pricing {
    visibility: hidden;
    opacity: 0;
    display: none;

  }

  #wrapper #product-list.grid-changed .check-button label {
    font-size: 16px;
  }

  #product-list.productLandingPageContainer .product-selection-box {
    border-radius: 10px;
  }

  #vipPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
  #vipPage .packageQuantityBox,
  .selectPackageBox,
  #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
    border-radius: 0px 0 10px 10px;
  }

  /* fixing featured product styling */

  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
    color: #565759;
    font-size: 28px;
    font-weight: 700;
  }



  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description .productDescriptionDiv {
    margin-bottom: 10px;
    margin-top: 5px;
  }

  #vipPage #product-list:not(.grid-changed) .productLandingPageContainer .sepratorLine {
    margin-top: 1.5rem;
  }

  #vipPage #product-list:not(.grid-changed) .starRatinGImage {
    margin-bottom: 10px;
  }

  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .spec-heding {
    margin-bottom: 5px;
  }

  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .small-desc h4,
  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .small-desc h5 {
    font-size: 14px;
  }

  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .spec-heding {
    max-width: 380px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.5;
  }

  #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-price-text-top {
    margin-top: 25px;
  }

  .active-recomendation-tab #product-list .product-selection-description {
    margin-bottom: 0px;
  }

  .after-access-code strong a {
    display: flex;
    margin-top: 5px;
    font-size: 12px;
    justify-content: center;
    font-weight: normal;
    align-content: center;
    column-gap: 5px;
    text-decoration: underline;
  }


/* feedback 26/6 */

.after-access-code .btn-access-pricing{

    max-width: 280px;
    margin-left: auto;
    margin-right: auto;
    text-decoration: none;
    letter-spacing: 0;
    font-size: 16px;
    border-radius: 3px;
    letter-spacing: 0.5px;
    font-weight: 300;
    font-family: 'Montserrat';
    background-color: #1fb6e4;
    border-color: #1fb6e4;
    border-radius: 10px;

}
.after-access-code .btn-access-pricing:hover{
  background-color: #595858;
    border-color: #595858;
}
.buttonAddedByJsAppended {
    margin-top: 10px;
}
.buttonAddedByJsAppended a{

    margin-left: auto;
    margin-right: auto;
    text-decoration: none;
    letter-spacing: 0;
    font-size: 16px;
    border-radius: 3px;
    letter-spacing: 0.5px;
    font-weight: 300;
    font-family: 'Montserrat';
    background-color: #1fb6e4;
    border-color: #1fb6e4;
    border-radius: 6px;
    color: #fff;
    display: flex;
    justify-content: center;
    margin-top: 5px;
}

/* ends feedback 26/6 */

  /* for fixing landscape layouts */
  @media only screen and (max-width: 1000px) and (orientation: landscape) {
    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
      max-width: 352px;
      margin-left: auto;
      margin-right: auto;
    }

    .page-template .subscription-product-detail .caripro-content h1 {
      /* color: red; */
    }

    #vipPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
      right: 21px;
      max-width: 304px;
      top: -43px;
    }

    #vipPage section.shopLanderPageHader .pageheaderTop {
      margin-top: 10px;
    }

    section.shopLanderPageHader .pageheaderTop {
      padding-top: 3rem;
      padding-bottom: 3rem;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list .medium-3 span.product-selection-price-text ins bdi,
    .page-template-geha-template #product-list .medium-6 span.product-selection-price-text ins bdi,
    .page-template-geha-template #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #vipPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi {
      font-size: 22px;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .product-selection-price-text-top {
      min-width: initial;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .discountedPriceForGehaMember {
      font-size: 10px;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
      font-size: 23px;
    }

    #product-list.productLandingPageContainer .featuredproductNameSubtitle {
      font-size: 13px;
    }

    #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
      max-width: 390px;
    }


    #product-list.productLandingPageContainer .medium-12 .product-selection-box.cariPro_dental_probiotics_byJs .product-selection-image-wrap img {
      max-width: 223px;
      margin-top: 0;
    }

    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
      max-width: 96%;
      padding-top: 2rem;
    }

    .subscription-product-detail {
      width: 100%;
    }

    #vipPage #product-list .product-selection-price-wrap button.btn,
    #vipPage #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue,
    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
      width: auto;
    }

    #vipPage #product-list.grid-changed .medium-12 .product-selection-description b,
    #product-list.grid-changed .product-selection-description b {
      /* color: orange !important; */
      font-size: 14px;
    }


  }





  @media (max-width: 1500px) {

    #vipPage #product-list:not(.grid-changed) .medium-3 .check-button label {
      min-width: 100%;
      /* background: orange !important; */
      font-size: 14px;
    }


    #vipPage #product-list .product-selection-price-wrap button.btn,
    #vipPage #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue,
    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
      /* background: red !important; */
      font-size: 14px;

    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
      width: 90%;
      margin-left: auto;
      margin-right: auto;
      /* border: 10px solid orange; */
    }

  }





  @media (min-width: 767px) and (max-width: 1023px) {

    .active-recomendation-tab #product-list.grid-changed .landing-product.medium-3 .product-selection-description-parent,
    #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent,
    .active-recomendation-tab #product-list.grid-changed .medium-6.landing-product .product-selection-description-parent {
      min-height: 120px;
      max-height: 120px;
      /* background: blue !important; */
    }

  }


  @media only screen and (min-width: 900px) and (max-width: 1200px) {

    #wrapper #vipPage #product-list:not(.grid-changed) .medium-3 .check-button label,
    #wrapper #vipPage #product-list:not(.grid-changed) .medium-6 .check-button label,
    #wrapper #vipPage #product-list:not(.grid-changed) .medium-4 .check-button label,
    #wrapper #vipPage #product-list:not(.grid-changed) .medium-8 .check-button label,
    #wrapper #vipPage #product-list:not(.grid-changed) .medium-12 .check-button label {
      /* background: purple !important; */
      font-size: 14px;
    }

    #vipPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
      max-width: initial;
      margin-left: -15px;
      margin-right: -15px;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box .product-selection-image-wrap {
      max-width: 50%;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box img {
      max-width: 100%;
    }

    .active-recomendation-tab #product-list .landing-product.medium-3 .product-selection-description-parent,
    .active-recomendation-tab #product-list .medium-6.landing-product .product-selection-description-parent {
      /* min-height: 120px;
      max-height: 120px; */
      /* background: blue !important; */
    }

    #vipPage #product-list.grid-changed .product-selection-price-wrap button.btn {
      max-width: 200px;
      min-width: 200px;
    }

    #product-list:not(.grid-changed) span.woocommerce-Price-amount.amount {
      font-size: 26px;
    }
  }


  @media only screen and (min-width: 768px) and (max-width: 900px) {

    #wrapper #vipPage #product-list.grid-changed .medium-3 .check-button label,
    #wrapper #vipPage #product-list.grid-changed .medium-6 .check-button label,
    #wrapper #vipPage #product-list.grid-changed .medium-4 .check-button label,
    #wrapper #vipPage #product-list.grid-changed .medium-8 .check-button label,
    #wrapper #vipPage #product-list.grid-changed .medium-12 .check-button label {
      /* background: blue !important; */
    }


    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box .product-selection-image-wrap {
      max-width: 50%;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box img {
      max-width: 100%;
    }




  }






  @media (min-width: 768px) {

    .check-button [type="checkbox"]:checked+label:before,
    .check-button [type="checkbox"]:not(:checked)+label:before {
      width: 52px;
      height: 38px;
    }


    #product-list.grid-changed .view-pricing-button-css {
      /* min-width: 140px;
    right: -254px;
    top: -14px;
 */
      position: static;
      margin-top: 16px;
      max-width: 200px;
      margin-left: 0;
    }

    #product-list.grid-changed .medium-3 .view-pricing-button-css {
      /* top: -50px;
    right: -353px; */
    }

    #product-list.grid-changed .medium-3.adjust-pricing-button-by-js .product-selection-price-text-top {
      margin-top: 0px;

    }

  }




  /* for fixing landscape layouts */
  @media only screen and (max-width: 1000px) and (orientation: landscape) {


    #vipPage section.shopLanderPageHader .pageheaderTop {
      margin-top: 10px;
    }

    section.shopLanderPageHader .pageheaderTop {
      padding-top: 3rem;
      padding-bottom: 3rem;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del,
    .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #product-list .medium-3 span.product-selection-price-text ins bdi,
    .page-template-geha-template #product-list .medium-6 span.product-selection-price-text ins bdi,
    .page-template-geha-template #vipPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-template-geha-template #vipPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi {
      font-size: 22px;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .product-selection-price-text-top {
      min-width: initial;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .discountedPriceForGehaMember {
      font-size: 10px;
    }

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
      font-size: 23px;
    }

    #product-list.productLandingPageContainer .featuredproductNameSubtitle {
      font-size: 13px;
    }

    #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
      max-width: 390px;
    }


    #product-list.productLandingPageContainer .medium-12 .product-selection-box.cariPro_dental_probiotics_byJs .product-selection-image-wrap img {
      max-width: 223px;
      margin-top: 0;
    }

    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
      max-width: 96%;
      padding-top: 2rem;
    }

    .subscription-product-detail {

      width: 100%;
    }


  }


  @media only screen and (min-width: 768px) and (max-width: 104px) {

    #product-list:not(.grid-changed) span.woocommerce-Price-amount.amount {
      font-size: 22px;
    }

    span.selec-option-to-share {
      font-size: 10px;
      line-height: 1;
    }

    #wrapper .check-button label {
      min-width: 200px;
      font-size: 14px;
    }





  }

  .loader-container {
    margin: 0 auto;
    width: 100%;
    max-width: 90%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 1px solid #c5c6c9;
    padding: 1rem;
    border-radius: 5px;
    margin-top: 2rem;
  }

  @keyframes placeholder {
    0% {
      background-position: -600px 0
    }

    100% {
      background-position: 600px 0
    }
  }

  .animated-background {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeholder;
    animation-timing-function: linear;
    background: #eeeeee;
    background: linear-gradient(to right, #eee 8%, #ddd 18%, #eee 33%);
    background-size: 1200px 100px;
    min-height: 22px;
    width: 100%;
    margin: 5px 0 5px 0;
    border-radius: 3px
  }

  .profile-image.animated-background {
    margin-top: 10px;
    margin-bottom: 3rem;
    /* border-radius: 50%; */
    width: 150px;
    height: 150px;
  }


  @media (max-width: 767px) {

    #vipPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
      width: 100%;
    }

    .user-profile-hero.no-bkground-required {
      display: none;
    }

    html body .user-profile-hero:not(.no-bkground-required) {
      padding-top: 50px;
    }

    #wrapper .medium-3 .check-button label,
    #wrapper .medium-6 .check-button label,
    #wrapper .medium-4 .check-button label,
    #wrapper .medium-8 .check-button label,
    #wrapper .medium-12 .check-button label {
      min-width: initial !important;
    }


    .addPublicationModalPopup .modal.is-visible .modal-transition {
      width: 88%;
      transform: translate(-50%, -24%);
    }


    .medium-6 .product-selection-description-parent-inner .drtext {
      position: static;
      justify-content: center;
    }

    #vipPage div#product-list.grid-changed .drtext {
      justify-content: center;
    }

    #product-list .medium-6 .view-pricing-button-css {
      margin-right: auto;
    }

    .addPublicationModalPopup .modal-close {
      display: inline-block;
    }

    .user-profile-hero {
      margin-bottom: 0px;
    }

    .logged-in .rdhHeaderWrapper .secondary-area-mbt {
      /* top: -2px; */
    }

    .profile-container-wrapper.rdhTemplateWrapper {
      margin-top: 0px;
    }

    .user-profile-hero {
      padding-bottom: 0px;
    }

    .user-profile-hero.rdhHeaderWrapper {
      padding-bottom: 15px;
      margin-bottom: 0;
    }

    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
      font-size: 18px;
    }

    .user-profile-hero .nav-men-wrapper .navigation-menu-body {
      top: 15px;
      right: 0;
    }

    html body .navigation-menu-body #contentThatFades {
      flex-wrap: wrap;
    }

    html body .navigation-menu-body #contentThatFades>li {
      /* width: 50%; */
    }

    .fixed-header-on .header {
      position: absolute;
    }

    .secondary-area-mbt {
      right: 54px;
      top: initial;
    }

    .burgerNav {
      width: 30px;
    }

    header .user-login {
      top: initial;
    }

    .dr-name-displayer {
      font-size: 14px;
      margin-top: 8px;
      margin-bottom: 15px;
    }



    .profile-container {
      width: 98%;
      max-width: 98%;
    }

    .rdh-profile-top-section .profile-detail {
      width: 85%;
    }

    .phonenumber a {
      line-break: anywhere;
      line-height: 1.4;
      /* color: #797a7a; */
    }

    section.shopLanderPageHader {
      margin-top: 0;
    }

    .combineWrapper {
      top: 0;
    }

    .user-login .fa-user-o:before {
      align-items: initial;
    }
  }
</style>

<div class="profile-container-wrapper rdhTemplateWrapper" id="vipPage">

  <!--user profile header section-->

  <div class="user-profile-hero no-bkground-required">
    <div class="tabsSectionrdhSec">

      <div class="profile-container">

        <div class="list-items Montserrat">

          <ul id="list_items_mbt">

            <li style="
    opacity: 0;display:none;
"><a id="profile-active" data-href-cust="/dentist/profile/<?php echo get_query_var('dentist_name'); ?>">About</a></li>

            <?php

            $affwp_product_rates = get_user_meta($user_id, 'affwp_product_rates', true);
            $rdh_recommended_toggle_show = get_user_meta($user_id, 'rdh_recommended_url', true);
            $rdh_recommended_toggle_show = 'show';
            if ($rdh_recommended_toggle_show != 'hide') { ?>

              <li><a class="active" id="reco-active"
                  data-href-cust="/dentist/products/<?php echo get_query_var('dentist_name'); ?>?ref=<?php echo $affiliate_id; ?>">All
                  Products</a></li>
            <?php } ?>
            <li style="
    opacity: 0;display:none;
"><a id="contact-active" data-href-cust="/dentist/contact/<?php echo get_query_var('dentist_name'); ?>">Contact Me</a>
            </li>
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





    <section class="shopLanderPageHader dental-systm-wrapper-tp">
      <div class="pageheaderBotm">
        <div class="row no-flex">
          <div class="flex-row">
            <div class="filterproductsOption" style="display: none;">
              <select id="filter_products">
                <option value="all" style="font-family: 'Open Sans', sans-serif;">All products</option>
                <option value="Bundle &amp; Save" style="font-family: 'Open Sans', sans-serif;">Bundle &amp; Save</option>
                <option value="Featured!" style="font-family: 'Open Sans', sans-serif;">Featured!</option>
                <option value="Low Stock" style="font-family: 'Open Sans', sans-serif;">Low Stock</option>
              </select>
            </div>
            <?php

            $recommen_selected = "";
            $recomend_option = "";
            if ($selected_products != '') {
              $recommen_selected = "selected";
              $recomend_option = ' <option value="select-high-to-low" ' . $recommen_selected . '>Recommended for you</option>';
            }
            ?>
            <div class="all-product-dropdown">
              <select id="price-sort">
                <option value="default" style="font-family: 'Open Sans', sans-serif;">All products</option>
                <?php echo $recomend_option; ?>
                <option value="price-low-to-high" style="font-family: 'Open Sans', sans-serif;">Low price to high</option>
                <option value="price-high-to-low" style="font-family: 'Open Sans', sans-serif;">high price to low</option>
                <option value="newest" style="font-family: 'Open Sans', sans-serif;">Newest</option>
              </select>
            </div>
            <div class="resetFilter">
              <a href="javascript:;" id="resetButton" style="font-family: 'Open Sans', sans-serif;">Reset </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>

      landing_str = '';

      var product_list;

      var landing_products;

      jQuery(document).on('change', '#filter_products', function () {

        show_hide_div_by_tag(jQuery(this).val());

      });

      jQuery(document).ready(function () {

        counter = 0;

        jQuery('.lander-shortcode').each(function () {

          data_Str = '';

          current_html = jQuery(this).parents('.wpb_column').html();

          col_class = jQuery(this).parents('.wpb_column').attr('class') + ' landing-product';

          data_Str += 'data-price="' + jQuery(this).data('price') + '"';

          data_Str += 'data-recommended="' + jQuery(this).data('recommended') + '"';

          data_Str += 'data-date="' + jQuery(this).data('date') + '"';

          data_Str += 'data-default="' + counter + '"';

          data_Str += 'data-tagging="' + jQuery(this).data('tagging') + '"';

          // col_class = col_class.replace("medium-9", "medium-6");

          // col_class = col_class.replace("medium-7", "medium-6");

          // col_class = col_class.replace("medium-12", "medium-6");

          // jQuery(this).parent('.landing-product').attr('price',jQuery(this).attr('price'));

          // 		jQuery(this).parent('.landing-product').attr('date',jQuery(this).attr('date'));

          // 		jQuery(this).parent('.landing-product').attr('recommended',jQuery(this).attr('recommended'));

          landing_str += '<div class="' + col_class + '" ' + data_Str + '>' + current_html + '</div>';

          counter++;



        });

        jQuery('#product-list').html(landing_str);

        setTimeout(function () {

          // jQuery(document).find('.lander-shortcode').each(function(){

          // 	jQuery(this).parent('.landing-product').attr('price',jQuery(this).attr('price'));

          // 	jQuery(this).parent('.landing-product').attr('date',jQuery(this).attr('date'));

          // 	jQuery(this).parent('.landing-product').attr('recommended',jQuery(this).attr('recommended'));

          // });

          landing_products = jQuery(document).find('.landing-product');

          product_list = $('#product-list');

          str = '<option value="all">All products</option>';

          jQuery(document).find('.landing-product').each(function () {

            attr_val = jQuery(this).data('tagging');

            if (str.includes(attr_val) || attr_val == 'Select') {

              // continue

            }

            else {

              str += '<option value="' + attr_val + '">' + attr_val + '</option>';

            }



          });

          jQuery('#filter_products').html(str);

        }, 500);


        jQuery(document).on('change', '#price-sort', function() {

//alert($(this).val());

if ($(this).val() == 'price-low-to-high') {

  sortAsc('price');

}

else if ($(this).val() == 'price-high-to-low') {

  sortDesc('price');

}
else if ($(this).val() == 'select-high-to-low') {

  sortDesc('selected');

}

else if ($(this).val() == 'newest') {

  sortDesc('date');

}

else if ($(this).val() == 'default') {

  sortAsc('default');

}

else {

  sortAsc('recommended');

}

addremClass();





});


      });


      function show_hide_div_by_tag(tag_val) {

        if (tag_val == 'all') {

          jQuery('.landing-product').show();



        }

        else {

          jQuery(document).find('.landing-product').each(function () {

            attr_val = jQuery(this).data('tagging');

            if (tag_val != attr_val) {

              jQuery(this).hide();

            }

            else {

              jQuery(this).show();

            }

          });

        }

        addremClass();



      }

      function addremClass() {

        if (jQuery('#price-sort').val() != 'default' || (jQuery('#filter_products').val() != 'all')) {

          jQuery('#wrapper,#product-list').addClass('grid-changed');

        }

        else {

          jQuery('#wrapper,#product-list').removeClass('grid-changed');

        }

      }

      function sortAsc(attr) {

        product_list.empty();

        landing_products.sort(function (a, b) {

          return $(a).data(attr) - $(b).data(attr)

        });

        product_list.append(landing_products);

      }

      function sortDesc(attr) {
        //alert(attr);
        product_list.empty(attr);

        landing_products.sort(function (a, b) {

          return $(b).data(attr) - $(a).data(attr)

        });

        product_list.append(landing_products);

      }

      jQuery(document).ready(function () {
        setTimeout(function () { jQuery('#price-sort').trigger('change'); }, 1000);

        jQuery('#resetButton').click(function () {
          jQuery('#filter_products').val('all');
          jQuery('#price-sort').val('default');
          jQuery('#filter_products').trigger('change');
          jQuery('#price-sort').trigger('change');

        })
      });


    </script>



    <div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer rdhtabs">

      <div class="loader-container">
        <div class="animated-background profile-image"></div>
        <div class="animated-background" style="width: 70%"></div>
        <div class="animated-background"></div>
        <div class="animated-background"></div>
        <div class="animated-background"></div>
        <div class="animated-background" style="width: 50%"></div>
      </div>


      <div class="row-t product-item-display profile-container sale-page rdhtabs" style="display:none">
        <?php
        $product_found = get_user_meta($user_id, 'product_found', true);
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
        $page_id = $wpdb->get_var($wpdb->prepare($get_redhc_page));
        if ($page_id != '') {
          $page = get_post($page_id);
          $content = apply_filters('the_content', $page->post_content);
          echo $content;
        }

        if ($product_found == '') {
          ?>
          <script>
            jQuery(document).ready(function () {

              //jQuery('#reco-active').remove();
            });

          </script>

          <?php
        } else {
          //echo 'found';
        }
        //$existing_value = get_user_meta($user_id,'rdhc_discounted_products',true);
        // echo '<pre>';
        // print_r($existing_value);
        // echo '</pre>';
        // echo $user_id;
        ?>
        <script>
          jQuery(document).ready(function () {
            if (jQuery('.lander-shortcode').length > 0) {
              //
              console.log('exists');
            }
            else {
              jQuery('#reco-active').remove();
              console.log('no exist');
            }
          });
        </script>
        <div class="col-lg-12 itemProducts">

          <?php
          if (isset($affwp_product_rates['woocommerce']) && is_array($affwp_product_rates['woocommerce'])) {
            foreach ($affwp_product_rates['woocommerce'] as $arr) {
              continue;
              foreach ($arr['products'] as $key => $val) {

                $product_id = $val;

                $rate_sale = $arr['rate_sale'];

                $type_sale = $arr['type_sale'];

                $product = wc_get_product($product_id);

                $pprice = (int) $product->get_price();

                $discount = 0;

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

                $pid = $product_id;

                $_product = $product;



                $sale_price = get_post_meta($pid, '_price', true) - $discount;

                $still_available = get_post_meta($pid, 'still_available', true);

                $bogo_custom_title = get_post_meta($pid, 'bogo_custom_title', true);



                ?>
                <div class="product-selection-box-parent">

                  <div class="product-selection-box">

                    <div class="row-t-mm">

                      <div class="product-selection-title-right">

                        <span class="availableItem">
                          <?php echo $still_available; ?> STILL AVAILABLE
                        </span> <span class="saveOnItem">SAVE $
                          <?php echo get_post_meta($pid, 'sale_page_discount', true); ?>
                        </span>

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

                                  $ptitle = get_the_title($pid);
                                }

                                $ptitle = get_the_title($pid);
                              } else {

                                $ptitle = $bogo_custom_title;
                              }



                              ?>

                              <?php echo $ptitle; ?>

                            </span>



                            <div class="row-mbt-product justify-content-between maxwidth80">

                              <?php



                              if ($_product->is_on_sale()) {

                                ?>

                                <div class="original-price">

                                  <div class="price-was gray-text line-thorough"><span class="wasText">was </span><span
                                      class="doller-sign">$</span>
                                    <?php echo $_product->get_regular_price(); ?>
                                  </div>

                                </div>



                                <div class="sale-price">



                                  <div class="price-new "><span class="doller-sign">$</span>
                                    <?php echo $_product->get_sale_price(); ?>
                                  </div>

                                </div>

                                <?php

                              } else {

                                ?>

                                <div class="original-price">



                                  <div class="price-was gray-text line-thorough"><span class="wasText">was </span><span
                                      class="doller-sign">$</span>
                                    <?php echo get_post_meta($pid, '_price', true); ?>
                                  </div>

                                </div>



                                <div class="sale-price">

                                  <div class="price-new "><span class="doller-sign">$</span>
                                    <?php echo $sale_price; ?>
                                  </div>

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

                                <button
                                  class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart <?php echo $addedClass; ?>"
                                  href="?add-to-cart=<?php echo $pid; ?>" <?php echo $string_bogo; ?> data-quantity="1"
                                  data-product_id="<?php echo $pid; ?>" data-action="woocommerce_add_order_item">ADD TO
                                  CART</button>

                                <?php

                              } else {

                                ?>

                                <button
                                  class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart <?php echo $addedClass; ?>"
                                  href="?add-to-cart=<?php echo $pid; ?>" <?php echo $string_bogo; ?> data-quantity="1"
                                  data-product_id="<?php echo $pid; ?>" data-rdh_sale_price="<?php echo $sale_price; ?>"
                                  data-action="woocommerce_add_order_item">ADD TO CART</button>

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

      <p>CONTACT
        <?php echo strtoupper($user_firstname); ?>
        <?php echo strtoupper($user_lastname); ?>
      </p>

    </div>

    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <div class="flex-wrap">

      <div class="contactFormWrapper">
        <div id="rdhResponse"></div>
        <form class="rdhContact" id="rdhContactForm">

          <div class="form-group">
            <label for="contactFormName" class="upper"><i class="fa fa-user"></i>Your Name</label><br>
            <span class="wpcf7-form-control-wrap user-name"><input type="text" name="user-name" value="" size="40"
                class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true"
                aria-invalid="false" placeholder="Your Name"></span>
          </div>
          <div class="form-group">
            <label for="contactFormEmail" class="upper"><i class="fa fa-envelope"></i>Your Email</label><br>
            <span class="wpcf7-form-control-wrap user-email"><input type="email" name="user-email" value="" size="40"
                class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control"
                aria-required="true" aria-invalid="false" placeholder="Your Email"></span>
          </div>
          <div class="form-group select-field">
            <label for="contactType" class="upper"><i class="fa fa-cog"></i>MESSAGE TYPE</label><br>
            <span class="wpcf7-form-control-wrap type"><select name="type" class="wpcf7-form-control wpcf7-select"
                aria-invalid="false">
                <option value="General Inquiry">General Inquiry</option>
              </select></span>
          </div>

          <div class="form-group text-area-wrapper">
            <label for="contactFormMessage" class="upper"><i class="fa fa-pencil"></i>YOUR MESSAGE</label><br>
            <span class="wpcf7-form-control-wrap message">
              <textarea name="message" cols="40" rows="6"
                class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required form-control-large"
                aria-required="true" aria-invalid="false" placeholder="Enter Your Message"></textarea></span>
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
        jQuery("body").on("click", "#btn_rdhContactForm", function () {



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

            success: function (response) {

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

          <p class="follow-social-text">Follow
            <?php echo $user_firstname; ?>
            <?php echo $user_lastname; ?>
          </p>

          <ul>

            <?php $style_s_follow = "none;" ?>

            <?php if (get_user_meta($user_id, 's_facebook', true) != '') {

              $style_s_follow = "block";

              ?>

              <li> <a href="http://www.facebook.com/<?php echo get_user_meta($user_id, 's_facebook', true); ?>"><img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fb.png" alt="" srcset=""></a> </li>

              <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_twitter', true) != '') {

              $style_s_follow = "block";

              ?>

              <li> <a href="http://www.twitter.com/<?php echo get_user_meta($user_id, 's_twitter', true); ?>"><img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/twitr.png" alt="" srcset=""></a>
              </li>

              <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_linkedin', true) != '') {

              $style_s_follow = "block";

              ?>

              <li> <a href="http://www.linkedin.com/in/<?php echo get_user_meta($user_id, 's_linkedin', true); ?>"> <img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/linkdin.png" alt="" srcset=""></a>
              </li>

              <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_instagram', true) != '') {

              ?>

              <li> <a href="http://www.instagram.com/<?php echo get_user_meta($user_id, 's_instagram', true); ?>"><img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insta.png" alt="" srcset=""></a>
              </li>

              <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_youtube', true) != '') {

              $style_s_follow = "block";

              ?>



              <li> <a href="http://www.youtube.com/<?php echo get_user_meta($user_id, 's_youtube', true); ?>"><img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/youtube.png" alt="" srcset=""></a>
              </li>

              <?php

            }

            ?>

            <?php if (get_user_meta($user_id, 's_tikTok', true) != '') {

              $style_s_follow = "block";

              ?>



              <li class="ticktokIcon"> <a
                  href="http://www.tiktok.com/@<?php echo get_user_meta($user_id, 's_tikTok', true); ?>"><img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tiktok.svg" alt="" srcset=""></a>
              </li>

              <?php

            }

            ?>

            <?php



            if (get_user_meta($user_id, 's_blog', true) != '') {

              $style_s_follow = "block";



              ?>



              <li class="blockIcon_mbt"> <a href="<?php echo get_user_meta($user_id, 's_blog', true); ?>"><i
                    class="fa fa-link" aria-hidden="true"></i></a> </li>

              <?php

            }

            ?>

          </ul>

          <style>
            .follow-social-text {
              display:
                <?php echo $style_s_follow; ?>
            }
          </style>

        </div>

      </div>


    </div>


    <?php

    //  echo show_chat_widget_rdh_profile($user_id); ?>



  </div>



  <?php



  //  } else {
  
  ?>





  <div class="rdhtabs profile-container-all" style="display:none">

    <div class="profile-container">

      <div class="user-details-wrapper gap-between-elements-60">

        <div class="profile-detail Montserrat  ">

          <h3 class="font-mont">
            <?php echo $user_firstname; ?>
            <?php echo $user_lastname; ?>
          </h3>

          <p class="designation font-mont">
            <?php echo $rdh_subtitle; ?>
          </p>

          <div class="address">

            <!-- <p>HOME TOWN</p> -->

            <p class="font-mont">
              <?php echo $address_town_city; ?>,
              <?php echo $address_state; ?>,
              <?php echo $address_country; ?>
            </p>

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
          $rdhc_video_ = get_user_meta($user_id, 'rdhc_video_', true);
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
            if ($rdhc_video_ != '') {
              ?>

              <div class="introVideo order-1m ss">

                <div class="iframe-video">

                  <?php echo $rdhc_video_; ?>

                </div>

                <div class="video-title">

                  Meet
                  <?php echo $user_firstname; ?>
                  <?php echo $user_lastname; ?> RDH

                </div>



              </div>

            <?php }
          } ?>



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

                <li> <a href="http://www.facebook.com/<?php echo get_user_meta($user_id, 's_facebook', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fb.png" alt="" srcset=""></a> </li>

                <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_twitter', true) != '') {

                ?>

                <li> <a href="http://www.twitter.com/<?php echo get_user_meta($user_id, 's_twitter', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/twitr.png" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_linkedin', true) != '') {

                ?>

                <li> <a href="http://www.linkedin.com/in/<?php echo get_user_meta($user_id, 's_linkedin', true); ?>"> <img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/linkdin.png" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_instagram', true) != '') {

                ?>

                <li> <a href="http://www.instagram.com/<?php echo get_user_meta($user_id, 's_instagram', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insta.png" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_youtube', true) != '') {

                ?>



                <li> <a href="http://www.youtube.com/<?php echo get_user_meta($user_id, 's_youtube', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/youtube.png" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

              <?php if (get_user_meta($user_id, 's_tikTok', true) != '') {

                ?>



                <li> <a href="http://www.tiktok.com/@<?php echo get_user_meta($user_id, 's_tikTok', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tiktok.svg" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

              <?php



              if (get_user_meta($user_id, 's_blog', true) != '') {



                ?>



                <li> <a href="<?php echo get_user_meta($user_id, 's_blog', true); ?>"><img
                      src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/blog.png" alt="" srcset=""></a>
                </li>

                <?php

              }

              ?>

            </ul>



            <div class="buttons">

              <div class="product-button">

                <button><a
                    href="/rdh/products/<?php echo get_query_var('dentist_name'); ?>?ref=<?php echo $affiliate_id; ?>">
                    MY RECOMMENDATIONS</a></button>

              </div>

              <div class="contact">

                <button class="modal-toggle"><a href="">CONTACT</a></button>

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

            $years_t = $total_months / 12;

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

                <h3>
                  <?php echo str_replace("\'", "'", $experience['company'][$i]); ?>
                </h3>

                <p>
                  <?php echo str_replace("\'", "'", $experience['exp_title'][$i]); ?>
                </p>

                <p>
                  <?php echo str_replace("\'", "'", $experience['city'][$i]); ?>,
                  <?php echo str_replace("\'", "'", $experience['state'][$i]); ?>
                </p>

                <span>
                  <?php echo $month_name = date("F", mktime(0, 0, 0, (int) $experience['start_month'][$i], 10)); ?>
                  <?php echo $experience['start_year'][$i]; ?> -
                  <?php if ($experience['end_month'][$i] == '') {

                    echo 'Present';
                  } else {

                    echo date("F", mktime(0, 0, 0, (int) $experience['end_month'][$i], 10));
                  } ?>
                  <?php echo $experience['end_year'][$i]; ?>
                </span> <span class="year"> -
                  <?php echo $years_t; ?>
                </span>



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

              <h3>
                <?php echo str_replace("\'", "'", $education['school'][$i]); ?>
              </h3>

              <p>
                <?php echo str_replace("\'", "'", $education['degree_title'][$i]); ?>
              </p>

              <span>
                <?php echo date('F Y', strtotime($education['grad_date'][$i])) ?>
              </span>



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

    if ($articless != '<div class="no-article"><h6>No Article found</h6></div>' || count($my_publications) > 0) { ?>
      <style>
        .no-article {
          display: none;
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


            $username = $user_info->user_login;


            $rdhTitle = get_field('rdh_titleline', 'user_' . $user_id);
            if ($rdhTitle) {
              $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
            }
            $author_name = $first_name . ' ' . $last_name . $rdhTitle;
            $html = '';
            if (is_array($my_publications) && count($my_publications) > 0) {
              $categories = get_categories();
              $related_categories = array();
              foreach ($categories as $category) {
                //  echo $category->slug.'=>'.$category->name.'<br />';
                $related_categories[$category->slug] = $category->name;
              }

              foreach ($my_publications as $pub) {

                $category_name = isset($related_categories[$pub->pub_category]) ? $related_categories[$pub->pub_category] : $pub->pub_category;
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
                if ($pub->pub_authorName != '') {
                  $author_name_updated = $author_name . '<br />' . stripslashes($pub->pub_authorName);
                } else {
                  $author_name_updated = $author_name;
                }
                if ($pub->publication_publisher)
                  $html .= '<div class="card">
                        <a href="' . $pub->pub_url . 'rel=nofollow">
                            <div class="card-img">
                                <img src="' . get_stylesheet_directory_uri() . '/assets/images/rdh-article-thumbnail/' . $final_image . '" >
                
                            </div>
                            <div class="card-details">
                                <div class="">
                                    <small>' . stripslashes($category_name) . '</small>
                                </div>
                                <div class="card-title">
                                    <h2>' . stripslashes($pub->pub_title) . '</h2>
                                </div>
                                
                                </a>
                                <div class="description mbtDescriptionRow">
                                <div class="description">
                                    <p>' . stripslashes($pub->pub_description) . '</p>
                                    <p class="author">By: ' . stripslashes($author_name_updated) . '</span></p>
                                </div>
                                    <div class="action_buttons_mbt">
                                    <div class="buttonRow_inner">
                                        <a class="readmore" href="' . $pub->pub_url . '?rel=nofollow" class="readmoreButton">    
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


<!-- modal-access-code modal -->
<div class="modal modal-access-code" id="modal-access-code">
  <!-- <div class="modal-overlay modal-toggle"></div> -->
  <div class="modal-wrapper modal-transition">
    <div class="modal-header">
      <button class="modal-close ">×</button>
      <h2 class="modal-heading">Access Code</h2>
    </div>

    <div class="modal-body">
      <div class="modal-content">
        <div class="before-access-code">
          <form>
            <div class="form-group">
              <label for="">Please enter the access code provided by your dentist/hygienist to view exclusive
                pricing.</label>
              <input type="text" class="form-control" id="access-code" placeholder="Enter your access code here">
              <span class="error-message-pop"></span>
            </div>
            <div class="share-button-row">
              <a class="btn btn-primary-blue" href="javascript:void(0);" onclick="verifyAccessCode()">SUBMIT</a>
            </div>
          </form>

        </div>



        <div class="after-access-code" style="display: none;">
          <h1 style="font-weight: normal;"> Access Granted! welcome patient of <br>
            <strong style="font-weight:800;color: #1fb6e4;"> Dr. <?php echo $user_firstname; ?>
              <?php echo $user_lastname; ?>!</strong>
          </h1>
          <strong style="font-weight:800;color: #1fb6e4;"><a class="btn btn-primary-blue btn-access-pricing"
              href="<?php echo $dentisturl_flush; ?>/?access_granted=true">
              Click Here to access pricing </a></strong>
        </div>


      </div>
    </div>
  </div>
</div>


<div class="modal" id="modalShare">
  <!-- <div class="modal-overlay modal-toggle"></div> -->
  <div class="modal-wrapper modal-transition">
    <div class="modal-header">
      <button class="modal-close">×</button>
      <h2 class="modal-heading">REFERRAL</h2>
    </div>
    <div class="modal-body">
      <div class="modal-content">
        <div class="share-options">

          <div class="form-group share-url-text" style="display: none;">
            <label for="url">URL TO SHARE</label>
            <div class="clipboard-parent-wrapper">
              <button class="clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i><span class="cpy-text"> copy
                  URL</span> </button>
              <input type="url" class="form-control url-input" placeholder="" id="website">
            </div>
          </div>
          <div class="form-group share-input-button">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" class="form-control" placeholder="Enter first name">
          </div>
          <div class="form-group share-input-button">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" class="form-control" placeholder="Enter last name">
          </div>

          <div class="form-group share-input-button">
            <label for="Type notes">NOTES/COMMENTS FROM OFFICE:</label>
            <textarea rows="4" cols="4" class="form-control notes-input" placeholder="Type notes"></textarea>
          </div>
          <div class="share-text">Share With</div>

          <div class="share-dentist-wrapper">
            <div class="share-with-icons" style="display: none;">
              <a href="javascript:;" class="share-email open-email-box" title="Email"><svg viewBox="0 0 512 512"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M256 352c-16.53 0-33.06-5.422-47.16-16.41L0 173.2V400C0 426.5 21.49 448 48 448h416c26.51 0 48-21.49 48-48V173.2l-208.8 162.5C289.1 346.6 272.5 352 256 352zM16.29 145.3l212.2 165.1c16.19 12.6 38.87 12.6 55.06 0l212.2-165.1C505.1 137.3 512 125 512 112C512 85.49 490.5 64 464 64h-416C21.49 64 0 85.49 0 112C0 125 6.01 137.3 16.29 145.3z" />
                </svg> </a>
              <a href="javascript:;" class="share-message open-mobile-number-box" title="SMS">
                <svg id="Layer_1" style="enable-background:new 0 0 30 30;" version="1.1" viewBox="0 0 30 30"
                  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <path
                    d="M8.612,22.397c0.072,1.537-0.143,3.65-2.29,4.637L6.5,27.99c2.897,0,6.099-1.922,7.332-5.158L8.612,22.397z" />
                  <circle cx="6.5" cy="27.5" r="0.5" />
                  <path
                    d="M24,4H6C3.791,4,2,5.791,2,8v12c0,2.209,1.791,4,4,4h18c2.209,0,4-1.791,4-4V8C28,5.791,26.209,4,24,4z M15,16  c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2s2,0.895,2,2C17,15.105,16.105,16,15,16z M21,16c-1.105,0-2-0.895-2-2  c0-1.105,0.895-2,2-2s2,0.895,2,2C23,15.105,22.105,16,21,16z M9,16c-1.105,0-2-0.895-2-2c0-1.105,0.895-2,2-2s2,0.895,2,2  C11,15.105,10.105,16,9,16z" />
                </svg>
              </a>
              <a href="javascript:;" class="share-qr-code-popup" onclick="generateQRCode()">
                <svg height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                  <title />
                  <rect height="80" rx="8" ry="8" width="80" x="336" y="336" />
                  <rect height="64" rx="8" ry="8" width="64" x="272" y="272" />
                  <rect height="64" rx="8" ry="8" width="64" x="416" y="416" />
                  <rect height="48" rx="8" ry="8" width="48" x="432" y="272" />
                  <rect height="48" rx="8" ry="8" width="48" x="272" y="432" />
                  <rect height="80" rx="8" ry="8" width="80" x="336" y="96" />
                  <rect height="176" rx="16" ry="16"
                    style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                    width="176" x="288" y="48" />
                  <rect height="80" rx="8" ry="8" width="80" x="96" y="96" />
                  <rect height="176" rx="16" ry="16"
                    style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                    width="176" x="48" y="48" />
                  <rect height="80" rx="8" ry="8" width="80" x="96" y="336" />
                  <rect height="176" rx="16" ry="16"
                    style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                    width="176" x="48" y="288" />
                </svg>
              </a>
            </div>

            <div class="share-box-wrapper-dentist ">
              <a href="javascript:;" class="modal-close-section" style="display: none;">×</a>
              <div class="share-header-wrap">
                <h2>
                  <!-- <i class="fa fa-envelope-o">&nbsp; &nbsp;</i>  -->
                  <span class="text-edidable-via-js" id="editableText"></span>
                </h2>

                <div class="form-boox email-sharebox-dentist">
                  <div class="arrow-up-indicator"></div>
                  <form>
                    <div class="row-flex">
                      <input type="email" class="emailShare--email-input " placeholder="Patient's email address">
                      <button type="submit" class="emailshare--email-submit" value="Send">send</button>
                    </div>
                  </form>
                </div>

                <div class="form-boox telephone-sharebox-dentist">
                  <div class="arrow-up-indicator"></div>
                  <div class="row-flex">
                    <input type="tel" class="telShare--tel-input" placeholder="(xxx) xxx-xxxx" id="phone-input">
                    <button type="submit" class="tellshare--tel-submit" value="Send">send</button>
                  </div>
                </div>


              </div>

            </div>

          </div>



        </div>

        <!-- <div class="share-button-row">               
              <button class="btn btn-primary-blue" >SHARE</button> 
            </div> -->
      </div>
    </div>
  </div>
</div>


<!--modal popup-->




<div class="modal" id="qr-code-popup">
  <!-- <div class="modal-overlay modal-toggle"></div> -->
  <div class="modal-wrapper modal-transition">
    <div class="modal-header">
      <button class="modal-cross">×</button>
      <h2 class="modal-heading">SHARE QR CODE</h2>
    </div>
    <div class="modal-body">
      <div class="modal-content">

        <div id="qrcode-container">
          <div id="qrcode" class="qrcode"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>



  var dentist_id = '<?php echo $dentist_id; ?>';
  var dentist_name = '<?php echo $first_name . ' ' . $last_name; ?>';
  jQuery(document).on('input', '.notes-input', function () {
    var noteVal = jQuery(this).val();
    var existingValInputField = jQuery('.url-input').val();
    var url = new URL(existingValInputField);

    // Add or update the `dentist_message` query parameter
    url.searchParams.set('dentist_message', noteVal);

    // Update the input field with the new URL
    jQuery('.url-input').val(url.toString());
  });
  jQuery(document).ready(function ($) {
    $('.emailshare--email-submit').click(function (e) {
      e.preventDefault();
      that = this;
      jQuery(this).addClass("loading");
      var email = $('.emailShare--email-input').val();
      var url = $('.url-input').val();
      var notes = $('.notes-input').val();
      var first_name = $('#firstName').val();
      var last_name = $('#lastName').val();
      var notes = $('.notes-input').val();
      var url = new URL(url);
      url.searchParams.set('dentist_message', notes);
      url = url.toString();
      // AJAX request
      $.ajax({
        url: ajaxurl,
        type: 'post',
        data: {
          action: 'send_email_share_link',
          email: email,
          url: url,
          notes: notes,
          first_name: first_name,
          last_name: last_name,
            dentist_name: dentist_name,
            dentist_id: dentist_id,
          allow_wp_mail: true
        },
        success: function (response) {
          response = JSON.parse(response);
          jQuery(that).removeClass("loading");

          jQuery('#modal-dentist').addClass("show-modal");

          if (response.success) {
            jQuery('#modal-dentist h2').text("Success!").css("color", "#1fb6e4");
            // jQuery('#modal-dentist p').html("Your product recommendations have been sent to the following patient.</br> <span>"+first_name+" "+ last_name+" " +email );
            jQuery('#modal-dentist p').html("Your product recommendations have been sent to the following patient.<br> <span style='color: #1fb6e4;'>" + first_name + " " + last_name + "<br>" + email + "</span>");
            jQuery('#modal-dentist .modal-content-dentist .ajax-share-res').html(
              "<div class='share-url'>" +
              "<a href='javascript:;' id='clipboardCopy'>" +
              "<i class='fa fa-clipboard' aria-hidden='true'></i> click to copy to the clipboard." +
              "</a>" +
              "<div class='addressCopyToClipboard'>" +
              response.message +
              "</div>" +
              "</div>" /* feedback 26/6 */
              +
              "<div class='buttonAddedByJsAppended'>" +
                 "<a class='btn btn-primary resetAllSetting' href='javascript:;'>Close</a>" +
            "</div>"
            );



          //   if (jQuery('.after-access-code').is(':visible')) {
          //       jQuery('#modal-access-code .modal-close').on('click', function (e) {
          //       location.reload();
          //   });
          // } 








            jQuery('.emailShare--email-input').val('');
          //  jQuery('.url-input').val('');
            jQuery('.notes-input').val('');
            jQuery('#firstName').val('');
            jQuery('#lastName').val('');
            //  setTimeout(function(){  
            //   jQuery("#modalShare").removeClass('is-visible');  jQuery("#modal-dentist").removeClass('show-modal'); }, 60000);


          jQuery(".modal").removeClass('is-visible'); 


          // Uncheck all radio buttons and checkboxes
          jQuery('input[type="radio"], input[type="checkbox"]').prop('checked', false);
          



          }
          else {
            message_to_show = "Some thing went wrong please contact to site admin";
            if (response.message) {
              message_to_show = response.message;
            }
            jQuery('#modal-dentist h2').text("Error!").css("color", "red");
            jQuery('#modal-dentist p').text(message_to_show);
          }

        },
        error: function (xhr, status, error) {
          jQuery(this).removeClass("loading");
          // Handle error
          jQuery('#modal-dentist h2').text("Error!");
          jQuery('#modal-dentist p').text("Some thing went wrong please contact to site admin");
        }
      });
    });

       /* feedback 26/6  JS*/
       jQuery(document).on('click', '.resetAllSetting', function (e) {

         jQuery(".modal").removeClass('is-visible'); 
         jQuery("#modal-dentist").removeClass('show-modal'); 
          // Reset all input values
          jQuery('input[type="text"], input[type="password"], input[type="email"], textarea').val('');

          // Uncheck all radio buttons and checkboxes
          jQuery('input[type="radio"], input[type="checkbox"]').prop('checked', false);

        });


    $('.tellshare--tel-submit').click(function (e) {
      e.preventDefault();
      that = this;
      jQuery(this).addClass("loading");
      var phone = $('.telShare--tel-input').val();
      var url = $('.url-input').val();
      var notes = $('.notes-input').val();
      var first_name = $('#firstName').val();
      var last_name = $('#lastName').val();
      var url = new URL(url);
      url.searchParams.set('dentist_message', notes);
      url = url.toString();
      console.log(url);
      // AJAX request
      $.ajax({
        url: ajaxurl,
        type: 'post',
        data: {
          action: 'send_text_share_link',
          phone: phone,
          url: url,
          first_name: first_name,
          last_name: last_name,
          dentist_name: dentist_name,
          dentist_id: dentist_id,
          notes: notes
        },
        success: function (response) {
          response = JSON.parse(response);
          jQuery(that).removeClass("loading");
          // Handle success
          jQuery('#modal-dentist').addClass("show-modal");
          if (response.success) {
            jQuery('#modal-dentist h2').text("Success!");
            jQuery('#modal-dentist h2').text("Success!").css("color", "#1fb6e4");
            jQuery('#modal-dentist p').text("Your product recommendations have been sent to the patient. ("+first_name+" "+ last_name+" " +phone );
            jQuery('#modal-dentist .modal-content-dentist .ajax-share-res').html(
              "<div class='share-url'>" +
              "<a href='javascript:;' id='clipboardCopy'>" +
              "<i class='fa fa-clipboard' aria-hidden='true'></i> click to copy to the clipboard." +
              "</a>" +
              "<div class='addressCopyToClipboard'>" +
              response.message +
              "</div>" +
              "</div>"
            );

            $('.telShare--tel-input').val('');
            $('.url-input').val('');
            $('.notes-input').val('');
            $('#firstName').val('');
            $('#lastName').val('');
            //setTimeout(function(){  jQuery("#modalShare").removeClass('is-visible');  jQuery("#modal-dentist").removeClass('show-modal'); }, 2000);
          }
          else {
            message_to_show = "Some thing went wrong please contact to site admin";
            if (response.message) {
              message_to_show = response.message;
            }
            jQuery('#modal-dentist h2').text("Error!");
            jQuery('#modal-dentist p').text(message_to_show);

          }
        },
        error: function (xhr, status, error) {
          jQuery(this).removeClass("loading");
          // Handle error
          jQuery('#modal-dentist h2').text("Error!");
          jQuery('#modal-dentist p').text("Some thing went wrong please contact to site admin");
        }
      });
    });
  });


  jQuery('body').on('click', '.share-url', function () {
    // Get the text to copy
    var textToCopy = jQuery('.addressCopyToClipboard').text();

    // Create a temporary input element to hold the text
    var tempInput = jQuery('<input>');
    jQuery('body').append(tempInput);
    tempInput.val(textToCopy).select();

    // Execute the copy command
    document.execCommand('copy');

    // Remove the temporary input element
    tempInput.remove();

    // Optionally, provide feedback to the user
    // alert('URL copied to clipboard!');



    // jQuery("#modal-dentist8").addClass('show-modal'); 


  });
</script>






<!--user profile main section end-->

<?php



// }

if (strpos($_SERVER['REQUEST_URI'], 'rdh/products') !== false) {

  ?>

  <script>
    jQuery(document).ready(function () {

      jQuery("#reco-active").addClass('active');



    });
  </script>

  <?php

} else if (strpos($_SERVER['REQUEST_URI'], 'rdh/profile') !== false) {

  ?>

    <script>
      jQuery(document).ready(function () {

        jQuery("#profile-active").addClass('active');



      });
    </script>

  <?php

} else if (strpos($_SERVER['REQUEST_URI'], 'rdh/contact') !== false) {

  ?>

      <script>
        jQuery(document).ready(function () {

          jQuery("#contact-active").addClass('active');



        });
      </script>

  <?php



}



get_footer('dentist'); ?>

<script>
  $(document).ready(function () {

    $('.burgerNav').click(function () {

      // $(this).toggleClass('open');

      // $(this).parent('.nav-men-wrapper').toggleClass('open-navigation');



    });

  });







  if ($('#list_items_mbt li').size() <= 2) {

    $(".tabsSectionrdhSec .list-items").addClass('listItemSmall');

  } else {

    $(".tabsSectionrdhSec .list-items").removeClass('listItemSmall');

  }

  jQuery(document).on('click', '#list_items_mbt li a', function () {

    jQuery('#list_items_mbt li a').removeClass('active');

    jQuery(this).addClass('active');

    show_hide_tabs_rdh();

    window.history.pushState({}, '', jQuery(this).attr('data-href-cust'));

  });

  jQuery(document).ready(function () {

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

      jQuery('#product-list').show();

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




  jQuery(document).on('click', '.packageheader  a.iconCloseBox', function () {
    jQuery(this).parents(".selectPackageWrapper").removeClass('openPackage');
  });


  // option for multiple package

  jQuery(document).on('click', '.selectpackageButton  button', function () {
    jQuery(".selectPackageWrapper").removeClass('openPackage');
    jQuery(this).parents(".selectPackageWrapper").addClass('openPackage');

  });
  // remove class outsideClick
  jQuery(document).click(function (event) {
    if (!jQuery(event.target).closest('.selectPackageWrapper').length) {
      jQuery('.openPackage').removeClass('openPackage');
    }
  });



  // option for Quantity Box

  jQuery(document).on('click', '.openQuantityBox  button', function () {

    jQuery(".product-selection-description-parent-inner").removeClass('openPackage-quantity');
    jQuery(this).parents(".product-selection-description-parent-inner").addClass('openPackage-quantity');
  });
  jQuery(document).on('click', '.packageQuantityBox  a.iconCloseBox', function () {
    jQuery(this).parents(".product-selection-description-parent-inner").removeClass('openPackage-quantity');
  });

  // remove class outsideClick
  jQuery(document).click(function (event) {
    if (!jQuery(event.target).closest('.product-selection-description-parent-inner').length) {
      jQuery('.openPackage-quantity').removeClass('openPackage-quantity');
    }
  });


  jQuery('.lander-shortcode').each(function () {
    jQuery(this).parents('.wpb_column').addClass('landing-product');

  });


  /*For total*/
  jQuery(document).ready(function () {
    jQuery(document).on('click', '.select-a-package', function() {
    console.log('parent clicked');
    
    // Find the last .pacakge_selected_data element
    var $lastPackage = jQuery(this)
        .parents('.product-selection-box')
        .find('.pacakge_selected_data:last');
    
    // Log to check if the input exists
    console.log('Checking if child exists: ', $lastPackage);
    
    // Check if the last package input exists and has the correct name="fav_language"
    if ($lastPackage.length > 0 && $lastPackage.attr('name') === 'fav_language') {
        // Set the input as checked and trigger a click event
        console.log('Triggering click on: ', $lastPackage);
        $lastPackage.trigger('click');
    } else {
        console.log('No child found or incorrect name attribute');
    }
});
jQuery(document).on('change', 'input[name="fav_language"]', function() {
      selected_product_id = jQuery(this).attr('data-pid');
      av_price = jQuery(this).attr('data-avr-price');
      var rdh_sale_price = $(this).attr('data-rdh_sale_price');
      if (typeof rdh_sale_price !== 'undefined' && rdh_sale_price !== false && rdh_sale_price != '' && rdh_sale_price > 0) {
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-rdh_sale_price', rdh_sale_price);
      }
      else {
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-rdh_sale_price');
      }
      jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id', selected_product_id);
      jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href', '?add-to-cart=' + selected_product_id);
      if (av_price != '') {
        jQuery(this).parents('.product-selection-box').find('.normalyAmount').show();
        jQuery(this).parents('.product-selection-box').find('.targeted_avr').html(av_price);
      }
      else {
        jQuery(this).parents('.product-selection-box').find('.normalyAmount').hide();
      }
      jQuery(this).parents('.product-selection-box').find('.packageAmount').text(jQuery(this).attr('data-price'));


    });
    jQuery(document).find('.qty-update').change(function () {
      //
    })


    jQuery(document).on("change", ".quantity", function () {
      console.log('changed-val');
      selected_product_id = jQuery(this).attr('data-pid');
      console.log(jQuery(this).val());
      jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id', selected_product_id);
      jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href', '?add-to-cart=' + selected_product_id);
      jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-quantity', jQuery(this).val());
    })
    jQuery(".selectquantitybtn").click(function () {
      jQuery(this).parents('.product-selection-box').find('.quantity').trigger('change');
    });
  })
  jQuery(document).on('click', '.selectquantitybtn', function() {
    console.log('hello');

    // Instead of triggering change, call the change handler directly
    var $quantityInput = jQuery(this).parents('.product-selection-box').find('.quantity');
    
    // Call the change function directly
    $quantityInput.trigger('change');
    
    // Alternatively, manually call the logic instead of triggering change
    selected_product_id = $quantityInput.attr('data-pid');
    console.log($quantityInput.val());

    // Update the product ID and quantity in the add to cart button
    jQuery(this).parents('.product-selection-box').find('.add_to_cart_button')
        .attr('data-product_id', selected_product_id)
        .attr('href', '?add-to-cart=' + selected_product_id)
        .attr('data-quantity', $quantityInput.val());
});


  // check child element then add class to parents
  jQuery(".productLandingPageContainer .wpb_row.row-fluid").each(function () {
    var childrenCount = $(this).children().length;
    jQuery(this).addClass("childrenBox-" + childrenCount);
  });
  jQuery(document).ready(function () {
    var commaSeparatedString = '<?php echo $selected_products; ?>';
    var access_code = '<?php echo $selected_products; ?>';
    jQuery('.btn-primary-blue').each(function () {

      var valueToFind = jQuery(this).attr('data-product_id');
      if (valueToFind && valueToFind.trim() !== '') {
        // alert(valueToFind);
        console.log(commaSeparatedString);
        if (!commaSeparatedString.includes(',')) {
          commaSeparatedString = commaSeparatedString + ',';
        }
        // Check if the string contains commas
        if (commaSeparatedString.includes(',')) {
          // If commas are present, split the string into an array
          var valuesArray = commaSeparatedString.split(',');
          console.log(valuesArray);
          // Check if the value exists in the array
          if (valuesArray.includes(valueToFind)) {
            jQuery(this).parents('.landing-product').addClass('selected-for-share');
            jQuery(this).parents('.landing-product').attr('data-selected', 1);
          } else {
            console.log("Value does not exist in the comma-separated string.");
            jQuery(this).parents('.landing-product').attr('data-selected', 0);
          }
        }
        else {
          if (commaSeparatedString == valueToFind) {
            jQuery(this).parents('.landing-product').addClass('selected-for-share');
            jQuery(this).parents('.landing-product').attr('data-selected', 1);
          }
        }
      }
    })


    // Value to find

  });

  // for dentist only
  // document.body.classList.add('dentist-only-page');



  function verifyAccessCode() {
    var dentist_code = '<?php echo $user_access_code; ?>';
    var submitted_code = jQuery('#access-code').val();
    if (submitted_code == '') {
      alert('Please enter Code');

    }
    if (submitted_code.toLowerCase() != dentist_code.toLowerCase()) {
      jQuery('.error-message-pop').text('Invalid Code');
    }
    if (dentist_code.toLowerCase() == submitted_code.toLowerCase()) {
      var expires = "";
      days = 30;
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
      }
      cname = 'access_code';
      document.cookie = cname + "=" + (dentist_code || "") + expires + "; path=/";
      jQuery('.after-access-code').show();
      jQuery('.error-message-pop').text('');
      jQuery('.before-access-code').hide();


      /* feedback 26/6 */

      if (jQuery('.after-access-code').is(':visible')) {
            jQuery('#modal-access-code .modal-close').on('click', function (e) {
            location.reload();
        });
      } 

      setTimeout(function () {



        // window.location.reload();
      }, 3000); // 3000 milliseconds = 3 seconds
    }
  }
</script>
<?php
$show_btn_customer = false;
$view_accss_button = false;
//echo get_user_meta($user_id, 'access_code', true);
if (($selected_products != '' && $access_code != '' && base64_decode($access_code) == get_user_meta($user_id, 'access_code', true)) || (isset($_COOKIE['access_code'])) && $_COOKIE['access_code'] == get_user_meta($user_id, 'access_code', true)) {
  $show_btn_customer = true;
}

if (!isset($_COOKIE['access_code']) && !is_user_logged_in() && $dentist_page) {
  $view_accss_button = true;
}
if (!isset($_COOKIE['access_code']) && is_user_logged_in() && get_current_user_id() != $user_id && $dentist_page) {
  $view_accss_button = true;
}
if (is_user_logged_in() && get_current_user_id() == $user_id && $dentist_page) {
  $show_btn_customer = true;
}
if ($view_accss_button) {
  ?>
  <script>
    jQuery(document).ready(function () {
      jQuery('body').addClass('view-pricing');
    });
  </script>
  <?php
}
if (!$show_btn_customer) {
  ?>
  <script>
    jQuery(document).ready(function () {
      jQuery(document).find('.product-selection-price-wrap').each(function () {
        jQuery(this).hide();



      });

      // for all
      jQuery(document).find('.product-selection-price-text-top').each(function () {
        jQuery(this).html('<a href="javascript:void(0);" class="access-code-handler enter-access-code-to-view-pricing">Enter your access code for pricing</a>');
        jQuery('.drtext').hide();

      });

      // for only medium 12 or medium-3 
      jQuery(document).find('.medium-12 .product-selection-price-text-top,.medium-3 .product-selection-price-text-top').each(function () {
        jQuery(this).html('<a href="javascript:void(0);" class="access-code-handler enter-access-code-to-view-pricing">Enter your access code for pricing</a>');
        jQuery(this).append('<a href="javascript:void(0);" class="openpop access-code-handler view-pricing-button-css">View Pricing</a>');
        jQuery("#contentThatFades").find('li.fillNot.share-this-page').hide();

      });

      // for only  medium-3 
      jQuery(document).find('#product-list .medium-3').each(function () {
        jQuery(this).addClass('adjust-pricing-button-by-js');
      });


      // for only medium6
      jQuery(document).find('.medium-6 .product-selection-description-parent-inner').each(function () {
        jQuery(this).addClass('align-items-center-by-js')
        jQuery(this).append('<a href="javascript:void(0);" class="openpop access-code-handler view-pricing-button-css">View Pricing</a>');
      });




    });
  </script>

  <?php
}
?>