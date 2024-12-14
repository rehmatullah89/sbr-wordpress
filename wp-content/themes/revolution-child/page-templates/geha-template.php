<?php
/*Template Name: Geha Template */

session_start();

global $GEHA_PAGE_ID;
//$GEHA_PAGE_ID =  get_the_ID();
$GEHA_PAGE_ID = GEHA_TEMPLATE_PAGE_ID;
$gehaFlag = false;
if (isset($_GET['utm_campaign']) && $_GET['utm_campaign'] == 'userExists') {
    // echo 'yes';
    // die();
    setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
    $_SESSION['geha_user'] = 'yes';
    set_transient('geha_user', 'yes', 365 * DAY_IN_SECONDS);
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'geha_user', 'yes');
    }
    $gehaFlag = true;
    if (function_exists('w3tc_flush_url')) {
        w3tc_flush_url(get_permalink(get_the_ID()));
    }
}

if (isset($_COOKIE['geha_user']) && $_COOKIE['geha_user'] == 'yes') {
    $gehaFlag = true;
}
if (isset($_SESSION['geha_user']) && $_SESSION['geha_user'] == 'yes') {
    $gehaFlag = true;
}
if (get_transient('geha_user') == 'yes') {
    // $gehaFlag = true;
}

if (is_user_logged_in()) {
    if (get_user_meta(get_current_user_id(), 'geha_user', true) == 'yes') {
        $gehaFlag = true;
    }
}
if (isset($_GET['email']) && $_GET['email'] != '') {
    gehaUserAddUpdateURL($_GET['email']);
    $gehaFlag = true;
    if (function_exists('w3tc_flush_url')) {
        w3tc_flush_url(get_permalink(get_the_ID()));
    }
}
get_header();

