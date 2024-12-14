<!doctype html>

<html <?php language_attributes(); ?>>



<head>

            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon/favicon-16x16.png">
            <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon/site.webmanifest">
            <link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
            <meta name="msapplication-TileColor" content="#da532c">
            <meta name="theme-color" content="#ffffff">

    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="color-scheme" content="light only" />
    <meta name="supported-color-schemes" content="light" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">

    <link rel="profile" href="http://gmpg.org/xfn/11">

    <meta name="google-site-verification" content="dDdWeexBGoa81nhp6EOYjALxzvQQwHllqZAXFnSY4bM" />

    <meta name="facebook-domain-verification" content="4eqw7wferl6j9egl8p8wp3x0axo0f2" />
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>" />
    <!-- Podcorn -->

    <?php

    if (WP_ENV  == 'production') {

        $enable_google_optimize = get_field('enable_service', 'option');

        //  if ($enable_google_optimize) {

        echo '<script src="https://www.googleoptimize.com/optimize.js?id=OPT-574SN2W"></script>';
        echo '<img src="https://trkn.us/pixel/c?ppt=20516&g=sitewide&gid=48032" height="0" width="0" border="0" style="display: none;"  />';

        // }

    ?>



        <script>
            // (function(w, d, s, l, i) {

            //     w[l] = w[l] || [];



            //     function podcorn() {

            //         w[l].push(arguments);

            //     };

            //     podcorn('js', new Date());

            //     podcorn('config', i);

            //     var f = d.getElementsByTagName(s)[0],

            //         j = d.createElement(s);

            //     j.async = true;

            //     j.src = 'https://behaviour.podcorn.com/js/app.js?id=' + i;

            //     f.parentNode.insertBefore(j, f);

            // })(window, document, 'script', 'podcornDataLayer', 'cf9e577f-9296-448a-aaeb-0a3e2cd9b4f6');
        </script>

        <script>
            (function(w, d, t, r, u) {

                var f, n, i;

                w[u] = w[u] || [], f = function() {

                        var o = {

                            ti: "175001323"

                        };

                        o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")

                    },

                    n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function() {

                        var s = this.readyState;

                        s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)

                    },

                    i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i)

            })

            (window, document, "script", "//bat.bing.com/bat.js", "uetq");
        </script>

        <!-- End Podcorn -->

    <?php

    }

    /*

      <script src="https://www.googleoptimize.com/optimize.js?id=OPT-574SN2W" onerror="window.GoogleOptimizeError = true"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/googleOptimize.js?v=<?php echo time(); ?>"></script>

               



         * Always have wp_head() just before the closing </head>

         * tag of your theme, or you will break many plugins, which

         * generally use this hook to add elements to <head> such

         * as styles, scripts, and meta tags.

         */

    wp_head();
    //Socket_Script_info();
    ?>

    <?php
if (!isset($_COOKIE['shipping_protection'])) {
    // Set the 'shipping_protection' cookie
    $cookie_value = '1'; // Replace with the desired value
    setcookie('shipping_protection', $cookie_value, time() + 7*24*3600, '/'); // Adjust expiration time as needed
    
}
    if (WP_ENV  == 'production') {

        if (isset($_GET['utm_campaign']) && isset($_GET['utm_medium'])) {

    ?>

            <script>
                jQuery(document).ready(function() {

                    current_url = window.location.href;

                    if (current_url.includes("#addshoppers___utm_enable")) {

                        new_url = current_url.replace("#", "&");

                        window.location.href = new_url;

                    }

                });
            </script>

        <?php

        }

        ?>

        <!-- Global site tag (gtag.js) - Google Ads: 991526735 

        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-991526735"></script>

        <script>

            window.dataLayer = window.dataLayer || [];



            function gtag() {

                dataLayer.push(arguments);

            }

            gtag('js', new Date());



            gtag('config', 'AW-991526735');

        </script>
-->


        <script type="text/javascript">
            var AddShoppersWidgetOptions = {

                'loadCss': false,

                'pushResponse': false

            };

            (! function() {

                var t = document.createElement("script");

                t.type = "text/javascript",

                    t.async = !0,

                    t.id = "AddShoppers",

                    t.src = "https://shop.pe/widget/widget_async.js#5c617c03bbddbd44eae72714",

                    document.getElementsByTagName("head")[0].appendChild(t)

            }());
        </script>

    <?php } ?>

    <!-- slick slider -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css" type="text/css" media="screen" />



    <!-- Taboola Pixel Code -->
    <!-- <script type='text/javascript'>
        window._tfa = window._tfa || [];
        window._tfa.push({
            notify: 'event',
            name: 'page_view',
            id: 1284622
        });
        ! function(t, f, a, x) {
            if (!document.getElementById(x)) {
                t.async = 1;
                t.src = a;
                t.id = x;
                f.parentNode.insertBefore(t, f);
            }
        }(document.createElement('script'),
            document.getElementsByTagName('script')[0],
            '//cdn.taboola.com/libtrc/unip/1284622/tfa.js',
            'tb_tfa_script');
    </script> -->
    <!-- End of Taboola Pixel Code -->
