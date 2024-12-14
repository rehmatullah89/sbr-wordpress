<style>
section.primeDaySaleSection {
    margin-top: 147px;
    overflow: hidden;
}

.noisy-overlay {
    position: relative;
}

.prime-day-wrapper {
    position: relative;
    background-color: #06a5df;
    /* background-image: url(https://smilebrilliant.com/wp-content/themes/revolution-child/assets/images/sales/2024/prime-day-sale/sale-background-bg.jpg); */
    background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/Prime-Day-Home-Page-Desktop-Recovered.jpg');
    background-position: center;
    opacity: 0;
    animation: fadeIn 1s ease-in forwards;
}

.home-page-wrappper {
    display: none;
}

.prime-banner {
    text-align: center;
    color: #fff;
}
.prime-day-wrapper,.prime-banner{
    min-height: 650px;
}



.prime-day-strip {
    background-color: #ffcc00;
    color: #000;
    font-weight: bold;
    padding: 10px 0;
    font-size: 1.2em;
    white-space: nowrap;
    overflow: hidden;
}

.content-wrapper {
    /* display: flex;
    justify-content: center;
    align-items: center; */
    padding: 20px;
    color: #fff;
    position: relative;    min-height: 534px;
}

.product-item {
    flex: 1;
    padding: 0 10px;
    position: absolute;
}

.product-item img {
    /* width: 100px;
    display: block; */
    margin: 0 auto;
}

.text-content {
    flex: 2;
    text-align: center;
}

.text-content h1 {
    font-size: 100px;
    margin-bottom: 20px;
    color: #263c46;
    font-weight: 800;line-height: 1;
    
}

.text-content h2 {
    font-size: 36px;
    margin-bottom: 0;
    color: #fff;
    font-weight: normal;
    line-height: 1;
    letter-spacing: 2px;
}
.flex-item-centent {
    height: 100%;
    display: flex;
    align-items: center;
    min-height: 494px;
    position: relative;
    max-width: 990px;
    margin-left: auto;
    margin-right: auto;
}
.text-content button {
    background-color: #263c46;
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-size: 20px;
    width: 100%;
    max-width: 325px;
    height: 62px;
    border-radius: 5px;
    font-family: 'Montserrat';
    font-weight: 700;
}

.text-content button:hover {
    background-color: #444;
}

.left {
    align-self: flex-start;
}

.right {
    right: 0;
    align-self: flex-end;
    top: 0;
}

.marquee {
    font-size: 28px;
    color: #263c46;
    height: 2.5vw;
    overflow: hidden;
    position: relative;
    font-family: 'Montserrat';
    font-weight: 800;
    line-height: 30px;
    display: flex;
    align-items: center;
}

/* nested div inside the container */
.marquee div {
    display: block;
    width: 200%;
    position: absolute;
    overflow: hidden;
    animation: marquee 50s linear infinite;
}

.marquee.marquee2 div {
    display: block;
    width: 200%;
    position: absolute;
    overflow: hidden;
    animation: marquee2 80s linear infinite;
}
.marquee.marquee2 span {
  display: inline-block;
  white-space: nowrap; /* Prevent the text from wrapping to the next line */
}
/* span with text */
.marquee span {
    /* float: left;
    width: 50%; */
}

/* keyframe */
@keyframes marquee {
    0% {
        left: 0;
    }

    100% {
        left: -100%;
    }
}

@keyframes marquee2 {
  0% {
    left: -100%; /* Start from the left */
  }
  100% {
    left: 0%; /* End far on the right */
  }
}

.product-item.left-tube {
    left: 327px;
    top: 66px;
}

.product-item.electricToothBrush {
    bottom: -366px;
    z-index: 1;
    left: 74px;
}
.product-item.retainerCleanerBox {
    bottom: -341px;
    left: -100px;z-index: 1;
}
.product-item.plaque-highlighter {
    top: 161px;
    left: -8px;
}

.product-item.toothBrushRight {
    right: 337px;
    top: -16px;
}

.product-item.right.cariproBottleBox {
    right: -88px;
}
.product-item.right.cariproBottle {
    right: 227px;
    top: -29px;
}

