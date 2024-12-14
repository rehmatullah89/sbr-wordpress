<?php
// Add custom column headers here
add_action('woocommerce_admin_order_item_headers', 'smilebrilliant_admin_order_item_header_options');

function smilebrilliant_admin_order_item_header_options() {

    echo '<th>Contact</th>';
}

add_action('woocommerce_admin_order_item_values', 'smilebrilliant_admin_order_item_values', 10, 3);

function smilebrilliant_admin_order_item_values($product, $item, $item_id = null) {
    echo '<td>';
    $product_visibility = $product->get_catalog_visibility();
    if ($product_visibility == 'visible') {
        global $wpdb;
        $product_id = $item->get_product_id();
        $order_number = isset($_REQUEST['post']) ? $_REQUEST['post'] : 0;
        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
        if ($three_way_ship_product == 'yes') {
            $smilebrilliant_order_information_table = 'smilebrilliant_order_information';

            $ticket_query = $wpdb->get_results("SELECT ticket_id , user_id FROM  $smilebrilliant_order_information_table WHERE order_id = $order_number and item_id = $item_id");
            if (count($ticket_query)) {
                $ajax_url = add_query_arg(
                        array(
                    'action' => 'ticketChatByOrderItem',
                    'ticket_id' => $ticket_query[0]->ticket_id,
                    'order_id' => $order_number,
                    'user_id' => $ticket_query[0]->user_id,
                    'width' => 1000,
                    'height' => 600,
                        ), admin_url('admin-ajax.php')
                );
                ?>

                <a href="javascript:;" class="openChat" custom-url = "<?php echo $ajax_url; ?>">
                    <span class="dashicons dashicons-admin-comments"></span>
                </a>
                <?php
            }
        }
        ?>
        <span class="dashicons dashicons-phone"></span><span class="dashicons dashicons-welcome-write-blog"></span><span class="dashicons dashicons-cart"></span>
        <?php
        echo '</td>';
    }
}

add_action('woocommerce_after_order_itemmeta', 'smilebrilliant_order_meta_tray_number_display', 10, 3);

function smilebrilliant_order_meta_tray_number_display($item_id, $item, $product) {

    global $wpdb;
    $product_visibility = $product->get_catalog_visibility();
    if ($product_visibility == 'visible') {

        $product_id = $item->get_product_id();
        $order_number = isset($_REQUEST['post']) ? $_REQUEST['post'] : 0;
        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
        if ($three_way_ship_product == 'yes') {
            $smilebrilliant_order_information_table = 'smilebrilliant_order_information';
            $tray_q = "SELECT * FROM  $smilebrilliant_order_information_table";
            $tray_q .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $tray_query = $wpdb->get_results($tray_q);
            if (count($tray_query)) {
                ?>

                <p class="tray_number_container" data-item="<?php echo $item_id; ?>">
                    <input type="text" id="tray_number_<?php echo $item_id; ?>" class="tray_number-input" name="tray_number" placeholder="Tray Number" value="<?php echo isset($tray_query[0]->tray_number) ? $tray_query[0]->tray_number : ''; ?>">
                    <input type="hidden" class="smilebrilliant_order_information_key"  value="<?php echo isset($tray_query[0]->id) ? $tray_query[0]->id : ''; ?>">
                    <button class="btn_tray_number" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>
                </p>
                <?php
            }
        }
    }
}

add_action('wp_ajax_update_tray_number', 'update_tray_number_callback');

function update_tray_number_callback() {
    global $wpdb;
    if (isset($_REQUEST['smilebrilliant_order_information_key'])) {
        $order_key = $_REQUEST['smilebrilliant_order_information_key'];
        $table_name = 'smilebrilliant_order_information';
        $query = $wpdb->get_results("SELECT * FROM  $table_name WHERE id = $order_key");
        if (count($query) > 0) {
            $update = array(
                'tray_number' => $_REQUEST['tray_number']
            );
            $condition = array(
                'id' => $order_key,
            );
            $wpdb->update($table_name, $update, $condition);
            echo 'Updated';
        } else {
            echo 'Something Went Wrong.';
        }
        die;
    }
}

function checkOrderItemStatus($status) {
    $possible_status = array(
        1 => 'Processing',
        2 => 'Shipped',
        3 => 'Waiting impression',
        4 => 'Analzing impression',
        5 => 'Shipped',
        6 => 'Received by customer',
        7 => 'Open',
    );
    if (isset($possible_status[$status])) {
        return $possible_status[$status];
    } else {
        return '--';
    }
}

add_action('woocommerce_order_item_line_item_html', 'woocommerce_order_item_line_item_html', 1, 3);

