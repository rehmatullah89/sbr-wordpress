<style>
    #solid-color-with-text-section {
     margin-top: 0rem;
}
.home-sale-wrapper {
    padding:80px 0px 30px 0px;
    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/cyber-monday-sale/BannerBackground.png");

}
.black-friday-logo {
    max-width:320px;
    margin:0px auto;
}
#solid-color-with-text-section {
    margin-top: 50px;
}
#solid-color-with-text-section  .flex-div{
    display:none;
     justify-content: center;
     margin-top: 15px;
    }
    #solid-color-with-text-section  span.dotsSeprator{
        display: none;
    }
    #solid-color-with-text-section     span.parentSpan{
        
    }
    #solid-color-with-text-section  .deal-time-span{
        font-size: 28px;
    }
    #solid-color-with-text-section   span#deal-days,#solid-color-with-text-section  span.deal-time-colon.daysonly
    ,#solid-color-with-text-section .profile-container .box-wrapper .box p,#solid-color-with-text-section  .curlyBrackets span
    {
        font-size: 30px;
    font-family: 'Montserrat';
    font-weight: 200;
}

    #solid-color-with-text-section  .curlyBrackets:before
    ,#solid-color-with-text-section  .curlyBrackets:after
    {
        font-weight: 200;
        font-size: 35px;
    }
    #solid-color-with-text-section  .flex-div-innerright.flex-div.curlyBrackets .parentSpan{
        padding-left: 5px;
        padding-right: 5px;        
    }


@media (min-width: 1500px){
  #oralCareDeals  .product-selection-box {
        max-height: 515px;
    }
}

@media screen and (max-width:767px){
    #solid-color-with-text-section  .flex-div{
    display:flex;
    }
    .home-sale-wrapper {
    padding: 30px 0px 30px 0px;
}
#solid-color-with-text-section {
    margin-top: 25px;
}
.home-sale-wrapper {
    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/cyber-monday-sale/mob-bg.png") !important;
    background-position: inherit;
    background-size: cover;
    background-repeat: no-repeat;
}
.home-sale-wrapper .curlyBrackets {
    max-height: 50px;
}

}
</style>

<section id="solid-color-with-text-section">
<div class="home-sale-wrapper">
<div class="black-friday-logo">
                    <!-- <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/cyber-monday-sale/Group-1.png" alt="cyber monday Deals Are Live"> -->
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/cyber-monday-sale/cyber-week-text.png" alt="cyber monday Deals Are Live">

</div>
<div class="flex-div-innerright flex-div curlyBrackets">


<div class='deal-time-break'></div>
<span class='deal-time-bracket'>&nbsp;[</span>
<!-- <span class="parentSpan">
    <span class='deal-days deal-time-span daysonly'></span>
    <span class='deal-time-colon daysonly'>days</span>
</span> -->
<span class="dotsSeprator">:</span>
<span class="parentSpan">
    <div clas="flexItem">
        <span class=' deal-hours deal-time-span'></span>
    </div>
    <span class='deal-time-colon'>hrs</span>
</span>
<span class="dotsSeprator">:</span>
<span class="parentSpan">
    <div clas="flexItem">
        <span class='deal-minutes deal-time-span'></span>
    </div>
    <span class='deal-time-colon'>mins</span>
</span>
<span class="dotsSeprator">:</span>
<span class="parentSpan" style="display:none;">
    <span class=' deal-seconds deal-time-span'></span>
    <span class='deal-time-colon'>sec</span>
</span>
<span class='deal-time-bracket'>]</span>

</div>
</div>
</section>