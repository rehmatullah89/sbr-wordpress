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
add_action('wp_ajax_total_tray_info_mbt', 'total_tray_info_mbt');
add_action('wp_ajax_total_upsell_mbt', 'total_upsell_mbt');
add_action('wp_ajax_easypost_report_mbt', 'easypost_report_mbt');
add_action('wp_ajax_rm_product_easypost_report_mbt', 'rm_product_easypost_report_mbt');

add_action('wp_ajax_geha_experiments_mbt', 'geha_experiments_mbt');


add_action('wp_ajax_rm_product_easypost_report_mbt', 'rm_product_easypost_report_mbt');
function rm_product_easypost_report_mbt($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    //  $order_start_date = $order_start_date . ' 00:00:00';
    //  $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();


    $searchQuery = '';
    if ($order_start_date <> '' && $order_end_date <> '') {
        $searchQuery .= " and (shipmentDate BETWEEN '" . $order_start_date . " 00:00:00' AND '" . $order_end_date . " 23:59:59') ";
    } else if ($order_start_date <> '') {
        $searchQuery .= " and (shipmentDate >= '" . $order_start_date . " 00:00:00') ";
    } else if ($order_end_date <> '') {
        $searchQuery .= " and (shipmentDate <= '" .  $order_end_date . " 23:59:59') ";
    }
    //distinct  se.shipment_id , shipmentCost , easyPostLabelCarrier , easyPostLabelService , shipmentState
    // distinct so.order_id ,
    $query = "SELECT productsWithQty , shipmentState , packageId FROM  " . SB_EASYPOST_TABLE . " as se";
    //  $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as so ON se.shipment_id=so.shipment_id";

    $query .= " WHERE 1 " . $searchQuery;
    $data_results = $wpdb->get_results($query, 'ARRAY_A');
    //   $data_results = $wpdb->get_col($);
    $firstShipmentRMProducts = array();
    $secondShipmentRMProducts = array();
    $oneTimeRMProducts = array();


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


    $whiteningShipped = array();
    $nightGuardShipped = array();
    if (count($data_results) > 0) {
        foreach ($data_results as  $shipmentEntry) {
            if ($shipmentEntry['shipmentState'] != 'Refunded-Success' && $shipmentEntry['packageId'] > 0) {
                //   if ($shipmentEntry['shipmentState'] != 'Refunded-Success') {
                $productsWithQty = $shipmentEntry['productsWithQty'];
                $items = json_decode($productsWithQty, true);
                $availableComponentProducts = array();
                foreach ($items as $productData) {
                    $product_id = $productData['product_id'];
                    // var_dump($productData);
                    if ($productData['type'] == 'composite' && (isset($productData['shipment'])  && (int)$productData['shipment'] == 2)) {

                        if (in_array($product_id, $whitening_product_list)) {
                            if (isset($whiteningShipped[$product_id])) {
                                $whiteningShipped[$product_id] = (int)  $whiteningShipped[$product_id]  + 1;
                            } else {
                                $whiteningShipped[$product_id] = 1;
                            }
                        }
                        if (in_array($product_id, $night_guards_product_list)) {
                            if (isset($nightGuardShipped[$product_id])) {
                                $nightGuardShipped[$product_id] = (int)  $nightGuardShipped[$product_id]  + 1;
                            } else {
                                $nightGuardShipped[$product_id] = 1;
                            }
                        }
                    }
                    if (isset($availableComponentProducts[$product_id])) {
                        $compositeData = $availableComponentProducts[$product_id];
                    } else {
                        $compositeData = get_field('composite_products', $product_id);
                        $availableComponentProducts[$product_id] = $compositeData;
                    }

                    foreach ($compositeData as $composite_item_id => $composite_item) {
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];

                        if ($productData['type'] == 'composite') {
                            if ((int)$productData['shipment'] == 1) {
                                if (isset($firstShipmentRMProducts[$composite_item_product_id])) {
                                    $firstShipmentRMProducts[$composite_item_product_id] = $firstShipmentRMProducts[$composite_item_product_id] +  $firstShipment;
                                } else {
                                    $firstShipmentRMProducts[$composite_item_product_id] = $firstShipment;
                                }
                            } else {

                                if (isset($secondShipmentRMProducts[$composite_item_product_id])) {
                                    $secondShipmentRMProducts[$composite_item_product_id] = $secondShipmentRMProducts[$composite_item_product_id] +  $secondShipment;
                                } else {
                                    $secondShipmentRMProducts[$composite_item_product_id] = $secondShipment;
                                }
                            }
                        } else {
                            $qtyShiped = $productData['qty'] * $firstShipment;
                            if (isset($oneTimeRMProducts[$composite_item_product_id])) {
                                $oneTimeRMProducts[$composite_item_product_id] = $oneTimeRMProducts[$composite_item_product_id] +  $qtyShiped;
                            } else {
                                $oneTimeRMProducts[$composite_item_product_id] = $qtyShiped;
                            }
                        }
                    }
                }
            }
        }
    }

    $html = '';
    if (count($data_results) > 0) {
        $html .= '<ul>';
        if (count($oneTimeRMProducts)) {
            $html .= '<li style="background-color: red;color: white;font-size: 16px;text-align: center;display: block;font-weight: bold;">One Way Products Component Inventory</li>';
            foreach ($oneTimeRMProducts as $otrm_product_id => $otrm_qty) {
                if ($otrm_qty > 0) {
                    $html .= '<li>' .  get_the_title($otrm_product_id) . ' <span class="qty-cell">' . $otrm_qty . '</span></li>';
                }
            }
        }
        if (count($firstShipmentRMProducts)) {
            $html .= '<li style="background-color: red;color: white;font-size: 16px;text-align: center;display: block;font-weight: bold;">First Shipment Inventory</li>';
            foreach ($firstShipmentRMProducts as $rm_product_id => $rm_qty) {
                if ($rm_qty > 0) {
                    $html .= '<li>' .  get_the_title($rm_product_id) . ' <span class="qty-cell">' . $rm_qty . '</span></li>';
                }
            }
        }
        if (count($secondShipmentRMProducts)) {
            $html .= '<li style="background-color: red;color: white;font-size: 16px;text-align: center;display: block;font-weight: bold;">Second Shipment Inventory</li>';
            foreach ($secondShipmentRMProducts as $st_rm_product_id => $st_rm_qty) {
                if ($st_rm_qty > 0) {
                    $html .= '<li>' .  get_the_title($st_rm_product_id) . ' <span class="qty-cell">' . $st_rm_qty . '</span></li>';
                }
            }
        }
        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    $nghtml = '';
    if (count($nightGuardShipped)) {
        $nghtml = '<ul>';
        foreach ($nightGuardShipped as $night_product_id => $night_qty) {
            if ($night_qty > 0) {
                $nghtml .= '<li>' .  get_the_title($night_product_id) . ' <span class="qty-cell">' . $night_qty . '</span></li>';
            }
        }
        $nghtml .= '</ul>';
    }
    $twhtml = '';
    if (count($whiteningShipped)) {
        $twhtml = '<ul>';
        foreach ($whiteningShipped as $tw_product_id => $tw_qty) {
            if ($tw_qty > 0) {
                $twhtml .= '<li>' .  get_the_title($tw_product_id) . ' <span class="qty-cell">' . $tw_qty . '</span></li>';
            }
        }
        $twhtml .= '</ul>';
    }
    $dataHtml = array(
        'raw' => $html,
        'nightGuard' => $nghtml,
        'whitening' => $twhtml,
    );
    echo json_encode($dataHtml);
    die();
}


