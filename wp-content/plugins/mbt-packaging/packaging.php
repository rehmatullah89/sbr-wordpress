<?php

/*
  Plugin Name: MBT Packaging System
  Plugin URI: https://www.mindblaze.net/
  Description: Packaging system for woocomemrce
  Author: Kamran Ashraf
  Author URI: https://www.mindblaze.net/
  Version: 1.0.0
 */

 /*
 test commit
 */
$ConfigMbt = array(
    'activation_key' => 'cd64539dd19283cdcc637f2ccddcd45-us6',
    'packaging_root_path' => WP_PLUGIN_DIR . '/mbt-packaging',
    'packaging_root_url' => WP_PLUGIN_URL . '/mbt-packaging',
    'pterms' => array('boxes', 'bubble-mailer', 'envelope', 'thermal-postage-label'),
);
global $MbtPackaging;
global $pconfiguration;
$pconfiguration = $ConfigMbt;
require_once($ConfigMbt['packaging_root_path'] . '/bootstrap.php');

use packaging\MbtRegistations;
use packaging\AjaxHandler;

class MbtPackaging
{

    private $activation_key;
    private $AjaxHandler;
    public $packageId;

    function __construct($ConfigMbt)
    {
        $this->activation_key = $ConfigMbt['activation_key'];
        $this->registrations = new MbtRegistations($ConfigMbt);
        $this->AjaxHandler = new AjaxHandler($ConfigMbt);
        register_activation_hook(__file__, array($this, 'mbt_packaging_installer'));
        add_action('admin_head', array($this, 'remove_content_editor_mbt'), 10, 1);
        if (isset($_GET['check_dup'])) {
            $this->get_duplicate_combinations($package_id = 72, $components = array('130265' => array('min' => '1', 'max' => 2), '428548' => array('min' => '4', 'max' => '5')));
            die();
        }
        // $this->get_duplicate_combinations();
        //add_action( 'init', array( $this, 'mbt_packaging_installer' ) );
    }

