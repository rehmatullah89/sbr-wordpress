<?php

add_action('wp_ajax_addSubscriptionProductPlan', 'addSubscriptionProductPlan_callback');
function addSubscriptionProductPlan_callback()
{

    ?>
            <div class="addSubscriptionProductPlan subscriptionProductPlanWrapperContainer">
                <h1>Add Subscription Plan</h1>
                <form id="add-subscription-plan-form" method="post">
                    <table>

                        <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $_REQUEST['product_id']; ?>" />

                        <tr>
                            <td><label for="title">Title:</label></td>
                            <td><input type="text" id="title" name="title" required></td>
                        </tr>
                        <tr>
                            <td><label for="description">Description:</label></td>
                            <td><textarea id="description" name="description"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="price">Price:</label></td>
                            <td><input type="number" id="price" name="price" step="0.01" required></td>
                        </tr>
                        <tr>
                            <td><label for="sale_price">Sale Price:</label></td>
                            <td><input type="number" id="sale_price" name="sale_price" step="0.01"></td>
                        </tr>
                        <tr>
                            <td><label for="sale_text">Sale Text:</label></td>
                            <td><input type="text" id="sale_text" name="sale_text"></td>
                        </tr>
                        <tr>
                            <td><label for="sale_active">Sale Active:</label></td>
                            <td>
                                <select id="sale_active" name="sale_active">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="available">Available:</label></td>
                            <td>
                                <select id="available" name="available">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="interval_plan">Interval Plan:</label></td>
                            <td>
                                <select id="interval_plan" name="interval_plan" required>
                                    <option value="12">Every 12 Months</option>
                                    <option value="6">Every 6 Months</option>
                                    <option value="4">Every 4 Months</option>
                                    <option value="3">Every 3 Months</option>
                                    <option value="2">Every 2 Months</option>
                                    <option value="1">Every 1 Month</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="order_interval">Order Interval:</label></td>
                            <td>
                                <select id="order_interval" name="order_interval" required>
                                    <option value="12">Every 12 Months</option>
                                    <option value="6">Every 6 Months</option>
                                    <option value="4">Every 4 Months</option>
                                    <option value="3">Every 3 Months</option>
                                    <option value="2">Every 2 Months</option>
                                    <option value="1">Every 1 Month</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="button" id="addUpdateSubscriptionData" value="Add Plan" class="button button-primary">
                </form>
            </div>
        <?php
        die;
}




add_action('wp_ajax_subscription_order_create', 'subscription_order_create_callback');
function subscription_order_create_callback()
{

    $item_id = $_POST['item_id'];
    $order_id = wc_get_order_id_by_order_item_id($item_id);
    if ($order_id) {
        $existing_order = wc_get_order($order_id);


        // Set the new order data
        $new_order_data = array(
            'status' => 'processing',
            'customer_id' => $existing_order->get_customer_id(),
            'payment_method' => $existing_order->get_payment_method(),
            'payment_title' => $existing_order->get_payment_method_title(),
            'line_items' => array(),
        );


        if ($existing_order) {
            $item = $existing_order->get_item($item_id);
            if ($item) {
                // Get the item data
                // $product_name = $item->get_name();
                $product_id = $item->get_product_id();
                $quantity = $item->get_quantity();
                $subtotal = $item->get_subtotal();


                $new_order_data['line_items'][] = array(
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                );
            }

            $billing_address = array(
                'first_name' => $existing_order->get_billing_first_name(),
                'last_name' => $existing_order->get_billing_last_name(),
                'company' => $existing_order->get_billing_company(),
                'email' => $existing_order->get_billing_email(),
                'phone' => $existing_order->get_billing_phone(),
                'address_1' => $existing_order->get_billing_address_1(),
                'address_2' => $existing_order->get_billing_address_2(),
                'city' => $existing_order->get_billing_city(),
                'postcode' => $existing_order->get_billing_postcode(),
                'state' => $existing_order->get_billing_state(),
                'country' => $existing_order->get_billing_country()
            );
            $shipping_address = array(
                'first_name' => $existing_order->get_shipping_first_name(),
                'last_name' => $existing_order->get_shipping_last_name(),
                'company' => $existing_order->get_shipping_company(),
                'address_1' => $existing_order->get_shipping_address_1(),
                'address_2' => $existing_order->get_shipping_address_2(),
                'city' => $existing_order->get_shipping_city(),
                'postcode' => $existing_order->get_shipping_postcode(),
                'state' => $existing_order->get_shipping_state(),
                'country' => $existing_order->get_shipping_country()
            );
            // Create the new order
            $new_order = wc_create_order($new_order_data);
            $new_order->set_address($billing_address, 'billing');
            $new_order->set_address($shipping_address, 'shipping');
            $new_order_id = $new_order->get_id();
            smile_brillaint_set_sequential_order_number($new_order_id);
            smile_brillaint_get_sequential_order_number($new_order_id);
            // Check if the new order was created successfully
            if (!empty($new_order_id)) {
                // Output the new order ID
                echo 'New order created with ID: ' . $new_order_id;
            } else {
                // Output an error message
                echo 'Error creating new order';
            }
        }
    } else {
        echo 'No Order found';
    }
    die;
}

add_action('wp_ajax_update_subscription_info', 'update_subscription_info');
function update_subscription_info()
{
    $responseAPI = false;
    if($_POST){
        $dataObject = '{
            "ARBUpdateSubscriptionRequest": {
                "merchantAuthentication": {
                    "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                    "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                },
                "refId": "' . $_POST['refId'] . '",
                "subscriptionId": "'.$_POST['subscription_id'].'",
                "subscription": {
                    "payment": {
                        "creditCard": {
                            "cardNumber": "'.$_POST['cardNumber'].'",
                            "expirationDate": "'.date('Y-m', strtotime("01/".$_POST['expDate'])).'",
                        }
                    }
                }
            }
        }';        
        $responseAPI = json_decode(authorizeCurlRequest($dataObject), true);
    }

    return $responseAPI;
}
add_action('wp_ajax_unsubscribe_order_items', 'unsubscribe_order_items');
function unsubscribe_order_items()
{
    global $wpdb;
    $order_id = $_REQUEST['order_id'];    
    $subscriptionInfo = $wpdb->get_results("SELECT * FROM sbr_subscription_details  WHERE status=1 AND order_id = ".$order_id);    
    if (!empty($subscriptionInfo)) {
        foreach($subscriptionInfo as $subscription){
            $refId = $subscription->item_id;
            $sub_id = $subscription->subscription_id;

            $data = '{
                "ARBCancelSubscriptionRequest": {
                  "merchantAuthentication": {
                    "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                        "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                  },
                  "refId": "' . $refId . '",
                  "subscriptionId": "' . $sub_id . '",
                }
              }';

            $curl = curl_init();    
            curl_setopt_array(
                $curl,
                array(
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
                )
            );
            $str = curl_exec($curl);
            curl_close($curl);
            for ($i = 0; $i <= 31; ++$i) {
                $response = str_replace(chr($i), "", $str);
            }
            $response = str_replace(chr(127), "", $str);
            if (0 === strpos(bin2hex($response), 'efbbbf')) {
                $response = substr($response, 3);
            }
            $responseAPI = json_decode($response, true);

            if ($responseAPI) {
                $wpdb->update(
                    'sbr_subscription_details',
                    array('status' => 0),
                    array('subscription_id' => $sub_id, 'item_id' => $refId)
                );
                $wpdb->insert('sbr_suspended_subscriptions', array(
                    'user_id' => $subscription->user_id,
                    'subscription_id' => $sub_id,
                    'parent_order_id' => $order_id,
                    'item_id' => $refId,
                    'quantity' => $subscription->quantity,
                    'title' => $subscription->interval_days.' days',
                    'amount' => $subscription->total_price,
                    'status' => 'cancelled',
                    'authorize_response' => ((string)$responseAPI)
                ));                 
            }
        }
    }

    echo "Order: ".$order_id." items has been un-subscribed successfully.";
    die;
}
add_action('wp_ajax_add_subscription_plan', 'add_subscription_plan');
function add_subscription_plan()
{
    global $wpdb;
    $table_name = 'sbr_subscription_plans';

    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $sale_text = $_POST['sale_text'];
    $sale_active = isset($_POST['sale_active']) ? 0 : 0;
    $available = isset($_POST['available']) ? 0 : 0;
    $interval_plan = $_POST['interval_plan'];
    $order_interval = $_POST['order_interval'];

    $id = $_POST['id'];

    // Server-side validation
    $errors = array();

    if (empty($product_id)) {
        $errors[] = 'Please enter a product ID.';
    }

    if (empty($title)) {
        $errors[] = 'Please enter a title.';
    }

    if (empty($price) || !is_numeric($price)) {
        $errors[] = 'Please enter a valid price.';
    }

    // If there are any errors, return them as a JSON response
    if (!empty($errors)) {
        $response = array(
            'success' => false,
            'errors' => $errors
        );
        wp_send_json($response);
    }

    if ($id) {
        $wpdb->update(
            $table_name,
            array(
                'product_id' => $product_id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'sale_price' => $sale_price,
                'sale_text' => $sale_text,
                'sale_active' => $sale_active,
                'available' => $available,
                'interval_plan' => $interval_plan,
                'order_interval' => $order_interval,
            ),
            array('id' => $id)
        );

        $response = array(
            'success' => true,
            'message' => 'Subscription plan updated successfully.'
        );
    } else {
        $wpdb->insert(
            $table_name,
            array(
                'product_id' => $product_id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'sale_price' => $sale_price,
                'sale_text' => $sale_text,
                'sale_active' => $sale_active,
                'available' => $available,
                'interval_plan' => $interval_plan,
                'order_interval' => $order_interval,
                'created_at' => current_time('mysql'),
            )
        );
        $response = array(
            'success' => true,
            'message' => 'Subscription plan added successfully.'
        );
    }
    wp_send_json($response);
    die;
}

