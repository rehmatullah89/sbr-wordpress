<?php
/*Template Name: Scan Template*/
get_header();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.css">
<style>
    .radio-buttons .form-group {
        margin: 0;
        font-size: 18px;
        color: #777b84;
    }

    .radio-buttons input[type="radio"] {
        display: none;
    }

    .radio-buttons label {
        cursor: pointer;
        position: relative;
        font-size: 18px;
        padding-left: 40px;
    }

    .radio-buttons label::before {
        content: "";
        position: absolute;
        width: 24px;
        height: 24px;
        background-color: transparent;
        border: 2px solid #cbcbcb;
        border-radius: 50%;
        top: 50%;
        left: 0rem;
        transform: translateY(-50%);
        transition: border-color 400ms ease;

    }

    .radio-buttons label::after {
        content: "";
        position: absolute;
        width: 24px;
        height: 24px;
        border: 0px solid #5cc20e;
        background-color: #69be28;
        border-radius: 50%;
        top: 50%;
        left: 0rem;
        transform: translateY(-50%) scale(0);
        transition: transform 400ms ease;

    }

    #wrapper .radio-buttons .form-group label {
        font-size: 18px;
    }

    .radio-buttons input[type="radio"]:checked+label::before {
        border-color: #69be28;
    }

    .radio-buttons input[type="radio"]:checked+label::after {
        transform: translateY(-50%) scale(0.55);
    }


    .floating-labels .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    #wrapper .floating-labels input {
        position: relative;
        display: block;
        width: 100%;
        border: 1px solid #dedede;
        border-radius: 4px;
        background-color: transparent;
        margin: 0px auto;
        padding: 6px 4px 4px 14px;
        outline: none !important;
        font-size: 16px;
        color: rgb(0 0 0 / 91%);
        transition: all .2s ease-in-out;
        padding-top: 12px;
    }

    #wrapper .floating-labels input:focus {
        outline: none !important;
    }

    #wrapper .floating-labels input.invalid,
    #wrapper .invalid {
        border-color: red;
    }

    .floating-labels label {
        /* position: absolute;
        top: 18px;
        left: 12px;
        text-align: left;
        display: inline-block;
        padding: 0 4px;
        height: 14px;
        line-height: 14px;
        font-size: 14px;
        font-weight: 400;
        background: #fff;
        color: rgba(0, 0, 0, 0.5);
        margin: 0px auto;
        cursor: text;
        transition: all .15s ease-in-out; */
    }

    .floating-labels input:hover,
    .floating-labels input:focus {
        /* border: 1px solid #000; */
    }

    .floating-labels input:valid+label,
    .floating-labels input:focus+label {
        /* top: -6px;
        color: #000;
        font-weight: bold; */
    }

    .floating-labels .gl-form-asterisk {
        /* background-color: inherit;
        color: #e32b2b;
        padding: 0;
        padding-left: 3px; */

    }

    .floating-labels .gl-form-asterisk:after {
        content: "*";
    }

    .styled-checkbox {
        position: absolute;
        opacity: 0;
    }

    .styled-checkbox+label {
        position: relative;
        cursor: pointer;
        padding: 0;
    }

    .styled-checkbox+label:before {
        content: '';
        margin-right: 10px;
        display: inline-block;
        vertical-align: text-top;
        width: 20px;
        height: 20px;
        background: white;
        border: 1px solid #333;
    }

    .styled-checkbox:hover+label:before {
        /* background: #69be28a1; */
    }

    .styled-checkbox:focus+label:before {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.12);
    }

    .styled-checkbox:checked+label:before {
        background: #69be28;
        border: 1px solid #69be28;
    }

    .styled-checkbox:disabled+label {
        color: #b8b8b8;
        cursor: auto;
    }

    .styled-checkbox:disabled+label:before {
        box-shadow: none;
        background: #ddd;
    }

    .styled-checkbox:checked+label:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 9px;
        background: white;
        width: 2px;
        height: 2px;
        box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
        transform: rotate(45deg);
        /* border: 1px solid #69be28; */
    }

    .title {
        text-align: center;
        color: #4571ec;
    }

    /* (A) BASICS - HIDE DEFAULT + SHOW CUSTOM ARROW */
    .sel select {
        appearance: none;
    }

    .sel::after {
        content: "\25b6";
    }

    /* (B) DIMENSIONS */
    /* (B1) WRAPPER - OPTIONAL */
    .sel {
        max-width: 400px;
        margin-top: 25px;
    }

    /* (B2) "EXPAND" SELECT BOX */
    .sel select {
        width: 100%;

        border: 1px solid #dedede;
        background: #fff;
        color: #777b84;
        font-size: 16px;
        font-weight: 400;
        font-family: 'Open Sans';
        border-radius: 4px;
    }

    /* (C) POSITION CUSTOM ARROW */
    /* (C1) REQUIRED FOR ABSOLUTE POSITION BELOW */
    .sel {
        position: relative;
    }

    /* (C2) DEFAULT - ARROW ON RIGHT SIDE */
    .sel::after {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
    }

    /* (C3) ARROW ON LEFT SIDE */
    .left.sel::after {
        left: 10px;
        right: auto;
    }

    .left.sel select {
        padding-left: 30px;
    }

    /* (D) COSMETICS */
    /* (D1) CUSTOM ARROW IS ESSENTIALLY TEXT! */
    .sel::after {
        font-size: 22px;
        color: #aaa;
    }

    /* (D2) ROTATE ARROW ON HOVER */
    .sel::after {
        transition: all 0.3s;
    }

    .sel:hover::after {
        transform: translateY(-50%) rotate(90deg);
        color: #69be28;
    }


    .contact-information-wrapper {
        max-width: 834px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        background: #fff;
        margin-top: 60px;
        border-radius: 5px;
        border: 1px solid #fff;
        padding-bottom: 30px;
    }

    .registration-form {
        background: #024;
        padding: 4rem;
    }

    .pro-shield-logo {
        text-align: center;
        margin-bottom: 50px;
    }

    .tp-heading-one {
        max-width: 1050px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        color: #fff;
    }

    .tp-heading-one p {
        font-size: 24px;
        line-height: 1.4;
        margin: 0;
    }

    .tp-heading-one p.scan-live-paragraph {
        color: #69be28;
        font-family: 'Montserrat';
        font-weight: 300;
        font-size: 32px;
    }

    .tp-heading-one h1 {
        margin: 0;
        color: #fff;
        margin-bottom: 44px;
        line-height: 1;
    }

    .contact-form-wrapper-header {
        background: #69be28;
        padding: 10px;
        border-radius: 5px 5px 0 0px;
        padding-left: 35px;
        padding-right: 35px;
    }

    .contact-form-wrapper-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: bold;
        color: #fff;
    }

    .contact-form-body {
        padding: 35px;
    }

    .radio-buttons {
        display: flex;
        align-content: center;
        gap: 25px;
    }

    .form-labels.floating-labels {
        margin-top: 30px;
    }

    .form-row {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;

    }

    .form-col-12 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;


    }

    .form-col-6 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }

    .form-col-8 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 66.6666%;
        flex: 0 0 66.6666%;
        max-width: 66.6666%;
    }

    .form-col-4 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 33.3333%;
        flex: 0 0 33.3333%;
        max-width: 33.3333%;
    }


    .tolltip-text {
        font-size: 12px;
        padding-left: 15px;
    }

    .text-green {
        color: #69be28;
    }

    .border1px-gray {
        border: 1px solid #dedede;
    }

    .py-3 {
        padding: 18px;
    }

    .radus-5 {
        border-radius: 5px;
    }

    .products-wrapper h3,
    .select-your-primay-sport h3 {
        color: #777b84;
        font-size: 20px;
        font-weight: 400;
        margin-bottom: 4px;
    }

    .unstyled.centered {
        list-style: none;
    }

    #wrapper label {
        color: #777b84;
        font-size: 20px;
        font-weight: 400;
    }

    #wrapper .unstyled.centered label {
        font-size: 14px;
    }

    .checkbox-wrapper {
        margin-top: 20px;
        padding-left: 28px;
    }

    .select-your-primay-sport {
        margin-top: 40px;
    }

    .footer-wrapper {
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .footer-wrapper button {
        width: 75%;
        background: #69be28;
        border-color: #69be28;
        color: #fff;
        font-size: 20px;
        margin-bottom: 10px;
        position: relative;
    }

    .below-indicatot {
        font-size: 10px;
        color: #555759;
        font-style: italic;
    }



    .contact-form-body :-ms-input-placeholder {
        /* Internet Explorer 10-11 */
        color: #777b84;
        font-size: 16px !important;
        font-weight: 400;
        opacity: 1;
    }

    html body .contact-form-body ::placeholder {
        color: #777b84;
        font-size: 16px !important;
        font-weight: 400;
        opacity: 1;
    }

    #select-your-primary-sport {
        display: none;
    }

    .add-manual a {
        font-size: 16px;
        font-weight: 400;
        font-family: 'Montserrat', 'BlinkMacSystemFont', -apple-system, 'Roboto', 'Lucida Sans';
        color: #69be28;
        padding-bottom: 4px;
        display: flex;
        justify-content: end;
    }

    .address-wrapper {
        background: #69be2812;
        padding: 15px;
        border: 1px solid #dedede;
    }

    #wrapper .floating-labels .address-wrapper input {
        background-color: #fff;
        margin-bottom: 14px;
    }

    #custom-address {
        display: none;
    }

    .default-stat-hide {
        display: none;
        color: gray;
    }

    .activate-custom-address .default-stat-hide {
        display: inline-flex;
    }

    .activate-custom-address .default-stat {
        display: none;
    }

    /* after success */
    .thankyou_registerDescription {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .product-image-mb {
        text-align: center;
        color: transparent;
        height: 200px;
        width: 200px;
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    .product-image-m img {
        max-width: 100;
    }

    .thankyou_description {
        text-align: center;
    }

    .thankyou_description h1,
    .thankyou_description p,
    .thankyou_description,
    .thankyou_description strong {
        color: #fff;
    }

    .thankyou_description strong.thankyou_scan {
        color: #69be28;
        display: block;
        text-align: center;
        font-size: 40px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .thankyou_description {
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .footer {
        padding: 0px 0;
    }

    .after-success-message {
        display: none;
    }

    .form-control-wrapper {
        position: relative;
    }

    .field-float {
        position: relative;
    }

    #wrapper label.form-control-label {
        position: absolute;
        top: 50%;
        left: 13px;
        margin-top: -11px;
        transform-origin: left top;
        color: #969595;
        font-size: 16px;
        line-height: 20px;
        font-weight: 400;
        /* background-color: #fff; */
        background: #fff !important;
        pointer-events: none;
        transition: all .235s ease;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        z-index: 9;
        bottom: 5px;
        right: 20px;
        margin-bottom: 0;
        /* width: 88%; */
    }

    #wrapper .anim-wrap label.form-control-label {
        top: 2px;
        top: -7px;
        font-size: 12.5px;
        background: 0 0;
        bottom: auto;
        right: auto;
        margin-top: 0;
        line-height: 16px;
        width: auto;
    }

    #wrapper .floating-labels input.invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        /* background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e"); */
        /* background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem); */
    }

    .scan-id-avaialble a {
        color: #3599ca;
        font-weight: 400;
        font-size: 16px;
        margin-top: 5px;
        /* display: flex; */
        color: #3c98cc;
        font-size: 12px;
        margin-top: -1px;
        /* display: flex; */
        padding: 4px 0;
        /* border: 1px solid #dedede; */
    }

    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 897;
    }

    .overlay:target,
    .overlay.open {
        visibility: visible;
        opacity: 1;
    }

    .popup {
        margin: 70px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 30%;
        position: relative;
        transition: all 5s ease-in-out;
    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }

    .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }

    .popup .close:hover {
        color: #06D85F;
    }

    .popup .content {
        max-height: 30%;
        overflow: auto;
    }

    .flex-div-row {
        display: flex;
        gap: 10px;
    }

    .flex-div-row select {
        padding: 0 8px;
    }

    .icon-container {
        position: absolute;
        right: 10px;
        top: calc(50% - 10px);
        z-index: 98;
        opacity: 0;
        visibility: hidden;
    }

    .icon-container.animate-loader {
        opacity: 1;
        visibility: visible;
    }

    .loader {
        position: relative;
        height: 20px;
        width: 20px;
        display: inline-block;
        animation: around 5.4s infinite;
    }

    @keyframes around {
        0% {
            transform: rotate(0deg)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    .loader::after,
    .loader::before {
        content: "";
        background: white;
        position: absolute;
        display: inline-block;
        width: 100%;
        height: 100%;
        border-width: 2px;
        border-color: #69be28 #69be288a transparent transparent;
        border-style: solid;
        border-radius: 20px;
        box-sizing: border-box;
        top: 0;
        left: 0;
        animation: around 0.7s ease-in-out infinite;
    }

    .loader::after {
        animation: around 0.7s ease-in-out 0.1s infinite;
        background: transparent;
    }

    .popup .scan-id-avaialble a {
        font-size: 16px;
        border: 0;
        padding: 0;
    }

    .footer-wrapper button:disabled,
    .footer-wrapper button[disabled] {
        background: #69be28;
        border-color: #69be28;
        color: #666666;
        opacity: 0.3;
        cursor: not-allowed;
    }

    .form-select {
        font-size: 16px;
        font-weight: 400;
        font-family: 'Open Sans';
        border-radius: 4px;
        color: #2c2c2c;
        background-color: #fff;
    }

    .error-message {
        color: red;
        font-size: 12px;
    }

    .invalid .error-message {
        display: flex !important;
    }

    #productBox.invalid {
        border-color: #dc3545;
    }
    .bold{ font-weight: bold;} 
    .click-here{ text-decoration: underline;
display: inline-flex;
padding-left: 3px;
padding-right: 3px;}

    @media only screen and (min-width: 768px) {
        #wrapper .floating-labels .address-wrapper .last-row input {
            margin-bottom: 0px;
        }
    }

    @media only screen and (max-width: 767px) {
        .registration-form {
            padding: 20px;
        }

        .contact-form-body {
            padding: 20px 10px;
        }

        .form-labels.floating-labels {
            margin-top: 15px;
        }

        .tolltip-text {
            padding-left: 0px;
            text-align: left;
        }

        .form-col-6,
        .form-col-4,
        .form-col-8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .checkbox-wrapper {
            padding-left: 0px;
            margin-left: -11px;
        }

        #wrapper .floating-labels .checkbox-wrapper input {
            display: none;
        }

        .unstyled.centered li {
            margin-bottom: 10px;
        }

        .products-wrapper h3,
        .select-your-primay-sport h3 {
            text-align: left;
        }

        .pro-shield-logo {
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 8px;
        }

        .tp-heading-one h1 {
            margin-bottom: 10px;
            font-size: 24px;
        }

        .tp-heading-one p {
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }

        .tp-heading-one p.scan-live-paragraph {
            font-size: 24px;
        }

        .contact-information-wrapper {
            margin-top: 20px;
            margin-left: -20px;
            margin-right: -20px;
            width: inherit;
            border-radius: 0px;
        }

        .contact-form-wrapper-header {
            border-radius: 0px;
            padding-left: 10px;
            padding-right: 0px;
            text-align: left;
        }

        #wrapper .radio-buttons .form-group label {
            font-size: 16px;
        }

        #wrapper .unstyled.centered label {
            font-size: 14px;
            height: auto;
            display: flex;
            align-content: flex-start;
            line-height: 1.2;
        }

        .styled-checkbox+label::before {
            min-width: 20px;
            min-height: 20px;
        }

        .popup {
            width: 90%;
        }

    }
