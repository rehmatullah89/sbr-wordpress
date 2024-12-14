<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
  * @version 7.9.0
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<form class="woocommerce-cart-form" id="smile_brillaint_cart_form"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="mbt_cart_table table table-bordered table-condensed table-striped shop-table table-responsive"
        cellspacing="0">
        <thead>
            <tr>

                <!--                 <th class="product-thumbnail">&nbsp;</th> -->
                <th scope="col" colspan="2" class="upper product-column"><?php esc_html_e('Product', 'woocommerce'); ?>
                </th>
                <th scope="col" colspan="1" class="upper price-column hidden-mobile">
                    <?php esc_html_e('Price', 'woocommerce'); ?></th>
                <th scope="col" colspan="1" class="upper qty-column hidden-mobile">
                    <?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th scope="col" colspan="1" class="upper"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                <th scope="col" colspan="1" class="upper remove-button-column hidden-mobile">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            $mbt_cart_items = array();
            $wc_cart = WC()->cart->get_cart();
           
            foreach ($wc_cart as $cart_item_key => $cart_item) {

                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                if (wc_cp_is_composited_cart_item($cart_item)) {
                    continue;
                } elseif (wc_cp_is_composite_container_cart_item($cart_item)) {
                    if(get_post_meta($product_id , 'three_way_ship_product' , true) == 'yes'){
                        if (isset($mbt_cart_items[$product_id])) {
                            $mbt_cart_items[$product_id] = $mbt_cart_items[$product_id] + 1;
                        } else {
                            $mbt_cart_items[$product_id] = 1;
                        }
                    }else{
                        $mbt_cart_items[$product_id] = $cart_item['quantity'];
                    }
                   
                } else {
                    $mbt_cart_items[$product_id] = $cart_item['quantity'];
                }
            }
            //echo 'Data: <pre>' .print_r($mbt_cart_items,true). '</pre>';
            $display_product = array();
            foreach ($wc_cart as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if (wc_cp_is_composited_cart_item($cart_item)) {
                    continue;
                } elseif (wc_cp_is_composite_container_cart_item($cart_item)) {
                    if (isset($display_product[$product_id])) {
                        continue;
                    } else {
                        $display_product[$product_id] = $product_id;
                    }
                }


                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
            <tr
                class="wproductRow <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">



                <td class="product-thumbnail product-thumb">
                    <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                            if (!$product_permalink) {
                                echo $thumbnail; // PHPCS: XSS ok.
                            } else {
                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                            }
                            ?>
                </td>

                <td class="product-name product-column" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                    <h5>
                        <?php
                                if (!$product_permalink) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                } else {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data.
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.
                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                    </h5>

                    <?php if (wp_is_mobile()) { ?>
                    <div class="show-mobile " data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                        <?php
                                    if (isset($mbt_cart_items[$product_id])) {
                                        ?>
                        <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][old_qty]"
                            value="<?php echo $mbt_cart_items[$product_id]; ?>" />
                        <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][product_id]"
                            value="<?php echo $product_id; ?>" />
                        <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][product_type]"
                            value="<?php echo $_product->get_type(); ?>" />
                        <?php
                                        $product_quantity = woocommerce_quantity_input(
                                                array(
                                            'input_name' => "cart[{$cart_item_key}][qty]",
                                            'input_value' => $mbt_cart_items[$product_id],
                                            'max_value' => $_product->get_max_purchase_quantity(),
                                            'min_value' => '0',
                                            'product_name' => $_product->get_name(),
                                                ), $_product, false
                                        );
                                    } else if ($_product->is_sold_individually()) {
                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                                array(
                                            'input_name' => "cart[{$cart_item_key}][qty]",
                                            'input_value' => $cart_item['quantity'],
                                            'max_value' => $_product->get_max_purchase_quantity(),
                                            'min_value' => '0',
                                            'product_name' => $_product->get_name(),
                                                ), $_product, false
                                        );
                                    }

                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                    ?>
                    </div>


                    <?php } ?>
                </td>

                <td class="price-column text-left hidden-mobile"
                    data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                    <h5 class="productTotal220">
                        <?php
                       /// echo  WC()->cart->get_product_price($_product);
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                        <span class="usd-symbal" style="font-size:0.7em;color:#565759;">USD</span>
                    </h5>
                </td>

                <?php if (!wp_is_mobile()) { ?>

                <td class="qty-column text-left hidden-mobile"
                    data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                    <?php
                                    if (isset($mbt_cart_items[$product_id])) {
                                        ?>
                    <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][old_qty]"
                        value="<?php echo $mbt_cart_items[$product_id]; ?>" />
                    <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][product_id]"
                        value="<?php echo $product_id; ?>" />
                    <input type="hidden" name="cart[<?php echo $cart_item_key; ?>][product_type]"
                        value="<?php echo $_product->get_type(); ?>" />
                    <?php
                $product_quantity = woocommerce_quantity_input(
                        array(
                    'input_name' => "cart[{$cart_item_key}][qty]",
                    'input_value' => $mbt_cart_items[$product_id],
                    'max_value' => $_product->get_max_purchase_quantity(),
                    'min_value' => '0',
                    'product_name' => $_product->get_name(),
                        ), $_product, false
                );
            } else if ($_product->is_sold_individually()) {
                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
            } else {
                $product_quantity = woocommerce_quantity_input(
                        array(
                    'input_name' => "cart[{$cart_item_key}][qty]",
                    'input_value' => $cart_item['quantity'],
                    'max_value' => $_product->get_max_purchase_quantity(),
                    'min_value' => '0',
                    'product_name' => $_product->get_name(),
                        ), $_product, false
                );
            }

            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
            ?>
                </td>
                <?php } ?>
                <td class="total-column" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                    <h5 class="productUnitPrice220">
                        <?php
        if (isset($mbt_cart_items[$product_id])) {
            $product_quantity = $mbt_cart_items[$product_id];
            echo WC()->cart->get_product_subtotal($_product, $product_quantity);
            //echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $product_quantity), $cart_item, $cart_item_key); // PHPCS: XSS ok.
        } else {
            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
        }
        //echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
        ?>
                        <span class="usd-symbal" style="font-size:0.7em;color:#565759;">USD</span>
                    </h5>
                </td>


                <?php
        $_productt = wc_get_product($product_id);
        if ($_productt->is_type('simple')) {
            echo ' <td class="remove-button-column text-left product-remove hidden-mobile">';
            echo apply_filters(// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove btn btn-primary btn-sm mbt-cart-item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">REMOVE</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_html__('Remove this item', 'woocommerce'), esc_attr($product_id), esc_attr($_product->get_sku())
                    ), $cart_item_key
            );
            echo '</td>';
        } else {

            echo '<td class="remove-button-column text-left hidden-mobile"><a href="javascript:void(0);" class="btn btn-primary btn-sm removesmilecart" aria-label="%s" data-product_id="' . esc_attr($product_id) . '" data-product_sku="%s">REMOVE</a></td>';
        }
        /*
          echo ' <td class="remove-button-column text-left product-remove hidden-mobile">';
          echo apply_filters(// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          'woocommerce_cart_item_remove_link', sprintf(
          '<a href="%s" class="remove btn btn-primary btn-sm mbt-cart-item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">REMOVE</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_html__('Remove this item', 'woocommerce'), esc_attr($product_id), esc_attr($_product->get_sku())
          ), $cart_item_key
          );
          echo '</td>';
         * 
         */
        ?>


            </tr>
            <?php
    }
}
?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr class="no-bg-mbt">
                <td colspan="6" class="no-border-option">
                    <input type="hidden" name="action" value="update_woocommerce_cart_quantity_sb" />
                    <button type="button" onclick="update_smile_brillaint_checkout()"
                        class="button  checkout wc-forward"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>




    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php if (wc_coupons_enabled()) { ?>

<div class="row">
    <div class="col-xs-12 col-md-8 sep-top-sm">
        <div class="panel panel-naked">
            <div class="panel-heading">
                <h5 class="thb-checkout-coupon showcoupon">

                    <span>Enter Gift Code<i class="fa fa-plus-circle"></i></span>

                </h5>
                <div id="cart-coupon-check">
                    <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display: none;">
                        <div class="flex-mbt">
                            <div class="coupon-code form-group pull-left">
                                <input type="text" name="coupon_code" class="input-text" placeholder="Coupon code"
                                    id="coupon_code" value="">
                            </div>
                            <p class="cmt-btn">
                                <button type="submit" class="button btn btn-primary" name="apply_coupon"
                                    value="Apply coupon">Apply coupon</button>
                            </p>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<?php } ?>
<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals">
    <?php
/**
 * Cart collaterals hook.
 *
 * @hooked woocommerce_cross_sell_display
 * @hooked woocommerce_cart_totals - 10
 */
do_action('woocommerce_cart_collaterals');
?>
</div>
<script>
// Quantity buttons
$('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append(
        '<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />')
    .end().find('input[type="number"]').attr('type', 'text');
    jQuery(document).ready(function(){
       if (jQuery(window).width() < 767){    
        jQuery('#couponRowDescriptionCell').attr('colspan','2');
    } 
    else{
         jQuery('#couponRowDescriptionCell').attr('colspan','4');
    }
    });
    jQuery(window).resize(function(){
    if (jQuery(window).width() < 767){    
        jQuery('#couponRowDescriptionCell').attr('colspan','2');
    }
    else{
         jQuery('#couponRowDescriptionCell').attr('colspan','4');
    }
});
</script>
<?php do_action('woocommerce_after_cart'); ?>