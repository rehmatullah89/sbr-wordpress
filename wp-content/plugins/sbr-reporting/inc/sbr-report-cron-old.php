<?php
add_action('sbr_report_cron', 'sbr_reports');
function sbr_reports()
{
    $params = array();
    // $startDate = date("Y-m-d", strtotime("-14 days"));
    // $endDate = date("Y-m-d", strtotime("-7 days"));
    $end_date =  date("Y-m-d");
    $start_date = date("Y-m-d", strtotime("-2 days"));
    $c_end_date = date("Y-m-d", strtotime("-3 days"));;
    $c_start_date = date("Y-m-d", strtotime("-5 days"));
    // $start_date = date("Y-m-d", strtotime("-7 days"));
    // $c_end_date = date("Y-m-d", strtotime("-8 days"));;
    // $c_start_date = date("Y-m-d", strtotime("-15 days"));
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
    // echo 'Data: <pre>' .print_r($totalOrderitemQuantityCompare,true). '</pre>'; exit;
    $totalOrderitemQuantityResponse   = total_item_night_guard_shipped_sbr_report_core($start_date, $end_date , '');
    $compare = total_item_night_guard_shipped_sbr_report_core($c_end_date, $c_start_date, '');
 
    $response_array = sbr_report_shipped_response_core($totalOrderitemQuantityResponse, $compare, 'yes', array('start_date' =>  $start_date, 'end_date' => $end_date, 'c_start_date' => $c_start_date, 'c_end_date' => $c_end_date));
    //echo 'Data: <pre>' .print_r($response_array,true). '</pre>'; exit;
    $totalOrderresponse = total_number_of_orders_rev_sbr_report_core($start_date, $end_date, '');
    // echo 'Data: <pre>' .print_r($totalOrderresponse,true). '</pre>';
    $totalOrdercompare = total_number_of_orders_rev_sbr_report_core($c_start_date, $c_end_date, '');
    //  die('Data: <pre>' .print_r($totalOrdercompare,true). '</pre>');

    // echo '<pre>';
    // print_r( $totalOrderresponse );
    // echo '</pre>';
    // echo '=>';
    // echo '<pre>';
    // print_r( $totalOrdercompare);
    // echo '</pre>';
    // die();
    $totalGehaOrderResponse = total_number_of_orders_geha_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrdercompare = total_number_of_orders_geha_rev_sbr_report_core($c_start_date, $c_end_date, '');
    $totalGehaOrderExistresponse = total_number_of_orders_geha_new_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrderExistcompare = total_number_of_orders_geha_new_rev_sbr_report_core($c_start_date, $c_end_date, '');
    $totalGehaOrderNonExistResponse = total_number_of_orders_non_geha_rev_sbr_report_core($start_date, $end_date, '');
    $totalGehaOrderNonExistCompare = total_number_of_orders_non_geha_rev_sbr_report_core($c_start_date, $c_end_date, '');
    $totalOrderNewCustomerResponse   = total_number_of_orders_new_customers_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrderNewCustomerCompare   = total_number_of_orders_new_customers_rev_sbr_report_core($c_start_date, $c_end_date, '');
    $totalOrderAddOnResponse   = addon_rev_sbr_report_core($start_date, $end_date, '');
    $totalOrderAddOncompare   = addon_rev_sbr_report_core($c_start_date, $c_end_date, '');
    $totalOrderitemQuantityResponse   = total_item_night_guard_shipped_sbr_report_core($start_date, $end_date, '');
    $totalOrderitemQuantityCompare   = total_item_night_guard_shipped_sbr_report_core($c_start_date, $c_end_date, '');
    //   $totalOrdericonTray    = total_tray_info_mbt(array('start_date' =>'2021-12-01', 'end_date' => '2022-03-17', 'cstart_date' =>'2021-12-01', 'cend_date'=>'2021-01-28'),'on');
    //echo 'Data: <pre>' .print_r($totalOrdericonTray,true). '</pre>';
    $dateArr = array('start_date' => $start_date, 'end_date' => $end_date, 'cstart_date' => $c_start_date, 'cend_date' => $c_end_date);

    $html = '<table style=" border-spacing:0;
    border-collapse: collapse;
    table-layout: fixed;
    margin: 0 auto;
    width: 630px;" class="mbtparent">
    <tr  style="vertical-align:top">
        <td style="padding: 4px;;width: 315px;">
            <table class="mbt01" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;;width: 100%;">
                <tr>
                    <th colspan="2"><h2 style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue All Orders</h2></th>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, '_order_shipping', '$',$dateArr) . '$</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, '_cart_discount', '$' ,$dateArr) . '$</td>
                </tr>
                 <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, 'total_orders', '' ,$dateArr).  '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue: (Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, '_order_revenue', '$',$dateArr) . '$</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue Today: (Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . number_format($totalOrderresponse['_order_revenue_today'], 2) . '$</td>
                </tr>
                 <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue Weekly: (Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . number_format($totalOrderresponse['_order_revenue_weekly'], 2) . '$</td>
                </tr>
                 <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue Weekly: (Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . number_format($totalOrderresponse['_order_revenue_monthally'], 2) . '$</td>
                </tr>
            </table>
        </td>
        <td style="padding: 4px;width: 315px;">
            <table style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;" class="mbt02">
                <tr>
                    <th colspan="2"><h2  style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue From GEHA Customers</h2></th>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_shipping', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_cart_discount', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_orders', '',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_revenue', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin %:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_gross_margin', '%',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_total', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_geha_coupons_geerated', '',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_geha_coupons_used', '',$dateArr) . '</td>
                </tr>
            </table>
        </td>
    
    </tr>
    </table>';

    $html .= '<table  style=" border-spacing:0;
    border-collapse: collapse;
    table-layout: fixed;
    margin: 0 auto;
    width: 630px;">
    <tr  style="vertical-align:top">
        <td style="width: 315px;padding: 4px;">
            <table class="mbt03" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                <tr>
                    <th colspan="2"><h2  style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue From New Customers</h2></th>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_shipping', '$',$dateArr) . '$</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_cart_discount', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, 'total_orders', '',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_revenue', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin `%:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_gross_margin', '%',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderNewCustomerResponse, $totalOrderNewCustomerCompare, '_order_total', '$',$dateArr) . '</td>
                </tr> 
            </table>
        </td>
        <td style="width: 315px;padding: 4px;">
            <table class="mbt04" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;">
            <tr>
                <th colspan="2"><h2  style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue from GEHA Customers Existing</h2></th>            
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_shipping', '$',$dateArr) . '$</td>
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_cart_discount', '$',$dateArr) . '</td>
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, 'total_orders', '',$dateArr) . '</td>
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_revenue', '$',$dateArr) . '</td>
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin `%:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_gross_margin', '%',$dateArr) . '</td>
            </tr>
            <tr>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderExistresponse, $totalGehaOrderExistcompare, '_order_total', '$',$dateArr) . '</td>
            </tr>
        </table>
    </td>
            </tr>
            </table>';

    $html .= '<table style=" border-spacing:0;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0 auto;
            width: 630px;" class="mbtparent02">
            <tr style="vertical-align:top">
                <td style="width: 315px;padding: 4px;">
                    <table  class="mbt05" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                        <tr>
                            <th colspan="2"><h2 style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue From Non GEHA Customers</h2></th>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_order_shipping', '$',$dateArr) . '$</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_cart_discount', '$',$dateArr) . '$</td>
                        </tr>
                         <tr>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue (Price - Discount):</td>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderNonExistResponse, $totalGehaOrderNonExistCompare, '_order_revenue', '$',$dateArr) . '</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin %:</td>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, '_gross_margin', '%',$dateArr) . '</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                            <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderresponse, $totalOrdercompare, '_order_total', '%',$dateArr) . '$</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 315px;padding: 4px;">
                            <table class="mbt06" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                                <tr>
                                    <th colspan="2"><h2 style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue From Existing Customers</h2>                                    </th>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_shipping', '$',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_cart_discount', '$',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_orders', '',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue: (Price - Discount)</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_revenue', '$',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin %:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_gross_margin', '%',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, '_order_total', '$',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_geha_coupons_geerated', '',$dateArr) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalGehaOrderResponse, $totalGehaOrdercompare, 'total_geha_coupons_used', '',$dateArr) . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>';


    $html .= '<table class="mbtparent03" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed;margin: 0 auto;width: 630px;">
    <tr style="vertical-align:top">
        <td style="width: 315px;padding: 4px;">
            <table class="mbt07" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                <tr>
                    <th colspan="2">
                        <h2 style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Revenue From Add-On Orders</h2>
                    </th>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_shipping', '$',$dateArr) . '$</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderAddOnResponse, $totalOrderAddOncompare, '_cart_discount', '$',$dateArr) . '$</td>
                </tr>
                 <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue:(Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_revenue', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin %:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderAddOnResponse, $totalOrderAddOncompare, '_gross_margin', '%',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderAddOnResponse, $totalOrderAddOncompare, '_order_total', '%',$dateArr) . '$</td>
                </tr>
            </table>
        </td>
        <td style="width: 315px;padding: 4px;">
            <table class="mbt08" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                <tr>
                    <th colspan="2">
                    <h2 style="padding: 8px;font-family: arial;text-align: center;background: #2271b1;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;border-bottom: 1px solid #c3c4c7;">Item Quantity Of Add-On Orders</h2></th>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Shipping:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_shipping', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Discount:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_cart_discount', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Total Number Of Orders:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, 'total_orders', '',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Revenue:(Price - Discount)</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_revenue', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Gross Margin %:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_gross_margin', '%',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Order Total:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, '_order_total', '$',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, 'total_geha_coupons_geerated', '',$dateArr) . '</td>
                </tr>
                <tr>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">Geha Coupons Generated:</td>
                    <td style="font-size: 14px;padding: 8px;font-family: arial;border-bottom: 1px dashed #c3c4c7d9;letter-spacing: 0.7px;line-height: 1.5;">' . calculateUpDownCompare($totalOrderitemQuantityResponse, $totalOrderitemQuantityCompare, 'total_geha_coupons_used', '',$dateArr) . '</td>
                </tr>
            </table>
        </td>
        
    </tr>
    </table>';

    $html .= '<table class="mbtparent04" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed;margin: 0 auto;width: 630px;">
            <tr style="vertical-align:top">
                <td>
                    <table  class="mbt09" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed; border: 1px solid #d1d1d1; padding: 6px;width: 100%;">
                        <tr style="vertical-align:top">
                        <th style="padding: 8px;center;background: #2271b1;border-bottom: 1px solid #c3c4c7;"> <h2 style="font-family: arial;text-align: center;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;margin: 0;">Total Number Of Whitening Trays Shipped</h2></th>
                        <th style="padding: 8px;center;background: #2271b1;border-bottom: 1px solid #c3c4c7;"> <h2 style="font-family: arial;text-align: center;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;margin: 0;">QTY</h2></th>
                        </tr>
                        <tr>
                        ' . $response_array['nightGuard'] . '
                        </tr>
                        
                    </table>
                </td>
            
            </tr>
            </table>';
    $html .= '<table class="mbtparent05" style=" border-spacing:0;border-collapse: collapse;table-layout: fixed;margin: 0 auto;width: 630px;">
        <tr style="vertical-align:top">
            <td>
                <table>
                    <tr>
                        <th style="padding: 8px;center;background: #2271b1;border-bottom: 1px solid #c3c4c7;"> <h2 style="font-family: arial;text-align: center;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;margin: 0;">Quantity Of Units Sold For Each Item</h2></th>
                        <th style="padding: 8px;center;background: #2271b1;border-bottom: 1px solid #c3c4c7;"> <h2 style="font-family: arial;text-align: center;color: #fff;font-size: 14px;line-height: 1;letter-spacing: 0.5px;text-transform: capitalize;margin: 0;">QTY</h2></th>
                    </tr>
                    <tr>
                    ' . $response_array['products'] . '
                    </tr>
                    
                </table>
            </td>
        
        </tr>
        </table>';

    $html .= '<table>
        <tr>
            <td>
                <table>
                    <tr>
                        <th>Quantity Of Raw Inventory Used</th>
                        <th>QTY</th>
                    </tr>
                    <tr>
                    ' . $response_array['raw'] . '
                    </tr>
                    
                </table>
            </td>
        
        </tr>
        </table>';

    $html .= '<table>
        <tr>
            <td>
                <table>
                    <tr>
                        <th>Quantity Of Raw Inventory Used</th>
                        <th>QTY</th>
                    </tr>
                    <tr>
                    ' . $response_array['raw'] . '
                    </tr>
                    
                </table>
            </td>
        
        </tr>
        </table>';

    // $html.= '<table>
    // <tr>
    //     <td>
    //         <table>
    //             <tr>
    //                 <th>Trays Info</th>
    //                 <th>QTY</th>
    //             </tr>
    //             <tr>
    //             '. total_tray_info_mbt(array('start_date' =>'2021-12-01', 'end_date' => '2022-03-17', 'cstart_date' =>'2021-12-01', 'cend_date'=>'2021-01-28'),'on') .'
    //             </tr>

    //         </table>
    //     </td>

    // </tr>
    // </table>';




    echo  $html;
    // $subject = 'Daily sale report';
    // $headers = array('Content-Type: text/html; charset=UTF-8');
    // $sent = wp_mail('asifjavaid@mindblazetech.com', $subject, $html, $headers);
    // if($sent) {
    //     echo $sent;
    //     echo 'sent';
    // } else {
    //     echo 'not sent';
    // }
}
