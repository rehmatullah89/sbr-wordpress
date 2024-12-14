<?php
/*Template Name: Vip Template */

session_start();

global $GEHA_PAGE_ID;
//$VIP_PAGE_ID =  get_the_ID();
$GEHA_PAGE_ID = VIP_TEMPLATE_PAGE_ID;
$gehaFlag = false;

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
        background-color: #ebedee !important;
    }

    #vipPage #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-5>.vc_column-inner {
        background-color: #fff !important;
    }


    #vipPage .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap button,
    .teethWhieteingSystemWrapper.productLandingPageContainer .product-selection-price-wrap a.product_type_composite,
    .teethWhieteingSystemWrapper.productLandingPageContainer .btn {
        background-color: #d4545a;
        border-color: #d4545a;
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
        background: #f1f1f8;
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
    .product-selection-description-parent{ position: relative;}    
    #vipPage  .ultrasonic-text-contain-by-js .backOrderList { 
        position: absolute;
    display: block;
    top: -2px;
    right: 0;
    max-width: 366px;
    }

    #vipPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList{
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

    section.shopLanderPageHader {
        margin-top: 0rem;
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

    .secondary-area-mbt {
        /* display: block !important; */
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
        margin-bottom: 3rem;
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
        font-size: 20px;
    }

    #vipPage #product-list .columns:not(.medium-12) span.product-selection-price-text del:before {
        left: -1px;
        height: 2px;
        background: #f8a18a;
    }

    #vipPage #product-list:not(.grid-changed) .columns:not(.medium-12) span.product-selection-price-text del:before {
        top: 25px;
    }




    @media (min-width: 768px) {

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
            font-family: 'Montserrat';
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
            width: 95%;
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
            font-size: 12px;
        }

        .resetFilter a {
            font-size: 11px;
        }

        section.shopLanderPageHader .pageheaderTop h1,
        section.shopLanderPageHader .pageheaderTop h1 span {
            font-size: 20px;
        }

        #vipPage #product-list .landing-product:not(.medium-12) .product-selection-price-wrap {
            padding-top: 6px;
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
        #vipPage .ultrasonic-text-contain-by-js .backOrderList{
            top: -51px;
        }
        #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList
        ,#vipPage #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList
        {
            line-height: 14px;
            top: -65px;
        }

    }


#product-list:not(.grid-changed) .landing-product.medium-3 .product-selection-description-parent
,#product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent
,#product-list:not(.grid-changed) .landing-product.medium-4 .product-selection-description-parent
{
    overflow: inherit;
}

</style>


<div class="gehaTemplate active-recomendation-tab" id="vipPage">



    <?php


    $page_id = VIP_REC_PAGE_ID; // Replace 123 with the ID of the page you want to retrieve
    $page = get_post($page_id);
    if ($page) {
    ?>
        <style>
            span.blue-text-js {
                font-weight: 900;
                color: #222222cf;
                font-size: 110%;
            }

            @media (min-width: 768px) {
                #vipPage section.shopLanderPageHader .pageheaderTop {
                    margin-top: 73px;
                    margin-top: 55px;
                    padding-top: 5rem;
                    padding-bottom: 5rem;
                }
            }
        </style>

        <section class="shopLanderPageHader">
            <div class="pageHeader ">
                <div class="whitening-teeth-girl-with-smile mobileOptionDisplay hidden">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/cyber-monday-sale/cyber-week-text.png" alt="cyber monday Deals Are Live">
                </div>
                <div class="pageheaderTop hidden" style="background:#65657f">
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
            ?>

            </div>
        </div>





        <?php
        // Start the loop
        while (have_posts()) : the_post();
        echo apply_filters('the_content', get_the_content());  

        endwhile; // End of the loop.
        ?>


        <div class="disclaimer-bar-purple hidden">
            <div class="container">
                <p>
                    “<strong>DISCLAIMER:</strong> These benefits are neither offered nor guaranteed under contract with the FEHB or FEDVIP Programs, but are made available to all Enrollees who become members of GEHA and their eligible family members.”
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
            jQuery('#price-sort').val('default');
            jQuery('#filter_products').trigger('change');
            jQuery('#price-sort').trigger('change');

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
                       // window._learnq.push(["track", "GEHA Discount", {}]);

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
        var vip_sale_price = $(this).attr('data-vip_sale_price');
        if (typeof vip_sale_price !== 'undefined' && vip_sale_price !== false && vip_sale_price != '' && vip_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-vip_sale_price', vip_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-vip_sale_price');
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

    jQuery(document).ready(function() {
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


    //});
</script>
<?php

get_footer();

?>