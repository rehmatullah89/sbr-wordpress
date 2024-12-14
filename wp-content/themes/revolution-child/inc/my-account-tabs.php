<?php

function sbr_customer_dashboard_addNewPayemnt_content()
{
    global $wpdb;

    $load_address = 'billing';
    $current_user = wp_get_current_user();
    $load_address = sanitize_key($load_address);
    $country      = get_user_meta(get_current_user_id(), $load_address . '_country', true);

    if (!$country) {
        $country = WC()->countries->get_base_country();
    }

    if ('billing' === $load_address) {
        $allowed_countries = WC()->countries->get_allowed_countries();

        if (!array_key_exists($country, $allowed_countries)) {
            $country = current(array_keys($allowed_countries));
        }
    }
    $address = WC()->countries->get_address_fields($country, $load_address . '_');

    // Enqueue scripts.
    wp_enqueue_script('wc-country-select');
    wp_enqueue_script('wc-address-i18n');
    $token_year  = 0;
    $token_month  = 0;
    $token_id = 0;
    // Prepare values.
    $payment_profile_id = (get_query_var('edit_payment_card')) ? get_query_var('edit_payment_card') : 0;
    if ($payment_profile_id) {
        $customer_profile_id = get_user_meta(get_current_user_id(), USER_CIM_PROFILE_ID, true);
        $infoD =  getCustomerPaymentProfile($customer_profile_id, $payment_profile_id);
        $token_id = $wpdb->get_var("SELECT  token_id FROM {$wpdb->prefix}woocommerce_payment_tokens  WHERE token = $payment_profile_id");
        $token_year = $wpdb->get_var("SELECT  meta_value FROM {$wpdb->prefix}woocommerce_payment_tokens token inner join {$wpdb->prefix}woocommerce_payment_tokenmeta tokenmeta on token.token_id=tokenmeta.payment_token_id  WHERE token.token = $payment_profile_id AND tokenmeta.meta_key = 'expiry_year'");
        $token_month = $wpdb->get_var("SELECT  meta_value FROM {$wpdb->prefix}woocommerce_payment_tokens token inner join {$wpdb->prefix}woocommerce_payment_tokenmeta tokenmeta on token.token_id=tokenmeta.payment_token_id  WHERE token.token = $payment_profile_id AND tokenmeta.meta_key = 'expiry_month'");
        $info = $infoD['paymentProfile']['billTo'];
        $data = array(
            'billing_first_name' => isset($info['firstName']) ?  $info['firstName'] : '',
            'billing_last_name' => isset($info['lastName']) ?  $info['lastName'] : '',
            'billing_company' => isset($info['company']) ?  $info['company'] : '',
            'billing_country' => isset($info['country']) ?  $info['country'] : 'US',
            'billing_postcode' => isset($info['zip']) ?  $info['zip'] : '',
            'billing_address_1' => isset($info['address']) ?  $info['address'] : '',
            'billing_address_2' => '',
            'billing_city' => isset($info['city']) ?  $info['city'] : '',
            'billing_state' => isset($info['state']) ?  $info['state'] : '',
            'billing_phone' => isset($info['phoneNumber']) ?  $info['phoneNumber'] : '',
        );
        foreach ($address as $key => $field) {
            $value = isset($data[$key]) ? $data[$key] : '';
            if ($key == 'billing_country' && $value == 'USA') {
                $value = 'US';
            }
            $address[$key]['value'] = apply_filters('woocommerce_my_account_edit_address_field_value', $value, $key, $load_address);
        }
    }

?>


    <div class="addPaymentCardBilling">
        <div class="d-flex align-items-center menuParentRowHeading paymentMethodFileParent borderBottomLine ">
            <div class="pageHeading_sec">
                <span><span class="text-blue">Billing</span>Manage billing.</span>
            </div>
        </div>
        <div class="d-flex align-items-center orderDetailFile breadCrumbsListWrapper justify-content-between">
            <div class="crumbTrail">
                <ul class="breadcrumbItem">
                    <li><a href="<?php echo home_url('/my-account/payment-methods/'); ?>">Payment Method</a></li>
                    <?php if ($payment_profile_id) {
                        echo '<li><a href="javascript:void(0);">Edit Payment</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0);">Add Payment</a></li>';
                    } ?>
                </ul>
            </div>
            <div class="button text-right goBackDetailPage hidden-mobile"><a href="/my-account/payment-methods/" class="buttonDefault smallRipple ripple-button " onclick="">Go Back</a></div>
            <div class="button text-right goBackDetailPage arrowBtn hiddenDesktop"><a href="/my-account/payment-methods/" class="backButton"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div>

        </div>
    </div>

    <form id="addPaymentMethod" class="paymentAddSec">
        <div id="responsePaymentMethodWapper" style="display:none">
            <div id="responsePaymentMethod"></div>
        </div>
        <div class="shippingAddressSection editShippingAddressDetail">


            <div class="paymentMethodBox al-order1">
                <h1 class="titleSecShipping">Credit/Debit card</h1>
                <p>
                <fieldset id="wc-authorize-net-cim-credit-card-credit-card-form" aria-label="Payment Info">
                    <legend style="display:none;">Payment Info</legend>

                    <div class="wc-authorize-net-cim-credit-card-new-payment-method-form js-wc-authorize-net-cim-credit-card-new-payment-method-form flex-row">

                        <p class="form-row form-row-wide validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-account-number_field" data-priority="">

                            <label for="wc-authorize-net-cim-credit-card-account-number" class="">Card Number&nbsp;<abbr class="required" title="required">*</abbr></label>

                            <span class="woocommerce-input-wrapper">

                                <input type="tel" class="js-sv-wc-payment-gateway-credit-card-form-account-number" name="wc-authorize-net-cim-credit-card-account-number" id="wc-authorize-net-cim-credit-card-account-number" placeholder="**** **** **** ****" value="" autocomplete="cc-number" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="16"></span>
                        </p>



                        <p class="form-row form-row-first validate-required col-sm-6" id="wc-authorize-net-cim-credit-card-expiry_year_field" data-priority="">



                            <label for="wc-authorize-net-cim-credit-card-expiry-month" class="">Expiration Month&nbsp;<abbr class="required" title="required">*</abbr></label>

                            <select id="wc-authorize-net-cim-credit-card-expiry-month" name="wc-authorize-net-cim-credit-card-expiry-month">

                                <option value=''>--Select Month--</option>
                                <option value='01' <?php if ($token_month == '01') echo 'selected'; ?>>Janaury</option>
                                <option value='02' <?php if ($token_month == '02') echo 'selected'; ?>>February</option>
                                <option value='03' <?php if ($token_month == '03') echo 'selected'; ?>>March</option>
                                <option value='04' <?php if ($token_month == '04') echo 'selected'; ?>>April</option>
                                <option value='05' <?php if ($token_month == '05') echo 'selected'; ?>>May</option>
                                <option value='06' <?php if ($token_month == '06') echo 'selected'; ?>>June</option>
                                <option value='07' <?php if ($token_month == '07') echo 'selected'; ?>>July</option>
                                <option value='08' <?php if ($token_month == '08') echo 'selected'; ?>>August</option>
                                <option value='09' <?php if ($token_month == '09') echo 'selected'; ?>>September</option>
                                <option value='10' <?php if ($token_month == '10') echo 'selected'; ?>>October</option>
                                <option value='11' <?php if ($token_month == '11') echo 'selected'; ?>>November</option>
                                <option value='12' <?php if ($token_month == '12') echo 'selected'; ?>>December</option>

                            </select>

                        </p>

                        <p class="form-row form-row-last col-sm-6  validate-required">

                            <label for="wc-authorize-net-cim-credit-card-expiry-" class="">Expiration Year(YYYY)&nbsp;<abbr class="required" title="required">*</abbr></label>

                            <span class="woocommerce-input-wrapper"><input type="tel" class="input-text" name="wc-authorize-net-cim-credit-card-expiry-year" id="wc-authorize-net-cim-credit-card-expiry-year" placeholder="YYYY" value="<?php echo $token_year; ?>" autocomplete="cc-exp" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span>
                        </p>



                        <p class="form-row form-row-first col-sm-6  validate-required">

                            <label for="wc-authorize-net-cim-credit-card-csc" class="">Card Security Code&nbsp;<abbr class="required" title="required">*</abbr></label>

                            <span class="woocommerce-input-wrapper">

                                <input type="tel" class="input-text js-sv-wc-payment-gateway-credit-card-form-input js-sv-wc-payment-gateway-credit-card-form-csc" name="wc-authorize-net-cim-credit-card-csc" id="wc-authorize-net-cim-credit-card-csc" placeholder="CSC" value="" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" maxlength="4"></span>

                        </p>
                        <?php
                        $hsa_fsa = $wpdb->get_var("SELECT  meta_value FROM {$wpdb->prefix}woocommerce_payment_tokens token inner join {$wpdb->prefix}woocommerce_payment_tokenmeta tokenmeta on token.token_id=tokenmeta.payment_token_id  WHERE token.token = $payment_profile_id AND tokenmeta.meta_key = 'hsa_fsa'");

                        $checkedHsa = '';
                        if ($hsa_fsa == 'yes') {
                            $checkedHsa = 'checked=""';
                        } ?>
                        <div class="paymentMethodNfa">
                            <span class="spacerText">space</span>
                            <div class="payment-thodInner">

                                <label for="payment_method_hsa_hfa" class="hsaIcons">
                                    <input id="payment_method_hsa_hfa" type="checkbox" class="input-checkbox hsa_custom" name="payment_method_hsa_hfa" value="yes" <?php echo $checkedHsa; ?>>
                                    <div class="payment_iconMbt ffee">
                                        <img class="hsaIcons" src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/FSA-2.svg" width="70px;" height="18px">
                                        <!-- <img class="hsaIcons" src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/HSA.svg" width="40px;" height="25px"><img src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/FSA.svg" class="hsaIcons" width="40px;" height="25px"> -->
                                    </div>
                                    HSA/FSA Card
                                </label>

                            </div>
                        </div>
                    </div><!-- ./new-payment-method-form-div -->

                </fieldset>


            </div>


            <div class="woocommerce-address-fields__field-wrapper al-order2">
                <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBbxE-oS52upTGTzOq2r1aCnG9QkqafsVI&#038;libraries=places&#038;ver=6.0.2' id='wfacp_google_js-js'></script>
                <script>
                    var country_code = 'us';
                    var places;
                    jQuery(document).on('change', '#billing_country', function() {
                        country_code = jQuery(this).val();
                        places.setComponentRestrictions({
                            country: country_code
                        });
                    });
                    jQuery(document).ready(function() {
                        country_code = jQuery('#billing_country').val();
                        if (country_code == '') {
                            country_code = 'us'
                        }

                        google.maps.event.addDomListener(window, 'load', function() {
                            console.log(country_code);
                            var options = {
                                componentRestrictions: {
                                    country: country_code
                                }
                            };


                            places = new google.maps.places.Autocomplete(document.getElementById(
                                'billing_address_1'), options);

                            google.maps.event.addListener(places, 'place_changed', function() {
                                var place = places.getPlace();
                                var address = place.formatted_address;
                                var latitude = place.geometry.location.lat();
                                var longitude = place.geometry.location.lng();
                                var latlng = new google.maps.LatLng(latitude, longitude);
                                var geocoder = geocoder = new google.maps.Geocoder();
                                console.log(country_code)
                                geocoder.geocode({
                                    'latLng': latlng
                                }, function(results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        if (results[0]) {
                                            var address = results[0].formatted_address;
                                            var pin = results[0].address_components[results[0]
                                                .address_components.length - 1].short_name;
                                            var country = results[0].address_components[results[0]
                                                .address_components.length - 2].short_name;
                                            var state = results[0].address_components[results[0]
                                                .address_components.length - 3].short_name;
                                            var state_long = results[0].address_components[results[0]
                                                .address_components.length - 3].long_name;
                                            var city = results[0].address_components[results[0]
                                                .address_components.length - 4].long_name;
                                            if (pin == 'US') {
                                                pin = results[0].address_components[results[0]
                                                    .address_components.length - 1].short_name;
                                            }
                                            // console.log( results[0]);
                                            if (state == 'US') {
                                                state = results[0].address_components[results[0]
                                                    .address_components.length - 4].short_name;
                                                state_long = results[0].address_components[results[0]
                                                    .address_components.length - 4].long_name;
                                                country = results[0].address_components[results[0]
                                                    .address_components.length - 3].short_name;
                                            }
                                            if (state_long == city) {

                                                var city = results[0].address_components[results[0]
                                                    .address_components.length - 7].long_name;
                                            }
                                            // console.log('ddd');
                                            // console.log(address);
                                            ///  document.getElementById('address-autocomp').value = address;
                                            document.getElementById('billing_state').value =
                                                state;
                                            document.getElementById('billing_city').value = city;
                                            document.getElementById('billing_postcode').value = pin;
                                            document.getElementById('billing_country').value = country;
                                        }
                                    }
                                });
                            });

                        });
                    });
                </script>

                <h1 class="titleSecShipping mb-3 mt-4">Billing Address</h1>
                <?php
                foreach ($address as $key => $field) {
                    if ($key == 'billing_email' || $key == 'shipping_email' || $key == 'billing_company') {
                        continue;
                    }
                    if ($key == 'billing_country') {
                        if (empty($field['value'])) {
                            $field['value'] = 'US';
                        }
                        $billing_county = $field['value'];
                    }

                    if ($key == 'billing_state') {
                        $billing_county = isset($address['billing_country']['value']) ? $address['billing_country']['value'] : 'US';

                        $countries_obj = new WC_Countries();
                        $countries = $countries_obj->__get('countries');
                        $default_county_states = $countries_obj->get_states($billing_county);
                        if ($default_county_states) {
                            woocommerce_form_field(
                                $key,
                                array(
                                    'type' => 'select',
                                    'required' => true,
                                    'class' => array('chzn-dropp'),
                                    'label' => __('Select a state'),
                                    'placeholder' => __('Enter state'),
                                    'options' => $default_county_states
                                ),
                                $field['value']
                            );
                        } else {
                ?>
                            <label>State</label>
                            <input type="text" name="<?php echo $key; ?>" class="form-control" value="<?php echo $field['value']; ?>" />

                <?php
                        }
                        //echo $field['value'];
                        //get_stateByCountry_SBR('billing_state', $billing_county, $field['value']);
                    } else {
                        woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                    }
                }
                ?>
            </div>

            <div class="g-recaptcha" data-sitekey="6LcpUbIeAAAAAHVNlO9ov2TS2gPdNn0mEQ90YZ3i"></div>
            <div class="form-row al-order3">
                <button type="button" class="" id="create_payment_profile_mbt" value="Add payment method">Save payment & Billing method</button>
                <input type="hidden" name="action" value="addCustomerPaymentProfile" />


                <?php if ($payment_profile_id) {
                    echo '<input type="hidden" name="token_id" value="' . $token_id . '">';
                    echo '<input type="hidden" name="payment_profile_id" value="' . $payment_profile_id . '">';
                }  ?>
            </div>

        </div>
    </form>

    <script>
        jQuery('body').on('keypress', '#wc-authorize-net-cim-credit-card-account-number , #wc-authorize-net-cim-credit-card-expiry-year ,  #wc-authorize-net-cim-credit-card-csc', function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else {
                jQuery(this).css('border-color', '#7e8993');
            }
        });
        jQuery('body').on('click', '#create_payment_profile_mbt', function(e) {

            var clicked = true;
            $validate_cc = true;
            jQuery('body').find('#addPaymentMethod .validate-required input').each(function() {
                var currentItem = jQuery(this);
                if (currentItem.val() == '') {
                    $validate_cc = false;
                    currentItem.attr('style', 'border-color: red !important');
                } else {
                    currentItem.attr('style', 'border-color: #4BB543 !important');
                }
            });
            jQuery('body').find('#addPaymentMethod .validate-required select').each(function() {
                var currentItem = jQuery(this);
                if (currentItem.val() == '') {
                    $validate_cc = false;
                    currentItem.attr('style', 'border-color: red !important');
                } else {
                    currentItem.attr('style', 'border-color: #4BB543 !important');
                }
            });
            //    return;
            /*
            
            $validate_cc = true;
            $ccno = jQuery('body').find('#wc-authorize-net-cim-credit-card-account-number');
            $expiry_month = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-month');
            $expiry_year = jQuery('body').find('#wc-authorize-net-cim-credit-card-expiry-year');
            $csc = jQuery('body').find('#wc-authorize-net-cim-credit-card-csc');
            $billing_first_name = jQuery('body').find('#billing_first_name');
            $billing_last_name = jQuery('body').find('#billing_last_name');
            $billing_country = jQuery('body').find('#billing_country');
            $billing_address_1 = jQuery('body').find('#billing_address_1');
            $billing_city = jQuery('body').find('#billing_city');
            $billing_state = jQuery('body').find('#billing_state');
            $billing_postcode = jQuery('body').find('#billing_postcode');
            $billing_email = jQuery('body').find('#billing_email');
            $billing_phone = jQuery('body').find('#billing_phone');

            if ($ccno.val() == '') {
                $validate_cc = false;
                $ccno.css('border-color', 'red');
            } else {
                $ccno.css('border-color', '#4BB543');
            }
            if ($expiry_year.val() == '') {
                $validate_cc = false;
                $expiry_year.css('border-color', 'red');
            } else {
                $expiry_year.css('border-color', '#4BB543');
            }
            if ($expiry_month.val() == '') {
                $validate_cc = false;
                $expiry_month.css('border-color', 'red');
            } else {
                $expiry_month.css('border-color', '#4BB543');
            }
            if ($csc.val() == '') {
                $validate_cc = false;
                $csc.css('border-color', 'red');
            } else {
                $csc.css('border-color', '#4BB543');
            }
            */
            if ($validate_cc) {
                if (clicked) {
                    clicked = false;
                    jQuery('#responsePaymentMethodWapper').hide();
                    jQuery("#responsePaymentMethod").html('');
                    jQuery("#responsePaymentMethod").removeClass('errorCase');
                    jQuery("#responsePaymentMethod").removeClass('successCase');
                    jQuery('.loading-sbr').show();
                    //jQuery('body').find('#smile_brillaint_payment_gateway_user').empty();
                    e.preventDefault();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                    var elementT = document.getElementById("addPaymentMethod");
                    var formdata = new FormData(elementT);
                    jQuery.ajax({
                        url: ajaxurl,
                        data: formdata,
                        async: true,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function(res) {
                            clicked = true;
                            grecaptcha.reset(); // Reset the reCAPTCHA widget
                            if (res.response === false) {
                                jQuery("#responsePaymentMethod").addClass('errorCase');
                            } else {
                                jQuery("#responsePaymentMethod").addClass('successCase');
                                <?php if ($payment_profile_id == 0) { ?>
                                    jQuery("#addPaymentMethod").trigger("reset");
                                    jQuery("#addPaymentMethod #billing_country").trigger("change");
                                    window.setTimeout(function() {
                                        window.location.href = '<?php echo site_url('/my-account/payment-methods/') ?>';
                                    }, 2000);
                                <?php } ?>

                            }
                            jQuery('body').find('#addPaymentMethod .validate-required input').each(function() {
                                var currentItem = jQuery(this);
                                currentItem.removeAttr('style');
                            });
                            jQuery('body').find('#addPaymentMethod .validate-required select').each(function() {
                                var currentItem = jQuery(this);
                                currentItem.removeAttr('style');
                            });
                            jQuery("#responsePaymentMethod").html(res.error);
                            // jQuery("#responsePaymentMethod").show("slow").delay(3000);
                            jQuery('#responsePaymentMethodWapper').show("slow").delay(3000);
                            jQuery('.loading-sbr').hide();
                            jQuery("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        },
                        error: function() {
                            clicked = true;
                            jQuery('.loading-sbr').hide();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            }

        });
    </script>
<?php

}


//
add_action('wp_ajax_saveNickCIM', 'saveNickCIM_callback');
function saveNickCIM_callback()
{
    $token = 0;
    $error_flag = false;
    if (isset($_REQUEST['token_id']) && empty($_REQUEST['token_id'])) {
        $error_message[] = 'Customer token ID missing.';
        $error_flag = true;
    }
    if (isset($_REQUEST['nickname']) && empty($_REQUEST['nickname'])) {
        $error_message[] = 'Card name required.';
        $error_flag = true;
    }
    if ($error_flag) {
        $response = array(
            'response' => false,
            'error' => str_replace('"', '\"', implode('<br/>', $error_message))
        );
        echo json_encode($response);
    } else {

        $token =  $_REQUEST['token_id'];
        global $wpdb;
        $tbl = $wpdb->prefix . 'woocommerce_payment_tokens';
        $sqlQuery = "SELECT token_id FROM $tbl WHERE token ='$token'";
        $token_payment_id = $wpdb->get_var($sqlQuery);
        $nickname = stripslashes($_REQUEST['nickname']);
        $response = array(
            'response' => true,
            'error' => 'Updated Successfully.'
        );
        addPaymentTokenMetaSBR('nickname', $nickname, $token_payment_id);
        echo json_encode($response);
    }
    die;
}
add_action('wp_ajax_addCustomerPaymentProfile', 'addCustomerPaymentProfile_callback');
function addCustomerPaymentProfile_callback()
{
//die();
    //echo 'Data: <pre>' . print_r($_REQUEST, true) . '</pre>';
    //die;

    $error_message = array();
    $error_flag = false;

    $recaptcha_secret = "6LcpUbIeAAAAAE4_GcvvLdPslwRVqdl2sCueTXWh";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    if ($response->success) {
        // reCAPTCHA verification successful, process the form
    } else {
        $error_message[] = 'Captcha required.';
        $error_flag = true;
    }

    if (isset($_REQUEST['customer_user_mbt']) && empty($_REQUEST['customer_user_mbt'])) {
        $error_message[] = 'Customer ID required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_first_name']) && empty($_REQUEST['billing_first_name'])) {
        $error_message[] = 'Billing first name required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_last_name']) && empty($_REQUEST['billing_last_name'])) {
        $error_message[] = 'Billing last name required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_phone']) && empty($_REQUEST['billing_phone'])) {
        $error_message[] = 'Billing phone number required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_city']) && empty($_REQUEST['billing_city'])) {
        $error_message[] = 'Billing city required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_address_1']) && empty($_REQUEST['billing_address_1'])) {
        $error_message[] = 'Billing address required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_postcode']) && empty($_REQUEST['billing_postcode'])) {
        $error_message[] = 'Billing postcode required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_state']) && empty($_REQUEST['billing_state'])) {
        $error_message[] = 'Billing state required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['billing_country']) && empty($_REQUEST['billing_country'])) {
        $error_message[] = 'Billing country required.';
        $error_flag = true;
    }

    if (isset($_REQUEST['wc-authorize-net-cim-credit-card-account-number']) && empty($_REQUEST['wc-authorize-net-cim-credit-card-account-number'])) {
        $error_message[] = 'Credit card number  .';
        $error_flag = true;
    } else {
        if (sbr_validateCC($_REQUEST['wc-authorize-net-cim-credit-card-account-number']) == false) {
            $error_message[] = 'Credit card number invalid.';
            $error_flag = true;
        }
    }
    if (isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-month']) && empty($_REQUEST['wc-authorize-net-cim-credit-card-expiry-month'])) {
        $error_message[] = 'Credit card expiry month required.';
        $error_flag = true;
    }
    if (isset($_REQUEST['wc-authorize-net-cim-credit-card-expiry-year']) && empty($_REQUEST['wc-authorize-net-cim-credit-card-expiry-year'])) {
        $error_message[] = 'Credit card expiry year required.';
        $error_flag = true;
    } else {
        $userInput = $_REQUEST['wc-authorize-net-cim-credit-card-expiry-month'] . '-' . $_REQUEST['wc-authorize-net-cim-credit-card-expiry-year'];
        $cardDate = DateTime::createFromFormat('m-y', $userInput);
        if ($cardDate != '' && $cardDate != false) {
            $currentDate = new DateTime('now');
            $interval = $currentDate->diff($cardDate);
            if ($interval->invert == 1) {
                $error_message[] = 'Credit card date expired.';
                $error_flag = true;
            }
        }
    }
    if (isset($_REQUEST['wc-authorize-net-cim-credit-card-csc']) && empty($_REQUEST['wc-authorize-net-cim-credit-card-csc'])) {
        $error_message[] = 'Credit card csc required.';
        $error_flag = true;
    }
    if ($error_flag) {
        $response = array(
            'response' => false,
            'error' => str_replace('"', '\"', implode('<br/>', $error_message))
        );
    } else {
        if (isset($_REQUEST['customer_user_mbt'])) {
            $user_id = $_REQUEST['customer_user_mbt'];
        } else {
            $user_id = get_current_user_id();
        }

        $cust_profile_id = get_user_meta($user_id, USER_CIM_PROFILE_ID, true);
        $first_name = isset($_REQUEST['billing_first_name']) ? $_REQUEST['billing_first_name'] : '';
        $last_name = isset($_REQUEST['billing_last_name']) ? $_REQUEST['billing_last_name'] : '';
        $address = isset($_REQUEST['billing_address_1']) ? $_REQUEST['billing_address_1'] : '';
        $city = isset($_REQUEST['billing_city']) ? $_REQUEST['billing_city'] : '';
        $postcode = isset($_REQUEST['billing_postcode']) ? $_REQUEST['billing_postcode'] : '';
        $state = isset($_REQUEST['billing_state']) ? $_REQUEST['billing_state'] : '';
        $country = isset($_REQUEST['billing_country']) ? $_REQUEST['billing_country'] : '';
        $phone = isset($_REQUEST['billing_phone']) ? $_REQUEST['billing_phone'] : '';
        $user_info = get_userdata($user_id);
        $card_account_number = $_REQUEST['wc-authorize-net-cim-credit-card-account-number'];
        $month = $_REQUEST['wc-authorize-net-cim-credit-card-expiry-month'];
        $year = $_REQUEST['wc-authorize-net-cim-credit-card-expiry-year'];
        $csc = $_REQUEST['wc-authorize-net-cim-credit-card-csc'];
        $payment_profile_id = $_REQUEST['payment_profile_id'];
        
        if (isset($_REQUEST['payment_profile_id'])) {
            $data = '{
                "updateCustomerPaymentProfileRequest": {
                    "merchantAuthentication": {
                        "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                        "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                    },
                "customerProfileId": "' . $cust_profile_id . '",
                "paymentProfile": {
                    "billTo": {
                        "firstName": "' . $first_name . '",
                        "lastName": "' . $last_name . '",
                        "address": "' . $address . '",
                        "city": "' . $city . '",
                        "state": "' . $state . '",
                        "zip": "' . $postcode . '",
                        "country": "' . $country . '",
                        "phoneNumber": "' . $phone . '"
                },
                    "payment": {
                        "creditCard": {
                            "cardNumber": "' . $card_account_number . '",
                            "expirationDate": "' . $year . '-' . $month . '",
                            "cardCode": "' . $csc . '"
                        }
                    },
                    "defaultPaymentProfile": false,
                    "customerPaymentProfileId": "' . $payment_profile_id . '"
                },
                "validationMode": "' . SB_AUTHORIZE_ENV . '"
                }
            }';
        } else {
            if ($cust_profile_id == '') {
                $data = '{
                        "createCustomerProfileRequest": {
                            "merchantAuthentication": {
                                "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                                "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                        },
                        "profile": {
                                "merchantCustomerId": "' . $user_id . '",
                                "description": "Smile Brilliant Customer",
                                "email": "' . $user_info->user_email . '",
                                "paymentProfiles": {
                                "billTo": {
                                        "firstName": "' . $first_name . '",
                                        "lastName": "' . $last_name . '",
                                        "address": "' . $address . '",
                                        "city": "' . $city . '",
                                        "state": "' . $state . '",
                                        "zip": "' . $postcode . '",
                                        "country": "' . $country . '",
                                        "phoneNumber": "' . $phone . '"
                                        },
                                "payment": {
                                "creditCard": {
                                    "cardNumber": "' . $card_account_number . '",
                                    "expirationDate": "' . $year . '-' . $month . '",
                                    "cardCode": "' . $csc . '"
                                }
                                }
                        }
                    },
                    "validationMode": "' . SB_AUTHORIZE_ENV . '" 
            }
        }';
            } else {

                $data = '{
                    "createCustomerPaymentProfileRequest": {
                        "merchantAuthentication": {
                            "name": "' . SB_AUTHORIZE_LOGIN_ID . '",
                            "transactionKey": "' . SB_AUTHORIZE_TRANSACTION_KEY . '"
                        },
                    "customerProfileId": "' . $cust_profile_id . '",
                    "paymentProfile": {
                        "billTo": {
                            "firstName": "' . $first_name . '",
                            "lastName": "' . $last_name . '",
                            "address": "' . $address . '",
                            "city": "' . $city . '",
                            "state": "' . $state . '",
                            "zip": "' . $postcode . '",
                            "country": "' . $country . '",
                            "phoneNumber": "' . $phone . '"
                    },
                        "payment": {
                            "creditCard": {
                                "cardNumber": "' . $card_account_number . '",
                                "expirationDate": "' . $year . '-' . $month . '",
                                "cardCode": "' . $csc . '"
                            }
                        },
                        "defaultPaymentProfile": false
                    },
                    "validationMode": "' . SB_AUTHORIZE_ENV . '"
                    }
                }';
            }
        }
        $send_Curl= true;

        if($first_name =='halina' || $first_name =='Halina') {
            $send_Curl = false;
        }
        if($first_name =='BVGTF' || $first_name =='Yvonne') {
            $send_Curl = false;
        }
        $max_count = 9999999999;
        if ( ! is_super_admin() ) {
            $max_count = 3;
        }
        $current_userid = get_current_user_id();
        $authorize_failed_attempt_count =  get_user_meta($current_userid,'authorize_failed_attempt_count',true);

        if($authorize_failed_attempt_count>=$max_count) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        $randstring3 = 'fake_user_res_'.$first_name.'_'.$randstring;
          
            $response = array(
                'response' => true,
                'user_id'=>get_current_user_id(),
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'user_email'=>$user_info->user_email,
                'last_4'=>preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number),
                'expirationDate'=>$year . '-' . $month,
                'cardCode'=>$csc,
                'randstring'=>$randstring3
            );
           
            update_option( $randstring3, json_encode($response) );
            $authorize_failed_attempt_count = (int) $authorize_failed_attempt_count+1;
            update_user_meta($current_userid,'authorize_failed_attempt_count',$authorize_failed_attempt_count);
            echo json_encode($response);
            $message_to = "Hey Team,We've spotted suspicious activity. user ".$first_name." whose user id:".$current_userid."is trying to verify cards via our payment system";
            send_twilio_text_sms('+923214401191',$message_to);
            send_twilio_text_sms('+923328030748',$message_to);
            send_twilio_text_sms('+16363465155',$message_to);
            die();
          //  die();
        }
        // echo $data;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => SB_AUTHORIZE_ENV_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $str = curl_exec($curl);
        curl_close($curl);
        for ($i = 0; $i <= 31; ++$i) {
            $response = str_replace(chr($i), "", $str);
        }
        $response = str_replace(chr(127), "", $str);
        if (0 === strpos(bin2hex($response), 'efbbbf')) {
            $response = substr($response, 3);
        }
        $responseAPI = json_decode($response, true);
        // echo 'Data: <pre>' . print_r($response, true) . '</pre>';
        if (isset($responseAPI['customerProfileId']) && (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Ok')) {
            $error_flag = false;
            $response_msg = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
            $customer_profile_id = $responseAPI['customerProfileId'];
            if ($cust_profile_id == '') {
                $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileIdList'][0];
                update_user_meta($user_id, USER_CIM_PROFILE_ID, $customer_profile_id);
            } else {
                $customerPaymentProfileIdList = $responseAPI['customerPaymentProfileId'];
            }
            $response = get_authorize_profile_info_by_profile_id($customer_profile_id, $customerPaymentProfileIdList);
            $last4Digits = preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number);
            $token = new WC_Payment_Token_CC();
            $token->set_token($customerPaymentProfileIdList);
            $token->set_gateway_id('authorize_net_cim_credit_card');
            if (isset($response['paymentProfile']['payment']['creditCard']['cardType'])) {
                $token->set_card_type(strtolower($response['paymentProfile']['payment']['creditCard']['cardType']));
            } else {
                $token->set_card_type('visa');
            }
            //$token->create(); // save to database
            $token->set_last4($last4Digits);
            $token->set_expiry_month($month);
            $token->set_expiry_year($year);
            $token->set_user_id($user_id);
            $token->save();
            // echo 'Data: <pre>' . print_r($token, true) . '</pre>';
            addPaymentTokenMetaSBR('customer_profile_id', $customer_profile_id, $token->get_id());
            if (isset($_REQUEST['payment_method_hsa_hfa'])) {
                addPaymentTokenMetaSBR('hsa_fsa', 'yes', $token->get_id());
            } else {
                addPaymentTokenMetaSBR('hsa_fsa', 'no', $token->get_id());
            }
        } else {
            if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Error') {
                $error_flag = true;
            } else {
                if (isset($responseAPI['messages']['resultCode']) && $responseAPI['messages']['resultCode'] == 'Ok') {
                    $token =  $_REQUEST['token_id'];
                    if (isset($_REQUEST['payment_method_hsa_hfa'])) {

                        addPaymentTokenMetaSBR('hsa_fsa', 'yes', $token);
                    } else {
                        addPaymentTokenMetaSBR('hsa_fsa', 'no', $token);
                    }
                    $token = new WC_Payment_Token_CC();
                    $token->set_token($payment_profile_id);
                    $token->set_gateway_id('authorize_net_cim_credit_card');
                    $last4Digits = preg_replace("#(.*?)(\d{4})$#", "$2", $card_account_number);
                    $token->set_last4($last4Digits);
                    $token->set_expiry_month($month);
                    $token->set_expiry_year($year);
                    $token->update();

                    $customer_profile_id = get_user_meta(get_current_user_id(), USER_CIM_PROFILE_ID, true);
                    addPaymentTokenMetaSBR('customer_profile_id', $customer_profile_id, $token->get_id());
                }
            }
        }
        $error_message = isset($responseAPI['messages']['message'][0]['text']) ? $responseAPI['messages']['message'][0]['text'] : '';
        if ($error_flag) {
           
            $authorize_failed_attempt_count =  get_user_meta($current_userid,'authorize_failed_attempt_count',true);
            if($authorize_failed_attempt_count =='') {
                $authorize_failed_attempt_count = 0;
            }
            $authorize_failed_attempt_count = (int) $authorize_failed_attempt_count+1;
            update_user_meta($current_userid,'authorize_failed_attempt_count',$authorize_failed_attempt_count);
            $response = array(
                'response' => false,
                'error' => $error_message . ' <br/>Please contact with customer support with relevant information.'
            );
        } else {
            $added = 'Payment method added ';
            if (isset($_REQUEST['payment_profile_id'])) {
                $added = 'Payment method updated ';
            }
            //  echo $user_id;
            $response = array(
                'response' => true,
                'resultHTML' => mbt_getUserCIM_profiles($user_id),
                'error' => $added . $error_message,
            );
        }
    }
    echo json_encode($response);
    die;
}



