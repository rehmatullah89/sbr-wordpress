<?php
/*
 * show order Shipments by order id
 */

function order_shipment_meta_box()
{

    add_meta_box(
        'order-shipment',
        __('Shipment History', 'woocommerce'),
        'order_shipment_meta_box_callback',
        'shop_order'
    );
}

add_action('add_meta_boxes', 'order_shipment_meta_box');

function order_shipment_meta_box_callback($order)
{
    $orderID = $order->ID;

?>

    <table id="shipmentRecord" class="data-table" style="width:99%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Carrier</th>
                <th>Method</th>
                <th>Date Shipped</th>
                <th class="label-date-th">Label Date</th>
                <th>Tracking Code</th>
                <th>Status</th>
                <th>Expected Delivery Date</th>
                <th>Actual Delivery Date</th>
                <th>Cost</th>
                <th>Manifest</th>
                <th>Products</th>
                <th class="shipment_actions"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>

    </table>
    <style>
        table.dataTable tbody tr {
            background-color: #fff;
            text-align: center;
        }
    </style>
    <script>
        jQuery(document).ready(function() {
            shipmentDatatable = jQuery('#shipmentRecord').DataTable({
                "ordering": false,
                "searching": false,
                "processing": false,
                "serverSide": true,
                //    "paging": false,
                "ajax": {
                    url: "<?php echo admin_url('admin-ajax.php?action=easypostShipment_datatable'); ?>",
                    type: "GET",
                    "data": function(d) {
                        d.source = 'order_page',
                            d.order_id = '<?php echo $orderID; ?>'

                    },
                    "complete": function(response) {

                    }

                }
            });
        });
    </script>
    <?php
}

//add_action('admin_menu', 'register_shipment_page');

function register_shipment_page()
{
    add_submenu_page(
        'edit.php?post_type=product',
        'Shipments',
        'Shipments',
        'manage_options',
        'shipment',
        'getAllEasypostShipments'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'Batch Search',
        'Batch Search',
        'manage_options',
        'search_batch',
        'getAllEasyPostBatch'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'Batch Print Logs',
        'Batch Print Logs',
        'manage_options',
        'batch_print_logs',
        'batchPrintLog'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'Print Request Info',
        'Print Request Info',
        'manage_options',
        'batch_print_info',
        'batchPrintLogDetail'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'Sale management system',
        'Sale management system',
        'manage_options',
        'sbr_sale',
        'sbr_productSaleManagement'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'Inventory management system',
        'Inventory management system',
        'manage_options',
        'sbr_ims',
        'sbr_inventoryManagement'
    );
    add_submenu_page(
        'edit.php?post_type=product',
        'RDH',
        'RDH',
        'manage_options',
        'sbr_rdh',
        'sbr_rdhManagement'
    );
}

function batchPrintLogDetail($request_id = 0, $state = 0)
{



    global $wpdb;
    if (isset($_GET['request_id']) && $_GET['request_id'] <> 0) {
        $request_id = $_GET['request_id'];
    }
    if ($request_id == '') {
        echo 'Request Id is empty';
    } else {
        echo '<input type="hidden" name="print_request_id" id="print_request_id" value="' . $request_id . '" />';
        $requestData = $wpdb->get_row("SELECT * FROM " . SB_PRINT_REQUEST_TABLE . " WHERE request_id=" . $request_id);
        //  echo 'Data: <pre>' .print_r($requestData,true). '</pre>';
        $batch_printing_orders = $wpdb->get_results("SELECT * FROM " . SB_PRINT_REQUESTS_ORDER_TABLE . " WHERE print_request_id=" . $request_id);
        //  echo 'Data: <pre>' .print_r($batch_printing_orders,true). '</pre>';

        wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
        wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    ?>
        <script src='<?php echo site_url('wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'); ?>' id='jquery-blockui-js'></script>
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
        <div class="mbt-row inf-content">
            <?php
            if ($state) {
                echo '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=sb_orders_page&batch_printing=yes') . '">Back</a>';
            } else {
                echo '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=batch_print_logs') . '">Back</a>';
            }
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
                                    <tr>
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
                                    <tr>
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
                                    <tr>
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
                                            <a class="button button-small" onclick="createEasyPostManifest(<?php echo $requestData->request_id; ?>)" href="javascript:;" style="float: right;">Generate Manifest</a>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <a href="javascript:;" id="resend_request_shipment" class="button button-small" style="display:none">Resend Print Requests </a>
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
                                    <th>Order ID</th>
                                    <th>Shipping Address</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $countries_obj = new WC_Countries();
                                $countries = $countries_obj->__get('countries');

                                $displayBtn = false;
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
                                        $productsWithQty = array();
                                        $productHtml = '';
                                        if ($order_entry->product_ids) {
                                            $products = json_decode($order_entry->product_ids, true);
                                            $productHtml .= '<ul>';
                                            foreach ($products as $item_id => $product) {

                                                if (isset($productsWithQty[$product['product_id']])) {
                                                    $productPreviousQty = $productsWithQty[$product['product_id']]['qty'] + $product['qty'];
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
                                        $county_states = $countries_obj->get_states($shipment->shiptoCountry);
                                        $selectState = isset($county_states[$shipment->shiptoState]) ? $county_states[$shipment->shiptoState] : $shipment->shiptoState;
                                        $selectCountry = isset($countries[$shipment->shiptoCountry]) ? $countries[$shipment->shiptoCountry] : $shipment->shiptoCountry;
                                        $address = $shipment->shiptoFirstName . ' ' . $shipment->shiptoLastName;
                                        $address .= '<br/>' . $shipment->shiptoAddress . ' ' . $shipment->shiptoAptNo;
                                        $address .= '<br/>' . $shipment->shiptoCompany;
                                        $address .= '<br/>' . $shipment->shiptoCity . ', ' . $selectState . '(' . $shipment->shiptoPostalCode . ')';
                                        $address .= '<br/>' . $selectCountry;
                                        $address .= '<br/>Ph#' . $shipment->shiptoPhone;
                                        echo '<tr id="print_order_' . $order_id . '" status="' . $statusOrder . '" order_id="' . $order_id . '" class="batchPrint-' . $key . '">';
                                        $order_number_formatted = '<strong><a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $order_id . '&action=edit">' . get_post_meta($order_id, 'order_number', true) . '</a></strong>';
                                        echo '<td>' . $order_number_formatted . '</td>';
                                        echo '<td>' . $address . '</td>';
                                        echo '<td class="curent-products">' . $productHtml . '</td>';
                                ?>
                                        <td class="current-response"><?php
                                                                        if ($order->get_status() == 'shipped' && $order_entry->status != 10) {
                                                                            $query = "SELECT shipment_id FROM " . SB_PRINT_REQUESTS_ORDER_TABLE . " WHERE order_id=" . $order_id . " AND status = 10";
                                                                            $shipmentTracking = $wpdb->get_var($query);
                                                                            echo 'Order Shipped with other batch print request.';
                                                                            if ($shipmentTracking) {
                                                                                //   $shipment = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $shipmentTracking);
                                                                                $statusHtml .= '';
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

                                                                                // $packageCreateUrl = admin_url('admin.php?page=new-package&order_id=' . $order_id);
                                                                                //13022023
                                                                                echo '<span class="batchBtnActions"><a onclick="addPackageGroup(\'' . $packageCreateUrl . '\' , false  ,' . $order_id . ')" href="javascript:;">Select packaging </a></span>';
                                                                            }
                                                                            if ($order_entry->status == 10) {
                                                                                if ($order_entry->shipment_id) {
                                                                                    $shipment = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $order_entry->shipment_id);
                                                                                    $statusHtml .= '';
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
                                    echo '<tr>';
                                    echo '<td colspan="3">No record found!</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <?php
            $loadingHtml = '<div id="center"><div class="letter_container_1"><span>L</span></div><div class="letter_container_2"><span>O</span></div><div class="letter_container_3"><span>A</span></div><div class="letter_container_4"><span>D</span></div><div class="letter_container_5"><span>I</span></div><div class="letter_container_6"><span>N</span></div><div class="letter_container_7"><span>G</span></div></div>';
            ?>
            <style>
                .loading-sbr {
                    display: none !important;
                }
            </style>
            <script>
                <?php
                if ($displayBtn) {
                ?>
                    jQuery('#resend_request_shipment').show();
                <?php
                }
                $actionShipmentType = 'createOrderShipment';
                if ($requestData->shipment_type == 2) {
                    $actionShipmentType = 'createOrderSecondShipment';
                }
                ?>

                function createEasyPostManifest(request_id = 0) {


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
                        "searching": false,
                        "paging": false
                    });
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
                jQuery('body').on('click', '#resend_request_shipment', function() {
                    // totalLength = getRemainItemCount();
                    sendPrintAjaxRequest(initialCounter);
                });

                function sendPrintAjaxRequest(initialCounter) {

                    if (initialCounter < totalLength) {

                        var classtofind = '.batchPrint-' + initialCounter;
                        var currentItem = jQuery('body').find(classtofind);
                        console.log(currentItem.attr('status'));
                        if (currentItem.attr('status') == 0) {
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
                                                jQuery(currentItem).find('.current-response').append('<a onclick="addPackageGroup(\'' + response.packageUrl + '\')" href="javascript:;">Select Package</a>');
                                            }
                                        }

                                    }




                                },
                                error: function(xhr) {

                                },
                            });
                        } else {
                            initialCounter = initialCounter + 1;
                            sendPrintAjaxRequest(initialCounter);
                        }
                        if (getRemainItemCount() == 0) {
                            jQuery('#resend_request_shipment').hide();
                        }
                    }
                }
            </script>
        <?php
    }
}

