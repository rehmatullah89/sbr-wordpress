<?php
require_once('wp-load.php');

class webhook{

    const TEXT_FILE = 'authorize.txt';
    const AUTHCAPTURE_PAYMENT_CREATED = "net.authorize.payment.authcapture.created";
    const PAYMENT_AUTHORIZATION_CREATED = "net.authorize.payment.authorization.created";
    const PAYMENT_CAPTURE_CREATED = "net.authorize.payment.capture.created";
    const PRIOR_PAYMENT_CAPTURE_CREATED = "net.authorize.payment.priorAuthCapture.created";

    const SUBSCRIPTION_CANCELLED = "net.authorize.customer.subscription.cancelled";
    const SUBSCRIPTION_EXPIRED = "net.authorize.customer.subscription.expired";
    const SUBSCRIPTION_FAILED = "net.authorize.customer.subscription.failed";
    const SUBSCRIPTION_SUSPENDED = "net.authorize.customer.subscription.suspended";
    const SUBSCRIPTION_TERMINATED = "net.authorize.customer.subscription.terminated";

    public $connection;
    public $raw_get_data;
    
    function __construct(){
        global $wpdb;
        $this->connection = $wpdb;
        $this->raw_get_data = file_get_contents('php://input');
        $this->writeLogsOnTextFile($this->raw_get_data);
    }

    public function writeLogsOnTextFile($data){
        $file = fopen(self::TEXT_FILE, "a");
        fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: " . $data);
        fclose($file);
    }

    public function handleWebHook(){
      //  echo 'handle request';
        $response = json_decode($this->raw_get_data);
        if(!empty($response))
        {
            //$this->connection->insert("webhook_response", ['response' => $response]);
            if(((strpos($response->eventType, self::AUTHCAPTURE_PAYMENT_CREATED) !== false)
            || (strpos($response->eventType, self::PAYMENT_AUTHORIZATION_CREATED) !== false)
            || (strpos($response->eventType, self::PAYMENT_CAPTURE_CREATED) !== false)
            || (strpos($response->eventType, self::PRIOR_PAYMENT_CAPTURE_CREATED) !== false)) ||                 
            ((strcasecmp($response->eventType, self::AUTHCAPTURE_PAYMENT_CREATED) == 0)
            || (strcasecmp($response->eventType, self::PAYMENT_AUTHORIZATION_CREATED) == 0)
            || (strcasecmp($response->eventType, self::PAYMENT_CAPTURE_CREATED) == 0)
            || (strcasecmp($response->eventType, self::PRIOR_PAYMENT_CAPTURE_CREATED) == 0)))
            {
                if($response->payload->invoiceNumber && (strpos($response->payload->invoiceNumber, "SUBC-") !== false)){                 
                    $invoiceNumber = explode("SUBC-", $response->payload->invoiceNumber);
                    if(!empty(@$invoiceNumber[1])){
                        $this->createSubscriptionOrder($invoiceNumber[1], $response->payload->id, $response->payload->authAmount, $response, 'regular');    
                    }else{
                        $this->writeLogsOnTextFile('User is not subscribed for order item : '.$response->payload->invoiceNumber);
                    }
                }
                else if($response->payload->invoiceNumber && (strpos($response->payload->invoiceNumber, "SHINE-") !== false)){                 
                    $invoiceNumber = explode("SHINE-", $response->payload->invoiceNumber);
                    if(!empty(@$invoiceNumber[1])){
                        $this->createSubscriptionOrder($invoiceNumber[1], $response->payload->id, $response->payload->authAmount, $response, 'shine');    
                    }else{
                        $this->writeLogsOnTextFile('User is not subscribed for order item : '.$response->payload->invoiceNumber);
                    }
                }
            }elseif((strcasecmp($response->eventType, self::SUBSCRIPTION_SUSPENDED) == 0) ){
                $this->notifySuspendedStatus($response->payload->id, $response);
            }elseif((strcasecmp($response->eventType, self::SUBSCRIPTION_CANCELLED) == 0) 
            || (strcasecmp($response->eventType, self::SUBSCRIPTION_EXPIRED) == 0)
            || (strcasecmp($response->eventType, self::SUBSCRIPTION_FAILED) == 0)           
            || (strcasecmp($response->eventType, self::SUBSCRIPTION_TERMINATED) == 0))
            {
                //terminate & update subscription status in database
                if($response->payload->id){
                    $this->connection->update(
                        'sbr_subscription_details',
                        array('status' => 0),
                        array('subscription_id' =>  $response->payload->id)
                    );

                    $subscription = $this->connection->get_results("SELECT * FROM sbr_subscription_details WHERE subscription_id= ".$response->payload->id." order by id DESC LIMIT 1");
                    $this->writeLogsOnTextFile('Subscription Details Info : '.json_encode($subscription));
                    if(count($subscription) > 0){
                        $this->connection->insert('sbr_suspended_subscriptions', array(
                            'user_id' => $subscription[0]->user_id,
                            'subscription_id' => $response->payload->id,
                            'parent_order_id' => $subscription[0]->order_id,
                            'item_id' => @$subscription[0]->item_id,
                            'quantity' => @$subscription[0]->quantity,
                            'title' => $response->payload->name,
                            'amount' => $response->payload->amount,
                            'status' => 'cancelled',
                            'authorize_response' => ((string)json_encode($response))
                        )); 
                    }
                    $this->writeLogsOnTextFile('Subscription Cancelled Due To : ' . $response->eventType);
                }
            }
        }
        header("HTTP/1.1 200 OK");
    }

