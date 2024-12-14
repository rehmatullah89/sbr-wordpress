<?php
/*Template Name: Shine my account */

global $GEHA_PAGE_ID;
$GEHA_PAGE_ID = CUSTOMER_DISCOUNT_PAGE_ID;

if (function_exists('w3tc_flush_url')) {
    w3tc_flush_url(get_permalink(get_the_ID()));
}

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/css/shine-my-account.css?ver=123456543210123456" type="text/css" media="screen" />

<script>
    document.addEventListener('DOMContentLoaded', function() {
         document.body.classList.add('page-template-geha-template');
    });
</script>
<div
    class="d-flex align-items-center orderListingPageMenu menuParentRowHeading menuParentRowHeadingOrderParent shine-subscription-page-headingtp">

    <div class="pageHeading_sec">
        <span><span class="text-blue">Customer Discounts </span>Avail discounts here.</span>
    </div>
</div>
<div class="gehaTemplate active-recomendation-tab " id="gehaPage">
<?php
    $shineFlag = true;
    if ($shineFlag) {
        $page_id = CUSTOMER_DISCOUNT_PAGE_ID; // Replace 123 with the ID of the page you want to retrieve
        $page = get_post($page_id);
        if ($page) {
    ?>
    
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
                                        <li class="depth-1 clas">
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

            <div id="product-list" class="row teethWhieteingSystemWrapper productLandingPageContainer grid-changed">
                <div class="row-t product-item-display profile-container sale-page rdhtabs">
                    
                <?php
                $content = apply_filters('the_content', $page->post_content);
                    echo do_shortcode($content);
                    }
                } ?>
<script>
    $(document).ready(function() {
    setTimeout(function() {
        $('.loading-sbr').remove();
    }, 1000); // 1000 milliseconds = 1 second
});

</script>
                </div>
            </div>


            <?php if ($shineFlag) {
                echo '<style>.footer {padding: 0px 0;}</style>
                    <div class="disclaimer-bar-purple bgColor" style="display:none;">
                    <div class="container">
                     <p class="postLoggedin text-white">“<strong>DISCLAIMER:</strong><i> In order to recieve shinemember exclusive pricing you must add to cart from this page.</i></p>
                    </div>
                    </div>';
            }
            ?>



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

            landing_str += '<div class="' + col_class + '" ' + data_Str + '>' + current_html + '</div>';

            counter++;



        });

        jQuery('#product-list').html(landing_str);

        setTimeout(function() {
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
            // jQuery('#wrapper,#product-list').removeClass('grid-changed');
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
        var sbrcustomer_sale_price = $(this).attr('data-sbrcustomer_sale_price');
        if (typeof sbrcustomer_sale_price !== 'undefined' && sbrcustomer_sale_price !== false && sbrcustomer_sale_price != '' && sbrcustomer_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-sbrcustomer_sale_price', sbrcustomer_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-sbrcustomer_sale_price');
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

    $(".child-radio").change(function() {
        var selectedValue = $(".child-radio:checked").val();

        if (selectedValue) {
            $("#dropdownMenuButton").text(selectedValue);
            jQuery(".shineDropDown").removeClass("menuActivate");
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

//get_footer();

?>