add_filter('woocommerce_add_cart_item_data', 'set_subscription_product_key', 10, 3);

function set_subscription_product_key($cart_item_data, $product_id, $variation_id)
{
    if ( !defined('SHIPPING_PROTECTION_PRODUCT') ) {
        define('SHIPPING_PROTECTION_PRODUCT', 858523);
    }
    
    if($product_id == SHIPPING_PROTECTION_PRODUCT){
        return $cart_item_data;
    }

    if (isset($_POST['arbid'])) {
        $cart_item_data['arbid'] = $_POST['arbid'];
        $cart_item_data['frequency'] = $_POST['frequency'];

        if(isset($_POST['disc_price'])){
            $cart_item_data['disc_price'] = $_POST['disc_price'];
        }

        if(isset($_POST['prod_price'])){
            $cart_item_data['shine'] = $_POST['shine'];
            $cart_item_data['prod_price'] = $_POST['prod_price'];
            $cart_item_data['members'] = $_POST['members'];
        }

    }
    return $cart_item_data;
}


add_action('woocommerce_before_calculate_totals', 'add_mbt_subscription_products');
function add_mbt_subscription_products(WC_Cart $cart)
{
//echo "<pre>";print_r($cart->get_cart());exit;
    foreach ($cart->get_cart() as $hash => $cart_item) {
        if (isset($cart_item['arbid'])) {
            $arbid = $cart_item['arbid'];
            $product_id = $cart_item['product_id'];
            
            if (isset($cart_item['disc_price']) && $cart_item['disc_price'] >0){
                $cart_item['data']->set_price($cart_item['disc_price']);
            }else if(isset($cart_item['prod_price']) && $cart_item['prod_price'] > 0){
                $cart_item['data']->set_price($cart_item['prod_price']);
            }
            else{
                $rows = get_field('define_subscription_plans', $product_id);
                foreach ($rows as $index => $data) {
                    if ($index == $arbid) {
                        $cart_item['data']->set_price($data['price']);
                    }
                }
            }

        }
    }
}

add_filter('woocommerce_cart_item_name', 'woocommerce_after_cart_item_name_subscription', 10, 3);
function woocommerce_after_cart_item_name_subscription($_productname, $cart_item, $cart_item_key)
{
    $html = '';
    if (isset($cart_item['arbid']) && !isset($cart_item['shine'])) {
        $html = '<br/>Plan: ' . $cart_item['frequency'] . ' days' . ($cart_item['quantity'] > 1 ? ' x ' . $cart_item['quantity'] : '');
    }elseif (isset($cart_item['shine'])) {
        $html = '<br/>';

        // Append member description if it exists
        if (!empty($cart_item['members'])) {
            if(strtolower($_productname) == 'shine member perks'){
                $html .= '( Unlimited ): ';
            }else{
                $html .= '(' . ucfirst($cart_item['members']) . '): ';
            }
            
        } else {
            $html .= ': ';
        }

        // Determine the frequency description
        if ($cart_item['frequency'] == 30) {
            $html .= 'Monthly';
        } elseif ($cart_item['frequency'] == 365) {
            $html .= 'Yearly';
        } else {
            // For other frequencies, show the number of days
            $html .= $cart_item['frequency'] . ' days';
        }

        // Append quantity if greater than 1
        $html .= ($cart_item['quantity'] > 1 ? ' x ' . $cart_item['quantity'] : '');
      //  $html = '<br/>'.'('.ucfirst(@$cart_item['members']).')'.': ' . $cart_item['frequency'] . ' days' . ($cart_item['quantity'] > 1 ? ' x ' . $cart_item['quantity'] : '');
    }
    return $_productname . $html;
}


add_action('woocommerce_new_order_item', 'order_item_meta_update_for_subscription', 10, 3);
function order_item_meta_update_for_subscription($item_id, $values)
{
    if (isset($values->legacy_values['arbid'])) {
        wc_add_order_item_meta($item_id, '_arbid', $values->legacy_values['arbid']);
    }

    if (isset($values->legacy_values['shine'])) {
        wc_add_order_item_meta($item_id, '_shine', $values->legacy_values['shine']);
        wc_add_order_item_meta($item_id, '_shine_members', $values->legacy_values['members']);
    }
}

//add_action('woocommerce_thankyou', 'smile_brilliant_payment_complete_subscription', 10);
add_action('woocommerce_payment_complete', 'smile_brilliant_payment_complete_subscription', 99,1);
//add_action('woocommerce_checkout_order_processed', 'smile_brilliant_payment_complete_subscription', 10);
function smile_brilliant_payment_complete_subscription($order_id)
{
    global $wpdb;
    $order = wc_get_order($order_id);
    $data = array();
    $wc_authorize_net_cim_credit_card_customer_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_customer_id', true);
    $wc_authorize_net_cim_credit_card_payment_token = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_payment_token', true);
    $authorize_cim_shipping_address_id = get_post_meta($order_id, '_authorize_cim_shipping_address_id', true);
    
    //$order_number = get_post_meta($order_id, 'order_number', true);
    if ($wc_authorize_net_cim_credit_card_customer_id) {
        foreach ($order->get_items() as $item_id => $item) {
            $arbid = wc_get_order_item_meta($item_id, '_arbid', true);
            $shine = wc_get_order_item_meta($item_id, '_shine', true);
            $retries = 3;
            $interval = 0;
            $plan_code = 0;
            $plan_name = "Shine Perks";
            if ($arbid > -1) {
                //toDo throw error if user subscribe for the same product
                $product_id = $item->get_product_id();
                $product = wc_get_product($product_id);
                /** Subscription Plan on Authorize.net**/

                if($shine && $shine > 0)
                    $rows = get_field('define_shine_membership_plans', $product_id);                
                else
                    $rows = get_field('define_subscription_plans', $product_id);                

                foreach ($rows as $index => $data) {
                    if ($index == $arbid) {
                        $price = $data['price'];

                        if (in_array($product_id, [SHINE_DENTAL_PRODUCT_ID]) && str_contains(strtolower(@$data['plan_type']['value']), 'individual')){
                            $plan_code = "577200";
                            $plan_name = "Shine Dental (Individual)";
                        }elseif(in_array($product_id, [SHINE_DENTAL_PRODUCT_ID])){
                            $plan_code = "577201";
                            $plan_name = "Shine Dental (Family)";
                        }

                        if (in_array($product_id, [SHINE_COMPLETE_PRODUCT_ID]) && str_contains(strtolower(@$data['plan_type']['value']), 'individual')){
                            $plan_code = "577204";
                            $plan_name = "Shine Complete (Individual)";
                        }
                        elseif(in_array($product_id, [SHINE_COMPLETE_PRODUCT_ID])){
                            $plan_code = "577205";
                            $plan_name = "Shine Complete (Family)";
                        }

                        if(is_array($data['billingshipping_frequency'])){
                            $interval = $data['billingshipping_frequency']['value'] < 7 ? 30 : $data['billingshipping_frequency']['value'];
                        }else{
                            $interval = $data['billingshipping_frequency'] < 7 ? 30 : $data['billingshipping_frequency'];
                        }

                    }
                }
                $title = substr($product->get_title() . " Every " . $interval . " days", 0, 50);
                
                for($i=0; $i<$retries; $i++)
                {
                    $dataObject = array(
                        "ARBCreateSubscriptionRequest" => array(
                            "merchantAuthentication" => array(
                                "name" => SB_AUTHORIZE_LOGIN_ID,
                                "transactionKey" => SB_AUTHORIZE_TRANSACTION_KEY
                            ),
                            "refId" => $item_id,
                            "subscription" => array(
                                "name" => $title,
                                "paymentSchedule" => array(
                                    "interval" => array(
                                        "length" => $interval,
                                        "unit" => "days"
                                    ),
                                    "startDate" => date('Y-m-d'),
                                    "totalOccurrences" => 999,
                                    "trialOccurrences" => "1"
                                ),
                                "amount" => $price,
                                "trialAmount" => "0.00",
                                "order" => array(
                                    "invoiceNumber" => ($shine && $shine >0 ?"SHINE-":"SUBC-") . $item_id,
                                    "description" => $title
                                ),
                                "profile" => array(
                                    "customerProfileId" => $wc_authorize_net_cim_credit_card_customer_id,
                                    "customerPaymentProfileId" => $wc_authorize_net_cim_credit_card_payment_token,
                                    "customerAddressId" => $authorize_cim_shipping_address_id
                                )
                            )
                        )
                    );
                    $response = authorizeCurlRequest(json_encode($dataObject));
                    $responseAPI = json_decode($response, true);

                    if(isset($responseAPI['subscriptionId']) && $responseAPI['subscriptionId']>0){
                        break;
                    }
                }

                $order->add_order_note(json_encode($dataObject));                
                $order->add_order_note($response);

                wc_add_order_item_meta($item_id, '_authorizeResponse', $response);
                wc_add_order_item_meta($item_id, '_subscriptionId', $responseAPI['subscriptionId']);

                if($responseAPI['subscriptionId']>0)
                {
                    //store subscription details
                    $user_id = get_post_meta($order_id, '_customer_user', true);
                    $transaction_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_trans_id', true);                    
                    update_user_meta($user_id, 'is_subscribed', 1);
                    $order->update_meta_data('_subscriptionId', $responseAPI['subscriptionId']);

                    if($shine && $shine >0){
                        cancel_existing_shine_memberships($order_id,$user_id);
                        update_user_meta($user_id, 'is_shine_user', 1);
                        update_user_meta($user_id, 'shine_current_member_ship_plan', $plan_name);
                        update_user_meta($user_id, 'shine_plan_code', $plan_code);
                        $order->update_meta_data('_shineSubcId', $responseAPI['subscriptionId']);
                    }                    

                    $qData = array(
                        'user_id' => $user_id,
                        'subscription_id' => ((int) $responseAPI['subscriptionId']),
                        'transaction_id' => $transaction_id,
                        'order_id' => $order_id,
                        'item_id' => $item_id,
                        'product_id' => $product_id,
                        'total_price' => $price,
                        'status' => 1,
                        'quantity' => $item->get_quantity(),
                        'subscription_date' => date('Y-m-d H:i:s'),
                        'interval_days' => $interval,
                        'next_order_date' => date('Y-m-d', strtotime(date('Y-m-d') . " + {$interval} days")),
                        'authorize_response' => $responseAPI,
                        'shine_group_code' => $plan_code
                    );
                    $wpdb->insert('sbr_subscription_details', $qData);
                }

                $order->add_order_note("Subscription Details Logs:" . json_encode($qData));
                $order->save();
            }
        }
    }
}

