<?php

/*
  Plugin Name: Smile brilliant
  Plugin URI: http://www.mindblaze.net/
  Description: Smile brilliant
  Author: Mindblazetech
  Version: 1.0
  Author URI: http://www.mindblaze.net/
 */
//date_default_timezone_set('America/Chicago');

/**
 * Create a new customer.
 *
 * @param  string $email    Customer email.
 * @param  string $username Customer username.
 * @param  string $password Customer password.
 * @param  array  $args     List of arguments to pass to `wp_insert_user()`.
 * @return int|WP_Error Returns WP_Error on failure, Int (user ID) on success.
 */

if (!function_exists('wc_create_new_customer')) {

    function wc_create_new_customer($email, $username = '', $password = '', $args = array())
    {
        if (empty($email) || !is_email($email)) {
            return new WP_Error('registration-error-invalid-email', __('Please provide a valid email address no.', 'woocommerce'));
        }

        if (email_exists($email)) {
            $SearchUser = get_user_by('email', $email);
            $user_roles = $SearchUser->roles;
            if (isset($_POST['createaccount']) && $_POST['createaccount'] == 1 && !in_array('administrator', $user_roles, true)) {
                //
            } else {
                return new WP_Error('registration-error-email-exists', apply_filters('woocommerce_registration_error_email_exists', __('An account is already registered with your email address. <a href="#" class="showlogin">Please log in.</a>', 'woocommerce'), $email));
            }
        }

        if ('yes' === get_option('woocommerce_registration_generate_username', 'yes') && empty($username)) {

            $username = wc_create_new_customer_username($email, $args);
        }

        $username = sanitize_user($username);

        if (empty($username) || !validate_username($username)) {

            return new WP_Error('registration-error-invalid-username', __('Please enter a valid account username.', 'woocommerce'));
        }

        if (username_exists($username)) {
            $SearchUser = get_user_by('login', $username);
            $user_roles = $SearchUser->roles;
            if (isset($_POST['createaccount']) && $_POST['createaccount'] == 1 && !in_array('administrator', $user_roles, true)) {
                //
            } else {
                return new WP_Error('registration-error-username-exists', __('An account is already registered with that username 2. Please choose another.', 'woocommerce'));
            }
        }


        // Handle password creation.
        $password_generated = false;
        if ('yes' === get_option('woocommerce_registration_generate_password') && empty($password)) {

            $password = wp_generate_password();
            $password_generated = true;
        }

        if (empty($password)) {

            return new WP_Error('registration-error-missing-password', __('Please enter an account password.', 'woocommerce'));
        }

        // Use WP_Error to handle registration errors.

        $errors = new WP_Error();
        do_action('woocommerce_register_post', $username, $email, $errors);
        $errors = apply_filters('woocommerce_registration_errors', $errors, $username, $email);
        if ($errors->get_error_code()) {

            return $errors;
        }

        $new_customer_data = apply_filters(
            'woocommerce_new_customer_data',
            array_merge(
                $args,
                array(
                    'user_login' => $username,
                    'user_pass' => $password,
                    'user_email' => $email,
                    'role' => 'customer',
                )
            )
        );
        $customer_id = wp_insert_user($new_customer_data);

        if (is_wp_error($customer_id)) {

            if (isset($customer_id->errors['existing_user_email'])) {
                $SearchUser = get_user_by('email', $email);
                $user_roles = $SearchUser->roles;
                if (in_array('administrator', $user_roles, true)) {
                    return $customer_id;
                }
                $customer_id = isset($SearchUser->ID) ? $SearchUser->ID : $customer_id;
            }
            if (isset($customer_id->errors['existing_user_login'])) {
                $SearchUser = get_user_by('login', $email);
                $user_roles = $SearchUser->roles;
                if (in_array('administrator', $user_roles, true)) {
                    return $customer_id;
                }
                $customer_id = isset($SearchUser->ID) ? $SearchUser->ID : $customer_id;
            }


            return $customer_id;
        }

        do_action('woocommerce_created_customer', $customer_id, $new_customer_data, $password_generated);

        return $customer_id;
    }
}

/*
  B1G1 product search fixes
 */
add_action('wp_ajax_acfw_search_products', 'acfw_search_products_mbt');

function acfw_search_products_mbt()
{
    global $wpdb;
    global $post;
    $sql = "SELECT ID,post_title FROM wp_posts INNER JOIN wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id WHERE post_type='product' AND post_title LIKE '%" . $_GET['term'] . "%' AND post_status='publish' AND wp_term_relationships.term_taxonomy_id=20";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $output = array();
    if (is_array($results) && count($results) > 0) {
        foreach ($results as $res) {
            $output[$res['ID']] = $res['post_title'];
        }
    }
    echo json_encode($output);
    die();
}

if (!function_exists('wp_password_change_notification')) {

    function wp_password_change_notification()
    {
    }
}

/**
 * Action hooked to 'woocommerce_thankyou' to handle secure payments.
 *
 * @param int $order_id The ID of the order.
 */
add_action('woocommerce_thankyou', function ($order_id) {
    $secure_payment = isset($_COOKIE['logged_in_user_mbt']) ? $_COOKIE['logged_in_user_mbt'] : '';
    $current_user_id = get_current_user_id();
    if ($secure_payment == $current_user_id) {
        //
    } else {
        $sessions = WP_Session_Tokens::get_instance($current_user_id);
        $sessions->destroy_all();
    }
});

