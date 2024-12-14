<?php

function total_number_of_orders_geha_rev_sbr_report_core($order_start_date, $order_end_date, $order_type)
{

    global $wpdb;

    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
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
    $_wc_cog_order_total_cost = 0;
    $existing_Array = array();

    if (count($results) > 0) {
        $counter = 0;
        foreach ($results as $res) {
            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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
        $sqlgeha_coupons = 'SELECT COUNT(post_id) as total FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id =  wp_posts.ID WHERE meta_key ="geha_coupon" AND wp_posts.post_type="shop_coupon" AND wp_posts.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
        $results2 = $wpdb->get_var($sqlgeha_coupons);

        $sqlgeha_coupons_used = 'SELECT COUNT(order_id) FROM wp_wc_order_coupon_lookup INNER JOIN wp_posts ON wp_wc_order_coupon_lookup.coupon_id = wp_posts.ID  WHERE wp_wc_order_coupon_lookup.date_created  BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '" AND wp_posts.post_content LIKE "%ge%" AND wp_posts.post_type="shop_coupon"';
        $results3 = $wpdb->get_var($sqlgeha_coupons_used);



        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
        $response_array['total_geha_coupons_geerated'] = $results2;
        $response_array['total_geha_coupons_used'] = $results3;
    }

    return $response_array;
    // echo json_encode($response_array);
    // die();
}


function total_number_of_orders_non_geha_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{
    global $wpdb;
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
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
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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

        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount, 2), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
    }
    return $response_array;
}

function total_number_of_orders_geha_exsiting_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{

    global $wpdb;
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
    $_wc_cog_order_total_cost = 0;
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
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = number_format(round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2), 2);
        $response_array['total_orders'] = number_format(round(count($removeDuplication), 2), 2);
    }
    return $response_array;
    // echo json_encode($response_array);
    // die();
}
function total_number_of_orders_rev_sbr_report_core($order_start_date, $order_end_date, $order_type)
{
    global $wpdb;
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
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
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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
        $order_s_date_week = date('Y-m-d', strtotime('-1 Week'));
        $order_s_date_month = date('Y-m-d', strtotime('-1 Month'));

        $today_rev = total_revenue_by_date_mbt($order_start_date_new, $order_end_date_new, $order_type);
        $weekly_rev = total_revenue_by_date_mbt($order_s_date_week, $order_end_date_new, $order_type);
        $monthly_rev = total_revenue_by_date_mbt($order_s_date_month, $order_end_date_new, $order_type);
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        // $response_array['_order_shipping'] = $_order_shipping;
        // $response_array['_cart_discount'] = $_cart_discount;
        // $response_array['_order_total'] = $_order_total;
        // $response_array['_order_subtotal'] = $subtotal;
        // $response_array['_order_revenue'] = calculate_revenue_mbt($subtotal, $_cart_discount);
        $response_array['_order_revenue_today'] = $today_rev;
        $response_array['_order_revenue_weekly'] = $weekly_rev;
        $response_array['_order_revenue_monthally'] = $monthly_rev;

        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
    }
    return $response_array;
}


function total_number_of_orders_geha_new_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{

    global $wpdb;
    $response_array = array();

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
    $_wc_cog_order_total_cost = 0;
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
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = count($removeDuplication);
    }
    return $response_array;
}

function calculateCurrentPrice($responseCurrent, $key, $sign = '$')
{
    $current = 0;
    if (isset($responseCurrent[$key]) && is_numeric($responseCurrent[$key]) > 0) {
        $current = $responseCurrent[$key];
    }

    $html =  number_format($current, 2) . $sign;
    return $html;
}
function calculateComparePrice($responseCompare, $key, $sign = '$')
{


    $compare = 0;
    if (isset($responseCompare[$key]) && is_numeric($responseCompare[$key]) > 0) {
        $compare = $responseCompare[$key];
    }
    $html =  number_format($compare, 2) . $sign;
    return $html;
}



