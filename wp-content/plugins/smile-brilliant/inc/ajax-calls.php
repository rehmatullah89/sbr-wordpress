<?php

/**
 * Format a date according to the site's date format settings.
 *
 * @param string $date The date to be formatted.
 * @return string Formatted date based on the site's date format settings.
 */
function sbr_date($date)
{
    //date_default_timezone_set('America/Chicago');
    //   return date('m-d-Y', strtotime($date));
    return date(get_option('date_format'), strtotime($date));
}

/**
 * Custom function to display the post date and time in a specific format in the post column.
 *
 * @param string $h_time The HTML-formatted time string.
 * @param WP_Post $post The current post object.
 * @return string Formatted date and time based on the post's GMT date.
 */
//add_filter('woocommerce_admin_order_date_format', 'custom_post_date_column_time');
function custom_post_date_column_time($h_time, $post)
{
    return date($post->post_date_gmt);
}
/**
 * Custom function to format a datetime string based on WordPress date and time settings.
 *
 * @param string $datetime The datetime string to be formatted.
 * @return string Formatted date and time based on WordPress date and time settings.
 */
function sbr_datetime($datetime)
{
    //date_default_timezone_set('America/Chicago');
    //return date_i18n(get_option('date_format'), strtotime($datetime . '-6 hours')) . ' ' . date_i18n(get_option('time_format'), strtotime($datetime . '-6 hours'));
    return date(get_option('date_format'), strtotime($datetime)) . ' ' . date(get_option('time_format'), strtotime($datetime));
    // return date('m-d-Y h:ia', strtotime($datetime), true);
}

add_action('wp_ajax_saveBillingShippingOrderSBRListing', 'saveBillingShippingOrderSBRListingcallback');
/**
 * AJAX callback function to save billing and shipping details for a WooCommerce order.
 */
function saveBillingShippingOrderSBRListingcallback()
{
    // Update billing fields.
    $order_id = $_REQUEST['order_id'];
    $order = wc_get_order($order_id);

    $billing_fields = apply_filters(
        'woocommerce_admin_billing_fields',
        array(
            'first_name' => array(
                'label' => __('First name', 'woocommerce'),
                'show' => false,
            ),
            'last_name' => array(
                'label' => __('Last name', 'woocommerce'),
                'show' => false,
            ),
            'company' => array(
                'label' => __('Company', 'woocommerce'),
                'show' => false,
            ),
            'address_1' => array(
                'label' => __('Address line 1', 'woocommerce'),
                'show' => false,
            ),
            'address_2' => array(
                'label' => __('Address line 2', 'woocommerce'),
                'show' => false,
            ),
            'city' => array(
                'label' => __('City', 'woocommerce'),
                'show' => false,
            ),
            'postcode' => array(
                'label' => __('Postcode / ZIP', 'woocommerce'),
                'show' => false,
            ),
            'country' => array(
                'label' => __('Country / Region', 'woocommerce'),
                'show' => false,
                'class' => 'js_field-country select short',
                'type' => 'select',
                'options' => array('' => __('Select a country / region&hellip;', 'woocommerce')) + WC()->countries->get_allowed_countries(),
            ),
            'state' => array(
                'label' => __('State / County', 'woocommerce'),
                'class' => 'js_field-state select short',
                'show' => false,
            ),
            'email' => array(
                'label' => __('Email address', 'woocommerce'),
            ),
            'phone' => array(
                'label' => __('Phone', 'woocommerce'),
            ),
        )
    );

    $shipping_fields = apply_filters(
        'woocommerce_admin_shipping_fields',
        array(
            'first_name' => array(
                'label' => __('First name', 'woocommerce'),
                'show' => false,
            ),
            'last_name' => array(
                'label' => __('Last name', 'woocommerce'),
                'show' => false,
            ),
            'company' => array(
                'label' => __('Company', 'woocommerce'),
                'show' => false,
            ),
            'address_1' => array(
                'label' => __('Address line 1', 'woocommerce'),
                'show' => false,
            ),
            'address_2' => array(
                'label' => __('Address line 2', 'woocommerce'),
                'show' => false,
            ),
            'city' => array(
                'label' => __('City', 'woocommerce'),
                'show' => false,
            ),
            'postcode' => array(
                'label' => __('Postcode / ZIP', 'woocommerce'),
                'show' => false,
            ),
            'country' => array(
                'label' => __('Country / Region', 'woocommerce'),
                'show' => false,
                'type' => 'select',
                'class' => 'js_field-country select short',
                'options' => array('' => __('Select a country / region&hellip;', 'woocommerce')) + WC()->countries->get_shipping_countries(),
            ),
            'state' => array(
                'label' => __('State / County', 'woocommerce'),
                'class' => 'js_field-state select short',
                'show' => false,
            ),
        )
    );
    $props = array();
    if (!empty($billing_fields)) {
        foreach ($billing_fields as $key => $field) {
            if (!isset($field['id'])) {
                $field['id'] = '_billing_' . $key;
            }

            if (!isset($_POST[$field['id']])) {
                continue;
            }

            if (is_callable(array($order, 'set_billing_' . $key))) {
                $props['billing_' . $key] = wc_clean(wp_unslash($_POST[$field['id']]));
            } else {
                $order->update_meta_data($field['id'], wc_clean(wp_unslash($_POST[$field['id']])));
            }
        }
    }

    // Update shipping fields.
    if (!empty($shipping_fields)) {
        foreach ($shipping_fields as $key => $field) {
            if (!isset($field['id'])) {
                $field['id'] = '_shipping_' . $key;
            }

            if (!isset($_POST[$field['id']])) {
                continue;
            }

            if (is_callable(array($order, 'set_shipping_' . $key))) {
                $props['shipping_' . $key] = wc_clean(wp_unslash($_POST[$field['id']]));
            } else {
                $order->update_meta_data($field['id'], wc_clean(wp_unslash($_POST[$field['id']])));
            }
        }
    }

    // echo 'Data: <pre>' .print_r($props,true). '</pre>';
    $order->set_props($props);
    $order->save();
    echo 'Updated';
    die;
}

add_action('wp_ajax_loadOrderBillingShipping', 'loadOrderBillingShipping_callback');
/**
 * AJAX callback function to load order billing and shipping information in the WordPress admin.
 */
function loadOrderBillingShipping_callback()
{

    $order_id = $_REQUEST['order_id'];
    $orderMetaBox = new WC_Meta_Box_Order_Data();
    echo '<form id="billingShippingOrderInfo">';
    $orderMetaBox->output(get_post($order_id));
    echo '<input  type="hidden" name="action"  value="saveBillingShippingOrderSBRListing" />';
    echo '<input  type="hidden" name="order_id"  value="' . $order_id . '" />';
    echo '<a href="javascript:;" order_id="' . $order_id . '" class="button sbr-button" id="saveBillingShippingInfo" >Update Information</a>';
    echo '</form>';
?>
    <style>
        #order_data .order_data_column:first-child,
        #order_data .sbr-order-action-btns,
        #order_data .order_data_column .address,
        #order_data .order_data_column h3 .edit_address {
            display: none;
        }

        #order_data .order_data_column .form-field.form-field-wide,
        #order_data .order_data_column .form-field._transaction_id_field,
        #order_data .woocommerce-order-data__meta.order_number {
            display: none;
        }

        #order_data .order_data_column {
            width: 50%;
        }
    </style>
    <script>
        jQuery(document).ready(function() {
            jQuery('body').find('.edit_address').trigger('click');

        });
    </script>
    <?php
    //  echo 'Data: <pre>' .print_r($response,true). '</pre>';
    exit();
}

add_action('wp_ajax_sbr_setAsCompleted', 'sbr_setAsCompleted_callback');
/**
 * AJAX callback function to set an order as completed in the WordPress admin.
 */
function sbr_setAsCompleted_callback()
{

    $order_id = $_REQUEST['order_id'];
    $order = wc_get_order($order_id);
    $order->update_status('completed');

    echo json_encode(array('status' => 'success', 'msg' => 'Order set as completed'));
    exit();
}

add_action('wp_ajax_reloadOrderRow', 'reloadOrderRow_callback');
/**
 * AJAX callback function to reload an order row in the WordPress admin.
 */
function reloadOrderRow_callback()
{

    // Check if the 'Orders_List_Table' class is already loaded, and if not, require it.
    if (!class_exists('Orders_List_Table')) {
        require_once(get_stylesheet_directory() . '/inc/orders-list-table.php');
    }
    $orders_obj = new Orders_List_Table();
    ob_start();
    $row = get_post($_REQUEST['order_id'], 'ARRAY_A');
    $data = $orders_obj->single_row_columns($row);
    echo $data;
    die;
}

add_action('wp_ajax_mbt_shipment_item_data', 'mbt_shipment_item_data_callback');
/**
 * AJAX callback function to handle shipment item data for create shipment popup.
 *
 * @param int $order_id The order ID.
 */
