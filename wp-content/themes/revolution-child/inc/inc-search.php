<?php
/*
 * Admin Search
 */
/*
 * Batch Printing
 * 
 */
function batch_search_singular($pname,$Qty){
     global $wpdb;
     $arr_ids = array();
     $product_name=  get_the_title($pname);
     $name_check = "AND wp_woocommerce_order_items.order_item_name ='" . $product_name . "'";
     $qty_join = "INNER JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_itemmeta.order_item_id=wp_woocommerce_order_items.order_item_id";
     $qty_check = "AND wp_woocommerce_order_itemmeta.meta_key = '_qty' AND wp_woocommerce_order_itemmeta.meta_value=$Qty";
     $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
            $Condition_three_way = "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
           $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
            WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status IN ('wc-processing' , 'wc-partial_ship') $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
           // die();
         
           $results = $wpdb->get_results($sql, 'ARRAY_A');
           foreach ($results as $res) {
                    $arr_ids[]=$res['order_id'];
                }
               return $arr_ids;
}
function batchPrinrting($query) {
    if (is_admin() && $query->get('post_type') == 'shop_order') {
        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            global $wpdb;
            $product_name = isset($_GET['product_id']) ? $_GET['product_id'] : array();
            $add_array = '';
            $name_check = '';
            $post_id_include = array(22222222222);
            $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : '';
            $qty_join = '';
            $qty_check='';
            $counter=0;
            $order_ids = array();
            if(count($product_name)>0){
            foreach ($product_name as $pp){
                 $found_orders = batch_search_singular($pp,$product_qty[$counter]);
                 if($counter==0){
                     foreach ($found_orders as $dd){
                         $order_ids[]= $dd; 
                     }
                 }
                 else{
                     $delitems = array();
                     foreach($order_ids as $key=>$ndd){
                         if(!in_array($ndd,$found_orders)){
                             $delitems[]= $ndd;
                             unset($order_ids[$key]);
                         }
                         
                     }
                 }
                 $counter++;
            }
            $post_id_include = $order_ids;
            }
            else{
            $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
            $Condition_three_way = "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
            $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
            WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status = 'wc-on-hold' $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
//            $Condition_three_way = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'threeWayShipment' AND meta_value='yes'";
//            echo $sql = "SELECT DISTINCT ID FROM wp_posts where ID NOT IN (".$Condition_three_way.") AND wp_posts.post_type='shop_order' AND wp_posts.post_status = 'wc-on-hold'";
           $results = $wpdb->get_results($sql, 'ARRAY_A');
            if (count($results) > 0) {
                $counter = 0;
                foreach ($results as $res) {

                    $post_id_include[] = $res['order_id'];
                }
            }
            }
            if(empty($post_id_include)){
                $post_id_include = array(22222222222);
            }
            $query->query_vars['post__in'] = $post_id_include;
            // }
        }
        return $query;
        //die();
    }
}
// filter for searching orders based on old order id
function includeOldOrderIdInSearchAdminSide($query) {

    //if we're on the admin panel, or it's a search, or it's not the post type we want to filter, return the original query
    $advance_search = isset($_GET['advance_search']) ? $_GET['advance_search'] : '';
    //die();
    if (is_admin() && $query->get('post_type') == 'shop_order' && $advance_search != '') {
        $trayOrderId = '';
        global $wpdb;
        $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
        $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
        $customer_email_address = isset($_GET['customer_email_address']) ? $_GET['customer_email_address'] : '';
        $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';
        $tray_number = isset($_GET['tray_number']) ? $_GET['tray_number'] : '';
        $sbr_number = isset($_GET['sbr_number']) ? $_GET['sbr_number'] : '';
        $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
        $product_status = isset($_GET['product_status']) ? $_GET['product_status'] : '';
        $order_ids = array();
       
        $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
        $post_id_include = array(55555555555555);
        $sql = 'SELECT DISTINCT P.ID from wp_posts P';
        $meta_query = false;
        if ($order_number != '') {
            $sql .= ' INNER JOIN wp_postmeta oldorderid  ON P.ID=oldorderid.post_id AND (oldorderid.meta_key="old_order_id" AND oldorderid.meta_value=' . $order_number . ' OR oldorderid.post_id=' . $order_number . ')';
            $meta_query = true;
        }
        if ($sbr_number != '') {
            $sql .= ' INNER JOIN wp_postmeta sbrnumber  ON P.ID=sbrnumber.post_id AND sbrnumber.meta_key="order_number" AND sbrnumber.meta_value="' . $sbr_number . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="order_number" AND wp_postmeta.meta_value='.$sbr_number;
        }
        if ($customer_first_name != '') {
            $sql .= ' INNER JOIN wp_postmeta cmfrstname  ON P.ID=cmfrstname.post_id AND cmfrstname.meta_key="_billing_first_name" AND cmfrstname.meta_value="' . $customer_first_name . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_first_name" AND wp_postmeta.meta_value="'.$customer_first_name.'"';
        }
        if ($customer_last_name != '') {
            $sql .= ' INNER JOIN wp_postmeta cmlstname  ON P.ID=cmlstname.post_id AND cmlstname.meta_key="_billing_last_name" AND cmlstname.meta_value="' . $customer_last_name . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_last_name" AND wp_postmeta.meta_value="'.$customer_last_name.'"';
        }
        if ($customer_email_address != '') {
            $sql .= ' INNER JOIN wp_postmeta billingemail  ON P.ID=billingemail.post_id AND billingemail.meta_key="_billing_email" AND billingemail.meta_value="' . $customer_email_address . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_email" AND wp_postmeta.meta_value="'.$customer_email_address.'"';
        }
        if ($tray_number != '') {
            $trayOrderId = $wpdb->get_var("SELECT order_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $tray_number");

            $jJosn_string = '{"trayNumber": "' . $tray_number . '"}';
            $sql .= " INNER JOIN wp_postmeta traynumber  ON P.ID=traynumber.post_id AND traynumber.meta_key='_oldJson' AND JSON_CONTAINS(traynumber.meta_value,'$jJosn_string')";
            $meta_query = true;


            //$sql .=' AND wp_postmeta.meta_key="_billing_email" AND wp_postmeta.meta_value="'.$customer_email_address.'"';
        }


        if ($order_start_date != '' && $order_end_date != '') {
            $order_start_date = $order_start_date . ' 00:00:00';
            $order_end_date = $order_end_date . ' 23:59:59';

            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
            }
        } else if ($order_start_date != '') {

            $order_start_date = $order_start_date . ' 00:00:00';
            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt >= "' . $order_start_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt >= "' . $order_start_date . '"';
            }
        } else if ($order_end_date != '') {
            $order_end_date = $order_end_date . ' 23:59:59';
            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt =< "' . $order_end_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt =< "' . $order_end_date . '"';
            }
        }

  
        $results = $wpdb->get_results($sql, 'ARRAY_A');
        if (count($results) > 0) {
            
            $counter = 0;
            foreach ($results as $res) {

                $post_id_include[] = $res['ID'];
            }
        }
        if (!empty($trayOrderId)) {
            $post_id_include[] = $trayOrderId;
        }
        if(count($order_ids)>0){
            foreach($order_ids as $idd){
            $post_id_include[] = $idd;
            }    
        }
        
        
        // echo '<pre>';
        // print_r($post_id_include);
        // echo '</pre>';
        // die;
        //if(count($post_id_include)>0) {     
       $query->query_vars['post__in'] = $post_id_include;
         if($product_status!=''){
             
            $order_ids = get_orders_product_status($product_status);
            
            if(count($order_ids)>0){
                $query->query_vars['post__in'] = $order_ids;
            }
            else{
               $query->query_vars['post__in'] = array(555555555555555555); 
            }
            
        }
         
        // }
        return $query;
    } else {
        return $query;
    }
}

