<?php
if (!session_id()) {
    session_start();
}
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<style>
    #shipping_method {
        display: none;
    }

    .order-review-full .small-12 {
        width: 100%;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 66.66667%;
        flex: 0 0 100%;
        max-width: 100%;
    }

    #order_comments_field {
        display: none;
    }

    .left-column .th-class {
        display: none;
    }

    #checkout-page-form button.button.checkout.wc-forward {
        float: right;
        background-color: #3c98cc;
        border-color: #3382af;
        color: white;
        padding: 2px 20px;
        font-size: 0.9em;
        font-family: 'Montserrat';
        height: 30px;
        text-transform: uppercase;
        border-radius: 0;
        font-size: 14px;
        letter-spacing: 1px;
    }

    h5.thb-checkout-coupon span {
        color: #4597cb;
        cursor: pointer;font-family: 'Montserrat';
    }

    h5.thb-checkout-coupon span:hover {
        color: #ee9982;
    }

    .thb-checkout-coupon {
        margin-bottom: 8px;
    }

    h5.thb-checkout-coupon span i {
        display: inline-block;
        margin-left: 6px;
    }

    .centering-element {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 64px;
        height: 64px;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
    }

    .left-column p.woocommerce-shipping-destination {
        display: none;
    }

    #wrapper ul.payment_methods li div.sv-wc-payment-gateway-card-icons {
        float: right;
    }

    #wrapper ul.wc_payment_methods.payment_methods.methods li>label {
        font-family: "Montserrat";
        font-weight: bold !important;
        font-size: 1.7em !important;
        color: #565759 !important;
        padding-bottom: 20px;
        clear: both;
        padding-bottom: 0;
        margin-bottom: 20px;
        margin-top: 0;
        text-transform: uppercase;
        margin-bottom: 0;
        display: inline-block;
        text-align: left;
        max-width: 100%;
        margin-bottom: 5px;
        width: 97%;
        padding-left: 0;

    }

    .woocommerce-checkout-payment .wc_payment_methods .wc_payment_method {
        padding: 10px 0;

    }

    .cart-collaterals .shop_table th,
    .shop_table.woocommerce-checkout-review-order-table th {
        width: 50%;
        border-right: 1px solid #eaeaea;
        font-size: 14px;
        color: #565759;
        font-weight: 400;
        height: 60px;
        font-family: 'Montserrat';
    }

    .cart-collaterals .shop_table tfoot tr,
    .shop_table.woocommerce-checkout-review-order-table tfoot tr {
        border-top: 1px solid #eaeaea;
    }

    table.shop_table.woocommerce-checkout-review-order-table th,
    table.shop_table.woocommerce-checkout-review-order-table td {
        padding: 10px;
    }

    .shop_table.woocommerce-checkout-review-order-table tfoot tr td {
        padding: 10px;
        text-align: left;
    }

    .woocommerce-shipping-totals.shipping #shipping_method {
        padding: 0;
    }

    #shipping_method #shipping_method_mbt {
        background-color: transparent;
    }

    table.shop_table.woocommerce-checkout-review-order-table {
        border: 1px solid #eaeaea;
    }

    tr.order-total th,
    tr.order-total td {
        background: #f9f9f9;
    }

    .woocommerce-checkout-payment .wc_payment_methods .wc_payment_method .payment_box {
        margin: 20px 0 0 0px;
    }

    .woocommerce-billing-fields,
    .woocommerce-shipping-fields,
    .woocommerce-additional-fields {
        padding-right: 0%;
    }

    td.actions.no-border-option {
        border: 1px solid #fff !important;
        padding-right: 0 !important;
    }

    #customer_details .col-1,
    #customer_details .col-2 {
        padding-right: 0px;
    }

    div.quantity .plus,
    div.quantity .minus {
        border: 1px solid #d7d7d7;
    }

    div.quantity .qty {
        background: #ffffff;
    }

    h3.upper.custom-heading.btm-spce-mbt {
        margin-bottom: 25px;
        font-size: 24px!important;


    }
    .order-review-full .woocommerce-billing-fields h3, body html h3.custom-heading{font-size: 24px!important;}
    td.remove-button-column.text-left.product-remove a,.woocommerce-cart-form td.remove-button-column a {
        max-width: 120px;
        padding-left: 10px;
        padding-right: 10px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        display: block;    
    }
    a.remove.btn.btn-primary.btn-sm.mbt-cart-item-remove,a.btn.btn-primary.btn-sm.removesmilecart{
        padding-bottom: 7px;
        padding-top: 7px;
        font-size: 12px;
    }
    .mbt_cart_table td{    font-family: Montserrat;}

    .mbt_cart_table>tbody>tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .mbt_cart_table:not(.variations):not(.shop_table):not(.group_table) tbody tr:nth-child(even),
    .mbt_cart_table>tbody>tr.no-bg-mbt {
        /*background: none !important;*/
    }

    #checkout-page-form dl.variation {
        font-size: 15px;
        display: flex;
        color: inherit;
        line-height: 26px;
        margin: 0;
    }

    #checkout-page-form dl.variation p,
    .mbt_cart_table h5 {
        margin-bottom: 0px !important;
    }
    tr.order-total th h5{ font-weight: 400; }
    .shipping-method h5{    font-size: 18px;}

    html body .mbt_cart_table:not(.variations):not(.shop_table):not(.group_table) tbody tr.couponRow {
        background-color: rgb(242, 242, 242) !important;
    }
    td#couponRowDescriptionCell h5 {
        font-family: Montserrat;
        font-size: 18px;
    }

    .payment-method-option p.form-row.woocommerce-validated label {
        margin-left: 10px !important;
    }


    .button.sv-wc-payment-gateway-payment-form-manage-payment-methods{
        max-width: 264px;
        padding-left: 10px;
        padding-right: 10px;
        background-color: transparent;
        border: 1px solid #595858;
        border-width: 1px !important;
        color: #595858;
        font-weight: 400;
        font-family: 'Montserrat';
        letter-spacing: 0.1px;
        text-transform: uppercase;
        font-size: 13px;
        border-radius: 0;
        display: block !important;


    }
    .button.sv-wc-payment-gateway-payment-form-manage-payment-methods:hover{
        background-color: #595858;
        border-color: #595858;
        color: #fff;
    }
    @media (max-width: 767px) {
        #wrapper ul.wc_payment_methods.payment_methods.methods li>label{     width: 93%; }
        .woocommerce-privacy-policy-text {
            text-align: center;
        }
        .payment-method-option button#place_order{
            max-width: 100%; float: none;
        }    
        .woocommerce-cart-form td.remove-button-column{ display: none; }
    }
    .product-name.product-column .variation{
        display:none !important;
    }

