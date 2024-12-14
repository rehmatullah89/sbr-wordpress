<?php
/*
Template Name: Customer Oral profile
*/

//get_header();
// echo '<pre>';
//  print_r($_REQUEST);
// echo '</pre>';
if(isset($_REQUEST['version_hash']) && $_REQUEST['version_hash']!='' && isset($_REQUEST['gform_save']) && $_REQUEST['gform_save']=='1'){
    global $wpdb;

// Get the current user ID
$user_id = get_current_user_id();

// Define the form ID (replace with your actual form ID)
$form_id = 5; // Adjust the form ID if necessary

// Search for entries made by the current user for the specified form
$search_criteria = array(
    'field_filters' => array(
        array(
            'key'   => 'created_by', 
            'value' => $user_id
        )
    )
);

// Get the entries for the current user
$sorting = array(
    'key'   => 'date_created',
    'direction' => 'DESC'
); // Sort by latest created entries

$entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, array('page_size' => 1));

if ( ! is_wp_error( $entries ) && ! empty( $entries ) ) {
    // Get the latest entry
    $latest_entry = $entries[0];

    // Get the entry ID and form ID
    $entry_id = $latest_entry['id'];
    $entry_ip = GFFormsModel::get_ip(); // Get the IP address of the entry
    // Query to get the UUID (token) from wp_gf_draft_submissions using the IP address
    $query = $wpdb->prepare(
        "SELECT uuid 
        FROM {$wpdb->prefix}gf_draft_submissions 
        WHERE form_id = %d 
        AND ip = %s 
        ORDER BY date_created DESC 
        LIMIT 1",
        $form_id,
        $entry_ip
    );

    // Execute the query
     $saved_token = $wpdb->get_var($query);

    // If no saved token, use the entry ID as a fallback token
    if ( empty( $saved_token ) ) {
        $saved_token = $entry_id; // Fallback to entry ID if no token found
    }

    // Build the edit link
    $edit_link = site_url('/my-account/my_oral_profile/?gf_token='.$saved_token);

    ?>
<div class="submission-message" style=" padding: 20px; background-color: #f9f9f9; border: 1px solid #e1e1e1; border-radius: 8px; text-align: center;">
    <h2 style="color: #333;">Your Submission is Saved!</h2>
    <p style="font-size: 16px; color: #555;">We've saved your progress. You can return to this form to complete or edit your submission at any time.</p>
    
    <a href="<?php echo esc_attr( $edit_link ); ?>" 
       class="edit-link" 
       style="display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #0073aa; color: #fff; text-decoration: none; font-size: 16px; border-radius: 4px;">
        Edit Your Submission
    </a>
    <button id="view-response-button" style="margin-top: 20px; padding: 12px 24px; background-color: #0073aa; color: #fff; border: none; border-radius: 4px; font-size: 16px;">
  View My Response
</button>
    
    <p style="margin-top: 15px; font-size: 14px; color: #777;">The link is valid for 1 year.</p>
</div>

    <?Php
}
}
if ( isset( $_GET['entry_id'] ) ) {
    $entry_id = intval( $_GET['entry_id'] ); // Sanitize the entry ID
    $entry = GFAPI::get_entry( $entry_id ); // Get the entry data using Gravity Forms API

    if ( $entry ) {
        // Get the form object
        $form = GFAPI::get_form( $entry['form_id'] );
        if(!isset($_REQUEST['readonly'])){
            echo '<h2>Thank You for Your Submission!</h2><br>';
            echo '<h3>Your Submitted Data:</h3>';
        }
        
        // Start the table for better organization
        echo '<table class="gf-submitted-data" style="width: 100%; border-collapse: collapse;">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="padding: 8px; border: 1px solid #ddd; background-color: #f4f4f4;">Field Name</th>';
        echo '<th style="padding: 8px; border: 1px solid #ddd; background-color: #f4f4f4;">Submitted Value</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through the form fields and display submitted data
        foreach ( $form['fields'] as $field ) {
            $field_id = $field->id;
            $value = rgar( $entry, $field_id ); // Retrieve the entry value for this field

            // Skip fields like sections or hidden fields that don't have values
            if ( $field->type == 'section' || $field->displayOnly ) {
                continue;
            }

            // Handle different field types
            if ( $field->type == 'name' && is_array( $field->inputs ) ) {
                // If it's a name field with multiple parts, display each part
                $name_parts = [];
                foreach ( $field->inputs as $input ) {
                    $part_value = rgar( $entry, $input['id'] );
                    if ( ! empty( $part_value ) ) {
                        $name_parts[] = esc_html( $input['label'] . ': ' . $part_value );
                    }
                }
                $value = implode( ', ', $name_parts );
            } elseif ( $field->type == 'checkbox' && is_array( $field->inputs ) ) {
                // If it's a checkbox field, loop through the inputs to get selected values
                $checked_values = [];
                foreach ( $field->inputs as $input ) {
                    $input_value = rgar( $entry, $input['id'] );
                    if ( $input_value ) {
                        $checked_values[] = esc_html( $input['label'] );
                    }
                }
                $value = implode( ', ', $checked_values );
            } elseif ( $field->type == 'checkbox' && !is_array( $field->inputs ) && is_array( $value ) ) {
                // Handle a case where checkbox values are stored directly in $value as an array
                $value = implode( ', ', $value );
            } elseif ( $field->type == 'multiselect' && is_array( $value ) ) {
                // Multi-select fields also return an array
                $value = implode( ', ', $value );
            } elseif ( $field->type == 'list' && is_array( $value ) ) {
                // List fields return serialized data
                $value = implode( ', ', $value );
            } elseif ( $field->type == 'fileupload' ) {
                // File upload fields return the URL of the uploaded file
                $value = '<a href="' . esc_url( $value ) . '" target="_blank">' . basename( $value ) . '</a>';
            } elseif ( $field->type == 'radio' || $field->type == 'select' ) {
                // Radio and select fields return a single value
                $value = esc_html( $value );
            }

            // Display the field label and value if not empty
            if ( ! empty( $value ) ) {
                echo '<tr>';
                echo '<td style="padding: 8px; border: 1px solid #ddd;">' . esc_html( $field->label ) . '</td>';
                echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $value . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';

        // Display the edit link
        echo '<p style="margin-top: 20px;">';
        echo '<a href="/my-account/my_oral_profile?gf_token=' . esc_attr( $_REQUEST['save_token'] ) . '" class="button" style="background-color: #0073aa; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Click to Edit</a>';
        echo '</p>';
    } else {
        echo '<p>There was an error retrieving your submission data.</p>';
    }
} else {
    echo do_shortcode('[gravityform id="5" title="true"]');
}




 ?>

 <script>
$(document).ready(function() {
        $('#view-response-button').click(function() {
            $('.my-oral-profile a').trigger('click');
            var link = $('.my-oral-profile a').attr('href');
            if (link) {
                window.location.href = link;
            }
        });
    });
 </script>


 <style>
    .oral-profile-tab-content button#view-response-button {
    cursor: pointer;
    padding: 10px 24px !important;
    cursor: pointer;
    background-color: transparent !important;
    border: 1px solid #3c98cc !important;
    color: #3c98cc !important;
}
.oral-profile-tab-content .edit-link{
    padding: 10px 24px !important;
    background-color: #3c98cc !important;
}
    .submission-message {
    width: 100%;
}
.submission-message h2 {
    font-size: 24px;
    font-weight: 600;
    color: #000;
    font-family: 'montserrat';
}
.submission-message p {
    font-size: 14px !important;
    color: #757575 !important;
   font-family: 'Open Sans' !important;

}
    .form_saved_message {
        display: none;
    }
    .gform_wrapper {
        padding-top: 10px;
        max-width: 100%;
   width: 100%;
}
 .gform_wrapper label.gform-field-label.gform-field-label--type-sub, .gform_wrapper .gfield_label.gform-field-label  {
    color: #000 !important;
    font-size: 14px;
    line-height: 22px;
    font-weight: 400;
    font-family: 'Open Sans';
}
 
.gform_wrapper .gform-theme--foundation .gfield .ginput_password, .gform-theme--foundation .gfield input, .gform-theme--foundation .gfield select {
    margin-bottom: 0;
    border: 1px solid #d7d7d7 !important;
    width: 100%;
    min-height: 48px !important;
    max-height: 48px !important;
    background-color: #fff;
    border-radius: 3px;
    padding-left: 12px;
    padding-right: 12px;
    line-height: 48px;
    color: #555;
    border-radius: 0;
    font-size: 17px;
    box-shadow: none !important;
}
.gsection_title{
    background: #fff;
    position: relative;
    z-index: 12;
    color:#1a1a1a !important;
    font-weight: 700 !important;
    font-size: 18px !important;
    line-height: 1.3 !important;
    text-transform: initial;
    font-family: 'Open Sans', sans-serif;
    font-weight: 600 !important;
    line-height: 1 !important;
    padding-top: 20px;
}
.gform_wrapper span.gfield_required.gfield_required_text {
    padding-left: 5px;
    font-size: 10px;
}
.gform_wrapper .gform-theme-button.button,.gform_button.button,.gform_previous_button.button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 38px !important;
    background: #3c98cd !important;
    border-color: #3c98cd !important;
    color: #fff !important;
    padding: 0 40px !important;
    max-width: 100%;
    font-size: 14px !important;
    font-weight: 600 !important;
    border: 0;
    outline: 0;
    cursor: pointer;
    border-radius: 3px !important;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.gform_wrapper .gfield_checkbox input {
    min-height: auto !important;
    max-height: auto !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
}
.gform_heading .gform_title {
    display: none !important;
}
.gform-theme--framework .gf_progressbar .percentbar_blue{
    background-color: hsl(202deg 59% 52%) !important;
}
div#field_5_21,div#field_5_22,fieldset#field_5_16 {
    width: 50% !important;
}
.gform-theme--foundation .ginput_complex .ginput_container_date {
    width: 33.33% !important;
}
.gform-theme--foundation .gform_fields{
    row-gap: 20px !important;
}
.gform-theme--foundation .gform-grid-col{
    padding-left: 10px !important;
    padding-right: 15px !important;
}
.gform-theme--foundation .gfield--width-eleven-twelfths {
        grid-column: span 12 !important;
    }
    .gfield--type-checkbox.gfield--type-choice.gfield--input-type-checkbox.gfield--width-full{
        grid-column: span 6 !important;
    }
    .gfield--type-checkbox  legend.gform-field-label{
        font-size: 16px !important;
    font-weight: 600 !important;
    padding-bottom: 10px;
    }
    .gfield-choice-input {
        border-color: #3b99ce !important;
    }
    .gform-theme--framework input[type=checkbox]:where(:not(.gform-theme__disable):not(.gform-theme__disable *):not(.gform-theme__disable-framework):not(.gform-theme__disable-framework *)){
        border-color: #3b99ce !important;
    }
    .gform-theme--framework input[type=checkbox]:where(:not(.gform-theme__disable):not(.gform-theme__disable *):not(.gform-theme__disable-framework):not(.gform-theme__disable-framework *))::before{
        color:  #3b99ce !important;
    }
    @media screen and (max-width:767px){
        div#field_5_21, div#field_5_22, fieldset#field_5_16, input#input_5_5{
            width: 100% !important;
            text-align: left;
        }
        .gfield--type-checkbox.gfield--type-choice.gfield--input-type-checkbox.gfield--width-full {
            grid-column: span 12 !important;
            text-align: left;

}
.gform_wrapper .gform-theme--foundation .gfield .ginput_password, .gform-theme--foundation .gfield input, .gform-theme--foundation .gfield select,.gfield_validation_message,.validation_message {
    text-align: left !important;
}
     
    }
</style>

