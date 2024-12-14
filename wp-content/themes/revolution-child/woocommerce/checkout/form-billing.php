<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
<?php $userDataSubmitted = $_SESSION['customer_info_new1'];
?>
<div class="woocommerce-billing-fields">
    <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

        <h3><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>

    <?php else : ?>

        <h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>

    <?php endif; ?>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing">
        <?php
        $billing_val_def = '';
        $fields = $checkout->get_checkout_fields('billing');
        $counter = 1;
        foreach ($fields as $key => $field) {
            // echo $key.'=>';
            if ($counter == 1) {
                echo '<div class="left-container woocommerce-billing-fields__field-wrapper">';
            }
            if ($counter == 5) {
                //  echo $counter.'counter';
                echo '</div> <div class="right-container woocommerce-billing-fields__field-wrapper">';
            }
            if ($counter == 10) {
                echo '</div>';
            }
            if ($key == 'kl_newsletter_checkbox') {
                $field['default'] = 1;
                $field['class'][1] = 'default-hide';
                //print_r($field);
            }
            if($key == 'billing_email' && $checkout->get_value($key)==''){
                $billing_val_def = isset($_COOKIE['billing_email']) ? $_COOKIE['billing_email'] : $checkout->get_value($key);
            }
            woocommerce_form_field($key, $field, $checkout->get_value($key));
            $counter++;
        }
        
        ?>
    </div>
    <script>
        jQuery(document).ready(function () {
            setTimeout(function () {
                jQuery('#billing_email').val('<?php echo $billing_val_def; ?>');
            }, 1000);

        });
    </script>
    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked(( true === $checkout->get_value('createaccount') || ( true === apply_filters('woocommerce_create_account_default_checked', false) )), true); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>

<script>
<?php
if (count($userDataSubmitted) > 0) {
    $userDataSubmitted = json_encode($userDataSubmitted);
    ?>
        jQuery(document).ready(function () {
            userdata = <?php echo $userDataSubmitted; ?>;
            console.log(userdata);
            $.each(userdata, function (key, data) {
                jQuery('#' + key).val(data);

            })
        });

<?php }
?>
    $(window).on('beforeunload', function () {
        $('#target-div-id').find('select, textarea, input').serialize();
        customer_info = $('#customer_details').find('select, textarea, input, checkbox').serialize();
        //$('#customer_details :input','#customer_details :select').serialize();
        console.log(customer_info);

        jQuery.ajax({
            type: 'POST',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: customer_info + '&action=save_customer_info_checkout',
            async: true,
            success: function (data) {
                //alert(data);
            }
        });
        //console.log(customer_info);
    });
</script>
