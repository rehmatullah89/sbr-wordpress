<?php
add_filter('wp_dropdown_users_args', 'wp_dropdown_users_args_sbr_blog_user', 10, 2);
/**
 * Filter callback for modifying arguments passed to wp_dropdown_users.
 *
 * @param array $query_args   An array of query arguments for wp_dropdown_users.
 * @param array $parsed_args  An array of parsed arguments for wp_dropdown_users.
 * @return array              Modified query arguments.
 */
function wp_dropdown_users_args_sbr_blog_user($query_args, $parsed_args)
{

    $my_current_screen = get_current_screen();
    if ($my_current_screen->base == 'post') {
        $query_args['capability'] = array();
        $query_args['role__in'] = array(
            'author',  'editor', 'subscriber'
        );
        $query_args['role__not_in'] = array(
            'customer'
        );
    }
    return $query_args;
}
//subscription#RB
add_action('admin_menu', 'register_subscriptions_admin_menus');
function register_subscriptions_admin_menus()
{
    add_menu_page(
        'Subscriptions',
        'Subscriptions',
        'manage_options',
        'subscriptions',
        'sbr_subscriptions_list',
        'https://www.smilebrilliant.com/wp-content/uploads/2020/08/favicon-96x96-1.png',
        2
    );
}
add_action('admin_menu', 'register_sbr_admin_menus');
/**
 * Register SBR admin menus.
 */
function register_sbr_admin_menus()
{
    add_menu_page(
        'SBR',
        'SBR',
        'manage_options',
        'sbr',
        'sbr_feature_listing_callback',
        'https://www.smilebrilliant.com/wp-content/uploads/2020/08/favicon-96x96-1.png',
        6
    );
    add_submenu_page(
        'sbr',
        'Add Shipment',
        'Add Shipment',
        'manage_options',
        'add_shipment',
        'addNewEasypostShipment'
    );
    add_submenu_page(
        'sbr',
        'Youtube guide',
        'Youtube guide',
        'manage_options',
        'youtube',
        'youtubeGuidePage'
    );
    add_submenu_page(
        'sbr',
        'Shipment Info',
        'Shipment Info',
        'manage_options',
        'shipment_info',
        'easyPostShipmentInfo'
    );
    add_submenu_page(
        'sbr',
        'RDH info',
        'RDH info',
        'manage_options',
        'rdh_info',
        'rdhDetailInfo_callback'
    );
    add_submenu_page(
        'sbr',
        'Shipments',
        'Shipments',
        'manage_options',
        'shipment',
        'getAllEasypostShipments'
    );
    add_submenu_page(
        'sbr',
        'Batch Search',
        'Batch Search',
        'manage_options',
        'search_batch',
        'getAllEasyPostBatch'
    );
    add_submenu_page(
        'sbr',
        'Batch Print Logs',
        'Batch Print Logs',
        'manage_options',
        'batch_print_logs',
        'batchPrintLog'
    );
    add_submenu_page(
        'sbr',
        'Print Request Info',
        'Print Request Info',
        'manage_options',
        'batch_print_info',
        'batchPrintLogDetail'
    );
    add_submenu_page(
        'sbr',
        'Batch Print Request',
        'Batch Print Request',
        'manage_options',
        'batch_request',
        'batchPrintRequestDetail'
    );
    add_submenu_page(
        'sbr',
        'Sale management system',
        'Sale management system',
        'manage_options',
        'sbr_sale',
        'sbr_productSaleManagement'
    );
    add_submenu_page(
        'sbr',
        'Inventory management system',
        'Inventory management system',
        'manage_options',
        'sbr_ims',
        'sbr_inventoryManagement'
    );
    add_submenu_page(
        'sbr',
        'RDH',
        'RDH',
        'manage_options',
        'sbr_rdh',
        'sbr_rdhManagement'
    );
    add_submenu_page(
        'sbr',
        'Create Order',
        'Create Order',
        'edit_posts',
        'create-order',
        'create_order_page_mbt'
    );
    add_submenu_page(
        'packaging-dashboard',
        'Search package',
        'Search package',
        'manage_options',
        'search-package',
        'mbt_packaging_search_dashboard'
    );
    add_submenu_page(
        'sbr',
        'Create custom postage',
        'Create custom postage',
        'manage_options',
        'custom_postage',
        'generate_shipment_withoutOrder'
    );
    /*
    add_submenu_page(
        'sbr',
        'Mini Cart/Checkout',
        'Mini Cart/Checkout',
        'edit_posts',
        'mini_cart_checkout',
        'create_order_page_mbt'
    );
    add_submenu_page(
        'sbr',
        'BOGO Products',
        'BOGO Products',
        'edit_posts',
        'bogo_products',
        'create_order_page_mbt'
    );
    */
    remove_menu_page('sbr');
}
/**
 * Callback function for the SBR feature listing.
 */
function sbr_feature_listing_callback()
{
    echo 'SBR';
}
