<?php
/*

Template Name: Secure Page

*/
if (WP_ENV != 'production') {
    die();
}
if ( ! defined( 'ABSPATH' ) ) exit;
$green_colors = array('processing','partial_ship','shipped','completed');
$alert_color = "danger";
$order_id = get_query_var('pending_order_id');
if($order_id =='') {
    die("not a valid order id");
}

if ( !wp_get_referer() && !$_POST['dataValue'] && !isset($_GET['key'])) {
    die("not a valid referral");
}
$order = wc_get_order($order_id);
//$order_items           = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note    = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
$order_status = $order->get_status();
if(in_array($order_status,$green_colors)) {
    $alert_color = "success";
}
?>
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">

<script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:968379,hjsv:5};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
<link rel='stylesheet' id='thb-google-fonts-css' href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C500%2C600%2C700%2C800%2C300i%2C400i%2C500i%2C600i%2C700i%2C800i%7CMontserrat%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100i%2C200i%2C300i%2C400i%2C500i%2C600i%2C700i%2C800i%2C900i&#038;subset=latin&#038;display=swap&#038;ver=2.2.4' media='all' />
<style>
    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        margin: 0;
    }

    h3.orderHeading,h2.woocommerce-column__title {
        font-size: 22px;
        margin-top: 20px;
        color: #212529;
        font-family: "Montserrat";
        text-transform: uppercase;font-weight: 500;
    }


a{
    color: #4597cb;
}
    .orderDetailTable {
        background: #f4f4f4;
        margin-bottom: 0px;    border-spacing: 0;
    }

    .orderDetailTable {
        margin-top: 10px;
        margin-bottom: 0px !important;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-spacing: 0;
    }


    table:not(.variations):not(.shop_table):not(.group_table) thead,
    table:not(.variations):not(.shop_table):not(.group_table) tbody,
    table:not(.variations):not(.shop_table):not(.group_table) tfoot {
        border: 1px solid #f1f1f1;
        background-color: #fefefe;
    }

    table:not(.variations):not(.shop_table):not(.group_table) thead tr,
    table:not(.variations):not(.shop_table):not(.group_table) tfoot tr {
        background: transparent;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .alert-success {
    color: #0f5132;
    background-color: #d1e7dd;
    border-color: #badbcc;
}



    .woocommerce-payment-methods table.woocommerce-MyAccount-paymentMethods.shop_table.shop_table_responsive.account-payment-methods-table span.nobr,
    .woocommerce-edit-address .myAccountContainerMbtInner h3,
    .deskTopOnly.orderDetail .orderDetailTable thead th,
    .woocommerce-view-order .orderCustomerDetailTable section.woocommerce-customer-details .woocommerce-column__title,
    #SBRCustomerDashboard .affwp-table.affwp-table-responsive th,
    #getCustomerMyAccountOrders .table-responsive thead tr th {
        font-size: 14px;
        font-weight: 400;
        text-transform: uppercase;
        font-family: 'Open Sans', sans-serif;
        color: #343434;
    }

    .orderDetailTable thead th {
        background: #f8f8f8;font-weight: 600;
    }


    .orderDetailTable th,
    .orderDetailTable td {
        border: 1px solid #f3efef;
        padding: 0.5rem 0.625rem 0.625rem;
        font-weight: normal;
        text-align: left;
        font-weight: 400;
         font-size: 16px;        
         font-family: 'Open Sans', 'BlinkMacSystemFont', -apple-system, 'Roboto', 'Lucida Sans';         
    }

    th.woocommerce-table__product-name.product-name {
        width: 70%;
    }

    .flex-row {
        display: flex;
    }

    .item-name-mbt {
        padding-left: 10px;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 0px !important;
    color: #212529;
    text-align: left;
    font-weight: 400;
    }
    .item-name-mbt a {
        text-decoration: none;
    }    
    strong.product-quantity {
    display: inline-block;
    padding-left: 4px;
    padding-right: 4px;
    font-size: 120%;
}
ul.wc-item-meta {
 
    background: #efefefb8;
    padding: 6px 6px;
    list-style: none;
    margin: 1px;
    border: 1px dashed #3c98cc3d;display: none;
}
ul.wc-item-meta li {
    display: flex;
    align-items: center;
}
ul.wc-item-meta p {
    margin: 0;
    margin-left: 6px;
    color: #3c98cc;

}
    .wrapper {
        padding-left: 15px;
    padding-right: 15px;
    width: 100%;
    max-width: 1120px;
    margin-left: auto;
    margin-right: auto;
    border: 3px dashed #edeaea;
    margin-top: 5px;
    }

 section.woocommerce-customer-details {
    border: 1px solid #eaeaea;
    padding: 10px;
    width: 100%;    margin-top: 20px;
}
.addresses .col-1, .addresses .col-2 {
    width: 100%;
    padding: 0 15px;
}
section.woocommerce-customer-details .addresses .col-1, section.woocommerce-customer-details .addresses .col-2 {
    width: 50%;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
address {
    margin-bottom: 1rem;
    font-style: normal;
    line-height: inherit;
}
h2.woocommerce-order-details__title {
    display: block;
    font-size: 30px;
    text-transform: uppercase;
    font-family: "Montserrat";
    font-weight: 300;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #3c98cc;
}

h3.orderHeading {
    font-size: 22px;
    margin-top: 10px;
    color: #212529;
    font-family: "Montserrat";
    text-transform: uppercase;
    font-weight: 500;
    margin-bottom: 10px;
}
header#sbr-header {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
    /* border-bottom: 1px solid #f3efef; */
    padding: 10px 0;
}

