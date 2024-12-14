<?php

/**
 * Add action hook to initialize and retrieve custom coupon code to session.
 */
add_action('init', 'get_custom_coupon_code_to_session');

/**
 * Retrieve and set custom coupon code to the session if provided in the URL.
 */
function get_custom_coupon_code_to_session()
{
  if (isset($_GET['coupon'])) {
    // Ensure that customer session is started
    if (isset(WC()->session) && !WC()->session->has_session())
      WC()->session->set_customer_session_cookie(true);

    // Check and register coupon code in a custom session variable
    $coupon_code = WC()->session->get('coupon_code');
    if (empty($coupon_code)) {
      $coupon_code = esc_attr($_GET['coupon']);
      WC()->session->set('coupon_code', $coupon_code); // Set the coupon code in session
    }
  }
}

/**
 * Add action hook to display discount on the checkout page.
 */
add_action('woocommerce_before_checkout_form', 'add_discout_to_checkout', 10, 0);

/**
 * Apply discount to the checkout if a coupon code is set in the session.
 */

function add_discout_to_checkout()
{
  // Set coupon code
  $coupon_code = WC()->session->get('coupon_code');
  if (!empty($coupon_code) && !WC()->cart->has_discount($coupon_code)) {
    WC()->cart->add_discount($coupon_code); // apply the coupon discount
    WC()->session->__unset('coupon_code'); // remove coupon code from session
  }
}