    /* Get Package based on product id's and quantities */
    public function get_package_ids_for_basket($basket_original = array(), $shipment = 1)
    {
        foreach ($basket_original as $key => $product) {
            $product_id = $product['product_id'];
            if( $product_id == SHIPPING_PROTECTION_PRODUCT ){
                /*
            check for shipping protection
            */
                    unset($basket_original[$key]);
                    /*
            check end for shipping protection
            */
            }
        }
       
        $response = [];
        $modified_array = array();
        //        print_r($basket_original);
        // echo '<pre>';
        // print_r($basket_original);
        // echo '</pre>';
        if (count($basket_original) > 0) {
            global $wpdb;
            $products = array();
            foreach ($basket_original as $bas) {
                $modified_array[$bas['product_id'] . '|' . $bas['level']] = $bas['qty'];
                $products[] = $bas['product_id'];
            }
            $pp = array_keys($modified_array);
            sort($pp);
            $default_package_id = 78;
            $package_id = 0;
            $basket = implode(',', $pp);
            $matchCased = array();
            $response['status'] = 0;
            $table_name_products = $wpdb->prefix . 'mbt_package_products';
            /*
           $sql_query = "SELECT *
      FROM wp_mbt_package_products INNER JOIN wp_mbt_packages ON wp_mbt_package_products.package_id=wp_mbt_packages.id WHERE wp_mbt_packages.shipment=$shipment AND package_products_descending = '$basket'"; */
            $sql_query = "SELECT *
      FROM wp_mbt_package_products INNER JOIN wp_mbt_packages ON wp_mbt_package_products.package_id=wp_mbt_packages.id WHERE package_products_descending = '$basket'";
            $restults = $wpdb->get_results(
               $sql_query
            );

            $sortedCombination = array();
            $matchRecords = 0;

            //echo '<pre>';
            //print_r($restults);
            //echo '</pre>';
            if (count($restults) > 0) {
                foreach ($basket_original as  $val) {
                    $iterration_level_matched = 0;
                    foreach ($restults as $bsk) {
                        if ($val['product_id'] == $bsk->product_id) {
                            if ($val['qty'] < $bsk->qty_min || $val['qty'] > $bsk->qty_max) {
                                $response['status'] = 0;
                                $response['message'] = 'no package found';
                                //   break;
                            } else {
                                //      $response['status'] = 1;
                                //     $response['package_id'] = $bsk->package_id;
                                $package_id_db = $bsk->package_id;
                                $group_id_db = $bsk->group_id;
                                $matchCased[$package_id_db][$group_id_db][] = $bsk;
                                //  $iterration_level_matched++;

                            }
                        }
                    }
                }
                //    echo $iterration_level_matched.'----' .count($restults);
                //    if ($matchCased > 0 && $iterration_level_matched == count($restults)) {
                if ($matchCased > 0) {
                    foreach ($matchCased as $p__id => $group__detail) {
                        foreach ($group__detail as $group__id => $group__info) {
                            if (count($group__info) == count($basket_original)) {
                                $sortedCombination[$p__id][$group__id] = $group__info;
                                $matchRecords++;
                                $response['package_id'] = $p__id;
                                $response['group__id'] = $group__id;
                                $response['status'] = 1;
                            }
                        }
                    }
                } else {
                    $response['status'] = 0;
                    $response['package_id'] = 0;
                    $response['message'] = 'no package found';
                }
            } else {
                $response['status'] = 0;
                $response['package_id'] = 0;
                $response['message'] = 'no package found';
            }
            // return $response;
            if ($response['package_id'] == 0) {
                return $response;
            } else {
              //  echo '<pre>';
              //  print_r($sortedCombination);
              //  echo '</pre>';
                if ($matchRecords > 1) {
                    $response['status'] = 0;
                    $response['combinations'] = $sortedCombination;
                    $response['combinations_data'] = $sortedCombination;
                    $response['message'] = 'Duplicate Combination found.';
                    return $response;
                } else {
                    $result = $this->check_package_inventory($response['package_id'], $shipment);
                    $success = $result['status'];
                    if ($success) {
                        $response['status'] = 1;
                        $response['combinations_data'] = $sortedCombination;
                        $response['package_id'] = $response['package_id'];
                        $response['group__id'] = $response['group__id'];
                        return $response;
                    } else {
                        $response['status'] = 0;
                        $response['message'] = $result['message'];
                        return $response;
                    }
                }
            }
        } else {
            $response['status'] = 0;
            $response['message'] = 'no package found';
            return $response;
        }
    }

    public function get_package_ids_for_basket_backup_preVersion($basket_original = array(), $shipment = 1)
    {
        $response = [];
        $modified_array = array();
        //        print_r($basket_original);
        if (count($basket_original) > 0) {
            global $wpdb;

            foreach ($basket_original as $bas) {
                $modified_array[$bas['product_id'] . '|' . $bas['level']] = $bas['qty'];
            }
            $pp = array_keys($modified_array);
            sort($pp);
            $default_package_id = 78;
            $package_id = 0;
            $basket = implode(',', $pp);

            //        die();
            $table_name_products = $wpdb->prefix . 'mbt_package_products';
            /*
           $sql_query = "SELECT *
      FROM wp_mbt_package_products INNER JOIN wp_mbt_packages ON wp_mbt_package_products.package_id=wp_mbt_packages.id WHERE wp_mbt_packages.shipment=$shipment AND package_products_descending = '$basket'"; */
            $sql_query = "SELECT *
      FROM wp_mbt_package_products INNER JOIN wp_mbt_packages ON wp_mbt_package_products.package_id=wp_mbt_packages.id WHERE package_products_descending = '$basket'";
            $restults = $wpdb->get_results(
               $sql_query
            );
            $not_matched = false;
            //print_r($restults);
            if (count($restults) > 0) {
                foreach ($basket_original as $key => $val) {
                    foreach ($restults as $bsk) {
                        if ($val['product_id'] == $bsk->product_id) {
                            if ($val['qty'] < $bsk->qty_min || $val['qty'] > $bsk->qty_max) {
                                $not_matched = true;
                                $response['status'] = 0;
                                $response['message'] = 'no package found';
                                // break;
                            } else {
                                $not_matched = false;
                                $package_id = $bsk->package_id;
                                $response['status'] = 1;
                                $response['package_id'] = $package_id;

                                break;
                            }
                        }
                    }
                }
            } else {
                $not_matched = true;
                $response['status'] = 0;
                $response['message'] = 'no package found';
            }
            if ($not_matched) {
                // return $default_package_id;
                return $response;
                //return false;
            } else {
                $result = $this->check_package_inventory($package_id, $shipment);
                $success = $result['status'];
                if ($success) {
                    $response['status'] = 1;
                    $response['package_id'] = $package_id;
                    return $response;
                    //return  $package_id;
                } else {
                    $response['status'] = 0;
                    $response['message'] = $result['message'];
                    return $response;
                    //return false;
                }
            }
        } else {
            $response['status'] = 0;
            $response['message'] = 'no package found';
            return $response;
            //return false;
        }
    }

