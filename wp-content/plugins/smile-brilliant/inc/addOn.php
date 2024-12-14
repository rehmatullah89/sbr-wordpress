<?php
// Hook the AJAX callback function.
add_action('wp_ajax_addCIMPaymentProfile', 'addCIMPaymentProfile_callback');
/**
 * AJAX callback function to add a new CIM payment profile.
 *
 * @since 1.0.0
 */
function addCIMPaymentProfile_callback()
{
    $response = array();

    $curl = curl_init();
    $card_account_number = isset($_REQUEST['wc-authorize-net-cim-credit-card-account-number']) ? $_REQUEST['wc-authorize-net-cim-credit-card-account-number'] : 0;
    $month = isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-month']) ? $_REQUEST['wc-authorize-net-cim-credit-card-expiry-month'] : 0;
    $year = isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-year']) ? $_REQUEST['wc-authorize-net-cim-credit-card-expiry-year'] : 0;
    $profile_id = isset($_REQUEST['wc_authorize_net_cim_customer_profile_id']) ? $_REQUEST['wc_authorize_net_cim_customer_profile_id'] : 0;
    $order_id = $_REQUEST['order_id'];
    $old_order = wc_get_order($order_id);

    $is_billing_address_changed = isset($_REQUEST['is_billing_address_changed']) ? $_REQUEST['is_billing_address_changed'] : 'old';
    if ($is_billing_address_changed == 'new') {

        $first_name = isset($_REQUEST['fname']) ? $_REQUEST['fname'] : '';
        $last_name = isset($_REQUEST['lname']) ? $_REQUEST['lname'] : '';
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $postcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : '';
        $state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
        $country = isset($_REQUEST['country']) ? $_REQUEST['country'] : '';
        $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
    } else {

        $first_name = $old_order->get_billing_first_name();
        $last_name = $old_order->get_billing_last_name();
        $phone = $old_order->get_billing_phone();
        $address = $old_order->get_billing_address_1() . ' ' . $old_order->get_billing_address_2();
        $city = $old_order->get_billing_city();
        $postcode = $old_order->get_billing_postcode();
        $state = $old_order->get_billing_state();
        $country = $old_order->get_billing_country();
    }

    /**
     * Prepare the JSON data for creating a customer payment profile.
     *
     * @since 1.0.0
     */
    $data = '{
        "createCustomerPaymentProfileRequest": {
            "merchantAuthentication": {
          "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
          "customerProfileId": "' . $profile_id . '",
          "paymentProfile": {
              "billTo": {
              "firstName": "' . $first_name . '",
              "lastName": "' . $last_name . '",
              "address": "' . $address . '",
              "city": "' . $city . '",
              "state": "' . $state . '",
              "zip": "' . $postcode . '",
              "country": "' . $country . '",
              "phoneNumber": "' . $phone . '"
            },
            "payment": {
              "creditCard": {
                "cardNumber": "' . $card_account_number . '",
                "expirationDate": "' . $year . '-' . $month . '"
              }
            },
            "defaultPaymentProfile": false
          },
          "validationMode": "' . SB_AUTHORIZE_ENV . '"
        }
      }';
    /**
     * Perform the cURL request to Authorize.Net CIM API for adding a payment profile.
     *
     * @since 1.0.0
     */
    curl_setopt_array($curl, array(
        CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $str = curl_exec($curl);
    curl_close($curl);

    for ($i = 0; $i <= 31; ++$i) {
        $response = str_replace(chr($i), "", $str);
    }
    $response = str_replace(chr(127), "", $str);
    if (0 === strpos(bin2hex($response), 'efbbbf')) {
        $response = substr($response, 3);
    }
    $response = json_decode($response, true);
    $response_msg = '';
    $no_error_flag = false;
    $ajax_response = array();

    if (isset($response['customerPaymentProfileId']) && (isset($response['messages']['resultCode']) && $response['messages']['resultCode'] == 'Ok')) {
        $no_error_flag = true;
        $response_msg = isset($response['messages']['message'][0]['text']) ? $response['messages']['message'][0]['text'] : '';
        $paymentProfileID = $response['customerPaymentProfileId'];
        $payment_json_data = '{
    "getCustomerPaymentProfileRequest": {
        "merchantAuthentication": {
            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
        "customerProfileId": "' . $profile_id . '",
                    "customerPaymentProfileId": "' . $paymentProfileID . '",
        "includeIssuerInfo": "true"
    }
}';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payment_json_data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $str = curl_exec($curl);
        curl_close($curl);

        for ($i = 0; $i <= 31; ++$i) {
            $response = str_replace(chr($i), "", $str);
        }
        $response = str_replace(chr(127), "", $str);
        if (0 === strpos(bin2hex($response), 'efbbbf')) {
            $response = substr($response, 3);
        }
        $response = json_decode($response, true);
        $last4Digits = preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number);
        $token = new WC_Payment_Token_CC();
        $token->set_token($paymentProfileID);
        $token->set_gateway_id('authorize_net_cim_credit_card');
        if (isset($response['paymentProfile']['payment']['creditCard']['cardType'])) {
            $token->set_card_type(strtolower($response['paymentProfile']['payment']['creditCard']['cardType']));
        } else {
            $token->set_card_type('visa');
        }
        $token->create(); // save to database
        $token->set_last4($last4Digits);
        $token->set_expiry_month($month);
        $token->set_expiry_year($year);
        $token->set_expiry_year($year);
        $token->set_user_id($old_order->get_user_id());
        $token->save();
        // WC_Authorize_Net_CIM_Payment_Profile::set_customer_profile_id($profile_id);
    } else {
        if (isset($response['messages']['resultCode']) && $response['messages']['resultCode'] == 'Error') {
            $no_error_flag = false;
            $response_msg = isset($response['messages']['message'][0]['text']) ? $response['messages']['message'][0]['text'] : '';
        }
    }
    $ajax_response['resultCase'] = $no_error_flag;
    $ajax_response['resultText'] = $response_msg;
    /**
     * Prepare the HTML for displaying payment tokens in the response.
     *
     * @since 1.0.0
     */
    $html = '';
    $tokens = WC_Payment_Tokens::get_customer_tokens($old_order->get_user_id(), 'authorize_net_cim_credit_card');
    if ($tokens) {
        $token_key_last = array_key_last($tokens);
        $alreadyMark = false;
        foreach ($tokens as $key => $token) {

            $getCC = array(
                'mastercard' => __('MasterCard', 'woocommerce'),
                'visa' => __('Visa', 'woocommerce'),
                'discover' => __('Discover', 'woocommerce'),
                'americanexpress' => __('American Express', 'woocommerce'),
                'diners' => __('Diners', 'woocommerce'),
                'jcb' => __('JCB', 'woocommerce'),
            );
            $html .= '<tr>';
            $html .= '<td>' . $getCC[$token->get_card_type()] . '</td>';
            $html .= '<td>' . $token->get_last4() . '</td>';
            $html .= '<td>' . $token->get_expiry_month() . '/' . $token->get_expiry_year() . '</td>';
            $html .= '<td>';
            $html .= '<label><span class="profile_cim">' . $token->get_token() . '</span>';
            $markedAsDefault = '';
            if ($token->is_default() || ($token_key_last == $key && $alreadyMark == false)) {
                $alreadyMark = true;
                $markedAsDefault = 'checked="checked"';
            }
            $html .= '<input name="wc_payment_gateway_authorize_net_cim_credit_card_tokens" value="' . $token->get_id() . '" type="radio"  ' . $markedAsDefault . ' />';
            $html .= '</label>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="4">No record found.</td></tr>';
    }
    $ajax_response['resultHTML'] = $html;
    if ($ret != '') {
        return true;
    }
    // Send the JSON response.
    echo json_encode($ajax_response);
    die;
}
/**
 * Generate a random reference ID with the specified length.
 *
 * @param int $length The length of the reference ID to generate.
 *
 * @return string The generated reference ID.
 *
 * @since 1.0.0
 */
function refId_mbt($length)
{
    $result = '';

    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}
// Hook the AJAX callback function.
add_action('wp_ajax_analyze_impression_save', 'analyze_impression_save_callback');
/**
 * AJAX callback function to save and analyze impressions.
 *
 * @since 1.0.0
 */
function analyze_impression_save_callback()
{
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $log_id = $_REQUEST['log_id'];
    $impression_trayType = $_REQUEST['impression_tray'];
    if ($impression_trayType == 1) {
        $single_putty = $_REQUEST['single_putty'];
        if ($single_putty == 4) {
            $event_id = 6;
        } else {
            $event_id = 7;
        }
        $save = $single_putty;
    } else {
        $upper = $_REQUEST['upper'];
        $lower = $_REQUEST['lower'];

        $save = $upper . $lower;
        $accept = false;
        if ($upper && $lower) {
            $accept = true;
            $event_id = 6;
        } else {
            $event_id = 7;
        }
    }
    // Additional information and package note.
    $packageNote = $_REQUEST['packaging_order_note'];
    // Generate HTML based on save value.
    $html = '';
    if ($save == '00') {
        $html .= 'Both impressions bad';
    } else if ($save == '01') {
        $html .= 'Upper impression bad &#13;&#10;';
        $html .= 'Lower impression good';
    } else if ($save == '10') {
        $html .= 'Upper impression good &#13;&#10;';
        $html .= 'Lower impression bad';
    } else if ($save == '11') {
        $html .= 'Both impressions good';
    } else if ($save == '4') {
        $html .= 'Impression good';
    } else if ($save == '3') {
        $html .= 'Impression bad';
    }

    // Log the impression analysis event.

    $packageNote = $packageNote . ' &#13;&#10;' . $html;
    global $wpdb;
    $update = array(
        'log_update' => 1,
        'note' => $packageNote,
        'extra_information' => $save
    );
    $condition = array(
        "log_id" => $log_id
    );
    // smile_brillaint_logs($order_id , 'Text');
    $wpdb->update(SB_LOG, $update, $condition);
    $event_data = array(
        "order_id" => $order_id,
        "child_order_id" => 0,
        "item_id" => $item_id,
        "product_id" => $product_id,
        "event_id" => $event_id,
        "extra_information" => $save,
    );
    sb_create_log($event_data);
    die;
}

add_action('wp_ajax_analyze_impression_putty', 'analyze_impression_putty_callback');
/**
 * AJAX callback function to analyze and save dental impression information.
 *
 * @since 1.0.0
 */
function analyze_impression_putty_callback()
{

    // Retrieve data from AJAX request.
    $order_id = $_REQUEST['order_id'];
    $product_id = $_REQUEST['product_id'];
    $item_id = $_REQUEST['item_id'];
    $impression_status = $_REQUEST['impression_status'];
    $log_id = $_REQUEST['log_id'];
    $getProductImpressionType = get_post_meta($product_id, 'impression_tray', true);

    global $wpdb;
    /*
      $q_last = "SELECT  note FROM  " . SB_LOG;
      $q_last .= " WHERE log_id = " . $_REQUEST['log_id'];
      $existing_note = $wpdb->get_var($q_last);
     */
?>
    <form id="analyzing_impression_form">
        <h2>Analyzing dental impression</h2>
        <table class="widefat" id="addon-table">
            <input type="hidden" name="action" value="analyze_impression_save" />
            <input type="hidden" name="log_id" value="<?php echo $log_id; ?>" />
            <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            <input type="hidden" name="impression_tray" value="<?php echo $getProductImpressionType; ?>" />

            <thead>
                <tr>
                    <th></th>
                    <th>Accept</th>
                    <th>Reject</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($getProductImpressionType == 2) {
                    $upper = false;
                    $lower = false;
                    if (isset($_REQUEST['impression_status']) && $_REQUEST['impression_status'] <> '') {
                        if ($_REQUEST['impression_status'] == '01') {
                            $upper = true;
                            $lower = false;
                        }
                        if ($_REQUEST['impression_status'] == '10') {
                            $upper = false;
                            $lower = true;
                        }
                        if ($_REQUEST['impression_status'] == '00') {
                            $upper = true;
                            $lower = true;
                        }
                    } else {
                        $upper = true;
                        $lower = true;
                    }

                    if ($upper) {
                ?>
                        <tr>
                            <td>
                                <label for="upper_putty">Upper dental impression</label>
                            </td>
                            <td>
                                <input type="radio" id="upper_putty" name="upper" value="1" checked="">
                            </td>
                            <td>
                                <input type="radio" id="upper_putty" name="upper" value="0">
                            </td>
                        </tr>
                    <?php
                    } else {
                        echo '<input type="hidden" id="upper_putty" name="upper" value="1" />';
                    }
                    if ($lower) {
                    ?>
                        <tr>
                            <td>
                                <label for="upper_putty">Lower dental impression</label>
                            </td>
                            <td>
                                <input type="radio" id="lower_putty" name="lower" value="1" checked="">
                            </td>
                            <td>
                                <input type="radio" id="lower_putty" name="lower" value="0">
                            </td>
                        </tr>
                    <?php
                    } else {
                        echo '<input type="hidden" id="lower_putty" name="lower" value="1" />';
                    }
                } else {
                    ?>
                    <tr>
                        <td>
                            <label for="single_putty_yes">Dental impression</label>
                        </td>
                        <td>
                            <input type="radio" id="single_putty_yes" name="single_putty" value="4" checked="">
                        </td>
                        <td>
                            <input type="radio" id="single_putty_no" name="single_putty" value="3">
                        </td>
                    </tr>
                <?php
                }
                ?>


            </tbody>
        </table>
        <div id="addNoteForm">
            <div class="shipment-container">
                <div class="shipmemt-header flex-row justify-content-between">
                    <h3>Add Note</h3>
                </div>
            </div>
            <div class="shipiing-setup">
                <textarea name="packaging_order_note" rows="4" cols="10" style="width: 100%;"></textarea>
            </div>

        </div>
    </form>
    <div class="addOn-modal-footer">
        <button type="button" id="close_order_popup" class="btn btn-danger button">Close</button>
        <div class="addOn-modal-footer_create">
            <button data-bb-handler="Charge" type="button" id="analyzing_impression_btn" class="btn btn-danger button">Save</button>
        </div>

    </div>


    <?php
    die;
}

function addRmaAddonProducts_bkkk($warranty_claim_id, $order_id)
{
    $result = warranty_load($warranty_claim_id);
    if ($result) {
        foreach ($result['products'] as $warranty_product) {
            $addonProduct = wc_get_product($warranty_product['product_id']);
            $item_id = $warranty_product['order_item_index'];
    ?>

            <tr id="parentAddonTr">
                <td>
                    <input type="hidden" name="product_id[]" value="<?php echo $warranty_product['product_id']; ?>" />
                    <strong><?php echo get_the_title($warranty_product['product_id']); ?></strong>
                </td>
                <td>
                    <?php
                    global $wpdb;
                    $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                    ?>
                    <input type="hidden" name="addon_tray_number[]" value="<?php echo $query_tray_no; ?>" class="addon_tray_number" />
                    <strong><?php echo $query_tray_no; ?></strong>
                </td>
                <td>
                    <?php
                    $price = 0;
                    if ($addonProduct->get_price()) {
                        $price = number_format($addonProduct->get_price(), 2);
                    }
                    ?>
                    <input type="hidden" name="price[]" value="<?php echo $price; ?>" class="price_addon" />
                    <strong><span class="currencySign">$</span><?php echo $price; ?></strong>
                </td>
                <td>
                    <input type="hidden" name="item_qty[]" value="<?php echo $warranty_product['quantity']; ?>" class="quantity_addon" />
                    <strong><?php echo $warranty_product['quantity']; ?></strong>
                </td>
                <td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_addon"></td>
                <td>
                    <input type="hidden" name="sub_total[]" value="<?php echo $price; ?>" class="subtotal_addon" />
                    <strong id="subtotal_addon_parent"><span class="currencySign">$</span><?php echo $price; ?></strong>

                </td>
                <td>
                    <a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a>
                </td>
            </tr>

    <?php
        }
    }
}

add_action('wp_ajax_create_addon_order_popup', 'create_addon_order_popup_callback');
/**
 * Function for addon order . proceed order create request using popup information
 *
 */
function create_addon_order_popup_callback()
{
    global $wpdb;
    $tax_query = array();
    $old_order_product_id = 0;
    $old_order_item_id = 0;
    $impression_status = 0;
    if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('raw', 'packaging', 'landing-page'),
            'operator' => 'NOT IN',
        );
    } else if (isset($_REQUEST['splitOrder']) && $_REQUEST['splitOrder'] == 1) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('raw', 'packaging', 'landing-page'),
            'operator' => 'NOT IN',
        );
    } else {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'addon',
        );
        $old_order_product_id = $_REQUEST['product_id'];
        $old_order_item_id = $_REQUEST['item_id'];
        $impression_status = $_REQUEST['impression_status'];
        $addonChildProduct = get_post_meta($old_order_product_id, 'addonChildProduct', true);
        $addonProduct = wc_get_product($addonChildProduct);
    }
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query
    );

    $product_list = get_posts($args);

    $products_options = '<option value="">Select Product</option>';
    foreach ($product_list as $prod_id) {
        $product = wc_get_product($prod_id);
        if ($product->get_price() == '') {
            $p_price = 0;
        } else {
            $p_price = number_format($product->get_price(), 2);
        }

        $products_options .= '<option value="' . $prod_id . '" data-price= "' . $p_price . '">' . $prod_id . '  - ' . get_the_title($prod_id) . '</option>';
    }

    $order_id = $_REQUEST['order_id'];

    $log_id = $_REQUEST['log_id'];
    $order = wc_get_order($order_id);
    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $user_id = $order->get_user_id();
    if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
        echo ' <h2 class="addonpouptitle">Product Replacement for Order# ' . $orderSBRref . '</h2>';
    } else if (isset($_REQUEST['splitOrder']) && $_REQUEST['splitOrder'] == 1) {
        echo ' <h2 class="addonpouptitle">Split Order Request against Order# ' . $orderSBRref . '</h2>';
    } else {
        echo ' <h2 class="addonpouptitle">Addon Request against Order# ' . $orderSBRref . '</h2>';
    }
    ?>
    <style>
        .addRMAProduct.disableClick {
            pointer-events: none;
        }
    </style>
    <form id="addOn_order_form">

        <?php
        $orderPriceTotal = 0;
        $price = 0;
        if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
            echo '<table class="widefat" id="addon-table"><thead>';
            echo '<tr>';
            echo '<th>Product</th>';
            echo '<th>Tray#</th>';
            //echo '<th>Price</th>';
            //echo '<th>Order Qty</th>';
            //echo '<th>Qty</th>';
            //echo '<th>Discount (%)</th>';
            //echo '<th>Sub Total</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead><tbody>';
            $addedProductInTable = 0;
            foreach ($order->get_items() as $item_id => $item) {
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                    continue;
                }
                $product = $item->get_product();
                $pro_price = $product->get_price();
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $product_id = $item->get_product_id();
                $qtyShipped = 0;

                $rmaShippedQty = 0;
                $type = 'simple';
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product) {
                    $type = 'composite';
                    $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                    if ($shippedhistory) {
                        $rmaShippedQty = 1;
                    } else {
                        $rmaShippedQty = 0;
                    }
                } else {
                    $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                    if ($shippedhistory) {
                        foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                            $qtyShipped += (int) $shippedhistoryQty;
                        }
                    }
                    $rmaShippedQty = $qtyShipped;
                }

                $query = "SELECT event_id FROM  " . SB_LOG;
                $query .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
                $query .= " ORDER BY log_id DESC";
                $query_q0 = $wpdb->get_var($query);
                if ($query_q0 == 17) {
                    continue;
                }
                $addedProductInTable++;
        ?>

                <tr id="parentAddonTr">
                    <td>
                        <strong><?php echo get_the_title($product_id); ?></strong>
                    </td>
                    <td>
                        <?php
                        $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                        if ($query_tray_no == '') {
                            $query_tray_no = 'N/A';
                        }
                        ?>
                        <strong><?php echo $query_tray_no; ?></strong>
                    </td>
                    <?php /*
                      <td>
                      <?php
                      $current_productQtyPrice = number_format(($pro_price * $item_quantity), 2);
                      $orderPriceTotal = $orderPriceTotal + $current_productQtyPrice;
                      ?>
                      <input type="hidden" name="price[]" value="<?php echo $pro_price; ?>" class="price_addon"/>
                      <strong><span class="currencySign">$</span><?php echo $pro_price; ?></strong>
                      </td>
                      <?php
                      if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
                      echo '<input type="hidden" name="item_id[]" value="' . $item_id . '" class="replace_item_id"/>';
                      echo '<td>';
                      echo '<strong>' . $item_quantity . '</strong>';
                      echo '</td>';
                      }
                      ?>
                      <td>
                      <input type="number" name="item_qty[]" value="<?php echo $rmaShippedQty; ?>" class="quantity_addon" min="1" max="<?php echo $rmaShippedQty; ?>"/>

                      </td>
                      <td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0"
                      size="4" class="discount_addon"></td>
                      <td>
                      <input type="hidden" name="sub_total[]" value="<?php echo $current_productQtyPrice; ?>" class="subtotal_addon"/>
                      <strong id="subtotal_addon_parent"><span class="currencySign">$</span><?php echo $current_productQtyPrice; ?></strong>

                      </td>
                     */ ?>
                    <td>
                        <a href="javascript:;" onclick="addRMAProducts(<?php echo $item_id ?>, <?php echo $product_id ?>, '<?php echo $pro_price ?>', '<?php echo get_the_title($product_id) ?>', '<?php echo $query_tray_no ?>', <?php echo $rmaShippedQty; ?>, '<?php echo $type; ?>')" class="addRMAProduct">Add Product</a>
                        <!-- <a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a> -->
                    </td>
                </tr>

            <?php
            }
            if ($addedProductInTable == 0) {
                echo ' <tr id="parentAddonTr"><td colspan="3">No Prdocut Available For RMA</td></tr>';
                die;
            }
            $price = number_format($orderPriceTotal, 2);
            echo ' </tbody>';
            echo ' </table>';

            echo '<table class="widefat" id="rma-new-table"><thead>';
            echo '<tr>';
            echo ' <th>Affected Product</th>';
            echo ' <th>Replacement Product</th>';
            echo ' <th>Tray#</th>';
            echo ' <th>Price</th>';
            echo ' <th>Qty</th>';
            echo ' <th>Discount (%)</th>';
            echo ' <th>Sub Total</th>';
            echo ' <th>Action</th>';
            echo '</tr>';
            echo ' </thead><tbody>';
            echo ' </tbody>';
            echo ' </table>';
        } else if (isset($_REQUEST['splitOrder']) && $_REQUEST['splitOrder'] == 1) {

            echo '<table class="widefat" id="addon-table"><thead>';
            echo '<tr>';
            echo '<th>Product</th>';
            echo '<th>Tray#</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead><tbody>';

            foreach ($order->get_items() as $item_id => $item) {
                if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                    continue;
                }
                $product = $item->get_product();
                $pro_price = $product->get_price();
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $product_id = $item->get_product_id();
                $qtyShipped = 0;

                $rmaShippedQty = 0;
                $type = 'simple';
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product) {
                    $type = 'composite';
                    $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                    if ($shippedhistory) {
                        $rmaShippedQty = 1;
                    } else {
                        $rmaShippedQty = 0;
                    }
                } else {
                    $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                    if ($shippedhistory) {
                        foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                            $qtyShipped += (int) $shippedhistoryQty;
                        }
                    }
                    $rmaShippedQty = $qtyShipped;
                }
            ?>

                <tr id="parentAddonTr">
                    <td>
                        <strong><?php echo get_the_title($product_id); ?></strong>
                    </td>
                    <td>
                        <?php
                        global $wpdb;
                        $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                        if ($query_tray_no == '') {
                            $query_tray_no = 'N/A';
                        }
                        ?>
                        <strong><?php echo $query_tray_no; ?></strong>
                    </td>

                    <td>
                        <a href="javascript:;" id="replaceProduct_<?php echo $item_id ?>" onclick="addRMAProducts(<?php echo $item_id ?>, <?php echo $product_id ?>, '<?php echo $pro_price ?>', '<?php echo get_the_title($product_id) ?>', '<?php echo $query_tray_no ?>', <?php echo $rmaShippedQty; ?>, '<?php echo $type; ?>' , this)" class="addRMAProduct">Add Product</a>

                    </td>
                </tr>

            <?php
            }
            $price = number_format($orderPriceTotal, 2);
            echo ' </tbody>';
            echo ' </table>';

            echo '<table class="widefat" id="rma-new-table"><thead>';
            echo '<tr>';
            echo ' <th>Product</th>';
            echo ' <th>Tray#</th>';
            echo ' <th>Price</th>';
            echo ' <th>Qty</th>';
            echo ' <th>Discount (%)</th>';
            echo ' <th>Sub Total</th>';
            echo ' <th>Action</th>';
            echo '</tr>';
            echo ' </thead><tbody>';
            echo ' </tbody>';
            echo ' </table>';
        } else {
            echo '<table class="widefat" id="addon-table"><thead>';
            echo '<tr>';
            echo ' <th>Product</th>';
            echo ' <th>Tray#</th>';
            echo ' <th>Price</th>';
            echo ' <th>Qty</th>';
            echo ' <th>Discount (%)</th>';
            echo ' <th>Sub Total</th>';
            echo ' <th>Action</th>';
            echo '</tr>';
            echo ' </thead><tbody>';
            ?>
            <tr id="parentAddonTr">
                <td>
                    <input type="hidden" name="product_id[]" value="<?php echo $addonChildProduct; ?>" />
                    <strong><?php echo $addonProduct->get_name(); ?></strong>
                </td>
                <td>
                    <?php
                    global $wpdb;
                    $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $old_order_item_id");
                    ?>
                    <!-- <input type="text" name="addon_tray_number[]" value="<?php //echo $query_tray_no;            
                                                                                ?>" class="addon_tray_number"/> -->
                    <span> <?php echo $query_tray_no; ?></span>
                </td>
                <td>
                    <?php
                    if ($addonProduct->get_price()) {
                        $price = number_format($addonProduct->get_price(), 2);
                    }
                    ?>
                    <input type="hidden" name="price[]" value="<?php echo $price; ?>" class="price_addon" />
                    <strong><span class="currencySign">$</span><?php echo $price; ?></strong>
                </td>
                <td>
                    <input type="number" name="item_qty[]" value="1" min="1" max="10" class="quantity_addon" />
                    <!-- <strong>1</strong> -->
                </td>
                <td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_addon"></td>
                <td>
                    <input type="hidden" name="sub_total[]" value="<?php echo $price; ?>" class="subtotal_addon" />
                    <strong id="subtotal_addon_parent"><span class="currencySign">$</span><?php echo $price; ?></strong>

                </td>
                <td>
                    <a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a>
                </td>
            </tr>

            </tbody>
            <?php // if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] == 0) {   
            ?>
            <tfoot>
                <tr>
                    <td colspan="3"><button id="add_addon_product_btn" class="button" onclick="addAddonProducts()" type="button">Add Product</button>
                    </td>
            </tfoot>
            <?php //}   
            ?>
            </table>
        <?php
        }
        ?>
        <div id="addon_summery">
            <table class="widefat">
                <tbody>
                    <tr style="display: none">
                        <td colspan="3"><b>Email</b></td>
                        <td colspan="3" style="text-align: left !important;"><label>Send if Checked.&nbsp;&nbsp;<input type="checkbox" id="addOnEmail" name="addOnEmail" /></label></td>
                    </tr>

                    <tr>
                        <td colspan="3"><b>Shipping Method</b></td>
                        <td colspan="3">
                            <?php
                            $shipping_county = get_post_meta($order_id, 'shipping_country', true);
                            if ($shipping_county) {
                                echo get_shipping_methods_by_country_code($shipping_county, true);
                            } else {
                                echo get_shipping_methods_by_country_code('US', true);
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Shipping Cost</b></td>
                        <td colspan="3"><span class="currencySign">$</span><input type="text" value="0.00" id="addOnShippingCostAmount" name="addOnShippingCostAmount" style="width: 99%;" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Total</b></td>
                        <td colspan="3"><span class="currencySign">$</span><input type="text" value="<?php echo $price; ?>" id="addOnTotalAmount" name="addOnTotalAmount" style="width: 99%;" /></td>
                    </tr>
                </tbody>

            </table>
        </div>
        <div class="ready-toship">
            <h4>Payment Via</h4>
            <label for="is_payment_via_email">
                <input name="payment_via" id="is_payment_via_email" type="radio" checked="" value="email">
                <span class="billing-different">Email invoice / order details to customer</span>
            </label>
            <label for="is_payment_via_cc">
                <input name="payment_via" id="is_payment_via_cc" type="radio" value="cc">
                <span class="billing-different">Payment Via Credit Card</span>
            </label>

            <?php
            //   $shipping_county = get_post_meta($order_id, 'shipping_country', true);
            // if($shipping_county == 'US'){
            ?>
            <label for="is_payment_via_free">
                <input name="payment_via" id="is_payment_via_free" type="radio" value="free">
                <span class="billing-different">Free</span>
            </label>
            <?php
            //}
            ?>

        </div>
        <div class="form-body-ship" style="display: none" id="is_payment_via_changed_tbody">
            <?php customerAddOrder_paymentProfiles($user_id); ?>
        </div>

        <input name="wc_authorize_net_cim_customer_profile_id" value="<?php echo get_user_meta($user_id, USER_CIM_PROFILE_ID, true); ?>" type="hidden" />



        <?php
        if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
            echo '<input type="hidden" id="warranty_claim_id" name="warranty_claim_id" value="' . $_REQUEST['warranty_claim_id'] . '" />';
        } else {
            echo '<input type="hidden" name="old_order_item_id" value="' . $old_order_item_id . '" />';
            echo '<input type="hidden" name="parent_product_id" value="' . $old_order_product_id . '" />';
            echo '<input type="hidden" name="order_id" value="' . $order_id . '" />';
            echo '<input type="hidden" name="impression_status" value="' . $impression_status . '" />';
        }
        echo '<input type="hidden" name="order_id" value="' . $order_id . '" />';
        echo '<input type="hidden" name="log_id" value="' . $log_id . '" />';
        echo '<input type="hidden" name="action" value="creatAddon" />';
        ?>
    </form>

    <style>
        .flex-row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-sm-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-sm-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }


        .col-sm-6,
        .col-sm-4 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        select#wc-authorize-net-cim-credit-card-expiry-month {
            width: 100%;
            max-width: 100% !important;
        }

        .ustom-shipping-address .form-group {
            margin-top: 1rem;
        }
    </style>

    <div class="addOn-modal-footer" id="addOn-modal-footer_cc">
        <button type="button" id="close_order_popup" class="btn btn-danger button">Close</button>
        <div class="addOn-modal-footer_create">
            <?php
            if (isset($_REQUEST['warranty_claim_id']) && $_REQUEST['warranty_claim_id'] != 0) {
                echo '<button data-bb-handler="Charge" type="button" id="generate_addOn_order" class="btn btn-danger button">Create RMA Order</button>';
            } else {
                echo '<button data-bb-handler="Charge" type="button" id="generate_addOn_order" class="btn btn-danger button">Create Addon Order</button>';
            }
            ?>


        </div>

    </div>
    <div id="addon_ajax_response"></div>

    <script>
        function addAddonProducts() {
            var html = '';
            html += '<tr>';
            html += '<td><select class="add_products" name="product_id[]"><?php echo $products_options; ?></select></td>';
            html += '<td><input type="text" name="addon_tray_number[]" value="" class="addon_tray_number"/></td>';
            html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="price[]" placeholder="0.00" size="4" class="price_addon"></td>';
            html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="item_qty[]" placeholder="1" size="4" class="quantity_addon"></td>';
            html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="quantity_addon"></td>';
            html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon"></td>';
            html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
            html += '</tr>';
            jQuery("body").find("#smile_brillaint_order_popup_response #addon-table tbody").append(html); //add input box
            jQuery(".add_products").select2({
                placeholder: "Please select product.",
                allowClear: true,
                width: '100%'
            });
        }

        function addRMAProducts(item_id, product_id, product_price, item_title, tryno, ship_qty, type, currentObj) {

            var contt = true;
            jQuery(currentObj).addClass('disableClick');
            jQuery(document).find('.rma-itemid').each(function() {
                vall = jQuery(this).val();

                if (vall == item_id) {
                    contt = false;
                }

            });
            if (contt) {
                var html = '';
                if (type == 'simple') {
                    html += '<tr>';
                    <?php if (!isset($_REQUEST['splitOrder'])) {
                    ?>
                        html += '<td colspan="2"><span>' + item_title + '</span>';
                    <?php
                    } else {
                    ?>
                        html += '<td colspan="1"><span>' + item_title + '</span>';
                    <?php }
                    ?>

                    html += '<input type="hidden" class="rma-itemid"  name="parent_item_id[]" value="' + item_id + '"/>';
                    html += '<input type="hidden" class="rma-productid"  name="parent_product_id[]" value="' + product_id + '"/>';
                    html += '<input type="hidden" name="type[]" value="' + type + '" />';
                    html += '<input type="hidden"  name="addon_tray_number[]" value="0" class="addon_tray_number"/>';
                    html += '<input type="hidden" name="product_id[]" value="' + product_id + '" /></td>';
                    html += '<td>N/A</td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" value="' + product_price + '" autocomplete="off" readonly="" name="price[]" placeholder="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="' + ship_qty + '" max="' + ship_qty + '" value="' + ship_qty + '" autocomplete="off" name="item_qty[]"  placeholder="1" size="2" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_addon"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" value="' + product_price * ship_qty + '" placeholder="0" size="4" class="subtotal_addon"></td>';
                    html += '<td><a href="javascript:;" onclick="removeClassReplace(' + item_id + ')"  class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                } else {
                    html += '<tr>';
                    html += '<td><span>' + item_title + '</span>';
                    html += '<input type="hidden" class="rma-itemid"  name="parent_item_id[]" value="' + item_id + '"/>';
                    html += '<input type="hidden" name="type[]" value="' + type + '" />';
                    html += '<input type="hidden" class="rma-productid"  name="parent_product_id[]" value="' + product_id + '"/></td>';
                    <?php if (!isset($_REQUEST['splitOrder'])) {
                    ?>
                        html += '<td><select class="add_products" name="product_id[]"><?php echo $products_options; ?></select></td>';
                    <?php }
                    ?>

                    html += '<td><span>' + tryno + '</span><input type="hidden"  name="addon_tray_number[]" value="' + tryno + '" class="addon_tray_number"/></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="price[]" placeholder="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="' + ship_qty + '" max="' + ship_qty + '" value="' + ship_qty + '" autocomplete="off" name="item_qty[]"  placeholder="1" size="2" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="quantity_addon"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon"></td>';
                    html += '<td><a href="javascript:;"  onclick="removeClassReplace(' + item_id + ')" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                }
                jQuery("body").find("#smile_brillaint_order_popup_response #rma-new-table tbody").append(html); //add input box
                jQuery(".add_products").select2({
                    placeholder: "Please select product.",
                    allowClear: true,
                    width: '100%'
                });
                console.log('Clicked')
                jQuery('#addOn_order_form').find('.quantity_addon').each(function(i, obj) {
                    jQuery(this).trigger('change');
                });
            }
        }

        function removeClassReplace(itmeId) {
            jQuery('body').find('#replaceProduct_' + itmeId).removeClass('disableClick');
        }

        setTimeout(() => {

            jQuery("body").find("#shipping_method_mbt").trigger("change");
        }, 100);
        jQuery(".add_products").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });
        jQuery('body').on('click', '#close_order_popup', function() {
            smile_brillaint_order_modal.style.display = "none";
        });
        jQuery("body").on('click', 'input[name="payment_via"]', function(event) {

            if (jQuery(this).val() == 'cc') {
                jQuery('#is_payment_via_changed_tbody').show();
                jQuery("body").find('#billingInfoAdminArea').hide();
                jQuery("body").find('#shippinginfoAdminArea').removeClass('col-sm-6').addClass('col-sm-12');

            } else {
                jQuery('#is_payment_via_changed_tbody').hide();
                jQuery("body").find('#billingInfoAdminArea').show();
                jQuery("body").find('#shippinginfoAdminArea').removeClass('col-sm-12').addClass('col-sm-6');
            }

            if (jQuery(this).val() == 'free') {
                jQuery('#addOn_order_form').find('.discount_addon').each(function(i, obj) {
                    jQuery(this).val(0);
                    jQuery(this).prop('disabled', true);
                });
                jQuery('#addOn_order_form').find('.quantity_addon').each(function(i, obj) {
                    jQuery(this).trigger('change');
                });
                jQuery("body").find("#addOn_order_form #addOnShippingCostAmount").val(0);
                jQuery("body").find("#addOn_order_form #addOnShippingCostAmount").trigger('change');

                document.getElementById("shipping_method_mbt").selectedIndex = 0; //1 = option 2
                jQuery('#addOnTotalAmount').val(0);

            } else {
                jQuery('#addOn_order_form').find('.discount_addon').each(function(i, obj) {
                    jQuery(this).prop('disabled', false);
                });
                jQuery('#addOn_order_form').find('.quantity_addon').each(function(i, obj) {
                    jQuery(this).trigger('change');
                });
            }
        });

        jQuery("body").find("#smile_brillaint_order_modal #addOn_order_form").on("change",
            ".add_products , .quantity_addon  , .discount_addon",
            function(e) {

                $getParentTr = jQuery(this).closest('tr');
                if ($getParentTr.attr('id') == 'parentAddonTr') {
                    $product_price = $getParentTr.find('input[name="price[]"]').val();
                    if (typeof($product_price) == "undefined") {

                        $product_price = $getParentTr.find('.price_addon').val();
                    }
                } else {
                    $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');

                    if (typeof($product_price) == "undefined") {

                        $product_price = $getParentTr.find('.price_addon').val();
                    }
                    if ($product_price == '') {
                        $product_price = 0;
                    }

                    $discount = $product_price;
                    $getParentTr.find('input[name="price[]"]').val($product_price);
                }
                // $product_price = $getParentTr.find('input[name="new_product_id[]"] option:selected').attr('data-price');

                $qty = $getParentTr.find('input[name="item_qty[]"]').val();
                $percentage = $getParentTr.find('input[name="discount[]"]').val();
                $calculated_price = 0;
                if ($qty > 0) {
                    $calculated_price = $total_price = $product_price * $qty;
                } else {
                    if ($product_price > 0) {
                        $calculated_price = $total_price = $product_price;
                    } else {
                        $calculated_price = 0.00;
                    }

                }
                if ($percentage > 0) {
                    $discount = $percentage * $total_price / 100;
                    $custom_price = $total_price - $discount;
                    $discount_price = $custom_price.toFixed(2);
                    if ($getParentTr.attr('id') == 'parentAddonTr') {
                        $getParentTr.find('#subtotal_addon_parent').html($discount_price);
                    }
                    $getParentTr.find('input[name="sub_total[]"]').val($discount_price);
                } else {
                    $calculated_price = parseFloat($calculated_price);
                    $calculated_price = $calculated_price.toFixed(2);
                    if ($getParentTr.attr('id') == 'parentAddonTr') {
                        $getParentTr.find('#subtotal_addon_parent').html($calculated_price);
                    }
                    $getParentTr.find('input[name="sub_total[]"]').val($calculated_price);
                }
                $total_addon_amount = 0;
                jQuery('#addOn_order_form').find('.subtotal_addon').each(function(i, obj) {

                    $total_addon_amount = parseFloat($total_addon_amount) + parseFloat(jQuery(obj).val());
                    addOnTotalAmount = $total_addon_amount.toFixed(2);
                });
                $shippingVal = jQuery('#addOnShippingCostAmount').val();
                if ($shippingVal) {
                    addOnTotalAmount = parseFloat(addOnTotalAmount) + parseFloat($shippingVal);
                    addOnTotalAmount = addOnTotalAmount.toFixed(2);

                }
                jQuery('#addOnTotalAmount').val(addOnTotalAmount);
            });

        jQuery("body").find("#smile_brillaint_order_modal #addOn_order_form").on("change", "#addOnShippingCostAmount", function(
            e) {
            $total_addon_amount = 0;
            var addOnTotalAmount = 0;
            jQuery('#addOn_order_form').find('.subtotal_addon').each(function(i, obj) {
                if (jQuery(obj).val()) {
                    $total_addon_amount = parseFloat($total_addon_amount) + parseFloat(jQuery(obj).val());
                    addOnTotalAmount = $total_addon_amount.toFixed(2);
                }

            });
            $shippingVal = jQuery('#addOnShippingCostAmount').val();
            if ($shippingVal) {
                addOnTotalAmount = parseFloat(addOnTotalAmount) + parseFloat($shippingVal);
                addOnTotalAmount = addOnTotalAmount.toFixed(2);

            }
            jQuery('#addOnTotalAmount').val(addOnTotalAmount);
        });
        jQuery('body').on('click', '#create_payment_profile_mbtbkk', function(e) {
            if (validate_create_profile_mbt()) {
                $validate_cc = true;
                $ccno = jQuery('body').find('#wc-authorize-net-cim-credit-card-account-number');
                $expiry_month = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-month');
                $expiry_year = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-year');
                $csc = jQuery('body').find('#wc-authorize-net-cim-credit-card-csc');
                if ($ccno.val() == '') {
                    $validate_cc = false;
                    $ccno.css('border-color', 'red');
                } else {
                    $ccno.css('border-color', '#4BB543');
                }
                if ($expiry_year.val() == '') {
                    $validate_cc = false;
                    $expiry_year.css('border-color', 'red');
                } else {
                    $expiry_year.css('border-color', '#4BB543');
                }
                if ($expiry_month.val() == '') {
                    $validate_cc = false;
                    $expiry_month.css('border-color', 'red');
                } else {
                    $expiry_month.css('border-color', '#4BB543');
                }
                if ($csc.val() == '') {
                    $validate_cc = false;
                    $csc.css('border-color', 'red');
                } else {
                    $csc.css('border-color', '#4BB543');
                }
                if ($validate_cc) {
                    jQuery('body').find('#smile_brillaint_payment_gateway_user').empty();
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=addOrderCIMProfile'); ?>';
                    var elementT = document.getElementById("addOn_order_form");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.resultCase) {
                                Swal.fire(
                                    'Good Job!',
                                    'CIM Payment profile created successfully',
                                    'success'
                                );
                                jQuery('body').find('#smile_brillaint_payment_gateway_user').html(
                                    smile_brillaint_load_html());
                                jQuery('body').find('#addPaymentProfile_checkbox').prop('checked', false);
                                jQuery('body').find('#addPaymentProfile_checkbox').attr('checked', false);
                                jQuery('body').find('#addOn_addPaymentProfile_form').hide();
                                jQuery('body').find('#smile_brillaint_payment_gateway_user').html(response
                                    .resultHTML);
                            } else {
                                // jQuery('body').find('#smile_brillaint_payment_gateway_user').html(smile_brillaint_load_html());
                                // jQuery('body').find('#smile_brillaint_payment_gateway_user').html(response.resultHTML);
                                //jQuery('body').find('#newOrder_ajax_response').html(smile_brillaint_addOrder_fail_status_html(response.resultText));
                                //reset_response();
                                Swal.fire(
                                    'Oops!',
                                    response.resultText,
                                    'error'
                                );

                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            }

        });



        jQuery("body").find('#smile_brillaint_order_popup_response #addon-table tbody, #smile_brillaint_order_popup_response #rma-new-table tbody').on("click", ".remove_field", function(
            e) { //user click on remove text
            e.preventDefault();
            jQuery(this).closest('tr').remove();
            // add_addon_prodcut--;
            if (jQuery("body").find("#addOn_order_form .quantity_addon").length > 0) {
                jQuery("body").find("#addOn_order_form .quantity_addon").trigger('change');
            } else {
                jQuery("body").find("#addOn_order_form #addOnShippingCostAmount").trigger('change');
            }
        });
    </script>
<?php
    if (isset($_REQUEST['action']) && $_REQUEST['action'] != 'analyze_impression_putty_split') {
        die;
    }
}
