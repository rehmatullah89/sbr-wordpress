<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</label>
	<?php
	$country = (isset( $_POST['s_country'])?$_POST['s_country']:'');
	if($gateway->id ==  'authorize_net_cim_credit_card' && $country == 'US'){
	?>
	<br class="brHFA" />
	<script>
		jQuery(document).on('change','input[name="payment_method"]',function(){
			
			if(jQuery('.hsa_custom').is(':checked')){
				jQuery('#hsa_hfa').val("yes");
				jQuery('.hsacustom-content').show("slow");
			}
			else{
				jQuery('#hsa_hfa').val("");
				jQuery('.hsacustom-content').hide("slow");
			}
		});
		jQuery(document).on('click','label',function(){
		if(jQuery(this).attr('for') == 'payment_method_authorize_net_cim_credit_card_hsa'){
			jQuery('.hsa_custom').click();
		}
		});
		jQuery(document).on('change','#shipping_country',function(){
// armyAddresses(true);
selected_country = jQuery(this).val();
if(selected_country == 'US') {
jQuery('.paymentMethodNfa').show();
}
else{
jQuery('.paymentMethodNfa').hide();
jQuery('.paymentMethodNfa').css('display','none !important');
}
		});
	</script>

<div class="paymentMethodNfa">
<!-- <span class="spacerText">space</span> -->
<div class="payment-thodInner">
<input type = "hidden" value="" id="hsa_hfa" name="hsa_hfa">
<label for="payment_method_hsa_hfa" class="hsaIcons">	
	<input id="payment_method_hsa_hfa" type="checkbox" class="input-checkbox hsa_custom" name="payment_method_hsa_hfa" value="yes" />
<?php echo "HSA/FSA Card"; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> 

<div class="payment_iconMbt">
<?php echo $images = '<img class="hsaIcons" src="' . get_stylesheet_directory_uri() . '/assets/images/HSA.svg" width="40px;" height="25px"><img src="' . get_stylesheet_directory_uri() . '/assets/images/FSA.svg" width="40px;" class="hsaIcons" height="25px">';?> 
</div>
</label>

</div>
</div>
	<?php
}
	?>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>
