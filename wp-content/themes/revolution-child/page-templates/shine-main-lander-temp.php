<?php
/*
Template Name: Shine Lander Template
 */

get_header();
$referral_id = isset($_GET['ref']) ? $_GET['ref'] : 'user';

if (is_page('shineplans') && !isset($_COOKIE['shineaffiliate'])) {
    setcookie('shineaffiliate', $referral_id, time() + (86400 * 365 * 10), "/"); // 86400 = 1 day, 365 * 10 = 10 years
}

if (is_page('shine') && isset($_COOKIE['shineaffiliate'])) {
    wp_redirect(home_url('/shineplans'));
    exit;
}
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/css/shine-system.css?ver=1681"
    type="text/css" media="screen" />

<div class="product-shine-lander">
    <!-- section-top-banner -->
    <section class="section section-top-banner">
        <div class="container">
            <div class="row-flex flex-count-one justify-content-center">
                <div class="sectionLft">
                    <div class="shine-banner-wrap">
                        <div class="circle-banner-home">
                            <img class="img-fluid"
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-smile.png" />
                        </div>
                        <div class="aetna-logo-wrap text-center" >
                            <div class="enhanced-width open-sans italic">
                            featuring 
                            </div>
                            <div class="aetna-logo">
                                <img class="img-fluid"
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/aetna-logo.png"
                                    alt="aetna" />
                            </div>
                            <div class="dental-access">
                                <img class="img-fluid"
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/dental-access-text-r.png"
                                    alt="Dental Access" />
                            </div>
                            <div class="hfa-fsa">
                                <img class="img-fluid"
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/HSA-Logo.png"
                                    alt="HSA" />
                                <img class="img-fluid"
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/FSA-Logo.png"
                                    alt="FSA" />
                            </div>
                            <div class="eligible-text">
                                ELIGIBLE
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sectionRgt" >
                    <h1>Dental <br>
                        <span style="color:#25d4cd;">Savings Plan</span>
                    </h1>
                    <div class="subheadinhg shine-underline  underline  underline--2 ">
                        Dental <span style="color:#25d4cd;">+</span>Vision <span style="color:#25d4cd;">+</span>Rx
                        Prescriptions
                    </div>
                    <p class="home-section-description-text" >
                    An easy-to-use membership program that will save you up to 70% on oral care products and 15 - 50%* off in most instances, when visiting a participating dentist.
                        
                    </p>

                    <div class="button-wrap ">
                        <a href="javascript:;" onclick="$('html, body').animate({scrollTop: $('#join-shine').offset().top - 90}, 1500); return false;" class="btn btn-yellow">Join Shine</a>
                    </div>

                    <div class="how-work-link">
                        <a href="javascript:;" onclick="$('html, body').animate({scrollTop: $('#how-it-works').offset().top - 90}, 1500); return false;">
                            How it Works
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Ends section-top-banner -->

    <!-- section-our-members -->
    <section class="section section-our-members">
        <div class="container">

            <div class="customer-brand-slide align-items-center ">
                <div class="logo health-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>


                <div class="logo health-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>

            </div>
        </div>

    </section>
    <div class="colorStrip row-flex">
        <div class="stripe" style="background:#002244;height:12px; width:25%;"></div>
        <div class="stripe" style="background:#00bbb4;height:12px; width:25%;"></div>
        <div class="stripe" style="background:#4597cb;height:12px; width:25%;"></div>
        <div class="stripe" style="background:#ecf5f9;height:12px; width:25%;"></div>
    </div>

    <!--Ends section-our-members -->

    <!-- section-wellness-saving-program -->
    <section class="section section-wellness-saving-program">
        <div class="container">
            <div class="row-flex justify-content-between">
                <div class="wellness-content-section">
                    <div class="whats-shine font-mont uppercase" data-aos="slide-up">
                        What is sh<span style="color:#f0c23a" class="yellow-text">!</span>ne?
                    </div>
                    <h2 class="font-mont weight-700" data-aos="slide-up">
                        <span style="color: #0eb4ba;" class="italic-mobile">It’s NOT <br class="desktop-hidden">
                            insurance:</span><br class="desktop-hidden">
                        It's a wellness<br class="desktop-hidden"> savings program to <br class="desktop-hidden">
                        <span class="shine-underline  underline  underline--3 ">reduce your oral health<br
                                class="desktop-hidden"> costs</span>. 
                                <!-- <span class="shine-underline  underline  underline--3 by-upToText">by up to 70%.*</span> -->
                        </>
                    </h2>
                    <div class="help-vision-text" data-aos="slide-up">
                        ...we also help with <span class="smile-graphic-below">vision</span> & <br
                            class="hidden-desktop-standard">
                        prescription drugs.
                    </div>
                    <p data-aos="slide-up">
                        Nope, your fees won’t go up each year like other providers either.
                    </p>
                    <div class="button-wrap" data-aos="slide-up">
                        <a href="javascript:;" class="btn btn-yellow" onclick="$('html, body').animate({scrollTop: $('#join-shine').offset().top - 90}, 1500); return false;">Join Shine</a>
                    </div>

                    <div class="find-participating-dentist row-flex justify-content-center hidden-desktop-standard " id="section3">
                        <div class="find-row row-flex align-items-center cursor_pointer openPop" >
                        <!-- onclick="performSearch3()" -->
                            <button type="submit" class="btn search-submit btn-two" >
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/search-icon.svg"
                                    alt="" />
                            </button>
                            <input type="text" class="zipNameGet disabled whiteBackground" placeholder="find a provider"  disabled  style="min-width: 180px;max-width: 180px;"/>

                            <dv class="hideElements" style="display: none;">
                                <div class="input-group select-option">
                                    <select id="category" class="category"><option value="" selected="">All Categories</option><option value="Optical">Optical</option><option value="Pharmacy">Vision Center</option><option selected value="Dentist">Dentist</option></select>
                                </div>

                                <div class="input-group select-option">
                                    <select  id="distance" class="distance"><option value="1">1 Mile</option><option value="3">3 Miles</option><option selected value="5">5 Miles</option><option value="10" selected="">10 Miles</option><option value="50">50 Miles</option></select>
                                </div>

                            </dv>

                        </div>


                    </div>
                </div>
                <div class="wellness-content-section-aside">
                    <div class="happy-family-pciture">
                        <img class="desktop_image" data-aos="fade-up" data-aos-delay="100"
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-happy-family.png"
                            alt="" />

                        <img class="mobile_image"
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-happy-family-mobile-v2-v.png"
                            alt="" />

                    </div>
                    <div class="find-participating-dentist row-flex justify-content-center hidden-mobile-standard" id="section4">

                        <div class="find-row row-flex align-items-center cursor_pointer openPop" data-aos="slide-up">
                        <!-- onclick="performSearch4()" -->
                            <button type="submit" class="btn search-submit btn-one"  >
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/search-icon.svg"
                                    alt="" />
                            </button>
                            <input type="text" class="zipNameGet disabled whiteBackground" placeholder="find a provider" disabled />

                            <dv class="hideElements" style="display: none;">
                                <div class="input-group select-option">
                                    <select id="category" class="category"><option value="" selected="">All Categories</option><option value="Optical">Vision Center</option><option value="Pharmacy">Pharmacy</option><option selected value="Dentist">Dentist</option></select>
                                </div>

                                <div class="input-group select-option">
                                    <select  id="distance" class="distance"><option value="1">1 Mile</option><option value="3">3 Miles</option><option selected value="5">5 Miles</option><option value="10" selected="">10 Miles</option><option value="50">50 Miles</option></select>
                                </div>

                            </dv>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Ends section-wellness-saving-program -->


    <!-- Common savings shine -->
    <section class="section section-common-saving-shine">
        <div class="container">

            <h3 class="weight-800 font-mont" data-aos="slide-up">Common savings <span class="styleOne-1">with SH<span style="color:#f0c23a"
                        class="yellow-text">!</span>NE</span></h3>
            <div class="headingSubHead" data-aos="slide-up">Dentist Visits, Oral Care Products, Vision Care. Rx <br
                    class="hidden-desktop-standard"> Prescription Drugs, and
                more!</div>

            <div class="shine-offers-wrapper  mobile-slider-activate">

                <?php get_template_part('inc/templates/shine-saving-plans/shine-common-savings-with-shine');?>

            </div>

            <div class="button-wrap row-flex justify-content-center" data-aos="slide-up" >
                <a href="javascript:;" class="btn btn-yellow" onclick="$('html, body').animate({scrollTop: $('#join-shine').offset().top - 90}, 1500); return false;">Join Shine</a>
            </div>
            <div class="how-work-link" data-aos="slide-up" data-aos-delay="50">
                <a href="javascript:;" id="openModal1">
                    See Complete Savings List
                </a>


            </div>
            <div class="section-displaimer" data-aos-delay="70">
                <p class="open-sans italic" class="openDisclaimerText"><span class="textdes">*Click to view disclaimer</span></p>

                <!-- <p class="open-sans italic">*These are real examples. However, your savings may vary based on procedure,
                    provider and geographic location.</p> -->
            </div>


        </div>



    </section>
    <!--Ends section-common-saving-shine -->


    <!-- section section-register-instantly-with-shine -->
    <section class="section section-register-instantly-with-shine" id="how-it-works">
        <div class="container">
            <div class="row-flex justify-content-between">
                <div class="section-register-lft">

                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-register-method-v2-r.png"
                        alt="" />
                </div>

                <div class="section-register-rgt">
                    <div class="where-can-i-use-it-text hidden-mobile" data-aos="slide-up" data-aos-delay="0">
                        WHERE CAN I USE IT?
                    </div>
                    <div class="where-can-i-use-it-text hidden-desktop" >
                        WHERE CAN I USE IT?
                    </div>
                    <h4 class="font-mont" data-aos="slide-up" data-aos-delay="50">Register online. </h4>
                    <h5 class="font-mont" data-aos="slide-up" data-aos-delay="70">Activates instantly.</h5>
                    <div class="cancel-as-want" data-aos="slide-up" data-aos-delay="80">Cancel whenever you want.</div>
                    <div class="find-provider-text" data-aos="slide-up" data-aos-delay="90">Find a provider. Show your membership. Save Money.</div>


                    <div class="faqs-section-sec">
                        <div class="accordion-faq-section">
                            <ul class="accordion-list">
                                <li data-aos="slide-up" data-aos-delay="0">
                                    <h3 class="d-flex"><span class="digits-number">
                                            <img class="img-fluid"
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/check-icon-green.svg"
                                                alt="" />
                                        </span>
                                        <div class="text--k">262,000+ Providers practice locations
                                            <div class="small-text">
                                                Dental procedures, orthodontics, x-rays, cleanings and more.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <div class="accordion-two-content">
                                                <p>Smile Brilliant has partnered with the Aetna Dental Access® Network to bring more than 262,000+ providers. Our members have convenient access to dentist office discounts throughout the US.</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li data-aos="slide-up" data-aos-delay="50">
                                    <h3 class="d-flex"><span class="digits-number">
                                            <img class="img-fluid"
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/check-icon-green.svg"
                                                alt="" />
                                        </span>
                                        <div class="text--k">Smile Brilliant and its partner websites
                                            <div class="small-text">
                                                Teeth whitening, night guards, oral care, skincare and wellness
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <div class="accordion-two-content">
                                                <p>Shine members receive up to 70% off our complete line of oral care products available on the Smile Brilliant website. Additionally, we’ve partnered with some of the leading personal care brands to bring a host of discounts from top brands to our members</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li data-aos="slide-up" data-aos-delay="100">
                                    <h3 class="d-flex"><span class="digits-number">
                                            <img class="img-fluid"
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/check-icon-green.svg"
                                                alt="" />
                                        </span>
                                        <div class="text--k">65,000+ Major chain and local pharmacies
                                            <div class="small-text">
                                                Levothyroxine, Tretinoin, Estradiol, Albuterol & hundreds more.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <div class="accordion-two-content">
                                                <p>Over 65,000+ pharmacies are participating in offering substantial savings on supplements and prescription medication to Shine members.</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li data-aos="slide-up" data-aos-delay="150">
                                    <h3 class="d-flex"><span class="digits-number">
                                            <img class="img-fluid"
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/check-icon-green.svg"
                                                alt="" />
                                        </span>
                                        <div class="text--k">20,000+ Vision centers and retailers
                                            <div class="small-text">
                                                Contacts, eye exams, eyewear, and lasik.
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="answer">
                                        <div class="answer-content">
                                            <div class="accordion-two-content">
                                                <p>Stop by any of the 20,000+ vision centers across the US, show your Shine membership, and receive instant savings on everything from contact lenses to eyewear and even Lasik.</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>



                            </ul>
                        </div>


                    </div>



                    <div class="button-wrap" data-aos="slide-up" data-aos-delay="0">
                        <a href="javascript:;" class="btn btn-yellow" onclick="$('html, body').animate({scrollTop: $('#join-shine').offset().top - 90}, 1500); return false;">Join Shine</a>
                    </div>
                    <div class="find-participating-dentist" data-aos="slide-up" data-aos-delay="40">
                        <div class="find-row row-flex cursor_pointer openPop"  id="section1" >
                        <!-- onclick="performSearch1()"  -->
                            <button type="submit" class="btn search-submit btn-three" >
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/search-icon.svg"
                                    alt="" />
                            </button>
                            <input type="text" class="zipNameGet disabled whiteBackground" placeholder="find a provider" disabled/>

                            <dv class="hideElements" style="display: none;">
                                <div class="input-group select-option">
                                    <select id="category" class="category"><option value="" selected="">All Categories</option><option value="Optical">Vision Center</option><option value="Pharmacy">Pharmacy</option><option selected value="Dentist">Dentist</option></select>
                                </div>

                                <div class="input-group select-option">
                                    <select  id="distance" class="distance"><option value="1">1 Mile</option><option value="3">3 Miles</option><option selected value="5">5 Miles</option><option value="10" selected="">10 Miles</option><option value="50">50 Miles</option></select>
                                </div>

                            </dv>



                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- Ends section section-register-instantly-with-shine -->



    <!-- section our-partners -->
    <section class="section our-partners " style="background: #f5e2aa;">
        <div class="container">
            <!-- row-flex align-items-center column-gatter-30 -->
            <div class=" partnersSlide ">
                <div class="logo-partner">
                    <img class="img-fluid albertsons-logo"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/albertsons.png"
                        alt="albertsons" />
                </div>
                <div class="logo-partner cvs-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/cvs.png"
                        alt="cvs" />
                </div>
                <div class="logo-partner walmart-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/walmart.png"
                        alt="walmart" />
                </div>
                <div class="logo-partner walgreens-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/walgreens.png"
                        alt="walgreens" />
                </div>
                <div class="logo-partner costco-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/costco.png"
                        alt="costco" />
                </div>
                <div class="logo-partner kroger-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/kroger.png"
                        alt="kroger" />
                </div>
                <div class="logo-partner publix-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/publix.png"
                        alt="publix" />
                </div>
                <div class="logo-partner rite-aid-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/rite-aid.png"
                        alt="Rite Aid" />
                </div>
                <div class="logo-partner target-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/target.png"
                        alt="target" />
                </div>


                <div class="logo-partner america-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/america-best.png"
                        alt="target" />
                </div>
                <div class="logo-partner giant-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/giant-eagle.png"
                        alt="target" />
                </div>

                <div class="logo-partner health-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/health-mart.png"
                        alt="target" />
                </div>

                <div class="logo-partner hyvee-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/hyvee.png"
                        alt="target" />
                </div>

                <div class="logo-partner lenscrafters-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/lenscrafters.png"
                        alt="target" />
                </div>

                <div class="logo-partner meijer-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/meijer.png"
                        alt="target" />
                </div>

                <div class="logo-partner pearle-vision-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/pearle-vision.png"
                        alt="target" />
                </div>

                <div class="logo-partner qualsight-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/qualsight.png"
                        alt="target" />
                </div>



                <div class="logo-partner safeway-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/safeway.png"
                        alt="target" />
                </div>

                <div class="logo-partner sams-club-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/sams-club.png"
                        alt="target" />
                </div>

                <div class="logo-partner visionworks-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/visionworks.png"
                        alt="target" />
                </div>

                <div class="logo-partner vons-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/partner-logo/vons.png"
                        alt="target" />
                </div>





            </div>
        </div>

    </section>
    <!-- Ends section our-partners -->

    <!-- section section savings plans -->
    <section class="section section-savings-plan" id="join-shine">
        <div class="container containerRowDental">
            <h6 class="font-mont" data-aos="slide-up" data-aos-delay="0">
                DENTAL SAVINGS PLAN
            </h6>
            <div class="dental-savings-subheading">
                <div class="shine-underline  underline  underline--3" data-aos="slide-up" data-aos-delay="10">
                    SIGN-UP OPTIONS
                </div>
            </div>

            <div class="section-description">
                <p class="open-sans" data-aos="slide-up" data-aos-delay="30"><span class="weight-600">Individuals. Couples. Family Savings Plans Available</span><br>
                    <span class="italic hidden-mobile-standard">Activates immediately. No usage limits. No rate hike
                        guarantee.</span>
                    <span class="italic hidden-desktop-standard">Use immediately. No limits. No rate hike
                        guarantee.</span>

                </p>
            </div>

            <?php