function sbr_subscriptions_list()
{
    global $wpdb;
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    ?>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
            <div class="ims-parent-body">
                <div class="search-shipement">
                    <h3><span class="dashicons dashicons-welcome-widgets-menus"></span>Subscriptions Management</h3>
                </div>

                <div class="loading-sbr" style="display: block;">
                    <div class="inner-sbr"></div>
                </div>
                <table id="ims" class="data-table" style="width:99%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Parent Order</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
            <style>
                table.dataTable tbody tr {
                    background-color: #fff;
                    text-align: center;
                }

                #smile_brillaint_order_modal {
                    z-index: 100023 !important;
                }
            </style>
            <script type="text/javascript">
                let datatable = '';

                function subscription_order_create(item_id) {
                    jQuery('.loading-sbr').show();
                    jQuery.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'subscription_order_create',
                            item_id: item_id,
                        },
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        beforeSend: function(xhr) {
                            // smile_brillaint_order_modal.style.display = "block";
                        },
                        success: function(response) {

                            jQuery('.loading-sbr').hide();
                            //alert(response);
                        },
                        error: function(xhr) {
                            //jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed. Something went wrong.'));
                        },
                        cache: false,
                        // contentType: false,
                        //  processData: false
                    });
                }

                function authorize_manage_subscription(subscription_id, event) {
                    if (event == 'history') {
                        jQuery("body").find('#smile_brillaint_order_modal .modal-content').addClass('ims_manage history');
                        jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
                    }else if (event == 'update') {
                        jQuery("body").find('#smile_brillaint_order_modal .modal-content').addClass('ims_manage history');
                        jQuery('body').find('#smile_brillaint_card_popup_response').html(smile_brillaint_load_html());
                    }
                    jQuery.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'authorize_manage_subscription',
                            subscription_db_id: subscription_id,
                            event: event
                        },
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        beforeSend: function(xhr) {
                            jQuery('.loading-sbr').show();
                            if (event == 'history' || event == 'update') {
                                smile_brillaint_order_modal.style.display = "block";
                            }
                        },
                        success: function(response) {
                            jQuery('.loading-sbr').hide();
                            datatable.ajax.reload();
                            if (event == 'history' || event == 'update') {
                                jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
                            }
                        },
                        error: function(xhr) {},
                        cache: false,
                    });
                }

                function authorize_cancell_subscription(subscription_id, refId) {
                    jQuery.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'authorize_cancell_subscription',
                            subscription_id: subscription_id,
                            refId: refId
                        },
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        beforeSend: function(xhr) {
                            jQuery('.loading-sbr').show();

                        },
                        success: function(response) {
                            jQuery('.loading-sbr').hide();
                            datatable.ajax.reload();

                        },
                        error: function(xhr) {},
                        cache: false,
                        // contentType: false,
                        //  processData: false
                    });
                }

                function authorize_subscription_log(subscription_id, refId) {

                    jQuery("body").find('#smile_brillaint_order_modal .modal-content').addClass('ims_manage history');
                    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());

                    jQuery.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'authorize_subscription_log',
                            subscription_id: subscription_id,
                            refId: refId
                        },
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        beforeSend: function(xhr) {
                            smile_brillaint_order_modal.style.display = "block";
                        },
                        success: function(response) {
                            // jQuery('#analyzing_impression_form').unblock();
                            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
                            // reload_order_item_table_mbt(order_id);
                        },
                        error: function(xhr) {
                            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed. Something went wrong.'));
                        },
                        cache: false,
                        // contentType: false,
                        //  processData: false
                    });
                }
                jQuery(document).ready(function() {
                    datatable = jQuery('#ims').DataTable({
                        "ordering": false,
                        "searching": true,
                        "bPaginate": false,
                        "processing": false,
                        "serverSide": false,
                        "clientSide": true,
                        "ajax": {
                            url: "<?php echo admin_url('admin-ajax.php?action=getAllSubscriptionList'); ?>",
                            type: "GET",
                            "data": function(d) {
                            },
                            "complete": function(response) {
                                jQuery('.loading-sbr').hide();
                            }
                        },
                        rowCallback: function(row, data) {
                            console.log(data);
                            //  $(row).addClass(data[7]);
                        }
                    });
                });
            </script>

            <?php
}


function authorizeCurlRequest($json)
{
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        )
    );
    $str = curl_exec($curl);
    curl_close($curl);
    for ($i = 0; $i <= 31; ++$i) {
        $response = str_replace(chr($i), "", $str);
    }
    $response = str_replace(chr(127), "", $str);
    if (0 === strpos(bin2hex($response), 'efbbbf')) {
        $response = substr($response, 3);
    }
    return $response;
}


