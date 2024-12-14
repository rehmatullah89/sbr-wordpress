<?php
add_filter('woocommerce_package_rates', 'smile_brilliant_woocommerce_tiered_shipping', 9999, 2);
/**
 * Apply tiered shipping rates based on cart contents.
 *
 * @param array $rates   Array of shipping rates.
 * @param array $package Array of shipping package details.
 *
 * @return array Modified array of shipping rates.
 */
function smile_brilliant_woocommerce_tiered_shipping($rates, $package)
{
    $productWeightsTotal = 0;
    global $woocommerce;
    $gehaFEE = 0;
    $shippingCharge = array();
    if (!WC()->cart->is_empty()) {

        $quantities = WC()->cart->get_cart_item_quantities();
        $items = $woocommerce->cart->get_cart();
        foreach ($items as $values) {
            $product_id = $values['data']->get_id();
            if (isset($values['gehaVariant'])) {
                $shippingCharge[$product_id] = $values['gehaVariant'];
            }
            $productWeights = get_post_meta($product_id, '_first_shipment_weight', true);
            $totalCountProductWeight = 0;
            if($productWeights){
                $totalCountProductWeight = $quantities[$product_id] * $productWeights;
            }
            $productWeightsTotal = (int) $productWeightsTotal + (int) $totalCountProductWeight;
        }
        $targeted_id = 130266;
        // Get quantities for each item in cart (array of product id / quantity pairs)
        // Displaying the quantity if targeted product is in cart
        if (isset($quantities[$targeted_id]) && $quantities[$targeted_id] > 0) {
            $gehaFEE = $quantities[$targeted_id] * 7.50;
            $gehaFEE = 0;
        }
        if (isset($shippingCharge[$targeted_id]) && $shippingCharge[$targeted_id] ===  'yes') {
            $gehaFEE = 0;
        }
    }
    // Sort shipping methods based on cost
    uasort($rates, function ($a, $b) {
        if ($a == $b)
            return 0;
        return ($a->cost < $b->cost) ? -1 : 1;
    });
    $couponFee = 0;
    if (!empty($woocommerce->cart->applied_coupons)) {
        foreach ($woocommerce->cart->get_applied_coupons() as $key => $applied_coupon) {
            $applied_couponObj = new WC_Coupon($applied_coupon);
            $couponFee = $applied_couponObj->get_meta('custom_shipping_fees');
        }
        if ($couponFee > 0) {
            $gehaFEE = (int) $gehaFEE + (int) $couponFee;
        }
    }
    $hideMedthods = array(
        15, 16, 17, 18, 19, 20, 21, 22, 23 , 24
    );

    // echo '<pre>';
    // print_r($hideMedthods);
    // echo '</pre>';
    foreach ($rates as $rate_id => $rate) {
        // echo '<pre>';
        // print_r($rate->instance_id);
        // echo '</pre>';
        if (in_array($rate->instance_id, $hideMedthods)) {
            unset($rates[$rate_id]);
        }
    }

    if ($gehaFEE > 0) {
        foreach ($rates as $rate) {
            $rate->cost = (int) $rate->cost + (int) $gehaFEE;
        }
    } else {
        foreach ($rates as $rate) {
            if ('free_shipping' === $rate->method_id) {
                $rate->label = $rate->label . ' - FREE';
            }
        }
    }
    return $rates;
}
/**
 * Add demo data to create a WooCommerce order for a customer.
 *
 * @param array  $customer      Customer details.
 * @param int    $customer_ID   Customer ID.
 * @param int    $product_id    Product ID to be added to the order.
 * @param int    $qty           Quantity of the product to be added.
 *
 * @throws Exception When encountering an invalid product or other errors.
 */
