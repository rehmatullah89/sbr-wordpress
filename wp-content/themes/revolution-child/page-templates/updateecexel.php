<?php

/*

  Template Name: update excel sheet

 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$args = array(
    'limit' => -1,
    'post_type' => 'shop_order',
    'orderby' => 'meta_value', //meta_value_num
    'order' => 'DESC',
    'status' => array('completed', 'processing'),
    'date_created' => '>' . ( time() - (MINUTE_IN_SECONDS * 2000)),
    'return' => 'ids',
    'customvar' => 'somevalue'
);
$customer_orders = wc_get_orders($args);
die('Data: <pre>' .print_r($customer_orders,true). '</pre>'); 
if (count($customer_orders) > 0) {
    $mainorderArray = array();
    //$skip_ids = array(44038);
    foreach ($customer_orders as $order_id) {
        $orderData = array();
        $order_detail = wc_get_order($order_id);
        $getOrderQty = 0;
       
        //die('Data: <pre>' .print_r($order_detail->get_items(),true). '</pre>');
        foreach ($order_detail->get_items() as $item_id => $item) {
            
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order_detail)) {
                $visibilty = false;
            } else if (wc_cp_is_composite_container_order_item($item)) {
                $visibilty = true;
            } else {
                $visibilty = true;
            }


            if ($visibilty) {
              
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $getOrderQty = $getOrderQty + 1;
                $product_id = $item->get_product_id();
                $orders_array = array(
                    'date' => $order_detail->get_date_created()->format('Y-m-d h:i:s'),
                    'id' => $order_id,
                    'order_no' => get_post_meta($order_id, "order_number", true),
                    'order_status' => $order_detail->get_status(),
                    'total' => $order_detail->get_total(),
                    'total_tax' => $order_detail->get_total_tax(),
                    'shipping_total' => $order_detail->get_shipping_total(),
                    'customer_id' => $order_detail->get_customer_id(),
                    'shipping' => $order_detail->get_shipping_first_name() . ' ' . $order_detail->get_shipping_last_name() . ' ' . $order_detail->get_shipping_address_1() . ' ' . $order_detail->get_shipping_address_2() . ' ' . $order_detail->get_shipping_city() . ' ' . $order_detail->get_shipping_state() . ' ' . $order_detail->get_shipping_postcode() . ' ' . $order_detail->get_shipping_country(),
                    'billing' => $order_detail->get_billing_first_name() . ' ' . $order_detail->get_billing_last_name() . ' ' . $order_detail->get_billing_address_1() . ' ' . $order_detail->get_billing_address_2() . ' ' . $order_detail->get_billing_city() . ' ' . $order_detail->get_billing_state() . ' ' . $order_detail->get_billing_postcode() . ' ' . $order_detail->get_billing_country(),
                    //'shipping'=>$shipping_address,
                    'customer_email'=>$order_detail->get_billing_email(),
                    'customer_name'=>$order_detail->get_shipping_first_name().' '. $order_detail->get_shipping_last_name(),
                    'product_id' => $item->get_product_id(),
                    'product_name' => $item->get_name(),
                    'product_qty' => $item->get_quantity(),
                    'item_status' => get_order_item_status_mbt($item, $item_id),
                        // 'items'=>$order->get_items(),
                );


                sbr_build_payload($orders_array);
            }
          
        }
    }
}
function sbr_build_payload($payload) {
    // echo 'Data: <pre>' . print_r($payload, true) . '</pre>';
    $get_delivery_url = 'https://script.google.com/macros/s/AKfycbwuoXchMd2FnflJOfGA7dkqvEuvAVxiS3SrNAzvzhiCKcaZC-PA/exec';
    //$get_delivery_url = 'https://script.google.com/macros/s/AKfycbwuoXchMd2FnflJOfGA7dkqvEuvAVxiS3SrNAzvzhiCKcaZC-PA/exec';
    // Setup request args.
    $http_args = array(
        'method' => 'POST',
        'timeout' => MINUTE_IN_SECONDS,
        'redirection' => 0,
        'httpversion' => '1.0',
        'blocking' => true,
        'user-agent' => sprintf('WooCommerce/%s Hookshot (WordPress/%s)', WC_VERSION, $GLOBALS['wp_version']),
        'body' => trim(wp_json_encode($payload)),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'cookies' => array(),
    );
    $http_args['headers']['X-WC-Webhook-Source'] = home_url('/'); // Since 2.6.0.
    $http_args['headers']['X-WC-Webhook-Topic'] = 'Order Create';
    $http_args['headers']['X-WC-Webhook-Resource'] = 'Custom Webhook';
    $http_args['headers']['X-WC-Webhook-Event'] = 'Create Order';
    $result = wp_safe_remote_request($get_delivery_url, $http_args);

    if ($result['response']['code'] == 200) {
        echo 'data added';
        // update_post_meta($orderID, 'sheet_order_updated', 'updated');
        // update_post_meta($order_number, 'sheet_order_updated', 'updated');
    }
}
