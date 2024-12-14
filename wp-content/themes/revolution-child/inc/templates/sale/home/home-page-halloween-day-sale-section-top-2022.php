<style>
@font-face {
    font-family: 'Magnificent Serif';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/magnificent/Magnificent-Serif.woff2') format('woff2'),
        url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/magnificent/Magnificent-Serif.ttf') format('ttf');
    font-weight: normal;
    font-style: normal;

}

.row-t {
    /* align-items:center; */
    margin-left: -15px;
    margin-right: -15px;
    display: flex;
}

#solid-color-with-text-section {
    position: relative;
    margin-top: 83px;
    overflow: hidden;
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
    padding: 0rem 0 3rem 0;
    background-position-y: top;
    padding-top: 0px;
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

.Magnificent_Serif {
    font-family: 'Magnificent Serif';
}

#solid-color-with-text-section .sectionRightText {
    color: #fff;
    text-align: left;
    position: relative;
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
    width: 60%;
    margin-top: 30px;
    position: relative;
    z-index: 9;
}

.product-img {
    position: absolute;
    left: 0;
    top: 40px;
}

.product-img img:not(.cat-eye-one) {
    max-width: 130%;
    position: relative;
    z-index: 12;

}
img.blackTree.animatedTree {
    max-width: 100%;
    position: absolute;
    left: -120px;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    top: -4px;
}
.mobile-icons {
    display:none;
}
#solid-color-with-text-section .medium-img {
    /* max-width: 94%;     */
    /* margin-left: auto; */
}

.cat-eye {
    position: absolute;
    left: -65px;
    bottom: 40px;
}

.sectionRightBanner {
    padding: 0px 60px;
    width: 45%;
    padding-bottom: 102px;
}

#solid-color-with-text-section .sectionRightText .arrow-person-img img {
    margin-top: 60px;
}

#solid-color-with-text-section .sectionRightText .arrow-person-img {
    width: 200px;
    position: relative;
    left: 20%;    left: 28%;
    margin-bottom: 25px;
}

#solid-color-with-text-section .sectionRightText .text-detail {
    text-align: center;
    position: relative;
    z-index: 9;
}

#solid-color-with-text-section .sectionRightText .text-detail h4 {
    color: #fff;
    margin-bottom: 10px;
    font-size: 36px;
    font-weight: 600;
}

#solid-color-with-text-section .sectionRightText .bottom-images {
    position: absolute;
    margin-top: -99px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: left;
    /* height: 140px; */
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    max-width: 96%;
}
.shopDealsButtonWithImages {
    text-align: center;
    position: relative;
    top: 63px;
    z-index: 12;
}
.shopDealsButtonWithImages::before{
    content: '';
    background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-right-one.png);
    width: 80px;
    height: 53px;
    position: absolute;
    left: 60px;
    top:0;
    -webkit-animation: blink 2s infinite;
}

.shopDealsButtonWithImages::after{
    content:'';
    background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-right-two.png);
    position: absolute;    
    width: 175px;
    height: 77px;
    right: -51px;
    top:0;  
    -webkit-animation: blink 2s infinite;  
}
.shopeDealButton a {
    background: #fd9c01;
    color: #fff;
    text-transform: uppercase;
    font-weight: 500;
}

.bottom-right-imgs {
    position: relative;
    top: 68px;
}

#solid-color-with-text-section .sectionRightText .text-detail h1 {
    color: #000;
    margin-bottom: 25px;
    font-size: 72px;
    font-weight: 500;
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
    padding: 20px 10px;
}



.strong-hover-shake:hover {
  animation: tilt-shaking 0.15s infinite;
}

.gentle-hover-shake:hover {
  animation: tilt-shaking 0.25s infinite;
}

.gentle-tilt-move-shake:hover {
  animation: tilt-n-move-shaking 0.25s infinite;
}

.strong-tilt-move-shake:hover {
  animation: tilt-n-move-shaking 0.15s infinite;
}

.constant-tilt-shake {
  animation: tilt-shaking 0.3s infinite;
}

.vertical-shake {
  animation: vertical-shaking 0.35s infinite;
}

.horizontal-shake {
  animation: horizontal-shaking 0.35s infinite;
}

.rise-shake {
  animation: jump-shaking 0.83s infinite;
}

.skew-shake-x {
  animation: skew-x-shake 1.3s infinite;
}

