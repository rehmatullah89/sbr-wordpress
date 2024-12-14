<?php

/*

Template Name: water flosser template

*/

get_header();

?>


        <link rel="stylesheet" href="https://www.smilebrilliant.com/static/style/bootstrap.min.css?ver=04-28-2021">
        <link rel="stylesheet" href="/static/style/main.css?ver=04-28-2021">
        <link rel="stylesheet" href="/static/style/style.css?ver=04-28-2021">









<div class="smilebrilliant-page-content sep-bottom-lg">
    <section id="product-image-section" class="text-center sep-top-4x sep-bottom-lg">
        <div style="overflow:hidden;">
            <div class="container" id="product-caripro-flosser">
                <h1 class="product-header-primary" id="fresh-take-text">cariPRO™ CORDLESS WATER FLOSSER</h1>
                <h2 class="product-header-sub"><span itemprop="name">The healthier way to floss. Delivered to your door.</span></h2>
                <img data-wow-delay=".5s" class="wow fadeIn img-responsive animated animated" src="https://www.smilebrilliant.com/static/images/graphic-caripro-flosser.png?ver=04-28-2021" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;"><br>
                <button onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-selection-type-section&quot;).offset().top + 220},1500);return false;" class="btn btn-primary-blue btn-lg" style="margin-top:30px;margin-bottom:20px;">SEE PRICING</button>
                <br>
                <a href="#" onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#whats-included-section&quot;).offset().top + 220},1500);return false;">Learn More</a>
            </div>
        </div>
    </section>

    <section id="solid-color-with-text-section">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row sep-top-md sep-bottom-md">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
                    <div id="solid-color-with-text-section-maintext">
                        <span style="font-weight:bold;">“Stop messing with string. This is fun flossing.”</span>
                    </div>
                    <!--<div id='solid-color-with-text-section-deliveredtext'>
                        - DELIVERED -
                    </div>-->
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 sep-top-md">
                        <a data-wow-delay=".5s" class="wow fadeIn col-sm-3 col-xs-6 text-center results-logos-wrap animated animated" id="results-logos-wrap-1" href="/geha" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                            <img style="text-decoration:none;border:none;" src="https://www.smilebrilliant.com/static/images/geha-logo-gray-light.png?ver=04-28-2021">
                        </a>

                        <div data-wow-delay=".7s" class="wow fadeIn col-sm-3 col-xs-6 text-center results-logos-wrap animated animated" id="results-logos-wrap-3" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeIn;">
                            <img src="https://www.smilebrilliant.com/static/images/fda-registered-light-gray-logo.png?ver=04-28-2021">
                        </div>                      
                        <div data-wow-delay=".6s" class="wow fadeIn col-sm-3 col-xs-6 text-center results-logos-wrap animated animated" id="results-logos-wrap-2" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeIn;">
                            <img src="https://www.smilebrilliant.com/static/images/forbes-logo-gray-light.png?ver=04-28-2021">
                        </div>

                        <div data-wow-delay=".8s" class="wow fadeIn col-sm-3 col-xs-6 text-center results-logos-wrap animated animated" id="results-logos-wrap-4" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeIn;">
                            <img src="https://www.smilebrilliant.com/static/images/fox-logo-gray-light.png?ver=04-28-2021">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <section id="product-selection-type-section" class="sep-top-lg sep-bottom-lg">
        <div style="overflow:hidden;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2 text-center">
                        <div class="section-header-blue">COMPLETE cariPRO™ WATER FLOSSER PACKAGE</div>
                        <div class="section-header-content-grey-large" style="margin-top:30px;">
                            The healthiest and most convenient way to floss is delivered directly to your door. Save up to 50% on comparable high quality water flossers.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        var n__toggleSensitivityTimer = null;
        var n__toggleSensitivityInitiated = false;
        function n__toggleProducts(n__initialLoad, n__selectedValue)
        {
            //dont do anything while switching
            if(n__toggleSensitivityInitiated == true)
            {  return;  }

            if(n__selectedValue == "standard")
            {
                if(n__initialLoad == false)
                {
                    n__toggleSensitivityInitiated = true;
                    $("#product-selection-subscription").fadeOut(400, function() {
                      $("#product-selection-standard").fadeIn(400, function() {
                        // Animation complete.
                            n__toggleSensitivityInitiated = false;
                      });
                    });
                }
                n__eById('product-selection-type-button-standard').disabled = true;
                n__eById('product-selection-type-button-subscription').disabled = false;

                n__setClass(n__eById('product-selection-type-button-standard'), "btn btn-lg btn-standard-active");
                n__setClass(n__eById('product-selection-type-button-subscription'), "btn btn-lg btn-subscription-inactive");
            }
            else if(n__selectedValue == "subscription")
            {
                if(n__initialLoad == false)
                {
                    n__toggleSensitivityInitiated = true;
                    $("#product-selection-standard").fadeOut(400, function() {
                         $("#product-selection-subscription").fadeIn(400, function() {
                          // Animation complete.
                          n__toggleSensitivityInitiated = false;
                        });
                    });
                }
                n__eById('product-selection-type-button-standard').disabled = false;
                n__eById('product-selection-type-button-subscription').disabled = true;

                n__setClass(n__eById('product-selection-type-button-standard'), "btn btn-lg btn-standard-inactive");
                n__setClass(n__eById('product-selection-type-button-subscription'), "btn btn-lg btn-subscription-active");

            }
        }

        n__toggleProducts(true, "standard");
    </script>
        <section class="caripro-fossible-product">
                <div class="row sep-top-sm" id="product-selection-standard">
                    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                        <div class="col-mbt">
                            <div data-wow-delay=".6s" class="wow fadeInDown product-selection-box animated animated" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInDown;">
                                <div class="product-selection-title">DELUXE PACKAGE</div>
                                <div class="product-selection-image-wrap">
                                    <img src="https://www.smilebrilliant.com/static/images/caripro-flosser-product-pack.png?ver=04-28-2021" class="img-responsive">
                                </div>
                                <div class="product-selection-description">
                                    <b>x1</b>cariPRO™ Cordless Water Flosser<br>
                                    <b>x4</b> premium specialty floss tips<br>
                                    <b>x1</b> universal USB &amp; wall adaptor charging<br>
                                    <br>
                                    <div>
                                        <span style="color:#3c98cc; font-weight: bold;">2 year limited warranty</span><br>
                                        60 day trial
                                    </div>
                                </div>
                                <div class="product-selection-price-wrap">
                                    <div><i class="fa fa-dollar product-selection-price-dollar-symbol"></i><span class="product-selection-price-text">98</span><span class="product-selection-price-currency" style="">&nbsp;USD</span></div>
                                    <div class="product-selection-dentist-price-note">Compared to $139</div>
                                    <button onclick="n__handleProductAddToCart(39, '');return false;" class="btn btn-primary-blue">ADD TO CART</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>



    <style type="text/css">
    #learn-more-shipping-button
    {
        border-color: #ffffff;
        color: #ffffff;
    }
        #learn-more-shipping-button:hover
        {
            color: #68c8c7;
            background-color: #ffffff;
            border-color: #ffffff;
        }

    #we-ship-worldwide-text
    {
        color:white;
        font-family:Montserrat;
        font-weight:bold;
        font-size: 2.5em;
    }

    @media(max-width:500px)
    {
        #we-ship-worldwide-text
        {
            font-size: 1.3em;
        }
    }

    @media(min-width:501px) and (max-width:767px)
    {
        #we-ship-worldwide-text
        {
            font-size: 1.8em;
        }
    }

    @media(min-width:768px)
    {
        #we-ship-worldwide-text
        {
            font-size: 2.5em;
        }
    }
    @media (min-width: 992px)
    {

    }
    @media (min-width: 1200px)
    {

    }
    @media (min-width: 1500px)
    {

    }

