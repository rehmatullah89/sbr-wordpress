<?php

/**
 * Adds action hook to enqueue a default script in the head section of WordPress.
 */
add_action('wp_head', 'impact_enqueue_default_script_sbr');

/**
 * Callback function to enqueue a default script in the head section of WordPress.
 */
function impact_enqueue_default_script_sbr()
{
?>
    <script>
        !(function() {
            !(function() {
                const e = (function(e, n) {
                    n || (n = window.location.href), (e = e.replace(/[\[\]]/g, "\\$&"));
                    var c = new RegExp("[?&]" + e + "(=([^&#]*)|&|#|$)").exec(n);
                    return c ? (c[2] ? decodeURIComponent(c[2].replace(/\+/g, " ")) : "") : null;
                })("irclickid");
                e &&
                    (function(e, n, c) {
                        const i = new Date();
                        i.setTime(i.getTime() + 24 * c * 60 * 60 * 1e3);
                        const o = "expires=" + i.toUTCString();
                        document.cookie = e + "=" + n + ";SameSite=None;" + o + ";path=/;secure";
                    })("irclickid", e, 30);
            })();
        })();
    </script>
    <?php
}


/**
 * Adds action hook to handle actions before creating a WooCommerce order during checkout.
 *
 * @param WC_Order $order The WooCommerce order object.
 * @param array $data Additional data.
 */
add_action('woocommerce_checkout_create_order', 'before_checkout_create_order_impact', 20, 2);

/**
 * Callback function to handle actions before creating a WooCommerce order during checkout.
 *
 * @param WC_Order $order The WooCommerce order object.
 * @param array $data Additional data.
 */

function before_checkout_create_order_impact($order, $data)
{
    $cookies = array('irclickid');
    foreach ($cookies as $cookie) {
        $order->update_meta_data($cookie, impact_sanitize_cookie($cookie));
    }
}


/**
 * Sanitizes the value of a specific cookie.
 *
 * @param string $cookie_name The name of the cookie.
 *
 * @return string|null The sanitized cookie value.
 */
function impact_sanitize_cookie($cookie_name)
{
    $value = null;
    if (isset($_COOKIE[$cookie_name])) {
        $value = sanitize_text_field(wp_unslash($_COOKIE[$cookie_name]));
    }
    return $value;
}



/**
 * Adds action hook to include tracking scripts in the footer of WordPress.
 */
add_action('wp_footer', 'sbr_upsell_trackingScripts');

/**
 * Callback function to include tracking scripts in the footer of WordPress.
 */
function sbr_upsell_trackingScripts()
{
    if (function_exists('gtm4wp_woocommerce_thankyou')) {
        $order = WFOCU_Core()->data->get_current_order();
        if ($order instanceof WC_Order) {
            $order_id = $order->get_id();
            if ((int) $order->get_meta('_ga_tracked', true) != 1) {
                gtm4wp_woocommerce_thankyou($order_id);
                $irClickId = get_post_meta($order_id, 'irclickid', true);
                if ($irClickId != '') {
                    $order = wc_get_order($order_id);
                    // Now you have access to (see above)...
                    if ($order) {
                        // Check if the customer has previous orders excluding the current order
                        $customerOrders = wc_get_orders(array(
                            'customer' => $order->get_customer_id(),
                            'exclude' => array($order->get_id()), // Exclude the current order
                            'limit' => 1,
                            'status' => array('processing', 'completed', 'on-hold', 'shipped', 'partial_ship'), // Add more statuses as needed
                        ));
                        $customerStatus = (empty($customerOrders)) ? 'NEW' : 'OLD';
                        $itemCounter = 1;
                        $hashedEmail = hash('sha256', $order->get_billing_email());
                        $orderData  = array(
                            'EventTypeId' => 35290,
                            'CampaignId' => 18348,
                            'ClickId' => $irClickId,
                            'EventDate' => 'NOW',
                            'OrderId' => $order_id,
                            'OrderDiscount' => $order->get_discount_total(),
                            'CustomerPostCode' => $order->get_billing_postcode(),
                            'CurrencyCode' => 'USD',
                            'CustomerStatus' => $customerStatus,
                            'IpAddress' => $order->get_customer_ip_address(),
                            'CustomerId' => $order->get_customer_id(),
                            'OrderPromoCode' =>    implode(', ', $order->get_coupon_codes()),
                            'CustomerEmail' => $hashedEmail,
                        );

                        foreach ($order->get_items() as $item_id => $item) {
                            $orderData['ItemSku' . $itemCounter] =     $item->get_product()->get_sku();
                            $orderData['ItemName' . $itemCounter] =     $item->get_name();
                            $orderData['ItemQuantity' . $itemCounter] =    $item->get_quantity();
                            $orderData['ItemPrice' . $itemCounter] =    $item->get_total() / $item->get_quantity();
                            $itemCounter++;
                        }

                        // Replace these placeholders with your actual values
                        $accountSid = 'IRT5rs8NSrun3959030Unv9zMCYRQfHDW1';
                        $authToken = 'X2hVQk-CSVbnWLExBLFztLCX7L.FUvRX';




                        // Initialize cURL session
                        $ch = curl_init();

                        // Set cURL options
                        curl_setopt($ch, CURLOPT_URL, "https://api.impact.com/Advertisers/{$accountSid}/Conversions");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded',
                        ]);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($orderData));

                        // Execute the cURL request
                        $response = curl_exec($ch);

                        // Check for cURL errors
                        if (curl_errno($ch)) {
                            $response .=  ' cURL error: ' . curl_error($ch);
                        }
                        // Close cURL session
                        curl_close($ch);
                        update_post_meta($order_id, 'impact_response', $response);
                    }
                }
            }
       
        $data_layer = array(
            'order_id' => $order_id,
        );
    ?>
        <script>
            dataLayer.push(<?php echo json_encode($data_layer); ?>);
        </script>
    <?php
 }
    }
}
/**
 * Generates and returns the shipment package list based on the provided parameters.
 *
 * @param array $packing_array An array containing order-related information for generating the shipment package list.
 *
 * @return string|false Shipment package list HTML or false if no data is available.
 */