function calculateUpDownCompare($responseCurrent, $responseCompare, $key, $sign = '$', $date = array())
{
    // echo '<pre>';
    // print_r($_REQUEST);
    // echo '</pre>';
    $starDate = $endDate = $cStartDate = $cEndDate = '';
    if (isset($_REQUEST['start_date'])) {
        $starDate = $_REQUEST['start_date'];
    } else {
        $starDate = $date['start_date'];
    }
    if (isset($_REQUEST['end_date'])) {
        $endDate = $_REQUEST['end_date'];
    } else {
        $endDate = $date['end_date'];
    }
    if (isset($_REQUEST['cstart_date'])) {
        $cStartDate = $_REQUEST['cstart_date'];
    } else {
        $cStartDate = $date['cstart_date'];
    }

    if (isset($_REQUEST['cend_date'])) {
        $cEndDate = $_REQUEST['cend_date'];
    } else {
        $cEndDate = $date['cend_date'];
    }

    $current = 0;
    if (isset($responseCurrent[$key]) && is_numeric($responseCurrent[$key]) > 0) {
        $current = $responseCurrent[$key];
    }
    $compare = 0;
    if (isset($responseCompare[$key]) && is_numeric($responseCompare[$key]) > 0) {
        $compare = $responseCompare[$key];
    }

    /*
    $oldFigure = $current;
    $newFigure = $compare;
    if ($current == $compare) {
        $percentChange = '0';
    } else {
        if ($current > $compare) {
            $percentChange = (1 - $current / $compare) * 100;
        } else {
            $percentChange = '-' . (1 - $current / $compare) * 100;
        }
    }
    */


    $calcalateGrowthRatio = calcalateGrowthRatio($current, $compare, $sign);
    $date_formated_start = date("M d Y", strtotime($starDate));
    $date_formated_end = date("M d Y", strtotime($endDate));

    $date_formated_start_comp = date("M d Y", strtotime($cStartDate));
    $date_formated_end_comp = date("M d Y", strtotime($cEndDate));


    $html = '';
    $html .= '<div class="calculateUpDownCompare">';
    $html .= '<div class="first">';
    $html .= '<div class="date">';
    $html .= $date_formated_start . ' - ' . $date_formated_end;
    $html .= '</div>';
    $html .= '<div class="value">';
    if ($sign != '') {
        $html .=  number_format($current, 2) . $sign;
    } else {
        $html .=  $current . $sign;
    }

    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="second">';
    $html .= '<div class="date">';
    $html .= $date_formated_start_comp . ' - ' . $date_formated_end_comp;
    $html .= '</div>';
    $html .= '<div class="value">';
    if ($sign != '') {
        $html .=  number_format($compare, 2) . $sign;
    } else {
        $html .=  $compare . $sign;
    }

    $html .= '</div>';
    $html .= '</div>';
    if ($key != '_order_shipping' && $key != '_cart_discount') {
        $html .= '<div class="result">';
        $html .= '<div class="change">';
        $html .= 'Change : ' . $calcalateGrowthRatio['%'];
        $html .= '</div>';
        $html .= '<div class="value">';
        $html .= 'Value : ' . $calcalateGrowthRatio['='];
        $html .= '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}
// Noman
function calculateDownUpCurrent($responseCurrent, $responseCompare, $key, $sign = '$')
{


    $current = 0;
    if (isset($responseCurrent[$key]) && (int)$responseCurrent[$key] > 0) {
        $current = $responseCurrent[$key];
    }
    $compare = 0;
    if (isset($responseCompare[$key]) && (int)$responseCompare[$key] > 0) {
        $compare = $responseCompare[$key];
    }
    $response = array();


    if ($sign != '') {
        $response['responsecurrent'] =  $sign . $current;
    } else {
        $response['responsecurrent'] =  $sign . $current;
    }

    $response['responsecompare'] = $sign . $compare;
    return $response;
}
function calculateDownUpCompare($responseCurrent, $responseCompare, $key, $sign = '$')
{

    $current = 0;
    if (isset($responseCurrent[$key]) && is_numeric($responseCurrent[$key]) > 0) {
        $current = $responseCurrent[$key];
    }
    $compare = 0;
    if (isset($responseCompare[$key]) && is_numeric($responseCompare[$key]) > 0) {
        $compare = $responseCompare[$key];
    }

    $calcalateGrowthRatio = calcalateGrowthRatio($current, $compare, $sign);


    $html = '';
    $html .= '<div class="calculateUpDownCompare">';
    if ($sign != '') {
        $html .=  number_format($compare, 2) . $sign;
    } else {
        $html .=  $compare . $sign;
    }
    if ($key != '_order_shipping' && $key != '_cart_discount') {
        $html .= '<div class="result">';
        $html .= '<div class="change">';
        $html .= 'Change : ' . $calcalateGrowthRatio['%'];
        $html .= '</div>';
        $html .= '<div class="value">';
        $html .= 'Value : ' . $calcalateGrowthRatio['='];
        $html .= '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}


function total_number_of_orders_existing_customers_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{

    global $wpdb;
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND PM.meta_key='_billing_email'";

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
    $_wc_cog_order_total_cost = 0;
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

        $existing_Array = array();
        $counter = 0;
        foreach ($order_data as $res) {

            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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
                $counter++;
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = number_format(round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
    }
    return $response_array;
}

function total_item_whitening_tray_shipped_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{
}

function addon_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';

    $tax_query = array();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('addon'),
        'operator' => 'IN',
    );

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query
    );

    $addon_product_list = get_posts($args);
    $sql = "SELECT DISTINCT  WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing') AND WOIM.meta_key = '_product_id' AND WOIM.meta_value IN (" . implode(',', $addon_product_list) . ")";

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
    $order_ids = $wpdb->get_col($sql);

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
    $_wc_cog_order_total_cost = 0;
    $subtotal = 0;
    $existing_Array = array();
    if ($order_ids) {
        $sql3 = " SELECT * FROM wp_postmeta where  meta_key IN ('_order_total','_order_shipping','_cart_discount' , '_wc_cog_order_total_cost') AND post_id IN (" . implode(',', $order_ids) . ") ";
        $order_data = $wpdb->get_results($sql3, 'ARRAY_A');

        $counter = 0;
        foreach ($order_data as $res) {

            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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
                $counter++;
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = number_format(round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
    }
    return $response_array;
}
function total_number_of_orders_new_customers_rev_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{
    global $wpdb;
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";

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
    $_wc_cog_order_total_cost = 0;
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

        $existing_Array = array();
        $counter = 0;
        foreach ($order_data as $res) {

            if (in_array($res['ID'], $existing_Array)) {
                continue;
            }
            if ($order_type != '') {
                $_billing_country = get_post_meta($res['ID'], '_billing_country', true);
                if ($order_type == 'local' && $_billing_country != 'US') {
                    continue;
                }
                if ($order_type == 'international' && $_billing_country == 'US') {
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
                $counter++;
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2), 2);
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2), 2);
        $response_array['_order_total'] = number_format(round($_order_total, 2), 2);
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2), 2);
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2), 2);
        $response_array['_gross_margin'] = number_format(round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2), 2);
        $response_array['total_orders'] = number_format(round($counter, 2), 2);
    }

    return $response_array;
}

