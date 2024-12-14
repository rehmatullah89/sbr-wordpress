<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $wp;
$current_url = add_query_arg(array(), $wp->request);
$current_url = explode("/", $current_url);
$endpointTop = isset($current_url[1]) ? $current_url[1] : WC()->query->get_current_endpoint();

//subscription#RB [search subscription]
$selectedProfileMenu = '';
$selectedShippingMenu = '';
$selectedBillingMenu = '';
$selectedRewardMenu = '';
$selectedSupportMenu = '';
$selectedOrderMenu = '';
$selectedSubscriptionMenu = '';
$selectedCustomerDiscountMenu = '';
$selectedShineSubscriptionMenu = '';
$field_value = '';
if(function_exists('bp_is_active')){
$field_value = bp_get_profile_field_data(array(
    'field' => 'Referral',
    'user_id' => get_current_user_id(),

));
}
switch ($endpointTop) {
    case 'shine_subscription':
        $selectedShineSubscriptionMenu = 'navActive';
        break;
    case 'customer_discounts':
        $selectedCustomerDiscountMenu = 'navActive';
        break;     
    case 'edit-shipping-address':
    case 'manage-shipping-address':
    case 'edit-address':
        $selectedShippingMenu = 'navActive';
        break;

    case 'payment-methods':
  //  case 'add_payment_card':
   // case 'edit_payment_card':
        $selectedBillingMenu = 'navActive';
        break;

    case 'edit-account':
        $selectedProfileMenu = 'navActive';
        break;
    case 'reward':
        $selectedRewardMenu = 'navActive';
        break;

    case 'support':
        $selectedSupportMenu = 'navActive';
        break;

    case 'orders':
    case 'view-order':
        $selectedOrderMenu = 'navActive';
        break;
    case 'subscription':
        $selectedSubscriptionMenu = 'navActive';
        break;   
}


$navigation = array(

    'shine_subscription' => array(
        'id' => 'shine_subscription',
        'icon' => 'shine-smile-white',
        'uppercase' => 'SHINE MEMBERSHIP',
        'text-gray' => 'Membership card, payment history, and product discounts'
    ),

    // 'customer_discounts' => array(
    //     'id' => 'customer_discounts',
    //     'icon' => 'orders-icon',
    //     'uppercase' => 'CUSTOMER DISCOUNTS',
    //     'text-gray' => 'Avail customer discounts.'
    // ),
    
    'edit-account' => array(
        'id' => 'editCustomerProfile',
        'icon' => 'profile-icon',
        'uppercase' => 'Profile',
        'text-gray' => 'Manage and edit your name or email.'
    ),
    'orders' => array(
        'id' => 'order',
        'icon' => 'orders-icon',
        'uppercase' => 'Orders',
        'text-gray' => 'Track, return or buy items again.'
    ),
    'subscription' => array(
        'id' => 'subscription',
        'icon' => 'subscription',
        'uppercase' => 'Subscriptions',
        'text-gray' => 'Track, return or buy items again.'
    ),
    'manage-shipping-address' => array(
        'id' => 'manage-shipping-address',
        'icon' => 'billing-shipping-icon',
        'uppercase' => 'Shipping',
        'text-gray' => 'Manage your shipping addresses.'
    ),

    'payment-methods' => array(
        'id' => 'payment-methods',
        'icon' => 'payment-icon',
        'uppercase' => 'Billing',
        'text-gray' => 'Manage billing methods.'
    ),
    // 'my_oral_profile' => array(
    //     'id' => 'my-oral-profile',
    //     'icon' => 'payment-icon',
    //     'uppercase' => 'My Oral Profile',
    //     'text-gray' => 'Manage oral profile.'
    // ),
);
if ( is_super_admin() ) {
    // Initialize the navigation array


// Get the current user ID
global $wpdb;

// Get the current user ID
$user_id = get_current_user_id();

// Define the form ID (replace with your actual form ID)
$form_id = 5; // Adjust the form ID if necessary

// Search for entries made by the current user for the specified form
$search_criteria = array(
    'field_filters' => array(
        array(
            'key'   => 'created_by', 
            'value' => $user_id
        )
    )
);

// Get the entries for the current user
$sorting = array(
    'key'   => 'date_created',
    'direction' => 'DESC'
); // Sort by latest created entries

$entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, array('page_size' => 1));
// echo '<pre>';
// print_r($entries);
// echo '<pre>';
if ( ! is_wp_error( $entries ) && ! empty( $entries ) ) {
    // Get the latest entry
    $latest_entry = $entries[0];

    // Get the entry ID and form ID
    $entry_id = $latest_entry['id'];
    $entry_ip =  $latest_entry['ip']; // Get the IP address of the entry
    
    $saved_token = get_user_meta($user_id,'form_'.$form_id.'_'.$entry_id.'_token',true);
    

    // If no saved token, use the entry ID as a fallback token
    if ( empty( $saved_token ) ) {
        $query = $wpdb->prepare(
            "SELECT uuid 
            FROM {$wpdb->prefix}gf_draft_submissions 
            WHERE form_id = %d 
            AND ip = %s 
            ORDER BY date_created DESC 
            LIMIT 1",
            $form_id,
            $entry_ip
        );
        if ( empty( $saved_token ) ) {
                $saved_token = $entry_id; 
        }// Fallback to entry ID if no token found
    }

    // Build the edit link
    $edit_link = 'my_oral_profile/?entry_id=' . $entry_id . '&form_id=' . $form_id . '&save_token=' . $saved_token.'&readonly=true';

    // Update the navigation array with the latest entry link
    $navigation[$edit_link] = array(
        'id' => 'my-oral-profile',
        'icon' => 'payment-icon',
        'uppercase' => 'My Oral Profile',
        'text-gray' => 'Manage oral profile.',
        
    );

} else {
    // No entries found for this user, keep the link unchanged or set a default
    $navigation['my_oral_profile'] = array(
        'id' => 'my-oral-profile',
        'icon' => 'payment-icon',
        'uppercase' => 'My Oral Profile',
        'text-gray' => 'Manage oral profile.'
    );
}


}
if (affwp_get_affiliate_id()) {
    $navigation['reward_dashboard'] = array(
        'id' => 'reward',
        'icon' => 'award',
        'uppercase' => 'Rewards',
        'text-gray' => 'Earn commissions & perks'
    );
} else {
    $navigation['reward'] = array(
        'id' => 'reward',
        'icon' => 'award',
        'uppercase' => 'Rewards',
        'text-gray' => 'Earn commissions & perks'
    );
}
$navigation['support'] = array(
    'id' => 'message',
    'icon' => 'message-icon',
    'uppercase' => 'customer support',
    'text-gray' => 'Connect with Smile Brilliant customer service.'
);





//	wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );


/*
do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
        <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                <?php echo esc_html($label); ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation');
*/

?>