/**
 * Function to get the legacy WooCommerce order number.
 *
 * @param string $this_get_id The current order ID.
 * @param object $instance The WooCommerce order instance.
 * @return string The legacy order number or the current order ID if not available.
 */
function lagacy_woocommerce_order_number($this_get_id, $instance)
{
    $lagacy_order_number = get_post_meta($instance->get_id(), 'order_number', true);
    if ($lagacy_order_number != '') {
        return $lagacy_order_number;
    } else {
        return $this_get_id;
    }
}

// add the filter 
add_filter('woocommerce_order_number', 'lagacy_woocommerce_order_number', 999, 2);
define('P_O', "");
define('SB_PO', "sbr_po_order");
define('SB_PP', "sbr_po_products");
define('SB_PO_LOG', "sbr_po_log");
define('SB_POSTAGE_REFUND', "sb_refund_request");
define('SB_ORDER_TABLE', "sb_order_information");
define('SB_SHIPPING_TABLE', "sb_shipping_information");
if (!defined('SB_EASYPOST_BATCH_TABLE')) {
   define('SB_EASYPOST_BATCH_TABLE', "sb_shipment_batch");
}
if (!defined('SB_EASYPOST_TABLE')) {
    define('SB_EASYPOST_TABLE', "sb_easypost_shipments");
 }
define('SB_ZENDESK_TABLE', "sb_order_zendesk");
define('SB_SHIPMENT_ORDERS_TABLE', "sbr_shipment_orders");
define('SB_PRINT_REQUEST_TABLE', "sb_print_requests");
define('SB_PRINT_REQUESTS_ORDER_TABLE', "sb_print_order_logs");
define('SB_DOWNLOAD', site_url('/downloads/'));
define('SB_LOG', "sb_event_log");
define('SB_EVENT', "sb_event_type");
define('ZENDESK_TBL', "mbt_zendesk_ticket");
define('ZENDESK_META_TBL', "mbt_zendesk_ticket_meta");



define('MBT_ZENDESK_HOST', get_field('mbt_zendesk_host', 'option'));
define('MBT_ZENDESK_USERPWD', get_field('mbt_zendesk_user', 'option') . ":" . get_field('mbt_zendesk_password', 'option'));
define('MBT_ZENDESK_AGENT', get_field('mbt_zendesk_agent', 'option'));


if (get_field('easypost_environment', 'option') == 'live') {
    define('SB_EASYPOST_API_KEY', get_field('easypost_live_api_key', 'option'));
} else {
    define('SB_EASYPOST_API_KEY', get_field('easypost_test_api_key', 'option'));
}

require __DIR__ . '/inc/admin-menu.php'; // ADDED
require __DIR__ . '/inc/product-meta.php'; // ADDED
require __DIR__ . '/inc/product-review.php'; // ADDED
require __DIR__ . '/inc/cart.php'; // ADDED
require __DIR__ . '/inc/coupon.php'; // ADDED
require __DIR__ . '/inc/ajax-calls.php'; // ADDED
require __DIR__ . '/inc/admin-order.php'; // ADDED
require __DIR__ . '/inc/order-item.php'; // ADDED
require __DIR__ . '/inc/add-shipment.php'; // ADDED
require __DIR__ . '/inc/shipment.php'; // ADDED
require __DIR__ . '/inc/split-order.php'; // ADDED
require __DIR__ . '/inc/addOn.php'; // ADDED
require __DIR__ . '/inc/contact-customer.php'; // ADDED
require __DIR__ . '/inc/woo-functions.php'; // ADDED
require __DIR__ . '/inc/zendesk.php';  // ADDED
require __DIR__ . '/inc/warranty.php'; // ADDED
require __DIR__ . '/inc/ajax-js.php'; // ADDED
require __DIR__ . '/inc/batch_printing.php'; // ADDED
require __DIR__ . '/inc/admin-zendesk.php'; // ADDED
require __DIR__ . '/inc/order-shipments.php'; // ADDED
require __DIR__ . '/inc/easypost-calls.php';
require __DIR__ . '/inc/shipment-detail.php'; // ADDED
require __DIR__ . '/inc/authorize-net.php'; // ADDED
require __DIR__ . '/inc/print-download-labels.php'; // ADDED
require __DIR__ . '/inc/batch-printing-second-shipment.php'; // ADDED
require __DIR__ . '/inc/refund-postage.php'; // ADDED
require __DIR__ . '/inc/twillio.php'; // ADDED
require __DIR__ . '/inc/db.php'; // ADDED
require __DIR__ . '/inc/ims.php'; // ADDED
require __DIR__ . '/inc/sale.php'; // ADDED
require __DIR__ . '/inc/rdh.php'; // ADDED
require __DIR__ . '/inc/shipment-enhancement.php'; // ADDED
require __DIR__ . '/inc/googleOptimize.php';  // ADDED
require __DIR__ . '/inc/mini-cart.php'; // ADDED
require __DIR__ . '/inc/bogo.php'; // ADDED
require __DIR__ . '/inc/seo.php'; // ADDED
require __DIR__ . '/inc/manage-package.php';  // ADDED
require __DIR__ . '/inc/custom-postage.php'; // ADDED
require __DIR__ . '/inc/updated-batch-system.php'; // ADDED
require __DIR__ . '/inc/subscriptions.php';


