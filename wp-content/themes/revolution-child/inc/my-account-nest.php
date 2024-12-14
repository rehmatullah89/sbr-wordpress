<?php

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'custom-orders', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'get_custom_orders',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'customer-orders', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'get_customer_orders',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'customer-order', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'get_customer_order',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'customer-subscriptions', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'get_customer_subscriptions',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'custom-customers', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'get_custom_customers',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'login-customer', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_login',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'update-customer', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_customer_update',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'update-customer-social', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_customer_update_social',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'change-password', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_change_password',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'cancel-order', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_cancel_order',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'cancel-order-subscriptions', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_cancel_order_subscriptions',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'track-order-item', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_track_order_item',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'review-order-item', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_review_order_item',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'replace-return-order', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_replace_return_order',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'order-invoice', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_download_order_invoice',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'register-reward-user', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_register_reward_user',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'cancel-order-item-subscription', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_cancel_item_subscription',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'user-shipping-addresses', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_shipping_addresses',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'update-shipping-address', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_update_shipping_address',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'default-shipping-address', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_default_shipping_address',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'remove-shipping-address', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_remove_shipping_address',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'user-billing-methods', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_billing_methods',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'user-support-messages', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_support_messages',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'user-create-ticket', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_create_ticket',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'user-ticket-status', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_ticket_status',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'register-user', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_register',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'reset-password', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_reset_password',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'jwt-auth', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_jwt',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'shipping-countries-states', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_shipping_countries_states',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'default-billing-method', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_default_billing_method',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'delete-billing-method', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_delete_billing_method',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'affiliate-user', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_affiliate_user',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'affiliate-settings', array(
        'methods' => 'POST', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_affiliate_settings',
        'permission_callback' => '__return_true',
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v3', 'get-customer', array(
        'methods' => 'GET', // array( 'GET', 'POST', 'PUT', )
        'callback' => 'handle_user_data',
        'permission_callback' => '__return_true',
    ));
});

function get_custom_customers( $request ) {

    global $wpdb, $woocommerce;
    $customer_query = new WP_User_Query(
        array(
            'offset' => (@$request['offset'] != 0? @$request['offset'] +1:0),
            'number' => $request['limit'],
            'orderby' => 'id',
            'order' => 'ASC',
            'role' => 'customer',
            'fields' => 'ID',
        ));
    
    $customer_list = [];
    foreach ( $customer_query->get_results() as $customer_id ) {
        $customer_list[] = get_customer_data($customer_id);
    }

    return $customer_list;
}

function get_customer_subscriptions( $request ) {
    global $wpdb;
    $subscriptionInfo = $wpdb->get_results("SELECT DISTINCT order_id FROM sbr_subscription_details  WHERE user_id = ". @$request['customer_id'] ." Group By subscription_id");    

    $order_list = [];
    foreach($subscriptionInfo as $subscription){
        array_push($order_list, get_order_data($subscription->order_id));
    }

    return $order_list;
}

function get_customer_orders( $request ) {
    $args = array(
        'post_type'      => 'shop_order', // WooCommerce orders
        'post_status' => 'any', //array( 'wc-completed', 'wc-processing', 'wc-on-hold', 'wc-cancelled', 'wc-partial_ship', 'wc-partial-refunded', 'wc-pending', 'wc-refunded', 'wc-shipped', 'draft'),
        'posts_per_page' => -1, // Get all orders
        'meta_query'     => array(
            array(
                'key'     => '_customer_user',
                'value'   => @$request['customer_id'],
                'compare' => '=',
            ),
        ),
        'fields'         => 'ids', // Only retrieve post IDs to reduce overhead
    );    
    $orders_query = new WP_Query( $args );

    $order_list = [];
    if ( $orders_query->have_posts() ) {
        while ( $orders_query->have_posts() ) {
            $orders_query->the_post();
            array_push($order_list, get_order_data(get_the_ID()));
        }
        wp_reset_postdata();
    } 
    return $order_list;
}

function get_customer_order( $request ) {
    
    return [get_order_data(@$request['id'])];
}

function get_customer_data($customer_id)
{
        global $wpdb;
        $customer = new WC_Customer( $customer_id );

        $affiliate = $wpdb->get_row("SELECT * FROM  wp_affiliate_wp_affiliates where user_id = $customer_id");
        $subscription = $wpdb->get_row("SELECT * FROM  sbr_subscription_details where user_id = $customer_id");

        $is_affiliate = false;
        if($affiliate && $affiliate->status == 'active'){
            $is_affiliate = true;
        }

        $is_subscribed = false;
        if($subscription && !empty($subscription)){
            $is_subscribed = true;
        }

       $user_data = Array( "id" => $customer_id,
        "is_affiliate_user" => $is_affiliate,
        "is_subscribed_user" => $is_subscribed,
        "date_created" => $customer->get_date_created(),
        "date_modified" => $customer->get_date_modified(),
        "email" => $customer->get_email(),
        "first_name" => $customer->get_first_name(),
        "last_name" => $customer->get_last_name(),
        "role" => $customer->get_role(),
        "username" => $customer->get_username(),
        "display_name" => $customer->get_display_name());

       $user_data['billing'] = array('first_name'=>$customer->get_billing_first_name(),
        'last_name'=>$customer->get_billing_last_name(),
        'company'=>$customer->get_billing_company(),
        'address_1'=>$customer->get_billing_address_1(),
        'address_2'=>$customer->get_billing_address_2(),
        'city'=>$customer->get_billing_city(),
        'state'=>$customer->get_billing_state(),
        'postcode'=>$customer->get_billing_postcode(),
        'country'=>$customer->get_billing_country(),
        'email'=>$customer->get_billing_email(),
        'phone'=>$customer->get_billing_phone(),
      );

      $user_data['shipping'] = array('first_name'=>$customer->get_shipping_first_name(),
        'last_name'=>$customer->get_shipping_last_name(),
        'company'=>$customer->get_shipping_company(),
        'address_1'=>$customer->get_shipping_address_1(),
        'address_2'=>$customer->get_shipping_address_2(),
        'city'=>$customer->get_shipping_city(),
        'state'=>$customer->get_shipping_state(),
        'postcode'=>$customer->get_shipping_postcode(),
        'country'=>$customer->get_shipping_country(),
        'phone'=>$customer->get_shipping_phone(),
      ) ;

      $user_data['is_paying_customer'] = $customer->get_is_paying_customer();
      $user_data['avatar_url'] = $customer->get_avatar_url();

      $meta_data = [];
      foreach($customer->get_meta_data() as $meta){
        $meta_data[@$meta->key] = @$meta->value;
      }
      $user_data['meta_data'] = $meta_data;

      return $user_data;
}

function get_custom_orders( $request ) {   
    $query = new WC_Order_Query( array(
        'offset' => (@$request['offset'] != 0? @$request['offset'] +1:0),
        'limit' => $request['limit'],
        'orderby' => 'id',
        'order' => 'ASC',
        'return' => 'ids',
    ) );
    $orders = $query->get_orders();

    $order_list = [];    
    foreach($orders as $order_id){
        $order_data = get_order_data($order_id);
        array_push($order_list, $order_data);
    }

    return $order_list;
}

