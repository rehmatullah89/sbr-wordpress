<?php

/**
 * Class OptimizeExperiments
 *
 * Handles extraction of experiment information from the _gaexp cookie for Google Optimize.
 */
if (!class_exists('OptimizeExperiments')) {
    class OptimizeExperiments
    {
        // Returns an array mapping experiment IDs to the client's variants.
        // A/B experiment values are single values. MVT experiment values are arrays.
        // If the client is not part of an experiment, the value is null or non-existent.
        // Non-existent/null experiment values should be treated as default/original variant (0).
        //
        // Example:
        // [
        //    'l-1BI4yTQKS_fmzt2WmKHg' => '0',
        //    'AsOij-R4RRyNlaGoG3LbkA' => ['1', '2'],
        //    'daedXXsORQivKtqvgSSNiQ' => null
        // ]
        //
        // Usage:
        //    $experiments = OptimizeExperiments::experimentsFromRequest();
        //    $variant = $experiments['tNY-e3yLT5u-jRSn5F6Oeg'] ?? 0;
        /**
         * Returns an array mapping experiment IDs to the client's variants.
         *
         * @return array A mapping of experiment IDs to variants.
         */
        static function experimentsFromRequest(): array
        {
            $gaexp = isset($_COOKIE['_gaexp']) ? $_COOKIE['_gaexp'] : '';
            return self::experimentsFromCookie($gaexp);
        }
        /**
         * Parses experiment information from the _gaexp cookie value.
         *
         * @param string $cookieValue The value of the _gaexp cookie.
         * @return array A mapping of experiment IDs to variants.
         */

        static function experimentsFromCookie($cookieValue): array
        {
            $cookieValue = trim($cookieValue);
            if (empty($cookieValue)) {
                return [];
            }

            $matches = null;
            if (!preg_match('/^GAX1\.2\.(.*)$/i', $cookieValue, $matches)) {
                /// self::reportParseFailure($cookieValue);
                return [];
            }

            if (empty($matches)) {
                return [];
            }

            $variants = [];

            // The experiment format is not documented, but there has been discussion about it.
            // See https://support.google.com/optimize/thread/11159980?hl=en.
            $experiments = explode('!', $matches[1]);
            if (empty($experiments)) {
                return [];
            }

            foreach ($experiments as $experiment) {
                if (!preg_match('/^(.*?)\.(.*?)\.(.*?)$/', trim($experiment), $matches)) {
                    /// self::reportParseFailure($cookieValue);
                    continue;
                }

                $experimentId = trim($matches[1]);
                $values = trim($matches[3]);

                // If the experiment variant format is not digits (A/B) or dash-separated digits (MVT),
                // then the client might not be part of the experiment. In this case, set the value to null.
                // See https://support.google.com/optimize/thread/35519440?hl=en.
                if (preg_match('/^\d+(-\d+)*$/', $values)) {
                    if (strpos($values, '-') !== false) {
                        $values = explode('-', $values);
                    }
                } else {
                    $values = null;
                }

                $variants[$experimentId] = $values;
            }

            return $variants;
        }
    }
}

/**
 * Retrieves information about Google Optimize experiments.
 *
 * @param string $type The type of experiment ('tray-system' or 'nightguard-system').
 * @return array An array containing the variant and additional attributes.
 */
function getOptimizeAttr($type = '')
{


    $data = array(
        'variant' => 0,
        'attr' => '',
    );

    if (in_array($type, array('tray-system', 'nightguard-system'))) {
        $experimentIds = array(
            // 'tray-system' => 'ZO7BZldLSCum8PLW6lHk8g',
            'tray-system' => 'h3UQY1cURiGrdKtPe0UhFw',
            //   'nightguard-system' => 'HYTxMG0nQ4G9sVgi0hIrQQ'
            'nightguard-system' => 'w_YPTL8hTfWzRfOOIf8W9Q'

        );
        if (class_exists('OptimizeExperiments')) {
            $experiments = OptimizeExperiments::experimentsFromRequest();
            $lander_experiment_id = $experimentIds[$type];
            $variant =  isset($experiments[$lander_experiment_id])  ? $experiments[$lander_experiment_id]  : 0;
            switch ($variant) {
                case 2:
                    $data['attr'] = ' data-minus_30_test="yes" data-experiment_id="' . $lander_experiment_id . '" data-variant_id="' . $variant . '" ';
                    $data['variant'] = $variant;
                    break;
                case 1:
                    $data['attr'] =  ' data-plus_30_test="yes" data-experiment_id="' . $lander_experiment_id . '" data-variant_id="' . $variant . '" ';
                    $data['variant'] = $variant;
                    break;
                default:
                    break;
            }
        }
    }

    return $data;
}



/**
 * AJAX callback to load product HTML for Google Optimize experiments.
 */
add_action('wp_ajax_loadProductHtmlGoogleOptimize', 'update_loadSBR_OptimizeProductArea_callback');
add_action('wp_ajax_nopriv_loadProductHtmlGoogleOptimize', 'update_loadSBR_OptimizeProductArea_callback');

/**
 * Callback function to handle AJAX requests for loading product HTML based on Google Optimize experiments.
 */
