<?php

/*

Template Name: Reviews page

*/

get_header();

?>


<style type='text/css'>
.review-stars-title-text {
    font-family: Montserrat;
    font-weight: 400;
    padding-left: 10px;
    text-align: left;
    float: left;
    font-size: 20px; 
    line-height: 28px;
    color: #565759;
}
.review-stars-icon-wrap {
    float: left;
    padding-right: 10px;
}
  
.review-stars-icon-wrap img {
    max-width: 60px;
}

.star-container {
    font-size: 1.5em;
    position: relative;
    display: inline-block;
}

.star-under {
    color: #cecece;
    vertical-align: top;
}
.star-over {
    color: #f5d060;
    position: absolute;
    left: 0;
    top: 0;
    overflow: hidden;
}
.review-stars-score-text {
    float: left;
    padding-left: 20px;
    font-size: 1.4em;
    line-height: 0px;
    padding-top: 10px;
}
.review-stars-link {
    float: right;
    padding-right: 10px;
    padding-left: 40px;
    font-size: 1.0em;
    line-height: 0px;
    padding-top: 10px;
    display: block;
}
table {
    background-color: transparent;
border-spacing: 0;
    border-collapse: collapse;
    border: 0px; background: none;

}
table:not(.variations):not(.shop_table):not(.group_table) thead, table:not(.variations):not(.shop_table):not(.group_table) tbody, table:not(.variations):not(.shop_table):not(.group_table) tfoot {
    border: 0px solid #f1f1f1;
    background-color: transparent;
}
table:not(.variations):not(.shop_table):not(.group_table) tbody th, table:not(.variations):not(.shop_table):not(.group_table) tbody td {
    padding: 0;
}
.sep-bottom-md {
    padding-bottom: 3em;
}
.sep-top-md {
    padding-top: 3em;
}
h2.product-header-sub{
    margin-bottom: 70px;    margin-top: 17px;
}
.progress {
    margin-bottom: 20px;
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: none;
    height: 22px;
    margin: 0px;
    padding: 0px;    

}
.progress-bar {
    float: left;
    width: 0;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #337ab7;
    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}
.progress .progress-bar {
    text-align: left;
    padding: 0 0 0 13px;
    line-height: 32px;
    box-shadow: none;
}
.progress .progress-bar {
    background: #3c98cc;
}
table:not(.variations):not(.shop_table):not(.group_table) tbody tr:nth-child(even) {
    border-bottom: 0;
    background-color: transparent;
}
.review-stars-write-review-wrap {
    text-align: center;
    padding-left: 45px;
    padding-right: 45px;
    padding-top: 50px;
}
.review-stars-write-review-text {
    font-size: 20px;
    line-height: 28px;
    color: #565759;
}
.sep-top-sm {
    padding-top: 2.2em;
}
.sep-top-4x {
    padding-top: 7.5em;
}
.review-youtube, .review-image-with-text, .review-text-only {
    padding: 20px;
    border: solid #e1e1e1 1px;
}

    .masonry-grid-reviews-col
    {
        margin-top:40px;
    }

    .masonry-grid-reviews-sizer,
    .masonry-grid-reviews-col
    {
        width:45%;
    }
    .masonry-grid-reviews-gutter-sizer
    {
        width:10%;
    }

    .sep-bottom-xs {
        padding-bottom: 1.5em !important;
    }
.title-heading{
    font-weight: bold;
    color: #4597cb;
    font-size: 22px;    
}

.sens-teeth{
    text-align: right;
    color: #868787;
    padding-top: 10px;
    font-weight: normal;
    font-size: 12px;    
}
.actual-review-text{ font-size: 15px; color: #565759; }
.review-container .masonry-grid-reviews-col .row{     width: 110%; }
table tbody th, table tbody td { font-size: 14px; }


    @media (min-width : 769px){
    
}

    @media (max-width : 768px)
    {
        .masonry-grid-reviews-sizer,
        .masonry-grid-reviews-col
        {
            width:100%;
        }
        .masonry-grid-reviews-gutter-sizer
        {
            width:0%;
        }
    .sep-top-4x {
        padding-top: 0.5em;
    }
.product-header-primary {
    font-size: 2.3em;
}
section .product-header-sub{
    font-size: 1.2em;
margin-bottom: 30px;
}


.review-stars-title-text {
    font-size: 1.1em;
}    
#review-stars-google-wrap {
    padding-top: 70px;
    padding-left: 30px;
    padding-right: 30px;
}

.review-stars-write-review-wrap {
    text-align: center;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 50px;
}
.col-md-12.title-heading{
        font-size: 1.2em;
    text-align: left;
}

.review-container .masonry-grid-reviews-col .row {
    padding-bottom: .5em !important;
}
.star-container{ line-height: 1em;     font-size: 1.2em;}


.review-stars-score-text{ font-size: 1.0em; }

    }

    @media (min-width : 1200px)
    {
        .masonry-grid-reviews-sizer,
        .masonry-grid-reviews-col
        {
            width:47%;
        }
        .masonry-grid-reviews-gutter-sizer
        {
            width:6%;
        }
    }



    @media (min-width : 1500px)
    {
        .masonry-grid-reviews-sizer,
        .masonry-grid-reviews-col
        {
            width:30%;
        }
        .masonry-grid-reviews-gutter-sizer
        {
            width:3%;
        }
    }

