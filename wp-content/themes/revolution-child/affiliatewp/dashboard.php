<?php

$active_tab = affwp_get_active_affiliate_area_tab(); ?>


<div id="affwp-affiliate-dashboard" class="myAccountContainerMbt desktopNoPaddingSides">


<div class="d-flex align-items-center menuParentRowHeading">
            <div class="pageHeading_sec">
                <span><span class="text-blue">Rewards</span>
				Earn commissions & perks</span> 
            </div>                        
</div>

<div class="flexDesktopChild">

	

	<div id="affwp-affiliate-dashboardInner" class="myAccountContainerMbtInnerOld">

	<?php if ( 'pending' == affwp_get_affiliate_status( affwp_get_affiliate_id() ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account is pending approval', 'affiliate-wp' ); ?></p>

	<?php elseif ( 'inactive' == affwp_get_affiliate_status( affwp_get_affiliate_id() ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account is not active', 'affiliate-wp' ); ?></p>

	<?php elseif ( 'rejected' == affwp_get_affiliate_status( affwp_get_affiliate_id() ) ) : ?>

		<p class="affwp-notice"><?php _e( 'Your affiliate account request has been rejected', 'affiliate-wp' ); ?></p>

	<?php endif; ?>

	<?php if ( 'active' == affwp_get_affiliate_status( affwp_get_affiliate_id() ) ) : ?>

		<?php
		/**
		 * Fires at the top of the affiliate dashboard.
		 *
		 * @since 0.2
		 * @since 1.8.2 Added the `$active_tab` parameter.
		 *
		 * @param int|false $affiliate_id ID for the current affiliate.
		 * @param string    $active_tab   Slug for the currently-active tab.
		 */
		do_action( 'affwp_affiliate_dashboard_top', affwp_get_affiliate_id(), $active_tab );
		?>

		<?php if ( ! empty( $_GET['affwp_notice'] ) && 'profile-updated' == $_GET['affwp_notice'] ) : ?>

			<p class="affwp-notice"><?php _e( 'Your affiliate profile has been updated', 'affiliate-wp' ); ?></p>

		<?php endif; ?>

		<?php
		/**
		 * Fires inside the affiliate dashboard above the tabbed interface.
		 *
		 * @since 0.2
		 * @since 1.8.2 Added the `$active_tab` parameter.
		 *
		 * @param int|false $affiliate_id ID for the current affiliate.
		 * @param string    $active_tab   Slug for the currently-active tab.
		 */
		do_action( 'affwp_affiliate_dashboard_notices', affwp_get_affiliate_id(), $active_tab );
		?>

		<ul id="affwp-affiliate-dashboard-tabs">
			<?php
			$field_value = '';
			if(function_exists('bp_is_active')){
$field_value = bp_get_profile_field_data( array(
    'field' => 'Referral',
    'user_id' => get_current_user_id(),
    
  ) );
}
			$tabs = affwp_get_affiliate_area_tabs();
			$active_tab_title = '';
			if ( $tabs ) {
				foreach ( $tabs as $tab_slug => $tab_title ) : ?>
					<?php if ( affwp_affiliate_area_show_tab( $tab_slug ) ) :
						if($tab_slug !='logout' && $tab_slug!='creatives') {
							//echo  $tab_slug;
							if($field_value!='' && $tab_slug=='urls') {
								continue;
							}
							?>
							<li class="affwp-affiliate-dashboard-tab<?php echo $active_tab == $tab_slug ? ' active' : ''; ?>">
						<!-- <a href="<?php //echo esc_url( affwp_get_affiliate_area_page_url( $tab_slug ) ); ?>"><?php //echo $tab_title; ?></a> -->
						<a href="<?php echo esc_url( home_url().'/my-account/reward/?tab='. $tab_slug  ); ?>"><?php echo $tab_title; ?></a>
						<?php $active_tab_title = $tab_title; ?>
					</li>
							<?php
						} ?>
					
					<?php endif; ?>
				<?php endforeach;
			}

			/**
			 * Fires immediately after core Affiliate Area tabs are output,
			 * but before the 'Log Out' tab is output (if enabled).
			 *
			 * @since 1.0
			 *
			 * @param int    $affiliate_id ID of the current affiliate.
			 * @param string $active_tab   Slug of the active tab.
			 */
			
			do_action( 'affwp_affiliate_dashboard_tabs', affwp_get_affiliate_id(), $active_tab );
			
			
			?>

			<!-- <?php if ( affiliate_wp()->settings->get( 'logout_link' ) ) : ?>
			<li class="affwp-affiliate-dashboard-tab">
				<a href="<?php //echo esc_url( affwp_get_logout_url() ); ?>"><?php //_e( 'Log out', 'affiliate-wp' ); ?></a>
			</li>
			<?php endif; ?> -->

		</ul>

		<?php
		echo '<div id="SBRCustomerDashboard">';
		if(wp_is_mobile()){
			//echo '<b>'.$active_tab_title.'</b>';
		}
		if ( ! empty( $active_tab ) && affwp_affiliate_area_show_tab( $active_tab ) ) :
			echo affwp_render_affiliate_dashboard_tab( $active_tab );
		endif;
		echo '</div>';
		?>

		<?php
		/**
		 * Fires at the bottom of the affiliate dashboard.
		 *
		 * @since 0.2
		 * @since 1.8.2 Added the `$active_tab` parameter.
		 *
		 * @param int|false $affiliate_id ID for the current affiliate.
		 * @param string    $active_tab   Slug for the currently-active tab.
		 */
		do_action( 'affwp_affiliate_dashboard_bottom', affwp_get_affiliate_id(), $active_tab );
		
		?>

	<?php endif; ?>

	</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
		// jQuery.ajax({
		// 	'url':'<?php echo admin_url("admin-ajax.php");?>',
		// 	'data':'action=get_tab_data_affiliate&tab=graphs',
		// 	'method':'post',
		// 	success:function(res){
		// 		jQuery('.affwp-tab-content').html(res);
		// 		alert(res);
		// 	}
		// });
		//jQuery('.loading-sbr').hide();
		jQuery('body').removeClass("loading-js");
		
		jQuery(document).on('click','.affwp-affiliate-dashboard-tab, .ripple-button',function(){
			if(jQuery(this).hasClass('active') || jQuery(this).hasClass('reward')){
				//ignore
			}
			else{
				//jQuery('.loading-sbr').show();
				jQuery('body').addClass("loading-js");
			}
		})
	});
 jQuery('#affwp-affiliate-dashboard #affwp-affiliate-dashboard-tabs li.active').on('click', function(e) {
        jQuery(this).parent().toggleClass("collapsed pressed"); //you can list several class names 
      e.preventDefault();
    });
	<?php
if ( wp_is_mobile() ) {
    ?>
jQuery(".affwp-affiliate-dashboard-tab.active").prependTo("#affwp-affiliate-dashboard-tabs");
	<?php
}
?>
	
</script>
<div class="loading-sbr" style="display: block;"><div class="inner-sbr"></div></div>
<style>
	
.loading-js #affwp-affiliate-dashboard-url-generator,.loading-js .affwp-tab-content{
	filter: blur(3px);
    -webkit-filter: blur(3px);
    -moz-filter: blur(3px);
    -o-filter: blur(3px);
    -ms-filter: blur(3px);
    filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius='3');
}

</style>

