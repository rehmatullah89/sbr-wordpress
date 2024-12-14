<?php
if (isset($_GET['delete_duplicate_posts'])) {
    delete_duplicate_posts();
    die();
}

function delete_duplicate_posts() {
    global $wpdb;

    $orders = "select post_id,meta_value from wp_postmeta where meta_key='old_order_id' group by meta_value having count(meta_value)>2";
    $results = $wpdb->get_results($orders);
    if (count($results) > 0) {
        foreach ($results as $res) {
            $postid = $res->post_id;
            wp_delete_post($postid, true);
        }
    }
}

if (isset($_GET['move_referals_to_payouts'])) {

    $orders = "select * from wp_affiliate_wp_referrals";
    $results = $wpdb->get_results($orders);
    if (count($results) > 0) {
        $counter = 0;
        foreach ($results as $res) {
            $referal_id = $res->referral_id;
            $affiliate_id = $res->affiliate_id;
            $visit_id = $res->visit_id;
            $customer_id = $res->customer_id;
            $amount = $res->amount;
            $date = $res->date;
            if ($amount > 0) {
                $arr_actual = array(
                    'affiliate_id' => $affiliate_id,
                    'referrals' => $referal_id,
                    'amount' => $amount,
                    'owner' => 2,
                    'payout_method' => 'manual',
                    'service_account' => '',
                    'service_id' => 0,
                    'service_invoice_link' => '',
                    'description' => '',
                    'status' => 'paid',
                    'date' => $date,
                );
                //if ($counter == 0) {
                $wpdb->insert('wp_affiliate_wp_payouts', $arr_actual);
                //die();
                //}
                $counter++;
            }
        }
    }
}
if (isset($_GET['affiliat_earning'])) {
    global $wpdb;
    $sq1 = "select affiliate_id from wp_affiliate_wp_affiliates order by affiliate_id ASC";
    $results1 = $wpdb->get_results($sq1);
    if (count($results1) > 0) {

        foreach ($results1 as $res1) {
            echo $affiliat_id = $res1->affiliate_id;
            echo '=>';
            $sql2 = "SELECT SUM(amount) as total_amount FROM wp_affiliate_wp_payouts WHERE affiliate_id=".$affiliat_id;
            $results2 = $wpdb->get_results($sql2);
            if (count($results2) > 0) {

                foreach ($results2 as $res2) {
                   
                    print_r($res2->total_amount);
                    echo '<br />';
                    
                }
            }
        }
    }
    die();
}

