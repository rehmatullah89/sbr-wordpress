<?php
function start_session_ng() {
    if (!session_id()) {
        session_start();
    }
}
//add_action('init', 'start_session_ng', 1);

// Determine the design and store it in session
function determine_design_ng() {
    if (!isset($_COOKIE['design_ng_sbr']) && check_if_night_guards_product_page()) {
        // Set the cookie with a value of either 'v1' or 'v2' and an expiration time of one hour
        $value = rand(0, 1) ? 'v1' : 'v2';
        setcookie('design_ng_sbr', $value, time() + 3600*24, "/"); // 3600 seconds = 1 hour
        setcookie('design_ng_sbr_unique_id', substr(bin2hex(random_bytes(8)), 0, 15), time() + 3600*24, "/");
    }
}
add_action('template_redirect', 'determine_design_ng');
function check_and_create_ab_test_tables() {
    global $wpdb;

    $table_name_visits = $wpdb->prefix . 'ab_test_visits';
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';

    $charset_collate = $wpdb->get_charset_collate();

    $sql_visits = "
        CREATE TABLE $table_name_visits (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            design varchar(2) NOT NULL,
            session_id varchar(255) NOT NULL,
            visit_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;
    ";

    $sql_orders = "
        CREATE TABLE $table_name_orders (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            design varchar(2) NOT NULL,
            session_id varchar(255) NOT NULL,
            product_id bigint(20) NOT NULL,
            action varchar(20) NOT NULL,
            order_id bigint(20) DEFAULT NULL,
            action_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_visits);
    dbDelta($sql_orders);
    die();
}

// Hook the function to 'init' action to check and create tables if they do not exist
if(isset($_REQUEST['create_table'])){
            add_action('init', 'check_and_create_ab_test_tables');
}


function check_if_night_guards_product_page() {
    if(wp_doing_ajax()){
    $referrer = isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : 'Unknown';
    if (strpos($referrer, 'product/night-guards') !== false) {
            // Code to execute if it's the product page with slug 'night-guards'
            return true;
        }
        return false;
    }

else{
    if (is_product()) {
        global $post;
        $product_slug = $post->post_name;

        if ($product_slug == 'night-guards') {
            // Code to execute if it's the product page with slug 'night-guards'
            return true;
        }
        return false;
    }
}
}


//add_action('template_redirect', 'track_visit_ng');

// Track add-to-cart
function track_add_to_cart_ng_old($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
     $referrer = isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : 'Unknown';
    if (!strpos($referrer, 'product/night-guards') !== false) {
       
        return;
    }
    
 
    global $wpdb;
    $session_id = $_COOKIE['design_ng_sbr_unique_id'];
    $design = $_COOKIE['design_ng_sbr'];
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';
    $taxonomy ='product_cat';
    if (product_belongs_to_category($product_id, 'night-guards',$taxonomy)) {
       
    $wpdb->insert($table_name_orders, [
        'session_id' => $session_id,
        'design' => $design,
        'product_id' => $product_id,
        'action' => 'add_to_cart',
    ]);
}
}

function track_add_to_cart_ng($cart_item_data, $product_id, $variation_id) {
    $referrer = isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : 'Unknown';

    if (strpos($referrer, 'product/night-guards') === false) {
        return $cart_item_data;
    }

    global $wpdb;
    $session_id = isset($_COOKIE['design_ng_sbr_unique_id']) ? $_COOKIE['design_ng_sbr_unique_id']:'';
    $design = isset($_COOKIE['design_ng_sbr']) ? $_COOKIE['design_ng_sbr'] : '';


    // Optionally store additional data or perform actions
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';
    $taxonomy = 'product_cat';

    if (product_belongs_to_category($product_id, 'night-guards', $taxonomy)  && $product_id!='795483' && $product_id!='739363') {
        $wpdb->insert($table_name_orders, [
            'session_id' => $session_id,
            'design' => $design,
            'product_id' => $product_id,
            'action' => 'add_to_cart',
        ]);
    }

    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'track_add_to_cart_ng', 10, 3);


//add_action('woocommerce_add_to_cart', 'track_add_to_cart_ng', 10, 6);

// Track successful orders
function track_order_ng($order_id) {
   

    global $wpdb;
    //$session_id = session_id();
   // $design = isset($_SESSION['design_ng_sbr'])?$_SESSION['design_ng_sbr']:'';
    //if($design!=''){
       
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';

    // Get the order details
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item_id => $item) {
        $design = isset($_COOKIE['design_ng_sbr']) ? $_COOKIE['design_ng_sbr']:'';
        $session_id = isset($_COOKIE['design_ng_sbr_unique_id']) ? $_COOKIE['design_ng_sbr_unique_id']:'';
        $product_id = $item->get_product_id();
        $taxonomy ='product_cat';
    if (product_belongs_to_category($product_id, 'night-guards',$taxonomy) && $design!='' && $session_id!='' && $product_id!='795483' && $product_id!='739363') {
        $wpdb->insert($table_name_orders, [
            'session_id' => $session_id,
            'design' => $design,
            'product_id' => $product_id,
            'action' => 'order',
            'order_id' => $order_id,
        ]);
    }
   // }
    }
}
add_action('woocommerce_checkout_order_processed', 'track_order_ng');



