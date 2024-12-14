<?php
if ( wp_safe_redirect( home_url() ) ) {
    exit;
}
get_header();
?>


<style type='text/css'>
.row{margin-left:-15px;margin-right:-15px; padding: 0px;}    
.sep-bottom-md {padding-bottom: 2.5em;}
.sep-top-md {padding-top: 2.5em;}    
.text-white{color:#fff !important;} 
.row-t{margin-left:-15px;margin-right:-15px; display:flex;}

/* solid-color-with-text-section */
#solid-color-with-text-section {background-color: #440776;margin-top: 5rem;}   
#solid-color-with-text-section h1{color:#3c98cc;font-size: 140px;line-height: 0.8; letter-spacing: 1px;}
#solid-color-with-text-section h3{font-size: 52px;line-height: 1;letter-spacing: 1px; }
#solid-color-with-text-section .exclusive-offer {font-size: 24px;font-weight: 300;    margin-top: 10px;}


/* product-section-top */
.text-blue{ color:#3c98cc;}
.description-header{font-size: 24px;font-weight: 300;    margin-top: 60px;margin-bottom: 60px;}
.col-sm-6 {
    width: 50%;
}
.product-block-white-box{
    width: 100%;
    height: 100%;    
    margin: 0;
}

.product-box {
    background: #ffa488;
    padding: 1px;
    position:relative;
}
#product-section-top .discount-bar {
    position: absolute;
    right: 0;
    top: 0;
    padding: 0px 24px;
    font-size: 24px;
    font-weight: bold;
    font-family: 'Montserrat';
    color: #fff;
}
#product-section-top .orange-bg {
    background: #fba488;
}
#product-section-top .blue-bg {
    background: #68c8c7;
}
.img-block {
    text-align: center;
    background: #fff;
    min-height: 370px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-block-white-box{
    border: solid #fff 0px;    
    padding-bottom: 25px;
}
.product-box-stars{
    margin-top: 20px;
    letter-spacing: 0px;
}
.product-block-white-box:hover{
    transform: scale(1);
    -webkit-transform: scale(1);    
    box-shadow: 0 0px 15px rgb(0 0 0 / 0%);
}
.product-box-content-button-wrap{
    margin-top: 35px;
}
#home-page-product-block-night-guard{background:none;}
#home-page-product-block-night-guard .product-box{background-color: #68c8c7;}
.btn, div#wcContent .btn{letter-spacing: 0em;}


#home-page-product-block-whitening-refill-text {
    color: #ffffff;
    font-size: 40px;
    line-height: 32px;
    font-family: 'Montserrat';
    font-weight: 700;
    height: 80px;
    background-color: #555759;
    margin-top: 25px;
    padding-top: 25px;
    padding-left: 15px;
}
#home-page-product-block-whitening-refill-buttons {
    height: 80px;
    background-color: #555759;
    margin-top: 25px;
    text-align: center;
}
#home-page-product-block-whitening-refill-buttons a {
    font-size: 12px;
    padding-left: 15px;
    padding-right: 15px;
    margin: 20px;
    margin-bottom: 0px;
}
div#home-page-product-block-whitening-refill-text{
    margin-right: -15px;    
}
div#home-page-product-block-whitening-refill-buttons{
    margin-left: -15px;
}
.font-regular{ font-weight:400 !important;}
#oralCareDeals h2{ padding-top:5rem; padding-bottom:0rem;}
.product-selection-title-text-wrap{    margin-top: -47px;margin-left: 60px;}
.product-selection-title-right{width:260px;    margin-right: 0; font-weight:normal;font-style: normal;}
.product-selection-box{ position:relative;    margin-top: 70px;}
.product-selection-title-text-wrap span.product-selection-title-text-name{font-size: 20px; color: #555759;}
.description-product-text{ font-weight:300;line-height: 24px;} 
.description-product-text strong {
    font-size: 22px;
}
.row-mbt-product {
    display: flex;
}
.justify-content-between {
    justify-content: space-between;

}
.add-to-cart button {
    display: block;
    max-width: 80%;
    margin-left: auto;
    margin-right: auto;  
    
    width: 100%;
  
}
.product-selection-description-text{
    padding-right: 40px;
    padding-left: 40px;
}
.product-image {
    padding-left: 45px;
    height: 100%;
    display: flex;
    align-items: center;    
}
.original-price .price-heading {
    margin-bottom: 10px;
}
.original-price .price-heading {
    margin-bottom: 10px;
    font-size: 12px;
}
.gray-text {
    color: #88898c;
}
.sale-price .price-heading {
    margin-bottom: 10px;
}
.price-was {
    font-size: 30px;
    font-weight: 300;
}
.line-thorough{
    position: relative;
}
.line-thorough:before{
    content: '';
    position: absolute;
    width: 110px;
    height: 2px;
    background: #565759;
    top: 10px;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;

}
span.availableItem {
    font-size: 12px;
    color: #f8a18a;
    text-transform: uppercase;
    font-weight: normal;
}


span.doller-sign {
    font-size: 20px;
}
.add-to-cart {
    margin-top: 20px;
}
.price-new {
    font-size: 31px;
}
span.saveOnItem {
    font-size: 16px;
    font-style: italic;
    margin-left: 10px;
}
.maxwidth80{
    max-width:65%;
    margin-left:auto;
    margin-right:auto;    
}
.description-product-text strong {
    font-weight: 600;
}
#product-section-top .row{
    /* margin-left:auto;
    margin-right:auto;     */
}
#stock-save-bundles .product-image{
    padding-left: 0px;
}
.button-blue-drk {
    background: #24a5aa;
    border-color: #24a5aa;
}
.button-pink {
    background: #db87aa;
    border-color: #db87aa;
    margin-top: 15px;
}
.choose-adult-kids {
    font-weight: normal;
}
.container{ margin-left:auto; margin-right: auto;}