/**
 * Add custom email classes to WooCommerce.
 *
 * @param array $email_classes WooCommerce email classes.
 * @return array Modified WooCommerce email classes.
 */
function add_easypost_shipment_order_woocommerce_email($email_classes)
{

    // include our custom email class
    require_once('inc/shipment-email.php'); // ADDED

    // add the email class to the list of email classes that WooCommerce loads
    $email_classes['WC_Shipment_Order_Email'] = new WC_Shipment_Order_Email();
    $email_classes['WC_Dental_Impressions_Received_Email'] = new WC_Dental_Impressions_Received_Email();
    $email_classes['WC_RDH_Register_Email'] = new WC_RDH_Register_Email();
    $email_classes['RDH_Contact_Email'] = new RDH_Contact_Email();
    $email_classes['GEHA_SignUp_Email'] = new GEHA_SignUp_Email();
    $email_classes['Insurance_SignUp_Email'] = new Insurance_SignUp_Email();

    return $email_classes;
}

add_filter('woocommerce_email_classes', 'add_easypost_shipment_order_woocommerce_email');
add_action('admin_enqueue_scripts', 'sb_admin_scripts', 11);
add_action('acf/init', 'api_environment_init');

/**
 * Initialize API environment options pages using ACF.
 */
function api_environment_init()
{

    // Check function exists.
    if (function_exists('acf_add_options_page')) {
        // Register options page.
        acf_add_options_page(array(
            'page_title' => __('SBR Settings'),
            'menu_title' => __('SBR Settings'),
            'menu_slug' => 'sbr-settings',
            'capability' => 'manage_options',
            'redirect' => false
        ));
        acf_add_options_sub_page(array(
            'page_title' => __('API Settings'),
            'menu_title' => __('API Settings'),
            'menu_slug' => 'apis-settings',
            'capability' => 'manage_options',
            'parent_slug' => 'sbr-settings',
            'redirect' => false
        ));
        acf_add_options_page(array(
            'page_title'     => 'Fraudulent domain',
            'menu_title'    => 'Fraudulent domain',
            'menu_slug'     => 'fraudulent-domain',
            'capability'    => 'manage_options',
            'redirect'        => false
        ));
        acf_add_options_sub_page(array(
            'page_title'     => 'BOGO/Upsell',
            'menu_title'    => 'BOGO/Upsell',
            'menu_slug'     => 'offer-deals',
            'capability'    => 'manage_options',
            'parent_slug' => 'sbr-settings',
            'redirect'        => false
        ));
        acf_add_options_sub_page(array(
            'page_title'     => 'SMS',
            'menu_title'    => 'SMS',
            'menu_slug'     => 'sms',
            'capability'    => 'manage_options',
            'parent_slug' => 'sbr-settings',
            'redirect'        => false
        ));
        acf_add_options_sub_page(array(
            'page_title'     => 'Shine Discounts',
            'menu_title'    => 'Shine Discounts',
            'menu_slug'     => 'shine-discounts',
            'capability'    => 'manage_options',
            'parent_slug' => 'sbr-settings',
            'redirect'        => false
        ));
    }
}
/**
 * Select EasyPost method based on order method and service.
 *
 * @param int $method_id Shipping method ID.
 * @param string $method Shipping method (e.g., 'USPS' or 'UPS').
 * @return mixed|string|false EasyPost method or false if not found.
 */
function selectEasyPostMethodByOrderMethod($method_id, $method = 'USPS')
{

    if ($method === 'USPS') {
        $defind_methods = array(
            5 => 'FirstClassPackageInternationalService', //USPS First Class International (7 - 14 Days)
            6 => 'PriorityMailInternational', //USPS Priority International (6 - 10 Days)
            11 => 'First', //USPS First Class Mail (3 - 5 Day)
            12 => 'Priority', //USPS Priority Mail (2 - 3 Day)
            8 => 'Priority', //USPS Priority Mail (w/Signature Confirm)
            9 => 'Express', //USPS Express (1 - 2 Day)
        );
    } else {
        $defind_methods = array(
            17 => 'NextDayAirSaver',
            18 => 'NextDayAir',
            19 => '3DaySelect',
            20 => '2ndDayAirAM',
            21 => 'Ground',
            22 => 'NextDayAirEarlyAM',
            23 => '2ndDayAir',
            14 => 'UPSSaver', //UPS Economy (3 - 6 Weeks)
            15 => 'Express', //UPS Express (2 - 3 Day)
            16 => 'Expedited', //UPS Expedited (3 - 5 Day)
        );
    }

    if (isset($defind_methods[$method_id])) {
        return $defind_methods[$method_id];
    } else {
        return false;
    }
}
/**
 * Get the Smile Brilliant from address.
 *
 * @return array An array containing Smile Brilliant from address details.
 */
function smile_brillaint_from_address()
{
    return array(
        'name' => 'Smile Brilliant Inc',
        'street1' => '1645 Headland Dr',
        'street2' => '',
        'city' => 'Fenton',
        'state' => 'MO',
        'zip' => '63026',
        'country' => 'US',
        'phone' => '855-944-8361',
        'email' => 'support@smilebrilliant.com'
    );
}

define('SB_ZENDESK_HOST', "smilebrilliant");
define('SB_ZENDESK_USERPWD', "support@smilebrilliant.com:xlma2190");
define('SB_ZENDESK_AGENT', 900385629303);

