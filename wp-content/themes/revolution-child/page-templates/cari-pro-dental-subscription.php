<?php
/*Template Name:  Geha Probiotic Landar demo */

$html = '';
// Access the product_id passed from the calling template file
if (isset($args['product_id'])) {
    // Now you can use $product_id in this template
    $product_id = $args['product_id'];
} else {
    $product_id = PROBIOTIC_1BOTTLE_PRODUCT_ID;
}
$discount_data = [];
$_product = wc_get_product($product_id);
$discount_amount = isset($args['discount_amount']) ? $args['discount_amount']:'';
$discount_type = isset($args['discount_type']) ? $args['discount_type']:'';
$call_from_page = isset($args['call_from_page']) ? $args['call_from_page']:'geha';
if($discount_type!='' && $discount_amount!=''){    
    $all_pids = PROBIOTIC_SUBSCRIPTION_PRODUCTS;
    // $probiotic_products = PROBIOTIC_SUBSCRIPTION_PRODUCTS;  // Assuming this is already defined somewhere
    // $enamelarmour_products = ENAMELARMOUR_SUBSCRIPTION_PRODUCTS; 
    // $sportsguard_products = SPORTSGUARD_PRODUCTS;
    // $all_pids = array_merge($probiotic_products, $enamelarmour_products, $sportsguard_products);

    foreach($all_pids as $pidd){
        $rate_sale = (int) $discount_amount;
        $pprice =   get_post_meta($pidd, '_price', true);
        $ppriceCalculation = get_post_meta($pidd, '_regular_price', true);
        if($pprice!=$ppriceCalculation){
           // continue;
        }
        $discount  = 0;

        if ($discount_type == 'percentage') {
            $discount = ($ppriceCalculation * $rate_sale) / 100;
            $discounted_price = $ppriceCalculation - $discount;
        } elseif ($discount_type == 'fixed') {
            $discount = $rate_sale;
            $discounted_price = $ppriceCalculation - $rate_sale;
        } else {
            $discount = 0;
            $discounted_price = $ppriceCalculation;
        }

        if ($discount > get_post_meta($pidd, '_price', true)) {
            $discount = get_post_meta($pidd, '_price', true);
        }
        $sale_price =  get_post_meta($pidd, '_price', true) - $discount;
        // only for geha
        //if($discount>0 && $GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID ){
            if($discount>0){
            $sale_price =  get_post_meta($pidd, '_regular_price', true) - $discount;
        }
        // update_post_meta($pidd,'geha_discounted_price_probiotics',$sale_price);
        update_post_meta($pidd,$call_from_page .'_discounted_price_probiotics',$sale_price);
        $discount_data[$pidd]=$sale_price;
    }
}

                $regularPrice = $_product->get_regular_price();
                $salePrice =  $_product->get_sale_price();
                $variant = 0;
                $variantAttr = '';
            
                $enable_google_optimize = get_field('enable_service', 'option');
                if ($enable_google_optimize) {
                    if ($productType == 'tray-system') {
                        $infoData =  getOptimizeAttr($productType);
                        $variant = $infoData['variant'];
                        $variantAttr = $infoData['attr'];
                    }
                }
                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);
                        $regularPrice = $regularPrice + ($optimizeVal);
                        if ($_product->is_on_sale()) {
                            $salePrice = $_product->get_sale_price() + ($optimizeVal);
                        }
                        break;
                    case 1:

                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);
                        $regularPrice = $regularPrice + ($optimizeVal);
                        if ($_product->is_on_sale()) {
                            $salePrice = $_product->get_sale_price() + ($optimizeVal);
                        }
                        break;

                    default:
                        # code...
                        break;
                }

 if ($_product->is_on_sale()) {

    $html .= '<span class="product-selection-price-text">';
    $html .= '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
    $html .= $regularPrice;
    $html .= '</bdi></span></del>';

    $html .= '<ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
    $html .= $salePrice;
    $html .= '</bdi></span></ins>';
    $html .= '</span>';
} else {
    $html .= '<i role="presentation" class="product-selection-price-dollar-symbol"><span>$</span></i>';
    $html .= '<span class="product-selection-price-text">' . $regularPrice . '</span>';
}


?>

