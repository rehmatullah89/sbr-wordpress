<?php
/**
 * Enqueues scripts and styles for Smile Brillaint Ajax functionality.
 *
 * @param string $hook The current admin page.
 * @return void
 */
function smile_brillaint_enqueue_ajax_scripts($hook) {
    //  if (isset($_GET['post']) && get_post_type($_GET['post']) == 'shop_order') {
    ?>
    <style>
        tr.item.composited_item {
            display: none !important;
        }
        .loader_container {
            width: 200px;
            height: 200px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: auto;
            filter: url('#goo');
            animation: rotate-move 2s ease-in-out infinite;
        }

        .loader_container .dot { 
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #000;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .loader_container .dot-3 {
            background-color: #f74d75;
            animation: dot-3-move 2s ease infinite, index 6s ease infinite;
        }

        .loader_container .dot-2 {
            background-color: #10beae;
            animation: dot-2-move 2s ease infinite, index 6s -4s ease infinite;
        }

        .loader_container .dot-1 {
            background-color: #ffe386;
            animation: dot-1-move 2s ease infinite, index 6s -2s ease infinite;
        }

        @keyframes dot-3-move {
            20% {transform: scale(1)}
            45% {transform: translateY(-18px) scale(.45)}
            60% {transform: translateY(-90px) scale(.45)}
            80% {transform: translateY(-90px) scale(.45)}
            100% {transform: translateY(0px) scale(1)}
        }

        @keyframes dot-2-move {
            20% {transform: scale(1)}
            45% {transform: translate(-16px, 12px) scale(.45)}
            60% {transform: translate(-80px, 60px) scale(.45)}
            80% {transform: translate(-80px, 60px) scale(.45)}
            100% {transform: translateY(0px) scale(1)}
        }

        @keyframes dot-1-move {
            20% {transform: scale(1)}
            45% {transform: translate(16px, 12px) scale(.45)}
            60% {transform: translate(80px, 60px) scale(.45)}
            80% {transform: translate(80px, 60px) scale(.45)}
            100% {transform: translateY(0px) scale(1)}
        }

        @keyframes rotate-move {
            55% {transform: translate(-50%, -50%) rotate(0deg)}
            80% {transform: translate(-50%, -50%) rotate(360deg)}
            100% {transform: translate(-50%, -50%) rotate(360deg)}
        }

        @keyframes index {
            0%, 100% {z-index: 3}
            33.3% {z-index: 2}
            66.6% {z-index: 1}
        }
        #smile_brillaint_loader{
            width: 100%;
            height: 100%;
            min-height: 400px;
            position: relative;
            /*            background-color: #f8f4d5;*/
        }

        /* The Modal (background) */
        #smile_brillaint_order_modal2 , #smile_brillaint_order_modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        #smile_brillaint_order_modal {
            z-index: 1; /* Sit on top */
        }

        #smile_brillaint_order_modal2 {
            z-index: 1000; /* Sit on top */
        }

        /* Modal Content/Box */
        #smile_brillaint_order_modal2 .modal-content ,    #smile_brillaint_order_modal .modal-content {
            background-color: #fefefe;
            margin: 7% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 65%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        #smile_brillaint_order_modal2 .close, #smile_brillaint_order_modal .close {
            color: #aaa;
            float: right;
            font-size: 23px;
            font-weight: bold;
            height: 25px;
            width: 25px;
            border-radius: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 14px;
            margin-bottom: 11px;
        }

        #smile_brillaint_order_modal2 .close:hover,
        #smile_brillaint_order_modal2 .close:focus,
        #smile_brillaint_order_modal .close:hover,
        #smile_brillaint_order_modal .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }

        #smile_brillaint_order_modal2 .form-row label ,   #smile_brillaint_order_modal .form-row label{     display: block;
                                                                                                            text-align: left;
                                                                                                            margin-bottom: 6px; }
        #smile_brillaint_order_modal2 #order_data p,   #smile_brillaint_order_modal #order_data p {
            margin: 0.5em 0;
        }

    </style>
    <!-- The Modal -->
    <div id="smile_brillaint_order_modal">

        <!-- Modal content -->
        <div class="modal-content">

            <span class="close">&times;</span>
            <div id="smile_brillaint_order_popup_response">
            </div>
        </div>
        <input type="hidden" id="orderListingPopupID" value="0" />
    </div>
    <div id="smile_brillaint_order_modal2">

        <!-- Modal content -->
        <div class="modal-content">

            <span class="close">&times;</span>
            <div id="smile_brillaint_order_popup_response2">
            </div>
        </div>
    </div>
    <script>
        function smile_brillaint_load_html() {
            var html = '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html += '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html += '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            return html;
            /*
             var html = '<div id="smile_brillaint_loader">';
             html += '<div class="loader_container"><div class="dot dot-1"></div><div class="dot dot-2"></div><div class="dot dot-3"></div></div>';
             html += '<svg xmlns="http://www.w3.org/2000/svg" version="1.1">';
             html += '<defs>';
             html += '<filter id="goo">';
             html += '<feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />';
             html += '<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 21 -7"/>';
             html += '</filter>';
             html += '</defs>';
             html += '</svg>';
             html += '</div>';
             return  html;
             */

        }
        function smile_brillaint_fail_status_html($msg) {
            var html = '<div class="alert alert-danger">';
            html += $msg;
            html += '</div>';
            return  html;

        }
    </script>
    <?php

    //   }
}

add_action('admin_print_scripts', 'smile_brillaint_enqueue_ajax_scripts');
