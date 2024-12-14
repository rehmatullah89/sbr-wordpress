<?php
/*

Template Name: Contact Us Temp

*/

get_header();


?>

<div class="smilebrilliant-page-content" id="contact-page">

	<section class="text-center sep-top-4x">
		<div class="row wpb_row row-fluid justify-content-center">
			<div class="medium-8">
		<h1 class="product-header-primary"  id="contactFormTitle">WE WANT TO HEAR <span style="color:#4597cb;">FROM YOU!</span></h1>
					<div class="section-header-content-grey-large" style="margin-top:30px;">
							Feel free to give us a call or contact us through our live online support.  Otherwise, fill out the contact form below to get in touch with our team.  If you haven't had a chance yet, be sure to read our <a href="/frequently-asked-questions">FAQ</a> for more information!
						</div>
					</div>
		</div>

			<div class="row wpb_row row-fluid justify-content-center">
				<div class="col-md-10">
					<?php echo do_shortcode( '[contact-form-7 id="427541" title="Contact Us"]' ); ?>
				</div>
			</div>



	</section>

	<!-- Start Contact section-->


	<section class="sep-bottom-md contact-bttm">
		<div style="overflow:hidden;">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-3 icon-gradient sep-top-sm" style="min-height:250px;">
						<div class="icon-box icon-horizontal icon-sm">
							<div class="icon-content img-circle" style="background-color:#4597cb;"><i class="fa fa-map-marker"></i></div>
							<div class="icon-box-content">
								<h6 class="upper">Office</h6>
								<p>
								1645 Headland Dr<br>
								Fenton, MO 63026<br>
									United States
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 icon-gradient sep-top-sm" style="min-height:250px;">
						<div class="icon-box icon-horizontal icon-sm">
							<div class="icon-content img-circle" style="background-color:#f8a18a;cursor:pointer;" onclick="window.location.href=&quot;tel:855-944-8361&quot;;"><i class="fa fa-phone"></i></div>
							<div class="icon-box-content">
								<h6 class="upper">Phone</h6>
								<p>
									<a style="color:#565759;" href="tel:855-944-8361">855-944-8361</a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 icon-gradient sep-top-sm" style="min-height:250px;">
						<div class="icon-box icon-horizontal icon-sm">
							<div class="icon-content img-circle" id="contactEmailSupportCircle" style="cursor:pointer;background-color:#68c8c7;">
							<a style="color:#fff;" id="" href="mailto:support@smilebrilliant.com">
							<i class="fa fa-envelope"></i>
						</a>
						</div>
							<div class="icon-box-content">
								<h6 class="upper">Email</h6>
								<p>
									<a style="color:#565759;" id="contactEmailAddressElement" href="mailto:support@smilebrilliant.com">support@smilebrilliant.com</a>
									<script type="text/javascript">
										var n__emailSupportView = n__eById('contactEmailAddressElement');
										n__emailSupportView.innerHTML = 'support'+'@'+'smilebrilliant.com';
										n__emailSupportView.href = 'mail'+'to:'+'support'+'@'+'smilebrilliant.com';

										var n__emailSupportCircle = n__eById('contactEmailSupportCircle');
										n__emailSupportCircle.onclick = function()
										{
											window.location.href = 'mail'+'to:'+'support'+'@'+'smilebrilliant.com';
										}


									</script>
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 icon-gradient sep-top-sm" style="min-height:250px;">
						<div class="icon-box icon-horizontal icon-sm">
							<div class="icon-content img-circle" style="background-color:#b8b8dc;"><i class="fa fa-clock-o"></i></div>
							<div class="icon-box-content">
								<h6 class="upper">Office Hours</h6>
								<p>Mon / Friday<br>09:00am - 5:00pm CST</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	
</div>




<?php

get_footer();

?>