<?php
/*Template Name: Insurance Lander */
session_start();

global $GEHA_PAGE_ID;
//$GEHA_PAGE_ID =  get_the_ID();
$GEHA_PAGE_ID = INSURANCE_TEMPLATE_PAGE_ID;
$insuranceLanderFlag = false;
if (isset($_GET['insurance_user']) && $_GET['insurance_user'] == 'yes') {
    setcookie('insurance_lander', 'yes', time() + (3600 * 24 * 360), '/');
    $_SESSION['insurance_lander'] = 'yes';
    set_transient('insurance_lander', 'yes', 365 * DAY_IN_SECONDS);
    $insuranceLanderFlag = true;
    if (function_exists('w3tc_flush_url')) {
        w3tc_flush_url(get_permalink(get_the_ID()));
    }
}

if (isset($_COOKIE['insurance_lander']) && $_COOKIE['insurance_lander'] == 'yes') {
    $insuranceLanderFlag = true;
}
if (isset($_SESSION['insurance_lander']) && $_SESSION['insurance_lander'] == 'yes') {
    $insuranceLanderFlag = true;
}
if (get_transient('insurance_lander') == 'yes') {
    /// $insuranceLanderFlag = true;
}

if (is_user_logged_in()) {
    if (get_user_meta(get_current_user_id(), 'insurance_lander', true)) {
        $insuranceLanderFlag = true;
    }
}

// Get the path to the child theme directory
$childThemePath = get_stylesheet_directory();

// Get the path to the child theme directory
$childThemePathUrl = get_stylesheet_directory_uri() . '/assets/insurance_logos'; // Replace 'your-folder' with the actual folder name
// Specify the folder within the child theme
$folderPath = $childThemePath . '/assets/insurance_logos'; // Replace 'your-folder' with the actual folder name

// Get all files in the folder
$files = scandir($folderPath);

// Initialize an empty array to store file name and clean name pairs
$insuranceArray = [];