function geha_experiments_mbt($params = array())
{


    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $order_start_date = $order_start_date . ' 00:00:00';
    $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();


    $order_start_date2 = new DateTime($order_start_date);
    $order_start_date =  $order_start_date2->format('Y-m-d 00:00:00');

    $order_start_date2 = new DateTime($order_end_date);
    $order_end_date =  $order_start_date2->format('Y-m-d 23:59:59');

    $sql = "SELECT * FROM sbr_geha_experiment ";
    if ($order_start_date != '' && $order_end_date != '') {
        // $order_start_date = $order_start_date . ' 00:00:00';
        // $order_end_date = $order_end_date . ' 23:59:59';


        $order_start_date = date('Y-m-d H:i:s', strtotime($order_start_date . ' - 6 hours'));
        $order_end_date = date('Y-m-d H:i:s', strtotime($order_end_date . ' - 6 hours'));


        $sql .= " WHERE created_date BETWEEN '$order_start_date' AND '$order_end_date '";
    } else if ($order_start_date != '') {
        //    $order_start_date = $order_start_date . ' 00:00:00';
        $order_start_date = date('Y-m-d H:i:s', strtotime($order_start_date . ' - 6 hours'));
        $sql .= " WHERE created_date >= '$order_start_date'";
    } else if ($order_end_date != '') {
        //   $order_end_date = $order_end_date . ' 23:59:59';
        $order_end_date = date('Y-m-d H:i:s', strtotime($order_end_date . ' - 6 hours'));
        $sql .= " WHERE created_date =< '$order_end_date'";
    }
    // echo $sql;
    //die;
    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    // echo '<pre>';
    // print_r($order_data_results);
    // echo '</pre>';
    $gehaExperiments = array(

        'total_leads' => count($order_data_results),
        'total_leads_shipping' => 0,
        'total_leads_free' => 0,
        'shipping' => 0,
        'free' => 0,
        'total_leads_to_order' => 0,
        'abandoned_leads' => 0,
        'abandoned_shipping' => 0,
        'abandoned_free_shipping' => 0,

    );
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {
            if ($order_data['item_id'] > 0) {
                if ($order_data['variant'] == 'yes') {
                    $gehaExperiments['shipping'] = $gehaExperiments['shipping'] + 1;
                } else {
                    $gehaExperiments['free'] = $gehaExperiments['free'] + 1;
                }
            }
            if ($order_data['variant'] == 'yes') {
                $gehaExperiments['total_leads_shipping'] = $gehaExperiments['total_leads_shipping'] + 1;
            } else {
                $gehaExperiments['total_leads_free'] = $gehaExperiments['total_leads_free'] + 1;
            }
        }
        $gehaExperiments['abandoned_leads'] = count($order_data_results) -  $gehaExperiments['free']  - $gehaExperiments['shipping'];
        $gehaExperiments['abandoned_shipping'] = $gehaExperiments['total_leads_shipping'] -  $gehaExperiments['shipping'];
        $gehaExperiments['abandoned_free_shipping'] = $gehaExperiments['total_leads_free'] - $gehaExperiments['free'];
        $gehaExperiments['total_leads_to_order'] = $gehaExperiments['free'] + $gehaExperiments['shipping'];
    }


    $html = '';
    if ($gehaExperiments) {
        $html .= '<ul>';
        $html .= '<li>Total leads: ' . ' <span class="qty-cell">' . $gehaExperiments['total_leads'] . '</span></li>';
        $html .= '<li>Total leads with shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['total_leads_shipping'] . '</span></li>';
        $html .= '<li>Total leads free shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['total_leads_free'] . '</span></li>';
        $html .= '<li>TOtal abandoned leads: ' . ' <span class="qty-cell">' . $gehaExperiments['abandoned_leads'] . '</span></li>';
        $html .= '<li>Leads to order: ' . ' <span class="qty-cell">' . $gehaExperiments['total_leads_to_order'] . '</span></li>';
        $html .= '<li>Abandoned with shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['abandoned_shipping'] . '</span></li>';
        $html .= '<li>Abandoned free shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['abandoned_free_shipping'] . '</span></li>';
        $html .= '<li>Order with shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['shipping'] . '</span></li>';
        $html .= '<li>Order free shipping: ' . ' <span class="qty-cell">' . $gehaExperiments['free'] . '</span></li>';
        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    echo $html;
    die();
}

