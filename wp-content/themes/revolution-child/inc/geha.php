<?php
//if (isset($_GET['utm_campaign']) && $_GET['utm_campaign'] == 'userExists') {
if (isset($_GET['utm_campaign']) && strtolower($_GET['utm_campaign']) == 'userexists') {
    setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
    $_SESSION['geha_user'] = 'yes';
}
function sb_hook_endpoint($url, $endpoint, $value, $permalink)
{

    if ($endpoint === 'customer-logout') {
        $url = site_url('/logout/');
    }

    return $url;
}

add_filter('woocommerce_get_endpoint_url', 'sb_hook_endpoint', 10, 4);


add_action('template_redirect', 'verify_geha_customer_url_oldstructure', 100);

function verify_geha_customer_url_oldstructure()
{
    if (is_404()) {

        $sb_link = $_SERVER['REQUEST_URI'];


        $url_match_case = trim($sb_link, '/');
        $geha_data = explode('/', $url_match_case);

        if ($geha_data[0] == 'checkout-geha') {
            set_transient( 'geha_user', 'yes', 365 * DAY_IN_SECONDS );
            
            $geha_product_id = 130266;
            $product_qty = isset($geha_data[2]) ? $geha_data[2] : 1;
            $exploded_qty =  explode('?', $product_qty);
            if (count($exploded_qty) > 0) {
                $product_qty = preg_replace("/[^0-9]/", "", $exploded_qty[0]);
            }
            $product_qty = (int) preg_replace("/[^0-9]/", "", $product_qty);
            global $wpdb;
            if (isset($geha_data[1])) {
               
                $post_exists = $wpdb->get_row("SELECT post_status FROM $wpdb->posts WHERE id = '" . $geha_product_id . "'", 'ARRAY_A');
                if (isset($post_exists['post_status']) && $post_exists['post_status'] == 'publish') {
                    if (isset($geha_data[1]) && filter_var($geha_data[1], FILTER_VALIDATE_EMAIL)) {

                        $user_id = username_exists($geha_data[1]);

                        if (!$user_id && false == email_exists($geha_data[1])) {
                            $random_password = wp_generate_password($length = 12, false);
                            $user_id = wp_create_user($geha_data[1], $random_password, $geha_data[1]);
                            $user_data = new WP_User($user_id);
                            $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
                            $user_data->add_role('customer');
                            update_user_meta($user_id, 'geha_user', 'yes');
                            update_user_meta($user_id, "billing_email", $geha_data[1]);

                            //clean_user_cache($user_id);
                            //wp_clear_auth_cookie();
                            /*
                            wp_set_current_user($user_id);
                            wp_set_auth_cookie($user_id, true, false);
                            update_user_caches($user_data);
                             * 
                             */
                        } else {
                            $user_data = get_user_by('email', $geha_data[1]);
                            $user_id = $user_data->ID;
                            ///$user_data = new WP_User($user_id);

                            if (!in_array('administrator', (array) $user_data->roles) && in_array('customer', (array) $user_data->roles)) {
                                update_user_meta($user_data->ID, 'geha_user', 'yes');
                                // clean_user_cache($user_id);
                                // wp_clear_auth_cookie();
                                /*
                                wp_set_current_user($user_id);
                                wp_set_auth_cookie($user_id, true, false);
                                update_user_caches($user_data);
                                 * 
                                 */
                            }
                        }
                        setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
                       // klaviyo_geha_customer_list($geha_data[1]);

                        WC()->cart->empty_cart();
                        $product_id = $geha_product_id;
                        $cart_item_data = array('checkout-geha' => 'yes');

                        if (isset($_GET['free_shipping']) && $_GET['free_shipping'] != '') {
                            $cart_item_data['gehaVariant'] = $_GET['free_shipping'];
                            $expData = array(
                                'variant' => $_GET['free_shipping'],
                                'email_address' => $geha_data[1],
                            );

                            $experiment_id = sbr_geha_experiment($expData);
                            $cart_item_data['geha_experiment_id']  = $experiment_id;
                        }


                        $_POST['action'] = 'woocommerce_add_order_item';
                        WC()->cart->add_to_cart($product_id, $product_qty, 0, array(), $cart_item_data);

                        setcookie('billing_email', $geha_data[1], time() + (8640), "/");
                        //$checkout_url = site_url('checkout') . '?email=' . $geha_data[1];

                        $checkout_url = site_url('checkout');
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: " . $checkout_url);
                    } else {
                        echo 'Invalid Email Address';
                    }
                } else {
                    echo 'Product Not Exist in System';
                }
            }
            die;
        }
    }
}

