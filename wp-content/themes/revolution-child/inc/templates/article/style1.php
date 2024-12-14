<style>
.single-post h2 {
        /* font-weight: 300 !important; */
    color: #4597cb !important;
    font-size: 28px;
}	

footer.article-tags.entry-footer.nav-style-style1 {
    display: none;
}
a.btn.btn-lg {
    font-size: 18px;
}
article h5{
    font-size: 22px;
    line-height: 25px;
    font-family: Montserrat;
    font-weight: 300;
    color: #565759;

} 
.post-detail .post-gallery-detail{ background: #fff;     padding-bottom: 0;    min-height:0vh; padding-top: 9vh;}
.post-detail.style1-detail .post-gallery .post-title .entry-title{ font-size: 42px; line-height: 59px; color: #565759; font-weight: 700 !important; margin: 0;} 
.post-content h1 {
    font-weight: bold;
    font-size: 35px;
    line-height: 39px;
    color: #4597cb;
}
.post-content ul li{
	font-size: 14px; line-height: 20px; 
}

.post-detail .post-content p {
    font-size: 17px;
    padding-top: 5px;
    padding-bottom: 5px;    margin: 0 0 10px;
}
.single.single-post .small-12.medium-10.large-10.columns {
    /* -webkit-box-flex: 0;
    -ms-flex: 100%;
    flex: 100%;
    max-width: 100%; */
}
.single.single-post .small-12.medium-10.large-10.columns .col-xs-12 {
    width: 100%;
}
.page-template-page-templatesreviews-temp-php h2.product-header-sub{

    font-weight: 300;
}

@media (max-width: 767px) {
.post-detail .post-gallery-detail{padding-top: 0vh;}
.post-detail  .header-spacer-force {
    display: none;
}
.post-detail .post-gallery-detail{ min-height: 0px; }
.post-detail.style1-detail .post-gallery .post-title .entry-title {
    font-size: 30px;
    line-height: 38px;
}   

.single.single-post h1{    font-size: 34px !important;
    line-height: 42px;padding-bottom: 40px;} 


}


</style>
<?php
	$article_sidebar     = ot_get_option( 'article_sidebar', 'on' );
	$article_author_name = ot_get_option( 'article_author_name', 'on' );
	$article_date        = ot_get_option( 'article_date', 'on' );
	$article_cat         = ot_get_option( 'article_cat', 'on' );
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class( 'post post-detail style1-detail' ); ?>>
	<?php
	/* The following determines what the post format is and shows the correct file accordingly */
	$format = get_post_format();
	if ( in_array( $format, array( 'gallery', 'video' ), true ) ) {
		get_template_part( 'inc/templates/postformats/' . $format );
	} else {
		get_template_part( 'inc/templates/postformats/standard' );
	}
	?>
	<div class="row align-center">
		<div class="small-12 medium-10 large-10 columns">
			<div class="post-content">
				<?php if ( in_array( $format, array( 'gallery', 'video' ), true ) ) { ?>
				<header class="post-title entry-header animation bottom-to-top-3d">
					<?php if ( 'on' === $article_cat ) { ?>
					<aside class="post-category">
						<?php the_category( ', ' ); ?>
					</aside>
					<?php } ?>
					<?php the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
					<?php if ( 'on' === $article_author_name || 'on' === $article_date ) { ?>
					<aside class="post-meta">
						<?php
						if ( 'on' === $article_author_name ) {
							?>
							<?php the_author_posts_link(); ?> <?php esc_html_e( 'on', 'revolution' ); ?> <?php } ?>
						<?php
						if ( 'on' === $article_date ) {
							?>
							<?php echo get_the_date(); ?><?php } ?>
					</aside>
					<?php } ?>
				</header>
				<?php } ?>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?> 
			</div>
			<?php get_template_part( 'inc/templates/blog/post-tags' ); ?>
		</div>
		<?php
		if ( 'on' === $article_sidebar ) {
			get_sidebar( 'single' ); }
		?>
	</div>
	<?php get_template_part( 'inc/templates/blog/post-end' ); ?>
	<?php do_action( 'thb_postmeta' ); ?>
</article>

<script>

	var myVar = setInterval(myTimer, 500);
	function myTimer() {
	jQuery(document).ready(function() {
  		jQuery('header').removeClass('light-header');
});
	}

</script>