@media (min-width: 767px){
    #solid-color-with-text-section h1{color:#3c98cc;font-size: 140px;line-height: 0.8; letter-spacing: 1px;}    
    #solid-color-with-text-section h3{font-size: 52px;line-height: 1;letter-spacing: 1px; }        
}
@media (min-width: 992px){
    #solid-color-with-text-section h1{color:#3c98cc;font-size: 140px;line-height: 0.8; letter-spacing: 1px;}    
    #solid-color-with-text-section h3{font-size: 52px;line-height: 1;letter-spacing: 1px; }        
}
@media (min-width: 1200px){

    #home-page-product-block-whitening-refill-text {
        color: #ffffff;
    font-size: 40px;
    line-height: 32px;
    font-family: 'Montserrat';
    font-weight: 700;
    height: 80px;
    background-color: #555759;
    margin-top: 25px;
    padding-top: 25px;
    padding-left: 15px;
}
#home-page-product-block-whitening-refill-buttons {

    margin-top: 25px;
}

#home-page-product-block-whitening-refill-buttons a {
    font-size: 15px;
    padding-left: 15px;
    padding-right: 13px;
    margin: 9px;
    margin-bottom: 0px; 
    margin-top: 20px;    
}
.product-selection-box{
    max-height: 500px;
}

}

@media (min-width: 1300px){
    .max1250{width:1250px;margin-left: auto;margin-right: auto;}    
    #solid-color-with-text-section h1{color:#3c98cc;font-size: 140px;line-height: 0.8; letter-spacing: 1px;}    
    #solid-color-with-text-section h3{font-size: 52px;line-height: 1;letter-spacing: 1px; }        

    .product-selection-box{
        max-height: 520px;
}

}
@media (min-width: 1500px){
    .max1250{width:1250px;margin-left: auto;margin-right: auto;}
    #solid-color-with-text-section h1{color:#3c98cc;font-size: 140px;line-height: 0.8; letter-spacing: 1px;}    
    #solid-color-with-text-section h3{font-size: 52px;line-height: 1;letter-spacing: 1px; }    


#home-page-product-block-whitening-refill-buttons {
    height: 80px;
    margin-top: 25px;
}
#home-page-product-block-whitening-refill-buttons a {
    font-size: 16px;
    padding-left: 15px;
    padding-right: 15px;
    margin: 15px;
    margin-bottom: 0px;
    font-weight: 300;    
}

.product-selection-box{
    max-height: 520px;
}

}



@media (max-width: 1300px){
    .maxwidth80{
        max-width: 90%;
    }

    .add-to-cart button{
        width: 100%; 
        max-width: 100%;
    }

}
@media (max-width: 1200px){
    .product-selection-box .col-md-1{ display:none;}
    .add-to-cart button{
        font-size: 14px; 
    }
}

