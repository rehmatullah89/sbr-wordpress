<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,900&display=swap');
</style>
<style>
section#solid-color-with-text-section .container {
    max-width: 1170px;
    padding-left: 15px;
    padding-right: 15px;
    margin-left: auto;
    margin-right: auto;    
}    
    div#home-page-top-banner-section {
        display: none;
    }


    #solid-color-with-text-section {
        background-color: #f0c6c7;
        margin-top: 83px;
        min-height: 480px;
        padding-top: 60px;
    padding-bottom: 50px;

    }
    #solid-color-with-text-section .row-t {
    margin-left: -15px;
    margin-right: -15px;
    display: flex;
}
.align-item-center {
    align-items: center;
}
.vdDescriptionText {
    max-width: 475px;
    margin-left: auto;
    margin-right: auto;
}

.v-col-sm-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
.font-mont-black{
    font-family: 'Montserrat', sans-serif;
    font-weight:900;
    font-style:italic;
}
.valentine-saleText {
    font-size: 118px;
    color: #fff;
    text-transform: uppercase;
    line-height: 1;
}
.valentine-day {
    font-size: 41px;
    color: #f5a2a4;
    font-weight: 600;
    font-style: italic;
    line-height: 1;
}
.vdBannerDescription {
    margin-top: 24px;
    color: #fff;
    margin-bottom: 33px;
    font-size: 24px;
    line-height: 1.3;
}
section#solid-color-with-text-section a.btn.btn-primary-orange {
    background: #fd0c34;
    border-color: #fd0c34;
}
.saleTextBox {
    padding: 15px;
    background-position: center;
}
section#solid-color-with-text-section a.btn.btn-primary-orange:hover {
    background-color: #595858;
    border-color: #595858;

}

@media only screen and (max-width: 1024px) {
    .valentine-day {
    font-size: 30px;
}
.valentine-saleText {
    font-size: 80px;
}
.vdBannerDescription {
    margin-top: 14px;
    color: #fff;
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 1.3;
}
.vdDescriptionText {
    max-width: 90%;
}    

.saleTextBox {
    background-size: contain;
    background-repeat: no-repeat;
}


}



@media only screen and (max-width: 767px) {
#solid-color-with-text-section{
    padding-top: 20px;
    padding-bottom: 25px;
}
.vdBannerImage {
    max-width: 250px;
}

#solid-color-with-text-section .row-t{
    flex-direction: column;
}

.v-col-sm-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 100%;
    max-width: 100%;
}
.vdBannerImage {

    margin-left: auto;
    margin-right: auto;
}
.valentine-day {
    font-size: 30px;
}
.valentine-saleText {
    font-size: 98px;
}    

.saleTextBox {
    background-position: center;
    background-size: contain;
    background-repeat: no-repeat;
}
.vdBannerDescription{
    padding-left: 15px;
    padding-right: 15px;
    font-size: 18px;
}
}
</style>


<section id="solid-color-with-text-section">
        <div class="container">
            <div class="row-t text-center align-item-center">
                <div class="v-col-sm-6">
                    <div class="vdBannerImage">                    
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/valentine-day-sale/valentine-day-sale-home-banner.jpg" class="">
                    </div>
                </div>
                <div class="v-col-sm-6">                    
                    <div class="vdDescriptionText">
                          <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/valentine-day-sale/vd-saleText.png" class="">  
 -->
                        <div class="saleTextBox" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/valentine-day-sale/vd-saleText.png);">
                            <div class="valentine-day font-mont">
                                VALENTINE’S DAY
                            </div>
                            <div class="valentine-saleText font-mont-black">
                                Sale!
                            </div>
                        </div>
                        <div class="vdBannerDescription font-mont">
                        Renew your smile! Kick off 2022 with huge savings on whitening & oral care!
                        </div>
                        <div class="section-buttons">
                            <a class="btn btn-primary-orange" href="/sale">SEE THE SALES</a>
                        </div>


                    </div>

                </div>

            </div>
        </div>            
    </section>