function shipmentPackageList($packing_array)
{

    $order_id = isset($packing_array['order_id']) ? $packing_array['order_id'] : 0;
    $orderItems = isset($packing_array['orderItems']) ? $packing_array['orderItems'] : 0;
    $packaging_note = isset($packing_array['packaging_note']) ? $packing_array['packaging_note'] : 'N/A';
    $shipment_package_id = isset($packing_array['shipment_package_id']) ? $packing_array['shipment_package_id'] : 0;
    $batchID = isset($packing_array['batchID']) ? $packing_array['batchID'] : '';
    $groupID = isset($packing_array['group_id']) ? $packing_array['group_id'] : '';

    global $wpdb;
    $order = wc_get_order($order_id);
    $productPackagingLabelData = array();
    $order_notes = array();

    foreach ($order->get_items() as $item_id => $item) {
        if (isset($orderItems[$item_id]) && $orderItems[$item_id] > 0) {
            $product_id = $item->get_product_id();
            $compositeData = get_post_meta($product_id, '_bto_data', true);


            $compositeData = get_post_meta($product_id, '_bto_data', true);
            $flagcompositeData =   wc_get_order_item_meta($item_id, '_composite_data',  true);
            if (!empty($flagcompositeData)) {
                if (empty($compositeData)) {
                    $compositeData = get_post_meta($product_id, '_bto_data_backup', true);
                }

                //   if ($compositeData) {
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                    /* Composite Prdoucts Child Items */
                } else if (wc_cp_is_composite_container_order_item($item)) {

                    ///$compositeData = get_post_meta($product_id, '_bto_data', true);
                    $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
                    $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
                    $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
                    $shipment = wc_get_order_item_meta($item_id, '_shipped_count', true);
                    $tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                    //echo 'Data: <pre>' .print_r($productShipmentType,true). '</pre>';
                    if ($productShipmentType == 'yes') {
                        if ($compositeData) {
                            $childCompositeData = array();
                            foreach ($compositeData as $composite_item_id => $composite_item) {
                                $quantity_ordered = 0;
                                $firstShipment = get_post_meta($composite_item_id, 'sm_first_shipment', true);
                                if ($firstShipment) {
                                    $quantity_ordered = $quantity_ordered + $firstShipment;
                                }
                                $secondShipment = get_post_meta($composite_item_id, 'sm_second_shipment', true);
                                if ($secondShipment) {
                                    $quantity_ordered = $quantity_ordered + $secondShipment;
                                }
                                $quantity_shipped = 0;
                                if ($shipment == 1) {
                                    $quantity_shipped = $secondShipment;
                                } else {
                                    $quantity_shipped = $firstShipment;
                                }
                                if ($quantity_shipped > 0) {
                                    $childCompositeData[] = array(
                                        'product_id' => $composite_item['default_id'],
                                        'quantity_ordered' => $quantity_ordered,
                                        'quantity_shipped' => $quantity_shipped
                                    );
                                }
                            }
                            if ($shipment == 1) {
                                $productPackagingLabelData[] = array(
                                    'product_id' => $product_id,
                                    'quantity_ordered' => '1',
                                    'quantity_shipped' => '1',
                                    'tray_no' => $tray_no,
                                    'mouth_guard_color' => $mouth_guard_color,
                                    'mouth_guard_number' => $mouth_guard_number,
                                    'childs' => $childCompositeData
                                );
                            } else {
                                $productPackagingLabelData[] = array(
                                    'product_id' => $product_id,
                                    'quantity_ordered' => '1',
                                    'quantity_shipped' => '1',
                                    'tray_no' => $tray_no,
                                    'mouth_guard_color' => $mouth_guard_color,
                                    'mouth_guard_number' => $mouth_guard_number,
                                    'childs' => array()
                                );
                            }
                        }
                    } else {
                        $item_quantity = $item->get_quantity(); // Get the item quantity

                        $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
                        $childCompositeData = array();
                        $productPackagingLabelData[] = array(
                            'product_id' => $product_id,
                            'quantity_ordered' => $item_quantity,
                            'quantity_shipped' => $qtyShipped,
                            'tray_no' => $tray_no,
                            'mouth_guard_color' => $mouth_guard_color,
                            'mouth_guard_number' => $mouth_guard_number,
                            'childs' => $childCompositeData
                        );
                    }
                    /* Composite Prdoucts Parent Item */
                } else {
                    $tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                    $item_quantity = $item->get_quantity(); // Get the item quantity
                    $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
                    $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
                    $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
                    $productPackagingLabelData[] = array(
                        'product_id' => $product_id,
                        'quantity_ordered' => $item_quantity,
                        'quantity_shipped' => $qtyShipped,
                        'mouth_guard_color' => $mouth_guard_color,
                        'mouth_guard_number' => $mouth_guard_number,
                        'tray_no' => $tray_no,
                        'childs' => array()
                    );
                }
            } else {
                $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
                $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
                $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
                $shipment = wc_get_order_item_meta($item_id, '_shipped_count', true);
                $stockManagement = wc_get_order_item_meta($item_id, '_sbr_stock', true);
                $tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                $compositeData = get_field('composite_products', $product_id);
                
                $refund_quantity = 0;
                foreach ($order->get_refunds() as $refund) {
                    // Loop through each item in the refund
                    foreach ($refund->get_items() as $refund_item) {
                        // Check if the refunded item ID matches the specified item ID
                        if ($refund_item->get_meta('_refunded_item_id') == $item_id) {
                            // Add the refunded quantity to the total
                            $refund_quantity += abs($refund_item->get_quantity());
                        }
                    }
                }
                //$refunded_qty = wc_get_order_item_meta($item_id,'_restock_refunded_items',true);
                $refunded_qty = $refund_quantity;
                if ($productShipmentType == 'yes') {
                    $childCompositeData = array();
                    foreach ($compositeData as $composite_item_id => $composite_item) {

                        $quantity_ordered = 0;
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];
                        if ($firstShipment) {
                            $quantity_ordered = $quantity_ordered + $firstShipment;
                        }

                        if ($secondShipment) {
                            $quantity_ordered = $quantity_ordered + $secondShipment;
                        }
                        $quantity_shipped = 0;
                        if ($shipment == 1) {
                            $quantity_shipped = $secondShipment;
                        } else {
                            $quantity_shipped = $firstShipment;
                        }
                        if ($stockManagement == 'first') {

                            if (isset($order_notes[$composite_item_product_id])) {
                                $order_notes[$composite_item_product_id] = $secondShipment +   $order_notes[$composite_item_product_id];
                            } else {
                                $order_notes[$composite_item_product_id] = $secondShipment;
                            }
                        } else if ($stockManagement == 'second') {
                            //ALL Stock Updated
                        } else {

                            if (isset($order_notes[$composite_item_product_id])) {
                                $order_notes[$composite_item_product_id] = $firstShipment +   $order_notes[$composite_item_product_id];
                            } else {
                                $order_notes[$composite_item_product_id] = $firstShipment;
                            }
                        }

                        if ($quantity_shipped > 0) {

                            $childCompositeData[] = array(
                                'product_id' => $composite_item_product_id,
                                'quantity_ordered' => $quantity_ordered,
                                'quantity_shipped' => $quantity_shipped
                            );
                        }
                    }
                    if ($shipment == 1) {

                        $productPackagingLabelData[] = array(
                            'product_id' => $product_id,
                            'quantity_ordered' => '1',
                            'quantity_shipped' => '1',
                            'tray_no' => $tray_no,
                            'mouth_guard_color' => $mouth_guard_color,
                            'mouth_guard_number' => $mouth_guard_number,
                            'refunded_qty'=>$refunded_qty,
                            'childs' => $childCompositeData
                        );
                        wc_update_order_item_meta($item_id, '_sbr_stock', 'second');
                    } else {
                        $productPackagingLabelData[] = array(
                            'product_id' => $product_id,
                            'quantity_ordered' => '1',
                            'quantity_shipped' => '1',
                            'tray_no' => $tray_no,
                            'mouth_guard_color' => $mouth_guard_color,
                            'mouth_guard_number' => $mouth_guard_number,
                            'refunded_qty'=>$refunded_qty,
                            'childs' => array()
                        );
                        wc_update_order_item_meta($item_id, '_sbr_stock', 'first');
                    }
                } else {
                    $flagSubscribedItem =  wc_get_order_item_meta($item_id, '_subscriptionId',  true);                    
                    $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
                if ($compositeData) {
                    foreach ($compositeData as $composite_item_id => $composite_item) {
                        $quantity_ordered = 0;
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];
                        if ($stockManagement != 'shipped') {
                            if ($firstShipment) {
//if cases added for subscription#RB                                        
                                    if($flagSubscribedItem && $flagSubscribedItem > 0){
                                        $rows = get_field('define_subscription_plans', $product_id);   
                                        $arbid = wc_get_order_item_meta($item_id, '_arbid',  true);
                                        foreach ($rows as $index => $data) {
                                            if ($index == $arbid) {
                                                $qtyShipped = $data['select_qty'];
                                            }
                                        }
                                        $order_notes[$composite_item_product_id] = ($firstShipment*$qtyShipped*$item->get_quantity()) + (int)@$order_notes[$composite_item_product_id];
                                    }else{
                                if (isset($order_notes[$composite_item_product_id])) {
                                    $order_notes[$composite_item_product_id] = $firstShipment + $order_notes[$composite_item_product_id];
                                } else {
                                    $order_notes[$composite_item_product_id] = ($firstShipment*$qtyShipped);
                                        }    
                                }
                            }
                        }
                    }
                }
               
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $childCompositeData = array();
                $productPackagingLabelData[] = array(
                    'product_id' => $product_id,
                    'quantity_ordered' => $item_quantity,
                    'quantity_shipped' => $qtyShipped,
                    'tray_no' => $tray_no,
                    'mouth_guard_color' => $mouth_guard_color,
                    'mouth_guard_number' => $mouth_guard_number,
                    'refunded_qty'=>$refunded_qty,
                    'childs' => array()
                );
                wc_update_order_item_meta($item_id, '_sbr_stock', 'shipped');
                }
            }
        }
    }
    if (!empty($productPackagingLabelData)) {
        $packing_array = array(
            'order_id' => $order_id,
            'packing_note' => $packaging_note,
            'package_id' => $shipment_package_id,
            'products' => $productPackagingLabelData,
            'batchNo' => $batchID,
            'groupID' => $groupID
        );
        //get_packing_slip_by_order_id($packing_array);
        if (!empty($order_notes)) {
            $logs = array();
            foreach ($order_notes as $item_product_id => $child_qty) {
                if ($child_qty) {
                    $productObj = wc_get_product($item_product_id);
                    wc_update_product_stock($item_product_id, $child_qty, 'decrease', false);
                    $logs[$item_product_id] = $productObj->get_formatted_name() . ' &rarr; ' . $child_qty;
                }
            }
            $order->add_order_note(sprintf(__('Stock decrease:<br/> %s', 'woocommerce'), implode('<br/>', $logs)));
        }
        $returnResponsePackaging = get_packing_slip_by_order_id($packing_array);

        $returnResponsePackaging = str_replace('″', '"', $returnResponsePackaging);
        // echo 'Data: <pre>' . print_r($returnResponsePackaging, true) . '</pre>';
        // die;
        return $returnResponsePackaging = str_replace('→', '-->', $returnResponsePackaging);
    } else {
        return false;
    }
}

/**
 * Generates and returns the shipment package list based on the provided parameters.
 *
 * @param array $packing_array An array containing order-related information for generating the shipment package list.
 *
 * @return string|false Shipment package list HTML or false if no data is available.
 */
function shipmentPackageList_previous_version($packing_array)
{

    $order_id = isset($packing_array['order_id']) ? $packing_array['order_id'] : 0;
    $orderItems = isset($packing_array['orderItems']) ? $packing_array['orderItems'] : 0;
    $packaging_note = isset($packing_array['packaging_note']) ? $packing_array['packaging_note'] : 'N/A';
    $shipment_package_id = isset($packing_array['shipment_package_id']) ? $packing_array['shipment_package_id'] : 0;
    $batchID = isset($packing_array['batchID']) ? $packing_array['batchID'] : '';
    $groupID = isset($packing_array['group_id']) ? $packing_array['group_id'] : '';

    global $wpdb;
    $order = wc_get_order($order_id);
    $productPackagingLabelData = array();
    //$order_id = $order->get_id();
    foreach ($order->get_items() as $item_id => $item) {
        if (isset($orderItems[$item_id]) && $orderItems[$item_id] > 0) {
            $product_id = $item->get_product_id();
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                /* Composite Prdoucts Child Items */
            } else if (wc_cp_is_composite_container_order_item($item)) {

                $compositeData = get_post_meta($product_id, '_bto_data', true);
                $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
                $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
                $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
                $shipment = wc_get_order_item_meta($item_id, '_shipped_count', true);
                $tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                //echo 'Data: <pre>' .print_r($productShipmentType,true). '</pre>';
                if ($productShipmentType == 'yes') {
                    if ($compositeData) {
                        $childCompositeData = array();
                        foreach ($compositeData as $composite_item_id => $composite_item) {
                            $quantity_ordered = 0;
                            $firstShipment = get_post_meta($composite_item_id, 'sm_first_shipment', true);
                            if ($firstShipment) {
                                $quantity_ordered = $quantity_ordered + $firstShipment;
                            }
                            $secondShipment = get_post_meta($composite_item_id, 'sm_second_shipment', true);
                            if ($secondShipment) {
                                $quantity_ordered = $quantity_ordered + $secondShipment;
                            }
                            $quantity_shipped = 0;
                            if ($shipment == 1) {
                                $quantity_shipped = $secondShipment;
                            } else {
                                $quantity_shipped = $firstShipment;
                            }
                            if ($quantity_shipped > 0) {
                                $childCompositeData[] = array(
                                    'product_id' => $composite_item['default_id'],
                                    'quantity_ordered' => $quantity_ordered,
                                    'quantity_shipped' => $quantity_shipped
                                );
                            }
                        }
                        if ($shipment == 1) {
                            $productPackagingLabelData[] = array(
                                'product_id' => $product_id,
                                'quantity_ordered' => '1',
                                'quantity_shipped' => '1',
                                'tray_no' => $tray_no,
                                'mouth_guard_color' => $mouth_guard_color,
                                'mouth_guard_number' => $mouth_guard_number,
                                'childs' => $childCompositeData
                            );
                        } else {
                            $productPackagingLabelData[] = array(
                                'product_id' => $product_id,
                                'quantity_ordered' => '1',
                                'quantity_shipped' => '1',
                                'tray_no' => $tray_no,
                                'mouth_guard_color' => $mouth_guard_color,
                                'mouth_guard_number' => $mouth_guard_number,
                                'childs' => array()
                            );
                        }
                    }
                } else {
                    $item_quantity = $item->get_quantity(); // Get the item quantity

                    $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
                    $childCompositeData = array();
                    $productPackagingLabelData[] = array(
                        'product_id' => $product_id,
                        'quantity_ordered' => $item_quantity,
                        'quantity_shipped' => $qtyShipped,
                        'tray_no' => $tray_no,
                        'mouth_guard_color' => $mouth_guard_color,
                        'mouth_guard_number' => $mouth_guard_number,
                        'childs' => $childCompositeData
                    );
                }
                /* Composite Prdoucts Parent Item */
            } else {
                $tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
                $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
                $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
                $productPackagingLabelData[] = array(
                    'product_id' => $product_id,
                    'quantity_ordered' => $item_quantity,
                    'quantity_shipped' => $qtyShipped,
                    'mouth_guard_color' => $mouth_guard_color,
                    'mouth_guard_number' => $mouth_guard_number,
                    'tray_no' => $tray_no,
                    'childs' => array()
                );
            }
        }
    }
    if (!empty($productPackagingLabelData)) {
        $packing_array = array(
            'order_id' => $order_id,
            'packing_note' => $packaging_note,
            'package_id' => $shipment_package_id,
            'products' => $productPackagingLabelData,
            'batchNo' => $batchID,
            'groupID' => $groupID
        );
        //get_packing_slip_by_order_id($packing_array);
        //echo 'Data: <pre>' .print_r($packing_array,true). '</pre>';
        //die;
        $returnResponsePackaging = get_packing_slip_by_order_id($packing_array);

        $returnResponsePackaging = str_replace('″', '"', $returnResponsePackaging);
        return $returnResponsePackaging = str_replace('→', '-->', $returnResponsePackaging);
    } else {
        return false;
    }
}