function batchPrintLog()
{

    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
        ?>


        <div class="search-shipement">
            <h3>Batch Print Requests <span class="dashicons dashicons-print"></span> </h3>
            <div class="shipment-inner-container">
                <div class="flex-row">


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Batch Created On or After
                                <input placeholder="Batch Number" type="date" id="batchLogCreatedAfter" value="" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Batch Created On or Before
                                <input placeholder="Batch Number" type="date" id="batchLogCreatedBefore" value="" class="form-control">
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>SBR Order Number
                                <input placeholder="SBR Order Number" type="text" autocomplete="off" id="sbrOrderNumber" value="" class="form-control">
                            </label>
                        </div>
                    </div>

                    <div class="buttons-custom-added wrap col-sm-12 ">
                        <a href="javascript:;" id="searchByFilters" class="button button-small page-title-action">Search</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="buttons-custom-added wrap">
            &nbsp;
        </div>

        <table id="batchPrintLog" class="data-table" style="width:99%">
            <thead>
                <tr>
                    <th>Request #</th>
                    <th>Number of Orders</th>
                    <th>Email Notification</th>
                    <th>Print Label</th>
                    <th>Generate Package</th>

                    <th>Created By</th>
                    <th>Date Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        <style>
            table.dataTable tbody tr {
                background-color: #fff;
                text-align: center;
            }
        </style>
        <script>
            var datatable = '';
            jQuery(document).ready(function() {
                datatable = jQuery('#batchPrintLog').DataTable({
                    "ordering": false,
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "<?php echo admin_url('admin-ajax.php?action=batchPrintLogs'); ?>",
                        type: "GET",
                        "data": function(d) {
                            d.sbrOrderNumber = jQuery(document).find('#sbrOrderNumber').val(),
                                d.batchCreatedAfter = jQuery(document).find('#batchLogCreatedAfter').val(),
                                d.batchCreatedBefore = jQuery(document).find('#batchLogCreatedBefore').val()
                            //  d.contact_request = 1
                        },
                        "complete": function(response) {

                        }

                    }
                });
            });
            jQuery(document).on('click', '#searchByFilters', function(e) {
                datatable.ajax.reload();
            });
        </script>
    <?php
}

add_filter('wp_ajax_batchPrintLogs', 'batchPrintLogs_callback');

function batchPrintLogs_callback()
{
    global $wpdb;
    if (!empty($_GET)) {
        //        echo '<pre>';
        //        print_r($_GET);
        //        echo '</pre>';
        $orderByColumnIndex = 0;
        // $orderBy = 'desc';
        /* SEARCH CASE : Filtered data */
        /* Useful $_REQUEST Variables coming from the plugin */
        $draw = $_GET["draw"]; //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'DESC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        $searchQuery = " ";
        $searchDateQuery = " ";
        $joinQuery = "";
        if (!empty($_GET['search']['value'])) {
        }

        if (isset($_REQUEST['sbrOrderNumber']) && $_REQUEST['sbrOrderNumber'] <> '') {
            $joinQuery = " INNER JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " po ON pr.request_id=po.print_request_id";
            $searchQuery .= " and (po.order_number = '" . $_REQUEST['sbrOrderNumber'] . "') ";
        }

        if ($_REQUEST['batchCreatedAfter'] <> '' && $_REQUEST['batchCreatedBefore'] <> '') {
            $searchQuery .= " and (pr.created_date BETWEEN '" . $_REQUEST['batchCreatedAfter'] . " 00:00:00' AND '" . $_REQUEST['batchCreatedBefore'] . " 23:59:59') ";
        } else if ($_REQUEST['batchCreatedAfter'] <> '') {
            $searchQuery .= " and (pr.created_date >= '" . $_REQUEST['batchCreatedAfter'] . " 00:00:00') ";
        } else if ($_REQUEST['batchCreatedBefore'] <> '') {
            $searchQuery .= " and (pr.created_date <= '" . $_REQUEST['batchCreatedBefore'] . " 23:59:59') ";
        }



        $keyCol = 'pr.request_id';
        $q1 = "SELECT DISTINCT pr.* FROM  " . SB_PRINT_REQUEST_TABLE . " pr" . $joinQuery;
        $q1 .= " WHERE 1 " . $searchQuery;
        $q1 .= " ORDER BY $keyCol $orderType LIMIT $start, $length";
        $data = $wpdb->get_results($q1);

        $modified_data = array();
        foreach ($data as $key => $batch) {
            $user_info = get_userdata($batch->created_by);
            $username = $user_info->display_name;
            $email = 'No';
            if ($batch->tracking_email) {
                $email = 'Yes';
            }
            $package = 'No';
            if ($batch->packaging_label) {
                $package = 'Yes';
            }
            $ship_label = 'No';
            if ($batch->shipment_label) {
                $ship_label = 'Yes';
            }

            $entryData = array(
                $batch->request_id,
                $batch->order_counts,
                $email,
                $package,
                $ship_label,
                $username,
            );
            $entryData[] = sbr_datetime($batch->created_date);
            //$entryData[] = date("Y-m-d", strtotime($batch->created_date));
            $batch_print_url = 'batch_print_info';
            if ($batch->order_ids != '') {
                $batch_print_url = 'batch_request';
            }
            $entryData[] = '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=' . $batch_print_url . '&request_id=' . $batch->request_id) . '">View Detail</a>';
            $modified_data[] = $entryData;
        }
        $q_count = "SELECT COUNT(DISTINCT pr.request_id) FROM  " . SB_PRINT_REQUEST_TABLE . " pr" . $joinQuery;
        $q_count .= " WHERE 1 " . $searchQuery;
        $q_count .= " " . $searchDateQuery;
        $recordsTotal = $wpdb->get_var($q_count);
        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsTotal,
            "data" => $modified_data
        );
        echo json_encode($results);
    }
    die;
}

function getAllEasyPostBatch()
{
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    ?>


        <div class="search-shipement">
            <h3>Batch Search <span class="dashicons dashicons-search"></span> </h3>
            <div class="shipment-inner-container">
                <div class="flex-row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Shipment Method
                                <select id="shipmentMethod" class="form-control">
                                    <option value="" selected="selected">All</option>
                                    <option value="USPS">USPS</option>
                                </select>
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Batch Created On or After
                                <input placeholder="Batch Number" type="date" data-date-format="DD MM YYYY" id="batchCreatedAfter" value="" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Batch Created On or Before
                                <input placeholder="Batch Number" type="date" data-date-format="DD MM YYYY" id="batchCreatedBefore" value="" class="form-control">
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">

                        </div>
                    </div>

                    <div class="buttons-custom-added wrap">
                        <a href="javascript:;" id="searchByFilters" class="page-title-action">Search</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="buttons-custom-added wrap">
            &nbsp;
        </div>

        <table id="shipmentRecord" class="data-table" style="width:99%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Carrier</th>
                    <th>Easypost Batch ID</th>
                    <th>Shipment Count</th>
                    <th>Mode</th>

                    <th>Created By</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        <style>
            table.dataTable tbody tr {
                background-color: #fff;
                text-align: center;
            }
        </style>
        <script>
            var datatable = '';
            jQuery(document).ready(function() {
                datatable = jQuery('#shipmentRecord').DataTable({
                    "ordering": false,
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "<?php echo admin_url('admin-ajax.php?action=easypostBatch_datatable'); ?>",
                        type: "GET",
                        "data": function(d) {
                            d.shipmentMethod = jQuery(document).find('#shipmentMethod').val(),
                                d.batchCreatedAfter = jQuery(document).find('#batchCreatedAfter').val(),
                                d.batchCreatedBefore = jQuery(document).find('#batchCreatedBefore').val()
                            //  d.contact_request = 1
                        },
                        "complete": function(response) {

                        }

                    }
                });
            });
            jQuery(document).on('click', '#searchByFilters', function(e) {
                datatable.ajax.reload();
            });

            function easyPostBatchRequest(get_ajax_url, mode) {
                jQuery.ajax({
                    url: get_ajax_url,
                    data: {
                        mode: mode
                    },
                    async: true,
                    dataType: 'JSON',
                    method: 'POST',
                    beforeSend: function(xhr) {

                    },
                    success: function(response) {

                        if (response.code == 'success') {
                            Swal.fire({
                                icon: 'success',
                                text: response.msg
                            });
                        } else if (response.code == 'error') {
                            Swal.fire({
                                icon: 'error',
                                text: response.msg
                            });
                        }
                    },
                    error: function(xhr) {

                    },
                    cache: false,
                });
            }

            jQuery('body').on('click', '.viewBatchPage', function() {
                var get_ajax_url = jQuery(this).attr('custom_url');
                easyPostBatchRequest(get_ajax_url, 'view');
            });
            jQuery('body').on('click', '.printBatchPage', function() {
                var get_ajax_url = jQuery(this).attr('custom_url');
                easyPostBatchRequest(get_ajax_url, 'print');
            });
        </script>
    <?php
}