function mbt_shipment_item_data_callback($order_id = '')
{

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'mbt_shipment_item_data') {
        $order_id = $_REQUEST['order_id'];
    }

    $order = wc_get_order($order_id);
    global $MbtPackaging, $wpdb;
    $oneWayOrderItems = array();
    $threeWayOrderItems = array();
    foreach ($order->get_items() as $item_id => $item) {

        $shipType = '';
        $product = $item->get_product();
        $pro_price = $product->get_price();
        $item_quantity = $item->get_quantity(); // Get the item quantity
        $product_id = $item->get_product_id();
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

        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);

        $class = '';

        if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
            continue;
        }
        if ($three_way_ship_product) {
            $shipType = 'threeway';
        } else {
            $shipType = 'normal';
        }
        //  echo 'Data: <pre>' .print_r($shipType,true). '</pre>';
        $q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
        $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
        $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
        $q1 .= " ORDER BY log_id DESC LIMIT 1";
        $status_query = $wpdb->get_row($q1);
        $item_event_id = $status_query->event_id;
        $item_status = $status_query->status;

        if ($shipType == 'normal') {
            $itemStatus = '<span class="oISALL oIS_' . $item_event_id . '">' . $item_status . '</span>';
            $itemHTML = '';
            $itemHTML .= '<tr>';
            $itemHTML .= '<td>' . $product->get_name() . '</td>';
            $itemHTML .= '<td>' . $itemStatus . '</td>';
            $itemHTML .= '<td>' . $item_quantity . '</td>';
            $itemHTML .= '<td>' . $qtyShipped . '</td>';
            $itemHTML .= '<td>' . $getRemainingQuantity . '</td>';
            $itemHTML .= '<td>';
            $weight = get_post_meta($product_id, '_first_shipment_weight', true);
            if ($weight == 0) {
                $weight = get_post_meta($product_id, '_weight', true);
            }
            // if ($product->get_type() == 'simple') {
            //     $weight = get_post_meta($product_id, '_weight', true);
            // } else {
            //     $weight = get_post_meta($product_id, '_first_shipment_weight', true);
            // }
            if ($weight == '') {
                $weight = 0;
            }
            $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][order_id]"  value="' . $order_id . '" />';
            $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][price]"  value="' . $pro_price . '" />';
            $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][type]"  value="simple" />';
            $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][product_id]"  value="' . $product_id . '" />';
            $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][weight]"  value="' . $weight . '" />';
            if ($getRemainingQuantity) {
                $itemHTML .= '<select name="orderItem[' . $item_id . '][qty]"  onChange="load_packages()" >';
                for ($index = 0; $index <= $getRemainingQuantity; $index++) {
                    if ($index == $getRemainingQuantity) {
                        $itemHTML .= '<option value="' . $index . '" selected="">' . $index . '</option>';
                    } else {
                        $itemHTML .= '<option value="' . $index . '" >' . $index . '</option>';
                    }
                }
                $itemHTML .= '</select>';
            } else {
                $itemHTML .= '0';
                $qty_send = 0;
                $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][qty]"  id=""  item_id="' . $item_id . '"   value="' . $qty_send . '" />';
            }

            $itemHTML .= '</td>';
            $itemHTML .= '</tr>';
            /// echo $itemHTML;
            $oneWayOrderItems[$item_id] = $itemHTML;
        } else if ($shipType == 'threeway') {

            $q_last = "SELECT event_id  FROM  " . SB_LOG;
            $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
            $q_last .= " ORDER BY log_id DESC LIMIT 1";
            $query_last = $wpdb->get_var($q_last);

            //   echo 'Data: <pre>' .print_r($query,true). '</pre>';

            $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
            $first_tracking_number = wc_get_order_item_meta($item_id, '_first_tracking_number', true);
            $second_tracking_number = wc_get_order_item_meta($item_id, '_second_tracking_number', true);
            // $parent_product = $item->get_id();
            $first_shipment_weight = get_post_meta($product_id, '_first_shipment_weight', true);
            $second_shipment_weight = get_post_meta($product_id, '_second_shipment_weight', true);
            $itemHTML = '';

            $itemHTML .= '<tr>';
            $itemHTML .= '<td>' . $product->get_name() . '</td>';
            $itemHTML .= '<td>';

            $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");

            if (empty($query_tray_no) || (strlen(trim($query_tray_no) < 1))) {
                $itemHTML .= smilebrilliant_order_meta_tray_number_display($item_id, $item, $product, 2);
            } else {
                $itemHTML .= '<p class="trays">Tray# ' . $query_tray_no . '</p>';
            }
            $itemStatus = '<span class="oISALL oIS_' . $item_event_id . '">' . $item_status . '</span>';
            $itemHTML .= '</td>';
            $itemHTML .= '<td>' . $itemStatus . '</td>';
            $itemHTML .= '<td>';

            if ($shippedhistory == 1) {
                $itemHTML .= '0.5';
            } else if ($shippedhistory == 2) {
                $itemHTML .= '1';
            } else {
                $itemHTML .= '0';
            }


            $itemHTML .= '</td>';
            $itemHTML .= '<td>';

            if ($shippedhistory == 1) {
                $itemHTML .= '0.5';
            } else if ($shippedhistory == 2) {
                $itemHTML .= '0';
            } else {
                $itemHTML .= '1';
            }

            $itemHTML .= '</td>';
            $itemHTML .= '<td>';

            if ($item_event_id == 1 || $item_event_id == 16) {
                if ($shippedhistory == 1) {
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][order_id]"  value="' . $order_id . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][price]"  value="' . $pro_price . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][type]"  value="composite" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][shipment]"  value="2" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][product_id]"  value="' . $product_id . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][weight]"  value="' . $second_shipment_weight . '" />';
                    $itemHTML .= '<select name="orderItem[' . $item_id . '][qty]"  onChange="load_packages()" >';
                    $itemHTML .= ' <option value="1" selected="">0.5</option>';
                    $itemHTML .= ' <option value="0" >0</option>';
                    $itemHTML .= '</select>';
                } else if ($shippedhistory == 2) {
                    $itemHTML .= '0';
                } else {
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][order_id]"  value="' . $order_id . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][price]"  value="' . $pro_price . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][type]"  value="composite" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][shipment]"  value="1" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][product_id]"  value="' . $product_id . '" />';
                    $itemHTML .= '<input type="hidden" name="orderItem[' . $item_id . '][weight]"  value="' . $first_shipment_weight . '" />';
                    $itemHTML .= '<select name="orderItem[' . $item_id . '][qty]"  onChange="load_packages()" >';
                    $itemHTML .= ' <option value="1" selected="">0.5</option>';
                    $itemHTML .= ' <option value="0" >0</option>';
                    $itemHTML .= '</select>';
                }
            } else {
                if ($shippedhistory == 1) {
                    $itemHTML .= '<select name="orderItemDisabaled[' . $item_id . '][qty]" disabled="" >';
                    $itemHTML .= ' <option value="1" selected="">0.5</option>';
                    $itemHTML .= ' <option value="0" >0</option>';
                    $itemHTML .= '</select>';
                } else if ($shippedhistory == 2) {
                    $itemHTML .= '0';
                } else {
                    $itemHTML .= '<select name="orderItemDisabaled[' . $item_id . '][qty]" disabled="" >';
                    $itemHTML .= ' <option value="1" selected="">0.5</option>';
                    $itemHTML .= ' <option value="0" >0</option>';
                    $itemHTML .= '</select>';
                }
            }

            $itemHTML .= '</td>';
            $itemHTML .= '</tr>';

            $threeWayOrderItems[$item_id] = $itemHTML;
        }
    }

    $flag = true;
    if (isset($_REQUEST['orderItem'])) {
        $readyToShipOrderItem = $_REQUEST['orderItem'];
        $allOrderIds = array();
        if (is_array($readyToShipOrderItem) && count($readyToShipOrderItem) > 0) {
            foreach ($readyToShipOrderItem as $item_id => $productDetail) {
                if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {
                    $product_order_id = $productDetail['order_id'];
                    $allOrderIds[$product_order_id] = $product_order_id;
                }
            }
            $allOrderIds[$order_id] = $order_id;
        }
        /* Valide Zip Codes for order */
        if ($allOrderIds) {
            $order_ids_for_zipcode = array();
            foreach ($allOrderIds as $order_key => $order_sbr_number) {
                $order_ids_for_zipcode[] = $order_key;
            }
            if (count($order_ids_for_zipcode) > 1) {
                if (check_unique_orders_by_zipcode($order_ids_for_zipcode) == false) {
                    $flag = false;
                }
            }
        }
    }
    $orderShippingValidateClass = '';
    if ($flag == false) {
        $orderShippingValidateClass = 'error';
    }

    $shipping_firstname = $order->get_shipping_first_name();
    if (empty($shipping_firstname)) {
        $shipping_firstname = $order->get_billing_first_name();
    }

    $shipping_lastname = $order->get_shipping_last_name();
    if (empty($shipping_lastname)) {
        $shipping_lastname = $order->get_billing_last_name();
    }
    $shipping_email = $order->get_billing_email();
    $shipping_phone = $order->get_billing_phone();
    $shipping_address_1 = $order->get_shipping_address_1();
    if (empty($shipping_address_1)) {
        $shipping_address_1 = $order->get_billing_address_1();
    }
    $shipping_address_2 = $order->get_shipping_address_2();
    if (empty($shipping_address_2)) {
        $shipping_address_2 = $order->get_billing_address_2();
    }

    $shipping_city = $order->get_shipping_city();
    if (empty($shipping_city)) {
        $shipping_city = $order->get_billing_city();
    }

    $shipping_state = $order->get_shipping_state();
    if (empty($shipping_state)) {
        $shipping_state = $order->get_billing_state();
    }

    $shipping_postcode = $order->get_shipping_postcode();
    if (empty($shipping_postcode)) {
        $shipping_postcode = $order->get_billing_postcode();
    }

    $shipping_county = $order->get_shipping_country();
    if (empty($shipping_county)) {
        $shipping_county = $order->get_billing_country();
    }
    $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ', ' . $shipping_address_1 . ' ' . $shipping_address_2 . ', ' . $shipping_city . ', ' . $shipping_state . ', ' . $shipping_postcode . ', ' . WC()->countries->countries[$shipping_county];

    if (count($threeWayOrderItems) > 0 || count($oneWayOrderItems) > 0) {
        echo '<div class="shipment_order_entry">';
        $orderSBRref = get_post_meta($order_id, 'order_number', true);
        $topHeading = '';
        $topHeading = '<h3>';
        $topHeading .= '<span class="order_shipment_number_mbt">' . $orderSBRref . '</span>';
        $topHeading .= '<span class="order_shipment_method">' . $order->get_shipping_method() . '</span>';
        $topHeading .= '<span class="order_entry_shipping_address ' . $orderShippingValidateClass . '">';
        $topHeading .= '<img src="/wp-content/plugins/smile-brilliant/assets/images/setAsShip.svg" class="listingIcons setAsShip">' . $shippingDetails . '</span>';
        $topHeading .= '</h3>';
        echo $topHeading;
        if (count($threeWayOrderItems) > 0) {
    ?>
            <div clas="inner-tablecolum">
                <table class="widefat">
                    <thead>
                        <tr>
                            <th class="sbr-products-table-name">Product Description</th>
                            <th class="sbr-products-table-qty">Tray #</th>
                            <th class="sbr-products-table-status">Current Item Log Status</th>
                            <th class="sbr-products-table-tcode">Qty Shipped to Date</th>
                            <th class="sbr-products-table-coupon">Qty Left to Ship</th>
                            <th class="sbr-products-table-coupon">Qty Now Shipping</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($threeWayOrderItems as $key => $tWI) {
                            echo $tWI;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php
        }
        if (count($oneWayOrderItems) > 0) {
        ?>

            <div clas="inner-tablecolum">
                <table class="widefat">
                    <thead>
                        <tr>
                            <th class="sbr-products-table-name">Product Description</th>
                            <th class="sbr-products-table-status">Current Item Log Status</th>
                            <th class="sbr-products-table-tcode">Qty Ordered</th>
                            <th class="sbr-products-table-tcode">Qty Shipped to Date</th>
                            <th class="sbr-products-table-coupon">Qty Left to Ship</th>
                            <th class="sbr-products-table-coupon">Qty Now Shipping</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($oneWayOrderItems as $key => $oWI) {
                            echo $oWI;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

    <?php
        }
        echo '</div>';
    }
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'mbt_shipment_item_data') {
        die;
    }
}

