<?php

/**
 * Register Custom Taxonomy for Suppliers.
 */
function njengah_custom_taxonomy_Item()
{
    $labels =  array(
        'name' => _x('Suppliers', 'taxonomy general name'),
        'singular_name' => _x('Supplier', 'taxonomy singular name'),
        'search_items' =>  __('Search Suppliers'),
        'all_items' => __('All Suppliers'),
        'parent_item' => __('Parent Supplier'),
        'parent_item_colon' => __('Parent Supplier:'),
        'edit_item' => __('Edit Supplier'),
        'update_item' => __('Update Supplier'),
        'add_new_item' => __('Add New Supplier'),
        'new_item_name' => __('New Supplier Name'),
        'menu_name' => __('Suppliers'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy('supplier', 'product', $args);
}
add_action('init', 'njengah_custom_taxonomy_item', 0);
/**
 * Add custom class to the admin body for a specific page.
 *
 * @param string $classes Existing body classes.
 * @return string Modified body classes.
 */
function sbr_ims_admin_classes($classes)
{
    if (isset($_GET['page']) &&  $_GET['page'] == 'sbr_ims') {
        $classes .= ' toplevel_page_sbr_ims ';
    }
    return $classes;
}
add_filter('admin_body_class', 'sbr_ims_admin_classes');
/**
 * Initialize Advanced Custom Fields options page.
 */
add_action('acf/init', 'ims_acf_op_init');
function ims_acf_op_init()
{
    // Check function exists.
    if (function_exists('acf_add_options_sub_page')) {

        acf_add_options_sub_page(array(
            'page_title'  => __('SETTINGS'),
            'menu_title'  => __('SETTINGS'),
            'parent_slug' => 'sbr_ims',
            'menu_slug' => 'sbr_ims-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        ));
    }
}


add_filter('wp_ajax_updateIMSInfo', 'updateIMSInfo_callback');
add_filter('wp_ajax_save_ims_status', 'save_ims_status_callback');
add_filter('wp_ajax_sbr_productIMS', 'sbr_productIMS_callback');
add_filter('wp_ajax_sbr_po_popup', 'sbr_po_popup_callback');
add_filter('wp_ajax_addPoOrder', 'addPoOrder_callback');
add_filter('wp_ajax_checkInPoOrder', 'checkInPoOrder_callback');
add_filter('wp_ajax_sbr_POproducts', 'sbr_POproducts_callback');
/**
 * Callback function for AJAX request to fetch products based on the selected supplier.
 */
function sbr_POproducts_callback()
{
    if (isset($_REQUEST['suppiler_id']) && $_REQUEST['suppiler_id'] == '') {
?><tr class="error">
            <td colspan="5">Please select suppiler.</td>
        </tr>
        <?php

    } else {
        $tax_query = array(
            'relation' => 'AND',
        );
        $tax_query[] = array(
            'taxonomy' => 'supplier',
            'field' => 'term_id',
            'terms' => $_REQUEST['suppiler_id'],
        );
        $tax_query[] = array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => 'simple',
        );
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => $tax_query,

        );
        $products = get_posts($args);
        if (count($products) > 0) {
        ?>
            <tr class="entryProduct">
                <td class="product_title">
                    <select name="product[]" class="productForPO form-control">
                        <?php
                        echo '<option value="" leadTime="0" stock="0">Select Product</option>';
                        foreach ($products as  $product_id) {
                            $currentStock = get_post_meta($product_id, '_stock', true);
                            $lead_time = get_post_meta($product_id, 'lead_time', true);
                            echo '<option value="' . $product_id . '" leadTime="' . $lead_time . '" stock="' . $currentStock . '">' . get_the_title($product_id) . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td class="lead_time">0</td>
                <td class="stock">0</td>
                <td class="order_qty"><input class="form-control" type="number" placeholder="Qty" name="order_qty[]"></td>
                <td class="close_row"><a href="javascript:;" class="removeRow"><span class="remove">X</span></a></td>
            </tr>
        <?php
        } else {
        ?>
            <tr class="error">
                <td colspan="5">No product found against selected suppiler.
                </td>
            </tr>
    <?php
        }
    }
    die;
}
/**
 * Callback function for AJAX request to update product information in the IMS.
 */
function updateIMSInfo_callback()
{

    $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : 0;
    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0;
    if ($product_id) {
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'stock') {
            global $wpdb;
            $backorder  = isset($_REQUEST['backorder']) ? $_REQUEST['backorder'] : 'no';
            $currentStock = get_post_meta($product_id, '_stock', true);
            if ($value == $currentStock) {
                update_post_meta($product_id, '_backorders', $backorder);
            } else {
                $received_qty = preg_replace("/[^0-9]/", "", $value);
                $data = array(
                    "received_date" => date("Y-m-d h:i:s"),
                    "note" => isset($_REQUEST['note']) ? $_REQUEST['note'] : '',
                    'created_by' => get_current_user_id(),
                    "add_in_stock" => 0,
                    "order_id" => 0,
                    "received_qty" => $value,
                    "old_stock" => $currentStock,
                    "change_stock" => (int)$received_qty - (int)$currentStock,
                    "product_id" => $product_id,

                );
                $wpdb->insert(SB_PO_LOG, $data);
                wc_update_product_stock($product_id, $received_qty, 'set', false);
            }
        } else  if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'supplier') {

            $suppliers = get_terms(array(
                'taxonomy' => 'supplier',
                'hide_empty' => false,
            ));

            if (count($suppliers) > 0) {
                foreach ($suppliers as  $supplier_id) {
                    wp_remove_object_terms($product_id, $supplier_id, 'supplier');
                }
            }
            if (count($value) > 0) {
                wp_set_post_terms($product_id, $value, 'supplier');
            }
        } else  if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'cog') {
            $productObj = wc_get_product($product_id);
            $productObj->update_meta_data('_wc_cog_cost', $value);
            $productObj->save(); // Save to database and sync
        } else {
            $productObj = wc_get_product($product_id);
            $productObj->update_meta_data('lead_time', $value);
            $productObj->save(); // Save to database and sync
        }
    }
    echo 'Updated';
    die;
}
/**
 * Callback function for AJAX request to check-in products from a purchase order.
 */
function checkInPoOrder_callback()
{
    global $wpdb;
    $error = array();
    $po_number = 0;
    $data = array(
        "received_date" => date("Y-m-d h:i:s"),
        "note" => isset($_REQUEST['note']) ? $_REQUEST['note'] : '',
        'created_by' => get_current_user_id(),
        "add_in_stock" => isset($_REQUEST['addInStock']) ? 1 : 0,

    );
    // $data = array();
    if (!isset($_REQUEST['product_id']) || $_REQUEST['product_id'] == '') {
        $error[] = 'Product missing.';
    } else {
        $data['product_id'] = $_REQUEST['product_id'];
    }
    if (!isset($_REQUEST['order_id']) || $_REQUEST['order_id'] == '') {
        $error[] = 'Order ID missing.';
    } else {
        $data['order_id'] = $_REQUEST['order_id'];
    }
    if (!isset($_REQUEST['qty']) || $_REQUEST['qty'] == '' || $_REQUEST['qty'] < 0) {
        $error[] = 'Received Qty missing.';
    } else {
        $data['received_qty'] = $_REQUEST['qty'];
        $poQtyQuery = "SELECT  po_qty  ,  po_number FROM  " . SB_PO .  " as PO  JOIN " . SB_PP . " as PP ON PO.order_id=PP.order_id WHERE PP.product_id = " . $data['product_id'] . " AND  PO.order_id = " . $data['order_id'] . " ORDER BY PO.order_id DESC";
        //$poQtyQuery = "SELECT  po_qty  ,  product_id FROM  " . SB_PO .  " WHERE order_id = " . $data['order_id'];
        $poData = $wpdb->get_row($poQtyQuery, 'ARRAY_A');
        // echo '<pre>';
        // print_r($poData);
        // echo '</pre>';
        // die;
        $poQty = $poData['po_qty'];
        $po_number = $poData['po_number'];
        $flag = false;
        if ($poQty >= $data['received_qty']) {
            $query2 = "SELECT  SUM(received_qty) as total  FROM " . SB_PO_LOG;
            // $query2 .= " WHERE order_id = " . $data['order_id'];
            $query2 .= " WHERE order_id = " . $data['order_id'] . " AND product_id = " . $data['product_id'];
            $checkAvailablibilty = $wpdb->get_var($query2);
            if ($checkAvailablibilty != '' && $poQty >= ($checkAvailablibilty + $data['received_qty'])) {
                $flag = true;
            } else if ($checkAvailablibilty == '') {
                $flag = true;
            } else {
                $error[] = 'Received qty should be less then ordered qty.';
            }
        } else {
            $error[] = 'Received qty should be less then ordered qty.';
        }
    }
    $html = '';
    if (count($error) > 0) {
        $html .= '<ul class="error notice">';
        foreach ($error as $e) {
            $html .= '<li>' . $e . '</li>';
        }
        $html .= '</ul>';
    } else {
        $currentStock = get_post_meta($data['product_id'], '_stock', true);
        $data['old_stock'] =  $currentStock;
        if ($data['add_in_stock']) {
            $data['change_stock'] =  $data['received_qty'];
        } else {
            $data['change_stock'] =  0;
        }
        $wpdb->insert(SB_PO_LOG, $data);
        if ($wpdb->insert_id) {
            if ($data['add_in_stock']) {
                $received_qty = preg_replace("/[^0-9]/", "", $data['received_qty']);
                wc_update_product_stock($data['product_id'], $received_qty, 'increase', false);
                // wc_update_product_stock($data['product_id'], $data['received_qty'], 'increase', false);
            }
            $html = '<div class="notice notice-success"><p>#' . P_O . $po_number . ' checked-in successfully. </p></div>';
            $html .= '<style>#checkInInventoryOrder , .orderHistorySection{ display:none !important }</style>';
            //addInventoryOrder
        } else {
            $html .= '<ul class="error notice db">';
            $html .= '<li>' . $wpdb->show_errors . '</li>';
            $html .= '</ul>';
        }
    }
    echo $html;
    die;
}