function getAllEasypostShipments()
{
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/datatables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/datatables.min.css', '1.0.0', true);

    ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
        <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <div class="search-shipement">
            <h3>Shipment Search <span class="dashicons dashicons-search"></span> </h3>
            <div class="shipment-inner-container">
                <div class="flex-row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Shipment Method


                                <?php
                                $easypostcarrieraccount = get_field('easypostcarrieraccount', 'option');
                                if (is_array($easypostcarrieraccount) && count($easypostcarrieraccount) > 0) {
                                    echo '<select  id="easyPostLabelCarrier" class="form-control" autocomplete="off" onchange="n__handleShippingMethod(this.value , 0 , 0 , 1);">';
                                    echo '<option value="" selected="selected">All</option>';
                                    foreach ($easypostcarrieraccount as $carrier) {
                                        echo '<option value="' . $carrier['label'] . '">' . $carrier['label'] . '</option>';
                                    }
                                    echo '</select>';
                                }
                                ?>

                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Tracking Number
                                <textarea placeholder="Shipment Tracking Number" data-role="tagsinput" type="text" autocomplete="off" id="shipmentTrackingNumber" value="" class="form-control"></textarea>
                            </label>

                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Shipping Status
                                <select id="shipmentStatus" class="form-control" autocomplete="off">
                                    <option value="" selected="selected">All</option>
                                    <?php
                                    $shipmentStatus = array(
                                        "pre_transit" => "Pre transit",
                                        "in_transit" => "In transit",
                                        "out_for_delivery" => "Out for delivery",
                                        "delivered" => "Delivered",
                                        "available_for_pickup" => "Available for pickup",
                                        "return_to_sender" => "Return to sender",
                                        "failure" => "Failure",
                                        "refuned" => "Refuned",
                                        "cancelled" => "Cancelled",
                                        "error" => "Error",
                                    );
                                    foreach ($shipmentStatus as $statusKey => $statusVal) {
                                        echo ' <option value="' . $statusKey . '">' . $statusVal . '</option>';
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Postage Refund
                                <select id="shipmentRefunedStatus" class="form-control" autocomplete="off">
                                    <option value="" selected="selected">--</option>
                                    <?php
                                    $shipmentRefundStatus = array(
                                        "Refunded-Success" => "Refunded Success",
                                        "Refunded-Failed" => "Refunded Failed",
                                    );
                                    foreach ($shipmentRefundStatus as $statusReKey => $statusRefVal) {
                                        echo ' <option value="' . $statusReKey . '">' . $statusRefVal . '</option>';
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Label Generation Method
                                <select id="shipmentLabelService" class="form-control" autocomplete="off">

                                    <?php
                                    $labelShipmentMethods = array(
                                        'First' => 'First',
                                        'Priority' => 'Priority',
                                        'Express' => 'Express',
                                        'ParcelSelect' => 'Parcel Select',
                                        'LibraryMail' => 'Library Mail',
                                        'MediaMail' => 'Media Mail',
                                        'FirstClassMailInternational' => 'First Class Mail International',
                                        'FirstClassPackageInternationalService' => 'First Class Package International Service',
                                        'PriorityMailInternational' => 'Priority Mail International',
                                        'ExpressMailInternational' => 'Express Mail International',
                                    );
                                    //<option value="" selected="selected">All</option>
                                    $_REQUEST['method'] = 'all';
                                    $_REQUEST['all'] = 1;
                                    get_carrierServiceMethod_callback();
                                    //foreach ($labelShipmentMethods as $methodKey => $shipmentLabelVal) {
                                    // echo ' <option value="' . $methodKey . '">' . $shipmentLabelVal . '</option>';
                                    // }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 hr-seprator">
                        <h4>Date Rangers</h4>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Label Generation Date On or After
                                <input placeholder="Shipment Tracking Number" type="date" id="labelGenerationAfter" value="" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Label Generation Date On or Before
                                <input placeholder="Shipment Tracking Number" type="date" id="labelGenerationBefore" value="" class="form-control">
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Shipment Created On or After
                                <input placeholder="Shipment Tracking Number" type="date" id="shipmentCreatedAfter" value="" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Shipment Created On or Before
                                <input placeholder="Shipment Tracking Number" type="date" id="shipmentCreatedBefore" value="" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="buttons-custom-added wrap">
                        <a href="javascript:;" id="searchByFilters" class="page-title-action">Search</a>
                    </div>
                </div>

            </div>

        </div>

        <div class="buttons-custom-added wrap">

            <a href="javascript:;" class="page-title-action" id="generateManifestScanForm">Generate Manifest</a>
            <a href="javascript:;" class="page-title-action" id="getRefundPostage">Refund Postage</a>
            <div id="controlPanel" style="float: right; margin-left: 7px;"></div>
            <style>
                #controlPanel button {
                    margin-left: 0;
                    margin-left: 4px;
                    padding: 4px 8px;
                    position: relative;
                    top: -3px;
                    text-decoration: none;
                    border: 1px solid #2271b1;
                    border-top-color: rgb(34, 113, 177);
                    border-right-color: rgb(34, 113, 177);
                    border-bottom-color: rgb(34, 113, 177);
                    border-left-color: rgb(34, 113, 177);
                    border-top-color: rgb(34, 113, 177);
                    border-right-color: rgb(34, 113, 177);
                    border-bottom-color: rgb(34, 113, 177);
                    border-left-color: rgb(34, 113, 177);
                    border-radius: 2px;
                    text-shadow: none;
                    font-weight: 600;
                    font-size: 13px;
                    line-height: normal;
                    color: #2271b1;
                    background: #f6f7f7;
                    cursor: pointer;
                }
            </style>
            <!-- <a href="javascript:;" class="page-title-action">Print label</a>         -->
        </div>
        <div class="loading-sbr" style="display: block;">
            <div class="inner-sbr"></div>
        </div>
        <table id="shipmentRecord" class="data-table" style="width:99%">
            <thead>
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="datatableCheckAll"></label>
                        </div>
                    </th>

                    <th>Type</th>
                    <th>Carrier</th>
                    <th>Method</th>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Date Shipped</th>
                    <th class="label-date-th">Label Date</th>
                    <th class="tracking-code">Tracking Code</th>
                    <th>Status</th>
                    <th class="expected-delivery-date">Expected Delivery Date</th>
                    <th class="actual-delivery-date">Actual Delivery Date</th>
                    <th>Cost(USD)</th>
                    <th>Weight(oz.)</th>

                    <th>Manifest</th>
                    <th class="product-id-table">Products</th>
                    <th class="shipment_actions"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        <style>
            table.dataTable tbody tr {
                background-color: #fff;
                text-align: center;
            }
        </style>
        <script>
            jQuery('#shipmentTrackingNumber').tagsinput({
                confirmKeys: [13, 32, 44]
            });


            var datatable = '';
            jQuery(document).ready(function() {
                datatable = jQuery('#shipmentRecord').DataTable({
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500],
                        [10, 25, 50, 100, 200, 500]
                    ],
                    "columnDefs": [{
                            "targets": [0],
                            "sClass": "hide-col-export",
                        },
                        {
                            "targets": [1],
                            "sClass": "hide-col-export",
                        },
                        {
                            "targets": [5],
                            "sClass": "hide-col-export",
                        },

                        {
                            "targets": [6],
                            "sClass": "hide-col-export",
                        },

                        {
                            "targets": [7],
                            "sClass": "hide-col-export",
                        },
                        {
                            "targets": [9],
                            "sClass": "hide-col-export",
                        },

                        {
                            "targets": [10],
                            "sClass": "hide-col-export",
                        },

                        {
                            "targets": [11],
                            "sClass": "hide-col-export",
                        },
                        {
                            "targets": [14],
                            "sClass": "hide-col-export",
                        },
                        {
                            "targets": [16],
                            "sClass": "hide-col-export",
                        },

                    ],

                    "ordering": false,
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "dom": 'B<"clear">lfrtip',
                    "buttons": [{
                        extend: 'excelHtml5',
                        text: 'Download',
                        exportOptions: {
                            columns: ":not(.hide-col-export)",
                        },

                        action: function(e, dt, node, config) {
                            var self = this;
                            var oldStart = dt.settings()[0]._iDisplayStart;
                            var oldLength = dt.settings()[0]._iDisplayLength;
                            dt.one('preXhr', function(e, s, data) {
                                // Just this once, load all data from the server...
                                data.start = 0;
                                data.length = 15;
                                data.exportLength = oldLength;
                                data.export = 'yes';
                                dt.one('preDraw', function(e, settings) {
                                    jQuery.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, node, config)
                                    dt.one('preXhr', function(e, s, data) {
                                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                        // Set the property to what it was before exporting.
                                        settings._iDisplayStart = oldStart;
                                        data.start = oldStart;
                                        data.export = 0;
                                    });
                                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                                    setTimeout(dt.ajax.reload, 0);
                                    // Prevent rendering of the full data to the DOM
                                    return false;
                                });
                            });
                            // Requery the server with the new one-time export settings
                            dt.ajax.reload();
                        }

                    }],

                    "ajax": {
                        url: "<?php echo admin_url('admin-ajax.php?action=easypostShipment_datatable'); ?>",
                        type: "GET",
                        "data": function(d) {

                            d.carrier = jQuery(document).find('#easyPostLabelCarrier').val(),
                                d.shipmentStatus = jQuery(document).find('#shipmentStatus').val(),
                                d.labelShipmentMethod = jQuery(document).find('#shipmentLabelService').val(),
                                d.trackingNumber = jQuery(document).find('#shipmentTrackingNumber').val(),
                                d.labelGenerationAfter = jQuery(document).find('#labelGenerationAfter').val(),
                                d.labelGenerationBefore = jQuery(document).find('#labelGenerationBefore').val(),
                                d.shipmentCreatedAfter = jQuery(document).find('#shipmentCreatedAfter').val(),
                                d.shipmentCreatedBefore = jQuery(document).find('#shipmentCreatedBefore').val(),
                                d.shipmentRefunedStatus = jQuery(document).find('#shipmentRefunedStatus').val()
                        },
                        "complete": function(response) {
                            jQuery('.loading-sbr').hide();
                        }

                    },
                });
                datatable.buttons().containers().appendTo('#controlPanel');
                /*
                datatable = jQuery('#shipmentRecord').DataTable({
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500],
                        [10, 25, 50, 100, 200, 500]
                    ],
                    "ordering": false,
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "dom": '<"top"i>rt<"bottom"flp><"top"rf>t<"bottom"pli>',
                    "ajax": {
                        url: "<?php //echo admin_url('admin-ajax.php?action=easypostShipment_datatable'); 
                                ?>",
                        type: "GET",
                        "data": function(d) {

                            d.carrier = jQuery(document).find('#easyPostLabelCarrier').val(),
                                d.shipmentStatus = jQuery(document).find('#shipmentStatus').val(),
                                d.labelShipmentMethod = jQuery(document).find('#shipmentLabelService').val(),
                                d.trackingNumber = jQuery(document).find('#shipmentTrackingNumber').val(),
                                d.labelGenerationAfter = jQuery(document).find('#labelGenerationAfter').val(),
                                d.labelGenerationBefore = jQuery(document).find('#labelGenerationBefore').val(),
                                d.shipmentCreatedAfter = jQuery(document).find('#shipmentCreatedAfter').val(),
                                d.shipmentCreatedBefore = jQuery(document).find('#shipmentCreatedBefore').val(),
                                d.shipmentRefunedStatus = jQuery(document).find('#shipmentRefunedStatus').val()

                            //  d.contact_request = 1
                        },
                        "complete": function(response) {
                            jQuery('.loading-sbr').hide();
                        }

                    }
                });
                */
            });
            jQuery(document).on('click', '#searchByFilters', function(e) {
                jQuery('.loading-sbr').show();
                datatable.ajax.reload();
            });

            jQuery('body').on('click', '#getRefundPostage', function(e) {

                e.preventDefault();
                var shipmentids_arr = [];
                // Read all checked checkboxes
                jQuery('body').find(".shipment_entry").each(function() {

                    if (jQuery(this).is(':checked')) {
                        shipmentids_arr.push(jQuery(this).val());
                    }
                });
                // Check checkbox checked or not
                if (shipmentids_arr.length > 0) {

                    // Confirm alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Submit postage refund requests to easypost.You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Create Request',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch('<?php echo admin_url('admin-ajax.php?action=easyPostPostageRefund'); ?>', {
                                method: 'POST',
                                body: JSON.stringify({
                                    shipmentIds: shipmentids_arr
                                })
                            }).then(response => {
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
                        if (result.value.code != 1 && result.value.code != 5) {
                            Swal.fire({
                                icon: 'info',
                                html: result.value.msg
                            });
                        } else if (result.value.code == 1) {

                            Swal.fire({
                                icon: 'success',
                                html: result.value.msg
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: result.value.msg
                            });
                        }
                        datatable.ajax.reload();
                        jQuery('.shipment_entry').prop('checked', false);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Please select shipments for submit postage refund requests to easypost.'
                    });
                }
            });
            // Delete record
            jQuery('body').on('click', '#generateManifestScanForm', function(e) {

                var shipmentids_arr = [];
                // Read all checked checkboxes
                jQuery('body').find(".shipment_entry").each(function() {

                    if (jQuery(this).is(':checked')) {
                        shipmentids_arr.push({
                            carrier: jQuery(this).attr('carrier'),
                            id: jQuery(this).val()
                        });
                        // shipmentids_arr.push(jQuery(this).val());
                    }
                });
                // Check checkbox checked or not
                if (shipmentids_arr.length > 0) {

                    // Confirm alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Generate manifest for selected shipment .You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Create'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery.ajax({
                                url: "<?php echo admin_url('admin-ajax.php?action=generateEasyPostManifest'); ?>",
                                type: 'POST',
                                dataType: 'JSON',
                                async: true,
                                data: {
                                    shipment_request: 2,
                                    shipmentIds: shipmentids_arr
                                },
                                success: function(response) {
                                    if (response.code == 'failed') {
                                        Swal.fire({
                                            icon: 'info',
                                            text: response.msg
                                        });
                                    } else if (response.code == 'success') {
                                        //
                                        Swal.fire({
                                            icon: 'success',
                                            text: response.msg
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            text: response.msg
                                        });
                                    }
                                    datatable.ajax.reload();
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Please select shipments for generate manifest.'
                    });
                }
            });
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
        </script>
    <?php
}

