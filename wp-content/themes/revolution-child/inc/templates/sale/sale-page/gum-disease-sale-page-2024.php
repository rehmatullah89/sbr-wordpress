<style>
 @font-face {
    font-family: 'Acrylic Hand Thick';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/acrylichand/AcrylicHandThick-Regular.woff') format('woff');
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/acrylichand/AcrylicHandThick-Regular.woff2') format('woff2');

    font-weight: normal;
    font-style: normal;

}

    #solid-color-with-text-section {
        margin-top: 92px;
        overflow: hidden;
    }

    #home-page-top-banner-section {
        display: none;
    }

    .gum-disease-wrapper {
        position: relative;
    padding: 92px 0px 122px 0px;
    background-color: #68c8c7;
    }

    .teeth-section {
        position: relative;
        display: flex;
        align-items: center;
    }

    .top-teeth {
        position: absolute;
        top: -80px;
    }

    .bottom-teeth {
        position: absolute;
        bottom: -121px;
    }

    .high-lighter-img {
        position: absolute;
        top: -190px;
        left: -68%;
        z-index: 99;
    }
    .brush-img {
        position: absolute;
        bottom: -165px;
        left: -16%;
    }
    .teeth-section-content {
    text-align: center;
    width: 50%;
    padding: 35px 0px 25px 0px;
}
    .gum-disease-product-section{
        width: 50%;
        position: relative;
    }
    .teeth-section-content .content-detail h1 {
    font-family: 'Acrylic Hand Thick';
    font-size: 67px;
    color: #f0f0f0;
    font-weight: 500;
}
.teeth-section-content .content-detail p{
    font-size: 46px;
    display: inline-block;
    border-top: 3px solid #f0f0f0;
    color: #f0f0f0;
    font-family: 'Montserrat';
    border-bottom: 3px solid #f0f0f0;
    margin-bottom:-10px;
}
.teeth-section-content:before {
    content: '';
    position: absolute;
    width: 106%;
    background: #54a2a1;
    display: block;
    z-index: 0;
    height: 166%;
    top: -80px;
    left: -55%;
}
.teeth-section-content:after {
    content: '';
    position: absolute;
    width: 8%;
    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/after-img.jpg");
    display: block;
    z-index: 0;
    height: 166%;
    left: 46%;
    top: -80px;
    background-repeat: no-repeat;
    background-size: 100%;
}
.content-detail{
    position: relative;
}
.enamel-image {
    position: absolute;
    top: -125px;
    right: -180px;
    transform: rotate(24deg);
    max-width: 60%;
}
.right-side-content {
    max-width: 440px;
    text-align: center;
    margin-left: 25px;
    position: relative;
    top: 20px;
}
.right-side-content h1 {
    display: inline-flex;
    font-size: 122px;
    align-items: center;
    color: #f0f0f0;
    margin-bottom: 0px;
}
span.percent {
    font-size: 48px;
    text-align: left;
    padding-left: 5px;
    line-height: 40px;
}
span.off {
    font-size: 29px;
    line-height: 29px;
    display: block;
}
.right-side-content h2{
    font-size: 44px;
    font-weight: 700;
    color: #f0f0f0;
    line-height: 10px;
    padding-left: 15px;
}
.high-lighter-img img {
    max-width: 26%;
}
.right-side-content p{
    padding: 15px 38px;
    font-size: 24px;
    font-family: 'Montserrat';
    color: #f0f0f0;
    font-weight: 400;
    line-height: 30px;
    margin-bottom: 10px;
}
.right-side-content .btn-primary{
    background: #d4545a;
    border-color: #d4545a;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}
.water-flosser {
    position: absolute;
    bottom: -135px;
    right: -100px;
}
.adult-bottle {
    right: 7px;
    position: absolute;
    top: -10px;
}
section.refillSection {
    position: relative;
    z-index: 123;
    background: #fff;
    margin-top: -30px;
    padding-top: 30px;
}
.gum-disease-mobile-section{
    display: none;
}
.gum-disease-mobile-section{
    overflow: hidden;
}
.gum-disease-wrapper {
    overflow: hidden
}
@media screen and (min-width:1024px) and (max-width:1199px){
    .high-lighter-img {
    top: -160px;
    left: -92%;
}
.high-lighter-img img {
    max-width: 20%;
}
.teeth-section-content:after{
    width: 10%;
}
.top-teeth {
    top: -80px;
    left: -90px;
}
.top-teeth img{
    max-width: 50%;
}
.bottom-teeth {
    bottom: -121px;
    left: -90px;
}
.bottom-teeth  img {
    max-width: 50%;

}
.brush-img {
    bottom: -122px;
    left: -16%;
}
.brush-img img {
    max-width: 70%;
}
.teeth-section-content{
    padding: 0px;
}
.teeth-section-content .content-detail h1 {
    font-size: 48px;
}
.teeth-section-content .content-detail p {
    font-size: 33px;
}
.right-side-content{
    margin-left: 0px;
}
.adult-bottle {
    right: -102px;
    top: 60px;
}
.adult-bottle img {
    max-width: 50%;
}
.enamel-image {
    position: absolute;
    top: -80px;
    right: -35px;
}
.water-flosser {
    bottom: -122px;
    right: -100px;
}
.water-flosser img{
    max-width: 70%;
}
.right-side-content h1 {
    font-size: 68px;
}
.right-side-content p {
    font-size: 19px;
}
.right-side-content h2 {
    font-size: 28px;
}
.teeth-section-content:before {
    height: 185%;
    top: -80px;
    left: -55%;
}
.teeth-section-content:after {
    height: 185%;
    left: 50%;
    width: 9%;
    top: -82px;
    background-size: 100%;
}
}

@media screen and (min-width:1200px) and (max-width:1399px){
    .adult-bottle {
    right: -40px;
    top:40px
}
.high-lighter-img{
    top: -144px;
    left: -75%;
}
.enamel-image{
    right: 10px;
}
.teeth-section-content:after{
    width: 10%;
}
.right-side-content{
    margin-left: 0px;
}
.high-lighter-img img {
    max-width: 18%;
}
.water-flosser img{
    max-width: 70%;
}
.right-side-content h2 {
    font-size: 36px;
}
.right-side-content p{
    font-size: 20px;
}
.water-flosser {
    right: -40px;
}
.top-teeth {
    left: -40px;
}
.adult-bottle img {
    max-width: 75%;
}
.bottom-teeth {
    left: -40px;
}


.brush-img {
    left: -7%;
}
.top-teeth img{
    max-width: 70%;
}
.bottom-teeth  img {
    max-width: 70%;

}
.brush-img img {
    max-width: 70%;
}
}
@media screen and (min-width:1400px) and (max-width:1499px){
   .top-teeth img {
    max-width: 75%;
   } 
   .enamel-image {
    right: -101px;
}
   .bottom-teeth img {
    max-width: 75%;
   }
   .high-lighter-img {
    top: -183px;
    left: -78%;
}
.high-lighter-img img {
    max-width: 26%;
}
.brush-img {
    bottom: -122px;
    left: -14%;
}
.brush-img img {
    max-width: 70%;
}
.adult-bottle {
    right: -108px;
    top: 20px;
}
.adult-bottle img {
    max-width: 80%;
}
.bottom-teeth {
    left: -30px;
}
.right-side-content h2{
    font-size:36px;
}
.water-flosser {
    bottom: -135px;
    right: -120px;
}
.water-flosser img {
    max-width: 85%;
}
.teeth-section-content:after {
    width: 10%;
    left: 48%;
}
}

@media screen and (min-width:1500px) and (max-width:1890px){
    .high-lighter-img {
        top: -166px;
         left: -59%;
}
.enamel-image {
    top: -133px;
    right: -20px;
}
.teeth-section-content:after {
    width: 6%;
    height: 180%;
    background-size: 105%;
}
.top-teeth,.bottom-teeth {
    left: 40px;
}
.top-teeth img,.bottom-teeth img ,.brush-img img{
    max-width: 80%;
}
.brush-img {
    left: -5%;
}
.adult-bottle {
    top: 20px;
    right: 50px;
}
.teeth-section-content .content-detail h1 {
    font-size: 48px;
}
.teeth-section-content .content-detail p {
    font-size: 32px;
}
.content-detail {
    padding-left: 40px;
}
.water-flosser {
    bottom: -122px;
    right: -65px;
}
.water-flosser img {
    max-width: 80%;
}
.right-side-content h1 {
    font-size: 82px;
}
.right-side-content h2 {
    font-size: 37px;
}
.right-side-content p {
    font-size: 20px;
}
.adult-bottle img {
    max-width: 80%;
}
.brush-img img {
    max-width: 70%;
}
.teeth-section-content {
    padding:0px;
}
.high-lighter-img img {
    max-width: 20%;
}
.teeth-section-content:before {
    height: 186%;
    width: 105%;
    top: -100px;
}
}
@media screen and (max-width:1024px){
  .gum-disease-wrapper{
    display: none;
  }
  .gum-disease-mobile-section{
    display: block;
    background-color: #68c8c7;
    position: relative;
  }
  .top-section {
    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/Rectangle.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    padding-bottom: 90px;
    position: relative;
  }
  .heading {
    padding: 40px 0px;
}
  .heading h1 {
    font-family: 'Acrylic Hand Thick';
    color: #fff;
    font-size: 32px;

  }
  .heading p {
    display: inline-block;
    border-top: 3px solid #fff;
    border-bottom: 3px solid #fff;
    color: #fff;
    padding: 5px;
    font-size: 22px;
    font-family: 'Montserrat';
  }
  .adult-mbl {
    position: absolute;
    right: -24px;
    top: 160px;
}
.bursh-mbl {
    position: absolute;
    left: -110%;
    top: 75px;
}
.bursh-mbl img {
    max-width: 48%;
}
.adult-mbl img {
    max-width: 70%;
}
.bottom-section h1 {
    display: inline-flex;
    font-size: 122px;
    align-items: center;
    color: #f0f0f0;
    margin-bottom: 0px;
    line-height: 0.8;
}
.bottom-section span.off {
    font-size: 28px;
    line-height: 36px;
    display: block;
}
.bottom-section h2 {
    font-size: 28px;
    font-weight: 800;
    color: #f0f0f0;
    margin-bottom: -2px;
    margin-top: 5px;
    font-family: 'Montserrat';
}
.bottom-section p {
    font-size: 20px;
    color: #f0f0f0;
    font-weight: 500;
    line-height: 27px;
    padding: 0px 38px;
}
.bottom-section  .btn-primary {
    background: #d4545a;
    border-color: #d4545a;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}
.bottom-teeth-image {
    margin-top: 20px;
}
.bottom-section {
   margin-top: -90px;
}
.mbl-enamel {
    position: absolute;
    bottom: 10px;
    left: -32px;
}
.mbl-brush {
    position: absolute;
    bottom: -20px;
    right: -31px;
}
.mbl-enamel img , .mbl-brush img {
    max-width: 60%;
}
#solid-color-with-text-section{
    margin-top: 80px;
}
}

@media screen and (min-width:768px) and (max-width:1024px){
    #solid-color-with-text-sections {
    margin-top: -15px;
}
    .gum-disease-mobile-section .teeth-image,.gum-disease-mobile-section .bottom-teeth-image {
        max-width: 400px;
          margin: 0px auto;
    }
    .bottom-section {
    margin-top: -45px;
    padding-bottom: 0px;
}
    .gum-disease-mobile-section .bottom-teeth-image {
        max-width: 400px;
          margin-top: 20px;
    }
    .bottom-content{
        max-width: 400px;
        margin: 0px auto;
        text-align: center;
    }
    .heading {
    text-align: center;
}
.bursh-mbl img {
    max-width: 40%;
}
.adult-mbl {
    position: absolute;
    right: 100px;
    top: 150px;
}
.adult-mbl img {
    max-width: 100%;
}
.mbl-brush {
    right: -20px;
    bottom: 25px;
}
.mbl-brush img {
    max-width: 90%;
}
.bursh-mbl {
    left: -199px;
    top: 53px;
}
.mbl-enamel img{
    max-width: 75%;
}
.mbl-enamel {
    left: 0px;
    bottom: -15px;
}
}
@media screen and (max-width:767px){
    .bursh-mbl {
    left: -111%;
    top: 174px;
}
.bursh-mbl img {
    max-width: 38%;
}
section#solid-color-with-text-sections {
    margin-top: -23px;
}
.mbl-enamel img, .mbl-brush img {
    max-width: 50%;
}
.gum-disease-mobile-section{
    position: unset;
}
.mbl-enamel {
    top: -10px;
    left: -32px;
}
.bottom-section {
    margin-top: -35px;
}
.heading h1 {
    font-size: 24px;
}
.heading p {
    font-size: 18px;
}
.adult-mbl img {
    max-width: 55%;
}
.adult-mbl {
    right: -24px;
    top: 195px;
}
.bottom-section h1 {
    font-size: 84px;
}
span.percent {
    font-size: 36px;
    line-height: 40px;
}
.bottom-section span.off {
    font-size: 20px;
    line-height: 25px;
}
.solid-color-with-text-sections{
    margin-top:-22px;
}
.mbl-brush {
    position: absolute;
    top: 60px;
    right: -50px;
}
.bottom-section {
    padding-bottom: 0px;
}
}
@media screen and (max-width:360px){
    .mbl-enamel img , .mbl-brush img {
    max-width: 50%;
} 
.adult-mbl {
    right: -40px;
}
}
</style>