<style>
    .subscription-badge {
        display: flex;
        justify-content: center;
        position: relative;
        top: 53px;
    }

    .subscription-badge span {
        display: inline-block;
        max-width: 350px;
        background: #002244;
        padding: 2px 20px;
        border-radius: 6px;
        color: #fff;
        font-family: 'montserrat';
        font-weight: 500;
    }

    .subscription-product-detail {
        /* margin: 40px 0px;
        border: 1px solid #c5c6c9;
        border-radius: 12px; */
        display: flex;
        /* max-width: 100%;
        padding: 40px 30px 40px 40px; */

    }

    .subscription-product-detail .caripro-content {
        text-align: center;
        width: 40%;
    }

    .rating-stars {
        margin-top: 0px;
        margin-bottom: 4px;
    }

    .subscription-product-detail .caripro-content img {
        margin-top: 40px;
    }

    .mbl-img {
        display: none;
    }

    .subscription-product-wrapper .rating-stars i {
        font-size: 18px;
    }

    .rating-stars i {
        color: #fbf046;
    }

    .subscription-product-detail .caripro-content h1 {
        font-size: 30px;
        color: #002244;
    }

    .desktop-hidden {
        display: none;
    }

    .product-skincare p {
        color: #2d2e2f;
        font-size: 16px;
    }

    .subscription-product-detail .caripro-content p {
        font-family: 'montserrat';
        font-weight: 400;
        position: relative;
    }

    .subscription-product-detail .caripro-content p:after {
        content: '';
        width: 135px;
        height: 6px;
        background-color: #0eb4ba;
        border-radius: 3px;
        position: absolute;
        top: 40px;
        right: 37%;
    }

    .fruit-content {
        width: 21%;
        padding-left: 0px;
        padding-top: 20px;
        margin-left: 125px;
        margin-left: 90px;
    }

    .fruit-content-header {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .fruit-content .header-content p {
        padding-left: 10px;
        font-size: 13px;
        margin-bottom: 0px;
        padding-right: 7px;
    }

    .fruit-content .header-content img {
        padding-left: 10px;
        padding-top: 10px;
    }

    .fruit-content .middile-content {
        padding-top: 20px;
    }

    .fruit-content .middile-content p {
        color: #616264;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .fruit-content .middile-content p.berry-falour {
        color: #9e1e82;
        font-weight: 500;
    }

    .middile-content img {
        margin-top: 20px;
    }

    .subscription-product {
        width: 30%;
        margin-left: 30px;
    }

    .subscription-product-inner-wrapper {
        border: 1px solid #c5c6c9;
        border-radius: 12px;
    }

    .subscription-product-header {
        background: #effafa;
        padding-right: 10px;
        padding-left: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid #eee;
    }

    .ninety-day-subscription .white-background,
    .subscribe-save .white-background,
    .one-time-offer .white-background {
        background-color: #fff;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .ninety-day-subscription .subscription-product-header {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .subscription-product-detail [type="radio"]:checked,
    .subscription-product-detail [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }

    .subscription-product-detail [type="radio"]:checked+label,
    .subscription-product-detail [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;

    }

    .subscription-product-detail [type="radio"]:checked+label:before,
    .subscription-product-detail [type="radio"]:not(:checked)+label:before {
        content: '';
        position: absolute;
        left: 1px;
        top: 7px;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: transparent;    background: #fff;
    }

    .subscription-product-detail [type="radio"]:checked+label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #68c8c7;
        position: absolute;
        top: 10px;
        left: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    .subscription-product-detail [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .subscription-product-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .subscription-product-header-top p,
    .subscription-product-header-bottom p {
        margin-bottom: 0px;
    }
    .subscription-product-header-bottom {

    display: none;
}
    .subscription-product-header-top p {
        font-size: 14px;
    }
    .subscription-product-header {
    text-align: left;
}
    .white-background .subscription-title {
        font-weight: 600;
    }

    .subscription-product-header-top .main-price {
        font-size: 21px;
    }

    .subscription-product-header-top p span {
        /* font-size: 14px; */
    }
    span.pricingDiscountMbt del {
        color: #c6c9cd;
        text-decoration-color: #9e1e82;  font-size: 18px;
    }


    span.originalPriceut {
    display: inline-flex;
    margin-right: 6px;
}   
    .subscription-product-content-body {
        display: none;
    }
    .dollerSymbal{ font-size: 14px;}

    .subscription-product-content ul {
        list-style: none;
        padding: 5px 15px 0px 25px;
        margin-bottom: 5px;
    }

    .subscription-product-content ul li {
        font-size: 12px;
    }

    .subscription-product-footer {
        padding: 10px;
    }

    .subscription-product-footer .btn-primary-teal.btn-lg {
        width: 100%;
        /* background-color: #9e1e82;
        border-color: #9e1e82;
        border-radius: 10px; */
        letter-spacing: 0;
    }

    .subscribe-save {
        background-color: transparent;
    }

    .select-probiotic-content-subscription {
        padding: 10px 10px 0px 10px;
    }

    .subscription-product-content label {
        padding-left: 10px;
    }

    .select-probiotic-content-subscription select {
        border-radius: 15px;
        margin-bottom: 10px;
        line-height: 40px;
        height: 40px;
        background: #f1f2f2 url(../images/products/new-dental-probiotic/select_arrow.png) calc(100% - 8px) 19px no-repeat !important;
        background-size: 9px 5px;
        border-color: #c5c6c9;
        box-shadow: 0px 13px 10px -15px #111;
        font-family: 'Montserrat', 'BlinkMacSystemFont', -apple-system, 'Roboto', 'Lucida Sans';
    }

    .selectPackageWrapper.subscription-product-popup.subscription-product-detail {
        margin: 0;
        border: 0;
        padding: 0;
        display: initial;
    }

    .subscription-product-popup .subscription-product-header {
        /* background-color: #fff; */
        padding-right: 0px;
        padding-left: 0px;
        padding-bottom: 0;
        border-bottom: 1px solid #fff;
    }

    .subscription-product-popup .subscription-product-inner-wrapper {
        border: 0px;
    }

    #wrapper .subscription-product-popup .select-probiotic-content-subscription label {
        display: none;
    }

    #wrapper .productLandingPageContainer .subscription-product-popup .packageheader {
        position: absolute;
        right: -16px;
        top: -18px;
        z-index: 1;
    }

    #wrapper .productLandingPageContainer .subscription-product-popup .packageheader a.iconCloseBox {
        background: #bdbdbd;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border-radius: 25px;
    }



    #wrapper .subscription-product-detail.subscription-product-popup .caripro-subscription-product-box label {
        margin-bottom: 0;
        padding-right: 16px;
        padding-left: 36px;

    }


    .subscription-product-detail.subscription-product-popup [type="radio"]:checked+label:before,
    .subscription-product-detail.subscription-product-popup [type="radio"]:not(:checked)+label:before {
        left: 8px;
        top: 15px;
        background: #fff;
    }

    .subscription-product-detail.subscription-product-popup [type="radio"]:checked+label:after {
        left: 11px;
        top: 18px;
        background: #9e1e82;
    }


    .subscription-product-detail.subscription-product-popup [type="radio"]:checked+label {
        background: #f6f1f9;
    }

    .subscription-product-detail.subscription-product-popup [type="radio"]:checked+label,
    .subscription-product-detail.subscription-product-popup [type="radio"]:not(:checked)+label {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .subscription-product-popup .subscription-product-header-top .main-price {
        font-size: 16px;
        font-weight: 700;
        color: #68c8c7;
    }

    .subscription-product-detail.subscription-product-popup [type="radio"]:checked+label .main-price {
        color: #9e1e82;
        font-family: 'Montserrat';
    }

    .subscription-product-popup .subscription-product-header-top p {
        font-family: 'Montserrat';
        font-weight: 600;
    }

    .subscription-product-popup .subscription-product-header-top p:after{
        opacity: 0;
    }

    .subscription-product-popup .subscription-product-content ul li {
        font-size: 14px;
        text-align: left;
    }

    .subscription-product-popup .subscription-product-content-body {
        background: #fff;
    }

    .subscription-product-popup .selectPackageBoxWrapper,
    .subscription-product-popup .subscription-product-inner-wrapper {
        height: calc(100% - 0px);
    }

    .subscription-product-popup .subscription-product-content-body[style*="display: block;"] {
        /* background-color: lightblue; */
        /* height: calc(25.5vh - 93px); */
    }

    .subscription-product-popup .ninety-day-subscription .white-background,
    .subscription-product-popup .subscribe-save .white-background,
    .subscription-product-popup .one-time-offer .white-background {
        background-color: #effafa;
    }

    #wrapper .productLandingPageContainer .subscription-product-popup .selectPackageBox {
        border-top: 0px;
        background: #ffffff;
        padding: 0;

    }


    #product-list.grid-changed .fruit-content,
    #product-list.grid-changed .rating-stars {
        display: none;
    }

    #product-list.grid-changed .subscription-product-detail .caripro-content {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    #product-list.grid-changed .subscription-product {
        width: 100%;
        display: none;
    }



    #product-list.grid-changed .product-image-caripro {
        order: 1;
    }

    #product-list:not(.grid-changed) .caripro-content-splitter .product-selection-price-wrap,
    #product-list.grid-changed .caripro-product-outer .sub-heading-cari-pro {
        display: none;
    }

    #product-list.grid-changed .caripro-product-outer h1 {
        font-size: 16px;
        text-transform: uppercase;
        padding-right: 15px;
        max-height: 44px;
        overflow: hidden;
        min-height: 44px;
        display: flex;
        align-items: end;
        justify-content: start;    color: #565759;
    }

    #product-list.grid-changed .caripro-content-splitter {
        min-height: 130px;
        max-height: 130px;
        background: #f1f1f8;
        padding: 15px;
        margin-left: -15px;
        margin-right: -15px;
        justify-content: space-between;
        order: 2;
        display: flex;
    }
    #product-list:not(.grid-changed) .for-only-grid-view{ display: none;}
    .subscription-product-header-bottom {
    display: flex;
    justify-content: space-between;
    align-items: end;
}
.subscription-product-header-bottom .sale {
    background: #9e1e82;
    padding: 1px 20px;
    border-radius: 12px;
}
.subscription-product-header-bottom .sale p {
    font-size: 10px;
    color: #fff;
    font-weight: 400;
}

