<style>
    .row-t {
        /* align-items:center; */
        margin-left: -15px;
        margin-right: -15px;
        display: flex;
    }

    #solid-color-with-text-section {
        margin-top: 84px;
        overflow: hidden;
        background: #1998ff;
        border-bottom: 4px solid #1e2c53;
    }

    #solid-color-with-text-section .btn-primary-orange {
        background-color: #1e2c53;
        border-color: #1e2c53;
        color: #fff;
        letter-spacing: 0;
        font-size: 18px;
        padding: 8px 40px;
    }

    #solid-color-with-text-section .btn-primary-orange:hover {
        background-color: #595858;
        border-color: #595858
    }

    #solid-color-with-text-section .sectionWrapper {
        background-repeat: no-repeat;
        background-position: right;
        padding: 1rem 0;
        background-position-y: top;
        padding-top: 24px;
        padding-bottom: 5rem;
    }

    #solid-color-with-text-section .sectionGraphic img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
    }

    #solid-color-with-text-section .blur {
        filter: blur(25px);
        animation-name: example;
        animation-duration: .1s;
        animation-delay: .1s;
        animation-timing-function: ease-in-out;
        animation-fill-mode: forwards;
    }

    #solid-color-with-text-section .no-blur {
        filter: blur(0);
        transition: filter .5s 1s ease-in;
    }

    @keyframes example {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    #solid-color-with-text-section .sectionRightText {
        color: #fff;

    }

    #solid-color-with-text-section .sale-content-section-left h1 {
        color: #fff;
        font-size: 6.5rem;
        line-height: 1;
    }

    #solid-color-with-text-section .nopremeMember {
        color: #1e2c53;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    #solid-color-with-text-section .sale-content-section-left {
        text-align: left;
        max-width: 438px;
    }

    #solid-color-with-text-section .medium-img {
        /* max-width: 94%;     */
        /* margin-left: auto; */
        min-height: 484px;
    }

    .sectionRightBanner {
        position: relative;
        min-width: 825px;
        padding-left: 2rem;
    }

    #home-page-top-banner-section {
        display: none
    }

    .xl-container {
        margin-left: auto;
        margin-right: auto;
    }

    #solid-color-with-text-section .sectionRightText p {
        font-size: 24px;
        line-height: 1.3;
    }


    #solid-color-with-text-section .brush-image-sale {
        position: absolute;
        bottom: -4rem;
        left: 7rem;
    }

    #solid-color-with-text-section h4.buy-one-get-one {
        font-size: 4.2rem;
        color: #1e2c53;
        line-height: 4rem;
        margin: 0;
        margin-top: 2rem;
        font-weight: 500;
    }

    #solid-color-with-text-section .parent-text-wrap {
        display: flex;
        gap: 10px;
    }

    #solid-color-with-text-section .more-text {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }

    #solid-color-with-text-section span.plus-icon-large {
        line-height: 0.9;
    }

    #solid-color-with-text-section span.more-text {
        font-size: 20%;
        position: relative;
        top: -23px;
    }

    #solid-color-with-text-section .free-text {
        font-weight: 900;
    }

    @media only screen and (min-width: 768px) {
        .hidden-desktop {
            display: none
        }

        .buy-one-get-one br {
            display: none;
        }
    }

    @media (min-width: 1300px) {
        #solid-color-with-text-section .sale-content-section-left h1 {
            /* color: orange; */
        }
    }

    @media (min-width: 1500px) {
        #solid-color-with-text-section .sale-content-section-left h1 {
            /* color: red; */
        }

    }


    @media (min-width: 1700px) {
        #solid-color-with-text-section .sale-content-section-left h1 {
            /* color: purple; */
        }
    }

    @media (max-width: 11450px) {

        .sectionWrapper br.hidden-mobile {
            display: none;
        }
    }
    @media (max-width: 1300px) {
        .xl-container {
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }

    }


    @media (max-width: 1200px) {

        #solid-color-with-text-section .sale-content-section-left h1 {
            font-size: 6vw;
        }

        .sectionRightBanner {
            min-width: 658px;
        }

    }


    @media (max-width: 992px) {
        #solid-color-with-text-section .sale-content-section-left h1 {
            /* color: brown; */
        }

        .sectionRightBanner {
            min-width: 550px;
        }

        #solid-color-with-text-section .nopremeMember {

            font-size: 18px;
        }

        #solid-color-with-text-section .sectionWrapper {
            padding: 2rem 0;
        }

        #solid-color-with-text-section .medium-img {
            min-height: 318px;
        }

    }

    @media only screen and (max-width: 767px) {
        .hidden-mobile {
            display: none
        }

        .row-t {
            flex-wrap: wrap;
        }

        #solid-color-with-text-section .sale-content-section-left {
            text-align: center;
            max-width: 100%;
            padding-left: 15px;
            padding-right: 15px;
        }

        #solid-color-with-text-section .sale-content-section-left h1 {
            font-size: 60px;
        }

        .sectionRightBanner {
            min-width: 100%;
        }

        #solid-color-with-text-section .sectionRightText {
            text-align: center;
        }

        #solid-color-with-text-section .sectionWrapper {
            background-position: top center;
            background-position-y: -527px;
        }

        #solid-color-with-text-section .sectionRightText p {
            font-size: 21px;
            line-height: 1.3;
        }

        #solid-color-with-text-section .medium-img {
            min-height: 245px;
        }

        #solid-color-with-text-section {
            margin-top: 65px;
        }

        .mobileimage {
            margin-top: 20px;
            margin-left: 1rem;
            margin-right: 1rem;
        }

        .buy-one-get-one br {
            display: block;
        }

        #solid-color-with-text-section h4.buy-one-get-one {
            margin-top: 0rem;
        }

        #solid-color-with-text-section .more-text {
            display: none;
        }

        #solid-color-with-text-section .parent-text-wrap {
            justify-content: center;
        }

        .sectionRightBanner {
            padding-left: 0rem
        }
    }
