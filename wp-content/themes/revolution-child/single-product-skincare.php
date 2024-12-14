<?php

/**
 * Template Name: Custom Product Template
 */
global $sc_page;
$sc_page = true;
get_header();
?>

<!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/skincare-css.css?ver=1.1.1.67812" type="text/css" media="screen" />

<div class="product-skincare">
    <section class="section section-top-banner">
        <div class="container asjt-wrp-mbl">
            <div class="circle-banner-home">
                <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/ellipse-circle.webp" />
            </div>
            <div class="row justify-content-between pos-rel no-padding">
                <div class="col-sm-5">
                    <div class="sbr-content-banner">
                        <h1 class="font-mont weight-normal">
                            Now delivering <br>
                            br<span class="yellow-text">!</span>lliant new <strong class="weight-900">skin.</strong>
                        </h1>
                        <p>
                            We’ve addressed the misinformation associated with <br />
                            skincare through a suite of scientifically backed <br />
                            products designed to nourish, firm, and improve skin <br />
                            complexion. <span class="weight-600"> This <i>will be</i> the best skincare product you 
                             have ever used.</span>

                            <!-- We’ve addressed the misinformation associated with <br />
                            skincare through a suite of scientifically backed <br />
                            products designed to heal, firm, and improve skin <br />
                            complexion. <span class="weight-600">This <i>will be</i> the best skincare product <br />
                                you have ever used.</span> -->
                        </p>

                        <div class="action-btn">
                            <button onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-list&quot;).offset().top - 90},1500);return false;" class="btn btn-primary-teal btn-lg" style="margin-top:0px;margin-bottom:20px;min-width:284px">Get Pricing</button>
                            <div class="seethescience text-center">
                                <a href="javascript:;" onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#see-the-science-section&quot;).offset().top - 90},1500);return false;">
                                    See The Science
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 hidden-mobile">
                    <div class="girl-skin-care-banner">
                        <div class="gurantee-logo">
                            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/gurantee-top.png" />
                        </div>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/girls-smiling.webp" />
                    </div>
                </div>
            </div>
        </div>

        <div class="section-header dark-blue text-center">
            <!-- <div class="circle-yellow"></div> -->
            <div class="container">
            
                <h1 class="mb-0 text-white">“See a noticeable difference in just 3 weeks  <span class="mobile-weight-light">or return it”</span></h1>
            </div>
        </div>
    </section>

    <section class="section section-the-real-science">

        <div class="scrollable-bullets">
            <div class="container">
                <ul class="bullets-slider-infinite">
                    <li>
                        <div class="align-center-smilebrilliant"><span class="dot-yellow"></span>  FINE LINES</div> 
                    </li>
                    <li>
                    <div class="align-center-smilebrilliant"><span class="dot-yellow"></span> BREAKOUTS </div>
                    </li>
                    <li>
                    <div class="align-center-smilebrilliant"> <span class="dot-yellow"></span> VISIBLE PORES </div>
                    </li>
                    <li>
                    <div class="align-center-smilebrilliant"><span class="dot-yellow"></span> DARK SPOTS </div>
                    </li>
                    <li>
                    <div class="align-center-smilebrilliant"><span class="dot-yellow"></span> FIRMNESS </div>
                    </li>
                    <li>
                        <div class="align-center-smilebrilliant"><span class="dot-yellow"></span> ROSACEA</div>
                    </li>
                    <li>
                    <div class="align-center-smilebrilliant"><span class="dot-yellow"></span> SCARRING</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="long-strip slide-stiprs-in-loop">
             <span class="strip-bar" style="width: 25%; background:#2d2e2f;"></span>
            <span class="strip-bar" style="width: 25%; background:#d5a415;"></span>
            <span class="strip-bar" style="width: 25%; background:#f0c23a;"></span>
            <span class="strip-bar" style="width: 25%; background:#f5e2aa;"></span>
        </div>

        <!-- <div class="parallax-image-banner parallax-window" data-parallax="scroll" >

        </div> -->
        <div class="section-real-science parallax-image-banner parallax-window" data-parallax="scroll" id="see-the-science-section">
            <div class="container">
                <div class="section-title font-mont">
                    TELL IT TO ME STRAIGHT
                </div>
                <h2 class="weight-800 section-heading-h2">
                    The <i class="yellow-text">real science</i> you <br class="hidden-desktop"> should <br class="hidden-mobile"> know about <br class="hidden-desktop"> your skin health.
                </h2>
                <div class="dont-belive-it">Don’t believe us? Google it.</div>


                <div class="row align-items-end">
                    <div class="col-md-4">
                        <figure class="men-apply-cream">

                            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/men-apply-cream-on-face.webp" />

                        </figure>
                    </div>
                    <div class="col-md-8">

                        <div class="accordion-faq-section">

                            <ul class="accordion-list">
                                <li>
                                    <h3 class="d-flex"><span class="digits-number">01</span>
                                        <div class="text--k">Healthy skin <i>requires</i> a healthy microbiome
                                            <div class="small-text">
                                                Preservatives kill your skin’s natural defenses.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <p>There are more than 900 different microbes that live on your skin. As gross
                                                as it
                                                might sound, these bacteria play a critical role in a healthy microbiome and
                                                radiant skin. These bacteria destroy invading organisms that cause acne and
                                                destruction of collagen. Further, they balance the pH of your skin to kill
                                                breakouts. Most people dont understand that harsh cleansers and moisturizers
                                                kill this bacteria and disrupt the microbiome. Formulate incorporates
                                                prebiotics
                                                and nourishing ingredients that support the microbiome and maintain a
                                                balanced
                                                pH for ultimate health.</p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <h3 class="d-flex"><span class="digits-number">02</span>
                                        <div class="text--k">EGF has a short shelf life. Freshness matters.
                                            <div class="small-text">
                                             Your formula is manufactured within 24 hours of shipment.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <p>Epidermal growth factors (or EGF) are naturally occurring proteins in our skin. They stimulate healing, collagen production, and improve firmness. Although most professional skincare products incorporate EGF, what they don’t tell you is that EGF expires (and loses its potency) within 1-2 months on the shelf! This means that most of the expensive products you buy with EGF have little to no viable EGF by the time you put it on your skin. Unlike any other company on the market, our skincare products are manufactured at the time of ordering. This means that the EGF in your Formulate skincare was refrigerated until it was shipped to you. Your product arrives fresh and with maximum potency. You will never receive a product from us that has been sitting on inventory shelves. Potency is guaranteed.</p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <h3 class="d-flex"><span class="digits-number">03</span>
                                        <div class="text--k">We’ve got ingredients that accelerate immune response.
                                            <div class="small-text">
                                                How long do your breakouts last?
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <p>Formulate Labs is the first skincare company to introduce CytoCall™, a novel molecule that accelerates T-cell response to distressed skin cells. When your skin cells are damaged, infected, or diseased, they give off cytokines to call in T-cells. These T-cells do the repair and cleanup. CytoCall™ accelerates epidermal cytokine production to speed up the healing and repair process. Our made-to-order formulas are packed with nourishing and anti-inflammatory ingredients to help your skin feel healthy.
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h3 class="d-flex"><span class="digits-number">04</span>
                                        <div class="text--k">Tightening skin & reducing visible pores is solvable.
                                            <div class="small-text">
                                                Stay hydrated. Eat better...and use quality product.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <p>We all know that to maintain youthful skin, diet, hydration, and a healthy lifestyle will provide long-term success. However, there are many amazing ingredients to help tighten skin and visibly reduce unsightly/large pores. Optimal concentrations of Retinol, collagen, and nourishing vitamins are formulated and mixed within 24 hours of shipping. The freshest product means maximized potency and efficacy.

                                            </p>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section yes-its-worth-it">
        <div class="container">
            <h3 class="weight-800">30 days to try it.<br class="desktop-hidden"> Ya, It’s <span class="yellow-text">worth it</span>.</h3>
            <div class="rating-stars d-flex align-items-center justify-content-center">
                <div class="ratig-star-div">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
            <div class="subtitle   font-mont">
                <span class="mont-bold-italic">Thousands of happy skincare customers</span>...and we’re just getting
                started!
            </div>

            <div class="review-wrapper">
                <div class="circle-yellow"></div>
                <div class="review-item">
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-one.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-two.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-three.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-four-edit.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-five.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-six.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-seven.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-eight.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-nine.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-ten.webp" />
                    </span>
                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-eleven.webp" />
                    </span>

                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-twelve.webp" />
                    </span>

                    <span>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/reviews/review-thirteen.webp" />
                    </span>

                </div>
                <div class="action-btn text-center">
                    <button onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-list&quot;).offset().top - 90},1500);return false;" class="btn btn-primary-teal btn-lg" style="margin-top:0px;margin-bottom:20px;min-width:284px">Get Pricing</button>
                </div>

                <div class="disclaimer-text">
                    <p>The photos here do not constitute a warranty of any kind nor do they represent a promise or guarantee of specific results. These photos are displayed for representational purposes only and do not constitute medical advice or claims. Smile Brilliant makes no medical or curative claims regarding its products, which are not intended to treat, cure, or prevent any disease or skin condition.</p>
                </div>

            </div>




        </div>
    </section>


    <section class="skincare-section-ingredeiants action-btn" id="ingredients-section"  style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/skincare-ingredients-bg.jpg);">
        <div class="container text-center">

            <div class="madefreshshipment">Made fresh in the USA within 24 hours of shipment</div>
            <button  class="btn btn-primary-teal btn-lg yellow-button"  id="popupIngredients">Ingredient List</button>
        </div>

    </section>



    <section class="select-your-packages" id="cart-section">
        <div class="container text-center">
            <h4 class="font-mont section-heading-package">SELECT YOUR PACKAGE</h4>
            <div class="heading-title">
            <span class="mobile-medium"> Fresh, made to order. 30 Day Trial.</span><br class="hidden-desktop">
                <i>Free shipping</i>  on orders over $35.</span>
            </div>
        </div>
    </section>
    <section class="recomended-product" id="products">
        <div class="long-strip slide-stiprs-in-loop">
            <span class="strip-bar" style="width: 25%; background:#f5e2aa;"></span>
            <span class="strip-bar" style="width: 25%; background:#d5a415;"></span>
            <span class="strip-bar" style="width: 25%; background:#f0c23a;"></span>
            <span class="strip-bar" style="width: 25%; background:#f5e2aa;"></span>
        </div>



