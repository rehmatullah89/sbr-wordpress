<?php
// echo $dentistmessage;
// die();
$footer = ot_get_option('footer', 'on');
$subfooter = ot_get_option('subfooter', 'on');
$footer_portfolio = is_singular('portfolio') ? ot_get_option('footer_portfolio', 'off') : 'on';
$footer_article = is_singular('post') ? ot_get_option('footer_article', 'on') : 'on';
$disable_footer = get_post_meta(get_the_ID(), 'disable_footer', true);
$cond = ('on' === $footer && 'on' === $footer_portfolio && 'on' === $footer_article && 'on' !== $disable_footer);
$billing_val_def = isset($_COOKIE['billing_email']) ? $_COOKIE['billing_email'] : '';
global $dentist_id;
global $dentistmessage;

if (is_product()) {
    wc_print_notices();
}
if ($cond) {
    do_action('thb_footer_bar');
}

?>
</div> <!-- End Main -->





<div class="mobile-overlay">
        <div class="my-faq-section tab" id="my_faq_info">       
            <h2 class="section-headings">
                <div class="rowDiv">
                    <div class="col-left">
                        FAQ
                    </div>
                    <a href="javascript:;" class="closefaqPop">
                        ×
                    </a>
                </div>
            </h2>
          <section class="faqs-content-container"></section>
     </div>
   </div>



   <script>
    
    //you can now use $ as your jQuery object.

    //jQuery(document).find(".faq-question-text").click(function() {
        jQuery(document).on('click','.faq-question-text',function(){           
            $(this).parent().addClass('active').find('.faq-answer-text').slideToggle(500);
            $(".faq-question-text").not(this).parent().removeClass('active').find('.faq-answer-text').slideUp(500);
    });
   
    function renderFaqsCategoryBaset(faqs) {
        const groupedData = faqs.reduce((acc, obj) => {
  const key = obj.category;
  if (!acc[key]) {
    acc[key] = [];
  }
  acc[key].push(obj);
  return acc;
}, {});
Object.keys(groupedData).forEach((key) => {
    categoryEky='.'+key;
  jQuery('.faqs-content-container').append('<h4 class="category-title">'+key+'</h4><div class="'+key+'"></div>');
  categoryData = groupedData[key];
  childcounter=
  categoryData.forEach((obj)=>{
   
    appended_html = '<div class="faq-question-section" id="faqSection'+obj._id+'"><a href="javascript:;" id="question'+obj._id+'" class="faq-question-text">'+obj.question+'</a><div id="faqAnswer'+obj._id+'" class="faq-answer-text" style="display: none;">'+obj.answer+'</div></div>';
    jQuery(document).find(categoryEky).append(appended_html);
  });
});

    }
    jQuery(document).ready(function() {
            jQuery.ajax({
                method: 'GET',
                url: CHAT_SBR_URL+'/faqs',
                success: function(faqs) {
                   renderFaqsCategoryBaset(faqs);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });


    // for RDH Faq desktop
    $('#pills-my-faq').on('click', function() {

        $('html').addClass('modal-open');
        $(this).addClass('activeButton');        
        $(".my-faq-section.tab").addClass('active');

    });
    
    $('.closefaqPop').on('click', function() {
        $('html').removeClass('modal-open');
        $(".my-faq-section.tab").removeClass('active');
    });


    (function () {
     // Check if the device is a mobile
        // var isMobile = $(window).width() < 768;
        // if (isMobile) {
        //     setTimeout(function() { 
        //         $('.sidebarOption ul li').on('click', function() {
        //             var mobileNav = $('.jumbotron.messageBodyChar');
        //             mobileNav.addClass('openNavigationOverlay');                    
        //             var offsetTop = mobileNav.offset().top-80;                    
        //             $('html, body').animate({
        //                 scrollTop: offsetTop
        //             }, 'slow');
        //             });


        //         $('.backToChatList').on('click', function() {
        //             jQuery('.openNavigationOverlay').removeClass('openNavigationOverlay');
        //         });

        //     }, 2000);
        // }
    })();



</script>

<div class="wrapperChatBoxMbt notificationBoxCenter" >
    <div class="wrapperChatBoxMbtInner">
        <div class="chatBoxHeader">
            <span class="displayName">Notification</span>
            <div class="headerButtons">
                <a href="javascript:;" class="icons minimizeWindow">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </a>
                <a href="javascript:;" class="icons maximizeWindow">
                    <i class="fa fa-window-maximize" aria-hidden="true"></i>
                </a>
                <a href="javascript:;" class="icons closeBox">
                     <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="notificationBoxBody">
            <ul>
                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>
               
                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>

                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>
                
                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>
                
                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>
                
                <li>
                    <div class="flex-row-otifi">
                        <div class="postWrapperNotification">
                             <span class="posttime">1 minutes ago</span>
                             <p>Covid-19, wawancara kerja virtual menjadi pilihan utama untuk banyak perusahaan.</p>
                        </div>                        
                    </div>
                </li>                
            </ul>
        </div>
    
    </div>
</div>


    <div class="messageCopyToClickBoard">
        <div class="messageCopyToClickBoardInner">
            <div class="displayCopyMessage">URL copied</div>
        </div>
    </div>

<div class="fixed-footer-container RDHProfileFooter">
    <?php
    if ($cond) {
        // get_template_part('inc/templates/footer/footer-rdh-profile');
    }
    ?>
    <?php
    if ('on' === $subfooter && 'on' === $footer_portfolio && 'on' === $footer_article && 'on' !== $disable_footer) {
        // get_template_part('inc/templates/footer/subfooter-' . ot_get_option('subfooter_style', 'style1'));
    }
    //$user_id = '';
    if (get_query_var('dentist_name') != false && get_query_var('dentist_name') != '') {
        if (function_exists('bp_version')) {
            $user_id = bp_core_get_userid(get_query_var('dentist_name'));
        }
    }
    ?>

    <!-- rdh sub footer starts -->

    <div class="rdh-sub-footer">
        <div class="rdh-footer-content row">
            <div class="rdhsub-footer-logo">
                 <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rdh-profile/rdh-footer/logo-dentisht.png" alt="" srcset=""> 
            </div>
            <aside class="socials">
                <ul>
                    <li> <a target="_blank" href="https://www.facebook.com/smileBrilliant"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
                    <!-- <li> <a href="http://www.twitter.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li> -->
                    <li> <a target="_blank" href="https://www.instagram.com/smilebrilliant/"><i class="fa fa-instagram" aria-hidden="true"></i></a> </li>
                    <li> <a target="_blank" href="https://twitter.com/SBwhitening"> <i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                    <li> <a target="_blank" href="https://www.youtube.com/smilebrilliant"><i
                                class="fa fa-youtube" aria-hidden="true"></i></a> </li>

                    <!-- <li> <a href="http://www.youtube.com/"><i class="fa fa-youtube" aria-hidden="true"></i></a> </li>
                <li> <a href="http://www.tiktok.com/"><img src="/assets/images/tiktok.svg" alt="" srcset=""></a> </li>
                <li class="blog-icon-footer-rdh"> <a href=""><i class="fa fa-link" aria-hidden="true"></i></a> </li> -->
                </ul>

            </aside>
        </div>
    </div>



</div>
<!-- Start Mobile Menu -->
<?php do_action('thb_mobile_menu'); ?>
<!-- End Mobile Menu -->

<!-- Start Side Cart -->
<?php do_action('thb_side_cart'); ?>
<!-- End Side Cart -->

<!-- Start Featured Portfolio -->
<?php do_action('thb_featured_portfolio'); ?>
<!-- End Featured Portfolio -->

<!-- Start Shop Filters -->
<?php do_action('thb_shop_filters'); ?>
<!-- End Shop Filters -->



<div class="modal-dentist" id="modal-dentist">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <h2>Hello, I am modal 1!</h2>
    <p>Click the top-right button to close me, or click outside the modal.</p>
    <div class="ajax-share-res"></div>
  </div>
 
</div>

<div class="modal-dentist" id="modal-dentist1">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <h2>Hello, I am modal 2!</h2>
    <p>Click the top-right button to close me, or click outside the modal.</p>
  </div>
</div>

<div class="modal-dentist" id="modal-dentist2">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <p>Are you sure you want to logout.</p>
    <div class="buttons-popup-container">
    <a class="yes-btn bypass">Yes</a>
    <a class="close-button-dentist noBypass">No</a>
    </div>
  </div>
</div>


<div class="modal-dentist" id="modal-dentist4">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <p>URL successfully copied to clipboard.</p>
    <div class="buttons-popup-container">
        <a class="close-button-dentist noBypass">OK</a>
    </div>
  </div>
</div>


<div class="modal-dentist" id="modal-dentist5">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <p>Please select at least one product for recommendation.</p>
    <div class="buttons-popup-container">
        <a class="close-button-dentist noBypass">OK</a>
    </div>
  </div>
</div>
<?php
$show_modlcls = '';
if ($dentistmessage!='') {
    //$show_modlcls = 'show-modal';
}?>
<div class="modal-dentist <?php echo $show_modlcls;?>" id="modal-dentist6">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <h4>Message from your dentist</h4>
    <p><?php
        if ($dentistmessage!='') {
            $dentist_message = str_replace("\'", "'", $dentistmessage);
            $dentist_message = str_replace('\"', '"', $dentist_message);
           // $dentist_message = nl2br($dentist_message);
          //  echo htmlspecialchars($dentist_message);
            echo html_entity_decode($dentist_message);
        } else if (isset($_COOKIE['message_from_dentist'])) {
            
            $message_from_dentist = str_replace("\'", "'", $_COOKIE['message_from_dentist']);
            $message_from_dentist = str_replace('\"', '"', $message_from_dentist);
          //  $message_from_dentist = nl2br($message_from_dentist);
          echo html_entity_decode($message_from_dentist);
        } else {
            echo "No message from the dentist.";
        }
        ?></p>
    <div class="buttons-popup-container">
        <a class="close-button-dentist noBypass">OK</a>
    </div>
  </div>
</div>


<div class="modal-dentist" id="modal-dentist8">
  <div class="modal-content-dentist">
    <span class="close-button-dentist">×</span>
    <p>The URL has been copied to your clipboard.</p>
    <div class="buttons-popup-container">
        <a class="close-button-dentist noBypass">OK</a>
    </div>
  </div>
</div>



    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


<script>


// mobile number as per usa format

// document.addEventListener('DOMContentLoaded', () => {
//   const phoneInput = document.getElementById('phone-input');

//   phoneInput.addEventListener('input', (e) => {
//     let input = e.target.value;
    
//     // Remove all non-digit characters
//     input = input.replace(/\D/g, '');

//     // Limit the input to a maximum of 10 digits
//     input = input.substring(0, 10);

//     // Format input based on the length
//     if (input.length === 0) {
//       input = '';
//     } else if (input.length <= 3) {
//       input = `(${input}`;
//     } else if (input.length <= 6) {
//       input = `(${input.slice(0, 3)}) ${input.slice(3)}`;
//     } else {
//       input = `(${input.slice(0, 3)}) ${input.slice(3, 6)}-${input.slice(6)}`;
//     }

//     // Set the formatted value
//     e.target.value = input;
//   });

//   phoneInput.addEventListener('keydown', (e) => {
//     const input = e.target.value;
//     if (e.key === 'Backspace' && (input.endsWith(' ') || input.endsWith('(') || input.endsWith(')') || input.endsWith('-'))) {
//       e.target.value = input.slice(0, -1);
//     }
//   });
// });

// Ends mobile number as per usa format


$(document).ready(function() {
  $(".trigger").click(function() {
    var target = $(this).data("target");
    $("#" + target).toggleClass("show-modal");
  });

  $(".close-button-dentist").click(function() {
    $(this).closest(".modal-dentist").removeClass("show-modal");
  });

  $(window).click(function(event) {
    if ($(event.target).hasClass("modal-dentist")) {
      $(event.target).removeClass("show-modal");
    }
  });
});

    
</script>    

<script>


function generateQRCode() {
  let website = $("#website").val();
  if (website) {
    let qrcodeContainer = $("#qrcode");
    qrcodeContainer.empty();
    new QRCode(qrcodeContainer[0], website);

    $("#qr-code-popup").addClass('is-visible');
  } else {
    alert("Please enter a valid URL");
  }
}


</script>


        <script>
            // jQuery('body').on('click', '.modal-toggle', function(e) {
            //     e.preventDefault();
            //     jQuery('.modal').toggleClass('is-visible');
            // });

            // jQuery('.modal-close').on('click', function (e) {
            //     e.preventDefault();
            //     jQuery('.modal').removeClass('is-visible');
            // });

        </script>

<script>


document.addEventListener('DOMContentLoaded', function() {
    // Select the button
    var copyButton = document.querySelector('.clipboard');
    
    // Add click event listener to the button
    copyButton.addEventListener('click', function() {
        // Select the input field
        var inputField = document.getElementById('website');
        
        // Copy the URL
        inputField.select();
        document.execCommand('copy');
        
        // Deselect the input field
        window.getSelection().removeAllRanges();
        
        jQuery("#modal-dentist4").addClass('show-modal'); 
        // Notify user
        // alert('URL copied to clipboard!');
    });
});

$(document).ready(function() {



    
  setTimeout(function() {
         $("body").on("find", ".selected-for-share", function () {
            $("body").addClass("add-class-by-js");
            // $(".dentish-share-button-js").hide();
             var recommendedDiv = $('<div class="requmended-by-dentist ribbon-top-right"><span>Recommended  <div class="by-dentist-tag">for You</div> </span></div>');
             $(".paients-access-code-li").hide();
             
            $(this).find('.product-selection-box').append(recommendedDiv);
        }); 
       $(".selected-for-share").trigger("find");
    }, 1000);


     
    });

$(document).ready(function() {

    $('.share-email').click(function() {
        // var url = $('.url-input').val();
        // var notes = $('.notes-input').val();
        // var emailBody = "Check out this URL: " + url + "\n\nNotes: " + notes;
        // window.location.href = "mailto:?body=" + encodeURIComponent(emailBody);

    });


    jQuery('.share-with-icons > a').click(function() {
        jQuery(".share-box-wrapper-dentist").addClass('is-visible-box');         
    });

    jQuery('.open-email-box').click(function() {
        jQuery(".telephone-sharebox-dentist").removeClass('is-visible-box'); 
        jQuery(".email-sharebox-dentist").addClass('is-visible-box');                     
        $("#editableText").text("Type email");
    });



    jQuery('.modal-close-section').click(function() {
        jQuery(".share-box-wrapper-dentist ").removeClass('is-visible-box'); 
    });


    jQuery('.open-mobile-number-box').click(function() {
        jQuery(".email-sharebox-dentist").removeClass('is-visible-box');    
        jQuery(".telephone-sharebox-dentist").addClass('is-visible-box'); 
        $("#editableText").text("Type phone number");
    });



    

    $('.share-message').click(function() {
    //     var url = $('.url-input').val();
    //     var notes = $('.notes-input').val();
    //     var messageBody = "Check out this URL: " + url + "\n\nNotes: " + notes;
    //     window.location.href = "sms:?body=" + encodeURIComponent(messageBody);

    //     var url = $('.url-input').val();
    // var notes = $('.notes-input').val();
    // var messageBody = "Check out this URL: " + url + "\n\nNotes: " + notes;
    // var currentBody = encodeURIComponent(messageBody);
    
    // // Check if the URL starts with 'sms:'
    // window.open("sms://?&body="+currentBody);

    });
    
});

function appendQueryParam(url, key, value) {
        var updatedURL = url;
        var queryString = key + '=' + encodeURIComponent(value);
        if (url.indexOf('?') !== -1) {
            updatedURL += '&' + queryString;
        } else {
            updatedURL += '?' + queryString;
        }
        return updatedURL;
    }
    jQuery('.message-popup-open').on('click', function (e) {
  //  alert('<? $dentist_id; ?>');
    
    jQuery("#modal-dentist6").addClass('show-modal'); 
    // alert('Please select minimum one product to recommend');
   

});
// Open share modal
jQuery('.share-popup-open').on('click', function (e) {
  //  alert('<? $dentist_id; ?>');
    e.preventDefault();
    var selectedProducts = [];
        $('.selected_for_share:checked').each(function(){
            selectedProducts.push($(this).val());
        });
            //  alert(selectedProducts.length);

        // if(selectedProducts.length<1){    
        //     jQuery("#modal-dentist5").addClass('show-modal'); 
        //     // alert('Please select minimum one product to recommend');
        //     return false;
        // }


        var currentURL = window.location.href;
        var selectedProductsStr = selectedProducts.join(',');

        var updatedURL = appendQueryParam(currentURL, 'selected_products', selectedProductsStr);
         updatedURL = appendQueryParam(updatedURL, 'access_code', '<?php echo base64_encode(get_user_meta($dentist_id, 'access_code', true)); ?>');

        $('.url-input').val(updatedURL);
        noteVal = jQuery('.notes-input').val();

         existingValInputField = jQuery('.url-input').val();
         new_urll = new URL(existingValInputField);

    // Add or update the `dentist_message` query parameter
    new_urll.searchParams.set('dentist_message', noteVal);

    // Update the input field with the new URL
    jQuery('.url-input').val(new_urll.toString());
    $('.url-input').val(new_urll);
    jQuery("#modalShare").addClass('is-visible'); 
    jQuery("a.share-email.open-email-box").trigger('click'); 
  


});

// Open access code modal

// setTimeout(function() {
//     jQuery(document).find('.access-code-handler').on('click', function (e) {
//         e.preventDefault();
//         jQuery("#modal-access-code").addClass('is-visible'); 
//     });
// }, 2000); // 2000 milliseconds = 2 seconds


jQuery(document).on('click', '.access-code-handler', function (e) {
   // e.preventDefault();
    jQuery("#modal-access-code").addClass('is-visible'); 
});








jQuery('.share-qr-code-popup').on('click', function (e) {
        // e.preventDefault();
        // jQuery("#qr-code-popup").addClass('is-visible'); 
    });


// Close modals
jQuery('.modal-close').on('click', function (e) {
    e.preventDefault();
    jQuery(".modal").removeClass('is-visible'); // Remove the is-visible class from all modals
});


jQuery("body").on("click", ".modal-cross", function () {
    jQuery("#qr-code-popup").removeClass('is-visible');
});

</script>


<?php if (is_account_page()) { ?>
                                                                        <div class="modal fade viewLogModalpopup" id="viewLogModalpopup" tabindex="-1" aria-labelledby="" aria-hidden="true" style="display: none;">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title font-mont" id="viewItemLogOrdernumber">Item Status Log <div class="orderNumberTagParent"><span class="itemNoTag">ORDER NO:</span> <span class="orderNumberJs"></span></div>
                                                                                        </h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="productWrapperMbt cssScroll" id="viewItemLogOrderItemData">


                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="modal-footer hidden">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
<?php } ?>
<?php
/*
 * Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */

if (is_checkout()) {
    require_once (get_stylesheet_directory() . '/inc/one-time-pop.php');
    require_once (get_stylesheet_directory() . '/inc/retainer-cleaner-pop.php');
    if (!is_user_logged_in()) {
        ?>
                                                                                                                                                <script>
                                                                                                                                                    jQuery(document).ready(function() {
                                                                                                                                                        setTimeout(function() {
                                                                                                                                                            jQuery('#billing_email').val('<?php echo $billing_val_def; ?>');
                                                                                                                                                            jQuery('#billing_email').click();
                                                                                                                                                            jQuery('#billing_email').focus();
                                                                                                                                                        }, 1000);

                                                                                                                                                    });
                                                                                                                                                    jQuery(document).ready(function() {

                                                                                                                                                        jQuery('#shipping_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');

                                                                                                                                                    });
                                                                                                                                                </script>
                                                                                                                                                <script>
                                                                                                                                                    jQuery(document).ready(function() {

                                                                                                                                                        jQuery('#billing_country').val('<?php echo ip_info_mbt('Visitor', 'countrycode'); ?>');
                                                                                                                                                    });
                                                                                                                                                </script>
                                                                                                                                            <?php
    }
    if (is_user_logged_in()) {
        ?>
                                                                                                                                                <script>
                                                                                                                                                    jQuery(document).on('change', 'input[name="wc-authorize-net-cim-credit-card-payment-token"]', function() {
                                                                                                                                                        if (jQuery('input[name="wc-authorize-net-cim-credit-card-payment-token"]:checked').attr('data-hsa_fsa') == 'true') {
                                                                                                                                                            $('#payment_method_hsa_hfa').prop('checked', true);
                                                                                                                                                        } else {
                                                                                                                                                            $('#payment_method_hsa_hfa').prop('checked', false);
                                                                                                                                                        }
                                                                                                                                                        if (jQuery('input[name="wc-authorize-net-cim-credit-card-payment-token"]:checked').val() == '') {
                                                                                                                                                            $('.paymentMethodNfa').show();
                                                                                                                                                        } else {
                                                                                                                                                            $('.paymentMethodNfa').hide();
                                                                                                                                                        }

                                                                                                                                                    });
                                                                                                                                                    jQuery(document).ready(function() {
                                                                                                                                                        selectObject = document.getElementsByName('shipping_address_id');
                                                                                                                                                        str_val_act = $(selectObject).children('option:selected').val();
                                                                                                                                                        if (str_val_act != 'emp') {
                                                                                                                                                            jQuery('.step_1 input, .step_1 select').each(function() {
                                                                                                                                                                val = jQuery(this).val();
                                                                                                                                                                name_str = jQuery(this).attr('name');
                                                                                                                                                                if (val == '' && name_str == 'shipping_state') {
                                                                                                                                                                    val = $('#shipping_state').children('option:selected').val();
                                                                                                                                                                }

                                                                                                                                                                if (name_str != 'shipping_state') {
                                                                                                                                                                    if (name_str.startsWith("shipping")) {
                                                                                                                                                                        str_val = $(selectObject).children('option:selected').data(name_str);
                                                                                                                                                                        if (str_val != '' && str_val != 'empty_val' && typeof str_val !== "undefined") {
                                                                                                                                                                            str_val = str_val.toString();
                                                                                                                                                                            result2 = str_val.replace(new RegExp("\\+", "g"), ' ');
                                                                                                                                                                            if (val != result2) {
                                                                                                                                                                                change_shipping_Address(selectObject);
                                                                                                                                                                                return false;
                                                                                                                                                                            }

                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                }
                                                                                                                                                            });
                                                                                                                                                        }
                                                                                                                                                    });
                                                                                                                                                </script>
                                                                                                                                        <?php
    }
}

wp_footer();
?>
<style>
    .order-processing-message {
        position: fixed;
        width: 100%;
        height: 100%;
        background: #00000096;
        z-index: 999999999;
        top: 0;
        display: none;
    }

    .message-processing {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        letter-spacing: 1px;
        background: #3498db;
        z-index: 99;
    }

    .loading-animate:after {
        content: ' .';
        animation: dots 1s steps(5, end) infinite;
    }

    @keyframes dots {

        0%,
        20% {
            color: rgba(0, 0, 0, 0);
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        40% {
            color: white;
            text-shadow:
                .25em 0 0 rgba(0, 0, 0, 0),
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        60% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 rgba(0, 0, 0, 0);
        }

        80%,
        100% {
            text-shadow:
                .25em 0 0 white,
                .5em 0 0 white;
        }
    }

    .container-form .row.after-success {
        display: none;
    }

    .has_error {
        border: 1px solid red !important;
    }
</style>
<script>
    jQuery('#see-full-technical-click').on('click', function(e) {
        jQuery('#content-accordion').toggleClass("visible pressed", 400); //you can list several class names 
        jQuery(this).toggleClass('active-nav');
        e.preventDefault();
    });


    jQuery(".open-specification").click(function() {
        jQuery('#content-accordion').toggleClass("visible pressed", 400); //you can list several class names 
        jQuery('#content-accordion').toggleClass('active-nav');
        jQuery('html, body').animate({
            scrollTop: jQuery("#see-full-technical-click").offset().top
        }, 800);
    });

    jQuery('.warranty-modal-popup .btn-primary').on('click', function(e) {
        jQuery(".overlay-fade").removeClass('ult-open');
        e.preventDefault();
    });

    var myFunc = function() {}
    window.onload = function() {
        setTimeout(myFunc, 3000);
        jQuery('.ufaq-faq-div .ufaq-faq-title').on('click', function() {
            jQuery('.ufaq-faq-display-style-Default.current-faq').removeClass('current-faq');
            jQuery(this).parent().addClass('current-faq');
        });
        // jQuery(".ufaq-faq-div .ufaq-faq-title").click(function(){
        //    jQuery(this).next(".ufaq-faq-body").slideToggle();
        // });


        jQuery('.ufaq-faq-div').on('click', function() {
            jQuery('.ufaq-faq-div').removeClass('current-faq-mbt');
            jQuery('.ufaq-faq-div.current-faq-mbt').removeClass('current-faq-mbt');
            jQuery(this).addClass('current-faq-mbt');
        });

        var all_links = document.querySelectorAll(".ufaq-faq-title a.ewd-ufaq-post-margin");

        for (var i = 0; i < all_links.length; i++) {
            all_links[i].removeAttribute("href");
        }


    }

    jQuery(function() {
        jQuery("#quick_cartt").on("click", function(e) {
            jQuery(this).parent().addClass("open");
            jQuery(".cart-mbt").addClass("wide");
            e.stopPropagation()
        });

    });

    jQuery(document).on('click', function(e) {
        if (jQuery(e.target).closest(".widget_shopping_cart_content").length === 0) {
            // jQuery(".widget_shopping_cart_content").hide();
            jQuery(".secondary-area-mbt").removeClass("open");
        }
    });


    // Geha page

    jQuery(".get-your-discount").click(function() {
        jQuery('html, body').animate({
            scrollTop: jQuery(".geha-registration-form").offset().top
        }, 1000);
    });
</script>


<script>
    jQuery(document).on('click', '.removesmilecart', function(e) {

        prodcutid = jQuery(this).attr('data-product_id');
        jQuery('#smile_brillaint_cart_form').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        jQuery.ajax({
            type: "post",
            async: true,
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            data: 'action=remove_composite_product_from_cart&product_id=' + prodcutid,
            success: function(response) {
                jQuery(document.body).trigger("update_checkout");
                jQuery('body').trigger('wc_fragment_refresh');
                jQuery(this).parent('.smile_brilliant-mini-cart-item').removeClass('removing');
                //   jQuery('#smile_brillaint_cart_form').unblock();
            }
        })
    });

    // jQuery(window).resize(function() {
    if (jQuery(window).width() < 767) {
        jQuery("#couponRowDescriptionCell").attr('colspan', 2);
    } else {
        jQuery("#couponRowDescriptionCell").attr('colspan', 4);
    }
    // });



    jQuery(function() {
        setTimeout(function() {
            //caches a jQuery object containing the header element
            var header = jQuery("#sbr-header");
            jQuery(window).scroll(function() {
                var scroll = jQuery(window).scrollTop();

                if (scroll >= 30) {
                    header.addClass("opaque");
                } else {
                    header.removeClass("opaque");
                }
            });
        }, 2000);
    });
    jQuery(document).on('click', '#send-my-discount', function(e) {
        e.preventDefault();
        hasserror = false;
        jQuery('#geha_discount_registration_form input').each(function() {
            if (jQuery(this).val() == '') {
                jQuery(this).addClass('has_error');
                hasserror = true;
            } else {
                jQuery(this).removeClass('has_error');
            }
        });
        if (hasserror) {
            return false;
        }
        var data_ajax = jQuery('#geha_discount_registration_form').serialize();
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: ajaxurl,
            data: data_ajax,
            success: function(response) {
                if (response.status == true) {
                    jQuery('.container-form .row.after-success #geha-coupon-code-box').text(response
                        .code);
                    jQuery('.container-form .row.after-success').show();
                    jQuery('#geha_discount_registration_form').hide();
                    try {

                        window._learnq = window._learnq || [];
                        window._learnq.push(['identify', {
                            '$email': jQuery('#entryEmail').val(),
                            '$first_name': jQuery('#entryFastName').val(),
                            '$last_name': jQuery('#entryLastName').val()
                        }]);
                        window._learnq.push(["track", "GEHA Discount", {}]);

                    } catch (err) {}

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.code,

                    })
                }
            }
        });
    });

    jQuery(document).ready(function() {
        jQuery(".page-id-426712 .ewd-ufaq-post-margin").removeAttr("href");
    });

    jQuery(".page-id-426712 .ewd-ufaq-post-margin").click(function() {
        event.preventDefault();

    });
</script>


<script type="text/javascript">
    function n__toggleTechSpecs(forceDisplay) {
        if (jQuery('#technical-specs-wrap').hasClass('visible') && forceDisplay !== true) {
            jQuery('#specs-drop-icon').removeClass('fa-angle-down').addClass('fa-angle-right');
            jQuery('#technical-specs-wrap').removeClass('visible');
        } else {
            jQuery('#specs-drop-icon').removeClass('fa-angle-right').addClass('fa-angle-down');
            jQuery('#technical-specs-wrap').addClass('visible');
        }
    }






    //   $(function() {
    //   $("#user-login-top").on("click", function(e) {
    //     $("#user-login-wrapper").toggleClass("wide");
    //   });
    //   $(document).on("click", function(e) {
    //     if ($(e.target).is("#user-login-wrapper, #user-login-top") === false) {
    //       $("#user-login-wrapper").removeClass("wide");
    //     }
    //   });
    // });


    // $(function() {                       //run when the DOM is ready
    //     $("body").find("a.btn.btn-primary.dropdown-toggle").click(function() {  //use a class, since your ID gets mangled
    //     $("#user-login-wrapper").addClass("open");      //add the class to the clicked element
    //   });
    // });

    // $(document).click(function(event) {
    //   //if you click on anything except the modal itself or the "open modal" link, close the modal
    //   if (!$(event.target).closest("#drop-down-home-nav").length) {
    //     $("body").find("#user-login-wrapper").removeClass("open");
    //   }
    // });



    // mobile navigation
    jQuery(document).ready(function() {

        jQuery('.mobile-toggle-holder.style1').click(function() {
            jQuery('html').addClass('openNavigationMenu');
        });
        jQuery('.thb-mobile-close').click(function() {
            jQuery('html').removeClass('openNavigationMenu');
        });

        jQuery('.thb-mobile-menuOne > li > a').click(function() {
            jQuery('.sub-menu').slideUp();
            if (jQuery(this).parent().find('.sub-menu').is(':hidden') == true) {
                jQuery(this).parent().find('.sub-menu').slideDown();
            }
        });


    });






    jQuery(document).ready(function() {
        jQuery(".wfacp_mb_cart_accordian").trigger('click');


        //   coupon code message on sale  
        jQuery('#checkoutCartParent .checkout_coupon .wfacp_coupon_row').append('<div class="couponerror-for-desktop"><span style="color:red;">Coupons are disabled during sale</span></div>');
        jQuery('.wfacp_woocommerce_form_coupon .wfacp-coupon-page .woocommerce-form-coupon .wfacp_coupon_row').append('<div class="couponerror-for-mobile"><span style="color:red;">Coupons are disabled during sale</span></div>');



    });
</script>
<script>
    jQuery(document).on('keyup', '#wc-authorize-net-cim-credit-card-account-number', function() {
        var new_val = jQuery(this).val();
        if (new_val.replace(/[^0-9]/g, "").length > 15) {
            jQuery('#wc-authorize-net-cim-credit-card-expiry').focus();
        }
    });
    jQuery(document).on('keyup', '#wc-authorize-net-cim-credit-card-expiry', function() {
        var new_val = jQuery(this).val();
        if (new_val.replace(/[^0-9]/g, "").length > 3) {
            jQuery('#wc-authorize-net-cim-credit-card-csc').focus();
        }
    });
</script>




</div> <!-- End Wrapper -->
<?php do_action('thb_after_wrapper'); ?>

<!--Start of Zendesk Chat Script-->
<!--<script type="text/javascript">
    window.$zopim || (function (d, s) {
        var z = $zopim = function (c) {
            z._.push(c)
        }, $ = z.s =
                d.createElement(s), e = d.getElementsByTagName(s)[0];
        z.set = function (o) {
            z.set.
                    _.push(o)
        };
        z._ = [];
        z.set._ = [];
        $.async = !0;
        $.setAttribute("charset", "utf-8");
        $.src = "https://v2.zopim.com/?1gkxxybCz6kCM2GXAe6U8xtYUaPh5yGK";
        z.t = +new Date;
        $.
                type = "text/javascript";
        e.parentNode.insertBefore($, e)
    })(document, "script");
</script>-->
<!--End of Zendesk Chat Script-->
<!-- Freind Buy customer tracking -->
<?php
$current_user = wp_get_current_user();
if (is_user_logged_in() && in_array('customer', (array) $current_user->roles)) {
    //The user has the "author" role
    ?>
                                                                        <script>
                                                                            // friendbuyAPI.push([
                                                                            //     "track",
                                                                            //     "customer",
                                                                            //     {
                                                                            //         email: "<?php //echo esc_html($current_user->user_email); ?>",
                                                                            //         id: "<?php //echo esc_html($current_user->id); ?>",
                                                                            //         name: "<?php //echo esc_html($current_user->display_name); ?>",

                                                                            //     },
                                                                            // ]);
                                                                        </script>
<?php }
?>
<?php if (isset($_GET['redirected']) && isset($_GET['sign_on'])) {
    ?>
                                                                        <script>
                                                                            setTimeout(function() {
          
                                                                                jQuery(document).ready(function() {
                                                                                    jQuery('.loading-mbt').show();
                                                                                    jQuery.ajax({
                                                                                        type: "post",
                                                                                        async: true,
                                                                                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                                                                        data: 'action=checkout_pay_for_order_auth_check',
                                                                                        success: function(response) {
                                                                                            jQuery('.loading-mbt').hide();
                                                                                            if (response.includes('no')) {
                                                                                                location.reload();
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                });
                                                                            }, 2000);
                                                                        </script>
                                                                    <?php
}
?>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script>
    jQuery(document).ready(function() {
      
        if (window.location.hash) {
            var hash = window.location.hash.substring(1);
          
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=old_affiliates_redirect_to_new_structure&hashed_val=' + hash,
                success: function(response) {
                    if (response != 'error') {
                    
                        // alert(response);
                        Cookies.set('affwp_ref', response);
                    }
                    //   jQuery('#smile_brillaint_cart_form').unblock();
                }
            });
        }
    });

    function rearrange_element_name(el_class) {
        //console.log(el_class);
        if (el_class == 'liscence') {
            var counterUpdate = 0;
            jQuery('.field_wrapper.liscence').find('.repeater_state_liscence').each(function() {
                name_dynamic = "repeater_state[liscence][" + (counterUpdate) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdate++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.liscence').find('.repeater_state_state').each(function() {
                name_dynamic = "repeater_state[state][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
        }
        if (el_class == 'education') {
            var counterUpdate = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_school').each(function() {
                name_dynamic = "repeater_degree[school][" + (counterUpdate) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdate++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_title').each(function() {
                name_dynamic = "repeater_degree[degree_title][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
            var counterUpdateSelect = 0;
            jQuery('.field_wrapper.education').find('.repeater_degree_date').each(function() {
                name_dynamic = "repeater_degree[grad_date][" + (counterUpdateSelect) + "]";
                jQuery(this).attr('name', name_dynamic);
                counterUpdateSelect++;
            });
        }
    }
    jQuery(document).on('click', '#buddypress #signup-form #submit', function() {
        jQuery("#buddypress #signup-form").validate();
    });
    var field_133 = document.getElementById('field_133');
    if (typeof(field_133) != 'undefined' && field_133 != null) {
        field_133.addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }
    jQuery("#buddypress #signup-form").validate({
        rules: {
            signup_username: {
                required: true,
                validUsername: true,
                uniqueUsername: true,
                minlength: 6,
            },
            signup_password: {
                required: true,
                //  pwcheck: true,
                minlength: 6
            },
            signup_password_confirm: {
                required: true,
                minlength: 6,
                //     pwcheck: true,
                equalTo: "#signup_password"
            },
            signup_email: {
                required: true,
                email: true,
                uniqueEmail: true,
                normalizer: function(value) {
                    return jQuery.trim(value);
                }
            },
            'contact[cellphone]': {
                required: true,
                phoneUS: true
            },
            field_1: {
                required: true,
                lettersonly: true
            },
            field_132: {
                required: true,
                lettersonly: true
            },
            'address[town_city]': {
                required: true,
                townCity: true
            },
            'social[linkedin]': {
                socialUsername: true,
            },
            'social[tiktok]': {
                socialUsername: true,
            },
            'social[youtube]': {
                socialUsername: true,
            },
            'social[instagram]': {
                socialUsername: true,
            },
            'social[twitter]': {
                socialUsername: true,
            },
            'social[facebook]': {
                socialUsername: true,
            },
            'social[blog]': {
                url: true
            },
        },
        messages: {
            field_1: {
                required: "Please enter your first name",
            },

            field_132: {
                required: "Please enter your last name",
            },
            signup_username: {
                required: "Please enter a username",
                uniqueUsername: "Username already in use",
                validUsername: "This username is not valid",
                minlength: "Your username must consist of at least 6 characters"
            },
            signup_password: {
                required: "Please provide a password",
                pwcheck: "Password must contain at least one capital letter, one numerical and one special character",
                minlength: "Your password must be at least 6 characters long"
            },
            signup_email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address",
                uniqueEmail: "This Email address is already registered in our system.",
            },
            signup_password_confirm: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above",
                pwcheck: "Password must contain at least one capital letter, one numerical and one special character",
            },
            ///  signup_email: "Please enter a valid email address",
        },
        onfocusout: function(element) {
            //To remove the 'checked' class on the error wrapper
            var $errorContainer = jQuery(element).siblings(".Ntooltip").find("label");
            $errorContainer.removeClass("checked");
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        errorPlacement: function(error, element) {
            var container = jQuery('<div />');
            container.addClass('Ntooltip'); // add a class to the wrapper
            error.insertAfter(element);
            error.wrap(container);
            jQuery("<div class='errorImage'></div>").insertAfter(error);
        },
        submitHandler: function(form) {
            form.submit();
        },
    });
    jQuery(".profile-edit.buddypress #profile-edit-form").validate({
        rules: {


            field_1: {
                required: true,
                lettersonly: true
            },
            field_132: {
                required: true,
                lettersonly: true
            },
            field_273: {
                required: true,
                referral: true
            },
            // 'repeater_state[state][] ': {
            //     required: true,
            // },
            'contact[cellphone]': {
                required: true,
                phoneUS: true
            },

            'address[town_city]': {
                required: true,
                townCity: true
            },
            'social[linkedin]': {
                socialUsername: true,
            },
            'social[tiktok]': {
                socialUsername: true,
            },
            'social[youtube]': {
                socialUsername: true,
            },
            'social[instagram]': {
                socialUsername: true,
            },
            'social[twitter]': {
                socialUsername: true,
            },
            'social[facebook]': {
                socialUsername: true,
            },
            'social[blog]': {
                url: true
            },
        },
        messages: {
            field_1: {
                required: "Please enter your first name",
            },

            field_132: {
                required: "Please enter your last name",
            },
        },
        onfocusout: function(element) {
            //To remove the 'checked' class on the error wrapper
            var $errorContainer = jQuery(element).siblings(".Ntooltip").find("label");
            $errorContainer.removeClass("checked");
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        errorPlacement: function(error, element) {
            var container = jQuery('<div />');
            container.addClass('Ntooltip'); // add a class to the wrapper
            error.insertAfter(element);
            error.wrap(container);
            jQuery("<div class='errorImage'></div>").insertAfter(error);
        },
        submitHandler: function(form) {
            form.submit();
        },
    });
    jQuery.validator.addMethod("referral", function(value, element) {

        var current_val = value.toLowerCase();
        var referralCodes = <?php echo json_encode(REFFERAL_CODES); ?>;
        if (jQuery.inArray(current_val, referralCodes) != -1) {
            return true;
        } else {
            return false;
        }
    }, "Referral Code is invalid.");
    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        // phone_number.length > 9 && 
        return this.optional(element) || phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number. US phone format (xxx) xxx-xxxx.");

    jQuery.validator.addMethod("pwcheck", function(value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
            return false;
        }
        return true;
    }, function(value, element) {
        let password = jQuery(element).val();
        if (!(/^(.{6,20}$)/.test(password))) {
            return 'Password must be between 6 to 20 characters long.';
        }
        /*else if (!(/^(?=.*[A-Z])/.test(password))) {
         return 'Password must contain at least one uppercase.';
         } else if (!(/^(?=.*[a-z])/.test(password))) {
         return 'Password must contain at least one lowercase.';
         } else if (!(/^(?=.*[0-9])/.test(password))) {
         return 'Password must contain at least one digit.';
         } else if (!(/^(?=.*[@#$%&])/.test(password))) {
         return "Password must contain special characters from @#$%&.";
         }
         */
        return false;
    });

    var validatedEmail = '';
    var resultssEmail = true;
    var validatedUsername = '';
    var resultsUserName = true;
    jQuery.validator.addMethod('uniqueUsername', function(value, element) {

        let resultusers = true;
        if (value.length > 5) {
            if (validatedUsername != value) {
                jQuery.ajax({
                    type: "post",
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        'action': 'validateUniqueAccount',
                        'type': 'username',
                        'value': value
                    },
                    dataType: "JSON",
                    async: true,
                    success: function(data) {
                        validatedUsername = value;
                        resultusers = data;
                        resultsUserName = data;
                    },
                });
            } else {
                resultusers = resultsUserName;
            }
        }
        return resultusers;
    });

    jQuery.validator.addMethod('uniqueEmail', function(value, element) {
        let resultss = true;
        if (validatedEmail != value) {
            jQuery.ajax({
                type: "post",
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    'action': 'validateUniqueAccount',
                    'type': 'email',
                    'value': value
                },
                dataType: "JSON",
                async: true,
                success: function(data) {
                    validatedEmail = value;
                    resultss = data;
                    resultssEmail = data;
                },
            });
        } else {
            resultss = resultssEmail;
        }
        return resultss;
    });
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Please use only alphabetical characters");
    jQuery.validator.addMethod("validUsername", function(value, element) {
        return /^[a-zA-Z0-9_.-]+$/.test(value);
    }, "This username is not valid");
    jQuery.validator.addMethod("socialUsername", function(value, element) {
        if (value.length == 0) {
            return true;
        } else {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }

    }, "This username is not valid");
    jQuery.validator.addMethod("townCity", function(value, element) {
        if (value.length == 0) {
            return true;
        } else {
            return /^[a-zA-Z_.-\s]+$/.test(value);
        }

    }, "Invalid Town/City");
    function addClassByClickmbt(obj) {
        jQuery(obj).addClass('added-to-cart');
    }


    jQuery('#flyout-example  .secondary-area').click(function() {
        jQuery('#side-cart').addClass("animatedSideBar");
        // jQuery('#side-cart').css({"transform":"translate(0px, 0px)"});
        // jQuery('#side-cart #shopping_cart_item_list_title').css({"transform":"translate(0px, 0px)"});
        // jQuery('#side-cart #shopping_cart_item_list_title').css({"opacity":"1"});        
    });


    jQuery('#side-cart  .thb-mobile-close').click(function() {
        jQuery('#side-cart').removeClass("animatedSideBar");
    });






    $(".burgerNav").click(function() {

        var x = $(".navigation-menu-body").css('display');

        if (x == 'block') {

            $(".navigation-menu-body").fadeOut();

        } else {

            $(".navigation-menu-body").fadeIn();

        }

    });



    if ($(window).width() > 768) { 
    $(document).mouseup(function(e){
            var container = $(".navigation-menu-body");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.fadeOut();
            }

        });

    }


//   for header notification   
$(".bellNotification").click(function() {
        var x = $(".bellNotification .dropdown-menu").css('display');
        if (x == 'block') {
            $(".bellNotification .dropdown-menu").fadeOut();
        } else {
            $(".bellNotification  .dropdown-menu").fadeIn();
        }
    });

    $(document).mouseup(function(e)
    {
        var container = $(".bellNotification .dropdown-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {container.fadeOut();}
    });    // click to clipboard 
    jQuery('.copy_text').click(function (e) {
        e.preventDefault();
        var copyText = jQuery(this).attr('href');
        document.addEventListener('copy', function(e) {
            e.clipboardData.setData('text/plain', copyText);
            e.preventDefault();
        }, true);

        document.execCommand('copy');  
        // console.log('copied text : ', copyText);
        //    alert('copied text: ' + copyText); 
             jQuery(".messageCopyToClickBoard").fadeIn(600); 
                setTimeout(function() {
                    jQuery(".messageCopyToClickBoard").fadeOut(300);
                }, 2500);

            
        });


        
         // upload photo click to delete to refresh page 
        setTimeout(function() {            
            jQuery('#bp-delete-avatar').click(function (e) {
            setTimeout(function() {
                 location.reload();
                }, 2500);
            });   
                }, 2500);


       // Browser Alert Pop Stop  
       // Browser Alert Pop Stop  
       jQuery('ul.windowAlertPopUpRemove li a,#contentThatFades a,.db-navigation ul a,.contentOverlayMenu a,#chat-circle a').click(function (e) {  
            window.onbeforeunload = null;
        });

  // click to copy clipboards with ios support
  function copyToClipboard(string) {
            let textarea;
            let result;
  try {
    textarea = document.createElement('textarea');
    textarea.setAttribute('readonly', true);
    textarea.setAttribute('contenteditable', true);
    textarea.style.position = 'fixed'; // prevent scroll from jumping to the bottom when focus is set.
    textarea.value = string;

    document.body.appendChild(textarea);

    textarea.focus();
    textarea.select();

    const range = document.createRange();
    range.selectNodeContents(textarea);

    const sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    textarea.setSelectionRange(0, textarea.value.length);
    result = document.execCommand('copy');
  } catch (err) {
    console.error(err);
    result = null;
  } finally {
    document.body.removeChild(textarea);
  }

  // manual copy fallback using prompt
  if (!result) {
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const copyHotkey = isMac ? '⌘C' : 'CTRL+C';
    result = prompt(`Press ${copyHotkey}`, string); // eslint-disable-line no-alert
    if (!result) {
      return false;
    }
  }
  return true;
}

// for chatBox maximize or minimize

    $('.minimizeWindow').click(function() {
        $('.wrapperChatBoxMbt').animate({
        bottom: '-355px'
    }, 300); // Set the animation duration in milliseconds

    $(".wrapperChatBoxMbt").addClass("minimizedSection");
  });

  $('.maximizeWindow').click(function() {
        $('.wrapperChatBoxMbt').animate({
        bottom: '0px'
    }, 300); // Set the animation duration in milliseconds

    $(".wrapperChatBoxMbt").removeClass("minimizedSection");
  });



    //   notification menu items Click
   $('.libellNotification ul li a').click(function() {
        $('.notificationBoxCenter').animate({
          bottom: '0px'
        }, 300); 

        
        $(".notificationBoxCenter").removeClass("minimizedSection");


  });


 //   notification menu items Click
  $('.libellMessage ul li a').click(function() {
        $('.messageWrapperContainerBox').animate({
         bottom: '0px'
      }, 300);    
        $(".messageWrapperContainerBox").removeClass("minimizedSection");
  });






  $('.closeBox').click(function() {
        $('.wrapperChatBoxMbt').animate({
            bottom: '-430px'
    }, 0); 

  });


  $('.upScreenOption').click(function() {
    jQuery('.wrapperChatBoxMbt').toggleClass("textAreaCoverFullWidth");
  });


  $('.chat-input').focus(function() {
    $(this).parent().addClass('focusedTextarea');
  });
  $('.chat-input').blur(function() {
    $(this).parent().removeClass('focusedTextarea');
  });

  $('.selectChatUser a').click(function() {
    jQuery(this).parent().toggleClass("activeChatUser");
    
  });


</script>
<div class="order-processing-message loading-mbt">
    <div class="message-processing loading-animate">
        ORDER PROCESSING
    </div>
</div>



<script>
    /*Publication validation
*/
document.addEventListener('DOMContentLoaded', function() {
  var customPostForm = document.getElementById('custom-post-form');
  var pub_title = document.getElementById('pub_title');
  var pub_category = document.getElementById('pub_category');
  var sub_pub_category = document.getElementById('sub_pub_category');
  var publicationDate = document.getElementById('publicationDate');
  var pub_authorName = document.getElementById('pub_authorName');
  var pub_url = document.getElementById('pub_url');
  var pub_description = document.getElementById('pub_description');
  var publication_publisher = document.getElementById('publication_publisher');
  var publisher_name_other = document.getElementById('publisher_name_other');
  var errorMessages = document.querySelectorAll('.error-message');


  customPostForm.addEventListener('submit', function(event) {
    event.preventDefault();

    var isValid = true;

    if (!pub_title.value) {
      errorMessages[0].textContent = 'Title is required';
      isValid = false;
    } else {
      errorMessages[0].textContent = '';
    }

    if (!pub_category.value) {
      errorMessages[1].textContent = 'Category is required';
      isValid = false;
    } else {
      errorMessages[1].textContent = '';
    }

    if (!sub_pub_category.value && sub_pub_category.classList.contains('active')) {
      errorMessages[2].textContent = 'Other category is required';
      isValid = false;
    } else {
      errorMessages[2].textContent = '';
    }
    if (!publication_publisher.value) {
      errorMessages[3].textContent = 'Publisher is required';
      isValid = false;
    } else {
      errorMessages[3].textContent = '';
    }
    if (!publisher_name_other.value && publisher_name_other.classList.contains('active')) {
      errorMessages[4].textContent = 'Publsiher name is required';
      isValid = false;
    } else {
      errorMessages[4].textContent = '';
    }

    if (!publicationDate.value) {
      errorMessages[5].textContent = 'Publication date is required';
      isValid = false;
    } else {
      errorMessages[5].textContent = '';
    }

    if (!pub_authorName.value && pub_authorName.classList.contains('active')) {
      errorMessages[6].textContent = 'Author name is required';
      isValid = false;
    } else {
      errorMessages[6].textContent = '';
    }

    if (!pub_url.value) {
      errorMessages[7].textContent = 'URL is required';
      isValid = false;
    } else {
      errorMessages[7].textContent = '';
    }

    if (!pub_description.value) {
      errorMessages[8].textContent = 'Publication description is required';
      isValid = false;
    } else {
      errorMessages[8].textContent = '';
    }

    if (isValid) {
        jQuery('.loader-article').show();
      var formData = new FormData(customPostForm);
      jQuery('.error-message').html('');
      jQuery('.general-response').removeClass('error');
      jQuery('.general-success').removeClass('error');
      jQuery('.general-success').html('');
      jQuery.ajax({
        type: "post",
        method:'POST',
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        data:$('#custom-post-form').serialize(),
        success: function(response) {
            if (typeof response !== 'string') {
                obj_json = JSON.parse(response);
                Object.keys(obj_json).forEach(function(kk){
                    if(kk=='status'){
                        jQuery('.general-response').addClass('error');
                        jQuery('.general-response').html('Something went wrong please contact web admin');
                    }
                    else{
                        error_id = '#'+kk+'-error';
                        jQuery(error_id).html(obj_json[kk]);
                
                    }
               
                });
            }
            else{
                load_existig_publications('<?php echo get_current_user_id(); ?>');
                jQuery('.loader-article').hide();
                jQuery('.general-response').addClass('success');
                jQuery('.general-response').html('Saved successfully');
                jQuery("#custom-post-form").trigger("reset");
                setTimeout(function(){jQuery('.modal').toggleClass('is-visible'); }, 500);
            }
            //   jQuery('#smile_brillaint_cart_form').unblock();
        }
    })
    }
  });
});
function resetErrorREsponse() {
    jQuery('.error-message').html('');
    jQuery('.error-message').html('');
    jQuery('.general-response').html('').removeClass('success');
}
jQuery(document).on('click','.edit-pub',function(){
    resetErrorREsponse();
    pub_id = jQuery(this).attr('data-pub_id');
    pub_title = jQuery(this).attr('data-pub_title');
    pub_category = jQuery(this).attr('data-pub_category');
    publication_publisher = jQuery(this).attr('data-publication_publisher');
    publicationdate = jQuery(this).attr('data-publicationdate');
    pub_authorname = jQuery(this).attr('data-pub_authorname');
    pub_url = jQuery(this).attr('data-pub_url');
    pub_description = jQuery(this).attr('data-pub_description');
    jQuery('#custom-post-form').find('#pub_title').val(pub_title);
    pub_category = pub_category.toLowerCase();
    jQuery('#custom-post-form').find('#pub_category').val(pub_category);
    if(jQuery('#pub_category').val()=='' || jQuery('#pub_category').val()== null) {
        jQuery('#pub_category').val('other').trigger('change');
        jQuery('#sub_pub_category').val(pub_category);
    }
    else{
        jQuery('#sub_pub_category').val('');
    }
    jQuery('#custom-post-form').find('#publication_publisher').val(publication_publisher);
    if(jQuery('#publication_publisher').val()=='' || jQuery('#publication_publisher').val()==null) {
        jQuery('#publication_publisher').val('other').trigger('change');
        jQuery('#publisher_name_other').val(publication_publisher);
    }
    else{
        jQuery('#publisher_name_other').val('');
    }
    
    jQuery('#custom-post-form').find('#publicationDate').val(publicationdate);
    
    if(pub_authorname!='') {
        jQuery('#custom-post-form').find('.addAuthorWrapper').slideToggle();
        jQuery('#custom-post-form').find('#pub_authorName').addClass('active');
        jQuery('#custom-post-form').find('#pub_authorName').val(pub_authorname);
    }
    
    jQuery('#custom-post-form').find('#pub_url').val(pub_url);
    jQuery('#custom-post-form').find('#pub_description').val(pub_description);
    jQuery('#custom-post-form').find('#action-id').val('update_rdh_publications');
    jQuery('#custom-post-form').find('#pub_id').val(pub_id);
    $('.modal').toggleClass('is-visible');


    // counter update on edit button
        updateCharacterCount();
        
        // Bind keyup event to character count function
        $("#pub_description").keyup(function() {
            updateCharacterCount();
        });

        // Bind click event to character count function for "Edit" button
        $(".edit-pub").click(function() {
            updateCharacterCount();
        });

        function updateCharacterCount() {
        var maxLength = $("#pub_description").attr('maxlength');
        var length = $("#pub_description").val().length;
        var counter = $("#counterNumber");
        counter.text(length + "/" + maxLength);
        }


    
});

jQuery(document).ready(function() {
  jQuery("#pub_description").keyup(function() {
    var maxLength = jQuery(this).attr('maxlength');
    var length = jQuery(this).val().length;
    var counter = jQuery("#counterNumber");
    counter.text(length + "/" + maxLength);
  });
});


/*




*/
// Quick & dirty toggle to demonstrate modal toggle behavior
$('body').toggleClass('addPublicationModalPopup');
$('.modal-toggle').on('click', function(e) {
    e.preventDefault();
    jQuery("#custom-post-form").trigger("reset");
    jQuery('#custom-post-form').find('#action-id').val('insert_rdh_publications');
    jQuery('#custom-post-form').find('#pub_id').val('');
    $('.modal').toggleClass('is-visible');
    resetErrorREsponse();
});
$('.textarea-count').keyup(function() {

var characterCount = $(this).val().length,
    current = $('#current'),
    maximum = $('#maximum'),
    theCount = $('#the-count');

current.text(characterCount);


/*This isn't entirely necessary, just playin around*/
if (characterCount < 70) {
    current.css('color', '#666');
}
if (characterCount > 70 && characterCount < 90) {
    current.css('color', '#6d5555');
}
if (characterCount > 90 && characterCount < 100) {
    current.css('color', '#793535');
}
if (characterCount > 100 && characterCount < 120) {
    current.css('color', '#841c1c');
}
if (characterCount > 120 && characterCount < 139) {
    current.css('color', '#8f0001');
}

if (characterCount >= 140) {
    maximum.css('color', '#8f0001');
    current.css('color', '#8f0001');
    theCount.css('font-weight', 'bold');
} else {
    maximum.css('color', '#666');
    theCount.css('font-weight', 'normal');
}


});
$('.cancelBtnPop').on('click', function(e) {
    $('.modal').removeClass('is-visible');
});
                                                                                                                                          
            
$(document).ready(function() {
    $('.publication-other,.addAuthorWrapper,.removeAuthorText,.anotherCategory').hide();

   $('#pub_category').change(function() {
    if($(this).val() == 'other') {
      $('.anotherCategory').show('fast');
      jQuery('#sub_pub_category').addClass('active');
    } else {
      $('.anotherCategory').hide('fast');
      $('#sub_pub_category').val('');
      jQuery('#sub_pub_category').removeClass('active');
    }
  });



  $('#publication_publisher').change(function() {
    if($(this).val() == 'other') {
        jQuery('#publisher_name_other').addClass('active');
      $('.publication-other').show('fast');
    } else {
        jQuery('#publisher_name_other').removeClass('active');
        jQuery('#publisher_name_other').val('');
      $('.publication-other').hide('fast');
    }
  });
  


   $('.addAuthorBtn').on('click', function(e) {
        e.preventDefault();        
        $('.addAuthorWrapper').slideToggle();
        $('#pub_authorName').addClass('active');
    });

    $('.remove_button').on('click', function(e) {
        e.preventDefault();        
        $('.addAuthorWrapper').slideUp();
        $('#pub_authorName').removeClass('active');
        $('#pub_authorName').val('');
    });
load_existig_publications('<?php echo get_current_user_id(); ?>');

});
function load_existig_publications(user_id) {
    jQuery.ajax({
        method:'POST',
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        data:'user_id='+user_id+'&action=get_rdh_publications',
        success: function(response) {
           
           jQuery('.card-list').html(response);
           
        }
    })
}




// let count = 0; // counter for number of clicks
//         let maxClicks = 10000; // maximum number of clicks
//         let interval = 2000; // interval in milliseconds (6 seconds)
        
//         let myButton = document.getElementById("myButton");
        
//         let clickInterval = setInterval(function() {
//           if (count >= maxClicks) {
//             clearInterval(clickInterval); // stop the clicking
//             console.log("Finished clicking.");
//           } else {
//             myButton.click(); // simulate the click
//             console.log("Clicked.");
//             count++;
//           }
//         }, interval);
        
        
            // for chat or message section for onlyh RDH
     


            
// Function to close the landscape warning
function closeLandscapeWarning() {
    document.querySelector('.landscape-warning').style.display = 'none';
}

// Event listener for the close button
document.getElementById('close-warning-landsacpe').addEventListener('click', closeLandscapeWarning);



    // mobile navigation min-cart-trigger to open min cart
    // jQuery('body').on('click touchstart', '#open-min-cart', function() {
    //      jQuery('#quick_cart').trigger('click');
    // });



    // mobile navigation min-cart-trigger to open min cart
    // jQuery('body').on('click touchstart', '#open-min-cart', function() {
    //      jQuery('#quick_cart').trigger('click');
    // });




    // // mobile navigation min-cart-trigger to open min cart
    // jQuery('body').on('click', '.open-min-cart,a.thb-mobile-close', function() {
    //     // alert("min cart")
    //         jQuery('body').removeClass('activateMenuNavigationWrapper');            
    //         jQuery('body').toggleClass('activateMinCartOption');
    //     });

    //     jQuery('body').on('click', '.mobile-burger-menu-nav', function() {
    //         // alert("burger nav")
    //         jQuery('body').removeClass('activateMinCartOption');
    //         jQuery('body').toggleClass('activateMenuNavigationWrapper');
    //     });


    //     jQuery('body').on('click', '.add_to_cart_button', function() {
    //         setTimeout(function() { 
    //         // alert("hohoho")
    //         if ($('#side-cart').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
    //             // jQuery('#side-cart').css('transform', 'translateX(100%)');         
    //         }
    //         else {
    //             // alert("hahah")
    //             jQuery('#side-cart').css('transform', 'translateX(0%)');            
    //             jQuery('body').addClass('activateMinCartOption');
    //         }
    //     }, 500);
    //     });




    // navigation js by ai

    // mobile navigation min-cart-trigger to open min cart
    if (window.innerWidth <= 768) {
        jQuery('body').on('click', '.open-min-cart', function() {
        
            if ($('#side-cart').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
                jQuery('#side-cart').css('transform', 'translateX(100%)');
                // jQuery('a#dropdownMenuCart').css('background', 'red');               
            }
            else {
                jQuery('#side-cart').css('transform', 'translateX(0%)');
                // jQuery('a#dropdownMenuCart').css('background', 'green');               
            }
        });

        
        jQuery('body').on('click', '.open-min-cart,a.thb-mobile-close', function() {
        // alert("min cart")
            jQuery('body').removeClass('activateMenuNavigationWrapper');            
            jQuery('body').toggleClass('activateMinCartOption');
            // jQuery('#wrapper').removeClass('open-cc')
        });
                    


        jQuery('body').on('click', '.add_to_cart_button', function() {
            setTimeout(function() { 
            // alert("hohoho")
            if ($('#side-cart').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
                // jQuery('#side-cart').css('transform', 'translateX(100%)');         
            }
            else {
                // alert("hahah")
                jQuery('#side-cart').css('transform', 'translateX(0%)');            
                jQuery('body').addClass('activateMinCartOption');
            }
        }, 1300);
        });

    
        jQuery('body').on('click', '.mobile-burger-menu-nav', function() {
            // alert("burger nav")
            jQuery('body').removeClass('activateMinCartOption');
            jQuery('body').toggleClass('activateMenuNavigationWrapper');
            jQuery('#side-cart').css('transform', 'translateX(100%)');
        });

    }

    jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
    console.log('Product added to cart!');
    $('#quick_cart').trigger('click');
  //  $('#quick_cart').trigger('click');
    // Perform your custom actions here
});
// End navigation js by ai
function updateShippingProtection(element) {
    var cookieName = 'shipping_protection';
    var enableShippingProtection = element.value;

    if (enableShippingProtection == '1') {
        setCookie(cookieName, '1', 7);

        setTimeout(function() {
            window.location.reload();
        }, 200); 
        jQuery('.loading-mbt').show();
        
    } else {
        setCookie(cookieName, '0', 7);
        jQuery('.remove_from_cart_button').each(function () {
            var att_pid = jQuery(this).data('gtm4wp_product_id');

            if (att_pid == '<?php echo SHIPPING_PROTECTION_PRODUCT ?>') {
             //   alert(att_pid);
                jQuery(this).click();
            }
            //alert(att_pid); // Note: This alert will display 'undefined' if att_pid is not
        });
        jQuery('.loading-mbt').show();
        // Perform removeFromCart or other logic as needed
        setTimeout(function() {
            window.location.reload();
        }, 200); 
    }
}
function setCookie(cookieName, cookieValue, days) {
    var expires = "";
    
    if(cookieName=='shipping_protection' && cookieValue=='0' && days){
        var date = new Date();
        date.setTime(date.getTime() + 1800*1000);
        expires = "; expires=" + date.toUTCString();
    }
   else if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    // Set SameSite=None for cross-site cookies
    var sameSiteAttribute = "; SameSite=None";

    // Check if the Secure attribute should be set (only for HTTPS)
    var secureAttribute = location.protocol === "https:" ? "; Secure" : "";

    // Set the cookie with the SameSite and Secure attributes
    document.cookie = cookieName + "=" + cookieValue + expires + "; path=/" + sameSiteAttribute + secureAttribute;
}



// Function to remove a cookie
function removeCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}






</script>
<script type="text/javascript">
    if (typeof ajaxurl === 'undefined') {
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    }
</script>

<!-- Start of smilebrilliant Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=aebce2de-0290-43d9-9807-fbaaf949fa4f">
</script>
<!-- End of smilebrilliant Zendesk Widget script -->
</body>

</html>