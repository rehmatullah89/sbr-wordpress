<?php
add_action('wp_ajax_rma_popup', 'rma_popup_callback');
/**
 * Retrieves the Order detail for RMA Request Popup on order listing and order detail page for ADMIN
 *
 * @param int order ID.
 *
 */
function rma_popup_callback()
{
    if (isset($_REQUEST['order_id'])) :

        global $MbtPackaging, $wpdb;
        $order_id = $_REQUEST['order_id'];
        $order = wc_get_order($order_id);
        $parent_product = 0;
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

        $easypostShipmentAddresses = easypostShipmentAddresses($order_id, $shipping_postcode);
        // echo 'Data: <pre>' .print_r($easypostShipmentAddresses,true). '</pre>';
?>

        <div class="popup-shipment">
            <form id="shipping_metabox_form">
                <div class="shipment-container">
                    <div class="shipmemt-header flex-row justify-content-between">
                        <h3 id="create_shipment_heading">Create shipment</h3>
                    </div>

                    <div class="shipment-body">
                        <div class="shipiing-setup">
                            <h3>Shipment Details</h3>
                            <div class="inner-spacing">
                                <div class="flex-row">
                                    <div class="col-sm-4">
                                        <div class="form-group" id="package_configuration">

                                        </div>
                                    </div>
                                    <?php
                                    $shipping_method_id = 0;
                                    foreach ($order->get_items('shipping') as $item_id => $item) {

                                        $shipping_method_id = $item->get_instance_id(); // The method ID
                                    }
                                    $shipmentMethodAutoSelect = selectEasyPostMethodByOrderMethod($shipping_method_id);
                                    ?>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelMethod">Shipping Carrier</label>
                                        <select name="shipmentLabelMethod" id="shipmentLabelMethod">
                                            <option value="USPS">USPS</option>
                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelService">Shipping Product </label>
                                        <select id="shipmentLabelService" name="shipmentLabelService" class="form-control">
                                            <option value="FirstClassPackageInternationalService">First Class International</option>
                                            <option value="PriorityMailInternational">Priority International</option>
                                            <option value="ExpressMailInternational">Express International</option>
                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelSignatureConfirmationLabel">Signature Confirm? </label>
                                        <select id="shipmentLabelSignatureConfirmation" class="form-control">
                                            <option value="" selected="selected">Not Required</option>
                                            <option value="SIGNATURE">Required</option>
                                        </select>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Actual Ship Date</label>
                                            <input type="date" name="shipmentLabelShipDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="checkbox" id="shipmentLabelSaturdayDeliveryLabel">
                                            <input type="checkbox" id="shipmentLabelSaturdayDelivery" name="shipmentLabelSaturdayDelivery" value="1">Saturday Delivery
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="inner-spacing">
                                <div class="col-sm-12-large label-inline-mbt">
                                    <label for="print_label_shipment">
                                        <input name="print_label_shipment" id="print_label_shipment" type="checkbox" checked="" class="" value="yes">
                                        <span class="print_label_shipment">Print Label</span>
                                    </label>
                                    <label for="package_label_shipment">
                                        <input name="package_label_shipment" id="package_label_shipment" type="checkbox" checked="" class="" value="yes">
                                        <span class="package_label_shipment">Package Label</span>
                                    </label>

                                    <label for="tracking_email_shipment">
                                        <input name="tracking_email" id="tracking_email_shipment" type="checkbox" checked="" class="" value="yes">
                                        <span class="tracking_email_shipment">Tracking Email</span>
                                    </label>
                                    <br />
                                </div>
                            </div>

                        </div>

                        <div class="row-body">
                            <div class="shipping-on-same-address-button">

                                <?php
                                $customer_id = $order->get_user_id();
                                $matchingOrders = get_posts(array(
                                    'numberposts' => -1,
                                    //'fields'        => 'ids',
                                    'post_type' => 'shop_order',
                                    'post_status' => array('wc-processing', 'wc-partial_ship', 'wc-on-hold', 'wc-pending'),
                                    'order' => 'ASC',
                                    'meta_query' => array(
                                        'relation' => 'OR',
                                        array(
                                            'key' => '_shipping_postcode',
                                            'value' => $shipping_postcode,
                                            'compare' => '=',
                                        ),
                                        array(
                                            'key' => '_customer_user',
                                            'compare' => '=',
                                            'value' => $customer_id, #<-- just some value as a pre 3.9 bugfix (Codex)
                                        ),
                                    )
                                ));
                                if ($matchingOrders) {
                                    echo '<h3 class="heading-section-address">Order(s) going to the same Customer/Address:</h3>';
                                    $order_statuses = array(
                                        'wc-pending' => _x('Pending payment', 'Order status', 'woocommerce'),
                                        'wc-processing' => _x('Processing', 'Order status', 'woocommerce'),
                                        'wc-on-hold' => _x('On hold', 'Order status', 'woocommerce'),
                                        'wc-partial_ship' => _x('Partial Ship', 'Order status', 'woocommerce'),
                                    );

                                    foreach ($matchingOrders as $m_order) {
                                        $s_order_id = $m_order->ID;
                                        if ($order->get_id() == $s_order_id) {
                                            continue;
                                        }
                                        $orderSBRref = get_post_meta($s_order_id, 'order_number', true);
                                        $orderId_html = '<div class="suggestEntry" id="matchOrder_' . $s_order_id . '">';
                                        $order_status = $order_statuses[$m_order->post_status];
                                        $orderId_html .= '<div class="suggestOrderItems"><button  onclick="addMatchingOrderShipment(' . $s_order_id . ')" class="button" type="button">' . $orderSBRref . ' - ' . $order_status . '</button></div>';
                                        $orderId_html .= '<div class="suggest_order_remove_field"><a href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></div>';
                                        $orderId_html .= '</div>';
                                        echo $orderId_html;
                                    }
                                }
                                ?>
                            </div>
                            <div class="tr-body" id="mbt_shipping_Item_listing">

                                <?php
                                //  mbt_addOrderStatus($order_id);
                                mbt_shipment_item_data_callback($order_id);
                                ?>

                            </div>

                            <div class="add-order-btn">
                                <button id="add_order_shipment_btn" onclick="addOrderShipment()" class="button" type="button">Add Order</button>
                            </div>

                        </div>

                        <div class="shipiing-setup custom-shipping-address">

                            <?php
                            $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ', ' . $shipping_address_1 . ' ' . $shipping_address_2 . ', ' . $shipping_city . ', ' . $shipping_state . ', ' . $shipping_postcode . ', ' . WC()->countries->countries[$shipping_county];
                            // $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ' ' . $shipping_address_1 . ' ' . $shipping_address_2 . ' ' . $shipping_city . ' ' . $shipping_state . ' (' . $shipping_postcode . ') , ' . WC()->countries->countries[$shipping_county]; 
                            ?>
                            <div class="cmt-thed">
                                <h3>Shipping Address</h3>

                                <div class="ready-toship shipping-address-container-mbt">

                                    <label for="is_shipping_address_default">
                                        <input name="is_shipping_address_changed" id="is_shipping_address_default" type="radio" checked="" class="" value="old">
                                        <span class="ship-different">Default Address - <?php echo $shippingDetails; ?></span>
                                    </label>
                                    <?php
                                    if ($easypostShipmentAddresses) {
                                        foreach ($easypostShipmentAddresses as $keyA => $ep_add) {
                                            $shippingDetails = $ep_add->shiptoFirstName . ' ' . $ep_add->shiptoLastName . ', ' . $ep_add->shiptoAddress . ', ' . $ep_add->shiptoCity . ', ' . $ep_add->shiptoState . ', ' . $ep_add->shiptoPostalCode . ', ' . WC()->countries->countries[$shipping_county];
                                            //$shippingDetails = $ep_add->shiptoFirstName . ' ' . $ep_add->shiptoLastName . ' ' . $ep_add->shiptoAddress . ' ' . $ep_add->shiptoCity . ' ' . $ep_add->shiptoState . ' (' . $ep_add->shiptoPostalCode . ') , ' . WC()->countries->countries[$ep_add->shiptoCountry];
                                    ?>
                                            <label for="is_shipping_address_default_<?php echo $keyA; ?>">
                                                <input name="is_shipping_address_changed" id="is_shipping_address_default_<?php echo $keyA; ?>" type="radio" class="" value="<?php echo $ep_add->shipment_id; ?>">
                                                <span class="ship-different">Shipment Address - <?php echo $shippingDetails; ?></span>
                                            </label>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <label for="is_shipping_address_changed">
                                        <input name="is_shipping_address_changed" id="is_shipping_address_changed" type="radio" class="" value="new">
                                        <span class="ship-different">Ship to different address</span>
                                    </label>

                                </div>
                            </div>


                            <div class="form-body-ship" style="display: none" id="is_shipping_address_changed_tbody">
                                <div class="flex-row">

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> First Name </label>
                                            <input type="text" name="fname" class="form-control" value="<?php echo $shipping_firstname; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Last Name </label>
                                            <input type="text" name="lname" class="form-control" value="<?php echo $shipping_lastname; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" name="email" class="form-control" value="<?php echo $shipping_email; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Phone </label>
                                            <input type="number" name="phone" class="form-control" value="<?php echo $shipping_phone; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Address Line 1</label>
                                            <textarea class="form-control" name="address_1"><?php echo $shipping_address_1; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Address Line 2 </label>
                                            <textarea class="form-control" name="address_2"><?php echo $shipping_address_2; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="<?php echo $shipping_city; ?>" />
                                        </div>
                                    </div>




                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" name="zipcode" class="form-control" value="<?php echo $shipping_postcode; ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group select-country-mbt">

                                            <?php
                                            $countries_obj = new WC_Countries();
                                            $countries = $countries_obj->__get('countries');

                                            woocommerce_form_field(
                                                'shipment_country',
                                                array(
                                                    'type' => 'select',
                                                    'required' => true,
                                                    'class' => array('chzn-drop'),
                                                    'label' => __('Select a country'),
                                                    'placeholder' => __('Enter something'),
                                                    'options' => $countries
                                                ),
                                                $shipping_county
                                            );
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- <div class="form-group" style="display:none">
                                            <label>State</label>
                                            

                                            
                                            <input type="text" name="state" class="form-control"
                                                value="<?php echo $shipping_state; ?>" />
                                        </div> -->
                                        <div class="form-group" id="shipmentStateHtml">
                                            <?php
                                            if (empty($shipping_county)) {
                                                $shipping_county = 'US';
                                            }
                                            get_stateByCountry_SBR('shipment_state', $shipping_county, $shipping_state);
                                            ?>
                                        </div>

                                    </div>

                                </div>


                            </div>



                            <div class="shipiing-content" id="shipmentContentWapper">
                                <h3>Shipment Contents</h3>


                                <div class="inner-spacing">
                                    <div class="flex-row">
                                        <div class="col-sm-6">
                                            <label class="select" id="shiptoContentsType">
                                                Shipment Content
                                                <select id="shiptoContentsType" name="shiptoContentsType" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="merchandise" selected="">Merchandise</option>
                                                    <option value="returned_goods">Returned Goods</option>
                                                    <option value="gift">Gift</option>
                                                    <option value="sample">Sample</option>
                                                </select>
                                            </label>
                                        </div>
                                        <!--                                        <div class="col-sm-6">
                                            <label class="input" id="shiptoTariffCode"> 
                                                HS Tariff Code
                                                <input type="text" name="shiptoTariffCode" id="shiptoTariffCode" value="" placeholder="HS Tariff Code" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
                                            </label>
                                        </div>-->
                                        <!-- <div class="col-sm-4">
                                             <label class="input" id="shipmentContentsDescriptionLabel">
                                             CONTENT DESCRIPTION 
                                                 <input type="text" id="shipmentContentsDescription" value="" placeholder="Shipment Contents Description">
                                             </label>
                                         </div>
         
                                          <div class="col-sm-2">
                                             <label class="input" id="shipmentContentsValueLabel">
                                             CONTENT VALUE 
                                                 <div class="input-group">
                                                     <input id="shipmentContentsValue" class="form-control" placeholder="Value (USD)" type="text" value="">
                                                 </div>
                                             </label>
                                         </div> 
         
                                         <div class="col-sm-4">
                                             <label class="input" id="shipmentContentsManufacturerLabel">
                                             CONTENT MANUFACTURER 
                                                 <input type="text" id="shipmentContentsManufacturer" value="" placeholder="Shipment Contents Manufacturer">
                                             </label>
                                         </div>-->
                                    </div>
                                </div>
                            </div>

                            <div class="shipiing-setup">
                                <h3>Add Packaging Note</h3>
                                <div class="shipiing-setup add-packagng-notes">
                                    <textarea name="packaging_order_note" rows="4" cols="100" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div id="shipment_response">

                            </div>

                            <div class="buttons-footer">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="ship_item_id" id="ship_item_id" value="" />
                                <input type="hidden" name="action" value="mbt_createShipmentWithPackages" />
                                <?php
                                if (isset($_REQUEST['relaod']) && $_REQUEST['relaod'] == 'yes') {
                                    echo ' <input type="hidden" name="source" value="add" />';
                                } else {
                                    echo ' <input type="hidden" name="source" value="order" />';
                                }
                                ?>

                                <button type="button" order_id="<?php echo $order_id; ?>" id="btn_ship_now">Generate Shipment</button>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
        <script>
            load_packages();
            shipmentContent('<?php echo $shipping_county; ?>', '<?php echo $shipmentMethodAutoSelect; ?>');
        </script>

    <?php
    endif;
    die;
}






add_action('wp_ajax_claimReplaceWarranty', 'wp_ajax_claimReplaceWarranty_callback');
/**
 * Claim Replacement request for existing order on listing or detail page
 *
 */
function wp_ajax_claimReplaceWarranty_callback()
{

    if (isset($_REQUEST['new_product_id'])) {
        global $wpdb;
        $product_logs = array();
        $old_order_id = $_REQUEST['order_id'];
        $old_order = wc_get_order($old_order_id);
        $billing_address = array(
            'first_name' => $old_order->get_billing_first_name(),
            'last_name' => $old_order->get_billing_last_name(),
            'company' => $old_order->get_billing_company(),
            'email' => $old_order->get_billing_email(),
            'phone' => $old_order->get_billing_phone(),
            'address_1' => $old_order->get_billing_address_1(),
            'address_2' => $old_order->get_billing_address_2(),
            'city' => $old_order->get_billing_city(),
            'postcode' => $old_order->get_billing_postcode(),
            'state' => $old_order->get_billing_state(),
            'country' => $old_order->get_billing_country()
        );

        $shipping_address = array(
            'first_name' => $old_order->get_shipping_first_name(),
            'last_name' => $old_order->get_shipping_last_name(),
            'company' => $old_order->get_shipping_company(),
            'address_1' => $old_order->get_shipping_address_1(),
            'address_2' => $old_order->get_shipping_address_2(),
            'city' => $old_order->get_shipping_city(),
            'postcode' => $old_order->get_shipping_postcode(),
            'state' => $old_order->get_shipping_state(),
            'country' => $old_order->get_shipping_country()
        );


        $args = array(
            'customer_id' => $old_order->get_user_id(),
            //   'parent' => $old_order->get_id(),
        );

        // Create the order and assign it to the current user
        $order = wc_create_order($args);
        $order = wc_get_order($order->get_id());
        $order->set_address($billing_address, 'billing');
        $order->set_address($shipping_address, 'shipping');
        $child_order_id = $order->get_id();
        $products = $_REQUEST['new_product_id'];
        $items_qty = $_REQUEST['item_qty'];
        $discount = $_REQUEST['discount'];
        if ($products) {
            foreach ($products as $key => $p) {

                $product_id = absint($p);
                $product = wc_get_product($product_id);
                $qty = 1;
                if ($items_qty[$key]) {
                    $qty = $items_qty[$key];
                }
                $dis_percentge = 0;
                if ($discount[$key]) {
                    $dis_percentge = $discount[$key];
                }
                if ($dis_percentge) {
                    $regular_price = (float) $product->get_regular_price(); // Regular price
                    $discount = $dis_percentge * $regular_price / 100;
                    $new_product_price = $regular_price - $discount;
                    $product->set_price($new_product_price);
                }

                if (!$product) {
                    throw new Exception(__('Invalid product ID', 'woocommerce') . ' ' . $product_id);
                }
                if ('variable' === $product->get_type()) {
                    /* translators: %s product name */
                    throw new Exception(sprintf(__('%s is a variable product parent and cannot be added.', 'woocommerce'), $product->get_name()));
                }
                $validation_error = new WP_Error();
                $validation_error = apply_filters('woocommerce_ajax_add_order_item_validation', $validation_error, $product, $order, $qty);

                if ($validation_error->get_error_code()) {
                    throw new Exception('<strong>' . __('Error:', 'woocommerce') . '</strong> ' . $validation_error->get_error_message());
                }
                $_POST['action'] = 'woocommerce_add_order_item';

                $item_id = $order->add_product($product, $qty);



                $item = apply_filters('woocommerce_ajax_order_item', $order->get_item($item_id), $item_id, $order, $product);

                $added_items[$item_id] = $item;
                $order_notes[$item_id] = $product->get_formatted_name();

                if ($product->managing_stock()) {
                    $new_stock = wc_update_product_stock($product, $qty, 'decrease');
                    $order_notes[$item_id] = $product->get_formatted_name() . ' &ndash; ' . ($new_stock + $qty) . '&rarr;' . $new_stock;
                    $item->add_meta_data('_reduced_stock', $qty, true);
                    $item->save();
                }
                $product_visibility = $product->get_catalog_visibility();
                if ($product_visibility != 'visible') {
                    $item->add_meta_data('warranty', 'yes', true);
                }
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product == 'yes') {

                    $child_query = $wpdb->get_results("SELECT * FROM  " . SB_ORDER_TABLE . " WHERE order_id = $child_order_id and item_id = $item_id");
                    if (empty($child_query)) {
                        $wpdb->insert(SB_ORDER_TABLE, array(
                            "order_id" => $child_order_id,
                            "tray_number" => '',
                            "ticket_id" => 0,
                            "item_id" => $item_id,
                            "product_id" => $product_id,
                            "status" => 1,
                            "user_id" => $order->get_customer_id(),
                            "created_date" => date("Y-m-d h:i:sa"),
                        ));
                    }
                }
                $q1 = "SELECT * FROM  " . SB_LOG . " as l";
                $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $child_order_id;
                ///  $q1 .= " ORDER BY log_id DESC LIMIT 1";

                $query_q0 = $wpdb->get_results($q1);
                if (empty($query_q0)) {
                    //Create Log
                    $event_data = array(
                        "order_id" => $child_order_id,
                        "child_order_id" => 0,
                        "item_id" => $item_id,
                        "product_id" => $product_id,
                        "event_id" => 1,
                    );
                    sb_create_log($event_data);
                }
                $item->save();
                $order->calculate_totals();
                $order->save();
                ///$order = wc_get_order($order->get_id());


                do_action('woocommerce_ajax_add_order_item_meta', $item_id, $item, $order);
            }
            $order->add_order_note(sprintf(__('Added line items: %s', 'woocommerce'), implode(', ', $order_notes)), false, true);

            do_action('woocommerce_ajax_order_items_added', $added_items, $order);
        }

        $order->calculate_totals();

        $order->save();
        $update = array(
            'child_order_id' => $child_order_id
        );
        $condition = array(
            "log_id" => $_REQUEST['log_id'],
        );
        $wpdb->update(SB_LOG, $update, $condition);
        $event_id = 12;
        $event_data = array(
            "order_id" => $old_order_id,
            "child_order_id" => $child_order_id,
            "item_id" => $_REQUEST['item_id'],
            "product_id" => $_REQUEST['product_id'],
            "event_id" => $event_id,
            'warranty_claim_id' => $_REQUEST['warranty_claim_id'],
        );
        sb_create_log($event_data);
        update_post_meta($child_order_id, 'created_good_to_ship', 'yes');
    }
    die;
}

add_action('wp_ajax_create_warranty_order_popup', 'create_warranty_order_popup_callback');

/**
 * Create Warranty request for existing order on listing or detail page
 *
 */
function create_warranty_order_popup_callback()
{

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $log_id = $_REQUEST['log_id'];
    $warranty_claim_id = $_REQUEST['warranty_claim_id'];

    $loop = new WP_Query($args);
    $products_options = '';
    while ($loop->have_posts()) : $loop->the_post();

        $products_options .= '<option value="' . get_the_ID() . '">' . woocommerce_get_product_thumbnail() . ' ' . get_the_title() . '</option>';
    endwhile;
    wp_reset_query();
    ?>
    <form id="addOn_order_form">
        <table class="widefat" id="addon-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>

                        <select class="add_products" name="new_product_id[]">
                            <?php echo $products_options; ?>
                        </select>
                    </td>
                    <td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="item_qty[]" placeholder="1" size="4" class="quantity"></td>
                    <td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="quantity"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><button id="add_addon_product_btn" class="button" type="button">Add Product</button></td>
            </tfoot>
        </table>
        <input type="hidden" name="action" value="claimReplaceWarranty" />
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
        <input type="hidden" name="log_id" value="<?php echo $log_id; ?>" />
        <input type="hidden" name="warranty_claim_id" value="<?php echo $warranty_claim_id; ?>" />
    </form>
    <div class="addOn-modal-footer">
        <button type="button" id="close_order_popup" class="btn btn-danger button">Close</button>
        <div class="addOn-modal-footer_create">
            <button data-bb-handler="Charge" type="button" id="generate_addOn_order" class="btn btn-danger button">Create Order</button>
        </div>

    </div>

    <style>
        .remove_field span {
            float: right;
        }

        .addOn-modal-footer {
            margin-top: 10px;
            display: flex;
        }

        #TB_ajaxContent {
            padding: 15px 15px 15px 15px;
            width: 100% !important;
        }

        .addOn-modal-footer button {
            margin-right: 17px !important;
        }
    </style>
    <script>
        jQuery("body").on('click', '#close_order_popup', (function(e) {
            //jQuery('#TB_closeWindowButton').trigger('click');
            //tb_remove();

        }));
        var count_addToCart = true;
        jQuery("body").on('click', '#generate_addOn_order', (function(e) {
            if (count_addToCart) {
                jQuery('#addon-table').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });


                count_addToCart = false;
                jQuery('body').find('.addOn-modal-footer_create').html('<span class="spinner is-active"></span>');
                e.preventDefault();
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                var elementT = document.getElementById("addOn_order_form");
                var order_id = jQuery(elementT).find('input[name="order_id"]').val();

                //// console.log(elementT);
                var formdata = new FormData(elementT);
                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    method: 'POST',
                    success: function(response) {
                        jQuery('#addon-table').unblock();
                        //tb_remove();
                        smile_brillaint_order_modal.style.display = "none";
                        reload_order_item_table_mbt(order_id);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        }));
        jQuery(".add_products").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });

        jQuery(document).ready(function() {
            var max_fields = 10; //maximum input boxes allowed
            var wrapper = jQuery("body").find('#addon-table tbody'); //Fields wrapper
            var add_button = jQuery("body").find("#add_addon_product_btn"); //Add button ID

            var x = 1; //initlal text box count
            jQuery(add_button).click(function(e) { //on add input button click
                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    var html = '';
                    html += '<tr>';
                    html += '<td><select class="add_products" name="product_id[]"><?php echo $products_options; ?></select></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="item_qty[]" placeholder="1" size="4" class="quantity"></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="quantity"></td>';
                    html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                    jQuery(wrapper).append(html); //add input box
                    jQuery(".add_products").select2({
                        placeholder: "Please select product.",
                        allowClear: true,
                        width: '100%'
                    });
                }
            });

            jQuery("body").find('#addon-table tbody').on("click", ".remove_field", function(e) { //user click on remove text
                e.preventDefault();
                jQuery(this).closest('tr').remove();
                x--;
            });
        });
    </script>

<?php
    die;
}
