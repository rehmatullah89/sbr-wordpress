<?php



add_action('wp_ajax_update_package_combination', 'update_package_combination_callback');
/**
 * Ajax callback to update package combination min max Qty
 */
function update_package_combination_callback()
{

    global $wpdb;

    // Check if the 'min_qty' and 'max_qty' keys exist in the request data
    if (isset($_REQUEST['min_qty']) && isset($_REQUEST['max_qty'])) {
        foreach ($_REQUEST['min_qty'] as $product_id => $qty) {
            $data[$product_id]['qty_min'] = $qty;
        }
        foreach ($_REQUEST['max_qty'] as $product_id => $qty) {
            $data[$product_id]['qty_max'] = $qty;
        }

        $noErrorflagQty = true;

        foreach ($data as $product_id => $value) {
            // Use '==' for comparison, not '='
            if ($value['qty_min'] == '' || $value['qty_min'] < 1) {
                $noErrorflagQty = false;
            }
            if ($value['qty_max'] == '' || $value['qty_max'] < 1) {
                $noErrorflagQty = false;
            }
            // Check if min qty is greater than max qty
            if ($value['qty_min'] > $value['qty_max']) {
                $noErrorflagQty = false;
            }
        }
    } else {
        // Handle case where 'min_qty' or 'max_qty' keys are missing in the request
        $noErrorflagQty = false;
    }
    smile_brillaint_logs('package_log', $_REQUEST);
    //var_dump($noErrorflagQty);
    //die;
    if ($noErrorflagQty) {
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        if ($_REQUEST['combination_package_id'] == $_REQUEST['package_id']) {

            foreach ($data as $product_id => $value) {
                $sql_data = array(
                    'qty_min' => $value['qty_min'],
                    'qty_max' => $value['qty_max']

                );
                $where = array(
                    'product_id' => (int)  $product_id,
                    'package_id' => (int)  $_REQUEST['combination_package_id'],
                    'group_id' => (int)  $_REQUEST['combination_group_id']
                );
                $wpdb->update($table_name_products, $sql_data, $where);
            }
        } else {
            $package_id = $_REQUEST['package_id'];
            $getLastGroup_sql = "SELECT MAX(group_id) AS max_group_id FROM $table_name_products WHERE package_id = %d";
            $getLastGroup_id = $wpdb->get_var($wpdb->prepare($getLastGroup_sql, $package_id));
            $getLastGroup_id++;

            foreach ($data as $product_id => $value) {
                $sql_data = array(
                    'qty_min' => $value['qty_min'],
                    'qty_max' => $value['qty_max'],
                    'group_id' => (int)  $getLastGroup_id,
                    'package_id' => (int)  $_REQUEST['package_id'],

                );
                $where = array(
                    'product_id' => (int)  $product_id,
                    'package_id' => (int)  $_REQUEST['combination_package_id'],
                    'group_id' => (int)  $_REQUEST['combination_group_id']
                );
                $wpdb->update($table_name_products, $sql_data, $where);
            }
        }
        $result['msg'] = 'Package info updated.';
        $result['status'] = 200;
    } else {
        $result['msg'] = 'Group Qty invalid';
        $result['status'] = 400;
    }
    echo json_encode($result);
    die;
}

add_action('wp_ajax_searchPackageByCombination', 'searchPackageByCombination_callback');
/**
 * Ajax callback to search package group for products
 */
