<?php
$thb_id = get_queried_object_id();
$logo = ot_get_option('logo', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo.png');
$logo_light = ot_get_option('logo_light', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo-light.png');

$fixed_header_color = ot_get_option('fixed_header_color', 'dark-header');
$fixed_header_shadow = ot_get_option('fixed_header_shadow');
$header_color = thb_get_header_color($thb_id);

$header_class[] = 'header style10';
$header_class[] = $fixed_header_shadow;
$header_class[] = $header_color;
?>
<!-- Start Header -->


<?php //get_template_part( 'inc/templates/sale/header/header-section-top' ); ?>

<!-- <div class="navbar-fixed-top-barr">
    <div style="width:25%;background-color:#4597cb;font-size:0px;height:8px;float:left;">&nbsp;1</div>
    <div style="width:25%;background-color:#f8a18a;font-size:0px;;height:8px;float:left;">&nbsp;2</div>
    <div style="width:25%;background-color:#68c8c7;font-size:0px;;height:8px;float:left;">&nbsp;3</div>
    <div style="width:25%;background-color:#b8b8dc;font-size:0px;;height:8px;float:left;">&nbsp;4</div>
</div> -->



<header id="mobile-header" class="hidden-desktop <?php echo esc_attr(implode(' ', $header_class)); ?>" data-header-color="<?php echo esc_attr($header_color); ?>" data-fixed-header-color="<?php echo esc_attr($fixed_header_color); ?>">
    <div class="row align-middle header-row">
        <div class="small-12 columns custom-spacing-around">
            <div class="mobile-toggle-holder style1">
                <div class="mobile-toggle">
                    <span style=""></span><span style=""></span><span style=""></span>
                </div>
            </div>

            <div class="logo-holder style10-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logolink" title="<?php bloginfo('name'); ?>">
                    <img src="<?php echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php bloginfo('name'); ?>"/>
                    <img src="<?php echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php bloginfo('name'); ?>"/>
                </a>
            </div>
            <?php
            add_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10, 2);
            get_template_part('inc/templates/header/full-menu');
            remove_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10);
            ?>
            <div class="secondary-area-mbt">
                <div id="quick_cartt">
                    <a rel="nofollow"  id="dropdownMenuCart">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                        <span class="float_count"></span>
                    </a>
                </div>
                <?php
                if (!is_checkout()) {
//                    woocommerce_mini_cart();
                }

                do_action('thb_secondary_area');
                ?>

            </div>

            <div class="user-login">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account',''); ?>">
				<i class="fa fa-user-o" aria-hidden="true"></i>

                    <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="lnr-user" viewBox="0 0 1024 1024" width="100%" height="100%"><title>user</title><path class="path1" d="M486.4 563.2c-155.275 0-281.6-126.325-281.6-281.6s126.325-281.6 281.6-281.6 281.6 126.325 281.6 281.6-126.325 281.6-281.6 281.6zM486.4 51.2c-127.043 0-230.4 103.357-230.4 230.4s103.357 230.4 230.4 230.4c127.042 0 230.4-103.357 230.4-230.4s-103.358-230.4-230.4-230.4z"></path><path class="path2" d="M896 1024h-819.2c-42.347 0-76.8-34.451-76.8-76.8 0-3.485 0.712-86.285 62.72-168.96 36.094-48.126 85.514-86.36 146.883-113.634 74.957-33.314 168.085-50.206 276.797-50.206 108.71 0 201.838 16.893 276.797 50.206 61.37 27.275 110.789 65.507 146.883 113.634 62.008 82.675 62.72 165.475 62.72 168.96 0 42.349-34.451 76.8-76.8 76.8zM486.4 665.6c-178.52 0-310.267 48.789-381 141.093-53.011 69.174-54.195 139.904-54.2 140.61 0 14.013 11.485 25.498 25.6 25.498h819.2c14.115 0 25.6-11.485 25.6-25.6-0.006-0.603-1.189-71.333-54.198-140.507-70.734-92.304-202.483-141.093-381.002-141.093z"></path></svg> -->
                </a>
            </div>

        </div>
    </div>
