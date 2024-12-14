<?php

require(get_stylesheet_directory() . '/inc/rdh-info.php');

$footer_classes[] = 'footer';

$footer_classes[] = ot_get_option('footer_color', 'light');

$footer_classes[] = 'footer-full-width-' . ot_get_option('footer_full_width', 'off');

?>

<!-- Start Footer -->

<footer id="footer" class="<?php echo esc_attr(implode(' ', $footer_classes)); ?>">

    <div class="subscribe-newsletter">

        <div class="container-full ">

            <div class="row max_width">

                <div class="small-12 medium-6 columns">

                    <h4 id="footer-newsletter-title">ARE YOU A DENTAL HYGIENIST?</h4>

                </div>

                <div class="small-12 medium-6 columns">

                    <div class="justify-right">
<?php
// $field_value = bp_get_profile_field_data(array(
//     'field' => 'Referral',
//     'user_id' => $user_id,

// ));
$data =  sbr_rdhc_retrieve_invite_code($user_id);
$code = '';

if (isset($data->code) && $data->limit>0) {
    $code = $data->code;
    $limit = $data->limit;
    $display = $code . '/' . $limit;
}
?>
                        <a href="<?php echo get_home_url(); ?>/rdh-register/?referral_code=<?php echo $code;?>" class="btn btn-primary-white-yellow">JOIN THE NETWORKK!</a>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <?php do_action('thb_footer_logo'); ?>

    <?php do_action('thb_page_content', apply_filters('thb_footer_page_content', ot_get_option('footer_top_content'))); ?>

    <div class="footer-mbt-tp">

        <div class="row footer-row footer-mbt-tppp">

            <div class="small-12 medium-5 large-5 columns mobile-footer-order-2">

                <div class="rdh-footer-left">

                    <div>

                        <div class="rdh-logo">

                            <img class="desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rdh-profile/RDH-logo.svg" alt="" />

                            <!-- <img class="desktop"

                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/RDH-connect-logo.png" alt="" /> -->

                        </div>

                        <p class="rdh_info_mbt">

                            <?php echo $user_firstname; ?> <?php echo $user_lastname; ?> RDH is a member of RDH Connect<sup>&#8482;</sup>, 
                            <!-- a curated network of the nation's most active and influential dental hygienists, who are committed to improving oral health through education. -->
                            the first community uniting dental hygienists as colleagues to influence the conversation around oral health and find opportunity through connection.

                        </p>

                    </div>

                </div>

            </div>

            <?php //do_action( 'thb_footer_columns' ); 
            ?>

            <!-- <div class="small-12 medium-1 large-1 columns"></div> -->

            <div class="small-12 medium-4 large-4 columns mobile-footer-order-3">

                <div class="widget cf widget_nav_menu">

                    <h6>helpful links</h6>
                    <?php
                    $buddy_name = get_query_var('buddyname');
                    if ($buddy_name == '') {
                        if(function_exists('bp_is_active')){
                            $buddy_name = bp_core_get_username($user_id);
                        }
                        //$buddy_name = $exploded[2];
                    }
                    ?>
                    <div class="menu-footer-nav-2-container">

                        <ul class="menu">

                            <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="/rdh/profile/<?php echo $buddy_name; ?>"> <?php echo $user_firstname; ?> <?php echo $user_lastname; ?> RDH Professional Profile</a></li>

                            <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="/rdh/products/<?php echo $buddy_name; ?>?ref=<?php echo $affiliate_id; ?>"><?php echo $user_firstname; ?> <?php echo $user_lastname; ?> RDH Recommended Products</a></li>

                            <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="/rdh/contact/<?php echo $buddy_name; ?>">Contact <?php echo $user_firstname; ?> <?php echo $user_lastname; ?> RDH</a></li>

                        </ul>

                    </div>



                    <h6 class="siteLinksPersonal">site links</h6>

                    <div class="menu-footer-nav-2-container">

                        <ul class="menu">

                            <?php if (!is_user_logged_in()) {

                            ?>

                                <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="<?php echo get_home_url(); ?>/rdh/">RDH Connect™ Home</a></li>





                                <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="<?php echo get_home_url(); ?>/rdh-register/?referral_code=FMRS22">Register for RDH Connect™</a></li>

                                <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="<?php echo get_home_url(); ?>/my-account/">Member Login</a></li>

                            <?php } ?>

                            <li class="menu-item menu-item-type-custom menu-item-object-custom "><a href="<?php echo get_home_url(); ?>">Smile Brilliant Oral Care</a></li>

                        </ul>

                    </div>

                </div>

            </div>



            <div class="small-12 medium-3 large-3 columns mobile-footer-order-1">

                <div class="user-profile-header">

                    <div class="profile-image-header-parent">

                        <div class="profile-image">

                            <div class="user-img">

                                <img src="<?php
if(function_exists('bp_is_active')){
                                            echo bp_core_fetch_avatar(

                                                array(
                                                    'item_id' => $user_id, // id of user for desired avatar

                                                    'type'    => 'full',

                                                    'html'   => FALSE     // FALSE = return url, TRUE (default) = return img html

                                                )

                                            );
                                        }
                                            ?>" alt="" />

                            </div>

                            <div class="border-img">

                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/border-round.png" alt="" srcset="">

                            </div>

                        </div>

                        <div class="rdh-profile-top-section">

                            <div class="profile-detail Montserrat">

                                <div class="rdh-logo rdh-mobile-logo">

                                    <img class="desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rdh-profile/RDH-logo.svg" alt="" />

                                </div>

                                <h3><?php echo $user_firstname; ?> <?php echo $user_lastname; ?> <span class="RDHdisplayName">RDH</span>
                                    <?php
                                    echo '<span class="checkbMark">';
                                    $icon = 'verified_icon_blue';
                                    //    echo $user_id;
                                    if (in_array($user_id, array(149484, 114131, 149487, 149480))) {
                                        $icon = 'verified_icon_pink';
                                    }
                                    echo '<img class="iconVerificed" src="' . get_stylesheet_directory_uri() . '/assets/images/' . $icon . '.svg" alt="" />';
                                    echo '</span>';

                                    ?></h3>

                                <p class="designation"> <?php echo $rdh_subtitle; ?></p>

                                <div class="address">

                                    <p><?php echo $address_town_city; ?>, <?php echo $address_state; ?>, <?php echo $address_country;?></p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>









            </div>



        </div>

    </div>







</footer>

<!-- End Footer -->