<?php

add_action('woocommerce_review_order_before_cart_contents', 'woocommerce_header_add_to_cart_fragment_bogoSaleDeal');
/**
 * Removes bogoSaleDeal items from the cart before displaying the order review on the checkout page.
 */
function woocommerce_header_add_to_cart_fragment_bogoSaleDeal()
{

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['bogoSaleDeal'])) {
            WC()->cart->remove_cart_item($cart_item_key);
        }
    }
}
/**
 * Filters the visibility of cart items with the bogoSaleDeal attribute during checkout.
 *
 * @param bool   $true          Whether the cart item is visible.
 * @param array  $cart_item     Cart item data.
 * @param string $cart_item_key Cart item key.
 *
 * @return bool Updated visibility status of the cart item.
 */
function filter_woocommerce_cart_item_visible_bogoSaleDeal($true, $cart_item, $cart_item_key)
{

    if (isset($cart_item['bogoSaleDeal'])) {
        $true = false;
    }

    return $true;
}
add_filter('woocommerce_checkout_cart_item_visible', 'filter_woocommerce_cart_item_visible_bogoSaleDeal', 10, 3);
add_filter('woocommerce_widget_cart_item_visible', 'filter_woocommerce_cart_item_visible_bogoSaleDeal', 10, 3);
/**
 * Adds a hook to execute the 'add_mbt_bogo_free_products' function before calculating cart totals.
 */
add_action('woocommerce_before_calculate_totals', 'add_mbt_bogo_free_products');
/**
 * Sets the price of bogoSaleDeal items to 0.00 before calculating cart totals.
 *
 * @param WC_Cart $cart The WooCommerce cart object.
 */
function add_mbt_bogo_free_products(WC_Cart $cart)
{

    foreach ($cart->get_cart() as $hash => $cart_item) {
        if (isset($cart_item['bogoSaleDeal'])) {
            $cart_item['data']->set_price(0.00);
        }
    }
}

add_filter('woocommerce_add_cart_item_data', 'set_extra_bogo_free_product_key', 10, 3);
/**
 * Sets extra data for the cart item when adding a product to the cart, including bogoSaleDeal information.
 *
 * @param array  $cart_item_data Additional cart item data.
 * @param int    $product_id     Product ID.
 * @param int    $variation_id   Variation ID.
 *
 * @return array Modified cart item data.
 */
function set_extra_bogo_free_product_key($cart_item_data, $product_id, $variation_id)
{

    if (isset($_POST['bogoSaleDeal'])) {
        $product = wc_get_product($product_id);
        //   if ($product->get_type() == 'composite') {
        $cart_item_data['bogoSaleDeal'] = 'yes';
        //  }
    }
    if(strpos($_SERVER['HTTP_REFERER'], 'smilebrilliant.com') === false) {
     $cart_item_data['addToCartSource'] = $_SERVER['HTTP_REFERER'];
    }
    /***Start Geha Experiment****/
    if (isset($_POST['gehaVariant'])) {
        $cart_item_data['gehaVariant'] = $_POST['gehaVariant'];
    }
    if (isset($_POST['geha_experiment_id'])) {
        $cart_item_data['geha_experiment_id'] = $_POST['geha_experiment_id'];
    }
    /***End**/
    if (isset($_REQUEST['uss'])) {
        $pop_products = array();
        if (have_rows('upsell_combination', 'option')) :
            while (have_rows('upsell_combination', 'option')) : the_row();

                $upsell_product =  get_sub_field('upsell_product');
                if ($upsell_product) {
                    $pop_products[] = $upsell_product;
                }

            endwhile;
        endif;
        if (in_array($product_id, $pop_products) && in_array($_REQUEST['uss'], array('cart', 'checkout-pop'))) {
            $cart_item_data['upsell_source'] = $_REQUEST['uss'];
        }
    }
    return $cart_item_data;
}

add_action('woocommerce_new_order_item', 'order_item_meta_update_upsell_source', 10, 3);
/**
 * Updates order item metadata for upsell source and Geha experiment variant.
 *
 * @param int   $item_id Order item ID.
 */
function order_item_meta_update_upsell_source($item_id, $values)
{
    if (isset($values->legacy_values['upsell_source']) && !empty($values->legacy_values['upsell_source'])) {
        wc_add_order_item_meta($item_id, '_upsell_source',  $values->legacy_values['upsell_source']);
    }
    /***Start Geha Experiment****/
    if (isset($values->legacy_values['gehaVariant']) && !empty($values->legacy_values['gehaVariant'])) {
        wc_add_order_item_meta($item_id, '_geha_variant',  $values->legacy_values['gehaVariant']);
        $expData = array(
            'id' =>  $values->legacy_values['geha_experiment_id'],
            'item_id' => $item_id,
        );
        sbr_update_geha_experiment($expData);
    }
    /***End**/
}

add_action('smilebrilliant_bogo_deal_html', 'smilebrilliant_bogo_deal_html_callback', 10, 1);

/**
 * Outputs HTML for the smilebrilliant_bogo_deal_html action hook.
 *
 * @param int $min_product_id Minimum product ID for the deal.
 * @param bool $return       Whether to return the HTML instead of echoing it.
 *
 * @return string HTML output if $return is true.
 */
