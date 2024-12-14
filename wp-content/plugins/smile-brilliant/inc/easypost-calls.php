<?php

use Dompdf\Dompdf;

/**
 * PHP Search an Array for multiple key / value pairs
 */
function multi_array_search($array, $search)
{
    // Create the result array
    $result = array();

    // Iterate over each array element
    foreach ($array as $key => $value) {

        // Iterate over each search condition
        foreach ($search as $k => $v) {

            // If the array element does not meet the search condition then continue to the next element
            if (!isset($value[$k]) || $value[$k] != $v) {
                continue 2;
            }
        }
        // Add the array element's key to the result array
        $result[] = $key;
    }

    // Return the result array
    return $result;
}

add_action('wp_ajax_addPackageGroup', 'addPackageGroup_callback');
/**
 *  add package group if not found. 
 */
function addPackageGroup_callback()
{
    $response = array();
    global $MbtPackaging;

    if (isset($_REQUEST['package_id']) && $_REQUEST['package_id'] > 0) {
        $products = $_REQUEST['product'];
        $data = array();
        $productsWithQty = array();
        foreach ($products as $key => $pro_id) {
            if ($_REQUEST['product'][$key] == SHIPPING_PROTECTION_PRODUCT) {
                continue;
            }
            $productsWithQty[] = array(
                'product_id' => $_REQUEST['product'][$key],
                'qty' => $_REQUEST['qty'][$key],
                'level' => isset($_REQUEST['level'][$key]) ?  $_REQUEST['level'][$key] : 1,
            );

            $data[] = array(
                'product_id' => $_REQUEST['product'][$key],
                'level' => isset($_REQUEST['level'][$key]) ?  $_REQUEST['level'][$key] : 1,
                'min' => '1',
                'qty' => $_REQUEST['qty'][$key],
                'max' => isset($_REQUEST['qty'][$key]) ? $_REQUEST['qty'][$key] : 1,
            );
            /*
            $productsWithQty[] = array(
                'product_id' => $_REQUEST['product'][$key],
                'qty' => $_REQUEST['qty'][$key],
                'level' => $_REQUEST['level'][$key],
            );

            $data[] = array(
                'product_id' => $_REQUEST['product'][$key],
                'level' => $_REQUEST['level'][$key],
                'min' => '1',
                'max' => isset($_REQUEST['qty'][$key]) ? $_REQUEST['qty'][$key] : 1,
            );
            */
        }

        $package_detail = $MbtPackaging->get_package_ids_for_basket($productsWithQty);
        if (isset($package_detail['status']) && $package_detail['status'] == 1) {
            $response = array(
                'code' => 'error',
                'msg' => 'Already product group added.'
            );
        } else {

            $responseAjax = $MbtPackaging->add_packaging_combination_by_package_id($_REQUEST['package_id'], $data);

            if ($responseAjax) {
                $response = array(
                    'code' => 'success',
                    'msg' => 'Product group save against selected package plan.'
                );
            } else {
                $response = array(
                    'code' => 'error',
                    'msg' => 'Already product group added.'
                );
            }
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => 'Please select package plan.'
        );
    }
    echo json_encode($response);
    die;
}
/**
 *  on product save update child items from previous system to  new and new to old
 */
add_action('save_post_product', 'onSaveProductWeightCalculation', 10, 3);
function updateCompositeProductItems($comp_product_id, $type)
{
    $all_component = get_post_meta($comp_product_id, '_bto_data', true);
    if ($type == 'old') {
        if (empty($all_component)) {
            $bto_data_backup  = get_post_meta($comp_product_id, '_bto_data_backup', true);
            update_field('composite_products', '',  $comp_product_id);
            update_post_meta($comp_product_id, '_bto_data', $bto_data_backup);
        }
        wp_remove_object_terms($comp_product_id, 'simple', 'product_type', true);
        wp_set_object_terms($comp_product_id, 'composite', 'product_type', true);
    } else {
        $productData = array();
        if ($all_component) {
            foreach ($all_component as $comp_id => $comp_data) {
                $sm_first_shipment = get_post_meta($comp_id, 'sm_first_shipment', true);
                $sm_second_shipment = get_post_meta($comp_id, 'sm_second_shipment', true);
                $childproductData = array();
                $childproductData['product_id'] = $comp_data['default_id'];
                if ($sm_first_shipment) {
                    $childproductData['first_shipment_qty'] = $sm_first_shipment;
                } else {
                    $childproductData['first_shipment_qty'] = 0;
                }
                if ($sm_second_shipment) {
                    $childproductData['second_shipment_qty'] = $sm_second_shipment;
                } else {
                    $childproductData['second_shipment_qty'] = 0;
                }
                $productData[] =  $childproductData;
            }

            update_field('composite_products', $productData,  $comp_product_id);
            update_post_meta($comp_product_id, '_bto_data', '');
            update_post_meta($comp_product_id, '_bto_data_backup', $all_component);
        }
        wp_remove_object_terms($comp_product_id, 'composite', 'product_type', true);
        wp_set_object_terms($comp_product_id, 'simple', 'product_type', true);
    }
}


/**
 *  update components in parent product (previous version)
 */
function updateCompositeProductItems_bkkk($comp_product_id, $type)
{

    $all_component = get_post_meta($comp_product_id, '_bto_data', true);
    if ($type == 'old') {
        if (empty($all_component)) {
            $bto_data_backup  = get_post_meta($comp_product_id, '_bto_data_backup', true);
            update_field('composite_products', '',  $comp_product_id);
            update_post_meta($comp_product_id, '_bto_data', $bto_data_backup);
        }
    } else {
        $productData = array();
        if ($all_component) {
            foreach ($all_component as $comp_id => $comp_data) {
                $sm_first_shipment = get_post_meta($comp_id, 'sm_first_shipment', true);
                $sm_second_shipment = get_post_meta($comp_id, 'sm_second_shipment', true);
                $childproductData = array();
                $childproductData['product_id'] = $comp_data['default_id'];
                if ($sm_first_shipment) {
                    $childproductData['first_shipment_qty'] = $sm_first_shipment;
                } else {
                    $childproductData['first_shipment_qty'] = 0;
                }
                if ($sm_second_shipment) {
                    $childproductData['second_shipment_qty'] = $sm_second_shipment;
                } else {
                    $childproductData['second_shipment_qty'] = 0;
                }
                $productData[] =  $childproductData;
            }

            update_field('composite_products', $productData,  $comp_product_id);
            update_post_meta($comp_product_id, '_bto_data', '');
            update_post_meta($comp_product_id, '_bto_data_backup', $all_component);
        }
    }
}
/**
 * on product save calculate weight of child components, HANDLED Switch case as well 
 */
