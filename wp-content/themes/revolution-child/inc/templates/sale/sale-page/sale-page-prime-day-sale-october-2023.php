<style>
    .row-t {
        /* align-items:center; */
        margin-left: -15px;
        margin-right: -15px;
        display: flex;
    }

    #solid-color-with-text-section {
        margin-top: 0px;
        overflow: hidden;
        background: #1998ff;
        border-bottom: 0px solid #1e2c53;
        padding-top: 39px;
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
        /* background-position: center; */
        background-position-y: -545px;
        padding-top: 24px;
        padding-bottom: 24px;
        padding-top: 22px;

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
        text-align: right;
    }

    #solid-color-with-text-section .sale-content-section-left h1 {
        color: #fff;
        font-size: 90px;
        line-height: 70px;
    }

    #solid-color-with-text-section .nopremeMember {
        color: #fff;
        font-size: 24px;
    }

    #solid-color-with-text-section .sale-content-section-left {
        text-align: center;
        max-width: 100%;
    }

    #solid-color-with-text-section .medium-img {
        /* max-width: 94%;     */
        /* margin-left: auto; */
        min-height: 484px;
    }

    .sectionRightBanner {
        min-width: 825px;
    }

    #home-page-top-banner-section {
        display: none
    }

    .xl-container {
        margin-left: auto;
        margin-right: auto;
    }

    #solid-color-with-text-section .sectionRightText p {
        font-size: 20px;
    }

    #solid-color-with-text-section .sale-content-section-left h1 {
        color: #1e2c53;
    }

    #solid-color-with-text-section .sale-content-section-left span.prime-day-text {
        font-size: 41px;
        line-height: 40px;
        color: #fff;
    }

    #solid-color-with-text-section .prime-day-text {
        font-family: 'Montserrat';
        color: #fff;
        font-size: 40px;
        line-height: 40px;
        font-weight: 600;
    }

    .page-template-page-sale-new .nopremeMember{
        display: none;
    }


    @media only screen and (min-width: 768px) {
        .hidden-desktop {
            display: none
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


    @media (max-width: 1300px) {
        .xl-container {
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }
    }


    @media (max-width: 1200px) {

        #solid-color-with-text-section .sale-content-section-left h1 {
            font-size: 4vw;
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

            font-size: 27px;
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
            font-size: 48px;
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
            font-size: 19px;
            line-height: 1.3;
        }

        #solid-color-with-text-section .medium-img {
            min-height: 245px;
        }

        #solid-color-with-text-section {
            margin-top: 25px;
        }

        .mobileimage {
            margin-top: 20px;
            margin-left: 1rem;
            margin-right: 1rem;
        }

        #solid-color-with-text-section .nopremeMember {
            font-size: 18px;
        }

        #solid-color-with-text-section .sectionWrapper {
            padding-top: 0px;
        }

        #solid-color-with-text-section {
    margin-top: 0px;
}#solid-color-with-text-section .sale-content-section-left h1 {
    font-size: 72px;
}
.header-spacer {
    height: 67px!important;
}


    }
</style>



<section id="solid-color-with-text-section">
    <div class="sectionWrapper" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/banner-background-graphic.png)">
        <div class="container xl-container">
            <div class="row-t text-center align-item-center justify-content-center pos-rel">
                <div class="sale-content-section-left">
                    <div class="prime-day-text">PRIME SALE </div>
                    <h1>
                        <span class="prime-day-main_text">DEALS! </span>
                    </h1>
                    <div class="nopremeMember">
                        Exclusive <strong>GEHA</strong> member pricing for the holidays
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>