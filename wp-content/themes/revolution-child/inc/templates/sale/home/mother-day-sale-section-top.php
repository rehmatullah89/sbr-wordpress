<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,900&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
</style>
<style>
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
    background-color: #b8b8dc;
    margin-top: 84px;
    padding-top: 45px;
    padding-bottom: 50px;
}

.row-t {
    align-items: center;
    margin-left: -15px;
    margin-right: -15px;
    display: flex;
    flex-wrap: wrap;
}

.v-col-sm-6,
.v-col-sm-6 {
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
    max-width: 480px;
    text-align: center;
}

.mother-dayText {
    font-size: 70px;
    font-family: 'Pacifico', cursive;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
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
    font-size: 23.5px;
    margin: 0;
    margin-top: 0px;
    margin-bottom: 0px;
    line-height: 1.2;
    color: #fff;
    margin-top: 6px;
    margin-bottom: 16px;
}


.sectionTopBanner .btn-primary-orange {
    background-color: #f0c6c7;
    border-color: #f0c6c7;
    color: #fff;
    margin-top: 15px;
    letter-spacing: 0;
}

.sectionTopBanner .btn-primary-orange:hover {
    background-color: #595858;
    border-color: #595858;
}

@media only screen and (min-width: 1200px) {
    .sectionGraphic {
        min-height: 500px;
    }
}

@media only screen and (max-width: 1200px) {
    .featureDeals {
        font-size: 111px;
    }

    .mother-dayText {
        font-size: 48px;
        position: relative;
        margin-bottom: 0;
        line-height: 0.9;
    }

    .sectionTopBanner p {
        font-size: 19px;
    }



}



@media only screen and (max-width: 767px) {

    #solid-color-with-text-section {
        padding-top: 20px;
        padding-bottom: 25px;
    }


    .v-col-sm-6,
    .v-col-sm-8 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }

    .p-order1 {
        order: 1;
    }

    .p-order2 {
        order: 2;
    }

    .sectionTopBanner {
        text-align: center;
    }

    .sectionGraphic img {
        max-width: 170px;
    }

}
</style>

<section id="solid-color-with-text-section">
    <div class="container">
        <div class="row-t text-center align-item-center justify-content-center">
            <div class="v-col-sm-6 p-order2">
                <div class="sectionGraphic">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mother-day-sale/mother-day-graphic-home-page.png);"
                        alt="" class="img-fluid">
                </div>
            </div>
            <div class="v-col-sm-6 p-order1">
                <div class="sectionTopBanner">
                    <div class="mother-dayText">
                        Mother’s Day
                    </div>
                    <div class="featureDeals">
                        <span class="orange-light-text">SALE</span>
                    </div>
                    <!-- <p class="font-mont">Gift mom or yourself a beautiful<br> smile this mother’s day and save<br> up to
                        40%</p> -->
                        <p class="font-mont">Gift mom (or you) a renewed  smile this mother’s day and save up to
                        40%</p>
                        <a class="btn btn-primary-orange hidden-mobile" href="/sale">SHOP FEATURED DEALS</a>
                </div>
            </div>

            <div class="v-col-sm-12 order3 desktop-hidden sectionTopBanner">
                <a class="btn btn-primary-orange" href="/sale">SHOP FEATURED DEALS</a>
            </div>
        </div>
    </div>
</section>