<style>
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}    
.row {
    display: -ms-flexbox;
    display: flex;

    margin-right: -15px;
    margin-left: -15px;    

}
.col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
}

.inf-content {
    border: 1px solid #DDDDDD;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    box-shadow: 7px 7px 7px rgb(0 0 0 / 30%);  padding: 15px;
        background: #fff;
}
.img-circle {
    border-radius: 50%;
}
.img-thumbnail {
    display: inline-block;
    width: 100% \9;
    max-width: 100%;
    height: auto;
    padding: 4px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    height: 140px;
    width: 140px;
    max-width: 140px; max-height: 140px;    
}


@media (min-width: 576px){
    .col-sm-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-sm-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-sm-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
.col-sm-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
.col-sm-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
}
.col-sm-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
.col-sm-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%;
}

}


</style>

<?php
add_submenu_page('shop_order', 'Cusomer History', '', 'manage_options', 'customer_history', 'customer_purchase_history_mbt', '', null);

function customer_purchase_history_mbt() {
    $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
    if ($customer_id == '') {
        echo 'Customer Id is empty';
    } else {
        $customer_info = get_customer($customer_id);
        if (is_array($customer_info) && count($customer_info) > 0) {
            ?>
            <div class="mbt-row inf-content">
                <div class="customer_profile_mbt main">

                    <div class="row">
                        <div class="cust_info avatar-img col-sm-3"><img class="img-circle img-thumbnail isTooltip" src="<?php echo $customer_info['avatar_url']; ?>"> </div>
                        <div class="info-right-br col-sm-9">
                        <h3> Customer Information </h3>

                        <div class="table-responsive">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong> <span class="glyphicon glyphicon-asterisk text-primary"></span> First Name:</strong>
                                        </td>
                                        <td class="text-primary"> <?php echo $customer_info['first_name']; ?></td>                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>





                        <div class="cust_info"><strong>First Name:</strong></div>
                        <div class="cust_info"><strong>Last Name:</strong><?php echo $customer_info['last_name']; ?></div>
                        <div class="cust_info"><strong>Email:</strong><?php echo $customer_info['email']; ?></div>

                    <h3> Billing Information </h3>

                    <div class="cust_info"><strong>First Name:</strong><?php echo $customer_info['billing_address']['first_name']; ?></div>
                    <div class="cust_info"><strong>Last Name:</strong><?php echo $customer_info['billing_address']['last_name']; ?></div>
                    <div class="cust_info"><strong>Email:</strong><?php echo $customer_info['billing_address']['email']; ?></div>
                    <div class="cust_info"> <strong>Address 1:</strong><?php echo $customer_info['billing_address']['address_1']; ?> </div>
                    <div class="cust_info"> <strong>Address 2:</strong><?php echo $customer_info['billing_address']['address_2']; ?> </div>
                    <div class="cust_info"> <strong>city:</strong><?php echo $customer_info['billing_address']['city']; ?> </div>
                    <div class="cust_info"> <strong>state:</strong><?php echo $customer_info['billing_address']['state']; ?> </div>
                    <div class="cust_info"> <strong>postcode:</strong><?php echo $customer_info['billing_address']['postcode']; ?> </div>
                    <div class="cust_info"> <strong>phone:</strong><?php echo $customer_info['billing_address']['phone']; ?> </div>


                    </div>
                    </div>

                </div>
                <div class="customer_profile_mbt billing">



                </div>
                <div class="customer_profile_mbt shipping">
                    <h3> Shipping Information </h3>

                    <div class="cust_info"><strong>First Name:</strong><?php echo $customer_info['shipping_address']['first_name']; ?></div>
                    <div class="cust_info"><strong>Last Name:</strong><?php echo $customer_info['shipping_address']['last_name']; ?></div>

                    <div class="cust_info"> <strong>Address 1:</strong><?php echo $customer_info['shipping_address']['address_1']; ?> </div>
                    <div class="cust_info"> <strong>Address 2:</strong><?php echo $customer_info['shipping_address']['address_2']; ?> </div>
                    <div class="cust_info"> <strong>city:</strong><?php echo $customer_info['shipping_address']['city']; ?> </div>
                    <div class="cust_info"> <strong>state:</strong><?php echo $customer_info['shipping_address']['state']; ?> </div>
                    <div class="cust_info"> <strong>postcode:</strong><?php echo $customer_info['shipping_address']['postcode']; ?> </div>
                    <div class="cust_info"> <strong>phone:</strong><?php echo $customer_info['shipping_address']['phone']; ?> </div>

                </div>
                <div class="customer_orders">
                    <div class="order_row"> 
                        <div class="order_row_info">
                        <strong>Order Id</strong>
                        </div>
                        <div class="order_row_info">
                        <strong>Order Total</strong>
                        </div>
                        <div class="order_row_info">
                        <strong>Order Discount</strong>
                        </div>
                        <div class="order_row_info">
                        <strong>Order Tax</strong>
                        </div>
                        <div class="order_row_info">
                         <strong>Order Shipping</strong>
                        </div>
                        <div class="order_row_info">
                         <strong>Order Date</strong>
                        </div>
                        <div class="order_row_info">
                         <strong>Edit/View</strong>
                        </div>
                    </div>
                    <?php
                    $order_statuses = array('wc-completed');
                    $customer_user_id = $customer_id; // current user ID 
// Getting current customer orders
                    $customer_orders = wc_get_orders(
                            array(
                                'meta_key' => '_customer_user',
                                'meta_value' => $customer_user_id,
                                'post_status' => '',
                                'numberposts' => -1
                            )
                    );
                    foreach ($customer_orders as $order) {
                        
                       // $order = wc_get_order($order_id);
                        if ($order) {
                           
                            // Get Order ID and Key
//                            $order->get_id();
//                            $order->get_order_key();
//
//                            // Get Order Totals $0.00
//                            $order->get_formatted_order_total();
//                            $order->get_cart_tax();
//                            $order->get_currency();
//                            $order->get_discount_tax();
//                            $order->get_discount_to_display();
//                            $order->get_discount_total();
//                            $order->get_fees();
//                            $order->get_formatted_line_subtotal();
//                            $order->get_shipping_tax();
//                            $order->get_shipping_total();
//                            $order->get_subtotal();
//                            $order->get_subtotal_to_display();
//                            $order->get_tax_location();
//                            $order->get_tax_totals();
//                            $order->get_taxes();
//                            $order->get_total();
//                            $order->get_total_discount();
//                            $order->get_total_tax();
//                            $order->get_total_refunded();
//                            $order->get_total_tax_refunded();
//                            $order->get_total_shipping_refunded();
//                            $order->get_item_count_refunded();
//                            $order->get_total_qty_refunded();
//                            $order->get_qty_refunded_for_item();
//                            $order->get_total_refunded_for_item();
//                            $order->get_tax_refunded_for_item();
//                            $order->get_total_tax_refunded_by_rate_id();
//                            $order->get_remaining_refund_amount();
                            ?>
                    
                    <div class="order_row">
                        <div class="order_row_info">
                             <?php echo $order->get_id(); ?>
                         </div>
                         <div class="order_row_info">
                              <?php echo $order->get_formatted_order_total(); ?>
                         </div>
                         <div class="order_row_info">
                             <?php echo $order->get_total_discount(); ?>
                         </div>
                         <div class="order_row_info">
                              <?php echo $order->get_total_tax(); ?>
                         </div>
                         <div class="order_row_info">
                             <?php echo $order->get_shipping_total(); ?>
                         </div>
                         <div class="order_row_info">
                              <?php echo $order->get_date_created()->date('Y-m-d'); ?>
                         </div>
                         <div class="order_row_info">
                             <?php echo edit_post_link('Edit','','',$order->get_id());?>
                         </div>
                       
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <style>
                .customer_profile_mbt{
                    float:left;
                    width:40%;
                }
                .customer_orders{
                    display: block;
                    clear:both;
                    
                }
                .order_row {
                    display: inline-flex;
                }
                .order_row_info{
                    width:220px;
                }
            </style>
            <?php
        }
        //print_r($customer_info);
    }
}

function get_customer($id) {
    global $wpdb;

    $customer = new WC_Customer($id);
    $last_order = $customer->get_last_order();
    $customer_data = array(
        'id' => $customer->get_id(),
        //'created_at'       => $this->server->format_datetime( $customer->get_date_created() ? $customer->get_date_created()->getTimestamp() : 0 ), // API gives UTC times.
        'email' => $customer->get_email(),
        'first_name' => $customer->get_first_name(),
        'last_name' => $customer->get_last_name(),
        'username' => $customer->get_username(),
        'last_order_id' => is_object($last_order) ? $last_order->get_id() : null,
        // 'last_order_date'  => is_object( $last_order ) ? $this->server->format_datetime( $last_order->get_date_created() ? $last_order->get_date_created()->getTimestamp() : 0 ) : null, // API gives UTC times.
        'orders_count' => $customer->get_order_count(),
        'total_spent' => wc_format_decimal($customer->get_total_spent(), 2),
        'avatar_url' => $customer->get_avatar_url(),
        'billing_address' => array(
            'first_name' => $customer->get_billing_first_name(),
            'last_name' => $customer->get_billing_last_name(),
            'company' => $customer->get_billing_company(),
            'address_1' => $customer->get_billing_address_1(),
            'address_2' => $customer->get_billing_address_2(),
            'city' => $customer->get_billing_city(),
            'state' => $customer->get_billing_state(),
            'postcode' => $customer->get_billing_postcode(),
            'country' => $customer->get_billing_country(),
            'email' => $customer->get_billing_email(),
            'phone' => $customer->get_billing_phone(),
        ),
        'shipping_address' => array(
            'first_name' => $customer->get_shipping_first_name(),
            'last_name' => $customer->get_shipping_last_name(),
            'company' => $customer->get_shipping_company(),
            'address_1' => $customer->get_shipping_address_1(),
            'address_2' => $customer->get_shipping_address_2(),
            'city' => $customer->get_shipping_city(),
            'state' => $customer->get_shipping_state(),
            'postcode' => $customer->get_shipping_postcode(),
            'country' => $customer->get_shipping_country(),
        ),
    );

    return $customer_data;
}
?>