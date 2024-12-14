<?php

function sb_orders_custom_page()
{
    $hook = add_menu_page('Orders', 'Orders', 'manage_options', 'sb_orders_page', 'sb_orders_page');
    add_action("load-$hook", 'sbr_screen_option');
}

add_action('admin_menu', 'sb_orders_custom_page');

function sbr_set_screen($status, $option, $value)
{
    return $value;
}

function sbr_screen_option()
{
    $option = 'per_page';
    $args = [
        'label' => 'Orders',
        'default' => 10,
        'option' => 'orders_per_page'
    ];

    add_screen_option($option, $args);
}

function get_orders_product_status($status)
{
    global $wpdb;
    $order_ids = array();
    if ($status == 'waiting-impression') {
        // $order_ids = $wpdb->get_col("SELECT DISTINCT  order_id FROM  " . SB_ORDER_TABLE . " WHERE status = 3");
        $order_ids = $wpdb->get_col("SELECT DISTINCT  order_id FROM  " . SB_ORDER_TABLE . " WHERE status IN (3, 5 , 7)");
    } else if ($status == 'pending-lab') {
        $order_ids = $wpdb->get_col("SELECT DISTINCT  order_id FROM  " . SB_ORDER_TABLE . " WHERE status IN (6, 16)");
    }

    return $order_ids;
}

function sb_orders_page()
{
   
    if (!class_exists('Orders_List_Table')) {
        require_once(get_stylesheet_directory() . '/inc/orders-list-table.php');
    }
    wp_enqueue_script('jquery-blockui');
    $orders_obj = new Orders_List_Table();

    add_filter('set-screen-option', 'sbr_set_screen', 10, 3);

    $simpleSearchcls = '';
    $simpleSearchstyle = 'none';
    $advanceSearchcls = 'active';
    $advanceSearchstyle = 'block';
    $batchStyle = 'none';
    $batchcls = '';

    if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
        $simpleSearchcls = 'active';
        $advanceSearchcls = '';
        $simpleSearchstyle = 'block';
        $advanceSearchstyle = 'none';
        $batchStyle = 'none';
        $batchcls = '';
    }
    if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
        $simpleSearchcls = '';
        $advanceSearchcls = '';
        $simpleSearchstyle = 'none';
        $advanceSearchstyle = 'none';
        $batchStyle = 'block';
        $batchcls = 'active';

        $packaging_filters = '<input type="hidden" name="shipment" id="shipmentType"  value="' . $_REQUEST['shipment'] . '"><input type="hidden" name="page" value="sb_orders_page"><input type="hidden" name="batch_printing" value="yes"><input type="hidden" name="print_label_shipment" class="print_label_shipment" value="yes"><input type="hidden" name="package_label_shipment" class="package_label_shipment" value="yes"><input type="hidden" name="tracking_email_shipment" class="tracking_email_shipment" value="yes">';

        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : array();
        //print_r($product_id);
       
        if(is_array($product_id)){
            //
                        }
                        else{
                            if($product_id =='undefined') {
                                $product_id = array();
                            }
                            else{
                                $product_id = explode(',',$product_id);
                            }
                        }
        $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : array();
        if(is_array($product_qty)){
        //
        }
        else{
        if($product_qty =='undefined') {
            $product_qty = array();
        }
        else{
            $product_qty = explode(',',$product_qty);
        }
    }
        $new_array = array('boxes', 'bubble-mailer', 'envelope', 'raw');

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'product',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' => $new_array,
                )
            )
        );

        $posts_array = get_posts(
            $args
        );
        $options = '';
        if (count($posts_array) > 0) {
            $options .= '<option value="">Select</option>';
            foreach ($posts_array as $PR) {
                $selectd = '';
                $options .= '<option value="' . $PR->ID . '"> ' . $PR->post_title . '</option>';
            }
        }
        $select_field = '<select name="product_id[]" id="product-id" class="select22">' . $options . '</select>';
        $row_html = '<div class="searh-row">
				 <div  class="search-filed-grp" style="display:inline-block;">
				  <label for="search-fname">Product:</label>
				 ' . $select_field . '
				  </div>
				  <div  class="search-filed-grp" style="display:inline-block;">
				  <label for="search-fname">Product Quantity:</label>
				  <input type="number" id="product-qty" placeholder="Product Quantity" min="1" value="" name="product_qty[]" required>
				  </div>
				  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
				</div>
				';
        $row_html2 = '';
        if (count($product_id) > 0) {
            $counter = 0;
            foreach ($product_id as $prid) {
                $options = '';
                if (count($posts_array) > 0) {
                    foreach ($posts_array as $PR) {
                        $selectd = '';
                        if ($PR->ID == $prid) {
                            $selectd = 'selected';
                        }
                        $options .= '<option value="' . $PR->ID . '" ' . $selectd . '> ' . $PR->post_title . '</option>';
                    }
                }
                $select_field = '<select name="product_id[]" id="product-id" class="select22">' . $options . '</select>';
                $row_html2 .= '<div class="searh-row tab-bathc-print-section-mbt">
				 <div  class="search-filed-grp tab-start-one" style="display:inline-block;">
				  <label for="search-fname">Product:</label>
				 ' . $select_field . '
				  </div>
				  <div  class="search-filed-grp tab-start-two" style="display:inline-block;">
				  <label for="search-fname">Product Quantity:</label>
				  <input type="number" id="product-qty" min="1" placeholder="Product Quantity" value="' . $product_qty[$counter] . '" name="product_qty[]" required>
				  </div>
				  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
				</div>
				';
                $counter++;
            }
        } else {
            $row_html2 = $row_html;
        }
