                    <style>
                        @font-face {
                        font-family: 'Magnificent Serif';
                        src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/magnificent/Magnificent-Serif.woff2') format('woff2'),
                            url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/magnificent/Magnificent-Serif.ttf') format('ttf');
                        font-weight: normal;
                        font-style: normal;
                        }
                        .Magnificent_Serif {
                        font-family: 'Magnificent Serif';
                        }
                        .horizontal-shake {
                        animation: horizontal-shaking 4s infinite;
                        }
                        .rise-shake {
                        animation: jump-shaking 5s infinite;
                        }
                        .skew-shake-x {
                        animation: skew-x-shake 4s infinite;
                        }
                        .vertical-shake {
                        animation: vertical-shaking 10s infinite;
                        }
                        .blink{
                            -webkit-animation: blink 2s infinite;
                        }

                        @keyframes horizontal-shaking {
                        0% { transform: translateX(0) }
                        25% { transform: translateX(5px) }
                        50% { transform: translateX(-5px) }
                        75% { transform: translateX(5px) }
                        100% { transform: translateX(0) }
                        }
                        @keyframes jump-shaking {
                        0% { transform: translateX(0) }
                        25% { transform: translateY(-6px) }
                        35% { transform: translateY(-6px) rotate(11deg) }
                        55% { transform: translateY(-6px) rotate(-11deg) }
                        65% { transform: translateY(-6px) rotate(11deg) }
                        75% { transform: translateY(-6px) rotate(-11deg) }
                        100% { transform: translateY(0) rotate(0) }
                        }
                        @keyframes skew-x-shake {
                        0% { transform: skewX(-5deg); }
                        5% { transform: skewX(5deg); }
                        10% { transform: skewX(-5deg); }
                        15% { transform: skewX(5deg); }
                        20% { transform: skewX(0deg); }
                        100% { transform: skewX(0deg); }  
                        }
                        @keyframes vertical-shaking {
                        0% { transform: translateY(0) }
                        25% { transform: translateY(15px) }
                        50% { transform: translateY(-15px) }
                        75% { transform: translateY(15px) }
                        100% { transform: translateY(0) }
                        }
                        /* @keyframes blink{
                        0%{opacity: 0;}
                        50%{opacity: 0.25;}
                        75%{opacity: 0.5;}
                        100%{opacity: 1;}
                        } */
                        @-webkit-keyframes blink {
                        0%, 100% {
                            transform: scale(1, .05);
                        }
                        5%,
                        95% {
                            transform: scale(1, 1);
                        }
                        }
                        section#sale-hallowen-mobile {
                        display: none;
                        }

                        #sale-hallowen-wrapper {
                            background:  #8989ab;
                        }
                        .hallowen-sale-content {
                        max-width: 1240px;
                        margin: 0px auto;
                    }
                    .footer-background {
                        background:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Ground.png');
                        width: 100%;
                        height: 170px;
                        margin-top:-100px;
                        position: relative;
                        background-repeat: no-repeat;
                        background-size: cover;
                    }
                    .footer-content p{
                        color:#fff;
                    }
                    .footer-content {
                        max-width: 400px;
                        position: absolute;
                        top: 60px;
                        text-align: center;
                        margin: 60px auto 0px auto;
                        left: 50%;
                        transform: translate(-50%, -60px);
                    }
                    .cat-right-one {
                        position: absolute;
                        top: 45%;
                        left: 27%;
                    }
                    .cat-right-two {
                        position: absolute;
                        right: 22%;
                        top: 24%;
                    }
                    .hallowen-sale-content-wrapper {
                        display:flex;
                        align-items:center;
                    }
                    .sale-hallowen-text {
                        position: relative;
                        text-align:center;
                        left: -45px;
                        top: -10px;
                    }
                    .sale-hallowen-text .text-detail h4{
                        font-size:42px;
                        font-weight:600;
                        color:#fff                
                    }
                    .sale-hallowen-text .text-detail  h1.Magnificent_Serif {
                    font-size: 92px;
                    color: #000;
                    margin-top:0px;
                    font-weight: 500;
                    }
                     .Pumpkin-image {
                        position: relative;
                        left: -90px;
                        top: 40px;
                    }
                    .cat-sitting {
                    left: -30px;
                    position: relative;
                    top: 80px;
                    }
                    .noun-hallowen-tree {
                    position: relative;
                    left: 40px;
                    }
                    section#sale-hallowen-wrapper {
                        margin-top: 15px;
                }
                    @media only screen and (max-width:1440px){
                        .cat-right-two {
                        right: 10%;
                    }
                    .cat-right-one {
                        left: 20%;
                    }
                    }
                    @media only screen and (max-width:1399px){
                        .footer-background {
                            margin-top:-88px;
                        }
                        .cat-sitting {
                        top: 110px;
                    }
                  
                    }
                    @media screen and (min-width:768px) and (max-width:1023px){
                        .sale-hallowen-text {
                        top: 33px;
                    }
                    .footer-background {
                    margin-top: 20px;
                }
                    .horizontal-shake {
                    position: relative;
                    top: 20px;
                }
                #sale-hallowen-wrapper {
                    margin-top: 30px;
                    background: #8989ab;
                }
                    .Pumpkin-image {
                        left: -90px;
                        top: 100px;
                    }
                    .noun-hallowen-tree {
                        left: -20px;
                        top: 100px;
                    }
                    .cat-sitting {
                        top: 130px;
                    }
                    .cat-right-two {
                        right: -3%;
                    }
                    .cat-right-one {
                        left: 10%;
                    }
                    }
                    @media screen and (min-width:1024px) and (max-width:1180px){
                        .Pumpkin-image {
                        left: -90px;
                        top: 120px;
                    }
                    #sale-hallowen-wrapper {
                    margin-top: 30px;
                    background: #8989ab;
                }
                .footer-background {
                    margin-top: 20px;
                }
                    .cat-sitting {
                    top: 180px;
                   }
                   .noun-hallowen-tree {
                    left: -30px;
                    top: 100px;
                }
                    }
                    @media only screen and (max-width:767px){
                        section#sale-hallowen-mobile {
                        display: block;
                        margin-top:45px;
                        }
                        #sale-hallowen-wrapper{
                            display:none;
                        }
                        #sale-hallowen-mobile {
                            background:#8989ab;
                            position: relative;
                        }
                        .sale-hallowen-text{
                            z-index: 10;
                            padding-top:40px;
                            left:0px;
                            top:0px;
                        }
                        .sale-hallowen-text .text-detail h1.Magnificent_Serif {
                        font-size: 64px;
                       }
                       .sale-hallowen-text .text-detail h4 {
                        font-size: 28px;
                        margin-bottom:10px;
                        }
                        .sale-hallowen-text .text-detail p {
                            color:#fff;
                            padding:0px 80px;
                            margin-top:15px;
                        }
                        .mobile-footer-hallowen-sale {
                        position: absolute;
                        bottom: -20px;
                        z-index: 12;
                        }
                        .hallowen-sale-mobile-images .left-images {
                        position: relative;
                        width: 130px;
                        left: 20px;
                        top: -38px;
                         }
                        .hallowen-sale-mobile-images {
                        display: flex;
                        align-items: end;
                        justify-content: start;
                       }
                       .hallowen-sale-mobile-images .right-images {
                        position: relative;
                        width: 140px;
                        left: 70px;
                        top: -15px;
                       }
                       .bat-large {
                        position: absolute;
                        top: 30px;
                        right: 20px;
                        width: 85px;
                       }
                       .bat-small {
                        position: absolute;
                        top: 29%;
                        left: 15px;
                        width: 50px;
                       }
                       .group-of-bets {
                        position: absolute;
                        top: 40%;
                        width: 75px;
                        left: 11px;
                       }
                       .yellow-bg {
                        position: absolute;
                        top: 0;
                        width: 190px;
                        z-index: -1;
                       }
                       .mobile-witch-logo {
                        position: absolute;
                        top: 40px;
                        left: 25px;
                        z-index: -1;
                        width: 90px;
                       }
                       .header-spacer {
                            height: 0px!important;
                        }
                       }

                       @media screen and (max-width:375px){
                        .mobile-witch-logo {
                        position: absolute;
                        top: 40px;
                        left: 8px;
                        z-index: -1;
                        width: 90px;
                       }
                       }

                       @media screen and (min-width:376px) and (max-width:414px){
                        .mobile-witch-logo {
                        position: absolute;
                        top: 40px;
                        left: 25px;
                        z-index: -1;
                        width: 90px;
                       }
                       }
                    </style>

                    <section id="sale-hallowen-wrapper">
                        <div class="hallowen-sale-content">
                            <div class="hallowen-sale-content-wrapper">
                                <div class="moon-image arrow-person-img horizontal-shake">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Witch-sale.png)" alt="" srcset="">
                                </div>

                                <div class="Pumpkin-image skew-shake-x">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Pumpkin.png)" alt="" srcset="">

                                </div>

                                <div class="sale-hallowen-text">
                                     <div class="text-detail">
                                         <h4>Got a sweet</h4>
                                         <h1 class="Magnificent_Serif">TOOTH?</h1>
                                    </div>
                                </div>

                                <div class="cat-sitting vertical-shake">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat_sitting.png)" alt="" srcset="">

                                </div>
                                <div class="noun-hallowen-tree vertical-shake">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/noun-halloween-tree.png)" alt="" srcset="">

                                </div>
                            </div>
                        </div>
                        <div class="footer-background">
                             <div class="hallowen-sale-content">
                                 <div class="footer-content">
                                      <p>Snack with comfort knowing  Smile Brilliant cariPRO™ products will defend your teeth this Halloween!</p>  
                                 </div>

                                 <div class="cat-images ">
                                     <div class="cat-right-one">
                                         <img class="blink "src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-right-one.png)" alt="" srcset="">
                                     </div>

                                     <div class="cat-right-two blink">
                                         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat-eye-right-two.png)" alt="" srcset="">
                                    </div>
                                </div>
                            </div>
                         </div>
                    </section>

                    <!--mobile version-->

                    <section id="sale-hallowen-mobile">
                        <div class="sale-hallowen-content-mobile">
                            <div class="sale-hallowen-content">
                                <div class="sale-hallowen-text">
                                     <div class="text-detail">
                                         <h4>Got a sweet</h4>
                                         <h1 class="Magnificent_Serif">TOOTH?</h1>
                                         <p>Snack with comfort knowing  Smile Brilliant cariPRO™ products will defend your teeth this Halloween!</p>

                                         <div class="bat-images">
                                            <div class="bat-large">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Bat Large.png)" alt="" srcset="">

                                            </div>
                                            <div class="bat-small">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Bat small.png)" alt="" srcset="">
                                            </div>
                                            <div class="group-of-bets">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/group of bats.png)" alt="" srcset="">

                                            </div>
                                            <div class="mobile-witch-logo horizontal-shake">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Witch-mobile.png)" alt="" srcset="">

                                            </div>
                                            <div class="yellow-bg">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Layer 6.png)" alt="" srcset="">

                                            </div>
                                         </div>
                                    </div>

                                    <div class="hallowen-sale-mobile-images">
                                        <div class="left-images skew-shake-x">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Pumpkin_mobile.png)" alt="" srcset="">
                                        </div>
                                        <div class="right-images vertical-shake">
                                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/cat_sitting_mobile.png)" alt="" srcset="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mobile-footer-hallowen-sale">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sales/2022/halloween-day/Cat_Eyes.png)" alt="" srcset="">
                            <img src="" alt="" srcset="">
                        </div>
                    </section>