function update_loadSBR_OptimizeProductArea_callback()
{

    if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'tray-system') {
        $atts = array(
            'type' => $_REQUEST['type'],
            'nonsensitive' => $_REQUEST['nonsensitive'],
            'ajax_query' => 'yes',
        );
        echo   teeth_whitening_trays_func($atts);
    } else {
        $atts = array(
            'type' => $_REQUEST['type'],
            'ajax_query' => 'yes',
        );
        echo   display_posts_night_guards($atts);
    }
    die;
}
$enable_google_optimize = get_field('enable_service', 'option');
if ($enable_google_optimize) {
    /**
     * Enqueues JavaScript to load HTML content for Google Optimize experiments.
     */
    add_action('wp_footer', 'loadSBR_OptimizeProductArea');
}

/**
 * JavaScript function to load HTML content for Google Optimize experiments.
 */
function loadSBR_OptimizeProductArea()
{
?>
    <script>
        function loadHtmlProductArea(type, nonsensitive, section_id) {
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    type: type,
                    nonsensitive,
                    action: "loadProductHtmlGoogleOptimize",
                },
                method: "POST",
                dataType: "html",
                success: function(response) {
                    console.log(section_id)
                    jQuery('body').find('#' + section_id).html(response);
                    jQuery('body').find('#' + section_id + ' .price_loading').hide();

                }
            });
        }
        <?php if (get_the_ID() == 427572) {
        ?>
            loadHtmlProductArea('tray-system', true, 'teeth-whitening_non-sensitive');
            loadHtmlProductArea('tray-system', false, 'teeth-whitening_sensitive');
        <?php
        }
        if (get_the_ID() == 427577) {
        ?>
            loadHtmlProductArea('nightguard-system', false, 'product-selection-night-guards');
        <?php
        }
        ?>
    </script>
<?php
}


add_filter('woocommerce_add_cart_item_data', 'set_google_optimize_data', 10, 3);


/**
 * Modifies cart item data to include Google Optimize information.
 *
 * @param array $cart_item_data The current cart item data.
 * @param int $product_id The ID of the product.
 * @param int $variation_id The ID of the product variation.
 * @return array The modified cart item data.
 */
function set_google_optimize_data($cart_item_data, $product_id, $variation_id)
{
    $optimizeVal = 0;
    $optimizeFlag = false;
    if (isset($_REQUEST['plus_30_test'])) {
        $product = wc_get_product($product_id);
        //  if ($product->get_type() == 'composite') {
        $optimizeVal = (int) get_post_meta($product_id, 'plus_value', true);
        $cart_item_data['plus_30_test'] = 30;
        $optimizeFlag = true;
        //}
    }
    if (isset($_REQUEST['minus_30_test'])) {
        $product = wc_get_product($product_id);
        //   if ($product->get_type() == 'composite') {
        $optimizeVal = '-' . (int) get_post_meta($product_id, 'minus_value', true);
        $cart_item_data['minus_30_test'] = 30;
        $optimizeFlag = true;
        //   }
    }

    if ($optimizeFlag) {
        $google_optimize = array(
            'product_id' =>  $product_id,
            'experiment_id' =>  $_POST['experiment_id'],
            'variant_id' =>  $_POST['variant_id'],
            'change_value' =>  $optimizeVal,
        );
        $cart_item_data['google_optimize'] = json_encode($google_optimize);
    }

    return $cart_item_data;
}

/**
 * Callback function to handle order item metadata for Google Optimize experiments.
 */
add_action('woocommerce_new_order_item', 'order_item_meta_google_optimize', 1, 3);
function order_item_meta_google_optimize($item_id, $values)
{

    if (isset($values->legacy_values['google_optimize']) && !empty($values->legacy_values['google_optimize'])) {

        $google_optimize = json_decode($values->legacy_values['google_optimize'], true);
        $order_id = wc_get_order_id_by_order_item_id($item_id);
        $param = array(
            'order_id' => $order_id,
            'item_id' => $item_id,
            'product_id' =>  $google_optimize['product_id'],
            'experiment_id' =>  $google_optimize['experiment_id'],
            'variant_id' => $google_optimize['variant_id'],
            'change_value' =>  $google_optimize['change_value'],
        );
        update_post_meta($order_id, 'google_optimize_order', 'yes');
        sbr_create_google_optimize_orders($param);
    }
}
/**
 * Inserts Google Optimize order information into a custom database table.
 *
 * @param array $param Parameters for Google Optimize order information.
 * @return int The inserted row ID.
 */
function sbr_create_google_optimize_orders($param = array())
{
    global $wpdb;
    $data = array(
        "order_id" => isset($param['order_id']) ? $param['order_id'] : 0,
        "item_id" => isset($param['item_id']) ? $param['item_id'] : 0,
        "product_id" => isset($param['product_id']) ? $param['product_id'] : 0,
        "experiment_id" => isset($param['experiment_id']) ? $param['experiment_id'] : '',
        "variant_id" => isset($param['variant_id']) ? $param['variant_id'] : '',
        "change_value" => isset($param['change_value']) ? $param['change_value'] : 0,
        "created_date" => date("Y-m-d h:i:sa"),
    );
    $wpdb->insert('sbr_google_optimize_orders', $data);
    return $wpdb->insert_id;
}
