<p class="order-info">
    <?php
    $order_date = date_i18n('F d, y h:i A', strtotime(WC_Warranty_Compatibility::get_order_prop($order, 'order_date')));
    printf(
            __('Order <mark class="order-number">%s</mark> made on <mark class="order-date">%s</mark>.', 'wc_warranty'), $order->get_order_number(), $order_date
    );
    ?>
</p>



<h2 class="woocommerce-order-details__title"><?php _e('Existing Requests', 'wc_warranty'); ?></h2>
<form method="get">
    <table width="100%" cellpadding="5" cellspacing="0" border="1px" class="warranty-table">
        <tr>
            <th><?php _e('RMA', 'wc_warranty'); ?></th>
            <th><?php _e('Products', 'wc_warranty'); ?></th>
            <th><?php _e('Details', 'wc_warranty'); ?></th>
            <th><?php _e('Status', 'wc_warranty'); ?></th>
        </tr>
        <?php
// load warranty request for this order, if any
        $results = warranty_search($order_id);

        if ($results) {
            foreach ($results as $result) {
                $result = warranty_load($result->ID);
                $warranty_string = '';
                $warranty_actions = '';
                $warranty_details = array();
                $status_term = wp_get_post_terms($result['ID'], 'shop_warranty_status');
                $status = $status_term[0]->name;

                foreach ($result['products'] as $warranty_product) {
                    if ($warranty_product['order_item_index'] == $item_idx) {
                        $used_qty = $used_qty + $warranty_product['quantity'];
                    }
                }

                $warranty_details[] = __('Updated ', 'wc_warranty') . date_i18n('F d, Y h:i A', strtotime($result['post_modified']));

                if ($result['request_tracking_code'] == 'y' && empty($result['tracking_code'])) {
                    // Ask for the shipping provider and tracking code
                    $warranty_actions .= warranty_request_shipping_tracking_code_form($result);
                }

                if (!empty($result['return_tracking_code']) || !empty($result['tracking_code'])) {
                    $warranty_actions .= warranty_return_shipping_tracking_code_form($result);
                }

                $shipping_label_id = get_post_meta($result['ID'], '_warranty_shipping_label', true);

                if ($shipping_label_id) {
                    ob_start();
                    ?>
                    <strong><?php _e('Shipping Label', 'wc_warranty'); ?></strong><br/>
                    <?php
                    $shipping_label_file_url = wp_get_attachment_url($shipping_label_id);
                    $post_mime_type = get_post_mime_type($shipping_label_id);

                    if ($post_mime_type == 'application/pdf') {
                        echo '<a href="' . $shipping_label_file_url . '"><img src="' . plugins_url('/assets/images/pdf-icon.png', dirname(__FILE__)) . '" />&nbsp; ' . __('Download', 'wc_warranty');
                    } else {
                        echo '<a href="' . $shipping_label_file_url . '">' . __('Download return label', 'wc_warranty') . '</a>';
                    }

                    $warranty_actions .= ob_get_clean();
                }

                if (!empty($result['refunded']) && $result['refunded'] == 'yes') {
                    $refund_amount = get_post_meta($result['ID'], '_refund_amount', true);
                    $refund_date = get_post_meta($result['ID'], '_refund_date', true);

                    if ($refund_amount && $refund_date) {
                        $pretty_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($refund_date));
                        $warranty_details[] = sprintf(__('Item has been refunded the amount of %s on %s', 'wc_warranty'), wc_price($refund_amount), $pretty_date);
                    } else {
                        $warranty_details[] = __('Item has been refunded', 'wc_warranty');
                    }
                }
                ?>
                <tr>
                    <td>
                        <strong><?php echo $result['code']; ?></strong>
                        <br/>
                        <small>
                            <?php echo __('created on ', 'wc_warranty') . date_i18n(wc_date_format() . ' ' . wc_time_format(), strtotime($result['post_date'])); ?>
                        </small>
                    </td>
                    <td>
                        <?php
                        foreach ($result['products'] as $product) {
                            echo '<a href="' . get_permalink($product['product_id']) . '">' . warranty_get_product_title($product['product_id']) . '</a> &times; ' . $product['quantity'] . '<br/>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo '<ul class="warranty-data">';

                        foreach ((array) $warranty_details as $detail) {
                            echo '  <li>' . $detail . '</li>';
                        }

                        echo '</ul>';

                        echo $warranty_actions;
                        ?>
                    </td>
                    <td><?php echo $status; ?></td>
                </tr>
                <?php
            }
        }else{
            echo ' <tr><td colspan="4">No request found!</td> </tr>';
        }
        ?>
    </table>
</form>