.subscription-product-header-bottom .sale-text p {
    font-size: 12px;
    font-style: italic;
    color: #9e1e82;
    font-weight: 500;
}

#product-list.grid-changed .subscription-product-detail .caripro-content p:after{
    width: 0;
}
.subscription-product-inner-wrapper .one-time-offer .subscription-product-header{
    border-radius: 0px 0px 12px 12px;
}

#product-list .medium-12  .cariPro_dental_probiotics_byJs .featureTag{
    display: inline-block;
    max-width: 350px;
    background: #002244;
    padding: 2px 20px;
    border-radius: 6px;
    color: #fff;
    font-family: 'montserrat';
    font-weight: 500;
}

#product-list.grid-changed .medium-12 .product-selection-price-dollar-symbol{
    font-size: 20px;
    font-weight:400;
    font-weight: normal;
    color: #565759;
    font-style: normal;
    font-family: Montserrat;
}

#gehaPage #product-list.grid-changed .medium-12 .product-selection-price-text{
    font-size: 28px;
    font-weight: 400;
    color: #565759;
}

.floting-geha-button {
    display: none;
}




   @media only screen and (max-width: 1199px) and (min-width: 768px) {

    #product-list:not(.grid-changed) [data-cats="dental-probiotics,only-google-feed,adults-probiotics"] .subscription-product-detail .caripro-content {
        text-align: center;
        width: 65%;
    }
    #product-list:not(.grid-changed) [data-cats="dental-probiotics,only-google-feed,adults-probiotics"]  .subscription-product {
            width: 35%;

        }

        #product-list:not(.grid-changed) [data-cats="dental-probiotics,only-google-feed,adults-probiotics"]   .subscription-product-detail {
            justify-content: space-between;
            width: 100%;
        }

        
   }

    @media only screen and (min-width: 768px) {
        #wrapper .productLandingPageContainer .subscription-product-popup .selectPackageBox {
            height: 100%;
        }
        .desktop-img {
            /* display: none; */
        }
    }

    @media (max-width: 1199px){
        .fruit-content {
            display: none;
        }
    }

    



    @media only screen and (max-width: 767px) {
        .subscription-product-popup .subscription-product-header-top .main-price{
            font-size: 14px;
            display: flex;
            align-items: center;            
        }
        span.pricingDiscountMbt del{
            font-size: 15px;
        }
        .subscription-product-header-top .main-price {
            font-size: 18px;
        }
        .subscription-product-header-top p span {
            /* display: flex;
            align-items: center; */
        }

        .mobile-hide {
    /* display: none !important; */
}
#gehaPage #product-list:not(.grid-changed).productLandingPageContainer .medium-12 .product-selection-description b {

    font-size: 24px;
}
        #product-list:not(.grid-changed ).productLandingPageContainer .medium-12 .caripro-content .product-selection-image-wrap{
            display: none;
        }
        #wrapper .productLandingPageContainer .subscription-product-popup .selectPackageBox {
            border: 1px solid #c5c6c9;
        }

        .subscription-badge {
            top: 30px;
        }

        .subscription-product-detail {

    flex-direction: column;
}
#product-list:not(.grid-changed ) .caripro-content-splitter{
    padding: 20px 20px 0px 20px;
}
#product-list:not(.grid-changed )  .subscription-product{
    padding: 15px;
    padding-top: 0;
    margin-left: auto;
    margin-right: auto;
    padding-right: 5px;
}

