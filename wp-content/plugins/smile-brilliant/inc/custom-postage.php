<?php

/**
 * dashboard screen Create request to easypost for shipment without any order details. 
 */
function generate_shipment_withoutOrder()
{

?>
    <script src='<?php echo site_url('wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js'); ?>' id='jquery-blockui-js'></script>
    <div class="popup-shipment withoutOrder">
        <form id="shipping_metabox_form">
            <div class="shipment-container">
                <div class="shipmemt-header flex-row justify-content-between">
                    <h3 id="create_shipment_heading" style="display: block">Create Postage</h3>
                </div>

                <div class="shipment-body">
                    <div class="shipiing-setup">
                        <h3>Shipment Details</h3>
                        <div class="inner-spacing">
                            <div class="flex-row">
                                <?php /*
                                <div class="col-sm-4">
                                    <label class="select" for="shipmentLabelMethod" autocomplete="off">Shipping Carrier</label>
                                    <?php $easypostcarrieraccount =  get_field('easypostcarrieraccount', 'option');
                                    if (is_array($easypostcarrieraccount) && count($easypostcarrieraccount) > 0) {
                                        echo '<select name="shipmentLabelMethod" id="shipmentLabelMethod" class="form-control">';
                                        //onchange="n__handleShippingMethod(this.value , \'US\' ,  \'First\' , 0);"
                                        foreach ($easypostcarrieraccount as  $carrier) {
                                            if ('USPS' === $carrier['label']) {
                                                echo '<option value="' . $carrier['label'] . '" selected="">' . $carrier['label'] . '</option>';
                                            } else {
                                                echo '<option value="' . $carrier['label'] . '">' . $carrier['label'] . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <label class="select" for="shipmentLabelService">Shipping Product </label>
                                    <select id="shipmentLabelService" name="shipmentLabelService" class="form-control">
                                        <option value="FirstClassPackageInternationalService">First Class International</option>
                                        <option value="PriorityMailInternational">Priority International</option>
                                        <option value="ExpressMailInternational">Express International</option>
                                    </select>

                                </div>
                                <?php */ ?>

                                <div class="col-sm-4">
                                    <label class="select" for="shipmentLabelSignatureConfirmationLabel">Signature Confirm? </label>
                                    <select id="shipmentLabelSignatureConfirmation" class="form-control">
                                        <option value="" selected="selected">Not Required</option>
                                        <option value="SIGNATURE">Required</option>
                                    </select>

                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Actual Ship Date</label>
                                        <input type="date" name="shipmentLabelShipDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="select" id="shiptoContentsType">
                                        Shipment Content
                                        <select id="shiptoContentsType" name="shiptoContentsType" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="merchandise" selected="">Merchandise</option>
                                            <option value="returned_goods">Returned Goods</option>
                                            <option value="gift">Gift</option>
                                            <option value="sample">Sample</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="col-sm-4">
                                    <label class="checkbox" id="shipmentLabelSaturdayDeliveryLabell">
                                        <input type="checkbox" id="shipmentLabelSaturdayDeliveryLabell" name="shipmentLabelSaturdayDelivery" value="1" />
                                        <span class="shipmentLabelSaturdayDeliveryLabell">Saturday Delivery</span>
                                    </label>
                                    <label for="print_label_shipment">
                                        <input name="print_label_shipment" id="print_label_shipment" type="checkbox" checked="" class="" value="yes" />
                                        <span class="print_label_shipment">Print Easypost Shipment Label</span>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Custom Label Message</label>
                                        <input type="text" name="customLabelMessage" class="form-control" max="100" value="" />
                                    </div>
                                </div>

                            </div>
                        </div>


                        <h3>Package Info</h3>
                        <div class="inner-spacing">
                            <div class="flex-row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Length</label>
                                        <input type="text" name="length" class="form-control" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Width</label>
                                        <input type="text" name="width" class="form-control" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Height</label>
                                        <input type="text" name="height" class="form-control" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Weight (oz)</label>
                                        <input type="text" name="pweight" class="form-control" value="" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3>Shipment Details</h3>
                        <div class="inner-spacing">
                            <div class="flex-row">
                            </div>
                            <table class="widefat" id="addon-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Declaration Price</th>
                                        <th>Quantity</th>
                                        <th>Weight (oz)</th>
                                        <th>Traiff Code</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" autocomplete="off" name="product[]" autocomplete="off" /></td>
                                        <td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0.00" value="0.00" size="4" class="price_addon"></td>
                                        <td><input type="number" step="1" min="1" max="100" autocomplete="off" name="item_qty[]" placeholder="1" size="4" value="1" class="quantity_addon"></td>
                                        <td><input type="number" step="0.1" min="0.1" max="100" autocomplete="off" name="weight[]" placeholder="1" size="4" value="0.1"></td>
                                        <td><input type="text" autocomplete="off" name="shiptoTariffCode[]" value="850.98.000" /></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="add-order-btn">
                                <button id="addProductShipment" class="button" type="button">Add Product</button>
                            </div>
                        </div>
                    </div>


                    <script>
                        jQuery('body').on('click', '#createPostageWithoutOrder', function() {


                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Please make sure before create postage label.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Create postage'
                            }).then((result) => {
                                if (result.isConfirmed) {


                                    jQuery('#shipping_metabox_form').block({
                                        message: null,
                                        overlayCSS: {
                                            background: '#fff',
                                            opacity: 0.6
                                        }
                                    });

                                    var elementT = document.getElementById("shipping_metabox_form");
                                    var formdata = new FormData(elementT);
                                    jQuery.ajax({
                                        url: ajaxurl,
                                        data: formdata,
                                        async: true,
                                        method: 'POST',
                                        dataType: 'JSON',
                                        success: function(response) {
                                            jQuery('#shipping_metabox_form').unblock();
                                            if (response.code == 'success') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    text: response.msg
                                                });
                                                jQuery('body').find('#shipment_response').html('');
                                                document.getElementById("shipping_metabox_form").reset();
                                            } else if (response.code == 'rates') {
                                                $error_msg = '  <div class="shipment-body shipiing-setup">';
                                                $error_msg += '<h3>Shipment Rates</h3>';
                                                $error_msg += '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                                                $error_msg += response.msg;
                                                $error_msg += '</div>';
                                                jQuery('body').find('#shipment_response').html($error_msg);
                                            } else {
                                                $error_msg = '<div class="alert">';
                                                $error_msg += '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                                                $error_msg += response.msg;
                                                $error_msg += '</div>';
                                                jQuery('body').find('#shipment_response').html($error_msg);
                                            }
                                        },
                                        cache: false,
                                        contentType: false,
                                        processData: false
                                    });
                                }

                            })

                        });
                        jQuery("body").find("#shipping_metabox_form").on("click", "#addProductShipment", function(e) {

                            // jQuery(add_button).click(function (e) { //on add input button click
                            //    jQuery(add_button).click(function (e) { //on add input button click
                            e.preventDefault();
                            let productAId = sbr_uniqId();

                            var html = '';
                            html += '<tr>';


                            html += '<td><input type="text" autocomplete="off" name="product[]"  autocomplete="off" /></td>';
                            html += '<td><span class="currencySign">$</span><input type="number" step="1" min="0" max="9999" autocomplete="off" name="price[]" placeholder="0.00" value="0.00" size="4" class="price_addon"></td>';
                            html += '<td><input type="number" step="1" min="1" max="100" autocomplete="off" name="item_qty[]" placeholder="1" size="4" value="1" class="quantity_addon"></td>';
                            html += '<td><input type="number" step="0.1" min="0.1" max="100" autocomplete="off" name="weight[]" placeholder="1" size="4" value="0.1"></td>';
                            html += '<td><input type="text" autocomplete="off" value="850.98.000" name="shiptoTariffCode[]" /></td>';
                            html += '<td><a href="javascript:;" class="remove_field"><span style=" background: #2372b1;" class="dashicons dashicons-no-alt"></span></a></td>';
                            html += '</tr>';
                            jQuery("body").find("#addon-table tbody").append(html); //add input box
                        });

                        jQuery("body").find('#shipping_metabox_form').on("click", ".remove_field", function(e) { //user click on remove text
                            e.preventDefault();
                            jQuery(this).closest('tr').remove();

                        });
                    </script>
                    <style>
                        .chzn-drop {
                            height: 0px !important;
                        }
                    </style>

                    <div class="shipiing-setup custom-shipping-address" style="display: flex;">
                        <div class="cmt-thed">
                            <h3>From Address</h3>
                            <div class="ready-toship shipping-address-container-mbt">
                                <div class="flex-row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="cname" class="form-control" value="Smile Brilliant Inc" autocomplete="off" />
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" name="cemail" class="form-control" value="support@smilebrilliant.com" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Phone </label>
                                            <input type="text" name="cphone" class="form-control" value="855-944-8361" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 1</label>
                                            <textarea class="form-control" name="caddress_1" autocomplete="off">1645 Headland Dr</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 2 </label>
                                            <textarea class="form-control" name="caddress_2" autocomplete="off"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="ccity" class="form-control" value="Fenton" autocomplete="off" />
                                        </div>
                                    </div>




                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" name="czipcode" class="form-control" value="63026" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="cstate" class="form-control" value="MO" autocomplete="off" />
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                        <div class="cmt-thed">
                            <h3>Shipping Address</h3>
                            <div class="ready-toship shipping-address-container-mbt">
                                <div class="flex-row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Name </label>
                                            <input type="text" name="name" class="form-control" value="" autocomplete="off" />
                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" name="email" class="form-control" value="" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Phone </label>
                                            <input type="number" name="phone" class="form-control" value="" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 1</label>
                                            <textarea class="form-control" name="address_1" autocomplete="off"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Address Line 2 </label>
                                            <textarea class="form-control" name="address_2" autocomplete="off"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="" autocomplete="off" />
                                        </div>
                                    </div>




                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" name="zipcode" class="form-control" value="" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group select-country-mbt">

                                            <?php
                                            $countries_obj = new WC_Countries();
                                            $countries = $countries_obj->__get('countries');
                                            $shipping_county = 'US';
                                            woocommerce_form_field(
                                                'shipment_country',
                                                array(
                                                    'type' => 'select',
                                                    'required' => true,
                                                    'class' => array(''),
                                                    'label' => __('Select a country'),
                                                    'placeholder' => __('Enter something'),
                                                    'options' => $countries
                                                ),
                                                $shipping_county
                                            );
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">

                                        <div class="form-group" id="shipmentStateHtml">
                                            <?php
                                            get_stateByCountry_SBR('shipment_state', $shipping_county, 'MO');
                                            ?>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="shipment_response">
                    </div>
                    <div class="buttons-footer">
                        <input type="hidden" name="action" value="mbt_createShipmentWithOutOrder" />
                        <button type="button" class="button" style="width: 50%;padding: 10px;margin: 0 auto;display: block;background-color: #164dff;color: #fff;font-size: 15px;" id="createPostageWithoutOrder">Create Postage</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
    die;
}