function total_item_night_guard_shipped_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{

    global $wpdb;
    $tax_query = array();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('night-guards'),
        'operator' => 'IN',
    );
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('addon'),
        'operator' => 'NOT IN',
    );

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query
    );

    $night_guards_product_list = get_posts($args);





    $tax_query_whitening = array();
    $tax_query_whitening[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('teeth-whitening-trays'),
        'operator' => 'IN',
    );
    $tax_query_whitening[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('addon'),
        'operator' => 'NOT IN',
    );

    $whitening_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query_whitening
    );

    $whitening_product_list = get_posts($whitening_args);

    $addon_tax_query = array();
    $addon_tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('addon'),
        'operator' => 'IN',
    );

    $addon_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $addon_tax_query
    );

    $addon_product_list = get_posts($addon_args);

    $raw_product_query = array();
    $raw_product_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('raw'),
    );
    $raw_product_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('data-only'),
        'operator' => 'NOT IN',
    );


    $raw_product_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $raw_product_query
    );
    $raw_product_list = get_posts($raw_product_args);
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')  AND WOIM.meta_key IN('_qty','_product_id' , 'shipped')";
    // $sql .= " AND WOIM.meta_value IN (".implode(',', $night_guards_product_list).")";
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


    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    $response_array = array();
    $whiteningShipped = array();
    $nightGuardShipped = array();
    $addonShipped = array();
    $rawProductsSoldQty = array();
    $eachItemSoldQty = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                //$order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['post_status'] = $order_data['post_status'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == 'shipped') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['shipped'] = $order_data['meta_value'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }

        if ($order_products) {
            foreach ($order_products as $order_number => $items) {
                if ($order_type != '') {

                    $_billing_country = get_post_meta($order_number, '_billing_country', true);
                    if ($order_type == 'local' && $_billing_country != 'US') {
                        continue;
                    }
                    if ($order_type == 'international' && $_billing_country == 'US') {
                        continue;
                    }
                }

                foreach ($items as $productsData) {

                    if (in_array($productsData['product_id'], $night_guards_product_list)) {
                        if (isset($productsData['shipped']) || in_array($productsData['post_status'], array('wc-completed', 'wc-shipped'))) {
                            if (isset($nightGuardShipped[$productsData['product_id']])) {
                                $nightGuardShipped[$productsData['product_id']]['qty'] = $nightGuardShipped[$productsData['product_id']]['qty'] + $productsData['qty'];
                            } else {
                                $nightGuardShipped[$productsData['product_id']] = $productsData;
                            }
                        }
                    }
                    if (in_array($productsData['product_id'], $whitening_product_list)) {
                        if (isset($productsData['shipped']) || in_array($productsData['post_status'], array('wc-completed', 'wc-shipped'))) {
                            if (isset($whiteningShipped[$productsData['product_id']])) {
                                $whiteningShipped[$productsData['product_id']]['qty'] = $whiteningShipped[$productsData['product_id']]['qty'] + $productsData['qty'];
                            } else {
                                $whiteningShipped[$productsData['product_id']] = $productsData;
                            }
                        }
                    }
                    if (in_array($productsData['product_id'], $addon_product_list)) {
                        ///  if (isset($productsData['shipped']) || in_array($productsData['post_status'], array('wc-partial_ship' , 'wc-on-hold' . 'wc-processing','wc-completed', 'wc-shipped'))) {
                        if (isset($addonShipped[$productsData['product_id']])) {
                            $addonShipped[$productsData['product_id']]['qty'] = $addonShipped[$productsData['product_id']]['qty'] + $productsData['qty'];
                        } else {
                            $addonShipped[$productsData['product_id']] = $productsData;
                        }
                        //   }
                    }
                    if (in_array($productsData['product_id'], $raw_product_list)) {

                        if (isset($rawProductsSoldQty[$productsData['product_id']])) {
                            $rawProductsSoldQty[$productsData['product_id']]['qty'] = $rawProductsSoldQty[$productsData['product_id']]['qty'] + $productsData['qty'];
                        } else {
                            $rawProductsSoldQty[$productsData['product_id']] = $productsData;
                        }
                    }
                    if (!in_array($productsData['product_id'], $raw_product_list)) {
                        if (isset($eachItemSoldQty[$productsData['product_id']])) {
                            $eachItemSoldQty[$productsData['product_id']]['qty'] = $eachItemSoldQty[$productsData['product_id']]['qty'] + $productsData['qty'];
                        } else {
                            $eachItemSoldQty[$productsData['product_id']] = $productsData;
                        }
                    }
                }
            }
        }
    }

    $response_array['nightGuard'] = $nightGuardShipped;
    $response_array['whitening'] = $whiteningShipped;
    $response_array['addon'] = $addonShipped;
    $response_array['raw'] = $rawProductsSoldQty;
    $response_array['products'] = $eachItemSoldQty;

    return $response_array;
}