?>
        <script>
            jQuery(document).ready(function() {
                //jQuery('.subsubsub').append('<a href="javascript:void(0);" class="batchprinting">Batch Printing</a>');
                jQuery(document).on('click', '.batchprinting', function() {
                    jQuery('.customBatchPrinting').slideToggle();
                });
            });
            jQuery(document).on('click', '.add-more-btach', function() {
                jQuery('#original').append(jQuery('#cloned-batch').html());
                jQuery(document).find(".select22").select2({
                    placeholder: "Please select product.",
                    allowClear: true,
                    width: '100%'
                });
            });
            jQuery(document).on('click', '.par-rem', function() {
                if (jQuery(this).parent().parent().children('.searh-row').length > 1)
                    jQuery(this).parents('.searh-row').remove();
            });
            jQuery(document).on("change", "#print_label_shipment", function() {
                if (this.checked) {
                    jQuery('.print_label_shipment').val('yes');
                } else {
                    jQuery('.print_label_shipment').val('');
                }
            });
            jQuery(document).on("change", ".bp-search-join-type input[name='shipment']", function() {
                let shipment2 = jQuery('input[name="shipment"]:checked').val();
                jQuery('#shipmentType').val(shipment2);
                jQuery('#batch-print-btn').click();

            });

            jQuery(document).on("change", "#package_label_shipment", function() {
                if (this.checked) {
                    jQuery('.package_label_shipment').val('yes');
                } else {
                    jQuery('.package_label_shipment').val('');
                }
            });
            jQuery(document).on("change", "#tracking_email_shipment", function() {
                if (this.checked) {
                    jQuery('.tracking_email_shipment').val('yes');
                } else {
                    jQuery('.tracking_email_shipment').val('');
                }
            });
        </script>

    <?php
    }
    $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
    $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
    $customer_email_address = isset($_GET['customer_email_address']) ? str_replace('|', PHP_EOL, $_GET['customer_email_address']) : '';
    $order_number = isset($_GET['order_number']) ? str_replace('|', PHP_EOL, $_GET['order_number']) : '';
    $tray_number = isset($_GET['tray_number']) ? str_replace('|', PHP_EOL, $_GET['tray_number']) : '';
    //$tray_number = html_entity_decode($tray_number);
    $sbr_number = isset($_GET['sbr_number']) ?  str_replace('|', PHP_EOL, $_GET['sbr_number']) : '';
    $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
    $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
    $order_status = isset($_GET['post_status']) ? $_GET['post_status'] : '';
    $product_status = isset($_GET['product_status']) ? $_GET['product_status'] : '';
    $product_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
    $shipping_flag = isset($_GET['shipping_flag']) ? $_GET['shipping_flag'] : '';
    //subscription#RB[search-subscription_orders]
    $subscription_orders = isset($_GET['subscription_orders']) ? $_GET['subscription_orders'] : '';   
    $exploded_shipping = explode(',', $shipping_flag);
    $exclude_legacy = isset($_GET['exclude_legacy']) ? $_GET['exclude_legacy'] : '';
    $exclude_addons = isset($_GET['exclude_addons']) ? $_GET['exclude_addons'] : '';
    $exclude_night_guard_reorder = isset($_GET['exclude_night_guard_reorder']) ? $_GET['exclude_night_guard_reorder'] : '';
    $exclude_extra_whitening_tray_set = isset($_GET['exclude_extra_whitening_tray_set']) ? $_GET['exclude_extra_whitening_tray_set'] : '';
    $wc_processing = '';
    $wc_on_hold = '';
    $wc_completed = '';
    $wc_cancelled = '';
    $wc_refunded = '';
    $wc_partial_refunded = '';
    $wc_failed = '';
    $wc_partial_ship = '';
    $impression_wating = '';
    $pending_on_lab = '';
    $backordered = '';
    $wc_shipped = '';
    $wc_pending = '';
    $wfocu_pri_order = '';
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
    if ($order_status == 'wc-partial-refunded') {
        $wc_partial_refunded = 'selected';
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
    if ($order_status == 'wc-pending') {
        $wc_pending = 'selected';
    }
    if ($order_status == 'wfocu-pri-order') {
        $wfocu_pri_order = 'selected';
    }
    if ($order_status == 'backordered') {
        $backordered = 'selected';
    }

    ?>
    <div class="wrap">
        <?php
        if (isset($_GET['product_status']) && $_GET['product_status'] == 'waiting-impression') {
        ?>
            <script>
                jQuery('body').addClass('waiting-impression');
            </script>
        <?php
        }
        ?>
        <style>
            .loading-sbr {
                display: block;
            }
        </style>
        <div class="loading-sbr">
            <div class="inner-sbr"></div>
        </div>
        <h2>Orders</h2>
        <div class="tab custom-tabs">
            <ul>
                <li class="tablinks <?php echo $advanceSearchcls; ?>" onclick="openCity(event, 'advance-search')">Advance Search</li>
                <li class="tablinks <?php echo $simpleSearchcls; ?>" onclick="openCity(event, 'simple-Search')">Simple Search</li>
                <li class="tablinks <?php echo $batchcls; ?>" onclick="openCity(event, 'batch-printing')">Batch Print</li>
            </ul>
        </div>

        <div id="advance-search" class="tabcontent" style="display: <?php echo $advanceSearchstyle ?>;">
            <div class="customSEarcingFilters">
                <div id="modal-window-search">
                    <form class="form-inline" method="get" action="<?php echo get_admin_url(); ?>admin.php">
                        <?php /* ?><input type="hidden" name="post_status" value="all">
                          <input type="hidden" name="action" value="-1">
                          <input type="hidden" name="action2" value="-1">
                          <input type="hidden" name="post_type" value="shop_order"><?php */ ?>
                        <input type="hidden" name="page" value="sb_orders_page">
                        <input type="hidden" name="advance_search" value="advance_search">
                        <input type="hidden" name="product_status" id="product_status" value="<?php echo isset($_GET['product_status']) ? $_GET['product_status'] : ''; ?>">
                        <?php /* ?><input type="hidden" name="paged" value="1"><?php */ ?>
                        <div class="searh-row">
                            <div class="search-filed-grp" style="display:inline-block;">
                                <label for="search-fname">First Name:</label>
                                <input type="text" id="search-fname" placeholder="First Name" value="<?php echo $customer_first_name; ?>" name="customer_first_name">
                            </div>
                            <div class="search-filed-grp">
                                <label for="search-laname">Last Name:</label>
                                <input type="text" id="search-laname" placeholder="Last Name" value="<?php echo $customer_last_name; ?>" name="customer_last_name">
                            </div>
                        </div>
                        <div class="searh-row">
                            <div class="search-filed-grp" style="display:inline-block; width:50%">
                                <label for="search-email">Email:</label>
                                <!--                                <input type="email" id="search-email" value="<?php echo $customer_email_address; ?>" placeholder="email" name="customer_email_address">-->
                                <textarea id="search-email" placeholder="email" name="customer_email_address" style="margin:5px 10px 5px"><?php echo $customer_email_address; ?></textarea>
                            </div>
                            <div class="search-filed-grp" style="display:<?php echo $product_status == '' ? 'inline-block' : 'inline-block'; ?>; width:50%">
                                <label for="search-tray-number">Tray Number:</label>
                                <!--                                <input type="text" id="search-tray-number" value="<?php // echo $tray_number;  
                                                                                                                        ?>" placeholder="Tray Number" name="tray_number">-->
                                <textarea id="search-tray-number" style="margin:5px 10px 5px" placeholder="Tray Number" name="tray_number"><?php echo $tray_number; ?></textarea>

                            </div>
                        </div>
                        <div class="searh-row">
                            <div class="search-filed-grp" style="display:inline-block; width:50%">
                                <label for="search-sbr-number">SBR Number:</label>
                                <!--                                <input type="text" value="<?php //echo $sbr_number;  
                                                                                                ?>" id="search-sbr-number" placeholder="SBR Number" name="sbr_number">-->
                                <textarea id="search-sbr-number" placeholder="SBR Number" name="sbr_number" style="margin:5px 10px 5px"><?php echo $sbr_number; ?></textarea>
                            </div>
                            <div class="search-filed-grp">
                                <label for="search-order-number">Order Number:</label>
                                <!--                                <input type="text" id="search-order-number" value="<?php //echo $order_number  
                                                                                                                        ?>" placeholder="Order Number" name="order_number">-->
                                <textarea id="search-order-number" placeholder="Order Number" name="order_number" style="margin:5px 10px 5px"><?php echo $order_number; ?></textarea>
                            </div>
                        </div>
                        <div class="searh-row">
                            <div class="search-filed-grp">
                                <label for="">Start Date:</label>
                                <input type="date" id="search-start-date" value="<?php echo $order_start_date; ?>" placeholder="Start Date" name="order_start_date">
                            </div>
                            <div class="search-filed-grp">
                                <label for="">End Date:</label>
                                <input type="date" id="search-end-date" value="<?php echo $order_end_date; ?>" placeholder="End Date" name="order_end_date">
                            </div>
                        </div>
                        <div class="searh-row checkbox-default-status">
                            <label for="" class="shipping-heading-first">Shipping:</label><br />
                            <input type="checkbox" id="shipping_flag_domestic" name="shipping_flag" value="domestic" <?php if ($shipping_flag == 'domestic' || count($exploded_shipping) > 1) echo 'checked'; ?>>
                            <label for="shipping_flag_domestic">US orders </label><br />
                            <input type="checkbox" id="shipping_flag_international" name="shipping_flag" value="international" <?php if ($shipping_flag == 'international' || count($exploded_shipping) > 1) echo 'checked'; ?>><label for="shipping_flag_international">International orders </label>
                            <input type="checkbox" id="subscription_orders" name="subscription_orders" value="1" <?php echo ($subscription_orders != '' )?'checked':''; ?>><label for="subscription_orders">Subscription Orders </label>

                            <input type="checkbox" id="upsell_orders" name="upsell_orders" value="yes"><label for="upsell_orders">Post purchases</label>


                        </div>
                        <?php if ($product_status == '') { ?>
                            <div class="search-filed-grp order-status-mbt">
                                <label for="">Order Status:</label>
                                <input type="hidden" name="product_cat" id="product_cat" value="">
                                <select class="subsubsub" name="post_status" id="post_status">
                                    <option value="">All</option>
                                    <option value="wc-processing" <?php echo $wc_processing; ?>>Processing</option>
                                    <option value="wc-pending" <?php echo $wc_pending; ?>>Pending payment</option>
                                    <option value="wc-wfocu-pri-order" <?php echo $wfocu_pri_order; ?>> Reorder in Production</option>
                                    <option value="backordered" <?php echo $backordered; ?>>Backordered item</option>
                                    <option value="wc-on-hold" <?php echo $wc_on_hold; ?>>On Hold</option>
                                    <option value="wc-completed" <?php echo $wc_completed; ?>>Completed</option>
                                    <option value="wc-cancelled" <?php echo $wc_cancelled; ?>>Cancelled</option>
                                    <option value="wc-refunded" <?php echo $wc_refunded; ?>>Refunded</option>
                                    <option value="wc-partial-refunded" <?php echo $wc_partial_refunded; ?>>Partial Refunded</option>
                                    <option value="wc-failed" <?php echo $wc_failed; ?>>Failed</option>
                                    <option value="wc-partial_ship" <?php echo $wc_partial_ship; ?>>Partial Shipped</option>
                                    <option value="wc-shipped" <?php echo $wc_shipped; ?>>Shipped</option>
                                </select>
                            </div>
                        <?php } else {
                        ?>
                            <div class="search-filed-grp mb-15">
                                <label for="" class="mb-10">Category:</label>
                                <select name="product_cat" id="product_cat">
                                    <option value="">None</option>
                                    <option value="night-guards" <?php echo $product_cat == 'night-guards' ? 'selected' : ''; ?>>Night Guards</option>
                                    <option value="teeth-whitening-trays" <?php echo $product_cat == 'teeth-whitening-trays' ? 'selected' : ''; ?>>Teeth Whitening Trays</option>
                                </select>
                            </div>
                        <?php } ?>

                        <div class="searh-row">
                            <div class="search-filed-grp" style="width:100%;">
                                <?php /* ?><label for="" style="opacity:0">End Date:</label><?php */ ?>
                                <button id="advanced-search-submit" type="submit">Submit</button>
                                <a href="<?php echo get_admin_url(); ?>admin.php?page=sb_orders_page" class="button" id="clrbtn">Clear</a>
                                <?php if ($product_status == 'pending-lab') { ?>
                                    <a href="javascript:void(0);" class="button" id="bulk-kit-ready">Bulk Kit Ready</a>
                                    <a href="javascript:void(0);" class="button" id="batch_print_second">Batch print</a>
                                    <script>
                                        jQuery(document).on('click', '#bulk-kit-ready', function() {
                                            val = '';
                                            counter = 0;
                                            jQuery('input[name="bulk-orders[]"]:checked').each(function() {
                                                //jQuery('.loading-sbr').show();
                                                jQuery(this).parents('tr').find('.kit-readybtn').each(function() {
                                                    itemid = jQuery(this).attr('data-item_id');
                                                    console.log(itemid);
                                                    val += itemid + ',';


                                                });
                                                counter++;



                                            });
                                            if (counter == 0) {
                                                alert("please select orders");
                                                return false;
                                            }



                                            jQuery('.loading-sbr').show();
                                            jQuery.ajax({
                                                url: ajaxurl,
                                                //dataType: 'json',
                                                method: 'post',
                                                //async:false,
                                                data: 'action=bulk_kit_ready&val=' + val,
                                                success: function(response) {
                                                    console.log(response);
                                                    jQuery('.loading-sbr').hide();
                                                    location.reload();
                                                    //jQuery('#advanced-search-submit').trigger('click');
                                                }
                                            });
                                        });
                                        jQuery(document).on('click', '#batch_print_second', function() {
                                            orderarr = [];
                                            counter = 0;
                                            ss = jQuery('input[name="bulk-orders[]"]').serialize();
                                            //                                       jQuery('input[name="bulk-orders[]"]:checked').each(function(){
                                            //                                         orderarr.push(jQuery(this).val());
                                            //                                               counter++; 
                                            //                                         });
                                            if (ss == '') {
                                                alert("please select orders");
                                                return false;
                                            }


                                            location_new = '<?php echo get_admin_url(); ?>admin.php?shipment=second&page=sb_orders_page&batch_printing=yes&print_label_shipment=yes&package_label_shipment=yes&tracking_email_shipment=yes&action=bulk-batch-printing&' + ss + '&action2=-1';
                                            window.location.href = location_new;
                                        });
                                    </script>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="simple-Search" class="tabcontent" style="display: <?php echo $simpleSearchstyle; ?>;">
            <form action="" method="GET">
                <p class="search-box">
                    <label class="screen-reader-text" for="post-search-input">Search orders:</label>
                    <input type="hidden" name="page" value="sb_orders_page">
                    <input type="hidden" name="simple_search" value="true">
                    <input type="search" id="post-search-input" name="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>">
                    <input type="submit" id="search-submit" class="button" value="Search orders">
                </p>
            </form>
        </div>

        <div id="batch-printing" class="tabcontent" style="display:<?php echo $batchStyle; ?>">
            <div class="customBatchPrinting">
                <div id="modal-window-printing" class="new-style-mbt-fields">
                    <div id="cloned-batch" style="display:none">
                        <?php echo $row_html ?? ''; ?>
                    </div>
                    <form class="form-inline form-mbt-class-added" method="get" action="<?php echo get_admin_url(); ?>admin.php">
                        <input type="hidden" name="page" value="sb_orders_page">
                        <input type="hidden" name="batch_printing" value="yes">
                        <div id="original" class="mbt-added-custom-class">
                            <?php echo $row_html2 ?? ''; ?>
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
                        <div class="searh-row-mbt">
                            <div class="strip-br-top-mbt searh-row">

                                <input type="checkbox" id="shipping_flag_domestic_batch" name="shipping_flag_batch" value="domestic" <?php if ($shipping_flag == 'domestic' || count($exploded_shipping) > 1) echo 'checked'; ?>>
                                <label for="shipping_flag_domestic">US orders &nbsp;
                                    &nbsp;
                                </label>

                                <input type="checkbox" id="shipping_flag_international_batch" name="shipping_flag_batch" value="international" <?php if ($shipping_flag == 'international' || count($exploded_shipping) > 1) echo 'checked'; ?>>
                                <label for="shipping_flag_international">International orders </label>
                                <input style="margin-left: 20px;" type="checkbox" id="exclude_legacy" name="exclude_legacy" value="yes" <?php if ($exclude_legacy == 'yes' || !isset($_GET['exclude_legacy'])) echo 'checked'; ?>> <label for="exclude_legacy">Exclude Legacy </label><br />
                                <input style="margin-left: 20px;" type="checkbox" id="exclude_addons" name="exclude_addons" value="yes" <?php if ($exclude_addons == 'yes' || !isset($_GET['exclude_addons'])) echo 'checked'; ?>> <label for="exclude_addons">Exclude Addons </label><br />
                                <input style="margin-left: 20px;" type="checkbox" id="exclude_night_guard_reorder" name="exclude_night_guard_reorder" value="yes" <?php if ($exclude_night_guard_reorder == 'yes' || !isset($_GET['exclude_night_guard_reorder'])) echo 'checked'; ?>> <label for="exclude_night_guard_reorder">Exclude Night Guard Reorder </label><br />
                                <input style="margin-left: 20px;" type="checkbox" id="exclude_extra_whitening_tray_set" name="exclude_extra_whitening_tray_set" value="yes" <?php if ($exclude_extra_whitening_tray_set == 'yes' || !isset($_GET['exclude_extra_whitening_tray_set'])) echo 'checked'; ?>> <label for="exclude_extra_whitening_tray_set">Exclude Extra Whitening Tray Set </label><br />

                            </div>
                        </div>
                        <div class="searh-row" style="display: contents">
                            <div class="bp-search-join-type" style="width:100%; margin-top:20px; margin-bottom:10px;">
                                <label for="bp_join_type">Join Type: &nbsp;&nbsp;</label>
                                <?php
                                $join_type = isset($_REQUEST['join_type']) ? $_REQUEST['join_type'] : '';
                                ?>
                                <input type="radio" name="bp_join_type" id="bp_join_type_and" value="AND" <?php if ($join_type  == 'AND' || $join_type  == '') echo 'checked'; ?> /> AND <input type="radio" name="bp_join_type" id="bp_join_type_or" value="OR" <?php if ($join_type  == 'OR') echo ' checked'; ?> /> OR
                            </div>
                            <!--                            <div class="bp-search-join-type" style="width:100%; margin-top:20px; margin-bottom:10px;">
                                <label for="shipment_type">Shipment: &nbsp;&nbsp;</label>
                                <input type="radio" name="shipment" id="shipment_type_first" value="first" <?php //if ($_REQUEST['shipment'] == 'first' || $_REQUEST['shipment'] == '') echo 'checked'; 
                                                                                                            ?> /> First <input type="radio" name="shipment" id="shipment_type_second" value="second" <?php //if ($_REQUEST['shipment'] == 'second') echo ' checked'; 
                                                                                                                                                                                                        ?> /> Second
                            </div>-->
                            <div class="search-filed-grp" style="width:100%;">
                                <?php /* ?><label for="" style="opacity:0">End Date:</label><?php */ ?>
                                <a href="javascript:void(0);" class="add-more-btach btn button">Add More</a>
                                <a href="javascript:void(0);" class="button" id="genrate_batch_print_request">Genrate Batch Print Request</a>
                                <button type="submit" id="batch-print-btn">Submit</button>
                                <a href="<?php echo get_admin_url(); ?>admin.php?page=sb_orders_page&batch_printing=yes" class="button">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'bulk-batch-printing') || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'bulk-batch-printing')) {
            echo '<div id="sbr-batch-bulk-printing">';
            $order_ids = esc_sql($_REQUEST['bulk-orders']);
            if (isset($_REQUEST['shipment'])  && $_REQUEST['shipment'] == 'second') {
                $res = batch_printing_send_request_second($order_ids, false);
            } else {
                $res = batch_printing_send_request($order_ids, false);
            }

            echo $res;
            echo '</div>';
        }
        ?>
        <form id="sbr-orders-list" method="get">
            <?php
            echo $packaging_filters ?? '';
            //$orders_obj->prepare_items(); 
            ?>
            <div id="sbr-orders-table">
                <?php //$orders_obj->display();      
                ?>
            </div>
        </form>

        <br class="clear">
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //jQuery('.loading-sbr').hide();
        });

        function openCity(evt, cityName) {
            urll = jQuery('body').find('#clrbtn').attr('href');
            jQuery('.loading-sbr').show();
            if (cityName == 'batch-printing') {
                urll = urll + '&batch_printing=yes';
                window.location.assign(urll)
            }

            if (cityName == 'advance-search') {
                window.location.assign(urll)
            }
            if (cityName == 'simple-Search') {
                urll = urll + '&simple_search=true';
                window.location.assign(urll)
            }
        }

        jQuery(document).ready(function() {
            jQuery(document).on('click', 'input.editBuyerDetails', function() {
                window.open('<?php echo get_admin_url(); ?>user-edit.php?user_id=' + jQuery(this).attr('data-customer-id') + '&sbr_action', "_blank");
            });
            jQuery(document).on('click', 'input.buyerProfile', function() {
                window.open('<?php echo get_admin_url(); ?>admin.php?page=customer_history&customer_id=' + jQuery(this).attr('data-customer-id'), "_blank");
            });
            jQuery(document).on('click', 'input.refundCC', function() {
                window.open('<?php echo get_admin_url(); ?>post.php?post=' + jQuery(this).attr('data-order-id') + '&action=edit&sb_open_refund_box', "_blank");
            });

            // Function to get checkbox values
            function getCheckboxValues() {
                var printLabel = jQuery("#print_label_shipment").prop("checked");
                var packageLabel = jQuery("#package_label_shipment").prop("checked");
                var trackingEmail = jQuery("#tracking_email_shipment").prop("checked");

                return {
                    printLabel: printLabel,
                    packageLabel: packageLabel,
                    trackingEmail: trackingEmail
                };
            }
            jQuery(document).on('click', '#genrate_batch_print_request', function() {
                var batch_orders = jQuery('input[name="bulk-orders[]"]').serialize();
                // Create an array to store checked values
                var checkedItems = [];
                jQuery('input[name="bulk-orders[]"]:checked').each(function() {
                    checkedItems.push(jQuery(this).val());
                });
                if (batch_orders == '') {
                    swal.fire("Error!", "Please select orders for batch request", "error");
                    return false;
                } else {
                    // Function to show a loader
                    swal.fire({
                        title: "Are you sure?",
                        text: "Please confirm to proceed with the batch print request for shipment",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Create",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('.loading-sbr').show();

                            // Get checkbox values
                            var checkboxValues = getCheckboxValues();

                            // Perform AJAX request
                            jQuery.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'genrate_batch_print_request',
                                    checkedItems: checkedItems,
                                    print_label_shipment: checkboxValues.printLabel,
                                    package_label_shipment: checkboxValues.packageLabel,
                                    tracking_email_shipment: checkboxValues.trackingEmail
                                },
                                success: function(response) {
                                    Swal.close();
                                    jQuery('.loading-sbr').hide();
                                    if (response.success) {
                                        window.location.href = response.data.url;
                                        Swal.fire('Success', 'Batch print request successful!', 'success');
                                    } else {
                                        Swal.fire('Error', 'Batch print request failed!', 'error');
                                    }
                                },
                                error: function(error) {
                                    Swal.close();
                                    jQuery('.loading-sbr').hide();
                                    Swal.fire('Error', 'AJAX Error: ' + error.responseText, 'error');
                                }
                            });
                        }
                    });

                }
            });
            jQuery(document).on('click', 'input.btn_tray_number', function() {
                let order_id = jQuery(this).attr('data-order-id');
                let item_id = jQuery(this).attr('data-item-id');
                let tray_number = jQuery('#tray_number_' + item_id).val();
                if (tray_number == '') {
                    alert('Tray number is empty');
                    return;
                }
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'order_item_tray_number_update',
                        order_id: order_id,
                        item_id: item_id,
                        tray_number: tray_number
                    },
                    success: function(response) {
                        response = jQuery.parseJSON(response);
                        if (response.status == 'success')
                            alert(response.msg);
                        else
                            alert(response.msg);
                    }
                });
            });
            /*jQuery(document).on('click','input.btn_order_shipped',function(){
             let order_id = jQuery(this).attr('data-order-id');
             let obj = this;
                 
             jQuery.ajax({
             url: ajaxurl,
             data: {
             action: 'sbr_order_set_as_shipped',
             order_id: order_id
             },
             success: function (response) {
             response = jQuery.parseJSON(response);
                 
             if(response.status == 'success'){
             jQuery(obj).parent().empty();
             alert(response.msg);
             }
             else
             alert(response.msg);
             }
             });
             });*/

            /*
            jQuery(document).on('click', '.sbr-button-order-add-notes', function () {
                let order_id = jQuery(this).attr('data-order-id');
                let is_customer_note = jQuery(this).attr('data-is_customer_note');
                popup_title = 'Add Note';
                if (is_customer_note == 1)
                    popup_title = 'Add Personalized Followup';
                admin_notes = get_admin_notes_ajax(order_id);
                console.log(admin_notes);
                Swal.fire({
                    title: popup_title,
                    html: ' <div id="appendres" style="color:red"></div>' + admin_notes + '<textarea id="order_note" placeholder="Note..." name="order_note" rows="10" cols="50" class="swal2-input" style="height:100px;"></textarea><input type="hidden" id="order_id" value="' + order_id + '" class="swal2-input" placeholder="Last Name"><input type="hidden" id="is_customer_note" value="' + is_customer_note + '" class="swal2-input">',
                    showLoaderOnConfirm: true,
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add Note',
                    showLoaderOnConfirm: true,
                    customClass: {
                        popup: 'full-width-swal',
                    },
                    preConfirm: (login) => {
                        const order_note = Swal.getPopup().querySelector('#order_note').value
                        const order_id = Swal.getPopup().querySelector('#order_id').value
                        const is_customer_note = Swal.getPopup().querySelector('#is_customer_note').value
                        data_f = 'order_id=' + order_id + '&is_customer_note=' + is_customer_note + '&order_note=' + order_note + '&action=create_woo_order_note';
                        if (!order_note) {
                            Swal.showValidationMessage('Please Fill the Note')
                        }
                        return fetch('<?php //echo get_admin_url(); 
                                        ?>admin-ajax.php?' + data_f)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(response.statusText)
                                    }
                                    return response.json()
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                            'Request failed: ${error}'
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
                                title: 'Error',
                                text: res.error
                            })
                        }
                        if (res.status == "1") {
                            Swal.fire({
                                title: 'Success',
                                text: "Note added successfully"
                            })
                            reloadOrderEntry(order_id);
                        }
                    }
                });
            });
            */
            jQuery(document).on('click', '.orderInvoice', function() {
                alert('Click')
                let data = {
                    //action: "wc_pip_process_order_action",
                    //security: '<?php echo wp_create_nonce('process-order-action') ?>',
                    action: "wc_pip_confirm_order_action",
                    security: '<?php echo wp_create_nonce('confirm-order-action') ?>',
                    document: 'wc_pip_print_invoice',
                    //document_type: 'invoice',
                    //document_action: jQuery(this).data("action"),
                    order_ids: jQuery(this).data("order-id")
                }
                console.log(data);
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            var invoiceUrl = decodeURIComponent(response.data.url);
                            console.log(invoiceUrl)
                            window.open(invoiceUrl);
                        }

                        //alert('Order deleted');
                    }
                });
            });
            jQuery(document).on('click', '.sbr-button-order-delete', function() {
                let order_id = jQuery(this).attr('data-order-id');
                let obj = this;
                let sbr_confirm = confirm("Are you sure, you want to delete this order?");
                if (sbr_confirm) {
                    let data = {
                        action: 'sbr_order_set_as_trash',
                        order_id: order_id
                    }
                    jQuery.ajax({
                        url: ajaxurl,
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            jQuery(obj).parent().parent().parent().remove();
                            alert('Order deleted');
                        }
                    });
                }
            });
        });
    </script>
    <style type="text/css">
        #modal-window-search .form-inline,
        .customBatchPrinting .form-inline {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
        }

        #modal-window-search .form-inline label,
        .customBatchPrinting .form-inline label {
            margin: 5px 10px 5px 0;
        }

        #modal-window-search .form-inline input,
        .customBatchPrinting .form-inline input {
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

        #modal-window-search .form-inline button,
        .customBatchPrinting .form-inline button {
            padding: 10px 20px;
            background-color: dodgerblue;
            border: 1px solid #ddd;
            color: white;
            cursor: pointer;
        }

        .wrap {
            position: relative;
        }

        #modal-window-search .form-inline button:hover,
        .customBatchPrinting .form-inline button:hover {
            background-color: royalblue;
        }

        .searh-row {
            display: flex;
        }

        .searh-row .search-filed-grp:nth-child(even) {
            margin-left: 10px;
        }

        #posts-filter .search-box {
            display: none !important;
        }

        .search-filed-grp {
            width: 50%;
        }

        .search-field input,
        .search-field select {
            width: 100%;
        }

        #modal-window-search .form-inline .button,
        .customBatchPrinting .form-inline .button {
            padding: 10px 20px;
            background-color: dodgerblue;
            border: 1px solid #ddd;
            color: white;
            cursor: pointer;
            line-height: inherit !important;
        }

        .search-filed-grp label {
            display: block;
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

        .anti_fraud.column-anti_fraud .wc-af-score::before {

            content: "\f334";
            display: inline-block;
            -webkit-font-smoothing: antialiased;
            font: 400 20px/1 dashicons;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        ul.subsubsub {
            display: none;
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
        }

        #original .searh-row .search-filed-grp:nth-child(2) {
            margin-left: 15px !important;
        }

        div#original .select2-container {
            margin-top: 5px;
        }

        div#original {
            width: 100%;
            max-width: 488px;
        }

        .wp-list-table .column-cb {
            width: 2%;
        }

        .wp-list-table .column-ordernumber {
            width: 10%;
        }

        .wp-list-table .column-orderdate {
            width: 8%;
        }

        .wp-list-table .column-emailphone {
            width: 10%;
        }

        .wp-list-table .column-totalpaid {
            width: 11%;
        }

        .wp-list-table .column-billing {
            width: 7%;
        }

        .wp-list-table .column-shipping {
            width: 7%;
        }

        .wp-list-table .column-ship {
            width: 5%;
        }

        .wp-list-table .column-products {
            width: 40%;
        }

        #the-list .column-products tr:last-child td,
        #the-list .column-products tr:last-child th {
            border-bottom: 1px solid #c3c4c7 !important;
            box-shadow: inherit;
        }

        .sbr-button {
            margin: 11px 0 4px !important;
            white-space: normal !important;
        }

        @media (max-width: 800px) {
            #modal-window-search .form-inline input {
                margin: 10px 0;
            }

            #modal-window-search .form-inline,
            .customBatchPrinting .form-inline {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
<?php
}

