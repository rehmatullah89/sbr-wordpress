<style>
    #home-page-top-banner-section {
        display: none;
    }

    #sale-banner-section {
        margin-top: 0px;
        overflow: hidden;
    }

    #sale-banner-section .sleep-awareness-week-container {
        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/sleep-awareness-sale-page-desktop-banner.jpg");
        position: relative;
        min-height: 440px;
        /* min-height: 61vh; */
    }

    #sale-banner-section .pos-absolute {
        position: absolute;
        z-index: 12;
    }

   #sale-banner-section .mobile-image {
        max-width: 218px;
        top: 70px;
    }

    #sale-banner-section .impression-kit {
        max-width: 240px;
        max-width: 13vw;
        left: 183px;
        margin-top: 0px;
        top: -13px;
    }

    #sale-banner-section .mold-impression {
        max-width: 160px;
        max-width: 150px;
        transform: rotate(40deg);
        margin-top: 0px;
        width: 100%;
        bottom: -61px;
        margin-left: -12%;
    }

    #sale-banner-section .row-wrap {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
        justify-content: center;
        padding-top: 130px;
        position: relative;
    }

    #sale-banner-section .sleep-awareness-section,
    #sale-banner-section .save-discount-section {
        padding-left: 15px;
        padding-right: 15px;
        width: 100%;

    }

    #sale-banner-section .save-discount-section {
        max-width: 35vw;
        max-width: 410px;
        text-align: center;
        padding-top: 39px;
    }

    #sale-banner-section .save-discount-section h2 {
        margin: 0;
        font-size: 60px;
        font-weight: 800;
        color: #3c98cb;
        line-height: 60px;
    }

    #sale-banner-section .save-discount-section h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 400;
        color: #fff;
    }

    #sale-banner-section .sleep-awareness-section {
        max-width: 25vw;
   
    }

    #sale-banner-section .night-guard-kit-image {
        max-width: 600px;
        right: -90px;
        top: 40px;
    }

    #sale-banner-section .container-full {
        width: 90vw;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 12;

    }

    #sale-banner-section .sleep-text {
        position: relative;
        display: flex;
        max-width: 258px;
    }

    #sale-banner-section  span.moon-image {
        position: absolute;
        top: -14px;
        right: 0;
    }



    #sale-banner-section .sleep-awareness-section h1 {
        font-size: 60px;
        font-weight: normal;
        color: #fff;
        line-height: 1;
    }

    #sale-banner-section .sleep-awareness-section strong.weekText {
        font-weight: 800;
        font-size: 88px;
        letter-spacing: 10px;
    }

    #sale-banner-section span.stars {
        position: absolute;
        /* z-index: 22; */

    }


    #sale-banner-section  span.stars.starTwo {
        /* left: 739px; */
        bottom: 30px;
        left: 41%;
    }

    #sale-banner-section .clouds-bottom-strip {
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 12;
        display: none;
    }

    #sale-banner-section  span.stars.starThree {
        /* left: 739px; */
        top: 30px;
        left: 67%;
    }

    #sale-banner-section .starFour {
        top: 80px;
        left: 35%;
        max-width: 22px;
    }

    #sale-banner-section .starFive {
        top: 111px;
        left: 74%;
        max-width: 22px;
    }

    #sale-banner-section .starSix {
        top: -41px;
        left: 79px;
        max-width: 32px;
        width: 32px;
        opacity: 0.8;
    }



    @keyframes move-background {
        from {
            -webkit-transform: translate3d(0px, 0px, 0px);
        }

        to {
            -webkit-transform: translate3d(1000px, 0px, 0px);
        }
    }

    @-webkit-keyframes move-background {
        from {
            -webkit-transform: translate3d(0px, 0px, 0px);
        }

        to {
            -webkit-transform: translate3d(1000px, 0px, 0px);
        }
    }

    @-moz-keyframes move-background {
        from {
            -webkit-transform: translate3d(0px, 0px, 0px);
        }

        to {
            -webkit-transform: translate3d(1000px, 0px, 0px);
        }
    }

    @-webkit-keyframes move-background {
        from {
            -webkit-transform: translate3d(0px, 0px, 0px);
        }

        to {
            -webkit-transform: translate3d(1000px, 0px, 0px);
        }
    }

    #sale-banner-section  .clouds {
        width: 10000px;
        height: 100%;
        background: transparent url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/clouds_repeat_one.png") repeat;
        background-size: 1000px 1000px;
        background-size:contain;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 2;
        -moz-animation: move-background 100s linear infinite;
        -ms-animation: move-background 100s linear infinite;
        -o-animation: move-background 100s linear infinite;
        -webkit-animation: move-background 100s linear infinite;
        animation: move-background 100s linear infinite;
        opacity: .9;
        /* background-blend-mode: multiply;
  background-color: #011f41; */
    }


    #sale-banner-section  .star {
        color: #ffffff3d;
        animation-name: blink;
        animation-duration: 2s;
        animation-iteration-count: infinite;
        position: absolute;
        z-index: 2;
        ;
    }

    @keyframes blink {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }



    #sale-banner-section .pos1 {
        left: 25%;
        bottom: 72px;
        max-width: 22px;
    }

    #sale-banner-section .pos4 {
        left: 24%;
        top: 150px;
        max-width: 22px;
    }

    #sale-banner-section .pos5 {
        left: 30%;
        top: 40%;
        max-width: 22px;
    }

    #sale-banner-section .pos6 {
        left: 50%;
        bottom: 145px;
        max-width: 22px;
    }

    #sale-banner-section .pos7 {
        left: 60%;
        top: 25%;
        max-width: 22px;
    }

    #sale-banner-section .pos8 {
        right: 8%;
        top: 87px;
        max-width: 30px;
    }


    #sale-banner-section .pos9 {
        right: 30%;
        bottom: 20px;
        max-width: 22px;
    }

    #sale-banner-section .s1 {
        top: 150px;
        left: 50%;
    }

    #sale-banner-section  .s2 {
        top: 219px;
        left: 20%;
    }

    #sale-banner-section  .s3 {
        top: 150px;
        right: 30%;
    }

    #sale-banner-section .s4 {
        bottom: 250px;
        left: 16%;
    }

    #sale-banner-section  .s5 {
        bottom: 100px;
        left: 30%;
    }

    #sale-banner-section .s6 {
        top: 150px;
        left: 50%;
    }

    #sale-banner-section .s7 {
        bottom: 150px;
        left: 70%;
    }

    #sale-banner-section  .s8 {
        bottom: 100px;
        left: 50%;
    }

    #sale-banner-section .s9 {
        top: 50px;
        right: 15%;
    }

    #sale-banner-section .s10 {
        bottom: 100px;
        right: 15%;
    }

    #sale-banner-section .btn-primary-teal{
        background-color: #3c98cb;
         border-color: #3c98cb;
    }
    #sale-banner-section .btn-primary-teal:hover{
        background-color: #595858;
    border-color: #595858;
    }

    @media only screen and (max-width: 1800px)  {
        #sale-banner-section .night-guard-kit-image{
            max-width: 540px;
        }   
    }

    @media only screen and (max-width: 1750px)  {
        #sale-banner-section  .save-discount-section h2 {
            /* background-color: blue; */
        }
 
        #sale-banner-section .night-guard-kit-image{
            max-width: 500px;;
        }

        #sale-banner-section .mobile-image {
            max-width: 177px;
            top: 80px;
        }
    }

    @media only screen and (max-width: 1550px)  {
        #sale-banner-section .night-guard-kit-image{
            max-width: 440px;
            top: 108px;
        }

    }

    @media only screen and (max-width: 1300px)  {
        #sale-banner-section .save-discount-section h2 {

            font-size: 48px;
        }
        #sale-banner-section .night-guard-kit-image{
            max-width: 397px;
        }

        #sale-banner-section .save-discount-section h3{
            font-size: 32px;
        }
        #sale-banner-section  .night-guard-kit-image{
            max-width: 330px;
        }
        #sale-banner-section .sleep-awareness-section h1{
            font-size: 38px;
        }
        #sale-banner-section .sleep-awareness-section strong.weekText{
            font-size: 62px;
        }
        #sale-banner-section .mobile-image {
            max-width: 180px;
        }

        #sale-banner-section span.moon-image {
            top: -3px;
            right: 94px;
            max-width: 42px;
        }
        #sale-banner-section .impression-kit {   
            max-width: 16vw;
            left: 88px;
        }
        #sale-banner-section  .mold-impression{
            bottom: -154px;
            margin-left: -3%;
        }
    }


    @media only screen and (max-width: 991px)  {
        #sale-banner-section .save-discount-section h2 {
            /* background-color: orange; */
            font-size: 40px;
        }
        #sale-banner-section .save-discount-section h3 {
            font-size: 26px;
        }
        #sale-banner-section  .mobile-image {
             max-width: 110px;
        }
        #sale-banner-section .row-wrap{
            padding-top: 114px;
        }

        #sale-banner-section  .sleep-awareness-section h1 {
            font-size: 28px;
        }
        .sleep-awareness-section strong.weekText {
            font-size: 38px;
        }        

        #sale-banner-section .sleep-awareness-week-container {
            min-height: 337px;
        }        

        #sale-banner-section span.moon-image {
            top: -10px;
            right: 39px;
        }
        #sale-banner-section  .night-guard-kit-image{
            top: 58px;
            max-width: 280px;
        }
        #sale-banner-section  span.stars {
         max-width: 22px;
        }
        #sale-banner-section .impression-kit {
            max-width: 16vw;
            left: 61px;
            margin-top: 0px;
        }
        #sale-banner-section .starSix {
            top: -20px;
            left: 42px;
        }
        #sale-banner-section .mold-impression {
            bottom: -136px;
            margin-left: -10%;
            max-width: 133px;
        }        

    }
    @media only screen and (max-width: 767px)  and (orientation:portrait){
        #sale-banner-section .sleep-awareness-week-container{
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/sleep-awareness-home-banner-mobile.jpg");
            background-size: cover;
        }
    }
    @media only screen and (max-width: 767px)  {
        #sale-banner-section .sleep-awareness-section strong.weekText {
            font-size: 34px;
        }
        #sale-banner-section .sleep-awareness-section{
            padding-top: 110px;
        }
        #sale-banner-section .save-discount-section{
            margin-top: 7px;    padding-top: 15px;
        }
        #sale-banner-section {
            margin-top: -11px;
        }

        #sale-banner-section .save-discount-section h2 {
            /* background-color: black; */
            font-size: 34px;
            line-height: 1;
        }
        #sale-banner-section .save-discount-section h3 {
            font-size: 20px;
        }
        #sale-banner-section .mobile-image{
            max-width: 92px;
            left: -21px;    top: 32px;
        }

        #sale-banner-section .impression-kit {
            max-width: 35vw;
            left: initial;
            margin-top: -7px;
            top: 0;
            right: -20px;
            transform: rotate(132deg);
        }
        #sale-banner-section  .night-guard-kit-image {
            max-width: 280px;
            top: initial;
            bottom: -47px;
        }
        #sale-banner-section .row-wrap {
            padding-top: 10px;
        }        
        #sale-banner-section  .sleep-awareness-section {
            max-width: 68%;
        }

        #sale-banner-section .sleep-awareness-week-container {
            min-height: 448px;
        }

        #sale-banner-section .mold-impression {
            max-width: 90px;
            bottom: -110px;
            top: initial;
            left: 54px;
        }
        #sale-banner-section  .clouds{

            background-size: contain;
        }
        #sale-banner-section .sleep-text{
            left: -33px;
            display: inline-block;
            min-width: 143px;

        }
        #sale-banner-section span.moon-image {
            top: -12px;
            right: -14px;
        }
        #sale-banner-section span.stars.starThree,span.stars.starOne{
            display: none;
        }
    }
    /* 767 ends */
    @media only screen and (max-width: 2199px) and (min-width: 1999px) {
        #sale-banner-section  .save-discount-section h2 {
            /* background-color: lightblue; */
        }
        #sale-banner-section  .night-guard-kit-image{
            max-width: 670px;            
        }
        #sale-banner-section .mobile-image{
            max-width: 272px;
        }
    }

    @media only screen and (max-width: 2499px) and (min-width: 2200px) {
        #sale-banner-section  .save-discount-section h2 {
            /* background-color: red; */
        }

        #sale-banner-section  .night-guard-kit-image{
            max-width: 730px;            
        }
        #sale-banner-section  .mobile-image{
            max-width: 272px;
        }


        #sale-banner-section .save-discount-section h3{
            font-size: 54px;
        }
        #sale-banner-section  .sleep-awareness-section h1 {
                font-size: 80px;
            }
            #sale-banner-section .night-guard-kit-image{
            max-width: 730px;            
        }
        #sale-banner-section  .mobile-image{
            max-width: 272px;
        }
        #sale-banner-section .sleep-awareness-section strong.weekText{
            font-size: 121px;
        }
        #sale-banner-section span.moon-image {
            top: -10px;
            right: -51px;
        }        
        #sale-banner-section  .save-discount-section{
            max-width: 520px;
        }
        #sale-banner-section  .sleep-awareness-section {
            max-width: 22vw;
        }



    }


    @media only screen and (max-width: 3200px) and (min-width: 2500px) {
        #sale-banner-section .sleep-awareness-week-container{
            background-size: 100%;
        }
        #sale-banner-section  .save-discount-section h2 {
            /* background-color: black; */
            font-size: 80px;
        }
        #sale-banner-section .save-discount-section h3{
            font-size: 54px;
        }
        #sale-banner-section .sleep-awareness-section h1 {
                font-size: 80px;
            }
            #sale-banner-section .night-guard-kit-image{
            max-width: 730px;            
        }
        #sale-banner-section .mobile-image{
            max-width: 272px;
        }
        #sale-banner-section  .sleep-awareness-section strong.weekText{
            font-size: 121px;
        }
        #sale-banner-section  span.moon-image {
            top: -10px;
            right: -51px;
        }        
        #sale-banner-section .save-discount-section{
            max-width: 520px;
        }
        #sale-banner-section .sleep-awareness-section {
            max-width: 22vw;
        }


    }