@media (max-width: 992px){
    .row-t{flex-wrap: wrap;}
    #home-page-product-block-whitening-refill-text{
        font-size: 26px;
    }
    #home-page-product-block-whitening-refill-text,#home-page-product-block-whitening-refill-buttons{
        height: 120px;
    }
    #home-page-product-block-whitening-refill-text{padding-top: 41px;}
    #home-page-product-block-whitening-refill-buttons a{
        margin: 13px;
    }
    .product-selection-box .col-md-1{ display:none;}
    .product-selection-box .col-sm-6.col-md-7{
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    }
    .col-sm-6.col-md-5.product-selection-description-text-wrap{
        -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    }
    .product-image img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.product-selection-title-text-wrap{
    margin-top: -47px;
    margin-left: 0px;
    background-color: transparent;
    width: 100%;
}
.product-selection-description-text{
    max-width: 80%;
    margin-left: auto;
    margin-right: auto;
}
#oralCareDeals h2 {
    padding-top: 3rem;
    padding-bottom: 0rem;
    font-size: 36px;
}

}
@media (max-width: 767px){
    #solid-color-with-text-section{
        margin-top: 0rem;
    }
    #solid-color-with-text-section h3{
        font-size: 36px;
    }
    #solid-color-with-text-section h1{
        font-size: 100px;
    }
    #solid-color-with-text-section .exclusive-offer{
        font-size: 16px;
    }
    #product-section-top .product-block-box-image{
        width: 100%;
    }
    .product-selection-description-text {
    max-width: 100%;
}
.product-selection-description-text .maxwidth80 {
    max-width: 80%;
}
.add-to-cart button {
    font-size: 16px;
}

section#getRefill .col-sm-6 {
    width: 100%;
}
#home-page-product-block-whitening-refill-buttons{
    margin-top: 0px;
}
#home-page-product-block-whitening-refill-text, #home-page-product-block-whitening-refill-buttons{
    height:auto;
}
#home-page-product-block-whitening-refill-buttons a{
    width: 80%;
}
.product-selection-title-text-wrap span.product-selection-title-text-name{
    font-size: 18px;

}
.product-selection-box{
    margin-left: 10px;
    margin-right: 10px;    
}
.product-selection-description-text .maxwidth80 {
    margin-top: 30px !important;
}
.product-selection-description-text {
    padding-right: 20px;
    padding-left: 20px;
}
section#product-section-top {
    margin-left: 10px;
    margin-right: 10px;
}
.product-box{
    margin-bottom: 15px; 
}
#home-page-product-block-whitening-refill-buttons a{
    margin: 5px;
}
#home-page-product-block-whitening-refill-text{
    padding-top: 20px;
    padding-left: 0px;
}
#home-page-product-block-whitening-refill-buttons{
    padding-bottom: 15px;  
}
.description-header br{ display:none;}
.description-header {
    font-size: 18px;

}


}






</style>


