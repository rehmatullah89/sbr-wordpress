<?php

add_action('wp_ajax_total_number_of_orders_existing_customers_rev_sbr_report', 'total_number_of_orders_existing_customers_rev_sbr_report');
add_action('wp_ajax_total_number_of_orders_new_customers_rev_sbr_report', 'total_number_of_orders_new_customers_rev_sbr_report');
add_action('wp_ajax_total_qty_sold_sbr_report', 'total_qty_sold_sbr_report');
add_action('wp_ajax_total_qty_sold_raw_sbr_report', 'total_qty_sold_raw_sbr_report');
add_action('wp_ajax_total_item_night_guard_shipped_sbr_report', 'total_item_night_guard_shipped_sbr_report');
add_action('wp_ajax_total_item_whitening_tray_shipped_sbr_report', 'total_item_whitening_tray_shipped_sbr_report');
add_action('wp_ajax_addon_rev_sbr_report', 'addon_rev_sbr_report');

function addon_rev_sbr_report($params)
{
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
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
    $sql = "SELECT DISTINCT  WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending', 'wc-wfocu-pri-order', 'wc-partial-refunded') AND WOIM.meta_key = '_product_id' AND WOIM.meta_value IN (" . implode(',', $addon_product_list) . ")";

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
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
                $counter++;
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
        $response_array['total_orders'] = $counter;
    }
    echo json_encode($response_array);
    die();
}

function total_item_night_guard_shipped_sbr_report($params)
{
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $response_array = array();
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';



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
    //echo ' <pre>' .print_r($night_guards_product_list,true). '</pre>';




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
    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending', 'wc-wfocu-pri-order', 'wc-partial-refunded')  AND WOIM.meta_key IN('_qty','_product_id' , 'shipped' , '_sbr_stock')";
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

    //echo $sql;
    // die();
    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    $response_array = array();
    $whiteningShipped = array();
    $nightGuardShipped = array();
    $addonShipped = array();
    $rawProductsSoldQty = array();
    $eachItemSoldQty = array();
    $newStockCompositeProducts = array();

    $newStockCompositeProductsChildACF = array();
    //$order_products = array();
    $itemProduct = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                //$order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['post_status'] = $order_data['post_status'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == 'shipped') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['shipped'] = $order_data['meta_value'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == '_sbr_stock') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['_sbr_stock'][] = $order_data['meta_value'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }
        ///   echo 'Data: <pre>' .print_r($order_products,true). '</pre>';
        //die;
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
                    if (isset($productsData['_sbr_stock'])) {
                        $newStockCompositeProductsChildACF[$productsData['product_id']] =  $productsData['product_id'];
                        $newStockCompositeProducts[] = array(
                            'product_id' => $productsData['product_id'],
                            'stock' => $productsData['_sbr_stock'],
                        );
                    }
                    if (in_array($productsData['product_id'], $night_guards_product_list)) {
                        if (isset($productsData['shipped']) || in_array($productsData['post_status'], array('wc-completed', 'wc-shipped', 'wc-partial_ship'))) {
                            if (isset($nightGuardShipped[$productsData['product_id']])) {
                                $nightGuardShipped[$productsData['product_id']]['qty'] = $nightGuardShipped[$productsData['product_id']]['qty'] + $productsData['qty'];
                            } else {
                                $nightGuardShipped[$productsData['product_id']] = $productsData;
                            }
                        }
                    }
                    if (in_array($productsData['product_id'], $whitening_product_list)) {
                        if (isset($productsData['shipped']) || in_array($productsData['post_status'], array('wc-completed', 'wc-shipped', 'wc-partial_ship'))) {
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
/****************************New Inventory System (---------Start-----)********************************************************************/
    $newSystemChildProductsQty = array();
    if (count($newStockCompositeProductsChildACF) > 0) {
        $compositeData = array();
        foreach ($newStockCompositeProductsChildACF as $product_id_cp) {
            $compositeData[$product_id_cp] = get_field('composite_products', $product_id_cp);
        }
        foreach ($newStockCompositeProducts as  $cpData) {
            $cp_prd_id =  $cpData['product_id'];
            $stageShipments =  $cpData['stock'];
            $shipQty =  $cpData['qty'];
            if (isset($compositeData[$cp_prd_id])) {
                if ($compositeData[$cp_prd_id]) {
                    foreach ($compositeData[$cp_prd_id] as $composite_item) {
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];

                        if (in_array('first', $stageShipments)) {
                            if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] + $firstShipment;
                            } else {
                                $newSystemChildProductsQty[$composite_item_product_id] = $firstShipment;
                            }
                        }
                        if (in_array('second', $stageShipments)) {
                            if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] + $secondShipment;
                            } else {
                                $newSystemChildProductsQty[$composite_item_product_id] = $secondShipment;
                            }
                        }
                        if (in_array('shipped', $stageShipments)) {
                            $totalRMqTY = $firstShipment * $shipQty;
                            if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] + $totalRMqTY;
                            } else {
                                $newSystemChildProductsQty[$composite_item_product_id] = $totalRMqTY;
                            }
                        }
                    }
                }
            }
        }
    }


    $updatedRawQty = array();
    foreach ($rawProductsSoldQty as $key => $previousRawData) {
        $previousProduct_id =  $previousRawData['product_id'];
        if (isset($newSystemChildProductsQty[$previousProduct_id])) {
            $previousRawData['qty'] =  $previousRawData['qty'] + $newSystemChildProductsQty[$previousProduct_id];
        }
        $updatedRawQty[$key] = $previousRawData;
    }
