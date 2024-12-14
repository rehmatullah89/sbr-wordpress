<?php
	$footer_classes[] = 'footer';
	$footer_classes[] = ot_get_option( 'footer_color', 'light' );
	$footer_classes[] = 'footer-full-width-' . ot_get_option( 'footer_full_width', 'off' );
?>




<!-- Start Footer -->
<footer id="footer" class="<?php echo esc_attr( implode( ' ', $footer_classes ) ); ?>">
	<div class="subscribe-newsletter">
		<div class="container ">
		<div class="row max_width">
			<div class="small-12 medium-6 columns">
				<h4 id="footer-newsletter-title">SUBSCRIBE TO OUR NEWSLETTER</h4>
			</div>
			<div class="small-12 medium-6 columns">
				<div class="justify-right">
<!-- 				<form>
					<div class="mbt-flex">
						<input id="" class="form-control input" type="text" value="" placeholder="Your E-Mail Address" name="">
						<button id="" onclick="" class="btn btn-primary-orange btn-sm">JOIN</button>					
				</div>
				</form> -->
                                   
                                    <div class="klaviyo-form-YyaC47"></div>
                                    
			</div>
			</div>
		</div>
		</div>
	</div>


	<?php do_action( 'thb_footer_logo' ); ?>
	<?php do_action( 'thb_page_content', apply_filters( 'thb_footer_page_content', ot_get_option( 'footer_top_content' ) ) ); ?>
	<div class="row footer-row footer-mbt-tp">
		<?php do_action( 'thb_footer_columns' ); ?>
	</div>



</footer>
<!-- End Footer -->
