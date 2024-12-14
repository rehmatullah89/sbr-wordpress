<?php
global $wpdb;
$user_id = get_current_user_id();
$sql_query = "select * from buddy_user_meta WHERE user_id=" . get_current_user_id();
$results_arr = $wpdb->get_results($sql_query, 'ARRAY_A');
$contact = array();
$professional = array();
$education = array();
$liscence = array();
$experience = array();
$address = array();
$biref = '';
$embed_url = get_user_meta($user_id, 'rdh_video_url', true);
$rdhc_video_  = get_user_meta($user_id, 'rdhc_video_', true);
$current_user = wp_get_current_user();
$useremail = $current_user->user_email;
$userename = $current_user->user_nicename;
$field_value = bp_get_profile_field_data(array(
    'field' => 'Referral',
    'user_id' => $user_id,

));
// echo '<pre>';
// print_r($results_arr);
// echo '</pre>';
if ($field_value != '') {
    echo  '<div class="row sidebarNavigationBuddyPress tabscontainer editProfileTabs" style="opacity:0;" >';
    echo  '<div class="small-12 columns" >';
    echo  '<div class="post-content no-vc">';
    echo  '<div class="flexDesktop">';
    echo  '<div class="sideBarNavigationList">';
    require_once(get_stylesheet_directory() . '/woocommerce/myaccount/navigation.php');
    echo '</div>';
    wp_enqueue_style('dashboardStyles', get_stylesheet_directory_uri() . '/assets/css/dashboardStyles.css', '', time());



    if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'professional') {
?>
        <script>
            jQuery(document).ready(function() {
                jQuery('#pills-professional-tab').click();
            });
        </script>

    <?php
    }
    if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'social') {
    ?>
        <script>
            jQuery(document).ready(function() {
                jQuery('#pills-social-tab').click();
            });
        </script>

    <?php
    }

    if (isset($_GET['active-tab']) && $_GET['active-tab'] == 'publications') {
        ?>
            <script>
                jQuery(document).ready(function() {
                    jQuery('#pills-my-publication').click();


                });
            </script>
    
        <?php
        }

    ?>

    <div class="myAccountContainerMbtInner ">
        <div class="d-flex align-items-center f-flex-custom menuParentRowHeading menuParentRowHeadingProfile mobile-settingRDH borderBottomLine fileEdit">
            <div class="pageHeading_sec">
                <span><span class="text-blue">RDHC Profile Manager</span>
                    Manage & Update...
                </span>
            </div>
            <?php
            $user_idd = bp_core_get_userid(bp_core_get_username(get_current_user_id()));

            if (!$user_idd || $user_idd == '') {
                $linkslug = $wpdb->get_var("SELECT user_login FROM wp_users WHERE user_nicename = '" . bp_core_get_username(get_current_user_id()) . "'");
            } else {
                $linkslug = bp_core_get_username(get_current_user_id());
            }
            ?>
            <div class="view-article-public-link">
                <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-my-faq" data-toggle="pill" href="javascript:;" role="tab" aria-controls="" aria-selected="false"><span> <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                    </span> FAQ</a>
                <?php
                $rows = get_field('rdhc_invite_codes', 'option');
               // $rdhc_video_ = '';
                if ($rows) {
                    foreach ($rows as $row) {
                        $rdhc_email_address = isset($row['rdhc_email_address']) ? $row['rdhc_email_address'] : '';
                        $rdhc_invite_code = $row['rdhc_invite_code'] ? $row['rdhc_invite_code'] : '';
                        $rdhc_code_usage_limit = $row['rdhc_code_usage_limit'] ? $row['rdhc_code_usage_limit'] : '';

                        if ($rdhc_email_address == $useremail) {
                           // $rdhc_video_ = $row['rdhc_video_'] ? $row['rdhc_video_'] : '';
                        }
                        if ($rdhc_email_address == $useremail && $rdhc_invite_code != '') {
                ?>
                            <!-- <div class="referal-code">
                                <span><span class="referrsl-codeText">Invite Code:</span> <strong></strong></span>
                            </div> -->
                <?php


                        }
                    }
                }

                ?>

                <a class="hiddenDefault" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
                    </span> View My Public Profile</a>
            </div>

        </div>


        <?php if ($field_value != '') {
        ?>
            <!-- <div class="copyLinkToClickBoards mobile-settingRDH hidden">
                        <a   class="viewPublickProfileAnchor-t" target="_blank" href="/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-external-link" aria-hidden="true"></i>
                        </span>View public profile</a>
                        <a target="_blank" class="copy_text viewPublickProfileAnchor"  data-toggle="tooltip" title="URL copied" href="<?php echo get_home_url(); ?>/rdh/profile/<?php echo  $linkslug; ?>"> <span> <i class="fa fa-clipboard" aria-hidden="true"></i>
                        </span>Copy</a>
                    </div>    
                    <div class="messageCopyToClickBoard">
                        <div class="messageCopyToClickBoardInner">
                            <div class="displayCopyMessage">URL copied</div>
                        </div>
                    </div> -->
        <?php } ?>


        <ul class="nav nav-tabs  mt-3 customTabs tabsDesktop hidden-mobile windowAlertPopUpRemove">
            <li class="nav-item">
                <a class="uppercase  nav-link active ripple-button rippleSlowAnimate" id="pills-contact-tab" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-home" aria-selected="true">Contact</a>
            </li>
            <li class="nav-item">
                <a class="uppercase nav-link ripple-button rippleSlowAnimate" id="pills-professional-tab" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-profile" aria-selected="false">Professional</a>
            </li>
            <li class="nav-item">
                <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-social-tab" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-password" aria-selected="false">Social Media</a>
            </li>

            <li class="nav-item my-publications-tab">
                <a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-my-publication" data-toggle="pill" href="javascript:;" role="tab" aria-controls="pills-publication" aria-selected="false">My Publications</a>
            </li>


            <li class="nav-item">
                <a href="/my-account/edit-account/?active-tab=pass">
                    Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="" sublink="rdh" id="pills-password-tab" href="<?php echo "/members/" . bp_core_get_username(get_current_user_id()) . "/profile/change-avatar"; ?>">
                    Upload Photo
                </a>
            </li>

        </ul>
        <div class="ajax-res-rdh"></div>
    <?php
}
if (is_array($results_arr) && count($results_arr) > 0) {
    foreach ($results_arr as $key => $ed) {
        if ($ed['key'] == 'contact') {
            $contact = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'professional') {
            $professional = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'education') {
            $education = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'liscence') {
            $liscence = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'experience') {
            $experience = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'social') {
            $social = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'address') {
            $address = json_decode($ed['value'], true);
        }
        if ($ed['key'] == 'biref') {
            $biref = $ed['value'];
        }
    }
}
$states_String =  '  <option value="" selected="selected">Select a State</option>
<option value="AL">Alabama</option>
<option value="AK">Alaska</option>
<option value="AZ">Arizona</option>
<option value="AR">Arkansas</option>
<option value="CA">California</option>
<option value="CO">Colorado</option>
<option value="CT">Connecticut</option>
<option value="DE">Delaware</option>
<option value="DC">District Of Columbia</option>
<option value="FL">Florida</option>
<option value="GA">Georgia</option>
<option value="HI">Hawaii</option>
<option value="ID">Idaho</option>
<option value="IL">Illinois</option>
<option value="IN">Indiana</option>
<option value="IA">Iowa</option>
<option value="KS">Kansas</option>
<option value="KY">Kentucky</option>
<option value="LA">Louisiana</option>
<option value="ME">Maine</option>
<option value="MD">Maryland</option>
<option value="MA">Massachusetts</option>
<option value="MI">Michigan</option>
<option value="MN">Minnesota</option>
<option value="MS">Mississippi</option>
<option value="MO">Missouri</option>
<option value="MT">Montana</option>
<option value="NE">Nebraska</option>
<option value="NV">Nevada</option>
<option value="NH">New Hampshire</option>
<option value="NJ">New Jersey</option>
<option value="NM">New Mexico</option>
<option value="NY">New York</option>
<option value="NC">North Carolina</option>
<option value="ND">North Dakota</option>
<option value="OH">Ohio</option>
<option value="OK">Oklahoma</option>
<option value="OR">Oregon</option>
<option value="PA">Pennsylvania</option>
<option value="RI">Rhode Island</option>
<option value="SC">South Carolina</option>
<option value="SD">South Dakota</option>
<option value="TN">Tennessee</option>
<option value="TX">Texas</option>
<option value="UT">Utah</option>
<option value="VT">Vermont</option>
<option value="VA">Virginia</option>
<option value="WA">Washington</option>
<option value="WV">West Virginia</option>
<option value="WI">Wisconsin</option>
<option value="WY">Wyoming</option><option value="AA">Armed Forces (AA)</option><option value="AE">Armed Forces (AE)</option><option value="AP">Armed Forces (AP)</option>';
$countries_String = '<option>select country</option><option value="AF">Afghanistan</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BR">Brazil</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, Democratic Republic of the Congo</option><option value="CR">Costa Rica</option><option value="CI">Cote D Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea, Democratic Peoples Republic of</option><option value="KR">Korea, Republic of</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao Peoples Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia, the Former Yugoslav Republic of</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States of</option><option value="MD">Moldova, Republic of</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="CS">Serbia and Montenegro</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan, Province of China</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania, United Republic of</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.s.</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>';
$years_string = '<option value="">Year</option>';
for ($i = 1950; $i <= date('Y'); $i++) {
    $years_string .= '<option value="' . $i . '">' . $i . '</option>';
}
$month_string = '<option value="">Month</option>
<option value="1">Janaury</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>';
$states_liscence = '<div class="liscence-wrapper"><div class="editfield degree_title full-width-field educationTitle">
<legend>state*</legend>
<select name="repeater_state[state][0]"  class="repeater_state_state" required>
' . $states_String . '
</select>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>License Number*</legend>
<input type="text" name="repeater_state[liscence][0]" class="repeater_state_liscence" required value="" placeholder="License*"/>
</div></div>';
$degree_string = '<div class="editfield degree_title full-width-field educationTitle">
<legend>School*</legend>
<input type="text" required name="repeater_degree[school][0]" value="" class="repeater_degree_school" placeholder="Ex: Boston University*"/>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>Degree*</legend>
<input type="text" required name="repeater_degree[degree_title][0]" value="" class="repeater_degree_title" placeholder="Ex: Bacholer"/>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>Graduation Date*</legend>
<input type="date" required name="repeater_degree[grad_date][0]" value="" class="repeater_degree_date"/>
</div>
';
$month_start_Str = str_replace('<option ', '<option ms="" ', $month_string);
$month_end_Str = str_replace('<option ', '<option me="" ', $month_string);