function add_demo_data_sbr($customer, $customer_ID, $product_id, $qty)
{


    $billing_address = array(
        'first_name' => $customer['first_name'],
        'last_name' => $customer['last_name'],
        'company' => 'Testing, LLC',
        'email' => $customer['email'],
        'phone' => $customer['address']['phone'],
        'address_1' => $customer['address']['address'],
        'address_2' => '',
        'city' => $customer['address']['city'],
        'state' => $customer['address']['state'],
        'postcode' => $customer['address']['zip'],
        'country' => $customer['address']['country']
    );

    $shipping_address = array(
        'first_name' => $customer['first_name'],
        'last_name' => $customer['last_name'],
        'company' => 'Testing, LLC',
        'email' => $customer['email'],
        'phone' => $customer['address']['phone'],
        'address_1' => $customer['address']['address'],
        'address_2' => '',
        'city' => $customer['address']['city'],
        'state' => $customer['address']['state'],
        'postcode' => $customer['address']['zip'],
        'country' => $customer['address']['country']
    );
    $_POST['action'] = 'woocommerce_add_order_item';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    echo '<pre>';
    print_r($billing_address);
    echo '</pre>';

    $args = array(
        'customer_id' => $customer_ID,
        //  'parent' => $old_order->get_id(),
    );
    $order = wc_create_order($args);
    //$order = wc_get_order($order->get_id());
    $order->set_address($billing_address, 'billing');
    $order->set_address($shipping_address, 'shipping');

    smile_brillaint_set_sequential_order_number($order->get_id());
    smile_brillaint_get_sequential_order_number($order->get_id());

    //  $product_id = 130255;

    $product_id = absint($product_id);
    $product = wc_get_product($product_id);
    $qty = 1;


    if (!$product) {
        throw new Exception(__('Invalid product ID', 'woocommerce') . ' ' . $product_id);
    }
    if ('variable' === $product->get_type()) {
        /* translators: %s product name */
        throw new Exception(sprintf(__('%s is a variable product parent and cannot be added.', 'woocommerce'), $product->get_name()));
    }
    $validation_error = new WP_Error();
    $validation_error = apply_filters('woocommerce_ajax_add_order_item_validation', $validation_error, $product, $order, $qty);

    if ($validation_error->get_error_code()) {
        throw new Exception('<strong>' . __('Error:', 'woocommerce') . '</strong> ' . $validation_error->get_error_message());
    }


    $item_id = $order->add_product($product, $qty);

    $item = apply_filters('woocommerce_ajax_order_item', $order->get_item($item_id), $item_id, $order, $product);

    $added_items[$item_id] = $item;
    $order_notes[$item_id] = $product->get_formatted_name();

    if ($product->managing_stock()) {
        $new_stock = wc_update_product_stock($product, $qty, 'decrease');
        $order_notes[$item_id] = $product->get_formatted_name() . ' &ndash; ' . ($new_stock + $qty) . '&rarr;' . $new_stock;
        // wc_update_order_item_meta($item_id, '_reduced_stock', $qty);
        $item->add_meta_data('_reduced_stock', $qty, true);
    }


    $item->save();
    $order->calculate_totals();
    $order->save();
    ///$order = wc_get_order($order->get_id());


    do_action('woocommerce_ajax_add_order_item_meta', $item_id, $item, $order);

    $order->add_order_note(sprintf(__('Added line items: %s', 'woocommerce'), implode(', ', $order_notes)), false, true);

    do_action('woocommerce_ajax_order_items_added', $added_items, $order);
}
/**
 * AJAX callback function for creating an addon order.
 */
add_action('wp_ajax_creatAddon', 'createAddon_callback');

/**
 * Callback function to create an addon order.
 *
 * Handles AJAX requests to create an addon order based on the provided parameters.
 */