/**
 * Callback Listener for customised line item functionality in the admin.
 */
function woocommerce_order_item_line_item_html($item_id, $item, $order) {
    // Add your custom line item functionality.
    // A good example would be order fulfillment for a line item.
    $html = '';
    $product = $item->get_product();

    $product_visibility = $product->get_catalog_visibility();
    if ($product_visibility == 'visible') {
        global $wpdb;
        $product_id = $item->get_product_id();
        $order_number = $order->get_order_number();

        ///SB_LOG = 'smilebrilliant_event_log';
        $q1 = "SELECT * FROM  SB_LOG";
        $q1 .= " JOIN smilebrilliant_event_type ON smilebrilliant_event_log.event_id=smilebrilliant_event_type.event_id";
        $q1 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
        $query = $wpdb->get_results($q1);

        $query2 = '';
        $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
         $html .= '<tr id="order_item_data-'.$item_id.'"><td colspan="8">';
        if ($three_way_ship_product == 'yes') {
            $smilebrilliant_order_information_table = 'smilebrilliant_order_information';
            $q2 = "SELECT * FROM  $smilebrilliant_order_information_table";
            $q2 .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_number;
            $query2 = $wpdb->get_results($q2);
        }

        if (count($query) > 0) {
           
            $html .= '<table class="table table-striped table-bordered mbttable " id="dest" style="width: 100%;">';
            $html .= '<thead class="thead-dark">';
            $html .= '<tr>';
            $html .= '<th style="background:#333; color:#fff; text-align:left; padding:10px;" class="col1 txt-left">Activity</th>';
            $html .= '<th style="background:#333; color:#fff; text-align:left; padding:10px;" class="col2 txt-left">Date</th>';
            $html .= '<th style="background:#333; color:#fff; text-align:left; padding:10px;" class="col3 txt-left">Status</th>';
            $html .= '<th style="background:#333; color:#fff; text-align:left; padding:10px;" class="col4 txt-left">Actions</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($query as $key => $response) {
               
                $html .= '<tr>';
                $html .= '<td class="txt-left col1">' . $response->event_name . '</td>';
                $html .= '<td class="txt-left col2">' . $response->created_date . '</td>';
                if ($three_way_ship_product == 'yes') {
                    $html .= '<td class="txt-left statusbx col3">' . checkOrderItemStatus($response->status) . '</td>';
                } else {
                    $html .= '<td class="txt-left statusbx col3">' . checkOrderItemStatus($response->status) . '</td>';
                }
                if ($response->status) {
                    $ajax_url = add_query_arg(
                            array(
                        'action' => 'create_shipping_request',
                        'order_id' => $order_number,
                        'log_id' => $response->log_id,
                        'event_id' => $response->event_id,
                        'width' => 1000,
                        'height' => 500,
                            ), admin_url('admin-ajax.php')
                    );
                }
                $html .= '<td class="txt-left col4"><a class="createShipping" href="javascript:;" custom-url="' . $ajax_url . '">' . $response->event_description . '</a> </td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
        
        }
         $html .= '</td></tr>';
    }
    echo $html;
}

add_action('wp_ajax_update_order_good_to_ship', 'update_order_good_to_ship_callback');

function update_order_good_to_ship_callback() {
    global $wpdb;
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '') {
        $order_id = $_REQUEST['order_id'];
        $order = wc_get_order($order_id);
        $order->update_status('processing');
      //  SB_LOG = 'smilebrilliant_event_log';
     //   $smilebrilliant_order_information_table = 'smilebrilliant_order_information';
        $user = $order->get_user();
        $user_email = $user->data->user_email;
        foreach ($order->get_items() as $item_id => $item) {

            $product_id = $item->get_product_id();
            $product = $item->get_product();
            $product_visibility = $product->get_catalog_visibility();
            if ($product_visibility == 'visible') {
                $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
                if ($three_way_ship_product == 'yes') {
                    $zendesk_user_id = search_user_zendesk($user_email);

                    if ($zendesk_user_id) {
                        
                    } else {
                        $data = array(
                            'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                            'email' => $user_email,
                            'phone' => $order->get_billing_phone(),
                        );
                        $zendesk_user_id = create_user_zendesk($data);
                    }


                    $query = $wpdb->get_results("SELECT * FROM  $smilebrilliant_order_information_table WHERE order_id = $order_id and item_id = $item_id");

                    if (empty($query)) {
                        $ticket_id = 1; //create_ticket_zendesk($item, $order, $zendesk_user_id, $order_id);
                        $wpdb->insert($smilebrilliant_order_information_table, array(
                            "order_id" => $order_id,
                            "tray_number" => '',
                            "ticket_id" => $ticket_id,
                            "item_id" => $item_id,
                            "product_id" => $product_id,
                            "status" => 1,
                            "user_id" => $order->get_customer_id(),
                            "created_date" => date("Y-m-d h:i:sa"),
                        ));
                    }
                }
                //Create Log
                $wpdb->insert(SB_LOG, array(
                    "tray_number" => '',
                    "order_id" => $order_id,
                    "child_order_id" => 0,
                    "item_id" => $item_id,
                    "product_id" => $product_id,
                    "event_type" => 1,
                    "warranty_claim_id" => 0,
                    "tracking_code" => 0,
                    "shipping_date" => '',
                    "impression_received_date" => '',
                    "shipping_information" => '',
                    "is_change_shipping" => 0,
                    "created_date" => date("Y-m-d h:i:sa"),
                ));
                echo 'Log Generated.';
            }
        }
    }
}

