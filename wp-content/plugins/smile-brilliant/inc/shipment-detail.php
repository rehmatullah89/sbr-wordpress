<?php
/**
 * Function for view shipment detail page. Admin Can review all information regarding Easypost shipment
 */
function easyPostShipmentInfo()
{
    global $wpdb;

    $shipment_id = isset($_GET['shipment_id']) ? $_GET['shipment_id'] : '';
    if ($shipment_id == '') {
        echo 'Shipment Id is empty';
    } else {
        $shipment = $wpdb->get_row("SELECT * FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $shipment_id);

        if ($shipment) {
            $customer_info = get_customer($shipment->userId);
            if ($shipment->shiptoCountry == 'US') {
                $type = 'Domestic';
            } else {
                $type = 'International';
            }
            $shipping_method = getShippingMethod($shipment->easyPostLabelCarrier, $shipment->easyPostLabelService);
            if (empty($shipping_method)) {
                $shipping_method = $shipment->easyPostLabelService;
            }
            $status = getEasypostShipmentStatus($shipment->shipmentStatus);
?>
            <div class="mbt-row inf-content">
                <div class="customer_profile_mbt main contianer">

                    <div class="row justify-content-center">

                        <?php
                        if ($shipment->easyPostLabelCarrier == 'USPS') {
                            echo '   <div class="cust_info avatar-img col-sm-2">';
                            echo '<span><img src="' . get_stylesheet_directory_uri() . '/assets/images/usps-icon.jpg" class="img-circle img-thumbnail isTooltip"></span>';
                            echo '</div>';
                        }
                        if ($shipment->easyPostLabelCarrier == 'UPS') {
                            echo '<div class="cust_info avatar-img col-sm-2">';
                            echo '<span><img src="https://assets.track.easypost.com/shared-assets/carriers/ups-logo.svg" class="img-circle img-thumbnail isTooltip"></span>';
                            echo '</div>';
                        }
                        ?>


                        <div class="info-right-br col-sm-4">
                            <h3> Carrier Information </h3>
                            <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-users"></span> Type:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $type; ?></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-cloud"></span> Carrier:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $shipment->easyPostLabelCarrier; ?></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-email"></span> Shipping Method:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $shipping_method; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-4">


                            <h3> Shipment Information </h3>
                            <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>


                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-page"></span> Date Shipped:</strong>
                                            </td>
                                            <td class="text-primary">
                                                <?php echo sbr_datetime($shipment->shipmentDate); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-post"></span> Label Date:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo sbr_datetime($shipment->easyPostLabelDate); ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-columns"></span> Tracking Code:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $shipment->trackingCode; ?></td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-screenoptions"></span> Status:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $status; ?></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Expected Delivery Date:</strong>
                                            </td>
                                            <td class="text-primary">
                                                <?php echo sbr_datetime($shipment->estDeliveryDate); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Actual Delivery Date:</strong>
                                            </td>
                                            <td class="text-primary">
                                                <?php echo sbr_datetime($shipment->actualDeliveryDate); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Cost:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $shipment->shipmentCost . ' USD'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Manifest:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $shipment->batchIdShipment; ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Shipment Notes:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $shipment->shipmentNotes; ?></td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if (!empty($shipment->easyPostShipmentId)) {


                                $q_s = "SELECT * FROM  " . SB_SHIPMENT_ORDERS_TABLE;
                                $q_s .= " WHERE shipment_id = '" . $shipment->shipment_id . "' ";
                                $data_s = $wpdb->get_results($q_s);
                                $htmlReferal = '';
                                $productsPackagingHtml = '';
                                if ($data_s) {
                                    $productsPackagingHtml = '<h3> Order Packaging</h3><table class = "widefat order_packaging_shipments">
                                
                                <tbody>';
                                    foreach ($data_s as $shipment_order) {

                                        //  $htmlReferal .= '<a target="_blank" href="' . get_admin_url() . 'post.php?post=' . $shipment_order->order_id . '&action=edit">' . $shipment_order->order_number . '</a> ';


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
                                    $productsPackagingHtml .= '</tbody></table>';
                                }



                                echo $productsPackagingHtml;
                            }
                            ?>
                        </div>



                        <div class="col-sm-4">
                            <div class="customer_profile_mbt shipping ">
                                <h3> Shipping Information </h3>

                                <div class="table-responsive">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-users"></span> First Name:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoFirstName; ?></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-cloud"></span> Last Name:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $shipment->shiptoLastName; ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-email"></span> Email:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoEmail; ?></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-welcome-write-blog"></span> Address 1:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoAddress; ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-welcome-write-blog"></span> Address 2:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoAptNo; ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-welcome-write-blog"></span> Company</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoCompany; ?></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-post"></span> City:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $shipment->shiptoCity; ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-columns"></span> State:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $shipment->shiptoState; ?></td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-screenoptions"></span> Postcode:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $shipment->shiptoPostalCode; ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-page"></span> Country:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo WC()->countries->countries[$shipment->shiptoCountry]; ?></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-phone"></span> Phone:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $shipment->shiptoPhone; ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <?php
                            if (!empty($shipment->easyPostShipmentId)) {
                                // $psp = add_query_arg(
                                //     array(
                                //     'id' => $shipment->trackingCode,
                                //     'type' => 'slip',
                                //         ), site_url('print.php')
                                // );
                                $pp = add_query_arg(
                                    array(
                                        'id' => $shipment->trackingCode,
                                        'type' => 'label',
                                    ),
                                    site_url('print.php')
                                );


                                $productsHtml = '';
                                if ($shipment->productsWithQty) {
                                    $productsHtml = '<h3>Shipped Products</h3><table class = "widefat">
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
                                            if ($item['shipment'] == 1) {
                                                $productsHtml .= '<td>1st Shipment</td>';
                                            } else {
                                                $productsHtml .= '<td>2nd Shipment</td>';
                                            }
                                        } else {
                                            $productsHtml .= '<td>' . $item['qty'] . '</td>';
                                        }
                                        $productsHtml .= '</tr>';
                                    }
                                    $productsHtml .= '</tbody></table><br/>';
                                }
                                echo $productsHtml;
                            ?>

                                <!-- <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php //echo SB_DOWNLOAD.'packages/'.$shipment->trackingCode.'.pdf';         
                                                                                                                        ?>">Package Slip</a> -->
                                <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $psp; ?>">Print Package Slip</a>
                                <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo SB_DOWNLOAD . 'labels/' . $shipment->trackingCode . '.png'; ?>">Shipping Label</a>
                                <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $pp; ?>">Print Label</a>
                                <a class="button button-small" style="margin-bottom: 10px;" target="_blank" href="<?php echo $shipment->easyPostShipmentTrackingUrl; ?>">Track Shipment</a>
                            <?php } ?>
                        </div>


                    </div>

                </div>
                <style>
                    .spacing-wrapper.clearfix table tr {
                        background: #f7f7f7 !important;
                        font-weight: 400 !important;
                    }

                    .customer_orders .spacing-wrapper.clearfix p {
                        display: none;
                    }

                    .customer_orders {
                        display: block;
                        clear: both;

                    }

                    .order_row {
                        display: inline-flex;
                    }

                    .order_row_info {
                        width: 220px;
                    }


                    .col,
                    .col-1,
                    .col-10,
                    .col-11,
                    .col-12,
                    .col-2,
                    .col-3,
                    .col-4,
                    .col-5,
                    .col-6,
                    .col-7,
                    .col-8,
                    .col-9,
                    .col-auto,
                    .col-lg,
                    .col-lg-1,
                    .col-lg-10,
                    .col-lg-11,
                    .col-lg-12,
                    .col-lg-2,
                    .col-lg-3,
                    .col-lg-4,
                    .col-lg-5,
                    .col-lg-6,
                    .col-lg-7,
                    .col-lg-8,
                    .col-lg-9,
                    .col-lg-auto,
                    .col-md,
                    .col-md-1,
                    .col-md-10,
                    .col-md-11,
                    .col-md-12,
                    .col-md-2,
                    .col-md-3,
                    .col-md-4,
                    .col-md-5,
                    .col-md-6,
                    .col-md-7,
                    .col-md-8,
                    .col-md-9,
                    .col-md-auto,
                    .col-sm,
                    .col-sm-1,
                    .col-sm-10,
                    .col-sm-11,
                    .col-sm-12,
                    .col-sm-2,
                    .col-sm-3,
                    .col-sm-4,
                    .col-sm-5,
                    .col-sm-6,
                    .col-sm-7,
                    .col-sm-8,
                    .col-sm-9,
                    .col-sm-auto,
                    .col-xl,
                    .col-xl-1,
                    .col-xl-10,
                    .col-xl-11,
                    .col-xl-12,
                    .col-xl-2,
                    .col-xl-3,
                    .col-xl-4,
                    .col-xl-5,
                    .col-xl-6,
                    .col-xl-7,
                    .col-xl-8,
                    .col-xl-9,
                    .col-xl-auto,
                    .container {
                        position: relative;
                        width: 100%;
                        padding-right: 15px;
                        padding-left: 15px;
                    }

                    .row {
                        display: -ms-flexbox;
                        display: flex;
                        -ms-flex-wrap: wrap;
                        flex-wrap: wrap;
                        margin-right: -15px;
                        margin-left: -15px;

                    }

                    .col {
                        -ms-flex-preferred-size: 0;
                        flex-basis: 0;
                        -ms-flex-positive: 1;
                        flex-grow: 1;
                        max-width: 100%;
                    }

                    .inf-content {
                        border: 1px solid #DDDDDD;
                        -webkit-border-radius: 10px;
                        -moz-border-radius: 10px;
                        border-radius: 6px;
                        box-shadow: 7px 7px 7px rgb(0 0 0 / 30%);
                        padding: 15px;
                        background: #fff;
                        max-width: 96%;
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .img-circle {
                        border-radius: 50%;
                    }

                    .img-thumbnail {
                        display: inline-block;
                        width: 100% \9;
                        max-width: 100%;
                        height: auto;
                        padding: 4px;
                        line-height: 1.42857143;
                        background-color: #fff;
                        border: 1px solid #ddd;
                        -webkit-transition: all .2s ease-in-out;
                        -o-transition: all .2s ease-in-out;
                        transition: all .2s ease-in-out;
                        height: 140px;
                        width: 140px;
                        max-width: 140px;
                        max-height: 140px;
                    }

                    .table {
                        width: 100%;
                        max-width: 100%;
                        margin-bottom: 20px;
                    }

                    .inf-content table {
                        background-color: transparent;
                    }

                    .inf-content table {
                        border-spacing: 0;
                        border-collapse: collapse;
                    }

                    .inf-content .table>thead>tr>th,
                    .inf-content .table>tbody>tr>th,
                    .inf-content .table>tfoot>tr>th,
                    .inf-content .table>thead>tr>td,
                    .inf-content .table>tbody>tr>td,
                    .inf-content .table>tfoot>tr>td {
                        padding: 8px;
                        line-height: 1.42857143;
                        vertical-align: top;
                        border-top: 1px solid #ddd;
                    }

                    .inf-content td.text-primary {
                        text-align: right;
                    }

                    .inf-content span.dashicons {
                        color: #428bca;

                    }

                    .inf-content .container {
                        max-width: 80%;
                    }

                    .justify-content-center {
                        -ms-flex-pack: center;
                        justify-content: center;
                    }

                    .cust_info.avatar-img {
                        text-align: center;
                    }

                    .customer_profile_mbt.main.contianer {
                        margin-bottom: 4rem;
                    }

                    .inf-content h3 {
                        text-transform: uppercase;
                    }

                    @media (min-width: 576px) {

                        .col-sm-2 {
                            -ms-flex: 0 0 16.666667%;
                            flex: 0 0 16.666667%;
                            max-width: 16.666667%;
                        }

                        .col-sm-3 {
                            -ms-flex: 0 0 25%;
                            flex: 0 0 25%;
                            max-width: 25%;
                        }

                        .col-sm-4 {
                            -ms-flex: 0 0 33.333333%;
                            flex: 0 0 33.333333%;
                            max-width: 33.333333%;
                        }

                        .col-sm-5 {
                            -ms-flex: 0 0 41.666667%;
                            flex: 0 0 41.666667%;
                            max-width: 41.666667%;
                        }

                        .col-sm-6 {
                            -ms-flex: 0 0 50%;
                            flex: 0 0 50%;
                            max-width: 50%;
                        }

                        .col-sm-7 {
                            -ms-flex: 0 0 58.333333%;
                            flex: 0 0 58.333333%;
                            max-width: 58.333333%;
                        }

                        .col-sm-8 {
                            -ms-flex: 0 0 66.666667%;
                            flex: 0 0 66.666667%;
                            max-width: 66.666667%;
                        }

                        .col-sm-9 {
                            -ms-flex: 0 0 75%;
                            flex: 0 0 75%;
                            max-width: 75%;
                        }

                    }
                </style>
    <?php
        }
    }
}