function easypost_report_mbt($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $order_start_date = $order_start_date . ' 00:00:00';
    $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();


    $searchQuery = '';
    if ($order_start_date <> '' && $order_end_date <> '') {
        $searchQuery .= " and (shipmentDate BETWEEN '" . $order_start_date . " 00:00:00' AND '" . $order_end_date . " 23:59:59') ";
    } else if ($order_start_date <> '') {
        $searchQuery .= " and (shipmentDate >= '" . $order_start_date . " 00:00:00') ";
    } else if ($order_end_date <> '') {
        $searchQuery .= " and (shipmentDate <= '" .  $order_end_date . " 23:59:59') ";
    }

    $query = "SELECT  distinct  shipment_id , shipmentCost , easyPostLabelCarrier , easyPostLabelService , shipmentState FROM  " . SB_EASYPOST_TABLE;
    ///   $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as so ON se.shipment_id=so.shipment_id";
    $query .= " WHERE 1 " . $searchQuery;
    $data_results = $wpdb->get_results($query, 'ARRAY_A');
    $html = '';
    if (count($data_results) > 0) {
        $costofUPS = 0;
        $costofUSPS = 0;
        $costofRefunded = 0;
        $noOfRShipments = 0;
        $noOfShipments = count($data_results);
        foreach ($data_results as  $shipment) {
            if ($shipment['shipmentState'] == '') {
                if ($shipment['easyPostLabelCarrier'] == 'USPS') {
                    $costofUSPS = $costofUSPS + $shipment['shipmentCost'];
                } else {
                    $costofUPS = $costofUPS + $shipment['shipmentCost'];
                }
            } else {
                $costofRefunded = $costofRefunded + $shipment['shipmentCost'];
                $noOfRShipments = $noOfRShipments + 1;
            }
        }
        $html .= '<ul>';
        $html .= '<li>Number of Shipment' . ' <span class="qty-cell">' . $noOfShipments . '</span></li>';
        $html .= '<li>Total Carrier Cost' . ' <span class="qty-cell">' . number_format($costofUSPS + $costofUPS + $costofRefunded, 2) . '$</span></li>';
        $html .= '<li>UPS Carrier Cost' . ' <span class="qty-cell">' . number_format($costofUPS, 2) . '$</span></li>';
        $html .= '<li>USPS Carrier Cost' . ' <span class="qty-cell">' . number_format($costofUSPS, 2) . '$</span></li>';
        $html .= '<li>Refunded Shipments' . ' <span class="qty-cell">' . $noOfRShipments . '</span></li>';
        $html .= '<li>Refunded Amount' . ' <span class="qty-cell">' . number_format($costofRefunded, 2) . '$</span></li>';
        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    echo $html;
    die();
}
/*
 * Upsell
 */
function total_upsell_mbt($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $order_start_date = $order_start_date . ' 00:00:00';
    $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();


    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM wp_posts P INNER JOIN wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')  AND WOIM.meta_key IN('_qty','_product_id' , '_upsell_source' , '_line_total')";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date BETWEEN '$order_start_date' AND '$order_end_date '";
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= " AND P.post_date >= '$order_start_date'";
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date =< '$order_end_date'";
    }

    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    $order_products = array();
    $upsellProducts = array();
    if ($order_data_results) {

        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == '_upsell_source') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['upsell_source'] = $order_data['meta_value'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == '_line_total') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['_line_total'] = $order_data['meta_value'];
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

                    if (isset($productsData['upsell_source'])) {
                        if ($productsData['upsell_source'] == 'cart') {
                            $cartQty = $productsData['qty'];
                            $checkoutQty = 0;

                            $cartRev = $productsData['_line_total'];
                            $checkoutRev = 0;
                        } else {
                            $cartQty = 0;
                            $checkoutQty = $productsData['qty'];
                            $cartRev = 0;
                            $checkoutRev = $productsData['_line_total'];
                        }


                        if (isset($upsellProducts[$productsData['product_id']])) {
                            $upsellProducts[$productsData['product_id']]['cart'] = $cartQty + $upsellProducts[$productsData['product_id']]['cart'];
                            $upsellProducts[$productsData['product_id']]['checkout'] = $checkoutQty +  $upsellProducts[$productsData['product_id']]['checkout'];


                            $upsellProducts[$productsData['product_id']]['cartRev'] = $cartRev + $upsellProducts[$productsData['product_id']]['cartRev'];
                            $upsellProducts[$productsData['product_id']]['checkoutRev'] = $checkoutRev +  $upsellProducts[$productsData['product_id']]['checkoutRev'];
                        } else {
                            $upsellProducts[$productsData['product_id']]['cart'] = $cartQty;
                            $upsellProducts[$productsData['product_id']]['checkout'] =  $checkoutQty;

                            $upsellProducts[$productsData['product_id']]['cartRev'] = $cartRev;
                            $upsellProducts[$productsData['product_id']]['checkoutRev'] =  $checkoutRev;
                        }
                    }
                }
            }
        }
    }

    $html = '';
    $cartRevTotal = 0;
    $checkoutRevTotal = 0;
    if ($upsellProducts) {
        $html .= '<ul>';
        foreach ($upsellProducts as $product_id => $entry) {
            $cartRevTotal = $cartRevTotal + $entry['cartRev'];
            $checkoutRevTotal = $checkoutRevTotal + $entry['checkoutRev'];


            $html .= '<li>';
            $html .= get_the_title($product_id) . ' ' . ' <span class="qty-cell">' . $entry['cart'] . '|' . $entry['checkout'] . '|' . ($entry['cart'] + $entry['checkout']) . '</span>';
            //  $html .= '<br/>Revenue ' . ' <span class="qty-cell">' . ($entry['cartRev']) . '|' . ($entry['checkoutRev'])  . '|' . ($entry['cartRev'] + $entry['checkoutRev']) . '</span>';

            $html .= '</li>';
        }

        $html .= '<li>';
        $html .= 'Total Revenue ' . ' <span class="qty-cell">$'  . number_format($cartRevTotal + $checkoutRevTotal, 2) . '</span>';
        $html .= '</li>';
        $html .= '<li>';
        $html .= 'Cart Revenue ' . ' <span class="qty-cell">$'  . number_format($cartRevTotal, 2)  . '</span>';
        $html .= '</li>';
        $html .= '<li>';
        $html .= 'Checkout Popup Revenue ' . ' <span class="qty-cell">$'  .   number_format($checkoutRevTotal, 2) . '</span>';
        $html .= '</li>';


        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    echo $html;
    die();
}
function total_upsell_mbt_back($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $order_start_date = $order_start_date . ' 00:00:00';
    $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();

    $sql = "SELECT P.post_status ,WOI.order_item_id  , WOIM.meta_key , WOIM.meta_value  , WOI.order_id FROM wp_posts P INNER JOIN wp_woocommerce_order_items as WOI ON P.ID= WOI.order_id INNER JOIN wp_woocommerce_order_itemmeta as WOIM ON WOI.order_item_id= WOIM.order_item_id where post_type='shop_order' AND  P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')  AND WOIM.meta_key IN('_qty','_product_id' , '_upsell_source')";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date BETWEEN '$order_start_date' AND '$order_end_date '";
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $sql .= " AND P.post_date >= '$order_start_date'";
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql .= " AND P.post_date =< '$order_end_date'";
    }

    $order_data_results = $wpdb->get_results($sql, 'ARRAY_A');
    $order_products = array();
    $upsellProducts = array();
    if ($order_data_results) {
        foreach ($order_data_results as $order_data) {

            if (isset($order_data['meta_key']) && $order_data['meta_key'] == '_product_id') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['product_id'] = $order_data['meta_value'];
            } elseif (isset($order_data['meta_key']) && $order_data['meta_key'] == '_upsell_source') {
                $order_products[$order_data['order_id']][$order_data['order_item_id']]['upsell_source'] = $order_data['meta_value'];
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

                    if (isset($productsData['upsell_source'])) {
                        if ($productsData['upsell_source'] == 'cart') {
                            $cartQty = $productsData['qty'];
                            $checkoutQty = 0;
                        } else {
                            $cartQty = 0;
                            $checkoutQty = $productsData['qty'];
                        }

                        if (isset($upsellProducts[$productsData['product_id']])) {
                            $upsellProducts[$productsData['product_id']]['cart'] = $cartQty + $upsellProducts[$productsData['product_id']]['cart'];
                            $upsellProducts[$productsData['product_id']]['checkout'] = $checkoutQty +  $upsellProducts[$productsData['product_id']]['checkout'];
                        } else {
                            $upsellProducts[$productsData['product_id']]['cart'] = $cartQty;
                            $upsellProducts[$productsData['product_id']]['checkout'] =  $checkoutQty;
                        }
                    }
                }
            }
        }
    }

    $html = '';
    if ($upsellProducts) {
        $html .= '<ul>';
        foreach ($upsellProducts as $product_id => $entry) {
            $html .= '<li>';
            $html .= get_the_title($product_id) . ' ' . ' <span class="qty-cell">' . $entry['cart'] . '|' . $entry['checkout'] . '|' . ($entry['cart'] + $entry['checkout']) . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    } else {
        $html .= 'no result found';
    }
    echo $html;
    die();
}
/*
 * trays info
 */