?>
<style>
        body{
        overflow-x: hidden;
    }
    #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-6>.vc_column-inner {
        background-color: #fff !important;
    }


    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
        max-width: 1330px;
    }

    #gehaPage .gehaPageBanner {
        max-height: 620px;
        overflow: hidden;
        background: rgb(69, 8, 118);
        background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%);
        /* background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/geha-banner-bg.jpg); */


    }
    #product-list .thb-dark-column.small-12.landing-product.child-5 .featureTag{ display:none;}

    .gehanFormSection {
        background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/geha-banner-bg.jpg);
        background-color: #683c8b;
        background-repeat: repeat-x;
    }

    #gehaPage .rowMbt {
        display: flex;
        flex-wrap: wrap;
    }

    .mt-100 {
        padding-top: 100px;
    }

    #gehaPage .geha-banner-text-section-parent {
        width: 40%;
    }

    #gehaPage .graphicImagePeople {
        width: 60%;
        text-align: right;
    }

    #gehaPage .text-white {
        color: #fff;
    }

    #gehaPage .geha-banner-text-section {
        text-align: center;
    }


    #gehaPage .geha-banner-text-section p {
        margin-bottom: 0;
        padding-bottom: 10px;
    }

    #gehaPage .geha-banner-text-section h2 {
        margin-top: 40px;
        font-size: 30px;
        margin-bottom: 50px;
        line-height: 1.1;
    }

    #gehaPage .gehaLoginCustomer {
        margin-top: 25px;
    }

    #gehaPage .seeDiscountBtn button {
        background: #eb6754;
        border-color: #eb6754;
        letter-spacing: 0;
        font-size: 20px;

    }

    #gehaPage .seeDiscountBtn button:hover {
        background-color: #595858;
        border-color: #595858;
    }

    #gehaPage .gehaLoginCustomer h3 {
        color: #fff;
        font-size: 20px;
        font-weight: 300;
    }

    #gehaPage .gehaLoginCustomer h3 a:hover {
        color: #fff;
    }

    #gehaPage .gehaLoginCustomer h3 a {
        color: #dec5f5;
    }

    #gehaPage .splitTwo {
        width: calc(100%/2);
    }

    #gehaPage .productGripgSectionWrapper {
        background: #17a2b8;
        padding: 20px;
    }

    #gehaPage .productGripgSection {
        border: 1px solid #fff;
        padding: 30px;
    }

    #gehaPage .productGripgSection li {
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

    #gehaPage .productGripgSection h3 {
        font-size: 67px;
        font-weight: bolder;
        letter-spacing: 1px;
        line-height: 52px;
        margin-bottom: 50px;
    }

    #gehaPage .productGripgSection ul {
        margin-bottom: 60px;
    }

    #gehaPage .productGripgSectionProduct {
        background-position: center;
        background: url(https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/geha-page/geha-product-image.jpg);
    }

    #gehaPage section.sectionProductDisplay {
        margin-top: 10px;
    }

    #gehaPage .logoesSecHfa {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;

    }
     .swal2-icon.swal2-error.swal2-icon-show {
    margin: 0px auto !important;
    margin-top: 10px !important;
}
 div:where(.swal2-container) .swal2-html-container{
    margin: 0em 1.6em 0.3em !important;
}
 div:where(.swal2-container) div:where(.swal2-popup) {
    font-family: 'Montserrat';
}
 div:where(.swal2-container) div:where(.swal2-actions) {
    margin: 0em auto 0 !important;
}
 div:where(.swal2-icon) {
    margin: 0em auto 0.6em !important;
}

    #gehaPage .logoesSecHfa img {
        max-width: 118px;
    }

    #gehaPage section.sectionHsaFsa {
        background: #555759;
        padding: 20px 0px;
    }

    #gehaPage .colhFsaSec {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    #gehaPage .colhFsaSec h4 {
        font-size: 30px;
    }

    #gehaPage section.ourSuportedCustomers.product-logo-wrapper {
        background: #440876;
        padding-top: 38px;
        padding-bottom: 38px;
        margin-top: 0px;
    }

    #gehaPage .extra_logo_before-top .boxSecBox {
        position: relative;
    }

    #gehaPage .extra_logo_before-top .col-md-3,
    #gehaPage .extra_logo_before .col-md-3 {
        -webkit-box-flex: 0;
        -ms-flex: initial;
        flex: initial;
        max-width: max-content;
        padding-left: 2.5%;
        padding-right: 2.5%;
    }

    #gehaPage .extra_logo_before-top .boxSecBox.box-with-extra-logo:before {
        content: "";
        background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/logoes-tiktok.png);
        width: 114px;
        height: 149px;
        position: absolute;
        top: 0;
        left: 0;
        background-repeat: no-repeat;
    }

    #gehaPage .box-with-extra-logo-right:before {
        content: "";
        background-image: url(/wp-content/themes/revolution-child/assets/images/geha-page/logoes-small-circle.png);
        width: 50px;
        height: 49px;
        position: absolute;
        top: 0;
        right: -100px;
        background-repeat: no-repeat;
    }

    #gehaPage .logo-strip-two .col-md-3 {
        padding-left: 4%;
        padding-right: 4%;
    }

    #gehaPage .justify-conten {
        justify-content: center;
    }

    #gehaPage .extra_logo_before-top .spacing-left-emphty,
    #gehaPage .smilePageIconSection-parent-div .extra_logo_before .spacing-left-emphty {
        position: relative;
        padding-left: 158px;
    }

    #gehaPage .rowMbt.extra_logo_before-top.logo-strip-one.justify-conten {
        margin-bottom: 35px;
    }

    #gehaPage .second-row .boxSecBox.spacing-left-emphty.col-md-3.col-4 {
        padding-left: 30px;
    }

    #gehaPage .fullWidth {
        width: 100%;
    }

    #gehaPage .year-wrannanty-container .itsSimpleHeading {
        color: #522773;
        text-align: center;
        margin-bottom: 0;
        font-weight: 400;
        font-size: 30px;
        margin-bottom: 20px;
    }

    #gehaPage section.warrantysectionPage {
        margin-bottom: 70px;
    }

    #gehaPage section.gehanFormSection {
        padding-top: 50px;
        padding-bottom: 40px;
    }

    #gehaPage .gehanFormSection input[type="text"],
    #gehaPage .gehanFormSection input[type="email"] {
        margin-bottom: 10px;
        min-height: 70px;
    }

    #gehaPage .member-ids input[type="text"] {
        background: #efdefc;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box,
    #gehaPage .profile-container {
        width: 100%;
    }

    #gehaPage section.sectionHsaFsa {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    #gehaPage section.ourCustomers h2 {
        font-size: 60px;
        font-weight: 700;
        margin-top: 0px;
        margin-bottom: 36px;
        padding-top: 40px;
    }

    #gehaPage section.ourCustomers h3 {
        font-size: 26px;
        font-weight: normal;
        margin-top: 0;

    }

    #gehaPage .customer-before-after-image {
        margin-top: 60px;
        margin-bottom: 65px;
    }

    #gehaPage .warrabty-text-container p {
        font-weight: 400;
    }

    #gehaPage .col-md-12.text-center.form-notes {
        margin-top: 20px;
    }

    #gehaPage .w-100 {
        width: 100%;
    }

    #gehaPage .row.after-success {
        width: 100%;
    }

    #gehaPage .colhFsaSec p {
        font-size: 14px;
    }

    #gehaPage .container {
        margin-left: auto;
        margin-right: auto;
        /* padding-bottom:30px; */
    }


    #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
        right: 78px;
        top: -16px;
        max-width: 436px;
    }

    #gehaPage .alin-items-center {
        align-items: center;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
        background-color: #e9e9f5 !important;
    }

    #gehaPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-5>.vc_column-inner {
        background-color: #fff !important;
    }


    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button,
    .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite,
    .teethWhieteingSystemWrapper.productLandingPageContainer .btn {
        background-color: #b8b8dc;
        border-color: #b8b8dc;
    }

    #gehaPage .productLandingPageContainer .medium-12 .small-desc h4,
    .productLandingPageContainer .medium-12 .small-desc h5 {
        color: #65657f;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12 .product-selection-description b {
        color: #65657f;
        font-weight: 500;
        font-size: 1.3rem;
    }

    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
    #gehaPage .packageQuantityBox,
    .selectPackageBox {
        background: #f1f1f8;
    }

    #gehaPage .graphicImagePeople img {
        width: 100%;
        max-width: 776px;
    }


    /* 9th-child-image-section added */
    #gehaPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description b {
        font-size: 16px;
        font-weight: normal;
        color: #565759;
        font-weight: 400;
    }

    #gehaPage #product-list.teethWhieteingSystemWrapper .medium-12.child-9 .productDescriptionDiv b {
        font-weight: bold;
        line-height: inherit;
        color: #565759;
    }

    #gehaPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.child-9 .productDescriptionDiv b {
        font-size: 22px;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description-text {
        padding-top: 0px;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.child-9 .product-selection-description-text p {
        margin: 0
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.child-9 .days-textFortyFive {
        margin-top: 35px;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.child-9 .text-blue {
        color: #3c98cc !important;
    }

    .product-selection-description-parent{ position: relative;}
    #gehaPage  .ultrasonic-text-contain-by-js .backOrderList {
        position: absolute;
    /* display: block; */
    top: -2px;
    right: 0;
    max-width: 366px;
    }

    #gehaPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList{
        line-height: 14px;
        top: -7px;
    }

    #gehaPage   #product-list.productLandingPageContainer:not(.grid-changed) .medium-12 .ultrasonic-text-contain-by-js .backOrderList {
        position: static;
    }
    /* Ended 9th-child-image-section added */

    /* popup */

    .modal {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0 0 0 / 70%);
        opacity: 0;
        visibility: hidden;
        transform: scale(1.1);
        transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
        z-index: 999;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 1rem 1rem;
        width: 30rem;
        border-radius: 0.5rem;
        border: 10px solid #440776;
    }

    .close-button {
        width: 30px;
        cursor: pointer;
        border-radius: 1rem;
        background-color: lightgray;
        position: absolute;
        right: -20px;
        top: -20px;
        background: #fff;
        color: #453651;
        border: 2px solid #453651;
        font-size: 24px;
        font-weight: 700;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-button:hover {
        background-color: darkgray;
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

    #gehaPage .container-form {
        max-width: 820px;
    }

    #gehaPage .after-success #geha-coupon-code-box {
        background-color: #ffffff;
    }

    #gehaPage .after-success h1 {
        line-height: 42px;
    }


    #gehaPage #product-list.grid-changed .medium-12 .product-selection-image-wrap img {
        max-width: 100%;
    }


    #gehaPage #product-list.grid-changed .medium-12 .product-selection-description b {
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        padding-right: 15px;
        color: #565759;
    }

    #gehaPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
        max-height: 44px;
        overflow: hidden;
        min-height: 44px;
        display: flex;
        align-items: flex-end;
    }

    #gehaPage #product-list.grid-changed .medium-12 .normalyAmount {
        display: none;
    }

    #gehaPage #product-list.grid-changed .product-selection-price-text-top {
        height: 30px;
        display: flex;
        align-items: center;
        flex-direction: initial;
        justify-content: flex-start;
    }

    #gehaPage #product-list.grid-changed .starRatinGImage {
        display: none;
    }

    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner {
        padding: 0px;
    }

    #gehaPage #product-list.grid-changed .medium-12 .small-desc,
    #gehaPage #product-list.grid-changed .medium-12 .featureShippingPrice {
        display: none;
    }

    #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text-top {
        margin: 0px;
    }

    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
        background-color: #ffffff !important;
    }

    #gehaPage #product-list.grid-changed .product-selection-price-text {
        font-size: 18px;
    }

    #gehaPage #product-list.grid-changed span.product-selection-price-text del:before {
        top: 10px;
        left: -8px;
    }

    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
        font-size: 18px;
    }

    #gehaPage #product-list.grid-changed .landing-product div[data-tagging="Featured!"] .featureTag {
        margin-right: 22px;
        top: 0px;
    }

    #gehaPage #product-list.grid-changed #product-list .product-selection-description {
        margin-bottom: 0px;
    }

    #gehaPage #product-list.grid-changed .medium-12 .selectPackageBox,
    #gehaPage #product-list.grid-changed .medium-12 .packageQuantityBox {
        margin-right: 0;
    }

    #gehaPage #product-list.grid-changed .thb-dark-column.medium-12.landing-product {
        margin-bottom: 0px;
    }

    section.shopLanderPageHader {
        margin-top: 0rem;
    }

    div#product-list.grid-changed {
        margin-top: 20px;
    }

    #gehaPage #product-list.grid-changed .active-recomendation-tab #product-list .product-selection-description {
        margin-bottom: 0px;
    }

    #gehaPage #product-list.grid-changed .medium-3 .product-selection-description-parent-inner>.normalyAmount {
        display: none;
    }

    #gehaPage #product-list.grid-changed .medium-3 .productDescriptionDiv {
        text-align: left;
    }

    #gehaPage #product-list.grid-changed .product-selection-price-wrap button.btn {
        min-width: 220px;
    }

    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
        max-width: inherit;
        width: auto;

    }

    .secondary-area-mbt {
        /* display: block !important; */
    }


    section.shopLanderPageHader #product-list.productLandingPageContainer:not(.grid-changed) .small-12.landing-product:nth-child(6) .vc_column-inner {
        /* background-color: #e9e9f5 !important; */
    }

    #product-list .landing-product:not(.medium-12) .featureTag {
        background: #f8a18a;
    }

    #gehaPage #product-list.grid-changed .medium-12 .featureTag,
    #gehaPage #product-list.grid-changed .landing-product .featureTag {
        top: 0px;
        margin-right: 20px;
    }


    #gehaPage .rowMbtInner {
        margin-left: auto;
        margin-right: auto;
    }

    #gehaPage .row.after-success h1,
    #gehaPage .row.after-success p {
        display: none !important;
    }

    #gehaPage section.sectionHsaFsa,
    #gehaPage .ourSuportedCustomers {
        max-width: 1420px;
        margin-left: auto;
        margin-right: auto;
    }



    #gehaPage .medium-3 .product-selection-price-text-top.noflexDiv {
        /* display: block !important; */
        line-height: 1;
    }

    #gehaPage #product-list:not(.grid-changed) .medium-6.landing-product .productDescriptionDiv {
        align-items: flex-start;
    }

    #gehaPage .productLandingPageContainer .medium-3 span.product-selection-price-text del bdi,
    #gehaPage .productLandingPageContainer .medium-6 span.product-selection-price-text del bdi {
        margin-right: 0;
    }

    #gehaPage .productLandingPageContainer .medium-12.landing-product span.product-selection-price-text.hoo,
    #gehaPage .productLandingPageContainer .medium-12.landing-product span.product-selection-price-text.heee {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .grid-changed #gehaPage .medium-3 .product-selection-price-text-top.noflexDiv {
        text-align: left;
        padding-top: 4px;
    }

    .grid-changed #gehaPage .medium-12 span.product-selection-price-text.heee {
        display: flex;
        align-items: center;
    }

    #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text {
        font-size: 24px;
        font-weight: 500;
    }

    #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount,
    #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi {
        font-weight: 500;
    }

    #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text del:before {
        top: 14px;
    }

    #gehaPage #product-list.grid-changed .product-selection-price-text-top {
        padding-top: 5px;
    }

    #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del span bdi,
    #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del span,
    #product-list.productLandingPageContainer .medium-12 span.product-selection-price-text del,
    #product-list.productLandingPageContainer .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount {
        font-weight: 500;
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

    .back-order p {
        margin: 0;
    }


    /* discount prices side by side with but line */
    #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text .wasText {
        display: none;
    }

    #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text del bdi {
        color: #c6c9cd;
        font-size: 20px;
    }

    #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text del:before {
        left: -1px;
        height: 2px;
        background: #f8a18a;
        top: 25px;
    }


    .drtext{ display: none !important;}



    @media (min-width: 768px) {

        section.shopLanderPageHader .pageheaderTop h1,
        section.shopLanderPageHader .pageheaderTop h1 span {
            font-size: 55px;
        }

        #gehaPage section.shopLanderPageHader .pageheaderTop {
            overflow: hidden;
        }

        #gehaPage #product-list.grid-changed .openPackage-quantity .packageQuantityBox,
        #gehaPage #product-list.grid-changed .openPackage .selectPackageBox {
            max-width: 308px;
            right: 0;
            left: inherit;
            border-left: 1px solid #c5c6c9;
            margin-right: 0;
        }

        #gehaPage section.ourCustomers .container {
            background: #eaeff3;
            padding-bottom: 65px;
        }



    }


    @media (min-width: 1024px) {
        .vc_wp_text.wpb_content_element.warrabty-text-container {
            max-width: 82%;
        }

        #gehaPage .gehanFormSection .seeDiscountBtn #send-my-discount {
            min-width: 400px;
        }

        #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
            max-width: inherit;
            width: auto;
            min-height: 130px;
            max-height: 130px;
            /* background: orange!important; */
        }

        #gehaPage #product-list.grid-changed .landing-product.medium-6 .product-selection-description-parent,
        #gehaPage #product-list.grid-changed .landing-product.medium-3 .product-selection-description-parent {
            min-height: 130px;
            max-height: 130px;
            /* background: red!important; */

        }

        section.shopLanderPageHader .pageheaderBotm select {
            padding: 0 30px 0 10px;
            min-width: 186px;
            font-family: 'Montserrat';
        }


    }

    @media (max-width: 1500px) {
        #gehaPage .productGripgSection h3 {
            font-size: 52px;
        }

        #gehaPage .productGripgSection li {
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
        #gehaPage .productGripgSection h3 {
            font-size: 42px;
        }

        #gehaPage .productGripgSection li {
            font-size: 16px;
        }

        #gehaPage section.ourCustomers h2 {
            font-size: 48px;
        }

        #gehaPage .rowMbt.extra_logo_before-top.logo-strip-one.justify-conten {
            margin-bottom: 60px;
        }

        #gehaPage .mt-100 {
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
        section.shopLanderPageHader{
            margin-top: 10rem;
        }
        #gehaPage .ultrasonic-text-contain-by-js .backOrderList{
            top: -50px;
        }
        #gehaPage .geha-banner-text-section-parent {
            width: 100%;
        }
        #gehaPage section.shopLanderPageHader .pageheaderTop {
            margin-top: 30px;
        padding-top: 1rem;
        }

        #gehaPage h1.gehaLogoLarge img {
            max-width: 200px;
        }

        #gehaPage .mt-100 {
            padding-top: 25px;
        }

        #gehaPage .geha-banner-text-section h2 {
            margin-top: 20px;
            font-size: 26px;
            margin-bottom: 35px;
            line-height: 1.1;
        }

        #gehaPage .graphicImagePeople {
            width: 100%;
            text-align: center;
        }

        #gehaPage .splitTwo {
            width: calc(100%/1);
        }

        #gehaPage .productGripgSection h3 {
            font-size: 34px;
            line-height: 33px;
            margin-bottom: 20px;
        }

        #gehaPage .productGripgSection li {
            padding-left: 37px;
            background-size: 30px;
            line-height: 28px;
            text-align: left;
        }

        #gehaPage .productGripgSection {
            padding: 20px;
        }

        #gehaPage .productGripgSection ul {
            margin-bottom: 30px;
        }

        #gehaPage .seeDiscountBtn button {
            font-size: 18px;
        }

        #gehaPage .colhFsaSec {
            justify-content: center;
        }

        /* .sectionHsaFsa .colhFsaSec{order: 2;}
        .sectionHsaFsa .colhLogoSec{order: 1;}         */
        #gehaPage section.ourCustomers h2 {
            font-size: 32px;
            line-height: 1;
            margin-top: 30px;
            margin-top: 0px;
            margin-bottom: 20px;
            padding-top: 40px;
        }

        #gehaPage section.ourCustomers h3 {
            font-size: 18px;
            line-height: 1.4;
        }

        #gehaPage section.ourCustomers {
            padding: 0 15px;
        }

        #gehaPage section.ourCustomers h3 br {
            display: none;
        }

        #gehaPage .customer-before-after-image {
            margin-top: 30px;
            margin-bottom: 38px;
        }

        #gehaPage section.gehanFormSection {
            padding-top: 30px;
            padding-bottom: 25px;
            padding-left: 15px;
            padding-right: 10px;
        }

        .header-spacer {
            height: 60px !important;
        }

        #gehaPage .productGripgSectionWrapper {
            padding: 0px;
        }

        #gehaPage .logoesSecHfa img {
            max-width: 88px;
        }

        #gehaPage .colhFsaSec {
            margin-bottom: 6px;
        }

        #gehaPage .form-steps h5 {
            margin-bottom: 28px;
            font-size: 18px;
        }

        #gehaPage section.ourSuportedCustomers.product-logo-wrapper {
            padding-top: 20px;
            padding-bottom: 16px;
            margin-top: 0px;
        }

        #gehaPage .logoesformobileOnly .col-4 {
            max-width: 33.33%;
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.33%;
            flex: 0 0 33.33%;
            max-width: 33.33%;
            margin-bottom: 11px;
        }

        #gehaPage .gehaLoginCustomer h3 {
            font-size: 16px;
        }

        #gehaPage .pageHeader {
            position: relative;
        }

        #gehaPage .shopLanderPageHader .mobileOptionDisplay.whitening-teeth-girl-with-smile {
            /* right: 0;
            top: -135px;
            max-width: 290px;
            left: 0;
            max-height: 135px;
            overflow: hidden; */
            /* show after banner update */
            right: 0;
            top: 35px;
            max-width: 161px;
            left: 0;
            max-height: 210px;
            overflow: hidden;
        }

        .modal-content {
            width: 95%;
        }

        h2.youreInText {
            font-size: 53px;
        }

        #gehaPage .descriptionBody {
            max-width: 100%;
        }

        h1.gehaTextmember {
            margin-bottom: 10px;
        }

        #gehaPage .graphicImagePeople img {
            max-width: 283px;
        }

        #gehaPage #product-list.grid-changed .product-selection-price-text-top {
            justify-content: center;
        }

        #gehaPage #product-list.grid-changed .medium-12 .product-selection-description .productDescriptionDiv {
            align-items: flex-start;
            min-height: 0px;
        }

        #gehaPage #product-list.grid-changed .medium-12 .product-selection-description b {
            padding-right: 0px;

        }

        #gehaPage #product-list.grid-changed .medium-12 .product-selection-description b {
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
            /* margin-top: 13rem; */
            /* show after banner revert */
        }

        #gehaPage #product-list.grid-changed .normalyAmount {
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

        #gehaPage .ourCustomers .container {
            padding-bottom: 40px;
        }

        #gehaPage #product-list.grid-changed .product-selection-price-text-top {
            height: auto;
        }

        #product-list .product-selection-description b {
            padding-right: 0px;
        }

        #gehaPage #product-list.grid-changed .product-selection-price-text-top {
            padding-top: 0px;
        }

        #gehaPage #product-list.grid-changed .medium-3 .productDescriptionDiv {
            text-align: center;
        }

        #gehaPage #product-list.grid-changed .product-selection-price-text-top {
            text-align: center;
            margin-bottom: 3px;
        }

        #product-list.productLandingPageContainer .medium-12 .product-selection-price-text-top {
            margin-top: 6px;
            margin-bottom: 6px;
        }

        #gehaPage #product-list.grid-changed .wasTextParent-div,
        .wasTextParent-div {
            line-height: 1;
        }

        #gehaPage .product-selection-description-parent-inner .normalyAmount,
        .normalyAmount {
            margin-bottom: 0px;
        }

        #gehaPage div#product-list {
            margin-top: 24px;
        }

        section.shopLanderPageHader .pageheaderBotm select {
            font-size: 12px;
        }

        .resetFilter a {
            font-size: 11px;
        }

        section.shopLanderPageHader .pageheaderTop h1,
        section.shopLanderPageHader .pageheaderTop h1 span {
            font-size: 20px;
        }

        #gehaPage #product-list .landing-product:not(.medium-12) .product-selection-price-wrap {
            padding-top: 6px;
        }

        #gehaPage #product-list.productLandingPageContainer span.woocommerce-Price-amount.amount {
            line-height: 1;
        }

        #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
            font-size: 14px;
        }

        /* #gehaPage .gehaPageBanner {
            margin-top: 55px;
        } */
    }


    /* new changes 11/03*/

    section.shopLanderPageHader .pageheaderTop .row {
        align-items: center;
        justify-content: center;
        flex-wrap: initial;
    }

    section.shopLanderPageHader .pageheaderTop {
        background-image: url(/wp-content/themes/revolution-child/assets/images/vip/vip-bg-gradient.jpg);
        background-position: center bottom;
        background-repeat: no-repeat;
    }

    section.shopLanderPageHader .pageheaderTop {
        margin-top: 73px;
        margin-top: 10px;
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    .banner-img.banner-text-center {
        position: relative;
        /* left: 2.5vw; */
    }

    section.shopLanderPageHader .pageheaderTop .row {
        position: relative;
    }

    #gehaPage section.shopLanderPageHader .pageheaderTop {
        overflow: initial;
    }

    .hidden {
        display: none !important;
    }

    section.shopLanderPageHader .pageheaderBotm {
        position: relative;
        z-index: 12;
        margin-bottom: 3rem;
    }

    @media (min-width: 768px) {
        #gehaPage section.shopLanderPageHader .pageheaderTop {
            /* margin-top: 55px; */
        }

        .banner-img.banner-image-flosser img {
            position: relative;
            top: 69px;
        }

        .banner-img.banner-image-retainer-cleaner img {
            position: relative;
            top: 37px;
        }
    }

    @media (max-width: 767px) {
        section.shopLanderPageHader .pageheaderTop {
            padding-top: 1rem;
            padding-bottom: 1rem;
            padding-left: 15px;
            padding-right: 15px;
        }

        section.shopLanderPageHader .pageheaderTop {
            padding-top: 4rem;
        }

        .banner-img.banner-image-retainer-cleaner {
            position: relative;
            top: 31px;
        }

        .banner-img.banner-image-flosser {
            position: relative;
            top: 40px;
        }

        #gehaPage .shopLanderPageHader .mobileOptionDisplay.whitening-teeth-girl-with-smile {
            right: 0;
            top: -156px;
            max-width: 200px;
            left: 0;
            max-height: 210px;
            overflow: hidden;
        }
        .ultrasonic-text-contain-by-js .backOrderList{
            top: -51px;
        }
        #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList {
            line-height: 14px;
            top: -65px;
        }


    }


    /* new changes ends  11/03*/


    #product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent
,#product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent
,#product-list:not(.grid-changed) .landing-product.medium-4 .product-selection-description-parent
{
    overflow: inherit;
}

</style>


<div class="gehaTemplate active-recomendation-tab" id="gehaPage">



    <?php

if ($gehaFlag || (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] == 'userExists')) {
    $page_id = GEHA_REC_PAGE_ID; // Replace 123 with the ID of the page you want to retrieve
    $page = get_post($page_id);
    if ($page) {
        ?>
            <style>
span.blue-text-js {
    font-weight: 900;
    color: #222222cf;
    font-size: 110%;
}

.landing-product.child-0 .backOrderList.alert.alert-danger.font-mont{
    /* display: block; */
}

#product-list .grid-changed .backOrderList
,#product-list .grid-change.child-0 .backOrderList.alert.alert-danger.font-mont
,#gehaPage #product-list.grid-changed .backOrderList.alert.alert-danger.font-mont

{
    position: absolute;
    /* display: block; */
    top: -40px;
    right: 0;
    max-width: 366px;
}
#gehaPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList {
    top: -29px;
}

.medium-12 .productDescriptionDiv.proTpDiv:not(.not-remove-title)
,.medium-12.child-12 .productDescriptionDiv.hooooo:not(.not-remove-title)
{ display:none;}

.medium-12.child-1 .product-selection-description > .starRatinGImage{
    display: none;
}
.medium-12.child-12 .small-desc:empty{ display:none;}

    /* fixing featured product styling */

    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
        color: #565759;
        font-size: 28px;
        font-weight: 700;
    }



    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description .productDescriptionDiv{
        margin-bottom: 10px;
        margin-top: 5px;
    }
    #gehaPage #product-list:not(.grid-changed) .productLandingPageContainer .sepratorLine{
        margin-top: 1.5rem;
    }
    #gehaPage #product-list:not(.grid-changed)  .starRatinGImage {
        margin-bottom: 10px;
    }

    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .spec-heding {
        margin-bottom: 5px;
    }

    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .small-desc h4,  #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .small-desc h5{
        font-size: 14px;
    }
    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .spec-heding {
        max-width: 380px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.5;
    }
    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-price-text-top {
        margin-top: 25px;
    }