//add_action('wp_ajax_create_addon_order', 'create_addon_order_callback');
/**
 * AJAX callback to addon order.
 */
function create_addon_order_callback($order_id, $product_id)
{

    $order = wc_get_order($order_id);
    $billing_address = array(
        'first_name' => $order->get_billing_first_name(),
        'last_name' => $order->get_billing_last_name(),
        'company' => $order->get_billing_company(),
        'email' => $order->get_billing_email(),
        'phone' => $order->get_billing_phone(),
        'address_1' => $order->get_billing_address_1(),
        'address_2' => $order->get_billing_address_2(),
        'city' => $order->get_billing_city(),
        'postcode' => $order->get_billing_postcode(),
        'state' => $order->get_billing_state(),
        'country' => $order->get_billing_country()
    );

    $shipping_address = array(
        'first_name' => $order->get_shipping_first_name(),
        'last_name' => $order->get_shipping_last_name(),
        'company' => $order->get_shipping_company(),
        'address_1' => $order->get_shipping_address_1(),
        'address_2' => $order->get_shipping_address_2(),
        'city' => $order->get_shipping_city(),
        'postcode' => $order->get_shipping_postcode(),
        'state' => $order->get_shipping_state(),
        'country' => $order->get_shipping_country()
    );

    $args = array(
        'customer_id' => $order->get_user_id(),
        'parent' => $order->get_id(),
    );

    // Create the order and assign it to the current user
    $new_order = wc_create_order($args);
    $new_order->set_address($billing_address, 'billing');
    $new_order->set_address($shipping_address, 'shipping');
    $products = get_post_meta($product_id, '_bto_data', true);
    if ($products) {
        foreach ($products as $key => $p) {

            $product = wc_get_product($p['default_id']);
            $qty = wc_get_product($p['quantity_min']);
            $new_order->add_product($product, $qty); //(get_product with id and next is for quantity)     
        }
    }
    if ($new_order->has_status('on-hold')) {
    } else {
        $new_order->update_status('on-hold');
    }
    $new_order->save();
    return $new_order->get_id();
}

add_action('wp_ajax_mbt_save_log_note', 'mbt_save_log_note_callback');
/**
 * AJAX callback to packaging order note.
 */
function mbt_save_log_note_callback()
{

    if (isset($_REQUEST['log_id']) && $_REQUEST['log_id'] <> '') {

        if (isset($_REQUEST['packaging_order_note'])) {
            global $wpdb;
            $update = array(
                'note' => $_REQUEST['packaging_order_note'],
            );
            $condition = array(
                "log_id" => $_REQUEST['log_id'],
            );
            $wpdb->update(SB_LOG, $update, $condition);

            echo wp_trim_words($_REQUEST['packaging_order_note'], 3);
        }
    }
    die;
}

add_action('wp_ajax_delete_activity_log', 'delete_activity_log_callback');
/**
 * AJAX callback to delete activity log.
 */
function delete_activity_log_callback()
{
    $log_id = $_REQUEST['log_id'];
    $order_id = $_REQUEST['order_id'];
    $confirm = $_REQUEST['confirm'];

    if($confirm){
        echo copy_and_delete_log($log_id);        
    ?>
    <script>
        reload_order_item_table_mbt(<?php echo $order_id;?>);
    </script>
    <?php
    exit;
    }else{
    ?>
    <script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    Swal.fire({
            title: "Are you sure,<br/><br/> You want to delete this log?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showDenyButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: "Yes. Delete Log!",
            denyButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        order_id: <?php echo $order_id;?>,
                        log_id: <?php echo $log_id;?>,
                        confirm : true,
                        action: "delete_activity_log",
                    },
                    method: "post",
                    success: function (res) {
                        reload_order_item_table_mbt(<?php echo $order_id;?>);
                    },
                });
            }
        });
    </script>
    <?php
    }
    die;
}
function copy_and_delete_log($log_id) {
    global $wpdb;
    $source_table = 'sb_event_log';
    $destination_table = 'sb_event_logs_deleted';

    // Step 1: Retrieve the row from the source table
    $log_entry = $wpdb->get_row( 
        $wpdb->prepare( "SELECT * FROM $source_table WHERE log_id = %d", $log_id ), 
        ARRAY_A 
    );
    if ($log_entry) {
        // Step 2: Insert the retrieved row into the destination table
        $inserted = $wpdb->insert(
            $destination_table,
            $log_entry
        );
        // Check if insertion was successful
        if ($inserted !== false) {
            // Step 3: Delete the row from the source table
            $deleted = $wpdb->delete(
                $source_table,
                array('log_id' => $log_id),
                array('%d')
            );

            // Check if deletion was successful
            if ($deleted !== false) {
                return "Log entry copied and deleted successfully.";
            } else {
                return "Failed to delete the log entry from the source table.";
            }
        } else {
            return "Failed to insert the log entry into the destination table.";
        }
    } else {
        return "Log entry not found in the source table.";
    }
}

add_action('wp_ajax_add_activity_note', 'add_activity_note_callback');
/**
 * AJAX callback to add activity not in order logs.
 */