function onSaveProductWeightCalculation($product_id, $post, $update)
{

    $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
    $product = wc_get_product($product_id);
    if ($product->get_type() == 'composite') {
        $compositeData = get_post_meta($product_id, '_bto_data', true);

        $frist_shipment_weight = 0;
        $second_shipment_weight = 0;
        if ($compositeData) {
            foreach ($compositeData as $composite_item_id => $composite_item) {

                $composite_item_product_id = $composite_item['default_id'];
                $weight = get_post_meta($composite_item_product_id, '_weight', true);
                if ($weight == '') {
                    $weight = 0.01;
                }
                if ($productShipmentType) {
                    $firstShipment = get_post_meta($composite_item_id, 'sm_first_shipment', true);
                    $secondShipment = get_post_meta($composite_item_id, 'sm_second_shipment', true);

                    if ($firstShipment == '') {
                        $firstShipment = 0;
                    }
                    if ($secondShipment == '') {
                        $secondShipment = 0;
                    }
                    $compositeWeightFrist = $weight * $firstShipment;
                    $compositeWeightSecond = $weight * $secondShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                    $second_shipment_weight = $second_shipment_weight + $compositeWeightSecond;
                } else {
                    $firstShipment = $composite_item['quantity_max'];
                    $compositeWeightFrist = $weight * $firstShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                }
            }
        } else {
            $compositeData = get_field('composite_products', $product_id);

            foreach ($compositeData as $composite_item_id => $composite_item) {

                $composite_item_product_id = $composite_item['product_id'];
                $weight = get_post_meta($composite_item_product_id, '_weight', true);
                if ($weight == '') {
                    $weight = 0.01;
                }
                if ($productShipmentType) {

                    $firstShipment = $composite_item['first_shipment_qty'];
                    $secondShipment = $composite_item['second_shipment_qty'];

                    if ($firstShipment == '') {
                        $firstShipment = 0;
                    }
                    if ($secondShipment == '') {
                        $secondShipment = 0;
                    }
                    $compositeWeightFrist = $weight * $firstShipment;
                    $compositeWeightSecond = $weight * $secondShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                    $second_shipment_weight = $second_shipment_weight + $compositeWeightSecond;
                } else {
                    $firstShipment = $composite_item['first_shipment_qty'];
                    $compositeWeightFrist = $weight * $firstShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                }
            }
        }
        update_post_meta($product_id, '_first_shipment_weight', $frist_shipment_weight);
        if ($productShipmentType) {
            update_post_meta($product_id, '_second_shipment_weight', $second_shipment_weight);
        }
    }
}

/**
 * on product save calculate weight of child components (Old VERSION)
 */
function onSaveProductWeightCalculation_previous($product_id, $post, $update)
{

    $productShipmentType = get_post_meta($product_id, 'three_way_ship_product', true);
    $product = wc_get_product($product_id);
    if ($product->get_type() == 'composite') {
        $compositeData = get_post_meta($product_id, '_bto_data', true);
        $frist_shipment_weight = 0;
        $second_shipment_weight = 0;
        if ($compositeData) {
            foreach ($compositeData as $composite_item_id => $composite_item) {

                $composite_item_product_id = $composite_item['default_id'];
                $weight = get_post_meta($composite_item_product_id, '_weight', true);
                if ($weight == '') {
                    $weight = 0.01;
                }
                if ($productShipmentType) {
                    $firstShipment = get_post_meta($composite_item_id, 'sm_first_shipment', true);
                    $secondShipment = get_post_meta($composite_item_id, 'sm_second_shipment', true);

                    if ($firstShipment == '') {
                        $firstShipment = 0;
                    }
                    if ($secondShipment == '') {
                        $secondShipment = 0;
                    }
                    $compositeWeightFrist = $weight * $firstShipment;
                    $compositeWeightSecond = $weight * $secondShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                    $second_shipment_weight = $second_shipment_weight + $compositeWeightSecond;
                } else {
                    $firstShipment = $composite_item['quantity_max'];
                    $compositeWeightFrist = $weight * $firstShipment;
                    $frist_shipment_weight = $frist_shipment_weight + $compositeWeightFrist;
                }
            }
        }
        update_post_meta($product_id, '_first_shipment_weight', $frist_shipment_weight);
        if ($productShipmentType) {
            update_post_meta($product_id, '_second_shipment_weight', $second_shipment_weight);
        }
    }
}

/**
 * Callback function create popup shipment Html from order detail page
 */
