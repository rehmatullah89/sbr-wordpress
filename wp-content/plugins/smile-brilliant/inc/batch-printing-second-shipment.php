<?php

use Dompdf\Dompdf;

add_action('wp_ajax_createOrderSecondShipment', 'createOrderSecondShipment_callback');
/**
 * AJAX callback function for creating a second shipment for an order from batch print page.
 *
 * @return void Outputs a JSON-encoded response containing information about the second shipment.
 */
function createOrderSecondShipment_callback()
{
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '' && get_post_type($_REQUEST['order_id']) == 'shop_order') {
        try {
            $response = orderEasyPostSecondShipmentRequest($_REQUEST['order_id']);
        } catch (Exception $e) {

            $response = array(
                'products' => '<ul class="print_product" ><li>---</li></ul>',
                'code' => 'error',
                'msg' => 'Something went wrong.'
            );
        }
    } else {
        $response = array(
            'products' => '<ul class="print_product" ><li>---</li></ul>',
            'code' => 'error',
            'msg' => 'No record found against this order.'
        );
    }
    echo json_encode($response);
    die;
}
/**
 * AJAX callback function for creating a first shipment for an order.
 *
 * @return void Outputs a JSON-encoded response containing information about the first shipment.
 */
function orderEasyPostSecondShipmentRequest($order_id)
{

    $createdBatchRequest = array();
    $reloadOption = false;
    $response = array();
    //ASSEMBLE OUR INSERT ARRAY
    $insertArray = array();

    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
  
    // require_once("dompdf/autoload.php");
    require_once("dompdfkami/autoload.inc.php");
    global $MbtPackaging, $wpdb;
    $order = wc_get_order($order_id);

    /*     * ************* */
    $customer_id = $order->get_user_id();
    $matchingOrders = get_posts(array(
        'numberposts' => -1,
        'fields' => 'ids',
        'post_type' => 'shop_order',
        'post_status' => array('wc-processing', 'wc-partial_ship', 'wc-on-hold'),
        'exclude' => array($order_id),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_customer_user',
                'compare' => '=',
                'value' => $customer_id,
            ),
        )
    ));

    if (is_array($matchingOrders) && count($matchingOrders) > 0) {
        $response = array(
            'products' => '<ul class="print_product" ><li>Not applicable because there are multiple active orders from this customer.</li></ul>',
            'code' => 'error',
            'redirect_url' => admin_url('admin.php?page=add_shipment&shipment_order=' . $order_id),
            'errorCode' => 51,
            'msg' => 'Order(s) going to the same Customer/Address found for shipment'
        );
        return ($response);
        die;
    }
    /* ============== */


    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $flagOrderStatus = false;
    foreach ($order->get_items() as $item_id => $item) {
        $log_visible = false;
        if (wc_cp_get_composited_order_item_container($item, $order)) {
            /* Composite Prdoucts Child Items */
        } else if (wc_cp_is_composite_container_order_item($item)) {
            /* Composite Prdoucts Parent Item */
            $log_visible = true;
        } else {
            $log_visible = true;
        }
        if ($log_visible) {

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

            if ($getRemainingQuantity) {
                $flagOrderStatus = true;
            }
        }
    }


    $readyToShipOrderItem = array();
    foreach ($order->get_items() as $item_id => $item) {
        if (wc_cp_get_composited_order_item_container($item, $order)) {
            /* Composite Prdoucts Child Items */
            continue;
        }

        $product = $item->get_product();
        $product_id = $item->get_product_id();

        $query = "SELECT event_id FROM  " . SB_LOG;
        $query .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
        $query .= " ORDER BY log_id DESC";
        $query_q0 = $wpdb->get_var($query);
        if ($query_q0 == 17) {
            continue;
        }



        $product_price = $product->get_price();
        // $item_quantity = $item->get_quantity(); // Get the item quantity
        /*
        if ($product->get_type() == 'composite') {
            $weight = get_post_meta($product_id, '_first_shipment_weight', true);
        } else {
            $weight = get_post_meta($product_id, '_weight', true);
        }
        */
        $weight = get_post_meta($product_id, '_first_shipment_weight', true);
        if (empty($weight)) {
            $weight = get_post_meta($product_id, '_weight', true);
        }

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

        if ($getRemainingQuantity) {
            $productDetail = array(
                'price' => $product_price,
                'type' => 'simple',
                'shipment' => 2,
                'product_id' => $product_id,
                'weight' => $weight,
                'qty' => $getRemainingQuantity,
            );

            $threeWay = get_post_meta($product_id, 'three_way_ship_product', true);
            if ($threeWay == 'yes') {
                $productDetail['type'] = 'composite';
            }

            if (@trim($weight)) {
            } else {
                $error_log[] = get_the_title($product_id) . " weight missing.";
            }

            $readyToShipOrderItem[$item_id] = $productDetail;
        }
    }

    $customs_items = array();
    $customs_info = false;
    $curItemsArray = array();
    $updatedOrderItem = array();
    $productDuplicate_array = array();
    $allOrderIds = array();
    $allShipProductsWeight = 0;
    $validationInCompleteOrder = true;
    $productsQtyShipmentLevel = array();
    $trayData = array();
    if (is_array($readyToShipOrderItem) && count($readyToShipOrderItem) > 0) {



        foreach ($readyToShipOrderItem as $item_id => $productDetail) {
            if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
                $product_id = $productDetail['product_id'];
                $qty = $productDetail['qty'];
                $level = 2;
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


        foreach ($readyToShipOrderItem as $item_id => $productDetail) {
            if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
                $product_id_val = $productDetail['product_id'];
                $product_qty_val = $productDetail['qty'];
                $product_price_val = $productDetail['price'];
                $product_weight = $productDetail['weight'];
                if (validateSecondShipmentLogs($order_id, $item_id, $product_id_val)) {
                } else {
                    $validationInCompleteOrder = false;
                    //break;
                }
                $updatedOrderItem[$item_id] = $productDetail;

                if ($productDetail['type'] == 'composite') {
                    $product_price_val = 20;
                } else {
                    $product_price_val = $productDetail['price'];
                }

                if (isset($productDuplicate_array[$product_id_val])) {

                    $productPreviousQty = $productDuplicate_array[$product_id_val]['qty'] + $product_qty_val;
                    $productPreviousWeight = $productDuplicate_array[$product_id_val]['weight'] + ($product_qty_val * $product_weight);
                    $productPreviousPrice = $productDuplicate_array[$product_id_val]['price'] + ($product_qty_val * $product_price_val);

                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $productPreviousQty,
                        'price' => $productPreviousPrice,
                        'weight' => $productPreviousWeight
                    );
                } else {
                    $weight = (is_numeric($product_weight) ? (float)$product_weight : 0.0);

                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $product_qty_val,
                        'price' => ($product_qty_val * $product_price_val),
                        'weight' => ((int)$product_qty_val * $weight),
                    );
                    /*
                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $product_qty_val,
                        'price' => ($product_qty_val * $product_price_val),
                        'weight' => ($product_qty_val * $product_weight),
                    );
                    */
                }
            }
        }
    } else {
        $response = array(
            'products' => '<ul class="print_product" ><li>---</li></ul>',
            'code' => 'error',
            'errorCode' => 1,
            'msg' => 'No product found for shipment'
        );
        return ($response);
    }


    if ($validationInCompleteOrder == false) {
        $response = array(
            'products' => '<ul class="print_product" ><li>---</li></ul>',
            'code' => 'error',
            'errorCode' => 1,
            'msg' => 'The items in the order are not in a state that is suitable for generating the shipment. Please check the order item states.'
        );
        return ($response);
    }
    $productLog = '';
    if (count($updatedOrderItem) > 0) {
        $productLog = '<ul class="product-list">';
        foreach ($updatedOrderItem as $itmId => $products_log) {
            $three_way_ship_product = get_post_meta($products_log['product_id'], 'three_way_ship_product', true);

            if ($three_way_ship_product) {
                $tray_q = "SELECT tray_number FROM  " . SB_ORDER_TABLE;
                $tray_q .= " WHERE item_id = " . $itmId . " AND product_id = " . $products_log['product_id'];
                $tray_query = $wpdb->get_var($tray_q);
                if (@$tray_query) {
                    $trayData[@$tray_query] = @$tray_query;
                    $tray_html = '<h3 class="traynumber2ndbatch"><span>Tray : </span>' . $tray_query . '</h3>';
                }
            }
            $productLog .= '<li><a href="' . get_edit_post_link($products_log['product_id']) . '"  target="_blank" >' . get_the_title($products_log['product_id']) . ' </a> <span class="crossQty">X</span> ' . $products_log['qty'] . $tray_html . '</li>';
            //$productLog .= '<li>'. get_the_title($products_log['product_id']).' * '.$products_log['qty'].'</li>';
        }
        $productLog .= '</ul>';
    }
    if ($flagOrderStatus) {
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "shipment_id" => 0,
                "order_id" => $order_id,
                "order_number" => $orderSBRref,
                "product_ids" => json_encode($updatedOrderItem),
                "status" => 0,
            );
            addPrintOrderLog($addPrintOrders);
        }
    } else {
        $response = array(
            'products' => $productLog,
            'code' => 'error',
            'errorCode' => 3,
            'msg' => 'Already Shipped'
        );

        return ($response);
    }
    if (count($updatedOrderItem) < 1) {
        $response = array(
            'products' => $productLog,
            'code' => 'error',
            'errorCode' => 2,
            'msg' => 'No product qty found to shipment'
        );
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "shipment_id" => 0,
                "order_id" => $order_id,
                "product_ids" => json_encode($updatedOrderItem),
                "status" => $response['errorCode'],
            );
            addPrintOrderLog($addPrintOrders);
        }
        return ($response);
    }


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
    $company = $order->get_shipping_company();
    if (empty($country)) {
        $company = $order->get_billing_company();
    }


    $error_log = array();
    //address requireements
    if (@trim($fname) == "") {
        $error_log[] = "The shipping first name is required.";
    }
    if (@trim($lname) == "") {
        $error_log[] = "The shipping last name is required.";
    }
    if (@trim($address1) == "") {
        $error_log[] = "The shipping address is required.";
    }
    if (@trim($city) == "") {
        $error_log[] = "The shipping city is required.";
    }
    if (@trim($zipcode) == "") {
        $error_log[] = "The shipping postal code is required.";
    }
    if (@trim($state) == "") {
        $error_log[] = "The shipping state is required.";
    }
    if (@trim($country) == "") {
        $error_log[] = "The shipping country is required.";
    }
    $shipping_method_id = 0;
    foreach ($order->get_items('shipping') as $item_id => $item) {
        $shipping_method_id = $item->get_instance_id(); // The method ID
    }

    if($shipping_method_id == 24){
        $error_log[] = "Order shipping method is Local pickup.";
    }

    $length = "";
    $width = "";
    $height = "";
    $parcelProductsWeight = "";

    $insertArray['userId'] = get_current_user_id();
    $insertArray['shipmentMethod'] = getShipmentCarrierLabel($shipping_method_id);
    $insertArray['shipmentNotes'] = '';
    $insertArray['shipmentDate'] = date("Y-m-d H:i:s");
    $insertArray['batchIdShipment'] = 0;

    //$insertArray['shiptoCompany'] = @trim($_POST['shiptoCompany']);
    $insertArray['shiptoFirstName'] = $fname;
    $insertArray['shiptoLastName'] = $lname;
    //$insertArray['shiptoAddress'] = $address1 . ' ' . $address2;
    $insertArray['shiptoAddress'] = $address1;
    $insertArray['shiptoAptNo'] = $address2;
    $insertArray['shiptoCompany'] = $company;
    $insertArray['shiptoCountry'] = $country;
    $insertArray['shiptoCity'] = $city;
    $insertArray['shiptoState'] = $state;
    $insertArray['shiptoPostalCode'] = $zipcode;
    $insertArray['shiptoPhone'] = $phone;
    $insertArray['shiptoEmail'] = $email;

    // $insertArray['shiptoContentsType'] = @trim($_POST['shiptoContentsType']);
    // $insertArray['shiptoTariffCode'] = @trim($_POST['shiptoTariffCode']);
    // $insertArray['shiptoTariffCode'] = $_REQUEST['shiptoTariffCode'];

    $_REQUEST['shipmentLabelMethod'] = getShipmentCarrierLabel($shipping_method_id);
    $_REQUEST['shiptoContentsType'] = 'merchandise';
    $_REQUEST['shiptoTariffCode'] = '850.98.000';

    $insertArray['shipmentLabelMethod'] = getShipmentCarrierLabel($shipping_method_id);
    $insertArray['shiptoContentsType'] = 'merchandise';
    $insertArray['shiptoTariffCode'] = '850.98.000';

    $_POST['shipmentLabelShipDate'] = date("Y-m-d");
    $insertArray['easyPostLabelDate'] = date("Y-m-d", strtotime(@trim($_POST['shipmentLabelShipDate'] . " 12:00:00")));

    //saturday delivery handling
    if (@trim($_POST['shipmentLabelSaturdayDelivery']) == "1") {
        //pass bool
        $insertArray['easyPostLabelSaturdayDelivery'] = true;
    } else {
        $insertArray['easyPostLabelSaturdayDelivery'] = false;
    }


    //parse the date
    $labelDate = date("Y-m-d", strtotime(@trim($_POST['shipmentLabelShipDate']) . " 12:00:00")) . "T12:00:00-07";

    //IF THIS IS AN INTERNATIONAL SHIPMENT, WE HAVE TO CREATE OUR CUSTOMS THINGS

    /*
      $productsWithQty = array();
      foreach ($productDuplicate_array as $productId => $productContent) {
      $productsWithQty[$productId] = $productContent['qty'];
      }
     */
    // echo 'Data: <pre>' . print_r($productsWithQty, true) . '</pre>';
    //
    //      echo 'Data: <pre>' .print_r($productsWithQty,true). '</pre>';
    //      die;
    $package_detail = $MbtPackaging->get_package_ids_for_basket($productsQtyShipmentLevel);
    //echo 'Data: <pre>' . print_r($package_detail, true) . '</pre>';
    //die;
    $shipment_package_id = 0;
    $packageCreateUrl = 0;
    $combinationHtml = 0;
    if (isset($package_detail['status']) && $package_detail['status'] == 1) {
        $shipment_package_id = $package_detail['package_id'];
        $package_info = $MbtPackaging->get_package_info_for_shipping($package_detail['package_id']);

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
                $parcelProductsWeight = $package_info['weight'];
            }
        }
        $insertArray['packageId'] = $shipment_package_id;
        //$shipment_package_id = 0;
    } else {
        $reloadOption = true;
        if (isset($package_detail['combinations'])) {
            $packageNamebyId = array();
            $get_all_packages = $MbtPackaging->get_all_packages();
            foreach ($get_all_packages as $key => $package) {
                $packageNamebyId[$package->id] = $package->name;
            }
            $combinationHtml = createDuplicateCombinationHtml($packageNamebyId, $package_detail);
            $error_log[] = "WARNING! Multiple shipment package combinations detected against this order. Please select one and remove ALL extra package combinations. To proceed close this box and open the order detail page in a new TAB. Then click create shipment button from there. From there you can remove all extra combinations.";
        } else {

            $error_log[] = "The package plan is required.";
            if (count($productsQtyShipmentLevel) > 0) {
                foreach ($productsQtyShipmentLevel as $key => $urlData) {
                    $QueryForNotFoundPackage .= '&product[' . $key . ']=' . $urlData['product_id'];
                    $QueryForNotFoundPackage .= '&qty[' . $key . ']=' . $urlData['qty'];
                    $QueryForNotFoundPackage .= '&level[' . $key . ']=' . $urlData['level'];
                }
            }
            $packageCreateUrl = $QueryForNotFoundPackage;
        }
        /*
        $QueryForNotFoundPackage = '';
        $error_log[] = "The package plan is required.";
        if (count($productsQtyShipmentLevel) > 0) {
            foreach ($productsQtyShipmentLevel as $key => $urlData) {
                $QueryForNotFoundPackage .= '&product[' . $key . ']=' . $urlData['product_id'];
                $QueryForNotFoundPackage .= '&qty[' . $key . ']=' . $urlData['qty'];
                $QueryForNotFoundPackage .= '&level[' . $key . ']=' . $urlData['level'];
            }
        }
        $packageCreateUrl = $QueryForNotFoundPackage;
        */
    }

    if ($insertArray['packageId']) {
        //make sure we provided label specs
        if (@trim($length) == "") {
            $error_log[] = "The length of the label (inches) is missing.";
        }
        if (@trim($width) == "") {
            $error_log[] = "The width of the label (inches) is missing.";
        }
        if (@trim($height) == "") {
            $error_log[] = "The height of the label (inches) is missing.";
        }
        if (@trim($parcelProductsWeight) == "") {
            $error_log[] = "The weight of the label (ounces) is missing.";
        }
    }



    //if international we require the contents
    if ($country != "US") {
        if (@trim($_REQUEST['shiptoContentsType']) == "") {
            $error_log[] = "The shipment content type is missing (required for international shipments).";
        }
        if (@trim($_REQUEST['shiptoTariffCode']) == "") {
            // $error_log[] = "The shipment content tariff code is missing (required for international shipments).";
        }
    }


    if (count($error_log) > 0) {
        $htmlError = '<ul class="error-list">';
        foreach ($error_log as $error_item) {
            $htmlError .= '<li>' . $error_item . '</li>';
        }

        $htmlError .= '</ul>';
        $response = array(
            'products' => $productLog,
            'reload' => $reloadOption,
            'packageId' => $shipment_package_id,
            'combinationHtml' => $combinationHtml,
            'packageUrl' => $packageCreateUrl,
            'code' => 'error',
            'errorCode' => 4,
            'msg' => $htmlError
        );
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "order_id" => $order_id,
                "status" => $response['errorCode'],
                "response" => $response['msg'],
            );
            addPrintOrderLog($addPrintOrders);
        }
        return ($response);
    }


    //NOW CREATE OUR SHIPMENT
    $shipmentOptions = array(
        'label_date' => $labelDate,
        'currency' => 'USD',
        'print_custom_1' => 'Second Shipment',
        //  'delivery_confirmation' => @trim($_POST['shipmentLabelSignatureConfirmation']),
        'saturday_delivery' => $insertArray['easyPostLabelSaturdayDelivery'],
    );

    if (count($trayData) > 0) {
        $shipmentOptions['print_custom_2'] = "T: " . implode(", ", $trayData);
    }
    if ($shipping_method_id == 8) {
        $shipmentOptions['delivery_confirmation'] = 'SIGNATURE';
    }
    $allShipProductsValue = 0;
    try {
        foreach ($productDuplicate_array as $productId => $productContent) {
            if($productId == SHIPPING_PROTECTION_PRODUCT || in_array($productId, VIRTUAL_PRODUCTS)){
                continue;
            }
            $product_title = get_post_meta($productId, 'product_short_name', true);
            if ($product_title == '') {
                $product_title = get_the_title($productId);
            }
            $product_title = html_entity_decode($product_title);
            $curItemArray = array(
                "description" => strip_tags($product_title),
                "quantity" => $productContent['qty'],
                "weight" => @round(@trim($productContent['weight']), 2),
                "value" => @round(@trim($productContent['price']), 2),
                "hs_tariff_number" => get_field('shiptoTariffCode', $productId),
                "currency" => "USD",
                "origin_country" => 'US'
            );
            $allShipProductsWeight = $allShipProductsWeight + @round(@trim($productContent['weight']), 2);
            $allShipProductsValue = $allShipProductsValue + @round(@trim($productContent['price']), 2);
            //  if ($country != "US") {
            array_push($curItemsArray, $client->customsItem->create($curItemArray));
            // }
        }
        $customs_info = $client->customsInfo->create(array(
            "eel_pfc" => 'NOEEI 30.37(a)',
            "customs_certify" => true,
            "customs_signer" => 'Salman Shah',
            "contents_type" => $insertArray['shiptoContentsType'],
            "contents_explanation" => '',
            "restriction_type" => 'none',
            "non_delivery_option" => 'return',
            "customs_items" => $curItemsArray
        ));
    } catch (Exception $e) {

        $response = array(
            'products' => $productLog,
            'code' => 'error',
            'errorCode' => 5,
            'msg' => "An error was returned from our Custom Item service, please show this to the administrator: " . htmlspecialchars($e->getMessage()),
        );
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "order_id" => $order_id,
                "status" => $response['errorCode'],
                "response" => $response['msg'],
            );
            addPrintOrderLog($addPrintOrders);
        }
        return ($response);
    }

    try {

        $insertArray['shiptoContentsValue'] = @trim($allShipProductsValue);

        if ($orderSBRref == "") {
            $orderSBRref = $order_id;
        }

        // $insertArray['order_id'] = $order_id;
        $insertArray['reference'] = $orderSBRref;
        $insertArray['packageLength'] = @trim($length);
        $insertArray['packageWidth'] = @trim($width);
        $insertArray['packageHeight'] = @trim($height);
        $insertArray['packageWeight'] = @trim(($parcelProductsWeight + $allShipProductsWeight));
        // if ($email == 'Tripacer09D@gmail.com') {
        //     $email = 'tripacer09d@gmail.com';
        // }
        $shipmentData = array(
            'options' => $shipmentOptions,
            'is_return' => false,
            //'carrier_accounts' => $carrier_accounts,
            "reference" => $orderSBRref,
            "to_address" => array(
                'name' => $fname . ' ' . $lname,
                'street1' => $address1,
                'street2' => $address2,
                'company' => $company,
                'city' => $city,
                'state' => $state,
                'zip' => $zipcode,
                'country' => $country,
                'phone' => $phone,
                'email' => $email
            ),
            "from_address" => smile_brillaint_from_address(),
            "parcel" => array(
                "length" => $length,
                "width" => $width,
                "height" => $height,
                "weight" => ($parcelProductsWeight + $allShipProductsWeight)
            ),
            'customs_info' => $customs_info,
            //'service' => $_REQUEST['shipmentLabelService'],
        );
        // if ($insertArray['shipmentMethod'] != 'USPS') {
        $shipmentData['carrier_accounts'] = get_easypostCarrierAccounts($insertArray['shipmentMethod']);
        // }
        $shipment =  $client->shipment->create($shipmentData);
        //  $shipment_id = $shipment->id;
    } catch (Exception $e) {

        $response = array(
            'products' => $productLog,
            'code' => 'error',
            'errorCode' => 6,
            'msg' => "An error was returned from our label generation service, please show this to the administrator: " . htmlspecialchars($e->getMessage()),
        );
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "order_id" => $order_id,
                "status" => $response['errorCode'],
                "response" => $response['msg'],
            );
            addPrintOrderLog($addPrintOrders);
        }
        return ($response);
    }
    //if we have a successful shipment
    if (@$shipment->id != "") {
        //by default, grab the lowest rate of the selected class
        $selectedRate = false;
        try {
            //if ($insertArray['shipmentMethod'] == "USPS") {
         //  $selectedRate = $shipment->lowest_rate($insertArray['shipmentMethod']);
            // }
            $selectedRate=false;
        } catch (Exception $e) {
            $response = array(
                'products' => $productLog,
                'code' => 'error',
                'errorCode' => 7,
                'msg' => "It appears that the label generation service did not find any rates.  This normally occurs due to an address error - please check to make sure the address for this customer is correct and try again.  Below is the error message from our label generation service: " . htmlspecialchars($e->getMessage()),
            );
            if (isset($_REQUEST['request_id'])) {
                $addPrintOrders = array(
                    "print_request_id" => $_REQUEST['request_id'],
                    "order_id" => $order_id,
                    "status" => $response['errorCode'],
                    "response" => $response['msg'],
                );
                addPrintOrderLog($addPrintOrders);
            }
            return ($response);
        }


        if ($shipping_method_id) {
            $flagSelected = false;
            $shipmentMethodAutoSelect = selectEasyPostMethodByOrderMethod($shipping_method_id, $insertArray['shipmentMethod']);
            // $shipmentMethodAutoSelect = selectEasyPostMethodByOrderMethod($shipping_method_id);
            //loop through the rates to select our rate
            if (@count($shipment->rates) > 0) {
                for ($i = 0; $i < count($shipment->rates); $i++) {
                    //match our rate to the service
                    if ($shipment->rates[$i]->service == $shipmentMethodAutoSelect) {
                        $selectedRate = $shipment->rates[$i];
                        $flagSelected = true;
                        break;
                    }
                }
                if ($flagSelected === false) {
                    $totalWeightVerify = $parcelProductsWeight + $allShipProductsWeight;
                    if ($totalWeightVerify > 16) {
                        for ($i = 0; $i < count($shipment->rates); $i++) {
                            //match our rate to the service
                            if ($shipment->rates[$i]->service == 'ParcelSelect') {
                                $selectedRate = $shipment->rates[$i];
                                break;
                            }
                        }
                    }
                }
            }
        }


        //buy the shipment
        try {
            // $shipment->buy(array(
            //     'rate' => $selectedRate
            //     //'insurance'	=>  0.00
            // ));
            $boughtShipment =$client->shipment->buy($shipment->id, $shipment->lowestRate());
        } catch (Exception $e) {
            $response = array(
                'products' => $productLog,
                'code' => 'error',
                'errorCode' => 8,
                'msg' => "An error was returned from our label generation service, please show this to the administrator: " . htmlspecialchars($e->getMessage()),
            );
            if (isset($_REQUEST['request_id'])) {
                $addPrintOrders = array(
                    "print_request_id" => $_REQUEST['request_id'],
                    "order_id" => $order_id,
                    "status" => $response['errorCode'],
                    "response" => $response['msg'],
                );
                addPrintOrderLog($addPrintOrders);
            }
            return ($response);
        }


        //set our insert values
        //$shipment->label(array("file_format" => "pdf"));
        $shipmentWithLabel =$client->shipment->label( $shipment->id,array("file_format" => "pdf"));
        //echo 'Data: <pre>' .print_r($shipment,true). '</pre>';
        $insertArray['trackingCode'] = @$shipmentWithLabel->tracking_code;
        $tracking_number = $insertArray['trackingCode'];
        $insertArray['shipmentCost'] = @number_format($shipmentWithLabel->selected_rate->rate, 2, '.', '');
        $insertArray['easyPostShipmentId'] = @$shipment->id;
        $insertArray['easyPostShipmentTrackingUrl'] = @$shipmentWithLabel->tracker->public_url;
        $insertArray['easyPostLabelSize'] = @$shipmentWithLabel->postage_label->label_size;

        $insertArray['easyPostLabelPNG'] = @$shipmentWithLabel->postage_label->label_url;
        $insertArray['easyPostLabelPDF'] = @$shipmentWithLabel->postage_label->label_pdf_url;

        $insertArray['easyPostLabelRateId'] = @$shipmentWithLabel->selected_rate->id;
        $insertArray['easyPostLabelCarrier'] = @$shipmentWithLabel->selected_rate->carrier;
        $insertArray['easyPostLabelService'] = @$shipmentWithLabel->selected_rate->service;

        $insertArray['shipmentStatus'] = @$shipmentWithLabel->tracker->status;
        $insertArray['estDeliveryDate'] = @$shipmentWithLabel->tracker->est_delivery_date;

        $_POST['easypost_tracking_number'] = $tracking_number;
        $_POST['easypost_tracking_url'] = $insertArray['easyPostShipmentTrackingUrl'];

        //download teh PNG version of the label
        $randomFileName = $tracking_number . ".png";
        $downloadResult = @file_get_contents(@$shipmentWithLabel->postage_label->label_url);

        if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'woocommerce_mark_order_status' || $_REQUEST['action'] == 'createOrderSecondShipment')) {
            $_REQUEST['tracking_email_shipment'] = 'yes';
            $_REQUEST['package_label_shipment'] = 'yes';
            $_REQUEST['print_label_shipment'] = 'yes';
        }
        $downloadSuccess = false;
        if ($downloadResult) {


            if (isset($_REQUEST['tracking_email_shipment']) && $_REQUEST['tracking_email_shipment'] == 'yes') {
                $insertArray['trackingEmail'] = 1;
                WC()->mailer()->emails['WC_Shipment_Order_Email']->trigger($order_id);
            } else {
                $insertArray['trackingEmail'] = 0;
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
                $insertArray['packageLabelPrint'] = 1;
                if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
                    $packaging_note = $_REQUEST['packaging_order_note'];
                }
                $packing_array = array(
                    'order_id' => $order_id,
                    'orderItems' => $updatedOrderItem,
                    'packaging_note' => $packaging_note,
                    'shipment_package_id' => $shipment_package_id,
                );
                if (isset($_REQUEST['request_id']) && $_REQUEST['request_id'] > 0) {
                    $packing_array['batchID'] = $_REQUEST['request_id'];
                }
                if (isset($package_detail['group__id']) && $package_detail['group__id'] > 0) {
                    $packing_array['group_id'] = $package_detail['group__id'];
                }

                $returnResponsePackaging = shipmentPackageList($packing_array);
                //  $returnResponsePackaging = shipmentPackageList($order_id, $updatedOrderItem, $packaging_note, $shipment_package_id);
                $insertArray['productsWithQty'] = json_encode($updatedOrderItem);

                // instantiate and use the dompdf class
                $dompdf = new Dompdf();
                $dompdf->loadHtml($returnResponsePackaging);
                $logs_dir = $_SERVER['DOCUMENT_ROOT'] . '/downloads/packages/';
                if (!is_dir($logs_dir)) {
                    mkdir($logs_dir, 0755, true);
                }
                $dompdf->render();
                $output = $dompdf->output();

                // $packagingFileName = $tracking_number . '.pdf';
                $packagingFileName = $tracking_number . '_' . $order_id . '.pdf';
                file_put_contents($logs_dir . $packagingFileName, $output);
                //successful drop of the file
                $packaging_file_path = $logs_dir . $packagingFileName;
                mbt_printer_receipt($packaging_file_path, '4x6');
            } else {
                $insertArray['packageLabelPrint'] = 0;
            }

            $MbtPackaging->manage_package_inventory($shipment_package_id);
            $logs_dir = $_SERVER['DOCUMENT_ROOT'] . '/downloads/labels/';
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
                    mbt_printer_receipt($file_path, $insertArray['easyPostLabelSize']);
                    $insertArray['shipmentLabelPrint'] = 1;
                } else {
                    $insertArray['shipmentLabelPrint'] = 0;
                }
            }
        } else {
            $response = array(
                'products' => $productLog,
                'code' => 'error',
                'errorCode' => 9,
                'msg' => "We were unsucessful in generating the return label for print.  Please try again or contact the administrator.",
            );
            if (isset($_REQUEST['request_id'])) {
                $addPrintOrders = array(
                    "print_request_id" => $_REQUEST['request_id'],
                    "order_id" => $order_id,
                    "status" => $response['errorCode'],
                    "response" => $response['msg'],
                );
                addPrintOrderLog($addPrintOrders);
            }
            return json_encode($response);
        }

        $shipment_db_id = sb_easypost_shipment($insertArray);
        if ($shipment_db_id) {
            mbt_goodToShip($order_id, 'no');
            $shipStatus = false;

            //foreach ($allOrderIds as $ord_id => $ord_number) {
            $order_shipment = array(
                'shipment_id' => $shipment_db_id,
                'order_id' => $order_id,
                'order_number' => $orderSBRref,
            );
            sb_easypost_shipment_orders($order_shipment);
            // }
            foreach ($updatedOrderItem as $item_id => $data) {
                $product_id = $data['product_id'];
                //  $order_id = $data['order_id'];
                //   $order = wc_get_order($order_id);
                $event_data = array(
                    "order_id" => $order_id,
                    "item_id" => $item_id,
                    "shipment_id" => $shipment_db_id,
                    "product_id" => $product_id,
                    "event_id" => 2,
                );
                sb_create_log($event_data);
                //Create Log    
                addShipmentHistory($item_id, $data['qty'], $data['type'], $tracking_number, date("Y-m-d", strtotime(@trim($_REQUEST['shipping_date']))));

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
                        sb_create_log($event_data);
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
                        sb_create_log($event_data);
                    }
                }

                $shipStatus = mbt_addOrderStatus($order_id);
            }

            $response = array(
                'code' => 'success',
                'products' => $productLog,
                'status' => $shipStatus,
                'errorCode' => 10,
                'msg' => 'Shipment created successfully. Tracking ID# ' . $tracking_number
            );
            if (isset($_REQUEST['request_id'])) {
                $addPrintOrders = array(
                    "print_request_id" => $_REQUEST['request_id'],
                    "shipment_id" => $shipment_db_id,
                    "order_id" => $order_id,
                    "product_ids" => json_encode($updatedOrderItem),
                    "status" => $response['errorCode'],
                    "response" => $response['msg'],
                );
                addPrintOrderLog($addPrintOrders);
            }
            return ($response);
        } else {
            $response = array(
                'products' => $productLog,
                'code' => 'error',
                'errorCode' => 11,
                'msg' => "An error occured while trying to insert the shipment.",
            );
            if (isset($_REQUEST['request_id'])) {
                $addPrintOrders = array(
                    "print_request_id" => $_REQUEST['request_id'],
                    "order_id" => $order_id,
                    "status" => $response['errorCode'],
                    "response" => $response['msg'],
                );
                addPrintOrderLog($addPrintOrders);
            }
            return ($response);
        }
    } else {
        $response = array(
            'products' => $productLog,
            'code' => 'error',
            'errorCode' => 12,
            'msg' => "We were unsucessful in generating the return label.  Please try again or contact the administrator.",
        );
        if (isset($_REQUEST['request_id'])) {
            $addPrintOrders = array(
                "print_request_id" => $_REQUEST['request_id'],
                "order_id" => $order_id,
                "status" => $response['errorCode'],
                "response" => $response['msg'],
            );
            addPrintOrderLog($addPrintOrders);
        }
        return ($response);
    }
}
/**
 * Callback function for creating a second shipment on  batch print screen dashbboard.
 */