function get_order_data($order_id){
    global $wpdb;
    $subscription_order = 0;
    $subscription_orders = [];
    $order = wc_get_order($order_id);

    $order_data = [];
    if($order)
    {
        $order_data = $order->get_data();        
        $meta_data = [];
        foreach($order_data['meta_data'] as $meta){
            $meta_data[@$meta->key] = @$meta->value;
        }
        $order_data['meta_data'] = $meta_data;
        $order_data['shipping_method'] = $order->get_shipping_to_display();

        $items = [];
        $subscription_order = get_post_meta($order_id, '_subscriptionId', true);
        foreach ($order->get_items() as $item_id => $item ) {
                        
            $product_id = $item->get_product_id();
            $product = wc_get_product($product_id);
            $image = $product->get_image();

            $q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
            $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
            $q1 .= " WHERE item_id = " . $item_id . " AND product_id = ".$product_id ;
            $q1 .= " ORDER BY log_id DESC LIMIT 1";
            $logEntry = $wpdb->get_row($q1, 'ARRAY_A');

            $status_title = 'Preparation';
            if (isset($logEntry['event_id']) && $logEntry['event_id'] > 0) {
                $event_id = $logEntry['event_id'];
                $status_title = $logEntry['status'];
            }

            $filled = 1;
            if (in_array($event_id, [1, 2, 3, 5, 6, 7, 8, 16])) {
                if ($event_id == 16) {
                    $filled = 6;
                }elseif (in_array($event_id, array(7, 8))) {
                    $filled = 4;
                }elseif ($order->get_status() == 'shipped') {
                    $filled = 7;

                    if($status_title == 'Preparation')
                        $status_title = 'shipped';
                }                   
            }

            $itemData = $wpdb->get_row("SELECT tray_number , created_date FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id");
            $tray_number = isset($itemData->tray_number) ? $itemData->tray_number : '';

            $tray_price = "";
            $tray_price3mm = "";
            if($tray_number>0)
            {
                $night_guard_reorder_product = 739363;
                $night_guard_reorder_product_3mm = 795483;
                $tray_price = get_post_meta($night_guard_reorder_product, 'any_whitening_system', true);
                $tray_price3mm = 0;
                $producttitle = get_the_title($product_id);

                if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (Deluxe)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm) (Deluxe)') {
                    $key = '1_nightguards_package';
                    $key3mm = '1_nightguards_package_3mm';
                    $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                    $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
                } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {
                    $key3mm = '2_nightguards_package_3mm';
                    $key = '2_nightguards_package';

                    $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                    $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
                } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {

                    $key3mm = '4_nightguards_package_3mm';
                    $key = '4_nightguards_package';

                    $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                    $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
                }
            }

            if($subscription_order){
                /*$dataObject = '{
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
                    $transaction_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_trans_id', true);                    
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
                }*/
                $subscriptionId =  wc_get_order_item_meta($item_id, '_subscriptionId',  true);             
                if($subscriptionId){                    
                    $subscription_details = $wpdb->get_results("SELECT * FROM sbr_subscription_details WHERE subscription_id = $subscriptionId ORDER BY id DESC", ARRAY_A);
                    foreach ($subscription_details as $key => $detail){                                              
						$subscription_details[$key]['order_number'] = get_post_meta($detail['order_id'], '_order_number_formatted', true);
                    }

                    $subscription_orders[] = $subscription_details;
                    $items[] = array_merge($item->get_data(), ["status_title"=>$status_title, "progress"=>$filled, 'tray_number'=>$tray_number, 'subscription_details'=>$subscription_details, 'tray_price2mm'=>$tray_price, 'tray_price3mm'=>$tray_price3mm, 'image_url'=>wp_get_attachment_url($product->get_image_id())]);
                }                    
            }else{
                $items[] = array_merge($item->get_data(), ["status_title"=>$status_title, "progress"=>$filled, 'tray_number'=>$tray_number, 'tray_price2mm'=>$tray_price, 'tray_price3mm'=>$tray_price3mm, 'image_url'=>wp_get_attachment_url($product->get_image_id())]);
            }

        }
        $order_data['line_items'] = $items;
        $order_data['order_notes'] = get_private_order_notes($order_id);        
        $order_data['easy_post_data'] = $wpdb->get_results("SELECT ses.* FROM sb_easypost_shipments ses, sbr_shipment_orders sso WHERE sso.shipment_id=ses.shipment_id AND sso.order_id={$order_id}");
        $order_data['subscription_orders'] = $subscription_orders;
    }

    return $order_data;
}

