<?php

use Dompdf\Dompdf;

add_action('wp_ajax_createManifestRequestBatchShipment', 'createManifestRequestBatchShipment_callback');
/**
 * AJAX callback to create a manifest request for batch shipments.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function createManifestRequestBatchShipment_callback()
{
    if (isset($_REQUEST['request_id']) && $_REQUEST['request_id'] <> 0) {
        $request_id = $_REQUEST['request_id'];
    }
    if ($request_id == '') {
        $response = array(
            'msg' => 'Request Id is empty',
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    } else {

        if (isset($_REQUEST['shipmentids_arr']) && is_array($_REQUEST['shipmentids_arr']) && count($_REQUEST['shipmentids_arr']) > 0) {
            global $wpdb;
            // Sanitize and prepare the array for the SQL query
            $shipmentIds = array_map('intval', $_REQUEST['shipmentids_arr']);
            // Build the IN clause for the SQL query
            $inClause = implode(',', $shipmentIds);

            $query = "SELECT easyPostShipmentId, easyPostLabelCarrier, order_id FROM  " . SB_EASYPOST_TABLE . " as se";
            $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
            $query .= " WHERE batchIdShipment = 0 AND  print_request_id = " . $request_id;
            $query .= " AND order_id IN (" . $inClause . ")"; // Add the IN clause here
            $easypostShipments = $wpdb->get_results($query);


            if (count($easypostShipments) > 0) {
                $services = array();
                $easypostShipmentIds = array();
                foreach ($easypostShipments as  $shipmentEntry) {
                    if (!in_array($shipmentEntry->easyPostLabelCarrier, $services)) {
                        $services[] = $shipmentEntry->easyPostLabelCarrier;
                    }
                    $easypostShipmentIds[] = $shipmentEntry->easyPostShipmentId;
                }
                if (count($services) == 1) {
                    addEasyPostManifestRequest($easypostShipmentIds, $services[0]);
                } else {
                    $response = array(
                        'msg' => 'Batch request contains multiple couriers.',
                        'code' => 'error'
                    );
                    echo json_encode($response);
                    die();
                }
            } else {
                $response = array(
                    'msg' => 'No order found aginst selected request ID',
                    'code' => 'error'
                );
                echo json_encode($response);
                die();
            }
        } else {
            $response = array(
                'msg' => 'No shipments were posted to the batch creation page',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
    }
}
add_action('wp_ajax_createPrintRequest', 'createPackagingSlipPrint_callback');
/**
 * AJAX callback to create and print packaging slips for orders in a print request.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function createPackagingSlipPrint_callback()
{
    global $wpdb;
    $response = array();
    require_once("dompdfkami/autoload.inc.php");
    if (isset($_POST['request_id']) && $_POST['request_id'] <> 0) {
        $request_id = $_POST['request_id'];
    }
    if ($request_id == '') {
        $response = array(
            'msg' => 'Request Id is empty',
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    } else {
        $order_id = $_POST['order_id'];
        $query = "SELECT * FROM  " . SB_EASYPOST_TABLE . " as se";
        $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
        $query .= " WHERE  print_request_id = " . $request_id;
        $query .= " AND  trackingCode != '' ";
        $query .= " AND  order_id = " . $order_id;
        $shipmentEntry = $wpdb->get_row($query);

        if (isset($shipmentEntry->order_id)) {
            $tracking_number = $shipmentEntry->trackingCode;
            $order_id = $shipmentEntry->order_id;
            $easyPostLabelSize = $shipmentEntry->easyPostLabelSize;
            $easyPostLabelPNG = $shipmentEntry->easyPostLabelPNG;
            $packagingSlip = $_SERVER['DOCUMENT_ROOT'] . '/downloads/packages/' . $tracking_number . '_' . $order_id . '.pdf';
            $easypostLabel = $_SERVER['DOCUMENT_ROOT'] . '/downloads/labels/' . $tracking_number . '.png';
            if (file_exists($packagingSlip)) {
                mbt_printer_receipt($packagingSlip, '4x6');
            } else {

                $packing_array = json_decode($shipmentEntry->packagingParam, true);
                if ($shipmentEntry->packagingParam) {
                    $returnResponsePackaging = new_shipmentPackageList($packing_array);
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($returnResponsePackaging);
                    $dompdf->render();
                    $output = $dompdf->output();
                    $packagingFilePutResult = @file_put_contents($packagingSlip, $output);

                    if ($packagingFilePutResult) {
                        mbt_printer_receipt($packagingSlip, '4x6');
                    }
                }
            }
            if (file_exists($easypostLabel)) {
                mbt_printer_receipt($easypostLabel, $easyPostLabelSize);
            } else {

                $downloadResult = @file_get_contents(@$easyPostLabelPNG);
                $filePutResult = @file_put_contents($easypostLabel, $downloadResult);
                if ($filePutResult) {
                    mbt_printer_receipt($easypostLabel, $easyPostLabelSize);
                }
            }
            $response = array(
                'msg' =>  'Request processing for printing  packing slips to the printer.',
                'code' => 'success'
            );
            echo json_encode($response);
            die();
        } else {
            $response = array(
                'msg' => 'No order found aginst selected request ID',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
    }
}

/**
 * AJAX callback to create and print packaging slips for orders in a print request previous system.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function createPackagingSlipPrint_callback_previous_bulk()
{
    global $wpdb;
    $response = array();
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    die;
    require_once("dompdfkami/autoload.inc.php");
    if (isset($_GET['request_id']) && $_GET['request_id'] <> 0) {
        $request_id = $_GET['request_id'];
    }
    if ($request_id == '') {
        $response = array(
            'msg' => 'Request Id is empty',
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    } else {
        $query = "SELECT * FROM  " . SB_EASYPOST_TABLE . " as se";
        $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
        $query .= " WHERE  print_request_id = " . $request_id;
        $easypostShipments = $wpdb->get_results($query);

        if (count($easypostShipments) > 0) {
            foreach ($easypostShipments as  $shipmentEntry) {
                $tracking_number = $shipmentEntry->trackingCode;
                $order_id = $shipmentEntry->order_id;
                $easyPostLabelSize = $shipmentEntry->easyPostLabelSize;
                $easyPostLabelPNG = $shipmentEntry->easyPostLabelPNG;
                $packagingSlip = $_SERVER['DOCUMENT_ROOT'] . '/downloads/packages/' . $tracking_number . '_' . $order_id . '.pdf';
                $easypostLabel = $_SERVER['DOCUMENT_ROOT'] . '/downloads/labels/' . $tracking_number . '.png';
                //updateCompositeProductItems(794933, 'new');

                //   updateCompositeProductItems(428548, 'new');
                if (file_exists($packagingSlip)) {
                    mbt_printer_receipt($packagingSlip, '4x6');
                } else {

                    //  die;
                    $packing_array = json_decode($shipmentEntry->packagingParam, true);
                    if ($shipmentEntry->packagingParam) {
                        $returnResponsePackaging = new_shipmentPackageList($packing_array);
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($returnResponsePackaging);
                        $dompdf->render();
                        $output = $dompdf->output();
                        $packagingFilePutResult = @file_put_contents($packagingSlip, $output);

                        if ($packagingFilePutResult) {
                            mbt_printer_receipt($packagingSlip, '4x6');
                        }
                    }
                }
                die;
                if (file_exists($easypostLabel)) {
                    mbt_printer_receipt($easypostLabel, $easyPostLabelSize);
                } else {

                    $downloadResult = @file_get_contents(@$easyPostLabelPNG);
                    $filePutResult = @file_put_contents($easypostLabel, $downloadResult);
                    if ($filePutResult) {
                        mbt_printer_receipt($easypostLabel, $easyPostLabelSize);
                    }
                }
            }
            $response = array(
                'msg' => count($easypostShipments) .  '=> Request processing for printing  packing slips to the printer.',
                'code' => 'success'
            );
            echo json_encode($response);
            die();
        } else {
            $response = array(
                'msg' => 'No order found aginst selected request ID',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
    }
}


/**
 * Function to generate a shipment package list for a given order.
 *
 * @param array $packing_array The array containing order details and packaging information.
 * @return string|false Returns the HTML content of the packaging slip or false if no data.
 */
