<style>

@font-face {

    font-family: 'Ayalisse';

    src: url('/wp-content/themes/revolution-child/assets/fonts/font-ayalisse/Ayalisse.woff2') format('woff2'), url('/wp-content/themes/revolution-child/assets/fonts/font-ayalisse/Ayalisse.woff') format('woff'), url('../assets/fonts/Ayalisse.ttf') format('truetype');

}



.font-alalisse {

    font-family: 'Ayalisse';

}



#solid-color-with-text-section {

    margin-top: 4px;

    overflow: hidden

}



#home-page-top-banner-section {

    display: none

}



section#solid-color-with-text-section .container {

    padding-left: 15px;

    padding-right: 15px;

    margin-left: auto;

    margin-right: auto

}



#solid-color-with-text-section {

    background-color: #fbb789;

}



.row-t {

    align-items: center;

    margin-left: -15px;

    margin-right: -15px;

    display: flex;

    flex-wrap: wrap

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

    padding: 50px 2rem

}



.indepndence-dayText {

    font-size: 34px;

    font-family: 'Playfair Display', serif;

    color: #595858;

    line-height: 1;

    margin-top: 10px;

    display: inline-flex;

    position: relative;

    margin-bottom: 15px

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

    font-size: 17px;

    margin: 0;

    margin-top: 0;

    margin-bottom: 0;

    line-height: 1.2;

    color: #fff;

    margin-top: 4px;

    margin-bottom: 0px;

    padding: 0 25px;

    font-weight: 400;

}



.people-img img {

    max-width: 270px

}



.sectionTopBanner .btn-primary-orange {

    background-color: #2385c2;

    border-color: #3482af;

    color: #fff;

    letter-spacing: 0;

    font-size: 18px;

    padding: 8px 40px;

}



.sectionTopBanner .btn-primary-orange:hover {

    background-color: #595858;

    border-color: #595858

}



.graphic_logo {

    max-width: 330px;

    margin-left: auto;

    margin-top: -54px;

    position: relative;

    left: -10px;

}



.extraBold {

    font-weight: 900

}



.saleHeading h2 {

    font-size: 8rem;

    color: #ffffff;

    line-height: 0.7;

    margin-bottom: 0;

}



.people-img {

    margin-top: 35px

}



.pos-rel {

    position: relative

}



.indepence-inner {

    font-weight: 700;

    font-size: 20px;

    color: #3e3f40;

    margin-bottom: 9px;

}





.medium-img {

    position: relative;

}





.sectionGraphic img {

    display: block;

    width: 100%;

    height: 100%;

    object-fit: cover;

    opacity: 0;

    /* cursor: zoom-in; */

}



.blur {

    filter: blur(25px);

    animation-name: example;

    animation-duration: .1s;

    animation-delay: .1s;

    animation-timing-function: ease-in-out;

    animation-fill-mode: forwards;

}



.no-blur {

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

.sbr-header-mbt .navbar-standard .navbar-center-cell{

   position: static;

}



.saleHeading {

    /* position: relative; */

    margin-left: auto;

    margin-right: auto;

}

img.img-fluid.leafOne {

    position: absolute;
    right: -40px;
    top: 58px;
    max-width: 70px;

    }



    img.img-fluid.leafTwo {

    position: absolute;
    left: 10px;
    bottom: 45px;
    max-width: 60px;

    }



    img.img-fluid.leafThree {

    max-width: 150px;
    position: absolute;
    right: -85px;
    top: 142px;
    }



    img.img-fluid.smallLeafImage {

    position: absolute;
    bottom: 87px;
    max-width: 85px;
    left: -70px;

    }

    @media screen and (min-width:1500px){
    img.img-fluid.leafThree {
    right: -40px;
}
    img.img-fluid.leafOne {
    right: 12px;
}
    img.img-fluid.leafTwo {
    left: 60px;
}
    img.img-fluid.smallLeafImage {
    left: -20px;
}
    }

    @media screen and (min-width:768px) and (max-width:992px){
        img.img-fluid.leafTwo {
    left: -10px;
    bottom: 35px;
}   
        .sectionTopBanner p.font-mont {
    margin: 0px auto;
    max-width: 270px;
    font-size: 15px !important;
}
img.img-fluid.leafThree {
    max-width: 75px !important;
    position: absolute;
    right: -5px;
    top: 178px;
}
img.img-fluid.leafOne {
    position: absolute;
    right: -30px;
    top: 58px;
    max-width: 70px;
}
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

        -ms-flex: 0 0 40%;

        flex: 0 0 40%;

        max-width: 40%

    }



    .graphic_logo_mobile.desktop-hidden,

    .desktop-hidden {

        display: none;

    }



}



@media only screen and (max-width: 1500px) {

    .graphic_logo {

        left: 40px;

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

        font-size: 17px

    }



    #solid-color-with-text-section .v-col-sm-5 {

        -ms-flex: 0 0 50%;

        flex: 0 0 50%;

        max-width: 50%

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



@media only screen and (max-width: 915px) and (orientation: landscape) {



    #solid-color-with-text-section .desktop-hidden,

    #solid-color-with-text-section .mobile-hidden {

        display: none;

    }



    #solid-color-with-text-section .graphic_logo.mobile-hidden {

        display: block;

    }

}



