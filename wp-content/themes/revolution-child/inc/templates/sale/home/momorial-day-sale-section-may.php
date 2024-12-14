<style>
    section#solid-color-with-text-section {
        min-height: 580px;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        margin-top: 92px;
        position: relative;
        overflow: hidden;
        position: relative;
        z-index: 12;
    }

    section#solid-color-with-text-section .container {
        max-width: 1170px;
        padding-left: 15px;
        padding-right: 15px;
        margin-left: auto;
        margin-right: auto;
    }


    div#home-page-top-banner-section {
        display: none !important;
    }


    section#solid-color-with-text-section .content {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        position: relative;
    }

    section#solid-color-with-text-section .momorial-sale-left,
    section#solid-color-with-text-section .momorial-sale-right {
        flex: 1;
        padding: 20px;
    }

    section#solid-color-with-text-section .sale-text-sec {
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    section#solid-color-with-text-section .flag-left {
        max-width: 150px;
        display: block;
        margin: 0 auto 0px;
    }

    section#solid-color-with-text-section .sale-text h1 {
        font-size: 36px;
        color: #003366;
        text-align: center;
        margin: 0;
    }


    section#solid-color-with-text-section .discount {
        font-size: 48px;
    }

    section#solid-color-with-text-section .momorial-sale-right p {
        font-size: 16px;
        color: #333;
        margin: 0;
    }

    /* Stars */
    .sale-banner::before,
    .sale-banner::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .sale-banner::before {
        height: 115%;
    }



    .sale-banner::after {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/pollygon-right.png');
        right: 0px;
        top: 0px;
        background-repeat: no-repeat;
        background-position: right;
        /* transform: rotate(195deg);
        background-size: 1400px; */

    }

    .sale-banner::before {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/pollygon-left.png');

        top: initial;
        left: 0px;
        bottom: 0px;
        background-repeat: no-repeat;
    }



    @keyframes move-in-circle {
        0% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(3deg);
        }



        100% {
            transform: rotate(0deg);
        }
    }




    @keyframes move-in-circle-2 {
        0% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(3deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }





    /* @keyframes move-in-circle-3 {
        0% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(30deg);
        }

        75% {
            transform: rotate(15deg);
        }

        100% {
            transform: rotate(0deg);
        }
    } */

    .sale-banner::before {
        animation: move-in-circle 4s linear infinite;
    }

    .sale-banner::after {
        animation: move-in-circle-2 4s linear infinite;
    }

    .star-one {
        animation: move-in-circle-3 10s linear infinite;
    }

    @keyframes move-in-circle-3 {
        0% {
            transform: rotate(0deg);
        }

        50% {
            transform: rotate(90deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .strr1,
    .strr7,
    .strr3 {
        animation: move-in-circle-4 10s linear infinite;
    }

    @keyframes move-in-circle-4 {
        0% {
            transform: rotate(90deg);
        }

        50% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(90deg);
        }
    }



 


    section#solid-color-with-text-section .sale-wrapper {
        position: relative;
        width: 100%;
        z-index: 123;
    }

    section#solid-color-with-text-section .flag-curve-right {
        position: absolute;
        right: 0;
        z-index: 1;
        top: 0;
    }


    section#solid-color-with-text-section .sale-text-content {
        background: #003563;
        display: flex;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 1rem;
        border-radius: 15px;
        color: #fff;
    }

    section#solid-color-with-text-section .day-sale-text {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }

    section#solid-color-with-text-section .star-bx-1,
    section#solid-color-with-text-section .star-bx-2 {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/star-red.svg');
        width: 34px;
        height: 34px;
        background-repeat: no-repeat;
        background-size: contain;
    }

    section#solid-color-with-text-section .star-bx-2 {
        width: 20px;
        height: 20px;
    }

    section#solid-color-with-text-section .star-red,
    section#solid-color-with-text-section .star-blue {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/star-red.svg');
        background-repeat: no-repeat;
        background-size: contain;
    }

    section#solid-color-with-text-section .star-blue {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/star-blue.svg');
    }

    section#solid-color-with-text-section .momorial-sale-left {
        position: relative
    }

    section#solid-color-with-text-section .star-one {
        position: absolute;
    }

    section#solid-color-with-text-section .strr1 {
        width: 160px;
        height: 160px;
        left: 0;
    }

    section#solid-color-with-text-section .strr2 {
        width: 60px;
        height: 60px;
    }

    section#solid-color-with-text-section .strr3 {
        width: 40px;
        height: 40px;
        left: 20px;
        top: 40px;
    } 

    section#solid-color-with-text-section .strr4 {
        width: 66px;
        height: 66px;
        bottom: 50%;
        left: 49px;
    }

    section#solid-color-with-text-section .strr6 {
        top: 74px;
    }

    section#solid-color-with-text-section .momorial-day-text {
        font-size: 60px;
        line-height: 0.9;
        font-weight: 500;
    }

    section#solid-color-with-text-section span.day-sale-ibt {
        font-size: 50px;
        line-height: 0.9;
        min-width: 52%;
    }

    section#solid-color-with-text-section .sale-text {
        font-weight: 800;
        text-transform: uppercase;
        font-size: 124px;
        line-height: 0.9;
    }

    section#solid-color-with-text-section .momorial-sale-right {
        max-width: 430px;
        text-align: center;
    }

    section#solid-color-with-text-section span.discount {
        color: #ef3327;
        font-size: 126px;
        font-weight: 800;
    }

    section#solid-color-with-text-section .right-wrapper-content h2 {
        display: flex;
        align-items: center;
        font-weight: 800;
        justify-content: center;
        line-height: 1;
        margin: 0;
        color: #ef3327;
    }

    section#solid-color-with-text-section span.textUpto,
    section#solid-color-with-text-section span.textOff {
        font-size: 35px;
    }

    section#solid-color-with-text-section span.textOff div {
        font-size: 170%;
    }

    section#solid-color-with-text-section .right-wrapper-content p {
        color: #141414;
        font-size: 26px;
        line-height: 1.3;
        font-weight: 500;
        position: relative;
    }

    section#solid-color-with-text-section a.button.btn {
        background: #dd362c;
        border: 0;
        text-transform: uppercase;
        color: #fff;
        font-weight: 500;
        font-family: "Montserrat";
    }

    section#solid-color-with-text-section a.button.btn:hover {
        background: #003563;
    }

    section#solid-color-with-text-section .button-tshop {
        margin-top: 30px;
    }

    .usa-flag-middle {
        position: relative;
        max-width: 220px;
        margin-left: auto;
        margin-right: auto;
    }

    .strr5 {
        width: 40px;
        height: 40px;
        right: 0%;
    }

    .strr6 {
        width: 40px;
        height: 40px;
        right: 0%;
    }

    .strr7 {
        width: 80px;
        height: 80px;
        right: -28%;
        top: 31px;
    }

    .strr9 {
        height: 180px;
        width: 180px;
        right: 7%;
        bottom: 17px;
        z-index: 1;
    }

    .flag-bottom {
        position: absolute;
        left: -180px;
        top: 352px;
        max-width: 450px;
    }

    .stars-animate {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-size: cover;
        animation: animateBg 50s linear infinite;
    }

    @keyframes animateBg {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }
    }

    .stars-animate span {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 4px;
        height: 4px; 
        background: #fff;
        border-radius: 50%;

        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1), 0 0 0 8px rgba(255, 255, 255, 0.1), 0 0 20px rgba(255, 255, 255, 0.1);
        animation: animate 3s linear infinite;
    }

    .stars-animate span::before {
        content: '';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 300px;
        height: 1px;
        background: linear-gradient(90deg, #3b97ca69, transparent);
    }

    @keyframes animate {
        0% {
            transform: rotate(315deg) translateX(0);
            opacity: 1;
        }

        70% {
            opacity: 1;
        }

        100% {
            transform: rotate(315deg) translateX(-1000px);
            opacity: 0;
        }
    }

    .stars-animate span:nth-child(1) {
        top: 0;
        right: 0;
        left: initial;
        animation-delay: 0s;
        animation-duration: 1s;
    }

    .stars-animate span:nth-child(2) {
        top: 0;
        right: 80px;
        left: initial;
        animation-delay: 0.2s;
        animation-duration: 3s;
    }

    .stars-animate span:nth-child(3) {
        top: 80;
        right: 0px;
        left: initial;
        animation-delay: 0.4s;
        animation-duration: 2s;
    }

    .stars-animate span:nth-child(4) {
        top: 0;
        right: 180px;
        left: initial;
        animation-delay: 0.6s;
        animation-duration: 1.5s;
    }

    .stars-animate span:nth-child(5) {
        top: 0;
        right: 400px;
        left: initial;
        animation-delay: 0.8s;
        animation-duration: 2.5s;
    }

    .stars-animate span:nth-child(6) {
        top: 0;
        right: 600px;
        left: initial;
        animation-delay: 1s;
        animation-duration: 3s;
    }

    .stars-animate span:nth-child(7) {
        top: 300px;
        right: 0px;
        left: initial;
        animation-delay: 1.2s;
        animation-duration: 1.75s;
    }

    .stars-animate span:nth-child(8) {
        top: 0px;
        right: 700px;
        left: initial;
        animation-delay: 1.4s;
        animation-duration: 1.25s;
    }

    .stars-animate span:nth-child(9) {
        top: 0px;
        right: 1000px;
        left: initial;
        animation-delay: 0.75s;
        animation-duration: 2.25s;
    }

    .stars-animate span:nth-child(9) {
        top: 0px;
        right: 450px;
        left: initial;
        animation-delay: 2.75s;
        animation-duration: 2.75s;
    }

    @media only screen and (min-width: 991px) {
        .page-template-sale-new-template .flag-bottom {
            top: 250px;
        }
        .page-template-sale-new-template  .strr9 {
            height: 140px;
            width: 140px;
            right: 2%;
        }
    }


    @media only screen and (max-width: 1700px) {
        section#solid-color-with-text-section .flag-curve-right {
            max-width: 290px;
        }

        .sale-banner::after {
            top: -12px;
        }

    }

    @media only screen and (max-width: 1250px) {



        section#solid-color-with-text-section .sale-text {
            font-size: 100px;
        }

        section#solid-color-with-text-section .strr1 {
            width: 120px;
            height: 120px;
        }

        .sale-banner::after {
            max-width: 575px;
            background-size: contain;
        }

        .sale-banner::before {
            max-width: 675px;
            background-size: contain;
        }

        section#solid-color-with-text-section {
            min-height: 463px;
        }

        .flag-bottom {
            top: 206px;
            max-width: 393px;
        }

        section#solid-color-with-text-section span.discount {
            font-size: 100px;
        }

        section#solid-color-with-text-section .right-wrapper-content p {
            font-size: 22px;
        }

        .strr9 {
            height: 90px;
            width: 90px;
        }

        section#solid-color-with-text-section .momorial-day-text {
            font-size: 48px;
        }

        section#solid-color-with-text-section span.day-sale-ibt {
            font-size: 40px;
        }

        section#solid-color-with-text-section .sale-text-sec {
            max-width: 350px;
        }

        section#solid-color-with-text-section .flag-left {
            max-width: 72px;
            position: relative;
            left: 29px;
        }

        .sale-banner::after {
            max-width: 832px;
            top: -7px;
        }

        .sale-banner::before {
            max-width: 516px;
        }

    }

    @media only screen and (max-width: 1024px) {
        section#solid-color-with-text-section .flag-curve-right {
            max-width: 192px;
        }

        .flag-bottom {
            top: 218px;
            max-width: 326px;
        }

        section#solid-color-with-text-section .momorial-day-text {
            font-size: 38px;
        }

        section#solid-color-with-text-section span.day-sale-ibt {
            font-size: 28px;
        }

        section#solid-color-with-text-section .sale-text {
            font-size: 86px;
        }

        section#solid-color-with-text-section .sale-text-sec {
            max-width: 280px;
        }

        .sale-banner::after {
            max-width: 500px;
            top: 0px;
        }

        .sale-banner::before {
            max-width: 570px;
        }

        section#solid-color-with-text-section {
            min-height: 330px;
            margin-top: 75px;
        }

        section#solid-color-with-text-section span.discount {
            font-size: 80px;
        }

        section#solid-color-with-text-section span.textUpto,
        section#solid-color-with-text-section span.textOff {
            font-size: 24px;
        }

        section#solid-color-with-text-section .right-wrapper-content p {
            font-size: 18px;
        }
    }


    /* Responsive Design */
    @media (max-width: 767px) {

        .sale-banner::before {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/pollygon-left-mobile.png');
        }

        .sale-banner::after {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/pollygon-right-mobile.png');
        }

        .sale-banner::before,
        .sale-banner::after {
            height: 100%;
            width: 100%;
            max-width: 100%;
            background-size: cover;
            opacity: 0.6;
        }

        .content {
            flex-direction: column;
        }

        .momorial-sale-left,
        .momorial-sale-right {
            padding: 10px;
        }



        .discount {
            font-size: 36px;
        }

        .momorial-sale-right p {
            font-size: 14px;
        }

        .flag-left {
            max-width: 100px;
        }

        .sale-text h1 {
            font-size: 24px;
        }

        .sale-banner::before,
        .sale-banner::after {
            /* width: 30px;
            height: 30px; */
        }

        section#solid-color-with-text-section .flag-curve-right {
            max-width: 168px;
        }

        section#solid-color-with-text-section {
            margin-top: 63px;
        }


        .flag-bottom {
            top: 420px;
            max-width: 308px;
        }
        .page-template-sale-new-template .flag-bottom {
            top: 350px;
        }

        section#solid-color-with-text-section .momorial-day-text {
            font-size: 26px;
        }

        section#solid-color-with-text-section span.day-sale-ibt {
            font-size: 22px;
        }

        section#solid-color-with-text-section .sale-text {
            font-size: 62px;
        }

        section#solid-color-with-text-section .right-wrapper-content p {
            font-size: 20px;
        }

        section#solid-color-with-text-section .strr2,
        section#solid-color-with-text-section .strr5,
        section#solid-color-with-text-section .strr6,
        section#solid-color-with-text-section .strr7 {
            display: none;
        }

        section#solid-color-with-text-section .strr1 {
            width: 52px;
            height: 52px;
            left: 237px;
            top: 165px;
        }

        section#solid-color-with-text-section span.discount {
            font-size: 80px;
        }

        section#solid-color-with-text-section span.textUpto,
        section#solid-color-with-text-section span.textOff {
            font-size: 24px;
        }

        .strr9 {
            height: 90px;
            width: 90px;
            right: -8%;
            bottom: 11px;
        }

        section#solid-color-with-text-section .strr4 {
            bottom: 65%;
            left: -28px;
        }

        section#solid-color-with-text-section .momorial-sale-right {
            padding-top: 0;
        }
    }
