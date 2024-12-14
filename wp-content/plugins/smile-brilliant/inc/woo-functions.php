<?php
// Billing email validation check error message
add_action('woocommerce_checkout_process', 'sbr_billing_email_validation_check');
/**
 * Custom validation for the billing email during WooCommerce checkout process.
 * Checks if the provided email domain is on the list of fraudulent domains.
 */
function sbr_billing_email_validation_check()
{
    if (isset($_POST['billing_email'])) {
        if (get_field('fraudulent_validation', 'option')) {

            $notAllowed = array();
            if (have_rows('fraudulent_domains', 'option')) :
                while (have_rows('fraudulent_domains', 'option')) : the_row();
                    $item =  get_sub_field('item');
                    if (strlen(trim($item)) > 5)
                        if (!in_array($item, $notAllowed)) {
                            $notAllowed[] =  trim($item);
                        }
                endwhile;
            endif;
            // Make sure the address is valid
            if (filter_var($_POST['billing_email'], FILTER_VALIDATE_EMAIL)) {
                // Separate string by @ characters (there should be only one)
                $parts = explode('@', $_POST['billing_email']);

                // Remove and return the last part, which should be the domain
                $domain = array_pop($parts);

                // Check if the domain is in our list
                if (in_array($domain, $notAllowed)) {
                    $domain_checkout_error_message = get_field('domain_checkout_error_message', 'option');
                    wc_add_notice($domain_checkout_error_message, 'error');
                }
            }
        }
    }
}
add_action('wp_ajax_second_stage_kit_ready', 'second_stage_kit_ready_callback');
/**
 * AJAX callback function for marking the second stage kit as ready.
 */
function second_stage_kit_ready_callback()
{

    global $wpdb;
    $child_order_id = 0;
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    if ($_REQUEST['log_id']) {
        $log_id = $_REQUEST['log_id'];
    }


    //Create Log
    $event_data = array(
        "order_id" => $order_id,
        "item_id" => $item_id,
        "product_id" => $product_id,
        "event_id" => 16,
    );
    sb_create_log($event_data);
    echo 'added';
    exit();
}

add_action('init', 'mbt_woocommerce_clear_cart_url');
/**
 * Clears the WooCommerce cart when the 'empty-cart' parameter is present in the URL.
 */
function mbt_woocommerce_clear_cart_url()
{
    global $woocommerce;

    if (isset($_GET['empty-cart'])) {
        $woocommerce->cart->empty_cart();
    }
}
/**
 * Get shipping information by shipping method instance ID.
 *
 * @param int $shipping_id Shipping method instance ID.
 * @return array|false Array containing title, cost, and method ID if found, otherwise false.
 */
function mbt_shipping_name_by_id($shipping_id)
{


    $zones = WC_Shipping_Zones::get_zones();
    $arr = 0;
    foreach ($zones as $zn) {
        $methods = $zn['shipping_methods'];
        if (is_array($methods) && count($methods) > 0) {
            foreach ($methods as $keyM => $mt) {

                $shipping_cost = $mt->cost;
                if ($shipping_cost == '') {
                    $shipping_cost = 0;
                }
                if ($shipping_id == $mt->instance_id) {
                    $arr = array(
                        'title' => $mt->title,
                        'cost' => $shipping_cost,
                        'method' => $zn['id']
                    );
                    break;
                }
            }
        }
    }

    if ($arr) {
        return $arr;
    } else {
        return false;
    }
}
/**
 * Generate HTML image tag for a listing icon.
 *
 * @param string $icon Icon name.
 * @return string HTML image tag.
 */
function iconListingOrder($icon)
{
    return '<img src="' . site_url('wp-content/plugins/smile-brilliant/assets/images/' . $icon . '.svg') . '" class="listingIcons ' . $icon . '" />';
}
/**
 * Get and display the status of an order item.
 *
 * @param object $item    The order item object.
 * @param int    $item_id The ID of the order item.
 * @return string Status HTML representation.
 */
function get_order_item_status_mbt($item, $item_id)
{
    global $wpdb;
    $order_id = $item->get_order_id();
    $query_status = $wpdb->get_var("SELECT status FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");

    $statusAllow = array(1, 2, 3, 5, 6, 7, 8, 17, 13, 16);
    $status = 'N/A';
    if (!empty($query_status) && in_array($query_status, $statusAllow)) {
        if ($query_status == 2) {
            //     $status = 'Completed';
            $status = '<span class="oISALL oIS_' . $query_status . '">Completed</span>';
        } else if ($query_status == 1) {
            //   $status = 'Ready for ship';
            $status = '<span class="oISALL oIS_1">Ready to ship</span>';
        } else if ($query_status == 16) {
            //   $status = 'Ready for ship';
            $status = '<span class="oISALL oIS_16">Ready to ship</span>';
        } else if ($query_status == 3) {
            // $status = 'Waiting for impression';
            $status = '<span class="oISALL oIS_' . $query_status . '">Waiting for impression</span>';
        } else if ($query_status == 5) {
            // $status = 'Analyzing impression';
            $status = '<span class="oISALL oIS_' . $query_status . '">Analyzing impression</span>';
        } else if ($query_status == 17 || $query_status == 13) {
            //$status = 'Close';
            $status = '<span class="oISALL oIS_' . $query_status . '">Close</span>';
        } else {
            //$status = 'Pending lab work';
            $status = '<span class="oISALL oIS_' . $query_status . '">Pending lab work</span>';
        }
    } else {
        $query = "SELECT event_id FROM " . SB_LOG;
        $query .= " WHERE item_id = " . $item_id;
        $query .= " ORDER BY log_id DESC LIMIT 1";

        $response = $wpdb->get_var($query);
        if ($response == 2) {
            $status = '<span class="oISALL oIS_' . $response . '">Completed</span>';
        } else {
            $status = '<span class="oISALL na">N/A</span>';
            //   $status = 'N/A';
            //$status = 'Ready for ship';
        }
    }

    return $status;
}
/**
 * Get and display tracking information for an order item.
 *
 * @param int $item_id The ID of the order item.
 * @return string HTML representation of tracking information.
 */
