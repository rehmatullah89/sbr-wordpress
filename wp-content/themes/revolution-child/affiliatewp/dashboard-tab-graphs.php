<?php
$affiliate_id = affwp_get_affiliate_id();
?>
<div id="affwp-affiliate-dashboard-graphs" class="affwp-tab-content">

	<h4 class="hidden"><?php _e( 'Referral Graphs', 'affiliate-wp' ); ?></h4>

	<?php
	$graph = new Affiliate_WP_Referrals_Graph;
	$graph->set( 'x_mode', 'time' );
	$graph->set( 'affiliate_id', $affiliate_id );
	// echo '<pre>';
	// print_r($graph);
	// die();
	$graph->display();
	?>

	<?php
	/**
	 * Fires after dashboard graphs within the affiliate area graphs template.
	 *
	 * @since 1.0
	 *
	 * @param int $affiliate_id Affiliate ID of the currently logged-in affiliate.
	 */
	do_action( 'affwp_affiliate_dashboard_after_graphs', $affiliate_id );
    ?>

</div>