if (is_page('shineplans')) {
    echo do_shortcode('[shine-memberships type="shine-membership" affiliate_version="yes"]');
} else {
    echo do_shortcode('[shine-memberships type="shine-membership"]');
}

?>

        </div>
    </section>
    <!-- Ends section section savings plans -->

    <section class="section section-shine-faqs">
        <div class="container">
            <div class="section-tp-title font-mont"  data-aos="fade-up" data-aos-delay="0" >
                FREQUENTLY ASKED QUESTIONS.
            </div>
            <h6 class="sec-title-lrge"  data-aos="fade-up" data-aos-delay="30" >
                <span style="color:#0eb4ba" class="mobile-sprate-style">Don’t have dental insurance?<br></span>
                <span style="color:#2d2e2f">Great! Neither do we.</span>
            </h6>
            <div class="sec-detail-info"  data-aos="fade-up" data-aos-delay="60" >
                ...but we have answers to help  both insured AND
                 uninsured people better understand the value and
                convenience of a
                Shine Dental Savings Plan.
            </div>

            <div class="down-arrow text-center" data-aos="fade-up" data-aos-delay="100">
                <a href="javascript:;"   >
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/down-arrow.svg"
                        alt="" style="max-width: 70px;" />
                </a>
            </div>

        </div>



        <div class="faqs-tabs-container" data-aos="fade-up" data-aos-delay="100">

            <div class="container">
                <div class="row-flex tabs-group-container" >
                    <div class="faq-text-lrg" >
                        FAQ
                    </div>
                    <a href="javascript:;" data-att="no-insurance"
                        class="tabs-button active btn-dental-insuran1 activeTab">
                        <span class="style-mobile-2"> I <span style="color:#4acac9 ;">Don’t Have</span></span> Dental
                        Insurance
                    </a>
                    <a href="javascript:;" data-att="have-insurance" class="tabs-button btn-dental-insuran2">
                        <span class="style-mobile-2">I Have</span> Dental Insurance
                    </a>

                    <a href="javascript:;" class="btn-fist-a-dentist openPop" id="openModal2">
                    <!-- data-att="find-dentist"  -->
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/search-icon.svg"
                            alt="" style="max-width: 20px;" /> Find a Provider
                    </a>
                </div>
            </div>

            <div class="faq-tabs-container">
                <div class="container">
                    <div class="tabs-content" id="no-insurance">


                    <div class="faqs-section-sec">
                        <div class="accordion-faq-section">

                                                        <?php