function get_order_item_tracking_mbt($item_id)
{
    global $wpdb;

    //    $order_number = $item->get_order_id();

    $query = "SELECT DISTINCT  st.packageId  , st.easyPostLabelCarrier  , st.easyPostShipmentTrackingUrl  , st.trackingCode , st.easyPostShipmentTrackingUrl , l.order_id , l.parent_order_id , l.warranty_claim_id FROM " . SB_EASYPOST_TABLE . " as st";
    $query .= " JOIN " . SB_LOG . " as l ON l.shipment_id=st.shipment_id";
    $query .= " WHERE  l.event_id = 2 AND st.shipmentState IS  NULL  AND l.item_id = " . $item_id;
    $query .= " ORDER BY st.shipment_id ASC LIMIT 10";
    $query_tracking_number = $wpdb->get_results($query);
    $trackingHtml = 'N/A';
    if ($query_tracking_number) {
        $trackingHtml = '<table class="sbr-tracking-table">';
        $trackingHtml .= '<thead>';
        $trackingHtml .= '<tr>';
        $trackingHtml .= '<th class="sbr-tracking-id">ID</th>';
        $trackingHtml .= '<th class="packaging">Packages</th>';
        $trackingHtml .= '<th class="sbr-shipment">Shipment</th>';
        $trackingHtml .= '</tr>';
        $trackingHtml .= '</thead>';
        $trackingHtml .= '<tbody>';
        // echo 'Data: <pre>' .print_r($query_tracking_number,true). '</pre>';
        foreach ($query_tracking_number as $tracking_number) {
            $icon = site_url('wp-content/themes/revolution-child/assets/images/usps-icon.jpg');
            // $icon = get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg';
            //   $icon = 'https://assets.track.easypost.com/shared-assets/carriers/usps-logo.svg';
            if ($tracking_number->easyPostLabelCarrier == 'UPS') {
                $icon = 'https://assets.track.easypost.com/shared-assets/carriers/ups-logo.svg';
            }
            $trackingHtml .= '<tr>';
            if (!empty($tracking_number->easyPostShipmentTrackingUrl)) {
                $trackingHtml .= '<td><span class="tooltip-parent"><a class="button" target="_blank" href="' . $tracking_number->easyPostShipmentTrackingUrl . '" ><img src="' . $icon . '" style="width:26px;max-width:26px;"><span class="tooltiptext">' . $tracking_number->trackingCode . '</span></span></a></td>';
            } else {
                $trackingHtml .= '<td><span class="tooltip-parent"><a class="button" target="_blank" href="javascript:;" ><img src="' . $icon . '" style="width:26px;max-width:26px;"><span class="tooltiptext">' . $tracking_number->trackingCode . '</span></span></a></td>';
            }
            $pp = add_query_arg(
                array(
                    'id' => $tracking_number->trackingCode,
                    'type' => 'label',
                ),
                site_url('print.php')
            );
            $logs_dir = site_url('/downloads/');
            //  if($tracking_number->parent_order_id){
            if ($tracking_number->parent_order_id != 0 && $tracking_number->warranty_claim_id == 1) {
                $packageSlipUrl = $logs_dir . 'packages/' . $tracking_number->trackingCode . '_' . $tracking_number->parent_order_id . '.pdf';
                $psp = add_query_arg(
                    array(
                        'id' => $tracking_number->trackingCode . '_' . $tracking_number->parent_order_id,
                        'type' => 'slip',
                    ),
                    site_url('print.php')
                );
            } else {
                $packageSlipUrl = $logs_dir . 'packages/' . $tracking_number->trackingCode . '_' . $tracking_number->order_id . '.pdf';
                $psp = add_query_arg(
                    array(
                        'id' => $tracking_number->trackingCode . '_' . $tracking_number->order_id,
                        'type' => 'slip',
                    ),
                    site_url('print.php')
                );
            }

            $shippingLabelUrl = $logs_dir . 'labels/' . $tracking_number->trackingCode . '.png';

            if ($tracking_number->packageId != 0) {
                $trackingHtml .= '<td class="package-new-table"><div class="row-mbt-table"><a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . $packageSlipUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">View Packaging Slip</span></a>';
                $trackingHtml .= '<a class="button button-small" style="margin-bottom: 10px;"  target="_blank" href="' . $psp . '"><span class="dashicons dashicons-printer"></span><span class="tooltiptext">Print Packaging Slip</span></a>';
                $trackingHtml .= '</div></td>';
            } else {
                $trackingHtml .= '<td class="package-new-table">N/A</td>';
            }

            if (!empty($tracking_number->easyPostShipmentTrackingUrl)) {
                $trackingHtml .= '<td class="shipment_new-td"><div class="row-mbt-table"><a class="button button-small" style="margin-bottom: 10px;"  target="_blank" href="' . $shippingLabelUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">View Shipment</span></a>';
                //<div class="row-mbt">
               $trackingHtml .= '<a class="button button-small" style="margin-bottom: 10px;"  target="_blank" href="' . $pp . '"><span class="dashicons dashicons-printer"></span><span class="tooltiptext">Print Shipment Slip</span></a>';
                $trackingHtml .= '</div></td>';
            } else {
                $trackingHtml .= '<td class="shipment_new-td">N/A</td>';
            }




            $trackingHtml .= '</tr>';
        }
        $trackingHtml .= '</tbody>';
        $trackingHtml .= '</table>';
    }
    return $trackingHtml;
}

/**
 * Register custom shipment status and order status in WooCommerce.
 */
function mbt_register_custom_shipment_status_order_status()
{

    register_post_status('wc-shipped', array(
        'label' => 'Shipped',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Shipped (%s)', 'Shipped (%s)')
    ));

    register_post_status('wc-partial_ship', array(
        'label' => 'Partially Shipped',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Partially Shipped (%s)', 'Partially Shipped (%s)')
    ));
    //    register_post_status('wc-partial-refunded', array(
    //        'label' => 'Partially Refunded',
    //        'public' => true,
    //        'exclude_from_search' => false,
    //        'show_in_admin_all_list' => true,
    //        'show_in_admin_status_list' => true,
    //        'label_count' => _n_noop('Partially Refunded (%s)', 'Partially Refunded (%s)')
    //    ));
    register_post_status('wc-fraud', array(
        'label' => 'Fraud',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Fraud (%s)', 'Fraud (%s)')
    ));
}

add_action('init', 'mbt_register_custom_shipment_status_order_status');

/**
 * Add custom shipment statuses to the list of order statuses in WooCommerce.
 *
 * @param array $order_statuses The existing order statuses.
 * @return array Modified order statuses.
 */
function mbt_custom_shipment_to_order_statuses($order_statuses)
{

    $order_statuses['wc-shipped'] = 'Shipped';
    $order_statuses['wc-fraud'] = 'Fraud';
    //  $order_statuses['wc-partial-refunded'] = 'Partially Refunded';
    $order_statuses['wc-partial_ship'] = 'Partially Shipped';
    $order_statuses['wc-backordered'] = 'Backordered item';
    return $order_statuses;
}

add_filter('wc_order_statuses', 'mbt_custom_shipment_to_order_statuses');
/**
 * Update order status based on shipped quantities of items.
 *
 * @param int $order_id The ID of the order.
 * @return bool Whether the order status was updated.
 */
function mbt_addOrderStatus($order_id)
{
    $order = wc_get_order($order_id);
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

    $order_status = $order->get_status();
    if ($flagOrderStatus) {
        if ($order_status != 'partial_ship') {
            $order->update_status('partial_ship');
        }
    } else {
        if ($order_status != 'shipped') {
            $order->update_status('shipped');
        }
    }
    return $flagOrderStatus;
}
/**
 * Set the sequential order number for a newly created order.
 *
 * @param int $order_id The ID of the order.
 */
