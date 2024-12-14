<?php
$stylepop = "none";
$show_popProduct = array();
$pop_products = array();
$related_products = array();
$related_product_data = array();
if (have_rows('upsell_combination', 'option')) :
    while (have_rows('upsell_combination', 'option')) : the_row();
        $visibilty =  get_sub_field('visibilty');
        if (in_array($visibilty, array('checkout', 'both'))) {
            $upsell_product =  get_sub_field('upsell_product');
            if ($upsell_product) {
                $offer_text =  get_sub_field('offer_text');
                $descripton_text =  get_sub_field('descripton_text');

                if (have_rows('related_products')) :
                    while (have_rows('related_products')) : the_row();
                        $related_products[$upsell_product][] = get_sub_field('product_id');
                        $show_popProduct[] =  get_sub_field('product_id');
                    endwhile;
                endif;
                $related_product_data[$upsell_product] = array(
                    'title_show' => $descripton_text,
                    'offer_text' => $offer_text,
                );
                $pop_products[] = $upsell_product;
                $show_pop = array_unique($show_popProduct);
            }
        }
    endwhile;
endif;

$free_product = FREE_PRODUCT_ID;

if (woo_in_cart_mbt($show_pop)) {
    $stylepop = "block";
}
foreach ($pop_products as $prdId) {
    if (woo_in_cart_mbt($prdId)) {
        $stylepop = "none";
    } else {
        $stylepop = "block";
        break;
    }
}

?>

<script>
    (function($) {



        $(document).on('click', '.add_to_cart_button_costom', function(e) {

            e.preventDefault();



            var $thisbutton = $(this),



                product_qty = jQuery(this).attr('data-quantity'),

                product_id = jQuery(this).attr('data-product_id');



            var data = {

                action: 'woocommerce_ajax_add_to_cart_mbt',

                product_id: product_id,
                uss: 'checkout-pop',
                quantity: product_qty,
                free_probiotics: jQuery(this).attr('data-free_probiotics'),

            };



            $(document.body).trigger('adding_to_cart', [$thisbutton, data]);



            $.ajax({

                type: 'post',

                url: ajaxurl,

                data: data,

                beforeSend: function(response) {

                    $thisbutton.removeClass('added').addClass('loading');

                },

                complete: function(response) {

                    $thisbutton.addClass('added').removeClass('loading');

                    jQuery('.footer-final-close').text('DONE');

                },

                success: function(response) {



                    if (response.error && response.product_url) {

                        alert(response.error);



                    } else {

                        if (response.indexOf("pop-close") >= 0) {

                            //if(response=='pop-close'){



                            jQuery('#gehaBrushHeadPromoModal').hide();

                        }
                        setTimeout(function() {
                            if ($('.add_to_cart_button_costom').length == $('.added').length) {

                                jQuery('#gehaBrushHeadPromoModal').hide();
                            }
                        }, 2000);

                        jQuery(document.body).trigger("update_checkout");





                        // $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

                    }

                },

            });



            return false;

        });

    })(jQuery);

    jQuery(document).on('click', '.no-thanks-close', function() {

        jQuery('#gehaBrushHeadPromoModal').hide();



    });
</script>