<!-- 
    <script data-obct type="text/javascript">
        /** DO NOT MODIFY THIS CODE**/ ! function(_window, _document) {
            var OB_ADV_ID = '007419e794dddab068f023992cb83006d9';
            if (_window.obApi) {
                var toArray = function(object) {
                    return Object.prototype.toStri
                    ng.call(object) === '[object Array]' ? object : [object];
                };
                _window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));
                return;
            }
            var api = _window.obApi = function() {
                api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);
            };
            api.version = '1.1';
            api.loaded = true;
            api.marketerId = OB_ADV_ID;
            api.queue = [];
            var tag = _document.createElement('script');
            tag.async = true;
            tag.src = '//amplify.outbrain.com/cp/obtp.js';
            tag.type = 'text/javascript';
            var script = _document.getElementsByTagName('script')[0];
            script.parentNode.insertBefore(tag, script);
        }(window, document);
        obApi('track', 'PAGE_VIEW');
    </script> -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/smile-brilliant-styles.css?ver=1.2.3565" type="text/css" media="screen" />

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/custom-styles.css?ver=1.128" type="text/css" media="screen" />

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/media-query.css?ver=1.2.3268821" type="text/css" media="screen" />

    <style>
    

    @media screen and (min-width: 991px) {
        span.sbr-logo-round{
            width:100%;
            min-width: 50px;
            
        } 
    }


        span.product-selection-price-text del {

            position: relative;

            text-decoration: none
        }
        .insurance-float-btn {
            background-color: #f8a18a !important;
        }


        span.product-selection-price-text del:before {

            content: "";

            /* position: relative; */

            position: absolute;

            /* width: 100px; */

            height: 2px;

            background: #565759;

            top: 22px;

            margin-left: auto;

            margin-right: auto;

            left: -13px;

            right: 0;

        }



        span.product-selection-price-text del bdi {

            color: #88898c;

            margin-right: 7px;

            font-size: 24px;

        }



        span.product-selection-price-text ins {

            text-decoration: none;

        }



        span.product-selection-price-text ins bdi {

            color: #565759;

            font-size: 26px;

            margin-left: 7px;

            font-weight: 400;



        }



        .avg-price {

            font-size: 13px;

            letter-spacing: .08em;

        }



        span.woocommerce-Price-currencySymbol {

            /* font-size: 16px; */

        }



        span.product-selection-price-text ins span.woocommerce-Price-currencySymbol {

            color: #565759;

        }



        .product-night-guards span.product-selection-price-text del:before,

        .product-sensitive-teeth-gel span.product-selection-price-text del:before,

        .product-sensitive-teeth-gel span.product-selection-price-text del:before,

        .body-plaque-highlighter span.product-selection-price-text del:before,

        .body-plaque-highlighter-kids span.product-selection-price-text del:before,

        .product-sensitive-teeth-gel span.product-selection-price-text del:before,

        .product-electric-toothbrush span.product-selection-price-text del:before,

        .product-toothbrush-heads span.product-selection-price-text del:before,

        .product-sensitive-teeth-gel span.product-selection-price-text del:before,

        .product-teeth-whitening-gel span.product-selection-price-text del:before,

        .product-water-flosser span.product-selection-price-text del:before,

        .sbrCariproUltrasonicCleaner span.product-selection-price-text del:before {

            top: 37px;

        }



        .product-electric-toothbrush span.product-selection-price-text del:before {

            top: 33px;

        }



        .wc-item-meta {

            display: none;

        }

        .geha-memeber-button {
            border-radius: 10px 10px 0 0;
        }
        /* .hidden-all-mbt{ display: none !important;} */

        /* for fixing home page logoes slick jerking */        
       .home  .home-section-two-start-logo .logoes-strip-mbt{ opacity: 0;}
       .home  .home-section-two-start-logo .logoes-strip-mbt.slick-initialized{ opacity: 1;}        

        @media only screen and (min-width: 768px) {
            .adjust-flossing-image-women .medium-8 .caption-style1{ 
                margin: 0;
                position: absolute;
            }
            .adjust-flossing-image-women {
                overflow: hidden;
                display: block;
                position: relative;
            }
        }  

        .elementor-754127 .elementor-element.elementor-element-5d0c622e .wfacp_mini_cart_start_h .woocommerce-info{
            background: #fff;
            padding: 0;  
        }
        .elementor-754127 .elementor-element.elementor-element-5d0c622e .wfacp_mini_cart_start_h .wfacp-coupon-section .wfacp-coupon-page .wfacp_main_showcoupon{
            margin-left: 0px;    text-decoration: none;
        }
        @media only screen and (max-width: 1500px) {
            .adjust-flossing-image-women .medium-8 .caption-style1{
                max-width: 699px !important; 
            }
        }
        @media only screen and (max-width: 1120px) {
            .adjust-flossing-image-women .medium-8 .caption-style1{
                        max-width: 420px !important;
            }

            .postid-856651.body-dental-floss-picks .right_side_image {
                    padding-top: 0px !important;
                    padding-bottom: 30px !important;
                }
        }
        @media only screen and (max-width: 767px) {

            body #wfacp-e-form .wfacp_form_cart .wfacp_woocommerce_form_coupon .wfacp-coupon-section .woocommerce-info, body #wfacp-e-form .wfacp_form_cart .wfacp_woocommerce_form_coupon .wfacp-coupon-section .woocommerce-info .wfacp_showcoupon{
                background: none;
            }
            body:not(.wfacpef_page) #wfacp-e-form a:not(.button-social-login):not(.wfob_read_more_link) {
                color: #5899d2;
            }



            .adjust-flossing-image-women .medium-8 .caption-style1{
                display: none !important;
            }

            span.product-selection-price-text del:before,

            .body-plaque-highlighter span.product-selection-price-text del:before,

            .product-electric-toothbrush span.product-selection-price-text del:before {

                width: 100px;

                top: 32px;

            }



            .product-electric-toothbrush span.product-selection-price-text del:before {

                top: 27px;

            }



            .product-night-guards span.product-selection-price-text del:before {

                top: 31px;

            }



            .postid-427572 span.product-selection-price-text del:before {

                width: auto;

                left: -6px;

            }

            /* for fixing home page logoes slick jerking */
           .home  .home-section-two-start-logo .logoes-strip-mbt{max-height:40px ;}


        }
    </style>

    <script>
        jQuery(document).ready(function() {

            jQuery(function() {

                var loc = window.location.href; // returns the full URL

                if (/teeth-whitening-trays/.test(loc)) {

                    jQuery('body').addClass('js-product-teeth-whitening-trays');

                    jQuery('html').addClass('htmlTagjsProductTeethWhiteningTrays');

                }

                if (/electric-toothbrush/.test(loc)) {

                    jQuery('body').addClass('js-product-electric-toothbrush');

                }

                if (/toothbrush-heads/.test(loc)) {

                    jQuery('body').addClass('js-product-toothbrush-heads');

                }

                if (/night-guards/.test(loc)) {

                    jQuery('body').addClass('js-product-night-guards');

                }

                if (/water-flosser/.test(loc)) {

                    jQuery('body').addClass('js-product-water-flosser');

                }



                if (/dental-probiotics-kids/.test(loc)) {

                    // jQuery('body').addClass('body-plaque-highlighter-kids');

                    // jQuery('body').addClass('body-plaque-highlighter');        



                }







            });







        });



        setTimeout(function() {



            // remove all .active classes when clicked anywhere

            hide = true;

            $('body').on("click", function() {

                setTimeout(function() {

                    if (hide)

                        $('.dropdown.clearfix.drop-down-home-nav').removeClass('active');

                    hide = true;

                }, 50);

            });



            // add and remove .active

            $('body').on('click', '.dropdown.clearfix.drop-down-home-nav', function() {



                var self = $(this);



                if (self.hasClass('active')) {

                    setTimeout(function() {

                        $('.dropdown.clearfix.drop-down-home-nav').removeClass('active');

                        return false;

                    }, 50);

                }



                $('.dropdown.clearfix.drop-down-home-nav').removeClass('active');



                self.toggleClass('active');

                hide = false;

            });

        }, 1500);





        // Friend buy integrtion

        // window["friendbuyAPI"] = friendbuyAPI = window["friendbuyAPI"] || [];



        // registers your merchant using your merchant ID found in the

        // retailer app https://retailer.friendbuy.io/settings/general

        // friendbuyAPI.merchantId = "e70138d0-7837-4f67-9128-078c0f87d485";

        // friendbuyAPI.push(["merchant", friendbuyAPI.merchantId]);



        // load the merchant SDK and your campaigns

        // (function(f, r, n, d, b, u, y) {

        //     while ((u = n.shift())) {

        //         (b = f.createElement(r)), (y = f.getElementsByTagName(r)[0]);

        //         b.async = 1;

        //         b.src = u;

        //         y.parentNode.insertBefore(b, y);

        //     }

        // })(document, "script", [

        //     "https://static.fbot.me/friendbuy.js",

        //     "https://campaign.fbot.me/e70138d0-7837-4f67-9128-078c0f87d485/campaigns.js",

        // ]);
    </script>





    <!-- End of smilebrilliant Zendesk Widget script -->

