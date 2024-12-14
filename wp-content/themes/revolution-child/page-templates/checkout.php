<?php
/*

Template Name: Checkout Page

*/

get_header();


?>

<div class="smilebrilliant-page-content" id="checkout-page">
	<section class="sep-top-4x">
		<div class="container">
				<h1 class="product-header-primary" id="orderCheckoutPageTitle">Checkout</h1>
				<h2 class="product-header-sub" id="orderCheckoutPageSubTitle">Let's start your journey! Your new smile awaits.</h2>
			<div id="checkout-page-form" class="sep-bottom-lg">
				<div id="checkout-page-order-review" class="sep-top-sm">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h4 class="upper">ORDER REVIEW</h4>
								<table class="table table-bordered table-condensed table-striped shop-table table-responsive">
							<thead>
									<tr>
										<th scope="col" colspan="2" class="upper product-column">Products</th>
										<th scope="col" colspan="1" class="upper price-column">Price</th>
										<th scope="col" colspan="1" class="upper qty-column">Quantity</th>
										<th scope="col" colspan="1" class="upper">Total</th>
										<th scope="col" colspan="1" class="upper remove-button-column"></th>
									</tr>
							</thead>

							<tbody>
								<tr class="productRow">
									<td class="product-thumb">
										<a rel="nofollow" href="/product/sensitive-teeth-whitening-trays">
											<img src="https://www.smilebrilliant.com/static/images/product/smilebrilliant-system-thumb-noshadow.png" class="img-fluid">
										</a>
									</td>
									<td class="product-column">
										<h5>
											<a rel="nofollow" href="/product/sensitive-teeth-whitening-trays">T9 Sensitive System (Custom-Fitted Trays + 9 Whitening &amp; Desensitizing Gel Syringes)</a>
										</h5>										
									</td>
									<td class="price-column text-left">
										<h5 class="productUnitPrice220">$189.00</h5>
									</td>
									<td class="qty-column text-left">
										<div class="input-group bootstrap-touchspin">

							<span class="input-group-btn">
									<input type="button" value="-" id="subs" class="btn btn-default pull-left"  />
							</span>
									<input type="text" class="onlyNumber form-control qty form-control" id="noOfRoom" value="" name="noOfRoom" />
								<span class="input-group-btn">
									<input type="button" value="+" id="adds" class="btn btn-default" />
								</span>											
										</div>
									</td>
									<td class="total-column">
										<h5  class="productTotal220">$189.00</h5>
									</td>
									<td class="remove-button-column text-left">
										<a rel="nofollow" class="btn btn-primary btn-sm">REMOVE</a>
									</td>
								</tr>

						<tr id="couponRow" style="background-color: rgb(242, 242, 242);/* display: none; */">
							<td colspan="4" id="couponRowDescriptionCell">
								<h5 style="color:#595959;text-align:right;">10% off Subscriber Loyalty</h5>							</td>
							<td colspan="1" style="text-align:left;">
								<h5 style="color:#595959;">-$16.90</h5>
							</td>
							<td colspan="1" class="remove-button-column">
								<a rel="nofollow" class="btn btn-primary btn-sm">REMOVE</a>
							</td>
													</tr>

							</tbody>


								</table>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 sep-top-sm">
								<div class="panel panel-naked">
									<div class="panel-heading">
									<h5>
										<a rel="nofollow" data-toggle="collapse" href="#collapseCouponEntry" class="collapsed" aria-expanded="false">Enter Gift Code<i class="fa fa-plus-circle"></i></a>
										</h5>										
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 class="upper">BILLING DETAILS</h4>
							</div>
							<div class="col-md-6">
								shipping left
							</div>
							<div class="col-md-6">
								shipping right
							</div>

						</div>

						<div class="row shipping-method">
							<div class="col-md-6">
								<h4 class="upper">SHIPPING METHOD</h4>

					<div class="form-group">
						<label for="shippingMethod">
							Shipping Method
							&nbsp;&nbsp;<span style="color:#4597cb;">(Order Will Ship:&nbsp;&nbsp;<b>Today</b>)</span>						</label>
							<select id="" class="form-control input-lg">
								<option value="3">USPS Priority Mail (2 - 3 Day)</option>
								<option value="6">USPS Priority Mail (w/Signature Confirm)</option>
								<option value="12">USPS Express (1 - 2 Day)</option>
							</select>
					</div>

					<div class="col-md-12" >
						<div class="note-text" id="shippingMethodNoteDomestic" style="display: none;">
							NOTE: If you live in an apartment or condo, we recommend selecting the "USPS Priority Mail (w/Signature Confirm)" shipping method to ensure that your package is not left out in the open.
						</div>
						<div class="note-text" id="shippingMethodNoteInternational">
							Placing this order, I acknowledge that I have been informed, understand, and agree to the terms outlined on the <a style="color:#D4545A;font-weight:bold;" href="/product-disclaimer" rel="nofollow" target="_blank">Smile Brilliant Product Disclaimer</a> and that I provide my consent prior to purchasing or using Smile Brilliant products.
						</div>

					</div>




							</div>


			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="cart_totals">
							<h4 class="upper">Totals</h4>
							<div class="sep-top-sm">
								<table class="table table-bordered table-condensed table-responsive">
									<tbody>
										<tr>
											<td class="upper">Subtotal</td>
											<td class="upper">
												<h5 id="subTotal">$169.00</h5>
											</td>
										</tr>
										<tr>
											<td class="upper">Shipping</td>
											<td id="shippingTotal">$35.00<div>Includes 2-way shipment of impressions &amp; trays.</div></td>
										</tr>
																				<tr id="salesTaxTotalRow" style="display:none;">
											<td class="upper" class="salesTaxTotalDescription">Sales Tax</td>

											<td id="salesTaxTotal"></td>
										</tr>

																				<tr id="discountTotalRow" style="display: none;">
											<td class="upper">Discount</td>
											<td id="discountTotal">$0.00</td>
										</tr>
										<tr class="evidence">
											<td class="upper" style="background-color:#f9f9f9;">
											  <h5 style="color:#252525;">Order Total</h5>
											</td>
											<td class="upper" style="background-color:#f9f9f9;">
												<h5 style="color:#252525;" id="totalTotal">$204.00</h5>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>


						</div>



					</div>
				</div>
			</div>


		</div>
	</section>
</div>

<script>
jQuery('#adds').click(function add() {
    var $rooms = jQuery("#noOfRoom");
    var a = $rooms.val();
    
    a++;
    jQuery("#subs").prop("disabled", !a);
    $rooms.val(a);
});
jQuery("#subs").prop("disabled", !jQuery("#noOfRoom").val());

jQuery('#subs').click(function subst() {
    var $rooms = jQuery("#noOfRoom");
    var b = $rooms.val();
    if (b >= 1) {
        b--;
        $rooms.val(b);
    }
    else {
        jQuery("#subs").prop("disabled", true);
    }
});
	
</script>

<?php

get_footer();

?>