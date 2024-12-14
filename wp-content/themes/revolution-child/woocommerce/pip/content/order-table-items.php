<?php
/**
 * WooCommerce Print Invoices/Packing Lists
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Print
 * Invoices/Packing Lists to newer versions in the future. If you wish to
 * customize WooCommerce Print Invoices/Packing Lists for your needs please refer
 * to http://docs.woocommerce.com/document/woocommerce-print-invoice-packing-list/
 *
 * @package   WC-Print-Invoices-Packing-Lists/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2011-2021, SkyVerge, Inc. (info@skyverge.com)
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */
defined('ABSPATH') or exit;

/**
 * PIP Template Body before content
 *
 * @var \WC_Order $order order object
 * @var int $order_id order ID
 * @var \WC_PIP_Document $document document object
 * @var string $type document type
 * @var string $action current document action
 *
 * @version 3.6.2
 * @since 3.0.0
 */
?>
<tbody class="order-table-body">

    <?php $table_rows = $document->get_table_rows(); ?>

    <?php foreach ($table_rows as $rows) : ?>

        <?php if (!empty($rows['headings']) && is_array($rows['headings'])) : ?>

            <tr class="row heading">

                <?php foreach ($rows['headings'] as $cell_id => $cell) : ?>

                    <?php if (!empty($cell['content'])) : ?>

                        <th class="<?php echo sanitize_html_class($cell_id); ?>" <?php
                        if (!empty($cell['colspan'])) {
                            echo 'colspan="' . (int) $cell['colspan'] . '"';
                        }
                        ?>>
                                <?php echo $cell['content']; ?>
                        </th>

                    <?php endif; ?>

                <?php endforeach; ?>

            </tr>

        <?php endif; ?>

        <?php
        $order = $document->order;

        foreach ($order->get_items() as $item_id => $item) {
            $flag = false;
            if ($composite_container_item = wc_cp_get_composited_order_item_container($item, $order)) {
                $flag = false;
            } else if (wc_cp_is_composite_container_order_item($item)) {
                $flag = true;
            } else {
                $flag = true;
            }
            if ($flag) {

                $product = $item->get_product();
                //echo 'Data: <pre>' .print_r($item,true). '</pre>';
                //die;
                // $pro_price = $product->get_price_html();
                $pro_price = $item->get_total();
                $item_quantity = $item->get_quantity(); // Get the item quantity
                $product_id = $item->get_product_id();
                echo '<tr class=" row item">';
                echo '<td>' . $product->get_sku() . '</td>';

                echo '<td>' . $product->get_title() . '</td>';
                echo '<td>' . $item_quantity . '</td>';
                echo '<td>$' . number_format_i18n($pro_price, 2) . '</td>';

                echo '</tr>';
            }
        }

        /*
          ( ! empty( $rows['items'] ) ) : $i = 0; ?>

          <?php foreach ( $rows['items'] as $items ) : ?>
          <?php if ( ! empty( $items ) && is_array( $items ) ) : $i++;
          ?>

          <tr class="ass row item <?php echo $i % 2 === 0 ? 'even' : 'odd'; ?>">

          <?php foreach ( $items as $cell_id => $cell_content ) : ?>

          <td class="<?php echo sanitize_html_class( $cell_id ); ?>">
          <?php echo $cell_content; ?>
          </td>

          <?php endforeach; ?>

          </tr>

          <?php endif; ?>

          <?php endforeach; ?>

          <?php endif;
         */
        ?>

    <?php endforeach; ?>

</tbody>
					<?php