function smile_brillaint_set_sequential_order_number($order_id)
{
    if(get_post_meta($order_id,'_order_number_formatted',true)==''){
        $seq_OrderNumber = new WC_Seq_Order_Number_Pro();
        $seq_OrderNumber->set_sequential_order_number($order_id, get_post($order_id));
    }
}
/**
 * Get and update the sequential order number for a completed order.
 *
 * @param int $order_id The ID of the completed order.
 */
function smile_brillaint_get_sequential_order_number($order_id)
{
    if(get_post_meta($order_id,'order_number',true)==''){
        $seq_OrderNumber = new WC_Seq_Order_Number_Pro();
        $order_number_formatted = $seq_OrderNumber->get_order_number($order_id, wc_get_order($order_id));
        update_post_meta($order_id, 'order_number', $order_number_formatted);
    }
}

add_action('woocommerce_thankyou', 'smile_brillaint_get_sequential_order_number', 20, 1);
/**
 * Get the actual delivery date of the latest shipment associated with a specific item in an order.
 *
 * @param object $item     The order item object.
 * @param int    $item_id  The ID of the order item.
 *
 * @global wpdb $wpdb      WordPress database access abstraction object.
 *
 * @return string|null The actual delivery date or null if not found.
 */
function getLastestShipmentInfo($item, $item_id)
{
    global $wpdb;
    $order_id = $item->get_order_id();
    $query = "SELECT  actualDeliveryDate FROM  " . SB_LOG . " as l";
    $query .= " JOIN " . SB_EASYPOST_TABLE . " as st ON l.shipment_id=st.shipment_id";
    $query .= " WHERE item_id = " . $item_id . " AND event_id = 2 AND order_id = '$order_id'";
    $query .= " ORDER BY log_id DESC LIMIT 1";
    return $wpdb->get_var($query);
}

/**
 * Generate HTML for displaying and editing tray number for an order item.
 *
 * @param int    $item_id        The ID of the order item.
 * @param string $tray_number    The tray number associated with the item.
 * @param int    $information_id The information key associated with the item.
 *
 * @return string The HTML content for the tray number container.
 */
function sb_orderItemTrayHtml($item_id, $tray_number, $information_id)
{

    $html_tray = '';
    $html_tray .= '<div class="tray_number_container" data-item="' . $item_id . '">';
    $visibility_tray_edit = '';
    $visibility_tray_input = '';
    $html_tray .= '<div class="item_tray flex-row-mbt" >';



    $html_tray .= '<div class="traynumber innerpage_traynumber"><label>Tray# :</label></div>';



    if ($tray_number) {
        $visibility_tray_input = 'style="display:none;"';
    } else {
        $visibility_tray_edit = 'style="display:none;"';
    }


    $html_tray .= '<div class="traynumberEdit">';
    $html_tray .= '<span>' . $tray_number . '</span>';
    $html_tray .= '<a ' . $visibility_tray_edit . ' class="try_edit" href="javascript:;"></a>';
    $html_tray .= '</div>';




    $html_tray .= '<div class="item_tray_input flex-row-mbt" ' . $visibility_tray_input . '>';
    $html_tray .= '<input type="text" id="tray_number_' . $item_id . '" class="tray_number-input" name="tray_number" placeholder="Tray Number" value="' . $tray_number . '">';
    $html_tray .= '<input type="hidden" class="smilebrilliant_order_information_key"  value="' . $information_id . '">';
    $html_tray .= '<div class="button-parent-batch-print">';
    $html_tray .= '<div class="btn_save"><button class="btn_tray_number" type="button">Save</button></div>';
    $html_tray .= '<div class="btn_cancel"><button class="btn_tray_number_cancel" type="button" style="display:none;">Cancel</button></div>';
    $html_tray .= '</div>';
    $html_tray .= '</div>';

    $html_tray .= '</div>';
    $html_tray .= '</div>';

    return $html_tray;
}
/**
 * Get the last log ID for a specific order item, product, and order.
 *
 * @param int $item_id    The ID of the order item.
 * @param int $product_id The ID of the product.
 * @param int $order_id   The ID of the order.
 *
 * @global wpdb $wpdb     WordPress database access abstraction object.
 *
 * @return object|false The last log entry or false if not found.
 */
function sb_get_last_log_id($item_id, $product_id, $order_id)
{
    global $wpdb;
    $q_last = "SELECT  * FROM  " . SB_LOG;
    $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = '$order_id'";
    $q_last .= " ORDER BY log_id DESC LIMIT 1";
    $query_last = $wpdb->get_row($q_last);
    //$last_log_id = isset($query_last->log_id) ? $query_last[0]->log_id : 0;
    return $query_last;
}
/**
 * Get the shipment ID associated with a specific shipment ID.
 *
 * @param int $shipment_id The ID of the shipment.
 *
 * @global wpdb $wpdb     WordPress database access abstraction object.
 *
 * @return object|false The shipment data or false if not found.
 */
function get_shimpemnt_id_by_shipment($shipment_id)
{
    global $wpdb;
    $q_last = "SELECT * FROM  " . SB_EASYPOST_TABLE;
    $q_last .= " WHERE shipment_id = " . $shipment_id;
    $q_last .= " ORDER BY shipment_id DESC LIMIT 1";
    $query_last = $wpdb->get_row($q_last);
    return $query_last;
}
/**
 * Get the shipment ID associated with a specific tracking number.
 * If not found, create a new shipment entry.
 *
 * @param string $tracking_code The tracking code associated with the shipment.
 * @param int    $order_id      The ID of the order.
 *
 * @global wpdb $wpdb           WordPress database access abstraction object.
 *
 * @return int The shipment ID.
 */
function get_shimpemnt_id_by_tracking_number($tracking_code, $order_id = 0)
{
    global $wpdb;
    if ($tracking_code) {
        $q_last = "SELECT shipment_id  FROM  " . SB_EASYPOST_TABLE;
        $q_last .= " WHERE trackingCode = " . $tracking_code;
        $q_last .= " ORDER BY trackingCode DESC LIMIT 1";
        $query_last = $wpdb->get_var($q_last);
        if ($query_last) {
            return $query_last;
        } else {
            $shipment_data = array(
                "order_id" => $order_id,
                "shipment_cost" => 0,
                "tracking_code" => $tracking_code,
            );
            $shipment_id = sb_create_shipment($shipment_data);
            return $shipment_id;
        }
    } else {
        return 0;
    }
}
/**
 * Callback function for handling warranty request insertion.
 *
 * @param int    $post_id      Post ID.
 * @param object $post_after   Post object after the update.
 * @param object $post_before  Post object before the update.
 */
