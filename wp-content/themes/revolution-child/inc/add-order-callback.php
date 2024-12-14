<?php
/**
 * Filter for backend orders to skip update status in fraud check.
 *
 * @param string $new_status The new order status.
 * @param int $order_id The order ID.
 * @param object $order The order object.
 * @return string|bool The new order status or false if created by CSR.
 */
function wc_anti_fraud_new_order_status_for_backend_orders($new_status, $order_id, $order)
{

    if (get_post_meta($order_id, '_createdByCSR', true) == 'yes') {
        return false;
    } else {
        return $new_status;
    }
}

add_filter('wc_anti_fraud_new_order_status', 'wc_anti_fraud_new_order_status_for_backend_orders', 10, 3);
/**
 * AJAX callback function to search for states by country code.
 */
function searchStateByCountryCode_callback()
{

    if (isset($_REQUEST['countryCode']) && $_REQUEST['countryCode'] <> '') {
        echo get_stateByCountry_SBR($_REQUEST['name'], $_REQUEST['countryCode']);
    }
    die;
}

add_action('wp_ajax_apply_giftCode_sbr', 'apply_giftCode_sbr_callback');
/**
 * AJAX callback function to apply a gift code.
 */
function apply_giftCode_sbr_callback()
{
    global $wpdb;
    $gift_code = $wpdb->escape($_REQUEST['gift_code']);
    //    echo '<pre>';
    //    print_r($_REQUEST);
    //    echo '</pre>';
    $errors = '';
    if (empty($gift_code)) {
        $errors = "Please enter a gift code";
    }
    $discountAmount = 0;
    if ($errors == '') {

        $products = $_REQUEST['product_id'];
        $items_qty = $_REQUEST['item_qty'];
        WC()->cart->empty_cart();
        if (is_array($products) && count($products) > 0) {
            //   $cart_obj = new WC_Cart();
            $_POST['action'] = 'woocommerce_add_order_item';
            foreach ($products as $key => $p) {

                $product_id = absint($p);
                if ($product_id == 0) {
                    continue;
                }
                $qty = 1;
                if ($items_qty[$key]) {
                    $qty = $items_qty[$key];
                }

                WC()->cart->add_to_cart($product_id, $qty);
            }
            $coupon = new \WC_Coupon($gift_code);
            $discounts = new \WC_Discounts(WC()->cart);
            $valid_response = $discounts->is_coupon_valid($coupon);
            if (is_wp_error($valid_response)) {
                $errors = $valid_response->get_error_message();
            } else {
                $response = WC()->cart->add_discount($gift_code);
                $discountAmount = WC()->cart->get_discount_total();
                echo '{"status":"1","amount":"' . $discountAmount . '"}';
                die();
            }
        } else {
            $errors = "Please select some products";
        }
    }
    echo '{"status":"0","error":"' . str_replace('"', '\"', $errors) . '"}';
    die();
}
/**
 * Function to get states by country for SBR.
 *
 * @param string $name The name of the field.
 * @param string $default_country The default country code.
 * @param string $default_state The default state value.
 */
function get_stateByCountry_SBR($name = 'billing_state', $default_country, $default_state = '')
{

    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_county_states = $countries_obj->get_states($default_country);
    if ($default_county_states) {
        woocommerce_form_field(
            $name,
            array(
                'type' => 'select',
                'required' => true,
                'class' => array('chzn-drop'),
                'label' => __('Select a state'),
                'placeholder' => __('Enter state'),
                'options' => $default_county_states
            ),
            $default_state
        );
    } else {
?>
        <label>State</label>
        <input type="text" name="<?php echo $name; ?>" class="form-control" value="<?php echo $default_state; ?>" />

<?php
    }
}
/**
 * Function to disable customer processing order email.
 *
 * @param bool $enabled Whether email is enabled.
 * @param object $object The object.
 * @return bool Always returns false.
 */
function sbr_disable_email_customer_processing_order($enabled, $object)
{
    return false;
}

