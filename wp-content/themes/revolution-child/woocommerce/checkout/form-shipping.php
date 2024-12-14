<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */
defined('ABSPATH') || exit;
?>
<div class="woocommerce-shipping-fields">
    <?php if (true === WC()->cart->needs_shipping_address()) : ?>
        <h3 class="custom-heading">SHIPPING DETAILS</h3>
        <h3 id="ship-to-different-address" style="display:none;">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0 ), 1); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e('Ship to a different address?', 'woocommerce'); ?></span>
            </label>
        </h3>
         <h3 id="ship-to-different-address-2">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input id="ship-to-different-address-checkbox-2" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" checked type="checkbox" name="ship_to_different_address_2" value="1" /> <span><?php esc_html_e(' My shipping address is the same as my billing address', 'woocommerce'); ?></span>
            </label>
        </h3>

        <div class="shipping_address">

            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="woocommerce-shipping-fields__field-wrappers">
                <?php
                $fields = $checkout->get_checkout_fields('shipping');
                $counter = 1;
                foreach ($fields as $key => $field) {
                    if ($key == 'shipping_country' && $checkout->get_value($key) == '') {
                        ?>
                        <script>
                            jQuery(document).ready(function () {
                                jQuery('#shipping_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');
                            });
                        </script>
                        <?php
                    }
                    if($counter==1){
                echo '<div class="left-container woocommerce-shipping-fields__field-wrapper">';
            }
            if($counter==3){
              //  echo $counter.'counter';
                echo '</div> <div class="right-container woocommerce-shipping-fields__field-wrapper">';
            }
            if($counter==9){
                echo '</div>';
            }
                    woocommerce_form_field($key, $field, $checkout->get_value($key));
                    $counter++;
                }
                ?>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

        </div>

    <?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

        <?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

            <h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>

        <?php endif; ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>