function warranty_request_insert_callback($post_id, $post_after, $post_before)
{
    global $wpdb;
    $current_post = get_post($post_id);
    if ($current_post->post_type == 'warranty_request' && $current_post->post_status == 'publish' && empty(get_post_meta($post_id, 'check_if_run_once'))) {
        $order_id = get_post_meta($post_id, '_order_id', true);
        if ($order_id) {
            $results = warranty_search($order_id);
            if ($results) {
                foreach ($results as $result) {
                    $result = warranty_load($result->ID);
                    foreach ($result['products'] as $warranty_product) {
                        $item_id = $warranty_product['order_item_index'];
                        $warranty_claim_id = $warranty_product['request_id'];
                        $query = $wpdb->get_results("SELECT log_id FROM  " . SB_LOG . " WHERE order_id = $order_id and item_id = $item_id and warranty_claim_id = $warranty_claim_id");
                        if (empty($query)) {
                            $event_data = array(
                                "order_id" => $order_id,
                                "warranty_claim_id" => $warranty_claim_id,
                                "item_id" => $item_id,
                                "product_id" => $warranty_product['product_id'],
                                "event_id" => 10,
                            );
                            sb_create_log($event_data);
                        }
                    }
                }
            }
        }
    }
}
// Hook the warranty request insertion callback to an action.
add_action('wc_warranty_status_updated', 'wc_warranty_item_returned_update_log_callback', 10, 3);

/**
 * Callback function for handling warranty item status updates and logging events.
 *
 * @param int    $warranty_id  Warranty ID.
 * @param string $new_status   New warranty status.
 * @param string $prev_status  Previous warranty status.
 */
function wc_warranty_item_returned_update_log_callback($warranty_id, $new_status, $prev_status)
{

    $do_insert = false;
    if ($new_status == $prev_status) {
        return;
    }
    $result = warranty_load($warranty_id);
    $order_id = $result['order_id'];
    if ($new_status == 'new') {
        /* Added by Meta */
    } else if ($new_status == 'reviewing') {
        $do_insert = true;
    } else if ($new_status == 'rejected') {
        $do_insert = true;
    } else if ($new_status == 'processing') {
        $do_insert = true;
    } else if ($new_status == 'completed') {
        $do_insert = true;
    }
    if ($do_insert) {
        foreach ($result['products'] as $warranty_product) {
            $item_id = $warranty_product['order_item_index'];

            $event_data = array(
                "order_id" => $order_id,
                "warranty_claim_id" => $warranty_id,
                "warranty_status" => $new_status,
                "item_id" => $item_id,
                "product_id" => $warranty_product['product_id'],
                "event_id" => 14,
            );
            sb_create_log($event_data);
        }
    }
    // die;
}
/**
 * Generate HTML for displaying order item activity log.
 *
 * This function generates HTML markup for displaying the activity log of an order item.
 *
 * @param array   $query       The array of log entries for the order item.
 * @param int     $item_id     The ID of the order item.
 * @param int     $product_id  The ID of the product associated with the order item.
 * @param int     $order_id    The ID of the order to which the item belongs.
 * @param int     $loadMore    Flag indicating whether to load more log entries.
 *
 * @return string HTML markup for the order item activity log.
 */
