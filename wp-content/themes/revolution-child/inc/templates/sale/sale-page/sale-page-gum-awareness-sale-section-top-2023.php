<style>
     @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display&display=swap');

#solid-color-with-text-section {
    margin-top: 0px;
}

div#home-page-top-banner-section {
    display: none;
}

.gum-awareness-background {
    background: #e7f3fa;
    -moz-box-shadow: 0 8px 6px #dbdbdb;
    -webkit-box-shadow: 0 8px 6px #dbdbdb;
    box-shadow: 0 8px 6px #dbdbdb;
} 
.gum-awareness-details {
    padding: 70px 20px 40px 20px;
    max-width:700px;
    margin:0px auto;
}
.gum-awareness-details .text-details {
    text-align:center;
}
#solid-color-with-text-section .gum-awareness-details .text-details h3 {
    font-family: 'Playfair Display';
    line-height: 1;
    font-weight: 300;
    color: #595858;
    margin-bottom: 10px;
    font-size: 46px;
}
.gum-awareness-details .text-details h2 {
    font-family: 'Montserrat';
    font-weight: 800;
    color: #0eb4b9;
    font-size: 57px;
    line-height: 1;
    margin-bottom:10px;
}

.gum-awareness-details .text-details p {
    padding: 0px 25px;
    line-height: 1.3;
    color: #595858;
    font-size: 24px;
    font-family: 'Montserrat';
}
.gum-awareness-details .text-details span img {
    margin-top: -8px;
}
.off-color {
    background:#0eb4b9;
    color:#fff;
}
.teeth-image-mobile {
    display:none;
}

@media screen and (max-width:767px){
    .gum-awareness-details .text-details p {
    padding: 0px 10px;
    font-size: 18px;
}
.gum-awareness-details{
    padding: 40px 20px 40px 20px;
}
.teeth-image-mobile {
    display:block;
}
.teeth-image-desktop {
    display:none;
}
.gum-awareness-details .text-details .teeth-image {
    /* margin-top: 40px; */
    margin-left: -20px;
    margin-right: -20px;
}
.gum-awareness-background {
    background: #e7f3fa;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
} 
}
</style>

<section id="solid-color-with-text-section">
    <div class="gum-awareness-wrapper">
        <div class="gum-awareness-background">
            <div class="gum-awareness-container">
                 <div class="gum-awareness-details">
                      <div class="text-details">
                             <h3>Gum Disease</h3>
                             <h2>Awareness Month <span> <img
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/calendar.png"
                                ) alt="" srcset="">
                                 </span></h2>
                             <p>Shop our gum-health related products and save up to <span class="off-color">30%</span>  for the remainder of February!</p>

                            <div class="teeth-image teeth-image-desktop">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/sale-teeth.png"
                                    ) alt="" srcset="">
                        </div>
                        <div class="teeth-image teeth-image-mobile">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2023/gum-awareness-month-sale/Teeth.png"
                        ) alt="" srcset="">
                    </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</section>