// Arguments for the custom query
$args = array(
    'post_type' => 'ufaq', // Custom post type for FAQs
    'tax_query' => array(
        array(
            'taxonomy' => 'ufaq-category', // Custom taxonomy for FAQ categories
            'field' => 'slug',
            'terms' => array('shine-dont-have-insurance'), // Categories to include
        ),
    ),
    'posts_per_page' => -1, // Number of posts to display (-1 for all)
    'orderby' => 'date', // Order by date
    'order' => 'ASC', // Descending order
);

// Custom query
$faq_query = new WP_Query($args);

// The Loop
if ($faq_query->have_posts()):
    while ($faq_query->have_posts()): $faq_query->the_post();
        // Display the FAQ content
   
        ?>

				                                                            <ul class="accordion-list">
				                                                                <li data-aos="slide-up" data-aos-delay="0">
				                                                                    <h3 class="d-flex">
				                                                                        <div class="text--k"><?php the_title();?>
				                                                                        </div>
				                                                                    </h3>
				                                                                    <div class="answer">
				                                                                        <div class="answer-content">
				                                                                            <div class="accordion-two-content">
                                                                                            <?php echo apply_filters('the_content', get_the_content()); ?>
				                                                                            </div>
				                                                                        </div>
				                                                                    </div>
				                                                                </li>
				                                                            </ul>


				                                                            <?php
    endwhile;
    wp_reset_postdata();
else:
    echo '<p>No FAQs found in the Shine category.</p>';
endif;
?>

                        </div>


                    </div>

                    </div>
                    <div class="tabs-content hidden-all" id="have-insurance">

                    <div class="faqs-section-sec">
                        <div class="accordion-faq-section">

                                                        <?php