function sbr_report_shipped_response_core_bk($data, $compareData, $req = '', $date = array())
{

    // $Testvar = array_merge_recursive($data, $compareData);


    $compareRecord = array();
    if ($data) {
        foreach ($data as $type => $entry) {

            foreach ($entry as $product_id => $entryD) {
                $compareRecord[$type][$product_id]['v'] = $entryD['qty'];
            }
        }
    }


    if ($compareData) {
        foreach ($compareData as $type2 => $entry2) {
            foreach ($entry2 as $product_id2 => $entryD2) {
                $compareRecord[$type2][$product_id2]['c'] = $entryD2['qty'];
            }
        }
    }




    $response_array = array();
    $response_array['nightGuard'] = 'no result found';
    $response_array['whitening'] = 'no result found';
    $response_array['addon'] = 'no result found';
    $response_array['raw'] = 'no result found';
    $response_array['products'] = 'no result found';
    if ($compareRecord) {

        foreach ($compareRecord as $typeC => $entryP) {
            $html = '';
            $html .= '<ul>';
            $html .= '<li class="compareDates">';
            $html .= '<div class="Sdate">';
            $html .= $_REQUEST['start_date'] . ' - ' . $_REQUEST['end_date'];
            $html .= '</div>';
            $html .= '<div class="Cdate">';
            $html .= $_REQUEST['cstart_date'] . ' - ' . $_REQUEST['cend_date'];
            $html .= '</div>';
            $html .= '</li>';

            // echo '<pre>';
            // print_r($typeC);
            // echo '<pre>';
            // print_r($entryP);
            // die;
            if (!empty($req)) {
                $html = '';
                $html .= '<tr>';
                $html .= '<td>' . $date['start_date'] . ' - ' . $date['end_date'] . '</td>';
                $html .= '<td>' . $date['c_start_date'] . ' - ' . $date['c_end_date'] . '</td>';
                $html .= '</tr>';
            }
            foreach ($entryP as $piD => $cData) {
                $current = isset($cData['v']) ? $cData['v'] : 0;
                $compare = isset($cData['c']) ? $cData['c'] : 0;
                $calcalateGrowthRatio = calcalateGrowthRatio($current, $compare);
                if (!empty($req)) {
                    $html .= '<tr>';
                    $html .= '<td> ' . get_the_title($piD) . ' ' . $current . ' ' . $compare . '</td>';
                    $html .= '<td>' . $calcalateGrowthRatio['%'] . ' Change :' . $calcalateGrowthRatio['='] . '</td>';
                    $html .= '</tr>';
                } else {
                    $html .= '<li>';
                    $html .= '<div class="heading">';
                    $html .= get_the_title($piD);
                    $html .= '</div>';
                    $html .= '<div class="first">';
                    $html .= $current;
                    $html .= '</div>';
                    $html .= '<div class="second">';
                    $html .= $compare;
                    $html .= '</div>';

                    $html .= '<div class="calculateUpDownCompare">';
                    $html .= '<div class="result">';
                    $html .= '<div class="change">';
                    $html .= 'Change : ' . $calcalateGrowthRatio['%'];
                    $html .= '</div>';
                    $html .= '<div class="value">';
                    $html .= $calcalateGrowthRatio['='];
                    $html .= '</div>';
                    $html .= '</div>';

                    $html .= '</div>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';

            $response_array[$typeC] = $html;
        }
    }
    return $response_array;
}

function sbr_report_shipped_response_core($data, $compareData, $req = '', $date = array())
{


    // $Testvar = array_merge_recursive($data, $compareData);


    $compareRecord = array();
    if ($data) {
        foreach ($data as $type => $entry) {

            foreach ($entry as $product_id => $entryD) {
                $compareRecord[$type][$product_id]['v'] = $entryD['qty'];
            }
        }
    }


    if ($compareData) {
        foreach ($compareData as $type2 => $entry2) {
            foreach ($entry2 as $product_id2 => $entryD2) {
                $compareRecord[$type2][$product_id2]['c'] = $entryD2['qty'];
            }
        }
    }




    $response_array = array();
    $response_array['nightGuard'] = 'no result found';
    $response_array['whitening'] = 'no result found';
    $response_array['addon'] = 'no result found';
    $response_array['raw'] = 'no result found';
    $response_array['products'] = 'no result found';
    if ($compareRecord) {

        //echo '$compareRecord: <pre>' .print_r($compareRecord,true). '</pre>'; die;
        // $mainArray = array();
        foreach ($compareRecord as $typeC => $entryP) {
            $html = '';
            // $html .= '<ul>';
            // $html .= '<li class="compareDates">';
            // $html .= '<div class="Sdate">';
            // $html .= $_REQUEST['start_date'] . ' - ' . $_REQUEST['end_date'];
            // $html .= '</div>';
            // $html .= '<div class="Cdate">';
            // $html .= $_REQUEST['cstart_date'] . ' - ' . $_REQUEST['cend_date'];
            // $html .= '</div>';
            // $html .= '</li>';

            // echo '<pre>';
            // print_r($typeC);
            // echo '<pre>';
            // print_r($entryP);
            // die;
            // if(!empty($req)) {
            //     $html = '';
            //     $html .= '<tr>';
            //     // $html .= '<td>'.$date['start_date'] . ' - ' . $date['end_date'].'</td>';
            //     // $html .= '<td>'.$date['c_start_date'] . ' - ' . $date['c_end_date'].'</td>';
            //     $html .= '</tr>';
            // }
            $category_array = array();
            foreach ($entryP as $piD => $cData) {

                $current = isset($cData['v']) ? $cData['v'] : 0;
                $compare = isset($cData['c']) ? $cData['c'] : 0;
                $calcalateGrowthRatio = calcalateGrowthRatio($current, $compare);

                if (!empty($req)) {

                    // $mainArray['title'] = get_the_title($piD);
                    // $mainArray['current'] = $current;
                    // $mainArray['compare'] = $compare;
                    // $mainArray['percentage'] = $calcalateGrowthRatio['%'];
                    // $mainArray['change'] = $calcalateGrowthRatio['='];
                    $html .= '<tr>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;"> ' . get_the_title($piD) . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $current . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $compare . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ' . $calcalateGrowthRatio['color'] . '" >' . $calcalateGrowthRatio['='] . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ' . $calcalateGrowthRatio['color'] . '" >' . $calcalateGrowthRatio['%'] . '%</td>';
                    $html .= '</tr>';
                    // } else {
                    // $html .= '<li>';
                    // $html .= '<div class="heading">';
                    // $html .= get_the_title($piD);
                    // $html .= '</div>';
                    // $html .= '<div class="first">';
                    // $html .= $current;
                    // $html .= '</div>';
                    // $html .= '<div class="second">';
                    // $html .= $compare;
                    // $html .= '</div>';

                    // $html .= '<div class="calculateUpDownCompare">';
                    // $html .= '<div class="result">';
                    // $html .= '<div class="change">';
                    // $html .= 'Change : ' . $calcalateGrowthRatio['%'];
                    // $html .= '</div>';
                    // $html .= '<div class="value">';
                    // $html .= $calcalateGrowthRatio['='];
                    // $html .= '</div>';
                    // $html .= '</div>';

                    // $html .= '</div>';
                    // $html .= '</li>';
                }
            }

            // $html .= '</ul>';

            $response_array[$typeC] = $html;
        }
    }
    return $response_array;
}

// Noman
function sbr_report_product_raw_response_core($data, $compareData, $req = '', $date = array())
{
    $compareRecord = array();

    if ($data) {
        foreach ($data as $type => $entry) {
            foreach ($entry as $product_id => $entryD) {
                $current_cat_name = array();
                foreach ($entryD['cat'] as $cate) {
                    $current_cat_name[] = $cate;
                }
                $compareRecord[$type][$product_id]['cate'] = $current_cat_name;
            }
        }
        foreach ($data as $type => $entry) {

            foreach ($entry as $product_id => $entryD) {
                $compareRecord[$type][$product_id]['v'] = $entryD['qty'];
            }
        }
    }

    if ($compareData) {
        foreach ($compareData as $type2 => $entry2) {
            foreach ($entry2 as $product_id2 => $entryD2) {
                $compareRecord[$type2][$product_id2]['c'] = $entryD2['qty'];
            }
        }
    }

    $response_array = array();
    // $response_array['nightGuard'] = 'no result found';
    // $response_array['whitening'] = 'no result found';
    // $response_array['addon'] = 'no result found';
    // $response_array['raw'] = 'no result found';
    //$response_array['products'] = 'no result found';
    if ($compareRecord) {
        foreach ($compareRecord as $typeC => $entryP) {


            $html = '';

            $Productcategory = array();
            foreach ($entryP as $piD => $cData) {
                $cat = $cData['cate'];
                if (is_array($cat)) {
                    if (in_array("Addon", $cat)) {
                        unset($cData['cate']);
                        $Productcategory['addon'][$piD] = $cData;
                    } else {
                        unset($cData['cate']);
                        $Productcategory[$cat['0']][$piD] = $cData;
                    }
                }
            }
            foreach ($Productcategory as $key => $value) {
                $keyvalue =  str_replace("-", " ", $key);
                $originalkey = ucwords(strtolower($keyvalue));

                $html .= '<tr>';
                $html .= '<th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5"> ' . $originalkey . '</th>';
                $html .= '</tr>';
                foreach ($value as $pro_id => $data) {
                    $calcalateGrowthRatio = calcalateGrowthRatio($data['v'], $data['c']);
                    $get_title  = get_the_title($pro_id);
                    $title =  str_replace("-", " ", $get_title);
                    $clean_title = ucwords(strtolower($title));


                    $html .= '<tr>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;"> ' . $clean_title . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $data['v'] . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $data['c'] . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ' . $calcalateGrowthRatio['color'] . '" >' . $calcalateGrowthRatio['='] . '</td>';
                    $html .= '<td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ' . $calcalateGrowthRatio['color'] . '" >' . $calcalateGrowthRatio['%'] . '%</td>';
                    $html .= '</tr>';
                }
            }

            $response_array[$typeC] = $html;
        }
    }
    return $response_array;
}
// Noman
function total_item_product_qty_sbr_report_core($order_start_date, $order_end_date, $order_type = '')
{

    global $wpdb;

    $raw_product_query = array();
    $raw_product_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('raw'),
    );
    $raw_product_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('data-only'),
        'operator' => 'NOT IN',
    );


    $raw_product_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $raw_product_query
    );
    $raw_product_list = get_posts($raw_product_args);
    //  echo '$raw_product_args: <pre>' .print_r($raw_product_args,true). '</pre>'; die;
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM sbr.wp_posts
     P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM
     ON WOI.order_item_id= WOIM.order_item_id  where post_type='shop_order' AND
     P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')  AND WOIM.meta_key IN('_qty','_product_id' , 'shipped')";
    // $sql .= " AND WOIM.meta_value IN (".implode(',', $night_guards_product_list).")";
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
    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    $response_array = array();
    // echo '$order_data_results: <pre>' .print_r($order_data_results,true). '</pre>';
    // die;
    $eachItemSoldQty = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                //$order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['post_status'] = $order_data['post_status'];
                // $order_products[$order_data['order_id']][$order_data['order_item_id']]['cat'] = '';
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == 'shipped') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['shipped'] = $order_data['meta_value'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }
        // echo '$order_products: <pre>' .print_r($order_products,true). '</pre>';
        // die; 
        if ($order_products) {
            foreach ($order_products as $order_number => $items) {
                if ($order_type != '') {

                    $_billing_country = get_post_meta($order_number, '_billing_country', true);
                    if ($order_type == 'local' && $_billing_country != 'US') {
                        continue;
                    }
                    if ($order_type == 'international' && $_billing_country == 'US') {
                        continue;
                    }
                }

                foreach ($items as $productsData) {

                    if (!in_array($productsData['product_id'], $raw_product_list)) {
                        $categories = get_the_terms($productsData['product_id'], 'product_cat');
                        $productCat = array();
                        if ($categories) {
                            foreach ($categories as $cat) {
                                $productCat[] = $cat->name;
                            }
                        }
                        $productsData['cat'] = $productCat;
                        if (isset($eachItemSoldQty[$productsData['product_id']])) {
                            $eachItemSoldQty[$productsData['product_id']]['qty'] = $eachItemSoldQty[$productsData['product_id']]['qty'] + $productsData['qty'];
                        } else {
                            $eachItemSoldQty[$productsData['product_id']] = $productsData;
                        }
                    }
                }
            }
        }
    }

    $response_array['products'] = $eachItemSoldQty;

    //  echo 'Data: <pre>' .print_r($response_array,true). '</pre>'; die;

    return $response_array;
}



