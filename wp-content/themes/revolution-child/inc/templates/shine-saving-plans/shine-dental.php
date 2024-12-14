<div class="shine-dental-description">
    <div class="row-flex align-items-center justify-content-between shine-dental-description-inner">
        <div class="shine-dental-description-paragraph">
            <p>
                <span style="color:#4acac9;">
                The Shine Dental Package</span>
                includes all of the discounts of the Member Perks package as well as exclusive, in-office discounts at more than 262,000+ providers. Shine Dental is a great package for individuals (or families) without dental insurance or those who have dental insurance but plan on spending more than your dental insurance annual benefit maximum (generally $1400-$2000 /year). This package does not include discounts at pharmacies or vision centers.
            </p>
        </div>
        <?php
                    $key = SHINE_DENTAL_PRODUCT_ID;
                    $field = get_field('define_shine_membership_plans', $key);
        ?>
        <div class="shine-dental-description-price-section">
            <div class="row-flex direction-column shine-price-display">
            <div class="saving-price-wrapper"><span class="currency-indicator" style="font-weight: bolder;" id="DM<?php echo $key;?>_price"></div>
            <span style="color: red;" id="<?php echo $key;?>_info_dm" >This combination of Package is not available.</span>
            <div class="dropdown-selection"  data-aos="fade-up" data-aos-delay="0" >
            <div class="form-group">
                <label>Payment Frequency:</label>
                <div class="select-option">
                <select name="frequency" id="<?php echo $key;?>_frequency_pop" onchange="getPopupPrices(<?php echo $key;?>)">
                    <?php
                            $prices = [];
                            $indexes = [];
                            $pcombinations = [];                            
                            foreach($field as $index => $values){
                                if(is_page('shineplans')){
                                    if(@$values['billingshipping_frequency']['value'] == 30 || @$values['billingshipping_frequency']['label']=='Monthly'){
                                        continue;
                                    }
                                }
                                if(!array_key_exists(@$values['billingshipping_frequency']['value'], $prices)){ 
                                    echo "<option value='".@$values['billingshipping_frequency']['value']."'>".@$values['billingshipping_frequency']['label']."</option>";
                                    $prices[@$values['billingshipping_frequency']['value']] =  @$values['price'];
                                }
                                $indexes[$key.'_'.@$values['plan_type']['value'].'_'.@$values['billingshipping_frequency']['value']] = $index;
                                $pcombinations[$key.'_'.@$values['plan_type']['value'].'_'.@$values['billingshipping_frequency']['value']] = @$values['price'];
                            }
                    ?>
                    <input type="hidden" name="combinations" id="<?php echo htmlspecialchars($key); ?>_combinations_pop" indexs="<?php echo htmlspecialchars(json_encode($indexes), ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars(json_encode($pcombinations), ENT_QUOTES, 'UTF-8'); ?>">

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Quantity of Members:</label>
                <div class="select-option">
                    <select name="members" id="<?php echo $key;?>_members_pop" onchange="getPopupPrices(<?php echo $key;?>)">
                        <?php
                            $discounts = [];
                            foreach($field as $index => $values){
                                if(!array_key_exists(@$values['plan_type']['value'], $discounts)){
                                    echo "<option value='".@$values['plan_type']['value']."' >".@$values['plan_type']['label']."</option>";
                                    $discounts[@$values['plan_type']['value']] =  @$values['discount-amount'];
                                }                                
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

                <div class="button-wrap">                    
                        <button class="btn btn-primary add_to_cart_button ajax_add_to_cart" data-arbid="0" data-shine="1" href="?add-to-cart=<?php echo $key;?>" data-quantity="1" data-product_id="<?php echo $key;?>" id="<?php echo $key;?>_btn_dm">Get This Package</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="pop-accordion-wrapper">

    <div class="accordion">

        <?php get_template_part('inc/templates/shine-saving-plans/smile-brilliant-discount-tab'); ?>

        <?php get_template_part('inc/templates/shine-saving-plans/dental-office-discount-tab'); ?>


        <div class="accordion-item notIncludedItem clickedDisable" style="border-color:#eeeeee;">
            <div class="accordion-header" style="background:#eeeeee;">
                <h3>VISION CENTER DISCOUNTS (not included)</h3>
            </div>
        </div>

        <div class="accordion-item notIncludedItem clickedDisable" style="border-color:#eeeeee;">
            <div class="accordion-header" style="background:#eeeeee;">
                <h3>PHARMACY Rx Discounts (not included)</h3>
            </div>
        </div>





    </div>
</div>