// Arguments for the custom query
$args = array(
    'post_type' => 'ufaq', // Custom post type for FAQs
    'tax_query' => array(
        array(
            'taxonomy' => 'ufaq-category', // Custom taxonomy for FAQ categories
            'field' => 'slug',
            'terms' => array('shine-have-insurance'), // Categories to include
        ),
    ),
    'posts_per_page' => -1, // Number of posts to display (-1 for all)
    'orderby' => 'date', // Order by date
    'order' => 'ASC', // Descending order
);

// Custom query
$faq_query = new WP_Query($args);

// The Loop
if ($faq_query->have_posts()):
    while ($faq_query->have_posts()): $faq_query->the_post();
    $pagecontent = get_the_content();
        // Display the FAQ content
        ?>

				                                                            <ul class="accordion-list">
				                                                                <li data-aos="slide-up" data-aos-delay="0">
				                                                                    <h3 class="d-flex">
				                                                                        <div class="text--k"><?php the_title();?>
				                                                                        </div>
				                                                                    </h3>
				                                                                    <div class="answer">
				                                                                        <div class="answer-content">
				                                                                            <div class="accordion-two-content">
                                                                                            <?php if($pagecontent!='') {
                                                                                                        echo $pagecontent;
                                                                                                        } ?>
				                                                                            </div>
				                                                                        </div>
				                                                                    </div>
				                                                                </li>
				                                                            </ul>


				                                                            <?php
    endwhile;
    wp_reset_postdata();
else:
    echo '<p>No FAQs found in the Shine category.</p>';
endif;
?>

                        </div>

                    </div>

                    </div>
                    <div class="tabs-content hidden-all" id="find-dentist">
                </div>
            </div>
        </div>
    </section>
    <!-- Ends section Faq -->


    <section class="partnership-banner-bottom" data-aos="fade-up" data-aos-delay="100">
        <div class="container">
            <div class="row-flex">
                <div class="col-sm-6">
                    <div class="image-circle" data-aos="fade-up" data-aos-delay="300">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo-full.png"
                            alt="" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="content-section">
                        <h5 class="section-heading-partner sea-green-text" data-aos="fade-up" data-aos-delay="50">
                            <span class="weight-800 text-default-one" style="color: #4acac9;">Trusted by dentists & hygienists! </span><span class="weight-600"
                                style="color: #fff;">Shine is the most comprehensive dental savings plan in
                                America.</span>
                        </h5>
                        <p class="text-white" data-aos="fade-up" data-aos-delay="80">                            
                            Shine has a multi-disciplined relationship between Smile Brilliant and over 262,000* available
                            dental practice locations, 20,000+ vision centers, and 65,000+ pharmacies nationwide.                            
                            
                            Our mission is to to bring
                            better wellness care to individuals seeking their best life at affordable prices. With your
                            Shine membership, you are guaranteed a reduced rate on professional services from
                            participating providers as well as exceptional discounts on Smile Brilliant and our partner
                            websites.
                        </p>
                        <p class="text-default-one weight-600" style="color: #4acac9;" data-aos="fade-up" data-aos-delay="90">We're putting our money where your mouth is!
                            If you are not completed satisfied with the products, services, or experiences you receive
                            through your membership, we will provide a full refund (processing fee).</p>
                        <div class="family-img" >
                            <img class=""
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/home/family.webp" />
                        </div>

                        <div class="poweredby-section powered-section-desktop" data-aos="fade-up" data-aos-delay="100">
                            <div class="powerd-by-text ">
                                <span>NO STRINGS ATTACHED.</span>
                            </div>
                        </div>
                        <div class="row-flex justify-content-between align-items-end footer-strings-attached" data-aos="fade-up" data-aos-delay="110">
                            <div class="our-people-promise action-btn">
                                <button onclick="window.open('/about-us', '_blank');"
                                    class="btn btn-primary-teal btn-lg yellow-button">Our People. Our Promise.</button>
                            </div>

                            <div class="gurantee-logo" data-aos="fade-up" data-aos-delay="120">
                                <div class="member-off-parent">
                                    <span class="memberOff-text">Member of</span>
                                </div>
                                <div class="nadp_logo">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/nadp_logo_white_cropped.png"
                                    alt="" style="max-width: 212px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="plan-insurance-displainer">
        <div class="container">
            <p><strong>THIS PLAN IS NOT INSURANCE.</strong> This plan is not a qualified health plan under the Affordable Care Act (ACA). Some services may be covered by a qualified  health plan under the ACA. This plan does not meet the minimum creditable coverage requirements under M.G.L. c. 111M and 956 CMR 5.00. This is not a Medicare prescription drug plan. Discounts on hospital services are not available in Maryland. The plan provides discounts at certain health care providers of medical services. The plan does not make payments directly to the providers of medical services. The plan member must pay for all health care services but will receive a discount from participating providers. The range of discounts will vary depending on the provider type and services provided. The discount plan organization is Gallagher Affinity Insurance Services, Inc., at 2850 W. Golf Road, Rolling Meadows, IL 60008 , 1-888-868-6199. The list of participating providers is at <a href="http://www.smilebrillaint.com/shine-search"><b>www.smilebrillaint.com/shine-search</b></a>. 
                <b>You have the right to cancel this plan within 30 days after the effective date for a full refund, less a nominal processing fee (AR, TN and MD residents will be refunded processing fee).</b> Such refund will be issued within 30 days of request.
                
                <br><br>

            <b>Benefits not available in Alaska, Iowa, Rhode Island, Utah, Vermont and Washington.</b><br><br>
            <b> *Information updated April 2020. While our provider lists are continually updated, provider status can change. We recommend that you confirm the provider you selected participates in the program when scheduling your appointment.</b> </p>
        </div>
    </div>


</div>





        <div id="modal4" class="modal youcanotPurchasePop disclaimermodal">
            <div class="modal-content">
                <span class="close" data-modal="modal4">&times;</span>
                <div class="modal-body">
                       <p>*Actual costs and savings may vary by provider, service and geographic location. We use the average of negotiated fees from participating providers to determine the average costs, as shown on the chart. The select regional average cost represents the average fees for the procedures listed above in Los Angeles, Orlando, Chicago and New York City, as displayed in the cost of care tool as of September 2021.</p>
                </div>
            </div>
        </div>


    <div id="modal3" class="modal youcanotPurchasePop">
            <div class="modal-content">
                <span class="close" data-modal="modal3">&times;</span>
                <div class="modal-body">
                        <h1>You cannot <strong>purchase</strong> more than one <strong>subscription products</strong> in a single order</h1>
                </div>
            </div>
        </div>

