<?php
$footer = ot_get_option('footer', 'on');
$subfooter = ot_get_option('subfooter', 'on');
$footer_portfolio = is_singular('portfolio') ? ot_get_option('footer_portfolio', 'off') : 'on';
$footer_article = is_singular('post') ? ot_get_option('footer_article', 'on') : 'on';
$disable_footer = get_post_meta(get_the_ID(), 'disable_footer', true);
$cond = ('on' === $footer && 'on' === $footer_portfolio && 'on' === $footer_article && 'on' !== $disable_footer);
$billing_val_def = isset($_COOKIE['billing_email']) ? $_COOKIE['billing_email'] : '';
add_shipping_protection_cookies(); 
if (is_product()) {
    wc_print_notices();
}
if ($cond) {
    do_action('thb_footer_bar');
}
?>
</div> <!-- End Main -->
<div class="fixed-footer-container">
    <?php
    if ($cond) {
        get_template_part('inc/templates/footer/style1');
    }
    ?>
    <?php
    if ('on' === $subfooter && 'on' === $footer_portfolio && 'on' === $footer_article && 'on' !== $disable_footer) {
        get_template_part('inc/templates/footer/subfooter-' . ot_get_option('subfooter_style', 'style1'));
    }
    ?>
</div>
<!-- Start Mobile Menu -->
<?php do_action('thb_mobile_menu'); ?>
<!-- End Mobile Menu -->

<!-- Start Side Cart -->
<?php do_action('thb_side_cart'); ?>
<!-- End Side Cart -->

<!-- Start Featured Portfolio -->
<?php do_action('thb_featured_portfolio'); ?>
<!-- End Featured Portfolio -->

