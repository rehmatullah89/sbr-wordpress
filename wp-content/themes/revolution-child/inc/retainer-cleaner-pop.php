<?php
return false;
 if($stylepop != 'block'){
  $stylepop = "none";

            $show_pop = SHOW_POP_ARRAY;

            if (woo_in_cart_mbt($show_pop)) {

                

                $stylepop = "block";

            }

            if (woo_in_cart_mbt(745219)) {

                $stylepop = "none";

            }

             

            

            ?>

            <script>

                

             (function ($) {



$(document).on('click', '.add_to_cart_button_costom-retainer', function (e) {

    e.preventDefault();



        var $thisbutton = $(this),

          

            product_qty = jQuery(this).attr('data-quantity'),

            product_id = jQuery(this).attr('data-product_id');



    var data = {

        action: 'woocommerce_ajax_add_to_cart_mbt',

        product_id: product_id,

        quantity: product_qty,

    };



    $(document.body).trigger('adding_to_cart', [$thisbutton, data]);



    $.ajax({

        type: 'post',

        url: ajaxurl,

        data: data,

        beforeSend: function (response) {

            $thisbutton.removeClass('added').addClass('loading');

        },

        complete: function (response) {

            $thisbutton.addClass('added').removeClass('loading');

            jQuery('.footer-final-close').text('DONE');

        },

        success: function (response) {

           

            if (response.error && response.product_url) {

                alert(response.error);



            } else {

                
                jQuery('#RetainingCleaningPromoModal').hide();

                jQuery(document.body).trigger("update_checkout");

               

                

               // $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

            }

        },

    });



    return false;

});

})(jQuery);

 jQuery(document).on('click', '.no-thanks-close-retainer', function () {

                    jQuery('#RetainingCleaningPromoModal').hide();



                });

            </script>

            <div class="popup-container modal fade in" id="RetainingCleaningPromoModal" style="display:<?php echo $stylepop; ?>">



                <div class="modal-backdrop"></div>

                <div class="modal-dialog">                    

                    <div class="modal-content">

                        <a href="javascript:;" class="close_icon_pop no-thanks-close-retainer" id="crossPopup">

                            <i class="fa fa-times" aria-hidden="true"></i>

                        </a>



                        <div class="modal-body text-center">

                            <h4 style="line-height:1.5em;margin-bottom:8px;padding-bottom:0px;padding-top:0px;margin-top:0px;">ONE-TIME OFFER</h4>

                            <?php  if (!woo_in_cart_mbt(745219) && woo_in_cart_mbt($show_pop) ) { ?>

                                <div class="extra-tooths-brush">

                            <hr style="margin-top:0px;padding-top:0px;margin-bottom:16px;">

                            <div class="extra-brush-head">

                            <h1 style="font-size:22px;line-height:1.3em;font-weight:bold;margin-top:0;">ADD <span style="color:#3c98cc;">CLEANING TABLETS</span> TO<br> YOUR ORDER</h1>

                            <div style="padding-left:22%;padding-right:22%;">

                                <img style="width:100%;" src="<?php echo get_the_post_thumbnail_url(745219, 'full'); ?>">

                            </div>

                            <h1 style="font-size:2.2em;line-height:1.3em;font-weight:bold;margin-top:10px;margin-bottom:0px;padding-bottom:0px;">ONLY $<?php echo $price = get_post_meta(745219, '_regular_price', true); ?>

                            </h1>

                              <p style="font-size:0.9em;margin-top:7px;;margin-bottom:7px;">Regular Price: $19.95</p>

                            <!-- <button type="button"  class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">ADD TO MY CART</button> -->

                            <!-- <a style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;" class="btn btn-primary-blue product_type_composite add_to_cart_button" href="?add-to-cart=130262&quantity=1&action=woocommerce_add_order_item" data-quantity="1" data-product_id="130262" data-action="woocommerce_add_order_item">ADD TO CART</a> -->

                            <a style="background-color:#4696cc;color:#fff;width:100%;border:1px solid #fff;" class="btn btn-primary-blue product_type_composite add_to_cart_button_costom-retainer" href="javascript:void(0)" data-quantity="1" data-product_id="745219" data-action="woocommerce_add_order_item">

                            <span class="addToCartText">ADD TO CART</span>                            

                            <span class="proAddedText">PRODUCT ADDED!</span>



                            <div class="icon icon--order-success svg">

                                <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">

                                    <g fill="none" stroke="#8EC343" stroke-width="3">

                                    <!-- <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle> -->

                                    <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>

                                    </g>

                                </svg>

                            </div>

	



                            <!-- <span class="label__check"><i class="fa fa-check icon"></i></span>                             -->

                        </a>

                    </div>

                    <?php } ?>

                    <?php  if (woo_in_cart_mbt(55555555555555555555)) { ?>

                        <hr style="margin-top:0px;padding-top:0px;margin-bottom:16px;">

                    <div class="extra-travel-case">

                            <h1 style="font-size:22px;line-height:1.3em;font-weight:bold;margin-top:0;">ADD PREMIUM TRAVEL CASE </h1>

                            <div style="padding-left:22%;padding-right:22%;">

                                <img style="width:100%;" src="<?php echo get_the_post_thumbnail_url(735617, 'full'); ?>">

                            </div>

                            <h1 style="font-size:2.2em;line-height:1.3em;font-weight:bold;margin-top:10px;margin-bottom:0px;padding-bottom:0px;">ONLY $<?php echo $price = get_post_meta(735617, '_regular_price', true); ?>

                            </h1>

                            <p style="font-size:0.9em;margin-top:7px;;margin-bottom:7px;">Regular Price: $19.95</p>

                            <!-- <button type="button"  class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">ADD TO MY CART</button> -->

                            <a style="background-color:#4696cc;color:#fff;width:100%;border:1px solid #fff;" class="btn btn-primary-blue product_type_composite add_to_cart_button_costom-retainer" href="javascript:void(0)" data-quantity="1" data-product_id="735617" data-action="woocommerce_add_order_item">

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

                        <?php } ?>

                    <div style="height:10px;"></div>

                            <button type="button" class="btn btn-primary no-thanks-close-retainer close footer-final-close" data-dismiss="modal" style="background-color:#d1dadf;color:#555759;width:100%;border:1px solid #d1dadf;">NO, THANKS</button>

                            <div style="height:0px;"></div>

                        </div>





                    </div>





                </div>







            </div>

            </div>
            <?php } ?>