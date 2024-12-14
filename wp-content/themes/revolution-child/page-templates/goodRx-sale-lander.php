<?php
/*Template Name:  GoodRx Sale Lander Template */

global $GEHA_PAGE_ID;
//$GEHA_PAGE_ID =  get_the_ID();
$GEHA_PAGE_ID = GOOD_RX_TEMPLATE_PAGE_ID;
if (function_exists('w3tc_flush_url')) {
    w3tc_flush_url(get_permalink(get_the_ID()));
}
session_start();
$goodrxFlag = false;
if (isset($_GET['utm_campaign']) && $_GET['utm_campaign'] == 'userExists') {
    setcookie('goodrx', 'yes', time() + (3600 * 24 * 360), '/');
    $_SESSION['goodrx'] = 'yes';
    set_transient('goodrx', 'yes', 365 * DAY_IN_SECONDS);
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'goodrx', 'yes');
    }
    $goodrxFlag = true;
    if (function_exists('w3tc_flush_url')) {
        w3tc_flush_url(get_permalink(get_the_ID()));
    }
}

if (isset($_COOKIE['goodrx']) && $_COOKIE['goodrx'] == 'yes') {
    $goodrxFlag = true;
}
if (isset($_SESSION['goodrx']) && $_SESSION['goodrx'] == 'yes') {
    $goodrxFlag = true;
}
if (isset($_COOKIE['goodrxOneTime']) && $_COOKIE['goodrxOneTime'] == 'yes') {
    $goodrxFlag = true;
    setcookie('goodrxOneTime', '', time() - 100000, '/');
}
if (get_transient('goodrx') == 'yes') {
    // $goodrxFlag = true;
}

if (is_user_logged_in()) {
    if (get_user_meta(get_current_user_id(), 'goodrx', true) == 'yes') {
        $goodrxFlag = true;
    }
}
if (isset($_GET['email']) && $_GET['email'] != '') {
    gehaUserAddUpdateURL($_GET['email']);
    $goodrxFlag = true;
    if (function_exists('w3tc_flush_url')) {
        w3tc_flush_url(get_permalink(get_the_ID()));
    }
}
get_header();

?>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<style>

@font-face {
    font-family: 'kaleko_105_boldbold';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105bold-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105bold-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}    