function addEasyPostManifestDB($data = array())
{
    global $wpdb;
    $wpdb->insert(SB_EASYPOST_BATCH_TABLE, $data);
    return $wpdb->insert_id;
}

function updateEasyPostManifestDB($update, $condition)
{
    global $wpdb;
    $wpdb->update(SB_EASYPOST_BATCH_TABLE, $update, $condition);
}

function updateEasyPostShipmentDB($update, $condition)
{
    global $wpdb;
    $wpdb->update(SB_EASYPOST_TABLE, $update, $condition);
}

add_filter('wp_ajax_printEasyPostManifest', 'printEasyPostManifest_callback');

function printEasyPostManifest_callback()
{
    global $wpdb;
    $response = array();
    $batchId = $_REQUEST['batchId'];
    //create our easy post batch
    try {
        //include easypost library
        require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
        $GLOBALS['easyPostBatch'] = $client->batch->retrieve($batchId);
        if ($GLOBALS['easyPostBatch']->id != "") {
            //if we have a scan form
            if ($GLOBALS['easyPostBatch']->scan_form->form_url != "") {
                //view or print
                $logs_dir = $_SERVER['DOCUMENT_ROOT'] . "/downloads/batch/";
                $randomFileName = $batchId . ".pdf";
            } else {
                $response = array(
                    'msg' => "It appears that the scanform has not been created yet, or there was an error during its creation.  Please try again in a minute or so.  Let the administrator know if the problem persists.",
                    'code' => 'error'
                );
                echo json_encode($response);
                die();
            }
        }
    } catch (Exception $e) {
        $response = array(
            'msg' => "An error was returned from our easypost service, please show this to the administrator:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>",
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    }
    die;
}

add_filter('wp_ajax_generateEasyPostManifest', 'generateEasyPostManifest_callback');

function generateEasyPostManifest_callback()
{

    global $wpdb;
    $response = array();
    if (isset($_REQUEST['screen']) && $_REQUEST['screen'] == 'log') {
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
            $query = "SELECT easyPostShipmentId , easyPostLabelCarrier FROM  " . SB_EASYPOST_TABLE . " as se";
            $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
            $query .= " WHERE batchIdShipment = 0 AND  print_request_id = " . $request_id;
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
            /*
            $query = "SELECT easyPostShipmentId FROM  " . SB_EASYPOST_TABLE . " as se";
            $query .= " JOIN " . SB_PRINT_REQUESTS_ORDER_TABLE . " as pl ON pl.shipment_id=se.shipment_id";
            $query .= " WHERE batchIdShipment = 0 AND  print_request_id = " . $request_id;
            $easypostShipments = $wpdb->get_col($query);
            if (count($easypostShipments) > 0) {
                addEasyPostManifestRequest($easypostShipments);
            } else {
                $response = array(
                    'msg' => 'No order found aginst selected request ID',
                    'code' => 'error'
                );
                echo json_encode($response);
                die();
            }
            */
        }
    } else {
        if (isset($_REQUEST['shipmentIds']) && is_array($_REQUEST['shipmentIds']) && count($_REQUEST['shipmentIds']) > 0) {
            $services = array();
            $easypostShipmentIds = array();
            foreach ($_REQUEST['shipmentIds'] as  $shipmentEntry) {

                /// $services[$shipmentEntry['carrier']] = $shipmentEntry['carrier'];
                if (!in_array($shipmentEntry['carrier'], $services)) {
                    $services[] = $shipmentEntry['carrier'];
                }
                $easypostShipmentIds[] = $shipmentEntry['id'];
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
            /// addEasyPostManifestRequest($_REQUEST['shipmentIds']);
        } else {
            $response = array(
                'msg' => 'No shipments were posted to the batch creation page',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
        /*
        if (isset($_REQUEST['shipmentIds']) && is_array($_REQUEST['shipmentIds']) && count($_REQUEST['shipmentIds']) > 0) {
            //addEasyPostManifestRequest($_REQUEST['shipmentIds']);
        } else {
            $response = array(
                'msg' => 'No shipments were posted to the batch creation page',
                'code' => 'error'
            );
            echo json_encode($response);
            die();
        }
        */
    }
}

function addEasyPostManifestRequest($easypostShipments, $batchCarrier = 'USPS')
{
    global $wpdb;
    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
    
    $response = array();
    $data = array(
        "createdBy" => get_current_user_id(),
        "batchCarrier" => $batchCarrier,
        "shipmentCount" => 0,
        "easyPostBatchId" => '',
    );

    $batchId = addEasyPostManifestDB($data);
    if (!($batchId > 0)) {
        $response = array(
            'msg' => 'An error occured while trying to insert the batch.',
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    }

    //create our easy post batch
    try {
        $batch = $client->batch->create();        
        if ( $batch->id != "") {
            $update = array(
                'easyPostBatchId' => $batch->id
            );
            $condition = array(
                'batchId' => $batchId
            );
            updateEasyPostManifestDB($update, $condition);
        }
    }catch (Exception $e) {
        $response = array(
            'msg' => "An error was returned from our easypost service, please show this to the administrator:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>",
            'code' => 'error'
        );
        echo json_encode($response);
        die();
    }

    $shipmentCount = 0;
    $shipments_ids = array_map(function($shipment_id) {
        return ['id' => $shipment_id];
    }, $easypostShipments);
    
    try {
        $shipmentCount = count($easypostShipments);
        $updates = array_map(function($shipment_id) use ($batchId) {
            return [
                'batchIdShipment' => $batchId,
                'easyPostShipmentId' => $shipment_id,
            ];
        }, $easypostShipments);
    
        // Update the database once with all the shipments
        foreach ($updates as $update) {
            $condition = ['easyPostShipmentId' => $update['easyPostShipmentId']];
            updateEasyPostShipmentDB(['batchIdShipment' => $batchId], $condition);
        }
    }
    catch (Exception $e) {
        echo 'Error processing shipments: ' . $e->getMessage();
    }
    
     try {
        $client->batch->addShipments($batch->id,array('shipments' => $shipments_ids));
        $scanForm = $client->scanForm->create([
            'shipments' => $shipments_ids
        ]);
    
        // Check if the scan form was created successfully
        if ($scanForm->status == 'created') {
            $formUrl = $scanForm->form_url;
            $trackingCodes = $scanForm->tracking_codes;
            $confirmation = $scanForm->confirmation;
    
            $response = array(
                'msg' => 'Manifest created successfully.',
                'code' => 'success',
                'form_url' => $formUrl,
                'tracking_codes' => $trackingCodes,
                'confirmation' => $confirmation
            );

            $wpdb->update(
                'sb_shipment_batch',   // Table name
                array(
                    'formUrl' => $formUrl,
                    'shipmentCount' => $shipmentCount // WordPress helper function to get current time
                ),
                array('batchId' => $batchId),  // WHERE clause
                array('%s', '%s'),  // Data format for the updated values
                array('%d')  // Data format for the WHERE clause
            );

        } else {
            $response = array(
                'msg' => 'Failed to create scan form.',
                'code' => 'failed'
            );
        }
    } catch (Exception $e) {
        $response = array(
            'msg' => "Error creating scan form: " . $e->getMessage(),
            'code' => 'failed'
        );
    }
    
    // Return the response as JSON
    echo json_encode($response);
    die();
    
}

add_filter('wp_ajax_easypostBatch_datatable', 'easypostBatch_datatable_callback');

function easypostBatch_datatable_callback()
{
    global $wpdb;
    if (!empty($_GET)) {
        //        echo '<pre>';
        //        print_r($_GET);
        //        echo '</pre>';
        $orderByColumnIndex = 0;
        // $orderBy = 'desc';
        /* SEARCH CASE : Filtered data */
        /* Useful $_REQUEST Variables coming from the plugin */
        $draw = $_GET["draw"]; //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'DESC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        $searchQuery = " ";
        $searchDateQuery = " ";
        if (!empty($_GET['search']['value'])) {
        }

        if (isset($_REQUEST['shipmentMethod']) && $_REQUEST['shipmentMethod'] <> '') {
            $searchQuery .= " and (batchCarrier = '" . $_REQUEST['shipmentMethod'] . "') ";
        }

        if ($_REQUEST['batchCreatedAfter'] <> '' && $_REQUEST['batchCreatedBefore'] <> '') {
            $searchQuery .= " and (createdByDate BETWEEN '" . $_REQUEST['batchCreatedAfter'] . " 00:00:00' AND '" . $_REQUEST['batchCreatedBefore'] . " 23:59:59') ";
        } else if ($_REQUEST['batchCreatedAfter'] <> '') {
            $searchQuery .= " and (createdByDate >= '" . $_REQUEST['batchCreatedAfter'] . " 00:00:00') ";
        } else if ($_REQUEST['batchCreatedBefore'] <> '') {
            $searchQuery .= " and (createdByDate <= '" . $_REQUEST['batchCreatedBefore'] . " 23:59:59') ";
        }


        $keyCol = 'batchId';
        $q1 = "SELECT * FROM  " . SB_EASYPOST_BATCH_TABLE;
        $q1 .= " WHERE 1 " . $searchQuery;
        $q1 .= " ORDER BY $keyCol $orderType LIMIT $start, $length";
        $data = $wpdb->get_results($q1);

        $modified_data = array();
        foreach ($data as $key => $batch) {
            $user_info = get_userdata($batch->createdBy);
            $username = $user_info->user_login;
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            $entryData = array(
                $batch->batchId,
                $batch->batchCarrier,
                $batch->easyPostBatchId,
                $batch->shipmentCount,
            );
            if ($batch->formUrl) {
                $actionMode = add_query_arg(
                    array(
                        'action' => 'printEasyPostManifest',
                        'batchId' => $batch->easyPostBatchId,
                    ),
                    admin_url('admin-ajax.php')
                );
                $pb = add_query_arg(
                    array(
                        'id' => $batch->easyPostBatchId,
                        'type' => 'batch',
                    ),
                    site_url('print.php')
                );
                $entryData[] = '<a href="' . $batch->formUrl . '" target="_blank" class="viewBatch button button-small" >View</a>&nbsp;&nbsp;<a href="' . $pb . '"  class="button button-small">Print</a>';
            } else {
                $entryData[] = 'N/A';
            }

            $entryData[] = $first_name . ' ' . $last_name;

            $date = new DateTime($batch->createdByDate);
           // $date->modify('-5 hours');
            $formattedDate = $date->format('Y-m-d H:i:s');


            /*
 $modified_date = date("Y-m-d H:i:s", strtotime($batch->created_date . " +5 hours")); 
           $entryData[] = sbr_datetime($modified_date);
            */
            $entryData[] = sbr_datetime($formattedDate);
            /*
                  $modified_data[] = array(
                  $batch->batchId,
                  $batch->batchCarrier,
                  $batch->easyPostBatchId,
                  $batch->shipmentCount,
                  '<a href="javascript:;" class="viewBatch" >View</a>
                  &nbsp;&nbsp;
                  <a href="javascript:;" custom_url="'.$actionMode.'" class="printBatchPage">Print</a>',
                  //$batch->formUrl,
                  $first_name. ' '. $last_name,
                  date("Y-m-d" , strtotime($batch->createdByDate)),
                  );
                 */
            $modified_data[] = $entryData;
        }
        $q_count = "SELECT COUNT(*) FROM  " . SB_EASYPOST_BATCH_TABLE;
        $q_count .= " WHERE 1 " . $searchQuery;
        $q_count .= " " . $searchDateQuery;
        $recordsTotal = $wpdb->get_var($q_count);
        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsTotal,
            "data" => $modified_data
        );
        echo json_encode($results);
    }
    die;
}

add_filter('wp_ajax_easypostShipment_datatable', 'easypostShipment_datatable_callback');

function easypostShipment_datatable_callback()
{
    global $wpdb;
    if (!empty($_GET)) {
        //        echo '<pre>';
        //        print_r($_GET);
        //        echo '</pre>';
        $orderByColumnIndex = 0;
        // $orderBy = 'desc';
        /* SEARCH CASE : Filtered data */
        /* Useful $_REQUEST Variables coming from the plugin */
        $draw = $_GET["draw"]; //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'DESC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        $searchQuery = " ";
        $searchDateQuery = " ";
        if (!empty($_GET['search']['value'])) {
        }

        if (isset($_REQUEST['shipmentStatus']) && $_REQUEST['shipmentStatus'] <> '') {
            $searchQuery .= " and (shipmentStatus = '" . $_REQUEST['shipmentStatus'] . "') ";
        }
        if (isset($_REQUEST['carrier']) && $_REQUEST['carrier'] <> '') {
            $searchQuery .= " and (easyPostLabelCarrier = '" . $_REQUEST['carrier'] . "') ";
        }

        if (isset($_REQUEST['labelShipmentMethod']) && $_REQUEST['labelShipmentMethod'] <> '') {
            $searchQuery .= " and (easyPostLabelService = '" . $_REQUEST['labelShipmentMethod'] . "') ";
        }
        if (isset($_REQUEST['shipmentRefunedStatus']) && $_REQUEST['shipmentRefunedStatus'] <> '') {
            $searchQuery .= " and (shipmentState = '" . $_REQUEST['shipmentRefunedStatus'] . "') ";
        }

        if (isset($_REQUEST['trackingNumber']) && $_REQUEST['trackingNumber'] <> '') {
            $trackingNumbers = preg_replace('/\s+/', '', $_REQUEST['trackingNumber']);
            $trackingNumbers = explode(",", $trackingNumbers);
            $trackingNumbers = "'" . implode("','", $trackingNumbers) . "'";
            $searchQuery .= " and (trackingCode IN (" . @trim($trackingNumbers) . ")) ";
        }

        if ($_REQUEST['labelGenerationAfter'] <> '' && $_REQUEST['labelGenerationBefore'] <> '') {
            $searchQuery .= " and (easyPostLabelDate BETWEEN '" . $_REQUEST['labelGenerationAfter'] . "' AND '" . $_REQUEST['labelGenerationBefore'] . "') ";
        } else if ($_REQUEST['labelGenerationAfter'] <> '') {
            $searchQuery .= " and (easyPostLabelDate >= '" . $_REQUEST['labelGenerationAfter'] . "') ";
        } else if ($_REQUEST['labelGenerationBefore'] <> '') {
            $searchQuery .= " and (easyPostLabelDate <= '" . $_REQUEST['labelGenerationBefore'] . "') ";
        }

        if ($_REQUEST['shipmentCreatedAfter'] <> '' && $_REQUEST['shipmentCreatedBefore'] <> '') {
            $searchQuery .= " and (shipmentDate BETWEEN '" . $_REQUEST['shipmentCreatedAfter'] . " 00:00:00' AND '" . $_REQUEST['shipmentCreatedBefore'] . " 23:59:59') ";
        } else if ($_REQUEST['shipmentCreatedAfter'] <> '') {
            $searchQuery .= " and (shipmentDate >= '" . $_REQUEST['shipmentCreatedAfter'] . " 00:00:00') ";
        } else if ($_REQUEST['shipmentCreatedBefore'] <> '') {
            $searchQuery .= " and (shipmentDate <= '" . $_REQUEST['shipmentCreatedBefore'] . " 23:59:59') ";
        }



        if (isset($_REQUEST['source']) && $_REQUEST['source'] == 'order_page' && $_REQUEST['order_id'] <> '') {
            $q_s = "SELECT shipment_id FROM  " . SB_SHIPMENT_ORDERS_TABLE;
            $q_s .= " WHERE order_id = '" . $_REQUEST['order_id'] . "' ";
            $data_s = $wpdb->get_col($q_s);

            if ($data_s) {
                $searchQuery .= " and shipment_id IN (" . implode(',', $data_s) . ") ";
            } else {
                $searchQuery .= " and shipment_id = '0' ";
            }
        }

        $keyCol = 'shipment_id';
        $q1 = "SELECT * FROM  " . SB_EASYPOST_TABLE;
        $q1 .= " WHERE 1 " . $searchQuery;
        if (isset($_REQUEST['export']) && $_REQUEST['export'] == 'yes') {
            $q1 .= " ORDER BY $keyCol $orderType";
        } else {
            $q1 .= " ORDER BY $keyCol $orderType LIMIT $start, $length";
        }
        $data = $wpdb->get_results($q1);

        $modified_data = array();
        foreach ($data as $key => $shipment) {

            $entry = array();
            $exportFlag = true;
            if (isset($_REQUEST['export']) && $_REQUEST['export'] == 'yes') {
                $exportFlag = false;
            }
            if ($exportFlag) {

                if ($shipment->shiptoCountry == 'US') {
                    $type = 'Domestic';
                } else {
                    $type = 'International';
                }
                $status = getEasypostShipmentStatus($shipment->shipmentStatus);

                $pp = add_query_arg(
                    array(
                        'id' => $shipment->trackingCode,
                        'type' => 'label',
                    ),
                    site_url('print.php')
                );

                $batchShipment = '';
                $batchPrinted = false;
                if ($shipment->batchIdShipment) {
                    $q1 = "SELECT * FROM  " . SB_EASYPOST_BATCH_TABLE;
                    $q1 .= " WHERE batchId = " . $shipment->batchIdShipment;
                    $batch = $wpdb->get_row($q1);
                    if ($batch->formUrl) {
                        $actionMode = add_query_arg(
                            array(
                                'action' => 'printEasyPostManifest',
                                'batchId' => $batch->easyPostBatchId,
                            ),
                            admin_url('admin-ajax.php')
                        );
                        $pb = add_query_arg(
                            array(
                                'id' => $batch->easyPostBatchId,
                                'type' => 'batch',
                            ),
                            site_url('print.php')
                        );
                        $batchPrinted = true;
                        $batchShipment = '<a href="' . $batch->formUrl . '" target="_blank" class="viewBatch" >View</a>&nbsp;&nbsp;<a href="' . $pb . '"  class="">Print</a>';
                    } else {
                        $batchShipment = 'N/A';
                    }
                } else {
                    $batchShipment = 'N/A';
                }
                if (!empty($shipment->easyPostShipmentId)) {


                    $q_s = "SELECT * FROM  " . SB_SHIPMENT_ORDERS_TABLE;
                    $q_s .= " WHERE shipment_id = '" . $shipment->shipment_id . "' ";
                    $data_s = $wpdb->get_results($q_s);
                    $htmlReferal = '';
                    $productsPackagingHtml = '';
                    $customer_id = 0;
                    if ($data_s) {
                        $productsPackagingHtml = '<table class = "widefat order_packaging_shipments">
                        <thead>
                            <tr>
                                <th class= "sbr-products-table-name">Order</th>
                                <th class= "sbr-products-table-qty"></th>
                        </thead>
                        <tbody>';
                        foreach ($data_s as $shipment_order) {
                            $customer_id = get_post_meta($shipment_order->order_id, '_customer_user', true);
                            if (isset($_REQUEST['source']) && $_REQUEST['source'] == 'order_page' && $_REQUEST['order_id'] <> '') {

                                if ($_REQUEST['order_id'] == $shipment_order->order_id) {
                                    $htmlReferal .= '<a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $shipment_order->order_id . '&action=edit">' . $shipment_order->order_number . '</a> ';

                                    $psp = add_query_arg(
                                        array(
                                            'id' => $shipment->trackingCode . '_' . $shipment_order->order_id,
                                            'type' => 'slip',
                                        ),
                                        site_url('print.php')
                                    );
                                    $productsPackagingHtml .= '<tr>';
                                    $productsPackagingHtml .= '<td>' . $shipment_order->order_number . '</td>';
                                    $productsPackagingHtml .= '<td><a class="button button-small btn-orange" style="margin-bottom: 10px;" target="_blank" href="' . SB_DOWNLOAD . 'packages/' . $shipment->trackingCode . '_' . $shipment_order->order_id . '.pdf' . '">Package Slip</a>
                                        <a class="button button-small btn-brown" style="margin-bottom: 10px;" target="_blank" href="' . $psp . '">Print Package Slip</a></td>';

                                    $productsPackagingHtml .= '</tr>';
                                }
                            } else {
                                $htmlReferal .= '<a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $shipment_order->order_id . '&action=edit">' . $shipment_order->order_number . '</a> ';

                                $psp = add_query_arg(
                                    array(
                                        'id' => $shipment->trackingCode . '_' . $shipment_order->order_id,
                                        'type' => 'slip',
                                    ),
                                    site_url('print.php')
                                );
                                $productsPackagingHtml .= '<tr>';
                                $productsPackagingHtml .= '<td>' . $shipment_order->order_number . '</td>';
                                $productsPackagingHtml .= '<td><a class="button button-small btn-orange" style="margin-bottom: 10px;" target="_blank" href="' . SB_DOWNLOAD . 'packages/' . $shipment->trackingCode . '_' . $shipment_order->order_id . '.pdf' . '">Package Slip</a>
                                    <a class="button button-small btn-brown" style="margin-bottom: 10px;" target="_blank" href="' . $psp . '">Print Package Slip</a></td>';

                                $productsPackagingHtml .= '</tr>';
                            }
                        }
                        $productsPackagingHtml .= '</tbody></table>';
                    }
                } else {
                    // $productsPackagingHtml = 'N/A';
                }




                if (isset($_REQUEST['source']) && $_REQUEST['source'] == 'order_page' && $_REQUEST['order_id'] <> '') {
                    $entry[] = $shipment->shipment_id;
                    $entry[] = $type;
                    $entry[] = $shipment->easyPostLabelCarrier;
                    $shipping_method = getShippingMethod($shipment->easyPostLabelCarrier, $shipment->easyPostLabelService);
                    if (empty($shipping_method)) {
                        $shipping_method = $shipment->easyPostLabelService;
                    }
                    $entry[] = $shipping_method;
                    // $entry[] = '<a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $shipment->order_id . '&action=edit">' . $shipment->reference . '</a>';
                    //$entry[] = '<a  target="_blank" href="' . admin_url('?page=customer_history&customer_id=' . $customer_id) . '">' . $shipment->shiptoFirstName . ' ' . $shipment->shiptoLastName . '</a>';
                } else {
                    if ($shipment->shipmentState == 'Refunded-Success') {
                        $entry[] = '#' . $shipment->shipment_id;
                    } else {
                        if ($batchPrinted) {
                            $entry[] = '#' . $shipment->shipment_id;
                        } else {
                            $entry[] = '<div class="custom-control custom-checkbox">
                               #' . $shipment->shipment_id . '
                    <input type="checkbox" class="shipment_entry custom-control-input" carrier="' . $shipment->easyPostLabelCarrier . '" value="' . $shipment->easyPostShipmentId . '" id="shipment_val_' . $shipment->shipment_id . '">
                    <label class="custom-control-label" for="shipment_val_' . $shipment->shipment_id . '"></label>
                      
                </div>';
                        }
                    }

                    // $entry[] = ;
                    $entry[] = $type;
                    $entry[] = $shipment->easyPostLabelCarrier;
                    //$entry[] = getShippingMethod($shipment->easyPostLabelCarrier, $shipment->easyPostLabelService);
                    $shipping_method = getShippingMethod($shipment->easyPostLabelCarrier, $shipment->easyPostLabelService);
                    if (empty($shipping_method)) {
                        $shipping_method = $shipment->easyPostLabelService;
                    }
                    $entry[] = $shipping_method;
                    $entry[] = $htmlReferal;
                    if (empty($customer_id)) {
                        $entry[] = $shipment->shiptoFirstName . ' ' . $shipment->shiptoLastName;
                    } else {
                        $entry[] = '<a  target="_blank" href="' . admin_url('?page=customer_history&customer_id=' . $customer_id) . '">' . $shipment->shiptoFirstName . ' ' . $shipment->shiptoLastName . '</a>';
                    }
                }

                $entry[] = '<span class="date-shipped"> ' . sbr_date($shipment->shipmentDate) . "</span>";
                $entry[] = '<span class="date-label"> ' . sbr_date($shipment->easyPostLabelDate) . "</span>";

                if (!empty($shipment->easyPostShipmentTrackingUrl)) {
                    $entry[] = '<a target="_blank" href="' . $shipment->easyPostShipmentTrackingUrl . '">' . $shipment->trackingCode . '</a>';
                } else {
                    $entry[] = '<a target="_blank" href="javascript:;">' . $shipment->trackingCode . '</a>';
                }
                if ($shipment->shipmentState != '') {
                    $entry[] = '<span class="shipment_status ' . $shipment->shipmentState . '">' . $shipment->shipmentState . '</span><span class="shipment_status status-' . $shipment->shipmentStatus . '">' . $status . '</span>';
                } else {
                    $entry[] = '<span class="shipment_status status-' . $shipment->shipmentStatus . '">' . $status . '</span>';
                }
                if ($shipment->estDeliveryDate == '0000-00-00 00:00:00') {
                    $entry[] = 'N/A';
                } else {
                    $entry[] = sbr_date($shipment->estDeliveryDate);
                }
                if ($shipment->actualDeliveryDate == '0000-00-00 00:00:00') {
                    $entry[] = 'N/A';
                } else {
                    $entry[] = sbr_date($shipment->actualDeliveryDate);
                }

                //    $entry[] = sbr_date($shipment->actualDeliveryDate);
                //  $entry[] = $shipment->estDeliveryDate;
                //  $entry[] = $shipment->actualDeliveryDate;
                $entry[] = $shipment->shipmentCost . ' USD';
                $entry[] = $shipment->packageWeight;
                $entry[] = $batchShipment;
                $productsHtml = '';
                if (!empty($shipment->easyPostShipmentId)) {
                    if ($shipment->productsWithQty) {
                        $productsHtml = '<table class = "widefat">
                <thead>
                    <tr>
                        <th class= "sbr-products-table-name">Product</th>
                        <th class= "sbr-products-table-qty">Qty</th>
                </thead>
                <tbody>';
                        $products = json_decode($shipment->productsWithQty, true);
                        foreach ($products as $item) {
                            $productsHtml .= '<tr>';
                            $productsHtml .= '<td>' . get_the_title($item['product_id']) . '</td>';
                            if ($item['type'] == 'composite') {
                                if (isset($item['fweight'])) {
                                    if ($item['qty'] == 1) {
                                        $productsHtml .= '<td>1st Shipment</td>';
                                    } else {
                                        $productsHtml .= '<td>2nd Shipment</td>';
                                    }
                                } else {
                                    if ($item['shipment'] == 1) {
                                        $productsHtml .= '<td>1st Shipment</td>';
                                    } else {
                                        $productsHtml .= '<td>2nd Shipment</td>';
                                    }
                                }
                            } else {
                                $productsHtml .= '<td>' . $item['qty'] . '</td>';
                            }
                            $productsHtml .= '</tr>';
                        }
                        $productsHtml .= '</tbody></table>';
                    }
                } else {
                    $productsHtml = 'N/A';
                }
                $entry[] = $productsHtml;
                // <a class="button button-small btn-orange" style="margin-bottom: 10px;" target="_blank" href="' . SB_DOWNLOAD . 'packages/' . $shipment->trackingCode . '.pdf' . '">Package Slip</a>
                // <a class="button button-small btn-brown" style="margin-bottom: 10px;" target="_blank" href="' . $psp . '">Print Package Slip</a>
                if (!empty($shipment->easyPostShipmentId)) {
                    $entry[] = $productsPackagingHtml . ' <a class="button button-small btn-blue" style="margin-bottom: 10px;" target="_blank" href="' . SB_DOWNLOAD . 'labels/' . $shipment->trackingCode . '.png' . '">Shipping Label</a>
                 <a class="button button-small btn-red" style="margin-bottom: 10px;" target="_blank" href="' . $pp . '">Print Label</a>
                 <a class="button button-small btn-green" style="margin-bottom: 10px;" target="_blank" href="' . $shipment->easyPostShipmentTrackingUrl . '">Track Shipment</a>
                 <a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=shipment_info&shipment_id=' . $shipment->shipment_id) . '">View Detail</a>';
                } else {
                    $entry[] = $productsPackagingHtml . '<a class="button button-small btn-yellow " style="margin-bottom: 10px;" target="_blank" href="' . admin_url('admin.php?page=shipment_info&shipment_id=' . $shipment->shipment_id) . '">View Detail</a>';
                }
            } else {
                $entry[] = '';
                $entry[] = '';
                $entry[] = $shipment->easyPostLabelCarrier;
                $shipping_method = getShippingMethod($shipment->easyPostLabelCarrier, $shipment->easyPostLabelService);
                if (empty($shipping_method)) {
                    $shipping_method = $shipment->easyPostLabelService;
                }
                $entry[] = $shipping_method;

                $htmlReferal = '';
                if (!empty($shipment->easyPostShipmentId)) {
                    $q_s = "SELECT order_number FROM  " . SB_SHIPMENT_ORDERS_TABLE;
                    $q_s .= " WHERE shipment_id = '" . $shipment->shipment_id . "' ";
                    $data_s = $wpdb->get_col($q_s);
                    if ($data_s) {
                        $htmlReferal = implode(', ', $data_s);
                    }
                }

                $entry[] = $htmlReferal;
                $entry[] = '';
                $entry[] = '';
                $entry[] = '';
                if (!empty($shipment->easyPostShipmentTrackingUrl)) {
                    $entry[] = '<a target="_blank" href="' . $shipment->easyPostShipmentTrackingUrl . '">' . $shipment->trackingCode . '</a>';
                } else {
                    $entry[] = '<a target="_blank" href="javascript:;">' . $shipment->trackingCode . '</a>';
                }



                $entry[] = '';
                $entry[] = '';
                $entry[] = '';

                $entry[] = $shipment->shipmentCost;
                $entry[] = number_format($shipment->packageWeight, 2);
                $entry[] = '';

                $productsHtml = '';
                if ($shipment->productsWithQty) {
                    $products = json_decode($shipment->productsWithQty, true);
                    $productsIds = array();
                    foreach ($products as $item) {

                        $productsIds[] = $item['product_id'];
                    }
                    $productsHtml = implode(', ', $productsIds);
                }

                $entry[] = $productsHtml;
                $entry[] = '';
            }
            $modified_data[] = $entry;
        }
        $q_count = "SELECT COUNT(*) FROM  " . SB_EASYPOST_TABLE;
        $q_count .= " WHERE 1 " . $searchQuery;
        $q_count .= " " . $searchDateQuery;
        $recordsTotal = $wpdb->get_var($q_count);
        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsTotal,
            "data" => $modified_data
        );
        echo json_encode($results);
    }
    die;
}

function easypostShipmentAddresses($order_id, $shipping_postcode)
{
    global $wpdb;
    $query = "SELECT * FROM  " . SB_EASYPOST_TABLE . " as se";
    $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as so ON se.shipment_id=so.shipment_id";
    $query .= " WHERE order_id = " . $order_id . " AND shiptoPostalCode != '" . $shipping_postcode . "'";
    //echo $query;
    return $wpdb->get_results($query);
}

function getShippingMethod($service, $method)
{
    $defind_methods = array(
        'USPS' => array(
            'First' => 'First',
            'Priority' => 'Priority',
            'Express' => 'Express',
            'ParcelSelect' => 'Parcel Select',
            'LibraryMail' => 'Library Mail',
            'MediaMail' => 'Media Mail',
            'FirstClassMailInternational' => 'First Class Mail International',
            'FirstClassPackageInternationalService' => 'First Class Package International Service',
            'PriorityMailInternational' => 'Priority Mail International',
            'ExpressMailInternational' => 'Express Mail International',
        ),
    );

    if (isset($defind_methods[$service]) && isset($defind_methods[$service][$method])) {
        return $defind_methods[$service][$method];
    } else {
        return false;
    }
}

function getEasypostShipmentStatus($code)
{
    $shipmentStatus = array(
        "pre_transit" => "Pre transit",
        "in_transit" => "In transit",
        "out_for_delivery" => "Out for delivery",
        "delivered" => "Delivered",
        "available_for_pickup" => "Available for pickup",
        "return_to_sender" => "Return to sender",
        "failure" => "Failure",
        "cancelled" => "Cancelled",
        "error" => "Error",
    );
    if (isset($shipmentStatus[$code])) {
        return $shipmentStatus[$code];
    } else {
        return '--';
    }
}

function sbr_productSaleManagementbk()
{
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    ?>


        <div class="search-shipement">
            <h3>Sale management<span class="dashicons dashicons-cart"></span> </h3>
        </div>
        <div class="loading-sbr" style="display: none;">
            <div class="inner-sbr"></div>
        </div>
        <form id="saleManagement">
            <!--            <input type="button" id="btnProductSale" class="button" value="Save Changes">-->

            <table id="sale" class="data-table" style="width:99%">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product name</th>
                        <th>Product price</th>
                        <th>
                            Sale price
                            <!--                            <br />
                                                        <br />
                                                        <input type="button" id="datatableCheckAllSale" class="button" value="Reset all sale prices">-->

                        </th>
                        <th>
                            <div class="custom-control custom-checkbox">
                                <input id="datatableCheckAll" type="checkbox" class="custom-control-input" autocomplete="off">
                                <label class="custom-control-label" for="datatableCheckAll">Disabled for all coupons</label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tax_query = array(
                        'relation' => 'AND'
                    );

                    $tax_query[] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array('raw', 'packaging', 'landing-page', 'data-only', 'addon'),
                        'operator' => 'NOT IN',
                    );

                    $tax_query[] = array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'composite',
                    );

                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'fields' => 'ids',
                        'tax_query' => $tax_query,
                    );

                    $compositePrdoucts = get_posts($args);
                    foreach ($compositePrdoucts as $product_id) {
                        $productObj = wc_get_product($product_id);
                        $title = '<a href="' . get_edit_post_link($product_id) . '" target="_blank">' . $productObj->get_title() . '</a>';
                    ?>
                        <tr>
                            <td><?php echo $productObj->get_id(); ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $productObj->get_price_html(); ?></td>
                            <td><input autocomplete="off" class="product_sale_entry" type="number" name="salePrice[<?php echo $product_id; ?>]" value="<?php echo number_format($productObj->get_sale_price(), 2); ?>" /></td>
                            <td>
                                <?php
                                $checked = '';
                                $disabled_for_coupons = $productObj->get_meta('_disabled_for_coupons');
                                if ($disabled_for_coupons === 'yes') {
                                    $checked = 'checked=""';
                                }
                                ?>
                                <input autocomplete="off" type="checkbox" class="product_entry" <?php echo $checked; ?> name="disabled_for_coupons[<?php echo $product_id; ?>]" />
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
            <input type="hidden" name="action" value="saveSaleManagement">

        </form>
        <style>
            .shipment-inner-container {
                display: none;
            }

            table.dataTable tbody tr {
                background-color: #fff;
                text-align: center;
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                // Check all 

                jQuery('#datatableCheckAllSale').click(function() {
                    console.log('datatableCheckAllSale')
                    jQuery('.product_sale_entry').val('');
                });
                jQuery('#datatableCheckAll').click(function() {
                    if (jQuery(this).is(':checked')) {
                        jQuery('.product_entry').prop('checked', true);
                    } else {
                        jQuery('.product_entry').prop('checked', false);
                    }
                });
                jQuery(document).on('change', '.product_entry', function(e) {
                    checkcheckbox();
                });
                // Checkbox checked
                function checkcheckbox() {
                    // Total checked checkboxes
                    var totalchecked = 0;
                    jQuery('.product_entry').each(function() {
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
                jQuery('#sale').DataTable({
                    "ordering": false,
                    "searching": true,
                    "bPaginate": false,
                });
                jQuery("body").on('click', '#btnProductSale', (function(e) {


                    var swaltext = 'Please make sure everything before save sale prices and coupon options.';
                    Swal.fire({
                        title: 'Are you sure?',
                        text: swaltext,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Save'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('.loading-sbr').show();
                            e.preventDefault();
                            var elementT = document.getElementById("saleManagement");
                            var formdata = new FormData(elementT);
                            jQuery.ajax({
                                url: ajaxurl,
                                data: formdata,
                                async: true,
                                method: 'POST',
                                dataType: 'JSON',
                                success: function(response) {

                                    jQuery('.loading-sbr').hide();
                                    Swal.fire('Updated Successfully', 'success');

                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }
                    });
                }));
            });
        </script>
    <?php
}
