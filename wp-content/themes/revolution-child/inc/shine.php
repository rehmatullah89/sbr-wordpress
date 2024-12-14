<?
/*
Shine Reports
*/
add_filter('woocommerce_add_cart_item_data', 'disable_coupons_for_shine_users', 10, 2);

function disable_coupons_for_shine_users($cart_item_data, $product_id) {
    if (isset($_POST['disable_coupon'])) {
        $cart_item_data['disable_coupon_shine'] = sanitize_text_field($_POST['disable_coupon']);
    }
    return $cart_item_data;
}


add_filter('woocommerce_coupon_is_valid', 'disable_coupon_for_specific_products', 10, 3);

function disable_coupon_for_specific_products($valid, $coupon, $discount) {
    foreach (WC()->cart->get_cart() as $cart_item) {
        if (isset($cart_item['disable_coupon_shine']) && $cart_item['disable_coupon_shine'] == 'yes') {
            // Coupon should not be applied to this cart item
            return false;
        }
    }
    return $valid;
}

add_action('wp_login', 'check_shine_user_meta_and_set_cookie', 10, 2);

function check_shine_user_meta_and_set_cookie($user_login, $user) {
    $is_shine_user = get_user_meta($user->ID, 'is_shine_user', true);
    if ($is_shine_user == '1') {
        setcookie('shine_user', $user->ID, time() + (3600 * 24 * 360), '/');
    } if ($is_shine_user == '0') {
        if (isset($_COOKIE['shine_user'])) {
            setcookie('shine_user', '', time() - 3600, '/'); // Expire the cookie by setting it to a past time
        }
    } 
}

/*
Admin Reports
*/
function gais_reports_page()
{
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d', strtotime('-30 days'));
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');

    echo '<div class="wrap">';
    echo '<h1>GAIS Reports</h1>';
    
    // Filter form
    echo '<form method="post">';
    echo '<label for="start_date">Start Date:</label>';
    echo '<input type="date" id="start_date" name="start_date" value="' . esc_attr($start_date) . '">&nbsp;';
    echo '<label for="end_date">End Date:</label>';
    echo '<input type="date" id="end_date" name="end_date" value="' . esc_attr($end_date) . '">&nbsp;';
    echo '<input type="submit" value="Filter">';
    echo '</form>';
    
    $orders = get_shine_report_orders($start_date, $end_date, 0);
    $logs = @$orders['logs'];
    $counts = @$orders['counts'];    
    $results = @$orders['results'];

    if(!empty($counts)){
    ?>
<style>
/* Accordion Styling */
.accordion {
    border: 1px solid #b6d7a8;
    border-radius: 5px;
    overflow: hidden;
}

.accordion-item {
    border-bottom: 1px solid #b6d7a8;
}

.accordion-header {
    background-color: #d9ead3;
    padding: 10px;
    cursor: pointer;
}

.accordion-header h3 {
    margin: 0;
    font-size: 16px;
    color: #4a7c59;
}

.accordion-content {
    max-height: 0;
    width: 100%;
    overflow: hidden;
    transition: ease-out;
    background-color: #f6f9f2;
}

.accordion-item.active .accordion-content {
    max-height: 500px; /* Adjust as needed */
}

/* CSV Table Styling */
.csv-table {
    width: 100%;
    border-collapse: collapse;
}

.csv-table th, .csv-table td {
    border: 1px solid #b6d7a8;
    padding: 10px;
    text-align: left;
    background-color: #e2efd9;
    color: #000;
}

.csv-table th {
    background-color: #a8d08d;
    font-weight: bold;
}

.csv-table tbody tr:nth-child(even) {
    background-color: #d9ead3;
}

.csv-table tbody tr:nth-child(odd) {
    background-color: #f6f9f2;
}
.accordion-item.active .accordion-content {
    overflow: auto;
}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script>
function toggleAccordion(element) {
    var item = element.parentElement;
    item.classList.toggle("active");
}
</script>

<div class="accordion" style="margin-top:5px;">    
<?php
$counter = 0;
foreach($counts as $countObj){
?>
<div id="id<?php echo $counter;?>" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id<?php echo $counter;?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <p><?php echo @$logs[$countObj->date];?></p>
      </div>
    </div>
</div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3><?php echo $countObj->date." (".$countObj->total.")"?><span style="float: right; margin-right: 20px;">
            <button onclick="document.getElementById('id<?php echo $counter++;?>').style.display='block'" class="button">View Logs</button></span></h3>
        </div>
        <div class="accordion-content">
            <table class="csv-table">
                <thead>
                    <tr>
                        <th>Group No</th>
                        <th>Unique Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
<?php 
                 foreach($results as $result){
                    $created_date = date("Y-m-d", strtotime($result->created_date));
                       if($countObj->date == $created_date)
                       {
?>
                    <tr>
                        <td><?php echo $result->group_number;?></td>
                        <td><?php echo $result->unique_id_no;?></td>
                        <td><?php echo $result->first_name." ".$result->last_name;?></td>
                        <td><?php echo $result->email;?></td>
                        <td><?php echo $result->phone;?></td>
                        <td><?php echo $result->address1.", ".$result->city.", ".$result->state.", ".$result->postal_code.", ".$result->country_code;?></td>
                        <td><?php echo ucfirst($result->gais_report_type);?></td>
                    </tr>
<?php               }
                }
?>
                </tbody>
            </table>
        </div>
    </div>
<?php 
}
?>
    <!-- Repeat accordion-item for more sheets -->
</div>
        <?php
       
    }else{
        echo "<div style='margin-top: 10px;'>No, GAIS Reports record found!</div>";
    }
}