<section id="solid-color-with-text-sections">

    <div class="gum-disease-wrapper">

        <div class="container">
            <div class="teeth-section">
                <div class="teeth-section-content">
                    <div class="high-lighter-img">
                        <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/High-Lighter.png" />
                    </div>
                    <div class="brush-img">
                    <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/Toothbrush.png" />
                    </div>
                    <div class="top-teeth">
                        <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/top-teeth.png" />
                    </div>

                    <div class="bottom-teeth">
                        <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/bottom-teeth.png" />
                    </div>

                    <div class="content-detail">
                        <h1>GUM <br> DISEASE</h1>
                        <p>Awareness Month</p>
                    </div>

                </div>
            
            <div class="gum-disease-product-section">
                <div class="enamel-image">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/sale-page-enamel.png" />
                </div>

                <div class="adult-bottle">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/Adult-bottle.png" />
                </div>
                <div class="water-flosser">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/sale-img.png" />
                </div>
                <div class="right-side-content">
                    <h1>15 <span class="percent">% <br><span class="off"> OFF</span></span></h1>
                    <h2>cariPRO Products</h2>
                    <p>Shop our gum-health related products and save 15% for the remainder of February!</p>

                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="gum-disease-mobile-section">
        <div class="gum-disease-wrapper-main">
            <div class="top-section">
                <div class="teeth-image">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/top-teeth.png" />
                </div>
                <div class="bursh-mbl">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/waer-mbl.png" />
                </div>
                <div class="adult-mbl">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/sale-bottle.png" />
                </div>
                <div class="heading">
                    <h1>GUM <br> DISEASE</h1>

                    <p>Awareness Month</p>
                </div>
            </div>

            <div class="bottom-section">
                <div class="bottom-content">
                    <h1>15 <span class="percent">% <br> <span class="off">OFF</span> </span></h1>
                    <h2>cariPRO Products</h2>
                    <p>Shop our gum-health related products and save 15% for the remainder of February!</p>
                   

                </div>
                <div class="bottom-teeth-image">
                <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/bottom-teeth.png" />
                </div>
            </div>
           <div class="mbl-enamel">
           <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/Enamel-mbl.png" />
           </div>
           <div class="mbl-brush">
           <img class=""
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2024/gum-disease-2024/sale-brush.png" />
           </div>
        </div>
    </div>
</section>