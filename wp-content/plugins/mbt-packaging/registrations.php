<?php
/*
  Class to register pages and enquing scripts
 */

namespace packaging;

class MbtRegistations
{

    public $ConfigMb;

    function __construct($ConfigMbtt)
    {
        $this->ConfigMb = $ConfigMbtt;
        add_action('admin_enqueue_scripts', array($this, 'mbtPackagingScripts'));
        add_action('admin_menu', array($this, 'wpdocs_register_my_custom_menu_page'));
    }

    public function mbtPackagingScripts()
    {
        wp_enqueue_style('mbt-packaging', plugins_url('/assets/css/style.css', __FILE__), array(), null, 'all');
        wp_enqueue_style('mbt-packagingselect2', plugins_url('/woocommerce/assets/css/select2.css'), array(), null, 'all');
        //wp_enqueue_style( 'mbt-packagingselect2', plugins_url( '/advanced-custom-fields/assets/inc/select2/4/select2.min.css'), array(), null, 'all' );
        // wp_enqueue_style('mbt-packagingselect2js', plugins_url('/woocommerce/assets/js/select2/select2.full.min.js'), array('jquery'), null, 'all');
        wp_enqueue_script('select2');
        $my_current_screen = get_current_screen();
        if (!in_array($my_current_screen->base, array('admin_page_sbr_ims'))) {
            wp_enqueue_script('mbt-packaging-js', plugins_url('/assets/js/scripts.js', __FILE__), array('jquery'), time(), true);
        }
    }

    public function wpdocs_register_my_custom_menu_page($ConfigMbt)
    {
        add_menu_page('Mbt Packaging', 'Packaging', 'manage_options', 'packaging-dashboard', array($this, 'mbt_all_packages'));
        add_submenu_page('packaging-dashboard', 'Add New Package', 'New Package', 'manage_options', 'new-package', array($this, 'mbt_packaging_dashboard'));
    }

    public function mbt_all_packages()
    {

        $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

        <div class='packaging-system-form'>
            <h2>All Packages</h2>
            <div class='container'>
                <?php
                global $MbtPackaging;
                //        $basket  = array( '130259'=>'7' );
                //        $results = $MbtPackaging->get_package_ids_for_basket( $basket );
                //        print_r($results);
                if (isset($_GET['package_id'])) {
                    $MbtPackaging->delete_package($_GET['package_id']);
                }
                $package_components = $MbtPackaging->get_all_packages_withComponents();
                if (count($package_components) > 0) {
                    $add_packages = array();
                    echo '<div class="head_contanier"> <div class="label-link"><strong>Package Name</strong></div><div class="info-link">  <strong>View </strong></div><div class="info-link"> <strong> Edit</strong></div> <div class="info-link"> <strong>  Delete</strong></div></div>';
                    foreach ($package_components as $package_component) {

                        if (!in_array($package_component->package_id, $add_packages)) {
                            $add_packages[] = $package_component->package_id;
                            if (count($add_packages) != 0) {
                                echo '</div></div>';
                            }
                            echo '<div class="package_contanier"><span class="arrow-mbt-up"></span>';

                            echo '<div class="label-link"><strong><a href="javascript:void(0);" class="pacakge_component_heading">' . $package_component->name . ' </a></strong></div><div class="info-link viewlink"><a    href="javascript:void(0);" class="pacakge_component_heading"> <span class="dashicons dashicons-visibility"></span> </a></div><div class="info-link"><a href="' . menu_page_url('new-package', false) . '&package_id=' . $package_component->package_id . '"> <span class="dashicons dashicons-edit-page"></span></a></div> <div class="info-link"><a class="remove-package" data-href="' . $current_url . '&package_id=' . $package_component->package_id . '" href="javascript:void(0);"> <span class="dashicons dashicons-trash"></span> </a></div> <div class="package_components">';
                            $package_products = $MbtPackaging->get_all_packages_products($package_component->package_id, $this->ConfigMb, false);
                            echo '<h3>Products</h3><div class="component_product">';
                            foreach ($package_products as $package_product) {
                                echo '<div class="component-item-product"><strong>product Name:</strong> ' . get_the_title($package_product->product_id) . ' <strong>Min Quantity:</strong> ' . str_replace('-', ' ', $package_product->qty_min) . ' <strong>Max Quantity:</strong> ' . str_replace('-', ' ', $package_product->qty_max) . '</div>';
                            }
                            echo '</div>';
                            echo '<h3>Components</h3>';
                        }
                        // if ( count( $add_packages ) == 1 ) {
                        //     echo '<h3>Components</h3>';
                        // }
                        echo '<div class="component-item"><strong>Component Name:</strong> ' . str_replace('-', ' ', $package_component->component_type) . ' <strong>Component Quantity:</strong> ' . str_replace('-', ' ', $package_component->component_qty) . '</div>';
                        if (!in_array($package_component->package_id, $add_packages)) {
                            echo '</div></div>';
                        }
                    }
                } else {
                    echo '<h3>No Record Found Please Add some Packages</h3>';
                }
                echo '</div>';
                // print_r( $add_packages );
                ?>
            </div>
        </div>
    <?php
    }