.skew-shake-y {
  animation: skew-y-shake 1.3s infinite;
}
.blink{
-webkit-animation: blink 2s infinite;
}

@keyframes tilt-shaking {
  0% { transform: rotate(0deg); }
  25% { transform: rotate(5deg); }
  50% { transform: rotate(0eg); }
  75% { transform: rotate(-5deg); }
  100% { transform: rotate(0deg); }
}

@keyframes tilt-n-move-shaking {
  0% { transform: translate(0, 0) rotate(0deg); }
  25% { transform: translate(5px, 5px) rotate(5deg); }
  50% { transform: translate(0, 0) rotate(0eg); }
  75% { transform: translate(-5px, 5px) rotate(-5deg); }
  100% { transform: translate(0, 0) rotate(0deg); }
}

@keyframes vertical-shaking {
  0% { transform: translateY(0) }
  25% { transform: translateY(15px) }
  50% { transform: translateY(-15px) }
  75% { transform: translateY(15px) }
  100% { transform: translateY(0) }
}
@keyframes vertical-shaking-tree {
  0% { transform: translateY(0) }
  25% { transform: translateY(35px) }
  50% { transform: translateY(-5px) }
  75% { transform: translateY(35px) }
  100% { transform: translateY(0) }
}



@keyframes horizontal-shaking {
  0% { transform: translateX(0) }
  25% { transform: translateX(5px) }
  50% { transform: translateX(-5px) }
  75% { transform: translateX(5px) }
  100% { transform: translateX(0) }
}

@keyframes jump-shaking {
  0% { transform: translateX(0) }
  25% { transform: translateY(-9px) }
  35% { transform: translateY(-9px) rotate(17deg) }
  55% { transform: translateY(-9px) rotate(-17deg) }
  65% { transform: translateY(-9px) rotate(17deg) }
  75% { transform: translateY(-9px) rotate(-17deg) }
  100% { transform: translateY(0) rotate(0) }
}

@keyframes skew-x-shake {
  0% { transform: skewX(-5deg); }
  5% { transform: skewX(5deg); }
  10% { transform: skewX(-5deg); }
  15% { transform: skewX(5deg); }
  20% { transform: skewX(0deg); }
  100% { transform: skewX(0deg); }  
}

@keyframes skew-y-shake {
  0% { transform: skewY(-15deg); }
  5% { transform: skewY(15deg); }
  10% { transform: skewY(-15deg); }
  15% { transform: skewY(15deg); }
  20% { transform: skewY(0deg); }
  100% { transform: skewY(0deg); }  
}
@-webkit-keyframes blink {
0%, 100% {
    transform: scale(1, .05);
}
5%,
95% {
    transform: scale(1, 1);
}
}

.arrow-person-img.horizontal-shake{
    animation: horizontal-shaking 4s infinite;
}

.bottom-right-imgs.vertical-shake {
    animation: vertical-shaking 10s infinite;
}

.blackTreeBack.constant-tilt-shake {
    animation: tilt-shaking 15s infinite;
}

.blackTreeBack.vertical-shake {
    animation: vertical-shaking-tree 30s infinite;
}

.bottom-left-imgs.horizontal-shake {
    animation: horizontal-shaking 5s infinite;
}
.bottom-left-imgs {
position: relative;
z-index: 0;
}
@media only screen and (min-width: 768px) {
    .hidden-desktop {
        display: none
    }
}

@media (max-width: 1299px) {
    .sectionRightBanner {
        padding-bottom: 88px;
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

@media (max-width: 1499px) {
    #solid-color-with-text-section .sale-content-section-left {
        margin-top: 130px;
    }

    .bottom-right-imgs {
        position: relative;
        top: 45px;
    }

    .bottom-left-imgs {
        position: relative;
        left: -30px;
    }

    .right-img-logo {
        background-position-y: 28px !important;
    }

    .sectionRightBanner {
        padding: 0px 60px 88px 60px;
    }
    .cat-eye {
    left: -70px;
}
.product-img {
    position: absolute;
    left: 15px;
    top: 100px;
}
.product-img img:not(.cat-eye-one) {
    max-width: 130%;
    margin-top: -110px;
    margin-left: 0px;
}
.shopDealsButtonWithImages::before{
    left: 0px;
}
.shopDealsButtonWithImages::after {
    right: -106px;
    top: -10px;
}
img.blackTree.animatedTree {
    left:75px;
}
}

@media (min-width: 1700px) {
    #solid-color-with-text-section .sale-content-section-left h1 {
        /* color: purple; */
    }
}
@media (max-width: 1230px) {
    .product-img img:not(.cat-eye-one) {
    margin-top: -45px;
    margin-left:-60px;
}
.cat-eye {
    left: 93px;
}
 .product-img img:not(.cat-eye-one) {
    max-width: 130%;
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
        min-width: 560px;
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
        padding:0rem 0rem 2rem 0rem;
    }
    .sectionRightBanner {
        padding: 0px 60px 95px 60px;
    }
    #solid-color-with-text-section .medium-img {
        min-height: 318px;
    }
    .right-img-logo {
    background-position-y: -10px !important;
}

}

