<?php
/**
  Template Name: data import
 */
/*
  include 'db.php';

  $dbhost = '50.19.215.164';
  $dbuser = 'root';
  $dbpass = 'LETSdoTHIS786';
  $dbname = 'smilebrilliant';
 */
/*
  $db = new db($dbhost, $dbuser, $dbpass, $dbname);
  echo 'here';
  die();
 */
/*
  register custom taxonomies
 */
global $wpdb;
echo $allorders = "SELECT *from wp_postmeta where meta_key='_oldJson' limit 200000,50000";

$results = $wpdb->get_results($allorders, 'ARRAY_A');
if (is_array($results) && count($results) > 0) {
    foreach ($results as $ress) {
        $data = $ress['meta_value'];
        $post_id = $ress['post_id'];
        $data = json_decode($data, true);
        $authorizeTransactionId = $data['authorizeTransactionId'];
        $affirmCaptureId = $data['affirmCaptureId'];
        $orderContainsGift = $data['orderContainsGift'];
        if ($authorizeTransactionId != '') {
            echo $post_id . '=>' . $authorizeTransactionId;
            echo '<br />';
            update_post_meta($post_id, '_payment_method', 'authorize_net_cim_credit_card');
            update_post_meta($post_id, '_transaction_id', $authorizeTransactionId);
            //continue;
        }
        if ($affirmCaptureId != '') {
            update_post_meta($post_id, '_payment_method', 'affirm');
            update_post_meta($post_id, '_transaction_id', $affirmCaptureId);
        }
        if ($orderContainsGift != '' && $orderContainsGift != 0) {
            update_post_meta($post_id, 'purchasing_as_giftset', 1);
        }
    }
}
die();
ini_set('max_execution_time', -1);
set_time_limit(-1);
$page = isset($_GET['page_num']) ? $_GET['page_num'] : 0;
$limit = 500;
$offset = $page * $limit;
global $influencers;
updateOrdersMbt();
die();

function delete_duplicate_refunds() {

    global $wpdb;
    echo $sql_duplicate = "SELECT ID, post_parent FROM wp_posts WHERE post_type='shop_order_refund' GROUP BY post_parent HAVING COUNT(post_parent)>1";
    $result = $wpdb->get_results($sql_duplicate);
    echo '<pre>';
    print_r($result);
    foreach ($result as $res) {
        $orderItemId = $res->post_parent;
        echo $post_id = $res->ID;
        wp_delete_post($post_id, true);
        //  echo  $del_sql= 'delete from wp_woocommerce_order_items where order_item_id='.$orderItemId;
        // $wpdb->query($del_sql);
    }
    die();
}

function deleteDoubleCoupons() {
    global $wpdb;
    $sql_duplicate = "SELECT order_item_id FROM
    wp_woocommerce_order_items
    WHERE order_item_type='coupon' 
    AND order_id<600000
    GROUP BY order_id
HAVING COUNT(order_item_type) > 1 LIMIT 5000";
    $result = $wpdb->get_results($sql_duplicate);

    foreach ($result as $res) {
        $orderItemId = $res->order_item_id;
        echo $del_sql = 'delete from wp_woocommerce_order_items where order_item_id=' . $orderItemId;
        echo '<br />';
        $wpdb->query($del_sql);
    }
}

delete_duplicate_orders_addons();
die();

function delete_duplicate_orders() {
    global $wpdb;
    $sql_duplicate = "SELECT 
    post_id

FROM
    wp_postmeta
    WHERE meta_key='old_order_id'
    GROUP BY meta_value
HAVING COUNT(meta_value) > 1";
    $result = $wpdb->get_results($sql_duplicate);

    foreach ($result as $res) {
        echo $orderId = $res->post_id;
        echo '<br />';
        echo $del_sql = 'delete from wp_woocommerce_order_items where order_id=' . $orderId;
        $wpdb->query($del_sql);
        wp_delete_post($orderId, true);
    }

    die();
}

function delete_duplicate_orders_addons() {
    global $wpdb;
    $sql_duplicate = "SELECT 
    post_id

FROM
    wp_postmeta
    WHERE meta_key='old_order_id_addon'
    GROUP BY meta_value
HAVING COUNT(meta_value) > 1";
    $result = $wpdb->get_results($sql_duplicate);

    foreach ($result as $res) {
        echo $orderId = $res->post_id;
        $del_sql = 'delete from wp_woocommerce_order_items where order_id=' . $orderId;
        $wpdb->query($del_sql);
        wp_delete_post($orderId, true);
    }

    die();
}