function add_activity_note_callback()
{
    global $wpdb;
    $q_last = "SELECT  note FROM  " . SB_LOG;
    $q_last .= " WHERE log_id = " . $_REQUEST['log_id'];
    $existing_note = $wpdb->get_var($q_last);
    $order_id = $_REQUEST['order_id'];
    ?>
    <div class="popup-shipment">
        <form id="addNoteForm">
            <div class="shipment-container">
                <div class="shipmemt-header flex-row justify-content-between">
                    <h3>Add Note</h3>
                </div>
            </div>
            <div class="shipiing-setup">
                <textarea name="packaging_order_note" rows="10" cols="100" style="width: 100%;"><?php echo $existing_note; ?></textarea>
            </div>
            <div class="buttons-footer">
                <input type="hidden" name="log_id" id="log_id" value="<?php echo $_REQUEST['log_id']; ?>" />
                <input type="hidden" name="action" value="mbt_save_log_note" />
                <button type="button" id="mbt_save_note">Save</button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        jQuery("body").on('click', '#mbt_save_note', (function(e) {

            jQuery('#addNoteForm').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            e.preventDefault();
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            var elementT = document.getElementById("addNoteForm");

            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                method: 'POST',
                success: function(response) {
                    reload_order_item_table_mbt('<?php echo $order_id; ?>');
                    jQuery('#addNoteForm').unblock();
                    //  $update_log_id = jQuery('body #sb_activity_note_<?php // echo $_REQUEST['log_id'];      
                                                                        ?>').html(response);
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        title: 'Note added succesfully',
                        animation: false,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }));
    </script>
    <?php
    die;
}

add_action('wp_ajax_removeActivity', 'removeActivity_callback');
/**
 * AJAX callback to remove activity.
 */
function removeActivity_callback()
{
    global $wpdb;
    $log_id = $_REQUEST['log_id'];

    global $wpdb;
    $q_last = "SELECT  * FROM  " . SB_LOG;
    $q_last .= " WHERE log_id = " . $log_id;
    $result = $wpdb->get_row($q_last);

    if (!empty($result)) {
        $q1 = "SELECT event_id , log_id FROM  " . SB_LOG;
        $q1 .= " WHERE item_id = " . $result->item_id . " AND product_id = " . $result->product_id . " AND order_id = " . $result->order_id;
        $q1 .= " ORDER BY log_id DESC LIMIT 2";
        $query_q0 = $wpdb->get_results($q1);
        if (!empty($query_q0)) {
            foreach ($query_q0 as $logEntry) {
                if ($logEntry->event_id == 6 || $logEntry->event_id == 7) {
                    $wpdb->delete(SB_LOG, array('log_id' => $logEntry->log_id));
                } else if ($logEntry->event_id == 5) {
                    $wpdb->delete(SB_LOG, array('log_id' => $logEntry->log_id));
                    /*
                      $update = array(
                      'extra_information' => ''
                      );
                      $condition = array(
                      "log_id" => $logEntry->log_id,
                      );
                      $wpdb->update(SB_LOG, $update, $condition);
                     */
                }
            }
            $param = array(
                'order_id' => $result->order_id,
                'item_id' => $result->item_id,
                'product_id' => $result->product_id,
                'event_id' => 3,
            );
            updateOrderItemStatus($param);
        }
        echo 'Revert analyzed impression';
    }
    die;
}


add_action('wp_ajax_markItemStatusAsCompleted', 'markItemStatusAsCompleted_callback');
/**
 * AJAX callback to mark the item status as completed.
 */
function markItemStatusAsCompleted_callback()
{
    global $wpdb;
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $log_id = $_REQUEST['log_id'];
    $update = array(
        'note' => 'Order Status set as comleted by => ' . get_current_user_id(),
        'log_update' => 1,
        'product_id' => $product_id . '0',
    );
    $condition = array(
        "log_id" => $log_id,
    );
    $wpdb->update(SB_LOG, $update, $condition);

    $update = array(
        'status' => 2,
    );
    $condition = array(
        "order_id" => $order_id,
        "item_id" => $item_id,
        "product_id" => $product_id,
    );
    $wpdb->update(SB_ORDER_TABLE, $update, $condition);
    echo 'Updated';
    die;
}

add_action('wp_ajax_create_acknowledged', 'create_acknowledged_callback');
/**
 * AJAX callback to handle actions related to logging events, updating orders, and triggering emails.
 */
function create_acknowledged_callback()
{
    global $wpdb;
    $child_order_id = 0;
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $event_action = $_REQUEST['event_action'];
    $log_id = $_REQUEST['log_id'];

    $event_id = 5;
    //Create Log
    $event_data = array(
        "order_id" => $order_id,
        "item_id" => $item_id,
        "product_id" => $product_id,
        "event_id" => $event_id,
    );
    sb_create_log($event_data);
    $update = array(
        'note' => 'Impression Received',
        'log_update' => 1
    );
    $condition = array(
        "log_id" => $log_id,
    );
    $wpdb->update(SB_LOG, $update, $condition);
    echo 'Impression Received';
    $terms = wp_get_post_terms($product_id, 'product_cat');
    $categories = array();
    foreach ($terms as $term) {
        $categories[] = $term->slug;
    }
    $titleCat = 'whitening trays';
    if (in_array('night-guards', $categories)) {
        $titleCat = 'night guard';
    }
    $_POST['dental_product'] = $titleCat;
    if (isset($_REQUEST['email_notification']) && $_REQUEST['email_notification'] == 0) {
        //No Email Fire .
    } else {
        WC()->mailer()->emails['WC_Dental_Impressions_Received_Email']->trigger($order_id);
        $tray_number = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
        $param = array(
            'order_id' => $order_id,
            'tray_number' => $tray_number,
            'status' => 'impression_received',
        );
        twillioSMS_withOrder($param);
    }
    die;
}
/**
 * AJAX callback to handle various actions related to logging events, updating orders, and triggering emails.
 */

function create_acknowledged_callback_bk()
{
    global $wpdb;
    $child_order_id = 0;
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $event_action = $_REQUEST['event_action'];
    $log_id = $_REQUEST['log_id'];
    if (isset($_REQUEST['source'])) {
        $event_id = 5;
        //Create Log
        $event_data = array(
            "order_id" => $order_id,
            "item_id" => $item_id,
            "product_id" => $product_id,
            "event_id" => $event_id,
        );
        //        echo '<pre>';
        //        print_r($event_data);
        //        die;
        sb_create_log($event_data);
        $update = array(
            'note' => 'Impression Received',
            'log_update' => 1
        );
        $condition = array(
            "log_id" => $log_id,
        );
        $wpdb->update(SB_LOG, $update, $condition);
        echo 'Impression Received';
        $terms = wp_get_post_terms($product_id, 'product_cat');
        $categories = array();
        foreach ($terms as $term) {
            $categories[] = $term->slug;
        }
        $titleCat = 'whitening trays';
        if (in_array('night-guards', $categories)) {
            $titleCat = 'night guard';
        }
        $_POST['dental_product'] = $titleCat;
        WC()->mailer()->emails['WC_Dental_Impressions_Received_Email']->trigger($order_id);
        die;
    }

    global $wpdb;
    $q_last = "SELECT  extra_information FROM  " . SB_LOG;
    $q_last .= " WHERE log_id = " . $log_id;
    $q_last .= " ORDER BY log_id DESC LIMIT 1";
    $query_last = $wpdb->get_var($q_last);
    if ($event_action == 'recipt') {
        $event_id = 5;
        $terms = wp_get_post_terms($product_id, 'product_cat');
        $categories = array();
        foreach ($terms as $term) {
            $categories[] = $term->slug;
        }
        $titleCat = 'whitening trays';
        if (in_array('night-guards', $categories)) {
            $titleCat = 'night guard';
        }
        $_POST['dental_product'] = $titleCat;
        WC()->mailer()->emails['WC_Dental_Impressions_Received_Email']->trigger($order_id);
    } else if ($event_action == 'accept') {
        $event_id = 6;
    } else if ($event_action == 'reject') {
        $event_id = 7;
    } else if ($event_action == 'create') {
        $child_order_id = create_addon_order_callback($order_id, $product_id);
        $event_id = 8;
    }

    //Create Log
    $event_data = array(
        "order_id" => $order_id,
        "child_order_id" => $child_order_id,
        "item_id" => $item_id,
        "product_id" => $product_id,
        "event_id" => $event_id,
        "extra_information" => $query_last,
    );
    sb_create_log($event_data);
    $update = array(
        'child_order_id' => $child_order_id,
        'note' => 'Impression Received',
        'log_update' => 1
    );
    $condition = array(
        "log_id" => $log_id,
    );
    $wpdb->update(SB_LOG, $update, $condition);
    if ($event_action == 'create') {
        $event_id = 1;
        //Create Log
        $event_data = array(
            "order_id" => $order_id,
            "child_order_id" => $child_order_id,
            "item_id" => $item_id,
            "product_id" => $product_id,
            "event_id" => $event_id,
        );
        sb_create_log($event_data);
        update_post_meta($child_order_id, 'created_good_to_ship', 'yes');
    }

    $html_response = array();
    $q1 = "SELECT * FROM  " . SB_LOG . " as l";
    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
    $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
    //$q1 .= " ORDER BY log_id DESC LIMIT 1";
    $query_q0 = $wpdb->get_results($q1);

    if (count($query_q0) > 0) {
        $html_response[] = array(
            'item_id' => $item_id,
            'html' => sb_orderItemHtml($query_q0, $item_id, $product_id, $order_id),
            'child_id' => $child_order_id
        );
    }
    echo json_encode($html_response);
    die;
}

/**
 * AJAX callback to sort item logs.
 *
 * @return void
 */
add_action('wp_ajax_item_log_sorting', 'item_log_sorting_callback');

/**
 * Callback function to sort item logs.
 *
 * @return void
 */

function item_log_sorting_callback()
{
    global $wpdb;

    $html_response = array();
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $event_action = $_REQUEST['event_action'];

    $q1 = "SELECT * FROM  " . SB_LOG . " as l";
    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
    $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
    if ($event_action == 'up') {
        $q1 .= " ORDER BY log_id ASC";
    } else {
        $q1 .= " ORDER BY log_id DESC";
    }

    $query_q0 = $wpdb->get_results($q1);

    if (count($query_q0) > 0) {
        $html_response[] = array(
            'item_id' => $item_id,
            'html' => sb_orderItemHtml($query_q0, $item_id, $product_id, $order_id),
        );
    }
    echo json_encode($html_response);
    die;
}
/**
 * AJAX callback to load item data.
 *
 * @return void
 */
add_action('wp_ajax_load_item_data', 'load_item_data_callback');
/**
 * Callback function to load item data.
 *
 * @return void
 */
function load_item_data_callback()
{
    global $wpdb;

    $html_response = array();
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];

    $q1 = "SELECT * FROM  " . SB_LOG . " as l";
    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
    $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
    $query_q0 = $wpdb->get_results($q1);

    if (count($query_q0) > 0) {
        $html_response[] = array(
            'item_id' => $item_id,
            'html' => sb_orderItemHtml($query_q0, $item_id, $product_id, $order_id),
        );
    }
    echo json_encode($html_response);
    die;
}