.animateObjects {
    transition: transform 0.1s ease-out;
    }




    .star-field {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    perspective: 600px;
    -webkit-perspective: 600px;

}
.star-field .layer {
    box-shadow: -411px -476px #cccccc, 777px -407px #d4d4d4, -387px -477px #fcfcfc, -91px -235px #d4d4d4, 491px -460px #f7f7f7, 892px -128px #f7f7f7, 758px -277px #ededed, 596px 378px #cccccc, 647px 423px whitesmoke, 183px 389px #c7c7c7,
        524px -237px #f0f0f0, 679px -535px #e3e3e3, 158px 399px #ededed, 157px 249px #ededed, 81px -450px #ebebeb, 719px -360px #c2c2c2, -499px 473px #e8e8e8, -158px -349px #d4d4d4, 870px -134px #cfcfcf, 446px 404px #c2c2c2,
        440px 490px #d4d4d4, 414px 507px #e6e6e6, -12px 246px #fcfcfc, -384px 369px #e3e3e3, 641px -413px #fcfcfc, 822px 516px #dbdbdb, 449px 132px #c2c2c2, 727px 146px #f7f7f7, -315px -488px #e6e6e6, 952px -70px #e3e3e3,
        -869px -29px #dbdbdb, 502px 80px #dedede, 764px 342px #e0e0e0, -150px -380px #dbdbdb, 654px -426px #e3e3e3, -325px -263px #c2c2c2, 755px -447px #c7c7c7, 729px -177px #c2c2c2, -682px -391px #e6e6e6, 554px -176px #ededed,
        -85px -428px #d9d9d9, 714px 55px #e8e8e8, 359px -285px #cfcfcf, -362px -508px #dedede, 468px -265px #fcfcfc, 74px -500px #c7c7c7, -514px 383px #dbdbdb, 730px -92px #cfcfcf, -112px 287px #c9c9c9, -853px 79px #d6d6d6,
        828px 475px #d6d6d6, -681px 13px #fafafa, -176px 209px #f0f0f0, 758px 457px #fafafa, -383px -454px #ededed, 813px 179px #d1d1d1, 608px 98px whitesmoke, -860px -65px #c4c4c4, -572px 272px #f7f7f7, 459px 533px #fcfcfc,
        624px -481px #e6e6e6, 790px 477px #dedede, 731px -403px #ededed, 70px -534px #cccccc, -23px 510px #cfcfcf, -652px -237px whitesmoke, -690px 367px #d1d1d1, 810px 536px #d1d1d1, 774px 293px #c9c9c9, -362px 97px #c2c2c2,
        563px 47px #dedede, 313px 475px #e0e0e0, 839px -491px #e3e3e3, -217px 377px #d4d4d4, -581px 239px #c2c2c2, -857px 72px #cccccc, -23px 340px #dedede, -837px 246px white, 170px -502px #cfcfcf, 822px -443px #e0e0e0, 795px 497px #e0e0e0,
        -814px -337px #cfcfcf, 206px -339px #f2f2f2, -779px 108px #e6e6e6, 808px 2px #d4d4d4, 665px 41px #d4d4d4, -564px 64px #cccccc, -380px 74px #cfcfcf, -369px -60px #f7f7f7, 47px -495px #e3e3e3, -383px 368px #f7f7f7, 419px 288px #d1d1d1,
        -598px -50px #c2c2c2, -833px 187px #c4c4c4, 378px 325px whitesmoke, -703px 375px #d6d6d6, 392px 520px #d9d9d9, -492px -60px #c4c4c4, 759px 288px #ebebeb, 98px -412px #c4c4c4, -911px -277px #c9c9c9;
    transform-style: preserve-3d;
    position: absolute;
    top: 50%;
    left: 50%;
    height: 4px;
    width: 4px;
    border-radius: 2px;
}
.star-field .layer:nth-child(1) {
    animation: sf-fly-by-1 5s linear infinite;
}
.star-field .layer:nth-child(2) {
    animation: sf-fly-by-2 5s linear infinite;
}
.star-field .layer:nth-child(3) {
    animation: sf-fly-by-3 5s linear infinite;
}
@keyframes sf-fly-by-1 {
    from {
        transform: translateZ(-600px);
        opacity: 0.5;
    }
    to {
        transform: translateZ(0);
        opacity: 0.5;
    }
}
@keyframes sf-fly-by-2 {
    from {
        transform: translateZ(-1200px);
        opacity: 0.5;
    }
    to {
        transform: translateZ(-600px);
        opacity: 0.5;
    }
}
@keyframes sf-fly-by-3 {
    from {
        transform: translateZ(-1800px);
        opacity: 0.5;
    }
    to {
        transform: translateZ(-1200px);
        opacity: 0.5;
    }
}


    @media only screen and  (min-width: 2000px) and (max-width: 2299px) {
    /* .offPriceText{ color: red;} */

}
@media  only screen and (min-width: 2400px) and (max-width: 2550px) {
  .prime-day-wrapper{zoom: 1.24;transform-origin: 0 0;}
  .offPriceText{ color: purple;}
}