function updateOrdersMbt() {
    $neworderId = 503330;
    $order = new WC_Order($neworderId);
    $order->calculate_totals();
    $order->save();
    die();
    $initial_date = '2021-01-01';
    $final_date = '2021-12-31';
    global $wpdb;


    $post_status = implode("','", array('wc-processing', 'wc-completed'));

    $result = $wpdb->get_results("SELECT ID FROM $wpdb->posts 
            WHERE post_type = 'shop_order'
            AND post_date BETWEEN '{$initial_date}  00:00:00' AND '{$final_date} 23:59:59'
        ");


    $total_sum = 0;
    if (count($result) > 0) {
        foreach ($result as $ord) {
            $neworderId = $ord->ID;
            $existing_total = get_post_meta($neworderId, '_order_total', true);

            if ($existing_total != '') {
                update_post_meta($neworderId, 'order_total2', $existing_total);
                $coupon_code = get_post_meta($neworderId, 'coupon_code', true);
                $order = new WC_Order($neworderId);
                if ($coupon_code != '') {
                    $coupon_applied = get_post_meta($neworderId, 'coupon_applied', true);
                    if ($coupon_applied == 'yes') {
                        //
                    } else {
                        $discount_total = get_post_meta($neworderId, 'discount_total', true);
                        $item = new WC_Order_Item_Coupon();
                        $item->set_props(array('code' => $coupon_code, 'discount' => $discount_total, 'discount_tax' => 0));
                        $order->add_item($item);
                        update_post_meta($neworderId, 'coupon_applied', 'yes');
                    }
                }
                $total_sum = $total_sum + $existing_total;
                $order->calculate_totals();
                update_post_meta($neworderId, '_order_total', $existing_total);
                //die();
            }
        }
    }
    echo 'total sum=' . $total_sum;
    die();
}

/*
  delete_duplicate_orders();
  die();
 * 
 */
$influencers = array(3331, 3828, 5921, 5922, 5923, 5924, 13878, 14411, 17758, 19854, 20779, 24675, 25941, 30412, 40783);
//$multiStage = array(8,9,10,11,20,21,22,34,35,36);


global $parentChilderns;
$parentChilderns = array(
    '1' => array('2', '3', '4'),
    '6' => array('19', '12', '17', '18'),
    '7' => array('11', '9', '10', '8', '22', '20', '21'),
    '13' => array('14', '15', '16'),
    '5' => array(),
    '23' => array('26', '25', '24', '31'),
    '27' => array('30', '29', '28', '32'),
    '33' => array('34', '35', '36'),
    '38' => array('39')
);
add_option('parentChilderns', $parentChilderns);
$saved_options = get_option('old_new_relation');
addOrderAddOns();
die();
//refundOrders();

/*
  import products
 */
if (isset($_GET['import_products'])) {
    importProducts();
}

// import coupons
if (isset($_GET['import_coupon'])) {
    global $wpdb;
    $offset = 22500;
    $limit = 40000;
    $sqlCoupons = "SELECT cop.*from coupon_  AS cop
	    LIMIT " . $offset . "," . $limit;
    $result = $wpdb->get_results($sqlCoupons, 'ARRAY_A') or die($wpdb->last_error);

    $parentChilderns = get_option('parentChilderns');

    foreach ($result as $row) {
        //createUserWoocommerce($row);

        $product_id = 0;
        if (isset($parentChilderns[$row['productId']])) {
            $coupon_products = $parentChilderns[$row['productId']];
            foreach ($coupon_products as $cp) {
                $product_id .= $saved_options[$cp] . ',';
            }
        } else {
            $product_id = isset($saved_options[$row['productId']]) ? $saved_options[$row['productId']] : '0';
        }

        insertCoupon($row, $product_id);
    }

    echo 'all the coupons are imported successfully';
    die();
    //die();
}
//    delete_all_orders();
//    die();
importOrdersTop();
die();

function splitOrders() {
    global $wpdb;
    /*
      $sql = "SELECT *from wp_postmeta where meta_key='_oldJson' and post_id in(SELECT wp_postmeta.post_id FROM order_split INNER JOIN wp_postmeta ON order_split.orderId = wp_postmeta.meta_value WHERE wp_postmeta.meta_key='old_order_id' GROUP BY wp_postmeta.post_id);";
      $results =$wpdb->get_results( $sql,'ARRAY_A');
      if(is_array($results) && count($results)>0) {
      foreach($results as $ress) {
      $data =  $ress['meta_value'];
      $data =json_decode($data,true);
      print_r($data);
      die();
      }
      }
     */
    $sql = "SELECT * from order_split";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    if (is_array($results) && count($results) > 0) {
        foreach ($results as $ress) {
            echo '<pre>';
            print_r($ress);
            echo '</pre>';
        }
    }
}

function addOrderAddOns() {
    $page = 5;

    $limit = 2000;

    $offset = 25000;

    global $wpdb;
    $orderItems = array();
    $orderItems['addOnNumGels'] = '404965';
    $orderItems['addOnNumDesenseGels'] = '404966';
    $orderItems['AddOnNumTrays'] = '427473';
    $orderItems['addOnNGNumTrays'] = '427469';
    $orderItems['addOnPuttySets'] = '404969';
    $orderItems['addOnBrushKits'] = '427449';
    $orderItems['addOnNumBrushHeads'] = '404971';
    echo $sql = "SELECT orderAddOns.*, order_.* from orderAddOns Join order_ on orderAddOns.orderId=order_.orderId where orderAddOns.ccResponse IN('approved','n/a') limit " . $offset . "," . $limit . "";

    $results = $wpdb->get_results($sql, 'ARRAY_A');

    if (count($results) > 0) {
        $counter = 1;
        foreach ($results as $res) {
            $mysql_query3 = "SELECT post_id,meta_value from wp_postmeta where meta_key ='old_order_id_addon' AND meta_value=" . $res["orderAddOnId"];

            $result3 = $wpdb->get_results($mysql_query3, 'ARRAY_A');
            //die();
            if (count($result3) > 0) {
                //echo 'exist';
            } else {
                importOrderAddon($orderItems, $res);
            }
        }
    }
}

function refundOrders() {
    global $wpdb;
    $page = $_GET['page_num'];

    $limit = 500;

    $offset = 3000;
    //$sql = "SELECT * from orderRefunds  limit ".$offset.",".$limit."";
    $sql = "SELECT orderRefunds.*, wp_postmeta.post_id FROM orderRefunds INNER JOIN wp_postmeta ON orderRefunds.orderId=wp_postmeta.meta_value WHERE wp_postmeta.meta_key='old_order_id' group by orderRefunds.orderId limit " . $offset . "," . $limit;

    $results = $wpdb->get_results($sql, 'ARRAY_A');

    if (count($results) > 0) {
        $counter = 1;
        foreach ($results as $res) {

            $orderId = $res['orderId'];
            $refundAmount = $res['refundAmount'];
            $refundReason = $res['refundReason'];
            $orderRefundNotes = $res['orderRefundNotes'];
            /* $sql2 = "SELECT post_id from wp_postmeta where meta_key='old_order_id' and meta_value=".$orderId;
              $results2 = $wpdb->get_results($sql2,'ARRAY_A');
              if(count( $results2 ) >0){

              foreach( $results2  as $res2) {
             */
            $orderIdNew = $res['post_id'];

            if (get_post_status($orderIdNew) == 'wc-refunded') {
                //echo 'private';
            } else {
                if ($orderIdNew != '' && $refundAmount != '' && $refundAmount > 0) {
                    $refund = wc_create_refund(array(
                        'amount' => $refundAmount,
                        'reason' => $refundReason,
                        'order_id' => $orderIdNew,
                            /* 'refund_payment' => true */
                    ));
                    if (is_wp_error($refund)) {
                        // error
                        echo $refund->get_error_message() . '=>' . $orderIdNew;
                    } else {
                        $refund_id = $refund->get_id();
                        update_post_meta($orderIdNew, 'refund_data', json_encode($res, true));

                        wp_update_post(
                                array(
                                    'ID' => $refund_id, // ID of the post to update
                                    'post_date' => $res['orderRefundDate'],
                                    'post_date_gmt' => get_gmt_from_date($res['orderRefundDate'])
                                )
                        );
                    }
                }
            }
            $counter++;
        }
    }

    die();
}

function updateOrderAddons() {
    global $wpdb;
    $mysql_query3 = "SELECT post_id,meta_value from wp_postmeta WHERE meta_key='_oldJson' and post_id IN(SELECT post_id FROM wp_postmeta WHERE meta_key='old_order_id_addon' AND meta_value!='' AND post_id>404973)";
    $result3 = $wpdb->get_results($mysql_query3, 'ARRAY_A');

    foreach ($result3 as $row) {

        $pid = $row['post_id'];
        $oldJson = $row['meta_value'];
        $oldJson = json_decode($oldJson, true);

        $trays = $oldJson['addOnNumTrays'];

        if ($trays > 0) {
            $already_added = get_post_meta($pid, 'updated_tray', true);
            if ($already_added == 'yes') {
                continue;
            }
            $order = new WC_Order($pid);
            $order->add_product(wc_get_product('404967'), $trays);
            update_post_meta($pid, 'updated_tray', 'yes');
        }
    }
}

function updateORderss() {
    global $wpdb;
    $mysql_query3 = "SELECT post_id,meta_value from wp_postmeta where meta_key ='_oldJson'";
    $result3 = $wpdb->get_results($mysql_query3, 'ARRAY_A');
    foreach ($result3 as $row) {

        $pid = $row['post_id'];
        $oldJson = $row['meta_value'];
        $oldJson = json_decode($oldJson, true);
        $oldJson['orderDate'];
        wp_update_post(
                array(
                    'ID' => $pid, // ID of the post to update
                    'post_date' => $oldJson['orderDate'],
                    'post_date_gmt' => get_gmt_from_date($oldJson['orderDate'])
                )
        );
    }
}

//updateORderss();
//die();


/*
  LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
  ,prdct.productId as ppproductId
 */

/*

  $sqlAll = "SELECT ordr.*,prdct.*,cop.*,ordercop.*,prdct.productId as ppid,cop.productId as copid, itm.productQuantity from order_  AS ordr
  LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
  LEFT JOIN product_ AS prdct ON prdct.productId=itm.productId
  LEFT JOIN order_coupon AS ordercop ON ordercop.orderId=ordr.orderId
  LEFT JOIN coupon_ AS cop ON cop.couponId=ordercop.couponId WHERE cop.couponDiscountType='flatItem' LIMIT ".$offset.",".$limit;
  $result = $wpdb->get_results($sqlAll,'ARRAY_A') or die(mysql_error());
  $sqlOrdersforUsers = "SELECT ordr.*from order_  AS ordr
  LIMIT ".$offset.",".$limit;
  $result = $wpdb->get_results($sqlOrdersforUsers,'ARRAY_A') or die(mysql_error());

  $sqlCoupons = "SELECT cop.*from coupon_  AS cop
  LIMIT ".$offset.",".$limit;
  $result = $wpdb->get_results($sqlCoupons,'ARRAY_A') or die(mysql_error());

  $sqlProductsParant = "SELECT prdct.*from product_  AS prdct WHERE prdct.parentProductId < 1
  LIMIT ".$offset.",".$limit;
  $result = $wpdb->get_results($sqlProductsParant,'ARRAY_A') or die(mysql_error());


  $sqlProductsChild = "SELECT prdct.*from product_  AS prdct WHERE prdct.parentProductId > 0
  LIMIT ".$offset.",".$limit;
  $result = $wpdb->get_results($sqlProductsChild,'ARRAY_A') or die(mysql_error());
 */
function importOrdersTop() {
    if (isset($_GET['import_order'])) {
        /*
          $sqlAll = "SELECT ordr.*,prdct.*,cop.*,ordercop.*,itm.productId as ppid,cop.productId as copid, itm.productQuantity from order_  AS ordr
          LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
          LEFT JOIN product_ AS prdct ON prdct.productId=itm.productId
          LEFT JOIN order_coupon AS ordercop ON ordercop.orderId=ordr.orderId
          LEFT JOIN coupon_ AS cop ON cop.couponId=ordercop.couponId WHERE cop.couponDiscountType='flatItem' LIMIT ".$offset.",".$limit;
         */
        global $wpdb;

        $offset = 80000;
        $offset = 20000;
        //$offset = 40000;
        //$offset = 60000;
        $limit = 20000;
        $mising_sql = " SELECT orderId FROM order_ WHERE orderId NOT IN (
    SELECT order_.orderId from order_
    JOIN wp_postmeta ON order_.orderId=wp_postmeta.meta_value
    WHERE wp_postmeta.meta_key = 'old_order_id'
) LIMIT 20000";
        // die();
        $arr = $wpdb->get_results($mising_sql, 'ARRAY_A');

        $next_arr = array();
        foreach ($arr as $r) {
            $next_arr[] = $r['orderId'];
        }
        echo '<pre>';
        print_r($next_arr);
        
        die();
        if (count($next_arr) > 0) {
            $sqlAll = "SELECT DISTINCT ordr.*,cop.couponCode,ordercop.couponDiscountTotal,itm.productQuantity, itm.productPrice from order_  AS ordr
	   LEFT JOIN order_item AS itm ON itm.orderId=ordr.orderId
       LEFT JOIN order_coupon AS ordercop ON ordercop.orderId=ordr.orderId
	   LEFT JOIN coupon_ AS cop ON cop.couponId=ordercop.couponId 
	   where ordr.orderId IN(" . implode(',', $next_arr) . ") GROUP BY ordr.orderId";
            $result = $wpdb->get_results($sqlAll, 'ARRAY_A');
            $saved_options = get_option('old_new_relation');
            if (is_array($result)) {

                foreach ($result as $row) {
                    if (already_imported($row["orderId"])) {
                        continue;
                    }
                    importOrder($row, $saved_options);
                }
            }
        }
    }
}