function createAddon_callback()
{

    $old_order_id = $_REQUEST['order_id'];
    $old_order_item_id = $_REQUEST['old_order_item_id'];
    $old_order = wc_get_order($old_order_id);
    $billing_address = array(
        'first_name' => $old_order->get_billing_first_name(),
        'last_name' => $old_order->get_billing_last_name(),
        'company' => $old_order->get_billing_company(),
        'email' => $old_order->get_billing_email(),
        'phone' => $old_order->get_billing_phone(),
        'address_1' => $old_order->get_billing_address_1(),
        'address_2' => $old_order->get_billing_address_2(),
        'city' => $old_order->get_billing_city(),
        'postcode' => $old_order->get_billing_postcode(),
        'state' => $old_order->get_billing_state(),
        'country' => $old_order->get_billing_country()
    );
    if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {
        $token_id = isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) ? $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] : 0;
        if ($token_id) {
            $billTo = isset($_REQUEST['ppAddress'][$token_id]) ? json_decode(stripslashes($_REQUEST['ppAddress'][$token_id]), true) : Null;
            if (isset($billTo['firstName'])) {
                $billing_address['first_name'] = $billTo['firstName'];
            }
            if (isset($billTo['lastName'])) {
                $billing_address['last_name'] = $billTo['lastName'];
            }
            if (isset($billTo['address'])) {
                $billing_address['address_1'] = $billTo['address'];
                $billing_address['address_2'] = '';
            }
            if (isset($billTo['city'])) {
                $billing_address['city'] = $billTo['city'];
            }
            if (isset($billTo['state'])) {
                $billing_address['state'] = $billTo['state'];
            }
            if (isset($billTo['zip'])) {
                $billing_address['postcode'] = $billTo['zip'];
            }
            if (isset($billTo['country'])) {
                $billing_address['country'] = $billTo['country'];
            }
            if (isset($billTo['phoneNumber'])) {
                $billing_address['phone'] = $billTo['phoneNumber'];
            }
        } else {
            $response = array(
                'msg' => 'Payment profile missing.',
                'error' => true
            );
            echo json_encode($response);
            die;
        }
    }

    if (isset($_REQUEST['product_id']) && is_array($_REQUEST['product_id']) && count($_REQUEST['product_id']) > 0) {
        global $wpdb;
        $payemt_note = '';

        $shipping_address = array(
            'first_name' => $old_order->get_shipping_first_name(),
            'last_name' => $old_order->get_shipping_last_name(),
            'company' => $old_order->get_shipping_company(),
            'address_1' => $old_order->get_shipping_address_1(),
            'address_2' => $old_order->get_shipping_address_2(),
            'city' => $old_order->get_shipping_city(),
            'postcode' => $old_order->get_shipping_postcode(),
            'state' => $old_order->get_shipping_state(),
            'country' => $old_order->get_shipping_country()
        );

        $args = array(
            'customer_id' => $old_order->get_user_id(),
            //  'parent' => $old_order->get_id(),
        );

        // Create the order and assign it to the current user
        $order = wc_create_order($args);
        $order = wc_get_order($order->get_id());
        $order->set_address($billing_address, 'billing');
        $order->set_address($shipping_address, 'shipping');
        $child_order_id = $order->get_id();
        smile_brillaint_set_sequential_order_number($child_order_id);
        smile_brillaint_get_sequential_order_number($child_order_id);
        $products = $_REQUEST['product_id'];
        $items_qty = $_REQUEST['item_qty'];
        $discount = $_REQUEST['discount'];


        $discountAmount = 0;

        if ($products) {
            foreach ($products as $key => $p) {

                $product_id = absint($p);
                $product = wc_get_product($product_id);
                $qty = 1;
                if ($items_qty[$key]) {
                    $qty = $items_qty[$key];
                }
                $dis_percentge = 0;
                if ($discount[$key]) {
                    $dis_percentge = $discount[$key];
                }

                if ($dis_percentge) {
                    $regular_price = (float) $product->get_regular_price();
                    $cal_discount = $dis_percentge * $regular_price / 100;
                    $discountAmount = (int) $discountAmount + (int) $cal_discount;
                }

                if (!$product) {
                    throw new Exception(__('Invalid product ID', 'woocommerce') . ' ' . $product_id);
                }
                if ('variable' === $product->get_type()) {
                    /* translators: %s product name */
                    throw new Exception(sprintf(__('%s is a variable product parent and cannot be added.', 'woocommerce'), $product->get_name()));
                }
                $validation_error = new WP_Error();
                $validation_error = apply_filters('woocommerce_ajax_add_order_item_validation', $validation_error, $product, $order, $qty);

                if ($validation_error->get_error_code()) {
                    throw new Exception('<strong>' . __('Error:', 'woocommerce') . '</strong> ' . $validation_error->get_error_message());
                }
                $_POST['action'] = 'woocommerce_add_order_item';

                $item_id = $order->add_product($product, $qty);

                $item = apply_filters('woocommerce_ajax_order_item', $order->get_item($item_id), $item_id, $order, $product);

                $added_items[$item_id] = $item;
                $order_notes[$item_id] = $product->get_formatted_name();

                if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] > 0) {
                    ///$old_order_item_id = $_REQUEST['parent_item_id'][$product_id_key];
                    wc_update_order_item_meta($item_id, 'parent_item_id', $old_order_item_id);
                } else {
                    wc_update_order_item_meta($item_id, 'parent_item_id', $old_order_item_id);
                }


                $item->save();
                do_action('woocommerce_ajax_add_order_item_meta', $item_id, $item, $order);
            }
            $order->calculate_totals();
            $order->save();
            $order->add_order_note(sprintf(__('Added line items: %s', 'woocommerce'), implode(', ', $order_notes)), false, true);

            do_action('woocommerce_ajax_order_items_added', $added_items, $order);
        }
        $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
        if ($addOn_amount > 0) {
            if ($discountAmount > 0) {

                $item = new WC_Order_Item_Fee();
                $item->set_name('Discount');
                $item->set_amount('-' . $discountAmount);
                $item->set_total('-' . $discountAmount);
                $item->set_taxes(false);
                $item->save();
                $order->add_item($item);
                update_post_meta($order->get_id(), '_cart_discount', $discountAmount);
            }
        }
        //  if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] != 'free') {
        if (isset($_REQUEST['shipping_method_id']) && $_REQUEST['shipping_method_id'] > 0) {


            $countery_code = $order->get_shipping_country();
            // Set the array for tax calculations
            $calculate_tax_for = array(
                'country' => $countery_code,
                'state' => $order->get_shipping_state(), // Can be set (optional)
                'postcode' => $order->get_shipping_postcode(), // Can be set (optional)
                'city' => $order->get_shipping_city(), // Can be set (optional)
            );
            $method_instance_id = $_REQUEST['shipping_method_id'];
            $shipping_method = mbt_shipping_name_by_id($method_instance_id);

            // Optionally, set a total shipping amount
            $shipping_cost = $_REQUEST['addOnShippingCostAmount'];
            if ($shipping_cost == '') {
                $shipping_cost = 0;
            }
            // Get a new instance of the WC_Order_Item_Shipping Object
            $item_fee = new WC_Order_Item_Shipping();
            $item_fee->set_method_title($shipping_method['title']);
            $item_fee->set_method_id($shipping_method['method']); // set an existing Shipping method rate ID
            $item_fee->set_instance_id($method_instance_id); //
            $item_fee->set_total($shipping_cost); // (optional)
            $item_fee->calculate_taxes($calculate_tax_for);
            $order->add_item($item_fee);
            update_post_meta($order->get_id(), '_order_shipping', $shipping_cost);
            // }
        }
        $order->calculate_totals();
        //  $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
        $order->set_total($addOn_amount);


        update_post_meta($child_order_id, '_postedData', json_encode($_REQUEST));
        $payemt_note = '';
        $paymentFlagError = false;
        $order->save();
        if (function_exists('w3tc_pgcache_flush_post')) {
            w3tc_pgcache_flush_post($child_order_id);
        }
        $keyUpdate = 0;
        $orderObj = wc_get_order($child_order_id);
        $parentQtyObj = array();
        foreach ($orderObj->get_items() as $item_id => $item) {
            if (wc_cp_is_composite_container_order_item($item)) {
                $_composite_parent =  wc_get_order_item_meta($item_id, '_composite_cart_key',  true);
                $parentQtyObj[$_composite_parent] = $item->get_quantity();
            }
        }
        foreach ($orderObj->get_items() as $item_id => $item) {

            $log_visible = false;
            // if (wc_cp_get_composited_order_item_container($item, $order)) {
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                /* Composite Prdoucts Child Items */
                $_composite_parent =  wc_get_order_item_meta($item_id, '_composite_parent',  true);
                if(isset($parentQtyObj[$_composite_parent])){
                    $childQty = $item->get_quantity();
                    wc_delete_order_item_meta($item_id , '_reduced_stock');
                    wc_update_product_stock($item->get_product_id(), $childQty, 'increase', false);
                    $_composite_item_id =  wc_get_order_item_meta($item_id, '_composite_item',  true);
                    $_composite_data =  wc_get_order_item_meta($item_id, '_composite_data',  true);
                foreach ($_composite_data as $_composite_data_key => $_composite_data_info) {
                  if($_composite_item_id == $_composite_data_key){
                    $newQty = $parentQtyObj[$_composite_parent] * $_composite_data_info['quantity_min'];
                    if($childQty != $newQty){
                        wc_update_order_item_meta($item_id, '_qty',  $newQty);
                    }
                   
                  }
                }
              }
            
            }
        }
        $orderObj->save();
        if (function_exists('w3tc_pgcache_flush_post')) {
            w3tc_pgcache_flush_post($child_order_id);
        }


        if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {
            if (is_numeric($addOn_amount) && $addOn_amount > 0) {
                $token_id = isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) ? $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] : 0;
                if ($token_id) {
                    $payment_param = array(
                        'token_id' => $token_id,
                        'amount' => $addOn_amount,
                        'order_id' => $child_order_id,
                    );
                    $aimResponse = sbr_chargePaymentProfile($payment_param);
                    $payemt_note = $aimResponse['note'];
                    $paymentFlagError = $aimResponse['errorflag'];
                }
            } else {
                //mbt_goodToShip($child_order_id);
            }
        } else if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'email') {

            do_action('woocommerce_before_resend_order_emails', $order, 'customer_invoice');
            // Send the customer invoice email.
            WC()->payment_gateways();
            WC()->shipping();
            WC()->mailer()->customer_invoice($order);
            // Note the event.
            $order->add_order_note(__('Order details manually sent to customer.', 'woocommerce'), false, true);
            do_action('woocommerce_after_resend_order_email', $order, 'customer_invoice');
        } else {
            /*Star New Code */
            if (function_exists('w3tc_pgcache_flush_post')) {
                w3tc_pgcache_flush_post($child_order_id);
            }
            $orderObj = wc_get_order($child_order_id);
            foreach ($orderObj->get_items() as $item_id => $item) {

                $log_visible = false;
                // if (wc_cp_get_composited_order_item_container($item, $order)) {
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                    /* Composite Prdoucts Child Items */
                } else if (wc_cp_is_composite_container_order_item($item)) {

                    /* Composite Prdoucts Parent Item */
                    $log_visible = true;
                } else {
                    $log_visible = true;
                }
                if ($log_visible) {
                    wc_update_order_item_meta($item_id, '_item_type', 'rma');
                    wc_update_order_item_meta($item_id, '_line_subtotal',  0);
                    wc_update_order_item_meta($item_id, '_line_total',  0);
                    $wpdb->update('wp_woocommerce_order_itemmeta', array(
                        'meta_value' => 0,
                    ), array('meta_key' => '_line_subtotal', 'order_item_id' => $item_id));

                    $wpdb->update('wp_woocommerce_order_itemmeta', array(
                        'meta_value' => 0,
                    ), array('meta_key' => '_line_total', 'order_item_id' => $item_id));
                }
            }
            $orderObj->set_total(0);
            $orderObj->save();
            if (function_exists('w3tc_pgcache_flush_post')) {
                w3tc_pgcache_flush_post($child_order_id);
            }
            /*End New Code */
            mbt_goodToShip($child_order_id);
        }
        smile_brillaint_GEHA_tag($child_order_id);
        $order->save();
        //   die;
        if (isset($_REQUEST['log_id']) && $_REQUEST['log_id'] != 0) {
            $update = array(
                'child_order_id' => $child_order_id,
                'log_update' => 1,
            );
            if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] > 0) {
                $update['note'] = 'RMA Order Created. Order Number ' . get_post_meta($child_order_id, 'order_number', true);
            } else {
                $update['note'] = 'Addon Order Created. Order Number ' . get_post_meta($child_order_id, 'order_number', true);
            }
            $condition = array(
                "log_id" => $_REQUEST['log_id'],
            );
            $wpdb->update(SB_LOG, $update, $condition);
        }

        mbt_goodToShip($child_order_id, 'no');
        if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] > 0) {
            if (isset($_REQUEST['parent_item_id']) && is_array($_REQUEST['parent_item_id'])) {
                foreach ($_REQUEST['parent_item_id'] as $product_id_key => $new_item_id) {

                    $event_id = 8;
                    $event_data = array(
                        "order_id" => $old_order_id,
                        "child_order_id" => $child_order_id,
                        "item_id" => $new_item_id,
                        "product_id" => $_REQUEST['parent_product_id'][$product_id_key],
                        "event_id" => $event_id,
                    );
                    // sb_create_log($event_data);
                    $event_id = 12;
                    if ($_REQUEST['type'][$product_id_key] == 'composite') {
                        $addonProduct = get_post_meta($_REQUEST['parent_product_id'][$product_id_key], 'addonChildProduct', true);
                        if ($addonProduct == $_REQUEST['product_id'][$product_id_key]) {
                            update_post_meta($new_item_id, 'rma_request', true);
                            ///   $event_id = 3;
                        }
                    }
                    $event_data = array(
                        "order_id" => $old_order_id,
                        "child_order_id" => $child_order_id,
                        "item_id" => $new_item_id,
                        "product_id" => $_REQUEST['parent_product_id'][$product_id_key],
                        "event_id" => $event_id,
                        "note" => 'RMA Order Created. Order Number ' . get_post_meta($child_order_id, 'order_number', true)
                    );
                    sb_create_log($event_data);


                    $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $old_order_id and item_id = $new_item_id");
                    if ($query_tray_no) {
                        $update = array(
                            'tray_number' => $query_tray_no,
                        );
                        $condition = array(
                            "order_id" => $child_order_id,
                        );
                        $wpdb->update(SB_ORDER_TABLE, $update, $condition);
                    }
                }
            }
        } else {

            $event_id = 3;
            //Create Log
            $event_data = array(
                "order_id" => $old_order_id,
                "child_order_id" => $child_order_id,
                "item_id" => $old_order_item_id,
                "product_id" => $_REQUEST['parent_product_id'],
                "event_id" => $event_id,
                "extra_information" => $_REQUEST['impression_status'],
            );
            sb_create_log($event_data);

            $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $old_order_id and item_id = $old_order_item_id");
            if ($query_tray_no) {
                $update = array(
                    'tray_number' => $query_tray_no,
                );
                $condition = array(
                    "order_id" => $child_order_id,
                );
                $wpdb->update(SB_ORDER_TABLE, $update, $condition);
            }
        }

        update_post_meta($child_order_id, 'parent_order_id', $old_order_id);
        if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] > 0) {
            update_post_meta($child_order_id, 'order_type', 'RMA');
        } else {
            update_post_meta($child_order_id, 'order_type', 'Addon');
            update_post_meta($child_order_id, 'source', 'detail');
        }
        update_post_meta($child_order_id, '_createdByCSR', 'yes');
        update_post_meta($child_order_id, '_csr_id', get_current_user_id());
        $response = array(
            'msg' => $payemt_note,
            'error' => false
        );
        echo json_encode($response);
        die;
    } else {
        $response = array(
            'msg' => 'No Product Selected Please Select Addon Product.',
            'error' => true
        );
        echo json_encode($response);
        die;
    }
    die;
}