//add_filter('pre_get_posts', 'includeOldOrderIdInSearchAdminSide');
//add_filter('pre_get_posts', 'batchPrinrting');
global $pagenow;
$postType = isset($_GET['post_type']) ? $_GET['post_type'] : '';
if ($postType == 'shop_order') {
if ($pagenow != 'post-new.php' ){
add_action('admin_head', 'injectScriptAdvanceSearch');
add_action('admin_head', 'injectScriptBatchprinring');
}
}
function injectScriptBatchprinring() {
$simpleSearchcls = '';
        $simpleSearchstyle = 'none';
        $advanceSearchcls = 'active';
        $advanceSearchstyle = 'block';
        $batchStyle='none';
        $batchcls = '';
         $packaging_filters = '<input type="hidden" name="print_label_shipment" class="print_label_shipment" value="yes"><input type="hidden" name="package_label_shipment" class="package_label_shipment" value="yes"><input type="hidden" name="tracking_email_shipment" class="tracking_email_shipment" value="yes">';
        if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
            $simpleSearchcls = 'active';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'block';
            $advanceSearchstyle = 'none';
            $batchStyle='none';
            $batchcls = '';
        }
        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            $simpleSearchcls = '';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'none';
            $advanceSearchstyle = 'none';
            $batchStyle='block';
            $batchcls = 'active';
        }
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : array();
        $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : array();
        $new_array= array('boxes', 'bubble-mailer', 'envelope','raw');
       
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'product',
            
            'tax_query' => array(
                'relation' =>'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' =>$new_array,
                )
            )
        );

        $posts_array = get_posts(
            $args
        );
        $options = '';
        if ( count( $posts_array )>0 ) {
            $options .='<option value="">Select</option>';
            foreach ( $posts_array as $PR ) {
                $selectd=''; 
                $options .='<option value="'.$PR->ID.'"> '.$PR->post_title.'</option>';
            }
        }
        $select_field = '<select name="product_id[]" id="product-id" class="select22">'.$options.'</select>';
        $row_html ='<div class="searh-row">
                 <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product:</label>
                 '.$select_field.'
                  </div>
                  <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product Quantity:</label>
                  <input type="number" id="product-qty" placeholder="Product Quantity" min="1" value="" name="product_qty[]" required>
                  </div>
                  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
                </div>
                ';
        $row_html2 = '';
       if(count($product_id)>0){
           $counter= 0;
           foreach($product_id as $prid){
               $options = '';
        if ( count( $posts_array )>0 ) {
            foreach ( $posts_array as $PR ) {
                $selectd=''; 
                if($PR->ID==$prid){
                    $selectd = 'selected';
                }
                $options .='<option value="'.$PR->ID.'" '.$selectd.'> '.$PR->post_title.'</option>';
            }
        }
        $select_field = '<select name="product_id[]" id="product-id" class="select22">'.$options.'</select>';
               $row_html2 .='<div class="searh-row">
                 <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product:</label>
                 '.$select_field.'
                  </div>
                  <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product Quantity:</label>
                  <input type="number" id="product-qty" min="1" placeholder="Product Quantity" value="' . $product_qty[$counter] . '" name="product_qty[]" required>
                  </div>
                  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
                </div>
                ';
               $counter++;
           }
       }
       else{
            $row_html2 = $row_html;
       }
        $htmll = '<div id="batch-printing" class="tabcontent" style="display:'.$batchStyle.'"><div class="customBatchPrinting">
                <div id="modal-window-printing">
                <div id="cloned-batch" style="display:none">
                 '.$row_html.'
                </div>
                <form class="form-inline form-mbt-class-added" method="get" action="' . get_admin_url() . '/edit.php">
                <input type="hidden" name="post_type" value="shop_order">
                <input type="hidden" name="batch_printing" value="yes">
                <div id="original" class="mbt-added-custom-class">
               '.$row_html2.'
                 </div>  
                 <div class="cmt-thed packaging-actions">
