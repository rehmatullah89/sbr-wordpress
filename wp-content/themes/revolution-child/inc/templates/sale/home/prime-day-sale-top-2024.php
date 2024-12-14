<?php
//
?>
<style>
    .home-page-wrappper {
        display: none;
    }
    .prime-day-wrapper {
        position: relative;
        background-color: #3890c5;

        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/sale-background-bg.jpg");
        background-position: center;
        opacity: 0; /* Initially hidden */
        animation: fadeIn 1s ease-in forwards;
        }
        @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
        }
    .prime-day-wrapper .container{
        padding: 40px 0px 76px 0px;
        min-height: 650px;
    }
    .text-wrapper-smile {
        max-width: 590px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-top: 3rem;
    }
    .noisy-overlay {
        position: relative;
    }

    section.primeDaySaleSection {
        margin-top: 147px;
        overflow: hidden;
    }
    .container{
         position: relative;
    }
    .handGraphic{
        position: absolute;
    }
    .enemalArmour{
        left:-100px;
        bottom: -28px;
    }
    .enemalArmour img {
        max-height: 430px;
    }
    .tpHandInjection{
        top: -129px;
    left: -62px;
    }
    .tpHandInjection img {
        max-height: 680px;
    }
    .handMouthGuard{
        left:200px;
        bottom: -23px;
    }
    .electricToothBrush{left: initial; right: 200px; bottom: -263px;     z-index: 1;}
    .sbrDevice{left: initial;     right: -120px;     top: -77px;     z-index: 1;}
    .primedayStrip {
        box-shadow: 7px 7px 18px rgba(0, 0, 0, 0.38);
    position: absolute;
    width:100%;
}
.primeDaySaleText{
    white-space: nowrap; 
}
.primeDaySaleText p{ 
    margin: 0;
    padding: 12px 0;
    font-family: 'Montserrat';
    padding: 16px 0;
    line-height: 1;
    text-transform: uppercase;
    color: #fff;
    font-weight: 800;
    display: flex;
    align-items: center;
    font-size: 28px;
    display: inline-block;
     animation: scrollText 2000s linear infinite; */

}

 @keyframes scrollText {
      from {
        transform: translateX(0);
      }
      to {
        transform: translateX(-100%);
      }
    }  
    
.stripOne,.stripThree{
    background: #4acac9;
    transform: rotate(-26deg);
    left: -556px;
    top: -31px;
}
.stripTwo{
    background: #fb319f;
    transform: rotate(-41deg);
    left: -766px;
    top: 67px;     
}
.stripThree{
    left: initial;
    right: -586px;
    top: initial;
    bottom: 17px;
    transform: rotate(-16deg);
}

.stripFour{
    background: #958dc9;
    right: -613px;
    top: initial;
    bottom: -100px;
    transform: rotate(-40deg);
}

.text-up {
    font-size: 49px;
    color: #fff;
    font-weight: 400;    line-height: 1;
}
.offPriceText{
    font-size: 100px;
    color: #fff;
    font-weight: 800;    line-height: 1;
}
.saleDateWrap{
    display: inline-flex;
    margin-top: 35px;
    position: relative;
    margin-bottom: 35px;
}
.saleDateWrap:before,.saleDateWrap:after{
    content: "";
    position: absolute;
    background: #fff;
    height:1px ;
    top: 0%;
    left: 0%;
    right: 0;
    margin-left: auto;
    margin-right: auto;    
    background: #fff;
    width: 95%;
}
.saleDateWrap:after{
    bottom: 0;
    top: inherit;
}
.saleDateWrap p{
    font-size: 28px;
    color: #fff;
    font-weight: 300;
    line-height: 1;
    margin: 0;
    padding-top: 14px;
    padding-bottom: 14px;
}
.sectionDescription p{
    font-size: 26px;
    color: #fff;
    font-weight: 300;        line-height: 1.3;
}
.btn-sale-sec{
    background: #fb319f;
    color: #fff;
    font-size: 24px;
    color: #fff;
    font-weight: 400;
    text-transform: uppercase;      
    border-color: #fb319f;
    letter-spacing: 0;
    border-radius: 3px;

}

.handGraphic {
    transition: transform 0.1s ease-out;
    }