add_action('save_post_product', 'save_composite_product_min_max_callback');
/**
 * Callback function to update min and max quantities for composite products during three-way shipment.
 */
function save_composite_product_min_max_callback()
{
    if (isset($_POST['three_way_ship_product'])) {
        if (isset($_POST['bto_data'])) {
            $bto_data = array();
            foreach ($_POST['bto_data'] as $key => $item) {

                if (isset($item['sm_first_shipment'])) {
                    $f_qty = $item['sm_first_shipment'];
                } else {
                    $f_qty = 0;
                }

                if (isset($item['sm_second_shipment'])) {
                    $sec_qty = $item['sm_second_shipment'];
                } else {
                    $sec_qty = 0;
                }
                $_POST['bto_data'][$key]['quantity_min'] = (int) $f_qty + (int)$sec_qty;
                $_POST['bto_data'][$key]['quantity_max'] = (int)$f_qty + (int)$sec_qty;
            }
        }
    }
}

add_action('woocommerce_composite_component_admin_config_html', 'smile_brillaint_component_shipping', 50, 3);
/**
 * Callback function to render HTML configuration for composite components.
 * Hooked into the 'woocommerce_composite_component_admin_config_html' action.
 *
 * @param int $id Component ID.
 * @param array $data Component data.
 * @param int $product_id Product ID.
 */
