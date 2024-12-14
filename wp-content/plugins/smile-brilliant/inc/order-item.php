<?php

/**
 * Adds action hook to display custom header options on the WooCommerce admin order item page.
 */
add_action('woocommerce_admin_order_item_headers', 'smilebrilliant_admin_order_item_header_options');

/**
 * Callback function to display custom header options on the WooCommerce admin order item page.
 */

function smilebrilliant_admin_order_item_header_options() {

    echo '<th class="sb-contact-th"></th>';
}

/**
 * Adds action hook to display custom values on the WooCommerce admin order item page.
 *
 * @param WC_Product|null $product The WooCommerce product object.
 * @param WC_Order_Item $item The WooCommerce order item object.
 * @param int|null $item_id The order item ID.
 */
add_action('woocommerce_admin_order_item_values', 'smilebrilliant_admin_order_item_values', 10, 3);

/**
 * Callback function to display custom values on the WooCommerce admin order item page.
 *
 * @param WC_Product|null $product The WooCommerce product object.
 * @param WC_Order_Item $item The WooCommerce order item object.
 * @param int|null $item_id The order item ID.
 */

function smilebrilliant_admin_order_item_values($product = null, $item, $item_id = null) {
    if ($product) {

        $product_visibility = $product->get_catalog_visibility();
        if ($product_visibility == 'visible') {

            $customer_chat = add_query_arg(
                    array(
                'action' => 'create_customer_popup',
                'order_id' => $item->get_order_id(),
                'product_id' => $item->get_product_id(),
                'item_id' => $item_id,
                    ), admin_url('admin-ajax.php')
            );
            echo '<td class="sb-contact-td">';
            echo getUserChatForLog($customer_chat);
            echo '</td>';
        }
    }
}



/**
 * Adds action hook to display custom content after order item meta on the WooCommerce order page.
 *
 * @param int $item_id The ID of the order item.
 * @param WC_Order_Item_Product $item The WooCommerce order item object.
 * @param WC_Product|null $product The WooCommerce product object.
 * @param int $addOn Additional flag indicating the context (0: Default, 1: Shipment Screen, 2: Return Value).
 */
add_action('woocommerce_after_order_itemmeta', 'smilebrilliant_order_meta_tray_number_display', 10, 3);

/**
 * Callback function to display custom content after order item meta on the WooCommerce order page.
 *
 * @param int $item_id The ID of the order item.
 * @param WC_Order_Item_Product $item The WooCommerce order item object.
 * @param WC_Product|null $product The WooCommerce product object.
 * @param int $addOn Additional flag indicating the context (0: Default, 1: Shipment Screen, 2: Return Value).
 */
function smilebrilliant_order_meta_tray_number_display($item_id, $item, $product = null, $addOn = 0) {

    $html = '';
    if ($product) {
        $model_icon_html = '';
        $order_number = $item->get_order_id();
        $product_id = $item->get_product_id();
        //$order = wc_get_order($order_number);
        //  if (wc_cp_get_composited_order_item_container($item, $order)) {
        /* Composite Prdoucts Child Items */
        //  } else if (wc_cp_is_composite_container_order_item($item)) {
        /* Composite Prdoucts Parent Item */
        global $wpdb;
        $html .= '<div id="item_tray_number_' . $item_id . '" class="item_sb" >';
        if ($addOn == 1) {
            $html .= '<input type="hidden" class="shipmentScreen" value="yes" />';
            $html .= '<input type="hidden" class="item_number" value="' . $item_id . '" />';
            $html .= '<input type="hidden" class="order_number" value="' . $order_number . '" />';
        } else {
            $html .= '<input type="hidden" class="shipmentScreen" value="no" />';
        }
        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
        if ($three_way_ship_product == 'yes') {
            $tray_q = "SELECT * FROM  " . SB_ORDER_TABLE;
            $tray_q .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $tray_query = $wpdb->get_row($tray_q);
            if (@$tray_query) {
                $tray_number = isset($tray_query->tray_number) ? $tray_query->tray_number : '';
                $information_id = isset($tray_query->id) ? $tray_query->id : '';
                $html .= sb_orderItemTrayHtml($item_id, $tray_number, $information_id);
            }
            $model_icon = '<img src="' . plugin_dir_url(__DIR__) . 'assets/images/3d-tooth-icon-grey.svg">';
            $model_icon_html = '<a href="javascript:void(0);" class="add_model button" data-item_id="' . $item_id . '" data-oid="' . $order_number . '"><span class="model-icon">' . $model_icon . '</span> <span class="tooltiptext">Add Digital Model Flag</span></a>';
            if (wc_get_order_item_meta($item_id, 'wc_get_order_item_meta', true) != '') {
                $model_icon = '<img src="' . plugin_dir_url(__DIR__) . 'assets/images/3d-tooth-icon.svg">';
                $model_icon_html = '<a href="javascript:void(0);" class="have_model button" data-item_id="' . $item_id . '" data-oid="' . $order_number . '"><span class="model-icon">' . $model_icon . '</span><span class="tooltiptext">Remove Digital Model Flag</span></a>';
            }
            $html .= '<div class="trayResponseDiv"></div>';
        } else {
            $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_number and item_id = $item_id");
            if ($query_tray_no) {
                $html .= '<div class="trayChild" style="color: #2271b1;">Tray number: ' . $query_tray_no . '</div>';
            }
        }
        $html .= '</div>' . $model_icon_html;
    }
    // }
    if ($addOn == 2) {
        return $html;
    } else {
        echo $html;
    }
}