/**
 * Registers the AJAX action for printing an order label.
 */
add_action('wp_ajax_sb_order_print_label', 'sb_order_print_label_callback');

/**
 * Callback function for handling the AJAX request to print an order label.
 * Checks if the file for the given tracking number exists and prints the label if found.
 */
function sb_order_print_label_callback()
{
    $logs_dir = get_home_path() . 'labels/';
    if (isset($_REQUEST['trackingno']) && $_REQUEST['trackingno'] <> '') {
        $trackingno = $_REQUEST['trackingno'];
        $file_path = $logs_dir . $trackingno . '.png';

        if (file_exists($file_path)) {
            echo 'Done';
            mbt_printer_receipt($file_path);
        } else {
            echo 'File not found.';
        }
    } else {
        echo 'tracking code not found.';
    }
    die;
}
/**
 * Add shipment history for an item.
 *
 * @param int    $item_id      The ID of the order item.
 * @param int    $qty          The quantity of items shipped.
 * @param string $type         The type of item (e.g., 'composite').
 * @param string $tracking_no  The tracking number associated with the shipment.
 * @param string $date         The date of the shipment.
 */
function addShipmentHistory($item_id, $qty, $type, $tracking_no = '', $date)
{

    $shippedHistory = wc_get_order_item_meta($item_id, 'shipped');
    if ($type == 'composite') {
        $shippedHistoryCount = wc_get_order_item_meta($item_id, '_shipped_count');
        if ($shippedHistoryCount) {
            wc_update_order_item_meta($item_id, '_shipped_count', 2);
            wc_update_order_item_meta($item_id, '_second_tracking_number', $tracking_no);
            $shippedHistory = array();
            $shippedHistory[$date] = 1;
            wc_update_order_item_meta($item_id, 'shipped', $shippedHistory);
        } else {
            wc_update_order_item_meta($item_id, '_shipped_count', 1);
            wc_update_order_item_meta($item_id, '_first_tracking_number', $tracking_no);
        }
    } else {
        if ($shippedHistory) {
            if (array_key_exists($date, $shippedHistory)) {
                $shippedHistory[$date] += $qty;
            } else {
                $shippedHistory[$date] = $qty;
            }
        } else {
            $shippedHistory = array();
            $shippedHistory[$date] = $qty;
        }
        wc_update_order_item_meta($item_id, 'shipped', $shippedHistory);
    }
}

add_action('wp_ajax_generate_shipment_id', 'generate_shipment_id_callback');


add_action('wp_ajax_mbt_createShipmentWithPackages', 'mbt_createShipmentWithPackages_callback');
/**
 * Callback function for creating shipments with packages using EasyPost API.
 */