function total_tray_info_mbt($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $order_start_date = $order_start_date . ' 00:00:00';
    $order_end_date = $order_end_date . ' 23:59:59';
    $response_array = array();
    $html = '<ul>';
    $html .= '<li><b> Whitening Trays Checked In</b>' . $wpdb->get_var("SELECT COUNT(log_id)  FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='2') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN('11','10','01','00')") . '</li>';
    $html .= '<li><b> Total Whitening Upper Good</b>' . $wpdb->get_var("SELECT COUNT(log_id) FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='2') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN ('10','11')") . '</li>';
    $html .= '<li><b> Total Whitening Upper Bad</b>' . $wpdb->get_var("SELECT COUNT(log_id) FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='2') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN ('01','00')") . '</li>';
    $html .= '<li><b> Total Whitening Lower Good</b>' . $wpdb->get_var("SELECT COUNT(log_id) FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='2') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN ('01','11')") . '</li>';
    $html .= '<li><b> Total Whitening Lower Bad</b>' . $wpdb->get_var("SELECT COUNT(log_id) FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='2') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN ('10','00')") . '</li>';
    $html .= '<li><b> Night Guard Trays Checked In</b>' . $wpdb->get_var("SELECT COUNT(log_id)  FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='1') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information IN('3','4')") . '</li>';
    $html .= '<li><b> Total Night Guards Good</b>' . $wpdb->get_var("SELECT COUNT(log_id)  FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='1') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information= '4'") . '</li>';
    $html .= '<li><b> Total Night Guards Bad</b>' . $wpdb->get_var("SELECT COUNT(log_id)  FROM sb_event_log WHERE product_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key= 'impression_tray' AND meta_value='1') AND created_date BETWEEN '" . $order_start_date . "' AND '" . $order_end_date . "' AND event_id=5 AND order_id NOT IN(SELECT post_id FROM wp_postmeta WHERE meta_key = 'order_type' AND meta_value='Split') AND extra_information= '3'") . '</li>';

    echo $html .= '</ul>';
    die();
}
//add_action('wp_ajax_nopriv_total_number_of_orders_geha_rev_sbr_report','total_number_of_orders_geha_rev_sbr_report');
function total_number_of_orders_geha_rev_sbr_report($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending-payment')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost' ,  'hfa_hsa')";
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
    $hfa_hsa = 0;
    $_wc_cog_order_total_cost = 0;
    $existing_Array = array();

    $easypostCost = 0;
    $totalShipments = 0;

    $orderIds = array();
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
            $orderIds[] = $res['ID'];
            if ($res['meta_key'] == '_cart_discount') {
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == 'hfa_hsa') {
                $hfa_hsa++;
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
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



        if ($orderIds) {
            $orderIds = array_unique($orderIds);
            $easypostOrderQuery = "SELECT distinct  shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE . " WHERE order_id IN (" . implode(',', $orderIds) . ")";
            $easypostOrderShipments = $wpdb->get_col($easypostOrderQuery);
            $totalShipments = count($easypostOrderShipments);
            $easypostOrderCostQuery = "SELECT SUM(shipmentCost) FROM  " . SB_EASYPOST_TABLE . " WHERE  shipment_id IN (" . implode(',', $easypostOrderShipments) . ")  ORDER BY shipment_id DESC ";
            $easypostCost = $wpdb->get_var($easypostOrderCostQuery);
        }

        $response_array['_easypostCost'] = number_format($easypostCost, 2);
        $response_array['_totalShipments'] = $totalShipments;


        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2));
        $response_array['_order_total'] = number_format(round($_order_total, 2));
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2));
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = $counter;
        $response_array['total_geha_coupons_geerated'] = $results2;
        $response_array['total_geha_coupons_used'] = $results3;
        $response_array['hfa_hsa'] = $hfa_hsa;
    }

    echo json_encode($response_array);
    die();
}