function importProducts() {

    $posts_relation[1] = 427574;
    $posts_relation[2] = 130253;
    $posts_relation[3] = 130252;
    $posts_relation[4] = 130251;
    $posts_relation[5] = 428644;
    $posts_relation[6] = 428645;
    $posts_relation[7] = 427572;
    $posts_relation[8] = 428646;
    $posts_relation[9] = 130256;
    $posts_relation[10] = 130255;
    $posts_relation[11] = 427602;
    $posts_relation[12] = 428641;
    $posts_relation[13] = 427568;
    $posts_relation[14] = 130246;
    $posts_relation[15] = 130247;
    $posts_relation[16] = 130248;
    $posts_relation[17] = 428642;
    $posts_relation[18] = 428643;
    $posts_relation[19] = 428640;
    $posts_relation[20] = 130259;
    $posts_relation[21] = 130258;
    $posts_relation[22] = 427704;
    $posts_relation[23] = 427575;
    $posts_relation[24] = 130265;
    $posts_relation[25] = 130264;
    $posts_relation[26] = 130263;
    $posts_relation[27] = 427576;
    $posts_relation[28] = 130267;
    $posts_relation[29] = 130261;
    $posts_relation[30] = 130260;
    $posts_relation[31] = 130266;
    $posts_relation[32] = 130262;
    $posts_relation[33] = 427577;
    $posts_relation[34] = 130268;
    $posts_relation[35] = 130269;
    $posts_relation[36] = 130270;
    $posts_relation[37] = 428648;
    $posts_relation[38] = 428535;
    $posts_relation[39] = 428548;
    update_option('old_new_relation', $posts_relation, '', 'yes');
    $saved_options = get_option('old_new_relation');
    print_r($saved_options);
    die();
    /* $sqlProductsAll = "SELECT prdct.*from product_  AS prdct";
      $result = $wpdb->get_results($sqlProductsAll,'ARRAY_A') or die(mysqli_error());
      $posts_relation =  array();
      foreach( $result as $row){
      $postId  = addProductWoo($row);
      if( $postId !='') {
      $posts_relation[$row['productId']] = $postId;
      }
      }
      delete_option('old_new_relation');
      add_option( 'old_new_relation', $posts_relation, '', 'yes' );
      $saved_options = get_option('old_new_relation');


      echo 'data is imported successfully';
     */
}