foreach ($files as $file) {
    // Skip current and parent directory entries
    if ($file == '.' || $file == '..') {
        continue;
    }

    // Get the original file name without extension
    $originalName = pathinfo($file, PATHINFO_FILENAME);

    // Beautify the file name by removing special characters, converting to lowercase
    // $beautifiedName = preg_replace('/[^a-zA-Z0-9]+/', '', $originalName);
    $beautifiedName = strtolower($originalName);

    // Replace spaces and underscores with hyphens
    //   $beautifiedName = preg_replace('/[\s_]+/', '-', $beautifiedName);

    // Convert the first character to uppercase
    $beautifiedName = ucfirst($beautifiedName);

    // Store the original file name (without extension) and beautified name in the array

    // $fileArray[$originalName] = $beautifiedName;
    $insuranceArray[$file] = $beautifiedName;
}
get_header();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<style>
    .page-id-890044 #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span bdi,
    .page-id-890044 #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del span,
    .page-id-890044 #product-list.productLandingPageContainer .medium-3 span.product-selection-price-text del,
    .page-id-890044 #product-list.productLandingPageContainer .medium-3 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-id-890044 #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span bdi,
    .page-id-890044 #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del span,
    .page-id-890044 #product-list.productLandingPageContainer .medium-6 span.product-selection-price-text del,
    .page-id-890044 #product-list.productLandingPageContainer .medium-6 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span bdi,
    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del span,
    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 span.product-selection-price-text del,
    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 .product-selection-price-text-top .product-selection-price-text span.woocommerce-Price-amount.amount {
        /* color: blue !important; */
        color: #a2a3a5;
        font-size: 28px;
        font-weight: 400;
    }

    .page-id-890044 #gehaPage #product-list.productLandingPageContainer span.product-selection-price-text del:before {
        height: 2px;
        background: #f8a18a;
        top: 50% !important;
        left: -3px;
        right: 0;
        margin-top: -1px;
        width: 106%;
    }

    .page-id-890044 #product-list .medium-3 span.product-selection-price-text ins bdi,
    .page-id-890044 #product-list .medium-6 span.product-selection-price-text ins bdi,
    .page-id-890044 #gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text span.woocommerce-Price-amount.amount,
    .page-id-890044 #gehaPage #product-list.grid-changed .medium-12 span.product-selection-price-text ins bdi {
        font-size: 28px;
        /* color: red !important; */
        font-weight: 400;
        color: #565759;
    }

    .page-id-890044 .swal2-icon.swal2-error.swal2-icon-show {
        margin: 0px auto !important;
        margin-top: 10px !important;
    }

    .page-id-890044 div:where(.swal2-container) .swal2-html-container {
        margin: 0em 1.6em 0.3em !important;
    }

    .page-id-890044 div:where(.swal2-container) div:where(.swal2-popup) {
        font-family: 'Montserrat';
    }

    .page-id-890044 div:where(.swal2-container) div:where(.swal2-actions) {
        margin: 0em auto 0 !important;
    }

    .page-id-890044 div:where(.swal2-icon) {
        margin: 0em auto 0.6em !important;
    }

    .page-id-890044 #product-list.productLandingPageContainer .discountedPriceForGehaMember {
        font-size: 12px;
        font-style: italic;
        font-weight: 400;
        color: #565759;
        font-family: "Open sans", sans-serif;
    }

    .page-id-890044 #product-list.productLandingPageContainer .medium-3 .discountedPriceForGehaMember,
    .page-id-890044 #product-list.productLandingPageContainer .medium-6 .discountedPriceForGehaMember,
    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 .discountedPriceForGehaMember {
        display: block;
        position: absolute;
        bottom: -16px;
        width: 100%;
        left: 0;
    }

    .close-button {
        display: none !important;
    }

    .page-id-890044 #product-list.productLandingPageContainer .product-selection-price-text-top {
        position: relative;
    }

    .page-id-890044 #product-list.productLandingPageContainer .medium-6 .discountedPriceForGehaMember {
        bottom: -22px;
        left: 0;
    }

    .page-id-890044 #gehaPage #product-list:not(.grid-changed) .medium-6.landing-product .productDescriptionDiv {
        align-items: self-end;
    }

    .page-id-890044 #gehaPage #product-list.grid-changed .medium-12 .product-selection-description-parent-inner .product-selection-description~.normalyAmount {
        color: orange !important;
        display: none !important;
    }

    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-3 .productDescriptionDiv {
        justify-content: start;
    }

    .page-id-890044 #product-list.productLandingPageContainer.grid-changed .medium-12 span.woocommerce-Price-currencySymbol {
        font-size: 20px !important;
    }

    .page-id-890044 #gehaPage .productLandingPageContainer span.product-selection-price-text.hoo,
    .page-id-890044 #gehaPage .productLandingPageContainer span.product-selection-price-text.heee {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }



    #product-list.teethWhieteingSystemWrapper:not(.grid-changed) .medium-12.thb-dark-column.small-12.landing-product.child-6>.vc_column-inner {
        background-color: #fff !important;
    }


    #product-list.productLandingPageContainer .medium-12.thb-dark-column.small-12.landing-product>.vc_column-inner .product-selection-box {
        max-width: 1330px;
    }

    #gehaPage .gehaPageBanner {
        padding-bottom: 75px;
        max-height: 670px;
        /* background: rgb(69, 8, 118); */
        /* background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%); */
        background-image: url(/wp-content/themes/revolution-child/assets/images/insurance-lander/geha-lander-v2.png);


    }

    .logos-wrapper .logo {
        padding: 0px 10px;
    }

    .gehanFormSection {
        background-image: url(/wp-content/themes/revolution-child/assets/images/insurance-lander/geha-banner-bg.jpg);
        background-color: #8a9094cc;
        background-repeat: repeat-x;
    }

    #gehaPage .rowMbt {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .mt-100 {
        padding-top: 100px;
    }

    #gehaPage .geha-banner-text-section-parent {
        width: 100%;
    }

    #gehaPage .graphicImagePeople {
        width: 60%;
        text-align: right;
    }

    #gehaPage .text-white {
        color: #fff;
    }

    #gehaPage .text-orange {
        color: #eb6754;
    }

    #gehaPage .geha-banner-text-section {
        text-align: center;
    }


    #gehaPage .geha-banner-text-section p {
        margin-bottom: 0;
        padding-bottom: 10px;
    }

    .custom-select p.dropdown-heading.toggle {
        display: flex;
        position: relative;
        background-color: #fff;
        max-width: 370px;
        margin: 0px auto;
        padding: 15px 15px !important;
        justify-content: space-between;
        margin-bottom: 35px !important;
    }

    #gehaPage .geha-banner-text-section h2 {
        font-size: 19px;
        margin-bottom: 50px;
        line-height: 1.3;
        max-width: 680px;
        margin: 40px auto 20px auto;
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

    #gehaPage .gehaPageBanner .seeDiscountBtn button {
        margin-bottom: 80px;
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
        color: #fff;
        font-weight: 500;
    }

    #gehaPage .splitTwo {
        width: calc(100%/2);
    }

    #gehaPage .productGripgSectionWrapper {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/BACKGROUND-save.png');
        padding: 20px;
    }

    #gehaPage .productGripgSection {
        padding: 30px;
    }

    #gehaPage .productGripgSection li {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/list-tick.png');
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
        background: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/geha-product-image.jpg');
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

    .slick-next:before {
        content: '→';
    }

    .slick-prev:before,
    .slick-next:before {
        font-family: 'slick';
        font-size: 20px;
        line-height: 1;
        opacity: .75;
        color: white;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    #gehaPage .colhFsaSec h4 {
        font-size: 30px;
    }

    #gehaPage section.ourSuportedCustomers.product-logo-wrapper {
        background: #378abf;
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
        background-image: url(/wp-content/themes/revolution-child/assets/images/insurance-lander/logoes-tiktok.png);
        width: 114px;
        height: 149px;
        position: absolute;
        top: 0;
        left: 0;
        background-repeat: no-repeat;
    }

    #gehaPage .box-with-extra-logo-right:before {
        content: "";
        background-image: url(/wp-content/themes/revolution-child/assets/images/insurance-lander/logoes-small-circle.png);
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
        color: #4597cb;
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
        background: #fff;
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
        background: rgb(69, 8, 118) !important;
        background: linear-gradient(190deg, rgba(69, 8, 118, 1) 0%, rgba(79, 23, 125, 1) 55%, rgba(99, 53, 137, 1) 85%) !important;

        /* background: url(/wp-content/themes/revolution-child/assets/images/insurance-lander/geha-member-discount-bg.png) #683c8c !important; */

    }

    .show-div {
        display: none;
    }

    .footer {
        padding-top: 0px;

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
    .product-selection-description-parent {
    position: relative;
}
    #gehaPage #product-list.productLandingPageContainer .medium-12 .product-selection-description b {
        color: #65657f;
        font-weight: 500;
    }
    
    .landing-product.child-0 .backOrderList.alert.alert-danger.font-mont{
    /* display: block; */
}

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

    #gehaPage .teethWhieteingSystemWrapper.productLandingPageContainer .landing-product:not(.medium-12) .product-selection-description-parent,
    #gehaPage .packageQuantityBox,
    .selectPackageBox {
        background: #f1f1f8;
    }

    #gehaPage .graphicImagePeople img {
        width: 100%;
        max-width: 776px;
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
        z-index: 9999;
    }

    .modal-content {
        position: absolute;
        top: 58%;
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



    #popup_loader {
        width: 100px;
        height: 100px;
        border-radius: 100%;
        position: relative;
        margin: 0 auto;
        display: none;
    }

    .page-loader {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #55575999;
        z-index: 9999;

    }

    .loader-activate .page-loader {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader-activate #popup_loader {
        display: flex;
    }

    /* LOADER 1 */

    #popup_loader:before,
    #popup_loader:after {
        content: "";
        position: absolute;
        top: -10px;
        left: -10px;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        border: 10px solid transparent;
        border-top-color: #3498db;
    }

    #popup_loader:before {
        z-index: 100;
        animation: spin 1s infinite;
    }

    #popup_loader:after {
        border: 10px solid #ccc;
    }

    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
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

    .custom-select .select-dropdown,
    .custom-select .select-dropdown * {
        margin: 0;
        padding: 0;
        position: relative;
        box-sizing: border-box;
    }

    .custom-select .select-dropdown {
        position: relative;
        background-color: #fff;
        max-width: 370px;
        margin: 0px auto;
        margin-bottom: 80px;

    }

    .custom-select .select-dropdown select {
        font-size: 15px;
        font-weight: normal;
        max-width: 370px;
        padding: 4px 24px 8px 30px;
        border: none;
        background-color: #fff;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0px;
        height: 60px;
    }

    .custom-select select {
        background: none !important
    }

    .custom-select .select-dropdown select:active,
    .custom-select .select-dropdown select:focus {
        outline: none;
        box-shadow: none;
    }

    .custom-select .select-dropdown:after {
        content: "";
        position: absolute;
        top: 50%;
        right: 30px;
        width: 0;
        height: 0;
        margin-top: -2px;
        border-top: 7px solid #555759;
        border-right: 7px solid transparent;
        border-left: 7px solid transparent;
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

    #gehaPage h1.gehaLogoLarge span {
        line-height: 1;
        font-size: 32px;
        position: relative;
        top: -12px;

    }

    #gehaPage h1.gehaLogoLarge {
        line-height: 52px;
    }

    .logos-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 30px;
    }

    /* .logos-wrapper .logo img {
    max-width: 150px;
    padding: 0px 10px;
} */

    .logo1 img {
        max-width: 110px;
    }

    .logo2 img {
        max-width: 170px;
    }

    .logo3 img {
        max-width: 160px;
    }

    .logo4 img {
        max-width: 145px;
        position: relative;
        top: 5px;
    }

    .logo5 img {
        max-width: 115px;
    }

    .logo6 img {
        max-width: 225px;
    }

    .logo7 img {
        max-width: 125px;
    }

    .logo8 img {
        max-width: 130px;
        position: relative;
        top: -4px;
    }

    /*new fropdown */
    .custom-select input[type="checkbox"],
    .custom-select .dropdown-content,
    .custom-select input[type="radio"] {
        display: none;
    }

    .custom-select .dropdown-wrapper.active .dropdown-content {
        display: block;
    }

    .custom-select input[type="radio"]+label {
        cursor: pointer;
        position: relative;
        font-size: 16px;
    }

    .custom-select input[type="radio"]+label:before {
        right: -110px;
        top: -15px;
        position: absolute;
        content: '\2713';
        font-size: 28px;
        font-weight: 700;
        color: green;
    }



    .custom-select .dropdown-content {
        position: absolute;
        border: 1px solid #b3b3bf;
        padding: 15px;
        top: -52px;
        right: -185px;
        width: 370px;
        max-height: 400px;
        overflow-x: hidden;
    }

    .custom-select .dropdown-content ul,
    .custom-select .dropdown-content li {
        margin: 0;
        padding: 0;
    }

    .custom-select .dropdown-content ul {
        list-style: none;
    }

    .slick-next {
        right: 10px;
    }

    .slick-prev {
        left: 10px;
    }

    .custom-select .dropdown-content:after,
    .dropdown-content:before {
        bottom: 100%;
        left: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .custom-select .dropdown-content:after {
        border-color: rgba(0, 0, 0, 0);
        border-bottom-color: #ffff;
        border-width: 10px;
        margin-left: -10px;
    }

    .custom-select .dropdown-content:before {
        border-color: rgba(179, 179, 191, 0);
        border-bottom-color: #b3b3bf;
        border-width: 11px;
        margin-left: -11px;
    }

    .custom-select .icon-wrapper {
        color: #b3b3bf;
    }

    .custom-select .icon-wrapper i {
        position: relative;
        margin-left: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        text-align: center;
        display: block;
        cursor: pointer;
        color: #2f255b;
    }

    .custom-select .icon-wrapper i:before {
        display: block;
        line-height: 18px;
        font-size: 10px;
    }

    .custom-select .icon-wrapper li {
        border-bottom: 1px solid #dcdbe5;
        margin: 10px 0px 10px 0px;
        color: #2f255b;
        display: flex;
        align-items: center;
        min-height: 60px;
    }

    .custom-select .icon-wrapper li:first-child {
        margin-top: 0;
    }

    .custom-select label {
        font-size: 14px !important;
    }

    .custom-select .icon-wrapper li span {
        display: block;
        padding-left: 35px;
        font-size: 0.9em;
        color: #b3b3bf;
    }

    .custom-select .icon-wrapper {
        display: inline-block;
        position: relative;
    }

    .custom-select i.fa.fa-chevron-down {
        position: absolute;
        right: 30px;
        top: 18px;
        color: #555759;
    }

    .custom-select .dropdown-heading {
        color: #b3b3bf;
        cursor: pointer;
    }

    .custom-select .dropdown-wrapper p {
        width: 100%;
        font-size: 16px;
        text-align: left;
        color: #555759;
    }

    .gehanFormSection.show-div .form-steps .logo {
        max-width: 200px;
        max-height: 200px;
        margin: 0px auto;
        margin-bottom: 30px;
    }

    .gehanFormSection.show-div .form-steps .logo img {
        max-width: 100%;
    }

    .custom-select input[type="radio"]+label:before {
        opacity: 0;
    }

    .custom-select input[type="radio"]:checked+label:before {
        opacity: 1;
    }

    .custom-select label {
        display: flex !important;
        text-align: left;
        justify-content: start;
        margin-bottom: 5px;
        align-items: center;
        color: #565759;
    }

    .page-id-890044 #product-list.productLandingPageContainer .medium-6 .discountedPriceForGehaMember,
    .page-id-890044 #product-list.productLandingPageContainer .medium-3 .discountedPriceForGehaMember,
    #product-list.productLandingPageContainer .medium-12 .normalyAmount {

        display: none !important
    }

    .custom-select label img {
        margin-right: 30px;
        width: 80px !important;
    }

    .seeDiscountBtn {
        display: none;
    }

    .insurance-float-btn {
        background-color: #f8a18a !important;
        display: none;
    }

    .insurance-wrapper-padding-top {
        padding-top: 140px;
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
    .page-id-890044 #product-list .landing-product.medium-3 .product-selection-description-parent,.page-id-890044  #product-list:not(.grid-changed) .landing-product.medium-6 .product-selection-description-parent {
        overflow: visible;
    }
    
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* .floting-geha-button .geha-memeber-button a {
        display: none !important
    } */

    @media (min-width: 768px) {

        .page-id-890044 #product-list .landing-product.medium-3 .product-selection-description-parent {
            min-height: 204px;
            max-height: 204px;
        }

        .page-id-890044 #product-list .medium-6.landing-product .product-selection-description-parent {
            min-height: 145px;
            max-height: 145px;
        }

        .page-id-890044 #product-list .product-selection-price-text-top {
            height: 50px;
        }

        .page-id-890044 #product-list.productLandingPageContainer .product-selection-price-text-top {
            min-width: 220px;
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



    @media screen and (min-width: 1200px) {
        .page-id-890044 #product-list .landing-product.medium-3 .product-selection-description-parent {
            min-height: 185px;
            max-height: 185px;
        }

        .page-id-890044 #product-list .medium-6.landing-product .product-selection-description-parent {
            min-height: 145px;
            max-height: 145px;
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

    .landing-product.child-0 .backOrderList.alert.alert-danger.font-mont{
    /* display: block; */
}