function verify_geha_customer_url()
{
    if (is_404()) {

        $sb_link = $_SERVER['REQUEST_URI'];


        $url_match_case = trim($sb_link, '/');
        $geha_data = explode('/', $url_match_case);
        global $wpdb;
        if (isset($geha_data[2])) {
            $post_exists = $wpdb->get_row("SELECT post_status FROM $wpdb->posts WHERE id = '" . $geha_data[2] . "'", 'ARRAY_A');
            if (isset($post_exists['post_status']) && $post_exists['post_status'] == 'publish') {
                if (isset($geha_data[1]) && filter_var($geha_data[1], FILTER_VALIDATE_EMAIL)) {
                    if (isset($geha_data[3]) && ($geha_data[3] > 0)) {
                        $user_id = username_exists($geha_data[1]);

                        if (!$user_id && false == email_exists($geha_data[1])) {
                            $random_password = wp_generate_password($length = 12, false);
                            $user_id = wp_create_user($geha_data[1], $random_password, $geha_data[1]);
                            $user_data = new WP_User($user_id);
                            $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
                            $user_data->add_role('customer');
                            update_user_meta($user_id, 'geha_user', 'yes');
                            update_user_meta($user_id, "billing_email", $geha_data[1]);

                            clean_user_cache($user_id);
                            wp_clear_auth_cookie();
                            wp_set_current_user($user_id);
                            wp_set_auth_cookie($user_id, true, false);
                            update_user_caches($user_data);
                        } else {
                            $user_data = get_user_by('email', $geha_data[1]);
                            $user_id = $user_data->ID;
                            ///$user_data = new WP_User($user_id);
                            update_user_meta($user_data->ID, 'geha_user', 'yes');
                            if (!in_array('administrator', (array) $user_data->roles) && in_array('customer', (array) $user_data->roles)) {
                                clean_user_cache($user_id);
                                wp_clear_auth_cookie();
                                wp_set_current_user($user_id);
                                wp_set_auth_cookie($user_id, true, false);
                                update_user_caches($user_data);
                            }
                        }
                        $quantity = $geha_data[3];
                    } else {
                        $quantity = 1;
                    }
                    WC()->cart->empty_cart();
                    $product_id = $geha_data[2];
                    $cart_item_data = array('checkout-geha' => 'yes');
                    $_POST['action'] = 'woocommerce_add_order_item';
                    WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);

                    $checkout_url = site_url('checkout') . '?email=' . $geha_data[1];
                    $checkout_url = site_url('checkout');
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: " . $checkout_url);
                } else {
                    echo 'Invalid Email Address';
                }
            } else {
                echo 'Product Not Exist in System';
            }
        }
        die;
    }
}

add_filter('woocommerce_checkout_fields', 'smile_brillaint_prefill_checkout_fields');

function smile_brillaint_prefill_checkout_fields($checkout_fields)
{

    /**
     * Query string fields to populate in checkout,
     *
     * Ex.
     * 'fname' => is query parameter name,
     * 'billing_first_name' => matching field of checkout 
     *
     * You can add other fields in the same way
     */
    $query_fields = array(
        'email' => 'billing_email',
    );

    // We will loop the above array to check if the field exists in URL or not.
    // If it exists we will add it to the checkout field's default value

    foreach ($query_fields as $field_slug => $match_field) {

        // Check if it is in URL or not, An not empty.
        if (isset($_GET[$field_slug]) && !empty($_GET[$field_slug])) {

            // Sanitize the value and store it in a variable.
            $field_value = sanitize_text_field($_GET[$field_slug]);

            // Check if match field exists in checkout form or not.
            if (isset($checkout_fields['billing'][$match_field])) {

                // Assign the pre-fill value to checkout field
                $checkout_fields['billing'][$match_field]['default'] = $field_value;
            }
        }
    }
    // Return the fields
    return $checkout_fields;
}

// Save an additional coverstart value in in the order post meta dat
add_action('woocommerce_checkout_update_order_meta', 'smile_brillaint_GEHA_tag', 10, 2);