function total_number_of_orders_non_geha_rev_sbr_report($params = array())
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    // $params = array('end_date' => '2021-10-03', 'start_date' => '2020-10-03');
    global $wpdb;
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $orderStatus = isset($params['order_status']) ? $params['order_status'] : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing', 'wc-pending-payment')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost' , 'hfa_hsa')";
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

    $easypostCost = 0;
    $totalShipments = 0;
    if ($results) {
        $orderIds = array_unique(array_column($results, 'ID'));
        $easypostOrderQuery = "SELECT distinct  shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE . " WHERE order_id IN (" . implode(',', $orderIds) . ")";
        $easypostOrderShipments = $wpdb->get_col($easypostOrderQuery);
        $totalShipments = count($easypostOrderShipments);
        $easypostOrderCostQuery = "SELECT SUM(shipmentCost) FROM  " . SB_EASYPOST_TABLE . " WHERE  shipment_id IN (" . implode(',', $easypostOrderShipments) . ")  ORDER BY shipment_id DESC ";
        $easypostCost = $wpdb->get_var($easypostOrderCostQuery);
    }

    $response_array['_easypostCost'] = number_format($easypostCost, 2);
    $response_array['_totalShipments'] = $totalShipments;

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
    $hfa_hsa = 0;
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
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == 'hfa_hsa') {
                $hfa_hsa++;
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
                //                $order = wc_get_order($res['ID']);
                //                $_order_subtotal += $order->get_subtotal();
                // $existing_Array[]=$res['ID'];
                $counter++;
            }
        }

        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2));
        $response_array['_order_total'] = number_format(round($_order_total, 2));
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2));
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = $counter;
        $response_array['hfa_hsa'] = $hfa_hsa;
    }

    echo json_encode($response_array);
    die();
}