function mbt_createShipmentWithPackages_callback1212()
{
    $response = array();
    try {

        require_once(ABSPATH . 'vendor/autoload.php');
        $client = new \EasyPost\EasyPostClient("EZTKfa1edfb636794cf0a30a8a5e630f53b7UwjiVnQorjPo0OQmedOFZg");
        
        global $MbtPackaging;

        $order_id = $_REQUEST['order_id'];
        $order = wc_get_order($order_id);

        if (isset($_REQUEST['is_shipping_address_changed']) && $_REQUEST['is_shipping_address_changed'] == 'old') {

            $fname = $order->get_shipping_first_name();
            if (empty($fname)) {
                $fname = $order->get_billing_first_name();
            }

            $lname = $order->get_shipping_last_name();
            if (empty($lname)) {
                $lname = $order->get_billing_last_name();
            }
            $email = $order->get_billing_email();
            $phone = $order->get_billing_phone();
            $address1 = $order->get_shipping_address_1();
            if (empty($address1)) {
                $address1 = $order->get_billing_address_1();
            }
            $address2 = $order->get_shipping_address_2();
            if (empty($address2)) {
                $address2 = $order->get_billing_address_2();
            }

            $city = $order->get_shipping_city();
            if (empty($city)) {
                $city = $order->get_billing_city();
            }

            $state = $order->get_shipping_state();
            if (empty($state)) {
                $state = $order->get_billing_state();
            }

            $zipcode = $order->get_shipping_postcode();
            if (empty($zipcode)) {
                $zipcode = $order->get_billing_postcode();
            }

            $country = $order->get_shipping_country();
            if (empty($country)) {
                $country = $order->get_billing_country();
            }
        } else {
            $fname = isset($_REQUEST['fname']) ? $_REQUEST['fname'] : '';
            $lname = isset($_REQUEST['lname']) ? $_REQUEST['lname'] : '';
            $address1 = isset($_REQUEST['address1']) ? $_REQUEST['address1'] : '';
            $address2 = isset($_REQUEST['address2']) ? $_REQUEST['address2'] : '';
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
            $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
            $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : '';
            $state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
            $country = isset($_REQUEST['country']) ? $_REQUEST['country'] : '';
            $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
        }



        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 5.2;
        $width = isset($_REQUEST['width']) ? $_REQUEST['width'] : 1.9;
        $height = isset($_REQUEST['height']) ? $_REQUEST['height'] : 2;
        $weight = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : 2.9;

        $shipment_package_id = isset($_REQUEST['shipment_package_id']) ? $_REQUEST['shipment_package_id'] : 0;
        if ($shipment_package_id) {
            $package_info = $MbtPackaging->get_package_info_for_shipping($shipment_package_id);

            if ($package_info) {
                if (isset($package_info['length']) && $package_info['length'] > 0) {
                    $length = $package_info['length'];
                }
                if (isset($package_info['width']) && $package_info['width'] > 0) {
                    $width = $package_info['width'];
                }
                if (isset($package_info['height']) && $package_info['height'] > 0) {
                    $height = $package_info['height'];
                }
                if (isset($package_info['weight']) && $package_info['weight'] > 0) {
                    $weight = $package_info['weight'];
                }
            }
        }
        if (empty($length) || empty($width) || empty($height) || empty($weight)) {

            $response = array(
                'code' => 'error',
                'msg' => 'Packaging box dimension missing. please make sure parcel dimension are added in selected package.'
            );
            echo json_encode($response);
            die;
        }

        if (isset($_REQUEST['shipping_date']) && $_REQUEST['shipping_date'] <> '') {
            $labelDate = date("Y-m-d", strtotime(@trim($_REQUEST['shipping_date']) . " 12:00:00")) . "T12:00:00-07";
        } else {
            $labelDate = date("Y-m-d") . " 12:00:00" . "T12:00:00-07";
        }

        $shipping_qty = $_REQUEST['shipping_qty'];
        $product_wight = $_REQUEST['product_wight'];

        $productsWithQty = array();
        $getItemListShiped = array();
        $productsWithWeight = array();
        //       $packaging_note = $_REQUEST['packaging_order_note'];
        //      $returnResponsePackaging = shipmentPackageList($order_id, $shipping_qty, $packaging_note , $shipment_package_id);





        foreach ($shipping_qty as $item_id => $qty) {

            if ($qty > 0) {
                $item_info = $order->get_item($item_id);
                $product_id = $item_info->get_product_id();
                $pro_price = $item_info->get_total();
                if (isset($productsWithQty[$product_id])) {
                    $productsWithQty[$product_id] = $productsWithQty[$product_id] + $qty;
                } else {
                    $productsWithQty[$product_id] = $qty;
                }
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product) {
                    $getItemListShiped[$item_id] = array(
                        'product_id' => $product_id,
                        'qty' => $qty,
                        'type' => 'composite',
                        'price' => $pro_price
                    );
                } else {
                    $getItemListShiped[$item_id] = array(
                        'product_id' => $product_id,
                        'qty' => $qty,
                        'type' => 'simple',
                        'price' => $pro_price
                    );
                }
            }
        }
        $parcelProductsWeight = $weight;
        $customs_items = array();
        $productDuplicate_array = array();
        if (count($getItemListShiped) > 0) {
            foreach ($getItemListShiped as $item_id_val => $item_detail) {
                $product_id_val = $item_detail['product_id'];
                $product_qty_val = $item_detail['qty'];
                $product_price_val = $item_detail['price'];
                if (isset($productDuplicate_array[$product_id_val])) {
                    $productDuplicate_array[$product_id_val] = ($productDuplicate_array[$product_id_val] + $product_qty_val) * $product_price_val;
                } else {
                    $productDuplicate_array[$product_id_val] = $product_qty_val * $product_price_val;
                }
            }
        }

        if (count($productsWithQty) > 0) {
            foreach ($productsWithQty as $prod_id => $p_qty) {
                if($prod_id == SHIPPING_PROTECTION_PRODUCT){
                    continue;
                }
                $weight = get_post_meta($prod_id, '_weight', true);
                if (empty($weight)) {
                    $weight = 0.01;
                }
                $parcelProductsWeight = $parcelProductsWeight + ($weight * $p_qty);
                $product_price = isset($productDuplicate_array[$prod_id]) ? $productDuplicate_array[$prod_id] : 0;
                $curItemArray = array(
                    "description" => strip_tags(get_the_title($prod_id)),
                    "quantity" => $p_qty,
                    "weight" => $weight * $p_qty,
                    "value" => $product_price,
                    "hs_tariff_number" => '123456',
                    "origin_country" => 'US'
                );
                array_push($customs_items, $client->customsItem->create($curItemArray));
            }
            // echo 'Data: 1<pre>' .print_r($productDuplicate_array,true). '</pre>';
            //    echo '<pre>';
            //    print_r($customs_items);
            //    echo '</pre>';
            //    die;
            //$parcelProductsWeight + $weight;
            if (count($customs_items) > 0) {

                //NOW CREATE OUR SHIPMENT
                $shipmentOptions = array(
                    'label_date' => $labelDate,
                    'currency' => 'USD',
                    'delivery_confirmation' => 'SIGNATURE',
                    'saturday_delivery' => true,
                );
                $customs_info = $client->customsInfo->create(array(
                    "eel_pfc" => 'NOEEI 30.37(a)',
                    "customs_certify" => true,
                    "customs_signer" => 'Salman Shah',
                    "contents_type" => 'merchandise',
                    "contents_explanation" => '',
                    "restriction_type" => 'none',
                    "non_delivery_option" => 'return',
                    "customs_items" => $customs_items
                ));
                $shipment = $client->shipment->create(array(
                    'options' => $shipmentOptions,
                    'is_return' => false,
                    //'carrier_accounts' => $carrier_accounts,
                    "reference" => $order_id,
                    "to_address" => array(
                        'name' => $fname . ' ' . $lname,
                        'street1' => $address1,
                        'street2' => $address2,
                        'city' => $city,
                        'state' => $state,
                        'zip' => $zipcode,
                        'country' => $country,
                        'phone' => $phone,
                        'email' => $email
                    ),
                    "from_address" => array(
                        'name' => 'Smile Brillaint Inc',
                        'street1' => '746 Springhill Farm Drive',
                        'street2' => 'Missouri',
                        'city' => 'Saint Louis',
                        'state' => 'MO',
                        'zip' => '63021-8419',
                        'country' => 'US',
                        'phone' => '3331114444',
                        'email' => 'ejaz@mindblazetech.com'
                    ),
                    "parcel" => array(
                        "length" => $length,
                        "width" => $width,
                        "height" => $height,
                        "weight" => ($parcelProductsWeight + $weight)
                    ),
                    'customs_info' => $customs_info,
                    //'service' => 'PriorityMailInternational',
                ));

                $shipment_id = $shipment->id;

                $boughtShipment =$client->shipment->buy($shipment->id, $shipment->lowestRate());

                $tracking_number = 0;
                if (isset($shipment->tracking_code)) {
                    $tracking_number = $shipment->tracking_code;
                }
                //$shipment->label(array("file_format" => "pdf"));
                $shipmentWithLabel =$client->shipment->label( $shipment->id,array("file_format" => "pdf"));
                $shipment_trackingUrl = @$shipmentWithLabel->tracker->public_url;
                $_POST['easypost_tracking_number'] = $tracking_number;
                $_POST['easypost_tracking_url'] = $shipment_trackingUrl;
                $get_postage_label = isset($shipmentWithLabel->postage_label) ? $shipmentWithLabel->postage_label : '';
                $get_label_pdf_url = isset($shipmentWithLabel->label_pdf_url) ? $shipmentWithLabel->label_pdf_url : '';
                $shipment_cost = @$shipmentWithLabel->selected_rate->rate;
                $shipment_method_carrier = @$shipmentWithLabel->selected_rate->carrier;
                $shipment_method_service = @$shipmentWithLabel->selected_rate->service;
                $shipment_data = array(
                    "order_id" => $order_id,
                    "shipment_method" => $shipment_method_service,
                    "shipment_id_easypost" => $shipment_id,
                    "shipment_method_carrier" => $shipment_method_carrier,
                    "shipment_method_service" => $shipment_method_service,
                    "shipment_cost" => $shipment_cost,
                    "shipment_label" => isset($_REQUEST['shipping_lable']) ? $_REQUEST['shipping_lable'] : '',
                    "url" => $get_label_pdf_url,
                    "tracking_url" => $shipment_trackingUrl,
                    "tracking_code" => $tracking_number,
                    "shipping_information" => json_encode($_REQUEST),
                    "shipping_date" => $labelDate,
                );
                $shipment_db_id = sb_create_shipment($shipment_data);



                //download teh PNG version of the label
                $randomFileName = $tracking_number . ".png";
                $downloadResult = @file_get_contents(@$shipmentWithLabel->postage_label->label_url);
                $downloadSuccess = false;
                if ($downloadResult) {


                    if (isset($_REQUEST['tracking_email']) && $_REQUEST['tracking_email'] == 'yes') {
                        WC()->mailer()->emails['WC_Shipment_Order_Email']->trigger($order_id);
                    }

                    if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
                        //    $packagingNote = '<b>Packaging Note</> <br/><b>Tracing ID: '.$tracking_number.'</b><br/>'.$_REQUEST['packaging_order_note'];
                        $packagingNote = '<div class="note_content">
                                            <p><strong>Packaging Note</strong></p>
                                            <p><strong>Tracing ID: </strong> ' . $tracking_number . '</p>
                                            <p><strong>Message: </strong>' . $_REQUEST['packaging_order_note'] . '</p>
                                            <p><strong>Status: <span style="color: green">Sent</span></strong></p>
                                        </div>';
                        create_woo_order_note($packagingNote, $order_id, true);
                    }
                    if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {
                        $packaging_note = '';
                        if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
                            $packaging_note = $_REQUEST['packaging_order_note'];
                        }
                        $returnResponsePackaging = shipmentPackageList($order_id, $shipping_qty, $packaging_note, $shipment_package_id);

                        //require_once("dompdf/autoload.php");
                        require_once("dompdfkami/autoload.inc.php");


                        // instantiate and use the dompdf class
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($returnResponsePackaging);
                        $logs_dir = get_home_path() . 'packaging/';
                        if (!is_dir($logs_dir)) {
                            mkdir($logs_dir, 0755, true);
                        }
                        $dompdf->render();
                        $output = $dompdf->output();

                        $packagingFileName = $tracking_number . '.pdf';

                        file_put_contents($logs_dir . $packagingFileName, $output);
                        //successful drop of the file
                        $packaging_file_path = $logs_dir . $packagingFileName;
                        mbt_printer_receipt($packaging_file_path, $insertArray['shiptoCountry']);
                    }


                    $MbtPackaging->manage_package_inventory($shipment_package_id);
                    $logs_dir = get_home_path() . 'labels/';
                    if (!is_dir($logs_dir)) {
                        mkdir($logs_dir, 0755, true);
                    }
                    //put the contents
                    $filePutResult = @file_put_contents($logs_dir . $randomFileName, $downloadResult);
                    if ($filePutResult) {
                        //successful drop of the file
                        $downloadSuccess = true;
                        $file_path = $logs_dir . $randomFileName;
                        if (isset($_REQUEST['print_label_shipment']) && $_REQUEST['print_label_shipment'] == 'yes') {
                            mbt_printer_receipt($file_path, $insertArray['shiptoCountry']);
                        }
                    }
                }

                if (!empty($shipment_db_id)) {
                    $shipStatus = false;
                    foreach ($getItemListShiped as $item_id => $data) {
                        $product_id = $data['product_id'];
                        $event_data = array(
                            "order_id" => $order_id,
                            "item_id" => $item_id,
                            "shipment_id" => $shipment_db_id,
                            "product_id" => $product_id,
                            "event_id" => 2,
                        );
                        //sb_create_log($event_data);
                        //Create Log    
                        // addShipmentHistory($item_id, $data['qty'], $data['type'], $tracking_number, date("Y-m-d", strtotime(@trim($_REQUEST['shipping_date']))));

                        $orderItem_info = $order->get_item($item_id);
                        $item_quantity = $orderItem_info->get_quantity(); // Get the item quantity

                        $qtyShipped = 0;
                        $getRemainingQuantity = 0;
                        $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                        if ($shippedhistory) {
                            foreach ($shippedhistory as $shippedhistoryQty) {
                                $qtyShipped += (int) $shippedhistoryQty;
                            }
                        }
                        if ($item_quantity) {
                            $getRemainingQuantity = $item_quantity - $qtyShipped;
                        }

                        if ($data['type'] == 'composite') {

                            if ($getRemainingQuantity) {
                                $event_data = array(
                                    "order_id" => $order_id,
                                    "item_id" => $item_id,
                                    "product_id" => $product_id,
                                    "event_id" => 3,
                                );
                                //sb_create_log($event_data);
                            }
                        } else {
                            if ($getRemainingQuantity) {
                                $event_data = array(
                                    "order_id" => $order_id,
                                    "item_id" => $item_id,
                                    "shipment_id" => $shipment_db_id,
                                    "product_id" => $product_id,
                                    "event_id" => 1,
                                );
                                // sb_create_log($event_data);
                            }
                        }

                        $shipStatus = mbt_addOrderStatus($order_id);
                    }
                    $response = array(
                        'code' => 'success',
                        'status' => $shipStatus,
                        'source' => isset($_REQUEST['source']) ? $_REQUEST['source'] : 'order',
                        'msg' => 'Shipment created successfully. Tracking ID# ' . $tracking_number
                    );
                } else {
                    $response = array(
                        'code' => 'error',
                        'msg' => 'Shipment unable to save in DB.'
                    );
                }
            } else {
                $response = array(
                    'code' => 'error',
                    'msg' => 'No customer item found to ship.'
                );
            }
        } else {
            $response = array(
                'code' => 'error',
                'msg' => 'No product qty found to ship.'
            );
        }
    } catch (\Exception $ex) {

        $response = array(
            'code' => 'error',
            'msg' => $ex->getMessage()
        );
    }
    echo json_encode($response);
    die;
}
/**
 * Generate HTML for displaying duplicate combinations.
 *
 * @param array $packageNamebyId An array of package names indexed by package ID.
 * @param array $get_packages    The array containing information about package combinations.
 *
 * @return string HTML representation of duplicate combinations.
 */