/**
 * Callback function for AJAX request to add a new purchase order.
 */
function addPoOrder_callback()
{

    $error = array();
    $productData = array();
    $data = array(
        "po_order_date" => date("Y-m-d h:i:s"),
        "note" => isset($_REQUEST['note']) ? $_REQUEST['note'] : '',
        'created_by' => get_current_user_id(),
    );
    if (!isset($_REQUEST['product']) || count($_REQUEST['product']) < 1) {
        $error['product'] = 'Product missing.';
    } else {
        $products = $_REQUEST['product'];
        foreach ($products as $key => $product_id) {
            if ($product_id > 0) {
                $lead_time = get_post_meta($product_id, 'lead_time', true);
                if ($lead_time == '') {
                    $lead_time = 60;
                }
                $productData[$product_id]['product_id'] = $product_id;
                $productData[$product_id]['po_estimated_received_date'] = date("Y-m-d h:i:s",  strtotime('+' . $lead_time . ' days'));
            } else {
                $error['product'] = 'Product missing.';
            }
            if (!isset($_REQUEST['order_qty']) || count($_REQUEST['order_qty']) < 1) {
                $error['qty'] = 'PO Qty missing.';
            } else {
                if ($_REQUEST['order_qty'][$key] > 0) {
                    $productData[$product_id]['po_qty'] = $_REQUEST['order_qty'][$key];
                } else {
                    $error['qty'] = 'PO Qty missing.';
                }
            }
        }
    }
    if (!isset($_REQUEST['suppiler_id']) || $_REQUEST['suppiler_id'] == '') {
        $error['supplier'] = 'Suppiler missing.';
    } else {
        $data['supplier_id'] = $_REQUEST['suppiler_id'];
    }

    // echo '<pre>';
    // print_r($productData);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($error);
    // echo '</pre>';
    // die;
    $html = '';
    if (count($error) > 0) {
        $html .= '<ul class="error notice">';
        foreach ($error as $e) {
            $html .= '<li>' . $e . '</li>';
        }
        $html .= '</ul>';
    } else {
        global $wpdb;
        $q_po_number = "SELECT  po_number FROM  " . SB_PO .  "  ORDER BY order_id DESC LIMIT 1";
        $po_number = $wpdb->get_var($q_po_number);
        if (empty($po_number)) {
            $po_number = 10001;
        } else {
            $po_number = $po_number + 1;
        }
        $data['po_number'] = $po_number;
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $wpdb->insert(SB_PO, $data);
        if ($wpdb->insert_id) {
            $order_id = $wpdb->insert_id;
            foreach ($productData as $key => $pd) {
                $pd['order_id'] = $order_id;
                $wpdb->insert(SB_PP, $pd);
            }
            $html = '<div class="notice notice-success"><p>Request #' . P_O . $po_number . ' Generated. </p></div>';
            $html .= '<style>#addInventoryOrder{ display:none !important }</style>';
        } else {
            $html .= '<ul class="error notice db">';
            $html .= '<li>' . $wpdb->show_errors . '</li>';
            $html .= '</ul>';
        }
    }
    echo $html;
    die;
}
/**
 * Callback function for handling AJAX requests related to purchase orders and inventory management.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function sbr_po_popup_callback()
{
    global $wpdb;
    $product_id = $_REQUEST['product_id'];
    $level = isset($_REQUEST['level']) ? $_REQUEST['level'] : 1;
    $currentStock = get_post_meta($product_id, '_stock', true);
    $lead_time = get_post_meta($product_id, 'lead_time', true);

    if (in_array($level, array(2, 3))) {
        $query = "SELECT  * FROM  " . SB_PO .  " as PO  JOIN " . SB_PP . " as PP ON PO.order_id=PP.order_id WHERE PP.product_id = " . $product_id . " ORDER BY PO.order_id DESC";
        $poOrders = $wpdb->get_results($query, 'ARRAY_A');
    }

    // echo '<pre>';
    // print_r($poOrders);
    // echo '</pre>';
    $checkInPoOrders = array();
    ?>

    <?php if ($level == 3) : ?>
        <div class="productPoInfo">
            <div class="productPoInfo1">
                <h2>Product Name: <?php echo  get_the_title($product_id); ?></h2>
            </div>
            <div class="productPoInfo2">
                <h2>Available Stock: <?php echo  (int)$currentStock; ?> Items</h2>
                <h2>Lead Time: <?php echo  $lead_time; ?> Days</h2>
            </div>
        </div>
        <div class="orderHistorySection">
            <h3>Order History</h3>
            <table id="orderHistory" class="data-table" style="width:99%">
                <thead>
                    <tr>
                        <th>PO#</th>
                        <th>Supplier</th>
                        <th>Order Qty</th>
                        <th>Balance Qty</th>
                        <th>Estimated Date</th>
                        <th>Ordered Date</th>
                        <th>PO Note</th>
                        <th>Order By</th>
                        <th>History</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($poOrders) {

                        foreach ($poOrders as  $po) {
                            $queryb = "SELECT  SUM(received_qty) as total  FROM " . SB_PO_LOG;
                            $queryb .= " WHERE order_id = " . $po['order_id'] . " AND product_id = " . $product_id;
                            $received_qty = $wpdb->get_var($queryb);
                            $balance =  $po['po_qty'];
                            if ($received_qty) {
                                $balance =  (int) $po['po_qty'] - (int) $received_qty;
                            }
                            $supplier_name = get_term($po['supplier_id'])->name;
                            $query2 = "SELECT  *   FROM " . SB_PO_LOG;
                            $query2 .= " WHERE order_id = " . $po['order_id'] . " AND product_id = " . $product_id;
                            $logs = $wpdb->get_results($query2, 'ARRAY_A');
                            $user = get_user_by('id',  $po['created_by']);

                    ?>
                            <tr>
                                <td><?php echo P_O . $po['po_number']; ?></td>
                                <td><?php echo $supplier_name; ?></td>
                                <td><?php echo $po['po_qty']; ?></td>
                                <td><?php echo $balance; ?></td>
                                <td><?php echo sbr_date($po['po_estimated_received_date']); ?></td>
                                <td><?php echo sbr_datetime($po['po_order_date']); ?></td>
                                <td><?php echo $po['note']; ?></td>
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                <td>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Rc. Qty</th>
                                                <th>Rc. Date</th>
                                                <th>Note</th>
                                                <th>Add in stock</th>
                                                <th>Rc. By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($logs) > 0) {
                                                foreach ($logs as  $log) {
                                                    $added = 'No';
                                                    if ($log['add_in_stock']) {
                                                        $added = 'Yes';
                                                    }
                                                    $user = get_user_by('id',  $po['created_by']);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $log['received_qty']; ?></td>
                                                        <td><?php echo sbr_datetime($log['received_date']); ?></td>
                                                        <td><?php echo $log['note']; ?></td>
                                                        <td><?php echo $added; ?></td>
                                                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="noRecord">No record found.</td></tr>';
                                            } ?>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="9" class="noRecord">No order found.</td></tr>';
                    }

                    ?>
                </tbody>

            </table>
        </div>
    <?php endif; ?>
    <?php if ($level == 4) : ?>
        <div class="productPoInfo">
            <div class="productPoInfo1">
                <h2>Product Name: <?php echo  get_the_title($product_id); ?></h2>
            </div>
            <div class="productPoInfo2">
                <h2>Available Stock: <?php echo  (int)$currentStock; ?> Items</h2>
                <h2>Lead Time: <?php echo  $lead_time; ?> Days</h2>
            </div>
        </div>
        <div class="orderHistorySection">
            <h3>Stock History</h3>
            <table id="orderHistory" class="data-table" style="width:99%">
                <thead>
                    <tr>
                        <th colspan="2">Rec.</th>
                        <th colspan="3">Qty</th>
                        <th>Note</th>
                        <th colspan="3">PO History</th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>By</th>

                        <th>Old</th>
                        <th>Change</th>
                        <th>New</th>

                        <th></th>

                        <th>PO#</th>
                        <th>Supplier</th>
                        <th>Ordered Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryb = "SELECT * FROM " . SB_PO_LOG . " WHERE  product_id = " . $product_id;
                    $poOrderLogs = $wpdb->get_results($queryb, 'ARRAY_A');
                    foreach ($poOrderLogs as $entry) {

                        $user = get_user_by('id',  $entry['created_by']);
                        echo '<tr>';
                        echo '<td>' . sbr_datetime($entry['received_date']) . '</td>';
                        echo '<td>' . $user->first_name . ' ' . $user->last_name . '</td>';

                        echo '<td>' . $entry['old_stock'] . '</td>';
                        echo '<td>' . $entry['change_stock'] . '</td>';

                        if ($entry['order_id']) {
                            if ($entry['change_stock'] == 0) {
                                echo '<td>' . $entry['old_stock'] . '</td>';
                            } else {
                                echo '<td>' . ($entry['received_qty'] +  $entry['old_stock']) . '</td>';
                            }
                        } else {
                            echo '<td>' . $entry['received_qty'] . '</td>';
                        }
                        echo '<td>' . $entry['note'] . '</td>';
                        if ($entry['order_id']) {
                            $query = "SELECT  * FROM  " . SB_PO .  "  WHERE order_id = " . $entry['order_id'];
                            $po = $wpdb->get_row($query, 'ARRAY_A');
                            $supplier_name = get_term($po['supplier_id'])->name;
                            echo '<td>' . P_O . $po['po_number'] . '</td>';
                            echo '<td>' . $supplier_name . '</td>';
                            echo '<td>' . sbr_datetime($po['po_order_date']) . '</td>';
                        } else {
                            echo '<td colspan="3">N/A</td>';
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
    <?php endif; ?>
    <div class="manageOrderSection">
        <?php if ($level == 2) :
        ?>
            <div class="productPoInfo">
                <div class="productPoInfo1">
                    <h2>Product Name: <?php echo  get_the_title($product_id); ?></h2>
                </div>
                <div class="productPoInfo2">
                    <h2>Available Stock: <?php echo  (int)$currentStock; ?> Items</h2>
                    <h2>Lead Time: <?php echo  $lead_time; ?> Days</h2>
                </div>
            </div>
            <?php
            if ($poOrders) {
                $dataSBPO = array();
                foreach ($poOrders as  $po) {
                    $queryb = "SELECT  SUM(received_qty) as total  FROM " . SB_PO_LOG;
                    // $queryb .= " WHERE order_id = " . $po['order_id'];
                    $queryb .= " WHERE order_id = " . $po['order_id'] . " AND product_id = " . $product_id;
                    $received_qty = $wpdb->get_var($queryb);
                    $balance =  $po['po_qty'];
                    if ($received_qty) {
                        $balance =  (int) $po['po_qty'] - (int) $received_qty;
                    }
                    if ($balance > 0) {
                        $dataSBPO[$po['order_id']] = array(
                            'po_number' => $po['po_number'],
                            'supplier_id' => $po['supplier_id'],
                            'order_id' => $po['order_id'],
                            'po_qty' => $po['po_qty'],
                            'balance' => $balance,
                        );
                        $checkInPoOrders[$po['order_id']] = $po['po_number'];
                    }
                }
            }
            ?>
            <div class="orderHistorySection">
                <h3>Order History</h3>
                <table id="orderHistory" class="data-table" style="width:99%">
                    <thead>
                        <tr>
                            <th>PO#</th>
                            <th>Supplier</th>
                            <th>Order Qty</th>
                            <th>Balance Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($dataSBPO) {
                            foreach ($dataSBPO as  $po) {
                                $supplier_name = get_term($po['supplier_id'])->name;
                        ?>
                                <tr>
                                    <td><?php echo P_O . $po['po_number']; ?></td>
                                    <td><?php echo $supplier_name; ?></td>
                                    <td><?php echo $po['po_qty']; ?></td>
                                    <td><?php echo $po['balance']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="9" class="noRecord">No order found.</td></tr>';
                        }

                        ?>
                    </tbody>

                </table>
            </div>
            <div class="checkInventoryOrder">
                <h3>Check-In Inventory</h3>
                <?php

                if (count($checkInPoOrders) > 0) {
                ?>
                    <div id="checkInInventoryOrderResponse"></div>
                    <form id="checkInInventoryOrder">
                        <div class="flex-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>PO Number
                                        <select class="form-control" name="order_id" autocomplete="off">
                                            <?php foreach ($checkInPoOrders as $order_id => $po_number) {
                                                echo '<option value="' . $order_id . '">' . P_O . $po_number . '</option>';
                                            } ?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Received Qty
                                        <input class="form-control" type="number" name="qty" placeholder="Qty">
                                    </label>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Note
                                        <textarea class="form-control" name="note"></textarea>
                                    </label>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="addInStockPO">
                                        <input class="form-control" type="checkbox" value="yes" name="addInStock" checked="" /> Add in Stock
                                    </label>

                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="action" value="checkInPoOrder">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="buttons-custom-added wrap">
                            <a href="javascript:;" id="receivedInventoryPO" product_id="<?php echo $product_id; ?>" class="page-title-action">Add</a>
                        </div>
                    </form>
                <?php
                } else {
                    echo 'No active order available.';
                }
                ?>

            </div>
        <?php endif; ?>
        <?php if ($level == 1) : ?>
            <div class="createInventoryOrder">
                <h3>Create Inventory Order</h3>
                <div id="createInventoryOrderResponse"></div>
                <form id="addInventoryOrder">
                    <div class="flex-row">
                        <div class="col-sm-12">

                            <?php
                            $supplierList = get_terms('supplier', array(
                                'hide_empty' => false,
                            ));
                            $supplierHtml = '';
                            //$supplierList = wp_get_object_terms($product_id, 'supplier');
                            if (!empty($supplierList)) :
                                $supplierHtml .= ' <label>Suppiler<select  class="form-control" name="suppiler_id" id="create_po_suppiler_id" autocomplete="off">';
                                $supplierHtml .= '<option value="">-</option>';
                                foreach ($supplierList as $supplier) :
                                    $supplierHtml .= '<option value="' . $supplier->term_id . '">' . $supplier->name . '</option>';
                                endforeach;
                                $supplierHtml .= '</select></label>';
                            else :
                                $supplierHtml .= 'No supplier found.';
                            endif;

                            ?>

                            <div class="form-group">
                                <?php echo $supplierHtml; ?>
                            </div>
                        </div>
                    </div>
                    <table class="widefat" id="addon-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Lead Time</th>
                                <th>Current Stock</th>
                                <th>Order Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="poProducts">

                        </tbody>
                    </table>
                    <div class="flex-row add-buttonss showAddMorePOP">
                        <div class="col-sm-12">
                            <button onclick="addPoProduct()" class="button" type="button">Add Product</button>

                        </div>
                    </div>

                    <div class="note-wrapper showAddMorePOP">
                        <div class="flex-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Order Note
                                        <textarea class="form-control" name="note"></textarea>
                                    </label>

                                </div>
                            </div>
                            <div class="buttons-custom-added wrap col-sm-12">
                                <a href="javascript:;" id="createInventoryPO" class="page-title-action">Create Order</a>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="action" value="addPoOrder">
                </form>
            </div>
        <?php endif; ?>
    </div>

<?php
    die;
}


/**
 * Callback function for handling AJAX requests related to purchase orders and inventory management backup.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 */