</style>



<div class="scan-wrapper">
    <div class="registration-form">
        <div class="form-beore-register">
            <div class="pro-shield-logo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/scan/pro-shield-scan.png" alt="Pro Shield" class="" />
            </div>

            <div class="tp-heading-one">
                <p class="scan-live-paragraph">LIVE SCAN</p>
                <h1>REGISTRATION FORM</h1>
                <p>After completing the registration form below, you will be sent a unique ID number via text message.
                    Please present the ID to the agent who will be scanning your teeth. This ID is used to match your scan
                    with your account!</p>
            </div>


            <div class="contact-information-wrapper">
                <div class="contact-form-wrapper-header">
                    <h3 class="font-mont">CONTACT INFORMATION</h3>
                </div>
                <div class="contact-form-body">


                    <form class="form-md" id="registration-form">


                        <div class="radio-buttons">
                            <div class="form-group">
                                <input type="radio" id="female" name="gender" value="female" autocomplete="off" />
                                <label for="female"><span>Female</span></label>
                            </div>
                            <div class="form-group">
                                <input type="radio" id="male" name="gender" value="male" autocomplete="off" checked="" />
                                <label for="male"><span>Male</span></label>
                            </div>
                        </div>


                        <div class="form-labels floating-labels">
                            <div class="form-row">
                                <div class="form-col-12">
                                    <div class="form-group field-float">
                                        <div class="form-control-wrapper">
                                            <div class="icon-container"><i class="loader"></i></div>
                                            <input id="form_email" name="form_email" class="form-control" type="email" placeholder="" autocomplete="off">
                                            <label for="form_email" class="form-control-label">Email <span class="gl-form-asterisk"></span></label>
                                        </div>
                                        <div class="scan-id-avaialble" style="display: none;">
                                            <a class="text-decoration-none  fw-bold text-blue-500 thnkayoupage_show" href="javascript:;">Your scan ID is already available <span class="bold click-here"> Click Here</span> to view!</a>
                                        </div>
                                        <div class="tolltip-text text-green" id="confirmation-email">A confirmation email will be sent to this
                                            account</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-6">
                                    <div class="form-group field-float">
                                        <div class="form-control-wrapper">
                                            <div class="icon-container"><i class="loader"></i></div>
                                            <input id="form_name1" name="first_name" class="form-control" type="text" placeholder="" autocomplete="off">
                                            <label for="form_name1" class="form-control-label">Name<span class="gl-form-asterisk"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-col-6">
                                    <div class="form-group field-float">
                                        <div class="form-control-wrapper">
                                            <div class="icon-container"><i class="loader"></i></div>
                                            <input id="form_last-name" name="last_name" class="form-control" type="text" placeholder="" autocomplete="off">
                                            <label for="form_last-name" class="form-control-label">Last name<span class="gl-form-asterisk"></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-6">
                                    <div class="form-group field-float">
                                        <div class="form-control-wrapper">
                                            <div class="icon-container"><i class="loader"></i></div>
                                            <input id="form_phone_number" name="phone" class="form-control" type="tel" placeholder="" autocomplete="off">
                                            <label for="form_phone_number" class="form-control-label">Cell phone<span class="gl-form-asterisk"></span></label>
                                        </div>
                                        <div class="tolltip-text text-green">You will receive a confirmation text with your
                                            Scan ID</div>
                                    </div>
                                </div>
                                <div class="form-col-6">
                                    <div class="form-group">
                                        <div class="field  flex-div-row">

                                            <select class="form-select" id="dob_month" name="month">
                                                <option value="">month</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                            <select class="form-select" id="dob_day" name="day">
                                                <option value="">day</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>


                                            <select class="form-select" id="dob_year" name="year">
                                                <option value="">year</option>
                                                <option value="1950">1950</option>
                                                <option value="1951">1951</option>
                                                <option value="1952">1952</option>
                                                <option value="1953">1953</option>
                                                <option value="1954">1954</option>
                                                <option value="1955">1955</option>
                                                <option value="1956">1956</option>
                                                <option value="1957">1957</option>
                                                <option value="1958">1958</option>
                                                <option value="1959">1959</option>
                                                <option value="1960">1960</option>
                                                <option value="1961">1961</option>
                                                <option value="1962">1962</option>
                                                <option value="1963">1963</option>
                                                <option value="1964">1964</option>
                                                <option value="1965">1965</option>
                                                <option value="1966">1966</option>
                                                <option value="1967">1967</option>
                                                <option value="1968">1968</option>
                                                <option value="1969">1969</option>
                                                <option value="1970">1970</option>
                                                <option value="1971">1971</option>
                                                <option value="1972">1972</option>
                                                <option value="1973">1973</option>
                                                <option value="1974">1974</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                            </select>


                                            <?php /*
                                        <input class="form-control" type="text" placeholder="Select Date.." data-id="minDate" readonly="readonly" id="birthday" name="birthday" autocomplete="off">
                                        
                                        <!-- <input type="text" placeholder="Birthday *" id="birthday" name="birthday" class=""> -->
                                        <!-- <label for="form_phone_number">Date of Birth:<span
                                            class="gl-form-asterisk"></span></label> -->
                                            */
                                            ?>
                                        </div>
                                        <div class="tolltip-text text-green">MM/DD/YYYY - Birthday of the person being
                                            scanned</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <div class="form-group">

                                        <div class="add-manual" id="addManual">
                                            <a href="javascript:;"> <span class="default-stat"><span>+</span> Add apartment etc </span>
                                                <span class="default-stat-hide"> Use autocomplete </span>
                                            </a>
                                        </div>
                                        <div id="mailing-address-wrapper" class="field-float">
                                            <div class="form-control-wrapper">
                                                <div class="icon-container"><i class="loader"></i></div>
                                                <input id="mailing-address" name="mailing-address" class="form-control" type="text" placeholder="" autocomplete="off">
                                                <label for="mailing-address" class="form-control-label">Start typing your mailing address...*<span class="gl-form-asterisk"></span></label>
                                            </div>
                                            <div class="tolltip-text text-green">Type your mailing address and the form will
                                                show
                                                you auto-complete options</div>
                                        </div>
                                        <div class="custom-address-wrapper" id="custom-address">
                                            <div class="address-wrapper">
                                                <div class="form-row">
                                                    <div class="form-col-12">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" name="form_address" id="form_address" class="form-control" type="text" placeholder="" autocomplete="off">
                                                                <label for="form_address" class="form-control-label">Address<span class="gl-form-asterisk"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-col-4">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper anim-wrap">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" readonly name="form_country" id="form_country" value="US" class="form-control" type="text" placeholder="US" autocomplete="off">
                                                                <label for="form_country" class="form-control-label">Country<span class="gl-form-asterisk"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-col-4">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" name="form_city" id="form_city" class="form-control" type="text" placeholder="" autocomplete="off">
                                                                <label for="form_city" class="form-control-label">City<span class="gl-form-asterisk"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-col-4">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" name="form_postal_code" id="form_postal_code" class="form-control" type="number" placeholder="" autocomplete="off">
                                                                <label for="form_postal_code" class="form-control-label">Post Code<span class="gl-form-asterisk"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row last-row">
                                                    <div class="form-col-4">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" name="form_billing" id="form_billing" class="form-control" type="text" placeholder="" autocomplete="off">
                                                                <label for="form_billing" class="form-control-label">State<span class="gl-form-asterisk"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-col-8">
                                                        <div class="field-float">
                                                            <div class="form-control-wrapper">
                                                                <div class="icon-container"><i class="loader"></i></div>
                                                                <input type="text" name="form_apartment" id="form_apartment" class="form-control" type="text" placeholder="Apartment, suite, unite etc. (optional)" autocomplete="off">
                                                                <label for="form_apartment" class="form-control-label">Apartment, suite, unite etc. (optional)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="products-wrapper border1px-gray radus-5 py-3" id="productBox">
                                <h3>Which products are you most interested?</h3>
                                <span class="error-message" style="display:none;">Please select anyone</span>
                                <div class="tolltip-text text-green">Please select all the options that you may be
                                    interested in (now and in the future)</div>


                                <div class="checkbox-wrapper">

                                    <ul class="unstyled centered">

                                        <li>
                                            <input class="styled-checkbox" id="sports-mouth-guard" autocomplete="off" type="checkbox" name="interested_products[]" value="ProShield™ Custom-fitted Sports Mouth Guards">
                                            <label for="sports-mouth-guard">ProShield™ Custom-fitted Sports Mouth Guards</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="custom-fitted-whitening-trays" autocomplete="off" type="checkbox" name="interested_products[]" value="Custom-fitted Teeth Whitening Trays">
                                            <label for="custom-fitted-whitening-trays">Custom-fitted Teeth Whitening Trays</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="custom-fitted-night-guards" autocomplete="off" type="checkbox" name="interested_products[]" value="Custom-fitted Night Guards (for teeth grinding/clenching)">
                                            <label for="custom-fitted-night-guards">Custom-fitted Night Guards (for teeth grinding/clenching)</label>
                                        </li>

                                        <li>
                                            <input class="styled-checkbox" id="clear-retainers" type="checkbox" autocomplete="off" name="interested_products[]" value="Clear Retainers">
                                            <label for="clear-retainers">Clear Retainers</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="clear-aligners" type="checkbox" autocomplete="off" name="interested_products[]" value="Clear Aligners (for straightening teeth)">
                                            <label for="clear-aligners">Clear Aligners (for straightening teeth)</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="select-your-primay-sport border1px-gray radus-5 py-3" id="select-your-primary-sport">
                                <h3>Select your primary sport.</h3>
                                <div class="tolltip-text text-green">If you play multiple sports, please just select your
                                    primary sport where you will use your mouth guard.</div>

                                <div class="form-row dropdown-box">
                                    <div class="form-col-12">

                                        <div class="sel">
                                            <select name="primary_sport">
                                                <option selected val="Football">Football</option>
                                                <option val="Baseball / Softball">Baseball / Softball</option>
                                                <option val="Basketball">Basketball</option>
                                                <option val="Boxing">Boxing</option>
                                                <option val="CrossFit">CrossFit</option>
                                                <option val="Cycling">Cycling</option>
                                                <option val="Equestrian">Equestrian</option>
                                                <option val="Hockey">Hockey</option>
                                                <option val="Lacrosse">Lacrosse</option>
                                                <option val="Martial arts">Martial arts</option>
                                                <option val="MMA">MMA</option>
                                                <option val="Motocross">Motocross</option>
                                                <option val="Rugby">Rugby</option>
                                                <option val="Rugby">Rugby</option>
                                                <option val="Tennis">Tennis</option>
                                                <option val="Vollyball">Vollyball</option>
                                                <option val="Weightlifting">Weightlifting</option>
                                                <option val="Wrestling">Wrestling</option>
                                                <option val="Other">Other</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="footer-wrapper">
                    <div class="register-btn">
                        <button type="button" class="btn btn-register" id="register-btn">REGISTER</button>
                    </div>
                    <div class="below-indicatot">
                        Your information will never be sold or made public. You can request to have your account and data
                        deleted at any time. By registering, you agree to Smile Brilliant Ventures, Inc <a href="/terms-of-use/" style="color: #69be28;">Terms & Conditions</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="after-success-message">
            <div class="pro-shield-logo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/scan/pro-shield-scan.png" alt="Pro Shield" class="" />
            </div>
            <div class="product-image-mb">
                <img class="produt-image" src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/products/pro-shield/pro-shield-banner-image.png">
            </div>

            <div class="thankyou_description">
                <h1>YOU'RE IN!</h1>
                <div class="thankyou_registerDescription">
                    <p class="thankyou">
                        <strong>Dear <span id="user_successname"></span>,</strong> <br>
                        we have confirmed your account registration with Smile Brilliant / ProShield!
                        <br> Your registration ID is <strong id="user_succestray" class="thankyou_scan">LS288546</strong>
                        Please present this ID to your agent before they begin your scan. Login details have been emailed to your email address at <strong id="user_successmail"></strong>.
                    </p>
                </div>

            </div>



        </div>



    </div>