add_action('woocommerce_new_order', 'create_invoice_for_wc_order', 1, 1);
/**
 * Function to create an invoice for a WooCommerce order.
 *
 * @param int $order_id The order ID.
 */
function create_invoice_for_wc_order($order_id)
{
    $customer_user_mbt = get_post_meta($order_id, '_customer_user', true);
    if (isset($_REQUEST['shipping_address_id']) && $_REQUEST['shipping_address_id'] != 'emp') {
        set_as_default_shipping_address_mbt($_REQUEST['shipping_address_id'], $customer_user_mbt);
    } else {
        creat_initila_address_from_default($customer_user_mbt);
    }
}

add_action('wp_ajax_createOrderByCSR', 'createOrderByCSR_callback');
/**
 * Function for Create order from backend. CSR can create order against any user with custom prices ,charge  CMI profiles , Create Profiles , Register User
 * 
*/
function createOrderByCSR_callback()
{


    $response = array();

    $child_order_id = false;
    $customer_user_mbt = isset($_REQUEST['customer_user_mbt']) ? $_REQUEST['customer_user_mbt'] : 0;
    $customer_send_email = isset($_REQUEST['customer_send_email']) ? $_REQUEST['customer_send_email'] : false;
    $customer_send_email_invoice = isset($_REQUEST['customer_send_email_invoice']) ? $_REQUEST['customer_send_email_invoice'] : false;
    if ($customer_user_mbt) {
        if (isset($_REQUEST['product_id'])) {
            if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {
                $token_id = isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) ? $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] : 0;
                if ($token_id) {
                    $billTo = isset($_REQUEST['ppAddress'][$token_id]) ? json_decode(stripslashes($_REQUEST['ppAddress'][$token_id]), true) : Null;
                    if (isset($billTo['firstName'])) {
                        $_REQUEST['billing_first_name'] = $billTo['firstName'];
                    }
                    if (isset($billTo['lastName'])) {
                        $_REQUEST['billing_last_name'] = $billTo['lastName'];
                    }
                    if (isset($billTo['address'])) {
                        $_REQUEST['billing_address_1'] = $billTo['address'];
                    }
                    if (isset($billTo['city'])) {
                        $_REQUEST['billing_city'] = $billTo['city'];
                    }
                    if (isset($billTo['state'])) {
                        $_REQUEST['billing_state'] = $billTo['state'];
                    }
                    if (isset($billTo['zip'])) {
                        $_REQUEST['billing_postcode'] = $billTo['zip'];
                    }
                    if (isset($billTo['country'])) {
                        $_REQUEST['billing_country'] = $billTo['country'];
                    }
                    if (isset($billTo['phoneNumber'])) {
                        $_REQUEST['billing_phone'] = $billTo['phoneNumber'];
                    }
                    $_REQUEST['is_billing_address_changed'] = 'new';
                } else {
                    $response = array(
                        'msg' => 'Payment profile missing.',
                        'error' => true
                    );
                    echo json_encode($response);
                    die;
                }
            }
            global $wpdb;
            $product_logs = array();
            $is_billing_address_changed = isset($_REQUEST['is_billing_address_changed']) ? $_REQUEST['is_billing_address_changed'] : 'old';
            if ($is_billing_address_changed == 'new') {

                $billing_firstname = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : get_user_meta($customer_user_mbt, 'billing_first_name', true);
                $billing_lastname = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : get_user_meta($customer_user_mbt, 'billing_last_name', true);
                $billing_phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : get_user_meta($customer_user_mbt, 'billing_phone', true);
                $billing_address_1 = isset($_REQUEST['billing_address_1']) ? $_REQUEST['billing_address_1'] : get_user_meta($customer_user_mbt, 'billing_address_1', true);
                $billing_city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : get_user_meta($customer_user_mbt, 'billing_city', true);
                $billing_state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : get_user_meta($customer_user_mbt, 'billing_state', true);
                $billing_postcode = isset($_REQUEST['billing_postcode']) ? $_REQUEST['billing_postcode'] : get_user_meta($customer_user_mbt, 'billing_postcode', true);
                $billing_country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : get_user_meta($customer_user_mbt, 'billing_country', true);

                update_user_meta($customer_user_mbt, 'billing_first_name', $billing_firstname);
                update_user_meta($customer_user_mbt, 'billing_last_name', $billing_lastname);
                update_user_meta($customer_user_mbt, 'billing_phone', $billing_phone);
                update_user_meta($customer_user_mbt, 'billing_address_1', $billing_address_1);
                update_user_meta($customer_user_mbt, 'billing_city', $billing_city);
                update_user_meta($customer_user_mbt, 'billing_state', $billing_state);
                update_user_meta($customer_user_mbt, 'billing_postcode', $billing_postcode);
                update_user_meta($customer_user_mbt, 'billing_country', $billing_country);
            } else {
                $billing_firstname = get_user_meta($customer_user_mbt, 'billing_first_name', true);
                $billing_lastname = get_user_meta($customer_user_mbt, 'billing_last_name', true);
                $billing_phone = get_user_meta($customer_user_mbt, 'billing_phone', true);
                $billing_address_1 = get_user_meta($customer_user_mbt, 'billing_address_1', true);
                $billing_city = get_user_meta($customer_user_mbt, 'billing_city', true);
                $billing_state = get_user_meta($customer_user_mbt, 'billing_state', true);
                $billing_postcode = get_user_meta($customer_user_mbt, 'billing_postcode', true);
                $billing_country = get_user_meta($customer_user_mbt, 'billing_country', true);
            }


            $is_shipping_address_changed = isset($_REQUEST['is_shipping_address_changed']) ? $_REQUEST['is_shipping_address_changed'] : 'old';
            if ($is_shipping_address_changed == 'new') {

                $shipping_firstname = isset($_REQUEST['shipping_first_name']) ? $_REQUEST['shipping_first_name'] : get_user_meta($customer_user_mbt, 'shipping_first_name', true);
                $shipping_lastname = isset($_REQUEST['shipping_last_name']) ? $_REQUEST['shipping_last_name'] : get_user_meta($customer_user_mbt, 'shipping_last_name', true);
                $shipping_address_1 = isset($_REQUEST['shipping_address_1']) ? $_REQUEST['shipping_address_1'] : get_user_meta($customer_user_mbt, 'shipping_address_1', true);
                $shipping_city = isset($_REQUEST['shipping_city']) ? $_REQUEST['shipping_city'] : get_user_meta($customer_user_mbt, 'shipping_city', true);
                $shipping_state = isset($_REQUEST['shipping_state']) ? $_REQUEST['shipping_state'] : get_user_meta($customer_user_mbt, 'shipping_state', true);
                $shipping_postcode = isset($_REQUEST['shipping_postcode']) ? $_REQUEST['shipping_postcode'] : get_user_meta($customer_user_mbt, 'shipping_postcode', true);
                $shipping_country = isset($_REQUEST['shipping_country']) ? $_REQUEST['shipping_country'] : get_user_meta($customer_user_mbt, 'shipping_country', true);

                update_user_meta($customer_user_mbt, 'shipping_first_name', $shipping_firstname);
                update_user_meta($customer_user_mbt, 'shipping_last_name', $shipping_lastname);
                // update_user_meta($user_id, 'billing_phone', $billing_phone);
                update_user_meta($customer_user_mbt, 'shipping_address_1', $shipping_address_1);
                update_user_meta($customer_user_mbt, 'shipping_city', $shipping_city);
                update_user_meta($customer_user_mbt, 'shipping_state', $shipping_state);
                update_user_meta($customer_user_mbt, 'shipping_postcode', $shipping_postcode);
                update_user_meta($customer_user_mbt, 'shipping_country', $shipping_country);
            } else {
                $shipping_firstname = get_user_meta($customer_user_mbt, 'shipping_first_name', true);
                $shipping_lastname = get_user_meta($customer_user_mbt, 'shipping_last_name', true);
                $shipping_address_1 = get_user_meta($customer_user_mbt, 'shipping_address_1', true);
                $shipping_address_2 = get_user_meta($customer_user_mbt, 'shipping_address_2', true);
                $shipping_city = get_user_meta($customer_user_mbt, 'shipping_city', true);
                $shipping_state = get_user_meta($customer_user_mbt, 'shipping_state', true);
                $shipping_postcode = get_user_meta($customer_user_mbt, 'shipping_postcode', true);
                $shipping_county = get_user_meta($customer_user_mbt, 'shipping_country', true);
                $_REQUEST['shipping_address_id'] = $_REQUEST['is_shipping_address_changed'];
                if (isset($_REQUEST['is_shipping_address_changed']) && is_numeric($_REQUEST['is_shipping_address_changed'])) {
                    $shippingAddress = current_user_shipping_addresses($customer_user_mbt);
                    if (count($shippingAddress) > 0) {
                        foreach ($shippingAddress as $shipAdd) {
                            if ($_REQUEST['is_shipping_address_changed'] == $shipAdd['id']) {
                                $shipping_firstname = $shipAdd['shipping_first_name'];
                                $shipping_lastname = $shipAdd['shipping_last_name'];
                                $shipping_address_1 = $shipAdd['shipping_address_1'];
                                $shipping_address_2 = $shipAdd['shipping_address_2'];
                                $shipping_city = $shipAdd['shipping_city'];
                                $shipping_state = $shipAdd['shipping_state'];
                                $shipping_postcode = $shipAdd['shipping_postcode'];
                                $shipping_county = $shipAdd['shipping_country'];
                                /// set_as_default_shipping_address_mbt($_REQUEST['is_shipping_address_changed']);
                                break;
                            }
                        }
                    }
                }
            }

            $userData = get_userdata($customer_user_mbt);
            $billing_address = array(
                'first_name' => $billing_firstname,
                'last_name' => $billing_lastname,
                'email' => $userData->user_email,
                'phone' => $billing_phone,
                'address_1' => $billing_address_1,
                'city' => $billing_city,
                'postcode' => $billing_postcode,
                'state' => $billing_state,
                'country' => $billing_country
            );

            $shipping_address = array(
                'first_name' => $shipping_firstname,
                'last_name' => $shipping_lastname,
                'address_1' => $shipping_address_1 . ' ' . $shipping_address_2,
                'city' => $shipping_city,
                'postcode' => $shipping_postcode,
                'state' => $shipping_state,
                'country' => $shipping_county
            );

            //echo 'Data: <pre>' .print_r(get_user_meta($customer_user_mbt)). '</pre>';
            //             echo 'Data: <pre>' .print_r($billing_address,true). '</pre>';
            //echo 'Data: <pre>' .print_r($billing_address,true). '</pre>';
            //die;
            $args = array(
                'customer_id' => $customer_user_mbt,
            );
            $productWithPrice = array();
            $newOrder = true;
            if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] > 0) {
                $newOrder = false;
            }
            // Create the order and assign it to the current user
            if ($newOrder) {
                $order = wc_create_order($args);
                $order = wc_get_order($order->get_id());
                $order->set_address($billing_address, 'billing');
                $order->set_address($shipping_address, 'shipping');
                $child_order_id = $order->get_id();
                smile_brillaint_set_sequential_order_number($child_order_id);
                smile_brillaint_get_sequential_order_number($child_order_id);
                $products = $_REQUEST['product_id'];
                $items_qty = $_REQUEST['item_qty'];
                $discountPerProduct = $_REQUEST['discount'];
                $subTotalProduct = $_REQUEST['sub_total'];
                $productPrice = $_REQUEST['price'];
                update_post_meta($child_order_id, '_createdByCSR', 'yes');
                update_post_meta($child_order_id, '_csr_id', get_current_user_id());
                $discountAmount = 0;
                if ($products) {
                    foreach ($products as $key => $p) {

                        $product_id = absint($p);
                        $product = wc_get_product($product_id);
                        $qty = 1;
                        if ($items_qty[$key]) {
                            $qty = $items_qty[$key];
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
                        $dis_percentge = 0;
                        if (isset($discountPerProduct[$key]) && $discountPerProduct[$key] > 0) {
                            $regular_price = (float) $product->get_regular_price(); // Regular price
                            if ($productPrice[$key] != $regular_price) {
                                $regular_price = (float) $productPrice[$key];
                            }
                            $dis_percentge = $discountPerProduct[$key];
                            $discount = $dis_percentge * $regular_price / 100;
                            $discountQty = $discount * $qty;
                            //$new_product_price = $regular_price - $discount;
                            //  $product->set_price($new_product_price);
                            $discountAmount = $discountAmount + $discountQty;
                            //$discountAmount = $discountAmount + $new_product_price;
                        }
                        if (isset($productPrice[$key])) {
                            $customData = array(
                                'subtotal' => $productPrice[$key],
                                'total' => $productPrice[$key] * $qty,
                            );
                            $item_id = $order->add_product($product, $qty, $customData);
                        } else {
                            $item_id = $order->add_product($product, $qty);
                        }
                        $tray_number = $_REQUEST['tray_number'][$key];
                        $productWithPrice[$key] = array(
                            'price' => $productPrice[$key],
                            'product_id' => $product_id,
                            'tray_number' => $tray_number,
                            'qty' => $qty,
                        );
                        $item = apply_filters('woocommerce_ajax_order_item', $order->get_item((int) $item_id), (int) $item_id, $order, $product);
                        $added_items[$item_id] = $item;
                        $order_notes[$item_id] = $product->get_formatted_name();
                        $item->save();
                        do_action('woocommerce_ajax_add_order_item_meta', (int) $item_id, $item, $order);
                    }
                    if (isset($_REQUEST['couponCode']) && $_REQUEST['couponCode'] <> '') {
                        $order->apply_coupon($_REQUEST['couponCode']);
                    }
                    $order->add_order_note(sprintf(__('Added line items: %s', 'woocommerce'), implode(', ', $order_notes)), false, true);
                    do_action('woocommerce_ajax_order_items_added', $added_items, $order);
                }
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
                }
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
                $order->calculate_totals();
                $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
                $order->set_total($addOn_amount);

                if (isset($_REQUEST['gift_order']) && trim($_REQUEST['gift_order'])) {
                    update_post_meta($order->get_id(), 'purchasing_as_giftset', '1');
                }
                if (isset($_REQUEST['order_customer_note']) && trim($_REQUEST['order_customer_note'])) {
                    $order->add_order_note($_REQUEST['order_customer_note'], true);
                }
                if (isset($_REQUEST['order_admin_note']) && trim($_REQUEST['order_admin_note'])) {
                    $order->add_order_note($_REQUEST['order_admin_note']);
                }
            } else {
                $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
                $child_order_id = $_REQUEST['order_id'];
                $order = wc_get_order($child_order_id);
            }

            if (isset($_REQUEST['parent_order_id'])) {
                update_post_meta($child_order_id, 'parent_order_id', $_REQUEST['parent_order_id']);
            }
            $addonResponse = '';
            if (isset($_REQUEST['order_type'])) {

                if ($_REQUEST['order_type'] == 'Addon') {
                    if (get_post_meta($child_order_id, 'order_number', true) == '') {
                        smile_brillaint_get_sequential_order_number($child_order_id);
                    }
                    $order->set_created_via('Addon');
                    $current_user = wp_get_current_user();
                    $editUrl = get_admin_url() . 'post.php?post=' . $child_order_id . '&action=edit';
                    $childOrderNote = 'Addon Order Created. <strong><a target="_blank" href="' . $editUrl . '">' . get_post_meta($child_order_id, 'order_number', true) . '</a></strong>';
                    $childOrderNote .= '<br/> Created By . <strong>' . $current_user->user_login . '</strong>';
                    $childOrderNote .= '<br/> Created On . <strong>' . date("Y-m-d H:i:s") . '</strong>';
                    create_woo_order_note($childOrderNote, $_REQUEST['parent_order_id'], true);

                    $addonResponse = 'Addon Order Created. Click to View Order <strong><a target="_blank" href="' . $editUrl . '">' . get_post_meta($child_order_id, 'order_number', true) . '</a></strong>';
                }

                update_post_meta($child_order_id, 'order_type', $_REQUEST['order_type']);
            } else {
                $order->set_created_via('addOrder');
            }
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
            $proshieldCounter = 0;
            foreach ($orderObj->get_items() as $item_id => $item) {

                $log_visible = false;
                // if (wc_cp_get_composited_order_item_container($item, $order)) {
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                    /* Composite Prdoucts Child Items */
                    $_composite_parent =  wc_get_order_item_meta($item_id, '_composite_parent',  true);
                    if (isset($parentQtyObj[$_composite_parent])) {
                        $childQty = $item->get_quantity();
                        wc_delete_order_item_meta($item_id, '_reduced_stock');
                        wc_update_product_stock($item->get_product_id(), $childQty, 'increase', false);
                        $_composite_item_id =  wc_get_order_item_meta($item_id, '_composite_item',  true);
                        $_composite_data =  wc_get_order_item_meta($item_id, '_composite_data',  true);
                        foreach ($_composite_data as $_composite_data_key => $_composite_data_info) {
                            if ($_composite_item_id == $_composite_data_key) {
                                $newQty = $parentQtyObj[$_composite_parent] * $_composite_data_info['quantity_min'];
                                if ($childQty != $newQty) {
                                    wc_update_order_item_meta($item_id, '_qty',  $newQty);
                                }
                            }
                        }
                    }
                } else if (wc_cp_is_composite_container_order_item($item)) {

                    /* Composite Prdoucts Parent Item */
                    $log_visible = true;
                } else {
                    $log_visible = true;
                }
                if ($log_visible) {
                    $product_id = $item->get_product_id();

                    if (isset($productWithPrice[$keyUpdate]['product_id']) && $productWithPrice[$keyUpdate]['product_id'] == $product_id) {
                        $_line_total = $productWithPrice[$keyUpdate]['price'] * $productWithPrice[$keyUpdate]['qty'];
                        $_line_subtotal = $productWithPrice[$keyUpdate]['price'];
                        $tray_number = $productWithPrice[$keyUpdate]['tray_number'];
                        if ($tray_number) {
                            wc_add_order_item_meta($item_id, '_tray_number',  $tray_number);
                        }
                        wc_update_order_item_meta($item_id, '_line_subtotal',  $_line_subtotal);
                        wc_update_order_item_meta($item_id, '_line_total',  $_line_total);



                        $categories = wp_get_post_terms($product_id, 'product_cat');
                        $has_proshield_category = false;

                        foreach ($categories as $category) {
                            if ($category->slug === 'proshield') {
                                $has_proshield_category = true;
                                break;
                            }
                        }

                        if ($has_proshield_category) {
                            wc_update_order_item_meta($item_id, 'mouth_guard_color',  $_REQUEST['proshieldColor'][$proshieldCounter]);
                            wc_update_order_item_meta($item_id, 'mouth_guard_number',  $_REQUEST['proshieldCustomID'][$proshieldCounter]);
                            $proshieldCounter++;
                        }


                        $wpdb->update('wp_woocommerce_order_itemmeta', array(
                            'meta_value' => $_line_subtotal,
                        ), array('meta_key' => '_line_subtotal', 'order_item_id' => $item_id));

                        $wpdb->update('wp_woocommerce_order_itemmeta', array(
                            'meta_value' => $_line_total,
                        ), array('meta_key' => '_line_total', 'order_item_id' => $item_id));
                    }
                    $keyUpdate++;
                }
            }
            $orderObj->save();
            if (function_exists('w3tc_pgcache_flush_post')) {
                w3tc_pgcache_flush_post($child_order_id);
            }
            //Don't send order processing email
            if (!$customer_send_email)
                add_filter('woocommerce_email_enabled_customer_processing_order', 'sbr_disable_email_customer_processing_order', 10, 2);
            //Don't send order invoice email
            if (!$customer_send_email_invoice)
                add_filter('woocommerce_email_enabled_pip_email_invoice', 'sbr_disable_email_customer_processing_order', 10, 2);
            if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {
                if (is_numeric($addOn_amount) && $addOn_amount > 0) {
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
                }
                if (!$paymentFlagError) {
                    mbt_goodToShip($child_order_id);
                }
                //subscription#RB
                if (isset($_REQUEST['subscription_arbids']) && !empty($_REQUEST['subscription_arbids']) && !$paymentFlagError) {
                    addSubscriptionPlan($child_order_id);
                }
            } else if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cheque') {

                update_post_meta($child_order_id, '_payment_method', 'cheque');
                update_post_meta($child_order_id, '_payment_method_title', 'Check payments');
                //if ($order->get_total() > 0) {
                //  $order->add_order_note('we\'re awaiting the cheque');
                // Mark as on-hold (we're awaiting the cheque).
                $order->update_status('on-hold', _x('Awaiting check payment', 'Check payment method', 'woocommerce'));
                //$order->update_status(apply_filters('woocommerce_cheque_process_payment_order_status', 'on-hold', $order), _x('Awaiting check payment', 'Check payment method', 'woocommerce'));
                // }
            } else {
                do_action('woocommerce_before_resend_order_emails', $order, 'customer_invoice');
                // Send the customer invoice email.
                WC()->payment_gateways();
                WC()->shipping();
                WC()->mailer()->customer_invoice($order);
                // Note the event.
                $order->add_order_note(__('Order details manually sent to customer.', 'woocommerce'), false, true);
                do_action('woocommerce_after_resend_order_email', $order, 'customer_invoice');
            }
            if (!$customer_send_email)
                remove_filter('woocommerce_email_enabled_customer_processing_order', 'sbr_disable_email_customer_processing_order', 10);
            if (!$customer_send_email_invoice)
                remove_filter('woocommerce_email_enabled_pip_email_invoice', 'sbr_disable_email_customer_processing_order', 10);
            smile_brillaint_GEHA_tag($child_order_id);
            //echo 'Data: <pre>' .print_r($_REQUEST,true). '</pre>';
            if (isset($_REQUEST['sbr_order_type']) && $_REQUEST['sbr_order_type'] != '') {
                update_post_meta($child_order_id, 'sbr_order_type', $_REQUEST['sbr_order_type']);
            }
            if (isset($_REQUEST['sbr_order_labels'])) {
                //    if (isset($_REQUEST['sbr_order_labels']) && is_array($_REQUEST['sbr_order_labels']) && count($_REQUEST['sbr_order_labels']) > 0) {
                update_post_meta($child_order_id, 'sbr_order_labels', $_REQUEST['sbr_order_labels']);
                $orderTags = explode(",", $_REQUEST['sbr_order_labels']);

                foreach ($orderTags as $key => $orderTag) {
                    wp_set_object_terms($child_order_id, $orderTag, 'order_tag', true);
                }
            }


            $response = array(
                'msg' => 'Order created successfully ' . $payemt_note,
                'order_id' => $child_order_id,
                'addon' => $addonResponse,
                'error' => $paymentFlagError
            );
            echo json_encode($response);
            die;
        } else {
            $response = array(
                'msg' => 'No product found!',
                'error' => true,
                'order_id' => $child_order_id,
            );
        }
        echo json_encode($response);
        die;
    } else {
        $response = array(
            'msg' => 'No customer selected against this order.',
            'error' => true,
            'order_id' => $child_order_id,
        );
        echo json_encode($response);
        die;
    }

    die;
}