function sbr_po_popup_callback_bk()
{
    global $wpdb;
    $product_id = $_REQUEST['product_id'];
    $level = $_REQUEST['level'];
    $currentStock = get_post_meta($product_id, '_stock', true);
    $lead_time = get_post_meta($product_id, 'lead_time', true);

    $query = "SELECT  * FROM  " . SB_PO .  " WHERE product_id = " . $product_id . " ORDER BY order_id DESC";
    $poOrders = $wpdb->get_results($query, 'ARRAY_A');
    $checkInPoOrders = array();
?>
    <div class="productPoInfo">
        <div class="productPoInfo1">
            <h2>Product Name: <?php echo  get_the_title($product_id); ?></h2>
        </div>
        <div class="productPoInfo2">
            <h2>Available Stock: <?php echo  (int)$currentStock; ?> Items</h2>
            <h2>Lead Time: <?php echo  $lead_time; ?> Days</h2>
        </div>
    </div>
    <script>
        po_productsHtml = '';
    </script>
    <?php if ($level == 3) : ?>
        <div class="orderHistorySection">
            <h3>Order History</h3>
            <table id="orderHistory" class="data-table" style="width:99%">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Supplier</th>
                        <th>Order Qty</th>
                        <th>Balance Qty</th>
                        <th>Estimated Date</th>
                        <th>Ordered Date</th>
                        <th>PO Note</th>
                        <th>Order By</th>
                        <th>History</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($poOrders) {
                        foreach ($poOrders as  $po) {
                            $queryb = "SELECT  SUM(received_qty) as total  FROM " . SB_PO_LOG;
                            $queryb .= " WHERE order_id = " . $po['order_id'];
                            $received_qty = $wpdb->get_var($queryb);
                            $balance =  $po['po_qty'];
                            if ($received_qty) {
                                $balance =  (int) $po['po_qty'] - (int) $received_qty;
                            }
                            if ($balance > 0) {
                                $checkInPoOrders[$po['order_id']] = $po['order_id'];
                            }

                            $supplier_name = get_term($po['supplier_id'])->name;
                            $query2 = "SELECT  *   FROM " . SB_PO_LOG;
                            $query2 .= " WHERE order_id = " . $po['order_id'];
                            $logs = $wpdb->get_results($query2, 'ARRAY_A');
                            $user = get_user_by('id',  $po['created_by']);

                    ?>
                            <tr>
                                <td><?php echo $po['order_id']; ?></td>
                                <td><?php echo $supplier_name; ?></td>
                                <td><?php echo $po['po_qty']; ?></td>
                                <td><?php echo $balance; ?></td>
                                <td><?php echo sbr_date($po['po_estimated_received_date']); ?></td>
                                <td><?php echo sbr_datetime($po['po_order_date']); ?></td>
                                <td><?php echo $po['note']; ?></td>
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                <td>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Rc. Qty</th>
                                                <th>Rc. Date</th>
                                                <th>Note</th>
                                                <th>Add in stock</th>
                                                <th>Rc. By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($logs) > 0) {
                                                foreach ($logs as  $log) {
                                                    $added = 'No';
                                                    if ($log['add_in_stock']) {
                                                        $added = 'Yes';
                                                    }
                                                    $user = get_user_by('id',  $po['created_by']);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $log['received_qty']; ?></td>
                                                        <td><?php echo sbr_date($log['received_date']); ?></td>
                                                        <td><?php echo $log['note']; ?></td>
                                                        <td><?php echo $added; ?></td>
                                                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="5">No record found.</td></tr>';
                                            } ?>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="9">No order found.</td></tr>';
                    }

                    ?>
                </tbody>

            </table>
        </div>
    <?php endif; ?>
    <div class="manageOrderSection">
        <?php if ($level == 2) :
            if ($poOrders) {
                foreach ($poOrders as  $po) {
                    $queryb = "SELECT  SUM(received_qty) as total  FROM " . SB_PO_LOG;
                    $queryb .= " WHERE order_id = " . $po['order_id'];
                    $received_qty = $wpdb->get_var($queryb);
                    $balance =  $po['po_qty'];
                    if ($received_qty) {
                        $balance =  (int) $po['po_qty'] - (int) $received_qty;
                    }
                    if ($balance > 0) {
                        $checkInPoOrders[$po['order_id']] = $po['order_id'];
                    }
                }
            }
        ?>
            <div class="checkInventoryOrder">
                <h3>Check-In Inventory</h3>

                <?php
                if (count($checkInPoOrders) > 0) {
                ?>
                    <div id="checkInInventoryOrderResponse"></div>
                    <form id="checkInInventoryOrder">
                        <div class="flex-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Order ID
                                        <select class="form-control" name="order_id" autocomplete="off">
                                            <?php foreach ($checkInPoOrders as  $order_id) {
                                                echo '<option value="' . $order_id . '">' . $order_id . '</option>';
                                            } ?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Received Qty
                                        <input class="form-control" type="number" name="qty" placeholder="Qty">
                                    </label>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Note
                                        <textarea class="form-control" name="note"></textarea>
                                    </label>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="addInStockPO">
                                        <input class="form-control" type="checkbox" value="yes" name="addInStock" checked="" /> Add in Stock
                                    </label>

                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="action" value="checkInPoOrder">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="buttons-custom-added wrap">
                            <a href="javascript:;" id="receivedInventoryPO" product_id="<?php echo $product_id; ?>" class="page-title-action">Add</a>
                        </div>
                    </form>
                <?php
                } else {
                    echo 'No active order available.';
                }
                ?>

            </div>
        <?php endif; ?>
        <?php if ($level == 1) : ?>
            <div class="createInventoryOrder">
                <h3>Create Inventory Order</h3>
                <div id="createInventoryOrderResponse"></div>
                <form id="addInventoryOrder">
                    <div class="flex-row">
                        <div class="col-sm-6">

                            <?php
                            $supplierHtml = '';
                            $supplierList = wp_get_object_terms($product_id, 'supplier');
                            if (!empty($supplierList)) :
                                $supplierHtml .= ' <label>Suppiler<select class="form-control" name="suppiler_id" autocomplete="off">';
                                foreach ($supplierList as $supplier) :
                                    $supplierHtml .= '<option value="' . $supplier->term_id . '">' . $supplier->name . '</option>';
                                endforeach;
                                $supplierHtml .= '</select></label>';
                            else :
                                $supplierHtml .= 'No supplier found.';
                            endif;

                            ?>

                            <div class="form-group">
                                <?php echo $supplierHtml; ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Order Qty
                                    <input class="form-control" type="number" placeholder="Qty" name="order_qty">
                                </label>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Order Note
                                    <textarea class="form-control" name="note"></textarea>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="buttons-custom-added wrap">
                        <a href="javascript:;" id="createInventoryPO" product_id="<?php echo $product_id; ?>" class="page-title-action">Create Order</a>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="action" value="addPoOrder">

                </form>
            </div>
        <?php endif; ?>

    </div>

<?php
    die;
}
/**
 * Sends email notifications for products that have reached or are approaching inventory alert levels.
 *
 * Retrieves sold inventory data for the past month and evaluates alert levels based on consumption rates.
 * Sends email notifications for products in Level 1 or Level 2 alert levels.
 *
 * @global string $first_level_alert  First-level alert threshold (days).
 * @global string $second_level_alert Second-level alert threshold (days).
 *
 * @return void Sends email notifications for products in alert levels.
 */
function alertLevelEmailNotification()
{
    $order_start_date =  date("Y-m-d", strtotime("-1 month"));
    $order_end_date =  date("Y-m-d", strtotime("-1 day"));
    /*Search Data */
    $searchData =  sbr_getSoldInventory($order_start_date, $order_end_date);
    $rawPrdoucts = $searchData['rawPrdoucts'];
    $orderQty = $searchData['orderQty'];


    $date1 = new DateTime($order_start_date);
    $date2 = new DateTime($order_end_date);
    $interval = $date1->diff($date2);
    $filterDayInterval = $interval->days;

    $modified_data = array();
    $first_level_alert = get_field('first_level_alert', 'option');
    $second_level_alert = get_field('second_level_alert', 'option');
    foreach ($rawPrdoucts as $key => $product_id) {


        $currentStock = (int) get_post_meta($product_id, '_stock', true);
        $lead_time = get_post_meta($product_id, 'lead_time', true);
        $title = '<a href="' . get_edit_post_link($product_id) . '" target="_blank">' . get_the_title($product_id) . '</a>';
        $title =  get_the_title($product_id);
        $consumptionRate  = 0;
        if (isset($orderQty[$product_id])) {
            $consumptionRate  = $orderQty[$product_id]['qty'] / $filterDayInterval;
            $consumptionRate = number_format((float)$consumptionRate, 2, '.', '');
        }
        if ($consumptionRate > 0) {
            $daysOfInventoryRemaining  = round($currentStock / $consumptionRate);
        } else {
            $daysOfInventoryRemaining = $currentStock;
        }
        $dayUntilOutOfStock  = round($daysOfInventoryRemaining - (int)$lead_time);

        $entry = array();
        $entry[] =  $title;
        /*
        $entry[] = $currentStock;

        if (is_infinite($consumptionRate)) {
            $entry[] = 0;
        } else {
            $entry[] = $consumptionRate;
        }

        if (is_infinite($daysOfInventoryRemaining)) {
            $entry[] = 0;
        } else {
            $entry[] = $daysOfInventoryRemaining;
        }

        if (is_infinite($dayUntilOutOfStock)) {
            $entry[] = 0;
        } else {
            $entry[] = $dayUntilOutOfStock;
        }

        $entry[] = $lead_time;
        */
        $lvl = 0;
        if ($consumptionRate == 0) {
        } else {
            if ($dayUntilOutOfStock <= $first_level_alert) {
                if ($dayUntilOutOfStock <= $second_level_alert) {
                    $lvl = 'Level 2';
                } else {
                    $lvl = 'Level 1';
                }
            }
        }
        $entry[] = $lvl;
        if ($lvl) {
            $modified_data[] = json_encode($entry);
        }
    }
    // echo '<pre>';
    // print_r($modified_data);
    // echo '</pre>';
}
/**
 * Dashboard page for inventrory Management
 *
 */
function sbr_inventoryManagement()
{


    global $wpdb;
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="ims-parent-body">
        <div class="search-shipement">
            <h3><span class="dashicons dashicons-welcome-widgets-menus"></span>Inventory management</h3>
            <div class="shipment-inner-container">
                <div class="flex-row">
                    <div class="col-sm-12 hr-seprator dateFilterIMS">
                        <h4>Search Date range</h4>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <input type="hidden" id="startDate" value="" autocomplete="off" />
                            <input type="hidden" id="endDate" value="" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-sm-12 hr-seprator productTypeIms">
                        <h4>Product Types</h4>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <br />
                            <label><input type="radio" name="searchProducts" value="all" autocomplete="off" checked="" />All</label>&nbsp;&nbsp;
                            <label><input type="radio" name="searchProducts" value="pm" autocomplete="off" />Packaging Material</label>&nbsp;&nbsp;
                            <label><input type="radio" name="searchProducts" value="np" autocomplete="off" />Normal Products</label>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="buttonGroupMbt">
                            <a href="/wp-admin/edit-tags.php?taxonomy=supplier&post_type=product" class="btn button">Suppliers</a>
                            <a href="/wp-admin/admin.php?page=sbr_ims-settings" class="btn button">Settings</a>
                            <a href="javascript:;" onclick="loadPoLogs()" class="btn button">Create PO</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="loading-sbr" style="display: block;">
            <div class="inner-sbr"></div>
        </div>
        <table id="ims" class="data-table" style="width:99%">
            <thead>
                <tr>

                    <th class="productName">Product name</th>
                    <th>Current Inv.</th>
                    <th>Sold Unit</th>
                    <th class="covsRate">Cons. Rate (units/day)</th>
                    <th>COG</th>
                    <th>Costing (cog*units*days)</th>
                    <th>Days to depletion</th>
                    <th class="daysUntilOrder">Days until order</th>
                    <th class="supplierCol">Supplier</th>
                    <th class="leadTimeHead">Lead Time (days)</th>
                    <th>Open Po Qty</th>
                    <th>Balance Qty</th>
                    <th class="managePO">Manage</th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
    </div>
    <style>
        /* .shipment-inner-container {
                display: none;
            } */

        table.dataTable tbody tr {
            background-color: #fff;
            text-align: center;
        }

        .levelYellow {
            background-color: #fbae053b !important;
            background-color: #ffef82b5 !important;
        }

        .levelRed {
            background-color: #ff000066 !important;
        }

        .ims_edit_icon {
            margin-top: 0px;
            /* display: block;
                position: relative;
                top: -34px;
                margin-left: auto; */
            text-align: right;
            width: 20px;
            background: #ffffff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            z-index: 1;
            justify-content: end;
            /* right: -18px; */
            text-decoration: none;
        }

        .ims_edit_icon::before {
            font-family: Dashicons;
            speak: none;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            margin: 0;
            text-indent: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            content: "\f464";
            position: relative;
            font-size: 18px;
        }
    </style>
    <script type="text/javascript">
        let datatable = '';
        let po_productsHtml = '';
        var start = moment().subtract(29, 'days');
        var end = moment();
        jQuery(document).ready(function() {

            jQuery('body').on('click', '.btnIMSUpdatestatus', function() {

                that = this;
                let product_id = jQuery(this).parents('.ims_inputDiv').find('.save_ims_status').attr('product_id');
                let ims_status = jQuery(this).parents('.ims_inputDiv').find('.save_ims_status option:selected').val();
                console.log(ims_status);
                jQuery.ajax({
                    url: "<?php echo admin_url('admin-ajax.php?action=save_ims_status'); ?>",
                    type: 'POST',
                    // dataType: 'JSON',
                    //  async: true,
                    data: {
                        product_id: product_id,
                        ims_status: ims_status
                    },
                    success: function(response) {
                        if (ims_status == 'sent') {
                            ims_status = 'On Order'
                        }
                        jQuery(that).parents('.imsWapper').find('span').text(ims_status);
                        // jQuery(that).parents('.IMSEditDiv').find('span').text(ims_status).show();
                        // jQuery(that).parents('.IMSEditDiv').find('ims_edit_icon').show();
                        // console.log(response);
                        jQuery(that).parents('.imsWapper').find('.btnIMScancel').click();
                        Swal.fire({
                            icon: 'success',
                            text: 'Status Updated'
                        });
                    }
                });
            });
            datatable = jQuery('#ims').DataTable({
                "ordering": false,
                "searching": true,
                "bPaginate": false,
                "processing": false,
                "serverSide": false,
                "clientSide": true,
                "ajax": {
                    url: "<?php echo admin_url('admin-ajax.php?action=sbr_productIMS'); ?>",
                    type: "GET",
                    "data": function(d) {
                        d.startDate = jQuery(document).find('#startDate').val(),
                            d.endDate = jQuery(document).find('#endDate').val(),
                            d.sc = jQuery(document).find('input[name=searchProducts]:checked').val()

                    },
                    "complete": function(response) {
                        jQuery('.loading-sbr').hide();
                    }

                },
                rowCallback: function(row, data) {
                    //  console.log(data);
                    //  console.log(data[8]);
                    $(row).addClass(data[13]);
                }
            });
            jQuery('body').on('change', 'input[name=searchProducts]', function() {
                jQuery('.loading-sbr').show();
                // alert('clicked');
                datatable.ajax.reload();
            });

            function cb(start, end) {
                $('#startDate').val(start.format('YYYY-MM-DD'));
                $('#endDate').val(end.format('YYYY-MM-DD'));
                reportFilterByDate();
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                minDate: '<?php echo date("m/d/Y", strtotime("-24 month")); ?>',
                maxDate: '<?php echo date("m/d/Y"); ?>',
                ranges: {
                    //     'Today': [moment(), moment()],
                    //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    //'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 60 Days': [moment().subtract(59, 'days'), moment()],
                    'Last 90 Days': [moment().subtract(89, 'days'), moment()],

                    //     'This Month': [moment().startOf('month'), moment().endOf('month')],

                }
            }, cb);

            cb(start, end);
        });
        jQuery('body').on('click', '.btnIMScancel', function() {
            $this = jQuery(this);
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            get_parent.find('span').show();
            get_parent.find('.ims_inputDiv').hide();
            get_parent.find('.ims_edit_icon').show();
        });

        jQuery('body').on('change', '#create_po_suppiler_id', function() {
            // function addPoProduct() {
            $this = jQuery(this);
            jQuery("body").find('#smile_brillaint_order_modal .manageOrderSection').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: 'sbr_POproducts',
                    suppiler_id: $this.val(),

                },
                async: true,
                dataType: 'html',
                method: 'POST',
                success: function(response) {
                    po_productsHtml = response;
                    jQuery("body").find('#smile_brillaint_order_modal #poProducts').html(response);
                    jQuery("body").find('#smile_brillaint_order_modal .manageOrderSection').unblock();
                },
                cache: false,
            });

        });

        jQuery('body').on('change', '.productForPO', function() {
            $event = jQuery(this);
            var lead_time = $event.find('option:selected').attr('leadTime');
            var stock = $event.find('option:selected').attr('stock');
            $event.closest('.entryProduct').find('.lead_time').html(parseInt(lead_time));
            $event.closest('.entryProduct').find('.stock').html(parseInt(stock));
        })

        jQuery('body').on('click', '#poProducts .remove', function() {
            jQuery(this).closest('.entryProduct').remove();
        })

        function addPoProduct() {
            jQuery("body").find('#smile_brillaint_order_modal #poProducts').append(po_productsHtml);
        }

        function loadPoLogs(product_id, level) {
            var lvlclass = 'create';
            if (level == 3 || level == 4) {
                lvlclass = 'history'
            } else if (level == 2) {
                lvlclass = 'check-in'
            }
            jQuery("body").find('#smile_brillaint_order_modal .modal-content').removeClass('ims_manage create history check-in');
            jQuery("body").find('#smile_brillaint_order_modal .modal-content').addClass('ims_manage ' + lvlclass);
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());

            jQuery.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: 'sbr_po_popup',
                    product_id: product_id,
                    level: level
                },
                async: true,
                dataType: 'html',
                method: 'POST',
                beforeSend: function(xhr) {
                    smile_brillaint_order_modal.style.display = "block";
                },
                success: function(response) {
                    // jQuery('#analyzing_impression_form').unblock();
                    jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
                    // reload_order_item_table_mbt(order_id);
                },
                error: function(xhr) {
                    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed. Something went wrong.'));
                },
                cache: false,
                // contentType: false,
                //  processData: false
            });
        }




        jQuery('body').on('click', '.ims_edit_icon', function() {
            $this = jQuery(this);
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            console.log(get_parent)
            get_parent.find('span').hide();
            $this.hide();
            get_parent.find('.ims_inputDiv').show();
            get_parent.find('.btnIMScancel').show();
        });
        jQuery('body').on('click', '.btnIMSUpdate', function() {
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            var imsVal = get_parent.find('.ims-input').val();
            var product_id = get_parent.find('.product_id').val();
            var type = get_parent.find('.type').val();
            var backorder = get_parent.find('.backorder').val();
            var note = get_parent.find('.stock_note').val();

            if (type == 'supplier') {
                var imsVal = [];
                // Read all checked checkboxes
                get_parent.find(".ims-input").each(function() {
                    if (jQuery(this).is(':checked')) {
                        imsVal.push(jQuery(this).val());
                    }
                });

            }
            if (imsVal) {
                get_parent.find('.ims_inputDiv').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });

                //Sending data
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'updateIMSInfo',
                        product_id: product_id,
                        value: imsVal,
                        type: type,
                        backorder: backorder,
                        note: note
                    },
                    method: 'POST',
                    //  dataType: 'JSON',
                    // async: false,
                    success: function(response) {
                        datatable.ajax.reload();
                        get_parent.find('.ims_inputDiv').unblock();
                        get_parent.find('span').show();
                        get_parent.find('.ims_inputDiv').hide();
                        get_parent.find('.ims_edit_icon').show();
                    },
                    error: function(response) {
                        get_parent.find('.ims_inputDiv').unblock();
                    }
                });
            }
        });

        function reportFilterByDate() {
            jQuery('.loading-sbr').show();
            datatable.ajax.reload();
        }
    </script>
    <script>
        var checkInInventoryOrder = true;
        jQuery('body').on('click', '#receivedInventoryPO', function() {
            var product_id = jQuery(this).attr('product_id');
            jQuery('#checkInInventoryOrderResponse').html();
            if (checkInInventoryOrder) {
                checkInInventoryOrder = false;
                jQuery('#checkInInventoryOrder').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                var elementT = document.getElementById("checkInInventoryOrder");
                var formdata = new FormData(elementT);
                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    method: 'POST',
                    //dataType: 'JSON',
                    success: function(response) {
                        checkInInventoryOrder = true;
                        datatable.ajax.reload();
                        jQuery('#checkInInventoryOrderResponse').html(response);
                        jQuery('#checkInInventoryOrder').unblock();

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });
        var createInventoryPO = true;
        jQuery('body').on('click', '#createInventoryPO', function() {
            var product_id = jQuery(this).attr('product_id');
            jQuery('#createInventoryOrderResponse').html();
            if (createInventoryPO) {
                createInventoryPO = false;
                jQuery('#addInventoryOrder').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                var elementT = document.getElementById("addInventoryOrder");
                var formdata = new FormData(elementT);
                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    method: 'POST',
                    //dataType: 'JSON',
                    success: function(response) {
                        createInventoryPO = true;
                        datatable.ajax.reload();
                        jQuery('#createInventoryOrderResponse').html(response);
                        jQuery('#addInventoryOrder').unblock();

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });
    </script>
<?php
    alertLevelEmailNotification();
}



/**
 * Retrieves sold inventory data based on specified date range and shipment category.
 *
 * @param string $order_start_date Start date for filtering shipments.
 * @param string $order_end_date   End date for filtering shipments.
 * @param string $sc               Shipment category ('all', 'np', 'pm').
 *
 * @global wpdb $wpdb              WordPress database class.
 * @global MbtPackaging $MbtPackaging Custom packaging class.
 *
 * @return array Associative array containing raw product IDs and order quantities.
 */
function sbr_getSoldInventory($order_start_date, $order_end_date, $sc = 'all')
{
    global $wpdb, $MbtPackaging;;
    $tax_query = array(
        'relation' => 'AND',
    );
    if ($sc == 'np') {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('boxes', 'bubble-mailer', 'envelope', 'thermal-postage-label'),
            'operator' => 'NOT IN',
        );
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('raw'),
        );
    } else if ($sc == 'pm') {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('boxes', 'bubble-mailer', 'envelope', 'thermal-postage-label'),
            'operator' => 'IN'
        );
    } else {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('raw'),
        );
    }
    $tax_query[] = array(
        'taxonomy' => 'product_type',
        'field' => 'slug',
        'terms' => 'simple',
    );
    /*
    $tax_query[] = array(
        'taxonomy' => 'product_type',
        'field' => 'slug',
        'terms' => 'composite',
    );
    */
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => $tax_query,

    );
    $rawPrdoucts = get_posts($args);
    $order_products = array();
    $orderQty = array();



    $searchQuery = '';
    if ($order_start_date != '' && $order_end_date != '') {
        $searchQuery .= " and (shipmentDate BETWEEN '" . $order_start_date . " 00:00:00' AND '" . $order_end_date . " 23:59:59') ";
    } else if ($order_start_date != '') {
        $searchQuery .= " and (shipmentDate >= '" . $order_start_date . " 00:00:00') ";
    } else if ($order_end_date != '') {
        $searchQuery .= " and (shipmentDate <= '" . $order_end_date . " 23:59:59') ";
    }

    $packageData = array();
    $packages = array();
    $usedStockPackage = array();

    $package_components = $MbtPackaging->get_all_packages_withComponents();
    foreach ($package_components as $components) {
        //$packageData[$components->package_id]
        $d = array(
            'p_id' => $components->component_id,
            'title' => $components->name,
            'qty' => $components->component_qty
        );

        $packageData[$components->package_id][] = $d;
    }
    $q1 = "SELECT trackingCode, packageId , shipmentState , productsWithQty FROM  " . SB_EASYPOST_TABLE;
    $q1 .= " WHERE 1 " . $searchQuery;
    $easypostData = $wpdb->get_results($q1, 'ARRAY_A');
    $newSystemChildProductsQty = array();
    $availableComponentProducts = array();
    foreach ($easypostData as  $packageInfo) {
        if ($packageInfo['shipmentState'] != 'Refunded-Success' && $packageInfo['packageId'] > 0) {

            if ($sc == 'np' || $sc == 'all') {
                $shipmentEntry = $packageInfo['productsWithQty'];
                $items = json_decode($shipmentEntry, true);

                foreach ($items as $productData) {
                    if (isset($productData['product_id'])) {
                        $product_id = $productData['product_id'];

                        if (isset($availableComponentProducts[$product_id])) {
                            $compositeData = $availableComponentProducts[$product_id];
                        } else {
                            $compositeData = get_field('composite_products', $product_id);
                            $availableComponentProducts[$product_id] = $compositeData;
                        }

                        foreach ($compositeData as $composite_item_id => $composite_item) {
                            $firstShipment = $composite_item['first_shipment_qty'];
                            $secondShipment = $composite_item['second_shipment_qty'];
                            $composite_item_product_id = $composite_item['product_id'];

                            if ($productData['type'] == 'composite') {
                                if ($productData['shipment'] == 1) {
                                    if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                        $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] +  $firstShipment;
                                    } else {
                                        $newSystemChildProductsQty[$composite_item_product_id] = $firstShipment;
                                    }
                                } else {
                                    if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                        $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] +  $secondShipment;
                                    } else {
                                        $newSystemChildProductsQty[$composite_item_product_id] = $secondShipment;
                                    }
                                }
                            } else {
                                $qtyShiped = $productData['qty'] * $firstShipment;
                                if (isset($newSystemChildProductsQty[$composite_item_product_id])) {
                                    $newSystemChildProductsQty[$composite_item_product_id] = $newSystemChildProductsQty[$composite_item_product_id] +  $qtyShiped;
                                } else {
                                    $newSystemChildProductsQty[$composite_item_product_id] = $qtyShiped;
                                }
                            }
                        }
                    }
                }
            }

            if (isset($packages[$packageInfo['packageId']])) {
                $packages[$packageInfo['packageId']] = $packages[$packageInfo['packageId']] + 1;
            } else {
                $packages[$packageInfo['packageId']] = 1;
            }
        }
    }
    if ($sc == 'np' || $sc == 'all') {
        if ($newSystemChildProductsQty) {
            foreach ($newSystemChildProductsQty as $composite_item_product_id_key => $rm_qty) {
                $orderQty[$composite_item_product_id_key]['qty'] = $rm_qty;
            }
        }
    }
    foreach ($packages as  $pkg_id => $pkg_qty) {
        foreach ($packageData[$pkg_id] as  $ppD) {

            // if (isset($orderQty[$ppD['p_id']])) {
            $usedQty = $orderQty[$ppD['p_id']]['qty'] +  ($ppD['qty'] * $pkg_qty);
            $orderQty[$ppD['p_id']]['qty'] =  $usedQty;
        }
    }

    // echo '<pre>';
    // print_r($orderQty['841668']);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($orderQty);
    // echo '</pre>';
    // die;
    return array(
        'rawPrdoucts' => $rawPrdoucts,
        'orderQty' =>  $orderQty
    );
}

