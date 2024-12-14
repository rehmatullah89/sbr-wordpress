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
   background-image:url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/hero-bg.png");
   background-position: bottom;
    background-repeat: repeat;
    background-size: contain;
   

}
.gum-awareness-container {
    max-width:1280px;
    display:flex;
    margin:0px auto;
    justify-content:space-between;
}
.gum-awareness-details {
    background: #e7f3fa;
    padding: 40px 20px;
    max-width:500px;
    margin:0px auto;
}
.gum-awareness-details .text-details {
    text-align:center;
}
.gum-awareness-details .logo-image P{
    line-height: 1;
    text-align: center;
    margin-bottom: 10px;

} 
.empty-container {
    width: 105%;
    position: relative;
    bottom: -5px;
}
.empty-container  img{
    width: 105%;

}
.gum-awareness-details .text-details h3 {
    font-family: 'Playfair Display';
    line-height: 1;
    font-weight: 300;
    color: #595858;
    margin-bottom: 10px;
    font-size: 42px;
}
.gum-awareness-details .text-details h2 {
    font-family: 'Montserrat';
    font-weight: 800;
    color: #0eb4b9;
    font-size: 57px;
    line-height: 1;
    margin-bottom:10px;
}
.gum-awareness-details .text-details .teeth-image {
    margin-top: 40px;
    margin-left: -20px;
    margin-right: -20px;
}
.gum-awareness-details .text-details p {
    padding: 0px 35px;
    line-height: 1.3;
    color: #595858;
    font-size: 24px;
    font-family: 'Montserrat';
}
.gum-awareness-details .text-details .btn-primary-white-teal {
    background-color: #0eb4b9;
    border-color: #0eb4b9;
    color: #fff;
    font-size:18px;
    padding:10px 60px;
    margin-top: 10px;
    font-weight: 300;
    letter-spacing:0px;
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
.gum-awareness-details .text-details .desktop-shop-btn{
    display:none;
}
.gum-awareness-details .text-details span img {
    margin-top: -5px;
}
.gum-awareness-details .text-details .btn-primary-white-teal {
    padding: 8px 40px;
}
}
</style>



<section id="solid-color-with-text-section">

    <div class="gum-awareness-wrapper">
        <div class="gum-awareness-background">
            <div class="gum-awareness-container">
                <div class="empty-container">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/img-sbr.png") alt="" srcset="">
                </div>
            <div class="gum-awareness-details">
                <div class="logo-image">
                   <p> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/Logo_horizontal.png"
                        ) alt="" srcset=""> </p>
                </div>

                <div class="text-details">
                    <h3>Gum Disease</h3>
                    <h2>Awareness <br> Month <span> <img
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/calendar.png"
                                ) alt="" srcset="">
                        </span></h2>
                    <p>Shop our gum-health related products and save up to <span class="off-color">30%</span>  for the remainder of February!</p>

                    <a rel="nofollow" href="/sale" class="new-year-shop-btn btn btn-primary-white-teal desktop-shop-btn">SHOP DEALS</a>
                    <a rel="nofollow" href="/sale" class="new-year-shop-btn btn btn-primary-white-teal mobile-shop-btn">SHOP GUM HEALTH</a>

                    <div class="teeth-image">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/Teeth.png"
                        ) alt="" srcset="">
                    </div>
                </div>
            </div>
            </div>
        </div>
       
    </div>

</section>