</style>

<section id="sale-banner-section">
    <div class="sleep-awareness-week-container">

        <div class="star s1">*</div>
        <div class="star s2">*</div>
        <div class="star s3">*</div>
        <div class="star s4">*</div>



        <div class="clouds"></div>
       
        <span class="stars starTwo"> <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/star.png"
                alt="" /></span>
        <span class="stars starThree"> <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/star.png"
                alt="" /></span>
        <span class="stars starFour"> <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/star.png"
                alt="" /></span>



        <div class="mobile-image pos-absolute">
            <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/phone.png"
                alt="" />
        </div>
        <div class="container-full">
            <div class="row-wrap">
                <div class="sleep-awareness-section">
                    <h1>
                        <div class="sleep-text"> Sleep
                            <span class="moon-image">
                                <img class="moon-bubble-animation"
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/moon.png"
                                    alt="" />

                                <span class="stars starSix"> <img class=""
                                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/star.png"
                                        alt="" /></span>
                            </span>

                        </div>Awareness<br>

                        <strong class="weekText">WEEK</strong>
                    </h1>

                    <div class="mold-impression pos-absolute">
                        <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/mold.png"
                            alt="" />
                    </div>

                    <div class="impression-kit pos-absolute">
                        <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/Impression.png"
                            alt="" />
                    </div>
                </div>

                <div class="save-discount-section">
                    <h2>Save 15%</h2>
                    <h3>on Night Guards</h3>
                </div>
            </div>
        </div>

        <div class="night-guard-kit-image pos-absolute">
            <img class=""
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/sleep-awareness-march/night-guard-kit.png"
                alt="" />
        </div>






    </div>
</section>

<script>


    // variables declarations
    var i;
    var stars = document.getElementsByClassName("star").length;
    var width = document.documentElement.clientWidth;
    var height = document.documentElement.clientHeight;

    // Use a for loop to assign unique random values for the x and y positions
    for (i = 0; i < stars; i++) {
        var x = Math.floor(Math.random() * width);
        var y = Math.floor(Math.random() * height);
        var speed = Math.floor(Math.random() * 10) + 1; // Ensure speed is at least 1

        // document.getElementsByClassName("star")[i].style.transform = "translate(" + x + "px, " + y + "px)";
        // document.getElementsByClassName("star")[i].style.animationDuration = speed + "s";
    }


    $(function () {
        setInterval(function () {
            // $('.starTwo,.starSix').fadeIn(120).delay(1920).fadeOut(120);
            // $('.starThree').fadeIn(300).delay(1200).fadeOut(150).delay(800);
            // $('.starFour').fadeIn(300).delay(700).fadeOut(160).delay(1350);
            // $('.starFive').fadeIn(150).delay(900).fadeOut(160).delay(1350);
        }, 1);
    });

</script>