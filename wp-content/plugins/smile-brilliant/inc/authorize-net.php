<?php
add_action('wp_ajax_getCustomerPaymentProfile_ajax', 'getCustomerPaymentProfile_ajax');
/**
 * AJAX callback function to get customer payment profile information.
 *
 * @return void
 */
function getCustomerPaymentProfile_ajax() {
    $customerProfileId = $_POST['profile_id'];
    $customerPaymentProfileId = $_POST['tok'];
    $ret = false;
    echo getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId, $ret);
    die();
}
/**
 * Retrieve customer payment profile information from Authorize.Net CIM.
 *
 * @param string $customerProfileId      Customer's profile ID.
 * @param string $customerPaymentProfileId Customer's payment profile ID.
 * @param bool   $ret                    Whether to return decoded JSON response (true) or HTML-formatted information (false).
 *
 * @return mixed|string|array            Depending on the $ret parameter, it returns either the decoded JSON response or HTML-formatted information.
 */
function getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId, $ret = true) {
    $curl = curl_init();
    $request_data = array(
        'getCustomerPaymentProfileRequest' => array(
            'merchantAuthentication' => array(
                'name' => SB_AUTHORIZE_LOGIN_ID,
                'transactionKey' => SB_AUTHORIZE_TRANSACTION_KEY
            ),
            'customerProfileId' => $customerProfileId,
            'customerPaymentProfileId' => $customerPaymentProfileId,
        )
    );
    $sendJson = json_encode($request_data);

    curl_setopt_array($curl, array(
        CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $sendJson,
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
    $checkLogin = json_decode($checkLogin, true);
    $info = isset($checkLogin) ? $checkLogin : NULL;
    if ($ret) {
        return $info;
    }
    $info = isset($checkLogin['paymentProfile']['billTo']) ? $checkLogin['paymentProfile']['billTo'] : NULL;
    $html = '';
    if ($info) {
        $html .= '<p>';
        $html .= $info['firstName'] . ' ' . $info['lastName'] . '</br>';
        $html .= $info['address'] . '</br>';
        $html .= $info['city'] . '</br>';
        $html .= $info['state'] . '(' . $info['zip'] . ')' . $info['country'];
        $html .= '</p>';
    }
    return $html;
}

/**
 * Charge a payment profile using Authorize.Net CIM.
 *
 * @param array $param {
 *     An array of parameters for charging the payment profile.
 *
 *     @type int    $order_id  The ID of the WooCommerce order.
 *     @type int    $token_id  The ID of the WooCommerce payment token.
 *     @type float  $amount    The amount to charge.
 * }
 *
 * @return array {
 *     An array containing information about the payment transaction.
 *
 *     @type string $note       A note describing the payment transaction.
 *     @type bool   $errorflag  A flag indicating whether there was an error during the transaction.
 * }
 */
function sbr_chargePaymentProfile($param) {

    $refId = isset($param['order_id']) ? get_post_meta($param['order_id'], 'order_number', true) : refId_mbt(15);
    $order = wc_get_order($param['order_id']);
    $token = WC_Payment_Tokens::get($param['token_id']);
    $customer_profile_id = get_user_meta($order->get_user_id(), USER_CIM_PROFILE_ID, true);


    $curl = curl_init();
    $line_items = array();
    $order_amount = number_format($param['amount'], 2, '.', '');
    // Get and Loop Over Order Items
    foreach ($order->get_items() as $item_id => $item) {
        if (wc_cp_get_composited_order_item_container($item, $order)) {
            continue;
        }
        $item_name = preg_replace('/[^\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Zs}\p{P}\p{Sm}\p{Sc}]/u', '', $item->get_name());
        $line_items[] = array(
            'itemId' => $item_id,
            'name' => mb_strimwidth($item_name, 0, 27, '...'),
            'description' => $item_name,
            'quantity' => $item->get_quantity(),
            'unitPrice' => $item->get_total(),
        );
    }
    // Iterating through order fee items ONLY
    foreach ($order->get_fees() as $fee_id => $fee) {

        if ($order->get_item_total($fee) >= 0) {
            $fee_name = preg_replace('/[^\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Zs}\p{P}\p{Sm}\p{Sc}]/u', '', $fee->get_name());
            $line_items[] = array(
                'itemId' => $fee_id,
                'name' => mb_strimwidth($fee_name, 0, 27, '...'),
                'description' => $fee_name,
                'quantity' => 1,
                'unitPrice' => $order->get_item_total($fee),
            );
        }
    }
    // maximum of 30 line items per order
    if (count($line_items) > 30) {
        $line_items = array_slice($line_items, 0, 30);
    }
    $taxAmount = array();
    if ($order->get_total_tax() > 0) {
        $taxes = array();
        foreach ($order->get_tax_totals() as $tax_code => $tax) {
            $taxes[] = sprintf('%s (%s) - %s', $tax->label, $tax_code, $tax->amount);
        }
        $taxAmount = array(
            'amount' => $order->get_total_tax(),
            'name' => 'Order Taxes',
            'description' => 'Mo Sale Tax',
        );
    }
    $shipping = array();
    if ($order->get_total_shipping() > 0) {
        $shipping = array(
            'amount' => $order->get_total_shipping(),
            'name' => 'Order Shipping',
            'description' => $order->get_shipping_method(),
        );
    }
    $request_data = array(
        'createTransactionRequest' => array(
            'merchantAuthentication' => array(
                'name' => SB_AUTHORIZE_LOGIN_ID,
                'transactionKey' => SB_AUTHORIZE_TRANSACTION_KEY
            ),
            'refId' => $refId,
            'transactionRequest' => array(
                'transactionType' => 'authCaptureTransaction',
                'amount' => $order_amount,
                'profile' => array(
                    'customerProfileId' => $customer_profile_id,
                    'paymentProfile' => array(
                        'paymentProfileId' => $token->get_token()
                    )
                ),
                'order' => array(
                    'invoiceNumber' => $refId,
                    'description' => 'Smile Brilliant - ' . $param['order_id'] . ' - ' . $refId
                ),
                'lineItems' => array('lineItem' => $line_items),
                'tax' => $taxAmount,
                'shipping' => $shipping,
                //  'poNumber' => $refId,
                'customer' => array(
                    'id' => $order->get_user_id(),
                    'email' => $order->get_billing_email(),
                ),
                /*
                  'billTo' => array(
                  'firstName' => $order->get_billing_first_name(),
                  'lastName' => $order->get_billing_last_name(),
                  'company' => $order->get_billing_company(),
                  'address' => $order->get_billing_address_1() . ' ' . $order->get_billing_address_2(),
                  'city' => $order->get_billing_city(),
                  'state' => $order->get_billing_state(),
                  'zip' => $order->get_billing_postcode(),
                  'country' => $order->get_billing_country(),
                  'phoneNumber' => $order->get_billing_phone(),
                  ),
                  'shipTo' => array(
                  'firstName' => $order->get_shipping_first_name(),
                  'lastName' => $order->get_shipping_last_name(),
                  'company' => $order->get_shipping_company(),
                  'address' => $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2(),
                  'city' => $order->get_shipping_city(),
                  'state' => $order->get_shipping_state(),
                  'zip' => $order->get_shipping_postcode(),
                  'country' => $order->get_shipping_country(),
                  ),
                 * 
                 */
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

    $paymentFlagError = false;
    $payemt_note = '';
    $checkLogin = json_decode($checkLogin, true);
    if (isset($checkLogin['transactionResponse']) && $checkLogin['transactionResponse']['responseCode'] == 1) {
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_trans_id', $checkLogin['transactionResponse']['transId']);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_authorization_code', $checkLogin['transactionResponse']['authCode']);
        update_post_meta($param['order_id'], '_transaction_id', $checkLogin['transactionResponse']['transId']);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_trans_date', date("Y-m-d h:i:sa"));
        $getCC = array(
            'mastercard' => __('MasterCard', 'woocommerce'),
            'visa' => __('Visa', 'woocommerce'),
            'discover' => __('Discover', 'woocommerce'),
            'american express' => __('American Express', 'woocommerce'),
            'diners' => __('Diners', 'woocommerce'),
            'jcb' => __('JCB', 'woocommerce'),
        );
        $payemt_note = 'Authorize.Net Credit Card Charge Approved: ' . $getCC[$token->get_card_type()] . ' ending in ' . $token->get_last4() . ' (expires ' . $token->get_expiry_month() . '/' . $token->get_expiry_year() . ') (Transaction ID ' . $checkLogin['transactionResponse']['transId'] . ')';
        $order->update_status('processing');
    } else {
        $payemt_note = isset($checkLogin['messages']['message'][0]['text']) ? $checkLogin['messages']['message'][0]['text'] : 'Authorize.Net Transaction Failed.';
        $payemt_note = $payemt_note . ' ' . isset($checkLogin['transactionResponse']['errors'][0]['errorText']) ? $checkLogin['transactionResponse']['errors'][0]['errorText'] : '';
        $paymentFlagError = true;
        $order->update_status('failed');
    }
    $order->add_order_note($payemt_note);
    update_post_meta($param['order_id'], '_payment_method', 'authorize_net_cim_credit_card');
    update_post_meta($param['order_id'], '_payment_method_title', 'Credit Card');
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_customer_id', $customer_profile_id);
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_payment_token', $token->get_token());
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_account_four', $token->get_last4());
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_authorization_amount', $order_amount);
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_card_type', $token->get_card_type());
    update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_card_expiry_date', $token->get_expiry_year() . '-' . $token->get_expiry_month());
    return array(
        'note' => $payemt_note,
        'errorflag' => $paymentFlagError
    );
}


/**
 * Charge a credit card and pay for the order using Authorize.Net CIM.
 *
 * @param array $param {
 *     An array of parameters for charging the credit card and paying for the order.
 *
 *     @type int    $order_id     The ID of the WooCommerce order.
 *     @type string $token        The opaque data token for the credit card.
 *     @type string $description  The data descriptor for the opaque data token.
 *     @type string $expiry_date   The expiry date of the credit card.
 * }
 *
 * @return void
 */
function sbr_chargeCreditCardPayOrder($param)
{

    $refId = isset($param['order_id']) ? get_post_meta($param['order_id'], 'order_number', true) : refId_mbt(15);
    $order = wc_get_order($param['order_id']);
    $curl = curl_init();
    $line_items = array();
    $order_amount = number_format($order->get_total(), 2, '.', '');
// Get and Loop Over Order Items
    foreach ($order->get_items() as $item_id => $item) {
        if (wc_cp_get_composited_order_item_container($item, $order)) {
            continue;
        }
        $item_name = preg_replace('/[^\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Zs}\p{P}\p{Sm}\p{Sc}]/u', '', $item->get_name());
        $line_items[] = array(
            'itemId' => $item_id,
            'name' => mb_strimwidth($item_name, 0, 27, '...'),
            'description' => $item_name,
            'quantity' => $item->get_quantity(),
            'unitPrice' => $item->get_total(),
        );
    }
// Iterating through order fee items ONLY
    foreach ($order->get_fees() as $fee_id => $fee) {

        if ($order->get_item_total($fee) >= 0) {
            $fee_name = preg_replace('/[^\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Zs}\p{P}\p{Sm}\p{Sc}]/u', '', $fee->get_name());
            $line_items[] = array(
                'itemId' => $fee_id,
                'name' => mb_strimwidth($fee_name, 0, 27, '...'),
                'description' => $fee_name,
                'quantity' => 1,
                'unitPrice' => $order->get_item_total($fee),
            );
        }
    }
// maximum of 30 line items per order
    if (count($line_items) > 30) {
        $line_items = array_slice($line_items, 0, 30);
    }
    $taxAmount = array();
    if ($order->get_total_tax() > 0) {

        $taxes = array();
        foreach ($order->get_tax_totals() as $tax_code => $tax) {

            $taxes[] = sprintf('%s (%s) - %s', $tax->label, $tax_code, $tax->amount);
        }
        $taxAmount = array(
            'amount' => $order->get_total_tax(),
            'name' => 'Order Taxes',
            'description' => 'Mo Sale Tax',
        );
    }
    $shipping = array();
    if ($order->get_total_shipping() > 0) {

        $shipping = array(
            'amount' => $order->get_total_shipping(),
            'name' => 'Order Shipping',
            'description' => $order->get_shipping_method(),
        );
    }
    $request_data = array(
        'createTransactionRequest' => array(
            'merchantAuthentication' => array(
                'name' => SB_AUTHORIZE_LOGIN_ID,
                'transactionKey' => SB_AUTHORIZE_TRANSACTION_KEY
            ),
            'refId' => $refId,
            'transactionRequest' => array(
                'transactionType' => 'authCaptureTransaction',
                'amount' => $order_amount,
                'payment' => array(
                    'opaqueData' => array(
                        'dataDescriptor' => $param['description'],
                        'dataValue' => $param['token']
                    )
                ),
                'order' => array(
                    'invoiceNumber' => $refId,
                    'description' => 'Smile Brilliant - ' . $param['order_id'] . ' - ' . $refId
                ),
                'lineItems' => array('lineItem' => $line_items),
                'tax' => $taxAmount,
                'shipping' => $shipping,
                //  'poNumber' => $refId,
                'customer' => array(
                    'id' => $order->get_user_id(),
                    'email' => $order->get_billing_email(),
                ),
                'billTo' => array(
                    'firstName' => $order->get_billing_first_name(),
                    'lastName' => $order->get_billing_last_name(),
                    'company' => $order->get_billing_company(),
                    'address' => $order->get_billing_address_1() . ' ' . $order->get_billing_address_2(),
                    'city' => $order->get_billing_city(),
                    'state' => $order->get_billing_state(),
                    'zip' => $order->get_billing_postcode(),
                    'country' => $order->get_billing_country(),
                    'phoneNumber' => $order->get_billing_phone(),
                ),
                'shipTo' => array(
                    'firstName' => $order->get_shipping_first_name(),
                    'lastName' => $order->get_shipping_last_name(),
                    'company' => $order->get_shipping_company(),
                    'address' => $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2(),
                    'city' => $order->get_shipping_city(),
                    'state' => $order->get_shipping_state(),
                    'zip' => $order->get_shipping_postcode(),
                    'country' => $order->get_shipping_country(),
                ),
                'customerIP' => $order->get_customer_ip_address(),
            ),
        )
    );
    $sendJson = json_encode($request_data);

    curl_setopt_array($curl, array(
        CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $sendJson,
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

    $paymentFlagError = false;
    $payemt_note = '';
    $checkLogin = json_decode($checkLogin, true);
    $accountType = $checkLogin['transactionResponse']['accountType'];
    $accountType = strtolower($accountType);
    $accountNumber = $checkLogin['transactionResponse']['accountNumber'];
    $accountNumber = substr($accountNumber, -4);

    if (isset($checkLogin['transactionResponse']) && $checkLogin['transactionResponse']['responseCode'] == 1) {
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_trans_id', $checkLogin['transactionResponse']['transId']);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_authorization_code', $checkLogin['transactionResponse']['authCode']);
        update_post_meta($param['order_id'], '_transaction_id', $checkLogin['transactionResponse']['transId']);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_trans_date', date("Y-m-d h:i:sa"));

        $getCC = array(
            'mastercard' => __('MasterCard', 'woocommerce'),
            'visa' => __('Visa', 'woocommerce'),
            'discover' => __('Discover', 'woocommerce'),
            'american express' => __('American Express', 'woocommerce'),
            'diners' => __('Diners', 'woocommerce'),
            'jcb' => __('JCB', 'woocommerce'),
        );
        $xp_date = $param['expiry_date'];
        $xp_date_exp = explode('/', $xp_date);
        $payemt_note = 'Authorize.Net Credit Card Charge Approved: ' . $accountType . ' ending in ' . $accountNumber . '(expires ' . $xp_date . ')  (Transaction ID ' . $checkLogin['transactionResponse']['transId'] . ')';
        //  $order->update_status('processing');

        $order->add_order_note($payemt_note);
        update_post_meta($param['order_id'], '_payment_method', 'authorize_net_cim_credit_card');
        update_post_meta($param['order_id'], '_payment_method_title', 'Credit Card');
        // update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_customer_id', $customer_profile_id);
        // update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_payment_token', $token->get_token());
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_account_four', $accountNumber);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_authorization_amount', $order_amount);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_card_type', $accountType);
        update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_card_expiry_date', $xp_date_exp[1] . '-' . $xp_date_exp[0]);
        // for testing 
        update_post_meta($param['order_id'], 'invoice_number_mbt', $refId);
        update_post_meta($param['order_id'], 'order_number_meta_mbt', get_post_meta($param['order_id'], 'order_number', true));
        update_post_meta($param['order_id'], 'order_number_sq_mbt', $order->get_order_number(), 'order_number', true);
        // for testing
        mbt_goodToShip($param['order_id'], 'yes');
        $order->save();
        $order = wc_get_order($param['order_id']);
        // for testing 
        update_post_meta($param['order_id'], 'order_number_sq_aftersave_mbt', $order->get_order_number(), 'order_number', true);
        // for testing 
        create_zendesk_ticket_status_changed($order);
        wp_safe_redirect($order->get_checkout_order_received_url());
        exit;
    } else {
        $payemt_note = isset($checkLogin['messages']['message'][0]['text']) ? $checkLogin['messages']['message'][0]['text'] : 'Authorize.Net Transaction Failed.';
        $payemt_note = $payemt_note . ' ' . isset($checkLogin['transactionResponse']['errors'][0]['errorText']) ? $checkLogin['transactionResponse']['errors'][0]['errorText'] : '';
        $paymentFlagError = true;
        // $order->update_status('failed');
        $order->add_order_note($payemt_note);
        echo '<div class="alert alert-danger" role="alert">
        ' . $payemt_note . '
        </div>';
    }


    // update_post_meta($param['order_id'], '_wc_authorize_net_cim_credit_card_card_expiry_date', $token->get_expiry_year() . '-' . $token->get_expiry_month());
    //  wp_safe_redirect($order->get_checkout_order_received_url());
}

/**
 * Validate a credit card number based on the card type or a custom regex pattern.
 *
 * @param string $ccNum  The credit card number to validate.
 * @param string|array|null $type   The card type to validate ('all', 'visa', 'mastercard', etc.)
 *                                  or a custom regex pattern. Default is 'all'.
 * @param string|null $regex  A custom regex pattern for validation. If provided, $type is ignored.
 *
 * @return bool  True if the credit card is valid, false otherwise.
 */
function sbr_validateCC($ccNum, $type = 'all', $regex = null)
{

    $ccNum = str_replace(array('-', ' '), '', $ccNum);
    if (mb_strlen($ccNum) < 13) {
        return false;
    }

    if ($regex !== null) {
        if (is_string($regex) && preg_match($regex, $ccNum)) {
            return true;
        }
        return false;
    }

    $cards = array(
        'all' => array(
            'amex' => '/^3[4|7]\\d{13}$/',
            'bankcard' => '/^56(10\\d\\d|022[1-5])\\d{10}$/',
            'diners' => '/^(?:3(0[0-5]|[68]\\d)\\d{11})|(?:5[1-5]\\d{14})$/',
            'disc' => '/^(?:6011|650\\d)\\d{12}$/',
            'electron' => '/^(?:417500|4917\\d{2}|4913\\d{2})\\d{10}$/',
            'enroute' => '/^2(?:014|149)\\d{11}$/',
            'jcb' => '/^(3\\d{4}|2100|1800)\\d{11}$/',
            'maestro' => '/^(?:5020|6\\d{3})\\d{12}$/',
            'mc' => '/^5[1-5]\\d{14}$/',
            'solo' => '/^(6334[5-9][0-9]|6767[0-9]{2})\\d{10}(\\d{2,3})?$/',
            'switch' =>
            '/^(?:49(03(0[2-9]|3[5-9])|11(0[1-2]|7[4-9]|8[1-2])|36[0-9]{2})\\d{10}(\\d{2,3})?)|(?:564182\\d{10}(\\d{2,3})?)|(6(3(33[0-4][0-9])|759[0-9]{2})\\d{10}(\\d{2,3})?)$/',
            'visa' => '/^4\\d{12}(\\d{3})?$/',
            'voyager' => '/^8699[0-9]{11}$/'
        ),
        'fast' =>
        '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/'
    );

    if (is_array($type)) {
        foreach ($type as $value) {
            $regex = $cards['all'][strtolower($value)];

            if (is_string($regex) && preg_match($regex, $ccNum)) {
                return true;
            }
        }
    } elseif ($type === 'all') {
        foreach ($cards['all'] as $value) {
            $regex = $value;

            if (is_string($regex) && preg_match($regex, $ccNum)) {
                return true;
            }
        }
    } else {
        $regex = $cards['fast'];

        if (is_string($regex) && preg_match($regex, $ccNum)) {
            return true;
        }
    }
    return false;
}
/**
 * Add or update meta information for a payment token in WooCommerce.
 *
 * @param string $key         The meta key.
 * @param mixed  $val         The meta value.
 * @param int    $token_id    The ID of the payment token.
 *
 * @global wpdb $wpdb        WordPress database global object.
 *
 * @return void
 */
function addPaymentTokenMetaSBR($key, $val, $token_id)
{
    global $wpdb;

    $tbl = $wpdb->prefix . 'woocommerce_payment_tokenmeta';
    $sqlQuery = "SELECT meta_id FROM $tbl WHERE meta_key ='$key' AND  payment_token_id ='$token_id'";
    $token_meta_id = $wpdb->get_var($sqlQuery);
    if ($token_meta_id) {
        $data = array(
            'meta_value' => $val,
        );
        $where = array(
            'meta_key' => $key,
            'payment_token_id' => $token_id,
        );
        $wpdb->update($tbl, $data, $where);
    } else {
        $payment_token_data = array(
            'meta_key' => $key,
            'meta_value' => $val,
            'payment_token_id' => $token_id,
        );

        $wpdb->insert($tbl, $payment_token_data);
    }
}

add_action('wp_ajax_addCIM_profile_SBR', 'addCIM_profile_SBR_callback');
/**
 * AJAX callback to add a CIM profile for a user in the SBR system.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function addCIM_profile_SBR_callback() {

    //echo 'Data: <pre>' .print_r($_REQUEST,true). '</pre>';
    $error_message = array();
    $error_flag = false;

    if (isset($_REQUEST['customer_user_mbt']) && empty($_REQUEST['customer_user_mbt'])) {
        $error_message[] = 'Customer ID required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_first_name']) && empty($_REQUEST['billing_first_name'])) {
        $error_message[] = 'Billing first name required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_last_name']) && empty($_REQUEST['billing_last_name'])) {
        $error_message[] = 'Billing last name required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_phone']) && empty($_REQUEST['billing_phone'])) {
        $error_message[] = 'Billing phone number required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_city']) && empty($_REQUEST['billing_city'])) {
        $error_message[] = 'Billing city required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_address_1']) && empty($_REQUEST['billing_address_1'])) {
        $error_message[] = 'Billing address required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_postcode']) && empty($_REQUEST['billing_postcode'])) {
        $error_message[] = 'Billing postcode required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_state']) && empty($_REQUEST['billing_state'])) {
        $error_message[] = 'Billing state required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_country']) && empty($_REQUEST['billing_country'])) {
        $error_message[] = 'Billing country required.';
        $error_flag = true;
    }

    if (isset($_REQUEST['credit_card_number']) && empty($_REQUEST['credit_card_number'])) {
        $error_message[] = 'Credit card number required.';
        $error_flag = true;
    } else {

        if (sbr_validateCC($_REQUEST['credit_card_number']) == false) {
            $error_message[] = 'Credit card number invalid.';
            $error_flag = true;
        }
    }
    if (isset($_REQUEST['credit_card_expiry_month']) && empty($_REQUEST['credit_card_expiry_month'])) {
        $error_message[] = 'Credit card expiry month required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['credit_card_expiry_year']) && empty($_REQUEST['credit_card_expiry_year'])) {
        $error_message[] = 'Credit card expiry year required.';
        $error_flag = true;
    } else {
        $userInput = $_REQUEST['credit_card_expiry_month'] . '-' . $_REQUEST['credit_card_expiry_year'];
        $cardDate = DateTime::createFromFormat('m-y', $userInput);
        $currentDate = new DateTime('now');
        $interval = $currentDate->diff($cardDate);
        if ($interval->invert == 1) {
            $error_message[] = 'Credit card date expired.';
            $error_flag = true;
        }
    }
    if (isset($_REQUEST['credit_card_csc']) && empty($_REQUEST['credit_card_csc'])) {
        $error_message[] = 'Credit card csc required.';
        $error_flag = true;
    }
    if ($error_flag) {
        $response = array(
            'response' => false,
            'error' => str_replace('"', '\"', implode('<br/>', $error_message))
        );
    } else {

        $user_id = $_POST['customer_user_mbt'];

        $cust_profile_id = get_user_meta($user_id, USER_CIM_PROFILE_ID, true);

        $first_name = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : '';
        $last_name = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : '';
        $address = isset($_REQUEST['billing_address_1']) ? $_REQUEST['billing_address_1'] : '';
        $city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : '';
        $postcode = isset($_REQUEST['billing_postcode']) ? $_REQUEST['billing_postcode'] : '';
        $state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : '';
        $country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : '';
        $phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : '';
        $user_info = get_userdata($user_id);

        $card_account_number = $_REQUEST['credit_card_number'];
        $month = $_REQUEST['credit_card_expiry_month'];
        $year = $_REQUEST['credit_card_expiry_year'];
        $csc = $_REQUEST['credit_card_csc'];

        if ($cust_profile_id == '') {
            $data = '{
    "createCustomerProfileRequest": {
        "merchantAuthentication": {
            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
        "profile": {
            "merchantCustomerId": "' . $user_id . '",
            "description": "Smile Brilliant Customer",
            "email": "' . $user_info->user_email . '",
            "paymentProfiles": {
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
                "expirationDate": "' . $year . '-' . $month . '",
                "cardCode": "' . $csc . '"
              }
            }
        }
        },
        "validationMode": "' . SB_AUTHORIZE_ENV . '" 
    }
}';
            //                   "cardCode": "591"
        } else {

            $data = '{
        "createCustomerPaymentProfileRequest": {
            "merchantAuthentication": {
          "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
          "customerProfileId": "' . $cust_profile_id . '",
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
                "expirationDate": "' . $year . '-' . $month . '",
                 "cardCode": "' . $csc . '"
       
              }
            },
            "defaultPaymentProfile": false
          },
          "validationMode": "' . SB_AUTHORIZE_ENV . '"
        }
      }';
        }

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
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $str = curl_exec($curl);
        curl_close($curl);
        //          echo 'Data: <pre>' .print_r($data,true). '</pre>';
        //           echo 'Data: <pre>' .print_r($responseAPI,true). '</pre>';
        for ($i = 0; $i <= 31; ++$i) {
            $response = str_replace(chr($i), "", $str);
        }
        $response = str_replace(chr(127), "", $str);
        if (0 === strpos(bin2hex($response), 'efbbbf')) {
            $response = substr($response, 3);
        }
        $responseAPI = json_decode($response, true);
        //       echo 'Data: <pre>' .print_r($responseAPI,true). '</pre>';
        //        die;
        if (isset($responseAPI['customerProfileId']) && (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Ok')) {
            $error_flag = false;
            $response_msg = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
            $customer_profile_id = $responseAPI['customerProfileId'];
            if ($cust_profile_id == '') {
                $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileIdList'][0];
                update_user_meta($user_id, USER_CIM_PROFILE_ID, $customer_profile_id);
            } else {
                $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileId'];
            }

            $response = get_authorize_profile_info_by_profile_id($customer_profile_id, $customerPaymentProfileIdList);
            // echo 'Data: <pre>' .print_r($response,true). '</pre>';
            $last4Digits = preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number);
            $token = new WC_Payment_Token_CC();
            $token->set_token($customerPaymentProfileIdList);
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

            $token->set_user_id($user_id);
            $token->save();
            // addPaymentTokenMetaSBR('code', $csc, $token->get_id());
            addPaymentTokenMetaSBR('customer_profile_id', $customer_profile_id, $token->get_id());
        } else {

            if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Error') {
                $error_flag = true;
            }
        }
        $error_message = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';

        if ($error_flag) {
            $response = array(
                'response' => false,
                'error' => $error_message
            );
        } else {
            $response = array(
                'response' => true,
                'error' => $error_message,
                'html' => mbt_getUserCIM_profiles($user_id)
            );
        }
    }

    echo json_encode($response);
    die;
}
/**
 * Get HTML representation of customer CIM profiles for display.
 *
 * @param int $user_id The user ID for which payment profiles are retrieved.
 *
 * @return string HTML content representing customer CIM profiles.
 */
function mbt_getUserCIM_profiles($user_id) {
    $html = '';
    $tokens = WC_Payment_Tokens::get_customer_tokens($user_id, 'authorize_net_cim_credit_card');


    if ($tokens) {
        $token_key_last = array_key_last($tokens);
        //  $alreadyMark = false;
        krsort($tokens);
        $counterMark = true;
        $customer_profile_id = get_user_meta($user_id, USER_CIM_PROFILE_ID, true);
        foreach ($tokens as $key => $token) {

            $validatedData = validateCustomerPaymentProfileRequest($customer_profile_id, $token->get_token());
            // echo '<pre>';
            // print_r($validatedData);
            // echo '</pre>';
            $validation_message = '';
            if (isset($validatedData['messages']['resultCode']) && $validatedData['messages']['resultCode'] == 'Error') {
                $validation_message = isset($validatedData['messages']['message'][0]['text']) ? '<b style="color:red"> ' . $validatedData['messages']['message'][0]['text'] . ' (If the error is technical in nature, please contact the SBR development team.)</b>' : '';
            }
            //            echo '<pre>';
            //            print_r($key);
            //            echo '</pre>';
            //    echo '<pre>';
            //    print_r($token);
            //    echo '</pre>';
            $paymentProfileDetail = getCustomerPaymentProfile($customer_profile_id, $token->get_token(), true);
            $cardType = isset($paymentProfileDetail['paymentProfile']['payment']['creditCard']['cardType']) ? $paymentProfileDetail['paymentProfile']['payment']['creditCard']['cardType'] : $token->get_card_type();
            $cardNumber = isset($paymentProfileDetail['paymentProfile']['payment']['creditCard']['cardNumber']) ? $paymentProfileDetail['paymentProfile']['payment']['creditCard']['cardNumber'] : $token->get_last4();
            $info = isset($paymentProfileDetail['paymentProfile']['billTo']) ? $paymentProfileDetail['paymentProfile']['billTo'] : Null;
            $addressHtml = '';
            if ($info) {
                $addressHtml .= '<p>';
                $addressHtml .= $info['firstName'] . ' ' . $info['lastName'] . '</br>';
                $addressHtml .= $info['address'] . '</br>';
                $addressHtml .= $info['city'] . '</br>';
                $addressHtml .= $info['state'] . '(' . $info['zip'] . ')' . $info['country'];
                $addressHtml .= '<input type="hidden" name="ppAddress[' . $token->get_id() . ']" value=\'' . json_encode($info) . '\' />';
                $addressHtml .= '</p>';
            }
            $html .= '<tr>';
            $html .= '<td>' . $cardType . '</td>';
            $html .= '<td>' . $addressHtml . '</td>';
            $html .= '<td>' . $cardNumber . '</td>';
            $html .= '<td>' . $token->get_expiry_month() . '/' . $token->get_expiry_year() . '</td>';
            $html .= '<td>';
            $html .= '<label><span class="profile_cim">' . $token->get_token() . '</span> ';
            $markedAsDefault = '';
            if ($counterMark) {
                $counterMark = false;
                $markedAsDefault = 'checked="checked"';
            }
            $html .= '<input name="wc_payment_gateway_authorize_net_cim_credit_card_tokens" value="' . $token->get_id() . '" type="radio"  ' . $markedAsDefault . ' />';
            $html .= '</label>' . $validation_message;
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="4">No record found.</td></tr>';
    }
    return $html;
}

add_action('wp_ajax_addLegacyAimPaymentProfile', 'addLegacyAimPaymentProfile_callback');
/**
 * AJAX callback to add a legacy AIM payment profile for a user.
 *
 * @return void Outputs JSON-encoded response indicating success or failure.
 */
function addLegacyAimPaymentProfile_callback() {

    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    $authnetPaymentId = isset($_REQUEST['authnetPaymentId']) ? $_REQUEST['authnetPaymentId'] : 0;
    global $wpdb;
    $sqlQuery = 'SELECT customer_.authnetCustomerId ,customer_.emailAddress , customer_credit_card.* FROM customer_ ';
    $sqlQuery .= 'INNER JOIN customer_credit_card ON customer_.customerId = customer_credit_card.customerId ';
    $sqlQuery .= 'INNER JOIN wp_users ON customer_.emailAddress = wp_users.user_email WHERE wp_users.ID=' . $user_id . ';';
    $resultsCC = $wpdb->get_results($sqlQuery, 'ARRAY_A');
    $response_msg = 'Something Went Wrong.';
    $added = false;
    if ($resultsCC) {
        foreach ($resultsCC as $paymentProfile) {

            if ($paymentProfile['authnetPaymentId'] == $authnetPaymentId) {

                $responseAPI = get_authorize_profile_info_by_profile_id($paymentProfile['authnetCustomerId'], $authnetPaymentId);
                if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Ok') {

                    update_user_meta($user_id, USER_CIM_PROFILE_ID, $paymentProfile['authnetCustomerId']);
                    $token = new WC_Payment_Token_CC();
                    $token->set_token($authnetPaymentId);
                    $token->set_gateway_id('authorize_net_cim_credit_card');
                    if (isset($responseAPI['paymentProfile']['payment']['creditCard']['cardType'])) {
                        $token->set_card_type(strtolower($responseAPI['paymentProfile']['payment']['creditCard']['cardType']));
                    } else {
                        $token->set_card_type('visa');
                    }
                    //   $token->create(); // save to database
                    $token->set_last4($paymentProfile['last4']);
                    $token->set_expiry_month($paymentProfile['expirationMonth']);
                    $token->set_expiry_year('20' . $paymentProfile['expirationYear']);
                    $token->set_user_id($user_id);
                    $token->save();
                    $added = true;
                } else {
                    if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Error') {
                        $response_msg = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
                    }
                    $added = false;
                }
                break;
            }
        }
    }
    $ajaxresponse = '';
    if ($added) {
        $ajaxresponse = array(
            'response' => true,
            'error' => 'Payment Profile added.',
            'html' => mbt_getUserCIM_profiles($user_id)
        );
    } else {
        $ajaxresponse = array(
            'response' => false,
            'error' => $response_msg,
        );
    }
    echo json_encode($ajaxresponse);
    die;
}

add_action('wp_ajax_legacyAimProfile', 'legacyAimProfile_callback');
/**
 * AJAX callback to retrieve and display legacy AIM profiles for a user.
 *
 * @return void Outputs HTML content representing legacy AIM profiles.
 */
function legacyAimProfile_callback() {

    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    $html = '';
    if ($user_id) {
        global $wpdb;
        $sqlQuery = 'SELECT customer_.authnetCustomerId , customer_.emailAddress, customer_credit_card.* FROM customer_ ';
        $sqlQuery .= 'INNER JOIN customer_credit_card ON customer_.customerId = customer_credit_card.customerId ';
        $sqlQuery .= 'INNER JOIN wp_users ON customer_.emailAddress = wp_users.user_email WHERE wp_users.ID=' . $user_id . ' AND customer_credit_card.authnetPaymentId NOT IN(select token from wp_woocommerce_payment_tokens WHERE user_id = ' . $user_id . ');';
        $resultsCC = $wpdb->get_results($sqlQuery, 'ARRAY_A');


        if ($resultsCC) {
            foreach ($resultsCC as $paymentProfile) {

                $html .= '<tr>';
                $html .= '<td>' . $paymentProfile['emailAddress'] . '</td>';
                $html .= '<td>' . $paymentProfile['authnetCustomerId'] . '</td>';
                $html .= '<td>' . $paymentProfile['authnetPaymentId'] . '</td>';
                $html .= '<td>' . $paymentProfile['last4'] . '</td>';
                $html .= '<td>' . $paymentProfile['expirationMonth'] . '/' . $paymentProfile['expirationYear'] . '</td>';
                $html .= '<td>';
                $html .= '<button  onclick="addLegacyPaymentProfile(' . $paymentProfile['authnetPaymentId'] . ' , ' . $user_id . ')" class="button" type="button">Add </button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="6">No Payment Profile Found in Legacy System.</td>';
            $html .= '</tr>';
        }
    }
    ?>
    <h2>Legacy AIM Profiles</h2>
    <table class="widefat" id="addLegacyPaymentProfileTBL">
        <thead>
            <tr>
                <th>Customer Email</th>
                <th>AIM Customer ID</th>
                <th>AIM Payment Profile ID</th>
                <th>Last Four</th>
                <th>Expiration (MM/YY)</th>
                <th></th>
            </tr>
        </thead>

        <tbody id="cm_smile_brillaint_payment_gateway_user">
            <?php
            echo $html;
            ?>
        </tbody>
    </table>
    <?php
    die;
}
/**
 * Display customer payment profiles and provide options to add new or check legacy profiles.
 *
 * @param int $user_id The user ID for which payment profiles are displayed.
 *
 * @return void Outputs HTML content with the customer payment profiles and action buttons.
 */
function customerAddOrder_paymentProfiles($user_id) {
    ?>

    <div class="flex-row">
        <div class="col-sm-12">

            <button id="addCIM_Profile" onclick="addCIM_Profile_SBR(<?php echo $user_id; ?>)" class="button" type="button">Add Payment Card</button>
            <button id="checkOldAimProfile" onclick="legacyAimProfile(<?php echo $user_id; ?>)" class="button" type="button">Legacy Payment Profile</button>

        </div>

    </div>
    <?php
    global $wpdb;
    $sqlQuery = "SELECT posts.ID
				FROM $wpdb->posts AS posts
				LEFT JOIN {$wpdb->postmeta} AS meta on posts.ID = meta.post_id
				WHERE meta.meta_key = '_customer_user'
				AND   meta.meta_value = '" . esc_sql($user_id) . "'
				AND   posts.post_type = 'shop_order'
				AND   posts.post_status IN ( 'wc-processing','wc-on-hold','wc-completed','wc-refunded','wc-shipped','wc-partial_ship','wc-wfocu-pri-order' )
				ORDER BY posts.ID DESC";
    $last_order = $wpdb->get_var($sqlQuery);
    $infoLast = 0;
    if ($last_order) {
        $order_old_id = get_post_meta($last_order, 'old_order_id', true);
        if ($order_old_id != '') {
            $sql = "SELECT * FROM order_  AS ordr WHERE ordr.orderId IN(" . $order_old_id . ") GROUP BY ordr.orderId ORDER BY orderId";
            $result3 = $wpdb->get_row($sql, 'ARRAY_A');
            if (isset($result3['authorizeTransactionId']) && $result3['authorizeTransactionId'] > 0 && $result3['authorizeTransactionId'] <> '') {
                $infoLast = $result3['creditCard'];
            }
        } else {
            if (get_post_meta($last_order, '_wc_authorize_net_cim_credit_card_account_four') > 0) {
                $infoLast = get_post_meta($last_order, '_wc_authorize_net_cim_credit_card_account_four', true);
            }
        }
    }
    if ($infoLast > 0) {
        echo '<h3 style="  padding: 10px;text-align: center;border: 1px dashed;color: #048a04;text-transform: capitalize;letter-spacing: 1px;background: #fff;">Last payment was charged from ' . $infoLast . '</h3>';
    }
    ?>
    <table class="widefat">
        <thead>
            <tr>
                <th>Card Type</th>
                <th>Billing Address</th>
                <th>Last Four</th>
                <th>Expiration (MM/YY)</th>
                <th>Default Payment Profile</th>
            </tr>
        </thead>
        <tbody id="smile_brillaint_payment_gateway_user">
            <?php
            echo mbt_getUserCIM_profiles($user_id);
            ?>
        </tbody>
    </table>

    <script>
        function addLegacyPaymentProfile(authnetPaymentId, user_id) {
            var data = {
                user_id: user_id,
                authnetPaymentId: authnetPaymentId,
                action: 'addLegacyAimPaymentProfile'
            };
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                async: true,
                dataType: 'json',
                method: 'POST',
                beforeSend: function (xhr) {
                    jQuery('body').find('#addLegacyPaymentProfileTBL').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    jQuery('body').find('#smile_brillaint_payment_gateway_user').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                success: function (req_response) {
                    jQuery('body').find('#addLegacyPaymentProfileTBL').unblock();
                    if (req_response.response) {

                        jQuery('body').find('#smile_brillaint_payment_gateway_user').html(req_response.html);
                        smile_brillaint_order_modal2.style.display = "none";
                        jQuery('body').find('#smile_brillaint_payment_gateway_user').unblock();
                    } else {
                        jQuery('body').find('#addLegacyPaymentProfileTBL').unblock();
                        jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
                    }
                },
                error: function (xhr) {
                    jQuery('body').find('#addLegacyPaymentProfileTBL').unblock();
                    jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
                },
                cache: false,
            });
        }

        function legacyAimProfile(user_id) {
            jQuery("body").find('#smile_brillaint_order_popup_response2').parent('.modal-content').removeClass('paymentCardPop');
            jQuery("body").find('#smile_brillaint_order_popup_response2').addClass(' addOn_mbt shipment-popup');
            jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_load_html());
            var data = {
                user_id: user_id,
                action: 'legacyAimProfile'
            };
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                async: true,
                dataType: 'html',
                method: 'POST',
                beforeSend: function (xhr) {
                    smile_brillaint_order_modal2.style.display = "block";
                },
                success: function (response) {
                    //   console.log(response);
                    jQuery('body').find('#smile_brillaint_order_popup_response2').html(response);
                    // reload_order_item_table_mbt(order_id);
                },
                error: function (xhr) {
                    jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
                },
                cache: false,
            });
        }

        function addCIM_Profile_SBR(user_id) {
            jQuery("body").find('#smile_brillaint_order_popup_response2').parent('.modal-content').addClass('paymentCardPop');
            jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_load_html());
            var data = {
                user_id: user_id,
                action: 'addCustomerPaymentProfileAdminSide'
            };
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                async: true,
                dataType: 'html',
                method: 'POST',
                beforeSend: function (xhr) {
                    smile_brillaint_order_modal2.style.display = "block";
                },
                success: function (response) {
                    //   console.log(response);
                    jQuery('body').find('#smile_brillaint_order_popup_response2').html(response);
                    // reload_order_item_table_mbt(order_id);
                },
                error: function (xhr) {
                    jQuery('body').find('#smile_brillaint_order_popup_response2').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
                },
                cache: false,
            });
        }
    </script>
    <?php
}