function new_shipmentPackageList($packing_array)
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
            $mouth_guard_color =   wc_get_order_item_meta($item_id, 'mouth_guard_color',  true);
            $mouth_guard_number =   wc_get_order_item_meta($item_id, 'mouth_guard_number',  true);
            $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
            $shipment = isset($orderItems[$item_id]['shipment']) ? $orderItems[$item_id]['shipment'] : 1;
            $stockManagement = wc_get_order_item_meta($item_id, '_sbr_stock', true);
            $qtyShipped = isset($orderItems[$item_id]['qty']) ? $orderItems[$item_id]['qty'] : 0;
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
                    if ($shipment == 2) {
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

                    if ($shipment == 2) {
                        $childCompositeData[] = array(
                            'product_id' => $composite_item_product_id,
                            'quantity_ordered' => $quantity_ordered,
                            'quantity_shipped' => $quantity_shipped
                        );
                    }
                }
                if ($shipment == 2) {

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

                if ($compositeData) {
                    foreach ($compositeData as $composite_item_id => $composite_item) {
                        $quantity_ordered = 0;
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];
                        if ($stockManagement != 'shipped') {
                            if ($firstShipment) {
                                if (isset($order_notes[$composite_item_product_id])) {
                                    $order_notes[$composite_item_product_id] = $firstShipment +   $order_notes[$composite_item_product_id];
                                } else {
                                    $order_notes[$composite_item_product_id] = $firstShipment;
                                }
                            }
                        }
                    }
                }
                
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
                    'refunded_qty'=>$refunded_qty,
                    'childs' => array()
                );
                wc_update_order_item_meta($item_id, '_sbr_stock', 'shipped');
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

//add_action('wp_ajax_createPrintRequest', 'createPrintRequest_callback');
/**
 * AJAX callback to create and print labels and packing slips for selected orders in a print request.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function createPrintRequest_callback()
{

    global $wpdb;
    $response = array();

    if (isset($_GET['request_id']) && $_GET['request_id'] <> 0) {
        $request_id = $_GET['request_id'];
    }
    if ($request_id == '') {
        $response = array(
            'msg' => 'Request Id is empty',
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    } else {

        $query = "SELECT order_id , trackingCode , easyPostLabelSize FROM  " . SB_EASYPOST_TABLE . " as se";
        $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
        $query .= " WHERE  print_request_id = " . $request_id;
        $easypostShipments = $wpdb->get_results($query);


        if (count($easypostShipments) > 0) {


            foreach ($easypostShipments as  $shipmentEntry) {
                $tracking_number = $shipmentEntry->trackingCode;
                $order_id = $shipmentEntry->order_id;
                $easyPostLabelSize = $shipmentEntry->easyPostLabelSize;
                $packagingSlip = $_SERVER['DOCUMENT_ROOT'] . '/downloads/packages/' . $tracking_number . '_' . $order_id . '.pdf';
                $easypostLabel = $_SERVER['DOCUMENT_ROOT'] . '/downloads/labels/' . $tracking_number . '.png';
                mbt_printer_receipt($packagingSlip, '4x6');
                mbt_printer_receipt($easypostLabel, $easyPostLabelSize);
            }

            $response = array(
                'msg' => count($easypostShipments) .  '=> Request processing for printing labels and packing slips to the printer.',
                'code' => 'success'
            );
            echo json_encode($response);
            die();
        } else {
            $response = array(
                'msg' => 'No order found aginst selected request ID',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
    }
}
add_action('wp_ajax_genrate_batch_print_request', 'genrate_batch_print_request_callback');
/**
 * AJAX callback to generate a batch print request for selected orders.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function genrate_batch_print_request_callback()
{
    // Your batch print processing logic here
    $batch_printing_orders = isset($_REQUEST['checkedItems']) ? $_REQUEST['checkedItems'] : array();
    if (is_array($batch_printing_orders) && count($batch_printing_orders) > 0) {
        if (isset($_REQUEST['tracking_email_shipment']) && $_REQUEST['tracking_email_shipment'] == true) {
            $data['tracking_email'] = 1;
        } else {
            $data['tracking_email'] = 0;
        }

        if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == true) {
            $data['packaging_label'] = 1;
        } else {
            $data['packaging_label'] = 0;
        }
        if (isset($_REQUEST['print_label_shipment']) && $_REQUEST['print_label_shipment'] ==  true) {
            $data['shipment_label'] = 1;
        } else {
            $data['shipment_label'] = 0;
        }
        $duplication_found_orders = array();
        //echo '<pre>'.print_r($batch_printing_orders).'</pre>';
        if(is_array($batch_printing_orders) && count($batch_printing_orders)>0){
            foreach($batch_printing_orders as $bp){
                if(get_orders_matching_by_customer($bp)){
                    $duplication_found_orders[]=$bp;
                }
        
            }
        }
        $data['shipment_type'] = 1;
        $data['order_ids'] = json_encode($batch_printing_orders);
        $data['duplication_found_orders'] = json_encode($duplication_found_orders);
        $data['order_counts'] = count($batch_printing_orders);
        $data['created_by'] = get_current_user_id();

        $print_request_id = addPrintLog($data);
        set_transient( 'duplication_found_orders'.$print_request_id, json_encode($duplication_found_orders), 60*60*24*30);
        if ($print_request_id) {
            // $url = site_url('/wp-admin/admin.php?page=batch_request&request_id=' . $print_request_id);
            $url = admin_url('admin.php?page=batch_request&request_id=' . $print_request_id);
            $response_data = array(
                'message' => 'Batch print request successful!',
                'url' => $url,
            );

            wp_send_json_success($response_data);
            //   wp_send_json_success('Batch print request successful!', $additional_params);
        } else {
            wp_send_json_error('Batch print request failed!. Database connection failed.');
        }
    } else {
        wp_send_json_error('Batch print request failed!. No Order found');
    }
    // Always die in functions echoing AJAX content
    die();
}


/**
 * Batch print request dashboard 
 *
 */