function importOrderAddon($saved_options, $data) {
    global $wpdb;

    //echo 'imported';
    $email = $data['emailAddress'];

    $couponCode = $data["couponCode"];

    $address_shipping = array(
        'first_name' => $data['shippingFirstName'],
        'last_name' => $data['shippingLastName'],
        'email' => $email,
        'phone' => $data['phoneNumber'],
        'address_1' => $data['shippingAddress'],
        'address_2' => '',
        'city' => $data['shippingCity'],
        'state' => $data['shippingState'],
        'postcode' => $data['shippingPostalCode'],
        'country' => $data['shippingCountry']
    );
    $address_billing = array(
        'first_name' => $data['billingFirstName'],
        'last_name' => $data['billingLastName'],
        'email' => $email,
        'phone' => $data['phoneNumber'],
        'address_1' => $data['billingAddress'],
        'address_2' => '',
        'city' => $data['billingCity'],
        'state' => $data['billingState'],
        'postcode' => $data['billingPostalCode'],
        'country' => $data['billingCountry']
    );

    $userfind = get_user_by('email', $email);
    $orderStatus = 'wc-completed';
    $row = $data;
    $ipAddress = $data['ipAddress'];
    $shipDate = $data['shipDate'];
    $shipmentMethod = $data['shipmentMethod'];
    $trackingCode = $data['trackingCode'];
    $shipmentMethod = $data['shipmentMethod'];


    if (!$userfind) {

        $userID = createUserWoocommerce($data);
    } else {

        $userID = $userfind->ID;
    }


    $wc_order = array(
        'post_title' => '',
        'post_excerpt' => '',
        'post_status' => $orderStatus,
        'post_author' => 1,
        'post_type' => 'shop_order',
        'post_date' => $data['addOnDate'],
        'post_date_gmt' => get_gmt_from_date($data['addOnDate'])
    );
    $neworderId = wp_insert_post($wc_order);
    /*
      $order = wc_create_order(array('status'=>$orderStatus,
      'customer_id' => $userID,
      'discount_total'=> $data["couponDiscountTotal"],
      // 'shipping_total'=>$data["orderShippingTotal"],
      //"total_tax"=>$data["orderSalesTaxTotal"],
      "total"=>$data["orderTotal"]));
     */
    $order = new WC_Order($neworderId);
    if ($data["addOnNumGels"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnNumGels']), $data["addOnNumGels"]);
    }
    if ($data["addOnNumDesenseGels"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnNumDesenseGels']), $data["addOnNumDesenseGels"]);
    }
    if ($data["AddOnNumTrays"] > 0) {
        $order->add_product(wc_get_product($saved_options['AddOnNumTrays']), $data["AddOnNumTrays"]);
    }
    if ($data["addOnNGNumTrays"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnNGNumTrays']), $data["addOnNGNumTrays"]);
    }
    if ($data["addOnPuttySets"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnPuttySets']), $data["addOnPuttySets"]);
    }
    if ($data["addOnBrushKits"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnBrushKits']), $data["addOnBrushKits"]);
    }
    if ($data["addOnNumBrushHeads"] > 0) {
        $order->add_product(wc_get_product($saved_options['addOnNumBrushHeads']), $data["addOnNumBrushHeads"]);
    }
    //'_customer_user';
    $order->set_address($address_billing, 'billing');
    $order->set_address($address_shipping, 'shipping');
    $order->set_customer_ip_address($data["ipAddress"]);
    $order->set_total($data["addOnTotal"], 'total');
    add_post_meta($order->id, '_customer_user', $userID);
    add_post_meta($order->id, 'order_number', $data['orderNumber']);

    add_post_meta($order->id, 'old_order_id', $data["orderId"]);
    add_post_meta($order->id, 'old_order_id_addon', $data["orderAddOnId"]);

    add_post_meta($order->id, '_oldJson', json_encode($data));
    /*
      wp_update_post(
      array (
      'ID'            => $order->id, // ID of the post to update
      'post_date'     =>$data['addOnDate'],
      'post_date_gmt'     =>get_gmt_from_date( $data['addOnDate'] ),
      )
      );

     */
}

function importOrder($data, $saved_options) {

    $multiStage = array(8, 9, 10, 11, 20, 21, 22, 34, 35, 36);
    global $wpdb;
    $sqlProductsChild = "SELECT * from order_item WHERE orderId =" . $data["orderId"];
    $result2 = $wpdb->get_results($sqlProductsChild, 'ARRAY_A');

    $importFlage = true;
    if (count($result2) > 0) {
        /*
          foreach($result2 as $ress){

          $productIdOld = $ress['productId'];
          if(!isset($saved_options[$ress['productId']])){
          $importFlage = false;
          break;
          }
          }
         */
        if ($importFlage) {
            $email = $data['emailAddress'];

            $couponCode = $data["couponCode"];

            $address_shipping = array(
                'first_name' => $data['shippingFirstName'],
                'last_name' => $data['shippingLastName'],
                'email' => $email,
                'phone' => $data['phoneNumber'],
                'address_1' => $data['shippingAddress'],
                'address_2' => '',
                'city' => $data['shippingCity'],
                'state' => $data['shippingState'],
                'postcode' => $data['shippingPostalCode'],
                'country' => $data['shippingCountry']
            );
            $address_billing = array(
                'first_name' => $data['billingFirstName'],
                'last_name' => $data['billingLastName'],
                'email' => $email,
                'phone' => $data['phoneNumber'],
                'address_1' => $data['billingAddress'],
                'address_2' => '',
                'city' => $data['billingCity'],
                'state' => $data['billingState'],
                'postcode' => $data['billingPostalCode'],
                'country' => $data['billingCountry']
            );

            $orderStatus = 'wc-pending';
            $userfind = get_user_by('email', $email);


            if (in_array($productIdOld, $multiStage)) {


                if ($data["shipDate"] == '') {
                    $orderStatus = 'wc-pending';
                }
                if ($data["shipDate"] != '' && $data["receiveDateImpressions"] == '' && $data["shipDateTrays"] == '') {
                    $orderStatus = 'wc-processing';
                }
                if ($data["shipDate"] != '' && $data["receiveDateImpressions"] != '' && $data["shipDateTrays"] == '') {
                    $orderStatus = 'wc-partial-comp';
                }
                if ($data["shipDate"] != '' && $data["receiveDateImpressions"] != '' && $data["shipDateTrays"] != '') {
                    $orderStatus = 'wc-completed';
                }
            } else {
                if ($data["shipDate"] == '') {
                    $orderStatus = 'wc-pending';
                } else {
                    $orderStatus = 'wc-completed';
                }
            }

            $row = $data;
            $ipAddress = $data['ipAddress'];
            $shipDate = $data['shipDate'];
            $shipmentMethod = $data['shipmentMethod'];
            $trackingCode = $data['trackingCode'];
            $shipmentMethod = $data['shipmentMethod'];


            if (!$userfind) {

                $userID = createUserWoocommerce($data);
            } else {

                $userID = $userfind->ID;
            }


            $wc_order = array(
                'post_title' => '',
                'post_excerpt' => '',
                'post_status' => $orderStatus,
                'post_author' => 1,
                'post_type' => 'shop_order',
                'post_date' => $data['orderDate'],
                'post_date_gmt' => get_gmt_from_date($data['orderDate'])
            );
            $neworderId = wp_insert_post($wc_order);
            /*
              $order = wc_create_order(array('status'=>$orderStatus,
              'customer_id' => $userID,
              'discount_total'=> $data["couponDiscountTotal"],
              // 'shipping_total'=>$data["orderShippingTotal"],
              //"total_tax"=>$data["orderSalesTaxTotal"],
              "total"=>$data["orderTotal"]));
             */
            $order = new WC_Order($neworderId);
            $products_arr =array();
            foreach ($result2 as $ress) {
                $product_id = isset($saved_options[$ress['productId']]) ? $saved_options[$ress['productId']] : '428734';
                update_post_meta($product_id, "_price", $ress['productPrice']);
                update_post_meta($product_id, "_regular_price", $ress['productPrice']);
                $order->add_product(wc_get_product($product_id), $ress['productQuantity']);
                $products_arr[$product_id] = $ress['productPrice'];
            }
            //'_customer_user';
            $order->set_address($address_billing, 'billing');
            $order->set_address($address_shipping, 'shipping');
            $order->set_customer_ip_address($data["ipAddress"]);
            //$order->set_total($data["couponDiscountTotal"], 'cart_discount');
            $order->set_total($data["orderTotal"], 'total');
            if ($data['orderNotes'] != '') {
                $order->add_order_note($data['orderNotes']);
            }
            //$order->save();
            update_post_meta($order->id, '_customer_user', $userID);
            update_post_meta($order->id, 'order_number', $data['orderNumber']);
            update_post_meta($order->id, 'order_shipping', $data['orderShippingTotal']);
            update_post_meta($order->id, 'order_taxes', $data['orderSalesTaxTotal']);
            update_post_meta($order->id, 'coupon_code', $couponCode);
            update_post_meta($order->id, 'old_order_id', $data["orderId"]);
            update_post_meta($order->id, '_oldJson', json_encode($data));
            if($couponCode!=''){
                $item = new WC_Order_Item_Coupon();
                $item->set_props(array('code' => $couponCode, 'discount' => $data["couponDiscountTotal"], 'discount_tax' => 0));
                $order->add_item($item);
                update_post_meta($neworderId, 'coupon_applied', 'yes');
            }
            $order->calculate_totals();
            foreach($products_arr as $key => $pr){
                update_post_meta($key, "_price", $pr);
                update_post_meta($key, "_regular_price", $pr);
            }
            /*
              wp_update_post(
              array (
              'ID'            => $order->id,
              'post_date'     =>$data['orderDate'],
              )
              );
             */
        }
    }
}

function createUserWoocommerce($data) {
    global $influencers;
    $email = $data['emailAddress'];
    $address_shipping = array(
        'first_name' => $data['shippingFirstName'],
        'last_name' => $data['shippingLastName'],
        'email' => $email,
        'phone' => $data['phoneNumber'],
        'address_1' => $data['shippingAddress'],
        'address_2' => '',
        'city' => $data['shippingCity'],
        'state' => $data['shippingState'],
        'postcode' => $data['shippingPostalCode'],
        'country' => $data['shippingCountry']
    );
    $address_billing = array(
        'first_name' => $data['billingFirstName'],
        'last_name' => $data['billingLastName'],
        'email' => $email,
        'phone' => $data['phoneNumber'],
        'address_1' => $data['billingAddress'],
        'address_2' => '',
        'city' => $data['billingCity'],
        'state' => $data['billingState'],
        'postcode' => $data['billingPostalCode'],
        'country' => $data['billingCountry']
    );

    $default_password = wp_generate_password();
    $userfind = get_user_by('login', $email);
    $arr = array(
        'user_login' => $email,
        'user_pass' => $default_password,
        'user_email' => $email,
        'first_name' => ucfirst(strtolower($address_shipping['first_name'])),
        'last_name' => $address_shipping['last_name'],
        'display_name' => $address_shipping['first_name'] . ' ' . $address_shipping['last_name'],
        'role' => 'customer'
    );

    if (!$userfind) {

        $user = wp_insert_user($arr);
        update_user_meta($user, "first_name", ucfirst(strtolower($address_shipping['first_name'])));
        update_user_meta($user, "last_name", $address_shipping['last_name']);
        update_user_meta($user, "billing_first_name", $address_billing['first_name']);
        update_user_meta($user, "billing_first_name", $address_billing['first_name']);
        update_user_meta($user, "billing_last_name", $address_billing['last_name']);

        update_user_meta($user, "billing_email", $address_billing['email']);
        update_user_meta($user, "billing_address_1", $address_billing['address_1']);
        update_user_meta($user, "billing_address_2", $address_billing['address_2']);
        update_user_meta($user, "billing_city", $address_billing['city']);
        update_user_meta($user, "billing_postcode", $address_billing['postcode']);
        update_user_meta($user, "billing_country", $address_billing['country']);
        update_user_meta($user, "billing_state", $address_billing['state']);
        update_user_meta($user, "billing_phone", $address_billing['phone']);
        update_user_meta($user, "shipping_first_name", $address_shipping['first_name']);
        update_user_meta($user, "shipping_last_name", $address_shipping['last_name']);

        update_user_meta($user, "shipping_address_1", $address_shipping['address_1']);
        update_user_meta($user, "shipping_address_2", $address_shipping['address_2']);
        update_user_meta($user, "shipping_city", $address_shipping['city']);
        update_user_meta($user, "shipping_postcode", $address_shipping['postcode']);
        update_user_meta($user, "shipping_country", $address_shipping['country']);
        update_user_meta($user, "shipping_state", $address_shipping['state']);
        update_user_meta($user, "_user_pass", $default_password);
        update_user_meta($user, "order_id", $data["orderId"]);
        if (in_array($couponId, $influencers)) {
            update_user_meta($user, "_influencer", true);
            update_user_meta($user, "_coupon_id", $couponId);
        }
        return $user;
    } else {
        return $userfind->ID;
    }
}

function Generate_Featured_Image($image_url, $post_id, $meta_key = '') {
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if (wp_mkdir_p($upload_dir['path']))
        $file = $upload_dir['path'] . '/' . $filename;
    else
        $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    $res1 = wp_update_attachment_metadata($attach_id, $attach_data);
    if ($meta_key == '') {
        $res2 = set_post_thumbnail($post_id, $attach_id);
    } else {
        update_post_meta($post_id, $meta_key, $attach_id);
    }
    return $attach_id;
}

function findPostBySlug($slug, $postType) {
    $args = array(
        'name' => $slug,
        'post_type' => $postType,
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $my_posts = get_posts($args);
    if ($my_posts) {
        return $my_posts[0]->ID;
    } else {
        return false;
    }
}

/* * ************************************************** add coupon************************************************************************* */

function insertCoupon($row, $ids) {
    $couponId = $row['couponId'];
    $couponType = $row['couponType'];
    $couponDiscountType = $row['couponDiscountType'];
    //$couponProductID = $row['copid'];
    $couponDiscount = $row['couponDiscount'];
    switch ($couponDiscountType) {
        case "percentage":
            $discount_type = 'percent';
            $couponDiscount = $couponDiscount * 100;
            break;
        case "flatItem":
            $discount_type = 'fixed_product';
            break;
        case "flatGlobal":
            $discount_type = 'fixed_cart';
            break;
        default:
            $discount_type = 'percent';
    }

    $couponCode = $row['couponCode'];
    $couponDescription = $row['couponDescription'];
    $endDateCoupon = $row['endDate'];
    $startDateCoupon = $row['startDate'];
    $couponShippingFree = $row['shippingFree'];
    $couponSalesTaxFree = $row['salesTaxFree'];
    $new_coupon_id = findPostBySlug($couponCode, 'shop_coupon');
    if (!$new_coupon_id) {
        $coupon = array(
            'post_title' => $couponCode,
            'post_content' => $couponDescription,
            'post_excerpt' => $couponDescription,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );

        $new_coupon_id = wp_insert_post($coupon);

// Add meta coupon
        update_post_meta($new_coupon_id, 'discount_type', $discount_type);
        update_post_meta($new_coupon_id, 'coupon_amount', $couponDiscount);
        if ($couponType == 'global') {
            update_post_meta($new_coupon_id, 'individual_use', 'no');
            if ($row['globalQtyAvailable'] < 0) {
                update_post_meta($new_coupon_id, 'usage_limit', '');
            } else {
                update_post_meta($new_coupon_id, 'usage_limit', $row['globalQtyAvailable']);
            }
            update_post_meta($new_coupon_id, 'usage_count', $row['globalQtyUsed']);
        } else {
            update_post_meta($new_coupon_id, 'individual_use', 'yes');
            update_post_meta($new_coupon_id, 'product_ids', $ids);
            if ($row['productQtyAvailable'] < 0) {
                update_post_meta($new_coupon_id, 'usage_limit', '');
            } else {
                update_post_meta($new_coupon_id, 'usage_limit', $row['productQtyAvailable']);
            }
            update_post_meta($new_coupon_id, 'usage_count', $row['productQtyUsed']);
        }

        $endDateCoupon2 = str_replace("-", "", $endDateCoupon);
        $endDateCoupon2 = str_replace(":", "", $endDateCoupon2);
        if ($endDateCoupon2 > 0) {

            update_post_meta($new_coupon_id, 'expiry_date', date('Y-m-d', strtotime($endDateCoupon)));
        }
        update_post_meta($new_coupon_id, 'apply_before_tax', strtolower($nnSalesTaxFree));
        update_post_meta($new_coupon_id, 'free_shipping', strtolower($couponShippingFree));
        update_post_meta($new_coupon_id, 'createdTime', $row['createdTime']);
        update_post_meta($new_coupon_id, 'lastUpdateUser', $row['lastUpdateUser']);
        update_post_meta($new_coupon_id, 'startDate', $row['startDate']);
        update_post_meta($new_coupon_id, 'lastUpdateTime', $row['lastUpdateTime']);
    }
}

/* * ************************************************** add coupon END************************************************************************* */

/* * ******************************************* add Product***************************************************** */

function addProductWoo($row) {

    $proudctId = $row['productId'];
    $proudctSKU = $row['productSKU'];
    $productType = $row['productType'];
    $productSlugParent = $row['productSlug'];
    $productSlugChild = $row['productSlugChild'];
    $parentProductId = $row['parentProductId'];
    $productNameFull = $row['productNameFull'];
    $productNameCart = $row['productNameCart'];
    $productNameOption = $row['productNameOption'];
    $productPrice = $row['productPrice'];
    $productPriceOriginal = $row['productPriceOriginal'];
    $productCostHandling = $row['productCostHandling'];
    $productCostOther = $row['productCostOther'];
    $productWeightOther = $row['productWeightOther'];
    $post_id = '';
    if ($parentProductId > 0) {
        $productImageFull = 'https://www.smilebrilliant.com/static/images/product/' . $row['productImageFull'];
        $productImageFullNoShadow = 'https://www.smilebrilliant.com/static/images/product/' . $row['productImageFullNoShadow'];
        $productImageThumb = 'https://www.smilebrilliant.com/static/images/product/' . $row['productImageThumb'];
        $productImageThumbNoShadow = 'https://www.smilebrilliant.com/static/images/product/' . $row['productImageThumbNoShadow'];
        $productImageShare = 'https://www.smilebrilliant.com/static/images/product/' . $row['productImageShare'];
        $productPageDescription = isset($row['productPageDescription']) ? $row['productPageDescription'] : 'no content';
        // $post_id = findPostBySlug($productSlugChild,'product');
        // if(!$post_id) {

        $post_id = wp_insert_post(array(
            'post_title' => $productNameFull,
            'post_content' => $productPageDescription,
            'post_status' => 'publish',
            'post_type' => "product",
                //'post_name' => $productSlugChild,
        ));
        wp_set_object_terms($post_id, 'simple', 'product_type');
        wp_set_object_terms($post_id, $productType, 'type');
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, '_downloadable', 'no');
        update_post_meta($post_id, '_virtual', 'yes');
        update_post_meta($post_id, '_regular_price', $productPrice);
        update_post_meta($post_id, '_sale_price', '');
        update_post_meta($post_id, '_purchase_note', '');
        update_post_meta($post_id, '_featured', 'no');
        update_post_meta($post_id, '_weight', '');
        update_post_meta($post_id, '_length', '');
        update_post_meta($post_id, '_width', '');
        update_post_meta($post_id, '_height', '');
        update_post_meta($post_id, '_sku', $proudctSKU);
        update_post_meta($post_id, '_product_attributes', array());
        update_post_meta($post_id, '_sale_price_dates_from', '');
        update_post_meta($post_id, '_sale_price_dates_to', '');
        update_post_meta($post_id, '_price', $productPrice);
        update_post_meta($post_id, '_sold_individually', '');
        update_post_meta($post_id, '_manage_stock', 'no');
        update_post_meta($post_id, '_backorders', 'no');
        update_post_meta($post_id, '_stock', '');
        update_post_meta($post_id, '_old_product_id', $proudctId);
        update_post_meta($post_id, 'type', $proudctId);
        update_post_meta($post_id, 'productPriceOriginal', $productPriceOriginal);
        update_post_meta($post_id, 'productCostHandling', $productCostHandling);
        update_post_meta($post_id, 'productCostOther', $productCostOther);
        update_post_meta($post_id, 'productWeightOther', $productWeightOther);
        update_post_meta($post_id, 'productImageThumb', $productImageThumb);
        update_post_meta($post_id, 'productImageThumbNoShadow', $productImageThumbNoShadow);
        update_post_meta($post_id, 'productImageShare', $productImageShare);
        update_post_meta($post_id, 'productImageFullNoShadow', $productImageFullNoShadow);
        update_post_meta($post_id, 'productImageFull', $productImageFull);
        if ($row['productImageFull'] != '') {
            //Generate_Featured_Image($productImageFull,$post_id,'');
        }
        /*
          if($row['productImageFullNoShadow'] != '') {
          Generate_Featured_Image($productImageFullNoShadow,$post_id,'productImageFullNoShadow');
          }

          if($row['productImageThumb'] != '') {
          Generate_Featured_Image($productImageThumb,$post_id,'productImageThumb');
          }
          if($row['productImageThumbNoShadow'] != '') {
          Generate_Featured_Image($productImageThumbNoShadow,$post_id,'productImageThumbNoShadow');
          }
          if($row['productImageShare'] != '') {
          Generate_Featured_Image($productImageShare,$post_id,'productImageShare');
          }
         */
        wp_set_object_terms($post_id, $productSlugParent, 'product_cat', true);
    }
    //}
    return $post_id;
}

/* * ***************************************** add product End********************************************************** */

function insertCouponOrder($coupon_id, $order_id, $amount, $date) {

    global $wpdb;
    $table = $wpdb->prefix . 'wc_order_coupon_lookup';
    $data = array('order_id' => $order_id, 'coupon_id' => $coupon_id, 'discount_amount' => $amount, 'date_created' => $date);
    $wpdb->insert($table, $data);
}

$nextnumber = $page + 1;
if ($nextnumber == 0) {
    $nextnumber = 1;
}
echo $nextnumber;

//die();
// header("Location: ".home_url()."/import?page_num=".$nextnumber."&import_order=true"); 
function already_imported($val) {
    global $wpdb;

    $sqlQuery = "select post_id from wp_postmeta where meta_key='old_order_id' AND meta_value=" . $val;
    $results = $wpdb->get_results($sqlQuery);
    if (count($results) > 0) {
        return true;
    } else {
        return false;
    }

    //die();
}

function delete_all_orders() {
    global $wpdb;
    echo $sq11 = "select ID from wp_posts where post_type='shop_order' LIMIT 1000";
    $result = $wpdb->get_results($sq11, 'ARRAY_A');
    foreach ($result as $row) {
        $post_id = $row['ID'];
        wp_delete_post($post_id, true);
    }
    die();
}
?>
<script>

    location_new = "<?php echo home_url(); ?>/import?page_num=<?php echo $nextnumber; ?>&import_order=true";

    window.location = location_new;

</script>