/**
 * AJAX callback to reject item warranty.
 *
 * @return void
 */
if (!function_exists('reject_item_warranty_callback')) {
    add_action('wp_ajax_reject_item_warranty', 'reject_item_warranty_callback');
    /**
     * Callback function to reject item warranty.
     *
     * @return void
     */
    function reject_item_warranty_callback()
    {
        global $wpdb;
        $html_response = array();

        if (isset($_REQUEST['log_id']) && $_REQUEST['log_id'] > 0) {
            $log_id = $_REQUEST['log_id'];
            $q1 = "SELECT * FROM  " . SB_LOG;
            $q1 .= " WHERE log_id = " . $log_id;
            $query_q0 = $wpdb->get_row($q1);

            if (count($query_q0) > 0) {
                $item_id = $query_q0->item_id;
                $order_id = $query_q0->order_id;
                $product_id = $query_q0->product_id;
                $event_data = array(
                    "order_id" => $order_id,
                    "warranty_claim_id" => $query_q0->warranty_claim_id,
                    "item_id" => $item_id,
                    "product_id" => $product_id,
                    "event_id" => 15,
                );
                sb_create_log($event_data);
                $update = array(
                    'log_update' => 1
                );
                $condition = array(
                    'log_id' => $_REQUEST['log_id']
                );
                $wpdb->update(SB_LOG, $update, $condition);
                $q1 = "SELECT * FROM  " . SB_LOG . " as l";
                $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                $query_q1 = $wpdb->get_results($q1);

                $html_response[] = array(
                    'item_id' => $item_id,
                    'html' => sb_orderItemHtml($query_q1, $item_id, $product_id, $order_id),
                );
            }
            echo json_encode($html_response);
        }

        die;
    }
}
/**
 * AJAX callback to create customer warranty.
 *
 * @return void
 */
if (!function_exists('create_customer_warranty_callback')) {
    add_action('wp_ajax_create_customer_warranty', 'create_customer_warranty_callback');
    /**
     * Callback function to create customer warranty.
     *
     * @return void
     */
    function create_customer_warranty_callback()
    {
        global $wpdb;
        $html_response = array();

        if (isset($_REQUEST['log_id']) && $_REQUEST['log_id'] > 0) {
            $log_id = $_REQUEST['log_id'];
            $q1 = "SELECT * FROM  " . SB_LOG;
            $q1 .= " WHERE log_id = " . $log_id;
            $query_q0 = $wpdb->get_row($q1);

            if (count($query_q0) > 0) {
                $item_id = $query_q0->item_id;
                $order_id = $query_q0->order_id;
                $product_id = $query_q0->product_id;
                $event_data = array(
                    "order_id" => $order_id,
                    "warranty_claim_id" => $query_q0->warranty_claim_id,
                    "item_id" => $item_id,
                    "product_id" => $product_id,
                    "event_id" => 11,
                );
                sb_create_log($event_data);
                if (get_post_meta($query_q0->warranty_claim_id, '_request_type', true) == 'refund') {
                    $event_data = array(
                        "order_id" => $order_id,
                        "warranty_claim_id" => $query_q0->warranty_claim_id,
                        "item_id" => $item_id,
                        "product_id" => $product_id,
                        "event_id" => 13,
                    );
                    sb_create_log($event_data);
                }
                $update = array(
                    'log_update' => 1
                );
                $condition = array(
                    'log_id' => $_REQUEST['log_id']
                );
                $wpdb->update(SB_LOG, $update, $condition);

                $q1 = "SELECT * FROM  " . SB_LOG . " as l";
                $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                $query_q1 = $wpdb->get_results($q1);

                $html_response[] = array(
                    'item_id' => $item_id,
                    'html' => sb_orderItemHtml($query_q1, $item_id, $product_id, $order_id),
                );
            }
            echo json_encode($html_response);
        }

        die;
    }
}



/**
 * AJAX callback to handle order ID RMA.
 *
 * @return void
 */
add_action('wp_ajax_orderIdRMA', 'orderIdRMA_callback');

/**
 * Callback function to handle order ID RMA.
 *
 * @return void
 */

function orderIdRMA_callback()
{
    global $wpdb;
    if (isset($_REQUEST['order_id'])) {
        $tracking_number = $_REQUEST['tracking_number'];
        $order_id = $_REQUEST['order_id'];
        $product_id = $_REQUEST['product_id'];
        $item_id = $_REQUEST['item_number'];
        $order_id_rma = $_REQUEST['order_id_rma'];
        $log_id = isset($_REQUEST['log_id']) ? $_REQUEST['log_id'] : 0;

        $event_id = 12;
        $event_data = array(
            "order_id" => $order_id,
            "child_order_id" => $order_id_rma,
            "item_id" => $item_id,
            "product_id" => $product_id,
            "event_id" => $event_id,
        );
        sb_create_log($event_data);
        $html_response = array();

        $q1 = "SELECT * FROM  " . SB_LOG . " as l";
        $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
        $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
        $query_q0 = $wpdb->get_results($q1);

        if (count($query_q0) > 0) {
            $html_response[] = array(
                'item_id' => $item_id,
                'html' => sb_orderItemHtml($query_q0, $item_id, $product_id, $order_id),
            );
        }
        echo json_encode($html_response);
    }
    die;
}
/**
 * Update tracking logs for a shipment.
 *
 * @param array $param {
 *     Parameters for updating tracking logs.
 *
 *     @type int    $order_id        The ID of the order.
 *     @type int    $shipment_db_id  The ID of the shipment in the database.
 *     @type int    $item_id         The ID of the order item.
 *     @type int    $product_id      The ID of the product.
 *     @type string $importCode      The import code.
 *     @type string $tracking_number The tracking number.
 * }
 * 
 * @return void
 */
function updateTrackingLogs($param)
{
    //    echo '<pre>';
    //    print_r($param);
    //    echo '</pre>';
    //    die;
    $order_id = $param['order_id'];
    $shipment_db_id = $param['shipment_db_id'];
    $item_id = $param['item_id'];
    $product_id = $param['product_id'];
    $importCode = $param['importCode'];
    $tracking_number = $param['tracking_number'];
    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $order_shipment = array(
        'shipment_id' => $shipment_db_id,
        'order_id' => $order_id,
        'order_number' => $orderSBRref,
    );
    sb_easypost_shipment_orders($order_shipment);
    //Create Log
    $event_data = array(
        "order_id" => $order_id,
        "item_id" => $item_id,
        "shipment_id" => $shipment_db_id,
        "product_id" => $product_id,
        "event_id" => 2,
        "extra_information" => $importCode,
    );
    sb_create_log($event_data);
    $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
    if ($three_way_ship_product == 'yes') {
        addShipmentHistory($item_id, 0.5, 'composite', $tracking_number, date("Y-m-d"));
        $event_data = array(
            "order_id" => $order_id,
            "item_id" => $item_id,
            "product_id" => $product_id,
            "event_id" => 3,
        );
        sb_create_log($event_data);
    }
}

/**
 * AJAX callback to update the tracking number for a shipment.
 *
 * @return void
 */
add_action('wp_ajax_update_tracking_number', 'update_tracking_number_callback');

/**
 * Callback function to update the tracking number for a shipment.
 *
 * @return void
 */
