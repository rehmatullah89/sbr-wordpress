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


<?php //get_template_part( 'inc/templates/sale/header/header-section-top' ); 
?>

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
					<img src="<?php echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php bloginfo('name'); ?>" />
					<img src="<?php echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php bloginfo('name'); ?>" />
				</a>
			</div>
			<?php
			add_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10, 2);
			get_template_part('inc/templates/header/full-menu');
			remove_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10);
			?>
			<div class="secondary-area-mbt">
				<div id="quick_cartt">
					<a rel="nofollow" id="dropdownMenuCart">
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
				<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('My Account', ''); ?>">
					<i class="fa fa-user-o" aria-hidden="true"></i>

					<!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="lnr-user" viewBox="0 0 1024 1024" width="100%" height="100%"><title>user</title><path class="path1" d="M486.4 563.2c-155.275 0-281.6-126.325-281.6-281.6s126.325-281.6 281.6-281.6 281.6 126.325 281.6 281.6-126.325 281.6-281.6 281.6zM486.4 51.2c-127.043 0-230.4 103.357-230.4 230.4s103.357 230.4 230.4 230.4c127.042 0 230.4-103.357 230.4-230.4s-103.358-230.4-230.4-230.4z"></path><path class="path2" d="M896 1024h-819.2c-42.347 0-76.8-34.451-76.8-76.8 0-3.485 0.712-86.285 62.72-168.96 36.094-48.126 85.514-86.36 146.883-113.634 74.957-33.314 168.085-50.206 276.797-50.206 108.71 0 201.838 16.893 276.797 50.206 61.37 27.275 110.789 65.507 146.883 113.634 62.008 82.675 62.72 165.475 62.72 168.96 0 42.349-34.451 76.8-76.8 76.8zM486.4 665.6c-178.52 0-310.267 48.789-381 141.093-53.011 69.174-54.195 139.904-54.2 140.61 0 14.013 11.485 25.498 25.6 25.498h819.2c14.115 0 25.6-11.485 25.6-25.6-0.006-0.603-1.189-71.333-54.198-140.507-70.734-92.304-202.483-141.093-381.002-141.093z"></path></svg> -->
				</a>
			</div>

		</div>
	</div>