// Add custom admin menu
function add_ab_test_admin_menu() {
    add_menu_page(
        'Nightguards  A/B',
        'Nightguards A/B',
        'manage_options',
        'ab-test-reports-ng',
        'render_ab_test_reports_page_ng',
        'dashicons-chart-bar',
        20
    );
}
add_action('admin_menu', 'add_ab_test_admin_menu');



// Render the custom admin page
function render_ab_test_reports_page_ng() {
    ?>
    <div class="wrap">
        <h1>A/B Test Reports</h1>
        <h2>Launch Date: September 20, 2024</h2>
        <?php
        
        //$start_date = new DateTime('2024-07-31');
        $start_date = new DateTime('2024-09-20');
        // Get the current date
        $current_date = new DateTime();
        
        // Calculate the difference in days
        $interval = $start_date->diff($current_date);
        $days_difference = $interval->days;
        
        // Print the result
        echo "<h2>Number of days from September 20, 2024, to today is: " . $days_difference."</h2>";

        // Generate reports
        display_ab_test_reports();
        echo "<h2>Combined Report</h2>";

        $reports = get_ab_test_reports_ng();
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Design</th>
                    <th>Page Views</th>
                    <th>Mobile Count</th>
                    <th>Desktop Count</th>
                    <th>Add To Cart</th>
                    <th>Purchases</th>
                    <th>Abandon Cart</th>
                    <th>Average Order Value</th>
                    <th>Total Revenue</th>
                    <th>Conversion Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $key=>$report) : ?>
                    <tr>
                        <td><?php echo esc_html($key); ?></td>
                        <td><?php echo esc_html($report['page_views']); ?></td>
                        <td><?php echo esc_html($report['mobile_count']); ?></td>
                        <td><?php echo esc_html($report['desktop_count']); ?></td>
                        <td><?php echo esc_html($report['addtocart']); ?></td>
                        <td><?php echo esc_html($report['purchases']); ?></td>
                        <td><?php echo esc_html($report['abandon_cart']); ?>%</td>
                        <td><?php echo esc_html(number_format($report['avg_order_value'], 2)); ?></td>
                        <td>$<?php echo esc_html(number_format($report['total_revenue'], 2)); ?></td>
                        <td><?php echo esc_html(number_format($report['conversion_rate'], 2) . '%'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Calculations are based on followings definitions</h2>
        <strong>Note: Device tracking began on 29 Aug 2024</strong>
        <ul>
    <li><strong>Design</strong>: The variant of design being tested (e.g., Design v1(Old) vs. Design v2(New)).</li>
    <li><strong>Page Views</strong>: The number of times the variant was viewed by visitors.</li>
    <li><strong>Purchases</strong>: The total number of NG purchases made on the page.</li>
    <li><strong>Average Order Value</strong>: 
        <ul>
            <li>The average amount of money spent per purchase.</li>
            <li>Calculated by dividing the total revenue by the number of purchases. </li>
        </ul>
    </li>
    <li><strong>Total Revenue</strong>: 
        <ul>
            <li>The total amount of money earned from purchases on the page.</li>
            <li>Includes all revenue from items in the cart, which might contain multiple products.</li>
        </ul>
    </li>
    <li><strong>Conversion Rate</strong>: 
        <ul>
            <li>The percentage of visitors who made a purchase.</li>
            <li>Calculated by dividing the number of purchases by the number of page views and then multiplying by 100.</li>
        </ul>
    </li>
</ul>
<style>
        
        .formula-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            max-width: 600px;
            margin: auto;
        }
        .formula-container h2 {
            color: #0056b3;
        }
        .formula {
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0;
        }
        .description {
            margin: 10px 0;
        }
        .formula-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .formula-container th, .formula-container td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .formula-container th {
            background-color: #0056b3;
            color: #fff;
        }
        .formula-container td {
            background-color: #fff;
        }
    </style>
    </div>

    <div class="wrap">
        <h1>Product-Level Reports</h1>
        <h2>Design v1</h2>
        <?php
        // Generate product-level reports for v1
        $reports_v1 = get_product_level_reports_ng('v1');
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Add to cart</th>
                    <th>Purchases</th>
                    <th>Abandon Cart</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports_v1 as $report) : 
                    $page_views = (int)$report['page_views'];
                    $purchases = (int)$report['purchases'];
                    if($page_views ==0 && $purchases>0){
                        continue;
                    }
                    $abandon_rate = round((($page_views - $purchases) / $page_views) * 100);
                    
                    // Ensure the value is within the range 0 to 100
                    $abandon_rate = max(0, min(100, $abandon_rate));
                    
                    ?>
                    <tr>
                        <td><?php echo get_the_title(esc_html($report['product_id'])); ?></td>
                        <td><?php echo esc_html($report['page_views']); ?></td>
                        <td><?php echo esc_html($report['purchases']); ?></td>
                        <td><?php echo $abandon_rate; ?>%</td>
                        <td>$<?php echo esc_html(number_format($report['total_revenue'], 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Design v2</h2>
        <?php
        // Generate product-level reports for v2
        $reports_v2 = get_product_level_reports_ng('v2');
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Add to cart</th>
                    <th>Purchases</th>
                    <th>Abandon Cart</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports_v2 as $report) :
                    $page_views = (int)$report['page_views'];
                    $purchases = (int)$report['purchases'];
                    if($page_views ==0 && $purchases>0){
                        continue;
                    }
                    $abandon_rate = round((($page_views - $purchases) / $page_views) * 100);
                    
                    // Ensure the value is within the range 0 to 100
                    $abandon_rate = max(0, min(100, $abandon_rate));
                    ?>
                    <tr>
                        <td><?php echo get_the_title(esc_html($report['product_id'])); ?></td>
                        <td><?php echo esc_html($report['page_views']); ?></td>
                        <td><?php echo esc_html($report['purchases']); ?></td>
                        <td><?php echo $abandon_rate; ?>%</td>
                        <td>$<?php echo esc_html(number_format($report['total_revenue'], 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Calculations are based on followings definitions</h2>
        <ul>
    <li><strong>Product Title</strong>: The name of the product being reported.</li>
    <li><strong>Add to Cart</strong>: The number of times the product was added to a shopping cart.</li>
    <li><strong>Purchases</strong>: The number of times the product was purchased.</li>
    <li>
        <strong>Abandoned Cart Percentage</strong>
        
        <div class="formula">
            
            <code>
                ((Add To Cart - Purchase) / Add To Cart) × 100
            </code>
        </div>
        </li>
    <li><strong>Total Revenue</strong>: 
        <ul>
            <li>The total amount of money earned from sales of the product.</li>
            <li>Includes the revenue from the product in a cart along with any other products that might also be in the cart.</li>
        </ul>
    </li>
    <li><p></p><strong>Note:</strong> We are using a variable in the cookies. The name of the variable is design_ng_value. This stores the version of the design.This cookie's life is 24 hours. so essentially the design will not change for 24 hours.
     After that the version of the design will be randomly assigned again.Hence it is also possible that the user may see the previous design again</p>


</li>
</ul>
    </div>
    <?php
}


function get_ab_test_reports_ng_old() {
    global $wpdb;
    $table_name_visits = $wpdb->prefix . 'ab_test_visits';
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';

    // Fetch page views
    $page_views = $wpdb->get_results("
        SELECT design, COUNT(*) as views
        FROM $table_name_visits
        GROUP BY design
    ", ARRAY_A);

    // Fetch orders and calculate purchases and total revenue
    $orders = $wpdb->get_results("
        SELECT design, COUNT(order_id) as purchases, SUM(order_item_total) as total_revenue
        FROM (
            SELECT design, order_id, SUM(meta_value) as order_item_total
            FROM $table_name_orders
            JOIN {$wpdb->prefix}woocommerce_order_items ON {$wpdb->prefix}woocommerce_order_items.order_id = $table_name_orders.order_id
            JOIN {$wpdb->prefix}woocommerce_order_itemmeta ON {$wpdb->prefix}woocommerce_order_itemmeta.order_item_id = {$wpdb->prefix}woocommerce_order_items.order_item_id
            WHERE {$wpdb->prefix}woocommerce_order_itemmeta.meta_key = '_line_total'
            GROUP BY design, order_id
        ) as order_details
        GROUP BY design
    ", ARRAY_A);

    // Merge results
    $reports = [];
    foreach ($page_views as $view) {
        $reports[$view['design']] = [
            'design' => $view['design'],
            'page_views' => $view['views'],
            'purchases' => $view['views'],
            'avg_order_value' => 0,
            'total_revenue' => 0,
            'conversion_rate' => 0,
        ];
    }
  
    foreach ($orders as $order) {
        if (isset($reports[$order['design']])) {
            $reports[$order['design']]['purchases'] = $order['purchases'];
            $reports[$order['design']]['total_revenue'] = $order['total_revenue'];
        }
    }

    // Calculate averages and conversion rates
    foreach ($reports as &$report) {
        // Avoid division by zero
        if ($report['purchases'] > 0) {
            $report['avg_order_value'] = $report['total_revenue'] / $report['purchases'];
        }
        if ($report['page_views'] > 0) {
            $report['conversion_rate'] = ($report['purchases'] / $report['page_views']) * 100;
        }
    }

    return $reports;
}


function get_ab_test_reports_ng() {
    global $wpdb;

    // Fetch metrics for design v1
    $page_views_v1 = $wpdb->get_results("
        SELECT design, COUNT(*) AS views
        FROM {$wpdb->prefix}ab_test_visits
        WHERE design = 'v1'
        GROUP BY design
    ", ARRAY_A);
    $unique_devices_v1 = $wpdb->get_results("
    SELECT
        design,
        SUM(CASE WHEN device = 'mobile' THEN 1 ELSE 0 END) AS mobile_count,
        SUM(CASE WHEN device = 'desktop' THEN 1 ELSE 0 END) AS desktop_count
    FROM {$wpdb->prefix}ab_test_visits
    WHERE design = 'v1'
    GROUP BY design
", ARRAY_A);
    $page_addtocart_v1 = $wpdb->get_results(
        $wpdb->prepare(
            "
            SELECT COUNT(*) AS addtocart
            FROM {$wpdb->prefix}ab_test_orders
            WHERE design = %s AND action = %s
            ",
            'v1', // Placeholder for design
            'add_to_cart' // Placeholder for action
        ),
        ARRAY_A
    );
    
    // Print the SQL query for debugging
   
    $purchases_v1 = $wpdb->get_results("
        SELECT design, COUNT( order_id) AS purchases
        FROM {$wpdb->prefix}ab_test_orders
        WHERE design = 'v1'
        GROUP BY design
    ", ARRAY_A);

    $page_addtocart_v2 = $wpdb->get_results(
        $wpdb->prepare(
            "
            SELECT COUNT(*) AS addtocart
            FROM {$wpdb->prefix}ab_test_orders
            WHERE design = %s AND action = %s
            ",
            'v2', // Placeholder for design
            'add_to_cart' // Placeholder for action
        ),
        ARRAY_A
    );
   
    $revenue_v1 = $wpdb->get_results("
        SELECT design, SUM(CAST(meta_value AS DECIMAL(10,2))) AS total_revenue
        FROM {$wpdb->prefix}ab_test_orders
        INNER JOIN {$wpdb->prefix}woocommerce_order_items
            ON {$wpdb->prefix}woocommerce_order_items.order_id = {$wpdb->prefix}ab_test_orders.order_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta
            ON {$wpdb->prefix}woocommerce_order_itemmeta.order_item_id = {$wpdb->prefix}woocommerce_order_items.order_item_id
        WHERE {$wpdb->prefix}woocommerce_order_itemmeta.meta_key = '_line_total'
        AND {$wpdb->prefix}ab_test_orders.design = 'v1'
        GROUP BY design
    ", ARRAY_A);

    // Fetch metrics for design v2
    $page_views_v2 = $wpdb->get_results("
        SELECT design, COUNT(*) AS views
        FROM {$wpdb->prefix}ab_test_visits
        WHERE design = 'v2'
        GROUP BY design
    ", ARRAY_A);
    $unique_devices_v2 = $wpdb->get_results("
    SELECT
        design,
        SUM(CASE WHEN device = 'mobile' THEN 1 ELSE 0 END) AS mobile_count,
        SUM(CASE WHEN device = 'desktop' THEN 1 ELSE 0 END) AS desktop_count
    FROM {$wpdb->prefix}ab_test_visits
    WHERE design = 'v2'
    GROUP BY design
", ARRAY_A);
    $purchases_v2 = $wpdb->get_results("
        SELECT design, COUNT(order_id) AS purchases
        FROM {$wpdb->prefix}ab_test_orders
        WHERE design = 'v2'
        GROUP BY design
    ", ARRAY_A);

    $revenue_v2 = $wpdb->get_results("
        SELECT design, SUM(CAST(meta_value AS DECIMAL(10,2))) AS total_revenue
        FROM {$wpdb->prefix}ab_test_orders
        INNER JOIN {$wpdb->prefix}woocommerce_order_items
            ON {$wpdb->prefix}woocommerce_order_items.order_id = {$wpdb->prefix}ab_test_orders.order_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta
            ON {$wpdb->prefix}woocommerce_order_itemmeta.order_item_id = {$wpdb->prefix}woocommerce_order_items.order_item_id
        WHERE {$wpdb->prefix}woocommerce_order_itemmeta.meta_key = '_line_total'
        AND {$wpdb->prefix}ab_test_orders.design = 'v2'
        GROUP BY design
    ", ARRAY_A);
$total_add_to_cart_v1 = (int) isset($page_addtocart_v1[0]['addtocart']) ? $page_addtocart_v1[0]['addtocart']:0;
$total_add_to_cart_v2 = (int) isset($page_addtocart_v2[0]['addtocart']) ? $page_addtocart_v2[0]['addtocart']:0;

$total_purchase_v1 = (int) isset($purchases_v1[0]['purchases']) ? $purchases_v1[0]['purchases']:0;
$total_purchase_v2 =  (int) isset($purchases_v2[0]['purchases']) ? $purchases_v2[0]['purchases']:0;
    // Combine results into a single array
    // $v1_abandon_cart = round((($total_add_to_cart_v1-$total_purchase_v1)/ $total_add_to_cart_v1)*100);
    // $v2_abandon_cart = round((($total_add_to_cart_v2-$total_purchase_v2)/ $total_add_to_cart_v2)*100);
    $v1_abandon_cart = $total_add_to_cart_v1 > 0 ? round((($total_add_to_cart_v1 - $total_purchase_v1) / $total_add_to_cart_v1) * 100) : 0;
    $v2_abandon_cart = $total_add_to_cart_v2 > 0 ? round((($total_add_to_cart_v2 - $total_purchase_v2) / $total_add_to_cart_v2) * 100) : 0;
    $v1_abandon_cart = max(0, min(100, $v1_abandon_cart));
    $v2_abandon_cart = max(0, min(100, $v2_abandon_cart));

    $reports = [
        'v1' => [
            'page_views' => isset($page_views_v1[0]['views']) ? (int)$page_views_v1[0]['views'] : 0,
            'addtocart' => $total_add_to_cart_v1,
            'abandon_cart' => $v1_abandon_cart,
            'purchases' => $total_purchase_v1,
            'total_revenue' => isset($revenue_v1[0]['total_revenue']) ? (float)$revenue_v1[0]['total_revenue'] : 0,
            'avg_order_value' => 0,
            'conversion_rate' => 0,
            'mobile_count' => $unique_devices_v1[0]['mobile_count'] ?? 0,
            'desktop_count' => $unique_devices_v1[0]['desktop_count'] ?? 0,
        ],
        'v2' => [
            'page_views' => isset($page_views_v2[0]['views']) ? (int)$page_views_v2[0]['views'] : 0,
            'addtocart' => $total_add_to_cart_v2,
            'abandon_cart' => $v2_abandon_cart,
            'purchases' => $total_purchase_v2,
            'total_revenue' => isset($revenue_v2[0]['total_revenue']) ? (float)$revenue_v2[0]['total_revenue'] : 0,
            'avg_order_value' => 0,
            'conversion_rate' => 0,
            'mobile_count' => $unique_devices_v2[0]['mobile_count'] ?? 0,
            'desktop_count' => $unique_devices_v2[0]['desktop_count'] ?? 0,
        ],
    ];

    // Calculate averages and conversion rates
    foreach ($reports as &$report) {
        // Avoid division by zero
        if ($report['purchases'] > 0) {
            $report['avg_order_value'] = $report['total_revenue'] / $report['purchases'];
        }
        if ($report['page_views'] > 0) {
            $report['conversion_rate'] = ($report['purchases'] / $report['page_views']) * 100;
        }
    }

    return $reports;
}



// Fetch product-level reports using existing table
function get_product_level_reports_ng($design) {
    global $wpdb;
    $table_name_orders = $wpdb->prefix . 'ab_test_orders';

    // Fetch product-level stats for the specified design
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT 
            product_id,
            SUM(CASE WHEN action = 'add_to_cart' THEN 1 ELSE 0 END) AS page_views,
            COUNT( CASE WHEN action = 'order' THEN order_id ELSE NULL END) AS purchases,
            SUM(CASE WHEN action = 'order' THEN (SELECT SUM(meta_value) FROM {$wpdb->prefix}woocommerce_order_items oi 
                JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id 
                WHERE oim.meta_key = '_line_total' AND oi.order_id = orders.order_id) ELSE 0 END) AS total_revenue
        FROM $table_name_orders AS orders
        WHERE design = %s
        GROUP BY product_id
    ", $design), ARRAY_A);

    return $results;
}


function enqueue_custom_ajax_script() {
   // wp_enqueue_script('custom-ajax-script', get_template_directory_uri() . '/js/custom-ajax.js', ['jquery'], null, true);

    wp_localize_script('custom-ajax-script', 'custom_ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('custom_ajax_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_script');


function track_visit_ng_ajax() {
    // Debugging
    if (isset($_REQUEST)) {
        error_log(print_r($_REQUEST, true));
    }

    // Optional: Add more detailed debugging
    if (!isset($_POST['design'])) {
        wp_send_json_error('Design parameter missing');
        return;
    }

    // Your original code here
    global $wpdb;

    $session_id = isset($_COOKIE['design_ng_sbr_unique_id']) ? $_COOKIE['design_ng_sbr_unique_id']:'';
    $design = $_POST['design']; // Changed from $_REQUEST to $_POST for consistency
    $table_name_visits = $wpdb->prefix . 'ab_test_visits';
        // Detect device type
        $device = wp_is_mobile() ? 'mobile' : 'desktop';
    // Check if visit is already recorded in this session
    $visit = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name_visits WHERE session_id = %s AND design = %s",
        $session_id,
        $design
    ));

    if ($visit == 0) {
        $wpdb->insert($table_name_visits, [
            'session_id' => $session_id,
            'design' => $design,
            'device' => $device,
        ]);
        wp_send_json_success('Visit recorded');
    } else {
        wp_send_json_success('Visit already recorded');
    }
}
add_action('wp_ajax_track_visit_ng', 'track_visit_ng_ajax');
add_action('wp_ajax_nopriv_track_visit_ng', 'track_visit_ng_ajax');


function get_shortode_rendered_ng() {
    if (!isset($_COOKIE['design_ng_sbr'])) {
        // Set the cookie with a value of either 'v1' or 'v2' and an expiration time of one hour
        $value = rand(0, 1) ? 'v1' : 'v2';
        setcookie('design_ng_sbr', $value, time() + 3600*24, "/"); // 3600 seconds = 1 hour
        setcookie('design_ng_sbr_unique_id', substr(bin2hex(random_bytes(8)), 0, 15), time() + 3600*24, "/");
        $_COOKIE['design_ng_sbr'] = $value;
    }
    $desing_cookie = isset($_COOKIE['design_ng_sbr']) ? $_COOKIE['design_ng_sbr']:'v1';
    
    $desing_html =do_shortcode('[night-guards type=nightguard-system]');
    if( $desing_cookie =='v2'){
        $desing_html =do_shortcode('[night-guards-new type=nightguard-system]');
    }
    $response = array(
        'success' => true,
        'session_desing' => $desing_cookie,
        'desing_html' => $desing_html
    );
    echo json_encode($response);
    die();
}
add_action('wp_ajax_get_shortode_rendered_ng', 'get_shortode_rendered_ng');
add_action('wp_ajax_nopriv_get_shortode_rendered_ng', 'get_shortode_rendered_ng');

// Device based reports

function display_ab_test_reports() {
    $reports = generate_ab_test_reports();

    function render_table($title, $data) {
        echo '<h2>' . esc_html($title) . '</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>
                <th>Page Views</th>
                <th>Add To Cart</th>
                <th>Purchases</th>
                <th>Abandon Cart (%)</th>
                <th>Average Order Value</th>
                <th>Total Revenue</th>
                <th>Conversion Rate (%)</th>
              </tr></thead>';
        echo '<tbody>';
        echo '<tr>
                <td>' . esc_html($data['page_views']) . '</td>
                <td>' . esc_html($data['add_to_cart']) . '</td>
                <td>' . esc_html($data['purchases']) . '</td>
                <td>' . esc_html(number_format($data['abandon_cart'], 2)) . '%</td>
                <td>' . esc_html(number_format($data['average_order_value'], 2)) . '</td>
                <td>' . esc_html(number_format($data['total_revenue'], 2)) . '</td>
                <td>' . esc_html(number_format($data['conversion_rate'], 2)) . '%</td>
              </tr>';
        echo '</tbody></table>';
    }

    render_table('Design v1 Mobile Report', $reports['v1']['mobile']);
    render_table('Design v1 Desktop Report', $reports['v1']['desktop']);
    render_table('Design v2 Mobile Report', $reports['v2']['mobile']);
    render_table('Design v2 Desktop Report', $reports['v2']['desktop']);
}

function generate_ab_test_reports() {
    global $wpdb;

    // Helper function to calculate additional metrics
    function calculate_additional_metrics($design, $device) {
        global $wpdb;

        // Fetch add to cart count
        $add_to_cart = $wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT COUNT(session_id)
                FROM {$wpdb->prefix}ab_test_orders
                WHERE design = %s AND action = %s
                AND session_id IN (
                    SELECT session_id
                    FROM {$wpdb->prefix}ab_test_visits
                    WHERE design = %s AND device = %s
                )
                ",
                $design, 'add_to_cart', $design, $device
            )
        );

        // Fetch purchases count
        $purchases = $wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT COUNT(order_id)
                FROM {$wpdb->prefix}ab_test_orders
                WHERE design = %s AND order_id IS NOT NULL
                AND session_id IN (
                    SELECT session_id
                    FROM {$wpdb->prefix}ab_test_visits
                    WHERE design = %s AND device = %s
                )
                ",
                $design, $design, $device
            )
        );

        // Fetch total revenue
        $total_revenue = $wpdb->get_var(
            $wpdb->prepare(
                "
                SELECT SUM(CAST(meta_value AS DECIMAL(10,2)))
                FROM {$wpdb->prefix}ab_test_orders
                INNER JOIN {$wpdb->prefix}woocommerce_order_items
                    ON {$wpdb->prefix}woocommerce_order_items.order_id = {$wpdb->prefix}ab_test_orders.order_id
                INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta
                    ON {$wpdb->prefix}woocommerce_order_itemmeta.order_item_id = {$wpdb->prefix}woocommerce_order_items.order_item_id
                WHERE {$wpdb->prefix}woocommerce_order_itemmeta.meta_key = '_line_total'
                AND {$wpdb->prefix}ab_test_orders.design = %s
                AND session_id IN (
                    SELECT session_id
                    FROM {$wpdb->prefix}ab_test_visits
                    WHERE design = %s AND device = %s
                )
                ",
                $design, $design, $device
            )
        );

        // Initialize metrics
        $average_order_value = 0;
        $conversion_rate = 0;
        $abandon_cart = 0;

        // Calculate additional metrics
        if ($purchases > 0) {
            $average_order_value = $total_revenue / $purchases;
        }
        if ($add_to_cart > 0) {
            $abandon_cart = (($add_to_cart - $purchases) / $add_to_cart) * 100;
        }

        return array(
            'add_to_cart' => $add_to_cart,
            'purchases' => $purchases,
            'abandon_cart' => $abandon_cart,
            'average_order_value' => $average_order_value,
            'total_revenue' => $total_revenue,
            'conversion_rate' => 0 // Placeholder, will be calculated later
        );
    }

    // Fetch metrics for design v1 (mobile)
    $page_views_v1_mobile = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COUNT(*)
            FROM {$wpdb->prefix}ab_test_visits
            WHERE design = %s AND device = %s
            ",
            'v1', 'mobile'
        )
    );
    $metrics_v1_mobile = calculate_additional_metrics('v1', 'mobile');
    if ($page_views_v1_mobile > 0) {
        $metrics_v1_mobile['conversion_rate'] = ($metrics_v1_mobile['purchases'] / $page_views_v1_mobile) * 100;
    }

    // Fetch metrics for design v1 (desktop)
    $page_views_v1_desktop = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COUNT(*)
            FROM {$wpdb->prefix}ab_test_visits
            WHERE design = %s AND device = %s
            ",
            'v1', 'desktop'
        )
    );
    $metrics_v1_desktop = calculate_additional_metrics('v1', 'desktop');
    if ($page_views_v1_desktop > 0) {
        $metrics_v1_desktop['conversion_rate'] = ($metrics_v1_desktop['purchases'] / $page_views_v1_desktop) * 100;
    }

    // Fetch metrics for design v2 (mobile)
    $page_views_v2_mobile = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COUNT(*)
            FROM {$wpdb->prefix}ab_test_visits
            WHERE design = %s AND device = %s
            ",
            'v2', 'mobile'
        )
    );
    $metrics_v2_mobile = calculate_additional_metrics('v2', 'mobile');
    if ($page_views_v2_mobile > 0) {
        $metrics_v2_mobile['conversion_rate'] = ($metrics_v2_mobile['purchases'] / $page_views_v2_mobile) * 100;
    }

    // Fetch metrics for design v2 (desktop)
    $page_views_v2_desktop = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COUNT(*)
            FROM {$wpdb->prefix}ab_test_visits
            WHERE design = %s AND device = %s
            ",
            'v2', 'desktop'
        )
    );
    $metrics_v2_desktop = calculate_additional_metrics('v2', 'desktop');
    if ($page_views_v2_desktop > 0) {
        $metrics_v2_desktop['conversion_rate'] = ($metrics_v2_desktop['purchases'] / $page_views_v2_desktop) * 100;
    }

    // Organize data into tables
    $reports = array(
        'v1' => array(
            'mobile' => array_merge(array('page_views' => $page_views_v1_mobile), $metrics_v1_mobile),
            'desktop' => array_merge(array('page_views' => $page_views_v1_desktop), $metrics_v1_desktop)
        ),
        'v2' => array(
            'mobile' => array_merge(array('page_views' => $page_views_v2_mobile), $metrics_v2_mobile),
            'desktop' => array_merge(array('page_views' => $page_views_v2_desktop), $metrics_v2_desktop)
        )
    );

    return $reports;
}