function smile_brillaint_component_shipping($id, $data, $product_id)
{
    $sm_shipment = isset($data['component_id']) ? $data['component_id'] : 0;
    if ($sm_shipment) {
        $bto_data_sm_first_shipment = get_post_meta($sm_shipment, 'sm_first_shipment', true);
        $bto_data_sm_second_shipment = get_post_meta($sm_shipment, 'sm_second_shipment', true);
?>
        <div class="component_shipment">
            <div class="form-field">
                <label for="sm_first_shipment_<?php echo $sm_shipment; ?>">
                    First Shipment Qty
                </label>
                <input type="number" class="group__quantity_min" name="bto_data[<?php echo $id; ?>][sm_first_shipment]" id="sm_first_shipment_<?php echo $sm_shipment; ?>" value="<?php echo $bto_data_sm_first_shipment; ?>" placeholder="" step="1" min="0">
            </div>
        </div>
        <div class="component_shipment">
            <div class="form-field">
                <label for="sm_second_shipment_<?php echo $sm_shipment; ?>">
                    Second Shipment Qty
                </label>
                <input type="number" class="group_quantity_min" name="bto_data[<?php echo $id; ?>][sm_second_shipment]" id="sm_second_shipment_<?php echo $sm_shipment; ?>" value="<?php echo $bto_data_sm_second_shipment; ?>" placeholder="" step="1" min="0">
            </div>
        </div>
        <!--        <style>
            .options_group_component:nth-child(4){
                display:none;
            }
        </style>-->
    <?php
    } else {
    ?>
        <!--        <style>
            .bto_group_handle .options_group.options_group_component:nth-child(3){
                display:none;
            }
        </style>-->
        <div class="component_shipment">
            <div class="form-field">
                <label for="Shipment">
                    <?php echo __('Shipment Qty', 'woocommerce-composite-products'); ?>
                </label>
                <?php echo __('First Save Component Item', 'woocommerce-composite-products'); ?>

            </div>
        </div>
    <?php
    }
}