function calcalateGrowthRatio($val1, $val2, $sign = '')
{
    $value1 = str_replace(",", "", $val1);
    $value2 = str_replace(",", "", $val2);
    $array = array($value1, $value2);
    $maxvalue = max($array);
    $minvalue = min($array);
    //  echo '$maxvalue: <pre>' .print_r($maxvalue,true). '</pre>'; 
    //present value - past value/past value = growth rate
    $response = array();
    if ($value1 == $value2) {
        $response['%'] = 0;
    } else {
        // Convert strings to numeric values
        $maxvalue = floatval($maxvalue);
        $minvalue = floatval($minvalue);

        $percentChange = (($maxvalue - $minvalue) / $maxvalue) * 100;
        //$percentChange = (1 - $val1 / $val2) * 100;
        //  $percentChange = $val1 -  $val1 / $val2;
        if (is_infinite($percentChange)) {
            $response['%'] = 'N/A';
        } else {
            if ($value1 < $value2) {
                $response['%'] = number_format('-' . $percentChange, 2);
                $response['color'] = 'color:red';
            } else {
                $response['%'] = number_format($percentChange, 2);
                $response['color'] = 'color:green';
            }
        }
    }

    $subtraction =  ((float)$value1 -  (float)$value2) . $sign;
    $response['='] =  number_format(round($subtraction), 2);

    return $response;
}