</style>



<section id="solid-color-with-text-section">
    <div class="sectionWrapper" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/banner-background-graphic.png)">
        <div class="container xl-container">
            <div class="row-t text-center align-item-center justify-content-center pos-rel">
                <div class="sale-content-section-left">
                    <h4 class="buy-one-get-one">Buy 1 <br class="show-only-mobile"><span style="color:#fff;">Get 1</span></h4>
                    <h1>
                        <div style="color:#1e2c53" class="parent-text-wrap">
                            <span class="free-text">FREE</span>
                            <div class="more-text"><span class="plus-icon-large">+</span>
                                <span class="more-text">more</span>
                            </div>
                        </div>
                    </h1>
                    <div class="sectionRightText">
                        <p>
                            Get a head start this holiday season!<br class="hidden-mobile">
                            Buy any <span style="color:#1e2c53;font-weight:700;">whitening kits</span> or deluxe<br class="hidden-mobile">
                            <span style="color:#1e2c53;font-weight:700;">electric toothbrush</span> & get a 2nd one<br class="hidden-mobile">
                            <strong class="font-mont bold">FREE</strong>. Save up to 50% site wide.
                        </p>
                    </div>

                    <a class="btn btn-primary-orange" href="/sale">SHOP DEALS</a>
                </div>

                <div class="sectionRightBanner">


                    <div class="medium-img hidden-mobile" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png);" alt="" class="img-fluid hidden-mobile">
                        <div class="brush-image-sale">
                            <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/sale-brush-extra.png);" alt="" class="img-fluid">
                        </div>
                    </div>

                    <div class="hidden-desktop mobileimage">
                        <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/mobile-early-prime-day-product-banner.jpg);" alt="" class="img-fluid hidden-mobile">
                    </div>


                </div>

            </div>
        </div>
    </div>
</section>



<script>
    // window.addEventListener("load", function() {
    //     let lazy = document.getElementsByClassName("medium-img");
    //     for (let n = 0, len = lazy.length; n < len; n++) {
    //         lazy[n].children[0].setAttribute("src", lazy[n].getAttribute("data-src"));
    //         lazy[n].children[0].addEventListener("load", function(e) {
    //             e.target.classList.add("no-blur");
    //         });
    //     }
    // });
</script>