function searchPackageByCombination_callback()
{

    global $MbtPackaging;
    $productsQtyShipmentLevel = array();

    foreach ($_REQUEST['packaging_product']['product_id'] as $key => $productDetail) {

        $product_id = $_REQUEST['packaging_product']['product_id'][$key];
        $qty = $_REQUEST['packaging_product']['qty'][$key];
        $level = $_REQUEST['packaging_product']['shipment_level'][$key];

        $data = array(
            'product_id' => $product_id,
            'qty' => $qty,
            'level' => $level
        );

        $existingKey = multi_array_search($productsQtyShipmentLevel, array('product_id' => $product_id, 'level' => $level));
        if (count($existingKey) > 0) {
            $productsQtyShipmentLevel[$existingKey[0]]['qty'] = $productsQtyShipmentLevel[$existingKey[0]]['qty'] + $qty;
        } else {
            $productsQtyShipmentLevel[] = $data;
        }
    }

    $get_all_packages = $MbtPackaging->get_all_packages();
    foreach ($get_all_packages as $key => $package) {
        $packageNamebyId[$package->id] = $package->name;
    }

    if (count($productsQtyShipmentLevel) > 0) {
        $get_packages = $MbtPackaging->get_package_ids_for_basket($productsQtyShipmentLevel);
        // echo '<pre>';
        // print_r($get_packages);
        // echo '</pre>';
        $combinationHtml = '';
        if (isset($get_packages['combinations_data'])) {

            if (isset($get_packages['search'])) {
                $combinationHtml .= '<div class="orderHistorySection SearchPackage">';
            } else {
                $combinationHtml .= '<div class="orderHistorySection">';
            }
            $combinationHtml .= '<h3>Search Results</h3>';
            $combinationHtml .= '<table id="orderHistory" class="data-table" style="width:99%">';
            $combinationHtml .= '<thead>';
            $combinationHtml .= '<tr>';
            $combinationHtml .= '<th>Package ID</th>';
            $combinationHtml .= '<th>Package Name</th>';
            $combinationHtml .= '<th>Groups</th>';
            $combinationHtml .= '</tr>';
            $combinationHtml .= '</thead>';
            $combinationHtml .= '<tbody>';

            foreach ($get_packages['combinations_data'] as  $package_id =>  $foundPackages) {
                $availableRecord = (array)$foundPackages;
                $combinationHtml .= '<tr>';
                $combinationHtml .= '<td>' . $package_id . '</td>';
                $combinationHtml .= '<td>' . $packageNamebyId[$package_id] . '</td>';
                $combinationHtml .= '<td>';
                $combinationHtml .= '<table>';
                $combinationHtml .= '<tbody>';
                $combinationHtml_inner = '';
                foreach ($availableRecord as $group_id =>  $packageGroup) {
                    $rand = rand(10, 999) * time();
                    $combinationHtml_inner .= '<tr class="parentGroup group_row_' . $group_id . '"  id="combination_' . $rand . '">';
                    $combinationHtml_inner .= '<td colspan=3>';
                    $combinationHtml_inner .= '<form id="form_' . $rand . '">';
                    $combinationHtml_inner .= '<div class="rowTopMbt">';
                    $combinationHtml_inner .= '<input type="hidden" name="combination_package_id" value="' . $package_id . '" />';
                    $combinationHtml_inner .= '<input type="hidden" name="combination_group_id" value="' . $group_id . '" />';
                    $combinationHtml_inner .= '<div class="groupId">Group ID#' . $group_id . '</div>';
                    $combinationHtml_inner .= '<div class="inputCross">';
                    ///   $combinationHtml_inner .= '<span class="inputButton"><label for="group_radio_' . $group_id . '"><input name="setPackageGroup" id="group_radio_' . $group_id . '" type="radio" class="radioPackageGroup" value="' . $group_id . '">Set as default</label></span>';
                    $combinationHtml_inner .= '<a href="javascript:;" onclick="removePackageGroup(' . $package_id . ', ' . $group_id . ' , ' . $rand . ')" class="crossIcon" >×</a>';
                    $combinationHtml_inner .= '</div>';
                    $combinationHtml_inner .= '</div>';

                    foreach ($packageGroup as  $groupData) {

                        $combinationHtml_inner .= '<div class="group_row_' . $group_id . ' item">';
                        //$combinationHtml_inner .= '<div class="group_package_title">' . $groupData->package_products_descending . '</div>';
                        $combinationHtml_inner .= '<div class="group_package_title">' . get_the_title($groupData->product_id) . '</div>';
                        $combinationHtml_inner .= '<div class="minMax">';

                        $combinationHtml_inner .= '<div class="minQty">Min Qty: <input type="number" name="min_qty[' . $groupData->product_id . ']" value="' . $groupData->qty_min . '" /></div>';
                        $combinationHtml_inner .= '<div class="maxQty">Max Qty: <input type="number" name="max_qty[' . $groupData->product_id . ']" value="' . $groupData->qty_max . '" /></div>';

                        $combinationHtml_inner .= '</div>';
                        $combinationHtml_inner .= '</div>';
                    }
                    $combinationHtml_inner .= '<div class="item">';
                    $combinationHtml_inner .= '<div class="group_package_title">Move Package:</div>';
                    $combinationHtml_inner .= '<div class="minMax"><select name="package_id">';
                    foreach ($packageNamebyId as $p_id => $p_name) {
                        if ($groupData->package_id  == $p_id) {
                            $combinationHtml_inner .= '<option value="' . $p_id . '" selected="">' . $p_name . '</option>';
                        } else {
                            $combinationHtml_inner .= '<option value="' . $p_id . '">' . $p_name . '</option>';
                        }
                    }
                    $combinationHtml_inner .= '</select></div>';
                    $combinationHtml_inner .= '</div>';

                    $combinationHtml_inner .= '<div class="button-update-action">';

                    $combinationHtml_inner .= '<button class="button btn" type="button" onclick="updateCombination(' . $rand . ')">Update</button>';
                    $combinationHtml_inner .= '<input type="hidden" name="action" value="update_package_combination" />';
                    $combinationHtml_inner .= '</div>';

                    $combinationHtml_inner .= '</form>';
                    $combinationHtml_inner .= '</td>';
                    $combinationHtml_inner .= '</tr>';
                }

                $combinationHtml .= $combinationHtml_inner;
                $combinationHtml .= '</tbody>';
                $combinationHtml .= '</table>';
                $combinationHtml .= '</td>';
                $combinationHtml .= '</tr>';
            }
            $combinationHtml .= '</tbody>';
            $combinationHtml .= '</table>';
        }
        if ($combinationHtml == '') {
            $combinationHtml .= '<div class="alert alert-danger" role="alert">No Package Found.</div>';
        }
        echo $combinationHtml;
    }
    die;
}
/**
 * Function to Search package groups Dashbaord where Admin can search group for products
 */
