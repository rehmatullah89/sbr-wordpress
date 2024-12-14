<?php
// Hamza-1 starts

add_action('woocommerce_after_order_itemmeta', 'smilebrilliant_order_meta_custom_details', 9, 3);

function smilebrilliant_order_meta_custom_details($item_id, $item, $product = null, $addOn = 0) {

    
    $html = '';
     $mouth_guard_number = wc_get_order_item_meta($item_id, 'mouth_guard_number', true);
    
 
     $mouth_guard_color = wc_get_order_item_meta($item_id, 'mouth_guard_color', true);
     
     
     if (!empty($mouth_guard_color)) {
        $html = '<div class="custom-guards">Color:<strong class="' . $mouth_guard_color . '"> ' . $mouth_guard_color . '</strong></div>';
     }
     if (!empty($mouth_guard_number)) {
         
         $html .= '<div class="custom-guards">Number:<strong> '.$mouth_guard_number.'</strong></div>';
     }

     echo $html;
}

// View = how many people added something to cart such that shipping protection was seen
// Accepted = completed checkout and pId for shipping protection
// Rejected = completed checkout but manually removed protection line item
// Success ratio = total checkout with protection divided by total views
// Rejection ratio = total checkout without protection divided by total views
// Conversion rate% = add up all accepted + all rejected orders and divide by total views to get the conv rate
function save_product_ids_to_options($post_id) {
    // on every product update, update Night Guards and Whitening product array in options table
    // Check if it's a product post type
    if (get_post_type($post_id) === 'product') {
        // Define an array to store product IDs
        $product_ids = array();

        // Get product IDs belonging to specific categories
        $category_slugs = array('night-guards', 'teeth-whitening-gel', 'teeth-whitening-trays');
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category_slugs,
                    'operator' => 'IN',
                ),
            ),
        );
        $query = new WP_Query($args);

        // Loop through the products and store their IDs
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product_ids[] = get_the_ID();
            }
            // Restore original post data
            wp_reset_postdata();
        }

        // Store the product IDs in wp_options
        update_option('ng_wht_ids', $product_ids);
        store_ng_wht_ids_mongodb($product_ids);
  

    }
}
add_action('save_post', 'save_product_ids_to_options');

function add_shipping_protection_cookies() {
// Check if the cookie doesn't exist
    if (!isset($_COOKIE['shipping_protection_prices_ng'])) {
        $shipping_protection_prices_ng = defined('SHIPPING_PROTECTION_PRICES_NG') ? SHIPPING_PROTECTION_PRICES_NG : SHIPPING_PROTECTION_PRICE_DEFAULT;
        $cookieValue = $shipping_protection_prices_ng[array_rand($shipping_protection_prices_ng)];
        setcookie('shipping_protection_prices_ng', $cookieValue, time() + (86400 * 360), '/');
    }
    
    // Check if the cookie doesn't exist    
    if (!isset($_COOKIE['shipping_protection_prices_non_ng'])) {
        // $shipping_protection_prices_non_ng = defined('SHIPPING_PROTECTION_PRICES_NON_NG') ? SHIPPING_PROTECTION_PRICES_NON_NG : SHIPPING_PROTECTION_PRICE_DEFAULT;
        // $cookieValue = $shipping_protection_prices_non_ng[array_rand($shipping_protection_prices_non_ng)];
        // setcookie('shipping_protection_prices_non_ng', $cookieValue, time() + (86400 * 360), '/');

        $cookieValue = get_shipping_protection_price_non_ng();
        setcookie('shipping_protection_prices_non_ng', $cookieValue, time() + (86400 * 360), '/');
    }
    
}

function get_shipping_protection_price_non_ng()
{
    $shipping_protection_value = get_option('shipping_protection_prices_non_ng',SHIPPING_PROTECTION_PRICE_DEFAULT);
    
    if (($key = array_search($shipping_protection_value, SHIPPING_PROTECTION_PRICES_NON_NG)) !== false) {
        $shipping_protection_value = SHIPPING_PROTECTION_PRICES_NON_NG[$key === 0 ? 1 : 0];
        update_option('shipping_protection_prices_non_ng', $shipping_protection_value);       
    }
    return $shipping_protection_value;
}