//add_action('woocommerce_account_edit_payment_card_endpoint', 'sbr_customer_dashboard_addNewPayemnt_content');
//add_action('woocommerce_account_add_payment_card_endpoint', 'sbr_customer_dashboard_addNewPayemnt_content');

function sbr_customer_dashboard_endpoints()
{
    add_rewrite_endpoint('reward', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('reward_dashboard', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('shine_subscription', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('my_oral_profile', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('customer_discounts', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('shine_card', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('shine_discounts', EP_ROOT | EP_PAGES);
   // add_rewrite_endpoint('add_payment_card', EP_ROOT | EP_PAGES);
  //  add_rewrite_endpoint('edit_payment_card', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('support', EP_ROOT | EP_PAGES);
}

add_action('init', 'sbr_customer_dashboard_endpoints');

// ------------------
// 2. Add new query var

function sbr_customer_dashboard_query_vars($vars)
{
    $vars[] = 'reward';
    $vars[] = 'reward_dashboard';
    $vars[] = 'support';
    $vars[] = 'shine_card';
    $vars[] = 'shine_discounts';
    $vars[] = 'shine_subscription';
    $vars[] = 'my_oral_profile';
    $vars[] = 'customer_discounts';
  //  $vars[] = 'add_payment_card';
   // $vars[] = 'edit_payment_card';

    return $vars;
}

add_filter('query_vars', 'sbr_customer_dashboard_query_vars', 0);


add_filter("woocommerce_get_query_vars", function ($vars) {

    foreach (["reward", "support", "add_payment_card", "reward_dashboard", "edit_payment_card", "manage-shipping-address", "shine_card", "shine_discounts", "shine_subscription","my_oral_profile","customer_discounts"] as $e) {
        $vars[$e] = $e;
    }

    return $vars;
});
// ------------------
// 3. Insert the new endpoint into the My Account menu

function sbr_customer_dashboard_link_my_account($items)
{
    if (affwp_get_affiliate_id()) {
        $items['reward_dashboard'] = 'Reward Dashboard';
    } else {
        $items['reward'] = 'Reward';
    }
    $items['support'] = 'Support';
    $items['shine-subscription'] = 'Shine Subscription';
    $items['shine-card'] = 'Membership Card';
    $items['my_oral_profile'] = 'My Oral Profile';
    $items['add_payment_card'] = 'Add Payment Method';
    $items['edit_payment_card'] = 'Edit Payment Method';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'sbr_customer_dashboard_link_my_account');



add_action('woocommerce_account_my_oral_profile_endpoint', 'sbr_customer_account_my_oral_profile_content');
function sbr_customer_account_my_oral_profile_content() {
    ?>
     <div class="rewardsDashboardSection">
        <div class="d-flex align-items-center menuParentRowHeading borderBottomLine">
            <div class="pageHeading_sec" style="padding-bottom: 15px">
                <span><span class="text-blue">My Oral Profile</span>
                    Manage your oral profile</span>
            </div>
        </div>
        <div class="db-row justify-content-center db-row-edit-container oral-profile-tab-content">
            <?php 
            
            echo get_template_part('page-templates/page-oral-profile'); ?>

</div>
</div>

        <?php
}
add_action('woocommerce_account_reward_dashboard_endpoint', 'sbr_customer_account_reward_dashboard_content');
function sbr_customer_account_reward_dashboard_content()
{
?>


    <div class="rewardsDashboardSection">
        <div class="d-flex align-items-center menuParentRowHeading">
            <div class="pageHeading_sec">
                <span><span class="text-blue">Rewards</span>
                    Earn commissions &amp; perks</span>
            </div>
        </div>
        <div class="db-row justify-content-center db-row-edit-container">
            <?php
            $field_value = '';
            if(function_exists('bp_is_active')){
            $field_value = bp_get_profile_field_data(array(
                'field' => 'Referral',
                'user_id' => get_current_user_id(),

            ));
        }
            if ($field_value == '') {
            ?>
                <div class="col-md-4 db-col-6 padd-right7">
                    <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=urls'); ?>" class="linkdetail block ripple-button">
                        <div class="dashboard-box profileSection">
                            <div class="dashboardPanel">
                                <div class="dashboard-icon icon-statistics">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/affiliate.svg" alt="">
                                </div>
                                <div class="dashboard_description">
                                    <h4 class="uppercase"><strong>affiliate URL</strong></h4>
                                    <p class="text-gray">Earn commissions & perks</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <div class="col-md-4 db-col-6 padd-right7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=stats'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box profileSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-statistics">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/statistics.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>statistics</strong></h4>
                                <p class="text-gray">Earn commissions & perks</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 db-col-6 padd-left7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=graphs'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box orderSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-graphs">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/graph.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Graphs</strong></h4>
                                <p class="text-gray">Track, return or buy items again.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 db-col-6 padd-right7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=referrals'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box BillingShippingSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-referrals">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/refferals.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Referrals</strong></h4>
                                <p class="text-gray">Manage your shipping addresses.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 db-col-6 padd-right7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=payouts'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box BillingShippingSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-payouts">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/payouts.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Payouts</strong></h4>
                                <p class="text-gray">Manage Billing Methods.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 db-col-6 padd-right7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=visits'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box messageSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-visits">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/visits.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Visits</strong></h4>
                                <p class="text-gray">Your communication with customer support.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 db-col-6 padd-left7">
                <a href="<?php echo esc_url(home_url() . '/my-account/reward/?tab=settings'); ?>" class="linkdetail block ripple-button">
                    <div class="dashboard-box rewardsSection">
                        <div class="dashboardPanel">
                            <div class="dashboard-icon icon-settings">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rewards/settings.svg" alt="">
                            </div>
                            <div class="dashboard_description">
                                <h4 class="uppercase"><strong>Settings</strong></h4>
                                <p class="text-gray">Earn commissions &amp; perks.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>

<?php
}

function customerSupportAddEditTicket($zendesk_user_id, $ticket_id = 0)
{

    // $t = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik5BSjZ6WUMwWmN2ZjBDOVFMR0htLSJ9.eyJpc3MiOiJodHRwczovL3NpbmFsaXRlLnVzLmF1dGgwLmNvbS8iLCJzdWIiOiJ2Z09xd2tkWTlmRkdoeXVDRjNLTEllaWRiWlkwSkEyckBjbGllbnRzIiwiYXVkIjoiaHR0cHM6Ly9hcGljb25uZWN0LnNpbmFsaXRlLmNvbSIsImlhdCI6MTY1NDA2NzEyMCwiZXhwIjoxNjU0NjcxOTIwLCJhenAiOiJ2Z09xd2tkWTlmRkdoeXVDRjNLTEllaWRiWlkwSkEyciIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.QH0X7JHDAcl-DOfAWi3onh_92JTthYf7tjWPqc_ckRoR45F_yntj_hbxeOboXpxls3xJStEy5eP9UZfSvCba0tTjGU-J8vS476GTweZ-PgN7lvLqplGz7UQGKh4F3CD6I8UMVNP7ELsAaJIeeVowMAQI8aNltKcVl_uhgCr-5dtGZH_WcNkAedYcaxv2Bw_4aAKXkrFzDe4b_VG9asHf65B0n2Tfk4EQSW1VRILFNFJ9JEtMQs0suF6pkIyBS_jWGTD-nSxTdyCSNzCn4aYpco1gPP0o8stPbAqGz4oDwfc4QIz0Qk0bXEG3oUA23ATb59ayTLY1lZsSyEFmEh9_Kg';
    // $data = cutomergetProducts($t);
    // echo '<pre>';
    // print_r(json_decode($data , true));
    // echo '</pre>';
    if ($ticket_id) {
        $ticketInfo = sb_ticket_comments_zendesk($ticket_id);
        if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
            $responseTicket = $ticketInfo['html'];
            $ticket_status = $ticketInfo['status'];
            $subjectTicketId = $ticketInfo['subject'];
            $created_at = $ticketInfo['created_at'];
            $updated_at = $ticketInfo['updated_at'];




            echo '<div class="ticketListItem">';
            echo '<div class="ticketListItemTopParentRow">';
            echo '<div class="ticketListItemTopRow">';
            echo '<div class="ticketId font-mont"><span class="ticketIcon"><i class="fa fa-life-ring" aria-hidden="true"></i>
            </span> #' . $ticket_id . '</div>';
            echo '<div class="ticketListItemDateWapper ticketListItemDateWapperFlexWrapperMbt flexDirectionColumn">';
            echo '<div class="ticketCreated  "><span class="startedDate">Started:</span> ' .   $created_at . '</div>';
            if ($ticket_status == 'solved' || $ticket_status == 'closed') {
                echo '<div class="ticketUpdated  ticketCreated "><span class="completedDate">Completed: </span>' .   $updated_at . '</div>';
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="ticketSubject  text-left flexRowDiv">';
            echo '<div class="ticketRowMbt">' . $subjectTicketId . '</div>';
            echo '<div class="ticketStatus parentItemRowMbtTxt">';
            echo '<div class="ticketStatus ' . $ticket_status . '"><span class="statucTag">Status: </span>' . ucfirst($ticket_status) . '</div>';
            if (in_array($ticket_status, array('open', 'new'))) {
                echo '<form method="post" class="markFormDisplay">';
                echo '<input  type="hidden"  name="ticket_id" value="' . $ticket_id . '"  />';
                echo '<input  type="hidden"  name="user_id" value="' . $zendesk_user_id . '"  />';
                echo '<button class="zendeskSolveTicket buttonDefault  blueBg "  type="submit" >Mark as solved</button>';
                echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="ticketStatus hidden ' . $ticket_status . '">' . ucfirst($ticket_status) . '</td>';
            echo '</div>';
            echo '</div>';

            echo '<div class="ticketBody">';
            echo $responseTicket;
            echo '</div>';
        }
    }

    if ($ticket_id != 0) :
        if (!in_array($ticket_status, array('open', 'new', 'solved', 'pending'))) {
            return;
        }
    endif;
?>
    <form id="customer_zendesk_chat" enctype="multipart/form-data">

        <div class="flex-cont">

            <?php if ($ticket_id == 0) : ?>
                <h3 class="messageType">Message Type</h3>
                <div class="selectwrap">
                    <select name="type" class="ticketType">
                        <option value="general_inquiry">General Inquiry</option>
                        <option value="help_with_product">Help With Product</option>
                        <option value="product_review">Product Review</option>
                        <?php if ($_REQUEST['type'] == 'refund') {
                            echo '<option value="product_return" selected="">Product Return</option>';
                        } else {
                            echo '<option value="product_return">Product Return</option>';
                        } ?>

                        <option value="order_status">Order Status</option>
                        <option value="electric_toothbrush_warranty_claim">Electric Toothbrush Warranty Claim</option>
                        <option value="whitening_tray_replacement_request">Whitening Tray Replacement Request</option>
                        <option value="night_guard_reorder_request">Night Guard Reorder Request</option>
                        <option value="wholesale_inquiry">Wholesale Inquiry</option>
                        <option value="partnership/collaboration_inquiry">Partnership/Collaboration Inquiry</option>
                    </select>
                </div>
            <?php endif; ?>
            <div class="message-box-container">
                <h3 class="typeMEssageText">Write Message</h3>
                <input type="hidden" name="action" value="send_ticket_message_customer" />
                <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>" />
                <input type="hidden" name="zendesk_user_id" value="<?php echo $zendesk_user_id; ?>" />
                <?php
                $description = '';
                $description_field = 'message_input_' . rand();
                //Provide the settings arguments for this specific editor in an array
                $description_args = array('media_buttons' => false, 'textarea_rows' => 30, 'textarea_name' => 'message', 'wpautop' => false, 'quicktags' => false);
                wp_editor($description, $description_field, $description_args);
                ?>
                <div class="parent-div-field">
                    <div id="fileUploadZendesk">
                        <!-- Upload Area -->
                        <div id="uploadArea" class="upload-area">
                            <!-- Header -->
                            <div class="upload-area__header">
                                <h1 class="upload-area__title">Upload picture</h1>

                            </div>
                            <!-- End Header -->

                            <!-- Drop Zoon -->
                            <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                <input type="file" id="attachments_zendesk" onchange="uploadTicketAttachment(this)" multiple />
                                <span class="drop-zoon__icon">

                                    <span class="bx bxs-file-image dashicons dashicons-images-alt2"></span>
                                </span>
                                <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">

                            </div>
                            <!-- End Drop Zoon -->
                            <p class="upload-area__paragraph">
                                If applicable, please upload pictures to help our staff with your request. If you are writing a review, please upload your before-and-after photos here.
                                <!-- 
                                Only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.
                                <strong class="upload-area__tooltip" style="display: none;">
                                    Like
                                    <span class="upload-area__tooltip-data">jpeg, .png, .gif</span>
                                </strong> -->
                            </p>

                            <!-- File Details -->
                            <div id="fileDetails" class="upload-area__file-details file-details">
                                <!--                            <h3 class="file-details__title">Uploaded File</h3>-->


                                <div class="progress" style="display: none">
                                    <div class="progress-bar" style="width: 0%;"></div>
                                </div>
                                <div id="attachmentContainer">

                                </div>

                            </div>
                        </div>
                        <!-- End File Details -->
                    </div>
                    <!-- End Upload Area -->

                </div>
            </div>
        </div>
        <button type="button" id="btn_customer_zendesk_chat" class="btn btn-danger button message-send">Send
            Message</button>
    </form>


<?php
}
add_action(
    'wp_ajax_zendeskCS',
    'sbr_customer_dashboard_support_content'
);

function sbr_customer_dashboard_support_content()
{

?>
    <style>
        #SBRCustomerDashboard {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    </style>
    <?php
    echo '<div id="SBRCustomerDashboard">';
    $current_user = get_current_user_id();
    $user_email = get_user_meta($current_user, 'billing_email', true);
    $billing_first_name = get_user_meta($current_user, 'billing_first_name', true);
    $billing_last_name = get_user_meta($current_user, 'billing_last_name', true);
    $billing_phone = get_user_meta($current_user, 'billing_phone', true);
    $zendesk_user_id = sb_search_user_zendesk($user_email);

    $support = (get_query_var('support')) ? get_query_var('support') : 0;
    if ($zendesk_user_id) {
    } else {
        $data = array(
            'name' => $billing_first_name . ' ' . $billing_last_name,
            'email' => $user_email,
            'phone' => $billing_phone,
        );
        $zendesk_user_id = sb_create_user_zendesk($data);
    }
    $field_value = '';
    if(function_exists('bp_is_active')){
    $field_value = bp_get_profile_field_data(array(
        'field' => 'Referral',
        'user_id' => $current_user,

    ));
}
    if ($field_value == '' || !isset($_GET['active-tab'])) {
        $heading_text = 'Support center';
        $subheading = 'Connect with our team';
    } else {
        $heading_text = 'Communication hub';
        $subheading = 'Discuss/Connect/Respond with smilebrilliant community';
    }
    echo '<div class="MessageDisplayFile"> 
        <div class="d-flex align-items-center menuParentRowHeading">
        <div class="pageHeading_sec">
            <span><span class="text-blue">' . $heading_text . '</span>' . $subheading . '.</span> 
        </div>                        
        </div>
        </div>';

    echo '<ul class="nav nav-tabs  mt-3 customTabs tabsDesktop hidden-mobile rdhTicketsMessage">';
    echo '<li class="nav-item messageTabLink">';
    echo '<a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-message-tab" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-message" aria-selected="false">Support Tickets';
    echo '</a>';
    echo '</li>';
    $field_value = '';
    if(function_exists('bp_is_active')){
    $field_value = bp_get_profile_field_data(array(
        'field' => 'Referral',
        'user_id' => get_current_user_id(),

    ));
}
    if ($field_value == '') {
        echo '<li class="nav-item" style="display: none;">';


        echo '<a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-chat-tab" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-chat" aria-selected="false">RDHC Messaging';
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';

    echo '<div class="chatBoxWrapperContainer chat-info-section tab" id="chat_info">';
    echo show_chat_widget_rdh_backend(get_current_user_id());
    echo '</div><script>$(document).ready(function() {
            $("#pills-message-tab")[0].click();
           $("#pills-message-tab").on("click", function() {
                $(".chat-info-section.tab").removeClass("active");     
                $(".message-info-section.tab").addClass("active");
           });
   
           $("a#pills-chat-tab").on("click", function() {
                $(".message-info-section.tab").removeClass("active");
                $(".chat-info-section.tab").addClass("active");            
            });
   
   
       });
   </script>';
    if (isset($_REQUEST['user_id']) && isset($_REQUEST['ticket_id']) && trim($_REQUEST['user_id']) > 0) {
        $response =  mbt_close_ticket($_REQUEST['ticket_id'], true);
        if (isset($response['status']) && $response['status'] == 'success') {
            echo '<div class="alert alert-success" role="alert">' . $response['message'] . '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">' . $response['message'] . '</div>';
        }
    }

    if (is_numeric($support) &&  $support > 0) {

        echo ' <div class="d-flex align-items-center orderDetailFile breadCrumbsListWrapper justify-content-between borderBottomLine paddingBottom15">';
        echo '<div class="crumbTrail">';
        echo ' <ul class="breadcrumbItem">';
        echo ' <li><a href="' . home_url('my-account/support') . '">All Messages</a></li>';
        echo ' <li><a href="javascript:void(0);">#' . basename($_SERVER["REQUEST_URI"]) . '</a></li>';
        echo ' </ul>';
        echo '  </div>';
        echo ' <div class="button text-right goBackDetailPage hidden-mobile"><a href="' . wc_get_account_endpoint_url('support') . '" class="buttonDefault smallRipple ripple-button">Go Back</a></div>';
        echo ' <div class="button text-right goBackDetailPage arrowBtn hiddenDesktop"><a href="' . wc_get_account_endpoint_url('support') . '" class="backButton" ><i class="fa fa-angle-left" aria-hidden="true"></i></a></div>';
        echo '</div>';

        echo '<div class="ticketHeading d-flex hidden">';
        echo '<div class="text-right">';
        echo '<span class="textChangeAble"><strong></strong></span>';
        echo '</div>';
        echo '<div class="button text-right">';
        //wc_get_account_endpoint_url
        //echo '<a href="javascript:void(0)" class="buttonDefault smallRipple ripple-button" onclick="dashboardAjaxRequest(\'zendeskCS&tab=all\' )">Go Back</a>';

        echo '<a href="' . wc_get_account_endpoint_url('support') . '" class="buttonDefault smallRipple ripple-button">Go Back</a>';
        echo '</div>';
        echo '</div>';

        customerSupportAddEditTicket($zendesk_user_id, $support);
    } else if ($support ===  'add') {
        echo '<div id="addNewTicket">';
        echo '<div class="ticketHeading">';
        echo '<div class="text-right">';
        echo '<span class="hidden customerSupportTempHide">Customer Support </span>';
        echo '</div>';
        echo '<div class="button text-right">';
        echo '<a href="' . wc_get_account_endpoint_url('support') . '" class="buttonDefault smallRipple ripple-button">Go Back</a>';
        echo '</div>';
        echo '</div>';
        echo '<div id="chat_container">';
        customerSupportAddEditTicket($zendesk_user_id, 0);
        echo '</div>';
        echo  '</div>';
    } else {
        $list = '';
        $url = "https://" . MBT_ZENDESK_HOST . ".zendesk.com/api/v2/users/$zendesk_user_id/tickets/requested";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $results = json_decode($result, true);

        echo '<div class="ticketListContainner message-info-section tab active" id="message_info">';
        $new = wc_get_account_endpoint_url('support/add/');

        if (isset($results['count']) && $results['count'] > 0) {
            echo '<div class="totalCount"><div class="messageTitle alignRowData">
            <strong class="font-mont">Messages</strong>
            <a href="' . $new . '" class="buttonDefault smallRipple ripple-button blueBg " id="addNewTicketBtn">new ticket</a>
            </div>Showing 1 to ' . $results['count'] . ' of ' . $results['count'] . ' tickets</div>';
            foreach ($results['tickets'] as $key => $ticket) {

                $content = wp_strip_all_tags($ticket['description']);




                echo '<div class="ticketListItem">';
                echo '<div class="ticketListItemRepeat">';

                $link = wc_get_account_endpoint_url('support/' . $ticket['id']);
                echo '<a href="' . $link . '" class="clickableAnchor">';

                echo '<div class="ticketListItemTopRow">';
                echo '<div class="ticketId font-mont"><span class="ticketIcon"><i class="fa fa-life-ring" aria-hidden="true"></i>
                </span> #' . $ticket['id'] . '</div>';
                echo '<div class="ticketCreated font-mont">' .   sbr_datetime($ticket['created_at']) . '</div>';
                echo '</div>';

                echo '<div class="ticketSubject font-mont">';

                echo '<div class="mobileLayoutAdj d-flex justify-content-between">';
                echo '<div class="ticketRowMbt">' . $ticket['subject'] . '</div>';
                echo '<div class="ticketStatus font-mont hiddenDesktop ' . $ticket['status'] . '">';
                echo '<span class="statucTag">Status: </span>' . ucfirst($ticket['status']);
                echo '</div>';
                echo '</div>';
                echo '<div class="ticketListItemWapper">';
                echo '<div class="ticketRowMbtContent">' . wp_trim_words($content, 20, '...<span class="readMoreMsg">Read More</span>') . '</div>';
                echo '<div class="ticketStatus font-mont hidden-mobile ' . $ticket['status'] . '">';
                echo '<span class="statucTag">Status: </span>' . ucfirst($ticket['status']);
                echo '</div>';

                echo '</div>';
                echo '</div>';


                echo '</a>';

                echo '</div>';
                echo '</div>';
            }
            echo '<div class="totalCount">Showing 1 to ' . $results['count'] . ' of ' . $results['count'] . ' tickets</div>';
        } else {

            echo '<div class="norecordFound divNoRecordFound">
            <div class="flex-row">
            <span class="iconGraphicLeft"><span class="ticketIcon"><i class="fa fa-ticket" aria-hidden="true"></i>
            </span></span>
            <div class="descriptionNoRecordFdound">
            <h3>There are no tickets right now</h3>
            <a href="' . $new . '" class="buttonDefault smallRipple ripple-button blueBg " id="addNewTicketBtn">new ticket</a>
            </div>
            </div> 
            </div>';
        }
        echo '</div>';
    }
    echo  '</div>';
    if (isset($_REQUEST['action'])) {
        die;
    }
}


function sbr_customer_dashboard_reward_content()
{
    //require get_stylesheet_directory() . '/affiliatewp/dashboard.php';
    echo do_shortcode('[affiliate_area]');
}

add_action('woocommerce_account_support_endpoint', 'sbr_customer_dashboard_support_content');
add_action('woocommerce_account_reward_endpoint', 'sbr_customer_dashboard_reward_content');
add_action('wp_ajax_editCustomerSBR', 'sbr_edit_customer_dashboard');
add_action('wp_ajax_orderSBR', 'sbr_customer_order_dashboard');
function sbr_customer_order_dashboard($tab = 'all')
{
    $tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : $tab;
    ?>
    <div class="">
        <? if ($tab == 'alloldmobile') { ?>
            <div class="">
                <?php
                $numorders = wc_get_customer_order_count(get_current_user_id());

                ?>
                <div class="row viewOrderList align-items-center mb-4">
                    <div class="viewListingText col-5">
                        <p class="mb-0">Viewing all <strong><?php echo $numorders; ?></strong> order</p>
                    </div>

                    <div class="dropDownParnt col-7">
                        <div class="d-flex align-items-center">
                            <label class="shoeText mb-0">Show:</label>
                            <div class="selectBox ">
                                <select class="form-control">
                                    <option class="selected">All Orders</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cardSection" id="getCustomerMyAccountOrders">
                    <?php //getCustomerMyAccountOrders_callback();

                    getCustomerMyAccountOrders_callback();
                    ?>
                </div>

            </div>
        <?
     //subscription#RB
    } elseif ($tab == 'alldesktop' || $tab == 'all') { ?>


            <div class="cardSection" id="getCustomerMyAccountOrders">

            <div class="form-inline">
                    <form class="form-inline" action="" method="POST" id="orderFilterForm">
                        <label class="mr-sm-2" for="selectOrderType">Select Option:</label>
                        <select class="form-control mb-2 mr-sm-2" id="selectOrderType" name="selectOrderType">
                        <option value="all">All Orders</option>
                        <option value="subscription" <?php echo isset($_REQUEST['selectOrderType']) && $_REQUEST['selectOrderType'] == 'subscription' ? 'selected' : ''; ?>>Subscription Orders</option>
                        <option value="regular" <?php echo isset($_REQUEST['selectOrderType']) && $_REQUEST['selectOrderType'] == 'regular' ? 'selected' : ''; ?>>Regular Orders</option>
                        </select>                    
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>
                    <style>
                        /* Skeleton Loader Styles */
                        
.skeleton-loader .sbr-orderItem.flex-div.parent-{
    display: flex;
  justify-content: start;
  align-content: center;
  margin-bottom: 25px;
}
.skeleton-loader .sbr-orderItemLeft{
    width: 20%;
}


.skeleton-loader .skeleton-item {
    background-color: #e0e0e0;
    border-radius: 4px;
    height: 20px;
    width: 100%;
    animation: pulse 1.5s infinite;
}
.skeleton-loader .sbr-orderItemRight {
    width: 80%;
}

.skeleton-loader .skeleton-item.short {
    width: 80%;
    margin-bottom: 10px;
}

.skeleton-loader .skeleton-image {
    width: 170px;
    height: 130px;
    background-color: #e0e0e0;
    border-radius: 4px;
}

.skeleton-loader .skeleton-title {
    width: 80%;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 4px;
    margin-bottom: 10px;
}

.skeleton-loader .skeleton-price {
    width: 80%;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 4px;
    margin-bottom: 10px;

}

@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

@media (max-width: 767px){

    .skeleton-loader .sbr-orderItemLeft {
        width: 35%;
    }
    .skeleton-loader .skeleton-image {
        width: 94%;
    }
    .skeleton-loader .skeleton-item.short {
        width: 65%;
    }

}


                    </style>
                    <script>
                        jQuery(document).ready(function($) {
    function fetchOrders() {
        $('#customerOrdersContainer').html(`
            <div class="skeleton-loader">
                <div class="sbr-orderItem flex-div parent-">
                    <div class="sbr-orderItemLeft">
                        <div class="orderImage">
                            <div class="skeleton-image skeleton-item"></div>
                        </div>
                       
                    </div>
                    <div class="sbr-orderItemRight">
                         <div class="orderTitle">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-item short"></div>
                            <div class="skeleton-price "></div>
                            <div class="skeleton-price skeleton-item"></div>

                        </div>
                    </div>
                </div>
                 <div class="sbr-orderItem flex-div parent-">
                    <div class="sbr-orderItemLeft">
                        <div class="orderImage">
                            <div class="skeleton-image skeleton-item"></div>
                        </div>
                       
                    </div>
                    <div class="sbr-orderItemRight">
                         <div class="orderTitle">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-item short"></div>
                            <div class="skeleton-price"></div>
                            <div class="skeleton-price skeleton-item"></div>

                        </div>
                    </div>
                </div>
                 <div class="sbr-orderItem flex-div parent-">
                    <div class="sbr-orderItemLeft">
                        <div class="orderImage ">
                            <div class="skeleton-image skeleton-item"></div>
                        </div>
                       
                    </div>
                    <div class="sbr-orderItemRight">
                         <div class="orderTitle">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-item short"></div>
                            <div class="skeleton-price"></div>
                            <div class="skeleton-price skeleton-item"></div>

                        </div>
                    </div>
                </div>
            </div>
        `);

        var orderType = $('#selectOrderType').val();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'get_customer_my_account_orders_desktop',
                selectOrderType: orderType
            },
            success: function(response) {
               
               $('#customerOrdersContainer').html(response);
              
            },
            error: function() {
               
                $('#customerOrdersContainer').html('<p>Error fetching orders.</p>');
            }
        });
    }

    // Fetch orders on page load
    fetchOrders();

    // Fetch orders on form submission
    $('#orderFilterForm').on('submit', function(e) {
        e.preventDefault();
        fetchOrders();
    });
});
                    </script>
                </div>
                <div id="customerOrdersContainer"></div>
                <?php
               // getCustomerMyAccountOrders_callback_desktop();
                ?>
            </div>
        <? } elseif ($tab == 'buyagain') { ?>
            <div class="">
                <?php
                //  return false;
                global $wpdb;
                $products_Arr = array();
                $product_for_user = "SELECT DISTINCT(post_id) FROM wp_postmeta INNER JOIN wp_posts on wp_postmeta.post_id = wp_posts.ID  WHERE meta_key ='_customer_user' AND meta_value = " . get_current_user_id() . " AND wp_posts.post_status != 'trash'";
                $results1 = $wpdb->get_results($product_for_user, 'ARRAY_A');
                if (is_array($results1) && count($results1) > 0) {
                    foreach ($results1 as $key => $res) {

                        $products_Arr[] = $res['post_id'];
                    }
                }
                //print_r($products_Arr);
                $arr = implode(",", $products_Arr);

                $sql_query = "SELECT DISTINCT (meta_value) FROM wp_woocommerce_order_itemmeta INNER JOIN  wp_woocommerce_order_items
                            ON wp_woocommerce_order_itemmeta.order_item_id = wp_woocommerce_order_items.order_item_id
                            WHERE wp_woocommerce_order_itemmeta.meta_key = '_product_id' AND wp_woocommerce_order_items.order_id IN(" . $arr . ")";
                $results = $wpdb->get_results($sql_query, 'ARRAY_A');
                if (is_array($results)) {
                    $single_stage_items  = '';
                    $multi_stage_items  = '';
                    $single_stage_ids = '';
                    $multi_stage_ids = '';
                    $show_extraTrays = false;
                    $extra_tray_Set = '';
                    foreach ($results as $key => $val) {
                        $common_string = '';
                        $add_to_cart_String = '';
                        $product_id =  $val['meta_value'];
                        $_product = wc_get_product((int) $product_id);
                        $post_title = get_field('styled_title', $product_id);
                        $sale_price = get_post_meta($product_id, '_price', true) - get_post_meta($product_id, 'sale_page_discount_geha', true);
                        if ($post_title == '') {
                            $post_title = get_the_title($product_id);
                        }
                        $add_to_cart_String .= '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $product_id . '" data-quantity="1" data-product_id="' . $product_id . '"  data-action="woocommerce_add_order_item">ADD TO CART</button>';

                        $product = wc_get_product($product_id);

                        if ($_product->is_on_sale()) {

                            $common_string = '<div class="original-price">
                                                            <div class="price-heading gray-text">ORIGINAL PRICE</div>
                                                            <div class="price-was gray-text line-thorough"><span class="doller-sign">$</span>' . $_product->get_regular_price() . '</div>
                                                        </div>
        
                                                        <div class="sale-price">
                                                            <div class="price-heading blue-text">SALE PRICE</div>
                                                            <div class="price-new "><span class="doller-sign">$</span>' . $_product->get_sale_price() . '</div>
                                                        </div>';
                        } else {

                            $common_string = ' <div class="sale-price single-price">
                                                        <div class="price-heading blue-text">PRICE</div>
                                                        <div class="price-new "><span class="doller-sign">$</span>' . $_product->get_regular_price() . '</div>
                                                    </div>';
                        }

                        if ($product->is_type('composite')) {
                            if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes') {

                                $multi_stage_ids .=  $product_id . ',';

                                $ptitle = get_post_meta($product_id, "styled_title", true);
                                if ($ptitle == '') {
                                    $ptitle = get_the_title($product_id);
                                }
                                if (strpos($ptitle, 'NIGHT GUARD') !== false || strpos($ptitle, 'SENSITIVE') !== false) {
                                    $show_extraTrays = true;
                                }
                                $multi_stage_items .= '<div class="product-selection-box ddd">
                                    <div class="row-t">
                                        <div class="product-selection-title-text-wrap">
                                            <span class="product-selection-title-text-name">
                                            ' . $ptitle . '
                                            </span>
        
                                        </div>
                                        <div class="product-selection-title-right">
                                            <span class="availableItem">133 STILL AVAILABLE</span> <span class="saveOnItem">SAVE $' . get_post_meta($product_id, "sale_page_discount_geha", true) . '</span>
                                        </div>
                                    </div>
                                    <div class="row-t">
                                        <div class="col-sm-6 col-md-7">
                                            <div class="product-image">
                                                <img src="' . get_the_post_thumbnail_url($product_id, "large") . '" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-1 hidden"></div>
                                        <div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
                                            <div class="product-selection-description-text">
                                                ' . get_post_meta($product_id, "sale_page_info", true) . '
                                                <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">
        
                                                    ' . $common_string . '
        
                                                </div>
        
                                                <div class="add-to-cart">
                                                    ' . $add_to_cart_String . '
                                                </div>
        
                                            </div>
        
        
        
                                        </div>
        
                                    </div>
                                </div>';
                            } else {

                                $ptitle = get_post_meta($product_id, "styled_title", true);
                                if ($ptitle == '') {
                                    $ptitle = get_the_title($product_id);
                                }
                                if (strpos($ptitle, 'NIGHT GUARD') !== false || strpos($ptitle, 'SENSITIVE') !== false) {
                                    $show_extraTrays = true;
                                }
                                $single_stage_items .= '<div class="product-selection-box ddd">
                                    <div class="row-t">
                                        <div class="product-selection-title-text-wrap">
                                            <span class="product-selection-title-text-name">
                                            ' . $ptitle . '
                                            </span>
        
                                        </div>
                                        <div class="product-selection-title-right">
                                            <span class="availableItem">133 STILL AVAILABLE</span> <span class="saveOnItem">SAVE $' . get_post_meta($product_id, "sale_page_discount_geha", true) . '</span>
                                        </div>
                                    </div>
                                    <div class="row-t">
                                        <div class="col-sm-6 col-md-7">
                                            <div class="product-image">
                                                <img src="' . get_the_post_thumbnail_url($product_id, "large") . '" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-1 hidden"></div>
                                        <div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
                                            <div class="product-selection-description-text">
                                                ' . get_post_meta($product_id, "info_1", true) . '
                                                ' . get_post_meta($product_id, "info_2", true) . '
                                                <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">
        
                                                    ' . $common_string . '
        
                                                </div>
        
                                                <div class="add-to-cart">
                                                    ' . $add_to_cart_String . '
                                                </div>
        
                                            </div>
        
        
        
                                        </div>
        
                                    </div>
                                </div>';
                            }
                        }
                    }
                    if ($show_extraTrays) {
                        $tray_sets = array(428035, 734174);

                        foreach ($tray_sets as $product_id) {
                            $ptitle = get_post_meta($product_id, "styled_title", true);
                            if ($ptitle == '') {
                                $ptitle = get_the_title($product_id);
                            }
                            $ptitle = get_the_title($product_id);
                            $_product = wc_get_product((int) $product_id);
                            $add_to_cart_String = '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $product_id . '" data-quantity="1" data-product_id="' . $product_id . '"  data-action="woocommerce_add_order_item">ADD TO CART</button>';
                            $common_string = ' <div class="sale-price single-price">
                            <div class="price-heading blue-text">PRICE</div>
                            <div class="price-new "><span class="doller-sign">$</span>' . $_product->get_regular_price() . '</div>
                        </div>';
                            $extra_tray_Set .= '<div class="product-selection-box ddd">
                                        <div class="row-t">
                                            <div class="product-selection-title-text-wrap">
                                                <span class="product-selection-title-text-name">
                                                ' . $ptitle . '
                                                </span>
            
                                            </div>
                                            <div class="product-selection-title-right">
                                                <span class="availableItem">133 STILL AVAILABLE</span> <span class="saveOnItem">SAVE $' . get_post_meta($product_id, "sale_page_discount_geha", true) . '</span>
                                            </div>
                                        </div>
                                        <div class="row-t">
                                            <div class="col-sm-6 col-md-7">
                                                <div class="product-image">
                                                    <img src="' . get_the_post_thumbnail_url($product_id, "large") . '" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-1 hidden"></div>
                                            <div class="col-sm-6 col-md-5 product-selection-description-text-wrap">
                                                <div class="product-selection-description-text">
                                                    ' . get_post_meta($product_id, "info_1", true) . '
                                                    ' . get_post_meta($product_id, "info_2", true) . '
                                                    <div class="row-mbt-product justify-content-between maxwidth80" style="margin-top:60px;">
            
                                                        ' . $common_string . '
            
                                                    </div>
            
                                                    <div class="add-to-cart">
                                                        ' . $add_to_cart_String . '
                                                    </div>
            
                                                </div>
            
            
            
                                            </div>
            
                                        </div>
                                    </div>';
                        }
                    }
                }

                ?>
                <div class="tabsBuyAgain">
                    <div class="buyItemWrapper">
                        <?php if ($single_stage_items != '' && $multi_stage_items != '') {
                            echo '  <h2>Single Stage Items</h2>';
                        }
                        ?>
                        <div class="row lessSpacingLeftRight">
                            <?php echo  $single_stage_items;
                            ?>
                        </div>
                        <?php if ($single_stage_items != '' && $multi_stage_items != '') {
                            echo '<h2>Multi-Stage Items</h32>';
                        }
                        ?>
                        <!-- // <h2 class="mt-4">Multi-Stage Items</h2> -->
                        <div class="row lessSpacingLeftRight">
                            <?php echo  $multi_stage_items;
                            // echo do_shortcode('[night-guards product_ids="'.$multi_stage_ids.'"]');
                            ?>
                        </div>
                        <?php if ($show_extraTrays) {
                            echo '<h2>Extra Tray Sets</h2>';
                        }
                        ?>
                        <!-- // <h2 class="mt-4">Multi-Stage Items</h2> -->
                        <div class="row lessSpacingLeftRight">
                            <?php echo  $extra_tray_Set;
                            // echo do_shortcode('[night-guards product_ids="'.$multi_stage_ids.'"]');
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        <? } else {
            echo  'NO SUBSCRIPTION AVAILABLE.';
        } ?>
    </div>
    <?php
    if (isset($_REQUEST['action'])) {
        die;
    }
}
//add_action('myaccount_tabs', 'sbr_customer_dashboard_tabs');
function sbr_edit_customer_dashboard($tab = 'contact')
{
    $tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : $tab;
    $current_user = wp_get_current_user();
    ?>

    <div class="d-flex align-items-center menuParentRowHeading socialItemMange borderBottomLine hiddenDesktop hiddenChangePasswordPage">
        <div class="pageHeading_sec">
            <span><span class="text-blue">Profile</span>Manage and edit your name or email.</span>
        </div>
    </div>

    <?php
    if ($tab == 'contact') {
    ?>
        <div class="contactINformation">
            <div id="s1Alter"></div>
            <form id="customerBasicInformation">
                <?php
                if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'contact') {
                ?>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery('.customTabs #pills-home-tab').click();
                        });
                    </script>

                <?php
                }
                if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'social') {
                ?>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery('.customTabs #pills-profile-tab').click();
                        });
                    </script>

                <?php
                }
                if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'pass') {
                ?>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery('.customTabs #pills-password-tab').click();
                        });
                    </script>

                <?php
                }
                ?>
                <ul class="defaultStyle nthh" id="customerProfileInfo">
                    <?php echo customerProfileDisplay(); ?>
                </ul>

                <div class="button text-right">
                    <a href="javascript:;" aria-controls="pills-profile" aria-selected="true" class="buttonDefault smallRipple ripple-button blueBg " id="editCustomerInfo">Edit Info</a>
                </div>
                <div class="button text-right">
                    <a href="javascript:;" aria-controls="pills-profile" aria-selected="true" class="buttonDefault smallRipple ripple-button " id="editCustomerInfoCancel" style="display: none;">Cancel</a>
                </div>
            </form>
        </div>
    <? } else    if ($tab == 'social') { ?>
        <div class="item">
            <div id="s2Alter"></div>


            <form id="contactBasicInformation">
                <ul class="defaultStyle nthhh" id="soicalProfileDisplay">
                    <?php echo soicalProfileDisplay($current_user->ID); ?>
                </ul>
                <div class="button text-right">
                    <a href="javascript:;" aria-controls="pills-profile" aria-selected="true" class="buttonDefault smallRipple ripple-button blueBg " id="editSocialInfo">Edit Info</a>
                </div>
                <div class="button text-right">
                    <a href="javascript:;" aria-controls="pills-profile" aria-selected="true" class="buttonDefault smallRipple ripple-button" id="editSocialInfoCancel" style="display: none;">Cancel</a>
                </div>
            </form>
        </div>
    <? } else    if ($tab == 'oral') { ?>


        <div class="item">
            <div id="oralProfileDisplay">
                <?php echo oralProfileDisplay($current_user->ID); ?>
            </div>
            <script>
            </script>

        </div>
    <? } else    if ($tab == 'password') { ?>


        <style>
            @media screen and (max-width: 767px) {
                .hiddenChangePasswordPage {
                    display: none !important;
                }

                .showOnChangePasswordPage {
                    display: block !important;
                }

                .showOnChangePasswordPage .view-article-public-link {
                    justify-content: space-between;
                }

            }
        </style>
        <div class="item">


            <div id="s4Alter"></div>
            <form id="changePasswordScreen">
                <div class="form-group align-items-center">
                    <div class="minWidthSetLarge">
                        <label>
                            Current Password:
                        </label>
                    </div>
                    <div class="formInput">
                        <input type="password" class="form-control" name="oldPassword">
                    </div>
                </div>

                <div class="form-group align-items-center">
                    <div class="minWidthSetLarge">
                        <label>
                            New Password:
                        </label>
                    </div>
                    <div class="formInput">
                        <input type="password" class="form-control" name="newPass">
                    </div>
                </div>

                <div class="form-group align-items-center">
                    <div class="minWidthSetLarge">
                        <label>
                            Confirm Password:
                        </label>
                    </div>
                    <div class="formInput">
                        <input type="password" class="form-control" name="newConfirmPass">
                    </div>
                </div>

                <div class="button mt-4">
                    <a href="javascript:;" class="buttonDefault blueBg ripple-button  w-100" id="changeCustomerPassword" onclick="changeCustomerPassword()">
                        Save Password
                    </a>
                </div>
            </form>
        </div>
<? }
    if (isset($_REQUEST['action'])) {
        die;
    }
}


?>