function update_tracking_number_callback()
{
    global $wpdb;

    ## Creating a Tracker
    if (isset($_REQUEST['tracking_number']) && @trim($_REQUEST['tracking_number']) <> '') {
        $shipment_db_id = 0;
        $response = array();
        $tracking_number = @trim($_REQUEST['tracking_number']);
        $q_last = "SELECT shipment_id  FROM  " . SB_EASYPOST_TABLE;
        $q_last .= " WHERE trackingCode = '" . $tracking_number . "'";
        $q_last .= " ORDER BY shipment_id DESC LIMIT 1";
        $shipment_db_id = $wpdb->get_var($q_last);
        //        echo '--';
        //        var_dump($shipment_db_id);
        //        die;
        if ($shipment_db_id) {
            $importCode = 10;
        } else {
            $importCode = 11;
        }

        $order_id = $_REQUEST['order_id'];
        $product_id = $_REQUEST['product_id'];
        $item_id = $_REQUEST['item_number'];
        $insertArray = array();
        try {
            if (empty($shipment_db_id)) {

                require_once(ABSPATH . 'vendor/autoload.php');
                $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
                $tracker = $client->tracker->create(array('tracking_code' => $tracking_number));

                $shipment_id = $tracker->shipment_id;
                $shipment = $client->tracker->retrieve($shipment_id);
                $insertArray['userId'] = get_current_user_id();
                // $insertArray['userId'] = get_post_meta($order_id, '_customer_user', true);
                $insertArray['easyPostLabelSaturdayDelivery'] = false;
                $insertArray['shiptoFirstName'] = $shipment->to_address->name;
                $insertArray['shiptoLastName'] = '';
                $insertArray['shiptoAddress'] = $shipment->to_address->street1;
                $insertArray['shiptoCountry'] = $shipment->to_address->country;
                $insertArray['shiptoCity'] = $shipment->to_address->city;
                $insertArray['shiptoState'] = $shipment->to_address->state;
                $insertArray['shiptoPostalCode'] = $shipment->to_address->zip;
                $insertArray['shiptoPhone'] = $shipment->to_address->phone;
                $insertArray['shiptoEmail'] = $shipment->to_address->email;
                $insertArray['shipmentDate'] = date("Y-m-d H:i:s", strtotime($shipment->created_at));
                $insertArray['easyPostLabelDate'] = date("Y-m-d", strtotime(@trim($shipment->options->label_date)));
                $insertArray['trackingCode'] = @$shipmentWithLabel->tracking_code;
                $tracking_number = $insertArray['trackingCode'];
                $insertArray['shipmentCost'] = @number_format($shipmentWithLabel->selected_rate->rate, 2, '.', '');
                $insertArray['easyPostShipmentId'] = $shipment_id;
                $insertArray['easyPostShipmentTrackingUrl'] = @$shipmentWithLabel->tracker->public_url;
                $insertArray['easyPostLabelSize'] = @$shipment->postage_label->label_size;
                $insertArray['easyPostLabelPNG'] = @$shipment->postage_label->label_url;
                $insertArray['easyPostLabelPDF'] = @$shipment->postage_label->label_pdf_url;
                $insertArray['easyPostLabelRateId'] = @$shipmentWithLabel->selected_rate->id;
                $insertArray['easyPostLabelCarrier'] = @$shipmentWithLabel->selected_rate->carrier;
                $insertArray['easyPostLabelService'] = @$shipmentWithLabel->selected_rate->service;
                $insertArray['shipmentStatus'] = @$shipmentWithLabel->tracker->status;
                $insertArray['estDeliveryDate'] = @$shipmentWithLabel->tracker->est_delivery_date;

                $shipment_db_id = sb_easypost_shipment($insertArray);

                $param = array(
                    'order_id' => $order_id,
                    'shipment_db_id' => $shipment_db_id,
                    'item_id' => $item_id,
                    'product_id' => $product_id,
                    'importCode' => $importCode,
                    'tracking_number' => $tracking_number,
                );
                //                echo __LINE__;
                //                echo '<pre>';
                //                print_r($param);
                //                echo '</pre>';
                updateTrackingLogs($param);
                //download teh PNG version of the label
                $randomFileName = $tracking_number . ".png";
                $downloadResult = @file_get_contents(@$shipment->postage_label->label_url);
                $downloadSuccess = false;
                if ($downloadResult) {
                    $logs_dir = get_home_path() . 'downloads/labels/';
                    if (!is_dir($logs_dir)) {
                        mkdir($logs_dir, 0755, true);
                    }
                    //put the contents
                    $filePutResult = @file_put_contents($logs_dir . $randomFileName, $downloadResult);

                    $response = array(
                        'code' => 'success',
                        'msg' => "Log Added",
                    );
                    echo json_encode($response);
                    die;
                } else {
                    $response = array(
                        'code' => 'error',
                        'msg' => "We were unsucessful in generating the return label for print.  Please try again or contact the administrator.",
                    );
                    echo json_encode($response);
                    die;
                }
            }
        } catch (Exception $e) {

            // $insertArray['userId'] = get_post_meta($order_id, '_customer_user', true);

            $order_old_id = get_post_meta($order_id, 'old_order_id', true);
            if ($order_old_id != '') {
                $sql = "SELECT DISTINCT ordr.*,cop.couponCode,ordercop.couponDiscountTotal,itm.productQuantity, itm.productPrice FROM order_  AS ordr
	   LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
       LEFT JOIN order_coupon AS ordercop ON ordercop.orderId=ordr.orderId
	   LEFT JOIN coupon_ AS cop ON cop.couponId=ordercop.couponId 
	   WHERE ordr.orderId IN(" . $order_old_id . ") GROUP BY ordr.orderId ORDER BY couponDiscountTotal DESC";
                $result3 = $wpdb->get_results($sql, 'ARRAY_A');
                $oldJSON = json_encode($result3[0]);
            } else {
                $oldJSON = get_post_meta($order_id, '_oldJson', true);
            }
            //$oldJSON = get_post_meta($order_id, '_oldJson', true);
            if ($oldJSON) {
                $dataOldJSON = json_decode($oldJSON, true);
                $insertArray['easyPostLabelSaturdayDelivery'] = false;
                $insertArray['shiptoFirstName'] = $dataOldJSON['shippingFirstName'];
                $insertArray['shiptoLastName'] = $dataOldJSON['shippingLastName'];
                $insertArray['shiptoAddress'] = $dataOldJSON['shippingAddress'];
                $insertArray['shiptoCountry'] = $dataOldJSON['shippingCountry'];
                $insertArray['shiptoCity'] = $dataOldJSON['shippingCity'];
                $insertArray['shiptoState'] = $dataOldJSON['shippingState'];
                $insertArray['shiptoPostalCode'] = $dataOldJSON['shippingPostalCode'];
                $insertArray['shiptoPhone'] = $dataOldJSON['phoneNumber'];
                $insertArray['shiptoEmail'] = $dataOldJSON['emailAddress'];
                $insertArray['shipmentDate'] = date("Y-m-d H:i:s", strtotime($dataOldJSON['shipDate']));
                $insertArray['easyPostLabelDate'] = date("Y-m-d", strtotime(@trim($dataOldJSON['shipDate'])));
                $insertArray['trackingCode'] = $tracking_number;
                $insertArray['shipmentCost'] = @number_format($dataOldJSON['shipmentCost'], 2, '.', '');
                $insertArray['userId'] = get_current_user_id();
                //$insertArray['easyPostLabelRateId'] = @$shipmentWithLabel->selected_rate->id;
                $insertArray['easyPostLabelCarrier'] = $dataOldJSON['shipmentMethod'];
                $insertArray['easyPostLabelService'] = $dataOldJSON['orderShippingRateDescription'];
                $insertArray['shipmentStatus'] = 'delivered';
                $insertArray['estDeliveryDate'] = date("Y-m-d H:i:s", strtotime($dataOldJSON['shipDate']));
                $insertArray['actualDeliveryDate'] = date("Y-m-d H:i:s", strtotime($dataOldJSON['shipDate']));
                $shipment_db_id = sb_easypost_shipment($insertArray);
                $importCode = 10;
            }

            $param = array(
                'order_id' => $order_id,
                'shipment_db_id' => $shipment_db_id,
                'item_id' => $item_id,
                'product_id' => $product_id,
                'importCode' => $importCode,
                'tracking_number' => $tracking_number,
            );
            //            echo __LINE__;
            //            echo '<pre>';
            //            print_r($param);
            //            echo '</pre>';
            updateTrackingLogs($param);
            $response = array(
                'code' => 'success',
                'msg' => preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
            );
            echo json_encode($response);
            die;
        }
        if ($shipment_db_id) {
            $param = array(
                'order_id' => $order_id,
                'shipment_db_id' => $shipment_db_id,
                'item_id' => $item_id,
                'product_id' => $product_id,
                'importCode' => $importCode,
                'tracking_number' => $tracking_number,
            );
            //            echo __LINE__;
            //            echo '<pre>';
            //            print_r($param);
            //            echo '</pre>';
            updateTrackingLogs($param);
            $response = array(
                'code' => 'success',
                'msg' => "Log Added",
            );
            echo json_encode($response);
            die;
        } else {
            echo __LINE__;

            $response = array(
                'code' => 'error',
                'msg' => 'We were unsucessful in generating the return label for print.  Please try again or contact the administrator.',
            );
            echo json_encode($response);
            die;
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => "We were unsucessful in generating the return label for print.  Please try again or contact the administrator.",
        );
        echo json_encode($response);
        die;
    }
    die;
}

/**
 * AJAX callback to update the tray number for an order.
 *
 * @return void
 */
add_action('wp_ajax_update_tray_number', 'update_tray_number_callback');

/**
 * Callback function to update the tray number for an order.
 *
 * @return void
 */