@media only screen and (max-width: 992px) { 
    .bottom-left-imgs {
    position: relative;
    left: -50px;
    top: 3px;
    }
    .hidden-mobile {
        display: block !important;
    }
    .background-img {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Ground1.png') !important;
    }
    .eye1 {
    position: absolute;
    top: 35px;
    left: 5%;
}
#solid-color-with-text-section .sectionRightText .text-detail h4 {
    margin-bottom:0px;
    margin-top:10px;
}
.bottom-right-imgs {
    left: 20px;
}
#solid-color-with-text-section .sectionRightText .text-detail h4 {
    font-size: 28px;
    font-weight: 500;
}
#solid-color-with-text-section .sectionRightText .text-detail h1 {
    margin-top:5px;
}
#solid-color-with-text-section .sectionRightText .bottom-images {
    max-width:80%;
}
.eye2 {
    position: absolute;
    top: 65%;
    left: 25%;
}
.eye3 {
    position: absolute;
    right: 13%;
    top: 21%;
}
.eye4 {
    position: absolute;
    right: 4%;
    top: 46%;
}
    .mobile-icons {
    display: block;
}
    .sectionRightBanner {
    min-width: 450px;
}
.shopDealsButtonWithImages::before {
    width: 55px;
    display:none;
}
.shopDealsButtonWithImages::after {
    display:none;
}
.shopeDealButton a {
    z-index: 20;
    position: relative;
}
    .row-t {
        flex-wrap: wrap;
    }

    #solid-color-with-text-section .sale-content-section-left {
        display:none;
        text-align: center;
        max-width: 100%;
        padding-left: 15px;
        padding-right: 15px;
    }
    #solid-color-with-text-section .sectionRightText .text-detail h1 {
        margin-bottom:0px;
    }
    #solid-color-with-text-section .sale-content-section-left h1 {
        font-size: 60px;
    }
    #solid-color-with-text-section .sectionRightText .arrow-person-img {
    width: 130px;
    position: relative;
    left: 20%;
    margin-bottom: -2px;
}
#solid-color-with-text-section .sectionRightText .arrow-person-img img {
    padding-top:20px;
    margin-top:0px;
}
.shopDealsButtonWithImages {
    top: 60px;
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
        padding-bottom:50px;
        line-height: 1.3;
    }

    #solid-color-with-text-section .medium-img {
        min-height: 245px;
        display:none !important;
    }

    #solid-color-with-text-section {
        margin-top: 80px;
    }

    .mobileimage {
        margin-top: 0px;
        margin-left: 1rem;
        margin-right: 1rem;
    }

}
@media only screen and (min-width:992px) and (max-width:1180px) {

    .product-img img:not(.cat-eye-one) {
        max-width: 130%;
    }
.blackTreeBack.vertical-shake {
    display: none;
}
.cat-eye {
    display:none;
    bottom: -40px;
    left: 93px;
}
.right-img-logo {
 background-position-y: 0px !important;
}

}

@media screen and (min-width:1024px) and (max-width:1180px){
    .product-img img:not(.cat-eye-one) {
    margin-left: -15px;
    margin-top: -15px;
}
}
@media screen and (min-width:992px) and (max-width:1023px){
    .product-img img:not(.cat-eye-one) {
    margin-left: -35px;
    margin-top: 90px;
}
}

@media screen and (min-width:768px)and (max-width:992px){
    .bottom-left-imgs {
    position: relative;
    left: -50px;
    top: 25px;
}
#solid-color-with-text-section {
    margin-top:130px;
}
.right-img-logo {
     background-position-y: 0px !important;
}
.sectionRightBanner {
    padding: 0px 60px 95px 60px;
}
}
@media screen and (min-width:376px) and (max-width:420px){
    .bottom-left-imgs {
    position: relative;
    left: -65px;
    top: 3px;
}
}