    public function notifySuspendedStatus($subscriptionId, $response)
    {
        $subscription = $this->connection->get_results("SELECT * FROM sbr_subscription_details WHERE subscription_id= {$subscriptionId} order by id DESC LIMIT 1");
        if(!empty($subscription)){
            $order_id = wc_get_order_id_by_order_item_id($subscription[0]->item_id);
            $order = wc_get_order($order_id);
            $user_email = $order->get_billing_email();
            $requester_id = sb_search_user_zendesk($user_email);
            $order_number = get_post_meta($order_id, 'order_number', true);

            if (empty($requester_id)) {
                $data = array(
                    'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                    'email' => $user_email,
                    'phone' => $order->get_billing_phone(),
                );
                $requester_id = sb_create_user_zendesk($data);
            }
            
            $message = '<h3>Subscription Status Set to Suspended due to Un-Successfull Charge. </h3></br>';
            $message .= '<b>Parent Order Number :</b> ' . $order_number . ' </br>';
            $message .= '<b>Reason:</b> unsuccessfull transaction from customer card. </br>';
            $message .= '<b>Customer:</b> ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' </br>';
            $message .= '<b>Customer Email:</b> ' . $user_email . ' </br>';
            $subject = ' Next Subscription Order NOT Created Due To Un-Successful Payment (Parent Order): '.$order_number;
        
            $arr = array();
            $arr['ticket'] = array(
                "subject" => $subject,
                "comment" => array(
                    "html_body" => $message,
                    "body" => $message,
                ),
                "requester_id" => $requester_id,
                "submitter_id" => SB_ZENDESK_AGENT,
                "assignee_id" => SB_ZENDESK_AGENT
            );
            $data_string = json_encode($arr);
            $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string)
                )
            );
        
            $result = curl_exec($ch);
            curl_close($ch);

            if($result){
                $user_id = get_post_meta($order_id, '_customer_user', true);
                $this->connection->insert('sbr_suspended_subscriptions', array(
                    'user_id' => $user_id,
                    'subscription_id' => $subscriptionId,
                    'parent_order_id' => $order_id,
                    'item_id' => @$subscription[0]->item_id,
                    'quantity' => @$subscription[0]->quantity,
                    'title' => $response->payload->name,
                    'amount' => $response->payload->amount,
                    'status' => 'suspended',
                    'authorize_response' => ((string)json_encode($response))
                )); 
            }
        }    
    }

    public function createSubscriptionOrder($item_id, $transaction_id, $price, $response, $plan_type)
    {
        $order_id = wc_get_order_id_by_order_item_id($item_id);        
        if ($order_id) 
        {
                $existing_order = wc_get_order($order_id);               
                // Set the new order data
                $new_order_data = array(
                    'status'        => 'processing',
                    'customer_id'   => $existing_order->get_customer_id(),
                    'payment_method' => $existing_order->get_payment_method(),
                    'payment_title' => $existing_order->get_payment_method_title(),
                    'line_items'    => array(),
                );

                if ($existing_order) 
                {                    
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
                    $new_order_id = '';
                    $new_order = wc_create_order($new_order_data);                                       
                    $item = $existing_order->get_item($item_id);  
                    if ($item) {
                        $product_id = $item->get_product_id();
                        $product = $item->get_product(); 
                        $quantity = $item->get_quantity();
                        $subtotal = $item->get_subtotal();
                        $new_item_id = $new_order->add_product($product, $quantity, array(
                            'subtotal' =>  $subtotal,
                            'total' => $subtotal,
                        ));

                        $subscriptionId =  wc_get_order_item_meta($item_id, '_subscriptionId',  true);                    
                        $arbId =  wc_get_order_item_meta($item_id, '_arbid',  true);                    
                        wc_update_order_item_meta($new_item_id, '_subscriptionId',   $subscriptionId);
                        wc_update_order_item_meta($new_item_id, '_arbid',   $arbId);

                        // Iterating through order shipping items
                        $shipping_method_title = '';
                        $shipping_method_id = '';
                        $shipping_method_instance_id = '';
                        foreach( $existing_order->get_items( 'shipping' ) as $item_id => $item ){
                            $shipping_method_title       = $item->get_method_title();
                            $shipping_method_id          = $item->get_method_id();
                            $shipping_method_instance_id = $item->get_instance_id();
                        }

                        // Set the array for tax calculations
                        $calculate_tax_for = array(
                            'country' => $existing_order->get_shipping_country(),
                            'state' => $existing_order->get_shipping_state(), // Can be set (optional)
                            'postcode' => $existing_order->get_shipping_postcode(), // Can be set (optional)
                            'city' => $existing_order->get_shipping_city(), // Can be set (optional)
                        );

                        $item_fee = new WC_Order_Item_Shipping();
                        $item_fee->set_method_title($shipping_method_title);
                        $item_fee->set_method_id($shipping_method_id); 
                        $item_fee->set_instance_id($shipping_method_instance_id); 
                        $item_fee->set_total(0); 
                        $item_fee->calculate_taxes($calculate_tax_for);
                        $new_order->add_item($item_fee);
                        $new_order_id = $new_order->get_id();                    
                        update_post_meta($new_order_id, '_order_shipping', 0);
                    }      
                    
                    $new_order->add_order_note('Parent Order Info:'.$order_id. ' & Item Id:'.$item_id);
                    $new_order->set_address($billing_address, 'billing');
                    $new_order->set_address($shipping_address, 'shipping');
                    $new_order->set_created_via('Subscriptions');
                    $new_order->calculate_totals();
                    $new_order->update_meta_data('_subscriptionId', $subscriptionId);                    
                    $new_order->update_meta_data('_payment_method', get_post_meta($order_id, '_payment_method', true));
                    $new_order->update_meta_data('_payment_method_title', get_post_meta($order_id, '_payment_method_title', true));
                    $new_order->update_meta_data('_wc_authorize_net_cim_credit_card_card_type', get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_card_type', true));
                    $new_order->update_meta_data('_wc_authorize_net_cim_credit_card_account_four', get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_account_four', true));
                    $new_order->update_meta_data('_transaction_id', $transaction_id);
                    $new_order->update_meta_data('_pip_invoice_number', $new_order_id);

                    $new_order->save();
                    smile_brillaint_set_sequential_order_number($new_order_id);
                    smile_brillaint_get_sequential_order_number($new_order_id);
                    // Check if the new order was created successfully
                    if (!empty($new_order_id)) {
                        // update subscription history
                        $user_id = get_post_meta($order_id, '_customer_user', true);
                        $transaction = $this->connection->get_results("SELECT * FROM sbr_subscription_details WHERE subscription_id= $subscriptionId order by id DESC LIMIT 1");
                        
                        $this->connection->insert('sbr_subscription_details', array(
                            'user_id' => $user_id,
                            'subscription_id' => $subscriptionId,
                            'transaction_id' => $transaction_id,
                            'order_id' => $new_order_id,
                            'item_id' => $new_item_id,
                            'product_id' => $product_id,
                            'total_price' => $price,
                            'status' => 1,
                            'quantity' => $quantity,
                            'subscription_date' => date('Y-m-d H:i:s'),
                            'interval_days' => $transaction[0]->interval_days,
                            'next_order_date' => date('Y-m-d', strtotime(date('Y-m-d'). " + {$transaction[0]->interval_days} days")),
                            'authorize_response' => ((string)json_encode($response)),
                            'shine_group_code' => @$transaction[0]->shine_group_code
                        ));                        

                        if (get_post_meta($order_id, 'gehaOrder', true) == 'yes')
                            update_post_meta($new_order_id, 'gehaOrder', 'yes');

                        //mark order as good to ship
                        mbt_goodToShip($new_order_id);
                        update_post_meta($new_order_id, 'updateByGTS', 2);

//                        add_post_meta( $new_order_id, '_subscriptionId', $subscriptionId);  
                        $this->writeLogsOnTextFile('New order created with ID: ' . $new_order_id);
                    } else {
                        // Output an error message
                        $this->writeLogsOnTextFile('Error creating new order against: '.$order_id);
                    }
                }
        } else {
                $this->writeLogsOnTextFile('No Order found against id: '.$order_id);
        }
    }
    
}

$webhook = new webhook();
$webhook->handleWebHook();

header("HTTP/1.1 200 OK");

?>