if (get_option('woocommerce_authorize_net_cim_credit_card_settings')) {
    $authorize_net_cim_setting_mbt = get_option('woocommerce_authorize_net_cim_credit_card_settings');
    if (isset($authorize_net_cim_setting_mbt['environment'])) {
        $env = $authorize_net_cim_setting_mbt['environment'];
        if ($env == 'test') {
            $mbt_api_login_id = $authorize_net_cim_setting_mbt['test_api_login_id'];
            $mbt_api_transaction_key = $authorize_net_cim_setting_mbt['test_api_transaction_key'];
            $mbt_api_signature_key = $authorize_net_cim_setting_mbt['test_api_signature_key'];
            define('SB_AUTHORIZE_ENV', 'testMode');
            define('SB_AUTHORIZE_ENV_URL', 'https://apitest.authorize.net/xml/v1/request.api');
            define('SB_AUTHORIZE_LOGIN_ID', $mbt_api_login_id);
            define('SB_AUTHORIZE_TRANSACTION_KEY', $mbt_api_transaction_key);
            define('SB_AUTHORIZE_SIGNATURE_KEY', $mbt_api_signature_key);
            define('USER_CIM_PROFILE_ID', "wc_authorize_net_cim_customer_profile_id_test");
        } else {
            $mbt_api_login_id = $authorize_net_cim_setting_mbt['api_login_id'];
            $mbt_api_transaction_key = $authorize_net_cim_setting_mbt['api_transaction_key'];
            $mbt_api_signature_key = $authorize_net_cim_setting_mbt['api_signature_key'];
            define('SB_AUTHORIZE_ENV', 'liveMode');
            define('SB_AUTHORIZE_ENV_URL', 'https://api.authorize.net/xml/v1/request.api');
            define('SB_AUTHORIZE_LOGIN_ID', $mbt_api_login_id);
            define('SB_AUTHORIZE_TRANSACTION_KEY', $mbt_api_transaction_key);
            define('SB_AUTHORIZE_SIGNATURE_KEY', $mbt_api_signature_key);
            define('USER_CIM_PROFILE_ID', "wc_authorize_net_cim_customer_profile_id");
        }
    }
}

/**
 * Enqueue admin scripts.
 */
//define('SB_ZENDESK_USERPWD', "amir.shah@agilitycollective.com:xlma2190");
function sb_admin_scripts()
{
    global $post_type;
    $version = time();
    $shipping_method_id = 0;
    $shipmentMethodAutoSelect = 0;
    wp_enqueue_script('sb', plugins_url('smile-brilliant/assets/js/') . 'sb.js?v=' . $version, false);
    wp_enqueue_style('select2');
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'));
    wp_enqueue_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js', array('jquery'));

    if ($post_type == 'shop_order') {
        if (isset($_REQUEST['post'])) {

            wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
            wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
            // \_WP_Editors::enqueue_scripts();
            //print_footer_scripts();
            //\_WP_Editors::editor_js();
            $order_id = $_REQUEST['post'];
            $order = wc_get_order($order_id);


            foreach ($order->get_items('shipping') as $item_id => $item) {
                $shipping_method_id = $item->get_instance_id(); // The method ID
            }
            $shipmentMethodAutoSelect = selectEasyPostMethodByOrderMethod($shipping_method_id);
        }
    }
    global $MbtPackaging;
    $packageHtml = '';
    $get_all_packages = $MbtPackaging->get_all_packages();
    $package_options = '<option value="0">Select Package</option>';
    if ($get_all_packages) {
        foreach ($get_all_packages as $package) {
            $mark = '';
            $package_options .= '<option  value="' . $package->id . '" ' . $mark . '>' . $package->name . '</option>';
        }
    }
    $packageHtml = '<h4 style="text-align:center;margin: unset;margin-bottom: 5px;">Oops. No package found. Please select package</h4><select id="shipment_package_id" name="shipment_package_id" class="shipment_package_id">' . $package_options . '</select>';

    wp_localize_script(
        'sb',
        'sb_object',
        array(
            'searchStateByCountryCode' => add_query_arg(array('action' => 'searchStateByCountryCode'), admin_url('admin-ajax.php')),
            'shipmentMethod' => $shipmentMethodAutoSelect,
            'sbr_packages' => $packageHtml,
        )
    );


    wp_enqueue_script('jquery-blockui');

    wp_enqueue_style('sb', plugins_url('smile-brilliant/assets/css/') . 'sb.css?v=' . $version, false);
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'));
    wp_enqueue_style('sweetalert2', plugins_url('smile-brilliant/assets/css/') . 'sweetalert2.css?v=' . $version, false);
    wp_enqueue_script('sweetalert2', plugins_url('smile-brilliant/assets/js/') . 'sweetalert2.js?v=' . $version, '1.0.0', true);
}
/**
 * Log various parameters and events for Smile Brilliant.
 *
 * @param array $param An associative array containing various parameters and event details to log.
 *                     Parameters include 'tray_number', 'order_id', 'child_order_id', 'item_id', 'product_id',
 *                     'event_id', 'status', 'warranty_claim_id', 'tracking_code', 'shipping_date',
 *                     'impression_received_date', 'shipping_information', 'is_change_shipping'.
 *                     The log is created with a timestamp in the 'created_date' field.
 */
