<?php
// Hook the miniCart_slider_script function to the wp_footer action with priority 1000
add_action('wp_footer', 'miniCart_slider_script', 1000);
/**
 * Function to handle the mini cart slider script.
 *
 * @param mixed $col The column parameter (not clear from the context).
 */
function miniCart_slider_script($col)
{
?>

    <script>
        var stateSlider = 0;

        function sliderCreateMinCart() {
            if (document.querySelector('.oneTimeBodyContent_inner') !== null) {
                jQuery('.oneTimeBodyContent_inner').not('.slick-initialized').slick({
                    autoplay: true,
                    autoplaySpeed: 3000,
                    infinite: false,
                    centerMode: true,
                    centerPadding: '30px',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    focusOnSelect: true,
                    dots: false,
                    arrows: false,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            centerPadding: '35px',
                        }
                    }]
                });
            }
        }

        let stateOfMiniCartOneTimeBuy = 0;
        jQuery('body').on('click', '.oneTimerOfferBanner .defaultShow', function() {
            stateOfMiniCartOneTimeBuy = 1;
            Cookies.set('stateOfMiniCartOneTimeBuy', stateOfMiniCartOneTimeBuy);
            jQuery('body').find(".oneTimerOfferBanner").addClass("open_widget_content");
            jQuery('body').find(".oneTimeBodyContent").slideDown(700);
            sliderCreateMinCart();
            jQuery('.oneTimeBodyContent_inner').get(0).slick.setPosition();
        });
        jQuery('body').on('click', '.oneTimerOfferBanner .afterShow', function() {
            sliderCreateMinCart();
            jQuery('body').find(".oneTimerOfferBanner").removeClass("open_widget_content");
            jQuery('body').find(".oneTimeBodyContent").slideUp(700);
            stateOfMiniCartOneTimeBuy = 0;
            Cookies.set('stateOfMiniCartOneTimeBuy', stateOfMiniCartOneTimeBuy);

        });


        jQuery(document).ready(function($) {
            $(document.body).on('added_to_cart removed_from_cart', function() {
                setTimeout(function() {
                    sliderCreateMinCart();
                }, 2000); // Delay in milliseconds
            });
        });

        jQuery('body').ajaxComplete(function(event, xhr, settings) {
            var stringUrl = settings.url;
            if (stringUrl.indexOf("add_to_cart") >= 0 || stringUrl.indexOf("wc-ajax=add_to_cart") >= 0 || stringUrl.indexOf("remove_from_cart") >= 0 || stringUrl.indexOf("update_order_review") >= 0 || stringUrl.indexOf("get_refreshed_fragments") >= 0) {
                console.log('ajaxComplete Event')
                sliderCreateMinCart();
            }
        });
        <?php if (isset($_COOKIE['stateOfMiniCartOneTimeBuy']) && $_COOKIE['stateOfMiniCartOneTimeBuy'] == 1) {
        ?>
            setTimeout(function() {
                jQuery('body').find(".oneTimerOfferBanner").addClass("open_widget_content");
                jQuery('body').find(".oneTimeBodyContent").slideDown();
            }, 1000);
        <?php
        } else {
        ?>
            setTimeout(function() {
                jQuery('body').find(".oneTimerOfferBanner").removeClass("open_widget_content");
                jQuery('body').find(".oneTimeBodyContent").slideUp(700);
            }, 1000);
        <?php
        }
        ?>
        jQuery(document).ready(function() {
            setTimeout(function() {
                sliderCreateMinCart();
            }, 1000);
        });
    </script>
<?php
}
// Uncomment the following line if you want to add the mini cart to the WooCommerce review order page
//add_action('woocommerce_review_order_after_cart_contents', 'minCartOneTimeProducts_checkout', 10, 1);
/**
 * Function to display the one-time products in the mini cart.
 *
 * @param mixed $col The column parameter (not clear from the context).
 */
function minCartOneTimeProducts_checkout($col)
{
?>
    <tr>
        <td colspan="3">
            <?php minCartOneTimeProducts(); ?>
        </td>
    </tr>
    <?php
}
// Hook the minCartOneTimeProducts function to the woocommerce_mini_cart_contents action with priority 10
add_action('woocommerce_mini_cart_contents', 'minCartOneTimeProducts', 10);