function sbr_orders_list_display_callback()
{
    //check_ajax_referer( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce', true );

    if (!class_exists('Orders_List_Table')) {
        require_once(get_stylesheet_directory() . '/inc/orders-list-table.php');
    }
    $orders_obj = new Orders_List_Table();
    if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'waiting-impression') {
        $orders_obj->prepare_items_waiting_on_impression();
    } else if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] == 'pending-lab') {
        $orders_obj->prepare_items_pending_lab();
    } else {
        $orders_obj->prepare_items();
    }
    //$orders_obj->prepare_items();

    ob_start();
    $orders_obj->display();
    $display = ob_get_clean();

    die(json_encode(array(
        "display" => $display
    )));
}

add_action('wp_ajax_orders_list_display', 'sbr_orders_list_display_callback');

function sbr_orders_list_display_update_callback()
{
    if (!class_exists('Orders_List_Table')) {
        require_once(get_stylesheet_directory() . '/inc/orders-list-table.php');
    }
    $orders_obj = new Orders_List_Table();
    $orders_obj->ajax_response();
}

add_action('wp_ajax_orders_list_display_update', 'sbr_orders_list_display_update_callback');

function sbr_order_item_tray_number_update_callback()
{
    global $wpdb;

    $order_id = $_GET['order_id'];
    $item_id = $_GET['item_id'];
    $tray_number = $_GET['tray_number'];

    $id = $wpdb->get_var("SELECT id FROM  " . SB_ORDER_TABLE . " WHERE tray_number='" . $tray_number . "' AND order_id!=" . $order_id . " AND item_id!=" . $item_id);
    if ($id) {
        echo json_encode(array('status' => 'error', 'msg' => 'This tray number is already assigned'));
    } else {
        $wpdb->update(SB_ORDER_TABLE, array('tray_number' => $tray_number), array('order_id' => $order_id, 'item_id' => $item_id));
        echo json_encode(array('status' => 'success', 'msg' => 'Tray number is assigned'));
    }
    exit();
}