<section class="page-wrapper">



    <section id="solid-color-with-text-section"  style="display:none;">
        <div class="container">
            <div class="row-t sep-top-md sep-bottom-md text-center">
                <div class="col-sm-12">
                    <h3 style="margin:0;" class="text-white font-mont"><?php echo get_field('mbt_sale_title' , 'option');  ?></h3>
                    <h1 style="margin:0;" class="font-mont">SALE<span class="text-white">!</span></h1>
                    <div class="exclusive-offer text-white font-mont">Exclusive <strong>GEHA</strong> member pricing for the holidays</div>
                </div>
            </div>
        </div>            
    </section>

    <div class="salePageBanner">
        <?php
            get_template_part( 'inc/templates/sale/sale-page/valentine-day-sale-page-top-section' );
        ?>
     </div>   


    <section id="product-section-top">
        <div class="container max1250">
            <div class="description-header text-center" style="display:none;">
                We are offering exclusive discounts to GEHA members beyond our normal holiday <br>
                sale pricing. <span class="text-blue">Limited quantities of each item are available so claim your discount<br>
                before it sells out!   </span>             
            </div>

            <div class="row-t">
                <div class="col-sm-6 product-block-box-image" id="home-page-product-block-whitening-image">
                    <div class="product-box" onclick="window.location.href=&quot;/product/teeth-whitening-trays&quot;;">
                        <div class="discount-bar orange-bg">
                            25% OFF
                        </div>
                        <div class="img-block text-center" >
                         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/whitening-tays-black-friday-sale-img.jpg" alt="" >                        
                        </div>
                        <div class="product-block-white-box" onclick="window.location.href=&quot;/product/teeth-whitening-trays&quot;;">
                            <div class="product-box-stars">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            </div>
                            <div class="product-box-small-title">
                                CUSTOM-FITTED
                            </div>
                            <div class="product-box-large-title">
                                WHITENING TRAYS
                            </div>
                            <div class="product-box-content-button-wrap">
                                <a rel="nofollow" href="/product/teeth-whitening-trays" class="btn btn-primary-white-orange">SEE WHITENING DEALS</a>
                            </div>
                        </div>

                    </div>                    
                </div>


                <div class="col-sm-6 product-block-box-image" id="home-page-product-block-night-guard">
                    <div class="product-box" onclick="window.location.href=&quot;/product/night-guards&quot;;">
                    <div class="discount-bar blue-bg">
                            25% OFF
                        </div>
                    
                         <div class="img-block text-center">
                             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/night-guards-black-friday-sale-img.jpg" alt="" >                        
                        </div>
                    <div class="product-block-white-box" onclick="window.location.href=&quot;/product/night-guards&quot;;">
						<div class="product-box-stars">
							<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
						</div>
						<div class="product-box-small-title">
							CUSTOM-FITTED
						</div>
						<div class="product-box-large-title">							
                            NIGHT GUARDS
						</div>
						<div class="product-box-content-button-wrap">
                            <a rel="nofollow" href="/product/night-guards" class="btn btn-primary-white-teal">SEE NIGHT GUARDS DEALS</a>
						</div>
					</div>
                </div>    

        </div>

    </section>
        <section id="getRefill">
        <div class="container max1250">
            <div class="row-t">
            <div class="col-sm-6 no-gutters">
                <div id="home-page-product-block-whitening-refill-text">
                    20% OFF <span class="font-regular">GEL REFILLS</span>
                </div>
				</div>
                <div class="col-sm-6 no-gutters" >
                    <div id="home-page-product-block-whitening-refill-buttons">
                    <div class="buttons-sec-page ">
					<a rel="nofollow" href="/product/teeth-whitening-gel/" class="btn btn-primary-orange">WHITENING GEL REFILLS</a>
					<a rel="nofollow" href="/product/desensitizing-gel/" class="btn btn-primary-purple">DESENSITIZING GEL REFILLS</a>
                </div>
                </div>
				</div>                


            </div>
        </div>

        </section>

        <section id="oralCareDeals" class="our-customers-speak-for-us">            
            <div class="container max1250">
                <h2 class="text-center">ORAL CARE DEALS</h2>


            <div class="row-t product-item-display">
                <div class="col-lg-12">

                         <div class="product-selection-box">
							<div class="row-t">
								<div class="product-selection-title-text-wrap">
									<span class="product-selection-title-text-name">
                                    COMPLETE ORAL CARE BUNDLE                                        
                                      </span> 

								</div>
								<div class="product-selection-title-right">
                                    <span class="availableItem">133 STILL AVAILABLE</span> <span class="saveOnItem">SAVE 52%</span>
								</div>
							</div>
							<div class="row-t">
                                <div class="col-sm-6 col-md-7">
                                    <div class="product-image">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/product-complete-oral-care-bundle.jpg" alt="" >                                             
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
								<div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
									<div class="product-selection-description-text">
										<div class="description-product-text">
                                            <strong>x1</strong> cariPRO™ Electric Toothbrush<br>
                                            <strong>x2</strong> premium replacement heads with tongue scraper & DuPont™ bristles<br>
                                            <strong>x1</strong> cariPRO™ Cordless Water Flosser<br>
                                            <strong>x4</strong> cariPRO™ Specialty Flossing Tips<br>
                                            <strong>x1</strong> Plaque Highlighters (30 day suppy)
                                          </div>
                                        <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">

                                            <div class="original-price">
                                                <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span>229</div>                                                
                                            </div>

                                            <div class="sale-price">
                                                <div class="price-heading blue-text">SALE PRICE</div>
                                                <div class="price-new "><span class="doller-sign">$</span>110</div>                                                
                                            </div>

                                        </div>

                                        <div class="add-to-cart">
										<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=735323" data-quantity="1" data-product_id="735323" data-action="woocommerce_add_order_item">ADD TO CART</button>
                                    </div>

									</div>
                                    
  

								</div>

							</div>
						</div>

                        <div class="product-selection-box">
							<div class="row-t">
								<div class="product-selection-title-text-wrap">
									<span class="product-selection-title-text-name">
                                    DELUXE CORDLESS WATER FLOSSER                                       
                                      </span> 

								</div>
								<div class="product-selection-title-right">
                                    <span class="availableItem">253 STILL AVAILABLE</span> <span class="saveOnItem">SAVE 44%</span>
								</div>
							</div>
							<div class="row-t">
                                <div class="col-sm-6 col-md-7">
                                    <div class="product-image">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/product-deluxe-cordless-water-flosser.jpg" alt="" >                                             
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
								<div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
									<div class="product-selection-description-text">
										<div class="description-product-text">
                                            <strong>x1</strong> cariPRO™ Cordless Water Flosser<br>
                                            <strong>x4</strong> cariPRO™ Specialty Flossing Tips<br>
                                            <strong>x1</strong> universal USB & wall adaptor charging<br>
                                          </div>
                                
                                          <div class="limited-warranty-box text-center" style="margin-top:30px;">
                                                <span class="text-blue limited-warranty-text-mbt">2 year limited warranty</span><br>
                                                <span class="days-trial">60 day trial</span>
                                                
                                            </div>
                                        <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">

                                            <div class="original-price">
                                                <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span>98</div>                                                
                                            </div>

                                            <div class="sale-price">
                                                <div class="price-heading blue-text">SALE PRICE</div>
                                                <div class="price-new "><span class="doller-sign">$</span>55</div>                                                
                                            </div>

                                        </div>
                                        <div class="add-to-cart">
										<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=735325" data-quantity="1" data-product_id="735325" data-action="woocommerce_add_order_item">ADD TO CART</button>
                                    </div>


									</div>
                                    


								</div>

							</div>
						</div>




                        <div class="product-selection-box" id="stock-save-bundles">
							<div class="row-t">
								<div class="product-selection-title-text-wrap">
									<span class="product-selection-title-text-name">
                                    STOCK & SAVE BUNDLES                                       
                                      </span> 

								</div>
								<div class="product-selection-title-right">
                                    <span class="availableItem">155 STILL AVAILABLE</span> <span class="saveOnItem">SAVE 50%</span>
								</div>
							</div>
							<div class="row-t">
                                <div class="col-sm-6 col-md-7">
                                    <div class="product-image">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/product-stock-save-bundles.jpg" alt="" >                                             
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
								<div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
									<div class="product-selection-description-text">
										<div class="description-product-text">
                                            <div class="ninty-day-supply-text">
                                                <strong>90 day supply</strong><br>
                                                Plaque Highlighters™ + Dental Probiotics
                                             </div>
                                            <div class="choose-adult-kids italic text-blue"  style="margin-top:25px;">
                                                choose adult or kids bundles...or both!
                                            </div>
                                          </div>
                                
                                        <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">

                                            <div class="original-price">
                                                <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span>79</div>                                                
                                            </div>

                                            <div class="sale-price">
                                                <div class="price-heading blue-text">SALE PRICE</div>
                                                <div class="price-new "><span class="doller-sign">$</span>40</div>                                                
                                            </div>

                                        </div>

                                        <div class="add-to-cart">
										<button class="btn btn-primary-blue btn-lg button-blue-drk product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=735329" data-quantity="1" data-product_id="735329" data-action="woocommerce_add_order_item">ADD TO CART - adult bundle</button>
										<button class="btn btn-primary-blue btn-lg button-pink product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=735328" data-quantity="1" data-product_id="735328" data-action="woocommerce_add_order_item">ADD TO CART - kids bundle</button>                                   
                                    </div>
									</div>
                                    
     

								</div>

							</div>
						</div>


                        



                        <div class="product-selection-box">
							<div class="row-t">
								<div class="product-selection-title-text-wrap">
									<span class="product-selection-title-text-name">
                                          ELECTRIC TOOTHBRUSH PACKAGE                                  
                                      </span> 

								</div>
								<div class="product-selection-title-right">
                                    <span class="availableItem">167 STILL AVAILABLE</span> <span class="saveOnItem">SAVE 75%</span>
								</div>
							</div>
							<div class="row-t">
                                <div class="col-sm-6 col-md-7">
                                    <div class="product-image">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/black-friday-sale/product-electric-toothbrush-package.jpg" alt="">                                             
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
								<div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
									<div class="product-selection-description-text">
										<div class="description-product-text">
                                            <strong>x1</strong> cariPRO™ Electric Toothbrush<br>
                                            <strong>x4</strong> premium replacement heads with tongue scraper & DuPont™ bristles<br>
                                            <strong>x1</strong> wireless charging dock<br>
                                          </div>
                                
                                          <div class="limited-warranty-box text-center" style="margin-top:30px;">
                                                <span class="text-blue limited-warranty-text-mbt">2 year limited warranty</span><br>
                                                <span class="days-trial">60 day trial</span>
                                                
                                            </div>
                                        <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">

                                            <div class="original-price">
                                                <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span>119</div>                                                
                                            </div>

                                            <div class="sale-price">
                                                <div class="price-heading blue-text">SALE PRICE</div>
                                                <div class="price-new "><span class="doller-sign">$</span>29.95</div>                                                
                                            </div>

                                        </div>

                                        <div class="add-to-cart">
										<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=130266" data-quantity="1" data-product_id="130266" data-action="woocommerce_add_order_item">ADD TO CART</button>
                                    </div>

									</div>
                                    


								</div>

							</div>
						</div>

                 </div>



             </div>


            </div>

        </section>




</section>



<?php
get_footer();
?>