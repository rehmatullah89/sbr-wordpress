<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $shippinh_protection_html;
$front = \FKCart\Includes\Front::get_instance();
do_action( 'fkcart_before_cart_items', $front );
$cart_contents        = $front->get_items();
$is_you_saved_enabled = \FKCart\Includes\Data::is_you_saved_enabled();


?>
<style>

/* for funnel min cart only */
/* 
html body  #fkcart-modal  .shipping-protection {
    max-width: 92%;
    margin-left: auto;
    margin-right: auto;
}
.fkcart-checkout-wrap.fkcart-panel {
    display: flex;
}
html body  #fkcart-modal .fkcart-checkout-wrap #fkcart-checkout-button{
    height: 44px;
    margin-top: 16px;
}
html body #fkcart-modal .fkcart-checkout-wrap.fkcart-panel a {
    width: 50%;
    max-width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 44px;
    margin-top: 16px;
    text-transform: uppercase;
    font-size: 14px;
    font-weight: 400;
    border-radius: 0;
 
}

html body  a.fkcart-shopping-link.fkcart-modal-close {
    background-color: #ffffff;
    border: 1px solid #595858;
    color: #595858;
    text-align: center;
    text-transform: uppercase;
    margin-right: 5px;    order: 1;
}
html body  .fkcart-checkout-wrap.fkcart-panel {
    display: flex;
    column-gap: 10px;
}
html body  #fkcart-modal .fkcart-checkout-wrap #fkcart-checkout-button{
    background-color: #3c98cc;
    border: 1px solid #3382af;
    font-size: 14px;
    font-weight: 400;    border-radius: 0;    order: 2;
}
.fkcart-order-summary .fkcart-summary-line-item .fkcart-summary-text.fkcart-shipping-tax-calculation-text{
    font-size: 11px;
    font-family: 'Montserrat';
    color: #3c98cc;
    font-weight: 500;
    text-align: left;
}
#fkcart-modal .protection-content-text{
    color: rgb(151, 151, 151);
}
#fkcart-modal .fkcart-item-wrap .fkcart--item .fkcart-item-title{
    font-weight: 500;
    font-family: 'Montserrat';    color: #343434;
}
#fkcart-modal .fkcart-item-wrap .fkcart--item{
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #ccc;
    transition: all 300ms; 
}
#fkcart-modal .fkcart-item-wrap .fkcart--item:last-child{
    border-bottom: 0;
}

.fkcart-item-wrap.fkcart-pt-16 {
    padding-left: 15px;
    padding-right: 15px;
}
#fkcart-modal .fkcart-item-wrap .fkcart--item .fkcart-item-price .woocommerce-Price-amount, #fkcart-modal .fkcart-item-wrap .fkcart--item .fkcart-item-price .woocommerce-Price-amount * {
    color: #565759;
    font-weight: 500;
    font-family: 'Montserrat';
    font-size: 14px;
}
#fkcart-modal .fkcart-slider-body .fkcart-item-wrap .fkcart--item{
    padding-left: 0;
    padding-right: 0;
}
#fkcart-modal  span.woocommerce-Price-amount.amount{
    font-weight: 600;
    font-size: 18px;
}
.fkcart-preview-ui {
    border-top: 6px solid #3c98cc;
}
#fkcart-modal .fkcart-preview-ui .fkcart-slider-header {
    border-bottom: solid 0px var(--fkcart-border-color);
}
#fkcart-modal .fkcart-item-wrap .fkcart--item .fkcart-item-title:hover{
    color: #3c98cc;
}
html body  #fkcart-modal .fkcart-primary-button {
    background: #3c98cc;
}
html body #fkcart-modal .fkcart-item-wrap .fkcart--item .fkcart-remove-item{
    left: -5px;background: #3c98cc;
    color: #ffffff;
} */

/*  ends for funnel min cart only */