add_filter('wp_ajax_authorize_manage_subscription', 'authorize_manage_subscription_callback');
function authorize_manage_subscription_callback()
{
    global $wpdb;
    $event = $_REQUEST['event'];
    $subId = $_REQUEST['subscription_db_id'];
    $subscriptionInfo = $wpdb->get_results("SELECT * FROM sbr_suspended_subscriptions ss  WHERE ss.status IN ('suspended', 'cancelled') AND subscription_id = ".$subId." ORDER by created_at DESC LIMIT 1");
    
    if (!empty($subscriptionInfo)) {
        $sub_db_id = $subscriptionInfo->id;
        foreach($subscriptionInfo as $subscription){

            $order_id = $subscription->parent_order_id;
            $item_id = $subscription->item_id;
            $sub_id = $subscription->subscription_id;

            switch ($event) {
                case 'history':    
                    
                    $dataObject = '{
                        "ARBGetSubscriptionRequest": {
                        "merchantAuthentication": {
                            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                            "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                        },
                        "refId": "' . $subscription->item_id . '",
                        "subscriptionId": "'.$subscription->subscription_id.'",
                        "includeTransactions": 1
                        }
                    }';
                    $responseAPI = json_decode(authorizeCurlRequest($dataObject), true);
                    ?>
                                                    <div id="smile_brillaint_order_popup_response">
                                                        <div class="productPoInfo">
                                                            <div class="productPoInfo1">
                                                                <h2><?php echo $responseAPI['subscription']['name']; ?></h2>
                                                            </div>
                                                            <div class="productPoInfo2">
                                                                <h2><?php echo $responseAPI['subscription']['paymentSchedule']['interval']['length'] . ' ' . $responseAPI['subscription']['paymentSchedule']['interval']['unit']; ?> </h2>
                                                                <h2><?php echo sbr_datetime($responseAPI['subscription']['paymentSchedule']['startDate']); ?></h2>
                                                            </div>
                                                        </div>
                                                        <div class="orderHistorySection">
                                                            <h3>Order History</h3>
                                                            <table id="orderHistory" class="data-table" style="width:99%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order Number</th>
                                                                        <th>Order Status</th>
                                                                        <th>Transaction ID</th>
                                                                        <th>Transaction Response</th>
                                                                        <th>Ordered Date</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php

                                                                    if (isset($responseAPI['subscription'])) {
                                                                        if (isset($responseAPI['subscription']['arbTransactions'])) {
                                                                            foreach ($responseAPI['subscription']['arbTransactions'] as  $arbTransactions) {
                                                                                if ($arbTransactions['payNum'] == 1) {

                                                                                    $order = wc_get_order($order_id);
                                                                                    $order_number = get_post_meta($order_id, 'order_number', true);
                                                                                    $get_transaction_id = $order->get_transaction_id();
                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td><?php echo $order_number; ?></td>
                                                                                                                        <td><?php echo $order->get_status(); ?></td>
                                                                                                                        <td><?php echo $get_transaction_id; ?></td>
                                                                                                                        <td><?php echo $arbTransactions['response']; ?></td>
                                                                                                                        <td><?php echo sbr_datetime($arbTransactions['submitTimeUTC']); ?></td>
                                                                                                                    </tr>

                                                                                                                <?php


                                                                                } else {
                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td>P_O10009</td>
                                                                                                                        <td>Value Mailer</td>
                                                                                                                        <td><?php echo $arbTransactions['transId']; ?></td>
                                                                                                                        <td><?php echo $arbTransactions['response']; ?></td>
                                                                                                                        <td><?php echo sbr_datetime($arbTransactions['submitTimeUTC']); ?></td>


                                                                                                                    </tr>
                                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    ?>

                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>
                                        <?php
                                        break;
                case 'cancel':
                    $data = '{
                        "ARBCancelSubscriptionRequest": {
                        "merchantAuthentication": {
                            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                                "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                        },
                        "refId": "' . $item_id . '",
                        "subscriptionId": "' . $sub_id . '",
                        }
                    }';

                    $response = authorizeCurlRequest($data);
                    $responseAPI = json_decode($response, true);

                    if (isset($responseAPI['subscriptionId'])) {
                        $wpdb->update(
                            'sbr_subscriptions',
                            array(
                                'subscription_status' => 1,
                                'authorize_response' => $response
                            ),
                            array('id' => $sub_db_id)
                        );
                    } else {
                        $wpdb->update(
                            'sbr_subscriptions',
                            array('authorize_response' => $response),
                            array('id' => $sub_db_id)
                        );
                    }
                    echo 'Deactivited Subscription';


                    break;
                case 'retry':


                    $wc_authorize_net_cim_credit_card_customer_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_customer_id', true);
                    $wc_authorize_net_cim_credit_card_payment_token = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_payment_token', true);
                    $authorize_cim_shipping_address_id = get_post_meta($order_id, '_authorize_cim_shipping_address_id', true);
                    $order_number = get_post_meta($order_id, 'order_number', true);
                    $subscription_id = wc_get_order_item_meta($item_id, '_plan_id', true);
                    if ($subscription_id) {

                        /** Subscription Plan on Authorize.net**/
                        global $wpdb;
                        $table_name = 'sbr_subscription_plans';
                        $query = "SELECT * FROM $table_name WHERE id= " . $subscription_id;
                        $results = $wpdb->get_row($query, "ARRAY_A");

                        $title = $results['title'];
                        $interval = $results['interval_plan'];
                        $price = $results['price'];
                        $data = '{
                "ARBCreateSubscriptionRequest": {
                    "merchantAuthentication": {
                        "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                        "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                    },
                    "refId": "' . $item_id . '",
                    "subscription": {
                        "name": "' . $title . '",
                        "paymentSchedule": {
                            "interval": {
                                "length": "' . $interval . '",
                                "unit": "months"
                            },
                            "startDate": "' . date('Y-m-d') . '",
                            "totalOccurrences": "' . $interval . '",
                            "trialOccurrences": "1"
                        },
                        "amount": "' . $price . '",
                        "trialAmount": "0.00",
                        "profile": {
                            "customerProfileId": "' . $wc_authorize_net_cim_credit_card_customer_id . '",
                            "customerPaymentProfileId": "' . $wc_authorize_net_cim_credit_card_payment_token . '",
                            "customerAddressId": "' . $authorize_cim_shipping_address_id . '"
                        }
                    }
                }
            }';
                        $response = authorizeCurlRequest($data);
                        $responseAPI = json_decode($response, true);

                        if (isset($responseAPI['subscriptionId'])) {
                            $wpdb->update(
                                'sbr_subscriptions',
                                array(
                                    'authorize_subscription_id' => $responseAPI['subscriptionId'],
                                    'authorize_response' => $response
                                ),
                                array('id' => $sub_db_id)
                            );
                        } else {
                            $wpdb->update(
                                'sbr_subscriptions',
                                array('authorize_response' => $response),
                                array('id' => $sub_db_id)
                            );
                        }
                    }
                    break;
                case 'update':    
                    ?>
                    <div id="smile_brillaint_card_popup_response">
                                <div class="productPoInfo">
                                    <div class="productPoInfo1">
                                        <h2>Add New Card Information</h2>
                                    </div>
                                </div>
                                <div class="orderHistorySection" style="width:100%;">
                                    <form id="form-card-info form-control" action="#" method="POST">
                                        <div class="form-group mb-2">
                                            <label for="cardNumber">Card Number *</label>
                                            <input type="text" class="form-control" id="cardNumber" placeholder="Card Number" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="expDate">Expiration Date (MM/YYYY) *</label>
                                            <input type="text" class="form-control" id="expDate" placeholder="MM/YYYY" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="cvv">CVV</label>
                                            <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
                                            <input type="hidden" id="subscriptionId_hidden" value="<?php echo $subscription->subscription_id; ?>">
                                            <input type="hidden" id="itemId_hidden" value="<?php echo $subscription->item_id; ?>">
                                        </div>

                                        <div class="form-group mb-2">
                                            <button type="button" class="btn btn-primary" onclick="updatCardInfo()">Authenticate Card</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                    <script> 
                        function updatCardInfo() {
                            if($('#cardNumber').val() != '' && $('#expDate').val() != '')
                            {
                                jQuery('.loading-sbr').show();
                                jQuery.ajax({
                                    type: "POST",
                                    url: ajaxurl,
                                    data: {
                                        action: 'update_subscription_info',
                                        subscription_id: $('#subscriptionId_hidden').val(),
                                        refId: $('#itemId_hidden').val(),
                                        cardNumber: $('#cardNumber').val(),
                                        expDate: $('#expDate').val(),
                                        cvv: $('#cvv').val(),
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        jQuery('.loading-sbr').hide();
                                        //jQuery('#smile_brillaint_order_modal').modal('hide');
                                        smile_brillaint_order_modal.style.display = 'none';
                                        if(response == 0){
                                            alert("Cannot update the cancelled subscription.");
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                        smile_brillaint_order_modal.style.display = 'none';
                                        alert("There is some error, please contact admin.");
                                    }
                                });
                            }else{
                                alert("Kindly fill required fields.");
                            }
                        }
                    </script>
                    <?php
                        break;
                default:
                    # code...
                    break;
            }
        }
    } else {
        echo 'No result found.';
    }

    die;
}


add_filter('wp_ajax_getAllSubscriptionList', 'getAllSubscriptionList_callback');
function getAllSubscriptionList_callback()
{
    global $wpdb;
    if($_GET['action'] == 'getAllSubscriptionList'){
        $draw = $_GET["draw"];
        $orderByColumnIndex = 0;
        //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'ASC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        /* *************** */
        $order_start_date = $_GET["startDate"]; //Paging first record indicator.
        $order_end_date = $_GET["endDate"]; //Paging first record indicator.
        $sc = $_GET["sc"]; //Paging first record indicator.
        /* *************** */
        $searchQuery = " ";
        $searchDateQuery = " ";

        $subscriptionData = array();
        $subscriptionInfo = $wpdb->get_results("SELECT * FROM sbr_suspended_subscriptions ss  WHERE ss.status IN ('suspended', 'cancelled') ORDER by created_at DESC");
        if ($subscriptionInfo) {
            foreach ($subscriptionInfo as $subscription) {

                //$retry = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscription->subscription_id . ' ,\'retry\')">Update Subscription</a>';
                $update = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscription->subscription_id . ' ,\'update\')">Update Card</a>';
                $history = '<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscription->subscription_id . ' ,\'history\')">View History</a>';
                //$cancel = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscription->id . ' ,\'cancel\')">Cancel Subscription</a>';

                $action_links = '';
                if($subscription->status == 'suspended'){
                    $action_links = $history.', '.$update;
                }else{
                    $action_links = $history;
                }
                
                $order_id = $subscription->parent_order_id;
                $order_number = get_post_meta($order_id, 'order_number', true);
                $billinh_email = get_post_meta($order_id, '_billing_email', true);
                $billing_name = get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true);
                if ($subscription->authorize_subscription_id) {
                    $status = 'Deactive';
                    if ($subscription->subscription_status) {
                        $status = 'Active';
                    }
                }

                $subscriptionData[] = array(
                    $subscription->subscription_id,
                    $subscription->title,
                    $order_number,
                    $billing_name,
                    $billinh_email,
                    wc_price($subscription->amount),
                    $subscription->status,
                    $subscription->created_at,
                    $action_links,
                    ''
                );
            }
        }

        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($subscriptionData),
            "iTotalDisplayRecords" => count($subscriptionData),
            "data" => $subscriptionData
        );

        echo json_encode($results);
        die;
    }
}


add_filter('wp_ajax_getAllSubscriptionListOld', 'getAllSubscriptionList_callbackOld');
function getAllSubscriptionList_callbackOld()
{
    global $wpdb;
    if (!empty($_GET)) {

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
        $orderType = 'ASC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        /* *************** */
        $order_start_date = $_GET["startDate"]; //Paging first record indicator.
        $order_end_date = $_GET["endDate"]; //Paging first record indicator.
        $sc = $_GET["sc"]; //Paging first record indicator.
        /* *************** */
        $searchQuery = " ";
        $searchDateQuery = " ";



        /*
        $data = '{
            "ARBGetSubscriptionListRequest": {
              "merchantAuthentication": {
                "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                    "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
              },
              "searchType": "subscriptionActive",
              "sorting": {
                "orderBy": "id",
                "orderDescending": "true"
            },
              "paging": {
                    "limit": "1000",
                    "offset": "1"
                }
            }
          }';


        $response = authorizeCurlRequest($data);
        $responseAPI = json_decode($response, true);
        // echo '<prE>';
        // print_r($responseAPI);
        // echo '</pre>';
        // die;
        $subscriptionData = array();

        if (isset($responseAPI['subscriptionDetails'])) {
            foreach ($responseAPI['subscriptionDetails'] as $subscriptionDetails) {



                $history = '<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscriptionDetails['id'] . ' ,\'history\')">History</a>';
                $cancel = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $subscriptionDetails['id'] . ' ,\'cancel\')">Cancel Subscription</a>';

                $subscriptionData[] = array(
                    $subscriptionDetails['id'],
                    $subscriptionDetails['name'],
                    $subscriptionDetails['invoice'],
                    $subscriptionDetails['firstName'] . ' ' . $subscriptionDetails['lastName'],
                    $subscriptionDetails['amount'] . ' ' . $subscriptionDetails['currencyCode'],
                    $subscriptionDetails['accountNumber'],
                    $subscriptionDetails['pastOccurrences'],
                    'Number Of Orders',
                    ucfirst($subscriptionDetails['status']),
                    sbr_datetime($subscriptionDetails['createTimeStampUTC']),
                    $history . $cancel,
                );
            }
        }
        // echo '<pre>';
        // print_r($responseAPI);
        // echo '</pre>';
        /*

{
    "ARBGetSubscriptionListRequest": {
        "merchantAuthentication": {
            "name": "5KP3u95bQpv",
            "transactionKey": "346HZ32z3fP4hTG2"
        },
        "refId": "123456",
        "searchType": "subscriptionActive",
        "sorting": {
            "orderBy": "id",
            "orderDescending": "false"
        },
        "paging": {
            "limit": "1000",
            "offset": "1"
        }
    }
}
*/




        global $wpdb;
        $plans_tbl = 'sbr_subscription_plans';
        $query = "SELECT * FROM $plans_tbl";
        $plans = $wpdb->get_results($query);
        $allPlans = array();
        foreach ($plans as $plan) {
            $allPlans[$plan->id] = $plan;
        }
        $subscription_tbl = 'sbr_subscriptions';
        $query1 = "SELECT * FROM $subscription_tbl";
        $sbr_subscriptions = $wpdb->get_results($query1);

        if ($sbr_subscriptions) {
            foreach ($sbr_subscriptions as $d_subscription) {

                $errorMsg = '';
                $flagError = false;
                $retry = '';
                if ($d_subscription->authorize_response == 0) {
                    $api_response = json_decode($d_subscription->authorize_response, true);

                    if (isset($api_response['messages']['resultCode']) && $api_response['messages']['resultCode'] == 'Error') {
                        $errorMsg = $api_response['messages']['message'][0]['text'];
                        $flagError = true;
                        $ation = 'retry';
                        $retry = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $d_subscription->id . ' ,\'retry\')">Retry Subscription</a>';
                    }
                }
                $history = '<a href="javascript:;" onclick="authorize_manage_subscription(' . $d_subscription->id . ' ,\'history\')">History</a>';
                $cancel = '';
                if ($d_subscription->subscription_status == 1) {
                    $cancel = '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $d_subscription->id . ' ,\'cancel\')">Cancel Subscription</a>';
                } else {
                    $history = '';
                    $cancel = 'Cancelled Subscription';
                    //$cancel .= '&nbsp;&nbsp;<a href="javascript:;" onclick="authorize_manage_subscription(' . $d_subscription->id . ' ,\'retry\')">Retry Subscription</a>';
                }

                $order_tbl = 'sbr_subscription_orders WHERE authorize_subscription_id= ' . $d_subscription->authorize_subscription_id;
                $query1 = "SELECT count(*) FROM $order_tbl";
                $orders = $wpdb->get_var($query1);
                $order_number = get_post_meta($d_subscription->order_id, 'order_number', true);

                if ($flagError) {

                    $subscriptionData[] = array(
                        $errorMsg,
                        $allPlans[$d_subscription->subscription_id]->title,
                        $d_subscription->subscription_id,
                        $orders,
                        $d_subscription->subscription_status,
                        $d_subscription->created_at,
                        $retry,
                        'subscription_failed'

                    );
                } else {
                    $subscriptionData[] = array(
                        $d_subscription->authorize_subscription_id,
                        $allPlans[$d_subscription->subscription_id]->title,
                        $d_subscription->subscription_id,

                        $orders,
                        $d_subscription->subscription_status,
                        $d_subscription->created_at,
                        $history . $cancel,
                        ''

                    );
                }
            }
        }

        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($subscriptionData),
            "iTotalDisplayRecords" => count($subscriptionData),
            "data" => $subscriptionData
        );

        echo json_encode($results);
    }
    die;
}



function sbr_productSubscriptionPlanManagement()
{

    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    wp_enqueue_script('dataTables_buttons', 'https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js', array('dataTables'), true);
    ?>

            <form id="saleManagement">
                <div class="search-shipement">
                    <h3>Subscription plan management<span class="dashicons dashicons-cart"></span> </h3>
                    <div class="form-group">
                        <input type="button" id="btnProductSale" class="button" value="Save Changes">
                    </div>
                </div>
                <div class="loading-sbr" style="display: none;">
                    <div class="inner-sbr"></div>
                </div>

                <table id="sale" class="data-table" style="width:99%">
                    <thead>
                        <tr>
                            <th>Plan ID</th>
                            <th>Product Name</th>
                            <th>Plan title</th>
                            <th>Product Price</th>
                            <th>Sale Price</th>
                            <th>Sale text</th>
                            <th>Sale</th>
                            <th>Plan status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
                <input type="hidden" name="action" value="savePSP">
            </form>
            <style>
                /* .shipment-inner-container {
                        display: none;
                    } */

                table.dataTable tbody tr {
                    background-color: #fff;
                    text-align: center;
                }

                .saleCategory {
                    display: inline-block;
                    vertical-align: top;
                    box-sizing: border-box;
                    margin: 1px 0 -1px 2px;
                    padding: 0 5px;
                    min-width: 18px;
                    height: 18px;
                    border-radius: 9px;
                    background-color: #d63638;
                    color: #fff;
                    font-size: 11px;
                    line-height: 1.6;
                    text-align: center;
                    z-index: 26;
                }
            </style>
            <script type="text/javascript">
                jQuery(document).ready(function() {

                    var datatable = jQuery('#sale').DataTable({
                        "ordering": false,
                        "searching": true,
                        "bPaginate": false,
                        "dom": "Bfrtip",
                        "processing": true,
                        "serverSide": false,
                        "clientSide": true,
                        "ajax": {
                            url: "<?php echo admin_url('admin-ajax.php?action=loadPSP'); ?>",
                            type: "GET",
                            "data": function(d) {

                            },
                            "complete": function(response) {
                                jQuery('.loading-sbr').hide();
                            }

                        },
                    });

                    jQuery('body').on('click', '#btnProductSale', function(e) {
                        var swaltext = 'Please make sure everything before save sale prices.';
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
                                    ///     dataType: 'JSON',
                                    success: function(response) {

                                        jQuery('.loading-sbr').hide();
                                        datatable.ajax.reload();
                                        //Swal.fire('Updated Successfully', 'success');

                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            }
                        });
                    });

                });
            </script>
        <?php
}