<!-- Start Shop Filters -->
<?php do_action('thb_shop_filters'); ?>
<!-- End Shop Filters -->
<?php if (is_account_page()) { ?>
    <div class="modal fade viewLogModalpopup" id="viewLogModalpopup" tabindex="-1" aria-labelledby="" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-mont" id="viewItemLogOrdernumber">Item Status Log <div class="orderNumberTagParent"><span class="itemNoTag">ORDER NO:</span> <span class="orderNumberJs"></span></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="productWrapperMbt cssScroll" id="viewItemLogOrderItemData">


                    </div>


                </div>
                <div class="modal-footer hidden">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    if (typeof ajaxurl === 'undefined') {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    }
</script>
<script>
    $(document).ready(function() {
        //console.log('jjj');
            // $(".wfacp_product_restore_wrap").css('display', 'none');
        
        //$('body').find('.woocommerce-Price-amount').click(function() {
            $('body').on('click', '.wfacp_delete_item_wrap', function() {

          //  alert('hello');
            // Check if any parent wrapper contains the text "shipping protection"
            if ($(this).parents('.cart_item').filter(function() {
                return $(this).text().toLowerCase().includes('shipping protection');
            }).length > 0) {
               // alert('hello22');
                setTimeout(function(){ 
                $(document.body).trigger('update_checkout');
                $(this).parents('.cart_item').remove();
            }, 2000);
               
            }
        });
    });
</script>

<?php
if (is_checkout()) {
    
    if (woo_in_cart_mbt(130266)) {
        if ($billing_val_def != '') {
?>
            <!-- <script>
                  jQuery(document).ready(function(){
             console.log('<?php //echo $billing_val_def;
                            ?>');
                //klaviyo details
                try {
                    window._learnq = window._learnq || [];
                    window._learnq.push(['identify', {
                        '$email': '<?php //echo $billing_val_def; 
                                    ?>'
                    }]);
                    window._learnq.push(["track", "GEHA Brush", {}]);
                    console.log(window._learnq);
                } catch (err) {
    console.log(err);
    console.log('err');
                }
            });
            </script> -->
        <?php
        }
    }
    require_once(get_stylesheet_directory() . '/inc/one-time-pop.php');
    require_once(get_stylesheet_directory() . '/inc/retainer-cleaner-pop.php');
    if (!is_user_logged_in()) {
        ?>
        <script>
            jQuery(document).ready(function() {
                setTimeout(function() {
                    jQuery('#billing_email').val('<?php echo $billing_val_def; ?>');
                    jQuery('#billing_email').click();
                    jQuery('#billing_email').focus();
                }, 1000);

            });
            jQuery(document).ready(function() {

                jQuery('#shipping_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');

            });
        </script>
        <script>
            jQuery(document).ready(function() {

                jQuery('#billing_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');
            });
        </script>
    <?php
    }
    if (is_user_logged_in()) {
    ?>
        <script>
            jQuery(document).on('change', 'input[name="wc-authorize-net-cim-credit-card-payment-token"]', function() {
                if (jQuery('input[name="wc-authorize-net-cim-credit-card-payment-token"]:checked').attr('data-hsa_fsa') == 'true') {
                    $('#payment_method_hsa_hfa').prop('checked', true);
                } else {
                    $('#payment_method_hsa_hfa').prop('checked', false);
                }
                if (jQuery('input[name="wc-authorize-net-cim-credit-card-payment-token"]:checked').val() == '') {
                    $('.paymentMethodNfa').show();
                } else {
                    $('.paymentMethodNfa').hide();
                }

            });
            jQuery(document).ready(function() {
                selectObject = document.getElementsByName('shipping_address_id');
                str_val_act = $(selectObject).children('option:selected').val();
                if (str_val_act != 'emp' && typeof str_val_act !== "undefined") {
                    jQuery('.step_1 input, .step_1 select').each(function() {
                        val = jQuery(this).val();
                        name_str = jQuery(this).attr('name');
                        if (val == '' && name_str == 'shipping_state') {
                            val = $('#shipping_state').children('option:selected').val();
                        }

                        if (name_str != 'shipping_state') {
                            if (name_str.startsWith("shipping")) {
                                str_val = $(selectObject).children('option:selected').data(name_str);
                                if (str_val != '' && str_val != 'empty_val' && typeof str_val !== "undefined") {
                                    str_val = str_val.toString();
                                    result2 = str_val.replace(new RegExp("\\+", "g"), ' ');
                                    if (val != result2) {
                                        change_shipping_Address(selectObject);
                                        return false;
                                    }

                                }
                            }
                        }
                    });
                }
                var billingPhoneField = $('#billing_phone');

// Check if the element with ID 'billing_phone' exists on the page
if (billingPhoneField.length > 0) {
  //  console.log(billingPhoneField.val() + 'kkkk');

    // Check if the field is initially empty
    if (billingPhoneField.val().trim() === '') {
        setTimeout(function() {
           // console.log(billingPhoneField.val() + 'kkkk4');

            // Remove the 'readonly' attribute
            billingPhoneField.prop('readonly', false);

            // Modify CSS properties
            billingPhoneField.css({
                'pointer-events': 'auto',
                'background-color': '#fff',
                'background': '#fff'
            });
        }, 1000);
    }
} else {
   // console.log("Element with ID 'billing_phone' not found on the page.");
}

                /*
                var billingPhoneField = $('#billing_phone');
                console.log(billingPhoneField.val()+'kkkk');
                // Check if the field is initially empty
                if (billingPhoneField.val().trim() === '') {
                    setTimeout(function() {
                        console.log(billingPhoneField.val()+'kkkk4');
                    // Remove the 'readonly' attribute
                    jQuery('#billing_phone').css({
    'pointer-events': 'auto',
    'background-color': '#fff !important',
    'background': '#fff !important'
});
                 //   billingPhoneField
                    billingPhoneField.removeAttr('readonly');
                    billingPhoneField.prop('readonly', false);
                }, 1000);
                    
                }
                */
            });
        </script>
<?php
    }
}
wp_footer();
?>
<style>
    .order-processing-message {
        position: fixed;
        width: 100%;
        height: 100%;
        background: #00000096;
        z-index: 999999999;
        top: 0;
        display: none;
    }

    .message-processing {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        letter-spacing: 1px;
        background: #3498db;
        z-index: 99;
    }

    .loading-animate:after {
        content: ' .';
        animation: dots 1s steps(5, end) infinite;
    }

    @keyframes dots {

        0%,
        20% {
            color: rgba(0, 0, 0, 0);
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        40% {
            color: white;
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        60% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        80%,
        100% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 white;
        }
    }

    .container-form .row.after-success {
        display: none;
    }

    .has_error {
        border: 1px solid red !important;
    }
</style>
<script>
    jQuery('#see-full-technical-click').on('click', function(e) {
        jQuery('#content-accordion').toggleClass("visible pressed", 400); //you can list several class names 
        jQuery(this).toggleClass('active-nav');
        e.preventDefault();
    });


    jQuery(".open-specification").click(function() {
        jQuery('#content-accordion').toggleClass("visible pressed", 400); //you can list several class names 
        jQuery('#content-accordion').toggleClass('active-nav');
        jQuery('html, body').animate({
            scrollTop: jQuery("#see-full-technical-click").offset().top
        }, 800);
    });

    jQuery('.warranty-modal-popup .btn-primary').on('click', function(e) {
        jQuery(".overlay-fade").removeClass('ult-open');
        e.preventDefault();
    });

    var myFunc = function() {}
    window.onload = function() {
        setTimeout(myFunc, 3000);
        jQuery('.ufaq-faq-div .ufaq-faq-title').on('click', function() {
            jQuery('.ufaq-faq-display-style-Default.current-faq').removeClass('current-faq');
            jQuery(this).parent().addClass('current-faq');
        });
        // jQuery(".ufaq-faq-div .ufaq-faq-title").click(function(){
        //    jQuery(this).next(".ufaq-faq-body").slideToggle();
        // });


        jQuery('.ufaq-faq-div').on('click', function() {
            jQuery('.ufaq-faq-div').removeClass('current-faq-mbt');
            jQuery('.ufaq-faq-div.current-faq-mbt').removeClass('current-faq-mbt');
            jQuery(this).addClass('current-faq-mbt');
        });

        var all_links = document.querySelectorAll(".ufaq-faq-title a.ewd-ufaq-post-margin");

        for (var i = 0; i < all_links.length; i++) {
            all_links[i].removeAttribute("href");
        }


    }

    jQuery(function() {
        jQuery("#quick_cartt").on("click", function(e) {
            jQuery(this).parent().addClass("open");
            jQuery(".cart-mbt").addClass("wide");
            e.stopPropagation()
        });

    });

    jQuery(document).on('click', function(e) {
        if (jQuery(e.target).closest(".widget_shopping_cart_content").length === 0) {
            // jQuery(".widget_shopping_cart_content").hide();
            jQuery(".secondary-area-mbt").removeClass("open");
        }
    });


    // Geha page

    jQuery(".get-your-discount").click(function() {
        jQuery('html, body').animate({
            scrollTop: jQuery(".geha-registration-form").offset().top
        }, 1000);
    });
</script>


<script>
    jQuery(document).on('click', '.removesmilecart', function(e) {

        prodcutid = jQuery(this).attr('data-product_id');
        jQuery('#smile_brillaint_cart_form').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        jQuery.ajax({
            type: "post",
            async: true,
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            data: 'action=remove_composite_product_from_cart&product_id=' + prodcutid,
            success: function(response) {
                jQuery(document.body).trigger("update_checkout");
                jQuery('body').trigger('wc_fragment_refresh');
                jQuery(this).parent('.smile_brilliant-mini-cart-item').removeClass('removing');
                //   jQuery('#smile_brillaint_cart_form').unblock();
            }
        })
    });

    // jQuery(window).resize(function() {
    if (jQuery(window).width() < 767) {
        jQuery("#couponRowDescriptionCell").attr('colspan', 2);
    } else {
        jQuery("#couponRowDescriptionCell").attr('colspan', 4);
    }
    // });



    jQuery(function() {
        setTimeout(function() {
            //caches a jQuery object containing the header element
            var header = jQuery("#sbr-header");
            jQuery(window).scroll(function() {
                var scroll = jQuery(window).scrollTop();

                if (scroll >= 30) {
                    header.addClass("opaque");
                } else {
                    header.removeClass("opaque");
                }
            });
        }, 2000);
    });
    // jQuery(document).on('click', '#send-my-discount', function(e) {
    //     e.preventDefault();
    //     hasserror = false;
    //     jQuery('#geha_discount_registration_form input').each(function() {
    //         if (jQuery(this).val() == '') {
    //             jQuery(this).addClass('has_error');
    //             hasserror = true;
    //         } else {
    //             jQuery(this).removeClass('has_error');
    //         }
    //     });
    //     if (hasserror) {
    //         return false;
    //     }
    //     var data_ajax = jQuery('#geha_discount_registration_form').serialize();
    //     jQuery.ajax({
    //         type: "post",
    //         dataType: "json",
    //         url: ajaxurl,
    //         data: data_ajax,
    //         success: function(response) {
    //             if (response.status == true) {
    //                 jQuery('.container-form .row.after-success #geha-coupon-code-box').text(response
    //                     .code);
    //                 jQuery('.container-form .row.after-success').show();
    //                 jQuery('#geha_discount_registration_form').hide();
    //                 try {

    //                     window._learnq = window._learnq || [];
    //                     window._learnq.push(['identify', {
    //                         '$email': jQuery('#entryEmail').val(),
    //                         '$first_name': jQuery('#entryFastName').val(),
    //                         '$last_name': jQuery('#entryLastName').val()
    //                     }]);
    //                     window._learnq.push(["track", "GEHA Discount", {}]);

    //                 } catch (err) {}

    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Oops...',
    //                     text: response.code,

    //                 })
    //             }
    //         }
    //     });
    // });

    jQuery(document).ready(function() {
        jQuery(".page-id-426712 .ewd-ufaq-post-margin").removeAttr("href");
    });

    jQuery(".page-id-426712 .ewd-ufaq-post-margin").click(function() {
        event.preventDefault();

    });
</script>


<script type="text/javascript">
    function n__toggleTechSpecs(forceDisplay) {
        if (jQuery('#technical-specs-wrap').hasClass('visible') && forceDisplay !== true) {
            jQuery('#specs-drop-icon').removeClass('fa-angle-down').addClass('fa-angle-right');
            jQuery('#technical-specs-wrap').removeClass('visible');
        } else {
            jQuery('#specs-drop-icon').removeClass('fa-angle-right').addClass('fa-angle-down');
            jQuery('#technical-specs-wrap').addClass('visible');
        }
    }






    //   $(function() {
    //   $("#user-login-top").on("click", function(e) {
    //     $("#user-login-wrapper").toggleClass("wide");
    //   });
    //   $(document).on("click", function(e) {
    //     if ($(e.target).is("#user-login-wrapper, #user-login-top") === false) {
    //       $("#user-login-wrapper").removeClass("wide");
    //     }
    //   });
    // });


    // $(function() {                       //run when the DOM is ready
    //     $("body").find("a.btn.btn-primary.dropdown-toggle").click(function() {  //use a class, since your ID gets mangled
    //     $("#user-login-wrapper").addClass("open");      //add the class to the clicked element
    //   });
    // });

    // $(document).click(function(event) {
    //   //if you click on anything except the modal itself or the "open modal" link, close the modal
    //   if (!$(event.target).closest("#drop-down-home-nav").length) {
    //     $("body").find("#user-login-wrapper").removeClass("open");
    //   }
    // });



    // mobile navigation
    jQuery(document).ready(function() {

        jQuery('.mobile-toggle-holder.style1').click(function() {
            jQuery('html').addClass('openNavigationMenu');
        });
        jQuery('.thb-mobile-close').click(function() {
            jQuery('html').removeClass('openNavigationMenu');
        });

        jQuery('.thb-mobile-menuOne > li > a').click(function() {
            jQuery('.sub-menu').slideUp();
            if (jQuery(this).parent().find('.sub-menu').is(':hidden') == true) {
                jQuery(this).parent().find('.sub-menu').slideDown();
            }
        });


    });






    jQuery(document).ready(function() {
        jQuery(".wfacp_mb_cart_accordian").trigger('click');

        
        jQuery('body.woocommerce-checkout .wfacp-coupon-page').append('<div class="shipping-free-text displayOnCheckout">Domestic shipping will be free for orders with a value of <b>$35</b> or more.</div>');
        //   coupon code message on sale  
        jQuery('#checkoutCartParent .checkout_coupon .wfacp_coupon_row').append('<div class="couponerror-for-desktop"><span style="color: #3c98cc;font-weight: 500;font-family: &quot;Montserrat&quot;, sans-serif;&quot;Montserrat&quot;, font-family: sans-serif;">Coupons are disabled during sales</span></div>');
        jQuery('.wfacp_woocommerce_form_coupon .wfacp-coupon-page .woocommerce-form-coupon .wfacp_coupon_row').append('<div class="couponerror-for-mobile"><span style="color: #3c98cc;font-weight: 500;font-family: &quot;Montserrat&quot;, sans-serif;&quot;Montserrat&quot;, font-family: sans-serif;">Coupons are disabled during sales</span></div>');



    });
</script>
<script>
    jQuery(document).on('keyup', '#wc-authorize-net-cim-credit-card-account-number', function() {
        var new_val = jQuery(this).val();
        if (new_val.replace(/[^0-9]/g, "").length > 15) {
            jQuery('#wc-authorize-net-cim-credit-card-expiry').focus();
        }
    });
    jQuery(document).on('keyup', '#wc-authorize-net-cim-credit-card-expiry', function() {
        var new_val = jQuery(this).val();
        if (new_val.replace(/[^0-9]/g, "").length > 3) {
            jQuery('#wc-authorize-net-cim-credit-card-csc').focus();
        }
    });
</script>




</div> <!-- End Wrapper -->
<?php do_action('thb_after_wrapper'); ?>

<!--Start of Zendesk Chat Script-->
<!--<script type="text/javascript">
    window.$zopim || (function (d, s) {
        var z = $zopim = function (c) {
            z._.push(c)
        }, $ = z.s =
                d.createElement(s), e = d.getElementsByTagName(s)[0];
        z.set = function (o) {
            z.set.
                    _.push(o)
        };
        z._ = [];
        z.set._ = [];
        $.async = !0;
        $.setAttribute("charset", "utf-8");
        $.src = "https://v2.zopim.com/?1gkxxybCz6kCM2GXAe6U8xtYUaPh5yGK";
        z.t = +new Date;
        $.
                type = "text/javascript";
        e.parentNode.insertBefore($, e)
    })(document, "script");
</script>-->
<!--End of Zendesk Chat Script-->
<!-- Freind Buy customer tracking -->
<?php
$current_user = wp_get_current_user();
if (is_user_logged_in() && in_array('customer', (array) $current_user->roles)) {
    //The user has the "author" role
?>
    <script>
        // friendbuyAPI.push([
        //     "track",
        //     "customer",
        //     {
        //         email: "<?php // echo esc_html($current_user->user_email); ?>",
        //         id: "<?php //echo esc_html($current_user->id); ?>",
        //         name: "<?php //echo esc_html($current_user->display_name); ?>",

        //     },
        // ]);
    </script>
<?php }
?>
<?php if (isset($_GET['redirected']) && isset($_GET['sign_on'])) {
?>
    <script>
        setTimeout(function() {
            console.log('yes');
            jQuery(document).ready(function() {
                jQuery('.loading-mbt').show();
                jQuery.ajax({
                    type: "post",
                    async: true,
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: 'action=checkout_pay_for_order_auth_check',
                    success: function(response) {
                        jQuery('.loading-mbt').hide();
                        if (response.includes('no')) {
                            location.reload();
                        }
                    }
                });
            });
        }, 2000);
    </script>
<?php
}
?>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script>

jQuery(document).ready(function() {
        // for water floseer page

        var wrapItems = jQuery('.water-flosser-wrap-items-row');
            if (wrapItems.length) {
            wrapItems.wrapAll('<div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer waterFlosserPage"></div>');
            jQuery('.lander-shortcode').each(function() {
                jQuery(this).parents('.wpb_column').addClass('landing-product');
            });

            // Show the container and wrapped elements with fadeIn effect
            jQuery('.water-flosser-wrap-items-row').animate({ opacity: 1 }, 1000);
            } else {
            console.log("No elements with class 'water-flosser-wrap-items-row' found.");
            }

    });


    jQuery(document).ready(function() {
        console.log('1');
        if (window.location.hash) {
            var hash = window.location.hash.substring(1);
            console.log('2');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=old_affiliates_redirect_to_new_structure&hashed_val=' + hash,
                success: function(response) {
                    if (response != 'error') {
                        console.log(response);
                        // alert(response);
                        Cookies.set('affwp_ref', response);
                    }
                    //   jQuery('#smile_brillaint_cart_form').unblock();
                }
            });
        }

    });

    function rearrange_element_name(el_class) {
        //console.log(el_class);
        if (el_class == 'liscence') {
            var counterUpdate = 0;
            jQuery('.field_wrapper.liscence').find('.repeater_state_liscence').each(function() {
                name_dynamic = "repeater_state[liscence][" + (counterUpdate) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdate++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.liscence').find('.repeater_state_state').each(function() {
                name_dynamic = "repeater_state[state][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
        }
        if (el_class == 'education') {
            var counterUpdate = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_school').each(function() {
                name_dynamic = "repeater_degree[school][" + (counterUpdate) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdate++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_title').each(function() {
                name_dynamic = "repeater_degree[degree_title][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_date').each(function() {
                name_dynamic = "repeater_degree[grad_date][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
        }
    }
    jQuery(document).on('click', '#buddypress #signup-form #submit', function() {
        jQuery("#buddypress #signup-form").validate();
    });
    var field_133 = document.getElementById('field_133');
    console.log(field_133)
    if (typeof(field_133) != 'undefined' && field_133 != null) {
        field_133.addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }
    jQuery("#buddypress #signup-form").validate({
        rules: {
            signup_username: {
                required: true,
                validUsername: true,
                uniqueUsername: true,
                minlength: 6,
            },
            signup_password: {
                required: true,
                //  pwcheck: true,
                minlength: 6
            },
            signup_password_confirm: {
                required: true,
                minlength: 6,
                //     pwcheck: true,
                equalTo: "#signup_password"
            },
            signup_email: {
                required: true,
                email: true,
                uniqueEmail: true,
                normalizer: function(value) {
                    return jQuery.trim(value);
                }
            },
            'contact[cellphone]': {
                required: true,
                phoneUS: true
            },
            field_1: {
                required: true,
                lettersonly: true
            },
            field_132: {
                required: true,
                lettersonly: true
            },
            'address[town_city]': {
                required: true,
                lettersonly: true
            },
            'social[linkedin]': {
                socialUsername: true,
            },
            'social[tiktok]': {
                socialUsername: true,
            },
            'social[youtube]': {
                socialUsername: true,
            },
            'social[instagram]': {
                socialUsername: true,
            },
            'social[twitter]': {
                socialUsername: true,
            },
            'social[facebook]': {
                socialUsername: true,
            },
            'social[blog]': {
                url: true
            },
        },
        messages: {
            field_1: {
                required: "Please enter your first name",
            },

            field_132: {
                required: "Please enter your last name",
            },
            signup_username: {
                required: "Please enter a username",
                uniqueUsername: "Username already in use",
                validUsername: "This username  just contain alpha numeric character",
                //validUsername: "This username  must contain at least one letter , one numerical character and must consist of at least 6 characters",
                minlength: "Your username must consist of at least 6 characters"
            },
            signup_password: {
                required: "Please provide a password",
                pwcheck: "Password must contain at least one capital letter, one numerical and one special character",
                minlength: "Your password must be at least 6 characters long"
            },
            signup_email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address",
                uniqueEmail: "This Email address is already registered in our system.",
            },
            signup_password_confirm: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above",
                pwcheck: "Password must contain at least one capital letter, one numerical and one special character",
            },
            ///  signup_email: "Please enter a valid email address",
        },
        onfocusout: function(element) {
            //To remove the 'checked' class on the error wrapper
            var $errorContainer = jQuery(element).siblings(".Ntooltip").find("label");
            $errorContainer.removeClass("checked");
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        errorPlacement: function(error, element) {
            var container = jQuery('<div />');
            container.addClass('Ntooltip'); // add a class to the wrapper
            error.insertAfter(element);
            error.wrap(container);
            jQuery("<div class='errorImage'></div>").insertAfter(error);
        },
        submitHandler: function(form) {
            form.submit();
        },
    });
    jQuery(".profile-edit.buddypress #profile-edit-form").validate({
        rules: {


            field_1: {
                required: true,
                lettersonly: true
            },
            signup_username: {
                required: true,
                validUsername: true,
                uniqueUsername: true,
                minlength: 6,
            },
            field_132: {
                required: true,
                lettersonly: true
            },
            field_273: {
                required: true,
                referral: true
            },
            // 'repeater_state[state][] ': {
            //     required: true,
            // },
            'contact[cellphone]': {
                required: true,
                phoneUS: true
            },

            'address[town_city]': {
                required: true,
                lettersonly: true
            },
            'social[linkedin]': {
                socialUsername: true,
            },
            'social[tiktok]': {
                socialUsername: true,
            },
            'social[youtube]': {
                socialUsername: true,
            },
            'social[instagram]': {
                socialUsername: true,
            },
            'social[twitter]': {
                socialUsername: true,
            },
            'social[facebook]': {
                socialUsername: true,
            },
            'social[blog]': {
                url: true
            },
        },
        messages: {
            field_1: {
                required: "Please enter your first name",
            },

            field_132: {
                required: "Please enter your last name",
            },
            signup_username: {
                required: "Please enter a username",
                uniqueUsername: "Username already in use",
                validUsername: "This username  just contain alpha numeric character",
                minlength: "Your username must consist of at least 6 characters"
            },
        },
        onfocusout: function(element) {
            //To remove the 'checked' class on the error wrapper
            var $errorContainer = jQuery(element).siblings(".Ntooltip").find("label");
            $errorContainer.removeClass("checked");
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        errorPlacement: function(error, element) {
            var container = jQuery('<div />');
            container.addClass('Ntooltip'); // add a class to the wrapper
            error.insertAfter(element);
            error.wrap(container);
            jQuery("<div class='errorImage'></div>").insertAfter(error);
        },
        submitHandler: function(form) {
            form.submit();
        },
    });
    /*
    jQuery.validator.addMethod("referral", function(value, element) {

        var current_val = value.toLowerCase();
        var referralCodes = <?php //echo json_encode(REFFERAL_CODES); 
                            ?>;
        console.log(referralCodes);
        if (jQuery.inArray(current_val, referralCodes) != -1) {
            return true;
        } else {
            return false;
        }
    }, "Referral Code is invalid.");
*/
    jQuery.validator.addMethod("referral", function(value, element) {
        <?php $ferreral_codes = array_map('strtolower', REFFERAL_CODES); ?>
        var current_val = value.toLowerCase();
        var referralCodes = <?php echo json_encode($ferreral_codes); ?>;
        if (jQuery.inArray(current_val, referralCodes) != -1) {
            return true;
        } else {
            return false;
        }
    }, "Referral Code is invalid.");

    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number. US phone format (xxx) xxx-xxxx.");

    jQuery.validator.addMethod("pwcheck", function(value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
            return false;
        }
        return true;
    }, function(value, element) {
        let password = jQuery(element).val();
        if (!(/^(.{6,20}$)/.test(password))) {
            return 'Password must be between 6 to 20 characters long.';
        }
        /*else if (!(/^(?=.*[A-Z])/.test(password))) {
         return 'Password must contain at least one uppercase.';
         } else if (!(/^(?=.*[a-z])/.test(password))) {
         return 'Password must contain at least one lowercase.';
         } else if (!(/^(?=.*[0-9])/.test(password))) {
         return 'Password must contain at least one digit.';
         } else if (!(/^(?=.*[@#$%&])/.test(password))) {
         return "Password must contain special characters from @#$%&.";
         }
         */
        return false;
    });

    var validatedEmail = '';
    var resultssEmail = true;
    var validatedUsername = '';
    var resultsUserName = true;
    jQuery.validator.addMethod('uniqueUsername', function(value, element) {

        let resultusers = true;
        if (value.length > 5) {
            if (validatedUsername != value) {

                jQuery('body').find('.account-detail-info-username .smooth.spinner').show();
                jQuery('body').find('.field_Username .smooth.spinner').show();
                jQuery.ajax({
                    type: "post",
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        'action': 'validateUniqueAccount',
                        'type': 'username',
                        'value': value
                    },
                    dataType: "JSON",
                    async: true,
                    success: function(data) {
                        jQuery('body').find('.account-detail-info-username .smooth.spinner').hide();
                        jQuery('body').find('.field_Username .smooth.spinner').hide();
                        validatedUsername = value;
                        resultusers = data;
                        resultsUserName = data;
                    },
                });
            } else {
                resultusers = resultsUserName;
            }
        }
        return resultusers;
    });

    jQuery.validator.addMethod('uniqueEmail', function(value, element) {
        let resultss = true;
        if (validatedEmail != value) {
            jQuery('body').find('.account-detail-info-email .smooth.spinner').show();
            jQuery.ajax({
                type: "post",
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    'action': 'validateUniqueAccount',
                    'type': 'email',
                    'value': value
                },
                dataType: "JSON",
                async: true,
                success: function(data) {
                    jQuery('body').find('.account-detail-info-email .smooth.spinner').hide();
                    validatedEmail = value;
                    resultss = data;
                    resultssEmail = data;
                },
            });
        } else {
            resultss = resultssEmail;
        }
        return resultss;
    });
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Please use only alphabetical characters");
    jQuery.validator.addMethod("validUsername", function(value, element) {
        return /^[a-zA-Z0-9]+$/.test(value);
        //return /^[a-zA-Z0-9_.-]+$/.test(value);
    }, "This username is not valid");




    jQuery.validator.addMethod("socialUsername", function(value, element) {
        if (value.length == 0) {
            return true;
        } else {
            return /^[a-zA-Z0-9_.-@-]+$/.test(value);
        }

    }, "This username is not valid");

    function addClassByClickmbt(obj) {
        jQuery(obj).addClass('added-to-cart');
    }
