<?php

add_action('wp_ajax_easyPostPostageRefund', 'easyPostPostageRefund_callback');
/**
 * Callback function for processing EasyPost postage refunds via Ajax.
 *
 * @return void Outputs JSON-encoded response based on the refund request.
 */
function easyPostPostageRefund_callback() {
    global $wpdb;
    $refundSource = 'shipment';
    if (isset($_REQUEST['easyPostShipmentId']) && $_REQUEST['easyPostShipmentId'] <> '') {
        $decoded = array(
            'shipmentIds' => array($_REQUEST['easyPostShipmentId'])
        );
        $refundSource = 'order';
    } else {
        /* Receive the RAW post data. */
        $content = trim(file_get_contents("php://input"));

        /* $decoded can be used the same as you would use $_POST in $.ajax */
        $decoded = json_decode($content, true);
    }
    $responsePR = array();
    if (isset($decoded['shipmentIds']) && is_array($decoded['shipmentIds']) && count($decoded['shipmentIds']) > 0) {
        require_once(ABSPATH . 'vendor/autoload.php');
        $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
        foreach ($decoded['shipmentIds'] as $shipment_id) {
            if ($shipment_id == '') {
                $responsePR[$shipment_db_id] = array(
                    'msg' => 'Not Valid Shipment. This shipment was not generated automatically through our system and cannot be refunded.  In order to process a refund for this shipment, you must use the appropriate shipper portal (ex:  UPS, etc).',
                    'code' => 7,
                    'shipment_id' => $shipment_id,
                );
            } else {
                $q1 = "SELECT shipmentState , shipment_id , trackingCode , productsWithQty FROM  " . SB_EASYPOST_TABLE . " WHERE easyPostShipmentId  = '$shipment_id' LIMIT 1";
                $qr = $wpdb->get_row($q1);
                $shipmentState = isset($qr->shipmentState) ? $qr->shipmentState : '';
                $trackingCode = isset($qr->trackingCode) ? $qr->trackingCode : '';
                $shipment_db_id = isset($qr->shipment_id) ? $qr->shipment_id : 0;
                $productsWithQty = isset($qr->productsWithQty) ? $qr->productsWithQty : 0;


                $availableEvents = array(2, 3);
                $visibility = true;
                $shipItems = json_decode($productsWithQty, true);
                if (is_array($shipItems) && count($shipItems) > 0) {
                    foreach ($shipItems as $itemId => $item) {

                        $event_sql = "SELECT status FROM  " . SB_ORDER_TABLE . " WHERE item_id = " . $itemId;
                        $event_id = $wpdb->get_var($event_sql);
                        if (!in_array($event_id, $availableEvents)) {
                            $visibility = false;
                        }
                    }
                }

                if ($visibility === false) {
                    $responsePR = array(
                        'msg' => 'Unfortunately, a refund for this shipment is not possible as the manifest has already been generated. To refund you will need to login to Easypost and initiate a manual refund or contact the tech support team on the smile-tech channel in slack.',
                        'code' => 100,
                    );
                    echo json_encode($responsePR);
                    die;
                }


                $noteParam = array(
                    'shipment_id' => $shipment_db_id,
                    'trackingCode' => $trackingCode,
                    'productsWithQty' => $productsWithQty,
                    'source' => $refundSource,
                    'reason' => isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ''
                );
                revertOrderShipment($noteParam);

                if (@$shipmentState == '') {

                    $refundResponseArray = array();

                    // after purchasing shipment
                    //USPS requires within 30 days
                    //UPS/FEDEX requires with 90 days
                    try {
                       // $shipment = $client->shipment->retrieve($shipment_id);
                        $client->shipment->refund($shipment_id);
                        $refundResponseArray['success'] = 1;
                        $shipmentState = "Refunded-Success";
                    }
                    //if no exception then we are good
                    catch (Exception $e) {
                        //echo $e->getMessage();
                        //if failure
                        $refundResponseArray['error'] = $e->getMessage();
                        $shipmentState = "Refunded-Failed";
                    }

                    if (@$refundResponseArray['success'] != 1 && @$refundResponseArray['error'] == "") {
                        $responsePR[$shipment_db_id] = array(
                            'msg' => '#.' . $trackingCode . ' Unknown Error. An error occured while trying to request the refund.  Please contact the system administrator.',
                            'code' => 6,
                            'shipment_id' => $shipment_id,
                        );
                    } else {
                        $update = array(
                            'shipmentState' => $shipmentState,
                        );
                        $condition = array(
                            'easyPostShipmentId' => $shipment_id,
                        );
                        $createdReq = array(
                            'shipment_id' => $shipment_db_id,
                            "created_by" => get_current_user_id(),
                            "reason" => $decoded['reason'],
                            "created_date" => date("Y-m-d h:i:sa"),
                        );
                        updateEasyPostShipmentDB($update, $condition);
                        // revertOrderShipment($shipment_db_id, '');
                        /// $wpdb->insert(SB_POSTAGE_REFUND, $createdReq);
                        $responsePR[$shipment_db_id] = array(
                            'msg' => 'Refund request created against #.' . $trackingCode,
                            'code' => 1,
                            'shipment_id' => $shipment_id,
                        );
                    }
                } else if (@$shipmentState == "Refunded-Success" || @$shipmentState == "Refunded-Failed") {
                    $responsePR[$shipment_db_id] = array(
                        'msg' => 'Refund Already Attemped . It appears that a refund attempt has already been processed against #.' . $trackingCode,
                        'code' => 7,
                        'shipment_id' => $shipment_id,
                    );
                }
            }
        }

        $htmlmsg = '<ul>';
        $flag = true;
        foreach ($responsePR as $errors) {
            if ($errors['code'] != 1) {
                $flag = false;
            }
            $htmlmsg .= '<li>' . $errors['msg'] . '</li>';
        }
        $htmlmsg .= '</ul>';
        $responsehtml = array(
            'msg' => $htmlmsg,
        );
        if ($flag) {
            $responsehtml['code'] = 1;
        } else {
            $responsehtml['code'] = 10;
        }
        echo json_encode($responsehtml);
        die;
    } else {
        $responsePR = array(
            'msg' => 'Shipment Id Required',
            'code' => 5,
        );
        echo json_encode($responsePR);
        die;
    }
}
/**
 * Update shipment order item logs based on the provided parameters.
 *
 * @param int    $item_id  The WooCommerce order item ID.
 * @param array  $param    An array containing parameters for updating shipment logs.
 * @param int    $event_id The event ID associated with the update.
 *
 * @return void
 */
