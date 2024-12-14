<?php
/**
 * Filter function for determining whether stock reduction is allowed for an order.
 *
 * @param bool $true      Default value indicating whether stock reduction is allowed.
 * @param int  $order_id  The ID of the order being processed.
 * @return bool           Whether stock reduction is allowed.
 */
function filter_woocommerce_can_reduce_order_stock($true, $order_id) {

    $order_type = get_post_meta($order_id, 'order_type', true);
    if ($order_type == 'Split') {
        return false;
    } else {
        return true;
    }
}

//add_filter('woocommerce_payment_complete_reduce_order_stock', 'filter_woocommerce_can_reduce_order_stock', 10, 2);

add_action('wp_ajax_split_order', 'split_order_callback');
/**
 * Function for order split in 3-ways products popup Dashboard
 *
 */
function split_order_callback() {
    global $wpdb;
    create_order_style_mbt();
    $order_id = $_REQUEST['order_id'];
    $log_id = $_REQUEST['log_id'];
    $order = wc_get_order($order_id);
    $orderSBRref = get_post_meta($order_id, 'order_number', true);
    $user_id = $order->get_user_id();
    echo ' <h2 class="addonpouptitle">Split Order Request against Order# ' . $orderSBRref . '</h2>';
    // echo '<h2> Create Order</h2>';
    echo '<div id="smile_brillaint_addNewOrder">';
    // mbt_goodToShip($order_id);
    ?>


    <div class="loading-element" style="display:none"><span class="spinner is-active"></span></div>
    <form id="addOn_order_form" class="addon-order-form-mbt split_order_popup">




        <div class="bg-light create-ordr-mbt-tp">
            <div class="flex-row">

                <div class="col-sm-6">
                    <div class="clr-bx">
                        <p class="form-field form-field-wide wc-customer-user">
                            <!--email_off-->
                            <!-- Disable CloudFlare email obfuscation -->
                            <label for="customer_user_mbt">
                                <b>Select a Customer</b>
                                <select class="customer_user_mbt form-control" data-placeholder="Select a Customer"
                                        data-allow_clear="true" style="width:500px" name="customer_user_mbt"></select>
                                <!--/email_off-->
                            </label>
                        </p>
                    </div>
                </div>


                <div class="button-create-customer">
                    <label class="opacity-zero">Create Customer</label>
                    <!-- space-tp-ad -->
                    <a class="openpop button" href="javascript:void(0)">Create Customer</a>
                </div>

                <div class="checkbox-button-create-customer">
                    <label class="opacity-zero">Create Customer</label>
                    <div class="flex-row">
                        <p class="form-field form-field-wide ml-20">
                            <label for="customer_send_email">
                                <input class="customer_send_email form-control" type="checkbox" checked="checked"
                                       id="customer_send_email" name="customer_send_email" value="yes" /> Send order email to
                                customer
                            </label>
                        </p>
                        <p class="form-field form-field-wide ml-20">
                            <label for="customer_send_email_invoice">
                                <input class="customer_send_email_invoice form-control" type="checkbox" checked="checked"
                                       id="customer_send_email_invoice" name="customer_send_email_invoice" value="yes" /> Send
                                invoice
                                email to customer
                            </label>
                        </p>
                    </div>
                </div>


            </div>




            <div class="flex-row">


            </div>


        </div>

        <div id="customerBillingShippingDetails"></div>
        <?php
        echo '<table class="widefat" id="old_addon-table"><thead>';
        echo '<tr>';
        echo '<th>Product</th>';
        echo '<th>Tray#</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead><tbody>';

        foreach ($order->get_items() as $item_id => $item) {
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                continue;
            }
            $product = $item->get_product();
            $pro_price = $product->get_price();
            $item_quantity = $item->get_quantity(); // Get the item quantity
            $product_id = $item->get_product_id();
            $qtyShipped = 0;

            $rmaShippedQty = 0;
            $type = 'simple';
            $three_way_ship_product = get_post_meta($product_id, 'three_way_ship_product', true);
            if ($three_way_ship_product) {
                $type = 'composite';
                $shippedhistory = wc_get_order_item_meta($item_id, '_shipped_count', true);
                if ($shippedhistory) {
                    $rmaShippedQty = 1;
                } else {
                    $rmaShippedQty = 0;
                }
            } else {
                $shippedhistory = wc_get_order_item_meta($item_id, 'shipped', true);
                if ($shippedhistory) {
                    foreach ($shippedhistory as $shippedhistoryDate => $shippedhistoryQty) {
                        $qtyShipped += (int) $shippedhistoryQty;
                    }
                }
                $rmaShippedQty = $qtyShipped;
            }
            if ($type == 'simple') {
                continue;
            }
            $query = "SELECT event_id FROM  " . SB_LOG;
            $query .= " WHERE item_id = " . $item_id . " AND product_id = " . $product_id . " AND order_id = " . $order_id;
            $query .= " ORDER BY log_id DESC";
            $query_q0 = $wpdb->get_var($query);
            if ($query_q0 == 17) {
                continue;
            }
            ?>

            <tr id="parentAddonTr">
                <td>
                    <strong><?php echo get_the_title($product_id); ?></strong>
                </td>
                <td>
                    <?php
                    $query_tray_no = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id");
                    if ($query_tray_no == '') {
                        $query_tray_no = 'N/A';
                    }
                    ?>
                    <strong><?php echo $query_tray_no; ?></strong>
                </td>

                <td>
                    <a href="javascript:;"  onclick="addRMAProducts(<?php echo $item_id ?>, <?php echo $product_id ?>, '<?php echo $pro_price ?>', '<?php echo get_the_title($product_id) ?>', '<?php echo $query_tray_no ?>', <?php echo $rmaShippedQty; ?>, '<?php echo $type; ?>')" class="addRMAProduct">Add Product</a>

                </td>
            </tr>

            <?php
        }
        $price = number_format($orderPriceTotal, 2);
        echo ' </tbody>';
        echo ' </table>';

        echo '<table class="widefat" id="split-order-table"><thead>';
        echo '<tr>';
        echo ' <th>Product</th>';
        echo ' <th>Tray#</th>';
        echo ' <th>Price</th>';
        echo ' <th>Qty</th>';
        echo ' <th>Discount (%)</th>';
        echo ' <th>Sub Total</th>';
        echo ' <th>Action</th>';
        echo '</tr>';
        echo ' </thead><tbody>';
        echo ' </tbody>';

        echo ' </table>';
        ?>

        <div class="flex-row add-buttonss">
            <div class="col-sm-12">
                <button id="add_split_product_btn" class="button" type="button">Add Product</button>
                <!--                <button id="apply_a_coupon_create_order" onclick="addCouponToOrder()" class="button" type="button">Apply a
                                    gift code</button>-->
            </div>

        </div>

        <div id="customerPaymentDetails" style="display: none"></div>

        <div id="addon_summery">
            <div class="widefat">
                <div class="tbody flex-row">
                    <div class="tr-div" style="display: none">
                        <td><b>Email</b></td>
                        <td style="text-align: left !important;"><label>Send if Checked.&nbsp;&nbsp;<input type="checkbox"
                                                                                                           id="addOnEmail" name="addOnEmail" /></label></td>
                    </div>

                    <div class="tr-div">
                        <div class="td-div"><b>Shipping Method</b></div>
                        <div class="td-div">
                            <div class="shipping-method" id="addonShippingMethodIds">
                                <?php echo get_shipping_methods_by_country_code('US', true); ?></div>
                        </div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Shipping Cost</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" max="100" min="0" value="0"
                                                                                      id="addOnShippingCostAmount" name="addOnShippingCostAmount" autocomplete="off"
                                                                                      style="width: 100%;max-width: 100% !important;" /></div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Discount</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" max="10000" min="0" value="0" readonly=""
                                                                                      id="addOnDiscountAmount" name="addOnDiscountAmount" autocomplete="off"
                                                                                      style="width: 100%;max-width: 100% !important;" />
                            <input type="hidden" name="couponCode" id="couponCode" value="" autocomplete="off" />
                            <div id="couponCodeHtml">

                            </div>
                        </div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Total</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0"
                                                                                      id="addOnTotalAmount" readonly="" name="addOnTotalAmount" autocomplete="off"
                                                                                      style="width: 100%;max-width: 100% !important;" /></div>
                    </div>
                </div>

            </div>
            <div class="order-notes-section">
                <div class="flex-row">
                    <div class="order-customer-note col-sm-6">
                        <textarea name="order_customer_note" placeholder="Customer Note" autocomplete="off"></textarea>
                    </div>
                    <div class="order-admin-note col-sm-6">
                        <textarea name="order_admin_note" placeholder="Admin Note" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="addOn-modal-footer" id="addOn-modal-footer_cc">

            <div class="addOn-modal-footer_create ml-0">
                <button data-bb-handler="Charge" type="button" id="generate_CSR_order" class="btn btn-danger button">Create
                    Order</button>
            </div>

        </div>
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
    </form>


    <div id="newOrder_ajax_response"></div>
    <style>
        #newOrder_ajax_response {
            margin-top: 15px;
        }
    </style>
    <style>
        .wrapper.open {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            background: #fff;
            z-index: 999;
        }

        .popup a.close {
            position: absolute;
            top: 17%;
            right: 25%;
            z-index: 999;
            font-size: 18px;
            background: #fff;
            width: 30px;
            height: 30px;
            text-align: center;
            border-radius: 30px;
            border: 1px solid #ccc;
            color: #333;
            text-decoration: none;
            line-height: 1.5;
        }

        div#smile_brillaint_addNewOrder .select2-container {
            width: 100% !important;
        }

        .loading-element {
            width: 100%;
            height: 100%;
            z-index: 9999;
            position: absolute;
            background-color: #eaeaeaea;
            padding: 10%;
            text-align: center;
        }

        .loading-element .spinner.is-active {
            text-align: center;
            float: none;
        }

        .hass-error {
            border: 1px solid red !important;
        }
    </style>
    <?php
    echo '</div>';
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'addon', 'data-only'),
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => array('simple'),
                'operator' => 'NOT IN',
            ),
        ),
    );

    $product_list = get_posts($args);

    $products_options = '<option value="">Select Product</option>';
    foreach ($product_list as $prod_id) {
        $product = wc_get_product($prod_id);
        $threewayProduct = get_post_meta($prod_id, 'three_way_ship_product', true);
        if ($product->get_price() == '') {
            $p_price = 0;
        } else {
            $p_price = number_format($product->get_price(), 2);
        }
        $validationStock = add_to_cart_validation_composite_product($prod_id);
        $disabledAttribute = '';
        $disabledText = '';
        if (!$validationStock) {
            $disabledAttribute = 'disabled';
            $disabledText = ' (Out of stock)';
        }


        $products_options .= '<option  ' . $disabledAttribute . ' twp="' . $threewayProduct . '" value="' . $prod_id . '" data-price= "' . $p_price . '">' . $prod_id . '  - ' . get_the_title($prod_id) . $disabledText . '</option>';
    }
    ?>
    <script>
        jQuery("body").find("#smile_brillaint_order_popup_response").on("change",
                "#addOnShippingCostAmount",
                function (e) {
                    // jQuery('body').find('#addOnShippingCostAmount').keypress(function (event) {
                    //  if (event.which != 46) {
                    //   if ((event.which != 8 && isNaN(String.fromCharCode(event.which)))) {
                    //    event.preventDefault(); //stop character from entering input
                    calculateGrossAmountSBR();
                    // }
                    //   }
                });
        //
        //        jQuery("#sbr_order_labels").select2({
        //            placeholder: "Please select tag.",
        //            allowClear: true,
        //            width: '100%'
        //        });
        jQuery(".add_products").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });


        jQuery("body").find('#smile_brillaint_order_popup_response #split-order-table tbody').on("click", ".remove_field", function (
                e) { //user click on remove text
            e.preventDefault();
            jQuery(this).closest('tr').remove();
            // add_addon_prodcut--;
            if (jQuery("body").find("#addOn_order_form .quantity_addon").length > 0) {
                jQuery("body").find("#addOn_order_form .quantity_addon").trigger('change');
            } else {
                jQuery("body").find("#addOn_order_form #addOnShippingCostAmount").trigger('change');
            }
        });


        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
                ".add_products , .quantity_addon",
                function (e) {
                    if (jQuery('#couponCode').val()) {
                        updateCouponDiscountOnChange(jQuery('#couponCode').val());
                    }

                });

        function calculateProductSection() {
            jQuery('#addOn_order_form').find('table tbody tr').each(function (i, obj) {

                $getParentTr = jQuery(this);
                var twp = $getParentTr.find('.add_products option:selected').attr('twp');
                if ($getParentTr.attr('id') == 'parentAddonTr') {
                    $product_price = $getParentTr.find('input[name="price[]"]').val();
                } else {
                    $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
                    // console.log($product_price);
                    $discount = $product_price;
                    $getParentTr.find('input[name="price[]"]').val($product_price);
                }
                // $product_price = $getParentTr.find('input[name="new_product_id[]"] option:selected').attr('data-price');
                if (twp == 'yes') {
                    $qty = $getParentTr.find('input[name="item_qty[]"]').val('1');
                    $qty = 1;
                } else {
                    $qty = $getParentTr.find('input[name="item_qty[]"]').val();
                }

                $percentage = $getParentTr.find('input[name="discount[]"]').val();
                $calculated_price = 0;
                if ($qty > 0) {
                    $calculated_price = $total_price = $product_price * $qty;
                } else {
                    if ($product_price > 0) {
                        $calculated_price = $total_price = $product_price;
                    } else {
                        $calculated_price = 0.00;
                    }

                }
                if ($percentage > 0) {
                    $discount = $percentage * $total_price / 100;
                    $custom_price = $total_price - $discount;
                    $discount_price = $custom_price.toFixed(2);
                    if ($getParentTr.attr('id') == 'parentAddonTr') {
                        $getParentTr.find('#subtotal_addon_parent').html($discount_price);
                    }
                    $getParentTr.find('input[name="sub_total[]"]').val($discount_price);
                    $get
                    ParentTr.find('input[name="discountItemAmount[]"]').val($discount);
                    $calculated_price = $total_price = $product_price * $qty;


                } else {
                    $calculated_price = parseFloat($calculated_price);
                    $calculated_price = $calculated_price.toFixed(2);
                    if ($getParentTr.attr('id') == 'parentAddonTr') {
                        $getParentTr.find('#subtotal_addon_parent').html($calculated_price);
                    }
                    $getParentTr.find('input[name="discountItemAmount[]"]').val(0);
                    $getParentTr.find('input[name="sub_total[]"]').val($calculated_price);
                }
            });
            //jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
            //jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".discount_amount", function (e) {
            removeCouponCode(1);
        });


        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
                ".add_products , .quantity_addon  , .discount_amount",
                function (e) {

                    $getParentTr = jQuery(this).closest('tr');
                    var twp = $getParentTr.find('.add_products option:selected').attr('twp');
                    if ($getParentTr.attr('id') == 'parentAddonTr') {
                        $product_price = $getParentTr.find('input[name="price[]"]').val();
                    } else {
                        $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
                        // console.log($product_price);
                        $discount = $product_price;
                        $getParentTr.find('input[name="price[]"]').val($product_price);
                    }
                    // $product_price = $getParentTr.find('input[name="new_product_id[]"] option:selected').attr('data-price');
                    if (twp == 'yes') {
                        $qty = $getParentTr.find('input[name="item_qty[]"]').val('1');
                        $qty = 1;
                    } else {
                        $qty = $getParentTr.find('input[name="item_qty[]"]').val();
                    }

                    $percentage = $getParentTr.find('input[name="discount[]"]').val();
                    $calculated_price = 0;
                    if ($qty > 0) {
                        $calculated_price = $total_price = $product_price * $qty;
                    } else {
                        if ($product_price > 0) {
                            $calculated_price = $total_price = $product_price;
                        } else {
                            $calculated_price = 0.00;
                        }

                    }
                    if ($percentage > 0) {
                        $discount = $percentage * $total_price / 100;
                        $custom_price = $total_price - $discount;
                        $discount_price = $custom_price.toFixed(2);
                        if ($getParentTr.attr('id') == 'parentAddonTr') {
                            $getParentTr.find('#subtotal_addon_parent').html($discount_price);
                        }
                        $getParentTr.find('input[name="sub_total[]"]').val($discount_price);
                        $getParentTr.find('input[name="discountItemAmount[]"]').val($discount);
                        $calculated_price = $total_price = $product_price * $qty;


                    } else {
                        $calculated_price = parseFloat($calculated_price);
                        $calculated_price = $calculated_price.toFixed(2);
                        if ($getParentTr.attr('id') == 'parentAddonTr') {
                            $getParentTr.find('#subtotal_addon_parent').html($calculated_price);
                        }
                        $getParentTr.find('input[name="discountItemAmount[]"]').val(0);
                        $getParentTr.find('input[name="sub_total[]"]').val($calculated_price);
                    }


                    jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
                    jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
                });


        function calculateDiscountAmountSBR() {
            var total_discount_amount = 0;
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function (i, obj) {
                if (parseFloat(jQuery(obj).val()) > 0) {
                    total_discount_amount = parseFloat(total_discount_amount) + parseFloat(jQuery(obj).val());
                    total_discount_amount = total_discount_amount.toFixed(2);
                }
            });
            if (jQuery('#addOn_order_form').find('#couponCode').val()) {
                total_discount_amount = jQuery('#addOn_order_form').find('#addOnDiscountAmount').val();
            }
            if (isNaN(total_discount_amount)) {
                total_discount_amount = 0
            }
            return parseFloat(total_discount_amount);
        }

        function calculateShippingAmountSBR() {
            var shippingVal = 0;
            shippingVal = parseFloat(jQuery('#addOn_order_form').find('#addOnShippingCostAmount').val());
            if (isNaN(shippingVal)) {
                shippingVal = 0
            }
            return parseFloat(shippingVal.toFixed(2));
        }

        function calculateTotalAmountSBR() {

            var original_amount = 0;
            jQuery(document).find('.price_addon').each(function () {
                new_amount = parseFloat(jQuery(this).val());
                //console.log(new_amount);
                if (!isNaN(new_amount)) {
                    qty = parseFloat(jQuery(this).parent().parent().find('.quantity_addon').val());
                    unit_total = new_amount * qty;
                    original_amount = original_amount + unit_total;
                }

            });
            //  console.log(original_amount);
            if (isNaN(original_amount)) {
                original_amount = 0;
            }
            return parseFloat(original_amount.toFixed(2));
        }

        jQuery("body").find('#smile_brillaint_addNewOrder').on("change", "#shipping_method_mbt", function () {
            shipmentCost = jQuery('option:selected', this).attr('data-price');
            jQuery('#addOn_order_form').find('#addOnShippingCostAmount').val(shipmentCost)
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        });


        function calculateGrossAmountSBR(disocuntCouponAmount = '') {


            if (disocuntCouponAmount != '') {

                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - disocuntCouponAmount;
            } else {
                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - calculateDiscountAmountSBR();
            }
            if (grossTotalAmount.toFixed(2) == 0) {
                jQuery('body').find('#customerPaymentDetails').hide();
            } else {
                jQuery('body').find('#customerPaymentDetails').show();
            }
            return grossTotalAmount.toFixed(2);
        }





        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("keyup", "#addOnShippingCostAmount", function (
                e) {
            if (jQuery('#couponCode').val()) {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR(jQuery('#addOnDiscountAmount').val()));
            } else {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
            }

        });
        var add_addon_prodcut = 1; //initlal text box count
        jQuery("body").find('#smile_brillaint_addNewOrder #split-order-table tbody').on("click", ".remove_field", function (
                e) { //user click on remove text
            e.preventDefault();
            jQuery(this).closest('tr').remove();
            add_addon_prodcut--;

            if (jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form .quantity_addon").length > 0) {
                jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form .quantity_addon").trigger('change');
            } else {
                removeCouponCode(1);
            }
            //  console.log(jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form .quantity_addon").length)
        });

        jQuery(document).ready(function () {
            var max_fields = 10; //maximum input boxes allowed
            // var wrapper = jQuery("body").find('#addon-table tbody'); //Fields wrapper
            //var add_button = jQuery("body").find("#add_addon_product_btn"); //Add button ID
            jQuery("body").find("#smile_brillaint_addNewOrder").on("click", "#add_split_product_btn", function (e) {

                // jQuery(add_button).click(function (e) { //on add input button click
                //    jQuery(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                // console.log('Added')
                if (add_addon_prodcut < max_fields) { //max input box allowed
                    add_addon_prodcut++; //text box increment
                    var html = '';
                    html += '<tr>';
                    html +=
                            '<td><select class="add_products" name="product_id[]"><?php echo $products_options; ?></select></td>';
                    html +=
                            '<td>N/A</td>';
                    html +=
                            '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="price[]" placeholder="0.00" value="0.00" size="4" class="price_addon"></td>';

                    html +=
                            '<td><input type="number" step="1" min="1" max="100" autocomplete="off" name="item_qty[]" placeholder="1" size="4" value="1" class="quantity_addon"></td>';
                    html +=
                            '<td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_amount"></td>';
                    html +=
                            '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon">';
                    html +=
                            '<input type="hidden"  autocomplete="off"  name="discountItemAmount[]" placeholder="0" class="discountItemAmount">';
                    html += '</td>';
                    html +=
                            '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                    jQuery("body").find("#smile_brillaint_addNewOrder #split-order-table tbody").append(
                            html); //add input box
                    jQuery(".add_products").select2({
                        placeholder: "Please select product.",
                        allowClear: true,
                        width: '100%'
                    });

                }
            });
            //  jQuery("body").find('#TB_window').addClass('addOn_mbt');

        });
        jQuery('body').on('click', '#addPaymentProfile_checkbox', function () {
            if (jQuery(this).prop('checked') == true) {
                //jQuery('body').find('#addOn-modal-footer_cc').hide();
                jQuery('body').find('#addOn_addPaymentProfile_form').show();
            } else {
                jQuery('body').find('#addOn_addPaymentProfile_form').hide();
                //  jQuery('body').find('#addOn-modal-footer_cc').show();
            }
        });

        function updateCouponDiscountOnChange(couponCode) {
            //jQuery('.loading-element').show();
            jQuery('body').find('#addOn_order_form').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var formdata = jQuery('#addOn_order_form').serialize() + '&action=apply_giftCode_sbr&gift_code=' + couponCode;
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                // async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    //  jQuery('.loading-element').hide();
                    jQuery('body').find('#addOn_order_form').unblock();
                    //  console.log(response);
                    //  console.log(response.status);
                    if (response.status == "0") {
                        jQuery('#couponCode').val('');
                        jQuery('#couponCodeHtml').html('');
                    }
                    if (response.status == "1") {
                        var disocuntCouponAmount = parseFloat(response.amount);
                        deleteItemDiscount();
                        jQuery('#addOnDiscountAmount').val(disocuntCouponAmount.toFixed(2));
                        var couponHtml = '<span>Coupon Code : ' + couponCode +
                                '</span><a href="javascript:;" onclick="removeCouponCode()" >Remove</a>';
                        jQuery('#couponCode').val(couponCode);
                        jQuery('#couponCodeHtml').html(couponHtml);
                        jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR(disocuntCouponAmount));
                        calculateProductSection();
                        //  jQuery('#addOn_order_form').find('.add_products').trigger('change');
                    }
                }

            });
        }

        function addCouponToOrder() {
            var gift_code = '';
            Swal.fire({
                title: 'Please add gift code',
                html: ` <div id="appendres" style="color:red"></div><input type="text" id="gift_code" class="swal2-input" placeholder="Gift Code">`,
                showLoaderOnConfirm: true,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Apply',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    gift_code = Swal.getPopup().querySelector('#gift_code').value;
                    const formdata = jQuery('#addOn_order_form').serialize() +
                            '&action=apply_giftCode_sbr&orderType=split&gift_code=' + gift_code;
                    if (!gift_code) {
                        Swal.showValidationMessage(`Please enter gift code.`)
                    }
                    return fetch('<?php echo admin_url('admin-ajax.php'); ?>?' + formdata)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                        )
                            })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    //console.log(result);
                    res = result.value;
                    if (res.status == "0") {
                        jQuery('#appendres').html(res.error);
                        jQuery('#couponCode').val('');
                        jQuery('#couponCodeHtml').html('');
                        Swal.fire({
                            title: `Error`,
                            text: res.error
                        })
                    }
                    if (res.status == "1") {
                        var disocuntCouponAmount = parseFloat(res.amount);
                        deleteItemDiscount();
                        jQuery('#addOnDiscountAmount').val(disocuntCouponAmount.toFixed(2));
                        var couponHtml = '<span>Coupon Code : ' + gift_code +
                                '</span><a href="javascript:;" onclick="removeCouponCode()" >Remove</a>';
                        jQuery('#couponCode').val(gift_code);
                        jQuery('#couponCodeHtml').html(couponHtml);
                        jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR(disocuntCouponAmount));
                        calculateProductSection();
                        Swal.fire('Good Job!',
                                'Gift code applied successfully',
                                'success'
                                );
                    }
                }
            })
        }

        function removeCouponCode(updateOnly = 0) {
            if (updateOnly == 0) {
                deleteItemDiscount();
            }
            jQuery('#couponCode').val('');
            jQuery('#couponCodeHtml').html('');
            jQuery('#addOnDiscountAmount').val(0);
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());

        }

        function deleteItemDiscount() {
            jQuery('#addOn_order_form').find('.discount_amount').each(function (i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function (i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }

        jQuery("body").on('click', 'input[name="payment_via"]', function (event) {
            if (jQuery(this).val() == 'cc') {
                jQuery('#is_payment_via_changed_tbody').show();
                jQuery("body").find('#billingInfoAdminArea').hide();
                jQuery("body").find('#shippinginfoAdminArea').removeClass('col-sm-6').addClass('col-sm-12');

            } else {
                jQuery('#is_payment_via_changed_tbody').hide();
                jQuery("body").find('#billingInfoAdminArea').show();
                jQuery("body").find('#shippinginfoAdminArea').removeClass('col-sm-12').addClass('col-sm-6');
            }
        });
        jQuery("body").on('click', 'input[name="is_billing_address_changed"]', function (event) {
            if (jQuery(this).val() == 'new') {
                jQuery('#is_billing_address_changed_tbody').show();
            } else {
                jQuery('#is_billing_address_changed_tbody').hide();
            }
        });
        jQuery("body").on('click', 'input[name="is_shipping_address_changed"]', function (event) {
            if (jQuery(this).val() == 'new') {
                jQuery('#is_shipping_address_changed_tbody').show();
            } else {
                jQuery('#is_shipping_address_changed_tbody').hide();
            }
        });
        jQuery('body').on('keypress',
                '#wc-authorize-net-cim-credit-card-account-number , #wc-authorize-net-cim-credit-card-expiry-year ,  #wc-authorize-net-cim-credit-card-csc',
                function (e) {
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    } else {
                        jQuery(this).css('border-color', '#7e8993');
                    }
                });
        function addRMAProducts(item_id, product_id, product_price, item_title, tryno, ship_qty, type) {
            var contt = true;
            jQuery(document).find('.rma-itemid').each(function () {
                vall = jQuery(this).val();

                if (vall == item_id) {

                    contt = false;
                }

            });
            if (contt) {
                var html = '';
                if (type == 'simple') {
                    html += '<tr>';

                    html += '<td colspan="1"><span>' + item_title + '</span>';

                    html += '<input type="hidden" class="rma-productid"  name="parent[' + item_id + ']" value="' + product_id + '"/>';
                    html += '<input type="hidden" class="rma-itemid"  value="' + item_id + '"/>';
                    html += '<input type="hidden" name="type[' + item_id + ']" value="' + type + '" />';
                    //html += '<input type="hidden"  name="trayno[]" value="0" class="addon_tray_number"/>';
                    html += '<input type="hidden" name="product_id[]" value="0" /></td>';
                    html += '<td>N/A</td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" value="0" autocomplete="off"  name="price[]" placeholder="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="' + ship_qty + '" max="' + ship_qty + '" value="' + ship_qty + '" autocomplete="off" name="item_qty[]"  placeholder="1" size="2" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_addon"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" value="0" placeholder="0" size="4" class="subtotal_addon"></td>';
                    html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                } else {
                    html += '<tr>';
                    html += '<td><span>' + item_title + '</span>';
                    html += '<input type="hidden" name="parent[' + item_id + ']" value="' + product_id + '"/>';
                    html += '<input type="hidden" class="rma-itemid"  value="' + item_id + '"/>';
                    //html += '<input type="hidden" class="rma-itemid"  name="parent_item_id[]" value="'+item_id+'"/>';
                    html += '<input type="hidden" name="type[' + item_id + ']" value="' + type + '" />';
                    html += '<input type="hidden" name="product_id[]" value="0"/></td>';
                    // html += '<input type="hidden" name="parent_product_id[]" value="'+product_id+'"/>';


                    html += '<td><span>' + tryno + '</span><input type="hidden"  name="trayno[' + item_id + ']" value="' + tryno + '" class="addon_tray_number"/></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" value="0" max="9999" autocomplete="off"  name="price[]" placeholder="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="' + ship_qty + '" max="' + ship_qty + '" value="' + ship_qty + '" autocomplete="off" name="item_qty[]"  placeholder="1" size="2" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="9999" autocomplete="off" name="discount[]" placeholder="0" size="4" class="quantity_addon"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon"></td>';
                    html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                }
                jQuery("body").find("#smile_brillaint_order_popup_response #split-order-table tbody").append(html); //add input box
                jQuery(".add_products").select2({
                    placeholder: "Please select product.",
                    allowClear: true,
                    width: '100%'
                });
            }
        }
        jQuery('body').on('click', '#create_payment_profile_mbtbkkkk', function (e) {
            if (validate_create_profile_mbt()) {
                $validate_cc = true;
                $ccno = jQuery('body').find('#wc-authorize-net-cim-credit-card-account-number');
                $expiry_month = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-month');
                $expiry_year = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-year');
                $csc = jQuery('body').find('#wc-authorize-net-cim-credit-card-csc');
                if ($ccno.val() == '') {
                    $validate_cc = false;
                    $ccno.css('border-color', 'red');
                } else {
                    $ccno.css('border-color', '#4BB543');
                }
                if ($expiry_year.val() == '') {
                    $validate_cc = false;
                    $expiry_year.css('border-color', 'red');
                } else {
                    $expiry_year.css('border-color', '#4BB543');
                }
                if ($expiry_month.val() == '') {
                    $validate_cc = false;
                    $expiry_month.css('border-color', 'red');
                } else {
                    $expiry_month.css('border-color', '#4BB543');
                }
                if ($csc.val() == '') {
                    $validate_cc = false;
                    $csc.css('border-color', 'red');
                } else {
                    $csc.css('border-color', '#4BB543');
                }
                if ($validate_cc) {
                    jQuery('body').find('#smile_brillaint_payment_gateway_user').empty();
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=addOrderCIMProfile'); ?>';
                    var elementT = document.getElementById("addOn_order_form");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.resultCase) {
                                Swal.fire(
                                        'Good Job!',
                                        'CIM Payment profile created successfully',
                                        'success'
                                        );
                                jQuery('body').find('#smile_brillaint_payment_gateway_user').html(
                                        smile_brillaint_load_html());
                                jQuery('body').find('#addPaymentProfile_checkbox').prop('checked', false);
                                jQuery('body').find('#addPaymentProfile_checkbox').attr('checked', false);
                                jQuery('body').find('#addOn_addPaymentProfile_form').hide();
                                jQuery('body').find('#smile_brillaint_payment_gateway_user').html(response
                                        .resultHTML);
                            } else {
                                // jQuery('body').find('#smile_brillaint_payment_gateway_user').html(smile_brillaint_load_html());
                                // jQuery('body').find('#smile_brillaint_payment_gateway_user').html(response.resultHTML);
                                //jQuery('body').find('#newOrder_ajax_response').html(smile_brillaint_addOrder_fail_status_html(response.resultText));
                                //reset_response();
                                Swal.fire(
                                        'Oops!',
                                        response.resultText,
                                        'error'
                                        );

                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            }

        });

        function customer_user_dropdown_changed(cust_id) {
            if (cust_id) {

    <?php
    $shippingdata_url = add_query_arg(
            array(
        'action' => 'mbt_customer_billing_information',
            ), admin_url('admin-ajax.php')
    );
    $paymentdata_url = add_query_arg(
            array(
        'action' => 'mbt_customer_payment_information',
            ), admin_url('admin-ajax.php')
    );
    ?>
                var error_flag = false;
                var get_ajax_url = '<?php echo $shippingdata_url; ?>&user_id=' + cust_id;
                jQuery.ajax({
                    url: get_ajax_url,
                    data: [],
                    async: true,
                    dataType: 'html',
                    method: 'POST',
                    beforeSend: function (xhr) {
                        jQuery('body').find('#customerBillingShippingDetails').empty();
                        jQuery('body').find('#customerBillingShippingDetails').html(smile_brillaint_load_html());
                    },
                    success: function (response) {
                        jQuery('body').find('#customerBillingShippingDetails').html(response);
                    },
                    error: function (xhr) {
                        error_flag = true;
                    },
                    cache: false,
                });

                var get_ajax_url_payment = '<?php echo $paymentdata_url; ?>&user_id=' + cust_id;
                jQuery.ajax({
                    url: get_ajax_url_payment,
                    data: [],
                    async: true,
                    dataType: 'html',
                    method: 'POST',
                    beforeSend: function (xhr) {
                        jQuery('body').find('#customerPaymentDetails').empty();
                        jQuery('body').find('#customerPaymentDetails').html(smile_brillaint_load_html());
                    },
                    success: function (response) {
                        jQuery('body').find('#customerPaymentDetails').html(response);
                    },
                    error: function (xhr) {
                        error_flag = true;
                    },
                    cache: false,
                });
                if (error_flag) {
                    Swal.fire(
                            'Oops!',
                            'Request failed...Something went wrong.',
                            'error'
                            );
                    jQuery('body').find('#customerPaymentDetails').empty();
                    jQuery('body').find('#customerBillingShippingDetails').empty();
                }
                // console.log(get_ajax_url);
            } else {
                jQuery('body').find('#customerPaymentDetails').empty();
                jQuery('body').find('#customerBillingShippingDetails').empty();

            }
        }

        jQuery('.customer_user_mbt').select2({
            placeholder: 'Select a User',
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                type: 'GET',
                method: 'GET',
                data: function (data) {
                    return {
                        term: data.term,
                        action: 'woocommerce_json_search_customers',
                        security: '<?php echo wp_create_nonce('search-customers'); ?>',
                    };
                },
                processResults: function (data) {
                    if (data.length == 0) {
                        jQuery('.openpop').show();
                    } else {
                        jQuery('.openpop').show();
                    }
                    //console.log(data);
                    var terms = [];
                    if (data) {
                        jQuery.each(data, function (id, text) {
                            terms.push({
                                id: id,
                                text: text.replace(/\&ndash;/g, ' ')
                            });
                        });
                    }
                    // console.log(terms);
                    return {
                        results: terms
                    };
                },
                cache: true

            }
        });

        function reset_response() {
            setTimeout(function () {
                jQuery('body').find('#newOrder_ajax_response').html('');
            }, 5000);
        }



        jQuery(document).on('click', '#wp_signup_form', function (e) {
            e.preventDefault();
            data_f = $('#woocreateuser :input').serialize();
            jQuery.ajax({
                data: data_f,
                method: 'post',
                url: ajaxurl,
                success: function (res) {
                    //  console.log(res);
                }
            });
        });
        var customer_email = '';

        jQuery(document).on('click', '.openpop', function () {


            Swal.fire({
                title: 'Create User',
                html: ` <div id="appendres" style="color:red"></div><input type="text" id="cus_first_name" class="swal2-input" placeholder="First Name">
                 <input type="text" id="cus_last_name" class="swal2-input" placeholder="Last Name">
                <input type="email" id="customer_email" class="swal2-input" placeholder="Email"><div style="position:relative"><label for="customer_tags">
                            <select autocomplete="on" name="customer_tags" id="customer_tags" multiple>
              <option value="influencer">Influencer</option>
              <option value="reseller">Reseller</option>
              <option value="wholesale">Wholesale</option>
            </select></label></div>
             <div class="geha-checkbox">                           
            <input type="checkbox" id="geha_user" name="geha_user" value="yes">
            <label for="geha_user"> Geha Customer</label></div><div class="email-checkbox"><input type="checkbox" id="send_user_email" name="send_user_email" value="yes">
            <label for="send_user_email"> Send Email</label></div>`,
                showLoaderOnConfirm: true,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Create User',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    const cus_first_name = Swal.getPopup().querySelector('#cus_first_name').value
                    const cus_last_name = Swal.getPopup().querySelector('#cus_last_name').value
                    customer_email = Swal.getPopup().querySelector('#customer_email').value
                    customer_tags = jQuery('#customer_tags').val()
                    if (jQuery('#geha_user').prop('checked') === true) {
                        geha_user = Swal.getPopup().querySelector('#geha_user').value
                    } else {
                        geha_user = '';
                    }
                    if (jQuery('#send_user_email').prop('checked') === true) {
                        send_user_email = Swal.getPopup().querySelector('#send_user_email').value
                    } else {
                        send_user_email = '';
                    }
                    data_f = 'cus_first_name=' + cus_first_name + '&cus_last_name=' + cus_last_name +
                            '&customer_email=' + customer_email + '&action=create_woo_customer&customer_tags=' +
                            customer_tags + '&geha_user=' + geha_user + '&send_user_email=' + send_user_email;
                    if (!cus_first_name || !cus_last_name) {
                        var errorMsg = '';
                        if ((!cus_first_name || !cus_last_name)) {
                            if (!cus_first_name) {
                                errorMsg += 'First Name ';
                            }
                            if (!cus_last_name) {
                                errorMsg += ' Last Name';
                            }
                            if (customer_email) {
                                Swal.showValidationMessage('Please Enter ' + errorMsg);
                            } else {
                                Swal.showValidationMessage('Please Enter ' + errorMsg +
                                        ' And Email Address');
                                // Swal.showValidationMessage(`Please First Name, Last Name And Email Address`)
                            }
                        } else {
                            Swal.showValidationMessage(`Please Enter Email Address`);
                        }

                        //  Swal.showValidationMessage(`Please First Name, Last Name And Email Address`)

                    }
                    return fetch('<?php echo admin_url('admin-ajax.php'); ?>?' + data_f)
                            .then(response => {

                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                if (response.status == '201') {
                                    throw new Error('email address already Exists');
                                    return false;
                                }
                                if (response.status == '202') {
                                    throw new Error('Invalid Email address');
                                    return false;
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                        )
                            })
                },
                allowOutsideClick: () => !Swal.isLoading()

            }).then((result) => {
                if (result.isConfirmed) {
                    //console.log(result);
                    res = result.value;
                    if (res.status == "0") {
                        jQuery('#appendres').html(res.error);
                        Swal.fire({
                            title: `Error`,
                            text: res.error
                        })
                    }
                    if (res.status == "1") {
                        Swal.fire({
                            title: "Success",
                            text: "user added successfully"
                        });
                        jQuery('.customer_user_mbt').append('<option value=' + res.cusid +
                                ' selected="selected">#' + res.cusid + ' ' + customer_email + '</option>');
                        jQuery('.customer_user_mbt').trigger('change');
                    }
                }

            })
            setTimeout(function () {
                jQuery("#customer_tags").select2({
                    placeholder: "Please select tags.",
                    allowClear: true,
                    width: '100%'
                });
            }, 500);
        });
        jQuery(document).on('change', '.customer_user_mbt', function () {
            customer_id_mbt = jQuery(this).val();
            if (customer_id_mbt != '') {
                customer_user_dropdown_changed(customer_id_mbt);
            }
        });

        function smile_brillaint_addOrder_fail_status_html($msg) {
            var html = '<div class="alert alert-danger">';
            html += $msg;
            html += '</div>';
            return html;
        }
        var count_addToCart = true;
        jQuery("body").on('click', '#generate_CSR_order', (function (e) {
            if (!validate_create_order_mbt()) {
                return false;
            }

            Swal.fire({
                title: 'Do you want to place Order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create Order'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('body').find('#addOn_order_form').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    //                    var refreshpage = '';
                    //                    if (window.location.href.indexOf("?page=sb_orders_page") > -1) {
                    //                        var refreshpage = 'listing';
                    //                    } else {
                    //                        var refreshpage = 'product';
                    //
                    //                    }
                    count_addToCart = false;
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=createOrderBySplit'); ?>';
                    var elementT = document.getElementById("addOn_order_form");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function (response) {
                            //   console.log(response);
                            count_addToCart = true;
                            jQuery('body').find('#addOn_order_form').unblock();
                            if (response.order_id) {
                                if (response.error) {
                                    Swal.fire(
                                            'Oops!',
                                            response.msg,
                                            'info'
                                            );

                                } else {
                                    if (refreshpage == 'listing') {
                                        reloadOrderEntry_ByStatus(<?php echo $order_id; ?>, 'waiting-impression');
                                    } else {
                                        reload_order_item_table_mbt(<?php echo $order_id; ?>);
                                    }

                                    Swal.fire(
                                            'Good job!',
                                            response.msg,
                                            'success'
                                            );
                                }
                                if (response.order_id) {
                                    jQuery('body').find('#created_order_id').val(response
                                            .order_id);
                                }
                            } else {
                                Swal.fire(
                                        'Oops!',
                                        response.msg,
                                        'error'
                                        );
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            })
        }));

        function validate_create_order_mbt() {
            /* Billing Form validation if chekced*/


            var rowCountproducts = jQuery('#split-order-table>tbody tr').length;
            if (rowCountproducts == 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please add some products',
                });
                return false;
            }
            submitp = true;
            jQuery('.add_products').each(function () {
                if (jQuery(this).val() == '') {
                    jQuery(this).addClass('hass-error');
                    submitp = false;
                } else {
                    jQuery(this).removeClass('hass-error');
                }
            });
            if (!submitp) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please select the products',
                });
                return false;
            }
            if (jQuery('#is_billing_address_changed').is(':checked') || jQuery("#is_billing_address_changed_tbody").css(
                    "display") == "block") {
                submit = true;
                jQuery(
                        '#is_billing_address_changed_tbody input, #is_billing_address_changed_tbody select, #is_billing_address_changed_tbody textarea'
                        )
                        .each(function () {
                            if (jQuery(this).val() == '') {
                                jQuery(this).addClass('hass-error');
                                submit = false;
                            } else {
                                jQuery(this).removeClass('hass-error');
                            }
                        });
                if (!submit) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Please fill the billing fields',
                    });
                    return false;
                }

            }
            return true;
        }
    </script>

    <?php
    die();
}