$year_start_Str = str_replace('<option ', '<option ys="" ', $years_string);
$year_end_Str = str_replace('<option ', '<option ye="" ', $years_string);


$exp_string = '<div class="editfield degree_title"><legend>Title</legend><input type="text" name="repeater_exp[exp_title][]" value="" placeholder="Title"/></div>
<div class="editfield degree_title"><legend>Company name</legend><input type="text" name="repeater_exp[company][]" value="" placeholder="Company" /></div>
<div class="editfield degree_title"><div class="editfieldd degree_titlee employementFIelds"><legend> Employment Type</legend><select name="repeater_exp[exp_employment_type][]"><option value="Full-time">Full-time</option><option value="Part-time">Part-time</option><option value="Self-Employed">Self-Employed</option><option value="Contract">Contract</option><option value="Internship">Internship</option><option value="Apprenticeship">Apprenticeship</option><option value="Seasonal">Seasonal</option> </select></div></div>
<div class="editfield degree_title"><div class="editfieldd degree_titlee employementFIelds"><legend> Country</legend><select name="repeater_exp[country][]" class="ccountry">'.$countries_String.' </select></div></div>
<div class="editfield degree_title estateFIelds"><legend>State</legend><select  class="location ccstate" name="repeater_exp[state][]">' . $states_String . '</select></div>
<div class="editfield degree_title"><legend>City</legend><input type="text" class="location" name="repeater_exp[city][]" value=""  placeholder="City" /></div>
<div class="editfield degree_title educationTitle">
<legend>Start Date*</legend>							
<select name="repeater_exp[start_month][]">
' . $month_start_Str . '
</select>
</div>
<div class="editfield degree_title educationTitle">
<legend class="startDateEmphty">Start Date</legend>							
<select class="mbtstartdate" name="repeater_exp[start_year][]">
' . $year_start_Str . '

</select>
</div>
<div class="editfield degree_title educationTitle hide-checked">
<legend>End Date</legend>								
<select name="repeater_exp[end_month][]">
' . $month_end_Str . '
</select>
</div>
<div class="editfield degree_title educationTitle hide-checked">
<legend class="startDateEmphty">End Date</legend>	
<select class="mbtenddate" name="repeater_exp[end_year][]">
' . $year_end_Str . '

</select>
</div>

<div class="editfield degree_title currentlyWorkingInthisRole"><input type="hidden" name="repeater_exp[currently_working_action][]" class="currently_working_action" ><input type="checkbox" class="currently_Work" checked name="repeater_exp[currently_working][]" /><span class="mb-0">I am currently working in this role</span></div>';
/**
 * BuddyPress - Members Single Profile Edit
 *
 * @since 3.0.0
 * @version 3.1.0
 */