<section>
    <div class="db-navigation">
        <ul>
            <!--    <li class="ripple-button">
                    <a href="" class="shineMemberTag" menu="">
                        <div class="nav-link db-d-flex db-align-items-center">
                            <div class="dashboard-icon">
                                <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/icons/shine-smile-my-account.png" alt="" />
                            </div>
                            <div class="menuText">
                                <h4 class="uppercase"><strong><span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span> Card</strong></h4>
                                <p class="text-gray">Manage and download your shine cards.</p>
                            </div>
                            <span class="chevron bottom"></span>
                        </div>
                    </a>
                </li> -->

            <?php if ($field_value != '') {
            ?>
                <li class="ripple-button  rdhCustomerProfile">
                    <a href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>" class="myAccountMenu <?php if (strpos($_SERVER['REQUEST_URI'], "profile/edit") !== false) {
                                                                                                                                                            echo 'activeNav';
                                                                                                                                                        } ?>" menu="editCustomerProfile">
                        <div class="nav-link db-d-flex db-align-items-center">
                            <div class="dashboard-icon">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/RDH.svg" alt="">
                            </div>
                            <div class="menuText">
                                <h4 class="uppercase"><strong> <span style="color:#dd1f69;line-height: 1;">R</span><span style="color:#fcac17; line-height: 1;">D</span><span style="color:#1eb6e5;line-height: 1;">H</span><span style="color:#217c93;line-height: 1;">C</span></strong></h4>
                                <p class="text-gray">Manage your RDHC public profile</p>
                            </div>
                            <span class="chevron bottom"></span>
                        </div>
                    </a>
                </li>
                <li class="ripple-button  rdhCustomerProfile onlyRdhMemberNav">
                    <a href="<?php echo home_url('my-account/support') . '?active-tab=chat'; ?>"  class="myAccountMenu" menu="editCustomerProfile" >
                        <div class="nav-link db-d-flex db-align-items-center">
                            <div class="dashboard-icon">

                                <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chat_talk.svg" />
                            </div>
                            <div class="menuText">
                                <h4 class="uppercase"><strong> <span style="color:#dd1f69;line-height: 1;">R</span><span style="color:#fcac17; line-height: 1;">D</span><span style="color:#1eb6e5;line-height: 1;">H</span><span style="color:#217c93;line-height: 1;">C</span> Messaging</strong> </h4>
                                <p class="text-gray">Inbox & communication tool</p>
                            </div>
                            <span class="chevron bottom"></span>
                        </div>
                    </a>
                </li>


            <?php } ?>

            <?php foreach ($navigation as $endpoint => $label) : ?>

                <?php
                /*
                if ($field_value != '' && $endpoint  != 'reward' && wc_get_customer_order_count(get_current_user_id()) == 0) {
                    continue;
                }
                if ($field_value != '' && $endpoint  == 'edit-account') {
                    continue;
                }
                */
                //subscription#RB
                if($endpoint == 'subscription' && !get_user_meta(get_current_user_id(), 'is_subscribed', true)){
                    continue;
                }
                //shine-subscription#RB
                if($endpoint == 'shine_subscription' && !get_user_meta(get_current_user_id(), 'is_shine_user', true)){
                    continue;
                }
                if ($endpoint  == 'reward' || $endpoint  == 'reward_dashboard') {
                } else {
                    if ($field_value != ''   && wc_get_customer_order_count(get_current_user_id()) == 0) {
                        continue;
                    }
                    if ($field_value != '' && $endpoint  == 'edit-account') {
                        continue;
                    }
                }

                $activeClass = '';
                /// echo '----'.$endpointTop .'=='. $endpoint;
                if ($endpointTop == $endpoint) {
                    $activeClass = 'activeNav ';
                }
                $pageUrl = esc_url(wc_get_account_endpoint_url($endpoint));
                if ('reward' == $endpoint) {
                    $pageUrl = $pageUrl . '?tab=stats';
                }

                ?>
                <li class="ripple-button <?php echo $label['id']; ?>">
                    <a href="<?php echo $pageUrl; ?>" class="<?php echo $activeClass; ?> myAccountMenu" menu="<?php echo $label['id']; ?>">
                        <div class="nav-link db-d-flex db-align-items-center">
                            <div class="dashboard-icon">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/<?php echo $label['icon']; ?>.svg" alt="" />
                            </div>
                            <div class="menuText">
                                <h4 class="uppercase"><strong><?php echo $label['uppercase']; ?></strong></h4>
                                <p class="text-gray"><?php echo $label['text-gray']; ?></p>
                            </div>
                            <span class="chevron bottom"></span>
                        </div>
                    </a>
                </li>
            <?php endforeach;

            ?>




            <li class="ripple-button">
                <div class="nav-link db-d-flex db-align-items-center db-justify-content-between messageSectionNav">
                    <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="backToDashboard text-blue">
                        <div class="db-d-flex align-items-center"> <i class="fa fa-chevron-left" aria-hidden="true"></i><span> Dashboard</span></div>
                    </a>
                    <a href="<?php echo esc_url(home_url('logout')); ?>" class="logouButton text-gray">
                        Logout <i class="fa fa-sign-out" aria-hidden="true"></i>

                    </a>

                </div>
            </li>


        </ul>
    </div>

</section>