function createDuplicateCombinationHtml($packageNamebyId, $get_packages)
{
    $combinationHtml = '';
    if (isset($get_packages['combinations'])) {

        $combinationHtml .= '<div class="orderHistorySection">';
        $combinationHtml .= '<h3>Found Repeated Combination</h3>';
        $combinationHtml .= '<table id="orderHistory" class="data-table" style="width:99%">';
        $combinationHtml .= '<thead>';
        $combinationHtml .= '<tr>';
        $combinationHtml .= '<th>Package ID</th>';
        $combinationHtml .= '<th>Package Name</th>';
        $combinationHtml .= '<th>Groups</th>';
        $combinationHtml .= '</tr>';
        $combinationHtml .= '</thead>';
        $combinationHtml .= '<tbody>';

        foreach ($get_packages['combinations'] as  $package_id =>  $foundPackages) {
            $availableRecord = (array)$foundPackages;
            $combinationHtml .= '<tr>';
            $combinationHtml .= '<td>' . $package_id . '</td>';
            $combinationHtml .= '<td>' . $packageNamebyId[$package_id] . '</td>';
            $combinationHtml .= '<td>';
            $combinationHtml .= '<table>';
            $combinationHtml .= '<tbody>';
            $combinationHtml_inner = '';
            foreach ($availableRecord as $group_id =>  $packageGroup) {
                $combinationHtml_inner .= '<tr class="parentGroup group_row_' . $group_id . '">';
                $combinationHtml_inner .= '<td colspan=3>';
                $combinationHtml_inner .= '<div class="rowTopMbt">';
                $combinationHtml_inner .= '<div class="groupId">Group ID#' . $group_id . '</div>';
                $combinationHtml_inner .= '<div class="inputCross">';
                ///   $combinationHtml_inner .= '<span class="inputButton"><label for="group_radio_' . $group_id . '"><input name="setPackageGroup" id="group_radio_' . $group_id . '" type="radio" class="radioPackageGroup" value="' . $group_id . '">Set as default</label></span>';
                $combinationHtml_inner .= '<a href="javascript:;" onclick="removePackageGroup(' . $package_id . ', ' . $group_id . ')" class="crossIcon" >×</a>';
                $combinationHtml_inner .= '</div>';
                $combinationHtml_inner .= '</div>';

                foreach ($packageGroup as  $groupData) {
                    $combinationHtml_inner .= '<div class="group_row_' . $group_id . ' item">';
                    //$combinationHtml_inner .= '<div class="group_package_title">' . $groupData->package_products_descending . '</div>';
                    $combinationHtml_inner .= '<div class="group_package_title">' . get_the_title($groupData->product_id) . '</div>';
                    $combinationHtml_inner .= '<div class="minMax">';
                    $combinationHtml_inner .= '<div class="minQty">Min Qty: ' . $groupData->qty_min . '</div>';
                    $combinationHtml_inner .= '<div class="maxQty">Max Qty: ' . $groupData->qty_max . '</div>';
                    $combinationHtml_inner .= '</div>';
                    $combinationHtml_inner .= '</div>';
                }
                $combinationHtml_inner .= '</td>';
                $combinationHtml_inner .= '</tr>';
            }

            $combinationHtml .= $combinationHtml_inner;
            $combinationHtml .= '</tbody>';
            $combinationHtml .= '</table>';
            $combinationHtml .= '</td>';
            $combinationHtml .= '</tr>';
        }
        $combinationHtml .= '</tbody>';
        $combinationHtml .= '</table>';
    }
    return $combinationHtml;
}

add_action('wp_ajax_generate_order_package', 'generate_order_package_callback');
/**
 * AJAX callback function for generating order packages.
 *
 * @wp-hook wp_ajax_generate_order_package
 *
 * @global $MbtPackaging
 *
 * @return void Outputs JSON-encoded response.
 */
function generate_order_package_callback()
{
    global $MbtPackaging;

    $orderItem = $_REQUEST['orderItem'];
    $order_id = $_REQUEST['order_id'];

    $productsWithQty = array();
    $QueryForNotFoundPackage = 'p=1';

    $shipmentLevel = array();

    $productsQtyShipmentLevel = array();
    foreach ($orderItem as $item_id => $productDetail) {
        if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
            $product_id = $productDetail['product_id'];
            if($product_id == SHIPPING_PROTECTION_PRODUCT || in_array($product_id, VIRTUAL_PRODUCTS)){
                continue;
            }
            $qty = $productDetail['qty'];
            $level = 1;
            if ($productDetail['type'] == 'composite') {
                $level = $productDetail['shipment'];
            }
            $data = array(
                'product_id' => $product_id,
                'qty' => $qty,
                'level' => $level
            );

            $existingKey = multi_array_search($productsQtyShipmentLevel, array('product_id' => $product_id, 'level' => $level));
            if (count($existingKey) > 0) {
                $productsQtyShipmentLevel[$existingKey[0]]['qty'] = $productsQtyShipmentLevel[$existingKey[0]]['qty'] + $qty;
            } else {
                $productsQtyShipmentLevel[] = $data;
            }
        }
    }
    $selectedPackage = 0;
    $defaultCase = false;
    $error_msg = '';
    $combinationHtml = '';
    $packageNamebyId = array();
    $get_all_packages = $MbtPackaging->get_all_packages();
    foreach ($get_all_packages as $key => $package) {
        $packageNamebyId[$package->id] = $package->name;
    }
    if (count($productsQtyShipmentLevel) > 0) {
        $get_packages = $MbtPackaging->get_package_ids_for_basket($productsQtyShipmentLevel);
        $combinationHtml = createDuplicateCombinationHtml($packageNamebyId, $get_packages);
        if ($get_packages['status'] == 1) {
            $selectedPackage = isset($get_packages['package_id']) ? $get_packages['package_id'] : DEFAULT_PACKAGE_ID;
        } else {
            $defaultCase = true;
            $error_msg = isset($get_packages['message']) ? $get_packages['message'] : '';
            $selectedPackage = DEFAULT_PACKAGE_ID;
        }
    }

    if (count($productsQtyShipmentLevel) > 0) {
        foreach ($productsQtyShipmentLevel as $key => $urlData) {
            $QueryForNotFoundPackage .= '&product[' . $key . ']=' . $urlData['product_id'];
            $QueryForNotFoundPackage .= '&qty[' . $key . ']=' . $urlData['qty'];
            $QueryForNotFoundPackage .= '&level[' . $key . ']=' . $urlData['level'];
        }
    }





    /*
    foreach ($orderItem as $item_id => $productDetail) {

        if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {

            $product_id = $productDetail['product_id'];
            if ($productDetail['type'] == 'composite') {
                if (isset($productDetail['shipment']) && $productDetail['shipment'] == 2) {
                    $shipmentLevel[$item_id] = 1;
                } else {
                    $shipmentLevel[$item_id] = 0;
                }
            }

            if (isset($productsWithQty[$product_id])) {
                $productsWithQty[$product_id] = $productsWithQty[$product_id] + $productDetail['qty'];
            } else {
                $productsWithQty[$product_id] = $productDetail['qty'];
            }
        }
    }

    $findShipmentLevel = 1;
    $secondShipmentCase = false;
    if (in_array(1, $shipmentLevel)) {
        $findShipmentLevel = 2;
        $secondShipmentCase = true;
    }
    if (in_array(0, $shipmentLevel)) {
        if ($secondShipmentCase) {
            $findShipmentLevel = 3;
        } else {
            $findShipmentLevel = 1;
        }
    }

    $selectedPackage = 0;
    $defaultCase = false;
    $error_msg = '';
    if (count($productsWithQty) > 0) {
        $get_packages = $MbtPackaging->get_package_ids_for_basket($productsWithQty, $findShipmentLevel);

        if ($get_packages['status'] == 1) {
            $selectedPackage = isset($get_packages['package_id']) ? $get_packages['package_id'] : DEFAULT_PACKAGE_ID;
        } else {
            $defaultCase = true;
            $error_msg = isset($get_packages['message']) ? $get_packages['message'] : '';
            $selectedPackage = DEFAULT_PACKAGE_ID;
        }
    }
*/


    $package_options = '<option value="0">Select Package</option>';
    if ($get_all_packages) {
        foreach ($get_all_packages as $key => $package) {
            $mark = '';
            if ($package->id == $selectedPackage) {
                $mark = 'selected=""';
            }
            $package_options .= '<option  value="' . $package->id . '" ' . $mark . '>' . $package->name . '</option>';
        }
    }

    $packageCreateUrl = $QueryForNotFoundPackage;

    if (isset($get_packages['combinations'])) {
    ?>
        <button class="btn" type="button" onClick="load_packages()" aria-label="Load All Saved Cobmination Package" title="Load All Saved Cobmination Package">
            <span class="dashicons dashicons-image-rotate"></span> View All Found Combination
        </button>
        <?php
    } else {
        echo '<label class="plan-head">Package Plan</label><select name="shipment_package_id" class="shipment_package_id">' . $package_options . '</select>';
        echo '<button class="reload-btn" type="button" onClick="load_packages()" aria-label="Reload Package" title="Reload Package"><span class="dashicons dashicons-image-rotate"></span></button>';
       
        if ($get_packages['status'] == 0 && strpos($error_msg, "out of stock") !== false) {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'WARNING! ',
                    html: '<?php echo $error_msg; ?>'
                });
            </script>
            <?php
        } else {
           if ($defaultCase) {
            ?>
                <script>
                    addPackageGroup('<?php echo $QueryForNotFoundPackage; ?>', true);
                </script>
    <?php
            }
        }
    }
    // echo $combinationHtml;
    ?>

    <script>
        <?php if (isset($get_packages['combinations'])) { ?>
            jQuery("body").find('#smile_brillaint_order_modal2 .modal-content').removeClass('ims_manage create history check-in package_combination');
            jQuery("body").find('#smile_brillaint_order_modal2 .modal-content').addClass('package_combination');
            jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_load_html());
            smile_brillaint_order_modal2.style.display = "block";
            jQuery('body').find('#smile_brillaint_order_popup_response2').html('<?php echo $combinationHtml; ?>');
        <?php } ?>
        jQuery('#shipping_metabox_form #shipment_response').empty();
        jQuery(".shipment_package_id").select2({
            placeholder: "Please select package.",
            allowClear: true,
            width: '100%'
        });
    </script>
    <?php
    die;
}

/**
 * AJAX callback function for generating order packages.
 *
 * @wp-hook wp_ajax_generate_order_package
 *
 * @global $MbtPackaging
 *
 * @return void Outputs JSON-encoded response.
 */