function sb_orderItemHtml($query, $item_id, $product_id, $order_id, $loadMore = 0)
{

    global $wpdb;
    $last_log_id = 0;
    $last_event_id = 0;
    $last_log = sb_get_last_log_id($item_id, $product_id, $order_id);
    //  $orderItemRecord = $wpdb->get_row("SELECT * FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");

    if (isset($last_log->log_id)) {
        $last_log_id = $last_log->log_id;
    }
    if (isset($last_log->event_id)) {
        $last_event_id = $last_log->event_id;
    }

    $html = '<td colspan="8">';
    $html .= '<table class="table table-striped table-bordered mbttable mbt_smile" id="dest" style="width: 100%;">';
    $html .= '<thead class="thead-dark">';
    $html .= '<tr>';
    $html .= '<th class="col1 txt-left th-activity">Activity Phase</th>';
    $html .= '<th class="col2 txt-left th-date">Activity Date<div class="arrow-container"><div class="arrow-up" action="up" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '"></div><div class="arrow-down"  action="down" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '"></div></div></th>';
    $html .= '<th class="col3 txt-left th-status">Status</th>';
    $html .= '<th class="col4 txt-left th-action">Actions</th>';
    $html .= '<th class="col4 txt-left th-action">Notes</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    $loop_last_ID = 0;

    foreach ($query as $response) {

        $loop_last_ID = $response->log_id;
        $html .= '<tr id="logid_'.$loop_last_ID.'">';
        if ($response->event_id == 8 || $response->event_id == 12) {
            $sbrOrderId = get_post_meta($response->child_order_id, 'order_number', true);
            $html .= '<td class="txt-left col1 td-activity">' . $response->event_name . '</td>';
        } else if ($response->event_id == 11) {
            $html .= '<td class="txt-left col1 td-activity">' . $response->event_name . ' #' . $response->warranty_claim_id . '</td>';
        } else if ($response->event_id == 14 || $response->event_id == 15) {
            $rma_url = admin_url('admin.php?page=warranties&s=' . get_post_meta($response->warranty_claim_id, '_code', true));
            $html .= '<td class="txt-left col1 td-activity"><a  target="_blank" href="' . $rma_url . '">RMA #' . $response->warranty_claim_id . '</a></td>';
        } else {
            $html .= '<td class="txt-left col1 td-activity">' . $response->event_name . '</td>';
        }


        $html .= '<td class="txt-left col2 td-date">' . sbr_datetime($response->created_date) . '</td>';

        if ($response->event_id == 11) {
            if (get_post_meta($response->warranty_claim_id, '_request_type', true) == 'replacement') {
                $html .= '<td class="txt-left statusbx col3 td-status "><span class="' . sanitize_title($response->status) . '">Replace Product</span></td>';
            } else {
                $html .= '<td class="txt-left statusbx col3 td-status money-refund"><span class="' . sanitize_title($response->status) . '">Money Refund</span></td>';
            }
        } else if ($response->event_id == 14) {
            $html .= '<td class="txt-left col1 td-activity"><span class="' . sanitize_title($response->status) . '">' . ucfirst($response->warranty_status) . '</span></td>';
        } else {
            $html .= '<td class="txt-left statusbx col3 td-status"><span class="' . sanitize_title($response->status) . '">' . $response->status . '</span></td>';
        }


        $html .= '<td class="txt-left col4 td-action" id="td_tracking_id_' . $response->item_id . '">';
        $customer_chat = add_query_arg(
            array(
                'action' => 'create_customer_popup',
                'order_id' => $order_id,
                'product_id' => $product_id,
                'item_id' => $item_id,
                //'ticket_id' => $response->ticket_id,
                'log_id' => $response->log_id,
            ),
            admin_url('admin-ajax.php')
        );

        $addOnOrder = add_query_arg(
            array(
                'action' => 'create_addon_order_popup',
                'order_id' => $order_id,
                'product_id' => $product_id,
                'event_id' => $response->event_id,
                'warranty_claim_id' => $response->warranty_claim_id,
                'item_id' => $item_id,
                'log_id' => $response->log_id,
                'impression_status' => $response->extra_information,
            ),
            admin_url('admin-ajax.php')
        );


        $splitOrder = add_query_arg(
            array(
                'action' => 'split_order',
                'order_id' => $order_id,
                'product_id' => $product_id,
                'event_id' => $response->event_id,
                'splitOrder' => 1,
                'item_id' => $item_id,
                'log_id' => $response->log_id,
                'impression_status' => $response->extra_information,
            ),
            admin_url('admin-ajax.php')
        );





        if ($response->event_id == 1 || $response->event_id == 16) {

            if ($last_log_id != $response->log_id) {
                // $html .= '<p class="shipped">' . $response->event_description . '</p>';
            } else {
                $ajax_url = add_query_arg(
                    array(
                        'action' => 'generate_shipment_popup',
                        'order_id' => $order_id,
                    ),
                    admin_url('admin-ajax.php')
                );

                $html .= '<p class="create_shipping"><a style="margin-top:0px" item_id="' . $response->item_id . '" custom-url="' . $ajax_url . '" class="create_sb_shipment button button-small" href="javascript:;" >' . $response->event_description . '</a></p>';
                if ($response->event_id == 1) {
                    //  $html .= '<p class="create_shipping"><a item_id="' . $response->item_id . '" class="create_shipping_metabox" href="javascript:;" >' . $response->event_description . '</a></p>';
                    $html .= '<p class="tracking_number_container" id="tracking_number_' . $item_id . '">';
                    $html .= '<input type="text" id="input_tracking_number_' . $item_id . '" class="tracking_number_input" name="tracking_number" placeholder="Tracking Number" value="">';
                    $html .= '<input type="hidden" class="order_number"  value="' . $order_id . '">';
                    $html .= '<input type="hidden" class="item_number"  value="' . $item_id . '">';
                    $html .= '<input type="hidden" class="product_id"  value="' . $product_id . '">';
                    if ($response->child_order_id) {
                        $html .= '<input type="hidden" class="event_id"  value="repeat">';
                    } else {
                        $html .= '<input type="hidden" class="event_id"  value="' . $response->event_id . '">';
                    }
                    $html .= '<button class="btn_tracking_number" id="btn_tracking_number_' . $item_id . '" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>';
                    $html .= '</p>';
                }
            }
        } else if ($response->event_id == 6) {

            $ajax_url = add_query_arg(
                array(
                    'action' => 'second_stage_kit_ready',
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'event_id' => $response->event_id,
                    'item_id' => $item_id,
                    'log_id' => $response->log_id,
                ),
                admin_url('admin-ajax.php')
            );
            if ($last_log_id == $response->log_id) {

                $removeActivity = add_query_arg(
                    array(
                        'action' => 'removeActivity',
                        'log_id' => $response->log_id,
                    ),
                    admin_url('admin-ajax.php')
                );
                $html .= '&nbsp;&nbsp;<a class="button button-small removeActivity"  href="javascript:;"  order_id="' . $order_id . '" custom-url="' . $removeActivity . '" >Revert Impression</a>';
                $html .= '<p><a style="margin-top:0px" item_id="' . $response->item_id . '" order_id="' . $order_id . '" custom-url="' . $ajax_url . '" class="kit_ready button button-small" href="javascript:;" >' . $response->event_description . '</a></p>';
            }
        } else if ($response->event_id == 2) {
            $shipment_detail = get_shimpemnt_id_by_shipment($response->shipment_id);
            //echo 'Data: <pre>' .print_r( $shipment_detail ,true). '</pre>';
            $tracking_code = isset($shipment_detail->trackingCode) ? $shipment_detail->trackingCode : '';
            $shipment_method_carrier = isset($shipment_detail->easyPostLabelCarrier) ? $shipment_detail->easyPostLabelCarrier : '';
            $print_label = isset($shipment_detail->easyPostLabelPNG) ? $shipment_detail->easyPostLabelPNG : '';
            $easypost_tracking_url = isset($shipment_detail->easyPostShipmentTrackingUrl) ? $shipment_detail->easyPostShipmentTrackingUrl : '';
            $html .= '<p class="shipped">';


            //$html .= 'Carrier&nbsp;'.$shipment_method_carrier;
            $imageUrl = '';
            if ($shipment_method_carrier == 'USPS') {
                $imageUrl = '<img src="https://assets.track.easypost.com/shared-assets/carriers/usps-logo.svg" width="150" height="75"/>';
            }
            if ($shipment_method_carrier == 'UPS') {
                $imageUrl = '<img src="https://assets.track.easypost.com/shared-assets/carriers/ups-logo.svg" width="150" height="75"/>';
            }
            if ($response->extra_information == 10) {
                $html .= '<a href="javascript:;" target="_blank" class="track_shipment" >' . $imageUrl . '</a>';
                $html .= '<br/>';
                $html .= $response->event_description . '<a href="javascript:;" target="_blank" class="track_shipment" >' . $tracking_code . '</a>';
                $html .= '<br/>';
            } else {
                $html .= '<a href="' . $easypost_tracking_url . '" target="_blank" class="track_shipment" >' . $imageUrl . '</a>';
                $html .= '<br/>';
                $html .= $response->event_description . '<a href="' . $easypost_tracking_url . '" target="_blank" class="track_shipment" >' . $tracking_code . '</a>';
                $html .= '<br/>';
            }


            if ($response->parent_order_id != 0 && $response->warranty_claim_id == 1) {
                $psp = add_query_arg(
                    array(
                        'id' => $shipment_detail->trackingCode . '_' . $response->parent_order_id,
                        'type' => 'slip',
                    ),
                    site_url('print.php')
                );
            } else {
                $psp = add_query_arg(
                    array(
                        'id' => $shipment_detail->trackingCode . '_' . $order_id,
                        'type' => 'slip',
                    ),
                    site_url('print.php')
                );
            }

            $pp = add_query_arg(
                array(
                    'id' => $shipment_detail->trackingCode,
                    'type' => 'label',
                ),
                site_url('print.php')
            );
            if ($response->parent_order_id != 0 && $response->warranty_claim_id == 1) {
                $packageSlipUrl = SB_DOWNLOAD . 'packages/' . $shipment_detail->trackingCode . '_' . $response->parent_order_id . '.pdf';
            } else {
                $packageSlipUrl = SB_DOWNLOAD . 'packages/' . $shipment_detail->trackingCode . '_' . $order_id . '.pdf';
            }
            if ($response->extra_information != 10) {
                if ($response->extra_information != 11) {
                    $html .= '<a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . $packageSlipUrl . '">Package Slip</a>';
                    $html .= '<a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . $psp . '">Print Package Slip</a>';
                }

                $html .= '<a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . SB_DOWNLOAD . 'labels/' . $shipment_detail->trackingCode . '.png' . '">Shipping Label</a>
            <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . $pp . '">Print Label</a>
            <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . $shipment_detail->easyPostShipmentTrackingUrl . '">Track Shipment</a>';
            }
            $html .= '<a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=shipment_info&shipment_id=' . $response->shipment_id) . '">View Detail</a>';
            $html .= '</p>';

            $RegenerateShipment = array(
                'action' => 'generate_shipment_popup',
                'order_id' => $order_id,
                'layout' => 'withoutOrderLog',
                'easyPostShipmentId' => $shipment_detail->easyPostShipmentId,
                'shipment_id' => $shipment_detail->shipment_id,
                'last_log_id' => $last_log_id,
                'log_id' => $response->log_id,
                'productsWithQty' => $shipment_detail->productsWithQty,
            );
            $html .= regenerateEasyPostShipmentEvent($RegenerateShipment);
        } else if ($response->event_id == 3) {
            if ($last_log_id != $response->log_id) {
                //$html .= '<span class="process-order">Impression Received</span>';
            } else {
                $html .= '<a class="button sbr-button check-mbt" onClick="sbr_impressionReceived(' . $item_id . ' , ' . $product_id . ' , ' . $order_id . ' , ' . $response->log_id  . ' ,  2)"  id="btn_impressionReceived_' . $item_id . '" href="javascript:;" ><span class="dashicons dashicons-yes"></span><span class="tooltiptext">Impression Received</span>Acknowledged Receipt</a>';
                if (get_current_user_id() == 2) {
                    $html .= '<a class="button sbr-button check-mbt" onClick="sbr_markAsCompleteItem(' . $item_id . ' , ' . $product_id . ' , ' . $order_id . ' , ' . $response->log_id  . ')"  id="btn_markAsCompleteItem_' . $item_id . '" href="javascript:;" >Mark as complete</a>';
                }
                //$html .= '<p><a class="create_acknowledged accept-case button button-small" action="recipt" href="javascript:;"  log_id="' . $response->log_id . '" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '">Acknowledged Receipt</a></p>';
            }
        } else if ($response->event_id == 4) {
            $shipment_detail = get_shimpemnt_id_by_shipment($response->shipment_id);
            $easypost_tracking_url = isset($shipment_detail->tracking_url) ? $shipment_detail->tracking_url : '';
            $tracking_code = isset($shipment_detail->trackingCode) ? $shipment_detail->trackingCode : '';
            $print_label = isset($shipment_detail->url) ? $shipment_detail->url : '';
            if ($last_log_id != $response->log_id) {
                $html .= '<a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=shipment_info&shipment_id=' . $response->shipment_id) . '">View Detail</a>';
            } else {

                $html .= '<p class="create_shipping">' . $response->event_description . '</p>';
                $html .= '<p  class="tracking_number_container" id="tracking_number_' . $response->item_id . '">';
                $html .= '<input type="text" id="input_tracking_number_' . $response->item_id . '" class="tracking_number_input" name="tracking_number" placeholder="Tracking Number" value="">';
                $html .= '<input type="hidden" class="order_number"  value="' . $response->order_id . '">';
                $html .= '<input type="hidden" class="item_number"  value="' . $response->item_id . '">';
                $html .= '<input type="hidden" class="product_id"  value="' . $response->product_id . '">';
                $html .= '<input type="hidden" class="log_id"  value="' . $response->log_id . '">';
                $html .= '<input type="hidden" class="event_id"  value="return">';
                $html .= '<button class="btn_tracking_number" id="btn_tracking_number_' . $response->item_id . '" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>';
                $html .= '</p>';
            }
        } else if ($response->event_id == 5) {

            if ($last_log_id != $response->log_id) {

                /*
                  if ($response->extra_information == '00') {
                  $html .= '<span style="color:red">Both impressions bad</span>';
                  } else if ($response->extra_information == '01') {
                  $html .= '<span style="color:red">Upper impression bad</span><br/>';
                  $html .= '<span style="color:#1eb400">Lower impression good</span>';
                  } else if ($response->extra_information == '10') {
                  $html .= '<span style="color:#1eb400">Upper impression good</span><br/>';
                  $html .= '<span style="color:red">Lower impression bad</span>';
                  } else if ($response->extra_information == '11') {
                  $html .= '<span style="color:#1eb400">Both impressions good</span>';
                  } else if ($response->extra_information == '4') {
                  $html .= '<span style="color:#1eb400">Impression good</span>';
                  } else if ($response->extra_information == '3') {
                  $html .= '<span style="color:red">Impression bad</span>';
                  }
                 */
            } else {
                $analyze_url = add_query_arg(
                    array(
                        'action' => 'analyze_impression_putty',
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'item_id' => $item_id,
                        'log_id' => $response->log_id,
                        'impression_status' => $response->extra_information,
                    ),
                    admin_url('admin-ajax.php')
                );
                $html .= '<a class="sb_analyze_impression button button-small" href="javascript:;"  custom-url="' . $analyze_url . '" >Analyze Impression Putty</a>';
                $html .= SplitOrderForLog($splitOrder, $order_id);
            }
        } else if ($response->event_id == 7) {

            if ($response->log_update) {
                // if ($last_log_id != $response->log_id) {
                if ($response->event_id == 8) {
                    $html .= '<span class="process-order">Process Order</span>';
                } else {
                    $html .= '<a class="view_child_order button button-small"  target="_blank" href="' . get_edit_post_link($response->child_order_id) . '">View Order</a>';
                    $html .= getUserChatForLog($customer_chat);
                }
            } else {
                $html .= addOnOrderForLog($addOnOrder);
                $html .= saveOrderIdForRMA($response);
                $html .= getUserChatForLog($customer_chat);
            }
            if (($last_log_id == $response->log_id) && ($response->event_id == 6 || $response->event_id == 7)) {
                $removeActivity = add_query_arg(
                    array(
                        'action' => 'removeActivity',
                        'log_id' => $response->log_id,
                    ),
                    admin_url('admin-ajax.php')
                );
                $html .= '&nbsp;&nbsp;<a class="button button-small removeActivity"  order_id="' . $order_id . '"  href="javascript:;"  custom-url="' . $removeActivity . '" >Revert Impression</a>';
            }
        } else if ($response->event_id == 10) {
            $rma_url = admin_url('admin.php?page=warranties&s=' . get_post_meta($response->warranty_claim_id, '_code', true));
            $html .= '<a  target="_blank" href="' . $rma_url . '">RMA #' . $response->warranty_claim_id . '</a>';
        } else if ($response->event_id == 17) {
            $parentOrderNumber = get_post_meta($response->child_order_id, 'order_number', true);
            $html .= '<a class="button button-small"  target="_blank" href="' . get_edit_post_link($response->child_order_id) . '">View Splitted Order : ' . $parentOrderNumber . '</a>';
        } else if ($response->event_id == 11) {
            $rma_url = admin_url('admin.php?page=warranties&s=' . get_post_meta($response->warranty_claim_id, '_code', true));
            $html .= '<a  target="_blank" href="' . $rma_url . '">RMA #' . $response->warranty_claim_id . '</a>';
        } else if ($response->event_id == 14) {
            $customer_chat = add_query_arg(
                array(
                    'action' => 'create_customer_popup',
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'item_id' => $item_id,
                    //  'ticket_id' => $response->ticket_id,
                    'log_id' => $response->log_id,
                ),
                admin_url('admin-ajax.php')
            );
            if ($response->warranty_status == 'processing') {
                if (get_post_meta($response->warranty_claim_id, '_request_type', true) == 'replacement') {
                    if ($response->child_order_id) {

                        $html .= '<a class="view_child_order button button-small"  target="_blank" href="' . get_edit_post_link($response->child_order_id) . '">View Order</a>';
                        //$html .= '&nbsp;<a class="customer_chat button button-small sb_customer_chat" href="javascript:;"  custom-url="' . $customer_chat . '" >Contact Customer</a>';
                        $html .= getUserChatForLog($customer_chat);
                    } else {

                        if ($last_log_id == $response->log_id) {
                            $html .= addOnOrderForLog($addOnOrder);
                            $html .= saveOrderIdForRMA($response);
                            //claim_warranty 
                            $html .= getUserChatForLog($customer_chat);
                            $html .= '<a class="reject_item button button-small" href="javascript:;"  item_id="' . $item_id . '" log_id="' . $response->log_id . '"   >Reject this Item</a>';
                        } else {
                            $html .= getUserChatForLog($customer_chat);
                        }
                    }
                } else {
                    if ($response->log_update) {
                        // $html .= 'Rejected Item';
                        //$html .= '<a class="customer_chat button button-small sb_customer_chat" href="javascript:;"  custom-url="' . $customer_chat . '" >Contact Customer</a>';
                        $html .= getUserChatForLog($customer_chat);
                    } else {
                        $html .= '<a class="create_warranty_request button button-small" item_id="' . $item_id . '" log_id="' . $response->log_id . '" href="javascript:;">Inititate Warranty to customer</a>';
                        $html .= '<a class="reject_item button button-small" href="javascript:;"  item_id="' . $item_id . '" log_id="' . $response->log_id . '"   >Reject this Item</a>';
                        $html .= getUserChatForLog($customer_chat);
                        //$html .= '&nbsp;|&nbsp;<a class="customer_chat button button-small sb_customer_chat" href="javascript:;"  custom-url="' . $customer_chat . '" >Contact Customer</a>';
                    }
                }
            } else {
                $rma_url = admin_url('admin.php?page=warranties&s=' . get_post_meta($response->warranty_claim_id, '_code', true));
                $html .= '<a  target="_blank" href="' . $rma_url . '">RMA #' . $response->warranty_claim_id . '</a>';
            }
        } else {
            $html .= '<p class="else-case">' . $response->event_description . '</p>';
        }

        $add_activity_note = add_query_arg(
            array(
                'order_id' => $order_id,
                'action' => 'add_activity_note',
                'log_id' => $response->log_id,
            ),
            admin_url('admin-ajax.php')
        );

        $delete_activity_note = add_query_arg(
            array(
                'order_id' => $order_id,
                'action' => 'delete_activity_log',
                'log_id' => $response->log_id,
            ),
            admin_url('admin-ajax.php')
        );

        $html .= '<td>';
        if ($response->note) {            
            $html .= '<span style="float:right;"><a class="button button-small sb_activity_note edit" id="sb_activity_note_' . $response->log_id . '" href="javascript:;"  custom-url="' . $add_activity_note . '" ></a>';
            $html .= '<a class="button button-small delete_activity_log delete" id="sb_activity_log_' . $response->log_id . '" href="javascript:;"  custom-url="' . $delete_activity_note . '" >Delete</a></span>';
            $html .= wp_trim_words($response->note, 10);
        } else {
            $html .= '<span style="float:right;"><a class="button button-small sb_activity_note" id="sb_activity_note_' . $response->log_id . '" href="javascript:;"  custom-url="' . $add_activity_note . '" >Add log note</a>';
            $html .= '<a class="button button-small delete_activity_log delete" id="sb_activity_log_' . $response->log_id . '" href="javascript:;"  custom-url="' . $delete_activity_note . '" >Delete</a></span>';
        }

        $html .= '</td>';
        $html .= '</td>';
        $html .= '</tr>';
    }
    if ($loadMore) {
        $html .= '<tr>';
        $html .= '<td colspan="8" style="text-align: center;" class="readmore-td">';
        $html .= '<a href="javascript:;" class="load_more_item" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '">Load More</a>';
        $html .= '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</td>';
    return $html;
}
/**
 * Create a log entry and update order item status.
 *
 * @param array $param {
 *     Array of parameters for log entry and order item status update.
 *
 *     @type int    $order_id            Order ID.
 *     @type int    $child_order_id      Child order ID.
 *     @type int    $item_id             Item ID.
 *     @type int    $product_id          Product ID.
 *     @type int    $event_id            Event ID.
 *     @type int    $shipment_id         Shipment ID.
 *     @type int    $warranty_claim_id   Warranty claim ID.
 *     @type string $warranty_status     Warranty status.
 *     @type string $note                Note.
 *     @type string $extra_information   Extra information.
 *     @type int    $parent_order_id     Parent order ID.
 *     @type string $created_date        Created date.
 * }
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return false|int Inserted log entry ID on success, false if the last entry is event_id 17.
 */
