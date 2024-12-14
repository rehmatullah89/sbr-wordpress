<?
setcookie('subscriber_exclusive_deals_user','yes', time() + 3600,COOKIEPATH, COOKIE_DOMAIN);
/*
Template Name:  Subscribers exclusive deals
*/
get_header();
?>


<style type='text/css'>
    /* .row{margin-left:-15px;margin-right:-15px; padding: 0px;}     */
    .sep-bottom-md {
        padding-bottom: 2.5em;
    }

    .sep-top-md {
        padding-top: 2.5em;
    }

    .text-white {
        color: #fff !important;
    }

    .row-t {
        margin-left: -15px;
        margin-right: -15px;
        display: flex;
    }


    /* solid-color-with-text-section */
    #solid-color-with-text-section {
        background: #4597cb;
    }

    #solid-color-with-text-section .banner-heading {
    max-width: 300px;
    text-align: center;
    padding: 60px 0px;
    margin: 0px auto;
}
#solid-color-with-text-section .banner-heading .title h2 {
    margin-bottom: 0px;
    font-size: 32px;
    font-weight: 700;
    color: #fff;
}
#solid-color-with-text-section .banner-heading .title p{
    font-weight: 200;
    font-size: 30px;
    margin-bottom: 0em;
    color: #fff;
}
    section#solid-color-with-text-section img {
        width: 100%;
        margin-left: -30px;
    }
    #solid-color-with-text-section h1 {
        color: #3c98cc;
        font-size: 140px;
        line-height: 0.8;
        letter-spacing: 1px;
    }

    #solid-color-with-text-section h3 {
        font-size: 52px;
        line-height: 1;
        letter-spacing: 1px;
    }

    #solid-color-with-text-section .exclusive-offer {
        font-size: 24px;
        font-weight: 300;
        margin-top: 10px;
    }


    /* product-section-top */
    .text-blue {
        color: #3c98cc;
    }

    .description-header {
        font-size: 24px;
        font-weight: 300;
        margin-top: 60px;
        margin-bottom: 60px;
    }

    .col-sm-6 {
        width: 50%;
    }

    .product-block-white-box {
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .product-box {
        background: #ffa488;
        padding: 1px;
        position: relative;
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

    .img-block img {
        max-width: 100%;
    }

    .product-block-white-box {
        border: solid #fff 0px;
        padding-bottom: 25px;
    }

    .product-box-stars {
        margin-top: 20px;
        letter-spacing: 0px;
    }

    .product-block-white-box:hover {
        transform: scale(1);
        -webkit-transform: scale(1);
        box-shadow: 0 0px 15px rgb(0 0 0 / 0%);
    }

    .product-box-content-button-wrap {
        margin-top: 35px;
    }

    #home-page-product-block-night-guard {
        background: none;
    }

    #home-page-product-block-night-guard .product-box {
        background-color: #68c8c7;
    }

    .btn,
    div#wcContent .btn {
        letter-spacing: 0em;
    }


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

    div#home-page-product-block-whitening-refill-text {
        margin-right: -15px;
    }

    div#home-page-product-block-whitening-refill-buttons {
        margin-left: -15px;
    }

    .font-regular {
        font-weight: 400 !important;
    }

    #oralCareDeals h2 {
        padding-top: 5rem;
        padding-bottom: 0rem;
    }

    .product-selection-title-text-wrap {
 
        margin-top: -60px;
        margin-left: 60px;
    }

    .product-selection-title-right {
        width: 260px;
        margin-right: 0;
        font-weight: normal;
        font-style: normal;
        z-index: 12;
    }

    .product-selection-box {
        position: relative;
        margin-top: 70px;
    }

    .product-selection-title-text-wrap span.product-selection-title-text-name {
        font-size: 20px;
        color: #555759;
    }

    .description-product-text {
        font-weight: 300;
        line-height: 24px;
    }

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

    .product-selection-description-text {
        padding-right: 40px;
        padding-left: 40px;
    }

    .product-image {
        padding-left: 45px;
        height: 100%;
        display: flex;
        align-items: center;
        max-height: 250px;

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

    .line-thorough {
        position: relative;
    }

    .line-thorough:before {
        content: '';
        position: absolute;
        width: 70px;
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

    .maxwidth80 {
        max-width: 65%;
        margin-left: auto;
        margin-right: auto;
    }

    .description-product-text strong {
        font-weight: 600;
    }

    #product-section-top .row {
        /* margin-left:auto;
    margin-right:auto;     */
    }

    #stock-save-bundles .product-image {
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

    .container {
        margin-left: auto;
        margin-right: auto;
    }

    .product-box-small-title {
        font-family: 'Montserrat';
    }

    .product-selection-box .row-t{
        align-items: center;
    }

    @media (min-width: 767px) {
        .product-image img{
            max-width: 80%;
        }
        #solid-color-with-text-section h1 {
            color: #3c98cc;
            font-size: 140px;
            line-height: 0.8;
            letter-spacing: 1px;
        }

        #solid-color-with-text-section h3 {
            font-size: 52px;
            line-height: 1;
            letter-spacing: 1px;
        }
        .row-t.product-item-display  .col-lg-12 .product-selection-box:nth-child(2) .product-selection-title-text-wrap{
            max-width: 860px;
            margin-top: -45px;
        }

    }

    @media (min-width: 992px) {
        #solid-color-with-text-section h1 {
            color: #3c98cc;
            font-size: 140px;
            line-height: 0.8;
            letter-spacing: 1px;
        }

        #solid-color-with-text-section h3 {
            font-size: 52px;
            line-height: 1;
            letter-spacing: 1px;
        }
    }

    @media (min-width: 1200px) {

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

        .product-selection-box {
            max-height: 440px;
        }

    }

    @media (min-width: 1300px) {
        .max1250 {
            width: 1250px;
            margin-left: auto;
            margin-right: auto;
        }

        #solid-color-with-text-section h1 {
            color: #3c98cc;
            font-size: 140px;
            line-height: 0.8;
            letter-spacing: 1px;
        }

        #solid-color-with-text-section h3 {
            font-size: 52px;
            line-height: 1;
            letter-spacing: 1px;
        }

        .product-selection-box {
            max-height: 440px;
        }

    }

    @media (min-width: 1500px) {
        .max1250 {
            width: 1250px;
            margin-left: auto;
            margin-right: auto;
        }

        #solid-color-with-text-section h1 {
            color: #3c98cc;
            font-size: 140px;
            line-height: 0.8;
            letter-spacing: 1px;
        }

        #solid-color-with-text-section h3 {
            font-size: 52px;
            line-height: 1;
            letter-spacing: 1px;
        }


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

        .product-selection-box {
            max-height: 440px;
        }

    }




    @media (max-width: 1300px) {
        .maxwidth80 {
            max-width: 90%;
        }

        .add-to-cart button {
            width: 100%;
            max-width: 100%;
        }

    }

    @media (max-width: 1200px) {
        .product-selection-box .col-md-1 {
            display: none;
        }

        .add-to-cart button {
            font-size: 14px;
        }
    }

    @media (max-width: 992px) {
        .row-t {
            flex-wrap: wrap;
        }

        #home-page-product-block-whitening-refill-text {
            font-size: 26px;
        }

        #home-page-product-block-whitening-refill-text,
        #home-page-product-block-whitening-refill-buttons {
            height: 120px;
        }

        #home-page-product-block-whitening-refill-text {
            padding-top: 41px;
        }

        #home-page-product-block-whitening-refill-buttons a {
            margin: 13px;
        }

        .product-selection-box .col-md-1 {
            display: none;
        }

        .product-selection-box .col-sm-6.col-md-7 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-sm-6.col-md-5.product-selection-description-text-wrap {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .product-image img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        html body .product-selection-title-text-wrap {
            margin-top: 4px;
    margin-left: 0px;
    background-color: transparent;
    width: 100%;
    margin-bottom: 16px;    padding-left: 15px;
    padding-right: 15px;
        }

        .product-selection-description-text {
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

    @media (max-width: 767px) {
        #solid-color-with-text-section {
            margin-top: 0rem;
        }

        #solid-color-with-text-section h3 {
            font-size: 36px;
        }

        #solid-color-with-text-section h1 {
            font-size: 100px;
        }

        #solid-color-with-text-section .exclusive-offer {
            font-size: 16px;
        }

        #product-section-top .product-block-box-image {
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

        #home-page-product-block-whitening-refill-buttons {
            margin-top: 0px;
        }

        #home-page-product-block-whitening-refill-text,
        #home-page-product-block-whitening-refill-buttons {
            height: auto;
        }

        #home-page-product-block-whitening-refill-buttons a {
            width: 80%;
        }

        .product-selection-title-text-wrap span.product-selection-title-text-name {
            font-size: 18px;

        }

        .product-selection-box {
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

        .product-box {
            margin-bottom: 15px;
        }

        #home-page-product-block-whitening-refill-buttons a {
            margin: 5px;
        }

        #home-page-product-block-whitening-refill-text {
            padding-top: 20px;
            padding-left: 0px;
        }

        #home-page-product-block-whitening-refill-buttons {
            padding-bottom: 15px;
        }


    }


    .textBelowBanner {
        display: none;
    }

    .col-md-8c,.col-md-4c{
            padding-right: 15px;
            padding-left: 15px;
            }
            .hidden{ display:none}