#product-list.grid-changed .subscription-product-detail{
    padding: 0px;
}
.subscription-product, .subscription-product-detail .caripro-content {
    width: 100%;
    margin-left: 0px;
}
.mbl-img {
    display: block;
    margin-bottom: 40px;    margin-left: auto;
    margin-right: auto;
}

.subscription-product-detail .caripro-content h1 {
    font-size: 24px;
    color: #002244;
    padding-top: 10px;
}

.desktop-hidden {
    display: block;
}


.product-skincare p {
    font-size: 15px;
}
.subscription-product-detail .caripro-content p::after {
    right: 28%;
}
.subscription-product-detail .fruit-content {
    display: none;
}
p.desktop-img.sub-heading-cari-pro {
    display: none;
}

#product-list.grid-changed p.mbl-img {
    display: none;
}

.subscription-product-detail .caripro-content img {
    margin-top: 0px;
}

#product-list.grid-changed .caripro-content-splitter{ flex-direction: column;     max-height: initial;}
#product-list.grid-changed .caripro-product-outer h1{    justify-content: center;}

#wrapper #product-list.grid-changed.productLandingPageContainer .subscription-product-popup .selectPackageBox{
    height: 100%;;
}
.subscription-product-detail .caripro-content p{
    /* display: none; */
}
#product-list.productLandingPageContainer .subscription-product-detail .caripro-content {
            width: 100%;
        }
        #product-list.productLandingPageContainer .subscription-product {
            width: 100%;
        }




    }