add_filter('wp_ajax_savePSP', 'savePSP_callback');
function savePSP_callback()
{

    global $wpdb;
    $table_name = 'sbr_subscription_plans';
    if (isset($_REQUEST['normalPrice']) && is_array($_REQUEST['normalPrice']) && count($_REQUEST['normalPrice']) > 0) {
        foreach ($_REQUEST['normalPrice'] as $plan_id => $normalPrice) {
            $sale_price = isset($_REQUEST['salePrice'][$plan_id]) ? $_REQUEST['salePrice'][$plan_id] : 0;
            $sale_active = isset($_REQUEST['sale_active'][$plan_id]) ? $_REQUEST['sale_active'][$plan_id] : 0;
            $sale_text = isset($_REQUEST['sale_text'][$plan_id]) ? $_REQUEST['sale_text'][$plan_id] : 'Sale!';

            $available = isset($_REQUEST['available'][$plan_id]) ? $_REQUEST['available'][$plan_id] : 0;
            $wpdb->update(
                $table_name,
                array(
                    'price' => $normalPrice,
                    'sale_price' => $sale_price,
                    'sale_text' => $sale_text,
                    'sale_active' => $sale_active,
                    'available' => $available
                ),
                array('id' => $plan_id)
            );
        }
    }
    echo 'Subscription plan updated successfully.';
    die;
}
add_filter('wp_ajax_loadPSP', 'loadPSP_callback');

function loadPSP_callback()
{
    global $wpdb;
    if (!empty($_GET)) {

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
        $order_start_date = $_GET["startDate"]; //Paging first record indicator.
        $order_end_date = $_GET["endDate"]; //Paging first record indicator.
        $searchQuery = " ";
        $searchDateQuery = " ";
        $modified_data = array();
        $rawPrdoucts = array();
        if (!empty($_GET['search']['value'])) {
        }




        global $wpdb;
        $table_name = 'sbr_subscription_plans';
        $results = $wpdb->get_results("SELECT * FROM $table_name ");
        // echo '<prE>';
        // print_r($results);
        // echo '</pre>';
        foreach ($results as $ps) {
            $product_id = $ps->product_id;
            $plan_id = $ps->id;
            $entry = array();

            $title = '<a href="' . get_edit_post_link($product_id) . '" target="_blank">' . get_the_title($product_id) . '</a>';
            $entry[] = $plan_id;
            $entry[] = $title;
            $entry[] = $ps->title;
            $entry[] = '<input autocomplete="off" class="product_sale_entry" type="text" name="normalPrice[' . $plan_id . ']" value="' . $ps->price . '" />';
            $entry[] = '<input autocomplete="off" class="product_sale_entry" type="text" name="salePrice[' . $plan_id . ']" value="' . $ps->sale_price . '" />';
            $entry[] = '<input autocomplete="off" class="product_sale_entry" type="text" name="sale_text[' . $plan_id . ']" value="' . $ps->sale_text . '" />';
            $checked = '';
            if ($ps->sale_active) {
                $checked = 'checked=""';
            }
            $entry[] = '<input autocomplete="off" type="checkbox" value="1" class="product_entry" ' . $checked . ' name="sale_active[' . $plan_id . ']" />';

            $checked = '';
            if ($ps->available) {
                $checked = 'checked=""';
            }
            $entry[] = ' <input autocomplete="off" type="checkbox" value="1" class="product_entry" ' . $checked . ' name="available[' . $plan_id . ']" />';
            $modified_data[] = $entry;
        }
        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($results),
            "iTotalDisplayRecords" => count($results),
            "data" => $modified_data
        );
        echo json_encode($results);
    }
    die;
}