/**
 * Function to check if a value is empty or contains only spaces.
 */

function isNotEmpty($value)
{
    return isset($value) && is_string($value) && trim($value) !== '';
}

add_action('wp_ajax_mbt_createShipmentWithOutOrder', 'mbt_createShipmentWithOutOrder_callback');
/**
 * Function to create easypost request for postage label generate without order 
 */
function mbt_createShipmentWithOutOrder_callback()
{
    $response = array();
    //ASSEMBLE OUR INSERT ARRAY
    $insertArray = array();
    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(SB_EASYPOST_API_KEY);
    global $MbtPackaging, $wpdb;


    // Initialize an array to store error messages, if any.
    $error_log = array();

    // Validate the fields for the recipient.
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
    $address1 = isset($_REQUEST['address_1']) ? $_REQUEST['address_1'] : '';
    $address2 = isset($_REQUEST['address_2']) ? $_REQUEST['address_2'] : '';
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
    $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
    $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : '';
    $state = isset($_REQUEST['shipment_state']) ? $_REQUEST['shipment_state'] : '';
    $country = isset($_REQUEST['shipment_country']) ? $_REQUEST['shipment_country'] : '';
    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';

    // Validate the fields for the sender.
    $cname = isset($_REQUEST['cname']) ? $_REQUEST['cname'] : '';
    $caddress1 = isset($_REQUEST['caddress_1']) ? $_REQUEST['caddress_1'] : '';
    $caddress2 = isset($_REQUEST['caddress_2']) ? $_REQUEST['caddress_2'] : '';
    $cemail = isset($_REQUEST['cemail']) ? $_REQUEST['cemail'] : '';
    $ccity = isset($_REQUEST['ccity']) ? $_REQUEST['ccity'] : '';
    $czipcode = isset($_REQUEST['czipcode']) ? $_REQUEST['czipcode'] : '';
    $cstate = isset($_REQUEST['cstate']) ? $_REQUEST['cstate'] : '';
    $ccountry = 'US';
    $cphone = isset($_REQUEST['cphone']) ? $_REQUEST['cphone'] : '';

    // Validate other fields as needed (length, width, height, weight, etc.).
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $width = isset($_REQUEST['width']) ? $_REQUEST['width'] : '';
    $height = isset($_REQUEST['height']) ? $_REQUEST['height'] : '';
    $parcelProductsWeight = isset($_REQUEST['pweight']) ? $_REQUEST['pweight'] : '';

    // Check the shipping carrier and service.
    $shipmentLabelMethod = isset($_POST['shipmentLabelMethod']) ? $_POST['shipmentLabelMethod'] : '';
    $shipmentLabelService = isset($_POST['shipmentLabelService']) ? $_POST['shipmentLabelService'] : '';

    // Perform form validation
    if (!isNotEmpty($name)) {
        $error_log[] = "Recipient name is required.";
    }
    if (!isNotEmpty($address1)) {
        $error_log[] = "Recipient address line 1 is required.";
    }
    if (!isNotEmpty($email)) {
        $error_log[] = "Recipient email is required.";
    }
    if (!isNotEmpty($city)) {
        $error_log[] = "Recipient city is required.";
    }
    if (!isNotEmpty($zipcode)) {
        $error_log[] = "Recipient zipcode is required.";
    }
    if (!isNotEmpty($state)) {
        $error_log[] = "Recipient state is required.";
    }
    if (!isNotEmpty($country)) {
        $error_log[] = "Recipient country is required.";
    }
    if (!isNotEmpty($phone)) {
        $error_log[] = "Recipient phone is required.";
    }

    // Validate the fields for the sender.
    if (!isNotEmpty($cname)) {
        $error_log[] = "Sender name is required.";
    }
    if (!isNotEmpty($caddress1)) {
        $error_log[] = "Sender address line 1 is required.";
    }
    if (!isNotEmpty($cemail)) {
        $error_log[] = "Sender email is required.";
    }
    if (!isNotEmpty($ccity)) {
        $error_log[] = "Sender city is required.";
    }
    if (!isNotEmpty($czipcode)) {
        $error_log[] = "Sender zipcode is required.";
    }
    if (!isNotEmpty($cstate)) {
        $error_log[] = "Sender state is required.";
    }
    if (!isNotEmpty($cphone)) {
        $error_log[] = "Sender phone is required.";
    }

    // Validate other fields as needed (length, width, height, weight, etc.).
    if (!isNotEmpty($length)) {
        $error_log[] = "Package length is required.";
    }
    if (!isNotEmpty($width)) {
        $error_log[] = "Package width is required.";
    }
    if (!isNotEmpty($height)) {
        $error_log[] = "Package height is required.";
    }
    if (!isNotEmpty($parcelProductsWeight)) {
        $error_log[] = "Package weight is required.";
    }

    // Check the shipping carrier and service.
    if (!isNotEmpty($shipmentLabelMethod)) {
        //  $error_log[] = "The shipping carrier is missing.";
    }
    if (!isNotEmpty($shipmentLabelService)) {
        //  $error_log[] = "The shipping service is missing.";
    }


    if (!isNotEmpty($_REQUEST['shipmentLabelShipDate'])) {
        $error_log[] = "The shipping label date is required.";
    }


    //if international we require the contents
    if ($country != "US") {
        if ($_REQUEST['shiptoContentsType'] == "") {
            $error_log[] = "The shipment content type is missing (required for international shipments).";
        }
        if ($_REQUEST['shiptoTariffCode'] == "") {
            /// if (@trim($_REQUEST['shiptoTariffCode']) == "") {
            // $error_log[] = "The shipment content tariff code is missing (required for international shipments).";
        }
    }


    if (count($error_log) > 0) {
        $htmlError = '<ul class="error-list lll">';
        foreach ($error_log as $error_item) {
            $htmlError .= '<li>' . $error_item . '</li>';
        }
        $htmlError .= '</ul>';
        $response = array(
            'code' => 'error',
            'msg' => $htmlError
        );
        echo json_encode($response);
        die;
    }


    $insertArray['userId'] = get_current_user_id();
    // $insertArray['shipmentMethod'] = @$_POST['shipmentLabelMethod'];
    $insertArray['shipmentNotes'] = @$_POST['customLabelMessage'];
    $insertArray['shipmentDate'] = date("Y-m-d H:i:s");
    $insertArray['batchIdShipment'] = 0;

    $insertArray['packageId'] = 0; //@$_POST['shipment_package_id'];
    //$insertArray['shiptoCompany'] = @trim($_POST['shiptoCompany']);
    $insertArray['shiptoFirstName'] = $name;
    $insertArray['shiptoLastName'] = ''; //$lname;
    $insertArray['shiptoAddress'] = $address1 . ' ' . $address2;
    $insertArray['shiptoCountry'] = $country;
    $insertArray['shiptoCity'] = $city;
    $insertArray['shiptoState'] = $state;
    $insertArray['shiptoPostalCode'] = $zipcode;
    $insertArray['shiptoPhone'] = $phone;
    $insertArray['shiptoEmail'] = $email;
    if (@trim($_POST['shiptoContentsType'])) {
        $insertArray['shiptoContentsType'] = @trim($_POST['shiptoContentsType']);
    } else {
        $insertArray['shiptoContentsType'] = 'merchandise';
    }
    $insertArray['shiptoTariffCode'] = '850.98.000';
    //$insertArray['shiptoTariffCode'] = @trim($_POST['shiptoTariffCode']);
    /*   $insertArray['shiptoContentsDescription'] = @trim($_POST['shiptoContentsDescription']);
      $insertArray['shiptoContentsManufacturer'] = @trim($_POST['shiptoContentsManufacturer']);
     */
    $insertArray['easyPostLabelDate'] = date("Y-m-d", strtotime(@trim($_POST['shipmentLabelShipDate'] . " 12:00:00")));

    //saturday delivery handling
    if (@trim($_POST['shipmentLabelSaturdayDelivery']) == "1") {
        //pass bool
        $insertArray['easyPostLabelSaturdayDelivery'] = true;
    } else {
        $insertArray['easyPostLabelSaturdayDelivery'] = false;
    }


    //parse the date
    $labelDate = date("Y-m-d", strtotime(@trim($_POST['shipmentLabelShipDate']) . " 12:00:00")) . "T12:00:00-07";

    //IF THIS IS AN INTERNATIONAL SHIPMENT, WE HAVE TO CREATE OUR CUSTOMS THINGS

    $customs_items = array();
    $customs_info = false;
    $curItemsArray = array();

    $readyToShipOrderItem = $_REQUEST['product'];
    $shipmentCounter = 1;
    $allShipProductsWeight = 0;
    $allOrderIds = array();
    $productData = array();

    if (is_array($readyToShipOrderItem) && count($readyToShipOrderItem) > 0) {
        foreach ($readyToShipOrderItem as $keyP => $productName) {
            $productData[] = array(
                'title' => $productName,
                'qty' => $_REQUEST['item_qty'][$keyP],
                'price' =>  $_REQUEST['price'][$keyP],
                'weight' =>  $_REQUEST['weight'][$keyP],
                'tariff' =>  $_REQUEST['shiptoTariffCode'][$keyP],
            );
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => 'No product found for shipment'
        );
        echo json_encode($response);
        die;
    }

    if (count($productData) < 1) {
        $response = array(
            'code' => 'error',
            'msg' => 'No product qty found to shipment'
        );
        echo json_encode($response);
        die;
    }

    //NOW CREATE OUR SHIPMENT
    /*     * for Test Case */
    $shipmentOptions = array(
        'label_date' => $labelDate,
        'currency' => 'USD',
        //  'delivery_confirmation' => @trim($_POST['shipmentLabelSignatureConfirmation']),
        'saturday_delivery' => $insertArray['easyPostLabelSaturdayDelivery'],
    );

    if (@trim($_POST['customLabelMessage'])) {
        $shipmentOptions['print_custom_1'] = @trim($_POST['customLabelMessage']);
    }


    if (isset($_POST['shipmentLabelSignatureConfirmation']) && $_POST['shipmentLabelSignatureConfirmation'] <> '') {
        $shipmentOptions['delivery_confirmation'] = 'SIGNATURE';
    }
    $allShipProductsValue = 0;
    try {
        foreach ($productData as  $productContent) {

            $curItemArray = array(
                "description" => strip_tags($productContent['title']),
                "quantity" => $productContent['qty'],
                "weight" => @round(@trim($productContent['weight']) * $productContent['qty'], 2),
                "value" => @round(@trim($productContent['price']) * $productContent['qty'], 2),
                "currency" => "USD",
                "origin_country" => 'US',
                "hs_tariff_number" => $productContent['shiptoTariffCode']
            );

            $allShipProductsWeight = $allShipProductsWeight + (float)@trim($curItemArray['weight']);
            $allShipProductsValue = $allShipProductsValue + (float)@trim($curItemArray['price']);


            array_push($curItemsArray, $client->customsItem->create($curItemArray));
        }
        $insertArray['shiptoContentsValue'] = @trim($allShipProductsValue);
    } catch (Exception $e) {

        $response = array(
            'code' => 'error',
            'msg' => "An error was returned from our Custom Item service, please show this to the administrator: " . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
        );
        echo json_encode($response);
        die;
    }
    try {

        $customs_info =  $client->customsInfo->create(array(
            "eel_pfc" => 'NOEEI 30.37(a)',
            "customs_certify" => true,
            "customs_signer" => 'Salman Shah',
            "contents_type" => $insertArray['shiptoContentsType'],
            "contents_explanation" => '',
            "restriction_type" => 'none',
            "non_delivery_option" => 'return',
            "customs_items" => $curItemsArray
        ));
    } catch (Exception $e) {

        $response = array(
            'code' => 'error',
            'msg' => "An error was returned from our Custom Info service, please show this to the administrator: " . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
        );
        echo json_encode($response);
        die;
    }
    $orderSBRref = 'Custom Label';
    $insertArray['packageLength'] = @trim($length);
    $insertArray['packageWidth'] = @trim($width);
    $insertArray['packageHeight'] = @trim($height);
    $insertArray['packageWeight'] = @trim(($parcelProductsWeight + $allShipProductsWeight));
    $insertArray['reference'] = $orderSBRref;

    if ((isset($_REQUEST['easypostShipmentID']) && !empty($_REQUEST['easypostShipmentID']))  && (isset($_REQUEST['rates']) && !empty($_REQUEST['rates']))) {
        $shipment =  $client->shipment->retrieve($_REQUEST['easypostShipmentID']);
    } else {
        try {
            $shipmentData = array(
                'options' => $shipmentOptions,
                'is_return' => false,
                //'carrier_accounts' => $carrier_accounts,
                "reference" => $orderSBRref,
                "to_address" => array(
                    'name' => $name,
                    'street1' => $address1,
                    'street2' => $address2,
                    'city' => $city,
                    'state' => $state,
                    'zip' => $zipcode,
                    'country' => $country,
                    'phone' => $phone,
                    'email' => $email
                ),
                "from_address" => array(
                    'name' => $cname,
                    'street1' => $caddress1,
                    'street2' => $caddress2,
                    'city' => $ccity,
                    'state' => $cstate,
                    'zip' => $czipcode,
                    'country' => $ccountry,
                    'phone' => $cphone,
                    'email' => $cemail
                ),
                "parcel" => array(
                    "length" => $length,
                    "width" => $width,
                    "height" => $height,
                    "weight" => ($parcelProductsWeight + $allShipProductsWeight)
                ),
                "customs_info" => $customs_info
                //'service' => $_REQUEST['shipmentLabelService'],
            );

            $shipment = $client->shipment->create($shipmentData);
            if (@count($shipment->rates) > 0) {

                $htmlError = '<ul class="easypost_rate-list">';
                $htmlError .= ' <input type="hidden"  name="easypostShipmentID" value="' . $shipment->id . '" />';
                //   echo 'Data: <pre>' .print_r($shipment->rates ,true). '</pre>';
                foreach ($shipment->rates as $key => $rates) {
                    //match our rate to the service       
                    $htmlError .= '<li><label class="checkbox" id="' . $rates['id'] . '">
                   <input type="radio" id="' . $rates['id'] . '" name="rates" value="' . $rates['id'] . '" />
                   <span class="' . $rates['id'] . '">' . $rates['carrier'] . ' - ' . $rates['service'] . '- ' .  $rates['rate'] . ' USD</span>
               </label>' . $error_item . '</li>';
                }
                for ($i = 0; $i < count($shipment->rates); $i++) {
                }
                $htmlError .= '</ul>';
            }
            $response = array(
                'code' => 'rates',
                'msg' => $htmlError
            );
            echo json_encode($response);
            die;
            // $shipment_id = $shipment->id;
        } catch (Exception $e) {

            $response = array(
                'code' => 'error',
                'msg' => "An error was returned from our label generation service, please show this to the administrator:<br/><br/>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())),
            );
            echo json_encode($response);
            die;
        }
    }


    //if we have a successful shipment
    if (@$shipment->id != "") {
        //by default, grab the lowest rate of the selected class
        $selectedRate = false;
        try {
            //$selectedRate = $shipment->lowest_rate($insertArray['shipmentMethod']);
            $selectedRate = false;
        } catch (Exception $e) {
            $response = array(
                'code' => 'error',
                'msg' => "It appears that the label generation service did not find any rates.  This normally occurs due to an address error - please check to make sure the address for this customer is correct and try again.  Below is the error message from our label generation service:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>",
            );
            echo json_encode($response);
            die;
        }
        //loop through the rates to select our rate
        if (@count($shipment->rates) > 0) {

            foreach ($shipment->rates as $key => $rates) {
                //for ($i = 0; $i < count($shipment->rates); $i++) {
                //match our rate to the service
                if ($rates->id == @trim($_REQUEST['rates'])) {
                    $selectedRate = $rates;
                    break;
                }
            }
        }

        //buy the shipment
        try {
            // $shipment->buy(array(
            //     'rate' => $selectedRate
            //     //'insurance'	=>  0.00
            // ));
            $boughtShipment =$client->shipment->buy($shipment->id, $shipment->lowestRate());
        } catch (Exception $e) {
            $response = array(
                'code' => 'error',
                'msg' => "An error was returned from our label generation service, please show this to the administrator:<br/><br/><strong>" . preg_replace("/\r\n|\r|\n/", '<br/>', htmlspecialchars($e->getMessage())) . "</strong>",
            );
            echo json_encode($response);
            die();
        }


        //set our insert values
        //$shipment->label(array("file_format" => "pdf"));
        $shipmentWithLabel =$client->shipment->label( $shipment->id,array("file_format" => "pdf"));
        //echo 'Data: <pre>' .print_r($shipment,true). '</pre>';
        $insertArray['trackingCode'] = @$shipmentWithLabel->tracking_code;
        $tracking_number = $insertArray['trackingCode'];
        $insertArray['shipmentCost'] = @number_format($shipmentWithLabel->selected_rate->rate, 2, '.', '');
        $insertArray['easyPostShipmentId'] = @$shipment->id;
        $insertArray['easyPostShipmentTrackingUrl'] = @$shipmentWithLabel->tracker->public_url;
        $insertArray['easyPostLabelSize'] = @$shipmentWithLabel->postage_label->label_size;

        $insertArray['easyPostLabelPNG'] = @$shipmentWithLabel->postage_label->label_url;
        $insertArray['easyPostLabelPDF'] = @$shipmentWithLabel->postage_label->label_pdf_url;

        $insertArray['easyPostLabelRateId'] = @$shipmentWithLabel->selected_rate->id;
        $insertArray['easyPostLabelCarrier'] = @$shipmentWithLabel->selected_rate->carrier;
        $insertArray['easyPostLabelService'] = @$shipmentWithLabel->selected_rate->service;

        $insertArray['shipmentStatus'] = @$shipmentWithLabel->tracker->status;
        $insertArray['estDeliveryDate'] = @$shipmentWithLabel->tracker->est_delivery_date;
        $_POST['easypost_tracking_number'] = $tracking_number;
        $_POST['easypost_tracking_url'] = $insertArray['easyPostShipmentTrackingUrl'];
        $_POST['custom_lable'] = 'yes';

        //download teh PNG version of the label
        $randomFileName = $tracking_number . ".png";
        $downloadResult = @file_get_contents(@$shipmentWithLabel->postage_label->label_url);
        $downloadSuccess = false;
        if ($downloadResult) {

            if (isset($_REQUEST['tracking_email']) && $_REQUEST['tracking_email'] == 'yes') {
                $insertArray['trackingEmail'] = 1;
                WC()->mailer()->emails['WC_Shipment_Order_Email']->trigger($email);
            } else {
                $insertArray['trackingEmail'] = 0;
            }


            $MbtPackaging->manage_package_inventory($shipment_package_id);
            $logs_dir = get_home_path() . 'downloads/labels/';
            if (!is_dir($logs_dir)) {
                mkdir($logs_dir, 0755, true);
            }            //put the contents
            $filePutResult = @file_put_contents($logs_dir . $randomFileName, $downloadResult);
            if ($filePutResult) {
                //successful drop of the file
                $downloadSuccess = true;
                $file_path = $logs_dir . $randomFileName;
                if (isset($_REQUEST['print_label_shipment']) && $_REQUEST['print_label_shipment'] == 'yes') {
                    //     mbt_printer_receipt($file_path, );
                    mbt_printer_receipt($file_path, $insertArray['easyPostLabelSize']);
                    $insertArray['shipmentLabelPrint'] = 1;
                } else {
                    $insertArray['shipmentLabelPrint'] = 0;
                }
            }
        } else {
            $response = array(
                'code' => 'error',
                'msg' => "We were unsucessful in generating the return label for print.  Please try again or contact the administrator.",
            );
            echo json_encode($response);
            die();
        }
        $insertArray['productsWithQty'] = json_encode($productData);
        require_once("dompdf/autoload.php");
        if (isset($_REQUEST['package_label_shipment']) && $_REQUEST['package_label_shipment'] == 'yes') {
            $insertArray['packageLabelPrint'] = 1;
        } else {
            $insertArray['packageLabelPrint'] = 0;
        }
        $shipment_db_id = sb_easypost_shipment($insertArray);
        if ($shipment_db_id) {

            $response = array(
                'code' => 'success',
                'status' => $shipStatus,
                'source' => isset($_REQUEST['source']) ? $_REQUEST['source'] : 'order',
                'msg' => 'Shipment created successfully. Tracking ID# ' . $tracking_number
            );
            echo json_encode($response);
            die();
        } else {
            $response = array(
                'code' => 'error',
                'msg' => "An error occured while trying to insert the shipment.",
            );
            echo json_encode($response);
            die();
        }
    } else {
        $response = array(
            'code' => 'error',
            'msg' => "We were unsucessful in generating the return label.  Please try again or contact the administrator.",
        );
        echo json_encode($response);
        die();
    }


    //echo 'Data: <pre>' .print_r($insertArray,true). '</pre>';die;
    die;
}
