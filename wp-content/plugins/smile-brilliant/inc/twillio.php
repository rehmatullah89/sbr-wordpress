<?php

/**
 * Sends Twilio SMS notifications based on order status changes.
 *
 * @param array $param An array containing information about the order and its status.
 */
function twillioSMS_withOrder($param)
{


    global $wpdb;
    $notifications_statuses = get_field('send_sms_notifications_for_those_status', 'option');
    $statusUpdated = false;
    if ($param['status'] == 'delivered') {
        if (in_array('tray_delivered', $notifications_statuses)) {
            $param['status'] = 'tray_delivered';
            $statusUpdated = 'delivered';
        }
    }
    if ($param['status'] == 'in_transit') {
        if (in_array('tray_shipped', $notifications_statuses)) {
            $param['status'] = 'tray_shipped';
            $statusUpdated = 'in_transit';
        }
    }

    if (!in_array($param['status'], $notifications_statuses)) {
        return;
    }
    if ($statusUpdated) {
        $param['status'] = $statusUpdated;
    }
    $sent_timestamp = time();
    $tracking_number = 0;
    $trackingUrl = false;
    $order_id = isset($param['order_id']) ? $param['order_id'] : 0;
    $tray_number = isset($param['tray_number']) ? $param['tray_number'] : '';
    $orders = array();
    if (isset($param['shipment_id']) && $param['shipment_id'] > 0) {

        $case2Shipment = false;
        $trayList = array();
        $query = "SELECT order_id , order_number , trackingCode , easyPostShipmentTrackingUrl  , productsWithQty FROM  " . SB_SHIPMENT_ORDERS_TABLE . "  as so";
        $query .= " JOIN " . SB_EASYPOST_TABLE . "  as ep";
        $query .= " ON so.shipment_id=ep.shipment_id ";
        $query .= " WHERE  ep.shipment_id = '" . $param['shipment_id'] . "' ";
        $orders = $wpdb->get_results($query, 'ARRAY_A');
        if (count($orders) > 0) {
            $order_id = isset($orders[0]['order_id']) ? $orders[0]['order_id'] : 0;
            $easyPostShipmentTrackingUrl = isset($orders[0]['easyPostShipmentTrackingUrl']) ? $orders[0]['easyPostShipmentTrackingUrl'] : 0;
            $tracking_number = isset($orders[0]['trackingCode']) ? $orders[0]['trackingCode'] : 'N/A';
            $order_number = implode(',', array_column($orders, 'order_number'));
            if ($easyPostShipmentTrackingUrl) {
                $trackingUrl = sbr_firebase_shorten_url($easyPostShipmentTrackingUrl);
            }
            $products = json_decode($orders[0]['productsWithQty'], true);
            foreach ($products as $item_id => $item) {

                if ($item['type'] == 'composite') {
                    $itemOrderId = $item['order_id'];
                    $trayList[] = $wpdb->get_var("SELECT tray_number FROM  " . SB_ORDER_TABLE . " WHERE order_id = $itemOrderId and item_id = $item_id");
                    if (isset($item['fweight'])) {
                        if ($item['qty'] == 1) {
                        } else {
                            $case2Shipment = true;
                        }
                    } else {
                        if ($item['shipment'] == 1) {
                        } else {
                            $case2Shipment = true;
                        }
                    }
                }
            }
            if ($case2Shipment) {
                if ($param['status'] == 'delivered') {
                    $param['status'] = 'tray_delivered';
                }
                if ($param['status'] == 'in_transit') {
                    $param['status'] = 'tray_shipped';
                }
                if (count($trayList) > 0) {
                    $tray_number = implode(',', $trayList);
                }
            }
        }
    } else {
        $order_number = get_post_meta($order_id, 'order_number', true);
    }
    if (!$order_id) {
        return;
    }

    $orderObj = wc_get_order($order_id);

    $to = $orderObj->get_billing_phone('edit');
    if (!$to) {
        return;
    }
    $messageIndex = array(
        'in_transit' => 'in_transit_sms_message',
        'out_for_delivery' => 'out_for_delivery_sms_message',
        'delivered' => 'delivered_sms_message',
        'impression_received' => 'impression_received_sms_message',
        'tray_shipped' => 'tray_shipped_sms_message',
        'tray_delivered' => 'tray_delivered_sms_message',
    );
    $get_message = get_field($messageIndex[$param['status']], 'option');


    $country_code = $orderObj->get_billing_country('edit');

    $replacements = array(
        '%sbr_brand%' => get_bloginfo('name'),
        '%order_number%' => $order_number,
        '%order_amount%' => $orderObj->get_formatted_order_total(),
        '%first_name%' => $orderObj->get_billing_first_name('edit'),
        '%last_name%' => $orderObj->get_billing_last_name('edit'),
        '%tracking_number%' => $tracking_number,
        '%tracking_url%' => $trackingUrl,
        '%tray_number%' => $tray_number,
    );
    $to = sbr_twillio_format_e164($to, $country_code);
    $message = str_replace(array_keys($replacements), $replacements, $get_message);
    $response = send_twilio_text_sms($to, $message);
    if (count($orders) > 1) {
        foreach ($orders as $ordData) {
            $order = wc_get_order($ordData['order_id']);
            $order->add_order_note(sbr_twillio_format_order_note($to, $sent_timestamp, $message, $response, $param['status']));
        }
    } else {
        $orderObj->add_order_note(sbr_twillio_format_order_note($to, $sent_timestamp, $message, $response, $param['status']));
    }
}

