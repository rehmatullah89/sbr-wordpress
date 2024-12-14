<?php
add_filter('woocommerce_order_item_name', 'smile_brillaint_display_product_image_in_order_item', 20, 3);

function smile_brillaint_display_product_image_in_order_item($item_name, $item, $is_visible)
{
    // Targeting view order pages only
    //   if( is_wc_endpoint_url( 'view-order' ) ) {
    $product = $item->get_product(); // Get the WC_Product object (from order item)
    $thumbnail = $product->get_image(array(36, 36)); // Get the product thumbnail (from product object)
    if ($product->get_image_id() > 0) {
        $product_thubmail = '<div class="item-thumbnail">' . $thumbnail . '</div>';
        $item_name = $product_thubmail . '<div class="item-name-mbt">' . $item_name . '</div>';
    }

    //}
    return $item_name;
}

add_filter('woocommerce_admin_order_preview_line_items', 'smile_brillaint_admin_order_preview_add_custom_meta_data', 10, 2);

function smile_brillaint_admin_order_preview_add_custom_meta_data($data, $order)
{
    $order_data = array();
    foreach ($data as $item_id => $item) {
        if (wc_cp_get_composited_order_item_container($item, $order)) {
            /* Composite Prdoucts Child Items */
        } else if (wc_cp_is_composite_container_order_item($item)) {
            /* Composite Prdoucts Parent Item */
            $order_data[$item_id] = $item;
        } else {
            $order_data[$item_id] = $item;
        }
    }
    return $order_data;
}

add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');

function smile_brilliant_checkout_shipping_rate_display()
{
?>
    <div class="form-group" id="sb_checkout_shipping">
        <label for="shippingMethod">
            Shipping Method
            &nbsp;&nbsp;<span style="color:#4597cb;">(Order Will
                Ship:&nbsp;&nbsp;<b>Today</b>)</span>
        </label>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php do_action('woocommerce_review_order_before_shipping'); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action('woocommerce_review_order_after_shipping'); ?>
        <?php endif; ?>
    </div>
<?php
}

// define the woocommerce_checkout_update_order_review callback 
function min_cart_fragments_update_on_checkout($fragments)
{
    ob_start();
?>
    <span class="float_count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
    <?php
    $fragments['.float_count'] = ob_get_clean();

    ob_start();
    ?>
    <div class="widget_shopping_cart_content">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
    $fragments['div.widget_shopping_cart_content'] = ob_get_clean();

    return $fragments;
}

add_filter('woocommerce_update_order_review_fragments', 'min_cart_fragments_update_on_checkout');






/**
 * Adding our cart on checkout
 */
add_filter('woocommerce_update_order_review_fragments', 'smile_brilliant_cart_fragment');

function smile_brilliant_cart_fragment($fragments)
{
    ob_start();
    echo '<div id="sb_checkout_cart">';
    wc_get_template_part('cart/cart');
    echo '</div>';
    $html = ob_get_clean();
    $fragments['#sb_checkout_cart'] = $html;
    return $fragments;
}

/**
 * Adding our shipping rate to display on checkout
 */
//add_filter('woocommerce_update_order_review_fragments', 'smile_brilliant_shipping_fragment');

function smile_brilliant_shipping_fragment($fragments)
{
    ob_start();
    smile_brilliant_checkout_shipping_rate_display();
    $html = ob_get_clean();
    $fragments['#sb_checkout_shipping'] = $html;
    return $fragments;
}

