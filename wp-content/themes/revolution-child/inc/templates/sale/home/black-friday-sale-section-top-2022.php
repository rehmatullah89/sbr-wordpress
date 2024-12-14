<style>
    #solid-color-with-text-section {
        margin-top: 134px;
        overflow: hidden;
    }

    #solid-color-with-text-section .home-sale-wrapper {
        position: relative;
        z-index: 99;
        background-color: #383737;

    }

    #solid-color-with-text-section .home-sale-wrapper .content-details {
        max-width: 1000px;
        margin: 0px auto;
        padding: 40px 0px;
        display: flex;
        justify-content: space-between;
        /* align-items: center; */
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail {
        z-index: 99;
        text-align: center;
        max-width: 440px;
        margin-top: 14px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail h3 {
        font-size: 32px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p {
        font-size: 24px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail p.main-text {
        line-height: 1.1;
        margin: 0px 0px 15px 0px;
    }

    #solid-color-with-text-section .home-sale-wrapper .text-detail h3,
    p {
        color: #fff;
        font-family: 'Montserrat'
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons p a {
        color: #fff;
        padding: 10px 15px;
        font-size: 16px;
        display: block;
        font-weight: 300;
        border: 1px solid #959494;
        transition: all .5s ease 0;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons p a:hover {
        color: #fff;
        background-color: #595858;
        border-color: #fff;
        box-shadow: none;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons p a span {
        color: #d4545a;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons p {
        margin-bottom: 15px !important;
    }

    #solid-color-with-text-section .home-sale-wrapper p.heading {
        margin-bottom: 0px;
        font-size: 40px;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons .shop-deals {

        background: #d4545a;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons .dental-stain {
        background: #432f7c;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons .enamel {
        background: #ffa488;
    }

    #solid-color-with-text-section .home-sale-wrapper .buttons .ultrasonic {

        background: #68c8c7;


    }

    #solid-color-with-text-section .home-sale-wrapper .black-friday-logo {
        z-index: 99;
        position: relative;
        text-align: center;    margin-top: 41px;
    }

    #solid-color-with-text-section .home-sale-wrapper .black-friday-logo p {
        margin-top: 20px;
        font-size: 38px;
    }

    #solid-color-with-text-section .home-sale-wrapper .shape {
        position: absolute;
        bottom: -90px;
        left: 45%;
        z-index: 9;   display:none;
    }

    #solid-color-with-text-section .home-sale-wrapper .shape2 {
        position: absolute;
        top: -150px;
        left: 0px;
        z-index: 9;
        display:none;
    }

    #home-page-top-banner-section {
        display: none;
    }

    #solid-color-with-text-section .home-sale-content .buttons span {
        font-style: italic;
        font-weight: 600;
    }

    #solid-color-with-text-section .home-sale-content .extraBold {
        font-weight: 800;
    }

    #solid-color-with-text-section .home-sale-content .italic {
        font-style: italic;
    }

    #solid-color-with-text-section  .flex-div{
        display: flex;
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

    @media screen and (max-width:1050px)  and (min-width:768px) {
        #solid-color-with-text-section .home-sale-wrapper{
            padding-left: 15px;
             padding-right: 15px;
        }
        #solid-color-with-text-section .home-sale-wrapper .black-friday-logo{
            max-width: 50%;
            padding-right: 20px;
        }
        #solid-color-with-text-section .home-sale-wrapper .content-details{
            align-items: center;
        }
    }
    @media screen and (max-width:767px) {
        
        #solid-color-with-text-section .home-sale-wrapper .content-details {
            padding: 15px 0px;   align-items: center;
        }

        #solid-color-with-text-section {
            margin-top: 115px;
        }

        #solid-color-with-text-section .home-sale-wrapper .black-friday-logo img {
            max-width: 290px;
            margin: 0px auto;
            padding: 20px 0px;
        }

        #solid-color-with-text-section .home-sale-wrapper .buttons {
            display: block;
        }

        #solid-color-with-text-section .home-sale-wrapper .content-details {
            flex-direction: column;
        }

        #solid-color-with-text-section .home-sale-wrapper .black-friday-logo p {
            display: none;
        }

        #solid-color-with-text-section .home-sale-wrapper .shape,
        .home-sale-wrapper .shape2 {
            display: none;
        }

        #solid-color-with-text-section .home-sale-wrapper {
            padding-left: 30px;
            padding-right: 30px;
        }

        #solid-color-with-text-section .home-sale-wrapper .text-detail p {
            font-size: 19px;
        }

        #solid-color-with-text-section .home-sale-wrapper .text-detail {
            margin-top: 0px;
        }

        #solid-color-with-text-section .home-sale-wrapper .text-detail .heading {
            font-size: 30px;
        }
        #solid-color-with-text-section .curlyBrackets{ display: none;}
        #solid-color-with-text-section .home-sale-wrapper .buttons p a {
            padding: 7px 15px;
        }
    }
</style>

<section id="solid-color-with-text-section">
    <div class="home-sale-wrapper">
        <div class="shape">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/black-friday-sale/Shape.png;" alt="">

        </div>
        <div class="shape2">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/black-friday-sale/Shape1.png;" alt="">

        </div>
        <div class="home-sale-content">
            <div class="content-details">
                <div class="black-friday-logo">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/black-friday-sale/Siren.png;" alt="Black Friday Deals Are Live">





                    <div class="flex-div-innerright flex-div curlyBrackets">


                            <div class='deal-time-break'></div>
                            <span class='deal-time-bracket'>&nbsp;[</span>
                            <span class="parentSpan">
                                <span class='deal-days deal-time-span daysonly'></span>
                                <span class='deal-time-colon daysonly'>days</span>
                            </span>
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








                    <div class="time-ticker">
                        <div id="the-final-countdown">
                            <p></p>
                        </div>
                    </div>
                </div>

                <div class="text-detail">
                    <p class="heading">Save up to <strong><em> 65%</em></strong> </p>
                    <p class="main-text">Now through Nov, 25 + <strong style="color:#d4545a" class="extraBold italic"> <em>New</em> </strong> <br> <strong> <em>bundle deals</em></strong> & <strong style="color:#d4545a" class="extraBold italic"><em>FREE</em></strong> <strong><em>GIFTS</em></strong> with <br> select items</p>

                    <div class="buttons">
                        <p><a href="/sale" class="shop-deals">SHOP DEAL PAGE</a></p>
                        <p><a href="/product/stain-concealer/" class="dental-stain"><span>NEW!</span> DENTAL STAIN CONCEALER</a></p>
                        <p><a href="/product/teeth-whitening-trays/" class="enamel">
                            <!-- <span>NEW!</span> -->
                             35% OFF WHITENING TRAYS</a></p>
                        <p><a href="/product/night-guards/" class="ultrasonic" >
                            <!-- <span>NEW!</span> -->
                             35% OFF NIGHT GUARDS</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>