bp_nouveau_xprofile_hook('before', 'edit_content');
//bp_nouveau_signup_hook( 'before', 'signup_profile' );
    ?>
    <?php
    $total_required = 0;
    $total_not_empty = 0;
    $req_array = array();

    ?>

    <h1 class="screen-heading edit-profile-screen editProfileHeadingPage product-header-primary"><?php esc_html_e('Edit Profile', 'buddypress'); ?></h1>
    <?php
    if (isset($_REQUEST['updated'])) {
        echo '<div class="changes-updated"><span> Your changes have been updated successfully</span></div>';
    }
    for ($i = 1; $i <= 6; $i++) {
        if (bp_has_profile('profile_group_id=' . $i)) :
            //  echo $i;
            while (bp_profile_groups()) :
                bp_the_profile_group();
                while (bp_profile_fields()) :
                    bp_the_profile_field();

                    $val = bp_get_the_profile_field_value();


                    $field = xprofile_get_field(bp_get_the_profile_field_id());
                    $required = isset($field->is_required) ? $field->is_required : false;
                    if ($required) {
                        $total_required++;
                        // echo 'required';
                    }
                    if ($required && $val != '') {
                        $total_not_empty++;
                        // echo 'required';
                    }
                    if ($required && $val == '') {
                        $req_array[] = bp_get_the_profile_group_slug();
                    }
                endwhile;
            endwhile;
        endif;
    }

    ?>
    <script>
        var req_json = <?php echo json_encode($req_array); ?>;
        jQuery(document).ready(function() {
            jQuery('.button-tabs li a').each(function() {
                current_text = jQuery(this).text();
                current_text2 = current_text.toLowerCase();
                current_text3 = current_text2.replace(' ', '-');
                current_text3 = current_text3.replace(' ', '-');
                // console.log(req_json);
              
                if (req_json.includes(current_text3)) {
                    url_existing = window.location.href;
                    // if(current_text3 =='contact-information') {

                    //     if(!url_existing.includes('/3')) {
                    //         new_location = url_existing.replace("/1", "/3");
                    //         console.log(new_location);
                    //        // window.location.href = new_location;
                    //     }
                    // }
                    // if(current_text3 =='professional-information') {
                    //     if(!url_existing.includes('/4')) {
                    //         new_location = url_existing.replace("/3", "/4");
                    //         console.log(new_location);
                    //         //window.location.href = new_location;
                    //     }

                    // }
                    jQuery(this).parent().removeClass('stepsDone');
                    jQuery(this).parent().removeClass('completed');
                    jQuery(this).parent().next('li').addClass('stepsNotDonePrevious');
                } else {
                    jQuery(this).parent().addClass('completed');
                }
            });
        });
    </script>


    <?php


    if (get_transient('submitted_aff')) {
        delete_transient('submitted_aff');
    ?>
        <script>
            jQuery(document).ready(function() {
                url_existing = window.location.href;
                if (url_existing.includes("/1")) {
                    new_location = url_existing.replace("/1", "/3");
                }
                if (url_existing.includes("/3")) {
                    new_location = url_existing.replace("/3", "/4");
                }
                if (url_existing.includes("/4")) {
                    new_location = url_existing.replace("/4", "/5");
                }
                if (url_existing.includes("/5")) {
                    new_location = '/rdh-thankyou';
                }
                window.location.href = new_location;
            });
        </script>
    <?php
    }

    ?>
    <div class="progressBarStrip">
        <progress id="b-progress" value="<?php echo $total_not_empty; ?>" max="<?php echo $total_required; ?>"> 32% </progress>

        <?php
        if (bp_has_profile('profile_group_id=' . bp_get_current_profile_group_id())) :
            while (bp_profile_groups()) :
                bp_the_profile_group();
        ?>
                <label for="file">Profile Progress:</label>
    </div>
    <form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form profile-edit <?php bp_the_profile_group_slug(); ?>">
        <div class="container tabsWrapperParent">
            <?php bp_nouveau_xprofile_hook('before', 'field_content'); ?>

            <?php if (bp_profile_has_multiple_groups()) : ?>
                <ul class="button-tabs button-nav">

                    <?php bp_profile_group_tabs(); ?>

                </ul>
            <?php endif; ?>
            <div class="tabsWrapperParentChild">
                <h3 class="screen-heading profile-group-title edit hidden-desktop" style="display:none;">
                    <?php
                    printf(
                        /* translators: %s = profile field group name */
                        __('<span class="editingTextpro" style="display:none;">Profile Group</span><span class="editingTextInfo">%s</span>', 'buddypress'),
                        bp_get_the_profile_group_name()
                    )
                    ?>
                </h3>





                <div class="contact-info-section tab active" id="contact_info">
                    <h2 class="section-headings">Contact Info</h2>




                    <div class="editfield field_127 field_gender required-field visibility-public field_type_radio anim-wrap">
                        <fieldset class="no-label">
                            <legend>
                                Gender <span class="bp-required-field-label">(required)</span> </legend>
                            <?php
                            $femselected = '';
                            $maleselected = '';
                            $gender =  isset($contact['gender']) ? $contact['gender'] : '';
                            if ($gender == 'Female') {
                                $femselected = "checked";
                            }
                            if ($gender == 'Male') {
                                $maleselected = "checked";
                            }
                            $cellphone =  isset($contact['cellphone']) ? $contact['cellphone'] : '';
                            $bday_day =  isset($contact['bday']['day']) ? $contact['bday']['day'] : '';
                            $bday_month =  isset($contact['bday']['month']) ? $contact['bday']['month'] : '';
                            $bday_year =  isset($contact['bday']['year']) ? $contact['bday']['year'] : '';
                            $titles =  isset($contact['titles']) ? $contact['titles'] : '';


                            ?>
                            <div id="contact[gender]" class="input-options radio-button-options"><label for="option_166" class="option-label"><input type="radio" name="contact[gender]" id="option_166" value="Female" <?php echo $femselected; ?>>Female</label><label for="option_167" class="option-label"><input type="radio" name="contact[gender]" id="option_167" value="Male" <?php echo $maleselected; ?>>Male</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="username-or-emailField">
                        <?php
                        if ($field_value == '') {
                        ?>
                            <div class="editfield field_1289 field_Username required-field visibility-public field_type_radio ">
                                <fieldset class="yes-label ">
                                    <legend id="">Username</legend>

                                    <div class="input-parent-pos">
                                        <input id="signup_username" name="signup_username" type="text" value="<?php echo $userename; ?>" required="" placeholder="">
                                        <span class="smooth spinner"></span>
                                    </div>
                                </fieldset>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="editfield field_1289 field_Username required-field visibility-public field_type_radio  disableEmail">
                                <fieldset class="yes-label ">
                                    <legend id="">Username</legend>
                                    <input id="" name="" type="text" value="<?php echo $userename; ?>" required="" placeholder="" disabled>
                                </fieldset>
                            </div>
                        <?php
                        }
                        ?>


                        <div class="editfield field_1288 field_email required-field visibility-public field_type_radio emailAddressDisplay disableEmail">
                            <fieldset class="yes-label ">
                                <legend id="">Your Email</legend>
                                <input id="" name="" type="email" value="<?php echo $useremail; ?>" required="" placeholder="Email" disabled>
                            </fieldset>
                        </div>
                    </div>
                    <?php
                    $no_label =  array('textbox', 'wp-textbox', 'telephone', 'email', 'radio', 'number', 'wp-biography');
                    //	echo bp_get_the_profile_field_type();
                    $custom_cl = '';

                    while (bp_profile_fields()) :
                        bp_the_profile_field();
                        $rferal_cal = '';
                        if (trim(bp_get_the_profile_field_name()) == 'First Name' && $field_value != '') {
                            $firs_name_val = get_user_meta($user_id, 'first_name', true);
                    ?>
                            <script>
                                jQuery(document).ready(function() {
                                    jQuery('#field_1').val('<?php echo $firs_name_val; ?>');
                                });
                            </script>

                        <?php
                        }
                        if (trim(bp_get_the_profile_field_name()) == 'Referral') {
                            $val = trim(strip_tags(bp_get_the_profile_field_value()));
                            if ($val != '') {
                                $rferal_cal = 'referal_added';
                            }


                        ?>
                            <!-- <div class="editfield degree_title anim-wrap">
                            <legend>Referral*</legend><input type="text" required="" id="Referral-code" name="" value="<?php // echo $val; 
                                                                                                                        ?>" aria-invalid="false" readonly disabled>
                        </div> -->
                        <?php
                            // continue;
                        }

                        if (in_array(bp_get_the_profile_field_type(), $no_label)) {
                            $custom_cl = 'no-label';
                        }
                        // echo '<pre>';
                        // print_r($value);
                        // echo '</pre>';
                        ?>

                        <div<?php bp_field_css_class('editfield'); ?>>
                            <fieldset class="<?php echo $custom_cl; ?> <?php echo $rferal_cal; ?>">

                                <?php
                                $field_type = bp_xprofile_create_field_type(bp_get_the_profile_field_type());
                                $field_type->edit_field_html();
                                // echo '<pre>';
                                // print_r($field_type);
                                ?>

                                <?php bp_nouveau_xprofile_edit_visibilty(); ?>

                            </fieldset>
                </div>

            <?php
                    endwhile; ?>
            <?php $classes = bp_get_field_css_class('editfield');

            ?>

            <div class="editfield contact[cellphone] field_cell-phone required-field visibility-public alt field_type_telephone">
                <fieldset class="no-label">

                    <legend id="field_133-1">
                        Cell Phone <span class="bp-required-field-label">(required)</span> </legend>


                    <input id="field_133" name="contact[cellphone]" type="tel" value="<?php echo $cellphone; ?>" aria-required="true" required="" placeholder="Cell Phone *" aria-labelledby="contact[cellphone]-1" aria-describedby="contact[cellphone]-3">
                </fieldset>
            </div>


            <div class="editfield field_377 field_birthday optional-field visibility-public field_type_birthdate">
                <fieldset class="">


                    <legend>
                        Birthday </legend>

                    <div class="input-options datebox-selects dayDropDownFields">


                        <select id="contact[bday][month]" name="contact[bday][month]" placeholder="Birthday" class="selectMonth">
                            <option value="" selected="selected">Month</option>
                            <option value="January" <?php if ($bday_month == 'January') {
                                                        echo 'selected';
                                                    } ?>>January</option>
                            <option value="February" <?php if ($bday_month == 'February') {
                                                            echo 'selected';
                                                        } ?>>February</option>
                            <option value="March" <?php if ($bday_month == 'March') {
                                                        echo 'selected';
                                                    } ?>>March</option>
                            <option value="April" <?php if ($bday_month == 'April') {
                                                        echo 'selected';
                                                    } ?>>April</option>
                            <option value="May" <?php if ($bday_month == 'May') {
                                                    echo 'selected';
                                                } ?>>May</option>
                            <option value="June" <?php if ($bday_month == 'June') {
                                                        echo 'selected';
                                                    } ?>>June</option>
                            <option value="July" <?php if ($bday_month == 'July') {
                                                        echo 'selected';
                                                    } ?>>July</option>
                            <option value="August" <?php if ($bday_month == 'August') {
                                                        echo 'selected';
                                                    } ?>>August</option>
                            <option value="September" <?php if ($bday_month == 'September') {
                                                            echo 'selected';
                                                        } ?>>September</option>
                            <option value="October" <?php if ($bday_month == 'October') {
                                                        echo 'selected';
                                                    } ?>>October</option>
                            <option value="November" <?php if ($bday_month == 'November') {
                                                            echo 'selected';
                                                        } ?>>November</option>
                            <option value="December" <?php if ($bday_month == 'December') {
                                                            echo 'selected';
                                                        } ?>>December</option>
                        </select>
                        <select id="contact[bday][day]" name="contact[bday][day]" placeholder="Birthday" class="selectDay">
                            <option value="" selected="selected">Day</option>
                            <?php for ($i = 1; $i <= 30; $i++) {
                                $bday_day_selected = '';
                                if ($i == $bday_day) {
                                    $bday_day_selected = 'selected';
                                }

                                echo ' <option value="' . $i . '" ' . $bday_day_selected . '>' . $i . '</option>';
                            }
                            ?>

                        </select>
                        <select id="contact[bday][year]" name="contact[bday][year]" placeholder="Birthday">
                            <option value="" selected="selected">Year</option>
                            <?php for ($i = 1950; $i <= date('Y'); $i++) {
                                $bday_year_selected = '';
                                if ($i == $bday_year) {
                                    $bday_year_selected = 'selected';
                                }

                                echo ' <option value="' . $i . '" ' . $bday_year_selected . '>' . $i . '</option>';
                            }
                            ?>


                        </select>

                    </div>
                </fieldset>
            </div>



            <div class="editfield field_135 field_titles-select-all-that-apply optional-field visibility-public alt field_type_checkbox">
                <fieldset class="">


                    <legend>
                        Titles (select all that apply) </legend>

                    <div id="" class="input-options checkbox-options"><label for="field_190_1" class="option-label">
                            <?php foreach (RDH_TITLES as $key => $val) {
                                $selected_item = '';
                                if (is_array($titles) && in_array($val, $titles)) {
                                    $selected_item = 'checked';
                                }

                                echo  '<label for="field_189_' . $key . '"
                                class="option-label"><input type="checkbox" name="contact[titles][]"
                                    id="field_189_' . $key . '" value="' . $val . '" ' . $selected_item . '>' . $val . '</label>';
                            }
                            ?>

                    </div>



                </fieldset>
            </div>
            <?php
                $address_type =  isset($address['address_type']) ? $address['address_type'] : '';
                $homeselected = '';
                $apoelected = '';
                if ($address_type == 'home-office') {
                    $homeselected = "checked";
                }
                if ($address_type == 'apo-fpo') {
                    $apoelected = "checked";
                }
                $address_address =  isset($address['address']) ? $address['address'] : '';
                $address_town_city =  isset($address['town_city']) ? $address['town_city'] : '';
                $address_country =  isset($address['country']) ? $address['country'] : 'US';
                $address_apt =  isset($address['apt']) ? $address['apt'] : '';
                $address_zipcode =  isset($address['zipcode']) ? $address['zipcode'] : '';
                $address_state =  isset($address['state']) ? $address['state'] : '';


            ?>
            <div class="address-container">
                <div class="editfield required-field visibility-public field_type_radio">
                    <fieldset class="no-label">
                        <legend> Mailing Address <span class="bp-required-field-label">*</span></legend>
                        <div class="input-options radio-button-options"><label for="home-office"><input type="radio" name="address[address_type]" checked id="home-office" value="home-office" <?php echo $homeselected; ?>>Home/Office</label><label for="apo-fpo" class="option-label"><input type="radio" name="address[address_type]" id="apo-fpo" value="apo-fpo" <?php echo $apoelected; ?>>APO/FPO</label></div>
                    </fieldset>
                </div>
                <div class="editfield degree_title addr">
                                                    <legend>Country</legend> <select data-selected="<?php echo  $address_country; ?>" name="address[country]" id="acountry"class="acountry input-text wfacp-form-control pac-target-input"> </select>
                                                </div>
                <div class="editfield degree_title addr">
                    <legend>Start typing your address...*</legend><input type="text" required class="input-text wfacp-form-control pac-target-input" name="address[address]" id="address-autocomp" placeholder="Start typing your address..." value="<?php echo  $address_address; ?>" autocomplete="off">
                </div>
                <div class="editfield degree_title towncity">
                    <legend>Town/City*</legend><input type="text" required class="input-text wfacp-form-control pac-target-input" name="address[town_city]" id="address-city" placeholder="House Number and Street Name" value="<?php echo  $address_town_city; ?>" autocomplete="off">
                </div>
                <div class="editfield degree_title apt">
                    <legend>Apartment, suite, unit etc.</legend><input type="text" name="address[apt]" value="<?php echo $address_apt; ?>" placeholder="Apartment, suite, unit etc. (optional)" />
                </div>
                <div class="editfield degree_title">
                    <legend>Zipcode*</legend><input type="text" required id="address-zip" name="address[zipcode]" value="<?php echo $address_zipcode; ?>" required placeholder="zipcode*" />
                </div>
                <div class="editfield degree_title">
                    <legend>State*</legend><select name="address[state]" required id="address-rep-state" data-selected="<?php echo $address_state;?>"><?php echo str_replace('<option value="' . $address_state . '">', '<option value="' . $address_state . '" selected>', $states_String); ?></select>
                </div>
            </div>
            <input type="hidden" name="action" value="partial_submit_form_profile">






            </div>
            <div class="professional-info-section tab" id="professional_info">
                <h2 class="section-headings">Professional Information</h2>


                <div class="field_wrapper liscence">
                    <div class="header_wrapper_mbt">
                        <h3>Which state(s) are you licensed to practice?</h3>
                    </div>

                    <?php if (is_array($liscence) && count($liscence) > 0) {

                        for ($i = 0; $i < count($liscence['state']); $i++) {
                            $classHideCross = '';
                            if ($i == 0) {
                                $classHideCross = 'removeCross';
                            }
                            echo '<div class="wrapperFieldOption eperience-wrapperFieldOption ' . $classHideCross . '"> <a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a>';
                            $replace_state = str_replace('<option value="' . $liscence['state'][$i] . '">', '<option value="' . $liscence["state"][$i] . '" selected>', $states_liscence);
                            $replace_liscence_number = str_replace('value="" placeholder="License*"', 'value="' . $liscence["liscence"][$i] . '" placeholder="License*"', $replace_state);
                            $replace_liscence_number = str_replace('repeater_state[state][0]', 'repeater_state[state][' . $i . ']', $replace_liscence_number);
                            $replace_liscence_number = str_replace('repeater_state[country][0]', 'repeater_state[country][' . $i . ']', $replace_liscence_number);
                            $replace_liscence_number = str_replace('repeater_state[liscence][0]', 'repeater_state[liscence][' . $i . ']', $replace_liscence_number);
                            echo $replace_liscence_number;
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="wrapperFieldOption eperience-wrapperFieldOption">';
                        echo $states_liscence;
                        echo '</div>';
                    }
                    ?>


                    <div class="addmoreButtonbottom">
                        <div class="addMoreButton">
                            <a href="javascript:void(0);" class="add_button font-mont" title="Add field">
                                <i class="plus-icon-svg" aria-hidden="true"></i> add another state</a>
                        </div>
                    </div>
                </div>


                <div class="editfield field_4 field_bio optional-field visibility-public alt field_type_wp-biography">
                    <fieldset class="yes-label">
                        <label for="field_4" class="display-brief-info">Brief Introduction</label>
                        <textarea id="bio-description" name="biref" cols="40" rows="5" placeholder="Bio" class="valid bio-description" aria-invalid="false" maxlength="500"><?php echo $biref; ?></textarea>
                        <p class="showCharactor">Characters Remaining <span id="characters-counter">500</span></p>
                    </fieldset>
                </div>


                <div class="editfield field_202 field_how-many-years-have-you-been-a-practicing-hygienist optional-field visibility-public alt field_type_number_minmax">
                    <fieldset class="">
                        <?php
                        $year_practicing =  isset($professional['year_practicing']) ? $professional['year_practicing'] : '';
                        ?>
                        <legend id="field_202-1">
                            What year did you first start practicing hygiene? </legend>
                        <select name="professional[year_practicing]" class="repeater_state_state" id="field_202" placeholder="How many years have you been a practicing hygienist?">
                            <?php
                            echo '<option value="0">How many years have you been a practicing hygienist?</option>';
                            for ($year_practicing_i = 1990; $year_practicing_i  <= date('Y'); $year_practicing_i++) {
                                if ($year_practicing == $year_practicing_i) {
                                    echo '<option value="' . $year_practicing . '" selected="">' . $year_practicing . '</option>';
                                } else {
                                    echo '<option value="' . $year_practicing_i . '">' . $year_practicing_i . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php
                        /*
                        ?>
                        <input id="field_202" name="professional[year_practicing]" type="number" value="<?php echo $year_practicing; ?>" min="0" max="100" placeholder="How many years have you been a practicing hygienist?">
<?php */ ?>
                    </fieldset>
                </div>


                <div class="editfield field_203 field_do-you-practice-in-office optional-field visibility-public field_type_radio">
                    <fieldset class="no-label">


                        <legend>
                            Do you practice in-office? </legend>

                        <?php
                        $year_practicing =  isset($professional['practice']) ? $professional['practice'] : '';
                        ?>

                        <div id="field_203" class="input-options radio-button-options">
                            <?php foreach (RDH_PRACTICE as $key => $val) {
                                $practice_checked = '';
                                if ($val == $year_practicing) {
                                    $practice_checked = 'checked';
                                }
                                echo ' <label for="option_373_' . $key . '"
                                    class="option-label"><input type="radio" name="professional[practice]"
                                        id="option_373_' . $key . '" value="' . $val . '" ' . $practice_checked . '>' . $val . '</label>';
                            }
                            ?>
                        </div>

                    </fieldset>
                </div>


                <div class="editfield field_208 field_do-you-attend-professional-conferences optional-field visibility-public alt field_type_radio">
                    <fieldset class="no-label">


                        <legend>
                            Do you attend professional conferences? </legend>
                        <?php
                        $conference_attend =  isset($professional['conference_attend']) ? $professional['conference_attend'] : '';
                        ?>



                        <div id="field_208" class="input-options radio-button-options">
                            <?php foreach (CONFERENCE_ATTEND as $key => $val) {
                                $conference_attend_check = '';
                                if ($val == $conference_attend) {
                                    $conference_attend_check = 'checked';
                                }
                                echo '<label for="option_353_' . $key . '"
                                    class="option-label"><input type="radio" name="professional[conference_attend]"
                                        id="option_353_' . $key . '" value="' . $val . '" ' . $conference_attend_check . '>' . $val . '</label>';
                            }
                            ?>

                        </div>



                    </fieldset>
                </div>


                <div class="editfield field_365 field_please-check-any-of-the-boxes-that-apply-to-you required-field visibility-public field_type_checkbox">
                    <fieldset class="">


                        <legend>
                            Please check any of the boxes that apply to you <span class="bp-required-field-label">(required)</span> </legend>



                        <div id="field_365" class="input-options checkbox-options">
                            <?php
                            $behaviour_arr_existing =  isset($professional['behaviour']) ? $professional['behaviour'] : array();
                            foreach (RDH_BEHAVIOUR as $key => $val) {
                                $behaviour_check = '';
                                if (in_array($val, $behaviour_arr_existing)) {
                                    $behaviour_check = 'checked';
                                }
                                echo '<label for="field_366_' . $key . '"
                                class="option-label"><input type="checkbox" name="professional[behaviour][]"
                                    id="field_366_' . $key . '" value="' . $val . '" ' . $behaviour_check . '>' . $val . '</label>';
                            }
                            ?>

                        </div>


                    </fieldset>
                </div>


                <div class="editfield field_339 field_areas-of-interest-select-all-that-apply optional-field visibility-public alt field_type_checkbox">
                    <fieldset class="">


                        <legend>
                            Areas of interest (select all that apply) </legend>



                        <div id="field_339" class="input-options checkbox-options">
                            <?php
                            $interest_arr_existing =  isset($professional['interest']) ? $professional['interest'] : array();
                            foreach (RDH_INTERESTS as $key => $val) {
                                $interest_check = '';
                                if (in_array(trim($val), $interest_arr_existing)) {
                                    $interest_check = 'checked';
                                }
                                echo '<label for="field_358_' . $key . '"
                                class="option-label"><input type="checkbox" name="professional[interest][]"
                                    id="field_358_' . $key . '" value="' . $val . '" ' . $interest_check . '>' . $val . '</label>';
                            }
                            ?></div>



                    </fieldset>
                </div>
                <div class="education-experiecce-wrapper">
                    <div class="field_wrapper education">
                        <div class="header_wrapper_mbt">
                            <h3>Education</h3>
                        </div>


                        <?php if (is_array($education) && count($education) > 0) {

                            for ($i = 0; $i < count($education['school']); $i++) {
                                $classHideCross = '';
                                if ($i == 0) {
                                    $classHideCross = 'removeCross';
                                }
                                echo '<div class="wrapperFieldOption edu-wrapperFieldOption ' . $classHideCross . '"> <a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a>';
                                $replace_school = str_replace('name="repeater_degree[school][0]" value=""', 'name="repeater_degree[school][' . $i . ']" value="' . $education["school"][$i] . '"', $degree_string);
                                $replace_digree_title = str_replace('name="repeater_degree[degree_title][0]" value=""', 'name="repeater_degree[degree_title][' . $i . ']" value="' . $education["degree_title"][$i] . '"', $replace_school);
                                $replace_grad_date = str_replace('name="repeater_degree[grad_date][0]" value=""', 'name="repeater_degree[grad_date][' . $i . ']" value="' . $education["grad_date"][$i] . '"', $replace_digree_title);

                                echo $replace_grad_date;
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="wrapperFieldOption edu-wrapperFieldOption">';
                            echo $degree_string;
                            echo '</div>';
                        }
                        ?>


                        <div class="addmoreButtonbottom">
                            <div class="addMoreButton">
                                <a href="javascript:void(0);" class="add_button font-mont" title="Add field"><i class="plus-icon-svg" aria-hidden="true"></i> Add more education</a>
                            </div>
                        </div>

                    </div>

                    <div class="field_wrapper experience">
                        <div class="header_wrapper_mbt">
                            <h3>Experience</h3>

                        </div>

                        <?php if (is_array($experience) && count($experience) > 0) {

                            for ($i = 0; $i < count($experience['exp_title']); $i++) {
                                $classHideCross = '';
                                if ($i == 0) {
                                    $classHideCross = 'removeCross';
                                }
                                if(!isset($experience["country"][$i])) {
                                    $experience["country"][$i] = 'US'; 
                                }
                                if($experience["country"][$i] =='') {
                                    $experience["country"][$i] = 'US';
                                }
                                echo '<div class="wrapperFieldOption eperience-wrapperFieldOption ' . $classHideCross . '"> <a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a>';
                                $replace_exp_title = str_replace('name="repeater_exp[exp_title][]" value=""', 'name="repeater_exp[exp_title][]" value="' . $experience["exp_title"][$i] . '"', $exp_string);
                                $replace_exp_company = str_replace('name="repeater_exp[company][]" value=""', 'name="repeater_exp[company][]" value="' . $experience["company"][$i] . '"', $replace_exp_title);
                                $replace_exp_employment_type = str_replace('<option value="' . $experience["exp_employment_type"][$i] . '">', '<option value="' . $experience["exp_employment_type"][$i] . '" selected>', $replace_exp_company);
                                $replace_exp_city = str_replace('name="repeater_exp[city][]" value=""', 'name="repeater_exp[city][]" value="' . $experience["city"][$i] . '"', $replace_exp_employment_type);
                                $replace_exp_employment_country = str_replace('<option value="' . $experience["country"][$i] . '">', '<option value="' . $experience["country"][$i] . '" selected>', $replace_exp_city);
                                //$replace_exp_employment_state = str_replace('<option value="' . $experience["state"][$i] . '">', '<option value="' . $experience["state"][$i] . '" selected>', $replace_exp_employment_country);
                                $replace_exp_employment_state = str_replace('name="repeater_exp[state][]"','name="repeater_exp[state][]" data-selected="'.$experience["state"][$i].'"', $replace_exp_employment_country);
                                $replace_exp_employment_start_month = str_replace('<option ms="" value="' . $experience["start_month"][$i] . '">', '<option value="' . $experience["start_month"][$i] . '" selected>', $replace_exp_employment_state);
                                $replace_exp_employment_start_year = str_replace('<option ys="" value="' . $experience["start_year"][$i] . '">', '<option value="' . $experience["start_year"][$i] . '" selected>', $replace_exp_employment_start_month);
                                $replace_exp_employment_end_month = str_replace('<option me="" value="' . $experience["end_month"][$i] . '">', '<option value="' . $experience["end_month"][$i] . '" selected>', $replace_exp_employment_start_year);
                                $replace_exp_employment_end_year = str_replace('<option ye="" value="' . $experience["end_year"][$i] . '">', '<option value="' . $experience["end_year"][$i] . '" selected>', $replace_exp_employment_end_month);
                                if ($experience["end_month"][$i] != '') {
                                    $replace_exp_employment_end_year = str_replace('name="repeater_exp[end_month][]"', 'name="repeater_exp[end_month][]" required', $replace_exp_employment_end_year);
                                    $replace_exp_employment_end_year = str_replace('name="repeater_exp[end_year][]"', 'name="repeater_exp[end_year][]" required', $replace_exp_employment_end_year);
                                }
                                if ($experience["end_year"][$i] != '') {
                                    $replace_exp_employment_end_year_rep = str_replace('checked name="repeater_exp[currently_working][]', 'name="repeater_exp[currently_working][]"', $replace_exp_employment_end_year);
                                    echo $replace_exp_employment_end_year_rep;
                                } else {
                                    echo $replace_exp_employment_end_year;
                                }
                                echo '</div>';


                                // echo $replace_grad_date;
                            }
                        } else {
                            echo '<div class="wrapperFieldOption eperience-wrapperFieldOption">';
                            echo $exp_string;
                            echo '</div>';
                        } ?>
                        <div class="addmoreButtonbottom">
                            <div class="addMoreButton">
                                <a href="javascript:void(0);" class="add_button font-mont" title="Add field"><i class="plus-icon-svg" aria-hidden="true"></i> Add work position</a>
                            </div>
                        </div>
                    </div>


                </div>
                <input type="hidden" name="action" value="partial_submit_form_profile">


                <div class="embeded-video-container">

                    <div class="toggleButtonVideoToShowFrontpage">
                        <h4>Display your introductory video on your public profile page</h4>
                        <div class="toggleButtonVideoToShowFrontpageChild">
                            <div class="form-group-radio-custom">
                                <input type="radio" id="rdh_video_toggle_show" name="rdh_video_url" value="show" <?php if ($embed_url == 'show') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                <label for="rdh_video_toggle_show">Show</label><br>
                            </div>
                            <div class="form-group-radio-custom">
                                <input type="radio" id="rdh_video_toggle_hide" name="rdh_video_url" value="hide" <?php if ($embed_url == 'hide') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                <label for="rdh_video_toggle_hide">Hide</label>
                            </div>
                        </div>
                    </div>

                    <?php if ($rdhc_video_ != '') { ?>
                        <div class="embeded-video-box">
                            <div class="embeded-video-box-container-inner">
                                <?php echo $rdhc_video_; ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>


                <div class="toggle-button-for-embed-video" style="display:none ;">
                    <a class="toggleButton btn" href="javascript:;" id="showdDefault">
                        <span class="defaultShow">hide video intro</span>
                        <span class="caret"></span>
                    </a>
                    <a class="toggleButton btn" href="javascript:;" id="showdeAfter">
                        <span class="afterShow">Show video intro</span>
                        <span class="caret"></span>
                    </a>

                </div>
            </div>



        </div>



    </div>
    <div class="social-info-section tab" id="social_media_info">
        <h2 class="section-headings">Social media Information</h2>
        <div class="editfield  field_linkedin optional-field visibility-public field_type_url">
            <fieldset class="">
                <legend id="social_linkedin">
                    Linkedin </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="linkedin.com/in/" type="text" disabled>
                    <input id="social[linkedin]" name="social[linkedin]" type="text" inputmode="url" value="<?php echo @$social['linkedin']; ?>" placeholder="Linkedin" aria-labelledby="social_linkedin" aria-describedby="social[linkedin]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield  field_instagram optional-field visibility-public alt field_type_url">
            <fieldset class="">
                <legend id="social_instagram">
                    Instagram </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="instagram.com/" type="text" disabled>
                    <input id="social[instagram]" name="social[instagram]" type="text" inputmode="url" value="<?php echo @$social['instagram']; ?>" placeholder="" aria-labelledby="social_instagram" aria-describedby="social[instagram]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield field_youtube optional-field visibility-public field_type_url">
            <fieldset class="">
                <legend id="social_youtube">
                    Youtube </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="youtube.com/" type="text" disabled>
                    <input id="social[youtube]" name="social[youtube]" type="text" inputmode="url" value="<?php echo @$social['youtube']; ?>" placeholder="Youtube" aria-labelledby="social_youtube" aria-describedby="social[youtube]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield field_tiktok optional-field visibility-public alt field_type_url">
            <fieldset class="">
                <legend id="social_tiktok">
                    Tiktok </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="tiktok.com/@" type="text" disabled>
                    <input id="social[tiktok]" name="social[tiktok]" type="text" inputmode="url" value="<?php echo @$social['tiktok']; ?>" placeholder="Tiktok" aria-labelledby="social_tiktok" aria-describedby="social[tiktok]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield  field_twitter optional-field visibility-public field_type_url">
            <fieldset class="">
                <legend id="social_twitter">
                    Twitter </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="twitter.com/@" type="text" disabled>
                    <input id="social[twitter]" name="social[twitter]" type="text" inputmode="url" value="<?php echo @$social['twitter']; ?>" placeholder="" aria-labelledby="social_twitter" aria-describedby="social[twitter]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield  field_facebook optional-field visibility-public alt field_type_url">
            <fieldset class="">
                <legend id="social_facebook">
                    Facebook </legend>
                <div class="socialFieldsParent">
                    <input class="socialHandlerText" value="facebook.com/" type="text" disabled>
                    <input id="social[facebook]" name="social[facebook]" type="text" inputmode="url" value="<?php echo @$social['facebook']; ?>" placeholder="Facebook" aria-labelledby="social_facebook" aria-describedby="social[facebook]-3" class="valid">
                </div>
            </fieldset>
        </div>
        <div class="editfield field_blog optional-field visibility-public field_type_url">
            <fieldset class="">
                <legend id="social_blog">
                    Blog </legend>

                <input id="social[blog]" name="social[blog]" type="text" inputmode="url" value="<?php echo @$social['blog']; ?>" placeholder="Blog" aria-labelledby="social_blog" aria-describedby="social[blog]-3" class="valid">
            </fieldset>
        </div>
        <input type="hidden" name="action" value="partial_submit_form_profile">
        <div class="socialDescriptionIndicagtor">
            <p class="description indicator-hint edditedCustom"><span style="color: #000;font-weight: bold;">Note:</span> For all social media accounts simply type
                your username. For your blog please type the complete URL.</p>
        </div>

    </div>

<?php if ($field_value != '') {?>
    <div class="my-publication-section tab" id="my_publication_info">
       
        <h2 class="section-headings">
            <div class="rowDiv">
                <div class="col-left">
                    My Publication
                </div>
                <div class="col-right">
                    <a href="javascript:;"   class="btn button modal-toggle"> <i class="fa fa-link" aria-hidden="true"></i> add publication</a>
                </div>
            </div>
        
        </h2>
        <div class="loader-article"></div>
       
        <div class="card-list">

        </div>
    </div>
    <?php } ?>


    <?php bp_nouveau_xprofile_hook('after', 'field_content'); ?>

    <input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
    <?php if ($field_value == '') {
                    bp_nouveau_submit_button('member-profile-edit');
                } else { ?>
        <div class="custom-btn-container">
            <a class="customsubmit button btn">Save </a>
        </div>
    <?php } ?>
    
    </div>

    </div>
    </form>
    <style>
        .bind .profile-edit .message-processing {
            display: none;
        }
    </style>
    <script>
        $('ul.button-tabs.button-nav li.current').prevAll('li').addClass('stepsDone')

        function submit_next_button() {

            jQuery('#profile-group-edit-submit')
        }
    </script>


<?php endwhile; ?>

<?php endif; ?>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBbxE-oS52upTGTzOq2r1aCnG9QkqafsVI&#038;libraries=places&#038;ver=6.0.2' id='wfacp_google_js-js'></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#signup-form').find('Input,select').each(function() {
            //jQuery(this).removeAttr('required');
        });
        jQuery('.field_states-select-all-that-apply select').select2();

        google.maps.event.addDomListener(window, 'load', function() {
            if (jQuery('.address-container').hasClass('apofpo')) {
                // return false;
            } else {
                var options = {
                            // componentRestrictions: {
                            //     country: "us"
                            // }
                };
                        var countrySelect = document.getElementById('acountry');
                        var addressInput = document.getElementById('address-autocomp');
                        var places = new google.maps.places.Autocomplete(addressInput, options);
                        places.setComponentRestrictions({ 'country': countrySelect.value });
                            countrySelect.addEventListener('change', function() {

                                // Set the country restriction based on the selected country in the dropdown
                                places.setComponentRestrictions({ 'country': countrySelect.value });
                                addressInput.value = '';
                            });
                google.maps.event.addListener(places, 'place_changed', function() {
                    var place = places.getPlace();
                    var address = place.formatted_address;
                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    var latlng = new google.maps.LatLng(latitude, longitude);
                    var geocoder = geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                               
                                var address = results[0].formatted_address;
                                var pin = results[0].address_components[results[0]
                                    .address_components.length - 2].short_name;
                                var country = results[0].address_components[results[0]
                                    .address_components.length - 2].long_name;
                                var state = results[0].address_components[results[0]
                                    .address_components.length - 3].short_name;
                                var state_long = results[0].address_components[results[0]
                                    .address_components.length - 3].long_name;
                                var city = results[0].address_components[results[0]
                                    .address_components.length - 4].long_name;
                                            City_updated= results[0].address_components[results[0]
                                    .address_components.length - 5].long_name;
                                if (pin == 'US') {
                                    pin = results[0].address_components[results[0]
                                        .address_components.length - 1].short_name;

                                }

                                if (state == 'US') {
                                    state = results[0].address_components[results[0]
                                        .address_components.length - 4].short_name;
                                    state_long = results[0].address_components[results[0]
                                        .address_components.length - 4].long_name;
                                }

                                if (state_long == city) {

                                    var city = results[0].address_components[results[0]
                                        .address_components.length - 7].long_name;
                                }
                                        if(city.length>City_updated.length){
                                    city = City_updated;
                                }
                                        // console.log('ddd');
                                        // console.log(address);
                                        ///  document.getElementById('address-autocomp').value = address;
                                document.getElementById('address-rep-state').value =
                                    state;
                                document.getElementById('address-city').value = city;
                                document.getElementById('address-zip').value = pin;

                                jQuery('#address-rep-state').removeClass('error');
                                jQuery('#address-rep-state').parents('.editfield').find('label').text('');

                                jQuery('#address-city').removeClass('error');
                                jQuery('#address-city').parents('.editfield').find('label').text('');

                                jQuery('#address-zip').removeClass('error');
                                jQuery('#address-zip').parents('.editfield').find('label').text('');



                            }
                        }
                    });
                });
            }
        });

    });