add_action('woocommerce_composite_process_component_data', 'woocommerce_composite_process_component_data_callback', 50, 3);
/**
 * Callback function to process composite component data.
 * Hooked into the 'woocommerce_composite_process_component_data' action.
 *
 * @param string $composite_group_data Composite group data.
 * @param array $post_data Post data.
 * @param int $component_id Component ID.
 *
 * @return string Composite group data.
 */
function woocommerce_composite_process_component_data_callback($composite_group_data = '', $post_data = '', $component_id = '')
{

    if ($component_id) {
        if (isset($post_data['sm_first_shipment'])) {
            $sm_first_shipment = $post_data['sm_first_shipment'];
            update_post_meta($component_id, 'sm_first_shipment', $sm_first_shipment);
        }
        if (isset($post_data['sm_second_shipment'])) {
            $sm_second_shipment = $post_data['sm_second_shipment'];
            update_post_meta($component_id, 'sm_second_shipment', $sm_second_shipment);
        }
    }
    return $composite_group_data;
}

// Add custom fields to product shipping tab
add_action('woocommerce_product_options_shipping', 'add_custom_shipping_option_to_products');
/**
 * Callback function to add custom shipping options to products.
 * Hooked into 'woocommerce_product_options_shipping'.
 */
function add_custom_shipping_option_to_products()
{
    global $post;
    $product = wc_get_product($post->ID);
    $three_way_ship_product = get_post_meta($post->ID, 'three_way_ship_product', true);

    if ($product->get_type() == 'composite') {
        echo '</div><div class="options_group">'; // New option group

        if ($three_way_ship_product) {
            woocommerce_wp_text_input(array(
                'id' => '_first_shipment_weight',
                'label' => __('First Composite Shipment Weight', 'woocommerce'),
                'placeholder' => '0.01',
                'desc_tip' => 'true',
                'description' => __('Enter the first shipment composite product weight here excluding packaging weight.', 'woocommerce'),
                'value' => get_post_meta($post->ID, '_first_shipment_weight', true),
            ));

            woocommerce_wp_text_input(array(
                'id' => '_second_shipment_weight',
                'label' => __('Second Composite Shipment Weight', 'woocommerce'),
                'placeholder' => '0.01',
                'desc_tip' => 'true',
                'description' => __('Enter the second shipment composite product weight here excluding packaging weight', 'woocommerce'),
                'value' => get_post_meta($post->ID, '_second_shipment_weight', true),
            ));
        } else {
            woocommerce_wp_text_input(array(
                'id' => '_first_shipment_weight',
                'label' => __('Composite Shipment Weight', 'woocommerce'),
                'placeholder' => '0.01',
                'desc_tip' => 'true',
                'description' => __('Enter the first shipment composite product weight here excluding packaging weight.', 'woocommerce'),
                'value' => get_post_meta($post->ID, '_first_shipment_weight', true),
            ));
        }
    }
}