/**
 * Sends Twilio SMS notifications based on order status changes (previous version).
 *
 * @param array $param An array containing information about the order and its status.
 */
function twillioSMS_withOrder_previousVersion($param)
{


    global $wpdb;
    $notifications_statuses = get_field('send_sms_notifications_for_those_status', 'option');
    if (!in_array($param['status'], $notifications_statuses)) {
        return;
    }
    $sent_timestamp = time();
    $tracking_number = 0;
    $trackingUrl = false;
    $order_id = isset($param['order_id']) ? $param['order_id'] : 0;
    $orders = array();
    if (isset($param['shipment_id']) && $param['shipment_id'] > 0) {
        $query = "SELECT order_id , order_number , trackingCode , easyPostShipmentTrackingUrl FROM  " . SB_SHIPMENT_ORDERS_TABLE . "  as so";
        $query .= " JOIN " . SB_EASYPOST_TABLE . "  as ep";
        $query .= " ON so.shipment_id=ep.shipment_id ";
        $query .= " WHERE  ep.shipment_id = '" . $param['shipment_id'] . "' ";
        $orders = $wpdb->get_results($query, 'ARRAY_A');
        if (count($orders) > 0) {
            $order_id = isset($orders[0]['order_id']) ? $orders[0]['order_id'] : 0;
            $easyPostShipmentTrackingUrl = isset($orders[0]['easyPostShipmentTrackingUrl']) ? $orders[0]['easyPostShipmentTrackingUrl'] : 0;
            $tracking_number = isset($orders[0]['trackingCode']) ? $orders[0]['trackingCode'] : 'N/A';
            $order_number = implode(',', array_column($orders, 'order_number'));
            if ($easyPostShipmentTrackingUrl) {
                $trackingUrl = sbr_firebase_shorten_url($easyPostShipmentTrackingUrl);
            }
        }
    } else {
        $order_number = get_post_meta($order_id, 'order_number', true);
    }
    if (!$order_id) {
        return;
    }
    //    if ($order_id == 747861) {
    //        echo '=====';
    //    } else {
    //        return;
    //    }
    $orderObj = wc_get_order($order_id);

    $to = $orderObj->get_billing_phone('edit');
    if (!$to) {
        return;
    }
    $messageIndex = array(
        'in_transit' => 'in_transit_sms_message',
        'out_for_delivery' => 'out_for_delivery_sms_message',
        'delivered' => 'delivered_sms_message',
    );
    $get_message = get_field($messageIndex[$param['status']], 'option');


    $country_code = $orderObj->get_billing_country('edit');

    $replacements = array(
        '%sbr_brand%' => get_bloginfo('name'),
        '%order_number%' => $order_number,
        '%order_amount%' => $orderObj->get_formatted_order_total(),
        '%first_name%' => $orderObj->get_billing_first_name('edit'),
        '%last_name%' => $orderObj->get_billing_last_name('edit'),
        '%tracking_number%' => $tracking_number,
        '%tracking_url%' => $trackingUrl,
    );
    $to = sbr_twillio_format_e164($to, $country_code);
    $message = str_replace(array_keys($replacements), $replacements, $get_message);
    $response = send_twilio_text_sms($to, $message);
    // $response = array();
    if (count($orders) > 1) {
        foreach ($orders as $ordData) {
            $order = wc_get_order($ordData['order_id']);
            $order->add_order_note(sbr_twillio_format_order_note($to, $sent_timestamp, $message, $response, $param['status']));
        }
    } else {
        $orderObj->add_order_note(sbr_twillio_format_order_note($to, $sent_timestamp, $message, $response, $param['status']));
    }
}