function sb_log($param)
{
    $event_data = array(
        "tray_number" => $param['tray_number'],
        "order_id" => $param['order_id'],
        "child_order_id" => $param['child_order_id'],
        "item_id" => $param['item_id'],
        "product_id" => $param['product_id'],
        "event_id" => $param['event_id'],
        "status" => $param['status'],
        "warranty_claim_id" => $param['warranty_claim_id'],
        "tracking_code" => $param['tracking_code'],
        "shipping_date" => $param['shipping_date'],
        "impression_received_date" => $param['impression_received_date'],
        "shipping_information" => $param['shipping_information'],
        "is_change_shipping" => $param['is_change_shipping'],
        "created_date" => date("Y-m-d h:i:sa"),
    );
    sb_create_log($event_data);
}
/**
 * Log messages related to Smile Brilliant in a log file.
 *
 * @param int|string $order_id The order ID associated with the log entry.
 * @param string|array $message The log message or an array of messages to be logged.
 *                              If an array, it will be JSON-encoded before logging.
 */
function smile_brillaint_logs($order_id, $message)
{
    if (is_array($message)) {
        $message = json_encode($message);
    }
    $log_year = date('Y');
    $log_month = date('m');
    $logs_dir = __DIR__ . '/logs/' . $log_year . '/' . $log_month . '/';
    if (!is_dir($logs_dir)) {
        mkdir($logs_dir, 0755, true);
    }
    $log_file = $logs_dir . $order_id . '.log';
    $file = fopen($log_file, "a");
    fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: User ID => " . get_current_user_id());
    fwrite($file, "\n"  . $message);
    fclose($file);
}
/**
 * Modify the body classes for specific WordPress pages based on the post ID.
 *
 * @param array $classes An array of existing body classes.
 * @return array The modified array of body classes.
 */
function smile_brillaint_body_classes($classes)
{
    if (get_the_id() == 711183 || get_the_id() == 711181 || get_the_id() == 711822) {
        $classes[] = 'body-plaque-highlighter';
    }
    if (get_the_id() == 711181 || get_the_id() == 711822) {
        $classes[] = 'body-plaque-highlighter-kids';
    }

    if (get_the_id() == 427572) {
        $classes[] = 'product-teeth-whitening-trays';
    }

    if (get_the_id() == 427574 || get_the_id() == 745744) {
        $classes[] = 'product-teeth-whitening-gel';
    }

    if (get_the_id() == 427568 || get_the_id() == 745743) {
        $classes[] = 'product-sensitive-teeth-gel';
    }
    if (get_the_id() == 427575) {
        $classes[] = 'product-electric-toothbrush';
    }

    if (get_the_id() == 427576) {
        $classes[] = 'product-toothbrush-heads';
    }

    if (get_the_id() == 428535) {
        $classes[] = 'product-water-flosser';
    }
    if (get_the_id() == 427577) {
        $classes[] = 'product-night-guards';
    }

    if (get_the_id() == 172) {
        $classes[] = 'page-teeth-whitening-facts';
    }

    if (get_the_id() == 403946) {
        $classes[] = 'body-geha-partner-page';
    }

    if (get_the_id() == 711822 || get_the_id() == 711872 || get_the_id() == 752433 || get_the_id() == 856651) {
        $classes[] = 'body-dental-probiotics-kids';
    }

    if (get_the_id() == 711872 || get_the_id() == 752433 || get_the_id() == 856651) {
        $classes[] = 'body-dental-probiotics-adults';
    }

    if (get_the_id() == 746732) {
        $classes[] = 'body-retainer-cleaning-tablets';
    }
    if (get_the_id() == 752433 || get_the_id() == 814129 || get_the_id() == 856651) {
        $classes[] = 'body-enamel-armour-page';
    }
    if (get_the_id() == 782204) {
        $classes[] = 'body-retainer-cleaning-tablets sbrCariproUltrasonicCleaner';
    }

    if (get_the_id() == 814129) {
        $classes[] = 'body-stain-concealer';
    }

    if (get_the_id() == 856651) {
        $classes[] = 'body-dental-floss-picks';
    }

    return $classes;
}

add_filter('body_class', 'smile_brillaint_body_classes');


add_filter('woocommerce_rest_prepare_shop_order_object', 'klaviyo_request_for_remove_child_composite', 10, 3);
/**
 * Modify the WooCommerce REST API response for shop orders to remove child composite items.
 *
 * @param WP_REST_Response $response The REST API response object.
 * @param WP_Post $post The post object.
 * @param WP_REST_Request $request The REST API request object.
 * @return WP_REST_Response The modified REST API response object.
 */
function klaviyo_request_for_remove_child_composite($response, $post, $request)
{

    if (isset($response->data['line_items'])) {
        $compositeItems = array();
        foreach ($response->data['line_items'] as $line_items) {
            $product_type = get_the_terms($line_items['product_id'], 'product_type');
            foreach ($product_type as $term) {
                if ($term->slug == 'composite') {
                    $compositeItems[] = $line_items;
                }
            }
        }
        if (count($compositeItems) > 0) {
            $response->data['line_items'] = $compositeItems;
        }
    }
    return $response;
}




add_action('wp_ajax_register_user_sports', 'register_user_sports');
add_action('wp_ajax_nopriv_register_user_sports', 'register_user_sports');
/**
 * AJAX callback to register or update a user's sports information.
 */