// Save the custom fields values as meta data
//add_action('woocommerce_process_product_meta', 'save_custom_shipping_option_to_products');

function save_custom_shipping_option_to_products($post_id)
{

    $first_shipment_weight = $_POST['_first_shipment_weight'];
    if (isset($first_shipment_weight))
        update_post_meta($post_id, '_first_shipment_weight', esc_attr($first_shipment_weight));

    $second_shipment_weight = $_POST['_second_shipment_weight'];
    if (isset($second_shipment_weight))
        update_post_meta($post_id, '_second_shipment_weight', esc_attr($second_shipment_weight));
}

/**
 * Add custom general product options to the WooCommerce product editor.
 *
 * @action woocommerce_product_options_general_product_data
 */
add_action('woocommerce_product_options_general_product_data', 'sb_general_product_options');

/**
 * Display custom general product options in the WooCommerce product editor.
 */
function sb_general_product_options()
{
    $threewayProduct = get_post_meta(get_the_ID(), 'three_way_ship_product', true);
    $addonProduct = get_post_meta(get_the_ID(), 'addonChildProduct', true);
    $addonProductBoth = get_post_meta(get_the_ID(), 'addonProductBoth', true);
    $impression_tray = get_post_meta(get_the_ID(), 'impression_tray', true);
    $lead_time = get_post_meta(get_the_ID(), 'lead_time', true);

    $addon_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => 'addon',
            ),
        ),
    );
    $addonPrdoucts = get_posts($addon_args);

    //    echo '<div class="options_group">';
    //    woocommerce_wp_checkbox(array(
    //        'id' => 'three_way_ship_product',
    //        'value' => $threewayProduct,
    //        'label' => 'Three way Shipping',
    //        'desc_tip' => true,
    //        'description' => 'Enable product as three way shipment',
    //    ));
    //
    //    echo '</div>';
    if ($threewayProduct == 'yes') {
        $checked3Way = 'checked="checked"';
        $checked3WayLinkedFields = 'style="display:block"';
    } else {
        $checked3Way = '';
        $checked3WayLinkedFields = 'style="display:none"';
    }
    ?>
    <p class="form-field three_way_ship_product_field ">
        <label for="three_way_ship_product">Three way Shipping</label>
        <!--        <span class="woocommerce-help-tip"></span>-->
        <?php ?>
        <input type="checkbox" <?php echo $checked3Way; ?> name="three_way_ship_product" id="three_way_ship_product" value="yes">
    </p>
    <div class="options_group addonProduct_container" <?php echo $checked3WayLinkedFields; ?>>
        <?php
        echo '<p class=" form-field _impression_kit_field">';
        echo '<label for="impression_tray">Impression Tray</label>';
        echo '<select style="" id="impression_tray" name="impression_tray" class="select short">';

        echo '<option value="none">None</option>';
        if ($impression_tray == 1) {
            echo '<option value="1" selected="selected">Single</option>';
        } else {
            echo '<option value="1">Single</option>';
        }
        if ($impression_tray == 2) {
            echo '<option value="2" selected="selected">Double</option>';
        } else {
            echo '<option value="2">Double</option>';
        }


        echo '</select>';
        echo '</p>';
        ?>

    </div>


    <div class="options_group addonProduct_container" <?php echo $checked3WayLinkedFields; ?>>

        <p class=" form-field _impression_kit_field">
            <label for="addonProduct">Default Replacement Product</label>
            <select style="" id="addonProduct" name="addonProduct" class="select short">
                <option value="none">None</option>
                <?php
                if ($addonPrdoucts) {
                    foreach ($addonPrdoucts as $addon_prod) {
                        if ($addon_prod->ID == $addonProduct) {
                            echo '<option value="' . $addon_prod->ID . '" selected="selected">' . $addon_prod->ID . ' - ' . $addon_prod->post_title . '</option>';
                        } else {
                            echo '<option value="' . $addon_prod->ID . '">' . $addon_prod->ID . ' - ' . $addon_prod->post_title . '</option>';
                        }
                    }
                }
                ?>
            </select>
        </p>
        <?php /*
          $impression2KitVisibility = 'display:none';
          if ($impression_tray == 2) {
          $impression2KitVisibility = 'display:block';
          }

          ?>
          <p class=" form-field _impression_kit_field" id="impression2Kit" style="<?php echo $impression2KitVisibility; ?>">

          <label for="addonProductBoth"><abbr title="If Upper and lower dental impression both are rejected.">Addon Product for both</abbr></label>
          <select style="" id="addonProductBoth" name="addonProductBoth" class="select short">
          <option value="none">None</option>
          <?php

          if ($addonPrdoucts) {
          foreach ($addonPrdoucts as $addon_prod) {
          if ($addon_prod->ID == $addonProductBoth) {
          echo '<option value="' . $addon_prod->ID . '" selected="selected">' . $addon_prod->ID . ' - ' . $addon_prod->post_title . '</option>';
          } else {
          echo '<option value="' . $addon_prod->ID . '">' . $addon_prod->ID . ' - ' . $addon_prod->post_title . '</option>';
          }
          }
          }
          ?>
          </select>
          </p>

          <?php */ ?>
    </div>
    <p class="form-field lead_time ">
        <label for="lead_time">Lead time</label>
        <input type="number" name="lead_time" id="lead_time" value="<?php echo $lead_time; ?>">
    </p>

    <script>
        const three_way_ship_product = document.getElementById('three_way_ship_product')

        three_way_ship_product.addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                jQuery('body').find('.addonProduct_container').show();
            } else {
                jQuery('body').find('.addonProduct_container').hide();
            }
        });



        const impression_tray = document.getElementById('impression_tray')

        impression_tray.addEventListener('change', (event) => {
            if (event.currentTarget.value == 2) {
                jQuery('body').find('#impression2Kit').show();
            } else {
                jQuery('body').find('#impression2Kit').hide();
            }
        });
    </script>
