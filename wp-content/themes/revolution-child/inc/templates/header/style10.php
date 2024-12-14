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
$current_user_id = get_current_user_id();

// Check if the current user has the 'is_shine_user' meta key with value '1'
if (get_user_meta($current_user_id, 'is_shine_user', true) === '1') {
    // If the user has the meta key, link to 'my-account/shine_subscription/'
    $account_link = home_url('/my-account/shine_subscription/');
} else {
    // Otherwise, link to the default 'my-account' page
    $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
}
?>





<header id="mobile-header" class="hidden-desktop <?php echo esc_attr(implode(' ', $header_class)); ?>" data-header-color="<?php echo esc_attr($header_color); ?>" data-fixed-header-color="<?php echo esc_attr($fixed_header_color); ?>">

<div class="navbar-fixed-top-barr">
    <div style="width:25%;background-color:#2d2e2f;font-size:0px;height:8px;">&nbsp;1</div>
    <div style="width:25%;background-color:#fa319e;font-size:0px;;height:8px;">&nbsp;2</div>
    <div style="width:25%;background-color:#4acac9;font-size:0px;;height:8px;">&nbsp;3</div>
    <div style="width:25%;background-color:#f0c23a;font-size:0px;;height:8px;">&nbsp;4</div>
</div>
	<div class="row align-middle header-row">
	<!-- custom-spacing-around -->
		<div class="small-12 columns">

			<div class="logo-holder style10-logo">

			<a href=""  id="back-step" class="go-back-button" title="Back page">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>//assets/images/navigation-icons/back_icon_v2.svg" alt="" />	
				</a>


				<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink" title="<?php bloginfo('name'); ?>">
				<div class="logo-wrap-smilebrilliant">
					<span class="sbr-logo-round">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sbr-logo.webp" alt="" />
					</span>
					<span class="sbr-logo-text">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sbr-logo-text.webp" alt="SmileBrilliant" />
					</span>
				</div>	

					<!-- <img src="<?php //echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php //bloginfo('name'); ?>" />
					<img src="<?php //echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php //bloginfo('name'); ?>" /> -->

				</a>
			</div>
			<?php
			add_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10, 2);
			get_template_part('inc/templates/header/full-menu');
			remove_filter('wp_nav_menu_objects', 'thb_center_nav_menu_items', 10);
			?>
			<div class="combineWrapper">
				<div class="secondary-area-mbt hyhyyhhyyh style10class">


					<?php
					$current_url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$field_value = '';
					if(function_exists('bp_is_active')){
					$field_value = bp_get_profile_field_data(array(
						'field' => 'Referral',
						'user_id' => get_current_user_id(),

					));
				}
					if (wp_is_mobile()) {

						if (is_user_logged_in() && $field_value == '' && strpos($current_url, "my-account") !== false) { ?>
							<div class="rowMbt libellNotification notificationAllUnique">
								<div id="flyout-example">
									<div class="bellNotification">
										<div class="bellWrapper">
											<a href="javascript:;" class="notificationAnchor navLink bellanimate">
												<i class="fa fa-bell" aria-hidden="true"></i><span class="notificationCounter">0</span>
											</a>
											<div class="dropdown-menu dropdown-menu-end notificationCenter">
												<a class="hidden-desktop close" href="JavaScript:void(0);"><span>×</span></a>
												<div class="dropdownHeader">Notifications</div>
												<div id="DZ_W_Notification1" class="widget-media dz-scroll">
													<ul class="timeline">

													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					<?php }
					} ?>

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
				<a href="<?php echo esc_url($account_link); ?>" title="<?php esc_attr_e('My Account', ''); ?>">
						<i class="fa fa-user-o" aria-hidden="true"></i>

						<!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="lnr-user" viewBox="0 0 1024 1024" width="100%" height="100%"><title>user</title><path class="path1" d="M486.4 563.2c-155.275 0-281.6-126.325-281.6-281.6s126.325-281.6 281.6-281.6 281.6 126.325 281.6 281.6-126.325 281.6-281.6 281.6zM486.4 51.2c-127.043 0-230.4 103.357-230.4 230.4s103.357 230.4 230.4 230.4c127.042 0 230.4-103.357 230.4-230.4s-103.358-230.4-230.4-230.4z"></path><path class="path2" d="M896 1024h-819.2c-42.347 0-76.8-34.451-76.8-76.8 0-3.485 0.712-86.285 62.72-168.96 36.094-48.126 85.514-86.36 146.883-113.634 74.957-33.314 168.085-50.206 276.797-50.206 108.71 0 201.838 16.893 276.797 50.206 61.37 27.275 110.789 65.507 146.883 113.634 62.008 82.675 62.72 165.475 62.72 168.96 0 42.349-34.451 76.8-76.8 76.8zM486.4 665.6c-178.52 0-310.267 48.789-381 141.093-53.011 69.174-54.195 139.904-54.2 140.61 0 14.013 11.485 25.498 25.6 25.498h819.2c14.115 0 25.6-11.485 25.6-25.6-0.006-0.603-1.189-71.333-54.198-140.507-70.734-92.304-202.483-141.093-381.002-141.093z"></path></svg> -->
					</a>
				</div>


				
				<div class="mobile-toggle-holder style1">
				<div class="mobile-toggle">
					<span style=""></span><span style=""></span><span style=""></span>
				</div>
			</div>


			<div class="icon-menu-dentist-system mobile-dots-menu" style="display: none;">
					<div class="burgerNav">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>


			</div>

		</div>
	</div>