/*
  add_action('woocommerce_composite_component_admin_config_html', 'smile_brillaint_component_shipping', 50, 3);

  function smile_brillaint_component_shipping($id, $data, $product_id) {
  $sm_shipment = isset($data['component_id']) ? $data['component_id'] : 0;
  if ($sm_shipment) {
  $bto_data_sm_first_shipment = get_post_meta($sm_shipment, 'sm_first_shipment', true);
  $bto_data_sm_second_shipment = get_post_meta($sm_shipment, 'sm_second_shipment', true);
  ?>
  <div class="component_shipment">
  <div class="form-field">
  <label for="sm_first_shipment_<?php echo $sm_shipment; ?>">
  First Shipment
  </label>
  <input type="number" class="group_quantity_min" name="bto_data[<?php echo $id; ?>][sm_first_shipment]" id="sm_first_shipment_<?php echo $sm_shipment; ?>" value="<?php echo $bto_data_sm_first_shipment; ?>" placeholder="" step="1" min="0">
  </div>
  </div>
  <div class="component_shipment">
  <div class="form-field">
  <label for="sm_second_shipment_<?php echo $sm_shipment; ?>">
  Second Shipment
  </label>
  <input type="number" class="group_quantity_min" name="bto_data[<?php echo $id; ?>][sm_second_shipment]" id="sm_second_shipment_<?php echo $sm_shipment; ?>" value="<?php echo $bto_data_sm_second_shipment; ?>" placeholder="" step="1" min="0">
  </div>
  </div>
  <?php
  } else {
  ?>
  <div class="component_shipment">
  <div class="form-field">
  <label for="Shipment">
  <?php echo __('Shipment', 'woocommerce-composite-products'); ?>
  </label>
  <?php echo __('First Save Component Item', 'woocommerce-composite-products'); ?>

  </div>
  </div>
  <?php
  }
  }

  add_action('woocommerce_composite_process_component_data', 'woocommerce_composite_process_component_data_callback', 50, 3);

  function woocommerce_composite_process_component_data_callback($composite_group_data = '', $post_data = '', $component_id = '') {

  if ($component_id) {
  if (isset($post_data['sm_first_shipment'])) {
  $sm_first_shipment = $post_data['sm_first_shipment'];
  update_post_meta($component_id, 'sm_first_shipment', $sm_first_shipment);
  }
  if (isset($post_data['sm_second_shipment'])) {
  $sm_second_shipment = $post_data['sm_second_shipment'];
  update_post_meta($component_id, 'sm_second_shipment', $sm_second_shipment);
  }
  }
  return $composite_group_data;
  }


 */

function wc_auth_net_cim_save_payment_method_default_checked($html, $form)
{

    if (empty($html) || $form->tokenization_forced()) {
        return $html;
    }

    return str_replace('type="checkbox"', 'type="checkbox" checked="checked"', $html);
}

add_filter('wc_authorize_net_cim_credit_card_payment_form_save_payment_method_checkbox_html', 'wc_auth_net_cim_save_payment_method_default_checked', 10, 2);

//add_filter('woocommerce_payment_complete_order_status', 'smile_brilliant_payment_complete_status', 10, 3);


function smile_brilliant_payment_complete_status($status, $order)
{

    return 'on-hold';
}