function sb_create_log($param = array())
{
    global $wpdb;


    $data = array(
        "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "child_order_id" => isset($param['child_order_id']) ? $param['child_order_id'] : 0,
        "item_id" => isset($param['item_id']) ? $param['item_id'] : 0,
        "product_id" => isset($param['product_id']) ? $param['product_id'] : 0,
        "event_id" => isset($param['event_id']) ? $param['event_id'] : 0,
        "shipment_id" => isset($param['shipment_id']) ? $param['shipment_id'] : 0,
        "warranty_claim_id" => isset($param['warranty_claim_id']) ? $param['warranty_claim_id'] : 0,
        "warranty_status" => isset($param['warranty_status']) ? $param['warranty_status'] : '',
        "note" => isset($param['note']) ? $param['note'] : '',
        "extra_information" => isset($param['extra_information']) ? $param['extra_information'] : '',
        "parent_order_id" => isset($param['parent_order_id']) ? $param['parent_order_id'] : 0,
        //   "created_date" => date("Y-m-d h:i:sa"),
    );
    if (isset($param['created_date'])) {
        $data['created_date'] = $param['created_date'];
    }
    $q_last = "SELECT  event_id FROM  " . SB_LOG;
    $q_last .= " WHERE item_id = " . $data['item_id'] . " AND product_id = " . $data['product_id'] . " AND order_id = " . $data['order_id'];
    $q_last .= " ORDER BY log_id DESC LIMIT 1";
    $query_last = $wpdb->get_var($q_last);
    if ($query_last != 17) {
        $wpdb->insert(SB_LOG, $data);
        $insert_id = $wpdb->insert_id;
        updateOrderItemStatus($param);
        return $insert_id;
    } else {
        return false;
    }
    //    $wpdb->insert(SB_LOG, $data);
    //    $insert_id = $wpdb->insert_id;
    //    updateOrderItemStatus($param);
    //
    //    return $insert_id;
}