</div>

<div id="popup1" class="overlay">
    <div class="popup">
        <h2><img src="https://www.smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logo-vertical-nosub-584x162-1.png" class="logoimg logo-light" alt="Smile Brilliant"></h2>
        <a class="close" href="javascript:;">&times;</a>
        <div class="content">
            <div class="scan-id-avaialble">
                <a class="text-decoration-none  fw-bold text-blue-500 thnkayoupage_show">Your scan ID is already available <span class="bold click-here"> Click Here</span> to view!</a>
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.js"></script> -->
<script>
    $("#sports-mouth-guard").change(function() {
        $("#select-your-primary-sport").slideToggle();
    });

    jQuery(document).ready(function() {
        jQuery('#form_phone_number').mask('(999) 999-9999');

        $('#form_phone_number').on('input', function() {
            const inputVal = $(this).val().replace(/\D/g, ''); // Remove non-digit characters
            if (inputVal.length === 10) {
                $(this).removeClass('invalid').addClass('valid');
            } else {
                $(this).removeClass('valid').addClass('invalid');
            }
        });

    });

    $(document).ready(function() {
        $("#addManual").click(function() {
            $(this).toggleClass("activate-custom-address");
            $("#mailing-address-wrapper").slideToggle();
            $("#custom-address").slideToggle();
        });


        let isValid = true;

        function validateField(inputField, validatorFunction) {
            const value = $(inputField).val();
            if (value === '') {
                isValid = false;
                $(inputField).addClass('invalid');
            } else {
                const isFieldValid = validatorFunction(value);
                if (isFieldValid) {
                    $(inputField).removeClass('invalid');
                } else {
                    $(inputField).addClass('invalid');
                    isValid = false;
                }
            }
        }


        const form = document.getElementById('registration-form');


        // Initialize flatpickr for each input

        // Function to check if a field is empty
        function isEmpty(value) {
            return value.trim() === '';
        }

        // Function to check if an email is in a valid format
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Function to check if a field is a valid phone number
        function isValidPhoneNumber(value) {
            // Remove spaces and hyphens from the input
            const cleanedValue = value.replace(/[\s-]/g, '');
            return /^\d+$/.test(cleanedValue);
        }

        // Function to validate field including phone number validation
        function validateFieldbk(inputField) {
            const value = inputField.value;
            let isValid = !isEmpty(value);

            if (inputField.id === 'form_email') {
                isValid = isValid && isValidEmail(value);
            }

            if (inputField.id === 'form_phone_number') {
                isValid = isValid && isValidPhoneNumber(value);
            }

            // Skip validation of specific fields when conditions are met
            if (!$("#addManual").hasClass("activate-custom-address") && !$("#custom-address").is(":visible")) {
                const skipFields = ['form_address', 'form_country', 'form_postal_code', 'form_billing', 'form_city', 'form_apartment'];
                if (skipFields.includes(inputField.id)) {
                    isValid = true;
                }
            }

            if (!isValid) {
                inputField.classList.add('invalid');


            } else {
                inputField.classList.remove('invalid');
            }
            if (jQuery("#dob_month").val() == '') {
                isValid = false;
                jQuery('#dob_month').addClass('invalid');
            } else {
                jQuery('#dob_month').removeClass('invalid');
            }
            if (jQuery("#dob_day").val() == '') {
                isValid = false;
                jQuery('#dob_day').addClass('invalid');
            } else {
                jQuery('#dob_day').removeClass('invalid');
            }
            if (jQuery("#dob_year").val() == '') {
                isValid = false;
                jQuery('#dob_year').addClass('invalid');
            } else {
                jQuery('#dob_year').removeClass('invalid');
            }

            var selectedProducts = jQuery("input[name='interested_products[]']:checked");
            if (selectedProducts.length === 0) {
                isValid = false;
                jQuery('#productBox').addClass('invalid');
            } else {
                isValid = true;
                jQuery('#productBox').removeClass('invalid');
            }

            return isValid;
        }

        jQuery('#form_name1 , #form_last-name , #dob_month, #dob_day, #dob_year').on('blur', function() {
            const value = $(this).val();
            if (value === '') {
                $(this).removeClass('valid').addClass('invalid');

            } else {
                $(this).removeClass('invalid').addClass('valid');
            }
        });

        jQuery('#mailing-address, #form_address, #form_country, #form_postal_code, #form_billing, #form_city').on('blur', function() {
            const value = $(this).val();
            if (value === '') {
                $(this).removeClass('valid').addClass('invalid');

            } else {
                $(this).removeClass('invalid').addClass('valid');
            }
        });



        function validatePhoneNumber() {
            const inputVal = $('#form_phone_number').val().replace(/\D/g, ''); // Remove non-digit characters
            if (inputVal.length === 10) {
                isValid = true;
                $('#form_phone_number').removeClass('invalid').addClass('valid');
            } else {
                isValid = false;
                $('#form_phone_number').removeClass('valid').addClass('invalid');
            }
        }

        $('#form_email').on('blur', function() {
            const email = $(this).val();
            if (isValidEmail(email)) {
                $(this).removeClass('invalid').addClass('valid');
            } else {
                $(this).removeClass('valid').addClass('invalid');
            }
        });
        // Attach blur event listener for phone number field

        $('#form_phone_number').on('blur', validatePhoneNumber);
        $("input[name='interested_products[]']").on('change', function() {
            const selectedProducts = $("input[name='interested_products[]']:checked");
            if (selectedProducts.length === 0) {
                $('#productBox').addClass('invalid');
            } else {
                $('#productBox').removeClass('invalid');
            }
        });

        // Function to validate all fields on form submission
        //   jQuery('form#registration-form').submit(function(event) {
        jQuery('#register-btn').on('click', function(event) {
         //   alert('click')
            event.preventDefault();
            isValid = true;

            validateField('#form_email', isValidEmail);
            //   validateField('#form_phone_number', isValidPhoneNumber);

            const inputVal = $('#form_phone_number').val().replace(/\D/g, ''); // Remove non-digit characters
            if (inputVal.length === 10) {
                isValid = true;
                $('#form_phone_number').removeClass('invalid').addClass('valid');
            } else {
                isValid = false;
                $('#form_phone_number').removeClass('valid').addClass('invalid');
            }

            // ... Other fields validation ...

            validateField('#form_name1', function(value) {
                return value !== '';
            });
            validateField('#form_last-name', function(value) {
                return value !== '';
            });

            // ... Validate other fields ...

            validateField('#dob_month', function(value) {
                return value !== '';
            });
            validateField('#dob_day', function(value) {
                return value !== '';
            });
            validateField('#dob_year', function(value) {
                return value !== '';
            });

            if (!$("#addManual").hasClass("activate-custom-address") && !$("#custom-address").is(":visible")) {
                validateField('#mailing-address', function(value) {
                    return value !== '';
                });
            } else {

                validateField('#form_address', function(value) {
                    return value !== '';
                });
                validateField('#form_country', function(value) {
                    return value !== '';
                });
                validateField('#form_postal_code', function(value) {
                    return value !== '';
                });
                validateField('#form_city', function(value) {
                    return value !== '';
                });
                validateField('#form_billing', function(value) {
                    return value !== '';
                });




            }


            const selectedProducts = $("input[name='interested_products[]']:checked");
            if (selectedProducts.length === 0) {
                isValid = false;
                $('#productBox').addClass('invalid');
            } else {
                $('#productBox').removeClass('invalid');
            }

            if (isValid) {
                // Form submission logic
                console.log('Form submitted successfully.');

                var elementT = document.getElementById("registration-form");
                var formdata = new FormData(elementT);
                formdata.set('action', 'register_user_sports');

                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(response) {
                        responseData3D(response);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                // loader shoewed
                jQuery(this).addClass("loading");

                // You can submit the form using AJAX or perform other actions here
            }else{
                console.log('validation')
                jQuery('#registration-form').get(0).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                    inline: 'nearest'
                });
            }
        });

        // Attach blur event listeners to all input fields
        /*
        const inputFields = form.querySelectorAll('.form-control');
        inputFields.forEach(inputField => {
            inputField.addEventListener('blur', function() {
                validateField(this);
            });
        });
        */

        // Attach form submission event listener
        // form.addEventListener('submit', validateForm);
    });