function updateShipmentOrderItemLogs($item_id, $param, $event_id) {
    $order_id = wc_get_order_id_by_order_item_id($item_id);
    //Create Log
    $event_data = array(
        "order_id" => $order_id,
        "item_id" => $item_id,
        "product_id" => $param['product_id'],
        "event_id" => $event_id,
    );
    if ($param['type'] == 'composite') {
        $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
        if ($shippedhistory == 1) {
            wc_update_order_item_meta($item_id, '_shipped_count', 0);
            wc_update_order_item_meta($item_id, 'shipped', 0);
        } else if ($shippedhistory == 2) {
            wc_update_order_item_meta($item_id, '_shipped_count', 1);
        }
    } else {
        $qtyShipped = 0;
        $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
        if ($shippedhistory) {
            foreach ($shippedhistory as $shippedhistoryQty) {
                $qtyShipped += (int) $shippedhistoryQty;
            }
        }
        //   echo $qtyShipped . '===';
        //  echo $param['qty'];
        if ($qtyShipped == $param['qty']) {
            wc_update_order_item_meta($item_id, 'shipped', 0);
        } else {
            if ($shippedhistory) {
                $updatedQty = array();
                foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                    if ($shippedhistoryQty != $param['qty']) {
                        if (array_key_exists($shippedhistoryDate, $updatedQty)) {
                            $updatedQty[$shippedhistoryDate] += $shippedhistoryQty;
                        } else {
                            $updatedQty[$shippedhistoryDate] = $shippedhistoryQty;
                        }
                    }
                }
                wc_update_order_item_meta($item_id, 'shipped', $updatedQty);
            }
        }
    }
    sb_create_log($event_data);
}
/**
 * Generate a hyperlink for regenerating an EasyPost shipment event.
 *
 * @param array $param An array containing parameters for generating the link.
 *
 * @return string Returns the HTML link for regenerating the EasyPost shipment event.
 */
