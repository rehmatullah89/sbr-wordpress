
<script type="application/javascript" src="//cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>

<?php
function fetch_reports_data(){
    global $wpdb;

    echo "<br/><h1>Shipping Protection Reports</h1>";
    echo "<h2>Launch Date: October 16, 2024</h2>";
    
    //$start_date = new DateTime('2024-07-31');
    $start_date = new DateTime('2024-10-16');
    $current_date = new DateTime();
    
    // Calculate the difference in days
    $interval = $start_date->diff($current_date);
    $days_difference = $interval->days;

    // Print the date
    echo "<h2>Number of days from October 16, 2024, to today is: " . $days_difference."</h2>";


    $query = "SELECT 
    `price`, 
    `mobile`, 
    `viewed`, 
    `desktop`
    FROM 
        `shipping_protection_report`
    WHERE `type` = 'non-ng'";

    $view_result = $wpdb->get_results($query);   
    echo '<br/><br/><h2>Over all views for Non-Night Guard & Non-Whitening Products </h2>';
    echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    echo '<thead><tr>
    <th style="width: 80px; background-color: #add8e6;">Price</th>
    <th style="width: 120px; background-color: #add8e6;">Mobile Views</th>
    <th style="width: 120px; background-color: #add8e6;">Desktop Views</th>
    <th style="width: 120px; background-color: #add8e6;">Total Views</th>
    </tr></thead>';
    echo '<tbody>';


    foreach($view_result as $data) {
        
        // Output row
        echo "<tr>
                <td>".$data->price."</td>
                <td>".$data->mobile."</td>
                <td>".$data->desktop."</td>
                <td>".$data->viewed."</td>
            </tr>";
    }
    
    echo '</tbody>';
    echo '</table>';
    //################Desktop Views for Night Guard###################
    $query = "SELECT 
            `price`, 
            `price_id`, 
            `action`,
            `device`, 
            COUNT(*) AS action_count
        FROM 
            `shipping_protection_report_visits`
        WHERE device = 'desktop_ng'    
        GROUP BY 
            `price`, `action`
        ORDER BY 
            `price`, `action`";
    $result = $wpdb->get_results($query);

    
    // echo '<br/><br/><h2>Desktop Views for Night Guard & Whitening Products</h2>';
    // echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    // echo '<thead><tr><th>Desktop Views</th><th>Price</th><th>Accepted</th><th>Rejected</th><th>Redeemed >= 35</th><th>Redeemed < 35</th><th>Total Revenue</th>
    //         <th>Success Ratio (%) <span  id="formula_gross_margin">$${Accepted\over {Views}} x 100$$ </span></th>
    //         <th>Rejection Ratio (%) <span  id="formula_gross_margin">$${Rejected\over {Views}} x 100$$ </span></th>
    //         <th>Conversion Rate (%) <span  id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$ </span></th>
    //         </tr></thead>';
    // echo '<tbody>';
    
    $dataList = [];
    foreach($result as $data) {
        if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NG))
        {
            if (!isset($dataList[$data->price])) {
                $dataList[$data->price] = [
                    'price' => $data->price, 
                    'revenue' => 0, 
                    'redeemed_gt35' => 0, 
                    'redeemed_lt35' => 0, 
                    'viewed_ng' => 0, 
                    'redeemed_ng' => 0, 
                    'removed_ng' => 0
                ];
            }
            
            // Get revenue for the price
            if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
                $dataList[$data->price]['revenue'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d",
                        'ng', 'desktop_ng', $data->price_id
                    )
                );

                $dataList[$data->price]['redeemed_gt35'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as redeemed_gt35 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d",
                        'ng', 'desktop_ng', $data->price_id, 35
                    )
                );

                $dataList[$data->price]['redeemed_lt35'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as redeemed_lt35 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d",
                        'ng', 'desktop_ng', $data->price_id, 35
                    )
                );
            }

            // Populate the action counts
            if ($data->action == 'viewed_ng') {
                $dataList[$data->price]['viewed_ng'] = (int)$data->action_count;
            } elseif ($data->action == 'redeemed_ng') {
                $dataList[$data->price]['redeemed_ng'] = (int)$data->action_count;
            } elseif ($data->action == 'removed_ng') {
                $dataList[$data->price]['removed_ng'] = (int)$data->action_count;
            }
        }
    }

    // Output the data
    foreach($dataList as $data) {
        $viewed_ng = $data['viewed_ng'];
        $redeemed_ng = $data['redeemed_ng'];
        $removed_ng = $data['removed_ng'];
        $revenue = $data['revenue'];
        $redeemed_gt35 = $data['redeemed_gt35'];
        $redeemed_lt35 = $data['redeemed_lt35'];

        // Calculate ratios
        $success_ratio = $viewed_ng > 0 ? ($redeemed_ng / $viewed_ng) * 100 : 0;
        $cancellation_ratio = $viewed_ng > 0 ? ($removed_ng / $viewed_ng) * 100 : 0;
        $engagement_rate = $viewed_ng > 0 ? (($redeemed_ng + $removed_ng) / $viewed_ng) * 100 : 0;

        // Output row
        // echo "<tr>
        //         <td>".$viewed_ng."</td>
        //         <td> $".$data['price']."</td>
        //         <td>".$redeemed_ng."</td>
        //         <td>".$removed_ng."</td>
        //         <td>".$redeemed_gt35."</td>
        //         <td>".$redeemed_lt35."</td>
        //         <td>$".number_format($revenue, 2)."</td>
        //         <td>".number_format($success_ratio, 2)."%</td>
        //         <td>".number_format($cancellation_ratio, 2)."%</td>
        //         <td>".number_format($engagement_rate, 2)."%</td>
        //       </tr>";
    }
    
    // echo '</tbody>';
    // echo '</table>';

    //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    //################Mobile Views for Night Guard###################
    $query = "SELECT 
        `price`, 
        `price_id`, 
        `action`,
        `device`, 
        COUNT(*) AS action_count
    FROM 
        `shipping_protection_report_visits`
    WHERE device = 'mobile_ng'    
    GROUP BY 
        `price`, `action`
    ORDER BY 
        `price`, `action`";
    $result = $wpdb->get_results($query);

    // echo '<br/><br/><h2>Mobile Views for Night Guard & Whitening Products</h2>';
    // echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    // echo '<thead><tr><th>Mobile Views</th><th>Price</th><th>Accepted</th><th>Rejected</th><th>Redeemed >= 35</th><th>Redeemed < 35</th><th>Total Revenue</th>
    //     <th>Success Ratio (%) <span  id="formula_gross_margin">$${Accepted\over {Views}} x 100$$ </span></th>
    //     <th>Rejection Ratio (%) <span  id="formula_gross_margin">$${Rejected\over {Views}} x 100$$ </span></th>
    //     <th>Conversion Rate (%) <span  id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$ </span></th>
    //     </tr></thead>';
    // echo '<tbody>';

    $dataList = [];
    foreach($result as $data) {
    if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NG))
    {
        if (!isset($dataList[$data->price])) {
            $dataList[$data->price] = [
                'price' => $data->price, 
                'revenue' => 0, 
                'redeemed_gt35' => 0, 
                'redeemed_lt35' => 0, 
                'viewed_ng' => 0, 
                'redeemed_ng' => 0, 
                'removed_ng' => 0
            ];
        }
        
        // Get revenue for the price
        if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
            $dataList[$data->price]['revenue'] = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                    FROM shipping_protection_report_orders 
                    WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d",
                    'ng', 'mobile_ng', $data->price_id
                )
            );

            $dataList[$data->price]['redeemed_gt35'] = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(1) as redeemed_gt35 
                    FROM shipping_protection_report_orders 
                    WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d",
                    'ng', 'mobile_ng', $data->price_id, 35
                )
            );

            $dataList[$data->price]['redeemed_lt35'] = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(1) as redeemed_lt35 
                    FROM shipping_protection_report_orders 
                    WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d",
                    'ng', 'mobile_ng', $data->price_id, 35
                )
            );
        }

        // Populate the action counts
        if ($data->action == 'viewed_ng') {
            $dataList[$data->price]['viewed_ng'] = (int)$data->action_count;
        } elseif ($data->action == 'redeemed_ng') {
            $dataList[$data->price]['redeemed_ng'] = (int)$data->action_count;
        } elseif ($data->action == 'removed_ng') {
            $dataList[$data->price]['removed_ng'] = (int)$data->action_count;
        }
    }
    }

    // Output the data
    foreach($dataList as $data) {
    $viewed_ng = $data['viewed_ng'];
    $redeemed_ng = $data['redeemed_ng'];
    $removed_ng = $data['removed_ng'];
    $revenue = $data['revenue'];
    $redeemed_gt35 = $data['redeemed_gt35'];
    $redeemed_lt35 = $data['redeemed_lt35'];

    // Calculate ratios
    $success_ratio = $viewed_ng > 0 ? ($redeemed_ng / $viewed_ng) * 100 : 0;
    $cancellation_ratio = $viewed_ng > 0 ? ($removed_ng / $viewed_ng) * 100 : 0;
    $engagement_rate = $viewed_ng > 0 ? (($redeemed_ng + $removed_ng) / $viewed_ng) * 100 : 0;

    // Output row
    // echo "<tr>
    //         <td>".$viewed_ng."</td>
    //         <td> $".$data['price']."</td>
    //         <td>".$redeemed_ng."</td>
    //         <td>".$removed_ng."</td>
    //         <td>".$redeemed_gt35."</td>
    //         <td>".$redeemed_lt35."</td>
    //         <td>$".number_format($revenue, 2)."</td>
    //         <td>".number_format($success_ratio, 2)."%</td>
    //         <td>".number_format($cancellation_ratio, 2)."%</td>
    //         <td>".number_format($engagement_rate, 2)."%</td>
    //     </tr>";
    }

    // echo '</tbody>';
    // echo '</table>';

    //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //##############Combined Night Guards Report #############
    $table_name = 'shipping_protection_report';
    $query = "SELECT (SELECT COALESCE(SUM(shipping_protection_report_price),0) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`='ng') as revenue, 
    (SELECT COUNT(1) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`='ng' AND shipping_protection_report_price >= 35) as redeemed_gt35, 
    (SELECT COUNT(1) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`='ng' AND shipping_protection_report_price < 35) as redeemed_lt35, 
                price, viewed_ng, redeemed_ng, removed_ng, mobile_ng, desktop_ng FROM $table_name WHERE type In ('all','ng')";
    $result = $wpdb->get_results($query);

    // Initialize an associative array to store success and cancellation ratios for each price
    $ratios2 = [];
    if($result){
   
        foreach ($result as $row) {
            $revenue = $row->revenue;
            $redeemed_gt35 = $row->redeemed_gt35;
            $redeemed_lt35 = $row->redeemed_lt35;
            $price = $row->price;
            $viewed_ng = $row->viewed_ng;
            $redeemed_ng = $row->redeemed_ng;
            $removed_ng = $row->removed_ng;
            $mobile_ng = $row->mobile_ng;
            $desktop_ng = $row->desktop_ng;
    
            // Calculate success ratio (redeemed_ng / viewed_ng) and cancellation ratio (removed_ng / viewed_ng)
            $success_ratio = $viewed_ng > 0 ? ($redeemed_ng / $viewed_ng) * 100 : 0;
            $cancellation_ratio = $viewed_ng > 0 ? ($removed_ng / $viewed_ng) * 100 : 0;
            $engagement_rate = $viewed_ng > 0 ? (($redeemed_ng + $removed_ng) / $viewed_ng) * 100 : 0;
    
            // Store the ratios for the current price
            $ratios2[$price] = [
                'success_ratio' => $success_ratio,
                'cancellation_ratio' => $cancellation_ratio,
                'engagement_rate' => $engagement_rate,
                'revenue'=>$revenue,
                'redeemed_gt35'=>$redeemed_gt35,
                'redeemed_lt35'=>$redeemed_lt35,
                'viewed_ng'=>$viewed_ng,
                'mobile_ng'=>$mobile_ng,
                'desktop_ng'=>$desktop_ng,
                'redeemed_ng'=>$redeemed_ng,
                'removed_ng'=>$removed_ng
    
            ];
        }
        // <span  id="formula_gross_margin">$${{Price - Discount - Cost}\over {Price - Discount}} x 100$$ </span>
        // Sort the array by success ratio in descending order
        arsort($ratios2);

    // echo '<br/><br/><h2>Combined Report for Night Guard & Whitening Products</h2>';
    // echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    // echo '<thead><tr><th>Combined Views</th><th>Price</th><th>Accepted</th><th>Rejected</th><th>Mobile Count</th><th>Desktop Count</th><th>Redeemed >= 35</th><th>Redeemed < 35</th><th>Total Revenue</th>
    //     <th>Success Ratio (%) <span  id="formula_gross_margin">$${Accepted\over {Views}} x 100$$ </span></th>
    //     <th>Rejection Ratio (%) <span  id="formula_gross_margin">$${Rejected\over {Views}} x 100$$ </span></th>
    //     <th>Conversion Rate (%) <span  id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$ </span></th>
    //     </tr></thead>';
    // echo '<tbody>';
    foreach ($ratios2 as $price => $ratio) {
        $success_ratio = number_format($ratio['success_ratio'], 2); // Limiting to two decimal places
        $cancellation_ratio = number_format($ratio['cancellation_ratio'], 2); // Limiting to two decimal places
        $engagement_rate = number_format($ratio['engagement_rate'], 2); // Limiting to two decimal places
        $revenue = number_format((double)$ratio['revenue'],2);
        $viewed_ng = $ratio['viewed_ng'];
        $redeemed_gt35 = $ratio['redeemed_gt35'];
        $redeemed_lt35 = $ratio['redeemed_lt35'];
        $redeemed_ng = $ratio['redeemed_ng'];
        $removed_ng = $ratio['removed_ng'];
        $mobile_ng = $ratio['mobile_ng'];
        $desktop_ng = $ratio['desktop_ng'];
       // echo "<tr><td>$viewed_ng</td><td> $$price</td><td>$redeemed_ng</td><td>$removed_ng</td><td>$mobile_ng</td><td>$desktop_ng</td><td>$redeemed_gt35</td><td>$redeemed_lt35</td><td>".$revenue."</td><td>$success_ratio%</td><td>$cancellation_ratio%</td><td>$engagement_rate%</td></tr>";
    }
    // echo '</tbody>';
    // echo '</table>';
}else{
   /// echo 'No data available';
}


    //################Desktop Views for NON-Night Guard###################
    $query = "SELECT 
    `price`, 
    `price_id`, 
    `action`,
    `device`, 
    COUNT(*) AS action_count
    FROM 
    `shipping_protection_report_visits`
    WHERE device = 'desktop'    
    GROUP BY 
    `price`, `action`
    ORDER BY 
    `price`, `action`";
    $result = $wpdb->get_results($query);

    echo '<br/><br/>';
    echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    echo '<thead><tr><td colspan="8" style="width: 120px; background-color: #7CB9E8; text-align:center;"><h2>Non-Night Guard & Non-Whitening Products for Order Checkout Value >= 35</h2></td></tr></thead>';
    echo '<thead><tr>
    <th style="width: 80px; background-color: #89CFF0;">Price</th>
    <th style="width: 100px; background-color: #89CFF0;">Accepted</th>
    <th style="width: 100px; background-color: #89CFF0;">Rejected</th>
    <th style="width: 150px; background-color: #89CFF0;">Avg Checkout Value</th>
    <th style="width: 130px; background-color: #89CFF0;">Total Revenue</th>
    <th style="width: 170px; background-color: #89CFF0;">Success Ratio (%) <span id="formula_gross_margin">$${Accepted\over {Views}} x 100$$</span></th>
    <th style="width: 170px; background-color: #89CFF0;">Rejection Ratio (%) <span id="formula_gross_margin">$${Rejected\over {Views}} x 100$$</span></th>
    <th style="width: 200px; background-color: #89CFF0;">Conversion Rate (%) <span id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$</span></th>
    </tr></thead>';
    echo '<tbody>';

    $dataList = [];
    foreach($result as $data) {
        if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NON_NG))
        {
            $order_count = 0;
            if (!isset($dataList[$data->price])) {
                $dataList[$data->price] = [
                    'price' => $data->price, 
                    'avg_value' => 0, 
                    'revenue' => 0, 
                    'accepted' => 0, 
                    'rejected' => 0,
                    'viewed' => 0, 
                ];
            }

            // Get revenue for the price
            if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
                $dataList[$data->price]['revenue'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d",
                        'non_ng', 'desktop', $data->price_id, 35
                    )
                );

                $dataList[$data->price]['accepted'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as accepted 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d AND `action` = %s",
                        'non_ng', 'desktop', $data->price_id, 35, 'order'
                    )
                );

                $dataList[$data->price]['rejected'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as rejected 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d AND `action` = %s",
                        'non_ng', 'desktop', $data->price_id, 35, 'cart'
                    )
                );
            }

            $order_count = $dataList[$data->price]['rejected'] + $dataList[$data->price]['accepted'];

            // Populate the action counts
            if ($data->action == 'viewed') {
                $dataList[$data->price]['viewed'] = (int)$data->action_count;
            }
            $dataList[$data->price]['avg_value'] = $order_count>0?($dataList[$data->price]['revenue']/$order_count):0;
        }
    }

    // Output the data
    foreach($dataList as $data) {
    $viewed_ng = $data['viewed'];
    $revenue = $data['revenue'];
    $accepted = $data['accepted'];
    $rejected = $data['rejected'];
    $avg_value = $data['avg_value'];

    // Calculate ratios
    $success_ratio = $viewed_ng > 0 ? ($accepted / $viewed_ng) * 100 : 0;
    $cancellation_ratio = $viewed_ng > 0 ? ($rejected / $viewed_ng) * 100 : 0;
    $engagement_rate = $viewed_ng > 0 ? (($accepted + $rejected) / $viewed_ng) * 100 : 0;

    // Output row
    echo "<tr>
            <td> $".$data['price']."</td>
            <td>".number_format($accepted, 2)."</td>
            <td>".number_format($rejected, 2)."</td>
            <td>".number_format($avg_value, 2)."</td>
            <td>$".number_format($revenue, 2)."</td>
            <td>".number_format($success_ratio, 2)."%</td>
            <td>".number_format($cancellation_ratio, 2)."%</td>
            <td>".number_format($engagement_rate, 2)."%</td>
          </tr>";
    }

    echo '</tbody>';
    echo '</table>';

    //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    //################Mobile Views for Night Guard###################
    $query = "SELECT 
    `price`, 
    `price_id`, 
    `action`,
    `device`, 
    COUNT(*) AS action_count
    FROM 
    `shipping_protection_report_visits`
    WHERE device = 'mobile'    
    GROUP BY 
    `price`, `action`
    ORDER BY 
    `price`, `action`";
    $result = $wpdb->get_results($query);

    // echo '<br/><br/><h2>Mobile Views for Non-Night Guard & Non-Whitening Products</h2>';
    echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    echo '<thead><tr>
    <th style="width: 80px; background-color: #89CFF0;">Price</th>
    <th style="width: 100px; background-color: #89CFF0;">Accepted</th>
    <th style="width: 100px; background-color: #89CFF0;">Rejected</th>
    <th style="width: 150px; background-color: #89CFF0;">Avg Checkout Value</th>
    <th style="width: 130px; background-color: #89CFF0;">Total Revenue</th>
    <th style="width: 170px; background-color: #89CFF0;">Success Ratio (%) <span id="formula_gross_margin">$${Accepted\over {Views}} x 100$$</span></th>
    <th style="width: 170px; background-color: #89CFF0;">Rejection Ratio (%) <span id="formula_gross_margin">$${Rejected\over {Views}} x 100$$</span></th>
    <th style="width: 200px; background-color: #89CFF0;">Conversion Rate (%) <span id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$</span></th>
    </tr></thead>';
    echo '<tbody>';

    $dataList = [];
    foreach($result as $data) {
        if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NON_NG))
        {
            $order_count = 0;
            if (!isset($dataList[$data->price])) {
                $dataList[$data->price] = [
                    'price' => $data->price, 
                    'avg_value' => 0, 
                    'revenue' => 0, 
                    'accepted' => 0, 
                    'rejected' => 0,
                    'viewed' => 0, 
                ];
            }

            // Get revenue for the price
            if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
                $dataList[$data->price]['revenue'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d",
                        'non_ng', 'mobile', $data->price_id, 35
                    )
                );

                $dataList[$data->price]['accepted'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as accepted 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d AND `action` = %s",
                        'non_ng', 'mobile', $data->price_id, 35, 'order'
                    )
                );

                $dataList[$data->price]['rejected'] = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(1) as rejected 
                        FROM shipping_protection_report_orders 
                        WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price >= %d AND `action` = %s",
                        'non_ng', 'mobile', $data->price_id, 35, 'cart'
                    )
                );
            }

            $order_count = $dataList[$data->price]['rejected'] + $dataList[$data->price]['accepted'];

            // Populate the action counts
            if ($data->action == 'viewed') {
                $dataList[$data->price]['viewed'] = (int)$data->action_count;
            }
            $dataList[$data->price]['avg_value'] = $order_count>0?($dataList[$data->price]['revenue']/$order_count):0;
        }
    }

    // Output the data
    foreach($dataList as $data) {
    $viewed_ng = $data['viewed'];
    $revenue = $data['revenue'];
    $accepted = $data['accepted'];
    $rejected = $data['rejected'];
    $avg_value = $data['avg_value'];

    // Calculate ratios
    $success_ratio = $viewed_ng > 0 ? ($accepted / $viewed_ng) * 100 : 0;
    $cancellation_ratio = $viewed_ng > 0 ? ($rejected / $viewed_ng) * 100 : 0;
    $engagement_rate = $viewed_ng > 0 ? (($accepted + $rejected) / $viewed_ng) * 100 : 0;

    // Output row
    echo "<tr>
            <td> $".$data['price']."</td>
            <td>".number_format($accepted, 2)."</td>
            <td>".number_format($rejected, 2)."</td>
            <td>$".number_format($avg_value, 2)."</td>
            <td>$".number_format($revenue, 2)."</td>
            <td>".number_format($success_ratio, 2)."%</td>
            <td>".number_format($cancellation_ratio, 2)."%</td>
            <td>".number_format($engagement_rate, 2)."%</td>
          </tr>";
    }

    echo '</tbody>';
    echo '</table>';

    //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 //################Desktop Views for NON-Night Guard < 35###################
    $query = "SELECT 
    `price`, 
    `price_id`, 
    `action`,
    `device`, 
    COUNT(*) AS action_count
    FROM 
    `shipping_protection_report_visits`
    WHERE device = 'desktop'    
    GROUP BY 
    `price`, `action`
    ORDER BY 
    `price`, `action`";
    $result = $wpdb->get_results($query);

    echo '<br/><br/>';
    echo '<table class="table-reporting" style="margin-top: 1px !important;">';
    echo '<thead><tr><td colspan="8" style="width: 120px; background-color: #C19A6B; text-align:center;"><h2>Non-Night Guard & Non-Whitening Products for Order Checkout Value < 35</h2></td></tr></thead>';
    echo '<thead><tr>
    <th style="width: 80px; background-color: #F2D2BD;">Price</th>
    <th style="width: 100px; background-color: #F2D2BD;">Accepted</th>
    <th style="width: 100px; background-color: #F2D2BD;">Rejected</th>
    <th style="width: 150px; background-color: #F2D2BD;">Avg Checkout Value</th>
    <th style="width: 130px; background-color: #F2D2BD;">Total Revenue</th>
    <th style="width: 170px; background-color: #F2D2BD;">Success Ratio (%) <span id="formula_gross_margin">$${Accepted\over {Views}} x 100$$</span></th>
    <th style="width: 170px; background-color: #F2D2BD;">Rejection Ratio (%) <span id="formula_gross_margin">$${Rejected\over {Views}} x 100$$</span></th>
    <th style="width: 200px; background-color: #F2D2BD;">Conversion Rate (%) <span id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$</span></th>
    </tr></thead>';
    echo '<tbody>';

 $dataList = [];
 foreach($result as $data) {
     if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NON_NG))
     {
         $order_count = 0;
         if (!isset($dataList[$data->price])) {
             $dataList[$data->price] = [
                 'price' => $data->price, 
                 'avg_value' => 0, 
                 'revenue' => 0, 
                 'accepted' => 0, 
                 'rejected' => 0,
                 'viewed' => 0, 
             ];
         }

         // Get revenue for the price
         if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
             $dataList[$data->price]['revenue'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d",
                     'non_ng', 'desktop', $data->price_id, 35
                 )
             );

             $dataList[$data->price]['accepted'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COUNT(1) as accepted 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d AND `action` = %s",
                     'non_ng', 'desktop', $data->price_id, 35, 'order'
                 )
             );

             $dataList[$data->price]['rejected'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COUNT(1) as rejected 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d AND `action` = %s",
                     'non_ng', 'desktop', $data->price_id, 35, 'cart'
                 )
             );
         }

         $order_count = $dataList[$data->price]['rejected'] + $dataList[$data->price]['accepted'];

         // Populate the action counts
         if ($data->action == 'viewed') {
             $dataList[$data->price]['viewed'] = (int)$data->action_count;
         }
         $dataList[$data->price]['avg_value'] = $order_count>0?($dataList[$data->price]['revenue']/$order_count):0;
     }
 }

 // Output the data
 foreach($dataList as $data) {
 $viewed_ng = $data['viewed'];
 $revenue = $data['revenue'];
 $accepted = $data['accepted'];
 $rejected = $data['rejected'];
 $avg_value = $data['avg_value'];

 // Calculate ratios
 $success_ratio = $viewed_ng > 0 ? ($accepted / $viewed_ng) * 100 : 0;
 $cancellation_ratio = $viewed_ng > 0 ? ($rejected / $viewed_ng) * 100 : 0;
 $engagement_rate = $viewed_ng > 0 ? (($accepted + $rejected) / $viewed_ng) * 100 : 0;

 // Output row
 echo "<tr>
         <td> $".$data['price']."</td>
         <td>".number_format($accepted, 2)."</td>
         <td>".number_format($rejected, 2)."</td>
         <td>".number_format($avg_value, 2)."</td>
         <td>$".number_format($revenue, 2)."</td>
         <td>".number_format($success_ratio, 2)."%</td>
         <td>".number_format($cancellation_ratio, 2)."%</td>
         <td>".number_format($engagement_rate, 2)."%</td>
       </tr>";
 }

 echo '</tbody>';
 echo '</table>';

 //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

 //################Mobile Views for Night Guard < 35 ###################
 $query = "SELECT 
 `price`, 
 `price_id`, 
 `action`,
 `device`, 
 COUNT(*) AS action_count
 FROM 
 `shipping_protection_report_visits`
 WHERE device = 'mobile'    
 GROUP BY 
 `price`, `action`
 ORDER BY 
 `price`, `action`";
 $result = $wpdb->get_results($query);

 // echo '<br/><br/><h2>Mobile Views for Non-Night Guard & Non-Whitening Products</h2>';
 echo '<table class="table-reporting" style="margin-top: 1px !important;">';
 echo '<thead><tr>
 <th style="width: 80px; background-color: #F2D2BD;">Price</th>
 <th style="width: 100px; background-color: #F2D2BD;">Accepted</th>
 <th style="width: 100px; background-color: #F2D2BD;">Rejected</th>
 <th style="width: 150px; background-color: #F2D2BD;">Avg Checkout Value</th>
 <th style="width: 130px; background-color: #F2D2BD;">Total Revenue</th>
 <th style="width: 170px; background-color: #F2D2BD;">Success Ratio (%) <span id="formula_gross_margin">$${Accepted\over {Views}} x 100$$</span></th>
 <th style="width: 170px; background-color: #F2D2BD;">Rejection Ratio (%) <span id="formula_gross_margin">$${Rejected\over {Views}} x 100$$</span></th>
 <th style="width: 200px; background-color: #F2D2BD;">Conversion Rate (%) <span id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$</span></th>
 </tr></thead>';
 echo '<tbody>';

 $dataList = [];
 foreach($result as $data) {
     if(in_array($data->price, SHIPPING_PROTECTION_PRICES_NON_NG))
     {
         $order_count = 0;
         if (!isset($dataList[$data->price])) {
             $dataList[$data->price] = [
                 'price' => $data->price, 
                 'avg_value' => 0, 
                 'revenue' => 0, 
                 'accepted' => 0, 
                 'rejected' => 0,
                 'viewed' => 0, 
             ];
         }

         // Get revenue for the price
         if ($data->price_id > 0 && $dataList[$data->price]['revenue'] == 0) {
             $dataList[$data->price]['revenue'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COALESCE(SUM(shipping_protection_report_price), 0) as revenue 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d",
                     'non_ng', 'mobile', $data->price_id, 35
                 )
             );

             $dataList[$data->price]['accepted'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COUNT(1) as accepted 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d AND `action` = %s",
                     'non_ng', 'mobile', $data->price_id, 35, 'order'
                 )
             );

             $dataList[$data->price]['rejected'] = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT COUNT(1) as rejected 
                     FROM shipping_protection_report_orders 
                     WHERE `type` = %s AND device = %s AND shipping_protection_report_id = %d AND shipping_protection_report_price < %d AND `action` = %s",
                     'non_ng', 'mobile', $data->price_id, 35, 'cart'
                 )
             );
         }

         $order_count = $dataList[$data->price]['rejected'] + $dataList[$data->price]['accepted'];

         // Populate the action counts
         if ($data->action == 'viewed') {
             $dataList[$data->price]['viewed'] = (int)$data->action_count;
         }
         $dataList[$data->price]['avg_value'] = $order_count>0?($dataList[$data->price]['revenue']/$order_count):0;
     }
 }

 // Output the data
 foreach($dataList as $data) {
 $viewed_ng = $data['viewed'];
 $revenue = $data['revenue'];
 $accepted = $data['accepted'];
 $rejected = $data['rejected'];
 $avg_value = $data['avg_value'];

 // Calculate ratios
 $success_ratio = $viewed_ng > 0 ? ($accepted / $viewed_ng) * 100 : 0;
 $cancellation_ratio = $viewed_ng > 0 ? ($rejected / $viewed_ng) * 100 : 0;
 $engagement_rate = $viewed_ng > 0 ? (($accepted + $rejected) / $viewed_ng) * 100 : 0;

 // Output row
 echo "<tr>
         <td> $".$data['price']."</td>
         <td>".number_format($accepted, 2)."</td>
         <td>".number_format($rejected, 2)."</td>
         <td>$".number_format($avg_value, 2)."</td>
         <td>$".number_format($revenue, 2)."</td>
         <td>".number_format($success_ratio, 2)."%</td>
         <td>".number_format($cancellation_ratio, 2)."%</td>
         <td>".number_format($engagement_rate, 2)."%</td>
       </tr>";
 }

 echo '</tbody>';
 echo '</table>';

 //~!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $query = "SELECT (SELECT COALESCE(SUM(shipping_protection_report_price),0) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`!='ng') as revenue, 
    (SELECT COUNT(1) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`!='ng' AND shipping_protection_report_price >= 35) as redeemed_gt35, 
    (SELECT COUNT(1) FROM shipping_protection_report_orders where shipping_protection_report_id = shipping_protection_report.id AND `type`!='ng' AND shipping_protection_report_price < 35) as redeemed_lt35, 
    price, viewed,redeemed, removed, mobile, desktop FROM $table_name WHERE type IN ('all', 'non-ng')";
    $result = $wpdb->get_results($query);

    // Initialize an associative array to store success and cancellation ratios for each price
    $ratios = [];
    // Iterate over the fetched data
    if($result){
       
        foreach ($result as $row) {
            $price = $row->price;
            $revenue = $row->revenue;
            $redeemed_gt35 = $row->redeemed_gt35;
            $redeemed_lt35 = $row->redeemed_lt35;
            $viewed = $row->viewed;
            $redeemed = $row->redeemed;
            $removed = $row->removed;
            $mobile = $row->mobile;
            $desktop = $row->desktop;
    
            // Calculate success ratio (redeemed / viewed) and cancellation ratio (removed / viewed)
            $success_ratio = $viewed > 0 ? ($redeemed / $viewed) * 100 : 0;
            $cancellation_ratio = $viewed > 0 ? ($removed / $viewed) * 100 : 0;
            $engagement_rate = $viewed > 0 ? (($redeemed + $removed) / $viewed) * 100 : 0;
            // Store the ratios for the current price
            $ratios[$price] = [
                'success_ratio' => $success_ratio,
                'cancellation_ratio' => $cancellation_ratio,
                'engagement_rate' => $engagement_rate,
                'revenue'=>$revenue,
                'redeemed_gt35'=>$redeemed_gt35,
                'redeemed_lt35'=>$redeemed_lt35,
                'viewed'=>$viewed,
                'mobile'=>$mobile,
                'desktop'=>$desktop,
                'redeemed'=>$redeemed,
                'removed'=>$removed
    
            ];
        }
    
        // Sort the array by success ratio in descending order
        arsort($ratios);
    
        // Output the success and cancellation ratios in a table
        // echo '<h2 style="margin-top: 45px;">Non-Night Guard & Non-Whitening Products</h2>';
        // echo '<table class="table-reporting">';
        // echo '<thead><tr><th>Combined Views</th><th>Price</th><th>Accepted</th><th>Rejected</th><th>Mobile Count</th><th>Desktop Count</th><th>Redeemed >= 35</th><th>Redeemed < 35</th><th>Total Revenue</th>
        // <th>Success Ratio (%) <span  id="formula_gross_margin">$${Accepted\over {Views}} x 100$$ </span></th>
        // <th>Rejection Ratio (%) <span  id="formula_gross_margin">$${Rejected\over {Views}} x 100$$ </span></th>
        // <th>Conversion Rate (%) <span  id="formula_gross_margin">$${{Accepted + Rejected}\over {Total\ Views}} x 100$$ </span></th>
        // </tr></thead>';
        // echo '<tbody>';
        foreach ($ratios as $price => $ratio) {
            $success_ratio = number_format($ratio['success_ratio'], 2); // Limiting to two decimal places
            $cancellation_ratio = number_format($ratio['cancellation_ratio'], 2); // Limiting to two decimal places
            $engagement_rate = number_format($ratio['engagement_rate'], 2); // Limiting to two decimal places
            $revenue = number_format((double) $ratio['revenue'], 2);
            $viewed = $ratio['viewed'];
            $redeemed_gt35 = $ratio['redeemed_gt35'];
            $redeemed_lt35 = $ratio['redeemed_lt35'];
            $redeemed = $ratio['redeemed'];
            $removed = $ratio['removed'];
            $mobile = $ratio['mobile'];
            $desktop = $ratio['desktop'];
            // echo "<tr><td>$viewed</td><td>$$price</td><td>$redeemed</td><td>$removed</td><td>$mobile</td><td>$desktop</td><td>$redeemed_gt35</td><td>$redeemed_lt35</td><td>".$revenue."</td><td>$success_ratio%</td><td>$cancellation_ratio%</td><td>$engagement_rate%</td></tr>";
        }
        // echo '</tbody>';
        // echo '</table>';
    }else{
        // echo 'No data available';
    }
    echo '<h2 style="margin-top: 45px;">Calculations are based on the followings...</h2>';
    echo '<ul class="point-list">';
    echo '<li style="color: red; font-weight: bold;">Accepted cases may include orders with statuses such as failed, refunded, or cancelled.</li>';
    echo '<li><strong>Views:</strong> The number of users who added items to their cart and saw the shipping protection option. (<b>Note:</b> Views are counted regardless of whether an order was completed.)</li>';
    echo '<li><strong>Accepted:</strong> Number of completed checkouts where the user accepted the shipping protection option. This includes orders with a corresponding product ID (pID) for shipping protection.</li>';
    echo '<li><strong>Rejected:</strong> Number of completed checkouts where the user manually removed the shipping protection line item after initially accepting it.</li>';
    echo '<li><strong>Total Revenue:</strong> The total amount of money earned from shipping protection orders.</li>';
    echo '<li><strong>Success Ratio:</strong> Ratio of completed checkouts with shipping protection to the total number of views. Calculated as (Accepted orders / Total views) * 100.</li>';
    echo '<li><strong>Rejection Ratio:</strong> Ratio of completed checkouts without shipping protection to the total number of views. Calculated as (Rejected orders / Total views) * 100.</li>';
    echo '<li><strong>Conversion Rate %:</strong> Percentage of users who completed checkout with or without shipping protection, divided by the total number of views. Calculated as ((Accepted + Rejected orders) / Total views) * 100.</li>';
    echo '</ul>';

}

fetch_reports_data();
?>

<style>
    .point-list {
    list-style-type: disc;
    padding-left: 30px;
}
    .table-reporting td, .table-reporting th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

.table-reporting tr:nth-child(even) {
  background-color: #dddddd;
}
    .flex-row {

        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        background-color: #f0f0f0;
        box-shadow: inset -1px -1px 0 #e0e0e0;
        width: 100%;
        -webkit-box-align: center !important;
        -ms-flex-align: center !important;
        align-items: center !important;
        margin-right: 0px;
        margin-top: 45px;
        margin-left: 0px;
    }

    .flex-child {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
        border-top: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
        background: #fff;
        padding: 10px 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .flex-row .flex-child:first-child {
        border-left: 1px solid #e0e0e0;
    }

    .flex-child h4 {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        font-weight: 600;
        font-size: 18px;
        line-height: 15px;
    }

    .table-reporting {
        border-collapse: collapse;
        width: 98%;
        margin-top: 30px;
        border: 1px solid #ccc;
    }

    .table-reporting tr th,
    .table-reporting tr td {
    padding: 10px 10px;
    white-space: nowrap;
    text-align: left;
    border-left: 1px solid #ccc;
}

/* Apply white background to even rows and grey background to odd rows */
.table-reporting tr:nth-child(even) td {
    background-color: #fff; /* White background color */
}

.table-reporting tr:nth-child(odd) td {
    background-color: #ccc; /* Grey background color */
}

    .table-reporting tr td {
        font-weight: normal;
        border-bottom: 1px solid #ccc;
    }

    tr th {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        text-align: center; 
        vertical-align: top;
    }

    .table-reporting thead tr th {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        padding: 10px 10px;
        background: #f2f2f2;
        border-bottom: 1px solid #ccc;
        font-weight: bold;
        text-align: center;
        /* font-size: 12px; */
        /* text-transform: uppercase; */
    }

    .diplaytickets-mbt tr td {
        font-size: 14px;
    }

    .diplaytickets-mbt .flex-mbt-container .flex-mbt>div {
        display: flex;
        justify-content: space-between;
        padding-bottom: 4px;
        border-bottom: 1px solid #cccccc96;
        margin-bottom: 4px;
        margin-left: -10px;
        margin-right: -10px;
        padding-left: 10px;
        padding-right: 10px;
        font-weight: bold;
    }

    .flex-mbt-container .flex-mbt>div:last-child {
        border-bottom: 0px;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .flex-mbt-container .flex-mbt>div p {
        margin: 0;
        font-weight: normal;
        font-size: 14px;
    }

    a.action-icon-inbox {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #000;
        text-decoration: none;
    }

    .table-reporting.diplaytickets-mbt tr td,
    .table-reporting.diplaytickets-mbt tfoot th {
        text-align: center;
    }
</style>
