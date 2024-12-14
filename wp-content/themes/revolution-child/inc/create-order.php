<?php

function mbt_create_new_order_func()
{

    global $pagenow;

    # Check current admin page.
    if ($pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'shop_order') {

        wp_redirect(admin_url('/admin.php?page=create-order'));
        exit;
    }
    if ($pagenow == 'user-edit.php' && isset($_GET['user_id']) && $_GET['user_id'] != '' && !isset($_GET['sbr_action'])) {
        $user_id = $_GET['user_id'];
        $userr = get_userdata($user_id);
        $user_roles = $userr->roles;
        if (in_array('customer', $user_roles, true) || in_array('vendor', $user_roles, true)) {
            if (isset($_GET['nored']) || isset($_GET['updated'])) {
                //
            } else {
                wp_redirect(admin_url('/admin.php?page=customer_history&customer_id=' . $user_id));
                exit;
            }
        }
    }
}

add_action('admin_init', 'mbt_create_new_order_func');
//add_action('admin_menu', 'register_newpage');


add_action('init', 'order_tag_taxonomy', 10);

//create a custom taxonomy name it subjects for your posts

function order_tag_taxonomy()
{

    $labels = array(
        'name' => _x('Order Tags', 'taxonomy general name'),
        'singular_name' => _x('Order Tag', 'taxonomy singular name'),
        'search_items' => __('Search Order Tags'),
        'all_items' => __('All Order Tags'),
        'parent_item' => __('Parent Order Tag'),
        'parent_item_colon' => __('Parent Order Tag:'),
        'edit_item' => __('Edit Order Tag'),
        'update_item' => __('Update Order Tag'),
        'add_new_item' => __('Add New Order Tag'),
        'new_item_name' => __('New Order Tag Name'),
        'menu_name' => __('Order Tags'),
    );


    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('order_tag', 'shop_order', $args);
    register_taxonomy_for_object_type('order_tag', 'shop_order');
}

function register_newpage()
{
    add_submenu_page(
        'create order',
        'Create Order',
        'Create Order',
        'edit_posts',
        'create-order',
        'create_order_page_mbt'
    );
}

add_action('wp_ajax_create_addon_order', 'create_order_page_mbt222');


add_action('wp_ajax_calculateTrayPrice', 'calculateTrayPrice_callback');
function calculateTrayPrice_callback()
{
    global $wpdb;
    $result = array();
    if (isset($_REQUEST['trayno']) &&  $_REQUEST['trayno'] > 0) {
        $trayno  =  $_REQUEST['trayno'];
        $night_guard_reorder_product  =  $_REQUEST['product_id'];
        $night_guard_reorder_product_3mm = $_REQUEST['product_id'];
        //   echo "SELECT product_id  FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $trayno ORDER BY id ASC";

       // $product_id = $wpdb->get_var("SELECT product_id  FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $trayno ORDER BY id ASC");
        $itemData = $wpdb->get_row("SELECT tray_number , created_date , product_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $trayno ORDER BY id ASC");
        $tray_number = isset($itemData->tray_number) ? $itemData->tray_number : '';
        $created_date = isset($itemData->created_date) ? $itemData->created_date : '';
        $product_id = isset($itemData->product_id) ? $itemData->product_id : '';
        $specific_date = '2024-04-01';
        $created_date = strtotime($created_date);
        $specific_date = strtotime($specific_date);
        
        if ($product_id == '') {
            $result = array(
                'response' => false,
                'trayno' => $trayno,
                'message' => 'Parent product not found.',
            );
            echo json_encode($result);
            die;
        } else {
            $producttitle = get_the_title($product_id);
            $producttitle_original = get_the_title($night_guard_reorder_product);
            if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (Deluxe)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm) (Deluxe)') {
                $key = '1_nightguards_package';
                $key3mm = '1_nightguards_package_3mm';
                if ($created_date > $specific_date) {
                    $key = '1_nightguards_package_new';
                    $key3mm = '1_nightguards_package_3mm_new';
                }
        
                $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
            } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {
        
        
                $key3mm = '2_nightguards_package_3mm';
                $key = '2_nightguards_package';
                if ($created_date > $specific_date) {
                    $key = '2_nightguards_package_new';
                    $key3mm = '2_nightguards_package_3mm_new';
                }
                $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
            } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {
        
                $key3mm = '4_nightguards_package_3mm';
                $key = '4_nightguards_package';
                if ($created_date > $specific_date) {
                    $key = '4_nightguards_package_new';
                    $key3mm = '4_nightguards_package_3mm_new';
                }
                $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
                $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
            } else {
                $result = array(
                    'response' => false,
                    'trayno' => $trayno,
                    'message' => 'Parent product not found.',
                );
                echo json_encode($result);
            die;
            }
            if (strpos($producttitle_original, '3mm') !== false) {
                $tray_price_final =  $tray_price3mm;
            }
            else{
                $tray_price_final =  $tray_price;
            }
            $result = array(
                'response' => true,
                'trayno' => $trayno,
                'price' => $tray_price_final,
            );
        }
    } else {
        $result = array(
            'response' => false,
            'message' => 'Tray number empty.',
        );
    }
    echo json_encode($result);
    die;
}