function total_number_of_orders_geha_new_rev_sbr_report($params)
{

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
            $userEmails[] = str_replace("'", '', $order_info['meta_value']);
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
    $response_array['_easypostCost'] = 0;
    $response_array['_totalShipments'] = 0;
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

        $orderEIds = array();
        foreach ($removeDuplication as  $orderkey => $order) {
            $orderEIds[] = $orderkey;

            if (isset($order['_cart_discount']) && !empty($order['_cart_discount']) && $order['_cart_discount'] > 0) {
                $_cart_discount += (float)$order['_cart_discount'];
            }
            if (isset($order['_order_shipping']) && !empty($order['_order_shipping']) && $order['_order_shipping'] > 0) {
                $_order_shipping += (float)$order['_order_shipping'];
            }
            if (isset($order['_order_total']) && !empty($order['_order_total']) && $order['_order_total'] > 0) {
                $_order_total += (float)$order['_order_total'];
            }
            if (isset($order['_wc_cog_order_total_cost']) && !empty($order['_wc_cog_order_total_cost']) && $order['_wc_cog_order_total_cost'] > 0) {
                $_wc_cog_order_total_cost += (float)$order['_wc_cog_order_total_cost'];
            }
        }
        $easypostCost = 0;
        $totalShipments = 0;
        if ($orderEIds) {

            $easypostOrderQuery = "SELECT distinct  shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE . " WHERE order_id IN (" . implode(',', $orderEIds) . ")";
            $easypostOrderShipments = $wpdb->get_col($easypostOrderQuery);
            $totalShipments = count($easypostOrderShipments);
            $easypostOrderCostQuery = "SELECT SUM(shipmentCost) FROM  " . SB_EASYPOST_TABLE . " WHERE  shipment_id IN (" . implode(',', $easypostOrderShipments) . ")  ORDER BY shipment_id DESC ";
            $easypostCost = $wpdb->get_var($easypostOrderCostQuery);
        }
        $response_array['_easypostCost'] = number_format($easypostCost, 2);
        $response_array['_totalShipments'] = $totalShipments;

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
    echo json_encode($response_array);
    die();
}

function total_number_of_orders_geha_exsiting_rev_sbr_report($params)
{

    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;

    $order_start_date = isset($params['start_date']) ? $params['start_date'] : '';
    $order_end_date = isset($params['end_date']) ? $params['end_date'] : '';

    $sql = "select  P.ID , PM.meta_key , PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id INNER JOIN wp_postmeta as PM2 ON P.ID=PM2.post_id where post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing','wc-pending-payment') AND PM.meta_key='_billing_email'";

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
    $sql2 = '';
    if (!empty($userEmails)) {
        $sql2 = "SELECT meta_value FROM wp_postmeta WHERE meta_key='_billing_email' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
        $sql2 .= "GROUP BY meta_value HAVING COUNT(*) > 1;";
    }

    if (!empty($sql2)) {
        $matchEmailsCounters = $wpdb->get_col($sql2);
    } else {
        // Handle the case when $userEmails is empty
        $matchEmailsCounters = array(); // or whatever appropriate action
    }

    // $sql2 = " SELECT meta_value FROM wp_postmeta where  meta_key='_billing_email' AND meta_value IN (" . implode(',', array_map('sbr_quote', $userEmails)) . ") ";
    // $sql2 .= 'GROUP BY meta_value HAVING COUNT(*) > 1;';

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
        //     echo '<pre>' .print_r($order_data,true). '</pre>';

        $removeDuplication = array();
        foreach ($order_data as $res) {

            $removeDuplication[$res['post_id']][$res['meta_key']] = $res['meta_value'];
        }
        $orderEIds = array();
        foreach ($removeDuplication as  $orderkey => $order) {
            $orderEIds[] = $orderkey;
            if (isset($order['_cart_discount']) && !empty($order['_cart_discount']) && $order['_cart_discount'] > 0) {
                $_cart_discount += (float)$order['_cart_discount'];
            }
            if (isset($order['_order_shipping']) && !empty($order['_order_shipping']) && $order['_order_shipping'] > 0) {
                $_order_shipping += (float)$order['_order_shipping'];
            }
            if (isset($order['_order_total']) && !empty($order['_order_total']) && $order['_order_total'] > 0) {
                $_order_total += (float)$order['_order_total'];
            }
            if (isset($order['_wc_cog_order_total_cost']) && !empty($order['_wc_cog_order_total_cost']) && $order['_wc_cog_order_total_cost'] > 0) {
                $_wc_cog_order_total_cost += (float)$order['_wc_cog_order_total_cost'];
            }
        }
        $easypostCost = 0;
        $totalShipments = 0;
        if ($orderEIds) {

            $easypostOrderQuery = "SELECT distinct  shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE . " WHERE order_id IN (" . implode(',', $orderEIds) . ")";
            $easypostOrderShipments = $wpdb->get_col($easypostOrderQuery);
            $totalShipments = count($easypostOrderShipments);
            $easypostOrderCostQuery = "SELECT SUM(shipmentCost) FROM  " . SB_EASYPOST_TABLE . " WHERE  shipment_id IN (" . implode(',', $easypostOrderShipments) . ")  ORDER BY shipment_id DESC ";
            $easypostCost = $wpdb->get_var($easypostOrderCostQuery);
        }
        $response_array['_easypostCost'] = number_format($easypostCost, 2);
        $response_array['_totalShipments'] = $totalShipments;
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
    echo json_encode($response_array);
    die();
}

