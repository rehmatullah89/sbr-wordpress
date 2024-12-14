<?php
/**
 * Function to add JavaScript code in the admin footer.
 */
function affiliates_partener_js_code()
{

    if (isset($_REQUEST['page']) && $_REQUEST['page'] = 'affiliate-wp-affiliates') {
?>
        <script>
            jQuery('body').find('.wp-list-table.affiliates tbody#the-list tr').each(function() {
                $username = jQuery(this).find('td.username').html();
                if ($username != '') {
                    $viewHtmlUrl = '<a href="https://smilebrilliant.com/partener-history.php?username=' + $username + '" target="_blank">Old History</a>';
                    jQuery(this).find('td.viewApp').html($viewHtmlUrl);
                }

            });
        </script>
    <?php
    }
}

add_action('admin_footer', 'affiliates_partener_js_code');
add_filter('manage_affiliates_page_affiliate-wp-affiliates_columns', 'affiliates_partener_columns');
/**
 * Filter to add a custom column to the 'affiliate-wp-affiliates' admin page.
 *
 * @param array $columns An array of column names.
 * @return array Modified array of column names.
 */
function affiliates_partener_columns($columns)
{
    $columns['viewApp'] = __('View');
    return $columns;
}



add_action('woocommerce_admin_order_data_after_shipping_address', 'sbr_after_shipping_address');
/**
 * Action to display additional content after the shipping address on the WooCommerce order admin page.
 *
 * @param WC_Order $order The WooCommerce order object.
 */
function sbr_after_shipping_address($order)
{
    //echo 'Data: <pre>' .print_r($_REQUEST,true). '</pre>';
    if (isset($_REQUEST['iframe'])) {

        echo '<input type="hidden" id="iframe" name="iframe" value="yes">';
    ?>
        <style>
            #wpadminbar,
            #adminmenumain,
            #woocommerce-embedded-root,
            #screen-meta,
            #screen-meta-links {
                display: none !important;
            }

            .wp-heading-inline,
            .page-title-action,
            #woocommerce-order-notes,
            #woocommerce-order-items,
            #delete-action {
                display: none !important;
            }

            #order_data .order_data_column:first-child {
                display: none;
            }

            #order_data .order_data_column {
                width: 50%;
            }

            .notice.notice-warning,
            #vc_license-activation-notice {
                display: none !important;
            }

            #woocommerce-customer-browsing-history,
            #order-shipment,
            #order-refunds,
            #woocommerce-customer-purchase-history {
                display: none !important;
            }

            #wpcontent,
            #wpfooter,
            html.wp-toolbar {
                margin-left: 0;

            }

            html.wp-toolbar {
                margin-left: 0;
                padding-top: 0;
            }

            .order_actions #actions {
                display: none !important;
            }

            #smile_brillaint_order_modal .modal-content {
                width: 80%;
            }
        </style>
        <script>
            jQuery(document).ready(function() {
                jQuery('body').find('.edit_address').trigger('click');

            });
        </script>
    <?php
    }
}

add_action('wp_ajax_updateProductQtyForLogs', 'updateProductQtyForLogs_callback');
/**
 * AJAX action to update product quantity for order logs.
 */
