<?php

/**
 * BuddyPress - Members/Blogs Registration forms
 *
 * @since 3.0.0
 * @version 8.0.0
 */
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
<select name="repeater_state[state][0]" class="repeater_state_state" required>
' . $states_String . '
</select>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>License Number*</legend>
<input type="text" name="repeater_state[liscence][0]" class="repeater_state_liscence" required value="" placeholder="License*"/>
</div></div>';
$degree_string = '<div class="editfield degree_title full-width-field educationTitle">
<legend>School*</legend>
<input type="text" required name="repeater_degree[school][0]" class="repeater_degree_school" value="" placeholder="Ex: Boston University*"/>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>Degree*</legend>
<input type="text" required name="repeater_degree[degree_title][0]" class="repeater_degree_title" value="" placeholder="Ex: Bacholer"/>
</div>
<div class="editfield degree_title full-width-field educationTitle">
<legend>Graduation Date*</legend>
<input type="date" required name="repeater_degree[grad_date][0]"  class="repeater_degree_date"value=""/>
</div>
';

$exp_string = '<div class="editfield degree_title"><legend>Title</legend><input type="text" name="repeater_exp[exp_title][]" value="" placeholder="Title"/></div>
<div class="editfield degree_title"><legend>Company/name</legend><input type="text" name="repeater_exp[company][]" value=""  placeholder="Company" /></div>
<div class="editfield degree_title fullWidthItem"><div class="editfield degree_title employementFIelds"><legend> Employment Type</legend><select name="repeater_exp[exp_employment_type][]"><option value="Full-time">Full-time</option><option value="Part-time">Part-time</option><option value="Self-Employed">Self-Employed</option><option value="Contract">Contract</option><option value="Internship">Internship</option><option value="Apprenticeship">Apprenticeship</option><option value="Seasonal">Seasonal</option> </select></div></div>
<div class="editfield degree_title"><legend>City</legend><input type="text" class="location" name="repeater_exp[city][]" value=""  placeholder="City" /></div>
<div class="editfield degree_title estateFIelds"><legend>State</legend><select  class="location" name="repeater_exp[state][]">' . $states_String . '</select></div>
<div class="editfield degree_title educationTitle">
<legend>Start Date</legend>							
<select name="repeater_exp[start_month][]" class="month-string-start">
' . $month_string . '
</select>
</div>
<div class="editfield degree_title educationTitle">
<legend class="startDateEmphty">Start Date*</legend>							
<select class="mbtstartdate" name="repeater_exp[start_year][]">
' . $years_string . '

</select>
</div>
<div class="editfield degree_title educationTitle hide-checked">
<legend>End Date</legend>								
<select name="repeater_exp[end_month][]" class="month-string-end">
' . $month_string . '
</select>
</div>
<div class="editfield degree_title educationTitle hide-checked">
<legend class="startDateEmphty">End Date</legend>	
<select class="mbtenddate" name="repeater_exp[end_year][]">
' . $years_string . '

</select>
</div>

