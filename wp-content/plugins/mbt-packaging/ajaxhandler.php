<?php

namespace packaging;

class AjaxHandler {

    function __construct() {
        add_action('wp_ajax_mbt_get_product_components', array($this, 'mbt_get_product_components'));
        add_action('wp_ajax_mbt_save_package', array($this, 'mbt_save_package'));
        add_action('wp_ajax_check_duplicate_combinations', array($this, 'get_duplicate_combinations'));
        add_action('wp_ajax_delete_group_by_id', array($this, 'delete_group_by_id'));
    }
    public function delete_group_by_id() {
        global $wpdb;
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        $group_id = $_REQUEST['group_id'];
        $package_id = $_REQUEST['package_id'];
        
        $sql_del = "delete from $table_name_products WHERE package_id = $package_id AND group_id = $group_id";
        $wpdb->query($sql_del);
        $arr = array('status'=>'success');
        echo json_encode($arr);
        die();
        

    }
    public function mbt_get_product_components() {
        $p_category = isset($_POST['p_category']) ? $_POST['p_category'] : '';
        $arr_res = array();
        if ($p_category == '') {
            $has_error = true;
            $arr_res['status'] = 'failed';
            $arr_res['message'] = 'Please select a component';
        } else {
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'product',
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $p_category,
                    )
                )
            );

            $posts_array = get_posts(
                    $args
            );
            if (count($posts_array) > 0) {
                $arr_res = array('status' => 'success');
                $str = '<div class="col-lg-3" id="package-' . $p_category . '"><div class="packaging-label">Select component item</div><select name=packaging[' . $p_category . '][component_item]>';
                foreach ($posts_array as $PR) {
                    $str .= '<option value="' . $PR->ID . '"> ' . $PR->post_title . '</option>';
                }
                $str .= '</select> <div class="packaging-label">Quantity</div><input type="number" min="1" name="packaging[' . $p_category . '][component_item_qty]" placehodler="Quantity"> <span class="rem-element" data-pcategory="' . $p_category . '">&#10006;</span></div>';
                $arr_res['options'] = $str;
            }
            wp_reset_postdata();
            $arr_res['status'] = 'success';
            $arr_res['message'] = '';
        }
        echo json_encode($arr_res);
        die();
    }

    public function mbt_save_package() {
        global $MbtPackaging;
        $arr_res = array();
        $group_based_combinations = $_POST['grouped_data'];
        $group_based_combinations = str_replace('\"', '"', $group_based_combinations);
        $group_based_combinations = json_decode($group_based_combinations);

        $group_based_products = array();
        if (is_array($group_based_combinations) && count($group_based_combinations) > 0) {
            $countt = 0;

            foreach ($group_based_combinations as $grp => $combb) {
                if ($combb != '') {
                    $arr = explode('{', $combb);
                    if (count($arr) > 0) {
                        foreach ($arr as $rr) {
                            $str = str_replace('}', '', $rr);
                            $str_exp = explode(',', $str);

                            if (count($str_exp) > 0) {
                                $product_id = '';
                                foreach ($str_exp as $itm) {
                                    if ($itm != '') {
//                                        echo $itm;
//                                        echo '<br />';
                                        $itm_exp = explode(':', $itm);
                                        if ($itm_exp[0] == 'product_id') {
                                            $product_id = $itm_exp[1];
                                        }
                                        if ($itm_exp[0] == 'min_qty') {
                                            $min_qty = $itm_exp[1];
                                        }
                                        if ($itm_exp[0] == 'max_qty') {
                                            $max_qty = $itm_exp[1];
                                        }
                                        if ($itm_exp[0] == 'shipment_level') {
                                            $shipment_level = $itm_exp[1];
                                        }
                                    }
                                }
                                if ($product_id != '') {
                                    //echo $grp.'=>'$product_id.'=>'.$min_qty.'=>'.$max_qty;
                                    $group_based_products[$grp][] = array('product_id' => $product_id, 'min_qty' => $min_qty, 'max_qty' => $max_qty, 'shipment' => $shipment_level);
                                }
                            }
                        }
                    }
                }
            }
        }
//         echo '<pre>';
//         print_r($group_based_products);
//         echo '</pre>';
//         /*
//          * Check duplication at group level
//          */
//         foreach($group_based_products as $pr){
//             
//         }
//         die();
        //print_r($group_based_products);
        $check_validation = array();
        foreach ($group_based_products as $key => $grp) {
            
            foreach ($grp as $dd) {
                $str = '';
               $str .= $key . '|' . $dd['product_id'] . '|' . $dd['shipment'];
              
                if (in_array($str, $check_validation)) {
                    $arr_res['status'] = 'failed';
                    $exploded = explode('|', $str);
                    $grpnum = $key + 1;
                    if($key==0 || $key==''){
                       $arr_res['message'] = 'duplication in new group for product (' . get_the_title($exploded[1]).')';
                    }
                    else{
                        $arr_res['message'] = 'duplication in group ' . $grpnum . ' for product (' . get_the_title($exploded[1]).')';
                    }
                    
                    echo json_encode($arr_res);
                    die();
                } else {
                    $check_validation[] = $str;
                }
            }
//            if (in_array($str, $check_validation)) {
//                $arr_res['status'] = 'failed';
//                $exploded = explode('|', $str);
//                $grpnum = $key + 1;
//                $arr_res['message'] = 'duplication in group ' . $grpnum . 'for product ' . get_the_title($exploded[1]);
//                echo json_encode($res);
//                die();
//            } else {
//                $check_validation[] = $str;
//            }
        }
        
        $package_name = isset($_POST['package_name']) ? $_POST['package_name'] : '';
        $package_desc = isset($_POST['package_desc']) ? $_POST['package_desc'] : '';
        $shipment = isset($_POST['shipment']) ? $_POST['shipment'] : '';
        $packaging = isset($_POST['packaging']) ? $_POST['packaging'] : array();
        $packaging_product = isset($_POST['packaging_product']) ? $_POST['packaging_product'] : array();
        $min_qty = isset($_POST['min_qty']) ? $_POST['min_qty'] : array();
        $max_qty = isset($_POST['max_qty']) ? $_POST['max_qty'] : array();
        if ($package_name == '') {
            $arr_res['status'] = 'failed';
            $arr_res['message'] = 'Package Name is Required';
        } else if (empty($packaging)) {
            $arr_res['status'] = 'failed';
            $arr_res['message'] = 'Please select at least one packaging component';
        } else if (empty($packaging_product) && $package_name != 'Default Package') {
            $arr_res['status'] = 'failed';
            $arr_res['message'] = 'please select at leaset one prodcut';
        } else {
            /* Insert Package */
            global $wpdb;

            $table_name = $wpdb->prefix . 'mbt_packages';
            if (isset($_POST['package_id'])) {
                $table_name_packaging = $wpdb->prefix . 'mbt_packages';
                $table_name_components = $wpdb->prefix . 'mbt_package_components';
                $table_name_products = $wpdb->prefix . 'mbt_package_products';
                $package_id = $_POST['package_id'];
                $data = array('name' => $package_name, 'Desc' => $package_desc, 'shipment' => $shipment);

                $format = array('%s', '%s', '%d');
                $where = array('id' => (int) $package_id);
                $wpdb->update($table_name_packaging, $data, $where, $format);
                $sql_del = "delete from $table_name_components WHERE package_id = $package_id";
                $wpdb->query($sql_del);
                $sql_del = "delete from $table_name_products WHERE package_id = $package_id";
                $message = 'Package is updated successfully';
                $wpdb->query($sql_del);
            } else {
                $data = array('name' => $package_name, 'Desc' => $package_desc, 'shipment' => $shipment);
                $format = array('%s', '%s', '%d');
                $wpdb->insert($table_name, $data, $format);
                $package_id = $wpdb->insert_id;
                //$wpdb->query( $sql_del );
                $message = 'Package is added successfully';
            }

            if (!$package_id) {
                $arr_res['status'] = 'failed';
                $arr_res['message'] = $wpdb->print_error();
            } else {
                /* Insert Package components */
                $table_name = $wpdb->prefix . 'mbt_package_components';
                foreach ($packaging as $key => $val) {
                    $data = array('package_id' => $package_id, 'component_type' => $key, 'component_id' => $val['component_item'], 'component_qty' => $val['component_item_qty']);
                    $format = array('%d', '%s', '%d', '%d');
                    $wpdb->insert($table_name, $data, $format);
                    $inserted_component = $wpdb->insert_id;
                    if (!$inserted_component) {
                        $arr_res['status'] = 'failed';
                        $arr_res['message'] = $wpdb->print_error();
                    }
                }
                /* Insert Package Products */

                $table_name = $wpdb->prefix . 'mbt_package_products';

                if (count($group_based_products) > 0) {
                    foreach ($group_based_products as $key => $comb) {
                        $products_ascending = array();
                        foreach ($comb as $single_comb) {
                            $products_ascending[] = $single_comb['product_id'] . '|' . $single_comb['shipment'];
                        }
                        $products_ascending_re_order = sort($products_ascending);
                        foreach ($comb as $single_comb) {
                            $data = array('package_id' => $package_id, 'group_id' => $key+1, 'product_id' => $single_comb['product_id'], 'qty_min' => $single_comb['min_qty'], 'qty_max' => $single_comb['max_qty'], 'shipment' => $single_comb['shipment'], 'package_products_descending' => implode(',', $products_ascending));
                            $format = array('%d', '%d', '%s', '%d', '%d', '%d', '%s');
                            $wpdb->insert($table_name, $data, $format);
                            $inserted_product = $wpdb->insert_id;
                            if (!$inserted_product) {
                                $arr_res['status'] = 'failed';
                                $arr_res['message'] = $wpdb->print_error();
                            }
                        }
                    }
                }
                foreach ($packaging_product['productid'] as $key => $val) {
                    $products_ascending[] = $val;
                }
                $products_ascending_re_order = sort($products_ascending);
//                foreach ( $packaging_product['productid'] as $key=>$val ) {
//
//                    $data = array( 'package_id' => $package_id, 'product_id' => $val, 'qty_min' => $packaging_product['min_qty'][$key], 'qty_max' =>  $packaging_product['max_qty'][$key], 'package_products_descending'=>implode( ',', $products_ascending ) );
//                    $format = array( '%d', '%s', '%d', '%d', '%s' );
//                    $wpdb->insert( $table_name, $data, $format );
//                    $inserted_product = $wpdb->insert_id;
//                    if ( ! $inserted_product ) {
//                        $arr_res['status'] = 'failed';
//                        $arr_res['message'] = $wpdb->print_error();
//                    }
//                }
                if (isset($arr_res['status']) && $arr_res['status'] == 'failed') {
                    $MbtPackaging->delete_package($package_id);
                }
            }
        }
        if (empty($arr_res)) {

            $arr_res['status'] = 'success';
            $arr_res['message'] = $message;
            $arr_res['redirect_url'] = admin_url('admin.php?page=packaging-dashboard');
        }
        echo json_encode($arr_res);
        die();
    }

    /*
     * Get duplicate Combinations
     */

    public function get_duplicate_combinations() {

        global $wpdb;
        $package_id_current = $_POST['package_id'];
        $group_id_current = $_POST['group_id'];

        $basket_original = $_POST['current_group'];
        $duplicates = [];
        
        if (count($basket_original) > 0) {
            global $wpdb;
            $pp = array_keys($basket_original);
            sort($pp);
            $default_package_id = 78;
            $package_id = 0;
            $basket = implode(',', $pp);
            
//        die();
            $table_name_products = $wpdb->prefix . 'mbt_package_products';
            $sql_query = "SELECT wp_mbt_package_products.*,wp_mbt_packages.name
      FROM wp_mbt_package_products INNER JOIN wp_mbt_packages ON wp_mbt_package_products.package_id=wp_mbt_packages.id WHERE package_products_descending = '$basket'";
            
            $restults = $wpdb->get_results(
                    $wpdb->prepare($sql_query)
            );
            $not_matched = false;
            //print_r($restults);
            if (count($restults) > 0) {
                foreach ($basket_original as $key => $val) {
                    $ex=  explode('|',$key);
                    foreach ($restults as $bsk) {
                        if ($ex[0] == $bsk->product_id) {
                            if ($val < $bsk->qty_min || $val > $bsk->qty_max) {
                                //
                            } else {

                                $package_id = $bsk->package_id;
                                $grp_id = $bsk->group_id;
                                //$grp_id = $grp_id + 1;

                                if ($package_id == $package_id_current && $grp_id == $group_id_current) {

                                    continue;
                                }
                                $duplicates[] = array('package_id' => $package_id, 'package_name' => $bsk->name, 'group_id' => $grp_id);
                            }
                        }
                    }
                }
            }
        }
        //print_r($duplicates);
        // if (count($duplicates) > count($basket_original)) {
        if (count($duplicates) > 0) {
            $message = '';
            foreach ($duplicates as $msg) {
                $message .= 'Package id:' . $msg['package_id'];
                $message .= ', Package name:' . $msg['package_name'];
                $message .= ', Group id:' . $msg['group_id'];
                $message .= ' <br />';
            }
            $res = array('status' => 'error', 'message' => $message);
            echo json_encode($res);
        } else {
            $res = array('status' => 'success');
            echo json_encode($res);
        }
        die();
    }

}

?>