function create_order_page_mbt222()
{
    create_order_style_mbt();
    echo '<h2> Create Addon Order</h2>';
    echo '<div id="smile_brillaint_addNewOrder">';
?>
    <form id="addOn_order_form" class="addon-order-form-mbt">

        <div class="bg-light create-ordr-mbt-tp">
            <div class="flex-row">
                <?php
                if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'create_addon_order') {
                    echo '<input type="hidden" name="customer_user_mbt" id="customer_user_mbt" value="' . $_REQUEST['customer_id'] . '"/>';
                } else {
                ?>
                    <div class="col-sm-6">
                        <div class="clr-bx">
                            <p class="form-field form-field-wide SBR_orderType">
                                <!--email_off-->
                                <!-- Disable CloudFlare email obfuscation -->

                                <label for="sbr_order_type">
                                    <span class="display-block"> <b>Select order type</b></span>
                                    <select class="form-control" autocomplete="off" data-placeholder="Select order type" data-allow_clear="true" id="sbr_order_type" name="sbr_order_type">
                                        <option value="retail-online">Retail-online</option>
                                        <option value="wholesale">Wholesale</option>
                                        <option value="dentist">Dentist</option>
                                        <option value="influencer/marketing">Influencer/Marketing</option>
                                        <option value="sample">Sample</option>
                                    </select>
                                </label>
                                <!--/email_off-->
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="clr-bx select-labels">
                            <p class="form-field form-field-wide order-labels">
                                <label for="sbr_order_labels">
                                    <b>Select labels</b>
                                    <input type="text" id="sbr_order_labels" name="sbr_order_labels" value="" class="tagsinput" data-role="tagsinput" />

                                    <script>
                                        var citynames = new Bloodhound({
                                            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                                            queryTokenizer: Bloodhound.tokenizers.whitespace,
                                            prefetch: {
                                                url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/js/orderTags.json?ver=<?php echo time() ?>',
                                                filter: function(list) {
                                                    return jQuery.map(list, function(cityname) {
                                                        return {
                                                            name: cityname
                                                        };
                                                    });
                                                }
                                            }
                                        });
                                        citynames.initialize();

                                        jQuery('.tagsinput').tagsinput({
                                            typeaheadjs: {
                                                name: 'citynames',
                                                displayKey: 'name',
                                                valueKey: 'name',
                                                source: citynames.ttAdapter()
                                            }
                                        });
                                    </script>

                                </label>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="clr-bx">
                            <p class="form-field form-field-wide wc-customer-user">
                                <!--email_off-->
                                <!-- Disable CloudFlare email obfuscation -->
                                <label for="customer_user_mbt">
                                    <b>Select a Customer</b>
                                    <select class="customer_user_mbt form-control" data-placeholder="Select a Customer" data-allow_clear="true" style="width:500px" name="customer_user_mbt"></select>
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
                <?php
                }
                ?>





                <div class="checkbox-button-create-customer">

                    <div class="flex-row">
                        <p class="form-field form-field-wide ml-20">
                            <label for="customer_send_email">
                                <input class="customer_send_email form-control" type="checkbox" id="customer_send_email" name="customer_send_email" value="yes" /> Send order email to
                                customer
                            </label>
                        </p>
                        <p class="form-field form-field-wide ml-20">
                            <label for="gift_order">
                                <input class="gift_order form-control" type="checkbox" id="gift_order" name="gift_order" value="yes" /> Gift Order
                            </label>
                        </p>
                        <p class="form-field form-field-wide ml-20">
                            <label for="customer_send_email_invoice">
                                <input class="customer_send_email_invoice form-control" type="checkbox" id="customer_send_email_invoice" name="customer_send_email_invoice" value="yes" /> Send
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
        <table class="widefat" id="addon-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount (%)</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="flex-row add-buttonss">
            <div class="col-sm-12">
                <button id="add_addon_product_btn" class="button" type="button">Add Product</button>
                <button id="apply_a_coupon_create_order" onclick="addCouponToOrder()" class="button" type="button">Apply a
                    gift code</button>
            </div>

        </div>

        <div id="customerPaymentDetails"></div>

        <div id="addon_summery">
            <div class="widefat">
                <div class="tbody flex-row">
                    <div class="tr-div" style="display: none">
                        <td><b>Email</b></td>
                        <td style="text-align: left !important;"><label>Send if Checked.&nbsp;&nbsp;<input type="checkbox" id="addOnEmail" name="addOnEmail" /></label></td>
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
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" id="addOnShippingCostAmount" name="addOnShippingCostAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" /></div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Discount</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" readonly="" id="addOnDiscountAmount" name="addOnDiscountAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" />
                            <input type="hidden" name="couponCode" id="couponCode" value="" autocomplete="off" />
                            <div id="couponCodeHtml">

                            </div>
                        </div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Total</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" id="addOnTotalAmount" readonly="" name="addOnTotalAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" /></div>
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
        <?php
        if (isset($_REQUEST['parent_order_id'])) {
            echo '<input type="hidden" name="parent_order_id" value="' . $_REQUEST['parent_order_id'] . '" autocomplete="off" />';
        }
        if (isset($_REQUEST['order_type'])) {
            echo '<input type="hidden" name="order_type" value="' . $_REQUEST['order_type'] . '" autocomplete="off" />';
        }
        ?>
        <input type="hidden" name="order_id" value="0" id="created_order_id" autocomplete="off" />
    </form>


    <div id="newOrder_ajax_response"></div>

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
                'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'data-only'),
                'operator' => 'NOT IN',
            ),
            /*
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => array('simple'),
                'operator' => 'NOT IN',
            ),
            */
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
            //$disabledAttribute = 'disabled';
            $disabledText = ' (Back Order)';
        }


        $products_options .= '<option  ' . $disabledAttribute . ' twp="' . $threewayProduct . '" value="' . $prod_id . '" data-price= "' . $p_price . '">' . $prod_id . '  - ' . get_the_title($prod_id) . $disabledText . '</option>';
    }
    ?>
    <script>
        <?php
        if (isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] > 0) {
            // $user_info = get_userdata($_REQUEST['customer_id']);
            //$user_email = $user_info->user_email;
        ?>
            jQuery(document).ready(function() {
                customer_user_dropdown_changed(<?php echo $_REQUEST['customer_id']; ?>);
            });
        <?php
        }
        ?>


        jQuery('body').find('#addOnShippingCostAmount').keypress(function(event) {
            if (event.which != 46) {
                if ((event.which != 8 && isNaN(String.fromCharCode(event.which)))) {
                    event.preventDefault(); //stop character from entering input
                }
            }
        });
        jQuery(".add_products").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });



        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".add_products , .quantity_addon",
            function(e) {
                if (jQuery('#couponCode').val()) {
                    updateCouponDiscountOnChange(jQuery('#couponCode').val());
                }

            });

        function calculateProductSection() {
            jQuery('#addOn_order_form').find('table tbody tr').each(function(i, obj) {

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
            });
            //jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
            //jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".discount_amount", function(e) {
            removeCouponCode(1);
        });
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".discount_amount", function(e) {
            removeCouponCode(1);
        });

        function updateProductSection(eventObj) {
            $getParentTr = jQuery(eventObj).closest('tr');
            var twp = $getParentTr.find('.add_products option:selected').attr('twp');
            $product_price = $getParentTr.find('input[name="price[]"]').val();
            $getParentTr.find('input[name="price[]"]').val($product_price);
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
                $getParentTr.find('input[name="sub_total[]"]').val($discount_price);
                $getParentTr.find('input[name="discountItemAmount[]"]').val($discount);
                $calculated_price = $total_price = $product_price * $qty;


            } else {
                $calculated_price = parseFloat($calculated_price);
                $calculated_price = $calculated_price.toFixed(2);
                $getParentTr.find('input[name="discountItemAmount[]"]').val(0);
                $getParentTr.find('input[name="sub_total[]"]').val($calculated_price);
            }


            jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }

        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".add_products",
            function(e) {
                $getParentTr = jQuery(this).closest('tr');
                $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
                $getParentTr.find('input[name="price[]"]').val($product_price);
                updateProductSection(jQuery(this));
            });

        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".quantity_addon  , .discount_amount , .price_addon",
            function(e) {
                updateProductSection(jQuery(this));
            });

        function calculateDiscountAmountSBR() {
            var total_discount_amount = 0;
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function(i, obj) {
                if (parseFloat(jQuery(obj).val()) > 0) {
                    total_discount_amount = parseFloat(total_discount_amount) + parseFloat(jQuery(obj).val());
                    total_discount_amount = total_discount_amount.toFixed(2);
                }
            });
            return parseFloat(total_discount_amount);
        }

        function calculateShippingAmountSBR() {
            var shippingVal = 0;
            shippingVal = parseFloat(jQuery('#addOnShippingCostAmount').val());
            if (isNaN(shippingVal)) {
                shippingVal = 0
            }
            return parseFloat(shippingVal.toFixed(2));
        }

        function calculateTotalAmountSBR() {

            var original_amount = 0;
            jQuery(document).find('.price_addon').each(function() {
                new_amount = parseFloat(jQuery(this).val());
                qty = parseFloat(jQuery(this).parent().parent().find('.quantity_addon').val());
                unit_total = new_amount * qty;
                original_amount = original_amount + unit_total;

            });
            return parseFloat(original_amount.toFixed(2));
        }

        jQuery("body").find('#smile_brillaint_addNewOrder').on("change", "#shipping_method_mbt", function() {
            shipmentCost = jQuery('option:selected', this).attr('data-price');
            jQuery('#addOnShippingCostAmount').val(shipmentCost)
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        });


        function calculateGrossAmountSBR(disocuntCouponAmount = '') {

            if (disocuntCouponAmount != '') {
                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - disocuntCouponAmount;
            } else {
                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - calculateDiscountAmountSBR();
            }
            return grossTotalAmount.toFixed(2);
        }





        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("keyup", "#addOnShippingCostAmount", function(
            e) {
            if (jQuery('#couponCode').val()) {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR(jQuery('#addOnDiscountAmount').val()));
            } else {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
            }

        });
        var add_addon_prodcut = 1; //initlal text box count
        jQuery("body").find('#smile_brillaint_addNewOrder #addon-table tbody').on("click", ".remove_field", function(
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

        jQuery(document).ready(function() {
            var max_fields = 10; //maximum input boxes allowed
            // var wrapper = jQuery("body").find('#addon-table tbody'); //Fields wrapper
            //var add_button = jQuery("body").find("#add_addon_product_btn"); //Add button ID
            jQuery("body").find("#smile_brillaint_addNewOrder").on("click", "#add_addon_product_btn", function(e) {

                // jQuery(add_button).click(function (e) { //on add input button click
                //    jQuery(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                console.log('Added')
                let productAId = sbr_uniqId();
                if (add_addon_prodcut < max_fields) { //max input box allowed
                    add_addon_prodcut++; //text box increment
                    var html = '';
                    html += '<tr>';
                    //  html += '<td><select class="add_products" id="productA_' + productAId + '" name="product_id[]"><?php echo $products_options; ?></select></td>';
                    html += '<td>';
                    html += '<span class="productAreaContainer">';
                    html += '<select class="add_products" id="productA_' + productAId + '" name="product_id[]"><?php echo $products_options; ?></select>';
                    html += '<input type="hidden" autocomplete="off" name="tray_number[]" value="" />';

                    html += '</span>';
                    html += '</td>';

                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0.00" value="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="1" max="100" autocomplete="off" name="item_qty[]" placeholder="1" size="4" value="1" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_amount"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon">';
                    html += '<input type="hidden"  autocomplete="off"  name="discountItemAmount[]" placeholder="0" class="discountItemAmount">';
                    html += '</td>';
                    html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                    jQuery("body").find("#smile_brillaint_addNewOrder #addon-table tbody").append(html); //add input box
                    jQuery(".add_products").select2({
                        placeholder: "Please select product.",
                        allowClear: true,
                        width: '100%',
                        minimumInputLength: 1
                    });

                    jQuery('body').find('#productA_' + productAId).select2('open').focus();
                    jQuery('body').find('#productA_' + productAId + ' .select2-search__field').trigger('click');
                }
            });
            //  jQuery("body").find('#TB_window').addClass('addOn_mbt');

        });
        jQuery('body').on('click', '#addPaymentProfile_checkbox', function() {
            if (jQuery(this).prop('checked') == true) {
                //jQuery('body').find('#addOn-modal-footer_cc').hide();
                jQuery('body').find('#addOn_addPaymentProfile_form').show();
            } else {
                jQuery('body').find('#addOn_addPaymentProfile_form').hide();
                //  jQuery('body').find('#addOn-modal-footer_cc').show();
            }
        });

        function updateCouponDiscountOnChange(couponCode) {
            jQuery('.loading-element').show();
            var formdata = jQuery('#addOn_order_form').serialize() + '&action=apply_giftCode_sbr&gift_code=' + couponCode;
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                // async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    jQuery('.loading-element').hide();
                    console.log(response);
                    console.log(response.status);
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
                        '&action=apply_giftCode_sbr&gift_code=' + gift_code;
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
            jQuery('#addOn_order_form').find('.discount_amount').each(function(i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function(i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }

        jQuery("body").on('click', 'input[name="payment_via"]', function(event) {
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

        jQuery('body').on('click', '#create_payment_profile_mbtbkkk', function(e) {
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
                        success: function(response) {
                            grecaptcha.reset(); // Reset the reCAPTCHA widget
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
                        'parent_order_id' => isset($_REQUEST['parent_order_id']) ? $_REQUEST['parent_order_id'] : 0,
                    ),
                    admin_url('admin-ajax.php')
                );

                $paymentdata_url = add_query_arg(
                    array(
                        'action' => 'mbt_customer_payment_information',
                    ),
                    admin_url('admin-ajax.php')
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
                    beforeSend: function(xhr) {
                        jQuery('body').find('#customerBillingShippingDetails').empty();
                        jQuery('body').find('#customerBillingShippingDetails').html(smile_brillaint_load_html());
                    },
                    success: function(response) {
                        jQuery('body').find('#customerBillingShippingDetails').html(response);
                    },
                    error: function(xhr) {
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
                    beforeSend: function(xhr) {
                        jQuery('body').find('#customerPaymentDetails').empty();
                        jQuery('body').find('#customerPaymentDetails').html(smile_brillaint_load_html());
                    },
                    success: function(response) {
                        jQuery('body').find('#customerPaymentDetails').html(response);
                    },
                    error: function(xhr) {
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
                data: function(data) {
                    return {
                        term: data.term,
                        action: 'woocommerce_json_search_customers',
                        security: '<?php echo wp_create_nonce('search-customers'); ?>',
                    };
                },
                processResults: function(data) {
                    if (data.length == 0) {
                        jQuery('.openpop').show();
                    } else {
                        jQuery('.openpop').show();
                    }
                    //console.log(data);
                    var terms = [];
                    if (data) {
                        jQuery.each(data, function(id, text) {
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
            setTimeout(function() {
                jQuery('body').find('#newOrder_ajax_response').html('');
            }, 5000);
        }



        jQuery(document).on('click', '#wp_signup_form', function(e) {
            e.preventDefault();
            data_f = $('#woocreateuser :input').serialize();
            jQuery.ajax({
                data: data_f,
                method: 'post',
                url: ajaxurl,
                success: function(res) {
                    console.log(res);
                }
            });
        });
        var customer_email = '';

        jQuery(document).on('click', '.openpop', function() {


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
            setTimeout(function() {
                jQuery("#customer_tags").select2({
                    placeholder: "Please select tags.",
                    allowClear: true,
                    width: '100%'
                });
            }, 500);
        });
        jQuery(document).on('change', '.customer_user_mbt', function() {
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
        jQuery("body").on('click', '#generate_CSR_order', (function(e) {
            if (!validate_create_order_mbt()) {
                return false;
            }

            Swal.fire({
                title: 'Do you want to place Order?.',
                //text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create Order'
            }).then((result) => {
                if (result.isConfirmed) {

                    jQuery('body').find('.loading-sbr').show();
                    count_addToCart = false;
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=createOrderByCSR'); ?>';
                    var elementT = document.getElementById("addOn_order_form");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function(response) {

                            console.log(response);
                            count_addToCart = true;
                            jQuery('body').find('.loading-sbr').hide();
                            if (response.order_id) {
                                if (response.error) {
                                    Swal.fire(
                                        'Oops!',
                                        response.msg,
                                        'info'
                                    );

                                } else {

                                    smile_brillaint_order_modal.style.display = "none";
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Addon Order Created.',
                                        text: response.msg,
                                        html: response.addon
                                    });

                                }
                                if (response.order_id) {
                                    jQuery('body').find('#created_order_id').val(response.order_id);
                                }
                                //jQuery('body').find('#newOrder_ajax_response').html(smile_brillaint_addOrder_fail_status_html(response.msg));
                            } else {
                                Swal.fire(
                                    'Oops!',
                                    response.msg,
                                    'error'
                                );

                                // jQuery('body').find('#newOrder_ajax_response').html(response.msg);
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


            var rowCountproducts = jQuery('#addon-table>tbody tr').length;
            if (rowCountproducts == 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please add some products',
                });
                return false;
            }
            submitp = true;
            jQuery('.add_products').each(function() {
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
                    .each(function() {
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
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'create_addon_order') {
        //        echo '<pre>';
        //        print_r($_REQUEST);
        //        echo '</pre>';
        die;
    }
}

function create_order_page_mbt()
{
    create_order_style_mbt();
    echo '<h2> Create Order</h2>';
    echo '<div id="smile_brillaint_addNewOrder">';
    ?>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <?php
    $orderTags = get_terms(array(
        'taxonomy' => 'order_tag',
        'hide_empty' => false,
    ));
    $termTags = array();
    $jsOrderTags = array();
    foreach ($orderTags as $tag) {
        $termTags[] = $tag->name;
        $jsOrderTags[] = $tag->name;
    }
    $filePath = '/assets/js/orderTags.json';
    file_put_contents(get_stylesheet_directory() . $filePath, json_encode($jsOrderTags));
    ?>
    <div class="loading-sbr loading-element" style="display: none;">
        <div class="inner-sbr"></div>
    </div>
    <!-- <div class="loading-element" style="display:none"><span class="spinner is-active"></span></div> -->
    <form id="addOn_order_form" class="addon-order-form-mbt">




        <div class="bg-light create-ordr-mbt-tp">
            <div class="flex-row">
                <div class="col-sm-6">
                    <div class="clr-bx">
                        <p class="form-field form-field-wide SBR_orderType">
                            <!--email_off-->
                            <!-- Disable CloudFlare email obfuscation -->

                            <label for="sbr_order_type">
                                <span class="display-block"> <b>Select order type</b></span>
                                <select class="form-control" autocomplete="off" data-placeholder="Select order type" data-allow_clear="true" id="sbr_order_type" name="sbr_order_type">
                                    <option value="retail-online">Retail-online</option>
                                    <option value="wholesale">Wholesale</option>
                                    <option value="dentist">Dentist</option>
                                    <option value="influencer/marketing">Influencer/Marketing</option>
                                    <option value="sample">Sample</option>
                                </select>
                            </label>
                            <!--/email_off-->
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="clr-bx select-labels">
                        <p class="form-field form-field-wide order-labels">
                            <label for="sbr_order_labels">
                                <b>Select labels</b>
                                <input type="text" id="sbr_order_labels" name="sbr_order_labels" value="" class="tagsinput" data-role="tagsinput" />

                                <script>
                                    var citynames = new Bloodhound({
                                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                                        prefetch: {
                                            url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/js/orderTags.json?ver=<?php echo time() ?>',
                                            filter: function(list) {
                                                return jQuery.map(list, function(cityname) {
                                                    return {
                                                        name: cityname
                                                    };
                                                });
                                            }
                                        }
                                    });
                                    citynames.initialize();

                                    jQuery('.tagsinput').tagsinput({
                                        typeaheadjs: {
                                            name: 'citynames',
                                            displayKey: 'name',
                                            valueKey: 'name',
                                            source: citynames.ttAdapter()
                                        }
                                    });
                                </script>

                            </label>
                        </p>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="clr-bx">
                        <p class="form-field form-field-wide wc-customer-user">
                            <!--email_off-->
                            <!-- Disable CloudFlare email obfuscation -->
                            <label for="customer_user_mbt">

                                <span class="display-block"> <b>Select a Customer</b></span>
                                <select class="customer_user_mbt form-control" data-placeholder="Select a Customer" data-allow_clear="true" style="width:500px" name="customer_user_mbt"></select>
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
                                <input class="customer_send_email form-control" type="checkbox" id="customer_send_email" name="customer_send_email" value="yes" /> Send order email to
                                customer
                            </label>
                        </p>
                        <p class="form-field form-field-wide ml-20">
                            <label for="gift_order">
                                <input class="gift_order form-control" type="checkbox" id="gift_order" name="gift_order" value="yes" /> Gift Order
                            </label>
                        </p>
                        <p class="form-field form-field-wide ml-20">
                            <label for="customer_send_email_invoice">
                                <input class="customer_send_email_invoice form-control" type="checkbox" id="customer_send_email_invoice" name="customer_send_email_invoice" value="yes" /> Send
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
        <table class="widefat" id="addon-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount (%)</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="flex-row add-buttonss">
            <div class="col-sm-12">
                <button id="add_addon_product_btn" class="button" type="button">Add Product</button>
                <button id="apply_a_coupon_create_order" onclick="addCouponToOrder()" class="button" type="button">Apply a
                    gift code</button>
            </div>

        </div>

        <div id="customerPaymentDetails"></div>

        <div id="addon_summery">
            <div class="widefat">
                <div class="tbody flex-row">
                    <div class="tr-div" style="display: none">
                        <td><b>Email</b></td>
                        <td style="text-align: left !important;"><label>Send if Checked.&nbsp;&nbsp;<input type="checkbox" id="addOnEmail" name="addOnEmail" /></label></td>
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
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" id="addOnShippingCostAmount" name="addOnShippingCostAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" /></div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Discount</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" readonly="" id="addOnDiscountAmount" name="addOnDiscountAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" />
                            <input type="hidden" name="couponCode" id="couponCode" value="" autocomplete="off" />
                            <div id="couponCodeHtml">

                            </div>
                        </div>
                    </div>
                    <div class="tr-div">
                        <div class="td-div"><b>Total</b></div>
                        <div class="td-div"><span class="currencySign">$</span><input type="number" value="0" id="addOnTotalAmount" readonly="" name="addOnTotalAmount" autocomplete="off" style="width: 100%;max-width: 100% !important;" /></div>
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
        <?php
        if (isset($_REQUEST['parent_order_id'])) {
            echo '<input type="hidden" name="parent_order_id" value="' . $_REQUEST['parent_order_id'] . '" autocomplete="off" />';
        }
        if (isset($_REQUEST['order_type'])) {
            echo '<input type="hidden" name="order_type" value="' . $_REQUEST['order_type'] . '" autocomplete="off" />';
        }
        ?>
        <input type="hidden" name="order_id" value="0" id="created_order_id" autocomplete="off" />
    </form>


    <div id="newOrder_ajax_response"></div>
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
                'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'data-only'),
                'operator' => 'NOT IN',
            ),
            /*
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => array('simple'),
                'operator' => 'NOT IN',
            ),
            */
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
        //   $validationStock = add_to_cart_validation_composite_product($prod_id);
        $disabledAttribute = '';
        $disabledText = '';
        //     if (!$validationStock) {
        // $disabledAttribute = 'disabled';
        //          $disabledText = ' (Back Order)';
        //  }

        $categories = wp_get_post_terms($prod_id, 'product_cat');
        $has_proshield_category = false;

        foreach ($categories as $category) {
            if ($category->slug === 'proshield') {
                $has_proshield_category = true;
                break;
            }
        }
        $proshield = 'no';
        if ($has_proshield_category) {
            $proshield = 'yes';
        }
//subscription#RB [search-subscription]
//shine#RB
$subscription = 0;
$rows = get_field('define_subscription_plans', $prod_id);
if(!$rows)
    $rows = get_field('define_shine_membership_plans', $prod_id);
if($rows && count($rows) > 0) {
    $subscription = 1;
}
$products_options .= '<option  ' . $disabledAttribute . ' twp="' . $threewayProduct . '" proshield="' . $proshield . '" subscription="' . $subscription . '" value="' . $prod_id . '" data-price= "' . $p_price . '">' . $prod_id . '  - ' . get_the_title($prod_id) . $disabledText . '</option>';

        // $products_options .= '<option  ' . $disabledAttribute . ' twp="' . $threewayProduct . '" value="' . $prod_id . '" data-price= "' . $p_price . '">' . $prod_id . '  - ' . get_the_title($prod_id) . $disabledText . '</option>';
    }
    ?>
    <script>
        <?php
        if (isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] > 0) {
            $user_info = get_userdata($_REQUEST['customer_id']);

            $user_email = $user_info->user_email;
        ?>
            jQuery(document).ready(function() {
                jQuery('.customer_user_mbt').append('<option value="<?php echo $_REQUEST['customer_id']; ?>" selected="selected">#<?php echo $_REQUEST['customer_id'] . ' - ' . $user_email; ?> </option>');
                jQuery('.customer_user_mbt').trigger('change');
            });
        <?php
        }
        ?>


        jQuery('body').find('#addOnShippingCostAmount').keypress(function(event) {
            if (event.which != 46) {
                if ((event.which != 8 && isNaN(String.fromCharCode(event.which)))) {
                    event.preventDefault(); //stop character from entering input
                }
            }
        });
        jQuery(".add_products").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });



        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".add_products , .quantity_addon",
            function(e) {
                if (jQuery('#couponCode').val()) {
                    updateCouponDiscountOnChange(jQuery('#couponCode').val());
                }

            });

        function calculateProductSection() {
            jQuery('#addOn_order_form').find('table tbody tr').each(function(i, obj) {

                $getParentTr = jQuery(this);
                var twp = $getParentTr.find('.add_products option:selected').attr('twp');
                var subscription = $getParentTr.find('.add_products option:selected').attr('subscription');
                if ($getParentTr.attr('id') == 'parentAddonTr') {
                    $product_price = $getParentTr.find('input[name="price[]"]').val();
                } else {
                    $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
                    // console.log($product_price);
                    $discount = $product_price;
                    if ($getParentTr.find('.customizedProduct').is(':checked')) {
                        $calculated_priceP = parseFloat($product_price);
                        $calculated_priceP += 15;
                        $product_price = $calculated_priceP.toFixed(2);

                        $getParentTr.find('input[name="price[]"]').val($product_price);
                    } else {
                        $getParentTr.find('input[name="price[]"]').val($product_price);
                    }

                    // $getParentTr.find('input[name="price[]"]').val($product_price);
                }
                // $product_price = $getParentTr.find('input[name="new_product_id[]"] option:selected').attr('data-price');
                if (twp == 'yes' || subscription == 1) {
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
            });
            //jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
            //jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".discount_amount", function(e) {
            removeCouponCode(1);
        });
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".discount_amount", function(e) {
            removeCouponCode(1);
        });

        function updateProductSection(eventObj) {
            $getParentTr = jQuery(eventObj).closest('tr');
            var twp = $getParentTr.find('.add_products option:selected').attr('twp');
            var subscription = $getParentTr.find('.add_products option:selected').attr('subscription');
            $product_price = $getParentTr.find('input[name="price[]"]').val();
            $getParentTr.find('input[name="price[]"]').val($product_price);
            if (twp == 'yes' || subscription == 1) {
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
                $getParentTr.find('input[name="sub_total[]"]').val($discount_price);
                $getParentTr.find('input[name="discountItemAmount[]"]').val($discount);
                $calculated_price = $total_price = $product_price * $qty;


            } else {
                $calculated_price = parseFloat($calculated_price);
                $calculated_price = $calculated_price.toFixed(2);
                $getParentTr.find('input[name="discountItemAmount[]"]').val(0);
                $getParentTr.find('input[name="sub_total[]"]').val($calculated_price);
            }


            jQuery('#addOnDiscountAmount').val(calculateDiscountAmountSBR());
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".customizedProduct", function(e) {
            $getParentTr = jQuery(this).closest('tr');
            if (jQuery(this).is(':checked')) {
                var randomId = Math.random().toString(36).substr(2, 9);
                var htmlProshield = '<div class="customizedProductArea">';
                htmlProshield += '<label for="proshieldColor' + randomId + '" class="proshieldColor">';
                htmlProshield += '<span class="display-block"> <b>Proshield color</b></span>';
                htmlProshield += '<select class="form-control" autocomplete="off" data-placeholder="Select Color" data-allow_clear="true" name="proshieldColor[]" id="proshieldColor' + randomId + '">';
                htmlProshield += '<option value="Clear">Clear</option>';
                htmlProshield += '<option value="White">White</option>';
                htmlProshield += '<option value="Red">Red</option>';
                htmlProshield += '<option value="Green">Green</option>';
                htmlProshield += '<option value="Blue">Blue</option>';
                htmlProshield += '<option value="Yellow">Yellow</option>';
                htmlProshield += '<option value="Orange">Orange</option>';
                htmlProshield += '<option value="Purple">Purple</option>';
                htmlProshield += '<option value="Black">Black</option>';
                htmlProshield += '<option value="Pink">Pink</option>';
                htmlProshield += '</select>';
                htmlProshield += '</label>';
                htmlProshield += '<label for="proshieldCustomID' + randomId + '" class="proshieldCustomID">';
                htmlProshield += '<span class="display-block"> <b>Custom ID</b></span>';
                htmlProshield += '<input type="text" autocomplete="off" id="proshieldCustomID' + randomId + '" name="proshieldCustomID[]" maxlength="2">';
                htmlProshield += '</label>';
                htmlProshield += '</div>';
                $getParentTr.find('.proshieldCreateOrder').append(htmlProshield);
            } else {
                jQuery(this).closest('tr').find('.customizedProductArea').remove();
            }
            calculateProductSection();
        });
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".subscritions_class", function(e) {
            $getParentTr = jQuery(this).closest('tr');
            $product_id = $getParentTr.find('.add_products option:selected').val();
            $selected_opt = $getParentTr.find('.subscritions_class option:selected').val();
            if($selected_opt == ''){
                $getParentTr.find('input[name="price[]"]').val(jQuery('#preprice_'+$product_id).val());
            }else{
                $getParentTr.find('input[name="price[]"]').val($getParentTr.find('.subscritions_class option:selected').attr('data-price'));
                $getParentTr.find('input[name="subscription_products[]"]').val($product_id);
                $getParentTr.find('input[name="subscription_arbids[]"]').val($getParentTr.find('.subscritions_class option:selected').attr('arbid'));
            }
            updateProductSection(jQuery(this));
        });
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change", ".add_products", function(e) {
            $getParentTr = jQuery(this).closest('tr');
            $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
            $product_id = $getParentTr.find('.add_products option:selected').val();

            $proshield = $getParentTr.find('.add_products option:selected').attr('proshield');
            $subscription = $getParentTr.find('.add_products option:selected').attr('subscription');

            if ($proshield == 'yes') {
                var randomId = Math.random().toString(36).substr(2, 9);
                var htmlProshield = '<div class="proshieldCreateOrder">';
                htmlProshield += '<div class="customizedProductCheckBox">';
                htmlProshield += '<label for="Customized' + randomId + '">';
                htmlProshield += '<input class="customizedProduct form-control" type="checkbox" id="Customized' + randomId + '" name="customizeProduct[]" value="yes"> Customized';
                htmlProshield += '</label>';
                htmlProshield += '</div>';
                htmlProshield += '</div>';

                jQuery(this).closest('td').append(htmlProshield);
            } else {
                $getParentTr.find('.proshieldCreateOrder').remove();
            }
            if ($subscription == 1) {
                var randomId = Math.random().toString(36).substr(2, 9);
                var htmlSubscriptionId = '<div class="subscriptionCreateOrder">';
                htmlSubscriptionId += '<select class="form-control subscritions_class" id="subscriptsId' + randomId + '" name="subscription_ids[]"><option value="">Select Subscription</select>';
                htmlSubscriptionId += '<input type="hidden" id="subscriptionArbIds' + randomId + '" name="subscription_arbids[]" value="-1"/>';
                htmlSubscriptionId += '<input type="hidden" id="subscriptionProducts' + randomId + '" name="subscription_products[]" value="-1"/>';
                htmlSubscriptionId += '<input type="hidden" id="preprice_' + $product_id + '" value="'+$product_price+'" />';

                var subResp = '';
                jQuery.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        action: 'get_subscription_items',
                        product_id: $product_id,
                        frequency: null,
                    },
                    async: true,
                    method: 'GET',
                    success: function(response) {
                        jQuery('.loading-sbr').hide();
                        data = JSON.parse(response);
                        
                        if(data.options){
                            jQuery('#subscriptsId'+randomId).append(data.options);
                           // jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form .subscritions_class").trigger('change');
                        }                            
                    },
                    error: function(xhr) {
                    },
                    cache: false,
                });

                htmlSubscriptionId += '</div>';
                jQuery(this).closest('td').append(htmlSubscriptionId);
            } else {
                $getParentTr.find('.subscriptionCreateOrder').remove();
            }

            $getParentTr.find('.trayContainer').remove();
            //795483,793962,739363
            if ($product_id == 795483 || $product_id == 793962 || $product_id == 739363) {
                Swal.fire({
                    title: 'Tray number',
                    inputPlaceholder: 'Enter the tray number.',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (trayno) => {
                        return fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=calculateTrayPrice&trayno=' + trayno + '&product_id=' + $product_id)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .then(data => {
                                if (!data.response) {
                                    throw new Error(data.message || 'Error occurred');
                                }
                                return data;
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
                        var trayHtml = '';
                        trayHtml += '<span class="trayContainer">';
                        trayHtml += '<span class="signTray">Tray# ' + result.value.trayno + '</span>';
                        trayHtml += '</span>';
                        $getParentTr.find('.productAreaContainer').after(trayHtml);
                        if (result.value.response) {
                            $getParentTr.find('input[name="price[]"]').val(result.value.price);
                        } else {
                            $getParentTr.find('input[name="price[]"]').val($product_price);
                        }
                        $getParentTr.find('input[name="tray_number[]"]').val(result.value.trayno);
                        updateProductSection(jQuery(this));

                    }
                });
            } else {

                if ($getParentTr.find('.customizedProduct').is(':checked')) {
                    $getParentTr.find('input[name="price[]"]').val($product_price + 15);
                } else {
                    $getParentTr.find('input[name="price[]"]').val($product_price);
                }
                updateProductSection(jQuery(this));
            }
        });
        /*
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".add_products",
            function(e) {
                $getParentTr = jQuery(this).closest('tr');
                $product_price = $getParentTr.find('.add_products option:selected').attr('data-price');
                $getParentTr.find('input[name="price[]"]').val($product_price);
                updateProductSection(jQuery(this));
            });
*/
        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("change",
            ".quantity_addon  , .discount_amount , .price_addon",
            function(e) {
                updateProductSection(jQuery(this));
            });

        function calculateDiscountAmountSBR() {
            var total_discount_amount = 0;
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function(i, obj) {
                if (parseFloat(jQuery(obj).val()) > 0) {
                    total_discount_amount = parseFloat(total_discount_amount) + parseFloat(jQuery(obj).val());
                    total_discount_amount = total_discount_amount.toFixed(2);
                }
            });
            return parseFloat(total_discount_amount);
        }

        function calculateShippingAmountSBR() {
            var shippingVal = 0;
            shippingVal = parseFloat(jQuery('#addOnShippingCostAmount').val());
            if (isNaN(shippingVal)) {
                shippingVal = 0
            }
            return parseFloat(shippingVal.toFixed(2));
        }

        function calculateTotalAmountSBR() {

            var original_amount = 0;
            jQuery(document).find('.price_addon').each(function() {
                new_amount = parseFloat(jQuery(this).val());
                qty = parseFloat(jQuery(this).parent().parent().find('.quantity_addon').val());
                unit_total = new_amount * qty;
                original_amount = original_amount + unit_total;

            });
            return parseFloat(original_amount.toFixed(2));
        }

        jQuery("body").find('#smile_brillaint_addNewOrder').on("change", "#shipping_method_mbt", function() {
            shipmentCost = jQuery('option:selected', this).attr('data-price');
            jQuery('#addOnShippingCostAmount').val(shipmentCost)
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        });


        function calculateGrossAmountSBR(disocuntCouponAmount = '') {

            if (disocuntCouponAmount != '') {
                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - disocuntCouponAmount;
            } else {
                var grossTotalAmount = calculateTotalAmountSBR() + calculateShippingAmountSBR() - calculateDiscountAmountSBR();
            }
            return grossTotalAmount.toFixed(2);
        }





        jQuery("body").find("#smile_brillaint_addNewOrder #addOn_order_form").on("keyup", "#addOnShippingCostAmount", function(
            e) {
            if (jQuery('#couponCode').val()) {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR(jQuery('#addOnDiscountAmount').val()));
            } else {
                jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
            }

        });
        var add_addon_prodcut = 1; //initlal text box count
        jQuery("body").find('#smile_brillaint_addNewOrder #addon-table tbody').on("click", ".remove_field", function(
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

        jQuery(document).ready(function() {
            var max_fields = 10; //maximum input boxes allowed
            // var wrapper = jQuery("body").find('#addon-table tbody'); //Fields wrapper
            //var add_button = jQuery("body").find("#add_addon_product_btn"); //Add button ID
            jQuery("body").find("#smile_brillaint_addNewOrder").on("click", "#add_addon_product_btn", function(e) {

                // jQuery(add_button).click(function (e) { //on add input button click
                //    jQuery(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                console.log('Added')
                if (add_addon_prodcut < max_fields) { //max input box allowed
                    add_addon_prodcut++; //text box increment
                    let productAId = sbr_uniqId();
                    var html = '';
                    html += '<tr>';
                    html += '<td><select class="add_products" id="productA_' + productAId + '" name="product_id[]"><?php echo $products_options; ?></select></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0.00" value="0.00" size="4" class="price_addon"></td>';
                    html += '<td><input type="number" step="1" min="1" max="100" autocomplete="off" name="item_qty[]" placeholder="1" size="4" value="1" class="quantity_addon"></td>';
                    html += '<td><input type="number" step="1" min="0" max="100" autocomplete="off" name="discount[]" placeholder="0" size="4" class="discount_amount"></td>';
                    html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" readonly="" name="sub_total[]" placeholder="0" size="4" class="subtotal_addon">';
                    html += '<input type="hidden"  autocomplete="off"  name="discountItemAmount[]" placeholder="0" class="discountItemAmount">';
                    html += '</td>';
                    html += '<td><a href="javascript:;" class="remove_field"><span class="dashicons dashicons-no-alt"></span></a></td>';
                    html += '</tr>';
                    jQuery("body").find("#smile_brillaint_addNewOrder #addon-table tbody").append(html); //add input box
                    jQuery(".add_products").select2({
                        placeholder: "Please select product.",
                        allowClear: true,
                        width: '100%',
                        minimumInputLength: 1
                    });

                    jQuery('body').find('#productA_' + productAId).select2('open').focus();
                    jQuery('body').find('#productA_' + productAId + ' .select2-search__field').trigger('click');

                }
            });
            //  jQuery("body").find('#TB_window').addClass('addOn_mbt');

        });
        jQuery('body').on('click', '#addPaymentProfile_checkbox', function() {
            if (jQuery(this).prop('checked') == true) {
                //jQuery('body').find('#addOn-modal-footer_cc').hide();
                jQuery('body').find('#addOn_addPaymentProfile_form').show();
            } else {
                jQuery('body').find('#addOn_addPaymentProfile_form').hide();
                //  jQuery('body').find('#addOn-modal-footer_cc').show();
            }
        });

        function updateCouponDiscountOnChange(couponCode) {
            jQuery('.loading-element').show();
            var formdata = jQuery('#addOn_order_form').serialize() + '&action=apply_giftCode_sbr&gift_code=' + couponCode;
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                // async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    jQuery('.loading-element').hide();
                    console.log(response);
                    console.log(response.status);
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
                        '&action=apply_giftCode_sbr&gift_code=' + gift_code;
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
            jQuery('#addOn_order_form').find('.discount_amount').each(function(i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOn_order_form').find('.discountItemAmount').each(function(i, obj) {
                jQuery(this).val(0);
            });
            jQuery('#addOnTotalAmount').val(calculateGrossAmountSBR());
        }

        jQuery("body").on('click', 'input[name="payment_via"]', function(event) {
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

        jQuery('body').on('click', '#create_payment_profile_mbtbkkkk', function(e) {
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
                        success: function(response) {
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
                        'parent_order_id' => isset($_REQUEST['parent_order_id']) ? $_REQUEST['parent_order_id'] : 0,
                    ),
                    admin_url('admin-ajax.php')
                );
                $paymentdata_url = add_query_arg(
                    array(
                        'action' => 'mbt_customer_payment_information',
                    ),
                    admin_url('admin-ajax.php')
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
                    beforeSend: function(xhr) {
                        jQuery('body').find('#customerBillingShippingDetails').empty();
                        jQuery('body').find('#customerBillingShippingDetails').html(smile_brillaint_load_html());
                    },
                    success: function(response) {
                        jQuery('body').find('#customerBillingShippingDetails').html(response);
                    },
                    error: function(xhr) {
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
                    beforeSend: function(xhr) {
                        jQuery('body').find('#customerPaymentDetails').empty();
                        jQuery('body').find('#customerPaymentDetails').html(smile_brillaint_load_html());
                    },
                    success: function(response) {
                        jQuery('body').find('#customerPaymentDetails').html(response);
                    },
                    error: function(xhr) {
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
                data: function(data) {
                    return {
                        term: data.term,
                        action: 'woocommerce_json_search_customers',
                        security: '<?php echo wp_create_nonce('search-customers'); ?>',
                    };
                },
                processResults: function(data) {
                    if (data.length == 0) {
                        jQuery('.openpop').show();
                    } else {
                        jQuery('.openpop').show();
                    }
                    //console.log(data);
                    var terms = [];
                    if (data) {
                        jQuery.each(data, function(id, text) {
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
            setTimeout(function() {
                jQuery('body').find('#newOrder_ajax_response').html('');
            }, 5000);
        }



        jQuery(document).on('click', '#wp_signup_form', function(e) {
            e.preventDefault();
            data_f = $('#woocreateuser :input').serialize();
            jQuery.ajax({
                data: data_f,
                method: 'post',
                url: ajaxurl,
                success: function(res) {
                    console.log(res);
                }
            });
        });
        var customer_email = '';

        jQuery(document).on('click', '.openpop', function() {


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
            setTimeout(function() {
                jQuery("#customer_tags").select2({
                    placeholder: "Please select tags.",
                    allowClear: true,
                    width: '100%'
                });
            }, 500);
        });
        jQuery(document).on('change', '.customer_user_mbt', function() {
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
        jQuery("body").on('click', '#generate_CSR_order', (function(e) {
            if (!validate_create_order_mbt()) {
                return false;
            }




            Swal.fire({
                title: 'Do you want to place Order?',
                //text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create Order'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('.loading-element').show();
                    count_addToCart = false;
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php?action=createOrderByCSR'); ?>';
                    var elementT = document.getElementById("addOn_order_form");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            count_addToCart = true;
                            jQuery('.loading-element').hide();
                            if (response.order_id) {
                                if (response.error) {
                                    Swal.fire(
                                        'Oops!',
                                        response.msg,
                                        'info'
                                    );

                                } else {
                                    Swal.fire(
                                        'Good job!',
                                        response.msg,
                                        'success'
                                    );
                                    location.reload();
                                }
                                if (response.order_id) {
                                    jQuery('body').find('#created_order_id').val(response
                                        .order_id);
                                }
                                //jQuery('body').find('#newOrder_ajax_response').html(smile_brillaint_addOrder_fail_status_html(response.msg));
                            } else {
                                Swal.fire(
                                    'Oops!',
                                    response.msg,
                                    'error'
                                );

                                // jQuery('body').find('#newOrder_ajax_response').html(response.msg);
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


            var rowCountproducts = jQuery('#addon-table>tbody tr').length;
            if (rowCountproducts == 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please add some products',
                });
                return false;
            }
            submitp = true;
            jQuery('.add_products').each(function() {
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
                    .each(function() {
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
}

add_action('wp_ajax_mbt_customer_billing_information', 'createOrderUserData_callback');

function createOrderUserData_callback()
{
    if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] <> '') {
        $user_id = $_REQUEST['user_id'];
        $order_id = isset($_REQUEST['parent_order_id']) ? $_REQUEST['parent_order_id'] : 0;
    ?>


        <div class="flex-row">
            <div class="col-sm-6" id="billingInfoAdminArea">
                <div class="cmt-thed">
                    <h4>Customer Billing Address</h4>

                    <?php
                    $newUser = false;
                    if (empty(get_user_meta($user_id, 'billing_city', true))) {
                        $newUser = true;
                    ?>
                        <input name="is_billing_address_changed" id="is_billing_address_changed" type="hidden" value="new" />
                    <?php
                    } else {
                        $newUser = false;
                        if ($order_id > 0) {
                            $billing_firstname = get_post_meta($order_id, '_billing_first_name', true);
                            $billing_lastname = get_post_meta($order_id, '_billing_last_name', true);
                            $billing_phone = get_post_meta($order_id, '_billing_phone', true);
                            $billing_address_1 = get_post_meta($order_id, '_billing_address_1', true);
                            $billing_address_2 = get_post_meta($order_id, '_billing_address_2', true);
                            $billing_city = get_post_meta($order_id, '_billing_city', true);
                            $billing_state = get_post_meta($order_id, '_billing_state', true);
                            $billing_postcode = get_post_meta($order_id, '_billing_postcode', true);
                            $billing_county = get_post_meta($order_id, '_billing_country', true);
                        } else {
                            $billing_firstname = get_user_meta($user_id, 'billing_first_name', true);
                            $billing_lastname = get_user_meta($user_id, 'billing_last_name', true);
                            $billing_phone = get_user_meta($user_id, 'billing_phone', true);
                            $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true);
                            $billing_address_2 = get_user_meta($user_id, 'billing_address_2', true);
                            $billing_city = get_user_meta($user_id, 'billing_city', true);
                            $billing_state = get_user_meta($user_id, 'billing_state', true);
                            $billing_postcode = get_user_meta($user_id, 'billing_postcode', true);
                            $billing_county = get_user_meta($user_id, 'billing_country', true);
                        }
                        $billingDetails = $billing_firstname . ' ' . $billing_lastname . ' ' . $billing_address_1 . ' ' . $billing_address_2 . ' ' . $billing_city . ' ' . $billing_state . ' (' . $billing_postcode . ') , ' . WC()->countries->countries[$billing_county];
                    ?>


                        <div class="ready-toship">

                            <label for="is_billing_address_default">
                                <input name="is_billing_address_changed" id="is_billing_address_default" type="radio" checked="" class="" value="old">
                                <span class="billing-different">Default Address - <?php echo $billingDetails; ?></span>
                            </label>
                            <label for="is_billing_address_changed">
                                <input name="is_billing_address_changed" id="is_billing_address_changed" type="radio" class="" value="new">
                                <span class="billing-different">Add different card billing address</span>
                            </label>

                        </div>
                    <?php
                    }
                    ?>

                </div>
                <?php
                $styleforBilling = 'display: none';
                if ($newUser) {
                    $styleforBilling = 'display: block';
                }
                ?>
                <div class="form-body-ship" style="<?php echo $styleforBilling; ?>" id="is_billing_address_changed_tbody">
                    <div class="flex-row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> First Name </label>
                                <input type="text" name="billing_first_name" class="form-control" value="<?php echo $billing_firstname; ?>" />
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Last Name </label>
                                <input type="text" name="billing_last_name" class="form-control" value="<?php echo $billing_lastname; ?>" />
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="billing_city" class="form-control" value="<?php echo $billing_city; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Address</label>
                                <textarea class="form-control" name="billing_address_1"><?php echo $billing_address_1; ?> <?php echo $billing_address_2; ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input type="text" name="billing_postcode" class="form-control" value="<?php echo $billing_postcode; ?>" />
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group select-country-mbt">

                                <?php
                                $countries_obj = new WC_Countries();
                                $countries = $countries_obj->__get('countries');
                                if (empty($billing_county)) {
                                    $billing_county = 'US';
                                }
                                woocommerce_form_field(
                                    'billing_country',
                                    array(
                                        'type' => 'select',
                                        'required' => true,
                                        'class' => array('chzn-drop'),
                                        'label' => __('Select a country'),
                                        'placeholder' => __('Enter something'),
                                        'options' => $countries
                                    ),
                                    $billing_county
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="billingStateHtml">
                                <?php
                                get_stateByCountry_SBR('billing_state', $billing_county, $billing_state);
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Phone </label>
                                <input type="text" name="billing_phone" class="form-control" value="<?php echo $billing_phone; ?>" />
                            </div>
                        </div>


                    </div>

                </div>
            </div>

            <div class="col-sm-6" id="shippinginfoAdminArea">


                <div class="cmt-thed">
                    <h4>Customer Shipping Address</h4>
                    <?php
                    $newUser = false;
                    if (empty(get_user_meta($user_id, 'shipping_city', true))) {
                        $newUser = true;
                    ?>
                        <input name="is_shipping_address_changed" id="is_shipping_address_changed" type="hidden" value="new" />
                    <?php
                    } else {
                        $newUser = false;
                        /*
                          if ($order_id > 0) {

                          $shipping_firstname = get_post_meta($order_id, '_shipping_first_name', true);
                          $shipping_lastname = get_post_meta($order_id, '_shipping_last_name', true);
                          //   $shipping_phone = get_post_meta($order_id, 'shipping_phone', true);
                          $shipping_address_1 = get_post_meta($order_id, '_shipping_address_1', true);
                          $shipping_address_2 = get_post_meta($order_id, '_shipping_address_2', true);
                          $shipping_city = get_post_meta($order_id, '_shipping_city', true);
                          $shipping_state = get_post_meta($order_id, '_shipping_state', true);
                          $shipping_postcode = get_post_meta($order_id, '_shipping_postcode', true);
                          $shipping_county = get_post_meta($order_id, '_shipping_country', true);
                          } else {

                          $shipping_firstname = get_user_meta($user_id, 'shipping_first_name', true);
                          $shipping_lastname = get_user_meta($user_id, 'shipping_last_name', true);
                          //   $shipping_phone = get_user_meta($user_id, 'shipping_phone', true);
                          $shipping_address_1 = get_user_meta($user_id, 'shipping_address_1', true);
                          $shipping_address_2 = get_user_meta($user_id, 'shipping_address_2', true);
                          $shipping_city = get_user_meta($user_id, 'shipping_city', true);
                          $shipping_state = get_user_meta($user_id, 'shipping_state', true);
                          $shipping_postcode = get_user_meta($user_id, 'shipping_postcode', true);
                          $shipping_county = get_user_meta($user_id, 'shipping_country', true);
                          }
                         */
                        // creat_initila_address_from_default($user_id);
                        // $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ' ' . $shipping_address_1 . ' ' . $shipping_address_2 . ' ' . $shipping_city . ' ' . $shipping_state . ' (' . $shipping_postcode . ') , ' . WC()->countries->countries[$shipping_county];
                    ?>


                        <div class="ready-toship">
                            <?php
                            $shippingAddress = current_user_shipping_addresses($user_id);
                            if (count($shippingAddress) == 0) {
                                creat_initila_address_from_default($user_id);
                                $shippingAddress = current_user_shipping_addresses($user_id);
                            }
                            if (count($shippingAddress) > 0) {
                                foreach ($shippingAddress as $shipAdd) {
                                    // echo '<pre>';
                                    // print_r($shipAdd);echo '</pre>';
                                    $shipping_firstname = $shipAdd['shipping_first_name'];
                                    $shipping_lastname = $shipAdd['shipping_last_name'];
                                    $shipping_address_1 = $shipAdd['shipping_address_1'];
                                    $shipping_address_2 = $shipAdd['shipping_address_2'];
                                    $shipping_city = $shipAdd['shipping_city'];
                                    $shipping_state = $shipAdd['shipping_state'];
                                    $shipping_postcode = $shipAdd['shipping_postcode'];
                                    $shipping_county = $shipAdd['shipping_country'];
                                    $shippingDetails = $shipping_firstname . ' ' . $shipping_lastname . ' ' . $shipping_address_1 . ' ' . $shipping_address_2 . ' ' . $shipping_city . ' ' . $shipping_state . ' (' . $shipping_postcode . ') , ' . WC()->countries->countries[$shipping_county];
                                    $is_default = '';
                                    $is_default_text = '';
                                    if ($shipAdd['is_default']) :
                                        $is_default = 'checked=""';
                                        $is_default_text = 'Default Address';
                                    endif;
                            ?>
                                    <label for="is_shipping_address_default<?php echo $shipAdd['id']; ?>">
                                        <input name="is_shipping_address_changed" id="is_shipping_address_default_<?php echo $shipAdd['id']; ?>" type="radio" <?php echo $is_default; ?> class="" value="<?php echo $shipAdd['id']; ?>">
                                        <span class="shipping-different"> <?php echo $is_default_text; ?> - <?php echo esc_html($shippingDetails); ?></span>
                                    </label>
                            <?php
                                }
                            }
                            ?>
                            <label for="is_shipping_address_changed">
                                <input name="is_shipping_address_changed" id="is_shipping_address_changed" type="radio" class="" value="new">
                                <span class="shipping-different">Add different shipping address</span>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                </div>


                <?php
                $styleforshipping = 'display: none';
                if ($newUser) {
                    $styleforshipping = 'display: block';
                }
                ?>
                <div class="form-body-ship" style="<?php echo $styleforshipping; ?>" id="is_shipping_address_changed_tbody">

                    <div class="flex-row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> First Name </label>
                                <input type="text" name="shipping_first_name" class="form-control" value="<?php echo $shipping_firstname; ?>" />
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Last Name </label>
                                <input type="text" name="shipping_last_name" class="form-control" value="<?php echo $shipping_lastname; ?>" />
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="shipping_city" class="form-control" value="<?php echo $shipping_city; ?>" />
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Address</label>
                                <textarea class="form-control" name="shipping_address_1"><?php echo $shipping_address_1; ?> <?php echo $shipping_address_2; ?></textarea>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input type="text" name="shipping_postcode" class="form-control" value="<?php echo $shipping_postcode; ?>" />
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group select-country-mbt">

                                <?php
                                $countries_obj = new WC_Countries();
                                $countries = $countries_obj->__get('countries');
                                if (empty($shipping_county)) {
                                    $shipping_county = 'US';
                                }
                                woocommerce_form_field(
                                    'shipping_country',
                                    array(
                                        'type' => 'select',
                                        'required' => true,
                                        'class' => array('chzn-drop'),
                                        'label' => __('Select a country'),
                                        'placeholder' => __('Enter something'),
                                        'options' => $countries
                                    ),
                                    $shipping_county
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="shippingStateHtml">
                                <?php
                                get_stateByCountry_SBR('shipping_state', $shipping_county, $shipping_state);
                                ?>
                            </div>
                        </div>
                        <div class="copy-billing-address-parent">
                            <input name="copyBillingAddress" id="copyBillingAddress" type="checkbox" class="" value="yes">
                            <span class="copyBillingAddress">Copy Billing Address</span>
                        </div>
                        </label>


                    </div>

                </div>
            </div>

        </div>
        <?php
        $shipDropDownHtml = '';
        $arr  = get_shipping_methods_by_country_code($shipping_county, false);
        if (is_array($arr) && count($arr) > 0) {
            $shipDropDownHtml = '<select class=" sd select wc-enhanced-select" name="shipping_method_id" id="shipping_method_mbt">';
            $shipDropDownUPSHtml = '';
            $shipDropDownUSPSHtml = '';
            foreach ($arr as $key => $val) {
                if($key == 24){
                 //   continue;
                }
                $sel = '';
                $option = '<option value="' . $key . '" data-price="' . $val['cost'] . '"> ' . $val['title'] . '</option>';
                if (getShipmentCarrierLabel($key) == 'UPS') {
                    $shipDropDownUPSHtml .= $option;
                } else {
                    $shipDropDownUSPSHtml .= $option;
                }
            }
            $shipDropDownHtml .= '<optgroup label="USPS">';
            $shipDropDownHtml .= $shipDropDownUSPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '<optgroup label="UPS">';
            $shipDropDownHtml .= $shipDropDownUPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '</select>';
        }
        /*
       
        if (is_array($shippingMethodHTML) && count($shippingMethodHTML) > 0) {
            $shipDropDownHtml = '<select class="select wc-enhanced-select" name="shipping_method_id" id="shipping_method_mbt">';
            foreach ($shippingMethodHTML as $ins_id => $ship_method) {
                $shipDropDownHtml .= '<option value="' . $ins_id . '" data-price="' . $ship_method['cost'] . '"> ' . $ship_method['title'] . '</option>';
            }
            $shipDropDownHtml .= '</select>';
        }
        */
        ?>
        <script>
            jQuery('body').find('#addonShippingMethodIds').html('<?php echo $shipDropDownHtml; ?>');
            jQuery("body").find("#shipping_method_mbt").trigger("change");
            //billing_country
            jQuery(document).on("change", "#billing_country , #shipping_country", function() {
                var selectedCountry = '';
                if (jQuery(this).attr('id') == 'billing_country') {
                    var selectedCountry = 'billing_state';
                } else {
                    var selectedCountry = 'shipping_state';
                }

                <?php
                $data_url = add_query_arg(
                    array(
                        'action' => 'searchStateByCountryCode',
                    ),
                    admin_url('admin-ajax.php')
                );
                $ship_data_url = add_query_arg(
                    array(
                        'action' => 'searchShipMethodByCountryCode',
                    ),
                    admin_url('admin-ajax.php')
                );
                ?>
                if (jQuery(this).attr('id') != 'billing_country') {
                    var shipment_ajax_url = '<?php echo $ship_data_url; ?>&countryCode=' + jQuery(this).val();
                    jQuery.ajax({
                        url: shipment_ajax_url,
                        data: [],
                        async: true,
                        dataType: 'html',
                        method: 'POST',
                        success: function(shipment_response) {
                            jQuery('body').find('#addonShippingMethodIds').html(shipment_response);
                            jQuery("body").find("#shipping_method_mbt").trigger("change");
                        }
                    });

                }
                var get_ajax_url = '<?php echo $data_url; ?>&countryCode=' + jQuery(this).val() + '&name=' +
                    selectedCountry;

                var parentForm = jQuery(this).closest('form').attr('id');
                jQuery.ajax({
                    url: get_ajax_url,
                    data: [],
                    async: true,
                    dataType: 'html',
                    method: 'POST',
                    beforeSend: function(xhr) {
                        if (parentForm == 'addPaymentMethod') {
                            jQuery('body').find('#billing_state_field').empty();
                            jQuery('body').find('#billing_state_field').html('Loading....');
                        } else {
                            if (selectedCountry == 'billing_state') {
                                jQuery('body').find('#billingStateHtml').empty();
                                jQuery('body').find('#billingStateHtml').html('Loading....');
                            } else {
                                jQuery('body').find('#shippingStateHtml').empty();
                                jQuery('body').find('#shippingStateHtml').html('Loading....');
                            }
                        }

                    },
                    success: function(response) {

                        if (parentForm == 'addPaymentMethod') {

                            jQuery('body').find('#billing_state_field').empty();
                            jQuery('body').find('#billing_state_field').html(response);
                        } else {
                            if (selectedCountry == 'billing_state') {
                                jQuery('body').find('#billingStateHtml').empty();
                                jQuery('body').find('#billingStateHtml').html(response);
                            } else {
                                jQuery('body').find('#shippingStateHtml').empty();
                                jQuery('body').find('#shippingStateHtml').html(response);
                                jQuery('#shipping_state').val(jQuery('#billing_state').val());
                            }
                        }

                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Oops!',
                            'Request failed...Something went wrong.',
                            'error'
                        );
                    },
                    cache: false,
                });
            });

            var shipping_first_name = '';
            var shipping_last_name = '';
            var shipping_first_name = '';
            var shipping_phone = '';
            var shipping_city = '';
            var shipping_state = '';
            var shipping_postcode = '';
            var shipping_country = '';
            var shipping_address_1 = '';
            jQuery(document).find("#copyBillingAddress").on("click", function() {


                if (this.checked) {

                    shipping_first_name = jQuery('input[name=shipping_first_name]').val();
                    shipping_last_name = jQuery('input[name=shipping_last_name]').val();
                    shipping_phone = jQuery('input[name=shipping_phone]').val();
                    shipping_city = jQuery('input[name=shipping_city]').val();
                    shipping_state = jQuery('#shipping_state').val();
                    shipping_zipcode = jQuery('input[name=shipping_zipcode]').val();
                    shipping_country = jQuery('select[name=shipping_country]').val();
                    shipping_address_1 = jQuery('textarea[name=shipping_address_1]').val();
                    jQuery('select[name=shipping_country]').val(jQuery('select[name=billing_country]').val()).trigger(
                        'change');
                    jQuery('input[name=shipping_first_name]').val(jQuery('input[name=billing_first_name]').val());
                    jQuery('input[name=shipping_last_name]').val(jQuery('input[name=billing_last_name]').val());
                    jQuery('input[name=shipping_phone]').val(jQuery('input[name=billing_phone]').val());
                    jQuery('input[name=shipping_city]').val(jQuery('input[name=billing_city]').val());

                    jQuery('input[name=shipping_postcode]').val(jQuery('input[name=billing_postcode]').val());

                    jQuery('textarea[name=shipping_address_1]').val(jQuery('textarea[name=billing_address_1]').val());
                    jQuery('#shipping_state').val(jQuery('#billing_state').val());

                } else {
                    // alert(shipping_first_name);
                    jQuery('input[name=shipping_first_name]').val(shipping_first_name);
                    jQuery('input[name=shipping_last_name]').val(shipping_last_name);
                    jQuery('input[name=shipping_phone]').val(shipping_phone);
                    jQuery('input[name=shipping_city]').val(shipping_city);
                    jQuery('#shipping_state').val(shipping_state);
                    jQuery('input[name=shipping_postcode]').val(shipping_postcode);
                    jQuery('select[name=shipping_country]').val(shipping_country);
                    jQuery('textarea[name=shipping_address_1]').val(shipping_address_1);
                }
            });
        </script>
    <?php
    }
    die;
}

add_action('wp_ajax_mbt_customer_payment_information', 'customerPaymentDetail_callback');

function customerPaymentDetail_callback()
{
    if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] <> '') {
        $user_id = $_REQUEST['user_id'];
    ?>

        <div class="ready-toship">
            <h4>Payment Via</h4>
            <label for="is_payment_via_email">
                <input name="payment_via" id="is_payment_via_email" type="radio" checked="" value="email">
                <span class="billing-different">Email invoice / order details to customer</span>
            </label>
            <label for="is_payment_via_cc">
                <input name="payment_via" id="is_payment_via_cc" type="radio" value="cc">
                <span class="billing-different">Payment Via Credit Card</span>
            </label>
            <label for="is_payment_via_cheque">
                <input name="payment_via" id="is_payment_via_cheque" type="radio" value="cheque">
                <span class="billing-different">Payment Via Cheque</span>
            </label>


        </div>

        <div class="form-body-ship" style="display: none" id="is_payment_via_changed_tbody">
            <?php customerAddOrder_paymentProfiles($user_id); ?>
        </div>
        <script>
            function validate_create_profile_mbt() {

                /* Billing Form validation if chekced*/
                if (jQuery('#is_billing_address_changed').is(':checked') || jQuery("#is_billing_address_changed_tbody").css(
                        "display") == "block") {
                    submit = true;
                    jQuery(
                            '#is_billing_address_changed_tbody input, #is_billing_address_changed_tbody select, #is_billing_address_changed_tbody textarea'
                        )
                        .each(function() {
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
                /* payment form validation*/
                if (jQuery('#addPaymentProfile_checkbox').is(':checked')) {
                    submitb = true;
                    jQuery(
                            '#wc-authorize-net-cim-credit-card-credit-card-form input, #wc-authorize-net-cim-credit-card-credit-card-form select, #wc-authorize-net-cim-credit-card-credit-card-form textarea'
                        )
                        .each(function() {
                            if (jQuery(this).val() == '') {
                                jQuery(this).addClass('hass-error');
                                submitb = false;
                            } else {
                                jQuery(this).removeClass('hass-error');
                            }
                        });
                    if (!submitb) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Please fill the payment form fields',
                        });
                        return false;
                    }

                }
                return true;
            }
        </script>
    <?php
    }
    die;
}

add_action('wp_ajax_addCustomerPaymentProfileAdminSide', 'sbr_addNewPayemntProfileAdminSide_callback');

function sbr_addNewPayemntProfileAdminSide_callback()
{
    global $wpdb;

    $current_user_id = $_REQUEST['user_id'];
    $load_address = 'billing';
    $current_user = get_userdata($current_user_id);
    $load_address = sanitize_key($load_address);
    $country = get_user_meta($current_user_id, $load_address . '_country', true);
    // wp_enqueue_script('wc-country-select');
    //wp_enqueue_script('wc-address-i18n');
    if (!$country) {
        $country = WC()->countries->get_base_country();
    }

    if ('billing' === $load_address) {
        $allowed_countries = WC()->countries->get_allowed_countries();

        if (!array_key_exists($country, $allowed_countries)) {
            $country = current(array_keys($allowed_countries));
        }
    }
    $address = WC()->countries->get_address_fields($country, $load_address . '_');
    foreach ($address as $key => $field) {
        //$value = isset($data[$key]) ? $data[$key] : '';
        $value = get_user_meta($current_user_id, $key, true);
        if (!$value) {
            switch ($key) {
                case 'billing_email':
                    $value = $current_user->user_email;
                    break;
            }
        }

        $address[$key]['value'] = apply_filters('woocommerce_my_account_edit_address_field_value', $value, $key, $load_address);
    }
    ?>
    <form id="addPaymentMethod" class="paymentAddSec">
        <div class="shippingAddressSection editShippingAddressDetail">
            <div class="paymentMethodBox al-order1">
                <h1 class="titleSecShipping">Credit/Debit card</h1>
                <fieldset id="wc-authorize-net-cim-credit-card-credit-card-form" aria-label="Payment Info">
                    <legend style="display:none;">Payment Info</legend>

                    <div class="wc-authorize-net-cim-credit-card-new-payment-method-form js-wc-authorize-net-cim-credit-card-new-payment-method-form flex-row">
                        <p class="form-row form-row-wide validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-account-number_field" data-priority="">
                            <label for="wc-authorize-net-cim-credit-card-account-number" class="">Card Number&nbsp;<abbr class="required" title="required">*</abbr></label>
                            <span class="woocommerce-input-wrapper">
                                <input type="tel" class="js-sv-wc-payment-gateway-credit-card-form-account-number" name="wc-authorize-net-cim-credit-card-account-number" id="wc-authorize-net-cim-credit-card-account-number" placeholder="**** **** **** ****" value="" autocomplete="cc-number" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="16"></span>
                        </p>
                        <p class="form-row form-row-first validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-expiry_year_field" data-priority="">
                            <label for="wc-authorize-net-cim-credit-card-expiry-month" class="">Expiration Month&nbsp;<abbr class="required" title="required">*</abbr></label>
                            <select id="wc-authorize-net-cim-credit-card-expiry-month" name="wc-authorize-net-cim-credit-card-expiry-month">
                                <option value=''>--Select Month--</option>
                                <option value='01'>Janaury</option>
                                <option value='02'>February</option>
                                <option value='03'>March</option>
                                <option value='04'>April</option>
                                <option value='05'>May</option>
                                <option value='06'>June</option>
                                <option value='07'>July</option>
                                <option value='08'>August</option>
                                <option value='09'>September</option>
                                <option value='10'>October</option>
                                <option value='11'>November</option>
                                <option value='12'>December</option>
                            </select>
                        </p>
                        <p class="form-row form-row-last col-sm-6  validate-required">
                            <label for="wc-authorize-net-cim-credit-card-expiry-" class="">Expiration Year(YYYY)&nbsp;<abbr class="required" title="required">*</abbr></label>
                            <span class="woocommerce-input-wrapper"><input type="tel" class="input-text" name="wc-authorize-net-cim-credit-card-expiry-year" id="wc-authorize-net-cim-credit-card-expiry-year" placeholder="YYYY" value="" autocomplete="cc-exp" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span>
                        </p>
                        <p class="form-row form-row-first col-sm-6  validate-required">
                            <label for="wc-authorize-net-cim-credit-card-csc" class="">Card Security Code&nbsp;<abbr class="required" title="required">*</abbr></label>
                            <span class="woocommerce-input-wrapper">
                                <input type="tel" class="input-text js-sv-wc-payment-gateway-credit-card-form-input js-sv-wc-payment-gateway-credit-card-form-csc" name="wc-authorize-net-cim-credit-card-csc" id="wc-authorize-net-cim-credit-card-csc" placeholder="CSC" value="" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span>
                        </p>
                    </div><!-- ./new-payment-method-form-div -->
                </fieldset>
            </div>
            <div class="woocommerce-address-fields__field-wrapper al-order2">
                <h1 class="titleSecShipping mb-3 mt-4">Billing Address</h1>
                <?php
                foreach ($address as $key => $field) {
                    if ($key == 'billing_email') {
                        $field['class'][] = 'hidden';
                    }
                    woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                }
                ?>
            </div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="6LcpUbIeAAAAAHVNlO9ov2TS2gPdNn0mEQ90YZ3i"></div>
            <div class="form-row al-order3">
                <button type="button" class="" id="create_payment_profile_mbt" value="Add payment method">Save payment & Billing method</button>
                <input type="hidden" name="customer_user_mbt" id="customer_user_mbt" value="<?php echo $current_user_id; ?>" />
        
                <input type="hidden" name="action" value="addCustomerPaymentProfile" />
            </div>
            <div id="responsePaymentMethod"></div>
        </div>
    </form>
<?php
    die;
}
?>