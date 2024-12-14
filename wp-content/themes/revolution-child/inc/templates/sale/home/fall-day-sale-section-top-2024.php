<style>

@font-face {
    font-family: 'astilaregular';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/Astila-Regular/fontsfree-net-astila-regular-2-webfont.svg') format('svg'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/Astila-Regular/fontsfree-net-astila-regular-2-webfont.woff') format('woff'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/Astila-Regular/fontsfree-net-astila-regular-2-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/Astila-Regular/fontsfree-net-astila-regular-2-webfont.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;

}

.sale-fall-section-top{
    padding-top: 200px;
    background-color: #f6edd8;
    background-size: cover;
    background-repeat: no-repeat;
    padding-bottom: 60px;
    position: relative;
    overflow: hidden;
    z-index: 0;


}
.sale-fall-section-top h2 {
    font-family: 'astilaregular';
    font-size: 77px;
    color: #6f1110;
    font-weight: 500;
    line-height: 54px;
    text-align: center;
    margin-bottom: 5px;
    position: relative;
}
.sale-fall-section-top h2 img.leaf-one-img {
    position: absolute;
    top: -50px;
    left: 101px;
}
.sale-fall-section-top h2 img.oral-leaf-img {
    position: absolute;
    top: -41px;
    margin-left: -32px;
}
.sale-fall-section-top h2 img.oral-leaf-img-end{
    position: absolute;
    top: 28px;
    margin-left: -10px;
}
.sale-fall-section-top p{
    text-align: center;
    font-size: 32px;
    font-family: 'Montserrat';
    line-height: 36px;
    font-weight: 500;
    color: #022044;
}
.sale-fall-section-heading {
    text-align: center;
    position: relative;
    z-index: 99;
}
.sale-fall-section-heading .brown-img {
    position: absolute;
    left: 23%;
    top: -145px;
}
.sale-fall-section-heading .green-img {
    position: absolute;
    right: 0;
    top: -70px;
}
.sale-fall-section-heading .yellow-img{
    position: absolute;
    right: 22%;
    top: -135px;
}
.sale-fall-section-heading .bottom-broen-img {
    position: absolute;
    right: 30px;
    margin-top: 40px;
}
.sale-fall-section-heading .bottom-yellow-img {
    position: absolute;
    left: 35%;
    bottom: -120px;
}
.sale-fall-section-heading  a{
    display: block;
    background: #6f1110;
    max-width: 308px;
    margin: 0px auto;
    padding: 15px 0px;
    color: #fff;
    font-family: 'Montserrat';
    font-size: 24px;
    font-weight: 500;
    margin-top: 40px;
}
.sale-fall-section-top .row {
    align-items: center;
}
.top-right-corner {
    position: absolute;
    top: 100px;
    right: 0;
}
.left-bottom-corner-image{
    position: absolute;
    bottom: -3px;
    left: -6px;
    width: 100%;
}
.leaf_bg_one_wrapper {
    position: absolute;
    top: 120px;
    left: 20px;
}
.leaf_bg_two_wrapper {
    position: absolute;
    top: 135px;
    right: 0px;
}
.home-page-wrappper {
    display: none;
}
.sale-fall-section-image img {
    filter: drop-shadow(1px 6px 5px rgba(88, 88, 88, 0.8));
}
.ribbon-text {
    position: absolute;
    z-index: 999;
    top: 135px;
}
.sale-fall-section-heading a {
    display: block;
    background: #6f1110;
    max-width: 308px;
    margin: 0px auto;
    padding: 15px 0px;
    color: #fff;
    font-family: 'Montserrat';
    font-size: 24px;
    font-weight: 500;
    margin-top: 12px;
}
.L-top-img{
    position: relative;
}

