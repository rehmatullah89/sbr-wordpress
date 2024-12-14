<?php
$affiliate_id = affwp_get_affiliate_id();
?>
<div id="affwp-affiliate-dashboard-url-generator" class="affwp-tab-content">

	<h4 class="hidden"><?php _e( 'Affiliate URLs', 'affiliate-wp' ); ?></h4>

	<?php
	/**
	 * Fires at the top of the Affiliate URLs dashboard tab.
	 *
	 * @since 2.0.5
	 *
	 * @param int $affiliate_id Affiliate ID of the currently logged-in affiliate.
	 */
	do_action( 'affwp_affiliate_dashboard_urls_top', $affiliate_id );
	?>


	<div class="affiliateIdWrapper">
		<?php if ( 'id' == affwp_get_referral_format() ) : ?>
			<div class="affiliateId">
			<?php
			/* translators: Affiliate ID */
			printf( __( '<div class="genericHeadingPage">Affiliate ID:</div>  <span class="urlText">%s</span>', 'affiliate-wp' ), $affiliate_id );
			?>
			</div>
		<?php elseif ( 'username' == affwp_get_referral_format() ) : ?>
			<div class="affiliateId">
			<?php
			/* translators: Affiliate username */
			printf( __( 'affiliate username: <strong>%s</strong>', 'affiliate-wp' ), affwp_get_affiliate_username() );
			?>
			</div>
		<?php endif; ?>
		
		<div class="yourReferralUrl">
		<div class="alert alert-success clickToCoppy" role="alert">
			URL copy to clipboard
		</div>

		<?php
		/* translators: Affiliate referral URL */
		printf( __( '<div class="genericHeadingPage">Referral URL:</div> <span class="urlText">%s', 'affiliate-wp' ),'<span id="copyrefferalurl" class="font-mont text-blue">'. esc_url( urldecode(affwp_get_affiliate_referral_url()) ).'</span></span>' );
		?>
		 <span >
		<a href="javascript:;" class="copytexticon buttonDefault smallRipple " data-toggle="tooltip" title="Copy To Clipboard">
			Copy URL		
			 <!-- <i class="fa fa-clone" aria-hidden="true" style="font-size: 25px;"></i>  -->
		</a>
			</span>
		</div>

		</div>
	
	<script>
	


jQuery('.copytexticon').click(function() {
       /* Get the text field */
  var copyText = jQuery('#copyrefferalurl').text();

  navigator.clipboard.writeText(copyText);
    });


	jQuery('.copytexticon').click(function() {
		jQuery('.clickToCoppy').addClass("showMessage");
		setTimeout(function() {
			jQuery('.clickToCoppy').removeClass('showMessage');
		}, 4000);

	});

	</script>


	<?php
	/**
	 * Fires just before the Referral URL Generator.
	 *
	 * @since 2.0.5
	 *
	 * @param int $affiliate_id Affiliate ID of the currently logged-in affiliate.
	 */
	do_action( 'affwp_affiliate_dashboard_urls_before_generator', $affiliate_id );
	?>
<div class="refferalGenerator">
	<div class="genericHeadingPage"><?php _e( 'Referral URL Generator', 'affiliate-wp' ); ?></div>
	<p><?php _e( 'Enter any URL from this website in the form below to generate a eferral link!', 'affiliate-wp' ); ?></p>

	<form id="affwp-generate-ref-url" class="affwp-form" method="get" action="#affwp-generate-ref-url">
		<div class="affwp-wrap affwp-base-url-wrap">
			<label for="affwp-url"><?php _e( 'Page URL', 'affiliate-wp' ); ?></label>
			<input type="text" name="url" id="affwp-url" value="<?php echo esc_url( urldecode( affwp_get_affiliate_base_url() ) ); ?>" />
		</div>

		<div class="affwp-wrap affwp-campaign-wrap">
			<label for="affwp-campaign"><?php _e( 'Campaign Name (optional)', 'affiliate-wp' ); ?></label>
			<input type="text" name="campaign" id="affwp-campaign" value="" />
		</div>

		<div class="affwp-wrap affwp-referral-url-wrap" <?php if ( ! isset( $_GET['url'] ) ) { echo 'style="display:none;"'; } ?>>
			<label for="affwp-referral-url"><?php _e( 'Referral URL', 'affiliate-wp' ); ?></label>
			<input type="text" id="affwp-referral-url" value="<?php echo esc_url( urldecode( affwp_get_affiliate_referral_url() ) ); ?>" />
			<div class="description"><?php _e( '(now copy this referral link and share it anywhere)', 'affiliate-wp' ); ?></div>
		</div>

		<div class="affwp-referral-url-submit-wrap">
			<input type="hidden" class="affwp-affiliate-id" value="<?php echo esc_attr( urldecode( affwp_get_referral_format_value() ) ); ?>" />
			<input type="hidden" class="affwp-referral-var" value="<?php echo esc_attr( affiliate_wp()->tracking->get_referral_var() ); ?>" />
			<input type="submit" class="button" value="<?php _e( 'Generate URL', 'affiliate-wp' ); ?>" />
		</div>
	</form>
	</div>

	<?php
	/**
	 * Fires at the bottom of the Affiliate URLs dashboard tab.
	 *
	 * @since 2.0.5
	 *
	 * @param int $affiliate_id Affiliate ID of the currently logged-in affiliate.
	 */
	do_action( 'affwp_affiliate_dashboard_urls_bottom', $affiliate_id );
	?>

</div>
