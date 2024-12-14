<?php
/*
 * 
 */

function wpdocs_register_lagacy_import_menu() {
    add_menu_page(
            __('Import Data', 'sbr'), 'Import Data', 'manage_options', 'import-lagacy-data', 'ImportLAgacydata', 'https://www.smilebrilliant.com/wp-content/uploads/2020/08/favicon-96x96-1.png', 6
    );
}

function ImportLAgacydata() {
    ?>
    <h2> Import Data</h2>
    <div class="ajax-ress" style="display:none"><h3>Importing.....</h3></div>
    <div class="loading-sbr"><div class="inner-sbr"></div></div>
    <?php
    
     global $wpdb;
     /*
    $sqll = "SELECT * FROM wp_woocommerce_order_itemmeta WHERE meta_key = '_product_id' AND meta_value = 427449";
    $qq_rows = $wpdb->get_results($sqll, 'ARRAY_A') or die($wpdb->last_error);
    print_r($qq_rows);
    foreach ($qq_rows as $rr) {
        $order_item_id = $rr['order_item_id'];
        $product_id = $rr['meta_value'];
        $meta_id = $rr['meta_id'];
   
        $updated_item_id = 130265;
        $updated_item_name = 'Individual Package: cariPRO Ultrasonic Electric toothbrush with 2 replacement brush heads';
        
        $sql_updated_1 = "UPDATE wp_woocommerce_order_items SET order_item_name='".$updated_item_name."' WHERE order_item_id=".$order_item_id;

        $sql_updated_2 = "UPDATE wp_woocommerce_order_itemmeta SET meta_value='".$updated_item_id."' WHERE meta_id=".$meta_id;
        $wpdb->query($sql_updated_1);
        $wpdb->query($sql_updated_2);
       // die();
    }
    */
   
    
    $sqlCouponsNew = "SELECT count(cop.couponId) as cnt FROM coupon_  AS cop WHERE cop.couponId NOT IN(SELECT couponId FROM coupon_ INNER JOIN wp_posts ON coupon_.couponCode = wp_posts.post_title)";
    $pedningImpport_Coupons = $wpdb->get_results($sqlCouponsNew, 'ARRAY_A') or die($wpdb->last_error);
    $missingOrdersSql = "SELECT COUNT(orderId) as cnt FROM order_ WHERE orderId NOT IN (
    SELECT order_.orderId FROM order_
    JOIN wp_postmeta ON order_.orderId=wp_postmeta.meta_value
    WHERE wp_postmeta.meta_key = 'old_order_id'
)";
    $pedningImpport_orders = $wpdb->get_results($missingOrdersSql, 'ARRAY_A') or die($wpdb->last_error);
    $missingAddonsSql = "SELECT COUNT(orderAddOns.orderAddOnId) as cnt FROM orderAddOns JOIN order_ ON orderAddOns.orderId=order_.orderId WHERE orderAddOns.ccResponse IN('approved','n/a') AND orderAddOns.orderAddOnId NOT IN (SELECT orderAddOns.orderAddOnId FROM orderAddOns
    JOIN wp_postmeta ON orderAddOns.orderAddOnId=wp_postmeta.meta_value
    WHERE wp_postmeta.meta_key = 'old_order_id_addon')";
    $pedningImpport_order_addons =  $wpdb->get_results($missingAddonsSql, 'ARRAY_A') or die($wpdb->last_error);
    
    $updateordersSql = "SELECT count(post_id) as cnt, post_id,meta_value FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id= wp_posts.ID WHERE meta_key ='_oldJson' AND post_status NOT IN('wc-refunded','wc-completed') ORDER BY ID DESC";
    $updateordersSqlCount =  $wpdb->get_results($updateordersSql, 'ARRAY_A') or die($wpdb->last_error);
    
    $refundordersSql = "SELECT COUNT(post_id) as cnt, orderRefunds.*, wp_postmeta.post_id FROM orderRefunds INNER JOIN wp_postmeta ON orderRefunds.orderId=wp_postmeta.meta_value WHERE wp_postmeta.meta_key='old_order_id' AND post_id NOT IN(SELECT post_parent  FROM wp_posts WHERE post_type='shop_order_refund')";
    $refundordersSqlCount =  $wpdb->get_results($refundordersSql, 'ARRAY_A') or die($wpdb->last_error);
    $pedningImpport_split_orders = 0;
    ?>
    <audio id="my_audio" src="https://www.soundjay.com/buttons/sounds/beep-01a.mp3" loop="loop"></audio>
    <a href="javascript:void(0)" class="import-pending-coupons" style="display:block"> Import Coupons (<?php echo $pedningImpport_Coupons[0]['cnt']; ?>)</a>
    <a href="javascript:void(0)" class="import-pending-orders" style="display:block"> Import Orders (<?php echo $pedningImpport_orders[0]['cnt']; ?>)</a>
    <a href="javascript:void(0)" class="import-pending-orders-addons" style="display:block"> Import Order Addons (<?php echo $pedningImpport_order_addons[0]['cnt']; ?>)</a>
    <a href="javascript:void(0)" class="import-refund-split" style="display:block"> Import refund Orders(<?php echo $refundordersSqlCount[0]['cnt']; ?>) </a>
    <a href="javascript:void(0)" class="sysc-coupons" style="display:block"> Sync Coupons </a>
