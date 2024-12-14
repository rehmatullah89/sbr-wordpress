<?php

/*
 * Geha Orders By Date
 */

if (isset($_GET['kami_test'])) {
    $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
     
    
}
add_action('wp_ajax_total_number_of_orders_geha_rev_sbr_report', 'total_number_of_orders_geha_rev_sbr_report');
add_action('wp_ajax_total_number_of_orders_non_geha_rev_sbr_report', 'total_number_of_orders_non_geha_rev_sbr_report');
add_action('wp_ajax_total_number_of_orders_rev_sbr_report', 'total_number_of_orders_rev_sbr_report');
add_action('wp_ajax_total_number_of_orders_geha_exsiting_rev_sbr_report', 'total_number_of_orders_geha_exsiting_rev_sbr_report');
add_action('wp_ajax_total_number_of_orders_geha_new_rev_sbr_report', 'total_number_of_orders_geha_new_rev_sbr_report');


//add_action('wp_ajax_nopriv_total_number_of_orders_geha_rev_sbr_report','total_number_of_orders_geha_rev_sbr_report');
function total_number_of_orders_geha_rev_sbr_report($params = array()) {

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type= isset($params['order_type']) ? $params['order_type']:'';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= ' AND P.post_date >= "' . $order_start_date . '"';
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date =< "' . $order_end_date . '"';
    }
    $sql .= ' AND PM2.meta_key="gehaOrder" AND PM2.meta_value="yes"';
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $response_array = array();
    $response_array['_order_shipping'] = 0;
    $response_array['_cart_discount'] = 0;
    $response_array['_order_total'] = 0;
    $response_array['_order_subtotal'] = 0;
    $response_array['total_orders'] = 0;
    $response_array['_order_revenue'] = 0;
    $response_array['_gross_margin'] = 0;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $_wc_cog_order_total_cost=0;
    $existing_Array = array();
    
    if (count($results) > 0) {
        $counter = 0;
        foreach ($results as $res) {
            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if($order_type!=''){
                 $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                 if($order_type == 'local' && $_billing_country!='US'){
                     continue;
                 }
                 if($order_type == 'international' && $_billing_country=='US'){
                     continue;
                 }
            }
            if ($res['meta_key'] == '_cart_discount') {
                $_cart_discount += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += $res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += $res['meta_value'];
//                $order = wc_get_order($res['ID']);
//                $_order_subtotal += $order->get_subtotal();
               //  $existing_Array[]=$res['ID'];
                $counter++;
            }
           
        }
        
        $subtotal = round($_order_total+$_cart_discount)-$_order_shipping;
        $subtotal = round ($subtotal,2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping,2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount,2));
        $response_array['_order_total'] = number_format(round($_order_total,2));
        $response_array['_order_subtotal'] =number_format(round($subtotal,2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal,$_cart_discount),2));
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal,$_wc_cog_order_total_cost,$_cart_discount),2);
        $response_array['total_orders'] = $counter;
    }

    echo json_encode($response_array);
    die();
}

