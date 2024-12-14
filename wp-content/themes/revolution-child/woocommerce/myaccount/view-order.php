<?php

/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */
defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
global $wpdb;
?>
<div id="SBRCustomerDashboard">
    <section class="page-container">

        <div id="main">
            <div class="container orderDetailContainer desktopNoPaddingSides">
                <?php 
                $shine = get_post_meta($order->ID, '_shineSubcId', true);
                if (!wp_is_mobile() || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {                     
                    ?>
                    <div class="deskTopOnly orderDetail <?php echo ($shine?'shineSubscribed shine-subs-detail':'');?>">

                        <div class="d-flex align-items-center menuParentRowHeading orderDetailFile borderBottomLine orderDetailsPage">
                            <div class="pageHeading_sec">
                                <span><span class="text-blue">OrderS</span>Track, Return, or buy items again.</span>
                            </div>

                        </div>

                        <div class="d-flex align-items-center orderDetailFile breadCrumbsListWrapper justify-content-between">
                            <div class="crumbTrail">
                                <ul class="breadcrumbItem">
                                    <li><a href="<?php echo home_url('my-account/orders'); ?>">All Orders</a></li>
                                    <li><a href="javascript:void(0);"><?php echo $order->get_order_number(); ?></a></li>

                                </ul>
                            </div>
                            <div class="button text-right goBackDetailPage">
                                <!-- <a href="/my-account/orders/" class="buttonDefault smallRipple ripple-button " onclick="">Go Back</a> -->
                                <a href="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>" class="buttonDefault smallRipple ripple-button">Go Back</a>
                            </div>

                        </div>


                        <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop hidden">
                            <li class="nav-item">
                                <a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">ALL ORDERS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">BUY AGAIN</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <h3 class="orderHeading"><?php echo $order->get_order_number(); ?> </h3>
                                <div class="orderPlaceInfo">
                                    <p class="placeOrderText">was placed on <span class="text-blue"><?php echo wc_format_datetime($order->get_date_created()); ?></span> and is currently in <span class="text-blue">[<?php echo ucwords(wc_get_order_status_name($order->get_status())); ?>] </span>status</span></p>
                                    <!-- <a href="javascript:;" class="backtoDash"><i class="fa fa-chevron-left" aria-hidden="true"></i>Back to Orders</a> -->
                                </div>




                                <table class="table table-bordered orderDetailTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col" class="statusThTable text-center">Status</th>
                                            <th scope="col" class="totalThTable ">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($order->get_items() as $item_id => $item) {

                                            if (wc_cp_get_composited_order_item_container($item, $order)) {
                                                continue;
                                            } else {
                                                $product_id = $item->get_product_id();
                                                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                                                $product = $item->get_product();
                                                $get_quantity = $item->get_quantity();
                                                $image = $product->get_image();
                                                $classSplited = '';
                                                $statusTitle = '';
                                                $total = number_format((float) $item->get_total(), 2, '.', '');
                                                $get_statusItem = 1;
                                                $shippedhistory = 0;
                                                if ($order->get_status() === 'processing') {
                                                    $get_statusItem = 1;
                                                } else if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                                                    //$q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
                                                    // $q1 = "SELECT l.event_id   FROM  " . SB_LOG . " as l";
                                                    // $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                                                    // $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id;
                                                    // $q1 .= " ORDER BY log_id DESC LIMIT 1";
                                                    // $get_statusItem = $wpdb->get_var($q1);


                                                    $q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
                                                    //  $q1 = "SELECT l.event_id   FROM  " . SB_LOG . " as l";
                                                    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                                                    $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id;
                                                    $q1 .= " ORDER BY log_id DESC LIMIT 1";
                                                    // $get_statusItem = $wpdb->get_var($q1);
                                                    $logEntry = $wpdb->get_row($q1, 'ARRAY_A');
                                                    // echo '<pre>';
                                                    // print_r($logEntry);
                                                    // echo '</pre>';
                                                    if (isset($logEntry['event_id']) && $logEntry['event_id'] > 0) {
                                                        $get_statusItem = $logEntry['event_id'];
                                                        $statusTitle = $logEntry['status'];
                                                    }

                                                    //   $get_statusItem = $wpdb->get_row($q1, 'ARRAY_A');

                                                    if ($get_statusItem == 17) {
                                                        $classSplited = 'itemSplitted';
                                                    }
                                                    if (isset($logEntry['event_id']) && $logEntry['event_id'] == 2) {
                                                        $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                                                    }
                                                } else {
                                                    $get_statusItem = 0;
                                                }


                                                //var_dump($get_statusItem);
                                                $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                                                $productTitle = '<h4 class="productNameAndQuantity mb-0 ' . $classSplited . '"> <a href="get_the_permalink(' . $product_id . ')" target= "_blank">' . (in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])? $item->get_name().' <small>('.ucfirst(wc_get_order_item_meta($item_id, 'shine_members', true)).')</small>' : $item->get_name()) . '</a> × <span class="text-blue">' . $get_quantity . '</span></h4>';
                                                $viewLink = '<a href="' . $product_permalink . '" class="viewItems text-blue ddasfasfs hidden">View Item <i class="fa fa-external-link-square" aria-hidden="true"></i></a>';
                                                $buyAgaing = '';
                                                if (get_field('buy_again', $product_id) != 'hide' && !in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])) {
                                                    $buyAgaing = '<a href="?add-to-cart=' . $product_id . '" data-quantity="1" class="button btn-primary-blue  add_to_cart_button ajax_add_to_cart" data-product_id="' . $product_id . '" data-action="woocommerce_add_order_item">Buy Again</a>';
                                                }
                                        ?>
                                                <tr class="productListOrder <?php echo $classSplited; ?>">
                                                    <th scope="row">
                                                        <div class="productDetailList">
                                                            <div class="productImage">
                                                                <?php echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item)); ?>
                                                            </div>
                                                            <div class="productDescription">
                                                                <?php echo $productTitle; ?>
                                                                <div class="optionDispaly">
                                                                    <?php echo $viewLink; ?>

                                                                    <?php
                                                                    if ($three_way_ship_product == 'yes') {
                                                                        if (in_array($order->get_status(), array('shipped'))) {
                                                                            echo getReorderKitButton($product_id, $item_id, $order->get_status());
                                                                        }
                                                                    } else {
                                                                        echo $buyAgaing;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>

                                                    <td class="viewStatusInnerTh">
                                                        <?php

                                                        if(!in_array($product->get_id(), [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])){
                                                        $itemData = array(
                                                            'product_id' => $product_id,
                                                            'item_id' => $item_id,
                                                            'order_number' => $order->get_order_number(),
                                                            'shipped' => $shippedhistory
                                                        );
                                                        echo stageItemLevel($get_statusItem, $three_way_ship_product, $statusTitle, $itemData);
                                                        echo '<a href="javascript:;" data-toggle="modal" data-target="#addProductModalpopup" onclick="addProductReview(' . $product_id . ' , ' . $item_id . ' , \'' . $order->get_id() . '\')" class="addCustomerProductReview  mobileaddCustomerProductReview order3" data-toggle="modal" data-target="#addCustomerProductReview">Add a review</a>';
                                                        }else{
                                                            echo "Completed";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="priceDisplayItem">
                                                            <?php
                                                            $product_id = $item->get_product_id();
                                                            if ($three_way_ship_product == 'yes') {
                                                                echo wc_price($item->get_subtotal() * $get_quantity);
                                                            } else {
                                                                echo $order->get_formatted_line_subtotal($item);
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <th scope="row" colspan="2">
                                                <div class="disTotal">
                                                    SUBTOTAL:
                                                </div>
                                            </th>

                                            <td>
                                                <div class="priceDisplayItem">
                                                    <?php echo $order->get_subtotal_to_display(); ?>
                                                </div>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th scope="row" colspan="2">
                                                <div class="disTotal">
                                                    SHIPPING:
                                                </div>
                                            </th>

                                            <td>
                                                <div class="shippingDisplyInfo">
                                                    <span>
                                                        <?php
                                                        echo $order->get_shipping_to_display();
                                                        ?>

                                                    </span>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                        if ($order->get_discount_total()) {
                                        ?>

                                            <tr>
                                                <th scope="row" colspan="2">
                                                    <div class="disTotal">
                                                        Discount:
                                                    </div>
                                                </th>

                                                <td>
                                                    <div class="paymentDisplyInfo">
                                                        <span>
                                                            <?php
                                                            echo $order->get_discount_to_display();

                                                            if (count($order->get_coupon_codes()) > 0) {
                                                                //echo '<br/>';
                                                                echo '(' . implode(",", $order->get_coupon_codes()) . ')';
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                        ?>

                                        <tr>
                                            <th scope="row" colspan="2">
                                                <div class="disTotal">
                                                    Payment Method:
                                                </div>
                                            </th>

                                            <td>
                                                <div class="paymentDisplyInfo">
                                                    <span>
                                                        <?php
                                                        if ($order->get_payment_method_title() != '') {
                                                            echo $order->get_payment_method_title();
                                                        } else {
                                                            echo 'Pending payment';
                                                        }
                                                        ?>

                                                    </span>
                                                </div>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th scope="row" colspan="2">
                                                <div class="alldisTotal">
                                                    <strong>Total:</strong>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="allTotal">
                                                    <strong><?php echo $order->get_formatted_order_total(); ?> </strong>
                                                </div>
                                            </td>

                                        </tr>


                                    </tbody>
                                </table>

                                <div class="currentStatus currentStatusDesktop mb-3">
                                    <div class="th-head currentStatusTab flexDsktopRow">
                                        <span>
                                            Current Status:
                                        </span>
                                        <strong class="text-blue">
                                            <?php echo ucwords(wc_get_order_status_name($order->get_status())); ?>
                                        </strong>
                                        <?php
                                        global $wpdb;
                                        if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                                            $order_number = $order->get_id();
                                            $query = "SELECT  easyPostShipmentTrackingUrl ,  trackingCode FROM " . SB_EASYPOST_TABLE . " as st";
                                            $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                                            $query .= " WHERE  l.order_id = $order_number AND st.shipmentState IS  NULL";
                                            $query .= " ORDER BY st.shipment_id DESC ";
                                            $query_tracking_number = $wpdb->get_row($query);

                                            if ($query_tracking_number) {
                                        ?>
                                                <span class="sepratorLine"></span>
                                                <a href="<?php echo $query_tracking_number->easyPostShipmentTrackingUrl; ?>" target="_blank" class="text-blue trackOrderMbt">Track Order</a>

                                        <?php
                                            }
                                        }
                                        ?>
                                        <!-- <span class="sepratorLine"></span>
                                                                                                    <strong><a href="javascript:;" class="text-blue">Track Order</a></strong> -->

                                    </div>
                                    <div class="td-head smallFnt flexDsktopRow">

                                        <?php
                                        if ($order->get_status() == 'pending' || $order->get_status() == 'failed') {
                                        ?>
                                            <a href="<?php echo $order->get_checkout_payment_url(); ?>" class="text-blue orangeButton">Pay Now</a>
                                        <?php
                                        }
                                        if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed'))) {
                                            echo refundOrderButton($order_id, $order->get_order_number());
                                        }
                                        ?>
                                        <!-- <a href="javascript:void(0)" class="button btn-primary-blue" onclick="dashboardAjaxRequest('zendeskCS&tab=add&type=refund')">Return Item</a> -->
                                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('support')); ?>" class="button btn-primary-blue fullBlueBg">Contact Support</a>

                                    </div>
                                </div>
                                <?php
                                if ($order->get_status() === 'processing') {
                                    echo cancelOrderButton($order_id, $order->get_order_number());
                                }
                                ?>

                            <?php } ?>

                            <div class="orderDetailContainer">
                                <?php if (wp_is_mobile()) { ?>
                                    <div class="onlyMobile <?php echo ($shine?'shineSubscribed shine-subs-detail':'');?>">

                                        <div class="pageHeading_sec borderBottomLine paddingBottom15 marginBottom15">
                                            <span><span class="text-blue">OrderS</span>Track, Return, or buy items again.</span>
                                        </div>
                                        <div class="d-flex orderDetailFile breadCrumbsListWrapper justify-content-between  borderBottomLine paddingBottom15">
                                            <div class="crumbTrail">
                                                <ul class="breadcrumbItem">
                                                    <li><a href="<?php echo home_url('my-account/orders'); ?>">All Orders</a></li>
                                                    <li><a href="javascript:void(0);"><?php echo $order->get_order_number(); ?></a></li>
                                                </ul>
                                            </div>
                                            <div class="button text-right goBackDetailPage arrowBtn"><a href="/my-account/orders/" class="backButton " onclick=""><i class="fa fa-angle-left" aria-hidden="true"></i></a></div>
                                        </div>

                                        <h3 class="orderHeading mb-0"><?php echo $order->get_order_number(); ?> </h3>
                                        <p class="placeOrderText">placed on <span class="text-blue"><?php echo wc_format_datetime($order->get_date_created()); ?></span> and is currently <span class="text-blue"><?php echo wc_get_order_status_name($order->get_status()); ?>.</span></span></p>


                                        <div class="productOrderSection">
                                            <div class="prductTitle">Product</div>

                                            <?php
                                            $orderItemArray = array();
                                            $counterItem = array();
                                            $Orderhtml = '';
                                            $order_items = $order->get_items();
                                            foreach ($order_items as $item_id => $item) {
                                                $product_id = $item->get_product_id();
                                                if (wc_cp_get_composited_order_item_container($item, $order)) {
                                                    continue;
                                                } else {
                                                    if (isset($counterItem[$product_id])) {
                                                        $counterItem[$product_id] = $counterItem[$product_id] + 1;
                                                    } else {
                                                        $counterItem[$product_id] = $item->get_quantity();
                                                    }
                                                }

                                                $orderItemArray[$product_id] = array(
                                                    'quantity' => $counterItem[$product_id],
                                                    'item_id' => $item_id,
                                                );
                                            }

                                            foreach ($orderItemArray as $product_id => $itemDeatil) {
                                                $item = $order_items[$itemDeatil['item_id']];
                                                $product = $item->get_product();
                                                $item_id = $itemDeatil['item_id'];
                                                $get_quantity = $itemDeatil['quantity'];
                                                $image = $product->get_image();
                                                $is_visible = $product && $product->is_visible();
                                                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', TRUE);
                                                $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                                                $productTitle = '<h4 class="productNameAndQuantity mb-0 dddd"> <a href="get_the_permalink(' . $product_id . ')" target= "_blank">' . (in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])? $item->get_name().' <small>('.ucfirst(wc_get_order_item_meta($item_id, 'shine_members', true)).')</small>' : $item->get_name()) . '</a> × <span class="text-blue">' . $get_quantity . '</span></h4>';
                                                $viewLink = '<a href="' . $product_permalink . '" class="viewItems text-blue adsfasfs">View Item <i class="fa fa-external-link-square" aria-hidden="true"></i></a>';
                                                $buyAgaing = '';
                                                if (get_field('buy_again', $product_id) != 'hide' && !in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])) {
                                                    $buyAgaing = '<a href="?add-to-cart=' . $product_id . '" data-quantity="1" class="button btn-primary-orange product-selection-price-button  add_to_cart_button ajax_add_to_cart orangeButton" data-product_id="' . $product_id . '" data-action="woocommerce_add_order_item">Buy Again</a>';
                                                }
                                            ?>


                                                <div class="productDisplayRow">
                                                    <div class="row lessSpacingLeftRight">

                                                        <div class="col productDescriptionBodyText">
                                                            <div class="featureImageSbr">
                                                                <?php echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item)); ?>
                                                                <?php //echo $viewLink; 
                                                                ?>
                                                            </div>
                                                            <div class="item-name-mbt">
                                                                <div class="itemInnerMbtText">
                                                                    <?php echo $productTitle; ?>

                                                                    <div class="priceDisplayN text-left">
                                                                        <strong>
                                                                            <?php
                                                                            $product_id = $item->get_product_id();
                                                                            if ($three_way_ship_product == 'yes') {
                                                                                echo wc_price($item->get_subtotal() * $get_quantity);
                                                                            } else {
                                                                                echo $order->get_formatted_line_subtotal($item);
                                                                            }
                                                                            ?>
                                                                        </strong>
                                                                    </div>
                                                                    <?php
                                                                    if ($three_way_ship_product == 'yes') {
                                                                        echo getReorderKitButton($product_id, $item_id, $order->get_status());
                                                                    } else {
                                                                        echo $buyAgaing;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            //echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf($viewProduct . $buyAgaing, $item->get_name(), $get_quantity, $product_permalink) : $item->get_name(), $item, $is_visible); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                            ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </div>

                                        <div class="orderDetailTable">

                                            <div class="repeatRowTab">
                                                <div class="row">
                                                    <div class="col-6 th-head">
                                                        <strong>
                                                            SUBTOTAL:
                                                        </strong>
                                                    </div>
                                                    <div class="col-6 td-head smallFnt">
                                                        <strong>
                                                            <?php echo $order->get_subtotal_to_display(); ?>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="repeatRowTab">
                                                <div class="row">
                                                    <div class="col-6 th-head">
                                                        <strong>
                                                            SHIPPING:
                                                        </strong>
                                                    </div>
                                                    <div class="col-6 td-head smallFnt shippingDisplyInfo">
                                                        <span>
                                                            <?php echo $order->get_shipping_to_display(); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>



                                            <?php
                                            if ($order->get_discount_total()) {
                                            ?>
                                                <div class="repeatRowTab">
                                                    <div class="row">
                                                        <div class="col-6 th-head">
                                                            <strong>
                                                                Discount:
                                                            </strong>
                                                        </div>
                                                        <div class="col-6 td-head smallFnt shippingDisplyInfo">
                                                            <span>
                                                                <?php
                                                                echo $order->get_discount_to_display();

                                                                if (count($order->get_coupon_codes()) > 0) {
                                                                    //echo '<br/>';
                                                                    echo '(' . implode(",", $order->get_coupon_codes()) . ')';
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                            }
                                            ?>


                                            <div class="repeatRowTab">
                                                <div class="row">
                                                    <div class="col-6 th-head">
                                                        <strong>
                                                            PAYMENT METHOD:
                                                        </strong>
                                                    </div>
                                                    <div class="col-6 td-head smallFnt paymentMethod">
                                                        <span>
                                                            <?php
                                                            if ($order->get_payment_method_title() != '') {
                                                                echo $order->get_payment_method_title();
                                                            } else {
                                                                echo 'Pending payment';
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="repeatRowTab totalSecLast">
                                                <div class="row">
                                                    <div class="col-6 th-head">
                                                        <strong>
                                                            TOTAL:
                                                        </strong>
                                                    </div>
                                                    <div class="col-6 td-head smallFnt">
                                                        <strong>
                                                            <?php echo $order->get_formatted_order_total(); ?>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            global $wpdb;
                                            if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                                                $order_number = $order->get_id();
                                                $query = "SELECT  easyPostShipmentTrackingUrl ,  trackingCode FROM " . SB_EASYPOST_TABLE . " as st";
                                                $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                                                $query .= " WHERE  l.order_id = $order_number AND st.shipmentState IS  NULL";
                                                $query .= " ORDER BY st.shipment_id DESC ";
                                                $query_tracking_number = $wpdb->get_row($query);

                                                if ($query_tracking_number) {
                                            ?>
                                                    <div class="repeatRowTab">
                                                        <div class="row align-items-center">
                                                            <div class="col-6 th-head">
                                                                <strong>
                                                                    Tracking Number:
                                                                </strong><br>
                                                                <span><?php echo $query_tracking_number->trackingCode; ?></span>
                                                            </div>
                                                            <div class="col-6 td-head smallFnt">
                                                                <a href="<?php echo $query_tracking_number->easyPostShipmentTrackingUrl; ?>" target="_blank" class="buttonDefault smallRipple ripple-button smallButtonMbt">Track Order</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                            <?php
                                                }
                                            }
                                            ?>




                                        </div>
                                        <div class="currentStatus">
                                            <div class="row noMargin">
                                                <div class="th-head currentStatusTab">
                                                    <strong>
                                                        Current Status:
                                                    </strong>
                                                </div>
                                                <div class="td-head smallFnt">
                                                    <strong class="text-blue">
                                                        <?php echo wc_get_order_status_name($order->get_status()); ?>
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="placeOrderText hidden">placed on <span class="text-blue"><?php echo wc_format_datetime($order->get_date_created()); ?></span> and is currently <span class="text-blue"><?php echo wc_get_order_status_name($order->get_status()); ?>.</span></span></p>
                                        <div class="customerSupportOrder hidden-mobile">
                                            <a href="javascript:void(0)" class="buttonDefault smallRipple ripple-button" onclick="dashboardAjaxRequest('zendeskCS&tab=all')">Customer Support</a>
                                        </div>

                                        <div class="hiddenDesktop hiddenMbt">

                                            <div class="td-head smallFnt flexDsktopRow customerSupportOrder d-flex border-bottom padding-bottom15 margin-bottom15 gap15">




                                                <?php
                                                if ($order->get_status() == 'pending' || $order->get_status() == 'failed') {
                                                ?>
                                                    <a href="<?php echo $order->get_checkout_payment_url(); ?>" class="text-blue orangeButton">Pay Now</a>
                                                <?php
                                                }

                                                if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed'))) {
                                                    echo refundOrderButton($order_id, $order->get_order_number());
                                                }
                                                ?>
                                                <!-- <a href="javascript:void(0)" class="button btn-primary-blue" onclick="dashboardAjaxRequest('zendeskCS&tab=add&type=refund')">Return</a> -->
                                                <a href="<?php echo esc_url(wc_get_account_endpoint_url('support')); ?>" class="button btn-primary-blue fullBlueBg">Support</a>

                                            </div>

                                        </div>

                                    </div>
                                <?php } ?>
                                <div class="orderCustomerDetailTable">
                                    <?php wc_get_template('order/order-details-customer.php', array('order' => $order)); ?>
                                </div>

                            </div>
                            </div>

                            <div class="tab-pane buyagaintab" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <?php
                                //sbr_customer_order_dashboard('buyagain'); 
                                ?>
                            </div>
                        </div>
                    </div>

            </div>
        </div>








    </section>
</div>