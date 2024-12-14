<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */
defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
    ?>

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
                <?php endif; ?>
            </p>

        <?php else : ?>

            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                                  
                                                                                                            ?></p>

            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                <li class="woocommerce-order-overview__order order">
                    <?php esc_html_e('Order number:', 'woocommerce'); ?>
                    <strong><?php
                            $order_number_formatted = '';
                            if (get_post_meta($order->get_id(), '_order_number_formatted', true)) {
                                $order_number_formatted = get_post_meta($order->get_id(), '_order_number_formatted', true);
                            } else {
                                $order_number_formatted = wc_seq_order_number_pro()->find_order_by_order_number($order->get_order_number()); //$order->get_order_number(); 
                            }
                            echo $order_number_formatted;
                            ?></strong>
                </li>

                <li class="woocommerce-order-overview__date date">
                    <?php esc_html_e('Date:', 'woocommerce'); ?>
                    <strong><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                                 
                            ?></strong>
                </li>

                <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                    <li class="woocommerce-order-overview__email email">
                        <?php esc_html_e('Email:', 'woocommerce'); ?>
                        <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                                 
                                ?></strong>
                    </li>
                <?php endif; ?>

                <li class="woocommerce-order-overview__total total">
                    <?php esc_html_e('Total:', 'woocommerce'); ?>
                    <strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                                 
                            ?></strong>
                </li>

                <?php if ($order->get_payment_method_title()) : ?>
                    <li class="woocommerce-order-overview__payment-method method">
                        <?php esc_html_e('Payment method:', 'woocommerce'); ?>
                        <strong><?php
                                if (get_post_meta($order->get_id(), '_payment_method', true) == 'authorize_net_cim_credit_card') {
                                    echo wp_kses_post($order->get_payment_method_title());
                                    echo '&nbsp;(' . ucfirst(get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_card_type', true)) . '&nbsp;-&nbsp;****' . get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_account_four', true) . ')';
                                } else {
                                    echo wp_kses_post($order->get_payment_method_title());
                                }
                                ?></strong>
                    </li>
                <?php endif; ?>

            </ul>
            <!-- Event snippet for Purchase conversion page -->
            <?php
            $orderStatuses = array('processing', 'on-hold', 'completed');
            if (in_array($order->get_status(), $orderStatuses)) {
                $transaction_id = $order->get_transaction_id();
                $amount = $order->get_total();
                $order_shipping = $order->get_shipping_total();
            ?>
                <script>
                    window.uetq = window.uetq || [];
                    window.uetq.push('event', 'purchase', {
                        "revenue_value": <?php echo $amount ?>,
                        "currency": "USD"
                    });
                </script>
                <script type='text/javascript'>
                    var AddShoppersWidgetOptions = {
                        'loadCss': false,
                        'pushResponse': false
                    };
                    AddShoppersConversion = {
                        order_id: "<?php echo $order_number_formatted; ?>",
                        value: "<?php echo $amount ?>",
                        email: "<?php echo $order->get_billing_email(); ?>"
                    };
                    var js = document.createElement('script');
                    js.type = 'text/javascript';
                    js.async = true;
                    js.id = 'AddShoppers';
                    js.src = ('https:' == document.location.protocol ? 'https://shop.pe/widget/' : 'http://d3rr3d0n31t48m.cloudfront.net/widget/') + 'widget_async.js#5c617c03bbddbd44eae72714';
                    document.getElementsByTagName('head')[0].appendChild(js);
                   // AddShoppersWidget.track_conv();
                </script>
                  <img src="https://trkn.us/pixel/c?ppt=20516&g=sign_up&gid=48033&cv1=<?php echo $order->get_customer_id(); ?>" height="0" width="0" border="0"  />
                <img src="https://trkn.us/pixel/c?ppt=20516&g=purchase&gid=48034&cv1=<?php echo $order->get_customer_id(); ?>&rev=<?php echo $amount ?>" height="0" width="0" border="0"  />

                <!-- Event snippet for Purchase/Sale conversion page -->
                <script type="text/javascript">
                    // GA Tracking
                    /*ga('require', 'ecommerce');
                    ga('ecommerce:addTransaction', {
                        'id': '<?php echo $order_number_formatted; ?>', // Transaction ID. Required
                        //   'affiliation': 'smile-brilliant', // Affiliation or store name
                        'revenue': '<?php echo $amount ?>', // Grand Total.
                        'shipping': '<?php echo $order_shipping; ?>', // Shipping.
                        'tax': '<?php echo $order->get_total_tax(); ?>', // Tax.
                        'currency': 'USD'
                    });*/
                    <?php
                    $new_customer = 'true';
                    $coupons_string = '';
                    if (has_bought_mbt($order->get_customer_id())) {
                        $new_customer = 'false';
                    }
                    $freindBuyProducts_array = array();
                    // Deprecated
                    // if ($order->get_used_coupons()) {
                    //     $coupons_count = count($order->get_used_coupons());
                    //     $i = 1;
                    //     foreach ($order->get_used_coupons() as $coupon) {
                    //         $coupons_string .= $coupon;
                    //         if ($i < $coupons_count)
                    //             $coupons_string .= ', ';
                    //         $i++;
                    //     }
                    // }
                    if ($order->get_coupon_codes()) {
                        $coupons_count = count($order->get_coupon_codes()); // Get the number of coupons
                        $i = 1;
                        foreach ($order->get_coupon_codes() as $coupon) {
                            $coupons_string .= $coupon; // Append coupon code to the string
                            if ($i < $coupons_count) {
                                $coupons_string .= ', '; // Add a comma if it's not the last coupon
                            }
                            $i++;
                        }
                    }
                    foreach ($order->get_items() as $item) {

                        if (wc_cp_get_composited_order_item_container($item, $order)) {
                            continue;
                            /* Composite Prdoucts Child Items */
                        }

                        $get_item = new WC_Product($item['product_id']);
                        $item_sku = $get_item->get_sku();
                        $item_qty = $item['qty'];
                        $item_price = $item['line_subtotal'];
                        $item_name = $item['name'];
                        $freindBuyProducts_array[] = array('quantity' => $item_qty, 'price' => (int) $item_price, 'name' => $item_name, 'sku' => $item_sku);
                    ?>

                        /*ga('ecommerce:addItem', {
                            'id': '<?php echo $order_number_formatted; ?>', // Transaction ID. Required.
                            'name': '<?php echo $item_name ?>', // Product name. Required.
                            'sku': '<?php echo $item_sku ?>', // SKU/code.
                            'category': '', // Category or variation.
                            'price': '<?php echo $item_price ?>', // Unit price.
                            'quantity': '<?php echo $item_qty ?>'  // Quantity.
                        });
                        ga('ecommerce:send');*/
                    <?php }
                    $freindBuyProductsJson = json_encode($freindBuyProducts_array);


/*
                    ?>


                    gtag('event', 'conversion', {
                        'send_to': 'AW-991526735/4QD5CJX3xl4Qz_7l2AM',
                        'value': '<?php echo $amount ?>',
                        'currency': 'USD',
                        'transaction_id': '<?php echo $transaction_id; ?>'
                    });


                    <?php  */  ?>
                </script>
                <!-- <script>
                    friendbuyAPI.push([
                        "track",
                        "purchase",
                        {
                            id: "<?php //echo $order_number_formatted; ?>",
                            amount: <?php //echo $amount; ?>,
                            currency: "USD",
                            isNewCustomer: <?php // echo $new_customer; ?>,
                            couponCode: "<?php //echo $coupons_string; ?>",
                            //  giftCardCodes: [INSERT_STRING_HERE, ...ADDITIONAL_STRINGS_IF_NECESSARY],
                            customer: {
                                email: "<?php //echo $order->get_billing_email(); ?>",
                                name: "<?php //echo  $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?>",
                                id: "<?php //echo $order->get_customer_id(); ?>",
                            },
                            products: <?php // echo  $freindBuyProductsJson; ?>,

                        },
                    ]);
                </script> -->

        <?php
            }
        endif;
        ?>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

    <?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), null); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                                 
                                                                                                        ?></p>

    <?php endif; ?>

</div>