/**
 * AJAX callback function for processing and retrieving data for the Sold Inventory Management System (IMS).
 *
 * @return void Outputs JSON-encoded data for DataTables.
 */
function sbr_productIMS_callback()
{
    global $wpdb;
    if (!empty($_GET)) {

        $orderByColumnIndex = 0;
        // $orderBy = 'desc';
        /* SEARCH CASE : Filtered data */
        /* Useful $_REQUEST Variables coming from the plugin */
        $draw = $_GET["draw"]; //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'ASC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        /* *************** */
        $order_start_date = $_GET["startDate"]; //Paging first record indicator.
        $order_end_date = $_GET["endDate"]; //Paging first record indicator.
        $sc = $_GET["sc"]; //Paging first record indicator.
        /* *************** */
        $searchQuery = " ";
        $searchDateQuery = " ";
        $modified_data = array();
        $rawPrdoucts = array();
        if (!empty($_GET['search']['value'])) {
        }

        if (empty($order_start_date) || empty($order_end_date)) {
        } else {
            /*Search Data */
            $searchData =  sbr_getSoldInventory($order_start_date, $order_end_date, $sc);
            $rawPrdoucts = $searchData['rawPrdoucts'];
            $orderQty = $searchData['orderQty'];

            $date1 = new DateTime($order_start_date);
            $date2 = new DateTime($order_end_date);
            $interval = $date1->diff($date2);
            $filterDayInterval = $interval->days + 1;


            $first_level_alert = get_field('first_level_alert', 'option');
            $second_level_alert = get_field('second_level_alert', 'option');
            $level1Entries = array();
            $level2Entries = array();
            foreach ($rawPrdoucts as $key => $product_id) {
                $product = wc_get_product($product_id);

                $currentStock = (int) get_post_meta($product_id, '_stock', true);
                $lead_time = get_post_meta($product_id, 'lead_time', true);
                $errorClass  = '';

                if ($lead_time == '') {
                    $errorClass  = 'errorLT';
                }
                $title = '<a href="' . get_edit_post_link($product_id) . '" target="_blank" class="' . $errorClass . '">' . str_replace('"', "&#8221;", get_the_title($product_id)) . '</a>';
                //$title = '';
                $consumptionRate  = 0;
                if (isset($orderQty[$product_id])) {
                    $consumptionRate  = $orderQty[$product_id]['qty'] / $filterDayInterval;
                    $consumptionRate = number_format((float)$consumptionRate, 2, '.', '');
                }

                if ($consumptionRate > 0) {
                    $daysOfInventoryRemaining  = round($currentStock / $consumptionRate);
                } else {
                    $daysOfInventoryRemaining  = 0;
                }

                if (!is_infinite($daysOfInventoryRemaining)) {
                    $dayUntilOutOfStock  = round($daysOfInventoryRemaining - (int) $lead_time);
                } else {
                    $dayUntilOutOfStock  = 0;
                }


                // if ($product_id == 749251) {
                //     var_dump($consumptionRate);
                //     var_dump($daysOfInventoryRemaining);
                //     var_dump($dayUntilOutOfStock);
                //     die;
                // } else {
                //     continue;
                // }

                $entry = array();
                $entry[] =  $title;


                $stockData = array(
                    'type' => 'stock',
                    'product_id' => $product_id,
                    'backorder' => $product->backorders_allowed(),
                    'currentStock' => $currentStock

                );


                if ($product->backorders_allowed()) {
                    $entry[] = stockLeadTimeUpdateHtml($stockData) . '<p>Backorder Enabled</p>';
                } else {
                    $entry[] = stockLeadTimeUpdateHtml($stockData) . '<p class="errorLT">Backorder Disabled</p>';
                }

                $orderQty_total = 0;
                if (isset($orderQty[$product_id]['qty'])) {
                    $orderQty_total = $orderQty[$product_id]['qty'];
                }
                $entry[] = $orderQty_total;
                if (is_infinite($consumptionRate)) {
                    $entry[] = 0;
                } else {
                    $entry[] = $consumptionRate;
                }
                $htmlCosg = '';

                $cog = get_post_meta($product_id, '_wc_cog_cost', true);
                $cogData = array(
                    'type' => 'cog',
                    'product_id' => $product_id,
                    'lead_time' => $cog

                );

                $entry[] = stockLeadTimeUpdateHtml($cogData);
                // $entry[] = wc_price(floatval($cog));
                if (isset($orderQty[$product_id]) && is_array($orderQty[$product_id])) {
                    $qty = $orderQty[$product_id]['qty'];


                    //  $htmlCosg = $qty. '= '.$filterDayInterval . '=' .$cog;
                    // Other calculations using $qty
                    $costPrice = (int)$qty  * floatval($cog);
                    // Rest of your code
                } else {
                    // Handle the case when $orderQty[$product_id] is not set or is not an array
                    // You can log an error, throw an exception, or set a default value for $costPrice
                    $costPrice = 0; // Or any default value you want
                }

                $entry[] = $htmlCosg . '<br/>' . wc_price($costPrice);

                $lvlClass = '';
                if ($consumptionRate == 0) {
                } else {
                    if ($dayUntilOutOfStock <= $first_level_alert) {
                        if ($dayUntilOutOfStock <= $second_level_alert) {
                            $lvlClass = 'levelRed';
                        } else {
                            $lvlClass = 'levelYellow';
                        }
                    }
                }

                $eastimateHtml = '';
                $estimatedOrderDays = ($daysOfInventoryRemaining - (int) $lead_time);
                if ($lvlClass != '') {
                    if (is_infinite($daysOfInventoryRemaining)) {
                    } else {
                        //   if ($estimatedOrderDays == 0) {
                        //     $eastimateHtml .= '<span class="orderNowMsg"><span>"ORDER NOW!"</span><br/>(' . $daysOfInventoryRemaining . ' days)</span>';
                        if ($estimatedOrderDays < 0) {
                            $eastimateHtml .= '<span class="orderNowMsg"><span>ORDER NOW!</span><br/>(' . numberFormat((int)$daysOfInventoryRemaining) . ' days)</span>';
                        } else {
                            $eastimateHtml .= '<span class="orderNowMsg"><span>ORDER NOW!</span><br/>(' . numberFormat((int)$daysOfInventoryRemaining) . ' days)</span>';
                        }
                    }
                } else {
                    $eastimateHtml .=  numberFormat((int)$daysOfInventoryRemaining) . ' days';
                }


                if (is_infinite($dayUntilOutOfStock)) {
                    $entry[] = 0;
                } else {
                    $entry[] = $eastimateHtml;
                }


                if (is_infinite($dayUntilOutOfStock)) {
                    $entry[] = 0;
                } else {
                    $entry[] = $dayUntilOutOfStock;
                }
                /*
                $supplierHtml = '';
                $supplierList = wp_get_object_terms($product_id, 'supplier');
                if (!empty($supplierList)) :
                    $supplierHtml = '<ul class="supplierCol">';
                    foreach ($supplierList as $supplier) :
                        $supplierHtml .= '<li>' . $supplier->name . '</li>';
                    //$supplierHtml .= '<span class="supplierDescription">' . $supplier->description . '</span>';
                    endforeach;
                    $supplierHtml .= '</ul>';
                endif;

                $entry[] = $supplierHtml;
                */
                $entry[] = supplierUpdateHtml($product_id);
                $leadData = array(
                    'type' => 'lead_time',
                    'product_id' => $product_id,
                    'lead_time' => $lead_time

                );

                $entry[] = stockLeadTimeUpdateHtml($leadData);

                $lvlHtml = '';
                $poQty = 0;
                $poRcQty = 0;
                $balance = 0;


                $productAllPoOrdersQuery = "SELECT  * FROM " . SB_PP . " WHERE product_id = $product_id";
                $productAllPoOrders = $wpdb->get_results($productAllPoOrdersQuery, 'ARRAY_A');
                // echo '<pre>';
                // print_r($productAllPoOrders);
                // echo '</pre>';
                $poOD = array();
                if (count($productAllPoOrders) > 0) {
                    foreach ($productAllPoOrders as $poD) {
                        $order_id = $poD['order_id'];
                        $poRcOrderQuery = "SELECT  SUM(received_qty) FROM " . SB_PO_LOG . " WHERE product_id = $product_id AND order_id = $order_id";
                        $poRcQtyD = $wpdb->get_var($poRcOrderQuery);

                        if (isset($poOD[$order_id])) {
                            $reQty =  $poOD[$order_id]['received_qty'];
                            $poOD[$order_id]['received_qty'] = $reQty + $poRcQtyD;
                        } else {
                            $poOD[$order_id] = array(
                                'po_qty' => $poD['po_qty'],
                                'received_qty' =>   $poRcQtyD,
                            );
                        }
                    }
                    // echo '<pre>';
                    // print_r($poOD);
                    // echo '</pre>';
                    foreach ($poOD as $stockCheck) {
                        if ($stockCheck['po_qty'] != $stockCheck['received_qty']) {
                            $poQty = $stockCheck['po_qty'] + $poQty;
                            $poRcQty = $stockCheck['received_qty'] + $poRcQty;
                        }
                    }
                }





                $lvlHtml = '';
                /*
                $estimatedOrderDays = ($daysOfInventoryRemaining - $lead_time);
                if (is_infinite($daysOfInventoryRemaining)) {
                } else {
                    if ($estimatedOrderDays == 0) {
                        $lvlHtml .= '<span class="orderNowMsg">"ORDER NOW!" (' . $daysOfInventoryRemaining . ' days)</span><br/><br/>';
                    } else if ($estimatedOrderDays < 0) {
                        $lvlHtml .= '<span class="orderNowMsg">"ORDER NOW!" (-' . $daysOfInventoryRemaining . ' days)</span><br/><br/>';
                    }
                }
                */
                if (count($productAllPoOrders) > 0) {
                    if ($poQty == $poRcQty) {
                        $lvlHtml .= '<strong>Inventory Received</strong><br/><br/>';
                    } else {
                        $balance = (int)$poQty - (int)$poRcQty;
                        $lvlHtml .= '<strong>On Order</strong><br/><br/>';
                        $lvlHtml .= '<a href="javascript:;" onclick= "loadPoLogs(' . $product_id . ' , 2)">Check-In</a>&nbsp;';
                    }
                    $lvlHtml .= '<a href="javascript:;" onclick= "loadPoLogs(' . $product_id . ' , 3)">PO History</a>';
                }
                $lvlHtml .= '<a href="javascript:;" onclick= "loadPoLogs(' . $product_id . ' , 4)">Stock History</a>';






                // $entry[] = 0;
                // $entry[] = 0;
                $entry[] = numberFormat($poQty);
                $entry[] = numberFormat($balance);


                $entry[] = '<div class="imsWapper"><div class="ims_container" product_id="' . $product_id . '">' . $lvlHtml . '</div></div>';
                $entry[] = $lvlClass;
                // $modified_data[] = $entry;
                if ($lvlClass == 'levelRed') {
                    $level1Entries[] = $entry;
                } else if ($lvlClass == 'levelYellow') {
                    $level2Entries[] = $entry;
                } else {
                    $levelNAEntries[] = $entry;
                }
            }
        }

        if (is_array($level1Entries) && count($level1Entries) > 0) {
            foreach ($level1Entries as  $lvl1) {
                $modified_data[] = $lvl1;
            }
        }
        if (is_array($level2Entries) && count($level2Entries) > 0) {
            foreach ($level2Entries as  $lvl2) {
                $modified_data[] = $lvl2;
            }
        }
        if (count($levelNAEntries) > 0) {
            foreach ($levelNAEntries as  $lvl3) {
                $modified_data[] = $lvl3;
            }
        }

        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($rawPrdoucts),
            "iTotalDisplayRecords" => count($rawPrdoucts),
            "data" => $modified_data
        );
        // echo '<pre>';
        // print_r($results);
        // echo '</pre>';
        // die;
        echo json_encode($results);
    }
    die;
}
/**
 * Generates HTML for displaying and updating supplier information for a given product.
 *
 * @param int $product_id Product ID.
 *
 * @return string HTML output for supplier information.
 */
