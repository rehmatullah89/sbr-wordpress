<?php

if (isset($_GET['update_user_name'])) {
    global $wpdb;
    $usersSql = "select user_id from wp_affiliate_wp_affiliates";
    $results = $wpdb->get_results($usersSql);
    if (count($results) > 0) {
        foreach ($results as $res) {
            $user_id = $res->user_id;
            $user_info = get_userdata($user_id);
            $user_email = $user_info->user_email;
            $sql = "SELECT campaignSlug FROM campaign_ WHERE campaignEmail='" . $user_email . "'";

            $results = $wpdb->get_results($sql);
            if (count($results) > 0) {
                $username = $results[0]->campaignSlug;
                if ($username != '') {

                    $wpdb->update(
                            'wp_users', array(
                            'user_login' => $username, // string
                            ), array('ID' => $user_id)
                    );
                }
            }
        }
    }
}
if (isset($_GET['affiliate-rates'])) {
    global $wpdb;
    //$affiliate_data = get_user_meta(113127, 'affwp_product_rates', true);

//    echo '<pre>';
//    print_r($affiliate_data);
//    die();
    //INNER JOIN wp_users ON campaign_.campaignEmail=wp_users.user_email COLLATE utf8mb4_unicode_520_ci LIMIT 0,500
    $sql = "SELECT campaign_.campaignEmail,campaign_.campaignId,wp_users.ID,campaign_profitPercentage.* FROM campaign_ 
        INNER JOIN wp_users ON campaign_.campaignEmail=wp_users.user_email COLLATE utf8mb4_unicode_520_ci
        INNER JOIN campaign_profitPercentage ON campaign_profitPercentage.campaignId=campaign_.campaignId WHERE campaign_.campaignEmail!='' LIMIT 30000,10000";
    $results = $wpdb->get_results($sql);
//    echo '<pre>';
//    print_r($results);
//    die();
    if (count($results) > 0) {
        $saved_options = get_option('old_new_relation');
        //$counter = 1;
        foreach ($results as $res) {

            $productId = isset($saved_options[$res->productId]) ? $saved_options[$res->productId] : '';
            if ($productId != '') {
                $userID = $res->ID;
                $campaign_id = $res->campaignId;
                $rate = $res->campaignId;
                $existing_meta = get_user_meta($userID, 'affwp_product_rates', true);

                $new_result = array('products' => [$productId], 'rate' => $res->campaignProfitPercentage * 100, 'type' => 'percentage');
                if (is_array($existing_meta) && count($existing_meta) > 0) {
                    //                    //
                } else {
                    $existing_meta = array('woocommerce' => array());
                }
                $existing_meta['woocommerce'][] = $new_result;
                update_user_meta($userID, 'affwp_product_rates', $existing_meta);
            }
        }
    }

//    if (count($results) > 0) {
//
//        foreach ($results as $res) {
//           
//            $post_id = wc_get_coupon_id_by_code($res->couponCode);
//             $already_imported = get_post_meta($post_id,'affwp_discount_affiliate',true);
//             if($already_imported!=''){
//                 continue;
//             }
//            if ($post_id != '') {
//                $wpdb->insert('wp_affiliate_wp_coupons', array(
//                    'affiliate_id' => $res->affiliate_id,
//                    'coupon_code' => $res->couponCode,
//                ));
//            }
//            echo $post_id.'=>'.$res->affiliate_id.'=>'.$res->couponCode;
//            update_post_meta($post_id,'affwp_discount_affiliate',$res->affiliate_id);
//           
//        }
//    }
    echo 'data is added successfully';
    die();
}
?>