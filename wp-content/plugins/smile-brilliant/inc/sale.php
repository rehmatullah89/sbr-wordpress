<?php
/**
 * Updates the products disabled for coupons based on user input.
 */
function sale_disabled_for_coupons_mbt()
{
    // echo 'kami';
    // echo '<pre>';
    // print_r($_REQUEST['disabled_for_coupons']);
    // echo '</pre>';
    // echo 'kami';
    // die();

    $disabled_products = array();
    if (isset($_REQUEST['disabled_for_coupons']) && count($_REQUEST['disabled_for_coupons']) > 0) {
        foreach ($_REQUEST['disabled_for_coupons'] as $product_id => $val) {
            if ($val == 'on') {
                $disabled_products[] = $product_id;
                $disabled_products = array_unique($disabled_products);
            }
        }
    }
    update_option('_products_disabled_for_coupons', $disabled_products);
}

add_filter('wp_ajax_saveSaleManagement', 'saveSaleManagement_callback');
/**
 * AJAX callback to save sale management information.
 */
function saveSaleManagement_callback()
{


    if (isset($_REQUEST['sbr_sale']) && $_REQUEST['sbr_sale'] == 'on') {
        update_option('sbr_sale', 'yes');
    } else {
        update_option('sbr_sale', 'no');
    }
    if (isset($_REQUEST['sbr_home_sale_page_header'])) {
        update_option('sbr_home_sale_page_header', $_REQUEST['sbr_home_sale_page_header']);
    }
    if (isset($_REQUEST['sbr_sale_page_header'])) {
        update_option('sbr_sale_page_header', $_REQUEST['sbr_sale_page_header']);
    }


    if (isset($_REQUEST['minus_value']) && is_array($_REQUEST['minus_value']) && count($_REQUEST['minus_value']) > 0) {
        foreach ($_REQUEST['minus_value'] as $product_id => $minus_value) {
            update_post_meta($product_id, 'minus_value', $minus_value);
        }
    }
    if (isset($_REQUEST['plus_value']) && is_array($_REQUEST['plus_value']) && count($_REQUEST['plus_value']) > 0) {
        foreach ($_REQUEST['plus_value'] as $product_id => $plus_value) {
            update_post_meta($product_id, 'plus_value', $plus_value);
        }
    }
    if (isset($_REQUEST['bogo_product_id']) && is_array($_REQUEST['bogo_product_id']) && count($_REQUEST['bogo_product_id']) > 0) {
        foreach ($_REQUEST['bogo_product_id'] as $product_id => $bogo_product_id) {
            update_post_meta($product_id, 'bogo_product_id', $bogo_product_id);
        }
    }
    if (isset($_REQUEST['composite_structure']) && is_array($_REQUEST['composite_structure']) && count($_REQUEST['composite_structure']) > 0) {
        foreach ($_REQUEST['composite_structure'] as $product_id => $composite_structure) {
           // updateCompositeProductItems($product_id, $composite_structure);
        }
    }
    $sync_products_arr = [];
    if (isset($_REQUEST['salePrice']) && is_array($_REQUEST['salePrice']) && count($_REQUEST['salePrice']) > 0) {
      
        foreach ($_REQUEST['salePrice'] as $product_id => $sale_price) {
            $productObj = wc_get_product($product_id);
            if ($sale_price) {
                $sale_price = number_format($sale_price, 2);
                $productObj->set_sale_price($sale_price);
            } else {
                $productObj->set_sale_price('');
            }
            $productObj->save(); // Save to database and sync
            if (isset($_REQUEST['disabled_for_coupons'][$product_id])) {
                update_post_meta($product_id, '_disabled_for_coupons', 'yes');
                //  $productObj->update_meta_data('_disabled_for_coupons', 'yes');
            } else {
                update_post_meta($product_id, '_disabled_for_coupons', 'no');
                // $productObj->update_meta_data('_disabled_for_coupons', 'no');
            }

            if (isset($_REQUEST['sale_page'][$product_id])) {
                update_field('sale_page', '1', $product_id);
                //$productObj->update_meta_data('sale_page', 1);
            } else {
                // $productObj->update_meta_data('sale_page', 0);
                update_field('sale_page', '0', $product_id);
            }
            if (isset($_REQUEST['sale_page_geha'][$product_id])) {
                update_field('sale_page_geha', '1', $product_id);
                //   $productObj->update_meta_data('sale_page_geha', 1);
            } else {
                update_field('sale_page_geha', '0', $product_id);
                //   $productObj->update_meta_data('sale_page_geha', 0);
            }
            $sync_products_arr[]=$product_id;
        }
       
    }
    sale_disabled_for_coupons_mbt();
    sync_sale_products_only($sync_products_arr);
    echo 'Information Updated';
    die;
}



