<?php
?>
<table
class="mbt_cart_table table table-bordered table-condensed table-striped shop-table table-responsive">
<thead>
    <tr>

        <th scope="col" colspan="2" class="upper product-column">Products</th>
        <th scope="col" colspan="1" class="upper price-column">Price</th>
        <th scope="col" colspan="1" class="upper qty-column">Quantity</th>
        <th scope="col" colspan="1" class="upper">Total</th>
        <th scope="col" colspan="1" class="upper remove-button-column"></th>
    </tr>
</thead>

<tbody>

    <?php
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
    <tr class="productRow">

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

        <td class="product-name product-column"
            data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
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
        </td>


        <td class="price-column text-left">
            <h5 class="productTotal220"
                data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                <?php
                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                        ?>
            </h5>
        </td>
        <td class="qty-column text-left" data-price="<?php echo  get_post_meta($cart_item['product_id'] , '_price', true);?>"
            data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
            <?php
                    if ($_product->is_sold_individually() || (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes')) {
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
        <td class="total-column">
            <h5 class="productUnitPrice220"
                data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                <?php
                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                        ?>
            </h5>

        </td>
        <td class="remove-button-column text-left product-remove">
            <?php
                    echo sprintf('<a href="javascript:void(0)" rel="nofollow" class="remove btn btn-primary btn-sm mbt-cart-item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" cart_item_key="%s">REMOVE</a>', esc_html__('Remove this item', 'woocommerce'), esc_attr($product_id), esc_attr($_product->get_sku()), esc_attr($cart_item_key));
                    ?>
        </td>
    </tr>
    <?php
        }
    }
    ?>
    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
    <tr class="couponRow"
        style="background-color: rgb(242, 242, 242);/* display: none; */">
        <td colspan="4" id="couponRowDescriptionCell">
            <h5 style="color:#595959;text-align:right;">
                <?php wc_cart_totals_coupon_label($coupon); ?></h5>
        </td>
        <td colspan="1" style="text-align:left;">
            <h5 style="color:#595959;"><?php wc_cart_totals_coupon_html($coupon); ?>
            </h5>
        </td>
        <td colspan="1" class="remove-button-column">
            <a rel="nofollow"
                class="btn btn-primary btn-sm mbt-coupon-remove">REMOVE</a>
        </td>
    </tr>

    <?php endforeach; ?>

</tbody>
</table>