function shine_reports_page() 
{
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d', strtotime('-30 days'));
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
    $report_type = isset($_POST['subscription_reports']) ? $_POST['subscription_reports'] : SHINE_COMPLETE_PRODUCT_ID;

    echo '<div class="wrap">';
    echo '<h1>Subscription Reports</h1>';
    
    // Filter form
    echo '<form method="post">';
    echo '<label for="subscription_reports">Select Report:</label>&nbsp;';
    echo '<select  name="subscription_reports">';
    echo '<optgroup label="Shine Reports">';
    echo '<option value="'.SHINE_COMPLETE_PRODUCT_ID.'" '.($report_type == SHINE_COMPLETE_PRODUCT_ID ?'selected':'').'>Shine Complete</option>';
    echo '<option value="'.SHINE_DENTAL_PRODUCT_ID.'" '.($report_type == SHINE_DENTAL_PRODUCT_ID ?'selected':'').'>Shine Dental</option>';
    echo '<option value="'.SHINE_PERK_PRODUCT_ID.'" '.($report_type == SHINE_PERK_PRODUCT_ID ?'selected':'').'>Shine Perk</option>';
    echo '</optgroup>';
    echo '<optgroup label="Probiotics Reports">';
    echo '<option value="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" '.($report_type == PROBIOTIC_1BOTTLE_PRODUCT_ID ?'selected':'').' on-sale="0">1 bottles (30 chewable tablets)</option>';
    echo '<option value="'.PROBIOTIC_2BOTTLE_PRODUCT_ID.'" '.($report_type == PROBIOTIC_2BOTTLE_PRODUCT_ID ?'selected':'').' on-sale="0">2 bottles (60 chewable tablets)</option>';
    echo '<option value="'.PROBIOTIC_3BOTTLE_PRODUCT_ID.'" '.($report_type == PROBIOTIC_3BOTTLE_PRODUCT_ID ?'selected':'').' on-sale="0">3 bottles (90 chewable tablets)</option>';
    echo '</optgroup>';
    echo '<optgroup label="Enamel Armour Reports">';
    echo '<option value="'.ENAMELARMOUR_1TUBE_PRODUCT_ID.'" '.($report_type == ENAMELARMOUR_1TUBE_PRODUCT_ID ?'selected':'').' on-sale="0">1 tube (30 applies)</option>';
    echo '<option value="'.ENAMELARMOUR_2TUBE_PRODUCT_ID.'" '.($report_type == ENAMELARMOUR_2TUBE_PRODUCT_ID ?'selected':'').' on-sale="0">2 tubes (60 applies)</option>';
    echo '<option value="'.ENAMELARMOUR_3TUBE_PRODUCT_ID.'" '.($report_type == ENAMELARMOUR_3TUBE_PRODUCT_ID ?'selected':'').' on-sale="0">3 tubes (90 applies)</option>';
    echo '</optgroup>';
    echo '<optgroup label="PLaque Reports">';
    echo '<option value="'.PLAQUE_HIGHLIGHTER1_PRODUCT_ID.'" '.($report_type == PLAQUE_HIGHLIGHTER1_PRODUCT_ID ?'selected':'').' on-sale="0">1 Plaque Highlighter</option>';
    echo '<option value="'.PLAQUE_HIGHLIGHTER2_PRODUCT_ID.'" '.($report_type == PLAQUE_HIGHLIGHTER2_PRODUCT_ID ?'selected':'').' on-sale="0">2 Plaque Highlighters</option>';
    echo '<option value="'.PLAQUE_HIGHLIGHTER3_PRODUCT_ID.'" '.($report_type == PLAQUE_HIGHLIGHTER3_PRODUCT_ID ?'selected':'').' on-sale="0">3 Plaque Highlighters</option>';
    echo '</optgroup>';
    echo '</select>&nbsp;';
    echo '<label for="start_date">Start Date:</label>';
    echo '<input type="date" id="start_date" name="start_date" value="' . esc_attr($start_date) . '">&nbsp;';
    echo '<label for="end_date">End Date:</label>';
    echo '<input type="date" id="end_date" name="end_date" value="' . esc_attr($end_date) . '">&nbsp;';
    echo '<input type="submit" value="Filter">';
    echo '</form>';
    
    $orders = get_shine_report_orders($start_date, $end_date, $report_type);
    if(is_numeric($report_type) && $report_type > 0)
    {
        $subsc_details = get_shine_order_subscription_details($start_date, $end_date, $report_type);
        echo '<table class="wp-list-table widefat fixed striped" id="MYTABLE">';
        echo '<thead><tr>';
        echo '<th>SBR Number</th><th>Package Name</th><th>Customer Name</th><th>Order Date</th><th>Order Status</th><th>Next Payment</th>';
        echo '</tr></thead>';
        echo '<tbody>';

        if ($orders) {
            foreach ($orders as $order) {
                $order = new WC_Order($order);
                $order_id = $order->get_id();
                $order_date = $order->get_date_created()->date('m-d-Y');
                $order_status = $order->get_status();
                $next_payment = @$subsc_details[$order_id]['next_order_date']; // Custom field
                $package_name = get_package_name($order); // Get package name
                $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                
                echo '<tr>';
                echo '<td>' . get_post_meta($order_id,'order_number',true) .'</td>';
                echo '<td>' . $package_name . '</td>';
                echo '<td>' . $customer_name . '</td>';
                echo '<td>' . $order_date . '</td>';
                echo '<td>' . $order_status . '</td>';
                echo '<td>' . $next_payment . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No orders found for the selected date range.</td></tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    var rowCount = document.querySelectorAll('#MYTABLE tbody tr').length;
    console.log("length:", rowCount);
    if (rowCount > 1) {
        new DataTable('#MYTABLE', {
            layout: {
                bottomEnd: {
                    paging: {
                        firstLast: false
                    }
                }
            },
            "lengthChange": false
        });
    }
</script>
<?php
    }
}


function get_shine_order_subscription_details($start_date, $end_date, $report_type)
{
    global $wpdb;    
    $results = $wpdb->get_results(
        $wpdb->prepare("
            SELECT * 
            FROM sbr_subscription_details 
            WHERE DATE(created_at) BETWEEN %s AND %s
        ", $start_date, $end_date),
        ARRAY_A
    );

    $key_value_pairs = array();
    foreach ($results as $row) {
        $key_value_pairs[$row['order_id']] = $row;
    }

    return $key_value_pairs;
}

function get_shine_report_orders($start_date, $end_date, $report_type) {
    global $wpdb;
 
    $orders = [];
    if(is_numeric($report_type) && $report_type > 0){
        $query = $wpdb->prepare(
            "SELECT DISTINCT p.ID
            FROM {$wpdb->prefix}posts p
            INNER JOIN {$wpdb->prefix}woocommerce_order_items oi ON p.ID = oi.order_id
            INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
            WHERE p.post_type = 'shop_order'
            AND p.post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-failed')
            AND DATE(p.post_date) BETWEEN %s AND %s
            AND oim.meta_key = '_product_id'
            AND oim.meta_value = %d",
            $start_date,
            $end_date,
            $report_type
        );
        $orders = $wpdb->get_col($query);
    }
    else
    {
        $query = $wpdb->prepare(
            "SELECT DATE(created_at) as `date`, logs FROM gais_logs WHERE DATE(created_at) BETWEEN %s AND %s AND DATEDIFF(%s, %s) <= 31 GROUP BY DATE(created_at)",
            $start_date, $end_date, $end_date, $start_date
        );
        $logs = $wpdb->get_results($query);

        $query = $wpdb->prepare(
            "SELECT DATE(created_date) as `date`, COUNT(*) as total FROM gais_uploads WHERE DATE(created_date) BETWEEN %s AND %s AND DATEDIFF(%s, %s) <= 31 GROUP BY DATE(created_date)",
            $start_date, $end_date, $end_date, $start_date
        );
        $counts = $wpdb->get_results($query);

        $query = $wpdb->prepare(
            "SELECT * FROM gais_uploads WHERE DATE(created_date) BETWEEN %s AND %s AND DATEDIFF(%s, %s) <= 31",
            $start_date, $end_date, $end_date, $start_date
        );
        $results = $wpdb->get_results($query);

        $logs_list = [];
        foreach($logs as $log){
            $logs_list[$log->date] = $log->logs;
        }

        $orders = ['counts'=>$counts, 'results'=>$results, 'logs'=>$logs_list];
    }
  
    return $orders;
}


function gais_reports_menu() {
    add_menu_page(
        'GAIS Reports',
        'GAIS Reports',
        'manage_options',
        'gais-reports',
        'gais_reports_page',
        'dashicons-chart-line',
        6
    );
    // Hide the menu item
    remove_menu_page('gais-reports');
}
add_action('admin_menu', 'gais_reports_menu');

function shine_reports_menu() {
    add_menu_page(
        'Shine Reports',
        'Shine Reports',
        'manage_options',
        'shine-reports',
        'shine_reports_page',
        'dashicons-chart-line',
        6
    );
    // Hide the menu item
    remove_menu_page('shine-reports');
}
add_action('admin_menu', 'shine_reports_menu');

function get_package_name($order) {
    $items = $order->get_items();
    $package_names = [];

    foreach ($items as $item) {
        $product = $item->get_product();
        $product_id = $item->get_product_id();
           
        $product_title = $product->get_name();
        $shine_members = $item->get_meta('_shine_members');
        $arbid = $item->get_meta('_arbid');

        $interval = 0;
        if(in_array( $product_id, SHINE_REPORT_PRODUCT_IDS))
        {
            $rows = get_field('define_shine_membership_plans', $product_id);
            foreach ($rows as $index => $data) {
                if ($index == $arbid) {
                    if(is_array($data['billingshipping_frequency'])){
                        $interval = $data['billingshipping_frequency']['value'] < 7 ? 30 : $data['billingshipping_frequency']['value'];
                    }else{
                        $interval = $data['billingshipping_frequency'] < 7 ? 30 : $data['billingshipping_frequency'];
                    }
                }
            }
        }
        $package_name = $product_title;
        if (!empty($shine_members)) {
            $package_name .= ' - ' . $shine_members;
        }
        if (!empty($interval)) {
            $package_name .= ' - ' . $interval.' days';
        }

        $package_names[] = $package_name;
    }

    return implode(', ', $package_names);
}

/**
 * Check if only the Shine product IDs are in the cart.
 *
 * @param array $product_ids Array of product IDs to check for.
 * @return bool True if only the specified product IDs are in the cart, false otherwise.
 */


function is_only_shine_package_products_in_cart($cart_items, $shine_report_product_ids = SHINE_REPORT_PRODUCT_IDS, $shipping_protection_product = SHIPPING_PROTECTION_PRODUCT) {
    // Create an array to store the product IDs from the cart
    
    $cart_product_ids = array();

    // Loop through each cart item
    foreach ($cart_items as $cart_item) {
        // Get the product ID of the cart item
        $cart_product_id = $cart_item['product_id'];
        if(in_array($cart_product_id, SHINE_REPORT_PRODUCT_IDS)){
            return true;
        }
        // Add the product ID to the array
        $cart_product_ids[] = $cart_product_id;
    }

    // Remove duplicates from the cart product IDs and sort arrays
    $cart_product_ids = array_unique($cart_product_ids);
    if (count($cart_product_ids) === 1 && in_array($shipping_protection_product, $cart_product_ids)) {
        return false; // Immediately return false if only the shipping protection product is in the cart
    }
    sort($cart_product_ids);

    // Create an array of valid product IDs
    $valid_product_ids = array_unique($shine_report_product_ids);

    // If the shipping protection product is in the cart, it should be allowed
    if (in_array($shipping_protection_product, $cart_product_ids)) {
        $valid_product_ids[] = $shipping_protection_product;
    }

    // Remove duplicates and sort the valid product IDs array
    $valid_product_ids = array_unique($valid_product_ids);
    sort($valid_product_ids);

    // Check if all cart product IDs are in the valid product IDs array
    $valid = empty(array_diff($cart_product_ids, $valid_product_ids));

    // Debugging: Print arrays for verification
    
    return $valid;
}

add_action('init','check_my_code');
function check_my_code(){
   // cancel_existing_shine_memberships(918538,197905);
}

function cancel_existing_shine_memberships($order_id,$user_id)
{
    global $wpdb;

    // Define the customer ID and excluded order ID
    $customer_id = $user_id;
    $excluded_order_id = $order_id;

    // Execute the SQL query to get order IDs
    $order_ids = $wpdb->get_col($wpdb->prepare("
        SELECT DISTINCT wp_posts.ID
        FROM {$wpdb->posts} wp_posts
        INNER JOIN {$wpdb->prefix}woocommerce_order_items wp_woocommerce_order_items ON wp_posts.ID = wp_woocommerce_order_items.order_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id
        INNER JOIN {$wpdb->postmeta} customer_meta ON wp_posts.ID = customer_meta.post_id
        WHERE wp_posts.post_type = 'shop_order'
        AND wp_woocommerce_order_itemmeta.meta_key = '_shine'
        AND wp_woocommerce_order_itemmeta.meta_value = '1'
        AND customer_meta.meta_key = '_customer_user'
        AND customer_meta.meta_value = %s
        AND wp_posts.ID NOT IN (%d)
        GROUP BY wp_posts.ID
        ORDER BY wp_posts.post_date DESC
        LIMIT 0, 10
    ", $customer_id, $excluded_order_id));

    // Check if any orders were found
    if (!empty($order_ids)) {
        $counter_subc = 1;
        foreach ($order_ids as $order_id) {
            if($counter_subc>10 || count($order_ids)>20){
                break;
            }
            //  echo $order_id.'<br />';
            unsubscribe_shine_orders($order_id,'','cancelled');
            $order = wc_get_order($order_id);
        //$order->update_status('cancelled', 'Order cancelled Creation of new membership.');
            update_post_meta($order_id,'mbt_status','updated');
            $counter_subc ++;
        }
    }
}

function unsubscribe_shine_orders($order_id, $old_status, $new_status)
{
    global $wpdb;
    if(in_array($new_status, ['cancelled', 'failed', 'refunded', 'trash'])){
        $subscriptionInfo = $wpdb->get_results("SELECT * FROM sbr_subscription_details  WHERE status=1 AND (shine_group_code <> 0 OR product_id = ".SHINE_PERK_PRODUCT_ID.") AND order_id = ".$order_id );    
        if (!empty($subscriptionInfo)) {
            foreach($subscriptionInfo as $subscription){
                $refId = $subscription->item_id;
                $sub_id = $subscription->subscription_id;

                $data = '{
                    "ARBCancelSubscriptionRequest": {
                    "merchantAuthentication": {
                        "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                            "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                    },
                    "refId": "' . $refId . '",
                    "subscriptionId": "' . $sub_id . '",
                    }
                }';

                $curl = curl_init();    
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $data,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    )
                );
                $str = curl_exec($curl);
                curl_close($curl);
                for ($i = 0; $i <= 31; ++$i) {
                    $response = str_replace(chr($i), "", $str);
                }
                $response = str_replace(chr(127), "", $str);
                if (0 === strpos(bin2hex($response), 'efbbbf')) {
                    $response = substr($response, 3);
                }
                $responseAPI = json_decode($response, true);

                if ($responseAPI) {
                    $wpdb->update(
                        'sbr_subscription_details',
                        array('status' => 0),
                        array('subscription_id' => $sub_id, 'item_id' => $refId)
                    );
                    $wpdb->insert('sbr_suspended_subscriptions', array(
                        'user_id' => $subscription->user_id,
                        'subscription_id' => $sub_id,
                        'parent_order_id' => $order_id,
                        'item_id' => $refId,
                        'quantity' => $subscription->quantity,
                        'title' => $subscription->interval_days.' days',
                        'amount' => $subscription->total_price,
                        'status' => 'cancelled',
                        'authorize_response' => ((string)$responseAPI)
                    ));                 
                }
            }
        }
    }
}


//add_filter('woocommerce_add_to_cart_validation', 'wp_kama_woocommerce_add_to_cart_validation_filter_mbt', 10, 3);

function wp_kama_woocommerce_add_to_cart_validation_filter_mbt($passed, $product_id, $quantity) {
    // print_r(SHINE_REPORT_PRODUCT_IDS);
    // die();
    // Array of product IDs that should be restricted
    $restricted_product_ids =SHINE_REPORT_PRODUCT_IDS; // Replace with your actual product IDs
    
    // Check if the product being added is one of the restricted products
    if (in_array($product_id, $restricted_product_ids)) {
        // Check if the quantity is greater than 1
        if ($quantity > 1) {
            wc_add_notice(__('You can only purchase one quantity of this product.', 'smilebrilliant'), 'error');
            return false; // Prevent adding to cart
        }
    }

    $cart_items = WC()->cart->get_cart();

    // Count restricted products in the cart
    $restricted_products_count = 0;

    foreach ($cart_items as $cart_item) {
        if (in_array($cart_item['product_id'], $restricted_product_ids)) {
            $restricted_products_count += $cart_item['quantity'];
        }
        if (in_array($cart_item['product_id'], $restricted_product_ids) && in_array($product_id, $restricted_product_ids)) {
            wc_add_notice(__('You cannot purchase more than one subscription products in a single order.', 'smilebrilliant'), 'error');
          //  wp_redirect( home_url().'/shine'); exit;
            return false;
        }
    }

    // If more than one restricted product is in the cart, prevent adding
    if ($restricted_products_count > 1) {
        wc_add_notice(__('You cannot purchase more than one subscription products in a single order.', 'smilebrilliant'), 'error');
        //wp_redirect( home_url().'/shine'); exit;
        return false;
        
    }
    return $passed; // Allow adding to cart
}

//add_action('woocommerce_check_cart_items', 'restrict_multiple_restricted_products_in_cart');
function restrict_multiple_restricted_products_in_cart() {
    // Array of product IDs that should be restricted
    $restricted_product_ids = SHINE_REPORT_PRODUCT_IDS; // Replace with your actual product IDs

    // Get cart items
    $cart_items = WC()->cart->get_cart();

    // Count restricted products in the cart
    $restricted_products_count = 0;

    foreach ($cart_items as $cart_item) {
        if (in_array($cart_item['product_id'], $restricted_product_ids)) {
            $restricted_products_count += $cart_item['quantity'];
        }
    }

    // If more than one restricted product is in the cart, prevent adding
    if ($restricted_products_count > 1) {
        wc_add_notice(__('You cannot purchase more than one subscription products in a single order.', 'smilebrilliant'), 'error');
        wc_get_cart_url();
    }
}


add_action( 'woocommerce_thankyou', 'set_order_status_completed_if_only_shine_report_products', 10, 1 );

function set_order_status_completed_if_only_shine_report_products( $order_id ) {
    if ( ! $order_id ) return;

    $order = wc_get_order( $order_id );
    $SHINE_REPORT_PRODUCT_IDS = SHINE_REPORT_PRODUCT_IDS; // Replace with your product IDs

    // Assume order is completed unless proven otherwise
    $complete_order = true;

    // Loop through each item in the order
    foreach ( $order->get_items() as $item_id => $item ) {
        $product_id = $item->get_product_id();

        // If any product is not in the allowed list, don't complete the order
        if ( ! in_array( $product_id, $SHINE_REPORT_PRODUCT_IDS ) ) {
            $complete_order = false;
            break;
        }
    }

    // Set the order status to completed if it contains only the allowed products
    if ( $complete_order ) {
        $order->update_status( 'completed' );
    }
}
function check_shine_report_products_only( $order ) {
    $allowed_product_ids = SHINE_REPORT_PRODUCT_IDS; // Your array of allowed product IDs.
    $items = $order->get_items();
    
    foreach ( $items as $item ) {
        $product_id = $item->get_product_id();
        
        if ( !in_array( $product_id, $allowed_product_ids ) ) {
            return false; // Return false if any product in the cart is not in the allowed list.
        }
    }
    
    return true; // All products are in the allowed list.
}


add_action( 'woocommerce_payment_complete', 'custom_woocommerce_payment_complete_sbr' );

function custom_woocommerce_payment_complete_sbr( $order_id ) {
    $order = wc_get_order( $order_id );

    if ( check_shine_report_products_only( $order ) ) {
        $order->update_status( 'completed' );
    }
}

add_action('woocommerce_order_item_meta_start', 'display_shine_members_meta', 10, 4);

function display_shine_members_meta($item_id, $item, $order, $plain_text) {
    // Get all meta data for the item
    $meta_data = $item->get_meta_data();
    
    // Loop through each meta data entry
    foreach ($meta_data as $meta) {
        // Check if the meta key is 'shine_members'
        if ($meta->key === '_shine_members' || $meta->key === '_arbid') {
            if($meta->key=='_arbid'){
              //  echo $item->get_product_id().'=>'.$meta->value;
                $meta_value = get_shine_order_item_frequency($item->get_product_id(),$meta->value);
            }
            else{
                $meta_value = $meta->value;  
            }
        //    echo $meta->key.''
            $meta_key = str_replace('_arbid', 'Interval', $meta->key);
            $meta_key = str_replace('_shine_members', 'Package', $meta_key); // Optional: Replace underscores with spaces
          //  $meta_key2 = str_replace('hine', 'Package',  $meta_key);
          

            // Display the meta key and value
            if ($plain_text) {
                // Output for plain text emails or similar
                echo esc_html( $meta_key) . ': ' . esc_html($meta_value) . "\n";
            } else {
                // Output for HTML content
                echo '<p><strong>' . esc_html( $meta_key) . ':</strong> ' . esc_html($meta_value) . '</p>';
            }
        }
    }
}

// Define the words you want to make bold

add_filter('woocommerce_display_item_meta', 'custom_display_item_meta', 10, 3);

function custom_display_item_meta($html, $item, $args) {
    $item_meta = $item->get_formatted_meta_data();
    
    foreach ($item_meta as $meta_id => $meta) {
        $meta_key = str_replace('_shine_members', 'Shine membership', $meta->key);
        $meta_value = $meta->value;

        // Replace the key in the HTML
        $html = str_replace($meta->display_key, esc_html($meta_key), $html);
    }

    return $html;
}

//subscription#RB[search-addSubscriptionPlan]
//shine#RB
function addSubscriptionPlan($order_id)
{
    global $wpdb;
    $order = wc_get_order($order_id);
    $data = array();
    $wc_authorize_net_cim_credit_card_customer_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_customer_id', true);
    $wc_authorize_net_cim_credit_card_payment_token = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_payment_token', true);
    
    if ($wc_authorize_net_cim_credit_card_customer_id) {
        foreach ($order->get_items() as $item_id => $item) {
           
            $is_shine = 0;
            $plan_code = 0;
            $plan_name = "Shine Perks";
            $product_id = $item->get_product_id();
            $key = array_search($product_id, $_REQUEST['subscription_products']);
            $search_prod = $_REQUEST['subscription_products'][$key];
            $arbid = $_REQUEST['subscription_arbids'][$key];

            /*if ($key === false && empty($search_prod)){
                continue;
            }else*/
            if($arbid > -1 && $search_prod == $product_id)
            {
                $product = wc_get_product($product_id);

                //** Subscription Plan on Authorize.net
                $rows = get_field('define_subscription_plans', $product_id);
                
                $interval = 0;
                if($rows){
                    foreach ($rows as $index => $data) {
                        $frequency = is_array($data['billingshipping_frequency'])?$data['billingshipping_frequency']['value']:$data['billingshipping_frequency'];
                        if ($index == $arbid) {
                            $price = $data['price'];
                            $interval = ($frequency < 7 ? 8 : $frequency);
                        }
                    }
                }elseif(!$rows){
                    $is_shine = 1;
                    $rows = get_field('define_shine_membership_plans', $product_id);

                    foreach ($rows as $index => $data) {
                        $frequency = is_array($data['billingshipping_frequency'])?$data['billingshipping_frequency']['value']:$data['billingshipping_frequency'];
                        if ($index == $arbid) {
                            $price = $data['price'];
    
                            if (in_array($product_id, [SHINE_DENTAL_PRODUCT_ID]) && str_contains(strtolower(@$data['plan_type']['value']), 'individual')){
                                $plan_code = "577200";
                                $plan_name = "Shine Dental (Individual)";
                            }elseif(in_array($product_id, [SHINE_DENTAL_PRODUCT_ID])){
                                $plan_code = "577201";
                                $plan_name = "Shine Dental (Family)";
                            }
    
                            if (in_array($product_id, [SHINE_COMPLETE_PRODUCT_ID]) && str_contains(strtolower(@$data['plan_type']['value']), 'individual')){
                                $plan_code = "577204";
                                $plan_name = "Shine Complete (Individual)";
                            }elseif(in_array($product_id, [SHINE_COMPLETE_PRODUCT_ID])){
                                $plan_code = "577205";
                                $plan_name = "Shine Complete (Family)";
                            }
    
                            $interval = ($frequency < 7 ? 30 : $frequency);
                        }
                    }
                }

                $title = substr($product->get_title() . " Every " . $interval . " days", 0, 50);

                $dataObject = array(
                    "ARBCreateSubscriptionRequest" => array(
                        "merchantAuthentication" => array(
                            "name" => SB_AUTHORIZE_LOGIN_ID,
                            "transactionKey" => SB_AUTHORIZE_TRANSACTION_KEY
                        ),
                        "refId" => $item_id,
                        "subscription" => array(
                            "name" => $title,
                            "paymentSchedule" => array(
                                "interval" => array(
                                    "length" => $interval,
                                    "unit" => "days"
                                ),
                                "startDate" => date('Y-m-d'),
                                "totalOccurrences" => 999,
                                "trialOccurrences" => "1"
                            ),
                            "amount" => $price,
                            "trialAmount" => "0.00",
                            "order" => array(
                                "invoiceNumber" => "SUBC-" . $item_id,
                                "description" => $title
                            ),
                            "profile" => array(
                                "customerProfileId" => $wc_authorize_net_cim_credit_card_customer_id,
                                "customerPaymentProfileId" => $wc_authorize_net_cim_credit_card_payment_token
                            )
                        )
                    )
                );

                $response = authorizeCurlRequest(json_encode($dataObject));
                $order->add_order_note(json_encode($dataObject));
                $responseAPI = json_decode($response, true);
                $order->add_order_note($response);

                wc_add_order_item_meta($item_id, '_authorizeResponse', $response);
                wc_add_order_item_meta($item_id, '_subscriptionId', $responseAPI['subscriptionId']);

                //store subscription details
                $user_id = get_post_meta($order_id, '_customer_user', true);
                $transaction_id = get_post_meta($order_id, '_wc_authorize_net_cim_credit_card_trans_id', true);    

                // if($is_shine && $is_shine >0){
                //     update_user_meta($user_id, 'is_shine_user', 1);
                //     update_user_meta($user_id, 'shine_current_member_ship_plan', $plan_name);
                // }
                
                if(empty($transaction_id))
                    $transaction_id = get_post_meta($order_id, '_transaction_id', true);    
                
                update_user_meta($user_id, 'is_subscribed', 1);
                $order->update_meta_data('_subscriptionId', $responseAPI['subscriptionId']);

                if($is_shine && $is_shine > 0){
                    update_user_meta($user_id, 'is_shine_user', 1);
                    update_user_meta($user_id, 'shine_current_member_ship_plan', $plan_name);
                    update_user_meta($user_id, 'shine_plan_code', $plan_code);
                    $order->update_meta_data('_shineSubcId', $responseAPI['subscriptionId']);
                }
                
                $qData = array(
                    'user_id' => $user_id,
                    'subscription_id' => ((int) $responseAPI['subscriptionId']),
                    'transaction_id' => $transaction_id,
                    'order_id' => $order_id,
                    'item_id' => $item_id,
                    'product_id' => $product_id,
                    'total_price' => $price,
                    'status' => 1,
                    'quantity' => $item->get_quantity(),
                    'subscription_date' => date('Y-m-d H:i:s'),
                    'interval_days' => $interval,
                    'next_order_date' => date('Y-m-d', strtotime(date('Y-m-d') . " + {$interval} days")),
                    'authorize_response' => $responseAPI,
                    'shine_group_code' => $plan_code
                );
                
                $order->add_order_note("Subscription Details Logs:" . json_encode($qData));
                $order->save();

                $wpdb->insert('sbr_subscription_details', $qData);
            }
        }
    }
}

//shine-subscription#RB
add_action('woocommerce_account_shine_subscription_endpoint', 'sbr_customer_account_shine_subscription_content');
add_action('woocommerce_account_shine_card_endpoint', 'sbr_customer_account_shine_card_content');
add_action('woocommerce_account_shine_discounts_endpoint', 'sbr_customer_account_shine_discounts_content');
function sbr_customer_account_shine_discounts_content()
{
    echo "<div class='shine-discount-card-mobile-wrapper'>";
  
    get_template_part('page-templates/shine-lander-my-account');
    
    echo "</div>";
}

function sbr_customer_account_shine_card_content()
{
    global $wpdb;
    $subscription_id = "";
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $postsPerPage = -1;
    $plan = explode("(", get_user_meta($current_user->ID, 'shine_current_member_ship_plan', true) ?: 'N/A');

    $results = $wpdb->get_row("Select subscription_id, next_order_date from sbr_subscription_details where user_id=$user_id AND (shine_group_code <> 0 OR product_id = ".SHINE_PERK_PRODUCT_ID.") Order by id DESC LIMIT 1", "ARRAY_A");
    $shine_subsc_id = @$results['subscription_id'];
    $shine_exp_date = date("m/d/Y", strtotime(@$results['next_order_date']));
    ?>

<!-- borderBottomLine -->
<div
    class="d-flex align-items-center orderListingPageMenu menuParentRowHeading menuParentRowHeadingOrderParent shine-subscription-page-headingtp">

    <div class="pageHeading_sec">
        <span><span class="text-blue">Shine Card </span>Review your shine membership details.</span>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#download-shine-card').on('click', function() {
        var element = document.getElementById('card-to-print');

        // Wait for images to load
        var images = element.getElementsByTagName('img');
        var totalImages = images.length;
        var loadedImages = 0;

        for (var i = 0; i < totalImages; i++) {
            images[i].onload = function() {
                loadedImages++;
                if (loadedImages === totalImages) {
                    // All images are loaded, generate PDF
                    html2pdf().from(element).set({
                        margin: 1,
                        filename: 'shine-card.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.99
                        },
                        html2canvas: {
                            scale: 3,
                            useCORS: true
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'letter',
                            orientation: 'portrait',
                            dpi: 300
                        }
                    }).save();
                }
            };
            // Handle the case where images are already cached
            if (images[i].complete) {
                images[i].onload();
            }
        }
    });
});
</script>

    <div class="tab-pane blockDesktop shine-cards-tab" id="pills-profile" role="tabpanel"
        aria-labelledby="pills-profile-tab">
           <div class="card-print-wrapper"> 
            <div id="card-to-print">
             <table class="front-card front-card-mobile"
                style="overflow: hidden;width: 600px;height: 300px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:18px;border-radius:18px;border: 2px solid #000;    border-spacing: 0;    border-collapse: separate;    border-spacing: 1px;">
                <tr style="border-radius:10px;    background: none;">
                    <td colspan="2" style="padding:0;padding-bottom: 20px; padding-top: 0;border-radius:10px;    background: none;">
                        <table
                            style="width: 100%;    border-spacing: 0;border-spacing: 0;    border-collapse: separate;border-radius:10px;margin:0;">
                            <tr style="border-radius:10px;    background: none;">
                                <td colspan="2" style="width: 100%;  padding:0;  padding-top: 0; border-radius:10px;    background: none;">
                                    <div style="float: left;width: 100%;    margin-top: -2px;">
                                        <div
                                            style="width:25%;background-color:#2d2e2f;font-size:0px;height:10px;    float: left;     border-radius: 14px 0 0 0;">
                                            &nbsp;1</div>
                                        <div
                                            style="width:25%;background-color:#fa319e;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;2</div>
                                        <div
                                            style="width:25%;background-color:#4acac9;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;3</div>
                                        <div
                                            style="width:25%;background-color:#f0c23a;font-size:0px;;height:10px;    float: left;        border-radius: 0px 14px 0px 0px;">
                                            &nbsp;4</div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-radius:10px;border-radius:10px;    background: none;">
                                <td
                                    style="padding:0;width: 60px;padding-left: 20px;padding-top: 1rem;border-radius:10px;    background: none;">
                                    <img class="img-fluid"
                                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png"
                                        alt="Shine" style="max-width: 100px;"></td>
                                <td
                                    style="padding:0;text-align: center;padding-right: 1rem;padding-top: 1rem;border-radius:10px;    background: none;">
                                    <span class="span-text"
                                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 32px;color: #565759;"><?php echo @$plan[0]; ?></span><br>
                                    <div
                                        style="text-align: left;margin-top: 3px;padding-left: 74px;border-radius:10px;">
                                        <span><span
                                                style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 10px;color: #565759;padding-right: 5px;border-radius:10px;">by</span>
                                            <img style="max-width: 120px;
    " src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo-text.webp"
                                                alt="SmileBrilliant"></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="background: none;"> 
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        MEMBER :</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo strtoupper(esc_html($current_user->first_name . ' ' . $current_user->last_name)); ?></strong>
                    </td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        MEMBER ID:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo str_pad($current_user->ID, 8, '0', STR_PAD_LEFT); ?></strong></td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        GROUP NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo get_user_meta($current_user->ID, 'shine_plan_code', true) ?: 'N/A'; ?></strong>
                    </td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 20px;line-height: 1;    background: none;">
                        EXPIRATION:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 20px;line-height: 1;    background: none;">
                        <strong><?php echo (isset($shine_exp_date)?$shine_exp_date:''); ?></strong></td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        PLAN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <span><?php echo str_pad($shine_subsc_id, 8, '0', STR_PAD_LEFT); ?></span> <span
                            style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 14px;color: #25d4cd;line-height: 1;    background: none;"><?php echo @$plan[0]; ?></span>
                        <?php echo (@$plan[1] ? '(' . @$plan[1] : ''); ?></td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        Rx BIN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        011867</td>
                </tr>
                <tr style="border-radius:10px;    background: none;">
                    <td colspan="2" style="padding:0;padding-top: 20px;border-radius:10px;    background: none;">
                        <table
                            style="width: 100%;width: 100%;border-collapse: separate;margin: 0;border-spacing: 1px;border-radius:10px;    background: none;">
                            <tbody style="border: 0;background: none;padding: 0;border-radius:10px;">
                                <tr style="border-radius:10px;    background: none;">
                                    <td
                                        style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.webp"
                                            alt="" style="max-height: 40px;"></td>