function batch_printing_send_request_second($batch_printing_orders, $stop = true)
{
    $orderList = array();
    global $wpdb;
    $errorList = array();
    $errorFlag = false;

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'woocommerce_mark_order_status') {
        if (is_array($batch_printing_orders) && count($batch_printing_orders) > 0) {

            $sql_query = "SELECT order_id , event_id FROM  " . SB_LOG;
            $sql_query .= " WHERE order_id IN (" . implode(",", $batch_printing_orders) . ")";
            $logResults = $wpdb->get_results($sql_query);

            if (is_array($logResults) && count($logResults) > 0) {
                foreach ($logResults as $logEntry) {
                    if (in_array($logEntry->event_id, array(16, 17))) {
                        //Add Order ID
                        $orderList[$logEntry->order_id] = $logEntry->order_id;
                    } else {
                        if (isset($orderList[$logEntry->order_id])) {
                            unset($orderList[$logEntry->order_id]);
                        }
                    }
                }
            } else {
                $orderList = $batch_printing_orders;
            }
        } else {
            $errorFlag = true;
            $errorList[] = 'No order selected for shipment';
        }

        $batch_printing_response = array();
        if (count($orderList) > 0) {
            foreach ($batch_printing_orders as $order_id) {
                $batch_printing_response[$order_id] = orderEasyPostSecondShipmentRequest($order_id);
            }
        }
        echo batchPtintDisplayPage($batch_printing_response);
        if ($stop)
            die;
    } else {
?>

        <style>
            #sbr-orders-table,
            .bp-search-join-type,
            #batch-printing,
            .tab.custom-tabs {
                display: none !important;
            }

            .form-inline #original,
            .form-inline .cmt-thed.packaging-actions,
            .form-inline .searh-row-mbt,
            .form-inline .searh-row,
            .form-inline .search-filed-grp {
                display: none !important;
            }
        </style>
        <?php
        if (isset($_REQUEST['print_request_id']) && $_REQUEST['print_request_id'] <> '') {
            batchPrintLogDetail($_REQUEST['print_request_id'], 1);
        } else {
            // }
            wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
            wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
        ?>
            <style>
                div#center span {
                    position: relative;
                    font-size: 10px;
                    color: #2372b1;

                }

                @-webkit-keyframes janimation {
                    0% {
                        -webkit-transform: rotate(0deg) scale(1.5);
                        color: #aaa;
                    }

                    10% {
                        -webkit-transform: rotate(0deg) scale(1.7);
                        color: #ccc;
                    }

                    100% {
                        -webkit-transform: rotate(0deg) scale(1.2);
                        /*color: #333;*/
                        color: transparent;
                        text-shadow: #666 0 0 10px;
                    }
                }

                div#center div {
                    position: relative;
                    display: inline-block;
                    -webkit-animation: janimation 2.2s infinite;
                }

                div#center div.letter_container_1 {
                    -webkit-animation-delay: 0s;
                }

                div#center div.letter_container_2 {
                    -webkit-animation-delay: .2s;
                }

                div#center div.letter_container_3 {
                    -webkit-animation-delay: .4s;
                }

                div#center div.letter_container_4 {
                    -webkit-animation-delay: .6s;
                }

                div#center div.letter_container_5 {
                    -webkit-animation-delay: .8s;
                }

                div#center div.letter_container_6 {
                    -webkit-animation-delay: 1s;
                }

                div#center div.letter_container_7 {
                    -webkit-animation-delay: 1.2s;
                }
            </style>
            <?php
            if (is_array($batch_printing_orders) && count($batch_printing_orders) > 0) {
                if (isset($_REQUEST['tracking_email_shipment']) && $_REQUEST['tracking_email_shipment'] == 'yes') {
                    $data['tracking_email'] = 1;
                } else {
                    $data['tracking_email'] = 0;
                }

                if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {
                    $data['packaging_label'] = 1;
                } else {
                    $data['packaging_label'] = 0;
                }
                if (isset($_REQUEST['print_label_shipment']) && $_REQUEST['print_label_shipment'] == 'yes') {
                    $data['shipment_label'] = 1;
                } else {
                    $data['shipment_label'] = 0;
                }
                $data['shipment_type'] = 2;
                $data['order_counts'] = count($batch_printing_orders);
                $data['created_by'] = get_current_user_id();
                if (isset($_REQUEST['print_request_id']) && $_REQUEST['print_request_id'] > 0) {
                    $print_request_id = $_REQUEST['print_request_id'];
                } else {
                    $print_request_id = addPrintLog($data);
                }

                echo '<input type="hidden" name="print_request_id" id="print_request_id" value="' . $print_request_id . '" />';
                echo '<input type="hidden" name="tracking_email_shipment" id="tracking_email_shipment" value="' . $_REQUEST['tracking_email_shipment'] . '" />';
                echo '<input type="hidden" name="package_label_shipment" id="package_label_shipment" value="' . $_REQUEST['package_label_shipment'] . '" />';
                echo '<input type="hidden" name="print_label_shipment" id="print_label_shipment" value="' . $_REQUEST['print_label_shipment'] . '" />';
            }
            ?>
            <div class="col-sm-12">
                <a href="javascript:;" id="resend_request_shipment" class="button button-small" style="display:none">Resend Failed Print Requests</a>
                <label>Display</label>
                <select id="batchPrintSort">
                    <option value="all">All</option>
                    <option value="left">Left</option>
                    <option value="printed">Printed</option>
                </select>
            </div>
            <table id="batch_print" class="secondShipmentBatch">
                <thead>
                    <tr>
                        <th>Products</th>
                        <th>SBR Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $loadingHtml = '<div id="center"><div class="letter_container_1"><span>L</span></div><div class="letter_container_2"><span>O</span></div><div class="letter_container_3"><span>A</span></div><div class="letter_container_4"><span>D</span></div><div class="letter_container_5"><span>I</span></div><div class="letter_container_6"><span>N</span></div><div class="letter_container_7"><span>G</span></div></div>';
                    if (is_array($batch_printing_orders) && count($batch_printing_orders) > 0) {
                        foreach ($batch_printing_orders as $key => $order_id) {
                            //$seq_OrderNumber = new WC_Seq_Order_Number_Pro();
                            //  $order = wc_get_order($order_id);
                            //  $order_number_formatted = $seq_OrderNumber->get_order_number($order_id, $order);
                            echo '<tr id="print_order_' . $order_id . '" status="0" order_id="' . $order_id . '" class="batchPrint-' . $key . '">';
                            // echo '<tr id="print_order_'.$order_id.'" order_id="'.$order_id.'" class="batchPrint-'.$key.'">';
                            $order_number_formatted = '<strong><a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $order_id . '&action=edit">' . get_post_meta($order_id, 'order_number', true) . '</a></strong>';
                            echo '<td class="curent-products"></td>';
                            echo '<td>' . $order_number_formatted . '</td>';
                            echo '<td class="current-response"></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr>';
                        echo '<td colspan="3">No record found!</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
            <style>
                .loading-sbr {
                    display: none !important;
                }
            </style>
            <script>
                var datatable = '';
                var ajaxCounterBatch = 0;
                var initialCounter = 0;
                var totalLength = jQuery('body').find('#batch_print tbody tr').length;
                jQuery(document).ready(function() {

                    jQuery('#batch_print').DataTable({
                        "ordering": false,
                        "searching": false,
                        "paging": false
                    });

                    sendPrintAjaxRequest(initialCounter);
                    insertUrlParam('print_request_id', jQuery('body').find('#print_request_id').val())

                });

                function insertUrlParam(key, value) {
                    if (history.pushState) {
                        let searchParams = new URLSearchParams(window.location.search);
                        searchParams.set(key, value);
                        let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
                        window.history.pushState({
                            path: newurl
                        }, '', newurl);
                    }
                }

                function sendPrintAjaxRequest(initialCounter) {

                    if (initialCounter < totalLength) {
                        var classtofind = '.batchPrint-' + initialCounter;
                        var currentItem = jQuery('body').find(classtofind);
                        if (currentItem.attr('status') == 0) {
                            var previousProducts = jQuery(currentItem).find('.curent-products').html();

                            jQuery.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: 'createOrderSecondShipment',
                                    order_id: currentItem.attr('order_id'),
                                    request_id: jQuery('body').find('#print_request_id').val(),
                                    tracking_email_shipment: jQuery('body').find('#tracking_email_shipment').val(),
                                    package_label_shipment: jQuery('body').find('#package_label_shipment').val(),
                                    print_label_shipment: jQuery('body').find('#print_label_shipment').val(),
                                },

                                async: true,
                                dataType: 'JSON',
                                method: 'POST',

                                beforeSend: function(xhr) {
                                    jQuery(currentItem).find('.curent-products').html('<?php echo $loadingHtml; ?>');
                                    jQuery(currentItem).find('.current-response').html('<?php echo $loadingHtml; ?>');
                                },
                                success: function(response) {
                                    console.log(response);
                                    // if(initialCounter <  totalLength){
                                    // console.log(response);
                                    initialCounter = initialCounter + 1;
                                    sendPrintAjaxRequest(initialCounter);
                                    jQuery(currentItem).find('.curent-products').html(response.products);
                                    jQuery(currentItem).find('.current-response').html(response.msg);
                                    if (response.code == 'success') {
                                        currentItem.attr('status', '1');
                                    } else {
                                        if (response.errorCode == 3) {
                                            currentItem.attr('status', '1');
                                            jQuery(currentItem).find('.curent-products').html(previousProducts);
                                        }
                                        if (response.errorCode == 51) {
                                            order_id_package = currentItem.attr('order_id');
                                            //jQuery(currentItem).find('.current-response').append('<a  href=":;">Create Shipment</a>');
                                            jQuery(currentItem).find('.current-response').append('<br/><br/><a  href="' + response.redirect_url + '" target="_blank">Create Shipment</a>');
                                        }
                                        if (response.packageId == 0) {
                                            order_id_package = currentItem.attr('order_id');
                                            //13022023jQuery(currentItem).find('.current-response').append('<a onclick="addPackageGroup(\'' + response.packageUrl + '\' , ' + false + ', ' + order_id_package + ' )" href="javascript:;">Select Package</a>');
                                            //  jQuery(currentItem).find('.current-response').append('<a href="' + response.packageUrl + '" target="_blank">Create Package</a>');
                                        }

                                    }

                                    // }

                                },
                                error: function(xhr) {

                                },
                                //cache: false,
                                //contentType: false,
                                //  processData: false
                            });
                        } else {
                            initialCounter = initialCounter + 1;
                            sendPrintAjaxRequest(initialCounter);
                        }
                    } else {
                        if (getRemainItemCount() == 0) {
                            jQuery('#resend_request_shipment').hide();
                        } else {
                            jQuery('#resend_request_shipment').show();
                        }
                    }
                }


                jQuery('body').on('click', '#resend_request_shipment', function() {
                    //  totalLength = getRemainItemCount();
                    sendPrintAjaxRequest(0);

                });

                function getRemainItemCount() {
                    var counter = 0;
                    jQuery('body').find('#batch_print tbody tr').each(function() {
                        if (jQuery(this).attr('status') == 0) {
                            counter = counter + 1;
                        }
                    });
                    return counter;
                }
                jQuery('.wpbody-content .wrap h2').html('Second Batch Shipment');
            </script>

<?php
        }
    }
    return;
}
/**
 * Validate order item log available for 2nd shipment or not.
 */
function validateSecondShipmentLogs($order_id, $item_id, $product_id)
{
    global $wpdb;
    $query = "SELECT event_id FROM  " . SB_LOG;
    $query .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
    $query .= " ORDER BY log_id DESC";
    $query_q0 = $wpdb->get_var($query);
    if (in_array($query_q0, array(16, 17))) {
        $valid = true;
    } else {
        $valid = false;
    }
    return $valid;
}