function generate_order_package_callback_backupPreVersion()
{
    global $MbtPackaging;

    $orderItem = $_REQUEST['orderItem'];
    $order_id = $_REQUEST['order_id'];

    $productsWithQty = array();
    $QueryForNotFoundPackage = 'p=1';

    $shipmentLevel = array();

    $productsQtyShipmentLevel = array();
    foreach ($orderItem as $item_id => $productDetail) {
        if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
            $product_id = $productDetail['product_id'];
            $qty = $productDetail['qty'];
            $level = 1;
            if ($productDetail['type'] == 'composite') {
                $level = $productDetail['shipment'];
            }
            $data = array(
                'product_id' => $product_id,
                'qty' => $qty,
                'level' => $level
            );

            $existingKey = multi_array_search($productsQtyShipmentLevel, array('product_id' => $product_id, 'level' => $level));
            if (count($existingKey) > 0) {
                $productsQtyShipmentLevel[$existingKey[0]]['qty'] = $productsQtyShipmentLevel[$existingKey[0]]['qty'] + $qty;
            } else {
                $productsQtyShipmentLevel[] = $data;
            }
        }
    }
    $selectedPackage = 0;
    $defaultCase = false;
    $error_msg = '';

    if (count($productsQtyShipmentLevel) > 0) {
        $get_packages = $MbtPackaging->get_package_ids_for_basket($productsQtyShipmentLevel);

        if ($get_packages['status'] == 1) {
            $selectedPackage = isset($get_packages['package_id']) ? $get_packages['package_id'] : DEFAULT_PACKAGE_ID;
        } else {
            $defaultCase = true;
            $error_msg = isset($get_packages['message']) ? $get_packages['message'] : '';
            $selectedPackage = DEFAULT_PACKAGE_ID;
        }
    }

    if (count($productsQtyShipmentLevel) > 0) {
        foreach ($productsQtyShipmentLevel as $key => $urlData) {
            $QueryForNotFoundPackage .= '&product[' . $key . ']=' . $urlData['product_id'];
            $QueryForNotFoundPackage .= '&qty[' . $key . ']=' . $urlData['qty'];
            $QueryForNotFoundPackage .= '&level[' . $key . ']=' . $urlData['level'];
        }
    }





    /*
    foreach ($orderItem as $item_id => $productDetail) {

        if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {

            $product_id = $productDetail['product_id'];
            if ($productDetail['type'] == 'composite') {
                if (isset($productDetail['shipment']) && $productDetail['shipment'] == 2) {
                    $shipmentLevel[$item_id] = 1;
                } else {
                    $shipmentLevel[$item_id] = 0;
                }
            }

            if (isset($productsWithQty[$product_id])) {
                $productsWithQty[$product_id] = $productsWithQty[$product_id] + $productDetail['qty'];
            } else {
                $productsWithQty[$product_id] = $productDetail['qty'];
            }
        }
    }

    $findShipmentLevel = 1;
    $secondShipmentCase = false;
    if (in_array(1, $shipmentLevel)) {
        $findShipmentLevel = 2;
        $secondShipmentCase = true;
    }
    if (in_array(0, $shipmentLevel)) {
        if ($secondShipmentCase) {
            $findShipmentLevel = 3;
        } else {
            $findShipmentLevel = 1;
        }
    }

    $selectedPackage = 0;
    $defaultCase = false;
    $error_msg = '';
    if (count($productsWithQty) > 0) {
        $get_packages = $MbtPackaging->get_package_ids_for_basket($productsWithQty, $findShipmentLevel);

        if ($get_packages['status'] == 1) {
            $selectedPackage = isset($get_packages['package_id']) ? $get_packages['package_id'] : DEFAULT_PACKAGE_ID;
        } else {
            $defaultCase = true;
            $error_msg = isset($get_packages['message']) ? $get_packages['message'] : '';
            $selectedPackage = DEFAULT_PACKAGE_ID;
        }
    }
*/

    $get_all_packages = $MbtPackaging->get_all_packages();
    $package_options = '<option value="0">Select Package</option>';
    if ($get_all_packages) {
        foreach ($get_all_packages as $key => $package) {
            $mark = '';
            if ($package->id == $selectedPackage) {
                $mark = 'selected=""';
            }
            $package_options .= '<option  value="' . $package->id . '" ' . $mark . '>' . $package->name . '</option>';
        }
    }

    $packageCreateUrl = $QueryForNotFoundPackage;

    echo '<label class="plan-head">Package Plan</label><select name="shipment_package_id" class="shipment_package_id">' . $package_options . '</select>';
    echo '<button class="reload-btn" type="button" onClick="load_packages()" aria-label="Reload Package" title="Reload Package"><span class="dashicons dashicons-image-rotate"></span></button>';
    if ($defaultCase) {
    ?>
        <script>
            addPackageGroup('<?php echo $QueryForNotFoundPackage; ?>', true);
        </script>
    <?php
    }
    ?>

    <script>
        jQuery('#shipping_metabox_form #shipment_response').empty();
        jQuery(".shipment_package_id").select2({
            placeholder: "Please select package.",
            allowClear: true,
            width: '100%'
        });
    </script>
    <?php
    die;
}

add_action('wp_ajax_generate_shipment_popup', 'generate_shipment_popup_callback');
/**
 * AJAX callback function for generating shipment popup.
 *
 * This function handles the display and submission of the shipment popup form.
 * It includes styling, form elements for shipping setup, customer shipping address,
 * and options for printing labels, package labels, and sending tracking emails.
 *
 * @wp-hook wp_ajax_generate_shipment_popup_bk
 *
 * @return void Outputs the HTML markup for the shipment popup form.
 */
function generate_shipment_popup_callback_bk()
{
    if (isset($_REQUEST['order_id'])) :
        //     mbt_addOrderStatus(428327);

        global $MbtPackaging, $wpdb;

        //     echo '<pre>';
        //    print_r(shipmentPackageList($_REQUEST['order_id']));
        //     echo '</pre>';
        //     die;
    ?>
        <style>
            #shipping_metabox_form .table .thead-dark th {
                color: #6b6b6b;
                background-color: #dfe1e2;
                border-color: #cccccc;
                width: auto;
                font-weight: normal;
                font-size: 12px;
                text-align: center;
                text-transform: uppercase;
                vertical-align: middle;
            }

            #shipping_metabox_form .table th.txt-left.col1 {
                text-align: left;
            }

            #shipping_metabox_form th.txt-left.col4 {
                /* width: 162px; */
                min-width: 112px;
            }

            #shipping_metabox_form .table .col1 {
                vertical-align: middle;
                font-size: 14px;
                line-height: 22px;
                text-align: left;
                color: #565656;
            }

            span.tracking-ship {
                font-weight: 400;
                color: #0e679c;
            }

            span.first-ship {
                display: inline-block;
                margin-right: 6px;
                min-width: 190px;
                color: #0e679c;
                border-right: 1px solid #c1c1c1;
            }

            span.shipment-id {
                display: inline;
                font-size: 13px;
                color: #585858;
                font-weight: 400;
            }

            .second-shipped {
                color: red;
                color: #761919 !important;
            }

            .second-shipped {

                color: #761919 !important;
            }

            label.plan-head {
                display: block;
                text-align: left;
                margin-bottom: 6px;
                font-size: 14px;
            }

            #btn_ship_now {
                display: inline-block;
                text-decoration: none;
                font-size: 13px;
                line-height: 2.15384615;
                min-height: 30px;
                margin: 0;
                padding: 0 10px;
                cursor: pointer;
                border-width: 1px;
                border-style: solid;
                -webkit-appearance: none;
                border-radius: 3px;
                white-space: nowrap;
                box-sizing: border-box;
                background: #007cba;
                border-color: #007cba;
                color: #fff;
                text-decoration: none;
                text-shadow: none;
                margin-top: 15px;
            }

            #shipping_metabox_form .table td,
            #shipping_metabox_form .table th {
                border-spacing: 0px;
                vertical-align: middle;
            }

            .ship-different {
                font-size: 16px;
            }

            #shipping_metabox_form table tbody tr:nth-child(even) {
                background: #7373730d;
            }

            #shipping_metabox_form .table tbody tr:last-child td {
                border-bottom: 1px solid #dee2e6;
            }

            #shipping_metabox_form table {
                margin-bottom: 20px;
                border: 1px solid #e2e2e2;
                border-spacing: 0px;

            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-control {
                display: block;
                width: 100%;
                height: calc(1.5em + .75rem + 2px);
                padding: .375rem .75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            .col,
            .col-1,
            .col-10,
            .col-11,
            .col-12,
            .col-2,
            .col-3,
            .col-4,
            .col-5,
            .col-6,
            .col-7,
            .col-8,
            .col-9,
            .col-auto,
            .col-lg,
            .col-lg-1,
            .col-lg-10,
            .col-lg-11,
            .col-lg-12,
            .col-lg-2,
            .col-lg-3,
            .col-lg-4,
            .col-lg-5,
            .col-lg-6,
            .col-lg-7,
            .col-lg-8,
            .col-lg-9,
            .col-lg-auto,
            .col-md,
            .col-md-1,
            .col-md-10,
            .col-md-11,
            .col-md-12,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-auto,
            .col-sm,
            .col-sm-1,
            .col-sm-10,
            .col-sm-11,
            .col-sm-12,
            .col-sm-2,
            .col-sm-3,
            .col-sm-4,
            .col-sm-5,
            .col-sm-6,
            .col-sm-7,
            .col-sm-8,
            .col-sm-9,
            .col-sm-auto,
            .col-xl,
            .col-xl-1,
            .col-xl-10,
            .col-xl-11,
            .col-xl-12,
            .col-xl-2,
            .col-xl-3,
            .col-xl-4,
            .col-xl-5,
            .col-xl-6,
            .col-xl-7,
            .col-xl-8,
            .col-xl-9,
            .col-xl-auto {
                position: relative;
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .flex-row {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
                margin-right: -15px;
                margin-left: -15px;

            }

            .justify-content-between {
                -ms-flex-pack: justify;
                justify-content: space-between;
            }

            .justify-content-center {
                -ms-flex-pack: center;
                justify-content: center;
            }

            .align-items-center {
                -ms-flex-align: center;
                align-items: center;
            }


            .col-sm-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%;
            }

            .col-sm-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%;
            }

            .col-sm-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }

            .col-sm-5 {
                -ms-flex: 0 0 41.666667%;
                flex: 0 0 41.666667%;
                max-width: 41.666667%;
            }

            .col-sm-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }

            .col-sm-7 {
                -ms-flex: 0 0 58.333333%;
                flex: 0 0 58.333333%;
                max-width: 58.333333%;
            }

            .col-sm-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%;
            }

            .tr-row.gray-bg {
                background: #ececec;
            }

            .tr-row.light-bg {
                background: #f7f7f7;
            }

            #smile_brillaint_order_modal {
                z-index: 123;
            }

            #smile_brillaint_order_modal .modal-content {
                background-color: #fefefe;
                padding: 20px 0;
                width: 76%;
                border-radius: 10px;
            }

            .shipmemt-header h3 {
                font-weight: normal;
                margin-left: 18px;
                font-size: 22px;
                margin-top: 0;

            }

            .tr-row {
                padding: 15px;
            }

            .th-head p {
                margin-bottom: 0;
                margin-top: 0;
                color: #a0a0a0;
            }

            .column-td p {
                font-size: 16px;
                margin-bottom: 0;
                margin-top: 0;
            }

            #smile_brillaint_order_modal .close {
                margin-right: 12px;
                border: 0px solid #ccc;
            }

            .text-right {
                text-align: right;
            }

            .shipping-now {
                max-width: 150px;
                margin-left: auto;
            }

            .qty-inner {
                padding: 6px 15px;
                min-width: 75px;
                padding-top: 0;
            }

            .shipping-now label {
                margin-bottom: 6px;
                margin-top: 0;
                color: #a0a0a0;
                display: block;
            }

            .column-th .hd-qt {
                color: #a0a0a0;
            }

            .shipiing-setup h3 {
                font-weight: normal;
                margin-left: 0px;
                font-size: 22px;
                margin-top: 18px;
                border-bottom: 1px solid #ececec;
                padding-bottom: 16px;
                margin-bottom: 10px;
            }

            select.form-control {
                max-width: 100%;
            }

            .shipiing-setup {
                padding-left: 15px;
                padding-right: 15px;
            }

            .shipiing-setup.custom-shipping-address .ready-toship {
                border-bottom: 1px solid #ececec;
                padding-bottom: 12px;
                margin-bottom: 12px;
            }

            /* The alert message box */
            .alert {
                padding: 20px;
                background-color: #f44336;
                /* Red */
                color: white;
                margin-bottom: 15px;
            }

            /* The close button */
            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }

            /* When moving the mouse over the close button */
            .closebtn:hover {
                color: black;
            }

            .buttons-footer {
                padding-left: 15px;
            }

            .select-country-mbt {}
        </style>
        <div class="popup-shipment">
            <form id="shipping_metabox_form">
                <div class="shipment-container">
                    <div class="shipmemt-header flex-row justify-content-between">
                        <h3>Create shipment</h3>
                    </div>

                    <div class="shipment-body">

                        <div class="row-body">

                            <div class="tr-body" id="mbt_shipping_Item_listing">


                                <?php
                                $order_id = $_REQUEST['order_id'];
                                $order = wc_get_order($order_id);
                                $parent_product = 0;

                                //  mbt_addOrderStatus($order_id);

                                mbt_shipment_item_data_callback($order_id);
                                ?>
                            </div>
                        </div>


                        <div class="shipiing-setup">
                            <h3>Shipping Setup</h3>
                            <div class="flex-row">
                                <div class="col-sm-6">
                                    <div class="form-group" id="package_configuration">

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Shipping Date</label>
                                        <input type="date" name="shipping_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="shipiing-setup custom-shipping-address">

                            <?php
                            $shipping_firstname = $order->get_shipping_first_name();
                            if (empty($shipping_firstname)) {
                                $shipping_firstname = $order->get_billing_first_name();
                            }

                            $shipping_lastname = $order->get_shipping_last_name();
                            if (empty($shipping_lastname)) {
                                $shipping_lastname = $order->get_billing_last_name();
                            }
                            $shipping_email = $order->get_billing_email();
                            $shipping_phone = $order->get_billing_phone();
                            $shipping_address_1 = $order->get_shipping_address_1();
                            if (empty($shipping_address_1)) {
                                $shipping_address_1 = $order->get_billing_address_1();
                            }
                            $shipping_address_2 = $order->get_shipping_address_2();
                            if (empty($shipping_address_2)) {
                                $shipping_address_2 = $order->get_billing_address_2();
                            }

                            $shipping_city = $order->get_shipping_city();
                            if (empty($shipping_city)) {
                                $shipping_city = $order->get_billing_city();
                            }

                            $shipping_state = $order->get_shipping_state();
                            if (empty($shipping_state)) {
                                $shipping_state = $order->get_billing_state();
                            }

                            $shipping_postcode = $order->get_shipping_postcode();
                            if (empty($shipping_postcode)) {
                                $shipping_postcode = $order->get_billing_postcode();
                            }

                            $shipping_county = $order->get_shipping_country();
                            if (empty($shipping_county)) {
                                $shipping_county = $order->get_billing_country();
                            }
                            ?>
                            <?php $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ' ' . $shipping_address_1 . ' ' . $shipping_address_2 . ' ' . $shipping_city . ' ' . $shipping_state . ' (' . $shipping_postcode . ') , ' . WC()->countries->countries[$shipping_county]; ?>
                            <div class="cmt-thed">
                                <h3>Customer Shipping Address</h3>

                                <div class="ready-toship">

                                    <label for="is_shipping_address_default">
                                        <input name="is_shipping_address_changed" id="is_shipping_address_default" type="radio" checked="" class="" value="old">
                                        <span class="ship-different">Default Address - <?php echo $shippingDetails; ?></span>
                                    </label>
                                    <label for="is_shipping_address_changed">
                                        <input name="is_shipping_address_changed" id="is_shipping_address_changed" type="radio" class="" value="new">
                                        <span class="ship-different">Ship to different address</span>
                                    </label>

                                </div>
                            </div>


                            <div class="form-body-ship" style="display: none" id="is_shipping_address_changed_tbody">
                                <div class="flex-row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> First Name </label>
                                            <input type="text" name="fname" class="form-control" value="<?php echo $shipping_firstname; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Last Name </label>
                                            <input type="text" name="lname" class="form-control" value="<?php echo $shipping_lastname; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" name="email" class="form-control" value="<?php echo $shipping_email; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Phone </label>
                                            <input type="number" name="phone" class="form-control" value="<?php echo $shipping_phone; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 1</label>
                                            <textarea class="form-control"><?php echo $shipping_address_1; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 2 </label>
                                            <textarea class="form-control"><?php echo $shipping_address_2; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="<?php echo $shipping_city; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="<?php echo $shipping_state; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" name="zipcode" class="form-control" value="<?php echo $shipping_postcode; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4 dddd">
                                        <div class="form-group select-country-mbt">

                                            <?php
                                            $countries_obj = new WC_Countries();
                                            $countries = $countries_obj->__get('countries');

                                            woocommerce_form_field(
                                                'country',
                                                array(
                                                    'type' => 'select',
                                                    'required' => true,
                                                    'class' => array('chzn-drop'),
                                                    'label' => __('Select a country'),
                                                    'placeholder' => __('Enter something'),
                                                    'options' => $countries
                                                ),
                                                $shipping_county
                                            );
                                            ?>
                                        </div>
                                    </div>



                                </div>

                            </div>

                            <div class="cmt-thed">
                                <label for="print_label_shipment">
                                    <input name="print_label_shipment" id="print_label_shipment" type="checkbox" checked="" class="" value="yes">
                                    <span class="print_label_shipment">Print Label</span>
                                </label>
                                <label for="package_label_shipment">
                                    <input name="package_label_shipment" id="package_label_shipment" type="checkbox" checked="" class="" value="yes">
                                    <span class="package_label_shipment">Package Label</span>
                                </label>

                                <label for="tracking_email_shipment">
                                    <input name="tracking_email" id="tracking_email_shipment" type="checkbox" checked="" class="" value="yes">
                                    <span class="tracking_email_shipment">Tracking Email</span>
                                </label>
                                <br />
                            </div>

                        </div>
                        <div class="shipiing-setup">
                            <label>Add Packaging Note</label>
                            <textarea name="packaging_order_note" rows="4" cols="100" style="width: 100%;"></textarea>
                        </div>
                    </div>
                    <div id="shipment_response">

                    </div>

                    <div class="buttons-footer">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                        <input type="hidden" name="ship_item_id" id="ship_item_id" value="" />
                        <input type="hidden" name="action" value="mbt_createShipmentWithPackages" />
                        <button type="button" order_id="<?php echo $order_id; ?>" id="btn_ship_now">Generate Shipment</button>
                    </div>
                </div>
            </form>


        </div>

        <script>
            load_packages();
        </script>

    <?php
    endif;
    die;
}