add_filter('wp_ajax_loadSaleProducts', 'loadSaleProducts_callback');
/**
 * AJAX callback to load sale products.
 */
function loadSaleProducts_callback()
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
        $orderType = 'DESC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        $order_start_date = $_GET["startDate"]; //Paging first record indicator.
        $order_end_date = $_GET["endDate"]; //Paging first record indicator.
        $searchQuery = " ";
        $searchDateQuery = " ";
        $modified_data = array();
        $rawPrdoucts = array();
        if (!empty($_GET['search']['value'])) {
        }



        $tax_query = array(
            'relation' => 'AND'
        );

        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array('raw', 'packaging', 'landing-page', 'data-only'),
            'operator' => 'NOT IN',
        );
/*
        $tax_query[] =  array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'composite',
        );
*/
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => $tax_query,
        );



        $compositePrdoucts = get_posts($args);
        foreach ($compositePrdoucts as  $product_id) {
            $productObj = wc_get_product($product_id);
            $entry = array();


            $cartHtml = '';
            foreach ((get_the_terms($product_id, 'product_cat')) as $category) {
                if ($category->slug == 'addon') {
                    $cartHtml = ' - <div class="saleCategory" >' . $category->name . '</div>';
                }
            }
            $title = '<a href="' . get_edit_post_link($product_id) . '" target="_blank">' . $productObj->get_title() . '</a>';
            $entry[] =  $productObj->get_id();
            $entry[] =  $title . $cartHtml;
            $entry[] =  $productObj->get_price_html();
            $salePrice = '';
            if((int)$productObj->get_sale_price()){
                $salePrice = ' value="' . number_format((int)$productObj->get_sale_price(), 2) . '" ';
            }
            $entry[] =  '<input autocomplete="off" class="product_sale_entry" type="number" name="salePrice[' . $product_id . ']"  '.$salePrice.'/>';
            
            //$entry[] =  '<input autocomplete="off" class="product_sale_entry" type="number" name="salePrice[' . $product_id . ']" value="' . number_format((float)$productObj->get_sale_price(), 2) . '" />';
            $checked = '';
            $disabled_for_coupons = $productObj->get_meta('_disabled_for_coupons');
            if ($disabled_for_coupons === 'yes') {
                $checked = 'checked=""';
            }
            $entry[] = ' <input autocomplete="off" type="checkbox" class="product_entry" ' . $checked . ' name="disabled_for_coupons[' . $product_id . ']" />';
            $checked = '';
            $sale_page = $productObj->get_meta('sale_page');
            if ($sale_page) {
                $checked = 'checked=""';
            }
            $entry[] = ' <input autocomplete="off" type="checkbox"  ' . $checked . ' name="sale_page[' . $product_id . ']" />';
            $checked = '';
            $sale_page_geha = $productObj->get_meta('sale_page_geha');
            if ($sale_page_geha) {
                $checked = 'checked=""';
            }
            $entry[] = ' <input autocomplete="off" type="checkbox" ' . $checked . ' name="sale_page_geha[' . $product_id . ']" />';



            $minus_value = (int) get_post_meta($product_id, 'minus_value', true);
            $plus_value = (int) get_post_meta($product_id, 'plus_value', true);
            $bogo_product_id =  get_post_meta($product_id, 'bogo_product_id', true);
            $entry[] = ' <input autocomplete="off" type="text"  name="bogo_product_id[' . $product_id . ']" value="' . $bogo_product_id . '" />';
            $entry[] = ' <input autocomplete="off" type="text"  name="minus_value[' . $product_id . ']" value="' . $minus_value . '" />';
            $entry[] = ' <input autocomplete="off" type="text"  name="plus_value[' . $product_id . ']" value="' . $plus_value . '" />';

            $old_checked = ''; // Initialize the "Old" radio button as unchecked by default
            $new_checked = ''; // Initialize the "New" radio button as unchecked by default


            $bto_data =  get_post_meta($product_id, '_bto_data', true);
            // Check if you have post meta values to determine which radio button should be checked
            if ($bto_data) {
                $old_checked = 'checked';
            } else {
                $new_checked = 'checked';
            }


            // Add the radio buttons with labels "Old" and "New"
            $entry[] = ' <label for="old_radio">Old</label>
                        <input autocomplete="off" type="radio" id="old_radio" name="composite_structure[' . $product_id . ']" value="old" ' . $old_checked . ' />
                        <label for="new_radio">New</label>
                        <input autocomplete="off" type="radio" id="new_radio" name="composite_structure[' . $product_id . ']" value="new" ' . $new_checked . ' />';

            $modified_data[] = $entry;
        }
        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($compositePrdoucts),
            "iTotalDisplayRecords" => count($compositePrdoucts),
            "data" => $modified_data
        );
        echo json_encode($results);
    }
    die;
}


