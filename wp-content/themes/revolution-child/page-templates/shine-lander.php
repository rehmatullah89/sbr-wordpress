<?php
/*Template Name: Shine sales Template */
global $wpdb;
global $GEHA_PAGE_ID;

if (function_exists('w3tc_flush_url')) {
    w3tc_flush_url(get_permalink(get_the_ID()));
}

get_header();
$GEHA_PAGE_ID = SHINE_PAGE_ID;
if($shineFlag){
    if(isset($_COOKIE['shine_user']) && is_numeric($_COOKIE['shine_user'])) {
        $shineUser = $_COOKIE['shine_user'];
        $subscriptions = $wpdb->get_row("SELECT COUNT(*) as active_subscription FROM sbr_subscription_details WHERE user_id = $shineUser AND (STATUS = 1 OR next_order_date >= NOW()) AND shine_group_code != 0 ORDER BY id DESC LIMIT 1", "ARRAY_A");                  
        if(!@$subscriptions['active_subscription']){
            ?>
                <script>window.location.href = '/shine';</script>
            <?php
        }
    }
}elseif(!$shineFlag){
   ?>
<script>window.location.href = '/';</script>
   <?php
   die();
}

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('page-template-geha-template');
    });
</script>

<style>
    #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-6>.vc_column-inner {
        background-color: #fff !important;
    }


    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
        max-width: 1330px;
    }

    #gehaPage .gehaPageBanner {
        max-height: 630px;
        overflow: hidden;
        background: #9da2ef;
        padding-top: 2rem;
        /* background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%); */
        /* background-image: url(/wp-content/themes/revolution-child/assets/images/one-dental/one-dental-banner-bg.jpg);
        background-repeat: no-repeat; */
        /* background-position: center; */


    }

    .gehanFormSection {
        background-color: #6db244;
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
        margin: 0;
    }

    #gehaPage .gehaLoginCustomer h3 a:hover {
        color: #fff;
    }

    #gehaPage .gehaLoginCustomer h3 a {
        color: #0c2242;
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
        background-color: #9da2ef;
        /* background-image: url(/wp-content/themes/revolution-child/assets/images/one-dental/one-dental-after-login-top-banner.jpg); */
        background-repeat: no-repeat;
        background-position: center;

    }

    #gehaPage .shopLanderPageHader .whitening-teeth-girl-with-smile {
        right: 78px;
        top: -106px;
        max-width: 369px;
    }

    #gehaPage .alin-items-center {
        align-items: center;
    }

    #gehaPage #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner {
        /* background-color: #f5e3a9a3 !important; */
    }

    #gehaPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-5>.vc_column-inner {
        background-color: rgba(37, 212, 205, 0.08) !important;
    }


    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button,
    .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite,
    .teethWhieteingSystemWrapper.productLandingPageContainer .btn {
        /* background-color: #b8b8dc;
        border-color: #b8b8dc; */

        background: #f0c23a;
    display: inline-flex;
    width: 100%;
    padding: 10px 0;
    font-size: 20px;
    color: #2d2e2f;
    font-weight: 300;
    justify-content: center;
    border-radius: 8px;
    border: 0;
    letter-spacing: 0;

    }
    #product-list .landing-product .product-selection-description-parent-inner .btn-primary-blue:hover{
        color:#fff;
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
        background: #e8f8fc;
        background: #e8f8fc;
    }

    .productLandingPageContainer .form-group-radio-custom [type="radio"]:checked + label:before {
        border-color: #25d4cd;
    }
    .productLandingPageContainer .form-group-radio-custom [type="radio"]:checked + label:after, .productLandingPageContainer .form-group-radio-custom [type="radio"]:not(:checked) + label:after{
        background: #25d4cd;
    }
    #product-list.productLandingPageContainer .packageheader a.iconCloseBox{
        color: #25d4cd;
    }
    #gehaPage .graphicImagePeople img {
        /* width: 100%;
        max-width: 776px; */
    }

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
        background: #ecf5fa;
    position: relative;
    border-bottom: 1px solid #ddebf2;
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

    #product-list .landing-product:not(.medium-12) .featureTag,#product-list .medium-12 .featureTag {
        background: #25d4cd;
        max-width: fit-content;
        margin-left: auto;
        margin-right: auto;
        border-radius: 10px;
        margin-top: 3px;    
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
        color: #fff;
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
        background: #2d2e2f;
        /* margin-top: -25px; */


    }
    .grid-changed-parent-wrapper .disclaimer-bar-purple{
        margin-top: 0px;
    }

    .text-blue-500 {
        color: #0c2242;
    }

    .bg-sky-500 {
        background: #3d98cc !important;
    }

    .bg-blue-200 {
        background: #9da2ef !important;
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

    .floting-geha-button {
        left: 0;
        transform: rotate(0deg);
        background-color: #DB0024;
    }

    .geha-memeber-button {
        position: absolute;
        bottom: 100%;
        -webkit-transform: rotateZ(90deg);
        transform-origin: 0 100%;
        background-color: #DB0024;
        white-space: nowrap;
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
    

    #product-list .landing-product:not(.medium-12) .featureTag, #product-list .medium-12 .featureTag{
        padding: 1px 5px;
        /* background-color: red; */
    }

    @media only screen and (max-width: 1280px) and (min-width: 992px) {
        #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img {
            max-width: 410px;
        }

    }




    @media (min-width: 991px) {
        .page-template-shine-lander #product-list.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description b
    ,.page-template-shine-lander  #product-list.grid-changed .caripro-product-outer h1
    ,.page-template-shine-lander #gehaPage #product-list.grid-changed .medium-12 .product-selection-description b
    {
        font-size: 14px;

    }
    #product-list.productLandingPageContainer .landing-product.medium-3 .product-selection-price-wrap button, #product-list.productLandingPageContainer .landing-product.medium-1\/5 .product-selection-price-wrap button, #product-list.productLandingPageContainer .landing-product.medium-2 .product-selection-price-wrap button {
        font-size: 16px;
    }

    #product-list:not(.grid-changed) .medium-3 .product-selection-image-wrap {
        min-height: 231px;
    }
    #product-list:not(.grid-changed) .medium-6 .product-selection-image-wrap {
        min-height: 272px;
    }
    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button, .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite, .teethWhieteingSystemWrapper.productLandingPageContainer .btn{
        font-size: 16px;
    }
    #product-list .landing-product:not(.medium-12) .productDescriptionDiv, #product-list .landing-product:not(.medium-12) .productDescriptionDiv{
        max-height: 40px;
        min-height: 40px;
    }



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
            padding-right: 4rem;
        }

    }



    @media (min-width: 768px) {



        #product-list.productLandingPageContainer:not(.grid-changed) .medium-8.landing-product.child-4 .product-selection-image-wrap {
            max-height: 330px;
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

        #gehaPage #product-list.grid-changed .subscription-product-popup .selectPackageBox{
            border: 2px solid red !important;    max-width: 390px;
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

        #gehaPage .gehanFormSection .seeDiscountBtn #send-my-discount_partner {
            min-width: 400px;
        }

        #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
            max-width: inherit;
            width: auto;
            min-height: 130px;
            max-height: 130px;
            /* background: orange!important; */
            background: #25d4cd14;
            border-radius: 0 0 10px 10px;
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

    @media only screen and (max-width: 991px) and (min-width: 768px) {
        #product-list .medium-6.landing-product .product-selection-description-parent-inner, #product-list .medium-9.landing-product .product-selection-description-parent-inner
        ,#product-list.grid-changed .medium-6.landing-product .product-selection-description-parent-inner, #product-list.grid-changed .medium-9.landing-product .product-selection-description-parent-inner, #product-list.grid-changed .medium-3.landing-product .product-selection-description-parent-inner, #product-list.grid-changed .medium-8.landing-product .product-selection-description-parent-inner, #product-list.grid-changed .medium-12.landing-product .product-selection-description-parent-inner, #product-list.grid-changed .medium-4.landing-product .product-selection-description-parent-inner
        
        {
            display: block;
            /* background: red; */
        }
        #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button, .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite, .teethWhieteingSystemWrapper.productLandingPageContainer .btn
        ,#gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue
        {
            font-size: 12px;
        }
        .page-template-geha-template #product-list .landing-product.medium-3 .product-selection-description-parent,.page-template-geha-template #product-list .medium-6.landing-product .product-selection-description-parent {
            min-height: 180px;
            max-height: 180px;
        }
        .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del, .page-template-geha-template #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount
        , .page-template-geha-template #product-list.productLandingPageContainer .product-selection-price-text
        ,.page-template-geha-template #product-list .medium-3 span.product-selection-price-text ins bdi, .page-template-geha-template #product-list .medium-6 span.product-selection-price-text ins bdi, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount, .page-template-geha-template #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi
        {
            font-size: 20px;
        }
        #product-list:not(.grid-changed) [data-cats="dental-probiotics,only-google-feed,adults-probiotics"] .subscription-product-detail .caripro-content {
            width: 40%;
        }
        #product-list:not(.grid-changed) [data-cats="dental-probiotics,only-google-feed,adults-probiotics"] .subscription-product {
            width: 50%;
        }

        .subscription-product-detail .caripro-content h1 {
            font-size: 20px;
            color: #002244;
        }
        .subscription-product-detail .caripro-content p:after{
             opacity: 0;
        }
        #product-list.productLandingPageContainer .medium-12 .product-selection-image-wrap img{
            max-width: 331px;
        }

        #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent {
            max-width: 400px;
        }
        #product-list:not(.grid-changed) .medium-6 .product-selection-image-wrap {
        min-height: 216px;
        max-height: 216px;
        }
        #product-list:not(.grid-changed) .medium-3 .product-selection-image-wrap {
            min-height: 217px;
        }
    }

    @media (max-width: 767px) {
        .page-template-page-templates .subscription-product-header-top{
            display: block;
        }
        .page-template-page-templates  .subscription-product-header-top .main-price{
            display: flex;
        }
        .page-template-page-templates  .subscription-product-header-top p span{ display: block;}
        .page-template-page-templates .subscription-product-header-top .main-price{
            width: 100%;
        }
        .page-template-page-templates .subscription-product-header-top p span {
            display: inline-block;
            min-width: auto;
        }
        span.pricingDiscountMbt del {
            font-size: 20px;
            display: inline-flex;
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
            max-width: 100% !important;
            justify-content: center;
        }
    }

    #gehaPage .gehaLoginCustomer h3 a {
        color: #eb6754 !important;
        font-weight: 400;
    }


    body .smtext {
        padding-left: 7rem;
    }

    body .prpt {
        padding-left: 5rem;
    }

    body .smtext h2 {
        margin-top: 0px !important;
        font-size: 27px !important;
    }

    .cnfimg {
        /* width: 70%; */
    }

    .col-sm-12.tp-head-form {
        max-width: 540px;
        margin: auto;
    }

    .col-sm-12.tp-head-form h5 {
        text-align: right;
        padding-right: 1rem;
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
            max-width: 300px;
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


    /* for dropdown */


    ul.slideContent {
        display: none;
        list-style: none;
    }

    .subMenuDropdown {
        display: none;
    }

    .menuActivate .subMenuDropdown {
        display: block;
    }

    ul.slideContent li,
    .skin-careProductNav {
        display: flex;
        align-items: center;
        column-gap: 9px;
        margin-top: 10px;
    }

    #wrapper .subMenuDropdown label {
        margin: 0;
        font-size: 14px;
        line-height: 1;
    }


    /* for shine lander only */


    .button-wrap,
    .how-work-link {
        margin-bottom: 15px;
        display: none;
    }

    .sectionRgt p {
        color: #2d2e2f !important;
    }

    html body .section-top-banner {
        padding-top: 87px;
        padding-bottom: 150px;
    }


    html body  .shineDropDown button {
    border: 0px;
    font-family: "Montserrat";
    background:  url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 8px) 20px no-repeat;
    background-color: transparent;
    text-transform: capitalize;
    border-radius: 3px;
    height: 48px;
    line-height: 48px;
    color: #343434;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 400;
    font-size: 16px;    font-family: 'Montserrat';
}
html body  .shineDropDown button {
    background-color: none;    letter-spacing: 0;
}