@media only screen and (max-width: 767px) {

    #solid-color-with-text-section .v-col-sm-5 {

        -ms-flex: 0 0 100%;

        flex: 0 0 100%;

        max-width: 100%

    }



    .hidden-mobile {

        display: none

    }



    .sectionGraphic {

        margin-bottom: 10px;

        margin-top: 10px

    }



    .v-col-sm-6,

    .v-col-sm-8 {

        -webkit-box-flex: 0;

        -ms-flex: 0 0 100%;

        flex: 0 0 100%;

        max-width: 100%

    }



    .order1 {

        order: 1

    }



    .order2 {

        order: 2

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



    #solid-color-with-text-section .container {

        width: 100%

    }



    .v-col-sm-5.order2.pos-rel.largerZ {

        padding: 0

    }



    .sectionTopBanner p {

        font-size: 17px;

        margin-top: 12px;

        margin-bottom: 15px;

        max-width: 265px;

        margin-left: auto;

        margin-right: auto;

    }





    .indepndence-dayText {

        font-size: 42px;

        margin-top: 0px

    }



    .graphic_logo_mobile {

        max-width: 380px;

        margin-left: auto;

        margin-right: auto;

        position: relative;

        margin-top: 40px;

    }



    .sectionTopBanner {

        text-align: center;

        padding-top: 25px;

        padding-bottom: 20px;

        padding-left: 1rem;

        padding-right: 1rem;

        box-shadow: 0 0 0 0 #00000029

    }



    .saleHeading h2 {

        font-size: 95px;

    }



    .saleHeading {

        position: relative;

        max-width: 350px;

        margin-left: auto;

        margin-right: auto;

    }



    .indepence-inner {

        font-size: 16px;

    }







    .sectionTopBanner p br {

        display: none;

    }





}

@media only screen and (max-width: 767px)  {
    span.heading-price {
    margin-left: -14px !important;
}
    img.img-fluid.leafTwo {
    left: 0px;
    bottom: 18px;
    max-width: 50px;
}
img.img-fluid.smallLeafImage {
    bottom: -85px;
    max-width: 50px;
    left: 5px;
}
img.img-fluid.leafOne {
    right: -7px;
    top: -5px;
    max-width: 50px;
}
img.img-fluid.leafThree {
    right: -1px;
    max-width: 70px;
    top: 85px;
}
.smallLeafImage.dsk {
    display:none !important;
}
.smallLeafImage.mbl {
    display:block !important;
}
}

.smallLeafImage.dsk {
    display:block;
}
.smallLeafImage.mbl {
    display:none;
}





@media only screen and (max-width: 767px) and (orientation: landscape) {

    #solid-color-with-text-section .graphic_logo.mobile-hidden {

        display: none;

    }



    #solid-color-with-text-section .desktop-hidden,

    #solid-color-with-text-section .mobile-hidden {

        display: block;

    }

}
span.heading-price {
    margin-left: -20px;
}
</style>



<section id="solid-color-with-text-section">

    <div class="container xl-container">

        <div class="row-t text-center align-item-center justify-content-center pos-rel">

            <div class="v-col-sm-5 order2 pos-rel largerZ">

                <div class="sectionTopBanner">

                    <div class="indepndence-dayText">

                        <div class="indepence-inner font-mont ">

                            Celebrate Fall With

                        </div>

                    </div>

                    <div class="saleHeading">

                        <h2 class=" font-alalisse">

                            Falling <br>P <span class="heading-price">rices</span> 

                        </h2>

                        <div class="hidden-desktop-none mobile-graphic-icons">

                           

                           <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-three.png);"

                            alt="" class="img-fluid smallLeafImage mbl"> 
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/leaf-three-sale-page.png);"

                            alt="" class="img-fluid smallLeafImage dsk">                              

                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-pine.png);"

                                alt="" class="img-fluid leafTwo">



                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/discount-tag.png);"

                                alt="" class="img-fluid leafThree">

                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-one.png);"

                                alt="" class="img-fluid leafOne">

      

                             

                        </div>

                    </div>



                    <p class="font-mont">

                        But like leaves, we will pick<br class="desktop-hidden">

                        them<br class="mobile-hidden">

                        up in a few days so

                        <br class="desktop-hidden"> don’t wait!

                    </p>



                </div>

            </div>

        </div>

    </div>

</section>



<script>

window.addEventListener("load", function() {

    let lazy = document.getElementsByClassName("medium-img");

    for (let n = 0, len = lazy.length; n < len; n++) {

        lazy[n].children[0].setAttribute("src", lazy[n].getAttribute("data-src"));

        lazy[n].children[0].addEventListener("load", function(e) {

            e.target.classList.add("no-blur");

        });

    }

});

</script>