add_action('wp_ajax_addOrderCIMProfile', 'addOrderCIMProfile_callback');
/**
 * Callback function for the AJAX action 'addOrderCIMProfile'.
 * Processes the request to add a CIM profile for an order.
 *
 * @return void Outputs JSON-encoded response with the result, result text, and HTML content.
 */
function addOrderCIMProfile_callback() {
    $ajax_response = array();
    $user_id = $_POST['customer_user_mbt'];

    $cust_profile_id = get_user_meta($user_id, USER_CIM_PROFILE_ID, true);

    $first_name = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : '';
    $last_name = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : '';
    $address = isset($_REQUEST['billing_address_1']) ? $_REQUEST['billing_address_1'] : '';
    $city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : '';
    $postcode = isset($_REQUEST['billing_postcode']) ? $_REQUEST['billing_postcode'] : '';
    $state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : '';
    $country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : '';
    $phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : '';
    $user_info = get_userdata($user_id);

    $card_account_number = isset($_REQUEST['wc-authorize-net-cim-credit-card-account-number']) ? $_REQUEST['wc-authorize-net-cim-credit-card-account-number'] : 0;
    $month = isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-month']) ? $_REQUEST['wc-authorize-net-cim-credit-card-expiry-month'] : 0;
    $year = isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-year']) ? $_REQUEST['wc-authorize-net-cim-credit-card-expiry-year'] : 0;

    if ($cust_profile_id == '') {
        $data = '{
    "createCustomerProfileRequest": {
        "merchantAuthentication": {
            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
        "profile": {
            "merchantCustomerId": "' . $user_id . '",
            "description": "Smile Brilliant Customer",
            "email": "' . $user_info->user_email . '",
            "paymentProfiles": {
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
            }
        }
        },
        "validationMode": "' . SB_AUTHORIZE_ENV . '" 
    }
}';
    } else {

        $data = '{
        "createCustomerPaymentProfileRequest": {
            "merchantAuthentication": {
          "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
        },
          "customerProfileId": "' . $cust_profile_id . '",
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
    }
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
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $str = curl_exec($curl);
    curl_close($curl);
    //   print_r($str);
    /// die();
    for ($i = 0; $i <= 31; ++$i) {
        $response = str_replace(chr($i), "", $str);
    }
    $response = str_replace(chr(127), "", $str);
    if (0 === strpos(bin2hex($response), 'efbbbf')) {
        $response = substr($response, 3);
    }
    $responseAPI = json_decode($response, true);
    //  echo 'Data: <pre>' .print_r($responseAPI,true). '</pre>';
    // die;
    if (isset($responseAPI['customerProfileId']) && (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Ok')) {
        $no_error_flag = true;
        $response_msg = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
        $customer_profile_id = $responseAPI['customerProfileId'];
        if ($cust_profile_id == '') {
            $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileIdList'][0];
            update_user_meta($user_id, USER_CIM_PROFILE_ID, $customer_profile_id);
        } else {
            $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileId'];
        }

        $response = get_authorize_profile_info_by_profile_id($customer_profile_id, $customerPaymentProfileIdList);
        // echo 'Data: <pre>' .print_r($response,true). '</pre>';
        $last4Digits = preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number);
        $token = new WC_Payment_Token_CC();
        $token->set_token($customerPaymentProfileIdList);
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
        $token->set_user_id($user_id);
        $token->save();
    } else {

        if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Error') {
            $no_error_flag = false;
            $response_msg = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
        }
    }




    $ajax_response['resultCase'] = $no_error_flag;
    $ajax_response['resultText'] = $response_msg;
    $ajax_response['resultHTML'] = mbt_getUserCIM_profiles($user_id);

    echo json_encode($ajax_response);

    die;
}