html body  .shineDropDown button:hover {
    background-color: transparent;
    color: #343434;    background: url(/wp-content/themes/revolution/assets/img/select_arrow.png) calc(100% - 8px) 20px no-repeat;
}
html body  .subMenuDropdown {
    position: relative;
}

html body  .shineDropDown .subMenuDropdown {
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
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);    z-index: 1;
    width: 100%;
    min-width: 344px;
    padding-top: 15px;
    padding-bottom: 15px;
    
}

html body  .subMenuDropdown>li>a,.subMenuDropdown .skin-careProductNav {
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
.subMenuDropdown .skin-careProductNav{
    background: none
}
.shineDropDown {
    position: relative;
}
section.shopLanderPageHader .pageheaderBotm{overflow: initial;}

.subMenuDropdown [type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
.subMenuDropdown [type="radio"]:checked + label,
.subMenuDropdown [type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
.subMenuDropdown [type="radio"]:checked + label:before,
.subMenuDropdown [type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
.subMenuDropdown [type="radio"]:checked + label:after,
.subMenuDropdown [type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #25d4cd;
    position: absolute;
    top: 3px;
    left: 3px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
.subMenuDropdown [type="radio"]:checked + label:before{
    border-color: #80e4e3;
}


.subMenuDropdown [type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
.subMenuDropdown [type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

ul.slideContent li {
    padding-left: 6px;
    padding-bottom: 4px;
    padding-top: 4px;
}
ul.subMenuDropdown > li {
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 8px;
}
ul.subMenuDropdown > li:last-child{
    border-bottom: 0px solid #eee;
    margin-bottom: 0px;    
}
ul.subMenuDropdown > li:last-child
#wrapper li.depth-1.skin-careProductNav label.radio-custom-label {
    margin-left: 10px;
    display: inline-flex;
}
body {
    overflow-x: hidden;
}

.page-template-geha-template #gehaPage #product-list.productLandingPageContainer span.product-selection-price-text del:before{
    background: #f0c23a;
    background: #25d4cd;
}
#product-list.productLandingPageContainer .featureShippingPrice {
    color: #25d4cd;
}
.product-selection-box{
    border: 1px solid rgba(37, 212, 205, 0.24);
    border-radius: 10px;
}

html body #product-list.teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap .packageQuantityBox .plus-minusWrapper button{
    color: #f0c23a;
}
.selectPackageBox{
    z-index: 123;
}
#gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent, #gehaPage .packageQuantityBox, .selectPackageBox{
    border-radius: 10px;    
}
.productLandingPageContainer .medium-6 .selectPackageBox, .productLandingPageContainer .medium-6 .packageQuantityBox, .productLandingPageContainer .medium-12 .selectPackageBox, .productLandingPageContainer .medium-12 .packageQuantityBox, .productLandingPageContainer .medium-9 .selectPackageBox, .productLandingPageContainer .medium-9 .packageQuantityBox, .productLandingPageContainer .medium-8 .packageQuantityBox, .productLandingPageContainer .medium-10 .packageQuantityBox, .productLandingPageContainer .medium-10 .selectPackageBox{
    border-left: 1px solid #caf5f3;
}
.packageQuantityBox,.selectPackageBox{
    border-top: 1px solid #caf5f3;
}

.productLandingPageContainer .medium-12 .selectPackageBox, .productLandingPageContainer .medium-12 .packageQuantityBox{
    border-color: #caf5f3;
}


#gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer  .lander-shortcode .product-selection-box > .product-selection-description-parent {
    border-radius: 0 0 10px 10px;
}
.shine-banner-wrap .aetna-logo-wrap{
    display: none;
}
html body .section-top-banner {
    padding-bottom: 30px;
}

#wrapper .subMenuDropdown li.depth-1.skin-careProductNav label{
    padding-left: 0;
}