<label for="print_label_shipment">
<input name="print_label_shipment" id="print_label_shipment" type="checkbox" checked="" class="" value="yes">
<span class="print_label_shipment">Print Label</span>
</label>
<label for="package_label_shipment">
<input name="package_label_shipment" id="package_label_shipment" type="checkbox" checked="" class="" value="yes">
<span class="package_label_shipment">Package Label</span>
</label>

<label for="tracking_email_shipment">
<input name="tracking_email" id="tracking_email_shipment" type="checkbox" checked="" class="" value="yes">
<span class="tracking_email_shipment">Tracking Email</span>
</label>
<br>
</div>
                <div class="searh-row" style="display: contents">
<div  class="search-filed-grp" style="width:100%;">
<label for="" style="opacity:0">End Date:</label>
<a href="javascript:void(0);" class="add-more-btach btn button" >Add More</a>

<button type="submit" id="batch-print-btn">Submit</button>
<a href="' . get_admin_url() . '/edit.php?post_type=shop_order&&batch_printing=yes" class="button" >Clear</a>
</div>
</div>

                </form>
        </div> </div>';
        $htmll = trim(preg_replace('/\s+/', ' ', $htmll));
        ?>
        <script>
            jQuery(document).ready(function () {
                 jQuery('#posts-filter').append('<?php echo $packaging_filters;?>');
                jQuery('.wp-heading-inline').before('<?php echo $htmll; ?>');
                jQuery('.subsubsub').append('<a href="javascript:void(0);" class="batchprinting">Batch Printing</a>');
                jQuery(document).on('click', '.batchprinting', function () {
                    jQuery('.customBatchPrinting').slideToggle();
                });
            });
            jQuery(document).on('click','.add-more-btach',function(){
               jQuery('#original').append(jQuery('#cloned-batch').html()); 
               jQuery(document).find(".select22").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });
            });
            jQuery(document).on('click','.par-rem',function(){
               jQuery(this).parents('.searh-row').remove();
            });
            
        </script>
        <?php
    }

    function injectScriptAdvanceSearch() {
        $simpleSearchcls = '';
        $simpleSearchstyle = 'none';
        $advanceSearchcls = 'active';
        $advanceSearchstyle = 'block';
        $batchStyle='none';
        $batchcls = '';
        if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
            $simpleSearchcls = 'active';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'block';
            $advanceSearchstyle = 'none';
            $batchStyle='none';
            $batchcls = '';
        }
        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            $simpleSearchcls = '';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'none';
            $advanceSearchstyle = 'none';
            $batchStyle='block';
            $batchcls = 'active';
        }
        $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
        $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
        $customer_email_address = isset($_GET['customer_email_address']) ? $_GET['customer_email_address'] : '';
        $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';
        $tray_number = isset($_GET['tray_number']) ? $_GET['tray_number'] : '';
        $sbr_number = isset($_GET['sbr_number']) ? $_GET['sbr_number'] : '';
        $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
        $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
        $order_status = isset($_GET['post_status']) ? $_GET['post_status']:'';
        $product_status = isset($_GET['product_status']) ? $_GET['product_status']:'';
        $wc_processing = '';
        $wc_on_hold = '';
        $wc_completed = '';
        $wc_cancelled = '';
        $wc_refunded = '';
        $wc_failed = '';
        $wc_partial_ship = '';
        $impression_wating = '';
        $pending_on_lab = '';
        $wc_shipped = '';
         if ($product_status == 'waiting-impression') {
            $impression_wating = 'selected';
        }
        if ($product_status == 'pending-lab') {
            $pending_on_lab = 'selected';
        }
        if ($order_status == 'wc-processing') {
            $wc_processing = 'selected';
        }
        if ($order_status == 'wc-on-hold') {
            $wc_on_hold = 'selected';
        }
        if ($order_status == 'wc-completed') {
            $wc_completed = 'selected';
        }
        if ($order_status == 'wc-cancelled') {
            $wc_cancelled = 'selected';
        }
        if ($order_status == 'wc-refunded') {
            $wc_refunded = 'selected';
        }
        if ($order_status == 'wc-failed') {
            $wc_failed = 'selected';
        }
         if ($order_status == 'wc-partial_ship') {
            $wc_partial_ship = 'selected';
        }
         if ($order_status == 'wc-shipped') {
            $wc_shipped = 'selected';
        }
       
        $htmll = '<div id="advance-search" class="tabcontent" style="display: ' . $advanceSearchstyle . ';"> <div class="customSEarcingFilters">