add_action( 'woocommerce_add_to_cart', 'wp_kama_woocommerce_add_to_cart_action', 10, 6 );

function wp_kama_woocommerce_add_to_cart_action( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    if (!session_id()) {
        session_start();
    }
    // Get the WooCommerce cart instance    
    global $wpdb;

    $cart = WC()->cart;
    $device = wp_is_mobile() ? 'mobile' : 'desktop';
    $shipping_protection_prices_non_ng = defined('SHIPPING_PROTECTION_PRICES_NON_NG') ? SHIPPING_PROTECTION_PRICES_NON_NG : SHIPPING_PROTECTION_PRICE_DEFAULT;
    $cookieValueDefault = $shipping_protection_prices_non_ng[array_rand($shipping_protection_prices_non_ng)];
    $ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
    $non_ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : $cookieValueDefault;
     
    $shipping_price =$non_ng_shipping_protection_price;
    $ng_wht_ids = get_option('ng_wht_ids');

     // Loop through cart items
    if(is_array($ng_wht_ids) && count($ng_wht_ids)>0)
    { 
        $shipping_protection_exists = false;
        $is_ng_wht = false;
        $cart_items = $cart->get_cart(); 
        $cart_items_count = count($cart->get_cart()); 
       
        $shippingProtection = (isset($_SESSION['shipping_protection'])?$_SESSION['shipping_protection']:'');
        foreach ($cart_items as $cart_item_key => $cart_item) {
            $cart_product_id = $cart_item['product_id'];
            
            if(in_array($cart_product_id, $ng_wht_ids)){
                $shipping_price = $ng_shipping_protection_price;
                $is_ng_wht = true; 
            }
            
            if ($cart_product_id == SHIPPING_PROTECTION_PRODUCT) {
                $shipping_protection_exists = true;
            }
        }

        if($shipping_protection_exists){
            $countedBefore = isset($shippingProtection) && $shippingProtection == $shipping_price;    
            //Check if have seen on a price before don't count it in viewed again (check only one time previous)
            if(!$countedBefore){
                if($is_ng_wht){
                    updateReport('viewed_ng',$shipping_price, $device."_ng");
                }else{
                    updateReport('viewed',$shipping_price, $device);
                }                
                $_SESSION['shipping_protection'] = $shipping_price;
                $_SESSION['is_ng_wht'] = $is_ng_wht;
            }
        }          
     }
}


add_action('woocommerce_before_calculate_totals', 'custom_modify_product_price_before_add_to_cart', 1, 1 );
function custom_modify_product_price_before_add_to_cart($cart) {

    global $wpdb;
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    

    $ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
    $non_ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
     
    $shipping_price =$non_ng_shipping_protection_price;
 
    $ng_wht_ids = get_option('ng_wht_ids');
    
     // Loop through cart items to set shipping protection price and find cart_item 
     if(is_array($ng_wht_ids) && count($ng_wht_ids)>0){
        $shipping_product_cart_id ='';
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $cart_product_id = $cart_item['product_id'];
         
            if(in_array($cart_product_id, $ng_wht_ids)){
                $shipping_price = $ng_shipping_protection_price;
                
            }
          
           if($cart_product_id == SHIPPING_PROTECTION_PRODUCT)
            {
                $shipping_product_cart_id = $cart_item;
            }
        }
        // free shipping protection for shine users
        if ((is_user_logged_in() && get_user_meta(get_current_user_id(), 'is_shine_user', true) == '1') || (isset($_COOKIE['shine_user']) && $_COOKIE['shine_user'] != '')) {
            $shipping_price = 0.00;
        }
        // set valid price to  the Shipping Protection product in the cart.
        if($shipping_product_cart_id != ''){

            $shipping_product_cart_id['data']->set_price($shipping_price);
        }

     }
}
add_action( 'woocommerce_checkout_order_processed', 'get_product_price_after_checkout', 10, 1 );

