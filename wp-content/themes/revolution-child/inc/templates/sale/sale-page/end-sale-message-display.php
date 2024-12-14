<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,900&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
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
    background-color: #6ca9d4;
    margin-top: 3px;
    padding-top: 41px;
    padding-bottom: 35px;
    }

    .row-t{
        margin-left: -15px;
    margin-right: -15px;
    display: flex;        
        align-items: center;
    }    
    .v-col-sm-4, .v-col-sm-8{
        padding-left:15px;
        padding-right:15px;        
    } 
    .v-col-sm-8 {
        -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
.v-col-sm-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}

.v-col-sm-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}


.font-mont-black {
    font-family: 'Montserrat', sans-serif;
    font-weight: 900;
    font-style: italic;
}
.sectionTopBanner {
    text-align: left;
}
.mother-dayText {
    font-size: 66px;
    font-family: 'Pacifico', cursive;
    color: #fff;
    line-height: 1.2;margin-bottom: 16px;
}
.featureDeals{
    font-size: 74px;
    font-family: 'Montserrat';
    font-weight: 900; line-height: 1;
}
.orange-light-text{
    color:#f0c6c7;
}
.blue-text{
    color:#3c98cc;
}

.sectionTopBanner p{
    font-size: 25.5px;
    margin:0;
    line-height:1.2;
    color:#fff;
}
.messageWithNoSale.font-mont {
    max-width: 820px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 30px;
    text-align: center;
}



@media only screen and (max-width: 1200px) {
    .featureDeals {
    font-size: 56px;
}
.mother-dayText {
    font-size: 52px;
}
.sectionTopBanner p {
    font-size: 19px;
}



}



@media only screen and (max-width: 767px) {
#solid-color-with-text-section{
    padding-top: 20px;
    padding-bottom: 25px;
}


.v-col-sm-4,.v-col-sm-8 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}

.v-col-sm-4{order:1;}
.v-col-sm-8{order:2;}
.sectionTopBanner {
    text-align: center;
}
.sectionGraphic img {
    max-width: 170px;
}

}

</style>
        <section id="solid-color-with-text-section">
            <div class="container">
                <div class="text-center align-item-center justify-content-center">

                    <div class="v-col-sm-12 sectionTopBanner">

                        <div class="messageWithNoSale font-mont">
                            <style>
/* no sale message */
.pacifico{
    font-family: 'Pacifico', cursive;
}
.hideSection{display:none !important;}
.messageWithNoSale {
    color: #fff;
    font-size: 38px;
    line-height: 1.2;    
}
.text-color-light-orange{
    color: #f0c6c7;
}
.text-color-blue{
    color: #f8a18a;
}
span.upcommingDealsText {
    margin-top: 10px;
    display: inline-block;
    font-size: 34px;
    letter-spacing: 1px;
}
.weight900{ font-weight:900;}
.footer{
                                    padding-top: 0;
                                }


                                @media only screen and (max-width: 767px) {
                                    .messageWithNoSale{
                                        font-size: 34px;  
                                    } 
                                    span.upcommingDealsText {
                                        font-size: 22px;
                                        letter-spacing: 0px;
                                    }  
                                }

/* no sale message Ends */                                

                            </style>
                            <span class="weight900">Our  Sale is closed now.</span>
                            <span class="upcommingDealsText">Find out about our upcoming deals by subscribing to our newsletter.</span>
                        </div>
                    </div>
                </div>
            </div>        
        </section>       
    
