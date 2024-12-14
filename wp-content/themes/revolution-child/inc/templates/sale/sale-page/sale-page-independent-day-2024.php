<?php
//
?>
<style>
    .home-page-wrappper {
        display:none;
    }    
    .indepence-day-wrapper{
        margin-top: 12px;
        background: #002245;
        background-image: url(/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/background-main.jpg);
        padding: 0px 0px 85px 0px;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }
    .indepence-day-wrapper:before {
        content: '';
        background-image: url('/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/blue-left-line.png');
        width: 80px;
        height: 100%;
        position: absolute;
        display: block;
        left: 0px;
        z-index: 1; 
        top: 0;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .indepence-day-wrapper:after {
        content: '';
        background-image: url('/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/blue-left-line.png');
        width: 80px;
        height: 100%;
        position: absolute;
        display: block;
        right: 0px;
        z-index: 1;
        top: 0;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .left-circle {
        position: absolute;
        top: -58px;
        left: -30px;
        z-index: 22;
}
.right-circle {
    position: absolute;
    bottom: -18px;
    right: -45px;
    z-index: 9;
}
.content-left-section{
    position: relative;
    text-align: right;
}

.single-baloon-img {
    position: absolute;
    top: -37px;
    left: 200px;
    z-index: 10;
}
.sale-img {
    padding-top: 135px;
    position: relative;
    left: -40px;
    z-index: 999;
}
.lightening-img{
    position: absolute;
    right: -109px;
    max-width: 45%;
    z-index: 0;
    bottom: -97px;
}
.sale-img img{ 
    border-top-right-radius: 43px;
}
.left-baloons-img {
    position: absolute;
    bottom: -12px;
    left: 117px;
    z-index: 9;
}
.blue-dotted-img {
    margin-top: 150px;
    position: relative;
    left: 85px;
    z-index: 99999;
}
.right-baloons-img {
    position: absolute;
    right: 92px;
    top: -72px;
    z-index: 9;
}
.white-doted {
    position: absolute;
    top: 45px;
    z-index: 999999;
}
.sale-right-content h1 {
    font-size: 67px;
    font-weight: 400;
    text-align: center;
    line-height: 69px;
    color: #3c98cb;
    font-family: 'Montserrat';
    margin-bottom: 17px;
}
.sale-right-content p {
    text-align: center;
    font-size: 28px;
    line-height: 36px;
    color: #fff;
    font-weight: 400;
    margin-bottom: 30px;
}
.sale-right-content {
    padding-top: 136px;
    margin-left: -65px;
    text-align: center;
    position: relative;
}
.btn.btn-sale {
    background-color: #3c98cb;
    border-color: #3c98cb;
    color: #fff !important;
    padding: 10px 30px;
    display: none;
}
.btn.btn-sale a{
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: 0.2px;
}
.sale-right-content .blue-baloon {
    position: absolute;
    right: -55px;
    bottom: 0px;
    max-width: 150px;
}
.single-baloon-img-mbl {
    display: none;
}
.independence-day-sale-top-wrapper{
    position: relative;
}
.left-wing{
    position: absolute;
    z-index: 9;
    left: 80px;
    top: -1px;
    max-width: 78%;
}
.btn.btn-sale:hover{
    background-color: #595858;
    border-color: #595858;
}
.blue-baloon.mbl-img {
        display: none;
    }
@media screen and (max-width:1899px){
    .sale-right-content .blue-baloon {
        right: -49px;
    }
}

@media screen and (max-width:1799px){
    .sale-right-content h1 {
        font-size: 42px;
        line-height: 42px;
    }
    .sale-right-content .blue-baloon {
        right: 20px;
        bottom: -53px;
    }
    .left-circle img {
        max-width: 85%;
    }
    .single-baloon-img {
        top: -58px;
        left: 165px;
    }
    .left-baloons-img img {
        max-width: 85%;
    }
.single-baloon-img img,.sale-img img img {
    max-width: 80%;
}
.sale-img {
        padding-top: 90px;
        left: -40px;
    }
    .lightening-img {
        right: -82px;
        max-width: 38%;
        bottom: -52px;
    }
    .sale-right-content {
        padding-top: 135px;
        margin-left: -185px;
    }
.sale-right-content h1 {
    font-size: 42px;
    line-height: 42px;
    margin-bottom: 12px;
}
.sale-right-content p {
    font-size: 22px;
    line-height: 27px;
}
.right-circle {
    max-width: 16%;
}

.right-baloons-img {
        right: 50px;
        top: 25px;
    }
    .white-doted img, .blue-dotted-img img {
        max-width: 100%;
    }
.left-baloons-img {
    bottom: -20px;
    left: 95px;
}
.white-doted {
        top: -45px;
        right: 20px;
        max-width: 100%;
    }
    .blue-dotted-img {
        margin-top: 25px;
        position: relative;
        left: 75px;
        max-width: 80%;
        z-index: 99999;
    }
.blue-baloon img {
        max-width: 100%;
    }
.indepence-day-wrapper {
        padding: 0px 0px 50px 0px;
    }
.sale-img img {
    max-width: 60%;
}

}

@media screen and (max-width:1599px){
  
    .single-baloon-img {
        top: -58px;
        left: 215px;
    
}
}
@media screen and (max-width:1499px){
    .sale-right-content h1 {
        font-size: 42px;
        line-height: 42px;
    }
    .sale-right-content .blue-baloon {
        right: -20px;
        bottom: -68px;
    }
    .left-circle img {
        max-width: 70%;
    }
    .left-baloons-img {
        bottom: -15px;
        left: 64px;
    }
    .left-baloons-img img {
        max-width: 75%;
    }
    .single-baloon-img {
        top: -80px;
        left: 60px;
    }
.single-baloon-img img,.sale-img img img {
    max-width: 80%;
}
.sale-img {
        padding-top: 59px;
        left: -40px;
    }
.lightening-img {
        right: -71px;
        max-width: 47%;
        bottom: -55px;
    }
    .sale-right-content {
        padding-top: 103px;
        margin-left: -65px;
    }
.sale-right-content h1 {
    font-size: 42px;
    line-height: 42px;
    margin-bottom: 12px;
}
.sale-right-content p {
    font-size: 22px;
    line-height: 27px;
}
.right-circle {
    max-width: 16%;
}

.right-baloons-img {
        right: 79px;
        top: 35px;
    }
    .white-doted img, .blue-dotted-img img {
        max-width: 100%;
    }
.white-doted {
        top: -45px;
        right: 0px;
        max-width: 85%;
    }
.blue-dotted-img {
    margin-top: 0px;
        position: relative;
        left: 110px;
        max-width: 85%;
        z-index: 99999;
}
.blue-baloon img {
    max-width: 80%;
}
.indepence-day-wrapper {
        padding: 0px 0px 50px 0px;
    }
.sale-img img {
    max-width: 60%;
}

}

@media screen and (max-width:1399px){
    .sale-right-content .blue-baloon {
        right: 5px;
        bottom: -68px;
    }
    .sale-right-content {
        padding-top: 105px;
        margin-left: -115px;
    }
    .single-baloon-img {
        left: 90px;
    }
}
@media screen and (max-width:1299px){
    .left-baloons-img {
        bottom: -35px;
        left: 55px;
    }
    .sale-img img {
        max-width: 50%;
    }
    .sale-img {
        padding-top: 60px;
        left: -40px;
    }
    .lightening-img {
        right: -71px;
        max-width: 43%;
        bottom: -77px;
    }
    .right-circle {
        max-width: 15%;
    }
    .blue-baloon img {
        max-width: 60%;
    }
    .sale-right-content .blue-baloon {
        right: 25px;
        bottom: -50px;
    }
    .single-baloon-img {
        top: -61px;
        left: 115px;
    }
    .single-baloon-img img, .sale-img img img {
        max-width: 65%;
    }
    .sale-right-content {
        padding-top: 75px;
        margin-left: -145px;
    }
    .white-doted img, .blue-dotted-img img {
        max-width: 90%;
    }
}


@media screen and (max-width:1199px){
    .left-circle img {
        max-width: 60%;
    }
    .left-baloons-img {
    bottom: 30px;
    left: 48px;
}
.left-baloons-img img {
    max-width: 60%;
}
.single-baloon-img{
    top: -40px;
    left: 18px;
}
.single-baloon-img img,.sale-img img img {
    max-width: 60%;
}
.sale-img {
    padding-top: 90px;
    left: -40px;
}
.lightening-img{
    right: -71px;
    max-width: 51%;
    bottom: -75px;
}
.sale-right-content {
    padding-top: 70px;
    margin-left: -65px;
}
.sale-right-content h1 {
    font-size: 35px;
    line-height: 39px;
}
.sale-right-content p {
    font-size: 22px;
    line-height: 27px;
}
.right-circle {
    max-width: 16%;
}

.right-baloons-img {
    right: 82px;
    top: 130px;
}
.white-doted img,.blue-dotted-img img {
    max-width: 80%;
}
.white-doted {
    top: -45px;
    right: 20px;
    max-width: 75%;
}
.blue-dotted-img {
    margin-top: 0px;
    position: relative;
    left: 85px;
    max-width: 75%;
    z-index: 99999;
}
.blue-baloon img {
    max-width: 60%;
}
.indepence-day-wrapper {
    padding:40px 0px 76px 0px
}
.sale-img img {
    max-width: 60%;
}
.sale-right-content .blue-baloon {
    right: -10px;
    bottom: -35px;
}
}

@media screen and (min-width:2020px){
    .sale-right-content .blue-baloon{
        right:-20px
    }
}

@media screen and (min-width:768px) and (max-width:1024px){
    .content-left-section{
        text-align: center;
    }
    .sale-img {
        left: 0px;
    }
    .sale-right-content {
        margin-left: 0px;
    }
    .lightening-img {
        right: 128px;
        max-width: 30%;
        bottom: -93px;
    }
    .sale-right-content h1 {
        font-size: 42px;
        line-height: 42px;
    }
    .right-baloons-img {
        right: 66px;
        top: 50px;
    }
    .sale-right-content .blue-baloon {
        right: 2px;
        bottom: 10px;
        z-index: 9;
    }
    .sale-right-content .blue-baloon {
        right: 20px;
        bottom: 10px;
    }
    .indepence-day-wrapper {
        margin-top: 16px;
    }
    .right-circle {
        max-width: 25%;
        bottom: -3px;
        right: -78px;
        z-index: 9;
    }
    .left-circle img {
        max-width: 80%;
    }
    .left-circle {
    position: absolute;
    top: -25px;
    left: -85px;
    z-index: 22;
}
    .right-circle {
        max-width: 25%;
        bottom: -3px;
        right: -78px;
        z-index: 9;
    }
}
@media screen and (max-width:991px){
    .single-baloon-img {
        left: 80px;
    }
    .lightening-img {
        right: 23px;
        max-width: 38%;
        bottom: -66px;
    }
}
@media screen and (min-width:768px) and (max-width:799px){
  
    .lightening-img {
        right: 84px;
        max-width: 33% !important;
        bottom: -48px;
    }

}
@media screen and (max-width:767px){
    .indepence-day-wrapper:before{
        background-image: url('/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/mobile-horizontal-img.png');
        width: 100%;
        height: 50px;
        background-size: contain;

    }
    .indepence-day-wrapper:after{
        background-image: url('/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/mobile-horizontal-img.png');
        width: 100%;
        height: 26px;
        bottom: 0px;
        top: unset;
        background-size: contain;


    }
    
    .indepence-day-wrapper{
        margin-top: -3px;
        padding: 61px 0px 110px 0px;
    }
    .left-circle {
    top: 0px;
    left: -130px;
}
.single-baloon-img{
    display: none;
}
.single-baloon-img-mbl {
    display: block;
        position: absolute;
        max-width: 20%;
        top: 45px;
        left: 17px;
}
.left-baloons-img{
    display: none;
}
.content-left-section {
    text-align: center;
}
.sale-img {
        padding-top: 60px;
        left: 0px;
    }
    .blue-baloon{
        display: none;
    }
    .blue-baloon.mbl-img {
        display: block;
    }
    .sale-img img {
        max-width: 40%;
        margin: 0px auto;
    }
    .sale-right-content {
        margin-left:0px
    }
    .sale-right-content{
        padding-top: 30px;
    }
    .sale-img{
        z-index: 9; 
    }
    .sale-img img {
        border-top-right-radius: 13px;
    }
    .sale-right-content p br {
        display: none;
    }
    .sale-right-content p  {
        padding: 0px 60px;
    }
    .sale-right-content h1 {
        font-size: 42px;
        line-height: 42px;
    }
    .lightening-img {
        right: 52px;
        max-width: 31%;
        bottom: -32px;
    }
    .white-doted {
        top: 70px;
        right: -108px;
        max-width: 75%;
    }
    .blue-dotted-img {
        margin-top: -45px;
        left: 181px;
        max-width: 80%;
        z-index: 99999;
    }
    .white-doted img, .blue-dotted-img img {
        max-width: 70%;
    }
    .white-doted {
        top: 43px;
        right: -108px;
        max-width: 75%;
    }
    .blue-baloon img {
        max-width: 100%;
    }
    .sale-right-content .blue-baloon {
        left: -55px;
        bottom: -85px;
    }
    .right-circle {
        max-width: 55%;
        bottom: 0px;
        right: -97px;
    }
    .indepence-day-wrapper{
       
        background-image: url('/wp-content/themes/revolution-child/assets/images/sales/2024/independence-day/mobile-bg_02.jpg');
        
    }
}

@media screen and (max-width:400px){
    .sale-right-content .blue-baloon {
        left: -70px;
        bottom: -85px;
    }
    .sale-right-content p {
        padding: 0px 40px;
    }
    .lightening-img {
        right: 41px;
        max-width: 32%;
        bottom: -28px;
    }
}
@media screen and (max-width:360px){
    .sale-right-content .blue-baloon {
        left: -82px;
        bottom: -85px;
    }
    .sale-right-content p {
        padding: 0px 25px;
    }
    .right-circle {
        max-width: 60%;
        bottom: 0px;
        right: -89px;
    }
    .lightening-img {
        right: 41px;
        max-width: 32%;
        bottom: -28px;
    }
}

</style>


<div class="indepence-day-wrapper" > 
    <div class="circle-img">
        <div class="left-circle">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/left-circle.png"  alt="">
        </div>
    <div class="right-circle">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/right-circle.png"  alt="">

    </div>
    </div>
    <div class="left-baloons-img">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/baloons.png" alt="" srcset="">

    </div>
    <div class="right-baloons-img">
        <div class="white-doted">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/white-doted-baloon.png" alt="" srcset="">

        </div>
        <div class="blue-dotted-img">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/blue-doted-baloon.png" alt="" srcset="">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6"> 
                <div class="content-left-section">
                    <div class="single-baloon-img">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/single-baloon.png" alt="" srcset="">
                    </div>
                    <div class="single-baloon-img-mbl">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/single-bloon-mbl.png" alt="" srcset="">
                    </div>
                    <div class="sale-img">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/sale-img.png" alt="">
                    </div>
                    <div class="lightening-img">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/lightening-img.png" alt="">

                    </div>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="sale-right-content">
                    <h1>SAVE UP <br> TO 40%</h1>
                    <p>Your exclusive discounts are <br> even better than fireworks</p>
                    <button class="btn btn-sale"> <a href="/sale">SHOP AND SAVE</a> </button>

                    <div class="blue-baloon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/blue-baloon.png" alt="">
                    </div>
                    <div class="blue-baloon mbl-img">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/independence-day/baloons.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