</header>
<div class="saleParentWrapper">
	<?php
	$start_time_ticker = '2022-10-24 02:00:00';
	$end_time_ticker = '2022-11-01 02:00:00';
	$dealalerttext_secondary = isset($GLOBALS["deal-alert-text-secondary"]) ? $GLOBALS["deal-alert-text-secondary"] : '';
	if (time() > strtotime($start_time_ticker) && time() < strtotime($end_time_ticker)) {
		$deal_alert_text_wrap_style = '';
		$deal_alert_on_click = '';
		$deal_alert_text_primary = " Prime Day";
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
				background: #fc9a18;
				height: 50px;
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
				margin-right: 10px;
				margin-left: 1px;
			}

			span.parentSpan {
				/* margin-top: 5px; */
				position: relative;
				display: flex;
				/* flex-direction: column; */
				align-items: center;
				min-width: 30px;
				min-width: 60px;
				/* font-family: 'Montserrat', sans-serif; */
				font-family: Open Sans;
				font-weight: 400;
				color: #fff;
				font-size: 20px;
				padding-left: 3px;
				padding-right: 3px;

			}
		</style>
		<style type='text/css'>
			.deal-top-bar .container {
				text-align: center;
			}

			/*
			span.deal-right-text, .deal-left-text {
				 padding-top: 14px; 
			}*/
			.bodoDealsText {
				text-transform: uppercase;
				font-weight: 800;
			}

			.deal-left-text {
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;
				/* font-size: 20px; */

			}

			span.deal-left-text {
				font-weight: 600;
				margin-right: 20px;
			}

			span.site-widetext span {
				font-size: 140%;
				font-family: Open Sans;
			}

			.deal-top-bar p,
			.deal-top-bar span {
				font-size: 18px;
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
				/* background-color: #fcfefc; */
				/* color: #ffa488; */
				color: #fff;
				/* font-size: 16px;
				padding-left: 3px;
				padding-right: 3px;
				height: 22px; */
				/* display: block; */
				display: flex;
				align-items: center;
				justify-content: center;
			}

			#deal-seconds {
				min-width: 29px;
			}

			/*
			span.deal-time-colon {
				 text-transform: uppercase;
				font-size: 9px;
				color: #fce0d7; 
			}
*/
			span.dotsSeprator {
				display: inline-block;
				padding-left: 6px;
				padding-right: 4px;
				color: #fff;
				position: relative;
				top: -3px;
				display: none;

			}

			.deal-top-bar a.btn {
				/* background-color: #ffc91a;
				border-color: #ffc91a;
				height: 26px;
				padding: 2px 18px;
				letter-spacing: 0;
				margin-left: 15px;
				margin-top: -6px;
				color: #565759; */

				background-color: #8989ab;
				border-color: #8989ab;
				height: 24px;
				padding: 4px 18px;
				letter-spacing: 0;
				margin-right: 26px;
				margin-top: 0px;
				color: #fff;
				margin-right: 15px;
				line-height: 1;
				font-size: 14px;
				font-weight: 500;
				margin-top: -8px;

			}

			.deal-top-bar a.btn:hover {
				background-color: #fff;
				border-color: #fff;
				color: #1e2c53;
			}

			.flex-div-innerleft {
				text-align: left;
			}

			.bogoDealFace {
				/* position: relative;
				top: -5px; */
				margin-top: -6px;
				margin-right: 15px;
			}

			.curlyBrackets {
				position: relative;
			}

			.curlyBrackets:before {
				position: relative;
				content: "[";
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;
				font-size: 18px;
			}

			.curlyBrackets:after {
				position: relative;
				content: "]";
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;
				font-size: 18px;
			}

			.textReamining {
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;
				font-size: 20px;
				display: inline-block;
				margin-left: 5px;
			}

			.add_to_cart_button.ajax_add_to_cart.added-to-cart {
				pointer-events: none;
				cursor: default;
				opacity: 0.6;
			}

			.site-widetext {
				/* font-size: 20px; */

			}

			@media(min-width:100px) {
				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:430px) {

				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:500px) {

				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:660px) {
				<?php if ($dealalerttext_secondary != '') { ?>.jord-page-content {
					padding-top: 87px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 62px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}



				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

				/* adjust top alignment  impact header counter	 */
				.post-content.no-vc,
				.post-172 h1.vc_custom_heading.full-larger-heading,
				.page-id-130 .post-130 {
					margin-top: 50px;
				}

				.page-template-faqs h1#contactFormTitle {
					margin-top: 130px;
				}

				/* adjust top alignment  impact header counter Ends	 */


			}

			@media(min-width:768px) {
				<?php if ($dealalerttext_secondary != '') { ?>.jord-page-content {
					padding-top: 68px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 43px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}

				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

				.onlyMobile {
					display: none !important;
				}
			}


			@media(min-width:992px) {
				<?php if ($dealalerttext_secondary != '') { ?>.jord-page-content {
					padding-top: 88px;
				}

				<?php } else { ?>.jord-page-content {
					padding-top: 58px;
				}

				<?php } ?>.deal-top-bar .container {
					text-align: center;
				}

				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}

			}

			@media(min-width:1200px) {

				.deal-center-break {
					<?php if ($dealalerttext_secondary != '') { ?>display: block;
					line-height: 0;
					<?php } else { ?>display: none;
					<?php } ?>
				}


			}

			@media(min-width:813px) {
				.deal-top-bar .flex-div {
					align-items: center;
				}

				.page-id-192 #wrapper div[role="main"],
				.postid-192 #wrapper div[role="main"] {
					padding-top: 67px;
				}

				.mobile-text-banner {
					display: none;
				}
			}

			@media(max-width:812px) {
				.deal-top-bar .container>.flex-div {
					/* flex-direction: column;
					position: relative; */
				}

				.deal-top-bar .flex-div {
					justify-content: flex-start;
					justify-content: space-evenly;
				}

				.deal-top-bar {
					height: 50px;
					padding-top: 11px;
				}

				.deal-time-span {
					/* font-size: 16px;
					height: 24px; */
				}

				span.parentSpan {
					margin-top: 0px;
				}

				span.dotsSeprator {
					padding-left: 4px;
					top: 2px;
				}

				.hiddenmobile {
					display: none !important;
				}

				span.parentSpan {
					min-width: 28px;
				}

				.deal-top-bar a.btn {
					margin-top: 0px;
					/* display: none; */
				}

				.deal-left-text {
					margin-bottom: 3px;
					display: inline-block;
					margin-top: 3px;
				}

				.fixed-header-on .header {
					top: 60px;
					background-color: rgba(238, 247, 244, 0.6);
					transition: all .4s;
					border-bottom: 1px solid rgba(255, 255, 255, 0.25);
				}

				.home .post-content.no-vc {
					margin-top: 0px;
				}

				.post-content.no-vc {
					margin-top: 60px;
				}

				.flex-div-innerright.flex-div {
					/* justify-content: start;
					padding-left: 15px; */
				}

				.deal-top-bar a.btn {
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
					padding-left: 7px;
				}

				.woocommerce-checkout.woocommerce-page #wrapper div[role="main"] {
					margin-top: 134px;
				}

				.woocommerce-checkout.woocommerce-page .post-content.no-vc {
					margin-top: 3px;
				}

				.bogoDealFace,
				.textReamining {
					display: none !important;
				}

				.onlyDesktop {
					display: none !important;
				}

				.deal-left-text,
				span.parentSpan {
					font-size: 14px;
					font-size: 3.6vw;
				}

				.deal-top-bar a.btn {
					right: 4px;
					top: 11px;
					font-size: 11px;
					max-width: 86px;
					height: 28px;
					position: static;
					max-width: 90px;
				}

				.curlyBrackets {
					max-height: 25px;
				}

			}

			@media(max-width:812px) {
				.hide-mobile-section {
					display: none;
				}

				.mobile-text-banner {
					font-family: Open Sans;
					font-size: 16px;
					color: #fff;
					font-weight: bold;
				}

				.deal-top-bar {
					height: 60px;
					padding-top: 6px;
				}

				.deal-top-bar p,
				.deal-top-bar span {
					font-size: 16px;
				}

				.deal-top-bar .flex-div {
					max-width: 370px;
					margin-left: auto;
					margin-right: auto;
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
				<span class='deal-left-text'><?php //echo $deal_alert_text_primary; 
												?></span>

				<span class='deal-right-text'> <?php //echo $deal_alert_text_secondary; 
												?></span> -->



				<div class="mobile-text-banner">Halloween Sale</div>

				<div class="flex-div ">

					<div class="flex-div-innerleft max-heightForMobile hide-mobile-section">

						<span class='deal-left-text '>

							<!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/world-smile-day-sale-2022/bogo-face-header-top.jpg);" alt="" class="bogoDealFace"> -->
							<!-- <span class="bodoDealsText"><span style="color:#ffc91a;">Bogo</span> Deals</span><span class="onlyMobile"> & MORE</span> -->
							<span class="site-widetext">
								<span>Halloween Sale</span></span>

							<?php //echo $deal_alert_text_primary; 
							?>
						</span>
						<!-- <span class='deal-center-break'><br /></span> -->
						<span class='deal-right-text' style="display:none;"> <?php echo $deal_alert_text_secondary; ?><span class="hiddenmobile">:</span></span>
						<a class="btn btn-primary-orange onlyDesktop" href="/sale">SHOP DEALS</a>

					</div>

					<div class="flex-div-innerright flex-div curlyBrackets">

						<?php
						if ($deal_alert_enabled_ticker  == true) {
						?>
							<div class='deal-time-break'></div>
							<span class='deal-time-bracket'>&nbsp;[</span>
							<span class="parentSpan">
								<span id="deal-days" class='deal-time-span daysonly'></span>
								<span class='deal-time-colon daysonly'>days</span>
							</span>
							<span class="dotsSeprator">:</span>
							<span class="parentSpan">
								<div clas="flexItem">
									<span id="deal-hours" class='deal-time-span' style=''></span>
								</div>
								<span class='deal-time-colon'>hrs</span>
							</span>
							<span class="dotsSeprator">:</span>
							<span class="parentSpan">
								<div clas="flexItem">
									<span id="deal-minutes" class='deal-time-span' style=''></span>
								</div>
								<span class='deal-time-colon'>mins</span>
							</span>
							<span class="dotsSeprator">:</span>
							<span class="parentSpan">
								<span id="deal-seconds" class='deal-time-span' style=''></span>
								<span class='deal-time-colon'>sec</span>
							</span>
							<span class='deal-time-bracket'>]</span>
						<?php
						}
						?>



					</div>
					<!-- <span class="textReamining">remaining</span> -->
					<a class="btn btn-primary-orange onlyMobile" href="/sale">SHOP DEALS</a>

				</div>
			</div>
		</div>
	<?php } ?>



	<header id="sbr-header" class="sbr-header-mbt header dark-header headroom headroom--top headroom--not-bottom">


		<nav class="navbar navbar-expand-lg navbar-dark navbar navbar-fixed-top navbar-standard row">


			<div class="collapse navbar-collapse justify-content-between" id="navbarToggle">

				<ul class="nav navbar-nav navbar-left">
					<li class="nav-item" id="navWhitening">
						<a class="nav-link active" href="#" rel="nofollow">Whitening <span class="caret"></span></a>

						<ul class="dropdown-menu">
							<li class="headingNav">
								Best Teeth Whitening
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/stain-concealer/" title="NEW! DENTAL STAIN CONCEALER">
									<div class="lpParnt"><span style="color:#e4a18b">NEW!</span> DENTAL STAIN CONCEALER</div>
									<div class="lpChild">Purple Toothpaste Stain Concealer</div>
								</a>
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/teeth-whitening-trays" title="Teeth Whitening Trays (Custom-Fitted) Kit">
									<div class="lpParnt">CUSTOM WHITENING TRAYS</div>
									<div class="lpChild">Complete Whitening Trays & Gel System</div>
								</a>
							</li>
							<li class="navItem">
								<a rel="nofollow" href="/product/teeth-whitening-gel" title="Teeth Whitening Gel">
									<div class="lpParnt">WHITENING GEL REFILLS</div>
									<div class="lpChild">Professional Strength Teeth Whitening Gel</div>
								</a>
							</li>
							<li class="navItem">
								<a rel="nofollow" href="/product/sensitive-teeth-gel" title="Desensitizing Gel For Teeth Whitening">
									<div class="lpParnt">DESENSITIZING GEL REFILLS</div>
									<div class="lpChild">Remineralization & Tooth Sensitivity Gel</div>
								</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/retainer-cleaner/" title="Cleaning Tablets for Night Guards, Whitening Trays, Clear Aligners">Whitening Tray Cleaning Tablets</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#e4a18b">NEW!</span> Ultrasonic Tray Cleaner</a>
							</li>
							<li>
								<a rel="nofollow" href="my-account/" title="Electric Toothbrush">Tray Replacement Reorder</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/enamel-armour/" title="cariPRO™ Enamel Armour for Sensitive Teeth | Smile Brilliant">Enamel Armour™ for Sensitive Teeth</a>
							</li>
							<li>
								<a rel="nofollow" class="oraneText" href="/reviews/" title="Teeth Whitening Reviews">Teeth Whitening Kit Reviews</a>
							</li>
							<li>
								<a rel="nofollow" class="oraneText" href="/teeth-whitening-facts/" title="10 Facts Everyone Should Know About Teeth Whitening">10 Facts About Teeth Whitening</a>
							</li>

							<!-- <li class="inner-sub-menu z-index-greater">
						<a rel="nofollow" href="javascript:void(0);" title="Plaque Highlighters">NEW! Plaque Highlighters</a>
						<ul class="plaque-sub-menu dropdown-menu">
							<li>
								<a rel="nofollow" href="/product/plaque-highlighters/adults" title="Plaque Highlighters For Adults">Plaque Highlighters</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/plaque-highlighters/kids" title="Plaque Highlighters for Kids">Plaque Highlighters for Kids</a>
							</li>

						</ul>
					</li> -->
							<!-- <li class="inner-sub-menu">
						<a rel="nofollow" href="javascript:void(0);" title="Plaque Highlighters">NEW! Dental Probiotics</a>
						<ul class="plaque-sub-menu dropdown-menu">
							<li>
								<a rel="nofollow" href="/product/dental-probiotics/adults" title="Dental Probiotics For Adults">Dental Probiotics</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/dental-probiotics/kids" title="Dental Probiotics for Kids">Oral & Sinus Probiotics for Kids</a>
							</li>
						</ul>
					</li> -->


						</ul>
					</li>
					<li class="nav-item" id="navNightGuards">
						<a rel="nofollow" rel="nofollow" title="">NIGHT GUARDS <span class="caret"></span> </a>
						<ul class="dropdown-menu">
							<li class="headingNav" style="background:#8cc8c7">
								CUSTOM NIGHT GUARDS
							</li>
							<li class="navItem">
								<a rel="nofollow" href="/product/night-guards/" title="Teeth Grinding - Night Guards">
									<div class="lpParnt">CUSTOM NIGHT GUARDS</div>
									<div class="lpChild">Complete Night Guard System</div>
								</a>
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/my-account/" title="Teeth Whitening Gel">
									<div class="lpParnt">REORDER MORE NIGHT GUARDS</div>
									<div class="lpChild">Existing Customer Login for Fast Reorder</div>
								</a>
							</li>

							<li>
								<a rel="nofollow" href="/product/retainer-cleaner" title="Cleaning Tablets for Night Guards, Whitening Trays, Clear Aligners">Night Guard Cleaning Tablets</a>
							</li>

							<li>
								<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#8cc8c7">NEW!</span> Ultrasonic Tray Cleaner</a>
							</li>

							<li>
								<a rel="nofollow" href="/product/enamel-armour" title="cariPRO™ Enamel Armour for Sensitive Teeth | Smile Brilliant"><span style="color:#8cc8c7">NEW!</span> Enamel Building Gel</a>
							</li>


						</ul>

					</li>
					<li class="nav-item" id="navOralCare">
						<a rel="nofollow" rel="nofollow" title="">oral Care <span class="caret"></span> </a>
						<ul class="dropdown-menu">
							<li class="headingNav" style="background:#3599ca">
								ORAL CARE PRODUCTS
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/electric-toothbrush/" title="Electric Toothbrush">
									<div class="lpParnt">ELECTRIC TOOTHBRUSH</div>
									<div class="lpChild">Best Electric Toothbrush Packages</div>
								</a>
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/water-flosser/" title="Water Flosser">
									<div class="lpParnt">CORDLESS WATER FLOSSER</div>
									<div class="lpChild">Award Winning Electric Water Flosser</div>
								</a>
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/dental-probiotics-adults/" title="Dental Probiotics For Adults">
									<div class="lpParnt">DENTAL PROBIOTICS</div>
									<div class="lpChild">Bad Breath. Immune Support. Cavities.</div>
								</a>
							</li>


							<li class="navItem">
								<a rel="nofollow" href="/product/enamel-armour/" title="cariPRO™ Enamel Armour for Sensitive Teeth | Smile Brilliant">
									<div class="lpParnt"><span style="color:#3599ca;">NEW!</span> ENAMEL ARMOUR™</div>
									<div class="lpChild">Rebuilds Enamel & Reduces Sensitivity</div>
								</a>
							</li>

							<li class="navItem">
								<a rel="nofollow" href="/product/plaque-highlighters-adults/" title="Plaque Highlighters For Adults | Smile Brilliant">
									<div class="lpParnt">PLAQUE HIGHLIGHTERS™</div>
									<div class="lpChild">Highlight Plaque & Tartar For Better Brushing</div>
								</a>
							</li>

							<li>
								<a rel="nofollow" href="/product/toothbrush-heads" title="Replacement Toothbrush Heads | Smile Brilliant">Replacement Toothbrush Heads</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/plaque-highlighters-kids" title="Plaque Highlighters for Kids">Plaque Highlighters™ For Kids!</a>
							</li>

							<li>
								<a rel="nofollow" href="/product/dental-probiotics-kids/" title="Dental Probiotics for Kids | Smile Brilliant">Dental Probiotics For Kids!</a>
							</li>
							<li>
								<a rel="nofollow" href="https://www.smilebrilliant.com/product/retainer-cleaner/" title="Cleaning Tablets for Night Guards, Whitening Trays, Clear Aligners">Retainer Cleaning Tablets</a>
							</li>
							<li>
								<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#3599ca;">NEW!</span> Ultrasonic Cleaner</a>
							</li>




						</ul>

					</li>
				</ul>


				<!--   Show this only lg screens and up   -->
				<a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand navbar-center-cell" title="<?php bloginfo('name'); ?>">
					<img src="<?php echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php bloginfo('name'); ?>" />
					<img src="<?php echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php bloginfo('name'); ?>" />
				</a>

				<div class="nav navbar-nav navbar-right right-sidebebar-top">
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a href="/reviews" rel="nofollow" title="Teeth Whitening Reviews">REVIEWS</a>
						</li>
						<li class="nav-item" id="navHelpFull">
							<a rel="nofollow" class="dropdown-toggle">
								HELPFul<span class="caret"></span>
							</a>
							<ul aria-labelledby="menu_item_features-grid" class="dropdown-menu">

								<li class="headingNav" style="background:#555759">
									HELPFUL LINKS
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/teeth-whitening-facts" title="10 Facts Everyone Should Know About Teeth Whitening">
										<div class="lpParnt">10 FACTS ABOUT TEETH WHITENING</div>
										<div class="lpChild">Best Practices for Whitening Teeth</div>
									</a>
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/sensitive-teeth-guide/" title="Causes & Remedies for Sensitive Teeth">
										<div class="lpParnt uppercase">Sensitive Teeth Guide</div>
										<div class="lpChild">Causes & Remedies for Sensitive Teeth</div>
									</a>
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/bad-breath-cause" title="Things You Should Know About Halitosis & Oral Care">
										<div class="lpParnt uppercase">The Science of Bad Breath</div>
										<div class="lpChild">Causes & Remedies for Bad Breath</div>
									</a>
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/oral-probiotics-facts" title="5 Facts You Should Know about Oral Probiotics">
										<div class="lpParnt">5 FACTS ABOUT ORAL PROBIOTICS</div>
										<div class="lpChild">Understanding Oral Micriobiome</div>
									</a>
								</li>
								<li>
									<a rel="nofollow" href="/frequently-asked-questions" title="Frequently Asked Questions About Whitening Teeth or Bleaching Teeth">Frequently Asked Questions</a>
								</li>
								<li>
									<a rel="nofollow" href="/articles" title="Articles About Teeth Whitening Science &amp; Dental Care">Science &amp; Articles</a>
								</li>
								<li>
									<a rel="nofollow" href="/cruelty-free" title="Leaping Bunny Cruelty-Free Certification">Cruelty-Free Certification</a>
								</li>
								<li>
									<a href="/contact" rel="nofollow" title="Contact the Best Teeth Whitening Company on the Planet :)">Contact Us</a>
								</li>

							</ul>
						</li>
						<li class="nav-item" id="navSupport">
							<a href="javascript:;" rel="nofollow" title="Teeth Whitening For Everyone">Support <span class="caret"></span> </a>

							<ul aria-labelledby="menu_item_features-grid" class="dropdown-menu">

								<li class="headingNav" style="background:#555759">
									Support
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/frequently-asked-questions" title="Frequently Asked Questions About Whitening Teeth or Bleaching Teeth">
										<div class="lpParnt uppercase">Frequently Asked Questions</div>
										<div class="lpChild">Commonly Asked Customer Questions</div>
									</a>
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/contact" title="Contact the Best Teeth Whitening Company on the Planet :">
										<div class="lpParnt">CONTACT US</div>
										<div class="lpChild">Contact Form & Phone Number</div>
									</a>
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/about-us" title="Teeth Whitening For Everyone">
										<div class="lpParnt">ABOUT US</div>
										<div class="lpChild">See How it All Began</div>

									</a>
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/guarantee/" title="Teeth Whitening Results Backed by Our Guarantee">
										<div class="lpParnt">GUARANTEE</div>
										<div class="lpChild">We Stand Behind Everything We Sell</div>
									</a>
								</li>

								<li>
									<a href="/reviews" rel="nofollow" title="Teeth Whitening Reviews">Smile Brilliant Product Reviews</a>
								</li>

								<li>
									<a rel="nofollow" href="/cruelty-free" title="Leaping Bunny Cruelty-Free Certification">Cruelty-Free Certification</a>
								</li>

							</ul>



						</li>
					</ul>



					<div class="secondary-area-mbt">
						<div id="quick_cartt">
							<a rel="nofollow" id="dropdownMenuCart">
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
<style>
	div#friendbuyoverlaySite {
		position: fixed;
		left: -34px;
		top: 50%;
		z-index: 9999999;
		background: #3c98cc;
		transform: rotate(90deg);
		padding: 10px 20px;
		color: #fff;
		cursor: pointer;
		text-transform: uppercase;
		font-size: 20px;
		letter-spacing: 0px;
	}



	div#friendbuyoverlay {
		background: #3c98cc;
		padding: 8px 12px;
		color: #fff;
		cursor: pointer;
		text-transform: uppercase;
		letter-spacing: 1px;
		display: inline-block;
		position: relative;
		top: -25px;
	}