<div id="modal-window-search">
<form class="form-inline" method="get" action="' . get_admin_url() . '/edit.php">
<input type="hidden" name="post_status" value="all">
<input type="hidden" name="action" value="-1">
<input type="hidden" name="action2" value="-1">


<input type="hidden" name="post_type" value="shop_order">
<input type="hidden" name="advance_search" value="advance_search">
<input type="hidden" name="paged" value="1">
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block;">
  <label for="search-fname">First Name:</label>
  <input type="text" id="search-fname" placeholder="First Name" value="' . $customer_first_name . '" name="customer_first_name">
  </div>
  <div  class="search-filed-grp">
  <label for="search-laname">Last Name:</label>
  <input type="text" id="search-laname" placeholder="Last Name" value="' . $customer_last_name . '" name="customer_last_name">
  </div>
</div>
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-email">Email:</label>
  <input type="email" id="search-email" value="' . $customer_email_address . '" placeholder="email" name="customer_email_address">
  </div>
  <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-tray-number">Tray Number:</label>
  <input type="text" id="search-tray-number" value="' . $tray_number . '" placeholder="Tray Number" name="tray_number">
  </div>
</div>
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-sbr-number">SBR Number:</label>
  <input type="text" value="' . $sbr_number . '" id="search-sbr-number" placeholder="SBR Number" name="sbr_number">
  </div>
  <div  class="search-filed-grp">
  <label for="search-order-number">Order Number:</label>
  <input type="text" id="search-order-number" value="' . $order_number . '" placeholder="Order Number" name="order_number">
  </div>