    public function mbt_packaging_dashboard()
    {
        global $MbtPackaging;
        $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
        <div class="loading-sbr">
            <div class="inner-sbr"></div>
        </div>
        <div class='overlay'></div>
        <div class='packaging-system-form packing-mbt-container-style'>
            <h2>PACKAGE MANAGEMENT</h2>
            <div class='initital-content' style='display:none'>
                <input type="hidden" name="group_id[]" value="1">
                <div class='repeating-content row-admin'>
                    <div class='remove-itm'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-trash"></span></a></div>
                    <div class='col-md-3'>
                        <div class='packaging-label label-comn'>Select Products</div>
                        <select name='packaging_product[productid][]' class='packaging-product sellect2'>
                            <?php
                            $new_array = $this->ConfigMb['pterms'];
                            array_push($new_array, "raw", "packaging", "landing-page", "data-only");
                            $args = array(
                                'posts_per_page' => -1,
                                'post_type' => 'product',
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'slug',
                                        'operator' => 'NOT IN',
                                        'terms' => $new_array,
                                    )
                                )
                            );

                            $posts_array = get_posts(
                                $args
                            );
                            if (count($posts_array) > 0) {
                                foreach ($posts_array as $PR) {
                                    $obj = $_product = wc_get_product($PR->ID);
                                    $term_list = wp_get_post_terms($PR->ID, 'type', array('fields' => 'names'));

                                    $term_name = isset($term_list[0]) ? $term_list[0] : '';
                                    $sku = $obj->get_sku();
                                    $skuString = '';
                                    if ($sku != '') {
                                        $skuString = ' (' . $sku . ')';
                                    }
                                    echo '<option value="' . $PR->ID . '"> ' . $PR->post_title . $skuString . ' ' . $term_name . '</option>';
                                }
                            }
                            //  echo json_encode($arr_res);
                            ?>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <div class='packaging-label'>Min Qty</div>
                        <input type='number' min='1' value='1' max='1' class="min_qty" name='packaging_product[min_qty][]'>

                    </div>
                    <div class='col-md-2'>
                        <div class='packaging-label'>Max Qty</div>
                        <input type='number' min='1' value='1' class="max_qty" name='packaging_product[max_qty][]'>

                    </div>
                    <div class='col-md-2'>
                        <div class='packaging-label'>Shipment</div>
                        <select class='shipment_level' name='packaging_product[shipment_level][]'>
                            <option value='1'>First/Default</option>
                            <option value='2'>Second</option>
                        </select>


                    </div>
                </div>
            </div>

            <form action="<?php echo $current_url; ?>" method='post' id='submitpackage'>
                <input type='hidden' name='action' value='mbt_save_package'>
                <script>
                    var default_package = false;
                </script>
                <?php
                $package_name = '';
                $package_desc = '';
                $shippment = 1;
                if (isset($_GET['package_id'])) {
                    $package_info = $MbtPackaging->get_package_info_by_id($_GET['package_id']);
                    // print_r( $package_info );
                    $package_name = $package_info[0]->name;
                    $package_desc = $package_info[0]->Desc;
                    $shippment = $package_info[0]->shipment;
                    if ($package_name == 'Default Package') {
                        echo '<script> var default_package=true;</script>';
                    } else {
                        echo '<script> var default_package=false;</script>';
                    }
                ?>
                    <input type='hidden' name='package_id' value='<?php echo $_GET['package_id']; ?>'>
                <?php
                }
                ?>

                <div class='title'>
                    <i class='fas fa-pencil-alt'></i>

                    <?php //AjaxHandler::add_packaging_combination_by_package_id(72,array('130265'=>array('min'=>'1','max'=>2),'428548'=>array('min'=>'3','max'=>'4'))); 
                    ?>
                </div>


                <div class="package-box-container package-mbt-container">

                    <div class="flex-row-admin mb-15">
                        <div class="right-section">
                            <div class="package-description">
                                <div class='packaging-label label-comn'>Package Description</div>
                                <textarea name='package_desc'><?php echo $package_desc; ?></textarea>
                            </div>
                            <div class="col-sm-4-full">
                                <br />
                                <div class="flex-row align-item-center no-gutter">
                                    <input type="radio" id="first_shipment" name="shipment" value="1" <?php
                                                                                                        if ($shippment == 1) {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                        ?>>
                                    <label for="first_shipment">Default/First Shipment</label>&nbsp; &nbsp;
                                    <input type="radio" id="second_shipment" name="shipment" value="2" <?php
                                                                                                        if ($shippment == 2) {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                        ?>>
                                    <label for="second_shipment">Second Shipment</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="left-section">

                            <div class='info'>
                                <div class="package-name">
                                    <div class='packaging-label label-comn'>Package Name</div>
                                    <input type='text' name='package_name' value='<?php echo $package_name; ?>'>
                                </div>
                            </div>

                            <div class="package-box">

                                <div class='packaging-label label-comn'>Select packaging Box</div>

                                <?php $pterms = $this->ConfigMb['pterms'];
                                ?>

                                <select name='packaging_box[]' id='all-components'>
                                    <option value=''>Select</otpion>
                                        <?php
                                        foreach ($pterms as $ptrm) {
                                            echo '<option value=' . $ptrm . '>' . ucwords(str_replace('-', ' ', $ptrm)) . '</option>';
                                        }
                                        ?>

                                </select>

                            </div>
                        </div>
                    </div>

                    <div class='component-items'>
                        <span class='spinner' style='float:left' id='spinner-mbt-admin'></span>

                        <?php
                        if (isset($_GET['package_id'])) {
                            echo $MbtPackaging->get_package_components_by_id($_GET['package_id'], true);
                        }
                        ?>


                    </div>
                    <div class='add-more-group'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-images-alt2"></span> Add Group</a></div>
                    <input type="hidden" class="append-grp-data" name="grouped_data">
                    <?php
                    if (isset($_GET['package_id'])) {
                        $results = $MbtPackaging->get_package_groups_by_package_id($_GET['package_id']);
                        if (count($results) > 0) {
                            $counter = 1;
                            foreach ($results as $res) {
                                if ($counter == 1) {
                                    $repclass = 'initial-reapeater';
                                } else {
                                    $repclass = '';
                                }
                    ?>
                                <div class='repeater <?php echo $repclass; ?>'>
                                    <div class='check-grp' data-package_id="<?php echo $_GET['package_id']; ?>" data-group_id="<?php echo $counter; ?>"><a href='javascript:void(0);' class='btn button'> ? </a></div>
                                    <div class='remove-grp'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-trash"></span></a></div>
                                    <input type="hidden" name="group_id[]" class="group_id" value="<?php echo $counter; ?>">
                                    <div class='add-more'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-welcome-add-page"></span> Add Products</a></div>
                                    <span class="groupid"> Group: #<?php echo $res->group_id; ?></span>
                                    <?php
                                    if (isset($_GET['package_id'])) {

                                        echo $MbtPackaging->get_all_packages_products($_GET['package_id'], $this->ConfigMb, true, $res->group_id);
                                    }
                                    if (isset($_GET['order_id'])) {
                                        echo $MbtPackaging->get_all_order_products($_GET['order_id'], $this->ConfigMb);
                                    } else if (isset($_GET['product'])) {
                                        echo $MbtPackaging->get_all_order_products_byid($this->ConfigMb);
                                    }
                                    ?>

                                </div>
                        <?php
                                $counter++;
                            }
                        }
                    } else {
                        ?>
                        <div class='repeater initial-reapeater'>

                            <div class='remove-grp'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-trash"></span></a></div>
                            <input type="hidden" name="group_id[]" class="group_id" value="1">
                            <div class='add-more'><a href='javascript:void(0);' class='btn button'> <span class="dashicons dashicons-welcome-add-page"></span> Add Products</a></div>
                            <?php
                            if (isset($_GET['package_id'])) {

                                echo $MbtPackaging->get_all_packages_products($_GET['package_id'], $this->ConfigMb, true, $res->group_id);
                            }
                            if (isset($_GET['order_id'])) {
                                echo $MbtPackaging->get_all_order_products($_GET['order_id'], $this->ConfigMb);
                            } else if (isset($_GET['product'])) {
                                echo $MbtPackaging->get_all_order_products_byid($this->ConfigMb);
                            }
                            ?>

                        </div>
                    <?php
                    }
                    ?>


                    <div class="add-package-fixed-button"><button type='submit' href='/' name='add-package' class='package-submit-btn btn btn-danger button'>Submit</button></div>
                    <script type="text/javascript">
                        var siteUrl = '<?= get_site_url(); ?>';
                    </script>




                </div>
        </div>





        </form>
        </div>
<?php
    }
}