<?php if (isset($plan[0]) && str_contains(strtolower($plan[0]), 'complete')) {?>
    
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/optum-rx-logo.svg"
                                            alt="Optum Rx" style="max-width: 90px;"></td>
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logo_CTCV.webp"
                                            alt="Coast to Coast Vision" style="max-width: 115px;"></td>
<?php }?>
                                    <td
                                        style="padding:0;text-align: center;    padding-right: 15px;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logosm_aetna.webp"
                                            alt="Aetna Dental Access®" style="height: 52px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="shine-back-card"
                style="width: 600px;height: 300px;border-radius: 15px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:14px;border-radius:14px;border: 2px solid #000;border-spacing: 0;margin-top:2rem;padding:1rem;font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 14px;color: #565759;padding-left: 16px;padding-bottom: 7px;line-height: 1;padding-top: 10px; border-collapse: separate;">
                <tbody style="border: 0;background-color: transparent;font-size:13px;">
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            Smile Brilliant Customer Service: <strong style="font-weight:700;"> 855-944-8361</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                        Aetna Dental Access®® Plan:<strong style="font-weight:700;"> 866-868-6199 </strong>
                        </td>
                    </tr>

                    <?php
if (isset($plan[0]) && str_contains(strtolower($plan[0]), 'complete')) {?>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            OptumRx Pharmacy Plan: <strong style="font-weight:700;">
                             866-868-6199 price quotes</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            Coast to Coast Vision Plan: <strong style="font-weight:700;">800-878-3901</strong>
                        </td>
                    </tr>
                    <?php }?>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 20px;    background: none;">
                            To view your account details or get discounts on Smile Brilliant Products:<br>
                            <a style="color: #565759;font-weight:700;text-decoration:none;"
                                href="http://www.smilebrilliant.com/my-account">www.smilebrilliant.com/my-account</a>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 10px;background: none;">
                            Search for a provider:<br>
                            <a href="http://www.smilebrilliant.com/shine-search"
                                style="color: #565759;font-weight:700;text-decoration:none;">www.smilebrilliant.com/shine-search</a>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 20px;background: none;">
                            PROVIDERS: <strong style="font-weight:700;">Use 866-868-6199 to check eligibility</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2"
                            style="padding-top: 20px; font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 12px;color: #565759;padding-bottom: 15px;line-height: 1.2; background: none;">
                            <strong style="font-weight:700;">Shine is NOT</strong> insurance. Shine provides access to
                            the Aetna Dental Access®® Network which is administered by Aetna Life Insurance Company
                            (ALIC). Neither ALIC nor any of its affiliates is an affiliate, agent, representative or
                            employee of [the discount program]. Dental providers are independent contractors and not
                            employees or agents of ALIC or its affiliates. ALIC does not provide dental care or
                            treatment and is not responsible for outcomes.
                        </td>
                    </tr>
                </tbody>
            </table>

            </div>
        </div>
        <button id="download-shine-card" class="btn button-download-button-card"> <span class="circle2"><i class="fa fa-download"></i></span> Download your shine card</button>
    </div>