function register_user_sports()
{

    $email = $_REQUEST['form_email'];
    $existing_user = get_user_by('email', $email);
    $user_flag = false;
    if ($existing_user) {
        // User exists, update user data.
        $user_id = $existing_user->ID;
        wp_update_user(array(
            'ID' => $user_id,
            'first_name' => $_REQUEST['first_name'],
            'last_name' => $_REQUEST['last_name'],
            // Update other fields as needed.
        ));
        $user_flag = true;
    } else {
        // User doesn't exist, register a new user.
        $user_id = wp_create_user($email, wp_generate_password(), $email);
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'first_name', $_REQUEST['first_name']);
            update_user_meta($user_id, 'last_name', $_REQUEST['last_name']);
            $user_flag = true;
            $emails = WC()->mailer()->get_emails();
            $respose =   $emails['WC_MOUTH_GUARD_Registration_Email']->trigger($user_id);
        } else {
            $user_flag = false;
        }
    }
    $response_data = array();
    if ($user_flag) {
        $impression_id = 'LS' . generate_unique_random_number();
        $primary_sport = $_REQUEST['primary_sport'];
        $interested_products = $_REQUEST['interested_products'];
        $dateString = $_REQUEST['year'] . "-" . $_REQUEST['month'] . "-" . $_REQUEST['day'];
        update_user_meta($user_id, '_dob', $dateString);
        update_user_meta($user_id, 'first_name', $_REQUEST['first_name']);
        update_user_meta($user_id, 'last_name', $_REQUEST['last_name']);
        update_user_meta($user_id, '_gender', $_REQUEST['gender']);
        add_3d_scanner_customer_details($user_id, $impression_id, $primary_sport);
        add_interested_products($impression_id, $interested_products);
        $scan_id = get_customer_3d_scan_id($user_id);
        // $response = send_twilio_text_sms($_REQUEST['phone'], $_REQUEST['first_name'] . ', we have confirmed your account registration with Smile Brilliant / ProShield! Your registration ID is ' . $scan_id . '. Please present this ID to your agent before they begin your scan. Login details have been emailed to your email address at ' . $_REQUEST["email"] . '.');
        update_user_meta($user_id, 'gender', $_REQUEST['gender']);
        update_user_meta($user_id, 'phone', $_REQUEST['phone']);
        update_user_meta($user_id, 'billing_address_1', $_REQUEST['form_address']);
        update_user_meta($user_id, 'billing_address_2', $_REQUEST['form_apartment']);
        update_user_meta($user_id, 'billing_city', $_REQUEST['form_city']);
        update_user_meta($user_id, 'billing_state', $_REQUEST['form_billing']);
        update_user_meta($user_id, 'billing_postcode', $_REQUEST['form_postal_code']);
        update_user_meta($user_id, 'billing_country', $_REQUEST['form_country']);
        update_user_meta($user_id, 'billing_phone', $_REQUEST['phone']);
        $existing_user = get_user_by('email', $email);
        $response_data =   get3dScanData($existing_user);
        $response_data['statusCode'] =  202;
    } else {
        $response_data['statusCode'] =  404;
    }
    echo json_encode($response_data);
    die;
}

add_action('wp_ajax_check_user_exists', 'check_user_exists');
add_action('wp_ajax_nopriv_check_user_exists', 'check_user_exists');
/**
 * AJAX callback to get 3D scan user's  information.
 */
function get3dScanData($user)
{
    $response_data = array();

    $first_name = get_user_meta($user->ID, 'first_name', true);
    $last_name = get_user_meta($user->ID, 'last_name', true);
    $dob = get_user_meta($user->ID, '_dob', true);
    $_gender = get_user_meta($user->ID, '_gender', true);
    $billing_address_1 = get_user_meta($user->ID, 'billing_address_1', true);
    $billing_address_2 = get_user_meta($user->ID, 'billing_address_2', true);
    $billing_city = get_user_meta($user->ID, 'billing_city', true);
    $billing_state = get_user_meta($user->ID, 'billing_state', true);
    $billing_postcode = get_user_meta($user->ID, 'billing_postcode', true);
    $billing_country = get_user_meta($user->ID, 'billing_country', true);
    $billing_phone = get_user_meta($user->ID, 'billing_phone', true);
    $billing_phone = get_user_meta($user->ID, 'billing_phone', true);
    // Get the tray number using the custom function get_customer_3d_scan_id()
    $scan3D = get_customer_3d_scan_id($user->ID);

    // Populate the response data array
    $response_data['user_id'] = $user->ID;
    $response_data['first_name'] = $first_name;
    $response_data['last_name'] = $last_name;
    $response_data['dob'] = $dob;
    if (!empty($dob)) {
        //   $dateString = "1950-01-01";
        $dateTimestamp = strtotime($dob);

        $year = date("Y", $dateTimestamp);
        $month = date("m", $dateTimestamp);
        $day = date("d", $dateTimestamp);


        $response_data['dob_y'] = $year; // Year with 4 digits
        $response_data['dob_m'] = $month; // Year with 4 digits
        $response_data['dob_d'] = $day; // Year with 4 digits
        // $response_data['dob']['m'] = date("m", strtotime($dob)); // Month with leading zero
        // $response_data['dob']['d'] = date("d", strtotime($dob)); // Day with leading zero
    }
    $response_data['email_address'] = $user->user_email;
    $response_data['gender'] = $_gender;
    $response_data['billing_address_1'] = $billing_address_1;
    $response_data['billing_address_2'] = $billing_address_2;
    $response_data['billing_city'] = $billing_city;
    $response_data['billing_state'] = $billing_state;
    $response_data['billing_postcode'] = $billing_postcode;
    $response_data['billing_country'] = $billing_country;
    $response_data['billing_phone'] = $billing_phone;
    $response_data['threed_scan_id'] = '';
    $response_data['tray_number'] = '';
    $response_data['customer_tray_number'] = '';
    $response_data['statusCode'] =  201;
    if ($scan3D) {
        $response_data['threed_scan_id'] = $scan3D;
        $response_data['customer_tray_number'] = $scan3D;
        $response_data['statusCode'] =  200;
    } else {
        $tray_data =  find_tray_numbers_by_email($user->user_email, $user->ID);
        if ($tray_data) {
            $response_data['tray_number'] = $tray_data;
            $response_data['customer_tray_number'] = $tray_data;
            $response_data['statusCode'] =  200;
        }
    }
    return $response_data;
}