.L-img-top {
    position: absolute;
    top: -22px;
    left: -36px;
    max-width: 70px;
}
.salr-top-right-img {
    position: absolute;
    top: 90px;
    left: 32px;
}
@media screen and (min-width:1024px){
    .mbl-green-leaf-1,.mbl-green-yellow-1,.mbl-green-leaf-2,img.salr-brown-img,.mobile-bottom-bg,.mbl-ribbon-text {
    display: none;
}
.bottom-broen-img-mbl {
    display: none;
}
.yellow-bottom-leaf-3,.mbl-brown-leaf-bottom,.mboile-cut-leaf-img,.mboile-cheery-img {
    display: none
}
.mboile-cheery-img, .yellow-cut-leaf-img {
    display: none;
}
.salr-top-right-img{
    display: none;
}
}
@media screen and (min-width:768px){
    .salr-top-right-img{
        display: none;
    }
}
@media screen and (min-width:768px) and (max-width:1024px){
    .mbl-green-leaf-1,.mbl-green-yellow-1,.mbl-green-leaf-2,img.salr-brown-img,.mobile-bottom-bg,.mbl-ribbon-text {
    display: none;
}
.bottom-broen-img-mbl {
    display: none;
}
.yellow-bottom-leaf-3,.mbl-brown-leaf-bottom,.mboile-cut-leaf-img,.mboile-cheery-img {
    display: none
}
.mboile-cheery-img, .yellow-cut-leaf-img {
    display: none;
}
.sale-fall-section-top .row{
    justify-content: center;
}
.sale-fall-section-image{
    text-align: center;
    z-index: 9999;
    position: relative
}
.sale-fall-section-top{
    padding-top: 222px;
}
}
@media only screen and (max-width: 1920px) {
    .sale-fall-section-top h2 {
    font-size: 52px;
    line-height: 36px;
}

.sale-fall-section-top h2 img.leaf-one-img {
    top: -59px;
    left: 172px;
}
.sale-fall-section-top h2 img.oral-leaf-img {
    top: -45px;
    margin-left: -25px;
}
.sale-fall-section-top h2 img.oral-leaf-img-end {
    top: 12px;
    margin-left: -10px;
}
.sale-fall-section-top p {
    font-size: 28px;
    line-height: 32px;
    margin-bottom: 0px;
}
.L-img-top {
        position: absolute;
        top: -35px;
        left: -40px;
        max-width: 70px;
    
}
}
@media only screen and (max-width: 1766px) {
    .sale-fall-section-top h2 {
    font-size: 52px;
    line-height: 36px;
}

.sale-fall-section-top h2 img.leaf-one-img {
    top: -59px;
    left: 172px;
}
.sale-fall-section-top h2 img.oral-leaf-img {
    top: -45px;
    margin-left: -25px;
}
.sale-fall-section-top h2 img.oral-leaf-img-end {
    top: 12px;
    margin-left: -10px;
}
.sale-fall-section-top p {
    font-size: 28px;
    line-height: 32px;
}
.leaf_bg_one_wrapper{
    left: -20px;
}
}
@media only screen and (max-width: 1599px) {
    .sale-fall-section-top h2 {
    font-size: 52px;
    line-height: 36px;
}

.sale-fall-section-top h2 img.leaf-one-img {
    top: -59px;
    left: 172px;
}
.sale-fall-section-top h2 img.oral-leaf-img {
    top: -45px;
    margin-left: -25px;
}
.sale-fall-section-top h2 img.oral-leaf-img-end {
    top: 12px;
    margin-left: -10px;
}
.sale-fall-section-top p {
    font-size: 28px;
    line-height: 32px;
}
.leaf_bg_one_wrapper {
        left: -100px;
    }
    .ribbon-text img {
        max-width: 80%;
    }
}
@media only screen and (max-width: 1499px) {
    .sale-fall-section-top h2 {
    font-size: 52px;
    line-height: 36px;
}

.sale-fall-section-top h2 img.leaf-one-img {
        top: -37px;
        left: 121px;
        max-width: 80%;
        height: 50px;
    }
    .sale-fall-section-top h2 img.oral-leaf-img {
        top: -34px;
        margin-left: -21px;
        max-width: 80%;
        height: 35px;
    }
    .sale-fall-section-top h2 img.oral-leaf-img-end {
        top: 14px;
        margin-left: -6px;
        max-width: 80%;
        height: 25px;
    }
    .sale-fall-section-top p {
        font-size: 20px;
        line-height: 24px;
    }
.leaf_bg_one_wrapper {
        left: -100px;
    }
    .sale-fall-section-image img {
        max-width: 88%;
    }
    .leaf_bg_two_wrapper {
    position: absolute;
    top: 60px;
    right: -91px;
}
.leaf_bg_two_wrapper img{
  max-width: 80%;
}
.leaf_bg_one_wrapper {
        left: 10px;
        top: 114px;
    }
    .leaf_bg_one_wrapper img {
        max-width: 65%;
    }
    .sale-fall-section-heading .brown-img {
    position: absolute;
    left: 23%;
    top: -94px;
}
.sale-fall-section-heading .brown-img img,.sale-fall-section-heading .yellow-img img,.sale-fall-section-heading .green-img img,.bottom-broen-img img {
    max-width: 80%;
}
.sale-fall-section-heading .yellow-img {

    top: -103px;
}
.sale-fall-section-heading .green-img {
    top: -35px;
}
}