.page-template-shine-lander #wrapper  li.depth-1.skin-careProductNav .radio-custom-label:before
,.page-template-shine-lander #wrapper  li.depth-1.skin-careProductNav .radio-custom-label:after
{

    width: 0;
    height: 0;
}




@media screen and (min-width: 768px) {
    #product-list .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue{
        font-size: 20px;
    }

    html body .subMenuDropdown>li>a, .subMenuDropdown .skin-careProductNav {
        font-weight: 400;
        color: #565759;
    }

}

#gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button, .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite, .teethWhieteingSystemWrapper.productLandingPageContainer .btn{
    text-transform: none;
}


@media screen and (max-width: 767px) {

    html body .section-top-banner {
    padding-bottom: 10px;
}

section.shopLanderPageHader .flex-row {
        flex-wrap: wrap;
    }

    html body .shineDropDown button{
        padding-left: 9px;    font-size: 12px;
    }

    #product-list .featureTag{
        z-index: inherit;
    }



    #gehaPage #product-list.grid-changed .medium-12.thb-dark-column.small-12.landing-product .product-selection-description-parent
    ,.child-4 .product-selection-description-parent, .child-0 .product-selection-description-parent, .child-5 .product-selection-description-parent, .child-6 .product-selection-description-parent
    
    {
        max-width: inherit !important;

    }
    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button, .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite, .teethWhieteingSystemWrapper.productLandingPageContainer .btn{
        font-size: 14px;
    }
    html body .shineDropDown .subMenuDropdown{
        left: 0px;
    }




    section.shopLanderPageHader .flex-row {
        flex-wrap: wrap;
    }
    section.shopLanderPageHader .flex-row {
        gap: 10px;
    }
    html body.page-template-shine-lander .shineDropDown {
        max-width: 100%;
        width: 100%;
    }
    
    html body.page-template-shine-lander .shineDropDown button, body.page-template-geha-template section.shopLanderPageHader .pageheaderBotm select {
        font-size: 14px;
        text-transform: capitalize !important;
        padding: 2px 11px;
        display: block;
        width: 100%;
        border: 0;
        border-bottom: 1px solid #e6e6e6;
        text-align: left;
    }
    html body.page-template-shine-lander .shineDropDown .dropdown-toggle::after, html body.page-template-geha-template .shineDropDown .dropdown-toggle::after {
    border-top: 0;
    border-right: 0;
    border-bottom: 0;
    border-left: 0;
}
html body.page-template-shine-lander .shineDropDown .subMenuDropdown {
        min-width: 260px;
    }


    html body.page-template-geha-template .shineDropDown .subMenuDropdown {
    border: 1px solid rgb(189 243 240);
    margin: 6px 0 0;
    border-top: 0;
    border-radius: 8px;
}
ul.subMenuDropdown > li {
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 8px;
}
html body.page-template-geha-template .subMenuDropdown>li>a, .subMenuDropdown .skin-careProductNav {
    font-weight: 400;
    color: #565759;
}
html body.page-template-shine-lander .subMenuDropdown>li>a, html body.page-template-shine-lander .subMenuDropdown .skin-careProductNav, html body.page-template-shine-lander #wrapper .subMenuDropdown label {
        font-size: 12px;
    }

    html body.page-template-shine-lander section.shopLanderPageHader{
        background: #ffffff;
        border-bottom: 0px solid #ddebf2;
    }
    html body.page-template-shine-lander .all-product-dropdown {
        width: 82%;
    }
    html body.page-template-shine-lander  .disclaimer-bar-purple{
        margin-top: 0px;
    }

    html body.page-template-shine-lander  #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product >.vc_column-inner {
        background-color: #ffffff !important;
    }

    .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top{
        padding-bottom: 5px;
        }
        .page-template-geha-template #product-list .product-selection-description {
            min-height: 0px;
        }
        .page-template-geha-template #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top, .page-template-geha-template #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top{
            padding-bottom: 5px;
        }

}