</script>
<script type="text/javascript">
    function update_new_added_element_ids(obj) {
        classnae = '.' + obj;
        lastchild = jQuery(classnae).find('.wrapperFieldOption').last();
        jQuery(lastchild).addClass('jejejej');
        jQuery(lastchild).find('input,select').each(function() {
            var number = 1 + Math.floor(Math.random() * 89801);
            id_dynamic = 'id-' + number;
            jQuery(this).attr('id', id_dynamic);
            jQuery(this).rules("add", {
                required: true,
            });
        });

    }
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input fiseld wrapper
        var focvused = 'onfocus="(this.type=\'date\')" onblur="(this.type=\'text\')"';
        var fieldHTMLdegree =
            '<div style="clear:both" class="wrapperFieldOption edu-wrapperFieldOption"><a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a><?php echo preg_replace("/\r|\n/", "", $degree_string); ?></div>'; //New input field html 
        var fieldHTMLexpereince =
            '<div style="clear:both" class="wrapperFieldOption eperience-wrapperFieldOption"><a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a><?php echo preg_replace("/\r|\n/", "", $exp_string); ?></div>';
        var fieldHTMLliscence =
            '<div style="clear:both" class="wrapperFieldOption eperience-wrapperFieldOption"><a href="javascript:void(0);" class="remove_button minusIcon-flex"><i class="minusIcon-svg" aria-hidden="true"></i> Remove</a><?php echo preg_replace("/\r|\n/", "", $states_liscence); ?></div>';

        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter

                if ($(this).parents('.field_wrapper').hasClass('education')) {
                    $(this).parents('.field_wrapper').append(fieldHTMLdegree); //Add field html
                    update_new_added_element_ids('education');
                    rearrange_element_name('education');

                }
                if ($(this).parents('.field_wrapper').hasClass('experience')) {
                    $(this).parents('.field_wrapper').append(fieldHTMLexpereince); //Add field html
                    update_new_added_element_ids('experience');
                    update_country_based_states();
                    jQuery(this).parents('.eperience-wrapperFieldOption').find('.ccountry').trigger('change');
                    jQuery(this).parents('.eperience-wrapperFieldOption').find('.ccountry').change();
                    setTimeout(function(){jQuery('.eperience-wrapperFieldOption').last().find('.ccountry').trigger('change'); }, 500);
                    
                 //   update_Data_accordingly(jQuery(this).parent('.eperience-wrapperFieldOption').find('.ccountry').trigger('change'));

                }
                if ($(this).parents('.field_wrapper').hasClass('liscence')) {
                    $(this).parents('.field_wrapper').append(fieldHTMLliscence); //Add field html
                    update_new_added_element_ids('liscence');
                    rearrange_element_name('liscence');
                }

            }
        });

        //Once remove button is clicked
        $('.field_wrapper').on('click', '.remove_button', function(e) {
            if ($(this).parents('.field_wrapper').hasClass('liscence')) {
                var classEle = 'liscence';
            }
            if ($(this).parents('.field_wrapper').hasClass('education')) {
                var classEle = 'education';
            }
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter

            rearrange_element_name(classEle);


        });
    });
    $("#profile-edit-form").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
    jQuery(document).ready(function() {
        // jQuery('#field_273').val(getUrlParameter('referral_code'));
    });
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };


    //-----for floating labels
    jQuery(document.body).on("focus", ".standard-form input", function() {
        jQuery(this).parents(".editfield").addClass("anim-wrap");
    });
    jQuery(document.body).on("focusout", ".standard-form input", function() {
        // console.log(jQuery(this).val());
        var currentVal = jQuery(this).val();
        if (currentVal.length <= 0) {
            var t = jQuery(this).parents(".editfield");
            t.removeClass("anim-wrap");
        }
    });
    jQuery(document.body).on("keyup", ".standard-form input", function() {
        var a = jQuery(this).parents(".editfield");
        a.addClass("anim-wrap");
    }), jQuery(document.body).on("change", ".standard-form input", function() {

        var a = jQuery(this).find(".input-radio");
        a.length > 0 ? a.is(":checked").length > 0 ? jQuery(this).parents(".editfield").addClass("anim-wrap") :
            jQuery(this).parents(".editfield").removeClass("anim-wrap") : null != jQuery(this).val() && "" !=
            jQuery(this).val() ? "" !== jQuery(this).val() && (jQuery(this).parent().siblings(
                ".wfacp_input_error_msg").hide(), jQuery(this).parents(".editfield").addClass("anim-wrap")) :
            jQuery(this).parents(".editfield").removeClass("anim-wrap")
    });
    var apo_addressValue = '';
    var apo_text2 = 'Enter organization name if applicable';
    home_text2 = 'Apartment, suite, unit etc. (optional)';

    var apo_text1 = 'APO/FPO Address *';
    home_text1 = 'Start typing your address... *';
    home_text_billing1 = 'Apt Number/Company';
    jQuery(document).on('change', 'input[name="address[address_type]"]', function() {
        armyAddresses(true);

    });

    function armyAddresses(set_val = false) {
        apo_addressValue = $("input[name='address[address_type]']:checked").val();
        if (apo_addressValue == 'apo-fpo') {
            jQuery('.address-container').addClass('apofpo');
        } else {
            jQuery('.address-container').removeClass('apofpo');

        }
        shippping_address_fields_update(set_val);
        //billing_address_fields_update(set_val);
    }

    function shippping_address_fields_update(set_val) {
        apo_addressValue = $("input[name='address[address_type]']:checked").val();
        if (apo_addressValue == 'apo-fpo') {
            jQuery('.apt legend').text(apo_text2);
            jQuery('.addr legend').text(apo_text1);
            jQuery(document).find('#address-rep-state option').each(function() {
                if (jQuery(this).val() != 'AA' && jQuery(this).val() != 'AE' && jQuery(this).val() != 'AP') {
                    jQuery(this).attr('disabled', 'disabled');
                }
            });
            if (set_val) {
                $("#address-rep-state").val("AA").change();
            }
        } else {
            jQuery('.addr legend').text(home_text1);
            jQuery('.apt legend').text(home_text_billing1);

            jQuery(document).find('#address-rep-state option').each(function() {
                jQuery(this).removeAttr('disabled');

                jQuery(this).show();
                if (set_val) {
                    //$('#shipping_state').val(jQuery('#shipping_state').find('option:first-child').val())
                }
            });
            $("#address-rep-state").val("").change();
            //$("#shipping_state").select2("destroy");
        }
    }
    jQuery(document).on('change', '.currently_Work', function() {
        if($(this).prop("checked") == true){
            jQuery(this).parent().parent().find('.hide-checked select').removeAttr('required');
            jQuery(this).parent().parent().find('.hide-checked select').val('');
            jQuery(this).parent().parent().find('.hide-checked select').removeClass('error');
            jQuery(this).parent().parent().find('.hide-checked select').removeAttr('aria-invalid');


        } else {
            jQuery(this).parent().parent().find('.hide-checked select').attr('required', "required");
            jQuery(this).parent().parent().find('.hide-checked select').val('');
            jQuery(this).parent().parent().find('.hide-checked select').addClass('error');
            jQuery(this).parent().parent().find('.hide-checked select').attr('aria-invalid', 'true');

        }
    });
    jQuery(document).ready(function() {
          jQuery('.currently_Work').each(function(){
            if($(this).prop("checked") == true){
                $(this).trigger('change');
                $(this).prop('checked', true);
            }
            // if(this.checked){
            //     jQuery(this).trigger();
            //     console.log('changed');
            // }
          });
    });


    $(document).ready(function() {
        var maxCharacters = 500;
        document.getElementById('bio-description').onkeyup = function() {
            document.getElementById('characters-counter').innerHTML = (maxCharacters - this.value.length);
        };

        jQuery('.referal_added input').prop("readonly", true);
        const url = window.location.href;
        const result3 = url.replace("?updated=true", "")
        window.history.pushState({}, '', result3);
    });
    $('.customTabs.tabsDesktop li a').on('click', function() {
        $('.customTabs.tabsDesktop li a.active').removeClass('active');
        $(this).addClass('active');
        jQuery('.custom-btn-container').css("display","block");
    });


    $('.customTabs.tabsDesktop li #pills-contact-tab').on('click', function() {
        $('.tab.active').removeClass('active');
        $(".contact-info-section.tab").addClass('active');
    });

    $('.customTabs.tabsDesktop li #pills-professional-tab').on('click', function() {
        $(".contact-info-section.tab").removeClass('active');
        $(".professional-info-section.tab").addClass('active');
        $(".social-info-section.tab").removeClass('active');
        $(".my-publication-section.tab").removeClass('active');

    });

    $('.customTabs.tabsDesktop li #pills-social-tab').on('click', function() {
        $(".contact-info-section.tab").removeClass('active');
        $(".professional-info-section.tab").removeClass('active');
        $(".my-publication-section.tab").removeClass('active');
        $(".social-info-section.tab").addClass('active');

    });

    $('.customTabs.tabsDesktop li #pills-my-publication').on('click', function() {
        $(".contact-info-section.tab").removeClass('active');
        $(".professional-info-section.tab").removeClass('active');
        $(".social-info-section.tab").removeClass('active');
        $(".my-publication-section.tab").addClass('active');
        jQuery('.custom-btn-container').css("display","none");
    });


    //    add body class on RDH value     
    if ($(".sidebarNavigationBuddyPress ").hasClass("tabscontainer")) {
        // console.log('bodyactiveclass');
        $("body").addClass('profileContainerfullLayout');
    }
    jQuery(document).on('click', '.customsubmit', function() {
        err = false;
        setTimeout(function() {
            jQuery('.tab.active').find('select, textarea, input').each(function() {

                if (jQuery(this).hasClass('error')) {
                    err = true;
                    jQuery.scrollTo(jQuery('.error'), 500);
                    return false;
                }

            });

            if (!err) {
                data_Ser = $('.tab.active').find('select, textarea, input').serialize();
                jQuery('.loading-mbt').show();


                $.ajax({
                    type: "POST",
                    //dataType : "json",
                    url: "/wp-admin/admin-ajax.php",
                    data: data_Ser,
                    success: function(response) {

                        // if(response == 'yes') {
                        jQuery('.loading-mbt').hide();
                        jQuery.scrollTo(jQuery('.profile.edit'), 500);
                        jQuery('.ajax-res-rdh').html('<div class="alert alert-success">Form saved.</div>');

                        // }

                    }
                });
            }
        }, 200);



    });
    jQuery(document).ready(function() {
        jQuery('.tabscontainer').css('opacity', '1');
        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            hashed_id = '#' + hash;
            jQuery(hashed_id).trigger('click');
            jQuery('.tabscontainer').css('opacity', '1');
            // hash found
        } else {
            // No hash found
        }
    });


    setTimeout(function() {
        jQuery('body').on('click', '.toggle-button-for-embed-video #showdDefault', function() {
            jQuery('body').find(".embeded-video-container").addClass("open_widget_content_video");
            jQuery('body').find(".embeded-video-box").css('display', "none");

        });
        jQuery('body').on('click', '.toggle-button-for-embed-video #showdeAfter', function() {
            jQuery('body').find(".embeded-video-container").removeClass("open_widget_content_video");
            jQuery('body').find(".embeded-video-box").css('display', "block")
        });

    }, 200);

    jQuery(document).on('change', '.mbtenddate', function() {
        endyear_val = jQuery(this).val();
        jQuery(this).parents('.eperience-wrapperFieldOption').find('.mbtstartdate').find('option').each(function() {
            option_val = jQuery(this).val();
            if (option_val > endyear_val) {
                jQuery(this).prop("disabled", true);
            } else {
                jQuery(this).prop("disabled", false);
            }
        });
    });
    jQuery(document).on('change', '.mbtstartdate', function() {
        endyear_val = jQuery(this).val();
        jQuery(this).parents('.eperience-wrapperFieldOption').find('.mbtenddate').find('option').each(function() {
            option_val = jQuery(this).val();
            if (option_val < endyear_val) {
                jQuery(this).prop("disabled", true);
            } else {
                jQuery(this).prop("disabled", false);
            }
        });

    });

    jQuery(document).on('click', '.mbtenddate', function() {
        endyear_val = jQuery(this).parents('.eperience-wrapperFieldOption').find('.mbtstartdate').val();
        jQuery(this).parents('.eperience-wrapperFieldOption').find('.mbtenddate').find('option').each(function() {
            option_val = jQuery(this).val();
            if (option_val < endyear_val) {
                jQuery(this).prop("disabled", true);
            } else {
                jQuery(this).prop("disabled", false);
            }
        });

    });