/**
 * Shortens URLs using the Firebase Dynamic Links API.
 *
 * @param string $url The URL to be shortened.
 * @return string|false The shortened URL or false if an error occurs.
 */
function sbr_firebase_shorten_url($url)
{

    $shortened_url = $url;
    $api_key = trim('AIzaSyBjMPFcvASzEQuRO87nvriya5zWIVetXXQ');
    $domain = trim('dn.cm/track');

    if (is_string($url) && !empty($api_key) && !empty($domain)) {

        $url = untrailingslashit($url);
        $domain = str_replace(['http://', 'https://'], '', untrailingslashit($domain));
        $api_url = add_query_arg('key', $api_key, 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks');
        $post_args = [
            'method' => 'POST',
            'timeout' => '10',
            'redirection' => 0,
            'httpversion' => '1.0',
            'sslverify' => true,
            'headers' => [
                'content-type' => 'application/json',
            ],
            /** @see https://firebase.google.com/docs/dynamic-links/rest for options */
            'body' => json_encode([
                'longDynamicLink' => "https://{$domain}/?link={$url}",
                'suffix' => [
                    'option' => 'SHORT',
                ],
            ]),
        ];

        $response = wp_safe_remote_post($api_url, $post_args);
    }
    $shortLink = false;
    if ($response instanceof \WP_Error) {
    } else {

        $data = json_decode(wp_remote_retrieve_body($response), true);
        // Google Shortener error
        if (200 === (int) wp_remote_retrieve_response_code($response)) {
            if (!empty($data['shortLink']) && is_string($data['shortLink'])) {
                $shortLink = $data['shortLink'];
            }
        }
    }
    return $shortLink;
}


/**
 * Sends text SMS using the Twilio API.
 *
 * @param string $to The recipient's phone number.
 * @param string $body The SMS message body.
 * @return array The Twilio API response.
 */
function send_twilio_text_sms($to, $body)
{
    $sid = TWILLIO_SID;
    $token = TWILLIO_TOKEN;
    $from = TWILLIO_FROM_NUMBER;
    $url = "https://api.twilio.com/2010-04-01/Accounts/" . $sid . "/Messages.json";
    $data = array(
        'From' => $from,
        'To' => $to,
        'Body' => $body,
    );
    $post = http_build_query($data);
    $x = curl_init($url);
    curl_setopt($x, CURLOPT_POST, true);
    curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($x, CURLOPT_USERPWD, "$sid:$token");
    curl_setopt($x, CURLOPT_POSTFIELDS, $post);
    $y = curl_exec($x);
    curl_close($x);
    return json_decode($y, true);
}


/**
 * Formats an order note for Twilio SMS notifications.
 *
 * @param string $to The recipient's phone number.
 * @param int $sent_timestamp The timestamp when the SMS was sent.
 * @param string $message The SMS message.
 * @param array $response The Twilio API response.
 * @param string $event The order status event.
 * @return string The formatted order note.
 */
function sbr_twillio_format_order_note($to, $sent_timestamp, $message, $response, $event)
{
    try {

        // get datetime object from unix timestamp
        $datetime = new \DateTime("@{$sent_timestamp}", new \DateTimeZone('UTC'));

        // change timezone to site timezone
        $datetime->setTimezone(new \DateTimeZone(wc_timezone_string()));

        // return datetime localized to site date/time settings
        $formatted_datetime = date_i18n(wc_date_format() . ' ' . wc_time_format(), $sent_timestamp + $datetime->getOffset());
    } catch (Exception $e) {
        $formatted_datetime = __('N/A', 'woocommerce');
    }

    ob_start();
?>
    <p><strong><?php esc_html_e('SMS Notification', 'woocommerce-twilio-sms-notifications'); ?></strong></p>
    <p><strong><?php esc_html_e('To', 'woocommerce-twilio-sms-notifications'); ?>: </strong><?php echo esc_html($to); ?></p>
    <p><strong><?php esc_html_e('Event', 'woocommerce-twilio-sms-notifications'); ?>: </strong><?php echo esc_html(implode(' ', array_map(ucfirst, explode('_', $event)))); ?></p>
    <?php
    if (isset($response['code']) && $response['code'] != '') {
    ?>
        <p><strong><?php esc_html_e('Error Code', 'woocommerce-twilio-sms-notifications'); ?>: <span style="color: red;"><?php echo esc_html($response['code']); ?></span></strong></p>
    <?php
    } else {
    ?>
        <p><strong><?php esc_html_e('Status', 'woocommerce-twilio-sms-notifications'); ?>: <span style="color: green;">Sent</span></strong></p>
    <?php
    }
    ?>
    <p><strong><?php esc_html_e('Date Sent', 'woocommerce-twilio-sms-notifications'); ?>: </strong><?php echo esc_html($formatted_datetime); ?></p>
    <p><strong><?php esc_html_e('Message', 'woocommerce-twilio-sms-notifications'); ?>: </strong><?php echo esc_html($message); ?></p>
<?php
    return ob_get_clean();
}

/**
 * Formats a phone number to E.164 international standard.
 *
 * @param string $number The phone number to be formatted.
 * @param string|null $country_code The country code (optional).
 * @return string The formatted phone number.
 */

function sbr_twillio_format_e164($number, $country_code = null)
{

    // if the number starts with a +, assume the customer has entered the country code already, so just strip non-digit characters and return
    if (!strncmp($number, '+', 1)) {
        return '+' . preg_replace('[\D]', '', $number);
    }

    // remove any non-number characters
    $number = preg_replace('[\D]', '', $number);

    $country_calling_code = null;

    // TODO: consider supporting other international call prefixes as well, see https://en.wikipedia.org/wiki/List_of_international_call_prefixes {IT 2017-12-27}
    // number has international call prefix (00)
    if (0 === strpos($number, '00')) {

        // remove international dialing code
        $number = substr($number, 2);

        // determine if the number has a country calling code entered
        foreach (sbr_twillio_get_country_codes() as $code => $prefix) {

            if (0 === strpos($number, $prefix)) {

                $country_calling_code = $prefix;
                break;
            }
        }
    }

    // get the phone country code for given country, if not determined from phone number
    if (!$country_calling_code && $country_code) {

        // add the country code
        $country_calling_code = sbr_twillio_get_country_calling_code($country_code);
        $number = $country_calling_code . $number;
    }

    // if no country calling code can be determined, just return the number as-is
    if (!$country_calling_code) {
        return $number;
    }

    // remove any leading zeroes after the country code
    // but only once, some numbers (like Taiwan) can have mobile numbers that
    // start with the same digits as the country code (e.g. +886 09-88606403) ಠ_ಠ
    if ('0' === substr($number, strlen($country_calling_code), 1)) {
        $number = preg_replace("/{$country_calling_code}0/", $country_calling_code, $number, 1);
    }

    // prepend +
    $number = '+' . $number;

    return $number;
}

/**
 * Get the calling code of a given country
 *
 * @link http://en.wikipedia.org/wiki/List_of_country_calling_codes
 * @since 1.0
 * @param string $country ISO_3166-1_alpha-2 country code
 * @return string country calling code
 */
function sbr_twillio_get_country_calling_code($country)
{

    $country = strtoupper($country);

    $country_codes = sbr_twillio_get_country_codes();

    // return valid country code if country exists or blank country code if not found
    return (isset($country_codes[$country])) ? $country_codes[$country] : '';
}

/**
 * Get the country codes that allow Alphanumeric Sender IDs.
 *
 * @link https://support.twilio.com/hc/en-us/articles/223133767-International-support-for-Alphanumeric-Sender-ID
 *
 * @since 1.6.0
 *
 * @return string[] $country_codes the supported country codes
 */
function sbr_twillio_get_asid_country_codes()
{

    $country_codes = array_keys(sbr_twillio_get_country_codes());

    // The countries that don't allow an ASID
    $non_asid_country_codes = array(
        'AR',
        'BE',
        'BR',
        'CA',
        'CL',
        'CN',
        'CO',
        'CR',
        'DO',
        'EC',
        'GU',
        'HU',
        'IR',
        'KE',
        'KG',
        'KR',
        'KW',
        'KZ',
        'LK',
        'MM',
        'MX',
        'MY',
        'MZ',
        'NI',
        'NR',
        'NZ',
        'PK',
        'PR',
        'SV',
        'SY',
        'TR',
        'US',
        'UY',
        'VE',
        'VN',
        'ZA',
    );

    $country_codes = array_diff($country_codes, $non_asid_country_codes);

    return $country_codes;
}

/**
 * Gets available country codes and their corresponding calling codes.
 *
 * @since 1.0.0
 *
 * @return string[] $country_codes
 */
function sbr_twillio_get_country_codes()
{

    $country_codes = array(
        'AC' => '247',
        'AD' => '376',
        'AE' => '971',
        'AF' => '93',
        'AG' => '1268',
        'AI' => '1264',
        'AL' => '355',
        'AM' => '374',
        'AO' => '244',
        'AQ' => '672',
        'AR' => '54',
        'AS' => '1684',
        'AT' => '43',
        'AU' => '61',
        'AW' => '297',
        'AX' => '358',
        'AZ' => '994',
        'BA' => '387',
        'BB' => '1246',
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BL' => '590',
        'BM' => '1441',
        'BN' => '673',
        'BO' => '591',
        'BQ' => '599',
        'BR' => '55',
        'BS' => '1242',
        'BT' => '975',
        'BW' => '267',
        'BY' => '375',
        'BZ' => '501',
        'CA' => '1',
        'CC' => '61',
        'CD' => '243',
        'CF' => '236',
        'CG' => '242',
        'CH' => '41',
        'CI' => '225',
        'CK' => '682',
        'CL' => '56',
        'CM' => '237',
        'CN' => '86',
        'CO' => '57',
        'CR' => '506',
        'CU' => '53',
        'CV' => '238',
        'CW' => '599',
        'CX' => '61',
        'CY' => '357',
        'CZ' => '420',
        'DE' => '49',
        'DJ' => '253',
        'DK' => '45',
        'DM' => '1767',
        'DO' => '1809',
        'DZ' => '213',
        'EC' => '593',
        'EE' => '372',
        'EG' => '20',
        'EH' => '212',
        'ER' => '291',
        'ES' => '34',
        'ET' => '251',
        'EU' => '388',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'FR' => '33',
        'GA' => '241',
        'GB' => '44',
        'GD' => '1473',
        'GE' => '995',
        'GF' => '594',
        'GG' => '44',
        'GH' => '233',
        'GI' => '350',
        'GL' => '299',
        'GM' => '220',
        'GN' => '224',
        'GP' => '590',
        'GQ' => '240',
        'GR' => '30',
        'GT' => '502',
        'GU' => '1671',
        'GW' => '245',
        'GY' => '592',
        'HK' => '852',
        'HN' => '504',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'ID' => '62',
        'IE' => '353',
        'IL' => '972',
        'IM' => '44',
        'IN' => '91',
        'IO' => '246',
        'IQ' => '964',
        'IR' => '98',
        'IS' => '354',
        'IT' => '39',
        'JE' => '44',
        'JM' => '1',
        'JO' => '962',
        'JP' => '81',
        'KE' => '254',
        'KG' => '996',
        'KH' => '855',
        'KI' => '686',
        'KM' => '269',
        'KN' => '1869',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KY' => '1345',
        'KZ' => '7',
        'LA' => '856',
        'LB' => '961',
        'LC' => '1758',
        'LI' => '423',
        'LK' => '94',
        'LR' => '231',
        'LS' => '266',
        'LT' => '370',
        'LU' => '352',
        'LV' => '371',
        'LY' => '218',
        'MA' => '212',
        'MC' => '377',
        'MD' => '373',
        'ME' => '382',
        'MF' => '590',
        'MG' => '261',
        'MH' => '692',
        'MK' => '389',
        'ML' => '223',
        'MM' => '95',
        'MN' => '976',
        'MO' => '853',
        'MP' => '1670',
        'MQ' => '596',
        'MR' => '222',
        'MS' => '1664',
        'MT' => '356',
        'MU' => '230',
        'MV' => '960',
        'MW' => '265',
        'MX' => '52',
        'MY' => '60',
        'MZ' => '258',
        'NA' => '264',
        'NC' => '687',
        'NE' => '227',
        'NF' => '672',
        'NG' => '234',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'NZ' => '64',
        'OM' => '968',
        'PA' => '507',
        'PE' => '51',
        'PF' => '689',
        'PG' => '675',
        'PH' => '63',
        'PK' => '92',
        'PL' => '48',
        'PM' => '508',
        'PR' => '1787',
        'PS' => '970',
        'PT' => '351',
        'PW' => '680',
        'PY' => '595',
        'QA' => '974',
        'QN' => '374',
        'QS' => '252',
        'QY' => '90',
        'RE' => '262',
        'RO' => '40',
        'RS' => '381',
        'RU' => '7',
        'RW' => '250',
        'SA' => '966',
        'SB' => '677',
        'SC' => '248',
        'SD' => '249',
        'SE' => '46',
        'SG' => '65',
        'SH' => '290',
        'SI' => '386',
        'SJ' => '47',
        'SK' => '421',
        'SL' => '232',
        'SM' => '378',
        'SN' => '221',
        'SO' => '252',
        'SR' => '597',
        'SS' => '211',
        'ST' => '239',
        'SV' => '503',
        'SX' => '1721',
        'SY' => '963',
        'SZ' => '268',
        'TA' => '290',
        'TC' => '1649',
        'TD' => '235',
        'TG' => '228',
        'TH' => '66',
        'TJ' => '992',
        'TK' => '690',
        'TL' => '670',
        'TM' => '993',
        'TN' => '216',
        'TO' => '676',
        'TR' => '90',
        'TT' => '1868',
        'TV' => '688',
        'TW' => '886',
        'TZ' => '255',
        'UA' => '380',
        'UG' => '256',
        'UK' => '44',
        'US' => '1',
        'UY' => '598',
        'UZ' => '998',
        'VA' => '39',
        'VC' => '1784',
        'VE' => '58',
        'VG' => '1284',
        'VI' => '1340',
        'VN' => '84',
        'VU' => '678',
        'WF' => '681',
        'WS' => '685',
        'XC' => '991',
        'XD' => '888',
        'XG' => '881',
        'XL' => '883',
        'XN' => '857',
        'XP' => '878',
        'XR' => '979',
        'XS' => '808',
        'XT' => '800',
        'XV' => '882',
        'YE' => '967',
        'YT' => '262',
        'ZA' => '27',
        'ZM' => '260',
        'ZW' => '263',
    );

    return $country_codes;
}
