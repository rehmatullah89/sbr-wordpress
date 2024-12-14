<?php
setcookie('rdh_member', 'true',time() + (86400 * 15), "/"); 
/*

Template Name: Bp Landing Page

*/

get_header();
?>
    <div class="container bp-welcome-container">
        <div class="rdhHeader text-center">
            <!-- <h1 class="font-mont">Coming soon tt!</h1> -->
			<div class="rdh-logo">
				<img src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png" alt="RDH connect" class="img-fluid" >
			</div>
		</div>
        <h1 class="font-mont weight-300 text-center">FOR HYGIENISTS. BY HYGIENISTS.</h1>
        <div class="page-body-content">
            <!-- <p>
                RDH Connect™ is a curated network of the nation's most active and influential dental hygienists, who are committed to improving oral health through education and enhancing opportunity through connection.
            </p> -->
            <p>RDH Connect™ is the first community uniting dental hygienists as colleagues to influence the conversation around oral health and find opportunity through connection.</p>

            <div class="form-input-container">
                <form action="/rdh-register" onsubmit='check_is_valid_code(event,<?php echo json_encode(REFFERAL_CODES); ?>);'>
                    <span class="ref-error" style="color:red"></span>
                    <input type="text" name="referral_code" id="refferel_code" required class="form-control" placeholder="Enter Invite Code Here"><br>
                    <button type="submit" class="button default-button btn">Register</button>
                    <br />
                    <br />
                    <a class="default-button" href="/my-account?rdh=true">Already a member? Click to Login</a>
                   
                </form>  
                <script>
                    function check_is_valid_code(event,codes_refferals) {
                       
                       
                        codes_refferals = codes_refferals.map(codes_refferals => codes_refferals.toLowerCase());
                        refferel_code = jQuery('#refferel_code').val();
                        refferel_code = refferel_code.toLowerCase();
                        if(refferel_code !='' && !codes_refferals.includes(refferel_code)) {
                            jQuery('#refferel_code').addClass('has-error');
                            jQuery('.ref-error').text('Invalid Referral Code');
                            event.preventDefault();
                            return false;
                        }
                        else{
                            jQuery('#refferel_code').removeClass('has-error');
                            jQuery('.ref-error').text('');
                        }
                    }
                </script>  
                <style>
                    .has-error {
                        border: 1px solid red !important;
                    }
                </style>            
            </div>

        </div>


    </div>





<?php

get_footer();

?>