</style>


<div class="subscription-product-detail full-col dentalProBioticProuductWrapper">
    <div class="caripro-content ">
        <div class="caripro-content-splitter ">
            <div class="rating-stars d-flex align-items-center justify-content-center">
                <img class="mbl-img"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/new-dental-probiotic/image.png" />
                <div class="ratig-star-div">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
            <div class="caripro-product-outer">
                <h1>cariPRO <br class="desktop-hidden"> Dental Probiotics</h1>
                <p class="desktop-img sub-heading-cari-pro">ORAL MICROBIOME REJUVENATION THERAPY</p>
                <p class="mbl-img">+30 DAY TRIAL</p>


                <div class="product-selection-price-text-top noflexDiv for-only-grid-view">
                    <?php echo  $html;?>
                    <div class="normalyAmount italic forOnlyLayoutSixDisplay"></div>
                    <div class="featureShippingPrice">+free shipping</div>
                </div>


            </div>

            <div class="selectPackageWrapper subscription-product-popup subscription-product-detail">





                <div class="selectPackageBox">
                    <div class="selectPackageBoxWrapper">
                        <div class="packageheader font-mont">
                            <a href="javascript:;" class="iconCloseBox">
                                &#x2715;
                            </a>
                        </div>

                        <div class="subscription-product-inner-wrapper">
                        <div class="innershortpop">
                        <?php  echo do_shortcode('[dental-probiotics-geha-pop type="adults-probiotics"]');                            
                        ?>
                        </div>

                        </div>

                    </div>
                </div>







                <div class="product-selection-price-wrap selectpackageButton">
                    <button class="btn btn-primary-blue btn-lg select-a-package">Select
                        Quantity</button>
                </div>



            </div>
        </div>
        <div class="product-selection-image-wrap product-image-caripro mobile-hide">
            <img class="desktop-img"
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/new-dental-probiotic/image.png" />
        </div>
    </div>

    <div class="fruit-content">
        <div class="fruit-content-header">
            <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/gurantee-top.png" />

            <div class="header-content">
                <p>See noticeable results in just 90 days or return it for a full refund.</p>
                <img class=""
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/new-dental-probiotic/FSA-Logo-merge.png" />

            </div>

        </div>
        <div class="middile-content">
            <p>Supports natural immune defense</p>
            <p>Supports good breath & gum health</p>
            <p>Helps fight plaque build-up</p>
            <p>Balances oral acidity (pH)</p>
            <p class="berry-falour">Delicious berry flavor!</p>

            <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/new-dental-probiotic/berries.png" />


        </div>

    </div>
    <div class="subscription-product">
        <div class="subscription-product-inner-wrapper">
            <?php
           update_option('probiotics_discounts',$discount_data);
            echo do_shortcode('[dental-probiotics-geha type="adults-probiotics" pids="'.PROBIOTIC_3BOTTLE_PRODUCT_ID.','.PROBIOTIC_2BOTTLE_PRODUCT_ID.','.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" discount="'.$discount_type.','.$discount_amount.'"]');
            ?>
        </div>

    </div>
</div>





<script>
    var pslug = '<?php echo $call_from_page;?>';
   $(document).ready(function () {
    // Remove class outsideClick
    $(document).click(function (event) {
        if (!$(event.target).closest('.selectPackageWrapper').length) {
            $('.openPackage').removeClass('openPackage');
        }
    });

    $(document).on('click', '.packageheader a.iconCloseBox', function () {
        $(this).parents(".selectPackageWrapper").removeClass('openPackage');
    });

    // Option for multiple packages
    $(document).on('click', '.selectpackageButton button', function () {
        $(".selectPackageWrapper").removeClass('openPackage');
        $(this).parents(".selectPackageWrapper").addClass('openPackage');
    });

    // $('.subscription-product-content-body').hide();

    // Show the content body of the initially checked radio button or the one with class default-display
    $('input[name="radio-group"]:checked').closest('.caripro-subscription-product-box').find('.subscription-product-content-body').show();

    // Add event listener to radio buttons with the name "radio-group"
    $('input[name="radio-group"]').change(function () {
        // Hide all subscription-product-content-body elements
        $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-content-body').hide();

        // Get the closest subscription-product-content-body element
        var contentBody = $(this).closest('.caripro-subscription-product-box').find('.subscription-product-content-body');

        // Toggle the visibility of the content body based on the checked state
        contentBody.toggle(this.checked);

        // Remove white background from all checkbox wrappers
        $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-header').removeClass('white-background');

        // Add white background to the selected checkbox wrapper
        if (this.checked) {
            $(this).closest('.subscription-product-header').addClass('white-background');
        }
    });

    $('.loading-sbr').show();

    $('.caripro-subscription-product-box').each(function () {
        var productBox = $(this);

        var product_id = productBox.find('.select-probiotic-content-subscription select[name="subc_quantity"]').val();
        var freq = productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').val();
        var discount = $('#discount_amt').val();
        var disc_type = $('#discount_type').val();

        if (productBox.find('.select-probiotic-content-subscription select[name="subc_quantity"] option:selected').attr("on-sale") == 1) {
            productBox.find("#sale_div2").show();
        } else {
            productBox.find("#sale_div2").hide();
        }

        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'get_subscription_items_data',
                product_id: product_id,
                frequency: freq,
            },
            async: true,
            method: 'GET',
            success: function (response) {
                productBox.find('.loading-sbr').hide();
                productBox.find("#subscription_item_data").val(response);
                localStorage.setItem('subscription_item_data', JSON.stringify(response));

                var options = '';
                var obj = JSON.parse(response);

                $.each(obj.data, function (prod, prodObj) {
                    console.log("PRD:", prod);
                    console.log("product_id:", product_id);
                    if (prod == product_id) {
                        $.each(prodObj, function (key, value) {
                            if(discount > 0){
                                    if(disc_type == 'fixed'){
                                        let new_price = value.price - discount;
                                        value.price = (new_price>0?new_price:value.price);
                                    }else if(disc_type == 'percentage'){
                                        let percent_disc = (value.price*(discount/100));
                                        new_price = value.price - percent_disc;
                                        value.price = (new_price>0?new_price:value.price);
                                    }
                            }
                            if (options == '') {
                                freq = value.frequency;
                                // console.log("i came here 1");
                                setupCariproPrice(productBox, "P2", value.arbid, value.price, product_id, value.reg_price, value.frequency, discount, disc_type);
                            }
                            options += "<option value='" + value.frequency + "' arbid='" + value.arbid + "' data-price='" + value.price + "'>" + value.frequency + " days (most common)</option>";
                        });
                    }
                });

                var old_price = parseFloat(productBox.find("#P2_old_price").html());
                var new_price = parseFloat(productBox.find("#P2_price").html());
                var percent = (new_price > 0 && old_price > 0) ? ((100 - (new_price / old_price) * 100)).toFixed(2) : 0;

                productBox.find("#price_today").html(new_price);
                var period = "";
                if (freq > 7 && freq <= 31) {
                    period = "mo"
                } else if (freq > 28 && freq <= 62) {
                    period = "2 mo(s)"
                } else if (freq > 62 && freq <= 93) {
                    period = "3 mo(s)"
                } else {
                    period = freq + ' days';
                }
                let updated_price = old_price-new_price;
                productBox.find("#after_price").html(new_price + ' /' + period);
                productBox.find("#save_price").html(updated_price.toFixed(2));
                productBox.find("#save_percent").html(percent);
                productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').html(options);
            },
            error: function (xhr) {},
            cache: false,
        });
    });
});

