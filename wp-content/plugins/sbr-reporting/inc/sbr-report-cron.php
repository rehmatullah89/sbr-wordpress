<?php
add_action('sbr_report_cron', 'sbr_reports');
function sbr_reports()
{
    $params = array();
    // $start_date = date("Y-m-d", strtotime("-7 days"));
    // $end_date   = date("Y-m-d");
    // $start_date = "2024-05-12";//date("Y-m-d", strtotime("-7 days"));
    // $end_date   = "2024-05-18";//date("Y-m-d");

    //  $end_date = date("Y-m-d", strtotime("-5 month"));
    //  $start_date = date("Y-m-d", strtotime("-6 month"));
    // $oneyearprevious    = date("Y-m-d H:i:s",strtotime("-1 year"));

    // $c_end_date = date("Y-m-d", strtotime("-8 month"));;
    // $c_start_date = date("Y-m-d", strtotime("-15 month"));
    // $c_end_date = "2024-05-04";//date("Y-m-d", strtotime("-8 days"));
    // $c_start_date = "2024-04-28";//date("Y-m-d", strtotime("-15 days"));


    $start_date = date("Y-m-d", strtotime("-7 days"));
    $end_date   = date("Y-m-d");
    $c_end_date = date("Y-m-d", strtotime("-8 days"));
    $c_start_date = date("Y-m-d", strtotime("-15 days"));


    /*==============================
                    Noman
    ==============================*/
    $orderQuantityText = 'Order Quantity';
    $orderTotalText    = 'Orders Total';
    $revenueText       = 'Revenue';
    $discountText      = 'Discount';
    $grossMarginText   = 'Gross Margin';
    $shippingcostText  = 'Shipping Cost';

    

    // echo  $start_date =  '2022-05-15';
    // echo '<br>';
    // echo  $end_date = '2022-05-16';
    // echo '<br>';
    // echo $c_start_date = '2022-05-15';
    // echo '<br>';
    // echo $c_end_date = '2022-05-14';

    // echo 'one date' . ' ' . $start_date . '<br>';
    // echo '<br>';
    // echo '2nd date' . ' ' . $end_date . '<br>';
    // echo 'c one date' . ' ' . $c_start_date . '<br>';
    // echo '<br>';
    // echo 'c 2nd date' . ' ' . $c_end_date . '<br>';
 
    $totalOrderitemQuantityResponse   = total_item_night_guard_shipped_sbr_report_core($start_date, $end_date , '');

    $totalOrderitemQuantityResponse_new   = total_item_product_qty_sbr_report_core($start_date, $end_date , '');
    $compareProducts = total_item_product_qty_sbr_report_core($c_start_date, $c_end_date, '');

    $compare = total_item_night_guard_shipped_sbr_report_core($c_start_date, $c_end_date, '');
   
    $response_array = sbr_report_shipped_response_core($totalOrderitemQuantityResponse, $compare, 'yes', array('start_date' =>  $start_date, 'end_date' => $end_date, 'c_start_date' => $c_start_date, 'c_end_date' => $c_end_date));
    $response_product_array = sbr_report_product_raw_response_core($totalOrderitemQuantityResponse_new, $compareProducts, 'yes', array('start_date' =>  $start_date, 'end_date' => $end_date, 'c_start_date' => $c_start_date, 'c_end_date' => $c_end_date));
  
    /*==============================
                 Noman
      ==============================*/
    // $startdate_human_readable = date("F jS, Y", strtotime($start_date)); 
    // $end_date_human_readable = date("F jS, Y", strtotime($end_date)); 
    // $c_start_date_human_readable = date("F jS, Y", strtotime($c_start_date)); 
    // $c_end_date_human_readable = date("F jS, Y", strtotime($c_end_date)); 

    $startdate_human_readable = date("M jS", strtotime($start_date)); 
    $end_date_human_readable = date("M jS", strtotime($end_date)); 
    $year_date_human_readable = date("y");
    $c_start_date_human_readable = date("M jS", strtotime($c_start_date)); 
    $c_end_date_human_readable = date("M jS", strtotime($c_end_date));


    $totalOrderresponse = total_number_of_orders_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrdercompare = total_number_of_orders_rev_sbr_report_core($c_start_date, $c_end_date, '');

    /* Start For All Customers*/
    $orderResponseCompare    = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, '_order_shipping', '$');
    $discountResponseCompare = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, '_cart_discount', '$');
    $revebueResponseCompare = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, '_order_revenue', '$');
    $grossMarginResponseCompare = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, '_gross_margin', '');
    $totalOrderResponseCompare = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, '_order_total', '$');
    $totalOrderNumberResponseCompare = calculateDownUpCurrent($totalOrderresponse, $totalOrdercompare, 'total_orders', '');

    $ordershipPercentageDiff =  calcalateGrowthRatio( $totalOrderresponse['_order_shipping'], $totalOrdercompare['_order_shipping'],'');
    $discountPercentageDiff  =  calcalateGrowthRatio( $totalOrderresponse['_cart_discount'], $totalOrdercompare['_cart_discount'],'');
    $revenuePercentageDiff =  calcalateGrowthRatio( $totalOrderresponse['_order_revenue'], $totalOrdercompare['_order_revenue'],'');
    $grossMarginPercentageDiff =  calcalateGrowthRatio( $totalOrderresponse['_gross_margin'], $totalOrdercompare['_gross_margin'],'');
    $totalOrderPercentageDiff =  calcalateGrowthRatio( $totalOrderresponse['_order_total'], $totalOrdercompare['_order_total'],'');
    $TotalNumberPercentageDiff =  calcalateGrowthRatio($totalOrderresponse['total_orders'], $totalOrdercompare['total_orders'], '');
    /* End For All Customers*/
    sleep(1);
    $totalGehaOrderResponse = total_number_of_orders_geha_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrdercompare = total_number_of_orders_geha_rev_sbr_report_core($c_start_date, $c_end_date, '');
   
    /* Start For Geha Customers*/
    $orderGehaResponseCompare    = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_shipping', '$');
    $discountGehaResponseCompare = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, '_cart_discount', '$');
    $revenueGehaResponseCompare = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_revenue', '$');
    $grossMarginGehaResponseCompare = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, '_gross_margin', '');
    $ordertotalGehaResponseCompare = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_total', '$');
    $TotalNumberGehaResponseCompare = calculateDownUpCurrent($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_orders', '');

    $ordershipGehaPercentageDiff   =calcalateGrowthRatio( $totalGehaOrderResponse['_order_shipping'],$totalGehaOrdercompare['_order_shipping'], '');
    $discountGehaPercentageDiff    =calcalateGrowthRatio( $totalGehaOrderResponse['_cart_discount'], $totalGehaOrdercompare['_cart_discount'], '');
    $revenueGehaPercentageDiff     =calcalateGrowthRatio( $totalGehaOrderResponse['_order_revenue'],$totalGehaOrdercompare['_order_revenue'], '');
    $grossMarginGehaPercentageDiff =calcalateGrowthRatio( $totalGehaOrderResponse['_gross_margin'],$totalGehaOrdercompare['_gross_margin'], '');
    $totalOrderGehaPercentageDiff  =calcalateGrowthRatio( $totalGehaOrderResponse['_order_total'],$totalGehaOrdercompare['_order_total'], '');
    $TotalNumberGehaPercentageDiff =calcalateGrowthRatio( $totalGehaOrderResponse['total_orders'],$totalGehaOrdercompare['total_orders'], '');
    
    sleep(1);
    /* End For Geha Customers*/

    $totalGehaOrderExistresponse = total_number_of_orders_geha_exsiting_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrderExistcompare = total_number_of_orders_geha_exsiting_rev_sbr_report_core($c_start_date, $c_end_date, '');

    /* Start For Geha Exist Customers*/
    $orderGehaExistResponseCompare    = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_shipping', '$');
    $discountGehaExistResponseCompare = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_cart_discount', '$');
    $revenueGehaExistResponseCompare = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_revenue', '$');
    $grossMarginGehaExistResponseCompare = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_gross_margin', '');
    $ordertotalGehaExistResponseCompare = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_total', '$');
    $TotalNumberGehaExistResponseCompare = calculateDownUpCurrent($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, 'total_orders', '');

    $ordershipGehaExistPercentageDiff   =  calcalateGrowthRatio( $totalGehaOrderExistresponse['_order_shipping'], $totalGehaOrderExistcompare['_order_shipping'],'');
    $discountGehaExistPercentageDiff    =  calcalateGrowthRatio( $totalGehaOrderExistresponse['_cart_discount'], $totalGehaOrderExistcompare['_cart_discount'],'');
    $revenueGehaExistPercentageDiff =  calcalateGrowthRatio( $totalGehaOrderExistresponse['_order_revenue'], $totalGehaOrderExistcompare['_order_revenue'], '');
    $grossMarginGehaExistPercentageDiff =  calcalateGrowthRatio( $totalGehaOrderExistresponse['_gross_margin'], $totalGehaOrderExistcompare['_gross_margin'], '');
    $ordertotalGehaExistPercentageDiff =  calcalateGrowthRatio( $totalGehaOrderExistresponse['_order_total'], $totalGehaOrderExistcompare['_order_total'], '');
    $TotalNumberGehaExistPercentageDiff =  calcalateGrowthRatio( $totalGehaOrderExistresponse['total_orders'], $totalGehaOrderExistcompare['total_orders'], '');
   
    sleep(1);
    /* End For Geha Exist Customers*/

    $totalGehaOrderNonExistResponse = total_number_of_orders_non_geha_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrderNonExistCompare  = total_number_of_orders_non_geha_rev_sbr_report_core($c_start_date, $c_end_date, '');

     /* Start For Geha Non Exist Customers*/
     $orderGehaNonExistResponseCompare    = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_order_shipping', '$');
     $discountGehaNonExistResponseCompare = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_cart_discount', '$');
     $revenueGehaNonExistResponseCompare = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_order_revenue', '$');
     $grossMarginGehaNonExistResponseCompare = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_gross_margin', '');
     $ordertotalGehaNonExistResponseCompare = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_order_total', '$');
     $TotalNumberGehaNonExistResponseCompare = calculateDownUpCurrent($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, 'total_orders', '');

     $ordershipGehaNonExistPercentageDiff =  calcalateGrowthRatio( $totalGehaOrderNonExistResponse['_order_shipping'], $totalGehaOrderNonExistCompare['_order_shipping'],'');
     $discountGehaNonExistPercentageDiff  =  calcalateGrowthRatio( $totalGehaOrderNonExistResponse['_cart_discount'], $totalGehaOrderNonExistCompare['_cart_discount'],'');
     $revenueGehaNonExistPercentageDiff  =  calcalateGrowthRatio( $totalGehaOrderNonExistResponse['_order_revenue'], $totalGehaOrderNonExistCompare['_order_revenue'],'');
     $grossMarginGehaNonExistPercentageDiff  =  calcalateGrowthRatio( $totalGehaOrderNonExistResponse['_gross_margin'], $totalGehaOrderNonExistCompare['_gross_margin'],'');
     $ordertotalGehaNonExistPercentageDiff  =  calcalateGrowthRatio( $totalGehaOrderNonExistResponse['_order_total'], $totalGehaOrderNonExistCompare['_order_total'],'');
     $TotalNumberGehaNonExistPercentageDiff =calcalateGrowthRatio( $totalGehaOrderNonExistResponse['total_orders'], $totalGehaOrderNonExistCompare['total_orders'], '');
     /* End For Geha Non Exist Customers*/
     sleep(1);
    $totalOrderNewCustomerResponse  = total_number_of_orders_new_customers_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrderNewCustomerCompare   = total_number_of_orders_new_customers_rev_sbr_report_core($c_start_date, $c_end_date, '');

    /* Start For New Customers*/
    $orderNewResponseCompare    = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_shipping', '$');
    $discountNewResponseCompare = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_cart_discount', '$');
    $revenueNewResponseCompare = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_revenue', '$');
    $grossMarginNewResponseCompare = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_gross_margin', '');
    $ordertotalNewResponseCompare = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_total', '$');
    $TotalNumberNewResponseCompare = calculateDownUpCurrent($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, 'total_orders', '');

    $ordershipNewPercentageDiff =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['_order_shipping'], $totalOrderNewCustomerCompare['_order_shipping'], '');
    $discountNewPercentageDiff  =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['_cart_discount'], $totalOrderNewCustomerCompare['_cart_discount'],'');
    $revenueNewPercentageDiff  =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['_order_revenue'], $totalOrderNewCustomerCompare['_order_revenue'],'');
    $grossMarginNewPercentageDiff  =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['_gross_margin'], $totalOrderNewCustomerCompare['_gross_margin'],'');
    $ordertotalNewPercentageDiff  =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['_order_total'], $totalOrderNewCustomerCompare['_order_total'],'');
    $TotalNumberNewPercentageDiff =  calcalateGrowthRatio( $totalOrderNewCustomerResponse['total_orders'], $totalOrderNewCustomerCompare['total_orders'], '');
    sleep(1);
    /* End For New Customers*/


    $totalOrderExistCustomerResponse =  total_number_of_orders_existing_customers_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrderExistCustomerCompare =  total_number_of_orders_existing_customers_rev_sbr_report_core($c_start_date, $c_end_date, '');
 
    /* Start For  Exist Customers*/
    $orderExistResponseCompare    = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, '_order_shipping', '$');
    $discountExistResponseCompare = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, '_cart_discount', '$');
    $revenueExistResponseCompare = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, '_order_revenue', '$');
    $grossMarginExistResponseCompare = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, '_gross_margin', '');
    $ordertotalExistResponseCompare = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, '_order_total', '$');
    $TotalNumberExistResponseCompare = calculateDownUpCurrent($totalOrderExistCustomerResponse, $totalOrderExistCustomerCompare, 'total_orders', '');

    $ordershipExistPercentageDiff =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['_order_shipping'], $totalOrderExistCustomerCompare['_order_shipping'], '');
    $discountExistPercentageDiff  =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['_cart_discount'], $totalOrderExistCustomerCompare['_cart_discount'],'');
    $revenueExistPercentageDiff =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['_order_revenue'], $totalOrderExistCustomerCompare['_order_revenue'], '');
    $grossMarginExistPercentageDiff =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['_gross_margin'], $totalOrderExistCustomerCompare['_gross_margin'], '');
    $ordertotalExistPercentageDiff =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['_order_total'], $totalOrderExistCustomerCompare['_order_total'], '');
    $TotalNumberExistPercentageDiff =  calcalateGrowthRatio( $totalOrderExistCustomerResponse['total_orders'], $totalOrderExistCustomerCompare['total_orders'], '');
    sleep(1);
    /* End For  Exist Customers*/


    $totalOrderAddOnResponse   = addon_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrderAddOncompare   = addon_rev_sbr_report_core($c_start_date, $c_end_date, '');

      /* Start For AddOn order*/
      $orderAddOnResponseCompare    = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_shipping', '$');
      $discountAddOnResponseCompare = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, '_cart_discount', '$');
      $revenueAddOnResponseCompare = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_revenue', '$');
      $grossMarginAddOnResponseCompare = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, '_gross_margin', '');
      $ordertotalAddOnResponseCompare = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_total', '$');
      $TotalNumberAddOnResponseCompare = calculateDownUpCurrent($totalOrderAddOnResponse, $totalOrderAddOncompare, 'total_orders', '');

      $ordershipAddOnPercentageDiff =  calcalateGrowthRatio( $totalOrderAddOnResponse['_order_shipping'],$totalOrderAddOncompare['_order_shipping'], '');
      $discountAddOnPercentageDiff  =  calcalateGrowthRatio( $totalOrderAddOnResponse['_cart_discount'], $totalOrderAddOncompare['_cart_discount'],'');
      $revenueAddOnPercentageDiff  =  calcalateGrowthRatio( $totalOrderAddOnResponse['_order_revenue'], $totalOrderAddOncompare['_order_revenue'],'');
      $grossMarginAddOnPercentageDiff  =  calcalateGrowthRatio( $totalOrderAddOnResponse['_gross_margin'], $totalOrderAddOncompare['_gross_margin'],'');
      $ordertotalAddOnPercentageDiff  =  calcalateGrowthRatio( $totalOrderAddOnResponse['_order_total'], $totalOrderAddOncompare['_order_total'],'');
      $TotalNumberAddOnPercentageDiff =  calcalateGrowthRatio( $totalOrderAddOnResponse['total_orders'], $totalOrderAddOncompare['total_orders'], '');
      sleep(1);
      /* End For AddOn order*/

    $totalOrderitemQuantityResponse   = total_item_night_guard_shipped_sbr_report_core($start_date, $end_date, '');
    $totalOrderitemQuantityCompare   = total_item_night_guard_shipped_sbr_report_core($c_start_date, $c_end_date, '');
   // $response = calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_shipping', '$',$dateArr);
 
      /* Start For Quantity of AddOn order*/
      $orderitemQuantityResponseCompare    =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_shipping', '$');
      $discountitemQuantityResponseCompare =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_cart_discount', '$');
      $revenueitemQuantityResponseCompare =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_revenue', '$');
      $grossMarginQuantityResponseCompare =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_gross_margin', '');
      $ordertotalitemQuantityResponseCompare =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_total', '$');
      $TotalNumberitemQuantityResponseCompare =  calculateDownUpCurrent($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, 'total_orders', '');

      $ordershipitemQuantityPercentageDiff =  calcalateGrowthRatio( $totalOrderitemQuantityResponse['_order_shipping'], $totalOrderitemQuantityCompare['_order_shipping'],'');
      $discountitemQuantityPercentageDiff  =  calcalateGrowthRatio( $totalOrderitemQuantityResponse['_cart_discount'], $totalOrderitemQuantityCompare['_cart_discount'],'');
      $revenueitemQuantityPercentageDiff  =  calcalateGrowthRatio( $totalOrderitemQuantityResponse['_order_revenue'], $totalOrderitemQuantityCompare['_order_revenue'],'');
      $grossMarginemQuantityPercentageDiff  =  calcalateGrowthRatio( $totalOrderitemQuantityResponse['_gross_margin'], $totalOrderitemQuantityCompare['_gross_margin'],'');
      $ordertotalitemQuantityPercentageDiff  =  calcalateGrowthRatio( $totalOrderitemQuantityResponse['_order_total'], $totalOrderitemQuantityCompare['_order_total'],'');
      $TotalNumberitemQuantityPercentageDiff = calcalateGrowthRatio( $totalOrderitemQuantityResponse['total_orders'], $totalOrderitemQuantityCompare['total_orders'], '');
     
     
      /* End For Quantity of AddOn order*/

    //   $totalOrdericonTray    = total_tray_info_mbt(array('start_date' =>'2021-12-01', 'end_date' => '2022-03-17', 'cstart_date' =>'2021-12-01', 'cend_date'=>'2021-01-28'),'on');
 
    //$timestamp = "2013-09-30 01:16:06";

    $dateArr = array('start_date' => $start_date, 'end_date' => $end_date, 'cstart_date' => $c_start_date, 'cend_date' => $c_end_date);
      $htmls = '';
     $htmls .='
     <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
        <thead>
          <tr>
            <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
            <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">ALL CUSTOMERS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="border:1px solid #eee;padding: 5px;"></td>
            <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
            <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
            <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
          </tr>
          <tr>
          <td style="border:1px solid #eee;padding: 5px;"></td></td>
          <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
          <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
          <td style="border:1px solid #eee;padding: 5px;"></td>
          <td style="border:1px solid #eee;padding: 5px;"></td>
        </tr>
        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . number_format(round($totalOrderNumberResponseCompare["responsecurrent"], 2)) . '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . number_format(round($totalOrderNumberResponseCompare["responsecompare"], 2)) . '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberPercentageDiff['color'].'">' . $TotalNumberPercentageDiff['='] . '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberPercentageDiff['color'].'">' . $TotalNumberPercentageDiff['%'] . '%</td>
        </tr>

        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' . $totalOrderResponseCompare['responsecurrent']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$totalOrderResponseCompare['responsecompare']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; '.$totalOrderPercentageDiff['color'].'">$'.$totalOrderPercentageDiff['='].'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$totalOrderPercentageDiff['color'].'">'.$totalOrderPercentageDiff['%'].'%</td>
        </tr>

        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$revebueResponseCompare['responsecurrent']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$revebueResponseCompare['responsecompare']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; '.$revenuePercentageDiff['color'].'">$'.$revenuePercentageDiff['='].'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenuePercentageDiff['color'].'">'.$revenuePercentageDiff['%'].'%</td>
        </tr>

        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountResponseCompare['responsecurrent']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountResponseCompare['responsecompare']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountPercentageDiff['color'].'">$'.$discountPercentageDiff['='].'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountPercentageDiff['color'].'">'.$discountPercentageDiff['%'].'%</td>
        </tr>
    
        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$grossMarginResponseCompare['responsecurrent']. '%</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$grossMarginResponseCompare['responsecompare']. '%</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; '.$grossMarginPercentageDiff['color'].'">$'.$grossMarginPercentageDiff['='].'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginPercentageDiff['color'].'">'.$grossMarginPercentageDiff['%'].'%</td>
        </tr>

        <tr>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderResponseCompare['responsecurrent']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderResponseCompare['responsecompare']. '</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; '.$ordershipPercentageDiff['color'].'">$'.$ordershipPercentageDiff['='].'</td>
        <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipPercentageDiff['color'].'">'.$ordershipPercentageDiff['%'].'%</td></tr>
      
        </tbody>
        </table>
        <br /><br />

        <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
         <thead>
        <tr>
          <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
          <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">GEHA Customers</th>
        </tr>
        </thead>
       <tbody>
        <tr>
          <td style="border:1px solid #eee;padding: 5px;"></td>
          <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
          <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
          <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
        </tr>
        <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td></td>
        <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
        <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee;padding: 5px;"></td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaResponseCompare["responsecurrent"] . '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaResponseCompare["responsecompare"] . '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaPercentageDiff['color'].'">' . $TotalNumberGehaPercentageDiff['='] . '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaPercentageDiff['color'].'">' . $TotalNumberGehaPercentageDiff['%'] . '%</td>
      </tr>

      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaResponseCompare['responsecurrent']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaResponseCompare['responsecompare']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$totalOrderGehaPercentageDiff['color'].'">$'.$totalOrderGehaPercentageDiff['='].'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$totalOrderGehaPercentageDiff['color'].'">'.$totalOrderGehaPercentageDiff['%'].'%</td>
      </tr>

      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaResponseCompare['responsecurrent']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaResponseCompare['responsecompare']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaPercentageDiff['color'].'">$'.$revenueGehaPercentageDiff['='].'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaPercentageDiff['color'].'">'.$revenueGehaPercentageDiff['%'].'%</td>
      </tr>

      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaResponseCompare['responsecurrent']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaResponseCompare['responsecompare']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaPercentageDiff['color'].'">$'.$discountGehaPercentageDiff['='].'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaPercentageDiff['color'].'">'.$discountGehaPercentageDiff['%'].'%</td>
      </tr>

      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaResponseCompare['responsecurrent']. '%</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaResponseCompare['responsecompare']. '%</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaPercentageDiff['color'].'">$'.$grossMarginGehaPercentageDiff['='].'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaPercentageDiff['color'].'">'.$grossMarginGehaPercentageDiff['%'].'%</td>
      </tr>

      <tr>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaResponseCompare['responsecurrent']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaResponseCompare['responsecompare']. '</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaPercentageDiff['color'].'">$'.$ordershipGehaPercentageDiff['='].'</td>
      <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaPercentageDiff['color'].'">'.$ordershipGehaPercentageDiff['%'].'%</td>
      </tr>

      </tbody>
      </table>
      <br /><br />

      <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
        <thead>
        <tr>
          <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
          <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">GEHA Customers Existing</th>
        </tr>
      </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaExistResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaExistResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaExistPercentageDiff['color'].'">' . $TotalNumberGehaExistPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaExistPercentageDiff['color'].'">' . $TotalNumberGehaExistPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalGehaExistPercentageDiff['color'].'">$'.$ordertotalGehaExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalGehaExistPercentageDiff['color'].'">'.$ordertotalGehaExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaExistPercentageDiff['color'].'">$'.$revenueGehaExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaExistPercentageDiff['color'].'">'.$revenueGehaExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaExistPercentageDiff['color'].'">$'.$discountGehaExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaExistPercentageDiff['color'].'">'.$discountGehaExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaExistResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaExistResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaExistPercentageDiff['color'].'">$'.$grossMarginGehaExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaExistPercentageDiff['color'].'">'.$grossMarginGehaExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaExistPercentageDiff['color'].'">$'.$ordershipGehaExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaExistPercentageDiff['color'].'">'.$ordershipGehaExistPercentageDiff['%'].'%</td>
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
      <thead>
        <tr>
          <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
          <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">Non GEHA Customers</th>
        </tr>
      </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaNonExistResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberGehaNonExistResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaNonExistPercentageDiff['color'].'">' . $TotalNumberGehaNonExistPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberGehaNonExistPercentageDiff['color'].'">' . $TotalNumberGehaNonExistPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaNonExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalGehaNonExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalGehaNonExistPercentageDiff['color'].'">$'.$ordertotalGehaNonExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalGehaNonExistPercentageDiff['color'].'">'.$ordertotalGehaNonExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaNonExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueGehaNonExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaNonExistPercentageDiff['color'].'">$'.$revenueGehaNonExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueGehaNonExistPercentageDiff['color'].'">'.$revenueGehaNonExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaNonExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountGehaNonExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaNonExistPercentageDiff['color'].'">$'.$discountGehaNonExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountGehaNonExistPercentageDiff['color'].'">'.$discountGehaNonExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaNonExistResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginGehaNonExistResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaNonExistPercentageDiff['color'].'">$'.$grossMarginGehaNonExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginGehaNonExistPercentageDiff['color'].'">'.$grossMarginGehaNonExistPercentageDiff['%'].'%</td>
    </tr>
    
    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaNonExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderGehaNonExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaNonExistPercentageDiff['color'].'">$'.$ordershipGehaNonExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipGehaNonExistPercentageDiff['color'].'">'.$ordershipGehaNonExistPercentageDiff['%'].'%</td>
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">New Customers</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberNewResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberNewResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberNewPercentageDiff['color'].'">' . $TotalNumberNewPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberNewPercentageDiff['color'].'">' . $TotalNumberNewPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalNewResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalNewResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalNewPercentageDiff['color'].'">$'.$ordertotalNewPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalNewPercentageDiff['color'].'">'.$ordertotalNewPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueNewResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueNewResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueNewPercentageDiff['color'].'">$'.$revenueNewPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueNewPercentageDiff['color'].'">'.$revenueNewPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountNewResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountNewResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountNewPercentageDiff['color'].'">$'.$discountNewPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountNewPercentageDiff['color'].'">'.$discountNewPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginNewResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginNewResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginNewPercentageDiff['color'].'">$'.$grossMarginNewPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginNewPercentageDiff['color'].'">'.$grossMarginNewPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderNewResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderNewResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipNewPercentageDiff['color'].'">$'.$ordershipNewPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipNewPercentageDiff['color'].'">'.$ordershipNewPercentageDiff['%'].'%</td>
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">Existing Customers</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td> 
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberExistResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberExistResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberExistPercentageDiff['color'].'">' . $TotalNumberExistPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberExistPercentageDiff['color'].'">' . $TotalNumberExistPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalExistPercentageDiff['color'].'">$'.$ordertotalExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalExistPercentageDiff['color'].'">'.$ordertotalExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueExistPercentageDiff['color'].'">$'.$revenueExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueExistPercentageDiff['color'].'">'.$revenueExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountExistPercentageDiff['color'].'">$'.$discountExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountExistPercentageDiff['color'].'">'.$discountExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginExistResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginExistResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginExistPercentageDiff['color'].'">$'.$grossMarginExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginExistPercentageDiff['color'].'">'.$grossMarginExistPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderExistResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderExistResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipExistPercentageDiff['color'].'">$'.$ordershipExistPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipExistPercentageDiff['color'].'">'.$ordershipExistPercentageDiff['%'].'%</td>
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">Add-On Orders</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td> 
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberAddOnResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberAddOnResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberAddOnPercentageDiff['color'].'">' . $TotalNumberAddOnPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberAddOnPercentageDiff['color'].'">' . $TotalNumberAddOnPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalAddOnResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalAddOnResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalAddOnPercentageDiff['color'].'">$'.$ordertotalAddOnPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalAddOnPercentageDiff['color'].'">'.$ordertotalAddOnPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueAddOnResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueAddOnResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueAddOnPercentageDiff['color'].'">$'.$revenueAddOnPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueAddOnPercentageDiff['color'].'">'.$revenueAddOnPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountAddOnResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountAddOnResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountAddOnPercentageDiff['color'].'">$'.$discountAddOnPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountAddOnPercentageDiff['color'].'">'.$discountAddOnPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginAddOnResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginAddOnResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginAddOnPercentageDiff['color'].'">'.$grossMarginAddOnPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginAddOnPercentageDiff['color'].'">'.$grossMarginAddOnPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderAddOnResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderAddOnResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipAddOnPercentageDiff['color'].'">$'.$ordershipAddOnPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipAddOnPercentageDiff['color'].'">'.$ordershipAddOnPercentageDiff['%'].'%</td>
    
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th  style="border:1px solid #eee;padding: 5px; font-family:arial;"  rowspan="2">KPIs</th>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="4">Quantity Of Add-On Orders</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #eee;padding: 5px;"></td>
        <td style="border:1px solid #eee ;font-size:14px; padding: 5px; text-align: center;font-family:arial;" colspan="2">Date</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">Difference</td>
        <td style="border:1px solid #eee;font-size:14px; padding: 5px;font-family:arial;">%Change</td>
      </tr>
      <tr>
      <td style="border:1px solid #eee;padding: 5px;"></td></td> 
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
      <td style="border:1px solid #eee;padding: 5px;"></td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderQuantityText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberitemQuantityResponseCompare["responsecurrent"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' . $TotalNumberitemQuantityResponseCompare["responsecompare"] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberitemQuantityPercentageDiff['color'].'">' . $TotalNumberitemQuantityPercentageDiff['='] . '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$TotalNumberitemQuantityPercentageDiff['color'].'">' . $TotalNumberitemQuantityPercentageDiff['%'] . '%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$orderTotalText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalitemQuantityResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$ordertotalitemQuantityResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalitemQuantityPercentageDiff['color'].'">$'.$ordertotalitemQuantityPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordertotalitemQuantityPercentageDiff['color'].'">'.$ordertotalitemQuantityPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$revenueText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueitemQuantityResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$revenueitemQuantityResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueitemQuantityPercentageDiff['color'].'">$'.$revenueitemQuantityPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$revenueitemQuantityPercentageDiff['color'].'">'.$revenueitemQuantityPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$discountText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountitemQuantityResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$discountitemQuantityResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountitemQuantityPercentageDiff['color'].'">$'.$discountitemQuantityPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$discountitemQuantityPercentageDiff['color'].'">'.$discountitemQuantityPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$grossMarginText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginQuantityResponseCompare['responsecurrent']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">' .$grossMarginQuantityResponseCompare['responsecompare']. '%</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginemQuantityPercentageDiff['color'].'">$'.$grossMarginemQuantityPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$grossMarginemQuantityPercentageDiff['color'].'">'.$grossMarginemQuantityPercentageDiff['%'].'%</td>
    </tr>

    <tr>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;">'.$shippingcostText.'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderitemQuantityResponseCompare['responsecurrent']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial; ">' .$orderitemQuantityResponseCompare['responsecompare']. '</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipitemQuantityPercentageDiff['color'].'">$'.$ordershipitemQuantityPercentageDiff['='].'</td>
    <td style="border:1px solid #eee;padding: 5px; font-size:14px;font-family:arial;'.$ordershipitemQuantityPercentageDiff['color'].'">'.$ordershipitemQuantityPercentageDiff['%'].'%</td>
    </tr>
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5">Total Number Of Whitening Trays Shipped</th>
      </tr>
    </thead>
    <tbody>
    <tr>

      <td style="border:1px solid #eee;padding: 5px;">Title</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;">Difference</td>
      <td style="border:1px solid #eee;padding: 5px;">%Change</td>
    </tr>

   

    <tr>'.$response_array['whitening'].'</tr>
    
  
    </tbody>
    </table>
<br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5">Total Number Of Night Guard Shipped</th>
      </tr>
    </thead>
    <tbody>
    <tr>
      <td style="border:1px solid #eee;padding: 5px;">Title</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;">Difference</td>
      <td style="border:1px solid #eee;padding: 5px;">%Change</td>
    </tr>


    <tr>'.$response_array['nightGuard'].'</tr>
    
  
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
      <tr>
        <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5">Total Number Of Addon</th>
      </tr>
    </thead>
    <tbody>
    <tr>

      <td style="border:1px solid #eee;padding: 5px;">Title</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
      <td style="border:1px solid #eee;padding: 5px;">Difference</td>
      <td style="border:1px solid #eee;padding: 5px;">%Change</td>
    </tr>



    <tr>'.$response_array['addon'].'</tr>
    
  
    </tbody>
    </table>
    <br /><br />

    <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
    <thead>
    <tr>
      
      <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5">Quantity Of Units Sold For Each Item</th>
    </tr>
  </thead>
  <tbody>
  <tr>
  <td style="border:1px solid #eee;padding: 5px;">Title</td>
  <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
  <td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
  <td style="border:1px solid #eee;padding: 5px;">Difference</td>
  <td style="border:1px solid #eee;padding: 5px;">%Change</td>
  </tr>



  <tr>'.$response_product_array['products'].'</tr>
  
  </tbody>
  </table>
  <br /><br />

  <table style="max-width:780px;width:100%;margin:0px auto; border-spacing:0px;">
  <thead>
  <tr>
    
    <th style="border:1px solid #eee;padding: 5px; font-family:arial;" colspan="5">Quantity Of Raw Inventory Used QTY</th>
  </tr>
</thead>
<tbody>
<tr>
<td style="border:1px solid #eee;padding: 5px;">Title</td>
<td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$startdate_human_readable. ' - ' .$end_date_human_readable.', '.$year_date_human_readable.'</td>
<td style="border:1px solid #eee;padding: 5px;font-size:14px;font-family:arial;">'.$c_start_date_human_readable. ' - ' .$c_end_date_human_readable.', '.$year_date_human_readable.'</td>
<td style="border:1px solid #eee;padding: 5px;">Difference</td>
<td style="border:1px solid #eee;padding: 5px;">%Change</td>
</tr>

<tr>'.$response_array['raw'].'</tr>

</tbody>
  </table><br /><br />';
echo $htmls;
include 'fortune.php';
$today = date("M jS", strtotime("-7 days")).' to '.date("jS"). ' - '.date("M jS",strtotime("-15 days")).' to '.date("jS",strtotime("-8 days")).', '.date("y");
$subject = 'SBR Weekly Review - '.$today;
$headers = array('Content-Type: text/html; charset=UTF-8');
$headers[] = 'From: <support@smilebrilliant.com>';
$headers[] = 'Cc: Abidoon Nadeem <abidoon@mindblazetech.com>, Rehmat Ullah <rehmatullah@mindablazetech.com>';
$sent = wp_mail('amir.shah@smilebrilliant.com', $subject, $htmls, $headers);
//$sent = wp_mail('rehmatullah@mindablazetech.com', $subject, $htmls, $headers);

    }