</script>
<div class="order-processing-message loading-mbt">
    <div class="message-processing loading-animate">
        ORDER PROCESSING
    </div>
</div>





<!-- Start of smilebrilliant Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=aebce2de-0290-43d9-9807-fbaaf949fa4f">
</script>
<?php
if (is_checkout()) {
    if (woo_in_cart_mbt(GEHA_PRODUCT_ID)) {
        if ($billing_val_def != '') {
            
            $api_key = KLAVIYO_API_KEY_CURL_GEHA;
$list_id = 'QuTn8m';
$email = $billing_val_def;
//$phone_number = '+15005550006'; // Optional

 $response = addProfileToKlaviyoList(KLAVIYO_API_KEY_CURL_GEHA, $list_id, $billing_val_def, null);

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => 'https://a.klaviyo.com/api/v2/list/QuTn8m/members?api_key=pk_aafe4c7dcacd640e5940145508c0dec1bc',
            //   CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_ENCODING => '',
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 0,
            //   CURLOPT_FOLLOWLOCATION => true,
            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //   CURLOPT_CUSTOMREQUEST => 'POST',
            //   CURLOPT_POSTFIELDS =>'{"email":"'.$billing_val_def.'","profiles":{"email":"'.$billing_val_def.'"}}',
            //   CURLOPT_HTTPHEADER => array(
            //     'Content-Type: application/json'
            //   ),
            // ));
            
            // $response = curl_exec($curl);
            
            // curl_close($curl);
        }
    }
}
//if (is_checkout()) {
if (woo_in_cart_mbt(130266)) {
    if ($billing_val_def != '') {
        
?>
        <script>
            console.log('<?php echo $billing_val_def; ?>');
            //klaviyo details
            try {
                window._learnq = window._learnq || [];
                window._learnq.push(["identify", {
                    "$email": "<?php echo $billing_val_def; ?>"
                }]);
                window._learnq.push(["track", "GEHA Brush", {}]);


            } catch (err) {
                //
            }
        </script>
<?php
    }
}
//}
?>