<div id="modal2" class="modal">
    <div class="modal-content">
        <span class="close" data-modal="modal2">&times;</span>
        <div class="modal-body find-a-dentist-location-pop">
        <div class="dental-location-search-wrapper">
                            <h6 class="find-location-heading">Find a Provider</h6>
                            <div class="location-search" id="section2">

                                <div class="search-flex optionOne rowDivWrapper">
                                     <div class="input-group select-option addIconforBlance" id="allCat">
                                        <div class="iconForBalnced"></div>
                                        <select id="category" class="category">
                                            <option value="" selected="">All Categories</option>
                                            <option value="Optical">Vision Center</option>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option selected value="Dentist">Dentist</option>
                                        </select>
                                    </div>
                                    <div class="input-group select-option" id="miles">
                                        <select  id="distance" class="distance"><option value="1">1 Mile</option><option value="3">3 Miles</option><option selected value="5">5 Miles</option><option value="10" selected="">10 Miles</option><option value="50">50 Miles</option></select>
                                    </div>
                                </div>

                                <div class="search-flex optionTwo fullMobileVersion">
                                    <div class="input-group">
                                        <div class="generalText"><strong>GENERAL RESULTS</strong><span class="hiddenSmallRes"> (less accurate)</span></div>
                                        <div class="wrapperTo">
                                            <label class="custom-checkbox" for="checkbox1">

                                                <!-- <input class="useCurrentLocation" type="checkbox" id="checkbox1" > -->

                                                <input class="useCurrentLocation" type="radio" id="checkbox1" name="buttons" value="General results">


                                                <div class="checkMarkWrapper">
                                                    <span class="checkmark"></span>
                                                </div>
                                            </label>
                                            <input id="zipNameGet" class="zipNameGet" type="text" placeholder="Search by ZIP Code" required="" value="">
                                        </div>
                                    </div>

                                    <div class=" optionLocation radiobuttonSec wrapperGPS">
                                        <div class="generalText rowTwonn"><strong>GPS RESULTS</strong><span class="hiddenSmallRes"> (most accurate)</span></div>
                                        <label class="custom-checkbox" for="checkbox2">
                                            <div class="wrapperGpsInner">

                                            <input class="useCurrentLocation" type="radio" id="checkbox2" name="buttons" value="GPS Results" onclick="getLocation(this)">

                                            <!-- <input class="useCurrentLocation" type="checkbox" onclick="getLocation(this)"  id="checkbox2"> -->


                                            <div class="checkMarkWrapper">
                                                <span class="checkmark"></span>
                                            </div>
                                                <div class="userLocationWrapper">
                                                    <span class="dotsSelection">
                                                    <img  style="width: 20px;" height="20px" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/icons/pulsing-location-pin.svg" alt="" />
                                                    </span>
                                                        <span class="textShowed"><span class="hiddeMobile">Use my </span>Current location</span>

                                                    </div>
                                                </div>
                                        </label>
                                    </div>


                                </div>
                                <div class="search-flex optionThree">
                                    <div class="buttons-group-set">
                                        <button class="search-button btn-four"  onclick="performSearch2()" id="searchButton">Search</button>
                                    </div>
                                    <div class="buttons-group-set">
                                        <button class="reset-button buttonCt" id="resetButton" type="reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

    </div>
</div>





<!-- listing options  -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <span class="close" data-modal="modal1">&times;</span>


        <div class="popupContentWrapper">
            <h2 class="font-mont popup-heading"><span style="color:#4acac9">Shine</span> Dental & Wellness Savings Plan
            </h2>
            <h4 class="popup-sub-heading">Procedures, pricing, and benefits for each Shine membership level.</h4>

            <div class="popuptabs-wrapper data-tab-shineCompleteTab">
                <div class="tabs tabs-left-row tabsDesktopOnly">

                    <button class="tablink shine-denta-tab-head" data-tab="shineDentalTab">
                        <div class="saving-card-header">
                            <div class="shine-smile-logo rounded-shine-smile">
                                <div class="logo-wrap-pop">
                                    <span class="shine-text">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-text-white.png"
                                            alt="Shine" />
                                    </span>
                                    <div class="shine-smile-symbal">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
                                    </div>
                                </div>

                            </div>
                            <div class="shine-text-wrap">
                                <span class="shine-text heading-clr">SH<span class="yellow-text"
                                        style="color:#f0c23a">!</span>NE</span>
                                <span class="text-wrap-two">Dental</span>
                            </div>
                        </div>

                    </button>
                    <button class="tablink shine-denta-complete-head" data-tab="shineCompleteTab">
                        <div class="saving-card-header">
                            <div class="shine-smile-logo rounded-shine-smile">
                                <div class="logo-wrap-pop">
                                    <span class="shine-text">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-text-white.png"
                                            alt="Shine" />
                                    </span>
                                    <div class="shine-smile-symbal">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
                                    </div>
                                </div>
                            </div>

                            <div class="shine-text-wrap">
                                <span class="shine-text">SH<span class="yellow-text"
                                        style="color:#f0c23a">!</span>NE</span>
                                <span class="text-wrap-two">Complete</span>
                            </div>
                        </div>
                    </button>
                    <button class="tablink shine-perks-tab-head" data-tab="ShinememberPerksTab">
                        <div class="saving-card-header" style="background:#eeeeee">
                            <div class="shine-smile-logo rounded-shine-smile">
                                <div class="logo-wrap-pop">
                                    <span class="shine-text">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-text-white.png"
                                            alt="Shine" />
                                    </span>
                                    <div class="shine-smile-symbal">
                                        <img class="img-fluid"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
                                    </div>
                                </div>
                            </div>
                            <div class="shine-text-wrap">
                                <span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE
                                    Member </span>
                                <span class="text-wrap-two">Perks</span>
                            </div>
                        </div>
                    </button>
                </div>




                <div id="shineDentalTab" class="tabcontent">
                    <div class="shineCompleteWrapperParent shinedental-container">
                            <div class="forMobileBtn tablink ">
                                <a href="#" class="btnShineDental btnjsAttribue" data-attribute="#shineDentalWrap">
                                    <div class="saving-card-header">
                                        <div class="shine-smile-logo rounded-shine-smile">
                                            <div class="logo-wrap-pop">
                                                <span class="shine-text">
                                                <img class="img-fluid"
                                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-1.png"
                                                    alt="Shine" />
                                                </span>

                                            </div>

                                        </div>
                                        <div class="shine-text-wrap">
                                            <span class="shine-text heading-clr">SH<span class="yellow-text"
                                                    style="color:#f0c23a">!</span>NE</span>
                                            <span class="text-wrap-two">Dental</span>
                                        </div>
                                    </div>

                                </a>

                            </div>
                            <div class="formobileWrapper" id="shineDentalWrap">
                                <?php get_template_part('inc/templates/shine-saving-plans/shine-dental');?>
                            </div>

                    </div>
                </div>

                <div id="shineCompleteTab" class="tabcontent">
                    <div class="shineCompleteWrapperParent shineComplete-container">
                    <div class="forMobileBtn tablink ">
                                <a href="#" class="btnShineComplete btnjsAttribue" data-attribute="#shineCompletelWrap">
                                    <div class="saving-card-header">
                                        <div class="shine-smile-logo rounded-shine-smile">
                                            <div class="logo-wrap-pop">
                                                <span class="shine-text">
                                                <img class="img-fluid"
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-2.png"
                alt="Shine" />
                                                </span>

                                            </div>
                                        </div>
                                        <div class="shine-text-wrap">
                                            <span class="shine-text heading-clr">SH<span class="yellow-text"
                                                    style="color:#f0c23a">!</span>NE</span>
                                                    <span class="text-wrap-two">Complete</span>
                                        </div>

                                    </div>
                                 </a>
                            </div>
                            <div class="formobileWrapper" id="shineCompletelWrap">
                                    <?php get_template_part('inc/templates/shine-saving-plans/shine-complete');?>
                            </div>
                    </div>
                </div>

                <div id="ShinememberPerksTab" class="tabcontent">
                    <div class="shineCompleteWrapperParent shineMemberPerks-container">

                            <div class="forMobileBtn tablink ">
                            <a href="#" class="btnShineperks btnjsAttribue" data-attribute="#shinePerksWrap">
                                <div class="saving-card-header">
                                <div class="shine-smile-logo rounded-shine-smile">
                                            <div class="logo-wrap-pop">
                                                <span class="shine-text">
                                                    <img class="img-fluid"
                                                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-3.png"
                                                        alt="Shine" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="shine-text-wrap">
                                            <span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE
                                                Member </span>
                                            <span class="text-wrap-two">Perks</span>
                                        </div>
                                    </div>
                            </a>
                                </div>
                            <div class="formobileWrapper" id="shinePerksWrap">
                                <?php get_template_part('inc/templates/shine-saving-plans/shine-member-perks');?>
                            </div>
                    </div>
                </div>


            </div>


        </div>

    </div>