/* for fixing landscape layouts */
@media only screen and (max-width: 1000px) and  (orientation: landscape){
       .page-template .subscription-product-detail .caripro-content h1 {
            color: red;
        }

        #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
            right: 21px;
            max-width: 304px;
            top: -43px;
        }

        #gehaPage section.shopLanderPageHader .pageheaderTop {
            margin-top: 10px;
        }
        section.shopLanderPageHader .pageheaderTop{
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount
        ,.page-template-geha-template #product-list .medium-3 span.product-selection-price-text ins bdi, .page-template-geha-template #product-list .medium-6 span.product-selection-price-text ins bdi, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi
        {
            font-size: 22px;
        }
        .page-template-geha-template #product-list.productLandingPageContainer .product-selection-price-text-top {
            min-width: initial;
        }
        .page-template-geha-template #product-list.productLandingPageContainer .discountedPriceForGehaMember {
            font-size: 10px;
        }
        #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
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

    @media only screen and (max-width: 1024px)  and (min-width: 768px) {

        #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
            right: 40px;
            top: -16px;
            max-width: 299px;
        }
        section.shopLanderPageHader .flex-row > div {
            max-width: 26.33%;
        }
        .product-selection-box.cariPro_dental_probiotics_byJs {
            padding-top: 3rem;
        }
        #gehaPage  .subscription-product-detail .caripro-content p:after{
            width: 0;
        }
        #product-list.productLandingPageContainer .medium-12  .subscription-product-detail.full-col .product-selection-image-wrap img {
            max-width: 254px;
        }

        .page-template-geha-template #product-list.productLandingPageContainer .product-selection-price-text-top {
            min-width: initial;
        }

        .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount
        ,.page-template-geha-template #product-list .medium-3 span.product-selection-price-text ins bdi, .page-template-geha-template #product-list .medium-6 span.product-selection-price-text ins bdi, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi
        {
                font-size: 18px;
            }

            #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {
                font-size: 18px;
            }

            .page-template-geha-template #product-list.productLandingPageContainer .discountedPriceForGehaMember {
                font-size: 10px;
            }
            #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
                font-size: 18px;
            }
            #product-list.productLandingPageContainer .featuredproductNameSubtitle {
                font-size: 14px;
            }
            #product-list .featureTag{
                font-size: 14px;
            }
            section.shopLanderPageHader .pageheaderTop {
            padding-top: 3rem;
            padding-bottom: 2rem;
        }

        .page-template-geha-template #product-list .landing-product.medium-3 .product-selection-description-parent {
                min-height: 187px;
                max-height: 187px;
            }
            #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
                max-width: 370px;
            }
            .subscription-product-detail .caripro-content h1 {
            font-size: 24px;
        }

        .subscription-product-detail .caripro-content p{
            margin-bottom: 0px;
        }
        #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box, #gehaPage .profile-container{
            max-width: 96%;
        }
        #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-price-text{
            font-size: 26px;
        }
    }


    @media (max-width: 1199px) {
        .subscription-product-detail {
            width: 100%;
        }

        #product-list.productLandingPageContainer .subscription-product-detail .caripro-content {
            width: 55%;
            margin-left: auto;
    margin-right: auto;
        }
        #product-list.productLandingPageContainer .subscription-product {
            width: 40%;
            margin-left: 60px;
        }

    }


            @media (max-width: 767px) {



                #gehaPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList{
                    top: -65px;
                }
                #product-list .grid-changed .backOrderList {
                    top: -80px;
                }
            }

                @media (min-width: 768px) {
                    #gehaPage section.shopLanderPageHader .pageheaderTop {
                        /* margin-top: 73px; */
                    }

                    #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent{
                    max-width: 50%;
                    justify-content: center;
                }

                #gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-image-wrap{
                    max-width: 50%;
                    justify-content: center;
                }


                }

            </style>
            <section class="shopLanderPageHader">

                <div class="pageHeader">

                    <div class="whitening-teeth-girl-with-smile mobileOptionDisplay show-mobile ">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
                    </div>


                    <div class="pageheaderTop" style="background:#65657f">
                        <div class="row no-flex">
                            <h1 class="font-mont weight-500 text-uppercase text-white">GEHA <span style="color: #b8b8dc;">MEMBER</span> DISCOUNTS</h1>
                            <p class="open-sans text-white">Welcome GEHA member! Save up to 70% on Teeth Whitening & Oral Care!</p>
                            <div class="whitening-teeth-girl-with-smile hidden-mobile">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
                            </div>
                        </div>
                    </div>



                    <div class="pageheaderBotm">

                        <div class="row no-flex">

                            <div class="flex-row">
                            <div class="productsortDropdown filterproductsOption">

