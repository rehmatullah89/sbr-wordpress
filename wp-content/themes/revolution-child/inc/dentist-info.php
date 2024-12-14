<?php
$user_id = '';
$wpdb;
// echo get_query_var('dentist_name');
// die();
if (get_query_var('dentist_name') != false && get_query_var('dentist_name') != '') {
  if(function_exists('bp_version')){

  $user_id = bp_core_get_userid(get_query_var('dentist_name'));
  }
}
if((strpos($_SERVER["REQUEST_URI"], 'my-account')  !== false || strpos($_SERVER["REQUEST_URI"], 'members')  !== false ) && is_user_logged_in() ) {
  $user_id = get_current_user_id();
}

if (!$user_id || $user_id == '') {
  $user_id = $wpdb->get_var( "SELECT ID FROM wp_users WHERE user_login = '".get_query_var('dentist_name')."'" );

}

$statesUs = [
  'AL'=>'Alabama',
  'AK'=>'Alaska',
  'AZ'=>'Arizona',
  'AR'=>'Arkansas',
  'CA'=>'California',
  'CO'=>'Colorado',
  'CT'=>'Connecticut',
  'DE'=>'Delaware',
  'DC'=>'District of Columbia',
  'FL'=>'Florida',
  'GA'=>'Georgia',
  'HI'=>'Hawaii',
  'ID'=>'Idaho',
  'IL'=>'Illinois',
  'IN'=>'Indiana',
  'IA'=>'Iowa',
  'KS'=>'Kansas',
  'KY'=>'Kentucky',
  'LA'=>'Louisiana',
  'ME'=>'Maine',
  'MD'=>'Maryland',
  'MA'=>'Massachusetts',
  'MI'=>'Michigan',
  'MN'=>'Minnesota',
  'MS'=>'Mississippi',
  'MO'=>'Missouri',
  'MT'=>'Montana',
  'NE'=>'Nebraska',
  'NV'=>'Nevada',
  'NH'=>'New Hampshire',
  'NJ'=>'New Jersey',
  'NM'=>'New Mexico',
  'NY'=>'New York',
  'NC'=>'North Carolina',
  'ND'=>'North Dakota',
  'OH'=>'Ohio',
  'OK'=>'Oklahoma',
  'OR'=>'Oregon',
  'PA'=>'Pennsylvania',
  'RI'=>'Rhode Island',
  'SC'=>'South Carolina',
  'SD'=>'South Dakota',
  'TN'=>'Tennessee',
  'TX'=>'Texas',
  'UT'=>'Utah',
  'VT'=>'Vermont',
  'VA'=>'Virginia',
  'WA'=>'Washington',
  'WV'=>'West Virginia',
  'WI'=>'Wisconsin',
  'WY'=>'Wyoming',
];
if (!$user_id || $user_id == '') {
  if ( is_email( get_query_var('dentist_name') ) ) {
    $current_url  = $_SERVER['REQUEST_URI'];
    $userr = get_user_by( 'email', get_query_var('dentist_name') );
    $user_id = $userr->id;
    $field_value = '';
    if(function_exists('bp_version')){
    $user_id_bp = bp_core_get_userid($userr->user_login);
    $field_value = bp_get_profile_field_data(array(
      'field' => 'Referral',
      'user_id' => $user_id,
  
  ));
}
    if(is_user_logged_in()) {
      wp_safe_redirect(home_url().'/my-account/support');
      die();
    }

    if($user_id_bp !='') {
      $current_url = str_replace( get_query_var('dentist_name'),$userr->user_login,$current_url);
      wp_safe_redirect(home_url(). $current_url);
      die();
    }
  }
}

if (!$user_id || $user_id == '') {
  wp_safe_redirect(home_url());
  exit;
 }
 $user_id = (int) $user_id;
    $fname = get_user_meta($user_id,'first_name',true);
    if($fname == '') {
        update_user_meta($user_id,'first_name',get_user_meta($user_id,'first_name_temp',true));
    }

$sql_query2 = "select * from buddy_user_meta where user_id =" . $user_id;
$results_query2 = $wpdb->get_results($sql_query2, 'ARRAY_A');
if ($results_query2 == null || count($results_query2) == 0) {
  // wp_safe_redirect(home_url());
  // exit;
}
$contact = array();
$professional = array();
$education = array();
$experience = array();
$liscence = array();
$social = array();
$address = array();
$contact = array();
$brief = '';

global $wpdb;
$affiliate_id = $wpdb->get_var(
  $wpdb->prepare(
    "
            SELECT affiliate_id
            FROM wp_affiliate_wp_affiliates
            WHERE user_id = %d
            AND status = 'active'
        ",
    $user_id
  )
);
$rdh_subtitle = get_field('rdh_titleline', 'user_' . $user_id);
if (is_array($results_query2) && count($results_query2) > 0) {
  foreach ($results_query2 as $key => $ed) {
    if ($ed['key'] == 'contact') {
      $ed['value'] = str_replace("\'", "'", $ed['value']);
      $contact = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'professional') {
      $ed['value'] = str_replace("\'", "'", $ed['value']);
      $professional = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'education') {
      //  echo 'yes';
      //$ed['value'] = str_replace("\'","'",$ed['value']);
      $education = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'experience') {
      //  $edu = str_replace("\'","'",$ed['value']);
      $experience = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'liscence') {
      // $ed['value'] = str_replace("\'","'",$ed['value']);
      $liscence = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'social') {
      $ed['value'] = str_replace("\'", "'", $ed['value']);
      $social = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'address') {
      $ed['value'] = str_replace("\'", "'", $ed['value']);
      $address = json_decode($ed['value'], true);
    }
    if ($ed['key'] == 'biref') {
      $ed['value'] = str_replace("\'", "'", $ed['value']);
      $brief = $ed['value'];
    }
  }
}
// echo '<pre>';
// print_r($social);
// echo '</pre>';
$address_address =  isset($address['address']) ? $address['address'] : '';
$address_town_city =  isset($address['town_city']) ? $address['town_city'] : '';
$address_country = isset($address['country']) ? $address['country'] : 'US';
$address_apt =  isset($address['apt']) ? $address['apt'] : '';
$address_zipcode =  isset($address['zipcode']) ? $address['zipcode'] : '';
$address_state =  isset($address['state']) ? $address['state'] : '';
$address_address = str_replace("\'", "'", $address_address);
$address_apt = str_replace("\'", "'", $address_apt);
$new_user = get_userdata($user_id);
$user_name=$new_user->user_login;
$user_firstname = get_user_meta($user_id, 'first_name', true);
$embed_url = get_user_meta($user_id, 'rdh_video_url', true);
$user_lastname = get_user_meta($user_id, 'last_name', true);
$billing_phone =  get_user_meta($user_id, 'billing_phone', true);
$titles = isset($contact['titles']) ? $contact['titles'] : array();