</head>



<body <?php body_class(); ?>>


<div class="landscape-warning">
    <button id="close-warning-landsacpe" class="close-warning" style="display: none;">×</button>
    <div class="landscape-inner-warning-message">
      <p class="font-mont" style="margin: 0;">Please rotate your device to portrait mode for optimum user experience.</p>
    </div>
  </div>


    <?php
    global $shineFlag;
    global $uccFlag;
    $gehaFlag = false;
    $uccFlag = false;
    $shineFlag = false;
    $sweatFlag = false;
    $onedentalFlag = false;
    $benefitFlag = false;
    $perkspotFlag = false;
    $abenityFlag = false;
    $goodrxFlag = false;
    $teledentistsFlag=false;
    $dentistFlag= false;
    $dentistPatientFlag= false;

    $insurance_lander = false;
    if (is_user_logged_in()) {
        if (get_user_meta(get_current_user_id(), 'geha_user', true) == 'yes') {
            $gehaFlag = true;
        }
        if (get_user_meta(get_current_user_id(), 'is_shine_user', true) == '1') {
            $shineFlag = true;
        }
        if (get_user_meta(get_current_user_id(), 'is_ucc_user', true) == '1') {
            $uccFlag = true;
        }
        if (get_user_meta(get_current_user_id(), 'access_code', true) != '') {
            $current_user = wp_get_current_user();
            $username = $current_user->user_login;
            $dentistFlag = true;
        }
       
        if (get_user_meta(get_current_user_id(), 'insurance_lander', true)) {
            $insurance_lander = true;
        }
    }

    if (isset($_COOKIE['geha_user']) && $_COOKIE['geha_user'] == 'yes') {
        $gehaFlag = true;
    }
    if (isset($_COOKIE['shine_user']) && $_COOKIE['shine_user'] != '') {
        $shineFlag = true;
    }
    if (isset($_COOKIE['ucc_user']) && $_COOKIE['ucc_user'] != '') {
        $uccFlag = true;
    }
    if (isset($_COOKIE['sweatcoin']) && $_COOKIE['sweatcoin'] == 'yes') {
        $sweatFlag = true;
    }
    if (isset($_COOKIE['benefithub']) && $_COOKIE['benefithub'] == 'yes') {
        $benefitFlag = true;
    }
    if (isset($_COOKIE['perkspot']) && $_COOKIE['perkspot'] == 'yes') {
        $perkspotFlag = true;
    }
    if (isset($_COOKIE['abenity']) && $_COOKIE['abenity'] == 'yes') {
        $abenityFlag = true;
    }
    if (isset($_COOKIE['goodrx']) && $_COOKIE['goodrx'] == 'yes') {
        $goodrxFlag = true;
    }
    if (isset($_COOKIE['teledentists']) && $_COOKIE['teledentists'] == 'yes') {
        $teledentistsFlag = true;
    }
    if (isset($_COOKIE['1dental']) && $_COOKIE['1dental'] == 'yes') {
        $onedentalFlag = true;
    }
    if (isset($_COOKIE['access_code']) && $_COOKIE['access_code'] != '') {
        $dentistPatientFlag = true;
        // echo 'dentist access';
        // die();
        //$dentist_url = 
    }
    if (isset($_SESSION['geha_user']) && $_SESSION['geha_user'] == 'yes') {
        $gehaFlag = true;
    }
    if (isset($_SESSION['insurance_lander']) && $_SESSION['insurance_lander'] == 'yes') {
        $insurance_lander = true;
    }
    ?>

    
       <?php if($dentistFlag){ ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button">
                    <a href="<?php echo home_url(); ?>/dentist/<? echo $username;?>">
                    Dentist Access
                    </a>
                </div>

        </div>
        <?php }  
        else if($dentistPatientFlag){ ?>
            <div class="floting-geha-button">
                    <div class="geha-memeber-button">
                        <a href="<?php echo home_url(); ?>/dentist/<?php echo $_COOKIE['dentist_slug'];?>">
                            Dentist Discounts
                        </a>
                    </div>
    
            </div>
            <?php }
             else if($shineFlag){ ?>
                <div  onclick="window.location.href='<?php echo home_url(); ?>/shine-members';" class="floting-geha-button shine-member-floating-button" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-discount-tab-button.png);" >
                        <div class="geha-memeber-button">
                            <a href="<?php echo home_url(); ?>/shine-members">
                              
                            </a>
                        </div>
        
                </div>
                <?php }
                  else if($uccFlag){ ?>
                    <div  onclick="window.location.href='<?php echo home_url(); ?>/ucc-members';" class="floting-geha-button ucc-member-floating-button" >
                            <div class="geha-memeber-button">
                                <a href="<?php echo home_url(); ?>/ucc-members">
                                Ucc Discounts
                                </a>
                            </div>
            
                    </div>
                    <?php }
            else if($gehaFlag){ ?>
                <div class="floting-geha-button homegeha">
                        <div class="geha-memeber-button">
                            <a href="<?php echo home_url(); ?>/geha">
                                GEHA Members
                            </a>
                        </div>
        
                </div>
                <?php }
        else if($sweatFlag){
            ?>
            <div class="floting-geha-button">
                    <div class="geha-memeber-button">
                        <a href="<?php echo home_url(); ?>/sweatcoin">
                        Sweatcoin Members
                        </a>
                    </div>
    
            </div>
            <?php
            
        } else if($benefitFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button" >
                    <a href="<?php echo home_url(); ?>/benefit-hub">
                    Benefit hub Members
                    </a>
                </div>

        </div>
        <?php

        }
        else if($perkspotFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button" style="background: #0a4b6b;">
                    <a href="<?php echo home_url(); ?>/perkspot">
                    Perkspot Members
                    </a>
                </div>

        </div>
        <?php

        }
        else if($goodrxFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button" style="background: #0a4b6b;">
                    <a href="<?php echo home_url(); ?>/goodrx">
                    GoodRx Members
                    </a>
                </div>

</div>
        <?php

        }
        else if($teledentistsFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button" style="background: #0a4b6b;">
                    <a href="<?php echo home_url(); ?>/teledentists">
                    Tele Dentists Members
                    </a>
                </div>

        </div>
        <?php

        }
        else if($abenityFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button" style="background: #0a4b6b;">
                    <a href="<?php echo home_url(); ?>/abenity">
                    Abenity Members
                    </a>
                </div>

        </div>
        <?php

        }
        else if($onedentalFlag) {
            ?>
        <div class="floting-geha-button">
                <div class="geha-memeber-button">
                    <a href="<?php echo home_url(); ?>/one-dental">
                    One dental Members
                    </a>
                </div>

        </div>
        <?php

        }

       // if(!$gehaFlag){ ?>
           <style>
            .home .homegeha{
                display:none;
            }
           </style>
            <?php // }
        ?>




    <?php wp_body_open(); ?>

    <?php do_action('thb_before_wrapper'); ?>

    <!-- Start Wrapper -->

    <div id="wrapper" class="thb-page-transition-<?php echo esc_attr(ot_get_option('page_transition', 'on')); ?>">



        <!-- Start Sub-Header -->

        <?php

        if (ot_get_option('subheader', 'off') === 'on') {

            get_template_part('inc/templates/header/subheader-' . ot_get_option('subheader_style', 'style1'));
        }

        ?>

        <!-- End Sub-Header -->



        <?php get_template_part('inc/templates/header/' . ot_get_option('header_style', 'style1')); ?>

        <?php //echo do_shortcode('[trustindex no-registration=google]');  
if (!isset($_COOKIE['shipping_protection'])) {
    // Set the 'shipping_protection' cookie
    $cookie_value = '1'; // Replace with the desired value
    setcookie('shipping_protection', $cookie_value, time() + 7*24*3600, '/'); // Adjust expiration time as needed
    
}
        ?>

        <div role="main">
            <?php
            $current_url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            if (is_user_logged_in() && strpos($current_url, "support") == false && strpos($current_url, "my-account") !== false) { ?>
                <div id="chat-circle">
                    <a href="/my-account/support/?active-tab=chat">
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chat_talk.svg" />
                    </a>
                    <div id="totalunreadmessages"></div>
                <?php } ?>

                </div>
                <div class="header-spacer"></div>