header#sbr-header img {
    max-width: 180px;
}
form#paymentForm button {
    padding: 8px;
    font-size: 18px;
    background-color: #3c98cc;
    border-color: #3382af;
    color: #fff;
    padding: 10px 20px;
    border: 2px solid;
    font-weight: 400;
    font-family: 'Montserrat';
    letter-spacing: .2em;
    text-shadow: none;
    text-transform: uppercase;
    cursor: pointer;
    margin-left: -3px;
    margin-top: 5px;
    margin-left: auto;
    margin-right: auto;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 18px;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    height: auto;
    padding: 10px 40px;
    border-radius: 40px;
    border: 2px solid;
    font-weight: 300;
    border-width: 1px;
    border-radius: 0;
    font-family: 'Montserrat';
    letter-spacing: .2em;
    text-shadow: none;
    margin-top: 16px;
}
form#paymentForm {
    text-align: center;
}
form#paymentForm button:hover{
    background-color: #595858;
    border-color: #595858;
}


.order-processing-message {
        position: fixed;
        width: 100%;
        height: 100%;
        background: #00000096;
        z-index: 999999999;
        top: 0;
        display: none;    left: 0;
    }

    .message-processing {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        letter-spacing: 1px;
        background: #3498db;
        z-index: 99;
    }

    .loading-animate:after {
        content: ' .';
        animation: dots 1s steps(5, end) infinite;
    }

    @keyframes dots {

        0%,
        20% {
            color: rgba(0, 0, 0, 0);
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        40% {
            color: white;
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        60% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        80%,
        100% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 white;
        }
    }


.loading:before, .loading-mbt:before {
    content: "";
    border: 10px solid #f3f3f3;
    border-top-color: #f3f3f3;
    border-top-style: solid;
    border-top-width: 10px;
    border-radius: 50%;
    border-top: 10px solid #3498db;
    width: 40px;
    height: 40px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    position: absolute;
    z-index: 99;
    top: 0;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
}

.loading:before,.loading-mbt:before{content:"";border:10px solid #f3f3f3;border-top-color:#f3f3f3;border-top-style:solid;border-top-width:10px;border-radius:50%;border-top:10px solid #3498db;width:40px;height:40px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite;position:absolute;z-index:99;top:0;left:0;right:0;margin-left:auto;margin-right:auto}
@-webkit-keyframes spin {
0%{-webkit-transform:rotate(0deg)}
100%{-webkit-transform:rotate(360deg)}
}
@keyframes spin {
0%{transform:rotate(0deg)}
100%{transform:rotate(360deg)}
}

.alert {
    position: relative;
    padding: 1rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}
.alert-danger {
    color: #842029;
    background-color: #f8d7da;
    border-color: #f5c2c7;
}
.loading-mbt:before {
    top: 50%;
    margin-top: -25px;
    border: 16px solid #e2e2e2;
    border-top-color: #d40000;
    border-top-width: 16px;
    border-top: 16px solid #3498db;
    width: 60px;
    height: 60px;
    top: 50%;
    margin-top: -25px;
}
section.woocommerce-columns.woocommerce-columns--2.woocommerce-columns--addresses.col2-set.addresses{
    display: flex;
    flex-wrap: wrap;
}

@media only screen and (max-width: 767px) {
    .item-name-mbt,.orderDetailTable th, .orderDetailTable td{
        font-size: 14px;
    }
    section.woocommerce-customer-details .addresses .col-1, section.woocommerce-customer-details .addresses .col-2 {
    width: 100%;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
h2.woocommerce-order-details__title{
    font-size: 22px;
}
form#paymentForm button{
    width: 100%;
}

}
</style>

<header id="sbr-header" class="sbr-header-mbt header dark-header headroom headroom--top headroom--not-bottom">

    <a href="https://smilebrilliant.com/" class="navbar-brand navbar-center-cell" title="Smile Brilliant">
        <img src="https://smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logo-vertical-nosub-584x162-1.png" class="logoimg logo-light" alt="Smile Brilliant">
    </a>

</header>

<div class="wrapper">

  <?php
  if (isset($_POST['dataValue']) && $_POST['dataValue']!='' && $order_status == 'pending') {
    $data_value =  $_POST['dataValue'];
    $dataDescriptor =  $_POST['dataDescriptor'];
    $order_id =  $_POST['order_id'];
    $expiry_date =  $_POST['exp_date'];
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // die();
    $resp = sbr_chargeCreditCardPayOrder(array('order_id' => $order_id, 'description' => $dataDescriptor, 'token' => $data_value,'expiry_date'=> $expiry_date));
}
if($order_status != 'pending') {
    echo '<div class="alert alert-'.$alert_color.'" role="alert">
    Order Status: '.$order_status.'
    </div>';
}
?>



    <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>

    <h3 class="orderHeading"><?php echo $order->get_order_number();?> </h3>

    <div class="content_top">


    <div class="loading-sbr order-processing-message loading-mbt" id="custom-loadder-mbt">
        <div class="inner-sbr message-processing loading-animate"> ORDER PROCESSING</div>
    </div>


    <table class="table table-bordered orderDetailTable">

        <thead>
            <tr>
                <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            do_action('woocommerce_order_details_before_order_table_items', $order);

            $orderItemArray = array();
            $counterItem = array();
            $Orderhtml = '';
            $order_items = $order->get_items();
            foreach ($order_items as $item_id => $item) {
                $product_id = $item->get_product_id();
                if (wc_cp_get_composited_order_item_container($item, $order)) {
                    continue;
                } else {
                    if (isset($counterItem[$product_id])) {
                        $counterItem[$product_id] = $counterItem[$product_id] + 1;
                    } else {
                        $counterItem[$product_id] = $item->get_quantity();
                    }
                }

                $orderItemArray[$product_id] = array(
                    'quantity' => $counterItem[$product_id],
                    'item_id' => $item_id,
                );
            }

            foreach ($orderItemArray as $product_id => $itemDeatil) {
                $item = $order_items[$itemDeatil['item_id']];
                $product = $item->get_product();
                $item_id = $itemDeatil['item_id'];
                $get_quantity = $itemDeatil['quantity'];


                wc_get_template(
                        'order/order-details-item.php', array(
                    'order' => $order,
                    'item_id' => $item_id,
                    'item' => $item,
                    'quantity' => $get_quantity,
                    'show_purchase_note' => $show_purchase_note,
                    'purchase_note' => $product ? $product->get_purchase_note() : '',
                    'product' => $product,
                        )
                );
            }
            
            do_action('woocommerce_order_details_after_order_table_items', $order);
            ?>
        </tbody>

        <tfoot>
            <?php
            foreach ($order->get_order_item_totals() as $key => $total) {
            ?>
                <tr>
                    <th scope="row"><?php echo esc_html($total['label']); ?></th>
                    <td><?php echo ('payment_method' === $key) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                        ?></td>
                </tr>
            <?php
            }
            ?>
            <?php if ($order->get_customer_note()) : ?>
                <tr>
                    <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>

    <?php do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id());
     if($order_status == 'pending') {
        wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
     }
    ?>
    <?php
    if (get_query_var('pending_order_id', '') != '' && $order_status == 'pending') {
        
    ?>
    <script type="text/javascript" src="https://js.authorize.net/v3/AcceptUI.js" charset="utf-8">
</script>
        <form id="paymentForm" method="POST" action="https://www.smilebrilliant.com/secure-payment/order-id/<?php echo get_query_var('pending_order_id'); ?>">
            <input type="hidden" name="dataValue" id="dataValue" />
            <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
            <input type="hidden" name="exp_date" id="dataExp" />
            
            <input type="hidden" name="order_id" value="<?php echo get_query_var('pending_order_id'); ?>" />
            <button type="button" class="AcceptUI" data-billingAddressOptions='{"show":false, "required":false}' data-apiLoginID="<?php echo SB_AUTHORIZE_LOGIN_ID;?>" data-clientKey="3uBfyuHcG55dGK8L9MzT8s3ZY7QRYNnc5A3Rg8myAGeUgn6QQzxT4362Dm46SAH8" data-acceptUIFormBtnTxt="Submit" data-acceptUIFormHeaderTxt="Card Information" data-responseHandler="responseHandler">Proceed To Pay
            </button>
        </form>

        </div>
       


</div>
</div>
<script type="text/javascript">
    function responseHandler(response) {
        if (response.messages.resultCode === "Error") {
            var i = 0;
            while (i < response.messages.message.length) {
                console.log(
                    response.messages.message[i].code + ": " +
                    response.messages.message[i].text
                );
                i = i + 1;
            }
        } else {
            response_data = paymentFormUpdate(response.opaqueData,response.encryptedCardData);
            console.log(response_data);
        }
    }


    function paymentFormUpdate(opaqueData,encryptedCardData) {
        console.log(opaqueData);
       
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;
        document.getElementById("dataExp").value = encryptedCardData.expDate;

        // If using your own form to collect the sensitive data from the customer,
        // blank out the fields before submitting them to your server.
        // document.getElementById("cardNumber").value = "";
        // document.getElementById("expMonth").value = "";
        // document.getElementById("expYear").value = "";
        // document.getElementById("cardCode").value = "";
        document.getElementById('custom-loadder-mbt').style.display = 'block';
        document.getElementById("paymentForm").submit();
    }
</script>

<?php
    }
?>