function smile_brillaint_GEHA_tag($order_id)
{
    $order = wc_get_order($order_id);
    $gehaOrder = false;
    $threeWay = false;
    $dentistOrder='';
    foreach ($order->get_items() as $item_id => $item) :
        $product_id = $item->get_product_id(); // the Product id
        if (get_post_meta($product_id, 'geha_product', true)) {
            $gehaOrder = true;
            wc_update_order_item_meta($item_id, 'geha_item', 'yes');
        }
        if (get_post_meta($product_id, 'three_way_ship_product', true)) {
            $threeWay = true;
        }
        if (wc_get_order_item_meta($item_id, '_geha_source', true) == 'lander') {
            $gehaOrder = true;
        }
        if (wc_get_order_item_meta($item_id, 'dentist_id', true) != '') {
            $dentistOrder = wc_get_order_item_meta($item_id, 'dentist_id', true);
        }
    endforeach;
    // Deprecated
    // if ($order->get_used_coupons()) {
    //     foreach ($order->get_used_coupons() as $coupon_code) {
    //         $coupon = new WC_Coupon($coupon_code);
    //         if (get_post_meta($coupon->get_id(), 'geha_coupon', true) == 'yes') {
    //             $gehaOrder = true;
    //         }
    //     }
    // }
    if ($order->get_coupon_codes()) {
        foreach ($order->get_coupon_codes() as $coupon_code) {
            $coupon = new WC_Coupon($coupon_code); // Load the coupon by its code
            if (get_post_meta($coupon->get_id(), 'geha_coupon', true) == 'yes') {
                $gehaOrder = true;
            }
        }
    }
    $geha_user = isset($_COOKIE['geha_user']) ? $_COOKIE['geha_user'] : '';
   
    
    if($geha_user =='') {
        
    }
    if ($geha_user == 'yes') {
        $gehaOrder = true;
    }
     
    if ($gehaOrder) {
        if (function_exists('klaviyo_geha_customer_list')) {
            klaviyo_geha_customer_list($order->get_billing_email());
        }
        $order->update_meta_data('gehaOrder', 'yes');
        $user_id = $order->get_user_id();
        update_user_meta($user_id, 'geha_user', 'yes');
    } else {
        if (get_user_meta($order->get_user_id(), 'geha_user', true) == 'yes') {
            $order->update_meta_data('gehaOrder', 'yes');
        } else {
            $order->update_meta_data('gehaOrder', 'no');
        }
    }
    if ($threeWay) {
        $order->update_meta_data('threeWayShipment', 'yes');
    }
    if ($dentistOrder!='') {
        $order->update_meta_data('dentistOrder', $dentistOrder);
        $order->update_meta_data('affwp_ref', $_COOKIE['access_code']);
        $user_id = $order->get_user_id();
        update_user_meta($user_id, 'dentist_user', $dentistOrder);
    }
    $order->save();
    // echo '<pre>';
    // print_r($order);
    // echo '</pre>';
}

if (!function_exists('sbr_geha_experiment')) {

    function sbr_geha_experiment($param = array())
    {
        global $wpdb;
        $data = array(
            "variant" => isset($param['variant']) ? $param['variant'] : 0,
            "email_address" => isset($param['email_address']) ? $param['email_address'] : 0,
            "item_id" => 0,
            "created_date" => date("Y-m-d h:i:sa"),
        );
        $wpdb->insert('sbr_geha_experiment', $data);
        return $wpdb->insert_id;
    }
}
if (!function_exists('sbr_update_geha_experiment')) {
    function sbr_update_geha_experiment($param = array())
    {
        global $wpdb;
        $update = array(
            'item_id' => $param['item_id'],
        );
        $condition = array(
            "id" => isset($param['id']) ? $param['id'] : 0,
        );
        $wpdb->update('sbr_geha_experiment', $update, $condition);
    }
}
function woocommerce_custom_price_to_cart_item_geha($cart_object)
{

    foreach ($cart_object->cart_contents as $key => $value) {
        if (isset($value["gehaVariant"]) && $value["gehaVariant"] == 'yes') {

            $value['data']->set_price(37.45);
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item_geha', 99);


function gehaUserAddUpdateURL($billing_email)
{
    $user_id = username_exists($billing_email);
    if (!$user_id && false == email_exists($billing_email)) {
        $random_password = wp_generate_password($length = 12, false);
        $user_id = wp_create_user($billing_email, $random_password, $billing_email);
        $user_data = new WP_User($user_id);
        $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
        $user_data->add_role('customer');
        update_user_meta($user_id, 'geha_user', 'yes');
        update_user_meta($user_id, "billing_email", $billing_email);

        clean_user_cache($user_id);
        wp_clear_auth_cookie();
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, false);
        update_user_caches($user_data);
    } else {
        $user_data = get_user_by('email', $billing_email);
        $user_id = $user_data->ID;
        ///$user_data = new WP_User($user_id);
        update_user_meta($user_data->ID, 'geha_user', 'yes');
        if (!in_array('administrator', (array) $user_data->roles) && in_array('customer', (array) $user_data->roles)) {
            clean_user_cache($user_id);
            wp_clear_auth_cookie();
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id, true, false);
            update_user_caches($user_data);
        }
    }
    setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
    if (function_exists('klaviyo_geha_customer_list')) {
        klaviyo_geha_customer_list($billing_email);
    }
}


function klaviyo_geha_customer_list($billing_email)
{
   
    $list_id = 'HAtTUL';
    //$phone_number = '+15005550006'; // Optional
    
     $response = addProfileToKlaviyoList(KLAVIYO_API_KEY_CURL_GEHA, $list_id, $billing_email,null);
    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://a.klaviyo.com/api/v2/list/HAtTUL/members?api_key=pk_aafe4c7dcacd640e5940145508c0dec1bc',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => '{"email":"' . $billing_email . '","profiles":{"email":"' . $billing_email . '"}}',
    //     CURLOPT_HTTPHEADER => array(
    //         'Content-Type: application/json'
    //     ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
}
