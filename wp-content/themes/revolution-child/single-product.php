<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 
 */

$vc                 = class_exists('WPBakeryVisualComposerAbstract');
$enable_pagepadding = get_post_meta(get_the_ID(), 'enable_pagepadding', true);
$classes[]          = 'on' === $enable_pagepadding ? 'page-padding' : false;
get_header();
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
				<?php the_content(); ?>
			</div>
		<?php } elseif (thb_is_woocommerce()) { ?>
			<div <?php post_class('page-padding'); ?>>
				<!-- <div class="row">
				<div class="small-12 columns"> -->
				<div class="post-content no-vc">
				<?php echo apply_filters('the_content', get_the_content()); ?>
					<!-- </div>
				</div> -->
				</div>
			</div>
		<?php } else { ?>
			<div <?php post_class('page-padding'); ?>>
				<!-- <div class="row">
				<div class="small-12 columns"> -->
				<header class="post-title page-title">
					<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>'); ?>
				</header>
				<div class="post-content no-vc">
				<?php echo apply_filters('the_content', get_the_content()); ?>
					<!-- </div>
				</div> -->
				</div>
			</div>
		<?php } ?>
		<?php if (comments_open() || get_comments_number()) : ?>
			<!-- Start #comments -->
			<?php //comments_template('', true); 
			?>
			<!-- End #comments -->
<?php endif;
	endwhile;
endif;

get_footer();