function batchPrintRequestDetail($request_id = 0, $state = 0)
{



    global $MbtPackaging, $wpdb;
    if (isset($_GET['request_id']) && $_GET['request_id'] <> 0) {
        $request_id = $_GET['request_id'];
    }


    if ($request_id == '') {
        echo 'Request Id is empty';
    } else {
        echo '<input type="hidden" name="print_request_id" id="print_request_id" value="' . $request_id . '" />';
        $requestData = $wpdb->get_row("SELECT * FROM " . SB_PRINT_REQUEST_TABLE . " WHERE request_id=" . $request_id);
        //  echo 'Data: <pre>' . print_r($requestData, true) . '</pre>';
        $request_orders = json_decode($requestData->order_ids, true);
        $batch_printing_orders = $wpdb->get_results("SELECT * FROM " . SB_PRINT_REQUESTS_ORDER_TABLE . " WHERE print_request_id=" . $request_id);
        //   echo 'Data: <pre>' . print_r($batch_printing_orders, true) . '</pre>';
        //  die;
        wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
        wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
?>
        <script src='<?php echo site_url('wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'); ?>' id='jquery-blockui-js'></script>
        <div class="loader" id="loader_loader_100" style="display: none;">
            <div class="loader-counter">
                <h1>0</h1>
            </div>
        </div>
        - <div class="loading-sbr" style="display: block;">
            <div class="inner-sbr"></div>
        </div>
        <style>
            body .loader {
                background: linear-gradient(to right, #2372b1b5, #2372b152);
                height: 100%;
                width: 100%;
                position: fixed;
                z-index: 12;
                top: 0;
                left: 0;
            }

            body .loader .loader-counter h1 {
                position: fixed;
                top: 30%;
                left: 50%;
                transform: translate(-50%, -70%);
                color: #fff;
                font-size: 150px;
            }
        </style>
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

            #batch_print_filter input {
                width: 400px;
                margin-bottom: 6px;
                margin-right: 2px;
            }
        </style>
        <div class="mbt-row inf-content">
            <?php
            /*
            if ($state) {
                echo '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=sb_orders_page&batch_printing=yes') . '">Back</a>';
            } else {
                echo '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=batch_print_logs') . '">Back</a>';
            }
            */
            ?>
            <div class="customer_profile_mbt main contianer">
                <div class="row-mbt-outer justify-content-center">
                    <div class="col-sm-12">
                        <h3> Batch Print Request Information </h3>
                        <div class="table-responsive">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong> <span class="dashicons dashicons-admin-users"></span> Request #:</strong>
                                        </td>
                                        <td class="text-primary"> <?php echo $requestData->request_id; ?></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong> <span class="dashicons dashicons-cloud"></span> Number x Order Requests:</strong>
                                        </td>
                                        <td class="text-primary"> <?php echo $requestData->order_counts; ?></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td>
                                            <strong> <span class="dashicons dashicons-cloud"></span>Print Labels</strong>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            if ($requestData->shipment_label) {
                                                echo 'Yes';
                                            } else {
                                                echo 'No';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td>
                                            <strong> <span class="dashicons dashicons-cloud"></span>Print Packaging Slip</strong>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            if ($requestData->packaging_label) {
                                                echo 'Yes';
                                            } else {
                                                echo 'No';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td>
                                            <strong> <span class="dashicons dashicons-cloud"></span>Email Notification</strong>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            if ($requestData->tracking_email) {
                                                echo 'Yes';
                                            } else {
                                                echo 'No';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong> <span class="dashicons dashicons-cloud"></span>Shipment</strong>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            if ($requestData->shipment_type == 2) {
                                                echo 'Second';
                                            } else {
                                                echo 'Frist';
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong> <span class="dashicons dashicons-email"></span>Created By:</strong>
                                        </td>
                                        <td class="text-primary"> <?php
                                                                    $user_info = get_userdata($requestData->created_by);
                                                                    echo $user_info->display_name;
                                                                    //   echo $requestData->created_by; 
                                                                    ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong> <span class="dashicons dashicons-email"></span>Created Date:</strong>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            echo sbr_datetime($requestData->created_date);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php
                                            if ($requestData->shipment_type == 1) {
                                                echo '<a href="javascript:;"  onclick="createEasypostRequest()" class="request_shipment button button-small"><span style="color: #fff;margin-top: 5px;" class="dashicons dashicons-airplane"></span> Create Shipments / Resend Shipments Request</a>';
                                            }
                                            ?>
                                            <a class="button button-small request_shipment" onclick="createPrintRequest(<?php echo $requestData->request_id; ?>)" href="javascript:;"><span style="color: #fff;margin-top: 5px;" class="dashicons dashicons-printer"></span> Print Lables and Packing Slips</a>
                                            <a class="button button-small request_shipment" onclick="createEasyPostManifest(<?php echo $requestData->request_id; ?>)" href="javascript:;">Generate Manifest</a>

                                            <a class="button button-small request_shipment" style="display:none" onclick="createPackagingSlipPrint(<?php echo $requestData->request_id; ?>)" href="javascript:;">Create Only Packaging Slip</a>

                                        </td>


                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <h2>Checkbox feature available only for printing.</h2>
                        <select id="batchPrintSort">
                            <option value="all">All</option>
                            <option value="left">Left</option>
                            <option value="printed">Printed</option>
                        </select>
                    </div>
                    <div class="col-sm-12">

                        <table id="batch_print">
                            <thead>
                                <tr>

                                    <th>Order Number
                                        <div class="custom-control custom-checkbox">
                                            <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                            <label class="custom-control-label" for="datatableCheckAll"></label>
                                        </div>
                                    </th>
                                    <th>Shipping Address</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $duplicate_orders = get_transient( 'duplication_found_orders'.$request_id);
                                if($duplicate_orders) {
                                    $duplicate_orders = json_decode($duplicate_orders,true);
                                }
                                $countries_obj = new WC_Countries();
                                $countries = $countries_obj->__get('countries');

                                $displayBtn = false;
                                $availableInLogOrders = array();
                                $keyCounter = 0;
                                if (is_array($batch_printing_orders) && count($batch_printing_orders) > 0) {

                                    foreach ($batch_printing_orders as $key => $order_entry) {

                                        $order_id = $order_entry->order_id;
                                        $order = wc_get_order($order_id);

                                        if (empty($order)) {
                                            echo '<tr>';
                                            echo '<td colspan="4">Order Number ' . $order_id . ' Not Found.</td>';
                                            echo '</tr>';
                                            continue;
                                        }
                                        $availableInLogOrders[$order_id] = $order_id;
                                        $productsWithQty = array();
                                        $productHtml = '';
                                        if ($order_entry->product_ids) {
                                            $products = json_decode($order_entry->product_ids, true);
                                            $productHtml .= '<ul>';
                                            foreach ($products as $item_id => $product) {

                                                if (isset($productsWithQty[$product['product_id']])) {
                                                    if(isset($productsWithQty[$product['product_id']]['qty'])){
                                                        $productPreviousQty = $productsWithQty[$product['product_id']]['qty'] + $product['qty'];
                                                    }
                                                    else{
                                                        $productPreviousQty = $productsWithQty[$product['product_id']] + $product['qty'];

                                                    }
                                                   
                                                    $productsWithQty[$product['product_id']] = $productPreviousQty;
                                                } else {
                                                    $productsWithQty[$product['product_id']] = $product['qty'];
                                                }

                                                $tray_html = '';
                                                $item_obj = $order->get_item($item_id);
                                                $three_way_ship_product = get_post_meta($product['product_id'], 'three_way_ship_product', true);

                                                if ($three_way_ship_product) {
                                                    $tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_obj, $product['product_id'], 2);
                                                }
                                                $productHtml .= '<li><a href="' . get_edit_post_link($product['product_id']) . '"  target="_blank" >' . get_the_title($product['product_id']) . ' </a> <span class="crossQty">X</span> ' . $product['qty'] . $tray_html . '</li>';
                                            }
                                            $productHtml .= '</ul>';
                                        }

                                        //echo $order->get_status();
                                        $statusOrder = 1;
                                        if ($order_entry->status != 10) {
                                            $displayBtn = true;
                                            $statusOrder = 0;
                                            if ($order->get_status() == 'shipped') {
                                                $statusOrder = 1;
                                            }
                                        }

                                        $shipment = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $order_entry->shipment_id);
                                        $address = '';
                                        if ($shipment) {
                                            $county_states = $countries_obj->get_states($shipment->shiptoCountry);
                                            $selectState = isset($county_states[$shipment->shiptoState]) ? $county_states[$shipment->shiptoState] : $shipment->shiptoState;
                                            $selectCountry = isset($countries[$shipment->shiptoCountry]) ? $countries[$shipment->shiptoCountry] : $shipment->shiptoCountry;
                                            $address = $shipment->shiptoFirstName . ' ' . $shipment->shiptoLastName;
                                            $address .= '<br/>' . $shipment->shiptoAddress . ' ' . $shipment->shiptoAptNo;
                                            $address .= '<br/>' . $shipment->shiptoCompany;
                                            $address .= '<br/>' . $shipment->shiptoCity . ', ' . $selectState . '(' . $shipment->shiptoPostalCode . ')';
                                            $address .= '<br/>' . $selectCountry;
                                            $address .= '<br/>Ph#' . $shipment->shiptoPhone;
                                        } else {
                                            // Get the shipping address.
                                            $addressData = $order->get_address('shipping');
                                            $county_states = $countries_obj->get_states($addressData['country']);
                                            $selectState = isset($county_states[$addressData['state']]) ? $county_states[$addressData['state']] : $addressData['state'];
                                            $selectCountry = isset($countries[$addressData['country']]) ? $countries[$addressData['country']] : $addressData['country'];
                                            $address = $addressData['first_name'] . ' ' . $addressData['last_name'];
                                            $address .= '<br/>' . $addressData['address_1'] . ' ' . $addressData['address_2'];
                                            $address .= '<br/>' . $addressData['company'];
                                            $address .= '<br/>' . $addressData['city'] . ', ' . $selectState . '(' . $addressData['postcode'] . ')';
                                            $address .= '<br/>' . $selectCountry;
                                            $address .= '<br/>Ph#' . $order->get_billing_phone();
                                        }

                                        $keyCounter = $key;
                                        echo '<tr id="print_order_' . $order_id . '" status="' . $statusOrder . '" order_id="' . $order_id . '" class="batchPrint-' . $key . '">';
                                        $order_select = '<div class="custom-control custom-checkbox">
                                        #' . $order_id . '
                             <input type="checkbox" class="shipment_entry custom-control-input" value="' . $order_id . '" id="shipment_val_' . $order_id . '">
                             <label class="custom-control-label" for="shipment_val_' . $order_id . '"></label>
                               
                         </div><br/><br/>';



                                        $order_number_formatted = '<strong><a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $order_id . '&action=edit">' . get_post_meta($order_id, 'order_number', true) . '</a></strong>';
                                        //   echo '<td>' . $order_number_formatted . '</td>';
                                        echo '<td>' . $order_select . $order_number_formatted  . '</td>';
                                        echo '<td>' . $address . '</br></br><b style="background-color: #2372b1;padding: 2px;color: #fff;">' . $order->get_shipping_method() . '</b></td>';
                                        echo '<td class="curent-products">' . $productHtml . '</td>';
                                ?>
                                        <td class="current-response"><?php
                                                                        if ($order->get_status() == 'shipped' && $order_entry->status != 10) {
                                                                            $query = "SELECT shipment_id FROM " . SB_PRINT_REQUESTS_ORDER_TABLE . " WHERE order_id=" . $order_id . " AND status = 10";
                                                                            $shipmentTracking = $wpdb->get_var($query);
                                                                            echo 'Order Shipped with other batch print request.';
                                                                            if ($shipmentTracking) {

                                                                                $psp = add_query_arg(
                                                                                    array(
                                                                                        'id' => $shipment->trackingCode . '_' . $order_id,
                                                                                        //'id' => $shipment->trackingCode,
                                                                                        'type' => 'slip',
                                                                                    ),
                                                                                    site_url('print.php')
                                                                                );
                                                                                $pp = add_query_arg(
                                                                                    array(
                                                                                        'id' => $shipment->trackingCode,
                                                                                        'type' => 'label',
                                                                                    ),
                                                                                    site_url('print.php')
                                                                                );
                                                                        ?>
                                                    <div class="shipmentActions">
                                                        <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo SB_DOWNLOAD . 'packages/' . $shipment->trackingCode . '_' . $order_id . '.pdf'; ?>">Package Slip</a></span>
                                                        <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $psp; ?>">Print Package Slip</a></span>
                                                        <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo SB_DOWNLOAD . 'labels/' . $shipment->trackingCode . '.png'; ?>">Shipping Label</a></span>
                                                        <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $pp; ?>">Print Label</a></span>

                                                        <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $shipment->easyPostShipmentTrackingUrl; ?>">Track Shipment</a></span>

                                                        <span class="batchBtnActions"><a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href=" <?php echo admin_url('admin.php?page=shipment_info&shipment_id=' . $shipment->shipment_id); ?>">View Detail</a></span>
                                                    </div>
                                                    <?php
                                                                            }
                                                                        } else {
                                                                            echo $order_entry->response;
                                                                            if ($order_entry->status == 444444) {

                                                                                $package_detail = $MbtPackaging->get_package_ids_for_basket($productsWithQty);
                                                                                if (isset($package_detail['status']) && $package_detail['status'] != 1) {

                                                                                    if (isset($package_detail['combinations'])) {
                                                                                        $packageNamebyId = array();
                                                                                        $get_all_packages = $MbtPackaging->get_all_packages();
                                                                                        foreach ($get_all_packages as $key => $package) {
                                                                                            $packageNamebyId[$package->id] = $package->name;
                                                                                        }
                                                                                        echo      $combinationHtml = createDuplicateCombinationHtml($packageNamebyId, $package_detail);
                                                                                    }
                                                                                }
                                                                            }
                                                                            if ($order_entry->status == 4) {
                                                                                $packageCreateUrl = '';
                                                                                if (count($productsWithQty) > 0) {
                                                                                    $keyItemToUrl = 0;
                                                                                    foreach ($productsWithQty as $product_idUrl => $qtyUrl) {
                                                                                        $packageCreateUrl .= '&product[' . $keyItemToUrl . ']=' . $product_idUrl;
                                                                                        $packageCreateUrl .= '&qty[' . $keyItemToUrl . ']=' . $qtyUrl;
                                                                                        $keyItemToUrl++;
                                                                                    }
                                                                                }


                                                                                $isFalse = false;
                                                                                // echo '<span class="batchBtnActions"><a onclick="addPackageGroup(\'' . $packageCreateUrl . '\', ' . $isFalse . ', ' . $order_id . ')" href="javascript:;">Select packaging</a></span>';
                                                                                echo '<span class="batchBtnActions"><a onclick="addPackageGroup(\'' . $packageCreateUrl . '\' , false  ,' . $order_id . ')" href="javascript:;">Select packaging </a></span>';
                                                                            }
                                                                            if ($order_entry->status == 10) {
                                                                                if ($order_entry->shipment_id) {
                                                                                    $shipment = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $order_entry->shipment_id);

                                                                                    $psp = add_query_arg(
                                                                                        array(
                                                                                            'id' => $shipment->trackingCode . '_' . $order_id,
                                                                                            'type' => 'slip',
                                                                                        ),
                                                                                        site_url('print.php')
                                                                                    );
                                                                                    $pp = add_query_arg(
                                                                                        array(
                                                                                            'id' => $shipment->trackingCode,
                                                                                            'type' => 'label',
                                                                                        ),
                                                                                        site_url('print.php')
                                                                                    );
                                                    ?>

                                                        <div class="shipmentActions">
                                                            <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo SB_DOWNLOAD . 'packages/' . $shipment->trackingCode . '_' . $order_id . '.pdf'; ?>">Package Slip</a> </span>
                                                            <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $psp; ?>">Print Package Slip</a></span>
                                                            <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo SB_DOWNLOAD . 'labels/' . $shipment->trackingCode . '.png'; ?>">Shipping Label</a></span>
                                                            <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $pp; ?>">Print Label</a></span>
                                                            <?php
                                                                                    if (!empty($shipment->easyPostShipmentTrackingUrl)) {
                                                            ?>
                                                                <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $shipment->easyPostShipmentTrackingUrl; ?>">Track Shipment</a></span>
                                                            <?php
                                                                                    } else {
                                                            ?>
                                                                <span class="batchBtnActions"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $shipment->easyPostShipmentTrackingUrl; ?>">Track Shipment</a></span>
                                                            <?php
                                                                                    }
                                                            ?>
                                                            <span class="batchBtnActions"><a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href=" <?php echo admin_url('admin.php?page=shipment_info&shipment_id=' . $shipment->shipment_id); ?>">View Detail</a></span>
                                                        </div>
                                            <?php
                                                                                }
                                                                            }
                                                                        }
                                            ?>
                                        </td>

                                <?php
                                        echo '</tr>';
                                    }
                                } else {
                                    // echo '<tr>';
                                    // echo '<td colspan="3">No record found!</td>';
                                    // echo '</tr>';
                                }

                                // Remove available IDs from request orders
                                if (!is_null($request_orders) && is_array($request_orders)) {
                                    $request_orders = array_diff($request_orders, $availableInLogOrders);
                                    // Remove available IDs from request orders
                                    $loadingHtml = '<div id="center" style="text-align: center;"><div class="letter_container_1"><span>L</span></div><div class="letter_container_2"><span>O</span></div><div class="letter_container_3"><span>A</span></div><div class="letter_container_4"><span>D</span></div><div class="letter_container_5"><span>I</span></div><div class="letter_container_6"><span>N</span></div><div class="letter_container_7"><span>G</span></div></div>';

                                    if ($request_orders) {

                                        foreach ($request_orders as $indexCounter => $pending_order_id) {
                                            if(in_array($pending_order_id,$duplicate_orders)){
                                                $print_status_str = '<a href="/wp-admin/admin.php?page=add_shipment&shipment_order='.$pending_order_id.'" target="_blank">Duplication found</a>'; 
                                            }
                                            else{
                                                $print_status_str = 'N/A';
                                            }
                                            if ($keyCounter  == 0) {
                                                echo '<tr id="print_order_' . $pending_order_id . '" status="0" order_id="' . $pending_order_id . '" class="batchPrint-' . $indexCounter . '">';
                                            } else {
                                                $keyCounter = $keyCounter + 1;
                                                echo '<tr id="print_order_' . $pending_order_id . '" status="0" order_id="' . $pending_order_id . '" class="batchPrint-' . $keyCounter . '">';
                                            }


                                            $order_number_formatted = '<strong><a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $pending_order_id . '&action=edit">' . get_post_meta($pending_order_id, 'order_number', true) . '</a></strong>';
                                            $order_select = '<div class="custom-control custom-checkbox">
                                            #' . $pending_order_id . '
                                 <input type="checkbox" class="shipment_entry custom-control-input" value="' . $pending_order_id . '" id="shipment_val_' . $pending_order_id . '">
                                 <label class="custom-control-label" for="shipment_val_' . $pending_order_id . '"></label>
                                   
                             </div><br/><br/>';

                                            echo '<td>' . $order_select . $order_number_formatted . '</td>';
                                            echo '<td></td>';
                                            echo '<td class="curent-products">N/A</td>';
                                            echo '<td class="current-response">'.$print_status_str.'</td>';
                                            echo '</tr>';
                                        }
                                    }
                                }

                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <style>
                .request_shipment {
                    font-size: 14px !important;
                    margin-bottom: 15px !important;
                    padding-left: 50px !important;
                    padding-right: 50px !important;
                    background-color: #2372b1 !important;
                    color: #fff !important;
                    font-weight: bold !important;
                }
            </style>
            <script>
                <?php
                if ($displayBtn) {
                ?>
                    jQuery('#resend_request_shipment').show();
                <?php
                }
                $actionShipmentType = 'update_createOrderShipment';
                if ($requestData->shipment_type == 2) {
                    //   $actionShipmentType = 'createOrderSecondShipment';
                }
                ?>
                // Check all 
                jQuery('#datatableCheckAll').click(function() {
                    if (jQuery(this).is(':checked')) {
                        jQuery('.shipment_entry').prop('checked', true);
                    } else {
                        jQuery('.shipment_entry').prop('checked', false);
                    }
                });
                jQuery(document).on('change', '.shipment_entry', function(e) {
                    checkcheckbox();
                });
                // Checkbox checked
                function checkcheckbox() {

                    // Total checkboxes
                    var length = jQuery('.shipment_entry').length;
                    // Total checked checkboxes
                    var totalchecked = 0;
                    jQuery('.shipment_entry').each(function() {
                        if (jQuery(this).is(':checked')) {
                            totalchecked += 1;
                        }
                    });
                    // Checked unchecked checkbox
                    if (totalchecked) {
                        jQuery("#datatableCheckAll").prop('checked', true);
                    } else {
                        jQuery('#datatableCheckAll').prop('checked', false);
                    }
                }
                jQuery("#datatableCheckAll").prop('checked', false);


                function createPackagingSlipPrint(request_id = 0) {


                    // Confirm alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Generate Packaging Slip for selected shipment .You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Generate Packaging',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch('<?php echo admin_url('admin-ajax.php?action=createPackagingSlipPrint&screen=log&request_id='); ?>' + request_id).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json();

                            }).catch(error => {
                                Swal.showValidationMessage(
                                    'Request failed: ${error}'
                                )

                            });
                        }
                    }).then((result) => {
                        let responseCode = result.value.code;
                        let responseMessage = result.value.msg;
                        if (responseCode == 'failed') {
                            Swal.fire({
                                icon: 'info',
                                text: responseMessage
                            });
                        } else if (responseCode == 'success') {
                            Swal.fire({
                                icon: 'success',
                                text: responseMessage
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: responseMessage
                            });
                        }
                    });
                }

                function createEasyPostManifest_bkkk(request_id = 0) {


                    // Confirm alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Generate manifest for selected shipment .You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Generate Manifest',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch('<?php echo admin_url('admin-ajax.php?action=generateEasyPostManifest&screen=log&request_id='); ?>' + request_id).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json();

                            }).catch(error => {
                                Swal.showValidationMessage(
                                    'Request failed: ${error}'
                                )

                            });
                        }
                    }).then((result) => {
                        let responseCode = result.value.code;
                        let responseMessage = result.value.msg;
                        if (responseCode == 'failed') {
                            Swal.fire({
                                icon: 'info',
                                text: responseMessage
                            });
                        } else if (responseCode == 'success') {
                            Swal.fire({
                                icon: 'success',
                                text: responseMessage
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: responseMessage
                            });
                        }
                    });
                }
                jQuery(document).ready(function() {
                    jQuery('#batch_print').DataTable({
                        "ordering": false,
                        "searching": true,
                        "paging": false
                    });
                    var counter12 = 0;
                    jQuery('body').find('#batch_print tbody tr').each(function() {
                        if (jQuery(this).attr('status') == 0) {
                            counter12 = counter12 + 1;
                        }
                    });
                    if (counter12 > 0) {
                        //createEasypostRequest();
                    }
                    jQuery('.loading-sbr').hide();
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
                var datatable = '';
                var ajaxCounterBatch = 0;
                var initialCounter = 0;
                var totalLength = jQuery('body').find('#batch_print tbody tr').length;
                /*
                jQuery('body').on('click', '#resend_request_shipment', function() {
                    totalLength = getRemainItemCount();
                    console.log(totalLength);
                    sendPrintAjaxRequest(initialCounter);
                });
*/

                function createEasypostRequest() {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Generate an order request to EasyPost for shipment. This action cannot be reverted.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Create Shipment',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //   jQuery('.loading-sbr').show();
                            sendPrintAjaxRequest(initialCounter);
                        }
                    });

                }


                function createEasyPostManifest(request_id = 0) {

                    var shipmentids_arr = [];
                    // Read all checked checkboxes
                    jQuery('body').find(".shipment_entry").each(function() {

                        if (jQuery(this).is(':checked')) {
                            shipmentids_arr.push(jQuery(this).val());
                            // shipmentids_arr.push(jQuery(this).val());
                        }
                    });
                    // Check checkbox checked or not
                    console.log(shipmentids_arr);
                    if (shipmentids_arr.length > 0) {


                        // Confirm alert
                        Swal.fire({
                            title: 'Are you sure?',
                            text: shipmentids_arr.length + " shipments selected for manifest. You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Generate Manifest',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery('.loading-sbr').show();
                                jQuery.ajax({
                                    url: "<?php echo admin_url('admin-ajax.php?action=createManifestRequestBatchShipment'); ?>",
                                    type: 'POST',
                                    dataType: 'JSON',
                                    async: true,
                                    data: {
                                        request_id: request_id,
                                        shipmentids_arr: shipmentids_arr
                                    },
                                    success: function(response) {
                                        let responseCode = response.code;
                                        let responseMessage = response.msg;
                                        if (responseCode == 'failed') {
                                            Swal.fire({
                                                icon: 'info',
                                                text: responseMessage
                                            });
                                        } else if (responseCode == 'success') {
                                            Swal.fire({
                                                icon: 'success',
                                                text: responseMessage
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                text: responseMessage
                                            });
                                        }

                                        console.log(response);
                                        jQuery('.loading-sbr').hide();
                                    }
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: 'Please select shipments for manifest  request.'
                        });
                        jQuery('.loading-sbr').hide();
                    }
                }

                function createPrintRequest(request_id = 0) {


                    var shipmentids_arr = [];
                    // Read all checked checkboxes
                    jQuery('body').find(".shipment_entry").each(function() {

                        if (jQuery(this).is(':checked')) {
                            shipmentids_arr.push(jQuery(this).val());
                            // shipmentids_arr.push(jQuery(this).val());
                        }
                    });
                    // Check checkbox checked or not
                    console.log(shipmentids_arr);
                    if (shipmentids_arr.length > 0) {


                        // Confirm alert
                        Swal.fire({
                            title: 'Are you sure?',
                            text: shipmentids_arr.length + " Requests Print label and packing slip. You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Print'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery('.loading-sbr').show();
                                // Iterate over rows in #batch_print tbody
                                var delay = 500; // 1 second delay

                                function processNextRequest(index) {
                                    if (index < shipmentids_arr.length) {
                                        var order_id = shipmentids_arr[index];
                                        jQuery('.loading-sbr').show();
                                        jQuery.ajax({
                                            url: "<?php echo admin_url('admin-ajax.php?action=createPrintRequest'); ?>",
                                            type: 'POST',
                                            dataType: 'JSON',
                                            async: true,
                                            data: {
                                                request_id: request_id,
                                                order_id: order_id
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    toast: true,
                                                    icon: 'success',
                                                    title: 'Order ' + order_id + ' Printed',
                                                    animation: false,
                                                    position: 'center',
                                                    showConfirmButton: false,
                                                    timer: 500,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                    }
                                                });
                                                jQuery('.loading-sbr').hide();
                                                console.log(response);

                                                // Process the next request after the delay
                                                setTimeout(function() {
                                                    processNextRequest(index + 1);
                                                }, delay);
                                            }
                                        });
                                    } else {
                                        // All requests processed, hide loading
                                        jQuery('.loading-sbr').hide();
                                    }
                                }

                                // Start processing requests
                                processNextRequest(0);
                            }
                        });
                        jQuery('.loading-sbr').hide();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: 'Please select shipments for print request.'
                        });
                        jQuery('.loading-sbr').hide();
                    }
                }


                function sendPrintAjaxRequest(initialCounter) {

                    if (initialCounter < totalLength) {

                        var classtofind = '.batchPrint-' + initialCounter;
                        var currentItem = jQuery('body').find(classtofind);
                        console.log(currentItem.attr('status'));
                        if (currentItem.attr('status') == 0) {
                            // jQuery('.loading-sbr').show();
                            jQuery.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: '<?php echo $actionShipmentType; ?>',
                                    order_id: currentItem.attr('order_id'),
                                    request_id: jQuery('body').find('#print_request_id').val(),
                                    tracking_email_shipment: <?php echo $requestData->tracking_email; ?>,
                                    package_label_shipment: <?php echo $requestData->packaging_label; ?>,
                                    print_label_shipment: <?php echo $requestData->shipment_label; ?>,
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
                                    jQuery('.loading-sbr').hide();
                                    initialCounter = initialCounter + 1;
                                    sendPrintAjaxRequest(initialCounter);
                                    jQuery(currentItem).find('.curent-products').html(response.products);
                                    jQuery(currentItem).find('.current-response').html(response.msg);
                                    if (response.code == 'success') {
                                        currentItem.attr('status', '1');
                                    } else {
                                        if (response.errorCode == 3) {
                                            currentItem.attr('status', '1');
                                            jQuery(currentItem).find('.curent-products').html(response.products);
                                        }

                                        if (response.errorCode == 4) {
                                            if (response.packageId == 0) {
                                                //13022023
                                                var packageUrl = response.packageUrl;
                                                var isFalse = false;
                                                var order_idpp = currentItem.attr('order_id');

                                                var link = jQuery('<a>')
                                                    .text('Select Package')
                                                    .attr('href', 'javascript:;')
                                                    .on('click', function() {
                                                        addPackageGroup(packageUrl, isFalse, order_idpp);
                                                    });

                                                jQuery(currentItem).find('.current-response').append(link);

                                                //  jQuery(currentItem).find('.current-response').append('<a onclick="addPackageGroup(\'' + response.packageUrl + ' , false ,  ' + currentItem.attr('order_id') + '\')" href="javascript:;">Select Package</a>');
                                            }
                                        }

                                    }
                                },
                                error: function(xhr) {
                                    jQuery('.loading-sbr').hide();
                                },
                            });
                        } else {
                            initialCounter = initialCounter + 1;
                            sendPrintAjaxRequest(initialCounter);

                        }
                    }
                    if (initialCounter == totalLength) {
                        // if (initialCounter == 879809989) {
                        //    jQuery('.loading-sbr').show();
                        jQuery('#loader_loader_100').show();
                        jQuery('#resend_request_shipment').hide();

                        var count = 0;
                        var interval = 50;

                        var i = setInterval(function() {
                            jQuery(".loader .loader-counter h1").html(count + "%");

                            if (++count > 100) {
                                clearInterval(i);
                                jQuery('#loader_loader_100').hide();
                                location.reload();
                            }
                        }, interval);

                    }
                }
            </script>
    <?php
    }
}