/**
 * Callback function for generating shipment IDs and handling shipping-related actions.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function generate_shipment_id_callback()
{
    global $wpdb;

    $shipping_qty = $_REQUEST['shipping_qty'];
    $order_id = $_REQUEST['order_id'];
    $shipment_id = isset($_REQUEST['shipment_id']) ? $_REQUEST['shipment_id'] : 0;
    $shipment_rate = isset($_REQUEST['shipment_rate']) ? $_REQUEST['shipment_rate'] : 0;
    if (isset($_REQUEST['shipping_date']) && $_REQUEST['shipping_date'] <> '') {
        $date = date("Y-m-d", strtotime($_REQUEST['shipping_date']));
    } else {
        $date = date("Y-m-d");
    }

    $getItemList = array();
    foreach ($shipping_qty as $item_id => $qty) {
        if ($qty) {
            $getItemList[] = $item_id;
            if (is_int($qty)) {
                addShipmentHistory($item_id, $qty, $date);
            }
        }
    }
    if (count($getItemList) > 0) {
        //mt_srand(mktime());
        $tracking_number = 0; //mt_rand();

        require_once(ABSPATH . 'vendor/autoload.php');
        $client = new \EasyPost\EasyPostClient("EZTKfa1edfb636794cf0a30a8a5e630f53b7UwjiVnQorjPo0OQmedOFZg");
        $shipment_tracking = $client->shipment->retrieve($shipment_id);

        foreach ($shipment_tracking->rates as $key => $rate) {

            if ($rate->id == $shipment_rate) {

                $get_tracking = $shipment_tracking->buy(array(
                    'rate' => $rate,
                    // 'insurance' => 100.00
                ));
                if (isset($get_tracking->tracking_code)) {
                    $tracking_number = $get_tracking->tracking_code;
                }

                break;
            }
        }
        $shipment_data = array(
            "order_id" => $order_id,
            "shipment_method" => isset($_REQUEST['method']) ? $_REQUEST['method'] : 'USPS',
            "shipment_id_easypost" => isset($_REQUEST['shipment_id']) ? $_REQUEST['shipment_id'] : 0,
            "shipment_method_carrier" => isset($_REQUEST['shipment_method_carrier']) ? $_REQUEST['shipment_method_carrier'] : '',
            "shipment_method_service" => isset($_REQUEST['shipment_method_service']) ? $_REQUEST['shipment_method_service'] : '',
            "shipment_cost" => 0,
            "shipment_label_date" => isset($_REQUEST['shipping_lable']) ? $_REQUEST['shipping_lable'] : '',
            "tracking_code" => $tracking_number,
            "shipping_information" => json_encode($_REQUEST),
            "shipping_date" => $_REQUEST['shipping_date'],
        );
        $label = $shipment_tracking->label(array("file_format" => "pdf"));
        // echo '<pre>';
        // print_r($label);
        // echo '</pre>';
        // die;
        $shipment_id = sb_create_shipment($shipment_data);
        if ($shipment_id) {
            $order = wc_get_order($order_id);

            foreach ($order->get_items() as $item_id => $item) {
                $product_id = $item->get_product_id();
                $product = $item->get_product();
                $product_visibility = $product->get_catalog_visibility();
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if (in_array($item_id, $getItemList)) {

                    $event_data = array(
                        "order_id" => $order_id,
                        "item_id" => $item_id,
                        "shipment_id" => $shipment_id,
                        "product_id" => $product_id,
                        "event_id" => 2,
                    );
                    sb_create_log($event_data);
                    //Create Log

                    $q_last = "SELECT log_id  FROM  " . SB_LOG;
                    $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND event_id = 5 AND order_id = " . $order_id;
                    $q_last .= " ORDER BY log_id DESC LIMIT 1";
                    $query_last = $wpdb->get_var($q_last);
                    if (empty($query_last)) {

                        $q_last = "SELECT id  FROM  " . SB_ORDER_TABLE;
                        $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                        $q_last .= " ORDER BY id DESC LIMIT 1";
                        $query_last = $wpdb->get_var($q_last);
                        if ($query_last) {
                            $event_data = array(
                                "order_id" => $order_id,
                                "item_id" => $item_id,
                                "product_id" => $product_id,
                                "event_id" => 3,
                            );
                            sb_create_log($event_data);
                        }
                    }
                }
            }
        }
    }
    echo 'Created..';
    die;
}

add_action('wp_ajax_create_shipment', 'create_shipping_popup_callback');
/**
 * Callback function for creating a shipping popup in WordPress.
 */
