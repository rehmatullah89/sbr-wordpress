<?php

/**
 * AJAX callback function to add a shipping note to an order.
 *
 * This function handles the AJAX request and updates the order meta with a packaging note.
 *
 * @since 1.0.0
 */
add_action('wp_ajax_add_order_shipping_note', 'add_order_shipping_note_callback');
function add_order_shipping_note_callback()
{
    $response = array();

    // Check if the order ID is set and greater than 0
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] > 0) {
        $response['error'] = false;
        $response['msg'] = 'Note Added';

        // Update the order meta with the packaging note
        update_post_meta($_REQUEST['order_id'], '_order_packaging_note', $_REQUEST['note']);
    } else {
        $response['error'] = true;
        $response['msg'] = 'Order ID not found';
    }

    // Send the JSON-encoded response and terminate the script
    echo json_encode($response);
    die;
}


/**
 * AJAX callback function to charge extra fees to a specific customer based on the provided parameters.
 *
 * This function handles the AJAX request and charges extra fees to a specified customer based on the
 * request parameters such as order ID, fees, charge type, etc.
 *
 * @since 1.0.0
 */
add_action('wp_ajax_chargeExtraFeeToSBRCustomer', 'chargeExtraFeeToSBRCustomer_callback');
/**
 * Callback function for charging extra fees to a customer.
 *
 * @since 1.0.0
 */
