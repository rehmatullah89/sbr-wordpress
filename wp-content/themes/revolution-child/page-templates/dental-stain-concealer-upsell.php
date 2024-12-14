<?php
/*Template Name: Dental stain concealer upsell*/
get_header();
?>

<style>
    .section-head {
        background: #945aa5;
        background: url(https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/product-stain-conceale/stain-concealer-bg-repeat.jpg);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 340px;
        text-align: center;
        padding-top: 58px 
    }

    .section-head h1 {
        color: white;
        text-align: center;
        font-size: 42px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        font-style: italic;
        margin-bottom: 0;
    }

    .section-head p {
        color: #fff;
        text-align: center;
        font-size: 22px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .product-wrapper-inner {
        display: flex;
        justify-content: center;
        border-radius: 10px;
        background: #FFF;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
        max-width: 991px;
        margin-left: auto;
        margin-right: auto;
        padding: 3rem;
        margin-top: -3rem;
        position: relative;
        padding-top: 0;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .flex-row {
        display: flex;
        margin-left: -15px;
        margin-right: -15px;
    }

    .d-flex {
        display: flex;
    }

    .this-one-time-offer {
        color: #335575;
        text-align: center;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .seprator-line {
        background: #999;
    }

    .content-left-section h2 {
        /* color: #68c8c7; */
        text-align: center;
        font-size: 32px;
        font-style: normal;
        font-weight: 700;
        line-height: 42px;
    }

    .listing {
        color: #444;
        font-family: "Montserrat";
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 38px;
        padding-left: 2rem;
    }

    .wraning-box {
        border-radius: 5px;
        border: 1px solid #f59f8a;
        background: #fdece8;
        text-align: center;
        height: 76px;
        padding: 5px;
    }

    .wraning-box p {
        margin: 0;
        color: #f59f8a;
        text-align: center;
        font-family: "Montserrat";
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 32px;
        /* 200% */
    }

    .time-tracker {
        color: #333;
        text-align: center;
        font-family: "Montserrat";
        font-size: 24px;
        font-style: normal;
        font-weight: 600;
        line-height: 36px;
        /* 150% */
        text-transform: uppercase;
    }

    .price p {
        color: #444;
        text-align: center;
        font-family: "Montserrat";
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 32px;
        margin: 0;
    }

    .was-price,
    .current-price {
        color: #333;
        font-family: "Montserrat";
        font-size: 36px;
        font-style: normal;
        font-weight: 700;
        line-height: 42px;
        position: relative;
        text-align: center;
    }

    .was-price {
        color: #c6c9cd;
    }

    .was-price del {
        position: relative;
        text-decoration-line: none;
    }

    .was-price del:before {
        content: "";
        position: absolute;
        height: 2px;
        background: #f8a18a;
        top: 50% !important;
        left: -3px;
        right: 0;
        margin-top: -1px;
        width: 106%;
    }

    .prices-to-display {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.5rem;
        margin-left: auto;
        margin-right: auto;
        max-width: 90%;
    }

    .line-seprator {
        width: 1px;
        height: 50px;
        background: #88888854;
        position: relative;
        left: -1%;
    }

    .cart-button {
        margin-top: 2rem;
    }

    .cart-button button,
    .cart-button a {
        background: #b8b8dc;
        border-color: #a4a4c3;
        width: 100%;
        height: 65px;
        color: #FFF;
        text-align: center;
        font-size: 24px;
        font-style: normal;
        line-height: normal;
        font-family: "Montserrat";
        letter-spacing: 0.04em;
        font-weight: 400;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f59f8a;
        border-color: #f59f8a;
        text-transform: uppercase;
        transition: all .5s ease 0;
        border-radius: 5px;
    }

    .cart-button a:hover {
        color: #fff;
        background-color: #595858;
        border-color: #595858;
    }

    .quantity-select {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.5rem;
        margin-left: auto;
        margin-right: auto;
        max-width: 90%;
    }

    .quantity-select p {
        margin: 0;
        color: #666;
        font-family: "Montserrat";
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: 32px;
    }

    .select-option {
        min-width: 150px;
    }

    .quantity-select select {
        background-position: calc(100% - 10px) 22px;
        color: #686868;
        background-color: rgba(255, 255, 255, 1);
        border-color: #E7E7E7;
        border-radius: 5px;

    }

    .product-image {
        margin-top: 0rem;
        min-height: 545px;
        position: relative;
        background: #fbf5f5;
        padding: 1rem;
    }

    span.woocommerce-Price-currencySymbol {
        font-size: 16px;
    }

    .product-wrapper {
        position: relative;
    }

    .back-gray-strip {
        /* height: 230px;
        background: #b8b8dc;
        position: absolute; */
        bottom: -9%;
        left: 0;
        right: 0;
        width: 100%;
    }

    span.info {
        font-family: "Montserrat";
        background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/upsell/rectangle-shape-blue.svg");
        background-size: contain;
        width: 110px;
        height: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 7px;
        color: #fff;
        font-weight: 600;
        line-height: normal;
        position: absolute;
        bottom: 0;
        right: 0;
        text-transform: uppercase;
        background-repeat: no-repeat;
    }

    span.item-thumbs {
        position: relative;
    }

    span.item-thumbs {
        width: 33.3333%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0px 1px;
        max-height: 150px;
        overflow: hidden;
        height: 145px;
    }

    .wfocu-prod-qty-wrapper label {
        display: none !important;
    }

    .wfocu-prod-qty-wrapper {
        min-width: 60px;
    }

    .no-thanks-wrap {
        margin: 1rem 0;
        text-align: center;
        position: relative;
    }
    p.this-one-time-offer {
    background-color: #FFF1C1;
    border-radius: 12px;
    padding: 10px 70px 10px 50px;
    position: relative;
    left: -25px;
    z-index: 0;
}

    .no-thanks-wrap a {
        color: #000;
        font-family: "Montserrat";
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        text-decoration: underline;
    }

    .small-logo {
        position: absolute;
        right: 0;
        top: -56px;
        max-width: 60px;
    }

    span.wraning-icon {
        display: flex;
        max-width: 110px;
    }
    .wraning-icon {
        position: relative;
        z-index: 1;
    }

    .section-head h1.order-confirmed {
        color: #8BC34A;
        background: #fff;
        border-radius: 20px;
        margin-bottom: 0;
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        display: inline-flex;
        margin-left: auto;
        margin-right: auto;
        padding-left: 13px;
        padding-right: 15px;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #8bc34a;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark {
        width: 40px;
        height: 49px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #8bc34a;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #7ac142;
        /* animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both; */
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: none;
        }

        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #fff;
        }
    }

    .content-left-section {
        padding-top: 3rem;
    }

    h2.product-header-sub {
        padding-top: 1rem;
        font-size: 82px;
        color: #432f7c;
        line-height: 1;
        font-weight: 400;
        text-align: center;
        margin-top: 0;
    }

    .section-header-teal {
        font-size: 1.1em;
        color: #555759;
        font-weight: 500;
        text-align: center;
    }

    .thumbs-products {
        margin-top: 15px;
    }

    .wrapper.flex-wrapper .form-group-radio-custom {
        -ms-flex: 0 0 32.555%;
        flex: 0 0 32.555%;
        max-width: 32.555%;
    }

    .wrapper.flex-wrapper {
        margin-top: 0px;
        gap: 5px;
    }

    #wrapper .form-group-radio-custom label {
        border-radius: 5px;
    }

    .form-group-radio-custom label span.mmAmount {
        font-weight: 700;
    }

    .content {
        display: none;
    }

    .show {
        display: block;
    }

    .form-group-radio-custom [type="radio"]:checked+label {
        background: #fdece8;
        border-color: #f59f8a !important;
    }

    .form-group-radio-custom [type="radio"]:checked+label:after,
    .form-group-radio-custom [type="radio"]:not(:checked)+label:after {
        background: #f59f8a;
    }

    span.woocommerce-Price-amount.amount {
        font-size: 100%;
        color: inherit;
        font-weight: inherit;

    }

    .form-group-radio-custom label span.mmAmount {
        font-family: "Montserrat";
    }
    .cart-button p {
    font-size: 14px;
    padding-top: 10px;
    text-align: center;
}

    @media only screen and (min-width: 768px) {
        .show-only-mobile {
            display: none;
        }

        .mrge-with-right-side {
            margin-right: -3rem;
        }
    }

    @media only screen and (max-width: 767px) {
        span.item-thumbs {
            height: 116px;
        }
        .header-spacer {
            height: 70px !important;
        }
        .cart-button p br{
            display: none
        }
        .show-only-desktop {
            display: block;
        }
        p.this-one-time-offer {
            padding: 10px 10px 10px 10px;
        }

        .product-wrapper-inner {
            margin-top: 0rem;
            padding: 2rem 1rem;
            max-width: 100%;
        }

        .flex-row {
            flex-wrap: wrap;
        }

        .section-head h1 {
            font-size: 17px;
        }
        .section-head{
            margin-top:45px
        }

        .section-head p {
            font-size: 14px;
            margin-bottom: 0;
            padding:10px
        }

        .m-order-1 {
            order: 1;
        }

        .m-order-2 {
            order: 2;
        }

        .product-image {
            margin-top: 0rem;
            min-height: 0px;
        }

        .content-left-section {
            padding-top: 2rem;
        }

        .content-left-section h2 {
            font-size: 24px;
            line-height: 32px;
        }

        .listing {
            text-align: left;
            line-height: 30px;
            padding-left: 1rem;
        }

        .cart-button button {
            font-size: 20px;
        }

        .section-head {
            padding: 0 15px;
            height: 160px;

        }

        .back-gray-strip {
            display: none;
        }

        .this-one-time-offer {
            font-size: 16px;
        }

        .cart-button button,
        .cart-button a {
            font-size: 16px;
        }

        .no-thanks-wrap {
            padding: 1rem;
        }

        .small-logo {
            top: -18px;
        }

        .prices-to-display,
        .quantity-select {
            max-width: 100%;
        }

        .cart-button button,
        .cart-button a {
            font-weight: 800;
            letter-spacing: 0.06em;
            height: 50px;
        }

        .prices-to-display {
            margin-top: 1rem;
        }

        .hidden-mobile {
            display: none;
        }
        .show-only-mobile {
            display:none
        }

        .form-group-radio-custom label span.mmAmount {
            font-weight: 600;
            font-size: 14px;
        }

        .cart-button {
            margin-top: 1rem;
        }

        .content-left-section {
            padding-top: 0rem;
        }

        .thumbs-products {
            display: block;
            margin-bottom:20px
        }

        .was-price,
        .current-price {
            font-size: 28px;
        }

        .price p {
            font-size: 15px;
        }

        .prices-to-display {
            max-width: 80%;
        }


    }