</style>

<section id="shipping-section" class="sep-top-md sep-bottom-md" style="background-color:#68c8c7;border-top:solid #eef5f5 1px;border-bottom:solid #eef5f5 1px;">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2 text-center">
                    <div id="we-ship-worldwide-text" data-wow-delay=".5s" class="wow pulse animated" style="visibility: visible; animation-delay: 0.5s; animation-name: pulse;">
                        <i class="fa fa-globe"></i>&nbsp;&nbsp;YES, WE SHIP WORLDWIDE&nbsp;&nbsp;<i class="fa fa-globe"></i>
                    </div>
                    <div class="sep-top-xs">
                        <a rel="nofollow" class="btn btn-primary-transparent-orange btn-sm" id="learn-more-shipping-button" onclick="$('#shipping-section-modal').modal('show'); return false;" href="#">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Modal -->
<div id="shipping-section-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content" style="max-width:600px;margin: 0 auto;box-shadow:none;border:none;border-radius:0;">
      <div class="modal-body text-center" style="border: 6px solid #3d97cc;font-size:0.9em">
        <h5 style="line-height:1.5em;">Do you ship the electric toothbrushes internationally?</h5>
        <br>
        <p style="font-size:0.9em"></p><p>Smile Brilliant ships all over the world! We have customers in over 90 countries and are very familiar with international shipments, customs, and duties. The cost to ship your cariPRO™ electric toothbrush anywhere in the world is free! <i>(unless an alternative shipping method is requested)</i></p><p></p>
        <br>
        <br>
        <br>
        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">GOT IT!</button>
        <br>
      </div>
    </div>
  </div>
