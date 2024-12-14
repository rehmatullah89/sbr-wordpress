<?php

/*

  Template Name: update excel sheet

 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$query = new WC_Order_Query(array(
    'limit' => 2,
    'orderby' => 'date',
    'order' => 'DESC',
    'status' => array('wc-processing', 'wc-on-hold'),
        // 'return' => 'ids',
        ));
$orders_array = array();
$orders = $query->get_orders();

foreach ($orders as $order) {
    foreach ($order->get_items() as $item_id => $item) {
        $orders_array = array(
            'date' => $order->get_date_created()->format('Y-m-d h:i:s'),
            'id' => $order->get_id(),
            'order_no' => get_post_meta($order->get_id(), "order_number", true),
            'order_status' => $order->get_status(),
            'total' => $order->get_total(),
            'total_tax' => $order->get_total_tax(),
            'shipping_total' => $order->get_shipping_total(),
            'customer_id' => $order->get_customer_id(),
            'shipping' => $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() . ' ' . $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() . ' ' . $order->get_shipping_city() . ' ' . $order->get_shipping_state() . ' ' . $order->get_shipping_postcode() . ' ' . $order->get_shipping_country(),
            'billing' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' ' . $order->get_billing_address_1() . ' ' . $order->get_billing_address_2() . ' ' . $order->get_billing_city() . ' ' . $order->get_billing_state() . ' ' . $order->get_billing_postcode() . ' ' . $order->get_billing_country(),
            //'shipping'=>$shipping_address,
            'customer_email'=>$order->get_billing_email(),
            'customer_name'=>$order->get_shipping_first_name().' '. $order->get_shipping_last_name(),
            'product_id' => $item->get_product_id(),
            'product_name' => $item->get_name(),
            'product_qty' => $item->get_quantity(),
            'item_status' => get_order_item_status_mbt($item, $item_id),
                // 'items'=>$order->get_items(),
        );


        
        sbr_build_payload($orders_array);
       
        //die('Data: <pre>' .print_r($orders_array,true). '</pre>');
    }


//break;
}

//
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