</script>

<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBbxE-oS52upTGTzOq2r1aCnG9QkqafsVI&#038;libraries=places&#038;ver=6.0.2' id='wfacp_google_js-js'></script>
<script>
    /*
    const phoneInput = document.getElementById('form_phone_number');

    phoneInput.addEventListener('input', function(event) {
        const inputValue = event.target.value.replace(/\D/g, '');
        const formattedValue = formatPhoneNumber(inputValue);
        event.target.value = formattedValue;
        // Restrict input length to the length of the formatted phone number
        if (inputValue.length > 10) {
            event.target.value = formattedValue;
        }
    });

    function formatPhoneNumber(phoneNumber) {
        const match = phoneNumber.match(/^(\d{3})(\d{0,3})(\d{0,4})$/);
        if (match) {
            return `(${match[1]}) ${match[2]}-${match[3]}`;
        }
        return phoneNumber;
    }
*/


    function responseData3D(response) {
        $("#register-btn").removeClass("loading");
        if (response.statusCode == 404) {
            jQuery(".form-control").each(function() {
                var $this = jQuery(this);
                var isEmailField = $this.attr("type") === "email";
                jQuery(this).parent(".form-control-wrapper").find(".icon-container").removeClass("animate-loader");
                if (!isEmailField) {
                    ///$this.parents(".form-control-wrapper").removeClass("anim-wrap");
                }
            });
            /*
            var registrationForm = document.getElementById("registration-form");
            for (var i = 0; i < registrationForm.elements.length; i++) {
                var element = registrationForm.elements[i];
                if (element.type !== "email") {
                    element.value = "";
                }
            }
            jQuery('input[name="gender"][value="male"]').prop('checked', true);
            */

        } else if (response.statusCode == 200) {

            jQuery('#user_successname').html(response.first_name + ' ' + response.last_name);
            jQuery('#user_succestray').html(response.customer_tray_number);
            jQuery('#user_successmail').html(response.email_address);

            jQuery('.scan-id-avaialble').show();
            jQuery("#confirmation-email").hide();
            jQuery(".overlay").addClass("open");

            jQuery('#register-btn').prop('disabled', true);
            jQuery("body").find(".invalid").removeClass("invalid");
            jQuery(".form-control").each(function() {
                jQuery(this).parent(".form-control-wrapper").find(".icon-container").removeClass("animate-loader");
                jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap");
            });
            if (response.dob != '') {
               // console.log(response.dob);
                document.getElementById('dob_year').value = response.dob_y;
                document.getElementById('dob_month').value = response.dob_m;
                document.getElementById('dob_day').value = response.dob_d;
            }
            if (response.gender != '') {
                var genderRadioButton = document.querySelector('input[name="gender"][value="' + response.gender + '"]');
                //console.log(genderRadioButton)
                if (genderRadioButton) {
                    genderRadioButton.checked = true;
                }
            }
            document.getElementById('form_address').value = response.billing_address_1;
            document.getElementById('form_billing').value = response.billing_state;
            document.getElementById('form_city').value = response.billing_city;
            document.getElementById('form_postal_code').value = response.billing_postcode;
            document.getElementById('form_country').value = response.billing_country;
            document.getElementById('form_phone_number').value = response.billing_phone;
            document.getElementById('form_name1').value = response.first_name;
            document.getElementById('form_last-name').value = response.last_name;
            document.getElementById('form_apartment').value = response.billing_address_2;
            // var completeAddress = response.billing_address_1 + ' ' + response.billing_address_2 + ' ' + response.billing_city + ' ' + response.billing_postcode + ' ' + response.billing_state + ' ' + response.billing_country;
            document.getElementById('mailing-address').value = response.billing_address_1;


        } else if (response.statusCode == 202) {

            jQuery('#user_successname').html(response.first_name + ' ' + response.last_name);
            jQuery('#user_succestray').html(response.customer_tray_number);
            jQuery('#user_successmail').html(response.email_address);

            jQuery('.scan-id-avaialble').show();
            jQuery("#confirmation-email").show();
            jQuery('.form-beore-register').hide();
            jQuery('.after-success-message').show();
            jQuery('.fixed-footer-container').hide();
            jQuery('#register-btn').prop('disabled', true);
            jQuery("body").find(".invalid").removeClass("invalid");
            jQuery(".form-control").each(function() {
                jQuery(this).parent(".form-control-wrapper").find(".icon-container").removeClass("animate-loader");
                jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap");
            });
            if (response.dob != '') {
                //console.log(response.dob);
                document.getElementById('dob_year').value = response.dob_y;
                document.getElementById('dob_month').value = response.dob_m;
                document.getElementById('dob_day').value = response.dob_d;
            }
            if (response.gender != '') {
                var genderRadioButton = document.querySelector('input[name="gender"][value="' + response.gender + '"]');
               // console.log(genderRadioButton)
                if (genderRadioButton) {
                    genderRadioButton.checked = true;
                }
            }
            document.getElementById('form_address').value = response.billing_address_1;
            document.getElementById('form_billing').value = response.billing_state;
            document.getElementById('form_city').value = response.billing_city;
            document.getElementById('form_postal_code').value = response.billing_postcode;
            document.getElementById('form_country').value = response.billing_country;
            document.getElementById('form_phone_number').value = response.billing_phone;
            document.getElementById('form_name1').value = response.first_name;
            document.getElementById('form_last-name').value = response.last_name;
            document.getElementById('form_apartment').value = response.billing_address_2;
            // var completeAddress = response.billing_address_1 + ' ' + response.billing_address_2 + ' ' + response.billing_city + ' ' + response.billing_postcode + ' ' + response.billing_state + ' ' + response.billing_country;
            document.getElementById('mailing-address').value = response.billing_address_1;

        } else if (response.statusCode == 201) {

            jQuery('#user_successname').html(response.first_name + ' ' + response.last_name);
            jQuery('#user_succestray').html(response.customer_tray_number);
            jQuery('.scan-id-avaialble').hide();
            jQuery('#register-btn').prop('disabled', false);
            jQuery(".form-control").each(function() {
                jQuery(this).parent(".form-control-wrapper").find(".icon-container").removeClass("animate-loader");
                jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap");
            });
            document.getElementById('form_address').value = response.billing_address_1;
            document.getElementById('form_billing').value = response.billing_state;
            document.getElementById('form_city').value = response.billing_city;
            document.getElementById('form_postal_code').value = response.billing_postcode;
            document.getElementById('form_country').value = response.billing_country;
            document.getElementById('form_phone_number').value = response.billing_phone;
            document.getElementById('form_name1').value = response.first_name;
            document.getElementById('form_last-name').value = response.last_name;
            document.getElementById('form_apartment').value = response.billing_address_2;
            document.getElementById('mailing-address').value = response.billing_address_1;
            if (response.dob != '') {
              //  console.log(response.dob);
                document.getElementById('dob_year').value = response.dob_y;
                document.getElementById('dob_month').value = response.dob_m;
                document.getElementById('dob_day').value = response.dob_d;
            }
            if (response.gender != '') {
                var genderRadioButton = document.querySelector('input[name="gender"][value="' + response.gender + '"]');
              //  console.log(genderRadioButton)
                if (genderRadioButton) {
                    genderRadioButton.checked = true;
                }
            }

        } else {

        }
    }
    jQuery(document).ready(function($) {
        /******EJaz****** */
        var typingTimer; // Timer identifier
        var typingDelay = 1000; // Delay in milliseconds (1 second)
        $('#form_email').on('input', function() {
            clearTimeout(typingTimer); // Clear the previous timer
            jQuery('.scan-id-avaialble').hide();
            jQuery("#confirmation-email").show();
            jQuery('#register-btn').prop('disabled', false);
            var email = $(this).val();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailRegex.test(email)) {
                // Set a new timer to perform AJAX request after typingDelay
                var ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery(".form-control").each(function() {
                    jQuery(this).parent(".form-control-wrapper").find(".icon-container").addClass("animate-loader");
                });

                typingTimer = setTimeout(function() {
                    // Perform AJAX request
                    $.ajax({
                        type: 'POST',
                        url: ajaxUrl,
                        dataType: "json",
                        data: {
                            action: 'check_user_exists', // WordPress AJAX action
                            user: email
                        },
                        success: function(response) {
                            // Handle the AJAX response

                            responseData3D(response);

                        }
                    });
                }, typingDelay);
            }
        });
    });
    jQuery(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', function() {
            if (jQuery('.address-container').hasClass('apofpo')) {
                // return false;
            } else {
                var options = {
                    componentRestrictions: {
                        country: "us"
                    }
                };
                var places = new google.maps.places.Autocomplete(document.getElementById('mailing-address'), options);

                google.maps.event.addListener(places, 'place_changed', function() {
                    var place = places.getPlace();
                    var address = place.formatted_address;
                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    var latlng = new google.maps.LatLng(latitude, longitude);
                    var geocoder = geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                var address = results[0].formatted_address;
                                var pin = results[0].address_components[results[0].address_components.length - 2].short_name;
                                var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                                var state = results[0].address_components[results[0].address_components.length - 3].short_name;
                                var city = results[0].address_components[results[0].address_components.length - 4].long_name;
                                if (pin == 'US') {
                                    pin = results[0].address_components[results[0].address_components.length - 1].short_name;
                                }
                               // console.log(results[0]);
                                if (state == 'US') {
                                    state = results[0].address_components[results[0].address_components.length - 4].short_name;
                                }
                                // console.log('ddd');
                                // console.log(address);
                                // document.getElementById('address-autocomp').value = address;
                                document.getElementById('form_address').value = address;
                                document.getElementById('form_billing').value = state;
                                document.getElementById('form_city').value = city;
                                document.getElementById('form_postal_code').value = pin;
                                document.getElementById('form_country').value = country;
                                jQuery('#custom-address').find('.form-control-wrapper').addClass("anim-wrap");
                                jQuery('#custom-address').find('.form-control').removeClass('invalid').addClass('valid');
                                jQuery('#addManual').click();

                            }
                        }
                    });
                });
            }
        });
    });


    jQuery(document.body).on("focus", ".form-control", function() {
        jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap");
    });
    jQuery(document.body).on("focusout", ".form-control", function() {
        // console.log(jQuery(this).val());
        var currentVal = jQuery(this).val();
        if (currentVal.length <= 0) {
            var t = jQuery(this).parents(".form-control-wrapper");
            t.removeClass("anim-wrap");
        }
    });
    jQuery(document.body).on("keyup", ".form-control", function() {
        var a = jQuery(this).parents(".form-control-wrapper");
       // console.log(jQuery(this).val());
        a.addClass("anim-wrap");
    }), jQuery(document.body).on("change", ".form-control", function() {
        var a = jQuery(this).find(".input-radio");
        a.length > 0 ? a.is(":checked").length > 0 ? jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap") : jQuery(this).parents(".form-control-wrapper").removeClass("anim-wrap") : null != jQuery(this).val() && "" != jQuery(this).val() ? "" !== jQuery(this).val() && (jQuery(this).parent().siblings(".wfacp_input_error_msg").hide(), jQuery(this).parents(".form-control-wrapper").addClass("anim-wrap")) : jQuery(this).parents(".form-control-wrapper").removeClass("anim-wrap")
    })
    jQuery('body').on('click', '.thnkayoupage_show', function() {
        jQuery('.form-beore-register').hide();
        jQuery('.after-success-message').show();
        jQuery('.fixed-footer-container').hide();
        jQuery(".overlay").removeClass("open");
        jQuery('..fixed-footer-container').hide();
        window.scrollTo(0, 0); // Scroll to the top of the page
        $(".registration-form").animate({
            scrollTop: 0
        }, "fast");
    });

    $(function() {
        $(".scan-id-avaialble a").click(function() {
            $(".overlay").addClass("open");
        });
        $(".close").click(function() {
            $(".overlay").removeClass("open");
            $("#register-btn").removeClass("loading");
        });

    });
</script>

<?php

get_footer();