    public function get_package_info_by_id($package_id)
    {
        global $wpdb;
        try {
            $table_name_packaging = $wpdb->prefix . 'mbt_packages';
            $table_name_components = $wpdb->prefix . 'mbt_package_components';
            $table_name_products = $wpdb->prefix . 'mbt_package_products';
            $sql_query = "select * from  $table_name_packaging where id=$package_id";

            $restults = $wpdb->get_results($sql_query);
                //$wpdb->prepare($sql_query)
            //);
            return $restults;
        } catch (Exception $e) {
            return $e->get_message();
        }
    }

    public function get_all_order_products($order_id, $ConfigMb)
    {
        global $wpdb;
        $new_array = $ConfigMb['pterms'];
        $orderproducts =  array();
        array_push($new_array, "raw", "packaging", "landing-page", "data-only");

        $order = wc_get_order($order_id);
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
        $html = '';
        $partial_shipped_items =  getRemainOrderItemsQty($order_id);
        $all_items = $order->get_items();

        foreach ($order->get_items() as $item_id => $item) {

            // Get an instance of corresponding the WC_Product object
            $product = $item->get_product();
            $product_id = $product->get_id();
            if (is_array($partial_shipped_items) && count($partial_shipped_items) > 0) {

                if (!array_key_exists($product_id, $partial_shipped_items)) {
                    continue;
                }
            }
            $pterms = wc_get_product_terms($product_id, 'product_cat');
            $continueFlag = false;
            foreach ($pterms as $tr) {
                $name = $tr->name;
                if ($name == 'Raw Materials') {
                    $continueFlag = true;
                    break;
                }
            }
            if ($continueFlag) {
                continue;
            }
            $active_price = $product->get_price(); // The product active raw price
            $regular_price = $product->get_sale_price(); // The product raw sale price
            $sale_price = $product->get_regular_price(); // The product raw regular price
            $product_name = $item->get_name(); // Get the item name (product name)

            $item_quantity = $item->get_quantity(); //


            if (array_key_exists($product_id, $orderproducts)) {
                // echo $item_quantity;
                // echo '<br />';
                $existing_qty = $orderproducts[$product_id];
                $new_qty = $item_quantity + $existing_qty;
                $orderproducts[$product_id] = $new_qty;
            } else {
                $orderproducts[$product_id] = $item_quantity;
            }
            if (is_array($partial_shipped_items) && count($partial_shipped_items) > 0) {
                $item_quantity = $partial_shipped_items[$product_id];
            }
        }

        foreach ($orderproducts as $product_id => $item_quantity) {
            $html .= '<div class="repeating-content">
            <div class="remove-itm"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-trash"></span></a></div>';
            $html .= "<div class='col-md-3'>
                <div class='packaging-label'>Select Products</div>
                <select name='packaging_product[productid][]' class='packaging-product select21 " . $class_existing . "'>";
            if (count($posts_array) > 0) {
                foreach ($posts_array as $PR) {
                    $term_list = wp_get_post_terms($PR->ID, 'type', array('fields' => 'names'));
                    $term_name = isset($term_list[0]) ? $term_list[0] : '';
                    $obj = wc_get_product($PR->ID);
                    $sku = $obj->get_sku();
                    $skuString = '';
                    if ($sku != '') {
                        $skuString = ' (' . $sku . ')';
                    }
                    if ($product_id == $PR->ID) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }

                    $html .= '<option value="' . $PR->ID . '" ' . $selected . '> ' . $PR->post_title . $skuString . ' ' . $term_name . '</option>';
                }
            }
            $html .= "</select> </div> <div class='col-md-2'>
                <div class='packaging-label'>Min Qty</div>
                <input type='number' min='1' max='" . $item_quantity . "' class='min_qty' name='packaging_product[min_qty][]' value='1'>

            </div>
            <div class='col-md-2'>
                <div class='packaging-label'>Max Qty</div>
                <input type='number' min='1' class='max_qty' name='packaging_product[max_qty][]' value='" . $item_quantity . "'>

            </div><div class='col-md-2'>
                <div class='packaging-label'>Shipment</div>
                <select class='shipment_level' name='packaging_product[shipment_level][]'><option value='1'>First/Default</option><option value='2'>Second</option></select>
                

            </div></div>";
            $orderproducts[] = $product_id;
        }
        return $html;