@font-face {
    font-family: 'kaleko_105book';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105book-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105book-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'kaleko_105light';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105light-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/kaleko/kaleko105light-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}


    .dark-blue {
        background: #24156e;
    }

    .section-header h1 {
        font-size: 36px;
        font-weight: 600;
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .warrabty-text-container p {
        font-size: 18px;
    }

    .light-blue {
        background: #3b97ca;
    }

    .clients-logoes {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .beneth-starts-rating {
        font-size: 28px;
        font-weight: 300;
        color: #fff;
        margin-top: 5px;
    }

    .beneth-starts-rating i {
        font-weight: 400;
    }

    .d-flex {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .logoes-strip-mbt {
        column-gap: 30px;
        margin-top: 30px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .section-body .logoes-strip-mbt {
        margin-top: 2rem;
        margin-bottom: 0rem;
    }

    .mulimages.slick-initialized .slick-slide {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-6>.vc_column-inner {
        background-color: #fff !important;
    }


    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
        max-width: 1330px;
    }

    #gehaPage .gehaPageBanner:before {
        content: "";
        background-image: url(https://www.abenity.com/wp-content/uploads/2021/02/diamonds-bg-white.svg);
        background-position: center center;
        background-size: contain;
        opacity: 0.14;
        position: absolute;
        height: 100%;
        width: 100%;

    }

    #gehaPage .gehaPageBanner {
        position: relative;
        max-height: 630px;
        overflow: hidden;
        background: #fae64f;
        padding-top: 2rem;
        transition: background 0.3s, border-radius 0.3s, opacity 0.3s;
        /* background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%); */
        /* background-image: url(/wp-content/themes/revolution-child/assets/images/one-dental/one-dental-banner-bg.jpg);
        background-repeat: no-repeat; */
        /* background-position: center; */
        padding-bottom: 3rem;
        position: relative;
    }

    .mouth-guards-banner {
        position: absolute;
        width: 500px;
        height: 554px;
        left: -143px;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .electric-tooth-brush-banner {
        position: absolute;
        width: 500px;
        height: 554px;
        right: 0px;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .electric-tooth-brush-banner {
        position: absolute;
        width: 100%;
        height: 86%;
        right: 0px;
        background-size: contain;
        background-repeat: no-repeat;
        top: 69px;
        right: -15%;
        background-position: right;
    }

    #gehaPage .gehaPageBanner .container {
        position: relative;
        z-index: 12;
    }

    @media screen and (min-width: 2000px) and (max-width: 2399px) {
        #gehaPage .geha-banner-text-section h2 {
            /* color: red !important; */
        }

        .electric-tooth-brush-banner {
            top: 17px;
            right: -10%;
            height: 95%;
        }
    }

    @media screen and (min-width: 2400px) and (max-width: 3000px) {
        #gehaPage .geha-banner-text-section h2 {
            /* color: green !important; */
        }

        .electric-tooth-brush-banner {
            top: -9px;
            right: -6%;
            height: 102%;
        }
    }

    @media (max-width: 1700px) {
        .electric-tooth-brush-banner {
            height: 75%;
        }
    }

    @media (max-width: 1500px) {
        .electric-tooth-brush-banner {
            height: 66%;
        }

        .mouth-guards-banner {
            width: 469px;
            height: 447px;
        }
    }


    @media (max-width: 1300px) {
        .electric-tooth-brush-banner {
            height: 50%;
            top: 93px;
            right: -12%;
        }

        .mouth-guards-banner {
            width: 433px;
            height: 521px;
            left: -188px;
        }

        #gehaPage .geha-banner-text-section h2 {
            font-size: 22px;
        }
    }

    @media (max-width: 767px) {
        .electric-tooth-brush-banner {
            display: none;
        }
    }


    #gehaPage .gehaPageBanner .container {
        max-width: 1160px;
    }

    .goodrx-logo-circle {
        max-width: 411px;
    }

    .primary-head-image {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
    }

    .primary-head-image img {
        /* max-width: 400px;
        border-radius: 50% 50% 50% 50%;
        box-shadow: 0px 12px 26px 6px rgba(0, 0, 0, 0.2);
        border: 1px solid #fff; */
    }

    .gehanFormSection {
        background-color: #6db244;
    }

    #gehaPage .rowMbt {
        justify-content: space-between;
        display: flex;
        flex-wrap: wrap;
    }

    .mt-100 {
        /* padding-top: 100px; */
    }

    #gehaPage .geha-banner-text-section-parent {
        width: 100%;
        max-width: 500px;
    }

    #gehaPage .graphicImagePeople {
        width: 100%;
        max-width: 570px;
        text-align: right;
    }

    #gehaPage .text-white {
        color: #fff;
    }

    #gehaPage .geha-banner-text-section {
        text-align: center;
        padding-top: 50px;
        position: relative;
    }

    #gehaPage .geha-banner-text-section p {
        margin-bottom: 0;
        padding-bottom: 10px;
    }

    #gehaPage .geha-banner-text-section p.prpt {

        line-height: 1.2;
        margin-top: -10px;
        font-size: 20px;
        font-size: 30px;
        color: #000;
    }

    #gehaPage .geha-banner-text-section h2 {
        margin-top: 40px;
        margin-top: 10px;
        font-size: 30px;
        margin-bottom: 50px;
        line-height: 1.1;
        color: #0c2242;
    }

    #gehaPage .gehaLoginCustomer {
        margin-top: 25px;
    }


    .registeded-btn-stp {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .registeded-btn-stp .stip-sttpp {
        color: #0c2242;
        padding-left: 5px;
        font-weight: 400;
    }

    .registeded-btn-stp .stip-sttpp a {
        color: #0c2242;
        font-weight: 400;
    }

    #gehaPage .gehaPageBanner .seeDiscountBtn button {
        /* border-radius: 20px; */
    }

    #gehaPage .seeDiscountBtn button {
        background: #0f56a6;
        border-color: #0f56a6;

        letter-spacing: 0;
        font-size: 20px;

    }

    #gehaPage .seeDiscountBtn button:hover {
        background-color: #595858;
        border-color: #595858;
    }

    #gehaPage .gehaLoginCustomer h3 {
        font-size: 20px;
        font-weight: 400;
        margin: 0;
        color: #fff;
    }

    #gehaPage .gehanFormSection .gehaLoginCustomer h3 {
        color: #0c2242;
    }

    #gehaPage .gehaLoginCustomer h3 a:hover {
        color: #fff;
    }

    #gehaPage .gehaLoginCustomer h3 a {
        color: #0c2242;

        font-weight: 400;
    }

    #gehaPage .splitTwo {
        width: calc(100%/2);
    }

    #gehaPage .productGripgSectionWrapper {
        background: #1fabc2;
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
        color: #0b4c6c;
        text-align: center;
        margin-bottom: 0;
        font-weight: 500;
        font-size: 30px;
        margin-bottom: 20px;
    }

    #gehaPage section.warrantysectionPage {
        margin-bottom: 70px;
    }

    #gehaPage section.gehanFormSection {
        padding-top: 50px;
        padding-bottom: 50px;
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

    #gehaPage section.shopLanderPageHader .pageheaderTop {
        background-color: #f4f4f4;
        /* background-image: url(/wp-content/themes/revolution-child/assets/images/one-dental/one-dental-after-login-top-banner.jpg); */
        background-repeat: no-repeat;
        background-position: center;
        position: relative;
    }

    #gehaPage section.shopLanderPageHader .pageheaderTop:before {
        content: "";
        background-image: url(https://www.abenity.com/wp-content/uploads/2021/02/diamonds-bg-white.svg);
        background-position: center center;
        background-size: contain;
        opacity: 0.14;
        position: absolute;
        height: 100%;
        width: 100%;
    }



    #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
        right: 112px;
        top: -45px;
        max-width: 296px;
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
        background-color: #0f56a6;
        border-color: #0f56a6;
    }

    #gehaPage .productLandingPageContainer .medium-12 .small-desc h4,
    .productLandingPageContainer .medium-12 .small-desc h5 {
        color: #65657f;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12 .product-selection-description b {
        color: #65657f;
        font-weight: 500;
    }

    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
    #gehaPage .packageQuantityBox,
    .selectPackageBox {
        background: #fdfae0;
    }

    .flex-item-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        column-gap: 14px;
        flex-direction: column;
    }

    #gehaPage .graphicImagePeople img {
        /* width: 100%;
        max-width: 776px; */
    }


    #register-loader {
        display: none;
        border: 8px solid #f3f3f3;
        /* Light grey */
        border-top: 8px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        position: absolute;
        top: 70%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }


    /* popup */

    .modal {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        opacity: 0;
        visibility: hidden;
        transform: scale(1.1);
        transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
        z-index: 9999;
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
        border: 10px solid #0f56a6;
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

    .close-button {
        display: none !important;
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
        color: #569ec3;
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
        background: #0f56a6;
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
        background: #0a4b6b;
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

    #gehaPage .productLandingPageContainer span.product-selection-price-text.hoo,
    #gehaPage .productLandingPageContainer span.product-selection-price-text.heee {
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

    input[type="text"]::placeholder,
    input[type="password"]::placeholder,
    input[type="date"]::placeholder,
    input[type="datetime"]::placeholder,
    input[type="email"]::placeholder,
    input[type="number"]::placeholder,
    input[type="search"]::placeholder,
    input[type="tel"]::placeholder,
    input[type="time"]::placeholder,
    input[type="url"]::placeholder,
    input[type="file"]::placeholder,
    textarea::placeholder {

        font-weight: 400;
        color: #000;

    }

    #wrapper .container-form .product-of-intestest .form-group label {
        display: inline-flex;
        color: #0c2242;
    }

    #wrapper .container-form .product-of-intestest .form-group {
        display: block;
        margin-bottom: 15px;
    }

    #wrapper .container-form .product-of-intestest .form-group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }

    #wrapper .container-form .product-of-intestest .form-group label {
        position: relative;
        cursor: pointer;
    }

    #wrapper .container-form .product-of-intestest .form-group label:before {
        content: '';
        -webkit-appearance: none;
        background-color: #fff;
        border: 2px solid #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 8px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 12px;
    }

    .form-group input:checked+label:after {
        content: '';
        display: block;
        position: absolute;
        top: 1px;
        left: 7px;
        width: 6px;
        height: 14px;
        border: solid #6db244;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .dflex-option {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .dflex-option .form-group {
        width: 33.333%;
    }

    .product-of-intestest h6 {
        color: #0c2242;
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
        text-transform: capitalize;
    }

    .product-of-intestest h6 span {
        font-size: 70%;
    }

    .fw-normal {
        font-weight: normal !important;
    }

    .disclaimer-bar-purple {
        background: #569ec3;
    }

    .text-white-500 {
        color: #fff;
    }

    .bg-sky-500 {
        background: #3d98cc !important;
    }

    .bg-blue-200 {
        background: #fae64f !important;
    }

    .bg-gradient-blue-500 {
        background-image: linear-gradient(to bottom, #450976, #613387) !important;
    }


    section.shopLanderPageHader .pageheaderTop p {
        line-height: 1.2;
    }

    #product-list span.product-selection-price-text .wasText {
        display: none;
    }

    #product-list span.product-selection-price-text del bdi,
    #product-list span.product-selection-price-text .wasText {
        color: #a2a3a5;
        font-size: 24px;
        font-weight: 400;
    }

    .floting-geha-button {
        left: 0;
        transform: rotate(0deg);
        background-color: #0a4b6b;
    }

    .page-template-page-templatesgoodrx-template-php .has_error {
        border: 2px solid red !important;
    }

    .geha-memeber-button {
        position: absolute;
        bottom: 100%;
        -webkit-transform: rotateZ(90deg);
        transform-origin: 0 100%;
        background-color: #0a4b6b;
        white-space: nowrap;
        display: none;
    }

    .floting-geha-button .geha-memeber-button a {
        padding: 12px;
    }

    #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount,
    #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount,
    #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount bdi,
    #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount bdi {
        font-size: 28px;
        font-weight: 400;
    }

    .footer {
        padding: 0px 0;
    }

    section.shopLanderPageHader .pageheaderBotm select {
        font-family: "Montserrat";
    }

    .gehaTextmember {
        max-width: 286px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
    }

    .normalyAmount.italic {
        display: none !important;
    }

    #gehaPage .gehanFormSection .seeDiscountBtn #send-my-discount_partner {
        min-width: 400px;
        border-radius: 0;
    }

    #product-list .medium-12 .featureTag {
        background: #fae64f;
    color: #000;
    }

    .popupBodyContent.text-center .gehaTextmember .goodrx-logo-circle {
        max-width: 252px;
    }



    




    @media (min-width: 991px) {
        #product-list:not(.grid-changed) .medium-8~.medium-4.landing-product .product-selection-price-text-top.noflexDiv {
            height: 56px;
        }

        #product-list.grid-changed .medium-8 .product-selection-image-wrap,
        #product-list.grid-changed .medium-4 .product-selection-image-wrap {
            min-height: 300px;
            max-width: 375px;
            max-height: 300px;
            overflow: hidden;
        }

        #product-list.grid-changed .medium-4.landing-product .product-selection-description-parent,
        #product-list.grid-changed .medium-8.landing-product .product-selection-description-parent {
            max-width: inherit;
            width: auto;
            min-height: 130px;
            max-height: 130px;
        }

        #gehaPage .graphicImagePeople {
            /* padding-right: 4rem; */
        }

    }



    @media (min-width: 768px) {

        .col-sm-12.tp-head-form {
            margin-bottom: 40px;
        }

        #product-list.productLandingPageContainer:not(.grid-changed) .medium-8.landing-product.child-4 .product-selection-image-wrap {
            max-height: 351px;
            overflow: hidden;

        }

        #product-list:not(.grid-changed) .medium-8~.medium-4.landing-product.child-5 .product-selection-image-wrap {
            max-height: 280px;
            overflow: hidden;
            min-height: 280px;
        }


        #product-list.productLandingPageContainer:not(.grid-changed) .medium-8~.medium-4.landing-product .product-selection-description-parent {
            min-height: 194px;
            max-height: 194px;
        }

        #product-list.productLandingPageContainer:not(.grid-changed) .medium-8.landing-product .selectPackageBox {
            max-width: 300px;
            left: 0;
            right: 0;
            margin-left: auto;
            border: 1px solid #c5c6c9;
        }

        #product-list.productLandingPageContainer .medium-8.landing-product.child-4 .wasText {
            position: relative;
            top: 2px;
        }

        #product-list span.product-selection-price-text .medium-8~.medium-4.landing-product .wasText {
            position: relative;
            top: 3px;
        }


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
            font-size: 38px;
        }

        #gehaPage section.ourCustomers h3 {
            font-size: 20px;
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

    @media (min-width: 1023px) and (max-width: 1199px) {
        #gehaPage .geha-banner-text-section-parent {
            max-width: 475px;
        }

        #gehaPage .graphicImagePeople {
            max-width: 480px;
        }

        .goodrx-logo-circle {
            max-width: 290px;
        }

    }

    @media (max-width: 991px) {
        #gehaPage .graphicImagePeople img {
            width: 100%;
            max-width: 100%;
        }

        .goodrx-logo-circle {
            max-width: 238px;
        }

        #gehaPage .geha-banner-text-section p.prpt {
            left: 66px;
            margin-top: -5px;
            font-size: 14px;
        }

        #gehaPage .productGripgSection {
            padding: 15px;
        }

        #gehaPage .productGripgSection h3 {
            font-size: 30px;
            margin-bottom: 0;
        }

        #gehaPage .productGripgSection li {
            font-weight: 300;
            min-height: 60px;
        }

        #gehaPage .productGripgSection ul {
            margin-bottom: 20px;
        }

        #gehaPage .productGripgSection li {
            line-height: 1.4;
            display: flex;
            align-items: center;
        }
    }

    @media (max-width: 767px) {
        #gehaPage .gehaPageBanner .rowMbt {
            justify-content: center;
        }

        #gehaPage .geha-banner-text-section-parent {
            width: 100%;
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
            font-size: 16px;
            padding: 10px 11px;
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
            right: 0;
            top: -198px;
            max-width: 188px;
            left: 0;
            max-height: 198px;
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

        section.shopLanderPageHader .pageheaderTop p br {
            display: none;
        }

        #gehaPage .gehaPageBanner {
            margin-top: 5px;
        }

        .px2 {
            padding-left: 5px;
            padding-right: 5px;
        }

        .benefit-hub .mobile-responsie {
            /* max-width: 150px; */
            justify-content: center;
            padding: 10px 0px 20px;
        }

        #gehaPage .seeDiscountBtn button,
        #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .discount-button-product .btn-primary-blue {
            font-size: 16px;
            display: block;
            width: 100%;
            max-width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .child-4 .product-selection-box img,
        .child-0 .product-selection-box img,
        .child-5 .product-selection-box img,
        .child-6 .product-selection-box img {
            max-width: 100% !important;
            min-width: inherit;
        }




        .whitening-teeth-girl-with-smile.col-sm-8.graphicImagePeople {
            display: none;
        }

        #gehaPage .gehaPageBanner {
            padding-bottom: 20px;
        }

        #gehaPage .geha-banner-text-section h2 {
            font-size: 20px;
            line-height: 1.3;
        }

        #product-list.productLandingPageContainer span.product-selection-price-text del bdi,
        #product-list.productLandingPageContainer span.product-selection-price-text .wasText,
        #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount,
        #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount,
        #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount bdi,
        #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount bdi,
        #product-list.productLandingPageContainer .medium-12 .product-selection-price-text,
        #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text {
            font-size: 22px;
        }

        .disclaimer-bar-purple {
            padding-left: 15px;
            padding-right: 15px;
        }

    }

    .flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .m0 {
        margin: 0px;
    }

    .postLoggedin {
        /* display: none; */
    }


    .disclaimer-bar-purple.bgColor {
        /* background-image: linear-gradient(to bottom, #450976, #613387); */
    }


    .logged-in .postLoggedin {
        /* display: block; */
    }


    @media(max-width:1200px) {
        .child-4 .product-selection-box .product-selection-description b {
            /* font-size: 25px !important; */
        }

        .child-4 .product-selection-box img,
        .child-0 .product-selection-box img,
        .child-5 .product-selection-box img,
        .child-6 .product-selection-box img {
            /* max-width: 100% !important;
            min-width: 300px; */
        }

        .child-0 .vc_column-inner,
        .child-4 .vc_column-inner,
        .child-5 .vc_column-inner,
        .child-6 .vc_column-inner {
            /* width: 100% !important;
            position: relative;
            left: unset !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important; */
        }

        .child-0 {
            /* margin-top: 2rem; */
        }
    }

    @media screen and (min-width: 768px) {
        .child-4 #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
            max-width: 100% !important;
            min-width: 300px;
        }
    }

    @media screen and (max-width: 900px) {
        .pageHeader img {
            max-width: 150px
        }
    }

    @media(max-width:800px) {
        /* .child-0 .vc_column-inner,
        .child-4 .vc_column-inner,
        .child-5 .vc_column-inner,
        .child-6 .vc_column-inner
        {
            width: 100% !important;
            position: relative;
            left: unset !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        } */

        .child-4 .product-selection-box,
        .child-5 .product-selection-box,
        .child-6 .product-selection-box,
        .child-0 .product-selection-box {
            flex-direction: column;
        }

        .child-4 .product-selection-description-parent,
        .child-0 .product-selection-description-parent,
        .child-5 .product-selection-description-parent,
        .child-6 .product-selection-description-parent {
            /* max-width: 100% !important; */
            justify-content: center;
        }
    }


    body .smtext {
        position: relative;
        /* padding-left: 7rem; */
    }

    body .prpt {
        /* padding-left: 5rem; */
    }



    .cnfimg {
        max-width: 240px;
        width: 100%;
    }

    .col-sm-12.tp-head-form {
        max-width: 620px;
        margin: auto;
        padding-bottom: 30px;
    }

    .col-sm-12.tp-head-form h5 {
        text-align: left;
        margin: 0;
    }

    span.weight-lower-mbt {
        font-weight: 400;
    }


    .access-code-no-added {
        display: none;
    }

    .max-238 {
        max-width: 238px;
    }

    .li-tpt h1 {
        padding-left: 10px;
    }

    .whitening-teeth-girl-with-smile .li-tpt p {
        line-height: 1.4;
    }

    @media (max-width: 767px) and (orientation: landscape) {
        .primary-head-image img {
            max-width: 100%;
        }

        .goodrx-logo-circle {
            max-width: 235px;
        }

        #gehaPage .geha-banner-text-section p.prpt {
            left: 73px;
            margin-top: -4px;
            font-size: 14px;
        }

        #gehaPage .seeDiscountBtn button {
            font-size: 14px;
        }

        #gehaPage section.ourCustomers h2 {
            font-size: 32px;
        }

        #gehaPage section.ourCustomers h3 {
            font-size: 18px;
        }

        .col-sm-12.tp-head-form h5 {
            text-align: left;
            margin: 0;
        }

        #gehaPage .productGripgSection h3 {
            font-size: 29px;
        }
    }

    @media(max-width:1024px) {

        #gehaPage .geha-banner-text-section-parent,
        #gehaPage .graphicImagePeople {
            width: 50%;
        }

        body .smtext,
        body .prpt {
            padding-left: 0pt;
        }

        body .smtext h2 {
            margin-top: 0px !important;
            font-size: 18px !important;
        }
    }

    .goodrx-text{
        margin: 0;
    font-size: 84px;
    color: #000;
    line-height: 1;
    }

    .k-weight-bold{
        font-family: 'kaleko_105_boldbold';
    }
    .k-book-font{
        /* font-family: 'kaleko_105book'; */
        font-family: 'kaleko_105light';
    }
    span.small-text--goodrx {
    font-size: 80%;
}

    @media(max-width:767px) {
        #gehaPage .productGripgSection li {
            min-height: 38px;
        }

        #gehaPage .geha-banner-text-section p.prpt {
            position: static;
            text-align: center;
            padding-bottom: 11px;
        }

        span.exclusive-text-mbt {
            position: static
        }

        .smtext-inr {
            margin-top: 12px;
        }

        #gehaPage .productGripgSection li {
            min-height: 28px;
        }

        #gehaPage section.ourCustomers h2 {
            padding-top: 14px;
        }

        #gehaPage h1.gehaLogoLarge img {
            max-width: 158px;
        }

        #gehaPage .form-steps h5 {
            margin-bottom: 0px;
            font-size: 16px;
            text-align: left;
        }

        #gehaPage .gehanFormSection .seeDiscountBtn #send-my-discount_partner {
            min-width: inherit;
        }

        .goodrx-text{
            font-size: 62px;
         }

    }

    @media(max-width:576px) {
        body .smtext {
            padding-left: 0rem;
        }

        .col-sm-12.tp-head-form h5 {
            text-align: center;
            padding-right: 0rem;
        }

        .dflex-option .form-group {
            width: 50%;
            justify-content: start;
            text-align: left;
        }

        /* .whitening-teeth-girl-with-smile.col-sm-8.graphicImagePeople {
            display: none;
        } */

        #gehaPage .geha-banner-text-section-parent,
        #gehaPage .graphicImagePeople {
            width: 100%;
        }
    }

    @media(max-width:480px) {
        .checlbxooption .form-group {
            width: 100%;
        }

        .checlbxooption .form-group label {
            font-size: 15px !important;
        }

        .product-of-intestest.col-md-12 h6 {
            text-align: left;
        }

        .shopLanderPageHader .whitening-teeth-girl-with-smile.hidden-mobile {
            /* position: relative !important;
            top: unset !important;
            right: unset !important; */

        }

        .shopLanderPageHader .whitening-teeth-girl-with-smile.hidden-mobile img {
            /* max-width: 283px;
            margin-bottom: -25px; */
        }

        .pageheaderTop {
            overflow: hidden;
        }

        .mobile-responsie img {
            max-width: 300px !important;
        }

        #gehaPage .mt-100 {
            padding-top: 0px;
        }

        .geha-banner-text-section img {
            max-width: 238px;
        }

        #gehaPage .geha-banner-text-section h2 {
            padding: 20px 0px 0px;
            font-size: 20px !important;
        }

        section.shopLanderPageHader .pageheaderTop p {
            font-size: 16px;
            margin-bottom: 1rem;
            line-height: 22px;
        }

        .align-items-center.mobile-responsie {
            flex-direction: column;
        }

        .registeded-btn-stp .stip-sttpp {
            font-size: 16px;
        }

        #gehaPage section.shopLanderPageHader .pageheaderTop h1 {
            font-size: 26px !important;
        }

        section.shopLanderPageHader .pageheaderTop h1,
        section.shopLanderPageHader .pageheaderTop h1 span {
            font-size: 26px !important;
        }

        #gehaPage .geha-banner-text-section h2 {
            font-size: 20px;
            line-height: 1.3;
            padding: 5px 0px;
            padding-left: 0px !important;
            margin-top: 0px !important;



        }

        section.shopLanderPageHader .pageheaderTop p {
            font-size: 16px;
        }

    }

    .whitening-teeth-girl-with-smile.hidden-mobile {
        /* display: block !important; */

    }


    p.disclaimer-text {
        color: #0c2242;
        font-size: 14px;
        text-align: center;
        margin-top: 3rem;
        font-style: italic;
        font-weight: 300;
        display: none;
    }
 