function setupCariproPrice(productBox, btnId, arbId, price, product_id, reg_price, frequency, discount, disc_type) {
    productBox.find("#" + btnId + "_price").html(Number(price).toFixed(2));  
    productBox.find("#" + btnId).attr("data-arbid", arbId);
    productBox.find("#" + btnId + "_old_price").html(reg_price);
    productBox.find("#" + btnId).attr("data-frequency", frequency);
    productBox.find("#" + btnId).attr("data-product_id", product_id);
    productBox.find("#" + btnId).attr("href", "?add-to-cart=" + product_id);
    if(disc_type && discount>0){
        productBox.find("#" + btnId).attr('data-disc_price', price);
        $("#" + btnId + "_pop").attr('data-disc_price', price);
    }

    if (product_id != 711911) {
        productBox.find("#" + btnId).attr("data-action", "woocommerce_add_order_item");
    } else {
        productBox.find("#" + btnId).removeAttr("data-action");
    }
}

function updateOrderSubscriptionItem(element) {
    var productBox = $(element).closest('.caripro-subscription-product-box');
    let product_id = productBox.find('.select-probiotic-content-subscription select[name="subc_quantity"]').val();
    var freq = productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').val();

    let response = '';
    const jsonString = localStorage.getItem('subscription_item_data');
    if (jsonString) {
        response = JSON.parse(jsonString);
        //console.log(response);
    }
    var discount = $('#discount_amt').val();
    var disc_type = $('#discount_type').val();
    var options = '';
    var obj = JSON.parse(response);
    $.each(obj.data, function (prod, prodObj) {
        if (prod == product_id) {
            $.each(prodObj, function (key, value) {
                if(discount > 0){
                        if(disc_type == 'fixed'){
                            let new_price = value.price - discount;
                            value.price = (new_price>0?new_price:value.price);
                        }else if(disc_type == 'percentage'){
                            let percent_disc = (value.price*(discount/100));
                            new_price = value.price - percent_disc;
                            value.price = (new_price>0?new_price:value.price);
                        }
                }
                if (freq == value.frequency) {
                    setupCariproPrice(productBox, "P2", value.arbid, value.price, product_id, value.reg_price, value.frequency, discount, disc_type);
                }
                options += "<option value='" + value.frequency + "' arbid='" + value.arbid + "' " + (freq == value.frequency ? 'selected' : '') + " data-price='" + value.price + "'>" + value.frequency + " days (most common)</option>";
            });
        }
    });

    if (productBox.find('.select-probiotic-content-subscription select[name="subc_quantity"] option:selected').attr("on-sale") == 1) {
        productBox.find("#sale_div2").show();
    } else {
        productBox.find("#sale_div2").hide();
    }

    var old_price = parseFloat(productBox.find("#P2_old_price").html());
    var new_price = parseFloat(productBox.find("#P2_price").html());
    var percent = (new_price > 0 && old_price > 0) ? ((100 - (new_price / old_price) * 100)).toFixed(2) : 0;
    productBox.find("#price_today").html(new_price);

    var period = "";
    if (freq > 7 && freq <= 31) {
        period = "mo"
    } else if (freq > 28 && freq <= 62) {
        period = "2 mo(s)"
    } else if (freq > 62 && freq <= 93) {
        period = "3 mo(s)"
    } else {
        period = freq + ' days';
    }
    let updated_price = old_price-new_price;
    productBox.find("#after_price").html(new_price + ' /' + period);
    productBox.find("#save_price").html(updated_price.toFixed(2));
    productBox.find("#save_percent").html(percent);

    productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').html(options);
}