</style>


<section id="solid-color-with-text-section" class="sale-banner">
    <!-- <div class="stars-animate">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>        
    </div> -->


    <div class="star-one strr3 star-red"></div>
    <div class="star-one strr4 star-blue"></div>

    <div class="flag-curve-right">
        <img class="USA flag"
            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/USA-flag-right-curve.png"
            alt="" />
    </div>
    <div class="sale-wrapper">

        <div class="content">
            <div class="momorial-sale-left">
                <div class="star-one strr1 star-red"></div>
                <div class="sale-text-sec">
                    <div class="usa-flag-middle">
                        <div class="star-one strr5 star-blue"></div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/USA-flag-middel-small.png"
                            alt="American Flag" class="flag-left">
                    </div>
                    <div class="sale-text-content">
                        <div class="momorial-day-text font-mont">MEMORIAL</div>
                        <div class="day-sale-text font-mont"><span class="star-bx-1"></span> <span
                                class="star-bx-2"></span> <span class="day-sale-ibt">DAY </span><span
                                class="star-bx-2"></span> <span class="star-bx-1"></span></div>
                        <div class="sale-text font-mont">Sale</div>
                    </div>
                </div>
                <div class="star-one strr2 star-blue"></div>
            </div>
            <div class="momorial-sale-right">
                <div class="right-wrapper-content">
                    <div class="star-one strr6 star-blue"></div>
                    <h2 class="font-mont"><span class="textUpto">
                            <div class="textUpp-d">UP</div>
                            <div class="textToo-d"> TO</div>
                        </span> <span class="discount">40</span> <span class="textOff">
                            <div>%</div> OFF
                        </span></h2>
                    <p class="font-mont">This weekend only, shop and save on whitening, guards, skincare, and more!
                        <span class="star-one strr7 star-red"></span>
                    </p>
                    <div class="button-tshop">
                        <a href="/sale" type="button" class="button btn">Shop Sale</a>
                    </div>

                    <div class="star-one strr8 star-blue"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="flag-bottom">
        <img class="USA flag"
            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/momorial-day-sale/USA-flag-left-large.png"
            alt="" />
    </div>
    <div class="star-one strr9 star-blue"></div>

</section>