function chargeExtraFeeToSBRCustomer_callback()
{
    $response = array();
    $order_id = $_REQUEST['order_id'];
    // Check if fees are set and the count is greater than 0
    if (isset($_REQUEST['fee']) && count($_REQUEST['fee']) > 0) {
        $response['error'] = false;
        $order = wc_get_order($order_id);
        // Check the charge type and perform the appropriate actions
        if (isset($_REQUEST['chargeType']) &&  $_REQUEST['chargeType']  === 'onlyadd') {
            foreach ($_REQUEST['fee'] as $key => $fee) {
                $amount = isset($_REQUEST['price'][$key]) ? $_REQUEST['price'][$key] : 0;
                // If the amount is greater than 0, add a fee item to the order
                if ($amount > 0) {
                    $item = new WC_Order_Item_Fee();
                    $title = $fee . ' - $' . $amount . ' - (Only Add).';
                    $item->set_name($title);
                    $item->set_amount($amount);
                    $item->set_total($amount);
                    $item->set_taxes(false);
                    $item->save();
                    $item->update_meta_data('transId', 'onlyadd');
                    $order->add_item($item);
                }
            }
            // Add admin note if provided
            $admin_note = isset($_REQUEST['admin_note']) ? sanitize_text_field(wp_unslash($_REQUEST['admin_note'])) : '';
            if ($admin_note != '') {
                $order->add_order_note($admin_note, 0, get_current_user_id());
            }
            // Calculate totals and set response messages
            $order->calculate_totals();
            $response['message'] = 'Fee Charged Successfully';
            $response['code'] = 'success';
        } else {
            if (isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) && $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] <> '') {
                // Perform actions for other charge types
                $refId = get_post_meta($order_id, 'order_number', true);
                if ($refId == '') {
                    $refId = refId_mbt(15);
                }
                $token_id = $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'];
                $token = WC_Payment_Tokens::get($token_id);
                $customer_profile_id = get_user_meta($order->get_user_id(), USER_CIM_PROFILE_ID, true);
                $total_amount = 0;
                $line_items = array();
                foreach ($_REQUEST['price'] as $key => $feeAmount) {
                    $total_amount += number_format($feeAmount, 2, '.', '');
                    $serviceFee = isset($_REQUEST['fee'][$key]) ? $_REQUEST['fee'][$key] : 'Service fee';
                    $line_items[] = array(
                        'itemId' => $order_id . '-' . $key,
                        'name' => mb_strimwidth($serviceFee, 0, 27, '...'),
                        'description' => $serviceFee,
                        'quantity' => 1,
                        'unitPrice' => $feeAmount,
                    );
                }

                // maximum of 30 line items per order
                if (count($line_items) > 30) {
                    $line_items = array_slice($line_items, 0, 30);
                }
                $curl = curl_init();

                $request_data = array(
                    'createTransactionRequest' => array(
                        'merchantAuthentication' => array(
                            'name' => SB_AUTHORIZE_LOGIN_ID,
                            'transactionKey' => SB_AUTHORIZE_TRANSACTION_KEY
                        ),
                        'refId' => $refId,
                        'transactionRequest' => array(
                            'transactionType' => 'authCaptureTransaction',
                            'amount' => $total_amount,
                            'profile' => array(
                                'customerProfileId' => $customer_profile_id,
                                'paymentProfile' => array(
                                    'paymentProfileId' => $token->get_token()
                                )
                            ),
                            'order' => array(
                                'invoiceNumber' => $refId,
                                'description' => 'Smile Brilliant - ' . $order_id . ' - ' . $refId
                            ),
                            'lineItems' => array('lineItem' => $line_items),
                            'customer' => array(
                                'id' => $order->get_user_id(),
                                'email' => $order->get_billing_email(),
                            ),
                            'customerIP' => $order->get_customer_ip_address(),
                        ),
                    )
                );

                curl_setopt_array($curl, array(
                    CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($request_data),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $str = curl_exec($curl);
                curl_close($curl);

                for ($i = 0; $i <= 31; ++$i) {
                    $checkLogin = str_replace(chr($i), "", $str);
                }

                $checkLogin = str_replace(chr(127), "", $str);
                if (0 === strpos(bin2hex($checkLogin), 'efbbbf')) {
                    $checkLogin = substr($checkLogin, 3);
                }
                $paymentFlag = false;
                $transId  = 0;
                $payemt_note = '';
                $checkLogin = json_decode($checkLogin, true);
                $current_user = wp_get_current_user();
                if (isset($checkLogin['transactionResponse']) && $checkLogin['transactionResponse']['responseCode'] == 1) {
                    $transId = $checkLogin['transactionResponse']['transId'];
                    $getCC = array(
                        'mastercard' => __('MasterCard', 'woocommerce'),
                        'visa' => __('Visa', 'woocommerce'),
                        'discover' => __('Discover', 'woocommerce'),
                        'american express' => __('American Express', 'woocommerce'),
                        'diners' => __('Diners', 'woocommerce'),
                        'jcb' => __('JCB', 'woocommerce'),
                    );

                    $payemt_note = 'Authorize.Net Credit Card Charge Approved: ' . $getCC[$token->get_card_type()];
                    $payemt_note .= ' ending in ' . $token->get_last4() . ' (expires ' . $token->get_expiry_month() . '/' . $token->get_expiry_year() . ')<br/>';
                    $payemt_note .= ' (Transaction ID ' . $transId . ')<br/>';
                    $payemt_note .= ' (authCode ' . $checkLogin['transactionResponse']['authCode'] . ')<br/>';
                    $payemt_note .= ' (transaction time ' . date("Y-m-d h:i:sa") . ')<br/>';
                    $payemt_note .= ' (transaction amount ' . $total_amount . ')<br/>';
                    $payemt_note .= ' (Charge By ' . $current_user->user_login . ')';
                    $paymentFlag = true;
                } else {
                    $paymentFlag = false;
                    $payemt_note = isset($checkLogin['messages']['message'][0]['text']) ? $checkLogin['messages']['message'][0]['text'] : 'Authorize.Net Transaction Failed.';
                    $payemt_note .= ' (transaction time ' . date("Y-m-d h:i:sa") . ')<br/>';
                    $payemt_note .= ' (transaction amount ' . $total_amount . ')<br/>';
                    $payemt_note .= ' (Charge By ' . $current_user->user_login . ')';
                }

                $order->add_order_note($payemt_note);
                if ($paymentFlag) {
                    // Get and Loop Over Order Items
                    if (isset($_REQUEST['chargeType']) && $_REQUEST['chargeType'] === 'add') {
                        // Get and Loop Over Order Items
                        foreach ($_REQUEST['fee'] as $key => $fee) {
                            $amount = isset($_REQUEST['price'][$key]) ? $_REQUEST['price'][$key] : 0;
                            if ($amount > 0) {
                                $item = new WC_Order_Item_Fee();
                                $title = $fee . ' - $' . $amount . ' - (Charge +  Add).';
                                $item->set_name($title);
                                $item->set_amount($amount);
                                $item->set_total($amount);
                                $item->set_taxes(false);
                                $item->save();
                                $item->update_meta_data('transId', $transId);
                                $order->add_item($item);
                            }
                        }
                    } else {
                        foreach ($_REQUEST['fee'] as $key => $fee) {
                            $amount = isset($_REQUEST['price'][$key]) ? $_REQUEST['price'][$key] : 0;
                            if ($amount > 0) {
                                $item = new WC_Order_Item_Fee();
                                $title = $fee . ' - $' . $amount . ' - (Only Charge)';
                                $item->set_name($title);
                                $item->set_amount(0);
                                $item->set_total(0);
                                $item->set_taxes(false);
                                $item->save();
                                $item->update_meta_data('transId', $transId);
                                $item->update_meta_data('transAmount', $amount);
                                $order->add_item($item);
                            }
                        }
                    }
                    $admin_note = isset($_REQUEST['admin_note']) ? sanitize_text_field(wp_unslash($_REQUEST['admin_note'])) : '';
                    if ($admin_note != '') {
                        $order->add_order_note($admin_note, 0, get_current_user_id());
                    }
                    $order->calculate_totals();
                    $response['message'] = 'Fee Charged Successfully';
                    $response['code'] = 'success';
                } else {
                    $response['message'] = $payemt_note;
                    $response['code'] = 'error';
                }
            } else {
                $response['message'] = 'Please add CIM Profile to charge customer';
                $response['code'] = 'error';
            }
        }
    } else {
        $response['message'] = 'Please add fee to charge customer';
        $response['code'] = 'error';
    }
    echo json_encode($response);
    die;
}