add_filter('wp_ajax_authorize_cancell_subscription', 'authorize_cancell_subscription_callback');
function authorize_cancell_subscription_callback()
{
    global $wpdb;
    $sub_id = $_REQUEST['subscription_id'];
    $refId = $_REQUEST['refId'];

    $data = '{
        "ARBCancelSubscriptionRequest": {
          "merchantAuthentication": {
            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
          },
          "refId": "' . $refId . '",
          "subscriptionId": "' . $sub_id . '",
        }
      }';

    //  echo 'Data: <pre>' . print_r($data, true) . '</pre>';
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
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
        )
    );
    $str = curl_exec($curl);
    curl_close($curl);
    for ($i = 0; $i <= 31; ++$i) {
        $response = str_replace(chr($i), "", $str);
    }
    $response = str_replace(chr(127), "", $str);
    if (0 === strpos(bin2hex($response), 'efbbbf')) {
        $response = substr($response, 3);
    }
    $responseAPI = json_decode($response, true);

    if ($responseAPI) {
        $wpdb->update(
            'sbr_subscription_details',
            array('status' => 0, 'updated_at'=> date("Y-m-d H:i:s")),
            array('subscription_id' => $sub_id, 'item_id' => $refId)
        );
        
        $results = $wpdb->get_row("SELECT * FROM sbr_subscription_details WHERE subscription_id= {$sub_id} AND item_id={$refId}", "ARRAY_A");        
        $wpdb->insert('sbr_suspended_subscriptions', array(
            'user_id' => @$results['user_id'],
            'subscription_id' => $sub_id,
            'parent_order_id' => @$results['order_id'],
            'item_id' => $refId,
            'quantity' => @$results['quantity'],
            'title' => @$results['interval_days'].' days',
            'amount' => @$results['total_price'],
            'status' => 'cancelled',
            'authorize_response' => ((string)$responseAPI)
        ));

        $user_id = @$results['user_id'];
        $otherSubscriptions = $wpdb->get_results("SELECT * FROM sbr_subscription_details WHERE user_id = $user_id AND status = 1 AND shine_group_code <> 0 ORDER BY id DESC");        
        if($otherSubscriptions){
            update_user_meta($user_id, 'is_shine_user', 1);
            update_user_meta($user_id, 'shine_plan_code', @$otherSubscriptions[0]->shine_group_code);            
            $plan_name = "";
            if (@$otherSubscriptions[0]->shine_group_code == '577200'){
                $plan_name = "Shine Dental (Individual)";
            }elseif(@$otherSubscriptions[0]->shine_group_code == "577201"){
                $plan_name = "Shine Dental (Family)";
            }elseif(@$otherSubscriptions[0]->shine_group_code == "577204"){
                $plan_name = "Shine Complete (Individual)";
            }elseif(@$otherSubscriptions[0]->shine_group_code == "577205"){
                $plan_name = "Shine Complete (Family)";
            }
            update_user_meta($user_id, 'shine_current_member_ship_plan', $plan_name);
        }else if($results && @$results[0]->next_order_date >= date("Y-m-d")){
            update_user_meta($user_id, 'is_shine_user', 0);
            update_user_meta($user_id, 'shine_current_member_ship_plan', 'N/A');
        }
    }

    die;
}