<script>
    




// let count = 0; // counter for number of clicks
//         let maxClicks = 10000; // maximum number of clicks
//         let interval = 2000; // interval in milliseconds (6 seconds)
        
//         let myButton = document.getElementById("myButton");
        
//         let clickInterval = setInterval(function() {
//           if (count >= maxClicks) {
//             clearInterval(clickInterval); // stop the clicking
//             console.log("Finished clicking.");
//           } else {
//             myButton.click(); // simulate the click
//             console.log("Clicked.");
//             count++;
//           }
//         }, interval);
        


    jQuery(document).ready(function() {
        // for water floseer page

            var wrapItems = jQuery('.water-flosser-wrap-items-row');
            wrapItems.wrapAll('<div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer waterFlosserPage"></div>');
            jQuery('.lander-shortcode').each(function() {
                jQuery(this).parents('.wpb_column').addClass('landing-product');
            });

            // Show the container and wrapped elements with fadeIn effect
            jQuery('.water-flosser-wrap-items-row').animate({ opacity: 1 }, 1000);

    });
    



    // for chat or message section for onlyh RDH
    


    

//  for header notification   
$(".bellNotification").click(function() {
        var x = $(".bellNotification .dropdown-menu").css('display');
        if (x == 'block') {
            $(".bellNotification .dropdown-menu").fadeOut();
        } else {
            $(".bellNotification  .dropdown-menu").fadeIn();
        }
    });

    $(document).mouseup(function(e)
    {
        var container = $(".bellNotification .dropdown-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {container.fadeOut();}
    });

        // footer new accordion navigation
        $('.parent-accordion').click(function () {

$(this).find('.dropdown-menu').slideToggle();
$(this).toggleClass('active-navigation');
$('.parent-accordion').not(this).find('.dropdown-menu').slideUp();
$('.parent-accordion').not(this).removeClass('active-navigation');
});



/*
Shipping Protection
*/
jQuery('body').on('click', '.remove_from_cart_button', function () {
   // alert('clicked');
    var att_pid = jQuery(this).data('gtm4wp_product_id');

    if (att_pid == '<?php echo SHIPPING_PROTECTION_PRODUCT ?>') {
        // Trigger a change in the radio button with ID 'shipping_protection_radio'
      // alert('hello');
       setTimeout(() => {
        jQuery('.remove_from_cart_button').each(function () {
            var att_pid = jQuery(this).data('gtm4wp_product_id');

            if (att_pid == '<?php echo SHIPPING_PROTECTION_PRODUCT ?>') {
               // alert(att_pid);
                jQuery(this).click();
            }
            //alert(att_pid); // Note: This alert will display 'undefined' if att_pid is not 
        });
       }, 2000);
    }
});
jQuery('body').on('click', '.remove_from_cart_button', function () {
   // alert('clicked');
    var att_pid = jQuery(this).data('product_id');

    if (att_pid == '<?php echo SHIPPING_PROTECTION_PRODUCT ?>') {
      
                var radioButton = document.getElementById('off-option'); // Example: Off option
    // Trigger the change event
    radioButton.checked = true; // Set the radio button as checked
    radioButton.dispatchEvent(new Event('change')); // Dispatch a change event
    }
});
function updateShippingProtection(element) {
    var cookieName = 'shipping_protection';
    var enableShippingProtection = element.value;

    if (enableShippingProtection == '1') {
        setCookie(cookieName, '1', 7);

        setTimeout(function() {
            window.location.reload();
        }, 200); 
        jQuery('.loading-mbt').show();
        
    } else {
        setCookie(cookieName, '0', 7);
        jQuery('.remove_from_cart_button').each(function () {
            var att_pid = jQuery(this).data('gtm4wp_product_id');

            if (att_pid == '<?php echo SHIPPING_PROTECTION_PRODUCT ?>') {
             //   alert(att_pid);
                jQuery(this).click();
            }
            //alert(att_pid); // Note: This alert will display 'undefined' if att_pid is not
        });
        jQuery('.loading-mbt').show();
        // Perform removeFromCart or other logic as needed
        setTimeout(function() {
            window.location.reload();
        }, 200); 
    }
}

// function updateShippingProtection_old(element) {
//     cookieName = 'shipping_protection';
//     var enableShippingProtection = element.value;
// if(enableShippingProtection =='1') {
//     setCookie(cookieName, '1', 7);
//     jQuery(document).find('.remove_from_cart_button').each(function(){
// att_pid = jQuery(this).attr('data-gtm4wp_product_id'){
//     if(att_pid ==
//         aler(att_pid);
//         jQuery(this).click();
//     }
//     aler(att_pid);
// }
//     });
//     //addToCart(product_id);
    
// }
// else{
//     setCookie(cookieName, '0', 7);
//    // removeFromCart(product_id);
// }


    
// }


    // Function to remove a product from the cart using WooCommerce's default function
   

   // Function to set a cookie

function setCookie(cookieName, cookieValue, days) {
    var expires = "";
    
    if(cookieName=='shipping_protection' && cookieValue=='0' && days){
        var date = new Date();
        date.setTime(date.getTime() + 1800*1000);
        expires = "; expires=" + date.toUTCString();
    }
   else if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    // Set SameSite=None for cross-site cookies
    var sameSiteAttribute = "; SameSite=None";

    // Check if the Secure attribute should be set (only for HTTPS)
    var secureAttribute = location.protocol === "https:" ? "; Secure" : "";

    // Set the cookie with the SameSite and Secure attributes
    document.cookie = cookieName + "=" + cookieValue + expires + "; path=/" + sameSiteAttribute + secureAttribute;
}



// Function to remove a cookie
function removeCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}



    // navigation js by ai

    // mobile navigation min-cart-trigger to open min cart


    if (window.innerWidth <= 768) {
        jQuery('body').on('click', '.open-min-cart', function() {
        
            if ($('#side-cart').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
                jQuery('#side-cart').css('transform', 'translateX(100%)');
                // jQuery('a#dropdownMenuCart').css('background', 'red');               
            }
            else {
                jQuery('#side-cart').css('transform', 'translateX(0%)');
                // jQuery('a#dropdownMenuCart').css('background', 'green');               
            }
        });

        
        jQuery('body').on('click', '.open-min-cart,a.thb-mobile-close', function() {
        // alert("min cart")
            jQuery('body').removeClass('activateMenuNavigationWrapper');            
            jQuery('body').toggleClass('activateMinCartOption');
            // jQuery('#wrapper').removeClass('open-cc')
        });
                    


        jQuery('body').on('click', '.add_to_cart_button', function() {
            setTimeout(function() { 
            // alert("hohoho")
            if ($('#side-cart').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
                // jQuery('#side-cart').css('transform', 'translateX(100%)');         
            }
            else {
                // alert("hahah")
                jQuery('#side-cart').css('transform', 'translateX(0%)');            
                jQuery('body').addClass('activateMinCartOption');
            }
        }, 1300);
        });

    
        jQuery('body').on('click', '.mobile-burger-menu-nav', function() {
            // alert("burger nav")
            jQuery('body').removeClass('activateMinCartOption');
            jQuery('body').toggleClass('activateMenuNavigationWrapper');
            jQuery('#side-cart').css('transform', 'translateX(100%)');
        });

    }
    jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    console.log('Product added to cart!');
    $('#quick_cart').trigger('click');
    // Perform your custom actions here
});
    // End navigation js by ai




  // mobile navigation Back Step Header Link
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('back-step').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent the default action of the link
        window.history.back();   // Navigate to the previous page
    });
});