function get_product_price_after_checkout( $order_id ) {
    global $wpdb;
    // Get the order object
    if (!session_id()) {
        session_start();
    }
    $product_price = 0;
    $order = wc_get_order( $order_id );
    $ng_wht_ids = get_option('ng_wht_ids');
    $is_ng_wht = false;
    $shipping_protection_exists = false;
    $device = wp_is_mobile() ? 'mobile' : 'desktop';
    $shippingProtection = (isset($_SESSION['shipping_protection'])?$_SESSION['shipping_protection']:'');
    // Loop through order items
    foreach ( $order->get_items() as $item_id => $item ) {
        // Check if the item is the one with ID 123
        $order_product_id = $item->get_product_id();
        if(in_array($order_product_id, $ng_wht_ids)){
            $is_ng_wht  = true;
        }
        if ( $item->get_product_id() == SHIPPING_PROTECTION_PRODUCT ) {

            $product_price = $item->get_subtotal();
            $shipping_protection_exists = true;
            
        }
    }
    // $countedBefore to check if protection was added before and than removed, than count it in removed

    $countedBefore = isset($shippingProtection);
   
    if($shipping_protection_exists &&  $is_ng_wht && isset($product_price)){
        updateReport('redeemed_ng',$product_price, $device."_ng");
        updateReportOrders('ng',$product_price, $order_id, $device."_ng",'order');
    }else if ($shipping_protection_exists && isset($product_price)){        
        updateReport('redeemed',$product_price, $device);
        updateReportOrders('non_ng', $product_price, $order_id, $device,'order');
    }else if(!$shipping_protection_exists && $countedBefore){
        //check if it was under ng_wht or not
        if(isset($_SESSION['is_ng_wht']) && isset($_SESSION['is_ng_wht']) && $_SESSION['is_ng_wht']){

            if(!isset($product_price) || $product_price == 0){
                $product_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
            }

            updateReport('removed_ng',$shippingProtection, $device."_ng");
            updateReportOrders('ng', $product_price, $order_id, $device."_ng", 'cart');
        }else{
            
            if(!isset($product_price) || $product_price == 0){
                $product_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
            }

            updateReport('removed',$shippingProtection, $device);
            updateReportOrders('non_ng', $product_price, $order_id, $device, 'cart');
        }
    }
    if (isset($_SESSION['shipping_protection'])) {
        unset($_SESSION['shipping_protection']);
    }
    if (isset($_SESSION['is_ng_wht'])) {
        unset($_SESSION['is_ng_wht']);
    }
    
  

}
add_action( 'woocommerce_cart_item_removed', 'wp_kama_woocommerce_cart_item_removed_action', 10, 2 );