</div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



<script>
var jQ = jQuery.noConflict();

//1 for accordion
jQuery(document).ready(function() {

    $('.accordion-list > li > .answer').hide();

    $('.accordion-list > li').click(function() {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active").find(".answer").slideUp();
        } else {
            $(".accordion-list > li.active .answer").slideUp();
            $(".accordion-list > li.active").removeClass("active");
            $(this).addClass("active").find(".answer").slideDown();
        }
        return false;
    });

    // Prevent closing when clicking inside .answer
    $('.accordion-list .answer').click(function(event) {
        event.stopPropagation();
    });

    // 2 for tabs

    jQuery('.tabs-button').on('click', function() {

        jQuery('.tabs-button').removeClass("activeTab");
        jQuery('.tabs-content').addClass('hidden-all'); // Hide all content
        var dataAtt = $(this).data('att'); // Get the data-att value
        jQuery('#' + dataAtt).removeClass('hidden-all'); // Show the relevant content
        jQuery(this).addClass("activeTab");
    });

    // 3 for popup

    // Open modal on button click
    $('#openModal1').click(function() {
        jQuery('body').addClass("overflowHiddenByJs");
        $('#modal1').fadeIn(500).find('.modal-content').animate({
            top: '10%'
        }, 500);

    });


    $('.textdes').click(function() {
        jQuery('body').addClass("overflowHiddenByJs");
        $('#modal4').fadeIn(500).find('.modal-content').animate({
            top: '10%'
        }, 500);

    });



    // Close modal on <span> click
    $('.close').click(function() {
        jQuery('body').removeClass("overflowHiddenByJs");
        var modalId = $(this).data('modal');
        $('#' + modalId).fadeOut(500).find('.modal-content').animate({
            top: '200px'
        }, 500);

    });

    // Close modal on outside click
    $(window).click(function(event) {
        if ($(event.target).hasClass('modal')) {
            $('.modal').fadeOut(500).find('.modal-content').animate({
                top: '200px'
            }, 500);
            jQuery('body').removeClass("overflowHiddenByJs");
        }

    });

    // 3 Tab functionality insight popup
    $('.tablink').click(function() {
        var tabId = $(this).data('tab');
        $(this).addClass('activeTabNav');
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        $(this).parent().siblings('.tabcontent').hide();
        $('#' + tabId).show();

        // Add class to popuptabs-wrapper based on the data-tab value
        $('.popuptabs-wrapper').removeClass(function(index, className) {
            return (className.match(/(^|\s)data-tab\S+/g) || []).join(' ');
        }).addClass('data-tab-' + tabId);

    });

    // Initialize the first tab as active
    $('.tabs').each(function() {
        $(this).find('.tablink').eq(1).addClass('active'); // Set the second tab as active
        $(this).siblings('.tabcontent').eq(1).show().addClass('fadeIn'); // Show the second tab content
    });

    // for accordion saving poup
    $('.accordion-header').click(function() {
        var content = $(this).next('.accordion-content');
        var arrow = $(this).find('.arrow');

        if (content.is(':visible')) {
            content.slideUp();
            arrow.removeClass('up');
        } else {
            $('.accordion-content').slideUp(); // Optional: Close other sections
            $('.arrow').removeClass('up'); // Optional: Reset arrows of other sections

            content.slideDown();
            arrow.addClass('up');
        }
    });

    // for customers brand logoes
    jQuery('.customer-brand-slide').slick({
        arrows: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        pauseOnHover: false,
        cssEase: 'linear',
        infinite: true,
        swipeToSlide: true,
        variableWidth: true,
        centerMode: true,
        focusOnSelect: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    // for savings plans

    jQuery('.mobile-slider-activate').slick({
        infinite: true,
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        speed: 600,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: true,
        swipeToSlide: true,
        touchThreshold: 30,   // Reduce this value to make small drags trigger slides
        touchMove: true,     // Enable smooth touch movement

        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    swipeToSlide: true,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    swipeToSlide: true,
                    centerMode: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    slidesToScroll: 1
                }
            }

        ]


    })




    // function initializeSlickSlider() {
    //     if (window.matchMedia("(max-width: 768px)").matches) {
    //         jQuery('.mobile-slider-activate').not('.slick-initialized').slick({
    //             dots: false,
    //             infinite: true,
    //             speed: 300,
    //             slidesToShow: 1,
    //             centerMode: true,
    //         });
    //     } else {
    //         if (jQuery('.mobile-slider-activate').hasClass('slick-initialized')) {
    //             jQuery('.mobile-slider-activate').slick('unslick');
    //         }
    //     }
    // }

    // // Initialize slider on page load
    // jQuery(document).ready(function() {
    //     initializeSlickSlider();
    // });

    // // Re-initialize slider on window resize
    // jQuery(window).on('resize', function() {
    //     initializeSlickSlider();
    // });

    // for partners logoes
    jQuery('.partnersSlide').slick({
        arrows: false,
        slidesToShow: 9,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        pauseOnHover: false,
        cssEase: 'linear',
        infinite: true,
        swipeToSlide: true,
        centerMode: true,
        focusOnSelect: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    if (window.matchMedia("(max-width: 768px)").matches) {
        // for savings cards only for mobile
        jQuery('.card-saving-best-value').addClass('active-pricing-card');
        jQuery('.saving-card-header').click(function() {
            jQuery('.card-saving-best-value').removeClass('active-pricing-card');
            const content = jQuery(this).next('.saving-shine-content');
            const parentCard = jQuery(this).closest('.savings-card-wrapper');

            // Slide up all other contents and remove active class from other parent elements
            jQuery('.saving-shine-content').not(content).slideUp(400);
            jQuery('.savings-card-wrapper').not(parentCard).removeClass('active-pricing-card');
            // Add active-pricing-card class to the parent element
            parentCard.addClass('active-pricing-card');

            // Toggle the clicked content
            content.slideToggle(600, function() {
                if (content.is(':visible')) {
                    // Scroll animation
                    jQuery('html, body').animate({
                        scrollTop: parentCard.offset().top - 65
                    }, 800);
                } else {
                    // Remove active-pricing-card class if content is hidden
                    parentCard.removeClass('active-pricing-card');
                }
            });
        });
    }

        AOS.init({
        duration: 1200,
        once: true,
        })

});

// function performSearch() {
//     // Get the values from the input fields
//     const zipOrName = document.getElementById('zipNameGet').value;
//     const category = document.getElementById('category').value;
//     const distance = document.getElementById('distance').value; // Just the number without 'miles'