</div>
<div class="searh-row">
<div  class="search-filed-grp">
  <label for="">Start Date:</label>
  <input type="date" id="search-start-date" value="' . $order_start_date . '" placeholder="Start Date" name="order_start_date">
  </div>
  <div  class="search-filed-grp">
  <label for="">End Date:</label>
  <input type="date" id="search-end-date" value="' . $order_end_date . '" placeholder="End Date" name="order_end_date">
  </div>
</div>
<div class="search-filed-grp"> <label for="">Order Status:</label> <select class="subsubsub" name="post_status">
	<option value="">All</option>
<option value="wc-processing" ' . $wc_processing . '>Processing</option>
<option value="wc-on-hold" ' . $wc_on_hold . '>On Hold</option>
<option value="wc-completed" ' . $wc_completed . '>Completed</option>
<option value="wc-cancelled" ' . $wc_cancelled . '>Cancelled</option>
<option value="wc-refunded" ' . $wc_refunded . '>Refunded</option>
<option value="wc-failed" ' . $wc_failed . '>Failed</option>
<option value="wc-partial_ship" ' . $wc_partial_ship . '>Partial Shipped</option>
<option value="wc-shipped" ' . $wc_shipped . '>Shipped</option>
</select> </div>

<div class="searh-row ddddadfafasfs">
<div  class="search-filed-grp" style="width:100%;">
<label for="" style="opacity:0">End Date:</label>
<button type="submit">Submit</button>
<a href="' . get_admin_url() . '/edit.php?post_type=shop_order" class="button" id="clrbtn">Clear</a>
</div>
</div>
</form>
</div> </div>';
        $thmlSimpleSearch = '<div id="simple-Search" class="tabcontent" style="display:' . $simpleSearchstyle . '"><form action="" method="GET"><p class="search-box">
	<label class="screen-reader-text" for="post-search-input">Search orders:</label>
        <input type="hidden" name="post_type" value="shop_order">
        <input type="hidden" name="simple_search" value="true">
	<input type="search" id="post-search-input" name="s" value="">
		<input type="submit" id="search-submit" class="button" value="Search orders"></p></form></div>';
        $htmll = trim(preg_replace('/\s+/', ' ', $htmll));
        $thmlSimpleSearch = trim(preg_replace('/\s+/', ' ', $thmlSimpleSearch));
        ?>
        <script>
            jQuery(document).ready(function () {
               
                jQuery('.wp-heading-inline').before('<div class="tab custom-tabs"><ul><li class="tablinks <?php echo $advanceSearchcls; ?>" onclick="openCity(event,\'advance-search\')">Advance Search</li><li class="tablinks <?php echo $simpleSearchcls; ?>" onclick="openCity(event,\'simple-Search\')\">Simple Search</li><li class="tablinks <?php echo $batchcls; ?>" onclick="openCity(event, \'batch-printing\')">Batch Print</li></ul></div>');
                jQuery('.wp-heading-inline').before('<?php echo $htmll; ?>');
                jQuery('.wp-heading-inline').before('<?php echo $thmlSimpleSearch; ?>');

                jQuery('.subsubsub').append('<a href="javascript:void(0);" class="advenssearch">Advance Search</a>');
                jQuery(document).on('click', '.advenssearch', function () {
                    jQuery('.customSEarcingFilters').slideToggle();
                });
            });
            jQuery(document).ready(function(){jQuery(".column-shipping_address").each(function(){
      
html = jQuery(this).find(".description").text();

if (html.indexOf("USPS") >= 0){
    img='<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/usps-icon.jpg" style="width:60px;">';
    jQuery(this).append(img);
}
});
});
jQuery(document).on('click','.wc-action-button-create-note',function(){
order_id = jQuery(this).parents('tr').find('.order-preview').attr('data-order-id');

Swal.fire({
  title: 'Add Note',
  html: ` <div id="appendres" style="color:red"></div><textarea id="order_note" placeholder="Note..." name="order_note" rows="4" cols="50" class="swal2-input"></textarea>
 <input type="hidden" id="order_id" value="`+order_id+`" class="swal2-input" placeholder="Last Name">`,
  showLoaderOnConfirm: true,
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Add Note',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
    const order_note = Swal.getPopup().querySelector('#order_note').value
    const order_id = Swal.getPopup().querySelector('#order_id').value
    data_f = 'order_id='+order_id+'&order_note='+order_note+'&action=create_woo_order_note';
    if (!order_note) {
      Swal.showValidationMessage(`Please Fill the Note`)
    }
    return fetch('https://dev.smilebrilliant.com/wp-admin/admin-ajax.php?'+data_f)
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
      if(res.status=="0"){
                 jQuery('#appendres').html(res.error);
                   Swal.fire({
      title: `Error`,
      text: res.error
    })
        }
        if(res.status=="1"){
                 Swal.fire({
      title: `Success`,
      text: "Note added successfully"
    })
   
        }
        }
//    Swal.fire({
//      title: `${result.value.login}'s avatar`,
//      imageUrl: result.value.avatar_url
//    })
  
});
});

        </script>
        <script>
            function openCity(evt, cityName) {
//                var i, tabcontent, tablinks;
//                tabcontent = document.getElementsByClassName("tabcontent");
//                for (i = 0; i < tabcontent.length; i++) {
//                    tabcontent[i].style.display = "none";
//                }
//                tablinks = document.getElementsByClassName("tablinks");
//                for (i = 0; i < tablinks.length; i++) {
//                    tablinks[i].className = tablinks[i].className.replace(" active", "");
//                }
//                document.getElementById(cityName).style.display = "block";
//                evt.currentTarget.className += " active";
                urll = jQuery('body').find('#clrbtn').attr('href');
                if(cityName=='batch-printing'){
                    urll = urll+'&batch_printing=yes';
                     window.location.assign(urll)
                   
                }
                
                if(cityName=='advance-search'){
                     window.location.assign(urll)
                }
                if(cityName=='simple-Search'){
                    urll = urll+'&simple_search=true';
                     window.location.assign(urll)
                }
            }
        </script>
        <style>
            #modal-window-search .form-inline,.customBatchPrinting .form-inline {  
                display: flex;
                flex-flow: row wrap;
                align-items: center;
            }

            #modal-window-search .form-inline label ,.customBatchPrinting .form-inline label {
                margin: 5px 10px 5px 0;
            }

            #modal-window-search .form-inline input,.customBatchPrinting .form-inline input {
                vertical-align: middle;
                margin: 5px 10px 5px 0;
                padding: 10px;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            a.advenssearch {
                /* position: ABSOLUTE; */
                top: 7px;
                left: 200px;
                border: 1px solid #0071a1;
                border-radius: 2px;
                text-shadow: none;
                font-weight: 600;
                font-size: 13px;
                background-color: #f3f5f6;
                padding: 3px 7px;
            }
            #modal-window-search .form-inline button ,.customBatchPrinting .form-inline button {
                padding: 10px 20px;
                background-color: dodgerblue;
                border: 1px solid #ddd;
                color: white;
                cursor: pointer;
            }
            .wrap {
                position: relative;
            }
            #modal-window-search .form-inline button:hover ,.customBatchPrinting .form-inline button:hover {
                background-color: royalblue;
            }
            .searh-row{
                display:flex;
            }
            .searh-row .search-filed-grp:nth-child(even) {
                margin-left:10px;
            }
            #posts-filter .search-box{
                display: none !important;
            }
            .search-filed-grp {
                width:50%;



            }
            .search-field input, .search-field select{
                width:100%;
            }
            #modal-window-search .form-inline .button,.customBatchPrinting  .form-inline .button {
                padding: 10px 20px;
                background-color: dodgerblue;
                border: 1px solid #ddd;
                color: white;
                cursor: pointer;
                line-height: inherit !important;
            }
            .search-filed-grp label{
                display:block;
            }
            .search-filed-grp {
                width: 100%;
            }

            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }

            /* Style the buttons that are used to open the tab content */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #ddd;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #ccc;
            }
            ul.subsubsub{
                display:none;
            }
            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }
            #original .searh-row .search-filed-grp .select2-container:nth-child(4) {
    display: none;
}#original .searh-row .search-filed-grp:nth-child(2) {
    margin-left: 15px !important;
}div#original .select2-container {
    margin-top: 5px;
}div#original {
    width: 100%;
    max-width: 488px;
}
            @media (max-width: 800px) {
                #modal-window-search .form-inline input {
                    margin: 10px 0;
                }

                #modal-window-search .form-inline,.customBatchPrinting .form-inline {
                    flex-direction: column;
                    align-items: stretch;
                }
            }
        </style>
        <?php
        echo '</div>';
    }
?>