</style>
<div class="fullpageloader">
    <div class="centering-element">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loading.gif " alt="">
    </div>

</div>

<div id="checkout-page-form">

    <div class="smilebrilliant-page-content" id="checkout-page">
        <section class="sep-top-4x">
            <div class="container">
                <h1 class="product-header-primary" id="orderCheckoutPageTitle">Checkout</h1>
                <h2 class="product-header-sub" id="orderCheckoutPageSubTitle">Let's start your journey! Your new smile
                    awaits.</h2>

                <?php
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    echo '<h2 class="user_logged_in_checkout">You are already logged in as ' . $current_user->user_email . '</h2>';
                }
                ?>
                <div class="sep-bottom-lg">
                    <div id="checkout-page-order-review" class="sep-top-sm">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="upper custom-heading btm-spce-mbt">ORDER REVIEW</h3>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>
    <di>

        <?php
        do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
        if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
            echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
            return;
        }
        ?>

        <script>
            jQuery('body').on('click', '.mbt-coupon-remove', function (e) {
                e.preventDefault();
                $this = jQuery(this);
                //$this.closest('.couponRow').remove();
                $container = $this.closest('.couponRow'),
                        $coupon_code = $this.data('coupon');
                var data = {
                    security: wc_checkout_params.remove_coupon_nonce,
                    coupon: $coupon_code
                };
                jQuery.ajax({
                    type: 'POST',
                    url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_coupon'),
                    data: data,
                    success: function (code) {
                        //jQuery('.woocommerce-error, .woocommerce-message').remove();
                        $this.closest('.couponRow').remove();
                        if (code) {
                            //window.location.reload();
                            jQuery('form.woocommerce-checkout').before(code);
                            setTimeout(function () {
                                jQuery(document.body).trigger('removed_coupon_in_checkout', [data.coupon_code]);
                                jQuery(document.body).trigger('update_checkout', {update_shipping_method: false});
                            }, 2000);

                            // Remove coupon code from coupon field
                            jQuery('form.checkout_coupon').find('input[name="coupon_code"]').val('');
                        }
                    },
                    error: function (jqXHR) {
                        if (wc_checkout_params.debug_mode) {
                            /* jshint devel: true */
                            console.log(jqXHR.responseText);
                        }
                    },
                    dataType: 'html'
                });
            });
        </script>
        <form name="checkout" method="post" class="checkout woocommerce-checkout"
              action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">


            <?php if ($checkout->get_checkout_fields()) : ?>
                <div class="order-review-full">
                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="col2-set" id="customer_details">
                        <div class="col-1">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="col-2">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                </div>
            <?php endif; ?>
            <div class="row shipping-method">
                <div class="large-6 columns left-column">
                    <h3 class="upper custom-heading">SHIPPING METHOD</h3>
                    <div class="woocommerce-shipping-totals shipping">


                        <div class="form-group" id="sb_checkout_shipping">
                            <label for="shippingMethod">
                                Shipping Method
                                &nbsp;&nbsp;<span style="color:#4597cb;">(Order Will
                                    Ship:&nbsp;&nbsp;<b>Today</b>)</span>
                            </label>

                            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                <?php do_action('woocommerce_review_order_before_shipping'); ?>
                                <?php wc_cart_totals_shipping_html(); ?>
                                <?php do_action('woocommerce_review_order_after_shipping'); ?>
                            <?php endif; ?>

                        </div>

                        <div class="col-md-12">
                            <div class="note-text" id="shippingMethodNoteDomestic" style="display: none;">
                                NOTE: If you live in an apartment or condo, we recommend selecting the "USPS Priority
                                Mail
                                (w/Signature Confirm)" shipping method to ensure that your package is not left out in
                                the open.
                            </div>
                            <div class="note-text" id="shippingMethodNoteInternational">
                                Placing this order, I acknowledge that I have been informed, understand, and agree to
                                the terms
                                outlined on the <a style="color:#D4545A;font-weight:bold;" href="/product-disclaimer"
                                                   rel="nofollow" target="_blank">Smile Brilliant Product Disclaimer</a> and that I
                                provide my
                                consent prior to purchasing or using Smile Brilliant products.
                            </div>
                        </div>
                    </div>

                </div>
                <div class="order-review-full large-6 columns">
                    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                    <h3 id="order_review_heading" class="custom-heading"><?php esc_html_e('Total', 'woocommerce'); ?>
                    </h3>

                    <?php do_action('woocommerce_checkout_before_order_review'); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>

                    <?php do_action('woocommerce_checkout_after_order_review'); ?>
                </div>
                <div class="payment-method-option">


                    <?php do_action("woocommerce_checkout_order_review_below_area", $checkout); ?>
                </div>
            </div>

            <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

            <script>

                jQuery('body').on('submit', '.checkout_coupon.woocommerce-form-coupon', function (e) {

                    var $form = $(this);
                    $form.addClass('processing').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    var data = {
                        security: wc_checkout_params.apply_coupon_nonce,
                        coupon_code: $form.find('input[name="coupon_code"]').val()
                    };
                    $.ajax({
                        type: 'POST',
                        url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon'),
                        data: data,
                        success: function (code) {
                            //$('.woocommerce-error, .woocommerce-message').remove();
                            $form.removeClass('processing').unblock();
                            if (code) {
                                $form.before(code);
                                $form.slideUp();
                                setTimeout(function () {
                                    $(document.body).trigger('applied_coupon_in_checkout', [data.coupon_code]);
                                    $(document.body).trigger('update_checkout', {update_shipping_method: false});
                                }, 2000);
                            }
                        },
                        dataType: 'html'
                    });
                    e.preventDefault();
                    return false;
                });
                jQuery(document).on("click", ".showhideordercomment", function () {
                    jQuery("#order_comments_field").slideToggle();
                });
                jQuery(document).on("click", ".thb-checkout-coupon", function () {
                    jQuery(".checkout_coupon").slideToggle();
                });
                jQuery(".fullpageloader").fadeOut("slow");
                jQuery(document).on("submit", ".woocommerce-cart-form", function () {
                    jQuery(".fullpageloader").fadeIn('slow');
                });
                $('body').on('click', '.plus, .minus', function () {
                    // Get values
                    var $qty = $(this).closest('.quantity').find('.qty'),
                            currentVal = parseFloat($qty.val()),
                            max = parseFloat($qty.attr('max')),
                            min = parseFloat($qty.attr('min')),
                            step = $qty.attr('step');
                    // Format values
                    if (!currentVal || currentVal === '' || currentVal === 'NaN') {
                        currentVal = 0;
                    }
                    if (max === '' || max === 'NaN') {
                        max = '';
                    }
                    if (min === '' || min === 'NaN') {
                        min = 0;
                    }
                    if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') {
                        step = 1;
                    }

                    // Change the value
                    if ($(this).is('.plus')) {

                        if (max && (max === currentVal || currentVal > max)) {
                            $qty.val(max);
                        } else {
                            $qty.val(currentVal + parseFloat(step));
                        }

                    } else {

                        if (min && (min === currentVal || currentVal < min)) {
                            $qty.val(min);
                        } else if (currentVal > 0) {
                            $qty.val(currentVal - parseFloat(step));
                        }

                    }

                    // Trigger change event
                    $qty.trigger('change');
                    return false;
                });


                function update_smile_brillaint_checkout() {


                    jQuery('#smile_brillaint_cart_form').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });


                    jQuery('#smile_brillaint_cart_form').addClass('loading-mbt');
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                    var elementT = document.getElementById("smile_brillaint_cart_form");

                    //// console.log(elementT);
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        success: function (response) {
                            jQuery('#smile_brillaint_cart_form').removeClass('loading-mbt');
                            jQuery('#smile_brillaint_cart_form').unblock();
                            jQuery(document.body).trigger("update_checkout");

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                }

                $('.woocommerce').on('change', 'input.qtydsd', function () {
                    priceSingle = jQuery(this).parents('.qty-column').attr('data-price');
                    cart_item_val = jQuery(this).val();
                    new_price = cart_item_val * cart_item_val;
                    cart_item_key = jQuery(this).attr('name');
                    jQuery('.mbt_cart_table').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "update_woocommerce_cart_quantitys", "cart_item_val": cart_item_val, "cart_item_key": cart_item_key},
                        success: function (response) {

                            jQuery(document.body).trigger("update_checkout");
                        }
                    });
                });

                $('.woocommerce').on('change', '.mbt-cart-item-remove', function () {
                    jQuery('body').find('#smile_brillaint_cart_form').addClass("loading-mbt");
                });

                $('#ship-to-different-address-checkbox').click(function () {
                    if ($(this).is(':checked'))
                        jQuery("#customer_details").addClass("shipping-form-open");
                    else
                        jQuery("#customer_details").removeClass("shipping-form-open");
                });
                jQuery(document).on('change','#ship-to-different-address-checkbox-2',function(){
                   manage_custom_change_addresses(this);
                });
                
                function manage_custom_change_addresses(obj =jQuery('#ship-to-different-address-checkbox-2')){
                     if(obj.checked) {
                        $('#ship-to-different-address-checkbox').prop('checked', false);
                         $('#ship-to-different-address-checkbox').removeAttr('checked');
                         $('#ship-to-different-address-checkbox').trigger('change');
                         
                    }
                    else{
                        $('#ship-to-different-address-checkbox').prop('checked', true);
                        $('#ship-to-different-address-checkbox').attr('checked','checked');
                        $('#ship-to-different-address-checkbox').trigger('change');
                    }
                }
            </script>
            <?php
            $fields = $checkout->get_checkout_fields('billing');

            foreach ($fields as $key => $field) {
                if ($key == 'billing_country' && $checkout->get_value($key) == '') {
                    ?>
                    <script>
                        jQuery(document).ready(function () {
                            jQuery('#billing_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');
                        });
                    </script>
                    <?php
                }
            }
            ?>
            <style>
                .modal-open .modal {
                    overflow-x: hidden;
                    overflow-y: auto;
                }
                .fade.in {
                    opacity: 1;
                }

                .fade {
                    opacity: 0;
                    -webkit-transition: opacity .15s linear;
                    -o-transition: opacity .15s linear;
                    transition: opacity .15s linear;
                }

                .modal {
                    position: fixed;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    /* display: none; */
                    overflow: hidden;
                    -webkit-overflow-scrolling: touch;
                    outline: 0;
                    z-index: 1234;
                    overflow:auto;
                }

                .modal-backdrop {
                    position: fixed;
                    top: 0;
                    right: 0;
                    left: 0;
                    background-color: #00000085;
                    width: 100%;
                    height: 100%;
                }
                .modal-backdrop.fade {
                    filter: alpha(opacity=0);
                    opacity: 0;
                }
                .modal-backdrop.in {
                    filter: alpha(opacity=50);
                    opacity: .5;
                }
                .modal-dialog {
                    position: relative;
                    width: auto;
                    margin: 10px;
                }
                .modal-dialog {
                    width: 600px;
                    margin: 30px auto;
                }
                .modal.fade .modal-dialog {
                    -webkit-transition: -webkit-transform .3s ease-out;
                    -o-transition: -o-transform .3s ease-out;
                    transition: transform .3s ease-out;
                    -webkit-transform: translate(0,-25%);
                    -ms-transform: translate(0,-25%);
                    -o-transform: translate(0,-25%);
                    transform: translate(0,-25%);
                }
                .modal.in .modal-dialog {
                    -webkit-transform: translate(0,0);
                    -ms-transform: translate(0,0);
                    -o-transform: translate(0,0);
                    transform: translate(0,0);
                }
                .modal-content {
                    position: relative;
                    background-color: #fff;
                    -webkit-background-clip: padding-box;
                    background-clip: padding-box;
                    border: 1px solid #999;
                    border: 1px solid rgba(0,0,0,.2);
                    border-radius: 6px;
                    outline: 0;
                    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
                    box-shadow: 0 3px 9px rgba(0,0,0,.5);
                }
                .modal-content {
                    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
                    box-shadow: 0 5px 15px rgba(0,0,0,.5);
                    max-width: 400px;
                    margin: 0 auto;
                    box-shadow: none;
                    border: none;
                    border-radius: 0;

                }
                .text-center {
                    text-align: center;
                }
                .modal-body {
                    position: relative;
                    padding: 15px;
                    border: 6px solid #3d97cc;
                    font-size: 0.9em;

                }
                .modal-body h4{
                    color: #565759;
                    font-family: 'Montserrat' !important;
                    font-weight: 300;	
                    font-size:23px;	
                }
                .modal-body hr {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    border: 0;
                    border-top: 1px solid #eee;
                    margin-top: 0px;
                    padding-top: 0px;
                    margin-bottom: 16px;

                }
                .modal-body h1{
                    color: #565759;
                    font-family: 'Montserrat' !important;
                }
                .modal-dialog {
                    margin-top: 8rem;
                }
                #wrapper div[role="main"]{
                    /* position: relative;
                    z-index: 645; */
                }

                .close_icon_pop {
                    position: absolute;
                    right: -12px;
                    height: 30px;
                    width: 30px;
                    border-radius: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 22px;
                    background: white;
                    border: 1px solid #3d97cd;
                    z-index: 456;
                    top: -10px;
                }                
                a#crossPopup i {
                    -webkit-text-stroke: 2px #fff;
                }

                @media(max-width:767px){

                    .modal-dialog {
                        margin-top: 0rem;

                    }
                    .modal-dialog,.modal-content {
                        width: 100%;
                        max-width:100%;
                    }   
                    h2.user_logged_in_checkout{ width:100%;} 
                    .modal-body{
                        padding-top: 15px;
                    }

                    .secondary-area-mbt .mobile-toggle-holder.style1 {
                        display:none;   
                    }
                    .modal-body h1{
                        font-size: 23px !important;
                    }
                    .close_icon_pop{
                        top: 8px;
                        right: 8px;
                    }                    


                }


            </style>
            <script>
                jQuery(document).ready(function(){
                    jQuery('#ship-to-different-address-checkbox-2').prop('checked',true);
                    jQuery('#ship-to-different-address-checkbox-2').attr('checked','checked');
                    jQuery('#ship-to-different-address-checkbox-2').trigger('change');
                    setTimeout(function(){  jQuery('body').trigger('update_checkout');  }, 2000);
                });
                jQuery(document).on('change','#shipping_state, #shipping_state',function(){
                    jQuery('body').trigger('update_checkout');
                });
            </script>