@media screen and (max-width:1299px){
    .leaf_bg_one_wrapper {
        left: -70px;
        top: 114px;
    }
    .leaf_bg_two_wrapper {

        right: -170px;
    }
    .ribbon-text img {
        max-width: 60%;
    }
}
    @media screen and (max-width:1199px){
        .sale-fall-section-top h2 img.leaf-one-img {
        top: -37px;
        left: 62px;
        max-width: 80%;
        height: 50px;
    }
    .ribbon-text img {
        max-width: 60%;
    }
    }

    @media screen and (max-width:1024){
        .sale-fall-section-top{
            padding-top: 250px;
        }
    }
    @media screen and (max-width:767px){
    .top-right-corner{
        display: none;
    }
    .sale-fall-section-heading .bottom-yellow-img{
        position: absolute;
        right: 2%;
        bottom: -215px;
    }
    .sale-fall-section-heading .bottom-yellow-img img {
        max-width: 60%;
    }
    .leaf_bg_two_wrapper{
        display: none;
    }
    .L-img-top{
    position: absolute;
    top: -20px;
    left: -25px;
    max-width: 45px;
}
    .mbl-brown-leaf-bottom {
    position: absolute;
    left: -35px;
    bottom: 15%;
    z-index: 99;
}
.mboile-cut-leaf-img {
    position: absolute;
    right: -15px;
}
.mboile-cut-leaf-img  img {
    max-width: 55%;
}
.sale-fall-section-top p {
    margin-bottom: 20px;
}
.yellow-cut-leaf-img {
    position: absolute;
        right: -10px;
        bottom: -170px;
}
.salr-top-right-img {
    left: 0px;
}
.salr-top-right-img img {
    max-width: 50%;
}
.yellow-cut-leaf-img img {
    max-width: 55%;
}
.mboile-cheery-img {
        position: absolute;
        right: -10px;
        bottom: 80px;
    }
    .mboile-cheery-img  img {
        max-width: 65%;
    }
.mbl-brown-leaf-bottom  img{
    max-width: 80%;
}
.yellow-bottom-leaf-3 img {
    max-width: 50%;
}
.yellow-bottom-leaf-3 {
    position: absolute;
    z-index: 9999;
    bottom: 20px;
    left: -10px;
}
    .left-bottom-corner-image {
        display: none;
    }
    .leaf_bg_one_wrapper {
        display: none;
    }
    .sale-fall-section-heading a{
        max-width: 230px;
        margin-top: -20px;
    }
    .bottom-broen-img {
    display: none;
}
    .ribbon-text {
        display: none
    }
    .bottom-broen-img-mbl {
    position: absolute;
    right: -60px;
    bottom: 10px;
}
.bottom-broen-img-mbl img {
    max-width: 35%;
}
    .sale-fall-section-heading .brown-img img,.sale-fall-section-heading .yellow-img img,.sale-fall-section-heading .green-img img,.bottom-broen-img img {
    max-width: 55%;
}
        .mbl-ribbon-text {
        max-width: 80%;
        right: -30px;
        z-index: 999;
    }
    .sale-fall-section-top h2 {
        font-size: 42px;
        line-height: 32px;
    }
    .mbl-hidden-text{
        display: none;
    }
    .mbl-hidden {
        display: none;
    }
    .desktop-hidden{
        display: block;
    }
    .mbl-ribbon-text{
        max-width: 80%;
    right: 0;
    z-index: 9;
    }
    .sale-fall-section-top{
        padding-top: 110px;
        padding-bottom: 0px;
    }
    .salr-top-right-img {
    left: -10px;
    top: 70px;
}

.sale-fall-section-heading .brown-img{
    left: 32%;
    top: -30px;
}
.sale-fall-section-heading .yellow-img{
    right: 0%;
}
.sale-fall-section-heading .yellow-img{
    top: -25px;
}
.mobile-bottom-bg{
    position: absolute;
    bottom: 0;
    z-index: 0;
}
.sale-fall-section-image {
    top: -15px;
        z-index: 99;
        position: relative;
    }
    .sale-fall-section-image img{
     max-width: 80%;
    }
.mbl-ribbon-text{
    position: absolute;
        max-width: 80%;
        right: -30px;
        z-index: 9999;
        bottom: 0;
}
.mbl-ribbon-text img {
    max-width: 83%;
}
.sale-fall-section-heading {
    z-index: 99;
    padding-bottom: 0px;
    padding-top: 40px;
}
.salr-brown-img{
    display: none;
}
.sale-fall-section-heading .green-img img{
    display: none;
}
.sale-fall-section-top h2 img.leaf-one-img{
    left: 34px;
}
.mbl-green-leaf-1 {
    position: absolute;
        top: 32%;
        max-width: 80%;
        left: 0px;
}
.mbl-green-leaf-2{
    position: absolute;
        bottom: 29%;
        max-width: 80%;
        left: 35px;
}
.mbl-green-leaf-2 img{
 max-width: 65%;
}

.mbl-green-yellow-1 {
    position: absolute;
        top: 47%;
        left: 10px;
}
.mbl-green-leaf-1 img {
    max-width: 65%;
}
.mbl-green-yellow-1 img {
    max-width: 65%;

}
}
@media screen and (max-width: 440px) {
    .sale-fall-section-top h2 img.leaf-one-img {
        left: 43px;
    }
}