</header>
<div class="saleParentWrapper">
<?php
	$start_time_ticker = '2022-06-02 00:00:00';
	$end_time_ticker = '2022-06-20 01:00:00';
	if (time() > strtotime($start_time_ticker) && time() < strtotime($end_time_ticker)) {
		$deal_alert_text_wrap_style = '';
		$deal_alert_on_click = '';
		$deal_alert_text_primary = "Father's Day ";
		$deal_alert_text_secondary = 'Sale Ends';
		$deal_alert_enabled_ticker = true;
		$deal_alert_endtime = strtotime($end_time_ticker);
		$dateTimeZoneCentral = new DateTimeZone(get_option('timezone_string'));
		//print_r($dateTimeZoneCentral);
		$dateTimeCentral = new DateTime("now", $dateTimeZoneCentral);
		$timeOffset = ($dateTimeZoneCentral->getOffset($dateTimeCentral) / 60) / 60;
		$utc_offset_mbt = "UTC-0" . abs($timeOffset) . "00";
	?>
		<!-- sale page header counter -->
		<style>
			.saleParentWrapper {
				position: fixed;
				width: 100%;
				right: 0;
				left: 0;
				z-index: 1030;
			}

			.deal-top-bar {
				background: #ffa488;
				height: 42px;
				text-align: center;
			}

			.saleParentWrapper header#sbr-header {
				position: static;
			}

			.deal-top-bar>.container {
				height: 100%;
			}

			.deal-top-bar .flex-div {
				height: 100%;
				display: flex;
				justify-content: center; 				
				
			}

			.white-text {
				color: #fff;
			}
			/* span#deal-seconds {
				    display: block;
			} */
			span.deal-right-text {
 			   margin-right: 10px;    margin-left: 1px;
			}
			span.parentSpan {
				margin-top: 5px;
				position: relative;
				display: flex;
				flex-direction: column;    
				/* align-items: center; */
				min-width: 30px;
			}

		</style>
		<style type='text/css'>

			.deal-top-bar .container {
				text-align: center;
			}
			span.deal-right-text,.deal-left-text {
				/* padding-top: 14px; */
			}
			.deal-left-text {
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;

			}

			span.deal-time-bracket {
				display: none;
			}

			span#deal-days,
			span.deal-time-colon.daysonly {
				display: block !important;
			}
			.deal-right-text {
				color: white;
			}

		
			.deal-center-break {
				display: none;
			}

		




			.deal-time-span {
				background-color: #fcfefc;
				color: #ffa488;
				font-size: 16px;
				padding-left: 3px;
				padding-right: 3px;
				height: 22px;
				/* display: block; */
				display: flex;
				align-items: center;
				justify-content: center;
			}
			span.deal-time-colon {
				text-transform: uppercase;
				font-size: 9px;
				color: #fce0d7;
			}
			span.dotsSeprator {
				display: inline-block;
				padding-left: 6px;
				padding-right: 4px;
				color: #fff;
				position: relative;
			    top: -3px;				

			}			
			.deal-top-bar a.btn{
				background-color: #303e48;
				border-color: #32373a;
				height: 26px;
				padding: 2px 18px;
				letter-spacing: 0;
				margin-left: 15px;
				margin-top: -6px;
			}
			.flex-div-innerleft {
				text-align: left;   
			}
			@media(min-width:100px) {
				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:430px) {
			
				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:500px) {
				
				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:660px) {
				<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>.jord-page-content {
					padding-top: 87px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 62px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}



				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

				/* adjust top alignment  impact header counter	 */
				.post-content.no-vc,.post-172 h1.vc_custom_heading.full-larger-heading
				,.page-id-130 .post-130

				{
 				   margin-top: 50px;
				}
				.page-template-faqs h1#contactFormTitle {
 				   margin-top: 130px;
				}

				/* adjust top alignment  impact header counter Ends	 */


			}

			@media(min-width:768px) {
				<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>.jord-page-content {
					padding-top: 68px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 43px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}

				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}


			@media(min-width:992px) {
				<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>.jord-page-content {
					padding-top: 88px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 58px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}

				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:1200px) {
				
				.deal-center-break {
					<?php if ($GLOBALS["deal-alert-text-secondary"] != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

				
			}
			@media(min-width:768px) {
				.deal-top-bar .flex-div {
					align-items: center;					
				}
			}

			@media(max-width:767px) {
				.deal-top-bar .container >.flex-div{ flex-direction: column;position: relative;}
				.deal-top-bar{    height: 70px; }
				.deal-time-span{
					font-size: 16px;
				    height: 24px;
				}
				span.parentSpan{
					margin-top: 0px;
				}
				span.dotsSeprator{
					padding-left: 4px;
					top: 2px;
				}
				.hiddenmobile{ display:none !important;}
				span.parentSpan{
					min-width: 28px;
				}
				.deal-top-bar a.btn{
					margin-top: 0px;
					/* display: none; */
				}
				.deal-left-text{
					margin-bottom: 3px;
					display: inline-block;
					margin-top: 3px;
				}
				.fixed-header-on .header{
					top: 69px;
				}
				.home .post-content.no-vc {
					margin-top: 0px;
				}				
				.post-content.no-vc {
					margin-top: 60px;
				}
				.flex-div-innerright.flex-div {
					justify-content: start;
					padding-left: 15px;
				}
				.deal-top-bar a.btn{
					margin-top: 0px;
					position: absolute;
					right: 15px;
					top: 12px;
					font-size: 18px;
					max-width: 140px;
					display: flex;
					align-items: center;
					justify-content: center;
					flex-direction: column;
					height: 46px;
				}
				.flex-div-innerleft {
					 padding-left: 15px;
				}

			}


		</style>
		<script>
			jQuery('body').addClass('bannerAdded');
		</script>

		<script type='text/javascript'>
			function n__eById(n__elementId) {
				return document.getElementById(n__elementId);
			}

			function n__showTickerAlertModal() {
				$('#tickerAlertModal').modal({
					backdrop: true, //true, false, or static (static doesnt close on click)
					keyboard: false, //escape closes window or not
					show: true, //show it when initialized
					remote: false //load remote path
				});
			}

			function n__getDealTimeRemaining(endtime) {
				var t = Date.parse(endtime) - Date.parse(new Date());
				var seconds = Math.floor((t / 1000) % 60);
				var minutes = Math.floor((t / 1000 / 60) % 60);
				var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
				var days = Math.floor(t / (1000 * 60 * 60 * 24));

				return {
					'total': t,
					'days': days,
					'hours': hours,
					'minutes': minutes,
					'seconds': seconds
				};
			}

			function n__initializeDealClock(endtime) {
				var daysSpan = n__eById('deal-days');
				var hoursSpan = n__eById('deal-hours');
				var minutesSpan = n__eById('deal-minutes');
				var secondsSpan = n__eById('deal-seconds');

				function n__updateDealClock() {
					var t = n__getDealTimeRemaining(endtime);

					if (t.days < 4) {
						if (t.days > 0) {

							var n__modifiedHours = (parseInt(t.hours) + (parseInt(24) * parseInt(t.days)));
							if (n__modifiedHours > 99) {
								hoursSpan.innerHTML = ('0' + n__modifiedHours).slice(-3);
							} else {
								hoursSpan.innerHTML = ('0' + n__modifiedHours).slice(-2);
							}
						} else {
							hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
						}
						minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
						secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
						daysSpan.innerHTML = ('00');
						jQuery('.daysonly').hide();
					}
					if (t.days >= 4) {
						console.log(t.days);
						daysSpan.innerHTML = ('0' + t.days).slice(-2);
						hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
						minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
						secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
					}
					if (t.total <= 0) {
						clearInterval(timeinterval);
					}
				}

				n__updateDealClock();
				var timeinterval = setInterval(n__updateDealClock, 1000);
			}

			<?php
			if ($deal_alert_enabled_ticker  == true) {
			?>
				jQuery(document).ready(function() {
					n__initializeDealClock('<?php echo date("F j Y H:i:s", $deal_alert_endtime) . " " . $utc_offset_mbt; ?>');
				})

			<?php
			}
			?>
		</script>


		<div class='deal-top-bar' style='<?php echo $deal_alert_text_wrap_style; ?>' onclick='<?php echo $deal_alert_on_click; ?>'>
			<div class="container">

				<!-- AMAZON PRIMEDAY 2018
				<span class='deal-left-text'><?php //echo $deal_alert_text_primary; ?></span>

				<span class='deal-right-text'> <?php //echo $deal_alert_text_secondary; ?></span> -->

				<div class="flex-div">
			
					<div class="flex-div-innerleft">

						<span class='deal-left-text '> <?php echo $deal_alert_text_primary; ?></span>
						<!-- <span class='deal-center-break'><br /></span> -->
						<span class='deal-right-text'> <?php echo $deal_alert_text_secondary; ?><span class="hiddenmobile">:</span></span>
					</div>

					<div class="flex-div-innerright flex-div">					
					<?php
					if ($deal_alert_enabled_ticker  == true) {
					?>
						<div class='deal-time-break'></div>
						<span class='deal-time-bracket'>&nbsp;[</span>
						<span class="parentSpan">
							<span id="deal-days" class='deal-time-span daysonly' style=''></span>
							<span class='deal-time-colon daysonly'>Days</span>
						</span>
						<span class="dotsSeprator">:</span>
						<span class="parentSpan">
							<div clas="flexItem">
								<span id="deal-hours" class='deal-time-span' style=''></span>
							</div>
							<span class='deal-time-colon'>Hours</span>
						</span>
						<span class="dotsSeprator">:</span>
						<span class="parentSpan">
							<div clas="flexItem">
								<span id="deal-minutes" class='deal-time-span' style=''></span>
							</div>
							<span class='deal-time-colon'>Minutes</span>
						</span>
						<span class="dotsSeprator">:</span>
						<span class="parentSpan">
							<span id="deal-seconds" class='deal-time-span' style=''></span>
							<span class='deal-time-colon'>Seconds</span>
						</span>
						<span class='deal-time-bracket'>]</span>
					<?php
					}
					?>

					<a class="btn btn-primary-orange" href="/sale">SHOP  DEALS</a>

					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<header id="sbr-header" class="sbr-header-mbt header dark-header headroom headroom--top headroom--not-bottom">


    <nav class="navbar navbar-expand-lg navbar-dark navbar navbar-fixed-top navbar-standard row">


        <div class="collapse navbar-collapse justify-content-between" id="navbarToggle">

            <ul class="nav navbar-nav navbar-left">
                <li class="nav-item">
                    <a class="nav-link active" href="#" rel="nofollow">Shop <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                        <li>
                            <a rel="nofollow" href="/product/teeth-whitening-trays" title="Teeth Whitening Trays (Custom-Fitted) Kit">Whitening System</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="/product/teeth-whitening-gel" title="Teeth Whitening Gel">Whitening Gel</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="/product/sensitive-teeth-gel" title="Desensitizing Gel For Teeth Whitening">Desensitizing Gel</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="/product/electric-toothbrush" title="Electric Toothbrush">Electric Toothbrush</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="/product/toothbrush-heads" title="Replacement Toothbrush Heads">Toothbrush Heads</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="/product/water-flosser" title="Water Flosser">Water Flosser</a>
                        </li>  

                        <li class="inner-sub-menu z-index-greater">
                            <a rel="nofollow" href="javascript:void(0);" title="Plaque Highlighters">NEW! Plaque Highlighters</a>
                                    <ul class="plaque-sub-menu dropdown-menu">
                                        <li>
                                            <a rel="nofollow" href="/product/plaque-highlighters/adults" title="Plaque Highlighters For Adults">Plaque Highlighters</a>
                                        </li>
                                        <li>
                                            <a rel="nofollow" href="/product/plaque-highlighters/kids" title="Plaque Highlighters for Kids">Plaque Highlighters for Kids</a>
                                        </li>

                                    </ul>
                        </li>
                        <li class="inner-sub-menu">
                            <a rel="nofollow" href="javascript:void(0);" title="Plaque Highlighters">NEW! Dental Probiotics</a>
                                    <ul class="plaque-sub-menu dropdown-menu">
                                        <li>
                                            <a rel="nofollow" href="/product/dental-probiotics/adults" title="Dental Probiotics For Adults">Dental Probiotics</a>
                                        </li>
                                        <li>
                                            <a rel="nofollow" href="/product/dental-probiotics/kids" title="Dental Probiotics for Kids">Oral & Sinus Probiotics for Kids</a>
                                        </li>

                                    </ul>
                        </li>


                        <li>
                            <a rel="nofollow" href="/product/retainer-cleaner" title="Cleaning Tablets for Night Guards, Whitening Trays, Clear Aligners">Retainer Cleaning Tablets</a>
                        </li>                        

                        <li>
                            <a rel="nofollow" href="/product/night-guards" title="Teeth Grinding - Night Guards">Night Guards</a>
                        </li>

                        <li>
                            <a rel="nofollow" href="/product/enamel-armour" title="cariPRO™ Enamel Armour for Sensitive Teeth | Smile Brilliant">Enamel Armour</a>
                        </li>
						<li>
                            <a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant">Ultrasonic Cleaner</a>
                        </li>	

                    </ul>

                </li>
                <li class="nav-item">
                    <a href="/reviews" rel="nofollow" title="Teeth Whitening Reviews">REVIEWS</a>
                </li>
                <li class="nav-item">
                    <a href="/guarantee" rel="nofollow" title="Teeth Whitening Results Backed by Our Guarantee">GUARANTEE</a>
                </li>
            </ul>


            <!--   Show this only lg screens and up   -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand navbar-center-cell" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php bloginfo('name'); ?>"/>
                <img src="<?php echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php bloginfo('name'); ?>"/>
            </a>     

            <div class="nav navbar-nav navbar-right right-sidebebar-top">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a rel="nofollow"  class="dropdown-toggle">
                            HELP<span class="caret"></span>
                        </a>

                        <ul aria-labelledby="menu_item_features-grid" class="dropdown-menu">

                            <li>
                                <a rel="nofollow" href="/teeth-whitening-facts" title="10 Facts Everyone Should Know About Teeth Whitening">10 FACTS ABOUT TEETH WHITENING</a>
                            </li>
                            
                            <li>
                                <a rel="nofollow" href="/sensitive-teeth-guide/" title="Causes & Remedies for Sensitive Teeth"> Sensitive Teeth Guide </a>
                            </li>
                            <li>
                                <a rel="nofollow" href="/bad-breath-cause" title="Things You Should Know About Halitosis & Oral Care">The Science of Bad Breath</a>
                            </li>
                            <li>
                                <a rel="nofollow" href="/oral-probiotics-facts" title="5 Facts You Should Know about Oral Probiotics">5 FACTS ABOUT ORAL PROBIOTICS</a>
                            </li>

                            <li>
                                <a rel="nofollow" href="/frequently-asked-questions" title="Frequently Asked Questions About Whitening Teeth or Bleaching Teeth">Frequently Asked Questions</a>
                            </li>
                            <li>
                                <a rel="nofollow" href="/cruelty-free" title="Leaping Bunny Cruelty-Free Certification">CRUELTY FREE CERTIFICATION</a>
                            </li>
                            <!--<li>
                                <a rel='nofollow' href="/product/sensitive-teeth-gel" title="Desensitizing Gel For Teeth Whitening by Smile Brilliant">Returns &amp; Exchanges</a>
                            </li>-->
                            <li>
                                <a rel="nofollow" href="/articles" title="Articles About Teeth Whitening Science &amp; Dental Care">Science &amp; Articles</a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item">
                        <a href="/contact" rel="nofollow" title="Contact the Best Teeth Whitening Company on the Planet :)">CONTACT</a>
                    </li>
                    <li class="nav-item">
                        <a href="/about-us" rel="nofollow" title="Teeth Whitening For Everyone">ABOUT</a>
                    </li>
                </ul>



                <div class="secondary-area-mbt">
                    <div id="quick_cartt">
                        <a rel="nofollow"  id="dropdownMenuCart">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                            <span class="float_count"></span>
                        </a>
                    </div>
                    <?php
                    if (!is_checkout()) {
//                    woocommerce_mini_cart();
                    }

                    do_action('thb_secondary_area');
                    ?>

                <div class="user-login">
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('My Account', ''); ?>">
                        <i class="fa fa-user-o" aria-hidden="true"></i>

                      <!--   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="lnr-user" viewBox="0 0 1024 1024" width="100%" height="100%"><title>user</title><path class="path1" d="M486.4 563.2c-155.275 0-281.6-126.325-281.6-281.6s126.325-281.6 281.6-281.6 281.6 126.325 281.6 281.6-126.325 281.6-281.6 281.6zM486.4 51.2c-127.043 0-230.4 103.357-230.4 230.4s103.357 230.4 230.4 230.4c127.042 0 230.4-103.357 230.4-230.4s-103.358-230.4-230.4-230.4z"></path><path class="path2" d="M896 1024h-819.2c-42.347 0-76.8-34.451-76.8-76.8 0-3.485 0.712-86.285 62.72-168.96 36.094-48.126 85.514-86.36 146.883-113.634 74.957-33.314 168.085-50.206 276.797-50.206 108.71 0 201.838 16.893 276.797 50.206 61.37 27.275 110.789 65.507 146.883 113.634 62.008 82.675 62.72 165.475 62.72 168.96 0 42.349-34.451 76.8-76.8 76.8zM486.4 665.6c-178.52 0-310.267 48.789-381 141.093-53.011 69.174-54.195 139.904-54.2 140.61 0 14.013 11.485 25.498 25.6 25.498h819.2c14.115 0 25.6-11.485 25.6-25.6-0.006-0.603-1.189-71.333-54.198-140.507-70.734-92.304-202.483-141.093-381.002-141.093z"></path></svg> -->
                    </a>
                </div>   

                </div>




            </div>
        </div>
    </nav>




</header>
                </div>


<?php
if(is_front_page()){
    //get_template_part( 'inc/templates/sale/home/home-section-top' );
}
 ?>
 <?php
if(is_front_page()){
    //get_template_part( 'inc/templates/sale/home/header-valentine-day-sale-section-top' );
}
 ?>

<?php
if(is_front_page()){
    //get_template_part( 'inc/templates/sale/home/mother-day-sale-section-top' );
}
 ?>
 <?php
if (is_front_page()) {
	//get_template_part('inc/templates/sale/home/father-day-sale-section-top');
}
?>
 <?php
if (is_front_page()) {
	//get_template_part('inc/templates/sale/home/indenpendence-day-sale-top');
}
?>