<nav>
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2">
    All products
    </button>
    <ul class="subMenuDropdown" id="tagsbasedfilters">
    <li class="depth-1">
        <input type="radio" id="all" name="product-selection" class="child-radio2" value="all" data-slug="all">
        <label for="all" class="radio-custom-label">All products</label>
        </li>
        <li class="depth-1">
        <input type="radio" id="Bundle &amp; Save" name="product-selection" class="child-radio2" value="Bundle &amp; Save" data-slug="Bundle &amp; Save">
        <label for="Bundle &amp; Save" class="radio-custom-label">Bundle &amp; Save</label>
        </li>
        <li class="depth-1">
        <input type="radio" id="Featured!" name="product-selection" class="child-radio2" value="Featured!" data-slug="Featured!">
        <label for="Featured!" class="radio-custom-label">Featured!</label>
        </li>
        <li class="depth-1">
        <input type="radio" id="Low Stock" name="product-selection" class="child-radio2" value="Low Stock" data-slug="Low Stock">
        <label for="Low Stock" class="radio-custom-label">Low Stock</label>
        </li>
    </ul>
</nav>

<style>
    /*product dropdown css */
html body .productsortDropdown .subMenuDropdown {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    z-index: 1;
    width: 100%;
    min-width: 210px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.subMenuDropdown {
    display: none;
}
ul.subMenuDropdown > li {
    padding-left: 15px;
    padding-bottom: 0px;
    padding-top: 4px;
    cursor: pointer;
}
ul.subMenuDropdown > li label {
    cursor: pointer;
}
html body .subMenuDropdown>li>a, .subMenuDropdown .skin-careProductNav {
    background: url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 18px) 12px no-repeat;
    display: block;
    padding: 5px 20px;
    clear: both;
    font-weight: 600;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    padding-left: 15px;
    transition: all .4s;
    font-family: 'Montserrat';
}
.productsortDropdown {
    position: relative;
}
html body .productsortDropdown button {
    border: 0px;
    font-family: "Montserrat";
    background: url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 8px) 20px no-repeat !important;
    background-color: transparent;
    text-transform: capitalize;
    border-radius: 3px;
    height: 48px;
    line-height: 48px;
    color: #343434 !important;
    display: flex;
    align-items: center;
    justify-content: start;
    font-weight: 400;
    font-size: 16px;
    font-family: 'Montserrat';
    min-width: 270px;
    padding: 10px 0px !important;
    letter-spacing: 0px !important;
}
.menuActivate2 .subMenuDropdown {
    display: block;
}
.productsortDropdown .btn:hover{
    background-color: transparent !important;
    color:#343434;
}
.subMenuDropdown [type="radio"]:checked, [type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
section.shopLanderPageHader .pageheaderBotm{
    overflow: visible !important;
}
#product-list .medium-12 .cariPro_dental_probiotics_byJs .featureTag{
    z-index: 0 !important;
}
.child-radio2:checked + label {
    background-color: #eee;
    position: relative;
    width: 110%;
    left: -8px;
    padding: 5px 0px 5px 9px;
}
#product-list .featureTag{
    z-index: 0 !important;
}

@media screen and (max-width:767px){
    .productsortDropdown {
    width: 100%;
    max-width: 100%;
    border-bottom: 1px solid #bbb7b7;
    position: relative;
}
section.shopLanderPageHader .flex-row {
        gap: 10px;
        flex-wrap: wrap;
    }
    html body .productsortDropdown button{
        min-width:100%;
        padding-left:10px !important;
    font-size: 14px;

    }

}
</style>
</div>

                                <div class="filterproductsOption" style="display: none;">

                                    <select id="filter_products">
                                        <option value="all">All products</option>
                                        <option value="Bundle &amp; Save">Bundle &amp; Save</option>
                                        <option value="Featured!">Featured!</option>
                                        <option value="Low Stock">Low Stock</option>
                                    </select>
                                </div>
                                <div class="customsortDropdown all-product-dropdown">

<nav>
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton">
       Sort
    </button>
    <ul class="subMenuDropdown" id="price-sortt">
    <li class="depth-1">
        <input type="radio" id="default" name="single-selection" class="child-radio" value="default" data-slug="default">
        <label for="default" class="radio-custom-label">Sort</label>
        </li>
        <li class="depth-1">
        <input type="radio" id="price-low-to-high" name="single-selection" class="child-radio" value="price-low-to-high" data-slug="Price Low To High">
        <label for="price-low-to-high" class="radio-custom-label">Low Price To High</label>
        </li>
        <li class="depth-1">
        <input type="radio" id="High-Price-To-Low" name="single-selection" class="child-radio" value="price-high-to-low" data-slug="High Price To Low">
        <label for="High-Price-To-Low" class="radio-custom-label">High Price To Low </label>
        </li>
        <li class="depth-1">
        <input type="radio" id="Newest" name="single-selection" class="child-radio" value="newest" data-slug="Newest">
        <label for="Newest" class="radio-custom-label">Newest</label>
        </li>
    </ul>
    <script>
        // Get all radio buttons with the name 'single-selection'
const radioButtons = document.querySelectorAll('input[name="single-selection"]');

// Add an event listener to each radio button
radioButtons.forEach((radio) => {
    radio.addEventListener('change', function() {
        const selectedValue = this.value;
jQuery('#price-sort').val(selectedValue).trigger('change');
        // switch(selectedValue) {
        //     case 'price-low-to-high':
        //         // Add your logic to sort by price low to high
        //         console.log('Sorting by: Low price to high');
        //         sortAsc('price');
        //         break;
        //     case 'price-high-to-low':
        //         sortDesc('price');
        //         console.log('Sorting by: High price to low');
        //         break;
        //     case 'newest':
        //         // Add your logic to sort by newest
        //         console.log('Sorting by: Newest');
        //         sortDesc('date');
        //         break;
        //     default:
        //     sortAsc('recommended');
        //         // Default case, recommended sorting (if needed)
        //         console.log('Sorting by: Recommended');
        //         break;
        // }
        addremClass();
    });
});

    </script>
</nav>

<style>
                    html body .customsortDropdown .subMenuDropdown {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    z-index: 1;
    width: 100%;
    min-width: 190px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.subMenuDropdown {
    display: none;
}
ul.subMenuDropdown > li {
    padding-left: 15px;
    padding-bottom: 0px;
    padding-top: 4px;
    cursor: pointer;
}
ul.subMenuDropdown > li label {
    cursor: pointer;
}
html body .subMenuDropdown>li>a, .subMenuDropdown .skin-careProductNav {
    background: url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 18px) 12px no-repeat;
    display: block;
    padding: 5px 20px;
    clear: both;
    font-weight: 600;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    padding-left: 15px;
    transition: all .4s;
    font-family: 'Montserrat';
}
.customsortDropdown {
    position: relative;
}
#product-list .featureTag{
    z-index: 0 !important;
}
html body .customsortDropdown button {
    border: 0px;
    font-family: "Montserrat";
    background: url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 8px) 20px no-repeat !important;
    background-color: transparent;
    text-transform: capitalize;
    border-radius: 3px;
    height: 48px;
    line-height: 48px;
    color: #343434 !important;
    display: flex;
    align-items: center;
    justify-content: start;
    font-weight: 400;
    font-size: 16px;
    font-family: 'Montserrat';
    min-width: 210px;
    padding: 10px 0px !important;
    letter-spacing: 0px !important;
}
.menuActivate .subMenuDropdown {
    display: block;
}
.customsortDropdown .btn:hover{
    background-color: transparent !important;
    color:#343434;
}
.subMenuDropdown [type="radio"]:checked, [type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
section.shopLanderPageHader .pageheaderBotm{
    overflow: visible !important;
}
#product-list .medium-12 .cariPro_dental_probiotics_byJs .featureTag{
    z-index: 0 !important;
}
.child-radio:checked + label {
    background-color: #eee;
    position: relative;
    width: 110%;
    left: -8px;
    padding: 5px 0px 5px 9px;
}
@media screen and (max-width:767px){
    .customsortDropdown {
    width: 82%;
    position: relative;
    max-width: 82%;
    padding-left: 10px;
    border-bottom: 1px solid #bcb7b7;
}
html body .customsortDropdown button{
    min-width: 100%;
    font-size: 14px;
}
}
</style>