function smilebrilliant_bogo_deal_html_callback($min_product_id, $return = false)
{
    $getDeals = bogoDealProductCombination();
    $cartPP = $getDeals['cartPP'];
    $cartBP = $getDeals['cartBP'];
    $cartProductWithQty = $getDeals['cartProductWithQty'];
    $html = '';
    foreach ($cartPP as $productId => $qty) {
        if (isset($cartProductWithQty[$productId]) &&  isset($cartBP[$productId]) &&  $cartProductWithQty[$productId] >= $qty  && $productId == $min_product_id) {
            if ((count($cartBP[$productId]) > 0)) {
                $html .= '<ul class="bogoProductCartSummery">';
                foreach ($cartBP[$productId] as $deals) {
                    $bogo_product_qty = $deals['qty'];
                    $bogo_product = $deals['bogo_product'];
                    $cartQty = $cartProductWithQty[$productId];
                    $multipleBy = intdiv($cartQty, $qty);
                    $html .= '<li>' . get_the_title($bogo_product) . '<span class="quantity"> ×' . $bogo_product_qty * $multipleBy . '</span></li>';
                }
                $html .= '</ul>';
            }
        }
    }
    if ($return) {
        return $html;
    } else {
        echo  $html;
    }
}
add_filter('woocommerce_cart_item_name', 'woocommerce_after_cart_item_nameasas',  10, 3);

/**
 * Filters the cart item name to display smilebrilliant_bogo_deal_html on the checkout page.
 *
 * @param string $_productname Original product name.
 * @param array  $cart_item    Cart item data.
 * @param string $cart_item_key Cart item key.
 *
 * @return string Modified cart item name.
 */
function woocommerce_after_cart_item_nameasas($_productname, $cart_item, $cart_item_key)
{
    $html = '';
    if (is_checkout()) {
        $min_product_id =  $cart_item['product_id'];
        $html = smilebrilliant_bogo_deal_html_callback($min_product_id, true);
    }
    return $_productname . $html;
}

/**
 * Displays HTML for bogoDealProductCombination on the checkout page.
 */
function bogoDealProductCombination()
{
    $cartPP = array();
    $cartBP = array();
    $cartSP = array();
    if (get_field('bogo_discount_products', 'option')) {
        if (have_rows('bogo_discount_products', 'option')) :
            while (have_rows('bogo_discount_products', 'option')) : the_row();
                $product =  get_sub_field('product');
                $cart_qty =  get_sub_field('cart_qty');
                //  $cartSP[$product] = get_sub_field('source_page');
                $cartPP[$product] = $cart_qty;
                if (have_rows('bogo_deal_products')) :
                    while (have_rows('bogo_deal_products')) : the_row();
                        $bogo_product =  get_sub_field('product');
                        $qty =  get_sub_field('qty');
                        $cartBP[$product][] = array(
                            'qty' => $qty,
                            'bogo_product' => $bogo_product
                        );
                    endwhile;
                endif;
            endwhile;
        endif;
    }
    $cartProductWithQty = array();
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $product = wc_get_product($product_id);
        //  if ($product->get_type() == 'composite') {
        if (!isset($cart_item['bogoSaleDeal'])) {
            if (isset($cartProductWithQty[$product_id])) {
                $cartProductWithQty[$product_id] = $cartProductWithQty[$product_id] +  $quantity;
            } else {
                $cartProductWithQty[$product_id] = $quantity;
            }
        } else {
            WC()->cart->remove_cart_item($cart_item_key);
        }
        // }
    }
    return array(
        'cartPP' => $cartPP,
        'cartBP' => $cartBP,
        //    'cartSP' => $cartSP,
        'cartProductWithQty' => $cartProductWithQty
    );
}

add_action('woocommerce_checkout_process', 'add_free_product_on_order_enquiry_status', 999);
/**
 * Displays HTML for bogoDealProductCombination on the checkout page.
 */
function add_free_product_on_order_enquiry_status()
{

    $getDeals = bogoDealProductCombination();
    $cartPP = $getDeals['cartPP'];
    $cartBP = $getDeals['cartBP'];
    $cartProductWithQty = $getDeals['cartProductWithQty'];
    foreach ($cartPP as $productId => $qty) {
        if (isset($cartProductWithQty[$productId]) &&  isset($cartBP[$productId]) &&  $cartProductWithQty[$productId] >= $qty) {

            if (count($cartBP[$productId]) > 0) {
                $_POST['action'] = 'woocommerce_add_order_item';
                foreach ($cartBP[$productId] as $deals) {
                    $bogo_product_qty = $deals['qty'];
                    $bogo_product = $deals['bogo_product'];
                    $cartQty = $cartProductWithQty[$productId];
                    $multipleBy =  intdiv($cartQty, $qty);
                    $cart_item_data = array(
                        'bogoSaleDeal' => 'yes'
                    );
                    WC()->cart->add_to_cart($bogo_product, $bogo_product_qty * $multipleBy, 0,  array(), $cart_item_data);
                }
            }
        }
    }
    return;
}

/**
 * Saves the author ID for a post based on the default author field.
 *
 * @param int $post_id Post ID.
 */
function save_rdh_author_id($post_id)
{

    $author_user_id = get_field('default_author', $post_id);
    if ($author_user_id) {
        // wp_update_post(array(
        //     'ID' => $post_id,
        //     'post_author' => $author_user_id
        // ));
        global $wpdb;
        $table_name = $wpdb->prefix . 'posts';

        $wpdb->update(
            $table_name,
            array('post_author' => $author_user_id),
            array('ID' => $post_id),
            array('%d'),
            array('%d')
        );
    }
}

add_action('save_post', 'save_rdh_author_id');


/**
 * Limits the number of post revisions for posts.
 *
 * @param int $num   The number of revisions to keep.
 *
 * @return int The modified number of revisions.
 */
function sbr_limit_post_revisions($num, $post)
{
    if ($post->post_type == 'post') {
        $num = 5;
    }
    return $num;
}

add_filter('wp_revisions_to_keep', 'sbr_limit_post_revisions', 10, 2);