</style>



<section class="page-wrapper">





   <!--banner-->

   <section id="solid-color-with-text-section" class="dailyMailBanner" >
    <div class="banner-heading">
                    <div class="title">
                        <h2>SUBSCRIBER</h2>
                        <p>EXCLUSIVE DEALS</p>
                    </div>
               </div>
    </section>

    <!--banner end-->




   <section class="refillSection">
         <?php
//            get_template_part('inc/templates/sale/gel-refill/gel-refill-section');

        ?>
   </section> 



    <section id="oralCareDeals" class="our-customers-speak-for-us">
        <div class="container max1250">
            <h2 class="text-center hidden"><?php echo get_field('section_heading');?></h2>


            <div class="row-t product-item-display">
                <div class="col-lg-12">
                    <?php $args = array(
                        'post_type' => 'product', 'post_status' => 'publish',/*'meta_key' => 'sale_page_order', 'orderby' => 'meta_value', 'order' => 'ASC',*/
                         'meta_query' => array(
                            'relation' => 'AND', // Optional, defaults to "AND"
                            array(
                                'key'     => 'subscriber_exclusive_deals',
                                'value'   => '1',
                                'compare' => '='
                            )
                        )
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                    $pid =  get_the_id();
                        $_product = wc_get_product((int) $pid);
                        $sale_price =  (int) get_post_meta($pid, '_price', true) - (int) get_post_meta($pid, 'subscriber_exclusive_deals_discount', true);
                        $still_available = get_post_meta($pid, 'still_available', true);
                       ?>
                        <div class="product-selection-box">
                        <div class="row-t">
                            <div class="product-selection-title-text-wrap">
                                <span class="product-selection-title-text-name">
                                   <?php 
                                   
                                   $ptitle = get_post_meta( $pid,'styled_title',true);
                                    if($ptitle == '') {
                                        $ptitle =  get_the_title();
                                    }
                                    $ptitle =  get_the_title();
                                    ?>
                                    <?php echo  $ptitle;?>
                                </span>

                            </div>
                            <div class="product-selection-title-right">
                                <span class="availableItem"><?php echo $still_available;?> STILL AVAILABLE</span> <span class="saveOnItem">SAVE $<?php echo get_post_meta( $pid,'sale_page_discount',true);?></span>
                            </div>
                        </div>
                        <div class="row-t">
                            <div class="col-sm-6 col-md-7">
                                <div class="product-image">
                                    <img src="<?php the_post_thumbnail_url('large');?>" alt="">
                                </div>
                            </div>
                            <!-- <div class="col-md-1"></div> -->
                            <div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
                                <div class="product-selection-description-text">
                                    <?php echo get_post_meta($pid,'sale_page_info',true); ?>
                                    <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">
                                            <?php



                                            if ($_product->is_on_sale()) {
                                            ?>
                                                <div class="original-price">
                                                    <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                    <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span><?php echo $_product->get_regular_price(); ?></div>
                                                </div>

                                                <div class="sale-price">
                                                    <div class="price-heading blue-text">SALE PRICE</div>
                                                    <div class="price-new "><span class="doller-sign">$</span><?php echo $_product->get_sale_price(); ?></div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="original-price">
                                                    <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                    <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span><?php echo get_post_meta($pid, '_price', true); ?></div>
                                                </div>

                                                <div class="sale-price">
                                                    <div class="price-heading blue-text">SALE PRICE</div>
                                                    <div class="price-new "><span class="doller-sign">$</span><?php echo $sale_price; ?></div>
                                                </div>
                                            <?php
                                            }
                                            ?>


                                        </div>

                                    <div class="add-to-cart">
                                            <?php if ($_product->is_on_sale()) {
                                            ?>
                                                <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $pid; ?>" data-quantity="1" data-product_id="<?php echo $pid; ?>"  data-action="woocommerce_add_order_item">ADD TO CART</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $pid; ?>" data-quantity="1" data-product_id="<?php echo $pid; ?>" data-discount_exclusive_deals="<?php echo get_post_meta($pid, 'subscriber_exclusive_deals_discount', true); ?>" data-action="woocommerce_add_order_item">ADD TO CART</button>
                                            <?php
                                            } ?>

                                    </div>

                                </div>



                            </div>

                        </div>
                    </div>
                       <?php
                    endwhile;

                    wp_reset_postdata();

                    ?>
                  

                </div>


            </div>
        </div>

    </section>


</section>



<?php
get_footer();
?>