</style>


    <div class="fkcart-item-wrap fkcart-pt-16">
		<?php
		$ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_ng']) ? $_COOKIE['shipping_protection_prices_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
		$non_ng_shipping_protection_price = isset($_COOKIE['shipping_protection_prices_non_ng']) ? $_COOKIE['shipping_protection_prices_non_ng'] : SHIPPING_PROTECTION_PRICE_DEFAULT;
		$shipping_protection_price = $non_ng_shipping_protection_price;
		$ng_wht_ids = get_option('ng_wht_ids');
		$display_shipping_protection = true;
		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
         //   echo $cart_item_key;
			if(in_array($cart_item['cart_item']['product_id'],SHINE_REPORT_PRODUCT_IDS)){
				$display_shipping_protection = false;
			}
			if (is_array($ng_wht_ids) && count($ng_wht_ids) > 0 && in_array($cart_item['cart_item']['product_id'], $ng_wht_ids)) {
				$shipping_protection_price = $ng_shipping_protection_price;
			}
			if ($cart_item['cart_item'] == SHIPPING_PROTECTION_PRODUCT) {
                // echo '<pre>';
                // print_r($cart_item['cart_item']);
                // echo '</pre>';
			$shipping_protection_price = isset($cart_item['cart_item']['line_subtotal']) ? $cart_item['cart_item']['line_subtotal']:0.00;
			}
			/** Admin preview */
			if ( fkcart_is_preview() ) {
				fkcart_get_template_part( 'cart/item-single-preview', '', [ 'cart_item' => $cart_item ] );
				continue;
			}

			if ( isset( $cart_item['visibility_hidden'] ) ) {
				continue;
			}
			fkcart_get_template_part( 'cart/item-single', '', [ 'cart_item' => $cart_item, 'cart_item_key' => $cart_item_key ] );
		}
		
do_action( 'fkcart_after_cart_items', $front );

	 if($display_shipping_protection) { 
               // echo $cart_item['product_id'];
               ob_start();
                ?>
            <div class="shipping-protection">
                <div class="row-flex">
                    <div class="image-protection">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shipping-protection-v2.png"
                            alt="Shipping Protection">
                    </div>
                    <div class="protection-content-text">
                        <div class="protection-tp">
                            <h3 class="font-mont">Shipping Protection</h3>
                            <div class="addon-module-price">
                                <?php
                                 if ((is_user_logged_in() && get_user_meta(get_current_user_id(), 'is_shine_user', true) == '1') || (isset($_COOKIE['shine_user']) && $_COOKIE['shine_user'] != '')) {
                                    ?>
                                     <span class="upcart-addons-price">Free</span>
                                     <?php
                                 } else {
                                 ?>
                                <span class="upcart-addons-price">$<?php echo $shipping_protection_price ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <p>Protect your order from damage, loss,<br /> or theft during shipping.</p>
                    </div>


                    <div class="toggle-button">
                        <fieldset class="radio-switch">
                            <input type="radio" name="enable_shipping_protection" id="on-option" <?php echo $added_checked; ?> value="1" class="button-toggle-protection"
                                onchange="updateShippingProtection(this)">
                            <label for="on-option" class="iconcheck">
                                <i class="fa fa-check fa-6" aria-hidden="true"></i>
                                <span style="opacity:0;">On</span>
                            </label>

                            <input type="radio" name="enable_shipping_protection" <?php echo $not_added_checked; ?>
                                id="off-option" value="0" class="button-toggle-protection"
                                onchange="updateShippingProtection(this)">
                            <label for="off-option">
                                <div class="styles_ToggleSwitch__loading__L2jDv">
                                    <div class="styles_ToggleSwitch__loader__WIEMd"></div>
                                </div>
                                <span style="opacity:0;">Off</span>
                            </label>
                        </fieldset>
                    </div>


                </div>
            </div>
            <? 
        $shippinh_protection_html = ob_get_clean();
        } ?>
    </div>