/**
 * Update order item status based on the event.
 *
 * @param array $param {
 *     Array of parameters for updating order item status.
 *
 *     @type int $order_id    Order ID.
 *     @type int $item_id     Item ID.
 *     @type int $product_id  Product ID.
 *     @type int $event_id    Event ID.
 * }
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function updateOrderItemStatus($param)
{
    global $wpdb;
    $statusAllow = array(1, 2, 3, 5, 6, 7, 8, 16, 17);
    //if (isset($param['event_id']) && in_array($param['event_id'], $statusAllow)) {
    $update = array(
        'status' => $param['event_id'],
    );
    $condition = array(
        "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "item_id" => isset($param['item_id']) ? $param['item_id'] : 0,
        "product_id" => isset($param['product_id']) ? $param['product_id'] : 0,
    );
    $wpdb->update(SB_ORDER_TABLE, $update, $condition);
    //}
}

/**
 * Create a shipment entry.
 *
 * @param array $param {
 *     Array of parameters for creating a shipment entry.
 *
 *     @type int    $order_id                 Order ID.
 *     @type string $shipment_method          Shipment method (default: 'USPS').
 *     @type int    $shipment_id_easypost     Shipment ID from EasyPost.
 *     @type string $shipment_method_carrier  Shipment method carrier.
 *     @type string $shipment_method_service  Shipment method service.
 *     @type float  $shipment_cost            Shipment cost.
 *     @type string $url                      URL.
 *     @type int    $tracking_url             Tracking URL.
 *     @type string $shipment_label           Shipment label.
 *     @type int    $tracking_code            Tracking code.
 *     @type int    $shipping_information     Shipping information.
 *     @type int    $shipping_date            Shipping date.
 * }
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return int Inserted shipment entry ID.
 */