<?php

    if (isset($_REQUEST['action'])) {
        die;
    } else {
        return true;
    }
}

function sbr_customer_account_shine_subscription_content()
{
    global $wpdb;
    $subscription_id = "";
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $postsPerPage = -1;
    $plan = explode("(", get_user_meta($current_user->ID, 'shine_current_member_ship_plan', true) ?: 'N/A');

    $results = $wpdb->get_row("Select subscription_id, next_order_date from sbr_subscription_details where user_id=$user_id AND (shine_group_code <> 0 OR product_id = ".SHINE_PERK_PRODUCT_ID.") Order by id DESC LIMIT 1", "ARRAY_A");
    $shine_subsc_id = @$results['subscription_id'];
    $shine_exp_date = date("m/d/Y", strtotime(@$results['next_order_date']));
    ?>

<!-- borderBottomLine -->
<div
    class="d-flex align-items-center orderListingPageMenu menuParentRowHeading menuParentRowHeadingOrderParent shine-subscription-page-headingtp">

    <div class="pageHeading_sec">
        <span><span class="text-blue">Shine membership </span>Review your shine membership details.</span>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>

$(document).ready(function() {
    $('#download-shine-card').on('click', function() {
        var element = document.getElementById('card-to-print');

        // Wait for images to load
        var images = element.getElementsByTagName('img');
        var totalImages = images.length;
        var loadedImages = 0;

        for (var i = 0; i < totalImages; i++) {
            images[i].onload = function() {
                loadedImages++;
                if (loadedImages === totalImages) {
                    // All images are loaded, generate PDF
                    html2pdf().from(element).set({
                        margin: 1,
                        filename: 'shine-card.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.99
                        },
                        html2canvas: {
                            scale: 3,
                            useCORS: true
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'letter',
                            orientation: 'portrait',
                            dpi: 300
                        }
                    }).save();
                }
            };
            // Handle the case where images are already cached
            if (images[i].complete) {
                images[i].onload();
            }
        }
    });
});
</script>