/**
 * Function to display one-time products in the mini cart.
 */
function minCartOneTimeProducts()
{

    if (!isset($_COOKIE['stateOfMiniCartOneTimeBuy'])) {
        $_COOKIE['stateOfMiniCartOneTimeBuy'] = 1;
    }
    $related_products = array();
    $related_product_data = array();
    if (have_rows('upsell_combination', 'option')) :
        while (have_rows('upsell_combination', 'option')) : the_row();
            $visibilty =  get_sub_field('visibilty');
            if (in_array($visibilty, array('cart', 'both'))) {
                $upsell_product =  get_sub_field('upsell_product');
                if ($upsell_product) {
                    $offer_text =  get_sub_field('offer_text');
                    $descripton_text =  get_sub_field('descripton_text');

                    if (have_rows('related_products')) :
                        while (have_rows('related_products')) : the_row();
                            $related_products[$upsell_product][] = get_sub_field('product_id');
                        endwhile;
                    endif;
                    $related_product_data[$upsell_product] = array(
                        'title_show' => $descripton_text,
                        'offer_text' => $offer_text,
                    );
                }
            }
        endwhile;
    endif;

   
    $minCartOneTime = array();
    foreach ($related_products as $productId => $arr) {
        if ((!woo_in_cart_mbt($productId) && woo_in_cart_mbt($arr))) {
           
            $minCartOneTime[$productId] = array(
                'product_id' => $productId,
                'title_show' => $related_product_data[$productId]['title_show'],
                'offer_text' => $related_product_data[$productId]['offer_text'],
            );
        }
    }

    if (is_array($minCartOneTime) && count($minCartOneTime) > 0) {
        $addClass = '';
        $addstyleMiniCart = 'style="display:none"';
        if (isset($_COOKIE['stateOfMiniCartOneTimeBuy']) && $_COOKIE['stateOfMiniCartOneTimeBuy'] == 1) {
            $addClass = 'open_widget_content';
            $addstyleMiniCart = '';
        }

    ?>

        <li class="offerListItem minCartOneTimeProducts">
            <div class="oneTimerOfferBanner <?php echo $addClass; ?>">
                <div class="oneTimeBannerBox">
                    <div class="oneTimeHeader">
                        <h4>ONE-TIME OFFER</h4>
                        <p>Discounts limited to this checkout</p>
                    </div>
                    <div class="oneTimeBodyContentWrapper">
                        <div class="oneTimeBodyContent" <?php echo $addstyleMiniCart; ?>>
                            <div class="oneTimeBodyContent_inner">
                                <?php foreach ($minCartOneTime as $product_id => $productData) {
                                    $productObj = wc_get_product($product_id);

                                ?>
                                    <div class="oneTimeProductsDisplay">
                                        <div class="prodcutImages">
                                            <div class="product-selection-box">
                                                <div class="product-selection-image-wrap">
                                                    <?php
                                                    /*
                                                    ?>
                                                    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'full'); ?>" />
                                                     <?php
                                                    */
                                                    ?>
                                                    <img src="<?php echo get_field('pic_5', $product_id); ?>" />
                                                </div>

                                                <div class="product-selection-description">
                                                    <b><?php echo $productData['title_show']; ?></b>
                                                </div>

                                                <div class="product-selection-description-price">
                                                    <b>only <span class="largeTextPrice">$<?php echo (float)$productObj->get_price(); ?></span></b>
                                                </div>

                                                <div class="product-selection-price-wrap">
                                                    <div class="product-selection-dentist-price-note"><?php echo $productData['offer_text']; ?></div>
                                                    <button class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $product_id; ?>" data-uss="cart" data-quantity="1" data-product_id="<?php echo $product_id; ?>" data-action="woocommerce_add_order_item">ADD TO CART</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <a class="toggleButton btn" href="javascript:void(0)">
                            <span class="defaultShow">SEE ONE-TIME DISCOUNTS</span>
                            <span class="afterShow">HIDE DISCOUNTS</span>
                            <span class="caret"></span>
                        </a>

                    </div>
                </div>
            </div>
        </li>
<?php
    }
}