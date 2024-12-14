<?php

/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */
defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (!$order) {
    return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads = $order->get_downloadable_items();
$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();

if ($show_downloads) {
    wc_get_template(
        'order/order-downloads.php',
        array(
            'downloads' => $downloads,
            'show_title' => true,
        )
    );
}
?>
<section class="woocommerce-order-details">
    <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

    <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>

    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

        <thead>
            <tr>
                <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'woocommerce'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            do_action('woocommerce_order_details_before_order_table_items', $order);

            $orderItemArray = array();
            $counterItem = array();
            $Orderhtml = '';
            $cart_items = array();
            foreach ($order->get_items() as $item_id => $item) {
                $product_id = $item->get_product_id();
                if (wc_cp_get_composited_order_item_container($item, $order)) {
                    continue;
                    //                } else if (wc_cp_is_composite_container_order_item($item)) {
                    //                    if (isset($cart_items[$product_id])) {
                    //                        $cart_items[$product_id] = $cart_items[$product_id] + 1;
                    //                    } else {
                    //                        $cart_items[$product_id] = 1;
                    //                    }
                } else {

                    if (isset($cart_items[$product_id])) {
                        $cart_items[$product_id]['qty'] = $cart_items[$product_id]['qty'] + $item->get_quantity();
                        $cart_items[$product_id]['amount'] =    $cart_items[$product_id]['amount'] + $item->get_total();
                    } else {
                        $cart_items[$product_id]['qty'] = $item->get_quantity();
                        $cart_items[$product_id]['amount'] = $item->get_total();
                    }
                }

                $orderItemArray[$product_id] = array(
                    'quantity' => $cart_items[$product_id]['qty'],
                    'amount' => $cart_items[$product_id]['amount'],
                    'item_id' => $item_id,
                );
            }
                    //    echo '<pre>';
                    //    print_r($orderItemArray);
                    //    echo '</pre>';
            //            $order_items = $order->get_items();
            foreach ($orderItemArray as $product_id => $itemDeatil) {
                $item = $order_items[$itemDeatil['item_id']];
                $product = $item->get_product();
                $item_id = $itemDeatil['item_id'];
                $get_quantity = $itemDeatil['quantity'];
                $get_amount = $itemDeatil['amount'];
                $dataDetail = array(
                    'order' => $order,
                    'item_id' => $item_id,
                    'item' => $item,
                    'quantity' => $get_quantity,
                    'amount' => $get_amount,
                    'show_purchase_note' => $show_purchase_note,
                    'purchase_note' => $product ? $product->get_purchase_note() : '',
                    'product' => $product,
                );

                wc_get_template(
                    'order/order-details-item.php',
                    $dataDetail
                );
            }

            do_action('woocommerce_order_details_after_order_table_items', $order);
            ?>
        </tbody>

        <tfoot>
            <?php
            foreach ($order->get_order_item_totals() as $key => $total) {
            ?>
                <tr>
                    <th scope="row"><?php echo esc_html($total['label']); ?></th>
                    <td><?php echo ('payment_method' === $key) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped                 
                        ?></td>
                </tr>
            <?php
            }
            ?>
            <?php if ($order->get_customer_note()) : ?>
                <tr>
                    <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>

    <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action('woocommerce_after_order_details', $order);

if ($show_customer_details) {
    wc_get_template('order/order-details-customer.php', array('order' => $order));
}