#product-list .grid-changed .backOrderList
,#product-list .grid-change.child-0 .backOrderList.alert.alert-danger.font-mont
,#product-list .landing-product.child-0 .backOrderList.alert.alert-danger.font-mont

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

#gehaPage #product-list:not(.grid-changed) .child-0 .backOrderList.alert.alert-danger.font-mont{
    position:static;
    margin-left: auto;
    margin-right: auto;
}

    @media (max-width: 767px) {
        #gehaPage .ultrasonic-text-contain-by-js .backOrderList{
            top: -50px;
        }
        #product-list .grid-changed .backOrderList, #product-list .grid-change.child-0 .backOrderList.alert.alert-danger.font-mont, #gehaPage #product-list.grid-changed .backOrderList.alert.alert-danger.font-mont{
            top: -63px;
        }
        .custom-select .icon-wrapper {
            display: block;
        }

        .custom-select p.dropdown-heading.toggle {
            margin-bottom: 0px !important
        }

        .disclaimer-bar-purple {
            padding-left: 10px;
            padding-right: 10px;
        }

        .year-wrannanty-container .wpb_single_image img {
            margin-bottom: 20px;
        }

        .logo1 img {
            position: relative;
            max-width: 71px;
            left: 30px;
        }

        .logo2 img {
            max-width: 100%;
        }

        .logo3 img {
            max-width: 115px;
        }

        .logo4 img {
            max-width: 115px;
            position: relative;
            top: 0px;
        }

        .logo5 img {
            max-width: 90px;
        }

        .logo6 img {
            max-width: 195px;
            position: relative;
            left: -25px;
            top: 0px;
        }

        .logo7 img {
            max-width: 90px;
            position: relative;
            left: 50px;
            top: 3px;
        }

        .logo8 img {
            max-width: 115px;
            position: relative;
            top: -10px;
            z-index: 9999999999;
            left: 29px;
        }

        #gehaPage h1.gehaLogoLarge {
            line-height: 32px;
            font-size: 28px;
        }

        #gehaPage h1.gehaLogoLarge span {
            top: -2px;
        }

        #gehaPage .geha-banner-text-section h2 br {
            display: none;
        }

        .logos-wrapper {
            padding-top: 0px;
        }

        .logos-wrapper img {
            margin: 0px 20px;
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

        .custom-select .dropdown-wrapper {
            padding: 10px 20px;
        }

        .custom-select i.fa.fa-chevron-down {
            top: 20px;
        }

        .custom-select .dropdown-content {
            right: 0px;
            width: 100%;
            top: 0px;
        }

        #gehaPage .geha-banner-text-section h2 {
            margin-top: 20px;
            font-size: 18px;
            line-height: 1.3;
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
            right: 0;
            top: -135px;
            max-width: 290px;
            left: 0;
            max-height: 135px;
            overflow: hidden;
        }

        .modal-content {
            width: 95%;
            top: 52%;
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
            margin-top: 0px;
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

        #gehaPage #product-list.grid-changed .medium-12.thb-dark-col
        umn.small-12.landing-product .product-selection-description-parent-inner .btn-primary-blue {
            font-size: 14px;
        }

        #gehaPage .gehaPageBanner {
            margin-top: 0px;
            padding-bottom: 20px;
        }

        .custom-select .dropdown-wrapper {
            margin-bottom: 35px;
        }

        #gehaPage .ultrasonic-text-contain-by-js .backOrderList{
            top: -50px;
        }

        .ultrasonic-text-contain-by-js .backOrderList{
            top: -51px;
        }
        #product-list.grid-changed .ultrasonic-text-contain-by-js .backOrderList {
            line-height: 14px;
            top: -65px;
        }


    }

    .gehaTextmember {
        max-width: 230px;
        margin-left: auto;
        margin-right: auto;
    }