function update_tray_number_callback()
{
    global $wpdb;
    if (isset($_REQUEST['smilebrilliant_order_information_key'])) {
        if (isset($_REQUEST['tray_number']) && trim($_REQUEST['tray_number'])) {
            $order_key = $_REQUEST['smilebrilliant_order_information_key'];
            $tray_number = $_REQUEST['tray_number'];

            $get_entry = $wpdb->get_row("SELECT id, tray_number FROM  " . SB_ORDER_TABLE . " WHERE id = $order_key");
            $get_tray_record = $wpdb->get_var("SELECT id FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $tray_number");
            /* New Tray Case */
            $responseCase = 0;
            if (empty($get_tray_record)) {
                $update = array(
                    'tray_number' => $_REQUEST['tray_number']
                );
                $condition = array(
                    'id' => $order_key,
                );

                $response = $wpdb->update(SB_ORDER_TABLE, $update, $condition);
                $responseCase = 1;
            } else {
                $responseCase = 2;
            }

            if ($responseCase == 1) {
                $html_response = array(
                    'flag' => true,
                    'msg' => '<span style="color:green">Save successfully.</span>',
                );
            } else if ($responseCase == 2) {
                $html_response = array(
                    'flag' => false,
                    'msg' => '<span style="color:red">Already in used. please try new tray ID</span>',
                );
            } else {
                $html_response = array(
                    'flag' => false,
                    'msg' => '<span style="color:red">Something went wrong</span>',
                );
            }
            echo json_encode($html_response);
        }
    }
    die;
}
/**
 * Update the "Good to Ship" status for an order.
 *
 * @param int    $order_id     The ID of the order.
 * @param string $changeStatus Whether to change the order status. Default is 'yes'.
 *                             Possible values: 'yes', 'no', 'split'.
 *
 * @return void
 */
function mbt_goodToShip($order_id, $changeStatus = 'yes')
{
    global $wpdb;
    if ($order_id) {
        $order = wc_get_order($order_id);
        $order_type = get_post_meta($order_id, 'order_type', true);

        foreach ($order->get_items() as $item_id => $item) {

            $log_visible = false;
            // if (wc_cp_get_composited_order_item_container($item, $order)) {
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {

                if ($order_type == 'Split') {
                    $composited_item_ids = wc_cp_get_composited_order_items($composite_container_item, $order, true);
                    foreach ($composited_item_ids as $key => $composited_item_id) {
                        $composited_item_quantity = wc_get_order_item_meta($composited_item_id, '_qty', true);
                        wc_update_order_item_meta($composited_item_id, '_reduced_stock', $composited_item_quantity);
                        wc_update_order_item_meta($composited_item_id, '_item_type', 'split');
                    }
                }
                /* Composite Prdoucts Child Items */
            } else if (wc_cp_is_composite_container_order_item($item)) {

                // die;
                /* Composite Prdoucts Parent Item */
                $log_visible = true;
            } else {
                $log_visible = true;
            }

            if ($log_visible) {
                $product_id = $item->get_product_id();
                $product = $item->get_product();
                //if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes') {
                $query = $wpdb->get_var("SELECT * FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                if (empty($query)) {
                    $data = array(
                        "order_id" => $order_id,
                        // "tray_number" => '',
                        // "ticket_id" => $ticket_id,
                        "item_id" => $item_id,
                        "product_id" => $product_id,
                        "status" => 1,
                        "user_id" => $order->get_customer_id(),
                        "created_date" => date("Y-m-d h:i:sa"),
                    );
                    $tray_number = wc_get_order_item_meta($item_id, '_tray_number', true);
                    if ($tray_number) {
                        $data['tray_number'] = $tray_number;
                    }

                    $wpdb->insert(SB_ORDER_TABLE, $data);
                }
                //  }
                $q1 = "SELECT COUNT(*) FROM  " . SB_LOG . " as l";
                $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                $query_q0 = $wpdb->get_var($q1);

                if (empty($query_q0)) {
                    //Create Log
                    $event_data = array(
                        "order_id" => $order_id,
                        "child_order_id" => 0,
                        "item_id" => $item_id,
                        "product_id" => $product_id,
                        "event_id" => 1,
                    );

                    sb_create_log($event_data);
                }
            } else {
                wc_delete_order_item_meta($item_id, '_tray_number');
            }
        }
        update_post_meta($order_id, 'created_good_to_ship', 'yes');
        if ($changeStatus == 'yes') {
            $orderStatuses = array('pending', 'on-hold', 'cancelled', 'failed');
            if (in_array($order->get_status(), $orderStatuses)) {
                //     if (!$order->has_status('processing') || ) {
                $order->update_status('processing');
            }
        } else if ($changeStatus == 'split') {
            $order->update_status('partial_ship');
        }
    }
}

/**
 * AJAX callback to update the "Good to Ship" status for an order.
 *
 * @return void
 */
add_action('wp_ajax_update_order_good_to_ship', 'update_order_good_to_ship_callback');

/**
 * Callback function to update the "Good to Ship" status for an order.
 *
 * @return void
 */

function update_order_good_to_ship_callback()
{
    global $wpdb;
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '') {
        echo 'Updating Status...';
        $order_id = $_REQUEST['order_id'];
        mbt_goodToShip($order_id);
        $current_user = wp_get_current_user();
        update_post_meta($order_id, 'updateByGTS', $current_user->ID);
    }
    die;
}
/**
 * AJAX callback to create a shipment using EasyPost API.
 *
 * @return void
 */
add_action('wp_ajax_mbt_create_shipment', 'mbt_create_shipment_callback');

/**
 * Callback function to create a shipment using EasyPost API.
 *
 * @return void
 */

function mbt_create_shipment_callback()
{

    try {

        require_once(ABSPATH . 'vendor/autoload.php');
        $client = new \EasyPost\EasyPostClient("EZTKfa1edfb636794cf0a30a8a5e630f53b7UwjiVnQorjPo0OQmedOFZg");

        $fname = isset($_REQUEST['fname']) ? $_REQUEST['fname'] : '';
        $lname = isset($_REQUEST['lname']) ? $_REQUEST['lname'] : '';
        $address1 = isset($_REQUEST['address1']) ? $_REQUEST['address1'] : '';
        $address2 = isset($_REQUEST['address2']) ? $_REQUEST['address2'] : '';
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : '';
        $state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
        $country = isset($_REQUEST['country']) ? $_REQUEST['country'] : '';
        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';

        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
        $width = isset($_REQUEST['width']) ? $_REQUEST['width'] : '';
        $height = isset($_REQUEST['height']) ? $_REQUEST['height'] : '';
        $weight = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : '';

        $shipping_qty = $_REQUEST['shipping_qty'];
        $order_id = $_REQUEST['order_id'];

        $order = wc_get_order($order_id);

        if (isset($_REQUEST['shipping_date']) && $_REQUEST['shipping_date'] <> '') {
            $date = date("Y-m-d", strtotime($_REQUEST['shipping_date']));
        } else {
            $date = date("Y-m-d");
        }

        $getItemList = array();
        $customs_items = array();

        foreach ($shipping_qty as $item_id => $qty) {
            if ($qty > 0) {
                $validate_qty = false;
                $product_type = $_REQUEST['product_parent_id'][$item_id];
                if ($product_type == 'normal') {
                    $validate_qty = true;
                    $getItemList[$item_id] = $item_id;
                } else if ($product_type != 'yes' && $shipping_qty[$product_type] > 0) {
                    $validate_qty = true;
                    $getItemList[$product_type] = $product_type;
                }
                if ($validate_qty) {

                    addShipmentHistory($item_id, $qty, $date);
                    $item_info = $order->get_item($item_id);
                    $product_id = $item_info->get_product_id();
                    $weight = get_post_meta($product_id, '_weight', true);
                    if (empty($weight)) {
                        $weight = 0.01;
                    }

                    $curItemArray = array(
                        "description" => get_the_title($product_id),
                        "quantity" => $qty,
                        "weight" => $weight,
                        "value" => 0.00,
                        "hs_tariff_number" => '123456',
                        "origin_country" => 'US'
                    );

                    array_push($customs_items, $client->customsItem->create($curItemArray));
                }
                $validate_qty = false;
            }
        }

        if (count($customs_items) > 0) {
            $customs_info = $client->customsInfo->create(array(
                "eel_pfc" => 'NOEEI 30.37(a)',
                "customs_certify" => true,
                "customs_signer" => 'Salman Shah',
                "contents_type" => 'merchandise',
                "contents_explanation" => '',
                "restriction_type" => 'none',
                "non_delivery_option" => 'return',
                "customs_items" => $customs_items
            ));
            $shipment = $client->shipment->create(array(
                "to_address" => array(
                    'name' => $fname . ' ' . $lname,
                    'street1' => $address1,
                    'street2' => $address2,
                    'city' => $city,
                    'state' => $state,
                    'zip' => $zipcode,
                    'country' => $country,
                    'phone' => $phone,
                    'email' => $email
                ),
                "from_address" => array(
                    'name' => 'EasyPost',
                    'street1' => '746 Springhill Farm Drive',
                    'street2' => 'Missouri',
                    'city' => 'Saint Louis',
                    'state' => 'MO',
                    'zip' => '63021-8419',
                    'country' => 'US',
                    'phone' => '3331114444',
                    'email' => 'ejaz@mindblazetech.com'
                ),
                "parcel" => array(
                    "length" => $length,
                    "width" => $width,
                    "height" => $height,
                    "weight" => $weight
                ),
                'customs_info' => $customs_info,
                'service' => 'PriorityMailInternational',
            ));
            $shipment_id = $shipment->id;
            // $shipment->buy(array(
            //     'rate' => $shipment->lowest_rate(),
            //     //  'insurance' => 1.99
            // ));
            $boughtShipment =$client->shipment->buy($shipment->id, $shipment->lowestRate());
            $tracking_number = 0;
            if (isset($shipment->tracking_code)) {
                $tracking_number = $shipment->tracking_code;
            }
            $shipment->label(array("file_format" => "pdf"));
            $get_postage_label = isset($shipment->postage_label) ? $shipment->postage_label : '';
            $get_label_pdf_url = isset($get_postage_label->label_pdf_url) ? $get_postage_label->label_pdf_url : '';
            $shipment_data = array(
                "order_id" => $order_id,
                "shipment_method" => isset($_REQUEST['method']) ? $_REQUEST['method'] : 'USPS',
                "shipment_id_easypost" => $shipment_id,
                "shipment_method_carrier" => isset($_REQUEST['shipment_method_carrier']) ? $_REQUEST['shipment_method_carrier'] : '',
                "shipment_method_service" => isset($_REQUEST['shipment_method_service']) ? $_REQUEST['shipment_method_service'] : '',
                "shipment_cost" => 0,
                "shipment_label" => isset($_REQUEST['shipping_lable']) ? $_REQUEST['shipping_lable'] : '',
                "url" => $get_label_pdf_url,
                "tracking_code" => $tracking_number,
                "shipping_information" => json_encode($_REQUEST),
                "shipping_date" => $date,
            );
            echo 'shipment_id->' . $shipment_db_id = sb_create_shipment($shipment_data);
            global $wpdb;
            if ($shipment_db_id) {

                foreach ($order->get_items() as $item_id => $item) {
                    $product_id = $item->get_product_id();

                    if (in_array($item_id, $getItemList)) {
                        echo 'Item_id->' . $item_id;
                        $event_data = array(
                            "order_id" => $order_id,
                            "item_id" => $item_id,
                            "shipment_id" => $shipment_db_id,
                            "product_id" => $product_id,
                            "event_id" => 2,
                        );
                        sb_create_log($event_data);
                        //Create Log

                        $q_last = "SELECT log_id  FROM  " . SB_LOG;
                        $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND event_id = 5 AND order_id = " . $order_id;
                        $q_last .= " ORDER BY log_id DESC LIMIT 1";
                        $query_last = $wpdb->get_var($q_last);
                        if (empty($query_last)) {

                            $q_last = "SELECT id  FROM  " . SB_ORDER_TABLE;
                            $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                            $q_last .= " ORDER BY id DESC LIMIT 1";
                            $query_last = $wpdb->get_var($q_last);
                            if ($query_last) {
                                $event_data = array(
                                    "order_id" => $order_id,
                                    "item_id" => $item_id,
                                    "product_id" => $product_id,
                                    "event_id" => 3,
                                );
                                sb_create_log($event_data);
                            }
                        }
                    }
                }
            }
        }
    } catch (\Exception $ex) {
        echo $ex->getMessage();
    }

    die;


    echo '<div class="shipment_rates">';
    echo ' <input type="hidden" name="shipment_id" value="' . $shipment_id . '" />';
    echo '<h4>Select Shipping rates</h4>';
    echo '<ul>';
    foreach ($shipment->rates as $key => $rate) {
    ?>
        <li>
            <label for="<?php echo $rate->id; ?>">
                <input type="radio" id="<?php echo $rate->id; ?>" name="shipment_rate" value="<?php echo $rate->id; ?>">
                <?php echo $rate->carrier . '-' . $rate->service . ' - ' . $rate->rate; ?>
            </label>
        </li>
<?php
    }
    echo '<ul>';
    echo '</div>';
    die;
}