/****************************End New Inventory System (---------End-----)********************************************************************/
    $response_array['nightGuard'] = sbr_report_shipped_response($nightGuardShipped);
    $response_array['whitening'] = sbr_report_shipped_response($whiteningShipped);
    $response_array['addon'] = sbr_report_shipped_response($addonShipped);
    $response_array['raw'] = sbr_report_shipped_response($rawProductsSoldQty);
    $response_array['products'] = sbr_report_shipped_response($eachItemSoldQty);
   // echo 'Data: <pre>' . print_r($rawProductsSoldQty, true) . '</pre>';
   // echo 'Data: <pre>' . print_r($updatedRawQty, true) . '</pre>';
   // echo 'Data: <pre>' . print_r($newStockCompositeProducts, true) . '</pre>';
    //die;
    echo json_encode($response_array);
    die();
}

function total_number_of_orders_existing_customers_rev_sbr_report($params)
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;

    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending', 'wc-wfocu-pri-order', 'wc-partial-refunded') AND PM.meta_key='_customer_user'";

    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= "AND P.post_date BETWEEN '$order_start_date' AND '$order_end_date'";
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
        $order_email = strtolower($order_info['meta_value']);
        if (!in_array($order_email, $userEmails)) {
            $userEmails[] = str_replace("'", '', strtolower($order_info['meta_value']));
        }
    }

    $sql2 = " SELECT meta_value FROM wp_postmeta where  meta_key='_customer_user' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
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
        $order_email = trim(strtolower($order_info['meta_value']));
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
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
                $counter++;
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
        $response_array['total_orders'] = $counter;
    }
    echo json_encode($response_array);
    die();
}

function total_number_of_orders_new_customers_rev_sbr_report($params)
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $response_array = array();
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';

    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending', 'wc-wfocu-pri-order', 'wc-partial-refunded') AND PM.meta_key='_customer_user'";

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
            $userEmails[] = str_replace("'", '', $order_info['meta_value']);
        }
    }



    //   die;
    $sql2 = " SELECT meta_value FROM wp_postmeta where  meta_key='_customer_user' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
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
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
                $counter++;
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
        $response_array['total_orders'] = $counter;
    }
    echo json_encode($response_array);
    die();
}