</div>
<!-- / FAQ Modal --><section id="whats-included-section" class="sep-top-md sep-bottom-md" style="background-color:#fdffff;border-top:solid #eef5f5 1px;border-bottom:solid #eef5f5 1px;">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2 text-center">
                    <div class="section-header-blue">WHAT'S IN THE BOX?</div>
                </div>
            </div>

            <div class="row sep-top-lg">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <div class="row">
                        <div data-wow-delay=".6s" class="wow fadeInLeft col-md-6 whats-included-left-column animated" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInLeft;">
                            <table cellspacing="0" cellpadding="0" style="">
                                <tbody><tr>
                                    <td class="whats-included-image-cell">
                                        <img src="https://www.smilebrilliant.com/static/images/graphic-flosser.png" alt="Electric toothbrush sketch">
                                    </td>
                                    <td class="whats-included-text-cell">
                                        <b>1 cariPRO™ Cordless Water Flosser</b><br>
                                        <ul>
                                            
                                            <li>155ml reservoir (45 secs of flossing per fill)</li>
                                            <li>44-75 psi floss jet</li>
                                            <li>3 floss modes (normal, soft, pulse)</li>
                                            <li>28 day battery life (on full charge)*</li>
                                            <li>Ergonomic slim design with graphite gray soft-touch  grip</li>
                                            <li>Waterproof design is is safe for shower or bath</li>
                                            <li>Auto-interval smart timer for even &amp; timed brushing</li>
                                            <li>5 Hour rapid charge (universal USB &amp; wall charging </li>
                                        </ul>

<div class="mobile-hidden">
                                    <div class="whats-included-image-cell">
                                        <img src="https://www.smilebrilliant.com/static/images/2year-full-warranty-grey.png" alt="Electric toothbrush head sketch">
                                    </div>
                                    
                                        <b>Full 2-Year Warranty</b><br>
                                        <ul>
                                            <li>Full warranty against manufacturer</li>
                                            <li>Retail packaging (individually sealed)</li>
                                            <li>Instruction booklet</li>
                                        </ul>
                                    </div>

                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                        <div data-wow-delay=".6s" class="wow fadeInRight col-md-6 whats-included-right-column animated" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInRight;">
                            <table cellspacing="0" cellpadding="0" style="">
                                <tbody>
                                    <tr>
                                    <td class="whats-included-text-cell">
                                    <div class="mob-flex">
                                    <div class="whats-included-image-cell">
                                        <img src="https://www.smilebrilliant.com/static/images/graphic-premium-floss-tips.png" alt="Electric toothbrush head sketch">
                                    </div>
                                    <div class="mobile-adjt">
                                        <b>4 Premium Floss Tips</b><br>
                                        <ul>
                                            <li>Standard tip (general use)</li>
                                            <li>Ortho tip - Ideal for braces</li>
                                            <li>Brush tip - Implants, crowns, and bridges</li>
                                            <li>Pocket tip - periodontal pockets / furcations</li>
                                        </ul>
                                    </div>
                                </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="whats-included-text-cell">
                                    <div class="mob-flex">  
                                        <div class="whats-included-image-cell">
                                        <img src="https://www.smilebrilliant.com/static/images/graphic-usb-adaptor.png" alt="Electric toothbrush head sketch">
                                    </div>
                                    <div class="mobile-adjt">
                                        <b>1 USB adaptor &amp; universal wall charger</b><br>
                                        <ul>
                                            <li>3.7v Li-ion high capacity battery (160 mAh)</li>
                                            <li>100-240v ~ 50/60Hz (US &amp; international use)</li>
                                            <li>420±50mAh Charging current</li>
                                        </ul>
                                    </div>
                                </div>
                                    </td>
                                </tr>

                                <tr class="mobile-show">
                                    <td class="whats-included-text-cell">
                                    <div class="mob-flex">  
                                        <div class="whats-included-image-cell">
<img src="https://www.smilebrilliant.com/static/images/2year-full-warranty-grey.png" alt="Electric toothbrush head sketch">
                                    </div>
                                    <div class="mobile-adjt">
                                        <b>Full 2-Year Warranty</b><br>
<ul>
                                            <li>Full warranty against manufacturer</li>
                                            <li>Retail packaging (individually sealed)</li>
                                            <li>Instruction booklet</li>
                                        </ul>
                                    </div>
                                </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                        </div>
                    </div>
                    <button onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-selection-type-section&quot;).offset().top +200},1500);return false;" class="btn btn-primary-blue btn-lg" style="margin-top:30px;margin-bottom:20px;">ORDER NOW</button>
                    <br>
                
                    <a href="#" onclick="n__toggleTechSpecs(true);$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#technical-specs-section&quot;).offset().top - 50},1500); return false;">See full technical specifications</a>

                </div>
            </div>
        </div>
    </div>