add_action('woocommerce_payment_complete', 'smile_brilliant_payment_complete_status_readyToShip', 10);
function smile_brilliant_payment_complete_status_readyToShip($order_id)
{


    global $wpdb;
    $order = wc_get_order($order_id);
    $data = array();
    foreach ($order->get_items() as $item_id => $item) {

        $log_visible = false;
        if (wc_cp_get_composited_order_item_container($item, $order)) {
        } else {

            $log_visible = true;
        }

        if ($log_visible) {
            $product_id = $item->get_product_id();
            $product = $item->get_product();

            $item_quantity = $item->get_quantity(); // Get the item quantity
            if ($item_quantity > 1) {
                 //subscription#RB[223-300]
                 $arbid = wc_get_order_item_meta($item_id, '_arbid', true);                
                 if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes' || $arbid > -1 ) {
                     $sqlLT = "SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '$item_id'";
                     $resultLT = $wpdb->get_results($sqlLT);
                     $price = $product->get_price();
                     $priceLT = $price;
                     $priceLST = $price;
                     if ($resultLT) {
                         foreach ($resultLT as $itemRow) {
                             if ($itemRow->meta_key == '_line_subtotal') {
                                 $priceLST = $itemRow->meta_value / $item_quantity;
                             }
                             if ($itemRow->meta_key == '_line_total') {
                                 $priceLT = $itemRow->meta_value / $item_quantity;
                             }
                         }
                     }
 
                     $data[$item_id] = array(
                         'item_id' => $item_id,
                         'product_id' => $product_id,
                         '_line_subtotal' => $priceLST,
                         '_line_total' => $priceLT,
                         '_arbid' => ($arbid == ""?-1:$arbid),
                         'name' => $product->get_name(),
                         'qty' => $item_quantity
                     );
                 }
            }
        }
    }
    if ($data) {
        foreach ($data as $key_itmId => $itmData) {
            $qty = $itmData['qty'];
            for ($i = 1; $i < $qty; $i++) {
                $dataWOI = array(
                    "order_item_name" => $itmData['name'],
                    "order_item_type" => 'line_item',
                    "order_id" => $order_id
                );
                $wpdb->insert('wp_woocommerce_order_items', $dataWOI);
                $addedData = $wpdb->insert_id;

                if ($addedData) {
                    $arrayData = array(
                        '_product_id' => $itmData['product_id'],
                        '_qty' => 1,
                        '_line_subtotal' => $itmData['_line_subtotal'],
                        '_line_total' => $itmData['_line_total'],
                    );
                    if(isset($itmData['_arbid']) && $itmData['_arbid'] > -1)
                        $arrayData = array_merge($arrayData, ['_arbid'=>$itmData['_arbid']]);
                    foreach ($arrayData as $keyWOIM => $itemDataEntry) {
                        $dataWOIM = array(
                            "order_item_id" => $addedData,
                            "meta_key" => $keyWOIM,
                            "meta_value" => $itemDataEntry
                        );
                        $wpdb->insert('wp_woocommerce_order_itemmeta', $dataWOIM);
                    }
                }
            }

            $wpdb->update('wp_woocommerce_order_itemmeta', array(
                'meta_value' => 1,
            ), array('meta_key' => '_qty', 'order_item_id' => $key_itmId));

            $wpdb->update('wp_woocommerce_order_itemmeta', array(
                'meta_value' => $itmData['_line_subtotal'],
            ), array('meta_key' => '_line_subtotal', 'order_item_id' => $key_itmId));

            $wpdb->update('wp_woocommerce_order_itemmeta', array(
                'meta_value' => $itmData['_line_total'],
            ), array('meta_key' => '_line_total', 'order_item_id' => $key_itmId));
            if(isset($itmData['_arbid']) && $itmData['_arbid'] > -1) {
                $wpdb->update('wp_woocommerce_order_itemmeta', array(
                    'meta_value' => $itmData['_arbid'],
                ), array('meta_key' => '_arbid', 'order_item_id' => $key_itmId));
            }
        }
        $order->calculate_totals();
    }

    mbt_goodToShip($order_id);
}

add_action('wp_enqueue_scripts', 'smile_brilliant_enqueue', 10);
if (!function_exists('smile_brilliant_enqueue')) {

    function smile_brilliant_enqueue()
    {
        if (is_checkout()) {
            //  wp_enqueue_script('wc-add-to-cart');
            wp_enqueue_script('wc-cart');
            wp_deregister_script('wc-checkout');
            wp_register_script('wc-checkout', get_stylesheet_directory_uri() . "/assets/js/checkout.js", array('jquery'), time(), TRUE);
            wp_enqueue_script('wc-checkout');
        }
    }
}

add_action('woocommerce_cart_contents', 'sb_woocommerce_after_cart_contents_callback');