@media  only screen and (min-width: 2551px) and (max-width: 2700px) {
    .prime-day-wrapper{zoom: 1.24;transform-origin: 0 0;}
    /* .offPriceText{ color: orange;} */
}

@media only screen and (min-width: 2700px) and (max-width: 3200px) {
    .prime-day-wrapper{zoom: 1.38;transform-origin: 0 0;}
    /* .offPriceText{ color: black;} */

}

@media only screen and (max-width: 1950px) {
    .product-item.left-tube {
        left: 225px;
    }
    .product-item.plaque-highlighter {
    left: -30px;
    }
    .product-item.electricToothBrush {
        left: -2px;
    }
    .product-item.right.cariproBottleBox {
    right: -107px;
    }
    .product-item.right.cariproBottle {
        right: 187px;
    }
    .product-item.toothBrushRight {
        right: 281px;
    }

}

@media only screen and (max-width: 1750px) {
    .product-item.plaque-highlighter {
        /* left: -67px;
        top: 16px; */        left: -133px;
    }

    .product-item.left-tube {
        left: 98px;
    }
    .product-item.electricToothBrush {
        left: -106px;
    }
    .product-item.toothBrushRight {
        right: 181px;
    }
    .product-item.right.cariproBottleBox {
        right: -145px;
    }

    .product-item.right.cariproBottle {
        right: 116px;
    }

}

@media only screen and (max-width: 1580px) {
    .prime-day-wrapper, .prime-banner {
        min-height: 620px;
    }    
    .text-content h1 {
        font-size: 77px;
    } 
    .text-content h2 {
    font-size: 27px;
    }
    .text-content button{
        font-size: 18px;
        max-width: 290px;
    height: 50px;        
    }
    .product-item.retainerCleanerBox{
        left: 1px;
    }
}

@media only screen and (max-width: 1389px) {
    .prime-day-wrapper, .prime-banner{
        min-height: 460px;
    }
    .product-item.plaque-highlighter {
        left: -189px;
    }
    .product-item.left-tube {
        left: -103px;
    }
    .text-content h1 {
        font-size: 65px;
    }
    .text-content h2 {
        font-size: 23px;
    }

    .product-item.right.cariproBottleBox {
        right: -116px;
        max-width: 320px;
    }
    .product-item.toothBrushRight {
        right: 181px;
        max-width: 240px;
    }
    .product-item.right.cariproBottle {
        right: 116px;
        max-width: 246px;
    }

    .content-wrapper {
        min-height: 420px;
    }
    .flex-item-centent{
        min-height: 330px;
    }

    .product-item.electricToothBrush {
        left: -106px;
    }
    .product-item.retainerCleanerBox {
        left: 64px;
        max-width: 363px;    bottom: -332px;
    }
    .product-item.left-tube {
        left: 30px;
        top: 6px;
    }

}

@media only screen and (max-width: 1280px) {
    .marquee {
    font-size: 22px;
}
    .product-item.plaque-highlighter {
        left: -83px;
        top: 111px;
        max-width: 253px;
    }
    .product-item.left-tube {
        left: -32px;
    }
    
    .product-item.electricToothBrush {
        left: -232px;
    }
    .product-item.retainerCleanerBox {
        max-width: 413px;
    }
    .product-item.right.cariproBottleBox {
        right: -99px;
        max-width: 296px;
    }
    .product-item.right.cariproBottle {
        right: 92px;
        max-width: 220px;
        top: -15px;
    }
    .product-item.toothBrushRight {
        right: 123px;
        max-width: 220px;
    }

}