        // $restults = $wpdb->query( $sql_query );
    }

    public function get_all_order_products_byid($ConfigMb)
    {
        global $wpdb;
        $new_array = $ConfigMb['pterms'];
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
        $html = '';
        $products = isset($_GET['product']) ? $_GET['product'] : array();
        $qty = isset($_GET['qty']) ? $_GET['qty'] : array();
        $shipment_level = isset($_GET['level']) ? $_GET['level'] : array();
        $counter = 0;
        foreach ($products as $pr) {
            $product_id = $pr;
            $item_quantity = $qty[$counter]; // 
            $item_level = $shipment_level[$counter];
            $second_select = '';
            $first_select = 'selected';
            if ($item_level == 2) {
                $second_select = 'selected';
                $first_select = '';
            }

            $html .= '<div class="repeating-content">
            <div class="remove-itm"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-trash"></span></a></div>';
            $html .= "<div class='col-md-3'>
                <div class='packaging-label'>Select Products</div>
                <select name='packaging_product[productid][]' class='packaging-product select21'>";
            if (count($posts_array) > 0) {

                foreach ($posts_array as $PR) {
                    $term_list = wp_get_post_terms($PR->ID, 'type', array('fields' => 'names'));
                    $term_name = isset($term_list[0]) ? $term_list[0] : '';
                    $obj = wc_get_product($PR->ID);
                    $sku = $obj->get_sku();
                    $skuString = '';
                    if ($sku != '') {
                        $skuString = ' (' . $sku . ')';
                    }
                    if ($product_id == $PR->ID) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $html .= '<option value="' . $PR->ID . '" ' . $selected . '> ' . $PR->post_title . $skuString . ' ' . $term_name . '</option>';
                }
            }
            $html .= "</select> </div> <div class='col-md-2'>
                <div class='packaging-label'>Min Qty</div>
                <input type='number' min='1' max='" . $item_quantity . "' class='min_qty' name='packaging_product[min_qty][]' value='1'>

            </div>
            <div class='col-md-2'>
                <div class='packaging-label'>Max Qty</div>
                <input type='number' min='1' class='max_qty' name='packaging_product[max_qty][]' value='" . $item_quantity . "'>

            </div>
            <div class='col-md-2'>
                <div class='packaging-label'>Shipment</div>
                <select class='shipment_level' name='packaging_product[shipment_level][]'><option value='1' " . $first_select . ">First/Default</option><option value='2' " . $second_select . ">Second</option></select>
                

            </div>
</div>";
            $counter++;
        }
        return $html;

        // $restults = $wpdb->query( $sql_query );
    }

    public function get_package_groups_by_package_id($package_id, $html = false)
    {
        global $wpdb;
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        $sql_query = "SELECT DISTINCT group_id from $table_name_products
        WHERE package_id = $package_id";
        $restults = $wpdb->get_results(
           $sql_query
        );
        if ($html) {
            //  
        } else {
            return $restults;
        }
    }

    public function get_all_packages_products($package_id, $ConfigMb, $html = false, $group_id = '')
    {
        global $wpdb;
        $new_array = $ConfigMb['pterms'];
        array_push($new_array, "raw", "packaging", "landing-page", "data-only");
        $table_name_packaging = $wpdb->prefix . 'mbt_packages';
        $table_name_components = $wpdb->prefix . 'mbt_package_components';
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        $sql_query = "select packages.* , pproducts.* from $table_name_packaging as packages 
        INNER JOIN $table_name_products as pproducts ON packages.id=pproducts.package_id 
        WHERE packages.id = $package_id";
        if ($group_id != '') {
            $sql_query .= ' AND pproducts.group_id=' . $group_id;
        }

        $restults = $wpdb->get_results(
           $sql_query
        );
        if ($html) {
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
            $html = '';

            foreach ($restults as $res) {
                $selectedTitle = '';
                $html .= '<div class="repeating-content">
            <div class="remove-itm"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-trash"></span></a></div>';
                $html .= "<div class='col-md-3'>
                <div class='packaging-label'>Select Products</div>
                <select name='packaging_product[productid][]' class='packaging-product select21'>";
                if (count($posts_array) > 0) {

                    foreach ($posts_array as $PR) {
                        // $term_list = wp_get_post_terms($PR->ID, 'type', array('fields' => 'names'));
                        // $term_name = isset($term_list[0]) ? $term_list[0] : '';
                        $term_name = '';
                        //  $obj = wc_get_product($PR->ID);
                        //  $sku = $obj->get_sku();
                        $skuString = '';
                        // if ($sku != '') {
                        //     $skuString = ' (' . $sku . ')';
                        // }
                        if ($res->product_id == $PR->ID) {
                            $selected = 'selected';
                            $selectedTitle = '<span class="productLabel">' . $PR->post_title . '</span>';
                        } else {
                            $selected = '';
                        }
                        $html .= '<option value="' . $PR->ID . '" ' . $selected . '> ' . $PR->post_title . $skuString . ' ' . $term_name . '</option>';
                    }
                }
                $item_level = $res->shipment;
                $second_select = '';
                $first_select = 'selected';
                if ($item_level == 2) {
                    $second_select = 'selected';
                    $first_select = '';
                }
                $html .= "</select> $selectedTitle</div> <div class='col-md-2'>
                <div class='packaging-label'>Min Qty</div>
                <input type='number' min='1' max='" . $res->qty_max . "' class='min_qty' name='packaging_product[min_qty][]' value='" . $res->qty_min . "'>

            </div>
            <div class='col-md-2'>
                <div class='packaging-label'>Max Qty</div>
                <input type='number' min='1'  class='max_qty' name='packaging_product[max_qty][]' value='" . $res->qty_max . "'>

            </div>
               <div class='col-md-2'>
                <div class='packaging-label'>Shipment</div>
                <select class='shipment_level' name='packaging_product[shipment_level][]'><option " . $first_select . " value='1'>First/Default</option><option " . $second_select . " value='2'>Second</option></select>
                

            </div></div>";
            }
            wp_reset_postdata();
            return $html;
        } else {
            return $restults;
        }
        // $restults = $wpdb->query( $sql_query );
    }

    public function get_all_packages()
    {
        global $wpdb;
        $table_name_packaging = $wpdb->prefix . 'mbt_packages';
        $sql_query = "select * from $table_name_packaging";
        return $restults = $wpdb->get_results($sql_query);
      //      $wpdb->prepare($sql_query)
       // );
        // $restults = $wpdb->query( $sql_query );
    }

    public function get_all_packages_withComponents()
    {
        global $wpdb;
        $table_name_packaging = $wpdb->prefix . 'mbt_packages';
        $table_name_components = $wpdb->prefix . 'mbt_package_components';
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        $sql_query = "select packages.* , pcomponents.* from $table_name_packaging as packages 
        LEFT JOIN $table_name_components as pcomponents ON packages.id=pcomponents.package_id 
        ORDER BY packages.id";
        return $restults = $wpdb->get_results(
           $sql_query
        );
        // $restults = $wpdb->query( $sql_query );
    }

    public function get_package_components_by_id($package_id, $html = false)
    {
        global $wpdb;
        $table_name_packaging = $wpdb->prefix . 'mbt_packages';
        $table_name_components = $wpdb->prefix . 'mbt_package_components';
        $table_name_products = $wpdb->prefix . 'mbt_package_products';
        $sql_query = "select * from  $table_name_components where package_id=$package_id";

        $restults = $wpdb->get_results(
           $sql_query
        );

        if ($html) {
            $str = '';
            foreach ($restults as $res) {
                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'product',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $res->component_type,
                        )
                    )
                );

                $posts_array = get_posts(
                    $args
                );
                if (count($posts_array) > 0) {
                    $arr_res = array('status' => 'success');
                    $str .= '<div class="col-lg-3" id="package-' . $res->component_type . '"><div class="packaging-label">Select component item</div><select name=packaging[' . $res->component_type . '][component_item]>';
                    foreach ($posts_array as $PR) {
                        if ($PR->ID == $res->component_id) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        $str .= '<option value="' . $PR->ID . '" ' . $selected . '> ' . $PR->post_title . '</option>';
                    }
                    $str .= '</select> <div class="packaging-label">Quantity</div><input type="number" min="1" name="packaging[' . $res->component_type . '][component_item_qty]" placehodler="Quantity" value="' . $res->component_qty . '"> <span class="rem-element" data-pcategory="' . $res->component_type . '">&#10006;</span></div>';
                }
                wp_reset_postdata();
            }
            return $str;
        } else {
            return $restults;
        }
    }

    public function delete_package($package_id)
    {
        try {
            global $wpdb;
            $table_name_packaging = $wpdb->prefix . 'mbt_packages';
            $table_name_components = $wpdb->prefix . 'mbt_package_components';
            $table_name_products = $wpdb->prefix . 'mbt_package_products';
            $sql_del = "delete t1,t2,t3 from $table_name_packaging as t1 LEFT JOIN $table_name_components as t2 ON t1.id=t2.package_id LEFT JOIN  $table_name_products as t3 ON t1.id = t3.package_id WHERE t1.id=$package_id";
            $wpdb->query($sql_del);
            echo 'Package Deleted Successfully';
        } catch (Exception $e) {
            echo 'Error! ' . $wpdb->last_error;
        }
    }

    public function remove_content_editor_mbt($ConfigMbt)
    {

        global $post;
        global $pconfiguration;

        if (has_term($pconfiguration['pterms'], 'product_cat', $post)) {
            remove_post_type_support('product', 'editor');

            remove_post_type_support('product', 'excerpt');

            remove_meta_box('wpseo_meta', 'product', 'normal');
            remove_meta_box('acf-group_5f40f89503c5b', 'product', 'normal');

            remove_meta_box('postexcerpt', 'product', 'normal');

            remove_meta_box('postimagediv', 'product', 'normal');

            remove_meta_box('woocommerce-product-images', 'product', 'normal');
            remove_meta_box('typediv', 'product', 'normal');
            remove_meta_box('tagsdiv-product_tag', 'product', 'normal');
            remove_meta_box('product_settings', 'product', 'normal');
            remove_meta_box('woocommerce-gpf-product-fields', 'product', 'normal');
        }
    }

    /*
      create packaging tables on activation
     */

    public function mbt_packaging_installer()
    {
        global $wpdb;
        global $charset_collate;
        $sql_packages = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . "mbt_packages (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `name` varchar(128) NOT NULL,
          `Desc` varchar(300) NULL,
          `shipment` int(11) DEFAULT 1,
           PRIMARY KEY (`id`)
        )$charset_collate;";
        $sql_packaging_components = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . "mbt_package_components (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `package_id` bigint(20) NOT NULL,
            `component_type` varchar(128) NOT NULL,
            `component_id` bigint(20) NOT NULL,
            `component_qty` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        )$charset_collate;";
        $sql_packaging_products = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . "mbt_package_products (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `package_id` bigint(20) NOT NULL,
            `group_id` int(11) DEFAULT 0,
            `product_id` bigint(20) NOT NULL,
            `qty_min` int(11) NOT NULL,
            `qty_max` int(11) NOT NULL,
            `package_products_descending` NULL,
            PRIMARY KEY (`id`)
        )$charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_packages);
        dbDelta($sql_packaging_components);
        dbDelta($sql_packaging_products);
    }

    public function get_package_info_for_shipping($package_id)
    {
        if ($package_id != '') {
            global $wpdb;

            $table_name_components = $wpdb->prefix . 'mbt_package_components';
            $sql = "SELECT * FROM $table_name_components where package_id=$package_id";
            $restults = $wpdb->get_results(
               $sql
            );
            $product_id = '';
            if (count($restults) > 0) {
                foreach ($restults as $res) {
                    if ($res->component_type == 'boxes') {
                        $product_id = $res->component_id;
                        break;
                    }
                }
                if ($product_id == '') {
                    foreach ($restults as $res) {
                        $product_id = $res->component_id;
                        break;
                    }
                }
            }
            if ($product_id != '') {
                $product = wc_get_product($product_id);
                if (!$product) {
                    return false;
                }
                $arr = array();
                $arr['width'] = $product->get_width();
                $arr['height'] = $product->get_height();
                $arr['length'] = $product->get_length();
                $arr['weight'] = $product->get_weight();
                return $arr;
            }
        } else {
            return false;
        }
    }

    /*
     * check package Quantity
     */

    public function check_package_inventory($package_id, $shipment = 1)
    {
        $result = [];
        if ($package_id != '') {
            global $wpdb;
            $table_name_components = $wpdb->prefix . 'mbt_package_components';
            $sql = "SELECT * FROM $table_name_components where package_id=$package_id";
            $restults = $wpdb->get_results(
               $sql
            );
            $product_id = '';
            if (count($restults) > 0) {
                foreach ($restults as $res) {
                    $product_id = $res->component_id;
                    $product_qty = $res->component_qty;
                    $product = wc_get_product($product_id);
                    if ($product->get_stock_quantity() < $product_qty) {
                        $result['status'] = 0;
                        //$text = html_entity_decode(str_replace('"','',get_the_title($product_id)));
                        $result['message'] = html_entity_decode(get_the_title($product_id)) . ' is out of stock';
                        return $result;
                        //return false;
                        break;
                    }
                }
            }
        } else {
            $result['status'] = 0;
            $result['message'] = 'no package found';
            return $result;
            //return false;
        }
        $result['status'] = 1;
        return $result;
        //return true;
    }

    /*
     * decrease package Quantity
     */

    public function manage_package_inventory($package_id)
    {
        if ($package_id != '') {
            global $wpdb;

            $table_name_components = $wpdb->prefix . 'mbt_package_components';
            $sql = "SELECT * FROM $table_name_components where package_id=$package_id";
            $restults = $wpdb->get_results(
               $sql
            );
            $product_id = '';
            if (count($restults) > 0) {
                foreach ($restults as $res) {
                    $product_id = $res->component_id;
                    $product_qty = $res->component_qty;
                    $product = wc_get_product($product_id);
                    $new_stock = wc_update_product_stock($product, $product_qty, 'decrease');
                }
            }
        } else {
            return false;
        }
    }

    /* make most selling combinations */

    public function mbtGetCombinations()
    {

        global $wpdb;
        $sql = "SELECT * FROM order_item ORDER BY orderItemId DESC LIMIT 500000";
        $restults = $wpdb->get_results(
           $sql
        );
        // echo '<pre>';
        // print_r($restults);
        // echo '</pre>';
        $combinations = array();
        if (count($restults) > 0) {
            foreach ($restults as $key => $val) {
                if (array_key_exists($val->orderId, $combinations)) {
                    $newarr = [$val->productId => $val->productQuantity];
                    $existing = $combinations[$val->orderId];
                    $combined = $newarr + $existing;
                    $combinations[$val->orderId] = $combined;
                    // $combinations[$val->orderId]['count'] =$combinations[$val->orderId]['count']+1;
                } else {
                    $combinations[$val->orderId] = [$val->productId => $val->productQuantity];
                    //$combinations[$val->orderId]['count'] =1;
                }

                // foreach($combinations[$val->orderId] as $key =>$comb) {
                //     if($key == $val->productId && $comb==$val->productQuantity){
                //         $combinations[$val->orderId]['count'] =  $combinations[$val->orderId]['count']+1;
                //     }
                // }
            }
        }

        $updated_combinations = array();
        foreach ($combinations as $comb) {
            ksort($comb);
            $str = '';
            $counter = 1;
            foreach ($comb as $key => $val) {
                $str .= $key . '|' . $val;
                if ($counter == count($comb)) {
                    // $str . ='-';
                } else {
                    $str .= '-';
                }
                $counter++;
            }
            if (array_key_exists($str, $updated_combinations)) {
                $updated_combinations[$str] = $updated_combinations[$str] + 1;
            } else {
                $updated_combinations[$str] = 1;
            }
        }
        arsort($updated_combinations);
        foreach ($updated_combinations as $key => $val) {
            $key_exp = explode('-', $key);
            $counter = 0;
            echo '<div class="report_item" style="width: 100%;
    padding: 17px;
    border: 1px solid #000;">';
            foreach ($key_exp as $ex) {
                $ex = explode('|', $ex);
                $pid = (int) $ex[0];
                $sql = "SELECT productNameFull FROM product_ WHERE productId=$pid";
                $restults = $wpdb->get_results(
                   $sql
                );
                foreach ($restults as $key => $val2) {
                    echo $val2->productNameFull . ' <strong>Qty ' . $ex[1] . '</strong> | ';
                }
            }
            echo '=><strong>' . $val . '</strong>';
            echo '</div>';
        }
        //        echo '<pre>';
        //        print_r($updated_combinations);
        //        die();
    }
    public function add_packaging_combination_by_package_id($package_id, $components)
    {

        if ($package_id == '') {
            return false;
        }
        $products_ascending = array();
        $modified_array = array();
        foreach ($components as $bas) {
            /*
            check for shipping protection
            */
            if($bas['product_id'] == SHIPPING_PROTECTION_PRODUCT)
            continue;
        /*
            check  end for shipping protection
            */
            $baseLevel = isset($bas['level']) ? $bas['level']:'1';
            $modified_array[$bas['product_id'] . '|' . $baseLevel] = $bas['qty'];
        }
        $products_ascending = array_keys($modified_array);

        sort($products_ascending);
        //        if(is_array($components) && count($components)>0) {
        //            foreach($components as $key=>$comp) {
        //                $products_ascending[]=$key;
        //            }
        //        }
        //        else{
        //            return false;
        //        }
        //        sort($products_ascending);
        global $wpdb;
        $table_name = $wpdb->prefix . 'mbt_package_products';
        $sql_last = "SELECT max(group_id) as gropuid FROM $table_name WHERE package_id=$package_id";
        $restults = $wpdb->get_results($sql_last, 'ARRAY_A');
        $maxid = isset($restults[0]['gropuid']) ? $restults[0]['gropuid'] : 0;
        $maxid =   $maxid + 1;
        foreach ($components as $key => $comp) {

            $data = array('package_id' => $package_id, 'group_id' => $maxid, 'product_id' => $comp['product_id'], 'qty_min' => $comp['min'], 'qty_max' => $comp['max'], 'shipment' => $comp['level'], 'package_products_descending' => implode(',', $products_ascending));
        
            $format = array('%d', '%d', '%s', '%d', '%d', '%d', '%s');
            $wpdb->insert($table_name, $data, $format);
            $inserted_product = $wpdb->insert_id;
            if (!$inserted_product) {
                return false;
            }
        }
        return true;
    }
}

$MbtPackaging = new MbtPackaging($ConfigMbt);
