<?php

if (isset($_GET['order_id1'])) {
    add_action('init', 'domPDF');
}

function get_packing_slip_data()
{
    // if (isset($_GET['order_id1'])) {
    $packing_array = array(
        'order_id' => '623988',
        'packing_note' => 'tes note',
        'package_id' => '80',
        'products' => array(
            array(
                'product_id' => '5',
                'quantity_ordered' => '2',
                'quantity_shipped' => '1',
                'childs' =>
                array(
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                )
            ),
            array(
                'product_id' => '5',
                'quantity_ordered' => '2',
                'quantity_shipped' => '1',
                'childs' =>
                array(
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                    array('product_id' => '5', 'quantity_ordered' => '2', 'quantity_shipped' => '1'),
                )
            ),
            array(
                'product_id' => '5',
                'quantity_ordered' => '2',
                'quantity_shipped' => '1',
                'childs' => [],
            )
        ),
    );
    return get_packing_slip_by_order_id($packing_array, true);
    //   die();
    //}
}

function get_packing_slip_by_order_id($packing_array, $ret = true)
{
    $html = '';

    $packing_products = isset($packing_array['products']) ? $packing_array['products'] : [];
    $batchNo = isset($packing_array['batchNo']) ? $packing_array['batchNo'] : ' N/A';
    $groupID = isset($packing_array['groupID']) ? $packing_array['groupID'] : '';
    $store_address = get_option('woocommerce_store_address');
    $store_address_2 = get_option('woocommerce_store_address_2');
    $store_city = get_option('woocommerce_store_city');
    $store_state = WC()->countries->get_base_state();
    $store_postcode = get_option('woocommerce_store_postcode');
    $woocommerce_store_phone = get_option('woocommerce_store_phone');
    $woocommerce_default_country = WC()->countries->get_base_country();
    // The country/state
    $store_raw_country = get_option('woocommerce_default_country');
    if (is_array($packing_products) && count($packing_products) > 0) {
        $counter = 1;
        $item_html = '';
        global $MbtPackaging;
        $components = $MbtPackaging->get_package_components_by_id($packing_array['package_id']);
        $package_info = $MbtPackaging->get_package_info_by_id($packing_array['package_id']);
        $package_name = $package_info[0]->name;
        $innercounter = 0;
        foreach ($packing_products as $prd) {
            $product_title = get_the_title($prd['product_id']);
            $product_title = html_entity_decode($product_title);
            $product_title = make_specific_words_bold($product_title);
            $product_title = str_ireplace('Deluxe', '<strong style="font-size:inherit;">DELUXE</strong>', $product_title);
            $refunded_qty = isset($prd['refunded_qty']) ? $prd['refunded_qty']:'0';
        //   echo '=>'.$prd['quantity_ordered'];
          // echo '<br />';
           $refunded_qty =  (int)$refunded_qty;
           $quantity_ordered = (int)$prd['quantity_ordered'];
           $qtyShipped = $prd['quantity_shipped'];
           $qtyShipped = (int) $qtyShipped;
            $full_refunded = '';
            if($refunded_qty!=0 && $refunded_qty == $quantity_ordered){
                $full_refunded  = 'Refunded';
                $refund_class = 'striked';
                $product_title ='<del  class="'.$refund_class.'"><strong>'.$full_refunded.':</strong>'.$product_title.'</del>';
            }
            if($refunded_qty!=0 && $refunded_qty <  $quantity_ordered){
                $full_refunded  = 'Partially Refunded';
                $refund_class = 'not-striked';
                $product_title ='<span class="'.$refund_class.'"><strong>'.$full_refunded.':</strong>'.$product_title.'</span>';
            }
            if($full_refunded!=''){
                $remaining_qty = max($quantity_ordered - $refunded_qty, 0);
                $qtyShipped = '<del  class="'.$refund_class.'">'.$qtyShipped.'</del><br />'.$remaining_qty;
            }
            $tray_no = false;
            if (isset($prd['tray_no']) && $prd['tray_no'] <> '') {
                $tray_no = $prd['tray_no'];
            }
            /*
             * 
             * 
             *    <td style="width:15%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;    vertical-align:top;">
              <p style="padding-top: 5px; margin: 0; " style="display:">' . $prd['quantity_ordered'] . '</p>

              </td>
             */
            $item_html .= '<tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;border-right: 0;line-height: 1.5;    vertical-align:top;">

		<p style=" margin: 0;font-size: 12pt; ">' . $counter . '</p> 
		
       	      	
      </td>
      <td style="width:45%;font-size:14pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;line-height: 1.5;    vertical-align:top;">
		<p style=" margin: 0;font-size: 14pt; ">' . $product_title . '</p> 
      <p style="margin: 0; font-size: 14pt;"> Tariff Code: ' . get_post_meta($prd["product_id"], 'shiptoTariffCode', true) . '</p>';

            if ($tray_no) {
                $item_html .= '<h3 style="padding-top: 5px; margin: 0;font-size: 22pt; "> Tray# ' . $tray_no . '</h3>';
            }
            $item_html .= '</td>
		
       <td style="width:30%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;    vertical-align:top;">
		<strong style="padding-top: 5px; margin: 0;font-size: 12pt; ">' . $qtyShipped . '</strong>      	
		
      </td>
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;line-height: 1.5;    vertical-align:top;">
     	<p style=" margin: 0;font-size: 12pt;"><span style="display: inline-block; height: 13.5pt; width: 13.5pt; border: 1px solid #000; "></span></p>
     	 	     	     	
	      	      	
       </td>
    </tr>';
            $childs = isset($prd['childs']) ? $prd['childs'] : [];

            if (is_array($childs) && count($childs) > 0) {
                foreach ($childs as $child) {
                    $innercounter++;
                    $product_title = get_post_meta($child['product_id'], 'product_short_name', true);
                    if ($product_title == '') {
                        $product_title = get_the_title($child['product_id']);
                    }
                    $product_title = html_entity_decode($product_title);
                    $product_title = str_ireplace('Deluxe', '<strong style="font-size:inherit;">DELUXE</strong>', $product_title);
                    /*
                     * 
                     *  <td style="width:15%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;    vertical-align:top;">
                      <p style="padding-top: 5px; margin: 0; ">' . $child['quantity_ordered'] . '</p>

                      </td>
                     */
                    $item_html .= '<tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;border-right: 0;line-height: 1.5;    vertical-align:top;">

		<p style=" margin: 0;padding-left:15px;font-size: 12pt; "> → </p> 
		
       	      	
      </td>
      <td style="width:45%;font-size:14pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;line-height: 1.5;    vertical-align:top;">
		<p style=" margin: 0;padding-left:20px;font-size: 14pt; ">' . $product_title . '</p> 
		
      </td>

     
      <td style="width:30%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;vertical-align:top">
		<strong style=" margin: 0;font-size: 12pt; ">' . $child['quantity_shipped'] . '</strong>      	
		
      </td>
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;line-height: 1.5;    vertical-align:top;">
     	<p style=" margin: 0;font-size: 12pt;"><span style="display: inline-block; height: 13.5pt; width: 13.5pt; border: 1px solid #000; "></span></p>
     	 	     	     	
	      	      	
       </td>
    </tr>';
                }
            }
            $counter++;
        }
        foreach ($components as $res) {
            $product_title = get_the_title($res->component_id);
            $product_title = html_entity_decode($product_title);
            $product_title = str_ireplace('Deluxe', '<strong style="font-size:inherit;">DELUXE</strong>', $product_title);
            $item_html .= '<tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;border-right: 0;line-height: 1.5;    vertical-align:top;">

		<p style=" margin: 0;font-size: 12pt;">' . $counter . '</p> 
		
       	      	
      </td>
      <td style="width:45%;font-size:14pt;padding: 10px;border-bottom: 1px solid #000;text-align: left;line-height: 1.5;    vertical-align:top;">
		<p style=" margin: 0;padding-left:0px; font-size: 14pt;">' . $product_title . '</p> 
		
      </td>

     
      <td style="width:30%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;    vertical-align:top;">
		<strong style="margin: 0;font-size: 12pt; ">' . $res->component_qty . '</strong>      	
		
      </td>
      <td style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;line-height: 1.5;    vertical-align:top;">
     	<p style=" margin: 0;font-size: 12pt;"><span style="display: inline-block; height: 13.5pt; width: 13.5pt; border: 1px solid #000; "></span></p>
     	 	     	     	
	      	      	
       </td>
    </tr>';
            $counter++;
        }
    }
    $order_id = $packing_array['order_id'];
    $order = wc_get_order($order_id);
    //    print_r($order);
    //    die();
    if ($order) {
        $packing_note = ' N/A';
        //$order_number =  smile_brillaint_get_sequential_order_number($packing_array['order_id']);
        $order_number = get_post_meta($order_id, 'order_number', true);
        $orderPackagingNote = get_post_meta($order_id, '_order_packaging_note', true);
        if (isset($packing_array['packing_note']) && $packing_array['packing_note'] != '') {
            $packing_note = $packing_array['packing_note'];
            update_post_meta($order_id, '_order_packaging_note', $packing_note);
            //         if ($orderPackagingNote) {
            //            $packing_note .= '<br/>'.$orderPackagingNote;
            //         }
        } else {
            if ($orderPackagingNote) {
                $packing_note = $orderPackagingNote;
            }
        }

        // Get Order ID and Key
        $order->get_id();
        $order->get_order_key();

        // Get Order Totals $0.00
        $order->get_formatted_order_total();
        $order->get_cart_tax();
        $order->get_currency();
        $order->get_discount_tax();
        $order->get_discount_to_display();
        $order->get_discount_total();
        $order->get_fees();
        //$order->get_formatted_line_subtotal();
        $order->get_shipping_tax();
        $order->get_shipping_total();
        $order->get_subtotal();
        $order->get_subtotal_to_display();
        //$order->get_tax_location();
        $order->get_tax_totals();
        $order->get_taxes();
        $order->get_total();
        $order->get_total_discount();
        $order->get_total_tax();
        $order->get_total_refunded();
        $order->get_total_tax_refunded();
        $order->get_total_shipping_refunded();
        $order->get_item_count_refunded();
        $order->get_total_qty_refunded();

        // Get Order Shipping
        $order->get_shipping_method();
        $order->get_shipping_methods();
        $order->get_shipping_to_display();

        // Get Order Dates

        $order->get_date_modified();
        $order->get_date_completed();
        $order->get_date_paid();

        // Get Order User, Billing & Shipping Addresses
        $order->get_customer_id();
        $order->get_user_id();
        $order->get_user();
        $order->get_customer_ip_address();
        $order->get_customer_user_agent();
        $order->get_created_via();
        $order->get_customer_note();
        //$order->get_address_prop();
        $order->get_billing_first_name();
        $order->get_billing_last_name();
        $order->get_billing_company();
        $order->get_billing_address_1();
        $order->get_billing_address_2();
        $order->get_billing_city();
        $order->get_billing_state();
        $order->get_billing_postcode();
        $order->get_billing_country();
        $order->get_billing_email();
        $order->get_billing_phone();
        $order->get_shipping_first_name();
        $order->get_shipping_last_name();
        $order->get_shipping_company();
        $order->get_shipping_address_1();
        $order->get_shipping_address_2();
        $order->get_shipping_city();
        $order->get_shipping_state();
        $order->get_shipping_postcode();
        $order->get_shipping_country();
        $order->get_address();
        $order->get_shipping_address_map_url();
        $order->get_formatted_billing_full_name();
        $order->get_formatted_shipping_full_name();
        $order->get_formatted_billing_address();
        $order->get_formatted_shipping_address();

        // Get Order Payment Details
        $order->get_payment_method();
        $order->get_payment_method_title();
        $order->get_transaction_id();

        // Get Order URLs
        $order->get_checkout_payment_url();
        $order->get_checkout_order_received_url();
        $order->get_cancel_order_url();
        $order->get_cancel_order_url_raw();
        $order->get_cancel_endpoint();
        $order->get_view_order_url();
        $order->get_edit_order_url();

        // Get Order Status
        $order->get_status();
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                </head><body><div style="max-width: 100%;
                margin: auto;">';
        $html .= '<h1 style="font-size:15pt;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;text-align: center;font-weight:bold;line-height: 1.5;">PACKING SLIP</h1>

<table style="border-collapse: collapse;margin: 0px auto;width: 100%;max-width: 100%;text-align: left;border-spacing: 0;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;table-layout: fixed;width: 100%;table-layout: fixed;
">
  <thead style="display:table-header-group;vertical-align: middle;border-color: inherit;">
    <tr style="display:table-row;vertical-align: inherit;border-color: inherit;">
 <th style="padding:10px;border: 0px solid #ccc;text-align: left;border-right: 0;font-weight: normal;line-height: 1.5;border-bottom: 1px solid #000;padding-bottom: 25px;">
 	<p style="font-size:14pt;font-weight: bold; margin: 0;color:#000;">Smile Brilliant </p>
<p style="font-size: 10pt;font-weight: normal; margin: 0; color:#000">' . $store_address . ', ' . $store_address_2 . $store_city . ', ' . $store_state  . $store_postcode . '<br>' . $woocommerce_store_phone . ' / ' . ' <a href="mailto:support@smilebrilliant.com" style="color:#000; text-decoration:none">support@smilebrilliant.com</a>
</p>
 </th>
 <th style="padding:10px;border: 0px solid #ccc;text-align: left;border-right: 0;font-weight: normal;line-height: 1.5;border-bottom: 1px solid #000;padding-bottom: 25px;">
 	<p style="font-size:10pt; margin: 0; width:fit-content; margin-left: auto;">
    <strong>Order #:</strong><strong style="font-size: 24px;">' . $order_number . '</strong><br>
 	<strong>Order Date: </strong> <span style="font-weight: normal;">' . sbr_datetime($order->get_date_created()) . '</span> <br>
 	<strong>Batch Print #: </strong> <span style="font-weight: normal;">' . $batchNo . ' </span><br>
 </th>
    </tr>
  </thea>
</table>

<table style="border-collapse: collapse;margin: 0px auto;width: 100%;max-width: 100%;text-align: left;margin-bottom: 0px;border-spacing: 0;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;table-layout: fixed;width: 100%;table-layout: fixed;
">
  <thead style="display:table-header-group;vertical-align: middle;border-color: inherit;">
    <tr style="display:table-row;vertical-align: inherit;border-color: inherit; border-top: 0px solid #000">
    </tr>
  </thea>
  <tbody>
    <tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td style="font-size:12pt;padding: 30px 10px;border-bottom: 1px solid #000;text-align: left;border-right: 0;line-height: 1.5;vertical-align: top;">

      <p style="margin:0px "><strong style="display: inline-block;padding-bottom: 1rem;">Shipping</strong><br>
      <strong style="font-size: 20px;">' . $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() . '</strong><br>
   ' . $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() . '<br>
   ' . $order->get_shipping_city() . ', ' . $order->get_shipping_country() . ' ' . $order->get_shipping_postcode() .
            '</p>
            
      </td>

      <td style="font-size:12pt;padding: 30px 10px;border-bottom: 1px solid #000;line-height: 1.5;vertical-align: top;"> 
      <p style="margin:0px;width: fit-content; margin-left: auto;""><strong style="display: inline-block;padding-bottom: 1rem;">Billing</strong><br><strong style="font-size: 20px;">' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '</strong><br>
      ' . $order->get_billing_address_1() . ' ' . $order->get_billing_address_2() . '<br>
      ' . $order->get_billing_city() . ', ' . $order->get_billing_country() . ' ' . $order->get_billing_postcode() . '<p/>   

</td>
    </tr>
    
  </tbody>
</table>';
        // Get and Loop Over Order Items

        /*
         * 
         *  <th style="width:15%; padding:10px;border-bottom: 1px solid #000;text-align: center;font-weight: bold;line-height: 1.5;">Qty<br>
          Ordered</th>
         */
        $html .= '<table style="border-collapse: collapse;margin: 20px auto;width: 100%;max-width: 100%;text-align: left;margin-bottom: 20px;margin-top: 0px;border-spacing: 0;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;table-layout: fixed;width: 100%;table-layout: fixed;
">
  <thead style="display:table-header-group;vertical-align: middle;border-color: inherit;">
    <tr style="display:table-row;vertical-align: inherit;border-color: inherit;">
 <th style="width:12%;padding:10px;border-bottom: 1px solid #000;text-align: left;border-right: 0;font-weight: bold;line-height: 1.5;">#<br>
</th>
 <th style="width:50%;padding:10px;border-bottom: 1px solid #000;text-align: left;font-weight: bold;line-height: 1.5; ">Product</th>
<th style="width:30%; padding:10px;border-bottom: 1px solid #000;text-align: center;font-weight: bold;line-height: 1.5;">Qty</th>
 <th style="width:12%;padding:10px;border-bottom: 1px solid #000;text-align: center;font-weight: bold;line-height: 1.5;">Check</th>
    </tr>
  </thea>

  <tbody>
    
    ' . $item_html . '
    
<tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td  colspan="6" style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;border-right: 0;line-height: 1.5;    vertical-align:top">

		<p style="padding-top: 5px; margin: 0; font-size: 16pt;">Packaging Note:<strong style="font-size: 26px;">' . $packing_note . '</strong></p> 

       	      	
      </td>


    </tr><tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td  colspan="6" style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;border-right: 0;line-height: 1.5;    vertical-align:top">
		<p style="padding-top: 5px; margin: 0; text-align:center;font-size: 12pt;">' . $package_name . ' (' . $groupID . ')' . '</p> 
      </td>


    </tr>';




        $html .= '</tbody>
</table>';
        if ($innercounter != 0) {
            $html .= '<p style="padding-top: 5px; margin: 0; font-size: 15pt;font-weight: bold; text-align:center;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif;">Finished Trays</p>';
        }
        $html .= '</div></body></html>';
    }
    /*
     * 
     * <tr style="display: table-row;vertical-align: inherit;border-color: inherit;">
      <td  colspan="6" style="width:12%;font-size:12pt;padding: 10px;border-bottom: 1px solid #000;text-align: center;border-right: 0;line-height: 1.5;    vertical-align:top;background-color: #f9f9f9 !important;">

      <p style="padding-top: 5px; margin: 0; ">Grand Total: <strong>' . $order->get_total() . ' &#36;</strong></p>


      </td>


      </tr>
     */
    if ($ret) {
        return $html;
    } else {
        echo $html;
    }
}
