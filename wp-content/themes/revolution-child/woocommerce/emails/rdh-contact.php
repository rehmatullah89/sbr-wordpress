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
$rdh_customer = $_REQUEST['rdh-name'];
$username = $_REQUEST['user-name'];
$query_type = $_REQUEST['type'];
$rdh_email = $_REQUEST['user-email'];
$message = $_REQUEST['message'];
/*
$message = str_replace("'", ",", $message);
$message = str_replace("‘", ",", $message);
$message = str_replace("\‘", "", $message);
$message = str_replace("\'", "\\'", $message);
$message = str_replace("'", "&#8217;", $message);
*/
?>
<html lang="en">

<body>
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td style="padding:36px 20px 42px 20px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td align="center">
                    <img style="margin:0 0 12px 0; max-width: 250px;" src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png"></img>
                  </td>
                </tr>

                <tr>
                  <td>
                    <h5 style="margin:0;font-size:16px;line-height: 1.5;font-family:Arial,sans-serif;">Hi <?php echo $rdh_customer; ?>,</h5>
                    <p>The following individual has left a message for you. Please contact them at the earliest:</p>
                    <p>Contact Name: <?php echo $username; ?></p>
                    <p>Contact Email: <?php echo $rdh_email; ?></p>
                    <p>Message Type: <?php echo $query_type; ?></p>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;vertical-align:top;">
                    <h5 style="margin:0;font-size:16px;line-height: 1.5;font-family:Arial,sans-serif;">Query:</h5>
                    <hr />
                    <p><?php echo stripslashes($message); //str_replace("'", "&lsquo;", $message); 
                        ?></p>
                    <hr />
                  </td>
                </tr>

                <tr>
                  <td style="padding:0;vertical-align:top;">
                    <h5 style="font-family:Arial,sans-serif; line-height: 1.5;">
                      This is a free service for RDHCs powered by rdhconnect.com
                    </h5>
                    <h4 style="font-family:Arial,sans-serif; line-height: 1.5;">
                      The RDH Connect Team
                    </h4>
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