/**
 * AJAX callback function to add extra fee to an order.
 *
 * This function handles the AJAX request to add extra fees to a specific order.
 *
 * @since 1.0.0
 */

add_action('wp_ajax_add_extra_fee', 'add_extra_fee_callback');
/**
 * Callback function for adding extra fee to an order.
 *
 * @since 1.0.0
 */
function add_extra_fee_callback()
{
    global $wpdb;
    create_order_style_mbt();
    $order_id = $_REQUEST['order_id'];

    $order = wc_get_order($order_id);
    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $user_id = $order->get_user_id();
    echo ' <h2 class="addonpouptitle">Add Services Fee in Order# ' . $orderSBRref . '</h2>';
?>
    <div id="smile_brillaint_addNewOrder">


        <form id="addSBROrderFee" class="addon-order-form-mbt split_order_popup">

            <input type="hidden" name="billing_first_name" value="<?php echo $order->get_billing_first_name(); ?>" />
            <input type="hidden" name="billing_last_name" value="<?php echo $order->get_billing_last_name(); ?>" />
            <input type="hidden" name="billing_phone" value="<?php echo $order->get_billing_phone(); ?>" />
            <input type="hidden" name="billing_city" value="<?php echo $order->get_billing_city(); ?>" />
            <input type="hidden" name="billing_address_1" value="<?php echo $order->get_billing_address_1() . ' ' . $order->get_billing_address_2(); ?>" />
            <input type="hidden" name="billing_postcode" value="<?php echo $order->get_billing_postcode(); ?>" />
            <input type="hidden" name="billing_state" value="<?php echo $order->get_billing_state(); ?>" />
            <input type="hidden" name="billing_country" value="<?php echo $order->get_billing_country(); ?>" />
            <div class="flex-row add-buttonss">
                <div class="col-sm-12">
                    <div class="row-body">

                        <div class="tr-body" id="mbt_shipping_Item_listing">
                            <hr class="addFeeHR" />
                            <table class="widefat" id="shipmentProduct_table">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" autocomplete="off" name="fee[]" value="" class="add_fee" /></td>
                                        <td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0" value="0" size="4" class="feePrice"></td>
                                        <td><a href="javascript:;" onclick="removeSBROrderFeeLine(this)" class="remove_item_row_shipment"><span class="dashicons dashicons-no-alt"></span></a></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="add-order-btn">
                            <button id="add_order_shipment_btn" onclick="addSBROrderFee()" class="button" type="button">Add Service</button>
                        </div>
                    </div>

                </div>

            </div>

            <div id="addon_summery">
                <div class="widefat">
                    <div class="tbody flex-row">

                        <div class="order-admin-note col-sm-12">
                            <textarea name="admin_note" placeholder="Admin Note" autocomplete="off"></textarea>
                        </div>
                        <div class="order-admin-note col-sm-12">
                            <h3>Charge Type</h3>
                            <label>
                                <input name="chargeType" value="add" type="radio" checked="">Charge + Add in order total amount
                            </label>
                            <label>
                                <input name="chargeType" value="onlyadd" type="radio">Only Add in order total amount
                            </label>
                            <label>
                                <input name="chargeType" value="charge" type="radio">Only Charge amount
                            </label>
                        </div>
                    </div>

                </div>

            </div>
            <div id="customerPaymentDetails">
                <?php customerAddOrder_paymentProfiles($user_id); ?>
            </div>
            <div class="col-sm-12">
                <button data-bb-handler="Charge" type="button" id="addExtraFeeSBROrder" class="btn btn-danger button">Charge</button>
            </div>
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
        </form>


        <div id="sbr_ajax_response"></div>
    </div>
    <style>
        #checkOldAimProfile {
            display: none;
        }
    </style>
    <script>
        function removeSBROrderFeeLine($row) {
            jQuery($row).closest('tr').remove();
            if (jQuery("body").find("#mbt_shipping_Item_listing .add_fee").length == 0) {
                jQuery("body").find("#mbt_shipping_Item_listing #shipmentProduct_table").hide();
            }
        }

        function addSBROrderFee() {
            if (jQuery("body").find("#mbt_shipping_Item_listing .add_fee").length == 0) {
                jQuery("body").find("#mbt_shipping_Item_listing #shipmentProduct_table").show();
            }
            var html = '';
            html += '<tr>';
            html += '<td><input type="text" autocomplete="off" name="fee[]" value="" class="add_fee" /></td>';
            html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0" value="0" size="4" class="feePrice"></td>';
            html += '<td><a href="javascript:;" onclick="removeSBROrderFeeLine(this)" class="remove_item_row_shipment"><span class="dashicons dashicons-no-alt"></span></a></td>';
            html += '</tr>';

            jQuery("body").find("#mbt_shipping_Item_listing #shipmentProduct_table tbody").append(html); //add input box

        }


        function smile_brillaint_addOrder_fail_status_html($msg) {
            var html = '<div class="alert alert-danger">';
            html += $msg;
            html += '</div>';
            return html;
        }
        jQuery("body").on('click', '#addExtraFeeSBROrder', (function(e) {
            Swal.fire({
                title: 'Charge Amount',
                text: "Do you want to charge amount? You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Charge Amount'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('body').find('#addSBROrderFee').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    count_addToCart = false;
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=chargeExtraFeeToSBRCustomer'); ?>';
                    var elementT = document.getElementById("addSBROrderFee");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            if (response.code == 'success') {
                                <?php
                                if (isset($_REQUEST['orderDetail'])) {
                                ?>
                                    location.reload();
                                <?php
                                } else {
                                ?>
                                    reloadOrderEntry(<?php echo $order_id; ?>);
                                <?php
                                }
                                ?>
                                jQuery('body').find('#addSBROrderFee').unblock();
                                jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                                Swal.fire({
                                    icon: 'success',
                                    text: response.message
                                });
                            } else {
                                $error_msg = '<div class="alert">';
                                $error_msg += '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                                $error_msg += response.message;
                                $error_msg += '</div>';
                                jQuery('body').find('#sbr_ajax_response').html($error_msg);
                                jQuery('body').find('#addSBROrderFee').unblock();
                            }


                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            })
        }));
    </script>