add_action('wp_ajax_update_createOrderShipment', 'update_createOrderShipment_callback');
/**
 * AJAX callback to update and create EasyPost shipment request for a given order.
 *
 * @return void Outputs JSON-encoded response with details about the updated shipment request.
 */
function update_createOrderShipment_callback()
{
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '' && get_post_type($_REQUEST['order_id']) == 'shop_order') {
        try {
            $response = updateOrderEasyPostShipmentRequest($_REQUEST['order_id']);
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
 * AJAX callback to create order shipment with new system 
 *
 */
function updateOrderEasyPostShipmentRequest($order_id)
{


    $reloadOption = false;
    $response = array();
    //ASSEMBLE OUR INSERT ARRAY
    $insertArray = array();

    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
    global $MbtPackaging, $wpdb;
    $order = wc_get_order($order_id);


    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $readyToShipOrderItem = array();
    foreach ($order->get_items() as $item_id => $item) {
        if(get_orders_matching_by_customer($order_id)){
            $response = array(
                'products' => '<ul class="print_product" ><li>---</li></ul>',
                'code' => 'error',
                'errorCode' => 1,
                'msg' => 'Duplicate orders found'
            );
            return ($response);
        }
        $product = $item->get_product();
        $product_id = $item->get_product_id();
        if ($_REQUEST['product'][$key] == SHIPPING_PROTECTION_PRODUCT) {
            continue;
        }
        $product_price = $product->get_price();
        $weight = get_post_meta($product_id, '_first_shipment_weight', true);
        if ($weight == 0) {
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
                'shipment' => 1,
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

    $customs_info = false;
    $curItemsArray = array();
    $updatedOrderItem = array();
    $productDuplicate_array = array();
    $allShipProductsWeight = 0;
    $trayData = array();
    $validationInCompleteOrder = true;
    $productsQtyShipmentLevel = array();
    if (is_array($readyToShipOrderItem) && count($readyToShipOrderItem) > 0) {


        foreach ($readyToShipOrderItem as $item_id => $productDetail) {
            if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
                $product_id = $productDetail['product_id'];
                $qty = $productDetail['qty'];
                $level = 1;
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
                if (validateShipmentLogs($order_id, $item_id, $product_id_val)) {
                } else {
                    $validationInCompleteOrder = false;
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
        }
        $productLog .= '</ul>';
    }
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


    $length = "";
    $width = "";
    $height = "";
    $parcelProductsWeight = "";

    $shipping_method_id = 0;
    foreach ($order->get_items('shipping') as $item_id => $item) {
        $shipping_method_id = $item->get_instance_id(); // The method ID
    }
    $errorCodePackaging = 4;
    if ($shipping_method_id == 24) {
        $errorCodePackaging = 4330;
        $error_log[] = "Order shipping method is Local pickup.";
    }
    $insertArray['userId'] = get_current_user_id();
    $insertArray['shipmentMethod'] = getShipmentCarrierLabel($shipping_method_id);
    $insertArray['shipmentNotes'] = '';
    $insertArray['shipmentDate'] = date("Y-m-d H:i:s");
    $insertArray['batchIdShipment'] = 0;

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
    $package_detail = $MbtPackaging->get_package_ids_for_basket($productsQtyShipmentLevel);
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
    } else {
        $reloadOption = true;

        if (isset($package_detail['combinations'])) {
            $packageNamebyId = array();
            $get_all_packages = $MbtPackaging->get_all_packages();
            foreach ($get_all_packages as $key => $package) {
                $packageNamebyId[$package->id] = $package->name;
            }
            $combinationHtml = createDuplicateCombinationHtml($packageNamebyId, $package_detail);
            $errorCodePackaging = 44;
            $error_log[] = "WARNING! Multiple shipment package combinations detected against this order. Please select one and remove ALL extra package combinations. To proceed close this box and open the order detail page in a new TAB. Then click create shipment button from there. From there you can remove all extra combinations.";
        } else {

            if ($package_detail['status'] == 0 && strpos($package_detail['message'], "out of stock") !== false) {
                $error_log[] = $package_detail['message'];
                $errorCodePackaging = 43;
            } else {
                $error_log[] = "The package plan is required.";
            }

            if (count($productsQtyShipmentLevel) > 0) {
                foreach ($productsQtyShipmentLevel as $key => $urlData) {
                    $QueryForNotFoundPackage .= '&product[' . $key . ']=' . $urlData['product_id'];
                    $QueryForNotFoundPackage .= '&qty[' . $key . ']=' . $urlData['qty'];
                    $QueryForNotFoundPackage .= '&level[' . $key . ']=' . $urlData['level'];
                }
            }
            $packageCreateUrl = $QueryForNotFoundPackage;
        }
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
            'packageUrl' => $packageCreateUrl,
            'combinationHtml' => $combinationHtml,
            'code' => 'error',
            'errorCode' => $errorCodePackaging,
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
        //  'delivery_confirmation' => @trim($_POST['shipmentLabelSignatureConfirmation']),
        'print_custom_1' => 'First Shipment',
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
            if ($productId == SHIPPING_PROTECTION_PRODUCT || in_array($productId, VIRTUAL_PRODUCTS)) {
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
        $customs_info =  $client->customsInfo->create(array(
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
        if (WP_ENV == 'production') {
            $shipmentData['carrier_accounts'] = get_easypostCarrierAccounts($insertArray['shipmentMethod']);
        }
        $shipment = $client->shipment->create($shipmentData);

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
            $selectedRate = false;
           // $selectedRate = $shipment->lowest_rate($insertArray['shipmentMethod']);
            //if ($insertArray['shipmentMethod'] == "USPS") {
            // $selectedRate = $shipment->lowest_rate("USPS");
            //}
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


        if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'woocommerce_mark_order_status' || $_REQUEST['action'] == 'update_createOrderShipment')) {
            $_REQUEST['tracking_email_shipment'] = 'yes';
            $_REQUEST['package_label_shipment'] = 'yes';
            $_REQUEST['print_label_shipment'] = 'yes';
        }


        if (isset($_REQUEST['tracking_email_shipment']) && $_REQUEST['tracking_email_shipment'] == 'yes') {
            $insertArray['trackingEmail'] = 1;
            WC()->mailer()->emails['WC_Shipment_Order_Email']->trigger($order_id);
        } else {
            $insertArray['trackingEmail'] = 0;
        }

        if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
            $packagingNote = '<div class="note_content">
                                        <p><strong>Packaging Note</strong></p>
                                        <p><strong>Tracing ID: </strong> ' . $tracking_number . '</p>
                                        <p><strong>Message: </strong>' . $_REQUEST['packaging_order_note'] . '</p>
                                        <p><strong>Status: <span style="color: green">Sent</span></strong></p>
                                    </div>';
            create_woo_order_note($packagingNote, $order_id, true);
        }
        $packaging_note = '';
        if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {
            $insertArray['packageLabelPrint'] = 1;
        } else {
            $insertArray['packageLabelPrint'] = 0;
        }
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


        $insertArray['packagingParam'] = json_encode($packing_array);
        $insertArray['productsWithQty'] = json_encode($updatedOrderItem);
        $MbtPackaging->manage_package_inventory($shipment_package_id);

        $shipment_db_id = sb_easypost_shipment($insertArray);
        if ($shipment_db_id) {
            mbt_goodToShip($order_id, 'no');
            $shipStatus = false;
            $order_shipment = array(
                'shipment_id' => $shipment_db_id,
                'order_id' => $order_id,
                'order_number' => $orderSBRref,
            );
            sb_easypost_shipment_orders($order_shipment);
            foreach ($updatedOrderItem as $item_id => $data) {
                $product_id = $data['product_id'];
                $event_data = array(
                    "order_id" => $order_id,
                    "item_id" => $item_id,
                    "shipment_id" => $shipment_db_id,
                    "product_id" => $product_id,
                    "event_id" => 2,
                );
                sb_create_log($event_data);
                //Create Log    
                $shipping_date = date("Y-m-d");
                if (isset($_REQUEST['shipping_date'])) {
                    $shipping_date = $_REQUEST['shipping_date'];
                }
                addShipmentHistory($item_id, $data['qty'], $data['type'], $tracking_number, date("Y-m-d", strtotime(@trim($shipping_date))));

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