function regenerateEasyPostShipmentEvent($param) {
    global $wpdb;
    $availableEvents = array(2, 3);
    $visibility = true;
    $shipItems = json_decode($param['productsWithQty'], true);
//    echo '<pre>';
//    print_r($shipItems);
//    echo '</pre>';
    if (is_array($shipItems) && count($shipItems) > 0) {
        foreach ($shipItems as $itemId => $item) {

            $event_sql = "SELECT status FROM  " . SB_ORDER_TABLE . " WHERE item_id = " . $itemId;
            $event_id = $wpdb->get_var($event_sql);
            if (!in_array($event_id, $availableEvents)) {
                $visibility = false;
            }
        }
    }
    if ($visibility) {
        $RegenerateUrl = add_query_arg(
                array(
            'action' => 'generate_shipment_popup',
            'order_id' => $param['order_id'],
            'layout' => 'withoutOrderLog',
            'easyPostShipmentId' => $param['easyPostShipmentId'],
            'shipment_id' => $param['shipment_id'],
                ), admin_url('admin-ajax.php')
        );
        return '<p class="create_shipping"><a style="margin-top:0px" easyPostShipmentId="' . $param['easyPostShipmentId'] . '" custom-url="' . $RegenerateUrl . '" class="RegeneratePostage button button-small" href="javascript:;" >Refund Postage</a></p>';
    } else {
        return '';
    }
}
/**
 * Revert order shipment based on the provided parameters.
 *
 * @param array $param An array containing parameters for reverting the order shipment.
 *
 * @return void
 */
function revertOrderShipment($param) {
    global $wpdb;
    $q = "SELECT  DISTINCT  order_id FROM  " . SB_SHIPMENT_ORDERS_TABLE;
    $q .= " WHERE shipment_id = '" . $param['shipment_id'] . "' ";
    $orders = $wpdb->get_col($q);
    $current_user = wp_get_current_user();
    if (is_array($orders) && count($orders) > 0) {
        foreach ($orders as $ord_id) {
            $note = '<h3>Postage Label Refunded.</h3>';
            $note .= ' (<b>Tracking Code: </b>' . $param['trackingCode'] . ')<br/>';
            $note .= ' (<b>Shipment Database ID: </b> ' . $param['shipment_id'] . ')<br/>';
            $note .= ' (<b>Time: </b>' . date("Y-m-d h:i:sa") . ')<br/>';
            $note .= ' (<b>Reason: </b>' . $param['reason'] . ')<br/>';
            $note .= ' (<b>Refunded By: </b>' . $current_user->user_login . ')';

            $notelog = ' (Tracking Code: ' . $param['trackingCode'] . ') ' . PHP_EOL . ' (Shipment Database ID: ' . $param['shipment_id'] . ')' . PHP_EOL . ' (Time: ' . date("Y-m-d h:i:sa") . ')' . PHP_EOL . ' (Reason: ' . $param['reason'] . ')' . PHP_EOL . ' ( Refunded By: ' . $current_user->user_login . ')';
            create_woo_order_note($note, $ord_id, true);
        }

        $update = array(
            'note' => $notelog,
            'log_update' => 1
        );
        $condition = array(
            "order_id" => $ord_id,
            "shipment_id" => $param['shipment_id'],
        );
        $wpdb->update(SB_LOG, $update, $condition);
        if ($param['source'] == 'order') {
            $shipItems = json_decode($param['productsWithQty'], true);
            if (is_array($shipItems) && count($shipItems) > 0) {
                foreach ($shipItems as $itemId => $item) {

                    //  $event_sql = "SELECT status FROM  " . SB_ORDER_TABLE . " WHERE item_id = " . $itemId;
                    // $event_id = $wpdb->get_var($event_sql);
                    //if ($event_id == 2) {
                    if ($item['type'] == 'composite') {
                        if ($item['shipment'] == 1) {
                            updateShipmentOrderItemLogs($itemId, $item, 1);
                        } else {
                            updateShipmentOrderItemLogs($itemId, $item, 16);
                        }
                    } else {
                        updateShipmentOrderItemLogs($itemId, $item, 1);
                    }
                    // }
                }
            }
        }
    }
}