<?php
    die();
}

/**
 * Function to add a new EasyPost shipment for relevant orders.
 *
 * Retrieves a list of orders within the last 3 months and provides the option to add a shipment for a selected order.
 *
 * @since 1.0.0
 */
function addNewEasypostShipment()
{
    $order_args = array(
        'post_type' => wc_get_order_types(),
        'posts_per_page' => -1,
        'fields' => 'ids',
        'post_status' => array('wc-processing', 'wc-partial_ship'),
        'date_query' => array(
            array(
                'after' => '-3 month',
            ),
        ),
    );
    $orders_options = '';
    $orderIds_list = get_posts($order_args);
    $orders_options = '<option value="">Select order</option>';
    foreach ($orderIds_list as $ord_id) {

        $orderSBRref = get_post_meta($ord_id, 'order_number', true);
        $orders_options .= '<option  value="' . $ord_id . '" >' . $orderSBRref . '</option>';
    }
?>
    <div class="search-shipement">
        <h3>Add Shipment</h3>
        <?php
        if (isset($_REQUEST['shipment_order'])) {
        ?>
            <div class="firstOrderShipmentEntry">Please wait.. Checking relevant orders</div>
            <script>
                jQuery(document).ready(function() {

                    let $currentOrder = jQuery('body');
                    jQuery('body').find('.loading-sbr').show();
                    $currentOrder.find(".firstOrderShipmentEntry").block({
                        message: '',
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    let data = {
                        action: 'generate_shipment_popup',
                        order_id: '<?php echo $_REQUEST['shipment_order']; ?>',
                        relaod: 'yes'
                    }
                    jQuery.ajax({
                        url: ajaxurl,
                        async: true,
                        dataType: 'html',
                        data: data,
                        success: function(response) {
                            $currentOrder.find(".firstOrderShipmentEntry").unblock();
                            $currentOrder.find(".firstOrderShipmentEntry").html(response);
                            jQuery('body').find('.loading-sbr').hide();
                        }
                    });
                });
            </script>
        <?php
        } else {
        ?>
            <div class="firstOrderShipmentEntry">
                <div class="orderShipItems"><select class="firstOrderShipment" name="order_id[]" autocomplete="off"><?php echo $orders_options; ?></select></div>
            </div>
            <script>
                jQuery(".firstOrderShipment").select2({
                    placeholder: "Please select order.",
                    allowClear: true,
                    width: '100%'
                });
                jQuery('body').on('change', '.firstOrderShipment', function() {
                    let $currentOrder = jQuery(this);
                    jQuery('body').find('.popup-shipment').remove();
                    if (jQuery(this).val()) {
                        $currentOrder.closest(".firstOrderShipmentEntry").block({
                            message: '',
                            overlayCSS: {
                                background: '#fff',
                                opacity: 0.6
                            }
                        });
                        jQuery('body').find('.loading-sbr').show();
                        let data = {
                            action: 'generate_shipment_popup',
                            order_id: jQuery(this).val(),
                            relaod: 'yes'
                        }
                        jQuery.ajax({
                            url: ajaxurl,
                            async: true,
                            dataType: 'html',
                            data: data,
                            success: function(response) {

                                $currentOrder.closest(".firstOrderShipmentEntry").unblock();
                                $currentOrder.closest(".firstOrderShipmentEntry").append(response);
                                jQuery('body').find('.loading-sbr').hide();
                                //disable_shipmentOrderIds();
                                // validateOrderZipCode();

                            }
                        });
                    } else {
                        jQuery('body').find('.popup-shipment').remove();
                    }
                });
            </script>
        <?php
        }
        //echo check_unique_orders_by_zipcode(array(711301,711313,711339)); 
        ?>

    </div>
    <div class="loading-sbr" style="display: none;">
        <div class="inner-sbr"></div>
    </div>

    <script>
        function validateOrderZipCode() {

            var elementT = document.getElementById("shipping_metabox_form");
            var formdata = new FormData(elementT);
            formdata.set('action', 'validateOrderZipCode');

            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: formdata,
                async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {

                    if (response.code == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.msg,
                        });

                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

        }

        function addOrderShipment() {

            var orderId_html = '';
            orderId_html += '<div class="newOrderShipmentEntry">';
            orderId_html += '<div class="orderShipItems"><select class="shipmentOrderIds" name="order_id[]" autocomplete="off"><?php echo $orders_options; ?></select></div>';
            orderId_html += '<div class="shipment_remove_field"><a href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></div>';
            orderId_html += '</div>';
            jQuery("body").find("#mbt_shipping_Item_listing").append(orderId_html); //add input box
            jQuery(".shipmentOrderIds").select2({
                placeholder: "Please select order.",
                allowClear: true,
                width: '100%'
            });
        }
        jQuery("body").on("click", ".shipment_remove_field", function(e) { //user click on remove text
            e.preventDefault();
            jQuery(this).closest('.newOrderShipmentEntry').remove();
            load_packages();
            disable_shipmentOrderIds();
        });
        jQuery("body").on('click', 'input[name="is_shipping_address_changed"]', function(event) {
            if (jQuery(this).val() == 'new') {
                jQuery('#is_shipping_address_changed_tbody').show();
            } else {
                jQuery('#is_shipping_address_changed_tbody').hide();
            }
        })


        jQuery("body").on('click', 'input[name="is_billing_address_changed"]', function(event) {
            if (jQuery(this).val() == 'new') {
                jQuery('#is_billing_address_changed_tbody').show();
            } else {
                jQuery('#is_billing_address_changed_tbody').hide();
            }
        })

        jQuery(document).on('click', '#add_order_shipment_btn', function() {
            disable_shipmentOrderIds();
        });
    </script>
    <style>
        #create_shipment_heading {
            display: none;
        }
    </style>
<?php
}

/**
 * Check if all provided order IDs have the same shipping zipcode.
 *
 * This function queries the database to check if all the provided orders have the same
 * shipping zipcode. It returns true if they do, and false otherwise.
 *
 * @since 1.0.0
 *
 * @param array $order_id An array of order IDs to check.
 * @param string $zipcode The shipping zipcode to compare against (optional).
 *
 * @return bool True if all orders have the same zipcode, false otherwise.
 */
function check_unique_orders_by_zipcode($order_id = array(), $zipcode = '')
{
    // If no order IDs are provided, return false
    if (count($order_id) < 1) {
        return false;
    }

    global $wpdb;
    // Convert array of order IDs to a comma-separated string
    $order_ids = implode(',', $order_id);

    // SQL query to fetch shipping zipcodes for the provided order IDs
    $sql = "SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id IN (" . $order_ids . ") AND meta_key='_shipping_postcode'";

    // If a specific zipcode is provided, add it to the query
    if ($zipcode != '') {
        $sql .= " AND meta_value= '" . $zipcode . "'";
    }

    // Execute the SQL query
    $results = $wpdb->get_results($sql);

    // If the number of orders doesn't match the number of results, return false
    if (count($order_id) != count($results)) {
        return false;
    }

    // Extract unique zipcodes from the results
    $arr = array();
    foreach ($results as $res) {
        $arr[] = $res->meta_value;
    }

    // Remove duplicate zipcodes
    $arr = array_unique($arr);

    // If there's only one unique zipcode, return true; otherwise, return false
    if (count($arr) == 1) {
        return true;
    }

    return false;
}
