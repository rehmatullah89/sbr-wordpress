<?php
/*
Template Name: Generate Coupons
*/
if (is_super_admin(get_current_user_id())) {
    if (isset($_POST['submit'])) {
        if (isset($_POST['number_of_coupons']) && $_POST['number_of_coupons'] != '' && isset($_POST['discount_amount']) && $_POST['discount_amount'] != '') {
            $data = array();
            for ($i = 1; $i <= $_POST['number_of_coupons']; $i++) {
                $prefix =  $_POST['prefix'];
                $characters = "ABCDEFGHJKMNPQRSTUVWXYZ23456789";
                $char_length = "8";
                $random_string = substr(str_shuffle($characters),  0, $char_length);
                $coupon_code =  $prefix . '-' . $random_string; // Code created using the random string snippet.
                $amount = $_POST['discount_amount']; // Amount
                $discount_type = 'percent_product'; // Type: fixed_cart, percent, fixed_product, percent_product
                $description =  isset($_POST['description']) ? $_POST['description'] : '';
                $min_cart_total =  isset($_POST['min_cart_total']) ? $_POST['min_cart_total'] : '';
                //$description = '25% OFF Individual Electric Toothbrush Package';
                $coupon = array(
                    'post_title' => $coupon_code,
                    'post_content' => $description,
                    'post_excerpt' => $description,
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'post_type'     => 'shop_coupon'
                );
                $new_coupon_id = wp_insert_post($coupon);
                $product_id = '';
                if ($prefix == 'SCP') {
                    $product_id = PROBIOTIC_1BOTTLE_PRODUCT_ID;
                }
                if ($prefix == 'SCT60' || $prefix == 'SCT25') {
                    $product_id = CARIPRO_TOOTHBRUSH_2_HEADS_ID;
                }
                if ($prefix == 'SCWF') {
                    $product_id = CARIPRO_CORDLESS_WATER_FLOSSER_4_TIPS_ID;
                }
                if ($prefix == 'SCT50') {
                    $product_id = T3_SENSITIVE_SYSTEM_TRAYS_3_SYRINGES_ID;
                }
                if ($prefix == 'SCN50') {
                    $product_id = ULTRA_DURABLE_NIGHT_GUARDS_2_ID;
                }
                if ($prefix == 'JEMWNG1') {
                    $product_id = ULTRA_DURABLE_NIGHT_GUARD_1_ID;
                }
                if ($prefix == 'JEMWNG2') {
                    $product_id = ULTRA_DURABLE_NIGHT_GUARDS_2_ID;
                }
                if ($prefix == 'JEMWDTB') {
                    $product_id = DELUXE_PACKAGE_CARIPRO_TOOTHBRUSH_4_HEADS_ID;
                }
                if ($prefix == 'JEMWITB') {
                    $product_id = CARIPRO_TOOTHBRUSH_2_HEADS_ID;
                }
                if ($prefix == 'JEMWT9S') {
                    $product_id = T9_SENSITIVE_SYSTEM_TRAYS_9_SYRINGES_ID;
                }
                if ($prefix == 'JEMWT3') {
                    $product_id = T3_NON_SENSITIVE_SYSTEM_TRAYS_3_SYRINGES_ID;
                }
                if ($prefix == 'SCNG') {
                    $product_id = T3_NON_SENSITIVE_SYSTEM_TRAYS_3_SYRINGES_ID;
                }
                if ($prefix == 'SCNO') {
                    $product_id = NIGHT_OUT_DENTAL_STAIN_CONCEALER_3_BOTTLES_ID;
                }
                if ($prefix == 'ONEDENTAL') {
                    $product_id = CARIPRO_TOOTHBRUSH_2_HEADS_ID;
                }
                
                $products = array($product_id);
                $coupon_code_str = $coupon_code;
                update_post_meta($new_coupon_id, 'discount_type', $discount_type);
                update_post_meta($new_coupon_id, 'coupon_amount', $amount);
                update_post_meta($new_coupon_id, 'individual_use', 'yes');
                update_post_meta($new_coupon_id, 'usage_limit', '1');
                update_post_meta($new_coupon_id, 'expiry_date',  date('Y-m-d', strtotime($_POST['expiry_date'])));
                update_post_meta($new_coupon_id, '_acfw_schedule_end',  date('Y-m-d', strtotime($_POST['expiry_date'])) . ' 00:00:00');
                update_post_meta($new_coupon_id, 'free_shipping', 'no');
                if (count($products) > 0) {
                    update_post_meta($new_coupon_id, '_wc_url_coupons_product_ids', $products);
                }
                if ($min_cart_total != '') {
                    // update_post_meta($new_coupon_id, 'minimum_amount', $min_cart_total);
                }
                if (count($products) > 0) {
                    update_post_meta($new_coupon_id, 'product_ids', implode(',', $products));
                }
                

                update_post_meta($new_coupon_id, '_wc_url_coupons_url_prefix', 'coupons');
                update_post_meta($new_coupon_id, '_wc_url_coupons_unique_url', $coupon_code);
                update_post_meta($new_coupon_id, '_wc_url_coupons_redirect_page_type', 'page');
                update_post_meta($new_coupon_id, '_wc_url_coupons_redirect_page', '191');
                update_post_meta($new_coupon_id, 'usage_count', '0');
                update_post_meta($new_coupon_id, 'limit_usage_to_x_items', '0');
                update_post_meta($new_coupon_id, 'usage_limit_per_user', '0');
                update_post_meta($new_coupon_id, '_acfw_usage_limit_reset_time', '');
                update_post_meta($new_coupon_id, '_acfw_enable_role_restriction', '');
                update_post_meta($new_coupon_id, '_acfw_disable_url_coupon', 'no');
                update_post_meta($new_coupon_id, '_acfw_reset_usage_limit_period', 'none');
                update_post_meta($new_coupon_id, '_acfw_enable_payment_methods_restrict', '');
                update_post_meta($new_coupon_id, '_acfw_schedule_expire_error_msg', '');
                if ($prefix == 'SCP' || $prefix == 'ONEDENTAL') {
                    update_post_meta($new_coupon_id, 'usage_limit_per_user', '1');
                    update_post_meta($new_coupon_id, 'limit_usage_to_x_items', '1');
                    //update_post_meta($new_coupon_id, 'custom_shipping_fees', '6');
                }
               // update_post_meta($new_coupon_id, 'affwp_discount_affiliate', '8145');

                update_post_meta($new_coupon_id, '_acfw_schedule_start', '');
                update_post_meta($new_coupon_id, 'date_expires', strtotime($_POST['expiry_date']));
                 $data[]=$coupon_code.','.home_url()."/apply-coupon/".$product_id."/".$coupon_code_str;
               // $data[] = $coupon_code;
            }

            download_csv_file($data, $prefix);
            die();
        }
    }
    if (is_user_logged_in()) {
?><form action="" method="post" style="margin-top">
            <div class="col-lg-6"> <b>Prefix:</b></div>
            <div class="col-lg-6"> <input type="text" name="prefix" required> </div>
            <div class="col-lg-6"> <b>Description:</b></div>
            <div class="col-lg-6"> <input type="text" name="description" required> </div>
            <div class="col-lg-6"><b>Number Of Coupons To Generate:</b></div>
            <div class="col-lg-6"><input type="number" name="number_of_coupons" max="10000" required> </div>

            <div class="col-lg-6"> <b> Discount Amount In USD:</b></div>
            <div class="col-lg-6"><input type="number" name="discount_amount" required></div>

            <div class="col-lg-6"> <b>Min Cart Total:</b></div>
            <div class="col-lg-6"> <input type="number" name="min_cart_total" min="0" required> </div>

            <div class="col-lg-6"> <b>Expiry Date:</b></div>
            <div class="col-lg-6"> <input type="date" name="expiry_date" required> </div>
            <br />
            <input type="submit" name="submit" class="btn button">
            <style>
                .col-lg-6 input {
                    padding: 0px 30px;
                    height: 32px;
                    border-radius: 5px;
                    width: 300px;
                }
            </style>
        </form><?php
            }
        }
        function download_csv_file($data, $prefix)
        {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $prefix . '.csv');
            $fp = fopen('php://output', 'w');
            foreach ($data as $line) {
                //  print_r($line);
                $val = explode(",", $line);
                fputcsv($fp, $val);
            }
            fclose($fp);
            die();
        }

                ?>