</div>


                                <div class="all-product-dropdown" style="display: none;">

                                    <select id="price-sort">

                                        <option value="default">Recommended</option>

                                        <option value="price-low-to-high">Low price to high</option>

                                        <option value="price-high-to-low">high price to low</option>

                                        <option value="newest">Newest</option>

                                    </select>

                                </div>


                                <div class="resetFilter">
                                    <a href="javascript:;" id="resetButton">Reset </a>
                                </div>


                            </div>

                        </div>

                    </div>



                </div>

            </section>

            <div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer">
                <div class="row-t product-item-display profile-container sale-page rdhtabs">
                <?php
$content = apply_filters('the_content', $page->post_content);
        echo do_shortcode($content);
    }
} else {

    ?>
                <section class="gehaPageBanner">
                    <div class="container">
                        <div class="rowMbt mt-100">
                            <div class="col-sm-4 geha-banner-text-section-parent">
                                <div class="geha-banner-text-section">
                                    <p class="font-mont text-white">PRODUCT PARTNER OF</p>
                                    <h1 class="gehaLogoLarge">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-logo.png" alt="GEHA" class="" />
                                    </h1>
                                    <h2 class="font-mont text-white">Exclusive discounts for<br>
                                        GEHA members & their<br> families!</h2>
                                    <div class="seeDiscountBtn">
                                        <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR DISCOUNT</button>
                                    </div>
                                    <div class="gehaLoginCustomer">
                                        <h3 class="font-mont">PAST CUSTOMER? <a href="/my-account/">Login</a> </h3>
                                    </div>

                                </div>
                            </div>
                            <!-- <div class="col-sm-8 graphicImagePeople">
                    <img src="<?php //echo get_stylesheet_directory_uri();
    ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" alt="" data-src="https://stable.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/geha-page/our-customer-banner-image.webp" decoding="async" class="">
                </div> -->

                            <div class="whitening-teeth-girl-with-smile col-sm-8 graphicImagePeople">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic-small.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
                            </div>

                        </div>
                    </div>
                </section>


                <section class="sectionProductDisplay">
                    <div class="container">
                        <div class="rowMbt">
                            <div class="col splitTwo productGripgSectionWrapper">
                                <div class="productGripgSection">
                                    <h3 class="font-mont text-white text-center">SAVE UP TO 70%</h3>
                                    <ul class="font-mont text-white">
                                        <li>Electric Toothbrushes & Water Flossers</li>
                                        <li>Professional Teeth Whitening Trays</li>
                                        <li>Custom-fitted Night Guards</li>
                                        <li>Solutions for Sensitive Teeth</li>
                                        <li>Solutions for Bad Breath</li>
                                    </ul>
                                    <div class="seeDiscountBtn text-center">
                                        <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR DISCOUNT</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col splitTwo productGripgSectionProduct">
                            </div>
                        </div>
                    </div>
                </section>


                <section class="sectionHsaFsa">
                    <div class="container">
                        <div class="rowMbt">
                            <div class="colhFsaSec splitTwo ">
                                <div class="rowMbtInner">
                                    <h4 class="font-mont mb-0 text-white text-center"> <span style="color:#62b1f4">HSA</span> &
                                        <span style="color:#66d55f">FSA</span> ELIGIBLE
                                    </h4>
                                    <p class="font-mont mb-0 text-white">Use your HSA or FSA account on eligible products</p>
                                </div>

                            </div>
                            <div class="colhLogoSec splitTwo">
                                <div class="logoesSecHfa">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/HSA.svg" alt="" class="" />
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/FSA.svg" alt="" class="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="ourCustomers">
                    <div class="container text-center">
                        <h2 class="font-mont" style="color:#440876;">OUR CUSTOMERS SPEAK FOR US</h2>
                        <h3>Over <span style="color:#eb6754">1 million happy customers</span> have relied on Smile Brilliant to<br>
                            improve their oral health & create a beautiful white smile!</h3>

                        <div class="customer-before-after-image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/our-customer-banner-image.webp" alt="" class="" />
                        </div>

                        <div class="seeDiscountBtn text-center">
                            <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR DISCOUNT</button>
                        </div>

                    </div>
                </section>

                <section class="ourSuportedCustomers product-logo-wrapper  smilePageIconSection smilePageIconSection-parent-div ">
                    <div class="hidden-mobile">
                        <div class="container">
                            <div class="rowMbt extra_logo_before-top logo-strip-one justify-conten">
                                <div class="boxSecBox box-with-extra-logo spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-health.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-forbes.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-fox.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-new-work-post.png" alt="" class="" />
                                </div>
                            </div>

                            <div class="rowMbt second-row extra_logo_before extra_logo_after_small logo-strip-two justify-conten">
                                <div class="medium-3 boxSecBox spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-circle.png" alt="" class="" />
                                </div>
                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-client.png" alt="" class="" />
                                </div>

                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-the-knot.png" alt="" class="" />
                                </div>
                                <div class="medium-3 col-md-3 col-4 boxSecBox box-with-extra-logo-right wpb_column columns medium-3 thb-dark-column small-12">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-allure.png" alt="" class="" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container show-mobile logoesformobileOnly">
                        <div class="rowMbt  justify-conten alin-items-center">
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-tiktok.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-health.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-forbes.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-fox.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-new-work-post.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-circle.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-client.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-the-knot.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-allure.png" alt="" class="" />
                            </div>

                        </div>
                    </div>



                </section>

                <section class="warrantysectionPage">
                    <div class="row wpb_row row-fluid year-wrannanty-container">
                        <div class="wpb_column columns medium-12 thb-dark-column small-12">
                            <div class="vc_column-inner   ">
                                <div class="wpb_wrapper">
                                    <div class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated text-center">

                                        <figure class="wpb_wrapper vc_figure">
                                            <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="150" height="150" src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-150x150.png" class="vc_single_image-img attachment-thumbnail" alt="" loading="lazy" srcset="https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-150x150.png 150w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-100x100.png 100w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-20x20.png 20w" sizes="(max-width: 150px) 100vw, 150px"></div>
                                        </figure>
                                    </div>

                                    <div class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_fadeIn fadeIn vc_custom_1596013369071 wpb_start_animation animated text-center">

                                        <figure class="wpb_wrapper vc_figure">
                                            <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="300" height="66" src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-300x66.png" class="vc_single_image-img attachment-medium" alt="" loading="lazy" srcset="https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-300x66.png 300w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-190x42.png 190w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-20x4.png 20w" sizes="(max-width: 300px) 100vw, 300px"></div>
                                        </figure>
                                    </div>
                                    <h3 style="text-align: center" class="vc_custom_heading">TRY IT. <span style="color:#522773;">LOVE IT</span> ...or return it</h3>
                                    <div class="vc_wp_text wpb_content_element warrabty-text-container">
                                        <div class="widget widget_text">
                                            <div class="textwidget">
                                                <p>Smile Brilliant is America's #1 brand of customized oral care products and a
                                                    proud partner of GEHA Insurance. All GEHA clients, their children, domestic
                                                    partners, spouses, parents, and grand parents are eligible for exclusive discounts
                                                    on professional teeth whitening, night guards, toothbrushes and oral care
                                                    products. Everything we offer comes with a money back guarantee. Simply register
                                                    and begin receiving your savings!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vc_wp_text wpb_content_element order-the-system-cnt">
                                        <div class="widget widget_text">
                                            <div class="textwidget">
                                                <h3 class="itsSimpleHeading">ITS THAT SIMPLE</h3>
                                                <div class="seeDiscountBtn text-center">
                                                    <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR GEHA DISCOUNTS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="gehanFormSection" id="gehaform">
                    <div class="container">
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <div class="container-form">
                            <form id="geha_discount_registration_form">
                                <div class="row form-steps fullWidth">
                                    <div class="col-sm-12 tp-head-form">
                                        <div class="logo">
                                            <h1 class="gehaLogoLarge">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-logo.png" alt="GEHA" class="" />
                                            </h1>
                                        </div>
                                        <h5 class="font-mont text-white">DISCOUNT REGISTRATION FORM</h5>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="first_name" class="control-label">First Name</label>
                                        <input name="first_name" type="text" id="entryFastName" value="" placeholder="First Name" class="form-control input-lg">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="last_name" class="control-label">Last Name</label>
                                        <input name="last_name" type="text" id="entryLastName" value="" placeholder="Last Name" class="form-control input-lg">
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label for="email" class="control-label">Email Address</label>
                                        <input type="email" id="entryEmail" value="" placeholder="Email Address" name="email" class="form-control input-lg">
                                    </div>
                                    <div class="col-md-6 form-group member-ids">
                                        <label for="Member ID" class="control-label">Member ID (Last 4 Digits)</label>
                                        <input type="text" maxlength="4" id="entryGehaMemberId" value="" placeholder="Last 4 Digits Member ID" name="member_id" class="form-control input-lg">
                                    </div>

                                    <div class="col-md-6 form-group member-ids">
                                        <label for="entryGehaMemberIdConfirm" class="control-label">Confirm Member ID (Last 4
                                            Digits)</label>
                                        <input type="text" maxlength="4" id="entryGehaMemberIdConfirm" value="" placeholder="Last 4 Digits Member ID" name="confirm_member_id" class="form-control input-lg">
                                    </div>

                                    <div class="col-md-12 text-center form-notes">
                                        <p class="text-white">Your Name and Member ID will be used to confirm account status. Member ID may be listed
                                            on your ID card under "RxID" or simply "ID".Discount codes will be emailed to the email
                                            address provided.</p>
                                    </div>

                                    <div class="col-md-12 sep-top-sm text-center seeDiscountBtn text-center">
                                        <button type="submit" class="btn btn-primary btn-primary-purple-drk btn-primary-geha" id="send-my-discount">REGISTER</button>
                                    </div>

                                    <div class="gehaLoginCustomer w-100 text-center">
                                        <h3 class="font-mont">ALREADY A PAST CUSTOMER? <a href="/my-account/">Login</a> </h3>
                                    </div>


                                </div>
                                <input type="hidden" name="action" value="add_geha_coupon_code">

                            </form>
                            <div class="row after-success">
                                <h1 class="font-mont text-white">YOUR DISCOUNT CODE HAS BEEN GENERATED!
                                </h1>
                                <p class="text-white">Your unique GEHA discount code has been created and is listed below (it has also been sent to you
                                    via email).<b>To order, begin the checkout process, click the "Enter Gift Code," and enter this
                                        code below to receive 20% off sitewide!</b></p>


                                <div id="geha-coupon-code-box">
                                    GEAZVHBVVB</div>

                                <p class="text-white">
                                    As always, our customer support representatives are here to help. Feel free to call, email, or
                                    use our live chat feature to connect with our team!</p>
                            </div>
                        </div>
                    </div>



                </section>

            <?php
}?>

                </div>
            </div>





            <?php