@media screen and (max-width: 399px) {
    .sale-fall-section-top h2 img.leaf-one-img {
        left: 23px;
    }
}
@media screen and (max-width:360px){
    .sale-fall-section-top h2 img.leaf-one-img {
        left: 9px;
    }
}

</style>




<div class="sale-fall-section-top">
    <div class="top-right-corner">
        <div class="top-right-corner-image">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/top_right_image.png" alt="top_right_image">
        </div>
    </div>
    <div class="salr-top-right-img">
       
       <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/salr-top-right-img.png" alt="top_right_image">
     
   </div>
    <div class="ribbon-text">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/text-png.png" alt="text img">
    </div>
    <div class="mbl-ribbon-text">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/nbl-ribbon-img.png" alt="text img">
    </div>
    <div class="leaf_bg_two_wrapper">
    <div class="leaf_bg_two">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/leaf3.png" alt="leaf3">
        </div>
    </div>
    <div class="mbl-green-leaf-1">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mlb-green-leaf.png" alt="leaf3">

    </div>
    <div class="mbl-green-yellow-1">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mbl-leaf-heart.png" alt="leaf3">

    </div>
    <div class="mbl-green-leaf-2">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mbl-green-leaf-2.png" alt="leaf3">

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="sale-fall-section-heading">
                    <div class="brown-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/brown-leaf.png" alt="text-leaf">
                    </div>
                    <div class="yellow-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/yellow-leaf.png" alt="text-leaf">
                    </div>
                    <div class="green-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/green-top-leaf.png" alt="text-leaf">
                    </div>
                    <h2> <img class="salr-brown-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/salr-brown-img.png" alt="text-leaf">  <span class="L-top-img"> <img class="L-img-top" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/text-leaf-1.png" alt="text-leaf"> L</span>eaf oral <img class="oral-leaf-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/text-leaf-2.png" alt="text-leaf">  care <br> concerns behind <img class="oral-leaf-img-end" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/leaf-text-3.png" alt="text-leaf"></h2>
                    <p class="mbl-hidden">Harvest up to 40% off on oral care must-haves. <br>
                  <span class="mbl-hidden-text"> Don’t miss out—sale ends Sept 29!</span> </p>
                  <div class="mboile-cheery-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mbl-cherry.png" alt="text-leaf">

                    </div>
                  <p class="desktop-hidden">Harvest up to 40% off <br> on oral care must-haves. </p> <br>
                    <a href="/sale">SAVE & SMILE</a>

                  
                    <div class="mboile-cut-leaf-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mblbrown-img-1.png" alt="text-leaf">

                    </div>
                    <div class="yellow-cut-leaf-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/yellow-cut-leaf.png" alt="text-leaf">

                    </div>
                    <div class="bottom-yellow-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/yellow-bottom-leaf.png" alt="text-leaf">
                    </div>
                    <div class="bottom-broen-img">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/bottom-brown-leaf.png" alt="text-leaf">
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="sale-fall-section-image">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/sale_product_img.png" alt="sale_product_img">


                </div>
            </div>
        </div>
    </div>
    <div class="left-bottom-corner-image">
        <div class="left-bottom-corner-image">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/bottom-left_img.png" alt="bottom-left_img">
        </div>
    </div>
    <div class="leaf_bg_one_wrapper">
    <div class="leaf_bg_one">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/Fall-Sale-Home-Desktop.png" alt="Fall-Sale-Home-Desktop">
        </div>
    </div>
    <div class="mbl-brown-leaf-bottom">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mbl-brwon-leaf-2.png" alt="bottom-left_img">

    </div>
    <div class="yellow-bottom-leaf-3">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/yellow-bottom-leaf-3.png" alt="bottom-left_img">

    </div>
    <div class="mobile-bottom-bg">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/mobile-bottom-bg.png" alt="bottom-left_img">
    </div>
    <div class="bottom-broen-img-mbl">
                    <img class="leaf-one-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/fall-sale/bottom-brown-leaf.png" alt="text-leaf">
                    </div>
</div>