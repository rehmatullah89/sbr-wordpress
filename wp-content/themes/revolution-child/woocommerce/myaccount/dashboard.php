<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$myaddresses = current_user_shipping_addresses();
if (count($myaddresses) == 0) {
    creat_initila_address_from_default();
}
$field_value = '';
if(function_exists('bp_is_active')){
$field_value = bp_get_profile_field_data(array(
    'field' => 'Referral',
    'user_id' => get_current_user_id(),

));
}
$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);

?>
<style>
    .sideBarNavigationList {
        display: none;
    }

    .flexDesktop .myAccountContainerMbtInner {
        max-width: 100%;
        width: 100%;
    }

    .container.fullWidthSection {
        padding-right: 0px;
        padding-left: 0px;
    }

    .accescodedata.after-success #geha-coupon-code-box {
        margin-top: 10px;
        margin-bottom: 0;
        color: #828282;
        padding: 19px;
        background-color: #fff;
        border-color: #ebebeb;
        line-height: 1;
        max-width: 100%;
        border: 0;
        border-style: solid;
        border-radius: 5px;
        /* max-width: 100%;
        border: 0; */
    }

    .accescodedata.after-success #geha-coupon-code-box .view-my-public-profile {
        line-height: 0;
        margin-top: 5px;
    }

    .accescodedata.after-success #geha-coupon-code-box .view-my-public-profile a {
        font-size: 15px;
        line-height: 1;
        text-decoration: underline;
        color: #828282;
        text-transform: uppercase;
    }

    .patient-acces-code-row {
        display: flex;
        justify-content: center;
        flex-direction: column;
    }

    .span-acces {
        font-size: 15px;
        text-transform: uppercase;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

</style>
<section class="page-container">
    <div class="container fullWidthSection">
        <div class="db-row justify-content-center db-row-edit-container">
            <?php if (wp_is_mobile() || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
                get_template_part('page-templates/my-account-v2');
            }
            else{?>
            <div class="db-col-12">

                <h2 class="helloMesageLimit">
                    <?php
                    printf(
                        /* translators: 1: user display name 2: logout url */
                        wp_kses(__('Hello %1$s', 'woocommerce'), $allowed_html),
                        '<strong class="mobileBlock">' . esc_html($current_user->first_name) . '</strong>',
                        esc_url(wc_logout_url())
                    );
                    ?>

                </h2>



                <div class="accountDashboardMes fullwidthForcustomerRdh">

                    <!-- only normal customer -->
                    <?php if ($field_value == '' && wc_get_customer_order_count(get_current_user_id()) > 0) {
                    ?>
                        <style>
                            .paragraphTextTop {
                                display: none;
                            }
                        </style>
                        <p class="forOnlyCustomers text-gray">From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                        <p class="forOnlyCustomers text-gray">You can also join our rewards program and earn commission on different Smile Brilliant products. </p>
                    <?php } ?>

                    <?php if ($field_value != '' && wc_get_customer_order_count(get_current_user_id()) == 0) {

                    ?>
                        <!-- only RDH customer -->
                        <style>
                            .paragraphTextTop {
                                display: none;
                            }
                        </style>
                        <p class="forOnlyCustomers text-gray">From your account dashboard you can manage your RDHC profile including your contact, professional and social media details.</p>
                    <?php } ?>

                    <div class="paragraphTextTop">
                        <p class="text-gray" style="display: none;">
                            From your account dashboard you can manage your RDHC profile including your contact, professional and social media details.
                        </p>
                        <p class="text-gray">
                            You can also join our rewards program and earn commission on different Smile Brilliant products.
                        </p>
                        <p class="text-gray">
                            Moreover, you can check your orders, manage shipping and billing addresses, view your recent orders and edit your password and account details.
                        </p>
                    </div>
                    <p class="text-gray" style="display:none;">
                        <?php
                        $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
                        if (wc_shipping_enabled()) {
                            $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
                        }
                        printf(
                            wp_kses($dashboard_desc, $allowed_html),
                            esc_url(wc_get_endpoint_url('orders')),
                            esc_url(wc_get_endpoint_url('edit-address')),
                            esc_url(wc_get_endpoint_url('edit-account'))
                        );
                        ?>
                    </p>

                    <?
                    $access_code = get_user_meta(get_current_user_id(), 'access_code', true);

                    if ($access_code != '') {
                        ?>
                        <div class="row">

                            <div class="col-12 displayField accescodedata after-success">
                                <div id="geha-coupon-code-box" class="font-mont">
                                    <div class="patient-acces-code-row">
                                        <span class="span-acces"> patient Access Code </span> <span class="span-acces-code">
                                            <?php echo $access_code; ?></span>
                                    </div>
                                    <?
                            $current_user = wp_get_current_user();
                            if ($current_user->ID != 0) {
                                $username = $current_user->user_login;
                            }
                            ?>
                                    <div class="view-my-public-profile"><a href="/dentist/<? echo $username; ?>">
                                            <i class="fa fa-link" aria-hidden="true"></i> View My Public Profile</a>
                                    </div>

                                </div>
                            </div>

                            
                        </div>
                    <? } ?>

                </div>


<?php
$shine_user = get_user_meta($current_user->ID, 'is_shine_user', true);
$shine_subsc_id = '';
if($shine_user){
    global $wpdb;
    $results = $wpdb->get_row("Select subscription_id, next_order_date from sbr_subscription_details where user_id=$current_user->ID AND shine_group_code <> 0 Order by id DESC LIMIT 1", "ARRAY_A");
    $shine_subsc_id = @$results['subscription_id'];
    $shine_exp_date = date("m/d/Y", strtotime(@$results['next_order_date']));
    $plan = explode("(", get_user_meta($current_user->ID, 'shine_current_member_ship_plan', true) ?: 'N/A');
?>                
<div class="owl-item ">
   <div class="item">
      <div class="testimonial-one__single">
         <div class="ribbon ribbon-top-left"><span><span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span> Card</span></div>
         <div class="testimonial-one__single-inner">
            <!-- <div class="testimonial-one__shape-1">
               <img decoding="async" src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/icons/card-shape.png" alt="alt">
            </div> -->
            <div class="testimonial-one__client-info">
               <div class="testimonial-one__client-img-box">
                      <img decoding="async" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/profile-icon.svg" alt="alt">
               </div>
               <div class="testimonial-one__client-content">
                  <div class="testimonial-one__client-details">
                     <h3 class="testimonial-one__client-name"><?php echo esc_html($current_user->first_name.' '.$current_user->last_name); ?></h3>
                     <div class="itemm-row policyNmber"><span class="imt1">Policy Code:</span><span class="imt2"><?php echo  get_user_meta($current_user->ID, 'shine_plan_code', true)?:'N/A';?></span></div>
                     <div class="itemm-row dob-item"><span class="imt1">DOB:</span><span class="imt2"><?php echo get_user_meta($current_user->ID, 'dob', true)?:'N/A';?></span></div>
                     <div class="itemm-row dob-item"><span class="imt1">Email:</span><span class="imt2"><?php echo esc_html($current_user->user_email);?></span></div>
                     <div class="itemm-row memberIDtt"><span class="imt1">Member ID:</span><span class="imt2"><?php echo str_pad($current_user->ID, 8, '0', STR_PAD_LEFT);?></span></div>
                  </div>
               </div>
            </div>
                    <div class="download-your-insurance-card">
                    <!-- download-shine-card -->
                        <a href="/my-account/shine_subscription/" class="btn" id="">
                        
                           View Membership
                        </a>
                    </div>

         </div>
      </div>
   </div>
</div>
<?php
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
        $(document).ready(function() {
        $('#download-shine-card').on('click', function() {
            var element = document.getElementById('card-to-print');
            
            // Wait for images to load
            var images = element.getElementsByTagName('img');
            var totalImages = images.length;
            var loadedImages = 0;

            for (var i = 0; i < totalImages; i++) {
                images[i].onload = function() {
                    loadedImages++;
                    if (loadedImages === totalImages) {
                        // All images are loaded, generate PDF
                        html2pdf().from(element).set({
                            margin: 1,
                            filename: 'shine-card.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2, useCORS: true },
                            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                        }).save();
                    }
                };
                // Handle the case where images are already cached
                if (images[i].complete) {
                    images[i].onload();
                }
            }
        });
    });
    </script>



<div style="display: none;">


<div class="card-print-wrapper"> 
            <div id="card-to-print">
             <table class="front-card front-card-mobile"
                style="width: 600px;height: 300px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:18px;border-radius:18px;border: 2px solid #000;    border-spacing: 0;    border-collapse: separate;    border-spacing: 1px;">
                <tr style="border-radius:10px;    background: none;">
                    <td colspan="2" style="padding:0;padding-bottom: 20px; padding-top: 0;border-radius:10px;    background: none;">
                        <table
                            style="width: 100%;    border-spacing: 0;border-spacing: 0;    border-collapse: separate;border-radius:10px;margin:0;">
                            <tr style="border-radius:10px;    background: none;">
                                <td colspan="2" style="width: 100%;  padding:0;  padding-top: 0; border-radius:10px;    background: none;">
                                    <div style="float: left;width: 100%;    margin-top: -2px;">
                                        <div
                                            style="width:25%;background-color:#2d2e2f;font-size:0px;height:10px;    float: left;     border-radius: 14px 0 0 0;">
                                            &nbsp;1</div>
                                        <div
                                            style="width:25%;background-color:#fa319e;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;2</div>
                                        <div
                                            style="width:25%;background-color:#4acac9;font-size:0px;;height:10px;    float: left;">
                                            &nbsp;3</div>
                                        <div
                                            style="width:25%;background-color:#f0c23a;font-size:0px;;height:10px;    float: left;        border-radius: 0px 14px 0px 0px;">
                                            &nbsp;4</div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-radius:10px;border-radius:10px;    background: none;">
                                <td
                                    style="padding:0;width: 60px;padding-left: 20px;padding-top: 1rem;border-radius:10px;    background: none;">
                                    <img class="img-fluid"
                                        src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/product-shine/images/shine-smile.png"
                                        alt="Shine" style="max-width: 100px;"></td>
                                <td
                                    style="padding:0;text-align: center;padding-right: 1rem;padding-top: 1rem;border-radius:10px;    background: none;">
                                    <span
                                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 32px;color: #565759;"><?php echo @$plan[0]; ?></span><br>
                                    <div
                                        style="text-align: left;margin-top: 3px;padding-left: 74px;border-radius:10px;">
                                        <span><span
                                                style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 10px;color: #565759;padding-right: 5px;border-radius:10px;">by</span>
                                            <img style="max-width: 120px;
    " src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/sbr-logo-text.webp"
                                                alt="SmileBrilliant"></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="background: none;"> 
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        MEMBER :</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo strtoupper(esc_html($current_user->first_name . ' ' . $current_user->last_name)); ?></strong>
                    </td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        MEMBER ID:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo str_pad($current_user->ID, 8, '0', STR_PAD_LEFT); ?></strong></td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        GROUP NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <strong><?php echo get_user_meta($current_user->ID, 'shine_plan_code', true) ?: 'N/A'; ?></strong>
                    </td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 20px;line-height: 1;    background: none;">
                        EXPIRATION:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 20px;line-height: 1;    background: none;">
                        <strong><?php echo $shine_exp_date; ?></strong></td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        PLAN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        <?php if($shine_user){ ?>
                        <span><?php echo str_pad($shine_subsc_id, 8, '0', STR_PAD_LEFT); ?></span> <span
                            style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 14px;color: #25d4cd;line-height: 1;    background: none;"><?php echo @$plan[0]; ?></span>
                        <?php echo (@$plan[1] ? '(' . @$plan[1] : ''); ?>
                    <?php } ?>
                    </td>
                </tr>
                <tr style="background: none;">
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 16px;color: #565759;padding-left: 40px;padding-bottom: 0px;line-height: 1;    background: none;">
                        Rx BIN NO:</td>
                    <td
                        style="font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 700;font-style: normal;font-size: 16px;color: #565759;padding-bottom: 0px;line-height: 1;    background: none;">
                        011867</td>
                </tr>
                <tr style="border-radius:10px;    background: none;">
                    <td colspan="2" style="padding:0;padding-top: 20px;border-radius:10px;    background: none;">
                        <table
                            style="width: 100%;width: 100%;border-collapse: separate;margin: 0;border-spacing: 1px;border-radius:10px;    background: none;">
                            <tbody style="border: 0;background: none;padding: 0;border-radius:10px;">
                                <tr style="border-radius:10px;    background: none;">
                                    <td
                                        style="padding:0;text-align: center; padding-left: 15px;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/sbr-logo.webp"
                                            alt="" style="max-height: 40px;"></td>
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="https://www.smilebrilliant.com/wp-content/uploads/2024/07/optum-rx-logo.svg"
                                            alt="Optum Rx" style="max-width: 90px;"></td>
                                    <td style="padding:0;text-align: center;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="https://www.smilebrilliant.com/wp-content/uploads/2024/07/logo_CTCV.png"
                                            alt="Coast to Coast Vision" style="max-width: 115px;"></td>
                                    <td
                                        style="padding:0;text-align: center;    padding-right: 15px;padding-bottom: 10px;border-radius:10px;    background: none;">
                                        <img src="https://www.smilebrilliant.com/wp-content/uploads/2024/07/logosm_aetna.png"
                                            alt="Aetna Dental Access®" style="height: 52px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="shine-back-card"
                style="width: 600px;height: 300px;border-radius: 15px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #fff;padding: 0px;box-sizing: border-box;-moz-border-radius: 14px;-webkit-border-radius:14px;border-radius:14px;border: 2px solid #000;border-spacing: 0;margin-top:2rem;padding:1rem;font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 14px;color: #565759;padding-left: 16px;padding-bottom: 7px;line-height: 1;padding-top: 10px; border-collapse: separate;">
                <tbody style="border: 0;background-color: transparent;font-size:13px;">
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            Smile Brilliant Customer Service: <strong style="font-weight:700;"> 855-944-8361</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            Aetna Dental Access® Plan:<strong style="font-weight:700;"> XXX-XXX-XXXX</strong>
                        </td>
                    </tr>

                    <?php
if (isset($plan[0]) && str_contains(strtolower($plan[0]), 'complete')) {?>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            OptumRx Pharmacy Plan: <strong style="font-weight:700;">877-459-8474 (price quotes:
                                844-239-7397)</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="background: none;">
                            Coast to Coast Vision Plan: <strong style="font-weight:700;">800-878-3901 (price quotes:
                                XXX-XXX-XXXX)</strong>
                        </td>
                    </tr>
                    <?php }?>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 20px;    background: none;">
                            To view your account details or get discounts on Smile Brilliant Products:<br>
                            <a style="color: #565759;font-weight:700;text-decoration:none;"
                                href="http://www.smilebrilliant.com/my-account">www.smilebrilliant.com/my-account</a>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 10px;background: none;">
                            Search for a provider:<br>
                            <a href="http://www.smilebrilliant.com/shine-search"
                                style="color: #565759;font-weight:700;text-decoration:none;">www.smilebrilliant.com/shine-search</a>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2" style="padding-top: 20px;background: none;">
                            PROVIDERS: <strong style="font-weight:700;">Use 866-868-6199 to check eligibility</strong>
                        </td>
                    </tr>
                    <tr style="background: none;">
                        <td colspan="2"
                            style="padding-top: 20px; font-family: &quot;Montserrat&quot;, sans-serif;font-optical-sizing: auto;font-weight: 500;font-style: normal;font-size: 12px;color: #565759;padding-bottom: 15px;line-height: 1.2; background: none;">
                            <strong style="font-weight:700;">Shine is NOT</strong> insurance. Shine provides access to
                            the Aetna Dental Access® network which is administered by Aetna Life Insurance Company
                            (ALIC). Neither ALIC nor any of its affiliates is an affiliate, agent, representative or
                            employee of [the discount program]. Dental providers are independent contractors and not
                            employees or agents of ALIC or its affiliates. ALIC does not provide dental care or
                            treatment and is not responsible for outcomes.
                        </td>
                    </tr>
                </tbody>
            </table>

            </div>
        </div>


<!-- <table id="card-to-print"  style="width: 426px; height: 250px; border-collapse: collapse; font-family: Arial, sans-serif; border-radius: 15px; overflow: hidden; background-color: #2c2c2c; color: #fff;    border-radius: 20px;
    box-sizing: border-box;background-image: linear-gradient(45deg, #4597cb, #002244);">
    <tbody style="
    background: none;
    background-color: transparent;
    border: 0;
">
  <tr style="background-color: #3498db;background-image: url(https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/sbr-logo.webp);background-size: 46px;background-repeat: no-repeat;background-position: 9px center;">
    <th style="text-align: right; padding-bottom: 0;">
      <img class="img-fluid" src="https://stable.smilebrilliant.com/wp-content/themes/revolution-child/assets/product-shine/images/shine-package-3.png" alt="Shine" style="max-width: 72px;">
    </th>
    <th  style="text-align: left; font-size: 1.5em; padding-bottom: 0px; padding-top: 0;">
      <div class="shine-text-wrap" style="    color: #fff;
    font-family: 'Montserrat';">
        <span class="shine-text"><?php 
        $plan = explode("(", get_user_meta($current_user->ID, 'shine_current_member_ship_plan', true)?:'N/A');
        echo @$plan[0]; ?></span>
      </div>
    </th>    
    
    
  </tr>
 
  <tr style="
    background: none;
    background-color: transparent;
    border: 0;
    color: #fff;
">
    
    <td colspan="2" style="text-align: center; font-size: 1.2em; font-weight: bold; padding: 10px;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';">
      <?php echo esc_html($current_user->first_name.' '.$current_user->last_name); ?>
    </td>
  </tr>
  <tr style="
    background: none;
    background-color: transparent;
    border: 0;
    color: #fff;
">
    <td style="padding: 10px;text-align: right;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"><span style="color: #ffffff;font-size: 0.9em;">POLICY CODE:</span></td>
    <td style="padding: 10px;text-align: left;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"> <?php echo  get_user_meta($current_user->ID, 'shine_plan_code', true)?:'N/A';?></td>
  </tr>
  <tr style="
    background: none;
    background-color: transparent;
    border: 0;
    color: #fff;
">
    <td style="padding: 10px;text-align: right;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"><span style="color: #ffffff;font-size: 0.9em;">Email:</span></td>
    <td style="padding: 10px;text-align: left;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"> <?php echo esc_html($current_user->user_email);?></td>
  </tr>
  <tr style="
    background: none;
    background-color: transparent;
    border: 0;
    color: #fff;
">
      <td style="padding: 10px;text-align: right;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"><span style="color: #ffffff;font-size: 0.9em;">MEMBER ID:</span></td>
    <td style="padding: 10px;text-align: left;    padding-top: 5px;    color: #fff;
    font-family: 'Montserrat';"> <?php echo str_pad($current_user->ID, 8, '0', STR_PAD_LEFT);?></td>
    
  
  </tr></tbody>
</table> -->


</div>


            </div>
            <?php if ($field_value == '') {
            ?>
                <div class="col-md-4 db-col-6 padd-right7">
                    <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box profileSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/profile-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Profile</strong></h4>
                                    <p class="text-gray">Manage and edit your name or email.</p>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>

                <div class="col-md-4 db-col-6 padd-left7">
                    <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box orderSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/orders-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Orders</strong></h4>
                                    <p class="text-gray">Track, return or buy items again.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 db-col-6 padd-right7">
                    <a href="<?php echo esc_url(wc_get_endpoint_url('manage-shipping-address')); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box BillingShippingSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/billing-shipping-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Shipping</strong></h4>
                                    <p class="text-gray">Manage your shipping addresses.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 db-col-6 padd-right7">
                    <a href="<?php echo esc_url(wc_get_endpoint_url('payment-methods')); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box BillingShippingSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/payment-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Billing</strong></h4>
                                    <p class="text-gray">Manage Billing Methods.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } else {

            ?>
                <style>

                </style>
                <div class="col-md-4 db-col-6 padd-right7">
                    <?php 	if(function_exists('bp_is_active')){ ?>
                    <a href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box profileSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon rdh_icon_white">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/RDH.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>RDHC</strong></h4>
                                    <p class="text-gray">Manage your RDHC public profile</p>
                                </div>
                            </div>

                        </div>
                    </a>
                    <?php } ?>
                </div>




                <?php
                if ($field_value != '' && wc_get_customer_order_count(get_current_user_id()) > 0) {
                ?>
                    <div class="col-md-4 db-col-6 padd-left7">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="linkdetail block ripple-button">
                            <div class="dashboard-box orderSection">
                                <div class="dashboardPanel">
                                    <div class="dashboard-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/orders-icon.svg" alt="" />
                                    </div>
                                    <div class="dashboard_description">
                                        <h4 class="uppercase"><strong>Orders</strong></h4>
                                        <p class="text-gray">Track, return or buy items again.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 db-col-6 padd-right7">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('manage-shipping-address')); ?>" class="linkdetail block ripple-button">
                            <div class="dashboard-box BillingShippingSection">
                                <div class="dashboardPanel">
                                    <div class="dashboard-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/billing-shipping-icon.svg" alt="" />
                                    </div>
                                    <div class="dashboard_description">
                                        <h4 class="uppercase"><strong>Shipping</strong></h4>
                                        <p class="text-gray">Manage your shipping addresses.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 db-col-6 padd-right7">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('payment-methods')); ?>" class="linkdetail block ripple-button">
                            <div class="dashboard-box BillingShippingSection">
                                <div class="dashboardPanel">
                                    <div class="dashboard-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/payment-icon.svg" alt="" />
                                    </div>
                                    <div class="dashboard_description">
                                        <h4 class="uppercase"><strong>Billing</strong></h4>
                                        <p class="text-gray">Manage Billing Methods.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 db-col-6 padd-right7">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('support')); ?>" class="linkdetail block ripple-button">
                            <div class="dashboard-box messageSection">
                                <div class="dashboardPanel">
                                    <div class="dashboard-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/message-icon.svg" alt="" />
                                    </div>
                                    <div class="dashboard_description">
                                        <h4 class="uppercase"><strong>Customer Support</strong></h4>
                                        <p class="text-gray">Connect with Smile Brilliant customer service.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

            <?php
                }
            }
            $rewardEndPoint = 'reward';
            if (affwp_get_affiliate_id()) {
                $rewardEndPoint = 'reward_dashboard';
            }
            ?>
            <div class="col-md-4 db-col-6 padd-left7">
                <a href="<?php echo esc_url(wc_get_endpoint_url($rewardEndPoint)); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box rewardsSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/award.svg" alt="" />
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Rewards</strong></h4>
                                <p class="text-gray">Earn commissions & perks.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <?php if ($field_value != '' && wc_get_customer_order_count(get_current_user_id()) == 0) {

            ?>
                <!-- only RDH customers -->

                <div class="col-md-4 db-col-6 padd-left7 disableBoxMbt">
                    <a href="javascript:;" class="linkdetail block ripple-button">
                        <div class="dashboard-box orderSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/orders-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Orders</strong></h4>
                                    <p class="text-gray">Track, return or buy items again.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 db-col-6 padd-right7 disableBoxMbt">
                    <a href="javascript:;" class="linkdetail block ripple-button">
                        <div class="dashboard-box BillingShippingSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/billing-shipping-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Shipping</strong></h4>
                                    <p class="text-gray">Manage your shipping addresses.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 db-col-6 padd-right7 disableBoxMbt">
                    <a href="javascript:;" class="linkdetail block ripple-button">
                        <div class="dashboard-box BillingShippingSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/payment-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Billing</strong></h4>
                                    <p class="text-gray">Manage Billing Methods.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 db-col-6 padd-right7 disableBoxMbt">
                    <a href="javascript:;" class="linkdetail block ripple-button">
                        <div class="dashboard-box messageSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/message-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Customer Support</strong></h4>
                                    <p class="text-gray">Connect with Smile Brilliant customer service.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            <?php } ?>
            <?php if ($field_value == '') {
            ?>
                <div class="col-md-4 db-col-6 padd-right7">
                    <a href="<?php echo esc_url(wc_get_endpoint_url('support')); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box messageSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/message-icon.svg" alt="" />
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>Customer Support</strong></h4>
                                    <p class="text-gray">Connect with Smile Brilliant customer service.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <!-- <div class="friendbuyaccountpage"></div> -->
            <?php } ?>
        </div>

        <div class="logoutLinkMbt">
            <p>
                <?php
                printf(
                    /* translators: 1: user display name 2: logout url */
                    wp_kses(__('not %1$s? <a href="%2$s">Log out</a>', 'woocommerce'), $allowed_html),
                    '<strong>' . esc_html($current_user->display_name) . '</strong>',
                    esc_url(wc_logout_url())
                );
                ?>
            </p>
        </div>


    </div>

</section>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