<div class="shinewrapperParent">

        <?php
        $customer_subscriptions = $wpdb->get_results("SELECT *, COUNT(1) as count FROM sbr_subscription_details WHERE user_id=" . $user_id . " AND subscription_id > 0 AND (shine_group_code <> 0 OR product_id = ".SHINE_PERK_PRODUCT_ID.") AND `status` = 1 GROUP BY subscription_id ORDER BY subscription_id DESC, id LIMIT 1");

        if(count($customer_subscriptions) > 0)
        {
            foreach ($customer_subscriptions as $customer_order) {
                $product = wc_get_product($customer_order->product_id);
                $productTitle = '<h4 class="productNameAndQuantity mb-0 "><a href="' . get_the_permalink($customer_order->product_id) . '" target= "_blank">' . $product->get_name() . '</a></h4>';
                $shine = get_post_meta($customer_order->order_id, '_shineSubcId', true);

                if ($shine) {
                    if ($subscription_id != $customer_order->subscription_id) {
                    
                        ?>
                <div class="subscription_wrapper <?php echo ($shine ? 'shineSubscribed' : ''); ?>">
                <div class="subscription_header">
                <div class="subscription_title subscriptionRowTitle">
                    <h3><?php 
                    
                    //echo ($shine ? $product->get_name() . ' for ' : '') . $customer_order->interval_days . ' Days Package'; 
                    echo (in_array($customer_order->product_id, [SHINE_DENTAL_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_PERK_PRODUCT_ID])? $product->get_name().' <small>('.ucfirst(wc_get_order_item_meta($customer_order->item_id, '_shine_members', true)).')</small> '. $customer_order->interval_days . ' Days Package' : $product->get_name());

                    ?>
                    </h3>
                    <a href="/shine-search">Find a Provider</a>
                </div>

                <div class="subscription-product-wrapper">
                    <div class="subscription-product-image-title">
                        <div class="orderImage">
                            <?php echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $product->get_image(), $customer_order->item_id)); ?>
                        </div>
                        <?php echo $productTitle; ?>
                    </div>

                    <div class="subscription-status-wrapper ">
                        <div class="sbr-orderItemRightActions">
                        
                            <?php
                    if ($customer_order->status) {
                        
                                        ?>
                                        <div class="sbr-detail-list-buttons">
                                                <!-- <a href="javascript:void(0)" class="button btn-primary-blue cancle-subscription"
                                                    onclick="setCancelSubValues(<?php //echo $customer_order->subscription_id; ?>, <?php //echo $customer_order->item_id; ?>);"
                                                    data-toggle="modal" data-target="#viewSubscriptionCancelModal">Cancel / Pause Subscription </a> -->
                                                <span class="seprator-line"></span>
                                                <a href="/my-account/subscription/" class="button btn-primary-blue shine-button-view-detail">
                                                    view history
                                                </a>
                                        </div>

                                        <?php
                                        
                    }
                        ?>
                        </div>
                        <div class="subscription-status">
                            <span style="float: right; font-weight: 400;"><span style="color: #3c98cc;">Subscription Status:
                                </span> <?php echo ($customer_order->status ? 'Active' : 'Cancelled'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lowOrderArea">
                </div>
            <?php

                    }
                    ?>
        </div>
        <?php

                }
        }
}else{
    echo "<div style='background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: space-between;'>
    <h3 style='margin: 0; font-size: 18px; color: #333;'>Your subscription is expiring soon on ".(isset($shine_exp_date)?$shine_exp_date:'').". Renew now to avoid interruption.</h3>
    <a href='/shine#shine_pricing' style='text-decoration: none;'>
      <button style='padding: 10px 20px; background-color: #f0c23a; border: none; color: white; border-radius: 5px; cursor: pointer; font-size: 16px;'>Renew Subscription</button>
    </a>
  </div><br/>";

}
    ?>
    </div>

    <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop shine-tabs-wrapper">    
    <li class="nav-item">
        <a class="uppercase nav-link ripple-button rippleSlowAnimate" id="pills-profile-tab" data-toggle="pill"
            href="#shine-card" role="tab" aria-controls="shine-card" aria-selected="false">
            Membership Card</a>
    </li>

        <li class="nav-item">
            <a class="nav-link uppercase ripple-button rippleSlowAnimate active show" id="shine-card-shopping" data-toggle="pill" href="#shine-shopping-discount" role="tab" aria-controls="shine-shopping-discount" aria-selected="true">
                 My Discounts
            </a>
        </li>