function updateProductQtyForLogs_callback()
{
    global $wpdb;
    //  $oldJSON = '';
    $order_old_id = $_REQUEST['order_old_id'];
    $order_id = $_REQUEST['order_id'];
    if ($order_old_id != '') {
        /*
          $sql = "SELECT trayNumber FROM order_  AS ordr
          WHERE ordr.orderId IN(" . $order_old_id . ")  ORDER BY orderId DESC";
          $result = $wpdb->get_var($sql);
          $trayNumber = array();
          if ($result != '') {

          $trayIds = explode(",", $result);
          foreach ($trayIds as $tray) {
          $trayNumber[] = trim($tray);
          }
          if (count($trayNumber) > 1) {

         */
        $order = wc_get_order($order_id);
        $data = array();
        foreach ($order->get_items() as $item_id => $item) {

            $log_visible = false;
            if (wc_cp_get_composited_order_item_container($item, $order)) {
                /* Composite Prdoucts Child Items */
            } else {
                /* Composite Prdoucts Parent Item */
                $log_visible = true;
            }

            if ($log_visible) {
                $product_id = $item->get_product_id();
                $product = $item->get_product();

                $item_quantity = $item->get_quantity(); // Get the item quantity
                if ($item_quantity > 1) {
                    if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes') {
                        $sqlLT = "SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '$item_id'";
                        $resultLT = $wpdb->get_results($sqlLT);
                        $price = $product->get_price();
                        $priceLT = $price;
                        $priceLST = $price;
                        if ($resultLT) {
                            foreach ($resultLT as $itemRow) {
                                if ($itemRow->meta_key == '_line_subtotal') {
                                    $priceLST = $itemRow->meta_value / $item_quantity;
                                }
                                if ($itemRow->meta_key == '_line_total') {
                                    $priceLT = $itemRow->meta_value / $item_quantity;
                                }
                            }
                        }
                        $data[$item_id] = array(
                            'item_id' => $item_id,
                            'product_id' => $product_id,
                            '_line_subtotal' => $priceLST,
                            '_line_total' => $priceLT,
                            'name' => $product->get_name(),
                            'qty' => $item_quantity
                        );
                    }
                }
            }
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($data) {
            foreach ($data as $key_itmId => $itmData) {
                $qty = $itmData['qty'];
                for ($i = 1; $i < $qty; $i++) {
                    $dataWOI = array(
                        "order_item_name" => $itmData['name'],
                        "order_item_type" => 'line_item',
                        "order_id" => $order_id
                    );
                    $wpdb->insert('wp_woocommerce_order_items', $dataWOI);
                    $addedData = $wpdb->insert_id;
                    echo 'Added<pre>';
                    print_r($addedData);
                    echo '</pre>';
                    if ($addedData) {
                        $arrayData = array(
                            '_product_id' => $itmData['product_id'],
                            '_qty' => 1,
                            '_line_subtotal' => $itmData['_line_subtotal'],
                            '_line_total' => $itmData['_line_total'],
                        );
                        foreach ($arrayData as $keyWOIM => $itemDataEntry) {
                            $dataWOIM = array(
                                "order_item_id" => $addedData,
                                "meta_key" => $keyWOIM,
                                "meta_value" => $itemDataEntry
                            );
                            $wpdb->insert('wp_woocommerce_order_itemmeta', $dataWOIM);
                        }
                    }
                }

                $wpdb->update('wp_woocommerce_order_itemmeta', array(
                    'meta_value' => 1,
                ), array('meta_key' => '_qty', 'order_item_id' => $key_itmId));

                $wpdb->update('wp_woocommerce_order_itemmeta', array(
                    'meta_value' => $itmData['_line_subtotal'],
                ), array('meta_key' => '_line_subtotal', 'order_item_id' => $key_itmId));

                $wpdb->update('wp_woocommerce_order_itemmeta', array(
                    'meta_value' => $itmData['_line_total'],
                ), array('meta_key' => '_line_total', 'order_item_id' => $key_itmId));
            }
            // mbt_goodToShip($order_id, 'no');
        }
        //  }
        // }
    }
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'updateProductQtyForLogs') {
        echo 'success';
        die;
    }
}

/**
 * Adds action hook to display editable order meta on the WooCommerce admin order page.
 *
 * @param WC_Order $order The WooCommerce order object.
 */
add_action('woocommerce_admin_order_data_after_order_details', 'sb_editable_order_meta_generall');

/**
 * Callback function to display editable order meta on the WooCommerce admin order page.
 *
 * @param WC_Order $order The WooCommerce order object.
 */

