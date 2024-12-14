<style>
    #solid-color-with-text-section {
        margin-top: 84px;
        overflow: hidden;
    }

    #solid-color-with-text-section .home-sale-wrapper {
        position: relative;
        z-index: 99;
        background-color: #6a6969;
        padding: 40px 0px;
    }

    #home-page-top-banner-section {
        display: none;
    }

    .black-friday-wrapper {
        max-width: 1100px;
        margin: 0px auto;
    }

    .black-friday-wrapper,
    .black-friday-left-side {
        display: flex;
        align-items: center;

        justify-content: space-between;
    }


    .black-firday-left-text {
        position: relative;
        text-align: center;
        margin-left: 80px;
        padding: 10px 20px 10px 10px;
        border: 2px solid #fff;
    }

    .badge-blue span {
        display: block;
        background-color: #3c97cb;
        border-radius: 6px;
        font-size: 18px;
        color: #fff;
        font-style: italic;
        letter-spacing: 2px;
        line-height: 24px;
        max-width: 144px;
        margin: 0px auto;
        position: absolute;
        width: 200px;
        left: 31%;
        top: -14px;
    }

    .black-firday-left-text .heading h1 {
        color: #fff;
        font-style: italic;
        font-size: 98px;
        padding-bottom: 30px;
        line-height: 80px;
    }

    .badge-red {
        position: absolute;
        bottom: -26px;
        left: 12px;
        background: #6a6969;
    }

    .text {
        position: absolute;
    }

    .text h3 {
        color: #fff;
        font-size: 48px;
        font-family: 'Montserrat';
        position: relative;
        left: 150px;
        top: -25px;
        background: #6a6969;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail {
        z-index: 99;
        text-align: center;
        max-width: 440px;
        margin-top: 14px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail h3 {
        font-size: 32px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p {
        font-size: 18px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p.main-text {
        line-height: 1.2;
        margin: 0px 0px 15px 0px;
    }

    .black-friday-right-side {
        position: relative;
        top: -20px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail h3,
    p {
        color: #fff;
        font-family: 'Montserrat'
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p.heading {
        margin-bottom: 0px;
        font-size: 26px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p.main-text {
        line-height: 1.3;
    }

    .black-friday-right-side .shop-deals {
        background-color: #d4545a;
    }

    .black-friday-right-side .night-guard {
        background-color: #68c8c7;
    }

    .black-friday-right-side .whitening-system {
        background-color: #f7a18a;
    }

    .black-friday-right-side .mouth-guard {
        background-color: #69be28;
    }

    .black-friday-right-side .mouth-guard span {
        color: #cd5b57;
        font-style: italic;
        font-weight: 600;
    }

    .black-friday-right-side .buttons p {
        padding: 5px 0px;
        margin-bottom: 10px;
        border: 1px solid #fff
    }

    .black-friday-right-side .buttons p a {
        color: #fff;
        font-size: 14px;
    }

    .mobile-img {
        display: none;
    }

    @media screen and (min-width:1500px) {
        .black-friday-wrapper {
            margin-right: 16%;
        }
    }

    @media screen and (max-width:767px) {
        #solid-color-with-text-section {
            margin-top: 65px;
        }

        .black-firday-image,
        .black-firday-left-text {
            display: none;
        }

        .mobile-img {
            display: block;
            max-width: 260px;
            margin-bottom: 20px;
        }

        .black-friday-wrapper,
        .black-friday-left-side {
            flex-direction: column;
        }

        .black-friday-right-side .text-detail .buttons {
            display: block;
        }

        .black-friday-right-side .buttons p {
            margin-bottom: 20px;
        }

        #solid-color-with-text-section .home-sale-wrapper .text-detail p.main-text {
            margin: 0px 0px 20px 0px;
        }

        .mobile-img .badge-blue span {
            padding: 0px;
            font-size: 14px;
            max-width: 108px;
            line-height: 20px;
        }

        .mobile-img .badge-blue {
            position: relative;
            top: 5px;
        }
    }
</style>

<section id="solid-color-with-text-section">
    <div class="home-sale-wrapper">
        <div class="container">
            <div class="black-friday-wrapper">
                <div class="black-friday-left-side">
                    <div class="black-firday-image">
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/black-friday-sale/Toothbrush&Flosser.png" alt="" class="img-fluid hidden-mobile">
                    </div>
                    <div class="black-firday-left-text">
                        <div class="badge-blue">
                            <span class="font-mont">EXTENDED</span>
                        </div>
                        <div class="heading">
                            <h1 class="font-mont">BLACK <br> FRIDAY</h1>
                        </div>
                        <div class="badge-red">
                            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/black-friday-sale/DEALS.png" alt="" class="img-fluid hidden-mobile">
                        </div>
                        <div class="text">
                            <h3>ARE LIVE</h3>
                        </div>
                    </div>
                    <div class="mobile-img">
                        <div class="badge-blue">
                            <span class="font-mont">EXTENDED</span>
                        </div>
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/black-friday-sale/Callout.png" alt="" class="img-fluid hidden-mobile">
                    </div>
                </div>
                <div class="black-friday-right-side">
                    <div class="text-detail">
                        <p class="heading">Save up to <strong><em> 60%</em></strong> </p>
                        <p class="main-text">There's no need to wait,<br> <strong style="color:#d4545a" class="extraBold italic"> <em>Black Friday</em> </strong>  deals are live. <strong>Save</strong> on <br>your oral care needs today!</p>
                        <!-- <p class="main-text">Now through Nov, 24 + <strong style="color:#d4545a" class="extraBold italic"> <em>New</em> </strong> <br> <strong> <em>bundle deals</em></strong> & <strong style="color:#d4545a" class="extraBold italic"><em>FREE</em></strong> <strong><em>GIFTS</em></strong> with <br> select items</p> -->
                        <div class="buttons">
                            <p class="shop-deals"><a href="/sale">SHOP FEATURED DEALS</a></p>
                            <p class="night-guard"><a href="/product/night-guards/">NIGHT GUARDS</a></p>
                            <p class="whitening-system"><a href="/product/teeth-whitening-trays/">
                                    <!-- <span>NEW!</span> -->
                                    WHITENING SYSTEMS</a></p>
                            <p class="mouth-guard"><a href="/product/proshield/">
                                    <!-- <span>NEW!</span> -->
                                    <span>NEW!</span> ATHLETIC MOUTH GUARD</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>