function sb_woocommerce_after_cart_contents_callback()
{
    foreach (WC()->cart->get_coupons() as $code => $coupon) :
    ?>
        <tr class="couponRow" style="background-color: rgb(242, 242, 242);/* display: none; */">
            <td colspan="4" id="couponRowDescriptionCell">
                <h5 style="color:#595959;text-align:right;">
                    <?php wc_cart_totals_coupon_label($coupon); ?></h5>
            </td>
            <td colspan="1" style="text-align:left;">
                <h5 style="color:#595959;"><?php wc_cart_totals_coupon_html($coupon); ?>
                </h5>
            </td>
            <td colspan="1" class="remove-button-column">
                <a rel="nofollow" href="javascript:;" data-coupon="<?php echo $code; ?>" class="btn btn-primary btn-sm mbt-coupon-remove">REMOVE</a>
            </td>
        </tr>

    <?php
    endforeach;
}

//add_action('woocommerce_checkout_update_user_meta', 'woocommerce_checkout_posted_data_smile_brilliant_callback');
function woocommerce_checkout_posted_data_smile_brilliant_callback()
{

    $cart_items = WC()->cart->get_cart();
    foreach ($cart_items as $cart_item_key => $cart_item) {
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
        $qty = $cart_item['quantity'];
        if (get_post_meta($product_id, 'three_way_ship_product', TRUE) == 'yes' && $qty > 1) {
            WC()->cart->set_quantity($cart_item_key, 1);
            for ($j = 1; $j < $qty; $j++) {
                $_POST['action'] = 'woocommerce_add_order_item';
                WC()->cart->add_to_cart($product_id, 1);
            }
        }
    }
    WC()->cart->maybe_set_cart_cookies();
    WC()->cart->calculate_totals();
}

// update woocommerce cart quantity
add_action('wp_ajax_update_woocommerce_cart_quantity_sb', 'update_woocommerce_cart_quantity_sb_callback');
add_action('wp_ajax_nopriv_update_woocommerce_cart_quantity_sb', 'update_woocommerce_cart_quantity_sb_callback');

function update_woocommerce_cart_quantity_sb_callback()
{

    $cart_items = WC()->cart->get_cart();
    $product_changeQty = array();
    foreach ($_REQUEST['cart'] as $cart_item_key => $cart_item) {
        $product_id = $cart_item['product_id'];
        $product_type = $cart_item['product_type'];
        if (isset($cart_item['qty'])) {
            //echo 'Data: <pre>' .print_r($cart_item,true). '</pre>';
            $qty = isset($cart_item['qty']) ? $cart_item['qty'] : 0;
            $old_qty = isset($cart_item['old_qty']) ? $cart_item['old_qty'] : 0;
            if ($qty != $old_qty) {
                if ($product_type == 'simple' ||  get_post_meta($product_id, 'three_way_ship_product', true) != 'yes') {
                    WC()->cart->set_quantity($cart_item_key, $qty);
                } else {
                    //WC()->cart->set_quantity($cart_item_key, $qty);
                    if ($qty > $old_qty) {
                        $incrementQty = $qty - $old_qty;
                        if ($incrementQty) {
                            for ($j = 1; $j <= $incrementQty; $j++) {
                                $_POST['action'] = 'woocommerce_add_order_item';
                                WC()->cart->add_to_cart($product_id, 1);
                            }
                        }
                    } else {
                        $decrementQty = $old_qty - $qty;
                        if ($decrementQty) {
                            $checkCounter = 1;
                            foreach ($cart_items as $cart_item_key => $cart_item) {
                                if ($cart_item['product_id'] == $product_id) {
                                    WC()->cart->remove_cart_item($cart_item_key);
                                    if ($checkCounter == $decrementQty) {
                                        break;
                                    } else {
                                        $checkCounter++;
                                    }
                                }
                            }
                        }
                    }
                    //  $product_changeQty[$product_id] = $cart_item;
                }
            }
        }
    }
    die();
    if (count($product_changeQty) > 0) {
        foreach ($product_changeQty as $product_id => $quantity) {

            //  $_product = wc_get_product($product_id);
            foreach ($cart_items as $cart_item_key => $cart_item) {
                if ($cart_item['product_id'] == $product_id) {
                    //                    if (wc_cp_is_composite_container_cart_item($cart_item)) {
                    //                        foreach ($cart_item['composite_children'] as $key_value) {
                    //                            WC()->cart->remove_cart_item($key_value);
                    //                        }
                    //                    }
                    //                    WC()->cart->remove_cart_item($cart_item_key);
                }
            }
            if ($quantity > 0) {
                for ($j = 1; $j <= $quantity; $j++) {
                    $_POST['action'] = 'woocommerce_add_order_item';
                    // Add the product as a new line item with the same variations that were passed
                    WC()->cart->add_to_cart($product_id, 1);
                }
            }
        }
    }
    die;
}