</style>


<div class="gehaTemplate active-recomendation-tab" id="gehaPage">



    <?php

    if ($goodrxFlag) {
        $page_id = GOOD_RX_REC_PAGE_ID; // Replace 123 with the ID of the page you want to retrieve
        $page = get_post($page_id);
        if ($page) {
            ?>
            <style>
                body {
                    overflow-x: hidden;
                }

                #gehaPage section.shopLanderPageHader .pageheaderTop:before {
                    top: 0;
                    background-size: auto;
                }

                #gehaPage .productLandingPageContainer span.product-selection-price-text.hoo,
                #gehaPage .productLandingPageContainer span.product-selection-price-text.heee {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                }

                #gehaPage #product-list.productLandingPageContainer span.product-selection-price-text del:before {
                    height: 2px;
                    background: #f8a18a;
                    top: 50% !important;
                    left: -3px;
                    right: 0;
                    margin-top: -1px;
                    width: 106%;
                }

                #gehaPage .medium-3 .product-selection-price-text-top.noflexDiv {

                    line-height: 1;
                }
                #gehaPage .section-post-purchase-section .rowMbt{
                    justify-content: center;
                }
                .section-post-purchase-section .mouth-guards-banner{
                    left: 71px;top: 0;
                }
                .section-post-purchase-section .electric-tooth-brush-banner{
                    top: 28px;
                     right: -28px;    height: 130%;
                }
                #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
                        background-color: #fae64f2b !important;
                    }







                    
                @media (min-width: 768px) {
                    #product-list.productLandingPageContainer .product-selection-price-text-top {
                        min-width: 220px;
                    }

                    #gehaPage section.shopLanderPageHader .pageheaderTop {
                        margin-top: 73px;
                        margin-top: 10px;
                    }
                }

                @media (max-width: 896px) and (orientation: landscape) {
                    #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
                        top: -18px;
                    }

                    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
                        max-width: 100%;
                    }

                    #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
                        max-width: 300px;
                    }

                    #product-list:not(.grid-changed) .medium-3 .product-selection-image-wrap {
                        min-height: 220px;
                    }

                    #product-list:not(.grid-changed) .medium-6 .product-selection-image-wrap {
                        min-height: 232px;
                        max-width: 300px;
                        max-height: 260px;
                    }

                    #product-list.productLandingPageContainer:not(.grid-changed) .medium-8~.medium-4.landing-product .product-selection-description-parent {
                        min-height: 170px;
                        max-height: 170px;
                    }

                    #product-list:not(.grid-changed) .medium-6 .product-selection-image-wrap {
                        min-height: 260px;

                    }

                    #product-list.productLandingPageContainer span.product-selection-price-text del bdi,
                    #product-list.productLandingPageContainer span.product-selection-price-text .wasText,
                    #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount,
                    #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount,
                    #product-list.productLandingPageContainer .medium-8.landing-product .woocommerce-Price-amount.amount bdi,
                    #product-list .medium-4.landing-product.child-5 .woocommerce-Price-amount.amount bdi,
                    #product-list.productLandingPageContainer .medium-12 .product-selection-price-text,
                    #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text {
                        font-size: 22px;
                    }

                    #product-list:not(.grid-changed) span.woocommerce-Price-amount.amount {
                        font-size: 22px;
                    }

                    #gehaPage #product-list.grid-changed .product-selection-price-wrap button.btn {
                        min-width: 131px;
                    }

                    .active-recomendation-tab #product-list.grid-changed .landing-product.medium-3 .product-selection-description-parent,
                    #product-list.productLandingPageContainer .medium-4.landing-product .product-selection-description-parent {
                        min-height: 130px;
                        max-height: 130px;
                    }

                    #gehaPage #product-list.grid-changed .medium-12 .product-selection-description b {
                        font-size: 12px;
                    }

                    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
                        max-width: none;
                    }

                    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
                        font-size: 14px;
                    }

                    #product-list.grid-changed .medium-6 .product-selection-image-wrap,
                    #product-list.grid-changed .medium-3 .product-selection-image-wrap,
                    #product-list.grid-changed .medium-9 .product-selection-image-wrap,
                    #product-list.grid-changed .medium-4 .product-selection-image-wrap,
                    #product-list.grid-changed .medium-12 .product-selection-image-wrap,
                    #product-list.grid-changed .medium-9 .product-selection-image-wrap {
                        min-height: 295px;
                        max-height: 295px;
                    }

                    #product-list.productLandingPageContainer .product-selection-price-text-top {
                        min-width: initial;
                    }

                    #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
                        font-size: 14px;
                    }

                    #product-list.productLandingPageContainer .medium-12 .product-selection-description b {
                        font-size: 24px;

                    }

                    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
                        max-width: 401px;
                    }

                    #gehaPage #product-list.productLandingPageContainer span.product-selection-price-text del:before {
                        margin-top: 2px;
                    }

                }

                @media (max-width: 767px) {
                    .header-spacer {
                        height: 44px !important;
                    }
                }



                @media screen and (min-width: 2400px) and (max-width: 3000px) {
        #gehaPage .section-post-purchase-section .geha-banner-text-section h2 {
            /* color: green !important; */
        }

        .section-post-purchase-section .electric-tooth-brush-banner {
            top: -3px;
            right: -4%;
            height: 171%;
        }
        .section-post-purchase-section .mouth-guards-banner{
            left: 274px;
        }
    }

    @media (max-width: 1700px) {
        .section-post-purchase-section .electric-tooth-brush-banner {
            height: 110%;
        }
    }

    @media (max-width: 1500px) {
        .section-post-purchase-section .electric-tooth-brush-banner {
            height: 100%;
            top: 42px;
            right: -100px;
        }

        .section-post-purchase-section  .mouth-guards-banner {
            left: -27px;
            width: 469px;
            height: 447px;
        }
    }


    @media (max-width: 1300px) {
        .section-post-purchase-section .electric-tooth-brush-banner {
            height: 100%;
                top: 60px;
                right: -13%;
        }

        .section-post-purchase-section  .mouth-guards-banner {
            width: 401px;
            height: 491px;
            left: -52px;
            top: 19px;
        }

        #gehaPage .section-post-purchase-section .geha-banner-text-section h2 {
            font-size: 22px;
        }
    }

    @media (max-width: 1024px) {
        .section-post-purchase-section .mouth-guards-banner {
            width: 358px;
            height: 250px;
            left: -77px;
            top: 31px;
        }
        .section-post-purchase-section .electric-tooth-brush-banner {
            right: -21%;
        }
        #gehaPage .geha-banner-text-section-parent{
                width: 100% !important;

       }
       .geha-banner-text-section  .smtext {
            max-width: 334px;
            margin-left: auto;
            margin-right: auto;
        }


}
        @media (max-width: 767px) {
            .section-post-purchase-section .geha-banner-text-section img{
                max-width: 274px;
            }
            .section-post-purchase-section .mouth-guards-banner {
                position: static;
                width: 368px;
                 height: 281px;margin-left: auto;
    margin-right: auto;    order: 2;    margin-top: -61px;
            }
            .smtext-inr{    max-width: 300px;
    margin-left: auto;
    margin-right: auto;
            }
            #gehaPage .gehaPageBanner.section-post-purchase-section{
                padding-top: 52px;
                display: flex;
                align-items: center;
                flex-direction: column;
            }
            #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
    background-color: transparent !important;
}

        }



            </style>
            <section class="shopLanderPageHader benefit-hub">

                <div class="pageHeader">

                    <div class="whitening-teeth-girl-with-smile mobileOptionDisplay show-mobile">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/homepage_hero"
                            alt="homepage hero mobile"
                            data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/homepage_hero"
                            decoding="async" class="lazyload">
                    </div>


                    <section class="gehaPageBanner section-post-purchase-section">
                        <div class="mouth-guards-banner"
                            style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/mouth-gard-package.png)">
                        </div>
                        <div class="container">
                            <div class="rowMbt">
                                <div class="col-sm-4 geha-banner-text-section-parent">
                                    <div class="geha-banner-text-section  mt-100">
                                        <p class="font-mont text-white prpt">EXCLUSIVE</p>
                                        <h1 class="goodrx-text"><strong class="k-weight-bold">Good</strong><span class="k-book-font">R<span class="small-text--goodrx">X</span></span></h1>
                                        <!-- <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/goodrx-logo.png"
                                            alt="One Dental" class="goodrx-logo-circle" /> -->
                                        <div class="smtext">
                                            <div class="smtext-inr">
                                                <h2 class="font-mont fw-normal">
                                                <span class="weight-lower-mbt">
                                                    Discounts and special offers
                                                    available to readers &
                                                    members.</span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="electric-tooth-brush-banner"
                            style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images//sales-landers/2024/goodRx/electric-tooth-brush-package.png">
                        </div>
                    </section>

                    <div class="pageheaderBotm">

                        <div class="row no-flex">

                            <div class="flex-row">

                                <div class="filterproductsOption">

                                    <select id="filter_products">
                                        <option value="all">All products</option>
                                        <option value="Bundle &amp; Save">Bundle &amp; Save</option>
                                        <option value="Featured!">Featured!</option>
                                        <option value="Low Stock">Low Stock</option>
                                    </select>

                                </div>



                                <div class="all-product-dropdown">

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
                    <div class="mouth-guards-banner"
                        style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/goodrx-mouth-guard.png)">
                    </div>
                    <div class="container">
                        <div class="rowMbt">
                            <div class="col-sm-4 geha-banner-text-section-parent">
                                <div class="geha-banner-text-section  mt-100">
                                <p class="font-mont text-white prpt">EXCLUSIVE</p>
                                        <h1 class="goodrx-text"><strong class="k-weight-bold">Good</strong><span class="k-book-font">R<span class="small-text--goodrx">X</span></span></h1>

                                    <!-- <p class="font-mont text-white prpt">PRODUCT
                                        PARTNER OF</p>
                                    <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/goodrx-logo.png"
                                        alt="One Dental" class="goodrx-logo-circle" /> -->
                                    <div class="smtext">
                                        <div class="smtext-inr">
                                            <h2 class="font-mont fw-normal">
                                                <span class="weight-lower-mbt">
                                                    Discounts and special offers
                                                    available to readers &
                                                    members.</span>
                                            </h2>
                                            <div class="seeDiscountBtn">
                                                <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE
                                                    YOUR DISCOUNTS</button>
                                            </div>
                                            <div class="gehaLoginCustomer">
                                                <h3 class="font-mont">ALREADY REGISTERED? <a href="/my-account/"
                                                        class="onpreColor onpostColor">Login</a> </h3>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>


                            <div class="whitening-teeth-girl-with-smile col-sm-8 graphicImagePeople">
                                <div class="primary-head-image">
                                    <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/goodrx-sale-lander/complete-control.png"
                                        alt=""
                                        data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/goodrx-sale-lander/complete-control.png"
                                        decoding="async" class="lazyload"> -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="electric-tooth-brush-banner"
                        style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images//sales-landers/2024/goodRx/goodrx-electric-tooth-brush.png">
                    </div>
                </section>

                <section class="sectionProductDisplay">
                    <div class="container">
                        <div class="rowMbt">
                            <div class="col splitTwo productGripgSectionWrapper">
                                <div class="productGripgSection">
                                    <h3 class="font-mont text-white text-center">SAVE UP TO 50%</h3>
                                    <ul class="font-mont text-white">
                                        <li>Electric Toothbrushes & Water Flossers</li>
                                        <li>Professional Teeth Whitening Trays</li>
                                        <li>Custom-fitted Night Guards</li>
                                        <li>Solutions for Sensitive Teeth</li>
                                        <li>Solutions for Bad Breath</li>
                                    </ul>
                                    <div class="seeDiscountBtn text-center">
                                        <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR
                                            DISCOUNTS</button>
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
                                    <h4 class="font-mont mb-0 text-white text-center"> <span
                                            style="color:#62b1f4">HSA</span> &
                                        <span style="color:#66d55f">FSA</span> ELIGIBLE
                                    </h4>
                                    <p class="font-mont mb-0 text-white">Use your HSA or FSA account on eligible products
                                    </p>
                                </div>

                            </div>
                            <div class="colhLogoSec splitTwo">
                                <div class="logoesSecHfa">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/HSA.svg" alt=""
                                        class="" />
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/FSA.svg" alt=""
                                        class="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="ourCustomers">
                    <div class="container text-center">
                        <h2 class="font-mont" style="color:#0b4c6c;">OUR CUSTOMERS SPEAK FOR US</h2>
                        <h3>Over <span style="color:#0f56a6">1 million happy customers</span> have relied on Smile Brilliant
                            to<br>
                            improve their oral health & create a beautiful white smile!</h3>

                        <div class="customer-before-after-image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/our-customer-banner-image.webp"
                                alt="" class="" />
                        </div>

                        <div class="seeDiscountBtn text-center">
                            <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR
                                DISCOUNTS</button>
                        </div>

                    </div>
                </section>



                <section class="section-two blue-section blusc1">
                    <div class="section-header dark-blue text-center" style="display: none;">
                        <div class="container">
                            <h1 class="mb-0 text-white">America’s #1 Custom Night Guard. Delivered to Your Door.</h1>
                        </div>

                    </div>
                    <div class="section-body   light-blue clients-logoes text-center">
                        <div class="container" style>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/stars-lrge.png"
                                alt="" class="stars" style="display:none;" />
                            <div class="beneth-starts-rating" style="display:none;">
                                Nearly <i>1 million happy customers...</i> growing!
                            </div>
                            <div class="d-flex align-items-center justify-content-center logoes-strip-mbt mulimages">
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/health-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/forbes-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/fox-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/new-york-post-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/sleep-foundation-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/clnet-icon-transparent.png"
                                        alt="" />
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/night-guards/allure-icon-transparent.png"
                                        alt="" />
                                </span>

                            </div>
                        </div>
                    </div>
                </section>


                <!-- hidden section -->
                <section
                    class="ourSuportedCustomers product-logo-wrapper bg-sky-500 smilePageIconSection smilePageIconSection-parent-div  "
                    style="display:none;">
                    <div class="hidden-mobile">
                        <div class="container">
                            <div class="rowMbt extra_logo_before-top logo-strip-one justify-conten">
                                <div class="boxSecBox box-with-extra-logo spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-health.png"
                                        alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-forbes.png"
                                        alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-fox.png"
                                        alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-new-work-post.png"
                                        alt="" class="" />
                                </div>
                            </div>

                            <div
                                class="rowMbt second-row extra_logo_before extra_logo_after_small logo-strip-two justify-conten">
                                <div class="medium-3 boxSecBox spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-circle.png"
                                        alt="" class="" />
                                </div>
                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-client.png"
                                        alt="" class="" />
                                </div>

                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-the-knot.png"
                                        alt="" class="" />
                                </div>
                                <div
                                    class="medium-3 col-md-3 col-4 boxSecBox box-with-extra-logo-right wpb_column columns medium-3 thb-dark-column small-12">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-allure.png"
                                        alt="" class="" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container show-mobile logoesformobileOnly">
                        <div class="rowMbt  justify-conten alin-items-center">
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-tiktok.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-health.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-forbes.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-fox.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-new-work-post.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-circle.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-client.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-the-knot.png"
                                    alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/geha-page/logoes-allure.png"
                                    alt="" class="" />
                            </div>

                        </div>
                    </div>



                </section>

                <section class="warrantysectionPage">
                    <div class="row wpb_row row-fluid year-wrannanty-container">
                        <div class="wpb_column columns medium-12 thb-dark-column small-12">
                            <div class="vc_column-inner   ">
                                <div class="wpb_wrapper">
                                    <div
                                        class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated text-center">

                                        <figure class="wpb_wrapper vc_figure">
                                            <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="150"
                                                    height="150"
                                                    src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-150x150.png"
                                                    class="vc_single_image-img attachment-thumbnail" alt="" loading="lazy"
                                                    srcset="https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-150x150.png 150w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-100x100.png 100w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/100percent-guarantee-logo-20x20.png 20w"
                                                    sizes="(max-width: 150px) 100vw, 150px"></div>
                                        </figure>
                                    </div>

                                    <div
                                        class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_fadeIn fadeIn vc_custom_1596013369071 wpb_start_animation animated text-center">

                                        <figure class="wpb_wrapper vc_figure">
                                            <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="300"
                                                    height="66"
                                                    src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-300x66.png"
                                                    class="vc_single_image-img attachment-medium" alt="" loading="lazy"
                                                    srcset="https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-300x66.png 300w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-190x42.png 190w, https://www.smilebrilliant.com/wp-content/uploads/2020/07/google-trusted-store-20x4.png 20w"
                                                    sizes="(max-width: 300px) 100vw, 300px"></div>
                                        </figure>
                                    </div>
                                    <h3 style="text-align: center" class="vc_custom_heading">TRY IT. <span
                                            style="color:#0b4c6c;">LOVE IT</span> ...or return it</h3>
                                    <div class="vc_wp_text wpb_content_element warrabty-text-container">
                                        <div class="widget widget_text">
                                            <div class="textwidget">
                                                <p>Smile Brilliant is America's #1 brand of customized oral care products
                                                    and a
                                                    proud partner of GoodRx Insurance. All GoodRx clients, their
                                                    children, domestic
                                                    partners, spouses, parents, and grand parents are eligible for exclusive
                                                    discounts
                                                    on professional teeth whitening, night guards, toothbrushes and oral
                                                    care
                                                    products. Everything we offer comes with a money back guarantee. Simply
                                                    register
                                                    and begin receiving your savings!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vc_wp_text wpb_content_element order-the-system-cnt">
                                        <div class="widget widget_text">
                                            <div class="textwidget">
                                                <h3 class="itsSimpleHeading">ITS THAT SIMPLE</h3>
                                                <div class="seeDiscountBtn text-center">
                                                    <button class="btn btn-primary-blue btn-lg scroll-link"
                                                        href="#gehaform">SEE GOODRX DISCOUNTS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="gehanFormSection bg-blue-200" id="gehaform">
                    <div class="container">
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <div class="container-form">
                            <form id="geha_discount_registration_form" method="post">
                                <div class="row form-steps fullWidth">
                                    <div class="col-sm-12 tp-head-form">

                                        <div class="flex-item-wrap">
                                            <div class="logo">
                                                <h1 class="gehaLogoLarge">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/goodrx-logo.png"
                                                        alt="" class="cnfimg" />


                                                </h1>
                                            </div>
                                            <h5 class="font-mont discount-registeration-form">DISCOUNT REGISTRATION FORM
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="first_name" class="control-label">First Name</label>
                                        <input name="first_name" type="text" id="entryFastName" value=""
                                            placeholder="First Name" class="form-control input-lg">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="last_name" class="control-label">Last Name</label>
                                        <input name="last_name" type="text" id="entryLastName" value=""
                                            placeholder="Last Name" class="form-control input-lg">
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label for="email" class="control-label">Email Address</label>
                                        <input type="email" id="entryEmail" value="" placeholder="Email Address"
                                            name="email" class="form-control input-lg">
                                    </div>
                                    <div class="product-of-intestest col-md-12">
                                        <h6>Products of Interest <span class="fw-normal"><i>(optional)</i></span></h6>
                                        <div class="checlbxooption">
                                            <div class="dflex-option">
                                                <div class="form-group">
                                                    <input type="checkbox" id="Teeth-Whitening" name="products[]"
                                                        value="teeth whitening">
                                                    <label for="Teeth-Whitening">Teeth Whitening</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Night Guards" name="products[]"
                                                        value="night guard">
                                                    <label for="Night Guards">Night Guards</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Electric-Toothbrush" name="products[]"
                                                        value="electric toothbrush">
                                                    <label for="Electric-Toothbrush">Electric Toothbrush</label>
                                                </div>
                                            </div>
                                            <div class="dflex-option">
                                                <div class="form-group">
                                                    <input type="checkbox" id="Water-Flosser" name="products[]"
                                                        value="water flosser">
                                                    <label for="Water-Flosser">Water Flosser</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Athletic-Mouth-Guard" name="products[]"
                                                        value="athletic mouth guard">
                                                    <label for="Athletic-Mouth-Guard">Athletic Mouth Guard</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Bad-Breath" name="products[]"
                                                        value="bad breath">
                                                    <label for="Bad-Breath">Bad Breath</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="source" value="goodrx">
                                    <input type="hidden" name="action" value="add_partner_user">
                                    <!-- <div class="product-of-intestest col-md-12">
                                        <h6>Products of Interest <span class="fw-normal"><i>(optional)</i></span></h6>
                                        <div class="checlbxooption">
                                            <div class="dflex-option">
                                                <div class="form-group">
                                                    <input type="checkbox" id="Teeth-Whitening">
                                                    <label for="Teeth-Whitening">Teeth Whitening</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Night Guards">
                                                    <label for="Night Guards">Night Guards</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Electric-Toothbrush">
                                                    <label for="Electric-Toothbrush">Electric Toothbrush</label>
                                                </div>
                                            </div>
                                            <div class="dflex-option">
                                                <div class="form-group">
                                                    <input type="checkbox" id="Water-Flosser">
                                                    <label for="Water-Flosser">Water Flosser</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Athletic-Mouth-Guard">
                                                    <label for="Athletic-Mouth-Guard">Athletic Mouth Guard</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" id="Bad-Breath">
                                                    <label for="Bad-Breath">Bad Breath</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-12 text-center form-notes">
                                        <p class="disclaimer-text-small">By registering you will be able to bypass this page
                                            on future
                                            visits and view GoodRx exclusive discounts so long as we recognize your devise
                                            or you’re logged in to your Smile Brilliant account.</p>
                                    </div>

                                    <div class="col-md-12 sep-top-sm text-center seeDiscountBtn text-center">
                                        <button type="submit"
                                            class="btn btn-primary btn-primary-purple-drk btn-primary-geha"
                                            id="send-my-discount_partner">REGISTER</button>
                                        <div id="register-loader" class="loader"></div>
                                    </div>

                                    <div class="gehaLoginCustomer w-100 text-center">
                                        <div class="registeded-btn-stp">
                                            <h3 class="font-mont">ALREADY REGISTERED? <a href="/my-account/">Login</a> </h3>
                                            <!-- <div class="stip-sttpp">
                                                or <a href="javascript:;" id="skipPartner">skip</a>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>

                            </form>

                            <p class="disclaimer-text">
                                DISCLAIMER: These benefits are neither offered nor guaranteed under contract with the FEHB
                                or FEDVIP Programs, but are made available to all Enrollees who become members of GoodRx and
                                their eligible family members.
                            </p>

                            <div class="row after-success" style="display: none;">
                                <h1 class="font-mont text-white">YOUR DISCOUNT CODE HAS BEEN GENERATED!
                                </h1>
                                <p class="text-white">Your unique GoodRx code has been created and is listed below (it has
                                    also been sent to you
                                    via email).<b>To order, begin the checkout process, click the "Enter Gift Code," and
                                        enter this
                                        code below to receive 20% off sitewide!</b></p>


                                <div id="geha-coupon-code-box">
                                    GEAZVHBVVB</div>

                                <p class="text-white">
                                    As always, our customer support representatives are here to help. Feel free to call,
                                    email, or
                                    use our live chat feature to connect with our team!</p>
                            </div>
                        </div>
                    </div>



                </section>

            <?php } ?>

        </div>
    </div>





    <?php
    // Start the loop
    while (have_posts()):
        the_post();

        // Display page content
        echo apply_filters('the_content', get_the_content());

    endwhile; // End of the loop.
    ?>




    <?php if ($goodrxFlag) {
        echo '<style>.footer {padding: 0px 0;}</style>
                    <div class="disclaimer-bar-purple bgColor">
                    <div class="container">
                     <p class="postLoggedin text-white">“<strong>DISCLAIMER:</strong> In order to recieve GoodRx  exclusive pricing you must add to cart from this page.</i></p>
                    </div>
                    </div>';
    }
    ?>