document.addEventListener('deviceready', () => {
    navigator.splashscreen.hide()
})


// for mobile dashboard navigation by ai
jQuery(document).ready(function() {
    if (window.innerWidth <= 768) { // Adjust the width as needed for your mobile breakpoint
        if (jQuery('.nav-bar-mobile-list-li-a').length) {
            jQuery('.nav-bar-mobile-list-li-a').on('click', function() {
                var $loadingElement = jQuery('.loading-sbr');
                $loadingElement.css('display', 'block');
                
                setTimeout(function() {
                    $loadingElement.css('display', 'none');
                }, 4000); // 2000 milliseconds = 2 seconds
            });
        }
    }

    
});
function check_shine_in_cart(){
    var in_cart = false;
    jQuery('.woocommerce-mini-cart-item').each(function() {
        // Get the product data from the 'data-gtm4wp_product_data' attribute
        var productData = jQuery(this).find('a').attr('data-gtm4wp_product_data');
        
        if (productData) {
            // Parse the product data (it is stored as JSON string)
            var productInfo = JSON.parse(productData);
            var productName = productInfo.item_name.toLowerCase(); // Convert product name to lowercase
//alert(productName);
            // Check if the product name contains 'shine dental', 'shine complete', or 'shine perks'
            if (productName.includes('shine dental') || productName.includes('shine complete') || productName.includes('shine member perks')) {
                in_cart = true;
            }
        }
    });
    return in_cart;
}
jQuery(document).ready(function() {

    $('.add_to_cart_button').on('click', function(e) {
        e.preventDefault();

        var product_id = $(this).data('product_id');
        var quantity = $(this).data('quantity');
       
        console.log(shineReportData.product_ids);
        console.log(product_id);
        if (shineReportData.product_ids.includes(product_id) && check_shine_in_cart()) {

            $('#modal3').fadeIn(500).find('.modal-content').animate({
                top: '10%'
            }, 500);

            // alert('You cannot purchase more than one subscription products in a single order');

            return false; // Stop further execution
        }
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php');?>',
            type: 'POST',
            data: {
                action: 'custom_add_to_cart_gtag',
                product_id: product_id,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    var product = response.data;
                    var addTocARTdATA = {
                        'event': 'add_to_cart',
                        'ecommerce': {
                            'currencyCode': 'USD', // Adjust if needed
                            'add': {
                                'products': [{
                                    'id': product.product_id,
                                    'name': product.product_name,
                                    'price': product.product_price,
                                    'quantity': quantity
                                }]
                            }
                        }
                    };
console.log(addTocARTdATA)
                    // Push data to GTM
                    dataLayer.push(addTocARTdATA);


                    // Optionally, you can add the product to the WooCommerce cart
                    // $.ajax({
                    //     url: '/?add-to-cart=' + product_id + '&quantity=' + quantity,
                    //     method: 'GET',
                    //     success: function() {
                    //         console.log('Product added to WooCommerce cart');
                    //     }
                    // });
                } else {
                    console.log('Error:', response.data);
                }
            }
        });
    });
});