</section><section id="best-brush-section">
    <div id="best-brush-section-overlay">
        <div style="overflow:hidden;">
            <div class="container">
                <div class="row">
                    <div data-wow-delay=".5s" class="wow fadeInRight col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-6 col-lg-5 text-center animated animated" id="best-brush-text-wrap" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInRight;">
                        <div id="best-brush-heading">50% more effective for improving gum health vs. string floss</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="technical-specs-section" style="background: #3c98cc;">
        <div style="overflow:hidden">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1 text-center">


                        <a href="javascript:;" onclick="n__toggleTechSpecs(); return false;" class="section-header-blue" style="display:block;padding-top:40px;padding-left:10px;padding-right:10px;color:#fff;font-size:1.5em;">SEE FULL TECHNICAL SPECIFICATIONS <i id="specs-drop-icon" class="fa fa-angle-right"></i></a>                               
                        
                        <div id="technical-specs-wrap" class="clearfix">
                            <div class="left-column">
                                <h5 style="color:#fff;margin-top:20px">Power &amp; Charging</h5>
                                <table cellspacing="0" cellpadding="0" style="">
                                    <tbody><tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>CHARGING:</li>
                                                <li>CHARGING ADAPTOR:</li>
                                                <li>BATTERY TYPE:</li>
                                                <li>VOLTAGE:</li>
                                                <li>BATTERY LIFE:</li>
                                            </ul>
                                        </td>
                                        <td>
                                            5 hour rapid charge<br>
                                            Universal USB &amp; wall adaptor<br>
                                            1600 mAh rechargeble Litium ION<br>
                                            100-240V (US &amp; International use)<br>
                                            Up to 4 weeks on full charge*
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                </tbody></table>
                                
                                <h5 style="color:#fff;margin-top:20px">Finish &amp; Ease of Use</h5>
                                <table cellspacing="0" cellpadding="0" style="">
                                    <tbody><tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>COLOR:</li>
                                                <li>HANDLE:</li>
                                                <li>DESIGN:</li>
                                                <li>HEAD REPLACEMENT:</li>
                                                <li>BATTERY INDICATOR:</li>
                                                <li>DISPLAY:</li>
                                            </ul>
                                        </td>
                                        <td>
                                            Graphite matte gray<br>
                                            Soft-touch silicone rubber grip<br>
                                            Ergonomic slim design<br>
                                            Quick-click brush head replacement<br>
                                            Illuminated icon indicates charge<br>
                                            Operating mode indicator lights
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                </tbody></table>
                                
                                <h5 style="color:#fff;margin-top:20px">Warranty &amp; Durability</h5>
                                <table cellspacing="0" cellpadding="0" style="">
                                    <tbody><tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>WARRANTY:</li>
                                                <li>WATERPROOF:</li>
                                            </ul>
                                        </td>
                                        <td>
                                            2 year limited warranty<br>
                                            PVx7 Rated (3ft water for 30 mins)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                </tbody></table>
                            </div>
                            
                            <div class="right-column">
                                <h5 style="color:#fff;margin-top:20px">4 Flosser Tips</h5>
                                <table cellspacing="0" cellpadding="0" style="">
                                    <tbody><tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>STANDARD JET:</li>
                                                <li>BRUSH TIP:   </li>
                                                <li>ORTHO TIP:</li>
                                                <li>PERIO POCKET:</li>
                                            </ul>
                                        </td>
                                        <td>
                                            Optimal cleaning results<br>
                                            Implants, crowns &amp; bridges<br>
                                            Ideal for braces<br>
                                            For periodontal pockets<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                </tbody></table>
                                
                                <h5 style="color:#fff;margin-top:20px">Performance</h5>
                                <table cellspacing="0" cellpadding="0" style="">
                                    <tbody><tr>
                                        <td colspan="2"><hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>PRESSURE RANGE:</li>
                                                <li>RESERVOIR:</li>
                                                <li>AUTO-TIMER:</li>
                                                <li>FLOW RATE:</li>
                                                <li>3 CLEANING MODES:</li>
                                                <li>ROTATING TIP:</li>                                              

                                            </ul>
                                        </td>
                                        <td>
                                            44-75 psi (3.103 to 5.171 Bar)<br>
                                            155 ml (5.5 oz)<br>
                                            2 minute auto shut-off<br>
                                            10 oz / minute<br>
                                            Normal / Soft / Pulse<br>
                                            360 Degrees
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr class="mt-60"></td>
                                    </tr>
                                </tbody></table>
                                
                                <br>
                                <br>
                                <a href="static/pdf/Flosser-Brochure_Letter-Size_2021.4.28.pdf" target="_blank" style="display:inline-block;color:#fff;margin-left:10px;margin-bottom:35px;"><img src="/static/images/icon-pdf-white.png"> &nbsp; Download PDF instruction manual</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Technical Specs -->
    <script type="text/javascript">
        function n__toggleTechSpecs(forceDisplay) {
            if ($('#technical-specs-wrap').hasClass('visible') && forceDisplay !== true) {
                $('#specs-drop-icon').removeClass('fa-angle-down').addClass('fa-angle-right');
                $('#technical-specs-wrap').removeClass('visible');
            } else {
                $('#specs-drop-icon').removeClass('fa-angle-right').addClass('fa-angle-down');
                $('#technical-specs-wrap').addClass('visible');
            }
        }
    </script><section id="home-page-process-section">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row sep-top-lg sep-bottom-lg">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="section-header-blue">3 REASONS TO TRY A cariPRO™ WATER FLOSSER</div>
                    </div>
                </div>
                <div class="row" style="margin-top:45px;">
                    <div data-wow-delay=".7s" class="wow bounceInLeft col-sm-4 text-center animated animated" style="visibility: visible; animation-delay: 0.7s; animation-name: bounceInLeft;">
                        <div class="the-reasons-image-wrap" id="the-reasons-image-1">
                            <img src="https://www.smilebrilliant.com/static/images/icon-stop-messing-with-string.png">
                        </div>
                        <div class="the-reasons-circle the-reasons-circle-1">1</div>
                        <div class="the-reasons-title the-reasons-title-1">Stop messing with <span style="font-weight:bold;color:#3c98cc;">string</span></div>
                        <div class="the-reasons-content the-reasons-content-1">
                            <div class="the-reasons-content-text">
                                Face it, flossing is annoying! Stop wasting time with silly string and make flossing a routine you look forward to.
                            </div>
                            <table cellspacing="0" cellpadding="0" style="margin-top:20px;width:100%;border-top: solid #c5c6c9 1px;">
                                <tbody class="fnt-adjust"><tr>
                                    <td style="vertical-align:top;border-right: solid #c5c6c9 1px;padding-right:20px;padding-left:20px;">
                                        <div style="color:#565759;font-family:Montserrat;">50%</div>
                                        <div style="margin-top:0px;font-size:0.9em;">better floss</div>
                                    </td>
                                    <td style="vertical-align:center;color:#979a9e;padding-top:10px;text-align:left;padding-left:20px;padding-right:20px;">
                                        50% MORE EFFECTIVE FOR IMPROVING GUM HEALTH VS. STRING FLOSS
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <div data-wow-delay=".9s" class="wow bounceInLeft col-sm-4 text-center animated animated" style="visibility: visible; animation-delay: 0.9s; animation-name: bounceInLeft;">
                        <div class="the-reasons-image-wrap" id="the-reasons-image-2">
                            <img src="https://www.smilebrilliant.com/static/images/graphic-smile.png">
                        </div>
                        <div class="the-reasons-circle the-reasons-circle-2">2</div>
                        <div class="the-reasons-title the-reasons-title-2">Your mouth will be <span style="font-weight:bold;color:#3c98cc;">healthier</span></div>
                        <div class="the-reasons-content the-reasons-content-2">
                            <div class="the-reasons-content-text">
                                2x more effective around implants. 3x more effective around braces (vs. string floss). Yep, your mouth is about to get a lot healthier.
                            </div>
                            <table cellspacing="0" cellpadding="0" style="margin-top:20px;width:100%;border-top: solid #c5c6c9 1px;">
                                <tbody class="fnt-adjust"><tr>
                                    <td style="vertical-align:top;border-right: solid #c5c6c9 1px;padding-right:20px;padding-left:20px;">
                                        <div style="color:#565759;font-family:Montserrat;">99.9%</div>
                                        <div style="margin-top:0px;font-size:0.9em;">less plaque</div>
                                    </td>
                                    <td style="vertical-align:center;color:#979a9e;padding-top:10px;text-align:left;padding-left:20px;padding-right:20px;">
                                        REMOVES 99.9% OF PLAQUE FROM TREATED AREAS
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <div data-wow-delay="1.1s" class="wow bounceInLeft col-sm-4 text-center animated animated" style="visibility: visible; animation-delay: 1.1s; animation-name: bounceInLeft;">
                        <div class="the-reasons-image-wrap" id="the-reasons-image-3">
                            <img src="https://www.smilebrilliant.com/static/images/guaranteed-results-text-light.png">
                        </div>
                        <div class="the-reasons-circle the-reasons-circle-3">3</div>
                        <div class="the-reasons-title the-reasons-title-3">Zero risk &amp; high <span style="font-weight:bold;color:#3c98cc;">reward</span></div>
                        <div class="the-reasons-content the-reasons-content-3">
                            <div class="the-reasons-content-text">
                                Experience the health benefits and cost savings of a premium water flosser risk free. Delivered to your door!
                            </div>
                            <table cellspacing="0" cellpadding="0" style="margin-top:20px;width:100%;border-top: solid #c5c6c9 1px;">
                                <tbody class="fnt-adjust"><tr>
                                    <td style="vertical-align:top;border-right: solid #c5c6c9 1px;padding-right:10px;padding-left:10px;">
                                        <div style="color:#565759;font-family:Montserrat;">60</div>
                                        <div style="margin-top:0px;font-size:0.9em;">day trial</div>
                                    </td>
                                    <td style="vertical-align:center;color:#979a9e;padding-top:10px;text-align:left;padding-left:10px;padding-right:10px;">
                                        SAVE TIME AND MONEY. REDUCE COSTLY DENTAL BILLS. EXPERIENCE THE CARIPRO DIFFERENCE
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                </div>
                <div class="row sep-top-lg">
                    <div class="col-sm-12 text-center">
                        <button onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-selection-type-section&quot;).offset().top + 200},1500);return false;" class="btn btn-primary-blue btn-lg">ORDER NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
    #warranty-section {
        background-color: #3c98cc;
        color: #fff;
    }
    
    @media(min-width:1px)
    {


    }

    @media(min-width:768px)
    {

    }
    @media (min-width: 992px)
    {

    }
    @media (min-width: 1200px)
    {

    }
    @media (min-width: 1500px)
    {


    }

