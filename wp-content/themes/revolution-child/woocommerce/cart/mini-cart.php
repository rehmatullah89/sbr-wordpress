<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart');
?>
<div class="widget_shopping_cart_content dropdown-menu widget-box cart-mbt" aria-labelledby="dropdownMenuCart">

    <a href="javascript:;" class="backstep-min-cart open-min-cart">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>//assets/images/navigation-icons/back_icon_v2.svg"
            alt="" />
    </a>

    <?php if (!WC()->cart->is_empty()): ?>
        <h5 class="section-title" id="shopping_cart_item_list_title">ITEMS</h5>
        <ul class="woocommerce-mini-cart nav navbar-nav navbar-right service-nav cart_list product_list_widget cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>"
            id="menuCartWrap">

            <?php
            do_action('woocommerce_before_mini_cart_contents');
            if (!isset($_COOKIE['shipping_protection'])) {
                // Set the 'shipping_protection' cookie
                $cookie_value = '1'; // Replace with the desired value
                setcookie('shipping_protection', $cookie_value, time() + 7 * 24 * 3600, '/'); // Adjust expiration time as needed
        
            }
            $added_checked = '';
            $not_added_checked = 'checked';
            if (isset($_COOKIE['shipping_protection']) && $_COOKIE['shipping_protection'] == '1') {
                // Set the 'shipping_protection' cookie
                $cookie_value = '1'; // Replace with the desired value
                $added_checked = 'checked';
                $not_added_checked = '';
            }
            // echo $added_checked.'=>not'.$not_added_checked;
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                //  $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                if ($product_id == SHIPPING_PROTECTION_PRODUCT) {
                    $added_checked = 'checked';
                    $not_added_checked = '';
                    break;
                }
            }
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                if ($product_id == SHIPPING_PROTECTION_PRODUCT) {
                    // continue;
                }
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>

                    <li
                        class="smile_brilliant-mini-cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                        <?php if (empty($product_permalink)): ?>
                            <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                            ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url($product_permalink); ?>">
                                <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                ?>
                            </a>
                        <?php endif; ?>
                        <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                    ?>
                        <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    //   if (isset($cart_item['addToCartSource']) && strpos($cart_item['addToCartSource'], '/vip') !== false) {
                                    do_action('smilebrilliant_bogo_deal_html', $product_id);
                                    // } ?>
                    </li>
                    <?php
                }
            }

            do_action('woocommerce_mini_cart_contents');
            ?>
        </ul>
        <div class="last-item-cnt">
            <div class="smile_brilliant-mini-cart-item">
                <?php
                $sale_discount = 0;
                $sale_discount_geha = 0;
                $subscriber_exclusive_deals_discount = 0;
                $ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
                $non_ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
                $shipping_protection_price = $non_ng_shipping_protection_price;
                $ng_wht_ids = get_option('ng_wht_ids');
                $display_shipping_protection = true;
                foreach (WC()->cart->get_cart() as $cart_item) {
                    $product = wc_get_product($cart_item['product_id']);
                    if(in_array($cart_item['product_id'],SHINE_REPORT_PRODUCT_IDS)){
                        $display_shipping_protection = false;
                    }
                    // if ($product->get_type() == 'composite') {
                    $new_discount = isset($cart_item['sale_discount']) ? $cart_item['sale_discount'] : 0;
                    $qty = $cart_item['quantity'];
                    $new_discount = $new_discount * $qty;
                    $sale_discount = $sale_discount + $new_discount;

                    $new_discount_geha = isset($cart_item['sale_discount_geha']) ? $cart_item['sale_discount_geha'] : 0;
                    $qty = $cart_item['quantity'];
                    $new_discount_geha = $new_discount_geha * $qty;
                    $sale_discount_geha = $sale_discount_geha + $new_discount_geha;

                    $new_subscriber_exclusive_deals_discount = isset($cart_item['subscriber_exclusive_deals_discount']) ? $cart_item['subscriber_exclusive_deals_discount'] : 0;
                    $qty = $cart_item['quantity'];
                    $new_subscriber_exclusive_deals_discount = (int) $new_subscriber_exclusive_deals_discount * (int) $qty;
                    $subscriber_exclusive_deals_discount = (int) $subscriber_exclusive_deals_discount + (int) $new_subscriber_exclusive_deals_discount;
                    if (is_array($ng_wht_ids) && count($ng_wht_ids) > 0 && in_array($cart_item['product_id'], $ng_wht_ids)) {
                        $shipping_protection_price = $ng_shipping_protection_price;
                    }
                    if ($cart_item['product_id'] == SHIPPING_PROTECTION_PRODUCT) {
                        $shipping_protection_price = $cart_item['line_subtotal'];
                    }
                    //  }
                }
                if ($sale_discount > 0) {
                    ?>
                    <div class="shipping-mini-cart sale-discont">
                        <span class="shpping-text">Sale Discount:</span>
                        <span class="shppng-nmber"> -$<?php echo $sale_discount; ?></span>
                    </div>
                    <?php
                }
                if ($sale_discount_geha > 0) {
                    ?>
                    <div class="shipping-mini-cart sale-discont">
                        <span class="shpping-text">Geha Sale Discount:</span>
                        <span class="shppng-nmber"> -$<?php echo $sale_discount_geha; ?></span>
                    </div>
                    <?php
                }
                if ($subscriber_exclusive_deals_discount > 0) {
                    ?>
                    <div class="shipping-mini-cart sale-discont">
                        <span class="shpping-text">Exclusive Deals Discount:</span>
                        <span class="shppng-nmber"> -$<?php echo $subscriber_exclusive_deals_discount; ?></span>
                    </div>
                    <?php
                }
                ?>

            </div>
            <?php

            if (count(WC()->cart->get_coupons()) > 0) {
                ?>

                <?php
                foreach (WC()->cart->get_coupons() as $code => $coupon):
                    ?>

                    <div class="couponRow smile_brilliant-mini-cart-item">
                        <h5 class="section-title pull-left " id="shopping_cart_coupon_list_title" style="">DISCOUNT</h5>

                        <a href="<?php echo site_url('?remove_coupon=' . $code) ?>" class="remove" aria-label="Remove">
                            <i class="fa fa-close"></i>
                        </a>
                        <a class="text-description" href="javascript:;">
                            <?php wc_cart_totals_coupon_label($coupon); ?>

                            <?php wc_cart_totals_coupon_html($coupon); ?>
                        </a>


                    </div>

                    <?php
                endforeach;
            }
            /*
            ?>

            <div id="shopping-cart-shipping-total" class="shipping-mini-cart">
                <span class="shpping-text">Shipping:</span>
                <?php
                $shippingCost = 0;
                if (WC()->session->get('cart_totals')['shipping_total'] > 0) {
                    $shippingCost = get_woocommerce_currency_symbol() . number_format((float) WC()->session->get('cart_totals')['shipping_total'], 2, '.', '');
                    //$shippingCost = get_woocommerce_currency_symbol() . WC()->session->get('cart_totals')['shipping_total'];
                } else {
                    $shippingCost = 'FREE';
                }
                ?>
                <span class="shppng-nmber"> <?php echo $shippingCost; ?></span>
            </div>
            <?php 
            if (WC()->session->get('cart_totals')['total_tax'] > 0) : ?>
              <div id="shopping-cart-shipping-total" class="shipping-mini-cart" style="border-top: none;">
                    <span class="shpping-text">Sales tax:</span>
                    <?php
                    $taxAmount = get_woocommerce_currency_symbol() . number_format((float) WC()->session->get('cart_totals')['total_tax'], 2, '.', '');
                    ?>
                    <span class="shppng-nmber"><?php echo $taxAmount; ?></span>
                </div>
            <?php endif;
            */ ?>

            <h5 class="section-title" id="shopping_cart_coupon_list_title">SUB TOTAL

                <?php
                /**
                 * Hook: woocommerce_widget_shopping_cart_total.
                 *
                 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
                 */
                //  echo WC()->cart->total;
                // echo wc_cart_totals_order_total_html();
                echo WC()->cart->get_cart_subtotal();
                /*
                 <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span><?php echo  WC()->cart->total; ?></bdi></span>
                */
                ?>

            </h5>
            <?php if($display_shipping_protection) { 
               // echo $cart_item['product_id'];
                ?>
            <div class="shipping-protection">
                <div class="row-flex">
                    <div class="image-protection">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shipping-protection-v2.png"
                            alt="Shipping Protection">
                    </div>
                    <div class="protection-content-text">
                        <div class="protection-tp">
                            <h3 class="font-mont">Shipping Protection</h3>
                            <div class="addon-module-price">
                                <?php
                                 if ((is_user_logged_in() && get_user_meta(get_current_user_id(), 'is_shine_user', true) == '1') || (isset($_COOKIE['shine_user']) && $_COOKIE['shine_user'] != '')) {
                                    ?>
                                     <span class="upcart-addons-price">Free</span>
                                     <?php
                                 } else {
                                 ?>
                                <span class="upcart-addons-price">$<?php echo $shipping_protection_price ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <p>Protect your order from damage, loss,<br /> or theft during shipping.</p>
                    </div>


                    <div class="toggle-button">
                        <fieldset class="radio-switch">
                            <input type="radio" name="enable_shipping_protection" id="on-option" <?php echo $added_checked; ?> value="1" class="button-toggle-protection"
                                onchange="updateShippingProtection(this)">
                            <label for="on-option" class="iconcheck">
                                <i class="fa fa-check fa-6" aria-hidden="true"></i>
                                <span style="opacity:0;">On</span>
                            </label>

                            <input type="radio" name="enable_shipping_protection" <?php echo $not_added_checked; ?>
                                id="off-option" value="0" class="button-toggle-protection"
                                onchange="updateShippingProtection(this)">
                            <label for="off-option">
                                <div class="styles_ToggleSwitch__loading__L2jDv">
                                    <div class="styles_ToggleSwitch__loader__WIEMd"></div>
                                </div>
                                <span style="opacity:0;">Off</span>
                            </label>
                        </fieldset>
                    </div>


                </div>
            </div>
            <? } ?>
            <div class="shipping-free-text ">
                Domestic shipping will be free for orders with a value of <b>$35</b> or more.
            </div>
            <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
        </div>

        <p class="woocommerce-mini-cart__buttons buttons"><a href="javascript:void(0);"
                class="button wc-forward continue-shopping">Continue
                Shopping</a><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>



    <?php else: ?>

        <div class="shopping_cart_dropdown text-center" style="" id="shopping_cart_dropdown_no_items">

            <?php echo __(' There Are Currently No Items In Your Shopping Cart', 'woocommerce'); ?>
            <div style="padding-top:20px;clear:both;">
                <a href="<?php echo site_url('/') ?>" rel="nofollow"
                    class="btn btn-primary btn-primary-blue btn-xs upper pull-right">
                    <?php echo __('Shop Now', 'woocommerce'); ?>
                </a>
            </div>
        </div>


    <?php endif; ?>
</div>
<?php do_action('woocommerce_after_mini_cart'); ?>
<style>
    .woocommerce-remove-coupon {
        display: none !important;
    }

    p.woocommerce-mini-cart__buttons.buttons a.button.wc-forward:nth-child(2) {
        display: none !important;
    }

    p.woocommerce-mini-cart__buttons.buttons a.button.wc-forward:nth-child(1) {
        display: flex !important;
    }

    .smile_brilliant-mini-cart-item dl.variation {
        display: none !important;
    }
</style>
<script>
    jQuery('body').on('click', '.smile_brilliant-mini-cart-item .remove , .smile_brilliant-mini-cart-item .removesmilecart', function () {
        jQuery(this).parent('.smile_brilliant-mini-cart-item').addClass('removing');
    });
    jQuery('body').on('click', '.continue-shopping', function () {

    var closeiconbtn = jQuery('#side-cart').find('.thb-mobile-close');
    
    if (closeiconbtn.length) {
        console.log("Close button found:", closeiconbtn);
        
        // Trigger the click event using native DOM method
        setTimeout(function() {
            closeiconbtn.each(function() {
                this.click();  // Use native DOM click()
            });
        }, 500);  // Optional delay to ensure all events are ready
    } else {
        console.log("Close button not found");
    }
});
</script>