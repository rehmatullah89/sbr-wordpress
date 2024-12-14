<?php

/*

Template Name: Dentist Welcome Template 

*/

get_header();


?>
<style>
    body {

    background: #F9F9F9;
}.bp-welcome-container .rdhHeader {
    margin-bottom: 4rem;
    margin-top: 4rem;
}
.contain-wrapper {
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 3rem;
    padding: 2rem;
    background: #fff;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}

    h1 {
    text-transform: uppercase;
}
.orr {
    font-weight: 800;
    font-size: 32px;
    font-family: "Montserrat";
}    
h4 {    margin-bottom: 0;
    font-size: 26px;
}
h4 a {
    font-size: 80%;
}
</style>
    <div class="container bp-welcome-container">
        <div class="rdhHeader text-center">
            <div class="contain-wrapper">
            <h1 class="font-mont">Thank you for registering with us!</h1>
            <h4 class="font-mont recomemdationURL">Below is the URL for accessing your recommendations: <br>
            <a href="<? echo $_REQUEST['recom_url'];?>" target="_blank"><? echo $_REQUEST['recom_url'];?></a></h4>

            <h4 class="font-mont accessCode">Your unique access code is:<br> 
                <b style="color:#1fb6e4;"><? echo $_REQUEST['access_code'];?></b></h4>            
            </div>

			<!-- <div class="rdh-logo">
				<img src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png" alt="RDH connect" class="img-fluid" >
			</div> -->
		</div>
        <!-- <h2 class="font-mont weight-300 text-center">FOR HYGIENISTS. BY HYGIENISTS.</h2> -->
       


    </div>





<?php

get_footer();

?>