<?
        
        $page_id = 897885; // Replace 123 with the ID of the page you want to retrieve
        $page = get_post($page_id);
        if ($page) {
    ?>
            <style>
                @media (min-width: 768px) {
                    #gehaPage section.shopLanderPageHader .pageheaderTop {
                        margin-top: 73px;
                        margin-top: 10px;
                    }
                    section.shopLanderPageHader{ margin-top: 0;}
                }
            </style>
            <section class="shopLanderPageHader benefit-hub">

                <div class="pageHeader">

                    <div class="whitening-teeth-girl-with-smile mobileOptionDisplay show-mobile">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/homepage_hero" alt="homepage hero mobile" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/homepage_hero" decoding="async" class="lazyload">
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
        


<script>
    landing_str = '';

    var product_list;

    var landing_products;

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





    $('#price-sort').change(function() {



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

    jQuery(".productDescriptionDiv:contains('REFILL:')").html(function(_, html) {
        return html.replace(/(REFILL:)/g, '<span class="yellow-text-refill">$1</span>');
    });

        jQuery(".productDescriptionDiv:contains('REPLACEMENT:')").html(function(_, html) {
            return html.replace(/(REPLACEMENT:)/g, '<span class="yellow-text-refill">$1</span>');
        });


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

        setCookiePartner('benefithubOneTime', 'yes', 200, '/');
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
                    setCookiePartner('benefithubOneTime', 'yes', 2000, '/');               
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
        console.log('parent cliecked');
        jQuery(this).parents('.product-selection-box').find('.pacakge_selected_data:last').prop("checked", true).trigger('click');
    });
    //  jQuery(document).find("input[name='fav_language']").click(function() {
    jQuery(document).on('click', 'input[name="fav_language"]', function() {
        console.log('child cliecked');
        selected_product_id = jQuery(this).attr('data-pid');
        av_price = jQuery(this).attr('data-avr-price');
        var benefithub_sale_price = $(this).attr('data-benefithub_sale_price');
        if (typeof benefithub_sale_price !== 'undefined' && benefithub_sale_price !== false && benefithub_sale_price != '' && benefithub_sale_price > 0) {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').attr('data-benefithub_sale_price', benefithub_sale_price);
        } else {
            jQuery(this).parents('.product-selection-box').find('.add_to_cart_button').removeAttr('data-benefithub_sale_price');
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



    //});
</script>


    </section>


    <section class="partnership-banner-bottom">
        <div class="container">

            <div class="row">
                <div class="col-sm-6">
                    <div class="image-circle">
                    <a href="https://www.youtube.com/watch?v=OcDAoxelGtw" class="video-banner js-trigger-video-modal" data-youtube-id="OcDAoxelGtw">
                            <div id="play-video" class="video-play-button">
                                <span></span>
                            </div>
                            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/video-thumbnail.webp" />
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="content-section">

                        <h5 class="section-heading-partner yellow-text">
                            <span class="weight-800">Partnership for a <br class="hidden-desktop"> Happier & Healthier <br class="hidden-desktop"> You.</span>
                        </h5>
                        <p class="text-white">
                            Smile Brilliant is excited to announce our strategic partnership with Formulate Labs,
                            the Nations leading researcher in premium personal care products. Over a year of
                            R&D went into developing a line of skincare products for our customers. Unique to
                            our brand, each shipment is made to order. This means it’s fresh, never sat on a
                            shelf, and has the highest levels of active ingredient potency. <span class="yellow-text weight-600">We've helped
                                thousands of individuals from all ages, see better skin at a fraction of the price of
                                typical "premium" brands.</span>
                            <br> <br>
                            We are confident that you will not find a better product on the market today.
                            <span class="yellow-text weight-600">Try us out for 30 days and if you do not see an obvious
                                difference in your overall skin
                                health, we'll take it back for a full refund.</span>
                        </p>

                        <div class="poweredby-section">
                            <div class="powerd-by-text">
                                <span>powered by</span>
                                <span class="formulate-logo">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/formulate-logo.webp" />
                                </span>
                            </div>
                            <div class="gurantee-logo">
                                <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/skin-care/gurantee-logo-yellow.png" />
                            </div>
                        </div>
                        <div class="our-people-promise action-btn">
                            <button onclick="window.open('/about-us');" class="btn btn-primary-teal btn-lg yellow-button">Our People. Our Promise.</button>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>






    <!-- ingredients modal -->
    <section class="video-modal">
        <!-- Modal Content Wrapper -->
        <div id="video-modal-content" class="video-modal-content">        

            <a href="javascript:void(0);" class="close-video-modal">
                <!-- X close video icon -->
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve" width="24" height="24">

                    <g id="icon-x-close">
                        <path fill="#ffffff" d="M30.3448276,31.4576271 C29.9059965,31.4572473 29.4852797,31.2855701 29.1751724,30.980339 L0.485517241,2.77694915 C-0.122171278,2.13584324 -0.104240278,1.13679247 0.52607603,0.517159487 C1.15639234,-0.102473494 2.17266813,-0.120100579 2.82482759,0.477288136 L31.5144828,28.680678 C31.9872448,29.1460053 32.1285698,29.8453523 31.8726333,30.4529866 C31.6166968,31.0606209 31.0138299,31.4570487 30.3448276,31.4576271 Z" id="Shape"></path>
                        <path fill="#ffffff" d="M1.65517241,31.4576271 C0.986170142,31.4570487 0.383303157,31.0606209 0.127366673,30.4529866 C-0.12856981,29.8453523 0.0127551942,29.1460053 0.485517241,28.680678 L29.1751724,0.477288136 C29.8273319,-0.120100579 30.8436077,-0.102473494 31.473924,0.517159487 C32.1042403,1.13679247 32.1221713,2.13584324 31.5144828,2.77694915 L2.82482759,30.980339 C2.51472031,31.2855701 2.09400353,31.4572473 1.65517241,31.4576271 Z" id="Shape"></path>
                    </g>

                </svg>
            </a>

        </div><!-- end modal content wrapper -->

        <!-- clickable overlay element -->
        <div class="overlay"></div>

    </section>
    <!-- end video modal -->






    <!-- video modal -->
    <section class="video-modal">

        <!-- Modal Content Wrapper -->
        <div id="video-modal-content" class="video-modal-content">

            <!-- iframe -->
            <iframe id="youtube" width="100%" height="100%" frameborder="0" allow="autoplay" allowfullscreen src=></iframe>

            <a href="javascript:void(0);" class="close-video-modal">
                <!-- X close video icon -->
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve" width="24" height="24">

                    <g id="icon-x-close">
                        <path fill="#ffffff" d="M30.3448276,31.4576271 C29.9059965,31.4572473 29.4852797,31.2855701 29.1751724,30.980339 L0.485517241,2.77694915 C-0.122171278,2.13584324 -0.104240278,1.13679247 0.52607603,0.517159487 C1.15639234,-0.102473494 2.17266813,-0.120100579 2.82482759,0.477288136 L31.5144828,28.680678 C31.9872448,29.1460053 32.1285698,29.8453523 31.8726333,30.4529866 C31.6166968,31.0606209 31.0138299,31.4570487 30.3448276,31.4576271 Z" id="Shape"></path>
                        <path fill="#ffffff" d="M1.65517241,31.4576271 C0.986170142,31.4570487 0.383303157,31.0606209 0.127366673,30.4529866 C-0.12856981,29.8453523 0.0127551942,29.1460053 0.485517241,28.680678 L29.1751724,0.477288136 C29.8273319,-0.120100579 30.8436077,-0.102473494 31.473924,0.517159487 C32.1042403,1.13679247 32.1221713,2.13584324 31.5144828,2.77694915 L2.82482759,30.980339 C2.51472031,31.2855701 2.09400353,31.4572473 1.65517241,31.4576271 Z" id="Shape"></path>
                    </g>

                </svg>
            </a>

        </div><!-- end modal content wrapper -->

        <!-- clickable overlay element -->
        <div class="overlay"></div>

    </section>
    <!-- end video modal -->




<!-- The Modal -->
<div id="myModal" class="modal ingredients-pop">

    <div class="modal-content">
        <div class="modal-header-ingredients">
        <span class="close">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve" width="18" height="18">
                <g id="icon-x-closed">
                    <path fill="#000" d="M30.3448276,31.4576271 C29.9059965,31.4572473 29.4852797,31.2855701 29.1751724,30.980339 L0.485517241,2.77694915 C-0.122171278,2.13584324 -0.104240278,1.13679247 0.52607603,0.517159487 C1.15639234,-0.102473494 2.17266813,-0.120100579 2.82482759,0.477288136 L31.5144828,28.680678 C31.9872448,29.1460053 32.1285698,29.8453523 31.8726333,30.4529866 C31.6166968,31.0606209 31.0138299,31.4570487 30.3448276,31.4576271 Z" id="Shape"></path>
                    <path fill="#000" d="M1.65517241,31.4576271 C0.986170142,31.4570487 0.383303157,31.0606209 0.127366673,30.4529866 C-0.12856981,29.8453523 0.0127551942,29.1460053 0.485517241,28.680678 L29.1751724,0.477288136 C29.8273319,-0.120100579 30.8436077,-0.102473494 31.473924,0.517159487 C32.1042403,1.13679247 32.1221713,2.13584324 31.5144828,2.77694915 L2.82482759,30.980339 C2.51472031,31.2855701 2.09400353,31.4572473 1.65517241,31.4576271 Z" id="Shape"></path>
                </g>
                </svg>
            </span>
        <div class="guraanteed-fresh-logo"><img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/products/new-dental-probiotic/popup-logo.webp" /></div>

        <!-- Tab links -->
        <div class="tabs">
            <button class="tab-link active" data-tab="moisturizer">MOISTURIZER</button>
            <button class="tab-link" data-tab="serum">SERUM</button>
            <button class="tab-link" data-tab="facewash">FACE WASH</button>
        </div>
        </div>

        <!-- Tab content -->
        <div id="moisturizer" class="tab-content active">
            <?php get_template_part( 'inc/templates/skin-care-ingredients/moisturizer' );?>
        </div>

        <div id="serum" class="tab-content">
            <?php get_template_part( 'inc/templates/skin-care-ingredients/serum' );?>            
        </div>

        <div id="facewash" class="tab-content">
        <?php get_template_part( 'inc/templates/skin-care-ingredients/face-wash' );?> 
        </div>
    </div>
</div>





    

</div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<!-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>


jQuery(document).ready(function() {


/* Toggle Video Modal
-----------------------------------------*/
function toggle_video_modal() {

    // Click on video thumbnail or link
    jQuery(".js-trigger-video-modal").on("click", function(e) {

        // prevent default behavior for a-tags, button tags, etc. 
        e.preventDefault();

        // Grab the video ID from the element clicked
        var id = jQuery(this).attr('data-youtube-id');

        // Autoplay when the modal appears
        // Note: this is intetnionally disabled on most mobile devices
        // If critical on mobile, then some alternate method is needed
        var autoplay = '?autoplay=1';

        // Don't show the 'Related Videos' view when the video ends
        var related_no = '&rel=0';

        // String the ID and param variables together
        var src = '//www.youtube.com/embed/' + id + autoplay + related_no;

        // Pass the YouTube video ID into the iframe template...
        // Set the source on the iframe to match the video ID
        jQuery("#youtube").attr('src', src);

        // Add class to the body to visually reveal the modal
        jQuery("body").addClass("show-video-modal noscroll");

    });

    // Close and Reset the Video Modal
    function close_video_modal() {

        event.preventDefault();

        // re-hide the video modal
        jQuery("body").removeClass("show-video-modal noscroll");

        // reset the source attribute for the iframe template, kills the video
        jQuery("#youtube").attr('src', '');

    }
    // if the 'close' button/element, or the overlay are clicked 
    jQuery('body').on('click', '.close-video-modal, .video-modal .overlay', function(event) {

        // call the close and reset function
        close_video_modal();

    });
    // if the ESC key is tapped
    jQuery('body').keyup(function(e) {
        // ESC key maps to keycode `27`
        if (e.keyCode == 27) {

            // call the close and reset function
            close_video_modal();

        }
    });
}
toggle_video_modal();



});




    $(document).ready(function() {
            $('.medium-12 .starRatinGImage img').attr('src', 'https://www.smilebrilliant.com/wp-content/uploads/2022/07/4.9-stars.png');
        // Adjust the speed based on your preference
        var parallaxSpeed = 0.5;

        $(window).scroll(function() {
            var scrollTop = $(this).scrollTop();
            $('.parallax-window').css('background-position', 'center ' + -(scrollTop * parallaxSpeed) + 'px');
        });

        $('.accordion-list > li > .answer').hide();

        $('.accordion-list > li').click(function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active").find(".answer").slideUp();
            } else {
                $(".accordion-list > li.active .answer").slideUp();
                $(".accordion-list > li.active").removeClass("active");
                $(this).addClass("active").find(".answer").slideDown();
            }
            return false;
        });

        $('.review-item').slick({
            dots: false,
            arrows: false,
            infinite: true,
            centerMode: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            cssEase: 'linear',
            adaptiveHeight: true, 
             autoplaySpeed: 2000,

            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });


        $('.bullets-slider-infinite').slick({
            dots: false,
            arrows: false,
            infinite: true,
            centerMode: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 0,
            speed: 5000,
            pauseOnHover: false,
            variableWidth: true,
            cssEase: 'linear',
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
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
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });

    });


    $(document).ready(function () {
        // Modal functionality
        var modal = $("#myModal");

        // Open the modal
        $("#popupIngredients").click(function () {
            modal.show();
            jQuery("body").addClass("ingredients-popup-active");
        });

        // Close the modal when clicking the close button
        $(".close").click(function () {
            modal.hide();
            jQuery("body").removeClass("ingredients-popup-active");
        });

        // Close the modal when clicking outside of the modal
        $(window).click(function (event) {
            if ($(event.target).is(modal)) {
                modal.hide();
                jQuery("body").removeClass("ingredients-popup-active");
            }
        });

        // Tabs functionality
        $(".tab-link").click(function () {
            var tabId = $(this).data("tab");

            $(".tab-link").removeClass("active");
            $(".tab-content").removeClass("active");

            $(this).addClass("active");
            $("#" + tabId).addClass("active");
        });

          // Accordion functionality
        $(".accordion-header").click(function () {
            
            var content = $(this).next(".accordion-content");
            var parentItem = $(this).parent(".accordion-item");

            // Toggle the accordion content and add/remove the active class on the parent
            if (content.is(":visible")) {
                content.slideUp().removeClass("active");
                parentItem.removeClass("active");
            } else {
                $(".accordion-content").slideUp().removeClass("active"); // Close other open accordions
                $(".accordion-item").removeClass("active"); // Remove active class from other accordion items

                content.slideDown().addClass("active");
                parentItem.addClass("active");
                
            }

            
        });
        
    });



</script>

<?php
get_footer();
