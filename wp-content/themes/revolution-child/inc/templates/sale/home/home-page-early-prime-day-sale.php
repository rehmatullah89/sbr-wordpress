<style>
    .row-t{
        /* align-items:center; */
        margin-left:-15px;margin-right:-15px;display:flex;
    }
#solid-color-with-text-section {
    margin-top: 134px;
    overflow: hidden;
    background: #1998ff;
    border-bottom: 4px solid #1e2c53;
}

#solid-color-with-text-section .btn-primary-orange {
    background-color: #1e2c53;
    border-color: #1e2c53;
    color: #fff;
    letter-spacing: 0;
    font-size: 18px;
    padding: 8px 40px;
}

#solid-color-with-text-section .btn-primary-orange:hover {
    background-color: #595858;
    border-color: #595858
}
#solid-color-with-text-section .sectionWrapper {
    background-repeat: no-repeat;
    background-position: right;   padding: 1rem 0;
    background-position-y: top;
    padding-top: 24px;    
}
#solid-color-with-text-section .sectionGraphic img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
}

#solid-color-with-text-section .blur {
  filter: blur(25px);
  animation-name: example;
  animation-duration: .1s;
  animation-delay: .1s;
  animation-timing-function: ease-in-out;
  animation-fill-mode: forwards;
}

#solid-color-with-text-section .no-blur {
  filter: blur(0);
  transition: filter .5s 1s ease-in;
}
@keyframes example {
  from {opacity: 0;}
  to {opacity: 1;}
}
#solid-color-with-text-section .sectionRightText {
    color: #fff;text-align: right;
}
#solid-color-with-text-section  .sale-content-section-left h1{
    color: #fff;
    font-size: 6.5rem;
    line-height: 1;
}
#solid-color-with-text-section  .nopremeMember{
    color: #1e2c53;
    font-size: 24px;   font-weight: 700;
    margin-bottom: 20px;
}
#solid-color-with-text-section  .sale-content-section-left {
    text-align: left;
    max-width: 438px;
}
#solid-color-with-text-section .medium-img {
    /* max-width: 94%;     */
    /* margin-left: auto; */   min-height: 484px;
}
.sectionRightBanner {
    min-width: 825px;
}
#home-page-top-banner-section{display:none}    

.xl-container {
    margin-left: auto;
    margin-right: auto;
}
#solid-color-with-text-section .sectionRightText p {
    font-size: 20px;    line-height: 1.3;
}
@media only screen and (min-width: 768px) {
    .hidden-desktop {
        display: none
    }
}

  @media (min-width: 1300px){
    #solid-color-with-text-section .sale-content-section-left h1{
        /* color: orange; */
    }
  }

  @media (min-width: 1500px){
    #solid-color-with-text-section .sale-content-section-left h1{
            /* color: red; */
        }

  }


  @media (min-width: 1700px){
    #solid-color-with-text-section .sale-content-section-left h1{
            /* color: purple; */
    }
  }


  @media (max-width: 1300px){
    .xl-container {
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }
  }


  @media (max-width: 1200px){

        #solid-color-with-text-section .sale-content-section-left h1{
            font-size: 6vw;
        }
        .sectionRightBanner {
         min-width: 658px;
        }

    }


    @media (max-width: 992px){
        #solid-color-with-text-section .sale-content-section-left h1{
            /* color: brown; */
        }
        .sectionRightBanner {
            min-width: 550px;
        }
        #solid-color-with-text-section .nopremeMember {

            font-size: 18px;
        }

        #solid-color-with-text-section .sectionWrapper{
            padding: 2rem 0;
        }

        #solid-color-with-text-section .medium-img{
            min-height: 318px;
        }

    } 

@media only screen and (max-width: 767px) {
    .hidden-mobile {
        display: none
    }

    .row-t{
        flex-wrap: wrap;
    }
    #solid-color-with-text-section .sale-content-section-left{
        text-align: center;
        max-width: 100%;
        padding-left: 15px;
    padding-right: 15px;        
    }

    #solid-color-with-text-section .sale-content-section-left h1{
        font-size: 60px;
    } 

    .sectionRightBanner {
        min-width: 100%;
    }    

    #solid-color-with-text-section .sectionRightText{
        text-align: center;
    }
    #solid-color-with-text-section .sectionWrapper{
        background-position: top center;
        background-position-y: -527px;
    }
    #solid-color-with-text-section .sectionRightText p {
    font-size: 19px;
    line-height: 1.3;
    }
    #solid-color-with-text-section .medium-img {
        min-height: 245px;
    }
    #solid-color-with-text-section{
        margin-top: 120px;
    }

    .mobileimage {
    margin-top: 20px;
    margin-left: 1rem;
    margin-right: 1rem;  
}

}


</style>



<section id="solid-color-with-text-section">
    <div class="sectionWrapper" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/banner-background-graphic.png)">
        <div class="container xl-container">
            <div class="row-t text-center align-item-center justify-content-center pos-rel">
                <div class="sale-content-section-left">
                    <h1>
                        <span style="color:#1e2c53">Prime</span><br class="">
                        Early<br class="">
                        Access<br class="">
                        Sale
                    </h1>
                    <div class="nopremeMember">
                        No Prime membership? No problem, its open to all! | <span style="color:#fff">Oct 10-12</span>.
                    </div>

                    <div class="sectionRightText hidden-desktop text-center">
                        <p>
                            Get a head start this holiday<br>
                            shopping season & save up to <span style="font-weight:700;">50%</span><br>
                            plus never before seen <span style="font-weight:700;">BOGO</span> deals!

                        </p>
                    </div>

                    <a class="btn btn-primary-orange" href="/sale">SHOP DEALS</a>
                </div>

                <div class="sectionRightBanner">

                
                    <div class="medium-img hidden-mobile" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png">
                            <img class="blur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/thumb-early-prime-day-product-banner.png);" alt="" class="img-fluid hidden-mobile">
                        <noscript>
                                <img class="blur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/early-prime-day-product-banner.png);" alt="" class="img-fluid hidden-mobile">
                        </noscript>
                    </div>
  
                <div class="hidden-desktop mobileimage">                   
                    <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/early-prime-day/mobile-early-prime-day-product-banner.jpg);" alt="" class="img-fluid hidden-mobile">
                </div>
                    <div class="sectionRightText hidden-mobile">
                        <p>
                            Get a head start this holiday<br>
                            shopping season & save up to <span style="color:#1e2c53;font-weight:700;">50%</span><br>
                            plus never before seen <span style="color:#1e2c53;font-weight:700;">BOGO</span> deals!

                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>



<script>

window.addEventListener("load", function() {
  let lazy = document.getElementsByClassName("medium-img");
  for (let n = 0, len = lazy.length; n < len; n++) {
    lazy[n].children[0].setAttribute("src", lazy[n].getAttribute("data-src"));
    lazy[n].children[0].addEventListener("load", function(e) {
      e.target.classList.add("no-blur");
    });
  }
});


</script>