</ul>

<div class="tab-content" id="pills-tabContent">

    <div class="tab-pane blockDesktop shine-cards-tab" id="shine-card" role="tabpanel"
        aria-labelledby="shine-card-tab">
           <div class="card-print-wrapper"> 
        <div id="card-to-print">
            <table class="front-card"
                style="overflow: hidden;width: 600px;height: 300px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:18px;border-radius:18px;border: 2px solid #000;    border-spacing: 0;    border-collapse: separate;    border-spacing: 1px;">
                <tr style="border-radius:10px;">
                    <td colspan="2" style="padding:0;padding-bottom: 20px; padding-top: 0;border-radius:10px;">
                        <table
                            style="width: 100%;    border-spacing: 0;border-spacing: 0;    border-collapse: separate;border-radius:10px;margin:0;">
                            <tr style="border-radius:10px;">
                                <td colspan="2" style="width: 100%;  padding:0;  padding-top: 0; border-radius:10px;">
                                    <div style="float: left;width: 100%;    margin-top: -2px;">
                                        <div
                                            style="width:25%;background-color:#2d2e2f;font-size:0px;height:10px;    float: left;     border-radius: 14px 0 0 0;">
                                            &nbsp;1</div>
                                        <div
                                            style="width:25%;background-color:#fa319e;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;2</div>
                                        <div
                                            style="width:25%;background-color:#4acac9;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;3</div>
                                        <div
                                            style="width:25%;background-color:#f0c23a;font-size:0px;;height:10px;    float: left;        border-radius: 0px 14px 0px 0px;">
                                            &nbsp;4</div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-radius:10px;border-radius:10px;">
                                <td
                                    style="padding:0;width: 60px;padding-left: 40px;padding-top: 1rem;border-radius:10px;">
                                    <img class="img-fluid"
                                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png"
                                        alt="Shine" style="max-width: 100px;"></td>
                                <td
                                    style="padding:0;text-align: center;padding-right: 1rem;padding-top: 1rem;border-radius:10px;">
                                    <span
                                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 32px;color: #565759;"><?php echo @$plan[0]; ?></span><br>
                                    <div
                                        style="text-align: left;margin-top: 3px;padding-left: 74px;border-radius:10px;">
                                        <span><span
                                                style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 10px;color: #565759;padding-right: 5px;border-radius:10px;">by</span>
                                            <img style="
        max-width: 120px;
    " src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo-text.webp"
                                                alt="SmileBrilliant"></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;">
                        MEMBER :</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;">
                        <strong><?php echo strtoupper(esc_html($current_user->first_name . ' ' . $current_user->last_name)); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;">
                        MEMBER ID:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;">
                        <strong><?php echo str_pad($current_user->ID, 8, '0', STR_PAD_LEFT); ?></strong></td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;">
                        GROUP NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;">
                        <strong><?php echo get_user_meta($current_user->ID, 'shine_plan_code', true) ?: 'N/A'; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 20px;line-height: 1;">
                        EXPIRATION:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 20px;line-height: 1;">
                        <strong><?php echo (isset($shine_exp_date)?$shine_exp_date:''); ?></strong></td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;">
                        PLAN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;">
                        <span><?php echo str_pad($shine_subsc_id, 8, '0', STR_PAD_LEFT); ?></span> <span
                            style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;line-height: 1;"><?php echo @$plan[0]; ?></span>
                        <?php echo (@$plan[1] ? '(' . @$plan[1] : ''); ?></td>
                </tr>
                <tr>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;">
                        Rx BIN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;">
                        011867</td>
                </tr>
                <tr style="border-radius:10px;">
                    <td colspan="2" style="padding:0;padding-top: 20px;border-radius:10px;">