function sbr_customer_subscription_dashboard_endpoints()
{
    add_rewrite_endpoint('subscription', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('subscription-detail', EP_ROOT | EP_PAGES);
}





add_filter("woocommerce_get_query_vars", function ($vars) {

    foreach (["subscription", "subscription-detail"] as $e) {
        $vars[$e] = $e;
    }

    return $vars;
});
// ------------------
// 3. Insert the new endpoint into the My Account menu

function sbr_customer_dashboard_subscription_link_my_account($items)
{
    //$items['subscription'] = 'Subscription';
    $items['shine-subscription'] = 'Shine Subscription';
    return $items;
}




function sbr_customer_dashboard_subscription_content()
{
    global $wpdb;    
    $subscription_id = "";
    $user_id = get_current_user_id();
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $postsPerPage = -1;
?>

<div class="d-flex align-items-center orderListingPageMenu menuParentRowHeading menuParentRowHeadingOrderParent borderBottomLine">
            <div class="pageHeading_sec">
                <span><span class="text-blue">Subscriptions </span>Track, return or buy items again.</span> 
            </div>                        
</div>	
<?php
    $customer_subscriptions = $wpdb->get_results("SELECT *, COUNT(1) as count FROM sbr_subscription_details WHERE user_id=".$user_id." AND subscription_id > 0 GROUP BY subscription_id ORDER BY subscription_id, id");
    foreach ($customer_subscriptions as $customer_order) {
                $product = wc_get_product( $customer_order->product_id );
                $productTitle = '<h4 class="productNameAndQuantity mb-0 "><a href="' . get_the_permalink($customer_order->product_id) . '" target= "_blank">' . $product->get_name() . ' × <span class="text-blue">' . $customer_order->quantity . '</span></a></h4>';
                $shine = get_post_meta($customer_order->order_id, '_shineSubcId', true);
        if($subscription_id != $customer_order->subscription_id){
            
?>
        <div class="subscription_wrapper <?php echo ($shine?'shineSubscribed':'');?>">
            <div class="subscription_header">
                <div class="subscription_title">
                    <h3><?php echo ($shine?$product->get_name().' for ':'').$customer_order->interval_days . ' Days Package'; ?></h3>
                </div>

             <div class="subscription-product-wrapper">
                <div class="subscription-product-image-title">
                    <div class="orderImage">
                        <?php echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail',  $product->get_image(), $customer_order->item_id)); ?>
                    </div>
                    <?php echo $productTitle;?>
                </div>

                <div class="subscription-status-wrapper">
                    <div class="sbr-orderItemRightActions">
                        <?php
                            if ($customer_order->status) {
                        ?>
                                <a href="javascript:void(0)" class="button btn-primary-blue cancle-subscription" onclick="setCancelSubValues(<?php echo $customer_order->subscription_id; ?>, <?php echo $customer_order->item_id; ?>);" data-toggle="modal" data-target="#viewSubscriptionCancelModal">Cancel / Pause Subscription </a>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="subscription-status">
                        <span style="float: right; font-weight: 400;"><span  style="color: #3c98cc;">Subscription Status: </span> <?php echo ($customer_order->status ? 'Active' : 'Cancelled'); ?></span>
                    </div>
                </div>
             </div>
          
            </div>

            <div class="lowOrderArea">

            <div id="accordion">
            <div class="card">
                <div class="card-header" id="heading<?php echo $subscription_id;?>">
                    <h5 class="mb-0">
                    <button class="btn btn-link collapsed" style="width: 100%;" data-toggle="collapse" data-target="#collapse<?php echo $subscription_id;?>" aria-expanded="false" aria-controls="collapse<?php echo $subscription_id;?>">
                        View Payment History
                        </button>
                    </h5>
                </div>
    <div id="collapse<?php echo $subscription_id;?>" class="collapse" aria-labelledby="heading<?php echo $subscription_id;?>" data-parent="#accordion">
        <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Payment#</th>
                            <th>Attempt#</th>
                            <th>Date</th>
                            <th>Response</th>
                            <th>Status</th>
                            <th>Total</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
}         
            $count = 1;
            $subscription_orders = $wpdb->get_results("SELECT * FROM sbr_subscription_details WHERE subscription_id = $customer_order->subscription_id ORDER BY id");          
            foreach ($subscription_orders as $subscription_order) {
                if (empty(wc_get_order_item_meta($subscription_order->item_id, '_subscriptionId', true)) && !$subscription_order)
                    continue;

                $order = wc_get_order($subscription_order->order_id);
                
                $invoice = wc_pip()->get_document('invoice', array('order' => $order));

                $invoiceTitle = '';
                if ($invoice && $invoice->has_invoice_number()) {
                    $invoiceLink = wp_nonce_url(
                        add_query_arg([
                            'wc_pip_action' => 'print',
                            'wc_pip_document' => 'invoice',
                            'order_id' => $order->get_id(),
                        ]),
                        'wc_pip_document'
                    );                    
                    $invoiceTitle = '<a target="_blank" href="'. site_url($invoiceLink) .'" class="text-blue">Invoice</a>';                
                }

                $statusTitle = 'Preparation';
                $three_way_ship_product = get_post_meta($subscription_order->product_id, 'three_way_ship_product', true);
                $total = number_format((float) $subscription_order->total_price, 2, '.', '');
                $shippedhistory = 0;
                $get_statusItem = 1;
                if ($order && $order->get_status() === 'processing') {
                    $get_statusItem = 1;
                } else if ($order && in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                    $q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
                    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                    $q1 .= " WHERE item_id = " . $subscription_order->item_id . " AND product_id = " . $subscription_order->product_id;
                    $q1 .= " ORDER BY log_id DESC LIMIT 1";
                    $logEntry = $wpdb->get_row($q1, 'ARRAY_A');
                    if (isset($logEntry['event_id']) && $logEntry['event_id'] > 0) {
                        $get_statusItem = $logEntry['event_id'];
                        $statusTitle = $logEntry['status'];
                    }
                    if ($get_statusItem == 17) {
                        $classSplited = 'itemSplitted';
                    }
                    if (isset($logEntry['event_id']) && $logEntry['event_id'] == 2) {
                        $shippedhistory = wc_get_order_item_meta($subscription_order->item_id, '_shipped_count', true);
                    }
                } else {
                    $get_statusItem = 0;
                }

                $cancelOrderButton = '';
                $trackingButton = '';
                if ($order && ($order->get_status() == 'pending' || $order->get_status() == 'failed')) {                    
                    $cancelOrderButton = '<a href="'. $order->get_checkout_payment_url().'" class="text-blue orangeButton">Pay Now</a>';
                } else if ($order && $order->get_status() == 'processing') {
                    $cancelOrderButton = cancelOrderButton($subscription_order->order_id, $order->get_order_number());
                } else {
                    if (in_array($order && $order->get_status(), array('partial_ship', 'shipped'))) {
                        $query = "SELECT  st.easyPostShipmentTrackingUrl FROM " . SB_EASYPOST_TABLE . " as st";
                        $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                        $query .= " WHERE  l.order_id = $subscription_order->order_id AND st.shipmentState IS  NULL";
                        $query .= " ORDER BY st.shipment_id DESC ";
                        $query_tracking_number = $wpdb->get_var($query);
                       
                        if ($query_tracking_number) {
                            $trackingButton = '</span><a href="' . $query_tracking_number . '" target="_blank" class="text-blue">Track <span class="hidden-mobile">Order</span></a>';
                            $cancelOrderButton = refundOrderButton($subscription_order->order_id, $order->get_order_number());
                        }
                    }
                }

                $orderItemStatus = '';
                $trackOrderReview = '';
                if ($order && in_array($order->get_status(), array('partial_ship', 'shipped', 'processing'))) {
                   
                        $itemData = array(
                            'product_id' => $subscription_order->product_id,
                            'item_id' => $subscription_order->item_id,
                            'order_number' => $order->get_order_number(),
                            'shipped' => $shippedhistory
                        );
                        $orderItemStatus = stageItemLevel($get_statusItem, $three_way_ship_product, $statusTitle, $itemData);

                        if($subscription_orders == 0){
                            $trackOrderReview .= '<a href="javascript:;" data-toggle="modal" data-target="#viewLogModalpopup" onclick="viewItemSummery(' . $subscription_order->product_id . ' , ' . $subscription_order->item_id . ' , \'' . $order->get_order_number() . '\')" class="viewlogbtn  mobileTrackButton order3" data-toggle="modal" data-target="#exampleModal">Track</a>';
                        }
                        $trackOrderReview .= '<a href="javascript:;" data-toggle="modal" data-target="#addProductModalpopup" onclick="addProductReview(' . $subscription_order->product_id . ' , ' . $subscription_order->item_id . ' , \'' . $order->get_order_number() . '\')" class="viewlogbtn  mobileTrackButton order3 buttonBlue" data-toggle="modal" data-target="#addCustomerProductReview">Add a review</a>';                                               
                }
               // if(!$call_api){
                    $dataObject = '{
                        "ARBGetSubscriptionRequest": {
                        "merchantAuthentication": {
                            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                            "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                        },
                        "refId": "' . $subscription_order->item_id . '",
                        "subscriptionId": "' . $subscription_order->subscription_id . '",
                        "includeTransactions": 1
                        }
                    }';
                    $subscription_details = json_decode(authorizeCurlRequest($dataObject), true);

                    if (!isset($subscription_details['subscription']['arbTransactions'])){
                        $transaction_id = $subscription_order->transaction_id;

                        if(!$transaction_id)
                            $transaction_id = get_post_meta($subscription_order->order_id, '_wc_authorize_net_cim_credit_card_trans_id', true);                    

                        $dataObject = '{
                            "getTransactionDetailsRequest": {
                                "merchantAuthentication": {
                                    "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                                    "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                                },
                                "transId": "'.$transaction_id.'"
                            }
                        }';
                        $subscription_details = json_decode(authorizeCurlRequest($dataObject), true);
                    }
                    //$call_api = true;
               // }

                

                $transactions = (array)@$subscription_details['subscription']['arbTransactions'];
                if ($order && count($transactions) > 1) {
                    foreach ($transactions as $index => $transaction) {
                        echo "<tr>";?>
                        <td><div class="sbr-ordernumber mFlex">
                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="orderTopLInkAnchor">
                                <h3><span class="text-blue"><?php echo $order->get_order_number(); ?></span></h3>
                            </a></div>
                        </td>
                    <?php                   
                    //$transaction['payNum']
                    //$transaction['submitTimeUTC']
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $transaction['attemptNum'] . "</td>";
                        echo "<td>" . date('m/d/Y', strtotime($subscription_order->subscription_date)) . "</td>";
                        echo "<td>" . $transaction['response'] . "</td>";
                        echo "<td>" . $orderItemStatus . "</td>";
                        echo "<td>$" . @$subscription_details['subscription']['amount'] . "</td>";
                        echo "<td><div class='trackOrderReview'>" . $invoiceTitle.$trackOrderReview . "</div></td>";
                        echo "</tr>";
                        break;
                    }
                } else if($order && count($transactions) == 1) {
                    echo "<tr>";?>
                        <td><div class="sbr-ordernumber mFlex">
                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="orderTopLInkAnchor">
                                <h3><span class="text-blue"><?php echo $order->get_order_number(); ?></span></h3>
                            </a></div>
                        </td>
                    <?php                            
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $transactions[0]['attemptNum'] . "</td>";
                        echo "<td>" . date('m/d/Y', strtotime($subscription_order->subscription_date)) . "</td>";
                        echo "<td>" . $transactions[0]['response'] . "</td>";
                        echo "<td>" . $orderItemStatus . "</td>";
                        echo "<td>$" . @$subscription_details['subscription']['amount'] . "</td>";
                        echo "<td><div class='trackOrderReview'>" . $invoiceTitle.$trackOrderReview . "</div></td>";
                        echo "</tr>";
                } else{
                    
                    if(isset($subscription_details['transaction']['lineItems'])){
                        
                        $result = $wpdb->get_row($wpdb->prepare("SELECT item_id FROM sbr_subscription_details WHERE order_id = " . $customer_order->order_id . " AND product_id = ".$subscription_order->product_id." AND subscription_id > 0"), ARRAY_A);
                        foreach($subscription_details['transaction']['lineItems'] as $index => $sub_details){
                            if(in_array($sub_details['itemId'], $result)){
                                ?>
                                <td><div class="sbr-ordernumber mFlex">
                                <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="orderTopLInkAnchor">
                                    <h3><span class="text-blue"><?php echo $order->get_order_number(); ?></span></h3>
                                        </a></div>
                                    </td>
                                <?php      
                                echo "<td>".$count."</td>";
                                echo "<td>1</td>";
                                echo "<td>" . date('m/d/Y', strtotime($subscription_order->created_at)) . "</td>";
                                echo "<td> This transaction has been approved. </td>";
                                echo "<td>" . $orderItemStatus . "</td>";
                                echo "<td>$" . (float)@$sub_details['unitPrice'] . "</td>";
                                echo "<td><div class='trackOrderReview'>" . $invoiceTitle.$trackOrderReview . "</div></td>";
                                echo "</tr>";
                            }
                        }
                    }
                }
                
                $count++;
                if($subscription_id != $customer_order->subscription_id){
                    $subscription_id = $customer_order->subscription_id;
                }
            }
if($subscription_id == $customer_order->subscription_id && $customer_order->count == $count-1){
                ?>                
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
            <?php
                if ($subscription_order->status) {
            ?>
            <div class="schedule_subscription">
        <div id="accordionB">
            <div class="card">
                <div class="card-header" id="headingB<?php echo $subscription_id;?>">
                    <h5 class="mb-0">
                    <button class="btn btn-link collapsed" style="width: 100%;" data-toggle="collapse" data-target="#collapseB<?php echo $subscription_id;?>" aria-expanded="false" aria-controls="collapse<?php echo $subscription_id;?>">
                        View Subscription Schedule
                        </button>
                    </h5>
                </div>
    <div id="collapseB<?php echo $subscription_id;?>" class="collapse" aria-labelledby="headingB<?php echo $subscription_id;?>" data-parent="#accordionB">
        <class="card-body">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="font-weight: bolder;">Date</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                            $date = date("Y-m-d", strtotime($subscription_order->created_at));
                            for ($i = 0; $i < 4; $i++) {
                                $date = date("Y-m-d", strtotime("+".$subscription_order->interval_days." days", strtotime($date)));                                
                                echo "<tr><td><span class='dateDigits'>" . date("j F, Y", strtotime($date)) ."</span></td></tr>";
                            }
                    ?>                
            </tbody>
        </table>
         
        </div>
        </div>
        </div>
        </div>
        <?php 
            }
}
        ?>
    </div>
<?php
}
?>
  <!-- Modal -->
  <style>
        .modal-backdrop{
            top: unset !important;
        }
        </style>
        <div class="modal fade" id="viewSubscriptionCancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel this subscription?
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="sbr-subscription_id">
                        <input type="hidden" value="" id="sbr-reference_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="deleteButton">Cancel Subscription</button>
                    </div>
                </div>
            </div>
        </div>

        <script> 
            function setCancelSubValues(subscriptionId, refId){
                $('#sbr-subscription_id').val(subscriptionId);
                $('#sbr-reference_id').val(refId);
            }
          jQuery(document).ready(function($) {        
                $('#deleteButton').on('click', function() {

                    jQuery.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'authorize_cancell_subscription',
                            subscription_id: $('#sbr-subscription_id').val(),
                            refId: $('#sbr-reference_id').val(),
                        },
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        success: function(response) {
                           //alert(response);
                           location.reload();
                        },
                        cache: false,
                    });

                    // Close the modal
                    $('#viewSubscriptionCancelModal').modal('hide');
                });
            });
        </script>
        <!--- End Modal --->
<!--Static html end -->

        <?php
        
        if (isset($_REQUEST['action'])) {
            die;
        } else {
            return true;
        }
}

/*add_action( 'woocommerce_checkout_create_order', 'update_order_line_items', 30, 2 );
function update_order_line_items( $order, $posted_data ){

   foreach ($order->get_items() as $item_id => $item) {
       // Get product data
       $product = $item->get_product();
       //wc_delete_order_item($item_id);

       // Split items based on their quantity
       for ($i = 1; $i <= $item->get_quantity(); $i++) {
           // Create a new order item
           $new_item = clone $item;

           // Adjust quantity and price for the new item
           $new_item->set_quantity(1);
           $new_item->set_total($product->get_price());
           $new_item->set_subtotal($product->get_price());

           // Add the new item to the order
           $order->add_item($new_item);
       }
   }

   // Save the updated order
   $order->save();
}*/
add_action('wp_ajax_get_subscription_items_data','get_subscription_items_data');
add_action('wp_ajax_nopriv_get_subscription_items_data','get_subscription_items_data');

