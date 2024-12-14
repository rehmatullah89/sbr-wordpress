<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action('woocommerce_email_header', $email_heading, $email);
?>
<div style="margin-bottom: 40px;">
    <p>The dental impressions you sent have been received by our lab!.</p>
    <p>Our technicians are currently reviewing them to make sure they are usable. If there is an issue, you&apos;ll receive another email with further instructions.</p>
    <p>Otherwise, sit back and relax!...we&apos;ll get to work on making your custom-fitted <?php echo $_POST['dental_product']; ?>.</p>
</div>

<?php
$additional_content = 'Thanks for using <a href="' . site_url() . ' target="_blank">www.smilebrilliant.com</a>!';
echo wp_kses_post(wpautop(wptexturize($additional_content)));

//do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);

do_action('woocommerce_email_footer', $email);