add_action('wp_ajax_searchStateByCountryCode', 'searchStateByCountryCode_callback');
/**
 * Validate a customer payment profile request using Authorize.Net API.
 *
 * @param string $profile_id         The ID of the customer profile.
 * @param string $paymentProfileID   The ID of the customer payment profile.
 *
 * @return array|false  An associative array containing the response from the Authorize.Net API
 *                      or false on failure. The response structure is dependent on the API request.
 */
function validateCustomerPaymentProfileRequest($profile_id, $paymentProfileID) {
    $validate_json_data = '{
        "validateCustomerPaymentProfileRequest": {
            "merchantAuthentication": {
                "name":  "' . SB_AUTHORIZE_LOGIN_ID . '",
                "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
            },
            "customerProfileId": "' . $profile_id . '",
            "customerPaymentProfileId": "' . $paymentProfileID . '",
            "validationMode": "' . SB_AUTHORIZE_ENV . '"
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
        CURLOPT_POSTFIELDS => $validate_json_data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $str = curl_exec($curl);
    for ($i = 0; $i <= 31; ++$i) {
        $response = str_replace(chr($i), "", $str);
    }
    $response = str_replace(chr(127), "", $str);
    if (0 === strpos(bin2hex($response), 'efbbbf')) {
        $response = substr($response, 3);
    }
    curl_close($curl);
    return $response = json_decode($response, true);
}