function generate_shipment_popup_callback()
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
                                            <?php
                                            global $MbtPackaging;
                                            $get_all_packages = $MbtPackaging->get_all_packages();
                                            $package_options = '<option value="0">Select Package</option>';
                                            if ($get_all_packages) {
                                                foreach ($get_all_packages as $key => $package) {
                                                    $package_options .= '<option  value="' . $package->id . '">' . $package->name . '</option>';
                                                }
                                            }
                                            echo '<label class="plan-head">Package Plan</label><select name="shipment_package_id" class="shipment_package_id">' . $package_options . '</select>';
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    $shipping_method_id = 0;
                                    foreach ($order->get_items('shipping') as $item_id => $item) {

                                        $shipping_method_id = $item->get_instance_id(); // The method ID
                                    }

                                    $shipmentLabelMethod = getShipmentCarrierLabel($shipping_method_id);
                                    $shipmentMethodAutoSelect = selectEasyPostMethodByOrderMethod($shipping_method_id, $shipmentLabelMethod);

                                    ?>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelMethod">Shipping Carrier</label>
                                        <?php $easypostcarrieraccount =  get_field('easypostcarrieraccount', 'option');
                                        if (is_array($easypostcarrieraccount) && count($easypostcarrieraccount) > 0) {
                                            echo '<select name="shipmentLabelMethod" id="shipmentLabelMethod" onchange="n__handleShippingMethod(this.value , \'' . $shipping_county . '\' ,  \'' . $shipmentMethodAutoSelect . '\' , 0);">';
                                            foreach ($easypostcarrieraccount as  $carrier) {
                                                if ($shipmentLabelMethod == $carrier['label']) {
                                                    echo '<option value="' . $carrier['label'] . '" selected="">' . $carrier['label'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $carrier['label'] . '">' . $carrier['label'] . '</option>';
                                                }
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelService">Shipping Product </label>
                                        <select id="shipmentLabelService" name="shipmentLabelService" class="form-control">
                                            <?php
                                            $_REQUEST['method'] = $shipmentLabelMethod;
                                            $_REQUEST['country'] = $shipping_county;
                                            $_REQUEST['shipmentMethod'] = $shipmentMethodAutoSelect;
                                            get_carrierServiceMethod_callback();
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="select" for="shipmentLabelSignatureConfirmationLabel">Signature Confirm? </label>
                                        <select id="shipmentLabelSignatureConfirmation" name="shipmentLabelSignatureConfirmation" class="form-control">
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
                                        <span class="print_label_shipment">Print postage</span>
                                    </label>
                                    <label for="package_label_shipment">
                                        <input name="package_label_shipment" id="package_label_shipment" type="checkbox" checked="" class="" value="yes">
                                        <span class="package_label_shipment">Packing list</span>
                                    </label>

                                    <label for="tracking_email_shipment">
                                        <input name="tracking_email" id="tracking_email_shipment" type="checkbox" checked="" class="" value="yes">
                                        <span class="tracking_email_shipment">Tracking Email</span>
                                    </label>
                                    <br />
                                </div>
                            </div>

                        </div>
                        <?php
                        if (isset($_REQUEST['shipment_id']) && $_REQUEST['shipment_id'] > 0) {
                            $productsHtml = '';
                            $shipmentDetail = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $_REQUEST['shipment_id']);
                            //                            echo '<pre>';
                            //                            print_r($shipmentDetail);
                            //                            echo '</pre>';
                            if (isset($shipmentDetail->productsWithQty) && $shipmentDetail->productsWithQty <> '') {
                                $productsHtml = '<h3>Shipped Products</h3><table class = "widefat">';
                                $productsHtml .= '<thead>';
                                $productsHtml .= '<tr>';
                                $productsHtml .= '<th class= "sbr-products-table-name">Order Number</th>';
                                $productsHtml .= '<th class= "sbr-products-table-name">Product</th>';
                                $productsHtml .= '<th class= "sbr-products-table-qty">Qty</th>';
                                $productsHtml .= '</thead>';
                                $productsHtml .= '<tbody>';
                                $shipItems = json_decode($shipmentDetail->productsWithQty, true);
                                foreach ($shipItems as $itemID => $shipItem) {
                                    $shipOrder_id = wc_get_order_id_by_order_item_id($itemID);
                                    //  $shipOrder_id = get_order_id_by_order_item_id($itemID);
                                    $shipProduct = $shipItem['product_id'];
                                    $shipProductQty = $shipItem['qty'];
                                    $productsHtml .= '<tr>';
                                    $productsHtml .= '<td>' . get_post_meta($shipOrder_id, 'order_number', true) . '</td>';
                                    $productsHtml .= '<td>' . get_the_title($shipProduct) . '</td>';
                                    if ($shipItem['type'] == 'composite') {
                                        if (isset($shipItem['fweight'])) {
                                            if ($shipProductQty == 1) {
                                                $productsHtml .= '<td>1st Shipment</td>';
                                            } else {
                                                $productsHtml .= '<td>2nd Shipment</td>';
                                            }
                                        } else {
                                            if ($shipItem['shipment'] == 1) {
                                                $productsHtml .= '<td>1st Shipment</td>';
                                            } else {
                                                $productsHtml .= '<td>2nd Shipment</td>';
                                            }
                                        }
                                    } else {
                                        $productsHtml .= '<td>' . $shipProductQty . '</td>';
                                    }
                                    $productsHtml .= '</tr>';
                                }
                                $productsHtml .= '</tbody>';
                                $productsHtml .= '</table><br/>';
                                echo $productsHtml;
                            }
                        }
                        ?>

                        <div class="row-body">

                            <?php
                            $customer_id = $order->get_user_id();
                            $matchingOrders = get_posts(array(
                                'numberposts' => -1,
                                //'fields'        => 'ids',
                                'post_type' => 'shop_order',
                                'post_status' => array('wc-processing', 'wc-partial_ship', 'wc-on-hold'),
                                'order' => 'ASC',
                                'exclude' => array($order_id),
                                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'key' => '_customer_user',
                                        'compare' => '=',
                                        'value' => $customer_id, #<-- just some value as a pre 3.9 bugfix (Codex)
                                    ),
                                )
                            ));

                            if ($matchingOrders) {
                                echo '<div class="shipping-on-same-address-button">';
                                echo '<h3 class="heading-section-address">Order(s) going to the same Customer/Address:<a href="javascript:;"  id="onGoingOrderBtn" class="hideContent">Show</a></h3>';
                                $order_statuses = array(
                                    'wc-pending' => _x('Pending payment', 'Order status', 'woocommerce'),
                                    'wc-processing' => _x('Processing', 'Order status', 'woocommerce'),
                                    'wc-on-hold' => _x('On hold', 'Order status', 'woocommerce'),
                                    'wc-partial_ship' => _x('Partial Ship', 'Order status', 'woocommerce'),
                                );
                                echo '<div class="onGoingOrder" style="display:none">';
                                foreach ($matchingOrders as $m_order) {
                                    $s_order_id = $m_order->ID;
                                    if ($order->get_id() == $s_order_id) {
                                        continue;
                                    }
                                    $orderSBRref = get_post_meta($s_order_id, 'order_number', true);
                                    $orderId_html = '<div class="suggestEntry ' . $m_order->post_status . '" id="matchOrder_' . $s_order_id . '">';
                                    $order_status = $order_statuses[$m_order->post_status];
                                    $orderId_html .= '<div class="suggestOrderItems"><button  onclick="addMatchingOrderShipment(' . $s_order_id . ')" class="button" type="button">' . $orderSBRref . ' - <span class="orderState ' . $m_order->post_status . '"> ' . $order_status . '</span></button></div>';
                                    $orderId_html .= '<div class="suggest_order_remove_field"><a href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></div>';
                                    $orderId_html .= '</div>';
                                    echo $orderId_html;
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                            <div class="tr-body" id="mbt_shipping_Item_listing">

                                <?php
                                if (isset($_REQUEST['shipment_id']) && $_REQUEST['shipment_id'] > 0) {
                                    $queryOrder = "SELECT  DISTINCT  order_id FROM  " . SB_SHIPMENT_ORDERS_TABLE;
                                    $queryOrder .= " WHERE shipment_id = '" . $_REQUEST['shipment_id'] . "' ";
                                    $orders = $wpdb->get_col($queryOrder);
                                    if ($orders) {
                                        foreach ($orders as $ord_id) {
                                            mbt_shipment_item_data_callback($ord_id);
                                        }
                                    }
                                } else {
                                    mbt_shipment_item_data_callback($order_id);
                                }
                                ?>

                            </div>

                            <div class="add-order-btn">
                                <button id="add_order_shipment_btn" onclick="addOrderShipment()" class="button" type="button">Add Order</button>
                            </div>

                        </div>

                        <div class="shipiing-setup custom-shipping-address">

                            <?php
                            $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ', ' . $shipping_address_1 . ' ' . $shipping_address_2 . ', ' . $shipping_city . ', ' . $shipping_state . ', ' . $shipping_postcode . ', ' . WC()->countries->countries[$shipping_county];
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
                                            $shippingDetails = $ep_add->shiptoFirstName . ' ' . $ep_add->shiptoLastName . ', ' . $ep_add->shiptoAddress . ', ' . $ep_add->shiptoAptNo . ', ' . $ep_add->shiptoCity . ', ' . $ep_add->shiptoState . ', ' . $ep_add->shiptoPostalCode . ', ' . WC()->countries->countries[$shipping_county];
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
                                            <input type="text" name="phone" class="form-control" value="<?php echo $shipping_phone; ?>" />
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
                            <?php $orderPackagingNote = get_post_meta($order_id, '_order_packaging_note', true); ?>
                            <div class="shipiing-setup">
                                <h3>Add Packaging Note</h3>
                                <div class="shipiing-setup add-packagng-notes">
                                    <textarea name="packaging_order_note" rows="4" cols="100" style="width: 100%;"><?php echo $orderPackagingNote; ?></textarea>
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
        <style>
            #shipment_response .alert {
                color: red !important;
                padding: 20px;
                background-color: #f443363d;
                color: #fff;
                margin-bottom: 15px;
                border: 1px solid #f44336;
                max-width: 440px;
                margin-left: 30px;
                margin-top: 7px;
            }

            #shipment_response .closebtn {
                color: red !important;
            }

            #shipment_response .alert ul li {
                border-bottom: 1px dashed #ffffffc7;
                padding-bottom: 4px;
            }
        </style>
        <script>
            load_packages();
            //shipmentContent('<?php //cho $shipping_county; 
                                ?>', '<?php //echo $shipmentMethodAutoSelect; 
                                        ?>');

            jQuery('body').on('click', '#onGoingOrderBtn', function(e) {
                let anchorText = jQuery(this).html();
                if (anchorText === 'Show') {
                    jQuery(this).html('Hide');
                    jQuery(this).removeClass('show').addClass('hide');
                    jQuery('body').find('.onGoingOrder').show();
                } else {
                    jQuery(this).html('Show');
                    jQuery('body').find('.onGoingOrder').hide();
                    jQuery(this).removeClass('hide').addClass('show');
                }
            });
        </script>