</style>


<div class="gehaTemplate active-recomendation-tab" id="gehaPage">
    <?php

    if ($insuranceLanderFlag) {
        $page_id = INSURANCE_REC_PAGE_ID; // Replace 123 with the ID of the page you want to retrieve
        $page = get_post($page_id);
        if ($page) {
    ?>
            <style>
                @media (min-width: 768px) {
                    #gehaPage section.shopLanderPageHader .pageheaderTop {
                        margin-top: 73px;
                    }
                }
            </style>
            <section class="shopLanderPageHader">

                <div class="pageHeader">

                    <div class="whitening-teeth-girl-with-smile mobileOptionDisplay show-mobile">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
                    </div>

                    <div class="pageheaderTop" style="background:#65657f">

                        <div class="row no-flex">
                            <h1 class="font-mont weight-500 text-uppercase text-white">Insurance <span style="color: #b8b8dc;">MEMBER</span> DISCOUNTS</h1>
                            <p class="open-sans text-white">Welcome insurance member! Save up to 60% on Teeth Whitening & Oral Care!</p>
                            <div class="whitening-teeth-girl-with-smile hidden-mobile">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
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
        } else {

                ?>
                <section class="gehaPageBanner">
                    <div class="container">
                        <div class="rowMbt mt-100 insurance-wrapper-padding-top">
                            <div class="col-sm-8 geha-banner-text-section-parent">
                                <div class="geha-banner-text-section">
                                    <p class="font-mont text-white text-orange">EXCLUSIVE DISCOUNTS</p>
                                    <h1 class="gehaLogoLarge text-white">
                                        HAVE MEDICAL <br> <span> <i>or</i> </span> <br> DENTAL INSURANCE?

                                    </h1>
                                    <h2 class="font-mont text-white"> <span class="text-orange">More than 35 insurance providers</span> are eligible for exclusive discounts <br>
                                        on professional teeth whitening, night guards & oral care.<br> <span class="text-orange"> Save up to 60%! </span></h2>
                                    <div class="custom-select">

                                        <!-- <div class="select-dropdown">
                                        <select name="insurance" id="insurance-select">
                                            <option value="">Select your insurance provider:</option>
                                            <option value="Option1">2nd Option</option>
                                            <option value="Option2">Option Number 3</option>
                                        </select>
                                    </div> -->
                                        <div class="dropdown-wrapper">

                                            <p class="dropdown-heading toggle"> <span>Select your insurance provider:</span>
                                                <i class=" fa fa-chevron-down"></i>
                                            </p>
                                            <div class="icon-wrapper ">
                                                <div class="dropdown-content">
                                                    <ul>
                                                        <!-- <li>
                                                            <input path="0" type="radio" name="insurance" id="General Insurance" onclick="updateDropdownHeading(this)">
                                                            <label for="General Insurance">General Insurance</label>
                                                        </li> -->
                                                        <!-- <li>
                                                            <input path="0" type="radio" name="insurance" id="No Insurance" onclick="updateDropdownHeading(this)">
                                                            <label for="No Insurance">Don't Have Insurance</label>
                                                        </li> -->
                                                        <?php

                                                        if ($insuranceArray) {
                                                            foreach ($insuranceArray as $image_path => $insurance_title) {
                                                                echo '<li>';
                                                                echo '<input path="' . $childThemePathUrl . '/' . $image_path . '" type="radio" name="insurance" id="' . $insurance_title . '" onclick="updateDropdownHeading(this)">';
                                                                echo '<label for="' . $insurance_title . '">';
                                                                echo '<img title="' . $insurance_title . '" style="width: 100px;" src="' . $childThemePathUrl . '/' . $image_path . '" />';
                                                                echo  $insurance_title;
                                                                echo '</label>';
                                                                echo '</li>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <li>
                                                            <input path="0" type="radio" name="insurance" id="Other Insurance" onclick="updateDropdownHeading(this)">
                                                            <label for="Other Insurance">Other Insurance</label>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- <div class="gehaLoginCustomer">
                                        <h3 class="font-mont">PAST CUSTOMER? <a href="/my-account/">Login</a> </h3>
                                    </div> -->

                                </div>
                            </div>
                            <div class="col-sm-8 graphicImagePeople" style="display: none;">
                                <img src="<?php // echo get_stylesheet_directory_uri(); 
                                            ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" alt="" data-src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/insurance-lander/our-customer-banner-image.webp" decoding="async" class="">
                            </div>

                            <div class="whitening-teeth-girl-with-smile col-sm-8 graphicImagePeople" style="display: none;">
                                <img src="<?php // echo get_stylesheet_directory_uri(); 
                                            ?>/assets/images/insurance-lander/geha-banner-top-section-graphic-small.png" alt="" data-src="<?php // echo get_stylesheet_directory_uri(); 
                                                                                                                                            ?>/assets/images/insurance-lander/geha-banner-top-section-graphic.webp" decoding="async" class="lazyload">
                            </div>

                        </div>

                        <div class="logos-wrapper your-class">
                            <div class="logo logo1">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/hsbc.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/hsbc.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo2">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/highmark.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/highmark.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/anthem.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/anthem.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/centene.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/centene.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo5">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/aetna.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/aetna.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo6">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/delta.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/delta.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo7">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/humana.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/humana.png" decoding="async" class="lazyload">

                            </div>
                            <div class="logo logo8">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/kaiser.png" alt="" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/kaiser.png" decoding="async" class="lazyload">

                            </div>
                        </div>
                    </div>
                </section>
                <section class="sectionProductDisplay">
                    <div class="container">
                        <div class="rowMbt">
                            <div class="col splitTwo productGripgSectionWrapper">
                                <div class="productGripgSection">
                                    <h3 class="font-mont text-white text-center">SAVE UP TO 60%</h3>
                                    <ul class="font-mont text-white">
                                        <li>Electric Toothbrushes & Water Flossers</li>
                                        <li>Professional Teeth Whitening Trays</li>
                                        <li>Custom-fitted Night Guards</li>
                                        <li>Solutions for Sensitive Teeth</li>
                                        <li>Solutions for Bad Breath</li>
                                        <li>Toothpaste & Mouthwash</li>

                                    </ul>
                                    <div class="seeDiscountBtn text-center">
                                        <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE YOUR DISCOUNTS</button>
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
                        <h2 class="font-mont" style="color:#378abf;">OUR CUSTOMERS SPEAK FOR US</h2>
                        <h3>Nearly <span style="color:#eb6754;font-weight:600">1 million happy customers</span> have relied on Smile Brilliant to<br>
                            improve their oral health & create a beautiful white smile!</h3>

                        <div class="customer-before-after-image">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/our-customer-banner-image.webp" alt="" class="" />
                        </div>

                        <div class="seeDiscountBtn text-center seeDiscountBtn3">
                            <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE INSURANCE DISCOUNTS</button>
                        </div>

                    </div>
                </section>

                <section class="ourSuportedCustomers product-logo-wrapper  smilePageIconSection smilePageIconSection-parent-div ">
                    <div class="hidden-mobile">
                        <div class="container">
                            <div class="rowMbt extra_logo_before-top logo-strip-one justify-conten">
                                <div class="boxSecBox box-with-extra-logo spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-health.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-forbes.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-fox.png" alt="" class="" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-new-work-post.png" alt="" class="" />
                                </div>
                            </div>

                            <div class="rowMbt second-row extra_logo_before extra_logo_after_small logo-strip-two justify-conten">
                                <div class="medium-3 boxSecBox spacing-left-emphty col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-circle.png" alt="" class="" />
                                </div>
                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-client.png" alt="" class="" />
                                </div>

                                <div class="medium-3 col-md-3 col-4">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-the-knot.png" alt="" class="" />
                                </div>
                                <div class="medium-3 col-md-3 col-4 boxSecBox box-with-extra-logo-right wpb_column columns medium-3 thb-dark-column small-12">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-allure.png" alt="" class="" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container show-mobile logoesformobileOnly">
                        <div class="rowMbt  justify-conten alin-items-center">
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-tiktok.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-health.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-forbes.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-fox.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-new-work-post.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-circle.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-client.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-the-knot.png" alt="" class="" />
                            </div>
                            <div class="col-4">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/insurance-lander/logoes-allure.png" alt="" class="" />
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
                                    <h3 style="text-align: center" class="vc_custom_heading">TRY IT. <span style="color:#eb6754;">LOVE IT</span> ...or return it</h3>
                                    <div class="vc_wp_text wpb_content_element warrabty-text-container">
                                        <div class="widget widget_text">
                                            <div class="textwidget">
                                                <p>Smile Brilliant is America's #1 brand of customized oral care products and a
                                                    proud partner of Insurance. All clients, their children, domestic
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
                                                <div class="seeDiscountBtn text-center seeDiscountBtn2">
                                                    <button class="btn btn-primary-blue btn-lg scroll-link" href="#gehaform">SEE INSURANCE DISCOUNTS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="gehanFormSection show-div" id="gehaform">
                    <div class="container">
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <div class="container-form">
                            <form id="geha_discount_registration_form">
                                <div class="row form-steps fullWidth">
                                    <div class="col-sm-12 tp-head-form">
                                        <div class="logo" id="form_insurance_logo_h1">
                                            <h1 class="gehaLogoLarge">
                                                <img id="form_insurance_logo" src="" alt="insurance" class="" />
                                            </h1>
                                        </div>
                                        <h5 class="font-mont text-white">DISCOUNT AVAILABILTY FORM</h5>
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
                                        <input type="text" maxlength="10" id="entryGehaMemberId" value="" placeholder="Member ID:" name="member_id" class="form-control input-lg">
                                    </div>

                                    <div class="col-md-6 form-group member-ids">
                                        <label for="entryGehaMemberIdConfirm" class="control-label">Confirm Member ID (Last 4
                                            Digits)</label>
                                        <input type="text" maxlength="10" id="entryGehaMemberIdConfirm" value="" placeholder="Confirm Member ID (Last 4 Digits)" name="confirm_member_id" class="form-control input-lg">
                                    </div>

                                    <div class="col-md-12 text-center form-notes">
                                        <p class="text-white">Your name and Member ID will be used to confirm account status. member ID may be listed on your ID card under "Member ID" or "ID"</p>
                                    </div>

                                    <div class="col-md-12 sep-top-sm text-center seeDiscountBtn text-center seeDiscountBtn4">
                                        <button type="submit" class="btn btn-primary btn-primary-purple-drk btn-primary-geha" id="send-my-discount">REGISTER</button>
                                        <div id="register-loader" class="loader"></div>
                                    </div>

                                    <div class="gehaLoginCustomer w-100 text-center">
                                        <h3 class="font-mont">ALREADY A PAST CUSTOMER? <a href="/my-account/">Login</a> </h3>
                                    </div>


                                </div>
                                <input type="hidden" name="source" id="insurnce_source" value="">
                                <input type="hidden" name="source_page_id" id="page_id" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="campaign" id="campaign" value="">
                                <input type="hidden" name="medium" id="medium" value="">
                                <input type="hidden" name="insurance_lander" id="insurance_lander" value="yes">
                                <input type="hidden" name="action" value="add_partner_user">

                            </form>
                            <div class="row after-success">
                                <h1 class="font-mont text-white">YOUR DISCOUNT CODE HAS BEEN GENERATED!
                                </h1>
                                <p class="text-white">Your unique insurance discount code has been created and is listed below (it has also been sent to you
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
                <script>
                    let toggle = function() {
                        var dropdownWrapper = document.querySelectorAll('.dropdown-wrapper')[0];
                        dropdownWrapper.classList.toggle('active');

                        // Get the dropdown content and toggle its display
                        var dropdownContent = dropdownWrapper.querySelector('.dropdown-content');
                        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
                    }

                    document.querySelectorAll('.toggle')[0].addEventListener("click", toggle);

                    // Add this function to close the dropdown when clicking outside
                    function closeDropdownOnClickOutside(event) {
                        var dropdownWrapper = jQuery('.dropdown-wrapper');
                        if (!dropdownWrapper.is(event.target) && dropdownWrapper.has(event.target).length === 0) {
                            dropdownWrapper.find('.dropdown-content').hide();
                        }
                    }

                    // Attach the event listener to the document body
                    jQuery(document).on('click', function(event) {
                        closeDropdownOnClickOutside(event);
                    });

                    // Modify your existing function to update the dropdown and close it when necessary
                    function updateDropdownHeading(radio) {
                        var current_val = jQuery(radio).attr('id');

                        var dropdownWrapper = jQuery('.dropdown-wrapper');
                        dropdownWrapper.find('.dropdown-heading span').html(current_val);
                        var dropdownContent = dropdownWrapper.find('.dropdown-content');
                        dropdownContent.hide();

                        if (current_val !== "") {

                            var path = jQuery(radio).attr('path');
                            jQuery('body').find('#insurnce_source').val(current_val);
                            if (path != 0) {
                                jQuery('body').find('#form_insurance_logo').attr('src', jQuery(radio).attr('path'));
                                jQuery('body').find('#insurance_popup').attr('src', jQuery(radio).attr('path'));
                                jQuery('body').find('#form_insurance_logo_h1').show();
                            } else {
                                jQuery('body').find('#form_insurance_logo_h1').hide();
                            }
                            jQuery('body').find('.seeDiscountBtn').show();
                            jQuery('body').find('.show-div').show();
                            jQuery('#gehaform').show();
                            //toggleModal();
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#gehaform").offset().top - 90
                            }, 500);
                        } else {
                            jQuery('body').find('.seeDiscountBtn').hide();
                            jQuery('body').find('.show-div').hide();
                            jQuery('#gehaform').hide();
                        }

                        /*
                                setTimeout(function() {
                                    var formSection = jQuery('#gehaform');
                                    var topOffset = -90;
                                    var scrollPosition = formSection.offset().top + topOffset;

                                    jQuery('html, body').animate({
                                        scrollTop: scrollPosition
                                    }, 500); // Adjust the duration as needed
                                }, 100);

                        */
                    }

                    // Prevent the click event inside the dropdown from closing it
                    jQuery('.dropdown-wrapper .dropdown-content').on('click', function(event) {
                        event.stopPropagation();
                    });

                    // Optionally, you can close the dropdown when the user presses the 'Esc' key
                    jQuery(document).on('keydown', function(event) {
                        if (event.key === 'Escape') {
                            jQuery('.dropdown-wrapper .dropdown-content').hide();
                        }
                    });
                </script>
            <?php } ?>

                </div>
            </div>





            <?php
            // Start the loop
            while (have_posts()) : the_post();
            echo apply_filters('the_content', get_the_content());

            endwhile; // End of the loop.
            ?>


            <div class="disclaimer-bar-purple">
                <div class="container">
                    <p>
                        “These benefits are not guaranteed under contract. Smile Brilliant does not have any affiliation with the insurance providers listed. These discounts are offered solely at the discretion of Smile Brilliant Ventures, Inc and are offered for promotional purposes.”
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
                    <img src="" id="insurance_popup" alt="insurance" class="" />
                </h1>
                <p class="memeberGranted">MEMBER DISCOUNT ACCESS GRANTED</p>
                <h2 class="youreInText">YOU’RE IN!</h2>
                <h3 class="pleaseRed">please read:</h3>
                <p class="descriptionBody">Welcome insurance member! You now have access to exclusive insurance discounts. An email has also been sent to you with your account login details. To view your discounts in the future, simply login. Our live chat and customer support team is also here to help!<br><br>
                    <strong>CLICK THE BUTTON BELOW TO VIEW THE DISCOUNT PAGE</strong>
                </p>
                <div class=" sep-top-sm text-center seeDiscountBtn text-center" id="see-discount-loder">
                    <a href="<?php echo site_url('insurance?insurance_user=yes'); ?>" class="btn" id="seeDiscountsBtn">SEE DISCOUNT PAGE</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-loader">
    <div class="loader" id="popup_loader"></div>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


<script>
    //select insurance script end

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

        jQuery(document).on('click', '#see-discount-loder a', function() {
            jQuery('body').addClass("loader-activate");
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


    // backorder on ultrasonic product           
        var productBoxes = jQuery('#product-list .product-selection-box');
        // Iterate through each product-selection-box
        productBoxes.each(function() {
        // Check if the text content includes "Ultrasonic"
        if (jQuery(this).text().includes('Ultrasonic')) {
            // Add the 'highlight' class
            jQuery(this).addClass('ultrasonic-text-contain-by-js');
        }
        });        

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
            show();
        }
    }

    closeButton.addEventListener("click", toggleModal);
    window.addEventListener("click", windowOnClick);


    jQuery(document).on('click', '#send-my-discount', function(e) {
        e.preventDefault();
        hasserror = false;
        jQuery('#geha_discount_registration_form input').each(function() {
            var input_name = jQuery(this).attr('name');

            if (input_name != 'campaign' && input_name != 'medium') {
                console.log(input_name);
                if (jQuery(this).val() == '') {
                    jQuery(this).addClass('has_error');
                    hasserror = true;
                } else {
                    jQuery(this).removeClass('has_error');

                }
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
            success: function(response) {
                console.log(response);
                jQuery('#register-loader').hide();
                if (response.status == true) {
                    try {

                        window._learnq = window._learnq || [];
                        window._learnq.push(['identify', {
                            '$email': jQuery('#entryEmail').val(),
                            '$first_name': jQuery('#entryFastName').val(),
                            '$last_name': jQuery('#entryLastName').val()
                        }]);
                        window._learnq.push(["track", "Insurance Lander", {}]);

                    } catch (err) {}
                    //   fbq('track', 'user_signup');
                    var user_name = jQuery('body').find('#entryFastName').val() + ' ' + jQuery('body').find('#entryLastName').val();
                    fbq('track', 'Lead', {
                        content_name: 'user_signup',
                        content_category: 'signup',
                        content_type: 'form',
                        value: 0, // You can set a value if applicable
                        currency: 'USD', // Change to your currency
                        // Add custom user details
                        user_email: jQuery('body').find('#entryEmail').val(),
                        user_name: user_name,
                        member_id: jQuery('body').find('#entryGehaMemberId').val(),
                        insurance: response.source,
                    });

                    dataLayer.push({
                        'event': 'insurance_lead',
                        'event_category': 'User Interaction',
                        'event_label': 'insurance_lead',
                        'value': 0,
                        'customerFirstName': jQuery('body').find('#entryFastName').val(),
                        'customerLastName': jQuery('body').find('#entryLastName').val(),
                        'customerBillingEmail': jQuery('body').find('#entryEmail').val(),
                        'insurance': response.source,
                        'member_id': jQuery('body').find('#entryGehaMemberId').val(),
                        'visitorId': response.customer_id
                    });

                    if (response.source == 'geha') {
                        console.log('here is geha');
                        jQuery('body').find('#seeDiscountsBtn').attr('href', '<?php echo site_url("geha?utm_campaign=userExists"); ?>');
                    }

                    jQuery('#geha_discount_registration_form').hide();
                    toggleModal();
                    setCookiePartner('insurance_lander', 'yes', 2000, '/');
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
        var insurance_lander_price = $(this).attr('data-insurance_lander_sale_price');
        if (typeof insurance_lander_price !== 'undefined' && insurance_lander_price !== false && insurance_lander_price != '' && insurance_lander_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-insurance_lander_price', insurance_lander_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-insurance_lander_price');
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

    jQuery('.your-class').slick({
        slidesToShow: 3,
        arrows: false,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        pauseOnHover: false,
        cssEase: 'linear',

        responsive: [{
                breakpoint: 9999,
                settings: "unslick"
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    arrows: false,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 0,
                    speed: 8000,
                    pauseOnHover: false,
                    cssEase: 'linear',
                }
            },

        ]
    });
</script>
<?php

get_footer();

?>