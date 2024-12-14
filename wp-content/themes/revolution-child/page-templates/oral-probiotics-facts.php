<?php
/*

Template Name: Oral Probiotics Facts

*/

get_header();


?>

<style>
/* Page fonts */
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,300&display=swap');

@font-face {
    font-family: 'arial_narrowregular';
    src: url('/wp-content/themes/revolution-child/assets/fonts/arial_narrow-webfont.woff2') format('woff2'),
        url('/wp-content/themes/revolution-child/assets/fonts/arial_narrow-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

@font-face {
    font-family: 'arial_narrowbold';
    src: url('/wp-content/themes/revolution-child/assets/fonts/arial_narrow_bold-webfont.woff2') format('woff2'),
        url('/wp-content/themes/revolution-child/assets/fonts/arial_narrow_bold-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

@font-face {
    font-family: 'dk_butterfly_ballregular';
    src: url('/wp-content/themes/revolution-child/assets/fonts/dk_butterfly_ball-webfont.woff2') format('woff2'),
        url('/wp-content/themes/revolution-child/assets/fonts/dk_butterfly_ball-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

@font-face {
    font-family: 'bebas_neuebold';
    src: url('/wp-content/themes/revolution-child/assets/fonts/bebasneue_bold-webfont.woff2') format('woff2'),
        url('/wp-content/themes/revolution-child/assets/fonts/bebasneue_bold-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

h2 {
    line-height: 1em;
}
.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

/* Page common style */
.row-smile {
    display: flex;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.smile-col-2,
.smile-col-3,
.smile-col-4,
.smile-col-5,
.smile-col-6,
.smile-col-7,
.smile-col-8,
.smile-col-9,
.smile-col-10,
.smile-col-11,
.smile-col-12 {
    padding-left: 15px;
    padding-right: 15px;
}

.smile-col-3 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
}

.smile-col-4 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}

.smile-col-5 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
}

.smile-col-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}

.smile-col-8 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}

.smile-col-12 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}





.acumin {
 font-family: 'Open Sans', sans-serif;
 font-weight: 300!important;

}

.italic {
    font-style: italic;
}

.narrow-fnt {
    font-family: 'arial_narrowregular';
}

.narrow-bold {
    font-family: 'arial_narrowbold';
}

.butterfly {
    font-family: 'dk_butterfly_ballregular';
}

.bebasbold {
    font-family: 'bebas_neuebold';
}

.acumin-fnt {
  font-family: 'Open Sans', sans-serif;
}

.dark-blue-bg {
    background: #1b4764;
}

.blue-text {
    color: #4197cb;
}

.sbr-page-logo img {
    max-width: 240.5px;
}

.mt-0 {
    margin-top: 0 !important;
}

.mt-8 {
    margin-top: 8px;
}

.mt-15 {
    margin-top: 15px;
}

.mt-3rem {
    margin-top: 3rem;
}

.mt-4rem {
    margin-top: 4rem;
}

.mt-5rem {
    margin-top: 5rem;
}

.mt-6rem {
    margin-top: 6rem;
}

.mall-0 {
    margin: 0;
}

.mb-0 {
    margin-bottom: 0px;
}

.uppercase {
    text-transform: uppercase;
}

.text-white {
    color: #fff;
}

.text-yellow {
    color: #FCD96D
}

.text-purple {
    color: #C19ADE
}

.text-orange {
    color: #FF928E;
}

.text-blue {
    color: #1B4764;
}

.text-black {
    color: #000;

}

.weight-500 {
    font-weight: 500;
}

h5 {
    font-weight: 500;
    font-size: 21px;
    line-height: 1.2;
}

.oral-probiotics {
    font-size: 160px;
    line-height: 0.8;
    letter-spacing: -2px;
    margin-bottom: 20px;
}

.presented-by {
    font-weight: 600;
    font-family: Montserrat;
}

.complete-guide-to-microbiome {
    font-size: 28px;
    letter-spacing: 1px;
    padding-bottom: 25px;
}

section.section-good-bad-bacteria {
    padding-top: 30px;
    padding-bottom: 30px;
}

.over700-species {
    font-size: 128px;
    letter-spacing: -2px;

}

.image-graphic {
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.image-graphic-species {
    /* max-width: 1160px; */
    margin-left: auto;
    margin-right: auto;
    margin-top: 3em;
}

.image-graphic-species img {
    max-width: 100%;
}

span.bad-sign {
    font-size: 4.5rem;
}

span.text-ind {
    font-size: 30px;
    line-height: 1;
    padding-left: 7px;
    font-family: Montserrat;
    font-weight: 500;
}

.section-good-bad-bacteria .bacteria-strip {
    margin-top: -53px;
    max-width: 1030px;
    margin-left: auto;
    margin-right: auto;
}

.bacteria-good-bad.good-back {
    margin-right: 7rem;
}


.bacteria-strip {
    display: flex;
    justify-content: space-between;
}

.light-blue-bg {
    background: #e3faff;
}

.white-bg {
    background: #fff;
}

.bacteria-good-bad {
    display: flex;
    align-items: center;
    text-align: left;
}

.special-note.white-bg {
    padding: 6px;
}

.graphic-bacteria-graphic {
    /* max-width: 33%; */
    margin-left: 8%;
}

.graphic-bacteria-graphic img {
    max-width: 100%;
}

.graphic-bacteria-text {
    padding-top: 3rem;
}

.section-healthy-population .graphic-bacteria-text {
    padding-left: 3rem;
}

.section-healthy-population .graphic-bacteria-text {
    padding-top: 4rem;
}


section.section-healthy-population {
    padding-top: 30px;
    padding-bottom: 30px;
}

.section-healthy-population h3 {
    font-size: 95px;
    margin: 0;
    line-height: 1;
    letter-spacing: -2px;
}

.section-healthy-population h2 {
    font-size: 115px;
    margin: 0;
    line-height: 0.8;
    letter-spacing: -0.1px;
}




.section-bottom {
    max-width: 58%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 4rem;
}
section.section-healthy-population .section-bottom{    margin-top: 2rem;}

.section-bad-bacteria h5 {
    line-height: 1.4;
    margin-top: 40px;
}

.nose-ear-mounth-area {
    max-width: 84%;
    margin-left: auto;
    margin-right: auto;
}

.section-bottom img {
    max-width: 100%;
}

.max-100 {
    max-width: 100%;
}


.light-orange-bg {
    background: #fbf0de;
}

.purple-bg {
    background: #f2ecfa;
}

section.section-bad-bacteria {
    padding: 40px 0;
}

.section-bad-bacteria h1 {
    letter-spacing: -1px;
    font-size: 105px;
    line-height: 0.8;
    margin: 0;

}


.section-bad-bacteria h5 {
    /* line-height: 1.4;*/
}

.special-note p {
    font-size: 24px;
    letter-spacing: -1.5px;
    font-weight: normal;
    margin-bottom: 0;
}

.special-note .fnt-30,
.fnt-30 {
    font-size: 30px;
}

.nose-ear-description h5 {
    font-size: inherit;
}

.nose-ear-description {
    font-size: 23px;
    text-align: center;
    margin-top: 2rem;
}

.section-top {
    margin-top: 4rem;
}

.section-improve-oral-microbiome .section-top {
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.lack-of-brusing-mbt {
    margin-top: 2rem;
    margin-bottom: 2rem;
}

section.section-improve-oral-microbiome {
    padding: 30px 0;
}

.section-heading {
    font-size: 120px;
    letter-spacing: -2px;
    line-height: 0.9;
    margin-bottom: 1rem;
}

.section-top p {
    font-size: 34px;
}

.section-top h2 {
    font-size: 64px;
    letter-spacing: -1px;
}

.heading-description-mbt {
    padding-left: 6rem;
    padding-right: 6rem;
}

.page-sub-heading {
    font-size: 26px;
    text-align: center;
    font-weight: 500;
}

.graphic-bacteria-graphic-col {
    text-align: right;
}

.graphic-bacteria-graphic-col img {
    max-width: 85%;
}

.section-improve-oral-microbiome .graphic-bacteria-text h5 {
    font-size: 21px;
}

.section-improve-oral-microbiome h2 {
    font-size: 3.2em;
}

.graphic-large {
    max-width: 70%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 2rem;
    margin-bottom: 4rem;
}

h2.fnt-64 {
    font-size: 64px;
}

h2.fnt-72 {
    font-size: 72px;
}

h2.fnt-76 {
    font-size: 76px;
}

.text-left-mbt {
    text-align: left
}

.align-item-center-mbt {
    align-items: center;
}

p.studies-have-shown {
    margin-bottom: 0;
    font-size: 21px;
    font-weight: 600;
    font-family: Montserrat;
}

.footer-left p {
    font-size: 24px;
    font-family: Montserrat;
    margin: 0;
    line-height: 1;
}

.smile-brilliant-text {
    font-size: 36px;
    font-family: Montserrat;
    line-height: 1;
}

.smile-brilliant-text a {
    color: #1B4764;
}

footer.page-footer {
    padding-top: 2rem;
    padding-bottom: 0rem;
    display:none;
}
footer#footer {
    padding-top: 0;
}
.smilebrilliant-logo {
    text-align: right;
}

.smilebrilliant-logo img {
    max-width: 292px;
}

.text-align-left {
    text-align: left;
}

section.page-top-section {
    margin-top: 60px;
    padding-top: 35px;
}
h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, h6 strong {
    font-weight: bold;
}
.heavy {
    font-weight: 800 !important;
}
.footer{
    padding-top: 30px;
}

section.section-good-bad-bacteria h3{ font-size:35px;}


@media (min-width: 1500px){
 
    .row,.sbr-header-mbt .navbar-expand-lg, .wrapper-mbt {
        /* width: 1170px;
        max-width: 1170px; */
    }
}

/****************/
@media (min-width: 1200px) {
    .container {
        width: 1170px;
    }
}





@media (min-width: 768px) {
    .hidden-desktop {
        display: none;
    }

}


@media (max-width: 1800px) {
    body {
        /* background: red; */
    }
}



@media (max-width: 1500px) {
    body {
        /* background: black; */
    }
}

@media (max-width: 1200px) {
    body {
        /* background: purple; */
    }

    .section-healthy-population h3 {
        font-size: 85px;
    }

    .section-healthy-population h2 {
        font-size: 102px;
    }

    .section-heading {
        font-size: 100px;
    }

    h2.fnt-76 {
        font-size: 62px;
    }

    .section-improve-oral-microbiome h2 {
        font-size: 3em;
    }

    section.page-top-section {
        margin-top: 80px;
    }


}


@media (max-width: 992px) {
    body {
        /* background: green; */
    }

    .oral-probiotics {
        font-size: 120px;
    }

    .over700-species {
        font-size: 98px;
    }

    .complete-guide-to-microbiome {
        font-size: 20px;
    }

    .section-healthy-population h3 {
        font-size: 65px;
    }

    .section-healthy-population h2 {
        font-size: 77px;
    }

    .section-bad-bacteria h1 {
        font-size: 74px;
    }

    .special-note p {
        font-size: 16px;
        letter-spacing: -1px;
    }

    h5 {
        font-size: 16px;
    }

    .section-healthy-population .graphic-bacteria-text {
        padding-top: 3rem;
    }


    .section-heading {
        font-size: 78px;
    }

    .section-top p {
        font-size: 24px;
    }

    .page-sub-heading {
        font-size: 20px;
    }

    .special-note .fnt-30 {
        font-size: 19px;
    }

    .order-2 {
        order: 2;
    }

    .order-1 {
        order: 1;
    }

    .section-healthy-population .graphic-bacteria-text {
        padding-left: 0rem;
    }

    .section-bottom {
        max-width: 100%;
    }

    .graphic-bacteria-graphic-col {
        text-align: center;
    }

    .text-left-mbt {
        text-align: center;
    }


}

/****************/
@media(max-width:767px) {
    h5 {
        font-size: 22px;
    }

    .smile-col-2,
    .smile-col-3,
    .smile-col-4,
    .smile-col-5,
    .smile-col-6,
    .smile-col-7,
    .smile-col-8,
    .smile-col-9,
    .smile-col-10,
    .smile-col-11,
    .smile-col-12 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }


    .oral-probiotics {
        font-size: 70px;
        margin-top: 25px;
    }

    .complete-guide-to-microbiome {
        font-size: 26px;
        padding-bottom: 14px;
    }

    .over700-species {
        font-size: 62px;
    }

    .section-good-bad-bacteria h3 {
        font-size: 22px;
    }

    .hidden-mobile {
        display: none;
    }

    .mobile-banner-top {
        text-align: center;
        margin-top: 30px;
    }

    .mobile-banner-top img {
        max-width: 345px;
    }

    .graphic-bacteria-graphic {
        margin-left: 0;
    }

    .section-healthy-population h3 {
        font-size: 5rem;
    }

    .section-healthy-population h2 {
        font-size: 5.8rem;
    }

    .section-heading {
        font-size: 65px;
    }

    .heading-description-mbt {
        padding-left: 0rem;
        padding-right: 0rem;
        padding-top: 1rem;
        padding-bottom: 2rem;
    }

    .smilebrilliant-logo {
        text-align: center;
    }

    .graphic-bacteria-graphic {
        padding-top: 20px;
    }

    .mobile331 img {
        max-width: 331px;
    }

    .mobile306 img {
        max-width: 306px;
    }

    .nose-ear-mounth-area {
        max-width: 100%;
    }

    .nose-ear-description.hidden-desktop {
        margin-bottom: 3rem;
    }

    .section-improve-oral-microbiome .graphic-large {
        width: 100%;
        max-width: 100%;
    }

    .section-improve-oral-microbiome .graphic-large img {
        max-width: 320px;
        max-width: 287.5px;
    }

    .section-improve-oral-microbiome .graphic-large {
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .smile-brilliant-text {
        margin-bottom: 20px;
    }

    .smile-brilliant-text {
        font-size: 34px;
    }

    .beneth-description {
        margin-top: 20px;
    }

    .special-note p {
        font-size: 18px;
    }

    .section-top p {
        line-height: 1.2;
    }

    p.studies-have-shown {
        line-height: 1;
        margin-bottom: 21px;
        font-size: 28px;
    }

    .section-improve-oral-microbiome h2 {
        margin-bottom: 3rem;
    }

    section.page-top-section {
    margin-top: 65px;
}

section.page-top-section{padding-top: 10px;}


}

@media screen and (device-aspect-ratio: 40/71) {
    .oral-probiotics {
        font-size: 57px;
    }

    .mobile-banner-top img {
        max-width: 100%;
    }

    .mobile331 img {
        max-width: 80%;
    }

    .footer-left p {
        font-size: 20px;
    }

    .smile-brilliant-text {
        font-size: 29px;
    }

    .mobile306 img {
        max-width: 80%;
    }

    .section-healthy-population h3 {
        font-size: 4rem;
    }

    .section-healthy-population h2 {
        font-size: 4.5rem;
    }

    .section-bad-bacteria h1 {
        font-size: 62px;
    }

    .section-heading {
        font-size: 60px;
    }

    .section-top p {
        font-size: 20px;
    }

    .section-improve-oral-microbiome h2 {
        font-size: 2.8em;
    }



}
</style>



<div class="smilebrilliant-page-content" id='oral-probiotics-page'>
    <section class="page-top-section dark-blue-bg text-center ">
        <div class="container">
            <!-- <div class="hidden-mobile">
                <div class="presented-by blue-text sep-top-xs">PRESENTED BY</div>
                <div class="sbr-page-logo mt-8 sep-bottom-md"> <img
                        src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/sbr-logo-tp.jpg' alt="Smile Brilliant "></div>
            </div> -->
            <h1 class="bebasbold text-white uppercase mall-0 oral-probiotics">ORAL Probiotics</h1>
            <h4 class="text-yellow weight-500 complete-guide-to-microbiome">A complete guide to understanding the oral
                microbiome</h4>
        </div>
    </section>


    <section class="section-good-bad-bacteria text-center">
        <div class="container">
            <h2 class="bebasbold uppercase text-purple over700-species mb-0">Over 700 species</h2>
            <h3 class="text-blue weight-500 mt-0">of both <strong class="text-blue">good and bad bacteria</strong> <br
                    class="hidden-mobile">
                populate our mouths all day, every day</h3>
            <div class="image-graphic-species hidden-mobile">
                <div class="image-graphic">
                    <img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/oral-probiotics-over-700-species.jpg'
                        alt="Over 700 species of both good and bad bacteria populate our mouths all day, every day">
                </div>
                <div class="bacteria-strip">
                    <div class="bacteria-good-bad bad-back">
                        <span class="bad-sign text-orange"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <span class="text-ind text-blue">Bad<br>Bacteria</span>
                    </div>
                    <div class="bacteria-good-bad good-back">
                        <span class="bad-sign text-purple"><i class="fa fa-check" aria-hidden="true"></i></span>
                        <span class="text-ind text-blue">Good<br>Bacteria</span>
                    </div>
                </div>
            </div>
            <div class="hidden-desktop mobile-banner-top">
                <img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/mobile-oral-probiotics-over-700-species.jpg'
                    alt="Over 700 species of both good and bad bacteria populate our mouths all day, every day">
            </div>

        </div>
    </section>

    <section class="section-healthy-population light-blue-bg">
        <div class="container">
            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-4 order-2">
                    <div class="graphic-bacteria-graphic mobile331">
                        <img src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/happy-bacteria.jpg' alt="">
                    </div>
                </div>
                <div class="smile-col-8 order-1">
                    <div class="graphic-bacteria-text">
                        <h3 class="bebasbold text-blue">A healthy population</h3>
                        <h2 class="bebasbold text-purple">of good bacteria</h2>
                        <div class="beneth-description">
                            <h5 class="text-blue"><strong class="text-blue">is the key to creating a microbiome</strong>
                                that<br class="hidden-mobile">
                                eliminates bad breath, reduces cavities and fights<br class="hidden-mobile">
                                gum inflammation.<h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-smile section-bottom">

                <div class="nose-ear-description hidden-desktop mt-0">
                    <h5 class="text-blue"><strong class="text-blue">The good bacterium also populate the sinuses to
                            reduce infections in the ears, nose, and throat.</strong></h5>

                </div>

                <div class="nose-ear-mounth-area">
                    <img class="hidden-mobile" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/nose-ear-face.jpg' alt="">
                    <img class="hidden-desktop" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/mobile-nose-ear-face.jpg'
                        alt="">
                </div>
                <div class="nose-ear-description hidden-mobile">
                    <h5 class="text-blue"><strong class="text-blue">The good bacterium also populate the sinuses to
                            reduce infections in the ears, nose, and throat.</strong></h5>

                </div>
            </div>
        </div>
    </section>


    <section class="section-bad-bacteria light-orange-bg">
        <div class="container">
            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-8">
                    <div class="graphic-bacteria-text">
                        <h1 class="uppercase text-orange bebasbold">Bad bacteria </h1>
                        <div class="special-note">
                            <p class="acumin italic text-blue">(Streptococcus mutans, Streptococcus sanguis, & hundreds
                                of other
                                species)</p>
                        </div>
                        <div class="hidden-mobile">
                            <h5 class="text-blue"><strong class="text-blue">is constantly regenerating and populating
                                    the
                                    micro crevasses on your teeth and gums.</strong> They
                                create a film on your teeth that leads to plaque
                                and tartar. </h5>
                            <h5 class="text-blue">These bad bacteria consume sugar from your food
                                and produce waste in the form of acid and volatile
                                sulfur compounds (VSCs).<strong class="text-blue"> The acid creates cavities
                                    and the VSCs cause bad breath.</strong></h5>
                        </div>
                    </div>
                </div>
                <div class="smile-col-4">
                    <div class="graphic-bacteria-graphic-col mobile306">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/graphic-backteria-with-teeth-orange.jpg"
                            alt="" class="max-100">
                    </div>

                    <div class="hidden-desktop mt-4rem">
                        <h5 class="text-blue"><strong class="text-blue">is constantly regenerating and populating
                                the
                                micro crevasses on your teeth and gums.</strong> They
                            create a film on your teeth that leads to plaque
                            and tartar. </h5>
                        <h5 class="text-blue">These bad bacteria consume sugar from your food
                            and produce waste in the form of acid and volatile
                            sulfur compounds (VSCs).<strong class="text-blue"> The acid creates cavities
                                and the VSCs cause bad breath.</strong></h5>
                    </div>

                </div>
            </div>
        </div>
    </section>




    <section class="section-bad-bacteria light-blue-bg">
        <div class="container">
            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-8">
                    <div class="graphic-bacteria-text">
                        <h1 class="uppercase text-purple bebasbold">GOOD bacteria </h1>
                        <div class="special-note">
                            <p class="acumin italic text-blue">(lactobacillus plantarum, streptococcus salivarius, etc)
                            </p>
                        </div>
                        <div class="hidden-mobile">
                            <h5 class="text-blue"><strong class="text-blue">crowd out and fight the bad
                                    bacteria.</strong>
                                They keep
                                the bad bacteria population under control and
                                keep the oral microbiome in a healthy balance.</h5>
                        </div>
                    </div>
                </div>
                <div class="smile-col-4">
                    <div class="graphic-bacteria-graphic-col mobile306">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/blue-graphic-good-backteria-with-teeth.jpg"
                            alt="" class="max-100">
                    </div>

                    <div class="hidden-desktop mt-3rem">
                        <h5 class="text-blue"><strong class="text-blue">crowd out and fight the bad
                                bacteria.</strong>
                            They keep
                            the bad bacteria population under control and
                            keep the oral microbiome in a healthy balance.</h5>
                    </div>

                </div>
                <div class="smile-col-12">
                    <div class="special-note white-bg lack-of-brusing-mbt">
                        <p class="acumin italic text-blue">Lack of brushing, poor quality foods/high sugar, lack of
                            water, and dry
                            mouth can lead to an over-population of bad bacteria.</p>
                    </div>
                </div>
            </div>

            <div class="row-smile">
                <div class="smile-col-4">
                    <div class="graphic-bacteria-graphic-col text-left-mbt mobile306">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/blue-graphic-paste-brush-backteria-kill.jpg"
                            alt="" class="max-100">
                    </div>
                </div>
                <div class="smile-col-8">
                    <div class="graphic-bacteria-text">
                        <h5 class="text-blue"><strong class="text-blue">Additionally, when you brush with toothpaste
                                (which
                                has soap) or rinse with an alcohol-based mouthwash,
                                you are essentially sterilizing your mouth and killing
                                all the good AND bad bacteria.</strong>
                        </h5>
                        <h5 class="text-blue">
                            Unfortunately, the bad bacteria tends to grow back fast
                            and often over-populate your mouth before the good
                            bacteria has time to fight. (This is why we often hear
                            stories of people who regularly use mouthwash but
                            have bad breath)</h5>
                    </div>
                </div>


            </div>

        </div>
    </section>



    <section class="section-improve-oral-microbiome purple-bg">
        <div class="container">
            <div class="section-top text-center">
                <h1 class="section-heading uppercase bebasbold text-blue">So how do you improve
                    oral microbiome?</h1>
                <p class="text-purple montserrat heavy ">Dental probiotics for oral and sinus support</p>

                <div class="graphic-large">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/purple-happy-teeth-microbiome.jpg" alt=""
                        class="max-100">
                    <!-- <img class="hidden-desktop" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/mobile-purple-happy-teeth-microbiome.jpg" alt=""
                        class="max-100"> -->

                </div>

                <h2 class="uppercase text-purple fnt-76 bebasbold">Dental probiotics are chewable tablets </h2>

            </div>




            <div class="heading-description-mbt">
                <h4 class="page-sub-heading text-blue text-blue"><strong class="text-blue">with concentrated amounts of
                        the
                        healthy bacteria your
                        mouth needs.</strong> Chewed once a day before bed (after
                    brushing/flossing/rinsing), these tablets populate your
                    mouth with the good stuff first!</h4>
            </div>
            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-4 ">
                    <div class="graphic-bacteria-graphic-col text-align-left mobile306">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/purple-leaves-less-opportunity-bad-bacteria.jpg"
                            alt="" class="max-100">
                    </div>
                </div>
                <div class="smile-col-8">
                    <div class="graphic-bacteria-text">
                        <h2 class="uppercase text-purple bebasbold">This leaves less opportunity for
                            the bad bacteria to take hold. </h2>

                        <h5 class="text-blue"><strong class="text-blue">By repeating this process on a daily
                                basis,</strong> studies
                            have shown that you can truly change the
                            microbiome of your mouth and increase the
                            population of good bacteria while subsequently
                            reducing the population of bad bacteria.</h5>
                    </div>
                </div>
                <div class="smile-col-12">
                    <div class="special-note white-bg lack-of-brusing-mbt">
                        <p class="acumin italic text-blue fnt-30">This process is often referred to as Microbiome Rejevenation Therapy or Bacterial
                            Replacement Therapy.</p>
                    </div>
                </div>
            </div>

            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-8">
                    <div class="graphic-bacteria-text">
                        <p class="studies-have-shown"><strong class="text-blue">Studies have shown that clinical grade
                            </strong></p>
                        <h2 class="uppercase text-purple bebasbold dental-probiotics-heading mt-0">dental probiotics
                            <span class="text-blue">reduce</span> plaque,
                            cavities, gum inflammation
                            and bad breath
                        </h2>
                        <div class="hidden-mobile mt-3rem">
                            <h5 class="text-blue">
                                over brushing and flossing alone. Further, they
                                help improve the upper respiratory immunity
                                in both children and adults.</h5>
                        </div>
                    </div>
                </div>

                <div class="smile-col-4">
                    <div class="graphic-bacteria-graphic-col mobile306">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/purple-dental-probiotics-reduce-plaque.jpg"
                            alt="" class="max-100">
                    </div>
                    <div class="hidden-desktop mt-3rem">
                        <h5 class="text-blue">
                            over brushing and flossing alone. Further, they
                            help improve the upper respiratory immunity
                            in both children and adults.</h5>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <footer class="page-footer">
        <div class="container">
            <div class="row-smile align-item-center-mbt">
                <div class="smile-col-6">
                    <div class="footer-left">
                        <p class="text-blue">To order or learn more, visit </p>
                        <div class="smile-brilliant-text text-blue heavy">
                            <a target="_blank" href="https://www.smilebrilliant.com/">smilebrilliant.com</a>
                        </div>
                    </div>
                </div>
                <div class="smile-col-6">
                    <div class="smilebrilliant-logo">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/page-oral-probiotics/oral-probiotics-page-footer-logo.jpg" alt=""
                            class="max-100" />
                    </div>
                </div>


            </div>
        </div>

    </footer>





</div>



<?php

get_footer();

?>