<?php
    endif;
    die;
}


/**
 * Callback function create popup shipment from order detail page
 */

function mbt_createShipmentWithPackages_callback()
{
    $gdInfo = gd_info();

    $response = array();
    //  echo 'Data: <pre>' .print_r($_REQUEST,true). '</pre>';die;
    //ASSEMBLE OUR INSERT ARRAY
    $insertArray = array();

    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
    global $MbtPackaging, $wpdb;

    $order_id = $_REQUEST['order_id'];
    $order = wc_get_order($order_id);

    if (isset($_REQUEST['is_shipping_address_changed']) && $_REQUEST['is_shipping_address_changed'] == 'old') {

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
    } else if (isset($_REQUEST['is_shipping_address_changed']) && $_REQUEST['is_shipping_address_changed'] == 'new') {
        $fname = isset($_REQUEST['fname']) ? $_REQUEST['fname'] : '';
        $lname = isset($_REQUEST['lname']) ? $_REQUEST['lname'] : '';
        $address1 = isset($_REQUEST['address_1']) ? $_REQUEST['address_1'] : '';
        $address2 = isset($_REQUEST['address_2']) ? $_REQUEST['address_2'] : '';
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : '';
        $state = isset($_REQUEST['shipment_state']) ? $_REQUEST['shipment_state'] : '';
        $country = isset($_REQUEST['shipment_country']) ? $_REQUEST['shipment_country'] : '';
        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
        $company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';
    } else {
        $shipment_detail = get_shimpemnt_id_by_shipment($_REQUEST['is_shipping_address_changed']);

        $fname = $shipment_detail->shiptoFirstName;
        $lname = $shipment_detail->shiptoLastName;
        $address1 = $shipment_detail->shiptoAddress;
        $address2 = $shipment_detail->shiptoAptNo;
        $company = $shipment_detail->shiptoCompany;
        $email = $shipment_detail->shiptoEmail;
        $city = $shipment_detail->shiptoCity;
        $zipcode = $shipment_detail->shiptoPostalCode;
        $state = $shipment_detail->shiptoState;
        $country = $shipment_detail->shiptoCountry;
        $phone = $shipment_detail->shiptoPhone;
    }


    $error_log = array();
    //address requireements
    if (@trim($fname) == "") {
        $error_log[] = "The shipping first name is required.";
    }
    if (@trim($lname) == "") {
        $error_log[] = "The shipping last name is required.";
    }
    if (@trim($phone) == "") {
        $error_log[] = "The phone number is required.";
    }
    if (@trim($email) == "") {
        $error_log[] = "The email is required.";
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

    $shipment_package_id = isset($_REQUEST['shipment_package_id']) ? $_REQUEST['shipment_package_id'] : 0;
    if ($shipment_package_id) {
        $package_info = $MbtPackaging->get_package_info_for_shipping($shipment_package_id);

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
    }

    // if(@trim($_POST['orderItem']) == "")
    // {	
    //     $error_log[] =  "No product found for shipment";
    // }
    //make sure a method and service were passed
    if (@trim($_POST['shipmentLabelMethod']) == "") {
        $error_log[] = "The shipping carrier is missing.";
    }
    if (@trim($_POST['shipmentLabelService']) == "") {
        $error_log[] = "The shipping service is missing.";
    }
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

    if (@trim($_REQUEST['shipmentLabelShipDate']) == "") {
        $error_log[] = "The shipping label date is required.";
    }
    if (@trim($_REQUEST['shipment_package_id']) == "" || @trim($_REQUEST['shipment_package_id']) == 0) {
        $error_log[] = "The packing plan is required.";
    }

    //if international we require the contents
    if ($country != "US") {
        if (@trim($_REQUEST['shiptoContentsType']) == "") {
            $error_log[] = "The shipment content type is missing (required for international shipments).";
        }
        if (@trim($_REQUEST['shiptoTariffCode']) == "") {
            //  $error_log[] = "The shipment content tariff code is missing (required for international shipments).";
        }
        /*
          if(@trim($_REQUEST['shiptoContentsDescription']) == "")
          {
          $error_log[] =  "The shipment content description is missing (required for international shipments).";
          }
          if(@trim($_REQUEST['shiptoContentsManufacturer']) == "")
          {
          $error_log[] =  "The shipment content manufacturer is missing (required for international shipments).";
          }
         */
    }


    if (count($error_log) > 0) {
        $htmlError = '<ul class="error-list">';
        foreach ($error_log as $error_item) {
            $htmlError .= '<li>' . $error_item . '</li>';
        }
        $htmlError .= '</ul>';
        $response = array(
            'code' => 'error',
            'msg' => $htmlError
        );
        echo json_encode($response);
        die;
    }

    $insertArray['userId'] = get_current_user_id();
    $insertArray['shipmentMethod'] = @$_POST['shipmentLabelMethod'];
    $insertArray['shipmentNotes'] = @$_POST['packaging_order_note'];
    $insertArray['shipmentDate'] = date("Y-m-d H:i:s");
    $insertArray['batchIdShipment'] = 0;

    $insertArray['packageId'] = @$_POST['shipment_package_id'];
    //$insertArray['shiptoCompany'] = @trim($_POST['shiptoCompany']);
    $insertArray['shiptoFirstName'] = $fname;
    $insertArray['shiptoLastName'] = $lname;
    $insertArray['shiptoAddress'] = $address1;
    $insertArray['shiptoAptNo'] = $address2;
    $insertArray['shiptoCompany'] = $company;
    $insertArray['shiptoCountry'] = $country;
    $insertArray['shiptoCity'] = $city;
    $insertArray['shiptoState'] = $state;
    $insertArray['shiptoPostalCode'] = $zipcode;
    $insertArray['shiptoPhone'] = $phone;
    $insertArray['shiptoEmail'] = $email;
    if (@trim($_POST['shiptoContentsType'])) {
        $insertArray['shiptoContentsType'] = @trim($_POST['shiptoContentsType']);
    } else {
        $insertArray['shiptoContentsType'] = 'merchandise';
    }
    $insertArray['shiptoTariffCode'] = '850.98.000';
    //$insertArray['shiptoTariffCode'] = @trim($_POST['shiptoTariffCode']);
    /*   $insertArray['shiptoContentsDescription'] = @trim($_POST['shiptoContentsDescription']);
      $insertArray['shiptoContentsManufacturer'] = @trim($_POST['shiptoContentsManufacturer']);
     */
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

    $customs_items = array();
    $customs_info = false;
    $curItemsArray = array();
    $updatedOrderItem = array();
    $productDuplicate_array = array();
    $readyToShipOrderItem = $_REQUEST['orderItem'];
    $shipmentCounter = 1;
    $allShipProductsWeight = 0;
    $allOrderIds = array();
    $trayData = array();
    $validationInCompleteOrder = true;
    if (is_array($readyToShipOrderItem) && count($readyToShipOrderItem) > 0) {
        foreach ($readyToShipOrderItem as $item_id => $productDetail) {
            if (isset($productDetail['qty']) && $productDetail['qty'] > 0) {

                $updatedOrderItem[$item_id] = $productDetail;

                $product_id_val = $productDetail['product_id'];
                $product_qty_val = $productDetail['qty'];
                $product_order_id = $productDetail['order_id'];


                if (validateShipmentLogs($product_order_id, $item_id, $product_id_val)) {
                } else {
                    $validationInCompleteOrder = false;
                    break;
                }

                $productShipmentType = get_post_meta($product_id_val, 'three_way_ship_product', true);
                if ($productShipmentType == 'yes') {
                    $product_price_val = 20;
                } else {
                    $product_price_val = $productDetail['price'];
                }

                $item_shipment = isset($productDetail['shipment']) ? $productDetail['shipment'] : 1;
                if (isset($productDetail['shipment']) && $shipmentCounter == 1) {
                    $shipmentCounter = $item_shipment;
                }


                if ($productShipmentType == 'yes') {
                    $tray_q = "SELECT tray_number FROM  " . SB_ORDER_TABLE;
                    $tray_q .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id_val;
                    $tray_query = $wpdb->get_var($tray_q);
                    if (@$tray_query) {
                        $trayData[@$tray_query] = @$tray_query;
                    }
                }
                $product_weight = $productDetail['weight'];
                /*
                  if(isset($productDetail['shipment'])){
                  if($productDetail['shipment'] == 2){
                  $product_price_val = 0;
                  }
                  }
                 */
                $orderSBRref = get_post_meta($product_order_id, 'order_number', true);
                $allOrderIds[$product_order_id] = $orderSBRref;
                if (isset($productDuplicate_array[$product_id_val])) {

                    $productPreviousQty = $productDuplicate_array[$product_id_val]['qty'] + $product_qty_val;
                    $productPreviousWeight = $productDuplicate_array[$product_id_val]['weight'] + ($product_qty_val * $product_weight);
                    $productPreviousPrice = $productDuplicate_array[$product_id_val]['price'] + ($product_qty_val * $product_price_val);

                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $productPreviousQty,
                        'order_id' => $product_order_id,
                        'price' => $productPreviousPrice,
                        'weight' => $productPreviousWeight
                    );
                } else {
                    /*
                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $product_qty_val,
                        'order_id' => $product_order_id,
                        'price' => ($product_qty_val * $product_price_val),
                        'weight' => ($product_qty_val * $product_weight),
                    );
                    */
                    if($product_price_val ==''){
                        $product_price_val = 0;
                       }
                    $weight = (is_numeric($product_weight) ? (float)$product_weight : 0.0);
                   
                    $productDuplicate_array[$product_id_val] = array(
                        'qty' => $product_qty_val,
                        'order_id' => $product_order_id,
                        'price' => ((int)$product_qty_val * (int)$product_price_val),
                        'weight' => ((int)$product_qty_val * $weight),
                    );
                }
            }
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => 'No product found for shipment'
        );
        echo json_encode($response);
        die;
    }
    if ($validationInCompleteOrder == false) {
        $response = array(
            'products' => '<ul class="print_product" ><li>---</li></ul>',
            'code' => 'error',
            'errorCode' => 1,
            'msg' => 'The items in the order are not in a state that is suitable for generating the shipment. Please check the order item states.'
        );
        echo json_encode($response);
        die;
    }
    if (count($updatedOrderItem) < 1) {
        $response = array(
            'code' => 'error',
            'msg' => 'No product qty found to shipment'
        );
        echo json_encode($response);
        die;
    }
    // echo 'Data: <pre>' .print_r($updatedOrderItem,true). '</pre>';die;
    //NOW CREATE OUR SHIPMENT
    /*     * for Test Case */
    $shipmentOptions = array(
        'label_date' => $labelDate,
        'currency' => 'USD',
        //  'delivery_confirmation' => @trim($_POST['shipmentLabelSignatureConfirmation']),
        'saturday_delivery' => $insertArray['easyPostLabelSaturdayDelivery'],
    );
    if ($shipmentCounter == 2) {
        $shipmentOptions['print_custom_1'] = 'Second Shipment';
    } else {
        $shipmentOptions['print_custom_1'] = 'First Shipment';
    }
    if (count($trayData) > 0) {
        $shipmentOptions['print_custom_2'] = "T: " . implode(", ", $trayData);
    }
    $shipping_method_id = 0;
    foreach ($order->get_items('shipping') as $item_id => $item) {
        $shipping_method_id = $item->get_instance_id(); // The method ID
    }

    if ($shipping_method_id == 24) {
        $response = array(
            'code' => 'error',
            'msg' => "Order shipping method is Local pickup."
        );
        echo json_encode($response);
        die;
    }

    if (isset($_POST['shipmentLabelSignatureConfirmation']) && $_POST['shipmentLabelSignatureConfirmation'] <> '') {
        $shipmentOptions['delivery_confirmation'] = 'SIGNATURE';
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
            $tfCode = get_field('shiptoTariffCode', $productId);
            if(empty($tfCode)){
                $tfCode = '850.98.000';
            }
            $curItemArray = array(
                "description" => strip_tags($product_title),
                "quantity" => $productContent['qty'],
                "weight" => @round(@trim($productContent['weight']), 2),
                "value" => @round(@trim($productContent['price']), 2),
                "currency" => "USD",
                "origin_country" => 'US',
                "hs_tariff_number" => $tfCode
            );

            $allShipProductsWeight = $allShipProductsWeight + @round(@trim($productContent['weight']), 2);
            $allShipProductsValue = $allShipProductsValue + @round(@trim($productContent['price']), 2);
            // if ($country != "US") {
            array_push($curItemsArray, $client->customsItem->create($curItemArray));
            //}
        }
        $insertArray['shiptoContentsValue'] = @trim($allShipProductsValue);
    } catch (Exception $e) {

        $response = array(
            'code' => 'error',
            'msg' => "An error was returned from our Custom Item service, please show this to the administrator: " . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
        );
        echo json_encode($response);
        die;
    }
    try {

        $customs_info =  $client->customsInfo->create(array(
            "eel_pfc" => 'NOEEI 30.37(a)',
            "customs_certify" => true,
            "customs_signer" => 'Salman Shah',
            "contents_type" => $insertArray['shiptoContentsType'],
            "contents_explanation" => 'Dental Care Products',
            "restriction_type" => 'none',
            "non_delivery_option" => 'return',
            "customs_items" => $curItemsArray
        ));
    } catch (Exception $e) {

        $response = array(
            'code' => 'error',
            'msg' => "An error was returned from our Custom Info service, please show this to the administrator: " . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
        );
        echo json_encode($response);
        die;
    }

    /* Valide Zip Codes for order */
    if (isset($_REQUEST['is_shipping_address_changed']) && $_REQUEST['is_shipping_address_changed'] == 'old') {
        if ($allOrderIds) {
            $order_ids_for_zipcode = array();
            foreach ($allOrderIds as $order_key => $order_sbr_number) {
                $order_ids_for_zipcode[] = $order_key;
            }
            if (count($order_ids_for_zipcode) > 1) {

                if (check_unique_orders_by_zipcode($order_ids_for_zipcode, $insertArray['shiptoPostalCode']) == false) {
                    $response = array(
                        'code' => 'error',
                        'msg' => "The orders in this shipment do not have the same address. Please specify a new shipping address or select only those orders that are going to the same address."
                    );
                    echo json_encode($response);
                    die;
                }
            }
        }
    }
    $errorRateMessage = '';
    try {

        $orderSBRref = get_post_meta($order_id, 'order_number', true);
        if ($orderSBRref == "") {
            $orderSBRref = $order_id;
        }
        /*
          $orderSBRref = get_post_meta($order_id , 'order_number' , true);
          if($orderSBRref == ""){
          $orderSBRref = $order_id;
          }

          $dataaaaa =   implode(",",$allOrderIds);
          echo 'Data: <pre>' .print_r($allOrderIds,true). '</pre>';
          echo 'Data: <pre>' .print_r($dataaaaa,true). '</pre>';
          die;
         */
        //   $insertArray['order_id'] = $order_id;
        //   $insertArray['reference'] = $orderSBRref;
        $insertArray['packageLength'] = @trim($length);
        $insertArray['packageWidth'] = @trim($width);
        $insertArray['packageHeight'] = @trim($height);
        $insertArray['packageWeight'] = @trim(($parcelProductsWeight + $allShipProductsWeight));

        $shipmentData = array(
            'options' => $shipmentOptions,
            'is_return' => false,
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
            "customs_info" => $customs_info
            //'service' => $_REQUEST['shipmentLabelService'],
        );

        if (WP_ENV == 'production') {
            $shipmentData['carrier_accounts'] = get_easypostCarrierAccounts($insertArray['shipmentMethod']);
        }

        $shipment = $client->shipment->create($shipmentData);
        $errorRateMessage = isset($shipment->messages[0]->message) ? $shipment->messages[0]->message : '';
    } catch (Exception $e) {

        $response = array(
            'code' => 'error',
            'msg' => "An error was returned from our shipment generation service, please show this to the administrator:<br/><br/>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
        );
        echo json_encode($response);
        die;
    }
    // echo '<pre>';
    // print_r($shipment);
    // echo '</pre>';
    // die;
    //if we have a successful shipment
    if (@$shipment->id != "") {
        //by default, grab the lowest rate of the selected class
        $selectedRate = false;
        try {
            // if ($insertArray['shipmentMethod'] == "USPS") {
            //$selectedRate = $shipment->lowest_rate($insertArray['shipmentMethod']);
            $selectedRate = false;
            //}
        } catch (Exception $e) {
            $response = array(
                'code' => 'error',
                'msg' => "It appears that the label generation service did not find any rates.  This normally occurs due to an address error - please check to make sure the address for this customer is correct and try again.  Below is the error message from our label generation service:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>" . '<br/>' . $errorRateMessage,
            );
            echo json_encode($response);
            die;
        }

        //loop through the rates to select our rate
        $flagSelected = false;
        if (@count($shipment->rates) > 0) {
            for ($i = 0; $i < count($shipment->rates); $i++) {
                //match our rate to the service
                if ($shipment->rates[$i]->service == @trim($_POST['shipmentLabelService'])) {
                    $flagSelected = true;
                    $selectedRate = $shipment->rates[$i];
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

        //buy the shipment
        try {
            // $shipment->buy(array(
            //     'rate' => $selectedRate
            //     //'insurance'	=>  0.00
            // ));
            $boughtShipment =$client->shipment->buy($shipment->id, $shipment->lowestRate());
        } catch (Exception $e) {
            $response = array(
                'code' => 'error',
                'msg' => "An error was returned from our buy shipment service, please show this to the administrator:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>" . '<br/>' . $errorRateMessage,
            );
            echo json_encode($response);
            die();
        }


        //set our insert values
       // $shipment->label(array("file_format" => "pdf"));
       $shipmentWithLabel =$client->shipment->label( $shipment->id,array("file_format" => "pdf"));
        // echo 'Data: <pre>' .print_r($shipmentWithLabel,true). '</pre>';
        // die();
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
        $downloadSuccess = false;
        if ($downloadResult) {


            if (isset($_REQUEST['tracking_email']) && $_REQUEST['tracking_email'] == 'yes') {
                $insertArray['trackingEmail'] = 1;
                WC()->mailer()->emails['WC_Shipment_Order_Email']->trigger($order_id);
            } else {
                $insertArray['trackingEmail'] = 0;
            }


            $MbtPackaging->manage_package_inventory($shipment_package_id);
            $logs_dir = get_home_path() . 'downloads/labels/';
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
                    //     mbt_printer_receipt($file_path, );
                    mbt_printer_receipt($file_path, $insertArray['easyPostLabelSize']);
                    $insertArray['shipmentLabelPrint'] = 1;
                } else {
                    $insertArray['shipmentLabelPrint'] = 0;
                }
            }
        } else {
            $response = array(
                'code' => 'error',
                'msg' => "We were unsucessful in generating the return label for print.  Please try again or contact the administrator.",
            );
            echo json_encode($response);
            die();
        }
        $insertArray['productsWithQty'] = json_encode($updatedOrderItem);
        //require_once("dompdf/autoload.php");
        require_once("dompdfkami/autoload.inc.php");
        if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {
            $insertArray['packageLabelPrint'] = 1;
        } else {
            $insertArray['packageLabelPrint'] = 0;
        }
        $shipment_db_id = sb_easypost_shipment($insertArray);
        if ($shipment_db_id) {

            foreach ($allOrderIds as $ord_id => $ord_number) {
                $order_shipment = array(
                    'shipment_id' => $shipment_db_id,
                    'order_id' => $ord_id,
                    'order_number' => $ord_number,
                );
                sb_easypost_shipment_orders($order_shipment);

                //Create Log    
                if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
                    //    $packagingNote = '<b>Packaging Note</> <br/><b>Tracing ID: '.$tracking_number.'</b><br/>'.$_REQUEST['packaging_order_note'];
                    $packagingNote = '<div class="note_content">
                                        <p><strong>Packaging Note</strong></p>
                                        <p><strong>Tracing ID: </strong> ' . $tracking_number . '</p>
                                        <p><strong>Message: </strong>' . $_REQUEST['packaging_order_note'] . '</p>
                                        <p><strong>Status: <span style="color: green">Sent</span></strong></p>
                                    </div>';
                    create_woo_order_note($packagingNote, $ord_id, true);
                }
                $packaging_note = '';
                if (isset($_REQUEST['packaging_order_note']) && $_REQUEST['packaging_order_note'] <> '' && trim($_REQUEST['packaging_order_note'])) {
                    $packaging_note = $_REQUEST['packaging_order_note'];
                }

                $packing_array = array(
                    'order_id' => $ord_id,
                    'orderItems' => $updatedOrderItem,
                    'packaging_note' => $packaging_note,
                    'shipment_package_id' => $shipment_package_id,
                    //'batchID' => 0,
                );
                $returnResponsePackaging = shipmentPackageList($packing_array);

                // $returnResponsePackaging = shipmentPackageList($ord_id, $updatedOrderItem, $packaging_note, $shipment_package_id);
                // instantiate and use the dompdf class
                $dompdf = new Dompdf();
                $dompdf->loadHtml($returnResponsePackaging);
                $logs_dir = get_home_path() . '/downloads/packages/';
                if (!is_dir($logs_dir)) {
                    mkdir($logs_dir, 0755, true);
                }
                $dompdf->render();
                $output = $dompdf->output();

                $packagingFileName = $tracking_number . '_' . $ord_id . '.pdf';

                file_put_contents($logs_dir . $packagingFileName, $output);
                if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {

                    //successful drop of the file
                    $packaging_file_path = $logs_dir . $packagingFileName;
                    mbt_printer_receipt($packaging_file_path, '4x6');
                }
            }
            $shipStatus = false;

            foreach ($updatedOrderItem as $item_id => $data) {
                $product_id = $data['product_id'];
                $order_id = $data['order_id'];
                $order = wc_get_order($order_id);
                $event_data = array(
                    "order_id" => $order_id,
                    "item_id" => $item_id,
                    "shipment_id" => $shipment_db_id,
                    "product_id" => $product_id,
                    "event_id" => 2,
                );
                sb_create_log($event_data);

                $orderItem_info = $order->get_item($item_id);
                $item_quantity = $orderItem_info->get_quantity(); // Get the item quantity
                addShipmentHistory($item_id, $data['qty'], $data['type'], $tracking_number, date("Y-m-d", strtotime(@trim($_REQUEST['shipping_date']))));
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
                $order_new_status = mbt_addOrderStatus($order_id);
                if ($_REQUEST['order_id'] == $order_id) {
                    $shipStatus = $order_new_status;
                }
            }
            $response = array(
                'code' => 'success',
                'status' => $shipStatus,
                'source' => isset($_REQUEST['source']) ? $_REQUEST['source'] : 'order',
                'msg' => 'Shipment created successfully. Tracking ID# ' . $tracking_number
            );
            // print_r($response);
            // die();
            echo json_encode($response);
            die();
        } else {
            $response = array(
                'code' => 'error',
                'msg' => "An error occured while trying to insert the shipment.",
            );
            echo json_encode($response);
            die();
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => "We were unsucessful in generating the return label.  Please try again or contact the administrator.",
        );
        echo json_encode($response);
        die();
    }


    //echo 'Data: <pre>' .print_r($insertArray,true). '</pre>';die;
    die;
}
/**
 * AJAX callback to validate the order zip code.
 */