function wp_kama_woocommerce_cart_item_removed_action( $cart_item_key, $that ){
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    if (!session_id()) {
        session_start();
    }
    // Get the WooCommerce cart instance
    $cart = WC()->cart;
    global $wpdb;
    $device = wp_is_mobile() ? 'mobile' : 'desktop';
    $removed_item = $cart->removed_cart_contents[$cart_item_key];
    $ng_wht_ids = get_option('ng_wht_ids');
    
    $removed_product_id = $removed_item['product_id'];
    $product_price = $removed_item['line_subtotal'];
    // check if shipping protection was removed, if yes  - update database
    if(isset($removed_product_id) && isset($product_price) && $removed_product_id == SHIPPING_PROTECTION_PRODUCT){
        if(is_array($ng_wht_ids) && count($ng_wht_ids)>0){
            $is_ng_wht = false;
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $cart_product_id = $cart_item['product_id'];
             
                if(in_array($cart_product_id, $ng_wht_ids)){
                    $is_ng_wht = true;
                }
            }

        }
        if($is_ng_wht){
            // updateReport('removed_ng',$product_price);
        }else{

            // updateReport('removed',$product_price);
        }
  
    }

    // after remove item occurs recheck if Night Guard/Whitening product exists in cart ,
    //  and set price respectively 

    $ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
    $non_ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
     
    $shipping_price =$non_ng_shipping_protection_price;

    
     // Loop through cart items
     if(is_array($ng_wht_ids) && count($ng_wht_ids)>0){
        $is_ng_wht = false;
        $shipping_protection_exists = false;
        $shippingProtection = (isset($_SESSION['shipping_protection'])?$_SESSION['shipping_protection']:'');
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $cart_product_id = $cart_item['product_id'];
         
            if(in_array($cart_product_id, $ng_wht_ids)){
                $shipping_price = $ng_shipping_protection_price;
                $is_ng_wht  = true;
            }
            if ($cart_product_id == SHIPPING_PROTECTION_PRODUCT) {
                $shipping_protection_exists = true;
            }
        }
        //if Shipping Protection exists count it as viewed
           if ($shipping_protection_exists) {
                $countedBefore = isset($shippingProtection) && $shippingProtection == $shipping_price;            
                //Check if have seen on a price before don't count it in viewed again (check only one time previous)
                if(!$countedBefore){
                    if($is_ng_wht){
                        updateReport('viewed_ng',$shipping_price, $device."_ng");
                    }else{
                        updateReport('viewed',$shipping_price, $device); 
                    }
                    $_SESSION['shipping_protection'] = $shipping_price;
                    $_SESSION['is_ng_wht'] = $is_ng_wht;
                }
            }
     }
}
// Add Side Menu for Shipping Protection Report
function admin_menu_reporting_shipping_protection() {
    add_menu_page(
           
        __('Shipping Protection', 'sbr' ),
        'Shipping Protection',
        'manage_options',
       
        'sbr_display_reports',
        'sbr_display_reports',
        plugins_url( 'sbr-reporting/assets/images/icon.png' ),
        6
    );

}
add_action( 'admin_menu', 'admin_menu_reporting_shipping_protection' );

function  sbr_display_reports(){ 
include_once(get_stylesheet_directory().'/inc/shipping-protection-functions.php');
}
function sync_sale_products_only($productsArr) {
    $base_url = home_url('/');

    $api_endpoint = 'api/products/sync-products-sale/';

    $api_url = $base_url . $api_endpoint;

    // Prepare the request body
    $body = json_encode(['products' => $productsArr]);

    // Set up the request arguments
    $args = [
        'method'  => 'POST',
        'body'    => $body,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ];


    // Make the API call using wp_remote_post
    $response = wp_remote_post($api_url, $args);
    // print_r($response);
    // die();
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        // Update option with the current date and time on success
        update_option('sale_products_synced', current_time('mysql'). ' '.wp_remote_retrieve_response_code($response));
    } else {
        $error_message = is_wp_error($response) ? $response->get_error_message() : 'API call failed with an unknown error.';
       
        update_option('sale_products_sync_failed', current_time('mysql') . ' ' . $error_message);
    }
}

add_action('save_post', 'call_api_after_post_save', 10, 2);

function call_api_after_post_save($post_id, $post) {
    // Check if this is not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if the post type is 'product' (you can modify this based on your needs)
    if ($post->post_type !== 'product') {
        return;
    }

    // Your API endpoint URL
    $base_url = home_url('/');

    $api_endpoint = 'api/products/sync-products/';

   
    $api_url = $base_url . $api_endpoint . $post_id;

    // Make the API call using wp_remote_get
    $response = wp_remote_get($api_url);

    // Check if the API call was successful
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        // Update post meta with the current date and time on success
        update_post_meta($post_id, 'api_call_success_date', current_time('mysql'));
    } else {
        // Update post meta with the error message on failure
        $error_message = is_wp_error($response) ? $response->get_error_message() : 'API call failed with an unknown error.';
        update_post_meta($post_id, 'api_call_error_message', $error_message);
    }
}
function store_ng_wht_ids_mongodb($ids=[]) {
    // URL to send the PATCH request to
    $base_url = home_url('/');
    $api_endpoint = 'api/options/store-or-update';
    
    $url = $base_url . $api_endpoint;
    
    
    // Data to be sent in the request body
    $data = array(
        'key' => 'ng_wht_ids',
        'value' =>$ids
    );

    // Arguments for the request
    $args = array(
        'method'  => 'POST',
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body'    => json_encode($data),
    );

    // Send the request
    $response = wp_remote_request($url, $args);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        // Handle error
        return "Error: $error_message";
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code === 200) {
            // Request was successful
            // return 'Request sent successfully.';
        } else {
            // Handle other response codes
            return "Error: Unexpected response code - $response_code";
        }
    }
}