function supplierUpdateHtml($product_id)
{



    $html = '';

    $suppliers = get_terms(array(
        'taxonomy' => 'supplier',
        'hide_empty' => false,
    ));
    $existSupplier = array();
    $supplierList = wp_get_object_terms($product_id, 'supplier');
    if (!empty($supplierList)) :
        $html = '<ul class="supplierCol" style="list-style: disclosure-closed;padding-left: 30px;">';
        foreach ($supplierList as $supplier) :
            $existSupplier[] = $supplier->term_id;
            $html .= '<li>' . $supplier->name . '</li>';
        endforeach;
        $html .= '</ul>';
    endif;

    $html .= '<div class="imsWapper">';
    $html .= '<div class="ims_container" product_id="' . $product_id . '">';

    $html .= '<div class="IMSEditDiv">';

    $html .= '<a class="ims_edit_icon" href="javascript:;" style=""></a>';
    $html .= '</div>';

    $html .= '<div class="ims_inputDiv flex-row-mbt" style="display: none; min-width: 385px;">';

    $html .= '<h5 style="margin-top: 0;margin-bottom: 10px;font-weight: 600;padding-left: 3px;letter-spacing: 1px;">Suppliers</h5>';

    if (!empty($suppliers)) :

        foreach ($suppliers as $supplier) :
            $checked = '';
            if (count($existSupplier) > 0) {
                if (in_array($supplier->term_id, $existSupplier)) {
                    $checked = 'checked=""';
                }
            }

            $html .= '<input class="ims-input" style="width: auto;" type="checkbox" id="supplier_' . $supplier->term_id . '" name="supplier" value="' . $supplier->term_id . '" ' . $checked . '>';
            $html .= '<label for="supplier_' . $supplier->term_id . '">' . $supplier->name . '</label><br>';
        endforeach;

    endif;

    $html .= '<input type="hidden" class="type" value="supplier">';
    $html .= '<input type="hidden" class="product_id" value="' . $product_id . '">';
    $html .= '<div class="button-parent-batch-print">';
    $html .= '<div class="btn_save"><button class="btnIMSUpdate" type="button">Save</button></div>';
    $html .= '<div class="btn_cancel"><button class="btnIMScancel" type="button" style="">Cancel</button></div>';
    $html .= '</div>';

    $html .= '</div>';

    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
/**
 * Generates HTML for displaying and updating inventory management system (IMS) information such as stock and lead time.
 *
 * @param array $data {
 *     Optional. Data used to customize the HTML output.
 *
 *     @type string $type        Type of IMS information ('stock' or 'lead_time').
 *     @type int    $product_id  Product ID.
 *     @type int    $currentStock Current stock quantity.
 *     @type int    $lead_time    Lead time for the product.
 *     @type string $backorder    Backorder status ('no', 'notify', 'yes').
 * }
 *
 * @return string HTML output for IMS information.
 */
function stockLeadTimeUpdateHtml($data)
{

    if (isset($data['type'])) {
        $type = $data['type'];
    } else {
        $type = $_REQUEST['type'];
    }
    if (isset($data['product_id'])) {
        $product_id = $data['product_id'];
    } else {
        $product_id = $_REQUEST['product_id'];
    }
    if (isset($data['currentStock'])) {
        $currentStock = $data['currentStock'];
    } else {
        $currentStock = $_REQUEST['currentStock'];
    }
    $errorClass  = '';
    if (isset($data['lead_time'])) {
        $lead_time = $data['lead_time'];
    } else {
        $lead_time = $_REQUEST['lead_time'];
    }

    $html = '';
    if ($type  == 'lead_time') {
        if ($lead_time == '') {
            $errorClass  = 'errorLT';
        }
    }
    $html .= '<div class="imsWapper ' . $errorClass . '">';
    $html .= '<div class="ims_container" product_id="' . $product_id . '">';

    $html .= '<div class="IMSEditDiv">';
    if ($type  == 'stock') {
        $html .= '<span style="">' . numberFormat((int)$currentStock) . '</span>';
    } else   if ($type  == 'cog') {
        $html .= '<span style="">' . wc_price(floatval($lead_time)) . '</span>';
    } else {
        $html .= '<span style="">' . (int)$lead_time . '</span>';
    }
    $html .= '<a class="ims_edit_icon" href="javascript:;" style=""></a>';
    $html .= '</div>';

    $html .= '<div class="ims_inputDiv flex-row-mbt" style="display: none;">';
    if ($type  == 'stock') {

        $html .= '<input type="hidden" class="type" value="stock">';
        $html .= '<label>Current Inv.';
        $html .= '<input type="text" class="ims-input" name="stock" placeholder="Stock" value="' . (int)$currentStock . '">';
        $html .= '</label>';


        if (isset($data['backorder'])) {
            $backorder = $data['backorder'];
            $html .= '<label>Backorders';
            $html .= '</label>';
            $html .= '<select class="backorder ims-input" name="_backorders">';

            if ($backorder == 'no') {
                $html .= '<option value="no" selected="selected">Do not allow</option>';
            } else {
                $html .= '<option value="no">Do not allow</option>';
            }
            if ($backorder == 'notify') {
                $html .= '<option value="notify" selected="selected">Allow, but notify customer</option>';
            } else {
                $html .= '<option value="notify">Allow, but notify customer</option>';
            }
            if ($backorder == 'yes') {
                $html .= '<option value="yes" selected="selected">Allow</option>';
            } else {
                $html .= '<option value="yes" >Allow</option>';
            }
            $html .= '</select>';
        }

        $html .= '<label>Add Note';
        $html .= '<textarea  class="stock_note" placeholder="Note"></textarea>';
        $html .= '</label>';
    } elseif ($type  == 'cog') {
        $html .= '<input type="hidden" class="type" value="cog">';
        $html .= '<input type="text" class="ims-input" name="cog" placeholder="Cost" value="' . $lead_time . '">';
    } else {
        $html .= '<input type="hidden" class="type" value="lead_time">';
        $html .= '<input type="text" class="ims-input" name="lead_time" placeholder="Lead Time" value="' . (int)$lead_time . '">';
    }
    $html .= '<input type="hidden" class="product_id" value="' . $product_id . '">';
    $html .= '<div class="button-parent-batch-print">';
    $html .= '<div class="btn_save"><button class="btnIMSUpdate" type="button">Save</button></div>';
    $html .= '<div class="btn_cancel"><button class="btnIMScancel" type="button" style="">Cancel</button></div>';
    $html .= '</div>';

    $html .= '</div>';

    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
/**
 * Callback function for handling AJAX requests to update the IMS status of a product.
 */
function save_ims_status_callback()
{
    if (!empty($_REQUEST['product_id'])) {
        update_post_meta($_REQUEST['product_id'], '_ims_status', $_REQUEST['ims_status']);
        echo 'Status Updated';
    } else {
        echo 'Something Went Wrong';
    }
    die;
}
/**
 * Format a number with commas as thousands separators and specified decimal places.
 *
 * @param float $number    The number to format.
 * @param int   $decimals  The number of decimal places. Default is 0.
 *
 * @return string Formatted number as a string.
 */
function numberFormat($number, $decimals = 0)
{

    // $number = 555;
    // $decimals=0;
    // $number = 555.000;
    // $number = 555.123456;

    if (strpos($number, '.') != null) {
        $decimalNumbers = substr($number, strpos($number, '.'));
        $decimalNumbers = substr($decimalNumbers, 1, $decimals);
    } else {
        $decimalNumbers = 0;
        for ($i = 2; $i <= $decimals; $i++) {
            $decimalNumbers = $decimalNumbers . '0';
        }
    }
    // return $decimalNumbers;



    $number = (int) $number;
    // reverse
    $number = strrev($number);

    $n = '';
    $stringlength = strlen($number);

    for ($i = 0; $i < $stringlength; $i++) {
        if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
            $n = $n . $number[$i] . ',';
        } else {
            $n = $n . $number[$i];
        }
    }

    $number = $n;
    // reverse
    $number = strrev($number);

    ($decimals != 0) ? $number = $number . '.' . $decimalNumbers : $number;

    return $number;
}