add_action('wp_ajax_createOrderBySplit', 'createOrderBySplit_callback');
/**
 * Function for order split . proceed order create request using popup information
 *
 */
function createOrderBySplit_callback() {
    $parentItems = $_REQUEST['parent'];
    $split_product_id = $_REQUEST['product_id'];
    $qty = $_REQUEST['item_qty'];
    $moified_qty = $qty;
    $moified = $split_product_id;
    $counter = 0;
    foreach ($parentItems as $key => $val) {
        if (in_array($val, $moified)) {
            $key_mached = array_search($val, $moified);

            unset($moified[$key_mached]);
            unset($moified_qty[$key_mached]);

            $counter++;
        }
    }
// echo 'Data: <pre>' .print_r($qty,true). '</pre>';
// echo 'Data: <pre>' .print_r($moified_qty,true). '</pre>';
// echo 'Data: <pre>' .print_r($parentItems,true). '</pre>';
// echo 'Data: <pre>' .print_r($split_product_id,true). '</pre>';
// echo 'Data: <pre>' .print_r($moified,true). '</pre>';
    $counter = 0;
    $itemType = $_REQUEST['type'];
    $trayno = $_REQUEST['trayno'];
    $products = $_REQUEST['product_id'];
    $items_qty = $_REQUEST['item_qty'];
    $discountPerProduct = $_REQUEST['discount'];
    $discountAmount = 0;
    $imes_new_array = array();
    $items_skip = array();


    $dataOrder = array();
    $counterParent = 0;
    foreach ($split_product_id as $key => $val) {
        $qty = 1;
        if ($items_qty[$key]) {
            $qty = $items_qty[$key];
        }
        $dis_percentge = 0;
        if (isset($discountPerProduct[$key])) {
            $dis_percentge = $discountPerProduct[$key];
        }
        $itemId = 0;
        if ($val == 0) {
            $counterCheck = 0;
            foreach ($parentItems as $keyCounter => $parentID) {
                $product_id = 0;
                if ($counterParent == $counterCheck) {
                    $product_id = absint($parentID);
                    $itemId = absint($keyCounter);
                    $counterParent++;
                    break;
                }
                $counterCheck++;
            }
        } else {
            $product_id = absint($val);
        }
        $dataOrder[] = array(
            'product_id' => $product_id,
            'qty' => $qty,
            'item_id' => $itemId,
            'discount' => $dis_percentge,
        );
    }
//echo 'Data: <pre>' .print_r($dataOrder,true). '</pre>';die;
//https://stackoverflow.com/questions/48188567/applying-programmatically-a-coupon-to-an-order-in-woocommerce3
    $response = array();

    $child_order_id = false;
    $customer_user_mbt = isset($_REQUEST['customer_user_mbt']) ? $_REQUEST['customer_user_mbt'] : 0;
    $customer_send_email = isset($_REQUEST['customer_send_email']) ? $_REQUEST['customer_send_email'] : false;
    $customer_send_email_invoice = isset($_REQUEST['customer_send_email_invoice']) ? $_REQUEST['customer_send_email_invoice'] : false;
    $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
    if ($addOn_amount == 0) {
        $_REQUEST['payment_via'] = 'cc';
    }

    if ($customer_user_mbt) {
        if (isset($_REQUEST['product_id'])) {
            if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {


                if (is_numeric($addOn_amount) && $addOn_amount > 0) {
                    $token_id = isset($_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens']) ? $_REQUEST['wc_payment_gateway_authorize_net_cim_credit_card_tokens'] : 0;
                    if ($token_id) {
                        /*                         * 21-06-2022 Start */
                        $billTo = isset($_REQUEST['ppAddress'][$token_id]) ? json_decode(stripslashes($_REQUEST['ppAddress'][$token_id]), true) : Null;
                        if (isset($billTo['firstName'])) {
                            $_REQUEST['billing_first_name'] = $billTo['firstName'];
                        }
                        if (isset($billTo['lastName'])) {
                            $_REQUEST['billing_last_name'] = $billTo['lastName'];
                        }
                        if (isset($billTo['address'])) {
                            $_REQUEST['billing_address_1'] = $billTo['address'];
                        }
                        if (isset($billTo['city'])) {
                            $_REQUEST['billing_city'] = $billTo['city'];
                        }
                        if (isset($billTo['state'])) {
                            $_REQUEST['billing_state'] = $billTo['state'];
                        }
                        if (isset($billTo['zip'])) {
                            $_REQUEST['billing_postcode'] = $billTo['zip'];
                        }
                        if (isset($billTo['country'])) {
                            $_REQUEST['billing_country'] = $billTo['country'];
                        }
                        if (isset($billTo['phoneNumber'])) {
                            $_REQUEST['billing_phone'] = $billTo['phoneNumber'];
                        }
                        $_REQUEST['is_billing_address_changed'] = 'new';
                        /*                         * 21-06-2022 End */
                    } else {
                        $response = array(
                            'msg' => 'Payment profile missing.',
                            'error' => true
                        );
                        echo json_encode($response);
                        die;
                    }
                }
            }
            global $wpdb;
            $product_logs = array();

            $is_billing_address_changed = isset($_REQUEST['is_billing_address_changed']) ? $_REQUEST['is_billing_address_changed'] : 'old';
            if ($is_billing_address_changed == 'new') {

                $billing_firstname = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : get_user_meta($customer_user_mbt, 'billing_first_name', true);
                $billing_lastname = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : get_user_meta($customer_user_mbt, 'billing_last_name', true);
                $billing_phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : get_user_meta($customer_user_mbt, 'billing_phone', true);
                $billing_address_1 = isset($_REQUEST['billing_address_1']) ? $_REQUEST['billing_address_1'] : get_user_meta($customer_user_mbt, 'billing_address_1', true);
                $billing_city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : get_user_meta($customer_user_mbt, 'billing_city', true);
                $billing_state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : get_user_meta($customer_user_mbt, 'billing_state', true);
                $billing_postcode = isset($_REQUEST['billing_postcode']) ? $_REQUEST['billing_postcode'] : get_user_meta($customer_user_mbt, 'billing_postcode', true);
                $billing_country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : get_user_meta($customer_user_mbt, 'billing_country', true);

                update_user_meta($customer_user_mbt, 'billing_first_name', $billing_firstname);
                update_user_meta($customer_user_mbt, 'billing_last_name', $billing_lastname);
                update_user_meta($customer_user_mbt, 'billing_phone', $billing_phone);
                update_user_meta($customer_user_mbt, 'billing_address_1', $billing_address_1);
                update_user_meta($customer_user_mbt, 'billing_city', $billing_city);
                update_user_meta($customer_user_mbt, 'billing_state', $billing_state);
                update_user_meta($customer_user_mbt, 'billing_postcode', $billing_postcode);
                update_user_meta($customer_user_mbt, 'billing_country', $billing_country);
            } else {
                $billing_firstname = get_user_meta($customer_user_mbt, 'billing_first_name', true);
                $billing_lastname = get_user_meta($customer_user_mbt, 'billing_last_name', true);
                $billing_phone = get_user_meta($customer_user_mbt, 'billing_phone', true);
                $billing_address_1 = get_user_meta($customer_user_mbt, 'billing_address_1', true);
                $billing_city = get_user_meta($customer_user_mbt, 'billing_city', true);
                $billing_state = get_user_meta($customer_user_mbt, 'billing_state', true);
                $billing_postcode = get_user_meta($customer_user_mbt, 'billing_postcode', true);
                $billing_country = get_user_meta($customer_user_mbt, 'billing_country', true);
            }


            $is_shipping_address_changed = isset($_REQUEST['is_shipping_address_changed']) ? $_REQUEST['is_shipping_address_changed'] : 'old';
            if ($is_shipping_address_changed == 'new') {

                $shipping_firstname = isset($_REQUEST['shipping_first_name']) ? $_REQUEST['shipping_first_name'] : get_user_meta($customer_user_mbt, 'shipping_first_name', true);
                $shipping_lastname = isset($_REQUEST['shipping_last_name']) ? $_REQUEST['shipping_last_name'] : get_user_meta($customer_user_mbt, 'shipping_last_name', true);
                $shipping_address_1 = isset($_REQUEST['shipping_address_1']) ? $_REQUEST['shipping_address_1'] : get_user_meta($customer_user_mbt, 'shipping_address_1', true);
                $shipping_city = isset($_REQUEST['shipping_city']) ? $_REQUEST['shipping_city'] : get_user_meta($customer_user_mbt, 'shipping_city', true);
                $shipping_state = isset($_REQUEST['shipping_state']) ? $_REQUEST['shipping_state'] : get_user_meta($customer_user_mbt, 'shipping_state', true);
                $shipping_postcode = isset($_REQUEST['shipping_postcode']) ? $_REQUEST['shipping_postcode'] : get_user_meta($customer_user_mbt, 'shipping_postcode', true);
                $shipping_country = isset($_REQUEST['shipping_country']) ? $_REQUEST['shipping_country'] : get_user_meta($customer_user_mbt, 'shipping_country', true);

                update_user_meta($customer_user_mbt, 'shipping_first_name', $shipping_firstname);
                update_user_meta($customer_user_mbt, 'shipping_last_name', $shipping_lastname);
                // update_user_meta($user_id, 'billing_phone', $billing_phone);
                update_user_meta($customer_user_mbt, 'shipping_address_1', $shipping_address_1);
                update_user_meta($customer_user_mbt, 'shipping_city', $shipping_city);
                update_user_meta($customer_user_mbt, 'shipping_state', $shipping_state);
                update_user_meta($customer_user_mbt, 'shipping_postcode', $shipping_postcode);
                update_user_meta($customer_user_mbt, 'shipping_country', $shipping_country);
            } else {

                $shipping_firstname = get_user_meta($customer_user_mbt, 'shipping_first_name', true);
                $shipping_lastname = get_user_meta($customer_user_mbt, 'shipping_last_name', true);
                $shipping_address_1 = get_user_meta($customer_user_mbt, 'shipping_address_1', true);
                $shipping_city = get_user_meta($customer_user_mbt, 'shipping_city', true);
                $shipping_state = get_user_meta($customer_user_mbt, 'shipping_state', true);
                $shipping_postcode = get_user_meta($customer_user_mbt, 'shipping_postcode', true);
                $shipping_county = get_user_meta($customer_user_mbt, 'shipping_country', true);

                /*                 * 21-06-2022 Start */
                $_REQUEST['shipping_address_id'] = $_REQUEST['is_shipping_address_changed'];
                if (isset($_REQUEST['is_shipping_address_changed']) && is_numeric($_REQUEST['is_shipping_address_changed'])) {
                    $shippingAddress = current_user_shipping_addresses($customer_user_mbt);
                    if (count($shippingAddress) > 0) {
                        foreach ($shippingAddress as $shipAdd) {
                            if ($_REQUEST['is_shipping_address_changed'] == $shipAdd['id']) {
                                $shipping_firstname = $shipAdd['shipping_first_name'];
                                $shipping_lastname = $shipAdd['shipping_last_name'];
                                $shipping_address_1 = $shipAdd['shipping_address_1'];
                                $shipping_address_2 = $shipAdd['shipping_address_2'];
                                $shipping_city = $shipAdd['shipping_city'];
                                $shipping_state = $shipAdd['shipping_state'];
                                $shipping_postcode = $shipAdd['shipping_postcode'];
                                $shipping_county = $shipAdd['shipping_country'];
                                /// set_as_default_shipping_address_mbt($_REQUEST['is_shipping_address_changed']);
                                break;
                            }
                        }
                    }
                }
                /*                 * 21-06-2022 End */
            }




            $userData = get_userdata($customer_user_mbt);
            $billing_address = array(
                'first_name' => $billing_firstname,
                'last_name' => $billing_lastname,
                'email' => $userData->user_email,
                'phone' => $billing_phone,
                'address_1' => $billing_address_1,
                'city' => $billing_city,
                'postcode' => $billing_postcode,
                'state' => $billing_state,
                'country' => $billing_country
            );

            $shipping_address = array(
                'first_name' => $shipping_firstname,
                'last_name' => $shipping_lastname,
                'address_1' => $shipping_address_1,
                'city' => $shipping_city,
                'postcode' => $shipping_postcode,
                'state' => $shipping_state,
                'country' => $shipping_county
            );

//echo 'Data: <pre>' .print_r(get_user_meta($customer_user_mbt)). '</pre>';
//             echo 'Data: <pre>' .print_r($billing_address,true). '</pre>';
            //echo 'Data: <pre>' .print_r($billing_address,true). '</pre>';
            //die;
            $args = array(
                'customer_id' => $customer_user_mbt,
            );

            $newOrder = true;
            $parentOrderID = $_REQUEST['order_id'];
            if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] > 0) {
                $newOrder = false;
            }
            global $wpdb;
            $newOrder = true;
// Create the order and assign it to the current user
            if ($newOrder) {
                $order = wc_create_order($args);
//                remove_action('woocommerce_order_status_pending', 'wc_maybe_increase_stock_levels');
//add_action( 'woocommerce_order_status_pending', 'wc_maybe_reduce_stock_levels' );
                $order = wc_get_order($order->get_id());
                $order->set_address($billing_address, 'billing');
                $order->set_address($shipping_address, 'shipping');
                $child_order_id = $order->get_id();
                // echo 'Data: <pre>' .print_r($child_order_id,true). '</pre>';
                smile_brillaint_set_sequential_order_number($child_order_id);
                smile_brillaint_get_sequential_order_number($child_order_id);

                update_post_meta($child_order_id, 'parent_order_id', $parentOrderID);
                update_post_meta($child_order_id, 'order_type', 'Split');
                $products = $_REQUEST['product_id'];
                $items_qty = $_REQUEST['item_qty'];
                $discountPerProduct = $_REQUEST['discount'];

                $discountAmount = 0;
                $imes_new_array = array();
                $items_skip = array();
                update_post_meta($child_order_id, 'created_good_to_ship', 'yes');

                //echo 'Data: <pre>' .print_r($dataOrder,true). '</pre>';
                //die;
                $addLog = array();
                if ($dataOrder) {
                    foreach ($dataOrder as $key => $object) {

                        $product_id = absint($object['product_id']);
                        $previous_item_id = absint($object['item_id']);
                        $qty = absint($object['qty']);
                        $product = wc_get_product($product_id);
                        $update_price = false;
                        if ($previous_item_id > 0) {
                            $update_price = true;
                            $dis_percentge = 100;
                            $product->set_price(0);
                        } else {
                            $dis_percentge = absint($object['discount']);
                        }





                        if (!$product) {
                            throw new Exception(__('Invalid product ID', 'woocommerce') . ' ' . $product_id);
                        }
                        if ('variable' === $product->get_type()) {
                            /* translators: %s product name */
                            throw new Exception(sprintf(__('%s is a variable product parent and cannot be added.', 'woocommerce'), $product->get_name()));
                        }
                        $validation_error = new WP_Error();
                        $validation_error = apply_filters('woocommerce_ajax_add_order_item_validation', $validation_error, $product, $order, $qty);

                        if ($validation_error->get_error_code()) {
                            throw new Exception('<strong>' . __('Error:', 'woocommerce') . '</strong> ' . $validation_error->get_error_message());
                        }
                        $_POST['action'] = 'woocommerce_add_order_item';



                        $item_id = $order->add_product($product, $qty);
                        if ($dis_percentge) {
                            $discountAmount = $_REQUEST['addOnDiscountAmount'];
                            wc_update_order_item_meta($item_id, 'discount', $dis_percentge);
                        }

                        $item = apply_filters('woocommerce_ajax_order_item', $order->get_item((int) $item_id), (int) $item_id, $order, $product);
                        $added_items[$item_id] = $item;
                        $order_notes[$item_id] = $product->get_formatted_name();

                        $item->save();

                        //   do_action('woocommerce_ajax_add_order_item_meta', (int) $item_id, $item, $order);
                        do_action('woocommerce_ajax_order_items_added', $added_items, $order);


                        if ($previous_item_id > 0) {
                            if (isset($itemType[$previous_item_id])) {
                                // $updatedItemId = $item_id + 1;
                            } else {
                                // $updatedItemId = $item_id;
                            }
                            $updatedItemId = $item_id;
                            if ($update_price) {
                                $addLog[$updatedItemId] = $updatedItemId;
                                wc_update_order_item_meta($updatedItemId, '_line_subtotal', 0);
                                wc_update_order_item_meta($updatedItemId, '_line_total', 0);
                                wc_update_order_item_meta($updatedItemId, '_reduced_stock', 1);
                                wc_update_order_item_meta($updatedItemId, '_item_type', 'split');
                                //$item_stock_reduced = $item->get_meta( '_reduced_stock', true );
                            }
                            //wc_update_order_item_meta($item_id, 'parent_item_id', $previous_item_id);
                            $query = $wpdb->get_var("SELECT id FROM  " . SB_ORDER_TABLE . " WHERE order_id = $child_order_id and item_id = $updatedItemId");

                            if (empty($query)) {
                                //$ticket_id = 0;
                                $orderItemRecord = $wpdb->get_row("SELECT * FROM  " . SB_ORDER_TABLE . " WHERE order_id = $parentOrderID and item_id = $previous_item_id");
                                if ($orderItemRecord):

                                    $orderItemData = array(
                                        "order_id" => $child_order_id,
                                        "item_id" => $updatedItemId,
                                        "product_id" => $product_id,
                                        "status" => $orderItemRecord->status,
                                        "parent_order_id" => absint($parentOrderID),
                                        "parent_item_id" => absint($previous_item_id),
                                        "ticket_id" => $orderItemRecord->ticket_id,
                                        "ticket_status" => $orderItemRecord->ticket_status,
                                        "tray_number" => $orderItemRecord->tray_number,
                                        "user_id" => $order->get_customer_id(),
                                        "created_date" => date("Y-m-d h:i:sa"),
                                    );
                                    //echo 'Data: <pre>' .print_r($orderItemData,true). '</pre>';
                                    $wpdb->insert(SB_ORDER_TABLE, $orderItemData);
                                endif;
                            }

                            $shippedHistory = wc_get_order_item_meta($previous_item_id, 'shipped');
                            if ($shippedHistory) {
                                wc_update_order_item_meta($updatedItemId, 'shipped', $shippedHistory);
                            }
                            $shippedHistoryCount = wc_get_order_item_meta($previous_item_id, '_shipped_count');
                            if ($shippedHistoryCount) {
                                wc_update_order_item_meta($updatedItemId, '_shipped_count', $shippedHistoryCount);
                            }
                            $shipped_count = wc_get_order_item_meta($previous_item_id, '_shipped_count');
                            if ($shipped_count) {
                                wc_update_order_item_meta($updatedItemId, '_shipped_count', $shipped_count);
                            }
                            $first_tracking_number = wc_get_order_item_meta($previous_item_id, '_first_tracking_number');
                            if ($first_tracking_number) {
                                wc_update_order_item_meta($updatedItemId, '_first_tracking_number', $first_tracking_number);
                            }
                            $second_tracking_number = wc_get_order_item_meta($previous_item_id, '_second_tracking_number');
                            if ($second_tracking_number) {
                                wc_update_order_item_meta($updatedItemId, '_second_tracking_number', $second_tracking_number);
                            }

                            $queryForHistory = "SELECT  * FROM  " . SB_LOG;
                            $queryForHistory .= " WHERE item_id = " . $previous_item_id . " AND product_id = " . $product_id . " AND order_id = '$parentOrderID'";
                            // $queryForHistory .= " ORDER BY log_id DESC LIMIT 1";
                            $logHistory = $wpdb->get_results($queryForHistory);

                            //Create Log
                            $event_data = array(
                                "order_id" => $parentOrderID,
                                "item_id" => $previous_item_id,
                                "product_id" => $product_id,
                                "child_order_id" => $child_order_id,
                                "event_id" => 17,
                            );

                            sb_create_log($event_data);
                            if ($logHistory) {
                                foreach ($logHistory as $log_entry) {
                                    $event_data = array(
                                        "order_id" => $child_order_id,
                                        "item_id" => $updatedItemId,
                                        "product_id" => $product_id,
                                        "parent_order_id" => $parentOrderID,
                                        "event_id" => $log_entry->event_id,
                                        "shipment_id" => $log_entry->shipment_id,
                                        "warranty_claim_id" => 1,
                                        "warranty_status" => $log_entry->warranty_status,
                                        "note" => $log_entry->note,
                                        "extra_information" => $log_entry->extra_information,
                                        "created_date" => $log_entry->created_date,
                                    );
                                    sb_create_log($event_data);
                                }
                            }
                        }
                    }
                    if (isset($_REQUEST['couponCode']) && $_REQUEST['couponCode'] <> '') {
                        $order->apply_coupon($_REQUEST['couponCode']);
                    }
                    if (!empty($addLog)) {
                        foreach ($addLog as $itemidforPrice) {
                            wc_update_order_item_meta($itemidforPrice, '_line_subtotal', 0);
                            wc_update_order_item_meta($itemidforPrice, '_line_total', 0);
                        }
                    }



                    $order->add_order_note(sprintf(__('Added line items: %s', 'woocommerce'), implode(', ', $order_notes)), false, true);
                }
                if (isset($_REQUEST['shipping_method_id']) && $_REQUEST['shipping_method_id'] > 0) {


                    $countery_code = $order->get_shipping_country();
                    // Set the array for tax calculations
                    $calculate_tax_for = array(
                        'country' => $countery_code,
                        'state' => $order->get_shipping_state(), // Can be set (optional)
                        'postcode' => $order->get_shipping_postcode(), // Can be set (optional)
                        'city' => $order->get_shipping_city(), // Can be set (optional)
                    );
                    $method_instance_id = $_REQUEST['shipping_method_id'];
                    $shipping_method = mbt_shipping_name_by_id($method_instance_id);

                    // Optionally, set a total shipping amount
                    $shipping_cost = $_REQUEST['addOnShippingCostAmount'];
                    if ($shipping_cost == '') {
                        $shipping_cost = 0;
                    }
                    // Get a new instance of the WC_Order_Item_Shipping Object
                    $item_fee = new WC_Order_Item_Shipping();
                    $item_fee->set_method_title($shipping_method['title']);
                    $item_fee->set_method_id($shipping_method['method']); // set an existing Shipping method rate ID
                    $item_fee->set_instance_id($method_instance_id); //
                    $item_fee->set_total($shipping_cost); // (optional)
                    $item_fee->calculate_taxes($calculate_tax_for);
                    $order->add_item($item_fee);
                    update_post_meta($order->get_id(), '_order_shipping', $shipping_cost);
                }

                if ($discountAmount > 0) {

                    $item = new WC_Order_Item_Fee();
                    $item->set_name('Discount');
                    $item->set_amount('-' . $discountAmount);
                    $item->set_total('-' . $discountAmount);

                    $item->set_taxes(false);
                    $item->save();
                    $order->add_item($item);

                    update_post_meta($order->get_id(), '_cart_discount', $discountAmount);
                }
                $order->calculate_totals();
                $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
                $order->set_total($addOn_amount);

                if (isset($_REQUEST['order_customer_note']) && trim($_REQUEST['order_customer_note'])) {
                    $order->add_order_note($_REQUEST['order_customer_note'], true);
                }
                if (isset($_REQUEST['order_admin_note']) && trim($_REQUEST['order_admin_note'])) {
                    $order->add_order_note($_REQUEST['order_admin_note']);
                }
            } else {
                $addOn_amount = isset($_REQUEST['addOnTotalAmount']) ? $_REQUEST['addOnTotalAmount'] : 0;
                $child_order_id = $_REQUEST['order_id'];
                $order = wc_get_order($child_order_id);
            }
            update_post_meta($child_order_id, '_createdByCSR', 'yes');
            update_post_meta($child_order_id, '_csr_id', get_current_user_id());
            $payemt_note = '';
            $paymentFlagError = false;
            //Don't send order processing email
            if (!$customer_send_email)
                add_filter('woocommerce_email_enabled_customer_processing_order', 'sbr_disable_email_customer_processing_order', 10, 2);
            //Don't send order invoice email
            if (!$customer_send_email_invoice)
                add_filter('woocommerce_email_enabled_pip_email_invoice', 'sbr_disable_email_customer_processing_order', 10, 2);
            if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cc') {
                if (is_numeric($addOn_amount) && $addOn_amount > 0) {
                    if ($token_id) {
                        $payment_param = array(
                            'token_id' => $token_id,
                            'amount' => $addOn_amount,
                            'order_id' => $child_order_id,
                        );
                        $aimResponse = sbr_chargePaymentProfile($payment_param);
                        $payemt_note = $aimResponse['note'];
                        $paymentFlagError = $aimResponse['errorflag'];
                    }
                } else {
                    mbt_goodToShip($child_order_id, 'split');
                }
            } else if (isset($_REQUEST['payment_via']) && $_REQUEST['payment_via'] == 'cheque') {

                update_post_meta($child_order_id, '_payment_method', 'cheque');
                update_post_meta($child_order_id, '_payment_method_title', 'Check payments');
                if ($order->get_total() > 0) {
                    //  $order->add_order_note('we\'re awaiting the cheque');
                    // Mark as on-hold (we're awaiting the cheque).
                    $order->update_status(apply_filters('woocommerce_cheque_process_payment_order_status', 'on-hold', $order), _x('Awaiting check payment', 'Check payment method', 'woocommerce'));
                }
            } else {
                do_action('woocommerce_before_resend_order_emails', $order, 'customer_invoice');
                // Send the customer invoice email.
                WC()->payment_gateways();
                WC()->shipping();
                WC()->mailer()->customer_invoice($order);
                // Note the event.
                $order->add_order_note(__('Order details manually sent to customer.', 'woocommerce'), false, true);
                do_action('woocommerce_after_resend_order_email', $order, 'customer_invoice');
            }
            if (!$customer_send_email)
                remove_filter('woocommerce_email_enabled_customer_processing_order', 'sbr_disable_email_customer_processing_order', 10);
            if (!$customer_send_email_invoice)
                remove_filter('woocommerce_email_enabled_pip_email_invoice', 'sbr_disable_email_customer_processing_order', 10);
            smile_brillaint_GEHA_tag($child_order_id);
//echo 'Data: <pre>' .print_r($_REQUEST,true). '</pre>';
            if (isset($_REQUEST['sbr_order_type']) && $_REQUEST['sbr_order_type'] != '') {
                update_post_meta($child_order_id, 'sbr_order_type', $_REQUEST['sbr_order_type']);
            }
            if (isset($_REQUEST['sbr_order_labels'])) {
                //    if (isset($_REQUEST['sbr_order_labels']) && is_array($_REQUEST['sbr_order_labels']) && count($_REQUEST['sbr_order_labels']) > 0) {
                update_post_meta($child_order_id, 'sbr_order_labels', $_REQUEST['sbr_order_labels']);
                $orderTags = explode(",", $_REQUEST['sbr_order_labels']);

                foreach ($orderTags as $key => $orderTag) {
                    wp_set_object_terms($child_order_id, $orderTag, 'order_tag', true);
                }
            }

            $order->save();
            $response = array(
                'msg' => 'Order created successfully ' . $payemt_note,
                'order_id' => $child_order_id,
                'error' => $paymentFlagError
            );
            echo json_encode($response);
            die;
        } else {
            $response = array(
                'msg' => 'No product found!',
                'error' => true,
                'order_id' => $child_order_id,
            );
        }
        echo json_encode($response);
        die;
    } else {
        $response = array(
            'msg' => 'No customer selected against this order.',
            'error' => true,
            'order_id' => $child_order_id,
        );
        echo json_encode($response);
        die;
    }

    die;
}