// for only static content of author on article for https://www.smilebrilliant.com/articles/oil-pulling-for-improved-oral-health/
jQuery(document).ready(function($) {
    if ($('body').hasClass('postid-925833')) {

            // Remove "Anu Issac," text inside the .author <b> element
            $(this).find('.author b').contents().filter(function() {
                return this.nodeType === 3 && this.nodeValue.trim() === "Anu Isaac,";
            }).remove();
            
          $(this).find('.social-icons-wrapper').css("opacity", "1");
         $('.authorContainer').each(function() {
            // Append text to the paragraph
            $(this).find('.paragraph').append(
                'Dr. Anu Isaac, DMD, leads Coral Dental Care in Salem, MA, where her commitment to quality and advanced training ensures top-notch oral care. Believing that even experts need to stay updated, Dr. Isaac continuously pursues the latest in dental advancements to provide the best treatments for her patients. As a dedicated educator, she shares her knowledge through engaging articles on oral health, recent innovations, and modern treatment techniques, benefiting both dental professionals and the wider community.'
            );
            // Change the image source
            $(this).find('.authorProfileImg img').attr('src', 'https://www.smilebrilliant.com/wp-content/uploads/2024/08/Dr-Isaac-1.png');
            $(this).find('.profile-button a.profile').attr('href', 'https://www.coraldentalcare.com/').text('Visit My Website');
            $(this).find('.profile-button a.contact').attr('href', 'https://www.coraldentalcare.com/contact/').text('Contact Dr. Isaac ');;            
            
        });
    }

    if ($('body').hasClass('page-id-426982')) {
        // Make the author paragraph visible
        $('p.author').css('opacity', '1');

        // Update the author paragraph content
        $('p.author').filter(function() {
            return $(this).text().includes('By: Anu Isaac');
        }).html('By: Anu Isaac, DMD');

    }



});