<div class="contentOverlayMenu">
    <div class="md-effect-1">
        <div class="md-content">
            <?php //if ($field_value != '') { 
            ?>
            <!-- profile section -->
            <div class="contentmenu" id="profileSec">
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/profile.png" class="" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    PROFILE
                                </div>
                                <span>
                                    Manage and edit your name or email.
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                        </div>

                    </div>

                </div>

                <ul>
                    <?php
                    $field_value = '';
                    if(function_exists('bp_is_active')){
                        $field_value = bp_get_profile_field_data(array(
                            'field' => 'Referral',
                            'user_id' => get_current_user_id(),

                        ));
                }
                    //   $field_value ='';
                    if ($field_value != '') {
                    ?>
                        <li class="mobileRDHLink" style="display:none ;">
                            <a href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1"; ?>">
                                RDH
                            </a>
                        </li>
                        <script>
                            jQuery(document).ready(function() {
                                my_account_url = '<?php echo site_url("my-account"); ?>';
                                jQuery('.bp-user .contentOverlayMenu ul li a').each(function() {
                                    curr_url = jQuery(this).attr('href');
                               
                                    if (curr_url.includes(my_account_url) || curr_url.includes('javascript') ||
                                        curr_url.includes('members') || curr_url.includes('members')) {
                                        //
                                    } else {
                                        curr_url_new = my_account_url + curr_url;
                                        jQuery(this).attr('href', curr_url_new);
                                    }
                                });
                            });
                        </script>
                    <?php } ?>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>">
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')) . '?tab=social'; ?>">
                            Social
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')) . '?tab=password'; ?>">
                            Change Password
                        </a>
                    </li>

                    <?php if(function_exists('bp_is_active')){ ?>
                    <li>
                        <a class="" sublink="rdh" id="pills-password-tab" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/change-avatar"; ?>">
                            Upload Photo
                        </a>
                    </li>
                    <?php } ?>

                </ul>


            </div>
            <?php //} 
            ?>
            <div class="contentmenu" id="orderSec">
                <!-- order section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/rewards.png" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    ORDER
                                </div>
                                <span>
                                    Track, return or buy items again.
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>

                            </span>
                        </div>

                    </div>

                </div>

                <ul>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>">
                            ALL ORDER
                        </a>
                    </li>
                    <!-- <li>
                        <a href="javascript:void(0)" sublink="subsciption">
                            SUBSCRIPTION
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" sublink="buyagain">
                            BUY AGAIN
                        </a>
                    </li> -->

                </ul>
            </div>



            <div class="contentmenu" id="billingSec">
                <!-- shipping section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/credit_icon.png" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    Billing
                                </div>
                                <span>
                                    Manage and edit your billing profiles
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>

                            </span>
                        </div>

                    </div>

                </div>

                <ul customLink="edit-address">


                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('payment-methods')); ?>">
                            View Payment Methods
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('add_payment_card')); ?>">
                            Add Payment Method
                        </a>
                    </li>


                </ul>
            </div>


            <div class="contentmenu" id="shippingSec">
                <!-- shipping section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/shipping.png" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    Shipping
                                </div>
                                <span>
                                    Manage and add edit your shippings info.
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>

                            </span>
                        </div>

                    </div>

                </div>

                <ul customLink="edit-address">

                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('manage-shipping-address')); ?>">
                            View Shipping Address
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-shipping-address/add/')); ?>">
                            Add New Shipping
                        </a>
                    </li>

                </ul>
            </div>

            <div class="contentmenu" id="rewardSec">
                <!-- reward section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/rewards.png" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    Reward
                                </div>
                                <span>
                                    Track, return or buy items again.
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>

                            </span>
                        </div>

                    </div>

                </div>
                <?php
                 $field_value = '';
                	if(function_exists('bp_is_active')){
                $field_value = bp_get_profile_field_data(array(
                    'field' => 'Referral',
                    'user_id' => get_current_user_id(),

                ));
            }
                ?>
                <ul customLink="reward" commom_action="get_tab_data_affiliate">
                    <?php if ($field_value  == '') { ?>
                        <li>
                            <a href="javascript:void(0)" sublink="urls">
                                Affiliate URLs
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="javascript:void(0)" sublink="stats">
                            Statistics
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" sublink="graphs">
                            Graphs
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" sublink="referrals">
                            Referrals
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" sublink="payouts">
                            Payouts
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" sublink="visits">
                            Visits
                        </a>
                    </li>
                    <!-- <li>
                        <a href="javascript:void(0)" sublink="creatives">
                            Creatives
                        </a>
                    </li> -->
                    <li>
                        <a href="javascript:void(0)" sublink="settings">
                            Settings
                        </a>
                    </li>


                </ul>
            </div>

            <?php // if ($field_value == '' ||  wc_get_customer_order_count( get_current_user_id()) >0) { 
            ?>


            <div class="contentmenu" id="messageSec">
                <!-- message section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img class="invertWhite" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/message.png" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                Customer Support
                                </div>
                                <span>
                                 <!-- Connect with Smile Brilliant customer service. -->
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>

                            </span>
                        </div>

                    </div>

                </div>

                <ul>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('support')); ?>">
                            All Tickets
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_endpoint_url('support/add')); ?>">
                            New Ticket
                        </a>
                    </li>
                    <li class="chatwithCustomers">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('support')) . '?active-tab=chat'; ?>" id="openChatBox">
                         RDHC Messaging
                        </a>
                    </li>      
                </ul>
            </div>
            <?php // } 
            ?>
            <?php
                        if(isset($_GET['active-tab']) && $_GET['active-tab'] =='chat') {
                            ?>
                            <script>
                                jQuery(document).ready(function() {
                                jQuery('.chatBoxWrapperContainer').addClass('active');
                                jQuery('.ticketListContainner').removeClass('active');
                                jQuery('.rdhTicketsMessage').hide();                            
                                });
                            </script>

                            <?php
                        }
                    ?>
            <div class="contentmenu" id="RDHprofile">
                <!-- message section -->
                <div class="titleHead">
                    <div class="sectionTitle">
                        <div class="row align-items-center">
                            <div class="iconDisplayNav">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/RDH.svg" alt="">
                            </div>
                            <div class="iconTextDisplayNav">
                                <div class="titleUpaer">
                                    RDHC
                                </div>
                                <span>
                                    Post and Manage Articles, Update Qualification & Experience
                                </span>
                            </div>
                        </div>

                        <div class="md-close closeNavOverLay">
                            <span>
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                        </div>

                    </div>

                </div>

                <ul>
                    <?php 	if(function_exists('bp_is_active')){ ?>
                    <li>
                        <a class="" id="contact-info" sublink="rdh" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1?active-tab=contact"; ?>">
                            Contact Info
                        </a>
                    </li>
                    <li>
                        <a class="" sublink="rdh" id="professional-info" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1?active-tab=professional"; ?>">
                            Professional Info
                        </a>
                    </li>
                    <li>
                        <a class="" sublink="rdh" id="pills-password-tab" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1?active-tab=social"; ?>">
                            Social Media Info
                        </a>
                    </li>

                    <li>
                        <a class="" sublink="rdh" id="pills-publication-tab" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/edit/group/1?active-tab=publications"; ?>">
                            My Publications
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')) . '?tab=password'; ?>">
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="" sublink="rdh" id="pills-password-tab" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/change-avatar"; ?>">
                            Upload Photo
                        </a>
                    </li>

                        <?php } ?>


                </ul>
            </div>


        </div>
    </div>

</div>


<section class="stickyNavigation h2-tabbar" id="lzd-h2-tabbar" style="display:none;">

    <style>
        /* code on file navigation */
        @media screen and (max-width: 767px) {
            .fixed-footer-container.RDHProfileFooter {
                padding-bottom: 46px;
            }
        }
    </style>

    <?php 
    if ($field_value != '' && wc_get_customer_order_count(get_current_user_id()) == 0) {

    ?>
        <a class="item  rdhProfileLink  <?php echo $selectedProfileMenu; ?>" href="javascript:;" data-related="RDHprofile" id="rdhNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/profile.svg" class="" alt="">
            </div>
        </a>

        <a class="item rewardIconMobile  orderTab <?php echo $selectedRewardMenu; ?>" href="javascript:;" data-related="rewardSec" id="rewardNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/award.svg" alt="">
            </div>
        </a>

        <a class="item messageIconMobile item messageIconMobile orderTab <?php echo $selectedSupportMenu; ?>" href="javascript:;" data-related="messageSec" id="messageNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/envelope.svg" alt="">
            </div>
        </a>


        <a class="orderIconMobile item   disableLink " href="javascript:;" aria-current="disableLink">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/order.svg" alt="">
            </div>
        </a>

        <a class="item billingIconMobile   disableLink " href="javascript:;" aria-current="disableLink">
            <div class="icon">

                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/credit_icon.svg" alt="">
            </div>
        </a>

        <a class="item shippingIconMobile  disableLink " href="javascript:;" aria-current="disableLink">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/delivery.svg" alt="">
            </div>
        </a>


        <a class="item messageIconMobile  disableLink " href="javascript:;" aria-current="disableLink">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/envelope.svg" alt="">
            </div>
        </a>



        <?php } else {
        if ($field_value != '') {
        ?>
            <a class="item  rdhProfileLink  asdf <?php echo $selectedProfileMenu; ?>" href="javascript:;" data-related="RDHprofile" id="rdhNav">
                <div class="icon">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/profile.svg" class="" alt="">
                    <!-- <i class="fa fa-user-o" aria-hidden="true"></i> -->
                </div>
            </a>
        <?PHP
        }
        if ($field_value == '') {
        ?>

            <a class="item  profileIconLink home <?php echo $selectedProfileMenu; ?>" href="javascript:;" data-related="profileSec" id="profileNav">
                <div class="icon">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/profile.svg" class="" alt="">
                </div>
            </a>
        <?php } ?>

        <a class="orderIconMobile item  orderTab <?php echo $selectedOrderMenu; ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" data-related="orderSect" id="orderNavv">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/order.svg" alt="">
            </div>
        </a>
        <a class="orderIconMobile item  orderTab <?php echo $selectedSubscriptionMenu; ?>"
            href="<?php echo esc_url(wc_get_endpoint_url('subscription')); ?>" data-related="orderSect" id="subsNavv">
            <div class="icon subscription-nav-icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/subscription-black-icon.svg" alt="">
            </div>
        </a>
        <a class="orderIconMobile item  orderTab <?php echo $selectedCustomerDiscountMenu; ?>"
            href="<?php echo esc_url(wc_get_endpoint_url('customer_discounts')); ?>" data-related="orderSect" id="subsNavv">
            <div class="icon subscription-nav-icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/subscription-black-icon.svg" alt="">
            </div>
        </a>        
        <a class="orderIconMobile item  orderTab <?php echo $selectedShineSubscriptionMenu; ?>"
            href="<?php echo esc_url(wc_get_endpoint_url('shine_subscription')); ?>" data-related="orderSect" id="subsNavv">
            <div class="icon subscription-nav-icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/subscription-black-icon.svg" alt="">
            </div>
        </a>
        <a class="item billingIconMobile  orderTab <?php echo $selectedBillingMenu; ?>" href="javascript:;" data-related="billingSec" id="billingSec">
            <div class="icon">

                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/credit_icon.svg" alt="">
            </div>
        </a>
        <a class="item shippingIconMobile orderTab <?php echo $selectedShippingMenu; ?>" href="javascript:;" data-related="shippingSec" id="shippingNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/delivery.svg" alt="">
            </div>
        </a>

        <a class="item rewardIconMobile  orderTab <?php echo $selectedRewardMenu; ?>" href="javascript:;" data-related="rewardSec" id="rewardNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/award.svg" alt="">
            </div>
        </a>
        <a class="item messageIconMobile orderTab <?php echo $selectedSupportMenu; ?>" href="javascript:;" data-related="messageSec" id="messageNav">
            <div class="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/myaccount/envelope.svg" alt="">
            </div>
        </a>
    <?php } ?>