function get_private_order_notes( $order_id){
    global $wpdb;

    $table_perfixed = $wpdb->prefix . 'comments';
    $results = $wpdb->get_results("
        SELECT *
        FROM $table_perfixed
        WHERE  `comment_post_ID` = $order_id
        AND  `comment_type` LIKE  'order_note'
    ");

    foreach($results as $note){
        $order_note[]  = array(
            'note_id'      => $note->comment_ID,
            'note_date'    => $note->comment_date,
            'note_author'  => $note->comment_author,
            'note_content' => $note->comment_content,
        );
    }
    return $order_note;
}

function handle_user_data(WP_REST_Request $request ) {
    global $wpdb;
    $user_id = $request->get_param( 'id' );
    
    if ( $user_id > 0 ) {
        return get_customer_data($user_id);
        die();
    }

    return new WP_Error( "Invalid Input data for user:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_affiliate_settings(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $payment_email = $request->get_param('payment_email');
    $recommended = $request->get_param('rdh_recommended_url');
    
    if($user_id>0) {        
        if($payment_email != ""){
            $wpdb->update('wp_affiliate_wp_affiliates', array('payment_email'=>$payment_email), array('user_id'=>$user_id));
        }
        if($recommended != ""){
            update_user_meta($user_id,'rdh_recommended_url',$recommended);
        }
        //trigger_customer_update_api($user_id);
        return new WP_REST_Response(['user_id'=>$user_id, 'status'=>true], 200);
        die();
    }
    
    return new WP_Error( "Invalid Input data for user:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_affiliate_user(WP_REST_Request $request ) {
    global $wpdb;
    $user_id = $request->get_param( 'user_id' );
    
    if ( $user_id > 0 ) {
        
        $affiliate = $wpdb->get_row("SELECT * FROM  wp_affiliate_wp_affiliates where user_id = $user_id");

        if($affiliate && $affiliate->status == 'pending')
            return new WP_REST_Response( ['message'=>'User is In-active, please contact admin.', 'status'=>true], 200 );

        if($affiliate && $affiliate->status == 'active'){
            $unpaid_referrals = $wpdb->get_row("SELECT count(*) as count FROM wp_affiliate_wp_referrals where status = 'unpaid' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $paid_referrals = $wpdb->get_row("SELECT count(*) as count FROM wp_affiliate_wp_referrals where status = 'paid' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $unpaid_earnings = $wpdb->get_row("SELECT SUM(amount) as amount FROM wp_affiliate_wp_referrals where status = 'unpaid' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $paid_earnings = $wpdb->get_row("SELECT SUM(amount) as amount FROM wp_affiliate_wp_referrals where status = 'paid' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $pending_earnings = $wpdb->get_row("SELECT SUM(amount) as amount FROM wp_affiliate_wp_referrals where status = 'pending' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $rejected_earnings = $wpdb->get_row("SELECT SUM(amount) as amount FROM wp_affiliate_wp_referrals where status = 'rejected' AND affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $graph_earnings = $wpdb->get_results("SELECT `status`, amount FROM wp_affiliate_wp_referrals where affiliate_id = ".$affiliate->affiliate_id." AND `date` >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND `date` <= LAST_DAY(CURDATE())");
            $campaigns = $wpdb->get_row("SELECT COUNT(*) as total, SUM(visits) as visits, SUM(unique_visits) as u_visits, SUM(referrals) as converted, conversion_rate FROM wp_affiliate_wp_campaigns where affiliate_id = ".$affiliate->affiliate_id." GROUP BY affiliate_id");
            $references = $wpdb->get_results("SELECT referral_id, `status`, amount, `description`, `date` FROM wp_affiliate_wp_referrals where affiliate_id = ".$affiliate->affiliate_id." ");
            $payouts = $wpdb->get_results("SELECT payout_method, `status`, amount, `date` FROM wp_affiliate_wp_payouts where affiliate_id = ".$affiliate->affiliate_id." ");
            $visits= $wpdb->get_results("SELECT `url`, referrer, referral_id, `date` FROM wp_affiliate_wp_visits where affiliate_id = ".$affiliate->affiliate_id." ");

            $response = array(
                'status'=>true,
                'affiliate_id'=>$affiliate->affiliate_id,
                'affiliate_visits'=>$affiliate->visits,
                'affiliate_url'=>"/?ref=".$affiliate->affiliate_id,
                'affiliate_rate'=>affwp_get_affiliate_conversion_rate( $affiliate->affiliate_id ),
                'affiliate_comission'=>affwp_get_affiliate_rate( $affiliate->affiliate_id, true ),
                'affiliate_type'=>$affiliate->rate_type,
                'unpaid_referrals'=>(int)@$unpaid_referrals->count,
                'paid_referrals'=>(int)@$paid_referrals->count,
                'unpaid_earnings'=>(float)@$unpaid_earnings->amount,
                'paid_earnings'=>(float)@$paid_earnings->amount,
                'pending_earnings'=>(float)@$pending_earnings->amount,
                'rejected_earnings'=>(float)@$rejected_earnings->amount,
                'graph_earnings'=>$graph_earnings,
                'campaigns'=>(int)@$campaigns->total,
                'campaign_visits'=>(int)@$campaigns->visits,
                'campaign_unique_visits'=>(int)@$campaigns->u_visits,
                'campaign_converted'=>(int)@$campaigns->converted,
                'campaign_rate'=>(int)@$campaigns->conversion_rate,
                'reference_report'=>$references,
                'payouts_report'=>$payouts,
                'visits_report'=>$visits,

            );
            return new WP_REST_Response( $response, 200 );
        }    

    } 

    return new WP_Error( "Invalid Input data for user:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_delete_billing_method(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $token_id = absint($request->get_param('card_id'));
    $token    = WC_Payment_Tokens::get( $token_id );

    if($user_id>0 && $token && $user_id == $token->get_user_id()) {        
        //WC_Payment_Tokens::delete( $token_id );    
        //trigger_customer_update_api($user_id);    
        return new WP_REST_Response(['user_id'=>$user_id, 'status'=>true], 200);
        die();
    }
    
    return new WP_Error( "Invalid Input data for user:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_default_billing_method(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $token_id = absint($request->get_param('card_id'));
    $token    = WC_Payment_Tokens::get( $token_id );

    if($user_id>0 && $token && $user_id == $token->get_user_id()) {
        
        WC_Payment_Tokens::set_users_default( $token->get_user_id(), intval( $token_id ) );
        //trigger_customer_update_api($user_id);
        return new WP_REST_Response(['user_id'=>$user_id, 'status'=>true], 200);
        die();
    }
    
    return new WP_Error( "Invalid Input data for user:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_shipping_countries_states(WP_REST_Request $request ) {
    $selected_country = $request->get_param( 'country' );
    $countries = WC()->countries->get_shipping_countries();
    
    // Check if the selected country is in the list of shipping countries
    if ( isset( $countries[ $selected_country ] ) ) {
        $states = WC()->countries->get_states( $selected_country );
        $response = array(
            'country' => $selected_country,
            'states' => $states,
        );
        return new WP_REST_Response( $response, 200 );
    } else {
        $response = array(
            'country' => $countries,
        );
        return new WP_REST_Response( $response, 200 );
    }
}

function handle_user_jwt(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $jwt_token = $request->get_param('jwt_token');

    if($user_id>0 && $jwt_token) {
        update_user_meta( $user_id, 'jwt_token', $jwt_token);
        //trigger_customer_update_api($user_id);
        return new WP_REST_Response(['user_id'=>$user_id, 'status'=>true], 200);
        die();
    }
    
    return new WP_Error( "Invalid data Input:".$user_id, array( 'status' => 400 ) );    
    exit();
}

function handle_reset_password(WP_REST_Request $request)
{
    $user_login = $request->get_param('user_login');
    $user = get_user_by('email', $user_login);
    if (!$user) {
        return new WP_Error('user_not_found', 'User not found', array('status' => 404));
    }

    // Generate password reset key
    $key = get_password_reset_key($user);
    if (is_wp_error($key)) {
        return new WP_Error('password_reset_error', $key->get_error_message(), array('status' => 500));
    }

    // Send email with password reset link
    $reset_link = '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . '>';
    $message = "Hello $user->user_login,\n\n";
    $message .= "You have requested to reset your password. Please click on the following link to reset your password:\n";
    $message .= $reset_link . "\n\n";
    $message .= "If you did not request this, please ignore this email.\n";

    //$sent = wp_mail($user->user_email, 'Password Reset Request', $message);
    $sent = mail($user->user_email, 'Password Reset Request', $message);

    if (!$sent) {
        return new WP_Error('email_send_error', 'Failed to send reset email', array('status' => 500));
    }

    return new WP_REST_Response(['msg'=>'Password reset email sent.', 'code'=>200], 200);
}

function handle_user_register(WP_REST_Request $request)
{
    $send_user_email = true;
    $email = $request->get_param('email');
    
    if ( $email ) 
    {
        $maybe_user = get_user_by( 'email', $email );
        if ( $maybe_user instanceof WP_User ) {
            return new WP_Error( "User Already Exist:".$maybe_user->ID, array( 'status' => 500 ) );    
        }

        $username = sanitize_user( current( explode( '@', $email ) ), true );
        $append     = 1;
        $o_username = $username;
        while ( username_exists( $username ) ) {
            $username = $o_username . $append;
            ++ $append;
        }

        $password = wp_generate_password();
        $errors = new WP_Error();

        do_action( 'woocommerce_register_post', $username, $email, $errors );
        $new_customer_data = apply_filters( 'woocommerce_new_customer_data', array(
            'user_login' => $username,
            'user_pass'  => $password,
            'user_email' => $email,
            'role'       => 'customer',
        ) );

        $customer_id = wp_insert_user( $new_customer_data );
        if ( is_wp_error( $customer_id ) ) {
            return new WP_Error( "Register Error for User:".$customer_id, array( 'status' => 500 ) );    
        }

        do_action( 'woocommerce_created_customer', $customer_id, $new_customer_data, true );

        if ($send_user_email == 'yes') {
            $emails = WC()->mailer()->get_emails();
            $emails['WC_Email_Customer_New_Account']->trigger($customer_id, $password, true);
        }

        return new WP_REST_Response(['id'=>$customer_id, 'email'=>$email, 'user_login'=>$username, 'role'=>'customer'], 200);
        exit();    
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_user_create_ticket(WP_REST_Request $request)
{
    global $wpdb;

    $attachments = "";
    if (!empty($_FILES["attachment"]["name"])) {
        // File path config 
        $fileName = sanitize_file_name($_FILES["attachment"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        // Allow certain file formats 
        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        $imageTag = '';
        if (in_array($fileType, $allowTypes)) {

            if ($_FILES['attachment']['size'] < 3145728) {
                try{
                    // Upload file to the server
                    $imagedata = file_get_contents($_FILES['attachment']['tmp_name']);
                    $contentType = $_FILES['attachment']['type'];
                    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/uploads/?filename=' . $fileName;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $imagedata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: ' . $contentType . '',
                        )
                    );
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $results = json_decode($result, true);
                    if (isset($results['upload']['token'])) {
                        $uploadStatus = 1;
                        $message = $fileName . ' - attachment uploaded.';
                        $attachments = $results['upload']['token'];
                    }
                }catch(Exception $e){
                    //do nothing
                }
            }
        }
    }
    /////Upload image done//////
    $responseData = array();
    $user_id = $request->get_param('user_id');     
    $user_info = get_userdata( $user_id );

    if ( $user_info ) {
        $user_email = $user_info->user_email;
        $requester_id = sb_search_user_zendesk($user_email);
        if ($requester_id) {
        } else {
            $data = array(
                'name' =>  $user_info->user_login,
                'email' => $user_email,
            );
            $requester_id = sb_create_user_zendesk($data);
        }
    }

    $messagess = $request->get_param('message');
    $message = str_replace("&nbsp;", "", $messagess);
    $message = str_replace("\\", "", $message);
    $medium = $request->get_param('medium')? $request->get_param('medium') : 'email';
    //$attachments = $request->get_param('tokenAttachment')? $request->get_param('tokenAttachment') : array();
    $ticket_id = $request->get_param('ticket_id') ? $request->get_param('ticket_id') : 0;
    $type = $request->get_param('type')? $request->get_param('type') : 'general_inquiry';

    if ($requester_id && $message != '') 
    {
        if ($ticket_id > 0) {
            try{
                $arr = array();
                $arr['ticket'] = array(
                    "status" => 'open',
                    "comment" => array(
                        "html_body" => force_balance_tags($message),
                        "uploads" => $attachments,
                        "author_id" => $requester_id,
                    ),
                    "custom_fields" => array(
                        array(
                            "id" => 4417382819865,
                            "value" => $medium,
                        ),
                    ),
                );
                $data_string = json_encode($arr);
                $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                    )
                );

                $result = curl_exec($ch);
                curl_close($ch);
                $results = json_decode($result, true);
                if (isset($results['ticket']['id']) && $results['ticket']['id'] > 0) {
                    $ticketInfo = sb_ticket_comments_zendesk($results['ticket']['id']);
                    if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                        $responseData['status'] = 'success';
                    } else {
                        $responseData['status'] = 'success';
                    }
                    $responseData['message'] = $ticketInfo['html'];
                    return new WP_REST_Response(($responseData), 200);
                    die();
                } else {
                    $responseData['status'] = 'error';
                    $responseData['message'] = 'Unable to add comment.';
                    return new WP_REST_Response(($responseData), 200);
                    die();
                }
            }catch(Exception $e){
                //do nothing
            }
        } else {
            try{
                $subject = ucwords(str_replace("_", " ", $type));
                $arr = array();
                $arr['ticket'] = array(
                    "subject" => $subject,
                    "comment" => array(
                        "html_body" => force_balance_tags($message),
                        "uploads" => $attachments,
                        "author_id" => $requester_id,
                    ),
                    "priority" => 'normal',
                    "assignee_id" => SB_ZENDESK_AGENT,
                    "requester_id" => $requester_id,
                    "submitter_id" => $requester_id,
                    "custom_fields" => array(
                        array(
                            "id" => 4417382819865,
                            "value" => $medium,
                        ),
                        array(
                            "id" => 900010956323,
                            "value" => $type,
                        ),
                    ),
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
                        'Content-Length: ' . strlen($data_string),
                    )
                );

                $result = curl_exec($ch);
                $ticket_created = json_decode($result, true);
                curl_close($ch);
                if (isset($ticket_created['ticket']['id']) && $ticket_created['ticket']['id'] != '') {
                    $ticketInfo = sb_ticket_comments_zendesk($ticket_created['ticket']['id']);
                    if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                        $responseData['status'] = 'success';
                    } else {
                        $responseData['status'] = 'success';
                    }
                    $responseData['message'] = $ticketInfo['html'];
                    return new WP_REST_Response(($responseData), 200);
                    die();
                } else {
                    $responseData['status'] = 'error';
                    $responseData['message'] = 'Unable to add comment.';
                    return new WP_REST_Response(($responseData), 200);
                    die();
                }
            }catch(Exception $e){
                //do nothing
            }
            
        }       
    }
    
    $responseData['status'] = 'error';
    $responseData['message'] = 'unable to add comment. Message Empty';
    return new WP_Error( ($responseData), array( 'status' => 500 ) );    
    exit();
}

function handle_user_support_messages(WP_REST_Request $request)
{
    if(isset($request['user_id'])){
        try{
            $user_email = get_user_meta($request['user_id'], 'billing_email', true);
            $zendesk_user_id = sb_search_user_zendesk($user_email);
            $url = "https://" . MBT_ZENDESK_HOST . ".zendesk.com/api/v2/users/$zendesk_user_id/tickets/requested";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($result, true);
            return new WP_REST_Response(array_merge(['status'=>true],$data), 200);
        }catch(Exception $e){
            return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
        }
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_user_billing_methods(WP_REST_Request $request)
{
    if(isset($request['user_id'])){
        $saved_methods = wc_get_customer_saved_methods_list($request['user_id']);
        return new WP_REST_Response($saved_methods, 200);
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_remove_shipping_address(WP_REST_Request $request)
{
    global $wpdb;
    $address_id = $request->get_param('address_id');

    if($address_id>0) {
        $shipping_address_table = $wpdb->prefix . 'customer_shipping_addresses';
        $wpdb->delete( $shipping_address_table, array( 'id' => $address_id ) );

        return new WP_REST_Response(['address_id'=>$address_id, 'deleted'=>true], 200);
        die();
    }
    
    return new WP_Error( "Invalid data Input:".$address_id, array( 'status' => 500 ) );    
    exit();
}

function handle_default_shipping_address(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $address_id = $request->get_param('address_id');

    if($address_id && $user_id) {
        $shipping_address_table = $wpdb->prefix . 'customer_shipping_addresses';        
        $wpdb->update($shipping_address_table, array('is_default'=>0), array('is_default'=>1,'user_id'=>$user_id));
        $wpdb->update($shipping_address_table, array('is_default'=>1), array('id'=>$address_id));
        //trigger_customer_update_api($user_id);

        return new WP_REST_Response(['user_id'=>$user_id,'address_id'=>$address_id,'is_default'=>true], 200);
    }
    
    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_update_shipping_address(WP_REST_Request $request)
{
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $address_id = $request->get_param('address_id');
    $first_name = sanitize_text_field($request->get_param('shipping_first_name'));
    $last_name = sanitize_text_field($request->get_param('shipping_last_name'));
    $address_1 = sanitize_text_field($request->get_param('shipping_address_1'));
    $address_2 = sanitize_text_field($request->get_param('shipping_address_2'));
    $city = sanitize_text_field($request->get_param('shipping_city'));
    $state = sanitize_text_field($request->get_param('shipping_state'));
    $postcode = sanitize_text_field($request->get_param('shipping_postcode'));
    $country = sanitize_text_field($request->get_param('shipping_country'));

    if ($user_id && $first_name && $last_name && $address_1 && $city && $state && $postcode && $country && isset($address_id)) {
        $shipping_address_table = $wpdb->prefix . 'customer_shipping_addresses';
        
        if($address_id > 0){
            $wpdb->update($shipping_address_table, array(
                'user_id' => $user_id,
                'shipping_first_name' => $first_name,
                'shipping_last_name' => $last_name,
                'shipping_address_1' => $address_1,
                'shipping_address_2' => $address_2,
                'shipping_city' => $city,
                'shipping_state' => $state,
                'shipping_postcode' => $postcode,
                'shipping_country' => $country,
                'extra_info' => array(),
            ),  
            array('id'=>sanitize_text_field($address_id)));
        }else{
            $wpdb->insert($shipping_address_table, array(
                'is_default' => 0,
                'user_id' => $user_id,
                'shipping_first_name' => $first_name,
                'shipping_last_name' => $last_name,
                'shipping_address_1' => $address_1,
                'shipping_address_2' => $address_2,
                'shipping_city' => $city,
                'shipping_state' => $state,
                'shipping_postcode' => $postcode,
                'shipping_country' => $country,
                'extra_info' => array(),
            ));
        }
        //trigger_customer_update_api($user_id);
        
        return new WP_REST_Response(array(
            'user_id' => $user_id,
            'shipping_first_name' => $first_name,
            'shipping_last_name' => $last_name,
            'shipping_address_1' => $address_1,
            'shipping_address_2' => $address_2,
            'shipping_city' => $city,
            'shipping_state' => $state,
            'shipping_postcode' => $postcode,
            'shipping_country' => $country,
        ), 200);
    }
    
    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_user_shipping_addresses(WP_REST_Request $request)
{
    if(isset($request['user_id'])){
        $myaddresses = current_user_shipping_addresses($request['user_id']);                  
        return new WP_REST_Response($myaddresses, 200);
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_cancel_item_subscription(WP_REST_Request $request)
{
    global $wpdb;
    $item_id = $request->get_param('item_id');
    $subscription_id = $request->get_param('subscription_id');
    
    if ($item_id && $subscription_id) {
        $data = '{
            "ARBCancelSubscriptionRequest": {
              "merchantAuthentication": {
                "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                    "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
              },
              "refId": "' . $item_id . '",
              "subscriptionId": "' . $subscription_id . '",
            }
          }';
    
        try{
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
        }catch(Exception $e){
            //do nothing
        }
    
        if ($responseAPI) {
            $wpdb->update(
                'sbr_subscription_details',
                array('status' => 0),
                array('subscription_id' => $subscription_id, 'item_id' => $item_id)
            );

            $subcDetail = $wpdb->get_row("SELECT * FROM sbr_subscription_details WHERE subscription_id=" . $subscription_id." AND item_id=".$item_id);
            $wpdb->insert('sbr_suspended_subscriptions', array(
                'user_id' => $subcDetail->user_id,
                'subscription_id' => $subscription_id,
                'parent_order_id' => $subcDetail->order_id,
                'item_id' => $item_id,
                'quantity' => $subcDetail->quantity,
                'title' => $subcDetail->id,
                'amount' => $subcDetail->amount,
                'status' => 'suspended',
                'authorize_response' => ((string)json_encode($response))
            )); 
        }
        //triggerReplaceOrderObject($subcDetail->order_id);
        return new WP_REST_Response('success', 200);
        die;
    }
    
    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_download_order_invoice(WP_REST_Request $request)
{
    if(isset($request['id'])){
        $order = wc_get_order($request['id']);
     
        $customer_id = $order->get_customer_id();
        if ($customer_id) {
            $user = get_user_by('id', $customer_id);
            if ($user) {
                // wp_clear_auth_cookie();
                // wp_set_current_user($user->ID);
                // wp_set_auth_cookie($user->ID);
                $user = get_user_by('id', $customer_id);
                wp_set_current_user($customer_id, $user->user_login);
                wp_set_auth_cookie($customer_id);
            }
        }

        $nonce = wp_create_nonce('wc_pip_print');

        // Construct the URL using add_query_arg
        $invoice_link = add_query_arg(
            array(
                'wc_pip_action' => 'print',
                'wc_pip_document' => 'invoice',
                'order_id' => $order->get_id(),
                '_wpnonce' => $nonce
            ),
            site_url('/my-account/orders/')
        );
        return $invoice_link;
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_register_reward_user(WP_REST_Request $request)
{
    $user_id = $request->get_param('affwp_user_id');
    $user_name = $request->get_param('affwp_user_name');
    $user_login = $request->get_param('affwp_user_login');
    $user_pass = $request->get_param('affwp_user_pass');
    $user_email = $request->get_param('affwp_user_email');
    $payment_email = $request->get_param('affwp_payment_email');
    $user_url = $request->get_param('affwp_user_url');
    $promotion_method = $request->get_param('affwp_promotion_method');
    
    if ($user_name && $user_login && $user_email && $user_url) {        
		if ( ! empty( $user_name ) ) {
			$name       = explode( ' ', sanitize_text_field( $user_name ) );
			$user_first = array_shift( $name );
			$user_last = count( $name ) ? implode( ' ', $name ) : '';
		} else {
			$user_first = '';
			$user_last  = '';
		}

        if($user_id > 0){
            /****** Existing User  ********/
            $new_user = false;
			$user    = (array) get_userdata( $user_id );

			if ( isset( $user['data'] ) ) {
				$args = (array) $user['data'];
			} else {
				$args = array();
			}

            wp_update_user( array(
                'ID'         => $user_id,
                'first_name' => $user_first,
                'last_name'  => $user_last
            ) );

        }else{
            /****** New User  ********/
            // Start with a random password.
            $user_pass = wp_generate_password( 24 );
            if ( isset( $user_pass ) ) {
                $user_pass = sanitize_text_field( $user_pass );
            }

            $user_login = isset( $user_login ) ? sanitize_text_field( $user_login ) : $user_email;

			$args = array(
				'user_login'    => $user_login,
				'user_email'    => $user_email,
				'user_pass'     => $user_pass,
				'display_name'  => trim( $user_first . ' ' . $user_last ),
			);

			$new_user = true;
			$user_id = wp_insert_user( $args );
			update_user_meta( $user_id, 'affwp_referral_notifications', true );
        }

        // website URL
		$website_url = isset( $user_url ) ? sanitize_text_field( $user_url ) : '';
		$status = affiliate_wp()->settings->get( 'require_approval' ) ? 'pending' : 'active';

        if($website_url)
        {
            affwp_add_affiliate( array(
                'user_id'        => $user_id,
                'payment_email'  => ! empty( $_POST['affwp_payment_email'] ) ? sanitize_text_field( $payment_email ) : $user_email,
                'status'         => $status,
                'website_url'    => $website_url,
                'dynamic_coupon' => ! affiliate_wp()->settings->get( 'require_approval' ) ? 1 : '',
            ) );
            $affiliate_id = affwp_get_affiliate_id( $user_id );
            if ( true === $new_user ) {
                // Enable referral notifications by default for new users.
                affwp_update_affiliate_meta( $affiliate_id, 'referral_notifications', true );
            }
            $promotion_method = isset( $promotion_method ) ? sanitize_text_field( $promotion_method ) : '';
            if ( $promotion_method ) {
                affwp_update_affiliate_meta( $affiliate_id, 'promotion_method', $promotion_method );
            }
            do_action( 'affwp_register_user', $affiliate_id, $status, $args );

            return new WP_REST_Response(['user_id'=>$user_id, 'user_name'=>$user_name, 'user_login'=>$user_login, 'user_email'=>$user_email, 'user_url'=>$user_url], 200);
        }else{
            return new WP_Error( "Missing Website URL.", array( 'status' => 400 ) );                
        }
        //trigger_customer_update_api($user_id);
    }
    
    return new WP_Error( "Invalid data Input.", array( 'status' => 400 ) );    
    exit();
}
  
function handle_replace_return_order(WP_REST_Request $request)
{
    $order_id = $request->get_param('order_id');
    $reason_refund = $request->get_param('reason_refund');
    $message = $request->get_param('message');
    
    if ($order_id && !empty($reason_refund)) {
            $order = new WC_Order($order_id);
            if ($order) {
                if ('processing' != $order->get_status() || 'pending' != $order->get_status()) {
                    insert_refund_reason('refund', $reason_refund, $order_id);
                    create_zendesk_ticket_status_changed($order, 'refund');

                    //triggerReplaceOrderObject($order_id);
                    return new WP_REST_Response('success', 200);
                } else {
                    return new WP_Error( "Items cannot be refunded as current status of order is " . $order->get_status(), array( 'status' => 500 ) );    
                    die();
                }
            }
    }
    
    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_review_order_item(WP_REST_Request $request)
{
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');
    $comment_id = $request->get_param('comment_id');
    $rating = $request->get_param('rating');
    $review = $request->get_param('review');    
    
    if ($product_id && $review) {
        if ($comment_id) {        
            wp_update_comment(['comment_ID'=>$comment_id, 'comment_approved'=>0, 'comment_content'=>$review]);
            update_comment_meta($comment_id, 'rating', $rating);
            return new WP_REST_Response('success', 200);
        }elseif($user_id > 0){
            $ip = '';
            $user = get_user_by( 'id', $user_id );
            if (array_key_exists('HTTP_CF_CONNECTING_IP', $_SERVER)) {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
            }
            $review_id = wp_insert_comment(array(
                'comment_post_ID'      => $product_id,
                'comment_author'       => $user->user_firstname . ' ' . $user->user_lastname,
                'comment_author_email' => $user->user_email,
                'comment_author_url'   => '',
                'comment_content'      => $review,
                'comment_type'         => '',
                'comment_parent'       => 0,
                'user_id'              => $user->ID,
                'comment_author_IP'    => $ip,
                'comment_agent'        => '',
                'comment_date'         => date('Y-m-d H:i:s'),
                'comment_approved'     => 0,
            ));

            update_comment_meta($review_id, 'rating', $rating);
            //triggerReplaceOrderObject($order_id);
            return new WP_REST_Response('success', 200);
        }         
    }

    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

function handle_track_order_item(WP_REST_Request $request)
{
    global $wpdb;
    $order_id = $request->get_param('id');
    $order_item_id = $request->get_param('item_id');
    
    if ($order_id != '' && $order_item_id != '') {
        $order = new WC_Order($order_id);
        if (!empty($order)) {
            $data = [];
            $count = 0;
            $order_items = $order->get_items();
            foreach ($order_items as $item_id => $item) {
                if ($item_id == $order_item_id) {
                    $product_id = $item->get_product_id();
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'thumbnail');
                    $q_last = "SELECT *  FROM  " . SB_LOG . ' as l';
                    $q_last .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                    $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id;
                    $q_last .= " ORDER BY log_id ASC";
                    $query_last = $wpdb->get_results($q_last);
                                      
                    if (isset($image[0])) {
                        $data[$count]['img'] = $image[0];
                    }
                    
                    $data[$count]['title'] = get_the_title($product_id);
                    if ($query_last) {            
                        foreach ($query_last as $key => $value) {
                            $data[$count]['event'] = $value->event_id;
                            $data[$count]['created_date'] = date('M', strtotime($value->created_date)).', '.date('d', strtotime($value->created_date));
                            if ($value->event_id == 5) {
                                $data[$count]['impression_notes'] = '';
                                if (trim($value->note) != '') {
                                    if ($value->extra_information == '00') {
                                        $data[$count]['impression_notes'] = 'Both impressions bad';
                                    } else if ($value->extra_information == '01') {
                                        $data[$count]['impression_notes'] = 'Upper impression bad & Lower impression good';
                                    } else if ($value->extra_information == '10') {
                                        $data[$count]['impression_notes'] = 'Upper impression good & Lower impression bad';
                                    } else if ($value->extra_information == '11') {
                                        $data[$count]['impression_notes'] = 'Both impressions good';
                                    } else if ($value->extra_information == '4') {
                                        $data[$count]['impression_notes'] = 'Impressions good';
                                    } else if ($value->extra_information == '3') {
                                        $data[$count]['impression_notes'] = 'Impressions bad';
                                    }
                                } else {
                                    $data[$count]['impression_notes'] = $value->status;
                                }
                            } else if ($value->event_id == 7 && $value->child_order_id > 0) {
                                $notedAddon = ' - Addon order created.<br/> - Order number ' . get_post_meta($value->child_order_id, 'order_number', true);
                                $data[$count]['notes_addon'] = $notedAddon;
                            } else if ($value->event_id == 6) {
                                $data[$count]['event_description'] = $value->event_description;
                            } else if ($value->event_id == 16) {
                                $data[$count]['event_name'] = $value->event_name;
                            } else if ($value->event_id == 17) {
                                $username = get_post_meta($value->child_order_id, '_billing_first_name', true) . ' ' . get_post_meta($value->child_order_id, '_billing_last_name', true);
                                $data[$count]['username'] = $username;
                            } else {
                                $data[$count]['status'] = $value->status;
                            }
                            if ($value->event_id == 2) {
                                $htmlTracking = '';
                                if ($value->shipment_id > 0) {
                                    $shipmentDetail = $wpdb->get_row("SELECT easyPostShipmentTrackingUrl , trackingCode , shipmentStatus FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $value->shipment_id);
                                    $data[$count]['tracking_url'] = $shipmentDetail->easyPostShipmentTrackingUrl;
                                    $data[$count]['tracking_code'] = $shipmentDetail->trackingCode;
                                    $data[$count]['shipment_status'] = $shipmentDetail->shipmentStatus;
                                }
            
                            }
                            $count ++;
                        }
                    }
                    return new WP_REST_Response(($data), 200);
                }
            }
        }
    }
    return new WP_Error( "Invalid data Input.", 500 );    
    exit();
}

function handle_cancel_order_subscriptions(WP_REST_Request $request)
{
    global $wpdb;
    $order_id = $request->get_param('id');
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

            try{
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
            }catch(Exception $e){
                //do nothing
            }

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
        //triggerReplaceOrderObject($order_id);
        return new WP_REST_Response('success', 200);
    }

    return new WP_Error( "Invalid Subscription Order.", array( 'status' => 500 ) );   
    die;
}

function handle_cancel_order(WP_REST_Request $request)
{
    $order_id = $request->get_param('id');
    $reason_cancellation = $request->get_param('reason_cancellation');
    $message = $request->get_param('message');    
    
    if ($order_id != '' && $reason_cancellation != '') {
        $order = new WC_Order($order_id);
        if (!empty($order)) {            
            if (in_array($order->get_status(), ['processing', 'pending'])) {
                insert_refund_reason('cancel', $reason_cancellation, $order_id);
                $order->update_status('cancelled');
                //create_zendesk_ticket_status_changed($order, 'cancel');
                //triggerReplaceOrderObject($order_id);
                return new WP_REST_Response('success', 200);
            } else {
                return new WP_Error( "Order cannot be cancelled as it's current status is " . $order->get_status(), array( 'status' => 500 ) );
            }
        }
    }
    return new WP_Error( "Invalid data Input.", array( 'status' => 500 ) );    
    exit();
}

// Handle login request & setup cookies
function handle_login(WP_REST_Request $request) {
    $username = $request->get_param('username');
    $password = $request->get_param('password');

    // Validate username and password
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user)) {
        // Failed authentication
        return array(
            'status' => 401,
            'success' => false,
            'message' => 'Invalid username or password',
            'error' => 'Bad Request',
        );
    } else {
        // Successful authentication & setup cookies
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        return array(
            'data' => get_customer_data($user->ID),
            'status' => 200,
            'success' => true,
            'message' => 'Login successful',
        );
    }
}

// Handle change password request
function handle_change_password(WP_REST_Request $request) {
    $user_id = $request->get_param('id');
    $password = $request->get_param('password');
    $new_password = $request->get_param('new_password');
  
    $user = get_user_by( 'id', $user_id );
    $user_object = wp_authenticate_username_password( NULL, $user->data->user_login , $password );

    if ( is_wp_error( $user_object )) {
        return array('message' => 'Old password do not match. Please type correct password.', 'status' => false, 'code' => 400);
    }else{
        wp_set_password($new_password , $user_id);
        return array('status' => true, 'code' => 200, 'message'=>'Password updated successfully'); 
    }
}

// Handle customer update request
function handle_customer_update(WP_REST_Request $request) {
    global $wpdb;
    $customer = new WC_Customer( @$request['id'] );    
    if($customer){
        $wpdb->update($wpdb->prefix.'usermeta', array('first_name'=>@$request['user_firstname'], 'last_name'=>@$request['user_lastname'], 'billing_phone'=>@$request['billing_phone']), array('user_id'=>@$request['id']));
        $user_data = wp_update_user(array(
            'ID' => $request['id'],
            'first_name' => $request['user_firstname'],
            'last_name' => $request['user_lastname'],
            'billing_phone'=>@$request['billing_phone']
        ));
        update_user_meta( $request['id'], 'billing_phone', @$request['billing_phone'] );

        if ( is_wp_error( $user_data ) ) {
            new WP_Error('invalid_credentials', __('Invalid customer data.'), array('status' => 401));
        }else{
            //trigger_customer_update_api(@$request['id']);
            return ['id'=>@$request['id'], 'first_name' => $request['user_firstname'], 'last_name' => $request['user_lastname'], 'billing_phone'=> $request['billing_phone']];
        }
    }else{
        new WP_Error('invalid_user', __('Invalid customer id.'), array('status' => 401));
    }
}

// Handle customer update request
function handle_customer_update_social(WP_REST_Request $request) {
    $customer = new WC_Customer( @$request['id'] );    
    if($customer){
        update_user_meta(@$request['id'], 's_instagram',  $request['s_instagram']);
        update_user_meta(@$request['id'], 's_twitter',  $request['s_twitter']);
        update_user_meta(@$request['id'], 's_facebook',  $request['s_facebook']);
        update_user_meta(@$request['id'], 's_youtube',  $request['s_youtube']);
        update_user_meta(@$request['id'], 's_linkedin',  $request['s_linkedin']);
        update_user_meta(@$request['id'], 's_tikTok',  $request['s_tikTok']);
        update_user_meta(@$request['id'], 's_blog',  $request['s_blog']);
        //trigger_customer_update_api(@$request['id']);

        return new WP_REST_Response(['id'=>$request['id'], 'message'=>'updated!'], 200);
        
    }else{
        new WP_Error('invalid_user', __('Invalid customer id.'), array('status' => 401));
    }
}

// add_action('woocommerce_order_status_changed', 'trigger_order_update_api', 10, 4);
// add_action('woocommerce_order_updated', 'trigger_order_update_api', 10, 2);
// add_action('woocommerce_update_order', 'trigger_order_update_api', 10, 2);
// add_action('woocommerce_process_shop_order_meta', 'trigger_order_update_api');
// function trigger_order_update_api( $order_id ) {    
//     triggerReplaceOrderObject($order_id);
// }

// add_action( 'woocommerce_before_order_object_save', 'action_woocommerce_before_order_object_save', 10, 2 );
// add_action( 'woocommerce_after_order_item_object_save', 'action_woocommerce_before_order_object_save', 10, 2 );
// function action_woocommerce_before_order_object_save( $order, $data_store ) {
//     triggerReplaceOrderObject($order->get_id());
// }

// add_action( 'woocommerce_after_order_object_save', 'action_woocommerce_after_order_object_save', 10, 1 );
// add_action( 'woocommerce_admin_order_data_after_billing_address', 'action_woocommerce_after_order_object_save', 10, 1 );
// function action_woocommerce_after_order_object_save( $order ) {
//     triggerReplaceOrderObject($order->get_id());
// }

/*add_action( 'save_post_shop_order', 'trigger_order_update', 10, 3 );
function trigger_order_update( $post_id, $post, $update ){
    triggerReplaceOrderObject($post_id);
}*/

/*add_action( 'wp_insert_post', 'my_order_created', 10, 3 );
function my_order_created ( $post_id, $post, $update ) {

    // Don’t run if $post_id doesn’t exist OR post type is not order OR update is true
    if ( ! $post_id || get_post_type( $post_id ) != 'shop_order') {
        return;
    }
    $order = new WC_Order( $post_id ); 
    echo "order created2".$post_id.":".$order->get_id();exit;
    triggerReplaceOrderObject($order->get_id());
}*/

function triggerReplaceOrderObject($order_id)
{
    global $wpdb;
    $order = wc_get_order($order_id);
    
    if($order){
        $order_data = get_order_data($order_id);
        try{
            $ch = curl_init(WP_HOME."/api/order/replace-order");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);    
        }catch(Exception $e){
            //do nothing
        }
    }
}

//add_action('profile_update','trigger_customer_update_api');
//add_action('user_register','trigger_customer_update_api');
//add_action('woocommerce_update_customer','trigger_customer_update_api');
function trigger_customer_update_api($customer_id) {    
    $user_data = get_customer_data($customer_id);
   try{
        $ch = curl_init(WP_HOME."/api/customer/replace-customer");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($user_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
   }catch(Exception $e){
    //do nothing
   }
}

// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wp_loaded', 'woocommerce_add_multiple_products_to_cart', 15 );
function woocommerce_add_multiple_products_to_cart() {
    //https://stable.smilebrilliant.com/?add-to-cart=711911,711909&quantities=1,2&device_id=112233&user_id=192813&jwt_token=123456
    // Check if 'add-to-cart' and 'quantities' parameters are present in the URL.
    if ( isset( $_GET['add-to-cart'] ) && isset( $_GET['quantities'] ) && isset($_REQUEST['device_id']) && isset($_REQUEST['user_id']) ) {
        // Split the 'add-to-cart' and 'quantities' parameters into arrays.
        $product_ids = explode( ',', $_GET['add-to-cart'] );
        $quantities = explode( ',', $_GET['quantities'] );
        $user_id = (int)@$_REQUEST['user_id'];
        $jwt_token = @$_REQUEST['jwt_token'];
        $jwt = get_user_meta($user_id, 'jwt_token', true);

        if($user_id > 0 && $jwt == $jwt_token && !is_super_admin($user_id))
        {
            $user = get_user_by('id', $user_id);
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);

            // Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
            remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

            // Check if the count of product IDs matches the count of quantities.
            if ( count( $product_ids ) == count( $quantities ) ) {
                // Loop over the arrays and for each pair of product ID and quantity, add the product to the cart.
                for ( $i = 0; $i < count( $product_ids ); $i++ ) {
                    $product_id = (int)@$product_ids[$i];
                    $quantity = (int)@$quantities[$i];
                    // Add the product to the cart using the WooCommerce function.
                    WC()->cart->add_to_cart( $product_id, $quantity );
                }
            }
            setcookie( 'device_id', $_REQUEST['device_id'], strtotime('+1 day'));
            setcookie( 'jwt_token', $jwt, strtotime('+1 day'));
        }
        wp_redirect( wc_get_checkout_url() );
        exit;
    }
}

//add_action( 'woocommerce_checkout_update_order_review', 'custom_update_order_review', 10, 1 );
// function custom_update_order_review( $posted_data ) {
//     if(isset($_COOKIE['device_id']) || isset($_COOKIE['jwt_token'])){
//         $cart_totals = WC()->cart->get_totals();
//         $cart_items = WC()->cart->get_cart();
//         foreach ($cart_items as $cart_item_key => $cart_item) {
//             // Get the product ID
//             $product_id = $cart_item['product_id'];
        
//             // Get the product feature image URL
//             $product_feature_image_url = get_the_post_thumbnail_url($product_id, 'medium');
        
//             // Add the product feature image URL to the cart item
//             $cart_items[$cart_item_key]['product_feature_image_url'] = $product_feature_image_url;
//         }

//         // Prepare cart object to return in the response
//         $cart_object = array(
//                 'cart_totals' => $cart_totals,
//                 'cart_items' => $cart_items,
//                 'device_id' => (isset($_COOKIE['device_id'])?$_COOKIE['device_id']:'')
//         );
//         $cart_object['cart_totals']['coupons'] = WC()->cart->get_applied_coupons();
//         //print_r(json_encode($cart_object));exit;
//         //here add the sync cart link
//         $ch = curl_init(WP_HOME."/api/cart/sync");    
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cart_object));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         $result = curl_exec($ch);
//         curl_close($ch);
//     }
// }

// add_action('woocommerce_payment_complete', 'clear_mongocart_after_order_submission', 10, 1 );
// function clear_mongocart_after_order_submission( $order_id ) {
//     //$order = wc_get_order( $order_id );    
//     if(isset($_COOKIE['device_id']) || isset($_COOKIE['jwt_token'])){
//         $ch = curl_init(WP_HOME."/api/cart/clear/".$_COOKIE['device_id']);
//         curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         $result = curl_exec($ch);
//         curl_close($ch);

//         unset($_COOKIE['jwt_token']);
//         unset($_COOKIE['device_id']);
//     }
// }

add_action( 'profile_update', 'wp_check_user_email_updated', 10, 2 );
function wp_check_user_email_updated( $user_id, $old_user_data ) {
	$old_user_email = $old_user_data->data->user_email;

	$user = get_userdata( $user_id );
	$new_user_email = $user->user_email;

	if ( $new_user_email !== $old_user_email ) {
		update_user_meta( $user_id, 'old_user_email', $old_user_email );

        //@@@@/////////update klavio email///////////@@@//
        /*$api_key = "pk_a75e6e2f97abd7bbf6f141a5acc53c5d17";
        $endpoint = "https://a.klaviyo.com/api/v2/people/search?email=" . urlencode($old_user_email) . "&api_key=" . $api_key;

        // Initialize cURL & get user profile id
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile_id = json_decode($response, true);
        //##***********update profile*************##
        if(isset($profile_id['id'])){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://a.klaviyo.com/api/profiles/'.@$profile_id['id'].'/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS =>'{
            "data": {
                "type": "profile",
                "id": "'.@$profile_id['id'].'",
                "attributes": {
                "email": "'.$new_user_email.'"
                }
            }
            }',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Klaviyo-API-Key {$api_key}",
                "accept: application/json",
                "content-type: application/json",
                "revision: 2023-12-15"
            ),));
            $response = curl_exec($curl);
            curl_close($curl);
            //echo $response;exit;
        }*/
        ///////////end klavio //////////////
	}
}
?>