<?php
    echo '<div class="options_group">';

    woocommerce_wp_checkbox(array(
        'id' => 'geha_product',
        'value' => get_post_meta(get_the_ID(), 'geha_product', true),
        'label' => 'Geha Product',
        'desc_tip' => true,
        'description' => 'Enable product to as Geha Product',
    ));

    echo '</div>';
}

add_action('woocommerce_process_product_meta', 'sb_product_save_fields', 10, 2);
/**
 * Save custom fields when a product is updated.
 *
 * @param int $id The ID of the product being saved.
 * @param WP_Post $post The post object.
 *
 * @action woocommerce_process_product_meta
 */
function sb_product_save_fields($id, $post)
{

    if (!empty($_REQUEST['geha_product'])) {
        update_post_meta($id, 'geha_product', $_REQUEST['geha_product']);
    } else {
        delete_post_meta($id, 'geha_product');
    }
    if (!empty($_REQUEST['lead_time'])) {
        update_post_meta($id, 'lead_time', $_REQUEST['lead_time']);
    }
    if (!empty($_REQUEST['three_way_ship_product'])) {
        update_post_meta($id, 'three_way_ship_product', $_REQUEST['three_way_ship_product']);
    } else {
        delete_post_meta($id, 'three_way_ship_product');
    }
    if (!empty($_REQUEST['impression_tray'])) {
        update_post_meta($id, 'impression_tray', $_REQUEST['impression_tray']);
    } else {
        delete_post_meta($id, 'impression_tray');
    }
    if (!empty($_REQUEST['addonProduct'])) {
        update_post_meta($id, 'addonChildProduct', $_REQUEST['addonProduct']);
    } else {
        delete_post_meta($id, 'addonChildProduct');
    }
    if (!empty($_REQUEST['addonProductBoth'])) {
        update_post_meta($id, 'addonProductBoth', $_REQUEST['addonProductBoth']);
    } else {
        delete_post_meta($id, 'addonProductBoth');
    }
}
