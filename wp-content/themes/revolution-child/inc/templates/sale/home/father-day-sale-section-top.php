<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display&display=swap');
</style>
<style>

#solid-color-with-text-section{margin-top: 138px;}
    #home-page-top-banner-section {
        display: none
    }

    section#solid-color-with-text-section .container {
        max-width: 1170px;
        padding-left: 15px;
        padding-right: 15px;
        margin-left: auto;
        margin-right: auto;
    }

    #solid-color-with-text-section {
        background-color: #6ca9d4;
        /* margin-top: 84px;
    padding-top: 45px;
    padding-bottom: 50px; */
    border-bottom: 1px solid #fff;
    }

    .row-t {
        align-items: center;
        margin-left: -15px;
        margin-right: -15px;
        display: flex;
        flex-wrap: wrap;
    }

    .v-col-sm-6,
    .v-col-sm-6,
    .v-col-sm-5,
    .v-col-sm-7 {
        padding-left: 15px;
        padding-right: 15px;
    }

    .v-col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }


    .font-mont-black {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-style: italic;
    }

    .sectionTopBanner {
        text-align: left;
    text-align: center;
    background: #e7f3fa;
    padding-top: 110px;
    padding-bottom: 110px;
    padding-left: 2rem;
    padding-right: 2rem;  box-shadow: 10px 0 5px -2px #00000029;
    }

    .father-dayText {
        font-size: 48px;
        font-family: 'Playfair Display', serif;
        color: #595858;
        line-height: 1;
        margin-top: 8px;
    }

    .featureDeals {
        font-size: 128px;
        font-family: 'Montserrat';
        font-weight: 900;
        line-height: 0.9;
    }

    .orange-light-text {
        color: #f0c6c7;
    }

    .blue-text {
        color: #3c98cc;
    }

    .sectionTopBanner p {
        font-size: 18px;
        margin: 0;
        margin-top: 0px;
        margin-bottom: 0px;
        line-height: 1.2;
        color: #595858;
        margin-top: 15px;
        margin-bottom: 16px;
    }


    .sectionTopBanner .btn-primary-orange {
        background-color: #303e48;
        border-color: #32373a;
        color: #fff;
        margin-top: 15px;
        letter-spacing: 0;
        width: 96%;font-size: 18px;
    }

    .sectionTopBanner .btn-primary-orange:hover {
        background-color: #595858;
        border-color: #595858;
    }
    .graphic_logo {
        max-width: 154px;
    margin-left: auto;
    margin-right: auto;
    }    
    .extraBold {
        font-weight: 900;
    }
    .saleHeading h2 {
    font-size: 9rem;
    color: #3d98cc;
    line-height: 1;
    margin-bottom: 0;
}



    @media only screen and (min-width: 768px) {
    .v-col-sm-7 {
            -ms-flex: 0 0 60%;
            flex: 0 0 60%;
            max-width: 60%;
        }

        .v-col-sm-5 {
            -ms-flex: 0 0 40%;
            flex: 0 0 40%;
            max-width: 40%;
        }
        .sectionGraphic img {
            max-width: 106%;
        }
    }
    @media only screen and (min-width: 1200px) {
        .sectionGraphic {
            /* min-height: 500px; */
            padding-top: 39px;
        }
    }

    @media only screen and (max-width: 1200px) {
        .featureDeals {
            font-size: 82px;
        }

        .father-dayText {
            font-size: 52px;
        }

        .sectionTopBanner p {
            font-size: 19px;
        }



    }



    @media only screen and (max-width: 767px) {

        .sectionTopBanner{
            padding-top: 40px;
             padding-bottom: 40px;
        }


        .v-col-sm-6,
        .v-col-sm-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .order1 {
            order: 1;
        }

        .order2 {
            order: 2;
        }

        .sectionTopBanner {
            text-align: center;
        }
        #solid-color-with-text-section{padding-top: 1rem;padding-bottom: 1rem;}
        #solid-color-with-text-section {
            margin-top: 115px;
        }

    }
</style>

<section id="solid-color-with-text-section">
    <div class="container">
        <div class="row-t text-center align-item-center justify-content-center">
            <div class="v-col-sm-7 order1">
                <div class="sectionGraphic">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/father-day-sale/father-day-sale-home-banner.webp);" alt="" class="img-fluid">
                </div>
            </div>

            <div class="v-col-sm-5 order2">
                <div class="sectionTopBanner">
                    <div class="graphic_logo">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/father-day-sale/Logo_sbr_text.webp);" alt="" class="img-fluid">
                    </div>

                    <div class="father-dayText">
                        Father’s Day
                    </div>

                    <div class="saleHeading">
                        <h2 class="font-mont extraBold">
                            <!-- <span class="textS">S</span><span class="textA">A</span><span class="saleLGraphc"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/father-day-sale/sale_L.png);" alt="" class="img-fluid"></span><span class="textE">E</span>  -->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/father-day-sale/saleText.png);" alt="SALE" class="img-fluid">
                        </h2>                        
                    </div>

                    <p class="font-mont">Make dad smile this Father’s Day & save up to 40%</p>
                    <a class="btn btn-primary-orange" href="/sale">SHOP  DEALS</a>
                </div>
            </div>

        </div>
    </div>
</section>