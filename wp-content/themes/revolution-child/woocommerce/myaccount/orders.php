<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;
?>






<div class="desktopVersionOrder">
<div class="d-flex align-items-center orderListingPageMenu menuParentRowHeading menuParentRowHeadingOrderParent borderBottomLine">
            <div class="pageHeading_sec">
                <span><span class="text-blue">orders</span>Track, return or buy items again.</span> 
            </div>                        
</div>	

	<!-- 					nav-justified -->
	<ul class="nav nav-tabs  mt-3 customTabs tabsDesktop hidden">
		<li class="nav-item">
			<a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">ALL ORDERS</a>
		</li>
		<li class="nav-item">
			<a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">BUY AGAIN</a>
		</li>
		

	</ul>


	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

			<div class="table-responsive">
				<?php
				$data_tab =  'alldesktop';
				if (wp_is_mobile()) {
				//	$data_tab =  'all';
				}
				sbr_customer_order_dashboard($data_tab); ?>

			</div>
		</div>
		
		<div class="tab-pane buyagaintab" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

			<?php
			//sbr_customer_order_dashboard('buyagain'); ?>
		</div>

	</div>
</div>
<?php if (wp_is_mobile()) { ?>
	<div id="SBRCustomerDashboard" class="hiddenDesktop">
		<?php //sbr_customer_order_dashboard(); ?>
	</div>
<?php } ?>

<?php


return; ?>
<!-- <table class="table table-bordered">
      <thead>
        <tr>
          <th>ORDERS</th>
          <th>DATE</th>
          <th>STATUS</th>
          <th>TOTAL</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="orderSecTab">
          		<h3>Order: <span class="text-blue">SBR-0431331</span></h3>
          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/09/graphic-toothbrush-heads-4p.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>

          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/08/smilebrilliant-whitening-gel-large.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>

          </div>
      </td>
          <td>
          	<div class="dateDisplay">
          		12-08-2021
          	</div>
          </td>
          <td>
          	<div class="orderStatus">
          		<span>Partially Shipped</span>
          	</div>
          </td>
          <td>
          		<div class="totalAmount">
          			<span class="text-blue priceDispaly">$120</span>
          			<span class="sepratorLine"></span>
          			<span class="totalItemToOrder">2 item</span>
          		</div>
          </td>
          <td>
          	<div class="actionDisplay">
          		<a href="javascript:;" class="text-blue">Details</a>
          		<span class="sepratorLine"></span>
          		<a href="javascript:;" class="text-blue">Track Package</a>
          	</div>
          </td>
        </tr>

<tr>
          <td><div class="orderSecTab">
          		<h3>Order: <span class="text-blue">SBR-0431331</span></h3>
          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/09/graphic-toothbrush-heads-4p.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>

          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/08/smilebrilliant-whitening-gel-large.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>
          		
          </div>
      </td>
          <td>
          	<div class="dateDisplay">
          		12-08-2021
          	</div>
          </td>
          <td>
          	<div class="orderStatus">
          		<span>Partially Shipped</span>
          	</div>
          </td>
          <td>
          		<div class="totalAmount">
          			<span class="text-blue priceDispaly">$120</span>
          			<span class="sepratorLine"></span>
          			<span class="totalItemToOrder">2 item</span>
          		</div>
          </td>
          <td>
          	<div class="actionDisplay">
          		<a href="javascript:;" class="text-blue">Details</a>
          		<span class="sepratorLine"></span>
          		<a href="javascript:;" class="text-blue">Track Package</a>
          	</div>
          </td>
        </tr>

<tr>
          <td><div class="orderSecTab">
          		<h3>Order: <span class="text-blue">SBR-0431331</span></h3>
          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/09/graphic-toothbrush-heads-4p.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>

          		<div class="orderDisplay">
          			<div class="orderImage">
          				<img src="https://www.smilebrilliant.com/wp-content/uploads/2020/08/smilebrilliant-whitening-gel-large.png">
          			</div>
          			<div class="orderTitle">
          				Toothbrush Heads
          			</div>	
          		</div>
          		
          </div>
      </td>
          <td>
          	<div class="dateDisplay">
          		12-08-2021
          	</div>
          </td>
          <td>
          	<div class="orderStatus">
          		<span>Partially Shipped</span>
          	</div>
          </td>
          <td>
          		<div class="totalAmount">
          			<span class="text-blue priceDispaly">$120</span>
          			<span class="sepratorLine"></span>
          			<span class="totalItemToOrder">2 item</span>
          		</div>
          </td>
          <td>
          	<div class="actionDisplay">
          		<a href="javascript:;" class="text-blue">Details</a>
          		<span class="sepratorLine"></span>
          		<a href="javascript:;" class="text-blue">Track Package</a>
          	</div>
          </td>
        </tr>
        

      </tbody>
    </table> -->

<?php
$data_tab =  'alldesktop';
if (wp_is_mobile()) {
	$data_tab =  'all';
}
sbr_customer_order_dashboard($data_tab); ?>


</div>
<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

	<h2> No subscriptions Found</h2>
</div>
<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

	<?php
	sbr_customer_order_dashboard('buyagain'); ?>
</div>
</div>



</div>


<div id="SBRCustomerDashboard" class="hiddenDesktop">
	<?php sbr_customer_order_dashboard(); ?>
</div>