if (isset($_GET['addrefferals'])) {
    add_action('init', 'get_order_cust_data');

    function get_order_cust_data() {
        global $wpdb;
        global $woocommerce;

        $orders = "select post_id,meta_value from wp_postmeta where meta_key='old_order_id' limit 160000,20000";
        $results = $wpdb->get_results($orders);
        $saved_options = get_option('old_new_relation');
        if (count($results) > 0) {

            foreach ($results as $res) {

                $order_id = $res->post_id;

                $old_order_id = $res->meta_value;

                if ($old_order_id != '') {
                    $sql2 = "select campaignId,campaignSlug,orderDate from order_ where orderId=" . $old_order_id;
                    $results2 = $wpdb->get_results($sql2);

                    if (count($results2) > 0) {
                        $campaignId = $results2[0]->campaignId;
                        $orderDate = $results2[0]->orderDate;
                        if ($campaignId == '' || $campaignId == 0) {

                            continue;
                        }

                        $sq3 = "select * from campaign_profitPercentage where campaignId=" . $campaignId;
                        $results3 = $wpdb->get_results($sq3);
                        $percentages = array();
                        if (count($results3) > 0) {
                            foreach ($results3 as $rr) {
                                $percentages[$rr->productId] = $rr->campaignProfitPercentage;
                            }
                        }

                        $user = get_user_by('login', $results2[0]->campaignSlug);
                        $sq5 = "select * from wp_affiliate_wp_affiliates where user_id=" . $user->ID;
                        $results5 = $wpdb->get_results($sq5);
                        $affid = '';
                        if (count($results5) > 0) {
                            $affid = $results5[0]->affiliate_id;
                        } else {
                            continue;
                        }
                        if ($affid == '') {

                            continue;
                        }

                        $json_custom = 's:63:"a:2:{s:12:"affiliate_id";i:' . $user->ID . ';s:18:"is_coupon_referral";b:0;}"';

                        $orderdata = wc_get_order((int) $order_id);
                        $products_array = array();
                        if ($orderdata != '') {
                            $customer_id = $orderdata->get_user_id();
                            $items = $orderdata->get_items();
                            $order_total = $orderdata->get_total();
                            $description = '';
                            $counter = 0;
                            $total_amount_affiliate = 0;
                            foreach ($items as $item_id => $item) {
                                $product_name = $item->get_name();
                                $product_id = $item->get_product_id();
                                $order_item_id = $item_id;
                                $item_quantity = $item->get_quantity();
                                $item_subtotal = $item->get_subtotal();
                                $item_total = $orderdata->get_item_meta($item_id, '_line_total', true);
                                $key = array_search($product_id, $saved_options);
                                $profit_percentage = isset($percentages[$key]) ? $percentages[$key] : 0;
                                if ($profit_percentage == '') {
                                    $profit_percentage = 0;
                                }
                                // if ($profit_percentage != '') {
                                $profit_percentage = $profit_percentage * $item_subtotal;
                                if ($counter > 0) {
                                    $description .= ', ';
                                }
                                $description .= $product_name;
                                $total_amount_affiliate = $total_amount_affiliate + $profit_percentage;
                                $products_array[] = array('name' => $product_name, 'id' => $product_id, 'price' => $item_total, 'referral_amount' => $profit_percentage);

                                $counter++;
                                //}
                            }
                            if (count($products_array) > 0) {
                                $productsData = serialize($products_array);
                                $arr_actual = array(
                                    'affiliate_id' => $affid,
                                    'visit_id' => 0,
                                    'rest_id' => '',
                                    'customer_id' => $customer_id,
                                    'parent_id' => 0,
                                    'description' => $description,
                                    'status' => 'paid',
                                    'amount' => $total_amount_affiliate,
                                    'currency' => 'USD',
                                    'custom' => $json_custom,
                                    'context' => 'woocommerce',
                                    'campaign' => '',
                                    'type' => 'sale',
                                    'reference' => $order_id,
                                    'products' => $productsData,
                                    'payout_id' => 0,
                                    'date' => $orderDate,
                                );

                                $wpdb->insert('wp_affiliate_wp_referrals', $arr_actual);
                                $refferal_id = $wpdb->insert_id;
                                $arr_actual = array(
                                    'referral_id' => $refferal_id,
                                    'affiliate_id' => $affid,
                                    'order_total' => $order_total,
                                );

                                $wpdb->insert('wp_affiliate_wp_sales', $arr_actual);
                            }
                        }
                    }
                }
            }
        }
    }

}
if (isset($_GET['importAffiliateCoupons'])) {
    global $wpdb;
    $sql = "SELECT campaign_.campaignEmail, wp_affiliate_wp_affiliates.affiliate_id,wp_users.ID,coupon_.couponCode,campaign_coupon.* FROM campaign_coupon 
INNER JOIN coupon_ ON campaign_coupon.couponId=coupon_.couponId 
INNER JOIN campaign_ ON campaign_coupon.campaignId=campaign_.campaignId
INNER JOIN wp_users ON campaign_.campaignEmail=wp_users.user_email COLLATE utf8mb4_unicode_520_ci
INNER JOIN wp_affiliate_wp_affiliates ON wp_affiliate_wp_affiliates.user_id=wp_users.ID LIMIT 50000,10000";
    $results = $wpdb->get_results($sql);

    if (count($results) > 0) {

        foreach ($results as $res) {

            $post_id = wc_get_coupon_id_by_code($res->couponCode);
            $already_imported = get_post_meta($post_id, 'affwp_discount_affiliate', true);
            if ($already_imported != '') {
                continue;
            }
            if ($post_id != '') {
                $wpdb->insert('wp_affiliate_wp_coupons', array(
                    'affiliate_id' => $res->affiliate_id,
                    'coupon_code' => $res->couponCode,
                ));
            }

            update_post_meta($post_id, 'affwp_discount_affiliate', $res->affiliate_id);
        }
    }
    echo 'data is added successfully';
    die();
}

if (isset($_GET['exportcsv'])) {
    global $wpdb;
    $sql = "SELECT * FROM campaign_";
    $results = $wpdb->get_results($sql);
//echo '<pre>';
//print_r($results);
//die();
    if (count($results) > 0) {
        $number = 1;
        $usersArray = array();
        $usersArray[] = array('Email', 'First Name', 'Last Name', 'Username', 'Status', 'Website', 'Date Registered');
        $users = '<table class="table table-bordered">
        <tr>
           
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Status</th>
            <th>Date Registered</th>
        </tr>';
        $ounter = 0;
        foreach ($results as $res) {
            if ($res->campaignEmail == '')
                continue;
            $user_status = $res->campaignIsActive;
            if ($user_status == '1' || $user_status == 1) {
                $user_status = 'active';
            } else {
                $user_status = 'inactive';
            }
            $usersArrayChild = array($res->campaignEmail, $res->campaignFirstName, $res->campaignLastName, $res->campaignEmail, $user_status, $res->campaignDescription, $res->createdTime);
            $users .= '<tr>';
            $users .= '<td>' . $res->campaignEmail . '</td>
            <td>' . $res->campaignFirstName . '</td>
            <td>' . $res->campaignLastName . '</td>
            <td>' . $res->campaignEmail . '</td>
            <td>' . $user_status . '</td>
            <td>' . $res->createdTime . '</td>';
            $users .= '</tr>';
            $usersArray[] = $usersArrayChild;
            $ounter++;
        }
        $users .= '</table>';
        $filename = 'affiliates.csv';
        $export_data = $usersArray;
// file creation
        $file = fopen($filename, "w");

        foreach ($export_data as $line) {
            fputcsv($file, $line);
        }

        fclose($file);

// download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Type: application/csv; ");
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($filename);
        unlink($filename);
        exit;
    }
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Export Data from MySQL to CSV Tutorial | iTech Empires</title>
            <!-- Bootstrap CSS File  -->
            <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
        </head>
        <body>
            <div class="container">
                <!--  Header  -->
                <div class="row">
                    <div class="col-md-12">
                        <h2>Export Data from MySQL to CSV</h2>
                    </div>
                </div>
                <!--  /Header  -->

                <!--  Content   -->
                <div class="form-group">
                    <?php echo $users ?>
                </div>
                <div class="form-group">
                    <button >
                    <?php } ?>