function sb_create_shipment($param = array())
{
    global $wpdb;
    $data = array(
        "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "shipment_method" => isset($param['shipment_method']) ? $param['shipment_method'] : 'USPS',
        "shipment_id_easypost" => isset($param['shipment_id_easypost']) ? $param['shipment_id_easypost'] : 0,
        "shipment_method_carrier" => isset($param['shipment_method_carrier']) ? $param['shipment_method_carrier'] : '',
        "shipment_method_service" => isset($param['shipment_method_service']) ? $param['shipment_method_service'] : '',
        "shipment_cost" => isset($param['shipment_cost']) ? $param['shipment_cost'] : 0,
        "url" => isset($param['url']) ? $param['url'] : '',
        "tracking_url" => isset($param['tracking_url']) ? $param['tracking_url'] : 0,
        "shipment_label" => isset($param['shipment_label']) ? $param['shipment_label'] : '',
        "tracking_code" => isset($param['tracking_code']) ? $param['tracking_code'] : 0,
        "shipping_information" => isset($param['shipping_information']) ? $param['shipping_information'] : 0,
        "shipping_date" => isset($param['shipping_date']) ? $param['shipping_date'] : 0,
        //   "created_date" => date("Y-m-d h:i:sa"),
    );
    $wpdb->insert(SB_SHIPPING_TABLE, $data);
    return $wpdb->insert_id;
}
/**
 * Generate HTML markup for displaying old order item information.
 *
 * @param string $activity Activity description.
 * @param string $date     Date information.
 * @param string $status   Status information.
 * @param string $action   Action information.
 *
 * @return string Generated HTML markup.
 */
function sb_old_orderItemHtml($activity = '', $date = '', $status = '', $action = '')
{

    $html = '<td colspan="8">';
    $html .= '<table class="table table-striped table-bordered mbttable mbt_smile" id="dest" style="width: 100%;">';
    $html .= '<thead class="thead-dark">';
    $html .= '<tr>';
    $html .= '<th class="col1 txt-left th-activity">Activity</th>';
    $html .= '<th class="col2 txt-left th-date">Date<div class="arrow-container"></th>';
    $html .= '<th class="col3 txt-left th-status">Status</th>';
    $html .= '<th class="col4 txt-left th-action">Actions</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    $html .= '<tr>';
    $html .= '<td class="txt-left col1 td-activity">' . $activity . '</td>';
    $html .= '<td class="txt-left col2 td-date">' . $date . '</td>';
    $html .= '<td class="txt-left statusbx col3 td-status">' . $status . '</td>';
    $html .= '<td class="txt-left col4 td-action">' . $action . '</td>';
    $html .= '</tr>';
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</td>';
    return $html;
}

add_filter('woocommerce_checkout_get_value', 'checkout_get_value_filter', 10, 2);
/**
 * Filter callback to modify values during WooCommerce checkout.
 *
 * @param mixed  $value Original value.
 * @param string $input Input field name.
 *
 * @return mixed Filtered value.
 */
function checkout_get_value_filter($value, $input)
{
    if (!is_user_logged_in()) {

        if ('billing_country' === $input || 'shipping_country' === $input || 'billing_state' === $input || 'shipping_state' === $input) {
            return '';
        }
    }
}
/**
 * Generate HTML markup for a "Split Order" link.
 *
 * @param string $splitOrder Custom URL for splitting the order.
 * @param int    $order_id   Order ID.
 *
 * @return string Generated HTML markup.
 */
function SplitOrderForLog($splitOrder, $order_id = 0)
{
    return '<a class="splitOrder button button-small refresh"  data-order-id="' . $order_id . '" href="javascript:;"  custom-url="' . $splitOrder . '" >Split Order</a>';
}
/**
 * Generate HTML markup for an "Add-on Order" link.
 *
 * @param string $addOnOrder Custom URL for creating an add-on order.
 *
 * @return string Generated HTML markup.
 */
function addOnOrderForLog($addOnOrder)
{
    return '<a class="addon_order button button-small sb_addon_order" href="javascript:;"  custom-url="' . $addOnOrder . '" >Create Order</a>';
}
/**
 * Generate HTML markup for a "Contact Customer" link.
 *
 * @param string $customer_chat Custom URL for contacting the customer.
 *
 * @return string Generated HTML markup.
 */
function getUserChatForLog($customer_chat)
{
    return '<a class="customer_chat button button-small sb_customer_chat" href="javascript:;"  custom-url="' . $customer_chat . '" >Contact Customer</a>';
}
/**
 * Generate HTML markup for saving Order ID in RMA.
 *
 * @param object $response Response object.
 *
 * @return string Generated HTML markup.
 */
function saveOrderIdForRMA($response)
{
    return '';
    $html = '<p  class="orderIdRMA_container" id="orderIdRMA_' . $response->item_id . '">';
    $html .= '<input type="text" id="input_orderIdRMA_' . $response->item_id . '" class="orderIdRMA_input" name="orderIdRMA" placeholder="Order ID" value="">';
    $html .= '<input type="hidden" class="  "  value="' . $response->order_id . '">';
    $html .= '<input type="hidden" class="item_number"  value="' . $response->item_id . '">';
    $html .= '<input type="hidden" class="product_id"  value="' . $response->product_id . '">';
    $html .= '<input type="hidden" class="event_id"  value="' . $response->event_id . '">';
    $html .= '<button class="btn_orderIdRMA button button-small" id="btn_orderIdRMA_' . $response->item_id . '" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>';
    $html .= '</p>';
    return $html;
}