/**
 * AJAX callback to check if a user exists and retrieve their data.
 */
function check_user_exists()
{
    // Get the username (email) from the AJAX request
    $username = isset($_REQUEST['user']) ? sanitize_text_field($_REQUEST['user']) : '';

    // Perform the user existence check
    $user = get_user_by('email', $username);

    // Prepare the response data array
    $response_data = array();

    if ($user) {
        // Get user meta data

        $response_data =   get3dScanData($user);
        // Send the response as JSON
        echo json_encode($response_data);
    } else {
        $response_data['statusCode'] =  404;
        echo json_encode($response_data);
    }
    // Always remember to exit after sending the response
    wp_die();
}
/**
 * Find tray number by email
 */
function find_tray_numbers_by_email($email, $user_id)
{
    global $wpdb;

    // Sanitize the email input to prevent SQL injection
    $email = sanitize_email($email);

    // Prepare an array to store individual tray numbers with commas
    $all_tray_numbers = array();
    // Query to retrieve tray numbers by user_id
    $unique_tray_numbers = $wpdb->get_col("SELECT DISTINCT  tray_number FROM " . SB_ORDER_TABLE . " WHERE user_id = $user_id");
    if (empty($unique_tray_numbers)) {
        // Query to retrieve tray numbers by emailAddress
        $trayNumber = $wpdb->get_col("SELECT  trayNumber FROM order_ WHERE emailAddress = '$email'");
        // Process the second database response to handle comma-separated values
        foreach ($trayNumber as $tray) {
            $comma_separated_trays = explode(',', $tray);
            $all_tray_numbers = array_merge($all_tray_numbers, $comma_separated_trays);
        }
        // Remove empty values
        $input_tray_numbers = array_filter($all_tray_numbers);
        $unique_tray_numbers = array_unique(array_merge($all_tray_numbers, $input_tray_numbers));
    }

    // Remove non-numeric characters from each element and reindex the array
    $unique_tray_numbers = array_values(array_map(function ($value) {
        return preg_replace('/[^0-9]/', '', $value);
    }, $unique_tray_numbers));
    $unique_tray_numbers = array_values(array_filter($unique_tray_numbers));

    return  implode(", ", $unique_tray_numbers);
}



add_action('wp_ajax_nopriv_add_partner_user', 'add_partner_user_callback');
add_action('wp_ajax_add_partner_user', 'add_partner_user_callback');
/**
 * AJAX callback to add a partner user and update their metadata.
 */