</header>

<div class="saleParentWrapper">
	<?php
	$start_time_ticker = '2023-11-26 00:00:00';
	$end_time_ticker = '2024-10-11 02:00:00';
	if (time() > strtotime($start_time_ticker) && time() < strtotime($end_time_ticker)) {
		$deal_alert_text_wrap_style = '';
		$deal_alert_on_click = '';
		$deal_alert_text_primary = "Prime Day Sale";
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
				top: 0;
			}

			.deal-top-bar {
				background: #06a3dc;
				height: 56px;
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
				flex-direction: column;
				align-items: center;
				/* min-width: 30px;
				min-width: 60px; */
				/* font-family: 'Montserrat', sans-serif; */
				font-family: Open Sans;
				font-weight: 400;
				color: #fff;
				font-size: 20px;
				/* padding-left: 3px;
				padding-right: 3px; */
				line-height: 1;
				padding-bottom: 10px;
				top: 4px;

			}
		</style>
		<style type='text/css'>
			#solid-color-with-text-section span.deal-time-colon {
				font-size: 18px !important;
				margin-bottom: -15px;
			}
			.deal-top-bar .container {
				text-align: center;
			}

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
				margin-right: 10px;
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
				/* display: block !important; */
			}

			.deal-right-text {
				color: white;
			}


			.deal-center-break {
				display: none;
			}

			.deal-time-span {
				color: #fff;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			#deal-seconds {
				min-width: 29px;
			}

			span.dotsSeprator {
				display: inline-block;
				padding-left: 3px;
				padding-right: 4px;
				color: #fff;
				position: relative;
				top: -1px;
				/* display: none; */

			}

			.home-page #solid-color-with-text-section {
				margin-top: 138px !important;
			}

			.deal-top-bar a.btn {
				/* background-color: #d4545a;
				border-color: #d4545a; */
				height: 34px;
				padding: 4px 18px;
				letter-spacing: 0;
				margin-right: 26px;
				margin-top: 0px;

				color: #fff;
				margin-right: 20px;
				line-height: 0.8;
				font-size: 16px;
				font-weight: 500;
				margin-top: 2px;
				display: flex;
				justify-content: center;
				align-items: center;
				margin-left: 10px;
				margin-top: 0;
				min-width: auto;
				position: relative;
				top: 2px;
				border-radius: 3px;

			}

			.deal-top-bar a.btn:hover {
				background-color: #595858 !important;
				border-color: #595858 !important;
				color: #fff!important;
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
				font-size: 19px;
				opacity: 0;
				display: none;
			}
			span.parentSpan.firstParent {
					/* display: none; */
				}
			.curlyBrackets:after {
				position: relative;
				content: "]";
				font-family: 'Montserrat', sans-serif;
				font-weight: 400;
				color: #fff;
				font-size: 19px;
				opacity: 0;
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

			span.singImage {
				margin-top: -1px;
				display: inline-flex;
			}

			.site-widetext span:not(.singImage) {
				/* font-weight: 800; */
				/* font-size: 26px; */
				/* font-style: italic; */
				font-size: 18px;
				display: inline-flex;
				padding-left: 5px;
				padding-right: 5px;
			}

			span.deal-time-colon {
				font-size: 9px;
				text-transform: uppercase;
				font-weight: 600;
				display: block;
				margin-top: 2px;
				position: absolute;
				bottom: 0;
				color: #ffffffa8;
			}

			span.deal-time-span {
				background: #fff;
				padding: 4px 7px;
				color: #3b95c9;
				width: 100%;
				margin-bottom: 1px;
				min-height: 26px;
				min-width: 30px;    border-radius: 3px;

			}
			.deal-left-text .site-widetext span b{
				color: #ffffff;
			}
			.deal-left-text .site-widetext span b{
				   text-transform: uppercase;
			}

			@media(min-width:768px) {
				.deal-left-text .site-widetext span b{
					position: relative;
					top: 2px;
				}

			}

			.deal-top-bar{
				opacity: 0; /* Initially hidden */
				animation: fadeIn 1s ease-in forwards;
				/* display: none; */
			}
			@keyframes fadeIn {
				from {
					opacity: 0;
				}
				to {
					opacity: 1;
				}
				}
			@media(min-width:768px) {
				.onlyMobile {
					display: none;
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

			@media(max-width:767px) {
				.deal-top-bar {
					position: relative;
					/* top: -20px; */
					padding-left: 5px;
					padding-right: 5px;
				}

				.home-page #solid-color-with-text-section {
					margin-top: 95px !important;
				}

				.deal-top-bar .flex-div {
					justify-content: flex-start;
					justify-content: center;
					max-width: 100% !important;
				}

				.deal-top-bar {
					height: 50px;
					padding-top: 11px;
				}

				.deal-left-text .site-widetext {
					display: flex;
					align-items: center;
				}

				.deal-left-text .site-widetext span b {
					font-size: 12px;
				position: relative;
				text-transform:uppercase;
				top: 5px; 
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
					min-width: 32px;
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
					
					/* top: 60px;
					top: 44px; */
					/* background-color: rgba(238, 247, 244, 0.6); */
					transition: all .4s;
					border-bottom: 1px solid rgba(255, 255, 255, 0.25);
				}

				.home .post-content.no-vc {
					margin-top: 0px;
				}

				.post-content.no-vc {
					margin-top: 60px;
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
					/* padding-left: 7px; */
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
					height: 54px;
					padding-top: 8px;
				}
				

				.deal-top-bar p,
				.deal-top-bar span {
					font-size: 16px;
				}

				.deal-top-bar .flex-div {
					max-width: 370px;
					/* margin-left: auto;
					margin-right: auto; */
				}

				.deal-top-bar a.btn {
					margin-right: 0px;
					font-size: 11px;
					padding: 3px 8px;
					height: 35px;
					position: relative;
   					 top: 0;
					 max-width: initial;
					 border-radius:3px;
					 font-weight:600;
				}

				span.deal-left-text {
					margin-right: 10px;
				}

				span.parentSpan.lastParent {
					/* display: none; */
				}

				.site-widetext span:not(.singImage) {
					padding-left: 2px;
					font-size: 16px;
					padding-right: 2px;
				}

				.deal-top-bar p,
				.deal-top-bar span {
					font-size: 14px;
				}

				span.singImage {
					margin-top: 0px;
				}

				span.deal-time-colon {
					position: static;
				}

				.site-widetext span:not(.singImage) {
					padding-left: 0px;
					font-size: 14px;
					padding-right: 0px;
				}

				span.deal-time-colon {
					font-size: 8px !important;
				}

				span.parentSpan {
					top: 0px;
				}

			}


			@media(max-width:812px) {
				.onlyDesktop {
					display: none;
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
				var daysSpan = jQuery('body').find('.curlyBrackets .deal-days');
				var hoursSpan = jQuery('body').find('.curlyBrackets .deal-hours');
				var minutesSpan = jQuery('body').find('.curlyBrackets .deal-minutes');
				var secondsSpan = jQuery('body').find('.curlyBrackets .deal-seconds');

				function n__updateDealClock() {
					var t = n__getDealTimeRemaining(endtime);
					//	console.log(t);
					if (t.days == 0) {
						jQuery('body').find('.curlyBrackets .firstParent').hide();
					}
					if (t.days > 9) {
						daysSpan.html(t.days);
					} else {
						daysSpan.html('0' + t.days);
					}
					if (t.hours > 9) {
						hoursSpan.html(t.hours);
					} else {
						hoursSpan.html('0' + t.hours);
					}
					if (t.minutes > 9) {
						minutesSpan.html(t.minutes);
					} else {
						minutesSpan.html('0' + t.minutes);
					}
					if (t.seconds > 9) {
						secondsSpan.html(t.seconds);
					} else {
						secondsSpan.html('0' + t.seconds);
					}
					if (t.total <= 0) {
						clearInterval(timeinterval);
					}
				}

				n__updateDealClock();
				var timeinterval = setInterval(n__updateDealClock, 1000);
			}

			function n__initializeDealClock_bk(endtime) {
				var daysSpan = jQuery('body').find('.curlyBrackets .deal-days');
				var hoursSpan = jQuery('body').find('.curlyBrackets .deal-hours');
				var minutesSpan = jQuery('body').find('.curlyBrackets .deal-minutes');
				var secondsSpan = jQuery('body').find('.curlyBrackets .deal-seconds');

				function n__updateDealClock() {
					var t = n__getDealTimeRemaining(endtime);

					if (t.days < 1) {
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
					if (t.days >= 1) {
						if (t.days < 10) {
							daysSpan.html('0' + t.days).slice(-2);
						} else {
							daysSpan.html(t.days).slice(-2);
						}
						if (t.hours < 10) {
							hoursSpan.html('0' + t.hours).slice(-2);
						} else {
							hoursSpan.html(t.hours).slice(-2);
						}
						if (t.minutes < 10) {
							minutesSpan.html('0' + t.minutes).slice(-2);
						} else {
							minutesSpan.html(t.minutes).slice(-2);
						}
						if (t.seconds < 10) {
							secondsSpan.html('0' + t.seconds).slice(-2);
						} else {
							secondsSpan.html(t.seconds).slice(-2);
						}
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



				<!-- <div class="mobile-text-banner">BLACK FRIDAY SALE</div> -->

				<div class="flex-div ">

					<div class="flex-div-innerleft max-heightForMobile">

						<span class='deal-left-text '>

							<!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/world-smile-day-sale-2022/bogo-face-header-top.jpg);" alt="" class="bogoDealFace"> -->
							<!-- <span class="bodoDealsText"><span style="color:#ffc91a;">Bogo</span> Deals</span><span class="onlyMobile"> & MORE</span> -->

							<!--new year sale header-->
							<span class="site-widetext">
								 <!-- <span style="background-color: #3c97cb;border-radius: 6px;font-weight: bold;font-style: italic;">Extended</span> -->
								<span><b>Prime Day Sale <span class="hidden-mobile">Ends:</span></b>
									
								</span>
							</span>

							<?php //echo $deal_alert_text_primary; 
							?>
						</span>
						<!-- <span class='deal-center-break'><br /></span> -->
						<span class='deal-right-text' style="display:none;"> <?php echo $deal_alert_text_secondary; ?><span class="hiddenmobile">:</span></span>
						<!-- <a class="btn btn-primary-orange hidden-mobile" style="background-color:#f7a18a;border-color:#f7a18a" href="/sale">SEE DEALS</a> -->

					</div>
					<!--new year sale header end-->

					<!-- <div class="saleDealButton hidden-desktop">
						<a class="btn btn-primary-orange" href="/sale">SEE DEALS</a>
					</div> -->

					<div class="flex-div-innerright flex-div curlyBrackets">

						<?php
						if ($deal_alert_enabled_ticker  == true) {
						?>
							<div class='deal-time-break'></div>
							<span class='deal-time-bracket'>&nbsp;[</span>
							<span class="parentSpan firstParent">
								<span class='deal-days deal-time-span daysonly'></span>
								<span class='deal-time-colon daysonly'>days</span>
							</span>
							<span class="dotsSeprator">:</span>
							<span class="parentSpan centerParent">
								<div clas="flexItem">
									<span class=' deal-hours deal-time-span'></span>
								</div>
								<span class='deal-time-colon'>hrs</span>
							</span>
							<span class="dotsSeprator ">:</span>
							<span class="parentSpan lastParent">
								<div clas="flexItem">
									<span class='deal-minutes deal-time-span'></span>
								</div>
								<span class='deal-time-colon'>mins</span>
							</span>
							<span class="dotsSeprator" style="display:none;">:</span>
							<span class="parentSpan" style="display:none;">
								<span class=' deal-seconds deal-time-span'></span>
								<span class='deal-time-colon'>sec</span>
							</span>
							<span class='deal-time-bracket'>]</span>
						<?php
						}
						?>



					</div>
					<a class="btn btn-primary-orange" style="background-color:#263c46;border-color:#263c46;" href="/sale">SHOP DEALS</a>


				</div>
			</div>
		</div>
	<?php } ?>



	<header id="sbr-header" class="sbr-header-mbt header dark-header headroom headroom--top headroom--not-bottom">
	<div class="navbar-fixed-top-barr">
    <div style="width:25%;background-color:#2d2e2f;font-size:0px;height:8px;">&nbsp;1</div>
    <div style="width:25%;background-color:#fa319e;font-size:0px;;height:8px;">&nbsp;2</div>
    <div style="width:25%;background-color:#4acac9;font-size:0px;;height:8px;">&nbsp;3</div>
    <div style="width:25%;background-color:#f0c23a;font-size:0px;;height:8px;">&nbsp;4</div>
</div>

		<nav class="navbar navbar-expand-lg navbar-dark navbar navbar-fixed-top navbar-standard row full-header ddd">


		<div class="header-wrapper-smilebrilliant">

			<!--   Show this only lg screens and up   -->
			<a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand navbar-center-cell" title="<?php bloginfo('name'); ?>">
				<div class="logo-wrap-smilebrilliant">
					<span class="sbr-logo-round">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sbr-logo.webp" alt="" />
					</span>
					<span class="sbr-logo-text">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sbr-logo-text.webp" alt="SmileBrilliant" />
					</span>
					<!-- <img src="<?php //echo esc_url($logo); ?>" class="logoimg logo-dark" alt="<?php //bloginfo('name'); ?>" /> -->
					<!-- <img src="<?php //echo esc_url($logo_light); ?>" class="logoimg logo-light" alt="<?php //bloginfo('name'); ?>" /> -->
				</div>					

			</a>

				<div class="collapse navbar-collapse " id="navbarToggle">
					<ul class="nav navbar-nav navbar-left">


					<li class="nav-item" id="navCustomTraysGuards">
							<a class="nav-link" href="#" rel="nofollow">CUSTOM TRAYS & GUARDS <span class="caret"><i class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
							<ul class="dropdown-menu">
								<li class="headingNav">
									Best TRAYS & GUARDS
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/product/night-guards/" title="Teeth Grinding - Night Guards">
										<div class="lpParnt">CUSTOM NIGHT GUARDS</div>
										<div class="lpChild">Complete Night Guard System</div>
									</a>
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/product/teeth-whitening-trays" title="Teeth Whitening Trays (Custom-Fitted) Kit">
										<div class="lpParnt">CUSTOM WHITENING TRAYS</div>
										<div class="lpChild">Complete Whitening Trays & Gel System</div>
									</a>
								</li>

								<li class="nav-item navItem  sports-guards-nav">
								<a rel="nofollow" href="/product/proshield/" title="Sports Guards">
										<div class="lpParnt">PROSHIELD SPORTS GUARDS</div>
										<div class="lpChild">Custom-fitted Sports Mouth Guards</div>
									</a>
									
								</li>

								<li>
									<a rel="nofollow" href="/product/retainer-cleaner/" title="Cleaning Tablets for Night Guards, Whitening Trays, Clear Aligners"> Tray Cleaning Tablets</a>
								</li>

								<li>
									<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#e4a18b">NEW!</span> Ultrasonic Tray Cleaner</a>
								</li>

							</ul>
						</li>

						<li class="nav-item" id="navWhitening">
							<a class="nav-link active" href="#" rel="nofollow">Teeth whitening <span class="caret"><i class="fa fa-chevron-down" aria-hidden="true"></i>
</span></a>
							<ul class="dropdown-menu">
								<li class="headingNav" style="background:#fa319e;">
									Best Teeth Whitening
								</li>


								<li class="navItem">
									<a rel="nofollow" href="/product/teeth-whitening-trays" title="Teeth Whitening Trays (Custom-Fitted) Kit">
										<div class="lpParnt">CUSTOM WHITENING TRAYS</div>
										<div class="lpChild">Complete Whitening Trays & Gel System</div>
									</a>
								</li>

								<li class="navItem">
									<a rel="nofollow" href="/product/stain-concealer/" title="NEW! DENTAL STAIN CONCEALER">
										<div class="lpParnt"><span style="color:#fa319e">NEW!</span> DENTAL STAIN CONCEALER</div>
										<div class="lpChild">Purple Toothpaste Stain Concealer</div>
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
									<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#fa319e">NEW!</span> Ultrasonic Tray Cleaner</a>
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

							</ul>
						</li>

						<!-- hidden item -->
						<li class="nav-item" id="navNightGuards" style="display: none;">
							<a rel="nofollow" rel="nofollow" title="">NIGHT GUARDS <span class="caret"><i class="fa fa-chevron-down" aria-hidden="true"></i>
</span> </a>
							<ul class="dropdown-menu">
								<li class="headingNav" style="background:#331f97">
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
									<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#331f97">NEW!</span> Ultrasonic Tray Cleaner</a>
								</li>

								<li>
									<a rel="nofollow" href="/product/enamel-armour" title="cariPRO™ Enamel Armour for Sensitive Teeth | Smile Brilliant"><span style="color:#331f97">NEW!</span> Enamel Building Gel</a>
								</li>


							</ul>
						</li>
						<!-- hidden item -->						

						<li class="nav-item" id="navOralCare">
							<a rel="nofollow" rel="nofollow" title="">oral Care <span class="caret"><i class="fa fa-chevron-down" aria-hidden="true"></i>
</span> </a>
							<ul class="dropdown-menu">
								<li class="headingNav" style="background:#4acac9">
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
										<div class="lpParnt"><span style="color:#4acac9;">NEW!</span> ENAMEL ARMOUR™</div>
										<div class="lpChild">Rebuilds Enamel & Reduces Sensitivity</div>
									</a>
								</li>

								<li class="navItem" id="plaqe-highlither-nav-menu">
									<a rel="nofollow" href="/product/plaque-highlighters-adults/" title="Plaque Highlighters For Adults | Smile Brilliant">
										<div class="lpParnt">PLAQUE HIGHLIGHTERS™</div>
										<div class="lpChild">Highlight Plaque & Tartar For Better Brushing</div>
									</a>
								</li>
								<li class="navItem">
									<a rel="nofollow" href="/product/dental-floss-picks/" title="Plaque Highlighters For Adults | Smile Brilliant">
										<div class="lpParnt">DENTAL FLOSS PICKS</div>
										<div class="lpChild">U-Shaped Disposable Floss Tool</div>
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
									<a rel="nofollow" href="/product/ultrasonic-cleaner/" title="cariPRO™ Ultrasonic + UV Light Cleaner | Smile Brilliant"><span style="color:#4acac9;">NEW!</span> Ultrasonic Cleaner</a>
								</li>
							</ul>
						</li>

						
						<li class="nav-item skin-care-nav" id="skin-care-nav-item">
							<a href="/product/skincare/" rel="nofollow" title="Skin care"><span style="color: #f0c23a;font-weight: bold;"> NEW!</span>&nbsp;Skin care</a>
						</li>

					</ul>


					<div class="nav navbar-nav navbar-right right-sidebebar-top">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item">
								<a href="/reviews" rel="nofollow" title="Teeth Whitening Reviews">REVIEWS</a>
							</li>

							
							<li class="nav-item" id="navSupport">
								<a href="javascript:;" rel="nofollow" title="Teeth Whitening For Everyone">Support <span class="caret"><i class="fa fa-chevron-down" aria-hidden="true"></i>
</span> </a>

								<ul aria-labelledby="menu_item_features-grid" class="dropdown-menu">

									<li class="headingNav" style="background:#2d2e2f">
										Support
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
										<a href="/contact" rel="nofollow" title="Contact the Best Teeth Whitening Company on the Planet :)">Contact Us</a>
									</li>									
									<li>
										<a rel="nofollow" href="/about-us" title="Teeth Whitening For Everyone">About Us</a>
									</li>
									<li>
										<a rel="nofollow" href="/guarantee/" title="Teeth Whitening Results Backed by Our Guarantee">
										Guarantee
										</a>
									</li>									

									<li>
										<a rel="nofollow" href="/cruelty-free" title="Leaping Bunny Cruelty-Free Certification">Cruelty-Free Certification</a>
									</li>

								</ul>

							</li>
						</ul>



						<div class="secondary-area-mbt oneforDesktop">

							<?php
							$field_value = '';
								if(function_exists('bp_is_active')){
									$field_value = bp_get_profile_field_data(array(
										'field' => 'Referral',
										'user_id' => get_current_user_id(),

									));
								}
							if (!wp_is_mobile()) {

								if (is_user_logged_in() && $field_value == '' && strpos($current_url, "my-account") !== false) { ?>
									<div class="rowMbt libellNotification notificationAllUnique">
										<div id="flyout-example">
											<div class="bellNotification">
												<div class="bellWrapper">
													<a href="javascript:;" class="notificationAnchor navLink bellanimate">
														<i class="fa fa-bell" aria-hidden="true"></i><span class="notificationCounter">0</span>
													</a>
													<div class="dropdown-menu dropdown-menu-end notificationCenter">
														<a class="hidden-desktop close" href="JavaScript:void(0);"><span>×</span></a>
														<div class="dropdownHeader">Notifications</div>
														<div id="DZ_W_Notification1" class="widget-media dz-scroll">
															<ul class="timeline">

															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							<?php }
							} ?>


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
								
								<a href="<?php echo esc_url($account_link); ?>" title="<?php esc_attr_e('My Account', ''); ?>">
									<i class="fa fa-user-o" aria-hidden="true"></i>

									<!--   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="lnr-user" viewBox="0 0 1024 1024" width="100%" height="100%"><title>user</title><path class="path1" d="M486.4 563.2c-155.275 0-281.6-126.325-281.6-281.6s126.325-281.6 281.6-281.6 281.6 126.325 281.6 281.6-126.325 281.6-281.6 281.6zM486.4 51.2c-127.043 0-230.4 103.357-230.4 230.4s103.357 230.4 230.4 230.4c127.042 0 230.4-103.357 230.4-230.4s-103.358-230.4-230.4-230.4z"></path><path class="path2" d="M896 1024h-819.2c-42.347 0-76.8-34.451-76.8-76.8 0-3.485 0.712-86.285 62.72-168.96 36.094-48.126 85.514-86.36 146.883-113.634 74.957-33.314 168.085-50.206 276.797-50.206 108.71 0 201.838 16.893 276.797 50.206 61.37 27.275 110.789 65.507 146.883 113.634 62.008 82.675 62.72 165.475 62.72 168.96 0 42.349-34.451 76.8-76.8 76.8zM486.4 665.6c-178.52 0-310.267 48.789-381 141.093-53.011 69.174-54.195 139.904-54.2 140.61 0 14.013 11.485 25.498 25.6 25.498h819.2c14.115 0 25.6-11.485 25.6-25.6-0.006-0.603-1.189-71.333-54.198-140.507-70.734-92.304-202.483-141.093-381.002-141.093z"></path></svg> -->
								</a>
							</div>

							<div class="icon-menu-dentist-system" style="display: none;">
								<div class="burgerNav">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
							</div>


						</div>




					</div>
				</div>
			</div>

		</nav>




	</header>

</div>




<nav id="main-navigation-mobile" class="main-navigation-mobile">
	<div class="navbar-wrapper-sm-br">
	<a href="/" class="home-nav-item nav-item-smilebrilliant">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/home-icon.svg" alt=""/> 
	</a>

    <a class="user-nav-item nav-item-smilebrilliant" href="/my-account">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/users-icon-v2.svg" alt=""/> 
    </a>




	<span class="cart-nav-item nav-item-smilebrilliant open-min-cart"  id="open-min-cart">		

		<img class="cart-default-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/shopping-cart-icon.svg" alt=""/>		
		<img class="cross-cart-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/cross-icon-nav.svg" alt=""/>		
		
					<div id="quick">
						<a rel="nofollow" id="dropdownMenuCart">
							<span class="float_count"></span>
						</a>
					</div>
						</span>
	<a class="menu-nav-item nav-item-smilebrilliant mobile-burger-menu-nav" href="javascript:;" id="mobile-burger-menu-nav">

		<img class="burgerMenuDefault" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/navigation_icon.svg" alt=""/>
		<img class="cross-cart-icon-burgermenu" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/navigation-icons/cross-icon-nav.svg" alt=""/>		
	</a>
	</div>
</nav>



<style>
	div#friendbuyoverlaySite {
		position: fixed;
		left: -34px;
		top: 50%;
		z-index: 99999;
		background: #3c98cc;
		transform: rotate(90deg);
		padding: 10px 20px;
		color: #fff;
		cursor: pointer;
		text-transform: uppercase;
		font-size: 20px;
		letter-spacing: 0px;
		display: none !important;
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

			$file_name_without_extension = str_replace('.php', '', $sbr_home_sale_page_header);
			$headerPath = 'inc/templates/sale/home/' . $file_name_without_extension;

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