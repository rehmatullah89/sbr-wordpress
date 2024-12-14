<?php

add_action('template_redirect', 'verify_geha_customer_url');
/**
 * Verifies GEHA customer URL and processes the associated actions.
 *
 * @return void
 */
function verify_geha_customer_url() {
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
                        //// $checkout_url = site_url('checkout') . '?add-to-cart=' . $geha_data[2] . '&quantity=' . $geha_data[3] . '&email=' . $geha_data[1];
                    } else {
                        ///  $checkout_url = site_url('checkout') . '?add-to-cart=' . $geha_data[2] . '&quantity=1&email=' . $geha_data[1];
                        $quantity = 1;
                    }
                    WC()->cart->empty_cart();
                    $product_id = $geha_data[2];
                    $cart_item_data = array('geha-checkout' => 'yes');
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
/**
 * Prefills WooCommerce checkout fields based on query string parameters.
 *
 * @param array $checkout_fields The array of checkout fields.
 * @return array The modified array of checkout fields.
 */
function smile_brillaint_prefill_checkout_fields($checkout_fields) {

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