function sb_editable_order_meta_generall($order)
{

    // global $wpdb;
    $user_id = $order->get_customer_id();
    $order_id = $order->get_id();
    //$orderIds_list = array();
    // $sql = "SELECT post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id =wp_posts.ID WHERE meta_key='_customer_user' AND meta_value=" . $user_id . " AND wp_posts.post_status IN ('wc-processing', 'wc-partial_ship');";
    // $orderIds_list = $wpdb->get_col($sql);

    $order_args = array(
        'post_type' => wc_get_order_types(),
        'posts_per_page' => -1,
        'fields' => 'ids',
        'post_status' => array('wc-processing', 'wc-partial_ship'),
        'date_query' => array(
            array(
                'after' => '-1 month',
            ),
        ),
    );
    $orderIds_list = get_posts($order_args);
    $orders_options = '<option value="">Select order</option>';
    foreach ($orderIds_list as $ord_id) {
        if ($order_id != $ord_id) {
            $orderSBRref = get_post_meta($ord_id, 'order_number', true);
            $orders_options .= '<option  value="' . $ord_id . '" >' . $orderSBRref . '</option>';
        }
    }


    if (in_array($order->get_payment_method(), array('authorize_net_cim_credit_card', 'affirm'))) {
    ?>
        <style>
            .refund-actions .button.button-primary.do-manual-refund {
                display: none !important;
            }
        </style>
    <?php
    }


    if (get_current_user_id() == 2 || get_current_user_id() == 124015) {

        if (isset($_REQUEST['post']) && $_REQUEST['post'] == 733918) {

            $orderListJson = json_decode('[{"post_id":621853},{"post_id":622094},{"post_id":622394},{"post_id":622484},{"post_id":623002},{"post_id":623032},{"post_id":623254},{"post_id":623427},{"post_id":623835},{"post_id":624340},{"post_id":624500},{"post_id":625544},{"post_id":625783},{"post_id":625849},{"post_id":625882},{"post_id":626316},{"post_id":626556},{"post_id":626801},{"post_id":626981},{"post_id":627024},{"post_id":627054},{"post_id":627198},{"post_id":627259},{"post_id":627273},{"post_id":627275},{"post_id":627419},{"post_id":627443},{"post_id":627599},{"post_id":628026},{"post_id":628066},{"post_id":628072},{"post_id":648395},{"post_id":648557},{"post_id":648589},{"post_id":648737},{"post_id":648805},{"post_id":649209},{"post_id":649243},{"post_id":649335},{"post_id":649361},{"post_id":649505},{"post_id":649547},{"post_id":649733},{"post_id":650325},{"post_id":650469},{"post_id":650721},{"post_id":650861},{"post_id":651019},{"post_id":651109},{"post_id":651187},{"post_id":651399},{"post_id":651709},{"post_id":651891},{"post_id":651906},{"post_id":652576},{"post_id":652667},{"post_id":652749},{"post_id":652785},{"post_id":653258},{"post_id":653272},{"post_id":653292},{"post_id":653298},{"post_id":653482},{"post_id":653712},{"post_id":653814},{"post_id":653879},{"post_id":653924},{"post_id":653984},{"post_id":653989},{"post_id":654052},{"post_id":654279},{"post_id":654365},{"post_id":654522},{"post_id":654667},{"post_id":654876},{"post_id":654904},{"post_id":654944},{"post_id":654956},{"post_id":654989},{"post_id":655119},{"post_id":655204},{"post_id":655299},{"post_id":655379},{"post_id":655404},{"post_id":655405},{"post_id":655623},{"post_id":655630},{"post_id":655757},{"post_id":655928},{"post_id":655979},{"post_id":656226},{"post_id":656448},{"post_id":656595},{"post_id":656823},{"post_id":656853},{"post_id":656927},{"post_id":656928},{"post_id":656938},{"post_id":656990},{"post_id":657145},{"post_id":657661},{"post_id":658051},{"post_id":658339},{"post_id":659934},{"post_id":660525},{"post_id":660630},{"post_id":660639},{"post_id":661446},{"post_id":661470},{"post_id":662181},{"post_id":663030},{"post_id":663351},{"post_id":664394},{"post_id":664451},{"post_id":665165},{"post_id":665177},{"post_id":665631},{"post_id":665796},{"post_id":666084},{"post_id":666415},{"post_id":666439},{"post_id":667416},{"post_id":667694},{"post_id":667895},{"post_id":669144},{"post_id":669177},{"post_id":669639},{"post_id":699985},{"post_id":700006},{"post_id":700016},{"post_id":700080},{"post_id":700088},{"post_id":700090},{"post_id":700091},{"post_id":700092},{"post_id":700181},{"post_id":700501},{"post_id":700533},{"post_id":700534},{"post_id":700733},{"post_id":700788},{"post_id":700789},{"post_id":700790},{"post_id":701280},{"post_id":701521},{"post_id":701524},{"post_id":701570},{"post_id":701584},{"post_id":701599},{"post_id":701637},{"post_id":701668},{"post_id":701695},{"post_id":701702},{"post_id":701830},{"post_id":701930},{"post_id":701950},{"post_id":701994},{"post_id":702033},{"post_id":713647},{"post_id":713648},{"post_id":713650},{"post_id":713651},{"post_id":713654},{"post_id":713657},{"post_id":713658},{"post_id":713674},{"post_id":713675},{"post_id":713684},{"post_id":713685},{"post_id":713692},{"post_id":713834},{"post_id":713842},{"post_id":713870},{"post_id":713902},{"post_id":713932},{"post_id":713933},{"post_id":713934},{"post_id":713987},{"post_id":713988},{"post_id":713998},{"post_id":714000},{"post_id":714010},{"post_id":714012},{"post_id":714013},{"post_id":714033},{"post_id":714034},{"post_id":714036},{"post_id":714037},{"post_id":714038},{"post_id":714039},{"post_id":714040},{"post_id":714041},{"post_id":714046},{"post_id":714084},{"post_id":714085},{"post_id":714093},{"post_id":714103},{"post_id":714105},{"post_id":714110},{"post_id":714198},{"post_id":714199},{"post_id":714204},{"post_id":714205},{"post_id":714206},{"post_id":714225},{"post_id":714230},{"post_id":714233},{"post_id":714235},{"post_id":714244},{"post_id":714254},{"post_id":714255},{"post_id":714257},{"post_id":714262},{"post_id":714264},{"post_id":714267},{"post_id":714286},{"post_id":714304},{"post_id":714306},{"post_id":714310},{"post_id":714318},{"post_id":714325},{"post_id":714326},{"post_id":714327},{"post_id":714330},{"post_id":714341},{"post_id":714342},{"post_id":714343},{"post_id":714349},{"post_id":714581},{"post_id":714583},{"post_id":715787},{"post_id":715813},{"post_id":716167},{"post_id":716253},{"post_id":719108},{"post_id":719383},{"post_id":720050},{"post_id":720121},{"post_id":720884},{"post_id":721209},{"post_id":721917},{"post_id":721962},{"post_id":722233},{"post_id":722465},{"post_id":722472},{"post_id":722897},{"post_id":723048},{"post_id":723373},{"post_id":723393},{"post_id":723884},{"post_id":723940},{"post_id":724156},{"post_id":724362},{"post_id":724545},{"post_id":724601},{"post_id":724998},{"post_id":725080},{"post_id":725318},{"post_id":725318},{"post_id":725384},{"post_id":725546},{"post_id":725716},{"post_id":726020},{"post_id":726086},{"post_id":726176},{"post_id":726192},{"post_id":726364},{"post_id":726498},{"post_id":726513},{"post_id":726583},{"post_id":728544},{"post_id":728612},{"post_id":728798},{"post_id":728823},{"post_id":728861},{"post_id":728924},{"post_id":728937},{"post_id":729008},{"post_id":729071},{"post_id":729160},{"post_id":729161},{"post_id":729214},{"post_id":729245},{"post_id":729248},{"post_id":729249},{"post_id":729313},{"post_id":729314},{"post_id":729327},{"post_id":729336},{"post_id":729385},{"post_id":729436},{"post_id":729481},{"post_id":729490},{"post_id":729504},{"post_id":729505},{"post_id":729717},{"post_id":729785},{"post_id":729806},{"post_id":729901},{"post_id":729906},{"post_id":729908},{"post_id":730009},{"post_id":730026},{"post_id":730030},{"post_id":730076},{"post_id":730122},{"post_id":730129},{"post_id":730131},{"post_id":730202},{"post_id":730308},{"post_id":730378},{"post_id":730480},{"post_id":730549},{"post_id":730595},{"post_id":730645},{"post_id":730655},{"post_id":730675},{"post_id":731096},{"post_id":731098},{"post_id":731099},{"post_id":731108},{"post_id":731112},{"post_id":731787},{"post_id":731970},{"post_id":733206},{"post_id":733327},{"post_id":733341},{"post_id":733534}]', true);
            foreach ($orderListJson as $key => $value) {
                $editUrl = get_admin_url() . 'post.php?post=' . $value['post_id'] . '&action=edit';
                $editorder = wc_get_order($value['post_id']);

                echo '<a class="button button-small"   style="margin-top: 10px;"  href="' . $editUrl . '" target="_blank">View  = ' . $value['post_id'] . '=== ' . $editorder->get_status() . '</a>';
            }
        }

        $order_old_id = get_post_meta($order_id, 'old_order_id', true);
        if ($order_old_id != '') {
            $addonSlip = add_query_arg(
                array(
                    'action' => 'updateProductQtyForLogs',
                    'order_id' => $order_id,
                    'order_old_id' => $order_old_id
                ),
                admin_url('admin-ajax.php')
            );
            echo '<a class="button button-small" order_id="' . $order_id . '"  id="updateProductQtyForLogs"  style="margin-top: 10px;" custom-url="' . $addonSlip . '" href="javascript:;">Split Products = ' . $order_id . '</a>';
        }
    }
    ?>

    <style>
        .woocommerce_order_items_wrapper table.display_meta {
            display: none;
        }

        .add-items .button.add-line-item,
        .add-items .button.add-coupon {
            display: none;
        }
    </style>
    <script>
        jQuery('body').on('click', '#updateProductQtyForLogs', function(event) {
            jQuery(this).attr('disabled', 'disabled');
            event.preventDefault();
            var order_id = jQuery(this).attr('order_id');
            var get_ajax_url = jQuery(this).attr('custom-url');
            jQuery.ajax({
                url: get_ajax_url,
                data: [],
                async: true,
                dataType: 'html',
                method: 'POST',

                success: function(response) {
                    console.log(response)
                    reload_order_item_table_mbt(order_id);
                },
                error: function(xhr) {
                    alert('Request failed...Something went wrong.')
                }
            });
        });

        function addOrderShipment() {

            var orderId_html = '';
            orderId_html += '<div class="newOrderShipmentEntry">';
            orderId_html += '<div class="orderShipItems"><select class="shipmentOrderIds" name="order_id[]"><?php echo $orders_options; ?></select></div>';
            orderId_html += '<div class="shipment_remove_field"><a href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></div>';
            orderId_html += '</div>';
            jQuery("body").find("#mbt_shipping_Item_listing").append(orderId_html); //add input box
            jQuery(".shipmentOrderIds").select2({
                placeholder: "Please select order.",
                allowClear: true,
                width: '100%'
            });
        }


        var shipmentDatatable = '';
    </script>
    <?php
    // $order = wc_get_order($order_id);
    $flagOrderStatus = false;
    $gehaOrderVidate = false;
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
            $product_name = $item->get_name();
            $productStrLower = strtolower($product_name);
            if (strpos($productStrLower, 'geha') !== false) {
                $gehaOrderVidate = true;
            }
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
    if ($gehaOrderVidate) {
        update_post_meta($order_id, 'gehaOrder', 'yes');
        update_user_meta($user_id, 'geha_user', 'yes');
    }

    // add_thickbox();
    ?>
    <script>
        <?php if (isset($_GET['sb_open_refund_box'])) { ?>
            jQuery(document).ready(function() {
                jQuery('body').find('.add-items .button.refund-items').trigger('click');
                var hash = "#order_line_items";
                jQuery('html, body').animate({

                    scrollTop: jQuery(hash).offset().top
                }, 800, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            });
        <?php } ?>

        <?php if (isset($_REQUEST['post'])) : ?>
            jQuery('body').on('click', '#accept_order_to_ship', function() {

                jQuery('.sb_order_item_tr').html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
                jQuery('#mbt-order-action').html('<span>Processing...</span>');
                //Sending data
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        order_id: <?php echo $_REQUEST['post']; ?>,
                        action: 'update_order_good_to_ship',
                    },
                    method: 'POST',
                    //  dataType: 'JSON',
                    // async: false,
                    success: function(response) {
                        /*
                         jQuery('.sb_order_item_tr').html('');
                         var len = response.length;
                         for (var i = 0; i < len; i++) {
                         var item_id = response[i].item_id;
                         var html = response[i].html;
                         var tray = response[i].tray;
                         jQuery('#item_tray_number_' + item_id).html(tray);
                         jQuery('#order_item_data-' + item_id).html(html);
                         //jQuery('#order_item_data-' + item_id).html(item_id);
                         }
                         */

                        //jQuery('#order_status').val('wc-processing').trigger('change');
                        jQuery('#mbt-order-action').html('Order Processing. Please Create Shipment.');
                        setTimeout(function() {
                            jQuery('#mbt-order-action').hide(500)
                        }, 1000);
                        reload_order_item_table_mbt(<?php echo $_REQUEST['post']; ?>);
                        //jQuery(this).html('<span>Loading...</span>');
                        //console.log(item_id);
                        //   spinner.addClass('hidden-class');
                        //     location.reload();
                    }
                });
            });
        <?php endif; ?>


        jQuery('body').on('click', '.RegeneratePostage', function(e) {

            e.preventDefault();
            var get_ajax_url = jQuery(this).attr('custom-url');
            var easyPostShipmentId = jQuery(this).attr('easyPostShipmentId');
            // Confirm alert
            Swal.fire({
                title: 'Are you sure?',
                html: "Submit Easypost postage refund request and revert shipment. You won't be able to undo this!<br/>",
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Provide a Reason for Regeneration/Refund:',
                inputAttributes: {
                    'aria-label': 'Provide a Reason for Regeneration/Refund:'
                },

                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create Request',
                showLoaderOnConfirm: true,
                preConfirm: (reason) => {
                    return fetch('<?php echo admin_url('admin-ajax.php?action=easyPostPostageRefund&type=regenerate&easyPostShipmentId='); ?>' + easyPostShipmentId + '&reason=' + reason, {
                        method: 'POST',
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        } else {
                            reload_order_item_table_mbt(<?php echo $_REQUEST['post']; ?>);
                        }
                        return response.json();

                    }).catch(error => {
                        Swal.showValidationMessage(
                            'Request failed: ${error}'
                        )

                    });

                }
            }).then((result) => {
                if (result.isConfirmed) {

                    if (result.value.code == 100) {
                        Swal.fire({
                            icon: 'error',
                            html: result.value.msg
                        });
                    } else {
                        jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt shipment-popup');
                        jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());

                        jQuery.ajax({
                            url: get_ajax_url,
                            data: [],
                            async: true,
                            dataType: 'html',
                            method: 'POST',
                            beforeSend: function(xhr) {
                                smile_brillaint_order_modal.style.display = "block";
                            },
                            success: function(response) {
                                // jQuery('#analyzing_impression_form').unblock();

                                jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
                                reload_order_item_table_mbt(<?php echo $_REQUEST['post']; ?>);
                            },
                            error: function(xhr) {
                                jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
                            },
                            cache: false,
                            // contentType: false,
                            //  processData: false
                        });
                    }
                }

            });
        });



        jQuery('body').on('click', '.create_acknowledged_accept', function() {

            var item_id = jQuery(this).attr('item_id');
            var product_id = jQuery(this).attr('product_id');
            var order_id = jQuery(this).attr('order_id');
            // jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
            //Sending data
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    order_id: order_id,
                    action: 'acknowledged_accept',
                    product_id: product_id,
                    item_id: item_id,
                },
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        //var item_id = response[i].item_id;
                        var html = response[i].html;
                        // var tray = response[i].tray;
                        // jQuery('#item_tray_number_' + item_number).html(tray);
                        jQuery('#order_item_data-' + item_id).html(html);
                        //jQuery('#order_item_data-' + item_id).html(item_id);
                    }
                }
                // cache: false,
                //    contentType: false,
                //  processData: false
            });
        });
        jQuery('body').on('click', '.create_acknowledged', function() {

            var item_id = jQuery(this).attr('item_id');
            var product_id = jQuery(this).attr('product_id');
            var order_id = jQuery(this).attr('order_id');
            var event_action = jQuery(this).attr('action');
            var log_id = jQuery(this).attr('log_id');
            jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
            //Sending data
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    log_id: log_id,
                    order_id: order_id,
                    action: 'create_acknowledged',
                    product_id: product_id,
                    item_id: item_id,
                    event_action: event_action,
                },
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        //var item_id = response[i].item_id;
                        var html = response[i].html;
                        // var tray = response[i].tray;
                        // jQuery('#item_tray_number_' + item_number).html(tray);
                        jQuery('#order_item_data-' + item_id).html(html);

                        if (event_action == 'create') {
                            var child_order_url = '<?php echo admin_url('post.php?action=edit&post='); ?>' + response[i].child_id;
                            console.log(child_order_url)
                            window.open(child_order_url, '_blank');
                        }

                        //jQuery('#order_item_data-' + item_id).html(item_id);
                    }
                }
                // cache: false,
                //    contentType: false,
                //  processData: false
            });
        });

        function reload_order_item_table_mbt(order_id) {
            jQuery('#woocommerce-order-items').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            var data = {
                order_id: order_id,
                action: 'woocommerce_load_order_items',
                security: '<?php echo wp_create_nonce('order-item'); ?>'
            };
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                type: 'POST',
                success: function(response) {
                    jQuery('#woocommerce-order-items').find('.inside').empty();
                    jQuery('#woocommerce-order-items').find('.inside').append(response);
                    jQuery('#woocommerce-order-items').unblock();
                }
            });
        }


        <?php
        $customer_chat = add_query_arg(
            array(
                'action' => 'create_customer_popup',
                'order_id' => $order_id,
                'product_id' => 0,
                'item_id' => 0,
            ),
            admin_url('admin-ajax.php')
        );

        $invoiceLink = wp_nonce_url(
            add_query_arg([
                'wc_pip_action' => 'print',
                'wc_pip_document' => 'invoice',
                'order_id' => $order_id,
            ], admin_url('admin.php')),
            'wc_pip_document'
        );

        $ajax_url = add_query_arg(
            array(
                'action' => 'generate_shipment_popup',
                'order_id' => $order_id,
            ),
            admin_url('admin-ajax.php')
        );
        $rma_url = add_query_arg(
            array(
                'action' => 'create_addon_order_popup',
                'order_id' => $order_id,
                'warranty_claim_id' => 1,
            ),
            admin_url('admin-ajax.php')
        );
        $existingAddonLink = add_query_arg(
            array(
                'action' => 'get_addon_orders_by_order_id',
                'order_id' => $order_id,
            ),
            admin_url('admin-ajax.php')
        );

        $addonOrderUrl = add_query_arg(
            array(
                'customer_id' => $user_id,
                'parent_order_id' => $order_id,
                'order_type' => 'Addon',
            ),
            admin_url('admin.php?page=create-order')
        );
        $addOnOrder = add_query_arg(
            array(
                'customer_id' => $user_id,
                'action' => 'create_addon_order',
                'order_type' => 'Addon',
                'parent_order_id' => $order_id,
            ),
            admin_url('admin-ajax.php')
        );



        $addFee = add_query_arg(
            array(
                'action' => 'add_extra_fee',
                'order_id' => $order_id,
                'orderDetail' => 1,
            ),
            admin_url('admin-ajax.php')
        );
        ?>
        var actionBtns = '<div class="sbr-order-action-btns flex-row section-buttons-top">';

        actionBtns += '<div class="customer-order-action-btns col-sm-4">';
        actionBtns += '<h3>';
        actionBtns += 'Customer';
        actionBtns += '</h3>';
        actionBtns += '<div class="sbr-inner-sections">';
        actionBtns += '<a class="button button-small"  target="_blank" href="<?php echo admin_url('?page=customer_history&customer_id=' . $user_id); ?>">Customer Profile</a>';

        actionBtns += '<?php echo getUserChatForLog($customer_chat); ?>';
        actionBtns += '<div class="column-shipping">';
        actionBtns += '<?php echo change_shipping_method_by_order_id($order, 'Change Shipping Method', 'button button-small'); ?>';
        actionBtns += '</div>';
        actionBtns += '</div>';

        actionBtns += '</div>';


        actionBtns += '<div class="customer-order-action-btns col-sm-4">';
        actionBtns += '<h3>';
        actionBtns += 'Order';
        actionBtns += '</h3>';
        actionBtns += '<div class="sbr-inner-sections">';

        <?php if (get_post_meta($order_id, 'created_good_to_ship', true) != 'yes') : ?>
            actionBtns += '<div id="mbt-order-action" class="mbt-order-action" style="margin-top: 30px;width: 100%; display: inline-flex;">';
            actionBtns += '<div id="accept_order_to_ship">';
            actionBtns += '<a href="javascript:;" class="button-primary" >Good To Ship<span class="spinner is-active hidden-class"></span></a>';
            actionBtns += '</div>';
            actionBtns += '</div>';
        <?php endif; ?>
        actionBtns += '<a class="sb_analyze_impression button button-small"  href="javascript:;"  custom-url="<?php echo $addFee; ?>">Charge Extra Amount</a>';
        actionBtns += '<a class="button button-small existingAddonOrders" custom-url="<?php echo $existingAddonLink; ?>" href="javascript:;">Existing Addon</a>';
        actionBtns += '<a class="button button-small"  target="_blank" href="<?php echo $invoiceLink; ?>">Order Invoice</a>';
        <?php
        if ($flagOrderStatus) {
        ?>
            actionBtns += '<a href="javascript:;" custom-url="<?php echo $ajax_url; ?>"  class="button button-small  create_sb_shipment ">Create shipment</a>';
        <?php
        }
        ?>
        actionBtns += '<a class="button button-small rma_request" custom-url="<?php echo $rma_url; ?>" href="javascript:;">RMA</a>';
        actionBtns += '<a class="button button-small"  id="get_notes_tab" href="javascript:;">Order Note</a>';
        actionBtns += '<a class="addon_order button button-small sb_addon_order" custom-url="<?php echo $addOnOrder; ?>" href="javascript:;">Create Addon</a>';


        //        actionBtns += '<a class="button button-small" target="_blank"  id="addonOrder" href="<?php // echo $addonOrderUrl;   
                                                                                                        ?>">Addon Order</a>';
        actionBtns += '<a class="button button-small"  id="product_log_event" href="javascript:;">Products Logs</a>';
        actionBtns += '<div class="loading-sbr" style="display: none;"><div class="inner-sbr"></div></div><a type="button" id="addNotes" class="button sbr-button button-small sbr-button-order-add-notes" data-order-id="<?php echo $order_id; ?>" data-is_customer_note="0" title="Admin Note">Edit Notes</a>';



        <?php
        $parentOrderID = get_post_meta($order_id, 'parent_order_id', true);
        $order_type = get_post_meta($order_id, 'order_type', true);
        if ($parentOrderID) :
            $parentOrderNumber = get_post_meta($parentOrderID, 'order_number', true);
            $editUrl = get_admin_url() . 'post.php?post=' . $parentOrderID . '&action=edit';
        ?>

            actionBtns += '<br/><br/>Order Type: <?php echo $order_type; ?>';
            actionBtns += '<br/>Parent Order: <a href="<?php echo $editUrl; ?>" target="_blank" class=""> <?php echo $parentOrderNumber; ?></a>';

        <?php endif; ?>

        // actionBtns += '<div class="existingAddonOrders"></div>';
        actionBtns += '</div>';
        actionBtns += '</div>';

        actionBtns += '<div class="customer-history-action-btns col-sm-4">';
        actionBtns += '<h3>';
        actionBtns += 'History';
        actionBtns += '</h3>';
        actionBtns += '<div class="sbr-inner-sections">';
        actionBtns += '<a class="button button-small"   id="shipmentEvent" href="javascript:;">Shipments History</a>';
        actionBtns += '<a class="button button-small"   id="refundsEvent" href="javascript:;">Refunds History</a>';
        actionBtns += '<a class="button button-small"   id="pruchaseHistroyEvent" href="javascript:;">Customer Purchase History</a>';
        actionBtns += '<a class="button button-small"   id="browsingHistoryEvent" href="javascript:;">Customer Browsing History</a>';
        actionBtns += '</div>';
        actionBtns += '</div>';


        actionBtns += '</div>';
        jQuery('body').find('.woocommerce-order-data__heading').after(actionBtns);
    </script>
<?php
}
