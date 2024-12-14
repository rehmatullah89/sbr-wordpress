<?php
$logo = ot_get_option('logo', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo.png');
$logo_light = ot_get_option('logo_light', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo-light.png');
$header_style = ot_get_option('header_style', 'style1');
$mobile_menu_footer = ot_get_option('mobile_menu_footer');

$class[] = 'style2';
$class[] = ot_get_option('mobile_menu_color', 'light');
?>
<!-- Start Content Click Capture -->
<div class="click-capture"></div>
<!-- End Content Click Capture -->
<!-- Start Mobile Menu -->
<nav id="mobile-menu" class="<?php echo esc_attr(implode(' ', $class)); ?> add"
	data-behaviour="<?php echo esc_attr(ot_get_option('submenu_behaviour', 'thb-submenu')); ?>">

	<a href="javascript:;" class="mobile-burger-menu-nav mobile-nav-backbutton">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>//assets/images/navigation-icons/back_icon_v2.svg"
			alt="" />
	</a>


	<a class="thb-mobile-close">
		<div><span></span><span></span></div>
	</a>
	<div class="menubg-placeholder"></div>
	<div class="custom_scroll" id="menu-scroll">

		<!--                 <div id="quick_cartt">
				<a rel="nofollow"  id="dropdownMenuCart">
					<i class="fa fa-shopping-cart fa-lg"></i>
					<span class="float_count">5</span>
				</a>
			</div> -->


		<div class="mobile-menu-top">

			<div class="alreadyMemberAccount">
				<?php if (is_user_logged_in()) {
					?>
					<div class="memeberMyAccount text-right">
						<a href="/my-account/">
							<i class="fa fa-user-o" aria-hidden="true"></i>
							My Account
						</a>
					</div>
					<?php
				} else {
					?>
					<div class="memeberLink">
						<a href="/my-account/">
							already a customer?
						</a>
					</div>
					<?php
				} ?>
			</div>

			<?php do_action('thb_language_switcher_mobile'); ?>
			<?php do_action('thb_mobile_search'); ?>
			<?php get_template_part('inc/templates/header/mobile-menu'); ?>
			<!-- <div id="friendbuyoverlay" class="test mobileRibbon"> Get $25</div> -->
		</div>
		<div class="mobile-menu-bottom">
			<?php get_template_part('inc/templates/header/mobile-menu-secondary'); ?>
			<?php if ($mobile_menu_footer) { ?>
				<div class="menu-footer">
					<?php echo do_shortcode($mobile_menu_footer); ?>
				</div>
			<?php } ?>
			<?php do_action('thb_social_links', ot_get_option('mobile_menu_social_link'), false, true); ?>
		</div>
		<style>
			.logged-in .memeberMyAccount i.fa-user-o:before {
				content: "\f007";
			}

			@media (max-width: 767px) {
				#friendbuyoverlaySite {
					display: none !important;
				}

				div#friendbuyoverlay {
					top: 10px;
					text-align: right;
					padding: 8px 30px;
					width: 100%;
					/* background-image: url(https://www.smilebrilliant.com/wp-content/uploads/2022/08/get-25img.png); */

				}

			}
		</style>
	</div>
</nav>
<!-- End Mobile Menu -->