//subscription#RB[search-addSubscriptionPlan]
function addSubscriptionPlan_back($order_id)
{
    global $wpdb;
    $order = wc_get_order($order_id);
    $data = array();
    $wc_authorize_net_cim_credit_card_customer_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_customer_id', true);
    $wc_authorize_net_cim_credit_card_payment_token = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_payment_token', true);
    
    if ($wc_authorize_net_cim_credit_card_customer_id) {
        foreach ($order->get_items() as $item_id => $item) {
           
            $product_id = $item->get_product_id();
            $key = array_search($product_id, $_REQUEST['subscription_products']);
            $search_prod = $_REQUEST['subscription_products'][$key];
            $arbid = $_REQUEST['subscription_arbids'][$key];

            /*if ($key === false && empty($search_prod)){
                continue;
            }else*/
            if($arbid > -1 && $search_prod == $product_id)
            {           
                $product = wc_get_product($product_id);

                //** Subscription Plan on Authorize.net
                $rows = get_field('define_subscription_plans', $product_id);
                $interval = 0;
                foreach ($rows as $index => $data) {
                    if ($index == $arbid) {
                        $price = $data['price'];
                        $interval = ($data['billingshipping_frequency'] < 7 ? 8 : $data['billingshipping_frequency']);
                    }
                }
                $title = substr($product->get_title() . " Every " . $interval . " days", 0, 50);

                $dataObject = array(
                    "ARBCreateSubscriptionRequest" => array(
                        "merchantAuthentication" => array(
                            "name" => SB_AUTHORIZE_LOGIN_ID,
                            "transactionKey" => SB_AUTHORIZE_TRANSACTION_KEY
                        ),
                        "refId" => $item_id,
                        "subscription" => array(
                            "name" => $title,
                            "paymentSchedule" => array(
                                "interval" => array(
                                    "length" => $interval,
                                    "unit" => "days"
                                ),
                                "startDate" => date('Y-m-d'),
                                "totalOccurrences" => 999,
                                "trialOccurrences" => "1"
                            ),
                            "amount" => $price,
                            "trialAmount" => "0.00",
                            "order" => array(
                                "invoiceNumber" => "SUBC-" . $item_id,
                                "description" => $title
                            ),
                            "profile" => array(
                                "customerProfileId" => $wc_authorize_net_cim_credit_card_customer_id,
                                "customerPaymentProfileId" => $wc_authorize_net_cim_credit_card_payment_token
                            )
                        )
                    )
                );

                $response = authorizeCurlRequest(json_encode($dataObject));
                $order->add_order_note(json_encode($dataObject));
                $responseAPI = json_decode($response, true);
                $order->add_order_note($response);

                wc_add_order_item_meta($item_id, '_authorizeResponse', $response);
                wc_add_order_item_meta($item_id, '_subscriptionId', $responseAPI['subscriptionId']);

                //store subscription details
                $user_id = get_post_meta($order_id, '_customer_user', true);
                $transaction_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_trans_id', true);    
                
                if(empty($transaction_id))
                    $transaction_id = get_post_meta($order_id, '_transaction_id', true);    
                
                update_user_meta($user_id, 'is_subscribed', 1);
                $order->update_meta_data('_subscriptionId', $responseAPI['subscriptionId']);
                $qData = array(
                    'user_id' => $user_id,
                    'subscription_id' => ((int) $responseAPI['subscriptionId']),
                    'transaction_id' => $transaction_id,
                    'order_id' => $order_id,
                    'item_id' => $item_id,
                    'product_id' => $product_id,
                    'total_price' => $price,
                    'status' => 1,
                    'quantity' => $item->get_quantity(),
                    'subscription_date' => date('Y-m-d H:i:s'),
                    'interval_days' => $interval,
                    'next_order_date' => date('Y-m-d', strtotime(date('Y-m-d') . " + {$interval} days")),
                    'authorize_response' => $responseAPI
                );
                $order->add_order_note("Subscription Details Logs:" . json_encode($qData));
                $order->save();

                $wpdb->insert('sbr_subscription_details', $qData);
            }
        }
    }
}