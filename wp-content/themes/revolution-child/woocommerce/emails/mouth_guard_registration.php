<?php

/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */
defined('ABSPATH') || exit;
//do_action('woocommerce_email_header', $email_heading, $email);
?>
<html lang="en">

<body>
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;    background: #002244;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:0px solid #cccccc;border-spacing:0;text-align:center;">
          <tr>
            <td style="padding:36px 20px 42px 20px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td align="center">
                    <img style="margin:0 0 12px 0" src="https://www.smilebrilliant.com/wp-content/uploads/2023/07/mouth-gaurd-proshield.jpg"></img>
                  </td>
                </tr>

                <tr>
                  <td>

                    <h5 style="font-family:Arial,sans-serif;line-height: 1.5;color:#fff;font-size: 18px;margin-bottom: 0;margin-top: 7px;text-align: left;font-weight: 400;margin-bottom: 20px;text-align:center;">
                      <!-- PRECISION-FIT CUSTOM MOUTH GUARD -->
                      <span style="font-family:Arial,sans-serif;color: #69be28;"><?php echo $_REQUEST['first_name'] ?>, </span>we have confirmed your account registration with Smile Brilliant / ProShield! Your registration ID is <span style="font-family:Arial,sans-serif;color: #69be28;"><?php echo $_REQUEST['tray_number'] ?></span>
                      Please present this ID to your agent before they begin your scan. Login details have been emailed to your email address at <?php echo $_REQUEST['form_email']; ?>.
                    </h5>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;vertical-align:top;text-align:center">
                    <img class="produt-image" style="width:380px" src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/pro-shield/pro-shield-banner-image.png">
                    </div>
                  </td>
                </tr>

                <tr>
                  <td style="padding:0;vertical-align:top; text-align:center;">

                    <a href="https://smilebrilliant.com/product/proshield/" class="btn btn-primary-teal btn-lg" style="text-decoration: none;margin-top:0px;margin-bottom:20px;min-width:284px;font-size: 20px;letter-spacing: 0;color: #ffffff;background: #69be28;padding: 15px 17px;border-color: #69be28;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;/* border: 2px solid; */font-weight: 300;font-family: Arial,sans-serif; margin-top:20px;">SEE PRICING &amp;
                      OPTIONS</a>

                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>

<?php
//do_action('woocommerce_email_footer', $email);
