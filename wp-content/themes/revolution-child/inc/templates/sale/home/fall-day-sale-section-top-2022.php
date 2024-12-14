<style>

@font-face {
    font-family: 'Ayalisse';
    src:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.woff') format('woff'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.woff2') format('woff2'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.svg#Ayalisse') format('svg'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.eot'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.eot?#iefix') format('embedded-opentype'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/font-ayalisse/Ayalisse.ttf') format('truetype');

    font-weight: normal;
    font-style: normal;
    font-display: swap;
}


.font-alalisse{
   
   font-family: 'Ayalisse';
}
#solid-color-with-text-section{margin-top:83px;overflow:hidden}
#home-page-top-banner-section{display:none}
section#solid-color-with-text-section .container{padding-left:15px;padding-right:15px;margin-left:auto;margin-right:auto}
#solid-color-with-text-section{background-color:#fbb789;}
.row-t{align-items:center;margin-left:-15px;margin-right:-15px;display:flex;flex-wrap:wrap}
.v-col-sm-6,.v-col-sm-6,.v-col-sm-5,.v-col-sm-7{padding-left:15px;padding-right:15px}
.v-col-sm-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}
.font-mont-black{font-family:'Montserrat',sans-serif;font-weight:900;font-style:italic}
.sectionTopBanner{text-align:left;text-align:center;padding:50px 2rem}
.indepndence-dayText{font-size:34px;font-family:'Playfair Display',serif;color:#595858;line-height:1;margin-top:20px;display:inline-flex;position:relative;margin-bottom:15px}
.indepndence-dayText:after{bottom:-15px;top:initial}
.featureDeals{font-size:128px;font-family:'Montserrat';font-weight:900;line-height:.9}
.orange-light-text{color:#f0c6c7}
.blue-text{color:#3c98cc}
.sectionTopBanner p{font-size:17px;margin:0;margin-top:0;margin-bottom:0;line-height:1.2;color:#fff;margin-top:35px;margin-bottom:20px;padding:0 25px;font-weight:400}
.people-img img{max-width:270px}
.sectionTopBanner .btn-primary-orange{background-color:#2385c2;border-color:#3482af;color:#fff;letter-spacing:0;font-size:18px;padding: 8px 40px;}
.sectionTopBanner .btn-primary-orange:hover{background-color:#595858;border-color:#595858}
.graphic_logo {
    max-width: 330px;
    margin-left: auto;
    margin-top: -54px;
    position: relative;
    left: -5px;
}
.extraBold{font-weight:900}
.saleHeading h2{
    font-size: 8rem;
    color: #ffffff;
    line-height: 0.7;
    margin-bottom: 0;   
}
.people-img{margin-top:35px}
.pos-rel{position:relative}
.indepence-inner {
   font-weight: 700;
    font-size: 20px;
    color: #3e3f40; 
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
  transition: filter .5s 0.3s ease-in;
}
@keyframes example {
  from {opacity: 0;}
  to {opacity: 1;}
}



@media only screen and (min-width: 768px) {
.hidden-desktop{display:none}
.sectionGraphic{max-width:1156px}
.v-col-sm-7{-ms-flex:0 0 60%;flex:0 0 60%;max-width:60%}
.v-col-sm-5{-ms-flex:0 0 40%;flex:0 0 40%;max-width:40%}
.graphic_logo_mobile.desktop-hidden,.desktop-hidden{ display: none;}
#solid-color-with-text-section{padding-top: 3rem;}

}
@media only screen and (max-width: 1500px) {
   
}
@media only screen and (max-width: 1200px) {
.saleHeading h2{font-size:7rem}
.featureDeals{font-size:82px}
.indepndence-dayText{font-size:29px}
.sectionTopBanner p{font-size:17px}
.people-img img{max-width:250px}
.sectionTopBanner p{padding:0 11px}
}
@media only screen and (max-width: 990px) {
.indepndence-dayText{font-size:30px}
.saleHeading h2{font-size:106px}
#solid-color-with-text-section .container{width:95%}
.sectionTopBanner p{font-size:17px}
#solid-color-with-text-section .v-col-sm-5{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}
.sectionGraphic{left:-58%;top:-39px;max-width:1030px}
.sectionTopBanner{padding-top:35px;padding-bottom:34px}



}

@media only screen and (max-width: 915px) and (orientation: landscape) {
 #solid-color-with-text-section  .desktop-hidden, #solid-color-with-text-section .mobile-hidden{ display: none;}
 #solid-color-with-text-section  .graphic_logo.mobile-hidden{ display: block;}
}

@media only screen and (max-width: 767px) {
#solid-color-with-text-section .v-col-sm-5{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}
.hidden-mobile{display:none}
.sectionGraphic{margin-bottom:10px;margin-top:10px}
.v-col-sm-6,.v-col-sm-8{-webkit-box-flex:0;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}
.order1{order:1}
.order2{order:2}
#solid-color-with-text-section{padding-bottom:0;margin-top:67px}
.sectionGraphic{display:none;position:static;max-width:1030px}
#solid-color-with-text-section .container{width:100%}
.v-col-sm-5.order2.pos-rel.largerZ{padding:0}
.sectionTopBanner p{
   font-size: 14px;
    margin-top: 12px;
    margin-bottom: 15px;
    max-width: 220px;
    margin-left: auto;
    margin-right: auto;}


.indepndence-dayText{font-size:42px;margin-top:0px}
.graphic_logo_mobile{ max-width: 380px; margin-left: auto; margin-right: auto; position: relative;margin-top: 40px;}
.sectionTopBanner{text-align:center;padding-top:25px;padding-bottom:20px;padding-left:1rem;padding-right:1rem;box-shadow:0 0 0 0 #00000029}
.saleHeading h2{
   font-size: 95px;
}
.saleHeading{ 
   position: relative;
   max-width: 350px;
    margin-left: auto;
    margin-right: auto; 
}
span.heading-price {
    margin-left: -14px !important;
}
img.img-fluid.leafOne {
    position: absolute;
    right: 0px;
    top: -7px;
    max-width: 45px;
}
img.img-fluid.leafTwo {
    position: absolute;
    left: 0px;
    top: 38px;
    max-width: 44px;
}
img.img-fluid.leafThree {
    position: absolute;
    right: 6px;
    bottom: -26px;
    max-width: 63px;
}
.indepence-inner{
   font-size: 16px; 
}

img.img-fluid.smallLeafImage {
   position: absolute;
    top: -77px;
    max-width: 60px;
    left: 10px;
}
.sectionTopBanner p br {
    display: none;
}

}
@media only screen and (max-width: 767px) and (orientation: landscape) {
 #solid-color-with-text-section   .graphic_logo.mobile-hidden{ display: none;}
 #solid-color-with-text-section .desktop-hidden, #solid-color-with-text-section .mobile-hidden{display: block;}
}

@media screen and (max-width:1499px){
   .graphic_logo {
      left: 45px;
   }
}
span.heading-price {
    margin-left: -20px;
}
</style>

<section id="solid-color-with-text-section">
   <div class="container xl-container">
      <div class="row-t text-center align-item-center justify-content-center pos-rel">
         <div class="v-col-sm-6 order1">
            <div class="sectionGraphic">
               <div class="medium-img" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/banner-home-page-fall-day-sale.jpg">
               <img class="blur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/thumb-banner-home-page-fall-day-sale.jpg);" alt="" class="img-fluid hidden-mobile">
               <noscript>
                     <img class="blur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/banner-home-page-fall-day-sale.jpg);" alt="" class="img-fluid hidden-mobile">
               </noscript>
            </div>
            </div>
         </div>
         <div class="v-col-sm-5 order2 pos-rel largerZ">
            <div class="sectionTopBanner">

               <div class="indepndence-dayText">
                  <div class="indepence-inner font-mont ">
                     Celebrate Fall With
                  </div>
               </div>
               <div class="saleHeading">
                  <h2 class=" font-alalisse">
                     Falling <br> P <span class="heading-price">rices</span> 
                  </h2>
                  <div class="hidden-desktop mobile-graphic-icons">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-one.png);" alt="" class="img-fluid leafOne">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-pine.png);" alt="" class="img-fluid leafTwo">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/discount-tag.png);" alt="" class="img-fluid leafThree">                  
                  </div>
               </div>
               <div class="graphic_logo mobile-hidden">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/graphic-falling-price-tag.png);" alt="" class="img-fluid">
               </div>

               <p class="font-mont">
                  But like leaves, we will pick<br class="desktop-hidden">
                   them<br class="mobile-hidden">
                  up in a few days so
                  <br class="desktop-hidden"> don’t wait!                  
               </p>

               <div class="graphic_logo_mobile desktop-hidden">
                 <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/leaf-three.png);" alt="" class="img-fluid smallLeafImage">                  
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fall-day-sale-2022/mobile-images/fall-sale-home-page-layout-mobile02.png);" alt="" class="img-fluid">
               </div>


               <a class="btn btn-primary-orange" href="/sale">SHOP  DEALS</a>
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