<?php if (isset($plan[0]) && str_contains(strtolower($plan[0]), 'complete')) {?>
                    <table
                            style="width: 100%;width: 100%;border-collapse: separate;margin: 0;border-spacing: 1px;border-radius:10px;">
                            <tbody style="border: 0;background: none;padding: 0;border-radius:10px;">
                                <tr style="border-radius:10px;">
                                    <td
                                        style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.webp" 
                                            alt="" style="max-height: 40px;"></td>
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/optum-rx-logo.svg"
                                            alt="Optum Rx" style="max-width: 90px;"></td>
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logo_CTCV.webp"
                                            alt="Coast to Coast Vision" style="max-width: 115px;"></td>
                                    <td
                                        style="padding:0;text-align: center;    padding-right: 15px;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logosm_aetna.webp"
                                            alt="Aetna Dental Access®" style="height: 52px;"></td>
                                </tr>
                            </tbody>
                        </table>
<?php }else{?>
                    <table
                            style="width: 100%;width: 100%;border-collapse: separate;margin: 0;border-spacing: 1px;border-radius:10px;">
                            <tbody style="border: 0;background: none;padding: 0;border-radius:10px;">
                                <tr style="border-radius:10px;">
                                    <td
                                        style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.webp"
                                            alt="" style="max-height: 58px;"></td>                                    
                                    <td
                                        style="padding:0;text-align: center;    padding-right: 15px;padding-bottom: 10px;border-radius:10px;">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logosm_aetna.webp"
                                            alt="Aetna Dental Access®" style="height: 58px;"></td>
                                    <td style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logosm_aetna.webp"
                                            alt="Aetna Dental Access®" style="height: 52px;;opacity:0;">
                                    </td>
                                    <td style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/logosm_aetna.webp"
                                            alt="Aetna Dental Access®" style="height: 52px;opacity:0;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
<?php }?>
                    </td>
                </tr>
            </table>


            <table class="shine-back-card"
                style="width: 600px;height: 300px;border-radius: 15px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:14px;border-radius:14px;border: 2px solid #000;border-spacing: 0;margin-top:2rem;padding:1rem;font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 14px;color: #565759;padding-left: 16px;padding-bottom: 7px;line-height: 1;padding-top: 10px; border-collapse: separate;">
                <tbody style="border: 0;background-color: transparent;font-size:13px;">
                
                    <tr>
                        <td colspan="2">
                            Smile Brilliant Customer Service: <strong style="font-weight:700;"> 855-944-8361</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Aetna Dental Access® Plan:<strong style="font-weight:700;"> 866-868-6199</strong>
                        </td>
                    </tr>

                    <?php
if (isset($plan[0]) && str_contains(strtolower($plan[0]), 'complete')) {?>
                    <tr>
                        <td colspan="2">
                            OptumRx Pharmacy Plan: <strong style="font-weight:700;"> 866-868-6199 price quotes</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Coast to Coast Vision Plan: <strong style="font-weight:700;">800-878-3901</strong>
                        </td>
                    </tr>
                    <?php }else{?>
                        <style>
                            .shine-back-card{
                                padding-top: 30px !important;
                                padding-bottom: 30px !important;
                            }

                        </style>
                        <tr class="remove">
                        <td colspan="2">
                            <div class="alignmentForPdfFrotEnd"></div>
                        </td>
                    </tr>


<?php                    }?>
                    <tr>
                        <td colspan="2" style="padding-top: 20px;">
                            To view your account details or get discounts on Smile Brilliant Products:<br>
                            <a style="color: #565759;font-weight:700;text-decoration:none;"
                                href="http://www.smilebrilliant.com/my-account">www.smilebrilliant.com/my-account</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 10px;">
                            Search for a provider:<br>
                            <a href="http://www.smilebrilliant.com/shine-search"
                                style="color: #565759;font-weight:700;text-decoration:none;">www.smilebrilliant.com/shine-search</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 20px;">
                            PROVIDERS: <strong style="font-weight:700;">Use 866-868-6199 to check eligibility</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="padding-top: 20px; font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 12px;color: #565759;padding-bottom: 15px;line-height: 1.2;">
                            <strong style="font-weight:700;">Shine is NOT</strong> insurance. Shine provides access to
                            the Aetna Dental Access®® Network which is administered by Aetna Life Insurance Company
                            (ALIC). Neither ALIC nor any of its affiliates is an affiliate, agent, representative or
                            employee of [the discount program]. Dental providers are independent contractors and not
                            employees or agents of ALIC or its affiliates. ALIC does not provide dental care or
                            treatment and is not responsible for outcomes.
                        </td>
                    </tr>
                </tbody>
            </table>

            </div>
        </div>
        <button id="download-shine-card" class="btn button-download-button-card"> <span class="circle2"><i class="fa fa-download"></i></span> Download your shine card</button>
    </div>

     <?php
            function is_mobile_device() {
                return preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone|opera mini|mobile|tablet|webos)/i', $_SERVER['HTTP_USER_AGENT']);
            }

            if (!is_mobile_device()) { // If not a mobile device, load the content
                ?>
                <div class="tab-pane show active" id="shine-shopping-discount" role="tabpanel" aria-labelledby="shine-shopping-discount-tab">
                    <?php get_template_part('page-templates/shine-lander-my-account'); ?>
                </div>
                <?php
            }
        ?>