<div class="popup-container modal fade in" id="gehaBrushHeadPromoModal">



    <div class="modal-backdrop"></div>

    <div class="modal-dialog">

        <div class="modal-content">

            <a href="javascript:;" class="close_icon_pop no-thanks-close" id="crossPopup">

                <i class="fa fa-times" aria-hidden="true"></i>

            </a>



            <div class="modal-body text-center">


                <h4 style="line-height:1.5em;margin-bottom:8px;padding-bottom:0px;padding-top:0px;margin-top:0px;">ONE-TIME OFFER </h4>

                <div class="scroll-able-div">

                    <?php
                    $stylepop = "none";
                    global $woocommerce;
                    $woocommerce->cart->get_cart();
                    // Loop through cart items
                    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
                        if (in_array($free_product, array($cart_item['product_id'], $cart_item['variation_id']))) {
                            $price = get_post_meta($free_product_id, '_price', true);
                            if (isset($cart_item['free_probiotics'])) {
                                $free_item_key .= ' free_probiotics';
                                break;
                            }
                        }
                    }
                    if (WC()->cart->get_subtotal() > 50000 /*&& !woo_in_cart_mbt($free_product)*/ && !isset($free_item_key)) {

                        $title_show = 'Claim Your <span style="color:#d4555b">FREE </span> Bottle of <span style="color:#3c98cc;"> cariPRO<sup>TM</sup> dental Probiotics </span> <br>  below';
                        $offer_text = 'Regular Price:' . get_post_meta($free_product, '_regular_price', true);


                        $stylepop = "block";
                    ?>

                        <hr style="margin-top:0px;padding-top:0px;margin-bottom:16px;">

                        <div class="extra-travel-case">

                            <h1 style="font-size: 56px!important;line-height: 1;font-weight: 900;margin-top: 0;color: #d4555b;"> FREE </h1>

                            <div style="padding-left:22%;padding-right:22%;">

                                <img style="" src="<?php echo get_the_post_thumbnail_url($free_product, 'full'); ?>">

                            </div>

                            <h1 style="font-size: 24px;line-height: 1.1;font-weight: bold;margin-top: 10px;margin-bottom: 18px;padding-bottom: 0px;"> <?php echo $title_show; ?>

                            </h1>

                            <p style="font-size:0.9em;margin-top:7px;;margin-bottom:7px;"><?php echo $offer_text; ?></p>

                            <!-- <button type="button"  class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">ADD TO MY CART</button> -->

                            <a style="background-color:#4696cc;color:#fff;width:100%;border:1px solid #fff;" class="btn btn-primary-blue product_type_composite add_to_cart_button_costom" href="javascript:void(0)" data-free_probiotics="0.00" data-quantity="1" data-uss="checkout-pop" data-product_id="<?php echo $free_product; ?>" data-action="woocommerce_add_order_item">

                                <span class="addToCartText">ADD TO CART</span>

                                <span class="proAddedText">PRODUCT ADDED!</span>

                                <!-- <span class="label__check"><i class="fa fa-check icon"></i></span>                                                         -->



                                <div class="icon icon--order-success svg">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">

                                        <g fill="none" stroke="#8EC343" stroke-width="3">

                                            <!-- <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle> -->

                                            <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>

                                        </g>

                                    </svg>

                                </div>



                            </a>





                        </div>

                        <?php }
                    foreach ($related_products as $productId => $arr) {
                        if ((!woo_in_cart_mbt($productId) && woo_in_cart_mbt($arr))) {
                           
                            $title_show = $related_product_data[$productId]['title_show'];
                            $offer_text = $related_product_data[$productId]['offer_text'];
                            $productObj = wc_get_product($productId);
                            $stylepop = "block";
                        ?>

                            <hr style="margin-top:0px;padding-top:0px;margin-bottom:16px;">

                            <div class="extra-travel-case">

                                <h1 style="font-size:22px;line-height:1.3em;font-weight:bold;margin-top:0;"><?php echo $title_show; ?></h1>

                                <div style="padding-left:22%;padding-right:22%;">

                                    <img style="" src="<?php echo get_the_post_thumbnail_url($productId, 'full'); ?>">

                                </div>

                                <h1 style="font-size:2.2em;line-height:1.3em;font-weight:bold;margin-top:10px;margin-bottom:0px;padding-bottom:0px;">ONLY $<?php echo (float)$productObj->get_price(); ?>

                                </h1>

                                <p style="font-size:0.9em;margin-top:7px;;margin-bottom:7px;"><?php echo $offer_text; ?></p>

                                <!-- <button type="button"  class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">ADD TO MY CART</button> -->

                                <a style="background-color:#4696cc;color:#fff;width:100%;border:1px solid #fff;" class="btn btn-primary-blue product_type_composite add_to_cart_button_costom" href="javascript:void(0)" data-quantity="1" data-uss="checkout-pop" data-product_id="<?php echo $productId; ?>" data-action="woocommerce_add_order_item">

                                    <span class="addToCartText">ADD TO CART</span>

                                    <span class="proAddedText">PRODUCT ADDED!</span>

                                    <!-- <span class="label__check"><i class="fa fa-check icon"></i></span>                                                         -->



                                    <div class="icon icon--order-success svg">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">

                                            <g fill="none" stroke="#8EC343" stroke-width="3">

                                                <!-- <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle> -->

                                                <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>

                                            </g>

                                        </svg>

                                    </div>



                                </a>





                            </div>

                    <?php }
                    }
                    ?>
                    <style>
                        #gehaBrushHeadPromoModal {
                            display: <?php echo $stylepop; ?>;
                            <?php if ($stylepop == 'block') {
                            ?>visibility: visible;
                            <?php
                            } ?>
                        }
                    </style>
                    <?php

                    ?>

                    <div style="height:10px;"></div>

                    <button type="button" class="btn btn-primary no-thanks-close close footer-final-close" data-dismiss="modal" style="background-color:#d1dadf;color:#555759;width:100%;border:1px solid #d1dadf;">NO, THANKS</button>

                    <div style="height:0px;"></div>
                </div>
            </div>

        </div>

    </div>

</div>

</div>