// Step 1: Capture the time when the Place Order button is clicked
jQuery(document).ready(function($) {
    // When the "Place Order" button is clicked
    $('form.woocommerce-checkout').on('submit', function() {
        var startTime = new Date().getTime();
        sessionStorage.setItem('checkoutStartTime', startTime);  // Store the startTime in sessionStorage
    });

    // Capture the time when the Thank You page is loaded
    $(window).on('load', function() {
       // if (window.location.href.indexOf('order-received') !== -1) { // Check if it's the Thank You page
            var startTime = sessionStorage.getItem('checkoutStartTime');  // Retrieve the startTime from sessionStorage
            
            if (startTime) {
                var endTime = new Date().getTime();
                var timeTaken = (endTime - startTime) / 1000;  // Convert milliseconds to seconds
                
                // Send the data to WordPress via AJAX
                $.ajax({
                    url: ajaxurl, // WordPress AJAX URL
                    type: 'POST',
                    data: {
                        action: 'store_checkout_session_time_taken',
                        start_time: startTime,
                        end_time: endTime,
                        time_taken: timeTaken
                    },
                    success: function(response) {
                        console.log('Session data saved successfully.');
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                    }
                });

                // Clear the sessionStorage
                sessionStorage.removeItem('checkoutStartTime');
            }
        //}
    });
});


// for only scrollable Icon slides 
jQuery(document).ready(function() {

    if (
    jQuery('body').hasClass('postid-814129') || 
    jQuery('body').hasClass('postid-864335') || 
    jQuery('body').hasClass('postid-427572') || 
    jQuery('body').hasClass('postid-782204') || 
    jQuery('body').hasClass('postid-428535')
)  {
        var $slider = jQuery('.customer-brand-slide');

            $slider.slick({
                arrows: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 0,
                speed: 8000,
                pauseOnHover: false,
                cssEase: 'linear',
                infinite: true,
                swipeToSlide: true,
                variableWidth: true,
                centerMode: true,
                focusOnSelect: true,
                // lazyLoad: 'ondemand', // Enable lazy loading
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // Listen for the lazyLoaded event
            $slider.on('lazyLoaded', function(event, slick, image, imageSource) {
                // Refresh the slider after each image has been lazy-loaded
                $slider.slick('setPosition');
            });
       
    }
});




</script>

<!-- testing new 1-->
<!-- End of smilebrilliant Zendesk Widget script -->
</body>

</html>