/**
 * Enqueues necessary scripts and styles, and renders the sale management form.
 *
 * @return void
 */
function sbr_productSaleManagement()
{

    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    wp_enqueue_script('dataTables_buttons', 'https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js', array('dataTables'), true);

    $sbr_sale =   get_option('sbr_sale');
    $saleCB = '';
    if ($sbr_sale == "yes") {
        $saleCB = 'checked=""';
    }
    $home_header =  get_option('sbr_home_sale_page_header');
    $sale_header =  get_option('sbr_sale_page_header');
    // $emails = WC()->mailer()->get_emails();
    // $respose =   $emails['WC_RDH_Register_Email']->trigger(2);
?>

    <form id="saleManagement">
        <div class="search-shipement">
            <h3>Sale management<span class="dashicons dashicons-cart"></span> </h3>
            <div class="shipment-inner-container">
                <div class="flex-row">
                    <div class="col-sm-12 hr-seprator">
                        <h4>Sale Actions</h4>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input id="saleSwitch" type="checkbox" name="sbr_sale" class="saleSwitch-input" autocomplete="off" <?php echo $saleCB; ?>>
                                <label class="custom-control-label" for="saleSwitch">Sale Enable/Disable.</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Sale sync status with nest:</strong> <? echo get_option('sale_products_synced',true).'<br />'.get_option('sale_products_sync_failed',true);?> <br />
                            
                            <label class="custom-control-label" for="saleSwitch">Homepage Sale Banner </label>
                            <select name="sbr_home_sale_page_header" autocomplete="off">
                                <?php
                                echo '<option value="0">Default</option>';
                                $files = list_files(get_stylesheet_directory() . '/inc/templates/sale/home', 2);
                                foreach ($files as $file) {
                                    if (is_file($file)) {
                                        $filename = basename($file);
                                        if ($home_header == $filename) {
                                            echo '<option value="' . $filename . '" selected="">' . $filename . '</option>';
                                        } else {
                                            echo '<option value="' . $filename . '">' . $filename . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="custom-control-label" for="saleSwitch">Sale Page Banner </label>
                            <select name="sbr_sale_page_header" autocomplete="off">
                                <?php
                                echo '<option value="0">Default</option>';
                                $files = list_files(get_stylesheet_directory() . '/inc/templates/sale/sale-page', 2);
                                foreach ($files as $file) {
                                    if (is_file($file)) {
                                        $filename = basename($file);
                                        if ($sale_header == $filename) {
                                            echo '<option value="' . $filename . '" selected="">' . $filename . '</option>';
                                        } else {
                                            echo '<option value="' . $filename . '">' . $filename . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="button" id="btnProductSale" class="button" value="Save Changes">
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <div class="loading-sbr" style="display: none;">
            <div class="inner-sbr"></div>
        </div>

        <table id="sale" class="data-table" style="width:99%">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Sale Price
                        <br />
                        <input type="button" id="datatableCheckAllSale" class="button" value="Reset All Sale Prices">
                    </th>
                    <th>Disabled Coupons
                        <!-- <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input" autocomplete="off">
                                    <label class="custom-control-label" for="datatableCheckAll">Disabled for all coupons</label>
                                </div>
                            </div> -->
                    </th>
                    <th>Sale Page</th>
                    <th>Geha Sale Page</th>
                    <th>BOGO Product ID</th>
                    <th>Experiment Up Variant</th>
                    <th>Experiment Down Variant</th>
                    <th>Composite Structure</th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        <input type="hidden" name="action" value="saveSaleManagement">
    </form>
    <style>
        /* .shipment-inner-container {
                display: none;
            } */

        table.dataTable tbody tr {
            background-color: #fff;
            text-align: center;
        }

        .saleCategory {
            display: inline-block;
            vertical-align: top;
            box-sizing: border-box;
            margin: 1px 0 -1px 2px;
            padding: 0 5px;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            background-color: #d63638;
            color: #fff;
            font-size: 11px;
            line-height: 1.6;
            text-align: center;
            z-index: 26;
        }
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Check all 

            jQuery('#datatableCheckAllSale').click(function() {
                console.log('datatableCheckAllSale')
                jQuery('.product_sale_entry').val('');
            });
            jQuery('#datatableCheckAll').click(function() {
                if (jQuery(this).is(':checked')) {
                    jQuery('.product_entry').prop('checked', true);
                } else {
                    jQuery('.product_entry').prop('checked', false);
                }
            });
            jQuery(document).on('change', '.product_entry', function(e) {
                checkcheckbox();
            });
            // Checkbox checked
            function checkcheckbox() {

                // Total checkboxes
                var length = jQuery('.product_entry').length;
                // Total checked checkboxes
                var totalchecked = 0;
                jQuery('.product_entry').each(function() {
                    if (jQuery(this).is(':checked')) {
                        totalchecked += 1;
                    }
                });
                // Checked unchecked checkbox
                if (totalchecked) {
                    jQuery("#datatableCheckAll").prop('checked', true);
                } else {
                    jQuery('#datatableCheckAll').prop('checked', false);
                }
            }

            var datatable = jQuery('#sale').DataTable({
                "ordering": false,
                "searching": true,
                "bPaginate": false,
                "dom": "Bfrtip",
                "processing": true,
                "serverSide": false,
                "clientSide": true,
                "ajax": {
                    url: "<?php echo admin_url('admin-ajax.php?action=loadSaleProducts'); ?>",
                    type: "GET",
                    "data": function(d) {

                    },
                    "complete": function(response) {
                        jQuery('.loading-sbr').hide();
                    }

                },
            });

            jQuery('body').on('click', '#btnProductSale', function(e) {
                var swaltext = 'Please make sure everything before save sale prices and coupon options.';
                Swal.fire({
                    title: 'Are you sure?',
                    text: swaltext,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('.loading-sbr').show();
                        e.preventDefault();
                        var elementT = document.getElementById("saleManagement");
                        var formdata = new FormData(elementT);
                        jQuery.ajax({
                            url: ajaxurl,
                            data: formdata,
                            async: true,
                            method: 'POST',
                            ///     dataType: 'JSON',
                            success: function(response) {

                                jQuery('.loading-sbr').hide();
                                datatable.ajax.reload();
                                //Swal.fire('Updated Successfully', 'success');

                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });

        });
    </script>
<?php
}