//add_action('admin_menu', 'customer_order_menu');

function customer_order_menu() {
    add_menu_page(__('Customer kit ', 'sb'), __('Customer kit', 'sb'), 'manage_options', 'customer-order-dashboard', 'customer_order_dashboard_callback', 'dashicons-money');
}

function customer_order_dashboard_callback() {
    /*
     * 
     * 
     * elseif (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] <> '') {
      $customerName = $_REQUEST['customer_name'];
      $args = array(
      'limit' => 10,
      'page' => $paged,
      'orderby' => 'date',
      'order' => 'DESC',
      'paginate' => true,
      'billing_first_name' => $customerName,
      // 'billing_last_name' => $customerName,
      );
      $orders = wc_get_orders($args);
      } elseif (isset($_REQUEST['start-date']) && $_REQUEST['start-date'] <> '') {
      //'date_paid' => '2016-02-12',
      } elseif (isset($_REQUEST['contact_email']) && $_REQUEST['contact_email'] <> '') {
      $emailPhone = $_REQUEST['contact_email'];
      $args = array(
      'limit' => 10,
      'page' => $paged,
      'orderby' => 'date',
      'order' => 'DESC',
      'paginate' => true,
      'customer' => $emailPhone,
      );
      $orders = wc_get_orders($args);
     */
    global $wpdb;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $order_number = '';
    $emailPhone = '';
    if (isset($_REQUEST['order_number']) && $_REQUEST['order_number'] <> '') {
        $order_number = $_REQUEST['order_number'];
        $order = wc_get_order($order_number);
    } elseif (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] <> '') {
        $customerName = $_REQUEST['customer_name'];
        $args = array(
            'limit' => 10,
            'page' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'paginate' => true,
            'billing_first_name' => $customerName,
                // 'billing_last_name' => $customerName,
        );
        $orders = wc_get_orders($args);
    } elseif (isset($_REQUEST['start-date']) && $_REQUEST['start-date'] <> '') {
        //'date_paid' => '2016-02-12',
    } elseif (isset($_REQUEST['contact_email']) && $_REQUEST['contact_email'] <> '') {
        $emailPhone = $_REQUEST['contact_email'];
        $args = array(
            'limit' => 10,
            'page' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'paginate' => true,
            'customer' => $emailPhone,
        );
        $orders = wc_get_orders($args);
    } else {
        if (isset($_REQUEST['searchBy']) && $_REQUEST['searchBy'] == 0) {
            $op = 'OR';
            if ($_REQUEST['searchBy'] == 1) {
                $op = 'AND';
            } else {
                $op = 'OR';
            }
            $metaQuery = array();
            if (isset($_REQUEST['contact_email']) && $_REQUEST['contact_email'] <> '') {
                $emailPhone = $_REQUEST['contact_email'];
                if (is_email($emailPhone)) {
                    $metaQuery[] = array(
                        'key' => '_billing_email',
                        'value' => $emailPhone,
                        'compare' => '=',
                    );
                } else {
                    $metaQuery[] = array(
                        'key' => '_billing_phone',
                        'value' => $emailPhone,
                        'compare' => '=',
                    );
                }
            }
            if (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] <> '') {
                $metaQuery[] = array(
                    'key' => '_billing_first_name',
                    'value' => $_REQUEST['customer_name'],
                    'compare' => 'LIKE',
                );
                $metaQuery[] = array(
                    'key' => '_billing_last_name',
                    'value' => $_REQUEST['customer_name'],
                    'compare' => 'LIKE',
                );
            }


            if (isset($_REQUEST['tray_number']) && $_REQUEST['tray_number'] <> '') {
                /*
                  $table_name = $wpdb->prefix . 'sb_orders';
                  $q = "SELECT order_id FROM  $table_name WHERE tray_number = " . $_REQUEST['tray_number'];
                  $query = $wpdb->get_results($q);
                  echo '<pre>';
                  print_r($query);
                  echo '<pre>';
                 * 
                 */
            }


            $param = array(
                'limit' => 10,
                'page' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                // 'return' => 'ids',
                'paginate' => true,
                'meta_query' => array(
                    'relation' => $op,
                    $metaQuery
                )
            );

            $query = new WC_Order_Query($param);
            $orders = $query->get_orders();
        } else {

            $query = new WC_Order_Query(array(
                'limit' => 10,
                'page' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                //    'return' => 'ids',
                'paginate' => true,
            ));
            $orders = $query->get_orders();
        }
    }


    /*
      $args = array(
      'limit' => 10,
      'orderby' => 'date',
      'order' => 'DESC',
      //'paginate' => true,
      );
      $orders = wc_get_orders($args);
     * 
     */
    ?>
    <?php add_thickbox(); ?>
    <form id="posts-filter" method="get" action="<?php echo admin_url('admin.php'); ?>">
        <br/><br/>


        <div class="alignleft actions">

            <p class="search-box" style="display: flex;">
                <input type="hidden"  name="page"  value="customer-order-dashboard" />
                <input type="hidden" name="paged"  value="<?php echo $paged; ?>" />
                <input type="text" id="post-search-input" name="order_number" placeholder="Order Number" value="<?php echo $order_number; ?>" />
                <input type="text" id="post-search-input" name="contact_email" placeholder="Email/Phone" value="<?php echo $emailPhone; ?>" />
                <input type="text" id="post-search-input" name="customer_name" placeholder="Customer Name" value="<?php echo $customerName; ?>" />
                <label> Start Date : </label>
                <input type="date" id="post-search-input" name="start-date" placeholder="Start Date" value="" />

                <label>End Date: </label>
                <input type="date" id="post-search-input" name="end-date" placeholder="End Date" value="" />
                <input type="text" id="post-search-input" name="tray_number" placeholder="Tray Number" value="" />
                <select name="searchBy" id="cat" class="postform">
                    <option  value="1">AND</option>
                    <option  value="2">OR</option>
                </select>

                <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter" />	
            </p>
        </div>
        <br/> <br/>
        <!-- start pagination -->

        <?php
        if (function_exists('sb_pagination')) {
            if (isset($orders->orders)) {
                sb_pagination($orders->total, $orders->max_num_pages, $paged);
            }
        }
        ?>
        <!-- end pagination -->
    </form>

    <br class="clear">

    <table class="wp-list-table widefat  striped posts">
        <thead>
            <tr>

                <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                    <a href="javascript:;">
                        <span>Order#</span>
    <!--                            <span class="sorting-indicator"></span>-->
                    </a>
                </th>
                <th scope="col" id="author" class="manage-column column-author">Order Date</th>
                <th scope="col" id="categories" class="manage-column column-categories">Customer Name</th>
                <th scope="col" id="categories" class="manage-column column-categories">Email/Phone</th>
                <th scope="col" id="tags" class="manage-column column-tags">Order Total</th>
                <th scope="col" id="tags" class="manage-column column-tags">Order Items</th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php
            $dp = 2;
            if (isset($orders->orders)) {
                foreach ($orders->orders as $order_id) {
                    $order = wc_get_order($order_id);
                    $id = $order->get_id();
                    $order_number = $order->get_order_number();
                    $created_at = $order->get_date_created()->date('Y-m-d H:i:s');
                    $status = $order->get_status();
                    $total = wc_format_decimal($order->get_total(), $dp);
                    $total_discount = wc_format_decimal($order->get_total_discount(), $dp);
                    $email = $order->get_billing_email();
                    $phone = $order->get_billing_phone();
                    $first_name = $order->get_billing_first_name();
                    $last_name = $order->get_billing_last_name();
                    ?>
                    <tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">

                            <strong>
                                <a class="row-title" href="javascript:;" aria-label=""><?php echo $order_number; ?></a>
                            </strong>

                            <div class="hidden" id="inline_1">
                                <div class="post_title"><?php echo $order_number; ?></div><div class="post_name"><?php echo $order_number; ?></div>
                                <div class="post_author">1</div>
                                <div class="comment_status">open</div>
                                <div class="ping_status">open</div>
                                <div class="_status">publish</div>
                                <div class="jj">17</div>
                                <div class="mm">06</div>
                                <div class="aa">2020</div>
                                <div class="hh">08</div>
                                <div class="mn">00</div>
                                <div class="ss">47</div>
                                <div class="post_password"></div><div class="page_template">default</div><div class="post_category" id="category_1">1</div><div class="tags_input" id="post_tag_1"></div><div class="sticky"></div><div class="post_format"></div></div>
                            <div class="row-actions">
                                <span class="edit"><a href="javascript:;" aria-label="Edit �Hello world!�">Edit</a> | </span>
                                <span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit �Hello world!� inline" aria-expanded="false">Quick&nbsp;Edit</button> | </span>
                                <span class="trash"><a href="javascript:;" class="submitdelete" aria-label="Move �Hello world!� to the Trash">Trash</a> | </span>
                                <span class="view"><a href="javascript:;" rel="bookmark" aria-label="View �Hello world!�">View</a></span>
                            </div>
                            <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                        </td>
                        <td class="categories column-categories" data-colname="Categories">
                            <a href="javascript:;"><?php echo $created_at; ?></a>
                        </td>
                        <td class="author column-author" data-colname="Author">
                            <a href="javascript:;"><?php echo $first_name . ' ' . $last_name ?></a>
                        </td>
                        <td class="categories column-categories" data-colname="Categories">
                            <a href="javascript:;"><?php
                                echo $email;
                                echo '<br/>';
                                echo $phone;
                                ?></a>
                        </td>
                        <td class="categories column-categories" data-colname="Categories">
                            <a href="javascript:;"><?php echo $order->get_order_currency() . $total; ?></a>
                        </td>
                        <td class="categories column-categories" data-colname="Categories">
                            <table class="wp-list-table widefat  striped posts">
                                <thead>
                                    <tr>

                                        <th scope="col" id="author" class="manage-column column-author">Item Name</th>
                                        <th scope="col" id="categories" class="manage-column column-categories">Tray Number</th>
                                        <th scope="col" id="categories" class="manage-column column-categories">Tracking Code</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Status</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Communication</th>

                                        <th scope="col" id="tags" class="manage-column column-tags">Impression Received Date</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Impression Redo Tracking Code</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Ship Date</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Customer Billing</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Customer Shipping</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Shipment Address</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Refunds</th>
                                        <th scope="col" id="tags" class="manage-column column-tags">Print Label</th>

                                    </tr>
                                </thead>
                                <tbody id="the-list">
                                    <?php
                                    foreach ($order->get_items() as $item_id => $item) {
                                        $table_name = $wpdb->prefix . 'sb_orders';
                                        $product_id = $item->get_product_id();
                                        $ticket_id = false;
                                        $tray_number_flag = FALSE;
                                        $tray_number = '';
                                        $query = $wpdb->get_results("SELECT * FROM  $table_name WHERE order_id = $order_number and item_id = $product_id");



                                        $order_key = FALSE;
                                        if (count($query) > 0) {

                                            if (isset($query[0]->ticket_id)) {
                                                $order_key = $query[0]->id;
                                                $ticket_id = $query[0]->ticket_id;
                                            }
                                            $tray_number = $query[0]->tray_number;
                                            $tray_number_flag = true;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $item->get_name(); ?>
                                            </td>
                                            <td>
                                                <?php if ($tray_number_flag): ?>
                                                    <p class="search-box tray_number_container" data-item="<?php echo $item_id; ?>" style="display: flex;">
                                                        <input type="text" id="tray_number_<?php echo $item_id; ?>" class="tray_number-input" name="tray_number" placeholder="Tray Number" value="<?php echo $tray_number; ?>">
                                                        <input type="hidden" class="order_key"  value="<?php echo $order_key; ?>">
                                                        <button class="btn_tray_number" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>
                                                    </p>
                                                    <?php
                                                else:
                                                    echo 'n/a';
                                                endif;
                                                ?>
                                            </td>
                                            <td>
                                                <p class="search-box" style="display: flex;">
                                                    <input type="text" id="post-search-input" name="s" placeholder="Tracking Code" value="">
                                                    <button><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="search-box" style="display: flex;">
                                                    <select name="cat" id="cat" class="postform">
                                                        <option value="0">Order Status</option>
                                                        <option class="level-0" value="1">Waiting for impressions</option>
                                                    </select>
                                                    <input type="button" id="search-submit" class="button" value="Save">
                                                </p>
                                            </td>
                                            <td>
                                                <?php
                                                if ($ticket_id) {

                                                    $ajax_url = add_query_arg(
                                                            array(
                                                        'action' => 'ticketChatByOrderItem',
                                                        'ticket_id' => $ticket_id,
                                                        'order_id' => $order_number,
                                                        'user_id' => $order->get_customer_id(),
                                                        'width' => 1000,
                                                        'height' => 600,
                                                            ), admin_url('admin-ajax.php')
                                                    );
                                                    ?>
                                                    <input custom-url = "<?php echo $ajax_url; ?>" type="button" id="openChat" class="button openChat" value="Open Chat">
                                                    <?php
                                                } else {
                                                    echo 'n/a';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                n/a
                                            </td>
                                            <td>
                                                n/a
                                            </td>
                                            <td>
                                                n/a
                                            </td>
                                            <td>
                                                <?php echo $order->get_formatted_billing_address(); ?>
                                                <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                            </td>
                                            <td>
                                                <?php
                                                if ($order->get_formatted_shipping_address()) {
                                                    echo $order->get_formatted_shipping_address();
                                                } else {
                                                    echo $order->get_formatted_billing_address();
                                                }
                                                ?>
                                                <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                            </td>
                                            <td>
                                                <?php
                                                if ($order->get_formatted_shipping_address()) {
                                                    echo $order->get_formatted_shipping_address();
                                                } else {
                                                    echo $order->get_formatted_billing_address();
                                                }
                                                ?>

                                                <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                            </td>
                                            <td>
                                                <input type="button" name="filter_action" id="post-query-submit" class="button" value="Refunds">
                                            </td>
                                            <td>
                                                <input type="button" name="filter_action" id="post-query-submit" class="button" value="Print Label">
                                            </td>

                                        </tr>




                                        <?php
                                        //  item_id;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="13">
                                            <?php
                                            $ajax_url = add_query_arg(
                                                    array(
                                                'action' => 'create_addon_order',
                                                'order_id' => $order_number,
                                                'user_id' => $order->get_customer_id(),
                                                'width' => 1000,
                                                'height' => 600,
                                                    ), admin_url('admin-ajax.php')
                                            );
                                            ?>
                                            <input custom-url="<?php echo $ajax_url; ?>" type="button" name="filter_action" id="post-query-submit" class="button addon_order" value="Add-on">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
            } else {


                $id = $order->get_id();
                $order_number = $order->get_order_number();
                $created_at = $order->get_date_created()->date('Y-m-d H:i:s');
                $status = $order->get_status();
                $total = wc_format_decimal($order->get_total(), $dp);
                $total_discount = wc_format_decimal($order->get_total_discount(), $dp);
                $email = $order->get_billing_email();
                $phone = $order->get_billing_phone();
                $first_name = $order->get_billing_first_name();
                $last_name = $order->get_billing_last_name();
                ?>
                <tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                    <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">

                        <strong>
                            <a class="row-title" href="javascript:;" aria-label=""><?php echo $order_number; ?></a>
                        </strong>

                        <div class="hidden" id="inline_1">
                            <div class="post_title"><?php echo $order_number; ?></div><div class="post_name"><?php echo $order_number; ?></div>
                            <div class="post_author">1</div>
                            <div class="comment_status">open</div>
                            <div class="ping_status">open</div>
                            <div class="_status">publish</div>
                            <div class="jj">17</div>
                            <div class="mm">06</div>
                            <div class="aa">2020</div>
                            <div class="hh">08</div>
                            <div class="mn">00</div>
                            <div class="ss">47</div>
                            <div class="post_password"></div><div class="page_template">default</div><div class="post_category" id="category_1">1</div><div class="tags_input" id="post_tag_1"></div><div class="sticky"></div><div class="post_format"></div></div>
                        <div class="row-actions">
                            <span class="edit"><a href="javascript:;" aria-label="Edit �Hello world!�">Edit</a> | </span>
                            <span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit �Hello world!� inline" aria-expanded="false">Quick&nbsp;Edit</button> | </span>
                            <span class="trash"><a href="javascript:;" class="submitdelete" aria-label="Move �Hello world!� to the Trash">Trash</a> | </span>
                            <span class="view"><a href="javascript:;" rel="bookmark" aria-label="View �Hello world!�">View</a></span>
                        </div>
                        <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                    </td>
                    <td class="categories column-categories" data-colname="Categories">
                        <a href="javascript:;"><?php echo $created_at; ?></a>
                    </td>
                    <td class="author column-author" data-colname="Author">
                        <a href="javascript:;"><?php echo $first_name . ' ' . $last_name ?></a>
                    </td>
                    <td class="categories column-categories" data-colname="Categories">
                        <a href="javascript:;"><?php
                            echo $email;
                            echo '<br/>';
                            echo $phone;
                            ?></a>
                    </td>
                    <td class="categories column-categories" data-colname="Categories">
                        <a href="javascript:;"><?php echo $order->get_order_currency() . $total; ?></a>
                    </td>
                    <td class="categories column-categories" data-colname="Categories">
                        <table class="wp-list-table widefat  striped posts">
                            <thead>
                                <tr>

                                    <th scope="col" id="author" class="manage-column column-author">Item Name</th>
                                    <th scope="col" id="categories" class="manage-column column-categories">Tray Number</th>
                                    <th scope="col" id="categories" class="manage-column column-categories">Tracking Code</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Status</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Communication</th>

                                    <th scope="col" id="tags" class="manage-column column-tags">Impression Received Date</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Impression Redo Tracking Code</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Ship Date</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Customer Billing</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Customer Shipping</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Shipment Address</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Refunds</th>
                                    <th scope="col" id="tags" class="manage-column column-tags">Print Label</th>

                                </tr>
                            </thead>
                            <tbody id="the-list">
                                <?php
                                foreach ($order->get_items() as $item_id => $item) {

                                    $product_id = $item->get_product_id();
                                    $ticket_id = false;
                                    $tray_number_flag = FALSE;
                                    $tray_number = '';
                                    $query = $wpdb->get_results("SELECT * FROM  wp_sb_orders WHERE order_id = $order_number AND item_id = $product_id");

                                    $order_key = FALSE;
                                    if (count($query) > 0) {

                                        if (isset($query[0]->ticket_id)) {
                                            $order_key = $query[0]->id;
                                            $ticket_id = $query[0]->ticket_id;
                                        }
                                        $tray_number = $query[0]->tray_number;
                                        $tray_number_flag = true;
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $item->get_name(); ?>
                                        </td>
                                        <td>
                                            <?php if ($tray_number_flag): ?>
                                                <p class="search-box tray_number_container" data-item="<?php echo $item_id; ?>" style="display: flex;">
                                                    <input type="text" id="tray_number_<?php echo $item_id; ?>" class="tray_number-input" name="tray_number" placeholder="Tray Number" value="<?php echo $tray_number; ?>">
                                                    <input type="hidden" class="order_key"  value="<?php echo $order_key; ?>">
                                                    <button class="btn_tray_number" type="button"><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>
                                                </p>
                                                <?php
                                            else:
                                                echo 'n/a';
                                            endif;
                                            ?>
                                        </td>
                                        <td>
                                            <p class="search-box" style="display: flex;">
                                                <input type="text" id="post-search-input" name="s" placeholder="Tracking Code" value="">
                                                <button><span class="spinner is-active hidden-class"></span><span style="display: block;">Save</span></button>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="search-box" style="display: flex;">
                                                <select name="cat" id="cat" class="postform">
                                                    <option value="0">Order Status</option>
                                                    <option class="level-0" value="1">Waiting for impressions</option>
                                                </select>
                                                <input type="button" id="search-submit" class="button" value="Save">
                                            </p>
                                        </td>
                                        <td>
                                            <?php
                                            if ($ticket_id) {

                                                $ajax_url = add_query_arg(
                                                        array(
                                                    'action' => 'ticketChatByOrderItem',
                                                    'ticket_id' => $ticket_id,
                                                    'order_id' => $order_number,
                                                    'user_id' => $order->get_customer_id(),
                                                    'width' => 1000,
                                                    'height' => 600,
                                                        ), admin_url('admin-ajax.php')
                                                );
                                                ?>
                                                <input custom-url = "<?php echo $ajax_url; ?>" type="button" id="openChat" class="button openChat" value="Open Chat">
                                                <?php
                                            } else {
                                                echo 'n/a';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            n/a
                                        </td>
                                        <td>
                                            n/a
                                        </td>
                                        <td>
                                            n/a
                                        </td>
                                        <td>
                                            <?php echo $order->get_formatted_billing_address(); ?>
                                            <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                        </td>
                                        <td>
                                            <?php
                                            if ($order->get_formatted_shipping_address()) {
                                                echo $order->get_formatted_shipping_address();
                                            } else {
                                                echo $order->get_formatted_billing_address();
                                            }
                                            ?>
                                            <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                        </td>
                                        <td>
                                            <?php
                                            if ($order->get_formatted_shipping_address()) {
                                                echo $order->get_formatted_shipping_address();
                                            } else {
                                                echo $order->get_formatted_billing_address();
                                            }
                                            ?>

                                            <input type="button" name="filter_action" id="post-query-submit" class="button" value="Edit">
                                        </td>
                                        <td>
                                            <input type="button" name="filter_action" id="post-query-submit" class="button" value="Refunds">
                                        </td>
                                        <td>
                                            <input type="button" name="filter_action" id="post-query-submit" class="button" value="Print Label">
                                        </td>

                                    </tr>




                                    <?php
                                    //  item_id;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="13">
                                        <input type="button" name="filter_action" id="post-query-submit" class="button" value="Add-on">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
                <?php
            }
            ?>



        </tbody>


    </table>
    <script>
        jQuery('body').on('click', '.btn_tray_number', function () {

            var get_parent = jQuery(this).parent('.tray_number_container');
            var spinner = get_parent.find('.btn_tray_number .spinner');
            spinner.removeClass('hidden-class');
            var tray_number = get_parent.find('.tray_number-input').val();
            if (tray_number) {

                //Sending data
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        order_key: get_parent.find('.order_key').val(),
                        action: 'update_tray_number',
                        tray_number: tray_number
                    },
                    method: 'POST',
                    success: function (response) {
                        console.log(response);
                        spinner.addClass('hidden-class');
                    },
                    // cache: false,
                    //    contentType: false,
                    //  processData: false
                });
            } else {
            }

        });
        jQuery('body').on('click', '.addon_order', function () {

            var get_ajax_url = jQuery(this).attr('custom-url');
            tb_show('Create Order', get_ajax_url);
        });
        jQuery('body').on('click', '.openChat', function () {

            var get_ajax_url = jQuery(this).attr('custom-url');
            tb_show('Zendesk Ticket Chat', get_ajax_url);
        });
        

    </script>

    <style>
        table {
            display: table;
        }
        tr {
            display: table-row;
        }
        td {
            display: table-cell;
        }
        .hidden-class{
            display: none;
        }
        .tablenav-pages{
            float: right;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        span.pagination-links a {
            margin: 2px;
        }
    </style>

    <?php
}

add_action('wp_ajax_create_addon_order', 'create_addon_order_callback');

function create_addon_order_callback() {

    $user_id = $_REQUEST['user_id'];
    $order_id = $_REQUEST['order_id'];

    $args = array(
        'customer_id' => $user_id,
        // The other options
        //'status'        => null,
        //'customer_note' => null,
        'parent' => $order_id,
            //'created_via'   => null,
            //'cart_hash'     => null,
            //'order_id'      => 0,
    );

    // Create the order and assign it to the current user
    $new_order = wc_create_order($args);
    echo '<pre>';
    print_r($new_order);
    echo '</pre>';
    die;
}

//register_activation_hook(__FILE__, 'on_activate');
///on_activate();

function on_activate() {

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'sb_orders';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id int(11) NOT NULL AUTO_INCREMENT ,
                order_id int(11) DEFAULT NULL,
                user_id int(11) NOT NULL,
                order_created datetime DEFAULT NULL,
                item_name varchar(255) DEFAULT NULL,
                item_id int(11) DEFAULT NULL,
                tray_number varchar(255) DEFAULT NULL,
                tracking_number varchar(255) DEFAULT NULL,
                ticket_id varchar(255) DEFAULT NULL,
                impression_redo_tracking varchar(255) DEFAULT NULL,
                shipping_address text DEFAULT NULL,
                shipping_date datetime DEFAULT NULL,
                status int(11) NOT NULL,
                impression_received_date datetime DEFAULT NULL,
                customer_name varchar(255) DEFAULT NULL,
              PRIMARY KEY  (id)
) $charset_collate;";


    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

function sb_pagination($total = 0, $pages = '', $paged = 1) {


    if (1 != $pages) {
        echo '<div class="tablenav-pages">';
        echo '<span class="displaying-num">' . $total . ' items</span>';
        echo '<span class="pagination-links">';
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
            echo "<a href='" . get_pagenum_link(1) . "'><span class='tablenav-pages-navspan button'>&laquo;</span></a>";
        }
        if ($paged > 1 && $showitems < $pages) {
            echo "<a href='" . get_pagenum_link($paged - 1) . "'><span class='tablenav-pages-navspan button'>&lsaquo;</span></a>";
        }

        echo '<span class="paging-input">';
        //echo '<label for="current-page-selector" class="screen-reader-text">Current Page</label>';
        //echo '<input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging">';
        echo '<span class="tablenav-paging-text"> of <span class="total-pages">' . $paged . '</span></span>';
        echo '</span>';

        if ($paged < $pages && $showitems < $pages) {
            echo "<a href=\"" . get_pagenum_link($paged + 1) . "\"><span class='tablenav-pages-navspan button'>&rsaquo;</span></a>";
        }
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
            echo "<a href='" . get_pagenum_link($pages) . "'><span class='tablenav-pages-navspan button'>&raquo;</span></a>";
        }
        echo '</span>';
        echo '</div>';
    }
}