function total_number_of_orders_rev_sbr_report($params)
{
    if (!is_array($params) || empty($params)) {
        $params = $_POST;
    }
    global $wpdb;
    $order_type = isset($params['order_type']) ? $params['order_type'] : '';
    $shipping_state = isset($params['shipping_state']) ? $params['shipping_state'] : '';
    $order_start_date = isset($params['start_date']) ? date('Y-m-d', strtotime($params['start_date'])) : '';
    $order_end_date = isset($params['end_date']) ? date('Y-m-d', strtotime($params['end_date'])) : '';
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing','wc-pending-payment') AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost' , 'hfa_hsa')";
    $sql2 = "select IFNULL(SUM(PM.meta_value),0) as refunds from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order' AND P.post_status = 'wc-refunded' AND PM.meta_key = '_order_total' ";
    
    $joinSql = "";
    if ($order_start_date != '' && $order_end_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $joinSql .= ' AND P.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';        
    } else if ($order_start_date != '') {
        $order_start_date = $order_start_date . ' 00:00:00';
        $joinSql .= ' AND P.post_date >= "' . $order_start_date . '"';        
    } else if ($order_end_date != '') {
        $order_end_date = $order_end_date . ' 23:59:59';
        $joinSql .= ' AND P.post_date =< "' . $order_end_date . '"';
    }

    if($shipping_state){
        $sql .= " {$joinSql} AND P.ID IN (select P.ID from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order' AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing','wc-pending-payment') AND PM.meta_key = '_shipping_state' AND PM.meta_value = '" . $shipping_state . "' {$joinSql}) ";
        $sql2 .= " {$joinSql} AND P.ID IN (select P.ID from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order' AND P.post_status = 'wc-refunded' AND PM.meta_key = '_shipping_state' AND PM.meta_value = '" . $shipping_state . "' {$joinSql}) ";
    }else{
        $sql .= $joinSql;
        $sql2 .= $joinSql;
    }

    $easypostCost = 0;
    $totalShipments = 0;
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $refunds = $wpdb->get_var($sql2);
    if ($results) {

        $orderIds = array_unique(array_column($results, 'ID'));
        $easypostOrderQuery = "SELECT distinct  shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE . " WHERE order_id IN (" . implode(',', $orderIds) . ")";
        $easypostOrderShipments = $wpdb->get_col($easypostOrderQuery);
        $totalShipments = count($easypostOrderShipments);
        $easypostOrderCostQuery = "SELECT SUM(shipmentCost) FROM  " . SB_EASYPOST_TABLE . " WHERE  shipment_id IN (" . implode(',', $easypostOrderShipments) . ")  ORDER BY shipment_id DESC ";
        $easypostCost = $wpdb->get_var($easypostOrderCostQuery);
    }
    $response_array = array();
    $response_array['_easypostCost'] = number_format($easypostCost, 2);
    $response_array['_totalShipments'] = $totalShipments;
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
    $response_array['_refunds'] = 0;
    $response_array['query'] = $sql;
    $_order_total = 0;
    $_cart_discount = 0;
    $_order_shipping = 0;
    $_order_subtotal = 0;
    $hfa_hsa = 0;
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
                $_cart_discount += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_order_shipping') {
                $_order_shipping += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == '_wc_cog_order_total_cost') {
                $_wc_cog_order_total_cost += (float)$res['meta_value'];
            }
            if ($res['meta_key'] == 'hfa_hsa') {
                $hfa_hsa++;
            }
            if ($res['meta_key'] == '_order_total') {
                $_order_total += (float)$res['meta_value'];
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
        $response_array['_order_shipping'] = number_format(round($_order_shipping, 2));
        $response_array['_cart_discount'] = number_format(round($_cart_discount, 2));
        $response_array['_order_total'] = number_format(round($_order_total, 2));
        $response_array['_order_subtotal'] = number_format(round($subtotal, 2));
        $response_array['_order_revenue'] = number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2));
        $response_array['_order_revenue_today'] = $today_rev;
        $response_array['hfa_hsa'] = $hfa_hsa;
        $response_array['_order_revenue_weekly'] = $weekly_rev;
        $response_array['_order_revenue_monthally'] = $monthly_rev;
        $response_array['_refunds'] = number_format(round($refunds, 2));
        $response_array['_gross_margin'] = round(gross_margin_mbt($subtotal, $_wc_cog_order_total_cost, $_cart_discount), 2);
        $response_array['total_orders'] = $counter;
    }

    echo json_encode($response_array);
    die();
}