</div>


<!-- Modal -->
<style>
.modal-backdrop {
    top: unset !important;
}
</style>
<div class="modal fade" id="viewSubscriptionCancelModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Cancel Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this subscription?
            </div>
            <div class="modal-footer subs-buttons">
                <input type="hidden" value="" id="sbr-subscription_id">
                <input type="hidden" value="" id="sbr-reference_id">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-primary" id="deleteButton">Cancel Subscription</button>
            </div>
        </div>
    </div>
</div>

<script>
function setCancelSubValues(subscriptionId, refId) {
    $('#sbr-subscription_id').val(subscriptionId);
    $('#sbr-reference_id').val(refId);
}
jQuery(document).ready(function($) {
    $('#deleteButton').on('click', function() {
    $('.loading-sbr').show();
        
        jQuery.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'authorize_cancell_subscription',
                subscription_id: $('#sbr-subscription_id').val(),
                refId: $('#sbr-reference_id').val(),
            },
            async: true,
            dataType: 'html',
            method: 'POST',
            success: function(response) {
                //alert(response);
                location.reload();
            },
            cache: false,
        });

        // Close the modal
        $('#viewSubscriptionCancelModal').modal('hide');
    });
});
</script>
<!--- End Modal --->
<!--Static html end -->

<?php

    if (isset($_REQUEST['action'])) {
        die;
    } else {
        return true;
    }
}
// Restrict States for shine membership
add_action('woocommerce_checkout_process', 'restrict_order_based_on_shipping_state_and_products');
function restrict_order_based_on_shipping_state_and_products() {
    $RESTRICTED_SHINE_STATES = RESTRICTED_SHINE_STATES; // restricted states 
    $restricted_product_ids = SHINE_REPORT_PRODUCT_IDS; //restricted product IDs 
    
    // Get the shipping state selected by the customer on the checkout page
    $shipping_state = WC()->customer->get_shipping_state(); // or use posted data
    if (empty($shipping_state)) {
        $shipping_state = isset($_POST['shipping_state']) ? sanitize_text_field($_POST['shipping_state']) : '';
    }
    
    // Check if the shipping state is in the restricted list
    if (in_array($shipping_state, $RESTRICTED_SHINE_STATES)) {        
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['product_id'];
            
            if (in_array($product_id, $restricted_product_ids)) {
                wc_add_notice( 'We apologize, but Shine membership is currently not available in your state. Please contact support for more details.', 'error' );                
                break;
            }
        }
    }
}


add_action('wp_footer', 'custom_restricted_product_modal');
function custom_restricted_product_modal() {
    if (is_checkout()) {
        ?>
        <style>
            .shineRestrictedProductModal{

                display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;

            }
            .restrictedModalInner{
                background-color: #fefefe;
                margin: 0% auto;
                padding: 30px 30px;
                border: 1px solid #888;
                width: 100%;
                max-width: 80%;
                animation: slideUp 0.5s;
                position: relative;
                border: 4px solid #2d2e2f;
                border-radius: 10px;
                margin-top: 2rem;
                border: 4px solid #888;
                max-width: 700px;
                color: #856404;
                border-color: #ffeeba;
            }
            .crossIconMbt {
            color: #856404;
            float: right;
            font-size: 28px;
            font-weight: bold;
            display: inline-flex;
            width: 30px;
            height: 30px;
            border: 1px solid #856404;
            align-items: center;
            justify-content: center;
            line-height: 1;
            border-radius: 30px;
            position: absolute;
            right: 14px;
            top: 14px;
            cursor: pointer;
        }
        .restrictedModalInner p {
                margin: 0;
            }
        .importantDiv{
            font-size: 29px;
            font-family: "Montserrat";font-weight: 800;

        }

        @media (max-width: 767px) {
            .restrictedModalInner{
                padding-left: 15px;
                padding-right: 15px;
            }


        }

        </style>
        <div id="restricted-product-modal" class="shineRestrictedProductModal">
            <div  class="restrictedModalInner">
                <span class="close-modal crossIconMbt">×</span>
                <div class="importantDiv">IMPORTANT!</div>
                <p> “Shine Complete and shine dental are not accepted in the following states (<strong>Alaska, Iowa, Rhode Island, Utah, Vermont and Washington</strong>). If you intend on using your shine in these states, it will not be accepted”.</p>
                <!-- <button id="close-modal"  class="close-modal" style="padding:10px 20px; background:#007cba; color:#fff; border:none; cursor:pointer; border-radius:5px;">OK</button> -->
            </div>
        </div>
        <?php
    }
}

// Add custom JS to checkout page
add_action('wp_footer', 'custom_checkout_state_restriction_script');
function custom_checkout_state_restriction_script() {
    // List of restricted states and product IDs
    $restricted_states = json_encode(RESTRICTED_SHINE_STATES); // restricted states 
    $restricted_product_ids = json_encode([SHINE_DENTAL_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID]); //restricted product IDs 
    ?>
    <script type="text/javascript">
       // $('#restricted-product-modal').fadeOut();
        jQuery(document).ready(function($) {
            var restrictedStates = <?php echo $restricted_states; ?>;
            var restrictedProductIds = <?php echo $restricted_product_ids; ?>;

            // Extract product IDs from dataLayer_content
            // function getProductIdsFromDataLayer() {
            //     if (typeof dataLayer !== 'undefined' && dataLayer[0]?.cartContent?.items) {
            //         var items = dataLayer[0].cartContent.items;
            //         var productIds = items.map(function(item) {
            //             return item.item_id;
            //         });
            //         return productIds; // Return the array of item_ids
            //     }
            //     return [];
            // }

            // // Check if restricted product is in the cart
            // function hasRestrictedProduct() {
            //     var productIdsInCart = getProductIdsFromDataLayer();
            //     var restrictedProductIdsNormalized = restrictedProductIds.map(Number);
            //     var productIdsInCartNormalized = productIdsInCart.map(Number);

            //     return productIdsInCartNormalized.some(function(id) {
            //         return restrictedProductIdsNormalized.includes(id);
            //     });
            // }

            function check_shine_restricted_item_in_cart(){
                var items = document.querySelectorAll('.wfacp_mini_cart_item_title');
                for (var i = 0; i < items.length; i++) {
                    var itemText = items[i].textContent || items[i].innerText;
                    if (itemText.includes('Shine Dental') || itemText.includes('Shine Complete')) {
                        return true;  // Return true if the text is found
                    }
                }    
                return false;
            }

            // Show the modal
            function showRestrictedProductModal() {
                $('#restricted-product-modal').fadeIn(); // Show the modal
            }

            // Hide the modal
            $('.close-modal').on('click', function() {
                $('#restricted-product-modal').fadeOut();
            });

            // Function to run after the checkout page is updated
            function checkShippingState() {
                var selectedState = $('#billing_state, #shipping_state').val();
                if (restrictedStates.includes(selectedState) && check_shine_restricted_item_in_cart()) {
                    showRestrictedProductModal();
                    $('#billing_state, #shipping_state').val("");
                    return false;
                }
            }

            // Wait for checkout fields to be updated, including after shipping fields load
            $(document.body).on('updated_checkout', function() {
                $('#billing_state, #shipping_state').on('change', function() {
                    checkShippingState();
                });
                checkShippingState();
            });
        });
    </script>
    <?php
}


function enqueue_custom_script_shine_ids() {
   
    wp_register_script('custom-js-shine', false); // Register a custom inline script with no file
    wp_enqueue_script('custom-js-shine'); // Enqueue the script
    // Pass the SHINE_REPORT_PRODUCT_IDS to the script
    $shine_report_ids = defined('SHINE_REPORT_PRODUCT_IDS') ? SHINE_REPORT_PRODUCT_IDS : array();
    wp_localize_script('custom-js-shine', 'shineReportData', array(
        'product_ids' => $shine_report_ids,
        'ajax_url'    => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script_shine_ids');
/* sending via cherrypick */

function shine_user_redirect_on_login($user_login, $user) {

    if (get_user_meta($user->ID, 'is_shine_user', true) === '1') {
        // Redirect to the subscriptions page
        wp_redirect(home_url('/my-account/shine_subscription/'));
        exit;
    }
}
add_action('wp_login', 'shine_user_redirect_on_login', 10, 2);