add_action('wp_ajax_validateOrderZipCode', 'validateOrderZipCode_callback');
/**
 * Callback function for validating the order zip code.
 */
function validateOrderZipCode_callback()
{

    if ($flag == false) {
        $response = array(
            'code' => 'error',
            'msg' => "Selected Order Shipping Address not same."
        );
        echo json_encode($response);
    } else {
        $response = array(
            'code' => 'success',
            'msg' => "Order on same addresses"
        );
        echo json_encode($response);
    }
    die;
}
/**
 * Get the remaining quantity of order items for a given order.
 *
 * @param int $order_id The ID of the order.
 * @return array|false An array of remaining quantities for each product or false if no remaining quantity.
 */
function getRemainOrderItemsQty($order_id)
{
    $order = wc_get_order($order_id);
    $flagOrderStatus = false;
    $productQty = array();
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
                if (isset($productQty[$item->get_product_id()])) {
                    $productQty[$item->get_product_id()] = $productQty[$item->get_product_id()] + $getRemainingQuantity;
                } else {
                    $productQty[$item->get_product_id()] = $getRemainingQuantity;
                }
            }


            if ($getRemainingQuantity) {
                $flagOrderStatus = true;
            }
        }
    }
    if ($flagOrderStatus) {
        return $productQty;
    } else {
        return false;
    }
}
/**
 * Insert a record into the shipment orders table.
 *
 * @param array $param Parameters for the shipment order.
 * @return int|false The inserted record ID or false on failure.
 */