</section>


<div class="md-overlay"></div>


<script>
    var initialTeeth_info;
    jQuery(document).ready(function() {
        oralProfileDisplay = jQuery('#oralProfileDisplay').html();
    });
    jQuery(document).ready(function() {
        jQuery('.loading-sbr').hide();
        jQuery('body').removeClass("loadingActivate");
    });
    var myAccountURL = '<?php echo site_url('my-account'); ?>';
    jQuery('body').on('click', '.contentOverlayMenu li a', function() {
        var currentLink = jQuery('body').find('#myAccountRef').val();
        var clickedLink = jQuery(this).parents('ul').attr('customLink');
        var commom_action = jQuery(this).parents('ul').attr('commom_action');
        var sublink = jQuery(this).attr('sublink');
            alert('currentLink= ' + currentLink);
            alert('clickedLink= ' + clickedLink);
        jQuery('.loading-sbr').show();
        jQuery('body').addClass("loadingActivate");

        if (currentLink == clickedLink) {
            if (sublink == 'billing' || sublink == 'shipping') {
                window.location.href = myAccountURL + '/' + clickedLink + '/' + sublink;
            } else if (sublink == 'rdh') {
                window.location.href = jQuery(this).attr('href');
            } else if (sublink == 'graphs') {
                window.location.href = myAccountURL + '/' + clickedLink + '?tab=' + sublink;
            } else if (sublink == 'viewAddress' || sublink == 'payment-methods' || sublink ==
                'add-payment-method') {
                if (sublink == 'viewAddress') {
                    sublink = 'edit-address';
                }
                window.location.href = myAccountURL + '/' + sublink;
            } else {
                dashboardAjaxRequest(commom_action + '&tab=' + sublink);
            }

        } else {
            // alert('URL')
            if (sublink == 'billing' || sublink == 'shipping') {
                window.location.href = myAccountURL + '/' + clickedLink + '/' + sublink;
            } else if (sublink == 'graphs') {
                window.location.href = myAccountURL + '/' + clickedLink + '?tab=' + sublink;
            } else if (sublink == 'viewAddress' || sublink == 'payment-methods' || sublink ==
                'add-payment-method') {
                if (sublink == 'viewAddress') {
                    sublink = 'edit-address';
                }

                window.location.href = myAccountURL + '/' + sublink;
            } else {
                // alert(myAccountURL + '/' + clickedLink + '?tab=' + sublink)
                window.location.href = myAccountURL + '/' + clickedLink + '?tab=' + sublink;
            }

        }
    });


    function dashboardAjaxRequest(ajaxUrl) {
        jQuery('.loading-sbr').show();
        jQuery('body').addClass("loadingActivate");
        jQuery.ajax({
            'url': '<?php echo admin_url("admin-ajax.php"); ?>',
            'data': 'action=' + ajaxUrl,
            'method': 'post',
            success: function(res) {
                jQuery('#SBRCustomerDashboard').html(res);
                jQuery('.loading-sbr').hide();
                jQuery('body').removeClass("loadingActivate");
                jQuery('.closeNavOverLay').trigger('click');
                jQuery('html, body').animate({
                    scrollTop: jQuery("#SBRCustomerDashboard").offset().top
                }, 0);
            }
        });
    }

    jQuery('.stickyNavigation a').on('click', function(e) {


    });

    jQuery('.md-close').on('click', function(e) {

        jQuery(".stickyNavigation a").removeClass("navActive");
        jQuery('.contentOverlayMenu').removeClass("md-show");
        jQuery('body').removeClass("mobileMenuOpen");
        jQuery('.contentmenu').removeClass("slide-up-fade-in");
        jQuery('.md-overlay').removeClass("displayOverLayBackground");


    });

    jQuery('body').on('click', '.stickyNavigation .orderIconMobile', function() {
        jQuery('.loading-sbr').show();
    });
    jQuery('body').on('click', '.stickyNavigation .item', function() {
        let selectSame = false;
        if (jQuery(this).hasClass('navActive')) {
            selectSame = true;
        }
        jQuery('.contentOverlayMenu .contentmenu').addClass("hideContent");
        jQuery('.contentOverlayMenu .contentmenu').removeClass("slide-up-fade-in");
        let itemId = jQuery(this).attr('id');
        let section = jQuery(this).attr('data-related');
        jQuery(".stickyNavigation a").removeClass("navActive");
        jQuery('.contentOverlayMenu').removeClass("md-show");
        jQuery('body').removeClass("mobileMenuOpen");
        jQuery('.md-overlay').removeClass("displayOverLayBackground");
        if (selectSame === false) {
            jQuery('#' + section).addClass("slide-up-fade-in");
            jQuery(this).addClass("navActive");
            jQuery('.contentOverlayMenu').addClass("md-show");
            jQuery('body').addClass("mobileMenuOpen");
            jQuery('.md-overlay').addClass("displayOverLayBackground");
        }
    });

    function editPaymentProfile() {
        jQuery('#order_id_cancellation').val('');
        jQuery('#cancell-response-ajax').html('');
        document.getElementById('editPaymentProfile').style.display = "block";
        jQuery('body').addClass('popupOpen');
    }

    jQuery('body').on('click', '#addNewTicketBtn', function() {

        jQuery('#messageList').hide();
        jQuery('#addNewTicket').show();
        jQuery('html, body').animate({
            scrollTop: jQuery("#addNewTicket").offset().top
        }, 0);
    });
    jQuery('body').on('click', '#backToList', function() {
        jQuery('#addNewTicket').hide();
        jQuery('#messageList').show();
        jQuery('html, body').animate({
            scrollTop: jQuery("#messageList").offset().top
        }, 0);
    });

    jQuery('body').find(".pagination .page-link").click(function() {

        jQuery('html, body').animate({
            scrollTop: jQuery("#getCustomerMyAccountOrders").offset().top
        }, 0);
    });

    jQuery('body').on('click', '#editProfileTab', function() {
        jQuery('#oralProfile').addClass('sectionEditActive');
        if (jQuery('#editProfileTab').text() == 'Save') {
            saveTeethInfo();
        }
        jQuery('#editProfileTab').text('Save');
        jQuery('#oralProfile #editProfileTabCancel').show();

    });

    jQuery('body').on('click', '#editProfileTabCancel', function() {
        jQuery('#oralProfile').removeClass('sectionEditActive');
        jQuery('#editProfileTab').text('Edit Info');
        jQuery('#oralProfile #editProfileTabCancel').hide();
        jQuery('#oralProfileDisplay').html(oralProfileDisplay);
    });



    jQuery('body').on('click', '#editCustomerInfoCancel', function() {
        jQuery('#editCustomerInfo').text('Edit Info');
        jQuery('#customerBasicInformation').removeClass('formEditingActivate');
        jQuery('#editCustomerInfoCancel').hide();
        jQuery('#customerProfileInfo .infoCEdit').hide();
        jQuery('#customerProfileInfo .infoCDisplay').show();
    });
    jQuery('body').on('click', '#editCustomerInfo', function() {
        var currentEvent = jQuery(this);
        if (currentEvent.text() == 'Edit Info') {
            currentEvent.text('Save');
            jQuery('#customerBasicInformation').addClass('formEditingActivate');
            jQuery('#editCustomerInfoCancel').show();
            jQuery('#customerProfileInfo .infoCEdit').show();
            jQuery('#customerProfileInfo .infoCDisplay').hide();
        } else {
            validation_custom = validateFormFields('customerBasicInformation', 's1Alter');
            if (!validation_custom) {
                return false;
            }
            jQuery('#customerBasicInformation').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var elementT = document.getElementById("customerBasicInformation");
            var formdata = new FormData(elementT);
            formdata.set('action', 'customerBasicInformation');
            validation_custom = validateFormFields('customerBasicInformation', 's1Alter');
            if (!validation_custom) {
                return false;
            }
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
                    jQuery('#s1Alter').html(response.msg);
                    jQuery('#customerProfileInfo').html(response.html);
                    jQuery("#s1Alter").show("slow").delay(3000).hide("slow");
                    jQuery('#customerBasicInformation').unblock();
                    currentEvent.text('Edit Info');
                    jQuery('#editSocialInfoCancel').hide();
                    jQuery('#customerProfileInfo .infoCEdit').hide();
                    jQuery('#customerProfileInfo .infoCDisplay').show();
                    jQuery('.loading-sbr').hide();

                },
                error: function() {
                    jQuery('.loading-sbr').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });




    jQuery('body').on('click', '#editSocialInfoCancel', function() {
        jQuery('#editSocialInfo').text('Edit Info');
        jQuery('#editSocialInfoCancel').hide();
        jQuery('#soicalProfileDisplay .infoCEdit').hide();
        jQuery('#soicalProfileDisplay .infoCDisplay').show();
    });
    jQuery('body').on('click', '#editSocialInfo', function() {
        var currentEvent = jQuery(this);
        if (currentEvent.text() == 'Edit Info') {
            currentEvent.text('Save');
            jQuery('#editSocialInfoCancel').show();
            jQuery('#soicalProfileDisplay .infoCEdit').show();
            jQuery('#soicalProfileDisplay .infoCDisplay').hide();
        } else {
            jQuery('#contactBasicInformation').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var elementT = document.getElementById("contactBasicInformation");
            var formdata = new FormData(elementT);
            formdata.set('action', 'contactBasicInformation');
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
                    jQuery("html, body").animate({
                        scrollTop: 0
                    }, 600);
                    if (response.code == 'error') {
                        jQuery('#s2Alter').html(response.msg);
                        jQuery("#s2Alter").show("slow").delay(3000);
                        jQuery('#contactBasicInformation').unblock();
                    } else {
                        jQuery('#s2Alter').html(response.msg);
                        jQuery('#soicalProfileDisplay').html(response.html);
                        jQuery("#s2Alter").show("slow").delay(3000).hide("slow");

                        currentEvent.text('Edit Info');
                        jQuery('#editSocialInfoCancel').hide();
                        jQuery('#soicalProfileDisplay .infoCEdit').hide();
                        jQuery('#soicalProfileDisplay .infoCDisplay').show();
                        jQuery('#contactBasicInformation').unblock();
                    }


                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });



    function editCustomerProfile(tab = 1) {
        jQuery('#editCustomerProfile').show(200);
        //  jQuery('#editCustomerProfile . nav-tabs .nav-item').removeClass('active');
        //  jQuery('#editCustomerProfile . nav-tabs .nav-item').removeClass('show');
        //  console.log(jQuery('#editCustomerProfile .nav-tabs .nav-item').eq(tab));
        jQuery('#editCustomerProfile .nav-tabs .nav-item').eq(tab).find('a').trigger('click');
        jQuery('#editProfileAccordion').hide(200);
    }

    function changeCustomerPassword() {
        jQuery('#changePasswordScreen').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        //jQuery('#changePasswordScreenResponse').html('');
        var elementT = document.getElementById("changePasswordScreen");
        var formdata = new FormData(elementT);
        formdata.set('action', 'changePasswordScreen');
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            dataType: 'JSON',
            method: 'POST',
            success: function(response) {
                jQuery('#changePasswordScreen').unblock();
                jQuery('#s4Alter').html(response.msg);
                jQuery("#s4Alter").show("slow"); //.delay(3000).hide("slow");
                if (response.code == 'success') {
                    document.getElementById('changePasswordScreen').reset();
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
    }


    jQuery('body').on('change', '#oralProfileDisplay input:radio', function() {
        if (jQuery(this).attr('name') == 'teeth-sensitivity') {
            jQuery('.teethSensitivityDiv .customRadioButton').removeClass('active');
            jQuery(this).closest('.customRadioButton').addClass('active');
        } else {
            jQuery('.teethColorDiv .customRadioButton').removeClass('active');
            jQuery(this).closest('.customRadioButton').addClass('active');
        }

    });

    function saveTeethInfo() {

        var elementT = document.getElementById("oralProfile");
        var formdata = new FormData(elementT);
        formdata.set('action', 'oralProfile');
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            dataType: 'JSON',
            method: 'POST',
            success: function(response) {
                oralProfileDisplay = response.html;
                jQuery('#oralProfileDisplay').html(oralProfileDisplay);

            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function saveCustomProfile() {
        var elementT = document.getElementById("contactBasicInformation");
        var formdata = new FormData(elementT);
        formdata.set('action', 'contactBasicInformation');
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            dataType: 'JSON',
            method: 'POST',
            success: function(response) {
                jQuery('#contactBasicInformationResponse').html(response.msg);
                //if(response.code == 'success'){
                jQuery('#soicalProfileDisplay').html(response.html);
                jQuery('#customerProfileInfo').html(response.customer);
                // document.getElementById('contactBasicInformation').reset();
                //}
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function getMoreOrders(paged) {


        jQuery('#getCustomerMyAccountOrders').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });

        var html =
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';

        jQuery('#getCustomerMyAccountOrders').html(html);
        jQuery.ajax({
            url: ajaxurl + '?action=getCustomerMyAccountOrders&paged=' + paged,
            data: {},
            type: 'POST',
            success: function(response) {
                jQuery('#getCustomerMyAccountOrders').html(response);
                jQuery('#getCustomerMyAccountOrders').unblock();
            }
        });

    }
    //editProfileAccordion
    function resetContactTabs() {
        jQuery('#editProfileAccordion .collapse').each(function(i, obj) {
            jQuery(this).removeClass('show');
        })
    }
    jQuery('body').on('click', '.myAccountMenu', function() {
        jQuery('.loading-sbr').show();
        return;
        let menu = jQuery(this).attr('menu');

        if (jQuery(this).hasClass('activeNav')) {
            jQuery('.myAccountMenu').removeClass('activeNav');
            resetContactTabs();
            if (menu === 'editCustomerProfile') {
                jQuery('#editProfileAccordion').hide();
                jQuery('#editCustomerProfile').hide();
            } else if (menu === 'order') {
                jQuery('#orderAccordion').hide();
            } else if (menu === 'reward') {
                jQuery('#affiliateAccordion').hide();
                jQuery('#affwp-affiliate-dashboardInner').hide();
            }
            jQuery('.ripple-button').removeClass('hidden');
        } else {
            jQuery('.myAccountMenu').removeClass('activeNav');
            jQuery(this).addClass('activeNav');
            jQuery('.ripple-button').addClass('hidden');
            jQuery(this).parent('.ripple-button').removeClass('hidden');
            resetContactTabs();
            if (menu === 'editCustomerProfile') {
                jQuery('#editProfileAccordion').fadeIn();
            } else if (menu === 'order') {
                jQuery('#orderAccordion').fadeIn();
            } else if (menu === 'reward') {
                jQuery('#affiliateAccordion').fadeIn();
                jQuery('#affwp-affiliate-dashboardInner').fadeIn();
            } else {
                jQuery('#editProfileAccordion').hide();
                jQuery('#editCustomerProfile').hide();
            }

        }

        jQuery('.customTabs a').removeClass('hidden');



    });

    function activaTab(tab) {
        jQuery('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    jQuery(document).on('click', '#pills-contact-tab', function() {

        if (jQuery(this).hasClass('contentloaded')) {
            //
        } else {
            jQuery(this).addClass('contentloaded');
            jQuery('.loading-sbr').show();
            jQuery.ajax({
                'url': '<?php echo admin_url("admin-ajax.php"); ?>',
                'data': 'action=orderSBR&tab=buyagain',
                'method': 'post',
                success: function(res) {
                    jQuery('.buyagaintab').html(res);
                    jQuery('.loading-sbr').hide();


                }
            });
        }
    });

    // activaTab('bbb');
</script>
<script>
    function removeUplodaedItem(item_id) {
        jQuery('#SBRCustomerDashboard').find('#uploadedFileInfo_' + item_id).remove();
    }

    function randomNumberFromRange(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    function formatBytes(bytes, decimals) {
        if (bytes == 0)
            return '0 Bytes';
        var k = 1024,
            dm = decimals || 2,
            sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
            i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    var uploadingItems = new Array();

    function uploadTicketAttachment(input) {

        var checkCount = $('body').find('#attachmentContainer .success-upload').length;
        if (checkCount > 5) {
            alert('You can  upload max 6 files for each  file max allowed size is  3 MB.');
            return false;

        }
        var i_inner = 0,
            len = input.files.length,
            file;
        // var totalItem = jQuery('#all-uplpad-image .image-panel').length;
        var formdata = new FormData();
        jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 0 + "%");
        jQuery('.loading-sbr').show();
        for (; i_inner < len; i_inner++) {

            file = input.files[i_inner];
            var vol_size = file.size;
            if (vol_size <= 0) {
                vol_size = 1;
            }
            vol_size = (vol_size) / 1024;
            vol_size = parseInt(vol_size);
            if (vol_size < 3072) {

                //    totalItem = totalItem + 1;
                //regex = /.jpg|.jpeg|.gif|.png|.bmp|.doc|.gif|.mobi|.mov|.mp3|.mpeg|.pdf|.psp|.rtf|.stl|.zip|.ePUB|.iBook/;
                regex = /.jpg|.jpeg|.gif|.png|.bmp|.doc|.pdf/;
                if ((!!file.type.match(regex))) {
                    var itemId = 'item_' + randomNumberFromRange(213, 5606565656);
                    formdata.append("attachment[]", file);
                    var items = new Array();
                    items['size'] = file.size;
                    items['name'] = file.name;
                    items['type'] = file.type;
                    uploadingItems.push(items);
                    checkCount++;
                } else {
                    formdata.append("attachment[]", 'Please upload files that end in jpg|.jpeg|.gif|.png|.bmp|.doc|.pdf.');
                    // alert('Please upload files that end in .bmp, .doc, .gif, .jpeg, .jpg, .mobi, .mov, .mp3, .mpeg, .pdf, .png, .psp, .rtf, .stl, .txt, .zip, .ePUB, or .iBook.');
                }
            } else {
                formdata.append("attachment[]", 'Your file size is ' + formatBytes(file.size) +
                    '. Max allowed size is  3 MB.');
                //alert('Your file size is ' + formatBytes(file.size) + '. Max allowed size is  3 MB.');
            }
            /// alert(checkCount)
            if (checkCount > 5) {
                break;
            }
        }
        jQuery('#SBRCustomerDashboard').find('.progress').show();
        jQuery('.loading-sbr').hide();
        if (uploadingItems.length > 0) {
            formdata.append("action", "uploadTicketAttachment");
            formdata.append("multiple", "yes");
            jQuery.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Upload progress
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 100 *
                                percentComplete + "%");
                        }
                    }, false);
                    // Download progress
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            // Do something with download progress
                            jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 100 *
                                percentComplete + "%");
                        }
                    }, false);
                    return xhr;
                },
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: formdata,
                async: true,
                method: 'POST',
                success: function(data) {
                    jQuery('#SBRCustomerDashboard').find('.progress').hide();
                    jQuery('#attachmentContainer').append(data);
                    jQuery('.loading-sbr').hide();
                    jQuery("#attachments_zendesk").val('');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        return;
        if (document.getElementById("attachments_zendesk").files.length > 0) {

            jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 0 + "%");
            jQuery('.loading-sbr').show();
            var property = document.getElementById('attachments_zendesk').files[0];
            var image_name = property.name;
            var fileType = property.type;
            var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png',
                'image/jpg'
            ];
            if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (
                    fileType == match[4]) || (fileType == match[5]))) {
                alert('Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.');
                jQuery("#attachmentContainer").val('');
                jQuery('#SBRCustomerDashboard').find('.progress').hide();
                jQuery('.loading-sbr').hide();
            } else {
                jQuery('#SBRCustomerDashboard').find('.progress').show();
                var form_data = new FormData();
                form_data.append("action", "uploadTicketAttachment");
                form_data.append("file_name", image_name);
                form_data.append("attachment", property);
                jQuery.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        // Upload progress
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                //Do something with upload progress
                                
                                jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 100 *
                                    percentComplete + "%");
                            }
                        }, false);
                        // Download progress
                        xhr.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                // Do something with download progress
                                
                                jQuery('#SBRCustomerDashboard').find('.progress-bar').css('width', 100 *
                                    percentComplete + "%");
                            }
                        }, false);
                        return xhr;
                    },
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: form_data,
                    async: true,
                    method: 'POST',
                    success: function(data) {
                        jQuery('#SBRCustomerDashboard').find('.progress').hide();
                        jQuery('#attachmentContainer').append(data);
                        jQuery('.loading-sbr').hide();
                        // jQuery('#SBRCustomerDashboard').unblock();
                        jQuery("#attachments_zendesk").val('');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    }



    $send_chat = true;
    jQuery('body').on('click', '#btn_customer_zendesk_chat', function() {
        jQuery('.loading-sbr').show();
        if ($send_chat) {
            <?php
            if ($endpointTop == 'support') {
                echo 'tinyMCE.triggerSave();';
            }
            ?>
            $send_chat = false;
            var elementT = document.getElementById("customer_zendesk_chat");
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: formdata,
                async: true,
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
                    $send_chat = true;
                    if (response.status == 'error') {
                        alert(response.message);
                    } else {
                        window.location.href =
                            '<?php echo wc_get_account_endpoint_url('support/'); ?>' + response
                            .ticket_id;
                    }
                    jQuery('.loading-sbr').hide();
                },
                error: function() {
                    jQuery('.loading-sbr').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
</script>


<!-- <div class="form-popup ult-overlay" id="editPaymentProfile" style="display:none">
    <div class="popupInnerBody ult_modal">
        <div class="ult_modal-content">

            <button type="button" class="cancel cancelButton" onclick="CancelOrderByIDMbtClose()"><i class="fa fa-times" aria-hidden="true"></i>
            </button>

            <form id="cancelOrderFormData" class="form-container " onsubmit="return false">
                <h1 class="uppercase">Edit Payment Method</h1>
                <div class="" style="display: flex;padding-top: 30px;padding-bottom: 23px;">
                    <div class="leftSide" style="padding-right: 40px;">
                        <label>Name on Card<br />
                            <input type="text" name="" value="Master Card 4444" />
                        </label>
                        <label>Set as Default payment method.
                            <input type="checkbox" name="" value="yes" />
                        </label>

                    </div>
                    <div class="rightSide">
                        <h5 class="">Edit Payment Method</h5>
                        <p>
                            Abidoon Nadeem<br />
                            169-P<br />
                            Model Town Ext<br />
                            Lahore, Punjab, 54700<br />
                            Pakistan<br />
                            +92336012345678<br />
                        </p>
                        <a href="javascript:;">Change</a>
                    </div>
                </div>


                <button type="submit" class="btn">Cancel</button>
                <button type="submit" class="btn">Save</button>
                <div id="cancell-response-ajax"></div>
            </form>
        </div>
    </div>
</div> -->
<div class="form-popup ult-overlay" id="cancelOrderForm" style="display:none">
    <div class="popupInnerBody ult_modal">
        <div class="ult_modal-content">

            <button type="button" class="cancel cancelButton" onclick="CancelOrderByIDMbtClose()"><i class="fa fa-times" aria-hidden="true"></i>
            </button>

            <form id="cancelOrderFormData" class="form-container " onsubmit="return false">
                <h1 class="uppercase">Cancel Order</h1>


                <div class="form-control form-control-no-border">
                    <input type="hidden" name="order_id" id="order_id_cancellation" value="" required>
                    <input type="hidden" name="action" value="cancel_order_by_id_mbt" required>
                    <label for="psw">Cancellation reason</label>
                    <select name="reason_cancellation">
                        <option value="The Product is damaged or defective"> The Product is damaged or defective
                        </option>
                        <option value="The Product arrived too late"> The Product arrived too late </option>
                        <option value="I no longer need the product"> I no longer need the product </option>
                        <option value="The product did not match the description"> The product did not match the
                            description </option>


                    </select>
                </div>

                <div class="form-control form-control-no-border textarea_sec">
                    <textarea name="message" placeholder="Message"></textarea>
                </div>
                <button type="submit" class="btn" onclick="submitCancellationMbt()">Submit</button>
                <div id="cancell-response-ajax" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>
<script>
    function CancelOrderByIDMbt(order_id, $orderNumber) {
        jQuery('#order_id_cancellation').val(order_id);
        jQuery('#cancell-response-ajax').hide();
        document.getElementById('cancelOrderForm').style.display = "block";
        jQuery('body').addClass('popupOpen');
    }

    function CancelOrderByIDMbtClose() {
        jQuery('#order_id_cancellation').val('');
        jQuery('#cancell-response-ajax').hide();
        document.getElementById('cancelOrderForm').style.display = "none";
        document.getElementById("cancelOrderFormData").reset();
        jQuery('body').removeClass('popupOpen');


    }

    function submitCancellationMbt() {
        completeId = "#cancelOrderFormData";
        error = false;
        jQuery(completeId).find('input,select,textarea').each(function() {
            if (jQuery(this).val() == '') {
                alert(jQuery(this).attr('name') + ' is empty');
                error = true;
            }
        });
        if (!error) {
            jQuery('.loading-sbr').show();
            dataFrom = jQuery(completeId).serialize();
            jQuery.ajax({
                data: dataFrom,
                method: 'POST',
                url: ajaxurl,
                success: function(res) {
                    // jQuery('.loading-sbr').hide();
                    if (res.includes('success')) {
                        jQuery('#cancell-response-ajax').removeClass('red');
                        jQuery('#cancell-response-ajax').addClass('green');
                        jQuery('#cancell-response-ajax').html('Your request to cancel order has been sent.');
                        jQuery('#cancell-response-ajax').show();
                        jQuery('.loading-sbr .inner-sbr').text('Reloading...').css('color', 'red');
                        location.reload();
                    } else {
                        jQuery('#cancell-response-ajax').removeClass('green');
                        jQuery('#cancell-response-ajax').addClass('red');
                        jQuery('#cancell-response-ajax').html(res);
                        jQuery('#cancell-response-ajax').show();
                        jQuery('.loading-sbr .inner-sbr').text('Reloading...').css('color', 'red');
                        location.reload();
                    }

                }
            });
        }
    }
</script>
<div class="backdropBg"></div>
<div class="form-popup ult-overlay" id="refundOrderForm" style="display:none">
    <div class="popupInnerBody ult_modal">
        <div class="ult_modal-content">
            <form class="form-container" id="refundOrderFormData">
                <input type="hidden" name="order_id" id="order_id_refund" value="" required>
                <input type="hidden" id="refund_replace_action" name="action" value="refund_order_by_id_mbt" required>
                <div class="popHeader">
                    <button type="button" class="cancel refundButton cancelButton" onclick="RefundlOrderByIDMbtClose()"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <h1 class="headingPopMain firstStepHeading">Return or Replace</h1>
                    <div class="headerSecStepTwo">
                        <h1 class="headingPopMain"><span class="return_replace_heading">Return Items</span></h1>
                        <p class="orderNumberDetail">Order Number# <span class="currentORder"></span></p>
                    </div>
                </div>

                <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop tabsPop" id="returnOrReplacePop">
                    <li class="nav-item">
                        <a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id="return-item-tab" data-toggle="pill" href="javscript:;" role="tab" aria-controls="return-item" aria-selected="true">Return Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="replace-item-tab" data-toggle="pill" href="#replace-item" role="tab" aria-controls="replace-item" aria-selected="false">Replace Item</a>
                    </li>
                </ul>

                <div id="tabContent-pop" class="tab-content">
                    <div class="tab-pane active" id="return-item">
                        <div class="stepOne">
                            <div class="form-control form-control-no-border">
                                <label for="reason_refund" id="reason_refund_label">Reason for return</label>
                                <select name="reason_refund" id="reason_refund">
                                    <option value="The Product is damaged or defective"> The Product is damaged or
                                        defective</option>
                                    <option value="The Product arrived too late"> The Product arrived too late </option>
                                    <option value=" I no longer need the product"> I no longer need the product
                                    </option>
                                    <option value=" The product did not match the description"> The product did not
                                        match the description </option>

                                </select>
                            </div>
                            <div class="form-control form-control-no-border textarea_sec">
                                <label for="message">Comment</label>
                                <textarea name="message" placeholder="Typre your message"></textarea>
                            </div>
                        </div>
                        <div class="stepTwo">
                            <div class="productItemsWrapperPop">
                                <div class="productItemsList">
                                    <label class="d-flex align-items-center">
                                        <input type="radio" name="mygroup" id="" value="value1" />
                                        <div class="productItemRepeater">
                                            <div class="sbr-orderItemLeft d-flex align-items-center">
                                                <div class="orderImage ">
                                                    <img width="170" height="130" src="https://www.smilebrilliant.com/wp-content/uploads/2020/08/smilebrilliant-night-guards-thumb-noshadow.png" alt="">
                                                </div>
                                                <div class="orderTitle  d-flex align-items-center">
                                                    <h4 class="productNameAndQuantity mb-0 ">T9 Sensitive System
                                                        (Custom-Fitted Trays + 9 Whitening &amp; Desensitizing Gel
                                                        Syringes) × <span class="text-blue">1</span></h4>
                                                    <div class="quantityBoxPop">
                                                        <select>
                                                            <option selected disabled>QTY</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="productItemsList">
                                    <label class="d-flex align-items-center">
                                        <input type="radio" name="mygroup" id="" value="value2" />
                                        <div class="productItemRepeater">
                                            <div class="sbr-orderItemLeft d-flex align-items-center">
                                                <div class="orderImage ">
                                                    <img width="170" height="130" src="https://www.smilebrilliant.com/wp-content/uploads/2020/08/smilebrilliant-night-guards-thumb-noshadow.png" alt="">
                                                </div>
                                                <div class="orderTitle">
                                                    <h4 class="productNameAndQuantity mb-0 ">T9 Sensitive System
                                                        (Custom-Fitted Trays + 9 Whitening &amp; Desensitizing Gel
                                                        Syringes) × <span class="text-blue">1</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                            </div>
                        </div>



                        <div class="nextButton">
                            <a href="javascript:;" id="clickToNextStep">Next</a>
                        </div>
                        <div class="submitButton">
                            <a class="btn" href="javascript:void(0);" onclick="submitRefundlationMbt()">Submit</a>
                        </div>
                        <div id="refund-response-ajax"></div>




                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).on('click', '#returnOrReplacePop .nav-item a', function() {
        if (jQuery(this).attr('id') == 'return-item-tab') {
            fillFormForReturn('refund');
        }
        if (jQuery(this).attr('id') == 'replace-item-tab') {
            fillFormForReturn('replace');
        }
    });

    function fillFormForReturn(tab) {

        var refund_options =
            '<option value="The Product is damaged or defective"> The Product is damaged or defective </option><option value="The Product arrived too late"> The Product arrived too late </option><option value="I no longer need the product"> I no longer need the product </option><option value="The product did not match the description"> The product did not match the description </option>';
        var replace_options =
            '<option value="The Product is damaged or defective"> The Product is damaged or defective</option> <option value="The Product malfunctioned after use"> The Product malfunctioned after use</option>';
        if (tab == 'refund') {
            jQuery('#reason_refund').html(refund_options);
            jQuery('#refund_replace_action').val('refund_order_by_id_mbt');
            jQuery('#reason_refund_label').text('Reason for return');
            jQuery('.return_replace_heading').text('Return Items');
        }
        if (tab == 'replace') {
            jQuery('#reason_refund').html(replace_options);
            jQuery('#refund_replace_action').val('replace_order_by_id_mbt');
            jQuery('#reason_refund_label').text('Reason for replace');
            jQuery('.return_replace_heading').text('Replace Items');
        }

    }

    function RefundOrderByIDMbt(order_id, $orderNumber) {
        jQuery('.currentORder').text($orderNumber);
        jQuery('#order_id_refund').val(order_id);
        jQuery('#refund-response-ajax').html('');
        document.getElementById('refundOrderForm').style.display = "block";
        jQuery('body').addClass('popupOpen');
        jQuery('.loading-sbr').show();
        jQuery.ajax({
            data: 'action=get_order_products_html_by_order_id_mbt&order_id=' + order_id,
            method: 'POST',
            url: ajaxurl,
            success: function(res) {
                jQuery('.loading-sbr').hide();
                jQuery('.productItemsWrapperPop').html(res);

            }
        });

    }

    function RefundlOrderByIDMbtClose() {
        jQuery('#order_id_refund').val('');
        jQuery('#refund-response-ajax').html('');
        document.getElementById('refundOrderForm').style.display = "none";
        jQuery('body').removeClass('popupOpen');
        document.getElementById("refundOrderFormData").reset();


    }

    function submitRefundlationMbt() {
        completeId = "#refundOrderFormData";
        error = false;
        jQuery(completeId).find('input,select').each(function() {
            if (jQuery(this).val() == '') {
                alert(jQuery(this).attr('name') + ' is empty');
                error = true;
            }
        });
        if (!error) {
            jQuery('.loading-sbr').show();
            dataFrom = jQuery(completeId).serialize();
            jQuery.ajax({
                data: dataFrom,
                method: 'POST',
                url: ajaxurl,
                success: function(res) {
                    //jQuery('.loading-sbr').hide();
                    if (res.includes('success')) {
                        jQuery('#refund-response-ajax').removeClass('red');
                        jQuery('#refund-response-ajax').addClass('green');
                        jQuery('.popupInnerBody').addClass('responceMessageShow');
                        jQuery('#refund-response-ajax').html(
                            'A ticket has been filed to process your return request. A member of our support team will be in touch with you.'
                        );
                        jQuery('.loading-sbr .inner-sbr').text('Reloading...').css('color', 'red');
                        location.reload();
                    } else {
                        jQuery('#refund-response-ajax').removeClass('green');
                        jQuery('#refund-response-ajax').addClass('red');
                        jQuery('.popupInnerBody').removeClass('responceMessageShow');
                        jQuery('#refund-response-ajax').html(res);
                        jQuery('.loading-sbr .inner-sbr').text('Reloading...').css('color', 'red');
                        location.reload();

                    }
                    // jQuery('#refund-response-ajax').html(res);
                }
            });
        }
    }


    jQuery('#clickToNextStep').on('click', function() {
        jQuery('.popupInnerBody').addClass('jSnextStepAcive');
    });
    jQuery('#refundOrderForm .cancelButton').on('click', function() {
        jQuery('.popupInnerBody').removeClass('jSnextStepAcive');
        jQuery('.popupInnerBody').removeClass('responceMessageShow');
    });

    jQuery('.backdropBg').on('click', function() {
        jQuery('.form-popup.ult-overlay').removeClass('');
    });


    function validateFormFields(form_id, response_id) {

        responsecomplete_id = '#' + response_id;
        formcomplete_id = '#' + form_id;
        error_string = '';
        jQuery(formcomplete_id).find('.custom-req').each(function() {
            input_name = jQuery(this).attr('name');
            input_name = input_name.replace("_", " ");
            if (jQuery(this).val() == '') {
                error_string += '<div class="alert alert-danger" role="alert">' + input_name + ' Is required</div>';
            }
            if (input_name.includes("email")) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (!emailReg.test(jQuery(this).val())) {
                    error_string += '<div class="alert alert-danger" role="alert">Invalid email address</div>';
                }
            }
            if (input_name.includes("phone")) {
                PhoneNumberRegex = "^[\\d*#+]+$";
                if (!jQuery(this).val().match(PhoneNumberRegex)) {
                    error_string += '<div class="alert alert-danger" role="alert">Invalid phone number</div>';
                }
            }

        });
        jQuery(responsecomplete_id).html(error_string);
        if (error_string == '') {
            return true;
        } else {
            return false;
        }
    }


    function viewItemSummery(product_id, item_id, order_number) {
        var data = {
            product_id: product_id,
            item_id: item_id,
            order_number: order_number,
            action: 'viewItemSummery'
        };
        jQuery('body').find('#viewItemLogOrdernumber span.orderNumberJs').html(order_number);
        var html =
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        html +=
            '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';

        jQuery('body').find('#viewItemLogOrderItemData').html(html);

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: data,
            async: true,
            dataType: 'html',
            method: 'POST',
            beforeSend: function(xhr) {

            },
            success: function(response) {
                jQuery('body').find('#viewItemLogOrderItemData').html(response);

            },
            error: function(xhr) {
                jQuery('body').find('#viewItemLogOrderItemData').html('Request failed...Something went wrong.');
            },
            cache: false,
        });
    }
    jQuery('body').on('change', '.form-group-radio-custom input', function() {

        var product_id = $(this).val();
        var price = $(this).attr('reOrderPrice');
        var nightKey = $(this).attr('nightKey');
        var nightKeyOther = $(this).attr('nightkeyother');
        var parent = $(this).parentsUntil('.reOrderWrapper');
        parent.find('.price_NightGuard').html(price);
        parent.find('.nightGuard').attr('data-product_id', product_id);
        parent.find('.nightGuard').removeAttr('data-' + nightKey);
        parent.find('.nightGuard').removeAttr('data-' + nightKeyOther);
        parent.find('.nightGuard').attr('data-' + nightKey, price);
        parent.find('.nightGuard').attr('href', '?add-to-cart=' + product_id);


    });


    jQuery(function() {
       // jQuery('body').find('.nightguard_classs22').prop('checked', true).attr('checked', 'checked');
       var radioInputs = $('.form-group-radio-custom input[type="radio"]');
       radioInputs.filter(':checked').trigger('change');

       jQuery('.expander').on('click', function() {
            jQuery(this).closest(".reOrderWrapper").toggleClass("toggleItem");
            jQuery(this).next().toggle();
        });
    });



    setTimeout(function() {

        jQuery('.addReviewPop').on('click', function() {
            jQuery("#addReviewForm").css("display", "block");
            jQuery("body").addClass("popupOpen");
        });

        jQuery('#addReviewForm .cancelButton').on('click', function() {
            jQuery("#addReviewForm").css("display", "none");
            jQuery("body").removeClass("popupOpen");
        });

    }, 200);
</script>