// Start the loop
while (have_posts()): the_post();
    $contentp = get_the_content();
    if (is_null($contentp)) {
        $contentp = '';
    }
    if ($contentp != '') {
        echo apply_filters('the_content', $contentp);
    }

endwhile; // End of the loop.
?>


            <div class="disclaimer-bar-purple">
                <div class="container">
                    <p>
                        <i>These benefits are neither offered nor guaranteed under contract with the FEHB or FEDVIP Programs, but are made available to all Enrollees who become members of GEHA and their eligible family members.</i>
                    </p>
                </div>
            </div>


</div>
<div class="popupGehaContainer">
    <div class="modal">
        <div class="modal-content">
            <div class="popupHeader">
                <span class="close-button">×</span>
            </div>
            <div class="popupBodyContent text-center">
                <h1 class="gehaTextmember">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/geha-popup-logo.jpg" alt="GEHA" class="" />
                </h1>
                <p class="memeberGranted">MEMBER DISCOUNT ACCESS GRANTED</p>
                <h2 class="youreInText">YOU’RE IN!</h2>
                <h3 class="pleaseRed">please read:</h3>
                <p class="descriptionBody">Welcome GEHA member! You now have access to give your exclusive GEHA discounts. An email has also been sent to you with your account login details. To view your discounts in the future, simply login. Our live chat and customer support team is also here to help!<br><br>
                    <strong>CLICK THE BUTTON BELOW TO VIEW THE DISCOUNT PAGE</strong>
                </p>
                <div class=" sep-top-sm text-center seeDiscountBtn text-center">
                    <a href="<?php echo site_url('geha?utm_campaign=userExists'); ?>" class="btn">SEE DISCOUNT PAGE</a>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    landing_str = '';

    var product_list;

    var landing_products;


    jQuery(document).ready(function() {
        jQuery(document).on('change', '#filter_products', function() {

show_hide_div_by_tag(jQuery(this).val());


// setTimeout(function() {
//     $('.selectquantitybtn').click(function() {
//         var price = $(this).attr('data-price');
//         console.log(price);
//         //$(this).parents('.product-selection-box').find('.price-display').text(price);
//     });

//     $('.plus-btn').click(function() {
//         var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
//         quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
//         updatePrice($(this).parents('.product-selection-box').find('.box'));
//     });

//     $('.minus-btn').click(function() {
//         var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
//         var decrementedValue = parseFloat(quantity.val()) - 1;
//         if (decrementedValue >= 1) {
//             quantity.val(decrementedValue).trigger('change');
//             updatePrice($(this).parents('.product-selection-box').find('.box'));
//         }
//     });

// }, 500);


});
jQuery(document).on('change', '#price-sort', function() {

if ($(this).val() == 'price-low-to-high') {

    sortAsc('price');

} else if ($(this).val() == 'price-high-to-low') {

    sortDesc('price');

} else if ($(this).val() == 'newest') {

    sortDesc('date');

} else if ($(this).val() == 'default') {

    sortAsc('default');

} else {

    sortAsc('recommended');

}

addremClass();


// setTimeout(function() {
//     $('.selectquantitybtn').click(function() {
//         var price = $(this).attr('data-price');
//         console.log(price);
//         //$(this).parents('.product-selection-box').find('.price-display').text(price);
//     });

//     $('.plus-btn').click(function() {
//         var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
//         quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
//         updatePrice($(this).parents('.product-selection-box').find('.box'));
//     });

//     $('.minus-btn').click(function() {
//         var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
//         var decrementedValue = parseFloat(quantity.val()) - 1;
//         if (decrementedValue >= 1) {
//             quantity.val(decrementedValue).trigger('change');
//             updatePrice($(this).parents('.product-selection-box').find('.box'));
//         }
//     });

// }, 500);


});


        jQuery('#product-list').children().each(function(index) {
            jQuery(this).addClass('child-' + index);
        });

        counter = 0;

        jQuery('.lander-shortcode').each(function() {

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

        setTimeout(function() {

            // jQuery(document).find('.lander-shortcode').each(function(){

            // 	jQuery(this).parent('.landing-product').attr('price',jQuery(this).attr('price'));

            // 	jQuery(this).parent('.landing-product').attr('date',jQuery(this).attr('date'));

            // 	jQuery(this).parent('.landing-product').attr('recommended',jQuery(this).attr('recommended'));

            // });

            landing_products = jQuery(document).find('.landing-product');

            product_list = $('#product-list');

            str = '<option value="all">All products</option>';
            str2 = '<li class="depth-1"><input type="radio" id="all" name="product-selection" class="child-radio2" value="all" data-slug="all"><label for="all" class="radio-custom-label">All products</label></li>';

            jQuery(document).find('.landing-product').each(function() {

                attr_val = jQuery(this).data('tagging');

                if (str.includes(attr_val) || attr_val == 'Select') {

                    // continue

                } else {

                    str += '<option value="' + attr_val + '">' + attr_val + '</option>';
                    str2 += '<li class="depth-1"><input type="radio" id="'+attr_val+'" name="product-selection" class="child-radio2" value="'+attr_val+'" data-slug="all"><label for="'+attr_val+'" class="radio-custom-label">'+attr_val+'</label></li>';

                }



            });

            jQuery('#filter_products').html(str);
            jQuery('#tagsbasedfilters').html(str2);
        }, 500);





    });
    function show_hide_div_by_tag(tag_val) {

        if (tag_val == 'all') {

            jQuery('.landing-product').show();



        } else {

            jQuery(document).find('.landing-product').each(function() {

                attr_val = jQuery(this).data('tagging');

                if (tag_val != attr_val) {

                    jQuery(this).hide();

                } else {

                    jQuery(this).show();

                }

            });

        }

        addremClass();



    }

    function addremClass() {
        if (jQuery('#price-sort').val() != 'default' || (jQuery('#filter_products').val() != 'all')) {
            jQuery('#wrapper,#product-list').addClass('grid-changed');
        } else {
            jQuery('#wrapper,#product-list').removeClass('grid-changed');
        }
    }

    function sortAsc(attr) {
        product_list.empty();
        landing_products.sort(function(a, b) {
            return $(a).data(attr) - $(b).data(attr)
        });
        product_list.append(landing_products);
    }

    function sortDesc(attr) {
        product_list.empty(attr);
        landing_products.sort(function(a, b) {
            return $(b).data(attr) - $(a).data(attr)
        });
        product_list.append(landing_products);
    }

    jQuery(document).ready(function() {
        jQuery('#resetButton').click(function() {
            jQuery('#filter_products').val('all');
            $("#dropdownMenuButton2").text("All Products");
            jQuery('#price-sort').val('default');
            jQuery('#filter_products').trigger('change');
            jQuery('#price-sort').trigger('change');
            jQuery(".customsortDropdown").removeClass("menuActivate");
            jQuery(".productsortDropdown").removeClass("menuActivate2");
            



        })
    });
</script>

<script>
    jQuery(document).ready(function() {

        jQuery('#product-list').children().each(function(index) {
            jQuery(this).addClass('child-' + index);
        });

        // add a click event listener to all links with the class "scroll-link"
        jQuery(".scroll-link").on("click", function(event) {
            event.preventDefault(); // prevent default link behavior
            var target = jQuery(this).attr("href"); // get the target div ID from the link href attribute
            var offset = jQuery(target).offset().top - 100; // get the target div offset from the top of the page
            jQuery("html, body").animate({
                scrollTop: offset
            }, 1000); // animate the scroll to the target div
        });
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
        if (!jQuery(event.target).closest('.product-selection-description-parent-inner').length) {
            jQuery('.openPackage-quantity').removeClass('openPackage-quantity');
        }
    });

    jQuery('.lander-shortcode').each(function() {
        jQuery(this).parents('.wpb_column').addClass('landing-product');

    });




    jQuery(document).on("change", ".quantity", function() {
        console.log('changed-val');
        selected_product_id = jQuery(this).attr('data-pid');
        console.log(jQuery(this).val());
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id', selected_product_id);
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href', '?add-to-cart=' + selected_product_id);
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-quantity', jQuery(this).val());
    })

    // $(document).ready(function() {
    // jQuery(".selectquantitybtn").click(function(){
    jQuery(document).on('click', '.selectquantitybtn', function() {
        console.log('hello');
        jQuery(this).parents('.product-selection-box').find('.quantity').trigger('change');
    });


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
    //  $('.plus-btn').click(function() {
    jQuery(document).on('click', '.plus-btn', function() {
        var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
        quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
        updatePrice($(this).parents('.product-selection-box').find('.box'));
    });

    //  $('.minus-btn').click(function() {
    jQuery(document).on('click', '.minus-btn', function() {
        var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
        var decrementedValue = parseFloat(quantity.val()) - 1;
        if (decrementedValue >= 1) {
            quantity.val(decrementedValue).trigger('change');
            updatePrice($(this).parents('.product-selection-box').find('.box'));
        }
    });
    // });

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
            jQuery('#quick_cart').hide();
        }
    });
    jQuery(document).ajaxComplete(function(event, xhr, settings) {
        if (typeof settings !== 'undefined' && typeof settings.data !== 'undefined') {
            if (settings.data.includes("product_id")) {
                if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
                    jQuery('#quick_cart').hide();
                } else {
                    jQuery('#quick_cart').show();
                }
            }
        }
    });




    var modal = document.querySelector(".modal");
    var closeButton = document.querySelector(".close-button");

    function toggleModal() {
        modal.classList.toggle("show-modal");
    }

    function windowOnClick(event) {
        if (event.target === modal) {
            toggleModal();
        }
    }

    closeButton.addEventListener("click", toggleModal);
    window.addEventListener("click", windowOnClick);


    jQuery(document).on('click', '#send-my-discount', function(e) {
        e.preventDefault();
        hasserror = false;
        jQuery('#geha_discount_registration_form input').each(function() {
            if (jQuery(this).val() == '') {
                jQuery(this).addClass('has_error');
                hasserror = true;
            } else {
                jQuery(this).removeClass('has_error');
            }
        });
        if (hasserror) {
            return false;
        }
        var data_ajax = jQuery('#geha_discount_registration_form').serialize();
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: ajaxurl,
            data: data_ajax,
            success: function(response) {
                if (response.status == true) {
                    jQuery('.container-form .row.after-success #geha-coupon-code-box').text(response
                        .code);
                    jQuery('.container-form .row.after-success').show();
                    jQuery('#geha_discount_registration_form').hide();
                    toggleModal();
                    try {

                        window._learnq = window._learnq || [];
                        window._learnq.push(['identify', {
                            '$email': jQuery('#entryEmail').val(),
                            '$first_name': jQuery('#entryFastName').val(),
                            '$last_name': jQuery('#entryLastName').val()
                        }]);
                        window._learnq.push(["track", "GEHA Discount", {}]);

                    } catch (err) {}

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.code,

                    })
                }
            }
        });
    });
    /*For total*/
    // jQuery(document).ready(function() {
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

    //  jQuery(document).find("input[name='fav_language']").click(function() {
    jQuery(document).on('change', 'input[name="fav_language"]', function() {
        console.log('child cliecked');
        selected_product_id = jQuery(this).attr('data-pid');
        av_price = jQuery(this).attr('data-avr-price');
        var geha_sale_price = $(this).attr('data-geha_sale_price');
        if (typeof geha_sale_price !== 'undefined' && geha_sale_price !== false && geha_sale_price != '' && geha_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-geha_sale_price', geha_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-geha_sale_price');
        }
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id', selected_product_id);
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href', '?add-to-cart=' + selected_product_id);
        if (av_price != '') {
            jQuery(this).parents('.product-selection-box').find('.normalyAmount').show();
            jQuery(this).parents('.product-selection-box').find('.targeted_avr').html(av_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.normalyAmount').hide();
        }
        jQuery(this).parents('.product-selection-box').find('.packageAmount').text(jQuery(this).attr('data-price'));


    });


    jQuery(document).ready(function(){
        // Find the text and wrap it in a span with the class "blue-text"
        jQuery(".featureTag span:contains('+ FREE GIFT')").html(function(_, html) {
            return html.replace(/(\+ FREE GIFT)/g, '<span class="blue-text-js">$1</span>');
        });
    });


    // REMOVE BACKORDER ON ULTRASONIC PRODUCT
    jQuery(document).ready(function() {
    // Select all elements with class 'product-selection-box' inside 'product-list'
    var productBoxes = jQuery('#product-list .product-selection-box');

    // Iterate through each product-selection-box
    productBoxes.each(function() {
      // Check if the text content includes "Ultrasonic"
      if (jQuery(this).text().includes('Ultrasonic')) {
        // Add the 'highlight' class
        jQuery(this).addClass('ultrasonic-text-contain-by-js');
      }
    });
  });
  jQuery(".customsortDropdown").removeClass("menuActivate");
  $("#dropdownMenuButton").click(function(event) {
        event.stopPropagation(); // Prevent click event from bubbling up to the document
        $(".customsortDropdown").toggleClass("menuActivate");
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.customsortDropdown, #dropdownMenuButton').length) {
            $(".customsortDropdown").removeClass("menuActivate");
        }
    });
  $(".child-radio").change(function() {
    var selectedValue = $(".child-radio:checked").val();

    if (selectedValue) {
        $("#dropdownMenuButton").text(selectedValue);
        $(".customsortDropdown").removeClass("menuActivate");
    } else {
        $("#dropdownMenuButton").text("All Products");
    }
});

    //});

    jQuery(".productsortDropdown").removeClass("menuActivate2");
  $("#dropdownMenuButton2").click(function(event) {
        event.stopPropagation(); // Prevent click event from bubbling up to the document
        $(".productsortDropdown").toggleClass("menuActivate2");
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.productsortDropdown, #dropdownMenuButton2').length) {
            $(".productsortDropdown").removeClass("menuActivate2");
        }
    });
    $(document).on("change", ".child-radio2", function() {
    var selectedValue = $(".child-radio2:checked").val();
    if ($(this).attr("name") === "product-selection") {
        show_hide_div_by_tag($(this).val());
    }

    if (selectedValue) {
        $("#dropdownMenuButton2").text(selectedValue);
        $(".productsortDropdown").removeClass("menuActivate2");
    } else {
        $("#dropdownMenuButton2").text("All Products");
    }
});


</script>
<?php

get_footer();

?>