function total_number_of_orders_non_geha_rev_sbr_report($params = array()) {

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type= isset($params['order_type']) ? $params['order_type']:'';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= ' AND P.post_date >= "' . $order_start_date . '"';
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date =< "' . $order_end_date . '"';
    }

    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $response_array = array();
    $response_array['_order_shipping'] = 0;
    $response_array['_cart_discount'] = 0;
    $response_array['_order_total'] = 0;
    $response_array['_order_subtotal'] = 0;
    $response_array['total_orders'] = 0;
    $response_array['_order_revenue'] = 0;
    $response_array['_gross_margin'] = 0;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $_wc_cog_order_total_cost = 0;
    $existing_Array = array();
    if (count($results) > 0) {
        $counter = 0;

        foreach ($results as $res) {
            $geha_order = get_post_meta($res['ID'], 'gehaOrder', true);
            if ($geha_order == 'yes') {
                continue;
            }
            if($order_type!=''){
                 $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                 if($order_type == 'local' && $_billing_country!='US'){
                     continue;
                 }
                 if($order_type == 'international' && $_billing_country=='US'){
                     continue;
                 }
            }
            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if ($res['meta_key'] == '_cart_discount') {
                $_cart_discount += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += $res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += $res['meta_value'];
//                $order = wc_get_order($res['ID']);
//                $_order_subtotal += $order->get_subtotal();
                // $existing_Array[]=$res['ID'];
                $counter++;
            }
           
        }
        
        $subtotal = round($_order_total+$_cart_discount)-$_order_shipping;
        $subtotal = round ($subtotal,2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping,2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount,2));
        $response_array['_order_total'] = number_format(round($_order_total,2));
        $response_array['_order_subtotal'] =number_format(round($subtotal,2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal,$_cart_discount),2));
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal,$_wc_cog_order_total_cost,$_cart_discount),2);
        $response_array['total_orders'] = $counter;
       
    }

    echo json_encode($response_array);
    die();
}
function total_number_of_orders_geha_new_rev_sbr_report($params) {

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $response_array = array();
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';

    //  die;
    // echo '<br/>';
    /// $sql ="select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where post_type='shop_order' AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount')";
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    // $sql ="select distinct P.ID, from wp_posts as P  where post_type='shop_order' ";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= "AND P.post_date BETWEEN '$order_start_date' AND '$order_end_date '";
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        //$sql .= ' AND P.post_date >= "' . $order_start_date . '"';
        $sql .= " AND P.post_date >= '$order_start_date'";
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date =< '$order_end_date'";
        // $sql .= ' AND P.post_date =< "' . $order_end_date . '"';
    }
    //$sql .=' GROUP BY PM.meta_value HAVING COUNT(*) > 1';
    $sql .= ' AND PM2.meta_key="gehaOrder" AND PM2.meta_value="yes"';
    $order_data = $wpdb->get_results($sql, 'ARRAY_A');
    $userEmails = array();
    foreach ($order_data as $order_info) {

        $order_email = $order_info['meta_value'];
        if (!in_array($order_email, $userEmails)) {
            $userEmails[] = $order_info['meta_value'];
        }
    }



    //   die;
    $sql2 = " SELECT meta_value FROM wp_postmeta where  meta_key='_billing_email' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
    $sql2 .= 'GROUP BY meta_value HAVING COUNT(*) = 1;';

    $matchEmailsCounters = $wpdb->get_col($sql2);

    $response_array = array();
    $response_array['_order_shipping'] = 0;
    $response_array['_cart_discount'] = 0;
    $response_array['_order_total'] = 0;
    $response_array['_order_subtotal'] = 0;
    $response_array['total_orders'] = 0;
    $response_array['_order_revenue'] = 0;
    $response_array['_gross_margin'] = 0;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $_wc_cog_order_total_cost=0;
    $order_ids = array();
    foreach ($order_data as $order_info) {
        $order_email = $order_info['meta_value'];
        if (in_array($order_email, $matchEmailsCounters)) {
            if (!in_array($order_info['ID'], $order_ids)) {
                $order_ids[] = $order_info['ID'];
            }
        }
    }
    if ($order_ids) {
        $sql3 = " SELECT * FROM wp_postmeta where  meta_key IN ('_order_total','_order_shipping','_cart_discount' , '_wc_cog_order_total_cost') AND post_id IN (" . implode(',', $order_ids) . ") ";
        $order_data = $wpdb->get_results($sql3, 'ARRAY_A');

        $removeDuplication = array();
        foreach ($order_data as $res) {
            $removeDuplication[$res['post_id']][$res['meta_key']] = $res['meta_value'];
        }

        foreach ($removeDuplication as $order) {

            if (isset($order['_cart_discount']) && !empty($order['_cart_discount']) && $order['_cart_discount'] > 0) {
                $_cart_discount += $order['_cart_discount'];
            }
            if (isset($order['_order_shipping']) && !empty($order['_order_shipping']) && $order['_order_shipping'] > 0) {
                $_order_shipping += $order['_order_shipping'];
            }
            if (isset($order['_order_total']) && !empty($order['_order_total']) && $order['_order_total'] > 0) {
                $_order_total += $order['_order_total'];
            }
            if (isset($order['_wc_cog_order_total_cost']) && !empty($order['_wc_cog_order_total_cost']) && $order['_wc_cog_order_total_cost'] > 0) {
                $_wc_cog_order_total_cost += $order['_wc_cog_order_total_cost'];
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = round($_order_shipping, 2);
        $response_array['_cart_discount'] = round($_cart_discount, 2);
        $response_array['_order_total'] = round($_order_total, 2);
        $response_array['_order_subtotal'] = round($subtotal, 2);
        $response_array['_order_revenue'] = round(calculate_revenue_mbt($subtotal, $_cart_discount), 2);
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal,$_wc_cog_order_total_cost,$_cart_discount),2);
        $response_array['total_orders'] = count($removeDuplication);
    }
    echo json_encode($response_array);
    die();
}
function total_number_of_orders_geha_exsiting_rev_sbr_report($params) {

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;

    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
  
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key='_billing_email'";

    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= "AND P.post_date BETWEEN '$order_start_date' AND '$order_end_date '";
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= " AND P.post_date >= '$order_start_date'";
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date =< '$order_end_date'";
    }
    $sql .= ' AND PM2.meta_key="gehaOrder" AND PM2.meta_value="yes"';

    $order_data = $wpdb->get_results($sql, 'ARRAY_A');
    $userEmails = array();
    foreach ($order_data as $order_info) {

        $order_email = $order_info['meta_value'];
        if (!in_array($order_email, $userEmails)) {
            $userEmails[] = $order_info['meta_value'];
        }
    }


    $sql2 = " SELECT meta_value FROM wp_postmeta where  meta_key='_billing_email' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
    $sql2 .= 'GROUP BY meta_value HAVING COUNT(*) > 1;';

    $matchEmailsCounters = $wpdb->get_col($sql2);
    $response_array = array();
    $response_array['_order_shipping'] = 0;
    $response_array['_cart_discount'] = 0;
    $response_array['_order_total'] = 0;
    $response_array['_order_subtotal'] = 0;
    $response_array['total_orders'] = 0;
    $response_array['_order_revenue'] = 0;
    $response_array['_gross_margin'] = 0;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_wc_cog_order_total_cost=0;
    $_order_subtotal = 0;
    $order_ids = array();
    foreach ($order_data as $order_info) {
        $order_email = $order_info['meta_value'];
        if (in_array($order_email, $matchEmailsCounters)) {
            if (!in_array($order_info['ID'], $order_ids)) {
                $order_ids[] = $order_info['ID'];
            }
        }
    }
    if ($order_ids) {
        $sql3 = " SELECT * FROM wp_postmeta where  meta_key IN ('_order_total','_order_shipping','_cart_discount' , '_wc_cog_order_total_cost') AND post_id IN (" . implode(',', $order_ids) . ") ";
        $order_data = $wpdb->get_results($sql3, 'ARRAY_A');
        //     echo '<pre>' .print_r($order_data,true). '</pre>';

        $removeDuplication = array();
        foreach ($order_data as $res) {

            $removeDuplication[$res['post_id']][$res['meta_key']] = $res['meta_value'];
        }

        foreach ($removeDuplication as $order) {

            if (isset($order['_cart_discount']) && !empty($order['_cart_discount']) && $order['_cart_discount'] > 0) {
                $_cart_discount += $order['_cart_discount'];
            }
            if (isset($order['_order_shipping']) && !empty($order['_order_shipping']) && $order['_order_shipping'] > 0) {
                $_order_shipping += $order['_order_shipping'];
            }
            if (isset($order['_order_total']) && !empty($order['_order_total']) && $order['_order_total'] > 0) {
                $_order_total += $order['_order_total'];
            }
            if (isset($order['_wc_cog_order_total_cost']) && !empty($order['_wc_cog_order_total_cost']) && $order['_wc_cog_order_total_cost'] > 0) {
                $_wc_cog_order_total_cost += $order['_wc_cog_order_total_cost'];
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = round($_order_shipping, 2);
        $response_array['_cart_discount'] = round($_cart_discount, 2);
        $response_array['_order_total'] = round($_order_total, 2);
        $response_array['_order_subtotal'] = round($subtotal, 2);
        $response_array['_order_revenue'] = round(calculate_revenue_mbt($subtotal, $_cart_discount), 2);
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal,$_wc_cog_order_total_cost,$_cart_discount),2);
        $response_array['total_orders'] = count($removeDuplication);
    }
    echo json_encode($response_array);
    die();
}
function total_number_of_orders_rev_sbr_report($params) {
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $order_type= isset($params['order_type']) ? $params['order_type']:'';
    
//   echo $sql = "select * from wp_postmeta where meta_key = 'order_shipping' and meta_value>0 LIMIT 80000,20000";
//    $results = $wpdb->get_results($sql, 'ARRAY_A');
//    if(count($results)>0){
//        foreach($results as $res){
//            $post_id = $res['post_id'];
//            $meta_val = $res['meta_value'];
//            $already_added = get_post_meta($post_id,'_order_shipping',true);
//            if($already_added==''){
//                continue;
//            }
//            else{
//                update_post_meta($post_id,'_order_shipping',$meta_val);
//            }
//            
//        }
//    }
//    echo '<pre>';
//    print_r($results);
//    echo '</pre>';
//    die();
    
//      $sql ="SELECT post_id, meta_key,meta_id, count(*)
//FROM wp_postmeta
//WHERE meta_key = '_order_currency'
//GROUP BY post_id, meta_key
//HAVING COUNT(*) > 1 LIMIT 0,50000";
//    $results = $wpdb->get_results($sql, 'ARRAY_A');
//    if(count($results)>0){
//        foreach($results as $res){
//            $meta_id = $res['meta_id'];
//            $wpdb->delete( 'wp_postmeta', array( 'meta_id' => $meta_id ) );
//           
//            
//        }
//    }
//    
//    die();
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= ' AND P.post_date >= "' . $order_start_date . '"';
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= ' AND P.post_date =< "' . $order_end_date . '"';
    }

   echo $sql;
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    
    $response_array = array();
    $response_array['_order_shipping'] = 0;
    $response_array['_cart_discount'] = 0;
    $response_array['_order_total'] = 0;
    $response_array['_order_subtotal'] = 0;
    $response_array['total_orders'] = 0;
    $response_array['_order_revenue'] = 0;
    $response_array['_order_revenue_today'] = 0;
    $response_array['_order_revenue_weekly'] = 0;
    $response_array['_order_revenue_monthally'] = 0;
    $response_array['_gross_margin'] = 0;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $_wc_cog_order_total_cost = 0;
    $existing_Array = array();
    if (count($results) > 0) {
        $counter = 0;
        foreach ($results as $res) {
            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if($order_type!=''){
                 $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                 if($order_type == 'local' && $_billing_country!='US'){
                     continue;
                 }
                 if($order_type == 'international' && $_billing_country=='US'){
                     continue;
                 }
            }
            if ($res['meta_key'] == '_cart_discount') {
                $_cart_discount += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += $res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += $res['meta_value'];
                //$existing_Array[]=$res['ID'];
                //$order = new WC_Order($res['ID']);
                //$_order_subtotal += $order->get_subtotal();
                $counter++;
            }
            
        }
        $order_start_date_new = date('Y-m-d');
        $order_end_date_new = date('Y-m-d');
       $order_s_date_week = date('Y-m-d',strtotime('-1 Week'));
       $order_s_date_month = date('Y-m-d',strtotime('-1 Month'));
       
        $today_rev = total_revenue_by_date_mbt($order_start_date_new,$order_end_date_new,$order_type);
        $weekly_rev = total_revenue_by_date_mbt($order_s_date_week,$order_end_date_new,$order_type);
        $monthly_rev = total_revenue_by_date_mbt($order_s_date_month,$order_end_date_new,$order_type);
        $subtotal = round($_order_total+$_cart_discount)-$_order_shipping;
        $subtotal = round ($subtotal,2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping,2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount,2));
        $response_array['_order_total'] = number_format(round($_order_total,2));
        $response_array['_order_subtotal'] =number_format(round($subtotal,2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal,$_cart_discount),2));
        $response_array['_order_revenue_today'] = $today_rev;
        $response_array['_order_revenue_weekly'] = $weekly_rev;
        $response_array['_order_revenue_monthally'] = $monthly_rev;
        
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal,$_wc_cog_order_total_cost,$_cart_discount),2);
        $response_array['total_orders'] = $counter;
    }

    echo json_encode($response_array);
    die();
}
function total_revenue_by_date_mbt($order_start_date,$order_end_date,$order_type){
    
    global $wpdb;
   $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
  if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
      $sql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
    }
   
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $_wc_cog_order_total_cost = 0;
    $existing_Array = array();
    if (count($results) > 0) {
        $counter = 0;
        foreach ($results as $res) {
            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if($order_type!=''){
                 $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                 if($order_type == 'local' && $_billing_country!='US'){
                     continue;
                 }
                 if($order_type == 'international' && $_billing_country=='US'){
                     continue;
                 }
            }
            if ($res['meta_key'] == '_cart_discount') {
                $_cart_discount += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += $res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += $res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += $res['meta_value'];
                //$existing_Array[]=$res['ID'];
                //$order = new WC_Order($res['ID']);
                //$_order_subtotal += $order->get_subtotal();
                $counter++;
            }
            
        }
        $subtotal = round($_order_total+$_cart_discount)-$_order_shipping;
        $subtotal = round ($subtotal,2);
        return number_format(round(calculate_revenue_mbt($subtotal,$_cart_discount),2));
    }
}

function calculate_revenue_mbt($total_price,$total_discount){
    

 if($total_price==''){
     return 0;
 }   
 $revenue =  $total_price - $total_discount;
 if($revenue<=0){
     $revenue = 0;
 }
 return $revenue;

}
function gross_margin_mbt($subtotal,$Cost,$discount){
    $rev_mbt = $subtotal-$discount-$Cost;
   $rev_mbt2 = $subtotal-$discount;
   if($rev_mbt2<=0){
       return 0;
   }
   return $percentage_gross_margin = ($rev_mbt/$rev_mbt2)*100;
   
}