function add_partner_user_callback()
{
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $source = isset($_POST['source']) ? $_POST['source'] : '';
    $products = isset($_POST['products']) ? $_POST['products'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $campaign = isset($_POST['campaign']) ? $_POST['campaign'] : '';
    $medium = isset($_POST['medium']) ? $_POST['medium'] : '';


    if (isset($_REQUEST['insurance_lander'])) {
        $member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';
        $confirm_member_id = isset($_POST['confirm_member_id']) ? $_POST['confirm_member_id'] : '';
        if ($first_name == '' || $last_name == '' || $email == '' || $member_id == '' || $confirm_member_id == '') {
            $arr = array('status' => false, 'code' => 'All Fields Are required');
            echo json_encode($arr);
            die();
        }
        if ($member_id != $confirm_member_id) {
            $arr = array('status' => false, 'code' => 'Member id and confirm member id do not match');
            echo json_encode($arr);
            die();
        }
    } else {
        if ($first_name == '' || $email == '') {
            $arr = array('status' => false, 'code' => 'All Fields Are required');
            echo json_encode($arr);
            die();
        }
    }


    if (!is_email($email)) {
        $arr = array('status' => false, 'code' => 'Email is invalid');
        echo json_encode($arr);
        die;
    }
    if (is_array($products)) {
        $products_data =  implode(", ", $products);
    } else {
        $products_data = '';
    }

    $page_key = $source;
    $user_id = username_exists($email);
    if (!$user_id && false == email_exists($email)) {
        $random_password = wp_generate_password($length = 12, false);
        $user_id = wp_create_user($email, $random_password, $email);
        $user_data = new WP_User($user_id);
        $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
        $user_data->add_role('customer');
        update_user_meta($user_id, "billing_email", $email);
        update_user_meta($user_id, "billing_first_name", $first_name);
        update_user_meta($user_id, "billing_last_name", $last_name);
        update_user_meta($user_id, "first_name", $first_name);
        update_user_meta($user_id, "last_name", $last_name);

        if (isset($_REQUEST['insurance_lander'])) {
            $emails = WC()->mailer()->get_emails();
            if (strtolower($source) == 'geha') {
                $emails['GEHA_SignUp_Email']->trigger($user_id, $random_password);
                setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
                $_SESSION['geha_user'] = 'yes';
                set_transient('geha_user', 'yes', 365 * DAY_IN_SECONDS);
            } else {
                $emails['Insurance_SignUp_Email']->trigger($user_id, $random_password);
                setcookie('insurance_lander', 'yes', time() + (3600 * 24 * 360), '/');
                $_SESSION['insurance_lander'] = 'yes';
                set_transient('insurance_lander', 'yes', 365 * DAY_IN_SECONDS);
            }
        }
    } else {
        $user_data = new WP_User($user_id);
    }
    if (!in_array('administrator', (array) $user_data->roles) && in_array('customer', (array) $user_data->roles)) {
        clean_user_cache($user_id);
        // wp_clear_auth_cookie();
        // wp_set_current_user($user_id);
        // wp_set_auth_cookie($user_id, true, false);
        // update_user_caches($user_data);
    }
    $arr = array('customer_id' => $user_id, 'status' => true, 'source' => strtolower($source));

    if (isset($_REQUEST['insurance_lander'])) {
        update_user_meta($user_id, "member_id", $member_id);
        update_user_meta($user_id, "insurance_lander", $page_key);
    } else {
        update_user_meta($user_id, $page_key, 'yes');
        if (is_array($products)) {
            update_user_meta($user_id, "partner_products", $products);
        }
        setcookie($source, 'yes', time() + (3600 * 24 * 360), '/');
    }
    if (is_array($products)) {
        $data = '{
             "email": "' . $email . '",
             "profiles": {
                 "first_name": "' . $first_name . '",
                 "last_name":"' . $last_name . '",
               "email": "' . $email . '",
               "source": "' . $source . '",
               "Products of Interest": "' . $products_data . '"
             }
           }';
    } else {
        $data = '{
             "email": "' . $email . '",
             "profiles": {
                 "first_name": "' . $first_name . '",
                 "last_name":"' . $last_name . '",
               "email": "' . $email . '",
               "source": "' . $source . '"
             }
           }';
    }
    update_user_meta($user_id, "source", $source);
    echo json_encode($arr);
    if (isset($_REQUEST['source_page_id'])) {
        if (function_exists('w3tc_flush_url')) {
            w3tc_flush_url(get_permalink($_REQUEST['source_page_id']));
        }
    }
    klaviyo_partner_customer_list($data);
    die();
}


/**
 * Send data to Klaviyo for updating the partner customer list.
 *
 * @param array $data all information of customer.
 */
function klaviyo_partner_customer_list($data)
{
    $list_id = 'Jw5rmp';
    //$phone_number = '+15005550006'; // Optional
    
     $response = addProfileToKlaviyoList(KLAVIYO_API_KEY_CURL_GEHA, $list_id, $data,null);
    //echo $data;
    //$curl = curl_init();
    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://a.klaviyo.com/api/v2/list/Jw5rmp/members?api_key=pk_aafe4c7dcacd640e5940145508c0dec1bc',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => $data,
    //     CURLOPT_HTTPHEADER => array(
    //         'Content-Type: application/json'
    //     ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
}
 

/*
function add_partner_user_callback()
{
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $source = isset($_POST['source']) ? $_POST['source'] : '';
    $products = isset($_POST['products']) ? $_POST['products'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    if ($first_name == '' || $email == '') {
        $arr = array('status' => false, 'code' => 'All Fields Are required');
        echo json_encode($arr);
        die();
    }
    if (is_array($products)) {
        $products_data =  implode(", ", $products);
    } else {
        $products_data = '';
    }

    $page_key = $source;
    $user_id = username_exists($email);
    echo $user_id;
    if (!$user_id && false == email_exists($email)) {
        $random_password = wp_generate_password($length = 12, false);
        $user_id = wp_create_user($email, $random_password, $email);
        $user_data = new WP_User($user_id);
        $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
        $user_data->add_role('customer');
        update_user_meta($user_id, "billing_email", $email);
        update_user_meta($user_id, "billing_first_name", $first_name);
        update_user_meta($user_id, "first_name", $first_name);
    } else {
        $user_data = new WP_User($user_id);
    }
    if (!in_array('administrator', (array) $user_data->roles) && in_array('customer', (array) $user_data->roles)) {
        clean_user_cache($user_id);
        wp_clear_auth_cookie();
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, false);
        update_user_caches($user_data);
    }
    $arr = array('status' => true);
    update_user_meta($user_id, $page_key, 'yes');
    update_user_meta($user_id, "source", $source);
    update_user_meta($user_id, "partner_products", $products);
    echo json_encode($arr);
    setcookie($source, 'yes', time() + (3600 * 24 * 360), '/');
    klaviyo_partner_customer_list($email, $source, $products_data);
    die();
}


function klaviyo_partner_customer_list($billing_email, $source, $products)
{
    $data = '{
        "email": "' . $billing_email . '",
        "profiles": {
          "email": "' . $billing_email . '",
          "source": "' . $source . '",
          "Products of Interest": "' . $products . '"
        }
      }';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.klaviyo.com/api/v2/list/Jw5rmp/members?api_key=pk_aafe4c7dcacd640e5940145508c0dec1bc',
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

    $response = curl_exec($curl);

    curl_close($curl);
}
*/