<!--     <a href="javascript:void(0)" class="sysc-orders" style="display:block"> Update Orders (<?php //echo $updateordersSqlCount[0]['cnt']; ?>)</a>-->
    

    <script>
        jQuery(document).on('click', '.sysc-coupons', function () {
            jQuery('.ajax-ress').show();
            jQuery('.loading-sbr').show();

            jQuery('.ajax-ress').html('<h3>Importing.....</h3>');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=updateCouponCodeLimits',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Import Done</h3>');
                    jQuery('.loading-sbr').hide();
                }
            })
        });
        jQuery(document).on('click', '.import-pending-coupons', function () {
            jQuery('.ajax-ress').show();
            jQuery('.loading-sbr').show();

            jQuery('.ajax-ress').html('<h3>Importing.....</h3>');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=insertMissingCoupons',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Import Done</h3>');
                    jQuery('.loading-sbr').hide();
                }
            })
        });
        jQuery(document).on('click', '.import-refund-split', function () {
            jQuery('.ajax-ress').show();
            jQuery('.loading-sbr').show();

            jQuery('.ajax-ress').html('<h3>Importing.....</h3>');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=refundOrders',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Import Done</h3>');
                    jQuery('.loading-sbr').hide();
                }
            })
        });
        
        jQuery(document).on('click', '.sysc-orders', function () {
            jQuery('.ajax-ress').show();
            jQuery('.loading-sbr').show();
              jQuery("#my_audio").get(0).pause();

            jQuery('.ajax-ress').html('<h3>Syncing.....</h3>');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=updateORderss',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Import Done</h3>');
                    jQuery('.loading-sbr').hide();
                    jQuery("#my_audio").get(0).play();
                }
            })
        });
        
        jQuery(document).on('click', '.import-pending-orders', function () {
        
        jQuery("#my_audio").get(0).pause();
       
        
            jQuery('.ajax-ress').show();
            jQuery('.ajax-ress').html('<h3>Adding.....</h3>');
            jQuery('.loading-sbr').show();
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=importOrder_top',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Flush Done</h3>');
                    jQuery('.loading-sbr').hide();
                     jQuery("#my_audio").get(0).play();
                    
                }
            })
        });
        jQuery(document).on('click', '.import-pending-orders-addons', function () {
        
        //jQuery("#my_audio").get(0).pause();
       
        
            jQuery('.ajax-ress').show();
            jQuery('.ajax-ress').html('<h3>Adding.....</h3>');
            jQuery('.loading-sbr').show();
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=addOrderAddOns',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Flush Done</h3>');
                    jQuery('.loading-sbr').hide();
                    // jQuery("#my_audio").get(0).play();
                    
                }
            })
        });
        
    </script>
    <?php
}