function get_subscription_items_data(){
    global $wpdb;

    $dataList = [];
    $product = isset($_REQUEST['product_id'])?$_REQUEST['product_id']:'';
    
    if(in_array($product, ENAMELARMOUR_SUBSCRIPTION_PRODUCTS)){
        $products = ENAMELARMOUR_SUBSCRIPTION_PRODUCTS;
    }elseif(in_array($product, PLAQUE_HIGHLIGHTER_SUBSCRIPTION_PRODUCTS)){
        $products = PLAQUE_HIGHLIGHTER_SUBSCRIPTION_PRODUCTS;
    }else{
        $products = PROBIOTIC_SUBSCRIPTION_PRODUCTS;
    }
    
    foreach($products as $product_id){
        $_product = wc_get_product( $product_id );
        $rows = get_field('define_subscription_plans', $product_id); 
        if( $rows ) {
            foreach( $rows as $index => $row ) {                     
                if(is_array($row['billingshipping_frequency'])){
                    $dataList[$product_id][$row['billingshipping_frequency']['value']]['arbid'] = $index;
                    $dataList[$product_id][$row['billingshipping_frequency']['value']]['price'] = $row['price'];
                    $dataList[$product_id][$row['billingshipping_frequency']['value']]['reg_price'] = $_product->get_regular_price();
                    $dataList[$product_id][$row['billingshipping_frequency']['value']]['frequency'] = $row['billingshipping_frequency']['value'];
                }else{
                    $dataList[$product_id][$row['billingshipping_frequency']]['arbid'] = $index;
                    $dataList[$product_id][$row['billingshipping_frequency']]['price'] = $row['price'];
                    $dataList[$product_id][$row['billingshipping_frequency']]['reg_price'] = $_product->get_regular_price();
                    $dataList[$product_id][$row['billingshipping_frequency']]['frequency'] = $row['billingshipping_frequency'];
                }
            }
        }
    }
           
    echo json_encode(array('data'=>$dataList));
    die();
}


add_action('wp_ajax_get_subscription_items','get_subscription_items');
add_action('wp_ajax_nopriv_get_subscription_items','get_subscription_items');

function get_subscription_items(){
    global $wpdb;
if(isset($_REQUEST['product_id']) && $_REQUEST['product_id']!=''){
    $indexList = [];
    $priceList = [];
    $product_id = $_REQUEST['product_id'];
    $frequency = $_REQUEST['frequency'];

    $options = "";
    $rows = get_field('define_subscription_plans', $product_id); 

    if(!$rows)
        $rows = get_field('define_shine_membership_plans', $product_id);

    if( $rows ) {
        foreach( $rows as $index => $row ) {                 
            if(is_null($frequency)){
                if(is_array($row['billingshipping_frequency'])){
                    $frequency = $row['billingshipping_frequency']['value'];    
                }else
                    $frequency = $row['billingshipping_frequency'];
            }

            if(isset($row['plan_type']['value']))
                $package_name = "(".ucfirst($row['plan_type']['value']).") ".(is_array($row['billingshipping_frequency'])?$row['billingshipping_frequency']['value']:$row['billingshipping_frequency']);
            else
                $package_name = is_array($row['billingshipping_frequency'])?$row['billingshipping_frequency']['value']:$row['billingshipping_frequency'];

            $billing_frequency = is_array($row['billingshipping_frequency'])?$row['billingshipping_frequency']['value']:$row['billingshipping_frequency'];    
            $indexList[$billing_frequency] = $index;
            $priceList[$billing_frequency] = $row['price'];
            $options .= "<option value='".$billing_frequency."' arbid='".$index."' data-price='".$row['price']."' ".($frequency == $billing_frequency?'selected':'')." >".$package_name." days package</option>";
        }
    }


    $_product = wc_get_product( $product_id );
    
    $response = array('arbid'=>$indexList[$frequency], 'price'=>$priceList[$frequency], 'reg_price'=>$_product->get_price(), 'frequency'=>$frequency, 'options'=>$options);
}
else{
    $response= array();
}
    echo json_encode($response);
    die();
}

/*
function search_customers_callback() {
    check_ajax_referer('security_nonce', 'nonce');

    // Get the search term from the AJAX request
    $search_term = sanitize_text_field($_GET['q']);

    // Perform the customer search using WooCommerce function
    $customers = wc_get_customers(array('s' => $search_term));

    // Format the data for Select2
    $formatted_customers = array();
    foreach ($customers as $customer) {
        $formatted_customers[] = array(
            'id'   => $customer->get_id(),
            'text' => $customer->get_formatted_name(),
        );
    }

    // Return the formatted data as JSON
    wp_send_json($formatted_customers);
}
add_action('wp_ajax_search_customers', 'search_customers_callback');
add_action('wp_ajax_nopriv_search_customers', 'search_customers_callback');*/

function subscription_details_tab_content()
{
    // Get the subscription ID from the URL
    $subscription_id = isset($_GET['subscription_id']) ? intval($_GET['subscription_id']) : 0;
    echo '<p>Invalid subscription ID.</p>';
}
//add_filter('query_vars', 'sbr_customer_subscription_dashboard_endpoints', 10);
add_filter('woocommerce_account_menu_items', 'sbr_customer_dashboard_subscription_link_my_account');
add_action('woocommerce_account_subscription_endpoint', 'sbr_customer_dashboard_subscription_content');
add_action('woocommerce_account_subscription-detail_endpoint', 'subscription_details_tab_content');

add_action('woocommerce_order_status_changed', 'unsubscribe_orders', 10, 3);
function unsubscribe_orders($order_id, $old_status, $new_status)
{
    global $wpdb;
    if(in_array($new_status, ['cancelled', 'failed', 'refunded', 'trash'])){
        $subscriptionInfo = $wpdb->get_results("SELECT * FROM sbr_subscription_details  WHERE status=1 AND order_id = ".$order_id );    
        if (!empty($subscriptionInfo)) {
            foreach($subscriptionInfo as $subscription){
                $refId = $subscription->item_id;
                $sub_id = $subscription->subscription_id;

                $data = '{
                    "ARBCancelSubscriptionRequest": {
                    "merchantAuthentication": {
                        "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                            "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                    },
                    "refId": "' . $refId . '",
                    "subscriptionId": "' . $sub_id . '",
                    }
                }';

                $curl = curl_init();    
                curl_setopt_array(
                    $curl,
                    array(
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
                    )
                );
                $str = curl_exec($curl);
                curl_close($curl);
                for ($i = 0; $i <= 31; ++$i) {
                    $response = str_replace(chr($i), "", $str);
                }
                $response = str_replace(chr(127), "", $str);
                if (0 === strpos(bin2hex($response), 'efbbbf')) {
                    $response = substr($response, 3);
                }
                $responseAPI = json_decode($response, true);

                if ($responseAPI) {
                    $wpdb->update(
                        'sbr_subscription_details',
                        array('status' => 0),
                        array('subscription_id' => $sub_id, 'item_id' => $refId)
                    );
                    $wpdb->insert('sbr_suspended_subscriptions', array(
                        'user_id' => $subscription->user_id,
                        'subscription_id' => $sub_id,
                        'parent_order_id' => $order_id,
                        'item_id' => $refId,
                        'quantity' => $subscription->quantity,
                        'title' => $subscription->interval_days.' days',
                        'amount' => $subscription->total_price,
                        'status' => 'cancelled',
                        'authorize_response' => ((string)$responseAPI)
                    ));                 
                }
            }
        }
    }
}

// Add a new item to the admin menu
// function custom_report_menu() {
//     add_menu_page(
//         __( 'Shine Report', 'textdomain' ),   // Page title
//         __( 'Shine Report', 'textdomain' ),   // Menu title
//         'manage_options',                      // Capability
//         'shine-report',                       // Menu slug
//         'shine_report_page_content',          // Function to display the page content
//         'dashicons-update',             // Icon URL
//         6                                      // Position
//     );
// }

//add_action( 'admin_menu', 'custom_report_menu' );

// Function to display the content of the custom report page
// function shine_report_page_content() {
//     
// }

// Function to generate the custom report
function generate_custom_report() {
    global $wpdb;

    // Example query to get the number of WooCommerce orders
    $results = $wpdb->get_results("SELECT COUNT(*) as total_orders FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order' AND post_status = 'wc-completed'");
    
    if ( !empty($results) ) {
        echo '<h2>' . __('Total Completed Orders', 'textdomain') . '</h2>';
        echo '<p>' . __('Total number of completed orders:', 'textdomain') . ' ' . $results[0]->total_orders . '</p>';
    } else {
        echo '<p>' . __('No data found', 'textdomain') . '</p>';
    }
}


// // Function to customize product names on invoices with a custom field
// function custom_invoice_product_name_with_custom_field($name, $item) {
//     // Get the product ID
//     $product_id = $item->get_product_id();
    
//     // Get the custom field value
//     $custom_field_value = get_post_meta($product_id, 'shine_members', true);

//     // Append the custom field value to the product name
//     $custom_name = $name . ' - -----' . $custom_field_value;

//     return $custom_name;
// }

// // Hook into WooCommerce to apply the custom function to product names on invoices
// add_filter('woocommerce_order_item_name', 'custom_invoice_product_name_with_custom_field', 10, 2);

function get_shine_order_item_frequency($product_id, $arbid)
{
    $frequency = 0;
    $rows = get_field('define_shine_membership_plans', $product_id);
    foreach ($rows as $index => $data) {
        if ($index == $arbid) {
            $frequency = is_array($data['billingshipping_frequency'])?$data['billingshipping_frequency']['value']:$data['billingshipping_frequency'];
        }
    }

    $freq_symbol = "";
    if($frequency > 28 && $frequency < 365){
        $freq_symbol = ' /mo';
    }else{
       // $freq_symbol = '/year';
        $freq_symbol = ' /yr';
    }

    return $freq_symbol;
}