//     // Build the query string
//     const queryString = `?keyword=${encodeURIComponent(zipOrName)}&category=${encodeURIComponent(category)}&distance=${encodeURIComponent(distance)}`;

//     // Redirect to the new URL
//     const searchUrl = 'https://stable.smilebrilliant.com/shine-search' + queryString;
//     window.location.href = searchUrl;
// }

// function performSearch4() {
//       const section = document.getElementById('section4');
//       const zipOrName = section.getElementsByClassName('zipNameGet')[0].value;
//       const category = section.getElementsByClassName('category')[0].value;
//       const distance = section.getElementsByClassName('distance')[0].value;

//       const queryString = `?keyword=${encodeURIComponent(zipOrName)}&category=${encodeURIComponent(category)}&distance=${encodeURIComponent(distance)}`;
//       const searchUrl = 'https://www.smilebrilliant.com/shine-search' + queryString;
//       window.location.href = searchUrl;
//     }

    // function performSearch1() {
    //   const section = document.getElementById('section1');
    //   const zipOrName = section.getElementsByClassName('zipNameGet')[0].value;
    //   const category = section.getElementsByClassName('category')[0].value;
    //   const distance = section.getElementsByClassName('distance')[0].value;

    //   const queryString = `?keyword=${encodeURIComponent(zipOrName)}&category=${encodeURIComponent(category)}&distance=${encodeURIComponent(distance)}`;
    //   const searchUrl = 'https://www.smilebrilliant.com/shine-search' + queryString;
    //   window.location.href = searchUrl;
    // }



    // Ends Get the user location and throw to the shine search



    // function performSearch3() {
    //   const section = document.getElementById('section3');
    //   const zipOrName = section.getElementsByClassName('zipNameGet')[0].value;
    //   const category = section.getElementsByClassName('category')[0].value;
    //   const distance = section.getElementsByClassName('distance')[0].value;

    //   const queryString = `?keyword=${encodeURIComponent(zipOrName)}&category=${encodeURIComponent(category)}&distance=${encodeURIComponent(distance)}`;
    //   const searchUrl = 'https://www.smilebrilliant.com/shine-search' + queryString;
    //   window.location.href = searchUrl;
    // }


function getPopupPrices(id) {
    try {
        var frequency = document.getElementById(id + '_frequency_pop').value;
        var members = document.getElementById(id + '_members_pop').value;
        var combinationsElement = document.getElementById(id + '_combinations_pop');

        // Log the content of the combinations element to debug
        //console.log('Combinations element content:', combinationsElement.value);


        // Log the content of the indexes element to debug
        //console.log('indexes element content:', indexes);

        var combinations = JSON.parse(combinationsElement.value);
        var indexes = JSON.parse(combinationsElement.getAttribute("indexs"));
        var priceKey = id + '_' + members + '_' + frequency;

        // Log the generated key to debug
        console.log('Price key:', priceKey);

        var price = combinations[priceKey];
        var index = indexes[priceKey];

        // Log the price to debug
        console.log('Price:', price);
        //console.log("ARBID:",index)

        var freq_symbol = '';
        if(frequency > 28 && frequency < 365){
            freq_symbol = '/mo';
        }else{
            freq_symbol = '/yr';
        }

        if(price && price != "undefined"){
            document.getElementById('DM' + id + '_price').innerHTML = '<div class="saving-price-wrapper"><span class="currency-indicator">$</span><div>' + parseFloat(price).toFixed(2) + '</div><span class="charges-yearly">'+freq_symbol+'</span></div>';
            var element = document.getElementById(id + '_btn_dm');
            element.classList.remove('disableButton');
            element.disabled = false;
            document.getElementById(id + '_info_dm').style.display = 'none';
            element.setAttribute("data-prod_price", parseFloat(price));
            element.setAttribute("data-frequency", frequency);
            element.setAttribute("data-arbid", index);
        }else{
            document.getElementById('DM' + id + '_price').innerHTML = '';
            var element = document.getElementById(id + '_btn_dm');
            element.classList.add('disableButton');
            element.disabled = true;
            document.getElementById(id + '_info_dm').style.display = '';
        }
    } catch (e) {
        console.error('Error parsing JSON or accessing price:', e);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    AOS.init();
    getPopupPrices(<?php echo SHINE_DENTAL_PRODUCT_ID; ?>);
    getPopupPrices(<?php echo SHINE_COMPLETE_PRODUCT_ID; ?>);
    getPopupPrices(<?php echo SHINE_PERK_PRODUCT_ID; ?>);
});



// for mobile popup accordion insight another accordion
//   JS for toggle buttons only for mobile
$(document).ready(function(){
  $(".accordion-mobile-header").click(function(){

 // Check how many elements have the class 'accordion-mobile-header'
    var headerCount = $(".accordion-mobile-header").length;
    console.log("Number of accordion-mobile-header elements: " + headerCount);

    // Close any open accordion-mobile body
    $(".accordion-mobile-body").slideUp();
    $(".accordion-mobile-header").removeClass("active");

    // Open the clicked accordion-mobile body
    if($(this).next(".accordion-mobile-body").is(":visible")){
        $(this).next(".accordion-mobile-body").slideUp();
        $(this).removeClass("active");
    } else {
        $(this).next(".accordion-mobile-body").slideDown();
        $(this).addClass("active");
    }
  });
});






// Get the user location and throw to the shine search


// let latitude = null;
// let longitude = null;

// function getLocation(radio) {
//     const zipNameGetInput = document.getElementById('zipNameGet');
//     const buttonsGroupSet = document.querySelector('#section2');

//     if (radio.checked) {
//         if (navigator.geolocation) {
//             // Add loader when geolocation starts
//             buttonsGroupSet.classList.add('loaderValuesLoader');

//             navigator.geolocation.getCurrentPosition(showPosition, showError);
//             zipNameGetInput.disabled = true;
//             zipNameGetInput.value = ''; // Clear the input value
//             jQuery('select#distance').removeClass('disabled');
//         } else {
//             alert("Geolocation is not supported by this browser.");
//         }
//     } else {
//         latitude = null;
//         longitude = null;
//         zipNameGetInput.disabled = false;
//         // jQuery('select#distance').addClass('disabled');
//     }
// }

// function showPosition(position) {
//     latitude = position.coords.latitude;
//     longitude = position.coords.longitude;

//     // Remove the loader when location is retrieved
//     const buttonsGroupSet = document.querySelector('#section2');
//     buttonsGroupSet.classList.remove('loaderValuesLoader');

//     console.log("Latitude: " + latitude + "\nLongitude: " + longitude);
// }

// function showError(error) {
//     const buttonsGroupSet = document.querySelector('#section2');
//     buttonsGroupSet.classList.remove('loaderValuesLoader'); // Remove loader on error as well

//     switch(error.code) {
//         case error.PERMISSION_DENIED:
//             alert("User denied the request for Geolocation.");
//             break;
//         case error.POSITION_UNAVAILABLE:
//             alert("Location information is unavailable.");
//             break;
//         case error.TIMEOUT:
//             alert("The request to get user location timed out.");
//             break;
//         case error.UNKNOWN_ERROR:
//             alert("An unknown error occurred.");
//             break;
//     }
// }




