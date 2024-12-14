<?php
/**
 * Populates the choices for the ACF field 'upscarriercountries' with a list of countries.
 *
 * @param array $field The ACF field settings.
 *
 * @return array The modified ACF field settings with country choices.
 */
function upscarriercountries_list($field)
{
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $field['choices'] = array();

    foreach ($countries as $countryCode => $countryTitle) {
        $field['choices'][$countryCode] = $countryTitle;
    }

    return $field;
}
/**
 * Populates the choices for the ACF field 'easypostcarrieraccount' with EasyPost carrier accounts.
 *
 * @param array $field The ACF field settings.
 *
 * @return array The modified ACF field settings with EasyPost carrier account choices.
 */
function easypostCarrierAccount_list($field)
{
    require_once(ABSPATH . 'vendor/autoload.php');
    $client = new \EasyPost\EasyPostClient(get_field('easypost_live_api_key', 'option'));
    $carrierAccount = $client->carrierAccount->all();
    $field['choices'] = array();
    if ($carrierAccount) {
        foreach ($carrierAccount as  $account) {
            $field['choices'][$account->id] = $account->readable;
        }
    }
    // return the field
    return $field;
}
//add_filter('acf/load_field/name=upscarriercountries', 'upscarriercountries_list');
add_filter('acf/load_field/name=easypostcarrieraccount', 'easypostCarrierAccount_list');

/**
 * Retrieves the EasyPost carrier account ID for the selected carrier label.
 *
 * @param string $selected_carrier The selected carrier label.
 *
 * @return int The EasyPost carrier account ID.
 */
function get_easypostCarrierAccounts($selected_carrier)
{
    $carrier_account_id = 0;
    $easypostcarrieraccount =  get_field('easypostcarrieraccount', 'option');
    foreach ($easypostcarrieraccount as  $carrier) {
        if ($selected_carrier == $carrier['label']) {
            $carrier_account_id =  $carrier['value'];
            break;
        }
    }
    return $carrier_account_id;
}

/**
 * Retrieves predefined carrier service options based on the given case (e.g., 'uspsD', 'uspsI', 'upsD', 'upsI').
 *
 * @param string $case The case specifying the carrier service options.
 *
 * @return array The predefined carrier service options.
 */
function getCarrierPredefinedService($case)
{
    $options = array();
    if ($case == 'uspsD') {
        $options['First'] = 'First Class';
        $options['Priority'] = 'Priority';
        $options['Express'] = 'Express';
    }
    if ($case == 'uspsI') {
        $options['FirstClassPackageInternationalService'] = 'First Class International';
        $options['PriorityMailInternational'] = 'Priority International';
        $options['ExpressMailInternational'] = 'Express International';
    }
    if ($case == 'upsD') {
        $options['NextDayAirSaver'] = 'Next DayAir Saver';
        $options['NextDayAir'] = 'Next Day Air';
        $options['3DaySelect'] = '3 Day Select';
        $options['2ndDayAirAM'] = '2nd Day Air AM';
        $options['Ground'] = 'Ground';
        $options['NextDayAirEarlyAM'] = 'Next Day Air Early AM';
        $options['2ndDayAir'] = '2nd Day Air';
    }
    if ($case == 'upsI') {
        $options['UPSSaver'] = 'Economy (3 - 6 Weeks)';
        $options['Express'] = 'UPS Express (2 - 3 Day)';
        $options['Expedited'] = 'UPS Expedited (3 - 5 Day)';
    }

    return $options;
}

add_action('wp_ajax_get_carrierServiceMethod', 'get_carrierServiceMethod_callback');
/**
 * AJAX callback to retrieve carrier service methods based on the selected carrier, country, and shipment method.
 *
 * @return void Outputs the HTML options for the carrier service methods.
 */
function get_carrierServiceMethod_callback()
{
    $optionHtml = '';
    $method = $_REQUEST['method'];
    $screen = isset($_REQUEST['all']) ? $_REQUEST['all'] : 0;
    $country = $_REQUEST['country'];
    $shipmentMethod = $_REQUEST['shipmentMethod'];
    $options = array();
    if ($method === 'UPS') {
        if ($country == 'US') {
            $options = getCarrierPredefinedService('upsD');
        } else {
            $options = getCarrierPredefinedService('upsI');
        }
    } else {
        if ($country == 'US') {
            $options = getCarrierPredefinedService('uspsD');
        } else {
            $options = getCarrierPredefinedService('uspsI');
        }
    }
    if ($screen) {
        if ($method === 'UPS') {
            $options =  array_merge_recursive(getCarrierPredefinedService('upsD'), getCarrierPredefinedService('upsI'));
        } else if ($method === 'USPS') {
            $options =  array_merge_recursive(getCarrierPredefinedService('uspsD'), getCarrierPredefinedService('uspsI'));
        } else {
            $options =  array();
        }
    }
    // echo '<pre>';
    // print_r($_REQUEST);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($options);
    // echo '</pre>';
    /*
    if ($method === 'UPS') {
        if ($country == 'US') {
            $options['NextDayAirSaver'] = 'Next DayAir Saver';
            $options['NextDayAir'] = 'Next Day Air';
            $options['3DaySelect'] = '3 Day Select';
            $options['2ndDayAirAM'] = '2nd Day Air AM';
            $options['Ground'] = 'Ground';
            $options['NextDayAirEarlyAM'] = 'Next Day Air Early AM';
            $options['2ndDayAir'] = '2nd Day Air';
        } else {
            $options['UPSSaver'] = 'Economy (3 - 6 Weeks)';
            $options['Express'] = 'UPS Express (2 - 3 Day)';
            $options['Expedited'] = 'UPS Expedited (3 - 5 Day)';
        }
    } else {
        if ($country == 'US') {
            $options['First'] = 'First Class';
            $options['Priority'] = 'Priority';
            $options['Express'] = 'Express';
        } else {
            $options['FirstClassPackageInternationalService'] = 'First Class International';
            $options['PriorityMailInternational'] = 'Priority International';
            $options['ExpressMailInternational'] = 'Express International';
        }
    }
    */
    if ($screen) {
        $optionHtml .=  '<option value="" selected="selected">All</option>';
    }
    if (count($options) > 0) {

        foreach ($options as $service => $serviceTitle) {
            if ($shipmentMethod === $service) {
                $optionHtml .= '<option value="' . $service . '" selected="">' . $serviceTitle . '</option>';
            } else {
                $optionHtml .= '<option value="' . $service . '">' . $serviceTitle . '</option>';
            }
        }
    }
    echo $optionHtml;
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_carrierServiceMethod') {
        die;
    }
}

/**
 * Retrieves the shipment carrier label based on the given carrier ID.
 *
 * @param int $id The carrier ID.
 *
 * @return string The shipment carrier label ('UPS' or 'USPS').
 */
function getShipmentCarrierLabel($id){
    $ups = array(14, 15, 16, 17, 18, 19 , 20 , 21 , 22 , 23);
   // $usps = array(5 , 6);
    if(in_array($id , $ups)){
        return 'UPS';
    }else{
        return 'USPS';
    }
}