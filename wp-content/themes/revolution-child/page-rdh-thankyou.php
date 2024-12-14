<?php

/*

Template Name: Bp Welcome Template

*/

get_header();


?>
    <div class="container bp-welcome-container">
        <div class="rdhHeader text-center">
            <h1 class="font-mont">Thank you for Registering!</h1>
			<div class="rdh-logo">
				<img src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png" alt="RDH connect" class="img-fluid" >
			</div>
		</div>
        <h2 class="font-mont weight-300 text-center">FOR HYGIENISTS. BY HYGIENISTS.</h2>
        <div class="page-body-content">
            <p>
                RDH Connect™ is a curated network of the nation's most active and influential dental hygienists, who are committed to improving oral health through education and enhancing opportunity through connection.
            </p>
            <?php if(is_user_logged_in()) {
                if(function_exists('bp_is_active')){ ?>
            <p class="backToEditProfile"><a href="/members/<?php echo bp_core_get_username( $userdata->ID);?>/profile/edit/group/1"><i class="fa fa-chevron-left" aria-hidden="true"></i> Edit Profile</a></p>
            <?php
        } } ?>

        </div>


    </div>





<?php

get_footer();

?>