// function showError(error) {
// switch(error.code) {
//     case error.PERMISSION_DENIED:
//         alert("User denied the request for Geolocation.");
//         break;
//     case error.POSITION_UNAVAILABLE:
//         alert("Location information is unavailable.");
//         break;
//     case error.TIMEOUT:
//         alert("The request to get user location timed out.");
//         break;
//     case error.UNKNOWN_ERROR:
//         alert("An unknown error occurred.");
//         break;
// }
// }



    let latitude = null;
    let longitude = null;

    function getLocation(radio) {
        const zipNameGetInput = document.getElementById('zipNameGet');
        const buttonsGroupSet = document.querySelector('#section2');

        if (radio.checked) {
            if (navigator.geolocation) {
                // Add loader when geolocation starts
                buttonsGroupSet.classList.add('loaderValuesLoader');

                navigator.geolocation.getCurrentPosition(showPosition, showError);
                zipNameGetInput.disabled = true;
                zipNameGetInput.value = ''; // Clear the input value
                jQuery('select#distance').removeClass('disabled');
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        } else {
            latitude = null;
            longitude = null;
            zipNameGetInput.disabled = false;
        }
    }

    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        // Remove the loader when location is retrieved
        const buttonsGroupSet = document.querySelector('#section2');
        buttonsGroupSet.classList.remove('loaderValuesLoader');

        console.log("Latitude: " + latitude + "\nLongitude: " + longitude);
    }

    function showError(error) {
        const buttonsGroupSet = document.querySelector('#section2');
        const checkbox1 = document.getElementById('checkbox1'); // Get checkbox1 element
        const zipNameGetInput = document.getElementById('zipNameGet');

        // Remove loader on error
        buttonsGroupSet.classList.remove('loaderValuesLoader');

        // Check the General Results radio button and enable zipNameGet input
        checkbox1.checked = true;
        zipNameGetInput.disabled = false;

        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }




function performSearch2() {
    const section = document.getElementById('section2');
    const checkbox1 = document.getElementById('checkbox1');
    const checkbox2 = document.getElementById('checkbox2');
    let zipOrName = section.getElementsByClassName('zipNameGet')[0].value.trim();
    const category = section.getElementsByClassName('category')[0].value;
    const distance = section.getElementsByClassName('distance')[0].value;

    // Default zipOrName to '0' if empty and checkbox1 is checked
    if (checkbox1.checked && !zipOrName) {
        zipOrName = '0';
    }

    let queryString = `?category=${encodeURIComponent(category)}&distance=${encodeURIComponent(distance)}`;

    // Add zipOrName if checkbox1 is checked
    if (checkbox1.checked) {
        queryString += `&keyword=${encodeURIComponent(zipOrName)}`;
    }

    // Add latitude and longitude if checkbox1 is not checked and values are available
    if (!checkbox1.checked && latitude && longitude) {
        queryString += `&latitude=${encodeURIComponent(latitude)}&longitude=${encodeURIComponent(longitude)}`;
    }

    // Add &keyword= if checkbox2 is selected
    if (checkbox2.checked) {
        queryString += `&keyword=`;
    }

    const searchUrl = '/shine-search' + queryString;
    window.location.href = searchUrl;

}





const zipNameGetInputTwo = document.getElementById('zipNameGet');

jQuery('#resetButton').on('click', function() {
    zipNameGetInputTwo.disabled = false;
    zipNameGetInputTwo.value = ''; // Clear the input value
    jQuery('.useCurrentLocation').prop('checked', false);
    jQuery("select#distance option:selected").attr('disabled',false)
    jQuery('select#distance').removeClass('disabled');
    jQuery('body').find("input").removeClass('disabled');
    // jQuery("#searchButton").attr('disabled',true);
    jQuery("#section2").removeClass("loaderValuesLoader")
    latitude = null;
    longitude = null;
});

// for popup checkbox

$(document).ready(function() {
    $('#checkbox1').change(function() {
        if ($(this).is(':checked')) {
            // alert("checkbox1 clicked");
            $('#checkbox2').prop('checked', false);
            jQuery("#zipNameGet").attr('disabled',false)
            jQuery(".rowDivWrapper").addClass('hideDivMiles')
            jQuery("select#distance option:selected").attr('disabled',true)
            jQuery("#searchButton").attr('disabled',false)
            // jQuery('.wrapperGpsInner').addClass('disabled');
            jQuery(this).parent().parent(".wrapperTo").addClass("generaResults-checked")

            jQuery("#section2").removeClass("loaderValuesLoader")

        }
        else {
        // When checkbox1 is unchecked
        jQuery(".rowDivWrapper").removeClass('hideDivMiles');
        $('#checkbox2').prop('checked', true);
        jQuery(this).parent().parent(".wrapperTo").removeClass("generaResults-checked")

    }
    });

    $('#checkbox2').change(function() {
        if ($(this).is(':checked')) {
            // alert("checkbox2 clicked");
            $('#checkbox1').prop('checked', false);
            jQuery("#zipNameGet").attr('disabled',true)
            jQuery("#searchButton").attr('disabled',false)
            jQuery(".rowDivWrapper").removeClass('hideDivMiles')
            jQuery("select#distance option:selected").attr('disabled',false)
            jQuery(".wrapperTo").removeClass("generaResults-checked")
            jQuery("#section2").addClass("loaderValuesLoader")
        }
        else {

            $('#checkbox1').prop('checked', true);
            alert("#checkbox1 clicking")

         }


    });
});




$(document).ready(function() {
    $('.openPop').click(function() {
        // Check the radio button
        $('#checkbox2').prop('checked', true);

        // Call getLocation function to fetch latitude and longitude
        getLocation(document.getElementById('checkbox2'));

        // Add a class to the body and animate the modal
        jQuery('body').addClass("overflowHiddenByJs");
        $('#modal2').fadeIn(500).find('.modal-content').animate({
            top: '10%'
        }, 500);
    });
});



// for mobile ONLy


$(document).ready(function() {
    // Function to handle the accordion effect
    $('.btnjsAttribue').on('click', function(event) {
        event.preventDefault();

        // Get the value of data-attribute
        var targetDiv = $(this).attr('data-attribute');
        var modal = $(this).closest('.modal'); // Adjust this to your modal container's class or ID
        var parentWrapper = $(this).closest('.popupContentWrapper'); // Find the parent wrapper with this class

        // Hide all the .formobileWrapper divs
        $('.formobileWrapper').slideUp();

        // Remove previously added classes from the parent wrapper
        parentWrapper.removeClass(function(index, className) {
            return (className.match(/(^|\s)shine\S+/g) || []).join(' ');
        });

        // Show the clicked target div only if it's not already visible
        if (!$(targetDiv).is(':visible')) {
            $(targetDiv).slideDown(function() {
                // Scroll to the target div inside the modal
                modal.animate({
                    scrollTop: $(targetDiv).offset().top - modal.offset().top + modal.scrollTop()
                }, 1000); // Adjust the duration for smooth scrolling

                // Add the class to the parent wrapper
                var targetClass = targetDiv.replace('#', ''); // Remove '#' to use the ID as the class
                parentWrapper.addClass(targetClass); // Add the class based on the targetDiv's ID
            });
        }
    });
});



</script>


<?php
if (function_exists('wc_print_notices')) {
    // Output the notices
    //echo 'noticess';
    wc_print_notices();
}
get_footer();
?>