</style>


<div class="gehaTemplate active-recomendation-tab" id="gehaPage">



    <?php

    if ($shineFlag) {
        $page_id = get_the_id(); // Replace 123 with the ID of the page you want to retrieve
        $page = get_post($page_id);
        if ($page) {
    ?>
            <style>
                @media (min-width: 768px) {
                    #gehaPage section.shopLanderPageHader .pageheaderTop {
                        margin-top: 73px;
                        margin-top: 10px;
                    }
                }
            </style>


            <div class="salePageBannerHome">
                <?php
                get_template_part('inc/templates/shine-saving-plans/shine-top-banner-member-page');
                ?>
            </div>

            <section class="shopLanderPageHader benefit-hub">

                <div class="pageHeader">
                    <div class="pageheaderBotm">


                        <div class="row no-flex">







                            <div class="flex-row">



                            <div class="shineDropDown">

                                <nav>
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton">
                                        All Products
                                    </button>
                                    <ul class="subMenuDropdown">
                                        <li class="depth-1">
                                            <a class="slide txtClr1" href="javascript:void(0)">CUSTOM TRAYS & GUARDS </a>
                                            <ul class="slideContent">
                                                <li class="depth-2">
                                                    <input type="radio" id="custom-night-guards" name="single-selection" class="child-radio" value="Custom Night Guards" data-slug="night-guards">
                                                    <label for="custom-night-guards" class="radio-custom-label">Custom Night Guards</label>
                                                </li>
                                                <li class="depth-2">
                                                    <input type="radio" id="custom-whitening-trays" name="single-selection" class="child-radio" value="Custom Whitening Trays" data-slug="teeth-whitening-trays">
                                                    <label for="custom-whitening-trays" class="radio-custom-label">Custom Whitening Trays</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="proshield-sports-guards" name="single-selection" class="child-radio" value="Proshield Sports Guards" data-slug="proshield">
                                                    <label for="proshield-sports-guards" class="radio-custom-label">Proshield Sports Guards</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="try-cleaning-tablets" name="single-selection" class="child-radio" value="Tray Cleaning Tablets" data-slug="retainer-cleaner">
                                                    <label for="try-cleaning-tablets" class="radio-custom-label">Tray Cleaning Tablets</label>
                                                </li>


                                            </ul>
                                        </li>
                                        <li class="depth-1">
                                            <a class="slide txtClr2" href="javascript:void(0)">Teeth whitening </a>
                                            <ul class="slideContent">

                                                <li class="depth-2">
                                                    <input type="radio" id="custom-whitening-trays-option-1" name="single-selection" class="child-radio" value="Custom Whitening Trays" data-slug="teeth-whitening-trays">
                                                    <label for="custom-whitening-trays-option-1" class="radio-custom-label">Custom Whitening Trays</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="new-dental-stain-concealer" name="single-selection" class="child-radio" value="New Dental Stain Concealer" data-slug="stain-concealer">
                                                    <label for="new-dental-stain-concealer" class="radio-custom-label">New Dental Stain Concealer</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="whitening-gel-refills" name="single-selection" class="child-radio" value="Whitening Gel Refills" data-slug="teeth-whitening-gel">
                                                    <label for="whitening-gel-refills" class="radio-custom-label">Whitening Gel Refills</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="desensitizing-gel-refills" name="single-selection" class="child-radio" value="Desensitizing Gel Refills" data-slug="sensitive-teeth-gel">
                                                    <label for="desensitizing-gel-refills" class="radio-custom-label">Desensitizing Gel Refills</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="whitening-tray-cleaning-tablets" name="single-selection" class="child-radio" value="Whitening Tray Cleaning Tablets" data-slug="retainer-cleaner">
                                                    <label for="whitening-tray-cleaning-tablets" class="radio-custom-label">Whitening Tray Cleaning Tablets</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="new-ultrasonic-tray-cleaner" name="single-selection" class="child-radio" value="Ultrasonic Tray Cleaner" data-slug="ultrasonic-cleaner">
                                                    <label for="new-ultrasonic-tray-cleaner" class="radio-custom-label">Ultrasonic Tray Cleaner</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="enamel-armour-for-sensitive-teeth" name="single-selection" class="child-radio" value="Enamel Armour™ for Sensitive Teeth" data-slug="enamel-armour">
                                                    <label for="enamel-armour-for-sensitive-teeth" class="radio-custom-label">Enamel Armour™ for Sensitive Teeth</label>
                                                </li>

                                            </ul>
                                        </li>


                                        <li class="depth-1">
                                            <a class="slide txtClr3" href="javascript:void(0)">oral Care </a>
                                            <ul class="slideContent">

                                                <li class="depth-2">
                                                    <input type="radio" id="electric-toothbrush" name="single-selection" class="child-radio" value="Electric Toothbrush" data-slug="electric-toothbrush">
                                                    <label for="electric-toothbrush" class="radio-custom-label">Electric Toothbrush</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="cordless-water-flosser" name="single-selection" class="child-radio" value="Cordless Water Flosser" data-slug="water-flosser">
                                                    <label for="cordless-water-flosser" class="radio-custom-label">Cordless Water Flosser</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="dental-probiotics-adults" name="single-selection" class="child-radio" value="Dental Probiotics" data-slug="adults-probiotics">
                                                    <label for="dental-probiotics-adults" class="radio-custom-label">Dental Probiotics</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="enamel-armour" name="single-selection" class="child-radio" value="Enamel Armour" data-slug="enamel-armour">
                                                    <label for="enamel-armour" class="radio-custom-label">Enamel Armour</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="plaque-highlighters-adults" name="single-selection" class="child-radio" value="Plaque Highlighters" data-slug="adults-plaque">
                                                    <label for="plaque-highlighters-adults" class="radio-custom-label">Plaque Highlighters Adults</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="dental-floss-picks" name="single-selection" class="child-radio" value="Dental Floss Picks" data-slug="floss-picks">
                                                    <label for="dental-floss-picks" class="radio-custom-label">Dental Floss Picks</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="replacement-roothbrush-heads" name="single-selection" class="child-radio" value="Replacement Toothbrush Heads" data-slug="toothbrush-head">
                                                    <label for="replacement-roothbrush-heads" class="radio-custom-label">Replacement Toothbrush Heads</label>
                                                </li>



                                                <li class="depth-2">
                                                    <input type="radio" id="plaque-highlighters-for-kids" name="single-selection" class="child-radio" value="Plaque Highlighters™ For Kids!" data-slug="kids-plaque">
                                                    <label for="plaque-highlighters-for-kids" class="radio-custom-label">Plaque Highlighters™ For Kids!</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="dental-probiotics-for-kids" name="single-selection" class="child-radio" value="Dental Probiotics For Kids!" data-slug="kids-probiotics">
                                                    <label for="dental-probiotics-for-kids" class="radio-custom-label">Dental Probiotics For Kids!</label>
                                                </li>

                                                <li class="depth-2">
                                                    <input type="radio" id="retainer-cleaning-tablets" name="single-selection" class="child-radio" value="Retainer Cleaning Tablets" data-slug="retainer-cleaner">
                                                    <label for="retainer-cleaning-tablets" class="radio-custom-label">Retainer Cleaning Tablets</label>
                                                </li>
                                                <li class="depth-2">
                                                    <input type="radio" id="ultrasonic-cleaner" name="single-selection" class="child-radio" value="Ultrasonic Cleaner" data-slug="ultrasonic-cleaner">
                                                    <label for="ultrasonic-cleaner" class="radio-custom-label">Ultrasonic Cleaner</label>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="depth-1 skin-careProductNav">
                                            <input type="radio" id="skin-care" name="single-selection" class="child-radio" value="Skin care" data-slug="skincare">
                                            <label for="skin-care" class="radio-custom-label">Skin care</label>
                                        </li>


                                    </ul>
                                </nav>



                            </div>

                                <div class="filterproductsOption" style="display: none;;">

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
        } ?>

                </div>
            </div>





            <?php
            // Start the loop
            // while (have_posts()) : the_post();

            //     // Display page content
            //     the_content();

            // endwhile; // End of the loop.
            ?>




            <?php if ($shineFlag) {
                echo '<style>.footer {padding: 0px 0;}</style>
                    <div class="disclaimer-bar-purple bgColor">
                    <div class="container">
                     <p class="postLoggedin text-white">“<strong>DISCLAIMER:</strong><i> In order to recieve shinemember exclusive pricing you must add to cart from this page.</i></p>
                    </div>
                    </div>';
            }
            ?>