function sbr_report_shipped_response($data)
{
    $html = '';
    if ($data) {
        $html .= '<ul>';
        foreach ($data as $product_id => $entry) {
            $html .= '<li>';
            $html .= get_the_title($product_id) . ' ' . ' <span class="qty-cell"><span>Qty:</span> ' . $entry['qty'] . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    return $html;
}

function sbr_quote($str)
{
    return sprintf("'%s'", strtolower($str));
}

/*
function total_qty_sold_sbr_report($params) {
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $response_array = array();
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';

    // $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    $sql = "SELECT WOI.order_item_id, WOI.order_item_name  , WOIM.meta_key , WOIM.meta_value , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  post_status !='trash' AND WOIM.meta_key IN('_qty','_product_id')";
    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' . 'wc-processing')  AND WOIM.meta_key IN('_qty','_product_id')";

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
//echo ' <pre>' .print_r($order_data_results,true). '</pre>';

    $tax_query = array();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('raw'),
    );

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query
    );

    $raw_product_list = get_posts($args);
    $order_products = array();
    $productQty = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }

        if ($order_products) {
            foreach ($order_products as $items) {
                foreach ($items as $productsData) {
                    $order_item_product_id = $productsData['product_id'];
                    if (!in_array($order_item_product_id, $raw_product_list)) {
                        if (isset($productQty[$order_item_product_id])) {
                            $productQty[$order_item_product_id]['qty'] = $productQty[$order_item_product_id]['qty'] + $productsData['qty'];
                            $productQty[$order_item_product_id] = $productQty[$order_item_product_id];
                        } else {
                            $productQty[$order_item_product_id] = $productsData;
                        }
                    }
                }
            }
        }
    }

    $html = '';
    if ($productQty) {
        $html .= '<ul>';
        foreach ($productQty as $entry) {
            $html .= '<li>';
            $html .= $entry['name'] . ': ' . ' <span class="qty-cell"><span>Qty:</span> ' . $entry['qty'] . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    } else {
        echo 'no result found';
    }
    echo $html;
    die();
}


function total_item_whitening_tray_shipped_sbr_report($params) {
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $response_array = array();
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
      $order_type= isset($params['order_type']) ? $params['order_type']:'';

    $tax_query = array();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('teeth-whitening-trays'),
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

    $whitening_product_list = get_posts($args);
    // echo ' <pre>' .print_r($whitening_product_list,true). '</pre>';





    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    $sql = "SELECT WOI.order_item_id, WOI.order_item_name  , WOIM.meta_key , WOIM.meta_value , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  post_status !='trash' AND WOIM.meta_key IN('_qty','_product_id' , 'shipped')";
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

    // 
    //     die;
    $order_products = array();
    $productQty = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == 'shipped') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['shipped'] = $order_data['meta_value'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }

        if ($order_products) {
            foreach ($order_products as $items) {
                foreach ($items as $productsData) {
                    if (in_array($productsData['product_id'], $whitening_product_list)) {
                        if (isset($productsData['shipped'])) {
                            if (isset($productQty[$productsData['product_id']])) {
                                $productQty[$productsData['product_id']]['qty'] = $productQty[$productsData['product_id']]['qty'] + $productsData['qty'];
                            } else {
                                $productQty[$productsData['product_id']] = $productsData;
                            }
                        }
                    }
                }
            }
        }
    }
    $html = '';
    if ($productQty) {
        $html .= '<ul>';
        foreach ($productQty as $entry) {
            $html .= '<li>';
            $html .= $entry['name'] . ': ' . '<span class="qty-cell"> <span>Qty:</span> ' . $entry['qty'] . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    } else {
        echo 'no result found';
    }
    echo $html;
    die();
}

function total_qty_sold_raw_sbr_report($params) {
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $response_array = array();
    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';

    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where post_type='shop_order' AND  post_status !='trash' AND PM.meta_key='_billing_email'";
    $sql = "SELECT WOI.order_item_id, WOI.order_item_name  , WOIM.meta_key , WOIM.meta_value , WOI.order_id FROM sbr.wp_posts P INNER JOIN sbr.wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN sbr.wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  post_status !='trash' AND WOIM.meta_key IN('_qty','_product_id')";
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

    $tax_query = array();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('raw'),
    );

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query
    );

    $raw_product_list = get_posts($args);
    $order_products = array();
    $productQty = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['name'] = $order_data['order_item_name'];
            } else {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['qty'] = $order_data['meta_value'];
            }
        }
        if ($order_products) {
            foreach ($order_products as $items) {
                foreach ($items as $productsData) {
                    if (in_array($productsData['product_id'], $raw_product_list)) {
                        if (isset($productQty[$productsData['product_id']])) {
                            $productQty[$productsData['product_id']]['qty'] = $productQty[$productsData['product_id']]['qty'] + $productsData['qty'];
                        } else {
                            $productQty[$productsData['product_id']] = $productsData;
                        }
                    }
                }
            }
        }
    }
    $html = '';
    if ($productQty) {
        $html .= '<ul>';
        foreach ($productQty as $entry) {
            $html .= '<li>';
            $html .= $entry['name'] . ': ' . '<span class="qty-cell"><span> Qty:</span> ' . $entry['qty'] . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    } else {
        echo 'no result found';
    }
    echo $html;
    die();
}



*/