.masonary-grid-container{}
.w-100{ width: 100%; }


    @media (min-width: 768px){
        .masonry-grid-reviews-col .col-md-6{ 
-ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
        }
    

    }

@media (max-width: 1024px){
    .review-container .masonry-grid-reviews-col .row {
        width: 100%;
    }




}
@media all and (device-width: 768px) and (device-height: 1024px){

   .col-md-5 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
}

.col-md-7 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
}

}

@media (max-width: 1024px){
   .col-md-5 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
}

.col-md-7 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
}
.spacing-mobile{ padding-left:15px; padding-right:15px;}

}

@media (max-width: 767px){
   .col-md-5 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}

.col-md-7 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}


}

</style>


<section class="text-center sep-top-4x sep-bottom-xs spacing-mobile">
        <h1 class="product-header-primary">CUSTOMERS SPEAK FOR US</h1>
        <h2 class="product-header-sub">Reviews of our industry-changing teeth whitening products.</h2>
    </section>

<section style="background-color:#f8f8f8;" class="masonary-grid-container">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row sep-top-md sep-bottom-md">
                <div class="col-md-4" id="review-stars-sb-wrap">
                    <div style="clear:both;">
                        <div class="review-stars-icon-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon-96x96.png">
                        </div>
                        <div class="review-stars-title-text">
                            SMILE BRILLIANT <br>CUSTOMER REVIEWS
                        </div>
                    </div>
                    <div style="clear:both;width:100%;padding-top:10px;">
                        <div style="float:left;">
                                            <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                    <span class="star star-under fa fa-star"></span>
                    <span class="star star-over fa fa-star" style="width:70%;"></span>
                </div>
                                </div>
                        <div class="review-stars-score-text">
                            4.7/5
                        </div>
                        <a href="#" onclick="localStorage[&quot;contactFormContactType&quot;] = &quot;review&quot;;window.location.href=&quot;/contact&quot;;return false;" class="review-stars-link">
                            Write Review
                        </a>
                    </div>
                    <div style="clear:both;padding-top:10px;">
                        <table style="width:100%;text-align:left;" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                5 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100" style="width:83%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                83%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                4 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="100" style="width:13%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                13%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                3 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                1%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                2 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:2%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                2%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                1 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                1%
            </td>
        </tr>
                        </tbody></table>
                    </div>
                </div>

                <div class="col-md-4" id="review-stars-google-wrap">
                    <div style="clear:both;">
                        <div class="review-stars-icon-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/google-trust-store-logomark.png">
                        </div>
                        <div class="review-stars-title-text">
                            GOOGLE CUSTOMER<br>VERIFIED REVIEWS
                        </div>
                    </div>
                    <div style="clear:both;width:100%;padding-top:10px;">
                        <div style="float:left;">
                                            <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                  <span class="star star-under fa fa-star"></span>
                  <span class="star star-over fa fa-star" style="width:100%;"></span>
                </div>
                    <div class="star-container">
                    <span class="star star-under fa fa-star"></span>
                    <span class="star star-over fa fa-star" style="width:80%;"></span>
                </div>
                                </div>
                        <div class="review-stars-score-text">
                            4.8/5
                        </div>
                        <a href="https://www.google.com/shopping/customerreviews/merchantreviews?q=smilebrilliant.com" target="_blank" rel="nofollow" class="review-stars-link">
                            See All
                        </a>
                    </div>
                    <div style="clear:both;padding-top:10px;">
                        <table style="width:100%;text-align:left;" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                5 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width:84%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                84%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                4 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width:11%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                11%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                3 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:2%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                2%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                2 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:2%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                2%
            </td>
        </tr>
        <tr>
            <td style="width:60px;vertical-align:top;padding-top:10px;">
                1 Star
            </td>
            <td style="padding-top:10px;">
                <div class="progress" style="height:22px;margin:0px;padding:0px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width:2%;height:22px;margin:0px;padding:0px;"></div>
                </div>
            </td>
            <td style="width:40px;vertical-align:top;padding-top:10px;padding-left:20px;">
                2%
            </td>
        </tr>
                        </tbody></table>
                    </div>
                </div>
                <div class="col-md-4 review-stars-write-review-wrap">
                    <div class="review-stars-write-review-text">
                        Helpful information - good or bad - should always be available to everyone. We genuinely appreciate the feedback!
                    </div>
                    <div class="sep-top-sm">
                        <a href="#" onclick="localStorage[&quot;contactFormContactType&quot;] = &quot;review&quot;;window.location.href=&quot;/contact&quot;;return false;" class="btn btn-primary-orange">WRITE A REVIEW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="review-container">
   <div style='overflow:hidden;'>
      <div class="container sep-top-sm">
         <div class='row w-100'>
            <div class='sep-bottom-lg w-100'>
               <div class="masonry-grid-reviews w-100" style='margin-top:-40px;'>
                  <div class="masonry-grid-reviews-sizer"></div>
                  <div class="masonry-grid-reviews-gutter-sizer"></div>
                                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How I whiten my teeth at home                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=aOBB-n6HLAs' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/mansutti.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Danielle M. - Black Rock, Australia (21 Years Old)            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Alex &amp; I Tried This &amp; Loved It               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=khX2E-YZbfw' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/aliandreea.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Ali Andreea - Paris, France           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My At Home Teeth Whitening Routine               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=8ud8kCTD8ps' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-leelee.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Lee F. - East Islip, NY           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T9 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Best Teeth Whitening for Stains &amp; Dental Work                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=8R1LhyFkYHk' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-beautysplurge.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Lisa P. - Attleboro, MA           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Best purchase I made this year               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/fernanda-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Fernanda - Jackson, MS (30 Years Old)                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I’ve used whitening strips a lot but had trouble getting all of my teeth white. I learned about your product on Youtube. The video talked about whitening crooked teeth. I’m seriously amazed and the before and after pics I just sent you!          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I want to say Smile Brililant is AWESOME!                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/jose-d-tallahassee-teeth-whitening-results.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Jose D. - Tallahassee, FL (31 Years Old)                           
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I really love this product; I was a little skeptical at first because there are many companies out there that claim to do the same thing at a much cheaper price. After reading the reviews, I decided to give you a chance and I discovered that Smile Brilliant is legit. Their service was very polite and cooler than the other side of the pillow. The trays and gel got here before the estimated arrival date which was awesome! This was the first time using a teeth whitening product and I am not disappo          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My teeth are much whiter             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/hannah-austin-tx-teeth-bleaching-before-and-afters.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Hannah S. - Austin, TX (27 Years Old)                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I’m an avid brusher and flosser but I drink coffee every morning before work. I don’t think I realized how dark my teeth had gotten until I started using your custom-fitted trays. I have had many of my friends ask me specifically about my teeth. I’m happy to recommend Smile Brilliant to everyone I meet!          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How To Get White Teeth Fast!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=2F9hunmLwsI' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-makeupbyamarie.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              MakeupbyAmarie            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I think I've found the holy grail                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I have an obsession with white teeth. I mean really I do. I've tried EVERYTHING on the market that claims to make your pearly whites, well white. But after going through every single thing from strips, to trays with the light, to 3 step tooth paste systems. I think I've found the holy grail.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Kayla P. - Poughkeepsie, NY                
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>              
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Trays fit nice and its definitely working                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/Melissa-30905-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Melissa W. - Rossendale, United Kingdom                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I have already noticed a huge difference which is fantastic! I shall be using it for a couple more days then I shall send better photos if that's ok? They fit great and actually are quite comfortable.          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How to Whiten Teeth At Home              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=a8YSFcGpsAA' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-lilisimply.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Lilisimply            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I am very grateful that I took the time out to try this great product!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/brittany-westland-mi-before-and-after-teeth-whitening.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Brittany W. - Westland, MI (32 Years Old)                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              Great results. Very happy my cousin recommended it to me.         
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           At home teeth whitening              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=w3yVqD6swRM' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-xsparkage.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              xsparkage             
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Much cheaper than getting same product from my dentist               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How I whiten my teeth at home                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=YQeMQuad3yU' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/alyshia_jones.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Alyshia J. - New Zealand (21 Years Old)           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Happy Smoker             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/brian-s-baton-roughe-before-and-after-teeth-whitening.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Brian S. - Denville, NJ (56 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T9 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              My wife bought me this teeth whitening kit. I think my teeth had become really yellow and have very dark stains around the edges. I smoked for 25+ years and quit a little over a year ago. I saw immediate changes to my teeth and got the results you see after about 14 applications. I would definitely recommend to others.          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Smile on fleek               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/kay-47077-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Kay B. - Greensboro, NC                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              My teeth have not been this white since probably high school. My hopes wasn't that high but it definitely beats goin to a dentist. who wants to spend $500 to get there tooth whitened :-)            
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Excellent product, fast service!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Smile Brilliant has amazing customer service.                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Smile Brilliant has amazing customer service. Any question I had, they were there to answer.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           So, do I LOVE Smile Brilliant? Yes!              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/66948-hannahp-whitening-photos.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Hannah P. - Oswego, IL                             
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              The first thing I mentioned was my sensitive teeth. I’ve avoided whitening from the dentist in fear of never eating or drinking again. My wonderful Smile Brilliant representative, Jessica, understood my hesitation and explained the desensitizer.
                              I was so excited to not only whiten my teeth, but not have to deal with increased sensitivity! I got an amazing teeth whitening outcome without the dentist cost. The whole kit is amazing and their customer service is top notch.           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Teeth Care? How I Whiten My Teeth! :)                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=-VBUCWUPFmY' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-luhhsettyxo.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Lisette - Longwood, FL (20 Years Old)         
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           This is truly an amazing product!                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              This is truly an amazing product! I have struggled for years to get my teeth white. Spending tons of money on kits that don't work and countless "white strips". I finally found something that was able to whiten my teeth beautifully! I got such amazing results and had zero sensitivity issues which can be common with teeth whitening products. Michael was so sweet and helpful and was such a pleasure to work with as well!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Nicole W.              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How I whiten my teeth                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=mmnEEYERXO8' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/kelli_tanner.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Kelly W. - Las Vegas, NV          
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My dentist recommended me here               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/jordano-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Jordan O. - Ballwin, MO (28 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I was referred to Smile Brilliant from my dentist. She does not do the custom-fitted whitening trays at her office so she sent me to you. The process was very simple. I take good care of my teeth and did not realize they were so stained. Very happy with results.            
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Super happy with everything!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I accidentally sent my package to my parents house and once I contacted customer service to get it fixed they replied in less than 30 mins! Super happy with everything!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Priced well below retail             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Simple quick and easy, exactly what I expected, Priced well bellow retail.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I’m so happy with my results!                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=nxMbre3pePA' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/brianna_fox.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Briana F. - Chicago, IL           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           UM DIA ESPECIAL PARA VC! (en espanol)                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=3sgibVsApoA' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-fafella.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Fafella           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My family noticed big changes                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/darby-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Darby D - Portland, OR                             
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              My family drinks much tea. I was first to try whitening teeth when I saw your video. I did not make my impressions good on first try but second try was much better. You can see that my teeth have changed a lot. I am very very happy!          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Still waiting on results             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/vanessa-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Vanessa (25 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I'm very happy that I have not had sensitivity! This was my biggest concern. Still waiting to see big changes. You can see a little change in my teeth so far.            
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Están de vuelta con el color que quería...!              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/32350-frankod-teeth-before-after.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Franko D. - Chicago, IL                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              Los trays son muy cómodos que no duelen y se ajustan perfectamente, apenas se pueden sentir. Puedo usarlos durante aproximadamente 2 horas sin ninguna molestia...No se hizo alteración alguna para las fotos – estos son mis resultados genuinos. lo recomiendo a cualquiera que quiera hacer su sonrisa un poco más vibrante y brillante !!             
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Teeth Whitening for Less             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=IN0ye02Xe5g' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-blaklzbeautyful.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Blaklzbeautyful           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Cheaper alternative to dentist whitening             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/24360-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Laven M. - Essen, Germany                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I absolutely love red lipstick! One of the problems while wearing red lipstick, especially the bolder colors, is that they might make your teeth look more yellowish than they are. There is nothing worse than putting on your favourite red lipstick and discovering that your teeth are so stained that the red makes it look even more awkward…There are many ways to get rid of the stain on your teeth, including home remedies but the most effective way is probably bleaching your teeth at the dentist, wh          
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           What An amazing product to have available right before my wedding day.               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Smile brilliant has made a huge difference in my smile and is extremely comfortable.
                              Definitely recommend this product for those who don't want to spend 100's of dollars getting them whitened at the dentist.
                              Very satisfied and happy with my new smile 
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Valerie L.                 
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I'm very pleased with my teeth whitening product. It works very well.                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Preparing for the FIRST DAY OF SCHOOL!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=Ak2TDTvRVKQ' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-fabulousinmaking.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Kennedy C.            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Blanqueamiento Dental Smile Brilliant Y Sorteo (spanish)             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=RwhbJ1tWDOM' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-yasmany.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Yasmany           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           teeth stains bothered me             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/demitra-23782-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Demitra K. - Athens, Greece                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I wanted so much to have a brighter smile as some teeth stains bothered me and I gave a try to Smile Brilliant kit. I'm very happy to get my trays.           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How to Whiten Teeth at Home (THE BEST WAY)               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=sWj_H8G2gDA' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-roserusso.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Rose R. - Canada          
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Working well so far. Great service.              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/craig-kimball-mi-teeth-whitening-before-and-afters.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Craig F. - Kimball, MI (37 Years Old)                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I started my 1st and 2nd treatment on consecutive days for 3 hrs each time. I found that to be a little too sensitive for my gums, so I spread it out to around every 3rd day still at 3 hrs. That seemed to be a lot easier to handle. Session 4-7 were spread out about 4-5 days apart as I travel a lot and it just didn't seem to fit in my schedule. I think the color changed quite a bit. I will continue to use the product.          
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My dentist recommended me                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/justin-montreal-teeth-bleaching-before-and-after.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Justin J - Montreal, Quebec, Canada (31 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I spent a few years and a lot of money to have my teeth straightened. When my braces came off, the color was very different. I went home, did a little research and came across your company and opted to give Smile Brilliant a try instead of my dentist. I’m extremely happy with my new smile.            
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Product already working!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Extremely fast, very easy ordering, product already working!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Great product. Fast delivery.                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           great customer service and good product              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/morgan-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Morgan                             
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              Have begun seeing great results. I'll continue my treatments. There was quite a bit of sensitivity on my last treatment but I has been quite easy thus far.           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Red lipstick with white teeth                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/fabstack-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Rebecca L. - Boulder, CO (28 Years Old)                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              The pictures I sent show you how my teeth look with red lipstick. I think they looked great for the wedding!          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Como blanquear dientes MUY amarillos en casa. (spanish)              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=HRxxu-XvEuM' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-makeupbymh.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              MakeupByMh            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How to get white teeth at home               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=HhLKyh4q4TA' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-ohhmyannie.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              OhhMyAnnie            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How To: WHITEN Yellowing Teeth At Home w. Professional Results!              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=vQthkGCHtNg' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/sylvia_gani.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Sylvia G.             
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Great product with significant results               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Great product with significant results. Took me about 5 sessions to see the results, but with monthly maintenance I have been able to keep my pearly whites looking white.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Anne D.                
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           The customer service was great and the package was sent and returned back fast.              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I am planning on purchasing again!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I have only used this product twice, but so far I think it is making a difference! It came really fast and had some great instructions with it! I am planning on purchasing again!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Very happy with purchase. The product came on time.              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Took too long to deliver             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I was so excited to use this product for an event coming up but they sent me both trays of my upper teeth! I'm so disappointed and will not have my trays ready in time. Next time, I hope Smile Brilliant pays more attention to what they're doing.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Rouen R.               
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How I whiten my teeth!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=o_yj5oB5WRg' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/becca_bristow.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Becca B.          
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I had great results              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/ahaiwe-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Chimee A. - Houston, TX (34 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I had great results, very east to use and quick turnaround.           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I only used 1 syringe so far             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/jenny-cypress-one-whitening-syringe-used.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Jenny C. - Montreal, Quebec, Canada (31 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              Thank you for helping me! The trays are so comfortable and so easy to use. The whole process of whitening was painless! I really appreciate your awesome customer service! Thank you again!           
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How to get white teeth               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=JiDPCCIyTZQ' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-ravenelyse.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Raven E. (22 Years Old)           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T9 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Affordable. Simple. Easy to use.             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=fTsYHvRGEJo' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/1975al.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Allison F. - VA (19 Years Old)            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How I whiten my teeth at home                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=GIh0_17EiRQ' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/allofdestiny.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              AllofDestiny - Memphis, TN            
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My at-home whitening routine             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=uVlWQLhwXi8' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/coco_lili.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              CocoLili          
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Whiten Yellow Teeth At Home w/ Professional Results              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=EmytWa3MjWU' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/kim_holden.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Kim H. - Farmington, CT           
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-youtube'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           How to: Whiten your teeth at home                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <a style='display:block;text-decoration:none;border:none;' rel='nofollow'  href='https://www.youtube.com/watch?v=hLszL6oqWHI' target='_blank' class='col-sm-12'>
                           <img class='img-responsive' style='text-decoration:none;border:none;' onload="try{n__refreshMasonryLayout();}catch(err){}" src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/testimonial-video-nabelanoor.jpg'/>
                           </a>
                           <div class='col-md-6' style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                              Nabela N.             
                           </div>
                           <div class='col-md-6 sens-teeth'>
                              <a style='color:#868787;' rel='nofollow' href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           It really works!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/25043-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Roberto P. - Palermo, Italy                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              After I finished my treatment, I can tell you that IT REALLY WORKS! 
                              My first concern when I started to test the product was: 
                              "It is all a waste of time, definitely it will not change anything." 
                              You know those super fake advertisement on television that make you see how Victoria's Secret only thanks to a pill? 
                              Well, I was afraid that Smile Brilliant was a flop like that and instead I'm happy to tell you that it's all true and it really works!            
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Bought the wrong package             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/alisha-delta-canada-before-and-after-teeth-whitening.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Alisha D. - Delta, British Columbia, Canada                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I had to do a lot of sessions to get my dark tooth to whiten but it worked! I did not notice that the website had a product for people with sensitive teeth. I bought the whitening package but my teeth became really sore. It wasn’t until I spoke with someone on the website chat that I learned about the desensitizing gel. I wish I would have known about it earlier.         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Saw results fast             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/kim-h-rockaway-teeth-whitening-light-results.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Kim H. - Rockaway, NJ                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              The pictures are after 6 sessions. It is surprisingly comfortable in the mouth. I will definitely be ordering more gel.           
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           After 2 treatments               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/louise-boston-2-treatments-whitening-gel.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Louise - Boston, MA (28 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T6 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I did 2, 3 hour treatments and I feel like my coffee stains are already going away. I hope these pictures are clear!          
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Gota love Smile Brilliant                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/marsai-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Marsai - Clarksville, TN                           
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              The custom tray fit perfect. I experienced no sensitivity which was my biggest concern.           
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Really nice customer service             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/megan-teeth-whitening-results-nelsonville-ohio.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Megan - Nelsonville, OH                            
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/teeth-whitening-trays'>Used The T3 Non-Sensitive System</a>                           
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I saw your ad on Facebook and wanted to try something other than the toothpastes. I have not used all the syringes yet but I can definitely see a change.         
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           J'en suis très satisfaite et je compte poursuivre le traitement              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/nathalie-23910-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Nathalie S. - Lescar, France                           
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              J'ai pris les 2 photos avec le même éclairage et sans flash. Pour obtenir ce résultat, je n'ai utilisé qu'une seule seringue de gel de blanchiment, j'ai fait 5 applications tout les deux jours. J'en suis très satisfaite et je compte poursuivre le traitement vu qu'il me reste deux autres seringues.            
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Smile Brilliant is simply AMAZING!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I have extremely sensitive teeth and gums and had zero problems with this system. Furthermore, the customer service and staff is so friendly, eager to help and so easy to contact. HIGHLY, highly recommend anyone that is looking for a whitening system to try Smile Brilliant!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Liliana G.                 
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Smile Brilliant teeth whitening kit is truly an amazing product.             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I had a bad experience with whitening my teeth in the past and I was nervous trying another teeth whitening product, Im glad I did because almost immediately after using this product I noticed a huge difference in the appearance of my teeth. I cannot recommend this teeth whitening product enough. Customer service were so friendly, informative and enthusiastic. Overall my experience was phenomenal.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Bethany D.                 
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I would recommend these for home use for sure!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              As a busy mother of 3, finding time to whiten my teeth gets pushed to almost last! This kit is perfect for busy people on the go who need to fit whitening in last minute! I recommend the desensitizing gel if your teeth are sensitive like mine. It made a huge difference!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Holly H.               
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Smile Brilliant is a awesome product for teeth whitening.                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              It is very easy to use and cost much less than professional teeth whitening. My friend loves coffee and after drinking countless cups of the Go Juice his teeth took a slight yellowish hue. After using Smile Brilliant I could see the difference. Although it had whitened his teeth, it had made his teeth more sensitive than usual.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Celeste W.                 
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Received 2 upper trays               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Smile Brilliant required us to send impressions of our teeth to them and they only sent me back my upper teeth. I now have to wait for them to send me more impression material and start the whole process over again which will take an extra 2 weeks. I bought it back in November to have it ready by an event I have in December. Now, I will not be able to use this product I paid for until after my event.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 customer               
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Did not cover all my teeth               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Package came on time, with an extra set of catalyst and base paste in case you make a mistake in the teeth impression. I did need to use the extra set for my upper teeth impression because the first set of my impression was not long enough to cover all of my teeth, and the extra set did work out.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 anonymous              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I loved my experience with your company.             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/65956-schma-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Nataly S. - Dallas, TX (29 Years Old)                          
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T6 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              It was an easy painless process and I loved being able to whiten my teeth without hurting them due to sensitivity!            
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I love coffee and wine. Toothpaste isn't enough sometimes.               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/66741-lindsey-s-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Lindsey - Las Vegas, NV (28 Years Old)                         
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T3 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I love coffee and wine, so I try to take care of my teeth as best as I can, but even using whitening toothpaste isn't enough sometimes. I've used teeth whitening kits in the past, but they always left my teeth feeling extremely sensitive. When using Smile Brilliant, I didn't experience any sensitivity and saw a noticeable difference in how bright my teeth looked. It brought my teeth back to their natural white state and I couldn't be happier with the results!           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Have only done 2 sessions so far             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/68446-jessica-light-stain-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Jessica H. - Murfreesboro, TN (21 Years Old)                           
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I love how quickly the product has worked for me thus far. Only used it twice and saw a difference.           
                           </div>
                        </div>
                     </div>
                     <hr/>
                     <div style='clear:both;'>
                        <div class='row' style='margin-top:-20px;'>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-sensitive-teeth-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Sensitive Teeth
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-coffee-drinker-grey.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#565759;text-align:center;margin-top:4px;'>
                                 Coffee/Tea Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-wine-drinker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Wine Drinker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-staining-foods-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Staining Foods
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:40px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-smoker-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Smoker
                              </div>
                           </div>
                           <div class='col-xs-4 col-md-2' style='margin-top:10px;min-height:80px;'>
                              <div style='text-align:center;'>
                                 <img class='img-responsive' style='max-width:35px;' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-thumbs/icon-soda-grey-light.png'/>
                              </div>
                              <div style='font-size:0.7em;color:#b5b5b5;text-align:center;margin-top:4px;'>
                                 Soda  Drinker
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-image-with-text'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-md-5'>
                              <img class='img-responsive' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/review-peoples/34461-christianc-teeth-whitening-review.jpg'/>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Christian C. - Addison, TX                             
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                                 <a style='color:#868787;' rel='nofollow'  href='/product/sensitive-teeth-whitening-trays'>Used The T9 Sensitive System</a>                         
                              </div>
                           </div>
                           <div class='col-md-7 actual-review-text'>
                              I’ve been using  this kit off and on for about two months and its been working exceptional for me. The trays are SO comfortable and molded by the smile brilliant lab to create a perfect fit. I first started with seven sessions of about 1-2 hours (you can do as minimal as 15 minutes) within about a 3 week time. I’m so impressed with my results and how quickly I achieved them...           
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           A little pricey but the product goes along way and works really well.                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           started using the product on Saturday and I am seeing excellent results!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I placed my order Thursday morning and the starter kit arrived Friday afternoon! I sent the trays back in for processing on Monday and the finished trays were back to my by Friday! I started using the product on Saturday and I am seeing excellent results! If you're thinking about teeth whitening, I would highly recommend this company and product!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           arrived quickly, and, actually works!!               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I would do business with them a thousand more time if I could.               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I ordered SmileBrillant for a teeth whitening kit and it arrived in two days. Not only that, but I ran out of material to make a impression, so I got ahold of customer service to ask them to send me more. It took them about two days to respond, but they were extremely helpful and very nice. I would do business with them a thousand more time if I could.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Have purchased from them before              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Very pleased with purchase.....could not have been better. Excellent company.....have purchased from them before. Thank you.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I was so impressed by their customer service!                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I ordered one package but to my surprise, three arrived. But when I called and talked with Danyell at Customer Assistance Dept, she was so helpful and friendly. They even sent me a return package so I didn't have to pay for return. They also let me get an extra set of tray material because I messed up the first time. Overall, I had an incredibly pleasant experience shopping at Smile Brilliant. Now, I'm waiting for my trays to arrive so I can start whitening my teeth! Thanks.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           The pudy process was easy to make and send back.             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              My package came on time. The pudy process was easy to make and send back. I received the confirmation email just 3 days after sending the pudy back to the lab.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I am very pleased with the service I received                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              The mail service lost my package despite recording it as "delivered". When I contacted SmileBrilliant customer service they sent me my package ASAP and I received it in two days with no extra charge. I am very pleased with the service I received.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:0%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Postage was short                
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I had to drive 7 miles to the post office and pay an additional $2.06 postage to get my package because they shorted the postage due for that size/weight package. Otherwise, it's too early to say if the product does what they say it does.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Google Review              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I saw a change in my teeth the very first night!             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              I was so extremely pleased with how fast all of the shipping was. Once I started whitening I saw a change in my teeth the very first night! The trays are the best trays I have ever used for whitening because they are fitted to my teeth and don't slide around and I don't have to bite down to keep them in place. 10/10 love this company!!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Nicole R.              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           Love the simplicity of the process               
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Love the simplicity of the process. Accuracy of molds was on par with professional grade from dentist. And the results are amazing!
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Michelle R.                
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           I've tried so many whitening products in the past that did not work.             
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              This is a great product that worked so well for me! I've tried so many whitening products in the past that did not work. Smile Brilliant gave me such good results in a short period of time. The whole process was so simple and I recommend Smile Brilliant to anyone who is looking to whiten their teeth with a safe product that works.
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Krystal S.                 
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='masonry-grid-reviews-col bootstrap-grid review-text-only'>
                     <div class='row'>
                        <div class='col-md-6' style='text-align:left;'>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                           <div class="star-container">
                              <span class="star star-under fa fa-star"></span>
                              <span class="star star-over fa fa-star" style='width:100%;'></span>
                           </div>
                        </div>
                        <div class='col-md-6 review-date-text'>
                        </div>
                     </div>
                     <div class='row sep-bottom-xs'>
                        <div class='col-md-12 title-heading'>
                           My daily staple on oral hygiene              
                        </div>
                     </div>
                     <div style='clear:both;'>
                        <div class='row'>
                           <div class='col-sm-12 actual-review-text'>
                              Smile brilliant is my life and now aded to my daily staple on oral hygiene. This is the best system to use quick and easy. So if you want r need brighter and whiter teeth this company is where you need to get the product from. Thank you Smile Brilliant or giving me the confidence to smile again
                              <div style='color:#4597cb;padding-top:10px;font-weight:normal;font-size:0.8em;'>
                                 Sherry C.              
                              </div>
                              <div style='color:#868787;padding-top:0px;font-weight:normal;font-size:0.9em;'>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class='sep-bottom-lg'>
   </div>
</section>






<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>


<?php

get_footer();
?>




    <script type='text/javascript'>
        var n__layoutRefreshTimer = null;

        function n__refreshMasonryLayout()
        {
            clearTimeout(n__layoutRefreshTimer);
            try
            {
                n__layoutRefreshTimer = setTimeout(function()
                {
                    n__masonryReviews.masonry('layout');
                },  500);
            }
            catch(err){}
        }
    </script>

<script type='text/javascript'>

    //conducts the search based on the filters
    function n__searchReviews()
    {
        window.location.href = "/reviews/"+n__urlEncodeString(n__eById('reviewSearchScore').value)+"/"+n__urlEncodeString(n__eById('reviewSearchType').value)+"/0";
    }

    var n__masonryReviews = null;

    //enter key on newsletter
    jQuery( document ).ready(function()
    {
        n__masonryReviews = jQuery('.masonry-grid-reviews').masonry({
              itemSelector: '.masonry-grid-reviews-col',
              columnWidth: '.masonry-grid-reviews-sizer',
              gutter: '.masonry-grid-reviews-gutter-sizer',
              percentPosition: true
          });
    });

</script>