add_action('admin_menu', 'wpdocs_register_lagacy_import_menu');
add_action('admin_menu', 'wpdocs_register_lagacy_compare_data');
function wpdocs_register_lagacy_compare_data(){
    add_menu_page(
            __('Compare Data', 'sbr'), 'Compare Data', 'manage_options', 'campare-lagacy-data', 'CompareLacydata', 'https://www.smilebrilliant.com/wp-content/uploads/2020/08/favicon-96x96-1.png', 6
    );
}
function CompareLacydata() {
    global $wpdb;
    echo '<h2>Last Two Month Orders</h2>';
    $sql ="SELECT * FROM order_ WHERE DATE(orderDate) >= '2021-10-01'";
   // $sql="SELECT order_.* , wp_posts.post_status,wp_posts.ID FROM order_ INNER JOIN wp_postmeta ON order_.orderId = wp_postmeta.meta_value INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE wp_postmeta.meta_key='old_order_id' AND post_type='shop_order' AND (DATE(orderDate) BETWEEN '2021-06-01' AND '2021-08-01') GROUP BY orderId ORDER BY orderId ASC";
   $sql="SELECT order_.* , wp_posts.post_status,wp_posts.ID FROM order_ INNER JOIN wp_postmeta ON order_.orderId = wp_postmeta.meta_value INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE wp_postmeta.meta_key='old_order_id' AND post_type='shop_order' AND DATE(orderDate) >= '2021-10-01' GROUP BY orderId ORDER BY orderId ASC";
    
    $results =  $wpdb->get_results($sql, 'ARRAY_A') or die($wpdb->last_error);
    echo '<style>.row-mbt {
    display: block;
    margin-bottom: 10px;
    height: 20px;
    clear:both;
}
.row-mbt div{
width:14.28% !important;
height: 15px;
float:left;
}

</style>';
     echo '<div style="width:100%" class="row-mbt"><div style="width:16.66%;float:left">Nimber</div><div style="width:16.66%;float:left">ORder Number</div><div style="width:16.66%;float:left">Sbr Number</div><div style="width:16.66%;float:left"> Impression Received</div> <div style="width:16.66%;float:left">Tracking Code</div> <div style="width:16.66%;float:left">Existing Status</div> <div style="width:16.66%;float:left">New Status</div></div>';
     $counter = 1;
     foreach($results as $data){
       
    if (isset($data["orderDate"])) {

            if (isset($data["trayNumber"]) && $data["trayNumber"] != '') {


                if ($data["shipDate"] == 0) {
                    $orderStatus = 'wc-processing';
                }
                if ($data["shipDate"] != 0 && $data["receiveDateImpressions"] == 0 && $data["shipDateTrays"] == 0) {
                    $orderStatus = 'wc-processing';
                }
                if ($data["shipDate"] != 0 && $data["receiveDateImpressions"] != 0 && $data["shipDateTrays"] == 0) {
                    $orderStatus = 'wc-partial_ship';
                   
                }
                if ($data["shipDate"] != 0 && $data["receiveDateImpressions"] != 0 && $data["shipDateTrays"] != 0) {
                    $orderStatus = 'wc-completed';
                }
            } else {
                if ($data["shipDate"] == 0 || $data["shipDate"] == '0' || $data["shipDate"] == '') {
                    $orderStatus = 'wc-processing';
                } else {
                    $orderStatus = 'wc-completed';
                }
            }
            $not_matched = "";
            if($orderStatus!=$data["post_status"]){
                 $not_matched = "color:red";
                 /*
                 if('wc-refunded' != $data["post_status"]){
                 
                 wp_update_post(
                                array(
                                    'ID' => $data["ID"], // ID of the post to update
                                    'post_status' => $orderStatus,
                                )
                        );
                  
                 }
                 */
                 
            }
            $trackingCode = $data["trackingCode"];
            $receiveDateImpressions = $data["receiveDateImpressions"];
            $sql_new = "SELECT post_status FROM wp_posts WHERE ID = (SELECT post_id FROM wp_postmeta WHERE meta_key='order_number' AND meta_value='".$data["orderNumber"]."')";
            echo '<div style="width:100%" class="row-mbt"><div style="width:16.66%;float:left">'.$counter.'</div><div style="width:16.66%;float:left">'.$data["orderId"].'</div><div style="width:16.66%;float:left">'.$data["orderNumber"].'</div><div style="width:16.66%;float:left">'.$receiveDateImpressions.'</div> <div style="width:16.66%;float:left">'.$trackingCode.'</div> <div style="width:16.66%;float:left"><a href="'.get_edit_post_link($data["ID"]).'" target="_blank">'.$orderStatus.'</a></div> <div style="width:16.66%;float:left;'.$not_matched.'">'.$data["post_status"].'</div></div>';
       $counter++;
            }
    }
    
   
}
?>