@media screen and (max-width:767px){
    #solid-color-with-text-section{
        margin-top: 50px;
    }
}
</style>



<section id="solid-color-with-text-section">
    <div class="sectionWrapper" style="background-color:#8989ab;">
        <div class="container xl-container">
            <div class="row-t text-center align-item-center justify-content-center pos-rel">
                <div class="sale-content-section-left">
                    <div class="product-img">
                        <div class="blackTreeBack vertical-shake">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/black-tree.png);"
                            alt="" class="blackTree animatedTree">                        
                        </div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Products [OLD].png);"
                            alt="" class="img-fluid hidden-mobile">

                        <div class="cat-eye rise-shake">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-left-one.png);"
                                alt="" class="img-fluid cat-eye-one">
                        </div>

                    </div>

                    <!-- <h1>
                            HALLOWEEN DAY SALE
                    </h1>
                    <div class="nopremeMember">
                        No Prime membership? No problem, its open to all! | <span style="color:#fff">Oct 10-13.</span>
                    </div> -->

                    <div class="sectionRightText hidden-desktop text-center">

                        <!-- <p>
                            Get a head start this holiday<br>
                            shopping season & save up to <span style="font-weight:700;">50%</span><br>
                            plus never before seen <span style="font-weight:700;">BOGO</span> deals!

                        </p> -->
                    </div>

                    <!-- <a class="btn btn-primary-orange" href="/sale">SHOP DEALS</a> -->
                </div>

                <div class="sectionRightBanner">

                    <div class="medium-img hidden-mobile"
                        data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png">
                        <!-- <img class="blur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/thumb-early-prime-day-product-banner.png);" alt="" class="img-fluid hidden-mobile"> -->
                        <noscript>
                            <img class="blur"
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png);"
                                alt="" class="img-fluid hidden-mobile">
                        </noscript>
                    </div>

                    <div class="hidden-desktop mobileimage">
                        <!-- <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/mobile-early-prime-day-product-banner.jpg);" alt="" class="img-fluid hidden-mobile"> -->
                    </div>
                    <div class="sectionRightText hidden-mobile">
                        <div class="right-img-logo"
                            style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/Grey-Icons.png);background-size: contain;background-repeat: no-repeat;background-position-y: 0px"
                            alt="" class="img-fluid hidden-mobile" )>

                            <div class="arrow-person-img horizontal-shake">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/Witch1.png);"
                                    alt="" class="img-fluid hidden-mobile">
                            </div>

                            <div class="text-detail">
                                <h4>Got a sweet</h4>
                                <h1 class="Magnificent_Serif">TOOTH?</h1>
                                <p>Snack with comfort knowing <br>Smile Brilliant cariPRO™ products <br> will defend
                                    your teeth this Halloween! </p>
                            </div>

                            <div class="bottom-images">
                                <div class="bottom-left-imgs skew-shake-x">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/Pumpkin.png);"
                                        alt="" class="img-fluid hidden-mobile" alt="">

                                </div>
                                <div class="bottom-right-imgs vertical-shake">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/cat-sitting.png);"
                                        alt="" class="img-fluid hidden-mobile" alt="">

                                </div>
                            </div>


                                <div class="shopDealsButtonWithImages">
                                    <div class="shopeDealButton">
                                        <a class="btn btn-primary-yellow" href="/sale" rel="nofollow">Shop Deals</a>
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="background-img" style=" background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/Ground.png);background-size: cover;
    background-position: inherit;background-repeat: no-repeat; width:100%;height:170px; position:absolute; bottom:0 ">
    <div class="mobile-icons">
        <div class="eye1">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-left-one.png" alt="" srcset="">
        </div>
        <div class="eye2">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-left-one.png" alt="" srcset="">
        </div>
        <div class="eye3">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-left-one.png" alt="" srcset="">
        </div>
        <div class="eye4">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-left-one.png" alt="" srcset="">
        </div>
    </div>
    </div>
</section>



<script>

// $(document).ready(function() {
//     $(".animationText").css('opacity',1).lettering('words').children("span").lettering().children("span").lettering(); 
// })

</script>