</div>
<div class="popupGehaContainer">
    <div class="modal">
        <div class="modal-content">
            <div class="popupHeader">
                <span class="close-button">×</span>
            </div>
            <div class="popupBodyContent text-center">
                <h1 class="gehaTextmember">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales-landers/2024/goodRx/goodrx-logo.png"
                        alt="GoodRx" class="goodrx-logo-circle" />

                </h1>
                <p class="memeberGranted">MEMBER DISCOUNT ACCESS GRANTED</p>
                <h2 class="youreInText">YOU’RE IN!</h2>
                <h3 class="pleaseRed">please read:</h3>
                <p class="descriptionBody">Welcome GoodRx member! You now have access to give your exclusive
                    GoodRx discounts. An email has also been sent to you with your account login details. To view
                    your discounts in the future, simply login. Our live chat and customer support team is also here to
                    help!<br><br>
                    <strong>CLICK THE BUTTON BELOW TO VIEW THE DISCOUNT PAGE</strong>
                </p>
                <div class=" sep-top-sm text-center seeDiscountBtn text-center">
                    <a href="<?php echo site_url('goodrx?user=yes'); ?>" class="btn">SEE DISCOUNT PAGE</a>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

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


        jQuery('#product-list').children().each(function (index) {
            jQuery(this).addClass('child-' + index);
        });

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

                } else {

                    str += '<option value="' + attr_val + '">' + attr_val + '</option>';

                }



            });

            jQuery('#filter_products').html(str);

        }, 500);





    });


    function show_hide_div_by_tag(tag_val) {

        if (tag_val == 'all') {

            jQuery('.landing-product').show();



        } else {

            jQuery(document).find('.landing-product').each(function () {

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
        landing_products.sort(function (a, b) {
            return $(a).data(attr) - $(b).data(attr)
        });
        product_list.append(landing_products);
    }

    function sortDesc(attr) {
        product_list.empty(attr);
        landing_products.sort(function (a, b) {
            return $(b).data(attr) - $(a).data(attr)
        });
        product_list.append(landing_products);
    }

    jQuery(document).ready(function () {
        jQuery('#resetButton').click(function () {
            jQuery('#filter_products').val('all');
            jQuery('#price-sort').val('default');
            jQuery('#filter_products').trigger('change');
            jQuery('#price-sort').trigger('change');

        })
    });
</script>

<script>
    jQuery(document).ready(function () {

        jQuery('#product-list').children().each(function (index) {
            jQuery(this).addClass('child-' + index);
        });

        // add a click event listener to all links with the class "scroll-link"
        jQuery(".scroll-link").on("click", function (event) {
            event.preventDefault(); // prevent default link behavior
            var target = jQuery(this).attr("href"); // get the target div ID from the link href attribute
            var offset = jQuery(target).offset().top - 100; // get the target div offset from the top of the page
            jQuery("html, body").animate({
                scrollTop: offset
            }, 1000); // animate the scroll to the target div
        });
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
        if (!jQuery(event.target).closest('.product-selection-description-parent-inner').length) {
            jQuery('.openPackage-quantity').removeClass('openPackage-quantity');
        }
    });

    jQuery('.lander-shortcode').each(function () {
        jQuery(this).parents('.wpb_column').addClass('landing-product');

    });




    jQuery(document).on("change", ".quantity", function () {
        console.log('changed-val');
        selected_product_id = jQuery(this).attr('data-pid');
        console.log(jQuery(this).val());
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-product_id', selected_product_id);
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('href', '?add-to-cart=' + selected_product_id);
        jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-quantity', jQuery(this).val());
    })

    // $(document).ready(function() {
    // jQuery(".selectquantitybtn").click(function(){
    jQuery(document).on('click', '.selectquantitybtn', function () {
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
    jQuery(document).on('click', '.plus-btn', function () {
        var quantity = $(this).parents('.product-selection-box').find('.box').find('.quantity');
        quantity.val(parseFloat(quantity.val()) + 1).trigger('change');
        updatePrice($(this).parents('.product-selection-box').find('.box'));
    });

    //  $('.minus-btn').click(function() {
    jQuery(document).on('click', '.minus-btn', function () {
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


    jQuery(document).ready(function () {

        if (jQuery('#quick_cart .float_count').text() == '0' || jQuery('#quick_cart .float_count').text() == 0) {
            jQuery('#quick_cart').hide();
        }
    });
    jQuery(document).ajaxComplete(function (event, xhr, settings) {
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
    // var closeButton = document.querySelector(".close-button");

    function toggleModal() {
        modal.classList.toggle("show-modal");
    }

    function windowOnClick(event) {
        if (event.target === modal) {
            show();
        }
    }

    // closeButton.addEventListener("click", toggleModal);
    window.addEventListener("click", windowOnClick);


    jQuery(document).on('click', '#skipPartner', function (e) {

        setCookiePartner('goodrxOneTime', 'yes', 200, '/');
        location.reload();
    });

    // Function to set a cookie
    function setCookiePartner(name, value, days, path) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        var cookiePath = path ? "; path=" + path : "";
        document.cookie = name + "=" + value + expires + cookiePath;
    }

    jQuery(document).on('click', '#send-my-discount_partner', function (e) {
        e.preventDefault();
        hasserror = false;
        jQuery('#geha_discount_registration_form input').each(function () {
            if (jQuery(this).val() == '') {
                jQuery(this).addClass('has_error');
                hasserror = true;
            } else {
                jQuery(this).removeClass('has_error');
            }
        });
        if (hasserror) {
            jQuery('#register-loader').hide();
            return false;
        }
        jQuery('#register-loader').show();
        var data_ajax = jQuery('#geha_discount_registration_form').serialize();
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: ajaxurl,
            data: data_ajax,
            success: function (response) {
                jQuery('#register-loader').hide();
                if (response.status == true) {
                    jQuery('#geha_discount_registration_form').hide();
                    setCookiePartner('goodrxOneTime', 'yes', 2000, '/');
                    // location.reload();
                    // setTimeout(function() {
                    //    window.scrollTo(0, 0); // Scroll to the top of the page   
                    // }, 1000);   
                    toggleModal();
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
        var goodrx_sale_price = $(this).attr('data-goodrx_sale_price');
        if (typeof goodrx_sale_price !== 'undefined' && goodrx_sale_price !== false && goodrx_sale_price != '' && goodrx_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-goodrx_sale_price', goodrx_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-goodrx_sale_price');
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



    //});
</script>
<?php

get_footer();

?>