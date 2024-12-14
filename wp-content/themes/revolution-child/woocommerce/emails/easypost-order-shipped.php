<?php
if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action('woocommerce_email_header', $email_heading, $email);
?>
<h2>Hi <?php echo $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() ?>,</h2>
<p><?php
    if ($sent_to_admin) {
        $before = '<a class="link" href="' . esc_url($order->get_edit_order_url()) . '">';
        $after = '</a>';
    } else {
        $before = '';
        $after = '';
    }
    /* translators: %s: Order ID. */
    echo wp_kses_post($before . sprintf(__('Item(s) from your order #%s have been shipped.', 'woocommerce') . $after . ' <time datetime="%s">%s</time>', $order->get_order_number(), $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())));
    ?></p>
<p><?php
    /* translators: %s: Order ID. */
    echo wp_kses_post(sprintf(__('Tracking Code: %s ', 'woocommerce'), $_POST['easypost_tracking_number']));

    echo '<br/>';

    ?></p>

<div style="margin-bottom: 40px;">
    <div style="text-align: center">
        <a href="<?php echo $_POST['easypost_tracking_url']; ?>" style="text-decoration:none;background:#3c98cc;color:#ffffff;font-weight:bold;font-size:16px;width:1080px;padding:12px" target="_blank" >TRACK YOUR ORDER</a>
    </div>

    <?php /*
      <table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
      <thead>
      <tr>
      <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Product', 'woocommerce'); ?></th>
      <th class="td" scope="col" style="text-align: center;"><?php esc_html_e('Date Shipped', 'woocommerce'); ?></th>
      <th class="td" scope="col" style="text-align: center;"><?php esc_html_e('Quantity Shipped', 'woocommerce'); ?></th>
      </tr>
      </thead>
      <tbody>
      <?php
      foreach ($order->get_items() as $item_id => $item) :
      ?>
      <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
      <td class="td" style="text-align:<?php echo $text_align; ?>; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
      fdfdf
      </td>
      <td class="td" style="text-align: center; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">

      </td>
      <td class="td" style="text-align: center; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">

      </td>
      </tr>
      <?php
      endforeach;
      ?>
      </tbody>
      </table>
     */
    ?>
</div>

<?php
//do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);
do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);

do_action('woocommerce_email_footer', $email);
