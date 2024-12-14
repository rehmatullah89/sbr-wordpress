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
$rdh_username = $_REQUEST['RDH_display_name'];
if(isset($_REQUEST['field_1'])){
    $rdh_username = $_REQUEST['field_1'];
}
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
                                <!-- <tr>
                                    <td style="padding:0 0 20px 0 ;">
                                        <h4 style="font-size:18px;margin:0 0 20px 0;font-family:Arial,sans-serif;line-height: 1.5; font-size: 22px; font-weight: 800;">Welcome to the first community created for hygienists, by hygienists.</h4>
                                    </td>

                                </tr> -->
                                <tr>
                                    <td align="center">
                                        <img style="margin:0 0 12px 0; max-width: 250px;" src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png"></img>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h5 style="margin:0;font-size:16px;line-height: 1.5;font-family:Arial,sans-serif;"><?php echo $rdh_username; ?>,</h5>
                                        <br/>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="padding:0;vertical-align:top;">
                                                    <p style="font-family:Arial,sans-serif;line-height: 1.5;">Welcome to RDH Connect! We’re happy you’re here!</p><br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;vertical-align:top;">
                                                    <p style="font-family:Arial,sans-serif;line-height: 1.5;">RDH Connect is the first community of its kind to bring dental hygienists together as colleagues & professionals. As a member, you’ll build connections, find unique professional opportunities, and influence the conversation around oral health.</p>
                                                    <br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;vertical-align:top;">
                                                    <p style="font-family:Arial,sans-serif; line-height: 1.5;">
                                                        As we prepare for the 2023 launch, we’ll stay in touch to introduce you to the team behind the community, Smile Brilliant & its products, share exciting updates, and more.
                                                    </p>
                                                    <br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;vertical-align:top;">
                                                    <p style="font-family:Arial,sans-serif; line-height: 1.5;">
                                                        We would love to hear from you too! Feel free to respond to tell us more about you or to share thoughts & feedback.

                                                    </p>
                                                    <br/><br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0;vertical-align:top;">
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
            </td>
        </tr>
    </table>
</body>

</html>