<style>
     @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display&display=swap');

#solid-color-with-text-section {
    margin-top: 84px;
    overflow: hidden;
}

div#home-page-top-banner-section {
    display: none;
}

.gum-awareness-background {
    background: #303e48;
}
.gum-awareness-container {
    max-width:1280px;
    display:flex;
    margin:0px auto;
    justify-content:space-between;
}
.gum-awareness-details {
    background: #303e48;
    padding: 49px 20px;
    max-width:500px;
    width: 100%;
    margin:0px auto;
}
.gum-awareness-details .text-details {
    text-align:center;
}
.gum-awareness-details .logo-image p{
    line-height: 1;
    text-align: center;
    margin-bottom: 10px;
} 
.empty-container {
    position: relative;
    bottom: -5px; padding-top: 34px;     padding-bottom: 30px;
}
.empty-container img{
    max-width: min-content;
}
.logo-image {
    margin-bottom: 10px;
}
.gum-awareness-details .text-details h3 {
    font-family: 'Playfair Display';
    line-height: 1;
    font-weight: 300;
    color: #fff;
    margin-bottom: 4px;
    font-size: 36px;
}
.gum-awareness-details .text-details h2 {
    font-family: 'Montserrat';
    font-weight: 800;
    color: #0eb4b9;
    font-size: 82px;
    line-height: 1;
    margin-bottom:11px;
}

.gum-awareness-details .text-details p {
    padding: 0px 25px;
    line-height: 1.2;
    color: #fff;
    font-size: 18px;
    font-family: 'Montserrat';
    margin-bottom: 25px;
}
 .btn-primary-white-teal {
    background-color: #0eb4b9;
    border-color: #0eb4b9;
    color: #fff;
    font-size: 18px;
    padding: 6px 10px;
    margin-top: 10px;
    font-weight: 300;
    letter-spacing: 0px;
    max-width: 240px;
    width: 100%;
}
.gum-awareness-details .text-details span img {
    width: 10%;
    margin-top: -13px;
}
.gum-awareness-details .text-details .btn-primary-white-teal:hover{
    background:#595858;
    border-color:#595858;
    color:#fff;
}
.gum-awareness-details .text-details .mobile-shop-btn{
    display:none;
}
.gum-awareness-details .text-details .desktop-shop-btn{
    display: inline-block;
    margin-bottom: 12px;    margin-top: 7px;
}

.saveAmount {
    font-size: 22px;
    font-weight: 300;
    font-family: 'Montserrat';
}
.saveAmount a{
    text-decoration: underline;
    color: #fff;
}
a.blueButton {
    background: #3d98cc;
}
a.outLineButton{
    border-color: #0eb4b9;
    background: transparent;
    color: #0eb4b9;

}
.descriptionBottom {
    font-weight: 300;
    font-size: 11px;
    color: #fff;
}
@media screen and (min-width:768px) {
    #solid-color-with-text-section .mobileGraphic{
        display: none;
    }
}

@media screen and (min-width:990px) and (max-width:1220px) {
    .empty-container img {
        max-width: 100%;
    }

}

@media screen and (min-width:768px) and (max-width:899px) {
    .empty-container img {
    max-width: 480px;
}
.gum-awareness-details{
    padding: 49px 3px;
}
.gum-awareness-details .text-details h3{
    font-size: 24px;
}
.gum-awareness-details .text-details h2{
    font-size: 54px;   
}
.saveAmount {
    font-size: 16px;
    font-weight: 300;
}
.btn-primary-white-teal{
    font-size: 16px;
}

}


@media screen and (max-width:767px){
    .gum-awareness-details .text-details p {
    padding: 0px 10px;
    font-size: 18px;
}
.empty-container  {
    display:none;
}
.off-color {
    background:#0eb4b9;
    color:#fff;
}
.gum-awareness-details .logo-image  {
    display:none;
}
.gum-awareness-details .text-details .mobile-shop-btn{
    display: inline-block;
}

.gum-awareness-details .text-details span img {
    margin-top: -5px;
}

#solid-color-with-text-section .hidden-mobile{ display: none;}
.mobileGraphic {
    display: flex;
    align-items: center;
    justify-content: center;
}
.ultraSonicCleanerImage {
    max-width: 200px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
}
.mobileGraphic {
    max-width: 175px;
    margin-left: auto;
    margin-right: auto;
}
.gum-awareness-details{
    padding: 20px 20px;
}
.kitGraphicImage{ margin-bottom: 10px;}

}
</style>



<section id="solid-color-with-text-section">

    <div class="gum-awareness-wrapper">
        <div class="gum-awareness-background">
            <div class="gum-awareness-container">
                <div class="empty-container">
                    
                    <img  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/sleep-awareness/sleep-awarnesessa-weeek-graphic-banner.jpg") alt="" srcset="">                    

                </div>
            <div class="gum-awareness-details">
                <div class="logo-image hidden-mobile" >
                   <p> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/sleep-awareness/moon-stars-with-bed-sleep-graphic.png"
                        ) alt="" srcset=""> </p>
                </div>

                <div class="mobileGraphic">
                        <img  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/sleep-awareness/smilebrilliant-logo.png") alt="" srcset="">
                        
                    </div>
                <div class="text-details">
                    <h3>Sleep Awareness</h3>
                    <h2>WEEK</h2>

                    <div class="hidden-desktop kitGraphicImage">
                        <img  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/sleep-awareness/kit-graphic-mobile.png") alt="" srcset="">
                    </div>
                    <!-- <p>
                        Save 20% on Smile Brilliant Night Guards this week only! Stop the damage and save!
                    </p> -->
                    <div class="saveAmount" style="color:#fff;">
                        <span style="color:#0eb4b9;font-style:italic;font-weight:bold;">Save 20%</span> on Night Guard <a href="/product/night-guards/">Kits</a>
                    </div>
                    <a rel="nofollow" href="/product/night-guards/" class="new-year-shop-btn btn btn-primary-white-teal desktop-shop-btn">SHOP NIGHT GUARDS</a>

                    <div class="saveAmount" style="color:#fff;">
                        <span style="color:#3d98cc;font-style:italic;font-weight:bold;">50% OFF</span> Ultrasonic UV Cleaner 
                    </div>
                    <a rel="nofollow" href="/product/ultrasonic-cleaner/" class="new-year-shop-btn btn btn-primary-white-teal desktop-shop-btn blueButton">BUY UV CLEANER</a>

                    <div class="saveAmount" style="color:#fff;">
                        <a href="/my-account/orders/">Reorder</a> 3 guards get a 4th <span style="color:#0eb4b9;font-style:italic;font-weight:bold;">FREE</span> 
                    </div>
                    <a rel="nofollow" href="/my-account/orders/" class="new-year-shop-btn btn btn-primary-white-teal desktop-shop-btn outLineButton">REORDER GUARDS</a>
                    <div class="descriptionBottom">
                        My Account --> locate your original order --> Reorder Trays
                    </div>

                    <div class="hidden-desktop ultraSonicCleanerImage">
                        <img  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/sleep-awareness/ultra-sonic-graphic-mobile.png") alt="" srcset="">
                    </div>                    

                </div>
            </div>
            </div>
        </div>
       
    </div>

</section>