@media only screen and (max-width: 1050px) {
    .product-item.left-tube {
        left: -78px;
    }
    .product-item.electricToothBrush {
        left: -111px;
        max-width: 358px;
        bottom: -203px;
    }
    .product-item.retainerCleanerBox {
        max-width: 348px;
        left: 6px;
        bottom: -291px;
    }
    .flex-item-centent {
        min-height: 272px;
    }

    .content-wrapper {
        min-height: 336px;
    }
    .prime-day-wrapper, .prime-banner {
        min-height: 410px;
    }

    .product-item.left-tube {
        left: -102px;        top: -14px;
    }

    .product-item.plaque-highlighter {
        max-width: 216px;
    }
    .product-item.right.cariproBottleBox {
        right: -95px;
        max-width: 267px;
    }

    .product-item.right.cariproBottle {
        right: 69px;
        max-width: 202px;
        top: -14px;
    }
    .product-item.toothBrushRight {
        right: 95px;
        max-width: 199px;
    }
    .text-content h1 {
        font-size: 58px;
    }    
    .text-content h2 {
        font-size: 20px;
    }
    .text-content button {
        font-size: 16px;
        max-width: 264px;
        height: 46px;
    }
    .marquee {
    font-size: 20px;
}


}


@media only screen and (mIN-width: 768px) {
    .mobile_only{ display: none;}
}
@media only screen and (max-width: 767px) {

section.primeDaySaleSection {
    margin-top: 52px;
}
.product-item.left-tube {
        left: -64px;
        top: 150px;
        max-width: 172px;
        transform: rotate(-50deg);
    }
    .product-item.plaque-highlighter {
        max-width: 197px;
        top: 15px;
        left: -92px;
    }

    .product-item.electricToothBrush {
        left: -100px;
        max-width: 227px;
        bottom: -115px;
    }
    .product-item.right.cariproBottle {
        right: -51px;
        max-width: 150px;
        top: 127px;
    }

    .product-item.right.cariproBottleBox {
        right: -59px;
        max-width: 163px;
    }
    .product-item.toothBrushRight {
        right: -47px;
        max-width: 144px;
        top: 184px;
        z-index: 1;
    }
    .text-content h1 {
        font-size: 55px;
    }
    .text-content button {
        max-width: 229px;
        height: 46px;
    }
    .prime-day-wrapper, .prime-banner {
        min-height: 392px;
    }

    .product-item.retainerCleanerBox {
        max-width: 254px;
        left: 6px;
        bottom: -202px;
    }
    .marquee{        font-size: 16px;
        height: 20px;
    }
    .marquee div{
        animation: marquee 20s linear infinite;
    }

    
    .text-content h1 span{ display: block;}
    .text-content h2 {
        font-size: 16px;
    }


}


</style>





<section class="primeDaySaleSection noisy-overlay">
    <div class="prime-day-wrapper">

    <div class="star-field">
<div class="layer"></div>
<div class="layer"></div>
<div class="layer"></div>
</div>

        <div class="prime-banner">
            <div class="prime-day-strip">
            <div class="marquee marquee2">
  <div>
    <span> PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •  PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •  PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •  PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
    PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
    DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • </span>


  </div>
</div>

            </div>
            <div class="content-wrapper">
                <div class="product-item left-tube animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/enemal-armour-tube.png);"
                        alt="" class="img-fluids">
                </div>
                <div class="product-item plaque-highlighter animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/plaque-highlighter-box.png);"
                        alt="" class="img-fluids">
                </div>

                <div class="product-item electricToothBrush animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/electric-tooth-brush.png);"
                        alt="" class="img-fluids">
                </div>

                    <div class="flex-item-centent">
                        <div class="text-content">
                            <h2>DENTIST-GRADE <br class="mobile_only"> ORAL CARE</h2>
                            <h1>PRIME <span style="color: #fff;">PRICES</span></h1>
                            <button onclick="window.location.href='/sale'"> PROTECT MY SMILE</button>
                        </div>

                        <div class="product-item retainerCleanerBox animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/retainer-cleaner.png);"
                        alt="" class="img-fluids">
                </div>

                    </div>

                <div class="product-item right toothBrushRight animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/electric-tooth-brush-right.png);"
                        alt="" class="img-fluids">
                </div>
                <div class="product-item right cariproBottle animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/probiotics.png);"
                        alt="" class="img-fluids">
                </div>

                <div class="product-item right cariproBottleBox animateObjects">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/pre-prime-day-october/cari-pro-box.png);"
                        alt="" class="img-fluids">
                </div>
            </div>
            <div class="prime-day-strip">
                <div class="marquee">
                    <div><span> PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
                            PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
                            DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •
                            PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME
                            DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY • PRIME DAY •</span>
                        
                        </div>
                </div>
            </div>
        </div>

    </div>
</section>