function addOrderSubscriptionItem() {
    var productBox = $(this).closest('.caripro-subscription-product-box');
    var product_id = productBox.find('.select-probiotic-content-subscription select[name="subc_quantity"]').val();
    var freq = productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').val();
    var discount =  $("#discount_amt").val();
    var disc_type = $("#discount_type").val();

    productBox.find('.loading-sbr').show();

    $.ajax({
        url: "<?php echo admin_url('admin-ajax.php'); ?>",
        data: {
            action: 'get_subscription_items',
            product_id: product_id,
            frequency: freq,
        },
        async: true,
        method: 'GET',
        success: function (response) {
            productBox.find('.loading-sbr').hide();
            data = JSON.parse(response);
            let arbId = data.arbid;
            let price = data.price;
            let reg_price = data.reg_price;
            let frequency = data.frequency;
            productBox.find('.select-probiotic-content-subscription select[name="subc_frequency"]').html(data.options);

            if(discount > 0){
                if(disc_type == 'fixed'){
                    let new_price = price - discount;
                    price = (new_price>0?new_price:price);
                }else if(disc_type == 'percentage'){
                    let percent_disc = (price*(discount/100));
                    new_price = price - percent_disc;
                    price = (new_price>0?new_price:price);
                }
            }
            // console.log("i came here 4");
            setupCariproPrice(productBox, "P2", arbId, price, product_id, reg_price, frequency, discount, disc_type);
        },
        error: function (xhr) {},
        cache: false,
    });
}

