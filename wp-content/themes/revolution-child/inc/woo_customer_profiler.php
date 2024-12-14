<?php
add_action( 'admin_menu', 'register_my_custom_menu_page_sbr' );
function register_my_custom_menu_page_sbr(){
    add_submenu_page('shop_order', 'Customer History', '', 'manage_options', 'customer_history', 'customer_purchase_history_mbt');
}


function customer_purchase_history_mbt() {
    $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
    if ($customer_id == '') {
        echo 'Customer Id is empty';
    } else {
        $customer_info = get_customer($customer_id);
        if (is_array($customer_info) && count($customer_info) > 0) {
            ?>
            <div class="mbt-row inf-content">
                <div class="customer_profile_mbt main contianer">

                    <div class="row justify-content-center">
                        <div class="cust_info avatar-img col-sm-2"><img class="img-circle img-thumbnail isTooltip" src="<?php echo $customer_info['avatar_url']; ?>"> </div>
                        <div class="info-right-br col-sm-4">
                            <h3> Customer Information </h3>
                            <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-users"></span> First Name:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['first_name']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-cloud"></span> Last Name:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['last_name']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-email"></span> Email:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['email']; ?></td>                                       
                                        </tr>
                                        <?php $geha_user = get_user_meta($customer_id,'geha_user',true);
                                        if($geha_user == 'yes'){
                                            ?>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-email"></span> Geha:</strong>
                                            </td>
                                            <td class="text-primary">Yes</td>                                       
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                         <?php $hfa_hsa = get_user_meta($customer_id,'hfa_hsa',true);
                                        if($hfa_hsa == 'yes'){
                                            ?>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-email"></span> HSA/FSA:</strong>
                                            </td>
                                            <td class="text-primary">Yes</td>                                       
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="row justify-content-center">                
                        <div class="col-sm-4">


                            <h3> Billing Information  </h3>
                            <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-users"></span> First Name:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['billing_address']['first_name']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-cloud"></span> Last Name:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $customer_info['billing_address']['last_name']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-email"></span>  Email:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['billing_address']['email']; ?></td>                                       
                                        </tr>




                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-welcome-write-blog"></span> Address 1:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['billing_address']['address_1']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-page"></span> Address 2:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $customer_info['billing_address']['address_2']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-admin-post"></span> City:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $customer_info['billing_address']['city']; ?> </td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-columns"></span> State:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $customer_info['billing_address']['state']; ?></td>                                       
                                        </tr>


                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-screenoptions"></span> Postcode:</strong>
                                            </td>
                                            <td class="text-primary"> <?php echo $customer_info['billing_address']['postcode']; ?></td>                                       
                                        </tr>

                                        <tr>
                                            <td>
                                                <strong> <span class="dashicons dashicons-phone"></span> Phone:</strong>
                                            </td>
                                            <td class="text-primary"><?php echo $customer_info['billing_address']['phone']; ?></td>                                       
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>



                        <div class="col-sm-4">
                            <div class="customer_profile_mbt shipping ">
                                <h3> Shipping Information </h3>

                                <div class="table-responsive">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-users"></span> First Name:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $customer_info['shipping_address']['first_name']; ?></td>                                       
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-cloud"></span> Last Name:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $customer_info['shipping_address']['last_name']; ?></td>                                       
                                            </tr>


                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-welcome-write-blog"></span> Address 1:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $customer_info['shipping_address']['address_1']; ?></td>                                       
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-page"></span> Address 2:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $customer_info['shipping_address']['address_2']; ?></td>                                       
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-admin-post"></span> City:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $customer_info['shipping_address']['city']; ?> </td>                                       
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-columns"></span> State:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $customer_info['shipping_address']['state']; ?></td>                                       
                                            </tr>


                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-screenoptions"></span> Postcode:</strong>
                                                </td>
                                                <td class="text-primary"> <?php echo $customer_info['shipping_address']['postcode']; ?> </td>                                       
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> <span class="dashicons dashicons-phone"></span> Phone:</strong>
                                                </td>
                                                <td class="text-primary"><?php echo $customer_info['shipping_address']['phone']; ?></td>                                       
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <a  class="edit_buyer_info button button-small" href="<?php echo get_edit_user_link($customer_id); ?>&nored=true">Edit Buyer Information</a>
                        </div>
                    </div>

                </div>




                <div class="customer_orders">
                    <h3>Customer's Purchase History</h3>
                    <?php
                    $order_statuses = array('wc-completed');
                    $customer_user_id = $customer_id; // current user ID 
// Getting current customer orders
                    $customer_orders = wc_get_orders(
                            array(
                                'meta_key' => '_customer_user',
                                'meta_value' => $customer_user_id,
                                'post_status' => 'any',
                                'numberposts' => -1
                            )
                    );
                    foreach ($customer_orders as $order) {

                        // $order = wc_get_order($order_id);
                        if ($order) {
                            break;
                            ?>
                            <?php
                        }
                    }
                    $c_history_obj = new WCCH_Show_History();
                    $c_history_obj->render_purchase_history($order);
                    ?>
                </div>
            </div>
            <style>
                .edit_buyer_info {
                    margin: 0 auto;
                    display: block;
                    width: 135px
                }
                .spacing-wrapper.clearfix table tr{
                    background: #f7f7f7 !important;
                    font-weight: 400 !important;
                }
                .customer_orders .spacing-wrapper.clearfix p{
                    display:none;
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


                .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto,.container {
                    position: relative;
                    width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                }    
                .row {
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
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
                    border-radius: 6px;
                    box-shadow: 7px 7px 7px rgb(0 0 0 / 30%);
                    padding: 15px;
                    background: #fff;
                    max-width: 96%;
                    margin-left: auto;
                    margin-right: auto;
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
                .table {
                    width: 100%;
                    max-width: 100%;
                    margin-bottom: 20px;
                }
                .inf-content table {
                    background-color: transparent;
                }
                .inf-content table {
                    border-spacing: 0;
                    border-collapse: collapse;
                }

                .inf-content .table>thead>tr>th,.inf-content  .table>tbody>tr>th,.inf-content  .table>tfoot>tr>th,.inf-content  .table>thead>tr>td,.inf-content  .table>tbody>tr>td,.inf-content  .table>tfoot>tr>td {
                    padding: 8px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 1px solid #ddd;
                }

                .inf-content td.text-primary {
                    text-align: right;
                }
                .inf-content  span.dashicons {
                    color: #428bca;

                }

                .inf-content .container {
                    max-width: 80%;
                }
                .justify-content-center {
                    -ms-flex-pack: center;
                    justify-content: center;
                }
                .cust_info.avatar-img {
                    text-align: center;
                }
                .customer_profile_mbt.main.contianer {
                    margin-bottom: 4rem;
                }

                .inf-content h3 {
                    text-transform: uppercase;
                }
                @media (min-width: 576px){

                    .col-sm-2 {
                        -ms-flex: 0 0 16.666667%;
                        flex: 0 0 16.666667%;
                        max-width: 16.666667%;
                    }    
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