/**
 * Adds action hook to customize the HTML output for line items in WooCommerce admin order page.
 *
 * @param int $item_id The ID of the order item.
 * @param WC_Order_Item_Product $item The WooCommerce order item object.
 * @param WC_Order $order The WooCommerce order object.
 */
add_action('woocommerce_order_item_line_item_html', 'woocommerce_order_item_line_item_html', 1, 3);

/**
 * Callback function to customize the HTML output for line items in the WooCommerce admin order page.
 *
 * @param int $item_id The ID of the order item.
 * @param WC_Order_Item_Product $item The WooCommerce order item object.
 * @param WC_Order $order The WooCommerce order object.
 */
function woocommerce_order_item_line_item_html($item_id, $item, $order) {

    $html = '';

    $product_id = $item->get_product_id();
    //$order_number = $order->get_order_number();
    $order_number = $order->get_id();
    $itemLineDisplay = false;
    if (wc_cp_get_composited_order_item_container($item, $order)) {
        /* Composite Prdoucts Child Items */
    } else if (wc_cp_is_composite_container_order_item($item)) {
        /* Composite Prdoucts Parent Item */
        $itemLineDisplay = true;
    } else {
        $itemLineDisplay = true;
        /* Normal Product */
    }

    $showAll = true;
    if ($itemLineDisplay) {
        global $wpdb;
        $html .= '<tr id="order_item_data-' . $item_id . '" class="sb_order_item_tr">';
        if ($showAll) {
            $q1 = "SELECT * FROM  " . SB_LOG . " as l";
            $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
            $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $query = $wpdb->get_results($q1);
            if (count($query) > 0) {
                $html .= sb_orderItemHtml($query, $item_id, $product_id, $order_number, 0);
            }
        } else {

            $q1_count = "SELECT  COUNT(log_id) FROM  " . SB_LOG . " as l";
            $q1_count .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $count = $wpdb->get_var($q1_count);

            $q1 = "SELECT * FROM  " . SB_LOG . " as l";
            $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
            $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $q1 .= " ORDER BY log_id DESC LIMIT 1";



            $query = $wpdb->get_results($q1);
            if (count($query) > 0) {

                if ($count > 1) {
                    $html .= sb_orderItemHtml($query, $item_id, $product_id, $order_number, 1);
                } else {
                    $html .= sb_orderItemHtml($query, $item_id, $product_id, $order_number, 0);
                }
            }
        }
        $html .= '</tr>';
    }

    echo $html;
}
/**
 * Filters the list of allowed countries in WooCommerce based on specific conditions.
 *
 * @param array $countries An associative array of country codes and names.
 *
 * @return array The modified array of allowed countries.
 */
function smile_brilliant_filter_woocommerce_countries_allowed_countries($countries) {
    // Cart or checkout page
    if (is_cart() || is_checkout() || is_account_page()) {

        // Country codes you want to show
        $show_countries = array(
            'AU',
            'AT',
            'LU',
            'BE',
            'VG',
            'VI',
            'NZ',
            'NL',
            'NO',
            'CA',
            'PL',
            'CN',
            'PT',
            'CZ',
            'PR',
            'DK',
            'QA',
            'FI',
            'RO',
            'FR',
            'SA',
            'DE',
            'SG',
            'GL',
            'KR',
            'HK',
            //'ES',
            'IS',
            'SE',
            'IE',
            'CH',
            'IL',
            'IT',
            'AE',
            'JP',
            'GB',
            'LT',
            'US'
        );

        // Loop through country codes
        foreach ($countries as $key => $country) {
            // NOT found
            if (!in_array($key, $show_countries)) {
                // Remove
                unset($countries[$key]);
            }
        }
    }

    // Return
    return $countries;
}

add_filter('woocommerce_countries_allowed_countries', 'smile_brilliant_filter_woocommerce_countries_allowed_countries', 10, 1);