function total_revenue_by_date_mbt($order_start_date, $order_end_date, $order_type)
{

    global $wpdb;
    $sql = "select P.ID,PM.meta_key,PM.meta_value from wp_posts as P INNER JOIN wp_postmeta as PM ON P.ID=PM.post_id where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing','wc-pending-payment')AND PM.meta_key IN('_order_total','_order_shipping','_cart_discount','_wc_cog_order_total_cost')";
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
                //$existing_Array[]=$res['ID'];
                //$order = new WC_Order($res['ID']);
                //$_order_subtotal += $order->get_subtotal();
                $counter++;
            }
        }
        $subtotal = round($_order_total + $_cart_discount) - $_order_shipping;
        $subtotal = round($subtotal, 2);
        return number_format(round(calculate_revenue_mbt($subtotal, $_cart_discount), 2));
    }
}

function calculate_revenue_mbt($total_price, $total_discount)
{


    if ($total_price == '') {
        return 0;
    }
    $revenue = $total_price - $total_discount;
    if ($revenue <= 0) {
        $revenue = 0;
    }
    return $revenue;
}

function gross_margin_mbt($subtotal, $Cost, $discount)
{
    $rev_mbt = $subtotal - $discount - $Cost;
    $rev_mbt2 = $subtotal - $discount;
    if ($rev_mbt2 <= 0) {
        return 0;
    }
    return $percentage_gross_margin = ($rev_mbt / $rev_mbt2) * 100;
}

add_action('wp_ajax_get_allreportsdata', 'get_allreportsdata');

function get_allreportsdata()
{
    global $wpdb;
    // print_r($_POST);

    $order_start_date = isset($_POST['start_date']) ? date('Y-m-d', strtotime($_POST['start_date'])) : '';
    $order_end_date = isset($_POST['end_date']) ? date('Y-m-d', strtotime($_POST['end_date'])) : '';
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    if ($product_id != '') {

        $order_start_date = $order_start_date . ' 00:00:00';
        $order_end_date = $order_end_date . ' 23:59:59';
        $sql = 'SELECT * FROM wp_postmeta WHERE meta_key="_customer_user" AND post_id IN
(SELECT order_id FROM wp_woocommerce_order_items INNER JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id=wp_woocommerce_order_itemmeta.order_item_id 
INNER JOIN wp_posts ON wp_woocommerce_order_items.order_id = wp_posts.ID WHERE wp_posts.post_date BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"
AND wp_woocommerce_order_itemmeta.meta_key="_product_id" AND wp_woocommerce_order_itemmeta.meta_value IN("' . $product_id . '") AND wp_posts.post_status IN ("wc-completed" , "wc-partial_ship" , "wc-shipped" , "wc-on-hold" , "wc-processing","wc-pending-payment")  )';
        $results = $wpdb->get_results($sql, 'ARRAY_A');
        $reportData = array();
        $reportData[0] = array('SBR-Number', 'Email', 'phone', 'First Name', 'Last name', 'City', 'State', 'PostCode', 'Country', 'Created', 'Qty');
        $content = '<a style="float:right" class="btn button" href="javascript:void(0); onclick=exportTableToExcel(\'download-rep\',\'' . get_the_title($product_id) . '\');"> Download Excel</a><table id="download-rep" style="width:100%" border="1px">';

        foreach ($results as $rr) {

            $order_id = $rr['post_id'];
            $order = wc_get_order($order_id);

            $reportData[$order_id] = array(
                'sbr_number' => get_post_meta($order_id, 'order_number', true),
                'email' => $order->get_billing_email(),
                'phone' => $order->get_billing_phone(),
                'first_name' => $order->get_billing_first_name(),
                'last_name' => $order->get_billing_last_name(),
                'city' => $order->get_billing_city(),
                'state' => $order->get_billing_state(),
                'postcode' => $order->get_billing_postcode(),
                'country' => $order->get_billing_country(),
                'created' => sbr_datetime($order->get_date_created()->date("F j, Y, g:i:s A T"))
            );

            // Get and Loop Over Order Items
            foreach ($order->get_items() as $item_id => $item) {
                $product_idd = $item->get_product_id();
                if ($product_id == $product_idd) {
                    $reportData[$order_id]['qty'] = $item->get_quantity();
                    break;
                }
            }

            //   $user_id = $rr['meta_value'];

        }
        //    print_r($reportData);
        $counter = 0;
        foreach ($reportData as $key => $geh) {
            if ($counter == 0) {
                $row_item = 'h';
            } else {
                $row_item = 'd';
            }
            $content .= '<tr>';
            if ($counter == 0) {
                foreach ($geh as $dt) {
                    $content .= '<t' . $row_item . '>' . $dt . '</td>';
                }
            } else {
                // Modify these to match the database structure
                $content .= '<t' . $row_item . '>' . $geh["sbr_number"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["email"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["phone"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["first_name"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["last_name"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["city"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["state"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["postcode"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["country"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["created"] . '</td>';
                $content .= '<t' . $row_item . '>' . $geh["qty"] . '</td>';
            }
            $content .= '</tr>';
            $counter++;
        }
        echo $content .= '<table>';
        die();

        $filePath = get_home_path() . get_the_title($product_id) . '.csv';
        $fp = fopen($filePath, 'w');
        foreach ($reportData as $line) {
            print_r($line);
            // $val = explode(",", $line);
            fputcsv($fp, $line);
        }
        fclose($fp);
    }
    die();
}
