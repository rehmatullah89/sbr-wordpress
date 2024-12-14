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
#solid-color-with-text-section {
    background-color: <?php echo get_field('banner_background_color');?>;
    background-color: #cfcfcfa1;
    margin-top: 3px;
    padding-top: 70px;
    padding-bottom: 50px;
    }
    .v-col-sm-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}

.valentine-day {
    font-size: 41px;
    color: #a6c8db;
    font-weight: 600;
    font-style: italic;
    line-height: 1;
}
.valentine-saleText {
    font-size: 118px;
    color: #fff;
    text-transform: uppercase;
    line-height: 1;
}

.font-mont-black {
    font-family: 'Montserrat', sans-serif;
    font-weight: 900;
    font-style: italic;
}

.saleTextBox {
    padding: 15px;
    background-position: center;
    background-repeat: no-repeat;
}

.textBelowBanner {
    max-width: 920px;
    margin-left: auto;
    margin-right: auto;
   margin-bottom: 41px;
    margin-top: 38px;
    text-align: center;
}
.textBelowBanner p{
    font-size: 24px;
    line-height: 1.5;
}
section#oralCareDeals h2 {
    padding-left: 15px;
    padding-right: 15px;
    word-wrap: break-word;
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
        margin-left: auto;
    margin-right: auto;        
    }    

    .saleTextBox {
        background-size: contain;
        background-repeat: no-repeat;
    }

    .textBelowBanner p {
    font-size: 18px;
     padding-left: 15px;
    padding-right: 15px;
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
<?php
    echo get_field('banner_area');
    ?>