function sb_easypost_shipment_orders($param = array())
{
    global $wpdb;

    $data = array(
        "shipment_id" => isset($param['shipment_id']) ? $param['shipment_id'] : 0,
        "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "order_number" => isset($param['order_number']) ? $param['order_number'] : '',
    );
    $wpdb->insert(SB_SHIPMENT_ORDERS_TABLE, $data);
    return $wpdb->insert_id;
}
/**
 * Insert a record into the easypost shipment table.
 *
 * @param array $param Parameters for the easypost shipment.
 * @return int|false The inserted record ID or false on failure.
 */
function sb_easypost_shipment($param = array())
{
    global $wpdb;

    $data = array(
        "userId" => isset($param['userId']) ? $param['userId'] : 0,
        //   "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "reference" => isset($param['reference']) ? $param['reference'] : '',
        "easyPostLabelCarrier" => isset($param['easyPostLabelCarrier']) ? $param['easyPostLabelCarrier'] : '',
        "easyPostLabelService" => isset($param['easyPostLabelService']) ? $param['easyPostLabelService'] : '',
        "easyPostShipmentId" => isset($param['easyPostShipmentId']) ? $param['easyPostShipmentId'] : 0,
        "easyPostLabelSaturdayDelivery" => isset($param['easyPostLabelSaturdayDelivery']) ? $param['easyPostLabelSaturdayDelivery'] : 0,
        "easyPostLabelDate" => isset($param['easyPostLabelDate']) ? $param['easyPostLabelDate'] : '',
        "shiptoContentsType" => isset($param['shiptoContentsType']) ? $param['shiptoContentsType'] : '',
        "trackingCode" => isset($param['trackingCode']) ? $param['trackingCode'] : 0,
        "batchIdShipment" => isset($param['batchIdShipment']) ? $param['batchIdShipment'] : 0,
        "shiptoTariffCode" => isset($param['shiptoTariffCode']) ? $param['shiptoTariffCode'] : 0,
        "shiptoContentsValue" => isset($param['shiptoContentsValue']) ? $param['shiptoContentsValue'] : 0,
        "shipmentCost" => isset($param['shipmentCost']) ? $param['shipmentCost'] : 0,
        "shipmentStatus" => isset($param['shipmentStatus']) ? $param['shipmentStatus'] : '',
        "estDeliveryDate" => isset($param['estDeliveryDate']) ? $param['estDeliveryDate'] : '',
        "actualDeliveryDate" => isset($param['actualDeliveryDate']) ? $param['actualDeliveryDate'] : '',
        "productsWithQty" => isset($param['productsWithQty']) ? $param['productsWithQty'] : 0,
        "packageId" => isset($param['packageId']) ? $param['packageId'] : 0,
        "packageLength" => isset($param['packageLength']) ? $param['packageLength'] : 0,
        "packageWidth" => isset($param['packageWidth']) ? $param['packageWidth'] : 0,
        "packageHeight" => isset($param['packageHeight']) ? $param['packageHeight'] : 0,
        "packageWeight" => isset($param['packageWeight']) ? $param['packageWeight'] : 0,
        "shiptoFirstName" => isset($param['shiptoFirstName']) ? $param['shiptoFirstName'] : '',
        "shiptoLastName" => isset($param['shiptoLastName']) ? $param['shiptoLastName'] : '',
        "shiptoAddress" => isset($param['shiptoAddress']) ? $param['shiptoAddress'] : '',
        "shiptoAptNo" => isset($param['shiptoAptNo']) ? $param['shiptoAptNo'] : '',
        "shiptoCompany" => isset($param['shiptoCompany']) ? $param['shiptoCompany'] : '',
        "shiptoCity" => isset($param['shiptoCity']) ? $param['shiptoCity'] : '',
        "shiptoPostalCode" => isset($param['shiptoPostalCode']) ? $param['shiptoPostalCode'] : 0,
        "shiptoState" => isset($param['shiptoState']) ? $param['shiptoState'] : '',
        "shiptoCountry" => isset($param['shiptoCountry']) ? $param['shiptoCountry'] : '',
        "shiptoPhone" => isset($param['shiptoPhone']) ? $param['shiptoPhone'] : '',
        "shiptoEmail" => isset($param['shiptoEmail']) ? $param['shiptoEmail'] : '',
        "shipmentDate" => isset($param['shipmentDate']) ? $param['shipmentDate'] : '',
        "easyPostLabelRateId" => isset($param['easyPostLabelRateId']) ? $param['easyPostLabelRateId'] : 0,
        "easyPostShipmentTrackingUrl" => isset($param['easyPostShipmentTrackingUrl']) ? $param['easyPostShipmentTrackingUrl'] : '',
        "easyPostLabelSize" => isset($param['easyPostLabelSize']) ? $param['easyPostLabelSize'] : '',
        "easyPostLabelPNG" => isset($param['easyPostLabelPNG']) ? $param['easyPostLabelPNG'] : '',
        "easyPostLabelPDF" => isset($param['easyPostLabelPDF']) ? $param['easyPostLabelPDF'] : '',
        "shipmentNotes" => isset($param['shipmentNotes']) ? $param['shipmentNotes'] : '',
        "packagingParam" => isset($param['packagingParam']) ? $param['packagingParam'] : '',
        "trackingEmail" => isset($param['trackingEmail']) ? $param['trackingEmail'] : 0,
        "packageLabelPrint" => isset($param['packageLabelPrint']) ? $param['packageLabelPrint'] : 0,
        "shipmentLabelPrint" => isset($param['shipmentLabelPrint']) ? $param['shipmentLabelPrint'] : 0,
        //   "created_date" => date("Y-m-d h:i:sa"),
    );
    $wpdb->insert(SB_EASYPOST_TABLE, $data);
    return $wpdb->insert_id;
}