<div class="editfield degree_title currentlyWorkingInthisRole"><input type="hidden" name="repeater_exp[currently_working_action][]" class="currently_working_action" ><input type="checkbox" class="currently_Work" checked name="repeater_exp[currently_working][]" /><legend class="mb-0">I am currently working in this role</legend></div>';
$ferreral_codes = REFFERAL_CODES;
$ferreral_codes = array_map('strtolower', $ferreral_codes);
if (!isset($_REQUEST['referral_code']) || $_REQUEST['referral_code'] == '' || !in_array(strtolower($_REQUEST['referral_code']), $ferreral_codes)) {
    echo '<h3 style="color:red;">referral code is Invalid</h3>';
} else {
?>

    <?php bp_nouveau_signup_hook('before', 'page'); ?>
    <div class="rdhHeader text-center">
        <div class="rdh-logo">
            <img src="https://www.smilebrilliant.com/wp-content/uploads/2022/08/RDH-connect-logo.png" alt="RDH connect" class="img-fluid">
        </div>
        <h2 class="headingRegisration">Registration Form</h2>
    </div>
    <div id="register-page" class="page register-page">
        <?php bp_nouveau_template_notices(); ?>

        <?php bp_nouveau_user_feedback(bp_get_current_signup_step()); ?>

        <form action="" name="signup_form" id="signup-form" class="standard-form signup-form clearfix" method="post" enctype="multipart/form-data" autocomplete="off">

            <div class="layout-wrap">

                <?php if ('request-details' === bp_get_current_signup_step()) : ?>

                    <?php bp_nouveau_signup_hook('before', 'account_details'); ?>

                    <div class="register-section default-profile" id="basic-details-section" style="display:none;">

                        <?php /***** Basic Account Details ******/ ?>

                        <h2 class="bp-heading"><?php //esc_html_e( 'Account Details', 'buddypress' ); 
                                                ?></h2>

                        <?php //bp_nouveau_signup_form(); 
                        ?>

                    </div><!-- #basic-details-section -->

                    <div class="register-section register-section default-profile" id="basic-details-section">

                        <?php /***** Basic Account Details ******/ ?>

                        <h2 class="bp-heading"><?php _e('Account Details', 'buddypress'); ?></h2>

                        <div class="editfield account-detail-info-username no-label">

                            <label for="signup_username"><?php _e('Username', 'buddypress'); ?><span class="bp-required-field-label"><?php _e('', 'buddypress'); ?><span class="displayNotForUserName"> (<span style="font-weight: bold;">Note:</span> user name will be visible on your public RDH profile)</span></span></label>
                            <?php

                            /**
                             * Fires and displays any member registration username errors.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_signup_username_errors'); ?>
                            <div class="input-parent-pos"><input type="text" required name="signup_username" role="presentation" id="signup_username" placeholder="Username * " value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes('username'); ?> autocomplete="off" /><span class="smooth spinner"></span></div>
                        </div>

                        <div class="editfield account-detail-info-email no-label">
                            <label for="signup_email"><?php _e('Email Address', 'buddypress'); ?><span class="bp-required-field-label"> <?php _e('(required)', 'buddypress'); ?></span></label>
                            <?php

                            /**
                             * Fires and displays any member registration email errors.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_signup_email_errors'); ?>
                            <div class="input-parent-pos">
                                <input type="email" role="presentation" required placeholder="Email * " name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes('email'); ?> autocomplete="off" />
                                <span class="smooth spinner"></span>
                            </div>
                        </div>


                        <div class="editfield account-detail-info-password no-label">
                            <label for="signup_password"><?php _e('Password', 'buddypress'); ?> <span class="bp-required-field-label"><?php _e('(required)', 'buddypress'); ?></span>
                            </label>
                            <?php

                            /**
                             * Fires and displays any member registration password errors.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_signup_password_errors'); ?>
                            <div class="coveredWrap">
                                <input type="password" required placeholder="Password * " name="signup_password" id="signup_password" value="" class="password-entry" <?php bp_form_field_attributes('password'); ?> title="The password should be at six characters long" />
                                <span toggle="#signup_password" class="fa fa-fw field-icon toggle-password fa-eye"></span>
                            </div>
                        </div>
                        <div class="editfield account-detail-info-confirm-pass no-label">
                            <label for="signup_password_confirm"><?php _e('Confirm Password', 'buddypress'); ?> <span class="bp-required-field-label"><?php _e('(required)', 'buddypress'); ?></span></label>
                            <?php

                            /**
                             * Fires and displays any member registration password confirmation errors.
                             *
                             * @since 1.1.0
                             */
                            do_action('bp_signup_password_confirm_errors'); ?>
                            <div class="coveredWrap">
                                <input required type="password" placeholder="Confirm Password * " name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm" <?php bp_form_field_attributes('password'); ?> title="The password should be at six characters long" />
                                <span toggle="#signup_password_confirm" class="fa fa-fw field-icon toggle-password fa-eye"></span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <p class="description indicator-hint edditedCustom"><span style="color: #000;font-weight: bold;">Hint:</span> The password should be at least six
                            characters long.</p>
                        <div id="pass-strength-result" class="password_strength" style="display:none;"></div>
                        <?php

                        /**
                         * Fires and displays any extra member registration details fields.
                         *
                         * @since 1.9.0
                         */
                        do_action('bp_account_details_fields'); ?>

                    </div><!-- #basic-details-section -->

                    <?php bp_nouveau_signup_hook('after', 'account_details'); ?>

                    <?php /***** Extra Profile Details ******/ ?>

                    <?php if (bp_is_active('xprofile') && bp_nouveau_has_signup_xprofile_fields(true)) : ?>

                        <?php bp_nouveau_signup_hook('before', 'signup_profile'); ?>




                        <div class="register-section extended-profile" id="profile-details-section">

                            <h2 class="bp-heading"><?php esc_html_e('Profile Details', 'buddypress'); ?></h2>

                            <?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
                            <?php while (bp_profile_groups()) : bp_the_profile_group(); ?>

                                <?php while (bp_profile_fields()) : bp_the_profile_field(); ?>

                                    <?php $classes = bp_get_field_css_class('editfield');
                                    if (str_contains($classes, 'field_first-name')) {
                                    ?>
                                        <div class="contact-info-section">
                                            <h2 class="section-headings">Contact Info</h2>


                                            <div class="editfield field_127 field_gender required-field visibility-public field_type_radio anim-wrap">
                                                <fieldset class="no-label">
                                                    <legend>
                                                        Gender <span class="bp-required-field-label">(required)</span> </legend>

                                                    <div id="contact[gender]" class="input-options radio-button-options"><label for="option_166" class="option-label"><input type="radio" name="contact[gender]" id="option_166" value="Female">Female</label><label for="option_167" class="option-label"><input type="radio" name="contact[gender]" id="option_167" value="Male">Male</label>
                                                    </div>
                                                </fieldset>
                                            </div>

                                        <?php
                                    }

                                    $no_label =  array('textbox', 'wp-textbox', 'telephone', 'email', 'radio', 'number', 'wp-biography');
                                    //	echo bp_get_the_profile_field_type();
                                    $custom_cl = '';
                                    if (in_array(bp_get_the_profile_field_type(), $no_label)) {
                                        $custom_cl = 'no-label';
                                    }
                                        ?>
                                        <div <?php echo $classes; ?>>
                                            <fieldset class="<?php echo $custom_cl; ?>">

                                                <?php

                                                $field_type = bp_xprofile_create_field_type(bp_get_the_profile_field_type());
                                                $field_type->edit_field_html();

                                                bp_nouveau_xprofile_edit_visibilty();
                                                ?>

                                            </fieldset>
                                        </div>
                                        <?php
                                        if (str_contains($classes, 'field_last-name')) {
                                        ?>

                                            <div class="editfield contact[cellphone] field_cell-phone required-field visibility-public alt field_type_telephone">
                                                <fieldset class="no-label">

                                                    <legend id="field_133-1">
                                                        Cell Phone <span class="bp-required-field-label">(required)</span> </legend>


                                                    <input id="field_133" name="contact[cellphone]" type="tel" value="" aria-required="true" required="" placeholder="Cell Phone *" aria-labelledby="contact[cellphone]-1" aria-describedby="contact[cellphone]-3">
                                                </fieldset>
                                            </div>


                                            <div class="editfield field_377 field_birthday optional-field visibility-public field_type_birthdate">
                                                <fieldset class="">


                                                    <legend>
                                                        Birthday </legend>

                                                    <div class="input-options datebox-selects dayDropDownFields">


                                                        <select id="contact[bday][month]" name="contact[bday][month]" placeholder="Birthday" class="selectMonth">
                                                            <option value="" selected="selected">Month</option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                        <select id="contact[bday][day]" name="contact[bday][day]" placeholder="Birthday" class="selectDay">
                                                            <option value="" selected="selected">Day</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                            <option value="31">31</option>
                                                        </select>
                                                        <select id="contact[bday][year]" name="contact[bday][year]" placeholder="Birthday">
                                                            <option value="" selected="selected">Year</option>
                                                            <option value="1950">1950</option>
                                                            <option value="1951">1951</option>
                                                            <option value="1952">1952</option>
                                                            <option value="1953">1953</option>
                                                            <option value="1954">1954</option>
                                                            <option value="1955">1955</option>
                                                            <option value="1956">1956</option>
                                                            <option value="1957">1957</option>
                                                            <option value="1958">1958</option>
                                                            <option value="1959">1959</option>
                                                            <option value="1960">1960</option>
                                                            <option value="1961">1961</option>
                                                            <option value="1962">1962</option>
                                                            <option value="1963">1963</option>
                                                            <option value="1964">1964</option>
                                                            <option value="1965">1965</option>
                                                            <option value="1966">1966</option>
                                                            <option value="1967">1967</option>
                                                            <option value="1968">1968</option>
                                                            <option value="1969">1969</option>
                                                            <option value="1970">1970</option>
                                                            <option value="1971">1971</option>
                                                            <option value="1972">1972</option>
                                                            <option value="1973">1973</option>
                                                            <option value="1974">1974</option>
                                                            <option value="1975">1975</option>
                                                            <option value="1976">1976</option>
                                                            <option value="1977">1977</option>
                                                            <option value="1978">1978</option>
                                                            <option value="1979">1979</option>
                                                            <option value="1980">1980</option>
                                                            <option value="1961">1981</option>
                                                            <option value="1982">1982</option>
                                                            <option value="1983">1983</option>
                                                            <option value="1984">1984</option>
                                                            <option value="1985">1985</option>
                                                            <option value="1986">1986</option>
                                                            <option value="1987">1987</option>
                                                            <option value="1988">1988</option>
                                                            <option value="1989">1989</option>
                                                            <option value="1990">1990</option>
                                                            <option value="1991">1991</option>
                                                            <option value="1992">1992</option>
                                                            <option value="1993">1993</option>
                                                            <option value="1994">1994</option>
                                                            <option value="1995">1995</option>
                                                            <option value="1996">1996</option>
                                                            <option value="1997">1997</option>
                                                            <option value="1998">1998</option>
                                                            <option value="1999">1999</option>
                                                            <option value="2000">2000</option>
                                                            <option value="2001">2001</option>
                                                            <option value="2002">2002</option>
                                                            <option value="2003">2003</option>
                                                            <option value="2004">2004</option>
                                                            <option value="2005">2005</option>
                                                            <option value="2006">2006</option>
                                                            <option value="2007">2007</option>
                                                            <option value="2008">2008</option>
                                                            <option value="2009">2009</option>
                                                            <option value="2010">2010</option>
                                                            <option value="2011">2011</option>
                                                            <option value="2012">2012</option>
                                                            <option value="2013">2013</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2017">2017</option>
                                                            <option value="2018">2018</option>
                                                            <option value="2019">2019</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>


                                                        </select>

                                                    </div>
                                                </fieldset>
                                            </div>



                                            <div class="editfield field_135 field_titles-select-all-that-apply optional-field visibility-public alt field_type_checkbox">
                                                <fieldset class="">


                                                    <legend>
                                                        Titles (select all that apply) </legend>



                                                    <div id="" class="input-options checkbox-options"><label for="field_189_0" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_189_0" value="RDH">RDH</label><label for="field_190_1" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_190_1" value="LDH">LDH</label><label for="field_191_2" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_191_2" value="RDHAP">RDHAP</label><label for="field_192_3" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_192_3" value="EPDH">EPDH</label><label for="field_193_4" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_193_4" value="CRDH">CRDH</label><label for="field_194_5" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_194_5" value="RDHEF">RDHEF</label><label for="field_195_6" class="option-label"><input type="checkbox" name="contact[titles][]" id="field_195_6" value="PHDHP">PHDHP</label>
                                                    </div>



                                                </fieldset>
                                            </div>








                                            <div class="address-container">
                                                <div class="editfield required-field visibility-public field_type_radio">
                                                    <fieldset class="no-label">
                                                        <legend> Address <span class="bp-required-field-label">*</span></legend>
                                                        <div class="input-options radio-button-options"><label for="home-office"><input type="radio" name="address[address_type]" checked id="home-office" value="home-office">Home/Office</label><label for="apo-fpo" class="option-label"><input type="radio" name="address[address_type]" id="apo-fpo" value="apo-fpo">APO/FPO</label></div>
                                                    </fieldset>
                                                </div>
                                                <div class="editfield degree_title addr">
                                                    <legend>Start typing your address...*</legend><input type="text" required class="input-text wfacp-form-control pac-target-input" name="address[address]" id="address-autocomp" placeholder="Start typing your address..." value="" autocomplete="off">
                                                </div>
                                                <div class="editfield degree_title towncity">
                                                    <legend>Town/City*</legend><input type="text" required class="input-text wfacp-form-control pac-target-input" name="address[town_city]" id="address-city" placeholder="House Number and Street Name" value="" autocomplete="off">
                                                </div>
                                                <div class="editfield degree_title apt">
                                                    <legend>Apartment, suite, unit etc.</legend><input type="text" name="address[apt]" value="" placeholder="Apartment, suite, unit etc. (optional)" />
                                                </div>
                                                <div class="editfield degree_title">
                                                    <legend>Zipcode*</legend><input type="text" required id="address-zip" name="address[zipcode]" value="" required placeholder="zipcode*" />
                                                </div>
                                                <div class="editfield degree_title">
                                                    <legend>State*</legend><select name="address[state]" required id="address-rep-state"><?php echo $states_String; ?></select>
                                                </div>
                                            </div>






                                        </div>
                                    <?php
                                        }
                                    ?>
                                <?php endwhile; ?>



                                <div class="professional-info-section">
                                    <h2 class="section-headings">Professional Information</h2>


                                    <div class="field_wrapper liscence">
                                        <div class="header_wrapper_mbt">
                                            <h3>Which state(s) are you licensed to practice?</h3>
                                        </div>
                                        <div class="buddyWrapperList">
                                            <?php echo $states_liscence; ?>
                                        </div>

                                        <div class="addmoreButtonbottom">
                                            <div class="addMoreButton">
                                                <a href="javascript:void(0);" class="add_button font-mont" title="Add field">
                                                    <i class="plus-icon-svg" aria-hidden="true"></i> add another state</a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="editfield field_202 field_how-many-years-have-you-been-a-practicing-hygienist optional-field visibility-public alt field_type_number_minmax">
                                        <fieldset class="">

                                            <legend id="field_202-1">
                                                What year did you first start practicing hygiene? </legend>
                                            <select name="professional[year_practicing]" class="repeater_state_state" id="field_202" placeholder="How many years have you been a practicing hygienist?">
                                                <?php
                                                echo '<option value="0">How many years have you been a practicing hygienist?</option>';
                                                for ($year_practicing_i = 1990; $year_practicing_i  <= date('Y'); $year_practicing_i++) {
                                                    echo '<option value="' . $year_practicing_i . '">' . $year_practicing_i . '</option>';
                                                }
                                                ?>
                                            </select>

                                        </fieldset>
                                    </div>


                                    <div class="editfield field_203 field_do-you-practice-in-office optional-field visibility-public field_type_radio">
                                        <fieldset class="no-label">


                                            <legend>
                                                Do you practice in-office? </legend>



                                            <div id="field_203" class="input-options radio-button-options"><label for="option_373" class="option-label"><input type="radio" name="professional[practice]" id="option_373" value="Part-time">Part-time</label><label for="option_374" class="option-label"><input type="radio" name="professional[practice]" id="option_374" value="Full-time">Full-time</label><label for="option_375" class="option-label"><input type="radio" name="professional[practice]" id="option_375" value="Rarely">Rarely</label><label for="option_376" class="option-label"><input type="radio" name="professional[practice]" id="option_376" value="Not at all">Not at all</label></div>

                                        </fieldset>
                                    </div>


                                    <div class="editfield field_208 field_do-you-attend-professional-conferences optional-field visibility-public alt field_type_radio">
                                        <fieldset class="no-label">


                                            <legend>
                                                Do you attend professional conferences? </legend>



                                            <div id="field_208" class="input-options radio-button-options"><label for="option_353" class="option-label"><input type="radio" name="professional[conference_attend]" id="option_353" value="Twice per year">Twice per year</label><label for="option_354" class="option-label"><input type="radio" name="professional[conference_attend]" id="option_354" value="Yearly">Yearly</label><label for="option_355" class="option-label"><input type="radio" name="professional[conference_attend]" id="option_355" value="Quarterly">Quarterly</label><label for="option_356" class="option-label"><input type="radio" name="professional[conference_attend]" id="option_356" value="Rarely">Rarely</label><label for="option_357" class="option-label"><input type="radio" name="professional[conference_attend]" id="option_357" value="Never">Never</label></div>



                                        </fieldset>
                                    </div>


                                    <div class="editfield field_365 field_please-check-any-of-the-boxes-that-apply-to-you required-field visibility-public field_type_checkbox">
                                        <fieldset class="">


                                            <legend>
                                                Please check any of the boxes that apply to you <span class="bp-required-field-label">(required)</span> </legend>



                                            <div id="field_365" class="input-options checkbox-options"><label for="field_366_0" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_366_0" value="I use an electric toothbrush">I use an electric
                                                    toothbrush</label><label for="field_367_1" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_367_1" value="I grind my teeth">I grind my teeth</label><label for="field_368_2" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_368_2" value="I own custom-fitted whitening trays">I own custom-fitted
                                                    whitening
                                                    trays</label><label for="field_369_3" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_369_3" value="I use an electric water flosser">I use an electric water
                                                    flosser</label><label for="field_370_4" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_370_4" value="I have had braces or Invisalign in my lifetime">I have had braces or
                                                    Invisalign in my lifetime</label><label for="field_371_5" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_371_5" value="I regularly use Chapstick or healing lip balm">I
                                                    regularly use
                                                    Chapstick or healing lip balm</label><label for="field_372_6" class="option-label"><input type="checkbox" name="professional[behaviour][]" id="field_372_6" value="I have sensitive teeth">I have sensitive teeth</label>
                                            </div>


                                        </fieldset>
                                    </div>


                                    <div class="editfield field_339 field_areas-of-interest-select-all-that-apply optional-field visibility-public alt field_type_checkbox">
                                        <fieldset class="">


                                            <legend>
                                                Areas of interest (select all that apply) </legend>



                                            <div id="field_339" class="input-options checkbox-options"><label for="field_358_0" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_358_0" value="CE credits">CE credits</label><label for="field_359_1" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_359_1" value="Brand Ambassador (earn commissions)">Brand ambassador
                                                    (earn
                                                    commissions)</label><label for="field_360_2" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_360_2" value="Published writing">Published writing</label><label for="field_361_3" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_361_3" value="New Career Opportunities">New career
                                                    opportunities</label><label for="field_362_4" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_362_4" value="Professional development">Professional
                                                    development</label><label for="field_363_5" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_363_5" value="Education &amp; Public Speaking Engagements">Education &amp; public
                                                    speaking engagements</label><label for="field_364_6" class="option-label"><input type="checkbox" name="professional[interest][]" id="field_364_6" value="Mentoring future dental professionals">Mentoring future dental
                                                    professionals</label></div>



                                        </fieldset>
                                    </div>
                                    <div class="education-experiecce-wrapper">
                                        <div class="field_wrapper education field_wrapper-education">
                                            <div class="header_wrapper_mbt">
                                                <h3>Education</h3>
                                            </div>
                                            <div class="buddyWrapperList">
                                                <?php echo $degree_string; ?>
                                            </div>

                                            <div class="addmoreButtonbottom">
                                                <div class="addMoreButton">
                                                    <a href="javascript:void(0);" class="add_button font-mont" title="Add field"><i class="plus-icon-svg" aria-hidden="true"></i> add another qualification</a>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="field_wrapper experience">
                                            <div class="header_wrapper_mbt">
                                                <h3>Experience</h3>

                                            </div>
                                            <div class="buddyWrapperList">
                                                <?php echo $exp_string; ?>

                                            </div>
                                            <div class="addmoreButtonbottom">
                                                <div class="addMoreButton">
                                                    <a href="javascript:void(0);" class="add_button font-mont" title="Add field"><i class="plus-icon-svg" aria-hidden="true"></i> add another Experience</a>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="editfield field_4 field_bio optional-field visibility-public alt field_type_wp-biography">
                                            <fieldset class="no-label">


                                                <label for="field_4">Brief introduction</label>
                                                <textarea id="bio-description" name="biref" cols="40" rows="5" placeholder="Bio" class="valid bio-description" aria-invalid="false" maxlength="500"></textarea>
                                                <p class="showCharactor">Characters Remaining <span id="characters-counter">500</span></p>
                                            </fieldset>
                                        </div>
                                        <!-- <div class="editfield field_4 field_bio optional-field visibility-public alt urlLInkDiv">
                                            <legend>Enter Youtube video embed code</legend>
                                            <textarea class="input-text wfacp-form-control pac-target-input" name="rdh_video_url" id="rdh_video_url" placeholder="Please enter the video url or embed code" value="" autocomplete="off" cols="40" rows="5"></textarea>

                                           
                                        </div> -->

                                    </div>



                                </div>




                                <div class="social-info-section">
                                    <h2 class="section-headings">Social media Information</h2>
                                    <div class="editfield  field_linkedin optional-field visibility-public field_type_url">
                                        <fieldset class="">
                                            <legend id="social_linkedin">
                                                Linkedin </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="linkedin.com/in/" type="text" disabled>
                                                <input id="social[linkedin]" name="social[linkedin]" type="text" inputmode="url" value="" placeholder="Linkedin" aria-labelledby="social_linkedin" aria-describedby="social[linkedin]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield  field_instagram optional-field visibility-public alt field_type_url">
                                        <fieldset class="">
                                            <legend id="social_instagram">
                                                Instagram </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="instagram.com/" type="text" disabled>
                                                <input id="social[instagram]" name="social[instagram]" type="text" inputmode="url" value="" placeholder="" aria-labelledby="social_instagram" aria-describedby="social[instagram]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield field_youtube optional-field visibility-public field_type_url">
                                        <fieldset class="">
                                            <legend id="social_youtube">
                                                Youtube </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="youtube.com/" type="text" disabled>
                                                <input id="social[youtube]" name="social[youtube]" type="text" inputmode="url" value="" placeholder="Youtube" aria-labelledby="social_youtube" aria-describedby="social[youtube]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield field_tiktok optional-field visibility-public alt field_type_url">
                                        <fieldset class="">
                                            <legend id="social_tiktok">
                                                Tiktok </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="tiktok.com/@" type="text" disabled>
                                                <input id="social[tiktok]" name="social[tiktok]" type="text" inputmode="url" value="" placeholder="Tiktok" aria-labelledby="social_tiktok" aria-describedby="social[tiktok]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield  field_twitter optional-field visibility-public field_type_url">
                                        <fieldset class="">
                                            <legend id="social_twitter">
                                                Twitter </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="twitter.com/@" type="text" disabled>
                                                <input id="social[twitter]" name="social[twitter]" type="text" inputmode="url" value="" placeholder="" aria-labelledby="social_twitter" aria-describedby="social[twitter]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield  field_facebook optional-field visibility-public alt field_type_url">
                                        <fieldset class="">
                                            <legend id="social_facebook">
                                                Facebook </legend>
                                            <div class="socialFieldsParent">
                                                <input class="socialHandlerText" value="facebook.com/" type="text" disabled>
                                                <input id="social[facebook]" name="social[facebook]" type="text" inputmode="url" value="" placeholder="Facebook" aria-labelledby="social_facebook" aria-describedby="social[facebook]-3" class="valid">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="editfield field_blog optional-field visibility-public field_type_url">
                                        <fieldset class="">
                                            <legend id="social_blog">
                                                Blog </legend>

                                            <input id="social[blog]" name="social[blog]" type="text" inputmode="url" value="" placeholder="Blog" aria-labelledby="social_blog" aria-describedby="social[blog]-3" class="valid">
                                        </fieldset>
                                    </div>
                                    <div class="socialDescriptionIndicagtor">
                                        <p class="description indicator-hint edditedCustom"><span style="color: #000;font-weight: bold;">Note:</span> For all social media accounts simply type
                                            your username. For your blog please type the complete URL.</p>
                                    </div>

                                </div>
                                <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

                            <?php endwhile; ?>

                            <?php bp_nouveau_signup_hook('', 'signup_profile'); ?>
                            <?php //do_action( 'bp_after_registration_confirmed' );
                            ?>

                        </div><!-- #profile-details-section -->

                        <?php bp_nouveau_signup_hook('after', 'signup_profile'); ?>

                    <?php endif; ?>

                    <?php if (bp_get_blog_signup_allowed()) : ?>

                        <?php bp_nouveau_signup_hook('before', 'blog_details'); ?>

                        <?php /***** Blog Creation Details ******/ ?>

                        <div class="register-section blog-details" id="blog-details-section">

                            <h2><?php esc_html_e('Site Details', 'buddypress'); ?></h2>

                            <p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1" <?php checked((int) bp_get_signup_with_blog_value(), 1); ?> />
                                    <?php esc_html_e("Yes, i'd like to create a new site", 'buddypress'); ?></label></p>

                            <div id="blog-details" <?php if ((int) bp_get_signup_with_blog_value()) : ?>class="show" <?php endif; ?>>

                                <?php bp_nouveau_signup_form('blog_details'); ?>

                            </div>

                        </div><!-- #blog-details-section -->

                        <?php bp_nouveau_signup_hook('after', 'blog_details'); ?>

                    <?php endif; ?>

                <?php endif; // request-details signup step 
                ?>

            </div><!-- //.layout-wrap -->

            <?php bp_nouveau_signup_hook('custom', 'steps'); ?>

            <?php if ('request-details' === bp_get_current_signup_step()) : ?>

                <?php if (bp_signup_requires_privacy_policy_acceptance()) : ?>
                    <?php  //bp_nouveau_signup_privacy_policy_acceptance_section(); 
                    ?>
                <?php endif; ?>

                <?php bp_nouveau_submit_button('register'); ?>

            <?php endif; ?>

        </form>
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
                            componentRestrictions: {
                                country: "us"
                            }
                        };
                        var places = new google.maps.places.Autocomplete(document.getElementById(
                            'address-autocomp'), options);

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

                                        }
                                        if (state_long == city) {

                                            var city = results[0].address_components[results[0]
                                                .address_components.length - 7].long_name;
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
                    var classEle = '';
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
            $("#signup-form").bind("keypress", function(e) {
                if (e.keyCode == 13) {
                    return false;
                }
            });
            jQuery(document).ready(function() {
                jQuery('#field_273').val(getUrlParameter('referral_code'));
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
                console.log(jQuery(this).val());
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
                if (this.checked) {
                    jQuery(this).parent().parent().find('.hide-checked select').removeAttr('required');
                    jQuery(this).parent().parent().find('.hide-checked select').val('');

                } else {
                    jQuery(this).parent().parent().find('.hide-checked select').attr('required', "");
                    jQuery(this).parent().parent().find('.hide-checked select').val('');

                }
            })


            $(document).ready(function() {
                var maxCharacters = 500;
                document.getElementById('bio-description').onkeyup = function() {
                    document.getElementById('characters-counter').innerHTML = (maxCharacters - this.value.length);
                };
            });



            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            jQuery(document).on('change', '.mbtenddate', function() {
                endyear_val = jQuery(this).val();
                jQuery(this).parents('.education-experiecce-wrapper').find('.mbtstartdate').find('option').each(function() {
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
                jQuery(this).parents('.education-experiecce-wrapper').find('.mbtenddate').find('option').each(function() {
                    option_val = jQuery(this).val();
                    if (option_val < endyear_val) {
                        jQuery(this).prop("disabled", true);
                    } else {
                        jQuery(this).prop("disabled", false);
                    }
                });

            });
        </script>

        <style>
            .editfield.degree_title {
                /* margin-top: 20px !important; */
                float: left;
                width: 50%;
            }

            .editfield.passing_year {
                /* margin-top: 20px !important; */
                float: right;
                width: 50%;
            }

            .field_referral {
                display: none;
            }

            .required-cls .mbbb {
                color: red;
            }

            .required-cls select,
            .required-cls input {
                border: 1px solid red !important;
            }
        </style>
    </div>

    <?php bp_nouveau_signup_hook('after', 'page'); ?>
<?php } ?>