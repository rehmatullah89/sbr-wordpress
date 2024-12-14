<?php

/**
 * Update composite item quantities in the cart before calculating totals.
 *
 * @action woocommerce_before_calculate_totals
 */
add_action('woocommerce_before_calculate_totals', 'composite_dataQty_updateCallback');

/**
 * Callback function to update composite item quantities in the cart.
 */
function composite_dataQty_updateCallback()
{

    if (!WC()->cart->is_empty()) {
        $cartChildItemKeys = array();
        $updateChildQty = array();
        $cartObj = WC()->cart->get_cart();
        foreach ($cartObj as $cart_item_key => $cart_item) {
            $quantity = $cart_item['quantity'];

            if (isset($cart_item['composite_children'])) {
                foreach ($cart_item['composite_children'] as $composite_children) {
                    $cartChildItemKeys[$composite_children] = $quantity;
                }
                foreach ($cart_item['composite_data'] as $composite_key => $composite_data) {
                    $updateChildQty[$composite_key] = isset($composite_data['quantity_min']) ? $composite_data['quantity_min'] : 1;
                }
            }
        }

        foreach ($cartObj as $cart_item_key => $cart_item) {
            //if (isset($updateChildQty[$cart_item['composite_item']]) && isset($cartChildItemKeys[$cart_item_key])) {
            if (isset($cart_item['composite_item']) && isset($updateChildQty[$cart_item['composite_item']]) && isset($cartChildItemKeys[$cart_item_key])) {
                $updatedQty = $cartChildItemKeys[$cart_item_key]  * $updateChildQty[$cart_item['composite_item']];
                if ($updatedQty  != $cart_item['quantity']) {
                    WC()->cart->set_quantity($cart_item_key,  $updatedQty);
                }
            }
        }
    }
}

add_filter('woocommerce_terms_is_checked_default', '__return_true');
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');
add_filter('woocommerce_create_account_default_checked', '__return_true');

//add_filter( 'woocommerce_registration_auth_new_customer', '__return_false' );


add_filter('woocommerce_order_item_visible', 'wc_cp_order_item_visible', 10, 2);
add_filter('woocommerce_widget_cart_item_visible', 'wc_cp_cart_item_visible', 10, 3);
add_filter('woocommerce_cart_item_visible', 'wc_cp_cart_item_visible', 10, 3);
add_filter('woocommerce_checkout_cart_item_visible', 'wc_cp_cart_item_visible', 10, 3);

/** Visibility of components in orders.
 *
 * @param  boolean $visible
 * @param  array   $order_item
 * @return boolean
 */
function wc_cp_order_item_visible($visible, $order_item)
{

    if (!empty($order_item['composite_parent'])) {
        $visible = false;
    }

    return $visible;
}

/**
 * Visibility of components in cart.
 *
 * @param  boolean $visible
 * @param  array   $cart_item
 * @param  string  $cart_item_key
 * @return boolean
 */
function wc_cp_cart_item_visible($visible, $cart_item, $cart_item_key)
{

    if (!empty($cart_item['composite_parent'])) {
        $visible = false;
    }

    return $visible;
}

/**
 * Register guest users after an order is placed.
 *
 * @param int $order_id The ID of the order.
 */
function wc_register_guests($order_id)
{
    // get all the order data
    $order = new WC_Order($order_id);

    //get the user email from the order
    $order_email = $order->get_billing_email();

    // check if there are any users with the billing email as user or email
    $email = email_exists($order_email);
    $user = username_exists($order_email);

    // if the UID is null, then it's a guest checkout
    if ($user == false && $email == false) {

        // random password with 12 chars
        $random_password = wp_generate_password();

        // create new user with email as username & newly created pw
        $user_id = wp_create_user($order_email, $random_password, $order_email);

        //WC guest customer identification
        update_user_meta($user_id, 'guest', 'yes');

        //user's billing data
        update_user_meta($user_id, 'billing_address_1', $order->get_billing_address_1());
        update_user_meta($user_id, 'billing_address_2', $order->get_billing_address_2());
        update_user_meta($user_id, 'billing_city', $order->get_billing_city());
        update_user_meta($user_id, 'billing_country', $order->get_billing_country());
        update_user_meta($user_id, 'billing_email', $order->get_billing_email());
        update_user_meta($user_id, 'billing_first_name', $order->get_billing_first_name());
        update_user_meta($user_id, 'billing_last_name', $order->get_billing_last_name());
        update_user_meta($user_id, 'billing_phone', $order->get_billing_phone());
        update_user_meta($user_id, 'billing_postcode', $order->get_billing_postcode());
        update_user_meta($user_id, 'billing_state', $order->get_billing_state());

        // user's shipping data
        update_user_meta($user_id, 'shipping_address_1', $order->get_shipping_address_1());
        update_user_meta($user_id, 'shipping_address_2', $order->get_shipping_address_2());
        update_user_meta($user_id, 'shipping_city', $order->get_shipping_city());
        update_user_meta($user_id, 'shipping_country', $order->get_shipping_country());
        update_user_meta($user_id, 'shipping_first_name', $order->get_shipping_first_name());
        update_user_meta($user_id, 'shipping_last_name', $order->get_shipping_last_name());
        update_user_meta($user_id, 'shipping_method', $order->get_shipping_method());
        update_user_meta($user_id, 'shipping_postcode', $order->get_shipping_postcode());
        update_user_meta($user_id, 'shipping_state', $order->get_shipping_state());
        // link past orders to this newly created customer
        wc_update_new_customer_past_orders($user_id);
    }
}

//add this newly created function to the thank you page
add_action('woocommerce_thankyou', 'wc_register_guests', 10, 1);


add_filter( 'woocommerce_cart_item_price', 'filter_cart_item_price', 10, 3 );
function filter_cart_item_price( $price_html, $cart_item, $cart_item_key ) {
    if( $cart_item['data']->is_on_sale() ) {
        return $cart_item['data']->get_price_html();
    }
    return $price_html;
}

add_filter( 'woocommerce_cart_item_subtotal', 'filter_cart_item_subtotal', 1, 3 );
function filter_cart_item_subtotal( $subtotal_html, $cart_item, $cart_item_key ) {
    $product    = $cart_item['data'];
    $quantity   = $cart_item['quantity'];
    $tax_string = '';

    $regular_price = $product->get_regular_price() * $quantity;
    $active_price  = $product->get_price() * $quantity;
    //subscription#RB
    if(isset($cart_item['arbid'])){
        $sale_price_html = '<ins>' . ( is_numeric( $active_price ) ? wc_price( $active_price ) : $active_price ) . '</ins>'; 
        return $sale_price_html . $tax_string;
    }
    if ( $product->is_on_sale() ) {
        $sale_price_html = wc_format_sale_price( $regular_price, $active_price ) . $product->get_price_suffix();
        return $sale_price_html . $tax_string;
    }

    return $subtotal_html;
}