</div>
<div class="popupGehaContainer">
    <div class="modal">
        <div class="modal-content">
            <div class="popupHeader">
                <!-- <span class="close-button">×</span> -->
            </div>
            <div class="popupBodyContent text-center">
                <h1 class="gehaTextmember">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/benefit-hub/shinemember.png" alt="shinemember" class="" />
                </h1>
                <p class="memeberGranted">MEMBER DISCOUNT ACCESS GRANTED</p>
                <h2 class="youreInText">YOU’RE IN!</h2>
                <h3 class="pleaseRed">please read:</h3>
                <p class="descriptionBody">Welcome shinemember member! You now have access to give your exclusive shinemember discounts. An email has also been sent to you with your account login details. To view your discounts in the future, simply login. Our live chat and customer support team is also here to help!<br><br>
                    <strong>CLICK THE BUTTON BELOW TO VIEW THE DISCOUNT PAGE</strong>
                </p>
                <div class=" sep-top-sm text-center seeDiscountBtn text-center">
                    <a href="<?php echo site_url('shinemember?user=yes'); ?>" class="btn">SEE DISCOUNT PAGE</a>
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

});
    $(document).ready(function() {
        // Event listener for radio button change
        $('.child-radio').on('change', function() {
            // Get the selected radio button's data-slug
            const selectedSlug = $(this).data('slug');
            show_hide = true;
            //alert(selectedSlug);
            // Loop through each div with class 'myclass'
            $('.landing-product').each(function() {
                // Get the data-cats attribute and split it into an array
                const dataCats = $(this).data('cats').split(',');

                // Check if the selected slug is in the data-cats array
                const isMatch = dataCats.includes(selectedSlug);

                if (!isMatch) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).show();
                }
            });
            addremClass();
        });
    });

    jQuery(document).ready(function() {


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
            data_Str += 'data-cats="' + jQuery(this).data('cats') + '"';


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

            jQuery(document).find('.landing-product').each(function() {

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
        if (jQuery('#price-sort').val() != 'default' || (jQuery('#filter_products').val() != 'all') || show_hide) {
            jQuery('#wrapper,#product-list').addClass('grid-changed');
            jQuery('body').addClass('grid-changed-parent-wrapper');
        } else {
            jQuery('#wrapper,#product-list').removeClass('grid-changed');
            jQuery('body').removeClass('grid-changed-parent-wrapper');
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
            jQuery('#price-sort').val('default');
            jQuery('#filter_products').trigger('change');
            jQuery('#price-sort').trigger('change');
            jQuery(".shineDropDown").removeClass("menuActivate");

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
    // var closeButton = document.querySelector(".close-button");

    function toggleModal() {
        modal.classList.toggle("show-modal");
    }

    function windowOnClick(event) {
        if (event.target === modal) {
            toggleModal();
        }
    }

    // closeButton.addEventListener("click", toggleModal);
    window.addEventListener("click", windowOnClick);


    jQuery(document).on('click', '#skipPartner', function(e) {

        setCookiePartner('shinememberOneTime', 'yes', 200, '/');
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

    jQuery(document).on('click', '#send-my-discount_partner', function(e) {
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
                    jQuery('#geha_discount_registration_form').hide();
                    setCookiePartner('shinememberOneTime', 'yes', 2000, '/');
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
        var shine_sale_price = $(this).attr('data-shine_sale_price');
        if (typeof shine_sale_price !== 'undefined' && shine_sale_price !== false && shine_sale_price != '' && shine_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-shine_sale_price', shine_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-shine_sale_price');
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



    // for dropdwon fileter

    // $(document).ready(function() {
    //     $("#dropdownMenuButton").click(function() {
    //         $(".shineDropDown").toggleClass("menuActivate");
    //     });

    //     $(".slide").click(function() {
    //         var target = $(this).parent().children(".slideContent");
    //         $(".slideContent").not(target).slideUp(); // Close other open submenus
    //         $(target).slideToggle();
    //     });

    //     $(".child-radio").change(function() {
    //         var selectedValue = $(".child-radio:checked").val();

    //         if (selectedValue) {
    //             $("#dropdownMenuButton").text(selectedValue);
    //         } else {
    //             $("#dropdownMenuButton").text("All Products");
    //         }
    //     });
    // });


    $(document).ready(function() {
    $("#dropdownMenuButton").click(function(event) {
        event.stopPropagation(); // Prevent click event from bubbling up to the document
        $(".shineDropDown").toggleClass("menuActivate");
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.shineDropDown, #dropdownMenuButton').length) {
            $(".shineDropDown").removeClass("menuActivate");
        }
    });

    $(".slide").click(function() {
        var target = $(this).parent().children(".slideContent");
        $(".slideContent").not(target).slideUp(); // Close other open submenus
        $(target).slideToggle();
    });

    // $(".child-radio").change(function() {
    //     var selectedValue = $(".child-radio:checked").val();

    //     if (selectedValue) {
    //         $("#dropdownMenuButton").text(selectedValue);
    //         $(".shineDropDown").removeClass("menuActivate");
    //     } else {
    //         $("#dropdownMenuButton").text("All Products");
    //     }
    // });

    $(".child-radio").change(function() {
    var selectedValue = $(".child-radio:checked").val();

    if (selectedValue) {
        $("#dropdownMenuButton").text(selectedValue);
        $(".shineDropDown").removeClass("menuActivate");
    } else {
        $("#dropdownMenuButton").text("All Products");
    }
});



    $("#resetButton").click(function() {
        $(".child-radio").prop('checked', false); // Uncheck all radio buttons
        $("#dropdownMenuButton").text("All Products"); // Reset dropdown button text
    });
});




    //});
</script>
<?php

get_footer();

?>