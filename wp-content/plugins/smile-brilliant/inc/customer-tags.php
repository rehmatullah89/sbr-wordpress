<?php
add_action('user_new_form', 'add_custom_checkbox_to_profile');
add_action('show_user_profile', 'add_custom_checkbox_to_profile');
add_action('edit_user_profile', 'add_custom_checkbox_to_profile');

function add_custom_checkbox_to_profile($user) {
    $user_id = $user->ID;
    $geha_user = get_user_meta($user_id, 'geha_user', true);
    $sleep_assn_user = get_user_meta($user_id, 'sleep_assn', true) === 'yes';
    $hfa_hsa_user = get_user_meta($user_id, 'hfa_hsa', true) === 'yes';



    ?>

    <h3><?php _e('Tags', 'text-domain'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label><?php _e('GEHA', 'text-domain'); ?></label></th>
         
            <td>
                <label for="geha_user_no">
                    <input type="radio" name="geha_user" id="geha_user_no" value="no" <?php checked($geha_user !== 'geha_user_only'); ?>>
                    Normal User
                </label>
                <label for="geha_user">
                    <input type="radio" name="geha_user" id="geha_user" value="yes" <?php checked($geha_user === 'yes'); ?>>
                    Tag the Customer + Order



                </label>
                <label for="geha_user_only">
                    <input type="radio" name="geha_user" id="geha_user_only" value="geha_user_only" <?php checked($geha_user === 'geha_user_only'); ?>>
                    Tag the Customer only
                </label>
            </td>

        </tr>
        <tr>
            <th><label for="user_tag_sleep"><?php _e('Sleep', 'text-domain'); ?></label></th>
            <td>
                <label for="user_tag_sleep">
                    <input type="checkbox" name="sleep_assn" id="user_tag_sleep" value="yes" <?php checked($sleep_assn_user, true); ?>>
                    Sleep
                </label>                
            </td>
        </tr>
        <tr>
            <th><label for="user_tag_hsa_fsa"><?php _e('HSA/FSA', 'text-domain'); ?></label></th>
            <td>
                <label for="user_tag_hsa_fsa">
                    <input type="checkbox" name="hfa_hsa" id="user_tag_hsa_fsa" value="yes" <?php checked($hfa_hsa_user, true); ?>>
                    Hsa/Fsa
                </label>
            </td>
        </tr>
    </table>

    <?php
}

add_action('user_register', 'save_custom_user_field_on_new_user');
add_action('edit_user_profile_update', 'save_custom_user_field_on_new_user');

function save_custom_user_field_on_new_user($user_id) {
    $fields_to_update = array();
    if (isset($_POST['geha_user']) && current_user_can('edit_user', $user_id)) {
        $fields_to_update['geha_user'] = $_POST['geha_user'];
    } else {
        $fields_to_update['geha_user'] = '';
    }

   
    if (isset($_POST['sleep_assn']) && current_user_can('edit_user', $user_id)) {
        $fields_to_update['sleep_assn'] = 'yes';
    } else {
        $fields_to_update['sleep_assn'] = '';
    }

    if (isset($_POST['hfa_hsa']) && current_user_can('edit_user', $user_id)) {
        $fields_to_update['hfa_hsa'] = 'yes';
    } else {
        $fields_to_update['hfa_hsa'] = '';
    }

    foreach ($fields_to_update as $field_key => $field_value) {
        if (current_user_can('edit_user', $user_id)) {
            update_user_meta($user_id, $field_key, $field_value);
        }
    }
}
?>