function mbt_packaging_search_dashboard()
{

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        'fields' => 'ids',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'operator' => 'NOT IN',
                'terms' => array("raw", "packaging", "landing-page", "data-only"),
            )
        )
    );

    $posts_array = get_posts(
        $args
    );

    $products = '<option>Select product</option>';
    foreach ($posts_array as $p_id) {
        $products .= '<option value="' . $p_id . '">' . get_the_title($p_id) . '</option>';
    }
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <div class="divCenterPackag">
        <h2>Manage Packages</h2>
        <form id="searchBtnPackage_form" class="packing-mbt-container-style">
            <div class="container-for-repeating-content">
                <!-- Content will be appended here -->
            </div>
            <div class="mt-20 button-action-group">
                <button id="addRepeatingContent" type="button" class="button btn">Add product</button>
                <input name="action" type="hidden" value="searchPackageByCombination" />
                <button type="button" id="searchBtnPackage" class="button btn">Search Package</button>
            </div>
        </form>
        <div id="responseSearchResult"></div>

    </div>
    <style>

    </style>
    <script>
        function searchPackageRequest() {
            jQuery('#responseSearchResult').empty();
            jQuery('#searchBtnPackage_form').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            jQuery('#responseSearchResult').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            var elementT = document.getElementById("searchBtnPackage_form");
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                method: 'POST',
                dataType: 'html',
                success: function(response) {
                    jQuery('#responseSearchResult').html(response);
                    jQuery('#searchBtnPackage_form').unblock();
                    jQuery('#responseSearchResult').unblock();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        function updateCombination(div_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, I am sure!'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#searchBtnPackage_form').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    jQuery('#responseSearchResult').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    var elementT = document.getElementById("form_" + div_id);
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                searchPackageRequest();
                            } else {
                                jQuery('#searchBtnPackage_form').unblock();
                                jQuery('#responseSearchResult').unblock();
                                Swal.fire('', response.msg, 'error');
                            }


                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                } else {
                    return false;
                }
            })

        }

        jQuery(document).ready(function($) {


            $("#addRepeatingContent").on("click", function() {
                var repeatingContent = `
                    <div class="repeating-content">
                        <div class="remove-itm"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-trash"></span></a></div>
                            <div class="row-smile">
                                <div class='col-md-6-smile'>
                                    <div class='packaging-label'>Select Products</div>
                                    <select name='packaging_product[product_id][]' class="searchProducts" autocomplete="false">
                                    <?php echo $products; ?>
                                    </select>
                                </div>
                                <div class='col-md-2-smile'>
                                    <div class='packaging-label'>Qty</div>
                                    <input type='number' min='1' max='10' class='qty' name='packaging_product[qty][]' value='1'>
                                </div>
                                <div class='col-md-4-smile'>
                                    <div class='packaging-label'>Shipment</div>
                                    <select class='shipment_level' name='packaging_product[shipment_level][]'>
                                        <option value='1'>First/Default</option>
                                        <option value='2'>Second</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                `;

                // Append the repeating content to the container
                $(".container-for-repeating-content").append(repeatingContent);
                jQuery(".searchProducts").select2({
                    placeholder: "Please select product.",
                    allowClear: true,
                    // width: '100%'
                });
            });
            jQuery('body').find('#addRepeatingContent').click();
            jQuery('body').on('click', '#searchBtnPackage', function() {

                var isValid = true;

                jQuery('body').find(".searchProducts").each(function() {
                    var selectedValues = jQuery(this).val();
                    if (!selectedValues || selectedValues.length === 0) {
                        isValid = false;
                        $(this).closest('.repeating-content').find('.select2-container').addClass('error');
                    } else {
                        $(this).closest('.repeating-content').find('.select2-container').removeClass('error');
                    }
                });

                if (!isValid) {
                    alert('Please select a product for all rows.');
                    return false;
                }
                searchPackageRequest();

            });





        });
    </script>
    <style>
        .divCenterPackag {
            background: #fff;
            padding: 16px;
            width: 99%;
            border: 1px solid #eee;
            margin-top: 14px;
        }

        .repeater .col-md-3 {
            width: 33%;
        }

        .col-sm-2 {
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%
        }

        .col-sm-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%
        }

        .col-sm-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%
        }

        .col-sm-5 {
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%
        }

        .col-sm-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-sm-7 {
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%
        }

        .col-sm-8 {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%
        }

        .repeater .col-md-3 {
            width: 31%;
            padding-left: 10px;
            padding-right: 10px;
        }

        #responseSearchResult h3 {
            font-size: 30px;

        }

        #responseSearchResult {
            border: 1px solid #cecece;
            padding: 20px;
            margin-top: 15px;
            background: #2372b114;

        }

        #responseSearchResult h3 {
            font-size: 30px;
            margin-top: 0;
        }

        .container-for-repeating-content {
            max-width: 100%;
            display: flex;
            flex-wrap: wrap;
            grid-template-columns: auto auto auto auto auto;
            grid-column-gap: 15px;
            grid-row-gap: 6px;
        }

        .container-for-repeating-content .repeating-content {
            max-width: 49%;
        }

        #responseSearchResult .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            font-size: 18px;
            margin-top: 30px;
        }

        .repeating-content select {
            padding: 5px 24px 0 8px;
        }

        .repeater {
            position: relative;
            margin-top: 16px;
            padding: 45px 20px 10px;
            border: 1px solid #d8d8d8;
            border-top-color: rgb(216, 216, 216);
            border-right-color: rgb(216, 216, 216);
            border-bottom-color: rgb(216, 216, 216);
            border-left-color: rgb(216, 216, 216);
            background: #dd907b21;
            border-radius: 3px;
            margin-bottom: 50px;
            border-color: #dd8f7a;
        }

        .repeating-content .remove-itm {
            position: absolute;
            right: -10px;
            top: -9px;
            margin-top: 3px;
            margin-right: 0%;
            background: #ffffff;
            height: 20px;
            width: 20px;
            border-radius: 20px;
            border: 1px solid #c5c5c5;
        }

        .repeating-content {
            margin-bottom: 2px;
            margin-top: 5px;
            border: 1px solid #c5c5c5 !important;
        }

        .repeating-content:nth-child(2n) {
            background: #e0ebf4;
            padding-bottom: 13px;
            margin-left: 0;
            margin-right: 0;
            border-top: 1px solid #e4e4e4;
        }
    </style>
<?php

}