var enamel_discounted_prices = '<?php echo json_encode($discount_data);?>';
function togglePrice(btnId, selectValue, selectElement) {
    var productBox = $(selectElement).closest('.caripro-subscription-product-box');
    // console.log("DISC PRICE:",enamel_discounted_prices);
    // console.log(productBox);
    // console.log(selectValue);
    // console.log( $(selectElement).val());
    var jsonObject = JSON.parse(enamel_discounted_prices);

var keyToCheck = selectValue;
add_to_cart_string1 = 'data-'+pslug+'_user="yes"';
// Using hasOwnProperty method
if (jsonObject.hasOwnProperty(keyToCheck)) {
    val = jsonObject[keyToCheck];
    add_to_cart_string2 = 'data-<?php echo $pslug;?>_sale_price="'+val+'"';
} else {
    var val = $(selectElement).parents('.product-selection-box').find("input[name='product_name" + selectValue + "']").val();
}
    //var val = productBox.find("#" + selectValue).val();
    //alert("product_name" + selectValue);
   


    var old_price =$(selectElement).parents('.product-selection-box').find("input[name='product_name" + selectValue + "']").attr("data-old_price");
    
    //console.log(val+'=>'+old_price);
    productBox.find("#" + btnId + "_price").html(Number(val).toFixed(2));
    productBox.find("#" + btnId + "_old_price").html(old_price);
    productBox.find("#" + btnId).attr("data-product_id", selectValue);
    productBox.find("#" + btnId).attr("href", "?add-to-cart=" + selectValue);
    productBox.find("#item_detail_li").html('• ' + productBox.find('#Quantity').find("option:selected").text());
    
    if (productBox.find("#Quantity").find("option:selected").attr("on-sale") == 1) {
        productBox.find("#sale_div").show();
    } else {
        productBox.find("#sale_div").hide();
    }
    productBox.find("#" + btnId).attr("data-"+pslug+"_user", "yes");
    productBox.find("#" + btnId).attr("data-"+pslug+"_probiotics_price", val);
    productBox.find("#" + btnId).attr("data-page", pslug);
    // productBox.find("#" + btnId).attr("data-geha_user", "yes");
    // productBox.find("#" + btnId).attr("data-geha_probiotics_price", val);
    if (selectValue != 711911) {
        productBox.find("#" + btnId).attr("data-action", "woocommerce_add_order_item");
       
    } else {
        productBox.find("#" + btnId).removeAttr("data-action");
    }
}

// Add event listeners for updating and adding subscription items
$(document).on('change', '.select-probiotic-content-subscription select[name="subc_quantity"], .select-probiotic-content-subscription select[name="subc_frequency"]', updateOrderSubscriptionItem);
//$(document).on('click', '.add-to-cart-btn button', addOrderSubscriptionItem);

</script>
<script>
    function scrollToScienceSection() {
        var offset = $("#see-the-science-section").offset().top - 90;
        $("html, body").animate({scrollTop: offset}, 1500);
    }

    //   for Cari Pro Dental Probiotics tag color
    var element = document.querySelector('.subscription-product-detail.full-col');
        if (element) {
            element.parentNode.classList.add('cariPro_dental_probiotics_byJs');
        }
    //   for Cari Pro Dental Probiotics tag color Ends        

</script>
<script>
    function scrollToProductSection() {
        var offset = $("#subscription-product-wrapper").offset().top - 90;
        $("html, body").animate({scrollTop: offset}, 1500);
    }
</script>
<?php

//get_footer();

?>