function create_shipping_popup_callback()
{

    if (isset($_REQUEST['order_id'])) :
    ?>

        <form id="shipping_metabox_form">
            <h4 class="generateshipment">Generate Shipment</h4>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th class="txt-left col1">Product Name</th>
                        <th class="txt-left col2">QTY</th>
                        <th class="txt-left statusbx col3">Shipped</th>
                        <th class="txt-left col4">Left to Ship</th>
                        <th class="txt-left col4">Shipping Now</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order_id = $_REQUEST['order_id'];
                    $order = wc_get_order($order_id);
                    $parent_product = 0;
                    foreach ($order->get_items() as $item_id => $item) {
                    }
                    ?>
                </tbody>
            </table>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th class="txt-left col1">Product Name</th>
                        <th class="txt-left col2">QTY</th>
                        <th class="txt-left statusbx col3">Shipped</th>
                        <th class="txt-left col4">Left to Ship</th>
                        <th class="txt-left col4">Shipping Now</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order_id = $_REQUEST['order_id'];
                    $order = wc_get_order($order_id);
                    $parent_product = 0;
                    foreach ($order->get_items() as $item_id => $item) {
                        $product_id = $item->get_product_id();
                        $product = $item->get_product();
                        $product_visibility = $product->get_catalog_visibility();
                        $item_quantity = $item->get_quantity(); // Get the item quantity
                        $qtyShipped = 0;
                        $getRemainingQuantity = 0;
                        $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                        if ($shippedhistory) {
                            foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                                $qtyShipped += (int) $shippedhistoryQty;
                            }
                        }
                        if ($item_quantity) {
                            $getRemainingQuantity = $item_quantity - $qtyShipped;
                        }

                        //   if ($product_visibility == 'visible') {
                        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                        $class = '';
                        if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                            $composited_item_ids = wc_cp_get_composited_order_items($composite_container_item, $order, true);
                            $class = 'composited_child_' . $parent_product;
                            echo '<tr class="' . $class . '" style="display:none;">';
                            echo '<input type="hidden"  name="product_parent_id[' . $item_id . ']"  id="parent_id_' . $item_id . '" value="' . $parent_product . '" />';
                        } else if (wc_cp_is_composite_container_order_item($item)) {
                            $parent_product = $item->get_id();
                            $class = 'composited_parent';
                            echo '<tr class="' . $class . '" data-parent-id = "' . $parent_product . '">';
                            echo '<input type="hidden"  name="product_parent_id[' . $item_id . ']"  id="parent_id_' . $item_id . '" value="yes" />';
                        } else {
                            echo '<tr>';
                            echo '<input type="hidden"  name="product_parent_id[' . $item_id . ']"  id="parent_id_' . $item_id . '" value="normal" />';
                        }
                        if ($three_way_ship_product) {
                            echo '<td class="txt-left col1" colspan="3">';
                            echo $product->get_name();
                            echo '</td>';
                            echo '<td class="txt-left col1" colspan="2">';
                            echo '<label for="shipping_qty_' . $item_id . '">';
                            echo '<input type="checkbox"  name="shipping_qty[' . $item_id . ']"  id="shipping_qty_' . $item_id . '" value="1" />';
                            echo 'Ready to Ship</label>';

                            echo '</td>';
                        } else {
                            echo '<td class="txt-left col1">' . $product->get_name() . '</td>';
                            echo '<td class="txt-left col2">' . $item_quantity . '</td>';
                            echo '<td class="txt-left col3">' . $qtyShipped . '</td>';
                            echo '<td class="txt-left col4">' . $getRemainingQuantity . '</td>';

                            if ($getRemainingQuantity) {
                                echo '<td class="txt-left col4">';
                                echo '<select name="shipping_qty[' . $item_id . ']">';
                                for ($index = 0; $index <= $getRemainingQuantity; $index++) {
                                    echo ' <option value="' . $index . '">' . $index . '</option>';
                                }
                                echo '</select>';
                                echo '</td>';
                            } else {
                                echo '<td class="txt-left col4">';
                                $qty_send = 0;
                                echo '<input type="hidden" name="shipping_qty[' . $item_id . ']"  id="" value="' . $qty_send . '" />';
                                echo '</td>';
                            }
                        }
                        echo '</tr>';

                        //   }
                    }
                    ?>
                </tbody>
            </table>

            <h2 style="font-size: 16px">Shipping Setup</h2>


            <table class="table">

                <tbody>
                    <tr id="rate_response">

                    </tr>
                    <tr>
                        <td class="txt-left " colspan="5">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <input type="hidden" name="ship_item_id" id="ship_item_id" value="" />
                            <input type="hidden" name="action" value="mbt_create_shipment" />
                            <button type="button" id="calculate_rates" style="display: none;">Calculate Rates</button>
                            <button type="button" order_id="<?php echo $order_id; ?>" id="btn_ship_now">Generate
                                Shipment</button>
                    </tr>
                    <tr>
                        <td class="txt-left ">Method <br>
                            <select name="method">
                                <option value="USPS">USPS</option>
                            </select>
                        </td>

                        <td class="txt-left">Shipping Label <br>
                            <input type="text" name="shipping_lable" />
                        </td>

                        <td class="txt-left ">Shipping Date <br>
                            <input type="date" name="shipping_date" value="<?php echo date('Y-m-d'); ?>" />
                        </td>
                        <td class="txt-left "></td>

                    </tr>

                    <tr>
                        <td class="txt-left ">Length (Inch)<br>
                            <input type="text" name="length" value="5.2" />
                        </td>
                        <td class="txt-left ">Width (Inch)<br>
                            <input type="text" name="width" value="1.9" />
                        </td>
                        <td class="txt-left ">Height (Inch)<br>
                            <input type="text" name="height" value="2" />
                        </td>
                        <td class="txt-left ">Weight (ounces)<br>
                            <input type="text" name="weight" value="2.9" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <td class="txt-left " colspan="5">
                            <h5>Customer Shipping Address</h5>
                            <label for="is_shipping_address_changed">
                                <input name="is_shipping_address_changed" id="is_shipping_address_changed" type="checkbox" class="" value="1">
                                Ship to different address
                            </label>
                        </td>
                    </tr>
                </thead>
                <tbody style="display: none" id="is_shipping_address_changed_tbody">


                    <tr>
                        <td class="txt-left " colspan="1">First Name<br>
                            <input type="text" name="fname" style="width: 100%;" value="<?php echo $order->get_billing_first_name(); ?>" />
                        </td>
                        <td class="txt-left " colspan="1">Last Name<br>
                            <input type="text" name="lname" style="width: 100%;" value="<?php echo $order->get_billing_last_name(); ?>" />
                        </td>
                        <td class="txt-left " colspan="1">Address line 1<br>
                            <input type="text" name="address1" style="width: 100%;" value="<?php echo $order->get_billing_address_1(); ?>" />
                        </td>

                        <td class="txt-left " colspan="1">Address line 2<br>
                            <input type="text" name="address2" style="width: 100%;" value="<?php echo $order->get_billing_address_2(); ?>" />
                        </td>
                        <td class="txt-left ">Email Shipment Confirmation <br>
                            <input type="text" name="email" value="<?php echo $order->get_billing_email(); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td class="txt-left ">Phone<br>
                            <input type="text" name="phone" value="<?php echo $order->get_billing_phone(); ?>" />
                        </td>
                        <td class="txt-left ">City<br>
                            <input type="text" name="city" value="<?php echo $order->get_billing_city(); ?>" />
                        </td>

                        <td class="txt-left ">Zip Code<br>
                            <input type="text" name="zipcode" value="<?php echo $order->get_billing_postcode(); ?>" />
                        </td>
                        <td class="txt-left ">State Code<br>
                            <input type="text" name="state" value="<?php echo $order->get_billing_state(); ?>" />
                        </td>
                        <td class="txt-left ">
                            <?php
                            $countries_obj = new WC_Countries();
                            $countries = $countries_obj->__get('countries');

                            woocommerce_form_field(
                                'country',
                                array(
                                    'type' => 'select',
                                    'required' => true,
                                    'class' => array('chzn-drop'),
                                    'label' => __('Select a country'),
                                    'placeholder' => __('Enter something'),
                                    'options' => $countries
                                ),
                                $order->get_billing_country()
                            );
                            ?>
                        </td>

                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <td class="txt-left " colspan="5">
                            <h5>Add Shipping Note</h5>
                            <textarea name="order_note" rows="4" cols="100" style="width: 100%;"><?php echo $order->get_customer_note(); ?></textarea>
                        </td>
                    </tr>

                </tfoot>
            </table>
        </form>
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery('body').on('click', 'input:radio[name="shipment_rate"]', function() {
                jQuery('body').find('#btn_ship_now').show();
            });
            var check_shipment_rate = true;
            jQuery('body').on('click', '#calculate_rates', function() {
                if (check_shipment_rate) {

                    jQuery('body').find('#btn_ship_now').hide();
                    check_shipment_rate = false;
                    jQuery('#shipping_metabox_form').block({
                        message: 'Please wait. Request processing...',
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    //jQuery('body').find('#rate_response').html('<td class="txt-left "colspan="5">Processing...</td>');

                    var elementT = document.getElementById("shipping_metabox_form");
                    var formdata = new FormData(elementT);
                    //   formdata.set('action', 'mbt_create_shipment');
                    console.log(elementT);
                    //  return false;
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: formdata,
                        async: true,
                        method: 'POST',
                        success: function(response) {
                            check_shipment_rate = true;
                            jQuery('#shipping_metabox_form').unblock();
                            jQuery('body').find('#rate_response').html('<td class="txt-left "colspan="5">' +
                                response + '</td>');
                            //jQuery('body').find('#shipping_metabox_form input:hidden[name="action"]').val('generate_shipment_id');
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }

            });
            var count_shipment = true;
            jQuery('body').on('click', '#btn_ship_now', function() {
                //  jQuery('body').find('#shipping_metabox_form input:hidden[name="action"]').val('generate_shipment_id');
                var order_id = jQuery(this).attr('order_id');
                if (count_shipment) {
                    jQuery('#shipping_metabox_form').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });

                    count_shipment = false;
                    var elementT = document.getElementById("shipping_metabox_form");
                    /// formdata.set('action', 'generate_shipment_id');
                    console.log(elementT);
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        success: function(response) {
                            jQuery('#shipping_metabox_form').unblock();
                            reload_order_item_table_mbt(order_id);

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });
        </script>

<?php
    endif;
    die;
}