</style>

<div id="friendbuyoverlaySite"> Get $25 </div>

<?php
if (is_front_page()) {
	//get_template_part( 'inc/templates/sale/home/home-section-top' );
}
?>
<?php
if (is_front_page()) {
	//get_template_part( 'inc/templates/sale/home/header-valentine-day-sale-section-top' );
}
?>

<?php
if (is_front_page()) {
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
	//get_template_part('inc/templates/sale/home/setptember-prime-day-sale-2022');
}


if (is_front_page()) {
	$sbr_sale =   get_option('sbr_sale');
	if ($sbr_sale == "yes") {
		$sbr_home_sale_page_header =  get_option('sbr_home_sale_page_header');
		if ($sbr_home_sale_page_header) {
			$headerPath = 'inc/templates/sale/home/' . rtrim($sbr_home_sale_page_header, ".php");
			///$sbr_home_sale_page_header = basename($sbr_home_sale_page_header, ".php");
			//$headerPath = 'inc/templates/sale/home/' . $sbr_home_sale_page_header;
			get_template_part($headerPath);
		}
	}
}


if (isset($_COOKIE['subscriber_exclusive_deals_user'])) {
	get_template_part('inc/templates/header/daily-mail-top');
}



?>


<?php
if (is_front_page()) {
	//get_template_part('inc/templates/sale/home/prime-day-sale-2022');
}
?>