@media only screen and (min-width: 1500px) {
   .prime-day-wrapper .container {
        width: 80%;
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



@media only screen and (max-width: 1700px) {
    .enemalArmour {
        left: -130px;
    } 
    .tpHandInjection{
        left: -105px;
    }
    .handMouthGuard {
        left: 149px;
    }
    .sbrDevice{
        right: -140px;
    }
    .electricToothBrush{
        right: 142px;
    }
    .sectionDescription p {
        font-size: 22px;
    }
    .saleDateWrap p {
        font-size: 24px;
    }
    .offPriceText {
        font-size: 92px;
    }



    .stripOne {
        top: 17px;
    }
    .stripTwo {
        top: 208px;
    }
    .stripThree {
        bottom: 37px;
    }
    .stripFour {
        bottom: -157px;
        right: -383px;
        transform: rotate(-37deg);
    }
}


@media only screen and (max-width: 1600px) {
    .stripOne{
        top: 70px;
    }
    .stripTwo{
        top: 284px;
    }
    .stripThree{
        right: -386px;
    }

}
@media only screen and (max-width: 1500px) {
    .stripThree {
        right: -468px;
    }
    .stripFour {
        right: -343px;
        bottom: -144px;
    }
}

@media only screen and (max-width: 1400px) {
    .handMouthGuard img {
        max-height: 373px;
    }
    .enemalArmour {
        left: -39px;
    }
    .enemalArmour img {
        max-height: 357px;
    }
    .tpHandInjection {
        left: -87px;
    }   
    
    .prime-day-wrapper .container {
        width: 90%;
    }

    .sbrDevice {
        right: -40px;
    }

    .electricToothBrush img {
        max-height: 750px;
    }
    .handGraphic.sbrDevice img {
        max-height: 486px;
    }

    .stripOne {
        top: 113px;
    }

    .stripTwo {
        top: -50px;
        left: -222px;
    }

    .stripFour {
        right: -210px;
    }

}
@media only screen and (max-width: 1200px) {
    .offPriceText {
        font-size: 70px;
    }
    .text-up {
        font-size: 36px;
    }
    .saleDateWrap p {
        font-size: 20px;
    }
    .sectionDescription p {
        font-size: 20px;
    }

    .prime-day-wrapper .container{
        min-height: 510px;
    }
    .electricToothBrush img {
        max-height: 660px;
    }
    .handGraphic.sbrDevice img {
        max-height: 460px;
    }
    .electricToothBrush {
        right: 117px;
    }
    .tpHandInjection img {
        max-height: 556px;
    }
    .handMouthGuard img {
        max-height: 300px;
    }
    .enemalArmour img {
        max-height: 299px;
    }
    .primeDaySaleText p{
        font-size: 20px;
    }

    .stripThree {
        right: -388px;
        bottom: 65px;
        transform: rotate(-27deg);
    }


}

@media only screen and (max-width: 991px) {
    .stripThree {
        right: -352px;
    }
    .sectionDescription p {
        font-size: 16px;
    }
    .btn-sale-sec{
        font-size: 18px;
    }

    .stripOne {
        transform: rotate(-30deg);
        top: 149px;
    }
    .stripTwo{
        transform: rotate(-50deg);
        left: -275px;
        left: -318px;
    }
}
@media only screen and (max-width: 990px) {

    .electricToothBrush,.handMouthGuard,.sbrDevice {
        display: none;
    }
    .tpHandInjection {
        left: initial;
        right: -22px;
        top: -223px;
    }
    .enemalArmour {
        left: 30px;
    }
    .enemalArmour img {
        max-height: 330px;
    }
    .stripFour{
        transform: rotate(-45deg);
        bottom: 0px;
        right: -311px;
    }
    .tpHandInjection img {
        max-height: 483px;
    }

    .stripOne {
        transform: rotate(-30deg);
        top: 119px;
        left: -319px;
    }   
    .stripTwo{
        left: -200px;
    } 


}
@media only screen and (min-width: 768px) {
    .hidden-desktop{ display: none;}
}


@media only screen and (max-width: 767px) {
    section.primeDaySaleSection{
        margin-top: 109px;
    }
    .saleDateWrap p{
        font-weight: 300;
    }
    .btn-sale-sec{
        font-weight: 400;
    }
    .stripOne {
        transform: rotate(-38deg);
        top: 124px;
        left: -269px;
    }

    .stripTwo {
        left: -287px;
        top: 120px;
        transform: rotate(-56deg);
    }

    .stripFour {
        right: -200px;
    }
    .prime-day-wrapper .container {
        width: 100%;
    }
    .saleDateWrap {
        margin-top: 25px;
        margin-bottom: 25px;
    }
    .sectionDescription p {
        font-size: 18px;
    }
}

@media only screen and (max-width: 600px) {
    .text-up {
        font-size: 32px;
        word-spacing: 18px;
        font-weight: 300;
    }
    .primedayStrip{    box-shadow: 7px 7px 18px rgba(0, 0, 0, 0.18);}
    .primeDaySaleText p {
        font-size: 16px;
    }
    .stripOne {
        transform: rotate(-39deg);
        top: 98px;
        left: -217px;
    }
    .stripTwo {
        left: -193px;
        top: 105px;
        transform: rotate(-55deg);
    }
    .tpHandInjection {
        right: 8px;
        top: -195px;
    }
    .tpHandInjection img {
        max-height: 422px;
    }

    .offPriceText {
        font-size: 60px;
    }
    .saleDateWrap p {
        font-size: 18px;
    }
    .enemalArmour img {
        max-height: 230px;
    }
    .enemalArmour {
        left: 9px;
    }
    .stripThree {
        right: -187px;
        bottom: 51px;
    }
    .stripFour {
        right: -126px;
    }
    .primeDaySaleText p{
        padding: 10px 0;
    }
}

@media only screen and (max-width: 400px) {
    .stripOne {
        transform: rotate(-28deg);
        top: 59px;
        left: -174px;
    }
    .stripTwo {
        left: -149px;
        top: 52px;
        transform: rotate(-43deg);
    }
    .stripThree {
        right: -142px;
        bottom: 32px;
    }

}

@media only screen and (max-width: 390px) {

    .stripOne {
        top: 41px;
        left: -135px;
    }
    .stripThree {
        right: -119px;
        bottom: 49px;
    }
    .stripFour {
        right: -68px;
    }
}


</style>


<section class="primeDaySaleSection noisy-overlay">
    <div class="prime-day-wrapper">
        <div class="container">
            <div class="primedayStrip stripOne">
                <div class="primeDaySaleText">
                <p>PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·
                    </p>
                </div>
            </div>

            <div class="primedayStrip stripTwo">
                <div class="primeDaySaleText">
                <p>PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·
                    </p>
                </div>
            </div>

            <div class="handGraphic enemalArmour">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/hand-enemalArmour.png"
                    alt="">
            </div>
            <div class="handGraphic tpHandInjection">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/hand-tpHandInjection.png"
                    alt="">
            </div>
            <div class="handGraphic handMouthGuard">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/hand-MouthGuard.png"
                    alt="">
            </div>
            <div class="text-wrapper-smile">
                <div class="text-up">
                    UP TO
                </div>
                <div class="offPriceText">
                    <span>60%</span>
                    <span>OFF</span>
                </div>

                <div class="saleDateWrap">
                    <p>FROM JULY 16TH TO 17TH</p>
                </div>

                <div class="sectionDescription">
                    <p>Prime Day. Prime smiles.<br class="hidden-desktop"> Prime savings.<br>
                        No prime account needed</p>
                </div>
                <div class="shopSaveBUtton">
                    <a class="btn btn-primary btn-sale-sec" href="/sale">SHOP & SAVE</a>
                </div>
            </div>

            <div class="handGraphic electricToothBrush">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/hand-electricToothBrush.png"
                    alt="">
            </div>
            <div class="handGraphic sbrDevice">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/prime-day-sale/hand-sbrDevice.png"
                    alt="">
            </div>

            <div class="primedayStrip stripThree">
                <div class="primeDaySaleText">
                    <p>PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·
                    </p>
                </div>
            </div>

            <div class="primedayStrip stripFour">
                <div class="primeDaySaleText">
                <p>PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY · PRIME DAY ·
                    </p>
                </div>
            </div>


        </div>
    </div>
</section>

<script>
    // document.addEventListener('mousemove', (e) => {
    //     const { clientX, clientY } = e;
    //     const { innerWidth, innerHeight } = window;
    //     const moveX = (clientX / innerWidth - 0.5) * 20;
    //     const moveY = (clientY / innerHeight - 0.5) * 20;

    //     const primeDaySaleSection = document.querySelector('.primeDaySaleSection');
    //     const rect = primeDaySaleSection.getBoundingClientRect();
    
    // if (
    //         clientX >= rect.left &&
    //         clientX <= rect.right &&
    //         clientY >= rect.top &&
    //         clientY <= rect.bottom
    //     ) {
    //         document.querySelectorAll('.handGraphic').forEach(element => {
    //         element.style.transform = `translate(${moveX}px, ${moveY}px)`;
    //         });
    //     }
    //  });

    function handleMove(e) {
    let clientX, clientY;

    if (e.type === 'mousemove') {
        clientX = e.clientX;
        clientY = e.clientY;
    } else if (e.type === 'touchmove') {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    }

    const { innerWidth, innerHeight } = window;
    const moveX = (clientX / innerWidth - 0.5) * 20;
    const moveY = (clientY / innerHeight - 0.5) * 20;

    const primeDaySaleSection = document.querySelector('.primeDaySaleSection');
    if (!primeDaySaleSection) {
        console.error('Element with class primeDaySaleSection not found.');
        return;
    }

    const rect = primeDaySaleSection.getBoundingClientRect();
    if (
        clientX >= rect.left &&
        clientX <= rect.right &&
        clientY >= rect.top &&
        clientY <= rect.bottom
    ) {
        document.querySelectorAll('.handGraphic').forEach(element => {
            element.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });
    }
}

document.addEventListener('mousemove', handleMove);
document.addEventListener('touchmove', handleMove);



</script>