</script>
<script src="<?php echo get_stylesheet_directory_uri();?>/assets/js/country-states.js"></script>
<script>
     var user_country_code ='US';
    jQuery(document).ready(function(){
        update_country_based_states('no');
            jQuery('.ccountry').each(function(){
                selected_Value = jQuery(this).val();
                if(selected_Value!=''){
                    user_country_code = selected_Value;
                }
                else{
                    user_country_code = 'US';
                }
                update_Data_accordingly(jQuery(this).parents('.eperience-wrapperFieldOption'));
            });
            address_Country = jQuery('#acountry').val();
            if(address_Country =='') {
                address_Country ='US';
            }
        states = country_and_states.states[address_Country];
        option = '';
        selected_state =jQuery('#address-rep-state').attr('data-selected')
        $.each(states, function (key, data) {
            let selected = (data.code == selected_state) ? ' selected' : '';
        option += '<option value="'+data.code+'" '+selected+'>'+data.name+'</option>';
        });
        jQuery('#address-rep-state').html(option);
    });
    function update_Data_accordingly(objj) {
        states = country_and_states.states[user_country_code];
        selected_state = objj.find('.ccstate').attr('data-selected');
        option = '';
        $.each(states, function (key, data) {
            
            let selected = (data.code == selected_state) ? ' selected' : '';
        option += '<option value="'+data.code+'" '+selected+'>'+data.name+'</option>';
        });
        objj.find('.ccstate').html(option);
    }
    jQuery(document).on('change','.acountry',function(){

        country_code = jQuery(this).val();
        states = country_and_states.states[country_code];
        option = '';
        selected_state =jQuery('#address-rep-state').attr('data-selected');
        $.each(states, function (key, data) {
            let selected = (data.code == selected_state) ? ' selected' : '';
        option += '<option value="'+data.code+'">'+data.name+'</option>';
        });
        jQuery('#address-rep-state').html(option);
    });
    jQuery(document).on('change','.ccountry',function(){

country_code = jQuery(this).val();
user_country_code = country_code;
states = country_and_states.states[country_code];
option = '';
$.each(states, function (key, data) {
option += '<option value="'+data.code+'">'+data.name+'</option>';
});
jQuery(this).parents('.eperience-wrapperFieldOption').find('.ccstate').html(option);
});
    function update_country_based_states(exp='yes') {
        countires =  country_and_states.country;
        option = '<option>select country</option>';
        existing_val = jQuery('#acountry').attr('data-selected');
        selected ='';
        $.each(countires, function (key, data) {
            if(exp =='yes') {
                selected = (user_country_code == key) ? ' selected' : '';
            }
            else{
                selected = (existing_val == key) ? ' selected' : '';
            }
        option += '<option value="'+key+'"'+selected+'>'+data+'</option>';
        });
        if(exp =='yes') {
            jQuery('.ccountry').html(option);
        }
        else{
            jQuery('.acountry').html(option);
        }
    }
</script>
<Style>
    /* .removeCross .remove_button{
        display:none !important;
    } */
</style>
<Style>
    /* .removeCross .remove_button{
        display:none !important;
    } */

    .tabscontainer .tab {
        display: none;
    }

    .tabscontainer .tab.active {
        display: block;
    }
</style>

<?php
bp_nouveau_xprofile_hook('after', 'edit_content');
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