/**
 * Function hooked to 'wp_loaded' to handle Impact conversion tracking.
 */
add_action('wp_loaded', 'sbrimpact_function');
function sbrimpact_function()
{
    if (isset($_REQUEST['sbrimpact'])) {

        $order_id = $_REQUEST['sbrimpact'];
        $irClickId = get_post_meta($order_id, 'irclickid', true);
        if ($irClickId != '') {
            $order = wc_get_order($order_id);
            // Now you have access to (see above)...
            if ($order) {
                // Check if the customer has previous orders excluding the current order
                $customerOrders = wc_get_orders(array(
                    'customer' => $order->get_customer_id(),
                    'exclude' => array($order->get_id()), // Exclude the current order
                    'limit' => 1,
                    'status' => array('processing', 'completed', 'on-hold', 'shipped', 'partial_ship'), // Add more statuses as needed
                ));
                $customerStatus = (empty($customerOrders)) ? 'NEW' : 'OLD';
                $itemCounter = 1;
                $hashedEmail = hash('sha256', $order->get_billing_email());
                $orderData  = array(
                    'EventTypeId' => 35290,
                    'CampaignId' => 18348,
                    'ClickId' => $irClickId,
                    'EventDate' => 'NOW',
                    'OrderId' => $order_id,
                    'OrderDiscount' => $order->get_discount_total(),
                    'CustomerPostCode' => $order->get_billing_postcode(),
                    'CurrencyCode' => 'USD',
                    'CustomerStatus' => $customerStatus,
                    'IpAddress' => $order->get_customer_ip_address(),
                    'CustomerId' => $order->get_customer_id(),
                    'OrderPromoCode' =>    implode(', ', $order->get_coupon_codes()),
                    'CustomerEmail' => $hashedEmail,
                );

                foreach ($order->get_items() as $item_id => $item) {
                    $orderData['ItemSku' . $itemCounter] =     $item->get_product()->get_sku();
                    $orderData['ItemName' . $itemCounter] =     $item->get_name();
                    $orderData['ItemQuantity' . $itemCounter] =    $item->get_quantity();
                    $orderData['ItemPrice' . $itemCounter] =    $item->get_total();
                    $itemCounter++;
                }

                // Replace these placeholders with your actual values
                $accountSid = 'IRT5rs8NSrun3959030Unv9zMCYRQfHDW1';
                $authToken = 'X2hVQk-CSVbnWLExBLFztLCX7L.FUvRX';




                // Initialize cURL session
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, "https://api.impact.com/Advertisers/{$accountSid}/Conversions");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($orderData));

                // Execute the cURL request
                $response = curl_exec($ch);

                // Check for cURL errors
                if (curl_errno($ch)) {
                    echo 'cURL error: ' . curl_error($ch);
                }

                // Close cURL session
                curl_close($ch);

                // Handle the response as needed
                echo $response;
                echo '<pre>';
                print_r($orderData);
                echo '</pre>';
                die;
            }
        }
        die;
    }
}