function recalculate_cart() {
    WC()->cart->calculate_totals();
}
// Hook into WooCommerce cart updated actions
add_action( 'woocommerce_cart_loaded_from_session', 'recalculate_cart', 10 );
add_action( 'woocommerce_cart_item_removed', 'recalculate_cart', 10 );
// Hamza-1 ends

// function updateReport($type,$shipping_price){
   
//     global $wpdb;
//     $count = $wpdb->get_var($wpdb->prepare("
//     SELECT $type FROM shipping_protection_report 
//     WHERE price = %s", $shipping_price));
    
//     if(isset($count)){

//         $count = intval($count) + 1;
//         $wpdb->query($wpdb->prepare("
//             UPDATE shipping_protection_report 
//             SET $type= %d 
//             WHERE price = %s", $count, $shipping_price));
//     }
// }

function updateReport($type, $shipping_price, $additional_field = null) {
    global $wpdb;
    
    $count = $wpdb->get_var($wpdb->prepare("
        SELECT $type FROM shipping_protection_report 
        WHERE price = %s", $shipping_price));

    if (isset($count)) {
        $count = intval($count) + 1;
        $wpdb->query($wpdb->prepare("
            UPDATE shipping_protection_report 
            SET $type = %d 
            WHERE price = %s", $count, $shipping_price));

        $reportId = $wpdb->get_var($wpdb->prepare("
            SELECT id FROM shipping_protection_report 
            WHERE price = %s", $shipping_price));
    
        $session_id = isset($_COOKIE['design_ng_sbr_unique_id']) ? $_COOKIE['design_ng_sbr_unique_id']:'';
        $wpdb->insert('shipping_protection_report_visits', [
                'device' => $additional_field,
                'action' => $type,
                'price' => $shipping_price,
                'price_id' => $reportId,
                'session_id' => $session_id,
                'date_time' => date("Y-m-d H:i:s")
        ]);    
    }
    
    if ($additional_field !== null && preg_match('/viewed(_ng)?/', $type)) {
        $additional_count = $wpdb->get_var($wpdb->prepare("
            SELECT $additional_field FROM shipping_protection_report 
            WHERE price = %s", $shipping_price));
        
        if (isset($additional_count)) {
            $additional_count = intval($additional_count) + 1;
            $wpdb->query($wpdb->prepare("
                UPDATE shipping_protection_report 
                SET $additional_field = %d 
                WHERE price = %s", $additional_count, $shipping_price));
        }
    }
}

function updateReportOrders($type ,$product_price, $order_id, $device, $action)
{   global $wpdb;

    if($product_price>0 && $order_id>0){
        $reportId = $wpdb->get_var($wpdb->prepare("
        SELECT id FROM shipping_protection_report 
        WHERE price = %s", $product_price));

        $order = wc_get_order( $order_id );
        $total_price = $order?$order->get_total():0;

        $wpdb->insert('shipping_protection_report_orders', [
            'shipping_protection_report_id' => (int)@$reportId,
            'shipping_protection_report_price' => $total_price,
            'type' => $type,
            'order_id' => $order_id,
            'device' => $device,
            'action' => $action,
            'date_time' => date("Y-m-d H:i:s")
        ]);
    }
}
