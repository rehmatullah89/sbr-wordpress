<style>


@font-face {
    font-family: 'lovemedium';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/love/love-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/love/love-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
    .font-love{
       font-family: 'lovemedium'; 
    }

    #solid-color-with-text-section {
    margin-top: 84px;
}
    .valentine-day-sale-2023-wrapper{
        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/valentine-day-sale/home-banner-top.png");
        background-repeat: no-repeat;
        position:relative;
        background-position:center;
        background-color:#f0c6c7;
        background-size:cover;
    }
   .valentine-day-sale-content .main-heart {
        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/valentine-day-sale/big-heart.png");
        background-repeat: no-repeat;
        max-width: 400px;
    object-fit: contain;
    height: 370px;

    }
    .valentine-day-sale-content .left-side {
    max-width: 400px;
    position:relative;
    width: 50%;
}
.valentine-day-sale-content  .right-side {
    text-align: center;
    width: 50%;
}
    .valentine-day-sale-content {
        display: flex;
    padding: 60px 0px 30px 120px;
    max-width: 1024px;
    margin: 0px auto;
    align-items: center;
    justify-content: start;
      
    }
    p.main-text{
        line-height: 1;
    margin-bottom: 0px;
    font-size:42px;
    margin-top:-10px;
    color: #f5faf8;
    }
    p.detail-text{
        padding: 0px 30px 20px;
    line-height: 30px;
    font-size: 22px;
    color: #f5faf8;
    margin-bottom: 0px;

    }
    .valentine-day-sale-content .text-main {
    max-width: 400px;
    align-items: center;
    display: flex;
    justify-content: center;
    text-align: center;
    }
    .valentine-day-sale-content  h2 {
    font-size: 120px;
    font-weight: 700;
    color: #f5faf8;
    margin-bottom: 10px;
    line-height: 1;
}
    .valentine-day-sale-content .text-main  .text55 {
        margin-top: 15px;
    opacity: 0.9;
    font-size: 185px;
    display: block;
    padding-left: 0px;
    font-weight: 200;
    color: #f0c6c7;
    font-family: 'Montserrat';
    }
    .valentine-day-sale-content .text-main  .percent {
        line-height: 0.8;
    color: #f0c6c7;
    font-weight: 200;
    font-size: 120px;
    margin-top: 4px;
    display: block;
    font-family: 'Montserrat';

    }
    .valentine-day-sale-content .text-main  .off {
        font-size: 48px;
    font-weight: 200;
    color: #f0c6c7;
    padding-left: 10px;
    line-height: 0.5;
    display: block;
    margin-top: -11px;
    }
    .valentine-day-sale-content .left-side .heart-image {
        position: absolute;
    right: 80px;
    bottom: 30px;
}
.valentine-day-sale-content .left-side .man-with-arrow {
    position: absolute;
    left: -130px;
    bottom: 13px;
}

.upto-text .upto-background {
    background-image: url(https://stable.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/sales/2023/valentine-day-sale/heart-top1.png);
    background-repeat: no-repeat;
    width: 120px;
    height: 120px;
    background-size: contain;
    z-index: 99;
    object-fit: contain;
}
.upto-text {
    left: -31px;
    top: -22px;
    position: absolute;
}
.upto-text .up-text{
    font-size: 38px;
    padding-left: 20px;
    padding-top: 2px;
    color: #f0c6c7;
    font-weight: 200;
    margin-bottom: 0px;
}
.upto-text .to-text{
    margin-bottom: 0px;
    padding-left: 55px;
    font-size: 34px;
    line-height: 0.3;
    color: #f0c6c7;
    font-weight: 200;
}
.red-text-main {
    color:#ee868b;
}
a.valentine-shop-btn.btn.btn-primary-white-teal {
    background: #ee868b;
    color: #f5faf8;
    border-color: #e9747a;
    padding:15px 55px;
}
div#home-page-top-banner-section {
    display: none;
}
a.valentine-shop-btn.btn.btn-primary-white-teal{
    letter-spacing: .1em;
}
@media screen and (min-width:768px) and (max-width:992px){
    .valentine-day-sale-content .main-heart {
        background-size:95%;
    }
    .valentine-day-sale-content .text-main .text55{
        font-size: 120px;
    padding-top: 10px;
    }
    .valentine-day-sale-content .text-main .percent{
        font-size:62px;
    }
    .valentine-day-sale-content .text-main .off{
        font-size:42px;
    }
    .valentine-day-sale-content .left-side .heart-image {
    right: 55px;
    bottom: 100px;
}
.valentine-day-sale-content .left-side .man-with-arrow {
    left:-100px
}
.upto-text .up-text {
    padding-left:10px;
}
.upto-text .to-text{
    padding-left:45px;
}
p.detail-text {
    padding: 0px 25px 20px;
}
}
@media screen and (max-width:767px){
    a.valentine-shop-btn.btn.btn-primary-white-teal{
    padding: 15px 40px;
}
    #solid-color-with-text-section {
    margin-top: 70px;
}
    .valentine-day-sale-content {
    display: block;
    padding: 60px 0px 60px 0px;
    max-width: 100%;
    margin: 0px auto;
}
.valentine-day-sale-content .left-side {
    display:none;
}
.valentine-day-sale-content .right-side {
    width: 100%;
}
p.detail-text {
    padding: 0px 15px 25px;
    font-size: 22px;
}
a.valentine-shop-btn.btn.btn-primary-white-teal {
    font-size:18px;
}
.valentine-day-sale-content h2 {
    margin-bottom:5px;
}
.valentine-day-sale-content  p.detail-text {
    padding: 0px 15px 25px;
    font-size: 22px;
    line-height: 32px;
}
.valentine-day-sale-2023-wrapper{
        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/valentine-day-sale/mobile-banner.png");
        background-repeat: no-repeat;
        position:relative;
        background-position:center;
        background-color:#f0c6c7;
        background-size:cover;
    }
}

</style>


<section id="solid-color-with-text-section">
   <div class="valentine-day-sale-2023-wrapper">
      <div class="valentine-day-sale-content">
        <div class="left-side">
            <div class="main-heart">
                <div class="text-main">
                    <div class="off55">
                        <span class="text55">55</span>
                    </div>
                    <div class="off%">
                        <span class="percent">%</span><br>
                        <span class="off">OFF</span>
                    </div>
                </div>
            </div>

            <div class="heart-image">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/valentine-day-sale/heart-bottom1.png") alt="" srcset="">
            </div>

            <div class="man-with-arrow">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/valentine-day-sale/man-with-arrow.png") alt="" srcset="">
            </div>

            <div class="upto-text">
                <div class="upto-background">
                    <p class="up-text">up</p>
                    <p class="to-text">to</p>
                </div>
            </div>
        </div>
        <div class="right-side">
        <div class="right-side-content">
            <p class="main-text font-love"> <span class="red-text-main ">Valentine’s </span> Day</p>
            <h2>SALE</h2>
            <p class="detail-text">Renew your love with a renewed smile this Valentine’s day and save up to 55%</p>
            <a rel="nofollow" href="/sale" class="valentine-shop-btn btn btn-primary-white-teal">SHOP DEALS PAGE</a>
        </div>
        </div>

      </div>
   </div>
</section>