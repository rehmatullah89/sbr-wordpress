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
$RDH_login = $_REQUEST['RDH_login'];
if(isset($_REQUEST['field_1'])){
    $rdh_username = $_REQUEST['field_1'];
}
if(isset($_REQUEST['signup_username'])){
    $RDH_login = $_REQUEST['signup_username'];
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <meta charset="UTF-8">

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <meta name="format-detection" content="telephone=no" />
    <style>
        /* Reset styles */
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            width: 100% !important;
            height: 100% !important;
            font-family: 'Montserrat', Arial, sans-serif;
        }

        body,
        table,
        td,
        div,
        p,
        a {
            -webkit-font-smoothing: antialiased;
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            line-height: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse !important;
            border-spacing: 0;
        }

        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        /* Rounded corners for advanced mail clients only */
        @media all and (min-width: 560px) {
            .container {
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                -khtml-border-radius: 8px;
            }
        }

        /* Set color for auto links (addresses, dates, etc.) */
        a,
        a:hover {
            color: #127DB3;
        }

        .footer a,
        .footer a:hover {
            color: #999999;
        }
    </style>

    <title>Geha Email </title>
</head>


<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
	background-color: #F0F0F0;
	color: #000000;" bgcolor="#F0F0F0" text="#000000">

    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
                bgcolor="#F0F0F0">
                <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
	max-width: 600px;" class="container">

                    <tr>
                        <td>
                            <div style="width:100%;float:left;">
                                <div style="width:25%;height:10px; background: #14748d;float:left;"></div>
                                <div style="width:25%;height:10px; background: #dd1f69 ;float:left;"></div>
                                <div style="width:25%;height:10px; background: #fcac17 ;float:left;"></div>
                                <div style="width:25%;height:10px; background: #1eb6e5 ;float:left;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
			padding-top: 20px;
			padding-bottom: 20px;">
                            <div style="margin-top:30px;margin-bottom: 20px;width:230px;height:120px;margin-top:30px;background: url(https://www.smilebrilliant.com/wp-content/uploads/2023/04/rdhc-logo.png);background-repeat:no-repeat;"
                                class="lazyload"
                                data-back="https://www.smilebrilliant.com/wp-content/uploads/2023/03/sbr-email-logo.png;">
                            </div>
                            <!-- <div style="width:268px;height:65px;background: url(https://www.smilebrilliant.com/wp-content/uploads/2023/03/geha-logo-email.png);" class="lazyload" data-back="https://www.smilebrilliant.com/wp-content/uploads/2023/03/geha-logo-email.png"></div> -->

                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
			padding-top: 10px;
			color: #555759;
			 font-family: 'Montserrat', Arial, sans-serif;font-weight:bold;font-size:34px;" class="header">
                            GET STARTED!
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 400; line-height: 150%;
			padding-top: 5px;
			color: #14748d;
            white-space: nowrap;
			 font-family: 'Montserrat', Arial, sans-serif;font-size:18px;" class="subheader">
                            Your first steps as a <span style="color:#e65b91">R</span><span
                                style="color:#fdc255">D</span><span style="color:#1eb6e5">H</span><span
                                style="color:#33879c">C</span> member!
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
			padding-top: 20px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%">
                            <p
                                style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left;font-weight: 600;">
                                Welcome <?php echo $rdh_username;?>!</p>
                            <p
                                style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                We’re so happy you’re here! <br> As an RDHC member, you’ll broaden your connection to
                                fellow RDHs and the larger dental community: providing support, enhancing your
                                professional footprint, & bringing opportunities your way.
                            </p>
                            <p
                                style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                Let’s get started! A customized public profile page has been created for you. Keep it up
                                to date by sharing experiences, goals, and accomplishments. Just log into our account
                                using the details below.
                            </p>

                            <p
                                style="font-size:16px;font-weight:600;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #14748d; text-align: left; margin-top: 25px;">
                                New Features roll out each month!</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
        padding-top: 20px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;padding-bottom: 30px;">
                            <div style="width:100%; float:left;">
                                <div style="width:12%; float:left;text-align: center;">
                                    <span
                                        style="width:38px;height: 38px;display:block;border-radius: 40px;text-align: center;margin-left: auto;margin-right: auto;background: #14748d;color: #fff;font-size: 26px;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;line-height: 1.5;">1</span>
                                </div>
                                <div style="width:84%; float:left;text-align: left;    padding-left: 10px;">
                                    <h3
                                        style="margin: 0;padding: 0;font-size: 18px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 3px;letter-spacing: 2px;    line-height: 22px;">
                                        DASHBOARD LOGIN INFORMATION</h3>
                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #dd1f69;font-weight:500; text-align: left; margin-top:5px;">
                                        This is the important stuff!</p>
                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                        Use the my-account link or button below to log into your account with the
                                        username & password you chose during registration. Your RDHC Dashboard is your
                                        central hub for managing your account & public profile. Let’s start by updating
                                        your profile pic and social media!
                                    </p>
                                    <h3
                                        style="margin: 0;padding: 0;font-size: 14px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 20px;   line-height: 22px;">
                                        DASHBOARD LOGIN</h3>
                                    <a href="https://www.smilebrilliant.com/my-account/" target="_blank"
                                        style="text-decoration:none;margin: 0;padding: 0;font-size: 14px;color: #1eb6e5;font-weight: 500; font-family: 'Montserrat', Arial, sans-serif;margin-top: 0px;    line-height: 22px;">www.smilebrilliant.com/my-account</a>
                                    <p
                                        style="margin: 0;padding: 0;font-size: 14px;color: #565759;font-weight: 500; font-family: 'Montserrat', Arial, sans-serif;margin-top: 20px;    line-height: 22px;">
                                        USER: <?php echo $RDH_login;?></p>
                                    <p
                                        style="margin: 0;padding: 0;font-size: 14px;color: #565759;font-weight: 500; font-family: 'Montserrat', Arial, sans-serif;margin-top: 0px;   line-height: 22px;">
                                        PASSWORD: xxxxxxx</p>
                                    <h3
                                        style="margin: 0;padding: 0;font-size: 14px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 20px;    line-height: 22px;">
                                        YOUR PUBLIC PROFILE URL (<span style="color:#dd1f69">share it!</span>):</h3>
                                        <a href="www.rdhconnect.com/<?php echo $RDH_login;?>"
                                        style="text-decoration:none;margin: 0;padding: 0;font-size: 14px;color: #1eb6e5;font-weight: 500; font-family: 'Montserrat', Arial, sans-serif;margin-top: 0px;    line-height: 22px;">www.rdhconnect.com/<?php echo $RDH_login;?></a>


                                    <div style="clear:both">
                                        <a href="https://www.smilebrilliant.com/my-account/"
                                            style="margin-top:30px;font-size: 18px;line-height:22px;font-family: 'Montserrat', Arial, sans-serif;color: #fff;text-align: center;background:#14748d;display: block;max-width: 350px;padding: 10px;text-decoration: none;font-weight: 300;">
                                            LOGIN TO MY ACCOUNT
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </td>
                    </tr>


                    <tr>
                        <td style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
        padding-top: 20px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;    padding-bottom: 30px;">
                            <div style="width:100%; float:left;">
                                <div style="width:12%; float:left;text-align: center;">
                                    <span
                                        style="width:38px;height: 38px;display:block;border-radius: 40px;text-align: center;margin-left: auto;margin-right: auto;background: #14748d;color: #fff;font-size: 26px;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;line-height: 1.5;">2</span>
                                </div>
                                <div style="width:84%; float:left;text-align: left;    padding-left: 10px;">
                                    <h3
                                        style="margin: 0;padding: 0;font-size: 18px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 3px;letter-spacing: 2px;    line-height: 22px;">
                                        INTRODUCE YOURSELF!</h3>
                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #dd1f69; text-align: left; font-weight: 500; margin-top: 5px;">
                                        Make a short video</p>

                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                        To further personalize your profile, you can create a video introducing yourself
                                        to prospective connections: giving them a chance to get to know you, highlight
                                        your experience, and let them know what steps you’re looking to take in your
                                        career.

                                    </p>

                                    <div style="clear:both">
                                        <a href="https://drive.google.com/file/d/1ZvZZau-h8RikE9cqAlYKXLtoay1wAbOj/view?usp=sharing
                                        " target="_blank"
                                            style="margin-top:30px;font-size: 18px;line-height:22px;font-family: 'Montserrat', Arial, sans-serif;color: #fff;text-align: center;background:#14748d;display: block;max-width: 350px;padding: 10px;text-decoration: none;font-weight: 300;">
                                            INTRO VIDEO GUIDE
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>



                    <tr>
                        <td style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
        padding-top: 20px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;    padding-bottom: 30px;">
                            <div style="width:100%; float:left;">
                                <div style="width:12%; float:left;text-align: center;">
                                    <span
                                        style="width:38px;height: 38px;display:block;border-radius: 40px;text-align: center;margin-left: auto;margin-right: auto;background: #14748d;color: #fff;font-size: 26px;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;line-height: 1.5;">3</span>
                                </div>
                                <div style="width:84%; float:left;text-align: left;    padding-left: 10px;">
                                    <h3
                                        style="margin: 0;padding: 0;font-size: 18px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 3px;letter-spacing: 2px;line-height: 22px;">
                                        WANT TO PUBLISH CONTENT?</h3>
                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #dd1f69; text-align: left; font-weight: 500; margin-top: 5px;">
                                        Content creation & interview opportunities</p>

                                    <p
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                        RDHC will publish & promote content created by members just like you. If you’re
                                        interested in covering topics that are important to patients & professionals,
                                        get on our contributor’s list!
                                    </p>
                                    <div style="clear:both">
                                        <a href="https://forms.gle/MncgdEJjLj6CmAdM6" target="_blank"
                                            style="margin-top:30px;font-size: 18px;line-height:22px;font-family: 'Montserrat', Arial, sans-serif;color: #fff;text-align: center;background:#14748d;display: block;max-width: 350px;padding: 10px;text-decoration: none;font-weight: 300;">
                                            I'M INTERESTED!
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
 
                          
   
                    <tr>
                        <td style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;
          padding-top: 20px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;    padding-bottom: 30px;">
                            <div style="width:100%; float:left;">
                                <div style="width:12%; float:left;text-align: center;">
                                    <span           
                                        style="width:38px;height: 38px;display:block;border-radius: 40px;text-align: center;margin-left: auto;margin-right: auto;background: #14748d;color: #fff;font-size: 26px;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;line-height: 1.5;">4</span>
                                 </div> 
                                <div style="width:84%; float:left;text-align: left;    padding-left: 10px;">
                                     <h3 
                                        style="margin: 0;padding: 0;font-size: 18px;color: #565759;font-weight: bold; font-family: 'Montserrat', Arial, sans-serif;margin-top: 0px;letter-spacing: 2px;    line-height: 22px;">
                                        JOIN THE CONVERSATION! <span
                                            style="display: inline-block;position: relative;top: 6px;"></span></h3>
                                    <p   
                                         style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #dd1f69; text-align: left; font-weight: 500; margin-top: 5px;">
                                        Share on social media & invite other RDHs</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                                    <p          
                                        style="font-size:16px;line-height:22px; font-family: 'Montserrat', Arial, sans-serif;color: #727272; text-align: left; margin-top: 15px;">
                                        Share your RDHC profile on your social media accounts. Join our active
                                        communities on Facebook, Instagram and Linkedin. Receive periodic updates as we
                                        roll out a series of updates each month on the RDHC platform.
                                    </p>   
                    <tr>  
                        <td>     
                            <div style="width:80%;float:center;margin: 0px auto 140px auto; text-align: center;" class="socila-icons">
                                <div style="width: 23%;
                                float: left;
                                padding-left: 1%;
                                padding-right: 1%;
                                text-align: center;"> 
                                    <a href="https://www.instagram.com/rdh.connct/" target="_blank"
                                            style="text-decoration:none;">
                                    <img
                                        src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/instagram.png"style="width:75px"
                                        alt="">
                                        </a>

                                    <p
                                        style="font-size:12px;color: #14748d;font-weight:500;font-family: 'Montserrat', Arial, sans-serif;">
                                        <a href="https://www.instagram.com/rdh.connct/" target="_blank"
                                            style="text-decoration:none;">Instagram</a></p>
                                </div>
                                <div style="width: 23%;
                                float: left;
                                padding-left: 1%;
                                padding-right: 1%;
                                text-align: center;">
                                    <a href="https://www.linkedin.com/company/rdhconnect/" target="_blank"
                                            style="text-decoration:none;">
                                    <img
                                        src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/linkedin.png" style="width:75px"
                                        alt="">
                                    </a>
                                    <p
                                        style="font-size:12px;color: #14748d;font-weight:500;font-family: 'Montserrat', Arial, sans-serif;">
                                        <a href="https://www.linkedin.com/company/rdhconnect/" target="_blank"
                                            style="text-decoration:none;">Linkedin</a></p>
                                </div>
                                <div style="width: 23%;
                                float: left;
                                padding-left: 1%;
                                padding-right: 1%;
                                text-align: center;font-family: 'Montserrat', Arial, sans-serif;">
                                    <a href="https://www.facebook.com/groups/rdhconnectcommunity" target="_blank"
                                            style="text-decoration:none;">
                                    <img
                                        src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/facebook.png" style="width:75px"
                                        alt="">
                                        </a>

                                    <p
                                        style="font-size:12px;color: #14748d;font-weight:500;font-family: 'Montserrat', Arial, sans-serif;">
                                        <a href="https://www.facebook.com/groups/rdhconnectcommunity" target="_blank"
                                            style="text-decoration:none;">Facebook</a> </p>
                                </div>
                                <div style="width: 23%;
                                float: left;
                                padding-left: 1%;
                                padding-right: 1%;
                                text-align: center;">
                                    
                                    <a href="https://www.youtube.com/@rdhconnect" target="_blank"
                                            style="text-decoration:none;"><img
                                        src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/youtube.png" style="width:75px"
                                        alt="">
                                    </a>
                                    <p
                                        style="font-size:12px;color: #14748d;font-weight:500;font-family: 'Montserrat', Arial, sans-serif;">
                                        <a href="https://www.youtube.com/@rdhconnect" 
                                            target="_blank" style="text-decoration:none;">Youtube</a></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </div>
                    </div>
                    <tr>
                        <td style="background-color: #fff3dc;padding-bottom: 40px; 
                        border-bottom: 2px solid #fff;">
                            <div>
                                <h3
                                    style="margin: 0;padding: 0;padding-top:30px;text-align:center;font-size: 18px;color: #565759;font-weight: 700; font-family: 'Montserrat', Arial, sans-serif;margin-top: 3px;letter-spacing: 2px;line-height: 22px;">
                                    MEET OUR FOUNDING MEMBERS!
                                </h3>
                                <p
                                    style="font-size:14px; padding: 0px 20px; line-height:20px; color: #727272; text-align:center;font-family: 'Montserrat', Arial, sans-serif;margin-bottom:30px">
                                    Check out their profiles, watch their videos, and read some of their  published
                                    content. Its all available on their public pages!</p>
                                <div style="width:95%;float:center;margin: 0px auto; text-align: center"class="socila-icons" ;>
                                    <div style="width: 23%;
                                    float: left;
                                    padding-left: 1%;
                                    padding-right: 1%; text-align: center;">
                                    <a href="https://www.rdhconnect.com/rcstroble/" target="_blank"> <img
                                            src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/stroble.png"style="width:80px"
                                            alt=""></a>
                                        <p
                                            style="min-height: 80px;color: #14748d;font-family: 'Montserrat', Arial, sans-serif;font-size: 13px;line-height: 16px;">
                                            <span style="font-weight:500">Rachel Stroble </span><br>
                                            RDH, CDA, MS</p>

                                        <a href="https://www.rdhconnect.com/rcstroble/" target="_blank" style="margin-top: 30px;
                                            font-size: 10px;
                                            line-height: 22px;
                                            font-family: 'Montserrat', Arial, sans-serif;
                                            color: #fff;
                                            text-align: center;
                                            background: #14748d;
                                            display: block;
                                            max-width: 100px;
                                            padding: 2px 5px;;
                                            margin: 0px auto;
                                            text-decoration: none;
                                            font-weight: 300;">VIEW PROFILE</a>
                                    </div>
                                    <div style="width: 23%;
                                    float: left;
                                    padding-left: 1%;
                                    padding-right: 1%;">
                                     <a href="https://www.rdhconnect.com/lacywalker/"target="_blank">
                                    <img
                                            src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/walker.png" style="width:80px"
                                            alt=""></a>
                                        <p
                                            style="min-height: 80px;color: #14748d;font-family: 'Montserrat', Arial, sans-serif;font-size: 13px;line-height: 16px;">
                                            <span style="font-weight:500">Lacy Walker </span> <br>
                                            RDH, BS, CADA, <br>
                                            MAADH, FAAOSH</p>
                                        <a href="https://www.rdhconnect.com/lacywalker/"target="_blank" style="margin-top: 30px;
                                            font-size: 10px;
                                            line-height: 22px;
                                            font-family: 'Montserrat', Arial, sans-serif;
                                            color: #fff;
                                            text-align: center;
                                            background: #14748d;
                                            display: block;
                                            max-width: 100px;
                                            padding: 2px 5px;;
                                            margin: 0px auto;
                                            text-decoration: none;
                                            font-weight: 300;">VIEW PROFILE</a>
                                    </div>
                                    <div style="width: 23%;
                                    float: left;
                                    padding-left: 1%;
                                    padding-right: 1%;font-family: 'Montserrat', Arial, sans-serif;">
                                    <a href="https://www.rdhconnect.com/cherelussmiles/"target="_blank">    <img src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/carter-cherelus.png" style="width:80px"
                                            alt=""></a> 
                                        <p
                                            style="min-height: 80px; color: #14748d;font-family: 'Montserrat', Arial, sans-serif;font-size: 13px;line-height: 16px;">
                                            <span style="font-weight:500">Kari Carter-Cherelus</span> <br>
                                            RDH, DA</p>
                                        <a href="https://www.rdhconnect.com/cherelussmiles/"target="_blank" style="margin-top: 30px;
                                            font-size: 10px;
                                            line-height: 22px;
                                            font-family: 'Montserrat', Arial, sans-serif;
                                            color: #fff;
                                            text-align: center;
                                            background: #14748d;
                                            display: block;
                                            max-width: 100px;
                                            padding: 2px 5px;;
                                            margin: 0px auto;
                                            text-decoration: none;
                                            font-weight: 300;">VIEW PROFILE</a>
                                    </div>
                                    <div style="width: 23%;
                                    float: left;
                                    padding-left: 1%;
                                    padding-right: 1%;">
                                     <a href="https://www.rdhconnect.com/ornelase/"target="_blank">
                                    <img
                                            src="https://www.smilebrilliant.com/wp-content/uploads/2023/04/ornelas.png"style="width:80px"
                                            alt=""></a>
                                        <p
                                            style="min-height: 80px;color: #14748d;font-family: 'Montserrat', Arial, sans-serif;font-size: 13px;line-height: 16px;">
                                            <span style="font-weight:500">Esmy Ornelas</span> <br>
                                            RDH, MS</p>
                                        <a href="https://www.rdhconnect.com/ornelase/"target="_blank" style="margin-top: 30px;
                                            font-size: 10px;
                                            line-height: 22px;
                                            font-family: 'Montserrat', Arial, sans-serif;
                                            color: #fff;
                                            text-align: center;
                                            background: #14748d;
                                            display: block;
                                            max-width: 100px;
                                            padding: 2px 5px;;
                                            margin: 0px auto;
                                            text-decoration: none;
                                            font-weight: 300;">VIEW PROFILE</a>

                                    </div>
                                </div>
                            </div>


                        </td>

                    </tr>

            </td>
        </tr>



        <tr>
            <td align="center" valign="top"
                style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;background: #eeeeee;"
                class="list-item">
                <table align="center" border="0" cellspacing="0" cellpadding="0"
                    style="width: inherit; margin: 0; padding: 0; border-collapse: collapse; border-spacing: 0;padding-left: 6.25%; padding-right: 6.25%;width: 87.5%;">
                    <tbody>
                        <tr>
                            <td align="left" valign="top"
                                style="border-collapse: collapse; border-spacing: 0;padding-right: 20px;padding-top: 20px;padding-bottom: 20px">
                                <p
                                    style="color: #848484;text-align: center;font-size: 10px;font-family: 'Montserrat', Arial, sans-serif;margin: 0;    line-height: 1.8;">
                                    RDH Connect<br>
                                    1645 Headland Dr<br>
                                    Fenton, MO 63026<br>
                                    www.rdhconnect.com
                                    <br><br>
                                    You received this email because you are a registered member of RDH Connect, <span
                                        style="color:#4597cb;display:none;" ;>unsubscribe</span>.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="width:100%;float:left;">
                    <div style="width:25%;height:10px; background: #14748d;float:left;"></div>
                    <div style="width:25%;height:10px; background: #dd1f69 ;float:left;"></div>
                    <div style="width:25%;height:10px; background: #fcac17 ;float:left;"></div>
                    <div style="width:25%;height:10px; background: #1eb6e5 ;float:left;"></div>
                </div>
            </td>
        </tr>
    </table>

    </td>
    </tr>
    </table>

</body>

</html>