/**
 * AJAX callback to change the order status inline on the listing page.
 *
 * @return void
 */
add_action('wp_ajax_change_order_status_inline_listing', 'change_order_status_inline_listing');

/**
 * Callback function to change the order status inline on the listing page.
 *
 * @return void
 */
function change_order_status_inline_listing()
{
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $selected_status = isset($_POST['selected_status']) ? $_POST['selected_status'] : '';
    $res = array();
    if ($order_id == '') {
        $res['messgae'] = 'order id is empty';
        $res['status'] = 'error';
    }
    if ($selected_status == '') {

        $res['messgae'] = 'order status is empty';
        $res['status'] = 'error';
    } else {
        $order = new WC_Order($order_id);
        $order->update_status($selected_status);
        $res['messgae'] = 'status is updated';
        $res['status'] = 'success';
    }
    echo json_encode($res);
    die();
}

/**
 * AJAX callback to change the shipping method inline on the listing page.
 *
 * @return void
 */
add_action('wp_ajax_change_order_shipping_inline_listing', 'change_order_shipping_inline_listing');

/**
 * Callback function to change the shipping method inline on the listing page.
 *
 * @return void
 */

function change_order_shipping_inline_listing()
{
    global $wpdb;
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $order = wc_get_order($order_id);
    $shipping_method = $order->get_shipping_method();
    $selected_shipping = isset($_POST['selected_shipping']) ? $_POST['selected_shipping'] : '';
    $itemid = isset($_POST['itemid']) ? $_POST['itemid'] : '';
    $itemtitle = isset($_POST['itemtitle']) ? $_POST['itemtitle'] : '';
    $res = array();
    if ($order_id == '') {
        $res['messgae'] = 'order id is empty';
        $res['status'] = 'error';
    }
    if ($selected_shipping == '') {
        $res['messgae'] = 'shipping method is empty';
        $res['status'] = 'error';
    } else {
        $wpdb->query($wpdb->prepare("UPDATE wp_woocommerce_order_items SET order_item_name='$itemtitle' WHERE order_item_id=$itemid"));
        $pd = wc_update_order_item_meta($itemid, 'instance_id', $selected_shipping);
        $order->update_meta_data('shipping_method_updated', 'Yes');
        $order->save();
        $order->add_order_note('shipping method changed from ' . $shipping_method . ' to ' . $itemtitle, false);
        $res['messgae'] = 'Shipping Method is updated';
        $res['status'] = 'success';
    }
    echo json_encode($res);
    die();
}

/*
 * Mark 3d model for order item
 */
add_action('wp_ajax_add_model_order_item', 'add_model_order_item');

function add_model_order_item()
{
    global $wpdb;
    $orde_item_id = isset($_POST['orde_item_id']) ? $_POST['orde_item_id'] : '';
    $res = array();
    if ($orde_item_id == '') {

        $res['messgae'] = 'Item id is empty';
        $res['status'] = 'error';
    } else {
        wc_update_order_item_meta($orde_item_id, 'wc_get_order_item_meta', 'yes');
        $res['messgae'] = 'Model is Marked';
        $res['status'] = 'success';
    }
    echo json_encode($res);
    die();
}

/*
 * 3d Model Unmark
 */
add_action('wp_ajax_remove_model_order_item', 'remove_model_order_item');

function remove_model_order_item()
{
    global $wpdb;
    $orde_item_id = isset($_POST['orde_item_id']) ? $_POST['orde_item_id'] : '';
    $res = array();
    if ($orde_item_id == '') {

        $res['messgae'] = 'Item id is empty';
        $res['status'] = 'error';
    } else {
        wc_update_order_item_meta($orde_item_id, 'wc_get_order_item_meta', '');
        $res['messgae'] = 'Model is UnMarked';
        $res['status'] = 'success';
    }
    echo json_encode($res);
    die();
}


/**
 * Action to create and display the "BOGO Item" button after the order item meta.
 *
 * @param int      $item_id Order item ID.
 * @param WC_Order_Item $item    The order item object.
 * @param WC_Product|null $product The product object associated with the order item.
 */
add_action('woocommerce_after_order_itemmeta', 'createSbrOrderBogoItem', 1, 3);

/**
 * Callback function to create and display the "BOGO Item" button.
 *
 * @param int      $item_id Order item ID.
 * @param WC_Order_Item $item    The order item object.
 * @param WC_Product|null $product The product object associated with the order item.
 */

function createSbrOrderBogoItem($item_id, $item, $product = null)
{
    if (get_current_user_id() == 2) {
        if ($product) {
            $order_id = $item->get_order_id();
            $product_id = $item->get_product_id();
            $order_old_id = get_post_meta($order_id, 'old_order_id', true);
            if ($order_old_id != '') {
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product == 'yes') {
                    echo  '<a class="button sbr-button check-mbt" onClick="sbr_markAsBogoItem(' . $item_id . ' , ' . $order_old_id . ' , ' . $order_id . ')"   href="javascript:;" >BOGO Item</a>';
                }
            }
        }
    }
}
/**
 * AJAX callback to mark an order item as BOGO Legacy Item.
 *
 * @return void
 */
add_action('wp_ajax_markAsBogoLegacyItem', 'markAsBogoLegacyItem_callback');

/**
 * Callback function to mark an order item as BOGO Legacy Item.
 *
 * @return void
 */
function markAsBogoLegacyItem_callback()
{


    $order_id = $_REQUEST['order_id'];
    // $order_old_id = $_REQUEST['order_old_id'];
    $item_id = $_REQUEST['item_id'];
    wc_update_order_item_meta($item_id, '_qty', 2);
    if (function_exists('w3tc_pgcache_flush_post')) {
        w3tc_pgcache_flush_post($order_id);
    }
    updateProductQtyForLogs_callback();
    if (function_exists('w3tc_pgcache_flush_post')) {
        w3tc_pgcache_flush_post($order_id);
    }

    clean_post_cache($order_id);
    $order = wc_get_order($order_id);
    wc_delete_shop_order_transients($order);
    wp_cache_delete('order-items-' . $order->get_id(), 'orders');
    mbt_goodToShip($order_id, 'no');
    echo 'Updated';
    die;
}
