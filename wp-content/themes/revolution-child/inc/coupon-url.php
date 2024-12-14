<?php
function apply_coupon_on_add_to_cart_sbr($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
    if(isset($_REQUEST['action']) && $_REQUEST['action'] =='custom_add_to_cart') {
    // Define the coupon code you want to apply
    $coupon_code = isset($_REQUEST['coupon_code']) ? $_REQUEST['coupon_code']:''; // Replace with your actual coupon code

    // Apply the coupon code
    if (!WC()->cart->has_discount($coupon_code) && $coupon_code!='') {
        WC()->cart->apply_coupon($coupon_code);
    }
}
}
add_action('woocommerce_add_to_cart', 'apply_coupon_on_add_to_cart_sbr', 10, 6);
add_action('init','apply_coupon_code_by_url_MBT');
function apply_coupon_code_by_url_MBT(){
    if (isset($_GET['add-to-cart'])){
        WC()->cart->add_to_cart($_GET['add-to-cart']);
    }
    if (isset($_GET['coupon_code'])) {
        $coupon_code = sanitize_text_field($_GET['coupon_code']); // Get the coupon code from the URL
        // Add the product to the cart
        WC()->cart->apply_coupon($coupon_code); // Apply the coupon code
    }
}
add_action('template_redirect', 'apply_coupon_by_url_MBT', 101);
function apply_coupon_by_url_MBT() {
    if (is_404()) {
        $sb_link = $_SERVER['REQUEST_URI'];
        $sb_link = parse_url($sb_link, PHP_URL_PATH);
        $url_match_case = trim($sb_link, '/');
        $coupon_data = explode('/', $url_match_case);
        if($coupon_data[0]=='apply-coupon'){
            if(isset($_REQUEST['ref']) && $_REQUEST['ref']!=''){
                setcookie('affwp_ref', $_REQUEST['ref'], time() + (86400 * 30), "/");
              }
        $product_id=isset($coupon_data[1]) ? $coupon_data[1]:'';
        $coupon_id=isset($coupon_data[2]) ? $coupon_data[2]:'';
        $product_qty = 1;
        $_POST['action'] = 'woocommerce_add_order_item';
        WC()->cart->add_to_cart($product_id, $product_qty, 0, array());
        WC()->cart->apply_coupon($coupon_id);
        $checkout_url = site_url('checkout');
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $checkout_url);
        die();
        }
        if($coupon_data[0]==' add-to-cart' || $coupon_data[0]=='add-to-cart'){
            if(isset($_REQUEST['ref']) && $_REQUEST['ref']!=''){
                setcookie('affwp_ref', $_REQUEST['ref'], time() + (86400 * 30), "/");
              }
              
            $product_id=isset($_REQUEST['add-to-cartp']) ? $_REQUEST['add-to-cartp']:'';
            $coupon_id=isset($coupon_data[2]) ? $coupon_data[2]:'';
            $product_qty = 1;
            $_POST['action'] = 'woocommerce_add_order_item';
            WC()->cart->add_to_cart($product_id, $product_qty, 0, array());
            if(isset($_GET['coupon_code']) && $_GET['coupon_code']!=''){
                WC()->cart->apply_coupon($_GET['coupon_code']);
            }
            //WC()->cart->apply_coupon($coupon_id);
            $checkout_url = site_url('checkout');
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $checkout_url);
            die();
            }
        
    }
}
?>