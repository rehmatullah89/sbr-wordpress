<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

$field_value = '';
if(function_exists('bp_is_active')){
$field_value = bp_get_profile_field_data(array(
    'field' => 'Referral',
    'user_id' => get_current_user_id(),

));
}
global $wpdb;
$current_user = wp_get_current_user();
$useremail = $current_user->user_email;
$user_idd='';
if(function_exists('bp_is_active')){
                $user_idd = bp_core_get_userid(bp_members_get_user_slug(get_current_user_id()));

                $useremail = $current_user->user_email;
                if (!$user_idd || $user_idd == '') {
                    $linkslug = $wpdb->get_var( "SELECT user_login FROM wp_users WHERE user_nicename = '".bp_members_get_user_slug(get_current_user_id())."'" );
                  
                }
                else{
                    $linkslug = bp_members_get_user_slug(get_current_user_id());
                }
            }
    
?>

<div id="SBRCustomerDashboard" class="desktopVersionAdded">
        <div class="d-flex align-items-center menuParentRowHeading menuParentRowHeadingProfile hidden-mobile form-edit-account showOnChangePasswordPage">

            <?php if ($field_value == '' && wc_get_customer_order_count( get_current_user_id()) >0) {
                ?>
                 <div class="pageHeading_sec"> 
                    <span><span class="text-blue">Profile</span>
                    Manage and edit your name email or  password</span> 
                </div>          
                  
                
                <?php } else { ?>
                    <div class="pageHeading_sec">
                    <span><span class="text-blue">Change Password</span>
                    Manage and edit your password.</span> 
                </div>                    
                <?php } ?>
                
                <?php
                if ($field_value != '') {
                    ?>         
                        <div class="view-article-public-link">
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate changePassLink "  id="pills-my-faq" data-toggle="pill" href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/edit/group/1?active-tab=faq"; ?>" role="tab" aria-controls="" aria-selected="false"><span> <i class="fa fa-question-circle-o" aria-hidden="true"></i></span> FAQ </a>
                            <?php
                            $rows = get_field('rdhc_invite_codes','option');
                        
                            if( $rows ) {
                                foreach( $rows as $row ) {
                                $rdhc_email_address = isset($row['rdhc_email_address']) ? $row['rdhc_email_address']:'';
                                $rdhc_invite_code = $row['rdhc_invite_code'] ? $row['rdhc_invite_code']:'';
                                $rdhc_code_usage_limit = $row['rdhc_code_usage_limit']? $row['rdhc_code_usage_limit']:'';
                                if($rdhc_email_address == $useremail && $rdhc_invite_code!='') {
                                    ?>
                                
                                    <div class="referal-code">
                                    <span><span class="referrsl-codeText">Invite Code:</span> <strong><?php //echo $rdhc_invite_code;?></strong></span>
                                    </div>
                                    <?php
                                    
                                        break;
                                }
                            }   
                            }
                        
                            ?>
                        
                            <a class="hiddenDefault" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
                                </span> View Public Profile</a>
                        </div>                

                        
                        <?php  } ?>
                                 
        </div>

    <?php if (!wp_is_mobile() || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) { ?>
    
    <?php

    if ($field_value != '') {

                if(isset($_GET['active-tab']) && $_GET['active-tab'] =='contact') {
                    ?>
                    <script>
                        jQuery( document ).ready(function() {
                           jQuery('.customTabs #pills-home-tab').click();
                        });
                    </script>

                    <?php
                }
                if(isset($_GET['active-tab']) && $_GET['active-tab'] =='social') {
                    ?>
                    <script>
                        jQuery( document ).ready(function() {
                           jQuery('.customTabs #pills-profile-tab').click();
                        });
                    </script>

                    <?php
                }

                if(isset($_GET['active-tab']) && $_GET['active-tab'] =='publications') {
                    ?>
                    <script>
                        jQuery( document ).ready(function() {
                           jQuery('.customTabs #pills-my-publication').click();
                        });
                    </script>

                    <?php
                }

                if(isset($_GET['active-tab']) && $_GET['active-tab'] =='pass') {
                    ?>
                    <script>
                        jQuery( document ).ready(function() {
                           jQuery('.customTabs #pills-password-tab').click();
                        });
                    </script>

                    <?php
                }
                ?>

               <script>
                        jQuery('#socialMediaLinks').click(function(){
                            jQuery(this).addClass("activeddddddd");
                            alert("yes");
                        });

               </script>     
            <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop hidden-mobile">
                    <li class="nav-item">
                        <a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id=""  href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/edit/group/1"; ?>" role="tab" aria-selected="true">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="uppercase nav-link ripple-button rippleSlowAnimate" id=""  href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/edit/group/1?active-tab=professional"; ?>" role="tab"  aria-selected="false">Professional</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="socialMediaLinks"  href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/edit/group/1?active-tab=social"; ?>"   aria-selected="false">Social Media</a>
                    </li>

                    <li class="nav-item my-publications-tab" >
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-my-publication"  href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/edit/group/1?active-tab=publications"; ?>"   aria-selected="false">My Publications</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Change password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate" sublink="rdh" id="pills-password-tab" href="<?php echo "/members/" . bp_members_get_user_slug(get_current_user_id()) . "/profile/change-avatar"; ?>">
                            Upload Photo
                        </a>
                    </li>

                </ul>

        <?php
    }
    else{
        ?>
    <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop">
        <li class="nav-item">
            <a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Contact</a>
        </li>
        <li class="nav-item">
            <a class="uppercase nav-link ripple-button rippleSlowAnimate" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Social</a>
        </li>        
        <li class="nav-item">
            <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Change password</a>
        </li>
<?php 	if(function_exists('bp_is_active')){ ?>
        <li class="nav-item">
            <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-uploadPhoto-tab"  href="/members/<?php echo bp_members_get_user_slug(get_current_user_id());?>/profile/change-avatar" role="tab" aria-controls="" >Upload Photo</a>
        </li>
<?php }?>
    </ul>

        <?php } ?>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <?php sbr_edit_customer_dashboard('contact'); ?>
        </div>
        <div class="tab-pane blockDesktop" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <?php sbr_edit_customer_dashboard('social'); ?>
        </div>
        <div class="tab-pane blockDesktop" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <?php sbr_edit_customer_dashboard('oral'); ?>
        </div>
        <div class="tab-pane blockDesktop" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
        <?php sbr_edit_customer_dashboard('password'); ?>
        </div>
    </div>
    <?php } else{
sbr_edit_customer_dashboard();
    }?>

</div>