add_action('wp_ajax_order_item_tray_number_update', 'sbr_order_item_tray_number_update_callback');

function sbr_order_set_as_shipped_callback()
{
    global $wpdb;

    $order_id = $_GET['order_id'];
    $order = wc_get_order($order_id);
    $order->update_status('wc-shipped');

    echo json_encode(array('status' => 'success', 'msg' => 'Order set as shipped'));
    exit();
}

add_action('wp_ajax_sbr_order_set_as_shipped', 'sbr_order_set_as_shipped_callback');

function sbr_order_set_as_trash_callback()
{
    global $wpdb;

    $order_id = $_GET['order_id'];
    $order = wc_get_order($order_id);
    $order->update_status('trash');

    echo json_encode(array('status' => 'success', 'msg' => 'Order set as trash'));
    exit();
}

add_action('wp_ajax_sbr_order_set_as_trash', 'sbr_order_set_as_trash_callback');

function fetch_ts_script()
{
    $screen = get_current_screen();

    if ($screen->id != "toplevel_page_sb_orders_page")
        return;
    $batch_printing = isset($_GET['batch_printing']) ? $_GET['batch_printing'] : '';
    $advance_search = isset($_GET['advance_search']) ? $_GET['advance_search'] : '';
    $simple_search = isset($_GET['simple_search']) ? $_GET['simple_search'] : '';
    $exclude_legacy = isset($_GET['exclude_legacy']) ? $_GET['exclude_legacy'] : 'yes';
    $exclude_addons = isset($_GET['exclude_addons']) ? $_GET['exclude_addons'] : 'yes';
    $orderby_orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'post_date';
    $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
    $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
    $customer_email_address = isset($_GET['customer_email_address']) ? $_GET['customer_email_address'] : '';
    $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';
    $tray_number = isset($_GET['tray_number']) ? $_GET['tray_number'] : '';
    $sbr_number = isset($_GET['sbr_number']) ? $_GET['sbr_number'] : '';
    $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
    $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
    $post_status = isset($_GET['post_status']) ? $_GET['post_status'] : '';
    $product_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
    $exclude_extra_whitening_tray_set = isset($_GET['exclude_extra_whitening_tray_set']) ? $_GET['exclude_extra_whitening_tray_set'] : 'yes';
    $exclude_night_guard_reorder = isset($_GET['exclude_night_guard_reorder']) ? $_GET['exclude_night_guard_reorder'] : 'yes';
    $shipment_shipment = isset($_GET['shipment']) ? $_GET['shipment'] : 'first';
    $paged_paged = isset($_GET['paged']) ? $_GET['paged'] : 1;
    $order_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
    $join_type = isset($_GET['join_type']) ? $_GET['join_type'] : 'AND';
    $product_status = isset($_GET['product_status']) ? $_GET['product_status'] : '';
    $product_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
    $search_search = isset($_GET['s']) ? $_GET['s'] : '';

?>

    <script type="text/javascript">
        var send_req = true;

        function GetParameterValues(param) {
            var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < url.length; i++) {
                var urlparam = url[i].split('=');
                if (urlparam[0] == param) {
                    return urlparam[1];
                }
            }
        }
        (function($) {
            list = {
                display: function() {
                    let data = {};
                    if ('<?php echo $batch_printing; ?>' == 'yes') {
                        /*let product_id = $('#original select[name="product_id[]"]').map(function (e) {
                         return this.value; // $(this).val()
                         }).get();
                         let product_qty = $('#original input[name="product_qty[]"]').map(function () {
                         return this.value; // $(this).val()
                         }).get();*/
                        var shippings = '';
                        var subscription_orders = '';
                        shippings = $('input[name=shipping_flag]:checked').map(function() {

                            return $(this).val();
                        });
                        subscription_orders = $('input[name=subscription_orders]:checked').map(function() {

                                return $(this).val();
                        });
                        data = {
                            advance_search: '<?php echo urldecode($advance_search); ?>',
                            simple_search: '<?php echo urldecode($simple_search); ?>',
                            batch_printing: '<?php echo urldecode($batch_printing); ?>',
                            exclude_legacy: '<?php echo urldecode($exclude_legacy); ?>',
                            exclude_addons: '<?php echo urldecode($exclude_addons); ?>',
                            exclude_night_guard_reorder: '<?php echo urldecode($exclude_night_guard_reorder); ?>',
                            exclude_extra_whitening_tray_set: '<?php echo  urldecode($exclude_extra_whitening_tray_set) ?>',
                            shipment: '<?php echo urldecode($shipment_shipment); ?>',
                            shipping_flag: shippings.get(),
                            //subscription_orders: subscription_orders.get(),
                            //product_id: product_id,
                            //product_qty: product_qty,
                            action: 'orders_list_display',
                            paged: '<?php echo  urldecode($paged_paged); ?>',
                            order: '<?php echo  urldecode($order_order); ?>',
                            orderby: '<?php echo urldecode($orderby_orderby); ?>',
                            join_type: '<?php echo urldecode($join_type); ?>',
                        }
                    } else if ('<?php echo $simple_search; ?>' == 'true') {
                        data = {
                            advance_search: '<?php echo urldecode($advance_search); ?>',
                            simple_search: '<?php echo urldecode($simple_search); ?>',
                            batch_printing: '<?php echo urldecode($batch_printing); ?>',
                            s: '<?php echo $search_search; ?>',
                            action: 'orders_list_display',
                            paged: '<?php echo urldecode($paged_paged); ?>',
                            order: '<?php echo urldecode($order_order); ?>',
                            orderby: '<?php echo urldecode($orderby_orderby); ?>'
                        }
                    } else {
                        var shippings = '';
                        var subscription_orders = '';
                        shippings = $('input[name=shipping_flag]:checked').map(function() {

                            return $(this).val();
                        });
                        subscription_orders = $('input[name=subscription_orders]:checked').map(function() {

                            return $(this).val();
                        });
                        data = {
                            //_ajax_custom_list_nonce: $('#_ajax_custom_list_nonce').val(),
                            advance_search: '<?php echo urldecode($advance_search); ?>',
                            simple_search: '<?php echo urldecode($simple_search); ?>',
                            batch_printing: '<?php echo urldecode($batch_printing); ?>',
                            customer_first_name: '<?php echo urldecode($customer_first_name); ?>',
                            customer_last_name: '<?php echo urldecode($customer_last_name); ?>',
                            customer_email_address: '<?php echo urldecode(str_replace('|', '\n', $customer_email_address)); ?>',
                            order_number: '<?php echo urldecode(str_replace('|', '\n', $order_number)); ?>',
                            tray_number: '<?php echo urldecode(str_replace('|', '\n', $tray_number)); ?>',
                            sbr_number: '<?php echo urldecode(str_replace('|', '\n', $sbr_number)); ?>',
                            order_start_date: '<?php echo urldecode($order_start_date); ?>',
                            order_end_date: '<?php echo urldecode($order_end_date); ?>',
                            post_status: '<?php echo urldecode($post_status); ?>',
                            product_status: '<?php echo urldecode($product_status); ?>',
                            product_cat: '<?php echo urldecode($product_cat); ?>',
                            shipping_flag: shippings.get(),
                            //subscription_orders: subscription_orders.get(),
                            product_cat: '<?php echo urldecode($product_cat); ?>',
                            action: 'orders_list_display',
                            paged: '<?php echo urldecode($paged_paged); ?>',
                            order: '<?php echo urldecode($order_order); ?>',
                            orderby: '<?php echo urldecode($orderby_orderby); ?>'
                        }
                    }

                    <?php if (isset($_GET['product_status']) && $_GET['product_status'] == 'pending-lab' && !isset($_GET['customer_first_name'])) {
                    ?>
                        send_req = false;
                    <?php
                    }
                    ?>
                    <?php if (isset($_GET['product_status']) && $_GET['product_status'] == 'waiting-impression' && !isset($_GET['customer_first_name'])) {
                    ?>
                        send_req = false;
                    <?php
                    }
                    ?>
                    if (!send_req) {

                        data.per_page = 0;
                    }
                    jQuery('.loading-sbr').show();
                    $.ajax({
                        url: ajaxurl,
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            $("#sbr-orders-table").html(response.display);
                            $("tbody").on("click", ".toggle-row", function(e) {
                                e.preventDefault();
                                $(this).closest("tr").toggleClass("is-expanded")
                            });
                            list.init();
                            list.initSearch();
                            jQuery('.loading-sbr').hide();
                        }
                    });

                },
                initSearch: function() {
                    $('#simple-Search #search-submit').on('click', function(e) {
                        e.preventDefault();
                        let state = {
                            page: 'sb_orders_page',
                            advance_search: '',
                            simple_search: 'true',
                            s: $('#post-search-input').val()
                        };
                        let url = 'admin.php?page=sb_orders_page&advance_search=&simple_search=true&s=' + $('#post-search-input').val();
                        history.pushState(state, 'Orders', url);
                        var data = {
                            advance_search: '',
                            simple_search: 'true',
                            s: $('#post-search-input').val() || '',
                            paged: '1',
                            order: 'DESC',
                            orderby: 'post_date'
                        };
                        list.update(data);
                    });
                    $('#advance-search #advanced-search-submit').on('click', function(e) {
                        send_req = true;
                        e.preventDefault();
                        var shippings = '';
                        var subscription_orders = '';
                        shippings = $('input[name=shipping_flag]:checked').map(function() {

                            return $(this).val();
                        });
                        subscription_orders = $('input[name=subscription_orders]:checked').map(function() {
                            return $(this).val();
                        });
                        let state = {
                            page: 'sb_orders_page',
                            advance_search: 'advance_search',
                            simple_search: '',
                            customer_first_name: $('#search-fname').val(),
                            customer_last_name: $('#search-laname').val(),
                            customer_email_address: $('#search-email').val(),
                            order_number: $('#search-order-number').val(),
                            tray_number: $('#search-tray-number').val(),
                            sbr_number: $('#search-sbr-number').val(),
                            order_start_date: $('#search-start-date').val(),
                            order_end_date: $('#search-end-date').val(),
                            post_status: $('#post_status').val(),
                            product_status: $('#product_status').val(),
                            product_cat: $('#product_cat').val()
                        };
                        let url = 'admin.php?page=sb_orders_page&advance_search=advance_search&simple_search=&customer_first_name=' + $('#search-fname').val() + '&customer_last_name=' + $('#search-laname').val() + '&customer_email_address=' + $('#search-email').val() + '&order_number=' + $('#search-order-number').val() + '&tray_number=' + $('#search-tray-number').val() + '&sbr_number=' + $('#search-sbr-number').val() + '&order_start_date=' + $('#search-start-date').val() + '&order_end_date=' + $('#search-end-date').val() + '&post_status=' + $('#post_status').val() + '&product_status=' + $('#product_status').val() + '&product_cat=' + $('#product_cat').val() + '&shipping_flag=' + shippings.get()+'&subscription_orders=' + subscription_orders.get();
                        url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                        history.pushState(state, 'Orders', url_updated);
                        var data = {
                            advance_search: 'advance_search',
                            simple_search: '',
                            customer_first_name: $('#search-fname').val() || '',
                            customer_last_name: $('#search-laname').val() || '',
                            customer_email_address: $('#search-email').val() || '',
                            order_number: $('#search-order-number').val() || '',
                            tray_number: $('#search-tray-number').val() || '',
                            sbr_number: $('#search-sbr-number').val() || '',
                            order_start_date: $('#search-start-date').val() || '',
                            order_end_date: $('#search-end-date').val() || '',
                            post_status: $('#post_status').val() || '',
                            product_status: $('#product_status').val(),
                            product_cat: $('#product_cat').val(),
                            upsell_orders: $('input[name=upsell_orders]:checked').val(),
                            shipping_flag: shippings.get(),
                            subscription_orders: subscription_orders.get(),
                            paged: '1',
                            order: 'DESC',
                            orderby: 'post_date'
                        };
                        list.update(data);
                    });
                    $('#batch-printing #batch-print-btn').on('click', function(e) {
                        e.preventDefault();
                        var shippings = '';
                        shippings = $('input[name=shipping_flag_batch]:checked').map(function() {

                            return $(this).val();
                        });
                        //console.log(shippings);
                        let product_id = $('#original select[name="product_id[]"]').map(function(e) {
                            return this.value; // $(this).val()
                        }).get();
                        let product_qty = $('#original input[name="product_qty[]"]').map(function() {
                            return this.value; // $(this).val()
                        }).get();
                        let shipment = jQuery('input[name="shipment"]:checked').val();
                        //console.log(product_id);
                        let join_type = jQuery('.bp-search-join-type input[name="bp_join_type"]:checked').val();
                        let state = {
                            page: 'sb_orders_page',
                            batch_printing: 'yes',
                            product_id: product_id,
                            product_qty: product_qty,
                            join_type: join_type /*,shipment: shipment*/
                        };
                        let url = 'admin.php?page=sb_orders_page&batch_printing=yes&product_id=' + product_id + '&product_qty=' + product_qty + '&shipping_flag=' + shippings.get() + '&exclude_legacy=' + $('input[name=exclude_legacy]:checked').val() + '&join_type=' + join_type + '&exclude_addons=' + $('input[name=exclude_addons]:checked').val() + '&exclude_night_guard_reorder=' + $('input[name=exclude_night_guard_reorder]:checked').val() + '&exclude_extra_whitening_tray_set=' + $('input[name=exclude_extra_whitening_tray_set]:checked').val()+ '&shipping_flag=' + shippings.get()/*+'&subscription_orders=' + subscription_orders.get() +'&shipment='+shipment*/ ;
                        url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                        history.pushState(state, 'Orders', url_updated);
                        if (product_id != '') {
                            var data = {
                                batch_printing: 'yes',
                                product_id: product_id,
                                product_qty: product_qty,
                                shipping_flag: shippings.get(),
                                //subscription_orders: subscription_orders.get(),
                                exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                join_type: join_type,
                                //  shipment: shipment,
                                paged: '1',
                                order: 'DESC',
                                orderby: 'post_date'
                            };
                        } else {
                            var data = {
                                batch_printing: 'yes',
                                // shipment: shipment,
                                shipping_flag: shippings.get(),
                                //subscription_orders: subscription_orders.get(),
                                exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                paged: '1',
                                order: 'DESC',
                                orderby: 'post_date'
                            };
                        }

                        list.update(data);
                    });
                },
                init: function() {
                    var timer;
                    var delay = 1500;
                    $('.tablenav-pages a, .manage-column.sortable a, .manage-column.sorted a').on('click', function(e) {
                        e.preventDefault();
                        var query = this.search.substring(1);
                        let data = {};
                        let batch_printing = list.__query(query, 'batch_printing');
                        if (batch_printing == 'yes') {
                            let product_id = $('#original select[name="product_id[]"]').map(function(e) {
                                return this.value;
                            }).get();
                            let product_qty = $('#original input[name="product_qty[]"]').map(function() {
                                return this.value;
                            }).get();
                            let join_type = jQuery('.bp-search-join-type input[name="bp_join_type"]:checked').val();
                            //let shipment = jQuery('[name="shipment"]:checked').val();
                            if (product_id != '') {
                                data = {
                                    batch_printing: batch_printing,
                                    product_id: product_id,
                                    // shipment:shipment,
                                    product_qty: product_qty,
                                    join_type: join_type,
                                    exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                    exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                    exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                    exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                    paged: list.__query(query, 'paged') || '1',
                                    order: list.__query(query, 'order') || 'DESC',
                                    orderby: list.__query(query, 'orderby') || 'post_date'
                                };
                            } else {
                                data = {
                                    batch_printing: batch_printing,
                                    //shipment:shipment,
                                    paged: list.__query(query, 'paged') || '1',
                                    order: list.__query(query, 'order') || 'DESC',
                                    exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                    exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                    exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                    exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                    orderby: list.__query(query, 'orderby') || 'post_date'
                                };
                            }
                            let state = {
                                page: 'sb_orders_page',
                                batch_printing: data.batch_printing,
                                product_id: data.product_id,
                                product_qty: data.product_qty,
                                join_type: join_type,
                                paged: data.paged,
                                orderby: data.orderby,
                                order: data.order /*,shipment: data.shipment*/
                            };
                            let url = 'admin.php?page=sb_orders_page&batch_printing=' + data.batch_printing + '&product_id=' + data.product_id + '&product_qty=' + data.product_qty + '&join_type=' + join_type + '&paged=' + data.paged + '&orderby=' + data.orderby + '&order=' + data.order /*+'&shipment=' + data.shipment*/ ;
                            url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                            history.pushState(state, 'Orders', url_updated);
                        } else {
                            data = {
                                advance_search: list.__query(query, 'advance_search') || '',
                                simple_search: list.__query(query, 'simple_search') || '',
                                batch_printing: list.__query(query, 'batch_printing') || '',
                                customer_first_name: $('#search-fname').val() || '',
                                customer_last_name: $('#search-lname').val() || '',
                                customer_email_address: $('#search-email').val() || '',
                                order_number: $('#search-order-number').val() || '',
                                tray_number: $('#search-tray-number').val() || '',
                                sbr_number: $('#search-sbr-number').val() || '',
                                order_start_date: $('#search-start-date').val() || '',
                                order_end_date: $('#search-end-date').val() || '',
                                post_status: $('#post_status').val() || '',
                                product_status: $('#product_status').val() || '',
                                product_cat: $('#product_cat').val() || '',
                                s: $('#post-search-input').val() || '',
                                paged: list.__query(query, 'paged') || '1',
                                order: list.__query(query, 'order') || 'DESC',
                                orderby: list.__query(query, 'orderby') || 'post_date'
                            };
                            let state = {
                                page: 'sb_orders_page',
                                advance_search: data.advance_search,
                                simple_search: data.simple_search,
                                customer_first_name: data.customer_first_name,
                                customer_last_name: data.customer_last_name,
                                customer_email_address: data.customer_email_address,
                                order_number: data.order_number,
                                tray_number: data.tray_number,
                                sbr_number: data.sbr_number,
                                order_start_date: data.order_start_date,
                                order_end_date: data.order_end_date,
                                post_status: data.post_status,
                                product_status: data.product_status,
                                product_cat: data.product_cat,
                                s: data.s,
                                paged: data.paged,
                                orderby: data.orderby,
                                order: data.order
                            };
                            let url = 'admin.php?page=sb_orders_page&advance_search=' + data.advance_search + '&simple_search=' + data.simple_search + '&customer_first_name=' + data.customer_first_name + '&customer_last_name=' + data.customer_last_name + '&customer_email_address=' + data.customer_email_address + '&order_number=' + data.order_number + '&tray_number=' + data.tray_number + '&sbr_number=' + data.sbr_number + '&order_start_date=' + data.order_start_date + '&order_end_date=' + data.order_end_date + '&post_status=' + data.post_status + '&product_status=' + data.product_status + '&product_cat=' + data.product_cat + '&paged=' + data.paged + '&orderby=' + data.orderby + '&order=' + data.order;
                            url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                            history.pushState(state, 'Orders', url_updated);
                        }

                        list.update(data);
                    });
                    $('input[name=paged]').on('keyup', function(e) {

                        if (13 == e.which) {
                            e.preventDefault();
                        }

                        //let paged = $(this).val();
                        let data = {};

                        if ('<?php echo $batch_printing; ?>' == 'yes') {
                            let product_id = $('#original select[name="product_id[]"]').map(function(e) {
                                return this.value;
                            }).get();
                            let product_qty = $('#original input[name="product_qty[]"]').map(function() {
                                return this.value;
                            }).get();
                            let join_type = jQuery('.bp-search-join-type input[name="bp_join_type"]:checked').val();
                            // let shipment = jQuery('input[name="shipment"]:checked').val();
                            if (product_id != '') {
                                data = {
                                    batch_printing: '<?php echo urldecode($batch_printing); ?>',
                                    // shipment:shipment,
                                    product_id: product_id,
                                    product_qty: product_qty,
                                    join_type: join_type,
                                    paged: parseInt($('input[name=paged]').val()) || '1',
                                    order: $('input[name=order]').val() || 'DESC',
                                    exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                    exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                    exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                    exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                    orderby: $('input[name=orderby]').val() || 'post_date'
                                };
                            } else {
                                data = {
                                    batch_printing: '<?php echo urldecode($batch_printing); ?>',
                                    // shipment:shipment,
                                    paged: parseInt($('input[name=paged]').val()) || '1',
                                    order: $('input[name=order]').val() || 'DESC',
                                    exclude_legacy: $('input[name=exclude_legacy]:checked').val(),
                                    exclude_addons: $('input[name=exclude_addons]:checked').val(),
                                    exclude_night_guard_reorder: $('input[name=exclude_night_guard_reorder]:checked').val(),
                                    exclude_extra_whitening_tray_set: $('input[name=exclude_extra_whitening_tray_set]:checked').val(),
                                    orderby: $('input[name=orderby]').val() || 'post_date'
                                };
                            }
                            let state = {
                                page: 'sb_orders_page',
                                batch_printing: data.batch_printing,
                                product_id: data.product_id,
                                product_qty: data.product_qty,
                                join_type: join_type,
                                paged: data.paged,
                                orderby: data.orderby,
                                order: data.order /*,shipment:data.shipment*/
                            };
                            let url = 'admin.php?page=sb_orders_page&batch_printing=' + data.batch_printing + '&product_id=' + data.product_id + '&product_qty=' + data.product_qty + '&join_type=' + join_type + '&paged=' + data.paged + '&orderby=' + data.orderby + '&order=' + data.order /*+'&shipment='+data.shipment*/ ;

                            url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                            history.pushState(state, 'Orders', url_updated);
                        } else {
                            data = {
                                advance_search: $('input[name=advance_search]').val() || '',
                                simple_search: $('input[name=simple_search]').val() || '',
                                batch_printing: '<?php echo urldecode($batch_printing); ?>' || '',
                                customer_first_name: $('#search-fname').val() || '',
                                customer_last_name: $('#search-lname').val() || '',
                                customer_email_address: $('#search-email').val() || '',
                                order_number: $('#search-order-number').val() || '',
                                tray_number: $('#search-tray-number').val() || '',
                                sbr_number: $('#search-sbr-number').val() || '',
                                order_start_date: $('#search-start-date').val() || '',
                                order_end_date: $('#search-end-date').val() || '',
                                post_status: $('#post_status').val() || '',
                                product_status: $('#product_status').val() || '',
                                product_cat: $('#product_cat').val() || '',
                                s: $('#post-search-input').val() || '',
                                paged: parseInt($('input[name=paged]').val()) || '1',
                                order: $('input[name=order]').val() || 'DESC',
                                orderby: $('input[name=orderby]').val() || 'post_date'
                            };
                            let state = {
                                page: 'sb_orders_page',
                                advance_search: data.advance_search,
                                simple_search: data.simple_search,
                                customer_first_name: data.customer_first_name,
                                customer_last_name: data.customer_last_name,
                                customer_email_address: data.customer_email_address,
                                order_number: data.order_number,
                                tray_number: data.tray_number,
                                sbr_number: data.sbr_number,
                                order_start_date: data.order_start_date,
                                order_end_date: data.order_end_date,
                                post_status: data.post_status,
                                product_status: data.product_status,
                                product_cat: data.product_cat,
                                s: data.s,
                                paged: data.paged,
                                orderby: data.orderby,
                                order: data.order
                            };
                            let url = 'admin.php?page=sb_orders_page&advance_search=' + data.advance_search + '&simple_search=' + data.simple_search + '&customer_first_name=' + data.customer_first_name + '&customer_last_name=' + data.customer_last_name + '&customer_email_address=' + data.customer_email_address + '&order_number=' + data.order_number + '&tray_number=' + data.tray_number + '&sbr_number=' + data.sbr_number + '&order_start_date=' + data.order_start_date + '&order_end_date=' + data.order_end_date + '&post_status=' + data.post_status + '&product_status=' + data.product_status + '&product_cat=' + data.product_cat + '&paged=' + data.paged + '&orderby=' + data.orderby + '&order=' + data.order;
                            url_updated = url.replace(/(?:\r\n|\r|\n)/g, '|');
                            history.pushState(state, 'Orders', url_updated);
                        }
                        window.clearTimeout(timer);
                        timer = window.setTimeout(function() {
                            list.update(data);
                        }, delay);
                    });
                    $('#sbr-orders-list').on('submit', function(e) {
                        //e.preventDefault();
                    });
                },
                /** AJAX call
                 *
                 * Send the call and replace table parts with updated version!
                 *
                 * @param    object    data The data to pass through AJAX
                 */
                update: function(data) {
                    jQuery('.loading-sbr').show();
                    $.ajax({
                        url: ajaxurl,
                        data: $.extend({
                                //_ajax_custom_list_nonce: $('#_ajax_custom_list_nonce').val(),
                                action: 'orders_list_display_update',
                            },
                            data
                        ),
                        success: function(response) {
                            var response = $.parseJSON(response);
                            if (response.rows.length)
                                $('#the-list').html(response.rows);
                            if (response.column_headers.length)
                                $('#sbr-orders-table .wp-list-table > thead tr, #sbr-orders-table .wp-list-table > tfoot tr').html(response.column_headers);
                            if (response.pagination.bottom.length)
                                $('.tablenav.top .tablenav-pages').html($(response.pagination.top).html());
                            if (response.pagination.top.length)
                                $('.tablenav.bottom .tablenav-pages').html($(response.pagination.bottom).html());
                            list.init();
                            jQuery('.loading-sbr').hide();
                        }
                    });
                },
                /**
                 * Filter the URL Query to extract variables
                 *
                 * @see http://css-tricks.com/snippets/javascript/get-url-variables/
                 *
                 * @param    string    query The URL query part containing the variables
                 * @param    string    variable Name of the variable we want to get
                 *
                 * @return   string|boolean The variable value if available, false else.
                 */
                __query: function(query, variable) {
                    var vars = query.split("&");
                    for (var i = 0; i < vars.length; i++) {
                        var pair = vars[i].split("=");
                        if (pair[0] == variable)
                            return pair[1];
                    }
                    return false;
                },
            }

            list.display();
        })(jQuery);
    </script>
<?php
}

add_action('admin_footer', 'fetch_ts_script');
?>