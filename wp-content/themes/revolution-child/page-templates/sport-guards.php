<?php
/*Template Name:  Geha SportGuard Landar demo */
    $html = '';

    // Access the product_id passed from the calling template file
    if (isset($args['product_id'])) {
        // Now you can use $product_id in this template
        $product_id = $args['product_id'];
    } else {
        $product_id = SPORTSGUARD_FOOTBALLCOMBAT_PRODUCT_ID;
    }
    $discount_data = [];
    $_product = wc_get_product($product_id);
    $discount_amount = isset($args['discount_amount']) ? $args['discount_amount']:'';
    $discount_type = isset($args['discount_type']) ? $args['discount_type']:'';
    $all_pids = SPORTSGUARD_PRODUCTS;
    foreach($all_pids as $pidd){
        $rate_sale = (int) $discount_amount;
        $_product = wc_get_product($pidd);
        $pprice =   get_post_meta($pidd, '_price', true);
        $ppriceCalculation = get_post_meta($pidd, '_regular_price', true);
        if($pprice!=$ppriceCalculation){
        // echo $pidd.'=>'.$pprice.'=>'.$ppriceCalculation;
          //  continue;
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
        if($discount>0){
            $sale_price =  get_post_meta($pidd, '_regular_price', true) - $discount;
        }
        update_post_meta($pidd,'geha_discounted_price_sportsguard',$sale_price);
        $discount_data[$pidd]['is_on_sale']= $_product->is_on_sale()?1:0;
        $discount_data[$pidd]['sale_price']=$sale_price;
        $discount_data[$pidd]['price']=$pprice;
        $discount_data[$pidd]['discount']=(int)$discount;
             
    }
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/sportGuards-sale-lander.css?ver=1.1.23456789" type="text/css" media="screen" />
<!-- ?ver=1.2.1.1.11103256716 -->

<div class="subscription-product-detail full-col sportGuardsProuductWrapper">
    <div class="caripro-content">
        <div class="caripro-content-splitter">
            <div class="rating-stars d-flex align-items-center justify-content-center">
                <img decoding="async" class="mbl-img" src="https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/pro-shield/pro-shield-banner-image.png" />
                <div class="ratig-star-div">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
            <div class="caripro-product-outer">
                <h1>ProShield™ Sport Protection</h1>
                <p class="desktop-img sub-heading-cari-pro">ProShield™ offer 3 different mouth guard styles engineered for your sport and level of competition</p>
                <p class="mbl-img">+30 DAY TRIAL</p>

                <div class="product-selection-price-text-top noflexDiv for-only-grid-view">
                    <i role="presentation" class="product-selection-price-dollar-symbol"><span>$</span></i><span class="product-selection-price-text">18.00</span>
                    <div class="normalyAmount italic forOnlyLayoutSixDisplay"></div>
                    <div class="featureShippingPrice">+free shipping</div>
                </div>
            </div>

            <div class="selectPackageWrapper subscription-product-popup subscription-product-detail">
                <div class="selectPackageBox">
                    <div class="selectPackageBoxWrapper">
                        <div class="packageheader font-mont">
                            <a href="javascript:;" class="iconCloseBox">
                                ✕
                            </a>
                        </div>

                        <div class="subscription-product-inner-wrapper">
                            <div class="innershortpop">
                                <div class="subscription-product-box subscribe-save footbal-combat-customized-wrapperP">
                                        <?php  
                                        $template = "1";
                    //                    get_template_part('inc/templates/sale/sport-guards/football-combat-customized'); 
                                        $path = locate_template('inc/templates/sale/sport-guards/football-combat-customized.php');
                                        if ($path) {
                                            include($path);  // Passing the $data array
                                        }
                                        ?>                   
                                </div>

                                <div class="subscription-product-box one-time-offer enemalArmourSaleLanderpageTop contacct-sporpt-customized-wrapperP" >
                                        <?php  
                                            $path = locate_template('inc/templates/sale/sport-guards/contact-sport-customized.php');
                                            if ($path) {
                                                include($path);  // Passing the $data array
                                            }
                                        ?> 
                                </div>

                                <div class="subscription-product-box one-time-offer enemalArmourSaleLanderpage lift-and-strain-customized-wrapperP">
                                        <?php 
                                            $path = locate_template('inc/templates/sale/sport-guards/lift-and-strain-customized.php');
                                            if ($path) {
                                                include($path);  // Passing the $data array
                                            }
                                        ?>                    
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-selection-price-wrap selectpackageButton">
                    <button class="btn btn-primary-blue btn-lg select-a-package">Select Quantity</button>
                </div>
            </div>
        </div>
        <div class="product-selection-image-wrap product-image-caripro mobile-hide">
            <img style="max-width: 360px;" decoding="async" class="desktop-img" src="https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/pro-shield/pro-shield-banner-image.png" />
        </div>
    </div>

    <div class="fruit-content">
    <div class="fruit-content-header flex-direction-column">
      <img decoding="async" class="" src="https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/pro-shield/life-time-reorders-image.png">
      <div class="header-content">
         <p class="weight-600">Lifetime <span class="text-green">Reorders</span> </p>
         <p>Your dental impressions are kept on file. If you lose or wear down your guards, we
         can make you new ones fast!</p>
      </div>
      </div>

        <div class="middile-content">         
            <p>ProShield™ offer 3 different mouth guard styles engineered for your sport and level of competition</p>
            <p>Each of our packages includes the impression creation kit, lab service, and delivery of your custom-fitted sports guards to your door</p>


            <img decoding="async" class="" src="https://www.smilebrilliant.com/wp-content/uploads/2024/09/proshield-combine-sec.png" />


        </div>
    </div>
    <div class="subscription-product">
        <div class="subscription-product-inner-wrapper">
            <div class="subscription-product-box subscribe-save">
                    <?php  
                    $template = "2";
                    $path = locate_template('inc/templates/sale/sport-guards/football-combat-customized.php');
                    if ($path) {
                        include($path);  // Passing the $data array
                    }
                    ?>                   
            </div>

            <div class="subscription-product-box one-time-offer enemalArmourSaleLanderpage">
                    <?php 
                    $path = locate_template('inc/templates/sale/sport-guards/contact-sport-customized.php');
                    if ($path) {
                        include($path);  // Passing the $data array
                    }
                    ?> 
            </div>

            <div class="subscription-product-box one-time-offer enemalArmourSaleLanderpage">
                    <?php 
                        $path = locate_template('inc/templates/sale/sport-guards/lift-and-strain-customized.php');
                        if ($path) {
                            include($path);  // Passing the $data array
                        }
                    ?>                    
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    $('input[name="radio-group-guard1"]:checked').closest('.subscription-product-box').find('.subscription-product-content-body').show();

    // Add event listener to radio buttons with the name "radio-group-enamal"
    $('input[name="radio-group-guard1"]').change(function () {

        // Hide all subscription-product-content-body elements
        $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-content-body').hide();

        // Get the closest subscription-product-content-body element
        var contentBody = $(this).closest('.subscription-product-box').find('.subscription-product-content-body');

        // Toggle the visibility of the content body based on the checked state
        contentBody.toggle(this.checked);

        // Remove white background from all checkbox wrappers
        $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-header').removeClass('white-background');

        // Add white background to the selected checkbox wrapper
        if (this.checked) {
            $(this).closest('.subscription-product-header').addClass('white-background');
        }
    });

$('input[name="radio-group-guard2"]:checked').closest('.subscription-product-box').find('.subscription-product-content-body').show();

// Add event listener to radio buttons with the name "radio-group-enamal"
$('input[name="radio-group-guard2"]').change(function () {

    // Hide all subscription-product-content-body elements
    $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-content-body').hide();

    // Get the closest subscription-product-content-body element
    var contentBody = $(this).closest('.subscription-product-box').find('.subscription-product-content-body');

    // Toggle the visibility of the content body based on the checked state
    contentBody.toggle(this.checked);

    // Remove white background from all checkbox wrappers
    $(this).closest('.subscription-product-inner-wrapper').find('.subscription-product-header').removeClass('white-background');

    // Add white background to the selected checkbox wrapper
    if (this.checked) {
        $(this).closest('.subscription-product-header').addClass('white-background');
    }
});
});
document.addEventListener("DOMContentLoaded", function() {
    // Check if the element exists before clicking
    var footballCombat = document.getElementById("footballCombat");
    if (footballCombat) {
        footballCombat.click();
    }
});

    $(".colo-selector").on("click", function (e) {
        $(".selectcolorBox a").removeClass("selected");
        $(this).toggleClass("selected");
        e.preventDefault();
    });

    jQuery(document).on("click", ".openColorPop label", function () {
        jQuery(".selectPackageWrapper").removeClass("openPackage");
        jQuery(".product-selection-price-wrap").removeClass("disabled-main-checkout");
        jQuery(".product-selection-price-wrap").removeClass("mouthGuardsInnerWrapperOpen");
        jQuery(this).parents(".selectPackageWrapper").addClass("openPackage");
        jQuery(this).parents(".product-selection-price-wrap").addClass("disabled-main-checkout");
        jQuery(this).parents(".product-selection-price-wrap").addClass("mouthGuardsInnerWrapperOpen");
        jQuery(this).parents(".product-selection-price-wrap").find(".selectPackageBox #clear").click();
    });

    // deteching outside of div
    jQuery(document).on("click", function (event) {
        var target = jQuery(event.target);
        if (!target.closest(".openPackage").length && !target.is(".standared-clear")) {
            jQuery(".selectPackageWrapper").removeClass("openPackage");
            jQuery(".openColorPop input").prop("checked", false);
            jQuery(".product-selection-price-wrap").removeClass("disabled-main-checkout");
            jQuery(".product-selection-price-wrap").removeClass("mouthGuardsInnerWrapperOpen");
        }
    });
    var selected_number = "";
    // other radio button and cross icon
    jQuery(document).on("click", ".standared-clear:not(.addClassDynamiclick1),.iconCloseBox", function () {
        jQuery(".selectPackageWrapper").removeClass("openPackage");
        jQuery(".openColorPop input").prop("checked", false);
        jQuery(".product-selection-price-wrap").removeClass("disabled-main-checkout");
        jQuery(".product-selection-price-wrap").removeClass("mouthGuardsInnerWrapperOpen");
    });


    // for only addClassDynamiclick1



    jQuery(document).on("click", ".addClassDynamiclick1", function () {
            // alert("alerttttttt");
         jQuery(".openColorPop input").prop("checked", false);
         jQuery(".product-selection-price-wrap").removeClass("disabled-main-checkout");
         jQuery(".product-selection-price-wrap").closest(".mouthGuardsInnerWrapperOpen").removeClass("mouthGuardsInnerWrapperOpen");
         
        //  jQuery(".sportGuardsProuductWrapper .subscription-product-detail")
        //         .find(".subscription-product-content-body .selectPackageWrapper")
        //         .closest(".selectPackageBox")
        //         .removeClass("mouthGuardsInnerWrapperOpen");

        // jQuery(".selectPackageWrapper").removeClass("openPackage");
        // jQuery(".openColorPop input").prop("checked", false);
        // jQuery(".product-selection-price-wrap").removeClass("disabled-main-checkout");
        // jQuery(".product-selection-price-wrap").removeClass("mouthGuardsInnerWrapperOpen");
    });


    jQuery(".modal-toggle").on("click", function (e) {
        e.preventDefault();
        jQuery(".modal").toggleClass("is-visible");
    });
    jQuery(document).on("click", ".colo-selector", function () {
        selected_color = jQuery(this).attr("data-color");
        jQuery(this).parents(".selectPackageBox").find(".add_to_cart_button").attr("data-mouth_guard_color", selected_color);
    });
    jQuery(document).on("keyup", ".number-letter", function () {
        selected_number = jQuery(this).val();
        jQuery(this).parents(".selectPackageBox").find(".add_to_cart_button").attr("data-mouth_guard_number", selected_number);
    });

    jQuery(".customized_button_add_to_cart").click(function (event) {
        if (selected_number == "") {
            event.stopPropagation();
            alert("Please provide 2 letters or numbers");
            return false;
        }

        // Continue with other events if condition is not met
        // ...
    });






    // For footballCombat
    jQuery('#footballCombat2, #footballCombat1').on('change', function() {
        if (jQuery(this).is(':checked')) {
            jQuery('#standared-clear-fc2, #standared-clear-fc1').prop('checked', true);
        }
    });

    // For contactSports
    jQuery('#contactSports2, #contactSports1').on('change', function() {
        if (jQuery(this).is(':checked')) {
            jQuery('#standared-clear-sc2, #standared-clear-sc1').prop('checked', true);
        }
    });

    // For lift-and-strain
    jQuery('#lift-and-strain2, #lift-and-strain1').on('change', function() {
        if (jQuery(this).is(':checked')) {
            jQuery('#standared-clear-ls2, #standared-clear-ls1').prop('checked', true);
        }
    });

    

</script>