</style>

<section>
    <div class="section-head">
        <div>
            <h1 class="order-confirmed flex-div">
                <span><svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg></span>
                Order confirmed!
            </h1>
            <h1 class="font-mont">Hurry - Don’t Miss Your BONUS OFFER</h1>
            <p class="font-mont">This is your ONLY chance to <span style="color: #f59f8a;font-size: 125%;font-weight: bold;">SAVE <?php echo do_shortcode('[wfocu_product_save_percentage key="1"]'); ?></span> on the Dental Stain Concealer</p>
        </div>
    </div>

    <div class="product-wrapper">
        <div class="back-gray-strip"></div>
        <div class="product-wrapper-inner">
            <div class="flex-row">
                <div class="col-7 m-order-2">
                    <div class="content-left-section">
                        <div class="show-only-desktop">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="wraning-icon">
                            <img src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/upsell/clicker.png" alt="">
                            </span>
                            <p class="mb-0 this-one-time-offer font-mont">
                            Offer will expire when<br class="hidden-mobile">the window is closed
                            </p>
                           </div>
                            
                            <h2 class="font-mont">
                            Enjoy your<span style="color:#f59f8a;"> <br>EXCLUSIVE
                                    <?php echo do_shortcode('[wfocu_product_save_percentage key="1"]'); ?> DISCOUNT</span> on the
                                <span style="color:#945aa5;"> Dental Concealer</span>
                            </h2>
                            <ul class="listing">
                                <li>Whiter Teeth in 60 seconds!</li>
                                <li>Easy to Use</li>
                                <li>Chemical-Free</li>
                                <li>Non Invasive</li>
                                <li>100% Safe </li>
                            </ul>
                        </div>
                        <div class="wraning-box">
                            <p class="">Only 13 Dental Concealer left!</p>
                            <div class="time-tracker">
                                <span id="time-tracker">
                                    00:00
                                </span>
                                Minutes
                            </div>

                        </div>

                        <div class="quantity-select">
                            <p>Select Quantity:</p>
                            <?php //echo do_shortcode('[wfocu_qty_selector]'); 
                            ?>
                        </div>

                        <div class="wrapper flex-wrapper">
                            <div class="form-group-radio-custom">
                                <input type="radio" name="dental-probitics-offer" id="30-days" checked="">
                                <label for="30-days" class="option ">
                                    <div class="dot"></div>
                                    <span class="mmAmount">30</span>
                                    <span class="mmpopular"> days</span>
                                </label>
                            </div>
                            <div class="form-group-radio-custom">
                                <input type="radio" name="dental-probitics-offer" id="60-days">
                                <label for="60-days" class="option">
                                    <div class="dot"></div>
                                    <span class="mmAmount">Travel</span>
                                    <span class="mmpopular">set</span>
                                </label>
                            </div>
                            <div class="form-group-radio-custom">
                                <input type="radio" name="dental-probitics-offer" id="90-days">
                                <label for="90-days" class="option">
                                    <div class="dot"></div>
                                    <span class="mmAmount">Best</span>
                                    <span class="mmpopular">value</span>
                                </label>
                            </div>
                        </div>


                        <div class="price-btn-box">
                            <div class="content show radio-30-days-content" id="radio-30-days-content">
                                <div class="prices-to-display">
                                    <div class="price">
                                        <p>Original Price:</p>
                                        <div class="was-price">
                                            <del><strong> <?php echo do_shortcode('[wfocu_product_regular_price key="3"]'); ?></strong></del>
                                        </div>
                                    </div>
                                    <div class="line-seprator"></div>
                                    <div class="price">
                                        <p>Your Price:</p>
                                        <div class="current-price">
                                            <strong> <?php echo do_shortcode('[wfocu_product_offer_price  key="3"]'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-button">
                                    <?php echo do_shortcode('[wfocu_yes_link  key="3"]BUY NOW[/wfocu_yes_link]'); ?>
                                    <p>Clicking "Buy Now" will automatically charge card on file. <br> Items will be added to your original order.</p>
                                </div>
                            </div>
                            <div class="content radio-60-days-content" id="radio-60-days-content">
                                <div class="prices-to-display">
                                    <div class="price">
                                        <p>Original Price:</p>
                                        <div class="was-price">
                                            <del><strong> <?php echo do_shortcode('[wfocu_product_regular_price key="2"]'); ?></strong></del>
                                        </div>
                                    </div>
                                    <div class="line-seprator"></div>
                                    <div class="price">
                                        <p>Your Price:</p>
                                        <div class="current-price">
                                            <strong> <?php echo do_shortcode('[wfocu_product_offer_price  key="2"]'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-button">
                                    <?php echo do_shortcode('[wfocu_yes_link  key="2"]BUY NOW[/wfocu_yes_link]'); ?>
                                    <p>Clicking "Buy Now" will automatically charge card on file. <br> Items will be added to your original order.</p>
                                </div>
                            </div>
                            <div class="content radio-90-days-content" id="radio-90-days-content">
                                <div class="prices-to-display">
                                    <div class="price">
                                        <p>Original Price:</p>
                                        <div class="was-price">
                                            <del><strong> <?php echo do_shortcode('[wfocu_product_regular_price key="1"]'); ?></strong></del>
                                        </div>
                                    </div>
                                    <div class="line-seprator"></div>
                                    <div class="price">
                                        <p>Your Price:</p>
                                        <div class="current-price">
                                            <strong> <?php echo do_shortcode('[wfocu_product_offer_price  key="1"]'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-button">
                                    <?php echo do_shortcode('[wfocu_yes_link  key="1"]BUY NOW[/wfocu_yes_link]'); ?>
                                    <p>Clicking "Buy Now" will automatically charge card on file. <br> Items will be added to your original order.</p>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

                <div class="col-5 m-order-1">
                    <div class="show-only-mobile content-left-section">
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="wraning-icon">
                        <img src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/upsell/clicker.png" alt="">
                        </span>
                        <p class="mb-0 this-one-time-offer font-mont">
                        Offer will expire when<br class="hidden-mobile">the window is closed
                        </p>
                    </div>
                        <hr class="seprator-line">
                        <h2 class="font-mont">
                            Enjoy your<span style="color:#f59f8a;"> <br>EXCLUSIVE
                                    <?php echo do_shortcode('[wfocu_product_save_percentage key="1"]'); ?> DISCOUNT</span> on the
                                <span style="color:#945aa5;"> Dental Concealer</span>
                            </h2>
                    </div>

                    <div class="product-image mrge-with-right-side">
                        <h2 class="product-header-sub mt-8rem" style="margin-bottom: 3px; padding-bottom: 0;"><span class="font-sig">Night Out!</span></h2>
                        <h1 id="fresh-take-text" class="section-header-teal medium">DENTAL STAIN CONCEALER</h1>
                        <div style="background: #432f7c; width: 125px; margin: 20px auto 20px auto; height: 4px;"></div>

                        <div class="content show radio-30-days-content" id="">
                            <div class="image-wrapper">
                                <img src="https://www.smilebrilliant.com/wp-content/uploads/2023/10/1_bottles.png">
                            </div>
                        </div>
                        <div class="content radio-60-days-content" id="">
                            <div class="image-wrapper">
                                <img src="https://www.smilebrilliant.com/wp-content/uploads/2023/10/2_bottles.png">
                            </div>
                        </div>
                        <div class="content radio-90-days-content" id="">
                            <div class="image-wrapper">
                                <img src="https://www.smilebrilliant.com/wp-content/uploads/2023/10/3_bottles.png">
                            </div>
                        </div>


                    </div>
                    <div class="thumbs-products">
                        <div class="d-flex align-items justify-content-center">
                            <span class="item-thumbs">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/upsell/stain13.png" alt="" />
                            <span class="info">TRANSFORM YOUR TEETH</span>

                            </span>
                            <span class="item-thumbs">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/upsell/stain12.png" alt="" />
                            <span class="info">BRUSH AND RINSE</span>

                            </span>
                            <span class="item-thumbs brilliant-teeth">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/upsell/stain3.png" alt="" />
                            <span class="info">SAFE FOR DAILY USE</span>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="no-thanks-wrap">
            <?php echo do_shortcode('[wfocu_no_link]No thanks, Skip this one-time offer[/wfocu_no_link]'); ?>
        </div>

    </div>

</section>

<script>
    $(document).ready(function() {
        var minutes = 5;
        var seconds = 0;

        function updateTimer() {
            var timerDisplay = $('#time-tracker');
            timerDisplay.text(minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0'));
        }

        function countdown() {
            if (minutes === 0 && seconds === 0) {
                clearInterval(timerInterval);
                location.reload();
                setTimeout(function() {
                    location.reload(); // Refresh the page after 10 minutes
                }, 600000); // 10 minutes in milliseconds
            } else {
                if (seconds === 0) {
                    minutes--;
                    seconds = 59;
                } else {
                    seconds--;
                }
                updateTimer();
            }
        }

        updateTimer(); // Initialize the timer display

        var timerInterval = setInterval(countdown, 1000); // Update the timer every second


        $("input[name='dental-probitics-offer']").change(function() {
            var selectedRadio = $("input[name='dental-probitics-offer']:checked").attr('id');

            // Hide all content divs
            $(".content").hide();

            // Show the corresponding content div based on the selected radio button
            $(".radio-" + selectedRadio + "-content").show();
        });

    });
</script>

<?php

get_footer();

?>