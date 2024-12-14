<?php

function num2d($number)
{
    return number_format((float) $number, 2, '.', '');
}

global $anti_fraudblacklist_emails_listing;
$anti_fraudblacklist_emails_listing = get_option('wc_settings_anti_fraudblacklist_emails');
$anti_fraudblacklist_emails_listing = explode(',', $anti_fraudblacklist_emails_listing);

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
require_once('waiting_impression_col.php');

class Orders_List_Table extends WP_List_Table
{

    public function __construct()
    {
        parent::__construct([
            'singular' => __('Order', 'sbr'),
            'plural' => __('Orders', 'sbr'),
            'ajax' => true
        ]);
    }

    public static function get_orders($per_page = 10, $page_number = 1, $count = '')
    {
        global $wpdb;
        if ($count == 'yes')
            $sql = "SELECT COUNT(DISTINCT P.ID) FROM {$wpdb->prefix}posts P";
        else
            $sql = "SELECT DISTINCT P.* FROM {$wpdb->prefix}posts P";

        $meta_query = false;
        $order_status = isset($_GET['post_status']) ? urldecode($_GET['post_status']) : '';
        $order_status_check = '';

        //Advanced Search
        if (isset($_GET['advance_search']) && $_GET['advance_search'] != '') {
            $customer_first_name = isset($_GET['customer_first_name']) ? urldecode($_GET['customer_first_name']) : '';
            $customer_last_name = isset($_GET['customer_last_name']) ? urldecode($_GET['customer_last_name']) : '';
            $customer_email_address = isset($_GET['customer_email_address']) ? urldecode($_GET['customer_email_address']) : '';
            $order_number = isset($_GET['order_number']) ? urldecode($_GET['order_number']) : '';
            $tray_number = isset($_GET['tray_number']) ? urldecode($_GET['tray_number']) : '';
            $sbr_number = isset($_GET['sbr_number']) ? urldecode($_GET['sbr_number']) : '';
            $order_start_date = isset($_GET['order_start_date']) ? urldecode($_GET['order_start_date']) : '';
            $order_end_date = isset($_GET['order_end_date']) ? urldecode($_GET['order_end_date']) : '';
            $order_status = isset($_GET['post_status']) ? urldecode($_GET['post_status']) : '';
            $product_status = isset($_REQUEST['product_status']) ? urldecode($_REQUEST['product_status']) : '';
            $product_cat = isset($_GET['product_cat']) ? urldecode($_GET['product_cat']) : '';
            $shipping_flag = isset($_GET['shipping_flag']) ? $_GET['shipping_flag'] : array();
            //subscription#RB[search-subscription_orders]
            $geha_orders = isset($_GET['geha_orders']) ? $_GET['geha_orders'] : array();
            //subscription#RB[search-subscription_orders]
            $subscription_orders = isset($_GET['subscription_orders']) ? $_GET['subscription_orders'] : array();
            $dentist_orders = isset($_GET['dentist_orders']) ? $_GET['dentist_orders'] : '';
            $suspicious_orders = isset($_GET['suspicious_orders']) ? $_GET['suspicious_orders'] : array();
            $upsell_orders = isset($_REQUEST['upsell_orders']) ? urldecode($_REQUEST['upsell_orders']) : '';
            // $exploded_Search = explode($shipping_flag);

            if (count($shipping_flag) == 1) {
                $shipping_flag = $shipping_flag[0];
            } else {
                $shipping_flag = 'all';
            }
            // Geha Orders filter
            if (count($geha_orders) == 1) {
                $geha_orders = $geha_orders[0];
            }
            if (count($subscription_orders) == 1) {
                $subscription_orders = $subscription_orders[0];
            }
            if ($dentist_orders!='') {
                $dentist_orders = $dentist_orders[0];
            }
            if (count($suspicious_orders) == 1) {
                $suspicious_orders = $suspicious_orders[0];
            }

            if ($product_cat != '') {
                $product_ids = array();
                $prod_args = array(
                    'post_type' => 'product',
                    'post_status' => 'any',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $product_cat,
                        ),
                    )
                );
                $products_filter = new WP_Query($prod_args);
                foreach ($products_filter->posts as $product) {
                    array_push($product_ids, $product->ID);
                }
                $sql .= ' INNER JOIN wp_woocommerce_order_items woi ON P.ID=woi.order_id AND woi.order_item_type="line_item" INNER JOIN wp_woocommerce_order_itemmeta woim ON woi.order_item_id=woim.order_item_id AND woim.meta_key="_product_id" AND woim.meta_value IN (' . implode(',', $product_ids) . ')';
                $meta_query = true;
            }
            if ($order_number != '') {
                $exploded = preg_split('/\r\n|\r|\n/', $order_number);
                if (is_array($exploded) && count($exploded) > 1) {
                    $resultset = "'" . implode("', '", $exploded) . "'";
                    $resultset = preg_replace('/\s+/', '', $resultset);
                    // $trayOrderId = $wpdb->get_col("SELECT order_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number IN(".$resultset." )");
                    $sql .= ' INNER JOIN wp_postmeta oldorderid  ON P.ID=oldorderid.post_id AND (oldorderid.meta_key="old_order_id" AND oldorderid.meta_value IN (' . $resultset . ') OR oldorderid.post_id IN (' . $resultset . '))';
                } else {
                    $sql .= ' INNER JOIN wp_postmeta oldorderid  ON P.ID=oldorderid.post_id AND (oldorderid.meta_key="old_order_id" AND oldorderid.meta_value=' . $order_number . ' OR oldorderid.post_id=' . $order_number . ')';
                }

                $meta_query = true;
            }
            if ($sbr_number != '') {
                $exploded = preg_split('/\r\n|\r|\n/', $sbr_number);
                if (is_array($exploded) && count($exploded) > 1) {
                    $resultset = "'" . implode("', '", $exploded) . "'";
                    $resultset = preg_replace('/\s+/', '', $resultset);
                    $sql .= ' INNER JOIN wp_postmeta sbrnumber  ON P.ID=sbrnumber.post_id AND sbrnumber.meta_key="order_number" AND sbrnumber.meta_value IN (' . $resultset . ')';
                } else {
                    $sql .= ' INNER JOIN wp_postmeta sbrnumber  ON P.ID=sbrnumber.post_id AND sbrnumber.meta_key="order_number" AND sbrnumber.meta_value="' . $sbr_number . '"';
                }
                $meta_query = true;
            }
            if ($customer_first_name != '') {
                $sql .= ' INNER JOIN wp_postmeta cmfrstname  ON P.ID=cmfrstname.post_id AND cmfrstname.meta_key="_billing_first_name" AND cmfrstname.meta_value="' . $customer_first_name . '"';
                $meta_query = true;
            }
            if ($customer_last_name != '') {
                $sql .= ' INNER JOIN wp_postmeta cmlstname  ON P.ID=cmlstname.post_id AND cmlstname.meta_key="_billing_last_name" AND cmlstname.meta_value="' . $customer_last_name . '"';
                $meta_query = true;
            }
            if ($customer_email_address != '') {
                $exploded = preg_split('/\r\n|\r|\n/', $customer_email_address);
                if (is_array($exploded) && count($exploded) > 1) {
                    $resultset = "'" . implode("', '", $exploded) . "'";
                    $resultset = preg_replace('/\s+/', '', $resultset);

                    $sql .= ' INNER JOIN wp_postmeta billingemail  ON P.ID=billingemail.post_id AND billingemail.meta_key="_billing_email" AND billingemail.meta_value IN (' . $resultset . ')';
                } else {
                    $sql .= ' INNER JOIN wp_postmeta billingemail  ON P.ID=billingemail.post_id AND billingemail.meta_key="_billing_email" AND billingemail.meta_value="' . $customer_email_address . '"';
                }

                $meta_query = true;
            }
            if ($shipping_flag != 'all') {
                if ($shipping_flag == 'international') {
                    $comparison_operator = '!=';
                } else {
                    $comparison_operator = '=';
                }
                $sql .= ' INNER JOIN wp_postmeta shippingflag  ON P.ID=shippingflag.post_id AND shippingflag.meta_key="_shipping_country" AND shippingflag.meta_value' . $comparison_operator . '"US"';
                $meta_query = true;
            }
            // geha orders filter
            if($geha_orders){
                $sql .= ' INNER JOIN wp_postmeta gehaOrder  ON P.ID=gehaOrder.post_id AND gehaOrder.meta_key="gehaOrder" AND gehaOrder.meta_value = "yes"';
                $meta_query = true;
            }
            if($subscription_orders){
                $sql .= ' INNER JOIN wp_postmeta subscOrder  ON P.ID=subscOrder.post_id AND subscOrder.meta_key="_subscriptionId" AND subscOrder.meta_value != ""';
                $meta_query = true;
            }
            if($dentist_orders){
                $sql .= ' INNER JOIN wp_postmeta dentistOrder  ON P.ID=dentistOrder.post_id AND dentistOrder.meta_key="dentistOrder" AND dentistOrder.meta_value != ""';
                $meta_query = true;
            }

            
            if($suspicious_orders){
                $sql2 = "WITH fraud_orders AS (
                    SELECT o1.ID AS order_id1, o1.post_date AS post_date1,
                        o2.ID AS order_id2, o2.post_date AS post_date2
                    FROM wp_posts o1
                    JOIN wp_posts o2 ON o1.post_type = 'shop_order' AND o2.post_type = 'shop_order'
                    WHERE o1.post_status IN ('wc-processing', 'wc-pending', 'wc-on-hold') AND o2.post_status IN ('wc-processing', 'wc-pending', 'wc-on-hold') AND o1.ID < o2.ID AND o1.post_date < o2.post_date AND o1.post_date > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND TIMESTAMPDIFF(SECOND, o1.post_date, o2.post_date) < 60  
                    ORDER BY o1.post_date DESC LIMIT 100
                )
                SELECT DISTINCT order_id
                FROM (
                    SELECT order_id1 AS order_id FROM fraud_orders
                    UNION ALL
                    SELECT order_id2 AS order_id FROM fraud_orders
                ) AS orders ORDER BY order_id";
                $qResults = implode(",",$wpdb->get_col($sql2));
                $joinQry = $qResults != ""?' AND P.ID IN ('.$qResults.')':"";
                $sql .= ' INNER JOIN wp_postmeta suspOrder  ON P.ID=suspOrder.post_id '.$joinQry;
            }

            if ($upsell_orders == 'yes') {

                $sql .= ' INNER JOIN wp_postmeta shippingflag  ON P.ID=shippingflag.post_id AND shippingflag.meta_key="_wfocu_upsell_amount" AND shippingflag.meta_value > 0 ';
                $meta_query = true;
            }


            if ($tray_number != '' && $tray_number != ' ') {

                $exploded = preg_split('/\r\n|\r|\n/', $tray_number);
                if (is_array($exploded) && count($exploded) > 1) {
                    $resultset = "'" . implode("', '", $exploded) . "'";
                    $resultset = preg_replace('/\s+/', '', $resultset);
                    $trayOrderId = $wpdb->get_col("SELECT order_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number IN(" . $resultset . " )");
                } else {
                    $trayOrderId = $wpdb->get_col("SELECT order_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $tray_number");
                }

                if ($trayOrderId) {
                } else {
                    $meta_query = true;
                    $jJosn_string = '{"trayNumber": "' . $tray_number . '"}';
                    $sql .= " INNER JOIN wp_postmeta traynumber  ON P.ID=traynumber.post_id AND traynumber.meta_key='_oldJson' AND JSON_CONTAINS(traynumber.meta_value,'$jJosn_string')";
                }
            }
            if ($order_start_date != '' && $order_end_date != '') {
                $order_start_date = $order_start_date . ' 00:00:00';
                $order_end_date = $order_end_date . ' 23:59:59';

                if ($meta_query) {
                    $sql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
                } else {
                    $sql .= ' WHERE P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
                }
                $meta_query = true;
            } else if ($order_start_date != '') {
                $order_start_date = $order_start_date . ' 00:00:00';
                if ($meta_query) {
                    $sql .= ' AND P.post_date >= "' . $order_start_date . '"';
                } else {
                    $sql .= ' WHERE P.post_date >= "' . $order_start_date . '"';
                }
                $meta_query = true;
            } else if ($order_end_date != '') {
                $order_end_date = $order_end_date . ' 23:59:59';
                if ($meta_query) {
                    $sql .= ' AND P.post_date =< "' . $order_end_date . '"';
                } else {
                    $sql .= ' WHERE P.post_date =< "' . $order_end_date . '"';
                }
                $meta_query = true;
            }
        }
        //Simple Search
        else if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
            $args = array(
                'post_type' => 'shop_order',
                'post_status' => 'any',
                'posts_per_page' => $per_page,
                'paged' => $page_number,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            if (isset($_GET['s']) && $_GET['s'] != '') {
                $post_ids = wc_order_search(wc_clean(wp_unslash($_GET['s'])));
                if (!empty($post_ids))
                    $args['post__in'] = array_merge($post_ids, array(0));
                else
                    $args['s'] = urldecode($_GET['s']);
                $query = new WP_Query($args);
            } else {
                $query = new WP_Query($args);
            }

            if ($count != 'yes') {
                $orders = $query->posts;
                $orders_arr = array();
                foreach ($orders as $order) {
                    $new_order = array();
                    $new_order['ID'] = $order->ID;
                    $new_order['post_date'] = $order->post_date;
                    $new_order['post_author'] = $order->post_auhor;
                    array_push($orders_arr, $new_order);
                }
                return $orders_arr;
            } else {
                return $query->found_posts;
            }
        }
        //Batch Printing
        else if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            $product_name = isset($_GET['product_id']) ? $_GET['product_id'] : array();

            if (is_array($product_name)) {
                //
            } else {
                if ($product_name == 'undefined') {
                    $product_name = array();
                }
            }

            $add_array = '';
            $name_check = '';
            $post_id_include = array(22222222222);
            $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : '';
            if (is_array($product_name)) {
                //
            } else {
                if ($product_name == 'undefined') {
                    $product_name = array();
                }
            }
            $relation = isset($_GET['relation']) ? $_GET['relation'] : 'or';
            $join_type = isset($_GET['join_type']) ? $_GET['join_type'] : 'AND';
            $exclude_legacy = isset($_GET['exclude_legacy']) ? $_GET['exclude_legacy'] : '';
            $exclude_addons = isset($_GET['exclude_addons']) ? $_GET['exclude_addons'] : '';
            $exclude_night_guard_reorder = isset($_GET['exclude_night_guard_reorder']) ? $_GET['exclude_night_guard_reorder'] : '';
            $exclude_extra_whitening_tray_set = isset($_GET['exclude_extra_whitening_tray_set']) ? $_GET['exclude_extra_whitening_tray_set'] : '';
            $qty_join = '';
            $qty_check = '';
            $counter = 0;
            $order_ids = array();
            if (count($product_name) > 0) {
                $break_main = false;
                foreach ($product_name as $pp) {
                    $found_orders = Orders_List_Table::batch_search_singular($pp, $product_qty[$counter]);
                    //                    if ($relation == 'and') {
                    //                        foreach ($found_orders as $oid) {
                    //                            $order = wc_get_order($oid);
                    //                            $items = $order->get_items();
                    //                            if (count($items) != count($product_name)) {
                    //                                $break_main = true;
                    //                            }
                    //                        }
                    //                    }
                    //                    if ($break_main) {
                    //                        break;
                    //                    }

                    if ($counter == 0) {
                        foreach ($found_orders as $dd) {
                            $order_ids[] = $dd;
                        }
                    } else {
                        if ($join_type == 'AND') {
                            $delitems = array();
                            foreach ($order_ids as $key => $ndd) {
                                if (!in_array($ndd, $found_orders)) {
                                    $delitems[] = $ndd;

                                    unset($order_ids[$key]);
                                }
                            }
                        } else if ($join_type == 'OR') {
                            foreach ($found_orders as $dd) {
                                if (!in_array($dd, $order_ids))
                                    $order_ids[] = $dd;
                            }
                        }
                    }
                    $counter++;
                }
                $post_id_include = $order_ids;
            } else {
                $wcstatus = 'wc-processing';

                if (isset($_GET['shipment']) && $_GET['shipment'] == 'second') {
                    $wcstatus = 'wc-partial_ship';
                }

                $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
                $Condition_three_way = ''; // "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
                $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
			WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status IN ('" . $wcstatus . "') $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
                //            $Condition_three_way = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'threeWayShipment' AND meta_value='yes'";
                //            echo $sql = "SELECT DISTINCT ID FROM wp_posts where ID NOT IN (".$Condition_three_way.") AND wp_posts.post_type='shop_order' AND wp_posts.post_status = 'wc-on-hold'";
                $results = $wpdb->get_results($sql, 'ARRAY_A');

                if (count($results) > 0) {
                    $counter = 0;
                    foreach ($results as $res) {
                        $post_id_include[] = $res['order_id'];
                    }
                }
            }
            if (empty($post_id_include)) {
                $post_id_include = array(22222222222);
            }
            $post_id_include_new = $post_id_include;
            /*
              Exclude night guard reorder
             */
            if ($exclude_night_guard_reorder == 'yes1') {

                //$exclude_night_quard_reorder_sql = "SELECT order_id FROM wp_woocommerce_order_items WHERE order_item_id IN(SELECT order_item_id FROM wp_woocommerce_order_itemmeta WHERE meta_key = '_product_id' AND meta_value='739363');";
                $exclude_night_quard_reorder_sql =  "SELECT oi.order_id
                FROM wp_woocommerce_order_items AS oi
                JOIN wp_woocommerce_order_itemmeta AS oim 
                  ON oi.order_item_id = oim.order_item_id
                  AND oim.meta_key = '_product_id'
                  AND oim.meta_value = '739363';
                ";
                $excludes_ids_night_guards_reorder = $wpdb->get_col($exclude_night_quard_reorder_sql);

                $post_id_include_new = array_diff($post_id_include_new, $excludes_ids_night_guards_reorder);
                // echo '1';
                // die();
            }
            /*
              Exclude EXTRA WHITENING TRAY SET
             */
            if ($exclude_extra_whitening_tray_set == 'yes1') {
                //$exclude_extra_whitening_tray_set_sql = "SELECT order_id FROM wp_woocommerce_order_items WHERE order_item_id IN(SELECT order_item_id FROM wp_woocommerce_order_itemmeta WHERE meta_key = '_product_id' AND meta_value='734174');";
                $exclude_extra_whitening_tray_set_sql = "SELECT oi.order_id
               FROM wp_woocommerce_order_items AS oi
               JOIN wp_woocommerce_order_itemmeta AS oim 
                 ON oi.order_item_id = oim.order_item_id
               WHERE oim.meta_key = '_product_id'
               AND oim.meta_value = '734174';";
                $excludes_ids_exclude_extra_whitening_tray_set_sql = $wpdb->get_col($exclude_extra_whitening_tray_set_sql);
                $post_id_include_new = array_diff($post_id_include_new, $excludes_ids_exclude_extra_whitening_tray_set_sql);
                // echo '2';
                // die();
            }
            if ($exclude_legacy == 'yes') {
                /*
                $exclude_old = "SELECT post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE (meta_key='old_order_id' || 'old_order_id_addon') AND wp_posts.post_status ='wc-processing'";
                $excludes_ids = $wpdb->get_col($exclude_old);
                $post_id_include_new = array_diff($post_id_include_new, $excludes_ids);
                */
            }
            if ($exclude_addons == 'yes') {
                $exclude_addons = "SELECT post_id FROM wp_postmeta WHERE (meta_key='order_type') AND meta_value ='Addon'";
                $excludes_ids_addons = $wpdb->get_col($exclude_addons);
                $post_id_include_new = array_diff($post_id_include_new, $excludes_ids_addons);
                // echo '3';
                // die();
            }
            $shipping_flag = isset($_GET['shipping_flag']) ? $_GET['shipping_flag'] : array();


            // $exploded_Search = explode($shipping_flag);
            $meta_query_args = array();
            if (count($shipping_flag) == 1) {
                $shipping_flag = $shipping_flag[0];
                if ($shipping_flag == 'domestic') {
                    $operator = '=';
                } else {
                    $operator = '!=';
                }
                $meta_query_args = array(
                    'relation' => 'AND', // Optional, defaults to "AND"
                    array(
                        'key' => '_shipping_country',
                        'value' => 'US',
                        'compare' => $operator
                    )
                );
            }
            if (isset($_REQUEST['shipment']) && $_REQUEST['shipment'] == 'second') {
                $get_pendingLab_orders = $wpdb->get_col("SELECT DISTINCT  order_id FROM  " . SB_ORDER_TABLE . " WHERE status = 16");
                // echo '5';
                // die();
                // $get_pendingLab_orders = get_orders_product_status('pending-lab');
                $post_id_include_new = array_intersect($post_id_include_new, $get_pendingLab_orders);
            }
            $args = array(
                'post_type' => 'shop_order',
                'post_status' => 'any',
                'post__in' => $post_id_include_new,
                'posts_per_page' => $per_page,
                'meta_query' => $meta_query_args,
                'date_query' => array(
                    array(
                        'after' => 'January 1st, 2023',
                        'inclusive' => true,
                    ),
                ),
                'paged' => $page_number,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $query = new WP_Query($args);
            // echo '7';
            // die();
            if ($count != 'yes') {
                $orders = $query->posts;
                $orders_arr = array();
                foreach ($orders as $order) {
                    $new_order = array();
                    $new_order['ID'] = $order->ID;
                    $new_order['post_date'] = $order->post_date;
                    $new_order['post_author'] = $order->post_auhor;
                    array_push($orders_arr, $new_order);
                }
                return $orders_arr;
            } else {
                return $query->found_posts;
            }
        }

        $order_status_check = '';
        if ($product_status != '') {
            if (isset($_REQUEST['per_page']) && $_REQUEST['per_page'] == 0) {
                $order_ids = array(22222222222);
            } else {
                $order_ids = get_orders_product_status($product_status);
            }
            if (count($order_ids) > 0) {
                $order_status_check = ' AND P.ID IN (' . implode(',', $order_ids) . ') AND P.post_status NOT IN ("trash", "draft", "auto-draft")';
            } else {
                $order_status_check = ' AND P.ID IN (555555555555555555)';
            }
        } else {
            if ($order_status != '')
                $order_status_check = ' AND P.post_status = "' . $order_status . '"';
            else
                $order_status_check = ' AND P.post_status NOT IN ("trash", "draft", "auto-draft")';
        }

        if (!empty($trayOrderId)) {
            $order_status_check .= ' AND P.ID IN (' . implode(',', $trayOrderId) . ')';
            //$order_status_check .= ' AND P.ID IN ('.$trayOrderId.')';
        }

        if ($meta_query) {
            $sql .= ' AND P.post_type="shop_order"' . $order_status_check;
        } else {
            $sql .= ' WHERE P.post_type="shop_order"' . $order_status_check;
        }

        //$sql = "SELECT * FROM {$wpdb->prefix}posts WHERE post_type='shop_order' AND post_status NOT IN ('trash', 'draft', 'auto-draft')";


        if ($count != 'yes') {
            if (!empty($_REQUEST['orderby'])) {
                $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
                $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
            } else
                $sql .= ' ORDER BY post_date DESC';

            $sql .= " LIMIT $per_page";

            $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;
        //   echo $sql;
         //     die();
            $result = $wpdb->get_results($sql, 'ARRAY_A');

            //print_r($sql);
        } else {
            $result = $wpdb->get_var($sql);
        }
        return $result;
    }

    public static function batch_search_singular($pname, $Qty)
    {
        global $wpdb;
        $wcstatus = 'wc-processing';
        if (isset($_GET['shipment']) && $_GET['shipment'] == 'second') {
            $wcstatus = 'wc-partial_ship';
        }
        $arr_ids = array(555555555555555555);
        //$product_name = html_entity_decode(get_the_title($pname));
        $product_name = str_replace("&#8211;", "-", get_the_title($pname));

        $name_check = "AND wp_woocommerce_order_items.order_item_name ='" . $product_name . "'";
        $qty_join = "INNER JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_itemmeta.order_item_id=wp_woocommerce_order_items.order_item_id";
        $qty_check = "AND wp_woocommerce_order_itemmeta.meta_key = '_qty' AND wp_woocommerce_order_itemmeta.meta_value=$Qty";
        $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
        $Condition_three_way = ''; //"AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
        $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
			WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status IN ('$wcstatus') $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";


        $results = $wpdb->get_results($sql, 'ARRAY_A');
        foreach ($results as $res) {
            $arr_ids[] = $res['order_id'];
        }
        return $arr_ids;
    }

    public function batch_search_multiple($pname, $Qty)
    {
        global $wpdb;
        $arr_ids = array();
        $product_name = get_the_title($pname);
        $name_check = "AND wp_woocommerce_order_items.order_item_name ='" . $product_name . "'";
        $qty_join = "INNER JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_itemmeta.order_item_id=wp_woocommerce_order_items.order_item_id";
        $qty_check = "AND wp_woocommerce_order_itemmeta.meta_key = '_qty' AND wp_woocommerce_order_itemmeta.meta_value=$Qty";
        $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";

        $Condition_three_way = ''; // "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
        $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
			WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status IN ('wc-processing') $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
        // die();

        $results = $wpdb->get_results($sql, 'ARRAY_A');
        foreach ($results as $res) {
            $arr_ids[] = $res['order_id'];
        }
        return $arr_ids;
    }

    public static function delete_order($id)
    {
        global $wpdb;

        $wpdb->delete("{$wpdb->prefix}posts", ['ID' => $id], ['%d']);
    }

    public static function trash_order($id)
    {
        global $wpdb;

        $wpdb->update("{$wpdb->prefix}posts", ['post_status' => 'trash'], ['ID' => $id]);
    }

    /* public static function record_count() {
      global $wpdb;

      $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE post_type='shop_order' AND post_status NOT IN ('trash', 'draft', 'auto-draft')";

      return $wpdb->get_var( $sql );
      } */

    public function no_items()
    {
        _e('No orders avaliable.', 'sbr');
    }

    /* function column_name( $item ) {

      $delete_nonce = wp_create_nonce( 'sbr_delete_order' );

      $title = '<strong>' . get_post_meta($item['ID'], 'order_number', true) . '</strong>';

      $actions = [
      'delete' => sprintf( '<a href="?page=%s&action=%s&order=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
      ];

      $buttons = '<input type="button" id="addNotes" class="button " value="Add Notes">';

      return $title . $this->row_actions( $actions ). $buttons;
      } */

    /**
     * Generates content for a single row of the table.
     *
     * @since 3.1.0
     *
     * @param object|array $item The current item
     */
    public function single_row($item)
    {
        echo '<tr id="sbr_order_' . $item['ID'] . '">';
        $this->single_row_columns($item);
        echo '</tr>';
    }

    public function column_default($item, $column_name)
    {
        global $wpdb;
        if (!isset($_POST['action'])) {
            return false;
        }
        $order_id = $item['ID'];
        $order = wc_get_order($order_id);

        $editUrl = get_admin_url() . 'post.php?post=' . $item['ID'] . '&action=edit';
        if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'waiting-impression') {


            foreach ($order->get_items() as $item_id => $item_pro) {

                $log_visible = false;
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item_pro, $order)) {
                    $log_visible = false;
                    /* Composite Prdoucts Child Items */
                } else if (wc_cp_is_composite_container_order_item($item_pro)) {

                    /* Composite Prdoucts Parent Item */
                    $log_visible = true;
                } else {
                    $log_visible = true;
                }
                if ($log_visible) {
                    $query_status = $wpdb->get_var("SELECT status FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");

                    if ($query_status == 3 || $query_status == 5 || $query_status == 7) {
                        $tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_pro, $item_pro->get_product(), 2);
                        $tray_number = isset($_REQUEST['tray_number']) ? urldecode($_REQUEST['tray_number']) : '';
                        echo get_col_waiting_on_impression($item, $column_name, $tray_html, $item_id, $item_pro, $tray_number);
                    }
                }
            }
        } else if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'pending-lab') {


            foreach ($order->get_items() as $item_id => $item_pro) {
                $log_visible = false;
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item_pro, $order)) {
                    $log_visible = false;
                    /* Composite Prdoucts Child Items */
                } else if (wc_cp_is_composite_container_order_item($item_pro)) {

                    /* Composite Prdoucts Parent Item */
                    $log_visible = true;
                } else {
                    $log_visible = true;
                }
                if ($log_visible) {
                    $query_status = $wpdb->get_var("SELECT status FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");

                    if ($query_status == 6 || $query_status == 16) {
                        $tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_pro, $item_pro->get_product(), 2);
                        $tray_number = isset($_REQUEST['tray_number']) ? urldecode($_REQUEST['tray_number']) : '';
                        echo get_col_pending_lab_work($item, $column_name, $tray_html, $item_id, $item_pro, $tray_number);
                    }
                }
            }
        } else {

            switch ($column_name) {
                case 'ordernumber':

                    if (get_post_meta($item['ID'], 'order_number', true) == '') {
                        smile_brillaint_get_sequential_order_number($item['ID']);
                    }
                    $title = '<strong><a target="_blank" href="' . $editUrl . '">' . get_post_meta($item['ID'], 'order_number', true) . '</a></strong>';
                    //$buttons = '<br>' . date('l M d, Y h:ia', strtotime($item['post_date']));
                    //$buttons = '<br>' . $item['post_date'];
                    $buttons = '<br>' . sbr_datetime($item['post_date']);

                    $threeWay = get_post_meta($item['ID'], 'threeWayShipment', true);
                    $shipOrder = '';
                    $buttons .= '<div class="OrderActionBtn">';
                    if (in_array($order->get_status(), array('processing'))) {
                        $shipOrder = '<a class="button sbr-button"  onClick="sbr_setAsShipOrder(' . $item['ID'] . ')" id="btn_setAsShipOrder_' . $item['ID'] . '" >' . iconListingOrder('setAsShip') . '<span class="tooltiptext">Print shipping label</span></a>';
                    }

                    //$buttons .= '<br><a class="button sbr-button "  href="javascript:;" onClick="loadOrderEntry('.$item['ID'].')">Reload</a>';
                    //$buttons .= '<br><a class="button sbr-button loadIframeSBROrder" data-order-url="'.$editUrl.'&iframe=yes"  data-order-id="'.$item['ID'].'"  href="javascript:;" >Reload Iframe</a>';
                    //   $buttons .= '<a class="button sbr-button" target="_blank" href="' . $editUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">Order Detail</span></a>';

                    $buttons .= '<a class="button sbr-button" target="_blank" href="' . $editUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">Order Detail</span></a>';

                    if ($order->get_status() === 'shipped') {

                        $buttons .= '<a class="button sbr-button check-mbt" onClick="sbr_setAsCompleteOrder(' . $item['ID'] . ')" id="btn_setAsCompleteOrder_' . $item['ID'] . '" href="javascript:;" ><span class="dashicons dashicons-yes"></span><span class="tooltiptext">Mark as complete</span></a>';
                    } else {
                        $buttons .= $shipOrder;
                    }
                    if ($order->get_status() === 'completed' || $order->get_status() === 'partial_ship') {
                        $rma_url = add_query_arg(
                            array(
                                'action' => 'create_addon_order_popup',
                                'order_id' => $item['ID'],
                                'warranty_claim_id' => 1,
                            ),
                            admin_url('admin-ajax.php')
                        );
                        //$rmaUrl = get_admin_url() . 'admin.php?page=warranties-new&search_key=order_id&search_term='.$item['ID'];
                        $buttons .= '<a class="button sbr-button rma-mbt rma_request"  href="javascript:;" custom-url="' . $rma_url . '" >' . iconListingOrder('return-product-1') . '</span><span class="tooltiptext">RMA</span></a>';
                    }


                    $customer_chat = add_query_arg(
                        array(
                            'action' => 'create_customer_popup',
                            'order_id' => $item['ID'],
                            'product_id' => 0,
                            //	'ticket_id' => $ticket_id,
                            'item_id' => 0,
                        ),
                        admin_url('admin-ajax.php')
                    );


                    $ticket_status = $wpdb->get_var("SELECT status FROM  " . SB_ZENDESK_TABLE . " WHERE order_id = " . $item['ID']);
                    $tool_tip_ticket = 'Create Ticket';
                    $img = 'customerSupport';
                    if ($ticket_status == 'open') {
                        $img = 'customerSupport-red';
                        $tool_tip_ticket = 'Contact Customer';
                    }
                    if ($ticket_status == 'solved') {
                        $img = 'customerSupport-green';
                        $tool_tip_ticket = 'Ticket Resolved';
                    }
                    $buttons .= '<a class="customer_chat button button-small sb_customer_chat ' . $ticket_status . '" href="javascript:;"  custom-url="' . $customer_chat . '" >' . iconListingOrder($img) . '<span class="tooltiptext">' . $tool_tip_ticket . '</span></a>';
                    if (get_current_user_id() == 2 || get_current_user_id() == 124143) {
                        $buttons .= '<a type="button" id="deleteOrder" class="button sbr-button sbr-button-order-delete"  data-order-id="' . $item['ID'] . '" title="Delete Order"><span class="dashicons dashicons-trash"></span><span class="tooltiptext">Delete Order</span></a>';
                    }
                    //   $buttons .= getUserChatForLog($customer_chat);

                    if (get_post_meta($item['ID'], 'created_good_to_ship', true) != 'yes') {
                        $keypopup = 0;
                        if (in_array($order->get_status(), array('on-hold', 'pending', 'cancelled', 'failed'))) {
                            $keypopup = 1;
                        }
                        $buttons .= '<a type="button" class="button sbr-button goodToShip"  href="javascript:;" id="btn_goodToShip_' . $item['ID'] . '"   onclick="orderGoodToShip(' . $item['ID'] . ' , ' . $keypopup . ')" data-order-id="' . $item['ID'] . '">' . iconListingOrder('readyToShip') . '<span class="tooltiptext">Good To Ship</span></a>';
                    }

                    $buttons .= '</div>';
                    $buttons .= '<div class="OrderActionTxtBtn">';

                    $addFee = add_query_arg(
                        array(
                            'action' => 'add_extra_fee',
                            'order_id' => $order_id,
                            'splitOrder' => 1,
                        ),
                        admin_url('admin-ajax.php')
                    );
                    $buttons .= '<a class="sb_analyze_impression button button-small" href="javascript:;"  custom-url="' . $addFee . '" >' . iconListingOrder('add-fee') . '<span class="tooltiptext">Charge Extra Amount</span></a>';

                    $invoiceLink = wp_nonce_url(
                        add_query_arg([
                            'wc_pip_action' => 'print',
                            'wc_pip_document' => 'invoice',
                            'order_id' => $item['ID'],
                        ], admin_url('admin.php')),
                        'wc_pip_document'
                    );
                    /*
                      $invoiceLink = add_query_arg(
                      array(
                      //  &wc_pip_action=print&wc_pip_document=invoice&order_id=711070
                      'wc_pip_action' => 'print',
                      '_wpnonce' => wp_create_nonce( 'confirm-order-action' ),
                      'wc_pip_document' => 'invoice',
                      'order_id' =>  $item['ID']
                      ), admin_url('edit.php?post_type=shop_order')
                      );
                     */
                    $has_note_class = 'post-it';
                    if (get_post_meta($item['ID'], 'has_order_note')) {
                        $has_note_class = 'post-it-red';
                    }
                    $buttons .= '<a type="button" href="' . $invoiceLink . '" target="_blank"  class="button sbr-button orderInvoicee"  data-order-id="' . $item['ID'] . '" data-action="wc_pip_print_invoice">' . iconListingOrder('invoice') . '<span class="tooltiptext">Invoice</span></a>';
                    $buttons .= '<a type="button" id="addNotes" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="0" title="Admin Note">' . iconListingOrder($has_note_class) . '<span class="tooltiptext">Admin Notes</span></a>';
                    // $buttons .= '<a type="button" id="editPersonalizedFollowup" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="1" title="Customer Notes">' . iconListingOrder('checklists') . '<span class="tooltiptext">Customer Notes</span></a>';

                    $user_id = $order->get_customer_id();
                    $addOnOrder = add_query_arg(
                        array(
                            'customer_id' => $user_id,
                            'action' => 'create_addon_order',
                            'order_type' => 'Addon',
                            'parent_order_id' => $item['ID'],
                        ),
                        admin_url('admin-ajax.php')
                    );

                    $buttons .= '<a class="addon_order button button-small sb_addon_order" href="javascript:;"  data-order-id="' . $item['ID'] . '"  custom-url="' . $addOnOrder . '">' . iconListingOrder('createAddon') . '<span class="tooltiptext">Create AddOn</span></a>';
                    if (!in_array($order->get_status(), array('completed', 'shipped'))) {
                        $easypostShip = add_query_arg(
                            array(
                                'action' => 'add_order_shipping_note',
                                'order_id' => $item['ID'],
                            ),
                            admin_url('admin-ajax.php')
                        );


                        $addedNoteClass = 'iconShippingNotes';
                        $orderPackagingNote = get_post_meta($item['ID'], '_order_packaging_note', true);
                        if ($orderPackagingNote) {
                            $orderPackagingNote = html_entity_decode($orderPackagingNote, ENT_QUOTES);
                            $addedNoteClass = 'iconShippingNotes-red';
                        }

                        $buttons .= '<a class="button button-small packagingNoteShip" source="1" custom-url="' . $easypostShip . '" note="' . $orderPackagingNote . '" href="javascript:;"  data-order-id="' . $item['ID'] . '">' . iconListingOrder($addedNoteClass) . '<span class="tooltiptext">Shipping Notes</span></a>';
                    }

                    $buttons .= '</div>';
                    $tags = '<p class="gifts-info no-flex-item">';
                    $customer_id = get_post_meta($item['ID'], '_customer_user', true);
                    if (get_user_meta($customer_id, 'insurance_lander', true)) {
                        $tags .= '<span class="listingOrderDevice">Insurance : ' . get_user_meta($customer_id, 'insurance_lander', true) . '</span>';
                    }
                    else  if (get_post_meta($item['ID'], '_subscriptionId', true) != '') { 
                        $tags .= '<span class="geha-icon flex-item-mbt" title="Subscription Order">
                        <img src="/wp-content/themes/revolution-child/assets/icons/subscription.svg" alt="Subscription Order"> 
                        <span class="order-text-mbt">Order</span></span>';
                        if (get_post_meta($item['ID'], '_shineSubcId', true) != '') {
                            update_post_meta($item['ID'], 'shineOrder', 'yes');
                            $tags .= '<span class="geha-icon flex-item-mbt">
                            <img src="/wp-content/uploads/2021/10/shine-logo-purple-300x75-1.png" alt="" > 
                            <span class="order-text-mbt">Order</span></span>';
                        }
                        elseif (get_user_meta($customer_id, 'geha_user', true) == 'yes') {
                            update_post_meta($item['ID'], 'gehaOrder', 'yes');
                            $tags .= '<span class="geha-icon flex-item-mbt">
                        <img src="/wp-content/uploads/2021/10/geha-logo-purple-300x75-1.png" alt="" > 
                        <span class="order-text-mbt">Order</span></span>';
                        }
                    }
                    
                     else {
                        if (get_user_meta($customer_id, 'geha_user', true) == 'yes') {
                            update_post_meta($item['ID'], 'gehaOrder', 'yes');
                            $tags .= '<span class="geha-icon flex-item-mbt">
                        <img src="/wp-content/uploads/2021/10/geha-logo-purple-300x75-1.png" alt="" > 
                        <span class="order-text-mbt">Order</span></span>';
                        }
                    }

                    if (get_post_meta($item['ID'], 'purchasing_as_giftset', true) == '1') {
                        $tags .= '<span class="listingGiftOrder">Gift Order</span>';
                    }
                    if (get_post_meta($item['ID'], 'dentistOrder', true) != '') {
                        $dentist_id =  get_post_meta($item['ID'], 'dentistOrder', true);
                        $tags .= '<span class="listingOrderDevice">Dentist : '.get_user_meta($dentist_id,'first_name',true).' '.get_user_meta($dentist_id,'last_name',true).'</span>';
                    }
                    $device = get_post_meta($item['ID'], 'user_device', true);
                    $hsa_hfa = get_post_meta($item['ID'], 'hfa_hsa', true);
                    if ($device != '') {
                        if (strtolower($device) == 'mobile') {
                            $tags .= '<span class="listingOrderDevice">Device: Mobile</span>';
                        } else {
                            $tags .= '<span class="listingOrderDevice">Device: Desktop</span>';
                        }
                    }
                   
                    if ($hsa_hfa != '' && get_user_meta($customer_id, 'hfa_hsa', true) == 'yes') {
                  //  if ($hsa_hfa != '') {
                        $tags .= '<span class="listingOrderDevice">HSA/FSA</span>';
                    }
                    $orderType = get_post_meta($item['ID'], 'order_type', true);
                    if ($orderType) {
                        $tags .= '<br/><span class="listingOrderDevice">Order Type : ' . $orderType . '</span>';
                    }
                    $old_order_id = get_post_meta($item['ID'], 'old_order_id', true);
                    if ($old_order_id) {
                        $tags .= '<br/><span class="listingOrderDevice" style="color:red">legacy Order ID: ' . $old_order_id . '</span>';
                    }
                    if (get_post_meta($item['ID'], 'updateByGTS', true) > 0) {
                        $tags .= '<br/><span class="listingOrderDevice">GTS marked by CSR</span>';
                    }
                    if (get_post_meta($item['ID'], 'google_optimize_order', true) == 'yes') {
                        $tags .= '<br/><span class="listingOrderDevice"><img  style="max-width: 22px;width: 22px;" src="https://www.gstatic.com/analytics-suite/header/suite/v2/ic_optimize.svg" alt="" > Google Optimize</span>';
                    }
                    $affiliate_id =    get_post_meta($item['ID'], 'rdhc_user_id', true);
                    if ($affiliate_id > 0) {
                        $name  = affiliate_wp()->affiliates->get_affiliate_name($affiliate_id);
                        $tags .= '<br/><span class="listingOrderDevice">RDHC : ' . $name . '</span>';
                    }
                    if (get_user_meta($customer_id, '_rdhc_user', true)) {
                        $tags .= '<br/><span class="geha-icon flex-item-mbt"><img src="https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/rdh-profile/RDH-logo.svg" alt="" ></span>';
                    }

                    // Assuming $post_id is the ID of the post
                    $user_history = get_post_meta($item['ID'], '_user_history', true);
                    if( get_user_meta($customer_id, 'sleep_assn', true) == 'yes'){
                        $tags .= '<br/><span class="listingOrderDevice">Sleep association</span>';
                    }else{
                        if (is_array($user_history)) {
                            foreach ($user_history as $meta_item) {
                                // Check if the meta item contains the specified values
                                if (
                                    strpos($meta_item['url'], 'utm_medium=Impact') !== false &&
                                    strpos($meta_item['url'], 'utm_source=2060990') !== false
                                ) {
                                    $tags .= '<br/><span class="listingOrderDevice">Sleep association</span>';
                                    // Match found, you can perform further actions here
                                    break; // Assuming you want to stop checking after the first match
                                }
                            }
                        }
                    }
                    // Check if the meta data is an array and iterate through it
                

                    /*
 $customer_id = get_post_meta($reference, '_customer_user',  true);
            if ($customer_id) {
                update_user_meta($customer_id, '_rdhc_user', $affiliate->user_id);
            }
*/

                    $tags .= '</p>';
                    return $title . $buttons . $tags;
		//Modified the case name as a hotfix patch to resolve  problem with the fraud plugin.
                case 'anti_fraud':
                    if (!class_exists('WC_AF_Score_Helper')) {
                        return 'Anti-fraud system is not available.';
                    }
                    $scoreHtml = '';
                    $order_id = $item['ID'];

                    // Create Score object and calculate score
                    $score_points = get_post_meta($order_id, 'wc_af_score', true);

                    // Get meta
                    $meta = WC_AF_Score_Helper::get_score_meta($score_points, $order_id);

                    // Check if there is an score order
                    if ('' != $score_points) {

                        // The label
                        $scoreHtml .= '<span class="mb-score-label" style="color:' . $meta['color'] . '">' . WC_AF_Score_Helper::invert_score($score_points) . ' % ' . $meta['label'] . '</span>' . PHP_EOL;

                        // Circle points
                        $circle_points = WC_AF_Score_Helper::invert_score($score_points);

                        // The circle
                        //$scoreHtml .= '<input class="knob" data-fgColor="' . $meta['color'] . '" data-thickness=".4" data-readOnly=true value="0" rel="' . $circle_points . '">';
                        // The rules
                        $json_rules = get_post_meta($order_id, 'wc_af_failed_rules', true);
                        $whitelist_action = get_post_meta($order_id, 'whitelist_action', true);
                        $whitelist_action_style = ($whitelist_action == 'user_email_whitelisted') ? 'style="color:grey"' : '';
                        //echo '<pre>'; print_r($json_rules); echo '</pre>';
                        // Failed Rules
                        if (is_array($json_rules) && !empty($json_rules)) {

                            $scoreHtml .= '<div class="woocommerce-af-risk-failure-list ' . sanitize_title($meta['label']) . '">' . PHP_EOL;

                            $scoreHtml .= '<ul>' . PHP_EOL;

                            foreach ($json_rules as $wc_af_failed_rule) {
                                $wc_af_failed_rule_decode = json_decode($wc_af_failed_rule, true);
                                if ($wc_af_failed_rule_decode['id'] == 'whitelist') {
                                    $scoreHtml .= '<li class="failed" ' . $whitelist_action_style . '>' . $wc_af_failed_rule_decode['label'] . '</li>' . PHP_EOL;
                                }
                            }

                            foreach ($json_rules as $json_rule) {

                                $rule = WC_AF_Rules::get()->get_rule_from_json($json_rule);
                                if (!is_a($rule, 'WC_AF_Rule')) {
                                    continue;
                                }
                                $scoreHtml .= '<li class="failed" ' . $whitelist_action_style . '>' . $rule->get_label() . '</li>' . PHP_EOL;
                            }

                            $scoreHtml .= '</ul>' . PHP_EOL;
                            //echo '<p><a href="#" data_id='.$order_id.' class="button button-primary test-fraud">' . __( 'Ajax Fraud Risk', 'woocommerce-anti-fraud' ) . '</a></p>' . PHP_EOL;
                            //  $scoreHtml .= '<a class="woocommerce-af-risk-failure-list-toggle" href="#" data-toggle="' . __( 'Hide details', 'woocommerce-anti-fraud' ) . '">' . __( 'Show fraud risk details', 'woocommerce-anti-fraud' ) . '</a>' . PHP_EOL;

                            $scoreHtml .= '</div>' . PHP_EOL;
                        }
                    }
                    return $scoreHtml;
                    case 'fraudlabspro_score':
                        ob_start(); // Start output buffering
                            $result = get_post_meta( $order->get_id(), '_fraudlabspro' );
                    
                            if (!$result) {
                                $table_name = $this->create_flpwc_table();
                                $result = $this->get_flpwc_data($table_name, $order->get_id(), '_fraudlabspro');
                            }
                    
                            if ( is_array($result) && count( $result ) > 0 ) {
                                $idx = count( $result ) - 1;
                                if ( !is_array( $result[$idx] ) && !is_object( $result[$idx] ) && strpos( $result[$idx], '\\' ) ) {
                                    $result[$idx] = str_replace( '\\', '', $result[$idx] );
                                }
                    
                                if( is_array( $result[$idx] ) ){
                                    if ( is_null( $row = $result[$idx] ) === FALSE ) {
                                        if ( isset( $row['fraudlabspro_score'] ) ) {
                                            if ( $row['fraudlabspro_score'] > 80 ) {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#ff0000"><span class="dashicons dashicons-warning"></span> <strong>' . $row['fraudlabspro_score'] . '</strong></div></a>';
                                            }
                                            elseif ( $row['fraudlabspro_score'] > 60 ) {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#f0c850"><span class="dashicons dashicons-warning"></span> <strong>' . $row['fraudlabspro_score'] . '</strong></div></a>';
                                            }
                                            else {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#66cc00"><span class="dashicons dashicons-thumbs-up"></span> <strong>' . $row['fraudlabspro_score'] . '</strong></div></a>';
                                            }
                                        }
                                    }
                                } else {
                                    if( is_object( $result[$idx] ) ){
                                        $row = $result[$idx];
                                    } else {
                                        $row = json_decode( $result[$idx] );
                                    }
                                    if ( is_null( $row ) === FALSE ) {
                                        if ( isset( $row->fraudlabspro_score ) ) {
                                            if ( $row->fraudlabspro_score > 80 ) {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#ff0000"><span class="dashicons dashicons-warning"></span> <strong>' . $row->fraudlabspro_score . '</strong></div></a>';
                                            }
                                            elseif ( $row->fraudlabspro_score > 60 ) {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#f0c850"><span class="dashicons dashicons-warning"></span> <strong>' . $row->fraudlabspro_score . '</strong></div></a>';
                                            }
                                            else {
                                                echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $order->get_id() . '&action=edit#flp-details"><div style="color:#66cc00"><span class="dashicons dashicons-thumbs-up"></span> <strong>' . $row->fraudlabspro_score . '</strong></div></a>';
                                            }
                                        }
                                    }
                                }
                            }
                            return ob_get_clean();
                        
                    //    return date('l M d, Y h:ia', strtotime($item['post_date']));
                case 'orderdate':
                    return date('l M d, Y h:ia', strtotime($item['post_date']));
                case 'emailphone':
                    $phone = get_post_meta($item['ID'], '_billing_phone', true);
                    $email = get_post_meta($item['ID'], '_billing_email', true);
                    $customer_id = get_post_meta($item['ID'], '_customer_user', true);
                    $buttons = '<br><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit</a>';
                    //	$buttons = '<br><input type="button" class="button sbr-button editBuyerDetails" value="Edit" data-customer-id="'.$customer_id.'">';
                    $buttons .= '<br><input type="button" class="button sbr-button buyerProfile" value="Buyer Profile" data-customer-id="' . $customer_id . '">';
                    return $phone . '<br>' . $email . $buttons;
                case 'totalpaid':
                    $order_shipping = '';

                    $order_subtotal = $order->get_subtotal_to_display();
                    $order_discount = $order->get_discount_total();
                    $order_total = $order->get_total();
                    $cart_discount = get_post_meta($item['ID'], '_cart_discount', true);
                    /*
                      $line_items_fee = $order->get_items('fee');
                      foreach ( $line_items_fee as $item_fee ) {
                      $order_shipping .= $item_fee->get_name().': '.wc_price( $item_fee->get_total(), array( 'currency' => $order->get_currency() ) );
                      }
                     */

                    $order_shipping = 'FREE';
                    if ($order->get_shipping_total() > 0) {
                        $order_shipping = '$' . num2d($order->get_shipping_total());
                    }

                    $totalOrderHtml = '<div class="sbr-order_total_col">';
                    $totalOrderHtml .= '<div class="order_subtotal sbr_flexcol">Subtotal: ' . $order_subtotal . '</div>';
                    $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Discount: <span>-$' . num2d($order->get_discount_total()) . '</span></div>';
                    $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Shipping: <span>' . $order_shipping . '</span></div>';
                    foreach ($order->get_items('fee') as $item_id => $item_fee) {
                        $fee_name = $item_fee->get_name();
                        if ('Geha Shipping Fees: ' == $fee_name) {
                            $fee_total = $item_fee->get_total();
                            // $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Geha Shipping: <span>$' . num2d($fee_total) . '</span></div>';
                            if ($fee_total != '') {
                                $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Geha Shipping: <span>$' . num2d($fee_total) . '</span></div>';
                            }
                        }
                    }
                    $service_charges_amount = 0;
                    foreach ($order->get_items('fee') as $item_id => $item_fee) {
                        if (wc_get_order_item_meta($item_id, 'transId')) {
                            $service_charges_amount += $item_fee->get_total();
                        }
                        //  $fee_name = $item_fee->get_name();
                        //  $service_charges_amount += $item_fee->get_total();
                    }

                    $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Service Charges: <span>$' . num2d($service_charges_amount) . '</span></div>';


                    $totalOrderHtml .= '<div class="cart_discount sbr_flexcol">Tax: <span>$' . num2d($order->get_total_tax()) . '</span></div>';
                    if ($order->get_total_refunded()) {
                        $totalOrderHtml .= '<div class="refunds sbr_flexcol"><div class="refund-popup-container">Refund: <span class="orde_refund_reason_mbt"  data-order-id="' . $item['ID'] . '" > <span class="info-tolltip-mbt"><span class="dashicons dashicons-info-outline"></span> <span class="loading-balls-animatation"></span>  <span class="tooltiptext">Refunds Reasons</span> </span> </span></div><span style="color:red">-$' . num2d($order->get_total_refunded()) . '</span>';
                        $totalOrderHtml .= '<div  class="popup-refund-parent" style="display:none">';
                        $totalOrderHtml .= '<div class="add-sbr-data" ></div> <span class="cross-div"><span class="dashicons dashicons-no"></span></span></div></div>';
                    }

                    $totalOrderHtml .= '<div class="order_total sbr_flexcol">Total: <span>$' . num2d($order->get_total() - $order->get_total_refunded()) . '</span></div>';
                    /*
                      $totalOrderHtml .= ($cart_discount ? '<div class="cart_discount sbr_flexcol">Discount: <span>-' . $order_discount . '</span></div>' : '');
                      $totalOrderHtml .= ($order_shipping ? '<div class="cart_discount sbr_flexcol">Shipping: <span>' . $order_shipping . '</span></div>' : '');
                      $totalOrderHtml .= ($order_tax ? '<div class="cart_discount sbr_flexcol">Tax: <span>' . $order_tax . '</span></div>' : '');

                      $totalOrderHtml .= '<div class="order_total sbr_flexcol">Total: ' . $order_total . '</div>';
                     */

                    if (get_post_meta($item['ID'], '_payment_method_title', true)) {
                        //	$totalOrderHtml .= '<div class="via_payment"><span class="viaPaymentImage"><img  src="'.get_stylesheet_directory_uri().'/assets/images/credit-card.svg"></span><span class="col_method_title">'.get_post_meta($item['ID'] , '_payment_method_title' , true).'</span></div>';
                    }


                    $totalOrderHtml .= '<div class="orderPaymentMethod">';
                    if (get_post_meta($order->get_id(), '_payment_method', true) == 'authorize_net_cim_credit_card') {
                        $cardType = get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_card_type', true);
                        if ($cardType == '') {
                            $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>CC';
                        } else {
                            if ($cardType == 'americanexpress' || $cardType == 'card-amex') {
                                $cardType = 'amex';
                            }
                            $cardImageUrl = site_url('wp-content/plugins/woocommerce-gateway-authorize-net-cim/vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway/assets/images/card-' . $cardType . '.svg');
                            $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                            $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';
                            $totalOrderHtml .= '<span class="cardNumber">****' . get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_account_four', true) . '</span>';
                        }


                        $totalOrderHtml .= '</div>';
                        $totalOrderHtml .= '<div class="title_transaction_id"><span class="paymentMethod">Transaction#</span>';
                        $totalOrderHtml .= '<span class="get_transaction_id">' . $order->get_transaction_id() . '</span>';
                        $totalOrderHtml .= '</div>';
                    } elseif (get_post_meta($order->get_id(), '_payment_method', true) == 'affirm') {
                        $cardImageUrl = 'https://cdn-assets.affirm.com/images/blue_logo-transparent_bg.png';
                        $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                        //$totalOrderHtml .= '<span class="col_method_title">Affirm</span>';
                        $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';

                        $totalOrderHtml .= '</div>';
                        $totalOrderHtml .= '<div class="title_transaction_id"><span class="paymentMethod">Transaction#</span>';
                        $totalOrderHtml .= '<span class="get_transaction_id">' . $order->get_transaction_id() . '</span>';
                        $totalOrderHtml .= '</div>';
                    } elseif ($order->get_status() == 'pending') {
                        $totalOrderHtml .= '<span class="paymentMethod pending" style="color:red">Pending Payment</span>';
                    } else {
                        if ($order->get_payment_method_title()) {
                            $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                            $totalOrderHtml .= '<span class="col_method_title">' . wp_kses_post($order->get_payment_method_title()) . '</span>';
                            $totalOrderHtml .= '</div>';
                        } else {
                            $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod  free">FREE</span>';
                            $totalOrderHtml .= '</div>';
                        }

                        //   $totalOrderHtml .= wp_kses_post($order->get_payment_method_title());
                    }
                    $totalOrderHtml .= '</div>';

                    $totalOrderHtml .= '<div class="sb-refund"><input type="button" class="button sbr-button refundCC" value="Refund CC" data-order-id="' . $item['ID'] . '"></div>';
                    $totalOrderHtml .= '</div>';
                    return $totalOrderHtml;
                    //return 'Subtotal: '.$order_subtotal.($cart_discount ? '<br><br>Discount: -'.$order_discount: '').($order_shipping ? '<br><br>'.$order_shipping: '').'<br><br>Total: '.$order_total.$buttons;
                case 'billing':
                    global $anti_fraudblacklist_emails_listing;
                    /// $billing_arr = get_post_meta($item['ID']);

                    $billing_first_name = get_post_meta($item['ID'], '_billing_first_name', true);
                    $billing_last_name = get_post_meta($item['ID'], '_billing_last_name', true);
                    $billing_address_1 = get_post_meta($item['ID'], '_billing_address_1', true);
                    $billing_address_2 = get_post_meta($item['ID'], '_billing_address_2', true);
                    $billing_city = get_post_meta($item['ID'], '_billing_city', true);
                    $billing_state = get_post_meta($item['ID'], '_billing_state', true);
                    $billing_postcode = get_post_meta($item['ID'], '_billing_postcode', true);
                    $phone = get_post_meta($item['ID'], '_billing_phone', true);
                    $email = get_post_meta($item['ID'], '_billing_email', true);
                    $customer_id = get_post_meta($item['ID'], '_customer_user', true);

                    $billing_method_html = '';
                    //if($billing_arr['_payment_method_title'][0])
                    //	$billing_method_html = '<br><br>via '.$billing_arr['_payment_method_title'][0];
                    //$billing = $billing_arr['_billing_first_name'][0].' '.$billing_arr['_billing_last_name'][0].', '.$billing_arr['_billing_address_1'][0].', '.$billing_arr['_billing_city'][0].', '.$billing_arr['_billing_state'][0].' '.$billing_arr['_billing_postcode'][0];
                    $buttons = '<div class="billingActions"><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit Order Address</a>';
                    //$buttons = '<div class="billingActions"><input type="button" class="button sbr-button editBuyerDetails" value="Edit" data-customer-id="'.$customer_id.'">';
                    $buttons .= '<input type="button" class="button sbr-button buyerProfile" value="Buyer Profile" data-customer-id="' . $customer_id . '"></div>';
                    //	$buttons .= $billing_method_html;

                    $billingHtml = '';
                    $billingHtml .= '<div class="billingAddressCol">';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $billing_first_name . ' ' . $billing_last_name . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $billing_address_1 . ' ' . $billing_address_2 . ', ' . $billing_city . ', ' . $billing_state . ' ' . $billing_postcode . '</span>';
                    $billingHtml .= '</div>';

                    if (in_array($email, $anti_fraudblacklist_emails_listing)) {
                        $order_id = $item['ID'];
                        $billingHtml .= '<div class="billinginfo" id="unblockFruadContainer-' . $order_id . '">';
                        $billingHtml .= '<span class="dashicons dashicons-email-alt" style="color:red"></span><span style="color:red" class="billingSubInfo">' . $email . '</span>';
                        $billingHtml .= '<a href="javascript:;" class="unblockFruad" order_id= "' . $order_id . '" email="' . $email . '"><span style="color:#64ce41" class="dashicons dashicons-unlock"></span></a>';
                        $billingHtml .= '</div>';
                    } else {
                        $billingHtml .= '<div class="billinginfo">';
                        $billingHtml .= '<span class="dashicons dashicons-email-alt"></span><span class="billingSubInfo">' . $email . '</span>';
                        $billingHtml .= '</div>';
                    }

                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-phone"></span><span class="billingSubInfo">' . $phone . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '</div>';
                    /*
                    $billingHtml = '';
                    $billingHtml .= '<div class="billingAddressCol">';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $billing_arr['_billing_first_name'][0] . ' ' . $billing_arr['_billing_last_name'][0] . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $billing_arr['_billing_address_1'][0] . ' ' . $billing_arr['_billing_address_2'][0] . ', ' . $billing_arr['_billing_city'][0] . ', ' . $billing_arr['_billing_state'][0] . ' ' . $billing_arr['_billing_postcode'][0] . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-email-alt"></span><span class="billingSubInfo">' . $email . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-phone"></span><span class="billingSubInfo">' . $phone . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '</div>';
*/
                    return $billingHtml . $buttons;

                    //return $billing;
                case 'shipping':
                    $shipping_method_html = '';
                    $shipping_method = $order->get_shipping_method();
                    if ($shipping_method == '') {
                        $olddata = json_decode(get_post_meta($order_id, '_oldJson', true), true);

                        $shipping_method = isset($olddata['shipmentMethod']) ? $olddata['shipmentMethod'] : '';
                    }
                    //  $shipping_arr = get_post_meta($item['ID']);
                    if ($shipping_method != '') {
                        $shipping_method_html .= '<div class="shippingMethodCol">';
                        // if (strpos($shipping_method, 'USPS') >= 0) {
                        //     $shipping_method_html .= '<span><img src="' . get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg" style="width:60px;"></span>';
                        // }
                        if (str_contains($shipping_method, 'USPS')) {
                            $shipping_method_html .= '<span><img src="' . get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg" style="width:60px;"></span>';
                            //$shipping_method_html .= '<span><img src="https://assets.track.easypost.com/shared-assets/carriers/usps-logo.svg" style="width:60px;" /></span>';
                        }
                        if (str_contains($shipping_method, 'UPS')) {
                            $shipping_method_html .= '<span><img src="https://assets.track.easypost.com/shared-assets/carriers/ups-logo.svg" style="width:60px;" /></span>';
                        }
                        $shipping_method_html .= '<span>via ' . $shipping_method . '</span>';
                        $shipping_method_html .= '</div>';
                    }


                    $edit_shipping = change_shipping_method_by_order_id($order);
                    //$shipping = $shipping_arr['_shipping_first_name'][0].' '.$shipping_arr['_shipping_last_name'][0].', '.$shipping_arr['_shipping_address_1'][0].', '.$shipping_arr['_shipping_city'][0].', '.$shipping_arr['_shipping_state'][0].' '.$shipping_arr['_shipping_postcode'][0].$shipping_method_html;
                    $shipping_first_name = get_post_meta($item['ID'], '_shipping_first_name', true);
                    $shipping_last_name = get_post_meta($item['ID'], '_shipping_last_name', true);
                    $shipping_address_1 = get_post_meta($item['ID'], '_shipping_address_1', true);
                    $shipping_address_2 = get_post_meta($item['ID'], '_shipping_address_2', true);
                    $shipping_city = get_post_meta($item['ID'], '_shipping_city', true);
                    $shipping_state = get_post_meta($item['ID'], '_shipping_state', true);
                    $shipping_postcode = get_post_meta($item['ID'], '_shipping_postcode', true);



                    $edit_shipping = change_shipping_method_by_order_id($order);
                    //$shipping = $shipping_arr['_shipping_first_name'][0].' '.$shipping_arr['_shipping_last_name'][0].', '.$shipping_arr['_shipping_address_1'][0].', '.$shipping_arr['_shipping_city'][0].', '.$shipping_arr['_shipping_state'][0].' '.$shipping_arr['_shipping_postcode'][0].$shipping_method_html;

                    $billingHtml = '';
                    if((!empty($shipping_first_name) || !empty($shipping_last_name)) && !empty($shipping_address_1))
                    {
                        $billingHtml .= '<div class="shippingAddressCol">';
                        $billingHtml .= '<div class="billinginfo">';
                        $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $shipping_first_name . ' ' . $shipping_last_name . '</span>';
                        $billingHtml .= '</div>';
                        $billingHtml .= '<div class="billinginfo">';
                        $billingHtml .= '<span class="dashicons dashicons-admin-home 333333"></span><span class="billingSubInfo">' . $shipping_address_1 . ' ' . $shipping_address_2 . ', ' . $shipping_city . ', ' . $shipping_state . ' ' . $shipping_postcode . '</span>';
                        $billingHtml .= '</div>';
                        $billingHtml .= $shipping_method_html . $edit_shipping;
                        $billingHtml .= '</div>';
                    }
                    /*
                    $billingHtml = '';
                    $billingHtml .= '<div class="shippingAddressCol">';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $shipping_arr['_shipping_first_name'][0] . ' ' . $shipping_arr['_shipping_last_name'][0] . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= '<div class="billinginfo">';
                    $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $shipping_arr['_shipping_address_1'][0] . ' ' . $shipping_arr['_shipping_address_2'][0] . ', ' . $shipping_arr['_shipping_city'][0] . ', ' . $shipping_arr['_shipping_state'][0] . ' ' . $shipping_arr['_shipping_postcode'][0] . '</span>';
                    $billingHtml .= '</div>';
                    $billingHtml .= $shipping_method_html . $edit_shipping;
                    $billingHtml .= '</div>';
                    */
                    return $billingHtml;
                case 'ship':

                    $order_status = $order->get_status();
                    $optionslistsss = wc_get_order_statuses();
                    // echo 'Data: <pre>' .print_r($optionslistsss,true). '</pre>';
                    $optionslist = array('processing', 'pending', 'on-hold', 'completed', 'cancelled', 'refunded', 'partial-refunded', 'failed', 'partial_ship', 'shipped');
                    $str = '';
                    foreach ($optionslistsss as $key222 => $ss) {
                        if (in_array($key222, array('wc-checkout-draft'))) {
                            continue;
                        }
                        $key22222 = str_replace("wc-", "", $key222);
                        if ($key22222 == $order_status) {
                            $selected_s = 'selected';
                        } else {
                            $selected_s = '';
                        }
                        $str .= '<option value="' . $key22222 . '" ' . $selected_s . '> ' . $ss . '</option>';
                    }
                    $edit_status = '<div class="item_status_input flex-row-mbt" style="display:none;"><select  class="subsubsub" name="edit_status_inline" id="edit_status_inline">
                                    
                                   ' . $str . '
                                </select><div class="button-parent-batch-print"><div class="btn_save"><button class="btn_edit_status" type="button" data-order_id="' . $order_id . '">Save</button></div><div class="btn_cancel"><button class="btn_edit_status_cancel" type="button" style="">Cancel</button></div></div></div>';

                    return '<span class="sbr-' . $order_status . '">' . wc_get_order_status_name($order_status) . '</span>' . $edit_status . '<a class="status_edit" href="javascript:;" style=""></a>';


                case 'products':
                    $threeWay = get_post_meta($item['ID'], 'threeWayShipment', true);

                    $prodcuts = '<table class="widefat"><thead>
                <tr><th class="sbr-products-table-name">Name</th>
                <th class="sbr-products-table-qty ">Ord Qty</th>
                <th class="sbr-products-table-qty shipped-qty-only">Shp Qty</th>
                <th class="sbr-products-table-status">Status</th>
                <th class="sbr-products-table-tcode">Tracking</th>
                <th class="sbr-products-table-coupon">CPN</th>
                <th class="sbr-products-table-discount">Disc</th></tr></thead><tbody>';

                    $coupons = $order->get_items('coupon');
                    $coupon_code = '';
                    if ($coupons) {
                        foreach ($coupons as $item_coupon_id => $item_coupon) {
                            $coupon_code = $item_coupon->get_code();
                        }
                    }
                    foreach ($order->get_items() as $item_id => $item_pro) {
                        $sync_html = '';
                        $tray_html = '';
                        $coupon_html = '';
                        $discount_html = '';
                        $mouth_guard_html='';
                        if ($item_pro->get_subtotal() !== $item_pro->get_total()) {
                            $coupon_html = $coupon_code;
                            $discount_html = wc_price(wc_format_decimal($item_pro->get_subtotal() - $item_pro->get_total(), ''), array('currency' => $order->get_currency()));
                        }
                        if (wc_cp_get_composited_order_item_container($item_pro, $order)) {
                            //Composite Prdoucts Child Items
                        } else {
                            $customer_chat = add_query_arg(
                                array(
                                    'action' => 'create_customer_popup',
                                    'order_id' => $item['ID'],
                                    'product_id' => $item_pro->get_product_id(),
                                    'item_id' => $item_id,
                                ),
                                admin_url('admin-ajax.php')
                            );

                            $ticket_status_item = $wpdb->get_var("SELECT ticket_status FROM  " . SB_ORDER_TABLE . " WHERE item_id = " . $item_id . " AND order_id = " . $item['ID'] . " AND ticket_id !=0");

                            $img = 'customerSupport';
                            $tool_tip_ticket = 'Create Ticket';
                            if ($ticket_status_item == 'open') {
                                $img = 'customerSupport-red';
                                $tool_tip_ticket = 'Contact Customer';
                            }
                            if ($ticket_status_item == 'solved') {
                                $img = 'customerSupport-green';
                                $tool_tip_ticket = 'Ticket Resolved';
                            }
                            //if(wc_cp_is_composite_container_order_item($item_pro)){
                            $three_way_ship_product = get_post_meta($item_pro->get_product_id(), 'three_way_ship_product', true);
                            $qtyShipped = 0;
                            $tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_pro, $item_pro->get_product(), 2);
                            if ($three_way_ship_product) {
                                $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                                if ($shippedhistory == 1) {
                                    $qtyShipped = 0.5;
                                } else if ($shippedhistory == 2) {
                                    $qtyShipped = 1;
                                } else {
                                    $qtyShipped = 0;
                                }

                                /*
                                  $query_tray_no = $wpdb->get_row("SELECT id, tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = ".$item['ID']." and item_id = ".$item_id);
                                  if($query_tray_no->id){
                                  $tray_html = '<div class="itemTrayCol"><label><Tray Number/label><input type="text" id="tray_number_' . $item_id . '" class="tray_number-input" name="tray_number" placeholder="Tray Number" value="' . $query_tray_no->tray_number . '">';
                                  $tray_html .= '<input class="button sbr-button btn_tray_number" type="button" value="Set Tray Number" data-order-id="'.$item['ID'].'" data-item-id="'.$item_id.'"></div>';
                                  }
                                 */
                            } else {
                                $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                                if ($shippedhistory) {
                                    foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                                        $qtyShipped += (int) $shippedhistoryQty;
                                    }
                                }
                            }
                            //$tray_html .= getUserChatForLog($customer_chat);
                            $mouth_guard_number = wc_get_order_item_meta($item_id, 'mouth_guard_number', true);
                            $mouth_guard_color = wc_get_order_item_meta($item_id, 'mouth_guard_color', true);
                            if (!empty($mouth_guard_number)) {
                                $mouth_guard_html = '<div class="custom-guards">Color:<strong class="' . $mouth_guard_color . '" > '.$mouth_guard_color.'</strong></div>';
                            }
                            if (!empty($mouth_guard_color)) {
                               $mouth_guard_html .= '<div class="custom-guards">Number:<strong> '.$mouth_guard_number.'</strong></div>';
                            }
                            $tray_html .= '<a class="customer_chat button button-small sb_customer_chat ' . $ticket_status_item . '" href="javascript:;"  custom-url="' . $customer_chat . '" >' . iconListingOrder($img) . '<span class="tooltiptext">' . $tool_tip_ticket . '</span></a>';
                            $tray_html.=$mouth_guard_html;
                            //}
                             //} subscription#RB[1299-1305]
                             $subscription_status = $wpdb->get_var("SELECT status FROM sbr_subscription_details WHERE order_id = " . $order->get_id() . " AND item_id = ".$item_id." AND subscription_id > 0 LIMIT 0,1");
                            $old_order_id = get_post_meta($order_id, 'old_order_id', true);
                            if ($old_order_id && $three_way_ship_product != 'yes' && $item_pro->get_quantity() != $qtyShipped) {
                                $sync_html = '<a href="javascript:void(0);" class="sysncQty" data-orderitemid="' . $item_id . '" data-order_id="' . $order_id . '" data-order_qty="' . $item_pro->get_quantity() . '">sysc Qty</a>';
                            }
                            $upsellClass = '';
                            if ($item_pro->get_meta('_upstroke_purchase')) {
                                $upsellClass = '<span class="upsellProduct"></span>';
                            }
                            $prodcuts .= '<tr><td>' . $upsellClass . $item_pro->get_name()  .($subscription_status?'<br><small style="color:MediumSeaGreen;">Subscribed</small>':''). $tray_html . '<br />' . $sync_html . '</td><td>' . $item_pro->get_quantity() . '</td>';
                            $prodcuts .= '<td>' . $qtyShipped . '</td>';
                            $prodcuts .= '<td>' . get_order_item_status_mbt($item_pro, $item_id) . '</td><td>' . get_order_item_tracking_mbt($item_id) . '</td><td>' . $coupon_html . '</td><td>' . $discount_html . '</td><tr>';
                        }
                    }
                    $prodcuts .= '</tbody></table>';

                    return $prodcuts;
                default:
                    return ''; //print_r( $item, true );
            }
        }
    }

    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="bulk-orders[]" value="%s" />', $item['ID']);
    }

    function get_columns()
    {

        if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'waiting-impression') {
            $columns = [
                'cb' => '<input type="checkbox" />',
                'tray_number' => __('Tray Number', 'sbr'),
                'product' => __('Product', 'sbr'),
                'ordernumber' => __('Order Number', 'sbr'),
                'orderdate' => __('Order Date', 'sbr'),
                'order_delivery_date' => __('Order Delivery Date', 'sbr'),
                'order_type' => __('Order Type', 'sbr'),
                'billing' => __('Customer Billing', 'sbr'),
                'shipping' => __('Customer Shipping', 'sbr'),
            ];
        } else if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'pending-lab') {
            $columns = [
                'cb' => '<input type="checkbox" />',
                'tray_number' => __('Tray Number', 'sbr'),
                'product' => __('Product', 'sbr'),
                'ordernumber' => __('Order Number', 'sbr'),
                'orderdate' => __('Order Date', 'sbr'),
                'impression_date' => __('Impression Date', 'sbr'),
                'order_type' => __('Order Type', 'sbr'),
                'billing' => __('Customer Billing', 'sbr'),
                'shipping' => __('Customer Shipping', 'sbr'),
            ];
        } else {
            $columns = [
                'cb' => '<input type="checkbox" />',
                'ordernumber' => __('Order Number', 'sbr'),
                //'anti_fraud' => __('Score', 'sbr'),
                'fraudlabspro_score' => __('Score', 'sbr'),
                //	'orderdate' => __( 'Order Date', 'sbr' ),
                //	'emailphone' => __( 'Email/Phone', 'sbr' ),
                'totalpaid' => __('Total Paid', 'sbr'),
                'billing' => __('Customer Billing', 'sbr'),
                'shipping' => __('Customer Shipping', 'sbr'),
                'ship' => __('Status', 'sbr'),
                'products' => __('Products Ordered', 'sbr')
            ];
        }


        return $columns;
    }

    function get_columns_pending_lab()
    {
        $columns = [
            'cb' => '<input type="checkbox" />',
            'tray_number' => __('Tray Number', 'sbr'),
            'product' => __('Product', 'sbr'),
            'ordernumber' => __('Order Number', 'sbr'),
            'orderdate' => __('Order Date', 'sbr'),
            'impression_date' => __('Impression Date', 'sbr'),
            'order_type' => __('Order Type', 'sbr'),
            'billing' => __('Customer Billing', 'sbr'),
            'shipping' => __('Customer Shipping', 'sbr'),
        ];
        return $columns;
    }

    function get_columns_waiting_impression()
    {
        $columns = [
            'cb' => '<input type="checkbox" />',
            'tray_number' => __('Tray Number', 'sbr'),
            'product' => __('Product', 'sbr'),
            //    'product_qty_ordered' => __('Qty', 'sbr'),
            //    'product_qty_shipped' => __('Shipped', 'sbr'),
            'ordernumber' => __('Order Number', 'sbr'),
            'orderdate' => __('Order Date', 'sbr'),
            //	'emailphone' => __( 'Email/Phone', 'sbr' ),
            'order_delivery_date' => __('Order Delivery Date', 'sbr'),
            'order_type' => __('Order Type', 'sbr'),
            'billing' => __('Customer Billing', 'sbr'),
            'shipping' => __('Customer Shipping', 'sbr'),
            //             'ship' => __('Status', 'sbr'),
            //             'products' => __('Products Ordered', 'sbr')
        ];

        return $columns;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            //'orderdate' => array( 'orderdate', true )
        );

        return $sortable_columns;
    }

    public function get_sortable_columns_waiting_impressiuon()
    {
        $sortable_columns = array(
            //'orderdate' => array( 'orderdate', true )
        );

        return $sortable_columns;
    }

    public function get_bulk_actions()
    {
        $actions = [
            //'bulk-trash' => 'Move to Trash',
            //'bulk-batch-printing' => 'Batch Printing'
        ];

        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '')
            //$actions['bulk-batch-printing'] = 'Batch Printing';

        return $actions;
    }

    public function prepare_items_waiting_on_impression()
    {
        $this->_column_headers = array($this->get_columns_waiting_impression(), array(), $this->get_sortable_columns_waiting_impressiuon());

        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('orders_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = self::get_orders($per_page, $current_page, 'yes');

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page
        ]);

        $this->items = self::get_orders($per_page, $current_page);
    }

    public function prepare_items_pending_lab()
    {
        $this->_column_headers = array($this->get_columns_pending_lab(), array(), $this->get_sortable_columns_waiting_impressiuon());

        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('orders_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = self::get_orders($per_page, $current_page, 'yes');

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page
        ]);

        $this->items = self::get_orders($per_page, $current_page);
    }

    public function prepare_items()
    {
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());

        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('orders_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = self::get_orders($per_page, $current_page, 'yes');

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page
        ]);

        $this->items = self::get_orders($per_page, $current_page);
    }

    public function process_bulk_action()
    {

        if ('delete' === $this->current_action()) {
            $nonce = esc_attr($_REQUEST['_wpnonce']);

            if (!wp_verify_nonce($nonce, 'sbr_delete_order')) {
                die('Invalid request');
            } else {
                self::delete_order(absint($_GET['order']));

                wp_redirect(esc_url(add_query_arg()));
                exit;
            }
        }

        if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'bulk-trash') || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'bulk-trash')) {
            $trash_ids = esc_sql($_POST['bulk-orders']);

            foreach ($trash_ids as $id) {
                self::trash_order($id);
            }

            wp_redirect(esc_url(add_query_arg()));
            exit;
        }
        if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'bulk-batch-printing') || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'bulk-batch-printing')) {
            //echo '*-*-*-';
            /* $order_ids = esc_sql( $_REQUEST['bulk-orders'] );
              //echo 'Data: <pre>' .print_r($order_ids,true). '</pre>';
              //die;
              $res = batch_printing_send_request($order_ids, false);

              //$redirect_url = add_query_arg('wc_batch_printing', count($post_ids), $redirect_url);
              echo $res; */
            //die();
        }
    }

    public function ajax_response()
    {

        if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'waiting-impression') {
            $this->prepare_items_waiting_on_impression();
        } else if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'pending-lab') {
            $this->prepare_items_pending_lab();
        } else {
            $this->prepare_items();
        }


        extract($this->_args);
        extract($this->_pagination_args, EXTR_SKIP);

        ob_start();
        if (!empty($_REQUEST['no_placeholder']))
            $this->display_rows();
        else
            $this->display_rows_or_placeholder();
        $rows = ob_get_clean();

        ob_start();
        $this->print_column_headers();
        $headers = ob_get_clean();

        ob_start();
        $this->pagination('top');
        $pagination_top = ob_get_clean();

        ob_start();
        $this->pagination('bottom');
        $pagination_bottom = ob_get_clean();

        $response = array('rows' => $rows);
        $response['pagination']['top'] = $pagination_top;
        $response['pagination']['bottom'] = $pagination_bottom;
        $response['column_headers'] = $headers;

        if (isset($total_items))
            $response['total_items_i18n'] = sprintf(_n('1 item', '%s items', $total_items), number_format_i18n($total_items));

        if (isset($total_pages)) {
            $response['total_pages'] = $total_pages;
            $response['total_pages_i18n'] = number_format_i18n($total_pages);
        }

        die(json_encode($response));
    }
}
