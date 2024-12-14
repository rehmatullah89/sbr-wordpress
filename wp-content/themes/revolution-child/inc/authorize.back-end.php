<?php
/*
 * Authorize.net integration at create order in wordpress back-end
 */

// inject payment options
/**
 * Register meta box(es).
 */
function mbt_register_meta_boxes_shop_order() {
    add_meta_box('meta-box-authorize', __('Payment', 'woocommerce'), 'authoprize_payment_form_display', 'shop_order');
}
if(!isset($_GET['action'])) {
add_action('add_meta_boxes', 'mbt_register_meta_boxes_shop_order');
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function authoprize_payment_form_display($post) {
    // Display code/markup goes here. Don't forget to include nonces!
    ?>
    <div id="cim_profiles"></div>
    <input type="checkbox" name="capture_new_card1" id="capture_new_card" value="1">
    <label for="capture_new_card"> New Card </label><br>

    <table style="width: 100%;display:none" id="payment_new_form">
        <tr>
            <td>
                <input type="hidden" id="order_total_amount" name="order_total_amount" value="">
                <input type="hidden" id="ajaxurll" value="<?php echo admin_url('admin-ajax.php'); ?>">

        <!--                    <input type="hidden" name="action" value="addCIMPaymentProfile" />
         <input type="hidden" name="order_id" value="<?php // echo $order_id;   ?>" />-->
                <div class="woocommerce-PaymentBox" style="">
                    <fieldset id="wc-authorize-net-cim-credit-card-credit-card-form" aria-label="Payment Info">
                        <legend style="display:none;">Payment Info</legend>
                        <div class="wc-authorize-net-cim-credit-card-new-payment-method-form js-wc-authorize-net-cim-credit-card-new-payment-method-form flex-row">
                            <p class="form-row form-row-wide validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-account-number_field" data-priority="">
                                <label for="wc-authorize-net-cim-credit-card-account-number" class="">Card Number&nbsp;<abbr class="required" title="required">*</abbr></label>
                                <span class="woocommerce-input-wrapper">
                                    <input type="tel" class="js-sv-wc-payment-gateway-credit-card-form-account-number" name="wc-authorize-net-cim-credit-card-account-number" id="wc-authorize-net-cim-credit-card-account-number" placeholder="**** **** **** ****" value="" autocomplete="cc-number" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="16"></span></p>

                            <p class="form-row form-row-first validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-expiry_year_field" data-priority="">

                                <label for="wc-authorize-net-cim-credit-card-expiry-month" class="">Expiration Month&nbsp;<abbr class="required" title="required">*</abbr></label>
                                <select id="wc-authorize-net-cim-credit-card-expiry-month"  style="max-width:100px "name="wc-authorize-net-cim-credit-card-expiry-month">
                                    <option value=''>--Select Month--</option>
                                    <option value='01'>Janaury</option>
                                    <option value='02'>February</option>
                                    <option value='03'>March</option>
                                    <option value='04'>April</option>
                                    <option value='05'>May</option>
                                    <option value='06'>June</option>
                                    <option value='07'>July</option>
                                    <option value='08'>August</option>
                                    <option value='09'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select>
                            </p> 
                            <p class="form-row form-row-last col-sm-6">
                                <label for="wc-authorize-net-cim-credit-card-expiry-" class="">Expiration Year(YYYY)&nbsp;<abbr class="required" title="required">*</abbr></label>
                                <span class="woocommerce-input-wrapper"><input type="tel" class="input-text" name="wc-authorize-net-cim-credit-card-expiry-year" id="wc-authorize-net-cim-credit-card-expiry-year" placeholder="YYYY" value="" autocomplete="cc-exp" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span></p>

                            <p class="form-row form-row-first col-sm-6" >
                                <label for="wc-authorize-net-cim-credit-card-csc" class="">Card Security Code&nbsp;<abbr class="required" title="required">*</abbr></label>
                                <span class="woocommerce-input-wrapper">
                                    <input type="tel" class="input-text js-sv-wc-payment-gateway-credit-card-form-input js-sv-wc-payment-gateway-credit-card-form-csc" name="" id="wc-authorize-net-cim-credit-card-csc" placeholder="CSC" value="" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span>
                            </p>
                        </div><!-- ./new-payment-method-form-div -->
                    </fieldset>

                </div>

            </td>
        </tr>        

    </table>

    <?php
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box($post_id) {
    // Save logic goes here. Don't forget to include nonce checks!
}

add_action('save_post', 'wpdocs_save_meta_box');

    add_action('wp_ajax_get_user_cim_by_email', 'get_user_cim_by_email_function');


function get_user_cim_by_email_function($user_id = '') {
    if ($user_id == '') {
        $user_id = $_POST['user_id'];
    }
    if ($user_id == '') {
        return 0;
    }

    //$old_order = wc_get_order($order_id);
    $tokens = WC_Payment_Tokens::get_customer_tokens($user_id, 'authorize_net_cim_credit_card');
    if ($tokens) {
        ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Card Type</th>
                    <th>Last Four</th>
                    <th>Expiration (MM/YY)</th>
                    <th>Default</th>
                </tr>
            </thead>
            <tbody id="smile_brillaint_payment_gateway_user"></tbody>

            <?php
            $token_key_last = array_key_last($tokens);
            $alreadyMark = false;
            foreach ($tokens as $key => $token) {
                ?>
                <tr>
                    <td><?php echo ucfirst($token->get_card_type()); ?></td>
                    <td><?php echo $token->get_last4(); ?></td>
                    <td><?php echo $token->get_expiry_month(); ?>/<?php echo $token->get_expiry_year(); ?></td>
                    <td>
                        <label><span class="profile_cim"><?php echo $token->get_token(); ?></span>
                            <?php
                            $markedAsDefault = '';
                            if ($token->is_default() || ($token_key_last == $key && $alreadyMark == false)) {
                                $alreadyMark = true;
                                $markedAsDefault = 'checked="checked"';
                            }
                            ?>
                            <input name="wc_payment_gateway_authorize_net_cim_credit_card_tokens" value="<?php echo $token->get_id(); ?>" type="radio" <?php echo $markedAsDefault; ?> />

                        </label>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="4">No record found.</td></tr>';
        }
        ?>
    </tbody>
    </table>     
    <?php
    die();
}

function regisert_new_order_data_auth($order_id) {

    //if( ! $update ){
    if(isset($_POST['order_status']) && $_POST['order_status']=='wc-pending'){
        return true;
    }
    else{
    if (isset($_POST['capture_new_card1']) && $_POST['capture_new_card1'] == '1') {

        customer_profile_for_authorize($order_id);
    } elseif (isset($_POST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) && $_POST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] != '') {
        $user_id = $_POST['customer_user'];
        $cust_profile_id = get_user_meta($user_id, 'wc_authorize_net_cim_customer_profile_id_test', true);
        capture_card_for_authorize($order_id, $cust_profile_id, $_POST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']);
    }
    }

    // }
}

add_action('woocommerce_new_order', 'regisert_new_order_data_auth', 10, 1);

//add_action( 'save_post_shop_order', 'regisert_new_order_data_auth', 999, 3 );
function customer_profile_for_authorize($order_id) {

    
//    echo '----'.$total.'---';
//    echo '<pre>';
//    print_r($_POST);
//echo '</pre>';
//echo '<pre>';
//print_r($obj);
//echo '</pre>';
//    die();

    $first_name = $_POST['_billing_first_name'];
    $last_name = $_POST['_billing_last_name'];
    $phone = $_POST['_billing_phone'];
    $email = $_POST['_billing_email'];
    $address = $_POST['_billing_address_1'] . ' ' . $_POST['_billing_address_2'];
    $city = $_POST['_billing_city'];
    $postcode = $_POST['_billing_postcode'];
    $state = $_POST['_billing_state'];
    $country = $_POST['_billing_country'];
    $user_id = $_POST['customer_user'];
    $cust_profile_id = get_user_meta($user_id, 'wc_authorize_net_cim_customer_profile_id_test', true);
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
            "description": "Profile description here",
            "email": "' . $email . '",
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
        echo
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
    $response = json_decode($response, true);
    $customer_profile_id = $response['customerProfileId'];
    if ($cust_profile_id == '') {
        $customerPaymentProfileIdList = $response['customerPaymentProfileIdList'][0];
        update_user_meta($user_id, 'wc_authorize_net_cim_customer_profile_id_test', $customer_profile_id);
    } else {
        $customerPaymentProfileIdList = $response['customerPaymentProfileId'];
    }

    $response = get_authorize_profile_info_by_profile_id($customer_profile_id, $customerPaymentProfileIdList);
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

    capture_card_for_authorize($order_id, $customer_profile_id, $token->get_id());
}

function capture_card_for_authorize($order_id, $customer_profile_id = '', $customerPaymentProfileIdList = '') {
    //$old_order = wc_get_order($order_id);
    $order = wc_get_order($order_id);
    $total = $order->get_total();
    $addOn_amount = $total;
    if (is_numeric($addOn_amount) && $addOn_amount > 0) {
        if ($customerPaymentProfileIdList == '') {
            $token_id = isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) ? $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] : 0;
        } else {
            $token_id = $customerPaymentProfileIdList;
        }
        if ($token_id != '') {

            $token = WC_Payment_Tokens::get($token_id);

            if ($customer_profile_id == '') {
                $profile_id = isset($_REQUEST['wc_authorize_net_cim_customer_profile_id']) ? $_REQUEST['wc_authorize_net_cim_customer_profile_id'] : 0;
            } else {
                $profile_id = $customer_profile_id;
            }
            // print_r($token);
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
                CURLOPT_POSTFIELDS => '{
          "createTransactionRequest": {
          "merchantAuthentication": {
           "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
          "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
          },
          "refId": "' . refId_mbt(15) . '",
          "transactionRequest": {
          "transactionType": "authCaptureTransaction",
          "amount": "' . $addOn_amount . '",
          "profile": {
          "customerProfileId": "' . $profile_id . '",
          "paymentProfile": { "paymentProfileId": "' . $token->get_token() . '" }
          }
          }
          }
          }',
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

            // This is the most common part
            // Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
            // here we detect it and we remove it, basically it's the first 3 characters 
            if (0 === strpos(bin2hex($checkLogin), 'efbbbf')) {
                $checkLogin = substr($checkLogin, 3);
            }

            $checkLogin = json_decode($checkLogin, true);
            $child_order_id = $order_id;
            $payemt_note = $checkLogin['transactionResponse']['messages'][0]['description'];
            if (isset($checkLogin['transactionResponse']) && $checkLogin['transactionResponse']['responseCode'] == 1) {
                //echo '*-*-*-';
                update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_trans_id', $checkLogin['transactionResponse']['transId']);
                update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_authorization_code', $checkLogin['transactionResponse']['authCode']);
                update_post_meta($child_order_id, '_transaction_id', $checkLogin['transactionResponse']['transId']);
                update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_trans_date', date("Y-m-d h:i:sa"));
                $getCC = array(
                    'mastercard' => __('MasterCard', 'woocommerce'),
                    'visa' => __('Visa', 'woocommerce'),
                    'discover' => __('Discover', 'woocommerce'),
                    'american express' => __('American Express', 'woocommerce'),
                    'diners' => __('Diners', 'woocommerce'),
                    'jcb' => __('JCB', 'woocommerce'),
                );
                $payemt_note = 'Authorize.Net Credit Card Charge Approved: ' . $getCC[$token->get_card_type()] . ' ending in ' . $token->get_last4() . ' (expires ' . $token->get_expiry_month() . '/' . $token->get_expiry_year() . ') (Transaction ID ' . $checkLogin['transactionResponse']['transId'] . ')';
                //  $old_order->update_status('processing');
            } else {
                //  $old_order->update_status('on-hold');
            }


             $order->add_order_note($payemt_note);
            update_post_meta($child_order_id, '_payment_note', $payemt_note);
            update_post_meta($child_order_id, '_payment_method', 'authorize_net_cim_credit_card');
            update_post_meta($child_order_id, '_payment_method_title', 'Credit Card');
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_customer_id', $profile_id);
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_payment_token', $token->get_token());
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_account_four', $token->get_last4());
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_authorization_amount', $addOn_amount);
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_card_type', $token->get_card_type());
            update_post_meta($child_order_id, '_wc_authorize_net_cim_credit_card_card_expiry_date', $token->get_expiry_year() . '-' . $token->get_expiry_month());
        }
    } else {
        //$order->update_status('processing');
    }
}

function get_authorize_profile_info_by_profile_id($profile_id, $paymentProfileID) {
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
    return $response = json_decode($response, true);
}
