<?php
$vc                 = class_exists('WPBakeryVisualComposerAbstract');
$enable_pagepadding = get_post_meta(get_the_ID(), 'enable_pagepadding', true);
$classes[]          = 'on' === $enable_pagepadding ? 'page-padding' : false;
?>
<?php
$field_value ='';
  if(function_exists('bp_is_active')){
$field_value = bp_get_profile_field_data(array(
	'field' => 'Referral',
	'user_id' => get_current_user_id(),

));
  }
$sbr_footer_slug = '';
$sbr_header_slug = '';
if((strpos($_SERVER["REQUEST_URI"], 'my-account')  !== false || strpos($_SERVER["REQUEST_URI"], 'members')  !== false ) && is_user_logged_in() ) {
	if ($field_value != '') {
		$sbr_header_slug = 'rdh';
		$sbr_footer_slug = 'rdhprofile';

	}
}
get_header($sbr_header_slug);

?>
<?php
if (have_posts()) :
	while (have_posts()) :
		the_post();
?>
		<?php
		if (post_password_required()) {
			get_template_part('inc/templates/password-protected');
		} elseif ($vc && !thb_is_woocommerce()) {
		?>
			<div <?php post_class($classes); ?>>
				<?php echo apply_filters('the_content', get_the_content()); ?>
			</div>
		<?php } elseif (thb_is_woocommerce()) { ?>
			<div <?php post_class('page-padding'); ?>>
				<div class="row">
					<div class="small-12 columns">
						<div class="post-content no-vc">
							<?php echo apply_filters('the_content', get_the_content()); ?>
						</div>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div <?php post_class('page-padding'); ?>>
				<div class="row">
					<div class="small-12 columns">
						<header class="post-title page-title">
							<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>'); ?>
						</header>
						<div class="post-content no-vc">
							<?php echo apply_filters('the_content', get_the_content()); ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (comments_open() || get_comments_number()) : ?>
			<!-- Start #comments -->
			<?php comments_template('', true); ?>
			<!-- End #comments -->
		<?php endif; ?>
<?php
	endwhile;
endif;
?>
<?php
get_footer($sbr_footer_slug);
