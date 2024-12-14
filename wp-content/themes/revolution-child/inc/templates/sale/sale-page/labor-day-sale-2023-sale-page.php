<style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display&display=swap');
</style>

<style>
    #solid-color-with-text-section {
        margin-top: 0px;
        overflow: hidden;
        background: #e7f3fa;
    }
    #solid-color-with-text-section .justify-content-center{
        justify-content: center;
    }

    #home-page-top-banner-section {
        display: none;
    }

    section#solid-color-with-text-section .container {
        max-width: 100%;
        width: 100%;
        padding-left: 15px;
        padding-right: 15px;
        margin-left: auto;
        margin-right: auto;
    }

    #solid-color-with-text-section {
        /* background-color: #6aa5d0; */
        max-height: 488px;
        overflow: hidden;
        padding-top: 23px;
        box-shadow: 0px 15px 10px -15px #11111185;
    }

    .row-t {
        margin-left: -15px;
        margin-right: -15px;
        display: flex;
        /* flex-wrap: wrap */
    }

    .v-col-sm-6,
    .v-col-sm-6,
    .v-col-sm-5,
    .v-col-sm-7 {
        padding-left: 15px;
        padding-right: 15px
    }

    .v-col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .font-mont-black {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-style: italic
    }

    .sectionTopBanner {
        text-align: left;
        text-align: center;
        background: #e7f3fa;
        padding: 40px 1rem;
        position: relative;
        z-index: 99;

    }

    .indepndence-dayText {
        font-size: 34px;
        font-family: 'Playfair Display', serif;
        color: #595858;
        line-height: 1;
        margin-top: 10px;
        display: inline-flex;
        position: relative;
        margin-bottom: 10px;
    }

    .indepndence-dayText:after {
        bottom: -15px;
        top: initial
    }

    .featureDeals {
        font-size: 128px;
        font-family: 'Montserrat';
        font-weight: 900;
        line-height: .9
    }

    .orange-light-text {
        color: #f0c6c7
    }

    .blue-text {
        color: #3c98cc
    }

    .sectionTopBanner p {
        font-size: 16px;
        margin: 0;
        margin-top: 0;
        margin-bottom: 0;
        line-height: 1.2;
        color: #626263;
        margin-top: 16px;
        margin-bottom: 20px;
        padding: 0 20px;
        font-weight: 500
    }

    .people-img img {
        max-width: 270px
    }

    .sectionTopBanner .btn-primary-orange {
        background-color: #3d98cc;
        border-color: #3482af;
        color: #fff;
        letter-spacing: 0;
        width: 70%;
        font-size: 18px
    }

    .sectionTopBanner .btn-primary-orange:hover {
        background-color: #595858;
        border-color: #595858
    }

    .graphic_logo {
        max-width: 140px;
        margin-left: auto;
        margin-right: auto
    }

    .extraBold {
        font-weight: 900
    }

    .saleHeading h2 {
        font-size: 6rem;
        color: #d4555b;
        line-height: 1;
        margin-bottom: 0
    }

    .people-img {
        margin-top: 18px
    }

    .sectionGraphic img {
        /* -webkit-box-shadow: 20px 20px 15px #3a7aa8 */
    }

    .pos-rel {
        position: relative
    }




    .sectionGraphic img {
        max-width: 921px;
    }

    .sidebar-section-right {
        display: flex;
    }

    .sidebar-section-right {
        display: flex;
        flex: 0 0 40%;
        max-width: 40%;
    }
    .sectionTopBanner p{
        font-size: 20px;
    }
    @media screen and (min-width:1800px) {

    }

    @media screen and (min-width:2000px) {

    }

    @media screen and (min-width:2600px) {

    }

    @media only screen and (min-width: 768px) {
        .hidden-desktop {
            display: none
        }

        .sectionGraphic {
            max-width: 1156px
        }

        .v-col-sm-7 {
            -ms-flex: 0 0 60%;
            flex: 0 0 60%;
            max-width: 60%
        }

        .v-col-sm-5 {
            max-width: 463px;
            width: 100%;
        }
    }

    @media only screen and (max-width: 1600px) {


        .sectionGraphic img {
            position: relative;
            left: -7rem;
        }
    }

    @media only screen and (max-width: 1400px) {


        .sectionGraphic img {
            position: relative;
            left: -13rem;
        }
    }

    @media only screen and (max-width: 1200px) {


        .saleHeading h2 {
            font-size: 7rem
        }

        .featureDeals {
            font-size: 82px
        }

        .indepndence-dayText {
            font-size: 29px
        }

        .sectionTopBanner p {
            font-size: 17px
        }

        .people-img img {
            max-width: 250px
        }

        .sectionTopBanner p {
            padding: 0 11px
        }
    }

    @media only screen and (max-width: 990px) {


        .indepndence-dayText {
            font-size: 30px
        }

        .saleHeading h2 {
            font-size: 106px
        }

        #solid-color-with-text-section .container {
            width: 95%
        }

        .sectionTopBanner p {
            font-size: 16px
        }

        #solid-color-with-text-section .v-col-sm-5 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }

        .sectionGraphic {
            left: -58%;
            top: -39px;
            max-width: 1030px
        }

        .sectionTopBanner {
            padding-top: 35px;
            padding-bottom: 34px
        }



    }

    @media only screen and (max-width: 767px) {
        #solid-color-with-text-section .v-col-sm-6 {
            display: none
        }

        #solid-color-with-text-section .v-col-sm-5 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
        }



        .sidebar-section-right {
            display: flex;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .hidden-mobile {
            display: none
        }

        .sectionGraphic {
            margin-bottom: 10px;
            margin-top: 10px
        }

        .sectionTopBanner {
            padding-top: 40px;
            padding-bottom: 40px
        }

        .v-col-sm-6,
        .v-col-sm-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%
        }

        .order1 {
            /* order: 1 */
        }

        .order2 {
            /* order: 2 */
        }

        .sectionTopBanner {
            text-align: center
        }

        #solid-color-with-text-section {
            padding-bottom: 0;
            margin-top: 0px
        }

        .sectionGraphic {
            display: none;
            position: static;
            max-width: 1030px
        }

        .sectionTopBanner {
            padding-top: 20px;
             padding-bottom: 20px;
        }

        #solid-color-with-text-section .container {
            width: 100%
        }

        .sectionTopBanner {
            padding-left: 1rem;
            padding-right: 1rem;
            box-shadow: 0 0 0 0 #00000029
        }

        .sectionTopBanner {
            padding-top: 15px;
            padding-bottom: 15px
        }

        .v-col-sm-5.order2.pos-rel.largerZ {
            padding: 0
        }

        .sectionTopBanner p {
            font-size: 16px;
            margin-top: 30px;
            margin-bottom: 30px
        }

        .indepndence-dayText {
            font-size: 42px;
            margin-top: 0px
        }

        #solid-color-with-text-section{
            background-color: #e7f3fa; 
        }
        #solid-color-with-text-section{
            max-height: 530px;
        }
    }
</style>

<section id="solid-color-with-text-section">
    <div class="container">
        <div class="row-t text-center align-item-center justify-content-center pos-rel">
                <div class="v-col-sm-5  pos-rel largerZ">
                    <div class="sectionTopBanner">
                        <div class="indepndence-dayText">
                            <div class="indepence-inner">
                                Labor Day
                            </div>
                        </div>
                        <div class="saleHeading">
                            <h2 class="font-mont extraBold">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/labour-day-september-sale/sale.png);" alt="" class="img-fluid">
                            </h2>
                        </div>
                        <p class="font-mont">Make your dentist proud by improving your smile this labor day & save up to 55% </p>
                    </div>
                </div>

      
        </div>
    </div>
</section>