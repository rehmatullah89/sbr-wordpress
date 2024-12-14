<?php

/*

Template Name: My Account V2

*/

//get_header();

?>
<style>
    ul.nav-bar-mobile-list-ul li {
        list-style: none;
    }

    .nav-bar-mobile-list-li-a-div {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        column-gap: 12px;
    }

    .hmenu-item.hmenu-title {
        font-family: Montserrat;
        text-align: left;
        /* padding-bottom: 5px; */
        font-size: 18px;
        font-weight: 600;
        line-height: 24px;
        color: #111;
        padding-right: 20px;
        padding-top: 13px;
        text-transform: uppercase;letter-spacing: 0.05em;
        color: #3b97ca;
    }

    .hmenu-item-sub.hmenu-sub-title {
        text-align: left;
        font-family: Montserrat;
        font-size: 14px;
        padding-bottom: 10px;
        font-weight: 500;
    }

    a.nav-bar-mobile-list-li-a {

        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/mobile-nav-right-icon.svg");
        display: flex;
        width: 100%;
        font-family: Montserrat;
        background-repeat: no-repeat;
        background-position: center right;
        align-items: center;
        -webkit-tap-highlight-color: transparent;
        background-size: 24px;
        padding-right: 20px;
        /* padding-left: 36px; */
        transition: all .4s;
        padding-top: 13px;
        padding-bottom: 13px;
        text-decoration: none;
        color: #565759;
        font-size: 14px;
        line-height: 1;
        text-transform: uppercase;
        font-weight: normal;
        font-weight: 500;
        letter-spacing: 0.05em;
        background-position-x: 100%;
        

    }

    .nav-bar-mobile-list-li-a-div-img {
        max-width: 20px;
        min-width: 20px;
    }

    .nav-bar-mobile-list-li-a-div-img img {
        max-width: 100%;
        width: 100%;
        height: 100%;
    }

    .section-nav-dashboard-list {
        border-bottom: 1px solid #dbdbdbee;
    }
    .woocommerce-page div.woocommerce {
        padding-top: 0px;
    }
    .myAccountContainerMbtInnerMobile {
        padding-left: 0px;
        padding-right: 0px;
    }
    .geha-memeber-button{
        opacity: 0.6;
    }
    .myaccount-dashboard-mobile {
    width: 100%;
    max-width: 100%;
    }

    .container.fullWidthSection {
        padding-right: 15px;
         padding-left: 15px;
    }
    .db-row-edit-container {
        margin-right: 0px;
        margin-left: 0px;
    }

@media screen only (max-width: 768px) {
    a.nav-bar-mobile-list-li-a {
        background-position-x: 102%;
    }
}
</style>

<div class="myaccount-dashboard-mobile">
    <div class="pageStainConcealer">

        <div class="section-nav-dashboard-list">

        <?php
        $current_user = wp_get_current_user();
        $shine_user = get_user_meta($current_user->ID, 'is_shine_user', true);
        if($shine_user){
        ?>
            <div class="hmenu-item hmenu-title shine-nav-mobile">Sh<span style="color:#f0c23a">!</span>ne Subscriptions</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Manage and download your shine cards.</div>
            <ul class="nav-bar-mobile-list-ul">

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/shine_subscription/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/shine-smile-my-account-icon.png"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Shine Subscriptions</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/customer_discounts/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/orders-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Customer Discounts</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/shine_card/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/shine-card.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Membership Card</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/shine_discounts/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/shine-discount.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">My Discounts</div>
                            </div>
                        </a>
                    </li>
            </ul>
            <?php
            }
            ?>

            <div class="hmenu-item hmenu-title ">PROFILE</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Manage and edit your name email or password</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/edit-account/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/users-icon-v2.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Profile</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/edit-account/?tab=social">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/social-icon.svg"
                                        alt="">
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Social</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/edit-account/?tab=password">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/password-icon.svg"
                                        alt="">
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Change Password</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="section-nav-dashboard-list orders-list">
            <div class="hmenu-item hmenu-title ">Orders</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Track, return or buy items again.</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/orders">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/orders-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">View All</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="section-nav-dashboard-list subscrition-list">
            <div class="hmenu-item hmenu-title ">Subscription</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Track, return or buy items again</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/subscription">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/subs-icon-1.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">View All</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        
        <div class="section-nav-dashboard-list billing-list">
            <div class="hmenu-item hmenu-title ">Billing</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Manage and edit your billing profiles</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/payment-methods">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/view-payment-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">View payment methods</div>
                            </div>
                        </a>
                    </li>

                    <!-- <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/add_payment_card/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/add-payment-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Add payment methods</div>
                            </div>
                        </a>
                    </li> -->

                </ul>
            </nav>
        </div>

        <div class="section-nav-dashboard-list billing-list">
            <div class="hmenu-item hmenu-title ">Shipping</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Manage your shipping addresses.</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/manage-shipping-address">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/shipping.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">View shipping address</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li add-new-shipping">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/edit-shipping-address/add/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img  style=" max-width: 24px; width: 24px;height: 24px;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/shipping-new.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Add new shipping</div>
                            </div>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>


        <div class="section-nav-dashboard-list billing-list">
            <div class="hmenu-item hmenu-title ">Reward</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Track, return or buy items again.</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=urls">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/url-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Affiliate URLS</div>
                            </div>
                        </a>
                    </li>
                    <?php if (affwp_get_affiliate_id()) { ?>
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=stats">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/stat-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Statistics</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=graphs">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/graph-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">Graphs</div>
                            </div>
                        </a>
                    </li>


                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=referrals">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/referrals-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">referrals</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=payouts">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/payout-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">payouts</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=visits">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/add-payment-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">visits</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/reward/?tab=settings">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/settings-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">settings</div>
                            </div>
                        </a>
                    </li>


                    <?php } ?>


                </ul>
            </nav>
        </div>

        <div class="section-nav-dashboard-list billing-list">
            <div class="hmenu-item hmenu-title ">Customer Support</div>
            <div class="hmenu-item-sub hmenu-sub-title ">Connect with Smile Brilliant customer service.</div>
            <nav class="nav-bar-mobile-list">
                <ul class="nav-bar-mobile-list-ul">
                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/support/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/tickets-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">All tickets</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-bar-mobile-list-li">
                        <a class="nav-bar-mobile-list-li-a"
                            href="<?php echo home_url(); ?>/my-account/support/add/">
                            <div class="nav-bar-mobile-list-li-a-div">
                                <div class="nav-bar-mobile-list-li-a-div-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/my-account/new-ticket-icon.svg"
                                        alt="" />
                                </div>
                                <div class="nav-bar-mobile-list-li-a-div-text">new tickets</div>
                            </div>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>


        <!-- <div
            style="color: rgb(10, 10, 10); font-family: inherit; font-size: 16px; font-weight: 400; text-transform: capitalize; text-align: center; display: flex; justify-content: center; margin-top: 20px;">
            Not<div style="font-weight: 700; margin-left: 5px;"><?php esc_html($current_user->first_name);?> ?</div>
            <div style="color: rgb(60, 152, 204); margin-left: 5px;"><a href="<?php echo wp_logout_url( get_permalink('') ); ?>">Log Out</a></div>
        </div> -->
    </div>
</div>




<?php

//get_footer();
