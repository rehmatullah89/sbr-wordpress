<?php

add_action('wp_ajax_searchShipMethodByCountryCode', 'searchShipMethodByCountryCode_callback');

function searchShipMethodByCountryCode_callback() {
    if (isset($_REQUEST['countryCode'])) {

        $shipMethod = get_shipping_methods_by_country_code($_REQUEST['countryCode'], true);
        echo $shipMethod;
    } else {
        echo 'Flat Rate';
    }
    die;
}

//
function get_shipping_methods_by_country_code($countery_code = '', $html = false) {
    if ($countery_code == '') {
        return false;
    }
    if ($countery_code == 'US') {
        $zone_name = 'Domestic';
    } else {
        $zone_name = 'International';
    }
    $zones = WC_Shipping_Zones::get_zones();
    $arr = array();
    if ($zone_name == 'International') {
        $arr[0] = array(
            'title' => 'Free',
            'cost' => 0,
        );
    }
    foreach ($zones as $zn) {
        if (isset($zn['zone_name']) && $zn['zone_name'] == $zone_name) {

            $methods = $zn['shipping_methods'];
            if (is_array($methods) && count($methods) > 0) {
                foreach ($methods as $mt) {

                    $shipping_cost = @$mt->cost;
                    if ($shipping_cost == '') {
                        $shipping_cost = 0;
                    }
                    $arr[$mt->instance_id] = array(
                        'title' => $mt->title,
                        'cost' => $shipping_cost,
                    );
                }
            }
        }
    }
    if ($html) {
        ob_start();

        if (is_array($arr) && count($arr) > 0) {
            $shipDropDownHtml = '<select class=" sd select wc-enhanced-select" name="shipping_method_id" id="shipping_method_mbt">';
            $shipDropDownUPSHtml = '';
            $shipDropDownUSPSHtml = '';
            foreach ($arr as $key => $val) {
                if($key == 24){
                   // continue;
                }
                $sel = '';
                $option = '<option value="' . $key . '" data-price="' . $val['cost'] . '"> ' . $val['title'] . '</option>';
                if (getShipmentCarrierLabel($key) == 'UPS') {
                    $shipDropDownUPSHtml .= $option;
                } else {
                    $shipDropDownUSPSHtml .= $option;
                }
            }
            $shipDropDownHtml .= '<optgroup label="USPS">';
            $shipDropDownHtml .= $shipDropDownUSPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '<optgroup label="UPS">';
            $shipDropDownHtml .= $shipDropDownUPSHtml;
            $shipDropDownHtml .= '</optgroup>';
            $shipDropDownHtml .= '</select>';
            echo $shipDropDownHtml;
        }
        ?>
        <script>
            jQuery(document).on("change", "#shipping_method_mbt", function () {
                sel_val = jQuery('option:selected', this).attr('data-price');
                jQuery("#addOnShippingCostAmount").val(sel_val);
                jQuery("body").find("#addOnShippingCostAmount").trigger("change");
            })
        </script>
        <?php

        return ob_get_clean();
    } else {
        return $arr;
    }
}
?>