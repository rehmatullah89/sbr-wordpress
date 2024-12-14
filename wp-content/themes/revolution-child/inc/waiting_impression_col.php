<?php

function get_trayID_by_itemID($item_id) {
    global $wpdb;
    $tray_number = $wpdb->get_var("SELECT tray_number  FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id ");
    if ($tray_number == '') {
        return false;
    } else {
        return $tray_number;
    }
}

function get_col_pending_lab_work($item, $column_name, $tray_html_main = '', $item_id, $item_pro, $tray_number = '') {
    global $wpdb;
    if ($tray_number != '' && $tray_number != ' ') {
        $exploded = preg_split('/\r\n|\r|\n/', $tray_number);
        $tray_id = get_trayID_by_itemID($item_id);
        if (is_array($exploded) && count($exploded) > 1) {
            if (!in_array($tray_id, $exploded)) {
                return '';
            }
        } else {
            if ($tray_number != $tray_id) {
                return '';
            }
        }
    }
    $order = wc_get_order($item['ID']);
    $editUrl = get_admin_url() . 'post.php?post=' . $item['ID'] . '&action=edit';

    switch ($column_name) {
        case 'tray_number':
            return $tray_html_main;
        case 'order_type':
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $tags = get_user_meta($customer_id, 'customer_tags', true);
            if (empty($tags)) {
                return '<div class="product_tag_pending">Retail-online</div>';
            } else {
                return '<div class="product_tag_pending">' . $tags . '</div>';
            }

        case 'impression_date':

            $product_id = $item_pro->get_product_id();
            $order_id = $item['ID'];
            $q_last = "SELECT  created_date FROM  " . SB_LOG;
            $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = '$order_id' AND event_id = 5";
            $q_last .= " ORDER BY log_id DESC LIMIT 1";

            $query_last = $wpdb->get_var($q_last);
            if ($query_last) {
                return '<div class="product_impression_date_pending">' . sbr_datetime($query_last) . '</div>';
            } else {
                return '<div class="product_impression_date_pending">N/A</div>';
            }



        case 'product':
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
            $customer_chat = add_query_arg(
                    array(
                'action' => 'create_customer_popup',
                'order_id' => $item['ID'],
                'screen' => 'pending-lab',
                'product_id' => $item_pro->get_product_id(),
                'item_id' => $item_id,
                    ), admin_url('admin-ajax.php')
            );
            $product_html = $item_pro->get_name();
            $product_html .= '<a class="customer_chat button button-small sb_customer_chat ' . $ticket_status_item . '" href="javascript:;"  custom-url="' . $customer_chat . '" >' . iconListingOrder($img) . '<span class="tooltiptext">' . $tool_tip_ticket . '</span></a>';
            return '<div class="product_name_info">' . $product_html . '</div>';

        case 'ordernumber':
            $user_id = $order->get_customer_id();
            if (get_post_meta($item['ID'], 'order_number', true) == '') {
                smile_brillaint_get_sequential_order_number($item['ID']);
            }
            $title = '<div class="order-inner-items"><strong><a target="_blank" href="' . $editUrl . '">' . get_post_meta($item['ID'], 'order_number', true) . '</a></strong>';
            //   $buttons = '<br>' . date('l M d, Y h:ia', strtotime($item['post_date']));
            // $buttons = '<br>' . sbr_datetime($item['post_date']);

            $threeWay = get_post_meta($item['ID'], 'threeWayShipment', true);
            $shipOrder = '';
            $buttons .= '<div class="OrderActionBtn">';
            //$buttons .= '<a class="button sbr-button" target="_blank" href="' . $editUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">Order Detail</span></a>';

            if ($order->get_status() === 'shipped') {

                $buttons .= '<a class="button sbr-button check-mbt" onClick="sbr_setAsCompleteOrder(' . $item['ID'] . ')" id="btn_setAsCompleteOrder_' . $item['ID'] . '" href="javascript:;" ><span class="dashicons dashicons-yes"></span><span class="tooltiptext">Mark as complete</span></a>';
            } else {
                $buttons .= $shipOrder;
            }





            $customer_chat = add_query_arg(
                    array(
                'action' => 'create_customer_popup',
                'order_id' => $item['ID'],
                'screen' => 'pending-lab',
                'product_id' => 0,
                //	'ticket_id' => $ticket_id,
                'item_id' => 0,
                    ), admin_url('admin-ajax.php')
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
            $has_note_class = 'post-it';
            if (get_post_meta($item['ID'], 'has_order_note')) {
                $has_note_class = 'post-it-red';
            }
            $buttons .= '<a type="button" id="addNotes" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="0" title="Admin Note">' . iconListingOrder($has_note_class) . '<span class="tooltiptext">Admin Notes</span></a>';
            // $buttons .= '<a type="button" id="editPersonalizedFollowup" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="1" title="Customer Notes">' . iconListingOrder('checklists') . '<span class="tooltiptext">Customer Notes</span></a>';

            $addOnOrder = add_query_arg(
                    array(
                'customer_id' => $user_id,
                'action' => 'create_addon_order',
                'order_type' => 'Addon',
                'parent_order_id' => $item['ID'],
                    ), admin_url('admin-ajax.php')
            );

            $buttons .= '<a class="addon_order button button-small sb_addon_order" href="javascript:;"  data-order-id="' . $item['ID'] . '"  custom-url="' . $addOnOrder . '">' . iconListingOrder('createAddon') . '<span class="tooltiptext">Create AddOn</span></a>';

//$buttons .= '<a type="button" id="deleteOrder" class="button sbr-button sbr-button-order-delete"  data-order-id="' . $item['ID'] . '" title="Delete Order"><span class="dashicons dashicons-trash"></span><span class="tooltiptext">Delete Order</span></a>';
            $buttons .= '</div>';
            // $buttons .= '<div class="OrderActionTxtBtn">';
            //$buttons .= '</div>';
            // $tags = '<p class="gifts-info no-flex-item">';

            if (get_post_meta($item['ID'], 'gehaOrder', true) == 'yes') {
                $tags .= '<span class="geha-icon flex-item-mbt">
                    <img src="/wp-content/uploads/2021/10/geha-logo-purple-300x75-1.png" alt="" > 
                    <span class="order-text-mbt">Order</span></span>';
            }
            if (get_post_meta($item['ID'], 'purchasing_as_giftset', true) == '1') {
                $tags .= '<span class="listingGiftOrder">Gift Order</span>';
            }
            $device = get_post_meta($item['ID'], 'user_device', true);
            if ($device != '' && strtolower($device) == 'mobile') {
                $tags .= '<span class="listingOrderDevice">Device: Mobile</span>';
            } else {
                $tags .= '<span class="listingOrderDevice">Device: Desktop</span>';
            }
//            $orderType = get_post_meta($item['ID'], 'order_type', true);
//            if ($orderType) {
//                $tags .= '<br/><span class="listingOrderType">Order Type : ' . $orderType . '</span>';
//            }
            $product_id = $item_pro->get_product_id();
            $order_id = $item['ID'];
            $q_last = "SELECT  event_id , log_id FROM  " . SB_LOG;
            $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = '$order_id'";
            $q_last .= " ORDER BY log_id DESC LIMIT 1";
            $log_id = 0;
            $event_id = 0;
            $query_last = $wpdb->get_row($q_last);
            if ($query_last) {
                $log_id = $query_last->log_id;
                $event_id = $query_last->event_id;
            }

//<a class="create_acknowledged accept-case button button-small" action="recipt" href="javascript:;"  log_id="' . $response->log_id . '" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '">Acknowledged Receipt</a></p>';
//Log say data leinaa hai 
            if ($event_id == 6) {
                $buttons .= '<a class="button sbr-button check-mbt kit-readybtn" data-item_id="' . $item_id . '" onClick="sbr_kitReady(' . $item_id . ' , ' . $item_pro->get_product_id() . ' , ' . $item['ID'] . ' , ' . $log_id . ')"  id="btn_kitReady_' . $item_id . '" href="javascript:;" >Kit Ready</a>';
            }

            if ($event_id == 16) {
                $ajax_url = add_query_arg(
                        array(
                    'action' => 'generate_shipment_popup',
                    'order_id' => $order_id,
                        ), admin_url('admin-ajax.php')
                );

                $buttons .= '<p class="create_shipping"><a style="margin-top:0px" item_id="' . $item_id . '" custom-url="' . $ajax_url . '" class="create_sb_shipment button button-small" href="javascript:;" >Create Second Shipment</a></p>';
            }
            
            $easypostShip = add_query_arg(
                    array(
                'action' => 'add_order_shipping_note',
                'order_id' => $item['ID'],
                    ), admin_url('admin-ajax.php')
            );
            $addedNoteClass = 'iconShippingNotes';
            $orderPackagingNote = get_post_meta($item['ID'], '_order_packaging_note', true);
            if ($orderPackagingNote) {
                $orderPackagingNote = html_entity_decode($orderPackagingNote, ENT_QUOTES);
                $addedNoteClass = 'iconShippingNotes-red';
            }

            $buttons .= '<a class="button button-small packagingNoteShip" source="2"  custom-url="' . $easypostShip . '" note="' . $orderPackagingNote . '" href="javascript:;"  data-order-id="' . $item['ID'] . '">' . iconListingOrder($addedNoteClass) . '<span class="tooltiptext">Shipping Notes</span></a>';


            /*
              $addonOrderUrl = add_query_arg(
              array(
              'customer_id' => $user_id,
              'parent_order_id' => $order_id,
              'order_type' => 'Addon',
              ), admin_url('admin.php?page=create-order')
              );
             * 
             */
            //  $buttons .= '<a class="button button-small" target="_blank"  id="addonOrder" href="' . $addonOrderUrl . '">Addon Order</a>';
            // $tags .= '</p>';
            return $title . $buttons . $tags . '</div>';


        //    return date('l M d, Y h:ia', strtotime($item['post_date']));
        case 'orderdate':
            return '<div class="order_date_sbr_inner">' . date('l M d, Y h:ia', strtotime($item['post_date'])) . '</div>';
        case 'emailphone':
            $phone = get_post_meta($item['ID'], '_billing_phone', true);
            $email = get_post_meta($item['ID'], '_billing_email', true);
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $buttons .= '<br><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit</a>';
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
                    $cardImageUrl = site_url('wp-content/plugins/woocommerce-gateway-authorize-net-cim/vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway/assets/images/card-' . $cardType . '.svg');
                    $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                    $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';
                    $totalOrderHtml .= '<span class="cardNumber">****' . get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_account_four', true) . '</span>';
                }

                //  $totalOrderHtml .= '<span class="col_method_title">' . wp_kses_post($order->get_payment_method_title()) . '</span>';


                $totalOrderHtml .= '</div>';
            } elseif (get_post_meta($order->get_id(), '_payment_method', true) == 'affirm') {
                $cardImageUrl = 'https://cdn-assets.affirm.com/images/blue_logo-transparent_bg.png';
                $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                //$totalOrderHtml .= '<span class="col_method_title">Affirm</span>';
                $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';
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
            $billing_arr = get_post_meta($item['ID']);
            $billing_method_html = '';
            //if($billing_arr['_payment_method_title'][0])
            //	$billing_method_html = '<br><br>via '.$billing_arr['_payment_method_title'][0];
            //$billing = $billing_arr['_billing_first_name'][0].' '.$billing_arr['_billing_last_name'][0].', '.$billing_arr['_billing_address_1'][0].', '.$billing_arr['_billing_city'][0].', '.$billing_arr['_billing_state'][0].' '.$billing_arr['_billing_postcode'][0];

            $phone = get_post_meta($item['ID'], '_billing_phone', true);
            $email = get_post_meta($item['ID'], '_billing_email', true);
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $buttons = '<div class="billingActions"><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit</a>';
            //$buttons = '<div class="billingActions"><input type="button" class="button sbr-button editBuyerDetails" value="Edit" data-customer-id="'.$customer_id.'">';
            $buttons .= '<input type="button" class="button sbr-button buyerProfile" value="Buyer Profile" data-customer-id="' . $customer_id . '"></div>';
            //	$buttons .= $billing_method_html;
            $billingHtml = '';
            $billingHtml .= '<div class="billingAddressCol">';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $billing_arr['_billing_first_name'][0] . ' ' . $billing_arr['_billing_last_name'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $billing_arr['_billing_address_1'][0] . ', ' . $billing_arr['_billing_city'][0] . ', ' . $billing_arr['_billing_state'][0] . ' ' . $billing_arr['_billing_postcode'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-email-alt"></span><span class="billingSubInfo">' . $email . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-phone"></span><span class="billingSubInfo">' . $phone . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '</div>';
            return '<div class="billing-container">' . $billingHtml . $buttons . '</div>';

        //return $billing;
        case 'shipping':

            $shipping_method_html = '';
            $shipping_method = $order->get_shipping_method();
            if ($shipping_method != '') {
                $shipping_method_html .= '<div class="shippingMethodCol">';
                if (strpos($shipping_method, 'USPS') >= 0) {
                    $shipping_method_html .= '<span><img src="' . get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg" style="width:60px;"></span>';
                }
                $shipping_method_html .= '<span>via ' . $shipping_method . '</span>';
                $shipping_method_html .= '</div>';
            }

            $shipping_arr = get_post_meta($item['ID']);
            //$shipping = $shipping_arr['_shipping_first_name'][0].' '.$shipping_arr['_shipping_last_name'][0].', '.$shipping_arr['_shipping_address_1'][0].', '.$shipping_arr['_shipping_city'][0].', '.$shipping_arr['_shipping_state'][0].' '.$shipping_arr['_shipping_postcode'][0].$shipping_method_html;

            $billingHtml = '';
            $billingHtml .= '<div class="shippingAddressCol">';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $shipping_arr['_shipping_first_name'][0] . ' ' . $shipping_arr['_shipping_last_name'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $shipping_arr['_shipping_address_1'][0] . ', ' . $shipping_arr['_shipping_city'][0] . ', ' . $shipping_arr['_shipping_state'][0] . ' ' . $shipping_arr['_shipping_postcode'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= $shipping_method_html;
            $billingHtml .= '</div>';
            return '<div class="shipping-container">' . $billingHtml . $buttons . '</div>';
        default:
            return ''; //print_r( $item, true );
    }
}

function get_col_waiting_on_impression($item, $column_name, $tray_html_main = '', $item_id, $item_pro, $tray_number = '') {
    global $wpdb;
    if ($tray_number != '' && $tray_number != ' ') {
        $exploded = preg_split('/\r\n|\r|\n/', $tray_number);
        $tray_id = get_trayID_by_itemID($item_id);
        if (is_array($exploded) && count($exploded) > 1) {
            if (!in_array($tray_id, $exploded)) {
                return '';
            }
        } else {
            if ($tray_number != $tray_id) {
                return '';
            }
        }
    }
    $order = wc_get_order($item['ID']);
    $editUrl = get_admin_url() . 'post.php?post=' . $item['ID'] . '&action=edit';

    switch ($column_name) {
        case 'tray_number':
            return $tray_html_main;
        case 'order_type':
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $tags = get_user_meta($customer_id, 'customer_tags', true);
            if (empty($tags)) {
                return '<div class="product_order_type">Retail-online</div>';
                //  return 'Retail-online';
            } else {
                return '<div class="product_order_type">' . $tags . '</div>';
                //return $tags;
            }

        case 'order_delivery_date':
            $order_delivery_date = getLastestShipmentInfo($item_pro, $item_id);
            if (preg_match("/0{4}/", $order_delivery_date)) {
                return '<div class="product_order_delivery_date">00-00-0000</div>';
            } else {
                return '<div class="product_order_delivery_date">' . date('m-d-Y', strtotime($order_delivery_date)) . '</div>';
            }

        case 'product_qty_shipped':

            $three_way_ship_product = get_post_meta($item_pro->get_product_id(), 'three_way_ship_product', true);
            $qtyShipped = 0;
            if ($three_way_ship_product) {
                //$tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_pro, $item_pro->get_product(), 2);
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
            return '<div class="product_qty_shipped">' . $qtyShipped . '</div>';
        case 'product':
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
            $customer_chat = add_query_arg(
                    array(
                'action' => 'create_customer_popup',
                'screen' => 'waiting-impression',
                'order_id' => $item['ID'],
                'product_id' => $item_pro->get_product_id(),
                'item_id' => $item_id,
                    ), admin_url('admin-ajax.php')
            );
            $product_html = $item_pro->get_name();
            $product_html .= '<a class="customer_chat button button-small sb_customer_chat ' . $ticket_status_item . '" href="javascript:;"  custom-url="' . $customer_chat . '" >' . iconListingOrder($img) . '<span class="tooltiptext">' . $tool_tip_ticket . '</span></a>';
            //#RB           
            $mouth_guard_number = wc_get_order_item_meta($item_id, 'mouth_guard_number', true);
            $mouth_guard_color = wc_get_order_item_meta($item_id, 'mouth_guard_color', true);
            if ($mouth_guard_number) {
                $product_html .= '<div class="custom-guards">Color:<strong class="' . $mouth_guard_color . '" > '.$mouth_guard_color.'</strong></div>';
            }
            if (!empty($mouth_guard_color)) {
            $product_html .= '<div class="custom-guards">Number:<strong> '.$mouth_guard_number.'</strong></div>';
            }
            return '<div class="product_name_info">' . $product_html . '</div>';

        case 'ordernumber':
            $user_id = $order->get_customer_id();
            if (get_post_meta($item['ID'], 'order_number', true) == '') {
                smile_brillaint_get_sequential_order_number($item['ID']);
            }
            $title = '<div class="order-inner-items"><strong><a target="_blank" href="' . $editUrl . '">' . get_post_meta($item['ID'], 'order_number', true) . '</a></strong>';
            //   $buttons = '<br>' . date('l M d, Y h:ia', strtotime($item['post_date']));
            // $buttons = '<br>' . sbr_datetime($item['post_date']);

            $threeWay = get_post_meta($item['ID'], 'threeWayShipment', true);
            $shipOrder = '';
            $buttons .= '<div class="OrderActionBtn">';
            // $buttons .= '<a class="button sbr-button" target="_blank" href="' . $editUrl . '">' . iconListingOrder('view') . '<span class="tooltiptext">Order Detail</span></a>';

            if ($order->get_status() === 'shipped') {

                $buttons .= '<a class="button sbr-button check-mbt" onClick="sbr_setAsCompleteOrder(' . $item['ID'] . ')" id="btn_setAsCompleteOrder_' . $item['ID'] . '" href="javascript:;" ><span class="dashicons dashicons-yes"></span><span class="tooltiptext">Mark as complete</span></a>';
            } else {
                $buttons .= $shipOrder;
            }





            $customer_chat = add_query_arg(
                    array(
                'action' => 'create_customer_popup',
                'order_id' => $item['ID'],
                'screen' => 'waiting-impression',
                'product_id' => 0,
                //	'ticket_id' => $ticket_id,
                'item_id' => 0,
                    ), admin_url('admin-ajax.php')
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
            $addOnOrder = add_query_arg(
                    array(
                'customer_id' => $user_id,
                'action' => 'create_addon_order',
                'order_type' => 'Addon',
                'parent_order_id' => $item['ID'],
                    ), admin_url('admin-ajax.php')
            );

            $buttons .= '<a class="addon_order button button-small sb_addon_order" href="javascript:;"  data-order-id="' . $item['ID'] . '"  custom-url="' . $addOnOrder . '">' . iconListingOrder('createAddon') . '<span class="tooltiptext">Create AddOn</span></a>';
            $has_note_class = 'post-it';
            if (get_post_meta($item['ID'], 'has_order_note')) {
                $has_note_class = 'post-it-red';
            }
            $buttons .= '<a type="button" id="addNotes" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="0" title="Admin Note">' . iconListingOrder($has_note_class) . '<span class="tooltiptext">Admin Notes</span></a>';
            // $buttons .= '<a type="button" id="editPersonalizedFollowup" class="button sbr-button sbr-button-order-add-notes" data-order-id="' . $item['ID'] . '" data-is_customer_note="1" title="Customer Notes">' . iconListingOrder('checklists') . '<span class="tooltiptext">Customer Notes</span></a>';
            //$buttons .= '<a type="button" id="deleteOrder" class="button sbr-button sbr-button-order-delete"  data-order-id="' . $item['ID'] . '" title="Delete Order"><span class="dashicons dashicons-trash"></span><span class="tooltiptext">Delete Order</span></a>';
            $buttons .= '</div>';
            //$buttons .= '<div class="OrderActionTxtBtn">';
            // $buttons .= '</div>';
            // $tags = '<p class="gifts-info no-flex-item">';

            if (get_post_meta($item['ID'], 'gehaOrder', true) == 'yes') {
                $tags .= '<span class="geha-icon flex-item-mbt">
                    <img src="/wp-content/uploads/2021/10/geha-logo-purple-300x75-1.png" alt="" > 
                    <span class="order-text-mbt">Order</span></span>';
            }
            if (get_post_meta($item['ID'], 'purchasing_as_giftset', true) == '1') {
                $tags .= '<span class="listingGiftOrder">Gift Order</span>';
            }
            $device = get_post_meta($item['ID'], 'user_device', true);
            if ($device != '') {
                if (strtolower($device) == 'mobile') {
                    $tags .= '<span class="listingOrderDevice">Device: Mobile</span>';
                } else {
                    $tags .= '<span class="listingOrderDevice">Device: Desktop</span>';
                }
            }

//            $orderType = get_post_meta($item['ID'], 'order_type', true);
//            if ($orderType) {
//                $tags .= '<br/><span class="listingOrderType">Order Type : ' . $orderType . '</span>';
//            }
            $product_id = $item_pro->get_product_id();
            $order_id = $item['ID'];
            $q_last = "SELECT  event_id , log_id FROM  " . SB_LOG;
            $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = '$order_id'";
            $q_last .= " ORDER BY log_id DESC LIMIT 1";
            $log_id = 0;
            $event_id = 0;
            $query_last = $wpdb->get_row($q_last);
            if ($query_last) {
                $log_id = $query_last->log_id;
                $event_id = $query_last->event_id;
            }

//<a class="create_acknowledged accept-case button button-small" action="recipt" href="javascript:;"  log_id="' . $response->log_id . '" item_id="' . $item_id . '" product_id="' . $product_id . '" order_id="' . $order_id . '">Acknowledged Receipt</a></p>';
//Log say data leinaa hai 
            if ($event_id == 3) {
                $buttons .= '<a class="button sbr-button check-mbt" onClick="sbr_impressionReceived(' . $item_id . ' , ' . $item_pro->get_product_id() . ' , ' . $item['ID'] . ' , ' . $log_id . ')"  id="btn_impressionReceived_' . $item_id . '" href="javascript:;" ><span class="dashicons dashicons-yes"></span><span class="tooltiptext">Impression Received</span></a>';
            }
            if ($event_id == 7) {
                $buttons .= '<a class="button sbr-button" target="_blank" href="' . $editUrl . '" >View Order <span class="tooltiptext">Impression Rejected. Please for more operation view detail page of order</span></a>';
            }

            if ($event_id == 5) {
                $splitOrder = add_query_arg(
                        array(
                    'action' => 'split_order',
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'splitOrder' => 1,
                    'item_id' => $item_id,
                    'log_id' => $log_id,
                        ), admin_url('admin-ajax.php')
                );


                $analyze_url = add_query_arg(
                        array(
                    'action' => 'analyze_impression_putty',
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'item_id' => $item_id,
                    'log_id' => $log_id,
                        ), admin_url('admin-ajax.php')
                );
                $buttons .= '<a class="sb_analyze_impression button button-small" href="javascript:;"  custom-url="' . $analyze_url . '" >Analyze Impression Putty</a>';
                $buttons .= SplitOrderForLog($splitOrder, $order_id);
            }


            $addonOrderUrl = add_query_arg(
                    array(
                'customer_id' => $user_id,
                'parent_order_id' => $order_id,
                'order_type' => 'Addon',
                    ), admin_url('admin.php?page=create-order')
            );

            // $buttons .= '<a class="button button-small" target="_blank"  id="addonOrder" href="' . $addonOrderUrl . '">Addon Order</a>';
            // $buttons .= '<a class="button button-small" target="_blank"  id="addonOrder" href="' . admin_url('admin.php?page=create-order&customer_id=' . $user_id) . '">Addon Order</a>';
            // $tags .= '</p>';
            return $title . $buttons . $tags . '</div>';


        //    return date('l M d, Y h:ia', strtotime($item['post_date']));
        case 'orderdate':
            return '<div class="order_date_sbr_inner">' . date('l M d, Y h:ia', strtotime($item['post_date'])) . '</div>';
        case 'emailphone':
            $phone = get_post_meta($item['ID'], '_billing_phone', true);
            $email = get_post_meta($item['ID'], '_billing_email', true);
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $buttons .= '<br><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit</a>';
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
                    $cardImageUrl = site_url('wp-content/plugins/woocommerce-gateway-authorize-net-cim/vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway/assets/images/card-' . $cardType . '.svg');
                    $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                    $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';
                    $totalOrderHtml .= '<span class="cardNumber">****' . get_post_meta($order->get_id(), '_wc_authorize_net_cim_credit_card_account_four', true) . '</span>';
                }

                //  $totalOrderHtml .= '<span class="col_method_title">' . wp_kses_post($order->get_payment_method_title()) . '</span>';


                $totalOrderHtml .= '</div>';
            } elseif (get_post_meta($order->get_id(), '_payment_method', true) == 'affirm') {
                $cardImageUrl = 'https://cdn-assets.affirm.com/images/blue_logo-transparent_bg.png';
                $totalOrderHtml .= '<div class="via_payment"><span class="paymentMethod">Payment Via</span>';
                //$totalOrderHtml .= '<span class="col_method_title">Affirm</span>';
                $totalOrderHtml .= '<span class="viaPaymentImage"><img  src="' . $cardImageUrl . '"></span>';
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
            $billing_arr = get_post_meta($item['ID']);
            $billing_method_html = '';
            //if($billing_arr['_payment_method_title'][0])
            //	$billing_method_html = '<br><br>via '.$billing_arr['_payment_method_title'][0];
            //$billing = $billing_arr['_billing_first_name'][0].' '.$billing_arr['_billing_last_name'][0].', '.$billing_arr['_billing_address_1'][0].', '.$billing_arr['_billing_city'][0].', '.$billing_arr['_billing_state'][0].' '.$billing_arr['_billing_postcode'][0];

            $phone = get_post_meta($item['ID'], '_billing_phone', true);
            $email = get_post_meta($item['ID'], '_billing_email', true);
            $customer_id = get_post_meta($item['ID'], '_customer_user', true);
            $buttons = '<div class="billingActions"><a class="button sbr-button loadIframeSBROrder editBuyerDetails" data-order-url="' . $editUrl . '&iframe=yes"  data-order-id="' . $item['ID'] . '"  href="javascript:;" >Edit</a>';
            //$buttons = '<div class="billingActions"><input type="button" class="button sbr-button editBuyerDetails" value="Edit" data-customer-id="'.$customer_id.'">';
            $buttons .= '<input type="button" class="button sbr-button buyerProfile" value="Buyer Profile" data-customer-id="' . $customer_id . '"></div>';
            //	$buttons .= $billing_method_html;
            $billingHtml = '';
            $billingHtml .= '<div class="billingAddressCol">';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $billing_arr['_billing_first_name'][0] . ' ' . $billing_arr['_billing_last_name'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $billing_arr['_billing_address_1'][0] . ', ' . $billing_arr['_billing_city'][0] . ', ' . $billing_arr['_billing_state'][0] . ' ' . $billing_arr['_billing_postcode'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-email-alt"></span><span class="billingSubInfo">' . $email . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-phone"></span><span class="billingSubInfo">' . $phone . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '</div>';
            return '<div class="billing-container">' . $billingHtml . $buttons . '</div>';

        //return $billing;
        case 'shipping':

            $shipping_method_html = '';
            $shipping_method = $order->get_shipping_method();
            if ($shipping_method != '') {
                $shipping_method_html .= '<div class="shippingMethodCol">';
                if (strpos($shipping_method, 'USPS') >= 0) {
                    $shipping_method_html .= '<span><img src="' . get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg" style="width:60px;"></span>';
                }
                $shipping_method_html .= '<span>via ' . $shipping_method . '</span>';
                $shipping_method_html .= '</div>';
            }

            $shipping_arr = get_post_meta($item['ID']);
            //$shipping = $shipping_arr['_shipping_first_name'][0].' '.$shipping_arr['_shipping_last_name'][0].', '.$shipping_arr['_shipping_address_1'][0].', '.$shipping_arr['_shipping_city'][0].', '.$shipping_arr['_shipping_state'][0].' '.$shipping_arr['_shipping_postcode'][0].$shipping_method_html;

            $billingHtml = '';
            $billingHtml .= '<div class="shippingAddressCol">';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-users"></span></span><span class="billingSubInfo">' . $shipping_arr['_shipping_first_name'][0] . ' ' . $shipping_arr['_shipping_last_name'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= '<div class="billinginfo">';
            $billingHtml .= '<span class="dashicons dashicons-admin-home"></span><span class="billingSubInfo">' . $shipping_arr['_shipping_address_1'][0] . ', ' . $shipping_arr['_shipping_city'][0] . ', ' . $shipping_arr['_shipping_state'][0] . ' ' . $shipping_arr['_shipping_postcode'][0] . '</span>';
            $billingHtml .= '</div>';
            $billingHtml .= $shipping_method_html;
            $billingHtml .= '</div>';
            return '<div class="shipping-container">' . $billingHtml . $buttons . '</div>';


            return $shipping;
        case 'ship':

            $order_status = $order->get_status();
            return '<span class="sbr-' . $order_status . '">' . wc_get_order_status_name($order_status) . '</span>';





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
//                foreach ($order->get_items() as $item_id => $item_pro) {
//                    if($item_id_main!=$item_id){
//                        continue;
//                    }
            $tray_html = '';
            $coupon_html = '';
            $discount_html = '';
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
                    'screen' => 'waiting-impression',
                        ), admin_url('admin-ajax.php')
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
                if ($three_way_ship_product) {
                    //$tray_html = smilebrilliant_order_meta_tray_number_display($item_id, $item_pro, $item_pro->get_product(), 2);
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

                $tray_html .= '<a class="customer_chat button button-small sb_customer_chat ' . $ticket_status_item . '" href="javascript:;"  custom-url="' . $customer_chat . '" >' . iconListingOrder($img) . '<span class="tooltiptext">' . $tool_tip_ticket . '</span></a>';
                //}

                $prodcuts .= '<tr><td>' . $item_pro->get_name() . $tray_html . '</td><td>' . $item_pro->get_quantity() . '</td>';
                $prodcuts .= '<td>' . $qtyShipped . '</td>';
                $prodcuts .= '<td>' . get_order_item_status_mbt($item_pro, $item_id) . '</td><td>' . get_order_item_tracking_mbt($item_id) . '</td><td>' . $coupon_html . '</td><td>' . $discount_html . '</td><tr>';
            }
            //   }
            $prodcuts .= '</tbody></table>';

            return $prodcuts;
        default:
            return ''; //print_r( $item, true );
    }
}

?>