add_filter('wfacp_mini_cart_after_shipping', 'woocommerce_review_order_after_shipping_threeway_display_message', 10);
function woocommerce_review_order_after_shipping_threeway_display_message()
{
    $title = '';
    if (WC()->cart->get_shipping_total() == 30) {
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['data']->get_id(); // For version 3 or more
            if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes') {
                $title = '<tr class="threewayShipping"><td colspan="2">*International shipping is $30 and covers two - way shipping: shipment of the kit to you and the final custom tray(s) to you. It does not cover return shipping of teeth impressions. It typically takes 10-14 business days to deliver on each instance of shipping.
                We would like this to apply to the night guard kits as well as the teeth whitening kits. Thank you!</td></tr>';
            }
        }
    }
    echo  $title;
}


function  pressReleaseInquiryEmail($f)
{
    $submission = WPCF7_Submission::get_instance();
    $data = $submission->get_posted_data();
    if (isset($data['type'][0]) && $data['type'][0] == 'press_release_inquiry') {
        return false; // DO SEND E-MAIL
    } else {
        return true; // DO NOT SEND E-MAIL
    }
}
add_filter('wpcf7_skip_mail', 'pressReleaseInquiryEmail');

add_action('wp_ajax_unblockFruadEmail', 'unblockFruadEmail_func');
function unblockFruadEmail_func()
{
    /*
    $email = isset($_REQUEST['email']) ? sanitize_text_field($_REQUEST['email']) : '';
    $email_blacklist = get_option('wc_settings_anti_fraudblacklist_emails');
    if ('' != $email_blacklist) {
        $blacklist = explode(',', $email_blacklist);
        if (is_array($blacklist) && count($blacklist) > 0 && in_array($email, $blacklist)) {
            foreach ($blacklist as $key => $val) {
                if ($val == $email) {
                    unset($blacklist[$key]);
                }
            }
            $blacklist = implode(',', $blacklist);
            echo esc_html__($blacklist);
            update_option('wc_settings_anti_fraudblacklist_emails', $blacklist);
        }
    }

*/

    $email = isset($_REQUEST['email']) ? sanitize_text_field($_REQUEST['email']) : '';
    $email_blacklist = get_option('wc_settings_anti_fraudblacklist_emails');
    if ('' != $email_blacklist) {
        $blacklist = explode(',', $email_blacklist);
        if (is_array($blacklist) && count($blacklist) > 0 && in_array($email, $blacklist)) {
            foreach ($blacklist as $key => $val) {
                if ($val == $email) {
                    unset($blacklist[$key]);
                }
            }
            $blacklist = implode(',', $blacklist);
            echo esc_html__($blacklist);
            update_option('wc_settings_anti_fraudblacklist_emails', $blacklist);
        }
    }
    $email_whitelist = get_option('wc_settings_anti_fraud_whitelist');
    $email_whitelist .= "\n" . isset($_REQUEST['email']) ? sanitize_text_field($_REQUEST['email']) : '';
    update_option('wc_settings_anti_fraud_whitelist', $email_whitelist);

    die();
}


function disable_unwanted_scripts() {
    if(is_page('contact')){
        wp_dequeue_script('rcfwc-js'); // Adjust based on the actual handle
        wp_dequeue_script('recaptcha'); // Adjust based on the actual handle
    }
}
add_action('wp_enqueue_scripts', 'disable_unwanted_scripts', 100);