</style>

<section id="warranty-section">
    <div style="overflow:hidden;">
        <div class="container">
            <div class="row sep-top-lg sep-bottom-lg">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div>
                            <img style="max-width: 130px;margin-left:10px;margin-right:10px;margin-top:15px;" src="/static/images/2year-full-warranty-white.png">
                        </div>
                        <div class="section-header-blue" style="padding-top:35px;padding-left:10px;padding-right:10px;font-weight:bold;color:#fff;">60 DAY TRIAL, 2 YEAR WARRANTY</div>
                        <div class="section-header-content-blue col-md-6 col-md-offset-3" style="padding-top:35px;font-weight:lighter;font-size:1.2em;color:#fff">
                            Smile Brilliant is committed to providing professional quality oral care products at a price everyone can afford. Your cariPRO™ is backed by a 2 year limited manufacturer's warranty and will meet or exceed the features of any top quality cordless water flosser.<br><br>

                            <b style="font-size:1.4em;">If you are anything but 100% satisfied with your cariPRO™ purchase, we'll take it back.</b>
                        </div>
                    </div>
                </div>
                <div class="row sep-top-md">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary-teal btn-lg" onclick="$(&quot;html,body&quot;).animate({scrollTop:  $(&quot;#product-selection-type-section&quot;).offset().top - 50},1500);return false;">BUY NOW</button><br>
                        <a href="#" onclick="$('#warranty-section-modal').modal('show'); return false;" style="display:inline-block;color:#fff;margin-top:15px;">See full warranty</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ Modal -->
<div id="warranty-section-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content" style="max-width:600px;margin: 0 auto;box-shadow:none;border:none;border-radius:0;">
      <div class="modal-body text-center" style="border: 6px solid #3d97cc;font-size:0.9em">
        <h5 style="line-height:1.5em;">What is the cariPRO™ Water Flosser 2 year limited warranty?</h5>
        <br>
        <p style="font-size:0.9em"></p><p>Smile Brilliant warrants the cariPRO™ cordless water flosser for a period of twenty-four (24) months from date of purchase. Defects due to faulty workmanship or materials will be repaired or replaced at the expense of Smile Brilliant so long as proof of purchase or warranty registration can be substantiated at time of claim*. Use of replacement parts other than authentic cariPRO™ parts will void the warranty. Users should adhere to all instructions included in the user manual and should refrain from actions or uses that are deemed unnecessary or which are warned against in the user manual. Smile Brilliant cannot be held responsible for powering failures due to improper voltage supply to the appliance. <i>Warranty does not cover replacement floss tips.</i></p>

<p>You may make a warranty claim by clicking <a href="/contact">HERE</a>.</p><br>

<p><strong>HOW TO REGISTER FOR YOUR WARRANTY</strong></p> <br>

<p><i>I purchased from the Smile Brilliant Website</i></p>
<p>Great! Your warranty is automatically registered and store in our system. There is nothing more you need to do!</p><br>

<p><i>I received the water flosser through my dentist or insurance company.</i></p>
<p>Lucky you! When you buy (or receive) a cariPRO from your dentist or insurance provider, you must fill out the <a href="/contact">warranty registration form</a>. If you are unable to do so, you can register your water flosser over the phone by calling <a href="tel:855-944-8361"> 855-944-8361</a>.</p>
<p></p>
        <br>
        <br>
        <br>
        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color:#4696cc;color:#fff;width:90%;border:1px solid #fff;">GOT IT!</button>
        <br>
      </div>
    </div>
  </div>
</div>
<!-- / FAQ Modal -->
</div>








<?php

get_footer();
?>




    




